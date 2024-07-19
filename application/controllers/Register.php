<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        $this->load->view('register');
    }

    public function create() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role = 'user'; // Default role

        // Validate and hash the password
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('register');
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            if ($this->User_model->register($username, $hashed_password, $role)) {
                $this->session->set_flashdata('success', 'Akun berhasil dibuat.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat akun.');
                redirect('register');
            }
        }
    }
}
