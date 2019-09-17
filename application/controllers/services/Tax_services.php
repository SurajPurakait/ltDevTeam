<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_services extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('system');
        $this->load->model('service_model');
        $this->load->model('company_model');
        $this->staff_info = $this->system->get_staff_info(sess('user_id'));
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Tax Services";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'tax_services';
        $render_data['header_title'] = $title;
        $this->load->template('services/tax_services', $render_data);
    }

    public function create_firpta(){
        $this->load->layout = 'dashboard';
        $title = "Create Firpta";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'tax_services';
        $render_data['header_title'] = $title;
        $render_data['service_info'] = $this->service_model->get_service_by_shortname('tax_f');
        $render_data['service_id'] = $render_data['service_info']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_firpta', $render_data);  
    }

    public function save_buyer_info(){ 
        echo $this->service_model->save_buyer_information(post());
    }
    public function buyer_list($id) {
        $render_data['buyer_list'] = $this->service_model->get_buyer_information($id);
        $this->load->view('services/single_buyer_info', $render_data);
    }
    public function buyer_list_order_id() {
        $order_id = post('id');
        $render_data['buyer_list'] = $this->service_model->get_buyer_information_by_order($order_id);
        $this->load->view('services/single_buyer_info', $render_data);
    }
    
    public function delete_buyer_info(){
        if($this->service_model->delete_buyer_info($this->input->post('id'))){
            echo 1;
        }else{
            echo 0;
        }
    }
    public function delete_seller_info(){
        if($this->service_model->delete_seller_info($this->input->post('id'))){
            echo 1;
        }else{
            echo 0;
        }
    }
    
    public function update_buyer($id){ 
        echo $this->service_model->update_buyer_details($id,post());    
    }

    public function save_seller_info(){
        echo $this->service_model->save_seller_information(post());    
    }
    public function seller_list($id) {
        $render_data['seller_list'] = $this->service_model->get_seller_information($id);
        $this->load->view('services/single_seller_info', $render_data);
    }
    public function seller_list_order_id() {
        $order_id = post('id');
        $render_data['seller_list'] = $this->service_model->get_seller_information_by_order($order_id);
        $this->load->view('services/single_seller_info', $render_data);
    }
    
    public function update_seller($id){    
        echo $this->service_model->update_seller_details($id,post());    
    }
    function request_create_firpta() {
        $order_id = $this->company_model->request_create_firpta(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = '');
            echo $order_id;
        } else {
            echo 0;
        }
    }
}