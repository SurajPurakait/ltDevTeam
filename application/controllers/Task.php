<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
    private $filter_element;
    function __construct() {
        parent::__construct();
//        $this->load->model('system');
//        $this->load->model('News_Update_model');
//        $this->load->model('action_model');
//        $this->load->model("administration");
        $this->load->model('Project_Template_model');
        $this->load->model('Task_model');
        $user_info = staff_info();
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->filter_element = [
            1 => "ID",
            2 => "Assigned To",
            3 => "Tracking Description"
        ];
    }
    function index($status = '', $priority = '', $request_type = '', $office_id = '', $department_id = ''){
        
        $this->load->layout = 'dashboard';
        $title = "Task Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'task_dashboard';
        $render_data['menu'] = 'task';
        $render_data['header_title'] = $title;
//        $render_data['filter_element_list'] = $this->filter_element;
//        $render_data['project_list']=$this->Project_Template_model->getProjectList();
        if ($priority == 0) {
            $priority = '';
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
        $render_data['priority'] = $priority;
        $render_data['filter_element_list'] = $this->filter_element;
//        print_r($render_data);die;
        $this->load->template('task/task', $render_data);
    }
    public function task_dashboard_ajax() {
        $request = post("request");
        $status = post("status");
        $priority = post("priority");
        $office_id = post("office_id");
        $department_id = post("department_id");
        $filter_assign = post("filter_assign");
        $filter_data = post("filter_data");
        $sos_value = post("sos_value");
        $sort_criteria = post("sort_criteria");
        $sort_type = post("sort_type");
        $client_type = post("client_type");
        $client_id = post("client_id");
        $render_data["task_list"] = $this->Task_model->get_task_list($request, $status, $priority, $office_id, $department_id, $filter_assign, $filter_data, $sos_value, $sort_criteria, $sort_type, $client_type, $client_id);
//        print_r($render_data["project_list"]);die;
        $return["result"] = $this->load->view("task/task_dashboard", $render_data, true);
        echo json_encode($return);
    }
    public function sort_task_dashboard(){
        $formdata = post();
        $sort_criteria = $formdata['sort_criteria'];
        $sort_type = $formdata["sort_type"];
//        echo $sort_type;die;
        unset($formdata['sort_criteria']);
        unset($formdata['sort_type']);
        $filter_assign = $formdata;
        $render_data["task_list"] = $this->Task_model->get_task_list('', '', '', '', '', '', $filter_assign, '', $sort_criteria, $sort_type);
//        echo "<pre>";
//        print_r($render_data["project_list"]);
//        echo '</pre>';die;
        $return["result"] = $this->load->view("task/task_dashboard", $render_data, true);
        echo json_encode($return);
    }
    public function task_filter() {
        $render_data["task_list"] = $this->Task_model->get_task_list('', '', '', '', '', '', post());
        $this->load->view("task/task_dashboard", $render_data);
    }
    public function task_filter_dropdown_option_ajax() {
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
            $result['element_value_list'] = $this->Task_model->get_task_filter_element_value($element_key, $office);
//        }
        $this->load->view('task/task_filter_dropdown_option_ajax', $result);
    }
    public function updateProjectTaskNotes() {
        if (!empty(post('notes'))) {
            $this->load->model('Notes');
            $this->Notes->updateNotes(post(), post('notestable'));
            //redirect(base_url() . 'action/home');
        }
    }
    public function addProjectTaskNotesmodal() {
        $notes = $this->input->post('task_note');
        $id = $this->input->post('taskid');
        $this->load->model('notes');
        $this->load->model('action_model');
        if (!empty($notes)) {
            $this->notes->insert_note(11, $notes, "task_id", $id, 'task');
            echo count($notes);
        } else {
            echo '0';
        }
        //redirect(base_url() . 'action/home');
    }
}
?>