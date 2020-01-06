<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('staff');
        $this->load->model('Project_Template_model');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Project Template";
        $render_data['title'] = $title . ' | Tax Leaf';
        // $render_data['main_menu'] = 'administration';
        $render_data['main_menu'] = 'project_dashboard';
        $render_data['menu'] = 'template';
        $render_data['header_title'] = $title;
        $render_data['project_list'] = $this->Project_Template_model->get_project_template_list();
//        $this->load->template('administration/project_template/template', $render_data);
        $this->load->template('administration/project_template/dashboard', $render_data);
    }

    public function create_template() {
        $this->load->model('Action_model');
        $this->load->layout = 'dashboard';
        $title = "Project Template";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'template';
        $render_data['header_title'] = $title;
        $render_data['service_category'] = $this->Project_Template_model->get_category();
        $render_data["departments"] = $this->action_model->get_departments();
        $render_data['office_list'] = $this->Project_Template_model->getOfficeList(2);
        $render_data['staff_type'] = $this->Project_Template_model->getStaffType();
        $render_data['template_category']=$this->Project_Template_model->getTemplateCategory();
//        print_r($render_data['office_list']);die;
//        $render_data["task_list"]=$this->Project_Template_model->project_template_task_list();
        $this->load->template('administration/project_template/template', $render_data);
    }

    public function get_service_list() {
        $render_data = [];
        $render_data['section'] = 'service';
        $render_data['select_sevice'] = post('select_service');
        $render_data['service_list'] = $this->Project_Template_model->get_service(post('category_id'));
        $this->load->view('administration/project_template/get_service_list', $render_data);
    }

    public function get_template_office_ajax() {
//        echo post('is_all');die;
        $this->load->model('Action_model');
        $department_id = post("department_id");
        $render_data["select_office"] = post("select_office");
        $render_data["department_id"] = $department_id;
        $render_data['select_staffs'] = post('select_staffs');
        $render_data['section'] = 'office';
        $render_data['is_all'] = post('is_all');
        $render_data["office_list"] = $this->action_model->get_office_by_department_id($department_id);
        $this->load->view('administration/project_template/get_service_list', $render_data);
    }

    public function get_template_office_ajax_new() {
//        echo post('is_all');die;
        $this->load->model('Action_model');
        $department_id = post("department_id");
        $render_data["ismyself"] = post("ismyself");
        $render_data["department_id"] = $department_id;
        $render_data['select_staffs'] = post('select_staffs');
        $render_data['section'] = 'office';
        $render_data['is_all'] = post('is_all');
        $render_data["dept_staff_list"] = $this->Project_Template_model->get_department_staff_by_department_id($department_id);
//        print_r($render_data["dept_staff_list"]);die;
        $this->load->view('administration/project_template/get_department_staff_list', $render_data);
    }

    public function get_template_office_staff_ajax() {
        $this->load->model('Action_model');
//        echo post("select_office");die;
        $render_data["ismyself"] = post("ismyself");
        $render_data["select_office"] = post("select_office");
        $render_data['select_staffs'] = post('select_staffs');
        $render_data['section'] = 'office_staff';
        $render_data['is_all'] = post('is_all');
        $render_data['partner'] = post('partner');
        $render_data['manager'] = post('manager');
        $render_data['associate'] = post('associate');
        $render_data["office_list"] = $this->Project_Template_model->get_office_staff_by_department_id(2, post("select_office"));
//        print_r($render_data["office_list"]);die;
        $this->load->view('administration/project_template/get_service_list_new', $render_data);
    }

    public function get_template_responsible_staff_ajax() {
        $this->load->model('Action_model');
        $department_id = post("user_type");
        $result["res_department"] = post("res_department");
        $result['res_staff'] = post('res_staff');
        $result['select_staff'] = post('select_staff');
        $result['is_all'] = post('is_all');
        $result['disabled'] = post('disabled');
        $result["department_id"] = $department_id;
        $result["departments"] = $this->action_model->get_departments();
//        $result["office_list"] = $this->action_model->get_office_by_department_id($department_id);
        $this->load->view("administration/project_template/template_responsible_ajax", $result);
    }

    public function get_template_staff_ajax() {
        $this->load->model('Action_model');
        $department_id = post("department_id");
        $office_id = post("office_id");
        $render_data["ismyself"] = post("ismyself");
        $render_data["select_staffs"] = post("select_staffs");
        $render_data['is_all'] = post("is_all");
        $render_data["staff_list"] = $this->action_model->get_staff_by_department_id_office_id($department_id, $office_id);
        $render_data['section'] = 'staff';
        $this->load->view('administration/project_template/get_service_list', $render_data);
    }

    public function get_template_staff_list() {
        $this->load->model('Action_model');
        $department_id = post("department_id");
        $office_id = post("office_id");
        $render_data["ismyself"] = post("ismyself");
        $render_data["select_staffs"] = post("select_staffs");
        $render_data["staff_list"] = $this->action_model->get_staff_by_department_id_office_id($department_id, $office_id);
        $render_data['section'] = 'staff_dd';
        $this->load->view('administration/project_template/get_service_list', $render_data);
    }

    public function get_template_staff_list2() {
        $this->load->model('Action_model');
        $department_id = post("department_id");
        $office_id = post("office_id");
        $render_data["ismyself"] = post("ismyself");
        $render_data["select_staffs"] = post("select_staffs");
        $render_data["staff_list"] = $this->action_model->get_staff_by_department_id_office_id($department_id, $office_id);
        $get_result['result']['partner'] = $this->load->view('administration/project_template/get_partner_list', $render_data, TRUE);
        $get_result['result']['manager'] = $this->load->view('administration/project_template/get_manager_list', $render_data, TRUE);
        $get_result['result']['associate'] = $this->load->view('administration/project_template/get_associate_list', $render_data, TRUE);
        echo json_encode($get_result);
        exit;
    }

    public function request_create_template() {
        $render_data = [];
        if ($data = $this->Project_Template_model->request_create_template(post())) {
            echo $data;
        } else {
            echo '-1';
        }
        exit;
    }

    public function project_template_task() {
        $render_data = [];
        if ($this->Project_Template_model->project_template_task(post())) {
            $render_data = [];
            $task_data = post();
            $template_main_id = $task_data['task']['template_main_id'];
//            echo $template_main_id;die;
            $render_data['data'] = $this->Project_Template_model->project_template_task_list($template_main_id);
            $this->load->view('administration/project_template/project_template_task_list', $render_data);
        } else {
            echo '-1';
        }
    }

    public function project_template_task_list() {
        $render_data = [];
        $render_data['data'] = $this->Project_Template_model->project_template_task_list();
        $this->load->view('administration/project_template/project_template_task_list', $render_data);
    }

    public function edit_project_template($template_id) {
        $this->load->model('Action_model');
        $this->load->layout = 'dashboard';
        $title = "Project Template";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'template';
        $render_data['header_title'] = $title;
        $render_data['template_id'] = $template_id;
        $render_data['service_category'] = $this->Project_Template_model->get_category();
        $render_data["departments"] = $this->action_model->get_departments();
        $render_data['office_list'] = $this->Project_Template_model->getOfficeList(2);
        $render_data['template_details'] = $this->Project_Template_model->editTemplateMainDetail($template_id);
        $render_data['staff_type'] = $this->Project_Template_model->getStaffType();
        $render_data['template_category']=$this->Project_Template_model->getTemplateCategory();
//        echo "<pre>";
//        print_r($render_data['template_details']);die;
        $render_data["task_list"] = $this->Project_Template_model->project_template_task_list($template_id);
        $this->load->template('administration/project_template/edit_template', $render_data);
    }
    public function inactive_project_template() {
        $template_id = post('id');
        echo $this->Project_Template_model->inactive_project_template($template_id);
    }
    public function addTaskNotesmodal() {
        $notes = $this->input->post('task_note');
        $id = $this->input->post('taskid');
        $this->load->model('notes');
        $this->load->model('action_model');
        if (!empty($notes)) {
            $this->notes->insert_note(8, $notes, "task_id", $id, 'task');
            echo count($notes);
        } else {
            echo '0';
        }
        //redirect(base_url() . 'action/home');
    }

    public function updateTaskNotes() {
        if (!empty(post('notes'))) {
            $this->load->model('Notes');
            $this->Notes->updateNotes(post(), post('notestable'));
            //redirect(base_url() . 'action/home');
        }
    }

    public function request_edit_template($template_id) {
//        echo $template_id;die;
        $render_data = [];
        if ($data = $this->Project_Template_model->request_edit_template($template_id, post())) {
            echo $data;
        } else {
            echo '-1';
        }
        exit;
    }

    public function get_task_department_office_ajax() {
        $this->load->model('Action_model');
        $department_id = post("department_id");
        $result["select_staffs"] = post("select_staff");
        $result['disabled'] = post('disabled');
        $result["department_id"] = $department_id;
        $result['responsible_staff'] = post('responsible_staff');
        $result['is_all'] = post('is_all');
        $result["ismyself"] = post("ismyself");
        $result["office_list"] = $this->action_model->get_office_by_department_id($department_id);
        $result["staff_list"] = $this->action_model->get_staff_by_department_id_office_id($department_id, '');
        $this->load->view("administration/project_template/template_task_office_ajax", $result);
    }

    public function get_template_task_staff_ajax() {
        $this->load->model('Action_model');
        $department_id = post("department_id");
        $office_id = post("office_id");
        $result["ismyself"] = post("ismyself");
        $result["select_staffs"] = post("select_staffs");
        $result['disabled'] = post('disabled');
        $result['is_all'] = post('is_all');
        $result['responsible_staff'] = post('responsible_staff');
        $result["staff_list"] = $this->action_model->get_staff_by_department_id_office_id($department_id, '');
//        print_r($result["staff_list"]);die;
        $this->load->view("administration/project_template/template_task_staff_ajax", $result);
    }

    public function get_responsible_staff_list_ajax() {
        $this->load->model('Action_model');
        $department_id = post("department_id");
        $result["ismyself"] = post("ismyself");
        $result["select_staffs"] = post("select_staffs");
        $result['is_all'] = post('is_all');
        $result['disabled'] = post('disabled');
        $result['user_type'] = post('user_type');
        if ($result['user_type'] == 1) {
            $result["staff_list"] = $this->action_model->get_staff_by_department_id_office_id(1, '');
        } else {
            $result["staff_list"] = $this->action_model->get_staff_by_department_id_office_id($department_id, '');
        }
        $this->load->view("administration/project_template/responsible_department_staff_ajax", $result);
    }

    public function get_responsible_francise_staff() {
        $this->load->model('Action_model');
        $user_type = post("user_type");
        $result['user_type'] = $user_type;
        $result['responsible_staff'] = post('responsible_staff');
        $this->load->view("administration/project_template/responsible_francise_staff", $result);
    }

    public function update_project_template_task($task_id, $template_main_id) {
        $render_data = [];
        if ($this->Project_Template_model->update_project_template_task($task_id, $template_main_id, post())) {
            $render_data = [];
            $task_data = post();
//            $template_main_id = $task_data['task']['template_main_id'];
//            echo $template_main_id;die;
            $render_data['data'] = $this->Project_Template_model->project_template_task_list($template_main_id);
            $this->load->view('administration/project_template/project_template_task_list', $render_data);
        } else {
            echo '-1';
        }
    }

    public function delete_template_task_modal() {
        $task_id=post('task_id');
        $template_id=post('template_id');
        if ($this->Project_Template_model->delete_project_template_task($task_id)) {
            $render_data = [];
            $render_data['data'] = $this->Project_Template_model->project_template_task_list($template_id);
            $this->load->view('administration/project_template/project_template_task_list', $render_data);
        } else {
            echo '-1';
        }
    }
    public function delete_project_template() {
        $template_id = post('id');
        echo $this->Project_Template_model->DeleteProjectTemplate($template_id);
    }

}
