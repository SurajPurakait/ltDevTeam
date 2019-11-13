<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Business_services extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }

        $this->load->model('system');
        $this->load->model('service_model');
        $this->load->model('company_model');
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Business Services";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'business_services';
        $render_data['header_title'] = $title;
        $this->load->template('services/business_services', $render_data);
    }

    public function create_legal_translations() {
        $this->load->layout = 'dashboard';
        $title = "Legal Translations";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'business_services';
        $render_data['header_title'] = $title;
       $render_data['service_info'] = $this->service_model->get_service_by_shortname('bus_l_t');
        $render_data['service_id'] = $render_data['service_info']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_legal_translations', $render_data);
    }

     public function request_create_legal_translations() {
        $data = post();
        if ($_FILES['doc_file']) {

            $photo = common_upload('doc_file');
            if ($photo['success'] == 1) {
                $data['doc_file'] = $photo['status_msg'];
            }
        }
       
         $order_id=$this->company_model->request_create_legal_translations($data); 
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'business');
            echo $order_id;
        } else {
            echo 0;
        }
         
    } 

}