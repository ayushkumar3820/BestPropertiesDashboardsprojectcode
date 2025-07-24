<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class AdminUsers extends REST_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->table = 'adminLogin';
        $this->$salt = 'c1!s4vFdxM8DdmOj0lvxp3cFwQx';

    }

    // List all admin users (without Api_model)
    public function list_get()
    {
        $query = $this->db->get($this->table);
        $admins = $query->result();

        $this->response([
            'status' => 'success',
            'message' => 'Admin users fetched successfully.',
            'data' => $admins
        ], REST_Controller::HTTP_OK);
    }

    // Create a new admin user
    public function create_post()
{
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data || empty($data['fullName']) || empty($data['email']) || empty($data['password'])) {
        return $this->response([
            'status' => 'error',
            'message' => 'fullName, email and password are required.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    }

    $email = $this->db->escape_str($data['email']);
    $phone = isset($data['phone']) ? $this->db->escape_str($data['phone']) : '';

    // Check if email or phone already exists
    $this->db->from($this->table);
    $this->db->group_start();
    $this->db->where('email', $email);
    if (!empty($phone)) {
        $this->db->or_where('phone', $phone);
    }
    $this->db->group_end();
    $exists = $this->db->get()->row();

    if ($exists) {
        return $this->response([
            'status' => 'error',
            'message' => 'Email or phone already exists.'
        ], REST_Controller::HTTP_CONFLICT);
    }

    // Hash password using the same method as in login
    $hashedPassword = hash_hmac("sha512", $data['password'], $this->salt);

    $insertData = [
        'fullName' => $data['fullName'],
        'email' => $email,
        'password' => $hashedPassword,
        'phone' => $phone,
        'address' => $data['address'] ?? '',
        'role' => $data['role'] ?? '',
        'rDate' => date('Y-m-d H:i:s')
    ];

    $insert = $this->db->insert($this->table, $insertData);

    if ($insert) {
        $this->response([
            'status' => 'success',
            'message' => 'Admin user created successfully.',
            'id' => $this->db->insert_id()
        ], REST_Controller::HTTP_CREATED);
    } else {
        $this->response([
            'status' => 'error',
            'message' => 'Failed to create admin user.'
        ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    // Update admin user
    public function update_put($id = null)
{
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$id || !$data) {
        return $this->response([
            'status' => 'error',
            'message' => 'Invalid request.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    }

    if (!empty($data['password'])) {
        // Use same hashing method as in login
        $data['password'] = hash_hmac("sha512", $data['password'], $this->salt);
    } else {
        unset($data['password']);
    }

    $update = $this->Api_model->updateTable('id', $id, $this->table, $data);

    if ($update) {
        $this->response([
            'status' => 'success',
            'message' => 'Admin user updated successfully.'
        ], REST_Controller::HTTP_OK);
    } else {
        $this->response([
            'status' => 'error',
            'message' => 'Failed to update admin user.'
        ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
}

    // Delete admin user
    public function delete_delete($id = null)
    {
        if (!$id) {
            return $this->response([
                'status' => 'error',
                'message' => 'Admin user ID is required.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        // Check if admin user exists
        $this->db->where('id', $id);
        $admin = $this->db->get($this->table)->row();

        if (!$admin) {
            return $this->response([
                'status' => 'error',
                'message' => 'Admin user not found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        // Proceed to delete
        $this->db->where('id', $id);
        $delete = $this->db->delete($this->table);

        if ($delete) {
            $this->response([
                'status' => 'success',
                'message' => 'Admin user deleted successfully.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => 'error',
                'message' => 'Failed to delete admin user.'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Get single admin user by ID
    public function view_get($id = null)
    {
        if (!$id) {
            return $this->response([
                'status' => 'error',
                'message' => 'Admin user ID is required.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $admin = $this->Api_model->getRecordByColumn('id', $id, $this->table);

        if ($admin) {
            $this->response([
                'status' => 'success',
                'message' => 'Admin user fetched successfully.',
                'data' => $admin[0]
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => 'error',
                'message' => 'Admin user not found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
