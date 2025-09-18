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

public function getProperty_get()
{
    $this->load->database();

    // Fetch all properties
    $this->db->select('
        p.id,
        p.name,
        p.type,
        p.phone,
        p.budget,
        p.budget_in_words,
        p.property_type,
        p.address,
        p.created_at,
        p.bathrooms,
        p.amenities,
        p.bedrooms,
        p.sqft,
        p.measureUnit,
        p.verified,
        p.city,
        CONCAT("' . base_url() . 'assets/properties/", p.image_one) as image
    ');
    $this->db->from('properties p');
    $this->db->where('p.status', 'active');
    $this->db->order_by('p.id', 'DESC');

    $query = $this->db->get();
    $properties = $query->result_array();

    if (empty($properties)) {
        $return['message'] = 'No Properties found';
    } else {
        foreach ($properties as &$item) {
            // Generate unique_id
            $cityPrefix = substr(preg_replace('/\s+/', '', strtolower($item['city'] ?? 'MO')), 0, 2);
            $item['unique_id'] = strtoupper($cityPrefix . $item['id']);

            // ✅ Fetch related meetings
            $this->db->select('
                m.id,
                m.lead_id,
                m.comment,
                m.offer,
                m.purpose,
                m.location,
                m.outcome,
                m.meeting_date,
                m.status,
                m.next_step,
                m.user_id,
                m.property_id
            ');
            $this->db->from('meetings m');
            $this->db->like('m.property_id', '"' . $item['id'] . '"');
            $meetingsQuery = $this->db->get();
            $meetings = $meetingsQuery->result_array();

            // ✅ Add buyer info for each meeting
            foreach ($meetings as &$meeting) {
                $this->db->select('uName, mobile, email,preferred_location,budget');
                $this->db->from('buyers');
                $this->db->where('id', $meeting['lead_id']);
                $buyerQuery = $this->db->get();
                $buyer = $buyerQuery->row_array();

                if ($buyer) {
                    $meeting['buyer'] = [
                        'name'  => $buyer['uName'],
                        'phone' => $buyer['mobile'],
                        'email' => $buyer['email'],
                        'preferred_location'=>$buyer['preferred_location'],
                        'budget'=>$buyer['budget']
                    ];
                } else {
                    $meeting['buyer'] = null;
                }
            }

            // Attach meetings under property
            $item['meetings'] = $meetings;
        }

        $return['result'] = $properties;
    }

    $this->response($return, REST_Controller::HTTP_OK);
}



public function getUserProperty_get()
{
    $this->load->database();
    $userId = $this->input->get('userid'); 

    $this->db->select('
        p.id,
        p.name,
        p.type,
        p.phone,
        p.budget,
        p.budget_in_words,
        p.property_type,
        p.address,
        p.created_at,
        p.bathrooms,
        p.amenities,
        p.bedrooms,
        p.sqft,
        p.measureUnit,
        p.verified,
        p.city,
        p.userid,
        CONCAT("' . base_url() . 'assets/properties/", p.image_one) as image
    ');
    $this->db->from('properties p');
    $this->db->where('p.status', 'active');

    // ✅ Only properties added by this user
    if (!empty($userId)) {
        $this->db->where('p.userid', $userId);
    }

    $this->db->order_by('p.id', 'DESC');
    $query = $this->db->get();
    $properties = $query->result_array();

    if (empty($properties)) {
        $return['message'] = 'No Properties found for this user';
    } else {
        foreach ($properties as &$item) {
            // Generate unique_id
            $cityPrefix = substr(preg_replace('/\s+/', '', strtolower($item['city'] ?? 'MO')), 0, 2);
            $item['unique_id'] = strtoupper($cityPrefix . $item['id']);

            // ✅ Fetch related meetings
            $this->db->select('
                m.id,
                m.lead_id,
                m.comment,
                m.offer,
                m.purpose,
                m.location,
                m.outcome,
                m.meeting_date,
                m.status,
                m.next_step,
                m.user_id,
                m.property_id
            ');
            $this->db->from('meetings m');
            $this->db->like('m.property_id', '"' . $item['id'] . '"');
            $meetingsQuery = $this->db->get();
            $meetings = $meetingsQuery->result_array();

            // ✅ Add buyer info for each meeting
            foreach ($meetings as &$meeting) {
                $this->db->select('uName, mobile, email, preferred_location, budget');
                $this->db->from('buyers');
                $this->db->where('id', $meeting['lead_id']);
                $buyerQuery = $this->db->get();
                $buyer = $buyerQuery->row_array();

                $meeting['buyer'] = $buyer ? [
                    'name'  => $buyer['uName'],
                    'phone' => $buyer['mobile'],
                    'email' => $buyer['email'],
                    'preferred_location' => $buyer['preferred_location'],
                    'budget' => $buyer['budget']
                ] : null;
            }

            // Attach meetings under property
            $item['meetings'] = $meetings;
        }

        $return['result'] = $properties;
    }

    $this->response($return, REST_Controller::HTTP_OK);
}

















    /** Add Property API **/
public function addAdminProperty_post()
{
    $return = ['status' => 'error', 'message' => 'Missing required fields', 'result' => ''];

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

    // ---- Collect Property Fields ----
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

    // ---- User ID ----
    $userid = $this->input->post('userid', true);
    if (empty($userid) && isset($this->session) && method_exists($this->session, 'userdata')) {
        $userid = $this->session->userdata('id');
    }
    if (empty($userid)) {
        $headerUserId = $this->input->get_request_header('X-User-Id', true);
        if (!empty($headerUserId)) {
            $userid = $headerUserId;
        }
    }
    if (!empty($userid)) {
        $data['userid'] = $userid;
    }

    // ---- Copy property fields ----
    foreach ($propertyFields as $field) {
        $val = $this->input->post($field);
        if ($val !== null && $val !== '') {
            $data[$field] = $val;
        }
    }

    // ---- Merge uploaded images ----
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
        'hospital_license','possession_status','map_link','other_property_type'
    ];

    $metaData = ['properties_id' => $property_id];
    foreach ($metaFields as $field) {
        $val = $this->input->post($field);
        if ($val !== null && $val !== '') {
            $metaData[$field] = $val;
        }
    }

    $this->db->insert('properties_meta', $metaData);

   // ---- Insert into property_tags_tb ----
$propertyTags = $this->input->post('property_tags');
if (!empty($propertyTags) && !empty($userid)) {
    // agar tags "~-~" ke sath aaye hain to uske hisab se split karlo
    if (strpos($propertyTags, '~-~') !== false) {
        $tagsArray = explode('~-~', $propertyTags);
    } else {
        $tagsArray = explode(',', $propertyTags);
    }

    foreach ($tagsArray as $tag) {
        $tag = trim($tag);
        if ($tag !== '') {
            // check karo tag already exist karta hai ya nahi
            $this->db->where('tags', $tag);
            $query = $this->db->get('property_tags_tb');

            if ($query->num_rows() == 0) {
                // agar exist nahi karta tabhi insert
                $this->db->insert('property_tags_tb', [
                    
                    'tags'   => $tag
                ]);
            }
        }
    }
}



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
            'new_properties_id', 'construction_status'
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
        'new_properties_id', 'construction_status','property_tags'
    ];

    foreach ($propertyFields as $field) {
        $value = $this->input->post($field);
        if ($value !== null) {
            $this->db->set($field, $value);
        }
    }


    $plot_area = trim($this->input->post('kothi_plot_area'));
    $plot_unit = strtolower(trim($this->input->post('kothi_plot_area_unit')));
    
    if ($plot_area !== '' && $plot_unit !== '') {
        $allowed_units = ['sq.yard','marla','kanal'];
        if (!in_array($plot_unit, $allowed_units)) {
            $plot_unit = 'sq.yard';
        }
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
    
    // ✅ Update property_tags_tb also
 $propertyTags = $this->input->post('property_tags');

if (!empty($propertyTags)) {
    if (strpos($propertyTags, '~-~') !== false) {
        $tagsArray = explode('~-~', $propertyTags);
    } else {
        $tagsArray = explode(',', $propertyTags);
    }

    foreach ($tagsArray as $tag) {
        $tag = trim($tag); // white space hatao
        $tag = ucwords(strtolower($tag)); // normalize: 1bhk -> 1Bhk

        if ($tag !== '') {
            // check karo normalized tag already exist karta hai ya nahi
            $this->db->where('tags', $tag);
            $query = $this->db->get('property_tags_tb');

            if ($query->num_rows() == 0) {
                $this->db->insert('property_tags_tb', [
                    'tags' => $tag
                ]);
            }
        }
    }
}




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

// Controller: Properties.php

public function getTags()
{
    $term = $this->input->get('term'); // user jo type karega
    $this->db->like('tags', $term);
    $query = $this->db->get('property_tags_tb');
    $result = $query->result();

    $tags = [];
    foreach ($result as $row) {
        $tags[] = $row->tags;
    }

    echo json_encode($tags); // frontend ko array bhej do
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

public function fetchTags_post()
{
    $term = $this->input->post('term');

    $this->load->model('Api_model');
    $tags = $this->Api_model->searchTags($term);

    echo json_encode($tags);
}





}
