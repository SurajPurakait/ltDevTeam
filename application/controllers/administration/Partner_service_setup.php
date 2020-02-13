<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_service_setup extends CI_Controller
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
        $title = "Partner Service Setup";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'partner_service_setup';
        $render_data['header_title'] = $title;
        $this->load->template('administration/partner_service_setup', $render_data);
    }
}    