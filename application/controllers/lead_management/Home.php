<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $filter_element;

    function __construct() {
        parent::__construct();
        $this->load->model("lead_management");
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->filter_element = [
            1 => "Type",
            2 => "Tracking",
            3 => "Office",
            4 => "Staff",
            5 => "Active Date",
            6 => "Complete Date"
        ];
    }

    public function index($stat = '', $type = '', $lead_type = '') {
        $this->load->layout = 'dashboard';
        $title = "Leads Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_dashboard';
        $render_data['header_title'] = $title;
        $render_data['stat'] = $stat;
        $render_data['type'] = $type;
        $render_data['lead_type'] = $lead_type;
        $render_data['filter_element_list'] = $this->filter_element;
        $this->load->template('lead_management/dashboard', $render_data);
    }

    public function view($id = '', $showhide = '') {
        $this->load->layout = 'dashboard';
        $title = "View Lead Management";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_dashboard';
        $render_data['header_title'] = $title;
        $render_data["data"] = $this->lead_management->view_leads_record($id);
//        print_r($render_data["data"]);die;
        $render_data["client_name"] = $this->lead_management->get_client_name($render_data["data"]["lead_agent"]);
        if ($render_data["data"]['type'] == 1) {
            $render_data["contact"] = $this->lead_management->get_type_of_contact_by_id($render_data['data']['type_of_contact']);
        } else {
            $render_data["contact"] = $this->lead_management->get_type_of_contact_referral_by_id($render_data['data']['type_of_contact']);
        }
        $render_data["state"] = $this->lead_management->get_state_by_id($render_data['data']['state']);
        $render_data["notes"] = $this->lead_management->get_notes_by_lead_id($render_data['data']['id']);
        $render_data["prospect"] = $this->lead_management->get_lead_source_by_id($render_data['data']['lead_source']);
        $render_data["language"] = $this->lead_management->get_language_by_id($render_data['data']['language']);
        $render_data['partner_showhide'] = $showhide;
        $render_data['assigned_client_id'] = '';
        $render_data['tracking_logs'] = $this->lead_management->get_tracking_log($render_data['data']['id'], "lead_management");
        $this->load->template("lead_management/view_lead_management", $render_data);
    }

    public function delete_lead(){
        $id = request('id');
        if ($this->lead_management->delete_lead_management($id)) {
            echo "1";
        } else {
            echo "0";
        }
    }   

    public function load_data() {
        $type = post("type");
        $status = post("status");
        $req_by = post("req_by");
        $lead_type = post("lead_type");
        $render_data["data"] = $this->lead_management->load_all_data($type, $status, $req_by, $lead_type);
        $this->load->view("lead_management/load_data", $render_data);
    }

    public function update_action_status() {
        echo $this->lead_management->update_lead_status($this->input->post("id"), $this->input->post("status"));
    }

    public function load_count_data() {
        echo json_encode($this->lead_management->load_count_data());
    }

    public function updateNotes() {
        if (isset($_POST['notes']) && !empty($_POST['notes'])) {
            $this->load->model('Notes');
            $this->Notes->updateNotes($_POST, $_POST['notestable']);
            redirect(base_url() . 'lead_management/home');
        } else {
            redirect(base_url() . 'lead_management/home');
        }
    }

    public function mail_campaign($is_campaign = 'n', $lead_id = '') {
        $this->load->layout = 'dashboard';
        $title = "Mail Campaign Template";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'lead_management';
        $render_data['menu'] = 'new_lead';
        $render_data['header_title'] = $title;
        $render_data['lead_id'] = $lead_id;
        $render_data['is_campaign'] = $is_campaign;
        $this->load->template('lead_management/mail_campaign_template', $render_data);
    }

    public function dashboard_ajax() {
        $lead_type = post("lead_type");
        $status = post("status");
        $request_by = post("request_by");
        $lead_contact_type = post("lead_contact_type");
        $render_data["lead_list"] = $this->lead_management->get_lead_list($lead_type, $status, $request_by, $lead_contact_type);
//        print_r($render_data["lead_list"]);
        $this->load->view("lead_management/ajax_dashboard", $render_data);
    }

    public function change_mail_campaign_status() {
        echo $this->lead_management->change_mail_campaign_status(post("service"), post("language"), post("status"));
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
        $result['element_array'] = $this->filter_element;
        $result['element_value_list'] = $this->lead_management->get_lead_filter_element_value($element_key, $office);
        $this->load->view('action/filter_dropdown_option_ajax', $result);
    }

    public function lead_filter() {
        $render_data["lead_list"] = $this->lead_management->get_lead_list('', '', '', '', post());
        $this->load->view("lead_management/ajax_dashboard", $render_data);
    }
    public function change_tracking_status() {
        echo $this->lead_management->change_tracking_status(post());        
    }
    public function assign_lead_as_client(){
        echo $this->lead_management->assign_lead_as_client(post('id'),post('partner_id'));
    }

}
