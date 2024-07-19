<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Queue_model');
    }

    public function services() {
        $data['services'] = $this->Queue_model->get_services();
        $this->load->view('admin_services', $data);
    }

    public function add_service() {
        $name = $this->input->post('name');
        $this->db->insert('services', array('name' => $name));
        redirect('admin/services');
    }

    public function edit_service($id) {
        $name = $this->input->post('name');
        $this->db->where('id', $id);
        $this->db->update('services', array('name' => $name));
        redirect('admin/services');
    }

    public function delete_service($id) {
        $this->db->where('id', $id);
        $this->db->delete('services');
        redirect('admin/services');
    }

    public function manage_queue() {
        $data['queues'] = $this->db->select('queue.id, queue.user_id, queue.queue_number, queue.service_id, services.name as service_name')
                                   ->from('queue')
                                   ->join('services', 'queue.service_id = services.id', 'left')
                                   ->get()
                                   ->result();
        $data['services'] = $this->Queue_model->get_services();
        $this->load->view('admin_queue_manage', $data);
    }

    public function update_queue_service() {
        $queue_id = $this->input->post('queue_id');
        $service_id = $this->input->post('service_id');
        $this->Queue_model->update_queue_service($queue_id, $service_id);
        redirect('admin/manage_queue');
    }
}
