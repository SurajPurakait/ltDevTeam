<?php

class Salestax_model extends CI_Model {

    public function request_create_sales_tax_processing($data) {
//       
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('System');
        $this->load->model('notes');
        $this->load->model('Internal');
        $this->load->model('Service');
        $this->load->model('billing_model');
        $this->load->model('action_model');
//        $this->db->trans_begin();
        $service_id = $data['service_id'];
        $conn = $this->db;

        if ($data['type_of_client'] == 0) {
            $sql = $this->db->query("select name from company where id='" . $data['client_list'] . "'")->row_array();
            $data['name_of_business1'] = $sql['name'];
            $data['name_of_company'] = $sql['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
//        
        if ($data['editval'] == '') {
//             Save company information
            if (!$this->company_model->save_company_data($this->company_model->make_payroll_company_data($data))) {
                return false;
            } else {
                $this->Company->removeCompanyTempFlag($data['reference_id']);
            }

            if ($data['type_of_client'] != 0) {
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }
            $invoice_data = $data;
            $reference_id = $data["reference_id"];
            $tracking = time();
            $today = date('Y-m-d h:i:s');
            $target_query = $this->db->query("select * from target_days where service_id='$service_id'")->result_array();
            $target_start = $target_query[0]['start_days'];
            $target_end = $target_query[0]['end_days'];
            $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
            $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));

            $sql = "insert into `order` (order_date,start_date,complete_date,tracking, staff_requested_service, reference, reference_id, status, category_id, service_id) values ('" . date('Y-m-d h:i:s') . "','" . $start_date . "','" . $end_date . "','" . $tracking . "', '{$this->System->getLoggedUserId()}', 'company', '" . $reference_id . "', 2, 2,'" . $service_id . "')";

            if ($this->db->query($sql)) {
                $order_id = $conn->insert_id();
                $this->System->log("insert", "order", $order_id);
            } else {
                return false;
            }

//            if ($data['retail_price_override']) {
//                $data['retail_price'] = $data['retail_price_override'];
//            }

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }

            $sql = "insert into service_request
                (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
                values
                (
                {$order_id},
                '$service_id',
                {$data['retail_price']},
                '{$tracking}',
                '{$start_date}',
                '{$end_date}',
                {$this->System->getLoggedUserOfficeId()},
                {$this->System->getLoggedUserId()},
                '2'
                )";
            $conn->query($sql);
            $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_started` asc')->result_array();
            if (!empty($get_target_start_query)) {
                $target_start_date = $get_target_start_query[0]['date_started'];
            }

            $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_completed` desc')->result_array();
            if (!empty($get_target_end_query)) {
                $target_end_date = $get_target_end_query[0]['date_completed'];
            }


            //Update the total amount of order

            $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $order_id),staff_office='" . $data['staff_office'] . "' where id = $order_id";

            $conn->query($sql);
            $this->Company->update_title_status($data["reference_id"]);
            $this->System->update_order_serial_id_by_order_id($order_id);
            $this->System->log("insert", "order", $order_id);

            //sales_tax_processing_section

            $new_existing = $data['type_of_client'];
            if(isset($data['client_list'])){
                $existing_ref_id = $data['client_list'];
            }else{
                $existing_ref_id = $data['reference_id']; 
            }
            
            $start_month_year = $data['start_year'];
            $frequeny_of_salestax = $data['frequeny_of_salestax'];

            if ($frequeny_of_salestax == 'm') {
                $freq_val = $data['frequency_of_salestax_month'];
                $year_val = $data['frequency_of_salestax_years1'];
            } elseif ($frequeny_of_salestax == 'q') {
                $freq_val = $data['frequency_of_salestax_quarter'];
                $year_val = $data['frequency_of_salestax_years2'];
            } else {
                $freq_val = $data['frequency_of_salestax_years'];
                $year_val = '';
            }

            $contact_phone_no = $data['contact_phone_no'];


            // if($data['frequency_of_salestax_month']!=''){
            //     $month=$data['frequency_of_salestax_month'];
            // }else{
            //     $month="";
            // }
            // if($data['frequency_of_salestax_querter']!=''){
            //     $querter=$data['frequency_of_salestax_querter'];
            // }else{
            //     $querter="";
            // }
            // if( $frequeny_of_salestax=='y' && $data['frequency_of_salestax_years']!=''){
            //     $years=$data['frequency_of_salestax_years'];
            // }else{
            //     $years="";
            // }
            $state = $data['state'];

            if ($data['county'] != '') {
                $county = $data['county'];
            } else {
                $county = '';
            }
            $service_id = $data["service_id"];
            $existing_practice_id = $data['existing_practice_id'];
            $sales_tax_number = $data['sales_tax_number'];
            $business_partner_number = $data['business_partner_number'];
            $sales_tax_business_description = $data['sales_tax_business_description'];
            $bank_account_number = $data['bank_account_number'];
            $bank_routing_number = $data['bank_routing_number'];

            // $sql = "insert into sales_tax_processing values('','$new_existing','$existing_ref_id','$start_month_year',"
            //         . "'$frequeny_of_salestax',"
            //         . "'$freq_val','$year_val','$state','$county',"
            //         . "'$order_id','$service_id','$existing_practice_id','$contact_phone_no','$sales_tax_number','$business_partner_number','$sales_tax_business_description','$bank_account_number','$bank_routing_number')";

            $sql = "INSERT INTO `sales_tax_processing`(`type_of_client`,`new_existing`, `start_year`, `frequeny_of_salestax`, `frequency_of_salestax_val`, `frequency_of_salestax_years`, `state`, `county`, `order_id`, `service_id`, `existing_practice_id`, `contact_phone_no`, `sales_tax_number`, `business_partner_number`, `sales_tax_business_description`, `sales_bank_account_number`, `sales_bank_routing_number`) VALUES ('$new_existing','$existing_ref_id','$start_month_year','$frequeny_of_salestax','$freq_val','$year_val','$state','$county','$order_id','$service_id','$existing_practice_id','$contact_phone_no','$sales_tax_number','$business_partner_number','$sales_tax_business_description','$bank_account_number','$bank_routing_number')";                        
            $conn->query($sql);

            $today = date('Y-m-d h:i:s');
            // $invoice_info_data['reference_id'] = $data["reference_id"];
            // $invoice_info_data['type'] = '1';
            // $invoice_info_data['new_existing'] = $data["type_of_client"];
            // if ($data["type_of_client"] == 0) {
            //     $invoice_info_data['existing_reference_id'] = $data["client_list"];
            // }
            // $start_year = date('m/Y', strtotime($today . ' + ' . $target_start . ' days'));
            // $invoice_info_data['start_month_year'] = $start_year;
            // $invoice_info_data['existing_practice_id'] = '';
            // $invoice_info_data['created_by'] = sess('user_id');
            // $invoice_info_data['order_id'] = $order_id;
            // $invoice_info_data['created_time'] = $today;
            // $invoice_info_data['status'] = '1';
            // $this->db->insert('invoice_info', $invoice_info_data);
            // $invoice_id = $this->db->insert_id();
            // $data = (object) $data;
            // // Create a new order for this request
            // $this->insert_invoice_services($data, $invoice_id);
            $invoice_data['order_id'] = $order_id;
            $invoice_id = $this->billing_model->insert_invoice_data($invoice_data);
            $this->system->log("insert", "invoice", $invoice_id);
            $this->system->save_general_notification('order', $order_id, 'insert');
            /* invoice section */

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
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {

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

            $reference_id = $data["reference_id"];
            $tracking = time();
            $today = date('Y-m-d h:i:s');
            $target_query = $this->db->query("select * from target_days where service_id='$service_id'")->result_array();
            $target_start = $target_query[0]['start_days'];
            $target_end = $target_query[0]['end_days'];
            $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
            $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));
            $order_id = $data['editval'];
            $RESPONSIBLE = $this->System->getLoggedUserOfficeId();
            $ressponsible_staff = $this->System->getLoggedUserId();
            $retail = $data['retail_price'];
//             $sql = "UPDATE  service_request SET price_charged='$restail',tracking='$tracking',date_started='$start_date',date_completed='$end_date',responsible_department='$RESPONSIBLE',responsible_staff='$ressponsible_staff',status='2'";
            $sql = "update service_request set price_charged={$retail}, tracking='{$tracking}', responsible_department={$RESPONSIBLE}, responsible_staff={$ressponsible_staff} where order_id={$order_id} and services_id=47";

            $conn->query($sql);
            $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_started` asc')->result_array();
            if (!empty($get_target_start_query)) {
                $target_start_date = $get_target_start_query[0]['date_started'];
            }

            $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_completed` desc')->result_array();
            if (!empty($get_target_end_query)) {
                $target_end_date = $get_target_end_query[0]['date_completed'];
            }

            // Update the total amount of order
            $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $order_id) where id = $order_id";
            $conn->query($sql);
            $this->Company->update_title_status($data["reference_id"]);
            $this->System->log("insert", "order", $order_id);



            //sales_tax_processing


            $start_month_year = $data['start_year'];
            $frequeny_of_salestax = $data['frequeny_of_salestax'];

            if ($frequeny_of_salestax == 'm') {
                $freq_val = $data['frequency_of_salestax_month'];
                $year_val = $data['frequency_of_salestax_years1'];
            } elseif ($frequeny_of_salestax == 'q') {
                $freq_val = $data['frequency_of_salestax_quarter'];
                $year_val = $data['frequency_of_salestax_years2'];
            } else {
                $freq_val = $data['frequency_of_salestax_years'];
                $year_val = '';
            }

            $contact_phone_no = $data['contact_phone_no'];
            // if($data['frequency_of_salestax_month']!=''){
            //     $month=$data['frequency_of_salestax_month'];
            // }else{
            //     $month="";
            // }
            // if($data['frequency_of_salestax_querter']!=''){
            //     $querter=$data['frequency_of_salestax_querter'];
            // }else{
            //     $querter="";
            // }
            // if( $frequeny_of_salestax=='y' && $data['frequency_of_salestax_years']!=''){
            //     $years=$data['frequency_of_salestax_years'];
            // }else{
            //     $years="";
            // }
            $state = $data['state'];

            if ($data['county'] != '') {
                $county = $data['county'];
            } else {
                $county = '';
            }
            $service_id = $data["service_id"];
            if ($data['existing_practice_id'] != '') {
                $existing_practice_id = $data['existing_practice_id'];
            } else {
                $existing_practice_id = '';
            }
            $sales_tax_number = $data['sales_tax_number'];
            $business_partner_number = $data['business_partner_number'];
            $sales_tax_business_description = $data['sales_tax_business_description'];
            $bank_account_number = $data['sales_bank_account_number'];
            $bank_routing_number = $data['sales_bank_routing_number'];



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

            $sql = "update sales_tax_processing set start_year='$start_month_year',frequeny_of_salestax='$frequeny_of_salestax',"
                    . "frequency_of_salestax_val='$freq_val',frequency_of_salestax_years='$year_val',state='$state',county='$county',existing_practice_id='$existing_practice_id',contact_phone_no='$contact_phone_no',sales_tax_number='$sales_tax_number',business_partner_number='$business_partner_number',sales_tax_business_description='$sales_tax_business_description',sales_bank_account_number='$bank_account_number',sales_bank_routing_number='$bank_routing_number'"
                    . "  where service_id='$service_id' and order_id='$order_id'";

            $conn->query($sql);
            $data['order_id'] = $order_id;
            $this->billing_model->update_invoice_data($data);
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

    public function request_create_sales_tax_recurring($data) {
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('action_model');
        $this->load->model('System');
        $this->load->model('notes');
        $this->load->model('Internal');
        $this->load->model('Service');
        $this->load->model('billing_model');
        $this->db->trans_begin();
        $service_id = $data['service_id'];
        $conn = $this->db;

        if ($data['type_of_client'] == 0) {
            $sql = $this->db->query("select name from company where id='" . $data['client_list'] . "'")->row_array();
            $data['name_of_business1'] = $sql['name'];
            $data['name_of_company'] = $sql['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
//        
        if ($data['editval'] == '') {
//             Save company information
            if (!$this->company_model->save_company_data($this->company_model->make_payroll_company_data($data))) {
                return false;
            } else {
                $this->Company->removeCompanyTempFlag($data['reference_id']);
            }

            if ($data['type_of_client'] != 0) {
                if (!$this->Internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }

            $invoice_data = $data;
            $reference_id = $data["reference_id"];
            $tracking = time();
            $today = date('Y-m-d h:i:s');
            $target_query = $this->db->query("select * from target_days where service_id='$service_id'")->result_array();
            $target_start = $target_query[0]['start_days'];
            $target_end = $target_query[0]['end_days'];
            $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
            $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));
            $sql = "insert into `order` (order_date,start_date,complete_date,tracking, staff_requested_service, reference, reference_id, status, category_id, service_id) values ('" . date('Y-m-d h:i:s') . "','" . $start_date . "','" . $end_date . "','" . $tracking . "', '{$this->System->getLoggedUserId()}', 'company', '" . $reference_id . "', 2, 2,'" . $service_id . "')";

            if ($conn->query($sql)) {
                $order_id = $conn->insert_id();
                $this->System->log("insert", "order", $order_id);
            } else {
                return false;
            }
//
//            if ($data['retail_price_override']) {
//                $data['retail_price'] = $data['retail_price_override'];
//            }

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $sql = "insert into service_request
                (order_id, services_id, price_charged, tracking, date_started, date_completed, responsible_department, responsible_staff, status)
                values
                (
                {$order_id},
                '$service_id',
                {$data['retail_price']},
                '{$tracking}',
                '{$start_date}',
                '{$end_date}',
                {$this->System->getLoggedUserOfficeId()},
                {$this->System->getLoggedUserId()},
                '2'
                )";
            $conn->query($sql);
            $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_started` asc')->result_array();
            if (!empty($get_target_start_query)) {
                $target_start_date = $get_target_start_query[0]['date_started'];
            }

            $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_completed` desc')->result_array();
            if (!empty($get_target_end_query)) {
                $target_end_date = $get_target_end_query[0]['date_completed'];
            }
            // Update the total amount of order
            $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $order_id),staff_office='" . $data['staff_office'] . "' where id = $order_id";
            $conn->query($sql);
            $this->Company->update_title_status($data["reference_id"]);
            $this->System->update_order_serial_id_by_order_id($order_id);
            $this->System->log("insert", "order", $order_id);
            //sales_tax_recurring section
            $new_existing = $data['type_of_client'];
            if(isset($data['client_list'])){
                $existing_ref_id = $data['client_list'];
            }else{
                $existing_ref_id = $data['reference_id'];
            }
            
            $existing_practice_id = $data['existing_practice_id'];
            $reference_id = $data['reference_id'];
            $service_id = $data["service_id"];
            $sales_tax_id = $data["sales_tax_id"];
            $password = $data["password"];
            $website = $data['website'];
            $frequeny_of_salestax = $data['frequeny_of_salestax'];
            $state = $data['state'];
            $start_month_year = $data['start_year'];
            $contact_phone_no = $data['contact_phone_no'];
            $sales_tax_number = $data['sales_tax_number'];
            $business_partner_number = $data['business_partner_number'];
            $sales_tax_business_description = $data['sales_tax_business_description'];
            $bank_account_number = $data['bank_account_number'];
            $bank_routing_number = $data['bank_routing_number'];

            if ($data['county'] != '') {
                $county = $data['county'];
            } else {
                $county = '';
            }
            // $sql = "insert into sales_tax_recurring values('$new_existing','$existing_ref_id','$existing_practice_id','$reference_id','$start_month_year','$order_id','$service_id','$sales_tax_id','$password','$website','$frequeny_of_salestax','$state','$county','$contact_phone_no','$sales_tax_number','$business_partner_number','$sales_tax_business_description','$bank_account_number','$bank_routing_number')";

            $sql = "INSERT INTO `sales_tax_recurring`(`new_existing`, `existing_ref_id`, `existing_practice_id`, `reference_id`, `start_month_year`, `order_id`, `service_id`, `sales_tax_id`, `password`, `website`, `freq_of_salestax`, `state`, `county`, `contact_phone_no`, `sales_tax_number`, `business_partner_number`, `sales_tax_business_description`, `bank_account_number`, `bank_routing_number`) VALUES ('$new_existing','$existing_ref_id','$existing_practice_id','$reference_id','$start_month_year','$order_id','$service_id','$sales_tax_id','$password','$website','$frequeny_of_salestax','$state','$county','$contact_phone_no','$sales_tax_number','$business_partner_number','$sales_tax_business_description','$bank_account_number','$bank_routing_number')";
            $conn->query($sql);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            /* invoice section */
            $today = date('Y-m-d h:i:s');
            // $invoice_info_data['reference_id'] = $data["reference_id"];
            // $invoice_info_data['type'] = '1';
            // $invoice_info_data['new_existing'] = $data["type_of_client"];
            // if ($data["type_of_client"] == 0) {
            //     $invoice_info_data['existing_reference_id'] = $data["client_list"];
            // }
            // $start_year = date('m/Y', strtotime($today . ' + ' . $target_start . ' days'));
            // $invoice_info_data['start_month_year'] = $start_year;
            // $invoice_info_data['existing_practice_id'] = '';
            // $invoice_info_data['created_by'] = sess('user_id');
            // $invoice_info_data['order_id'] = $order_id;
            // $invoice_info_data['created_time'] = $today;
            // $invoice_info_data['status'] = '1';
            // $this->db->insert('invoice_info', $invoice_info_data);
            // $invoice_id = $this->db->insert_id();
            // $data = (object) $data;
            // // Create a new order for this request
            // $this->insert_invoice_services($data, $invoice_id);
            $invoice_data['order_id'] = $order_id;
            $invoice_id = $this->billing_model->insert_invoice_data($invoice_data);
            $this->System->log("insert", "invoice", $invoice_id);
            $this->System->save_general_notification('order', $order_id, 'insert');
        } else {
//            echo "Hi";die;
//            print_r($data);die;
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

            $reference_id = $data["reference_id"];
            $tracking = time();
            $today = date('Y-m-d h:i:s');
            $target_query = $this->db->query("select * from target_days where service_id='$service_id'")->result_array();
            $target_start = $target_query[0]['start_days'];
            $target_end = $target_query[0]['end_days'];
            $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_start . ' days'));
            $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_end . ' days'));
            $order_id = $data['editval'];
            $RESPONSIBLE = $this->System->getLoggedUserOfficeId();
            $ressponsible_staff = $this->System->getLoggedUserId();
            $retail = $data['retail_price'];
//             $sql = "UPDATE  service_request SET price_charged='$restail',tracking='$tracking',date_started='$start_date',date_completed='$end_date',responsible_department='$RESPONSIBLE',responsible_staff='$ressponsible_staff',status='2'";
            $sql = "update service_request set price_charged={$retail}, tracking='{$tracking}', responsible_department={$RESPONSIBLE}, responsible_staff={$ressponsible_staff} where order_id={$order_id} and services_id=47";

            $conn->query($sql);
            $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_started` asc')->result_array();
            if (!empty($get_target_start_query)) {
                $target_start_date = $get_target_start_query[0]['date_started'];
            }

            $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_completed` desc')->result_array();
            if (!empty($get_target_end_query)) {
                $target_end_date = $get_target_end_query[0]['date_completed'];
            }
            // Update the total amount of order
            $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $order_id) where id = $order_id";
            $conn->query($sql);
            $this->Company->update_title_status($data["reference_id"]);
            $this->System->log("insert", "order", $order_id);

            //sales_tax_recurring section
            $service_id = $data["service_id"];
            $sales_tax_id = $data["sales_tax_id"];
            $password = $data["password"];
            $website = $data['website'];
            $frequeny_of_salestax = $data['frequeny_of_salestax'];
            $state = $data['state'];
            $start_month_year = $data['start_year'];
            $existing_practice_id = $data['existing_practice_id'];
            $contact_phone_no = $data['contact_phone_no'];
            $sales_tax_number = $data['sales_tax_number'];
            $business_partner_number = $data['business_partner_number'];
            $sales_tax_business_description = $data['sales_tax_business_description'];
            $bank_account_number = $data['bank_account_number'];
            $bank_routing_number = $data['bank_routing_number'];
            if ($data['county'] != '') {
                $county = $data['county'];
            } else {
                $county = '';
            }
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
            $sql = "update sales_tax_recurring set sales_tax_id='$sales_tax_id',password='$password',website='$website',freq_of_salestax='$frequeny_of_salestax',state='$state',county='$county',start_month_year='$start_month_year',existing_practice_id='$existing_practice_id',contact_phone_no='$contact_phone_no',sales_tax_number='$sales_tax_number',business_partner_number='$business_partner_number',sales_tax_business_description='$sales_tax_business_description',bank_account_number='$bank_account_number',bank_routing_number='$bank_routing_number' where service_id='$service_id' and order_id='$order_id'";
            $conn->query($sql);
            $data['order_id'] = $order_id;
            $this->billing_model->update_invoice_data($data);
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

    public function request_create_sales_tax_application($data) {
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('Internal');
        $this->load->model('System');
        $this->load->model('Notes');
        $this->load->model('Service');
        $this->load->model('billing_model');
        $this->load->model('action_model');
        $this->db->trans_begin();
        $service_id = $data['service_id'];
        
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

        if (!isset($data['Rt6need'])) {
            $data['Rt6need'] = '';
        }

        if ($data['editval'] == '') {       //add payroll section
            // Save company information
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

            $invoice_data = $data;
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
                ('" . date('Y-m-d h:i:s') . "', '{$tracking}', {$this->System->getLoggedUserId()}, 'company', {$data->reference_id}, 2, 2, 12)";
            if ($conn->query($sql)) {
                $order_id = $conn->insert_id();
                $this->System->log("insert", "order", $order_id);
            } else {
                return false;
            }


            $this->db->query("INSERT INTO `sales_tax_application` (`id`, `new_existing`, `existing_ref_id`, `reference_id`, `order_id`, `start_month_year`, `bank_name`, `bank_account_number`, `bank_routing_number`, `acc_type1`, `acc_type2`, `rt6_availability`, `rt6_number`, `state`, `void_cheque`, `need_rt6`, `resident_type`, `passport`, `lease`, `state_recurring`, `country_recurring`, `contact_phone_no`) VALUES ('', '{$data->type_of_client}', '{$data->client_list}', '{$data->reference_id}', '$order_id', '{$data->start_year}', '{$data->bank_name}', '{$data->bank_account}', '{$data->bank_routing}', '{$data->acctype1}', '{$data->acctype2}', '{$data->Rt6}', '{$data->rt6_number}', '{$data->state}', '$void_check_filename', '{$data->Rt6need}', '{$data->residenttype}', '$passport_filename', '$lease_filename', '{$data->state_recurring}', '{$data->county}', '{$data->contact_phone_no}')");

            if (count($license_file) > 0) {
                foreach ($license_file as $val) {
                    if ($val['name'] != '') {
                        if ($this->uploaddocs($val)) {
                            $this->db->insert('sales_driver_license_data', ['reference_id' => $data->reference_id, 'order_id' => $order_id, 'file_name' => $this->file_uploaded]);
                            $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,order_id) VALUES ('company','{$data->reference_id}','SALES LICENSE','{$this->file_uploaded}','$order_id') ");
                        }
                    }
                }
            }

            //upload sales tax rt6 on document table

            $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES VOID CHEQUE','$void_check_filename',1,'$order_id') ");

            if ($passport_filename != '') {
                $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES PASSPORT','$passport_filename',1,'$order_id') ");
            }
            if ($lease_filename != '') {
                $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES LEASE','$lease_filename',1,'$order_id') ");
            }

//            if ($data->retail_price_override) {
//                $data->retail_price = $data->retail_price_override;
//            }

            if (isset($data->retail_price_override)) {
                $data->retail_price = ($data->retail_price_override == '') ? $data->retail_price : $data->retail_price_override;
            } else {
                $data->retail_price = $data->retail_price;
            }


            $today = date('Y-m-d h:i:s');
            $target_query = $this->db->query("select * from target_days where service_id='42'")->result_array();
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
                {$service_id},
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
            $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $order_id),staff_office='" . $data->staff_office . "' where id = $order_id";
            $conn->query($sql);
            $this->Company->update_title_status($data->reference_id);
            $this->System->update_order_serial_id_by_order_id($order_id);
            $this->System->log("insert", "order", $order_id);

            /* invoice section */

            $today = date('Y-m-d h:i:s');
            // $invoice_info_data['reference_id'] = $data->reference_id;
            // $invoice_info_data['type'] = '1';
            // $invoice_info_data['new_existing'] = $data->type_of_client;
            // if ($data->type_of_client == 0) {
            //     $invoice_info_data['existing_reference_id'] = $data->client_list;
            // }
            // $invoice_info_data['service_id'] = $service_id;
            // $invoice_info_data['start_month_year'] = $data->start_year;
            // $invoice_info_data['existing_practice_id'] = $data->existing_practice_id;
            // $invoice_info_data['created_by'] = sess('user_id');
            // $invoice_info_data['order_id'] = $order_id;
            // $invoice_info_data['created_time'] = $today;
            // $invoice_info_data['status'] = '1';
            // $this->db->insert('invoice_info', $invoice_info_data);
            // $invoice_id = $this->db->insert_id();
            // Create a new order for this request
            //print_r($data); exit;
            // $this->insert_invoice_services($data, $invoice_id);
            $invoice_data['order_id'] = $order_id;
            $invoice_id = $this->billing_model->insert_invoice_data($invoice_data);
            $this->System->log("insert", "invoice", $invoice_id);
            $this->System->save_general_notification('order', $order_id, 'insert');
            $data = (array) $data;
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

            // $email_subject = 'Order #' . $order_id . ' for sales tax application has been successfully placed';


            // $message = '<table cellpadding="0" cellspacing="0" style=" font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            //                 <tr>
            //                     <td>' .
            //         $user_name .
            //         ',<BR/><BR/> Order #' . $order_id . ' for sales tax application has been successfully placed on your LeafCloud Portal.
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

            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['office'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else { //update started
//            print_r($data);die;
            $order_id = $data['editval'];
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

                    $this->db->query("DELETE FROM documents WHERE order_id='{$data->editval}' AND reference_id='{$data->reference_id}' AND doc_type='SALES PASSPORT' ");

                    $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES PASSPORT','$passport_filename',1,'{$data->editval}') ");
                } else {
                    $passport_filename = '';
                }
            } else {
                $passport_filename = '';
            }

            if ($_FILES['lease']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['lease'])) {
                    $lease_filename = $this->file_uploaded;

                    $this->db->query("DELETE FROM documents WHERE order_id='{$data->editval}' AND reference_id='{$data->reference_id}' AND doc_type='SALES LEASE'");

                    $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES LEASE','$lease_filename',1,'{$data->editval}') ");
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

                    $this->db->query("DELETE FROM documents WHERE order_id='{$data->editval}' AND reference_id='{$data->reference_id}' AND doc_type='SALES VOID CHEQUE'");
                    $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES VOID CHEQUE','$void_check_filename',1,'{$data->editval}') ");
                } else {
                    $void_check_filename = '';
                }
            } else {
                $void_check_filename = '';
            }

            if (!isset($data->Rt6need)) {
                $data->Rt6need = '';
            }

            // $sales_sql = "update `sales_tax_application` set new_existing='{$data->type_of_client}', existing_ref_id='{$data->client_list}', reference_id='{$data->reference_id}', start_month_year='{$data->start_year}', bank_name='{$data->bank_name}', bank_account_number='{$data->bank_account}', bank_routing_number='{$data->bank_routing}', acc_type1={$data->acctype1}, acc_type2={$data->acctype2}, rt6_availability='{$data->Rt6}', rt6_number='{$data->rt6_number}', state='{$data->state}', need_rt6='{$data->Rt6need}', resident_type='{$data->residenttype}', contact_phone_no='{$data->contact_phone_no}'";

            $sales_sql = "update `sales_tax_application` set new_existing='{$data->type_of_client}', existing_ref_id='{$data->client_list}', reference_id='{$data->reference_id}', start_month_year='{$data->start_year}', bank_name='{$data->bank_name}', bank_account_number='{$data->bank_account}', bank_routing_number='{$data->bank_routing}', acc_type1={$data->acctype1}, acc_type2={$data->acctype2}, rt6_availability='{$data->Rt6}', rt6_number='{$data->rt6_number}', state='{$data->state}', need_rt6='{$data->Rt6need}', resident_type='{$data->residenttype}', contact_phone_no='{$data->contact_phone_no}'";

            if ($void_check_filename != '') {
                $sales_sql .= ", void_cheque='{$void_check_filename}'";
            }

            if ($lease_filename != '') {
                $sales_sql .= ", lease='{$lease_filename}'";
            }

            if ($passport_filename != '') {
                $sales_sql .= ", passport='{$passport_filename}'";
            }

            $sales_sql .= ", state_recurring='{$data->state_recurring}'";

            $sales_sql .= ", country_recurring='{$data->county}'";

            $sales_sql .= " where order_id={$data->editval}";

            //echo $sales_sql; exit;

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
                            $this->db->insert('sales_driver_license_data', ['reference_id' => $data->reference_id, 'order_id' => $data->editval, 'file_name' => $this->file_uploaded]);
                            $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES LICENSE','{$this->file_uploaded}',1,'{$data->editval}') ");
                        }
                    }
                }
            }
//            update sales tax rt6 in document
            // $this->db->query("DELETE FROM documents WHERE order_id='{$data->editval}' AND reference_id='{$data->reference_id}'");
            // $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES VOID CHEQUE','$void_check_filename',1,'{$data->editval}') ");

            // if ($passport_filename != '') {
            //     $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES PASSPORT','$passport_filename',1,'{$data->editval}') ");
            // }
            // if ($lease_filename != '') {
            //     $this->db->query("INSERT INTO documents (reference,reference_id,doc_type,document,status,order_id) VALUES ('company','{$data->reference_id}','SALES LEASE','$lease_filename',1,'{$data->editval}') ");
            // }

            if (isset($data->edit_payroll_rt6_notes)) {
                $this->Notes->update_note(5, $data->edit_payroll_rt6_notes);
            }
            if (isset($data->payroll_rt6_notes)) {
                $this->Notes->insert_note(5, $data->payroll_rt6_notes, 'reference_id', $data->reference_id);
            }

            if ($data->retail_price_override) {
                $data->retail_price = $data->retail_price_override;
            }

            $orderid = $data->editval;

            $tracking = time();

            $sql = "update service_request set price_charged={$data->retail_price}, tracking='{$tracking}', responsible_department={$this->System->getLoggedUserOfficeId()}, responsible_staff={$this->System->getLoggedUserId()} where order_id={$orderid} and services_id='$service_id'";
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
            $this->System->save_general_notification('order', $order_id, 'edit');
        }
        $invoice_data['order_id'] = $order_id;
        $this->billing_model->update_invoice_data($invoice_data);
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
        // $allowed_extensios = array('pdf');
        $allowed_extensios = array('jpg', 'jpeg', 'gif', 'png', 'pdf','doc', 'docx','mp4');

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
        $allowed_extensios = array('jpg', 'jpeg', 'gif', 'png', 'pdf','doc', 'docx','mp4');

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
        // $allowed_extensios = array('jpg', 'jpeg', 'gif', 'png', 'pdf');
        $allowed_extensios =  array('jpg', 'jpeg', 'gif', 'png', 'pdf','doc', 'docx');

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

    public function get_salestax_data($order_id) {        
        return $this->db->get_where("sales_tax_application", ['order_id' => $order_id])->result_array();
    }
    
    public function getstatename($state) {
        $this->db->select('states.state_name');
        return $this->db->get_where('states',['id' => $state])->result_array();
    }

    public function get_sales_tax_application_by_order_id($order_id) {
        return $this->db->get_where("sales_tax_application", ['order_id' => $order_id])->row_array();
    }

    public function get_salestax_driver_license_data_by_order_id($id) {
        return $this->db->get_where("sales_driver_license_data", ['order_id' => $id])->result_array();
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

        if (!isset($data->dba)) {
            $data->dba = '';
        }
        if (!isset($data->company_fax)) {
            $data->company_fax = '';
        }
        if (!isset($data->company_email)) {
            $data->company_email = '';
        }
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
                state_others='{$data->state_other}',
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

    public function related_create_sales_tax_application($data) {
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

//        if ($data->retail_price_override) {
//            $data->retail_price = $data->retail_price_override;
//        }


        if (isset($data->retail_price_override)) {
            $data->retail_price = ($data->retail_price_override == '') ? $data->retail_price : $data->retail_price_override;
        } else {
            $data->retail_price = $data->retail_price;
        }

        $tracking = time();

        $check_if_sales_tax_application_exists = $this->check_if_sales_tax_application_exists($data->order_id);

        if (empty($check_if_sales_tax_application_exists)) {

            $this->db->query("INSERT INTO `sales_tax_application` (`id`, `new_existing`, `existing_ref_id`, `existing_practice_id`, `reference_id`, `order_id`, `start_month_year`, `bank_name`, `bank_account_number`, `bank_routing_number`, `acc_type1`, `acc_type2`, `rt6_availability`, `rt6_number`, `state`, `void_cheque`, `need_rt6`, `resident_type`, `passport`, `lease`, `state_recurring`, `country_recurring`) VALUES ('', '{$data->type_of_client}', '{$data->client_list}', '{$data->existing_practice_id}', '{$data->reference_id}', '{$data->order_id}', '{$data->start_year}', '{$data->bank_name}', '{$data->bank_account}', '{$data->bank_routing}', '{$data->acctype1}', '{$data->acctype2}', '{$data->Rt6}', '{$data->rt6_number}', '{$data->state}', '$void_check_filename', '{$data->Rt6need}', '{$data->residenttype}', '$passport_filename', '$lease_filename', '{$data->state_recurring}', '{$data->county}')");
        } else {

            $sales_sql = "update `sales_tax_application` set new_existing='{$data->type_of_client}', existing_ref_id='{$data->client_list}', existing_practice_id='{$data->existing_practice_id}', reference_id='{$data->reference_id}', start_month_year='{$data->start_year}', bank_name='{$data->bank_name}', bank_account_number='{$data->bank_account}', bank_routing_number='{$data->bank_routing}', acc_type1={$data->acctype1}, acc_type2={$data->acctype2}, rt6_availability='{$data->Rt6}', rt6_number='{$data->rt6_number}', state='{$data->state}', need_rt6='{$data->Rt6need}', resident_type='{$data->residenttype}'";

            if ($void_check_filename != '') {
                $sales_sql .= ", void_cheque='{$void_check_filename}'";
            }

            if ($lease_filename != '') {
                $sales_sql .= ", lease='{$lease_filename}'";
            }

            if ($passport_filename != '') {
                $sales_sql .= ", passport='{$passport_filename}'";
            }

            $sales_sql .= ", state_recurring='{$data->state_recurring}'";

            $sales_sql .= ", country_recurring='{$data->county}'";

            $sales_sql .= " where order_id={$data->order_id}";

            $this->db->query($sales_sql);
        }

        if (count($license_file) > 0) {
            foreach ($license_file as $val) {
                if ($val['name'] != '') {
                    if ($this->uploaddocs($val)) {
                        $this->db->insert('sales_driver_license_data', ['reference_id' => $data->reference_id, 'order_id' => $data->order_id, 'file_name' => $this->file_uploaded]);
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

    public function check_if_sales_tax_application_exists($order_id) {
        $query = "select * from `sales_tax_application` where order_id='" . $order_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function check_if_rt6_exists_for_this_order($rt6_service_id, $order_id) {
        $query = "select * from `service_request` where order_id='" . $order_id . "' and services_id='" . $rt6_service_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function related_create_sales_tax_recurring($data) {
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('System');
        $this->load->model('notes');
        $this->load->model('Internal');
        $this->load->model('Service');
        $this->db->trans_begin();

        $conn = $this->db;

//        if ($data['retail_price_override']) {
//            $data['retail_price'] = $data['retail_price_override'];
//        }
        if (isset($data->retail_price_override)) {
            $data->retail_price = ($data->retail_price_override == '') ? $data->retail_price : $data->retail_price_override;
        } else {
            $data->retail_price = $data->retail_price;
        }
        $tracking = time();

        $RESPONSIBLE = $this->System->getLoggedUserOfficeId();
        $ressponsible_staff = $this->System->getLoggedUserId();
        $retail = $data['retail_price'];

        $sql = "update service_request set price_charged={$retail}, tracking='{$tracking}', responsible_department={$RESPONSIBLE}, responsible_staff={$ressponsible_staff} where order_id={$data['order_id']} and services_id={$data['service_id']}";

        $conn->query($sql);


        //sales_tax_recurring section

        $new_existing = isset($data['type_of_client']) ? $data['type_of_client'] : '';
        $existing_ref_id = isset($data['client_list']) ? $data['client_list'] : '';
        $existing_practice_id = isset($data['existing_practice_id']) ? $data['existing_practice_id'] : '';
        $reference_id = $data['reference_id'];
        $service_id = $data["service_id"];
        $sales_tax_id = $data["sales_tax_id"];
        $password = $data["password"];
        $website = $data['website'];
        $frequeny_of_salestax = $data['frequeny_of_salestax'];
        $state = $data['state'];
        $start_month_year = isset($data['start_year']) ? $data['start_year'] : '';
        if ($data['county'] != '') {
            $county = $data['county'];
        } else {
            $county = '';
        }
        $order_id = $data['order_id'];

        $check_if_sales_tax_recurring_exists = $this->check_if_sales_tax_recurring_exists($data['order_id']);

        if (empty($check_if_sales_tax_recurring_exists)) {
            $sql = "insert into sales_tax_recurring values('','$new_existing','$existing_ref_id','$existing_practice_id','$reference_id','$start_month_year','$order_id','$service_id','$sales_tax_id','$password','$website','$frequeny_of_salestax','$state','$county')";

            $conn->query($sql);
        } else {
            $sql = "update sales_tax_recurring set sales_tax_id='$sales_tax_id',password='$password',website='$website',freq_of_salestax='$frequeny_of_salestax',state='$state',county='$county',start_month_year='$start_month_year',existing_practice_id='$existing_practice_id' where service_id='$service_id' and order_id='$order_id'";
            $conn->query($sql);
        }

        $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $data['order_id'] . '" order by `date_started` asc')->result_array();
        if (!empty($get_target_start_query)) {
            $target_start_date = $get_target_start_query[0]['date_started'];
        }

        $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $data['order_id'] . '" order by `date_completed` desc')->result_array();
        if (!empty($get_target_end_query)) {
            $target_end_date = $get_target_end_query[0]['date_completed'];
        }


        // Update the total amount of order
        $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $order_id) where id = $order_id";

        $conn->query($sql);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function check_if_sales_tax_recurring_exists($order_id) {
        $query = "select * from `sales_tax_recurring` where order_id='" . $order_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function related_create_sales_tax_processing($data) {
        $this->load->model('Company');
        $this->load->model('company_model');
        $this->load->model('System');
        $this->load->model('notes');
        $this->load->model('Internal');
        $this->load->model('Service');
        $this->db->trans_begin();
        $service_id = $data['service_id'];
        $conn = $this->db;


        $reference_id = $data["reference_id"];
        $tracking = time();

//        if ($data['retail_price_override']) {
//            $data['retail_price'] = $data['retail_price_override'];
//        }
        if (isset($data['retail_price_override'])) {
            $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
        } else {
            $data['retail_price'] = $data['retail_price'];
        }

        $reference_id = $data["reference_id"];
        $tracking = time();
        $order_id = $data['order_id'];
        $RESPONSIBLE = $this->System->getLoggedUserOfficeId();
        $ressponsible_staff = $this->System->getLoggedUserId();
        $retail = $data['retail_price'];

        $sql = "update service_request set price_charged={$retail}, tracking='{$tracking}', responsible_department={$RESPONSIBLE}, responsible_staff={$ressponsible_staff} where order_id={$order_id} and services_id={$service_id}";
        $conn->query($sql);


        $get_target_start_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_started` asc')->result_array();
        if (!empty($get_target_start_query)) {
            $target_start_date = $get_target_start_query[0]['date_started'];
        }

        $get_target_end_query = $this->db->query('select * from service_request where order_id="' . $order_id . '" order by `date_completed` desc')->result_array();
        if (!empty($get_target_end_query)) {
            $target_end_date = $get_target_end_query[0]['date_completed'];
        }


        //Update the total amount of order

        $sql = "update `order` set start_date='$target_start_date',complete_date='$target_end_date', target_start_date='$target_start_date',target_complete_date='$target_end_date',total_of_order = (select sum(price_charged) from service_request where order_id = $order_id) where id = $order_id";

        $conn->query($sql);

        $new_existing = isset($data['type_of_client']) ? $data['type_of_client'] : '';
        $existing_ref_id = isset($data['client_list']) ? $data['client_list'] : '';
        $start_month_year = isset($data['start_year']) ? $data['start_year'] : '';
        $frequeny_of_salestax = $data['frequeny_of_salestax'];

        if ($frequeny_of_salestax == 'm') {
            $freq_val = $data['frequency_of_salestax_month'];
            $year_val = $data['frequency_of_salestax_years1'];
        } elseif ($frequeny_of_salestax == 'q') {
            $freq_val = $data['frequency_of_salestax_quarter'];
            $year_val = $data['frequency_of_salestax_years2'];
        } else {
            $freq_val = $data['frequency_of_salestax_years'];
            $year_val = '';
        }

        $state = $data['state'];

        if ($data['county'] != '') {
            $county = $data['county'];
        } else {
            $county = '';
        }

        $existing_practice_id = isset($data['existing_practice_id']) ? $data['existing_practice_id'] : '';

        $check_if_sales_tax_processing_exists = $this->check_if_sales_tax_processing_exists($order_id);

        if (empty($check_if_sales_tax_processing_exists)) {
            $sql = "insert into sales_tax_processing values('','$new_existing','$existing_ref_id','$start_month_year',"
                    . "'$frequeny_of_salestax',"
                    . "'$freq_val','$year_val','$state','$county',"
                    . "'$order_id','$service_id','$existing_practice_id')";

            $conn->query($sql);
        } else {
            $sql = "update sales_tax_processing set start_year='$start_month_year',frequeny_of_salestax='$frequeny_of_salestax',"
                    . "frequency_of_salestax_val='$freq_val',frequency_of_salestax_years='$year_val',state='$state',county='$county',existing_practice_id='$existing_practice_id'"
                    . "  where service_id='$service_id' and order_id='$order_id'";

            $conn->query($sql);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function check_if_sales_tax_processing_exists($order_id) {
        $query = "select * from `sales_tax_processing` where order_id='" . $order_id . "'";
        return $this->db->query($query)->row_array();
    }

}
