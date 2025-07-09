<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Buyer extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Api_model');

        $checkToken = $this->checkForToken();
        if(!$checkToken) { die(); }
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
        }
        elseif($infoType == 'personalInfo' && (strlen($uName) < 3 || preg_match("/[0-9]/", $uName))) {
            $return['message'] = 'Name must be at least 3 characters.';
        }
        elseif($infoType == 'personalInfo') {
            $checNumber = $this->Api_model->getRecordByColumn('mobile',$mobile,'buyers','mobile');

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
                'state' => $data['state'] ?? null,
                'rDate' => isset($data['rDate']) ? date('Y-m-d H:i:s', strtotime($data['rDate'])) : null,
                'propertyType_sub' => $data['propertyType_sub'] ?? null,
                'propertyType' => $data['propertyType'] ?? null,
                'source' => $data['source'] ?? null,
                'Profession' => $data['Profession'] ?? null,
                'deal' => $data['deal'] ?? null,
                'timeline' => $data['timeline'] ?? null,
                'priority' => $data['priority'] ?? null,
                'userid' => $data['userid'] ?? null,
                'Project_Builder' => $data['Project_Builder'] ?? null,
                'leads_type' => $data['leads_type'] ?? null,
                'description' => $data['description'] ?? null
            ];

            if(!empty($checNumber) && $checNumber[0]['mobile']== $mobile){
                $this->Api_model->updateTable('mobile',$mobile,'buyers',$fullPayload);
                $return['status'] = 'done';
                $return['message'] = 'Buyer updated successfully.';
            } else {
                $this->Api_model->add_data_in_table($fullPayload, 'buyers');
                $return['status'] = 'done';
                $return['message'] = 'Buyer added successfully.';
            }
        }
        elseif($infoType == 'location') {
            $checNumber = $this->Api_model->getRecordByColumn('mobile',$mobile,'buyers','mobile');
            if(!empty($checNumber) && $checNumber[0]['mobile']== $mobile){
                $address = removeAllSpecialCharcter($data['address']);
                $city = removeAllSpecialCharcter($data['city']);
                $zip = removeAllSpecialCharcter($data['zip']);

                if($address == '' || $city == '' || $zip == ''){
                    $return['message'] = 'Please fill all fields.';
                } else {
                    $updateLocation = array('address' => $address, 'city' => $city, 'zip'=>$zip);
                    $this->Api_model->updateTable('mobile',$mobile,'buyers',$updateLocation);
                    $return['status'] = 'done';
                    $return['message'] = 'Buyer location updated.';
                }
            }
        }
        elseif ($infoType == 'budget') {
            $checNumber = $this->Api_model->getRecordByColumn('mobile', $mobile, 'buyers', 'mobile');
            if (!empty($checNumber) && $checNumber[0]['mobile'] == $mobile) {
                $minBudget = removeAllSpecialCharcter($data['minBudget']);
                $maxBudget = removeAllSpecialCharcter($data['maxBudget']);

                if ($minBudget == '' || $maxBudget == '') {
                    $return['message'] = 'Please fill all fields.';
                } else {
                    $updateBudget = array('budget' => $minBudget, 'max_budget' => $maxBudget,'preferred_location'=>$data['location']
                    ,'city'=>$data['city']);
                    $this->Api_model->updateTable('mobile', $mobile, 'buyers', $updateBudget);
                    $return['status'] = 'done';
                    $return['message'] = 'Buyer budget updated.';
                }
            }
        }
        elseif($infoType == 'requirement') {
            $checNumber = $this->Api_model->getRecordByColumn('mobile',$mobile,'buyers','mobile');
            if(!empty($checNumber) && $checNumber[0]['mobile']== $mobile){
               // $residential = removeAllSpecialCharcter($data['residential']);
                //$commercial = removeAllSpecialCharcter($data['commercial']);
                $propertyType = removeAllSpecialCharcter($data['property_type']);

                if($propertyType == ''){
                    $return['message'] = 'Missing propertyType.';
                } else {
                   $updateRequirement = array(
                        'uName'              => $data['uName'],
                        'address'            => $data['address'],
                        'mobile'             => $data['mobile'],
                        'requirement'        => $data['requirement'],
                        'status'             => $data['status'],
                        'city'               => $data['city'],
                        'rDate'              => $data['rDate'],
                        'userid'             => $data['userid'],
                        'timeline'           => $data['timeline'],
                        'propertyType'       => $data['property_type'],
                        'propertyType_sub'   => $data['property_type_sub']
                    );

                    $this->Api_model->updateTable('mobile',$mobile,'buyers',$updateRequirement);
                    $return['status'] = 'done';
                    $return['message'] = 'Buyer requirement updated.';
                }
            }
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }
}
