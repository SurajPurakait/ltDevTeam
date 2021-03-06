<?php

class Referral_partners extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("referral_partner");
        $this->load->model("service");
        $this->load->model("action_model");
        $this->load->model("system");
        $this->load->model("lead_management");
        $this->load->model('lead_management', "lm");
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    function partners($req_by = '', $stat = '', $type = '', $lead_type = '') {
        $this->load->layout = 'dashboard';
        $title = "Partners / All Partners";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'all_partners';
        $render_data['menu'] = 'partners';
        $render_data['stat'] = $stat;
        $render_data['type'] = $type;
        $render_data['req_by'] = $req_by;
        $render_data['lead_type'] = $lead_type;
        $render_data['header_title'] = $title;
        $render_data['referral_leads_count'] = $this->referral_partner->getReferralLeadsCount();
        $this->load->template('referral_partner/partner_dashboard', $render_data);
    }

    public function lead_dashboard() {
        $this->load->layout = 'dashboard';
        $title = "Refer a Lead";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'reffer_lead';
        $render_data['header_title'] = $title;
        $this->load->template('referral_partner/lead_dashboard', $render_data);
    }

    public function referral_partner_dashboard() {
        $this->load->layout = 'dashboard';
        $title = "Referral Partner Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'reffer_partner_dashboard';
        $render_data['header_title'] = $title;
        $this->load->template('referral_partner/referral_partner_dashboard', $render_data);
    }

    public function add_lead($partner_creator='') {
        $this->load->layout = 'dashboard';
        $title = "Create Lead";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'reffer_lead';
        $render_data['header_title'] = $title;
        $render_data["type_of_contact"] = $this->lm->get_lead_types();
        $render_data["lead_source"] = $this->lm->get_lead_sources();
        $render_data["lead_agents"] = $this->lm->get_lead_agents();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["languages"] = $this->system->get_languages();
        $render_data["partner_creator"] = $partner_creator;
        $this->load->template('referral_partner/create_lead', $render_data);
    }

    public function reffer_lead_to_partner($lead_id,$is_partner="") {
        $this->load->layout = 'dashboard';
        $title = "Reffer Lead To Partner";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'partners';
        $render_data['header_title'] = $title;
        $render_data['partner'] = $is_partner;
        $render_data["type_of_contact"] = $this->lm->get_lead_types();
        $render_data["type_of_leads"] = $this->lm->get_lead_type_for_mail();
        $render_data["lead_source"] = $this->lm->get_lead_sources();
        $render_data["lead_agents"] = $this->lm->get_lead_agents();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["languages"] = $this->system->get_languages();
        $ref_partner_id = $this->lm->get_ref_partner_id($lead_id);
        $render_data['ref_partner_id'] = $ref_partner_id;
        $this->load->template('referral_partner/reffer_lead_to_partner', $render_data);
    }

    function load_partner_dashboard() { // ajax_dashboard_referral
        $lead_type = post("lead_type");
        $request_by = post('req_by');
        $status = post("status");
        $lead_contact_type = post("lead_contact_type");
        $render_data['referral_data'] = $this->referral_partner->getReferralPartnerData($request_by);
        $this->load->view('referral_partner/load_referral_partner_data', $render_data);
    }

    function load_referral_partners_dashboard() {
        $type = post('type');
        $status = post('status');
        // $render_data['referral_partner_data'] = $this->referral_partner->load_referral_partners_dashboard_data($type, $status);
        $render_data['referral_partner_data'] = $this->referral_partner->load_referral_partners_dashboard_data('',post());
        $this->load->view('referral_partner/load_referral_partners_dashboard_data', $render_data);
    }

    public function load_referred_leads_dashboard() {
        $status = post('status');
        $render_data['referred_lead_data'] = $this->referral_partner->load_referred_leads_dashboard_data($status);
        $this->load->view('referral_partner/load_referred_leads_dashboard_data', $render_data);
    }

    function load_partners_lead_dashboard() {
        $render_data['referral_data'] = $this->referral_partner->getReferralPartnerLeadData();
        $this->load->view('referral_partner/load_referral_partner_lead_data', $render_data);
    }

    public function updateNotes() {
        if (!empty(post('notes'))) {
            $this->load->model('Notes');
            $this->Notes->updateNotes(post(), post('notestable'));
            redirect(base_url() . 'referral_partner/referral_partners/partners');
        }
    }

    public function set_password() {
        $pwd = post('password');
        $hiddenid = post('hiddenid');
        $staffrequestedby = post('staffrequestedby');
        $referral_partner_data = $this->referral_partner->getReferralPartnerDatabyid($hiddenid);
        $this->referral_partner->set_password($referral_partner_data, $pwd,$staffrequestedby);
        
        // Sending email From Manager to Partner
//        $config = Array(
//           'protocol' => 'smtp',
//           'smtp_host' => 'ssl://smtp.gmail.com',
//           'smtp_port' => 465,
//           'smtp_user' => 'codetestml0016@gmail.com', // change it to yours
//           'smtp_pass' => 'codetestml0016@123', // change it to yours
//           'mailtype' => 'html',
//           'charset' => 'utf-8',
//           'wordwrap' => TRUE
//        );

         $config = Array(
                 //'protocol' => 'smtp',
                 'smtp_host' => 'mail.leafnet.us',
                 'smtp_port' => 465,
                 'smtp_user' => 'developer@leafnet.us', // change it to yours
                 'smtp_pass' => 'developer@123', // change it to yours
                 'mailtype' => 'html',
                 'charset' => 'utf-8',
                 'wordwrap' => TRUE
         );
        $partner_name = $referral_partner_data['first_name'].' '.$referral_partner_data['last_name'];
        $from = staff_info_by_id($staffrequestedby)['user'];
        $from_name_details = staff_info_by_id($staffrequestedby);
        $from_name = $from_name_details['first_name'] .'  '.$from_name_details['last_name'];
        $email_subject = 'Taxleaf Partnership Account';
        $user_email = $referral_partner_data['email'];
        
        $user_logo = "";
        if ($referral_partner_data['office'] != 0) {
            $user_logo = get_user_logo($referral_partner_data['office']);
        }

        if ($user_logo != "" && !file_exists('https://leafnet.us/uploads/' . $user_logo)) {
            $user_logo_fullpath = 'https://leafnet.us/uploads/' . $user_logo;
        } else {
            $user_logo_fullpath = 'https://leafnet.us/assets/img/logo.png';
        }
        $user_logo_default = 'https://leafnet.us/assets/img/logo.png';
        if ($referral_partner_data['office'] == 1 || $referral_partner_data['office'] == 18 || $referral_partner_data['office'] == 34) {
            $bgcolor = '#00aec8';
            $divider_img = 'https://leafnet.us/assets/img/divider-blue.jpg';
            $divider_style = 'background:#00aec8;height:10px;';
        } else {
            $bgcolor = '#8ab645';
            $divider_img = 'http://www.taxleaf.com/Email/divider2.gif';
            $divider_style = 'background:#8ab645;height:10px;';
        }
        $chat_link = 'https://www.websitealive3.com/12709/operator/guest/gDefault_v2.asp?cframe=login&chattype=mobile&groupid=12709&websiteid=783&departmentid=15447&sessionid_=&iniframe=&ppc_id=&autostart=&proactiveid=&req_router_type=&text2chat_info=&loginname=&loginnamelast=&loginemail=&loginphone=&infocapture_ids=&infocapture_values=&dl=&loginquestion=';
        $url_link = 'https://leafnet.us/';
        $mail_body ='<td style="padding: 0px">
                        <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="text-align: left;">
                                    <h3 style="padding-bottom: 10px;">Hello '.$partner_name.',</h3>
                                    <p style="margin-bottom: 0;">Welcome to Leafnet.</p>
                                    <p style="margin-bottom: 0; margin-top: 5px;">You have access to a new portal.</p>
                                    <p style="padding-top: 0px; font-size: 16px; color: #06a0d6; font-weight: 600;">Login Credentials</p>
                                </td>
                            </tr>
                        </table>
                        <table style="text-align: left; width:100%;" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="text-align: left;">
                                    <p style="margin-bottom: 5px; margin-top: 0; "><span style="color: #06a0d6; font-weight: 600; width: 200px;">Username </span>:&nbsp; '.$referral_partner_data['email'].'</p> 
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">
                                    <p style="margin-bottom: 0px; margin-top: 0; "><span style="color: #06a0d6; font-weight: 600; width: 200px;">Password  </span>:&nbsp; '.$pwd.'</p>
                                </td>
                            </tr>
                        </table>
                        <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="text-align: left;">
                                    <p style="padding-top: 20px;"><a style="color: #0990bf; text-decoration: none; font-weight: 600;" href="http://leafnet.us/" target="_blank">Login Here!</a></p>
                                    <h3 style="padding-bottom: 20px;">Thank you</h3>
                                </td>
                            </tr>
                        </table>
                    </td>';
        $message = 
            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>TAXLEAF</title>
                    <style type="text/css">
                        body {
                            background-color: #FFFFFF;
                            margin-left: 0px;
                            margin-top: 0px;
                            margin-right: 0px;
                            margin-bottom: 0px;
                        }
                        .textoblanco {
                            font-family: Arial, Helvetica, sans-serif;
                            font-size: 12px;
                            color: #000;
                        }
                        .textoblanco {
                            font-family: Arial, Helvetica, sans-serif;
                            font-size: 12px;
                            color: #FFF;
                        }
                        .textonegro {
                            font-family: Arial, Helvetica, sans-serif;
                            font-size: 12px;
                            color: #000;
                        }
                        </style>
                </head>
                <body>
                    <br/>
                    <table width="600" border="0" bgcolor="' . $bgcolor . '" cellpadding="0" cellspacing="10">
                        <tr>
                            <td>
                                <table width="600" border="0" cellpadding="0" cellspacing="0">
                                    <tr style="background: #fff;">
                                        <td style="padding: 25px 20px;">
                                            <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="text-align: left; width: 200px;">
                                                        <a href="http://leafnet.us/" target="_blank"><img src="' . $user_logo_fullpath . '" alt="site-logo" style="width:150px"></a>
                                                    </td>
                                                    <td style="text-align: right; width: 200px;">
                                                        <a href="http://leafnet.us/" target="_blank"><img src="' .$user_logo_default. '" alt="site-logo" style="width:150px"></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="'.$divider_style.'"></td>
                                    </tr>
                                </table>
                                <table width="600" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="15">
                                    ' . $mail_body . '
                                </table>          
                                <table width="600" border="0" cellpadding="0" cellspacing="0"></table>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                                    <tr style="background: transparent; height: 60px;">
                                        <td style="text-align: center;">
                                            <a href="https://leafnet.us/" style="text-transform: uppercase; text-decoration: none; color: #00aec8; background:#fff; padding: 6px 8px; display: inline-block;">Home</a>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="https://leafnet.us/" style="text-transform: uppercase; text-decoration: none; color: #00aec8; background:#fff; padding: 6px 8px; display: inline-block;">Services</a>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="'. $chat_link .'" style="text-transform: uppercase; text-decoration: none; color: #00aec8; background:#fff; padding: 6px 8px; display: inline-block;">Chat</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br/>
                </body>
            </html>';

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($from, $from_name); // change it to yours
        $this->email->reply_to($from, $from_name);
        $this->email->to($user_email); // change it to yours
        $this->email->subject($email_subject);
        $this->email->message($message);
        $this->email->send();

        redirect(base_url() . 'referral_partner/referral_partners/partners');
    }

    public function load_assign_container() {
        $select_type = post('select_type');
        $edit_mode = post('edit_mode');
        $userinfo = staff_info();
        if ($select_type == '1') {
            $render_data['reference'] = 'company';
            $render_data['completed_orders'] = $this->service->completed_orders();
        } else {
            $render_data['reference'] = 'individual';
        }
        $this->load->view('referral_partner/assign_container_ajax', $render_data);
    }

    public function assign_client() {
        if ($this->referral_partner->assign_client(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function assign_lead() {
        $lead_id = post('lead_id');
        if ($this->referral_partner->assign_lead($lead_id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function new_referral_agent() {
        $this->load->layout = 'dashboard';
        $title = "Create Referral Partner";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'reffer_lead';
        $render_data['header_title'] = $title;
        $render_data["type_of_contact"] = $this->lm->get_lead_referral();
        $render_data["lead_source"] = $this->lm->get_lead_sources();
        $render_data["lead_agents"] = $this->lm->get_lead_agents();
        $render_data["client_list"] = $this->lm->get_clients();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["languages"] = $this->system->get_languages();
        $this->load->template('referral_partner/create_referral_partner', $render_data);
    }

    public function edit_referral_agent($id) {
        $render_data["data"] = $this->lm->fetch_data($id);
        $render_data["data"]["notes"] = explode(",", $render_data["data"]["notes"]);
        $render_data["type_of_contact"] = $this->lm->get_lead_referral();
        $render_data["lead_source"] = $this->lm->get_lead_sources();
        $render_data["lead_agents"] = $this->lm->get_lead_agents();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["languages"] = $this->system->get_languages();
        $this->load->layout = 'dashboard';
        $title = "Edit Referral Partner";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'reffer_lead';
        $render_data['header_title'] = $title;
        $this->load->template("referral_partner/edit_referral_partner", $render_data);
    }

    public function leads_ref_by_refpartner_dashboard($status = '4', $request_type = '', $lead_type = '') {
        $this->load->layout = 'dashboard';
        $title = "Leads Referred By Referral Partners";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'leads_ref_by_refpartner_dashboard';
        $render_data['header_title'] = $title;
        $render_data['status'] = $status;
        $render_data['request_type'] = $request_type;
        $render_data['lead_type'] = $lead_type;
        $this->load->template('referral_partner/leads_ref_by_refpartner_dashboard', $render_data);
    }

    public function load_lead_ref_by_refpartner_dashboard() {
        $render_data['lead_data'] = $this->referral_partner->getLeadDataByRefPartner(post('by'), post('status'), post('lead_type'));
        $this->load->view('referral_partner/load_lead_ref_by_refpartner_data', $render_data);
    }

    public function refferred_leads() {
        $this->load->layout = 'dashboard';
        $title = "Referred Lead Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'refferred_leads_dashboard';
        $render_data['header_title'] = $title;
        $this->load->template('referral_partner/referred_lead_dashboard', $render_data);
    }

    public function update_leads_by_refPartnerNotes() {
        if (isset($_POST['notes']) && !empty($_POST['notes'])) {
            $this->load->model('Notes');
            $this->Notes->updateNotes($_POST, $_POST['notestable']);
            redirect(base_url() . 'referral_partner/referral_partners/leads_ref_by_refpartner_dashboard');
        }
    }

    public function addNotesmodal_leads_by_refPartner() {
        $data = $this->input->post();
        $this->load->model('Notes');
        if (!empty($data['referral_partner_note'][0])) {
            $this->Notes->insert_note(3, $data['referral_partner_note'], "lead_id", $data['lead_id']);
        }
        redirect(base_url() . 'referral_partner/referral_partners/leads_ref_by_refpartner_dashboard');
    }

    public function addNotesmodal_dashboard_partners() {
        $data = $this->input->post();
        $this->load->model('Notes');
        if (!empty($data['referral_partner_note'][0])) {
            $this->Notes->insert_note(3, $data['referral_partner_note'], "lead_id", $data['lead_id']);
        }
        redirect(base_url() . 'referral_partner/referral_partners/referral_partner_dashboard');
    }

    public function addNotesmodal_dashboard_for_lead() {
        $data = $this->input->post();
        $this->load->model('Notes');
        if (!empty($data['referral_partner_note'][0])) {
            $this->Notes->insert_note(3, $data['referral_partner_note'], "lead_id", $data['lead_id']);
        }
        redirect(base_url() . 'referral_partner/referral_partners/lead_dashboard');
    }

    public function addRefPartnerClientNotes() {
        $data = $this->input->post();
        if (!empty($data['referral_partner_note'][0])) {
            $this->referral_partner->addRefPartnerClientNotes($data);
        }
        redirect(base_url() . 'referral_partner/referral_partners/partners');
    }

    public function edit_lead_prospect($id) {
        $render_data["data"] = $this->lm->fetch_data($id);
        $render_data["data"]["notes"] = explode(",", $render_data["data"]["notes"]);
        $render_data["type_of_contact"] = $this->lm->get_lead_types();
        $render_data["lead_source"] = $this->lm->get_lead_sources();
        $render_data["lead_agents"] = $this->lm->get_lead_agents();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["languages"] = $this->system->get_languages();
        $this->load->layout = 'dashboard';
        $title = "Edit Prospect";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'reffer_partner_dashboard';
        $render_data['header_title'] = $title;
        $render_data['from_menu'] = 'referral';
        $render_data['ref_cancel'] = 'ref_cancel';
        $this->load->template("lead_management/edit_prospect", $render_data);
    }

    public function view_leads($id = '', $assigned_client_id = '') {
        $this->load->layout = 'dashboard';
        $title = "View Leads";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'leads_ref_by_refpartner_dashboard';
        $render_data['header_title'] = $title;
        $render_data["data"] = $this->lm->view_leads_record($id);
//        print_r($render_data["data"]);die;
        $render_data["client_name"] = $this->lm->get_client_name($render_data["data"]["lead_agent"]);
        if ($render_data["data"]['type'] == 1) {
            $render_data["contact"] = $this->lm->get_type_of_contact_by_id($render_data['data']['type_of_contact']);
        } else {
            $render_data["contact"] = $this->lm->get_type_of_contact_referral_by_id($render_data['data']['type_of_contact']);
        }
        $render_data["state"] = $this->lm->get_state_by_id($render_data['data']['state']);
        $render_data["notes"] = $this->lm->get_notes_by_lead_id($render_data['data']['id']);
        $render_data["prospect"] = $this->lm->get_lead_source_by_id($render_data['data']['lead_source']);
        $render_data["language"] = $this->lm->get_language_by_id($render_data['data']['language']);
        $render_data['partner_showhide'] = '1';
        $render_data['assigned_client_id'] = $assigned_client_id;
        $render_data["tracking_logs"] = $this->lead_management->get_tracking_log($render_data['data']['id'], "lead_management");
        $this->load->template("lead_management/view_lead_management", $render_data);
    }

    public function view_referral($id = '') {
        $this->load->layout = 'dashboard';
        $title = "View Referral Partner";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'partners';
        $render_data['header_title'] = $title;
        $render_data["data"] = $this->lm->view_leads_record($id);
//        print_r($render_data["data"]);die;
        $render_data["client_name"] = $this->lm->get_client_name($render_data["data"]["lead_agent"]);
        if ($render_data["data"]['type'] == 1) {
            $render_data["contact"] = $this->lm->get_type_of_contact_by_id($render_data['data']['type_of_contact']);
        } else {
            $render_data["contact"] = $this->lm->get_type_of_contact_referral_by_id($render_data['data']['type_of_contact']);
        }
        $render_data["state"] = $this->lm->get_state_by_id($render_data['data']['state']);
        $render_data["notes"] = $this->lm->get_notes_by_lead_id($render_data['data']['id']);
        $render_data["prospect"] = $this->lm->get_lead_source_by_id($render_data['data']['lead_source']);
        $render_data["language"] = $this->lm->get_language_by_id($render_data['data']['language']);
        $render_data["partner_showhide"] = '';
        $render_data['assigned_client_id'] = '';
        $render_data["tracking_logs"] = $this->lead_management->get_tracking_log($render_data['data']['id'], "lead_management");
        $this->load->template("lead_management/view_lead_management", $render_data);
    }

    public function get_filter_dropdown_options() {
        $resultval['val'] = post('val');
        $this->load->view('referral_partner/filter_options', $resultval);
    }

    public function filter_form() {
        $req_by = '';
        $render_data['referral_data'] = $this->referral_partner->getReferralPartnerData($req_by, post());
        $this->load->view('referral_partner/load_referral_partner_data', $render_data);
    }

    public function delete_reffererd_lead(){
        $id = $_POST['id'];
        $assigned_client_id = $_POST['assigned_client_id'];
        $result = $this->referral_partner->delete_reffererd_leads($id,$assigned_client_id);
        if ($result == 1)
        {    
            echo "1";
        } else {
            echo "0";
        }
    }


    public function delete_referral_partner(){
        $id = $_POST['id'];
        $result = $this->referral_partner->delete_referral_partners($id);
        if ($result == 1){    
            echo "1";
        } else {
            echo "0";
        }
    }

    public function is_staff() {
        echo $this->referral_partner->is_staff_check(post());
    }

}
