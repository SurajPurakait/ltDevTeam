<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_log extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('administration');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Manage Log";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'manage_log';
        $render_data['header_title'] = $title;
        $this->load->template('administration/manage_log', $render_data);
    }

    public function load_staff_data() {
//        $action = request('action');
        $render_data['log_list'] = $this->administration->get_log_info();
        $this->load->view('administration/manage_log_ajax', $render_data);
    }

}
