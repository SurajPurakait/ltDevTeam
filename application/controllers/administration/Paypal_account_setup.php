<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal_account_setup extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('administration');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index()
    {
        $this->load->layout = 'dashboard';
        $title = "Paypal Account Setup";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'paypal_account_setup';
        $render_data['header_title'] = $title;
        $render_data['paypal_details'] = $this->administration->paypal_details();
        $this->load->template('administration/paypal_account_setup', $render_data);
    }

    public function insert_paypal_details(){
        echo $this->administration->insert_paypal_details($this->input->post());
    }
}
