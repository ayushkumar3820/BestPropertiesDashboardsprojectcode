<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logincord extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load helpers/libraries/models if needed
    }

    public function index() {
        $this->load->view('login'); // this loads the view file located at application/views/login.php
    }
}
