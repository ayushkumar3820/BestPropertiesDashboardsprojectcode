<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Leads extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');

        $this->table = 'buyers';
        // Optional token check
        // if (!$this->checkForToken()) { die(); }
    }

    // ✅ Create new buyer
    public function create_post()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['uName']) || empty($data['mobile'])) {
            return $this->response([
                'status' => 'error',
                'message' => 'Name and Mobile are required.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $data['rDate'] = date('Y-m-d H:i:s');
        $insert_id = $this->Api_model->add_data_in_table($data, $this->table);

        if ($insert_id) {
            return $this->response([
                'status' => 'success',
                'message' => 'Buyer created successfully.',
                'id' => $insert_id
            ], REST_Controller::HTTP_CREATED);
        } else {
            return $this->response([
                'status' => 'error',
                'message' => 'Failed to create buyer.'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     public function getDataByMultipleColumns($where, $table, $columns = '*', $orderBy = '', $orderByValue = '', $limit = '') {
	    $this->db->select($columns);
		$this->db->from($table);
		$this->db->where($where);
		if($orderBy != '') { $this->db->order_by($orderBy,$orderByValue); }
		if($limit !='') { $this->db->limit($limit); }
		$query = $this->db->get();
		return $query->result();
	}
		public function getDataByMultipleColumnss($where,$table,$columns,$orderBy='',$orderByValue='asc',$limit=''){
	    $this->db->select($columns);
		$this->db->from($table);
		$this->db->where($where);
		if($orderBy != '') { $this->db->order_by($orderBy,$orderByValue); }
		if($limit !='') { $this->db->limit($limit); }
		$query = $this->db->get();
		return $query->result();
	}

    public function getFilteredLeads($filters = [], $like = [], $table, $columns = '*', $orderBy = '', $orderByValue = '', $limit = '') {
        $this->db->select($columns);
        $this->db->from($table);

        if (!empty($filters)) {
            $this->db->where($filters);
        }

        if (!empty($like)) {
            foreach ($like as $key => $val) {
                $this->db->like($key, $val);
            }
        }

        if ($orderBy != '') {
            $this->db->order_by($orderBy, $orderByValue);
        }

        if ($limit != '') {
            $this->db->limit($limit);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function getAgentLead($userid){
        $this->db->select('b.*');
            $this->db->from('buyers as b');
            $this->db->join('assigned_leads as s', 's.leadid=b.id', 'left');
            $this->db->where('s.userid', $userid);
        //	if($orderBy != '') { $this->db->order_by($orderBy,$orderByValue); }
        //	if($limit !='') { $this->db->limit($limit); }
            $query = $this->db->get();
            return $query->result();
    }

    // ✅ Read buyers (all or single)
    public function get_get($id = null)
    {
        $userRole = $this->input->get_request_header('Role');
        $userId = $this->input->get_request_header('Userid');
        $params = $this->input->get();

        $filters = [];
        $like = [];
        $agent = "";

        // Fetch single buyer if ID is given
        if ($id) {
            $buyer = $this->Api_model->getRecordByColumn('id', $id, $this->table);
            if (!empty($buyer)) {
                return $this->response([
                    'status' => 'success',
                    'result' => $buyer
                ], REST_Controller::HTTP_OK);
            } else {
                return $this->response([
                    'status' => 'error',
                    'message' => 'Buyer not found.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }

        // Sale Person view
        if (stristr($userRole, 'Sale Person')) {
            $statuses = ["Assigned", "Contacted", "Interested", "Not Interested", "Zunk"];
            $this->db->where_in("status", $statuses);
            $leads = $this->db->get("buyers")->result_array();
        } else {
            // General filters
            $filters["id >"] = "1";

            if ($userRole == "Agent") {
                $filters["userid"] = $userId;
            }

            // Optional filters from GET
            if (!empty($params['start_date']) && !empty($params['end_date'])) {
                $filters["DATE(rDate) >="] = $params["start_date"];
                $filters["DATE(rDate) <="] = $params["end_date"];
            }

            if (!empty($params["uName"])) {
                $like["uName"] = $params["uName"];
            }

            if (!empty($params["mobile"])) {
                $like["mobile"] = $params["mobile"];
            }

            if (!empty($params["status"])) {
                $filters["status"] = $params["status"];
            }

            if (!empty($params["leads_type"])) {
                $filters["leads_type"] = $params["leads_type"];
            }

            if (isset($params["agent"]) && $params["agent"] !== "") {
                $agent = $params["agent"];
                $filters["userid"] = $agent;
            }

            $leads = $this->getFilteredLeads($filters, $like, "buyers", "*", "id", "desc");
        }

        // Agent lead assignment merging
        if (stristr($userRole, "Agent") || $agent != "") {
            $leadUserId = $agent ? $agent : $userId;

            $assignleads = $this->getAgentLead($leadUserId);
            if (!empty($assignleads)) {
                $leads = array_merge($leads, $assignleads);
                $leads = array_map("unserialize", array_unique(array_map("serialize", $leads)));
            }
        }

        // Agent List
        $agents = $this->getDataByMultipleColumns(
            ["role" => "Agent"],
            "adminLogin",
            "id,fullName"
        );

        return $this->response([
            'status' => 'success',
            'result' => [
                'leads' => $leads,
                'agents' => $agents
            ]
        ], REST_Controller::HTTP_OK);
    }

    // ✅ Update buyer
    public function update_put($id = null)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$id || !$data) {
            return $this->response([
                'status' => 'error',
                'message' => 'ID and data are required.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $updated = $this->Api_model->updateTable('id', $id, $this->table, $data);

        if ($updated) {
            return $this->response([
                'status' => 'success',
                'message' => 'Buyer updated successfully.'
            ], REST_Controller::HTTP_OK);
        } else {
            return $this->response([
                'status' => 'error',
                'message' => 'Failed to update buyer.'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ✅ Delete buyer
    public function delete_delete($id = null)
    {
        if (!$id) {
            return $this->response([
                'status' => 'error',
                'message' => 'ID is required.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $deleted = $this->Api_model->delete('id', $id, $this->table);

        if ($deleted) {
            return $this->response([
                'status' => 'success',
                'message' => 'Buyer deleted successfully.'
            ], REST_Controller::HTTP_OK);
        } else {
            return $this->response([
                'status' => 'error',
                'message' => 'Failed to delete buyer.'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
