<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("administration");
        $this->load->model("system");
        $this->load->model("lead_management");
        $this->load->model("referral_partner");
        $this->load->model("action_model", "action");
        $this->load->model("service_model");
        $this->load->model("videos_model");
        $this->load->model("billing_model");
        $this->load->model("notes");
        $this->load->model('marketing_model');
        $this->load->model('News_Update_model');
        $this->load->model('Project_Template_model');
        $this->load->model('Visitation_model');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function edit_department() {
        $render_data['department_info'] = $this->administration->get_department_by_id($this->input->post('department_id'));
        $render_data['department_staffs'] = $this->administration->get_department_staffs_by_id($this->input->post('department_id'));
        $render_data['selected_manager'] = $this->administration->get_selected_manager_by_id($this->input->post('department_id'));
        $this->load->view('modal/edit_department_modal', $render_data);
    }

    public function show_franchise_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data['state_list'] = $this->system->get_all_state();
        $render_data['office_type_list'] = $this->administration->get_all_office_type();
        $render_data['office_list'] = $this->administration->get_all_office();
        if ($render_data['modal_type'] == "edit") {
            $render_data['franchise_info'] = $this->administration->get_office_by_id($this->input->post('franchise_id'));
            $render_data['office_staff'] = $this->administration->get_all_office_staff_by_office_id(post("franchise_id"));
        }
        $this->load->view('modal/franchise_modal', $render_data);
    }

    public function show_staff_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data['staff_type_list'] = $this->administration->get_all_staff_type();
        $render_data['office_list'] = $this->administration->get_all_office_admin();
        if ($render_data['modal_type'] == "edit") {
            $render_data['staff_info'] = $this->administration->get_staff_by_id($this->input->post('staff_id'));
            $staff_type = $render_data['staff_info']['type'];
            $render_data['department_list'] = $this->administration->get_department_staffwise($staff_type);
            $render_data['office_list'] = $this->administration->get_all_office_stafftypewise($render_data['staff_info']['type']);
        } else {
            $render_data['office_list'] = $this->administration->get_all_office_admin();
            $render_data['department_list'] = $this->administration->get_department_staffwise(1);
        }
        $this->load->view('modal/staff_modal', $render_data);
    }

    public function add_visitation_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $edit_id = post('id');
        if (isset($edit_id) && $edit_id != '') {
            $render_data['attachments'] = $this->Visitation_model->show_attachment_in_editpage($edit_id);

            $render_data['visitation_result'] = $this->Visitation_model->show_edit_visitation($edit_id);
            //$render_data['parti'] = $this->Visitation_model->show_participation($edit_id);
            // print_r($render_data['parti']);exit; 
        }
        $this->load->view('modal/visitation_modal', $render_data);
    }

    public function show_visit_notes_modal() {
        $id = post('id');
        if (isset($id) && $id != '') {
            // $render_data['notes_data'] = $this->Visitation_model->show_notes_in_modalpage($id); 
            $this->load->model('Notes');
            $related_table_id = '10';
            $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'visitation_id', $id);
            $render_data['notes_table'] = 'visitation_notes';
            $this->Notes->change_read_status_visitnotes($id);
        }
        $this->load->view('modal/visitnote_modal', $render_data);
    }

    public function change_visitation_status() {
        $render_data['status'] = $this->input->post('visitation_status');
        $render_data['visitation_id'] = $this->input->post("visitation_id");
        // $render_data["tracking_logs"] = $this->action->get_tracking_log($this->input->post("visitation_id"), "visitation");
        $this->load->view('modal/visitation_status_tracking_modal', $render_data);
    }

    public function show_department_modal() {
        $this->load->view('modal/add_department_modal');
    }

    public function show_service_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data["categories"] = $this->administration->get_all_categories();
        $render_data['department_list'] = $this->administration->get_all_departments();
        if ($render_data['modal_type'] == "edit") {
            $render_data['service_info'] = $this->administration->get_service_by_id_for_service_setup($this->input->post('service_id'));
        }
        $this->load->view('modal/service_modal', $render_data);
    }

    public function show_partner_service_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data["partners_type_list"] = $this->administration->get_partners_type_list();
        if ($render_data['modal_type'] == "edit") {
            $render_data['partner_service_info'] = $this->administration->get_partner_service_by_id(post('service_id'));
        }
        $this->load->view('modal/partner_service_modal', $render_data);
    }

    public function show_company_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        if ($render_data['modal_type'] == "edit") {
            $render_data['company_name'] = $this->administration->get_company_by_id($this->input->post('company_id'));
        }
        $this->load->view('modal/company_modal', $render_data);
    }

    public function show_source_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        if ($render_data['modal_type'] == "edit") {
            $render_data['source_name'] = $this->administration->get_source_by_id($this->input->post('source_id'));
        }
        $this->load->view('modal/sources_modal', $render_data);
    }

    public function show_lead_type_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        if ($render_data['modal_type'] == "edit") {
            $render_data['lead_type_name'] = $this->lead_management->get_lead_type_name_by_id($this->input->post('lead_id'));
        }
        $this->load->view('modal/lead_type_modal', $render_data);
    }

    public function show_lead_ref_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        if ($render_data['modal_type'] == "edit") {
            $render_data['lead_ref_name'] = $this->lead_management->get_lead_ref_name_by_id($this->input->post('ref_id'));
        }
        $this->load->view('modal/lead_ref_modal', $render_data);
    }

    public function show_lead_source_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        if ($render_data['modal_type'] == "edit") {
            $render_data['lead_source_name'] = $this->lead_management->get_lead_source_by_id($this->input->post('source_id'));
        }
        $this->load->view('modal/lead_source_modal', $render_data);
    }

    public function show_action_tracking_modal() {
        $render_data["current_status"] = $this->action->get_current_status("actions", $this->input->post("id"));
        $render_data["id"] = $this->input->post("id");
        $render_data["added_by_user_id"] = $this->action->get_added_by($this->input->post("id"));
        $render_data['priority'] = $this->action->get_action_priority($this->input->post("id"));
        $render_data["page_name"] = $this->input->post("page_name");
        $render_data["sos_read_status"] = $this->action->get_sos_read_status(post("id")); 
        $render_data["tracking_logs"] = $this->action->get_tracking_log($this->input->post("id"), "actions");
        $this->load->view('modal/action_tracking_modal', $render_data);
    }

    public function show_lead_tracking_modal() {
        $render_data["current_status"] = $this->action->get_current_status("lead_management", $this->input->post("id"));
        $render_data["id"] = $this->input->post("id");
        $render_data["lead_type"] = $this->lead_management->get_types_of_lead(post("id"));
        $render_data["tracking_logs"] = $this->lead_management->get_tracking_log($this->input->post("id"), "lead_management");
        $this->load->view('modal/lead_tracking_modal', $render_data);
    }

    public function show_ref_partner_tracking_modal() {
        $render_data["current_status"] = $this->action->get_current_status("lead_management", $this->input->post("id"));
        $render_data["id"] = $this->input->post("id");
        $render_data["tracking_logs"] = $this->lead_management->get_tracking_log($this->input->post("id"), "lead_management");
        $this->load->view('modal/ref_partner_tracking_modal', $render_data);
    }

    public function show_action_notes() {
        //$render_data["notes"] = $this->action->get_action_notes($this->input->post("id"));
        $this->load->model('Notes');
        $related_table_id = '2';
        $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'action_id', $this->input->post("id"));
        $render_data['notes_table'] = 'action_notes';
        $userid=$this->input->post('user_id');
        // echo $this->input->post("id");die;
        $change_read_status = $this->Notes->change_read_status_notes($this->input->post("id"),$userid);

        $this->load->view('action/action_notes_modal', $render_data);
    }

    public function show_marketing_notes() {
        $this->load->model('Notes');
        $related_table_id = '6';
        $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'marketing_id', $this->input->post("id"));
        $render_data['notes_table'] = 'marketing_notes';

        $this->load->view('marketing_materials/marketing_notes_modal', $render_data);
    }

    public function add_note_cart() {
        $this->load->model('Notes');
        $related_table_id = '7';
        $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'cart_id', $this->input->post("id"));
        $render_data['notes_table'] = 'cart_notes';

        $this->load->view('marketing_materials/cart_notes_modal', $render_data);
    }

    public function show_lead_notes() {
        $this->load->model('Notes');
        $related_table_id = '3';
        $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'lead_id', $this->input->post("id"));
        $render_data['notes_table'] = 'lead_notes';
        $this->load->view('lead_management/lead_notes_modal', $render_data);
    }

    public function show_salestax_process_notes() {
        $this->load->model('Notes');
        $related_table_id = '1';
        $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'reference_id', post('reference_id'), post('reference'));
        $render_data['notes_table'] = 'notes';
        $this->load->view('action/salestax_process_notes_modal', $render_data);
    }

    public function show_ref_partner_notes() {
        $this->load->model('Notes');
        $related_table_id = '3';
        $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'lead_id', $this->input->post("id"));
        $render_data['notes_table'] = 'lead_notes';
        $this->load->view('referral_partner/ref_partner_notes_modal', $render_data);
    }

    public function show_action_files() {
        $render_data['files_data'] = $this->action->getFilesContent($this->input->post("id"));
        $render_data['id'] = $this->input->post("id");
        $render_data['staff_list'] = post('staff');
        $this->action->updateFileReadStatus(post("id"));
        $this->load->view('action/file_list_modal', $render_data);
    }

    public function show_image_file_modal() {
        $render_data["file"] = $this->input->post("image");
        $this->load->view('action/image_preview_modal', $render_data);
    }

    public function show_add_contact() {
        $render_data['modal_type'] = post('modal_type');
        $render_data['reference'] = post('reference');
        $render_data['reference_id'] = post('reference_id');
        if ($render_data['modal_type'] == "edit") {
            $render_data["data"] = $this->service_model->get_single_contact_info($this->input->post("id"));
        }
        $this->load->view('modal/add_contact_modal', $render_data);
    }

    public function show_add_document() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data['reference'] = post('reference');
        $render_data['reference_id'] = post('reference_id');
        if ($render_data['modal_type'] == "edit") {
            //Some Code
        }
        $this->load->view('modal/add_document_modal', $render_data);
    }

    public function show_contact() {

        $render_data['modal_type'] = post('modal_type');
        $render_data['reference'] = post('reference');
        $render_data['reference_id'] = post('reference_id');
        if ($render_data['modal_type'] == "edit") {
            $render_data["data"] = $this->service_model->get_single_contact_info($this->input->post("id"));
        }
//        print_r($render_data["data"]);exit;
        $this->load->view('modal/contact_modal', $render_data);
    }

    public function show_document() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data['reference'] = post('reference');
        $render_data['reference_id'] = post('reference_id');
        if ($render_data['modal_type'] == "edit") {
            //Some Code
        }
        $this->load->view('modal/document_modal', $render_data);
    }

    public function show_financial_account() {
        $render_data['modal_type'] = post('modal_type');
        $render_data['reference_id1'] = post('reference_id1');
        $render_data['client_id']=post('client_id');
        $render_data['order_id'] = post('order_id');
        $section = post('section');
        $render_data['account_details']=$this->company_model->get_account_details_bookkeeping(post('reference_id1'),'',post('client_id'));
//        $this->load->view('modal/financial_account',$data);
        if ($render_data['modal_type'] == "edit") {
            $render_data["id"] = post("id");
            $render_data["data"] = $this->service_model->get_financial_account_info(post("id"));
        }
        if ($section == "month_diff") {
            $this->load->view('modal/financial_account_by_date', $render_data);
        } else {
            $this->load->view('modal/financial_account', $render_data);
        }
    }

    public function show_owner_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data['reference'] = post('reference');
        $render_data['reference_id'] = post('reference_id');
        $render_data["service_id"] = post("service_id");
        if ($render_data['modal_type'] == "edit") {
            $render_data["id"] = post("id");
        }
        $this->load->view('modal/owner_modal', $render_data);
    }

    public function show_employee_modal() {
        $render_data['modal_type'] = post('modal_type');
        $this->load->model('employee');
        if ($render_data['modal_type'] == "edit") {
            $employee_id = post('employee_id');
            $render_data['employee_details'] = $this->employee->get_employee_by_id($employee_id);
        }
        $this->load->view('modal/employee_modal', $render_data);
    }

    public function show_payroll_approver_modal() {
        $render_data['oredr_id'] = post('oredr_id');
        $render_data['reference_id'] = post('reference_id');
        $this->load->view('modal/payroll_approver_modal', $render_data);
    }

    public function get_msg_details() {
        $action_id = post('action_id');
        $render_data['msg_details'] = $this->action->msg_details($action_id);
        $this->load->view('action/msg_details', $render_data);
    }

    public function get_user_details() {
        $user_id = post('user_id');
        $this->load->model('system');
        $render_data['user_details'] = $this->system->get_staff_info($user_id);
        $this->load->view('action/user_details', $render_data);
    }

    public function show_main_cat_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        if ($render_data['modal_type'] == "edit") {
            $render_data['main_cat_name'] = $this->videos_model->get_main_cat_by_id($this->input->post('source_id'));
        }
        $this->load->view('modal/main_cat_modal', $render_data);
    }

    public function show_marketing_main_cat_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $this->load->model('marketing_model');
        if ($render_data['modal_type'] == "edit") {
            $render_data['main_cat_name'] = $this->marketing_model->get_main_cat_by_id($this->input->post('source_id'));
        }
        $this->load->view('modal/marketing_main_cat_modal', $render_data);
    }

    public function show_operational_manual_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $this->load->model('operational_model');
        if ($render_data['modal_type'] == "edit") {
            $render_data['data'] = $this->operational_model->get_operational_manual_data_by_id($this->input->post('source_id'));
        }
        $this->load->view('modal/operational_manual_modal', $render_data);
    }

    public function show_operational_main_cat_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $this->load->model('operational_model');
        if ($render_data['modal_type'] == "edit") {
            $render_data['main_cat_name'] = $this->operational_model->get_main_cat_by_id($this->input->post('source_id'));
        }
        $this->load->view('modal/operational_main_cat_modal', $render_data);
    }

    public function show_sub_cat_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        if ($render_data['modal_type'] == "edit") {
            $render_data['sub_cat_name'] = $this->videos_model->get_sub_cat_by_id($this->input->post('source_id'));
        }
        $render_data['main_cat'] = $this->videos_model->get_main_cats();
        $this->load->view('modal/sub_cat_modal', $render_data);
    }

    public function show_marketing_sub_cat_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        if ($render_data['modal_type'] == "edit") {
            $render_data['sub_cat_name'] = $this->marketing_model->get_sub_cat_by_id($this->input->post('source_id'));
        }
        $render_data['main_cat'] = $this->marketing_model->get_main_cats();
        $this->load->view('modal/marketing_sub_cat_modal', $render_data);
    }

    public function show_operational_sub_cat_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $this->load->model('operational_model');
        if ($render_data['modal_type'] == "edit") {
            $render_data['sub_cat_name'] = $this->operational_model->get_sub_cat_by_id($this->input->post('source_id'));
        }
        $render_data['main_cat'] = $this->operational_model->get_main_cats();
        $this->load->view('modal/operational_sub_cat_modal', $render_data);
    }

    public function show_payment_modal() {
        $render_data['modal_type'] = post('modal_type');
        $render_data['invoice_id'] = post('invoice_id');
        $render_data['service_id'] = post('service_id');
        $render_data['order_id'] = post('order_id');
        $render_data['due_amount'] = post('due_amount');
        $render_data['payment_type'] = $this->billing_model->get_payment_type();
        if ($render_data['modal_type'] == "edit") {
            //Some Code
        }
        $this->load->view('modal/payment_modal', $render_data);
    }

    public function show_refund_modal() {
        $render_data['modal_type'] = post('modal_type');
        $render_data['invoice_id'] = post('invoice_id');
        $render_data['service_id'] = post('service_id');
        $render_data['order_id'] = post('order_id');
        $render_data['payble_amount'] = post('payble_amount');
        $render_data['payment_type'] = $this->billing_model->get_payment_type();
        if ($render_data['modal_type'] == "edit") {
            //Some Code
        }
        $this->load->view('modal/refund_modal', $render_data);
    }

    public function show_business_client_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data['state'] = $this->system->get_all_state();
        if ($render_data['modal_type'] == "edit") {
            $render_data['business_client'] = $this->administration->get_business_client_by_id($this->input->post('client_id'));
        }
        $this->load->view('modal/business_client_modal', $render_data);
    }

    public function show_renewal_dates_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data['state'] = $this->system->get_all_state();
        $render_data['company'] = $this->system->get_all_company_type();
        if ($render_data['modal_type'] == "edit") {
            $render_data['renewal_dates'] = $this->administration->get_renewal_dates_by_id($this->input->post('client_id'));
        }
        $this->load->view('modal/renewal_dates_modal', $render_data);
    }

    public function showSalesProcessTrackingModal() {
        $render_data["current_status"] = $this->action->get_current_status("sales_tax_process", $this->input->post("id"));
        $render_data["id"] = $this->input->post("id");
        $render_data["tracking_logs"] = $this->action->get_tracking_log($this->input->post("id"), "sales_tax_process");
        $this->load->view('modal/sales_process_tracking_modal', $render_data);
    }

    public function show_ref_partner_client_notes_modal() {
        $render_data["ref_partner_table_id"] = $this->input->post("ref_partner_table_id");
        $render_data["get_note_data"] = $this->referral_partner->get_note_data($this->input->post("ref_partner_table_id"));
        $this->load->view('referral_partner/show_ref_partner_client_notes_modal', $render_data);
    }

    public function training_materials_attachments_modal() {
        $render_data['files_data'] = get_training_videos($this->input->post("training_material_id"));
        $this->load->view('modal/show_training_materials_attachments_modal', $render_data);
    }

    public function note_notification() {
        $render_data['notification_details'] = $this->notes->note_notification_list_with_log(post('related_table_id'), post('notification_reference'), post('bywhom'));
        $this->notes->change_read_status($render_data['notification_details']);
        if (count($render_data['notification_details']) != 0) {
            $this->load->view('modal/show_note_notification_modal', $render_data);
        } else {
            echo 0;
        }
    }

    public function show_action_assign_modal() {
        $this->load->view('modal/action_assign_modal', post());
    }

    public function show_order_assign_modal() {
        $data = post();
        $data['all_staffs'] = trim($data['all_staffs'], ',');
        $data['all_staffs'] = explode(',', $data['all_staffs']);
        $this->load->view('modal/order_assign_modal', $data);
    }

    public function show_service_assign_modal() {
        $data = post();
        $data['all_staffs'] = trim($data['all_staffs'], ',');
        $data['all_staffs'] = explode(',', $data['all_staffs']);
        $this->load->view('modal/service_assign_modal', $data);
    }

    public function show_sos() {
        $reference = post('reference');
        $service_id = post('service_id');
        $order_id = post('order_id');
        $render_data['all_sos'] = $this->system->show_sos($reference, $service_id, $order_id);
        $this->load->view('modal/show_sos_modal', $render_data);
    }

    public function sos_filter() {
        $sos_value = post('byval');
        $dashboard_type = post('dashboard_type');
        if ($dashboard_type == 'order') {
            $render_data['result'] = $this->service_model->ajax_services_dashboard_filter('', '', '', '', '', '', '', '', '', $sos_value);
            $render_data['serviceid'] = $this->service_model->getServiceId();
            $this->load->view('services/ajax_dashboard', $render_data);
        } else {
            $render_data["action_list"] = $this->action_model->get_action_list('', '', '', '', '', '', '', $sos_value);
            $this->load->view("action/ajax_dashboard", $render_data);
        }
    }

    public function ajax_news_details() {

        $render_data = [];
        if (post('news_id') != '') {
            $render_data['details'] = $this->News_Update_model->get_news_details_by_id(post('news_id'));
            $this->load->view("newsandupdates/ajax_news_details", $render_data);
        }
    }

    public function ajax_manage_news() {

        $render_data = [];

        $render_data['office_type'] = $this->administration->get_all_office_type();
        $render_data['news_id'] = '';

        if (post('news_id') != '') {

            $render_data['details'] = $this->News_Update_model->get_news_details_by_id(post('news_id'));
            $render_data['assigned_office'] = $this->News_Update_model->get_news_office(post('news_id'));
            $render_data['assigned_dept'] = $this->News_Update_model->get_news_department(post('news_id'));
            $render_data['news_id'] = post('news_id');
        }
        $this->load->view("newsandupdates/ajax_manage_news", $render_data);
    }

    public function get_template_task_modal() {
        $render_data = [];
        $render_data['template_id'] = $this->input->post('template_id');
        $render_data["departments"] = $this->action->get_departments();
        $render_data['template_category_id']=$this->Project_Template_model->getTemplateCategoryByTemplateId($this->input->post('template_id'));
        $this->load->view("administration/project_template/project_template_task_modal", $render_data);
    }

    public function edit_template_task_modal() {
        $render_data = [];
        $this->load->model('Project_Template_model');
        $task_id = $this->input->post('task_id');
        $render_data['task_id'] = $task_id;
        $render_data['template_id']=post('template_id');
        $render_data["departments"] = $this->action->get_departments();
        $render_data['task_details'] = $this->Project_Template_model->getTemplateTaskDetails($task_id);
        $render_data['staff_type'] = $this->Project_Template_model->getStaffType();
        $render_data['template_category_id']=$this->Project_Template_model->getTemplateCategoryByTemplateId(post('template_id'));
        $this->load->view("administration/project_template/edit_project_template_task_modal", $render_data);
    }

    public function clear_sos_notifications() {
        $sosids = explode(",", post('sosids'));
        $reference = post('reference');
        $reference_id = post('reference_id');
        $this->system->clear_sos_notifications($sosids, $reference, $reference_id);
    }
    public function clear_sos() {
        $sosids = explode(",", post('sosids'));
        $reference = post('reference');
        $reference_id = post('reference_id');
        $this->system->clear_sos($sosids, $reference, $reference_id);
    }

    public function show_task_notes() {
        //$render_data["notes"] = $this->action->get_action_notes($this->input->post("id"));
        $this->load->model('Notes');
        $related_table_id = '8';
        $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'task_id', $this->input->post("id"));
        $render_data['notes_table'] = 'template_task_note';
        // echo $this->input->post("id");die;
        $change_read_status = $this->Notes->change_task_read_status_notes($this->input->post("id"));

        $this->load->view('administration/project_template/task_note_modal', $render_data);
    }

    public function ajax_manage_project() {
        $render_data = [];
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data['template_list'] = $this->Project_Template_model->get_project_template_list();
        $render_data['project_id'] = '';
        $render_data['reference_id'] = $this->system->create_reference_id();
        if ($render_data['modal_type'] == 'edit') {
            $render_data['project_id'] = $this->input->post('project_id');
            $render_data['template_list'] = $this->Project_Template_model->get_project_template_list();
            $render_data['project_dtls'] = $this->Project_Template_model->getProjectDetails($this->input->post('project_id'));
            $render_data['office_id'] = $this->Project_Template_model->get_project_office_id($this->input->post('project_id'));
//            print_r($render_data['project_dtls']);die;
        }
        $this->load->view("projects/ajax_manage_project", $render_data);
    }

    public function show_project_notes() {
        //$render_data["notes"] = $this->action->get_action_notes($this->input->post("id"));
        $this->load->model('Notes');
        $related_table_id = '9';
        $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'project_id', $this->input->post("id"));
        $render_data['notes_table'] = 'project_note';
//        $render_data['project_id']=$this->input->post("id");
        $change_read_status = $this->Notes->change_task_read_status_notes($this->input->post("id"));

        $this->load->view('projects/project_note_modal', $render_data);
    }

    public function file_upload_actions() {
        echo $this->action_model->file_upload_actions(post(), $_FILES["upload_file"]);
        // print_r($this->action_model->file_upload_actions(post(), $_FILES["upload_file"]));
    }

    public function edit_project_task_modal() {
        $render_data = [];
        $this->load->model('Project_Template_model');
        $task_id = $this->input->post('task_id');
        $render_data['task_id'] = $task_id;
        $render_data["departments"] = $this->action->get_departments();
        $render_data['task_details'] = $this->Project_Template_model->getProjectTaskDetails($task_id);
        $render_data['staff_type'] = $this->Project_Template_model->getStaffType();
        $render_data['template_category_id']=$this->Project_Template_model->getProjectTemplateCategoryd(post('project_id'));
        $render_data['template_details'] = $this->Project_Template_model->editProjectMainDetail(post('project_id'));
        $render_data['project_id'] = post('project_id');
        $this->load->view("projects/edit_project_task_modal", $render_data);
    }

    public function get_project_task_modal() {       
        $render_data = [];
        $render_data['template_id'] = $this->input->post('template_id');
        $render_data['project_id'] = $this->input->post('project_id');
        $render_data["departments"] = $this->action->get_departments();
        $render_data['template_category_id']=$this->Project_Template_model->getProjectTemplateCategoryd(post('project_id'));
        $render_data['project_id'] = post('project_id');
        $render_data['template_details'] = $this->Project_Template_model->editProjectMainDetail(post('project_id'));
        $this->load->view("projects/project_task_modal", $render_data);
    }

    public function action_notification_modal() {
        $data = post();
        $forValue = $data['forvalue'];
//        $where['gn.action'] = 'tracking';
        $where['gn.reference'] = 'action';
        $render_data['general_notification_list'] = $this->system->get_general_notification_by_user_id(sess('user_id'), '', $where, '', $forValue);
        if (!empty($render_data['general_notification_list']) && count($render_data['general_notification_list']) > 0) {
            $this->load->view("modal/show_action_notification_modal", $render_data);
        } else {
            echo 0;
        }
    }

    public function service_notification_modal() {
        $data = post();
        $forValue = $data['forvalue'];
//        $where['gn.action'] = 'tracking';
        $where['gn.reference'] = 'order';
        $render_data['general_notification_list'] = $this->system->get_general_notification_by_user_id(sess('user_id'), '', $where, '', $forValue);
        if (!empty($render_data['general_notification_list']) && count($render_data['general_notification_list']) > 0) {
            $this->load->view("modal/show_service_notification_modal", $render_data);
        } else {
            echo 0;
        }
    }

    public function project_notification_modal() {
        $where['gn.action'] = 'tracking';
        $where['gn.reference'] = 'projects';
        $render_data['general_notification_list'] = $this->system->get_general_notification_by_user_id(sess('user_id'), '', $where);
        if (!empty($render_data['general_notification_list']) && count($render_data['general_notification_list']) > 0) {
            $this->load->view("modal/show_project_notification_modal", $render_data);
        } else {
            echo 0;
        }
    }

    public function notification_modal() {
        $where['gn.action'] = post('action');
        $where['gn.reference'] = post('reference');
        $render_data['general_notification_list'] = $this->system->get_general_notification_by_user_id(sess('user_id'), '', $where);
        if (!empty($render_data['general_notification_list']) && count($render_data['general_notification_list']) > 0) {
            $this->load->view("modal/show_notification_modal", $render_data);
        } else {
            echo 0;
        }
    }

    public function sos_filter_project() {
        $this->load->model('Project_Template_model');
        $sos_value = post('byval');
        $dashboard_type = post('dashboard_type');
        $render_data["project_list"] = $this->Project_Template_model->get_project_list('', '', '', '', '', '', '', $sos_value);
        $this->load->view("projects/project_dashboard", $render_data);
    }

    public function buyer_info_modal() {
        $render_data['modal_type'] = post('modal_type');
        $render_data['reference'] = post('reference');
        $render_data['reference_id'] = post('reference_id');
        $render_data['id'] = post('id');
        if ($render_data['modal_type'] == "edit") {
            $render_data['buyer_data'] = $this->service_model->get_single_buyer_info($render_data['id']);
        }
        $this->load->view('modal/buyer_info_modal', $render_data);
    }

    public function seller_info_modal() {
        $render_data['modal_type'] = post('modal_type');
        $render_data['reference'] = post('reference');
        $render_data['reference_id'] = post('reference_id');
        $render_data['id'] = post('id');
        if ($render_data['modal_type'] == "edit") {
            $render_data['seller_data'] = $this->service_model->get_single_seller_info($render_data['id']);
        }
        $this->load->view('modal/seller_info_modal', $render_data);
    }

    public function delete_template_task_modal() {
        $render_data = [];
        $this->load->model('Project_Template_model');
        $task_id = $this->input->post('task_id');
        $render_data['task_id'] = $task_id;
        $render_data["departments"] = $this->action->get_departments();
        $render_data['task_details'] = $this->Project_Template_model->getTemplateTaskDetails($task_id);
        $render_data['staff_type'] = $this->Project_Template_model->getStaffType();
        $this->load->view("administration/project_template/edit_project_template_task_modal", $render_data);
    }

    public function sos_filter_task() {
        $this->load->model('Task_model');
        $sos_value = post('byval');
        $dashboard_type = post('dashboard_type');
        $render_data["task_list"] = $this->Task_model->get_task_list('', '', '', '', '', '', '', $sos_value);
        $this->load->view("task/task_dashboard", $render_data);
    }

    public function show_invoice_email_modal() {
        $render_data['invoice_id'] = $this->input->post('invoice_id');
        $render_data['email_list'] = explode(',', $this->input->post('emails'));
        $this->load->view('modal/invoice_email_modal', $render_data);
    }
    public function show_project_task_notes() {
//        echo $this->input->post('id');die;
        //$render_data["notes"] = $this->action->get_action_notes($this->input->post("id"));
        $this->load->model('Notes');
        $related_table_id = '11';
        $render_data['notes_data'] = $this->Notes->note_list_with_log($related_table_id, 'task_id', $this->input->post("id"));
        $render_data['notes_table'] = 'project_task_note';
        // echo $this->input->post("id");die;
        $change_read_status = $this->Notes->change_project_task_read_status_notes($this->input->post("id"));
//        print_r($render_data['notes_data']);die;
        $this->load->view('projects/project_task_note_modal', $render_data);
    }

    public function add_lead_modal() {
        $render_data['modal_type'] = $this->input->post('modal_type');
        $render_data['id'] = $this->input->post('id');
        $render_data["languages"] = $this->system->get_languages();
        $render_data["selected_lang"] = $this->lead_management->get_selected_languages($this->input->post('id'));
        // $render_data["leaddetails"] = $this->lead_management->get_addlead_details($this->input->post('id'));
        $render_data["leaddetails"] = $this->lead_management->fetch_data($this->input->post('id'));
        $render_data["leaddetails"]["notes"] = explode(",", $render_data["leaddetails"]["notes"]);
        $this->load->view('modal/add_leads_modal',$render_data);
    }
    public function show_task_files() {
        $render_data['files_data'] = $this->Project_Template_model->getTaskFilesContent($this->input->post("id"));
        $render_data['id'] = $this->input->post("id");
        $render_data['staff_list'] = post('staff');
        $this->action->updateFileReadStatus(post("id"));
        $this->load->view('projects/task_file_list_modal', $render_data);
    }
    public function file_upload_task() {
        echo $this->Project_Template_model->file_upload_tasks(post(), $_FILES["upload_file"]);
        // print_r($this->action_model->file_upload_actions(post(), $_FILES["upload_file"]));
    }
     public function show_task_financial_account() {
        $render_data['modal_type'] = post('modal_type');
        $render_data['client_id'] = post('client_id');
        $render_data['task_id'] = post('task_id');
        $section = post('section');
        $render_data['account_details']=$this->company_model->get_account_details_bookkeeping(post('task_id'),'project',post('client_id'));
        $render_data['company_id'] = $this->company_model->get_company_id_client_id(post('client_id'));
        $render_data['section'] = post('section');
//        $this->load->view('modal/financial_account',$data);
        if ($render_data['modal_type'] == "edit") {
            $render_data["id"] = post("id");
            $render_data["data"] = $this->service_model->get_financial_account_info(post("id"));
        }
        if ($section == "month_diff") {
            $this->load->view('modal/financial_account_by_date', $render_data);
        } else {
            $this->load->view('modal/task_financial_accounts', $render_data);
        }
    }


     public function show_recipient() {

        $render_data['modal_type'] = post('modal_type');
        $render_data['reference'] = post('reference');
        $render_data['reference_id'] = post('reference_id');
        $render_data['retail_price'] = post('retail_price');
        if ($render_data['modal_type'] == "edit") {
            $render_data["data"] = $this->service_model->get_single_recipient_info($this->input->post("id"));        
        }
       
        $this->load->view('modal/recipient_modal', $render_data);
    }

    // public function get_lead_details_by_id() {
    //     $render_data["lead_email"] = $this->lead_management->get_lead_details_by_id(post('id'))['email'];
        
    // }
    
}
