<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Buyer extends REST_Controller
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

    /** add buyers  **/
    public function addBuyer_post()
    {
        $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $infoType = removeAllSpecialCharcter($data['infotype']);
        $userType = removeAllSpecialCharcter($data['userType']);
        $uName = removeAllSpecialCharcter($data['uName']);
        $mobile = removeAllSpecialCharcter($data['mobile']);

        if (!is_numeric($mobile) || strlen($mobile) != 10) {
            $return['message'] = 'Phone number is not valid';
        } elseif ($infoType == 'personalInfo' && (strlen($uName) < 3 || preg_match("/[0-9]/", $uName))) {
            $return['message'] = 'Name must be at least 3 characters.';
        } elseif ($infoType == 'personalInfo') {
            $checNumber = $this->Api_model->getRecordByColumn('mobile', $mobile, 'buyers', 'mobile');

            $fullPayload = [
                'uName' => $uName,
                'userType' => $userType,
                'mobile' => $mobile,
                'email' => $data['email'] ?? null,
                'address' => $data['address'] ?? null,
                'preferred_location' => $data['preferred_location'] ?? null,
                'budget' => $data['budget'] ?? null,
                'max_budget' => $data['max_budget'] ?? null,
                'Payment_Method' => $data['home_loan'] ?? null,  // assuming 'home_loan' maps to 'Payment_Method'
                'requirement' => $data['requirement'] ?? null,
                'status' => $data['status'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? 'Punjab',
                'rDate' => isset($data['rDate']) ? date('Y-m-d H:i:s', strtotime($data['rDate'])) : null,
                'propertyType_sub' => $data['propertyType_sub'] ?? null,
                'propertyType' => $data['propertyType'] ?? null,
                'source' => $data['source'] ?? 'Website',
                'Profession' => $data['Profession'] ?? null,
                'deal' => $data['deal'] ?? null,
                'timeline' => $data['timeline'] ?? null,
                'priority' => $data['priority'] ?? 'Cold',
                'userid' => $data['userid'] ?? null,
                'Project_Builder' => $data['Project_Builder'] ?? null,
                'leads_type' => $data['leads_type'] ?? 'Buyer',
                'description' => $data['description'] ?? null
            ];

            if (!empty($checNumber) && $checNumber[0]['mobile'] == $mobile) {
                $this->Api_model->updateTable('mobile', $mobile, 'buyers', $fullPayload);
                $return['status'] = 'done';
                $return['message'] = 'Buyer updated successfully.';
            } else {
                $this->Api_model->add_data_in_table($fullPayload, 'buyers');
                $return['status'] = 'done';
                $return['message'] = 'Buyer added successfully.';
            }
        } elseif ($infoType == 'location') {
            $checNumber = $this->Api_model->getRecordByColumn('mobile', $mobile, 'buyers', 'mobile');
            if (!empty($checNumber) && $checNumber[0]['mobile'] == $mobile) {
                $address = removeAllSpecialCharcter($data['address']);
                $city = removeAllSpecialCharcter($data['city']);
                $zip = removeAllSpecialCharcter($data['zip']);

                if ($address == '' || $city == '' || $zip == '') {
                    $return['message'] = 'Please fill all fields.';
                } else {
                    $updateLocation = array('address' => $address, 'city' => $city, 'zip' => $zip);
                    $this->Api_model->updateTable('mobile', $mobile, 'buyers', $updateLocation);
                    $return['status'] = 'done';
                    $return['message'] = 'Buyer location updated.';
                }
            }
        } elseif ($infoType == 'budget') {
            $checNumber = $this->Api_model->getRecordByColumn('mobile', $mobile, 'buyers', 'mobile');
            if (!empty($checNumber) && $checNumber[0]['mobile'] == $mobile) {
                $minBudget = removeAllSpecialCharcter($data['minBudget']);
                $maxBudget = removeAllSpecialCharcter($data['maxBudget']);

                if ($minBudget == '' || $maxBudget == '') {
                    $return['message'] = 'Please fill all fields.';
                } else {
                    $updateBudget = array(
                        'budget' => $minBudget,
                        'max_budget' => $maxBudget,
                        'preferred_location' => $data['location']
                        ,
                        'city' => $data['city']
                    );
                    $this->Api_model->updateTable('mobile', $mobile, 'buyers', $updateBudget);
                    $return['status'] = 'done';
                    $return['message'] = 'Buyer budget updated.';
                }
            }
        } elseif ($infoType == 'requirement') {
            $checNumber = $this->Api_model->getRecordByColumn('mobile', $mobile, 'buyers', 'mobile');
            if (!empty($checNumber) && $checNumber[0]['mobile'] == $mobile) {
                // $residential = removeAllSpecialCharcter($data['residential']);
                //$commercial = removeAllSpecialCharcter($data['commercial']);
                $propertyType = removeAllSpecialCharcter($data['property_type']);

                if ($propertyType == '') {
                    $return['message'] = 'Missing propertyType.';
                } else {
                    $dbFields = [
                        'uName',
                        'address',
                        'mobile',
                        'preferred_location',
                        'budget',
                        'max_budget',
                        'Payment_Method',
                        'requirement',
                        'leads_type',
                        'description',
                        'status',
                        'city',
                        'state',
                        'rDate',
                        'userType',
                        'email',
                        'Project_Builder',
                        'propertyType_sub',
                        'propertyType',
                        'source',
                        'Profession',
                        'deal',
                        'timeline',
                        'priority',
                        'userid'
                    ];

                    // Step 2: Split data into updateable fields and additional_info
                    $updateRequirement = [];
                    $additionalInfo = [];

                    foreach ($data as $key => $value) {
                        // Skip if key is "infotype" or value is empty/null
                        if ($key === 'infotype' || $value === '' || is_null($value)) {
                            continue;
                        }

                        // Handle special keys mapping
                        if ($key === 'property_type') {
                            $updateRequirement['propertyType'] = $value;
                        } elseif ($key === 'property_type_sub') {
                            $updateRequirement['propertyType_sub'] = $value;
                        }
                        // Direct field match
                        elseif (in_array($key, $dbFields)) {
                            $updateRequirement[$key] = $value;
                        }
                        // Everything else goes in additional_info
                        else {
                            $additionalInfo[$key] = $value;
                        }
                    }

                    // Step 3: Add additional_info JSON if any
                    if (!empty($additionalInfo)) {
                        $updateRequirement['additional_info'] = json_encode($additionalInfo);
                    }

                    // Step 4: Update database
                    $this->Api_model->updateTable('mobile', $data['mobile'], 'buyers', $updateRequirement);

                    $return['status'] = 'done';
                    $return['message'] = 'Buyer requirement updated.';
                }
            }
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }


    public function scheduleVisit_post()
    {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        $response = ['status' => 'error', 'message' => 'Invalid request'];

        if (!$data || !isset($data['phone']) || !isset($data['visitDate']) || !isset($data['property_id'])) {
            $response['message'] = 'Missing required fields';
            echo json_encode($response);
            return;
        }

        $phone = $data['phone'];
        $property_id = $data['property_id'];
        $user_id = $data['Userid'];
        $property_name = isset($data['property_name']) ? $data['property_name'] : 'Unknown Property';
        $firstname = isset($data['firstname']) ? $data['firstname'] : 'Guest';
        $visitDate = date('Y-m-d H:i:s', strtotime($data['visitDate']));
        $comment = 'Visit Scheduled for property: ' . $property_name . ' (ID: ' . $property_id . ')';

        // Check if buyer already exists
        $this->db->where('mobile', $phone);
        $buyer = $this->db->get('buyers')->row();

        if (!$buyer) {
            $newBuyer = [
                'uName' => $firstname,
                'mobile' => $phone,
                'requirement' => $property_name,
                'leads_type' => 'Buyer',
                'status' => 'New',
                'rDate' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('buyers', $newBuyer);
            $lead_id = $this->db->insert_id();
        } else {
            $lead_id = $buyer->id;
        }

        // Check for existing meeting
        $this->db->where('leadId', $lead_id);
        $this->db->where('choice', 'Meeting');
        $this->db->like('comment', "(ID: $property_id)");
        $existing = $this->db->get('leads_comment')->row();

        if ($existing) {
            // 🟨 Update: append property_id to property_ids if not already present
            $existing_ids = $existing->property_ids ? explode(',', $existing->property_ids) : [];

            if (!in_array($property_id, $existing_ids)) {
                $existing_ids[] = $property_id;
            }

            $property_ids_updated = implode(',', $existing_ids);

            $meetingData = [
                'leadId' => $lead_id,
                'comment' => $comment,
                'nextdt' => $visitDate,
                'choice' => 'Meeting',
                'status' => 'Rescheduled',
                'property_ids' => $property_ids_updated,
                'userId' => $user_id
            ];

            $this->db->where('id', $existing->id);
            $this->db->update('leads_comment', $meetingData);

            $this->db->where('id', $lead_id);
            $this->db->update('buyers', [
                'uName' => $firstname,
                'requirement' => $property_name,
                'status' => 'Rescheduled',
            ]);

            $response['message'] = 'Meeting rescheduled successfully';
        } else {
            // 🟩 Insert: create new row with property_ids
            $meetingData = [
                'leadId' => $lead_id,
                'comment' => $comment,
                'nextdt' => $visitDate,
                'choice' => 'Meeting',
                'status' => 'Scheduled',
                'property_ids' => $property_id,
                'userId' => $user_id
            ];

            $this->db->insert('leads_comment', $meetingData);
            $response['message'] = 'Meeting scheduled successfully';

        }

        $response['status'] = 'success';
        echo json_encode($response);
    }



    //get api function 

    public function getScheduledVisits_get()
    {
        header('Content-Type: application/json'); // ensure JSON

        $phone = $this->input->get('phone', true);
        $property_id = $this->input->get('property_id', true);
        $user_id = $this->input->get('Userid', true);

        $response = ['status' => 'error', 'message' => 'Invalid request', 'result' => []];

        try {
            // 👉 your DB query logic here
            $this->db->select('*');
            $this->db->from('leads_comment');
            if (!empty($phone)) {
                $this->db->where('leadId', $phone);
            }
            if (!empty($property_id)) {
                $this->db->like('property_ids', $property_id);
            }
            $query = $this->db->get();
            $data = $query->result();

            if ($data) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data retrieved',
                    'result' => $data
                ];
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'No data found',
                    'result' => []
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        echo json_encode($response);
        return $this->response($response, REST_Controller::HTTP_OK);

    }





    //all scheduled visit properties as requested properties
    public function getRequestedProperties_get()
    {

        // Default error response
        $response = ['status' => 'error', 'message' => 'Invalid request'];

        $user_id = $this->input->get('Userid', true); // true enables XSS filtering

        // Input validation
        if (empty($user_id)) {
            $response = [
                'status' => 'error',
                'message' => 'Missing Userid'
            ];
            return $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        // Step 1: Get property_ids from leads_comment for given user_id
        $this->db->select('property_ids');
        $this->db->from('leads_comment');
        $this->db->where('userId', $user_id);
        $query = $this->db->get();
        $results = $query->result();

        // Step 2: Collect all IDs into a single array
        $property_ids = [];

        foreach ($results as $row) {
            if (!empty($row->property_ids)) {
                $ids = explode(',', $row->property_ids);
                $property_ids = array_merge($property_ids, $ids);
            }
        }

        // Step 3: Remove duplicates and empty values
        $property_ids = array_unique(array_filter($property_ids));

        // Step 4: Return if no valid IDs found
        if (empty($property_ids)) {
            $response['message'] = 'No valid property IDs found for this user';
            return $this->response($response, REST_Controller::HTTP_OK);
        }

        // Step 5: Get matching property records
        $this->db->where_in('id', $property_ids);
        $this->db->where('is_deleted', 0); // Optional: only active properties
        $properties = $this->db->get('properties')->result();

        // Final Response
        $response = [
            'status' => 'success',
            'message' => 'Requested properties fetched successfully',
            'result' => $properties
        ];

        return $this->response($response, REST_Controller::HTTP_OK);
    }

    public function deleteRequestedProperty_delete()
    {
        $response = ['status' => 'error', 'message' => 'Invalid request'];

        // Get raw JSON input
        $input = json_decode(trim(file_get_contents("php://input")), true);
        $user_id = $input['Userid'] ?? null;
        $property_id = $input['property_id'] ?? null;

        // Input validation
        if (empty($user_id) || empty($property_id)) {
            $response['message'] = 'Missing Userid or property_id';
            return $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        // Step 1: Fetch all leads_comment rows for user
        $this->db->select('id, property_ids');
        $this->db->from('leads_comment');
        $this->db->where('userId', $user_id);
        $query = $this->db->get();
        $rows = $query->result();

        if (empty($rows)) {
            $response['message'] = 'No records found for the given user';
            return $this->response($response, REST_Controller::HTTP_OK);
        }

        $updated = false;
        $deleted = false;

        foreach ($rows as $row) {
            $property_ids = array_filter(explode(',', $row->property_ids));
            $new_ids = array_diff($property_ids, [$property_id]); // remove only that property_id

            if (count($new_ids) === 0) {
                // If no properties left, delete the row
                $this->db->where('id', $row->id);
                $this->db->delete('leads_comment');
                $deleted = true;
            } elseif (implode(',', $property_ids) !== implode(',', $new_ids)) {
                // Update only if change occurred
                $this->db->where('id', $row->id);
                $this->db->update('leads_comment', ['property_ids' => implode(',', $new_ids)]);
                $updated = true;
            }
        }

        if ($deleted || $updated) {
            $response = [
                'status' => 'success',
                'message' => $deleted
                    ? 'Property deleted successfully'
                    : 'Property removed successfully'
            ];
        } else {
            $response['message'] = 'Property not found in user\'s requested list';
        }

        return $this->response($response, REST_Controller::HTTP_OK);
    }
}
