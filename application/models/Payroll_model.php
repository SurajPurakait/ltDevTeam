<?php

class Payroll_model extends CI_Model {

    public function get_payroll_by_id($id) {
        return $this->db->get_where('order', ['id' => $id])->row_array();
    }

    public function get_payroll_data($reference_id) {
        return $this->db->get_where("payroll_company_data", ['reference_id' => $reference_id])->result_array();
    }

    public function get_company_by_id($id) {
        return $this->db->get_where("company", ['id' => $id])->row_array();
    }

    public function payroll_company_data($id) {
        return $this->db->get_where("payroll_company_data", ['reference_id' => $id])->row_array();
    }

    public function request_create_payroll($data) {
        $this->load->model('Company');
        $this->load->model('action_model');
        $this->load->model('company_model');
        $this->load->model('Internal');
        $this->load->model('System');
        $this->load->model('Notes');
        $this->load->model('Service');
        $this->load->model('billing_model');
        $this->db->trans_begin();
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
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company_data($this->company_model->make_payroll_company_data($data))) {
                    return false;
                } else {
                    $this->Company->removeCompanyTempFlag($data['reference_id']);
                }
                // Save company internal data
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
                //$this->action_model->insert_client_action($data);
            }
            $invoice_data = $data;
            $data = (object) $data;
            $tracking = time();
            $sql = "insert into `order` (order_date, tracking, staff_requested_service, reference, reference_id, status, category_id, service_id) 
                values 
                ('" . date('Y-m-d h:i:s') . "', '{$tracking}', {$this->System->getLoggedUserId()}, 'company', {$data->reference_id}, 2, 2, 11)";
            if ($conn->query($sql)) {
                $order_id = $conn->insert_id();
            } else {
                return false;
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
            $target_query = $this->db->query("select * from target_days where service_id='42'")->result_array();
            $target_start = $target_query[0]['start_days'];
            $target_end = $target_query[0]['end_days'];
            $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
            $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));

            $tracking = time();
            if ($data->Rt6 == 'No') {
                $sql = "insert into service_request
                (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
                values
                (
                {$order_id},
                '42',
                {$data->retail_price},
                '{$tracking}',
                '{$start_date}',
                '{$end_date}',
                {$this->System->getLoggedUserOfficeId()},
                {$this->System->getLoggedUserId()},
                '2'
                )";
                $conn->query($sql);
                $invoice_data['related_services'][] = 42;
                $invoice_data['related_service']['retail_price'][42] = $data->retail_price;
                $invoice_data['related_service']['override_price'][42] = $data->retail_price_override;
            }
            if ($data->employee_related_service['override_price']) {
                $data->retail_price_payroll = $data->employee_related_service['override_price'];
            } else {
                $data->retail_price_payroll = $data->employee_related_service['retail_price'];
            }
            $invoice_data['retail_price_override'] = $data->employee_related_service['override_price'];
            $invoice_data['retail_price'] = $data->employee_related_service['retail_price'];
            $target_query_pay = $this->db->query("select * from target_days where service_id='11'")->result_array();
            $target_start_pay = $target_query_pay[0]['start_days'];
            $target_end_pay = $target_query_pay[0]['end_days'];
            $start_date_pay = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start_pay . ' days'));
            $end_date_pay = date('Y-m-d h:i:s', strtotime($start_date_pay . ' + ' . $target_end_pay . ' days'));

            $tracking = time();
            $sql = "insert into service_request
                (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
                values
                (
                {$order_id},
                '11',
                {$data->retail_price_payroll},
                '{$tracking}',
                '{$start_date}',
                '{$end_date}',
                {$this->System->getLoggedUserOfficeId()},
                {$this->System->getLoggedUserId()},
                '2'
                )";
            $conn->query($sql);

            if ($_FILES['fein_file']['name'] != '') {
                if ($this->uploadfein($_FILES['fein_file'])) {
                    $fein_filename = $this->file_uploaded;
                } else {
                    $fein_filename = '';
                }
            } else {
                $fein_filename = '';
            }
            $this->db->query("INSERT INTO `payroll_company_data` (`id`, `new_existing`, `order_id`, `existing_ref_id`,`existing_practice_id`, `reference_id`, `company_address`, start_month_year, `fein_filename`, `company_started`, `phone_number`) VALUES ('', '{$data->type_of_client}', '{$order_id}', '{$data->client_list}', '{$data->existing_practice_id}','{$data->reference_id}', '{$data->company_address}', '{$data->start_year}', '$fein_filename', '{$data->company_started}', '{$data->company_phone}')");


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

            $this->db->query("INSERT INTO `payroll_account_numbers` (`id`, `reference_id`, `order_id`, `bank_name`, `ban_account_number`, `bank_routing_number`, `rt6_availability`, `rt6_number`, `state`, `void_cheque`, `resident_type`, `drivers_license`, `passport`, `lease`) VALUES ('', '{$data->reference_id}', '{$order_id}', '{$data->bank_name}', '{$data->bank_account}', '{$data->bank_routing}', '{$data->Rt6}', '{$data->rt6_number}', '{$data->state}', '$void_check_filename', '{$data->residenttype}', '', '$passport_filename', '$lease_filename')");

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
                            $this->db->insert('payroll_driver_license_data', ['reference_id' => $data->reference_id, 'order_id' => $order_id, 'file_name' => $this->file_uploaded]);
                        }
                    }
                }
            }

            $this->db->query("INSERT INTO `payroll_data` (`id`, `reference_id`, `order_id`, `payroll_frequency`, `payday`) VALUES ('', '{$data->reference_id}', '{$order_id}','{$data->payroll_frequency}', '{$data->payday}')");

            $update_payroll = array(
                'fname' => $data->payroll_first_name,
                'lname' => $data->payroll_last_name,
                'title' => $data->payroll_title,
                'social_security' => $data->payroll_social_security,
                'phone' => $data->payroll_phone,
                'ext' => $data->payroll_ext,
                'fax' => $data->payroll_fax,
                'email' => $data->payroll_email
            );
            $this->db->where(['reference_id' => $data->reference_id]);
            $this->db->update('payroll_approver', $update_payroll);
            $update_company = array(
                'fname' => $data->company_principal_first_name,
                'lname' => $data->company_principal_last_name,
                'title' => $data->company_principal_title,
                'social_security' => $data->company_principal_social_security,
                'phone' => $data->company_principal_phone,
                'ext' => $data->company_principal_ext,
                'fax' => $data->company_principal_fax,
                'email' => $data->company_principal_email
            );
            $this->db->where(['reference_id' => $data->reference_id]);
            $this->db->update('company_principal', $update_company);
            if ($this->db->get_where('signer_data', ['reference_id' => $data->reference_id])->num_rows() > 0) {
                $update_signer = array(
                    'fname' => $data->signer_first_name,
                    'lname' => $data->signer_last_name,
                    'social_security' => $data->signer_social_security
                );
                $this->db->where(['reference_id' => $data->reference_id]);
                $this->db->update('signer_data', $update_signer);
            } else {
                $insert_signer = array(
                    'fname' => $data->signer_first_name,
                    'lname' => $data->signer_last_name,
                    'social_security' => $data->signer_social_security,
                    'reference_id' => $data->reference_id
                );
                $this->db->insert('signer_data', $insert_signer);
            }

            $emp_dtl = $data->employee_related_service;
            $emp_dtl['reference_id'] = $data->reference_id;
            $this->db->insert('payroll_employee_details', $emp_dtl);
            if (isset($data->payroll_employee_notes)) {
                $this->Notes->insert_note(4, $data->payroll_employee_notes, 'reference_id', $data->reference_id);
            }

            if (isset($data->company_notes)) {
                $this->Notes->insert_note(1, $data->company_notes, 'reference_id', $data->reference_id, 'company');
            }
            //Payroll Sheet Upload
            if ($_FILES['bi_weekly']['name'] != '') {
                if ($this->uploadPayrollFormsxls($_FILES['bi_weekly'])) {
                    $bi_weekly_form_name = $this->file_uploaded;
                    $this->db->query("INSERT INTO `payroll_wage_files` (`reference_id`, `type`, `file_name`) VALUES ('{$data->reference_id}', 1 ,'$bi_weekly_form_name' )");
                }
            }

            if ($_FILES['weekly']['name'] != '') {
                if ($this->uploadPayrollFormsxls($_FILES['weekly'])) {
                    $weekly_form_name = $this->file_uploaded;
                    $this->db->query("INSERT INTO `payroll_wage_files` (`reference_id`, `type`, `file_name`) VALUES ('{$data->reference_id}', 2 ,'$weekly_form_name' )");
                }
            }
            //Payroll Sheet Upload            
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
            /* mail section */
            $invoice_data['order_id'] = $order_id;
            $this->billing_model->insert_invoice_data($invoice_data);
            $this->System->save_general_notification('order', $order_id, 'insert');
            $data= (array) $data;            
            $user_id = $_SESSION['user_id'];
            $ci = &get_instance();
            $ci->load->model('Staff');
            $user_info = $ci->Staff->StaffInfo($user_id);
            $user_type = $user_info[0]['department'];
            $user_email = "'" . $user_info[0]['user'] . "'";
            $user_name = $user_info[0]['first_name'] . ' ' . $user_info[0]['last_name'];
            $admin_email = 'leafpay@taxleaf.com';

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

            // if (isset($data->related_services) && $data->related_services != '0' && count($data->related_services) > 0) {
            //     $related_services = $data->related_services;
            //     $total_services = count($related_services) + 1;
            // } else {
            //     $total_services = 1;
            // }
            // $amount_query = $this->db->query("select sum(price_charged) as total from service_request where order_id = '$order_id'")->result_array();
            // $total = $amount_query[0]['total'];

            $email_subject = 'Order #' . $order_id . ' for payroll has been successfully placed';


            $message = '<table cellpadding="0" cellspacing="0" style=" font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                            <tr>
                                <td>' .
                    $user_name .
                    ',<BR/><BR/> Order #' . $order_id . ' for payrol has been successfully placed on your LeafCloud Portal.
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


            if ($data['type_of_client'] == 1) {
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
        } else {
            if ($data['type_of_client'] == 1) {
                if (!$this->Company->saveCompanydatapayroll($data)) {
                    return false;
                } else {
                    $this->Company->removeCompanyTempFlag($data['reference_id']);
                }

                // Save company internal data
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
            }

//            $this->Notes->saveupdateNotes($data);
            $invoice_data = $data;
            $data = (object) $data;

            $payroll_company_data = [
                "new_existing" => $data->type_of_client,
                "existing_ref_id" => $data->client_list,
                "existing_practice_id" => $data->existing_practice_id,
                "company_address" => $data->company_address,
                "start_month_year" => $data->start_year,
                "company_started" => $data->company_started,
                "phone_number" => $data->company_phone
            ];

            if ($_FILES['fein_file']['name'] != '') {
                if ($this->uploadfein($_FILES['fein_file'])) {
                    $payroll_company_data["fein_filename"] = $this->file_uploaded;
                }
            }

            $this->db->where("order_id", $data->editval);
            $this->db->update("payroll_company_data", $payroll_company_data);
            //print_r($_FILES['fein_file']);exit;
//            $this->db->query("delete from `payroll_company_data` where reference_id='{$data->reference_id}'");
//
//            $this->db->query("INSERT INTO `payroll_company_data` (`id`, `new_existing`, `existing_ref_id`,`existing_practice_id`, `reference_id`, `company_address`, start_month_year, `fein_filename`, `company_started`, `phone_number`) VALUES ('', '{$data->type_of_client}', '{$data->client_list}', '{$data->existing_practice_id}','{$data->reference_id}', '{$data->company_address}', '{$data->start_year}', '$fein_filename', '{$data->company_started}', '{$data->company_phone}')");
//            if ($_FILES['license']['name'] != '') {
//                if ($this->uploaddocs($_FILES['license'])) {
//                    $license_filename = $this->file_uploaded;
//                } else {
//                    $license_filename = '';
//                }
//            } else {
//                $license_filename = '';
//            }

            if (!isset($data->residenttype)) {
                $data->residenttype = "";
            }

            $payroll_account_data = [
                "bank_name" => $data->bank_name,
                "ban_account_number" => $data->bank_account,
                "bank_routing_number" => $data->bank_routing,
                "rt6_availability" => $data->Rt6,
                "rt6_number" => $data->rt6_number,
                "state" => $data->state,
                "resident_type" => $data->residenttype
            ];

            if ($_FILES['passport']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['passport'])) {
                    $payroll_account_data["passport"] = $this->file_uploaded;
                }
            }

            if ($_FILES['lease']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['lease'])) {
                    $payroll_account_data["lease"] = $this->file_uploaded;
                }
            }


//            $this->db->query("delete from `payroll_account_numbers` where reference_id='{$data->reference_id}'");

            if ($_FILES['void_cheque']['name'] != '') {
                if ($this->uploadvoidcheque($_FILES['void_cheque'])) {
                    $payroll_account_data["void_cheque"] = $this->file_uploaded;
                }
            }

//            $this->db->query("INSERT INTO `payroll_account_numbers` (`id`, `reference_id`, `bank_name`, `ban_account_number`, `bank_routing_number`, `rt6_availability`, `rt6_number`, `state`, `void_cheque`, `resident_type`, `drivers_license`, `passport`, `lease`) VALUES ('', '{$data->reference_id}', '{$data->bank_name}', '{$data->bank_account}', '{$data->bank_routing}', '{$data->Rt6}', '{$data->rt6_number}', '{$data->state}', '$void_check_filename', '{$data->residenttype}', '', '$passport_filename', '$lease_filename')");
//            $check_rt6 = $this->get_payroll_account_numbers_by_order_id($data->order_id);
            if ($data->Rt6 == 'No') {
                $invoice_data['related_services'][] = 42;
                $invoice_data['related_service'][$data->order_id][42]['retail_price'] = $data->retail_price;
                $invoice_data['related_service'][$data->order_id][42]['override_price'] = $data->retail_price_override;
//                if (!empty($check_rt6)) {
//                    $this->db->where("order_id", $data->order_id);
//                    $this->db->update("payroll_account_numbers", $payroll_account_data);
//                } else {
//                    $sql = "insert into service_request
//                (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
//                values
//                (
//                {$order_id},
//                '42',
//                {$data->retail_price},
//                '{$tracking}',
//                '{$start_date}',
//                '{$end_date}',
//                {$this->System->getLoggedUserOfficeId()},
//                {$this->System->getLoggedUserId()},
//                '2'
//                )";
//                    $payroll_account_data['reference_id'] = $data['reference_id'];
//                    $payroll_account_data['order_id'] = $data->order_id;
//                    $this->db->insert("payroll_account_numbers", $payroll_account_data);
//                }
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
            if (count($license_file) > 0) {
                foreach ($license_file as $val) {
                    if ($val['name'] != '') {
                        if ($this->uploaddocs($val)) {
                            $this->db->insert('payroll_driver_license_data', ['order_id' => $data->order_id, 'reference_id' => $data->reference_id, 'file_name' => $this->file_uploaded]);
                        }
                    }
                }
            }

            $this->db->delete('payroll_employee_details', ['reference_id' => $data->reference_id]);
            $emp_dtl = $data->employee_related_service;
            $emp_dtl['reference_id'] = $data->reference_id;
            $this->db->insert('payroll_employee_details', $emp_dtl);

            if (isset($data->edit_payroll_employee_notes)) {
                $this->Notes->update_note(4, $data->edit_payroll_employee_notes);
            }
            if (isset($data->payroll_employee_notes)) {
                $this->Notes->insert_note(4, $data->payroll_employee_notes, 'reference_id', $data->reference_id);
            }
            if (isset($data->company_notes)) {
                $this->Notes->insert_note(1, $data->company_notes, 'reference_id', $data->reference_id, 'company');
            }
            if (isset($data->edit_company_notes)) {
                $this->Notes->update_note(1, $data->edit_company_notes);
            }

//            $this->db->delete('payroll_employee_notes', ['reference_id' => $data->reference_id]);
//            if (count($data->employee_related_service_notes) > 0) {
//                foreach ($data->employee_related_service_notes as $employee_notes) {
//                    $notes_dtl['reference_id'] = $data->reference_id;
//                    $notes_dtl['notes'] = $employee_notes;
//                    $this->db->insert('payroll_employee_notes', $notes_dtl);
//                }
//            }

            $this->db->query("delete from `payroll_data` where reference_id='{$data->reference_id}'");

            $this->db->query("INSERT INTO `payroll_data` (`id`, `reference_id`, `payroll_frequency`, `payday`) VALUES ('', '{$data->reference_id}', '{$data->payroll_frequency}', '{$data->payday}')");

            $update_payroll = array(
                'fname' => $data->payroll_first_name,
                'lname' => $data->payroll_last_name,
                'title' => $data->payroll_title,
                'social_security' => $data->payroll_social_security,
                'phone' => $data->payroll_phone,
                'ext' => $data->payroll_ext,
                'fax' => $data->payroll_fax,
                'email' => $data->payroll_email
            );
            $this->db->where(['reference_id' => $data->reference_id]);
            $this->db->update('payroll_approver', $update_payroll);
            $update_company = array(
                'fname' => $data->company_principal_first_name,
                'lname' => $data->company_principal_last_name,
                'title' => $data->company_principal_title,
                'social_security' => $data->company_principal_social_security,
                'phone' => $data->company_principal_phone,
                'ext' => $data->company_principal_ext,
                'fax' => $data->company_principal_fax,
                'email' => $data->company_principal_email,
            );
            $this->db->where(['reference_id' => $data->reference_id]);
            $this->db->update('company_principal', $update_company);
            if ($this->db->get_where('signer_data', ['reference_id' => $data->reference_id])->num_rows() > 0) {
                $update_signer = array(
                    'fname' => $data->signer_first_name,
                    'lname' => $data->signer_last_name,
                    'social_security' => $data->signer_social_security
                );
                $this->db->where(['reference_id' => $data->reference_id]);
                $this->db->update('signer_data', $update_signer);
            } else {
                $insert_signer = array(
                    'fname' => $data->signer_first_name,
                    'lname' => $data->signer_last_name,
                    'social_security' => $data->signer_social_security,
                    'reference_id' => $data->reference_id
                );
                $this->db->insert('signer_data', $insert_signer);
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

            //print_r($data->rt6_notes); exit;
//            $this->db->delete('payroll_rt6_notes', ['reference_id' => $data->reference_id]);
//
//            if (count($data->rt6_notes) > 0) {
//                foreach ($data->rt6_notes as $rt6_notes) {
//                    $notes_dtl1['reference_id'] = $data->reference_id;
//                    $notes_dtl1['note'] = $rt6_notes;
//                    $this->db->insert('payroll_rt6_notes', $notes_dtl1);
//                }
//            }

            if (isset($data->edit_payroll_rt6_notes)) {
                $this->Notes->update_note(5, $data->edit_payroll_rt6_notes);
            }
            if (isset($data->payroll_rt6_notes)) {
                $this->Notes->insert_note(5, $data->payroll_rt6_notes, 'reference_id', $data->reference_id);
            }


            if ($data->employee_related_service['override_price']) {
                $data->retail_price_payroll = $data->employee_related_service['override_price'];
            } else {
                $data->retail_price_payroll = $data->employee_related_service['retail_price'];
            }


            $sql = "update service_request set price_charged={$data->retail_price_payroll}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$orderid} and services_id=11";
            $conn->query($sql);

            //Payroll Sheet Upload
            if ($_FILES['bi_weekly']['name'] != '') {
                if ($this->uploadPayrollFormsxls($_FILES['bi_weekly'])) {
                    $bi_weekly_form_name = $this->file_uploaded;
                    $this->db->query("delete from `payroll_wage_files` where reference_id='{$data->reference_id}' and type='1'");
                    $this->db->query("INSERT INTO `payroll_wage_files` (`reference_id`, `type`, `file_name`) VALUES ('{$data->reference_id}', 1 ,'$bi_weekly_form_name' )");
                }
            }

            if ($_FILES['weekly']['name'] != '') {
                if ($this->uploadPayrollFormsxls($_FILES['weekly'])) {
                    $weekly_form_name = $this->file_uploaded;
                    $this->db->query("delete from `payroll_wage_files` where reference_id='{$data->reference_id}' and type='2'");
                    $this->db->query("INSERT INTO `payroll_wage_files` (`reference_id`, `type`, `file_name`) VALUES ('{$data->reference_id}', 2 ,'$weekly_form_name' )");
                }
            }
            //Payroll Sheet Upload
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
            $this->System->save_general_notification('order', $order_id, 'edit');
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

    public function uploaded_xls_list($reference_id, $type) {
        return $this->db->get_where("payroll_wage_files", ['reference_id' => $reference_id, 'type' => $type])->row_array();
    }

    public function get_payroll_company_data_by_order_id($order_id) {
        return $this->db->get_where("payroll_company_data", ['order_id' => $order_id])->row_array();
    }

    public function get_payroll_account_numbers_by_order_id($order_id) {
        return $this->db->get_where("payroll_account_numbers", ['order_id' => $order_id])->row_array();
    }

    public function related_create_payroll($data) {
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('Internal');
        $this->load->model('System');
        $this->load->model('Notes');
        $this->load->model('Service');
        $this->load->model('billing_model');
        $this->db->trans_begin();
        $conn = $this->db;

        //$invoice_data = $data;
        $data = (object) $data;

        if ($data->retail_price_override) {
            $data->retail_price = $data->retail_price_override;
        }
        $today = date('Y-m-d h:i:s');
        $target_query = $this->db->query("select * from target_days where service_id='" . $data->rt6_service_id . "'")->result_array();
        $target_start = $target_query[0]['start_days'];
        $target_end = $target_query[0]['end_days'];
        $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
        $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));

        $tracking = time();

        //check if already added--- according to that update or insert

        $check_if_rt6_exists_for_this_order = $this->check_if_rt6_exists_for_this_order($data->rt6_service_id, $data->order_id);

        if (empty($check_if_rt6_exists_for_this_order)) {
            if ($data->Rt6 == 'No') {
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
            }
        } else {
            $sql = "update service_request set price_charged={$data->retail_price}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$data->order_id} and services_id={$data->rt6_service_id}";
            $conn->query($sql);
        }

        if ($data->employee_related_service['override_price']) {
            $data->retail_price_payroll = $data->employee_related_service['override_price'];
        } else {
            $data->retail_price_payroll = $data->employee_related_service['retail_price'];
        }


        if (!isset($data->residenttype)) {
            $data->residenttype = "";
        }

        $check_if_payroll_accno_exists = $this->check_if_payroll_accno_exists($data->order_id);

        if (empty($check_if_payroll_accno_exists)) {

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

            if ($_FILES['void_cheque']['name'] != '') {
                if ($this->uploadvoidcheque($_FILES['void_cheque'])) {
                    $void_check_filename = $this->file_uploaded;
                } else {
                    $void_check_filename = '';
                }
            } else {
                $void_check_filename = '';
            }

            $this->db->query("INSERT INTO `payroll_account_numbers` (`id`, `reference_id`, `order_id`, `bank_name`, `ban_account_number`, `bank_routing_number`, `rt6_availability`, `rt6_number`, `state`, `void_cheque`, `resident_type`, `drivers_license`, `passport`, `lease`) VALUES ('', '{$data->reference_id}', '{$data->order_id}', '{$data->bank_name}', '{$data->bank_account}', '{$data->bank_routing}', '{$data->Rt6}', '{$data->rt6_number}', '{$data->state}', '$void_check_filename', '{$data->residenttype}', '', '$passport_filename', '$lease_filename')");
        } else {  //else part payroll acc nos
            $payroll_account_data = [
                "bank_name" => $data->bank_name,
                "ban_account_number" => $data->bank_account,
                "bank_routing_number" => $data->bank_routing,
                "rt6_availability" => $data->Rt6,
                "rt6_number" => $data->rt6_number,
                "state" => $data->state,
                "resident_type" => $data->residenttype
            ];

            if ($_FILES['passport']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['passport'])) {
                    $payroll_account_data["passport"] = $this->file_uploaded;
                }
            }

            if ($_FILES['lease']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['lease'])) {
                    $payroll_account_data["lease"] = $this->file_uploaded;
                }
            }

            if ($_FILES['void_cheque']['name'] != '') {
                if ($this->uploadvoidcheque($_FILES['void_cheque'])) {
                    $payroll_account_data["void_cheque"] = $this->file_uploaded;
                }
            }

            $this->db->where("order_id", $data->order_id);
            $this->db->update("payroll_account_numbers", $payroll_account_data);
        }

        $check_if_payroll_driver_license_exists = $this->check_if_payroll_driver_license_exists($data->order_id);

        if (empty($check_if_payroll_driver_license_exists)) {
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
                            $this->db->insert('payroll_driver_license_data', ['reference_id' => $data->reference_id, 'order_id' => $order_id, 'file_name' => $this->file_uploaded]);
                        }
                    }
                }
            }
        } else { //else section driver license data
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
                            $this->db->insert('payroll_driver_license_data', ['order_id' => $data->order_id, 'reference_id' => $data->reference_id, 'file_name' => $this->file_uploaded]);
                        }
                    }
                }
            }
        }

        $check_if_payroll_data_exists = $this->check_if_payroll_data_exists($data->order_id);

        if (empty($check_if_payroll_data_exists)) {

            $this->db->query("INSERT INTO `payroll_data` (`id`, `reference_id`, `order_id`, `payroll_frequency`, `payday`) VALUES ('', '{$data->reference_id}', '{$data->order_id}','{$data->payroll_frequency}', '{$data->payday}')");
        } else {
            $this->db->query("delete from `payroll_data` where order_id='{$data->order_id}'");

            $this->db->query("INSERT INTO `payroll_data` (`id`, `reference_id`, `order_id`, `payroll_frequency`, `payday`) VALUES ('', '{$data->reference_id}', '{$data->order_id}','{$data->payroll_frequency}', '{$data->payday}')");
        }

        $update_payroll = array(
            'fname' => $data->payroll_first_name,
            'lname' => $data->payroll_last_name,
            'title' => $data->payroll_title,
            'social_security' => $data->payroll_social_security,
            'phone' => $data->payroll_phone,
            'ext' => $data->payroll_ext,
            'fax' => $data->payroll_fax,
            'email' => $data->payroll_email
        );
        $this->db->where(['reference_id' => $data->reference_id]);
        $this->db->update('payroll_approver', $update_payroll);
        $update_company = array(
            'fname' => $data->company_principal_first_name,
            'lname' => $data->company_principal_last_name,
            'title' => $data->company_principal_title,
            'social_security' => $data->company_principal_social_security,
            'phone' => $data->company_principal_phone,
            'ext' => $data->company_principal_ext,
            'fax' => $data->company_principal_fax,
            'email' => $data->company_principal_email
        );
        $this->db->where(['reference_id' => $data->reference_id]);
        $this->db->update('company_principal', $update_company);


        if ($this->db->get_where('signer_data', ['reference_id' => $data->reference_id])->num_rows() > 0) {
            $update_signer = array(
                'fname' => $data->signer_first_name,
                'lname' => $data->signer_last_name,
                'social_security' => $data->signer_social_security
            );
            $this->db->where(['reference_id' => $data->reference_id]);
            $this->db->update('signer_data', $update_signer);
        } else {
            $insert_signer = array(
                'fname' => $data->signer_first_name,
                'lname' => $data->signer_last_name,
                'social_security' => $data->signer_social_security,
                'reference_id' => $data->reference_id
            );
            $this->db->insert('signer_data', $insert_signer);
        }

        $check_if_payroll_employee_details_exists = $this->check_if_payroll_employee_details_exists($data->reference_id);

        if (empty($check_if_payroll_employee_details_exists)) {
            $emp_dtl = $data->employee_related_service;
            $emp_dtl['reference_id'] = $data->reference_id;
            $this->db->insert('payroll_employee_details', $emp_dtl);
        } else {
            $this->db->delete('payroll_employee_details', ['reference_id' => $data->reference_id]);
            $emp_dtl = $data->employee_related_service;
            $emp_dtl['reference_id'] = $data->reference_id;
            $this->db->insert('payroll_employee_details', $emp_dtl);
        }

        //Payroll Sheet Upload

        $check_if_payroll_biweekly_wage_exists = $this->check_if_payroll_biweekly_wage_exists($data->reference_id);

        if (empty($check_if_payroll_biweekly_wage_exists)) {
            if ($_FILES['bi_weekly']['name'] != '') {
                if ($this->uploadPayrollFormsxls($_FILES['bi_weekly'])) {
                    $bi_weekly_form_name = $this->file_uploaded;
                    $this->db->query("INSERT INTO `payroll_wage_files` (`reference_id`, `type`, `file_name`) VALUES ('{$data->reference_id}', 1 ,'$bi_weekly_form_name' )");
                }
            }
        } else {
            //Payroll Sheet Upload
            if ($_FILES['bi_weekly']['name'] != '') {
                if ($this->uploadPayrollFormsxls($_FILES['bi_weekly'])) {
                    $bi_weekly_form_name = $this->file_uploaded;
                    $this->db->query("delete from `payroll_wage_files` where reference_id='{$data->reference_id}' and type='1'");
                    $this->db->query("INSERT INTO `payroll_wage_files` (`reference_id`, `type`, `file_name`) VALUES ('{$data->reference_id}', 1 ,'$bi_weekly_form_name' )");
                }
            }
        }

        $check_if_payroll_weekly_wage_exists = $this->check_if_payroll_weekly_wage_exists($data->reference_id);

        if (empty($check_if_payroll_weekly_wage_exists)) {
            if ($_FILES['weekly']['name'] != '') {
                if ($this->uploadPayrollFormsxls($_FILES['weekly'])) {
                    $weekly_form_name = $this->file_uploaded;
                    $this->db->query("INSERT INTO `payroll_wage_files` (`reference_id`, `type`, `file_name`) VALUES ('{$data->reference_id}', 2 ,'$weekly_form_name' )");
                }
            }
        } else {
            if ($_FILES['weekly']['name'] != '') {
                if ($this->uploadPayrollFormsxls($_FILES['weekly'])) {
                    $weekly_form_name = $this->file_uploaded;
                    $this->db->query("delete from `payroll_wage_files` where reference_id='{$data->reference_id}' and type='2'");
                    $this->db->query("INSERT INTO `payroll_wage_files` (`reference_id`, `type`, `file_name`) VALUES ('{$data->reference_id}', 2 ,'$weekly_form_name' )");
                }
            }
        }

        $sql = "update service_request set price_charged={$data->retail_price_payroll}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$data->order_id} and services_id={$data->service_id}";
        $conn->query($sql);


        $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $data->order_id . '" order by `date_started` asc')->result_array();
        if (!empty($get_target_start_query)) {
            $target_start_date = $get_target_start_query[0]['date_started'];
        }

        $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $data->order_id . '" order by `date_completed` desc')->result_array();
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

    public function check_if_rt6_exists_for_this_order($rt6_service_id, $order_id) {
        $query = "select * from `service_request` where order_id='" . $order_id . "' and services_id='" . $rt6_service_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function check_if_payroll_accno_exists($order_id) {
        $query = "select * from `payroll_account_numbers` where order_id='" . $order_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function check_if_payroll_driver_license_exists($order_id) {
        $query = "select * from `payroll_driver_license_data` where order_id='" . $order_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function check_if_payroll_data_exists($order_id) {
        $query = "select * from `payroll_data` where order_id='" . $order_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function check_if_payroll_employee_details_exists($reference_id) {
        $query = "select * from `payroll_employee_details` where reference_id='" . $reference_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function check_if_payroll_biweekly_wage_exists($reference_id) {
        $query = "select * from `payroll_wage_files` where reference_id='" . $reference_id . "' and type='1'";
        return $this->db->query($query)->row_array();
    }

    public function check_if_payroll_weekly_wage_exists($reference_id) {
        $query = "select * from `payroll_wage_files` where reference_id='" . $reference_id . "' and type='2'";
        return $this->db->query($query)->row_array();
    }

}
