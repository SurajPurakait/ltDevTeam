<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_mail extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('lead_management');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Lead Mail";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_mail';
        $render_data['header_title'] = $title;
        $render_data["lead_mail_content"] = $this->lead_management->get_lead_mail_content();
        $this->load->template('lead_management/lead_mail', $render_data);
    }

    public function add_new_mail() {
        $this->load->layout = 'dashboard';
        $title = "Add New Mail";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_mail';
        $render_data['header_title'] = $title;
        $this->load->template('lead_management/add_new_mail', $render_data);
    }

    public function edit_new_mail($id) {
        $this->load->layout = 'dashboard';
        $title = "Edit New Mail";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_mail';
        $render_data['header_title'] = $title;
        $render_data["edit_lead_mail_content"] = $this->lead_management->edit_lead_mail_content($id);
        $this->load->template('lead_management/edit_new_mail', $render_data);
    }

    public function copy_mail($id) {
        $this->load->layout = 'dashboard';
        $title = "Create Mail";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_mail';
        $render_data['header_title'] = $title;
        $render_data["edit_lead_mail_content"] = $this->lead_management->edit_lead_mail_content($id);
        $this->load->template('lead_management/copy_mail', $render_data);
    }

    public function insert_mail_content() {
        if ($this->input->post('email_id') == '') {
            echo $this->lead_management->insert_mail_content($this->input->post());
        } else {
            echo $this->lead_management->update_mail_content($this->input->post());
        }
    }

    public function lead_mail_campaign() {
        $this->load->model('system');
        $this->load->layout = 'dashboard';
        $title = "Mail Campaign";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_mail_campaign';
        $render_data['header_title'] = $title;
        // $render_data["type_of_contact"] = $this->lead_management->get_lead_types();
        $render_data["type_of_contact"] = $this->lead_management->get_lead_type_for_mail();
        $render_data["languages"] = $this->system->get_languages();
        $this->load->template('lead_management/lead_mail_campaign', $render_data);
    }

    public function edit_mail_campaign($id) {
        $this->load->model('system');
        $this->load->layout = 'dashboard';
        $title = "Edit Mail Campaign";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_mail_campaign';
        $render_data['header_title'] = $title;
        // $render_data["type_of_contact"] = $this->lead_management->get_lead_types();
        $render_data["type_of_contact"] = $this->lead_management->get_lead_type_for_mail();
        $render_data["languages"] = $this->system->get_languages();
        $render_data["edit_lead_mail_chain_content"] = $this->lead_management->edit_lead_mail_chain_content($id);
        $this->load->template('lead_management/edit_lead_mail_campaign', $render_data);
    }

    public function insert_mail_campaign_content() {
        if (post('email_id') == '') {
            echo $this->lead_management->insert_mail_campaign_content(post());
        } else {
            echo $this->lead_management->update_mail_campaign_content(post());
        }
    }

    public function delete_lead_mail() {
        $del_id = request('id');
        $result = $this->lead_management->delete_lead_mail($del_id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function add_mail_campaign() {
        $this->load->model('system');
        $this->load->layout = 'dashboard';
        $title = "Add Mail Campaign";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_mail_campaign';
        $render_data['header_title'] = $title;
        // $render_data["type_of_contact"] = $this->lead_management->get_lead_types();
        $render_data["type_of_contact"] = $this->lead_management->get_lead_type_for_mail();
        $render_data["languages"] = $this->system->get_languages();
        $this->load->template('lead_management/add_lead_mail_campaign', $render_data);
    }

    public function change_dropdown_options() {
        $this->load->model('system');
        // $service = request('service');
        $leadtype = request('leadtype');
        $language = request('language');
        $day = request('day');
        $ddval = request('ddval');
        // $check_if_mail_exists = $this->lead_management->check_if_mail_exists($service, $language, $day);
        $check_if_mail_exists = $this->lead_management->check_if_mail_exists($leadtype, $language, $day);
        //if(!empty($check_if_mail_exists)){
        $render_data['ddval'] = $ddval;
        $render_data['check_if_mail_exists'] = $check_if_mail_exists;
        // $render_data["type_of_contact"] = $this->lead_management->get_lead_types();
        $render_data["type_of_contact"] = $this->lead_management->get_lead_type_for_mail();
        $render_data["languages"] = $this->system->get_languages();
        // $render_data["service"] = $service;
        $render_data["leadtype"] = $leadtype;
        $render_data["language"] = $language;
        $render_data["day"] = $day;
        $this->load->view('lead_management/dropdown_options_ajax', $render_data);
        // }else{
        //     echo 0;
        // }
    }

    public function delete_mail_campaign() {
        $del_id = request('id');
        $result = $this->lead_management->delete_mail_campaign($del_id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function load_campaign_mails() {
        // $service = request('service');
        $leadtype = request('leadtype');
        $language = request('language');
        $day = request('day');
        $status = request('status');
        $render_data = request();
//        $render_data['lead_campaign_mails'] = $this->lead_management->lead_campaign_mails($service, $language, $day, $status);
        $render_data['main_title_array'] = $this->lead_management->lead_campaign_mails($leadtype, $language, $day, $status, 'main_title');
        $this->load->view('lead_management/campaign_mails_ajax', $render_data);
    }

    public function mail_campaign_template_ajax() {
        if (request('is_campaign') == 'y') {
            $lead_data = $this->lead_management->fetch_data(request('lead_id'));
            $day = request('day');
            // $service = $lead_data['type_of_contact'];
            $leadtype = $lead_data['type'];
            $language = $lead_data['language'];
            $contact_type = $this->lead_management->get_type_of_contact_by_id($leadtype);
            $lead_mail = $this->lead_management->lead_campaign_mails($leadtype, $language, $day);
            $added_by = staff_info_by_id($lead_data['staff_requested_by']);
            $user_details = staff_info();
            $lead_source = $this->lead_management->get_lead_source_by_id($lead_data["lead_source"]);
            if (!empty($lead_mail)) {
                $lead_mail = $lead_mail[0];
                // $veriable_array = [
                //     'name' => $lead_data['first_name'],
                //     'type' => $contact_type['name'],
                //     'company' => $lead_data['company_name'],
                //     'phone' => $lead_data['phone1'],
                //     'email' => $lead_data['email'],
                //     'requested_by' => $added_by['full_name']
                // ];
                $veriable_array = [
                    'name' => $lead_data['first_name'],
                    'type_of_contact' => $contact_type['name'],
                    'company_name' => $lead_data['company_name'],
                    'phone' => $lead_data['phone1'],
                    'email' => $lead_data['email'],
                    'staff_name' => $added_by['full_name'],
                    'staff_office' => staff_office_name(sess('user_id')),
                    'staff_phone' => $user_details['phone'],
                    'staff_email' => $user_details['user'],
                    'date_first_contact' => ($lead_data['date_of_first_contact'] != '0000-00-00') ? date('m/d/Y', strtotime($lead_data['date_of_first_contact'])) : '',
                    'lead_source' => $lead_source['name'],
                    'lead_source_detail' => $lead_data['lead_source_detail']
                ];
                $lead_mail['body'] = urldecode($lead_mail['body']);
                foreach ($veriable_array as $index => $value) {
                    if ($value != '') {
                        $lead_mail['body'] = str_replace('#' . $index, $value, $lead_mail['body']);
                        $lead_mail['subject'] = str_replace('#' . $index, $value, $lead_mail['subject']);
                    }
                }
                echo json_encode($lead_mail);
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }
    
    public function show_mail_campaign_template_ajax() {
        // $service = request('service');
        $leadtype = request('leadtype');
        $language = request('language');
        $day = request('day');
        $contact_type = $this->lead_management->get_type_of_contact_by_id($leadtype);
        $lead_mail = $this->lead_management->lead_campaign_mails($leadtype, $language, $day);
        // print_r($lead_mail);exit;
        // echo $lead_mail;exit;
        if (!empty($lead_mail)) {
            $lead_mail = $lead_mail[0];
            $veriable_array = [
                'name' => request('first_name'),
                'type' => $contact_type['name'],
                'company' => request('company_name'),
                'phone' => request('phone'),
                'email' => request('email')
            ];
            $lead_mail['body'] = urldecode($lead_mail['body']);
//            foreach ($veriable_array as $index => $value) {
//                if ($value != '') {
//                    $lead_mail['body'] = str_replace('#' . $index, $value, $lead_mail['body']);
//                }
//            }
            echo json_encode($lead_mail);
        } else {
            echo 0;
        }
    }

}
