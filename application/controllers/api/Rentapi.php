<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
require APPPATH . 'libraries/REST_Controller.php';
class Rentapi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Api_model');
        
        $checkToken = $this->checkForToken();
        if(!$checkToken) { die(); }
    }
    
    public function rent_get()
    { 
        $rentData = $this->Api_model->getRecordByColumn('status', 'active', 'rent', 'id, name, property_type, address, sector, budget, bathrooms, verified, floor, security_deposite, property_status, amenities, image_one as image');
        if (empty($rentData)) {
            $return['message'] = 'No Records found';
        } else {
            $return['result'] = $rentData;
            $return['imgUrl'] = base_url().'assets/properties/';
        }
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function rentDetails_post()
    {
        $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');
         
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        $id = $data['id'];
        if (!is_numeric($id)) {
            $return['message'] = 'Please pass a valid ID';
        } else {
            $rent = $this->Api_model->getRecordByColumn('id', $id, 'rent', '*');
            
            
            if (empty($rent)) {
                $return['message'] = 'No records found';
            } else {
                /*$propertyType = $getPropertyDetails[0]['property_type'];
                $additionalPropertyDetails = $this->Api_model->getAdditionalPropertiesByType($propertyType, $id, 3);*/
              
               
			   
                $return['status'] = 'done';
                $return['message'] = 'Success';
                $return['imgUrl'] = base_url().'assets/properties/';
                $return['result'] = array(
                    'rent' => $rent
                );
            }
        }
        
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    /*******Add Rental Properties******/
    public function addRentProperties_post()
    {
        $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');
        $input = $this->input->post();
        
        $json = file_get_contents('php://input');
        $data = json_decode($json,true);
        
        $title = removeAllSpecialCharcter($data['title']);
        $areaSqft = removeAllSpecialCharcter($data['areaSqft']);
        $sector = removeAllSpecialCharcter($data['sector']);
        $rentpermonth = removeAllSpecialCharcter($data['rentpermonth']);
        $bathroom = removeAllSpecialCharcter($data['bathroom']);
        $bedrooms = removeAllSpecialCharcter($data['bedrooms']);
        $propertyType = removeAllSpecialCharcter($data['property_type']);
        $property_description = removeAllSpecialCharcter($data['property_description']);
        $address = removeAllSpecialCharcter($data['address']);
        $bookedby = removeAllSpecialCharcter($data['bookedby']);
        $bookingamount = removeAllSpecialCharcter($data['bookingamount']);
        $available_from = removeAllSpecialCharcter($data['available_from']);
        $status = 'deactivate';
        if (strlen($title) < 3) {
            $return['message'] = 'Please enter valid plot area';
        }
        
        else{
            $propertyInformation = array(
				'name' => $title, 
				'sqft' => $areaSqft, 
				'sector' => $sector,
				'budget' => $rentpermonth,
				'bathrooms' => $bathroom,
				'bedrooms' => $bedrooms,
				'description' => $property_description,
				'address' => $address,
				'booked_by' => $bookedby,
				'booking_amount' => $bookingamount,
				'property_type' => $propertyType,
				'available_from' => $available_from,
				'status'=>$status);
            
			$this->Api_model->add_data_in_table($propertyInformation, 'rent');
			$return['result'] = '';
			$return['status'] = 'done';
			$return['message'] = 'Property added successfully.';
        
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }
	
	/************Property Type Api********************/

	public function allPropertyTypeApi_get()
    {
        $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');
     
		$property_types = rentPropertyType();
			if(!empty($property_types)){
				$return['result'] = $property_types;
				$return['status'] = 'done';
				$return['message'] = '';
			}
			else {
				// Property types could not be retrieved
				$return['message'] = 'Failed to retrieve property types';
			}
            $this->response($return, REST_Controller::HTTP_OK);
    }

	/*********** Rent Hot Deals Api *************************/

	public function rentHotDeals_get()
    {
		$return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');
		$where = array('hot_deals' => 'yes', 'status' => 'active');
		$hotDeals = $this->Api_model->getRecordByMultipleColumn($where, 'rent', 'id,name,type,budget,property_type,address,property_status,floor,sector,bathrooms,bedrooms,sqft,measureUnit,verified,image_one','id','RANDOM',6);
			if (empty($hotDeals)) {
				$return['message'] = 'No Hot Deals Found';
			} else {
				$return['status'] = 'Done';
				$return['result'] = 'Done';
				$return['result'] = $hotDeals;
				$return['image_url'] = base_url() . 'assets/properties/';
			}
		$this->response($return, REST_Controller::HTTP_OK);	
	}

	// SEARCH API
	public function rent_search_get()
    {
        $property_type = $this->get('property_type');
        $sort_by = $this->get('sort_by'); // 'asc' or 'desc'
        $city = $this->get('city');
        $keyword = $this->get('keyword');

        $this->load->model('Api_model');

        // ✅ Return error if keyword is missing
        if (empty($keyword)) {
            $this->response([
                'status' => false,
                'message' => 'Field keyword is required'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // Base WHERE clause
        $where = ['status' => 'active'];
        if (!empty($property_type)) {
            $where['property_type'] = $property_type;
        }

        $this->db->select('id, name, property_type, address, sector, budget, bathrooms, verified, floor, security_deposite, property_status, amenities, image_one as image');
        $this->db->from('rent');
        $this->db->where($where);

        // ✅ Keyword match across multiple fields using 'LIKE' (match as whole word or partial)
        $this->db->group_start();
        $this->db->like('name', $keyword);
        $this->db->or_like('address', $keyword);
        $this->db->or_like('sector', $keyword);
        $this->db->or_like('amenities', $keyword);
        $this->db->group_end();

        // City filter
        if (!empty($city)) {
            $this->db->like('address', $city);
        }

        // Sorting
        if (!empty($sort_by) && in_array(strtolower($sort_by), ['asc', 'desc'])) {
            $this->db->order_by('budget', $sort_by);
        } else {
            $this->db->order_by('id', 'DESC');
        }

        $query = $this->db->get();
        $rentData = $query->result();

        if (empty($rentData)) {
            $return['message'] = 'No records found for the given keyword';
        } else {
            $return['result'] = $rentData;
            $return['imgUrl'] = base_url() . 'assets/properties/';
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }


}