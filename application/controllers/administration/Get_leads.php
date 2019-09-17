<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_leads extends CI_Controller
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
        $title = "Get Leads";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'lead_management';
        $render_data['menu'] = 'get_leads';
        $render_data['header_title'] = $title;
        $render_data['all_leads'] = $this->administration->get_leads();
        $this->load->template('administration/get_leads', $render_data);
    }

    public function insert_import_lead(){
        echo $this->administration->insert_import_lead(post());
    }
}
