<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Queue_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_queues() {
        $this->db->select('queue.*, users.username, services.name as service_name');
        $this->db->from('queue');
        $this->db->join('users', 'queue.user_id = users.id', 'left');
        $this->db->join('services', 'queue.service_id = services.id', 'left');
        $this->db->where('queue.status', 'waiting');
        $this->db->order_by('queue.queue_number', 'ASC');
        return $this->db->get()->result();
    }

    public function get_queue_history() {
        $this->db->select('queue.*, users.username');
        $this->db->from('queue');
        $this->db->join('users', 'queue.user_id = users.id');
        $this->db->where('queue.status', 'served');
        $this->db->order_by('queue.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_next_queue_number() {
        $this->db->select_max('queue_number');
        $result = $this->db->get('queue')->row();
        return $result->queue_number + 1;
    }

    public function get_last_queue_number() {
        $this->db->select_max('queue_number');
        $result = $this->db->get('queue')->row();
        return $result->queue_number;
    }
/*
    public function get_my_queue_number($user_id) {
        $this->db->select('queue_number');
        $this->db->from('queue');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'waiting');
        $result = $this->db->get()->row();
        return $result ? $result->queue_number : null;
    }
*/
public function get_my_queue_number($user_id) {
    $this->db->select('queue.*, services.name as service_name');
    $this->db->from('queue');
    $this->db->join('services', 'queue.service_id = services.id', 'left');
    $this->db->where('queue.user_id', $user_id);
    $this->db->where('queue.status', 'waiting');
    return $this->db->get()->row();
}
    public function add_to_queue($user_id, $queue_number, $service_id) {
        $data = array(
            'user_id' => $user_id,
            'queue_number' => $queue_number,
            'status' => 'waiting',
            'service_id' => $service_id
        );
        return $this->db->insert('queue', $data);
    }

    public function get_services() {
        return $this->db->get('services')->result();
    }

    public function get_queue_by_user($user_id) {
        $this->db->select('queue.*, services.name as service_name');
        $this->db->from('queue');
        $this->db->join('services', 'queue.service_id = services.id', 'left');
        $this->db->where('queue.user_id', $user_id);
        return $this->db->get()->row();
    }

    public function update_queue_service($queue_id, $service_id) {
        $this->db->where('id', $queue_id);
        $this->db->update('queue', array('service_id' => $service_id));
    }

    public function serve_queue($id) {
        $this->db->where('id', $id);
        return $this->db->update('queue', array('status' => 'served'));
    }

    public function update_queue_number($id, $queue_number) {
        $this->db->where('id', $id);
        return $this->db->update('queue', array('queue_number' => $queue_number));
    }

    public function delete_queue($id) {
        $this->db->where('id', $id);
        return $this->db->delete('queue');
    }

    public function move_to_end($id) {
        $next_queue_number = $this->get_next_queue_number();
        $this->db->where('id', $id);
        return $this->db->update('queue', array('queue_number' => $next_queue_number));
    }
}
