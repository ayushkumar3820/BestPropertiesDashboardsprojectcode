<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class TestAPI extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Api_model');

        $checkToken = $this->checkForToken();
        if (!$checkToken) {
            $this->response(['status' => 'error', 'message' => 'Unauthorized'], REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
    }

    /*======== Geting Hot Deals data Here =============*/
    public function propertyTest_get()
    {

        $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');
        $where = array('hot_deals' => 'yes', 'status' => 'active');
        $fields = 'id,name,type,budget,property_type,address,bathrooms,bedrooms,sqft,measureUnit,verified,image_one';
        $prohotDeals = $this->Api_model->getRecordByMultipleColumn($where, 'properties', $fields, 'id', 'RANDOM', 10);

        if (empty($prohotDeals)) {
            $return['message'] = 'No Hot Deals Found';
        } else {
            $return['status'] = 'Done';
            $return['message'] = 'Done';
            $return['result'] = $prohotDeals;
            $return['image_url'] = base_url() . 'assets/properties/';
        }
        $this->response($return, REST_Controller::HTTP_OK);
    }


}










