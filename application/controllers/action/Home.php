<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $filter_element;
    private $sales_tax_filter_element;

    function __construct() {
        parent::__construct();
        $this->load->model("action_model");
        $this->load->model("administration");
        $this->load->model('service_model');
        $this->load->model('system');
        $this->load->model('company');
        $this->load->model('notes');
        $this->load->model('lead_management');
        $this->load->model('individual');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->filter_element = [
            1 => "Priority",
            2 => "Tracking",
            3 => "To Office",
            4 => "To Department",
            5 => "Start Date",
            6 => "Complete Date",
            7 => "ACTION ID",
            8 => "Created By",
            9 => "Assigned To",
            10 => "Client ID",
            11 => "Creation Date",
            12 => "Due Date",
            13 => "Request Type",
            14 => "By Department",
            15 => "By Office"
        ];

        $this->sales_tax_filter_element = [
            1 => "Client",
            2 => "State",
            3 => "County",
            4 => "Added By",
            5 => "Start Date",
            6 => "Complete Date",
            7 => "Period",
            8 => "Tracking"
        ];
    }

    public function index($status = '', $priority = '', $request_type = '', $office_id = '', $department_id = '') {
        $this->load->layout = 'dashboard';
        $title = "Action Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'action';
        $render_data['menu'] = 'action_dashboard';
        $render_data['header_title'] = $title;
        if ($priority == 0) {
            $priority = '';
        }
        if ($office_id == 0) {
            $office_id = '';
        }
        if ($department_id == 0) {
            $department_id = '';
        }
//        if ($status == 'all') {
            // $status = '';
//        }
         $render_data['fileter_request_type']='';
         $render_data['filter_val']='';
        if($status != ''){
            if($status=='0'){
                $render_data['status'] = $status;
                $render_data['filter_val']=$status.'-New';
//                $render_data['fileter_request_type']='byme_tome_mytask-By ME,To Me,My Task';
            }else{
                $render_data['status'] = $status;
                $render_data['filter_val']=$status.'-Started';
//                $render_data['fileter_request_type']='byme_tome_mytask-By ME,To Me,My Task';
            }
        }else{
        $render_data['status'] = $status;    
        }
        $render_data['stat'] = $status;
        // $render_data['status'] = $status;
        $render_data['office_id'] = $office_id;
        $render_data['department_id'] = $department_id;
        $render_data['request_type'] = $request_type;
        $render_data['priority'] = $priority;
//        $render_data['staff_list'] = $this->administration->get_all_staff_ajax();
//        $render_data['department_list'] = $this->administration->get_all_departments();
//        echo $render_data['status'];die;
        $render_data['filter_element_list'] = $this->filter_element;
        $this->load->template('action/dashboard', $render_data);
    }

    public function load_dropdown() {
        $dd1_val = post("dd1_val");
        $dd2_val = post("dd2_val");

        if ($dd1_val == 'sent_to' && $dd2_val == 'office') {
            $render_data["data"] = $this->action_model->get_sentto_office_for_dashboard_dd();
        } elseif ($dd1_val == 'sent_from' && $dd2_val == 'office') {
            $render_data["data"] = $this->action_model->get_sentfrom_office_for_dashboard_dd();
        } elseif ($dd1_val == 'sent_from' && $dd2_val == 'staff') {
            $render_data["data"] = $this->action_model->get_sentfrom_staff_for_dashboard_dd();
        } elseif ($dd1_val == 'sent_to' && $dd2_val == 'staff') {
            $render_data["data"] = $this->action_model->get_sentto_staff_for_dashboard_dd();
        } elseif ($dd1_val == 'sent_to' && $dd2_val == 'department') {
            $render_data["data"] = $this->action_model->get_sentto_department_for_dashboard_dd();
        }
        if (!empty($render_data["data"])) {
            $this->load->view("action/load_dropdown", $render_data);
        }
    }

    public function create_action() {
        $this->load->layout = 'dashboard';
        $title = "Create Action";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'action';
        $render_data['menu'] = 'create_action';
        $render_data['header_title'] = $title;
        $render_data["departments"] = $this->action_model->get_departments();
        $this->load->template('action/new_action', $render_data);
    }

    public function get_staff_by_department() {
        $department_id = $this->input->post("department");
        $staff = $this->action_model->get_staff_by_department($department_id);
        echo json_encode($staff);
    }

    public function request_create_action() {
        echo $this->action_model->add_new_action($this->input->post(), $_FILES["upload_file"]);
        mod_actions_count('', 0);
    }

    public function update_action_status() {
        $prev_status = $this->action_model->get_current_status('actions', $this->input->post("id"));
        $status = $this->input->post("status");
        $action_id = $this->input->post("id");
        $comment = $this->input->post("comment");
        $allstaffs = explode(",",post('allstaffs'));
        if($status==1){
            $check = $this->action_model->check_if_current_user_is_from_assigned_dept($action_id);
            if($check==1){
                $this->action_model->assign_action_by_action_id($action_id, sess('user_id'), $allstaffs);
            }            
        }
        // if($status==2 || $status==7){
        //     $get_created_by_staff = $this->action_model->get_created_by_staff($action_id);
        //     $this->action_model->assign_action_by_action_id($action_id, $get_created_by_staff);
        // }
        echo $this->action_model->update_action_status($action_id, $status, $comment, $allstaffs);

        mod_actions_count($prev_status, $this->input->post("status"));
    }

    public function load_data() {
        $type = post("type");
        $status = post("status");
        $dd1_val = post("dd1_val");
        $dd2_val = post("dd2_val");
        $dd_ofc = post("dd_ofc");
        $dd_staff = post("dd_staff");
        $priority_val = post("priority_val");
        $dd_department = post("dd_department");
        $render_data["data"] = $this->action_model->load_all_data($type, $status, $dd1_val, $dd2_val, $priority_val, $dd_ofc, $dd_staff, $dd_department);
        $this->load->view("action/load_data", $render_data);
    }

    public function load_data_bullets() {
        $type = post("type");
        $status = post("status");
        $dd1_val = post("dd1_val");
        $dd2_val = post("dd2_val");
        $dd_ofc = post("dd_ofc");
        $dd_staff = post("dd_staff");
        $priority_val = post("priority_val");
        $dd_department = post("dd_department");
        $render_data["data"] = $this->action_model->load_all_data($type, $status, $dd1_val, $dd2_val, $priority_val, $dd_ofc, $dd_staff, $dd_department);
        $this->load->view("action/load_data", $render_data);
    }

    public function load_count_data() {
        echo json_encode($this->action_model->load_count_data());
    }

    public function updateNotes() {
        if (!empty(post('notes'))) {
            $this->load->model('Notes');
            $this->Notes->updateNotes(post(), post('notestable'));
            //redirect(base_url() . 'action/home');
        }
    }

    public function get_action_office_ajax() {
        $department_id = post("department_id");
        $result["select_office"] = post("select_office");
        $result['disabled'] = post('disabled');
        $result["department_id"] = $department_id;
        $result["office_list"] = $this->action_model->get_office_by_department_id($department_id);
        $this->load->view("action/action_office_ajax", $result);
    }

    public function get_action_staff_ajax() {
        $department_id = post("department_id");
        $office_id = post("office_id");
        $result["ismyself"] = post("ismyself");
        $result["select_staffs"] = post("select_staffs");
        $result['disabled'] = post('disabled');
        $result["staff_list"] = $this->action_model->get_staff_by_department_id_office_id($department_id, $office_id);
        $this->load->view("action/action_staff_ajax", $result);
    }

    public function edit_action($id) {
        $render_data["action_id"] = $id;
        $render_data["data"] = $this->action_model->fetch_data($id);
        $render_data["data"]["staffs"] = explode(",", $render_data["data"]["staffs"]);
        $render_data["departments"] = $this->action_model->get_departments();
        $render_data["type_of_contact"] = $this->action_model->get_staff_by_department($render_data["data"]["department"]);
        $render_data["data"]["notes"] = explode(",", $render_data["data"]["notes"]);
        $render_data["data"]["files"] = $this->action_model->get_files_by_action_id($id);
        $this->load->layout = 'dashboard';
        $title = "Edit Action";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'action';
        $render_data['menu'] = 'action_dashboard';
        $render_data['header_title'] = $title;
        $this->load->template("action/edit_action", $render_data);
    }

    public function view_action($id = '') {
        if ($id != '') {
            $render_data["data"] = $this->action_model->fetch_data($id);
            if (empty($render_data["data"])) {
                redirect(base_url() . 'action/home');
            }
            $render_data["action_id"] = $id;
            $render_data["data"]["staffs"] = explode(",", $render_data["data"]["staffs"]);
            // $render_data["departments"] = $this->action_model->get_departments();
            $render_data["departments"] = $this->action_model->get_departments_for_action();
            $render_data["type_of_contact"] = $this->action_model->get_staff_by_department($render_data["data"]["department"]);
            $render_data["data"]["notes"] = explode(",", $render_data["data"]["notes"]);
            $render_data["data"]["files"] = $this->action_model->get_files_by_action_id($id);
            $this->load->layout = 'dashboard';
            $title = "Action Dashboard / View Action";
            $render_data['title'] = $title . ' | Tax Leaf';
            $render_data['main_menu'] = 'actions';
            $render_data['menu'] = 'action_dashboard';
            $render_data['header_title'] = $title;
            $this->load->template("action/view_action", $render_data);
        } else {
            redirect(base_url() . 'action/home');
        }
    }

    public function request_edit_action($action_id) {
        echo $this->action_model->edit_action($action_id, $this->input->post(), $_FILES["upload_file"]);
    }

    public function delete_action_file() {
        $file_id = post('file_id');
        $file = $this->action_model->get_file_by_id($file_id);
        if ($this->action_model->delete_file_by_id($file_id)) {
            $file_path = FCPATH . 'uploads/' . $file['file_name'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            echo 1;
        } else {
            echo 0;
        }
    }

    public function delete_sales_tax_process_file() {
        $file_id = post('file_id');
        $file = $this->action_model->get_sales_file_by_id($file_id);
        if ($this->action_model->delete_sales_file_by_id($file_id)) {
            $file_path = FCPATH . 'uploads/' . $file['file_name'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            echo 1;
        } else {
            echo 0;
        }
    }

    public function add_individual() {
        $this->load->layout = 'dashboard';
        $title = "Add Individual";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'add_individual';
        $render_data['header_title'] = $title;
        $reference_id = $this->system->create_reference_id();
        $render_data['reference'] = 'company';
        $title_id = $this->company->createTitleReferenceId($reference_id);
        if ($title_id) {
            $title_array = $this->company->getTitle($title_id);
            $individual_id = $title_array->individual_id;
        } else {
            $title_array = false;
            $title_id = 0;
            $individual_id = 0;
        }
        $render_data['title_val'] = $title_array;
        $render_data['reference'] = 'individual';
        $render_data['reference_id'] = $reference_id;
        $render_data['company_type'] = 0;
        $render_data['staffInfo'] = staff_info();
        $render_data['individual_id'] = $individual_id;
        $render_data['title_id'] = $title_id;
        $this->load->template('action/add_individual', $render_data);
    }

    public function save_individualData() {
        $data = post();
        if (array_key_exists('lead_id', $data) && !empty($data['lead_id'])) {
            $this->lead_management->update_lead_assigned_status($data['lead_id']);
            $lead_notes = $data['lead_notes'];
            if (!empty($lead_notes)) {
                $this->notes->insert_note(3, $lead_notes, "lead_id", $data['lead_id']);
            }
            unset($data['lead_id']);
            unset($data['lead_notes']);
        }
        if($data['editval']=='add'){
            $check_if_duplicate_exists = $this->individual->check_if_duplicate_exists($data);
        }else{
            $check_if_duplicate_exists = array();
        }
        
        if(empty($check_if_duplicate_exists)){
            if ($this->individual->saveIndividual($data)) {
                if($data['editval']=='add'){
                    $data['subject'] = 'New Client Has Been Added';
                    $data['client'] = 'individual';
                    $data['message'] = staff_info()['full_name'].' has added a new client';
                    $this->action_model->insert_client_action($data);
                }
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 3;
        }
    }

    public function add_business() {
        $this->load->layout = 'dashboard';
        $title = "Add Business";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'add_business';
        $render_data['header_title'] = $title;
        $render_data['reference'] = 'company';
        $this->load->model('system');
        $render_data['service_id'] = 0;
        $render_data['reference_id'] = $this->system->create_reference_id();
        $this->load->template('action/add_business', $render_data);
    }

    public function request_create_business() {
        $data = post();
        // echo "<pre>";
        // print_r($data);exit;
        if ($this->action_model->request_create_business($data)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function individual_dashboard() {
        $this->load->model('system');
        $this->load->layout = 'dashboard';
        $title = "Individual Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'individual_dashboard';
        $render_data['header_title'] = $title;
//        $render_data['staff_office'] = $this->action_model->get_office_staffwise();
        $staff_info = staff_info();
        if ($staff_info['type'] == 3) {     // this section are closed for client requirment || ($staff_info['type'] == 2 && $staff_info['department']!=14)
            $render_data['staff_office'] = $this->administration->get_office_by_staff_id($staff_info['id']);
        } else {
            $render_data['staff_office'] = $this->administration->get_all_office();
        }
        $render_data['staff_list'] = $this->system->get_staff_list();
        $render_data['reffered_by_source'] = $this->system->get_reffered_by_source();
        $this->load->template('action/individual_dashboard', $render_data);
    }

    public function import_clients() {
        $this->load->model('system');
        $this->load->layout = 'dashboard';
        $title = "Import Clients";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'import_clients';
        $render_data['header_title'] = $title;
        $this->load->template('action/import_clients', $render_data);
    }

    public function insert_import_clients() {
        $this->load->model('system');
        if (!empty($_FILES['excel_file']["name"])) {
            $_FILES['excel_file']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $_FILES['excel_file']['name']));

            $uploadPath = FCPATH . 'uploads/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = "*";

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('excel_file')) {
                $fileData = $this->upload->data();
                $file_name = $fileData['file_name'];

                 $fullpath = FCPATH . 'uploads/' . $file_name;

                $this->load->library('csvreader');
                $result = $this->csvreader->parse_file($fullpath); //path to csv file
                // echo '<pre>';
                // print_r($result); exit;

                if (!empty($result)) {
                    foreach ($result as $data) {
                            if ((isset($data['type_of_company']) && $data['type_of_company'] != '') && (isset($data['company_name']) && $data['company_name'] != '') && (isset($data['office_name']) && $data['office_name'] != '') && (isset($data['partner_name']) && $data['partner_name'] != '') && (isset($data['manager_name']) && $data['manager_name'] != '')) {
                                $check_if_company_exists = $this->action_model->check_if_company_exists($data['company_name']);
                                //$check_if_company_exists = $this->action_model->check_if_company_exists_by_practice_id($data['practice_id']);
                                if (empty($check_if_company_exists)) {
                                    $this->action_model->import_clients($data);
                                }else{
                                    $this->action_model->update_import_clients($data,$check_if_company_exists['id']); 
                                }
                            } else {
                                $this->action_model->import_failed_data($data, 'mandatory data missing', '1');
                            }
                        }
                        echo '1';
                    }
                else {
                    echo '0';
                }

            }else{
                echo '0';
            }
        }else{
            echo '0';
        }

    }

    public function insert_import_individuals() {
        $this->load->model('system');
        if (!empty($_FILES['excel_file']["name"])) {
            $_FILES['excel_file']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $_FILES['excel_file']['name']));

            $uploadPath = FCPATH . 'uploads/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = "*";

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('excel_file')) {
                $fileData = $this->upload->data();
                $file_name = $fileData['file_name'];

                $fullpath = FCPATH . 'uploads/' . $file_name;

                $this->load->library('csvreader');
                $result = $this->csvreader->parse_file($fullpath); //path to csv file
                // echo '<pre>';
                // print_r($result); exit;
                if (!empty($result)) {
                    foreach ($result as $data) {
                        if ((isset($data['owner_first_name']) && $data['owner_first_name'] != '') && (isset($data['owner_last_name']) && $data['owner_last_name'] != '') && (isset($data['office_name']) && $data['office_name'] != '') && (isset($data['partner_name']) && $data['partner_name'] != '') && (isset($data['manager_name']) && $data['manager_name'] != '')) {
                            $check_if_individual_exists = $this->action_model->check_if_owner_exists($data['owner_first_name'],$data['owner_last_name']);
                                if (empty($check_if_individual_exists)) {
                                    // $check_if_contact_with_same_ph_email_exists = $this->service_model->check_if_contact_with_same_ph_email_exists($data['contact_first_name'],$data['contact_last_name'],$data['contact_phone'],$data['contact_email']);
                                    // if(empty($check_if_contact_with_same_ph_email_exists)){
                                        $this->action_model->import_individual($data);
                                    // }else{
                                    //     $this->action_model->import_failed_data($data, 'contact email/phone exists', '2');
                                    // }                                    
                                }else{ 
                                    $this->action_model->update_import_individual($data,$check_if_individual_exists['id']);
                                }
                        } else {
                            $this->action_model->import_failed_data($data, 'mandatory data missing', '2');
                        }
                    }
                    echo '1';
                } else {
                    echo '0';
                }
            }else{
                echo '0';
            }
        }else{
            echo '0';
        }
        
    }

    public function business_dashboard() {
        $this->load->model('system');
        $this->load->layout = 'dashboard';
        $title = "Business Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'business_dashboard';
        $render_data['header_title'] = $title;

        $staff_info = staff_info();
        if ($staff_info['type'] == 3) {  //this section are closed for client requirement ($staff_info['type'] == 2 && $staff_info['department']!=14)
            $render_data['staff_office'] = $this->administration->get_office_by_staff_id($staff_info['id']);
        } else {
            $render_data['staff_office'] = $this->administration->get_all_office();
        }
        $render_data['staff_list'] = $this->system->get_staff_list();
        $render_data['reffered_by_source'] = $this->system->get_reffered_by_source();
        $render_data['company_type'] = $this->system->get_company_type();
//        get_office_by_staff_id
//        print_r($render_data['staff_office']);
        $this->load->template('action/business_dashboard', $render_data);
    }

    public function load_data_individual() {
        $result = $this->action_model->load_individual_data();
        echo json_encode($result);
        //$this->load->view("action/load_individual_data", $render_data);
    }

    public function load_data_business() {
        $result = $this->action_model->load_business_data();
        echo json_encode($result);
        //$this->load->view("action/load_business_data", $render_data);
    }

    public function view_individual($id) {
        
        $this->load->model('Pdf');
        $this->load->model('Contacts');
        $this->load->model('Administration');
        $this->load->layout = 'dashboard';
        $title = "View Individual";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'individual_dashboard';
        $render_data['header_title'] = $title;
        $render_data['get_individual_data'] = $this->action_model->get_individual_data($id);
        if(empty($render_data['get_individual_data'])){
            $render_data['get_individual_data'] = $this->action_model->get_individual_data_old($id);
        }
        $render_data['reference_id'] = $render_data['get_individual_data']['reference_id'];
        $render_data['contact_info'] = $this->Contacts->loadContactListpdf("individual", $id);
        $render_data['language_list'] = $this->action_model->get_lanuage_list($render_data['get_individual_data']['language']);
        $render_data['country_residence'] = $this->action_model->get_country_list($render_data['get_individual_data']['country_residence']);
        $render_data['country_citizenship'] = $this->action_model->get_country_list($render_data['get_individual_data']['country_citizenship']);
        $render_data['office'] = $this->administration->get_office_by_id($render_data['get_individual_data']['office']);
        $render_data['partner_name'] = $this->Pdf->getOfficeStaff($render_data['get_individual_data']['partner']);
        $render_data['manager_name'] = $this->Pdf->getOfficeStaff($render_data['get_individual_data']['manager']);
        $render_data['ref_by_src'] = $this->Pdf->getReferredBySource($render_data['get_individual_data']['referred_by_source']);
        $render_data['notes'] = $this->action_model->get_individual_notes($render_data['get_individual_data']['id']);
        $render_data['attachment'] = $this->action_model->get_individual_attachments($render_data['get_individual_data']['id']);
        $render_data['business_info'] = $this->action_model->get_business_info($id);
        $this->load->template('action/view_individual', $render_data);
    }

    public function edit_individual($id) {
        $this->load->layout = 'dashboard';
        $title = "Edit Individual";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'individual_dashboard';
        $render_data['header_title'] = $title;
        $get_individual_data = $this->action_model->get_individual_data($id);

        if(empty($get_individual_data)){
            $get_individual_data = $this->action_model->get_individual_data_old($id);
        }
        //print_r($get_individual_data); exit;
        $render_data['staffInfo'] = staff_info();
        $render_data['individual_id'] = $id;
        $render_data['reference'] = 'individual';
        $render_data['reference_id'] = $get_individual_data['company_id'];
        $render_data['company_type'] = 0;
        $render_data['title_id'] = $get_individual_data['title_id'];
        $render_data['documents'] = $this->action_model->get_individual_attachment($render_data['reference_id']);        
        $render_data['result'] = $get_individual_data;
        $this->load->template('action/edit_individual', $render_data);
    }

    public function view_business($reference_id, $company_id) {

        $this->load->model('Contacts');
        $this->load->model('Administration');
        $this->load->model('Pdf');
        $this->load->model("company_model");
        $this->load->model("System");
        $this->load->model("action_model");
        $this->load->model("individual");
        $this->load->model("Contacts");
        $this->load->layout = 'dashboard';
        $title = "View Business";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'business_dashboard';
        $render_data['header_title'] = $title;
        $render_data['company_data'] = $this->company_model->get_company_data($reference_id);
        $render_data['reference_id'] = $render_data['company_data'][0]['id'];
        $render_data['state_data'] = $this->system->get_state_by_id($render_data['company_data'][0]['state_opened']);
        $render_data['company_name_option_data'] = $this->company_model->get_company_details($render_data['company_data'][0]['id']);
        $render_data['company_type'] = $this->company_model->get_company_type($render_data['company_name_option_data']['type']);
        $render_data['company_internal_data'] = $this->company_model->get_company_internal_data($reference_id);
        $render_data['office'] = $this->administration->get_office_by_id($render_data['company_internal_data'][0]['office']);
        $render_data['partner_name'] = $this->Pdf->getOfficeStaff($render_data['company_internal_data'][0]['partner']);
        $render_data['manager_name'] = $this->Pdf->getOfficeStaff($render_data['company_internal_data'][0]['manager']);
        $render_data['ref_by_src'] = $this->Pdf->getReferredBySource($render_data['company_internal_data'][0]['referred_by_source']);
        $render_data['language_list'] = $this->action_model->get_lanuage_list($render_data['company_internal_data'][0]['language']);
        $render_data['company_order_data'] = $this->company_model->get_company_order_data($reference_id);
        $render_data['contact_info'] = $this->Contacts->loadContactListpdf("company", $reference_id);
        $render_data['get_individual_data'] = $this->individual->get_individual_info_by_refernce_id($reference_id);
        $render_data['owner_contact'] = [];
        if (!empty($render_data['get_individual_data'])) {
            foreach ($render_data['get_individual_data'] as $indv) {
                $render_data['owner_contact'][] = $this->Contacts->loadOwnerContactList("individual", $indv['individual_id']);
            }
        }
        $render_data['notes'] = $this->individual->get_business_notes($render_data['company_data'][0]['id']);
        $payroll_account_details = $this->company_model->get_account_details($render_data['company_data'][0]['id']);
        $orderid=$this->company_model->getOrderID($render_data['company_data'][0]['id']);
        $financial_account_details=$this->company_model->getFinancialAccountDetails($orderid);
        $render_data['account_details']=array_merge($payroll_account_details,$financial_account_details);
        $this->load->template('action/view_business', $render_data);
    }

    public function edit_business($reference_id, $company_id) {
        $this->load->model("company_model");
        $this->load->layout = 'dashboard';
        $title = "Edit Business";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'business_dashboard';
        $render_data['header_title'] = $title;
        $render_data['reference'] = 'company';
        $render_data['reference_id'] = $reference_id;
        $render_data['company_data'] = $this->company_model->get_company_data($reference_id);
        $render_data['company_name_option_data'] = $this->company_model->get_company_name_option_data($reference_id);
        $render_data['company_order_data'] = $this->company_model->get_company_order_data($reference_id);
        $render_data['company_internal_data'] = $this->company_model->get_company_internal_data($reference_id);
        $render_data['account_details'] = $this->company_model->get_account_details($render_data['company_data'][0]['id']);
        $render_data['account_details_bookkeeping'] = $this->company_model->get_account_details_bookkeeping($render_data['company_data'][0]['id']);
//        $render_data['documents']= $this->company_model->get_business_attachment($reference_id);
        $this->load->template('action/edit_business', $render_data);
    }

    function sales_tax_process() {
        $this->load->layout = 'dashboard';
        $title = "Sales Tax Processing";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'action';
        $render_data['menu'] = 'sales_tax_process';
        $render_data['header_title'] = $title;
        $render_data['staff_office'] = $this->action_model->get_staff_name();
        $this->load->model('service');
        $render_data['filter_element_list'] = $this->sales_tax_filter_element;
        $render_data['client'] = $this->service->completed_orders_salestax(47);
        $this->load->template('action/sales_tax_process_dashboard', $render_data);
    }

    function ajax_client_type() {
        $client = post('client_id');
        $value['sales_tax_process'] = $this->action_model->ajax_client_type($client);
        $this->load->view('action/load_sales_tax_data', $value);
    }

    function ajax_added_by() {
        $added_by = post('added_by_id');
        $value['sales_tax_process'] = $this->action_model->ajax_added_by($added_by);
        $this->load->view('action/load_sales_tax_data', $value);
    }

    function load_sale_tax_data() {
        $client_type = post('clienttype');
        $added_by = post('added_by');
        $req_by = post('req_by');
        $status = post('status');
        $data['sales_tax_process'] = $this->action_model->get_sales_tax_process($client_type, $added_by, $req_by, $status);
        $this->load->view("action/load_sales_tax_data", $data);
    }

    function load_sale_tax_data_count() {
        $req_by = post('req_by');
        $status = post('status');
        $countval = $this->action_model->get_sales_tax_process_count($req_by, $status);
        echo $countval;
    }

    function add_sales_tax() {
        $this->load->layout = 'dashboard';
        $title = "Add Sales Tax Processing";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'action';
        $render_data['menu'] = 'sales_tax_process';
        $render_data['header_title'] = $title;
//        $render_data['reference'] = 'company';
        $this->load->model('service');
        $render_data['state'] = $this->system->get_all_state();
        $render_data['staffInfo'] = staff_info();
        $render_data['completed_salestax_orders'] = $this->service->completed_orders_salestax(47); //id will be different for live
        $render_data['county_details'] = $this->action_model->get_county_name();
        $this->load->template('action/add_sales_tax', $render_data);
    }

    function get_county_rate() {
        $county_id = post('county_id');
        $data['county_rate'] = $this->action_model->get_county_rate($county_id);
        $this->load->view('action/county_rate_ajax', $data);
    }

    function get_county() {
        $state = post('state_id');
        $data['selected_county'] = post('select_county');
        $data['county'] = $this->action_model->getCounty($state);
        $this->load->view('action/ajax_county', $data);
    }

    function save_sales_tax_process() {
        $this->load->model('sales_tax_process');
        if ($this->sales_tax_process->saveSalesTaxProcess(post(), $_FILES["upload_file"])) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function edit_sales_tax_process($id) {
        $this->load->layout = 'dashboard';
        $title = "Edit Sales Tax Processing";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'action';
        $render_data['menu'] = 'sales_tax_process';
        $render_data['header_title'] = $title;
        $this->load->model('service');
        $this->load->model('system');
        $render_data['staffInfo'] = staff_info();
        $render_data['state'] = $this->system->get_all_state();
        $render_data['completed_orders'] = $this->service->completed_orders_salestax(47); //id will be different for live
        $render_data['county_details'] = $this->action_model->get_county_name();
        //$render_data["data"]["notes"] = explode(",", $render_data["data"]["notes"]);
        $render_data["sales_tax_process_files"] = $this->action_model->get_files_by_sales_tax_process_id($id);
        $render_data['sales_tax_process_dtls'] = $this->action_model->getSalesTaxProcessById($id);

        $this->load->template('action/edit_sales_tax', $render_data);
    }

    function get_ajax_county_rate() {
        $county = $this->input->post('county');
        $rate = $this->input->post('rate');
        $data['county_rate'] = $this->action_model->getCountyAjaxRate($county, $rate);
        $this->load->view('action/county_rate_ajax', $data);
    }

    function update_sales_tax_process($salesid) {
        $this->load->model('sales_tax_process');
        if ($this->sales_tax_process->updateSalesTaxProcess(post(), $salesid, $_FILES["upload_file"])) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function update_sales_process_status() {
        echo $this->action_model->updateSalesProcessStatus($this->input->post("id"), $this->input->post("status"));
    }

    public function view_sales_process($id) {
        $this->load->layout = 'dashboard';
        $title = "Sales Tax Processing Details";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'action';
        $render_data['menu'] = 'sales_tax_process';
        $render_data['header_title'] = $title;
        $this->load->model('service');
        $this->load->model('system');
        $render_data['staffInfo'] = staff_info();
        $render_data['state'] = $this->system->get_all_state();
        $render_data['completed_orders'] = $this->service->completed_orders(47);
        $render_data['county_details'] = $this->action_model->get_county_name();
        $render_data['sales_tax_process_dtls'] = $this->action_model->getSalesTaxProcessById($id);
        $this->load->template('action/view_sales_tax', $render_data);
    }

    public function get_sales_tax_recurring() {
        $clval = post('clval');
        $get_sales_tax_recurring_data = $this->action_model->get_sales_tax_recurring_data($clval);
        echo json_encode($get_sales_tax_recurring_data);
    }

    public function updateSalesTaxProcessNotes() {
        if (isset($_POST['notes']) && !empty($_POST['notes'])) {
            $this->load->model('Notes');
            $this->Notes->updateNotes($_POST, $_POST['notestable']);
            redirect(base_url() . 'action/home/sales_tax_process');
        }
    }

    public function assign_action() {
        $action_id = post('action_id');
        if (post('staff_id') != '') {
            $staff_id = post('staff_id');
        } else {
            $staff_id = sess('user_id');
        }
        if ($this->action_model->assign_action_by_action_id($action_id, $staff_id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function dashboard_ajax() {
        $request = post("request");
        $status = post("status");
        $priority = post("priority");
        $office_id = post("office_id");
        $department_id = post("department_id");
        $filter_assign = post("filter_assign");
        $render_data["action_list"] = $this->action_model->get_action_list($request, $status, $priority, $office_id, $department_id, $filter_assign);
        $return["result"] = $this->load->view("action/ajax_dashboard", $render_data, true);
        echo json_encode($return);
    }

    public function sort_dashboard(){
        $formdata = post();
        $sort_criteria = $formdata['sort_criteria'];
        $sort_type = $formdata["sort_type"];
        unset($formdata['sort_criteria']);
        unset($formdata['sort_type']);
        $filter_assign = $formdata;
        $render_data["action_list"] = $this->action_model->get_action_list('', '', '', '', '', '', $filter_assign, '', $sort_criteria, $sort_type);
        $return["result"] = $this->load->view("action/ajax_dashboard", $render_data, true);
        echo json_encode($return);
    }

    public function addNotesmodal() {
        $notes = $this->input->post('action_note');
        $id = $this->input->post('actionid');
        $all_staffs = $this->input->post('all_staffs');
        $all_staffs = explode(",",$all_staffs);
        $this->load->model('notes');
        if (!empty($notes)) {
            $this->notes->insert_note(2, $notes, "action_id", $id, 'action');
            $this->system->save_general_notification('action', $id, 'note', $all_staffs);
            // $check_action_created_by = $this->action_model->check_action_created_by($id);
            // if ($check_action_created_by['added_by_user'] == sess('user_id')) {
            //     if ($check_action_created_by['status'] == 2) {
            //         $this->action_model->changeActionStatus($id);
            //     }
            // }
            echo count($notes);
        }else{
            echo '0';
        }
        //redirect(base_url() . 'action/home');
    }

    public function filter_dropdown_option_ajax() {
        $result['element_key'] = $element_key = post('variable');
        $result['condition'] = '';
        if (post('condition')) {
            $result['condition'] = post('condition');
        }
        $office = '';
        if (post('office')) {
            $office = post('office');
        }
        if (post('dashboard_type')) {
            $result['element_array'] = $this->sales_tax_filter_element;
            $result['element_value_list'] = $this->action_model->get_salestax_filter_element_value($element_key);
        } else {
            $result['element_array'] = $this->filter_element;
            $result['element_value_list'] = $this->action_model->get_action_filter_element_value($element_key, $office);
        }
        $this->load->view('action/filter_dropdown_option_ajax', $result);
    }

    public function action_filter() {
        $render_data["action_list"] = $this->action_model->get_action_list('', '', '', '', '', '', post());
        $this->load->view("action/ajax_dashboard", $render_data);
    }

    function sales_tax_dashboard_ajax() {
        $filter_data = post();
        $month_year = post('month_year');
        $request_type = post('request_type');
        $status = post('status');
        $is_insert = post('is_insert');
        if ($is_insert == 'insert') {
            $this->action_model->repeat_save_sales_tax_process($month_year);
        }
        if (post('is_filter') == '') {
            $filter_data = [];
        }
        unset($filter_data['month_year']);
        unset($filter_data['request_type']);
        unset($filter_data['status']);
        unset($filter_data['is_filter']);
        unset($filter_data['is_insert']);
        $staff_info = staff_info();
        $stafftype = $staff_info['type'];
        $staffrole = $staff_info['role'];
//        print_r(post());
//        exit;
        $return['summary_count'][] = 'my_sales_tax_new-' . count($this->action_model->get_sales_tax_process_list(sess('user_id'), $month_year, 'my', 0));
        $return['summary_count'][] = 'my_sales_tax_started-' . count($this->action_model->get_sales_tax_process_list(sess('user_id'), $month_year, 'my', 1));
        $return['summary_count'][] = 'my_sales_tax_completed-' . count($this->action_model->get_sales_tax_process_list(sess('user_id'), $month_year, 'my', 2));
        if ($stafftype == 1 || ($stafftype == 3 && $staffrole == 2) || ($stafftype == 2 && $staffrole == 4)) {
            $return['summary_count'][] = 'others_sales_tax_new-' . count($this->action_model->get_sales_tax_process_list(sess('user_id'), $month_year, 'others', 0));
            $return['summary_count'][] = 'others_sales_tax_started-' . count($this->action_model->get_sales_tax_process_list(sess('user_id'), $month_year, 'others', 1));
            $return['summary_count'][] = 'others_sales_tax_completed-' . count($this->action_model->get_sales_tax_process_list(sess('user_id'), $month_year, 'others', 2));
        }
        $month_year_array = explode('/', $month_year);
        $return['search_month'] = date('F, Y', strtotime(date('Y') . '-' . $month_year_array[0] . '-01'));
        $data['sales_tax_process'] = $this->action_model->get_sales_tax_process_list(sess('user_id'), $month_year, $request_type, $status, $filter_data);
        $return['sales_tax_data'] = $this->load->view("action/sales_tax_process_dashboard_ajax", $data, true);
        echo json_encode($return);
    }

    public function get_mngrs() {
        $ofc_id = post('ofc_id');
        $selected = post('selected');
        if ($ofc_id == '') {
            $render_data['mngrs'] = $this->system->get_staff_list();
        } else {
            $render_data['mngrs'] = $this->action_model->get_mngrs($ofc_id);
        }
        $render_data['selected']= $selected;
        $this->load->view("action/manager_list", $render_data);
    }

    public function delete_individual() {
        $result = $this->action_model->delete_individual(post());
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }
    public function activate_individual() {
        $id = post('id');
        $result = $this->action_model->activate_individual($id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }
    public function delete_business() {
        $result = $this->action_model->delete_business(post());
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function activate_business() {
        $id = post('id');
        $reference_id = post('reference_id');
        $result = $this->action_model->activate_business($id, $reference_id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function check_if_individual_associated($individual_id) {
        echo $this->action_model->check_if_individual_associated($individual_id);
    }

    public function check_if_business_associated($reference_id) {
        echo $this->action_model->check_if_business_associated($reference_id);
    }

    public function inactive_individual(){
        $id = post('id');
        $result = $this->action_model->inactive_individual($id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }
    public function sos_count(){
        echo sos_dashboard_count('action', 'byme');
    }

}
