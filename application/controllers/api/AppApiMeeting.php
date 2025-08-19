<?php

defined('BASEPATH') or exit('No direct script access allowed');    /*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
require APPPATH . 'libraries/REST_Controller.php';
class AppApiMeeting extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Api_model');

        $checkToken = $this->checkForToken();
        if (!$checkToken) {
            die();
        }
    }

 

public function getAllMeetings_get()
{
    // Default response
    $response = [
        'status'  => 'error',
        'message' => 'User ID is required',
        'result'  => []
    ];

    // Get userId and role from query params
    $userId = $this->input->get('userId'); 
    $role   = $this->input->get('role');  

    // If no userId provided → stop
    if (empty($userId)) {
        return $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    // Get all meetings from model
    $allMeetings = $this->Api_model->get_tasks_with_conditions("meeting");

    // Filter meetings
    $validMeetings = [];
    foreach ($allMeetings as $meeting) {
        // Skip if status is completed or cancel
        if (in_array(strtolower($meeting['status']), ['completed', 'cancel'])) {
            continue;
        }

        // Skip if not matching this user
        if ($meeting['userId'] != $userId) {
            continue;
        }

        // Skip if role filter is applied and doesn't match
        if (!empty($role) && isset($meeting['role']) && $meeting['role'] != $role) {
            continue;
        }

        // Add valid meeting
        $validMeetings[] = $meeting;
    }

    // Prepare final response
    if (!empty($validMeetings)) {
        $response['status']  = 'success';
        $response['message'] = 'Records found';
        $response['result']  = $validMeetings;
    } else {
        $response['message'] = 'No Records found';
    }

    // Send JSON response
    return $this->response($response, REST_Controller::HTTP_OK);
}

    // POST METHOD

public function postAllMeetings_post()
{
    // Set CORS headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    
    // Handle OPTIONS request
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    // Default response
    $return = [
        'status' => 'error',
        'message' => 'Please send all required parameters',
        'result' => ''
    ];
    
    // Get and decode JSON input
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    // Check if JSON is valid
    if (!$data) {
        $return['message'] = 'Invalid JSON data';
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        return;
    }
    
    // Extract required fields
    $leadId = $data['leadId'] ?? null;
    $comment = $data['comment'] ?? null;
    $nextdt = $data['nextdt'] ?? null;
    $choice = $data['choice'] ?? null;
    $status = $data['status'] ?? 'active';
    $userId = $data['userId'] ?? null;
    $propertyIds = $data['property_ids'] ?? null;
    
    // Validate required fields
    if (empty($leadId) || empty($comment) || empty($nextdt) || empty($userId)) {
        $return['message'] = 'leadId, comment, nextdt, and userId are required';
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        return;
    }
    
    // Prepare data for database insert
    $insertData = [
        'leadid' => $leadId,
        'comment' => $comment,
        'nextdt' => $nextdt,
        'choice' => $choice,
        'status' => $status,
       
        'userId'       => $userId,  
        'property_ids' => $propertyIds
    ];
    
    // Insert data into leads_comment table
    $result = $this->db->insert('leads_comment', $insertData);
    
    if ($result) {
        // Success response
        $return['status'] = 'success';
        $return['message'] = 'Meeting comment saved successfully';
        $return['result'] = [
            'comment_id' => $this->db->insert_id(),
            'leadId' => $leadId
        ];
        $this->response($return, REST_Controller::HTTP_OK);
    } else {
        // Error response
        $return['message'] = 'Failed to save comment to database';
        $this->response($return, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
}



public function deleteMeeting_delete()
{
    // Get ID from query param
    $id = $this->input->get('id');

    // Default response
    $response = [
        'status'  => 'error',
        'message' => 'Meeting ID is required',
        'result'  => []
    ];

    // If no ID provided
    if (empty($id)) {
        return $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    // Try deleting from DB
    $this->db->where('id', $id);
    $deleted = $this->db->delete('leads_comment');

    if ($deleted) {
        $response['status']  = 'success';
        $response['message'] = 'Meeting deleted successfully';
    } else {
        $response['message'] = 'Failed to delete meeting (maybe ID not found)';
    }

    return $this->response($response, REST_Controller::HTTP_OK);
}


    
}