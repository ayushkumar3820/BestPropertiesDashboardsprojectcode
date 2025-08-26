<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Properties extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->helper('url');

        $checkToken = $this->checkForToken();
        if (!$checkToken) { die(); }
    }

    /** Add Property API **/
public function addAdminProperty_post()
{
    $return = ['status' => 'error', 'message' => 'Missing required fields', 'result' => ''];

    // Ensure session is loaded in REST controller
    if (!isset($this->session)) {
        $this->load->library('session');
    }

    // ---- Image Uploads ----
    $imageFields  = ['image_one', 'image_two', 'image_three', 'image_four'];
    $uploadPath   = './assets/properties/';
    $allowedTypes = 'jpg|jpeg|png|webp';

    $this->load->library('upload');
    $uploadedImages = [];

    foreach ($imageFields as $field) {
        if (!empty($_FILES[$field]['name'])) {
            $config = [
                'upload_path'   => $uploadPath,
                'allowed_types' => $allowedTypes,
                'file_name'     => time() . '_' . basename($_FILES[$field]['name']),
            ];
            $this->upload->initialize($config);
            if ($this->upload->do_upload($field)) {
                $uploadData = $this->upload->data();
                $uploadedImages[$field] = $uploadData['file_name'];
            }
        }
    }

    // ---- Collect Property Fields (excluding userid; set separately) ----
    $propertyFields = [
        'name','property_builder','description','property_for','project_n',
        'built','land','carpet','additional','additional_value','address','person',
        'phone','person_address','city','state','property_type','category','zip_code',
        'bhk','budget','budget_in_words','amenities','type',
        'status','approvel','show_in_slider','show_in_gallery',
        'icon','bathrooms','bedrooms','sqft','measureUnit','services','verified',
        'residential','commercial','hot_deals','clone_id','main_site','lead_id',
        'new_properties_id','construction_status','property_tags'
    ];

    $data = [];

    // Always set userid (POST -> Session -> Header fallback)
    $userid = $this->input->post('userid', true);
    if (empty($userid) && isset($this->session) && method_exists($this->session, 'userdata')) {
        $userid = $this->session->userdata('id');
    }
    if (empty($userid)) {
        // optional header fallback if you pass user id via header
        $headerUserId = $this->input->get_request_header('X-User-Id', true);
        if (!empty($headerUserId)) {
            $userid = $headerUserId;
        }
    }
    if (!empty($userid)) {
        $data['userid'] = $userid;
    }

    // Copy posted fields (ignore null/empty strings)
    foreach ($propertyFields as $field) {
        $val = $this->input->post($field);
        if ($val !== null && $val !== '') {
            $data[$field] = $val;
        }
    }

    // Merge uploaded images
    foreach ($uploadedImages as $field => $filename) {
        $data[$field] = $filename;
    }

    // ---- Insert into properties ----
    $this->db->insert('properties', $data);
    $property_id = $this->db->insert_id();

    if (!$property_id) {
        $return['message'] = 'Failed to add property.';
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // ---- Property Meta ----
    $metaFields = [
        'floor_no','total_floors','property_age','kothi_story_type','furnishing_status',
        'ownership_type','gated_community','available_from','has_lift','parking_available',
        'commercial_approval','width_length','road_width','commercial_useType',
        'shutters_count','roof_height','loading_bay','locality','landmark','direction',
        'facing','in_society','hospital_type','floor_available','medical_facilities',
        'hospital_license','possession_status','map_link','other_property_type','property_tags'
    ];

    $metaData = ['properties_id' => $property_id];
    foreach ($metaFields as $field) {
        $val = $this->input->post($field);
        if ($val !== null && $val !== '') {
            $metaData[$field] = $val;
        }
    }

    $this->db->insert('properties_meta', $metaData);

    $return['status']  = 'done';
    $return['message'] = 'Property added successfully';
    return $this->response($return, REST_Controller::HTTP_OK);
}





    /** Add Property API **/
    
    
    public function addProperty_post()
    {

       $return = array('status' => 'error', 'message' => 'Missing required fields', 'result' => '');

        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (!$data || !isset($data['property_type']) || !isset($data['phone'])) {
            $return['message'] = "Missing required fields: property_type or phone.";
            return $this->response($return, REST_Controller::HTTP_OK);
        }

        // Property table fields
        $propertyFields = [
            'userid', 'name', 'property_builder', 'description', 'property_for', 'project_n',
            'built', 'land', 'carpet', 'additional', 'additional_value', 'address', 'person',
            'phone', 'person_address', 'city', 'state', 'property_type', 'category', 'zip_code',
            'bhk', 'budget', 'budget_in_words', 'amenities', 'type', 'image_one', 'image_two',
            'image_three', 'image_four', 'status', 'approvel', 'show_in_slider', 'show_in_gallery',
            'icon', 'bathrooms', 'bedrooms', 'sqft', 'measureUnit', 'services', 'verified',
            'residential', 'commercial', 'hot_deals', 'clone_id', 'main_site', 'lead_id',
            'new_properties_id', 'construction_status','property_tags'
        ];

        $propertyData = [];
        foreach ($propertyFields as $field) {
            if (isset($data[$field])) {
                $propertyData[$field] = $data[$field];
            }
        }

        // Insert property
        $property_id = $this->Api_model->add_data_in_table($propertyData, 'properties');

        if (!$property_id) {
            $return['message'] = 'Failed to insert property';
            return $this->response($return, REST_Controller::HTTP_OK);
        }

        // Property meta table fields
        $metaFields = [
            'floor_no', 'total_floors', 'property_age', 'kothi_story_type', 'furnishing_status',
            'ownership_type', 'gated_community', 'available_from', 'has_lift', 'parking_available',
            'commercial_approval', 'width_length', 'road_width', 'commercial_useType',
            'shutters_count', 'roof_height', 'loading_bay', 'locality', 'landmark', 'direction',
            'facing', 'in_society', 'hospital_type', 'floor_available', 'medical_facilities',
            'hospital_license', 'possession_status', 'map_link','other_property_type'
        ];

        $metaData = ['properties_id' => $property_id];
        foreach ($metaFields as $field) {
            if (isset($data[$field])) {
                $metaData[$field] = $data[$field];
            }
        }

        // Insert property meta
        $this->Api_model->add_data_in_table($metaData, 'properties_meta');

        $return['status'] = 'done';
        $return['message'] = 'Property saved successfully';
      // $return['result'] = ['property_id' => $property_id];

        return $this->response($return, REST_Controller::HTTP_OK);
    }

  public function editProperty_post()
{
    $return = array('status' => 'error', 'message' => 'Missing required fields', 'result' => '');

    // Read property ID
    $property_id = $this->input->post('id');
    if (!$property_id) {
        $return['message'] = "Missing required field: property ID.";
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // Handle image uploads
    $imageFields = ['image_one', 'image_two', 'image_three', 'image_four'];
    $uploadPath = './assets/properties/';
    $allowedTypes = 'jpg|jpeg|png|webp';

    $this->load->library('upload');

    foreach ($imageFields as $field) {
        $oldImage = $this->input->post($field . '_old');  // hidden input: image_one_old

        if (!empty($_FILES[$field]['name'])) {
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = $allowedTypes;
            $config['file_name'] = time() . '_' . basename($_FILES[$field]['name']);

            $this->upload->initialize($config);

            if ($this->upload->do_upload($field)) {
                $uploadData = $this->upload->data();
                $uploadedFileName = $uploadData['file_name'];

                $this->db->set($field, $uploadedFileName);

                // Delete old image if needed
                if (!empty($oldImage) && file_exists($uploadPath . $oldImage)) {
                    unlink($uploadPath . $oldImage);
                }
            }
        } else {
            if (!empty($oldImage)) {
                $this->db->set($field, $oldImage);
            }
        }
    }

    // Property table fields (without built & land, handle separately)
    $propertyFields = [
        'userid', 'name', 'property_builder', 'description', 'property_for', 'project_n',
        'carpet', 'additional', 'additional_value', 'address', 'person',
        'phone', 'person_address', 'city', 'state', 'property_type', 'category', 'zip_code',
        'bhk', 'budget', 'budget_in_words', 'amenities', 'type',
        'status', 'approvel', 'show_in_slider', 'show_in_gallery',
        'icon', 'bathrooms', 'bedrooms', 'sqft', 'measureUnit', 'services', 'verified',
        'residential', 'commercial', 'hot_deals', 'clone_id', 'main_site', 'lead_id',
        'new_properties_id', 'construction_status'
    ];

    foreach ($propertyFields as $field) {
        $value = $this->input->post($field);
        if ($value !== null) {
            $this->db->set($field, $value);
        }
    }

// ✅ Custom handling for land (plot area)
$plot_area = trim($this->input->post('kothi_plot_area'));
$plot_unit = strtolower(trim($this->input->post('kothi_plot_area_unit')));

if ($plot_area !== '' && $plot_unit !== '') {
    $allowed_units = ['sq.yard','marla','kanal'];
    if (!in_array($plot_unit, $allowed_units)) {
        $plot_unit = 'sq.yard'; // fallback
    }
    // अब दोनों को जोड़कर एक ही field में save करो
    $this->db->set('land', $plot_area . ' ' . $plot_unit);
}

// ✅ Custom handling for built (covered area)
$covered_area = trim($this->input->post('kothi_covered_area'));
$covered_unit = strtolower(trim($this->input->post('kothi_covered_area_unit')));

if ($covered_area !== '' && $covered_unit !== '') {
    $allowed_units = ['sq.yard','marla','kanal'];
    if (!in_array($covered_unit, $allowed_units)) {
        $covered_unit = 'sq.yard';
    }
    $this->db->set('built', $covered_area . ' ' . $covered_unit);
}



    // Update the `properties` table
    $this->db->where('id', $property_id);
    $this->db->update('properties');

    // Property meta fields
    $metaFields = [
        'floor_no', 'total_floors', 'property_age', 'kothi_story_type', 'furnishing_status',
        'ownership_type', 'gated_community', 'available_from', 'has_lift', 'parking_available',
        'commercial_approval', 'width_length', 'road_width', 'commercial_useType',
        'shutters_count', 'roof_height', 'loading_bay', 'locality', 'landmark', 'direction',
        'facing', 'in_society', 'hospital_type', 'floor_available', 'medical_facilities',
        'hospital_license', 'possession_status', 'map_link','other_property_type'
    ];

    $metaData = [];
    foreach ($metaFields as $field) {
        $value = $this->input->post($field);
        if ($value !== null) {
            $metaData[$field] = $value;
        }
    }

    if (!empty($metaData)) {
        $this->db->where('properties_id', $property_id);
        $this->db->update('properties_meta', $metaData);
    }

    $return['status'] = 'done';
    $return['message'] = 'Property updated successfully';
    return $this->response($return, REST_Controller::HTTP_OK);
}



public function deleteProperty_post()
{
    $return = array('status' => 'error', 'message' => 'Missing required field: property ID', 'result' => '');

    // Try POST param first
    $property_id = $this->input->post('id');
    

    // If not found, try JSON body
    if (!$property_id) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        if (isset($data['id'])) {
            $property_id = $data['id'];
        }
    }

    if (!$property_id) {
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // Delete records
    $this->Api_model->delete('properties_id', $property_id, 'properties_meta');
    $this->Api_model->delete('id', $property_id, 'properties');

    $return['status'] = 'done';
    $return['message'] = 'Property deleted successfully';
    return $this->response($return, REST_Controller::HTTP_OK);
}



}
