<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class TestAPI extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Api_model');

        $checkToken = $this->checkForToken();
        if (!$checkToken) {
            $this->response([
                'status' => 'error',
                'message' => 'Invalid or missing token'
            ], REST_Controller::HTTP_UNAUTHORIZED);
            exit;
        }
    }

    // POST request to /TestAPI
    public function index_post()
    {
        echo 'Hello World';
    }

    // POST request to /TestAPI/addUserLeadDataMain
    public function leadUserData_post()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!is_array($data)) {
            return $this->response([
                'status' => 'error',
                'message' => 'Invalid JSON format.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $name = trim($data['uName'] ?? '');
        $address = trim($data['address'] ?? '');

        // Validation
        if (empty($name) || empty($address)) {
            return $this->response([
                'status' => 'error',
                'message' => 'Enter all required fields.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        // Prepare data
        $insertData = [
            'uName' => $name,
            'address' => $address
        ];

        // Insert using model
        $id = $this->Api_model->add_data_in_table($insertData, 'buyers');

        if ($id) {
            return $this->response([
                'status' => 'success',
                'message' => 'User added successfully',
                'result' => ['id' => $id]
            ], REST_Controller::HTTP_OK);
        } else {
            return $this->response([
                'status' => 'error',
                'message' => 'Failed to add user'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
