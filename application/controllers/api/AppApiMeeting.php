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
         $this->load->model('AdminModel');
         $this->load->helper('headerdata');
        

        $checkToken = $this->checkForToken();
        if (!$checkToken) {
            die();
        }
    }

public function getMeetingsData_post()
{
    $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $token  = removeAllSpecialCharcter($data['token'] ?? '');
    $userId = removeAllSpecialCharcter($data['user_id'] ?? '');

    if ($token == '') {
        $return['message'] = 'Please pass the valid token.';
    } elseif (!$userId || !is_numeric($userId)) {
        $return['message'] = 'Please pass a valid user id.';
    } else {

        $checkToken = $this->Api_model->getRecordByColumn('token', $token, 'adminLogin');

        if ($checkToken) {
            $loginUser = $checkToken[0]; 
            $dbUserId  = $loginUser['id']; 
            $role      = strtolower($loginUser['role'] ?? '');

            if ($dbUserId != $userId) {
                $return['message'] = 'Invalid user id.';
                $this->response($return, REST_Controller::HTTP_UNAUTHORIZED);
                return;
            }

         
            if ($role === 'admin') {
                $meetingsData = $this->Api_model->getAllMeetingsWithProperties();
            } else {
                $meetingsData = $this->Api_model->getAllMeetingsWithProperties($dbUserId); 
            }

            if (!empty($meetingsData)) {
                $return['status']  = 'done';
                $return['message'] = 'Meetings fetched successfully.';
                $return['result']  = $meetingsData;
            } else {
                $return['status']  = 'Fail';
                $return['message'] = 'No records found.';
            }
        } else {
            $return['message'] = 'Invalid token.';
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}


private function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

public function addMeeting_post()
{
    $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $token   = removeAllSpecialCharcter($data['token'] ?? '');
    $userId  = removeAllSpecialCharcter($data['user_id'] ?? '');
    $leadId  = removeAllSpecialCharcter($data['lead_id'] ?? '');

    if ($token == '') {
        $return['message'] = 'Please pass the valid token.';
    } elseif (!$userId || !is_numeric($userId)) {
        $return['message'] = 'Please pass a valid user id.';
    } elseif (!$leadId || !is_numeric($leadId)) {
        $return['message'] = 'Please pass a valid lead id.';
    } else {
      
        $checkToken = $this->Api_model->getRecordByColumn('token', $token, 'adminLogin');

        if ($checkToken) {
            $loginUser = $checkToken[0];

            if (strtolower($loginUser['role']) === 'admin' && $loginUser['id'] == $userId) {
           
                $propertyData = $data['property_id'] ?? [];
                $propertyJson = json_encode($propertyData);
                
                if (!isset($data['meeting_date']) || !$this->validate_meeting_time_api($data['meeting_date'])) {
    $return['message'] = 'Invalid meeting time. Please select between 7 AM to 7 PM.';
    $this->response($return, REST_Controller::HTTP_OK);
    return;
}
$this->db->where('lead_id', $leadId);
$this->db->order_by('id', 'DESC');
$this->db->limit(1);
$lastMeeting = $this->db->get('meetings')->row();

if($lastMeeting && $lastMeeting->status != 'Complete') {
    $return['message'] = 'You cannot add a new meeting until the previous meeting is complete.';
    $this->response($return, REST_Controller::HTTP_OK);
    return; // exit function
}

   $buyer = $this->db->where('id', $leadId)->get('buyers')->row();
                if (!$buyer || empty($buyer->preferred_location) || empty($buyer->budget) || empty($buyer->leads_type)) {
                    $return['message'] = 'Please fill Preferred Location, Budget, and Lead Type in buyer details before adding a meeting.';
                    $this->response($return, REST_Controller::HTTP_OK);
                    return;
                }
                $allowedPurposes = meetingPurpose();

              if (!in_array($data['purpose'], $allowedPurposes)) {
                  $return['message'] = 'Invalid purpose selected.';
                  $this->response($return, REST_Controller::HTTP_OK);
                  return;
              }

                $insertData = array(
                    'user_id'      => $userId,
                    'lead_id'      => $leadId,
                    'meeting_date' => $data['meeting_date'] ?? '',
                    'status'       => $data['status'] ?? '',
                    'purpose'      => $data['purpose'] ?? '',
                    'comment'      => $data['comment'] ?? '',
                    'next_step'    => $data['next_step'] ?? '',
                    'location'     => $data['location'] ?? '',
                    'property_id'  => $propertyJson,
                    'outcome'      => $data['outcome'] ?? '',
                    'offer'        => $data['offer'] ?? ''
                );

                $result = $this->Api_model->addDataInTable($insertData, 'meetings');

                if ($result) {
                    $return['status']  = 'done';
                    $return['message'] = 'Meeting added successfully.';
                } else {
                    $return['message'] = 'Failed to add meeting.';
                }
            } else {
                $return['message'] = 'Invalid role or user id.';
            }
        } else {
            $return['message'] = 'Token expired or invalid.';
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}

public function editMeeting_post()
{
    $return = array('status' => 'error', 'message' => 'Something went wrong.', 'result' => '');

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $token   = removeAllSpecialCharcter($data['token'] ?? '');
    $userId  = removeAllSpecialCharcter($data['user_id'] ?? '');
    $id      = removeAllSpecialCharcter($data['meeting_id'] ?? ''); // DB id

    if ($token == '' || !$userId || !$id) {
        $return['message'] = 'Missing required parameters.';
    } else {
        $checkToken = $this->Api_model->getRecordByColumn('token', $token, 'adminLogin');

        if ($checkToken) {
            $loginUser = $checkToken[0];

            if (strtolower($loginUser['role']) === 'admin' && $loginUser['id'] == $userId) {

                // ✅ property_id handling same as add
                $propertyData = $data['property_id'] ?? [];
                $propertyJson = json_encode($propertyData);
                
                if (!isset($data['meeting_date']) || !$this->validate_meeting_time_api($data['meeting_date'])) {
    $return['message'] = 'Invalid meeting time. Please select between 7 AM to 7 PM.';
    $this->response($return, REST_Controller::HTTP_OK);
    return;
}  

$allowedPurposes = meetingPurpose();

if (isset($data['purpose']) && $data['purpose'] !== '') {
    if (!in_array($data['purpose'], $allowedPurposes)) {
        $return['message'] = 'Invalid purpose selected.';
        $this->response($return, REST_Controller::HTTP_OK);
        return;
    }
}

             

                $updateData = array(
                    'meeting_date' => $data['meeting_date'] ?? '',
                    'status'       => $data['status'] ?? '',
                    'outcome'      => $data['outcome'] ?? '',
                    'offer'        => $data['offer'] ?? '',
                    'purpose'      => $data['purpose'] ?? '',
                     'comment'      => $data['comment'] ?? '',
                    'location'     => $data['location'] ?? '',
                    'next_step'    => $data['next_step'] ?? '',
                    'property_id'  => $propertyJson
                );

                $this->db->where('id', $id);
                $this->db->update('meetings', $updateData);

                if ($this->db->affected_rows() > 0) {
                    $return['status']  = 'done';
                    $return['message'] = 'Meeting updated successfully.';
                } else {
                    $return['message'] = 'No changes or meeting not found.';
                }
            } else {
                $return['message'] = 'Invalid role or user id.';
            }
        } else {
            $return['message'] = 'Token expired or invalid.';
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}

private function validate_meeting_time_api($meeting_date) {
    if (empty($meeting_date)) return false;

    $timestamp = strtotime($meeting_date);
    $hour = (int) date('H', $timestamp); // 24-hour format

    return ($hour >= 7 && $hour <= 19); // 7 AM – 7 PM
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

public function getMessageLData_post()
{
    $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $token  = removeAllSpecialCharcter($data['token'] ?? '');
    $userId = removeAllSpecialCharcter($data['user_id'] ?? '');
    $leadId = removeAllSpecialCharcter($data['leadId'] ?? '');

    if ($token == '') {
        $return['message'] = 'Please pass the valid token.';
    } elseif (!$userId || !is_numeric($userId)) {
        $return['message'] = 'Please pass a valid user id.';
    } elseif (!$leadId || !is_numeric($leadId)) {
        $return['message'] = 'Please pass a valid lead id.';
    } else {

        $checkToken = $this->Api_model->getRecordByColumn('token', $token, 'adminLogin');

        if ($checkToken) {
            $loginUser = $checkToken[0]; 
            $dbUserId  = $loginUser['id']; 
            $role      = strtolower($loginUser['role'] ?? '');

            if ($dbUserId != $userId) {
                $return['message'] = 'Invalid user id.';
                $this->response($return, REST_Controller::HTTP_UNAUTHORIZED);
                return;
            }

            
            $commentsData = $this->Api_model->getCommentsByLeadId($leadId);

            if (!empty($commentsData)) {
                $return['status']  = 'done';
                $return['message'] = 'Comments fetched successfully.';
                $return['result']  = $commentsData;
            } else {
                $return['status']  = 'Fail';
                $return['message'] = 'No records found.';
            }
        } else {
            $return['message'] = 'Invalid token.';
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}
public function addMessageLData_post()
{
    $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $token   = removeAllSpecialCharcter($data['token'] ?? '');
    $userId  = removeAllSpecialCharcter($data['user_id'] ?? '');
    $leadId  = removeAllSpecialCharcter($data['leadId'] ?? '');
    $comment = trim($data['comment'] ?? '');
    $nextdt  = trim($data['nextdt'] ?? '');
    $choice  = trim($data['choice'] ?? '');

    if ($token == '') {
        $return['message'] = 'Please pass the valid token.';
    } elseif (!$userId || !is_numeric($userId)) {
        $return['message'] = 'Please pass a valid user id.';
    } elseif (!$leadId || !is_numeric($leadId)) {
        $return['message'] = 'Please pass a valid lead id.';
    } elseif ($comment == '') {
        $return['message'] = 'Please enter comment.';
    } elseif (!in_array($choice, ['Followup', 'Message'])) {
        $return['message'] = 'Please select a valid choice (Followup or Message).';
    } else {

        $checkToken = $this->Api_model->getRecordByColumn('token', $token, 'adminLogin');

        if ($checkToken) {
            $loginUser = $checkToken[0];
            $dbUserId  = $loginUser['id'];
            $role      = strtolower($loginUser['role'] ?? '');

            if ($dbUserId != $userId) {
                $return['message'] = 'Invalid user id.';
                $this->response($return, REST_Controller::HTTP_UNAUTHORIZED);
                return;
            }

           
            $insertData = array(
                'leadId' => $leadId,
                'comment' => $comment,
                'nextdt' => $nextdt,
                'choice' => $choice,
                'userId' => $userId
            );

            $insertId = $this->Api_model->add_data_in_table($insertData, 'leads_comment');

            if ($insertId) {
                $return['status']  = 'done';
                $return['message'] = 'Comment added successfully.';
               
            } else {
                $return['message'] = 'Failed to add comment.';
            }
        } else {
            $return['message'] = 'Invalid token.';
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}

public function getMatchingProperties_post()
{
    $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $token  = removeAllSpecialCharcter($data['token'] ?? '');
    $userId = removeAllSpecialCharcter($data['user_id'] ?? '');
    $leadId = removeAllSpecialCharcter($data['leadId'] ?? '');
    $propertyType = trim($data['propertyType'] ?? '');
    $maxBudget    = trim($data['max_budget'] ?? '');
    $deal         = trim($data['deal'] ?? '');

    if ($token == '') {
        $return['message'] = 'Please pass the valid token.';
    } elseif (!$userId || !is_numeric($userId)) {
        $return['message'] = 'Please pass a valid user id.';
    } elseif (!$leadId || !is_numeric($leadId)) {
        $return['message'] = 'Please pass a valid lead id.';
    } else {
        // Token validation
        $checkToken = $this->Api_model->getRecordByColumn('token', $token, 'adminLogin');

        if ($checkToken) {
            $loginUser = $checkToken[0];
            $dbUserId  = $loginUser['id'];

            if ($dbUserId != $userId) {
                $return['message'] = 'Invalid user id.';
                $this->response($return, REST_Controller::HTTP_UNAUTHORIZED);
                return;
            }

            // ✅ Check if lead exists in buyers table
            $buyer = $this->db->get_where('buyers', ['id' => $leadId])->row();
            if (!$buyer) {
                $return['status'] = 'fail';
                $return['message'] = 'Invalid lead id.';
                $this->response($return, REST_Controller::HTTP_OK);
                return;
            }

            // Prepare lead object
            $lead = new stdClass();
            $lead->leadId = $leadId;
            $lead->propertyType = $propertyType;
            $lead->max_budget = is_numeric($maxBudget) ? (float)$maxBudget : 0;
            $lead->deal = $deal;

            // Fetch matching properties
            $properties = $this->Api_model->getMatchingProperties($lead);

            if (!empty($properties)) {
                $return['status'] = 'done';
                $return['message'] = 'Properties fetched successfully.';
                $return['result'] = $properties;
            } else {
                $return['status'] = 'fail';
                $return['message'] = 'No properties found.';
            }

        } else {
            $return['message'] = 'Invalid token.';
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}



}