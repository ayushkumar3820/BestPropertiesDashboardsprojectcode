<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';
	
	class Leads extends REST_Controller
	{
	public function __construct()
{
    parent::__construct();
    $this->load->database();
    $this->load->helper('url');
    $this->load->model('Api_model');

    // CORS Headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization");

    // Handle preflight OPTIONS request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0);
    }
	
    $checkToken = $this->checkForToken();
    if(!$checkToken) {
        die();
    }
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
		
// 		Add Leads 

public function addBuyers_post()
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $return = ['status' => 'error', 'message' => 'Please send all required parameters', 'result' => ''];

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!is_array($data)) {
        $return['message'] = 'Invalid JSON format.';
        return $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    $uName   = trim($data['uName'] ?? '');
    $address = trim($data['address'] ?? '');
    $mobile  = trim($data['mobile'] ?? '');

    if ($uName === '' || $address === '' || $mobile === '') {
        $return['message'] = 'Please provide uName, address, and mobile.';
        return $this->response($return, REST_Controller::HTTP_OK);
    }
    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $return['message'] = 'Please provide a valid 10-digit mobile number.';
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    $insertData = [
        'uName'      => $uName,
        'address'    => $address,
        'mobile'     => $mobile,
    ];

    if (!method_exists($this->Api_model, 'add_data_in_tables')) {
        $return['message'] = 'Model method add_data_in_tables not found.';
        return $this->response($return, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }

    $insertId = $this->Api_model->add_data_in_tables('buyers', $insertData); // table first, data second

    if ($insertId) {
        $return['status']  = 'done';
        $return['message'] = 'Buyer added successfully.';
        $return['result']  = ['buyer_id' => $insertId];
    } else {
        $dbError = $this->db->error();
        $return['message'] = 'Failed to add buyer. DB Error: ' . $dbError['message'];
    }

    return $this->response($return, REST_Controller::HTTP_OK);
}

		
		
		

	}