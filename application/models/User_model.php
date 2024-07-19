<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function login($username, $password) {
        $this->db->where('username', $username);
        $user = $this->db->get('users')->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            return FALSE;
        }
    }
    public function register($username, $password, $role) {
        $data = array(
            'username' => $username,
            'password' => $password,
            'role' => $role
        );
        return $this->db->insert('users', $data);
    }
}
