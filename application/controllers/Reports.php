<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	function __construct() {
        parent::__construct();
        if (!sess('user_id') && sess('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('system');
        $this->load->model('administration');
        $this->load->model('billing_model');
    }
    public function index($type = 1) {
        $this->load->layout = 'dashboard';
        $title = "Manage Reports";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'reports';
        $render_data['menu'] = 'report_' . $type;
        $render_data['header_title'] = $title;
        $this->load->template('reports/reports', $render_data);
    }
    public function royalty_reports() {
    	$this->load->layout = 'dashboard';
        $title = "Royalty Reports";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'reports';
        $render_data['menu'] = 'royalty_report';
        $render_data['header_title'] = $title;
        $this->load->template('reports/royalty_reports', $render_data);	
    }
    public function load_royalty_reports_data() {
    	$render_data['royalty_reports_data'] = $this->billing_model->royalty_reports_data();
    	$this->load->view('reports/load_royalty_reports_data',$render_data);
    }

}
