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
        $this->load->model("service_model");
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
    /* royalty_reports */
    public function royalty_reports() {
    	$this->load->layout = 'dashboard';
        $title = "Royalty Reports";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'reports';
        $render_data['menu'] = 'royalty_report';
        $render_data['header_title'] = $title;
        $this->load->template('reports/royalty_reports', $render_data);	
    }
    /* fetching royalty_reports data*/
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

    /* royalty_reports total calculation */
    public function royalty_reports_totals() {
    	if (post('ofc') != '') {
    		$office = post('ofc');
    	} else {
    		$office = '';
    	}
    	if (post('daterange') != '') {
    		$daterange = post('daterange');
    	} else {
    		$daterange = '';
    	}  
    	$render_data['total_data'] = $this->billing_model->get_total_price_report($office,$daterange);
    	$this->load->view('reports/total_data_report',$render_data);
    }

    /* weekly_sales_report dashboard */
    public function weekly_sales_report() {
        $this->load->layout = 'dashboard';
        $title = "Weekly Sales Reports";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'reports';
        $render_data['menu'] = 'weekly_sales_report';
        $render_data['header_title'] = $title;
        $this->load->template('reports/weekly_sales_report', $render_data);    
    }
    /* fetching weekly_sales_report data */
    public function get_weekly_sales_report_data() {
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
        
        $result = $this->service_model->get_weekly_sales_report_data($office_id,$daterange);    
        echo json_encode($result);
    }
    /* weekly_sales_report total calculation */
    public function weekly_sales_reports_totals() {
        if (post('ofc') != '') {
            $office = post('ofc');
        } else {
            $office = '';
        }
        if (post('daterange') != '') {
            $daterange = post('daterange');
        } else {
            $daterange = '';
        }  
        $render_data['sales_total_data'] = $this->service_model->get_total_of_sales_report($office,$daterange);
        $this->load->view('reports/totals_of_weekly_sales_report',$render_data);
    }
}
