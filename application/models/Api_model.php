<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
 	function getRecordByColumn($where,$value,$table,$columns='*') {
		$this->db->select($columns);
		$this->db->from($table);
		$this->db->where($where,$value);
		$query = $this->db->get();
		$data = FALSE;
        if($query !== FALSE && $query->num_rows() > 0){
            $data = $query->result_array();
        }
		return $data;
	} 
	
	public function getRecordsByWhereIn($where, $ids, $table, $columns = '*')
	{
			$this->db->select($columns);
			$this->db->from($table);
			$this->db->where_in($where, $ids);
			$data = $this->db->get();
			if($data == FALSE){ return array(); } 
			else { return $data->result_array(); }
	}
	
	public function get_tasks_with_conditions($type, $status = '', $today = '') {
        //$today = date('Y-m-d 00:00:01'); 
        $this->db->select('leads_comment.*,buyers.uName,  buyers.preferred_location, buyers.budget,buyers.mobile');
        $this->db->from('leads_comment');
        $this->db->join('buyers', 'leads_comment.leadId = buyers.id', 'left');
    
        $this->db->where('leads_comment.choice', $type);
        
        if ($today != '') { 
            $this->db->where('leads_comment.nextdt >=', $today); 
        }
        
        if($status != ''){
            $this->db->where('leads_comment.status', $status);
        }
    
        $this->db->order_by('leads_comment.nextdt', 'DESC');
    
        $query = $this->db->get();
        return $query->result_array();
    }
	
	
	function getRecordByMultipleColumn($where,$table,$columns='*',$sort='',$orderby='',$limit='') {
		$this->db->select($columns);
		$this->db->from($table);
		 $where['status'] = 'active';
		$this->db->where($where);
		if($sort != '') { $this->db->order_by($sort, $orderby); }
		if($limit != '') { $this->db->limit($limit); }
		$query = $this->db->get();
		$data = FALSE;
        if($query !== FALSE && $query->num_rows() > 0){
            $data = $query->result_array();
        }
		return $data;
	} 
	
	function getRecordByColumnService($where, $value, $additionalWhere, $additionalValue, $table, $columns = '*') {
		$this->db->select($columns);
		$this->db->from($table);
		$this->db->where($where, $value);
		$this->db->where($additionalWhere, $additionalValue);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$data = FALSE;

		if ($query !== FALSE && $query->num_rows() > 0) {
			$data = $query->result_array();
		}

		return $data;
    }
    
	function updateTable($where,$value,$table,$data) {
	    $this->db->where($where, $value);
        $this->db->update($table, $data);
        return true;
	}
    function delete($where,$value,$table) {
        $this->db->where($where, $value);
        $this->db->delete($table); 
        return true;
    }
    function add_data_in_table($data,$table) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
function add_data_in_tables($table, $data) {
    $this->db->insert($table, $data);
    return $this->db->insert_id();
}

    
/*function for get values with image url*/

     public function getPropertywithImages($id) {
        $this->db->select('*');  
        $this->db->from('properties');
        $this->db->where('id', $id);
        $this->db->where('status', 'active');
        $query = $this->db->get();
        //$query = $this->db->get('properties'); 

        if ($query->num_rows() > 0) {
        $data = $query->result_array();

        foreach ($data as &$row) {
            
        $row['image_one_url'] = $this->get_image_url($row['image_one']);
        $row['image_two_url'] = $this->get_image_url($row['image_two']);
        $row['image_three_url'] = $this->get_image_url($row['image_three']);
        $row['image_four_url'] = $this->get_image_url($row['image_four']);
            }
        return $data;
        }
        return array(); 
        }

     private function get_image_url($image_name) {
        if($image_name){
        $image_url = base_url('assets/properties/' . $image_name);
        return $image_url;
         }
        }
        
public function getAdditionalPropertiesByType($propertyType, $currentId, $limit = 3)
{
    $this->db->where('property_type', $propertyType);
    $this->db->where('id !=', $currentId);
    $this->db->where('status', 'active');
    $this->db->limit($limit);
    $query = $this->db->get('properties');

     if ($query->num_rows() > 0) {
        $data = $query->result_array();

        foreach ($data as &$row) {
            
        $row['image_one_url'] = $this->get_image_url($row['image_one']);
        $row['image_two_url'] = $this->get_image_url($row['image_two']);
        $row['image_three_url'] = $this->get_image_url($row['image_three']);
        $row['image_four_url'] = $this->get_image_url($row['image_four']);
            }
        return $data;
        }
        return array(); 
        }
        public function fetch_upcoming_projects() {
        $this->db->select('Images, Min_Budget, Project_Name, Max_Budget');
        $this->db->from('Properties_Projects');
        $this->db->where('Upcoming_Projects', 'yes');
        $query = $this->db->get();
        return $query->result_array();
    }
    
public function get_meeting_list() {
    return $this->db->get('meetings')->result_array();
}


 public function insertData($table, $data){
    return $this->db->insert($table, $data);
}

public function searchTags($term)
{
    $this->db->select('property_tags');
    $this->db->from('property_tags_tb');
    $this->db->like('property_tags', $term);
    $query = $this->db->get();

    $result = $query->result_array();
    $finalTags = [];

    foreach ($result as $row) {
        $tags = explode("~-~", $row['property_tags']);
        foreach ($tags as $t) {
            $t = trim($t);
            if (stripos($t, $term) !== false) {
                $finalTags[] = $t;
            }
        }
    }

    return $finalTags;
}

public function getAllMeetingsWithProperties($userId = null)
{
    
    if ($userId) {
        $this->db->where('user_id', $userId);
    }

    $meetings = $this->db->get('meetings')->result();

    foreach ($meetings as &$meeting) {
        // 🔹 Properties fetch
        if (!empty($meeting->property_id)) {
            $decoded = json_decode($meeting->property_id, true);
            $props = [];

            if (is_array($decoded)) {
                foreach ($decoded as $p) {
                    $propId = isset($p['id']) ? $p['id'] : null;
                    if ($propId) {
                        $propQuery = $this->db->select('id, name, phone, person_address, person, image_one')
                                              ->from('properties')
                                              ->where('id', $propId)
                                              ->get()
                                              ->row_array();
                        if ($propQuery) {
                            $props[] = $propQuery;
                        }
                    }
                }
            }
            $meeting->properties_detail = $props;
        } else {
            $meeting->properties_detail = [];
        }

        // 🔹 Buyer fetch
        if (!empty($meeting->lead_id)) {
            $buyer = $this->db->select('id, budget, preferred_location, uName, mobile')
                              ->from('buyers')
                              ->where('id', $meeting->lead_id)
                              ->get()
                              ->row_array();
            $meeting->buyer_detail = $buyer ? $buyer : new stdClass();
        } else {
            $meeting->buyer_detail = new stdClass();
        }
    }

    return $meetings;
}




private function isJson($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

public function addDataInTable($data, $table)
{
    $this->db->insert($table, $data);
    return $this->db->insert_id();
}



/**
 * Fetch meetings for multiple lead IDs in one query
 * and return them grouped by lead_id:
 *  [ lead_id => [ meeting1, meeting2, ... ], ... ]
 */
// ✅ Fetch all meetings grouped by lead_id
public function getMeetingsByLeadIds($leadIds = [])
{
    if (empty($leadIds)) {
        return [];
    }

    $this->db->select('*');
    $this->db->from('meetings');
    $this->db->where_in('lead_id', $leadIds);
    $query = $this->db->get();

    $meetings = $query->result_array();
    $grouped = [];

    foreach ($meetings as $m) {
        $grouped[$m['lead_id']][] = $m;
    }

    return $grouped;
}

// ✅ Fetch property safely by ID
public function getPropertyById($propertyId)
{
    $propertyId = intval(trim($propertyId));
    if ($propertyId <= 0) {
        return null;
    }

    $this->db->select('id, name, property_builder, city, state, budget, phone, bhk, sqft, bathrooms, bedrooms, status, image_one');
    $this->db->from('properties');
    $this->db->where('id', $propertyId);
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->row_array() : null;
}

// Fetch multiple properties with only required fields
public function getPropertiesByIds($ids = [])
{
    if (empty($ids)) {
        return [];
    }

    $this->db->select('id, name,address,person, budget, phone');
    $this->db->from('properties');
    $this->db->where_in('id', $ids);
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->result_array() : [];
}


public function getCommentsByLeadId($leadId)
{
    $this->db->select('leadId, comment, nextdt, choice, userId');
    $this->db->from('leads_comment');
    $this->db->where('leadId', $leadId);
    $query = $this->db->get();
    return $query->result_array();
}
public function getMatchingProperties($lead) {
    $this->db->select('p.*');
    $this->db->from('properties p');

    // Sirf active properties fetch karo
    $this->db->where('p.status', 'active');

    // Property type condition
    if (!empty($lead->propertyType)) {
        $this->db->where('p.category', $lead->propertyType);
    }

    // Budget condition
    if (isset($lead->max_budget) && $lead->max_budget > 0) {
        $budgetInWords = $this->convertNumberToWords($lead->max_budget);
        $minBudget = $lead->max_budget - ($lead->max_budget * 0.15);
        $maxBudget = $lead->max_budget + ($lead->max_budget * 0.15);

        $this->db->group_start(); 
        $this->db->where('p.budget', $lead->max_budget);
        $this->db->or_where('p.budget_in_words', $budgetInWords);
        $this->db->or_where("p.budget BETWEEN {$minBudget} AND {$maxBudget}");
        $this->db->group_end();
    }

    // Exclude deals only for this lead
    if (!empty($lead->deal)) {
        $dealIds = explode(',', $lead->deal); 
        $dealIds = array_map('trim', $dealIds); 
        if (!empty($dealIds)) {
            $this->db->where_not_in('p.id', $dealIds);
        }
    }

    // Random 4 properties
    $this->db->order_by('RAND()');
    $this->db->limit(5);

    $query = $this->db->get();
    return $query->result();
}


private function convertNumberToWords($number) {
    $words = "";
    if ($number >= 10000000) {
        $crore = floor($number / 10000000);
        $words .= $crore . " Crore";
        $number %= 10000000;
    }
    if ($number >= 100000) {
        $lakh = floor($number / 100000);
        $words .= ($words ? " " : "") . $lakh . " Lakh";
        $number %= 100000;
    }
    if ($number >= 1000) {
        $thousand = floor($number / 1000);
        $words .= ($words ? " " : "") . $thousand . " Thousand";
        $number %= 1000;
    }
    if ($number > 0) {
        $words .= ($words ? " " : "") . $number;
    }
    return $words;
}
public function getDataByMultipleColumns($where, $table, $columns='*', $orderBy='', $orderByValue='asc', $limit=''){
    $this->db->select($columns);
    $this->db->from($table);
    $this->db->where($where);
    if($orderBy != '') { $this->db->order_by($orderBy, $orderByValue); }
    if($limit != '') { $this->db->limit($limit); }
    $query = $this->db->get();
    return $query->result(); 
}
public function insertMultipleDeals($leadId, $propertyIds, $status='Interested'){
    if(empty($propertyIds) || !$leadId) return false;

    foreach($propertyIds as $propertyId){
        // Get property name
        $propertyData = $this->getDataByMultipleColumns(['id'=>$propertyId], 'properties', 'name');
        if(!empty($propertyData)){
            $dataToInsert = [
                'name' => $propertyData[0]->name,
                'lead_id' => $leadId,
                'properties_id' => $propertyId,
                'status' => $status,
                'date' => date('Y-m-d H:i:s')
            ];
            $this->insertData('leadDeal', $dataToInsert);
        }
    }
    return true;
}

// Inside Api_model.php

public function getPropertyDetailsForDeal($propertyId) {
    $propertyId = intval(trim($propertyId));
    if ($propertyId <= 0) {
        return null;
    }

    $this->db->select('id, name, description, address,budget_in_words, city, state,image_one,image_two');
    $this->db->from('properties');
    $this->db->where('id', $propertyId);
    // $this->db->where_in('status', ['active', 'Active', '1']);
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->row_array() : null;
}

public function getAgentForManager($managerId) {
    $this->db->select('*');
    $this->db->from('adminLogin');
    $this->db->where('role', 'Agent');
    $this->db->where('parent_id', $managerId);
    $query = $this->db->get();

    return $query->row(); 
}



}
