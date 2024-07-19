<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->User_model->login($username, $password);

            if ($user) {
                $this->session->set_userdata('user_id', $user->id);
                $this->session->set_userdata('role', $user->role);

                if ($user->role == 'admin') {
                    redirect('dashboard/admin');
                } else {
                    redirect('dashboard/user');
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
                redirect('login');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role');
        redirect('login');
    }
}
