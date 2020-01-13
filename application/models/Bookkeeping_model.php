<?php

class Bookkeeping_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model("notes");
        $this->load->model("billing_model");
        $this->load->model("service_model");
    }

//    public function get_bookkeeping_data($reference_id) {
//        $sql = "select * from bookkeeping where company_id = '$reference_id';";
//        $result = $this->db->query($sql)->result_array();
//        return $result;
//    }
//    public function update_bookkeeping_by_date($data) {
//        $this->db->trans_begin();
//
//        $this->db->set($data["bookkeeping"])->where("company_id", $data["main"]["reference_id"])->update('bookkeeping');
//        $this->db->set($data["company"])->where("id", $data["main"]["reference_id"])->update('company');
//        $this->db->set($data["internal_data"])->where("reference_id", $data["main"]["reference_id"])->update('internal_data');
//        $this->db->set($data["service_request"])->where("order_id", $data["main"]["order_id"])->update('service_request');
//        $this->db->set($data["internal_data"])->where("reference_id", $data["main"]["reference_id"])->update('internal_data');
//
//        if (!empty($data["service_notes"][41])) {
//            $this->notes->insert_note(1, $data["service_notes"][41], "reference_id", $data["main"]["reference_id"], "service");
//        }
//
//        if (!empty($data["edit_service_notes"][41])) {
//            $this->notes->update_note(1, $data["service_notes"][41]);
//        }
//
//        if (!empty($data["company_notes"])) {
//            $this->notes->insert_note(1, $data["company_notes"], "reference_id", $data["main"]["reference_id"], "company");
//        }
//
//        if (!empty($data["company_notes"])) {
//            $this->notes->update_note(1, $data["company_notes"]);
//        }
//
//        if ($this->db->trans_status() === FALSE) {
//            $this->db->trans_rollback();
//            return "0";
//        } else {
//            $this->db->trans_commit();
//            return "1";
//        }
//    }

    public function save_account($data) {
//        print_r($data);die;
        $section = $data['section'];
        $modal_type=$data['modal_type'];
        unset($data['modal_type']);
        unset($data['section']);
        if ($_FILES['acc_file']['name'] != "") {
            $status = common_upload("acc_file");
            if ($status["success"] == 1) {
                $data["acc_doc"] = $status["status_msg"];
            }
        }
        $edit_id = $data["edit_id"];
        unset($data["edit_id"]);
        $this->db->trans_begin();
        if ($section == "month_diff") { // Account by date
            if ($edit_id == "") { //Add account
                $security_questions = $data["security_question"];
                unset($data["security_question"]);
                $security_answers = $data["security_answer"];
                unset($data["security_answer"]);
                if(isset($modal_type) && $modal_type=='add_account'){
                    $data['client_id']=$data['company_id'];
                }
                $this->db->insert("financial_accounts", $data);
                $edit_id = $this->db->insert_id();

                $security = [];

                foreach ($security_questions as $key => $question) {
                    if ($question != '' && $security_answers[$key] != '') {
                        $security[$key]["security_question"] = $question;
                        $security[$key]["security_answer"] = $security_answers[$key];
                        $security[$key]["financial_accounts_id"] = $edit_id;
                    }
                }
                if (!empty($security)) {
                    $this->db->insert_batch("security_questions", $security);
                }
            } else { //Update account
                $security_questions = $data["security_question"];
                unset($data["security_question"]);
                $security_answers = $data["security_answer"];
                unset($data["security_answer"]);
                $security = [];
                if($section=='project'){
                    $data['reference']=$section;
                }
                $this->db->delete('security_questions', array('financial_accounts_id' => $edit_id));

                $this->db->set($data)->where("id", $edit_id)->update("financial_accounts");

                foreach ($security_questions as $key => $question) {
                    if ($question != '' && $security_answers[$key] != '') {
                        $security[$key]["security_question"] = $question;
                        $security[$key]["security_answer"] = $security_answers[$key];
                        $security[$key]["financial_accounts_id"] = $edit_id;
                    }
                }
                if (!empty($security)) {
                    $this->db->insert_batch("security_questions", $security);
                }
            }
        } else { // Account
            if ($edit_id == "") { //Add account
                
                $security_questions = $data["security_question"];
                unset($data["security_question"]);
                $security_answers = $data["security_answer"];
                unset($data["security_answer"]);
                if($section=='project'){
                    $data['reference']=$section;
                }
                $this->db->insert("financial_accounts", $data);
                $edit_id = $this->db->insert_id();

                $security = [];

                foreach ($security_questions as $key => $question) {
                    if ($question != '' && $security_answers[$key] != '') {
                        $security[$key]["security_question"] = $question;
                        $security[$key]["security_answer"] = $security_answers[$key];
                        $security[$key]["financial_accounts_id"] = $edit_id;
                    }
                }
                if (!empty($security)) {
                    $this->db->insert_batch("security_questions", $security);
                }
            } else { //Update account
                $security_questions = $data["security_question"];
                unset($data["security_question"]);
                $security_answers = $data["security_answer"];
                unset($data["security_answer"]);
                $security = [];
                $this->db->delete('security_questions', array('financial_accounts_id' => $edit_id));

                $this->db->set($data)->where("id", $edit_id)->update("financial_accounts");

                foreach ($security_questions as $key => $question) {
                    if ($question != '' && $security_answers[$key] != '') {
                        $security[$key]["security_question"] = $question;
                        $security[$key]["security_answer"] = $security_answers[$key];
                        $security[$key]["financial_accounts_id"] = $edit_id;
                    }
                }
                if (!empty($security)) {
                    $this->db->insert_batch("security_questions", $security);
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "0";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function delete_financial_account($id) {
        $this->db->trans_begin();
        $this->db->delete('security_questions', array('financial_accounts_id' => $id));
        $this->db->delete('financial_accounts', array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "0";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function request_create_bookkeeping($data) {
        // return $data['state_other'];
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('Internal');
        $this->load->model('System');
        $this->load->model('Service');
        $this->load->model('action_model');
        $this->db->trans_begin();
        if ($data['type_of_client'] == 0) {
            $sql = $this->db->query("select name from company where id='" . $data['client_list'] . "'")->row_array();
            $data['name_of_business1'] = $sql['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_business1'];
        }
        $conn = $this->db;
        if ($data['editval'] == '') { //Insert bookkeeping              
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company_data($this->company_model->make_company_data($data))) {
                    return false;
                }
                // Save company internal data
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
                //$this->action_model->insert_client_action($data);
            }
            $invoice_data = $data;
            // convert the post array into an object
            $data = (object) $data;
            // Create a new order for this request
            $tracking = time();
            $sql = "insert into `order` (order_date, tracking, staff_requested_service, reference, reference_id, status, category_id, service_id) 
                values 
                ('" . date('Y-m-d h:i:s') . "', '{$tracking}', {$this->System->getLoggedUserId()}, 'company', {$data->reference_id}, 2, 2, {$data->service_id})";
            if ($conn->query($sql)) {
                $order_id = $conn->insert_id();
            } else {
                return false;
            }
            $data->order_id = $order_id;
            $this->save_bookkeeping_data($data);
            $client_id=$this->db->get_where('order',['id'=>$order_id])->row()->reference_id;
            // Create the service request
//            if ($data->retail_price_override) {
//                $data->retail_price = $data->retail_price_override;
//            }
            if (isset($data->retail_price_override)) {
                $data->retail_price = ($data->retail_price_override == '') ? $data->retail_price : $data->retail_price_override;
            } else {
                $data->retail_price = $data->retail_price;
            }
            $today = date('Y-m-d h:i:s');
            $target_query = $this->db->query("select * from target_days where service_id='10'")->result_array();
            $target_start = $target_query[0]['start_days'];
            $target_end = $target_query[0]['end_days'];
            $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
            $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));

            $tracking = time();
            $sql = "insert into service_request
                (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
                values
                (
                {$order_id},
                {$data->service_id},
                {$data->retail_price},
                '{$tracking}',
                '{$start_date}',
                '{$end_date}',
                {$this->System->getLoggedUserOfficeId()},
                {$this->System->getLoggedUserId()},
                '2'
                )";
            $conn->query($sql);
            $service_request_id = $conn->insert_id();
            // Loop into related services
            if (isset($data->related_services) && $data->related_services != '0' && count($data->related_services) > 0) {
                $related_services = $data->related_services;
                for ($i = 0; $i < count($related_services); $i++) {

                    $service_id = $related_services[$i];
                    $service = $this->Service->getService($service_id);
                    $tracking = time();
                    $price = $service->retail_price;
                    if (isset($data->related_service['override_price'][$service_id]) && $data->related_service['override_price'][$service_id] != '') {
                        $price = $data->related_service['override_price'][$service_id];
                    }
                    $target_days = $this->service_model->get_date_form_target_days($service_id);
                    $today = date('Y-m-d h:i:s');
                    $target_query = $this->db->query("select * from target_days where service_id='$service_id'")->result_array();
                    $target_start = $target_query[0]['start_days'];
                    $target_end = $target_query[0]['end_days'];
                    $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
                    $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));


                    $sql = "insert into service_request
                    (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
                    values
                    (
                    {$order_id},
                    {$service_id},
                    {$price},
                    '{$tracking}',
                    '{$start_date}',
                    '{$end_date}',
                    {$this->System->getLoggedUserOfficeId()},
                    {$this->System->getLoggedUserId()},
                    '2'
                    )";
                    $conn->query($sql);
                    $service_request_id = $conn->insert_id();
                }
            }
            if (isset($data->service_notes)) {
                foreach ($data->service_notes as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data->company_notes)) {
                $this->notes->insert_note(1, $data->company_notes, 'reference_id', $data->reference_id, 'company');
            }

            if (isset($data->order_notes)) {
                $this->notes->insert_note(1, $data->order_notes, 'reference_id', $order_id, 'order');
            }

            $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_started` asc')->result_array();
            if (!empty($get_target_start_query)) {
                $target_start_date = $get_target_start_query[0]['date_started'];
            }

            $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_completed` desc')->result_array();
            if (!empty($get_target_end_query)) {
                $target_end_date = $get_target_end_query[0]['date_completed'];
            }

            // Update the total amount of order
            $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $order_id),staff_office='".$data->staff_office."' where id = $order_id";
            $conn->query($sql);

            $this->System->log("insert", "order", $order_id);
            $invoice_data['order_id'] = $order_id;
            $this->billing_model->insert_invoice_data($invoice_data);
            $this->System->save_general_notification('order', $order_id, 'insert');
            $data = (object) $data;
            $this->service_model->update_account_order_id_by_new_reference_id($data->new_reference_id, $order_id,$client_id);
            /* mail section */
            $this->System->update_order_serial_id_by_order_id($order_id);
            $user_id = $_SESSION['user_id'];
            $ci = &get_instance();
            $ci->load->model('Staff');
            $user_info = $ci->Staff->StaffInfo($user_id);
            $user_type = $user_info[0]['department'];
            $user_email = "'" . $user_info[0]['user'] . "'";
            $user_name = $user_info[0]['first_name'] . ' ' . $user_info[0]['last_name'];
            $admin_email = 'bookkeeping@taxleaf.com';

            //if ($user_type == 'Franchise') {

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'codetestml0016@gmail.com', // change it to yours
                'smtp_pass' => 'codetestml0016@123', // change it to yours
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
                'wordwrap' => TRUE
            );

            if (isset($data->related_services) && $data->related_services != '0' && count($data->related_services) > 0) {
                $related_services = $data->related_services;
                $total_services = count($related_services) + 1;
            } else {
                $total_services = 1;
            }
            $this->Company->update_title_status($data->reference_id);

            $amount_query = $this->db->query("select sum(price_charged) as total from service_request where order_id = '$order_id'")->result_array();

            $total = $amount_query[0]['total'];

            $email_subject = 'Order #' . $order_id . ' for ' . $total_services . ' Totaling ' . $total . ' has been successfully placed';


            $message = '<table cellpadding="0" cellspacing="0" style=" font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                            <tr>
                                <td>' .
                    $user_name .
                    ',<BR/><BR/> Order #' . $order_id . ' for ' . $total_services . ' Totaling ' . $total . ' has been successfully placed on your LeafCloud Portal.
                                    Click here to access this order now!
                                    </td>
                                    </tr>
                                    <tr>
                                    <td><BR/><BR/><BR/><BR/>
                                    Sincerely,<br/>
                                    Admin<br/>
                                </td>
                            </tr>
                        </table>';

            $ci->load->library('email', $config);
            $ci->email->set_newline("\r\n");
            $ci->email->from('codetestml0016@gmail.com'); // change it to yours
            $ci->email->to($user_email); // change it to yours
            $ci->email->cc($admin_email);
            $ci->email->subject($email_subject);
            $ci->email->message($message);
            $ci->email->send();
            //}

            /* mail section */
            if($data->type_of_client == 1){
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data->staff_office;
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'].' has added a new client on order #'.$order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice    
            }
            
        } else {
            if ($data['type_of_client'] == 1) {
                if (!$this->Company->saveCompany($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
                // Save name options for the new company
                $this->Company->saveCompanyNameOptions($data);
            }

//            $this->notes->saveupdateNotes($data);
            $bookkeeping_data = (object) $data;
            $bookkeeping_data->order_id = $data['editval'];
            $this->save_bookkeeping_data($bookkeeping_data);
            $related_services = $data['related_service'];
            foreach ($related_services as $service_order_id => $order_data) {
                $conn->query('delete from service_request where order_id="' . $service_order_id . '" and services_id!="10"');
                foreach ($order_data as $service_id => $service_data) {
                    if (isset($service_data['override_price']) && $service_data['override_price'] != '') {
                        $price = $service_data['override_price'];
                    } else {
                        $price = $service_data['retail_price'];
                    }
                    $tracking = time();
                    if ($service_id == 10) {
                        $sql = "update service_request set price_charged={$price}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$service_order_id} and services_id=10";
                        $conn->query($sql);
                    } elseif ($service_id == 41) {
                        $sql = "update service_request set price_charged={$price}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$service_order_id} and services_id=41";
                        $conn->query($sql);
                    } elseif (in_array($service_id, $data['related_services'])) {
                        $today = date('Y-m-d h:i:s');
                        $target_query = $this->db->query("select * from target_days where service_id='$service_id'")->result_array();
                        $target_start = $target_query[0]['start_days'];
                        $target_end = $target_query[0]['end_days'];
                        $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
                        $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));

                        $sql = "insert into service_request
                                    (order_id, services_id, price_charged, tracking,date_started,date_completed, responsible_department, responsible_staff, status)
                                    values
                                    (
                                    {$service_order_id},
                                    {$service_id},
                                    {$price},
                                    '{$tracking}',
                                     '{$start_date}',
                                    '{$end_date}',
                                    {$this->System->getLoggedUserOfficeId()},
                                    {$this->System->getLoggedUserId()},
                                    '2'
                                    )";
                        $conn->query($sql);
                    }
                } // inner foreach
            } //outer foreach

            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
//            print_r($data['service_notes']);
            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['editval'], 'company');
            }
            if (isset($data['edit_company_notes'])) {
                $this->notes->update_note(1, $data['edit_company_notes']);
            }
            $data['order_id'] = $data['editval'];
            $this->billing_model->update_invoice_data($data);
            $data = (object) $data;

            // Create a new order for this request
            $tracking = time();

            $orderid = $data->editval;
            $sql = "update `order` set tracking='{$tracking}', reference='company', reference_id='{$data->reference_id}' where id='$orderid'";
            if ($conn->query($sql)) {
                $order_id = $orderid;
            } else {
                return false;
            }


            // Update the total amount of order
            $sql = "update `order` set total_of_order = (select sum(price_charged) from service_request where order_id = $order_id) where id = $order_id";
            $conn->query($sql);
            $this->Company->update_title_status($data->reference_id);
            $this->System->save_general_notification('order', $order_id, 'edit');
            $this->System->log("insert", "order", $order_id);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function request_create_bookkeeping_by_date($data) {
        $this->load->model('Company');
        $this->load->model('action_model');
        $this->load->model('company_model');
        $this->load->model('Internal');
        $this->load->model('System');
        $this->load->model('Service');
        if (isset($data['type_of_client']) && $data['type_of_client'] == 0) {
            $sql = $this->db->query("select name from company where id='" . $data['client_list'] . "'")->row_array();
            $data['name_of_business1'] = $sql['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_business1'];
        }
        $conn = $this->db;
        $this->db->trans_begin();
        if ($data['editval'] == '') {   //add bookkeeping
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company_data($this->company_model->make_company_data($data))) {
                    return false;
                }
                // Save company internal data
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
                //$this->action_model->insert_client_action($data);
            }
            $invoice_data = $data;
            // convert the post array into an object
            $data = (object) $data;

            // Create a new order for this request
            $tracking = time();
            $sql = "insert into `order` (order_date, tracking, staff_requested_service, reference, reference_id, status, category_id, service_id) 
                values 
                ('" . date('Y-m-d h:i:s') . "', '{$tracking}', {$this->System->getLoggedUserId()}, 'company', {$data->reference_id}, 2, 2, {$data->service_id})";
            if ($conn->query($sql)) {
                $order_id = $conn->insert_id();
            } else {
                return false;
            }
            $client_id=$this->db->get_where('order',['id'=>$order_id])->row()->reference_id;

            $data->order_id = $order_id;
            $this->save_bookkeeping_data($data);

            // Create the service request
//            if ($data->retail_price_override) {
//                $data->retail_price = $data->retail_price_override;
//            }
            if (isset($data->retail_price_override)) {
                $data->retail_price = ($data->retail_price_override == '') ? $data->retail_price : $data->retail_price_override;
            } else {
                $data->retail_price = $data->retail_price;
            }
            $today = date('Y-m-d h:i:s');
            $target_query = $this->db->query("select * from target_days where service_id='10'")->result_array();
            $target_start = $target_query[0]['start_days'];
            $target_end = $target_query[0]['end_days'];
            $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
            $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));

            $tracking = time();
            $sql = "insert into service_request
                (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
                values
                (
                {$order_id},
                {$data->service_id},
                {$data->retail_price},
                '{$tracking}',
                '{$start_date}',
                '{$end_date}',
                {$this->System->getLoggedUserOfficeId()},
                {$this->System->getLoggedUserId()},
                '2'
                )";
            $conn->query($sql);
            $service_request_id = $conn->insert_id();
            // Loop into related services
            if (isset($data->related_services) && $data->related_services != '0' && count($data->related_services) > 0) {
                $related_services = $data->related_services;
                for ($i = 0; $i < count($related_services); $i++) {

                    $service_id = $related_services[$i];
                    $service = $this->Service->getService($service_id);
                    $tracking = time();
                    $price = $service->retail_price;
                    if (isset($data->related_service['override_price'][$service_id]) && $data->related_service['override_price'][$service_id] != '') {
                        $price = $data->related_service['override_price'][$service_id];
                    }

                    $today = date('Y-m-d h:i:s');
                    $target_query = $this->db->query("select * from target_days where service_id='$service_id'")->result_array();
                    $target_start = $target_query[0]['start_days'];
                    $target_end = $target_query[0]['end_days'];
                    $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
                    $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));


                    $sql = "insert into service_request
                    (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
                    values
                    (
                    {$order_id},
                    {$service_id},
                    {$price},
                    '{$tracking}',
                    '{$start_date}',
                    '{$end_date}',
                    {$this->System->getLoggedUserOfficeId()},
                    {$this->System->getLoggedUserId()},
                    '2'
                    )";
                    $conn->query($sql);
                    $service_request_id = $conn->insert_id();
                }
            }
            if (isset($data->service_notes)) {
                foreach ($data->service_notes as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data->company_notes)) {
                $this->notes->insert_note(1, $data->company_notes, 'reference_id', $data->reference_id, 'company');
            }

            if (isset($data->order_notes)) {
                $this->notes->insert_note(1, $data->order_notes, 'reference_id', $order_id, 'order');
            }

            $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_started` asc')->result_array();
            if (!empty($get_target_start_query)) {
                $target_start_date = $get_target_start_query[0]['date_started'];
            }

            $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_completed` desc')->result_array();
            if (!empty($get_target_end_query)) {
                $target_end_date = $get_target_end_query[0]['date_completed'];
            }

            $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $order_id) where id = $order_id";
            $conn->query($sql);
            $invoice_data['order_id'] = $order_id;
            $this->billing_model->insert_invoice_data($invoice_data);
            $data = (object) $data;
            // Update the total amount of order            
            $this->service_model->update_account_order_id_by_new_reference_id($data->new_reference_id, $order_id,$client_id);
            $this->System->update_order_serial_id_by_order_id($order_id);
            $this->System->save_general_notification('order', $order_id, 'insert');
            $this->System->log("insert", "order", $order_id);

            // /* mail section */

            // $user_id = $_SESSION['user_id'];
            // $ci = &get_instance();
            // $ci->load->model('Staff');
            // $user_info = $ci->Staff->StaffInfo($user_id);
            // $user_type = $user_info[0]['department'];
            // $user_email = "'" . $user_info[0]['user'] . "'";
            // $user_name = $user_info[0]['first_name'] . ' ' . $user_info[0]['last_name'];
            // $admin_email = 'bookkeeping@taxleaf.com';

            // //if ($user_type == 'Franchise') {

            // $config = Array(
            //     'protocol' => 'smtp',
            //     'smtp_host' => 'ssl://smtp.gmail.com',
            //     'smtp_port' => 465,
            //     'smtp_user' => 'codetestml0016@gmail.com', // change it to yours
            //     'smtp_pass' => 'codetestml0016@123', // change it to yours
            //     'mailtype' => 'html',
            //     'charset' => 'iso-8859-1',
            //     'wordwrap' => TRUE
            // );

            // if (isset($data->related_services) && $data->related_services != '0' && count($data->related_services) > 0) {
            //     $related_services = $data->related_services;
            //     $total_services = count($related_services) + 1;
            // } else {
            //     $total_services = 1;
            // }
            // $this->Company->update_title_status($data->reference_id);

            // $amount_query = $this->db->query("select sum(price_charged) as total from service_request where order_id = '$order_id'")->result_array();

            // $total = $amount_query[0]['total'];

            // $email_subject = 'Order #' . $order_id . ' for ' . $total_services . ' Totaling ' . $total . ' has been successfully placed';


            // $message = '<table cellpadding="0" cellspacing="0" style=" font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            //                 <tr>
            //                     <td>' .
            //         $user_name .
            //         ',<BR/><BR/> Order #' . $order_id . ' for ' . $total_services . ' Totaling ' . $total . ' has been successfully placed on your LeafCloud Portal.
            //                         Click here to access this order now!
            //                         </td>
            //                         </tr>
            //                         <tr>
            //                         <td><BR/><BR/><BR/><BR/>
            //                         Sincerely,<br/>
            //                         Admin<br/>
            //                     </td>
            //                 </tr>
            //             </table>';

            // $ci->load->library('email', $config);
            // $ci->email->set_newline("\r\n");
            // $ci->email->from('codetestml0016@gmail.com'); // change it to yours
            // $ci->email->to($user_email); // change it to yours
            // $ci->email->cc($admin_email);
            // $ci->email->subject($email_subject);
            // $ci->email->message($message);
            // $ci->email->send();
            // //}

            // /* mail section */

            if($data->type_of_client == 1){
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data->staff_office;
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'].' has added a new client on order #'.$order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {
            $this->load->model('Company');
            $this->load->model('Internal');
            $this->load->model('System');
            $conn = $this->db;
            if (isset($data['type_of_client']) && $data['type_of_client'] == 1) {     // Save company information
                if ($data['type_of_client'] == 0) {
                    $sql = $this->db->query("select name from company where id='" . $data['client_list'] . "'")->row_array();
                    $data['name_of_business1'] = $sql['name'];
                } else {
                    $data['name_of_business1'] = $data['name_of_business1'];
                }
                if (!$this->Company->saveCompany($data)) {
                    return false;
                } else {
                    $this->Company->removeCompanyTempFlag($data['reference_id']);
                }
                // Save company internal data
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
                // Save name options for the new company
                $this->Company->saveCompanyNameOptions($data);
            }

            // convert the post array into an object
            $related_services = $data['related_service'];
            //print_r($related_services); exit;
            foreach ($related_services as $service_order_id => $order_data) {
                $conn->query('delete from service_request where order_id="' . $service_order_id . '" and services_id!="41"');
                foreach ($order_data as $service_id => $service_data) {
                    if (isset($service_data['override_price']) && $service_data['override_price'] != '') {
                        $price = $service_data['override_price'];
                    } else {
                        $price = $service_data['retail_price'];
                    }
                    $tracking = time();
                    if ($service_id == 10) {
                        $sql = "update service_request set price_charged={$price}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$service_order_id} and services_id=10";
                        $conn->query($sql);
                    } elseif ($service_id == 41) {
                        $sql = "update service_request set price_charged={$price}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$service_order_id} and services_id=41";
                        $conn->query($sql);
                    } elseif (in_array($service_id, $data['related_services'])) {
                        $today = date('Y-m-d h:i:s');
                        $target_query = $this->db->query("select * from target_days where service_id='$service_id'")->result_array();
                        $target_start = $target_query[0]['start_days'];
                        $target_end = $target_query[0]['end_days'];
                        $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
                        $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));

                        $sql = "insert into service_request
                                    (order_id, services_id, price_charged, tracking,date_started,date_completed, responsible_department, responsible_staff,status)
                                    values
                                    (
                                    {$service_order_id},
                                    {$service_id},
                                    {$price},
                                    '{$tracking}',
                                    '{$start_date}',
                                    '{$end_date}',
                                    {$this->System->getLoggedUserOfficeId()},
                                    {$this->System->getLoggedUserId()},
                                    '2'
                                    )";
                        $conn->query($sql);
                    }
                } // inner foreach
            } //outer foreach

            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
//            print_r($data['service_notes']);
            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            if (isset($data['edit_company_notes'])) {
                $this->notes->update_note(1, $data['edit_company_notes']);
            }
            $data['order_id'] = $data['editval'];
            $this->billing_model->update_invoice_data($data);
            $data = (object) $data;
            $data->order_id = $data->editval;
            $this->save_bookkeeping_data($data);

            // Create a new order for this request
            $tracking = time();

            $orderid = $data->editval;
            $sql = "update `order` set tracking='{$tracking}', reference='company', reference_id='{$data->reference_id}' where id='$orderid'";
            if ($conn->query($sql)) {
                $order_id = $orderid;
            } else {
                return false;
            }


            // Update the total amount of order
            $sql = "update `order` set total_of_order = (select sum(price_charged) from service_request where order_id = $order_id) where id = $order_id";
            $conn->query($sql);
            $this->Company->update_title_status($data->reference_id);
            $this->System->save_general_notification('order', $order_id, 'edit');
            $this->System->log("insert", "order", $order_id);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function save_bookkeeping_data($data) {
        if (isset($data->start_year) && $data->start_year != '') {
            $bookkeeping['start_month_year'] = $data->start_year;
        } else {
            $bookkeeping['start_month_year'] = '';
        }
        if (isset($data->frequeny_of_bookkeeping) && $data->frequeny_of_bookkeeping != '') {
            $bookkeeping['frequency'] = $data->frequeny_of_bookkeeping;
        } else {
            $bookkeeping['frequency'] = '';
        }
        if (isset($data->payroll_people_total) && $data->payroll_people_total != '') {
            $bookkeeping['payroll_count'] = $data->payroll_people_total;
        } else {
            $bookkeeping['payroll_count'] = '';
        }
        if (isset($data->office_visit) && $data->office_visit != '') {
            $bookkeeping['office_visit'] = $data->office_visit;
        } else {
            $bookkeeping['office_visit'] = '';
        }
        if (isset($bookkeeping['existing_practice_id']) && $bookkeeping['existing_practice_id'] != '') {
            $bookkeeping['existing_practice_id'] = $bookkeeping['existing_practice_id'];
        } else {
            $bookkeeping['existing_practice_id'] = '';
        }
        //$bookkeeping['existing_practice_id'] = $data->existing_practice_id;
        if (isset($data->corporate_tax_return) && $data->corporate_tax_return != '') {
            $bookkeeping['corporate_tax_return'] = $data->corporate_tax_return;
        } else {
            $bookkeeping['corporate_tax_return'] = '';
        }
        $bookkeeping['sub_category'] = $data->bookkeeping_sub_cat;
        $bookkeeping_data = $this->get_bookkeeping_by_order_id($data->order_id);
        if (isset($data->type_of_client) && $data->type_of_client != '') {
            $data->type_of_client = $data->type_of_client;
        } else {
            $data->type_of_client = '';
        }
        if (isset($data->client_list) && $data->client_list != '') {
            $data->client_list = $data->client_list;
        } else {
            $data->client_list = '';
        }
        if (empty($bookkeeping_data)) {
            $bookkeeping['order_id'] = $data->order_id;
            $bookkeeping['company_id'] = $data->reference_id;
            $bookkeeping['new_existing'] = $data->type_of_client;
            $bookkeeping['existing_ref_id'] = $data->client_list;
            return $this->db->insert('bookkeeping', $bookkeeping);
        } else {
            $this->db->where('id', $bookkeeping_data['id']);
            return $this->db->update('bookkeeping', $bookkeeping);
        }
    }

    public function get_bookkeeping_by_order_id($order_id,$reference='') {
        if($reference!='project'){
            return $this->db->get_where('bookkeeping', ['order_id' => $order_id])->row_array();
        }else{
            return $this->db->get_where('bookkeeping', ['order_id' => $order_id,'reference'=>'project'])->row_array();
        }
    }

    public function related_create_bookkeeping_by_date($data) {
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('Internal');
        $this->load->model('System');
        $this->load->model('Service');

        $conn = $this->db;
        $this->db->trans_begin();
        $data = (object) $data;
        $this->save_bookkeeping_data($data);
        $this->service_model->update_account_order_id_by_new_reference_id($data->new_reference_id, $data->order_id);

        if ($data->retail_price_override) {
            $data->retail_price = $data->retail_price_override;
        }

        $sql = "update service_request set price_charged={$data->retail_price} where order_id={$data->order_id} and services_id={$data->service_id}";
        $conn->query($sql);

        $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $data->order_id . '" order by `date_started` asc')->result_array();
        if (!empty($get_target_start_query)) {
            $target_start_date = $get_target_start_query[0]['date_started'];
        }

        $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $data->order_id . '" order by `date_completed` desc')->result_array();
        if (!empty($get_target_end_query)) {
            $target_end_date = $get_target_end_query[0]['date_completed'];
        }
        $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $data->order_id) where id = $data->order_id";
        $conn->query($sql);


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function related_create_recurring_bookkeeping($data) {
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('Internal');
        $this->load->model('System');
        $this->load->model('Service');

        $conn = $this->db;
        $this->db->trans_begin();
        $data = (object) $data;
        $this->save_bookkeeping_data($data);
        $this->service_model->update_account_order_id_by_new_reference_id($data->new_reference_id, $data->order_id);

        if ($data->retail_price_override) {
            $data->retail_price = $data->retail_price_override;
        }

        $sql = "update service_request set price_charged={$data->retail_price} where order_id={$data->order_id} and services_id={$data->service_id}";
        $conn->query($sql);

        $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $data->order_id . '" order by `date_started` asc')->result_array();
        if (!empty($get_target_start_query)) {
            $target_start_date = $get_target_start_query[0]['date_started'];
        }

        $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $data->order_id . '" order by `date_completed` desc')->result_array();
        if (!empty($get_target_end_query)) {
            $target_end_date = $get_target_end_query[0]['date_completed'];
        }
        $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $data->order_id) where id = $data->order_id";
        $conn->query($sql);


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_account_list_by_order_id($order_id) {
        return $this->db->get_where("financial_accounts", ['order_id' => $order_id])->result_array();
    }

}
