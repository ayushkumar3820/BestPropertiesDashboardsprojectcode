<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class MyProperties extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->helper('url');

        $checkToken = $this->checkForToken();
        if (!$checkToken) {
            $this->response([
                'status' => 'error',
                'message' => 'Unauthorized access. Token missing or invalid.'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    // ✅ 1. Get all properties for a user
    public function getMyProperties_get()
    {
        $userid = $this->input->get('Userid');

        if (!$userid) {
            return $this->response([
                'status' => 'error',
                'message' => 'Userid is required'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->db->where('userid', $userid);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('properties');
        $result = $query->result();

        return $this->response([
            'status' => 'done',
            'message' => 'Properties fetched successfully.',
            'result' => $result
        ], REST_Controller::HTTP_OK);
    }

    // ✅ 2. Remove property by ID and UserID
    public function removeMyProperty_delete()
    {
        $input = json_decode(trim(file_get_contents('php://input')), true);
        $property_id = $input['property_id'] ?? null;
        $userid = $input['Userid'] ?? null;

        if (empty($property_id) || empty($userid)) {
            return $this->response([
                'status' => 'error',
                'message' => 'property_id and Userid are required.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->db->where('id', $property_id);
        $this->db->where('userid', $userid);
        $query = $this->db->get('properties');

        if ($query->num_rows() === 0) {
            return $this->response([
                'status' => 'error',
                'message' => 'No matching property found for this user.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        // Soft delete: mark as deleted
        $this->db->where('id', $property_id);
        $this->db->update('properties', ['is_deleted' => 1]);

        return $this->response([
            'status' => 'done',
            'message' => 'Property removed successfully.'
        ], REST_Controller::HTTP_OK);
    }
}