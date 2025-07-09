<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
require APPPATH . 'libraries/REST_Controller.php';
class Contact extends REST_Controller
{


    public function __construct()
    {

        parent::__construct();
        // $this->load->database();
        $this->load->helper('url');
        $this->load->model('Api_model');
        
        $checkToken = $this->checkForToken();
        if(!$checkToken) { die(); }
    }

    /** add buyers  **/

  public function contact_post()
{
    $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $firstname = removeAllSpecialCharcter($data['firstname'] ?? '');
    $phone = removeAllSpecialCharcter($data['phone'] ?? '');
    $property_id = isset($data['property_id']) ? removeAllSpecialCharcter($data['property_id']) : null;
    $message = $data['subject'] ?? null;
    $subject = $data['selectedValue'] ?? null;
    $email = $data['email'] ?? null;

    if (strlen($firstname) < 3) {
        $return['message'] = 'Name not valid.';
    } elseif (!is_numeric($phone) || strlen($phone) != 10) {
        $return['message'] = 'Phone number is not valid';
    } else {
        // Check for duplicates
        if (!empty($property_id)) {
            $this->db->where('phone', $phone);
            $this->db->where('property', $property_id);
            $query = $this->db->get('contact');
        } else {
            $this->db->where('phone', $phone);
            $query = $this->db->get('contact');
        }

        if ($query->num_rows() > 0) {
            $return['message'] = !empty($property_id)
                ? 'This phone number is already associated with this property.'
                : 'Phone number already exists.';
        } else {
            $addInfo = array(
                'fname' => $firstname,
                'phone' => $phone,
                'message' => $message,
                'email' => $email,
                'subject' => "Interested in " . $subject
            );

            if (!empty($property_id)) {
                $addInfo['property'] = $property_id;
            }

            $this->Api_model->add_data_in_table($addInfo, 'contact');
            $return['result'] = '';
            $return['status'] = 'done';
            $return['message'] = 'Contact added successfully.';
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}
}