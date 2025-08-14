<?php

defined('BASEPATH') or exit('No direct script access allowed');    /*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
require APPPATH . 'libraries/REST_Controller.php';
class Projects extends REST_Controller
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
        $return = array(
            'status' => 'error',
            'message' => 'Please send all required parameters',
            'result' => ''
        );

        $meetingsData = $this->Api_model->get_tasks_with_conditions("meeting");

        if (empty($meetingsData)) {
            $return['message'] = 'No Records found';
        } else {
            $return['status'] = 'success';
            $return['message'] = 'Records found';
            $return['result'] = $meetingsData;
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }





    // post  METHOD (replace your existing postAllMeetings_post method)
    public function postAllMeetings_post()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $return = [
            'status' => 'error',
            'message' => 'Please send all required parameters',
            'result' => ''
        ];

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Extract fields from 
        $leadId = $data['leadId'] ?? null;
        $comment = $data['comment'] ?? null;
        $nextdt = $data['nexpayloadtdt'] ?? null;
        $choice = $data['choice'] ?? null;
        $status = $data['status'] ?? 'active';
        $userId = $data['userId'] ?? null;
        $propertyIds = $data['property_ids'] ?? null;

        // Buyer-related fields
        $uName = $data['uName'] ?? null;
        $preferred_location = $data['preferred_location'] ?? null;
        $budget = $data['budget'] ?? null;
        $mobile = $data['mobile'] ?? null;

        // Validation
        if (empty($leadId) || empty($comment) || empty($nextdt)) {
            $return['message'] = 'leadId, comment, and nextdt are required fields';
            return $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        // --- Step 1: Check if buyer exists ---
        $buyerExists = $this->db->where('id', $leadId)->get('buyers')->num_rows();

        if ($buyerExists == 0) {
            // Insert new buyer
            $buyerData = [
                'id' => $leadId,
                'uName' => $uName,
                'preferred_location' => $preferred_location,
                'budget' => $budget,
                'mobile' => $mobile
            ];
            $this->db->insert('buyers', $buyerData);
        } else {
            // Optional: update buyer details
            $buyerUpdate = [
                'uName' => $uName,
                'preferred_location' => $preferred_location,
                'budget' => $budget,
                'mobile' => $mobile
            ];
            $this->db->where('id', $leadId)->update('buyers', $buyerUpdate);
        }

        // --- Step 2: Insert into leads_comment ---
        $commentData = [
            'leadid' => $leadId,
            'comment' => $comment,
            'nextdt' => $nextdt,
            'choice' => $choice,
            'status' => $status,
            'userid' => $userId,
            'property_ids' => $propertyIds
        ];

        $this->db->insert('leads_comment', $commentData);

        if ($this->db->affected_rows() > 0) {
            $return['status'] = 'success';
            $return['message'] = 'Buyer and comment saved successfully';
            $return['result'] = ['comment_id' => $this->db->insert_id()];
        } else {
            $return['message'] = 'Failed to save comment';
        }

        return $this->response($return, REST_Controller::HTTP_OK);
    }







    // 2.  UPDATE METHOD (add this new method)
    public function updateAllMeetings_put()
    {
        $id = $this->put('id');

        $data = array(
            'comment' => $this->put('comment'),
            'nextdt' => $this->put('nextdt'),
            'choice' => $this->put('choice'),
            'status' => $this->put('status'),
            'property_ids' => $this->put('property_ids')
        );

        // Only set userId if it's valid and exists
        $userId = $this->put('userId');
        if (!empty($userId)) {
            $userExists = $this->db->where('id', $userId)->count_all_results('users');
            if ($userExists > 0) {
                $data['userId'] = $userId;
            }
        }

        $this->db->where('id', $id);
        if ($this->db->update('leads_comment', $data)) {
            $this->response(['status' => 'success', 'message' => 'Meeting updated successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'error', 'message' => 'Failed to update meeting'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }




    // 3. NEW DELETE METHOD (add this new method)

    public function deleteAllMeetings_delete()
    {
        // CORS headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $return = array(
            'status' => 'error',
            'message' => 'Please send all required parameters',
            'result' => ''
        );

        // Get JSON input
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $meetingId = $data['meeting_id'] ?? null;

        if (empty($meetingId)) {
            $return['message'] = 'meeting_id is required';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // Check if meeting exists
        $existingMeeting = $this->Api_model->getRecordByColumn('id', $meetingId, 'meetings');
        if (!$existingMeeting) {
            $return['message'] = 'Meeting not found';
            $this->response($return, REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        // Simple delete (or soft delete if you want)
        $deleted = $this->Api_model->updateTable('id', $meetingId, 'meetings', ['status' => 'deleted']);

        if ($deleted) {
            $return['status'] = 'success';
            $return['message'] = 'Meeting deleted successfully';
            $return['result'] = ['meeting_id' => $meetingId];
        } else {
            $return['message'] = 'Failed to delete meeting';
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }


}