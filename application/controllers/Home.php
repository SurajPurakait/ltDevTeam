<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('administration');
        $this->load->model('service_model');
        $this->load->model('system');
        $this->load->model('action_model');
        $this->load->model('billing_model');
        $this->load->model('lead_management');
        $this->load->model('referral_partner');
        $this->load->model('News_Update_model');
    }

    public function index() {
        if ($this->session->userdata('user_id') && $this->session->userdata('user_id') != '') {
            redirect(base_url() . "home/dashboard");
        }
        $this->load->layout = 'login';
        $this->load->template('login');
    }

    public function checkssn() {
        $ssn_no = $this->input->post('ssn_no');
        $user_id = $this->input->post('user_id');
        $err = "";
        if ($ssn_no == "") {
            $this->session->set_flashdata('ssn_no_error', '<div class="text-danger">SSN can not be blank</div>');
            $err = "error";
        }
        if ($ssn_no != "" && strlen($ssn_no) != "6") {
            $this->session->set_flashdata('ssn_digit_error', '<div class="text-danger">Please Input Last Six Digit Only</div>');
            $err = "error";
        }
        if ($err != "") {
            redirect(base_url() . 'home/ssn_security_check/' . base64_encode($user_id));
        }
        $ssn_authentication = $this->system->ssn_authentication($user_id);
        $saved_ssn = $ssn_authentication['ssn_itin'];
        if (trim($saved_ssn) == '') {
            $this->session->set_flashdata('ssn_blank_error', '<div class="text-danger">Social Security Number is blank</div>');
            redirect(base_url() . 'home/ssn_security_check/' . base64_encode($user_id));
        } else {
            $last_six_ssn_digit = substr(trim($saved_ssn), -6);
            if ($last_six_ssn_digit == trim($ssn_no)) {
                $this->system->set_user_session($user_id);
                redirect(base_url() . 'home/dashboard');
            } else {
                $this->session->set_flashdata('ssn_invalid_error', '<div class="text-danger">Social Security Number is invalid</div>');
                redirect(base_url() . 'home/ssn_security_check/' . base64_encode($user_id));
            }
        }
    }

    public function updatessn() {
        $ssn_no = $this->input->post('ssn_no');
        $user_id = $this->input->post('user_id');
        $err = "";
        if ($ssn_no == "") {
            $this->session->set_flashdata('ssn_no_error', '<div class="text-danger">SSN can not be blank</div>');
            $err = "error";
        }
        $real_ssn = str_replace("-", "", $ssn_no);
        if ($ssn_no != "" && strlen($real_ssn) != "9") {
            $this->session->set_flashdata('ssn_digit_error', '<div class="text-danger">SSN must be of Nine digits</div>');
            $err = "error";
        }
        if ($err != "") {
            $this->session->set_flashdata('ssn_blank_error', 'blank_error');
            redirect(base_url() . 'home/ssn_security_check/' . base64_encode($user_id));
        }
        $this->system->updatessn($real_ssn, $user_id);
        $this->system->set_user_session($user_id);
        redirect(base_url() . 'home/dashboard');
    }

    public function checkpost() {
        if ($this->input->post('login')) {
            $user_post = $this->input->post('login');
            $err = "";
            if ($user_post['user'] == "") {
                $this->session->set_flashdata('username_error', '<div class="text-danger">Username can not be blank</div>');
                $err = "error";
            }
            if ($user_post['password'] == "") {
                $this->session->set_flashdata('password_error', '<div class="text-danger">Password can not be blank</div>');
                $err = "error";
            }
            if ($err != "") {
                redirect(base_url());
            }
            $user_post['password'] = md5($user_post['password']);
            if ($this->system->authentication($user_post)) {
                $val = $this->system->authentication($user_post);
                if ($val['user_type'] == 4) {
                    $this->system->set_user_session($val['user_id']);
                    redirect(base_url() . 'referral_partner/referral_partners/referral_partner_dashboard');
                } else {
                    $user_info = staff_info_by_id($val['user_id']);
                    $id = base64_encode($val['user_id']);
                    if ($val['user_type'] != 1 && $user_info['date'] != '0000-00-00') {
                        //$id = $user_info['id'];
                        $date = date('Y-m-d');
                        $start_date = explode('-', $user_info['date']);
                        $end_date = explode("-", $date);
                        $start_date = date_create($start_date[0] . "-" . $start_date[1] . "-" . $start_date[2]);
                        $end_date = date_create($end_date[0] . "-" . $end_date[1] . "-" . $end_date[2]);
                        $diff = date_diff($start_date, $end_date);
                        $df = explode(" ", $diff->format("%R %y %m %d"));
                        if ($df[0] == "+") {
                            $d = (($df[1] * 360) + ($df[2] * 30) + $df[3]);
                            if ($d > 90) {
                                //$id = base64_encode($id);
                                redirect(base_url() . 'home/chnage_password/' . $id);
                            } else {
                                //redirect(base_url() . 'home/dashboard');
                                redirect(base_url() . 'home/ssn_security_check/' . $id);
                            }
                        }
                    } else {
                        //redirect(base_url() . 'home/dashboard');
                        redirect(base_url() . 'home/ssn_security_check/' . $id);
                    }
                }
            } else {
                $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Wrong username or password</div>');
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }

    public function logout() {
        if ($this->session->userdata('user_id') && $this->session->userdata('user_id') != '') {
            $this->system->log('logout', 'staff', $this->session->userdata('user_id'));
            $this->session->unset_userdata(['user_id', 'user_office_id', 'security_level', 'login']);
            $this->session->sess_destroy();
        }
        redirect(base_url());
    }

    public function dashboard() {
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->layout = 'dashboard';
        $title = "Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'dashboard';
        $render_data['menu'] = 'dashboard';
        $render_data['header_title'] = $title;
        $render_data['corporate_office_list'] = $this->administration->get_office_list_by_type(1);
        $render_data['office_list'] = $this->administration->get_all_office();
        $render_data['department_list'] = $this->administration->get_all_departments([1, 3]);
        $render_data["lead_type_list"] = $this->lead_management->get_lead_types();
        $this->load->template('dashboard', $render_data);
    }

    public function upload_file() {
        $file_name = $this->input->post('file_name');
        $res = common_upload($file_name);
        echo json_encode($res);
    }

    public function change_profile_picture() {
        $imgurl = post('imgurl');
        echo $this->system->change_profile_picture($imgurl);
    }

    public function view_profile() {
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->layout = 'dashboard';
        $title = "View Profile";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'dashboard';
        $render_data['menu'] = 'dashboard';
        $render_data['header_title'] = $title;
        $this->load->template('view_profile', $render_data);
    }

    public function delete_note() {
        $this->load->model('notes');
        if ($this->notes->delete_note($this->input->post('note_id'), $this->input->post('related_table_id'))) {
            echo 1;
        }
    }

    public function forgot_password() {
        $this->load->layout = 'login';
        $this->load->template("forgot_password");
    }

    public function change_password_new($id = "") {
        if ($this->input->post('change_password')) {
            $change_password = $this->input->post('change_password');
            $temp = $this->system->get_user_date(base64_decode($id));
            $password = $temp['password'];
            $old_password = md5($change_password['old_password']);
            $new_password = md5($change_password['new_password']);
            $retype_password = md5($change_password['retype_password']);
            $err = "";
            if ($old_password == "") {
                $this->session->set_flashdata('old_password_error', '<div class="text-danger">Password can not be blank</div>');
                $err = "error";
            } elseif ($password != $old_password) {
                $this->session->set_flashdata('old_password_error', '<div class="text-danger">Old Password mismatch</div>');
                $err = "error";
            }
            if ($new_password == "") {
                $this->session->set_flashdata('new_password_error', '<div class="text-danger">Password can not be blank</div>');
                $err = "error";
            }

            if ($retype_password == "") {
                $this->session->set_flashdata('retype_password_error', '<div class="text-danger">Retype Password can not be blank</div>');
                $err = "error";
            }
            if ($new_password != $retype_password) {
                $this->session->set_flashdata('retype_password_error', '<div class="text-danger">Retype Password mismatch</div>');
                $err = "error";
            }
            if ($err != "") {
                redirect(base_url('home/chnage_password'));
            }
            if ($new_password == $retype_password) {
                $final = $this->system->update_password($id, $change_password['new_password']);
                if ($final) {
                    $this->session->sess_destroy();
                    redirect(base_url());
                }
            } else {
                $this->session->set_flashdata('update_password_error', '<div class="alert alert-danger">Password Mismatch</div>');
                redirect(base_url('home/new_password/' . $id));
            }
        } else {
            redirect(base_url('home/chnage_password'));
        }
    }

    public function check_username() {

        if ($this->input->post('forgot_password')) {
            $user_post = $this->input->post('forgot_password');
            $err = "";
            if ($user_post['user'] == "") {
                $this->session->set_flashdata('username_error', '<div class="text-danger">Username can not be blank</div>');
                $err = "error";
            }

            if ($err != "") {
                redirect(base_url('home/forgot_password'));
            }

            if ($this->system->check_user($user_post)) {
                $val = $this->system->check_user($user_post);
                if ($val != 0) {
                    $id = $val['id'];
                    $to_mail = $val['user'];
                    $subject = "Forgot Password";
                    $url = base_url() . 'home/new_password/' . base64_encode($id);
                    $message = "<a href='" . $url . "'>Click Here</a>";
                    $mail = compose_mail($to_mail, $subject, $message);
                    redirect(base_url());
                } else {
                    $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Wrong username</div>');
                    $err = "error";
                }
            } else {
                redirect(base_url('home/forgot_password'));
            }
        } else {
            redirect(base_url());
        }
    }

    public function new_password($id = "") {
        $array = [
            'id' => $id
        ];
        $this->load->layout = 'login';
        $this->load->template("new_password", $array);
    }

    public function chnage_password($id = "") {
        $array = [
            'id' => $id
        ];
        $this->load->layout = 'login';
        $this->load->template("chnage_password", $array);
    }

    public function ssn_security_check($id = "") {
        $idval = base64_decode($id);
        $array = [
            'id' => $idval
        ];
        $this->load->layout = 'login';
        $this->load->template("ssn_security_check", $array);
    }

    public function update_password($id = '') {
        $password = $this->input->post('password');
        $retype_password = $this->input->post('retype_password');
        $err = "";
        if ($password == "") {
            $this->session->set_flashdata('password_error', '<div class="text-danger">Password can not be blank</div>');
            $err = "error";
        }
        if ($retype_password == "") {
            $this->session->set_flashdata('retype_password_error', '<div class="text-danger">Retype Password can not be blank</div>');
            $err = "error";
        }
        if ($err != "") {
            redirect(base_url('home/new_password/' . $id));
        }
        if ($password == $retype_password) {
            $final = $this->system->update_password($id, $password);
            if ($final == 1) {
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('update_password_error', '<div class="alert alert-danger">Password Mismatch</div>');
            redirect(base_url('home/new_password/' . $id));
        }
    }

    public function addSos() {
        $res = $this->system->insert_sos(post());
        if (post('reference') == 'order') {
            //redirect(base_url('services/home'));
            echo $res;
        } else {
            echo $res;
        }
    }

    public function replySos() {
        $this->system->reply_sos(post());
        if (post('reference') == 'order') {
            redirect(base_url('services/home'));
        } else {
            echo '1';
        }
    }

    public function home_dashboard_ajax() {
        $data = post();
        //print_r($data);exit;
        $user_info = staff_info();
        $user_type = $user_info['type'];
        $role = $user_info['role'];
        $user_department = $user_info['department'];
        $section_array = explode(',', $data['section']);
        $json_data = [];
        if (in_array('action', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'action';
            $data['request_type_list'][] = ['request' => 'byme', 'request_name' => 'By Me'];
            $data['request_type_list'][] = ['request' => 'tome', 'request_name' => 'To Me'];
            if ($user_type == 1 || ($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2) || $user_department == 14):
                $data['request_type_list'][] = ['request' => 'byother', 'request_name' => 'By Other'];
            endif;
            if (($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)):
                $data['request_type_list'][] = ['request' => 'toother', 'request_name' => 'To Other'];
            endif;
            $data['request_type_list'][] = ['request' => 'mytask', 'request_name' => 'My Task'];
            $data['request_type_list'][] = ['request' => 'unassigned', 'request_name' => 'Unassigned'];
            $data['priority_list'] = [
                1 => 'urgent',
                2 => 'important',
                3 => 'regular'
            ];
            foreach ($data['request_type_list'] as $rtl) {
                foreach ($data['priority_list'] as $priority_index => $priority) {
                    $data["action"][$rtl['request']][$priority]['new'] = count($this->action_model->get_action_list($rtl['request'], 0, $priority_index, $data['office_id'], $data['department_id']));
                    $data["action"][$rtl['request']][$priority]['start'] = count($this->action_model->get_action_list($rtl['request'], 1, $priority_index, $data['office_id'], $data['department_id']));
                    $data["action"][$rtl['request']][$priority]['resolved'] = count($this->action_model->get_action_list($rtl['request'], 6, $priority_index, $data['office_id'], $data['department_id']));
                    // $data["action"][$rtl['request']][$priority]['complete'] = count($this->action_model->get_action_list($rtl['request'], 2, $priority_index, $data['office_id'], $data['department_id']));
                }
            }
            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }
        if (in_array('client', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'client';
            $data['client']['business'] = count($this->action_model->business_list($data['office_id']));
            $data['client']['individual'] = count($this->action_model->individual_list($data['office_id']));
            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }


        if (in_array('event', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'event';
            $data['event'] = count($this->lead_management->get_event_details($data['office_id']));
            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }


        if (in_array('service', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'service';
            $data['service_category_list'] = $this->service_model->get_service_category();
            foreach ($data['service_category_list'] as $key => $scl) {
                $category_name_array = explode(" ", $scl['name']);
                $index = strtolower($category_name_array[0]);
                $data['service_category_list'][$key]['category_name'] = $index;
                $data['service'][$index]['not_start'] = count($this->service_model->ajax_services_dashboard_filter(2, '', $scl['id'], '', '', $data['office_id']));
                $data['service'][$index]['start'] = count($this->service_model->ajax_services_dashboard_filter(1, '', $scl['id'], '', '', $data['office_id']));
                $data['service'][$index]['late'] = count($this->service_model->ajax_services_dashboard_filter(3, '', $scl['id'], '', '', $data['office_id']));
                $data['service'][$index]['total'] = count($this->service_model->ajax_services_dashboard_filter(4, '', $scl['id'], '', '', $data['office_id']));
            }
            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }
        if (in_array('billing', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'billing';

            $data['billing']['unpaid']['not_started'] = count($this->billing_model->billing_list(1, '', $data['office_id'], 1));
            $data['billing']['unpaid']['started'] = count($this->billing_model->billing_list(2, '', $data['office_id'], 1));
            $data['billing']['unpaid']['completed'] = count($this->billing_model->billing_list(3, '', $data['office_id'], 1));
            $data['billing']['unpaid']['total'] = ($data['billing']['unpaid']['not_started'] + $data['billing']['unpaid']['started'] + $data['billing']['unpaid']['completed']);

            $data['billing']['partial']['not_started'] = count($this->billing_model->billing_list(1, '', $data['office_id'], 2));
            $data['billing']['partial']['started'] = count($this->billing_model->billing_list(2, '', $data['office_id'], 2));
            $data['billing']['partial']['completed'] = count($this->billing_model->billing_list(3, '', $data['office_id'], 2));
            $data['billing']['partial']['total'] = ($data['billing']['partial']['not_started'] + $data['billing']['partial']['started'] + $data['billing']['partial']['completed']);

            $data['billing']['paid']['not_started'] = count($this->billing_model->billing_list(1, '', $data['office_id'], 3));
            $data['billing']['paid']['started'] = count($this->billing_model->billing_list(2, '', $data['office_id'], 3));
            $data['billing']['paid']['completed'] = count($this->billing_model->billing_list(3, '', $data['office_id'], 3));
            $data['billing']['paid']['total'] = ($data['billing']['paid']['not_started'] + $data['billing']['paid']['started'] + $data['billing']['paid']['completed']);

            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }
        if (in_array('lead', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'lead';
            $data['lead']['client_leads']['new'] = count($this->lead_management->get_lead_list(1, '0', '', $data['lead_type_id']));
            $data['lead']['client_leads']['active'] = count($this->lead_management->get_lead_list(1, 3, '', $data['lead_type_id']));
            $data['lead']['client_leads']['inactive'] = count($this->lead_management->get_lead_list(1, 2, '', $data['lead_type_id']));
            $data['lead']['client_leads']['total'] = count($this->lead_management->get_lead_list(1, '', '', $data['lead_type_id']));

            // $data['lead']['partner_leads']['new'] = count($this->lead_management->get_lead_list(2, '0', '', $data['lead_type_id']));
            // $data['lead']['partner_leads']['active'] = count($this->lead_management->get_lead_list(2, 3, '', $data['lead_type_id']));
            // $data['lead']['partner_leads']['inactive'] = count($this->lead_management->get_lead_list(2, 2, '', $data['lead_type_id']));
            // $data['lead']['partner_leads']['total'] = count($this->lead_management->get_lead_list(2, '', '', $data['lead_type_id']));

            
            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }
        if (in_array('partner', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'partner';
            $data['partner']['referred_to_me']['new'] = count($this->referral_partner->getLeadDataByRefPartner(1, '0', $data['lead_type_id']));
            $data['partner']['referred_to_me']['active'] = count($this->referral_partner->getLeadDataByRefPartner(1, 3, $data['lead_type_id']));
            $data['partner']['referred_to_me']['inactive'] = count($this->referral_partner->getLeadDataByRefPartner(1, 2, $data['lead_type_id']));
            $data['partner']['referred_to_me']['total'] = count($this->referral_partner->getLeadDataByRefPartner(1, '', $data['lead_type_id']));
            if ($user_type != 3 || $role == 2) {
                $data['partner']['referred_to_others']['new'] = count($this->referral_partner->getLeadDataByRefPartner(2, '0', $data['lead_type_id']));
                $data['partner']['referred_to_others']['active'] = count($this->referral_partner->getLeadDataByRefPartner(2, 3, $data['lead_type_id']));
                $data['partner']['referred_to_others']['inactive'] = count($this->referral_partner->getLeadDataByRefPartner(2, 2, $data['lead_type_id']));
                $data['partner']['referred_to_others']['total'] = count($this->referral_partner->getLeadDataByRefPartner(2, '', $data['lead_type_id']));
            }
            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }
        if (in_array('sos', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'sos';
            $data['sos_notification_list'] = $this->system->get_sos_notification_by_user_id($data['staff_id'], 10);
            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }
        if (in_array('notification', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'notification';
            $start = $data['start'];
            $json_data['section_index'][] = $data['notification_count'] = post('start_val');
            $data['general_notification_list'] = $this->system->get_general_notification_by_user_id($data['staff_id'], 5, '', $start);
            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }
        if (in_array('news_update', $section_array)) {
            $json_data['section_index'][] = $data['section'] = 'news_update';

            if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
                //$data["news_update_list"] = $this->News_Update_model->get_news_update_list('',[],'notification',$data['limit']);
                $data["news_update_list"] = $this->News_Update_model->get_news_update_list('', [], 'notification', 10);
            } else {
                //$data["news_update_list"] = $this->News_Update_model->get_news_update_list(sess('user_id'),[],'notification',$data['limit']);
                $data["news_update_list"] = $this->News_Update_model->get_news_update_list(sess('user_id'), [], 'notification', 10);
            }
            if ($data['is_clear'] != '' && ($user_type == 1 || ($user_type == 2 && $user_department == 14))) {
                $this->News_Update_model->clearNews_updateListAdmin(sess('user_id'));
            } else {
                $this->News_Update_model->clearNews_updateList(sess('user_id'));
            }
            $json_data['section'][] = $this->load->view("ajax_dashboard", $data, true);
        }
        echo json_encode($json_data);
    }

    public function load_ddl_option_ajax() {
        echo load_ddl_option(post('action'), post('selected'), post('service_id'));
    }

    public function update_profile() {
        $fname = post('fname');
        $lname = post('lname');
        $birth_date = post('birth_date');
        $phno = post('phno');
        $cell = post('cell');
        $extension = post('extension');
        $pwd = post('pwd');
        echo $this->system->update_profile($fname, $lname, $birth_date, $phno, $cell, $extension, $pwd);
    }

    public function read_notification() {
        $notification_id = post('notification_id');
        $reference = post('reference');
        if ($this->system->read_general_notification($notification_id, $reference)) {
            echo 1;
        } else {
            echo 0;
        }
//        echo get_action_notifications_count();
    }

    public function template() {
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->layout = 'dashboard';
        $title = "Project Template";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'dashboard';
        $render_data['menu'] = 'dashboard';
        $render_data['header_title'] = $title;
        $this->load->template('template', $render_data);
    }

    public function clear_sos_list() {
        $userid = post('userid');
        if ($this->system->clear_notification_list($userid, 'sos')) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function clear_notification_list() {
        $userid = post('userid');
        $reference = post('reference');
        if ($this->system->clear_notification_list($userid, 'notification', $reference)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function clear_news_update_list() {
        $userid = post('userid');
        if ($this->system->clear_notification_list($userid, 'news_update')) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function new_menu() {
        $title = "Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'dashboard';
        $render_data['menu'] = 'dashboard';
        $render_data['header_title'] = $title;
        $this->load->view('new_menu', $render_data);
    }

}
