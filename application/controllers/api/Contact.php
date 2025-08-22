<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
require APPPATH . 'libraries/REST_Controller.php';
class Contact extends REST_Controller
{


    public function __construct()
    {

        parent::__construct();
        // $this->load->database();
        $this->load->helper('url');
        $this->load->model('Api_model');
        
        $checkToken = $this->checkForToken();
        if(!$checkToken) { die(); }
    }

    /** add buyers  **/

  public function contact_post()
{
    $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $firstname = removeAllSpecialCharcter($data['firstname'] ?? '');
    $phone = removeAllSpecialCharcter($data['phone'] ?? '');
    $property_id = isset($data['property_id']) ? removeAllSpecialCharcter($data['property_id']) : null;
    $message = $data['subject'] ?? null;
    $subject = $data['selectedValue'] ?? null;
    $email = $data['email'] ?? null;
    $type = $data['type'] ?? 'contact';

    if (!empty($property_id) && (empty($type) || $type === 'contact')) {
        $return['message'] = 'Type is required when property_id is provided".';
        $this->response($return, REST_Controller::HTTP_OK);
        return;
    }

    if (strlen($firstname) < 3) {
            $return['message'] = 'Name not valid.';
        } elseif (!is_numeric($phone) || strlen($phone) != 10) {
            $return['message'] = 'Phone number is not valid';
        } else {
            // Check for duplicates
           if (!empty($property_id)) {
        // (Optional) Check if property exists in the specific table
        if ($type === 'rent') {
            $exists = $this->db->where('id', $property_id)->get('rent')->row();
        } elseif ($type === 'project') {
            $exists = $this->db->where('id', $property_id)->get('Properties_Projects')->row();
        } elseif ($type === 'properties') {
            $exists = $this->db->where('id', $property_id)->get('properties')->row();
        }

        // Proper duplicate check: phone + property
        $this->db->where('phone', $phone);
        $this->db->where('property', $property_id);
        $query = $this->db->get('contact');
    } else {
        $this->db->where('phone', $phone);
        $query = $this->db->get('contact');
    }

        if ($query->num_rows() > 0) {
            $return['message'] = !empty($property_id)
                ? 'This phone number is already associated with this property.'
                : 'Phone number already exists.';
        } else {
            $addInfo = array(
                'fname' => $firstname,
                'phone' => $phone,
                'message' => $message,
                'email' => $email,
                'subject' => $subject,
                'type' => $type
            );

            if (!empty($property_id)) {
                $addInfo['property'] = $property_id;
            }

            $this->Api_model->add_data_in_table($addInfo, 'contact');
            $return['result'] = '';
            $return['status'] = 'done';
            $return['message'] = 'Contact added successfully.';
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}


/** Get contacts **/
public function contact_get() {
    $return = array('status' => 'error', 'message' => 'No data found', 'result' => '');
    
    // Get query parameters
    $property_id = $this->get('property_id');
    $type = $this->get('type');
    $phone = $this->get('phone');
    $limit = $this->get('limit') ? $this->get('limit') : 50;
    $offset = $this->get('offset') ? $this->get('offset') : 0;
    
    // Build query
    $this->db->select('*');
    $this->db->from('contact'); 
    
    // Apply filters if provided
    if (!empty($property_id)) {
        $this->db->where('property', $property_id);
    }
    
    if (!empty($type)) {
        $this->db->where('type', $type);
    }
    
    if (!empty($phone)) {
        $this->db->where('phone', $phone);
    }
    
    // Add pagination
    $this->db->limit($limit, $offset);
    
    // Order by latest first
    $this->db->order_by('id', 'DESC');
    
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        $contacts = $query->result_array();
        
        // Get total count for pagination
        $this->db->from('contact');
        if (!empty($property_id)) {
            $this->db->where('property', $property_id);
        }
        if (!empty($type)) {
            $this->db->where('type', $type);
        }
        if (!empty($phone)) {
            $this->db->where('phone', $phone);
        }
        $total_count = $this->db->count_all_results();
        
        $return['status'] = 'done';
        $return['message'] = 'Contacts retrieved successfully.';
        $return['result'] = array(
            'contacts' => $contacts,
            'total_count' => $total_count,
            'limit' => $limit,
            'offset' => $offset
        );
    } else {
        $return['message'] = 'No contacts found.';
        $return['result'] = array(
            'contacts' => [],
            'total_count' => 0,
            'limit' => $limit,
            'offset' => $offset
        );
    }
    
    $this->response($return, REST_Controller::HTTP_OK);
}
}