<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Incorporation extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('system');
        $this->load->model('service_model');
        $this->load->model('company_model');
        $this->staff_info = $this->system->get_staff_info(sess('user_id'));
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Incorporation";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $this->load->template('services/incorporation', $render_data);
    }

    public function create_company() {
        $this->load->layout = 'dashboard';
        $title = "Create Company";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $render_data['service'] = $render_data['florida'] = $this->service_model->get_service_by_shortname('inc_n_c_f');
        $render_data['delaware'] = $this->service_model->get_service_by_shortname('inc_n_c_d');
        $render_data['bvi'] = $this->service_model->get_service_by_shortname('inc_n_c_b_v_i');
        $render_data['oth'] = $this->service_model->get_service_by_shortname('inc_n_c_o');
        $render_data['service_id'] = $render_data['florida']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_company', $render_data);
    }

    public function create_company_non_profit_fl() {
        $this->load->layout = 'dashboard';
        $title = "Create Company - Non Profit Florida";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $render_data['service'] = $this->service_model->get_service_by_shortname('inc_n_c_n_p_f');
        $render_data['service_id'] = $render_data['service']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_company_non_profit_fl', $render_data);
    }

    public function create_new_florida_pa() {
        $this->load->layout = 'dashboard';
        $title = "Create New Florida PA";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $render_data['service'] = $this->service_model->get_service_by_shortname('inc_n_f_p');
        $render_data['service_id'] = $render_data['service']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_new_florida_pa', $render_data);
    }

    public function create_annual_report() {
        $this->load->layout = 'dashboard';
        $title = "Create Annual Report";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $render_data['florida'] = $this->service_model->get_service_by_shortname('inc_f_a_r');
        $render_data['delaware'] = $this->service_model->get_service_by_shortname('inc_d_a_r');
        $render_data['arizona'] = $this->service_model->get_service_by_shortname('inc_a_a_r');
        $render_data['wyoming'] = $this->service_model->get_service_by_shortname('inc_w_a_r');
        $render_data['michigan'] = $this->service_model->get_service_by_shortname('inc_m_a_r_c');
        $render_data['texas'] = $this->service_model->get_service_by_shortname('inc_t_a_r');
        $render_data['new_jersey'] = $this->service_model->get_service_by_shortname('inc_n_j_a_r');
        $render_data['new_york'] = $this->service_model->get_service_by_shortname('inc_n_y_a_r');
//        print_r($render_data['michigan']);exit;
        $render_data['service_id'] = $render_data['florida']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_annual_report', $render_data);
    }

    public function request_create_company() {
        // print_r(post());exit;
        $order_id=$this->company_model->request_create_company(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function request_create_company_non_profit_fl() {
        $order_id=$this->company_model->request_create_company_non_profit_fl(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function request_create_new_florida_pa() {
        $order_id=$this->company_model->request_create_new_florida_pa(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function request_create_annual_report() {
        $order_id=$this->company_model->request_create_annual_report(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function getretailprice() {
        $data = $this->company_model->getretailprice(post());
        echo $data['retail_price'];
    }

    public function getrelatedservices() {
        $service_id = post('service_id');
        load_ddl_option("get_select_service", "", $service_id);
    }

    public function edit_company($edit_id) {
        $render_data = array();
        $this->load->model('Staff');
        $this->load->model('FormFields');
        $this->load->model('Company');
        $this->load->model('Contacts');
        $this->load->model('Documents');
        $this->load->model('Staff');
        $this->load->model('Service');
        $this->load->model('service_model');

        $edit_id = base64_decode($edit_id);
        $edit_data = $this->Service->get_edit_data($edit_id);
        $this->load->layout = 'dashboard';
        $render_data['title'] = 'Edit Company | Tax Leaf';
        $render_data['menu'] = 'incorporation';
        $render_data['main_menu'] = 'services';
        $render_data['header_title'] = 'Edit Company';
        $render_data['staffInfo'] = staff_info();
        $render_data['company_id'] = $edit_data[0]['reference_id'];
        $render_data['edit_data'] = $edit_data;
        $render_data['service'] = $this->Service->getService(1);
        $render_data['quant_documents'] = $this->Documents->getQuantDocumentsByReference("company", $edit_data[0]['reference_id']);
        $render_data['quant_contact'] = $this->Contacts->getQuantContactByReference("company", $edit_data[0]['reference_id']);
        $render_data['quant_title'] = $this->Company->getQuantTitle($edit_data[0]['reference_id']);
        $render_data['other_business_name'] = $this->Service->get_other_business_name($edit_data[0]['reference_id']);
        $render_data['related_services'] = $this->Service->editgetRelatedService($edit_data[0]['id']);
        if ($edit_data[0]['state_opened'] == 8) {
            $del_serv_id = $this->service_model->get_service_by_shortname('inc_n_c_d');
            $render_data['all_related_services'] = $this->Service->getallRelatedService($del_serv_id['id']);
            $render_data['related_service'] = $this->Service->getRelatedService($del_serv_id['id']);
        } else {
            $render_data['all_related_services'] = $this->Service->getallRelatedService(1);
            $render_data['related_service'] = $this->Service->getRelatedService(1);
        }
        $this->load->template('services/edit_company', $render_data);
    }

    public function create_fien_application() {
        $this->load->layout = 'dashboard';
        $title = "Create FEIN Application";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $render_data['service_info'] = $this->service_model->get_service_by_shortname('inc_f_a');
        $render_data['service_id'] = $render_data['service_info']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_fien_application', $render_data);
    }

    public function create_certificate_of_good_standing() {
        $this->load->layout = 'dashboard';
        $title = "Certificate of Good Standing";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $render_data['service_info'] = $this->service_model->get_service_by_shortname('inc_c_o_g_s_d');
        $render_data['service_id'] = $render_data['service_info']['id'];
        $render_data['service_info_fl'] = $this->service_model->get_service_by_shortname('inc_c_o_g_s_f');
        $render_data['service_id_fl'] = $render_data['service_info_fl']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_certificate_of_good_standing', $render_data);
    }

    public function create_certificate_shares() {
        $this->load->layout = 'dashboard';
        $title = "Create Certificate Shares";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $id = $this->service_model->get_service_by_shortname('inc_c_s');
        $render_data['service_id'] = $id['id'];
        $render_data['service'] = $this->service_model->get_service_by_id($id['id']);
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['twenty_certificate_shares'] = $this->service_model->get_service_by_shortname('inc_2_b_c_o_s');
        $render_data['corp_book'] = $this->service_model->get_service_by_shortname('inc_c_b');
        $render_data['shares_transfer_completion'] = $this->service_model->get_service_by_shortname('inc_s_t');
        $render_data['extra_10_cert'] = $this->service_model->get_service_by_shortname('inc_1_e_c');
        $render_data['reference'] = 'company';
//        echo '<pre>';
//        print_r($render_data);die;
        $this->load->template('services/create_certificate_shares', $render_data);
    }

    public function create_operating_agreement() {
        $this->load->layout = 'dashboard';
        $title = "Operating Agreement";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $render_data['service_info'] = $this->service_model->get_service_by_shortname('inc_o_a');
        $render_data['service_id'] = $render_data['service_info']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_operating_agreement', $render_data);
    }

    function request_create_operating_agreement() {
        $order_id = $this->company_model->request_create_operating_agreement(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    function edit_operating_agreement($id) {
        $this->load->layout = 'dashboard';
        $title = "Edit Operating Agreement";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $this->load->template('edit_operating_agreement', $render_data);
    }

    function request_create_certificate_of_good_standing() {
        $order_id = $this->company_model->request_create_certificate_of_good_standing(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    function request_create_certificate_shares() {
        $order_id = $this->company_model->request_create_certificate_shares(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function edit_fein_application($id) {
//        echo $id;
        $this->load->model('salestax_model');
        $this->load->model('payroll_model');
        $this->load->model('payroll');
        $this->load->model('Service');
        $this->load->model('service_model');
        $this->load->model('company_model');

        $this->load->layout = 'dashboard';
        $title = "Edit FEIN Application";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;

        $edit_data = $this->salestax_model->get_sales_by_id($id);
        $render_data['company_id'] = $edit_data['reference_id'];
        $render_data['edit_data'] = $edit_data;
        $render_data['staffInfo'] = staff_info();
        $reference_id = $this->salestax_model->get_sales_by_id($id)['reference_id'];
        $render_data['company_data'] = $this->payroll_model->get_company_by_id($reference_id);
        $render_data['notes_data'] = $this->payroll->get_note_by_reference_id($edit_data['reference_id']);
        $render_data['inter_data'] = $this->Service->get_payroll_internal($edit_data['reference_id']);
        $render_data["service_id"] = 4;
        $render_data["reference_id"] = $reference_id;
        $render_data["reference"] = $this->salestax_model->get_sales_by_id($id)['reference'];
        $render_data['owner_list'] = $this->service_model->get_owner_list($reference_id);
        $render_data['fein_details'] = $this->company_model->get_fein_details($edit_data['reference_id']);
        $service = $this->service_model->get_service_by_shortname('inc_f_a');
//        $render_data['service_id'] = $service['id'];
        $render_data['retail_price'] = $service['retail_price'];
//        echo '<pre>';print_r($render_data);die;
        $this->load->template('services/edit_fien_application', $render_data);
    }

    function request_create_fien_application() {
        $order_id = $this->company_model->request_create_fien_application(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function create_corporate_amendment() {
        $this->load->layout = 'dashboard';
        $title = "Create Corporate Amendment";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'incorporation';
        $render_data['header_title'] = $title;
        $render_data['service_info'] = $this->service_model->get_service_by_shortname('inc_c_a');
        $render_data['service_id'] = $render_data['service_info']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_corporate_amendment', $render_data);
    }

    function request_create_corporate_amendment() {
        $order_id = $this->company_model->request_create_corporate_amendment(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function modify_retail_price() {
        $value = post('value');
        $ref_id = post('ref_id');
        if ($value == '') {
            if ($ref_id != '') {
                $typeval = $this->company_model->get_company_by_id($ref_id)['type'];
            } else {
                $typeval = '';
            }
        } else {
            $typeval = $value;
        }
        if ($typeval != 3 && $typeval != 6) {
            $render_data['value'] = $typeval;
            $render_data['corporate_service_info'] = $this->service_model->get_service_by_shortname('inc_c_b2');
            $render_data['shareholders_service_info'] = $this->service_model->get_service_by_shortname('inc_s_a');
            $this->load->view('services/modify_retail_price', $render_data);
        }
    }

    public function change_retail_price() {
        $value = post('value');
        $ref_id = post('ref_id');
        if ($value == '') {
            if ($ref_id != '') {
                $stateval = $this->company_model->get_company_by_id($ref_id)['state_opened'];
            } else {
                $stateval = '';
            }
        } else {
            $stateval = $value;
        }
        echo $stateval;
    }

}

?>
