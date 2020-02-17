<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting_services extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model("payroll_model");
        $this->load->model("staff");
        $this->load->model("service");
        $this->load->model("system");
        $this->load->model("service_model");
        $this->load->model("bookkeeping_model");
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Accounting Services";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $this->load->template('services/accounting_services', $render_data);
    }

    public function edit_payroll($id) {
        $this->load->model('FormFields');
        $this->load->model('Contacts');
        $this->load->model('Company');
        $this->load->model('Documents');
        $this->load->model('Service');
        $this->load->model('Staff');
        $this->load->model('payroll');
        $this->load->model('payroll_model');
        $this->load->model('service_model');

        $this->load->layout = 'dashboard';
        $title = "Edit Payroll";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;

        $id = base64_decode($id);
        $render_data['rt6_data'] = $this->service_model->get_service_by_id(42);
        $edit_data = $this->payroll_model->get_payroll_by_id($id);
        $render_data['company_id'] = $edit_data['reference_id'];
        $render_data['edit_data'] = $edit_data;
        $render_data['staffInfo'] = staff_info();

        $reference_id = $edit_data['reference_id'];

        $render_data['quant_contact'] = $this->Contacts->getQuantContactByReference("company", $edit_data['reference_id']);
        $render_data['quant_account'] = $this->Documents->getQuantAccountsByReference($edit_data['reference_id']);
        $render_data['quant_documents'] = $this->Documents->getQuantDocumentsByReference("company", $edit_data['reference_id']);
        $render_data['quant_title'] = $this->Company->getQuantTitle($edit_data['reference_id']);
        $render_data['completed_orders'] = $this->Service->completed_orders();
        $render_data['payroll_company_data'] = $this->payroll_model->get_payroll_company_data_by_order_id($id);
//        $render_data['payroll_account_numbers'] = $this->payroll->payroll_account_numbers($edit_data['reference_id']);
        $render_data['payroll_account_numbers'] = $this->payroll_model->get_payroll_account_numbers_by_order_id($id);
        $render_data['payroll_data'] = $this->payroll->payroll_data($edit_data['reference_id']);
        $render_data['company_data'] = $this->payroll->get_company_by_id($edit_data['reference_id']);
        $render_data['notes_data'] = $this->payroll->get_note_by_reference_id($edit_data['reference_id']);
        $render_data['payroll_approver'] = $this->payroll->get_payroll_approver_by_reference_id($edit_data['reference_id']);
        $render_data['company_principal'] = $this->payroll->get_company_principal_by_reference_id($edit_data['reference_id']);
        $render_data['all_driver_license'] = $this->payroll->get_payroll_driver_license_data_by_reference_id($edit_data['reference_id']);
        $render_data['employee_notes'] = $this->payroll->get_payroll_employee_notes_by_reference_id($edit_data['reference_id']);
        $render_data['employee_details'] = $this->payroll->get_payroll_employee_details_by_reference_id($edit_data['reference_id']);
        $render_data['inter_data'] = $this->Service->get_payroll_internal($edit_data['reference_id']);
        $render_data['payroll_data_for_new_existing'] = $this->payroll->get_payroll_data($edit_data['reference_id']);
        $render_data['get_override_price'] = $this->payroll->get_override_price(42, $edit_data['id']);
        $render_data['signer_data'] = $this->payroll->get_signer_data($edit_data['reference_id']);
        $render_data["service_id"] = 11;
        $render_data["reference_id"] = $reference_id;
        $render_data["reference"] = $this->payroll_model->get_payroll_by_id($id)['reference'];
        $render_data['existing_client'] = $this->payroll_model->get_payroll_data($reference_id)[0];
        $render_data['completed_orders'] = $this->service_model->completed_orders();
        $render_data['company_data'] = $this->payroll_model->get_company_by_id($reference_id);
        $render_data['payroll_company_data'] = $this->payroll_model->get_payroll_company_data_by_order_id($id);
        $render_data['owner_list'] = $this->service_model->get_owner_list($reference_id);
        $render_data['biweekly_xls_list'] = $this->payroll_model->uploaded_xls_list($reference_id, 1);
        $render_data['weekly_xls_list'] = $this->payroll_model->uploaded_xls_list($reference_id, 2);
        $render_data['other_state'] = $render_data['company_data']['state_others'];
        // $render_data['other_state'] = "Hello";

        $this->load->template('services/edit_payroll', $render_data);
    }

    public function edit_bookkeeping_by_date($edit_id) {
        $render_data = array();
        $this->load->model('Staff');
        $this->load->model('FormFields');
        $this->load->model('Company');
        $this->load->model('Contacts');
        $this->load->model('Documents');
        $this->load->model('Staff');
        $this->load->model('Service');

        $edit_id = base64_decode($edit_id);
        $edit_data = $this->Service->get_edit_data($edit_id);
        $this->load->layout = 'dashboard';
        $title = "Edit Bookkeeping By Date";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;

        $render_data['staffInfo'] = staff_info();
        $render_data['company_id'] = $edit_data[0]['reference_id'];
        $render_data['edit_data'] = $edit_data;
        $render_data['service'] = $this->Service->getService(41);
        $render_data['related_service'] = $this->Service->getRelatedService(41);
        $render_data['quant_account'] = $this->Documents->getQuantAccountsByReference($edit_data[0]['reference_id']);
        $render_data['quant_documents'] = $this->Documents->getQuantDocumentsByReference("company", $edit_data[0]['reference_id']);
        $render_data['quant_contact'] = $this->Contacts->getQuantContactByReference("company", $edit_data[0]['reference_id']);
        $render_data['other_state'] = $edit_data[0]['state_others']; // added
        $render_data['quant_title'] = $this->Company->getQuantTitle($edit_data[0]['reference_id']);
        $render_data['completed_orders'] = $this->Service->completed_orders();
        $render_data['other_business_name'] = $this->Service->get_other_business_name($edit_data[0]['reference_id']);
        $render_data['get_bookkeeping'] = $this->bookkeeping_model->get_bookkeeping_by_order_id($edit_id);
        $this->load->template('services/edit_bookkeeping_by_date', $render_data);
    }

    public function edit_bookkeeping($edit_id) {
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
        $title = "Edit Bookkeeping";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;

        $render_data['staffInfo'] = staff_info();
        $render_data['company_id'] = $edit_data[0]['reference_id'];
        $render_data['edit_data'] = $edit_data;
        $render_data['other_state'] = $edit_data[0]['state_others']; // added
        $render_data['service'] = $this->Service->getService(10);
        $render_data['related_service'] = $this->Service->getRelatedService(10);
        $render_data['quant_account'] = $this->Documents->getQuantAccountsByReference($edit_data[0]['reference_id']);
        $render_data['quant_documents'] = $this->Documents->getQuantDocumentsByReference("company", $edit_data[0]['reference_id']);
        $render_data['quant_contact'] = $this->Contacts->getQuantContactByReference("company", $edit_data[0]['reference_id']);
        $render_data['quant_title'] = $this->Company->getQuantTitle($edit_data[0]['reference_id']);
        $render_data['other_business_name'] = $this->Service->get_other_business_name($edit_data[0]['reference_id']);
        $render_data['related_services'] = $this->Service->editgetRelatedService($edit_data[0]['id']);
        $render_data['all_related_services'] = $this->Service->getallRelatedService(10);
        $render_data['completed_orders'] = $this->Service->completed_orders();
        $render_data['other_business_name'] = $this->Service->get_other_business_name($edit_data[0]['reference_id']);
        $render_data['get_bookkeeping'] = $this->bookkeeping_model->get_bookkeeping_by_order_id($edit_id);

        $this->load->template('services/edit_bookkeeping', $render_data);
    }

    public function create_bookkeeping_by_date() {
        $this->load->layout = 'dashboard';
        $title = "Create Bookkeeping by Date";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $render_data['service_id'] = 41;
//        $render_data['service'] = $this->service_model->get_service_by_id(41);
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $render_data['completed_orders'] = $this->service->completed_orders();
        $this->load->template('services/create_bookkeeping_by_date', $render_data);
    }

//    public function save_bookkeeping_by_date() {
//        echo $this->bookkeeping_model->update_bookkeeping_by_date(post());
//    }

    public function get_month_diff() {
        $start_date = explode("/", $this->input->post('start_date'));
        $end_date = explode("/", $this->input->post('end_date'));
        $start_date = date_create($start_date[1] . "-" . $start_date[0] . "-01");
        $end_date = date_create($end_date[1] . "-" . $end_date[0] . "-02");
        $diff = date_diff($start_date, $end_date);
        $df = explode(" ", $diff->format("%R %y %m"));
        if ($df[0] == "+") {
            echo (($df[1] * 12) + $df[2]) + 1;
        } else {
            echo "N";
        }
    }

    public function delete_account() {
        echo $this->bookkeeping_model->delete_financial_account(post('account_id'));
    }

    public function save_account() {
        echo $this->bookkeeping_model->save_account(post());
    }

    public function get_internal_data() {
        $reference = request('reference');
        $reference_id = request('reference_id');
        $this->load->model('Internal');
        $internal_data = $this->Internal->get_internal_data($reference, $reference_id);
        if (!empty($internal_data)) {
            echo json_encode($internal_data[0]);
        } else {
            echo 0;
        }
    }

    public function request_create_bookkeeping() {
        $order_id = $this->bookkeeping_model->request_create_bookkeeping(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'accounting_services');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function get_company_data() {
        $reference_id = post('reference_id');
        $this->load->model('Company');
        $company_data = $this->Company->get_company_data($reference_id);
        if (!empty($company_data)) {
            echo json_encode($company_data[0]);
        } else {
            echo 0;
        }
    }

    public function request_create_bookkeeping_by_date() {
        $order_id = $this->bookkeeping_model->request_create_bookkeeping_by_date(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'accounting_services');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function related_create_bookkeeping_by_date() {
        if ($this->bookkeeping_model->related_create_bookkeeping_by_date(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function related_create_recurring_bookkeeping() {
        if ($this->bookkeeping_model->related_create_recurring_bookkeeping(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function related_create_payroll() {
        $this->load->model('payroll_model');
        if ($this->payroll_model->related_create_payroll(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function create_payroll() {
        $this->load->layout = 'dashboard';
        $title = "Create Payroll";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $render_data['rt6_data'] = $this->service_model->get_service_by_id(42);
        $render_data['service_id'] = 11;
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $render_data['completed_orders'] = $this->service->completed_orders();
        $this->load->template('services/create_payroll', $render_data);
    }

    public function get_payroll_company_data() {
        $this->load->model('Payroll');
        $clientid = request('clientid');
        $new_reference_id = request('new_reference_id');
        $check_old_client_type = $this->Payroll->check_old_client_type($clientid);
        $service_id = $check_old_client_type['service_id'];
        if ($service_id == '11') {
            $get_company_data = $this->Payroll->get_company_data_payroll($clientid);
        } else {
            $get_company_data = $this->Payroll->get_company_data($clientid);
        }
        $return = $get_company_data[0];
//        $return->business_description = urldecode($return->business_description);
        echo json_encode($return);
    }

    public function get_pay_period() {
        $payroll_frequency = request('payroll_frequency');
        $payday = request('payday');
        $payday_timestamp = strtotime($payday);
        $payday_end = date('l', strtotime($payday . ' -3 Weekdays'));
        if ($payroll_frequency == 'Weekly') {
            $payday_start = date('l', strtotime($payday_end . '-6 days'));
        } elseif ($payroll_frequency == 'Biweekly') {
            $payday_start = date('l', strtotime($payday_end . '-13 days'));
        } else {
            $payday_start = date('l', strtotime($payday_end . '-30 days'));
        }
        echo "Pay period would be " . $payday_start . " - " . $payday_end;
    }

    public function copy_contact_payroll_section() {
        $reference_id = request('ref_id');
        $this->load->model('Contacts');
        $this->load->model('Payroll');
        $contactdata = $this->Contacts->copy_main_contact_payroll("company", $reference_id);
        if (!empty($contactdata)) {
            $savecontact_topayroll = $this->Payroll->save_main_contact_payroll($contactdata[0], $reference_id);
            echo json_encode($contactdata[0]);
        } else {
            echo '0';
        }
    }

    public function set_company_principal() {
        $company_princpal = $_REQUEST['company_princpal'];
        $reference_id = $_REQUEST['reference_id'];
        $this->load->model('Contacts');
        $this->load->model('Payroll');
        if ($company_princpal == 0) { //main contact
            $contactdata = $this->Contacts->copy_main_contact_payroll("company", $reference_id);
            if (!empty($contactdata)) {
                $savecontact_toprincipal = $this->Payroll->save_main_contact_principal($contactdata[0], $reference_id);
                echo json_encode($contactdata[0]);
            } else {
                echo '0';
            }
        } else { // payroll approver
            $payroll_approverdata = $this->Payroll->copy_payroll_approver($reference_id);
            if (!empty($payroll_approverdata)) {
                $savepayroll_toprincipal = $this->Payroll->save_paryroll_approver_principal($payroll_approverdata[0], $reference_id);
                echo json_encode($payroll_approverdata[0]);
            } else {
                echo '0';
            }
        }
    }

    public function set_signer_data() {
        $signer_data = $_REQUEST['signer_data'];
        $reference_id = $_REQUEST['reference_id'];
        $this->load->model('Contacts');
        $this->load->model('Payroll');
        if ($signer_data == 0) { //main contact
            $contactdata = $this->Contacts->copy_main_contact_payroll("company", $reference_id);
            if (!empty($contactdata)) {
                $savecontact_toprincipal = $this->Payroll->save_main_contact_principal($contactdata[0], $reference_id);
                echo json_encode($contactdata[0]);
            } else {
                echo '0';
            }
        } elseif ($signer_data == 1) { // payroll approver
            $payroll_approverdata = $this->Payroll->copy_payroll_approver($reference_id);
            if (!empty($payroll_approverdata)) {
                $savepayroll_toprincipal = $this->Payroll->save_paryroll_approver_principal($payroll_approverdata[0], $reference_id);
                echo json_encode($payroll_approverdata[0]);
            } else {
                echo '0';
            }
        } else {
            $company_principaldata = $this->Payroll->copy_company_principal($reference_id);
            if (!empty($company_principaldata)) {
                $savecompany_tosigner = $this->Payroll->save_company_principal_signer($company_principaldata[0], $reference_id);
                echo json_encode($company_principaldata[0]);
            } else {
                echo '0';
            }
        }
    }

    public function copy_owner_data() {
        $ownerid = filter_input(INPUT_POST, 'ownerid', FILTER_SANITIZE_SPECIAL_CHARS);
        $reference_id = filter_input(INPUT_POST, 'reference_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $this->load->model('Company');
        $this->load->model('Payroll');
        $owner_data = $this->Company->get_owner_data($ownerid);
        if (!empty($owner_data)) {
            $saveowner_topayroll = $this->Payroll->save_owner_payroll($owner_data, $reference_id);
            echo json_encode($owner_data);
        } else {
            echo '0';
        }
    }

    public function populate_financial_account_data() {
        $financial_account_id = filter_input(INPUT_POST, 'financial_account_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $this->load->model('Payroll');
        $financial_data = $this->Payroll->get_financial_data($financial_account_id);
        echo json_encode($financial_data[0]);
    }

    public function get_employee_list() {
        $reference_id = post('reference_id');
        $this->load->model('employee');
        $data['employee_list'] = $this->employee->loadEmployeeList($reference_id);
        $this->load->view("services/employee_list", $data);
    }

    public function save_employee() {
        $this->load->model('employee');
        $data = post();
        $err = "";
        if ($data['editval'] == "") {                   
            unset($data['editval']);
//            if ($this->employee->check_add_employee_email($data["email"]) == 0) {
            if ($data["payroll_check"] == "Direct Deposit") {                
                if (empty($_FILES['bank_file']['name'])) {
                    $err = 2;
                } else {
                    $upload_path = FCPATH . 'uploads/';
                    if (!file_exists($upload_path)) {
                        @mkdir($upload_path, 0777);
                    }
                    $file_name = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $_FILES['bank_file']['name']));
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'pdf|jpg|png|doc|jpeg|xls|tiff|csv';
                    $config['file_name'] = $file_name;
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('bank_file')) {
                        $err = 2;
                    } else {
                        $data["bank_file"] = $this->upload->data()['file_name'];
                    }
                }
            }
            if(!isset($data['ssn_name'])) {
                if (empty($_FILES['w4']['name'])) {
                    $err = 2;
                } else {
                    $w4 = $this->uploadPayrollForms($_FILES['w4']);
                    if ($w4) {
                        $data['w4_file'] = $w4;
                    } else {
                        $err = 2;
                    }
                }
                if (!array_key_exists('ssn_name', $data)) {
                    if (empty($_FILES['i9']['name'])) {
                        $err = 2;
                    } else {
                        $i9 = $this->uploadPayrollForms($_FILES['i9']);
                        if ($i9) {
                            $data['i9_file'] = $i9;
                        } else {
                            $err = 2;
                        }
                    }
                }
            }             
            unset($data['action']);
            if ($err == 2) {
                echo 2;
            } else {    
                if(isset($data['ssn_name']) && array_key_exists('ssn_name', $data))
//                isset($data['salary_rate']) && isset($data['ssn_name']) && isset($data['w4']) && isset($data['bank_file']) && isset($data['bank_file']) && isset($data['bank_file'])
                    {   
                        $data['i9'] = $_FILES['i9']['name'];
                        $salary_rate = $data['salary_rate'];
                        $ssn_name = $data['ssn_name'];
                        unset($data['w4']);
                        unset($data['i9']); 
                        unset($data['hourly_rate']); 
                        unset($data['irs_form']); 
                        unset($data['filing_status']); 
//                        echo "Hi";exit;
                    } else {
                        $data['bank_file'] = $_FILES['bank_file']['name'];
                        unset($data['salary_rate']);
                        unset($data['ssn_name']); 
                        $ss = $data['ss'];
                        $email = $data['email'];
                        $emp_type = $data['employee_type'];
                        $bank_file = $data['bank_file'];
//                        echo "Hello";exit;
                    }
                
                    if ($this->employee->add_employee($data)) {
                        echo 1;
                    } else {
                        echo 0;
                    }
            }
//            } else {
//                echo 3;
//            }
        } else {
            $employee_id = $data["editval"];
            $employee_details = $this->employee->get_employee_by_id($employee_id);
//            if ($this->employee->check_update_employee_email($employee_id, $data["email"]) == 0) {
            if ($data["payroll_check"] == "Paper Check") {
                if (!empty($_FILES['bank_file']['name'])) {
                    $upload_path = FCPATH . 'uploads/';
                    if (!file_exists($upload_path)) {
                        @mkdir($upload_path, 0777);
                    }
                    $file_name = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $_FILES['bank_file']['name']));
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'pdf|jpg|png|doc|jpeg|xls|tiff|csv';
                    $config['file_name'] = $file_name;
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('bank_file')) {
                        $err = 2;
                    } else {
                        $data["bank_file"] = $this->upload->data()['file_name'];
                        $data["bank_account_type"] = "";
                        $data["bank_routing"] = "";
                        $data["bank_account"] = "";
                    }
                }
            } else {
                $data["bank_file"] = "";
            }
           if(!isset($data['ssn_name'])) {
                if (empty($_FILES['w4']['name'])) {
                    $err = 2;
                } else {
                    $w4 = $this->uploadPayrollForms($_FILES['w4']);
                    if ($w4) {
                        $data['w4_file'] = $w4;
                    } else {
                        $err = 2;
                    }
                }
                if (!array_key_exists('ssn_name', $data)) {
                    if (empty($_FILES['i9']['name'])) {
                        $err = 2;
                    } else {
                        $i9 = $this->uploadPayrollForms($_FILES['i9']);
                        if ($i9) {
                            $data['i9_file'] = $i9;
                        } else {
                            $err = 2;
                        }
                    }
                }
            } 
            unset($data['action']);
            unset($data['editval']);
            if ($err == 2) {
                echo 2;
            } else {
                if(isset($data['ssn_name']) && array_key_exists('ssn_name', $data))
//                isset($data['salary_rate']) && isset($data['ssn_name']) && isset($data['w4']) && isset($data['bank_file']) && isset($data['bank_file']) && isset($data['bank_file'])
                    {   
                        $data['i9'] = $_FILES['i9']['name'];
                        $salary_rate = $data['salary_rate'];
                        $ssn_name = $data['ssn_name'];
                        unset($data['w4']);
                        unset($data['i9']); 
                        unset($data['hourly_rate']); 
                        unset($data['irs_form']); 
                        unset($data['filing_status']); 
//                        echo "Hi";exit;
                    } else {
                        $data['bank_file'] = $_FILES['bank_file']['name'];
                        unset($data['salary_rate']);
                        unset($data['ssn_name']); 
                        $ss = $data['ss'];
                        $email = $data['email'];
                        $emp_type = $data['employee_type'];
                        $bank_file = $data['bank_file'];
//                        echo "Hello";exit;
                    }
                if ($this->employee->update_employee($employee_id, $data)) {
                    echo 1;
                } else {
                    echo 0;
                }
            }
//            } else {
//                echo 3;
//            }
        }
    }

    private function uploadPayrollForms($file) {
        $upload_dir = FCPATH . 'uploads/';
        $temp = explode('.', $file['name']);
        $extension = strtolower(end($temp));
        $filename = trim(strtolower(reset($temp)));
        $save_as = time() . "_" . $filename . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('pdf');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
//            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['size'] > $max_size) {
//                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
//                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
//                    $this->upload_message = "File uploaded successfully";
//                    $this->file_uploaded = $save_as;
                    return $save_as;
                }
            }
        }
    }

    public function delete_employee() {
        $employee_id = post('employee_id');
        $this->load->model('employee');
        $employee_details = $this->employee->get_employee_by_id($employee_id);
        if (count($employee_details) != 0) {
            if ($this->employee->delete_employee_by_id($employee_id)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function save_payroll_approver() {
        $this->load->model('Payroll');
        $payroll_approver_list = $this->Payroll->save_payroll_approver(post());
        if (!empty($payroll_approver_list)) {
            echo json_encode($payroll_approver_list[0]);
        } else {
            echo 0;
        }
    }

    function request_create_payroll() {
        $this->load->model('payroll_model');
        $order_id = $this->payroll_model->request_create_payroll(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'accounting_services');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function create_sales_tax_application() {
        $this->load->layout = 'dashboard';
        $title = "Create Sales Tax Application";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $render_data['state'] = $this->service_model->get_states();
        $render_data['service_id'] = 12;
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $render_data['completed_orders'] = $this->service->completed_orders();
        $this->load->template('services/create_sales_tax_application', $render_data);
    }

    public function create_bookkeeping() {
        $this->load->layout = 'dashboard';
        $title = "Create Recurring Bookkeeping";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $render_data['service_id'] = 10;
        $render_data['service'] = $this->service_model->get_service_by_id(10);
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_bookkeeping', $render_data);
    }

    public function create_sales_tax_recurring() {
        $this->load->layout = 'dashboard';
        $title = "Create Sales Tax Recurring";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $serviceid = $this->service_model->getServiceId();
        $render_data['service_id'] = $serviceid;
        $render_data['service'] = $this->service_model->get_service_by_id($serviceid);
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $render_data['state'] = $this->service_model->get_states();
        $render_data['completed_orders'] = $this->service->completed_orders();
        $this->load->template('services/create_sales_tax_recurring', $render_data);
    }

    public function create_sales_tax_processing() {
        $this->load->layout = 'dashboard';
        $title = "Create Sales Tax Processing";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $serviceid = $this->service_model->getService();
        $render_data['service_id'] = $serviceid;
        $render_data['service'] = $this->service_model->get_service_by_id($serviceid);
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $render_data['state'] = $this->service_model->get_states();
        $render_data['completed_orders'] = $this->service->completed_orders();
//        echo '<pre>';
//        print_r($render_data);die;
        $this->load->template('services/create_sales_tax_processing', $render_data);
    }

    public function edit_sales_tax_processing($id) {
//        echo $id;
        $this->load->model('FormFields');
        $this->load->model('Contacts');
        $this->load->model('Company');
        $this->load->model('Documents');
        $this->load->model('Service');
        $this->load->model('Staff');
        $this->load->model('payroll');
        $this->load->model('payroll_model');
        $this->load->model('salestax_model');
        $this->load->model('service_model');

        $this->load->layout = 'dashboard';
        $title = "Edit Sales Tax Processing";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;

        $id = base64_decode($id);
        $serviceid = $this->service_model->getService();
        $render_data['service_id'] = $serviceid;
        $render_data['service'] = $this->service_model->get_service_by_id($serviceid);
        $render_data['recurring_data'] = $this->service_model->get_processing_data($id);
//            print_r($render_data['recurring_data']);die;
        $render_data['edit_data'] = $this->Service->get_edit_data($id);

        $state = $render_data['recurring_data']->state;
        $render_data['state_list'] = $this->service_model->get_states();
        $render_data['state'] = $this->service->get_state_name($state);
//        print_r( $render_data['state']);die;
        $county = $render_data['state']->id;

        $render_data['county'] = $this->service->get_county_by_state_name($county);
        $service_id = $render_data['recurring_data']->service_id;
//        $serviceid=$this->service_model->getServiceId();
//        existing data
        $edit_data = $this->salestax_model->get_sales_by_id($id);
        $render_data['company_id'] = $edit_data['reference_id'];
        $render_data['edit_data'] = $edit_data;
        $render_data['staffInfo'] = staff_info();

        $reference_id = $this->salestax_model->get_sales_by_id($id)['reference_id'];
        $render_data['company_data'] = $this->payroll_model->get_company_by_id($reference_id);
        $render_data['other_state'] = $render_data['company_data']['state_others'];
        $render_data['quant_contact'] = $this->Contacts->getQuantContactByReference("company", $edit_data['reference_id']);
        $render_data['quant_account'] = $this->Documents->getQuantAccountsByReference($edit_data['reference_id']);
        $render_data['quant_documents'] = $this->Documents->getQuantDocumentsByReference("company", $edit_data['reference_id']);
        $render_data['quant_title'] = $this->Company->getQuantTitle($edit_data['reference_id']);
        $render_data['completed_orders'] = $this->Service->completed_orders();

        $render_data['notes_data'] = $this->payroll->get_note_by_reference_id($edit_data['reference_id']);

        $render_data['all_driver_license'] = $this->salestax_model->get_salestax_driver_license_data_by_order_id($id);

        $render_data['inter_data'] = $this->Service->get_payroll_internal($edit_data['reference_id']);

        $render_data['get_override_price'] = $this->salestax_model->get_override_price($service_id, $edit_data['id']);

        $render_data["service_id"] = $service_id;
        $render_data["reference_id"] = $reference_id;
        $render_data["reference"] = $this->salestax_model->get_sales_by_id($id)['reference'];

        $render_data['owner_list'] = $this->service_model->get_owner_list($reference_id);

        $this->load->template('services/edit_sales_tax_processing', $render_data);
    }

    public function edit_annual_report($id) {
        $this->load->model('Service');
        $this->load->model('salestax_model');
        $this->load->model('payroll_model');
        $this->load->model('company_model');
        $this->load->model('service_model');

        $id = base64_decode($id);
        $this->load->layout = 'dashboard';
        $title = "Edit Annual Report";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $render_data['florida'] = $this->service_model->get_service_by_shortname('inc_f_a_r');
        $render_data['delaware'] = $this->service_model->get_service_by_shortname('inc_d_a_r');
        $render_data['regestered_agent'] = $this->service_model->get_service_by_shortname('inc_r_a');
        $render_data['edit_data'] = $this->Service->get_edit_data($id);
        $render_data['service_id'] = $render_data['edit_data'][0]['service_id'];
        $reference_id = $this->salestax_model->get_sales_by_id($id)['reference_id'];
        $render_data['reference_id'] = $reference_id;
        $render_data['reference'] = 'company';
        $render_data['company_data'] = $this->payroll_model->get_company_by_id($reference_id);
        $render_data['inter_data'] = $this->Service->get_payroll_internal($render_data['edit_data'][0]['reference_id']);

        $render_data['annual_report'] = $this->service->get_anual_report_data($render_data['edit_data'][0]['id']);

        $this->load->template('services/edit_annual_report', $render_data);
    }

    public function edit_sales_tax_recurring($id) {
        $this->load->model('FormFields');
        $this->load->model('Contacts');
        $this->load->model('Company');
        $this->load->model('Documents');
        $this->load->model('Service');
        $this->load->model('Staff');
        $this->load->model('payroll');
        $this->load->model('payroll_model');
        $this->load->model('salestax_model');
        $this->load->model('service_model');

        $this->load->layout = 'dashboard';
        $title = "Edit Sales Tax Recurring";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;

        $id = base64_decode($id);
        $render_data['recurring_data'] = $this->service_model->get_recurring_data($id);
//            print_r($render_data['recurring_data']);die;
        $render_data['edit_data'] = $this->Service->get_edit_data($id);

        $state = $render_data['recurring_data']->state;
        $render_data['state_list'] = $this->service_model->get_states();
        $render_data['state'] = $this->service->get_state_name($state);
//        print_r( $render_data['state']);die;
        $county = $render_data['state']->id;

        $render_data['county'] = $this->service->get_county_by_state_name($county);
        $service_id = $render_data['recurring_data']->service_id;
//        $serviceid=$this->service_model->getServiceId();
//        existing data
        $edit_data = $this->salestax_model->get_sales_by_id($id);
        $render_data['company_id'] = $edit_data['reference_id'];
        $render_data['edit_data'] = $edit_data;
        // print_r($render_data['recurring_data']);exit;
        $render_data['staffInfo'] = staff_info();

        $reference_id = $this->salestax_model->get_sales_by_id($id)['reference_id'];
        $render_data['company_data'] = $this->payroll_model->get_company_by_id($reference_id);
        $render_data['other_state'] = $render_data['company_data']['state_others'];

        $render_data['quant_contact'] = $this->Contacts->getQuantContactByReference("company", $edit_data['reference_id']);
        $render_data['quant_account'] = $this->Documents->getQuantAccountsByReference($edit_data['reference_id']);
        $render_data['quant_documents'] = $this->Documents->getQuantDocumentsByReference("company", $edit_data['reference_id']);
        $render_data['quant_title'] = $this->Company->getQuantTitle($edit_data['reference_id']);
        $render_data['completed_orders'] = $this->Service->completed_orders();

        $render_data['notes_data'] = $this->payroll->get_note_by_reference_id($edit_data['reference_id']);

        $render_data['all_driver_license'] = $this->salestax_model->get_salestax_driver_license_data_by_order_id($id);

        $render_data['inter_data'] = $this->Service->get_payroll_internal($edit_data['reference_id']);

        $render_data['get_override_price'] = $this->salestax_model->get_override_price($service_id, $edit_data['id']);

        $render_data["service_id"] = $service_id;
        $render_data["reference_id"] = $reference_id;
        $render_data["reference"] = $this->salestax_model->get_sales_by_id($id)['reference'];
//        echo $id;die;
//        $render_data['sales_tax_data'] = $this->salestax_model->get_salestax_recurring($id);

        $render_data['owner_list'] = $this->service_model->get_owner_list($reference_id);
//        echo "<pre>";
//        print_r($render_data['sales_tax_data']);
//        echo "</pre>";die;

        $this->load->template('services/edit_sales_tax_recurring', $render_data);
    }

    public function county_list() {
        $county_list = $this->service_model->get_county_list_by_state_id(post('state_id'));
        echo '<option value="">Select an option</option>';
        foreach ($county_list as $cl) {
            echo '<option value="' . $cl['id'] . '" ' . (post('county_id') == $cl['id'] ? 'selected="selected"' : '') . '>' . $cl['name'] . '</option>';
        }
    }

    public function create_rt6_unemployment_app() {
        $this->load->layout = 'dashboard';
        $title = "Create Rt6 Unemployment App";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $render_data['service_info'] = $this->service_model->get_service_by_shortname('acc_r_a_-_u');
        $render_data['service_id'] = $render_data['service_info']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $render_data['completed_orders'] = $this->service->completed_orders();
        $this->load->template('services/create_rt6_unemployment_app', $render_data);
    }

    public function request_create_sales_tax_processing() {
        $this->load->model('salestax_model');
        $order_id = $this->salestax_model->request_create_sales_tax_processing(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'accounting_services');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function related_create_sales_tax_processing() {
        $this->load->model('salestax_model');
        if ($this->salestax_model->related_create_sales_tax_processing(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function request_create_sales_tax_application() {
        $this->load->model('salestax_model');
        $order_id = $this->salestax_model->request_create_sales_tax_application(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'accounting_services');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function related_create_sales_tax_application() {
        $this->load->model('salestax_model');
        if ($this->salestax_model->related_create_sales_tax_application(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function request_create_sales_tax_recurring() {
        $this->load->model('salestax_model');
        $order_id = $this->salestax_model->request_create_sales_tax_recurring(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'accounting_services');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function related_create_sales_tax_recurring() {
        $this->load->model('salestax_model');
        if ($this->salestax_model->related_create_sales_tax_recurring(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function request_create_rt6_unemployment_app() {
        $this->load->model('rt6_model');
        $order_id = $this->rt6_model->request_create_rt6_unemployment_app(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'accounting_services');
            echo $order_id;
        } else {
            echo 0;
        }
    }

    public function related_create_rt6_unemployment_app() {
        $this->load->model('rt6_model');
        if ($this->rt6_model->related_create_rt6_unemployment_app(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function edit_sales_tax_application($id) {
        $this->load->model('FormFields');
        $this->load->model('Contacts');
        $this->load->model('Company');
        $this->load->model('Documents');
        $this->load->model('Service');
        $this->load->model('Staff');
        $this->load->model('payroll');
        $this->load->model('payroll_model');
        $this->load->model('service_model');
        $this->load->model('salestax_model');

        $this->load->layout = 'dashboard';
        $title = "Edit Sales Tax Application";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;

        $id = base64_decode($id);
        $edit_data = $this->salestax_model->get_sales_by_id($id);
        $render_data['company_id'] = $edit_data['reference_id'];
        $render_data['edit_data'] = $edit_data;
        $render_data['staffInfo'] = staff_info();

        $reference_id = $this->salestax_model->get_sales_by_id($id)['reference_id'];

        $render_data['company_data'] = $this->payroll_model->get_company_by_id($reference_id);
        $render_data['other_state'] = $render_data['company_data']['state_others'];
        $render_data['quant_contact'] = $this->Contacts->getQuantContactByReference("company", $edit_data['reference_id']);
        $render_data['quant_account'] = $this->Documents->getQuantAccountsByReference($edit_data['reference_id']);
        $render_data['quant_documents'] = $this->Documents->getQuantDocumentsByReference("company", $edit_data['reference_id']);
        $render_data['quant_title'] = $this->Company->getQuantTitle($edit_data['reference_id']);
        $render_data['completed_orders'] = $this->Service->completed_orders();

        $render_data['notes_data'] = $this->payroll->get_note_by_reference_id($edit_data['reference_id']);

        $render_data['all_driver_license'] = $this->salestax_model->get_salestax_driver_license_data_by_order_id($id);

        $render_data['inter_data'] = $this->Service->get_payroll_internal($edit_data['reference_id']);

        $render_data['get_override_price'] = $this->salestax_model->get_override_price(42, $edit_data['id']);

        $render_data["service_id"] = 12;
        $render_data["reference_id"] = $reference_id;
        $render_data["reference"] = $this->salestax_model->get_sales_by_id($id)['reference'];

        $render_data['sales_tax_data'] = $this->salestax_model->get_salestax_data($id)[0];


        $render_data['owner_list'] = $this->service_model->get_owner_list($reference_id);

        $state = $render_data['sales_tax_data']['state_recurring'];
        $render_data['state_list'] = $this->service_model->get_states();
        $render_data['state'] = $this->service->get_state_name($state);
//        print_r( $render_data['state']);die;
        $county = $render_data['state']->id;

        $render_data['county'] = $this->service->get_county_by_state_name($county);

        $this->load->template('services/edit_sales_tax_application', $render_data);
    }

    public function edit_rt6_unemployment_app($id) {
        $this->load->model('FormFields');
        $this->load->model('Contacts');
        $this->load->model('Company');
        $this->load->model('Documents');
        $this->load->model('Service');
        $this->load->model('Staff');
        $this->load->model('payroll');
        $this->load->model('payroll_model');
        $this->load->model('service_model');
        $this->load->model('rt6_model');

        $this->load->layout = 'dashboard';
        $title = "Edit Rt6 Unemployment App";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;

        $id = base64_decode($id);
        $edit_data = $this->rt6_model->get_sales_by_id($id);
        $render_data['company_id'] = $edit_data['reference_id'];
        $render_data['edit_data'] = $edit_data;
        $render_data['staffInfo'] = staff_info();

        $reference_id = $this->rt6_model->get_sales_by_id($id)['reference_id'];

        $render_data['company_data'] = $this->payroll_model->get_company_by_id($reference_id);
        $render_data['other_state'] = $render_data['company_data']['state_others'];
        $render_data['quant_contact'] = $this->Contacts->getQuantContactByReference("company", $edit_data['reference_id']);
        $render_data['quant_account'] = $this->Documents->getQuantAccountsByReference($edit_data['reference_id']);
        $render_data['quant_documents'] = $this->Documents->getQuantDocumentsByReference("company", $edit_data['reference_id']);
        $render_data['quant_title'] = $this->Company->getQuantTitle($edit_data['reference_id']);
        $render_data['completed_orders'] = $this->Service->completed_orders();

        $render_data['notes_data'] = $this->payroll->get_note_by_reference_id($edit_data['reference_id']);

        $render_data['all_driver_license'] = $this->rt6_model->get_salestax_driver_license_data_by_order_id($id);

        $render_data['inter_data'] = $this->Service->get_payroll_internal($edit_data['reference_id']);

        $render_data['get_override_price'] = $this->rt6_model->get_override_price(42, $edit_data['id']);

        $render_data["service_id"] = 14;
        $render_data["reference_id"] = $reference_id;
        $render_data["reference"] = $this->rt6_model->get_sales_by_id($id)['reference'];

        $render_data['sales_tax_data'] = $this->rt6_model->get_rt6_data($id)[0];


        $render_data['owner_list'] = $this->service_model->get_owner_list($reference_id);


        $this->load->template('services/edit_rt6_unemployment_app', $render_data);
    }

    public function create_1099_write_up() {
        $this->load->layout = 'dashboard';
        $title = "Create 1099 Write Up";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'accounting_services';
        $render_data['header_title'] = $title;
        $render_data['service_info'] = $this->service_model->get_service_by_shortname('acc_1_w_u');
        $render_data['service_id'] = $render_data['service_info']['id'];
        $render_data['reference_id'] = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $this->load->template('services/create_1099_write_up', $render_data);
    }

    public function copy_contact_for_1099_write_up() {
        $reference_id = request('ref_id');
        $this->load->model('Contacts');
        $contactdata = $this->Contacts->copy_contact_for_1099_write_up("company", $reference_id);
        if (!empty($contactdata)) {
            echo json_encode($contactdata[0]);
        } else {
            echo '0';
        }
    }

    function request_create_1099_write_up() {
        // print_r(post());exit;
        $order_id = $this->company_model->request_create_1099_write_up(post());
        if ($order_id) {
            mod_services_count($status_from = '', $status_to = 2, $section_name = 'incorporation');
            echo $order_id;
        } else {
            echo 0;
        }
    }

}
