<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Queue extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Queue_model');
        $this->load->model('User_model');
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function index() {
        $data['queues'] = $this->Queue_model->get_all_queues();
        $data['queue_history'] = $this->Queue_model->get_queue_history();
        $data['last_queue_number'] = $this->Queue_model->get_last_queue_number();
        $data['my_queue_number'] = $this->Queue_model->get_my_queue_number($this->session->userdata('user_id'));

        $data['services'] = $this->Queue_model->get_services();
        $data['queues'] = $this->Queue_model->get_all_queues(); // Pastikan ada metode untuk mendapatkan semua antrian

        $this->load->view('queue/index', $data);
    }

    public function add() {
        $data['services'] = $this->Queue_model->get_services();
        $this->load->view('queue_add', $data);
    }

    public function create() {
        $user_id = $this->input->post('user_id');
        $service_id = $this->input->post('service_id');
        $queue_number = $this->Queue_model->get_next_queue_number();
        $this->Queue_model->add_to_queue($user_id, $queue_number, $service_id);
        redirect('queue');
    }

    public function view() {
        $user_id = $this->session->userdata('user_id');
        $data['queues'] = $this->Queue_model->get_all_queues();
        $data['queue_history'] = $this->Queue_model->get_queue_history($user_id);
        $data['last_queue_number'] = $this->Queue_model->get_next_queue_number() - 1;
        $data['my_queue_number'] = $this->Queue_model->get_queue_number_by_user($user_id);

        // Pastikan ini mengembalikan data dengan service_name
        $data['my_queue'] = $this->Queue_model->get_queue_by_user($user_id); 

        $this->load->view('queue_view', $data);
    }

    public function serve($id) {
        $this->Queue_model->serve_queue($id);
        redirect('queue');
    }

    public function set_queue_number($id) {
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard/user');
        }

        $queue_number = $this->input->post('queue_number');
        if ($this->Queue_model->update_queue_number($id, $queue_number)) {
            $this->session->set_flashdata('success', 'Nomor urut berhasil diubah.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah nomor urut.');
        }
        redirect('queue');
    }

    public function delete_queue($id) {
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard/user');
        }

        if ($this->Queue_model->delete_queue($id)) {
            $this->session->set_flashdata('success', 'Nomor urut berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus nomor urut.');
        }
        redirect('queue');
    }

    public function move_to_end($id) {
        if ($this->Queue_model->move_to_end($id)) {
            $this->session->set_flashdata('success', 'Nomor urut berhasil dipindahkan ke akhir.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memindahkan nomor urut ke akhir.');
        }
        redirect('queue');
    }
}
