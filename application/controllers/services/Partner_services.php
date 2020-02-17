<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_services extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model("service_model");
        $this->load->model('lead_management');
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Partner Services";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'partner_services';
        $render_data['header_title'] = $title;
        $this->load->template('services/partner_services', $render_data);
    }

    public function create_mortgages_and_lending() {
        $this->load->layout = 'dashboard';
        $title = "Create Mortgages And Lending";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'partner_services';
        $render_data['header_title'] = $title;
        $render_data['client_type'] = 1;
        $render_data['mortgages_list'] = $this->service_model->get_mortgages_list();
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['client_id'] = '';
        $render_data['all_partners_list'] = $this->lead_management->get_all_partners_list();
        $this->load->template('services/create_mortgages_and_lending', $render_data);
    }

    public function get_related_section_by_type() {
        $client_type = post('client_type'); // 1: business 2: Individual
        $render_data['reference_id'] = post('reference_id');
        $render_data['client_id'] = post('client_id');
        if ($client_type == '1') {
            $render_data['reference'] = 'company';
            $render_data['client_type'] = $client_type;
        } else {
            $render_data['reference'] = 'individual';
            $render_data['client_type'] = $client_type;
        }
        $this->load->view('services/partner_services_type'.$client_type,$render_data);
    }
    
    public function request_create_mortgages() {
        $result = $this->service_model->request_create_mortgages(post());
        if($result){
            echo $result;
        } else {
           echo 0; 
        }
    }
}

?>