<?php

class Rt6_model extends CI_Model {

    public function request_create_rt6_unemployment_app($data) {
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('Internal');
        $this->load->model('System');
        $this->load->model('Notes');
        $this->load->model('Service');
        $this->load->model('billing_model');
        $this->load->model('action_model');
        $this->db->trans_begin();
//        print_r($data); exit;
        if ($data['type_of_client'] == 0) {
            $sql = $this->db->query("select name from company where id='" . $data['client_list'] . "'")->row_array();
            $data['name_of_business1'] = $sql['name'];
            $data['name_of_company'] = $sql['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        $conn = $this->db;

        if ($data['type_of_client'] != 0) {
            $data['client_list'] = '0';
        }
        if ($data['editval'] == '') {       //add payroll section
            // Save company information
            $service_id = $data['service_id'];
            $this->load->model('Company');
            if (!$this->company_model->save_company_data($this->company_model->make_payroll_company_data($data))) {
                return false;
            } else {
                $this->Company->removeCompanyTempFlag($data['reference_id']);
            }

            if ($data['type_of_client'] != 0) {
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
                //$this->action_model->insert_client_action($data);
            }
            // Save company internal data
//            $this->Notes->saveNotes($data);

            $data = (object) $data;

            if ($_FILES['passport']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['passport'])) {
                    $passport_filename = $this->file_uploaded;
                } else {
                    $passport_filename = '';
                }
            } else {
                $passport_filename = '';
            }

            if ($_FILES['lease']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['lease'])) {
                    $lease_filename = $this->file_uploaded;
                } else {
                    $lease_filename = '';
                }
            } else {
                $lease_filename = '';
            }

            if (!isset($data->residenttype)) {
                $data->residenttype = "";
            }

            if ($_FILES['void_cheque']['name'] != '') {
                if ($this->uploadvoidcheque($_FILES['void_cheque'])) {
                    $void_check_filename = $this->file_uploaded;
                } else {
                    $void_check_filename = '';
                }
            } else {
                $void_check_filename = '';
            }

            $license_file = [];
            if (!empty($_FILES['license_file'])) {
                foreach ($_FILES['license_file'] as $ind => $license) {
                    $i = 0;
                    foreach ($license as $val) {
                        $license_file[$i][$ind] = $val;
                        $i++;
                    }
                }
            }

            $tracking = time();
            $sql = "insert into `order` (order_date, tracking, staff_requested_service, reference, reference_id, status, category_id, service_id) 
                values 
                ('" . date('Y-m-d h:i:s') . "', '{$tracking}', {$this->System->getLoggedUserId()}, 'company', {$data->reference_id}, 2, 2, {$service_id})";
            if ($conn->query($sql)) {
                $order_id = $conn->insert_id();
                $this->System->log("insert", "order", $order_id);
            } else {
                return false;
            }

            if(!isset($data->Rt6need)){
                $data->Rt6need = '';
            }


            $this->db->query("INSERT INTO `rt6_unemployment_app` (`id`, `new_existing`, `existing_ref_id`, `existing_practice_id`, `reference_id`, `order_id`, `start_month_year`, `bank_name`, `bank_account_number`, `bank_routing_number`, `acc_type1`, `acc_type2`, `salestax_availability`, `need_rt6`, `salestax_number`, `state`, `void_cheque`, `resident_type`, `passport`, `lease`, `contact_phone_no`) VALUES ('', '{$data->type_of_client}', '{$data->client_list}', '{$data->existing_practice_id}', '{$data->reference_id}', '$order_id', '{$data->start_year}', '{$data->bank_name}', '{$data->bank_account}', '{$data->bank_routing}', '{$data->acctype1}', '{$data->acctype2}', '{$data->Rt6}', '{$data->Rt6need}', '{$data->rt6_number}', '{$data->state}', '$void_check_filename', '{$data->residenttype}', '$passport_filename', '$lease_filename', '{$data->contact_phone_no}')");

            if (count($license_file) > 0) {
                foreach ($license_file as $val) {
                    if ($val['name'] != '') {
                        if ($this->uploaddocs($val)) {
                            $this->db->insert('rt6_driver_license_data', ['reference_id' => $data->reference_id, 'order_id' => $order_id, 'file_name' => $this->file_uploaded]);
                            $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('','company','{$data->reference_id}','SALES LICENSE','{$this->file_uploaded}',1,'$order_id') "); 
                        }
                    }
                }
            }
            
//            rt6 in document table
             
            $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES VOID CHEQUE','$void_check_filename',1,'$order_id') ");
            
            if($passport_filename!=''){
               $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES PASSPORT','$passport_filename',1,'$order_id') "); 
            }
            if($lease_filename!=''){
               $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES LEASE','$lease_filename',1,'$order_id') ");  
            }


//            if ($data->retail_price_override) {
//                $data->retail_price = $data->retail_price_override;
//            }
            if(isset($data->retail_price_override)){
                $data->retail_price = ($data->retail_price_override=='') ? $data->retail_price : $data->retail_price_override;
            }else{
                $data->retail_price = $data->retail_price;
            }

            $today = date('Y-m-d h:i:s');
            $sales_service_info = $this->service_model->get_service_by_shortname('acc_r_a_-_u');
            $sales_service_id = $sales_service_info['id'];
            $target_query = $this->db->query("select * from target_days where service_id='".$sales_service_id."'")->result_array();
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
                '{$sales_service_id}',
                {$data->retail_price},
                '{$tracking}',
                '{$start_date}',
                '{$end_date}',
                {$this->System->getLoggedUserOfficeId()},
                {$this->System->getLoggedUserId()},
                '2'
                )";
            $conn->query($sql);

            if (isset($data->payroll_rt6_notes)) {
                $this->Notes->insert_note(5, $data->payroll_rt6_notes, 'reference_id', $data->reference_id);
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
            $this->Company->update_title_status($data->reference_id);
            $this->System->update_order_serial_id_by_order_id($order_id);
            $this->System->log("insert", "order", $order_id);

            /* invoice section */

            $today = date('Y-m-d h:i:s');
            $invoice_info_data['reference_id'] = $data->reference_id;

            $invoice_info_data['type'] = '1';

            $invoice_info_data['new_existing'] = $data->type_of_client;
            if ($data->type_of_client == 0) {
                $invoice_info_data['existing_reference_id'] = $data->client_list;
            }
            $invoice_info_data['start_month_year'] = $data->start_year;
            $invoice_info_data['existing_practice_id'] = $data->existing_practice_id;
            $invoice_info_data['created_by'] = sess('user_id');
            $invoice_info_data['order_id'] = $order_id;
            $invoice_info_data['created_time'] = $today;
            $invoice_info_data['status'] = '1';
            $this->db->insert('invoice_info', $invoice_info_data);
            $invoice_id = $this->db->insert_id();
            // Create a new order for this request
            $this->insert_invoice_services($data, $invoice_id);
            $this->system->log("insert", "invoice", $invoice_id);
            $data= (array) $data;
//            print_r($data);die
            /* invoice section */

            // /* mail section */

            // $user_id = $_SESSION['user_id'];
            // $ci = &get_instance();
            // $ci->load->model('Staff');
            // $user_info = $ci->Staff->StaffInfo($user_id);
            // $user_type = $user_info[0]['department'];
            // $user_email = "'" . $user_info[0]['user'] . "'";
            // $user_name = $user_info[0]['first_name'] . ' ' . $user_info[0]['last_name'];
            // $admin_email = 'leafpay@taxleaf.com';

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

            // // if (isset($data->related_services) && $data->related_services != '0' && count($data->related_services) > 0) {
            // //     $related_services = $data->related_services;
            // //     $total_services = count($related_services) + 1;
            // // } else {
            // //     $total_services = 1;
            // // }
            // // $amount_query = $this->db->query("select sum(price_charged) as total from service_request where order_id = '$order_id'")->result_array();
            // // $total = $amount_query[0]['total'];

            // $email_subject = 'Order #' . $order_id . ' for rt6 unemployment app has been successfully placed';


            // $message = '<table cellpadding="0" cellspacing="0" style=" font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            //                 <tr>
            //                     <td>' .
            //         $user_name .
            //         ',<BR/><BR/> Order #' . $order_id . ' for rt6 unemployment app has been successfully placed on your LeafCloud Portal.
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

            if ($data['type_of_client'] != 0) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['staff_office'];
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

        } else { //update started
            if (!$this->saveCompanydatasalestax($data)) {
                return false;
            } else {
                $this->Company->removeCompanyTempFlag($data['reference_id']);
            }

            // Save company internal data
            if ($data['type_of_client'] != 0) {
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
            }
//            $this->Notes->saveupdateNotes($data);
            $invoice_data = $data;
            $data = (object) $data;
            if (!isset($data->residenttype)) {
                $data->residenttype = "";
            }

            if ($_FILES['passport']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['passport'])) {
                    $passport_filename = $this->file_uploaded;
                } else {
                    $passport_filename = '';
                }
            } else {
                $passport_filename = '';
            }

            if ($_FILES['lease']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['lease'])) {
                    $lease_filename = $this->file_uploaded;
                } else {
                    $lease_filename = '';
                }
            } else {
                $lease_filename = '';
            }


//            $this->db->query("delete from `payroll_account_numbers` where reference_id='{$data->reference_id}'");

            if ($_FILES['void_cheque']['name'] != '') {
                if ($this->uploadvoidcheque($_FILES['void_cheque'])) {
                    $void_check_filename = $this->file_uploaded;
                } else {
                    $void_check_filename = '';
                }
            } else {
                $void_check_filename = '';
            }

            $sales_sql = "update `rt6_unemployment_app` set new_existing='{$data->type_of_client}', existing_ref_id='{$data->client_list}', existing_practice_id='{$data->existing_practice_id}', reference_id='{$data->reference_id}', start_month_year='{$data->start_year}', bank_name='{$data->bank_name}', bank_account_number='{$data->bank_account}', bank_routing_number='{$data->bank_routing}', acc_type1={$data->acctype1}, acc_type2={$data->acctype2}, salestax_availability='{$data->Rt6}', need_rt6='{$data->Rt6need}', salestax_number='{$data->rt6_number}', state='{$data->state}', resident_type='{$data->residenttype}', contact_phone_no='{$data->contact_phone_no}'";

            if ($void_check_filename != '') {
                $sales_sql .= ", void_cheque='{$void_check_filename}'";
            }

            if ($lease_filename != '') {
                $sales_sql .= ", lease='{$lease_filename}'";
            }

            if ($passport_filename != '') {
                $sales_sql .= ", passport='{$passport_filename}'";
            }

            $sales_sql .= "where order_id={$data->editval}";

            $this->db->query($sales_sql);


            $license_file = [];
            if (!empty($_FILES['license_file'])) {
                foreach ($_FILES['license_file'] as $ind => $license) {
                    $i = 0;
                    foreach ($license as $val) {
                        $license_file[$i][$ind] = $val;
                        $i++;
                    }
                }
            }
            if (count($license_file) > 0) {
                foreach ($license_file as $val) {
                    if ($val['name'] != '') {
                        if ($this->uploaddocs($val)) {
                            $this->db->insert('rt6_driver_license_data', ['reference_id' => $data->reference_id, 'order_id' => $data->editval, 'file_name' => $this->file_uploaded]);
                            $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES LICENSE','$passport_filename',1,'{$data->editval}') "); 
                        }
                    }
                }
            }
//             edit rt6 file in document table
            
            $this->db->query("DELETE FROM documents WHERE order_id='{$data->editval}'");
            $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES VOID CHEQUE','$void_check_filename',1,'{$data->editval}') ");
            
            if($passport_filename!=''){
               $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES PASSPORT','$passport_filename',1,'{$data->editval}') "); 
            }
            if($lease_filename!=''){
               $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES LEASE','$lease_filename',1,'{$data->editval}') ");  
            }

            if (isset($data->edit_payroll_rt6_notes)) {
                $this->Notes->update_note(5, $data->edit_payroll_rt6_notes);
            }
            if (isset($data->payroll_rt6_notes)) {
                $this->Notes->insert_note(5, $data->payroll_rt6_notes, 'reference_id', $data->reference_id);
            }

//            if ($data->retail_price_override) {
//                $data->retail_price = $data->retail_price_override;
//            }
             if(isset($data->retail_price_override)){
                $data->retail_price = ($data->retail_price_override=='') ? $data->retail_price : $data->retail_price_override;
            }else{
                $data->retail_price = $data->retail_price;
            }

            $orderid = $data->editval;

            $tracking = time();

            $sql = "update service_request set price_charged={$data->retail_price}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$orderid} and services_id=42";
            $conn->query($sql);

            // Create a new order for this request
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
            $this->System->log("insert", "order", $order_id);
            $invoice_data['order_id'] = $order_id;
            $this->billing_model->update_invoice_data($invoice_data);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    private function uploadpdffiles($file) {

        $upload_dir = FCPATH . 'uploads/';
        $temp = explode('.', $file['name']);
        $extension = strtolower(end($temp));
        $filename = trim(strtolower(reset($temp)));
        $save_as = time() . "_" . $filename . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('pdf');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['size'] > $max_size) {
                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message = "File uploaded successfully";
                    $this->file_uploaded = $save_as;
                    return true;
                }
            }
        }
    }

    private function uploadfein($file) {

        $upload_dir = FCPATH . 'uploads/';
        $temp = explode('.', $file['name']);
        $extension = strtolower(end($temp));
        $filename = trim(strtolower(reset($temp)));
        $save_as = time() . "_" . $filename . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('doc', 'docx');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['size'] > $max_size) {
                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message = "File uploaded successfully";
                    $this->file_uploaded = $save_as;
                    return true;
                }
            }
        }
    }

    private function uploadPayrollForms($file) {

        $upload_dir = FCPATH . 'uploads/';
        $temp = explode('.', $file['name']);
        $extension = strtolower(end($temp));
        $filename = trim(strtolower(reset($temp)));
        $save_as = time() . "_" . $filename . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('pdf');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['size'] > $max_size) {
                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message = "File uploaded successfully";
                    $this->file_uploaded = $save_as;
                    return true;
                }
            }
        }
    }

    private function uploadPayrollFormsxls($file) {

        $upload_dir = FCPATH . 'uploads/';
        $temp = explode('.', $file['name']);
        $extension = strtolower(end($temp));
        $filename = trim(strtolower(reset($temp)));
        $save_as = time() . "_" . $filename . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('xls', 'xlsx');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['size'] > $max_size) {
                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message = "File uploaded successfully";
                    $this->file_uploaded = $save_as;
                    return true;
                }
            }
        }
    }

    private function uploadvoidcheque($file) {

        $upload_dir = FCPATH . 'uploads/';
        $temp = explode('.', $file['name']);
        $extension = strtolower(end($temp));
        $filename = trim(strtolower(reset($temp)));
        $save_as = time() . "_" . $filename . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('pdf');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['size'] > $max_size) {
                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message = "File uploaded successfully";
                    $this->file_uploaded = $save_as;
                    return true;
                }
            }
        }
    }

    private function uploaddocs($file) {

        $upload_dir = FCPATH . 'uploads/';
        $temp = explode('.', $file['name']);
        $extension = strtolower(end($temp));
        $filename = trim(strtolower(reset($temp)));
        $save_as = time() . "_" . $filename . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('jpg', 'jpeg', 'gif', 'png', 'pdf');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['size'] > $max_size) {
                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message = "File uploaded successfully";
                    $this->file_uploaded = $save_as;
                    return true;
                }
            }
        }
    }

    public function get_sales_by_id($id) {
        return $this->db->get_where('order', ['id' => $id])->row_array();
    }

    public function get_override_price($service_id, $order_id) {
        $sql = "select * from service_request where order_id='$order_id' and services_id='$service_id'";
        return $this->db->query($sql)->result_array();
    }

    public function get_rt6_data($id) {
        $sql = "select * from rt6_unemployment_app where order_id='$id'";
        return $this->db->query($sql)->result_array();
    }

    public function get_salestax_driver_license_data_by_order_id($id) {
        return $this->db->get_where("rt6_driver_license_data", ['order_id' => $id])->result_array();
    }

    public function saveCompanydatasalestax($data) {
        $data = (object) $data; // convert the post array into an object
        $this->load->model('System');
        $desc = urlencode($data->business_description);
        if (!isset($data->incorporated_date)) {
            $data->incorporated_date = date("d/m/Y");
        }
        // if (!isset($data->istate)) {
        //     $data->istate = 0;
        // }

        $sql = "update company set
                name='{$data->name_of_company}',
                dba='{$data->dba}',
                fein='{$data->fein}',
                type='{$data->type}',  
                fye='{$data->fye}', 
                state_opened='{$data->istate}',  
                business_description='{$desc}',
                fax='{$data->company_fax}',
                email='{$data->company_email}',
                start_month_year='{$data->start_year}'
                where id='{$data->reference_id}'";

        $conn = $this->db;
        if ($conn->query($sql)) {
            $last_id = $conn->insert_id();
            $this->System->log("update", "company", $last_id);
            return true;
        } else {
            return false;
        }
    }

    public function insert_invoice_services($data, $invoice_id) {
        $this->load->model('System');
        $this->load->model('Notes');
        $tracking = time();
        $today = date('Y-m-d h:i:s');
        //foreach ($data['service_section'] as $key => $value) {
        $service_data = $data;
        $order_data['order_date'] = date('Y-m-d h:i:s');
        $order_data['tracking'] = $tracking;
        $order_data['staff_requested_service'] = sess('user_id');
        $order_data['reference'] = 'invoice';
        $order_data['reference_id'] = $service_data->reference_id;
        $order_data['status'] = 10;
        $order_data['category_id'] = '2';
        $order_data['service_id'] = $service_data->service_id;
        $order_data['quantity'] = '1';
        $order_data['invoice_id'] = $invoice_id;
        if ($this->db->insert('order', $order_data)) {
            $order_id = $this->db->insert_id();
        } else {
            return false;
        }
        $target_query = $this->db->get_where("target_days", ["service_id" => 42])->row_array();
        $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_query['start_days'] . ' days'));
        $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_query['end_days'] . ' days'));


        $service_request['order_id'] = $order_id;
        $service_request['services_id'] = $service_data->service_id;
        $service_request['price_charged'] = ($service_data->retail_price_override != '') ? $service_data->retail_price_override : $service_data->retail_price;
        $service_request['tracking'] = $tracking;
        $service_request['date_started'] = $start_date;
        $service_request['date_completed'] = $end_date;
        $service_request['responsible_department'] = $this->System->getLoggedUserOfficeId();
        $service_request['responsible_staff'] = sess('user_id');
        $service_request['status'] = 2;
        $this->db->insert('service_request', $service_request);

        $this->db->order_by("date_started", "asc");
        $target_start = $this->db->get_where('service_request', ['order_id' => $order_id])->row_array();
        if (!empty($target_start)) {
            $target_start_date = $target_start['date_started'];
        }

        $this->db->order_by("date_started", "desc");
        $target_end = $this->db->get_where('service_request', ['order_id' => $order_id])->row_array();
        if (!empty($target_end)) {
            $target_end_date = $target_end['date_completed'];
        }

        // Update the total amount of order
        $this->db->select('sum(price_charged) as total_price');
        $total_price = $this->db->get_where('service_request', ['order_id' => $order_id])->row_array();

        $update_order_data['start_date'] = $target_start_date;
        $update_order_data['complete_date'] = $target_end_date;
        $update_order_data['target_start_date'] = $target_start_date;
        $update_order_data['target_complete_date'] = $target_end_date;
        $update_order_data['total_of_order'] = $total_price['total_price'];
        $this->db->where(['id' => $order_id]);
        $this->db->update('order', $update_order_data);
        //}
    }

    public function related_create_rt6_unemployment_app($data) {
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('Internal');
        $this->load->model('System');
        $this->load->model('Notes');
        $this->load->model('Service');
        $this->db->trans_begin();

        $conn = $this->db;

        $data = (object) $data;

        if ($_FILES['passport']['name'] != '') {
            if ($this->uploadpdffiles($_FILES['passport'])) {
                $passport_filename = $this->file_uploaded;
            } else {
                $passport_filename = '';
            }
        } else {
            $passport_filename = '';
        }

        if ($_FILES['lease']['name'] != '') {
            if ($this->uploadpdffiles($_FILES['lease'])) {
                $lease_filename = $this->file_uploaded;
            } else {
                $lease_filename = '';
            }
        } else {
            $lease_filename = '';
        }

        if (!isset($data->residenttype)) {
            $data->residenttype = "";
        }


        if (!isset($data->Rt6need)) {
            $data->Rt6need = '';
        }

        if (!isset($data->existing_practice_id)) {
            $data->existing_practice_id = "";
        }

        if (!isset($data->type_of_client)) {
            $data->type_of_client = "";
        }
        if (!isset($data->client_list)) {
            $data->client_list = "";
        }
        if (!isset($data->start_year)) {
            $data->start_year = "";
        }


        if ($_FILES['void_cheque']['name'] != '') {
            if ($this->uploadvoidcheque($_FILES['void_cheque'])) {
                $void_check_filename = $this->file_uploaded;
            } else {
                $void_check_filename = '';
            }
        } else {
            $void_check_filename = '';
        }

        $license_file = [];
        if (!empty($_FILES['license_file'])) {
            foreach ($_FILES['license_file'] as $ind => $license) {
                $i = 0;
                foreach ($license as $val) {
                    $license_file[$i][$ind] = $val;
                    $i++;
                }
            }
        }

        if ($data->retail_price_override) {
            $data->retail_price = $data->retail_price_override;
        }

        $tracking = time();

        $order_id = $data->order_id;

        $check_if_rt6_unemployment_app_exists = $this->check_if_rt6_unemployment_app_exists($data->order_id);

        if (empty($check_if_rt6_unemployment_app_exists)) {

            $this->db->query("INSERT INTO `rt6_unemployment_app` (`id`, `new_existing`, `existing_ref_id`, `existing_practice_id`, `reference_id`, `order_id`, `start_month_year`, `bank_name`, `bank_account_number`, `bank_routing_number`, `acc_type1`, `acc_type2`, `salestax_availability`, `need_rt6`, `salestax_number`, `state`, `void_cheque`, `resident_type`, `passport`, `lease`) VALUES ('', '{$data->type_of_client}', '{$data->client_list}', '{$data->existing_practice_id}', '{$data->reference_id}', '$order_id', '{$data->start_year}', '{$data->bank_name}', '{$data->bank_account}', '{$data->bank_routing}', '{$data->acctype1}', '{$data->acctype2}', '{$data->Rt6}', '{$data->Rt6need}', '{$data->rt6_number}', '{$data->state}', '$void_check_filename', '{$data->residenttype}', '$passport_filename', '$lease_filename')");
        } else {

            $sales_sql = "update `rt6_unemployment_app` set new_existing='{$data->type_of_client}', existing_ref_id='{$data->client_list}', existing_practice_id='{$data->existing_practice_id}', reference_id='{$data->reference_id}', start_month_year='{$data->start_year}', bank_name='{$data->bank_name}', bank_account_number='{$data->bank_account}', bank_routing_number='{$data->bank_routing}', acc_type1={$data->acctype1}, acc_type2={$data->acctype2}, salestax_availability='{$data->Rt6}', need_rt6='{$data->Rt6need}', salestax_number='{$data->rt6_number}', state='{$data->state}', resident_type='{$data->residenttype}'";

            if ($void_check_filename != '') {
                $sales_sql .= ", void_cheque='{$void_check_filename}'";
            }

            if ($lease_filename != '') {
                $sales_sql .= ", lease='{$lease_filename}'";
            }

            if ($passport_filename != '') {
                $sales_sql .= ", passport='{$passport_filename}'";
            }

            $sales_sql .= "where order_id={$order_id}";

            $this->db->query($sales_sql);
        }

        if (count($license_file) > 0) {
            foreach ($license_file as $val) {
                if ($val['name'] != '') {
                    if ($this->uploaddocs($val)) {
                        $this->db->insert('sales_driver_license_data', ['reference_id' => $data->reference_id, 'order_id' => $order_id, 'file_name' => $this->file_uploaded]);
                    }
                }
            }
        }

        $today = date('Y-m-d h:i:s');
        $target_query = $this->db->query("select * from target_days where service_id='$data->rt6_service_id'")->result_array();
        $target_start = $target_query[0]['start_days'];
        $target_end = $target_query[0]['end_days'];
        $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
        $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));

        $check_if_rt6_exists_for_this_order = $this->check_if_rt6_exists_for_this_order($data->rt6_service_id, $data->order_id);

        if (empty($check_if_rt6_exists_for_this_order)) {

            $sql = "insert into service_request
                (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
                values
                (
                {$data->order_id},
                {$data->rt6_service_id},
                {$data->retail_price},
                '{$tracking}',
                '{$start_date}',
                '{$end_date}',
                {$this->System->getLoggedUserOfficeId()},
                {$this->System->getLoggedUserId()},
                '2'
                )";
            $conn->query($sql);
        } else {
            $sql = "update service_request set price_charged={$data->retail_price}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$data->order_id} and services_id={$data->rt6_service_id}";
            $conn->query($sql);
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

    public function check_if_rt6_unemployment_app_exists($order_id) {
        $query = "select * from `rt6_unemployment_app` where order_id='" . $order_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function check_if_rt6_exists_for_this_order($rt6_service_id, $order_id) {
        $query = "select * from `service_request` where order_id='" . $order_id . "' and services_id='" . $rt6_service_id . "'";
        return $this->db->query($query)->row_array();
    }

}
