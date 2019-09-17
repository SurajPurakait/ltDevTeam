<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_staff extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('administration');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Manage Staff";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'manage_staff';
        $render_data['header_title'] = $title;
        $render_data['staff_type'] = $this->administration->get_all_staff_type();
        $render_data['staff_depts'] = $this->administration->get_all_departments([3]);
        $render_data['staff_office'] = $this->administration->get_all_office();
        $render_data['staff_list'] = $this->administration->get_all_staff();
        $this->load->template('administration/manage_staff', $render_data);
    }

    public function office_department_staffwise_ajax() {
        $staff_type = $this->input->post("staff_type");
        $render_data['staff_type'] = $staff_type;
        $render_data['office_list'] = $this->administration->get_offices_staffwise($staff_type);
        $render_data['department_list'] = $this->administration->get_department_staffwise($staff_type);
        $this->load->view('administration/ajax_office_department_staffwise_div', $render_data);
    }

    public function update_staff() {
        $return['success'] = 1;
        $return['status_msg'] = '';
        $data = $this->input->post();
        foreach ($_FILES as $file_name => $file) {
            if ($file['name'] != '') {
                $upload_result = common_upload($file_name);
                if ($upload_result['success'] == 0) {
                    $return['success'] = 0;
                    $return['error_field'][] = [$file_name, $upload_result['status_msg']];
                } else {
                    $data[$file_name] = $upload_result['status_msg'];
                }
            }
        }
        $email_result = check_duplicate_field('staff', 'user', $data['user'], 'id', $data['id']);
        if ($email_result != 0) {
            $return['success'] = 0;
            $return['error_field'][] = ['user', 'Email already exist'];
        }
        if ($return['success'] == 1) {
            if (!$this->administration->update_staff($data)) {
                $return['success'] = 2;
            }
        }
        echo json_encode($return);
    }

    public function insert_staff() {
        $return['success'] = 1;
        $return['status_msg'] = '';
        $data = $this->input->post();
        foreach ($_FILES as $file_name => $file) {
            if ($file['name'] != '') {
                $upload_result = common_upload($file_name);
                if ($upload_result['success'] == 0) {
                    $return['success'] = 0;
                    $return['error_field'][] = [$file_name, $upload_result['status_msg']];
                } else {
                    $data[$file_name] = $upload_result['status_msg'];
                }
            }
        }
        $email_result = check_duplicate_field('staff', 'user', $data['user']);
        if ($email_result != 0) {
            $return['success'] = 0;
            $return['error_field'][] = ['user', 'Email already exist'];
        }
        unset($data['retype_password']);
        if ($return['success'] == 1) {
            if (!$this->administration->insert_staff($data)) {
                $return['success'] = 2;
            }
        }
        echo json_encode($return);
    }

    public function get_staff_relations($staff_id) {
        echo $this->administration->get_staff_relations($staff_id);
    }

    public function delete_staff() {
        $id = $this->input->post("staff_id");
        $result = $this->administration->delete_staff($id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function load_staff_data() {
        $ofc = request('ofc');
        $dept = request('dept');
        $type = request('type');
        $render_data['staff_list'] = $this->administration->get_all_staff_ajax($ofc, $dept, $type);
        $this->load->view('administration/manage_staff_ajax', $render_data);
    }

}
