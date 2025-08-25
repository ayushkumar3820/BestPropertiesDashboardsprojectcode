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
    // Set proper JSON headers
    $this->output->set_content_type('application/json');
    header('Content-Type: application/json');
    
    // Initialize response array
    $return = array(
        'status' => 'error', 
        'message' => 'No contacts found', 
        'result' => array()
    );
    
    try {
        // Get query parameters with proper validation
        $property_id = $this->get('property_id');
        $type = $this->get('type');
        $phone = $this->get('phone');
        $limit = $this->get('limit') ? (int)$this->get('limit') : 50;
        $offset = $this->get('offset') ? (int)$this->get('offset') : 0;
        
        // Validate limit (max 100)
        if ($limit > 100) {
            $limit = 100;
        }
        
        // Build the main query
        $this->db->select('id, fname, phone, email, message, subject, property, type, created_at');
        $this->db->from('contact');
        
        // Apply filters if provided
        if (!empty($property_id) && is_numeric($property_id)) {
            $this->db->where('property', (int)$property_id);
        }
        
        if (!empty($type)) {
            $this->db->where('type', $type);
        }
        
        if (!empty($phone)) {
            $this->db->where('phone', $phone);
        }
        
        // Count total records (before limit/offset)
        $total_query = clone $this->db;
        $total_count = $total_query->count_all_results('', FALSE);
        
        // Add pagination and ordering to main query
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'DESC');
        
        // Execute the query
        $query = $this->db->get();
        
        // Check if we have results
        if ($query && $query->num_rows() > 0) {
            $contacts = $query->result_array();
            
            // Format the response data
            $formatted_contacts = [];
            foreach ($contacts as $contact) {
                $formatted_contacts[] = array(
                    'id' => (int)$contact['id'],
                    'name' => $contact['fname'],
                    'phone' => $contact['phone'],
                    'email' => $contact['email'],
                    'message' => $contact['message'],
                    'subject' => $contact['subject'],
                    'property_id' => $contact['property'] ? (int)$contact['property'] : null,
                    'type' => $contact['type'],
                    'created_at' => $contact['created_at'] ?? null
                );
            }
            
            $return = array(
                'status' => 'success',
                'message' => 'Contacts retrieved successfully',
                'result' => array(
                    'contacts' => $formatted_contacts,
                    'pagination' => array(
                        'total_count' => (int)$total_count,
                        'current_page' => (int)($offset / $limit) + 1,
                        'per_page' => (int)$limit,
                        'total_pages' => (int)ceil($total_count / $limit),
                        'has_next' => ($offset + $limit) < $total_count,
                        'has_previous' => $offset > 0
                    )
                )
            );
        } else {
            // No records found
            $return = array(
                'status' => 'success',
                'message' => 'No contacts found',
                'result' => array(
                    'contacts' => [],
                    'pagination' => array(
                        'total_count' => 0,
                        'current_page' => 1,
                        'per_page' => (int)$limit,
                        'total_pages' => 0,
                        'has_next' => false,
                        'has_previous' => false
                    )
                )
            );
        }
        
    } catch (Exception $e) {
        // Handle any database or other errors
        $return = array(
            'status' => 'error',
            'message' => 'An error occurred while fetching contacts: ' . $e->getMessage(),
            'result' => array()
        );
    }
    
    // Ensure we return proper JSON response
    $this->response($return, REST_Controller::HTTP_OK);
}
}