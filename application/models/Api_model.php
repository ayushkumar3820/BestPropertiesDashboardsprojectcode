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

}
