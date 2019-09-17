<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Business_client extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('administration');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    function index() {
        $this->load->layout = 'dashboard';
        $title = "Sales Tax Rate";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'business_client';
        $render_data['header_title'] = $title;
        $render_data['business_client'] = $this->administration->get_business_client();
        $this->load->template('administration/business_client', $render_data);
    }

    function add_business_client() {
        $data = array(
            'state' => post('state'),
            'name' => post("client_name"),
            'rate' => post('client_rate'),
            'due_date' => date('Y-m-d', strtotime(post('due_date')))
        );
//        $check = $this->administration->check_if_business_client_exists($company_name);
        if ($this->administration->add_business_client($data)) {
            echo "1";
        } else {
            echo "0";
        }
    }

    function edit_business_client() {
        $client_id = post('client_id');
        $data = array(
            'state'=> post('state'),
            'name' => post("client_name"),
            'rate' => post('client_rate'),
            'due_date' => date('Y-m-d', strtotime(post('due_date')))
        );
        if ($this->administration->update_business_client($data, $client_id)) {
            echo "1";
        } else {
            echo "0";
        }
    }

    function delete_business_client() {
        $client_id = post("client_id");
        if ($this->administration->delete_business_client($client_id)) {
            echo "1";
        } else {
            echo "0";
        }
    }

}
