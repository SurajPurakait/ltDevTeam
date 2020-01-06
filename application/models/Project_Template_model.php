<?php

class Project_Template_model extends CI_Model {

    private $filter_element, $project_select;

    public function __construct() {
        parent::__construct();
        $this->filter_element = [
            1 => "id",
            2 => "template_id",
            3 => "pattern",
            4 => "client_type",
            5 => "client_id",
            6 => "all_project_staffs",
            7 => "all_project_staffs",
            8 => "status",
            9 => "created_at",
            10 => "added_by_user",
            11 => "due_date",
            12 => "template_cat_id"
        ];

        // $this->project_select[] = 'REPLACE(CONCAT(",",(SELECT GROUP_CONCAT(psm2.staff_id) FROM project_staff_main AS psm2 WHERE psm2.project_id = pro.id),(SELECT GROUP_CONCAT(pts.staff_id) FROM project_task_staff AS pts left join project_task AS pt on pt.id=pts.task_id WHERE pt.project_id = pro.id),","), " ", "") AS all_project_staffs';
        $this->project_select[] = 'REPLACE(CONCAT(",",(SELECT GROUP_CONCAT(psm2.staff_id) FROM project_staff_main AS psm2 WHERE psm2.project_id = pro.id),","), " ", "") AS all_project_staffs';
        $this->project_select[] = 'REPLACE(CONCAT(",",(SELECT GROUP_CONCAT(pts.staff_id) FROM project_task_staff AS pts WHERE pts.task_id = pt.id),","), " ", "") AS all_task_staffs';
        $this->project_select[] = 'pro.*,pm.office_id as project_office_id,pm.department_id as project_department_id,pm.status as status,prm.actual_due_month';
        $this->project_select[] = 'pm.added_by_user AS added_by_user';
        $this->project_select[] = 'pm.added_by_user AS staff_id';
        $this->project_select[] = 'pm.department_id as department_id';
        $this->project_select[] = 'prm.due_date as due_date';
        $this->project_select[] = 'pm.template_cat_id as template_cat_id';

//        $this->project_select[] = 'REPLACE(CONCAT(",",(SELECT case when (pm.office_id=1 then GROUP_CONCAT(psm2.staff_id) FROM project_staff_main AS psm2 WHERE psm2.project_id = pro.id )),",")," "," ") AS responsible_staff';
    }

    public function get_category() {

        $data = $this->db->get('category')->result_array();
        return $data;
    }

    public function get_service($category_id) {

        $data = $this->db->where('category_id', $category_id)->get('services')->result_array();
        return $data;
    }

    public function request_create_template($post) {
//        echo "<pre>";
//        print_r($post);
//        echo "</pre>";die;
        $last_id = '';
        $this->db->trans_begin();
        if (isset($post['template_main']) && !empty($post['template_main'])) {
            $temp_main_ins['added_by_user'] = sess('user_id');
            $temp_main_ins['template_id'] = $post['template_main']['Id'];
            $temp_main_ins['title'] = $post['template_main']['title'];
            $temp_main_ins['description'] = $post['template_main']['description'];
            $temp_main_ins['category_id'] = $post['template_main']['service_category'];
            $temp_main_ins['template_cat_id']=$post['template_main']['template_cat_id'];
            if (isset($post['template_main']['service']) && $post['template_main']['service'] != '') {
                $temp_main_ins['service_id'] = $post['template_main']['service'];
            } else {
                $temp_main_ins['service_id'] = '';
            }
            $temp_main_ins['status'] = $post['template_main']['status'];
            $temp_main_ins['department_id'] = $post['template_main']['department'];
//            $temp_main_ins['ofc_is_all'] = $post['template_main']['ofc_is_all'];
            $temp_main_ins['dept_is_all'] = $post['template_main']['dept_is_all'];
            $temp_main_ins['office_id'] = $post['template_main']['office'];
            if ($temp_main_ins['office_id'] == 3) {
                $temp_main_ins['responsible_staff'] = $post['template_main']['francise_staff'];
            }
            if (isset($post['template_main']['responsible_department']) && $post['template_main']['responsible_department'] != '') {
                $temp_main_ins['responsible_department'] = $post['template_main']['responsible_department'];
            }
            if (isset($post['template_main']['is_all']) && $post['template_main']['is_all'] != '') {
                $temp_main_ins['ofc_is_all'] = $post['template_main']['is_all'];
            }
            $template_staff_list = $this->get_department_staff_by_department_id($post['template_main']['department']);
//            echo "<pre>";
//            print_r($template_staff_list);die;
//            if (isset($post['template_main']['partner']) && $post['template_main']['partner'] != '') {
//                $temp_main_ins['partner_id'] = $post['template_main']['partner'];
//            } else {
//                $temp_main_ins['partner_id'] = null;
//            }
//            if (isset($post['template_main']['manager']) && $post['template_main']['manager'] != '') {
//                $temp_main_ins['manager_id'] = $post['template_main']['manager'];
//            } else {
//                $temp_main_ins['manager_id'] = null;
//            }
//            if (isset($post['template_main']['associate']) && $post['template_main']['associate'] != '') {
//                $temp_main_ins['associate_id'] = $post['template_main']['associate'];
//            } else {
//                $temp_main_ins['associate_id'] = null;
//            }
//            echo "<pre>";
//            print_r($temp_main_ins);
//            echo "</pre>";
//            
//            die;

            $this->db->insert('project_template_main', $temp_main_ins);
            $last_id = $this->db->insert_id();

            if (isset($post['template_main']['department_staff']) && !empty($post['template_main']['department_staff'])) {

                foreach ($post['template_main']['department_staff'] as $ins_staff_id) {

                    $this->db->insert('project_template_staff_main', ['template_id' => $last_id, 'staff_id' => $ins_staff_id, 'type' => 1]);
                }
            }
            if (isset($post['template_main']['res_dept_staff']) && !empty($post['template_main']['res_dept_staff'])) {

                foreach ($post['template_main']['res_dept_staff'] as $ins_staff_id) {

                    $this->db->insert('project_template_staff_main', ['template_id' => $last_id, 'staff_id' => $ins_staff_id, 'type' => 2]);
                }
            }
            if ($temp_main_ins['dept_is_all'] == 1 && !empty($template_staff_list)) {
//                echo "a";die;
                foreach ($template_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_template_staff_main', ['template_id' => $last_id, 'staff_id' => $staffId, 'type' => 1]);
                }
//                echo $this->db->last_query();
            }
            $template_responsible_list = $this->get_department_staff_by_department_id($post['template_main']['office']);
            if ((isset($temp_main_ins['ofc_is_all']) && $temp_main_ins['ofc_is_all'] == 1) && !empty($template_responsible_list)) {
                foreach ($template_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_template_staff_main', ['template_id' => $last_id, 'staff_id' => $staffId, 'type' => 2]);
                }
            }
        }
        if (isset($post['recurrence']) && !empty($post['recurrence']) && $last_id != '') {

            $ins_recurrence = [];
            $ins_recurrence['template_id'] = $last_id;
            foreach ($post['recurrence'] as $key => $val) {
                $ins_recurrence[$key] = $val;
            }

            if ($ins_recurrence['pattern'] == 'annually' || $ins_recurrence['pattern'] == 'none') {
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = $ins_recurrence['due_month'];
                $current_month=date('m');
                $current_day=date('d');
                if($ins_recurrence['due_month']>=$current_month && $ins_recurrence['due_day']>=$current_day){
                    $ins_recurrence['actual_due_year'] = date('Y');
                }else{
                    $ins_recurrence['actual_due_year'] = date('Y')+1;
                }
            } elseif ($ins_recurrence['pattern'] == 'monthly') {
                $current_month = date('m');
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = (int) $current_month + (int) $ins_recurrence['due_month'];
                if($ins_recurrence['actual_due_day']>=date('d')){
                    if($ins_recurrence['actual_due_month']<=12){
                        $ins_recurrence['actual_due_year'] = date('Y');
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y');
                    }
                }else{
                   if($ins_recurrence['actual_due_month']<=12){
                        $ins_recurrence['actual_due_year'] = date('Y');
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y')+($ins_recurrence['actual_due_month']/12);
                    } 
                }
            } elseif ($ins_recurrence['pattern'] == 'weekly') {
                $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
                $current_day = $day_array[$ins_recurrence['due_month']];
                $givenDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $ins_recurrence['due_day'], date('Y')));
                $ins_recurrence['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
                $ins_recurrence['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
                $ins_recurrence['actual_due_year'] = date('Y');
            } elseif ($ins_recurrence['pattern'] == 'quarterly') {
                $current_month = date('m');
                if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                    $next_quarter[1] = '4';
                    $next_quarter[2] = '5';
                    $next_quarter[3] = '6';
                    $due_year = date('Y');
                } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
                    $next_quarter[1] = '7';
                    $next_quarter[2] = '8';
                    $next_quarter[3] = '9';
                    $due_year = date('Y');
                } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
                    $next_quarter[1] = '10';
                    $next_quarter[2] = '11';
                    $next_quarter[3] = '12';
                    $due_year = date('Y');
                } else {
                    $next_quarter[1] = '1';
                    $next_quarter[2] = '2';
                    $next_quarter[3] = '3';
                    $due_year = date('Y', strtotime('+1 year'));
                }
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = $next_quarter[$ins_recurrence['due_month']];
                $ins_recurrence['actual_due_year'] = $due_year;
            }elseif($ins_recurrence['pattern']=='periodic'){
                $current_month = date('m');
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = (int) $ins_recurrence['due_month'];
                if($ins_recurrence['actual_due_day']>=date('d')){
                    if($ins_recurrence['actual_due_month']<$current_month){
                        $ins_recurrence['actual_due_year'] = date('Y', strtotime('+1 year'));
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y');
                    }
                }else{
                   if($ins_recurrence['actual_due_month']<=$current_month){
                        $ins_recurrence['actual_due_year'] = date('Y', strtotime('+1 year'));
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y');
                    } 
                }
            }
            else {
                $ins_recurrence['actual_due_day'] = '0';
                $ins_recurrence['actual_due_month'] = '0';
                $ins_recurrence['actual_due_year'] = '0';
            }
            $periodic_day= json_decode($ins_recurrence['periodic_due_day']);
            $periodic_month=json_decode($ins_recurrence['periodic_due_month']);
            unset($ins_recurrence['periodic_due_day']);
            unset($ins_recurrence['periodic_due_month']);
//            if(isset($ins_recurrence['pattern']))
//            print_r($ins_recurrence);die;
            $this->db->insert('project_template_recurrence_main', $ins_recurrence);
//            print_r($periodic_day);echo '<br>';
//            print_r($periodic_month);echo "<br>";
            if(isset($periodic_day) && !empty($periodic_day)){
                $periodic_count=count($periodic_day);
                $periodic_day_array=array();
                $i=0;
                foreach ($periodic_day as $value) {
                    $periodic_day_array[]=$i.'_'.$value;
                    $i++;
                }
                $new_val= array_combine($periodic_day_array,$periodic_month);
//                print_r($new_val);die;
                foreach($new_val as $day=>$month){
                    $periodic_data=array();
                    $current_month = date('m');
                    $exp1=explode('_',$day);
                    $day=$exp1[1];
                    $actual_due_day = $day;
                    $actual_due_month = $month;
                    if($actual_due_day>=date('d')){
                        if($actual_due_month<$current_month){
                            $actual_due_year = date('Y', strtotime('+1 year'));
                        }else{
                            $actual_due_year=date('Y');
                        }
                    }else{
                       if($actual_due_month<=$current_month){
                            $actual_due_year = date('Y', strtotime('+1 year'));
                        }else{
                            $actual_due_year=date('Y');
                        } 
                    }
                    $periodic_data=array(
                        'template_id'=>$last_id,
                        'due_day'=>$day,
                        'due_month'=>$month,
                        'actual_due_day'=>$actual_due_day,
                        'actual_due_month'=>$actual_due_month,
                        'actual_due_year'=>$actual_due_year
                    );
                    $this->db->insert('template_periodic_pattern',$periodic_data);
                }
                
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $last_id;
        }
    }

    function project_template_task($post) {
//        print_r($post);die;
        $this->db->trans_begin();
        $template_cat_id = $post['task']['template_cat_id'];
        $task_data['template_main_id'] = $post['task']['template_main_id'];
        $task_data['added_by_user'] = sess('user_id');
        $task_data['task_order'] = $post['task']['task_order'];
        $task_data['task_title'] = $post['task']['task_title'];
        $task_data['description'] = $post['task']['description'];
        $task_data['target_start_date'] = $post['task']['target_start_date'];
        $task_data['target_start_day'] = $post['task']['target_start_day'];
        $task_data['target_complete_date'] = $post['task']['target_complete_date'];
        $task_data['target_complete_day'] = $post['task']['target_complete_day'];
        $task_data['tracking_description'] = $post['task']['tracking_description'];
        $task_data['is_input_form']=$post['task']['is_input_form'];
        if($template_cat_id==1){
            if($post['task']['is_input_form']=='y'){
                $task_data['input_form_type']=1;
                if(isset($post['task']['bookkeeping_input_type']) && $post['task']['bookkeeping_input_type']!=''){
                    $task_data['bookkeeping_input_type']=$post['task']['bookkeeping_input_type'];
                }else{
                    $task_data['bookkeeping_input_type']=0;
                }
            }else{
                $task_data['input_form_type']=0;
            }
        }else{
            if(isset($post['task']['input_form_type']) && $post['task']['input_form_type']!=''){
                $task_data['input_form_type']=$post['task']['input_form_type'];
            }else{
                $task_data['input_form_type']=0;
            }
        }
//        $task_data['is_all'] = $post['task']['is_all'];
        $task_data['department_id'] = $post['task']['department'];
        if ($task_data['department_id'] != 2 && ($post['task']['is_all'] == 1 || $post['task']['is_all'] == 0)) {
            $task_data['responsible_task_staff'] = null;
            $task_data['is_all'] = $post['task']['is_all'];
        } else {
            $task_data['is_all'] = null;
            $task_data['responsible_task_staff'] = $post['task']['responsible_task_staff'];
        }
        $task_staff_list = $this->get_department_staff_by_department_id($post['task']['department']);
//        print_r($task_staff_list);die;
        $this->db->insert('project_template_task', $task_data);
        $insert_id = $this->db->insert_id();
        if ($post['task']['department'] != 2) {
            if (isset($post['task']['staff']) && !empty($post['task']['staff']) && ($post['task']['is_all'] != 1)) {
                foreach ($post['task']['staff'] as $ins_staff_id) {
                    $this->db->insert('project_template_task_staff', ['task_id' => $insert_id, 'staff_id' => $ins_staff_id]);
                }
            }
            if ($task_data['is_all'] == 1 && !empty($task_staff_list)) {
//                echo "a";die;
                foreach ($task_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_template_task_staff', ['task_id' => $insert_id, 'staff_id' => $staffId]);
                }
//                echo $this->db->last_query();
            }
        }
        $notedata = $this->input->post('task_note');
        $this->insert_task_note(8, $notedata, "task_id", $insert_id, 'task');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function project_template_task_list($template_main_id) {
        $added_user = sess('user_id');
//        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('project_template_task', ['template_main_id' => $template_main_id])->result_array();
    }

    function project_task_list($project_id) {
        $added_user = sess('user_id');
//        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('project_task', ['project_id' => $project_id])->result_array();
    }

    function project_main_task_list($template_main_id) {
        $added_user = sess('user_id');
//        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('project_task', ['project_id' => $template_main_id])->result_array();
    }

    function get_project_template_list() {
        $added_user = sess('user_id');
        $this->db->order_by('id', 'DESC');
        $this->db->where('status !=','4'); // 4 = inactivated as on 26.12.19
        return $this->db->get('project_template_main')->result_array();
    }

    public function get_assigned_dept_staff_project_template($id) {

        $query = 'select dept_is_all from project_template_main where id=' . $id . '';
        $data1 = $this->db->query($query)->row_array();

        if ($data1['dept_is_all'] == 1) {

            return "All Staff";
        } else {

            $query = 'select staff_id '
                    . 'from project_template_staff_main '
                    . 'where template_id=' . $id . ' and type=1';
            $data2 = $this->db->query($query)->row_array();

            $query = 'select CONCAT(last_name, ", ",first_name,", ",middle_name) as full_name '
                    . 'from staff '
                    . 'where id=' . $data2['staff_id'] . '';
            $data3 = $this->db->query($query)->row_array();


            return $data3['full_name'];
        }
    }

    public function get_assigned_dept_staff_project_main($id) {

        $query = 'select dept_is_all from project_main where project_id=' . $id . '';
        $data1 = $this->db->query($query)->row_array();

        if ($data1['dept_is_all'] == 1) {

            return "All Staff";
        } else {

            $query = 'select staff_id '
                    . 'from project_staff_main '
                    . 'where project_id=' . $id . ' and type=1';
            $data2 = $this->db->query($query)->row_array();

            $query = 'select CONCAT(last_name, ", ",first_name) as full_name '
                    . 'from staff '
                    . 'where id=' . $data2['staff_id'] . '';
            $data3 = $this->db->query($query)->row_array();


            return $data3['full_name'];
        }
    }

    public function get_assigned_office_staff_project_template($id) {
//echo "hi";die;
        $query = 'select ofc_is_all,office_id from project_template_main where id=' . $id . '';
        $data1 = $this->db->query($query)->row_array();
        if ($data1['office_id'] == 3) {
            $val = $this->db->query("SELECT responsible_staff from project_template_main WHERE id='$id'")->row();
            if ($val->responsible_staff == 1) {
                return "Partner";
            } elseif ($val->responsible_staff == 2) {
                return "Manager";
            } else {
                return "Client Association";
            }
        } else {
            if ($data1['ofc_is_all'] == 1) {
                return "All Staff";
            } else {

                $query = 'select staff_id '
                        . 'from project_template_staff_main '
                        . 'where template_id=' . $id . ' and type=2';
                $data2 = $this->db->query($query)->row_array();

                $query = 'select CONCAT(last_name, ", ",first_name,", ",middle_name) as full_name '
                        . 'from staff '
                        . 'where id=' . $data2['staff_id'] . '';
                $data3 = $this->db->query($query)->row_array();


                return $data3['full_name'];
            }
        }
    }

    public function get_assigned_office_staff_project_main($id, $client_id = '') {
        $array = [];
        $query = 'select * from project_main where project_id=' . $id . '';
        $data1 = $this->db->query($query)->row_array();
        if ($client_id == '') {
            $qs = 'select * from projects where id=' . $id . '';
            $res = $this->db->query($qs)->row_array();
            $client_id = $res['client_id'];
        }
        if ($data1['office_id'] == 3) {
            $query1 = 'select * from internal_data where reference_id=' . $client_id . '';
            $result1 = $this->db->query($query1)->row_array();
            if ($data1['responsible_staff'] == 1) {
                $array['name'] = $result1['partner'];
                $array['office'] = $result1['office'];
            } elseif ($data1['responsible_staff'] == 2) {
                $array['name'] = $result1['manager'];
                $array['office'] = $result1['office'];
            } else {
                if (isset($result1['client_association']) && $result1['client_association'] != '') {
                    $array['name'] = $result1['client_association'];
                    $array['office'] = $result1['client_association'];
                } else {
                    $array['name'] = 'N/A';
                    $array['office'] = 'N/A';
                }
            }
        } else {
            if ($data1['ofc_is_all'] == 1) {
                $array['name'] = 'All Staff';
            } else {

                $query = 'select staff_id '
                        . 'from project_staff_main '
                        . 'where project_id=' . $id . ' and type=2';
                $data2 = $this->db->query($query)->row_array();

                $query = 'select CONCAT(first_name, " ",last_name) as full_name '
                        . 'from staff '
                        . 'where id=' . $data2['staff_id'] . '';
                $data3 = $this->db->query($query)->row_array();

                $array['name'] = $data3['full_name'];
            }
            $array['office'] = '0';
        }
        return $array;
    }
    public function getAssignedOfficeStaffProjectTask($task_id,$project_id, $responsible_staff){
        $project_details=$this->db->get_where('projects',['id'=>$project_id])->row();
        $officeid=$project_details->office_id;
        $client_id=$project_details->client_id;
        $client_type=$project_details->client_type;
        $data['office']= $this->db->get_where('office',['id'=>$officeid])->row()->office_id;
        if($responsible_staff==1){
            $this->db->select("concat(s.first_name ,' ', s.last_name) as name");
            $this->db->from('staff s');
            $this->db->join('internal_data ind','s.id=ind.partner');
            $this->db->where('ind.reference_id',$client_id);
            $result=$this->db->get()->row();
            if(!empty($result)){
                $data['staff_name']=$result->name;
            }else{
               $data['staff_name']='N/A';
            }
        }else if($responsible_staff==2){
            $this->db->select("concat(s.first_name ,' ', s.last_name) as name");
            $this->db->from('staff s');
            $this->db->join('internal_data ind','s.id=ind.manager');
            $this->db->where('ind.reference_id',$client_id);
            $result=$this->db->get()->row();
            if(!empty($result)){
                $data['staff_name']=$result->name;
            }else{
               $data['staff_name']='N/A';
            }
        }
        else{
            $data['staff_name']='N/A';
        }
        return $data;
           
    }

    public function getTemplateStaffList($template_id) {
        return $this->db->get_where('project_template_main', ['id' => $template_id])->row();
    }

    public function get_project_officeID_by_project_id($project_id) {
        $this->db->select('o.office_id as office_name');
        $this->db->from('projects p');
        $this->db->join('office o', 'o.id=p.office_id');
        $this->db->where('p.id', $project_id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function getTemplateOfficeStaffList($office_id, $department) {
        if ($office_id == '' && $department != 2) {
            $query = 'select s.id,CONCAT(s.last_name, ", ",s.first_name,", ",s.middle_name) as full_name '
                    . 'from staff s '
                    . 'INNER JOIN department_staff ds ON(ds.staff_id=s.id)'
                    . 'where ds.department_id=' . $department . '';
            $data = $this->db->query($query)->result_array();
        } else {
            $query1 = "SELECT s.id,CONCAT(s.last_name, ', ',s.first_name,', ',s.middle_name) as full_name FROM staff s INNER JOIN office_staff os ON(os.staff_id=s.id) WHERE os.office_id='$office_id'";
            $data = $this->db->query($query1)->result_array();
        }
        return $data;
    }

    public function get_assigned_task_staff($id) {
//        echo $id;die;
        $query = 'select * from project_template_task where id=' . $id . '';
        $data1 = $this->db->query($query)->row();
        $department_id = $data1->department_id;
        $office_id = $data1->office_id;
//        $staff_id = $data1->staff_id;
        $is_all = $data1->is_all;
        $franc_staff = $data1->responsible_task_staff;
        if ($department_id != 2 && $is_all == 1) {
            return "All Staff";
        }
//        else if ($department_id == 2 && $is_all == 1) {
//            return "All Staff";
//        }
        else if ($department_id != 2 && $is_all == 0) {
            $query = 'select s.id,CONCAT(s.last_name, ", ",s.first_name,", ",s.middle_name) as full_name '
                    . 'from staff s '
                    . 'INNER JOIN project_template_task_staff ptsk ON(ptsk.staff_id=s.id)'
                    . 'where ptsk.task_id=' . $id . '';
            $data2 = $this->db->query($query)->row();
            return $data2->full_name;
        } else if ($department_id == 2 && $franc_staff != '') {
            if ($franc_staff == 1) {
                return "Partner";
            } else if ($franc_staff == 2) {
                return "Manager";
            } else {
                return "Client Association";
            }
        }

//        else if ($department_id == 2 ) {
//            $query1 = "SELECT s.id,CONCAT(s.last_name, ', ',s.first_name,', ',s.middle_name) as full_name FROM staff s INNER JOIN project_template_task_staff ptsk ON(ptsk.staff_id=s.id) WHERE ptsk.task_id='$id'";
//            $data3 = $this->db->query($query1)->row_array();
//            return $data3['full_name'];
//        }
    }

    public function get_assigned_task_department($template_id) {
        $query = 'select * from project_template_task where id=' . $template_id . '';
        $data1 = $this->db->query($query)->row();
        $department_id = $data1->department_id;
//        if ($department_id != 2) {
        $query = "SELECT name FROM department WHERE id=$department_id";
        $data = $this->db->query($query)->row();
        return $data->name;
//        }
//        else {
//            $office_id = $data1->office_id;
//            $query = "SELECT name,office_id FROM office WHERE id=$office_id";
//            $data = $this->db->query($query)->row();
//            return $data->name;
//        }
//        else {
//            $office_id = $data1->responsible_task_staff;
//            $query = "SELECT name FROM staff_type WHERE id=$department_id";
//            $data = $this->db->query($query)->row();
//            return $data->name;
//        }
    }

    public function getTaskNoteCount($task_id) {
        $data = $this->db->get_where('template_task_note', ['task_id' => $task_id])->result_array();
        return count($data);
    }

    public function getProjectTaskNoteCount($task_id) {
        $data = $this->db->get_where('project_task_note', ['task_id' => $task_id])->result_array();
        return count($data);
    }

    public function get_assigned_template_department($template_id) {
        $query = 'select * from project_template_main where id=' . $template_id . '';
        $data1 = $this->db->query($query)->row();
        $department_id = $data1->department_id;
        if ($department_id != 2) {
            $query = "SELECT name FROM department WHERE id=$department_id";
            $data = $this->db->query($query)->row();
            return $data->name;
        } else {
            $office_id = $data1->office_id;
            $query = "SELECT name,office_id FROM office WHERE id=$office_id";
            $data = $this->db->query($query)->row();
            return $data->name;
        }
    }

    public function get_assigned_project_main_department($project_id) {
        $query = 'select * from project_main where project_id=' . $project_id . '';
        $data1 = $this->db->query($query)->row();
        $department_id = $data1->department_id;
        if ($department_id != 2) {
            $query = "SELECT name FROM department WHERE id=$department_id";
            $data = $this->db->query($query)->row();
            return $data->name;
        } else {
            $office_id = $data1->office_id;
            $query = "SELECT name,office_id FROM office WHERE id=$office_id";
            $data = $this->db->query($query)->row();
            return $data->name;
        }
    }

    public function get_assigned_template_office($template_id) {
        $query = 'select office_id from project_template_main where id=' . $template_id . '';
        $data1 = $this->db->query($query)->row();
        $office_id = $data1->office_id;
//        $query = "SELECT name,office_id FROM office WHERE id=$office_id";
        $query = "SELECT * FROM staff_type WHERE id='$office_id'";
        $data = $this->db->query($query)->row();
        $office['name'] = $data->name;
        $office['id'] = $data->id;
        return $office;
    }

    public function get_assigned_project_main_template_office($template_id) {
        $query = 'select office_id from project_main where project_id=' . $template_id . '';
        $data1 = $this->db->query($query)->row();
        $office_id = $data1->office_id;
//        $query = "SELECT name,office_id FROM office WHERE id=$office_id";
        $query = "SELECT * FROM staff_type WHERE id='$office_id'";
        $data = $this->db->query($query)->row();
        $office['name'] = $data->name;
        $office['id'] = $data->id;
        return $office;
    }

    public function get_template_responsible_staff($template_id) {
        $query = 'select office_id from project_template_main where id=' . $template_id . '';
        $data1 = $this->db->query($query)->row();
        $office_id = $data1->office_id;
        $query = "SELECT * FROM staff_type WHERE id=$office_id";
        $data = $this->db->query($query)->row();
        $office['name'] = $data->name;
        $office['id'] = $data->id;
        return $office;
    }

    public function editTemplateMainDetail($template_id) {
        return $this->db->get_where('project_template_main', ['id' => $template_id])->row();
//        $this->db->select("ptm.*,ptsm.staff_id");
//        $this->db->from('project_template_main ptm');
//        $this->db->join('project_template_staff_main ptsm', "ptm.id=ptsm.template_id", 'left');
//        $this->db->where('ptsm.type', 1);
//        $this->db->where('ptm.id', $template_id);
//        return $this->db->get()->row();
    }

    public function editProjectMainDetail($template_id) {
        return $this->db->get_where('project_main', ['project_id' => $template_id])->row();
    }

    public function getTemplateOfficeStaff($template_id) {
        return $this->db->query("SELECT staff_id FROM project_template_staff_main WHERE template_id='$template_id' and type=2")->row();
    }

    public function getProjectOfficeStaff($project_id) {
        return $this->db->query("SELECT staff_id FROM project_staff_main WHERE project_id='$project_id' and type=2")->row();
    }

    public function getTemplateDepartmentStaff($template_id) {
        return $this->db->query("SELECT staff_id FROM project_template_staff_main WHERE template_id='$template_id' and type=1")->row();
    }

    public function getProjectDepartmentStaff($project_id) {
        return $this->db->query("SELECT staff_id FROM project_staff_main WHERE project_id='$project_id' and type=1")->row();
    }

    public function get_related_note_table_by_id_task($related_table_id) {
        $table[1] = 'notes';
        $table[2] = 'action_notes';
        $table[3] = 'lead_notes';
        $table[4] = 'payroll_employee_notes';
        $table[5] = 'payroll_rt6_notes';
        $table[6] = 'marketing_notes';
        $table[7] = 'cart_notes';
        $table[8] = 'template_task_note';
        $table[9] = 'project_note';
        $table[11] = 'project_task_note';
        return $table[$related_table_id];
    }

    public function insert_task_note($related_table_id, $notes_data, $foreign_column, $foreign_value, $reference = "") {
        $table = $this->get_related_note_table_by_id_task($related_table_id);
        $user_id = $this->session->userdata('user_id');
        foreach ($notes_data as $note) {
            if (trim($note) != "") {
                $insert_data[$foreign_column] = $foreign_value;
                $insert_data['note'] = $note;
                if ($related_table_id == 6 || $related_table_id == 7 || $related_table_id == 8 || $related_table_id == 9 || $related_table_id == 11) {
                    $insert_data['added_by_user'] = $user_id;
                }
                if ($related_table_id == 1) {
                    $insert_data['reference'] = $reference;
                }
                $this->db->insert($table, $insert_data);
                $note_id = $this->db->insert_id();
                $this->db->insert("notes_log", ['note_id' => $note_id, 'user_id' => $user_id, 'related_table_id' => $related_table_id, 'date_time' => date('Y-m-d H:i:s')]);
            }
        }
    }

    public function request_edit_template($template_id, $post) {
//        echo "<pre>";
//        print_r($post);
//        die;
        $last_id = $template_id;
        $this->db->trans_begin();
        if (isset($post['template_main']) && !empty($post['template_main'])) {
            $temp_main_ins['added_by_user'] = sess('user_id');
            $temp_main_ins['template_cat_id']=$post['template_main']['template_cat_id'];
            $temp_main_ins['template_id'] = $post['template_main']['Id'];
            $temp_main_ins['title'] = $post['template_main']['title'];
            $temp_main_ins['description'] = $post['template_main']['description'];
            $temp_main_ins['category_id'] = $post['template_main']['service_category'];
            if (isset($post['template_main']['service']) && $post['template_main']['service'] != '') {
                $temp_main_ins['service_id'] = $post['template_main']['service'];
            } else {
                $temp_main_ins['service_id'] = '';
            }
            $temp_main_ins['status'] = $post['template_main']['status'];
            $temp_main_ins['department_id'] = $post['template_main']['department'];
//            $temp_main_ins['ofc_is_all'] = $post['template_main']['ofc_is_all'];
            $temp_main_ins['dept_is_all'] = $post['template_main']['dept_is_all'];
            $temp_main_ins['office_id'] = $post['template_main']['office'];
            if ($temp_main_ins['office_id'] == 3) {
                $temp_main_ins['responsible_staff'] = $post['template_main']['francise_staff'];
                $temp_main_ins['ofc_is_all'] = null;
            }
            if (isset($post['template_main']['responsible_department']) && $post['template_main']['responsible_department'] != '') {
                $temp_main_ins['responsible_department'] = $post['template_main']['responsible_department'];
            }
            if (isset($post['template_main']['is_all']) && $post['template_main']['is_all'] != '') {
                $temp_main_ins['ofc_is_all'] = $post['template_main']['is_all'];
            }
            $template_staff_list = $this->get_department_staff_by_department_id($post['template_main']['department']);
//            if (isset($post['template_main']['partner']) && $post['template_main']['partner'] != '' && ($post['template_main']['ofc_is_all']) != 1) {
//                $temp_main_ins['partner_id'] = $post['template_main']['partner'];
//            } else {
//                $temp_main_ins['partner_id'] = null;
//            }
//            if (isset($post['template_main']['manager']) && $post['template_main']['manager'] != '' && ($post['template_main']['ofc_is_all']) != 1) {
//                $temp_main_ins['manager_id'] = $post['template_main']['manager'];
//            } else {
//                $temp_main_ins['manager_id'] = null;
//            }
//            if (isset($post['template_main']['associate']) && $post['template_main']['associate'] != '' && ($post['template_main']['ofc_is_all']) != 1) {
//                $temp_main_ins['associate_id'] = $post['template_main']['associate'];
//            } else {
//                $temp_main_ins['associate_id'] = null;
//            }
//            echo "<pre>";
//            print_r($temp_main_ins);die;
            $this->db->where('id', $template_id);
            $this->db->update('project_template_main', $temp_main_ins);
//            $last_id = $this->db->insert_id();
//            echo $template_id;die;
//            echo $post['template_main']['staff'];die;
            $this->db->where('template_id', $template_id);
            $this->db->delete('project_template_staff_main');
            if (isset($post['template_main']['department_staff']) && !empty($post['template_main']['department_staff']) && ($post['template_main']['dept_is_all']) != 1) {
//              
                foreach ($post['template_main']['department_staff'] as $ins_staff_id) {

                    $this->db->insert('project_template_staff_main', ['template_id' => $template_id, 'staff_id' => $ins_staff_id, 'type' => 1]);
                }
            }
            if (isset($post['template_main']['res_dept_staff']) && !empty($post['template_main']['res_dept_staff'])) {
//                $this->db->where('template_id', $template_id);
//                $this->db->delete('project_template_staff_main');
                foreach ($post['template_main']['res_dept_staff'] as $ins_offic_id) {

                    $this->db->insert('project_template_staff_main', ['template_id' => $template_id, 'staff_id' => $ins_offic_id, 'type' => 2]);
                }
            }
            if ($temp_main_ins['dept_is_all'] == 1 && !empty($template_staff_list)) {
//                echo "a";die;
                foreach ($template_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_template_staff_main', ['template_id' => $template_id, 'staff_id' => $staffId, 'type' => 1]);
                }
//                echo $this->db->last_query();
            }
            $template_responsible_list = $this->get_department_staff_by_department_id($post['template_main']['office']);
            if ($temp_main_ins['ofc_is_all'] == 1 && !empty($template_responsible_list)) {
                foreach ($template_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_template_staff_main', ['template_id' => $template_id, 'staff_id' => $staffId, 'type' => 2]);
                }
            }
        }
        if (isset($post['recurrence']) && !empty($post['recurrence']) && $last_id != '') {
            $this->db->where('template_id', $template_id);
            $this->db->delete('project_template_recurrence_main');
            $ins_recurrence = [];
            $ins_recurrence['template_id'] = $template_id;
            foreach ($post['recurrence'] as $key => $val) {
                $ins_recurrence[$key] = $val;
            }
            if ($ins_recurrence['pattern'] == 'annually' || $ins_recurrence['pattern'] == 'none') {
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = $ins_recurrence['due_month'];
                $current_month=date('m');
                $current_day=date('d');
                if($ins_recurrence['due_month']>=$current_month && $ins_recurrence['due_day']>=$current_day){
                    $ins_recurrence['actual_due_year'] = date('Y');
                }else{
                    $ins_recurrence['actual_due_year'] = date('Y')+1;
                }
            } elseif ($ins_recurrence['pattern'] == 'monthly') {
                $current_month = date('m');
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = (int) $current_month + (int) $ins_recurrence['due_month'];
                if($ins_recurrence['actual_due_day']>=date('d')){
                    if($ins_recurrence['actual_due_month']<=12){
                        $ins_recurrence['actual_due_year'] = date('Y');
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y');
                    }
                }else{
                   if($ins_recurrence['actual_due_month']<=12){
                        $ins_recurrence['actual_due_year'] = date('Y');
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y')+($ins_recurrence['actual_due_month']/12);
                    } 
                }
            } elseif ($ins_recurrence['pattern'] == 'weekly') {
                $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
                $current_day = $day_array[$ins_recurrence['due_month']];
                $givenDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $ins_recurrence['due_day'], date('Y')));
                $ins_recurrence['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
                $ins_recurrence['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
                $ins_recurrence['actual_due_year'] = date('Y');
            } elseif ($ins_recurrence['pattern'] == 'quarterly') {
                $current_month = date('m');
                if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                    $next_quarter[1] = '4';
                    $next_quarter[2] = '5';
                    $next_quarter[3] = '6';
                    $due_year = date('Y');
                } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
                    $next_quarter[1] = '7';
                    $next_quarter[2] = '8';
                    $next_quarter[3] = '9';
                    $due_year = date('Y');
                } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
                    $next_quarter[1] = '10';
                    $next_quarter[2] = '11';
                    $next_quarter[3] = '12';
                    $due_year = date('Y');
                } else {
                    $next_quarter[1] = '1';
                    $next_quarter[2] = '2';
                    $next_quarter[3] = '3';
                    $due_year = date('Y', strtotime('+1 year'));
                }
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = $next_quarter[$ins_recurrence['due_month']];
                $ins_recurrence['actual_due_year'] = $due_year;
            }elseif($ins_recurrence['pattern']=='periodic'){
                $current_month = date('m');
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = (int) $ins_recurrence['due_month'];
                if($ins_recurrence['actual_due_day']>=date('d')){
                    if($ins_recurrence['actual_due_month']<$current_month){
                        $ins_recurrence['actual_due_year'] = date('Y', strtotime('+1 year'));
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y');
                    }
                }else{
                   if($ins_recurrence['actual_due_month']<=$current_month){
                        $ins_recurrence['actual_due_year'] = date('Y', strtotime('+1 year'));
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y');
                    } 
                }
                $periodic_day= json_decode($ins_recurrence['periodic_due_day']);
                $periodic_month=json_decode($ins_recurrence['periodic_due_month']);
                unset($ins_recurrence['periodic_due_day']);
                unset($ins_recurrence['periodic_due_month']);
            }
            else {
                $ins_recurrence['actual_due_day'] = '0';
                $ins_recurrence['actual_due_month'] = '0';
                $ins_recurrence['actual_due_year'] = '0';
            }
            unset($ins_recurrence['periodic_due_day']);
            unset($ins_recurrence['periodic_due_month']);
//            print_r($ins_recurrence);die;
            $this->db->insert('project_template_recurrence_main', $ins_recurrence);
            if(isset($periodic_day) && !empty($periodic_day)){
                $this->db->where('template_id',$template_id);
                $this->db->delete('template_periodic_pattern');
                $periodic_count=count($periodic_day);
                $periodic_day_array=array();
                $i=0;
                foreach ($periodic_day as $value) {
                    $periodic_day_array[]=$i.'_'.$value;
                    $i++;
                }
                $new_val= array_combine($periodic_day_array,$periodic_month);
                foreach($new_val as $day=>$month){
                    $periodic_data=array();
                    $current_month = date('m');
                    $exp1=explode('_',$day);
                    $day=$exp1[1];
                    $actual_due_day = $day;
                    $actual_due_month = $month;
                    if($actual_due_day>=date('d')){
                        if($actual_due_month<$current_month){
                            $actual_due_year = date('Y', strtotime('+1 year'));
                        }else{
                            $actual_due_year=date('Y');
                        }
                    }else{
                       if($actual_due_month<=$current_month){
                            $actual_due_year = date('Y', strtotime('+1 year'));
                        }else{
                            $actual_due_year=date('Y');
                        } 
                    }
                    $periodic_data=array(
                        'template_id'=>$template_id,
                        'due_day'=>$day,
                        'due_month'=>$month,
                        'actual_due_day'=>$actual_due_day,
                        'actual_due_month'=>$actual_due_month,
                        'actual_due_year'=>$actual_due_year
                    );
                    $this->db->insert('template_periodic_pattern',$periodic_data);
                }
                
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $template_id;
        }
    }

    function getTemplatePatternValue($template_id) {
        $data = $this->db->get_where('project_template_recurrence_main', ['template_id' => $template_id])->row();
        return $data;
    }

    function getProjectPatternValue($template_id) {
        $data = $this->db->get_where('project_recurrence_main', ['project_id' => $template_id])->row();
        return $data;
    }

    function get_pattern_details($template_id) {
        return $this->db->get_where('project_template_recurrence_main', ['template_id' => $template_id])->row();
    }

    function get_project_pattern_details($project_id) {
        return $this->db->get_where('project_recurrence_main', ['project_id' => $project_id])->row();
    }

    function get_department_staff_by_department_id($department_id) {
        $staff_info = staff_info();
        $this->db->select("st.id, concat(st.last_name, ', ', st.first_name, ' ',st.middle_name) as name");
        $this->db->from("staff st");
        $this->db->join("department_staff dprt", "st.id = dprt.staff_id");
        $this->db->where("dprt.department_id", $department_id);
        $this->db->where("st.status", '1');
        $this->db->where('st.first_name is NOT NULL', NULL, FALSE);
        $this->db->where('st.middle_name is NOT NULL', NULL, FALSE);
        $this->db->where('st.last_name is NOT NULL', NULL, FALSE);
        $r = $this->db->get()->result_array();
        return $r;
    }

    function getOfficeList() {
        return $this->db->query("SELECT * FROM office WHERE type=2")->result_array();
    }

    public function get_office_staff_by_department_id($department_id, $office_id = '') {
        return $this->db->query("SELECT st.id, concat(st.last_name, ', ', st.first_name, ' ',st.middle_name) as name FROM staff st INNER JOIN office_staff ofc ON(st.id = ofc.staff_id) WHERE st.status=1 and st.first_name is NOT NULL and st.middle_name is NOT NULL and st.last_name is NOT NULL and ofc.office_id='$office_id'")->result_array();
    }

    function getTemplateTaskDetails($task_id) {
        return $this->db->get_where('project_template_task', ['id' => $task_id])->row();
    }

    function getProjectTaskDetails($task_id) {
        return $this->db->get_where('project_task', ['id' => $task_id])->row();
    }

    function getTaskStaffList($task_id) {
        $data = $this->db->get_where('project_template_task_staff', ['task_id' => $task_id])->row();
        if (!empty($data)) {
            return $data->staff_id;
        } else {
            return '';
        }
    }

    function getProjectTaskStaffList($task_id) {
        $data = $this->db->get_where('project_task_staff', ['task_id' => $task_id])->row();
        if (!empty($data)) {
            return $data->staff_id;
        } else {
            return '';
        }
    }

    public function get_client_fye($ref_id) {
        $data = $this->db->get_where('company', ['id' => $ref_id])->row_array();
        if (!empty($data)) {
            return $data['fye'];
        } else {
            return '';
        }
    }

    function requestCreateProject($post) {
        $this->db->trans_begin();
//        print_r($post);die;
        $project_client_ids = $post['project']['client_id'];
        if (!empty($project_client_ids)) {
            foreach ($project_client_ids as $pcid) {

                $project = $post['project'];
                if (isset($project['office_id']) && $project['office_id'] != '') {
                    $post['project']['office_id'] = $project['office_id'];
                }
                $client_office=$this->db->get_where('internal_data',['reference_id'=>$pcid])->row();
                if(!empty($client_office)){
                    $post['project']['office_id']=$client_office->office;
                }
                $post['project']['client_id'] = $pcid;
                if(isset($post['project']['created_at']) && $post['project']['created_at']!=''){
                    $creation_date=$post['project']['created_at'];
                    if(date('Y-m-d')!=date('Y-m-d',strtotime($creation_date))){
                        $post['project']['created_at']=date('Y-m-d',strtotime($creation_date));
                    }else{
                        $post['project']['created_at']=date('Y-m-d',strtotime($creation_date));
                    }
                }else{
                    $post['project']['created_at']=date('Y-m-d');
                }
                $this->db->insert('projects', $post['project']);
                $insert_id = $this->db->insert_id();
                $notedata = $this->input->post('project_note');
                $this->insert_task_note(9, $notedata, "project_id", $insert_id, 'project');

                $client_reference_id = $post['project']['client_id'];

                $project_template_id = $post['project']['template_id'];

                $project_main_data = $this->db->get_where('project_template_main', ['id' => $project_template_id])->row_array();
                $project_recurrence_main_data = $this->db->get_where('project_template_recurrence_main', ['template_id' => $project_template_id])->row_array();
                $project_task_data = $this->db->get_where('project_template_task', ['template_main_id' => $project_template_id])->result_array();
                $project_recurrence_periodic_data=$this->db->get_where('template_periodic_pattern',['template_id'=>$project_template_id])->result_array();
//                echo"<pre>";
//                print_r($project_recurrence_periodic_data);
                $project_staff_main_data = $this->db->get_where('project_template_staff_main', ['template_id' => $project_template_id])->result_array();
//              print_r($project_staff_main_data);die;
                $end_array = end($project_staff_main_data);
                $last_key = key($project_staff_main_data);
                $new_key = (int) $last_key + 1;
                if (isset($project_main_data) && !empty($project_main_data)) {
                    unset($project_main_data['id']);
                    $project_main_data['project_id'] = $insert_id;
                    $project_main_data['added_by_user'] = sess('user_id');
                    $this->db->set($project_main_data);
                    $this->db->insert('project_main', $project_main_data);
                }
                //get partner or manager id for project responsible staff 
                $this->db->select('p.client_id,p.client_type,pm.office_id,pm.responsible_staff');
                $this->db->from('projects AS p');
                $this->db->join('project_main AS pm', 'p.id=pm.project_id', 'inner');
                $this->db->where('project_id', $insert_id);
                $manage_result = $this->db->get()->row();
                $res = $this->db->get_where('internal_data', ['reference_id' => $manage_result->client_id])->row();

                if ($manage_result->office_id == 3 && $manage_result->responsible_staff == 1) {
                    $partner_id = $res->partner;
                }
                if ($manage_result->office_id == 3 && $manage_result->responsible_staff == 2) {
                    $manager_id = $res->manager;
                }

                if (isset($partner_id) && $partner_id != '') {
                    $project_staff_main_data[$new_key]['id'] = '';
                    $project_staff_main_data[$new_key]['template_id'] = $project_staff_main_data[0]['template_id'];
                    $project_staff_main_data[$new_key]['staff_id'] = $partner_id;
                    $project_staff_main_data[$new_key]['type'] = $project_staff_main_data[0]['type'];
                    $project_staff_main_data[$new_key]['created_at'] = $project_staff_main_data[0]['created_at'];
                }
                if (isset($manager_id) && $manager_id != '') {
                    $project_staff_main_data[$new_key]['id'] = '';
                    $project_staff_main_data[$new_key]['template_id'] = $project_staff_main_data[0]['template_id'];
                    $project_staff_main_data[$new_key]['staff_id'] = $manager_id;
                    $project_staff_main_data[$new_key]['type'] = $project_staff_main_data[0]['type'];
                    $project_staff_main_data[$new_key]['created_at'] = $project_staff_main_data[0]['created_at'];
                }
                //end finding partner or manager
                $project_date=$this->db->get_where('projects',['id'=>$insert_id])->row()->created_at;
                if (isset($project_recurrence_main_data) && !empty($project_recurrence_main_data)) {
                    if ($project_recurrence_main_data['client_fiscal_year_end'] == 1) {
                        $get_client_fye = get_client_fye($client_reference_id);
                        if ($project_recurrence_main_data['fye_type'] == 1) {

                            $get_project_creation_date = $this->db->get_where('projects', ['id' => $insert_id])->row_array();
                            $creation_date = date('Y-m-d',strtotime($project_date));

                            $fye_day = $project_recurrence_main_data['fye_day'];
                            $fye_is_weekday = $project_recurrence_main_data['fye_is_weekday'];
                            $fye_month = $project_recurrence_main_data['fye_month'];

                            $after_days = (int) $fye_month * 30;
                            $current_due = $project_recurrence_main_data['actual_due_year'] . '-' . $get_client_fye;

                            $newDate = strtotime($current_due . ' + ' . $after_days . ' days');

                            $project_recurrence_main_data['actual_due_day'] = $fye_day;
                            $project_recurrence_main_data['actual_due_month'] = date('m', $newDate);
                            $project_recurrence_main_data['actual_due_year'] = date('Y', $newDate);
                            
                            if($project_recurrence_main_data['actual_due_month']<=12){
                                $due_date = $project_recurrence_main_data['actual_due_year'] . '-' . $project_recurrence_main_data['actual_due_month'] . '-' . $project_recurrence_main_data['actual_due_day'];
                            }else{
                                $due_date = $project_recurrence_main_data['actual_due_year'] . '-' .($project_recurrence_main_data['actual_due_month'] % 12).'-' . $project_recurrence_main_data['actual_due_day'];
                            }

                            if ($due_date <= $creation_date) {
                                $project_recurrence_main_data['actual_due_year'] = $project_recurrence_main_data['actual_due_year'] + 1;
                            }
                        }
                    }
//                    day month and year creation
                            unset($project_recurrence_main_data['actual_due_day']);
                            unset($project_recurrence_main_data['actual_due_month']);
                            unset($project_recurrence_main_data['actual_due_year']);
                            if ($project_recurrence_main_data['pattern'] == 'annually' || $project_recurrence_main_data['pattern'] == 'none') {
                                $project_recurrence_main_data['actual_due_day'] = $project_recurrence_main_data['due_day'];
                                $project_recurrence_main_data['actual_due_month'] = $project_recurrence_main_data['due_month'];
                                $current_month=date('m',strtotime($project_recurrence_main_data['created_at']));
                                $current_day=date('d',strtotime($project_recurrence_main_data['created_at']));
                                if($project_recurrence_main_data['due_month']>=$current_month && $project_recurrence_main_data['due_day']>=$current_day){
                                    $project_recurrence_main_data['actual_due_year'] = date('Y');
                                }else{
                                    $project_recurrence_main_data['actual_due_year'] = date('Y')+1;
                                }
                            }
                            
                            elseif ($project_recurrence_main_data['pattern'] == 'monthly') {
                                
                                $current_month=date('m',strtotime($project_date));
                                $current_day=date('d',strtotime($project_date));
                                $project_recurrence_main_data['actual_due_day'] = $project_recurrence_main_data['due_day'];
                                $project_recurrence_main_data['actual_due_month'] = (int) $current_month + (int) $project_recurrence_main_data['due_month'];
                                 if($project_recurrence_main_data['due_day']>=$current_day){
                                    
                                    if($project_recurrence_main_data['actual_due_month']<=12){
                                        $project_recurrence_main_data['actual_due_year'] = date('Y');
                                    }else{
                                        $project_recurrence_main_data['actual_due_year']=date('Y')+1;
                                    }
                                }else{
                                    
                                   if($project_recurrence_main_data['actual_due_month']<=12){
                                        $project_recurrence_main_data['actual_due_year'] = date('Y');
                                    }else{
                                        $year=intdiv($project_recurrence_main_data['actual_due_month'],12);
                                        $project_recurrence_main_data['actual_due_year']=date('Y')+$year;
                                    } 
                                }
                            }
                            
                            elseif ($project_recurrence_main_data['pattern'] == 'weekly') {
                                $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
                                $current_day = $day_array[$project_recurrence_main_data['due_month']];
                                $current_months=date('m',strtotime($project_date));
                                $current_days=date('d',strtotime($project_date));
                                $givenDate = date('Y-m-d', mktime(0, 0, 0, $current_months,$current_days + $project_recurrence_main_data['due_day'], date('Y')));
                                $project_recurrence_main_data['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
                                $project_recurrence_main_data['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
                                $project_recurrence_main_data['actual_due_year'] = date('Y');
                            } elseif ($project_recurrence_main_data['pattern'] == 'quarterly') {
//                                $current_month = date('m');
                                $current_month=date('m',strtotime($project_date));
                                $current_day=date('d',strtotime($project_date));
                                if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                                    $next_quarter[1] = '4';
                                    $next_quarter[2] = '5';
                                    $next_quarter[3] = '6';
                                    $due_year = date('Y');
                                } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
                                    $next_quarter[1] = '7';
                                    $next_quarter[2] = '8';
                                    $next_quarter[3] = '9';
                                    $due_year = date('Y');
                                } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
                                    $next_quarter[1] = '10';
                                    $next_quarter[2] = '11';
                                    $next_quarter[3] = '12';
                                    $due_year = date('Y');
                                } else {
                                    $next_quarter[1] = '1';
                                    $next_quarter[2] = '2';
                                    $next_quarter[3] = '3';
                                    $due_year = date('Y', strtotime('+1 year'));
                                }
                                $project_recurrence_main_data['actual_due_day'] = $project_recurrence_main_data['due_day'];
                                $project_recurrence_main_data['actual_due_month'] = $next_quarter[$project_recurrence_main_data['due_month']];
                                $project_recurrence_main_data['actual_due_year'] = $due_year;
                            }elseif($project_recurrence_main_data['pattern']=='periodic'){
//                                $current_month = date('m');
                                $current_month=date('m',strtotime($project_date));
                                $current_day=date('d',strtotime($project_date));
                                $project_recurrence_main_data['actual_due_day'] = $project_recurrence_main_data['due_day'];
                                $project_recurrence_main_data['actual_due_month'] = (int) $project_recurrence_main_data['due_month'];
                                if($project_recurrence_main_data['actual_due_day']>=$current_day){
                                    if($project_recurrence_main_data['actual_due_month']<$current_month){
                                        $project_recurrence_main_data['actual_due_year'] = date('Y', strtotime('+1 year'));
                                    }else{
                                        $project_recurrence_main_data['actual_due_year']=date('Y');
                                    }
                                }else{
                                   if($project_recurrence_main_data['actual_due_month']<=$current_month){
                                        $project_recurrence_main_data['actual_due_year'] = date('Y', strtotime('+1 year'));
                                    }else{
                                        $project_recurrence_main_data['actual_due_year']=date('Y');
                                    } 
                                }
//                                $periodic_day= json_decode($project_recurrence_main_data['periodic_due_day']);
//                                $periodic_month=json_decode($project_recurrence_main_data['periodic_due_month']);
//                                unset($project_recurrence_main_data['periodic_due_day']);
//                                unset($project_recurrence_main_data['periodic_due_month']);
                            }
                            else {
                                $project_recurrence_main_data['actual_due_day'] = '0';
                                $project_recurrence_main_data['actual_due_month'] = '0';
                                $project_recurrence_main_data['actual_due_year'] = '0';
                            }
//                            end of new date 
//                            echo $project_recurrence_main_data['actual_due_month'];die;
                    if ($project_recurrence_main_data['pattern'] == 'monthly') {
//                        $cur_day = date('d');
                        $cur_month=date('m',strtotime($project_date));
                        $cur_day=date('d',strtotime($project_date));
                        if ($cur_day <= $project_recurrence_main_data['actual_due_day']) {
                            if($cur_month<=$project_recurrence_main_data['actual_due_month']){
                                $project_recurrence_main_data['actual_due_month'] = $cur_month;
                            }else{
                                $project_recurrence_main_data['actual_due_month']=$project_recurrence_main_data['actual_due_month'];
                            }
                        }else{
                            if($cur_month<=$project_recurrence_main_data['actual_due_month']){
                                $project_recurrence_main_data['actual_due_month'] = $project_recurrence_main_data['actual_due_month'];
                            }else{
                                $project_recurrence_main_data['actual_due_month']=$cur_month;
                            }
                        }
                    }
                    unset($project_recurrence_main_data['id']);
                    if($project_recurrence_main_data['actual_due_month']<=12){
                                $due_date = $project_recurrence_main_data['actual_due_year'] . '-' . $project_recurrence_main_data['actual_due_month'] . '-' . $project_recurrence_main_data['actual_due_day'];
                            }else{
                                $due_date = $project_recurrence_main_data['actual_due_year'] . '-' .($project_recurrence_main_data['actual_due_month'] % 12).'-' . $project_recurrence_main_data['actual_due_day'];
                            }
                    if ($project_recurrence_main_data['generation_month'] == '') {
                        $project_recurrence_main_data['generation_month'] = '0';
                    }

                    if ($project_recurrence_main_data['generation_day'] == '') {
                        $project_recurrence_main_data['generation_day'] = '0';
                    }
                    $generation_days = ((int) $project_recurrence_main_data['generation_month'] * 30) + (int) $project_recurrence_main_data['generation_day'];

                    $project_recurrence_main_data['due_date'] = $due_date;
//                    echo $due_date;die;
                    if ($project_recurrence_main_data['pattern'] == 'monthly') {
                        $next_due_date = date("Y-m-d", strtotime("+1 month", strtotime($due_date)));
                        $project_recurrence_main_data['next_due_date'] = $next_due_date;
                    } elseif ($project_recurrence_main_data['pattern'] == 'annually') {
                        $next_due_date = date("Y-m-d", strtotime("+1 year", strtotime($due_date)));
                        $project_recurrence_main_data['next_due_date'] = $next_due_date;
                    } elseif ($project_recurrence_main_data['pattern'] == 'weekly') {
                        $next_due_date = date("Y-m-d", strtotime("+7 days", strtotime($due_date)));
                        $project_recurrence_main_data['next_due_date'] = $next_due_date;
                    } elseif ($project_recurrence_main_data['pattern'] == 'quarterly') {
                        $next_due_date = date("Y-m-d", strtotime("+3 months", strtotime($due_date)));
                        $project_recurrence_main_data['next_due_date'] = $next_due_date;
                    }elseif ($project_recurrence_main_data['pattern'] == 'periodic') {
                        $next_due_date = '0000-00-00';
                        $project_recurrence_main_data['next_due_date'] = $next_due_date;
                    }
                    else {
                        $project_recurrence_main_data['next_due_date'] = '0000-00-00';
                    }
                    if($project_recurrence_main_data['generation_type']==2 ||$project_recurrence_main_data['pattern']=='periodic'){
                        $generation_date =NULL;
                    }else{
                        $generation_date = date('Y-m-d', strtotime('-' . $generation_days . ' days', strtotime($project_recurrence_main_data['next_due_date'])));
                    }
                    $project_recurrence_main_data['generation_date'] = $generation_date;
                    $project_recurrence_main_data['project_id'] = $insert_id;
                    $this->db->set($project_recurrence_main_data);
                    $this->db->insert('project_recurrence_main', $project_recurrence_main_data);
                }
                if(isset($project_recurrence_periodic_data) && !empty($project_recurrence_periodic_data)){
                    foreach($project_recurrence_periodic_data as $periodic_data){
                        unset($periodic_data['id']);
                        unset($periodic_data['template_id']);
                        $current_month=date('m',strtotime($project_date));
                        $current_day=date('d',strtotime($project_date));
                        if($periodic_data['due_day']>=$current_day){
                            if($periodic_data['due_month']<$current_month){
                                $periodic_data['actual_due_year'] = date('Y', strtotime('+1 year'));
                            }else{
                                $periodic_data['actual_due_year']=date('Y');
                            }
                        }else{
                           if($periodic_data['due_month']<=$current_month){
                                $periodic_data['actual_due_year'] = date('Y', strtotime('+1 year'));
                            }else{
                                $periodic_data['actual_due_year']=date('Y');
                            } 
                        }
                        if($periodic_data['due_day'])
                        $recurrence_periodic_data['template_id']=$project_template_id;
                        $recurrence_periodic_data['project_id']=$insert_id;
                        $recurrence_periodic_data['due_day']=$periodic_data['due_day'];
                        $recurrence_periodic_data['due_month']=$periodic_data['due_month'];
                        $recurrence_periodic_data['actual_due_day']=$periodic_data['actual_due_day'];
                        $recurrence_periodic_data['actual_due_month']=$periodic_data['actual_due_month'];
                        $recurrence_periodic_data['actual_due_year']=$periodic_data['actual_due_year'];
                        $this->db->insert('project_periodic_pattern',$recurrence_periodic_data);
                        $periodic_id=$this->db->insert_id();
                    }
                }
//                create due date for various periodic date
                if(isset($project_recurrence_main_data) && !empty($project_recurrence_main_data) && isset($project_recurrence_periodic_data) && !empty($project_recurrence_periodic_data) && $project_recurrence_main_data['pattern'] == 'periodic'){
                   $cur_year=date('Y',strtotime($project_date));
                   $due_year=$project_recurrence_main_data['actual_due_year'];
                   if($due_year > $cur_year){
                        $due_date_details= $this->db->get_where('project_periodic_pattern',['project_id'=>$insert_id,'is_created'=>'n'])->row();
                        $due_date=$due_date_details->actual_due_year.'-'.$due_date_details->actual_due_month.'-'.$due_date_details->actual_due_day;
                        $this->db->where('project_id',$insert_id);
                        $this->db->update('project_recurrence_main',['due_date'=>$due_date]);
                        $this->db->where(['project_id'=>$insert_id,'id'=>$due_date_details->id]);
                        $this->db->update('project_periodic_pattern',['is_created'=>'y']);
                        $next_due_date_details= $this->db->get_where('project_periodic_pattern',['project_id'=>$insert_id,'is_created'=>'n'])->row();
                        $next_due_date=$next_due_date_details->actual_due_year.'-'.$next_due_date_details->actual_due_month.'-'.$next_due_date_details->actual_due_day;
                        if($project_recurrence_main_data['generation_type']==2){
                            $generation_date =NULL;
                        }else{
                            $generation_date = date('Y-m-d', strtotime('-' . $generation_days . ' days', strtotime($next_due_date)));
                        }
                        $this->db->where('project_id',$insert_id);
                        $this->db->update('project_recurrence_main',['next_due_date'=>$next_due_date,'generation_date'=>$generation_date]);
                    }
                    else{
                        $next_due_date_details= $this->db->get_where('project_periodic_pattern',['project_id'=>$insert_id,'is_created'=>'n'])->row();
                        $next_due_date=$next_due_date_details->actual_due_year.'-'.$next_due_date_details->actual_due_month.'-'.$next_due_date_details->actual_due_day;
                        if($project_recurrence_main_data['generation_type']==2){
                            $generation_date =NULL;
                        }else{
                            $generation_date = date('Y-m-d', strtotime('-' . $generation_days . ' days', strtotime($next_due_date)));
                        }
                        $this->db->where('project_id',$insert_id);
                        $this->db->update('project_recurrence_main',['next_due_date'=>$next_due_date,'generation_date'=>$generation_date]);
                        $this->db->where(['project_id'=>$insert_id,'id'=>$next_due_date_details->id]);
                        $this->db->update('project_periodic_pattern',['is_created'=>'y']);
                    }
                }
                if (isset($project_task_data) && !empty($project_task_data)) {
                    $tid = [];
                    foreach ($project_task_data as $key => $val) {
                        $this->db->where('task_id', $val['id']);
                        $note_data = $this->db->get('template_task_note')->result_array();
                        $this->db->where('task_id', $val['id']);
                        $project_task_staff_data = $this->db->get('project_template_task_staff')->result_array();
                        unset($val['id']);
                        $val['project_id'] = $insert_id;
                        $this->db->insert('project_task', $val);
                        $project_task_id = $this->db->insert_id();
                        $tid[$key] = $project_task_id;
                        if (!empty($note_data)) {
                            foreach ($note_data as $key => $nd) {
                                unset($nd['id']);
                                unset($nd['task_id']);
                                unset($nd['template_id']);
                                unset($nd['created_at']);
                                unset($nd['read_status']);
                                unset($nd['added_by_user']);
                                $this->insert_task_note(11, $nd, "task_id", $project_task_id, 'task');
                            }
                        }
                        if (isset($project_task_staff_data) && !empty($project_task_staff_data)) {
                            if ($this->db->get_where('project_task_staff', ['task_id' => $project_task_id])->num_rows() == '0') {
                                foreach ($project_task_staff_data as $key => $val1) {
                                    unset($val1['id']);
                                    unset($val1['task_id']);
                                    $val1['task_id'] = $project_task_id;
                                    $this->db->set($val1);
                                    $this->db->insert('project_task_staff', $val1);
                                }
                            }
                        }
                    }
                }
                // Find partner or manager for project task for assign.
                $this->db->select('p.client_id,p.client_type,pt.id,pt.department_id,pt.responsible_task_staff');
                $this->db->from('projects AS p');
                $this->db->join('project_task AS pt', 'p.id=pt.project_id', 'inner');
                $this->db->where('project_id', $insert_id);
                $manage_result1 = $this->db->get()->result_array();
                if(isset($project_task_staff_data)){
                    $end_array1 = end($project_task_staff_data);
                    $last_key1 = key($project_task_staff_data);
                }
//        if($last_key!=''){
//        $new_key1=(int)$last_key+1;
//        }else{
//            $new_key1=(int)+0;
//        }
                if (empty($project_task_staff_data)) {
                    $new_key1 = (int) +0;
                    foreach ($manage_result1 as $key1 => $mng_result) {
                        $res = $this->db->get_where('internal_data', ['reference_id' => $mng_result['client_id']])->row();

                        if ($mng_result['department_id'] == 2 && $mng_result['responsible_task_staff'] == 1) {
                            $partner_id = $res->partner;
                        }
                        if ($mng_result['department_id'] == 2 && $mng_result['responsible_task_staff'] == 2) {
                            $manager_id = $res->manager;
                        }

                        if (isset($partner_id) && $partner_id != '') {
                            $project_task_staff_data[$new_key1]['id'] = '';
                            $project_task_staff_data[$new_key1]['task_id'] = $mng_result['id'];
                            $project_task_staff_data[$new_key1]['staff_id'] = $partner_id;
                            $project_task_staff_data[$new_key1]['created_at'] = $project_staff_main_data[0]['created_at'];
                        }
                        if (isset($manager_id) && $manager_id != '') {
                            $project_task_staff_data[$new_key1]['id'] = '';
                            $project_task_staff_data[$new_key1]['task_id'] = $mng_result['id'];
                            $project_task_staff_data[$new_key1]['staff_id'] = $manager_id;
                            $project_task_staff_data[$new_key1]['created_at'] = $project_staff_main_data[0]['created_at'];
                        }
                        $new_key1++;
                    }
                }

//        echo "<pre>";
//        print_r($project_task_staff_data);
//        echo "</pre>";die;
                if (isset($project_staff_main_data) && !empty($project_staff_main_data)) {
                    foreach ($project_staff_main_data as $val) {
                        unset($val['id']);
                        $val['project_id'] = $insert_id;
                        $this->db->set($val);
                        $this->db->insert('project_staff_main', $val);
                    }
                }

//        echo $tid[$key];
//        print_r($project_task_notes);
//        die;
            } //end project_client_id forach
        }  //end project_client_id empty checking
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    function getProjectList() {
        $this->db->order_by('id', 'desc');
        return $this->db->get('projects')->result_array();
    }

    function getTemplateDetailsById($id) {
        return $this->db->get_where('project_main', ['project_id' => $id]);
    }

    public function getProjectNoteCount($project_id) {
        $data = $this->db->get_where('project_note', ['project_id' => $project_id])->result_array();
        return count($data);
    }

    public function getProjectClient($office_id) {
        $this->db->select('office_id');
        $data = $this->db->get_where('office', ['id' => $office_id])->row();
        return $data->office_id;
    }

    public function getProjectClientName($client_id, $client_type, $office_id = '') {
        if ($client_type == 1) {
            $this->db->select('name');
            $data = $this->db->get_where('company', ['id' => $client_id])->row();
            return $data->name;
        } else {
//            echo $client_id;13859
            $this->db->select("CONCAT(COALESCE(i.last_name,''), ', ',COALESCE(i.first_name,''), ' ',COALESCE(i.middle_name,'')) as name");
            $this->db->join('title t', 't.individual_id=i.id', 'inner');
            $data = $this->db->get_where('individual i', ['t.id' => $client_id])->row();
            return $data->name;
        }
    }

    public function getProjectDetails($project_id) {
        return $this->db->get_where('projects', ['id' => $project_id])->row();
    }

    function requestUpdateProject($project_id, $post) {
        $this->db->trans_begin();
//        print_r($post);die;
        if (isset($post['project']['template_id']) && $post['project']['template_id'] != '') {
            unset($post['project']['template_id']);
        }
        $project = $post['project'];
        if (isset($project['office_id']) && $project['office_id'] != '') {
            $post['project']['office_id'] = $project['office_id'];
        }
        $this->db->where('id', $project_id);
        $this->db->update('projects', $post['project']);

        $client_reference_id = $post['project']['client_id'];

        $recurrence_data = $this->db->get_where('project_recurrence_main', ['project_id' => $project_id])->row_array();

        $client_fiscal_year_end = $recurrence_data['client_fiscal_year_end'];

        if ($recurrence_data['pattern'] == 'annually') {
            if ($client_fiscal_year_end == 1) {
                $get_client_fye = get_client_fye($client_reference_id);
                if ($recurrence_data['fye_type'] == 1) {
                    $fye_day = $recurrence_data['fye_day'];
                    $fye_is_weekday = $recurrence_data['fye_is_weekday'];
                    $fye_month = $recurrence_data['fye_month'];

                    $get_project_creation_date = $this->db->get_where('projects', ['id' => $project_id])->row_array();
                    $creation_date = strtotime($get_project_creation_date['created_at']);

                    $after_days = (int) $fye_month * 30;

                    // if(strlen($project_recurrence_main_data['actual_due_month'])==1){
                    //     $actual_mnth = '0'.$project_recurrence_main_data['actual_due_month'];
                    // }
                    // if(strlen($project_recurrence_main_data['actual_due_day'])==1){
                    //     $actual_day = '0'.$project_recurrence_main_data['actual_due_day'];
                    // }

                    $current_due = $recurrence_data['actual_due_year'] . '-' . $get_client_fye;

                    $newDate = strtotime($current_due . ' + ' . $after_days . ' days');

                    $actual_due_day = $fye_day;
                    $actual_due_month = date('m', $newDate);
                    $actual_due_year = date('Y', $newDate);

                    $due_date = $actual_due_year . '-' . $actual_due_month . '-' . $actual_due_day;

                    if ($due_date <= $creation_date) {
                        $actual_due_year += 1;
                    }
                }
                //    else{
                //     $fye_day = $project_recurrence_main_data['fye_day'];
                //     $fye_is_weekday = $project_recurrence_main_data['fye_is_weekday'];
                //     $fye_month = $project_recurrence_main_data['fye_month'];
                //     $after_days = (int)$fye_month*2);
                //     if(strlen($project_recurrence_main_data['actual_due_month'])==1){
                //         $actual_mnth = '0'.$project_recurrence_main_data['actual_due_month'];
                //     }
                //     if(strlen($project_recurrence_main_data['actual_due_day'])==1){
                //         $actual_day = '0'.$project_recurrence_main_data['actual_due_day'];
                //     }
                //     $current_due = $project_recurrence_main_data['actual_due_year'].'-'.$actual_mnth.'-'.$actual_day;
                //     $newDate = strtotime('+'.$after_days.' days',$current_due);
                // }
                $this->db->where('project_id', $project_id);
                $this->db->update('project_recurrence_main', array('actual_due_day' => $actual_due_day, 'actual_due_month' => $actual_due_month, 'actual_due_year' => $actual_due_year));
            }
        }

//        $insert_id=$this->db->insert_id();
//        $notedata = $this->input->post('project_note');
//        $this->insert_task_note(9, $notedata, "project_id", $project_id, 'project');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function update_project_task_status($id, $status, $comment) {
        $this->db->trans_begin();

        $this->db->select('COUNT(id) as data_count');
        $this->db->where('stuff_id', $this->session->userdata("user_id"));
        $this->db->where('status_value', $status);
        $this->db->where('section_id', $id);
        $this->db->where('related_table_name', 'project_task');
        $data_count = $this->db->get('tracking_logs')->row_array();
        $project_id=$this->db->get_where('project_task',['id'=>$id])->row()->project_id;
        if ($data_count['data_count'] == 0) {
            $this->db->insert("tracking_logs", ["stuff_id" => $this->session->userdata("user_id"), "status_value" => $status, "section_id" => $id, "related_table_name" => "project_task", "comment" => $comment]);
        }
        $data = ["tracking_description" => $status];
        $get_main_order_query = $this->db->query("SELECT * FROM project_task WHERE id=$id")->result_array();

//        tracking
        $task2='';
        if ($status == 0) {
            $this->db->where('id', $id);
            $this->db->update('project_task', array('date_completed' => date('Y-m-d h:i:s'), 'tracking_description' => 0));
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['project_id'];
            }
            $check_if_all_services_completed = $this->db->query('select * from project_task where project_id="' . $suborder_order_id . '"')->result_array();
            if (!empty($check_if_all_services_completed)) {
                $k = 0;
                $status_array = '';
                $len = count($check_if_all_services_completed);
                foreach ($check_if_all_services_completed as $val) {
                    if ($k == $len - 1) {
                        $status_array .= $val['tracking_description'];
                    } else {
                        $status_array .= $val['tracking_description'] . ',';
                    }
                    $k++;
                }
            }
            $status_array_values = explode(",", $status_array);
            if (!in_array("1", $status_array_values) && !in_array("2", $status_array_values) && !in_array("3", $status_array_values)) {
                $this->db->where('id', $suborder_order_id);
                $this->db->update('project_main', array('status' => 0));
            } else if (!in_array("0", $status_array_values) && !in_array("2", $status_array_values) && !in_array("3", $status_array_values)) {
                $this->db->where('id', $suborder_order_id);
                $this->db->update('project_main', array('status' => 1));
            } else {
                $this->db->where('project_id', $suborder_order_id);
                $this->db->update('project_main', array('status' => 1));
            }
        } elseif ($status == 1) {
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['project_id'];
            }
            $end_date = date('Y-m-d h:i:s');
            $this->db->where('id', $id);
            $this->db->update('project_task', array('date_completed' => $end_date, 'tracking_description' => 1));
            $this->db->where('project_id', $suborder_order_id);
            $this->db->update('project_main', array('status' => 1));
//            this section for 2nd task
            $this->db->select('id');
            $this->db->from('project_task');
            $this->db->where('project_id',$project_id);
            $this->db->where_in('tracking_description',2);
            $get_all_task_ids=$this->db->get()->result_array();
            $old_task_ids= array_column($get_all_task_ids,'id');
//            print_r($old_task_ids);echo "<br>";
            $this->db->select('id');
            $this->db->from('project_task');
            $this->db->where('project_id',$project_id);
            $this->db->where_not_in('tracking_description',[1,2]);
            $get_task_ids=$this->db->get()->result_array();
            $a= array_column($get_task_ids,'id');
//            print_r($a);die;
            if(isset($a[0])){
                if(!in_array($a[0], $old_task_ids)){
                    $task2=$a[0];
                    $end_date = date('Y-m-d h:i:s');
                    $this->db->where('id', $task2);
                    $this->db->update('project_task', array('date_completed' => $end_date, 'tracking_description' => 0));
                }
            }
        }elseif ($status == 3) {
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['project_id'];
            }
            $end_date = date('Y-m-d h:i:s');
            $this->db->where('id', $id);
            $this->db->update('project_task', array('date_completed' => $end_date, 'tracking_description' => 3));
            $this->db->where('project_id', $suborder_order_id);
            $this->db->update('project_main', array('status' => 0));
        }
        elseif ($status == 4) {
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['project_id'];
            }
            $end_date = date('Y-m-d h:i:s');
            $this->db->where('id', $id);
            $this->db->update('project_task', array('date_completed' => $end_date, 'tracking_description' => 4));
//            $this->db->where('project_id', $suborder_order_id);
//            $this->db->update('project_main', array('status' => 0));
            
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['project_id'];
            }
            $check_if_all_services_not_started = $this->db->query('select * from project_task where project_id="' . $suborder_order_id . '"')->result_array();
//          
            
            if (!empty($check_if_all_services_not_started)) {
                $k = 0;
                $status_array = '';
                $len = count($check_if_all_services_not_started);
                foreach ($check_if_all_services_not_started as $val) {
                    if ($k == $len - 1) {
                        $status_array .= $val['tracking_description'];
                    } else {
                        $status_array .= $val['tracking_description'] . ',';
                    }
                    $k++;
                }
            }
//            echo $status_array;die;
            $status_array_values = explode(",", $status_array);
            if (count(array_unique($status_array_values)) == 1) {
                $this->db->where('project_id', $suborder_order_id);
                $this->db->update('project_main', array('status' => 4));
            }
        }
        else {
            $end_date = date('Y-m-d h:i:s');
            $this->db->where('id', $id);
            $this->db->update('project_task', array('date_completed' => $end_date, 'tracking_description' => 2));
            
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['project_id'];
            }
            $this->db->where('project_id', $suborder_order_id);
            $this->db->update('project_main', array('status' => 1));
            
            $this->db->select('id');
            $this->db->from('project_task');
            $this->db->where('project_id',$project_id);
            $this->db->where_not_in('tracking_description',2);
            $get_task_ids=$this->db->get()->result_array();
            $a= array_column($get_task_ids,'id');
            if(isset($a[0])){
                $task2=$a[0];
                $end_date = date('Y-m-d h:i:s');
                $this->db->where('id', $task2);
                $this->db->update('project_task', array('date_completed' => $end_date, 'tracking_description' => 3));
            }
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['project_id'];
            }
            $check_if_all_services_not_started = $this->db->query('select * from project_task where project_id="' . $suborder_order_id . '"')->result_array();
//          
            
            if (!empty($check_if_all_services_not_started)) {
                $k = 0;
                $status_array = '';
                $len = count($check_if_all_services_not_started);
                foreach ($check_if_all_services_not_started as $val) {
                    if ($k == $len - 1) {
                        $status_array .= $val['tracking_description'];
                    } else {
                        $status_array .= $val['tracking_description'] . ',';
                    }
                    $k++;
                }
            }
//            echo $status_array;die;
            $status_array_values = explode(",", $status_array);
            if (count(array_unique($status_array_values)) == 1) {
                $this->db->where('project_id', $suborder_order_id);
                $this->db->update('project_main', array('status' => 2));
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
//            $this->system->save_general_notification('action', $id, 'tracking');
            return $task2;
        }
    }

    public function get_current_project_task_status($table_name, $id) {
        return $this->db->query("select tracking_description from $table_name where id = '$id'")->row_array()["tracking_description"];
    }

    public function get_project_tracking_log($id, $table_name) {
        return $this->db->query("SELECT concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as stuff_id, (SELECT name from department where id=(SELECT department_id from department_staff where staff_id=s.id )) as department, case when tracking_logs.status_value = '0' then 'New' when tracking_logs.status_value = '1' then 'Started' when tracking_logs.status_value = '2' then 'Resolved' when tracking_logs.status_value = '3' then 'Ready' else tracking_logs.status_value end as status, date_format(tracking_logs.created_time, '%m/%d/%Y - %r') as created_time FROM `tracking_logs` inner join staff as s on tracking_logs.stuff_id = s.id where tracking_logs.section_id = '$id' and tracking_logs.related_table_name = '$table_name' order by tracking_logs.id desc")->result_array();
    }

    public function getStaffType() {
        return $this->db->get('staff_type')->result_array();
    }

    function update_project_template_task($task_id, $template_id, $post) {
//        print_r($post);die;
        $this->db->trans_begin();
        $template_cat_id = $post['task']['template_cat_id'];
        $task_data['template_main_id'] = $template_id;
        $task_data['added_by_user'] = sess('user_id');
        $task_data['task_order'] = $post['task']['task_order'];
        $task_data['task_title'] = $post['task']['task_title'];
        $task_data['description'] = $post['task']['description'];
        $task_data['target_start_date'] = $post['task']['target_start_date'];
        $task_data['target_start_day'] = $post['task']['target_start_day'];
        $task_data['target_complete_date'] = $post['task']['target_complete_date'];
        $task_data['target_complete_day'] = $post['task']['target_complete_day'];
        $task_data['tracking_description'] = $post['task']['tracking_description'];
        $task_data['is_input_form']= $post['task']['is_input_form'];
        if($template_cat_id==1){
            if($post['task']['is_input_form']=='y'){
                $task_data['input_form_type']=1;
                if(isset($post['task']['bookkeeping_input_type']) && $post['task']['bookkeeping_input_type']!=''){
                    $task_data['bookkeeping_input_type']=$post['task']['bookkeeping_input_type'];
                }else{
                    $task_data['bookkeeping_input_type']=0;
                }
            }else{
                $task_data['input_form_type']=0;
                $task_data['bookkeeping_input_type']=0;
            }
        }else{
            if(isset($post['task']['input_form_type']) && $post['task']['input_form_type']!=''){
                $task_data['input_form_type']=$post['task']['input_form_type'];
            }else{
                $task_data['input_form_type']=0;
            }
        }
//        $task_data['is_all'] = $post['task']['is_all'];
        $task_data['department_id'] = $post['task']['department'];
        if ($task_data['department_id'] != 2 && ($post['task']['is_all'] == 1 || $post['task']['is_all'] == 0)) {
            $task_data['responsible_task_staff'] = null;
            $task_data['is_all'] = $post['task']['is_all'];
        } else {
            $task_data['is_all'] = null;
            $task_data['responsible_task_staff'] = $post['task']['responsible_task_staff'];
        }
        $task_staff_list = $this->get_department_staff_by_department_id($post['task']['department']);
//        print_r($task_data);die;
        $this->db->where('id', $task_id);
        $this->db->update('project_template_task', $task_data);
//        $insert_id = $this->db->insert_id();

        if ($post['task']['department'] != 2) {
            $this->db->where('task_id', $task_id);
            $this->db->delete('project_template_task_staff');
            if (isset($post['task']['staff']) && !empty($post['task']['staff']) && ($post['task']['is_all'] != 1)) {
                foreach ($post['task']['staff'] as $ins_staff_id) {
                    $this->db->insert('project_template_task_staff', ['task_id' => $task_id, 'staff_id' => $ins_staff_id]);
                }
            }
            if ($task_data['is_all'] == 1 && !empty($task_staff_list)) {
//                echo "a";die;
                foreach ($task_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_template_task_staff', ['task_id' => $task_id, 'staff_id' => $staffId]);
                }
//                echo $this->db->last_query();
            }
        }
        $notedata = $this->input->post('task_note');
        $this->insert_task_note(8, $notedata, "task_id", $task_id, 'task');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function request_update_project_main($post) {
//        echo "<pre>";
//        print_r($post);
//        die;
        $project_id = $post['template_main']['project_id'];
        $template_id = $post['template_main']['template_main_id'];
        $client_reference_id = $this->db->get_where('projects', ['id' => $project_id])->row_array()['client_id'];
        $this->db->trans_begin();
        if (isset($post['template_main']) && !empty($post['template_main'])) {
            unset($post['template_main']['project_id']);
            unset($post['template_main']['edit_template']);
//            $temp_main_ins['added_by_user'] = sess('user_id');
            $temp_main_ins['template_id'] = $post['template_main']['template_id'];
            $temp_main_ins['title'] = $post['template_main']['title'];
            $temp_main_ins['description'] = $post['template_main']['description'];
            $temp_main_ins['category_id'] = $post['template_main']['service_category'];
            if (isset($post['template_main']['service']) && $post['template_main']['service'] != '') {
                $temp_main_ins['service_id'] = $post['template_main']['service'];
            } else {
                $temp_main_ins['service_id'] = '';
            }
            $temp_main_ins['status'] = $post['template_main']['status'];
            $temp_main_ins['department_id'] = $post['template_main']['department'];
//            $temp_main_ins['ofc_is_all'] = $post['template_main']['ofc_is_all'];
            $temp_main_ins['dept_is_all'] = $post['template_main']['dept_is_all'];
            $temp_main_ins['office_id'] = $post['template_main']['office'];
            if ($temp_main_ins['office_id'] == 3) {
                $temp_main_ins['responsible_staff'] = $post['template_main']['francise_staff'];
                $temp_main_ins['ofc_is_all'] = null;
            }
            if (isset($post['template_main']['responsible_department']) && $post['template_main']['responsible_department'] != '') {
                $temp_main_ins['responsible_department'] = $post['template_main']['responsible_department'];
            }
            if (isset($post['template_main']['is_all']) && $post['template_main']['is_all'] != '') {
                $temp_main_ins['ofc_is_all'] = $post['template_main']['is_all'];
            }
            $template_staff_list = $this->get_department_staff_by_department_id($post['template_main']['department']);
            $template_responsible_list = $this->get_department_staff_by_department_id($post['template_main']['office']);
//            if (isset($post['template_main']['partner']) && $post['template_main']['partner'] != '' && ($post['template_main']['ofc_is_all']) != 1) {
//                $temp_main_ins['partner_id'] = $post['template_main']['partner'];
//            } else {
//                $temp_main_ins['partner_id'] = null;
//            }
//            if (isset($post['template_main']['manager']) && $post['template_main']['manager'] != '' && ($post['template_main']['ofc_is_all']) != 1) {
//                $temp_main_ins['manager_id'] = $post['template_main']['manager'];
//            } else {
//                $temp_main_ins['manager_id'] = null;
//            }
//            if (isset($post['template_main']['associate']) && $post['template_main']['associate'] != '' && ($post['template_main']['ofc_is_all']) != 1) {
//                $temp_main_ins['associate_id'] = $post['template_main']['associate'];
//            } else {
//                $temp_main_ins['associate_id'] = null;
//            }
//            echo "<pre>";
//            print_r($temp_main_ins);die;
            $this->db->where('project_id', $project_id);
            $this->db->update('project_main', $temp_main_ins);
//            $last_id = $this->db->insert_id();
//            echo $template_id;die;
//            echo $post['template_main']['staff'];die;
            $this->db->where('project_id', $project_id);
            $this->db->delete('project_staff_main');
            if (isset($post['template_main']['department_staff']) && !empty($post['template_main']['department_staff']) && ($post['template_main']['dept_is_all']) != 1) {
//              
                foreach ($post['template_main']['department_staff'] as $ins_staff_id) {

                    $this->db->insert('project_staff_main', ['project_id' => $project_id, 'staff_id' => $ins_staff_id, 'type' => 1]);
                }
            }
            if (isset($post['template_main']['res_dept_staff']) && !empty($post['template_main']['res_dept_staff'])) {
//                $this->db->where('template_id', $template_id);
//                $this->db->delete('project_template_staff_main');
                foreach ($post['template_main']['res_dept_staff'] as $ins_offic_id) {

                    $this->db->insert('project_staff_main', ['project_id' => $project_id, 'staff_id' => $ins_offic_id, 'type' => 2]);
                }
            }
            if ($temp_main_ins['dept_is_all'] == 1 && !empty($template_staff_list)) {
//                echo "a";die;
                foreach ($template_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_staff_main', ['project_id' => $project_id, 'staff_id' => $staffId, 'type' => 1]);
                }
//                echo $this->db->last_query();
            }
            if ($temp_main_ins['ofc_is_all'] == 1 && !empty($template_responsible_list)) {
                foreach ($template_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_staff_main', ['project_id' => $project_id, 'staff_id' => $staffId, 'type' => 2]);
                }
            }
        }
        if (isset($post['recurrence']) && !empty($post['recurrence']) && $project_id != '') {
            $this->db->where('project_id', $project_id);
            $this->db->delete('project_recurrence_main');
            $ins_recurrence = [];
            $ins_recurrence['template_id'] = $template_id;
            $ins_recurrence['project_id'] = $project_id;
            foreach ($post['recurrence'] as $key => $val) {
                $ins_recurrence[$key] = $val;
            }
            if ($ins_recurrence['pattern'] == 'annually') {

                if ($ins_recurrence['client_fiscal_year_end'] == 1) {
                    $get_client_fye = get_client_fye($client_reference_id);
                    if ($ins_recurrence['fye_type'] == 1) {
                        $fye_day = $ins_recurrence['fye_day'];
                        $fye_is_weekday = $ins_recurrence['fye_is_weekday'];
                        $fye_month = $ins_recurrence['fye_month'];

                        $after_days = (int) $fye_month * 30;

                        // if(strlen($project_recurrence_main_data['actual_due_month'])==1){
                        //     $actual_mnth = '0'.$project_recurrence_main_data['actual_due_month'];
                        // }
                        // if(strlen($project_recurrence_main_data['actual_due_day'])==1){
                        //     $actual_day = '0'.$project_recurrence_main_data['actual_due_day'];
                        // }

                        $current_due = $ins_recurrence['actual_due_year'] . '-' . $get_client_fye;

                        $newDate = strtotime($current_due . ' + ' . $after_days . ' days');

                        $ins_recurrence['actual_due_day'] = $fye_day;
                        $ins_recurrence['actual_due_month'] = date('m', $newDate);
                        $ins_recurrence['actual_due_year'] = date('Y', $newDate);
                    }
                    //    else{
                    //     $fye_day = $project_recurrence_main_data['fye_day'];
                    //     $fye_is_weekday = $project_recurrence_main_data['fye_is_weekday'];
                    //     $fye_month = $project_recurrence_main_data['fye_month'];
                    //     $after_days = (int)$fye_month*2);
                    //     if(strlen($project_recurrence_main_data['actual_due_month'])==1){
                    //         $actual_mnth = '0'.$project_recurrence_main_data['actual_due_month'];
                    //     }
                    //     if(strlen($project_recurrence_main_data['actual_due_day'])==1){
                    //         $actual_day = '0'.$project_recurrence_main_data['actual_due_day'];
                    //     }
                    //     $current_due = $project_recurrence_main_data['actual_due_year'].'-'.$actual_mnth.'-'.$actual_day;
                    //     $newDate = strtotime('+'.$after_days.' days',$current_due);
                    // }
                } else {
                    $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                    $ins_recurrence['actual_due_month'] = $ins_recurrence['due_month'];
                    $ins_recurrence['actual_due_year'] = date('Y');
                }
            } elseif ($ins_recurrence['pattern'] == 'none') {
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = $ins_recurrence['due_month'];
                $ins_recurrence['actual_due_year'] = date('Y');
            } elseif ($ins_recurrence['pattern'] == 'monthly') {
                $current_month = date('m');
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = $current_month + $ins_recurrence['due_month'];
                $ins_recurrence['actual_due_year'] = date('Y');
            } elseif ($ins_recurrence['pattern'] == 'weekly') {
                $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
                $current_day = $day_array[$ins_recurrence['due_month']];
                $givenDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $ins_recurrence['due_day'], date('Y')));
                $ins_recurrence['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
                $ins_recurrence['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
                $ins_recurrence['actual_due_year'] = date('Y');
            } elseif ($ins_recurrence['pattern'] == 'quarterly') {
                $current_month = date('m');
                if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                    $next_quarter[1] = '4';
                    $next_quarter[2] = '5';
                    $next_quarter[3] = '6';
                    $due_year = date('Y');
                } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
                    $next_quarter[1] = '7';
                    $next_quarter[2] = '8';
                    $next_quarter[3] = '9';
                    $due_year = date('Y');
                } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
                    $next_quarter[1] = '10';
                    $next_quarter[2] = '11';
                    $next_quarter[3] = '12';
                    $due_year = date('Y');
                } else {
                    $next_quarter[1] = '1';
                    $next_quarter[2] = '2';
                    $next_quarter[3] = '3';
                    $due_year = date('Y', strtotime('+1 year'));
                }
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = $next_quarter[$ins_recurrence['due_month']];
                $ins_recurrence['actual_due_year'] = $due_year;
            }elseif($ins_recurrence['pattern']=='periodic'){
                $current_month = date('m');
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = (int) $ins_recurrence['due_month'];
                if($ins_recurrence['actual_due_day']>=date('d')){
                    if($ins_recurrence['actual_due_month']<$current_month){
                        $ins_recurrence['actual_due_year'] = date('Y', strtotime('+1 year'));
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y');
                    }
                }else{
                   if($ins_recurrence['actual_due_month']<=$current_month){
                        $ins_recurrence['actual_due_year'] = date('Y', strtotime('+1 year'));
                    }else{
                        $ins_recurrence['actual_due_year']=date('Y');
                    } 
                }
                $periodic_day= json_decode($ins_recurrence['periodic_due_day']);
                $periodic_month=json_decode($ins_recurrence['periodic_due_month']);
                unset($ins_recurrence['periodic_due_day']);
                unset($ins_recurrence['periodic_due_month']);
            }
            else {
                $ins_recurrence['actual_due_day'] = '0';
                $ins_recurrence['actual_due_month'] = '0';
                $ins_recurrence['actual_due_year'] = '0';
            }
            if ($ins_recurrence['pattern'] == 'monthly') {
                $cur_day = date('d');
                if ($cur_day <= $ins_recurrence['actual_due_day']) {
                    $ins_recurrence['actual_due_month'] = date('m');
                }
            }
            $due_date = $ins_recurrence['actual_due_year'] . '-' . $ins_recurrence['actual_due_month'] . '-' . $ins_recurrence['actual_due_day'];

            if ($ins_recurrence['generation_month'] == '') {
                $ins_recurrence['generation_month'] = '0';
            }

            if ($ins_recurrence['generation_day'] == '') {
                $ins_recurrence['generation_day'] = '0';
            }
            $generation_days = ((int) $ins_recurrence['generation_month'] * 30) + (int) $ins_recurrence['generation_day'];

            $ins_recurrence['due_date'] = $due_date;
            if ($ins_recurrence['pattern'] == 'monthly') {
                $next_due_date = date("Y-m-d", strtotime("+1 month", strtotime($due_date)));
                $ins_recurrence['next_due_date'] = $next_due_date;
            } elseif ($ins_recurrence['pattern'] == 'annually') {
                $next_due_date = date("Y-m-d", strtotime("+1 year", strtotime($due_date)));
                $ins_recurrence['next_due_date'] = $next_due_date;
            } elseif ($ins_recurrence['pattern'] == 'weekly') {
                $next_due_date = date("Y-m-d", strtotime("+7 days", strtotime($due_date)));
                $ins_recurrence['next_due_date'] = $next_due_date;
            } elseif ($ins_recurrence['pattern'] == 'quarterly') {
                $next_due_date = date("Y-m-d", strtotime("+3 months", strtotime($due_date)));
                $ins_recurrence['next_due_date'] = $next_due_date;
            } else {
                $ins_recurrence['next_due_date'] = '0000-00-00';
            }
            $generation_date = date('Y-m-d', strtotime('-' . $generation_days . ' days', strtotime($ins_recurrence['next_due_date'])));
            $ins_recurrence['generation_date'] = $generation_date;
            $this->db->insert('project_recurrence_main', $ins_recurrence);
            
            if(isset($periodic_day) && !empty($periodic_day)){
                $this->db->where('project_id',$project_id);
                $this->db->delete('project_periodic_pattern');
                $new_val= array_combine($periodic_day, $periodic_month);
//                print_r($new_val);die;
                foreach($new_val as $day=>$month){
                    $periodic_data=array();
                    $current_month = date('m');
                    $actual_due_day = $day;
                    $actual_due_month = $month;
                    if($actual_due_day>=date('d')){
                        if($actual_due_month<$current_month){
                            $actual_due_year = date('Y', strtotime('+1 year'));
                        }else{
                            $actual_due_year=date('Y');
                        }
                    }else{
                       if($actual_due_month<=$current_month){
                            $actual_due_year = date('Y', strtotime('+1 year'));
                        }else{
                            $actual_due_year=date('Y');
                        } 
                    }
                    $periodic_data=array(
                        'template_id'=>$template_id,
                        'project_id'=>$project_id,
                        'due_day'=>$day,
                        'due_month'=>$month,
                        'actual_due_day'=>$actual_due_day,
                        'actual_due_month'=>$actual_due_month,
                        'actual_due_year'=>$actual_due_year
                    );
                    $this->db->insert('project_periodic_pattern',$periodic_data);
                }
                
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $template_id;
        }
    }

    function update_project_task($task_id, $template_id, $post, $project_id) {
//        print_r($post);die;
        $this->db->trans_begin();
        $template_cat_id = $post['task']['template_cat_id'];
        $task_data['template_main_id'] = $template_id;
        $task_data['added_by_user'] = sess('user_id');
        $task_data['task_order'] = $post['task']['task_order'];
        $task_data['task_title'] = $post['task']['task_title'];
        $task_data['description'] = $post['task']['description'];
        $task_data['target_start_date'] = $post['task']['target_start_date'];
        $task_data['target_start_day'] = $post['task']['target_start_day'];
        $task_data['target_complete_date'] = $post['task']['target_complete_date'];
        $task_data['target_complete_day'] = $post['task']['target_complete_day'];
        $task_data['tracking_description'] = $post['task']['tracking_description'];
        $task_data['is_input_form']=$post['task']['is_input_form'];
        if($template_cat_id==1){
            if($post['task']['is_input_form']=='y'){
                $task_data['input_form_type']=1;
                if(isset($post['task']['bookkeeping_input_type']) && $post['task']['bookkeeping_input_type']!=''){
                    $task_data['bookkeeping_input_type']=$post['task']['bookkeeping_input_type'];
                }else{
                    $task_data['bookkeeping_input_type']=0;
                }
            }else{
                $task_data['input_form_type']=0;
                $task_data['bookkeeping_input_type']=0;
            }
        }else{
            if(isset($post['task']['input_form_type']) && $post['task']['input_form_type']!=''){
                $task_data['input_form_type']=$post['task']['input_form_type'];
            }else{
                $task_data['input_form_type']=0;
            }
        }
//        $task_data['is_all'] = $post['task']['is_all'];
        $task_data['department_id'] = $post['task']['department'];
        if ($task_data['department_id'] != 2 && ($post['task']['is_all'] == 1 || $post['task']['is_all'] == 0)) {
            $task_data['responsible_task_staff'] = null;
            $task_data['is_all'] = $post['task']['is_all'];
        } else {
            $task_data['is_all'] = null;
            $task_data['responsible_task_staff'] = $post['task']['responsible_task_staff'];
        }
        $task_staff_list = $this->get_department_staff_by_department_id($post['task']['department']);
//        print_r($task_data);die;
        $this->db->where('id', $task_id);
        $this->db->update('project_task', $task_data);
//        $insert_id = $this->db->insert_id();

        if ($post['task']['department'] != 2) {
            $this->db->where('task_id', $task_id);
            $this->db->delete('project_task_staff');

            if (isset($post['task']['staff']) && !empty($post['task']['staff']) && ($post['task']['is_all'] != 1)) {
                foreach ($post['task']['staff'] as $ins_staff_id) {
                    $this->db->insert('project_task_staff', ['task_id' => $task_id, 'staff_id' => $ins_staff_id]);
                }
            }
            if ($task_data['is_all'] == 1 && !empty($task_staff_list)) {
//                echo "a";die;
                foreach ($task_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_task_staff', ['task_id' => $task_id, 'staff_id' => $staffId]);
                }
//                echo $this->db->last_query();
            }
        }
        if ($post['task']['department'] == 2) {
            $this->db->where('task_id', $task_id);
            $this->db->delete('project_task_staff');
            $client_id = $this->db->get_where('projects', ['id' => $project_id])->row()->client_id;
            $res = $this->db->get_where('internal_data', ['reference_id' => $client_id])->row();
            if ($post['task']['responsible_task_staff'] == 1) {
                $staffsid = $res->partner;
            }
            if ($post['task']['responsible_task_staff'] == 2) {
                $staffsid = $res->manager;
            }
            $this->db->insert('project_task_staff', ['task_id' => $task_id, 'staff_id' => $staffsid]);
        }
        $notedata = $this->input->post('task_note');
        $this->insert_task_note(8, $notedata, "task_id", $task_id, 'task');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function add_project_task($post) {
//        print_r($post);die;
        $this->db->trans_begin();
        $template_cat_id = $post['task']['template_cat_id'];
        $task_data['template_main_id'] = $post['task']['template_main_id'];
        $task_data['project_id'] = $post['task']['project_id'];
        $task_data['added_by_user'] = sess('user_id');
        $task_data['task_order'] = $post['task']['task_order'];
        $task_data['task_title'] = $post['task']['task_title'];
        $task_data['description'] = $post['task']['description'];
        $task_data['target_start_date'] = $post['task']['target_start_date'];
        $task_data['target_complete_date'] = $post['task']['target_complete_date'];
        $task_data['target_start_day'] = $post['task']['target_start_day'];
        $task_data['target_complete_day'] = $post['task']['target_complete_day'];
        $task_data['tracking_description'] = $post['task']['tracking_description'];
        $task_data['is_input_form']=$post['task']['is_input_form'];
        if($template_cat_id==1){
            if($post['task']['is_input_form']=='y'){
                $task_data['input_form_type']=1;
                if(isset($post['task']['bookkeeping_input_type']) && $post['task']['bookkeeping_input_type']!=''){
                    $task_data['bookkeeping_input_type']=$post['task']['bookkeeping_input_type'];
                }else{
                    $task_data['bookkeeping_input_type']=0;
                }
            }else{
                $task_data['input_form_type']=0;
            }
        }else{
            if(isset($post['task']['input_form_type']) && $post['task']['input_form_type']!=''){
                $task_data['input_form_type']=$post['task']['input_form_type'];
            }else{
                $task_data['input_form_type']=0;
            }
        }
//        $task_data['is_all'] = $post['task']['is_all'];
        $task_data['department_id'] = $post['task']['department'];
        if ($task_data['department_id'] != 2 && ($post['task']['is_all'] == 1 || $post['task']['is_all'] == 0)) {
            $task_data['responsible_task_staff'] = null;
            $task_data['is_all'] = $post['task']['is_all'];
        } else {
            $task_data['is_all'] = null;
            $task_data['responsible_task_staff'] = $post['task']['responsible_task_staff'];
        }
        $task_staff_list = $this->get_department_staff_by_department_id($post['task']['department']);
//        print_r($task_data);die;
        $this->db->insert('project_task', $task_data);
        $insert_id = $this->db->insert_id();
        if ($post['task']['department'] != 2) {
            if (isset($post['task']['staff']) && !empty($post['task']['staff']) && ($post['task']['is_all'] != 1)) {
                foreach ($post['task']['staff'] as $ins_staff_id) {
                    $this->db->insert('project_task_staff', ['task_id' => $insert_id, 'staff_id' => $ins_staff_id]);
                }
            }
            if ($task_data['is_all'] == 1 && !empty($task_staff_list)) {
//                echo "a";die;
                foreach ($task_staff_list as $ins_staff_id) {
                    $staffId = $ins_staff_id['id'];
                    $this->db->insert('project_task_staff', ['task_id' => $insert_id, 'staff_id' => $staffId]);
                }
//                echo $this->db->last_query();
            }
        }
//        for Franchise partner or manager
        if ($post['task']['department'] == 2) {
            $project_id = $post['task']['project_id'];
            $client_id = $this->db->get_where('projects', ['id' => $project_id])->row()->client_id;
            $res = $this->db->get_where('internal_data', ['reference_id' => $client_id])->row();
            if ($post['task']['responsible_task_staff'] == 1) {
                $staffsid = $res->partner;
            }
            if ($post['task']['responsible_task_staff'] == 2) {
                $staffsid = $res->manager;
            }
            $this->db->insert('project_task_staff', ['task_id' => $insert_id, 'staff_id' => $staffsid]);
        }
        $notedata = $this->input->post('task_note');
        $this->insert_task_note(8, $notedata, "task_id", $insert_id, 'task');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_assigned_project_task_staff($id) {
//        echo $id;die;
        $query = 'select * from project_task where id=' . $id . '';
        $data1 = $this->db->query($query)->row();
        $department_id = $data1->department_id;
        $office_id = $data1->office_id;
//        $staff_id = $data1->staff_id;
        $is_all = $data1->is_all;
        $franc_staff = $data1->responsible_task_staff;
        if ($department_id != 2 && $is_all == 1) {
            return "All Staff";
        }
//        else if ($department_id == 2 && $is_all == 1) {
//            return "All Staff";
//        }
        else if ($department_id != 2 && $is_all == 0) {
            $query = 'select s.id,CONCAT(s.last_name, ", ",s.first_name,", ",s.middle_name) as full_name '
                    . 'from staff s '
                    . 'INNER JOIN project_task_staff ptsk ON(ptsk.staff_id=s.id)'
                    . 'where ptsk.task_id=' . $id . '';
            $data2 = $this->db->query($query)->row();
            if (isset($data2)) {
                return $data2->full_name;
            } else {
                return '';
            }
        } else if ($department_id == 2 && $franc_staff != '') {
            if ($franc_staff == 1) {
                return "Partner";
            } else if ($franc_staff == 2) {
                return "Manager";
            } else {
                return "Client Association";
            }
        }

//        else if ($department_id == 2 ) {
//            $query1 = "SELECT s.id,CONCAT(s.last_name, ', ',s.first_name,', ',s.middle_name) as full_name FROM staff s INNER JOIN project_template_task_staff ptsk ON(ptsk.staff_id=s.id) WHERE ptsk.task_id='$id'";
//            $data3 = $this->db->query($query1)->row_array();
//            return $data3['full_name'];
//        }
    }

    public function get_assigned_project_task_department($template_id) {
        $query = 'select * from project_task where id=' . $template_id . '';
        $data1 = $this->db->query($query)->row();
        $department_id = $data1->department_id;
        $query = "SELECT name FROM department WHERE id=$department_id";
        $data = $this->db->query($query)->row();
        return $data->name;
    }

    public function get_p_m_ca_name($resp_value, $project_id, $client_type) {
        if ($client_type == 1) {
            $clientType = 'company';
        } else {
            $clientType = 'individual';
        }
        $query = 'select * from projects where id=' . $project_id . '';
        $result = $this->db->query($query)->row_array();
        if ($resp_value == 'Partner') {
            $query1 = 'select * from internal_data where reference_id=' . $result["client_id"] . '';
            $result1 = $this->db->query($query1)->row_array();
            $val = $result1['partner'];
            echo get_assigned_by_staff_name($val);
        } elseif ($resp_value == 'Manager') {
            $query1 = 'select * from internal_data where reference_id=' . $result["client_id"] . '';
            $result1 = $this->db->query($query1)->row_array();
            $val = $result1['manager'];
            echo get_assigned_by_staff_name($val);
        } else {
            $query1 = 'select * from internal_data where reference_id=' . $result["client_id"] . '';
            $result1 = $this->db->query($query1)->row_array();
            $val = $result1['client_association'];
            if ($val == '') {
                $val = 'N/A';
            }
            echo $val;
        }
    }

    public function get_p_m_ca_ofc_name($resp_value, $project_id, $client_type) {
//        echo $client_type;
        $query = 'select * from projects where id=' . $project_id . '';
        if ($client_type == 1) {
            $clientType = 'company';
        } else {
            $clientType = 'individual';
        }
        $result = $this->db->query($query)->row_array();
        if ($resp_value == 'Partner') {
            $query1 = "select * from internal_data where reference_id=" . $result['client_id'];
            $result1 = $this->db->query($query1)->row_array();
            $val = $result1['office'];
            $result = $this->db->get_where('office', ['id' => $val])->row();
            if (isset($result->office_id)) {
                return $result->office_id;
            } else {
                return '';
            }
        } elseif ($resp_value == 'Manager') {
//            echo "dkfjdkl";
            $query1 = "select * from internal_data where reference_id=" . $result['client_id'];
            $result1 = $this->db->query($query1)->row_array();
            $val = $result1['office'];
            $result = $this->db->get_where('office', ['id' => $val])->row();
            if (isset($result->office_id)) {
                return $result->office_id;
            } else {
                return '';
            }
        } else {
            $query1 = "select * from internal_data where reference_id=" . $result['client_id'];
            $result1 = $this->db->query($query1)->row_array();
            $val = $result1['client_association'];
            if ($val == '') {
                $val = 'N/A';
            }
            return $val;
        }
    }

    public function get_project_office_id($project_id) {
        return $this->db->get_where('projects', ['id' => $project_id])->row()->office_id;
    }

    public function get_project_list($request = '', $status = '', $template_id = '', $office_id = '', $department_id = '', $filter_assign = '', $filter_data = [], $sos_value = '', $sort_criteria = '', $sort_type = '', $client_type = '', $client_id = '',$template_cat_id='',$month='',$year='') {
//        print_r($month);die;
//        print_r($filter_data);die;
        $user_info = $this->session->userdata('staff_info');
        $user_department = $user_info['department'];
        $user_type = $user_info['type'];
        $staff_id = sess('user_id');
        $role = $user_info['role'];
        $user_office = $user_info['office'];
        
//        $office_staff = $department_staff = $departments = $action_id = [];
//        if ($user_type == 3 && $role == 2) {
//            $office_staff = explode(",", $user_info['office_staff']);
//            $office_staff = array_unique($office_staff);
//        }
//        if ($user_type == 2 && $role == 4) {
//            if ($user_department != '14') {
//                $departments = $user_department;
//                $department_staff = explode(",", $user_info['department_staff']);
//                $department_staff = array_unique($department_staff);
//                //$action_id = $this->get_request_to_others_action_by_staff_id($staff_id);
//            }
//        }
        $select = implode(', ', $this->project_select);
        $this->db->select($select);
        //$this->db->select('pro.*,pm.office_id as project_office_id,pm.department_id as project_department_id');
        // $this->db->select('id');
        $this->db->from('projects AS pro');
        $this->db->join('project_main AS pm', 'pm.project_id = pro.id', 'left');
        $this->db->join('project_recurrence_main AS prm', 'prm.project_id = pro.id', 'left');
        $this->db->join('project_task AS pt', 'pt.project_id = pro.id', 'left');
//        $this->db->join('staff AS st', 'st.id = act.added_by_user');
        if (isset($sos_value) && $sos_value != '') {
            $this->db->join('sos_notification AS sos', 'sos.reference_id = pro.id');
            $this->db->join('sos_notification_staff AS sns', 'sns.sos_notification_id = sos.id');
        }
        $having = [];
//        if($user_type==1 && $user_department==14){
//            $having[] = 'all_project_staffs LIKE "%,' . $staff_id . ',%" AND added_by_user != "' . $staff_id . '"';
//        }
        if ($request != '') {
//            echo "aaa";die;
            if ($request == 'byme') {
                $this->db->where(['pm.added_by_user' => $staff_id]);
            } elseif ($request == 'tome') {
                $having[] = '(all_project_staffs LIKE "%,' . $staff_id . ',%" OR all_task_staffs LIKE "%,' . $staff_id . ',%") AND added_by_user != "' . $staff_id . '"';
            }

//            elseif ($request == 'byother') {
//                echo "c";die;
//                if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
//                    $this->db->where(['my_task' => 0, 'added_by_user!=' => $staff_id]);
//                }
//                if ($user_type == 3 && $role == 2) {
//                    unset($office_staff[array_search(sess('user_id'), $office_staff)]);
//                    $this->db->where(['my_task' => 0]);
//                    if (!empty($office_staff)) {
//                        $this->db->where_in('added_by_user', $office_staff);
//                    } else {
//                        $this->db->where('act.id', 0);
//                    }
//                }
//                if ($user_type == 2 && $role == 4) {
//                    if($user_department != 14){
//                    // unset($department_staff[array_search(sess('user_id'), $department_staff)]);
//                    $this->db->where(['my_task' => 0]);
//                    if (!empty($department_staff)) {
//                        $this->db->where_in('added_by_user', $department_staff);
//                    } else {
//                        $this->db->where('act.id', 0);
//                    }
//                   }
//                }
//            } 
            elseif ($request == 'toother') {
//                echo "d";die;
                if ($user_type == 3 && $role == 2) {
                    unset($office_staff[array_search(sess('user_id'), $office_staff)]);
                    $like_staffs = [];
                    $like_staffs_task = [];
                    foreach ($office_staff as $staffID) {
                        $like_staffs[] = 'all_project_staffs LIKE "%,' . $staffID . ',%"';
                        $like_staffs_task[] = 'all_task_staffs LIKE "%,' . $staffID . ',%"';
                    }
                    if (!empty($like_staffs)) {
                        // $having[] = 'all_project_staffs NOT LIKE "%,' . $staff_id . ',%" AND (' . implode(' OR ', $like_staffs) . ') AND added_by_user != "' . $staff_id . '"';
                        $having[] = '(all_project_staffs NOT LIKE "%,' . $staff_id . ',%" AND (' . implode(' OR ', $like_staffs) . ') OR all_task_staffs NOT LIKE "%,' . $staff_id . ',%" AND (' . implode(' OR ', $like_staffs_task) . ')) AND added_by_user != "' . $staff_id . '"';
                    } else {
                        $having[] = 'added_by_user != "' . $staff_id . '"';
//                        $having[] = 'added_by_user != "' . $staff_id . '" OR assign_staff LIKE "%,' . $staff_id . ',%"';
                    }
                }
                if ($user_type == 2 && $role == 4) {
                    if ($user_department != 14) {
                        if (isset($departments)) {
                            $having[] = '(all_project_staffs NOT LIKE "%,' . $staff_id . ',%" OR all_task_staffs NOT LIKE "%,' . $staff_id . ',%") AND department_id IN (' . $departments . ') AND added_by_user != "' . $staff_id . '"';
                        } else {
                            $having[] = 'added_by_user != "' . $staff_id . '"';
                        }
                    }
                }
            } elseif ($request == 'mytask') {
//                $having[]= 'assign_staff LIKE "%,' . $staff_id . ',%"';
            }
//             elseif ($request == 'unassigned') {
//                echo "f";die;
//                if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
//                    $having[] = 'all_project_staffs > 1 AND added_by_user != "' . $staff_id . '" OR assign_staff LIKE "%,' . $staff_id . ',%"';
//                } else {
//                    $having[] = 'all_project_staffs > 1 AND department_id IN (' . $user_department . ') AND added_by_user != "' . $staff_id . '" OR assign_staff LIKE "%,' . $staff_id . ',%"';
//                }
//            }
            if ($status != '') {
                if ($status == 0 || $status == 1 || $status == 2) {
                    $this->db->where('pm.status', $status);
                }
            } else {
                if ($status == 0) {
                    $this->db->where('pm.status', $status);
                } else {
                    if (empty($filter_data)) {
                        $this->db->where_not_in('pm.status', [1, 2]);
                    }else{
                        $this->db->where_in('pm.status', [0,1, 2]);
                    }
                }
            }
        } else {
            $having_or = [];
            if ($user_type == 1 || ($user_type == 2 && $user_department == 14)||$user_type==2) {
//                $this->db->where_in('my_task', [0, $staff_id]);
            } 
            else if ($user_type == 3) {
                $this->db->where(['pm.office_id'=>3,'pro.office_id'=>$user_office]);
            }
            else {
                $having[] = '(all_project_staffs LIKE "%,' . $staff_id . ',%" OR all_task_staffs LIKE "%,' . $staff_id . ',%" OR added_by_user = "' . $staff_id . '")';
            }
        }
        if ($status != '') {
                if ($status == 0 || $status == 1 || $status == 2) {
                    $this->db->where('pm.status', $status);
                }
            } else {
                $this->db->where_in('pm.status', [0,1, 2]);
            }
        if (isset($sos_value) && $sos_value != '') {
            if ($sos_value == 'tome') {
                $this->db->where(['sns.staff_id' => sess('user_id'), 'sos.reference' => 'projects', 'sns.read_status' => 0, 'sos.added_by_user!=' => sess('user_id')]);
            } else {
                $this->db->where(['sos.reference' => 'projects', 'sns.read_status' => 0, 'sos.added_by_user' => sess('user_id')]);
            }
        }

        if ($office_id != '') {
            $this->db->where('pro.office', $office_id);
        }

        if ($department_id != '') {
            if ($department_id != 14) {
                $this->db->where('department_id', $department_id);
            }
        }

        if ($client_type != '') {
            $this->db->where('pro.client_type', $client_type);
        }
        if ($filter_assign == 1) {
            $having[] = 'action_staff_count = 1';
        } else if ($filter_assign == 2) {
            $having[] = 'action_staff_count != 1';
        }
        if (!empty($filter_data)) {
//            echo "<pre>";
//            print_r($filter_data['condition_dropdown']);
//            echo "</pre>";
            if (isset($filter_data['variable_dropdown'])) {
                foreach ($filter_data['variable_dropdown'] as $key => $variable_value) {
                    if (isset($variable_value) && $variable_value != '') {
                        if(!isset($filter_data['condition_dropdown'][$key])){
                            $condition_value=1;
                        }else{
                            $condition_value = $filter_data['condition_dropdown'][$key];
                        }
//                        echo $condition_value;die;
                        if (isset($condition_value) && $condition_value != '') {
                            $column_name = $this->filter_element[$variable_value];
//                            echo $column_name;die;
                            if ($variable_value == 3 || $column_name == 'pattern' || $column_name == 'status') {
                                $this->db->where($this->build_filter_query($variable_value, $condition_value, $filter_data['criteria_dropdown'], $column_name));
                            } else {
                                $having[] = $this->build_filter_query($variable_value, $condition_value, $filter_data['criteria_dropdown'], $column_name);
                            }
                        }
                    }
                }
            }
        }

        if ($template_id != '') {
            $this->db->where('pro.template_id', $template_id);
        }
        if($template_cat_id!=''){
            $this->db->where('pm.template_cat_id',$template_cat_id);
        }
        if($month!=''){
            $this->db->where('MONTH(prm.due_date)',$month);
        }
        
        if (count($having) != 0) {
            $this->db->having(implode(' AND ', $having));
        }
        $this->db->where('pro.is_deleted', 0);
        if ($client_id != '') {
            $this->db->where('pro.client_id', $client_id);
        }
//        if($template_cat_id==1){
            if($year==''){
                $present_year=date('Y');
                $this->db->where('YEAR(prm.due_date)',$present_year);
            }else{
               $this->db->where('YEAR(prm.due_date)',$year); 
            }
//        }
        $this->db->group_by('pro.id');
        if ($sort_criteria != '') {
//            echo "a";
//            print_r($sort_criteria);
//            die;
            $this->db->order_by($sort_criteria, $sort_type);
        } else {
//            echo "b";die;
            $this->db->order_by("pro.id", "DESC");
        }
        //$this->db->limit(10,0);
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $result = $this->db->get()->result_array();
//        print_r($result);die;
//        echo $this->db->last_query();die;
        return $result;
    }

    public function get_project_filter_element_value($element_key, $office) {
        $tracking_array = [
                ["id" => 0, "name" => "Not Started"],
                ["id" => 1, "name" => "Started"],
                ["id" => 2, "name" => "Completed"]
        ];
        $pattern_array = [
                ["id" => "monthly", "name" => "monthly"],
                ["id" => "weekly", "name" => "weekly"],
                ["id" => "quarterly", "name" => "quarterly"],
                ["id" => "annually", "name" => "annually"],
                ["id" => "none", "name" => "none"]
        ];
        $client_type_array = [
                ['id' => 1, 'name' => 'Business'],
                ['id' => 2, 'name' => 'Individual']
        ];
        switch ($element_key):
            case 1: {
                    $this->db->select("pro.id as id,pro.id as name");
                    $this->db->from('projects pro');
                    return $this->db->get()->result_array();
                }
                break;
            case 2: {
                    $this->db->select("distinct(pro.template_id) as id,pm.title as name");
                    $this->db->from('projects pro');
                    $this->db->join('project_main AS pm', 'pm.project_id = pro.id', 'left');
                    return $this->db->get()->result_array();
                }
                break;
            case 3: {
                    return $pattern_array;
                }
                break;
            case 4: {
                    return $client_type_array;
                }
                break;
//            case 5: {
//                    $this->db->select("pro.client_id as id,pro.client_id as name");
//                    $this->db->from('projects pro');
//                    return $this->db->get()->result_array();
//                }
//                break;
            case 5:
            case 9:
            case 11:
            case 8: {
                    return $tracking_array;
                }
                break;
            case 6: {
                    $this->db->select("st.id AS id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) AS name");
                    $this->db->from('staff AS st');
                    if ($office != ''):
                        $this->db->join('office_staff os', 'os.staff_id = st.id');
                        $this->db->where(['os.office_id' => $office]);
                    endif;
                    $this->db->where(['st.type!=' => 4]);
                    return $this->db->get()->result_array();
                }
                break;
            case 7: {
                    $this->db->select("st.id AS id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) AS name");
                    $this->db->from('staff AS st');
                    if ($office != ''):
                        $this->db->join('office_staff os', 'os.staff_id = st.id');
                        $this->db->where(['os.office_id' => $office]);
                    endif;
                    $this->db->where(['st.type!=' => 4]);
                    return $this->db->get()->result_array();
                }
                break;
            case 10: {
                    $this->db->select("st.id AS id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) AS name");
                    $this->db->from('staff AS st');
                    if ($office != ''):
                        $this->db->join('office_staff os', 'os.staff_id = st.id');
                        $this->db->where(['os.office_id' => $office]);
                    endif;
                    $this->db->where(['st.type!=' => 4]);
                    return $this->db->get()->result_array();
                }
                break;
            case 12:{
                return $this->db->get('template_category')->result_array();
            }
                
            default: {
                    return [];
                }
                break;
        endswitch;
    }

    public function get_all_office() {
        $this->db->order_by('name', 'ASC');
        return $this->db->get_where('office', ['status' => 1])->result_array();
    }

    public function build_filter_query($variable_value, $condition_value, $criteria, $column_name) {
//        print_r($criteria);die;
        $query = '';
        if ($variable_value == 1) {
            $criteria_value = $criteria['id'];
        } elseif ($variable_value == 2) {
            $criteria_value = $criteria['template'];
        } elseif ($variable_value == 3) {
            $criteria_value = $criteria['pattern'];
        } elseif ($variable_value == 4) {
            $criteria_value = $criteria['client_type'];
        } elseif ($variable_value == 5) {
            $criteria_value = $criteria['client_id'];
        } elseif ($variable_value == 6) {
            $criteria_value = $criteria['responsible'];
        } elseif ($variable_value == 7) {
            $criteria_value = $criteria['assigned_to'];
        } elseif ($variable_value == 8) {
            $criteria_value = $criteria['tracking'];
        } elseif ($variable_value == 9) {
            $criteria_value = $criteria['created_at'];
        } elseif ($variable_value == 10) {
            $criteria_value = $criteria['requested_by'];
        } elseif ($variable_value == 11) {
            $criteria_value = $criteria['due_date'];
        }
        elseif ($variable_value == 12) {
            $criteria_value = $criteria['template_cat_id'];
        }

//        elseif ($variable_value == 10) {
//            $criteria_value = $criteria['client_id'];
//        }elseif ($variable_value == 11) {
//            $criteria_value = $criteria['creation_date'];
//        }elseif ($variable_value == 12) {
//            $criteria_value = $criteria['due_date'];
//        }
//        echo 'uuu'.$variable_value.', '.$condition_value.', '.$column_name.', '.$criteria_value[0].', ';
//            echo 'd';die;
        if ($variable_value == 9 || $variable_value == 11) { // dates
//            echo 'a';die;
//            print_r($criteria_value);die;
//            echo 'uuu'.$variable_value.', '.$condition_value.', '.$column_name.', '.$criteria_value[0].', ';
//            echo 'd';die;
            if ($condition_value == 1 || $condition_value == 3) {
                $date_value = date("Y-m-d", strtotime($criteria_value[0]));
                $query = $column_name . (($condition_value == 1) ? ' like ' : ' not like ') . '"%' . $date_value . '%"';
            } elseif ($condition_value == 2 || $condition_value == 4) {
//             
                $criterias = explode(" - ", $criteria_value[0]);
//                elseif ($variable_value == 6) {
//                    $criterias = explode(" - ", $criteria_value[0]);
//                } elseif ($variable_value == 11) {
//                    $criterias = explode(" - ", $criteria_value[0]);
//                } elseif ($variable_value == 12) {
//                    $criterias = explode(" - ", $criteria_value[0]);
//                }
                foreach ($criterias as $key => $c) {
                    $criterias[$key] = "'" . date("Y-m-d", strtotime($c)) . "'";
                }
                $query = 'Date(' . $column_name . ')' . (($condition_value == 2) ? ' between ' : ' not between ') . implode(' AND ', $criterias);
            }
        } elseif ($variable_value == 7 || $variable_value == 6) {
            if ($condition_value == 1 || $condition_value == 3) {
                $query = $column_name . (($condition_value == 1) ? ' like ' : ' not like ') . '"%' . $criteria_value[0] . '%"';
            } elseif ($condition_value == 2 || $condition_value == 4) {
                foreach ($criteria_value as $k => $c) {
                    $criterias[$k] = $column_name . (($condition_value == 2) ? ' like ' : ' not like ') . '",' . $c . ',"';
                }
                $query = implode(' OR ', $criterias);
            }
        } else {

//            print_r($criteria_value);die;
//            echo 'uuu'.$condition_value.', '.$column_name.', '.$criteria_value[0].', ';
//            echo 'd';die;
            if ($condition_value == 1 || $condition_value == 3) {
                if ($column_name == 'pattern') {
                    $query = 'prm.' . $column_name . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                } elseif ($column_name == 'status') {
                    $query = 'pm.' . $column_name . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                } else {
                    $query = $column_name . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                }

//                echo "a";die;
            } elseif ($condition_value == 2 || $condition_value == 4) {
//                echo "b";die;
                if ($variable_value == 1) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 2) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 3) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 4) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 7) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 8) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 10) {
                    $criterias = implode(",", $criteria_value);
                }elseif ($variable_value == 12) {
                    $criterias = implode(",", $criteria_value);
                }
//                elseif ($variable_value == 9) {
//                    $criterias = implode(",", $criteria_value);
//                }
                $query = $column_name . (($condition_value == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
            }
        }
        return $query;
    }

    function delete_project_template_task($task_id) {
        $this->db->where('task_id', $task_id);
        $this->db->delete('project_template_task_staff');
        $this->db->where('id', $task_id);
        return $this->db->delete('project_template_task');
    }

    function delete_project($project_id, $project_template_id) {
        $sos_ids = $this->db->get_where('sos_notification', ['reference' => 'projects', 'reference_id' => $project_id])->result_array();
        foreach ($sos_ids as $sos_id) {
            $sosid = $sos_id['id'];
            $this->db->where('sos_notification_id', $sosid);
            $this->db->delete('sos_notification_staff');
            $this->db->where('id', $sosid);
            $this->db->delete('sos_notification');
        }
        $this->db->set('is_deleted', 1);
        $this->db->where('id', $project_id);
        return $this->db->update('projects');
    }

    function projectTaskStaffList($taskid) {
        return $this->db->get_where('project_task_staff', ['task_id' => $taskid])->result_array();
    }

    public function get_project_notes_read_status($id) {
        $result = $this->db->get_where('project_note', array('project_id' => $id))->result_array();
        return array_column($result, 'read_status');
        // return $result['read_status'];
    }

    public function get_project_task_notes_readstatus($id) {
        $result = $this->db->get_where('project_task_note', array('task_id' => $id))->result_array();
        return array_column($result, 'read_status');
        // return $result['read_status'];
    }
    public function getTemplateIds(){
        $this->db->select('p.template_id,ptm.title');
        $this->db->from('projects p');
        $this->db->join('project_template_main ptm','p.template_id=ptm.id','inner');
        $this->db->group_by('p.template_id');
        return $this->db->get()->result_array();
    }
    public function getTaskFilesCount($task_id){
        return $this->db->query("SELECT COUNT(id) as files FROM task_files WHERE task_id = '$task_id'")->row();
    }
    public function getUnreadTaskFileCount($task_id,$reference){
        return $this->db->query('SELECT COUNT(frss.id) as unread_files_count FROM file_read_status_staff AS frss WHERE frss.reference_id = '. "$task_id". ' AND frss.reference = "task" AND frss.read_status = "n"')->row();
    }
    public function getTaskFilesContent($id) {
        $query = $this->db->query("select * from task_files where task_id='" . $id . "'");
        return $query->result_array();
    }
    public function file_upload_tasks($data, $files) {
        if (!empty($files["name"])) {
            $filesCount = count($files['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['userFile']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['userFile']['type'] = $files['type'][$i];
                $_FILES['userFile']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['userFile']['error'] = $files['error'][$i];
                $_FILES['userFile']['size'] = $files['size'][$i];

                $uploadPath = FCPATH . 'uploads/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = "*";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['added_by_user'] = sess('user_id');
                    $uploadData[$i]['task_id'] = $data['task_id'];
                }
            }
        }

        if (!empty($uploadData)) {
            $this->db->insert_batch('task_files', $uploadData);
        }

        $last_id_arr = [];
        $last_id = $this->db->insert_id();
        for($j=0;$j<count($files['name']);$j++) {
            if (!empty($files['name'][$j])) {    
                array_push($last_id_arr,$last_id+$j);
                $variable = explode(',',$data['staff_list']);

                foreach ($variable as $value) {
                    $staff_array = array(
                        'file_id' => $last_id_arr[$j],
                        'reference' => 'task',
                        'reference_id' => $data['task_id'],
                        'staff_id' => $value
                    );
                    $this->db->insert('file_read_status_staff',$staff_array);
                }
            }
        }

        return $this->db->get_where('task_files',array('task_id'=>$data['task_id']))->num_rows();;
    }
    function getTaskFiles($task_id){
        return $this->db->get_where("task_files",['task_id'=>$task_id])->result_array();
    }
    function saveProjectInputForm($data){
        $input_form_type=$data['input_form_type'];
        $bookkeeping_input_type=$data['bookkeeping_input_type'];
        if($input_form_type==3){
            $exist=$this->db->get_where('project_task_sales_tax_process',['task_id'=>$data['task_id']])->row();
            if(!empty($exist)){
                $this->db->where('task_id',$data['task_id']);
                $this->db->delete('project_task_sales_tax_process');
            }
            $data_array = array(
                'task_id'=>$data['task_id'],
                'client_id' => $data['client_name'],
                'state_id' => $data['state'],
                'county_id' => $data['county'],
                'added_by_user' => sess('user_id'),
                'user_type' => $data['user_type'],
                'rate' => $data['rate'],
                'exempt_sales' => $data['exempt_sales'],
                'taxable_sales' => $data['taxable_sales'],
                'gross_sales' => $data['gross_sales'],
                'sales_tax_collect' => $data['sales_tax_collect'],
                'collect_allowance' => $data['collection_allowance'],
                'total_due' => $data['total_due'],
                'period_of_time' => $data['period_time'],
                'period_of_time_val' => $data['period_time'],
                'period_of_time_yearval' => $data['period_time_year'],
                'confirmation_number' => $data['confirmation_number'],
                'status' => 0
            );
            $this->db->trans_begin();
            $this->db->insert('project_task_sales_tax_process',$data_array);
            $insert_id=$this->db->insert_id();
//            echo $insert_id;die;
        }if($input_form_type==1){
            if($bookkeeping_input_type==1){
                $exist=$this->db->get_where('bookkeeping',['order_id'=>$data['task_id'],'reference'=>'project'])->row();
                if(!empty($exist)){
                    $this->db->where(['order_id'=>$data['task_id'],'reference'=>'project']);
                    $this->db->delete('bookkeeping');
                }
                $bookdata=array(
                   'company_id'=>$data['reference_id'],
                    'order_id'=>$data['task_id'],
                    'frequency'=>$data['frequency'],
                    'reference'=>'project'
                );
            $this->db->insert('bookkeeping',$bookdata);
            }else if($bookkeeping_input_type==2){
                $exist=$this->db->get_where('project_task_bookkeeper_department',['task_id'=>$data['task_id']])->row();
                if(!empty($exist)){
                    $this->db->where('task_id',$data['task_id']);
                    $this->db->delete('project_task_bookkeeper_department');
                }
                $bookkeeper_data=array(
                    'task_id'=>$data['task_id'],
                    'bank_account_no'=>$data['bank_account_no'],
                    'transaction'=>$data['transaction'],
                    'item_uncategorize'=>$data['item_uncategorize'],
                    'reconciled'=>$data['reconciled'],
                    'total_time'=>$data['total_time']
                );
                $this->db->insert('project_task_bookkeeper_department',$bookkeeper_data);
            }else if($bookkeeping_input_type==3){
                $exist=$this->db->get_where('project_task_bookkeeper_department',['task_id'=>$data['task_id']])->row();
                if(!empty($exist)){
                    $this->db->where('task_id',$data['task_id']);
                    $this->db->delete('project_task_bookkeeper_department');
                }
                $client_data=array(
                    'task_id'=>$data['task_id'],
                    'adjustment'=>$data['need_adjustment']
                );
                $this->db->insert('project_task_bookkeeper_department',$client_data);
            }
        }
        $uploadData = [];
        $files = $_FILES["project_attachment"];
        if (!empty($files["name"])) {
            $filesCount = count($files['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['attachment_file']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['attachment_file']['type'] = $files['type'][$i];
                $_FILES['attachment_file']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['attachment_file']['error'] = $files['error'][$i];
                $_FILES['attachment_file']['size'] = $files['size'][$i];

                $uploadPath = FCPATH . 'uploads/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = "*";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('attachment_file')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['added_by_user'] = sess('user_id');
                    $uploadData[$i]['task_id'] = $data['task_id'];
                }
            }
        }
        $this->db->where(['id' => $data['task_id']]);
        $this->db->update('project_task', ['input_form_status' => 'y']);
        if (!empty($uploadData)) {
            $this->db->insert_batch('task_files', $uploadData);
        }
        
        $notedata = $this->input->post('task_note');
        if(!empty($notedata)){
            $this->insert_task_note(11, $notedata, "task_id", $data['task_id'], 'task');
        }
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    public function delete_project_input_form_files($file_id) {
        $file_info = $this->db->get_where('task_files', ['id' => $file_id])->row_array();
        unlink(FCPATH . 'uploads/' . $file_info['file_name']);
        $this->db->where(['id' => $file_id]);
        return $this->db->delete('task_files');
    }
    public function getTemplateCategory(){
        return $this->db->get('template_category')->result_array();
    }
    public function getClientDtlsByTaskId($task_id){
        $this->db->select('p.client_id,p.client_type,pt.project_id');
        $this->db->from('project_task pt');
        $this->db->join('projects p','p.id=pt.project_id','inner');
        $this->db->where('pt.id',$task_id);
        return $this->db->get()->row();
    }
    public function getProjectTaskInputFormType($task_id){
        return $this->db->get_where('project_task',['id'=>$task_id])->row()->input_form_type;
    }
    public function getProjectTaskSalesTaxProcess($task_id){
        return $this->db->get_where('project_task_sales_tax_process',['task_id'=>$task_id])->row();
    }
    public function get_project_count_by_client_id($clientid){
        return count($this->db->get_where('projects',['client_id'=>$clientid])->result_array());
    }
    public function getTemplateCategoryByTemplateId($project_template_id){
        return $this->db->get_where('project_template_main',['id'=>$project_template_id])->row()->template_cat_id;
    }
    public function getTaskListForInputForm($project_id){
        return $this->db->get_where('project_task',['project_id'=>$project_id])->result_array();
    }
    public function getProjetBookkeeperDetails($task_id){
        return $this->db->get_where('project_task_bookkeeper_department',['task_id'=>$task_id])->row();
    }
    public function getProjectTemplateCategoryd($project_id){
        return $this->db->get_where('project_main',['project_id'=>$project_id])->row()->template_cat_id;
    }
    public function getExistBookkeepingInputType($template_id){
        return $this->db->get_where('project_template_task',['template_main_id'=>$template_id])->result_array();
    }
    public function getProjectExistBookkeepingInputType($template_id){
        return $this->db->get_where('project_task',['template_main_id'=>$template_id])->result_array();
    }
    public function getExistTask($template_id){
        return count($this->db->get_where('project_template_task',['template_main_id'=>$template_id])->result_array());
    }
    public function getDueYear(){
        $this->db->select('YEAR(due_date) as due_year');
        $this->db->from('project_recurrence_main');
        $this->db->where('YEAR(due_date)!=','0');
        $this->db->group_by('YEAR(due_date)');
        return $this->db->get()->result_array();
    }
    public function getDueMonth(){
        $this->db->select('MONTH(due_date) as due_month');
        $this->db->from('project_recurrence_main');
        $this->db->where('MONTH(due_date)!=','0');
        $this->db->group_by('MONTH(due_date)');
        return $this->db->get()->result_array();
    }
    public function getProjectClientPracticeId($client_id, $client_type, $office_id = '') {
        if ($client_type == 1) {
            $this->db->select('practice_id');
            $data = $this->db->get_where('internal_data', ['reference_id' => $client_id])->row();
            return $data->practice_id;
        } else {
//            echo $client_id;13859
            $this->db->select("id.practice_id");
            $this->db->from('internal_data id');
            $this->db->join('title t', 't.individual_id=id.reference_id', 'inner');
            $this->db->where('t.id',$client_id);
            $data = $this->db->get()->row();
            return $data->practice_id;
        }
    }
    public function getTemplateCategoryName($template_cat_id){
        $data=$this->db->get_where('template_category',['id'=>$template_cat_id])->row();
        if(!empty($data)){
            return $data->name;
        }else{
            return 'N/A';
        }
    }
    public function getProjectOfficeClient($project_id){
        $this->db->select('client_id,client_type,office_id');
        $this->db->from('projects');
        $this->db->where('id',$project_id);
        return $this->db->get()->row();
    }
    public function getProjectOfficeName($office_id){
        $data=$this->db->get_where('office',['id'=>$office_id])->row();
        if(!empty($data)){
            return $data->name;
        }else{
            return 'N/A';
        }
    }
    public function getAddedUserDepartment($user_id){
        return $this->db->get_where('department_staff',['staff_id'=>$user_id])->row()->department_id;
    }
    public function getAddedUserOffice($user_id){
        return $this->db->get_where('office_staff',['staff_id'=>$user_id])->row()->office_id;
    }
    public function getProjectPeriodicData($project_id){
        return $this->db->get_where('project_periodic_pattern',['project_id'=>$project_id])->row();
    }
    public function getTemplatePeriodicPattern($template_id){
        return $this->db->get_where('template_periodic_pattern',['template_id'=>$template_id])->result_array();
    }
    public function getProjectMainPeriodicData($project_id){
        return $this->db->get_where('project_periodic_pattern',['project_id'=>$project_id])->result_array();
    }
    public function inactive_project_template($project_id) {
        $this->db->set('status','4');
        $this->db->where('id',$project_id);
        return $this->db->update('project_template_main');
    }
    public function DeleteProjectTemplate($template_id){
        $this->db->where('id',$template_id);
        return $this->db->delete('project_template_main');
    }
    public function getProjectCreatedDate($project_id){
        return $this->db->get_where('projects',['id'=>$project_id])->row()->created_at;
    }
}

?>