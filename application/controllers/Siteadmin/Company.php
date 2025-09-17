<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation'); 
        $this->load->helper('url'); 
        $this->load->library('session'); 
        $this->load->model('AdminModel'); 

        $sessionLogin = $this->session->userdata('adminLogged');
        if(!($sessionLogin)) { redirect(base_url('site-admin')); }  
    }

    // List companies
    public function index() {
        $data['title'] = 'Company Management'; 
        $data['company'] = $this->AdminModel->getDataFromTable('company_managment');
        $data['mainContent'] = 'siteAdmin/company'; 
        $this->load->view('includes/admin/template', $data);
    }

    // Add company
    public function add() {
        $data['title'] = 'Add Company'; 
        if($this->input->post('save')) {
            $this->form_validation->set_rules('company_name', 'Company Name','trim|required|min_length[2]|max_length[250]');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            
            if ($this->form_validation->run() != FALSE) { 
                $insertData = array(
                    'company_name'=> $this->input->post('company_name'),
                );
                $result = $this->AdminModel->addDataInTable($insertData,'company_managment');
                if($result == TRUE){
                    $this->session->set_flashdata('message','Company added successfully.');
                    redirect(base_url('admin/company'));
                } 
            }
        }

        $data['mainContent'] = 'siteAdmin/companyAdd'; 
        $this->load->view('includes/admin/template', $data);
    }

    // Edit company
    public function edit($id = null) {
        $data['title'] = 'Edit Company'; 
        $data['company'] = $this->AdminModel->getDataFromTableByField($id,'company_managment','id');
		
        if($this->input->post('save')) {
            $this->form_validation->set_rules('company_name', 'company_name','trim|required|min_length[2]|max_length[250]');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            
            if ($this->form_validation->run() != FALSE) { 
                $updateData = array(
                    'company_name'=> $this->input->post('company_name'),
                );
                $this->AdminModel->updateTable($id,'id','company_managment',$updateData);
                $this->session->set_flashdata('message','Company updated successfully.');
                redirect(base_url('admin/company/'));
            }
        }

        $data['mainContent'] = 'siteAdmin/companyEdit'; 
        $this->load->view('includes/admin/template', $data);
    }

    // Delete company
    public function delete($id = null){
        $this->AdminModel->deleteRow($id,'company_managment','id');
        redirect(base_url('admin/company'));
    }
}