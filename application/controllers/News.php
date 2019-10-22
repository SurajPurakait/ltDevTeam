<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('system');
        $this->load->model('News_Update_model');
        $this->load->model('action_model');
        $this->load->model("administration");
        $user_info = staff_info();
//        print_r($user_info);
//        exit;

        if ($user_info['type'] == 2) {
            $this->filter_element = [
                5 => "Create Date",
                3 => "Department",
                1 => "Priority",
                2 => "Type",
            ];
        }elseif($user_info['type'] == 3){
            $this->filter_element = [
                5 => "Create Date",
                4 => "Office",
                1 => "Priority",
                2 => "Type",
            ];
        }else{
            $this->filter_element = [
                5 => "Create Date",
                3 => "Department",
                4 => "Office",
                1 => "Priority",
                2 => "Type",
            ];
        }
        
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "News and Updates";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'news';
        $render_data['menu'] = 'news';
        $render_data['header_title'] = $title;
        $render_data['filter_element_list'] = $this->filter_element;

//        print_r($render_data['office_type']);exit;

        $this->load->template('newsandupdates/news', $render_data);
    }

    public function request_create_newsandupdate() {
        echo $this->News_Update_model->add_newsandupdate($this->input->post());
    }

    public function request_save_newsandupdate() {
        echo $this->News_Update_model->save_newsandupdate($this->input->post());
    }

    public function get_dept_office_dd() {
//        echo post('type_val');exit;
        $type_val = post('type_val');

        $render_data["type_val"] = $type_val;
        if ($type_val == '1') {
            $render_data["departments"] = $this->action_model->get_corp_departments();
        } elseif ($type_val == '2') {

            $render_data["departments"] = $this->action_model->get_office_by_department_id($type_val);
        }

        $this->load->view('newsandupdates/get_dept_office_dd', $render_data);
    }

    public function dashboard_ajax() {
        //print_r($_POST);exit;
        $render_data = [];
        $render_data['news'] = '';
        $render_data['update'] = '';
        $render_data['filter'] = '';
        $filter['variable_dropdown'] = [];
        $filter['condition_dropdown'] = [];
        $filter['criteria_dropdown'] = [];

        if (!empty(post('variable_dropdown'))) {
            $filter['variable_dropdown'] = post('variable_dropdown');
        }
        if (!empty(post('condition_dropdown'))) {
            $filter['condition_dropdown'] = post('condition_dropdown');
        }
        if (!empty(post('criteria_dropdown'))) {
            $filter['criteria_dropdown'] = post('criteria_dropdown');
        }
//        $filter['news'] = '';
//        $filter['update'] = '';
//        if (post('filter') != '' && post('filter') == 1) {
//            $filter['news'] = post('news');
//            $filter['update'] = post('update');
//
//            $render_data['news'] = $filter['news'];
//            $render_data['update'] = $filter['update'];
//            $render_data['filter'] = post('filter');
//        }

        if (sess('user_type') == 1) {
            $render_data["news_update_list"] = $this->News_Update_model->get_news_update_list(null, $filter, 'dashboard');
        } else {
            $render_data["news_update_list"] = $this->News_Update_model->get_news_update_list(sess('user_id'), $filter, 'dashboard');
        }
//        print_r($render_data["news_update_list"]);exit;
        if (sess('user_type') == 1) {
            $return["result"] = $this->load->view("newsandupdates/ajax_dashboard", $render_data, true);
        } else {
            $return["result"] = $this->load->view("newsandupdates/ajax_dashboard_staff", $render_data, true);
        }
        echo json_encode($return);
    }

    public function filter_dropdown_option_ajax() {
//        print_r(post());
//        exit;
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
        $result['element_value_list'] = $this->News_Update_model->get_action_filter_element_value($element_key, $office);

        $this->load->view('action/filter_dropdown_option_ajax', $result);
    }

    public function update_read() {
        if (post('user_id') != '' && post('news_id') != '') {
            echo $this->News_Update_model->update_read(post('user_id'), post('news_id'));
        } 
    }

    public function delete_news_update() {

        if (post('user_id') != '' && post('news_id') != '') {
            echo $this->News_Update_model->delete_news_update(post('user_id'), post('news_id'));
        } else {
            echo '-1';
        }
    }

    public function delete_news_admin() {

        if (post('news_id') != '') {
            echo $this->News_Update_model->delete_news_admin(post('news_id'));
        } else {
            echo '-1';
        }
    }

    public function delete_news_notification_admin() {

        if (post('news_id') != '') {
            echo $this->News_Update_model->delete_news_notification_admin(post('news_id'));
        } else {
            echo '-1';
        }
    }

    public function delete_news_notification() {

        if (post('news_id') != '') {
            echo $this->News_Update_model->delete_news_notification(post('news_id'), post('user_id'));
        } else {
            echo '-1';
        }
    }

    // public function news_filter() {
        
    // }

    public function show_read_or_unread_users() {
        $news_id = post('news_id');
        $render_data['read_assigned_list'] = $this->News_Update_model->get_news_view_count($news_id);
        $render_data['total_assigned_list'] = $this->News_Update_model->get_all_assigened_staff_news($news_id);
        $this->load->view('modal/user_list_status_news', $render_data);   
    }
}
