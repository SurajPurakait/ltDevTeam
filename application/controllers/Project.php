<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

    private $filter_element;

    function __construct() {
        parent::__construct();
//        $this->load->model('system');
//        $this->load->model('News_Update_model');
//        $this->load->model('action_model');
//        $this->load->model("administration");
        $this->load->model('Project_Template_model');
        $this->load->model('billing_model');
        $user_info = staff_info();
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->filter_element = [
            1 => "ID",
            2 => "Template",
            3 => "Pattern",
            4 => "Client Type",
//            5 => "Client Id",
            6 => "Responsible",
            7 => "Assigned To",
            8 => "Tracking",
            9 => "Creation Date",
            10 => "Requested By",
            11 => "Due Date",
            12 => "Template Category"
        ];
    }

    function index($status = '', $template_id = '', $request_type = '', $office_id = '', $department_id = '', $filter_assign = '', $filter_data = [], $sos_value = '', $sort_criteria = '', $sort_type = '', $client_type = '', $client_id = '', $template_cat_id = '') {
//        echo 'kk'.$template_id;die;
        $this->load->layout = 'dashboard';
        $title = "Project Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'project_dashboard';
        $render_data['menu'] = 'project';
        $render_data['header_title'] = $title;
//        $render_data['filter_element_list'] = $this->filter_element;
//        $render_data['project_list']=$this->Project_Template_model->getProjectList();
        if ($template_id == 0) {
            $template_id = '';
        }
        if ($office_id == 0) {
            $office_id = '';
        }
        if ($department_id == 0) {
            $department_id = '';
        }
        if ($status == 'all') {
            $status = '';
        }
        $render_data['stat'] = $status;
        $render_data['status'] = $status;
        $render_data['office_id'] = $office_id;
        $render_data['department_id'] = $department_id;
        $render_data['request_type'] = $request_type;
        $render_data['template_id'] = $template_id;
        $render_data['template_cat_id'] = $template_cat_id;
        $render_data['filter_element_list'] = $this->filter_element;
        $render_data['templateIds'] = $this->Project_Template_model->getTemplateIds();
        $render_data['due_m'] = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
        $this->load->template('projects/project', $render_data);
    }

    function request_create_project() {
        echo $this->Project_Template_model->requestCreateProject($this->input->post());
    }

    public function updateProjectNotes() {
        if (!empty(post('notes'))) {
            $this->load->model('Notes');
            $this->Notes->updateNotes(post(), post('notestable'));
            //redirect(base_url() . 'action/home');
        }
    }

    public function addProjectNotesmodal() {
        $notes = $this->input->post('project_note');
        $id = $this->input->post('project_id');
        $this->load->model('notes');
        $this->load->model('action_model');
        if (!empty($notes)) {
            $this->notes->insert_note(9, $notes, "project_id", $id, 'project');
            echo count($notes);
        } else {
            echo '0';
        }
        //redirect(base_url() . 'action/home');
    }

    public function edit_project_template($project_id) {
        $project_id = base64_decode($project_id);
//        $template_id=base64_decode($template_id);
        $this->load->model('Action_model');
        $this->load->layout = 'dashboard';
        $title = "Project Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'project_dashboard';
        $render_data['menu'] = 'project_dashboard';
        $render_data['header_title'] = $title;
        $render_data['project_id'] = $project_id;
        $render_data['service_category'] = $this->Project_Template_model->get_category();
        $render_data["departments"] = $this->action_model->get_departments();
        $render_data['office_list'] = $this->Project_Template_model->getOfficeList(2);
        $render_data['template_main_id'] = $this->db->get_where('projects', ['id' => $project_id])->row()->template_id;
        $render_data['template_details'] = $this->Project_Template_model->editProjectMainDetail($project_id);
        $render_data['staff_type'] = $this->Project_Template_model->getStaffType();
//        echo "<pre>";
//        print_r($render_data['template_details']);die;
        $render_data["task_list"] = $this->Project_Template_model->project_main_task_list($project_id);
        $this->load->template('projects/edit_project_template', $render_data);
    }

    public function edit_project($project_id) {
        $this->load->layout = 'dashboard';
        $title = "Project Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'project_dashboard';
        $render_data['menu'] = 'project_dashboard';
        $render_data['header_title'] = $title;
        $render_data['project_list'] = $this->Project_Template_model->getProjectList();
        $this->load->template('projects/project', $render_data);
    }

    public function get_project_completed_orders_officewise() {
//        echo post('client_id');die;
        $office_id = post('office_id');
        $render_data['client_id'] = post('client_id');
        $render_data['mode'] = post('mode');
        $render_data['completed_orders'] = $this->service->completed_orders('', $office_id);
        $this->load->view('projects/project_client_list', $render_data);
    }

    function request_update_project($project_id) {
        echo $this->Project_Template_model->requestUpdateProject($project_id, $this->input->post());
    }

    public function get_project_tracking_log($id, $table_name) {
        echo json_encode($this->Project_Template_model->get_project_tracking_log($id, $table_name));
    }

    public function update_project_task_status() {
        $prev_status = $this->Project_Template_model->get_current_project_task_status('project_task', $this->input->post("id"));
        $statusval = post('statusval');
        $prosubid = post('prosubid');
        $this->load->model('service_model');
        $comment = '';
        $sub_taskid=$this->Project_Template_model->update_project_task_status($prosubid, $statusval, $comment);
        $projectid=$this->db->get_where('project_task',['id'=>$prosubid])->row_array()['project_id'];
        $ids['task_status']=$this->db->get_where('project_task',['id'=>$prosubid])->row_array()['tracking_description'];
        $ids['project_status']=$this->db->get_where('project_main',['project_id'=>$projectid])->row_array()['status'];
        $ids['sub_taskid_status']=$this->db->get_where('project_task',['id'=>$sub_taskid])->row_array()['tracking_description'];
        $ids['sub_taskid']=$sub_taskid;
        echo json_encode($ids);
    }

    public function request_update_project_main() {

        if ($data = $this->Project_Template_model->request_update_project_main(post())) {
            echo $data;
        } else {
            echo '-1';
        }
        exit;
    }

    public function update_project_task($task_id, $template_main_id, $project_id) {
        $render_data = [];
        if ($this->Project_Template_model->update_project_task($task_id, $template_main_id, post(), $project_id)) {
            $render_data = [];
            $task_data = post();
//            $template_main_id = $task_data['task']['template_main_id'];
//            echo $template_main_id;die;
            $render_data['data'] = $this->Project_Template_model->project_task_list($project_id);
            $this->load->view('projects/project_task_list', $render_data);
        } else {
            echo '-1';
        }
    }

    public function add_project_task() {
        $render_data = [];
        if ($this->Project_Template_model->add_project_task(post())) {
            $render_data = [];
            $task_data = post();
            $project_id = $task_data['task']['project_id'];
//            echo $template_main_id;die;
            $render_data['data'] = $this->Project_Template_model->project_task_list($project_id);
            $this->load->view('projects/project_task_list', $render_data);
        } else {
            echo '-1';
        }
    }

    public function get_project_container_ajax() {
        $client_type = post('client_type');
//        echo $client_type;die;
        $reference_id = post('reference_id');
        $render_data['reference_id'] = $reference_id;
        $render_data['service_category_list'] = $this->billing_model->get_service_category();
        if ($client_type == '1') {
            $render_data['reference'] = 'company';
//            $render_data['completed_orders'] = $this->service->completed_orders();
        } else {
            $render_data['reference'] = 'individual';
        }
        $this->load->view('projects/client_type' . $client_type, $render_data);
    }

    public function get_completed_orders_officewise() {
        $office_id = post('office_id');
//        echo post('client_id');die;
        $render_data['client_id'] = post('client_id');
        $render_data['completed_orders'] = $this->service->completed_orders('', $office_id);
//        print_r($render_data['completed_orders']);die;
        $this->load->view('projects/business_client_list', $render_data);
    }

    public function get_edit_project_container_ajax() {
        $client_type = post('client_type');
        $client_id = post('client_id');
        $project_id = post('project_id');
        if ($client_type == '1') {
            $render_data['project_id'] = $project_id;
            $render_data['client_id'] = $client_id;
            $render_data['office_id'] = $this->Project_Template_model->get_project_office_id($project_id);
//            echo $office_id;die;
            $render_data['reference'] = 'company';
        } else {
            $render_data['client_id'] = $client_id;
            $render_data['reference'] = 'individual';
        }
        $this->load->view('projects/client_type' . $client_type, $render_data);
    }

    public function sort_project_dashboard() {
        $formdata = post();
        $sort_criteria = $formdata['sort_criteria'];
        $sort_type = $formdata["sort_type"];
//        echo $sort_type;die;
        unset($formdata['sort_criteria']);
        unset($formdata['sort_type']);
        $filter_assign = $formdata;
        $render_data["project_list"] = $this->Project_Template_model->get_project_list('', '', '', '', '', '', $filter_assign, '', $sort_criteria, $sort_type);
        $return["result"] = $this->load->view("projects/project_dashboard", $render_data, true);
        echo json_encode($return);
    }

    public function project_filter() {
        $render_data["project_list"] = $this->Project_Template_model->get_project_list('', '', '', '', '', '', post());
        $this->load->view("projects/project_dashboard", $render_data);
    }

    public function dashboard_ajax() {
        $request = post("request");
        $status = post("status");
        $template_id = post("template_id");
        $office_id = post("office_id");
        $department_id = post("department_id");
        $filter_assign = post("filter_assign");
        $filter_data = post("filter_data");
        $sos_value = post("sos_value");
        $sort_criteria = post("sort_criteria");
        $sort_type = post("sort_type");
        $client_type = post("client_type");
        $client_id = post("client_id");
        $template_cat_id = post('template_cat_id');
        $month = post('month');
        if (post('page_number') != 0) {
            $render_data['page_number'] = post('page_number');
        }
        $render_data["project_list"] = $this->Project_Template_model->get_project_list($request, $status, $template_id, $office_id, $department_id, $filter_assign, $filter_data, $sos_value, $sort_criteria, $sort_type, $client_type, $client_id, $template_cat_id, $month);
        $this->load->view("projects/project_dashboard", $render_data);
    }

    public function project_filter_dropdown_option_ajax() {
        $result['element_key'] = $element_key = post('variable');
        $result['condition'] = '';
        if (post('condition')) {
            $result['condition'] = post('condition');
        }
        $office = '';
        if (post('office')) {
            $office = post('office');
        }
//        if (post('dashboard_type')) {
//            $result['element_array'] = $this->sales_tax_filter_element;
//            $result['element_value_list'] = $this->action_model->get_salestax_filter_element_value($element_key);
//        } else {
        $result['element_array'] = $this->filter_element;
        $result['element_value_list'] = $this->Project_Template_model->get_project_filter_element_value($element_key, $office);
//        }
        $this->load->view('projects/project_filter_dropdown_option_ajax', $result);
    }

    public function delete_project() {
        $project_id = post('project_id');
        $project_template_id = post('project_template_id');
        if ($this->Project_Template_model->delete_project($project_id, $project_template_id)) {
            echo '1';
        } else {
            echo "-1";
        }
    }

    public function load_project_tasks() {
        $id = post('id');
        $created_at = post('created_at');
        $dueDate = post('dueDate');
        $render_data['id'] = $id;
        $render_data['created_at'] = $created_at;
        $render_data['dueDate'] = $dueDate;
        $render_data['task_list'] = getProjectTaskList($id);
        $this->load->view('projects/project_dashboard_collapse', $render_data);
    }

}
