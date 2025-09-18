<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper('url');
        $this->load->model('AdminModel');

        if (!$this->session->userdata('adminLogged')) {
            redirect(base_url('site-admin'));
        }
    }

    // Show chat list
    public function index() {
        $data['title'] = 'Chat';
        $data['chat'] = $this->AdminModel->getDataFromTable('chat');
       
        $data['mainContent'] = 'siteAdmin/chat'; // 
        $this->load->view('includes/admin/template', $data);
    }

    // Add chat
    public function chatadd() {
        $data['title'] = 'Add Chat';

        if ($this->input->post('save')) {
            $this->form_validation->set_rules('property_id', 'Property', 'trim|required|integer');
            $this->form_validation->set_rules('user_id', 'User', 'trim|required|integer');
            $this->form_validation->set_rules('message', 'Message', 'trim|required|min_length[1]|max_length[1000]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            if ($this->form_validation->run() != FALSE) {
                $insertData = array(
                    'property_id' => $this->input->post('property_id'),
                    'user_id'     => $this->input->post('user_id'),
                    'message'     => $this->input->post('message'),
                    'status'      => 0, // default unread
                    'r_date'      => date('Y-m-d H:i:s')
                );

                $result = $this->AdminModel->addDataInTable($insertData, 'chat');
                if ($result) {
                    $this->session->set_flashdata('message', 'Chat message added successfully.');
                    redirect(base_url('admin/chat')); // 
                }
            }
        }

        $data['mainContent'] = 'siteAdmin/chatAdd';
        $this->load->view('includes/admin/template', $data);
    }

    // Edit chat
    public function chatEdit($id = null) {
        if (!$id) {
            redirect(base_url('admin/chat'));
        }

        $data['title'] = 'Edit Chat';
        $data['chat'] = $this->AdminModel->getDataFromTableByField($id, 'chat', 'id');

        if ($this->input->post('save')) {
            $this->form_validation->set_rules('property_id', 'Property', 'trim|required|integer');
            $this->form_validation->set_rules('user_id', 'User', 'trim|required|integer');
            $this->form_validation->set_rules('message', 'Message', 'trim|required|min_length[1]|max_length[1000]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            if ($this->form_validation->run() != FALSE) {
                $updateData = array(
                    'property_id' => $this->input->post('property_id'),
                    'user_id'     => $this->input->post('user_id'),
                    'message'     => $this->input->post('message'),
                    'status'      => $this->input->post('status'),
                    'r_date'      => date('Y-m-d H:i:s')
                );

                $this->AdminModel->updateTable($id, 'id', 'chat', $updateData);
                $this->session->set_flashdata('message', 'Chat message updated successfully.');
                redirect(base_url('admin/chat/edit/' . $id));
            }
        }

        $data['mainContent'] = 'siteAdmin/chatEdit';
        $this->load->view('includes/admin/template', $data);
    }

    // Delete chat
    public function chatDelete($id = null) {
        if ($id) {
            $this->AdminModel->deleteRow($id, 'chat', 'id');
        }
        redirect(base_url('admin/chat'));
    }
}