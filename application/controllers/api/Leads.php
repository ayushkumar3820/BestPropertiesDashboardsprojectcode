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
    
    // Get Leads Data

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
            $role = strtolower($checkToken[0]['role'] ?? '');

            if ($role === 'admin') {
                // 🔥 Admin gets ALL buyers (no filter)
                $this->db->select('*');
                $this->db->from('buyers');
                $this->db->order_by('id', 'DESC');   // ✅ latest first
                $query = $this->db->get();
                $leadsData = $query->num_rows() > 0 ? $query->result_array() : [];

            } else {
                // 🔥 Non-admin = only assigned leads
                $assignedLeads = $this->Api_model->getRecordByColumn('userid', $userId, 'assigned_leads', 'leadid');

                if ($assignedLeads) {
                    $leadIds = array_column($assignedLeads, 'leadid');
                    $leadsData = $this->Api_model->getRecordsByWhereIn('id', $leadIds, 'buyers');
                } else {
                    $leadsData = [];
                }
            }

            // ✅ Attach meetings + property info
            if (!empty($leadsData)) {
                $leadIds = array_column($leadsData, 'id');
                $meetingsByLead = $this->Api_model->getMeetingsByLeadIds($leadIds);

                foreach ($leadsData as &$lead) {
                    $leadId = $lead['id'];
                    $lead['meetings'] = isset($meetingsByLead[$leadId]) ? $meetingsByLead[$leadId] : [];

                    // Attach property details for each meeting
                   foreach ($lead['meetings'] as &$meeting) {
    $meeting['property'] = [];

    if (!empty($meeting['property_id'])) {
        $ids = [];

        // Normalize JSON or string
        $decoded = json_decode($meeting['property_id'], true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            // JSON array [{"id":"1923"},{"id":"1924"}]
            foreach ($decoded as $item) {
                if (isset($item['id'])) $ids[] = intval($item['id']);
            }
        } else {
            // Comma-separated "1923,1924" or other string
            $parts = preg_split('/[\s,]+/', $meeting['property_id']);
            foreach ($parts as $p) {
                $id = intval(trim($p));
                if ($id > 0) $ids[] = $id;
            }
        }

        $ids = array_unique($ids); // remove duplicates

        if (!empty($ids)) {
            // fetch only the properties that exist in the properties table
            $properties = $this->Api_model->getPropertiesByIds($ids);

            // 🔹 Keep only existing properties, ignore missing IDs
            $meeting['property'] = $properties ?: [];
        }
    }
}
unset($meeting);

                }
                unset($lead); // break reference
                unset($meeting);

                $return['status'] = 'done';
                $return['message'] = 'Leads fetched successfully.';
                $return['result'] = $leadsData;
            } else {
                $return['status'] = 'Fail';
                $return['message'] = 'No records found.';
            }
        } else {
            $return['message'] = 'This token has been expired.';
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}

    
    public function statusGetLeadsData_post()
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

                // ✅ Get all leads first
                $leadsData = $this->Api_model->getRecordsByWhereIn('id', $leadIds, 'buyers');

                // ✅ Filter here based on status
                if ($leadsData) {
                    $filteredLeads = array_filter($leadsData, function ($lead) {
                        return in_array($lead['status'], ['New', 'Pending', 'Follow-up']);
                    });

                    if (!empty($filteredLeads)) {
                        $return['status'] = 'done';
                        $return['message'] = 'Done.';
                        $return['result'] = array_values($filteredLeads); // reindex array
                    } else {
                        $return['status'] = 'Fail';
                        $return['message'] = 'No records found with given status.';
                        $return['result'] = '';
                    }
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



    // Add Leads Data
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
            'userid', 'uname', 'address', 'mobile', 'preferred_location', 'propertytype',
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
        if (!preg_match('/^[0-9]{10}$/', $data['mobile'])) {
            return $this->response(
                ['status' => 'error', 'message' => 'Please provide a valid 10-digit mobile number.'],
                REST_Controller::HTTP_OK
            );
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->response(
                ['status' => 'error', 'message' => 'Please provide a valid email address.'],
                REST_Controller::HTTP_OK
            );
        }
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
    
    
    // Update Leads Data
public function updateLeadsData_post($id = null)
{
    $return = ['status' => 'error', 'message' => '', 'result' => ''];

    // Get raw input
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!is_array($data)) {
        return $this->response([
            'status' => 'error',
            'message' => 'Invalid JSON format.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    }

    if ($id === null) {
        return $this->response([
            'status' => 'error',
            'message' => 'ID is required in URL.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    }

    // Convert new_requirement array to JSON string before saving
    if (isset($data['new_requirement']) && is_array($data['new_requirement'])) {
        $data['new_requirement'] = json_encode($data['new_requirement']);
    }

    // Database update
    $updated = $this->Api_model->updateTable('id', $id, 'buyers', $data);

    if ($updated) {
        $return = [
            'status' => 'success',
            'message' => 'Data updated successfully',
            'result' => $data
        ];
    } else {
        $return = [
            'status' => 'error',
            'message' => 'Failed to update data'
        ];
    }

    return $this->response($return, REST_Controller::HTTP_OK);
}



// Delete Leads Data
// Delete Leads Data
public function deleteLeadsData_post($id = null) 
{
    $return = array(
        'status' => 'error',
        'message' => 'Please send required parameter (id)',
        'result' => ''
    );

    // Agar URL me id hi nahi di
    if (empty($id)) {
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // buyers table me check
    $buyerExists = $this->db->where('id', $id)->get('buyers')->row();
    if (!$buyerExists) {
        $return['message'] = 'Lead not found in buyers, delete not allowed';
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // buyers table se delete
    $this->Api_model->delete('id', $id, 'buyers');

    // leads table se bhi delete
    $this->db->where('id', $id);
    $this->db->delete('leads');
     
    $return['status'] = 'success';
    $return['message'] = 'Lead deleted successfully';
    $return['result']  = ['id' => $id];

    return $this->response($return, REST_Controller::HTTP_OK);
}









}