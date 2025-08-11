<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class MeetingsApi extends CI_Controller {

    public function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->load->helper('url');
			$this->load->model('Api_model');
			
		/*	$checkToken = $this->checkForToken();
			if(!$checkToken) { die(); } */
		}

   

		
		

}