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
        $this->load->model("lead_management");
        $this->load->model("action_model");
        $this->load->model('Project_Template_model');
    }
    public function index($type = 1) {
        $this->load->layout = 'dashboard';
        $title = "Manage Reports";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'reports';
        $render_data['menu'] = 'report_' . $type;
        $render_data['header_title'] = $title;
        $render_data['current_date'] = date('m/d/Y');
        $render_data['order_start_date'] = $this->service_model->get_start_date_sales_report();
        $render_data['project_start_date'] = $this->Project_Template_model->get_project_start_date();
        $render_data['action_start_date'] = $this->action_model->get_action_start_date();
        $render_data['lead_start_date'] = $this->lead_management->get_lead_start_date();
        $render_data['partner_start_date'] = $this->lead_management->get_partner_start_date();
        // $render_data['client_start_date'] = '';
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
        $render_data['start_date'] = $this->billing_model->get_start_date_royalty_report();
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
        $render_data['start_date'] = $this->service_model->get_start_date_sales_report();
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

    /* service_by_franchisee */
    public function get_service_by_franchise_data() {
        $category = post('category');
        $render_data['service_by_franchise_list'] = $this->service_model->get_service_by_franchise_data(post());
        $render_data['reports'] = array('report'=>'leafnet_report');
        $render_data['category'] = $category;
         
        $this->load->view('reports/service_by_franchise_data',$render_data);
    }
    public function get_range_service_report() {
        echo post('date_range_service');
    }

    // report dashboard billing data
    public function get_show_billing_data() {       
        $render_data['section'] = "billing";
        $render_data['reports'] = array('report'=>'leafnet_report');
        $render_data['billing_report_list'] = $this->billing_model->report_billing_list(post());
        $total_invoice = array_sum(array_column($render_data['billing_report_list'],'total_invoice'));
        if($total_invoice != '' || $total_invoice !=0) {
            $unpaid = (array_sum(array_column($render_data['billing_report_list'],'unpaid'))/$total_invoice) * 100;
            $paid = (array_sum(array_column($render_data['billing_report_list'],'paid'))/$total_invoice) * 100;
            $partial = (array_sum(array_column($render_data['billing_report_list'],'partial'))/$total_invoice) * 100;
        }else {
            $unpaid = 0;
            $paid = 0;
            $partial = 0;
        }
        $render_data['totals'] = array(
            'total_no_of_invoice'=> array_sum(array_column($render_data['billing_report_list'],'total_invoice')),   
            'total_amount_collected'=> array_sum(array_column($render_data['billing_report_list'],'amount_collected')),
            'total_unpaid' => round($unpaid,2),  
            'total_partial' => round($paid,2),   
            'total_paid' => round($partial,2),
            'total_less_than_30' => array_sum(array_column($render_data['billing_report_list'],'less_than_30')),  
            'total_less_than_60' => array_sum(array_column($render_data['billing_report_list'],'less_than_60')),   
            'total_more_than_60' => array_sum(array_column($render_data['billing_report_list'],'more_than_60'))   
        );
        $this->load->view('reports/billing_invoice_payments_data',$render_data);   
    }
    public function get_range_billing_report() {
        echo post('date_range_billing');
    }
    // report action data
    public function get_action_data() {       
        $category = post('category');
        $render_data['action_list'] = $this->action_model->get_action_data(post());
        $render_data['reports'] = array('report'=>'leafnet_report');
        $render_data['category'] = $category;
        $render_data['date_range_service_report'] = post('date_range'); 
        $this->load->view('reports/report_action_data',$render_data);
    }

    public function get_range_action_report() {
        echo post('date_range_action');
    }
    // report project data
    public function get_project_data() {        
        $category = post('category');
        $date_range = post('date_range');
        $render_data['projects_list'] = $this->Project_Template_model->get_projects_data($category,$date_range);
        $render_data['reports'] = array('report'=>'leafnet_report');
        $render_data['category'] = $category;
        $render_data['date_range_service_report'] = post('date_range'); 
        $this->load->view('reports/report_projects_data',$render_data);    
    }
    public function get_range_project_report() {
        echo post('date_range_project');
    }
    // report client data
    public function get_clients_data() {
        $category = post('category');
        $render_data['client_list'] = $this->action_model->get_clients_data($category);
        $render_data['reports'] = array('report'=>'leafnet_report');
        $render_data['category'] = $category;
        $this->load->view('reports/report_client_data',$render_data);    
    }
    
    // report partner data
    public function get_partner_data() {        
        $render_data['partner_list'] = $this->lead_management->get_partner_data(post());
        $render_data['reports'] = array('report'=>'leafnet_report');
        $render_data['date_range_service_report'] = post('date_range');
        $this->load->view('reports/report_partner_data',$render_data);    
    }
    public function get_range_partners_report() {
        echo post('date_range_partner');
    }
    // report lead data
    public function get_leads_data() {
        $category = post('category');
        $render_data['lead_list'] = $this->lead_management->get_lead_data(post());
        $render_data['reports'] = array('report'=>'leafnet_report');
        $render_data['category'] = $category;
        $render_data['date_range_service_report'] = post('date_range');         
        $this->load->view('reports/report_lead_data',$render_data);    
    }

    public function get_range_lead_report() {
        echo post('date_range_lead');
    }

    // refresh range
    public function refresh_service_report() {
        echo $this->service_model->refresh_report_dashboard_service();
    }

    public function refresh_billing_report() {
        echo $this->billing_model->refresh_report_dashboard_billing();    
    }
}
