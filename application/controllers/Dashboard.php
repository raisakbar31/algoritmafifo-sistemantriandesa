<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function admin() {
        $this->load->view('dashboard/admin');
    }

    public function user() {
        $this->load->view('dashboard/user');
    }
}
