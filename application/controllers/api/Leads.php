<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Leads extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Api_model');

        $checkToken = $this->checkForToken();
        if (!$checkToken) {
            die();
        }
    }

    public function index_post()
    {
        echo 'index function';
    }

    public function getLeadsData_post()
    {
        $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $token = removeAllSpecialCharcter($data['token'] ?? '');
        $userId = removeAllSpecialCharcter($data['user_id'] ?? '');

        if ($token == '') {
            $return['message'] = 'Please pass the valid token.';
        } elseif (!$userId || !is_numeric($userId)) {
            $return['message'] = 'Please pass a valid user id.';
        } else {
            $checkToken = $this->Api_model->getRecordByColumn('token', $token, 'adminLogin');

            if ($checkToken) {
                $assignedLeads = $this->Api_model->getRecordByColumn('userid', $userId, 'assigned_leads', 'leadid');

                if ($assignedLeads) {
                    $leadIds = array_column($assignedLeads, 'leadid');
                    $leadsData = $this->Api_model->getRecordsByWhereIn('id', $leadIds, 'buyers');

                    if ($leadsData) {
                        $return['status'] = 'done';
                        $return['message'] = 'Done.';
                        $return['result'] = $leadsData;
                    } else {
                        $return['status'] = 'Fail';
                        $return['message'] = 'No records found.';
                        $return['result'] = '';
                    }
                } else {
                    $return['message'] = 'No leads assigned to this user.';
                }
            } else {
                $return['message'] = 'This token has been expired.';
            }
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function addLeadsData_post()
    {
        $return = ['status' => 'error', 'message' => '', 'result' => ''];
        $json   = file_get_contents('php://input');
        $data   = json_decode($json, true);
    
        if (!is_array($data)) {
            return $this->response(['status' => 'error', 'message' => 'Invalid JSON format.'], REST_Controller::HTTP_OK);
        }
    
        // Standardize keys to lowercase
        $data = array_change_key_case($data, CASE_LOWER);
    
        // Trim all string inputs safely
        $data = array_map(function ($v) {
            return is_string($v) ? trim($v) : $v;
        }, $data);
    
        // Required fields (lowercase now)
        $required = [
            'uname', 'address', 'mobile', 'preferred_location', 'propertytype',
            'propertytype_sub', 'budget', 'max_budget', 'payment_method',
            'project_builder', 'status', 'source', 'priority', 'timeline',
            'leads_type', 'requirement', 'description', 'usertype',
            'profession', 'city', 'email'
        ];
    
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                return $this->response(
                    ['status' => 'error', 'message' => "Please provide {$field}."],
                    REST_Controller::HTTP_OK
                );
            }
        }
    
        // Mobile number validation
        if (!preg_match('/^[0-9]{10}$/', $data['mobile'])) {
            return $this->response(
                ['status' => 'error', 'message' => 'Please provide a valid 10-digit mobile number.'],
                REST_Controller::HTTP_OK
            );
        }
    
        // Email validation
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->response(
                ['status' => 'error', 'message' => 'Please provide a valid email address.'],
                REST_Controller::HTTP_OK
            );
        }
    
        // Insert into DB
        $insertId = $this->Api_model->add_data_in_table($data, 'buyers');
    
        if ($insertId) {
            $return = [
                'status'  => 'done',
                'message' => 'Buyer added successfully.',
                'result'  => $insertId
            ];
        }
    
        return $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function deleteLeadsData_post() 
    {
    $return = array(
        'status' => 'error',
        'message' => 'Please send required parameter (id)',
        'result' => ''
    );

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $id = $data['id'] ?? null;

    if (empty($id)) {
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // Check if record exists
    $lead = $this->Api_model->add_data_in_table('buyers', ['id' => $id])->row();

    if (!$lead) {
        $return['message'] = 'Lead not found';
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // Delete record
    $this->db->where('id', $id);
    $this->db->delete('leads');

    $return['status'] = 'success';
    $return['message'] = 'Lead deleted successfully';
    $return['result']  = ['id' => $id];

    return $this->response($return, REST_Controller::HTTP_OK);
}







}