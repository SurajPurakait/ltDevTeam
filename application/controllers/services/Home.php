<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('system');
        $this->load->model('service_model');
        $this->load->model("staff");
        $this->load->model("bookkeeping_model");
        $this->load->model('employee');
        $this->load->model('payroll_model');
        $this->load->model('service');
        $this->load->model('documents');
        $this->load->model('contacts');
        $this->load->model('company');
        $this->load->model('notes');
        $this->load->model('payroll');
        $this->load->model('company_model');
        $this->load->model('action_model');
        $this->load->model('rt6_model');
        $this->staff_info = $this->system->get_staff_info(sess('user_id'));
    }

    public function index($status = '', $category_id = '', $office_id = '') {
        $this->load->layout = 'dashboard';
        $title = "Service Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'service_dashboard';
        $render_data['header_title'] = $title;
        $render_data['page_heading'] = 'Service Dashboard';
        $render_data['filter_category']='';
        $render_data['filter_status'] = '';
        if($status != ''){
            $render_data['status'] = $status;
            if($status==2){
                $render_data['filter_status']=$status.'-Not Started';
               if($category_id!=''){
                   switch ($category_id){
                       case 1:
                           $render_data['filter_category']= $category_id.'-Incorporation-category';
                           break;
                       case 2:
                           $render_data['filter_category']= $category_id.'-Accounting Service-category';
                           break;
                       case 3:
                           $render_data['filter_category']= $category_id.'-Tax Services-category';
                           break;
                       case 4:
                           $render_data['filter_category']= $category_id.'-Business Services-category';
                           break;
                       case 5:
                           $render_data['filter_category']= $category_id.'-Partner Services-category';
                           break;
                       default :
                           $render_data['filter_category']='';  
                   }
               }
            }elseif($status==1){
                $render_data['filter_status']=$status.'-Started';
               if($category_id!=''){
                   switch ($category_id){
                       case 1:
                           $render_data['filter_category']= $category_id.'-Incorporation-category';
                           break;
                       case 2:
                           $render_data['filter_category']= $category_id.'-Accounting Service-category';
                           break;
                       case 3:
                           $render_data['filter_category']= $category_id.'-Tax Services-category';
                           break;
                       case 4:
                           $render_data['filter_category']= $category_id.'-Business Services-category';
                           break;
                       case 5:
                           $render_data['filter_category']= $category_id.'-Partner Services-category';
                           break;
                       default :
                           $render_data['filter_category']='';  
                   }
               }
            }
        }else{
           $render_data['status'] = $status; 
        }
        $render_data['category_list'] = $this->service_model->get_service_category();
        $render_data['staffInfo'] = $this->staff_info;
        // $render_data['status'] = $status;
        $render_data['category_id'] = $category_id;
        $render_data['office_id'] = $office_id;
        $this->load->template('services/dashboard', $render_data);
    }

    public function edit($order_id = '') {
        $this->load->layout = 'dashboard';
        $order_id = base64_decode($order_id);
        $edit_data = $this->service_model->get_order_info_by_id($order_id);
        // echo "<pre>";
        // print_r($edit_data);exit;
        $title = 'Edit ' . (($edit_data['service_shortname'] == 'inc_n_c_f' || $edit_data['service_shortname'] == 'inc_n_c_d' || $edit_data['service_shortname'] == 'inc_n_c_b_v_i' || $edit_data['service_shortname'] == 'inc_n_c_o') ? 'New Company' : $edit_data['service_name']);
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'service_dashboard';
        $render_data['header_title'] = $title;
        if (empty($edit_data) && count($edit_data) == 0) {
            redirect(base_url('services/home'));
        }
        $render_data['other_state'] = $edit_data['state_others'];
        $render_data['page_heading'] = $title;
        $edit_data['business_description'] = urldecode($edit_data['business_description']);
        $render_data['edit_data'] = $edit_data;
        $render_data['staffInfo'] = staff_info();
        $render_data['reference'] = 'company';
        $render_data['reference_id'] = $edit_data['company_id'];
        $render_data['service_id'] = $edit_data['service_id'];
        $render_data['company_id'] = $edit_data['company_id'];
        // echo '<pre>';print_r($render_data['edit_data']);exit;
        switch ($edit_data['service_shortname']):
            case 'inc_n_c_f':
            case 'inc_n_c_d':
            case 'inc_n_c_b_v_i':
            case 'inc_n_c_o': {      // Company
                    $render_data['company_name_option'] = $this->company_model->get_company_name_by_company_id($render_data['reference_id']);
                    $extra_services = $this->service_model->get_extra_services($order_id, $render_data['service_id']);
                    $render_data['selected_services'] = [];
                    if (!empty($extra_services)) {
                        $render_data['selected_services'] = array_column($extra_services, 'services_id');
                    }
                    $render_data['service'] = $this->service_model->get_service_by_id($render_data['service_id']);
                    $render_data['all_related_services'] = $this->service_model->get_related_service_list_by_service_id($render_data['service_id']);
                    $render_data['florida'] = $this->service_model->get_service_by_shortname('inc_n_c_f');
                    $render_data['delaware'] = $this->service_model->get_service_by_shortname('inc_n_c_d');
                    $render_data['bvi'] = $this->service_model->get_service_by_shortname('inc_n_c_b_v_i');
                    $render_data['oth'] = $this->service_model->get_service_by_shortname('inc_n_c_o');
                    $this->load->template('services/edit_company', $render_data);
                }
                break;
            case 'inc_n_c_n_p_f': {      //  Create Company - Non Profit Florida 
                    $render_data['company_name_option'] = $this->company_model->get_company_name_by_company_id($render_data['reference_id']);
                    $render_data['service'] = $this->service_model->get_service_by_id($render_data['service_id']);
                    $render_data['extra_data'] = $this->service_model->get_extra_data($order_id);
                    $this->load->template('services/edit_company_non_profit_fl', $render_data);
                }
                break;
            case 'inc_n_f_p': {      //  New Florida PA
                    $render_data['company_name_option'] = $this->company_model->get_company_name_by_company_id($render_data['reference_id']);
                    $render_data['service'] = $this->service_model->get_service_by_id($render_data['service_id']);
                    $render_data['extra_data'] = $this->service_model->get_extra_data($order_id);
                    $this->load->template('services/edit_new_florida_pa', $render_data);
                }
                break;
            case 'inc_c_a': {      // Corporate Amendment
                    $this->load->template('services/edit_corporate_amendment', $render_data);
                }
                break;
            case 'inc_f_a': {     // FIEN Application
                    $this->load->template('services/edit_fien_application', $render_data);
                }
                break;
            case 'inc_c_o_g_s_d':
            case 'inc_c_o_g_s_f': {     // Certificate of Good Standing
                    $this->load->template('services/edit_certificate_of_good_standing', $render_data);
                }
                break;
            case 'inc_o_a': {     // Operating Agreement
                    $render_data['extra_services'] = $this->service_model->get_extra_services($order_id, $render_data['service_id']);
                    $render_data['corporate_service_info'] = $this->service_model->get_service_by_shortname('inc_c_b2');
                    $render_data['shareholders_service_info'] = $this->service_model->get_service_by_shortname('inc_s_a');
                    $render_data['extra_data'] = $this->service_model->get_extra_data($order_id);
                    $render_data['ov_price'] = $this->service_model->get_main_service_data($order_id, $render_data['service_id'])['price_charged'];
                    $this->load->template('services/edit_operating_agreement', $render_data);
                }
                break;
            case 'tax_f': {     // FIRPTA
                    $render_data['extra_services'] = $this->service_model->get_extra_services($order_id, $render_data['service_id']);
                    $render_data['corporate_service_info'] = $this->service_model->get_service_by_shortname('tax_f');
                    $render_data['shareholders_service_info'] = $this->service_model->get_service_by_shortname('tax_f');
                    $render_data['service_info'] = $this->service_model->get_service_by_shortname('tax_f');
                    $render_data['extra_data'] = $this->service_model->get_extra_data($order_id);
                    $render_data['ov_price'] = $this->service_model->get_main_service_data($order_id, $render_data['service_id'])['price_charged'];
                    $this->load->template('services/edit_firpta', $render_data);
                }
                break;
            case 'inc_2_b_c_o_s':
            case 'inc_c_b': {     // Certificate Shares
                    $render_data['extra_services'] = $this->service_model->get_extra_services($order_id, $render_data['service_id']);
                    $selected_services = array();
                    if (!empty($render_data['extra_services'])) {
                        foreach ($render_data['extra_services'] as $data) {
                            $selected_services[] = $data['services_id'];
                        }
                    }
                    $render_data['service'] = $this->service_model->get_service_by_id($render_data['service_id']);
                    $render_data['selected_services'] = $selected_services;
                    $render_data['all_related_services'] = $this->service_model->get_related_service_list_by_service_id($render_data['service_id']);
                    $render_data['twenty_certificate_shares'] = $this->service_model->get_service_by_shortname('inc_2_b_c_o_s');
                    $render_data['corp_book'] = $this->service_model->get_service_by_shortname('inc_c_b');
                    $render_data['shares_transfer_completion'] = $this->service_model->get_service_by_shortname('inc_s_t');
                    $render_data['extra_10_cert'] = $this->service_model->get_service_by_shortname('inc_1_e_c');
                    $this->load->template('services/edit_certificate_shares', $render_data);
                }
                break;

            case 'inc_f_a_r':
            case 'inc_a_a_r':
            case 'inc_w_a_r':
            case 'inc_m_a_r_c':
            case 'inc_t_a_r':
            case 'inc_n_j_a_r': 
            case 'inc_n_y_a_r':    
            case 'inc_d_a_r': {     //     Annual Report 
                    $render_data['extra_services'] = $this->service_model->get_extra_services($order_id, $render_data['service_id']);
//                    print_r($render_data['extra_services']); exit;
                    $selected_services = array();
                    if (!empty($render_data['extra_services'])) {
                        foreach ($render_data['extra_services'] as $data) {
                            $selected_services[] = $data['services_id'];
                        }
                    }

                    $render_data['service'] = $this->service_model->get_service_by_id($render_data['service_id']);
                    $render_data['selected_services'] = $selected_services;
                    $render_data['all_related_services'] = $this->service_model->get_related_service_list_by_service_id($render_data['service_id']);
                    $render_data['florida'] = $this->service_model->get_service_by_shortname('inc_f_a_r');
                    $render_data['delaware'] = $this->service_model->get_service_by_shortname('inc_d_a_r');
                    $render_data['arizona'] = $this->service_model->get_service_by_shortname('inc_a_a_r');
                    $render_data['wyoming'] = $this->service_model->get_service_by_shortname('inc_w_a_r');
                    $render_data['michigan'] = $this->service_model->get_service_by_shortname('inc_m_a_r_c');
                    $render_data['texas'] = $this->service_model->get_service_by_shortname('inc_t_a_r');
                    $render_data['new_jersey'] = $this->service_model->get_service_by_shortname('inc_n_j_a_r');
                    $render_data['new_york'] = $this->service_model->get_service_by_shortname('inc_n_y_a_r');
                    $this->load->template('services/edit_annual_report', $render_data);
                }
                break;
                case 'bus_l_t':{        // Legal Translations
                    $render_data['order_extra_data'] = $this->service_model->get_extra_data($order_id);
                    $this->load->template('services/edit_legal_translations', $render_data);
                }
                break;
                case 'acc_1_w_u': {     // 1099 Write Up
                    $render_data['payer_data'] = $this->service_model->get_payer_info($order_id);
                    $render_data['recipient_data'] = $this->service_model->get_recipient_info_by_id($order_id);
                    $this->load->template('services/edit_1099_write_up', $render_data);
                }              
                break;
            default :
                redirect(base_url('services/home'));
        endswitch;
    }

    public function view($order_id = '') {       
        $this->load->layout = 'dashboard';
        $order_id = base64_decode($order_id);
        $order_info = $this->service_model->get_order_info_by_id($order_id);
        $title = (($order_info['service_shortname'] == 'inc_n_c_f' || $order_info['service_shortname'] == 'inc_n_c_d') ? 'New Company' : $order_info['service_name']);
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'service_dashboard';
        $render_data['header_title'] = $title;
        if (empty($order_info) && count($order_info) == 0) {
            redirect(base_url('services/home'));
        }
        $render_data['page_heading'] = $title;
        $render_data['reference'] = 'company';
        $render_data['reference_id'] = $order_info['company_id'];
        $render_data['service_id'] = $order_info['service_id'];
        $render_data['company_id'] = $order_info['company_id'];
        $render_data['staff_info'] = staff_info();
        $render_data['company_info'] = $this->company_model->get_company_by_id($render_data['reference_id']);
        $render_data['company_name_option'] = $this->company_model->get_company_name_by_company_id($render_data['reference_id']);
        $render_data['internal_data'] = $this->system->get_internal_data_by_reference($render_data['reference_id'], $render_data['reference']);
        $render_data['contact_list'] = $this->service_model->get_contact_list_by_reference($render_data['reference_id'], $render_data['reference']);
        $render_data['owner_list'] = $this->system->get_owner_list_by_company_id($render_data['reference_id']);
// echo $render_data['reference_id'];die;
        $render_data['document_list'] = $this->service_model->get_document_list_by_reference($render_data['reference_id'], $render_data['reference']);
        $render_data['order_info'] = $order_info;
        $render_data['note_list'] = $this->notes->note_list_with_log(1, 'reference_id', $order_info['id'], 'order');
        $render_data['related_service_list'] = $this->service_model->get_service_request_list($order_id);

        $render_data['order_status_array'] = [
            "0" => "Completed",
            "1" => "Started",
            "2" => "Not Started",
            "7" => "Cancelled"
        ];
        $render_data['frequency_array'] = [
            'm' => 'Monthly',
            'q' => 'Quarterly',
            'b' => 'BI-ANNUAL',
            'y' => 'Yearly'
        ];
        $render_data['order_extra_data'] = $render_data['company_extra_data'] = [];
        switch ($order_info['service_shortname']):
            case 'acc_r_b':
            case 'acc_b_b_d': {      // Bookkeeping
                    $render_data['order_extra_data'] = $this->bookkeeping_model->get_bookkeeping_by_order_id($order_id);
                    if (isset($render_data['order_extra_data']['existing_practice_id']) && $render_data['order_extra_data']['existing_practice_id'] != '') {
                        $render_data['internal_data']['existing_practice_id'] = $render_data['order_extra_data']['existing_practice_id'];
                    }
                    $render_data['account_list'] = $this->bookkeeping_model->get_account_list_by_order_id($order_id);
                }
                break;
            case 'acc_s_t_a': {      // Sales Tax Application
                    $render_data['order_extra_data'] = $this->salestax_model->get_salestax_data($order_id);
                    if (!empty($render_data['order_extra_data']) && isset($render_data['order_extra_data']['resident_type']) && $render_data['order_extra_data']['resident_type'] == "Resident") {
                        $render_data['salestax_driver_license_data'] = $this->payroll->sales_driver_license_data($order_id);
                    }
                }
                break;
            case 'acc_s_t_r': {      // Sales Tax Recurring
                    $render_data['order_extra_data'] = $this->service_model->get_recurring_data_by_order_id($order_id);
                    if (!empty($render_data['order_extra_data'])) {
                        $render_data['order_extra_data']['state_name'] = $this->system->get_state_by_id($render_data['order_extra_data']['state'])['state_name'];
                        $county = $this->action_model->get_county_name_by_id($render_data['order_extra_data']['county']);
                        if (!empty($county)) {
                            $render_data['order_extra_data']['county_name'] = $county['name'];
                        }
                    }
                    if (isset($render_data['order_extra_data']['existing_practice_id']) && $render_data['order_extra_data']['existing_practice_id'] != '') {
                        $render_data['internal_data']['existing_practice_id'] = $render_data['order_extra_data']['existing_practice_id'];
                    }
                    $render_data['order_extra_data']['frequency'] = $render_data['order_extra_data']['freq_of_salestax'];
                }
                break;
            case 'acc_s_t_p': {      // Sales Tax processing
                    $render_data['order_extra_data'] = $this->service_model->get_processing_data_by_order_id($order_id);
                    if (!empty($render_data['order_extra_data'])) {
                        $render_data['order_extra_data']['state_name'] = $this->system->get_state_by_id($render_data['order_extra_data']['state'])['state_name'];
                        $county = $this->action_model->get_county_name_by_id($render_data['order_extra_data']['county']);
                        if (!empty($county)) {
                            $render_data['order_extra_data']['county_name'] = $county['name'];
                        }
                    }
                    if (isset($render_data['order_extra_data']['existing_practice_id']) && $render_data['order_extra_data']['existing_practice_id'] != '') {
                        $render_data['internal_data']['existing_practice_id'] = $render_data['order_extra_data']['existing_practice_id'];
                    }
                    $render_data['order_extra_data']['frequency'] = $render_data['order_extra_data']['frequeny_of_salestax'];
                }
                break;
            case 'acc_p': {      // Payroll
                    $render_data['order_extra_data'] = $this->payroll_model->get_payroll_account_numbers_by_order_id($order_id);
                    if (!empty($render_data['order_extra_data']) && $render_data['order_extra_data']['resident_type'] == "Resident") {
                        $render_data['salestax_driver_license_data'] = $this->payroll->payroll_driver_license_data($order_id);
                    }
                    $render_data['payroll_wage_files'] = $this->payroll->payroll_wage_files($order_info['company_id']);
                    $render_data['company_extra_data'] = $this->payroll_model->get_payroll_company_data_by_order_id($order_id);
                    $render_data['employee_list'] = $this->employee->loadEmployeeList($order_info['company_id']);

                    $render_data['payroll_data'] = $this->payroll->payroll_data($order_info['company_id']);
                    $render_data['payroll_approver'] = $this->payroll->get_payroll_approver_by_reference_id($order_info['company_id']);
                    $render_data['company_principal'] = $this->payroll->get_company_principal_by_reference_id($order_info['company_id']);
                    $render_data['signer_data'] = $this->payroll->get_signer_data($order_info['company_id']);
                    $render_data['employee_details'] = $this->payroll->get_payroll_employee_details_by_reference_id($order_info['company_id']);
                    $render_data['payroll_employee_notes'] = $this->payroll->get_payroll_employee_notes_by_reference_id($order_info['company_id']);
                    $render_data['payroll_account_numbers'] = $this->payroll_model->get_payroll_account_numbers_by_order_id($order_id);
                }
                break;
            case 'inc_n_c_n_p_f': {      //  Create Company - Non Profit Florida
                    $render_data['order_extra_data'] = $this->service_model->get_extra_data($order_id);
                }
                break;
            case 'tax_f': {      //  Create FIRPTA
                    $render_data['order_extra_data'] = $this->service_model->get_extra_data($order_id);
                    $render_data['buyers_info'] = $this->service_model->get_buyers_list_order_id($order_id);
                    $render_data['sellers_info'] = $this->service_model->get_sellers_list_order_id($order_id);
                }
                break;
            case 'inc_n_f_p': {      //  New Florida PA
                    $render_data['order_extra_data'] = $this->service_model->get_extra_data($order_id);
                }
                break;
            case 'acc_r_a_-_u': {      //  Rt6 Unemployment App
                    $render_data['sales_tax_data'] = $this->rt6_model->get_rt6_data($order_id)[0];
                    if (!empty($render_data['sales_tax_data']) && $render_data['sales_tax_data']['resident_type'] == "Resident") {
                        $render_data['salestax_driver_license_data'] = $this->payroll->payroll_driver_license_data($order_id);
                    } else {
                        $render_data['salestax_driver_license_data'] = [];
                    }
                    $render_data['salestax_employee_notes'] = $this->payroll->get_payroll_employee_notes_by_reference_id($render_data['reference_id']);
                }
                break;

            case 'acc_1_w_u': {   // 1099 Write Up
                   
                   $render_data['recipient_info'] = $this->service_model->get_recipient_info($order_id); 
                   $render_data['payer_info'] = $this->service_model->get_payer_info($order_id); 
            }
        endswitch;

//        if ($service_id == '14') {
//            $result['sales_tax_data'] = $this->rt6_model->get_rt6_data($rowid)[0];
//            if (!empty($result['sales_tax_data']) && $result['sales_tax_data']['resident_type'] == "Resident") {
//                $result['salestax_driver_license_data'] = $this->payroll->payroll_driver_license_data($edit_data[0]['order_id']);
//            } else {
//                $result['salestax_driver_license_data'] = [];
//            }
//            $result['salestax_employee_notes'] = $this->payroll->get_payroll_employee_notes_by_reference_id($edit_data[0]['reference_id']);
//        }
        if($render_data['title'] == "Sales Tax Application | Tax Leaf")
        {
        $state = '';        
        foreach ($render_data['order_extra_data'] as $value) {            
            $state = $value['state_recurring'];
        }
        $render_data['state_name1'] = $this->salestax_model->getstatename($state);   
        }
        $this->load->template('services/view_service1', $render_data);
    }

    public function download($order_id = '') {
        $order_info = $this->service_model->get_order_info_by_id($order_id);
        $title = (($order_info['service_shortname'] == 'inc_n_c_f' || $order_info['service_shortname'] == 'inc_n_c_d') ? 'New Company' : $order_info['service_name']);
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'service_dashboard';
        $render_data['header_title'] = $title;
        if (empty($order_info) && count($order_info) == 0) {
            redirect(base_url('services/home'));
        }
        $render_data['fcpath'] = base_url();
        $render_data['page_heading'] = $title;
        $render_data['reference'] = 'company';
        $render_data['reference_id'] = $order_info['company_id'];
        $render_data['service_id'] = $order_info['service_id'];
        $render_data['company_id'] = $order_info['company_id'];
        $render_data['staff_info'] = staff_info();
        $render_data['company_info'] = $this->company_model->get_company_by_id($render_data['reference_id']);
        $render_data['company_name_option'] = $this->company_model->get_company_name_by_company_id($render_data['reference_id']);
        $render_data['internal_data'] = $this->system->get_internal_data_by_reference($render_data['reference_id'], $render_data['reference']);

// print_r($render_data);exit;
        $render_data['contact_list'] = $this->service_model->get_contact_list_by_reference($render_data['reference_id'], $render_data['reference']);
        $render_data['owner_list'] = $this->system->get_owner_list_by_company_id($render_data['reference_id']);
        $render_data['document_list'] = $this->service_model->get_document_list_by_reference($render_data['reference_id'], $render_data['reference']);

        $render_data['order_info'] = $order_info;
        $render_data['note_list'] = $this->notes->note_list_with_log(1, 'reference_id', $order_info['id'], 'order');
        $render_data['related_service_list'] = $this->service_model->get_service_request_list($order_id);
        $render_data['order_status_array'] = [
            "0" => "Completed",
            "1" => "Started",
            "2" => "Not Started",
            "7" => "Cancelled"
        ];
        $render_data['frequency_array'] = [
            'm' => 'Monthly',
            'q' => 'Quarterly',
            'b' => 'BI-ANNUAL',
            'y' => 'Yearly'
        ];
        $render_data['order_extra_data'] = $render_data['company_extra_data'] = [];
        switch ($order_info['service_shortname']):
            case 'acc_r_b':
            case 'acc_b_b_d': {      // Bookkeeping
                    $render_data['order_extra_data'] = $this->bookkeeping_model->get_bookkeeping_by_order_id($order_id);
                    if (isset($render_data['order_extra_data']['existing_practice_id']) && $render_data['order_extra_data']['existing_practice_id'] != '') {
                        $render_data['internal_data']['existing_practice_id'] = $render_data['order_extra_data']['existing_practice_id'];
                    }
                    $render_data['account_list'] = $this->bookkeeping_model->get_account_list_by_order_id($order_id);
                }
                break;
            case 'acc_s_t_a': {      // Sales Tax Application
                    $render_data['order_extra_data'] = $this->salestax_model->get_salestax_data($order_id);
                    if (!empty($render_data['order_extra_data']) && isset($render_data['order_extra_data']['resident_type']) && $render_data['order_extra_data']['resident_type'] == "Resident") {
                        $render_data['salestax_driver_license_data'] = $this->payroll->sales_driver_license_data($order_id);
                    }
                }
                break;
            case 'acc_s_t_r': {      // Sales Tax Recurring
                    $render_data['order_extra_data'] = $this->service_model->get_recurring_data_by_order_id($order_id);
                    if (!empty($render_data['order_extra_data'])) {
                        $render_data['order_extra_data']['state_name'] = $this->system->get_state_by_id($render_data['order_extra_data']['state'])['state_name'];
                        $county = $this->action_model->get_county_name_by_id($render_data['order_extra_data']['county']);
                        if (!empty($county)) {
                            $render_data['order_extra_data']['county_name'] = $county['name'];
                        }
                    }
                    if (isset($render_data['order_extra_data']['existing_practice_id']) && $render_data['order_extra_data']['existing_practice_id'] != '') {
                        $render_data['internal_data']['existing_practice_id'] = $render_data['order_extra_data']['existing_practice_id'];
                    }
                    $render_data['order_extra_data']['frequency'] = $render_data['order_extra_data']['freq_of_salestax'];
                }
                break;
            case 'acc_s_t_p': {      // Sales Tax processing
                    $render_data['order_extra_data'] = $this->service_model->get_processing_data_by_order_id($order_id);
                    if (!empty($render_data['order_extra_data'])) {
                        $render_data['order_extra_data']['state_name'] = $this->system->get_state_by_id($render_data['order_extra_data']['state'])['state_name'];
                        $county = $this->action_model->get_county_name_by_id($render_data['order_extra_data']['county']);
                        if (!empty($county)) {
                            $render_data['order_extra_data']['county_name'] = $county['name'];
                        }
                    }
                    if (isset($render_data['order_extra_data']['existing_practice_id']) && $render_data['order_extra_data']['existing_practice_id'] != '') {
                        $render_data['internal_data']['existing_practice_id'] = $render_data['order_extra_data']['existing_practice_id'];
                    }
                    $render_data['order_extra_data']['frequency'] = $render_data['order_extra_data']['frequeny_of_salestax'];
                }
                break;
            case 'acc_p': {      // Payroll
                    $render_data['order_extra_data'] = $this->payroll_model->get_payroll_account_numbers_by_order_id($order_id);
                    if (!empty($render_data['order_extra_data']) && $render_data['order_extra_data']['resident_type'] == "Resident") {
                        $render_data['salestax_driver_license_data'] = $this->payroll->payroll_driver_license_data($order_id);
                    }
                    $render_data['payroll_wage_files'] = $this->payroll->payroll_wage_files($order_info['company_id']);
                    $render_data['company_extra_data'] = $this->payroll_model->get_payroll_company_data_by_order_id($order_id);
                    $render_data['employee_list'] = $this->employee->loadEmployeeList($order_info['company_id']);

                    $render_data['payroll_data'] = $this->payroll->payroll_data($order_info['company_id']);
                    $render_data['payroll_approver'] = $this->payroll->get_payroll_approver_by_reference_id($order_info['company_id']);
                    $render_data['company_principal'] = $this->payroll->get_company_principal_by_reference_id($order_info['company_id']);
                    $render_data['signer_data'] = $this->payroll->get_signer_data($order_info['company_id']);
                    $render_data['employee_details'] = $this->payroll->get_payroll_employee_details_by_reference_id($order_info['company_id']);
                    $render_data['payroll_employee_notes'] = $this->payroll->get_payroll_employee_notes_by_reference_id($order_info['company_id']);
                }
                break;
            case 'inc_n_c_n_p_f': {      //  Create Company - Non Profit Florida
                    $render_data['order_extra_data'] = $this->service_model->get_extra_data($order_id);
                }
                break;
            case 'inc_n_f_p': {      //  New Florida PA
                    $render_data['order_extra_data'] = $this->service_model->get_extra_data($order_id);
                }
                break;
            case 'tax_f': {      //  Create FIRPTA
                    $render_data['order_extra_data'] = $this->service_model->get_extra_data($order_id);
                    $render_data['buyers_info'] = $this->service_model->get_buyers_list_order_id($order_id);
                    $render_data['sellers_info'] = $this->service_model->get_sellers_list_order_id($order_id);
                }
                break;
            case 'acc_r_a_-_u': {      //  Rt6 Unemployment App
                    $render_data['sales_tax_data'] = $this->rt6_model->get_rt6_data($order_id)[0];
                    if (!empty($render_data['sales_tax_data']) && $render_data['sales_tax_data']['resident_type'] == "Resident") {
                        $render_data['salestax_driver_license_data'] = $this->payroll->payroll_driver_license_data($order_id);
                    } else {
                        $render_data['salestax_driver_license_data'] = [];
                    }
                    $render_data['salestax_employee_notes'] = $this->payroll->get_payroll_employee_notes_by_reference_id($render_data['reference_id']);
                }
                break;
        endswitch;
//$this->load->view('services/download', $render_data);
        $this->load->helper('pdf_helper');
        tcpdf();
        $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
        $obj_pdf->SetTitle($title);
        $obj_pdf->AddPage();
        ob_start();
//        echo "<pre>";
//        print_r($render_data);
//        echo "</pre>";die;
        $content = $this->load->view('services/download', $render_data, TRUE);
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->Output("Taxleaf_" . date('dmY') . ".pdf", 'D');
    }

    public function service_dashboard_filter() {
        if (post('request_type') == 'on_load') {
            $render_data['load_type'] = 'on_load';
            $request_type = '';
        } else {
            $request_type = post('request_type');
        }
        $category_id = request('category_id');
        $status = request('status');
        $request_by = request('request_by');
        $department = request('department_id');
        $office = request('office_id');
        $staff_type = request('staff_type');
        $sort = request('sort');
        $render_data['page_number'] = request('page_number');
        $render_data['result'] = $this->service_model->ajax_services_dashboard_filter($status, $request_type, $category_id, $request_by, $department, $office, $staff_type, $sort);
        $render_data['serviceid'] = $this->service_model->getServiceId();
        $this->load->view('services/ajax_dashboard', $render_data);
    }

    public function load_partner_manager() {
        $data = $this->service_model->get_staff_by_office_id(post('office_id'));
        if (count($data) > 0) {
            echo json_encode($data);
        } else {
            echo 0;
        }
    }

    public function change_due_date() {
        $data = $this->service_model->change_due_date(post());
        echo date('m/d/Y', strtotime($data['date']));
    }

    public function annual_date() {
        $data = $this->service_model->change_annual_date(post());
        if ($data) {
            $data['date'] = date('m/d/Y', strtotime($data['date']));
            echo json_encode($data);
        } else {
            echo 0;
        }
    }

    public function get_related_service_container() {
        $data['service_id'] = post('service_id');
        $data['related_service_id_arr'] = post('relative_service_id');
        if (!empty($data['related_service_id_arr'])) {
            array_unique($data['related_service_id_arr']);
        }
        $data['related_service'] = $this->service_model->get_related_service_by_service_id($data['service_id']);
        $this->load->view('services/related_service_container', $data);
    }

    public function owner_form($service_id, $reference_id = "", $title_id = '') {
        $this->load->model('Company');
        $this->load->model('Contacts');
        $this->load->model('Documents');
        if (!$title_id) {
            $title_id = $this->Company->createTitleReferenceId($reference_id);
        }
        if ($title_id) {
            $title_array = $this->Company->getTitle($title_id);
            $individual_id = $title_array->individual_id;
        } else {
            $title_array = false;
            $title_id = 0;
            $individual_id = 0;
        }
        $quant_contact = $this->Contacts->getQuantContactByReference("individual", $individual_id);
        $quant_documents = $this->Documents->getQuantDocumentsByReference("individual", $individual_id);
        $company_type = get('q');


        $this->load->layout = 'dashboard';
        $title = "Owner";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['title_val'] = $title_array;
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $render_data['reference'] = 'individual';
        $render_data['service_id'] = $service_id;
        $render_data['reference_id'] = $reference_id;
        $render_data['company_type'] = $company_type;
        $render_data['staffInfo'] = $this->staff_info;
        $render_data['individual_id'] = $individual_id;
        $render_data['quant_contact'] = $quant_contact;
        $render_data['quant_documents'] = $quant_documents;
        $render_data['service_id1'] = get('sid');
        $render_data['main_contact_exists'] = $this->Contacts->check_main_contact_exists($reference_id);
        $render_data['individual_contact_exists'] = $this->Contacts->check_if_contact_exists($individual_id);
        $render_data['title_id'] = $title_id;

        $this->load->template('services/owner_form', $render_data);
    }

    public function show_contact_list($ref, $ref_id) {
        $render_data['data'] = $this->service_model->get_address_book($ref, $ref_id);
        $this->load->view('services/contact_list', $render_data);
    }

//    public function show_owner_list() {
//        $render_data['list'] = $this->service_model->show_owner_list($id);
//        $this->load->view('services/owner_list', $render_data);
//    }

    public function reload_owner_list() {
        $render_data['section'] = post('section');
        $render_data['list'] = $this->service_model->show_owner_list(post("company_id"));
        $render_data['total_percentage'] = $this->service_model->total_percentage(post("company_id"));
        $this->load->view('services/owner_list', $render_data);
    }

    public function insert_contact() {
        echo $this->service_model->add_new_contact(post());
    }

    public function update_list($id) {
        $render_data['contact'] = $this->service_model->get_single_address($id);
        $this->load->view('services/single_contact', $render_data);
    }

    public function get_all_contacts($ref_id) {
        $render_data['contact'] = $this->service_model->get_contacts_by_ref($ref_id);
        $this->load->view('services/single_contact', $render_data);
    }

    public function update_doc_list($id) {
        $render_data['data']["id"] = $id;
        $this->load->view('services/attached_docs', $render_data);
    }

    public function insert_document() {
        echo $this->service_model->add_new_document(post());
    }

    public function update_contact($id) {
        echo $this->service_model->update_contact($id, post());
    }

    public function delete_contact() {
        $id = post('id');
        $reference_id = post('reference_id');
        $reference = post('reference');
        if ($this->service_model->count_contact_by_reference($reference_id, $reference) <= 1) {
            echo 1;
        } else {
            if ($this->service_model->delete_contact($id)) {
                echo 2;
            } else {
                echo 0;
            }
        }
    }

    public function loadDocumentList($id) {
        echo $this->service_model->loadDocumentList($id);
    }

    public function loadDocumentListByRef($ref_id) {
        echo $this->service_model->loadDocumentListByRef($ref_id);
    }

    public function delete_document($id, $file_name) {
        echo $this->service_model->delete_document($id, $file_name);
    }

    public function getNotesContent() {
        $this->notes->note_read_status_change(post('reference_id'));
        $render_data = array();
        $render_data['notes_data'] = $this->notes->note_list_with_log(1, 'reference_id', post('reference_id'), (post('loc') == 'outer') ? 'order' : 'service');
        $render_data['notes_table'] = 'notes';
        $this->load->view('services/notes_content', $render_data);
    }

    public function getAttacments() {
        $reference = post('reference');
        $reference_id = post('reference_id');
        $order_id = post('order_id');
// $this->load->model('service_model');
        $render_data['attachments_list'] = $this->service_model->get_document_list_by_reference_id($reference_id, $reference,$order_id);
// print_r($render_data['attachments_list']);die;
// echo $reference_id;die;
        $this->load->view('services/attachments_content', $render_data);
    }

    public function getNotesContentPayrollform() {
        $render_data = array();
        if (post('reference') == 'payrollemp') {
            $related_table_id = '4';
            $render_data['notes_table'] = 'payroll_employee_notes';
        } else {
            $related_table_id = '5';
            $render_data['notes_table'] = 'payroll_rt6_notes';
        }
        $render_data['notes_data'] = $this->notes->note_list_with_log($related_table_id, 'reference_id', post('reference_id'));
        $this->load->view('services/notes_content', $render_data);
    }

    public function get_tracking_log($id, $table_name) {
        $this->load->model('service_model');
        echo json_encode($this->service_model->get_tracking_log($id, $table_name));
    }

    public function update_suborder_status() {
        $statusval = post('statusval');
        $suborderid = post('suborderid');
        // if (post('input_form_status') == 'incomplete') {
        //     echo 'error_on_input_form';
        // }
         if ((post('sos_read_status') == 'not_cleared' && $statusval == '0') || (post('sos_read_status') == 'not_cleared' && $statusval == '7')) {
            echo 'error_on_sos_read_status';
        } else {
            $this->load->model('service_model');
            $details = $this->service_model->get_suborder_details($suborderid);
            mod_services_count($details['status'], $statusval, str_replace(' ', '_', strtolower($details['name'])));
            if ($statusval == 1) {
                $this->service_model->assign_service_by_service_id($suborderid, sess('user_id'));
            }
            $ids = $this->service_model->update_suborder_status($statusval, $suborderid);
            $main_status = $this->db->query("select * from `order` where id='" . $ids['main_order_id'] . "'")->row_array()['status'];
            $sub_status = $this->db->query("select * from `service_request` where id='" . $ids['sub_order_id'] . "'")->row_array()['status'];
            $ids['main_order_status'] = $main_status;
            $ids['sub_order_status'] = $sub_status;
            echo json_encode($ids);
        }
    }

    public function updateNotes() {
        if (!empty(post('notes'))) {
            $this->notes->updateNotes(post(), post('notestable'));
// redirect(base_url() . 'services/home');
        }
    }

    public function test() {
        $this->service_model->add_related_service(25, [1 => ["price_changed" => 500], 2 => ["price_changed" => 800]]);
    }

    public function copy_contact() {
        $company_id = request('company_id');
        $individual_id = request('individual_id');
        $this->load->model('Contacts');
        $check_if_contact_exists = $this->Contacts->check_if_contact_exists($individual_id);
        if ($check_if_contact_exists == 0) {
            $resultdata = $this->Contacts->copy_contact_list_ajax("company", $company_id);
            $check_if_contact_with_same_ph_email_exists_for_copy = $this->service_model->check_if_contact_with_same_ph_email_exists_for_copy($resultdata[0]['first_name'], $resultdata[0]['last_name'], $resultdata[0]['phone1'], $resultdata[0]['email1'], $individual_id);
            if (empty($check_if_contact_with_same_ph_email_exists_for_copy)) {
                $this->Contacts->saveCopiedContact($resultdata, $individual_id);
                echo "1";
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    }

    public function save_owner() {
        $this->load->model('Individual');
        $owner_total_percentage = $this->Individual->owner_total_percentage(post());
        if (empty($owner_total_percentage)) {
            $total = '0.00';
        } else {
            $total = $owner_total_percentage[0]['total'];
        }

        $com_type = post('type');
        $current_percentage = intval(post('percentage'));

        $tot = intval($total);

        $checking_percentage_value = $tot + $current_percentage;

        $title = post('title');
        $company_id = post('company_id');

        if ($com_type == 3 || $com_type == 6) {

            if ($title != 'MEMBER' && $title != 'MANAGING MEMBER') {
                $check_if_title_exists = $this->Individual->check_if_title_exists($title, $company_id);
            } else {
                $check_if_title_exists = '0';
            }

// if ($com_type == 3 || $com_type == 6) {
            if ($checking_percentage_value > 100) {
                echo 2;
            } else {
                if ($check_if_title_exists == 0) {
                    if ($this->Individual->saveOwner(post())) {
                        echo 1;
                    } else {
                        echo 0;
                    }
                } else {
                    $this->Individual->saveOwner(post());
                    echo 1;
                }
            }
// } else {
//     if ($check_if_title_exists == 0) {
//         if ($this->Individual->saveOwner(post())) {
//             echo 1;
//         } else {
//             echo 0;
//         }
//     } else {
//         echo 0;
//     }
// }
        } else {
            if ($title != 'MEMBER') {
                $check_if_title_exists = $this->Individual->check_if_title_exists($title, $company_id);
            } else {
                $check_if_title_exists = '0';
            }

            if ($com_type == 3 || $com_type == 6) {
                if ($checking_percentage_value > 100) {
                    echo 2;
                } else {
                    if ($check_if_title_exists == 0) {
                        if ($this->Individual->saveOwner(post())) {
                            echo 1;
                        } else {
                            echo 0;
                        }
                    } else {
                        $this->Individual->saveOwner(post());
                        echo 1;
                    }
                }
            } else {
                if ($check_if_title_exists == 0) {
                    if ($this->Individual->saveOwner(post())) {
                        echo 1;
                    } else {
                        echo 0;
                    }
                } else {
                    $this->Individual->saveOwner(post());
                    echo 1;
                }
            }
        }
    }

    public function delete_owner() {
        $owner_id = post('owner_id');
        $compnay_id = post('company_id');
        $this->load->model('Company');
        $this->load->model('service_model');
        if ($this->service_model->count_owner_by_company($compnay_id) <= 1) {
            echo 1;
        } else {
            if ($this->Company->deleteTitle($owner_id)) {
                echo 2;
            } else {
                echo 0;
            }
        }
    }

    public function enable_company_type() {
        $company_id = post('company_id');
        $this->load->model('Company');
        echo $this->Company->getownercount($company_id);
    }

    public function get_contact_list() {
        $data['disable'] = post('disable');
        $data['list'] = $this->service_model->get_contact_list_by_reference(post('reference_id'), post('reference'));
        if (empty($data['list'])) {
            $individual_data = $this->service_model->get_individual_id_by_ref_id(post('reference_id'));
            $individual_id = $individual_data['individual_id'];
            $data['list'] = $this->service_model->get_contact_list_by_reference($individual_id, post('reference'));
        }
        $this->load->view('services/show_contact_list', $data);
    }

    public function get_document_list() {

        $data['list'] = $this->service_model->get_document_list_by_reference(post('reference_id'), post('reference'));
        $this->load->view('services/show_document_list', $data);
    }

    public function save_contact() {
        echo $this->service_model->save_contact(post('contact'));
    }

    public function save_document() {
        echo $this->service_model->save_document(post());
    }

    public function get_partnet_manager($office_id) {
        echo json_encode($this->staff->get_office_function($office_id));
    }

    public function get_financial_account_list() {
        $data['company_id'] = post('company_id');
        $data['order_id'] = post('order_id');
        $data['list_type'] = post('list_type');
        if ($data['order_id'] == '') {
            $data['list'] = $this->service_model->get_account_list_by_company_id($data['company_id'],post('list_type'));
        } else {
            $data['list'] = $this->service_model->get_account_list_by_order_id($data['order_id'],post('list_type'));
        }
        $this->load->view("services/account_list", $data);
    }

    public function save_existing_owner_list() {
        $company_id = post('company_id');
        $new_reference_id = post('new_reference_id');
        $this->load->model('Company');
        $check_if_existing_owner_exists = $this->Company->check_if_existing_owner_exists($company_id);
        if ($check_if_existing_owner_exists != 0) {
            $resultdata = $this->Company->get_existing_owner_list($company_id);
            $this->Company->saveExistingowners($resultdata, $new_reference_id);
            echo $check_if_existing_owner_exists;
        } else {
            echo '0';
        }
    }

    public function save_existing_contact_list() {
        $reference = post('reference');
        $reference_id = post('reference_id');
        $new_reference_id = post('new_reference_id');
        $this->load->model('Contacts');
        $check_if_existing_contact_exists = $this->Contacts->check_if_existing_contact_exists($reference, $reference_id);
        if ($check_if_existing_contact_exists != 0) {
            $resultdata = $this->Contacts->get_existing_contact_list($reference, $reference_id);
            $this->Contacts->saveExistingContact($resultdata, $new_reference_id);
            echo $check_if_existing_contact_exists;
        } else {
            echo '0';
        }
    }

    public function delete_contact_ist() {
        $reference_id = request('reference_id');
        $this->load->model('Contacts');
        if ($this->Contacts->deleteContactList($reference_id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function delete_owner_list() {
        $reference_id = request('reference_id');
        $this->load->model('Company');
        if ($this->Company->delete_owner_list($reference_id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function addNotesmodal() {
        $data = post();
        $service_id = $data['service_id'];
        $reference = $data['reference'];

        $notes = $data['modal_notes'];
        $order_id = $this->input->post('order_id');

        $id = $data['reference_id'];
        $this->load->model('notes');

        if ($reference == 'payrollrt6') {
            if (isset($service_id) && $service_id != "") {
                if (!empty($data['modal_notes'][0])) {
                    $this->notes->insert_note(5, $notes, 'reference_id', $id);
                    echo count($notes);
                } else {
                    echo '0';
                }
            } else {
                if (!empty($data['modal_notes'][0])) {
                    $this->notes->insert_note(5, $notes, 'reference_id', $id);
                    echo count($notes);
                } else {
                    echo '0';
                }
            }
        } elseif ($reference == 'payrollemp') {
            if (isset($service_id) && $service_id != "") {
                if (!empty($data['modal_notes'][0])) {
                    $this->notes->insert_note(4, $notes, 'reference_id', $id);
                    echo count($notes);
                } else {
                    echo '0';
                }
            } else {
                if (!empty($data['modal_notes'][0])) {
                    $this->notes->insert_note(4, $notes, 'reference_id', $id);
                    echo count($notes);
                } else {
                    echo '0';
                }
            }
        } else {
            // if (isset($service_id) && $service_id != "") {
            if ($id != $order_id) {
                if (!empty($data['modal_notes'][0])) {
                    $this->notes->insert_note(1, $notes, 'reference_id', $id, 'service');
                    echo count($notes);
                } else {
                    echo '0';
                }
            }
            // }
            else {
                if (!empty($data['modal_notes'][0])) {
                    $this->notes->insert_note(1, $notes, 'reference_id', $id, 'order');
                    echo count($notes);
                } else {
                    echo '0';
                }
            }
        }
    }

    public function add_model_note() {
        $data = post();
        $data['table'] = 'notes';
        $data['note_title'] = "";
        $data['add_name'] = 'modal_notes[]';
        $this->load->view('model_add_note', $data);
    }

    public function copy_main_contact_info() {
        $reference_id = request('reference_id');
        $this->load->model('Contacts');
        $resultdata = $this->Contacts->copy_contact_list_ajax("company", $reference_id);
        if (!empty($resultdata)) {
            echo json_encode($resultdata[0]);
        } else {
            echo 0;
        }
    }

    public function download_zip() {
        $files_array = explode(",", request('filesarray'));
        $this->load->library('zip');
        if (!empty($files_array)) {
            foreach ($files_array as $file) {
                $filepath = FCPATH . '/uploads/' . trim($file);
                $this->zip->read_file($filepath);
            }
//$this->zip->archive(FCPATH.'/uploads/example_backup.zip');
            $this->zip->download('my_zipfile.zip');
        }
    }

    public function check_shortname() {
        $sc = post('sc');
        $checkval = $this->service_model->check_shortname($sc);
        echo $checkval;
    }

    public function get_state_of_incorporation_value() {
        $ref_id = post('ref_id');
        $res = $this->service_model->get_state_of_incorporation_value($ref_id);
        echo $res['state_opened'];
    }

    public function get_company_type() {
        $ref_id = post('ref_id');
        $res = $this->service_model->get_company_type($ref_id);
        echo $res['type'];
    }

    public function get_state_county_val() {
        $ref_id = post('ref_id');
        $res = $this->service_model->get_state_county_val($ref_id);
        echo json_encode($res);
    }

    public function related_services_form($service_id, $order_id) {
        $this->load->model('system');
        $this->load->model('bookkeeping_model');
        $this->load->model('payroll');
        $this->load->model('salestax_model');
        $this->load->model('Service');
        $this->load->model('service_model');
        $this->load->model('rt6_model');
        $service = $this->service_model->get_service($service_id);
        $service_name = $service['description'];
        $service_shortcode = $service['ideas'];
        $this->load->layout = 'dashboard';
        $title = $service_name . " Form";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'home';
        $render_data['header_title'] = $title;
        $render_data['service_id'] = $service_id;
        $render_data['order_id'] = $order_id;
        $render_data['reference_id'] = $this->service_model->get_order_by_id($order_id)['reference_id'];
        $serv_name = strtolower(preg_replace('/\s+/', '_', trim($service_name)));
        if ($service_shortcode == 'acc_b_b_d') {
            $render_data['override_price'] = $this->system->check_if_related_service_exists($service_id, $order_id)['price_charged'];
        } elseif ($service_shortcode == 'acc_r_b') {
            $render_data['override_price'] = $this->system->check_if_related_service_exists($service_id, $order_id)['price_charged'];
            $render_data['bookkeeping_data'] = $this->bookkeeping_model->get_bookkeeping_by_order_id($order_id);
        } elseif ($service_shortcode == 'acc_p') {
            $render_data['rt6_data'] = $this->service_model->get_service_by_shortcode('acc_r');
            $render_data['payroll_account_numbers'] = $this->payroll_model->get_payroll_account_numbers_by_order_id($order_id);
            $render_data['payroll_data'] = $this->payroll->payroll_data($render_data['reference_id']);
            $render_data['company_data'] = $this->payroll->get_company_by_id($render_data['reference_id']);
//$render_data['notes_data'] = $this->payroll->get_note_by_reference_id($edit_data['reference_id']);
            $render_data['payroll_approver'] = $this->payroll->get_payroll_approver_by_reference_id($render_data['reference_id']);
            $render_data['company_principal'] = $this->payroll->get_company_principal_by_reference_id($render_data['reference_id']);
            $render_data['all_driver_license'] = $this->payroll->get_payroll_driver_license_data_by_reference_id($render_data['reference_id']);
//$render_data['employee_notes'] = $this->payroll->get_payroll_employee_notes_by_reference_id($edit_data['reference_id']);
            $render_data['employee_details'] = $this->payroll->get_payroll_employee_details_by_reference_id($render_data['reference_id']);
//$render_data['inter_data'] = $this->Service->get_payroll_internal($edit_data['reference_id']);
            $render_data['payroll_data_for_new_existing'] = $this->payroll->get_payroll_data($render_data['reference_id']);
            $render_data['get_override_price'] = $this->payroll->get_override_price($render_data['rt6_data']['id'], $order_id);
            $render_data['signer_data'] = $this->payroll->get_signer_data($render_data['reference_id']);
            $render_data['company_data'] = $this->payroll_model->get_company_by_id($render_data['reference_id']);
            $render_data['payroll_company_data'] = $this->payroll_model->get_payroll_company_data_by_order_id($order_id);
            $render_data['owner_list'] = $this->service_model->get_owner_list($render_data['reference_id']);
            $render_data['biweekly_xls_list'] = $this->payroll_model->uploaded_xls_list($render_data['reference_id'], 1);
            $render_data['weekly_xls_list'] = $this->payroll_model->uploaded_xls_list($render_data['reference_id'], 2);
        } elseif ($service_shortcode == 'acc_s_t_a') {
            $render_data['rt6_data'] = $this->service_model->get_service_by_shortcode('acc_r');
            $render_data['all_driver_license'] = $this->salestax_model->get_salestax_driver_license_data_by_order_id($order_id);

            $render_data['get_override_price'] = $this->salestax_model->get_override_price($render_data['rt6_data']['id'], $order_id);

            $render_data['sales_tax_data'] = $this->salestax_model->get_salestax_data($order_id)[0];


            $state = $render_data['sales_tax_data']['state_recurring'];
            $render_data['state_list'] = $this->service_model->get_states();
            $render_data['state'] = $this->service->get_state_name($state);
            $county = $render_data['state']->id;

            $render_data['county'] = $this->service->get_county_by_state_name($county);
        } elseif ($service_shortcode == 'acc_s_t_r') {
            $render_data['recurring_data'] = $this->service_model->get_recurring_data($order_id);

            $render_data['edit_data'] = $this->Service->get_edit_data($order_id);

            if (isset($render_data['recurring_data'])) {
                $state = $render_data['recurring_data']->state;

                $render_data['state'] = $this->service->get_state_name($state);
                $county = $render_data['state']->id;
                $render_data['county'] = $this->service->get_county_by_state_name($county);
            }

            $render_data['state_list'] = $this->service_model->get_states();


            $edit_data = $this->salestax_model->get_sales_by_id($order_id);
            $render_data['override_price'] = $this->salestax_model->get_override_price($service_id, $order_id)[0];
            $render_data['company_id'] = $edit_data['reference_id'];
            $render_data['edit_data'] = $edit_data;
            $render_data['staffInfo'] = staff_info();
        } elseif ($service_shortcode == 'acc_s_t_p') {
            $render_data['service'] = $this->service_model->get_service_by_id($service_id);

            $render_data['processing_data'] = $this->service_model->get_processing_data($order_id);
//            print_r($render_data['recurring_data']);die;
            $render_data['edit_data'] = $this->Service->get_edit_data($order_id);

            if (isset($render_data['processing_data'])) {
                $state = $render_data['processing_data']->state;
                $render_data['state'] = $this->service->get_state_name($state);

                $county = $render_data['state']->id;

                $render_data['county'] = $this->service->get_county_by_state_name($county);
            }

            $render_data['state_list'] = $this->service_model->get_states();


            $edit_data = $this->salestax_model->get_sales_by_id($order_id);
            $render_data['company_id'] = $edit_data['reference_id'];
            $render_data['edit_data'] = $edit_data;
            $render_data['staffInfo'] = staff_info();

            $reference_id = $this->salestax_model->get_sales_by_id($order_id)['reference_id'];
            $render_data['override_price'] = $this->salestax_model->get_override_price($service_id, $order_id)[0];
        } elseif ($service_shortcode == 'acc_r_u_a') {
            $edit_data = $this->rt6_model->get_sales_by_id($order_id);
            $render_data['company_id'] = $edit_data['reference_id'];
            $render_data['edit_data'] = $edit_data;
            $render_data['staffInfo'] = staff_info();

            $reference_id = $this->rt6_model->get_sales_by_id($order_id)['reference_id'];


            $render_data['all_driver_license'] = $this->rt6_model->get_salestax_driver_license_data_by_order_id($order_id);

            $render_data['get_override_price'] = $this->rt6_model->get_override_price($service_id, $edit_data['id']);

            $render_data["reference_id"] = $reference_id;

            $render_data['sales_tax_data'] = $this->rt6_model->get_rt6_data($order_id);

            if (!empty($render_data['sales_tax_data'])) {
                $render_data['sales_tax_data'] = $render_data['sales_tax_data'][0];
            }

            $render_data['rt6_data'] = $this->service_model->get_service_by_shortcode('acc_r');
        }
        $this->load->template('services/related_services_form_' . $serv_name, $render_data);
    }

    public function related_services_form_view($service_id, $order_id) {
        $this->load->model('system');
        $this->load->model('bookkeeping_model');
        $this->load->model('payroll');
        $this->load->model('salestax_model');
        $this->load->model('Service');
        $this->load->model('service_model');
        $this->load->model('rt6_model');
        $this->load->model('Documents');
        $service = $this->service_model->get_service($service_id);
        $service_name = $service['description'];
        $service_shortcode = $service['ideas'];
        $this->load->layout = 'dashboard';
        $title = $service_name . " Form";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'home';
        $render_data['header_title'] = $title;
        $render_data['service_id'] = $service_id;
        $render_data['order_id'] = $order_id;
        $render_data['reference_id'] = $this->service_model->get_order_by_id($order_id)['reference_id'];
        $serv_name = strtolower(preg_replace('/\s+/', '_', trim($service_name)));
        if ($service_shortcode == 'acc_b_b_d') {
            $render_data['override_price'] = $this->system->check_if_related_service_exists($service_id, $order_id)['price_charged'];
            $render_data['acc_list'] = $this->Documents->loadAccountsListpdf($render_data['reference_id']);
        } elseif ($service_shortcode == 'acc_r_b') {
            $render_data['override_price'] = $this->system->check_if_related_service_exists($service_id, $order_id)['price_charged'];
            $render_data['bookkeeping_data'] = $this->bookkeeping_model->get_bookkeeping_by_order_id($order_id);
            $render_data['acc_list'] = $this->Documents->loadAccountsListbydatepdf($render_data['reference_id']);
        } elseif ($service_shortcode == 'acc_p') {
            $render_data['rt6_data'] = $this->service_model->get_service_by_shortcode('acc_r');
            $render_data['payroll_account_numbers'] = $this->payroll_model->get_payroll_account_numbers_by_order_id($order_id);
            $render_data['payroll_data'] = $this->payroll->payroll_data($render_data['reference_id']);
            $render_data['company_data'] = $this->payroll->get_company_by_id($render_data['reference_id']);
//$render_data['notes_data'] = $this->payroll->get_note_by_reference_id($edit_data['reference_id']);
            $render_data['payroll_approver'] = $this->payroll->get_payroll_approver_by_reference_id($render_data['reference_id']);
            $render_data['company_principal'] = $this->payroll->get_company_principal_by_reference_id($render_data['reference_id']);
            $render_data['all_driver_license'] = $this->payroll->get_payroll_driver_license_data_by_reference_id($render_data['reference_id']);
//$render_data['employee_notes'] = $this->payroll->get_payroll_employee_notes_by_reference_id($edit_data['reference_id']);
            $render_data['employee_details'] = $this->payroll->get_payroll_employee_details_by_reference_id($render_data['reference_id']);
            $render_data['employee_list'] = $this->employee->loadEmployeeList($render_data['reference_id']);
//$render_data['inter_data'] = $this->Service->get_payroll_internal($edit_data['reference_id']);
            $render_data['payroll_data_for_new_existing'] = $this->payroll->get_payroll_data($render_data['reference_id']);
            $render_data['get_override_price'] = $this->payroll->get_override_price($render_data['rt6_data']['id'], $order_id);
            $render_data['signer_data'] = $this->payroll->get_signer_data($render_data['reference_id']);
            $render_data['company_data'] = $this->payroll_model->get_company_by_id($render_data['reference_id']);
            $render_data['payroll_company_data'] = $this->payroll_model->get_payroll_company_data_by_order_id($order_id);
            $render_data['owner_list'] = $this->service_model->get_owner_list($render_data['reference_id']);
            $render_data['biweekly_xls_list'] = $this->payroll_model->uploaded_xls_list($render_data['reference_id'], 1);
            $render_data['weekly_xls_list'] = $this->payroll_model->uploaded_xls_list($render_data['reference_id'], 2);
        } elseif ($service_shortcode == 'acc_s_t_a') {
            $render_data['rt6_data'] = $this->service_model->get_service_by_shortcode('acc_r');
            $render_data['all_driver_license'] = $this->salestax_model->get_salestax_driver_license_data_by_order_id($order_id);

            $render_data['get_override_price'] = $this->salestax_model->get_override_price($render_data['rt6_data']['id'], $order_id);

            $render_data['sales_tax_data'] = $this->salestax_model->get_salestax_data($order_id)[0];


            $state = $render_data['sales_tax_data']['state_recurring'];
            $render_data['state_list'] = $this->service_model->get_states();
            $render_data['state'] = $this->service->get_state_name($state);
            $county = $render_data['state']->id;

            $render_data['county'] = $this->service->get_county_by_state_name($county);
        } elseif ($service_shortcode == 'acc_s_t_r') {
            $render_data['recurring_data'] = $this->service_model->get_recurring_data($order_id);

            $render_data['edit_data'] = $this->Service->get_edit_data($order_id);

            if (isset($render_data['recurring_data'])) {
                $state = $render_data['recurring_data']->state;

                $render_data['state'] = $this->service->get_state_name($state);
                $county = $render_data['state']->id;
                $render_data['county'] = $this->service->get_county_by_state_name($county);
            }

            $render_data['state_list'] = $this->service_model->get_states();


            $edit_data = $this->salestax_model->get_sales_by_id($order_id);
            $render_data['override_price'] = $this->salestax_model->get_override_price($service_id, $order_id)[0];
            $render_data['company_id'] = $edit_data['reference_id'];
            $render_data['edit_data'] = $edit_data;
            $render_data['staffInfo'] = staff_info();
            $render_data['state_name'] = $this->service_model->getStateName($render_data['recurring_data']->state);
//$result['county'] = $this->service_model->getCounty($result['recurring_data']->county);
        } elseif ($service_shortcode == 'acc_s_t_p') {
            $render_data['service'] = $this->service_model->get_service_by_id($service_id);

            $render_data['processing_data'] = $this->service_model->get_processing_data($order_id);
//            print_r($render_data['recurring_data']);die;
            $render_data['edit_data'] = $this->Service->get_edit_data($order_id);

            if (isset($render_data['processing_data'])) {
                $state = $render_data['processing_data']->state;
                $render_data['state'] = $this->service->get_state_name($state);

                $county = $render_data['state']->id;

                $render_data['county'] = $this->service->get_county_by_state_name($county);
            }

            $render_data['state_list'] = $this->service_model->get_states();


            $edit_data = $this->salestax_model->get_sales_by_id($order_id);
            $render_data['company_id'] = $edit_data['reference_id'];
            $render_data['edit_data'] = $edit_data;
            $render_data['staffInfo'] = staff_info();
            $render_data['state_name'] = $this->service_model->getStateName($render_data['processing_data']->state);
            $reference_id = $this->salestax_model->get_sales_by_id($order_id)['reference_id'];
            $render_data['override_price'] = $this->salestax_model->get_override_price($service_id, $order_id)[0];
        } elseif ($service_shortcode == 'acc_r_u_a') {
            $edit_data = $this->rt6_model->get_sales_by_id($order_id);
            $render_data['company_id'] = $edit_data['reference_id'];
            $render_data['edit_data'] = $edit_data;
            $render_data['staffInfo'] = staff_info();

            $reference_id = $this->rt6_model->get_sales_by_id($order_id['reference_id']);
            $render_data['all_driver_license'] = $this->rt6_model->get_salestax_driver_license_data_by_order_id($order_id);

            $render_data['get_override_price'] = $this->rt6_model->get_override_price($service_id, $edit_data['id']);

            $render_data["reference_id"] = $reference_id;

            $render_data['sales_tax_data'] = $this->rt6_model->get_rt6_data($order_id);

            if (!empty($render_data['sales_tax_data'])) {
                $render_data['sales_tax_data'] = $render_data['sales_tax_data'][0];
            }

            $render_data['rt6_data'] = $this->service_model->get_service_by_shortcode('acc_r');
        }
        $render_data['service_shortcode'] = $service_shortcode;

        $this->load->template('services/view_related_services_form', $render_data);
    }

    public function get_staff_dropdown_val() {
        $val = post('val');
        $type = post('type');
        $this->load->model('system');
        if ($type == 'dept') {
            $staff_list = $this->system->get_staff_ids_by_department_id($val);
            foreach ($staff_list as $sl):
                $staff_ids[] = $sl['staff_id'];
            endforeach;
        }elseif ($type == 'office') {
            $staff_list = $this->system->get_staff_ids_by_office_id($val);
            foreach ($staff_list as $sl):
                $staff_ids[] = $sl['staff_id'];
            endforeach;
        }else {
            $staff_list = $this->system->get_staff_ids_of_admin_user();
            foreach ($staff_list as $sl):
                $staff_ids[] = $sl['id'];
            endforeach;
        }

        $return = '';
        if (isset($staff_ids) && count($staff_ids) > 0) {
//$return .= "<select id='filter_staff_list' class='form-control staff-dropdown' name='filter_staff_list'>";
            $return .= "<option value=''>Select a staff</option>";
            foreach ($staff_ids as $staff_id):
                $st = $this->system->get_staff_info($staff_id);
                $return .= "<option value='" . $st['id'] . "'>" . $st['first_name'] . " " . $st['last_name'] . "</option>";
            endforeach;
//$return .= "</select>";
        }else {
//$return .= "<select id='filter_staff_list' class='form-control staff-dropdown' name='filter_staff_list'>";
            $return .= "<option value=''>Select a staff</option>";
//$return .= "</select>";
        }
        echo $return;
    }

    public function get_filter_dropdown_options() {
        $resultval['val'] = post('val');
        $resultval['ofc_val'] = post('ofc_val');
        $this->load->view('services/filter_options', $resultval);
    }

    public function get_filter_dropdown_options_multiple_dateval() {
        $resultval['val'] = post('val');
        $resultval['variable_ddval'] = post('variable_ddval');
        $this->load->view('services/filter_options_multiple_dateval', $resultval);
    }

    public function filter_form() {
        $render_data['result'] = $this->service_model->ajax_services_dashboard_filter('', '', '', '', '', '', '', '', post());
//print_r($render_data['result']);
        $render_data['serviceid'] = $this->service_model->getServiceId();
        $this->load->view('services/ajax_dashboard', $render_data);
    }

    public function assign_order() {
        $order_id = post('order_id');
        if (post('staff_id') != '') {
            $staff_id = post('staff_id');
        } else {
            $staff_id = sess('user_id');
        }
        if ($this->service_model->assign_order_by_order_id($order_id, $staff_id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function assign_service() {
        $service_id = post('service_id');
        if (post('staff_id') != '') {
            $staff_id = post('staff_id');
        } else {
            $staff_id = sess('user_id');
        }
        if ($this->service_model->assign_service_by_service_id($service_id, $staff_id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function sort_service_dashboard() {
        $formdata = post();
        $sort_criteria = $formdata['sort_criteria'];
        $sort_type = $formdata["sort_type"];
        unset($formdata['sort_criteria']);
        unset($formdata['sort_type']);
        $filter_assign = $formdata;

        $render_data['serviceid'] = $this->service_model->getServiceId();

        $render_data["result"] = $this->service_model->ajax_services_dashboard_filter('', '', '', '', '', '', '', '', $filter_assign, '', $sort_criteria, $sort_type);
        $this->load->view("services/ajax_dashboard", $render_data);
    }

    public function service_filter() {
        $render_data['serviceid'] = $this->service_model->getServiceId();
        $render_data['result'] = $this->service_model->ajax_services_dashboard_filter('', '', '', '', '', '', '', '', post(), '', '', '');
        $this->load->view("services/ajax_dashboard", $render_data);
    }

    public function select_existing_owner() {
        $company_id = post('company_id');
        $individual_id = post('individual_id');
        $company_type = post('company_type');
        $percentage = post('percentage');
        $old_individual_id = post('old_individual_id');
        $title_id = post('title_id');
        $ownertitle = post('ownertitle');
        $get_title_data_by_title_id = $this->service_model->get_title_data_by_title_id($individual_id);
        if (!empty($get_title_data_by_title_id)) {
            unset($get_title_data_by_title_id['id']);
            $get_title_data_by_title_id['company_id'] = $company_id;
            $get_title_data_by_title_id['existing_reference_id'] = $company_id;
            $get_title_data_by_title_id['company_type'] = $company_type;
            $get_title_data_by_title_id['percentage'] = $percentage;
            $get_title_data_by_title_id['title'] = $ownertitle;
            $update_title_data = $this->service_model->update_title_data($get_title_data_by_title_id, $title_id);
            $this->service_model->delete_old_individual($old_individual_id);
            //$insert_title_id = $this->db->insert_id();
        }
    }

    public function related_services($service_request_id, $type = 'edit') {
        $this->load->layout = 'dashboard';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'service_dashboard';
        

        $render_data['service_request_id'] = $service_request_id;
        $render_data['service_request_details'] = $service_request_details = $this->service_model->get_service_request_by_id($service_request_id);
        if (empty($render_data['service_request_details'])) {
            redirect(base_url('services/home'));
        }
        $render_data['service_details'] = $service_details = $this->service_model->get_service_by_id($service_request_details['services_id']);
        $title = $render_data['service_details']['description'];
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['header_title'] = $title;
        $render_data['order_details'] = $order_details = $this->service_model->get_order_by_id($service_request_details['order_id']);
        $render_data['related_service_files'] = $this->service_model->get_related_service_files_by_id($service_request_id);
        $render_data['service_name'] = $service_name = $service_details['description'];
        $render_data['service_shortname'] = $service_shortname = $service_details['ideas'];
        $render_data['service_id'] = $service_id = $service_request_details['services_id'];
        $render_data['order_id'] = $order_id = $service_request_details['order_id'];
        $render_data['reference_id'] = $reference_id = $order_details['reference_id'];
        $render_data['reference'] = $reference = $order_details['reference'];
        if ($reference == 'company') {
            $render_data['company_info'] = $this->company_model->get_company_by_id($render_data['reference_id']);
            if (!empty($render_data['company_info'])) {
                $renewal_date_info = $this->service_model->get_renewal_dates($render_data['company_info']['state_opened'], $render_data['company_info']['type']);
                $due_date = date('m/d/Y', strtotime($renewal_date_info['date']));
            }
        }
        $render_data['order_extra_data'] = [];
        switch ($service_shortname):
            case 'inc_n_c_f':
            case 'inc_n_c_d':
            case 'inc_n_c_b_v_i':
            case 'inc_n_c_o': {      // New Company
                    if ($reference == 'company') {
                        $render_data['company_name_option'] = $this->company_model->get_company_name_by_company_id($reference_id);
                    }
                }
                break;
            case 'acc_r_b':
            case 'acc_b_b_d': {      // Bookkeeping--2019
                    $render_data['bookkeeping_details'] = $this->bookkeeping_model->get_bookkeeping_by_order_id($order_id);
                }
                break;
            case 'inc_o_a': {     // Operating Agreement--2019
                    $render_data['order_extra_data'] = $this->service_model->get_extra_data($order_id);
                }
                break;
            case 'acc_s_t_a': {      // Sales Tax Application--2019
                    $render_data['rt6_data'] = $this->service_model->get_service_by_shortcode('acc_r');
                    $render_data['all_driver_license'] = $this->salestax_model->get_salestax_driver_license_data_by_order_id($order_id);
                    $render_data['sales_tax_application_details'] = $this->salestax_model->get_sales_tax_application_by_order_id($order_id);
                }
                break;
            case 'acc_s_t_r': {      // Sales Tax Recurring--2019
                    $render_data['sales_tax_recurring_details'] = $this->service_model->get_recurring_data_by_order_id($order_id);
                }
                break;
            case 'acc_s_t_p': {      // Sales Tax Processing--2019
                    $render_data['sales_tax_processing_details'] = $this->service_model->get_processing_data_by_order_id($order_id);
                }
                break;
            case 'acc_p': {      // Payroll
                    $render_data['payroll_account_details'] = $this->payroll_model->get_payroll_account_numbers_by_order_id($order_id);
                    $render_data['payroll_wage_files'] = $this->payroll->payroll_wage_files($order_details['reference_id']);
                    $render_data['payroll_data'] = $this->payroll->payroll_data($order_details['reference_id']);
                    $render_data['payroll_approver'] = $this->payroll->get_payroll_approver_by_reference_id($order_details['reference_id']);
                    $render_data['company_principal'] = $this->payroll->get_company_principal_by_reference_id($order_details['reference_id']);
                    $render_data['signer_data'] = $this->payroll->get_signer_data($order_details['reference_id']);
                }
                break;
            case 'inc_n_c_n_p_f':   // Create Company - Non Profit Florida
            case 'inc_n_f_p': {         //  New Florida PA--2019
                    if ($reference == 'company') {
                        $render_data['company_name_option'] = $this->company_model->get_company_name_by_company_id($reference_id);
                    }
                    $render_data['order_extra_data'] = $this->service_model->get_extra_data($order_id);
                }
                break;
            case 'acc_r_a_-_u': {      //  Rt6 Unemployment App--2019
                    $render_data['rt6_details'] = $this->service_model->get_rt6_data_by_order_id($order_id);
                }
                break;
            case 'inc_f_a_r':
            case 'inc_d_a_r': {     //     Annual Report--2019
                    if (isset($due_date)) {
                        $render_data['due_date'] = $due_date;
                    }
                }
                break;
            case 'acc_1_w_u': {      //  1099 Write Up
                    $render_data['payer_information'] = $this->service_model->get_payer_info($order_id);
                    $render_data['recipient_information'] = $this->service_model->get_recipient_info($order_id);                
                }
        endswitch;
        $render_data['service_id2'] = $this->service_model->get_service_id_for_1099_service($render_data['reference_id'], $render_data['order_id']);
        $render_data['client_id'] = $this->service_model->get_practice_id($render_data['reference_id']);
        $this->load->template('services/related_services', $render_data);
    }

    public function request_save_related_service() {
        if ($this->service_model->save_related_service(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function delete_related_service_file($file_id) {
        if ($this->service_model->related_service_file_delete($file_id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function get_existing_client_list() {
        load_ddl_option("existing_client_list");
    }

    public function clientTypeYes() {
        $this->load->view('services/extra_field_service_existing_client');
    }

    public function service_list_ajax() {
        $render_data = post();
        $render_data['order_info'] = $order_info = $this->service_model->get_order_info_by_id($render_data['order_id']);
        $render_data['services_list'] = $this->service_model->get_service_list_by_order_id($render_data['order_id']);
        $render_data['is_order']=$order_info['is_order'];
        $render_data['reference_id'] = $order_info['company_id'];
        $render_data['service_id'] = $order_info['service_id'];
        $render_data['invoiced_id'] = $order_info['invoiced_id'];
        $render_data['requested_staff_id'] = $order_info['staff_requested_service'];
        $all_staff_id_list = explode(',', $render_data['all_staffs']);
        $all_staff_id_list = array_merge($all_staff_id_list, [$render_data['requested_staff_id']]);
        $all_staff_id_list = array_unique($all_staff_id_list);
        $render_data['all_staff_id_list'] = implode(',', $all_staff_id_list);
        $this->load->view('services/order_service_inner_content', $render_data);
    }

    public function get_payroll_account_list() {
        $reference_id = post('reference_id');
        $data['account_details'] = $this->company_model->get_account_details($reference_id);
        $this->load->view('services/show_payroll_account_list', $data);
    }

    public function save_recipient() {        
        echo $this->service_model->save_recipient(post());
    }

    public function get_recipient_list() {
        // $data['disable'] = post('disable');
        $data['list'] = $this->service_model->get_recipient_list_by_reference(post('reference_id'), post('reference'));
        $this->load->view('services/show_recipient_list', $data);
    }
    public function get_recipient_list_count() {
        // $data['disable'] = post('disable');
        $data['list'] = $this->service_model->get_recipient_list_by_reference(post('reference_id'), post('reference'));
        echo count($data['list']);
    }

    public function recipient_delete()
    {
       $id = post()['id'];                 
       echo $data['recipient'] = $this->service_model->recipent_delete($id);     
    }

    public function update_recipient()
    {
        echo $this->service_model->update_recipient(post());
    }
}

// End controller class

