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
            2 => "Assigned To",
            1 => "ID",
            3 => "Tracking Description"
        ];
    }
    function index($status = '', $priority = '', $request_type = '', $office_id = '', $department_id = ''){
        
        $this->load->layout = 'dashboard';
        $title = "Task Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'project_dashboard';
        $render_data['menu'] = 'task_dashboard';
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
        $render_data['page_number'] = post('page_number');
        $render_data["task_list"] = $this->Task_model->get_task_list($request, $status, $priority, $office_id, $department_id, $filter_assign, $filter_data, $sos_value, $sort_criteria, $sort_type, $client_type, $client_id);
        $this->load->view("task/task_dashboard", $render_data);
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
    public function task_input_form($task_id,$bookkeeping_input_type='',$type='edit'){
        $this->load->model('notes');
        $this->load->model('bookkeeping_model');
        $this->load->layout = 'dashboard';
        $title = "Input Forms";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'project dashboard';
        $render_data['menu'] = 'project_dashboard';
        $render_data['header_title'] = $title;
        $render_data['task_id']=$task_id;
        $render_data['note_title']='Task Note';
        $render_data['table']='project_task_note';
        $render_data['multiple']='y';
        $render_data['related_table_id']=11;
        $render_data['required']='n';
        $render_data['bookkeeping_input_type']=$bookkeeping_input_type;
        $render_data['client_id']='';
        $render_data['input_form_type']=$input_form_type=$this->Project_Template_model->getProjectTaskInputFormType($task_id);
        $render_data['project_id']=$project_id=$this->Project_Template_model->getTaskProjectId($task_id);
        $client_dtls=$this->Project_Template_model->getClientDtlsByTaskId($task_id);
        if($input_form_type==3){
            $this->load->model('service');
            $this->load->model('system');
            
            $render_data['state'] = $this->system->get_all_state();
            $render_data['staffInfo'] = staff_info();
//            print_r($render_data['staffInfo']);die;
            $render_data['period_time']=Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $render_data['client_name']=$client_name=$this->Project_Template_model->getProjectClientName($client_dtls->client_id, $client_dtls->client_type);
//            print_r($client_dtls); die;
    //        $render_data['completed_salestax_orders'] = $this->service->completed_orders_salestax(47); //id will be different for live
            $render_data['county_details'] = $this->action_model->get_county_name();
            $render_data['sales_tax_process']=$this->Project_Template_model->getProjectTaskSalesTaxProcess($task_id);
            $render_data['bank_account_details'] =$this->Project_Template_model->getaccountdetails($client_dtls->client_id);
        }if($input_form_type==1){
            if($bookkeeping_input_type==1){
            $render_data['client_id']=$client_dtls->client_id;
            $render_data['client_account_details']= $this->Project_Template_model->getBookkeepingAccountDetails($client_dtls->client_id,$task_id,$project_id);
            
//            These 2 function are closed for new requirement of feb 14th 2020
//            
//            $render_data['bookkeeping_details'] = $this->bookkeeping_model->get_bookkeeping_by_order_id($task_id,'project');
//            $render_data['list'] = $this->service_model->get_document_list_by_reference($task_id, 'project');
//            $this->load->view('services/show_document_list', $data);
            }else if($bookkeeping_input_type==2|| $bookkeeping_input_type==3){
                $render_data['client_id']=$client_dtls->client_id;
                $render_data['client_account_details']= $this->Project_Template_model->getBookkeepingInput2AccountDetails($client_dtls->client_id,$task_id,$project_id);
//                $render_data['bookkeeper_details']=$this->Project_Template_model->getProjetBookkeeperDetails($task_id);
            }
        }
            $render_data['related_service_files']=$this->Project_Template_model->getTaskFiles($task_id);
            $render_data['notes_data'] = $this->notes->note_list_with_log(11, 'task_id', $task_id);
        
        $this->load->template('projects/input_form',$render_data);
    }
    public function save_project_input_form() {
        if ($this->Project_Template_model->saveProjectInputForm(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function delete_project_input_form_file($file_id) {
        if ($this->Project_Template_model->delete_project_input_form_files($file_id)) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function task_sales_tax_input_form($task_id,$type='edit'){
        $this->load->layout = 'dashboard';
        $title = "Add Project Task Sales Tax Processing";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'project dashboard';
        $render_data['menu'] = 'project_dashboard';
        $render_data['header_title'] = $title;
//        $render_data['reference'] = 'company';
        $this->load->model('service');
        $this->load->model('system');
        $render_data['state'] = $this->system->get_all_state();
        $render_data['staffInfo'] = staff_info();
        $client_dtls=$this->Project_Template_model->getClientDtlsByTaskId($task_id);
        $render_data['client_name']=$client_name=$this->Project_Template_model->getProjectClientName($client_dtls->client_id, $client_dtls->client_type);
//        $render_data['completed_salestax_orders'] = $this->service->completed_orders_salestax(47); //id will be different for live
        $render_data['county_details'] = $this->action_model->get_county_name();
        $this->load->template('projects/project_task_sales_tax', $render_data);
    }
    public function update_project_bookkeeping_input_form_status(){
        $status = post('statusval');
        $id = post('id');
        $status_result= $this->Project_Template_model->updateProjectBookkeepingInputFormStatus($status,$id);
        echo $status_result;
    }
    public function update_project_bookkeeping_transaction_val(){
        $transaction_val=post('transaction_val');
        $id=post('id');
        $update=$this->Project_Template_model->updateProjectBookkeepingTransactionVal($id,$transaction_val);
        echo $update;
    }
    public function update_project_bookkeeping_uncategorized_item(){
        $uncategorized_item=post('uncategorized_item');
        $id=post('id');
        $update=$this->Project_Template_model->updateProjectBookkeepingUncategorizedItem($id,$uncategorized_item);
        echo $update;
    }
}
?>