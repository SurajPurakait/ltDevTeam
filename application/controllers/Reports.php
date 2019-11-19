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
        $result = $this->billing_model->royalty_reports_data();
        echo json_encode($result);
    }
    public function get_royalty_reports_data() {
    	if (post('ofc') != '') {
    		$office_id = post('ofc');
    	} else {
    		$office_id = '';
    	}
    	if (post('daterange') != '') {
    		$daterange = post('daterange');
    	} else {
    		$daterange = '';
    	}
    	
    	$result = $this->billing_model->get_royalty_reports_data($office_id,$daterange);	
        echo json_encode($result);
    }
    

}
