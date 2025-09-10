<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meetings extends CI_Controller {
 
 public function __construct()
 {
    parent::__construct();
   
    $this->load->library('form_validation'); 
    $this->load->helper('url'); 
    $this->load->library('session'); 
    $this->load->model('AdminModel'); 
    
 	$sessionLogin = $this->session->userdata('adminLogged');
	if(!($sessionLogin)) { redirect(base_url('site-admin'));   }
    }
 public function index() {
    $data['title'] = 'Meetings';
    
    $meeting_id = $this->uri->segment('4');
    $user_id = $this->session->userdata('id');
    
    
    
    $meeting_id = $this->uri->segment('4');
     $this->db->where('user_id', $user_id);
    $data['meeting'] = $this->AdminModel->getDataFromTable('meetings','id,lead_id,purpose, location,meeting_date,status');
   
    
	$data['mainContent'] = 'siteAdmin/meetings'; 
    $this->load->view('includes/admin/template', $data);
 }

 public function addMeeting() {
    $data['title'] = 'Add Meeting'; 
    
       $lead_id = $this->uri->segment('4');
    $user_id = $this->session->userdata('id');
  
    if($this->input->post('save')) {
         $this->db->where('lead_id', $lead_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $lastMeeting = $this->db->get('meetings')->row();

        if($lastMeeting && $lastMeeting->status != 'Complete') {
            $this->session->set_flashdata('message', 'You cannot add a new meeting until the previous meeting is complete.');
            redirect(base_url('admin/meeting/add/'.$lead_id));
            return; 
        }
            // ✅ Check buyers table required fields
        $buyer = $this->db->where('id', $lead_id)->get('buyers')->row();
        if (!$buyer || empty($buyer->preferred_location) || empty($buyer->budget) || empty($buyer->leads_type)) {
            $this->session->set_flashdata('message', 'Please fill Preferred Location, Budget, and Lead Type in Leads details before adding a meeting.');
            redirect(base_url('admin/meeting/add/'.$lead_id));
            return;
        }
        $this->form_validation->set_rules('meeting_date', 'Meeting Date', 'required|callback_validate_meeting_time');
       

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
       
        if ($this->form_validation->run() != FALSE) { 
            $propertyData = $this->input->post('property_id');
            $propertyJson = json_encode($propertyData);

            $addData = array(
                'user_id'      => $this->session->userdata('id'),
                'lead_id'      => $this->uri->segment('4'),
                'meeting_date' => $this->input->post('meeting_date'),
                'status'       => 'Schedule',
                'purpose'      => $this->input->post('purpose'),
                'comment'      => $this->input->post('comment'),
                //'next_step'    => $this->input->post('next_step'),
                'location'     => $this->input->post('location'),
                'property_id'  => $propertyJson
                //'outcome'      => $this->input->post('outcome'),
                //'offer'        => $this->input->post('offer')
            );
           

            $result = $this->AdminModel->addDataInTable($addData, 'meetings');
            if($result){
                $this->session->set_flashdata('message','Meeting added successfully.');
                redirect(base_url('admin/meeting/add/').$this->uri->segment('4'));
            } 
        }
    }

    $data['mainContent'] = 'siteAdmin/meetingAdd'; 
    $this->load->view('includes/admin/template', $data);
}

/**
 * Custom validation for meeting time (7 AM - 7 PM only)
 */
public function validate_meeting_time($meeting_date)
{
    if (empty($meeting_date)) {
        return FALSE;
    }

    $timestamp = strtotime($meeting_date);
    $hour = (int)date('H', $timestamp);

    if ($hour >= 7 && $hour <= 19) {
        return TRUE; // valid time
    } else {
        $this->form_validation->set_message(
            'validate_meeting_time',
            'Invalid meeting time. Please select between 7 AM to 7 PM.'
        );
        return FALSE;
    }
}


public function editMeeting() {
    $data['title'] = 'Meeting Edit'; 

    $id = $this->uri->segment('4');

    if($this->input->post('save')) {
        $this->form_validation->set_rules('meeting_date', 'Meeting Date', 'required|callback_validate_meeting_time');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() != FALSE) {
            $propertyData = $this->input->post('property_id');
            $propertyJson = json_encode($propertyData);

            $updateData = array(
                'meeting_date' => $this->input->post('meeting_date'),
                'status'       => $this->input->post('status'),
                'purpose'      => $this->input->post('purpose'),
                'comment'      => $this->input->post('comment'),
                'next_step'    => $this->input->post('next_step'),
                'location'     => $this->input->post('location'),
                'outcome'      => $this->input->post('outcome'),
                'property_id'  => $propertyJson,
                'offer'        => $this->input->post('offer')
            );

            $result = $this->AdminModel->updateTable($id, 'id', 'meetings', $updateData);
            if($result){
                $this->session->set_flashdata('message','Meeting updated successfully.');
                redirect(base_url('admin/meeting/edit').'/'.$id);
            } 
        }
    }

    // Fetch existing meeting data
    $data['meeting'] = $this->AdminModel
                          ->getDataFromTableByField($id,'meetings','id')[0];

    // Property JSON decode
    $data['meeting']->property_data = [];
    if(!empty($data['meeting']->property_id)){
        $propertyArr = json_decode($data['meeting']->property_id, true);
        $enhancedData = [];
        foreach($propertyArr as $row){
            $propertyId = $row['id'];  
            $property = $this->db->select('id, name, person, phone, person_address')
                                 ->where('id', $propertyId) 
                                 ->get('properties')
                                 ->row_array();
            if($property){
                $property['key'] = $row['key']; 
                $enhancedData[] = $property;
            }
        }
        $data['meeting']->property_data = $enhancedData;
    }

    $data['mainContent'] = 'siteAdmin/meetingEdit'; 
    $this->load->view('includes/admin/template', $data);
}
 
public function updateAddress()
{
    $id = $this->input->post('id');
    $address = $this->input->post('person_address');

    if (!empty($id) && !empty($address)) {
        $this->db->where('id', $id);
        $this->db->update('properties', ['person_address' => $address]);

        if ($this->db->affected_rows() > 0) {
            echo "success";
        } else {
            echo "fail";
        }
    } else {
        echo "invalid";
    }
    exit;
}


 
 public function deleteMeeting(){
     
    $id = $this->uri->segment('4');
   
       $result =  $this->AdminModel->deleteRow($id,'meetings','id');
         if($result){
         $this->session->set_flashdata('message','Meetings delete successfully.');
         }
         else{
         $this->session->set_flashdata('message','Meetings not delete please try again.');
         }
     redirect(base_url('admin/leads/meetings').'/'.$id);
 }

}
?>