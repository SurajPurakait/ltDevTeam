<?php

class Billing_model extends CI_Model {

    private $select_billing;
    private $select_billing_2;
    private $filter_element;
    private $sorting_element;

    public function __construct() {
        parent::__construct();
        $this->load->model('company');
        $this->load->model('company_model');
        $this->load->model('internal');
        $this->load->model('system');
        $this->load->model('notes');
        $this->load->model('service');
        $this->load->model('service_model');
        $this->load->model('individual');
        $this->select_billing_1 = [
            'inv.id as invoice_id',
            'inv.reference_id as reference_id',
            'inv.order_id as order_id',
            'inv.new_existing as new_existing',
            'inv.created_time as created_time',
            'inv.existing_reference_id as existing_reference_id',
            'inv.type as invoice_type',
            'inv.is_order as is_order',
            'co.name as name_of_company',
            'co.fein as federal_ID',
            'ind.birth_date as date_of_birth',
            '(SELECT st.state_name FROM states as st WHERE st.id = co.state_opened) as state_of_incorporation',
            '(SELECT ct.type FROM company_type as ct WHERE ct.id = co.type) as type_of_company',
            'inv.start_month_year as start_month_year',
            'co.fye as fiscal_year_end',
            'co.business_description as business_description',
            '(SELECT COUNT(*) FROM contact_info as ci WHERE ci.reference_id = inv.reference_id AND ci.reference = "company") as contact_info',
            '(SELECT COUNT(*) FROM title as tl WHERE tl.company_id = inv.reference_id AND tl.status = 1) as owners',
            'indt.office as office_id',
            '(SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office',
            '(SELECT ofc.office_id FROM office as ofc WHERE ofc.id = indt.office) as officeid',
            '(SELECT ofc.photo FROM office as ofc WHERE ofc.id = indt.office) as office_photo',
            '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = indt.partner) as partner',
            '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = indt.manager) as manager',
            'indt.client_association as client_association',
            '(SELECT rbs.source FROM referred_by_source as rbs WHERE rbs.id = indt.referred_by_source) as referred_by_source',
            'indt.referred_by_name as referred_by_name',
            '(SELECT lng.language FROM languages as lng WHERE lng.id = indt.language) as language',
            'inv.existing_practice_id as existing_practice_ID',
            '(SELECT COUNT(*) FROM documents dc WHERE dc.reference = "company" AND dc.reference_id = inv.reference_id AND dc.status = 1) as documents',
            '(SELECT COUNT(*) FROM `order` ord WHERE ord.invoice_id = inv.id AND ord.reference = \'invoice\') as services',
            'inv.status as invoice_status'
        ];
        $this->select_billing_2 = [
            'inv.id as invoice_id',
            'inv.reference_id as reference_id',
            'inv.order_id as order_id',
            'inv.new_existing as new_existing',
            'inv.created_time as created_time',
            'inv.existing_reference_id as existing_reference_id',
            'inv.type as invoice_type',
            't.individual_id as individual_id',
            'inv.is_order as is_order',
//            't.percentage as individual_percentage',
            'CONCAT(ind.last_name,", ",ind.first_name) as individual_name',
            'ind.ssn_itin as ssn',
            'ind.birth_date as date_of_birth',
            '(SELECT lng.language FROM languages as lng WHERE lng.id = ind.language) as individual_language',
            '(SELECT cn.country_name FROM countries as cn WHERE cn.id = ind.country_residence) as country_of_residence',
            '(SELECT cn.country_name FROM countries as cn WHERE cn.id = ind.country_citizenship) as country_citizenship',
            '(SELECT COUNT(*) FROM contact_info as ci WHERE ci.reference_id = inv.reference_id AND ci.reference = "individual") as contact_info',
            'indt.office as office_id',
            '(SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office',
            '(SELECT ofc.office_id FROM office as ofc WHERE ofc.id = indt.office) as officeid',
            '(SELECT ofc.photo FROM office as ofc WHERE ofc.id = indt.office) as office_photo',
            '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = indt.partner) as partner',
            '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = indt.manager) as manager',
            'indt.client_association as client_association',
            '(SELECT rbs.source FROM referred_by_source as rbs WHERE rbs.id = indt.referred_by_source) as referred_by_source',
            '(SELECT rbs.id FROM referred_by_source as rbs WHERE rbs.id = indt.referred_by_source) as referred_by_source_id',
            'indt.referred_by_name as referred_by_name',
//            '(SELECT lng.language FROM languages as lng WHERE lng.id = indt.language) as language',
            'inv.existing_practice_id as existing_practice_ID',
            '(SELECT COUNT(*) FROM documents dc WHERE dc.reference = "individual" AND dc.reference_id = inv.reference_id AND dc.status = 1) as documents',
            '(SELECT COUNT(*) FROM `order` ord WHERE ord.invoice_id = inv.id AND ord.reference = \'invoice\') as services',
            'inv.status as invoice_status'
        ];

        $this->filter_element = [
            "id" => "inv.id",
            "order_id" => "inv.order_id",
            "tracking" => "inv.status",
            "office" => "indt.office",
            "client_type" => "inv.type",
            "status" => "inv.payment_status",
            "creation_date" => "inv.created_time",
            "requested_by" => "inv.created_by",
            "client_id" => "inv.reference_id",
            "service_name" => "ord.service_id",
            "request_type" => "request_type",
            "due_date" => "due_date"
        ];

        $this->sorting_element = [
            "id" => "inv.id",
            "order_id" => "inv.order_id",
            "tracking" => "inv.status",
            "invoice_type" => "inv.type",
            "office_id" => "officeid",
            "status" => "inv.payment_status",
            "client_name" => "client_name",
            "creation_date" => "inv.created_time",
            "requested_by" => "created_by_name"
        ];
    }

    public function document_details() {
        return $this->db->query("select * from payment_deposit inner join payment_document on payment_deposit.id=payment_document.payment_deposit_id")->result_array();
    }

    public function get_payment_deposit_list() {
        $this->db->select("payment_deposit.*, CONCAT(staff.last_name, ', ',staff.first_name,' ',staff.middle_name) AS requested_by");
        $this->db->from('payment_deposit');
        $this->db->join('staff', 'staff.id = payment_deposit.added_by');
        return $this->db->get()->result();
    }

    public function payment_deposit_details($id) {
        return $data = $this->db->query("select * from payment_deposit where id='$id'")->row_array();
    }

    public function payment_document_details($id) {
        return $data = $this->db->query("select * from payment_document where payment_deposit_id='$id'")->row_array();
    }

    public function get_payment_documents_by_deposit_id($deposit_id) {
        return $this->db->get_where('payment_document', ['payment_deposit_id' => $deposit_id])->result_array();
    }

    public function request_save_document($data) {
        $this->db->trans_begin();
        $added_by = sess('user_id');
        $invoice_id = $data['invoice_id'];
        if ($data['editval'] == '') {
            $payment_deposit = array(
                'invoice_id' => $invoice_id,
                'added_by' => $added_by
            );
            $this->db->insert('payment_deposit', $payment_deposit);
            $payment_deposit_id = $this->db->insert_id();
        } else {
            $payment_deposit_id = $data['editval'];
            $payment_deposit = array(
                'invoice_id' => $invoice_id
            );
            $this->db->where('id', $data['editval']);
            $this->db->update('payment_deposit', $payment_deposit);
            $this->db->where('payment_deposit_id', $payment_deposit_id);
            $this->db->delete('payment_document');
        }
        foreach ($data['document'] as $key => $document) {
            $inesrt_document_data['payment_deposit_id'] = $payment_deposit_id;
            if (isset($_FILES['file_input_' . $key]['name']) && $_FILES['file_input_' . $key]['name'] != '') {
                $file = common_upload('file_input_' . $key);
                if ($file["success"] == 1) {
                    $inesrt_document_data["document"] = $file["status_msg"];
                }
            } else {
                $inesrt_document_data["document"] = $document['previous_file'];
            }
            $inesrt_document_data["date"] = date('Y-m-d h:i:s', strtotime($document['date']));
            $inesrt_document_data["note"] = $document['note'];
            $this->db->insert('payment_document', $inesrt_document_data);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "0";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function get_service_category() {
        return $this->db->get('category')->result_array();
    }

    public function get_service_category_by_id($category_id) {
        return $this->db->get_where('category', ['id' => $category_id])->row_array();
    }

    public function get_service_list_by_category_id($category_id) {
        return $this->db->get_where('services', ['category_id' => $category_id])->result_array();
    }

    public function get_service_list_by_category_id_for_billing($service_id,$category_id, $invoice_type) {
        if($invoice_type == 1){   
            return $this->db->query("select * from services where category_id = '$category_id' and (client_type_assign = '0' or client_type_assign = '2') and id !='$service_id'")->result_array();
        }else{         
            return $this->db->query("select * from services where category_id = '$category_id' and (client_type_assign = '1' or client_type_assign = '2') and id !='$service_id'")->result_array();
        }
    }

    public function get_service_by_id($service_id) {
        return $this->db->get_where('services', ['id' => $service_id])->row_array();
    }

    public function request_create_invoice($data,$is_recurrence = "") {
//        echo "<pre>";
//        print_r($data);exit;
        $staff_info = staff_info();
        $this->db->trans_begin();
        if ($data['editval'] == '') { // Insert section
            
            if ($data['invoice_type'] == 1) {        # Business Client Section

                if($is_recurrence == 'y'){ // Recurring invoice for business client 

                  foreach ($data['client_list'] as $key => $val) {

                      if ($data['type_of_client'] == 0) {
                    $this->service_model->updateCompany($data);
                } else {
                    if ($this->service_model->insertCompany($data)) {

                        $data['practice_id'] = $data['internal_data']['practice_id'];
                        if (!$this->internal->saveInternalData($data)) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
                if($data['type_of_client']!=0){
                    $val=$data['reference_id'];
                }
                $today = date('Y-m-d h:i:s');
                $invoice_info_data['reference_id'] = $val;
                $invoice_info_data['client_id'] = $val;
                if (isset($data['invoice_type'])) {
                    $invoice_info_data['type'] = $data['invoice_type'];
                }
                $invoice_info_data['new_existing'] = $data['type_of_client'];
                if ($data['type_of_client'] == 0) {
                    $invoice_info_data['existing_reference_id'] = $val;
                }
                $invoice_info_data['start_month_year'] = $data['start_year'];
//                $invoice_info_data['existing_practice_id'] = $data['existing_practice_id'];
                $invoice_info_data['created_by'] = sess('user_id');
                $invoice_info_data['created_time'] = $today;
                if (isset($data['is_create_order']) && $data['is_create_order'] == 'yes') {
                    $invoice_info_data['is_order'] = 'y';
                    $invoice_info_data['status'] = 1;
                }
                unset($invoice_info_data[0]);
               
                $this->db->insert('invoice_info', $invoice_info_data);
                // echo $this->db->last_query();exit;
                $invoice_id = $this->db->insert_id();
                // Create a new order for this request               
                unset($data['client_list']);
                $data['reference_id'] = $val;
                $data['client_id'] = $val;
                $this->insert_invoice_services($data, $invoice_id);
                 // echo $this->db->last_query();exit;
                $this->system->log("insert", "invoice", $invoice_id);
               

                    if (isset($data['recurrence']) && !empty($data['recurrence']) && $invoice_id != '') {
    
                    $ins_recurrence = [];
                    $ins_recurrence['invoice_id'] = $invoice_id;
                    foreach ($data['recurrence'] as $key => $val) {
                        $ins_recurrence[$key] = $val;
                    }
                    if ($ins_recurrence['start_date'] != '') {
                        $ins_recurrence['start_date'] = date('Y-m-d', strtotime($ins_recurrence['start_date']));
                    }
                    if ($ins_recurrence['pattern'] == 'annually' || $ins_recurrence['pattern'] == 'none') {
                        $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                        $ins_recurrence['actual_due_month'] = $ins_recurrence['due_month'];
                        $ins_recurrence['actual_due_year'] = date('Y');
//                                   ------ due date -------
                        $due_month =  $ins_recurrence['actual_due_month'];
                        $due_day = $ins_recurrence['actual_due_day'];
                        $due_year = $ins_recurrence['actual_due_year']+1;                      
                        $ins_recurrence['due_date'] = $due_year."-".$due_month."-".$due_day;                      
                        $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date']));
//                           ----------------- recurrence date -----------
                        $next_due_month = $due_month;
                        $next_due_day = $due_day;
                        $next_due_year = $due_year+1;                             
                        $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                        $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));
                    } elseif ($ins_recurrence['pattern'] == 'monthly') {
                        $current_month = date('m');
                        $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                        $ins_recurrence['actual_due_month'] = date('m', strtotime($ins_recurrence['start_date'])) + (int) $ins_recurrence['due_month'];
                        $ins_recurrence['actual_due_year'] = date('Y', strtotime($ins_recurrence['start_date']));
//                                            ------ due date -------
                        if(($ins_recurrence['actual_due_day'] > date('d', strtotime($ins_recurrence['start_date']))) && $ins_recurrence['due_month'] == date('m', strtotime($ins_recurrence['start_date'])))
                        {
                           $ins_recurrence['due_date'] = $ins_recurrence['actual_due_year']."-".date('m', strtotime($ins_recurrence['start_date']))."-".$ins_recurrence['actual_due_day'];
                        } else {
                            $due_month =  $ins_recurrence['actual_due_month'];                           
                            $due_day = $ins_recurrence['actual_due_day'];
                            $due_year = $ins_recurrence['actual_due_year'];
                            if($due_month >12){
                            $due_month = $due_month-12;
                            $due_year = $due_year+1;
                              }                 
                            $ins_recurrence['due_date'] = $due_year."-".$due_month."-".$due_day;
                        }
                        $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date']));
     //                          ----------------- recurrence date -----------
                        $next_due_month = date('m', strtotime($ins_recurrence['due_date'])) +  $ins_recurrence['due_month'];
                        $next_due_day = date('d', strtotime($ins_recurrence['due_date']));
                        $next_due_year = date('Y', strtotime($ins_recurrence['due_date']));
                        if($next_due_month >12){
                            $next_due_month = $next_due_month-12;
                            $next_due_year = $next_due_year+1;
                              } 
                        else{
                            $next_due_month = $next_due_month;
                            $next_due_year = $next_due_year;
                        }
                        $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                        $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));
                    } elseif ($ins_recurrence['pattern'] == 'weekly') {
                        $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
                        $current_day = $day_array[$ins_recurrence['due_month']];
                        $givenDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $ins_recurrence['due_day'], date('Y')));
                        $ins_recurrence['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
                        $ins_recurrence['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
                        $ins_recurrence['actual_due_year'] = date('Y');
                    } elseif ($ins_recurrence['pattern'] == 'quarterly') {
//                                          ------ due date -------
                        $current_month = date('m');
                        if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                            $next_quarter[1] = '1';
                            $next_quarter[2] = '2';
                            $next_quarter[3] = '3';
                            $due_year = date('Y');
                        } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
                            $next_quarter[1] = '4';
                            $next_quarter[2] = '5';
                            $next_quarter[3] = '6';
                            $due_year = date('Y');
                        } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
                            $next_quarter[1] = '7';
                            $next_quarter[2] = '8';
                            $next_quarter[3] = '9';
                            $due_year = date('Y');
                        } elseif ($current_month == '10' || $current_month == '11' || $current_month == '12') {
                            $next_quarter[1] = '10';
                            $next_quarter[2] = '11';
                            $next_quarter[3] = '12';
                            $due_year = date('Y');
                        }                   
                        $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                        $ins_recurrence['actual_due_month'] = $next_quarter[$ins_recurrence['due_month']];
                        $ins_recurrence['actual_due_year'] = $due_year;
                        $ins_recurrence['due_date'] = $ins_recurrence['actual_due_year']."-".$ins_recurrence['actual_due_month']."-".$ins_recurrence['actual_due_day'];
                        $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date'])); 
//                             ----------------- recurrence date -----------
                        if ($ins_recurrence['actual_due_month'] == '1' || $ins_recurrence['actual_due_month'] == '2' || $ins_recurrence['actual_due_month'] == '3') {
                            $next_quarter1[1] = '4';
                            $next_quarter1[2] = '5';
                            $next_quarter1[3] = '6';
                            $due_year = date('Y');
                        } elseif ($ins_recurrence['actual_due_month'] == '4' || $ins_recurrence['actual_due_month'] == '5' || $ins_recurrence['actual_due_month'] == '6') {
                            $next_quarter1[1] = '7';
                            $next_quarter1[2] = '8';
                            $next_quarter1[3] = '9';
                            $due_year = date('Y');
                        } elseif ($ins_recurrence['actual_due_month'] == '7' || $ins_recurrence['actual_due_month'] == '8' || $ins_recurrence['actual_due_month'] == '9') {
                            $next_quarter1[1] = '10';
                            $next_quarter1[2] = '11';
                            $next_quarter1[3] = '12';
                            $due_year = date('Y');
                        } elseif ($ins_recurrence['actual_due_month'] == '10' || $ins_recurrence['actual_due_month'] == '11' || $ins_recurrence['actual_due_month'] == '12') {
                            $next_quarter1[1] = '1';
                            $next_quarter1[2] = '2';
                            $next_quarter1[3] = '3';
                            $due_year = date('Y')+1;
                        } 
                        $next_due_month = $next_quarter1[$ins_recurrence['due_month']];
                        $next_due_day = $ins_recurrence['actual_due_day'];
                        $next_due_year = $due_year;
                        $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                        $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));                                                                                                                                                              
                    } else {
                        $ins_recurrence['actual_due_day'] = '0';
                        $ins_recurrence['actual_due_month'] = '0';
                        $ins_recurrence['actual_due_year'] = '0';
                    }                                       
                    if (isset($ins_recurrence['until_date']) && !empty($ins_recurrence['until_date'])) {
                        $ins_recurrence['until_date'] = date('Y-m-d', strtotime($ins_recurrence['until_date']));
                    } else {
                        $ins_recurrence['until_date'] = null;
                    }
                    if (isset($ins_recurrence['duration_time']) && !empty($ins_recurrence['duration_time'])) {
                        $ins_recurrence['duration_time'] = $ins_recurrence['duration_time'];
                    } else {
                        $ins_recurrence['duration_time'] = null;
                    }
                    if (isset($ins_recurrence['duration_type'])) {
                        $ins_recurrence['duration_type'] = $ins_recurrence['duration_type'];
                    } else {
                        $ins_recurrence['duration_type'] = null;
                    }
                    if (isset($ins_recurrence['due_type']) && !empty($ins_recurrence['due_type'])) {
                        $ins_recurrence['due_type'] = $ins_recurrence['due_type'];
                    } else {
                        $ins_recurrence['due_type'] = null;
                    }
                    $remain_generation=null;                                        
                    if($ins_recurrence['duration_time'] == 1)
                    {
                       $ins_recurrence['due_date'] = ''; 
                       $ins_recurrence['next_occurance_date'] = '';
                    } 
                    elseif($ins_recurrence['duration_time'] == 2)
                    {
                       $ins_recurrence['next_occurance_date'] = ''; 
                    }else {
                        $ins_recurrence['next_occurance_date'] = $ins_recurrence['next_occurance_date'];                                                          
                    }
                    
                    if(!empty($ins_recurrence['start_date']) && empty($ins_recurrence['due_date']) && empty($ins_recurrence['next_occurance_date']))
                    {
                        $ins_recurrence['total_generation_time'] = '1';
                    } elseif(!empty($ins_recurrence['start_date']) && !empty($ins_recurrence['due_date']) && empty($ins_recurrence['next_occurance_date']))
                    {
                        $ins_recurrence['total_generation_time'] = '2';
                    } elseif(!empty($ins_recurrence['start_date']) && !empty($ins_recurrence['due_date']) && !empty($ins_recurrence['next_occurance_date']))
                    {
                        $ins_recurrence['total_generation_time'] = '3';
                    }
    //            if(isset($ins_recurrence['pattern']))
                    $this->db->insert('invoice_recurence', $ins_recurrence);
                    $recurrence_id= $this->db->insert_id();
    //                 echo $this->db->last_query();die;
                    $this->db->where('id', $invoice_id);
                    $this->db->update('invoice_info', ['is_recurrence' => 'y']);
    //                echo $this->db->last_query();die;
                    
                }

                if (isset($data['invoice_notes'])) {
                    $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
                }
                $this->system->save_general_notification('invoice', $invoice_id, 'insert');
              }  
 
                  
            }else{  // Billing invoice for business client
                    if ($data['type_of_client'] == 0) {
                        $this->service_model->updateCompany($data);
                    } else {
                        if ($this->service_model->insertCompany($data)) {

                            $data['practice_id'] = $data['internal_data']['practice_id'];
                            if (!$this->internal->saveInternalData($data)) {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
                    $today = date('Y-m-d h:i:s');
                    $invoice_info_data['reference_id'] = $data['reference_id'];
                    $invoice_info_data['client_id'] = $data['reference_id'];
                    if (isset($data['invoice_type'])) {
                        $invoice_info_data['type'] = $data['invoice_type'];
                    }
                    $invoice_info_data['new_existing'] = $data['type_of_client'];
                    if ($data['type_of_client'] == 0) {
                        $invoice_info_data['existing_reference_id'] = $data['client_list'];
                    }
                    $invoice_info_data['start_month_year'] = $data['start_year'];
    //                $invoice_info_data['existing_practice_id'] = $data['existing_practice_id'];
                    $invoice_info_data['created_by'] = sess('user_id');
                    $invoice_info_data['created_time'] = $today;
                    if (isset($data['is_create_order']) && $data['is_create_order'] == 'yes') {
                        $invoice_info_data['is_order'] = 'y';
                        $invoice_info_data['status'] = 0;
                    }
                    $this->db->insert('invoice_info', $invoice_info_data);
                    $invoice_id = $this->db->insert_id();
                     // print_r($invoice_id);exit;
                    // Create a new order for this request
                    $this->insert_invoice_services($data, $invoice_id);
                    $this->system->log("insert", "invoice", $invoice_id); 

                    if (isset($data['invoice_notes'])) {
                    $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
                    }
                    $this->system->save_general_notification('invoice', $invoice_id, 'insert');

                }
                
            } else {        # Individual Section

                if($is_recurrence == 'y'){ // Recurring invoice for individual client

                    foreach ($data['individual_list'] as $key => $val) {
                        if ($val == "" && $data['type_of_individual'] == 1) {
                            $individual_insert_data = array(
                                'first_name' => $data['first_name'],
                                'middle_name' => $data['middle_name'],
                                'last_name' => $data['last_name'],
                                'birth_date' => $this->system->invertDate($data['birth_date']),
                                'ssn_itin' => $data['ssn_itin'],
                                'type' => '',
                                'language' => $data['language'],
                                'country_residence' => $data['country_residence'],
                                'country_citizenship' => $data['country_citizenship'],
                                'status' => 1,
                                "added_by_user" => sess('user_id')
                            );
                            $this->db->insert('individual', $individual_insert_data);
                            $individual_id = $this->db->insert_id();
                            $title_insert_data = array(
                                'company_id' => $data['reference_id'],
                                'individual_id' => $individual_id,
                                'company_type' => $data['type'],
                                'status' => 1,
                                'existing_reference_id' => $data['reference_id']
                            );
                            $this->db->insert('title', $title_insert_data);
                            $internal_data = $data;
                            $internal_data['reference_id'] = $individual_id;
                            $internal_data['practice_id'] = $data['internal_data']['practice_id'];

                        if (!$this->internal->saveInternalData($internal_data)) {
                                return false;
                            }
                            $this->service_model->change_contact_reference($data['reference_id'], $individual_id);
                            $this->service_model->change_document_reference($data['reference_id'], $individual_id);
                        } else {
                            $individual_details = $this->individual->individual_info_by_title_id($val);
                            if (empty($individual_details)) {
                                return false;
                            }
                            $individual_id = $individual_details['individual_id'];
                           
                            $data['reference_id'] = $individual_details['existing_reference_id'];
                        }
                        $today = date('Y-m-d h:i:s');
                        $invoice_info_data['reference_id'] = $data['reference_id'];
                        if (isset($data['invoice_type'])) {
                            $invoice_info_data['type'] = $data['invoice_type'];
                        }
                        $invoice_info_data['client_id'] = $individual_id;
                        $invoice_info_data['new_existing'] = $data['type_of_individual'];
                        $invoice_info_data['existing_reference_id'] = $data['reference_id'];
        //                $invoice_info_data['existing_practice_id'] = $data['existing_practice_id'];
                        $invoice_info_data['created_by'] = sess('user_id');
                        $invoice_info_data['created_time'] = $today;
                        if (isset($data['is_create_order']) && $data['is_create_order'] == 'yes') {
                            $invoice_info_data['is_order'] = 'y';
                            $invoice_info_data['status'] = 1;
                        }

                        // print_r($invoice_info_data);exit;
                        $this->db->insert('invoice_info', $invoice_info_data);
                        $invoice_id = $this->db->insert_id();

                        unset($data['individual_list'] );
                        $data['reference_id'] = $data['reference_id'];
                        $data['client_id'] = $individual_id;
                        // Create a new order for this request
                        $this->insert_invoice_services($data, $invoice_id);
                        $this->system->log("insert", "invoice", $invoice_id);

                        if (isset($data['recurrence']) && !empty($data['recurrence']) && $invoice_id != '') {
            
                            $ins_recurrence = [];
                            $ins_recurrence['invoice_id'] = $invoice_id;
                            foreach ($data['recurrence'] as $key => $val) {
                                $ins_recurrence[$key] = $val;
                            }
                            if ($ins_recurrence['start_date'] != '') {
                                $ins_recurrence['start_date'] = date('Y-m-d', strtotime($ins_recurrence['start_date']));
                            }                      
                            if ($ins_recurrence['pattern'] == 'annually' || $ins_recurrence['pattern'] == 'none') {
                            $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                            $ins_recurrence['actual_due_month'] = $ins_recurrence['due_month'];
                            $ins_recurrence['actual_due_year'] = date('Y');
    //                                             ------ due date -------
                            $due_month =  $ins_recurrence['actual_due_month'];
                            $due_day = $ins_recurrence['actual_due_day'];
                            $due_year = $ins_recurrence['actual_due_year']+1;                      
                            $ins_recurrence['due_date'] = $due_year."-".$due_month."-".$due_day;                      
                            $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date']));
    //                                   ----------------- recurrence date -----------
                            $next_due_month = $due_month;
                            $next_due_day = $due_day;
                            $next_due_year = $due_year+1;                             
                            $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                            $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));
                                
                            } elseif ($ins_recurrence['pattern'] == 'monthly') {
                            $current_month = date('m');
                        $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                        $ins_recurrence['actual_due_month'] = date('m', strtotime($ins_recurrence['start_date'])) + (int) $ins_recurrence['due_month'];
                        $ins_recurrence['actual_due_year'] = date('Y', strtotime($ins_recurrence['start_date']));
//                                            ------ due date -------
                        if(($ins_recurrence['actual_due_day'] > date('d', strtotime($ins_recurrence['start_date']))) && $ins_recurrence['due_month'] == date('m', strtotime($ins_recurrence['start_date'])))
                        {
                           $ins_recurrence['due_date'] = $ins_recurrence['actual_due_year']."-".date('m', strtotime($ins_recurrence['start_date']))."-".$ins_recurrence['actual_due_day'];
                        } else {
                            $due_month =  $ins_recurrence['actual_due_month'];                           
                            $due_day = $ins_recurrence['actual_due_day'];
                            $due_year = $ins_recurrence['actual_due_year'];
                            if($due_month >12){
                            $due_month = $due_month-12;
                            $due_year = $due_year+1;
                              }                 
                            $ins_recurrence['due_date'] = $due_year."-".$due_month."-".$due_day;
                        }
                            $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date']));
     //                                         ----------------- recurrence date -----------
                            $next_due_month = date('m', strtotime($ins_recurrence['due_date'])) +  $ins_recurrence['due_month'];
                            $next_due_day = date('d', strtotime($ins_recurrence['due_date']));
                            $next_due_year = date('Y', strtotime($ins_recurrence['due_date']));
                            if($next_due_month >12){
                                $next_due_month = $next_due_month-12;
                                $next_due_year = $next_due_year+1;
                                  } 
                            else{
                                $next_due_month = $next_due_month;
                                $next_due_year = $next_due_year;
                            }
                            $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                            $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));
                            } elseif ($ins_recurrence['pattern'] == 'weekly') {
                                $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
                                $current_day = $day_array[$ins_recurrence['due_month']];
                                $givenDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $ins_recurrence['due_day'], date('Y')));
                                $ins_recurrence['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
                                $ins_recurrence['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
                                $ins_recurrence['actual_due_year'] = date('Y');
                            } elseif ($ins_recurrence['pattern'] == 'quarterly') {                             
//                                             ------ due date -------
                            $current_month = date('m');
                            if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                                $next_quarter[1] = '1';
                                $next_quarter[2] = '2';
                                $next_quarter[3] = '3';
                                $due_year = date('Y');
                            } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
                                $next_quarter[1] = '4';
                                $next_quarter[2] = '5';
                                $next_quarter[3] = '6';
                                $due_year = date('Y');
                            } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
                                $next_quarter[1] = '7';
                                $next_quarter[2] = '8';
                                $next_quarter[3] = '9';
                                $due_year = date('Y');
                            } elseif ($current_month == '10' || $current_month == '11' || $current_month == '12') {
                                $next_quarter[1] = '10';
                                $next_quarter[2] = '11';
                                $next_quarter[3] = '12';
                                $due_year = date('Y');
                            }                   
                            $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                            $ins_recurrence['actual_due_month'] = $next_quarter[$ins_recurrence['due_month']];
                            $ins_recurrence['actual_due_year'] = $due_year;
                            $ins_recurrence['due_date'] = $ins_recurrence['actual_due_year']."-".$ins_recurrence['actual_due_month']."-".$ins_recurrence['actual_due_day'];
                            $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date'])); 
//                                    ----------------- recurrence date -----------
                        if ($ins_recurrence['actual_due_month'] == '1' || $ins_recurrence['actual_due_month'] == '2' || $ins_recurrence['actual_due_month'] == '3') {
                            $next_quarter1[1] = '4';
                            $next_quarter1[2] = '5';
                            $next_quarter1[3] = '6';
                            $due_year = date('Y');
                        } elseif ($ins_recurrence['actual_due_month'] == '4' || $ins_recurrence['actual_due_month'] == '5' || $ins_recurrence['actual_due_month'] == '6') {
                            $next_quarter1[1] = '7';
                            $next_quarter1[2] = '8';
                            $next_quarter1[3] = '9';
                            $due_year = date('Y');
                        } elseif ($ins_recurrence['actual_due_month'] == '7' || $ins_recurrence['actual_due_month'] == '8' || $ins_recurrence['actual_due_month'] == '9') {
                            $next_quarter1[1] = '10';
                            $next_quarter1[2] = '11';
                            $next_quarter1[3] = '12';
                            $due_year = date('Y');
                        } elseif ($ins_recurrence['actual_due_month'] == '10' || $ins_recurrence['actual_due_month'] == '11' || $ins_recurrence['actual_due_month'] == '12') {
                            $next_quarter1[1] = '1';
                            $next_quarter1[2] = '2';
                            $next_quarter1[3] = '3';
                            $due_year = date('Y')+1;
                        } 
                        $next_due_month = $next_quarter1[$ins_recurrence['due_month']];
                        $next_due_day = $ins_recurrence['actual_due_day'];
                        $next_due_year = $due_year;
                        $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                        $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date'])); 
                            } else {
                                $ins_recurrence['actual_due_day'] = '0';
                                $ins_recurrence['actual_due_month'] = '0';
                                $ins_recurrence['actual_due_year'] = '0';
                            }                                                 
                            if (isset($ins_recurrence['until_date']) && !empty($ins_recurrence['until_date'])) {
                                $ins_recurrence['until_date'] = date('Y-m-d', strtotime($ins_recurrence['until_date']));
                            } else {
                                $ins_recurrence['until_date'] = null;
                            }
                            if (isset($ins_recurrence['duration_time']) && !empty($ins_recurrence['duration_time'])) {
                                $ins_recurrence['duration_time'] = $ins_recurrence['duration_time'];
                            } else {
                                $ins_recurrence['duration_time'] = null;
                            }
                            if (isset($ins_recurrence['duration_type'])) {
                                $ins_recurrence['duration_type'] = $ins_recurrence['duration_type'];
                            } else {
                                $ins_recurrence['duration_type'] = null;
                            }
                            if (isset($ins_recurrence['due_type']) && !empty($ins_recurrence['due_type'])) {
                                $ins_recurrence['due_type'] = $ins_recurrence['due_type'];
                            } else {
                                $ins_recurrence['due_type'] = null;
                            }
                            $remain_generation=null;                                                      
                            if($ins_recurrence['duration_time'] == 1)
                            {
                               $ins_recurrence['due_date'] = ''; 
                               $ins_recurrence['next_occurance_date'] = '';
                            }
                            elseif($ins_recurrence['duration_time'] == 2)
                            {
                               $ins_recurrence['next_occurance_date'] = ''; 
                            }else {
                               $ins_recurrence['next_occurance_date'] = $ins_recurrence['next_occurance_date'];                                                                                                                                                         
                            }
                            
                            if(!empty($ins_recurrence['start_date']) && empty($ins_recurrence['due_date']) && empty($ins_recurrence['next_occurance_date']))
                            {
                                $ins_recurrence['total_generation_time'] = '1';
                            } elseif(!empty($ins_recurrence['start_date']) && !empty($ins_recurrence['due_date']) && empty($ins_recurrence['next_occurance_date']))
                            {
                                $ins_recurrence['total_generation_time'] = '2';
                            } elseif(!empty($ins_recurrence['start_date']) && !empty($ins_recurrence['due_date']) && !empty($ins_recurrence['next_occurance_date']))
                            {
                                $ins_recurrence['total_generation_time'] = '3';
                            }
            //            print_r($ins_recurrence);die;
                            $this->db->insert('invoice_recurence', $ins_recurrence);
                            $recurrence_id= $this->db->insert_id();
            //                 echo $this->db->last_query();die;
                            $this->db->where('id', $invoice_id);
                            $this->db->update('invoice_info', ['is_recurrence' => 'y']);
            //                echo $this->db->last_query();die;
                            
                        }

                        if (isset($data['invoice_notes'])) {
                            $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
                            }
                            $this->system->save_general_notification('invoice', $invoice_id, 'insert');

                    }

                }else{ // Billing invoice for individual client

                    if ($data['individual_list'] == "" && $data['type_of_individual'] == 1) {
                        $individual_insert_data = array(
                            'first_name' => $data['first_name'],
                            'middle_name' => $data['middle_name'],
                            'last_name' => $data['last_name'],
                            'birth_date' => $this->system->invertDate($data['birth_date']),
                            'ssn_itin' => $data['ssn_itin'],
                            'type' => '',
                            'language' => $data['language'],
                            'country_residence' => $data['country_residence'],
                            'country_citizenship' => $data['country_citizenship'],
                            'status' => 1,
                            "added_by_user" => sess('user_id')
                        );
                        $this->db->insert('individual', $individual_insert_data);
                        $individual_id = $this->db->insert_id();
                        $title_insert_data = array(
                            'company_id' => $data['reference_id'],
                            'individual_id' => $individual_id,
                            'company_type' => $data['type'],
                            'status' => 1,
                            'existing_reference_id' => $data['reference_id']
                        );
                        $this->db->insert('title', $title_insert_data);
                        $internal_data = $data;
                        $internal_data['reference_id'] = $individual_id;
                        $internal_data['practice_id'] = $data['internal_data']['practice_id'];

                        if (!$this->internal->saveInternalData($internal_data)) {
                            return false;
                        }
                        $this->service_model->change_contact_reference($data['reference_id'], $individual_id);
                        $this->service_model->change_document_reference($data['reference_id'], $individual_id);
                    } else {
                        $individual_details = $this->individual->individual_info_by_title_id($data['individual_list']);
                        if (empty($individual_details)) {
                            return false;
                        }
                        $individual_id = $individual_details['individual_id'];
                        $data['reference_id'] = $individual_details['existing_reference_id'];
                    }
                        $today = date('Y-m-d h:i:s');
                        $invoice_info_data['reference_id'] = $data['reference_id'];
                        if (isset($data['invoice_type'])) {
                            $invoice_info_data['type'] = $data['invoice_type'];
                        }
                        $invoice_info_data['client_id'] = $individual_id;
                        $invoice_info_data['new_existing'] = $data['type_of_individual'];
                        $invoice_info_data['existing_reference_id'] = $data['reference_id'];
        //                $invoice_info_data['existing_practice_id'] = $data['existing_practice_id'];
                        $invoice_info_data['created_by'] = sess('user_id');
                        $invoice_info_data['created_time'] = $today;
                        if (isset($data['is_create_order']) && $data['is_create_order'] == 'yes') {
                            $invoice_info_data['is_order'] = 'y';
                            $invoice_info_data['status'] = 0;
                        }
                        $this->db->insert('invoice_info', $invoice_info_data);
                        $invoice_id = $this->db->insert_id();
                        // Create a new order for this request
                        $this->insert_invoice_services($data, $invoice_id);
                        $this->system->log("insert", "invoice", $invoice_id);

                        if (isset($data['invoice_notes'])) {
                            $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
                            }
                            $this->system->save_general_notification('invoice', $invoice_id, 'insert');
                    }
                }
//            recurring invoice section


            // if (isset($data['invoice_notes'])) {
            //     $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
            // }
            // $this->system->save_general_notification('invoice', $invoice_id, 'insert');
        } else {  // Update section
            if ($data['invoice_type'] == 1) {        # Business Client Section
//                echo '<pre>';
//                print_r($data);die;
                if(isset($data['is_recurrence']) && $data['is_recurrence'] == 'y'){  // Update recurring invoice for business client
//                    echo '<pre>';
//                print_r($data);die;
                if ($data['type_of_client'] == 1) {
                    // Save company information
                    if (!$this->company_model->save_company_data($this->company_model->make_company_data($data))) {
                        return false;
                    }
                    // Save company internal data
                    $data['practice_id'] = $data['internal_data']['practice_id'];
                    if (!$this->internal->saveInternalData($data)) {
                        return false;
                    }
                }
                // Create a new order for this request
                $invoice_id = $data['editval'];
                if (isset($data['type_of_client']) && $data['type_of_client'] == 1) {
                    $invoice_info_data['existing_practice_id'] = $data['existing_practice_id'];
                    $this->db->where('id', $invoice_id);
                    $this->db->update('invoice_info', $invoice_info_data);
                }
                $this->insert_invoice_services($data, $invoice_id);
                $this->update_invoice_services($data);
                $this->system->log("update", "invoice", $invoice_id);

                    if (isset($data['recurrence']) && !empty($data['recurrence']) && $invoice_id != '') {
//                    echo 'hi';die;
                    $ins_recurrence = [];
                    $ins_recurrence['invoice_id'] = $invoice_id;
                    foreach ($data['recurrence'] as $key => $val) {
                        $ins_recurrence[$key] = $val;
                    }
                    if ($ins_recurrence['start_date'] != '') {
                        $ins_recurrence['start_date'] = date('Y-m-d', strtotime($ins_recurrence['start_date']));
                    }
                    if ($ins_recurrence['pattern'] == 'annually' || $ins_recurrence['pattern'] == 'none') {
                        $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                        $ins_recurrence['actual_due_month'] = $ins_recurrence['due_month'];
                        $ins_recurrence['actual_due_year'] = date('Y');
//                                        ------ due date -------
                        $due_month =  $ins_recurrence['actual_due_month'];
                        $due_day = $ins_recurrence['actual_due_day'];
                        $due_year = $ins_recurrence['actual_due_year']+1;                      
                        $ins_recurrence['due_date'] = $due_year."-".$due_month."-".$due_day;                      
                        $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date']));
//                            ----------------- recurrence date -----------
                        $next_due_month = $due_month;
                        $next_due_day = $due_day;
                        $next_due_year = $due_year+1;                             
                        $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                        $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));
                    } elseif ($ins_recurrence['pattern'] == 'monthly') {
                        $current_month = date('m');
                        $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                        $ins_recurrence['actual_due_month'] = date('m', strtotime($ins_recurrence['start_date'])) + (int) $ins_recurrence['due_month'];
                        $ins_recurrence['actual_due_year'] = date('Y');
//                                            ------ due date -------
                        if(($ins_recurrence['actual_due_day'] > date('d', strtotime($ins_recurrence['start_date']))) && $ins_recurrence['due_month'] == date('m', strtotime($ins_recurrence['start_date'])))
                        {
                           $ins_recurrence['due_date'] = $ins_recurrence['actual_due_year']."-".date('m', strtotime($ins_recurrence['start_date']))."-".$ins_recurrence['actual_due_day'];
                        } else {
                            $due_month =  $ins_recurrence['actual_due_month'];                           
                            $due_day = $ins_recurrence['actual_due_day'];
                            $due_year = $ins_recurrence['actual_due_year'];
                            if($due_month >12){
                            $due_month = $due_month-12;
                            $due_year = $due_year+1;
                              }                 
                            $ins_recurrence['due_date'] = $due_year."-".$due_month."-".$due_day;
                        }
                        $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date']));
     //                             ----------------- recurrence date -----------
                        $next_due_month = date('m', strtotime($ins_recurrence['due_date'])) + (int) $ins_recurrence['due_month'];
                        $next_due_day = date('d', strtotime($ins_recurrence['due_date']));
                        $next_due_year = date('y', strtotime($ins_recurrence['due_date']));
                        if($next_due_month >12){
                            $next_due_month = $next_due_month-12;
                            $next_due_year = $next_due_year+1;
                              } 
                        else{
                            $next_due_month = $next_due_month;
                            $next_due_year = $next_due_year;
                            }
                        $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                        $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));   
                        
                    } elseif ($ins_recurrence['pattern'] == 'weekly') {
                        $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
                        $current_day = $day_array[$ins_recurrence['due_month']];
                        $givenDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $ins_recurrence['due_day'], date('Y')));
                        $ins_recurrence['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
                        $ins_recurrence['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
                        $ins_recurrence['actual_due_year'] = date('Y');
                    } elseif ($ins_recurrence['pattern'] == 'quarterly') {                   
//                                          ------ due date -------
                        $current_month = date('m');
                        if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                            $next_quarter[1] = '1';
                            $next_quarter[2] = '2';
                            $next_quarter[3] = '3';
                            $due_year = date('Y');
                        } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
                            $next_quarter[1] = '4';
                            $next_quarter[2] = '5';
                            $next_quarter[3] = '6';
                            $due_year = date('Y');
                        } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
                            $next_quarter[1] = '7';
                            $next_quarter[2] = '8';
                            $next_quarter[3] = '9';
                            $due_year = date('Y');
                        } elseif ($current_month == '10' || $current_month == '11' || $current_month == '12') {
                            $next_quarter[1] = '10';
                            $next_quarter[2] = '11';
                            $next_quarter[3] = '12';
                            $due_year = date('Y');
                        }                   
                        $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                        $ins_recurrence['actual_due_month'] = $next_quarter[$ins_recurrence['due_month']];
                        $ins_recurrence['actual_due_year'] = $due_year;
                        $ins_recurrence['due_date'] = $ins_recurrence['actual_due_year']."-".$ins_recurrence['actual_due_month']."-".$ins_recurrence['actual_due_day'];
                        $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date'])); 
//                                    ----------------- recurrence date -----------
                        if ($ins_recurrence['actual_due_month'] == '1' || $ins_recurrence['actual_due_month'] == '2' || $ins_recurrence['actual_due_month'] == '3') {
                            $next_quarter1[1] = '4';
                            $next_quarter1[2] = '5';
                            $next_quarter1[3] = '6';
                            $due_year = date('Y');
                        } elseif ($ins_recurrence['actual_due_month'] == '4' || $ins_recurrence['actual_due_month'] == '5' || $ins_recurrence['actual_due_month'] == '6') {
                            $next_quarter1[1] = '7';
                            $next_quarter1[2] = '8';
                            $next_quarter1[3] = '9';
                            $due_year = date('Y');
                        } elseif ($ins_recurrence['actual_due_month'] == '7' || $ins_recurrence['actual_due_month'] == '8' || $ins_recurrence['actual_due_month'] == '9') {
                            $next_quarter1[1] = '10';
                            $next_quarter1[2] = '11';
                            $next_quarter1[3] = '12';
                            $due_year = date('Y');
                        } elseif ($ins_recurrence['actual_due_month'] == '10' || $ins_recurrence['actual_due_month'] == '11' || $ins_recurrence['actual_due_month'] == '12') {
                            $next_quarter1[1] = '1';
                            $next_quarter1[2] = '2';
                            $next_quarter1[3] = '3';
                            $due_year = date('Y')+1;
                        } 
                        $next_due_month = $next_quarter1[$ins_recurrence['due_month']];
                        $next_due_day = $ins_recurrence['actual_due_day'];
                        $next_due_year = $due_year;
                        $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                        $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));  
                    } else {
                        $ins_recurrence['actual_due_day'] = '0';
                        $ins_recurrence['actual_due_month'] = '0';
                        $ins_recurrence['actual_due_year'] = '0';
                    }                                                                                             
                    if (isset($ins_recurrence['until_date']) && !empty($ins_recurrence['until_date'])) {
                        $ins_recurrence['until_date'] = date('Y-m-d', strtotime($ins_recurrence['until_date']));
                    } else {
                        $ins_recurrence['until_date'] = null;
                    }
                    if (isset($ins_recurrence['duration_time']) && !empty($ins_recurrence['duration_time'])) {
                        $ins_recurrence['duration_time'] = $ins_recurrence['duration_time'];
                    } else {
                        $ins_recurrence['duration_time'] = null;
                    }
                    if (isset($ins_recurrence['duration_type'])) {
                        $ins_recurrence['duration_type'] = $ins_recurrence['duration_type'];
                    } else {
                        $ins_recurrence['duration_type'] = null;
                    }
                    if (isset($ins_recurrence['due_type']) && !empty($ins_recurrence['due_type'])) {
                        $ins_recurrence['due_type'] = $ins_recurrence['due_type'];
                    } else {
                        $ins_recurrence['due_type'] = null;
                    }
                    
                    if($ins_recurrence['duration_time'] == 1)
                    {
                       $ins_recurrence['due_date'] = ''; 
                       $ins_recurrence['next_occurance_date'] = '';
                    } 
                    elseif($ins_recurrence['duration_time'] == 2)
                    {
                       $ins_recurrence['next_occurance_date'] = ''; 
                    }else {
                        $ins_recurrence['next_occurance_date'] = $ins_recurrence['next_occurance_date'];                                                          
                    }
                    
                    if(!empty($ins_recurrence['start_date']) && empty($ins_recurrence['due_date']) && empty($ins_recurrence['next_occurance_date']))
                    {
                        $ins_recurrence['total_generation_time'] = '1';
                    } elseif(!empty($ins_recurrence['start_date']) && !empty($ins_recurrence['due_date']) && empty($ins_recurrence['next_occurance_date']))
                    {
                        $ins_recurrence['total_generation_time'] = '2';
                    } elseif(!empty($ins_recurrence['start_date']) && !empty($ins_recurrence['due_date']) && !empty($ins_recurrence['next_occurance_date']))
                    {
                        $ins_recurrence['total_generation_time'] = '3';
                    }

                    
    //            if(isset($ins_recurrence['pattern']))
//                print_r($ins_recurrence);die;
                    $this->db->where('invoice_id', $invoice_id);
                    $this->db->update('invoice_recurence', $ins_recurrence);
                    $this->db->where('id', $invoice_id);
                    $this->db->update('invoice_info', ['is_recurrence' => 'y']);
    //                echo $this->db->last_query();die;
                }
                if (isset($data['invoice_notes'])) {
                    $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
                }
                if (isset($data['edit_invoice_notes'])) {
                    $this->notes->update_note(1, $data['edit_invoice_notes'], $invoice_id, 'invoice');
                }
                $this->system->save_general_notification('invoice', $invoice_id, 'edit');
                $this->save_order_on_invoice($invoice_id, 'edit');

                }else{  // Update billing invoice for business client

                    if ($data['type_of_client'] == 1) {
                    // Save company information
                    if (!$this->company_model->save_company_data($this->company_model->make_company_data($data))) {
                        return false;
                    }
                    // Save company internal data
                    $data['practice_id'] = $data['internal_data']['practice_id'];
                    if (!$this->internal->saveInternalData($data)) {
                        return false;
                    }
                }
                // Create a new order for this request
                $invoice_id = $data['editval'];
                if (isset($data['type_of_client']) && $data['type_of_client'] == 1) {
                    $invoice_info_data['existing_practice_id'] = $data['existing_practice_id'];
                    $this->db->where('id', $invoice_id);
                    $this->db->update('invoice_info', $invoice_info_data);
                }
                $this->insert_invoice_services($data, $invoice_id);
                $this->update_invoice_services($data);
                $this->system->log("update", "invoice", $invoice_id);

                if (isset($data['invoice_notes'])) {
                $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
                }
                if (isset($data['edit_invoice_notes'])) {
                $this->notes->update_note(1, $data['edit_invoice_notes'], $invoice_id, 'invoice');
                }
                $this->system->save_general_notification('invoice', $invoice_id, 'edit');
                $this->save_order_on_invoice($invoice_id, 'edit');
                }
            } else {        # Individual Section

                if($data['is_recurrence'] == 'y'){ // Recurring invoice for individual client
                if ($data['type_of_individual'] == 1) {
                    $individual_update_data = array(
                        'first_name' => $data['first_name'],
                        'middle_name' => $data['middle_name'],
                        'last_name' => $data['last_name'],
                        'birth_date' => $this->system->invertDate($data['birth_date']),
                        'ssn_itin' => $data['ssn_itin'],
                        'type' => '',
                        'language' => $data['language'],
                        'country_residence' => $data['country_residence'],
                        'country_citizenship' => $data['country_citizenship'],
                        'status' => 1,
                        "added_by_user" => sess('user_id')
                    );
                    $this->db->where(['id' => $data['individual_id']]);
                    $this->db->update('individual', $individual_update_data);

                    // Save company internal data
                    $internal_data = $data;
                    $internal_data['reference_id'] = $data['individual_id'];
                    $internal_data['practice_id'] = $data['internal_data']['practice_id'];
                    if (!$this->internal->saveInternalData($internal_data)) {
                        return false;
                    }
                }
                $this->service_model->change_contact_reference($data['reference_id'], $data['individual_id']);
                $this->service_model->change_document_reference($data['reference_id'], $data['individual_id']);
                $invoice_id = $data['editval'];
                if ($data['type_of_individual'] == 1) {
                    $invoice_info_data['existing_practice_id'] = $data['existing_practice_id'];
                    $this->db->where('id', $invoice_id);
                    $this->db->update('invoice_info', $invoice_info_data);
                }
                // Create a new order for this request
                if (isset($data['service_section'])) {
                    $this->insert_invoice_services($data, $invoice_id);
                }
                $this->update_invoice_services($data);
                $this->system->log("update", "invoice", $invoice_id);

                            if (isset($data['recurrence']) && !empty($data['recurrence']) && $invoice_id != '') {
//                echo 'hi';die;
                $ins_recurrence = [];
                $ins_recurrence['invoice_id'] = $invoice_id;
                foreach ($data['recurrence'] as $key => $val) {
                    $ins_recurrence[$key] = $val;
                }
                if ($ins_recurrence['start_date'] != '') {
                    $ins_recurrence['start_date'] = date('Y-m-d', strtotime($ins_recurrence['start_date']));
                }
                if ($ins_recurrence['pattern'] == 'annually' || $ins_recurrence['pattern'] == 'none') {
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = $ins_recurrence['due_month'];
                $ins_recurrence['actual_due_year'] = date('Y');
    //                              ------ due date -------
                $due_month =  $ins_recurrence['actual_due_month'];
                $due_day = $ins_recurrence['actual_due_day'];
                $due_year = $ins_recurrence['actual_due_year']+1;                      
                $ins_recurrence['due_date'] = $due_year."-".$due_month."-".$due_day;                      
                $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date']));
    //                     ----------------- recurrence date -----------
                $next_due_month = $due_month;
                $next_due_day = $due_day;
                $next_due_year = $due_year+1;                             
                $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));
                } elseif ($ins_recurrence['pattern'] == 'monthly') {
                $current_month = date('m');
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = date('m', strtotime($ins_recurrence['start_date'])) + (int) $ins_recurrence['due_month'];
                $ins_recurrence['actual_due_year'] = date('Y');
//                                      ------ due date -------
                if(($ins_recurrence['actual_due_day'] > date('d', strtotime($ins_recurrence['start_date']))) && $ins_recurrence['due_month'] == date('m', strtotime($ins_recurrence['start_date'])))
                {
                   $ins_recurrence['due_date'] = $ins_recurrence['actual_due_year']."-".date('m', strtotime($ins_recurrence['start_date']))."-".$ins_recurrence['actual_due_day'];
                } else {
                    $due_month =  $ins_recurrence['actual_due_month'];
                    $due_day = $ins_recurrence['actual_due_day'];
                    $due_year = $ins_recurrence['actual_due_year'];
                    if($due_month >12){
                    $due_month = $due_month-12;
                    $due_year = $due_year+1;
                        }                 
                    $ins_recurrence['due_date'] = $due_year."-".$due_month."-".$due_day;
                }
                $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date']));
     //                       ----------------- recurrence date -----------
                    $next_due_month = date('m', strtotime($ins_recurrence['due_date'])) +  $ins_recurrence['due_month'];
                    $next_due_day = date('d', strtotime($ins_recurrence['due_date']));
                    $next_due_year = date('Y', strtotime($ins_recurrence['due_date']));
                    if($next_due_month >12){
                    $next_due_month = $next_due_month-12;
                    $next_due_year = $next_due_year+1;
                       } 
                    else{
                    $next_due_month = $next_due_month;
                    $next_due_year = $next_due_year;
                    }
                    $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                    $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));
                } elseif ($ins_recurrence['pattern'] == 'weekly') {
                    $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
                    $current_day = $day_array[$ins_recurrence['due_month']];
                    $givenDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $ins_recurrence['due_day'], date('Y')));
                    $ins_recurrence['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
                    $ins_recurrence['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
                    $ins_recurrence['actual_due_year'] = date('Y');
                } elseif ($ins_recurrence['pattern'] == 'quarterly') {                                
//                                             ------ due date -------
                $current_month = date('m');
                if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                    $next_quarter[1] = '1';
                    $next_quarter[2] = '2';
                    $next_quarter[3] = '3';
                    $due_year = date('Y');
                } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
                    $next_quarter[1] = '4';
                    $next_quarter[2] = '5';
                    $next_quarter[3] = '6';
                    $due_year = date('Y');
                } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
                    $next_quarter[1] = '7';
                    $next_quarter[2] = '8';
                    $next_quarter[3] = '9';
                    $due_year = date('Y');
                } elseif ($current_month == '10' || $current_month == '11' || $current_month == '12') {
                    $next_quarter[1] = '10';
                    $next_quarter[2] = '11';
                    $next_quarter[3] = '12';
                    $due_year = date('Y');
                }                   
                $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
                $ins_recurrence['actual_due_month'] = $next_quarter[$ins_recurrence['due_month']];
                $ins_recurrence['actual_due_year'] = $due_year;
                $ins_recurrence['due_date'] = $ins_recurrence['actual_due_year']."-".$ins_recurrence['actual_due_month']."-".$ins_recurrence['actual_due_day'];
                $ins_recurrence['due_date'] = date('Y-m-d', strtotime($ins_recurrence['due_date'])); 
//                    ----------------- recurrence date -----------
                if ($ins_recurrence['actual_due_month'] == '1' || $ins_recurrence['actual_due_month'] == '2' || $ins_recurrence['actual_due_month'] == '3') {
                    $next_quarter1[1] = '4';
                    $next_quarter1[2] = '5';
                    $next_quarter1[3] = '6';
                    $due_year = date('Y');
                } elseif ($ins_recurrence['actual_due_month'] == '4' || $ins_recurrence['actual_due_month'] == '5' || $ins_recurrence['actual_due_month'] == '6') {
                    $next_quarter1[1] = '7';
                    $next_quarter1[2] = '8';
                    $next_quarter1[3] = '9';
                    $due_year = date('Y');
                } elseif ($ins_recurrence['actual_due_month'] == '7' || $ins_recurrence['actual_due_month'] == '8' || $ins_recurrence['actual_due_month'] == '9') {
                    $next_quarter1[1] = '10';
                    $next_quarter1[2] = '11';
                    $next_quarter1[3] = '12';
                    $due_year = date('Y');
                } elseif ($ins_recurrence['actual_due_month'] == '10' || $ins_recurrence['actual_due_month'] == '11' || $ins_recurrence['actual_due_month'] == '12') {
                    $next_quarter1[1] = '1';
                    $next_quarter1[2] = '2';
                    $next_quarter1[3] = '3';
                    $due_year = date('Y')+1;
                } 
                    $next_due_month = $next_quarter1[$ins_recurrence['due_month']];
                    $next_due_day = $ins_recurrence['actual_due_day'];
                    $next_due_year = $due_year;
                    $ins_recurrence['next_occurance_date'] = $next_due_year."-".$next_due_month."-".$next_due_day;
                    $ins_recurrence['next_occurance_date'] = date('Y-m-d', strtotime($ins_recurrence['next_occurance_date']));                
                } else {
                    $ins_recurrence['actual_due_day'] = '0';
                    $ins_recurrence['actual_due_month'] = '0';
                    $ins_recurrence['actual_due_year'] = '0';
                }                             
                if (isset($ins_recurrence['until_date']) && !empty($ins_recurrence['until_date'])) {
                    $ins_recurrence['until_date'] = date('Y-m-d', strtotime($ins_recurrence['until_date']));
                } else {
                    $ins_recurrence['until_date'] = null;
                }
                if (isset($ins_recurrence['duration_time']) && !empty($ins_recurrence['duration_time'])) {
                    $ins_recurrence['duration_time'] = $ins_recurrence['duration_time'];
                } else {
                    $ins_recurrence['duration_time'] = null;
                }
                if (isset($ins_recurrence['duration_type'])) {
                    $ins_recurrence['duration_type'] = $ins_recurrence['duration_type'];
                } else {
                    $ins_recurrence['duration_type'] = null;
                }
                if (isset($ins_recurrence['due_type']) && !empty($ins_recurrence['due_type'])) {
                    $ins_recurrence['due_type'] = $ins_recurrence['due_type'];
                } else {
                    $ins_recurrence['due_type'] = null;
                }
                
                if($ins_recurrence['duration_time'] == 1)
                {
                    $ins_recurrence['due_date'] = ''; 
                    $ins_recurrence['next_occurance_date'] = '';
                } 
                elseif($ins_recurrence['duration_time'] == 2)
                {
                    $ins_recurrence['next_occurance_date'] = ''; 
                }else {
                    $ins_recurrence['next_occurance_date'] = $ins_recurrence['next_occurance_date'];                                                          
                }
                
                if(!empty($ins_recurrence['start_date']) && empty($ins_recurrence['due_date']) && empty($ins_recurrence['next_occurance_date']))
                {
                    $ins_recurrence['total_generation_time'] = '1';
                } elseif(!empty($ins_recurrence['start_date']) && !empty($ins_recurrence['due_date']) && empty($ins_recurrence['next_occurance_date']))
                {
                    $ins_recurrence['total_generation_time'] = '2';
                } elseif(!empty($ins_recurrence['start_date']) && !empty($ins_recurrence['due_date']) && !empty($ins_recurrence['next_occurance_date']))
                {
                    $ins_recurrence['total_generation_time'] = '3';
                }
                

//            if(isset($ins_recurrence['pattern']))
//            print_r($ins_recurrence);die;
                $this->db->where('invoice_id', $invoice_id);
                $this->db->update('invoice_recurence', $ins_recurrence);
//                 echo $this->db->last_query();die;
                $this->db->where('id', $invoice_id);
                $this->db->update('invoice_info', ['is_recurrence' => 'y']);
//                echo $this->db->last_query();die;
            }
            if (isset($data['invoice_notes'])) {
                $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
            }
            if (isset($data['edit_invoice_notes'])) {
                $this->notes->update_note(1, $data['edit_invoice_notes'], $invoice_id, 'invoice');
            }
            $this->system->save_general_notification('invoice', $invoice_id, 'edit');
            $this->save_order_on_invoice($invoice_id, 'edit');

            }else{  // Billing invoice for individual client

                if ($data['type_of_individual'] == 1) {
                    $individual_update_data = array(
                        'first_name' => $data['first_name'],
                        'middle_name' => $data['middle_name'],
                        'last_name' => $data['last_name'],
                        'birth_date' => $this->system->invertDate($data['birth_date']),
                        'ssn_itin' => $data['ssn_itin'],
                        'type' => '',
                        'language' => $data['language'],
                        'country_residence' => $data['country_residence'],
                        'country_citizenship' => $data['country_citizenship'],
                        'status' => 1,
                        "added_by_user" => sess('user_id')
                    );
                    $this->db->where(['id' => $data['individual_id']]);
                    $this->db->update('individual', $individual_update_data);

                    // Save company internal data
                    $internal_data = $data;
                    $internal_data['reference_id'] = $data['individual_id'];
                    $internal_data['practice_id'] = $data['internal_data']['practice_id'];
                    if (!$this->internal->saveInternalData($internal_data)) {
                        return false;
                    }
                }
                $this->service_model->change_contact_reference($data['reference_id'], $data['individual_id']);
                $this->service_model->change_document_reference($data['reference_id'], $data['individual_id']);
                $invoice_id = $data['editval'];
                if ($data['type_of_individual'] == 1) {
                    $invoice_info_data['existing_practice_id'] = $data['existing_practice_id'];
                    $this->db->where('id', $invoice_id);
                    $this->db->update('invoice_info', $invoice_info_data);
                }
                // Create a new order for this request
                if (isset($data['service_section'])) {
                    $this->insert_invoice_services($data, $invoice_id);
                }
                $this->update_invoice_services($data);
                $this->system->log("update", "invoice", $invoice_id);

                if (isset($data['invoice_notes'])) {
                $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
                }
                if (isset($data['edit_invoice_notes'])) {
                $this->notes->update_note(1, $data['edit_invoice_notes'], $invoice_id, 'invoice');
                }
                $this->system->save_general_notification('invoice', $invoice_id, 'edit');
                $this->save_order_on_invoice($invoice_id, 'edit');

            }

        }
//             if (isset($data['recurrence']) && !empty($data['recurrence']) && $invoice_id != '') {
// //                echo 'hi';die;
//                 $ins_recurrence = [];
//                 $ins_recurrence['invoice_id'] = $invoice_id;
//                 foreach ($data['recurrence'] as $key => $val) {
//                     $ins_recurrence[$key] = $val;
//                 }

//                 if ($ins_recurrence['pattern'] == 'annually' || $ins_recurrence['pattern'] == 'none') {
//                     $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
//                     $ins_recurrence['actual_due_month'] = $ins_recurrence['due_month'];
//                     $ins_recurrence['actual_due_year'] = date('Y');
//                 } elseif ($ins_recurrence['pattern'] == 'monthly') {
//                     $current_month = date('m');
//                     $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
//                     $ins_recurrence['actual_due_month'] = (int) $current_month + (int) $ins_recurrence['due_month'];
//                     $ins_recurrence['actual_due_year'] = date('Y');
//                 } elseif ($ins_recurrence['pattern'] == 'weekly') {
//                     $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
//                     $current_day = $day_array[$ins_recurrence['due_month']];
//                     $givenDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $ins_recurrence['due_day'], date('Y')));
//                     $ins_recurrence['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
//                     $ins_recurrence['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
//                     $ins_recurrence['actual_due_year'] = date('Y');
//                 } elseif ($ins_recurrence['pattern'] == 'quarterly') {
//                     $current_month = date('m');
//                     if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
//                         $next_quarter[1] = '4';
//                         $next_quarter[2] = '5';
//                         $next_quarter[3] = '6';
//                         $due_year = date('Y');
//                     } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
//                         $next_quarter[1] = '7';
//                         $next_quarter[2] = '8';
//                         $next_quarter[3] = '9';
//                         $due_year = date('Y');
//                     } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
//                         $next_quarter[1] = '10';
//                         $next_quarter[2] = '11';
//                         $next_quarter[3] = '12';
//                         $due_year = date('Y');
//                     } else {
//                         $next_quarter[1] = '1';
//                         $next_quarter[2] = '2';
//                         $next_quarter[3] = '3';
//                         $due_year = date('Y', strtotime('+1 year'));
//                     }
//                     $ins_recurrence['actual_due_day'] = $ins_recurrence['due_day'];
//                     $ins_recurrence['actual_due_month'] = $next_quarter[$ins_recurrence['due_month']];
//                     $ins_recurrence['actual_due_year'] = $due_year;
//                 } else {
//                     $ins_recurrence['actual_due_day'] = '0';
//                     $ins_recurrence['actual_due_month'] = '0';
//                     $ins_recurrence['actual_due_year'] = '0';
//                 }
//                 if ($ins_recurrence['start_date'] != '') {
//                     $ins_recurrence['start_date'] = date('Y-m-d', strtotime($ins_recurrence['start_date']));
//                 }
//                 if (isset($ins_recurrence['until_date']) && !empty($ins_recurrence['until_date'])) {
//                     $ins_recurrence['until_date'] = date('Y-m-d', strtotime($ins_recurrence['until_date']));
//                 } else {
//                     $ins_recurrence['until_date'] = null;
//                 }
//                 if (isset($ins_recurrence['duration_time']) && !empty($ins_recurrence['duration_time'])) {
//                     $ins_recurrence['duration_time'] = $ins_recurrence['duration_time'];
//                 } else {
//                     $ins_recurrence['duration_time'] = null;
//                 }
//                 if (isset($ins_recurrence['duration_type'])) {
//                     $ins_recurrence['duration_type'] = $ins_recurrence['duration_type'];
//                 } else {
//                     $ins_recurrence['duration_type'] = null;
//                 }
//                 if (isset($ins_recurrence['due_type']) && !empty($ins_recurrence['due_type'])) {
//                     $ins_recurrence['due_type'] = $ins_recurrence['due_type'];
//                 } else {
//                     $ins_recurrence['due_type'] = null;
//                 }
                

// //            if(isset($ins_recurrence['pattern']))
// //            print_r($ins_recurrence);die;
//                 $this->db->where('invoice_id', $invoice_id);
//                 $this->db->update('invoice_recurence', $ins_recurrence);
// //                 echo $this->db->last_query();die;
//                 $this->db->where('id', $invoice_id);
//                 $this->db->update('invoice_info', ['is_recurrence' => 'y']);
// //                echo $this->db->last_query();die;
//             }
//             if (isset($data['invoice_notes'])) {
//                 $this->notes->insert_note(1, $data['invoice_notes'], 'reference_id', $invoice_id, 'invoice');
//             }
//             if (isset($data['edit_invoice_notes'])) {
//                 $this->notes->update_note(1, $data['edit_invoice_notes'], $invoice_id, 'invoice');
//             }
//             $this->system->save_general_notification('invoice', $invoice_id, 'edit');
//             $this->save_order_on_invoice($invoice_id, 'edit');
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->update_payment_status_by_invoice_id($invoice_id);
            return $invoice_id;
        }
    }

    public function get_invoice_by_id($invoice_id = "") {
        $invoice_type = $this->db->get_where('invoice_info', ['id' => $invoice_id])->row()->type;
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $where['inv.id'] = $invoice_id;
        if ($invoice_type == 1) {
            $this->db->select(implode(', ', $this->select_billing_1));
            $this->db->from('invoice_info inv');
            $this->db->join('company co', 'co.id = inv.reference_id');
            $this->db->join('title t', 't.company_id = inv.reference_id');
            $this->db->join('individual ind', 'ind.id = t.individual_id');
            $this->db->join('internal_data indt', 'indt.reference_id = inv.reference_id and indt.reference = "company"');
        } else {
            $this->db->select(implode(', ', $this->select_billing_2));
            $this->db->from('invoice_info inv');
            $this->db->join('title t', 't.company_id = inv.reference_id');
            $this->db->join('individual ind', 'ind.id = t.individual_id');
            $this->db->join('internal_data indt', 'indt.reference_id = t.individual_id and indt.reference = "individual"');
            $where['t.status'] = 1;
        }
        $this->db->where($where);
        $r = $this->db->get()->row_array();
//        echo $this->db->last_query();die;
        return $r;
    }

    public function get_document_list($reference_id, $reference) {
        return $this->db->get_where('documents', ['reference_id' => $reference_id, 'reference' => $reference])->result_array();
    }

    public function get_order_by_invoice_id($invoice_id) {
//        $main_order_id = $this->db->query("select * from invoice_info where id=".$invoice_id."")->row_array()['order_id'];
        $select = [
            'inv.id as invoice_id',
            'inv.status as status',
            'ord.id as order_id',
            'ord.service_id as service_id',
            'sr.category_id as category_id',
            'ct.name as service_category',
            'sr.description as service',
            'IF((inv.order_id != 0) AND ((ord.service_id = 10) OR (ord.service_id = 41)) AND ((SELECT COUNT(id) FROM financial_accounts AS fa WHERE fa.order_id = inv.order_id) != 0), (SELECT IF(SUM(fa.grand_total) != 0, SUM(fa.grand_total), SUM(fa.total_amount)) FROM financial_accounts AS fa WHERE fa.order_id = inv.order_id), sr.retail_price) as retail_price',
//            'IF((inv.order_id != 0) AND ((ord.service_id = 10) OR (ord.service_id = 41)), (SELECT IF(SUM(fa.grand_total) != 0, SUM(fa.grand_total), SUM(fa.total_amount)) FROM financial_accounts AS fa WHERE fa.order_id = inv.order_id), sr.retail_price) as retail_price',
//            'sr.retail_price as retail_price',
            'ord.quantity as quantity',
            '(SELECT sr.price_charged FROM service_request sr WHERE sr.order_id = ord.id AND sr.services_id = ord.service_id) as override_price',
            '(CAST((SELECT sr.price_charged FROM service_request sr WHERE sr.order_id = ord.id AND sr.services_id = ord.service_id) AS Decimal(10,2)) * ord.quantity) as sub_total'
//            '(SELECT sr.price_charged FROM service_request sr WHERE sr.order_id = '.$main_order_id.' AND sr.services_id = ord.service_id) as override_price',
//            '(CAST((SELECT sr.price_charged FROM service_request sr WHERE sr.order_id = '.$main_order_id.' AND sr.services_id = ord.service_id) AS Decimal(10,2)) * ord.quantity) as sub_total'
        ];
        $this->db->select(implode(', ', $select));
        $this->db->from('invoice_info inv');
        $this->db->join('order as ord', 'ord.invoice_id = inv.id');
        $this->db->join('services sr', 'sr.id = ord.service_id');
        $this->db->join('category ct', 'ct.id = sr.category_id');
        $this->db->where(['inv.id' => $invoice_id, 'ord.invoice_id' => $invoice_id, 'ord.reference' => 'invoice']);
        $this->db->query('SET SQL_BIG_SELECTS=1');
        return $this->db->get()->result_array();
    }

    public function update_order_summary($invoice_id) {
        $this->db->where(['id' => $invoice_id]);
        if ($this->db->update('invoice_info', ['status' => 1])) {
            mod_invoices_count('', 1);
            mod_payments_count('', 1);
            return true;
        } else {
            return false;
        }
    }

    public function update_billing_status($invoice_id, $status) {
        $this->db->select('COUNT(id) as data_count');
        $this->db->where('stuff_id', $this->session->userdata("user_id"));
        $this->db->where('status_value', $status);
        $this->db->where('section_id', $invoice_id);
        $this->db->where('related_table_name', 'invoice_info');
        $data_count = $this->db->get('tracking_logs')->row_array();
        if ($data_count['data_count'] == 0) {
            $this->db->insert("tracking_logs", ["stuff_id" => sess("user_id"), "status_value" => $status, "section_id" => $invoice_id, "related_table_name" => "invoice_info"]);
        }
        $this->db->where(['id' => $invoice_id]);
        return $this->db->update('invoice_info', ['status' => $status]);
    }

    public function get_tracking_log($id, $table_name) {
        return $this->db->query("SELECT concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as stuff_id, (SELECT GROUP_CONCAT(department.name) FROM department WHERE department.id IN (SELECT department_staff.department_id FROM department_staff WHERE department_staff.staff_id = s.id)) as department, case when tracking_logs.status_value = '3' then 'Completed' when tracking_logs.status_value = '2' then 'Started' when tracking_logs.status_value = '1' then 'Not Started' end as status, date_format(tracking_logs.created_time, '%m/%d/%Y - %r') as created_time FROM `tracking_logs` inner join staff as s on tracking_logs.stuff_id = s.id where tracking_logs.section_id = '$id' and tracking_logs.related_table_name = '$table_name' order by tracking_logs.id desc")->result_array();
    }

    public function get_payment_details($invoice_id = "") {
        $invoice_type = $this->db->get_where('invoice_info', ['id' => $invoice_id])->row()->type;
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $where['inv.id'] = $invoice_id;
        $this->db->select('inv.is_refund');
        $this->db->select('inv.created_by');
        if ($invoice_type == 1) {
            $this->db->select(implode(', ', $this->select_billing_1));
            $this->db->from('invoice_info inv');
            $this->db->join('company co', 'co.id = inv.reference_id');
            $this->db->join('title t', 't.company_id = inv.reference_id');
            $this->db->join('individual ind', 'ind.id = t.individual_id');
            $this->db->join('internal_data indt', 'indt.reference_id = inv.reference_id and indt.reference = "company"');
        } else {
            $this->db->select(implode(', ', $this->select_billing_2));
            $this->db->from('invoice_info inv');
            $this->db->join('title t', 't.company_id = inv.reference_id');
            $this->db->join('individual ind', 'ind.id = t.individual_id');
            $this->db->join('internal_data indt', 'indt.reference_id = t.individual_id and indt.reference = "individual"');
            $where['t.status'] = 1;
        }
        $this->db->where($where);
        $r = $this->db->get()->row_array();
        return $r;
    }

    public function get_payment_type() {
        return $this->db->get('payment_type')->result_array();
    }

    public function get_payment_history($invoice_id, $service_id, $order_id) {
        return $this->db->get_where('payment_history', ['invoice_id' => $invoice_id, 'service_id' => $service_id, 'order_id' => $order_id])->result_array();
    }

    public function get_cancel_payment_history($invoice_id, $service_id) {
        return $this->db->get_where('payment_history', ['invoice_id' => $invoice_id, 'service_id' => $service_id, 'is_cancel' => 1])->result_array();
    }

    public function get_payment_history_type($payment_type) {
        return $this->db->get_where('payment_type', ['id' => $payment_type])->row()->name;
    }

    public function get_total_payble_amount($order_id) {
        $this->db->select('SUM(pay_amount) AS pay_amount');
        return $this->db->get_where('payment_history', ['type' => 'payment', 'order_id' => $order_id, 'is_cancel' => 0])->row_array();
    }

    public function get_invoice_payment_status_by_invoice_id($invoice_id) {
        $total_amount = number_format((float) array_sum(array_column($this->get_order_by_invoice_id($invoice_id), 'sub_total')), 2, '.', '');
        $this->db->select('SUM(pay_amount) AS pay_amount');
        $pay_amount = $this->db->get_where('payment_history', ['type' => 'payment', 'invoice_id' => $invoice_id, 'is_cancel' => 0])->row_array();
        if (empty($pay_amount)) {
            return 1;
        }
        if ($pay_amount['pay_amount'] == 0) {
            return 1;
        } else {
            if ($total_amount > $pay_amount['pay_amount']) {
                return 2;
            } else {
                return 3;
            }
        }
    }

    public function get_invoice_service_payment_status($invoice_id, $service_id, $total_amount) {
        $this->db->select('SUM(pay_amount) AS pay_amount');
        $pay_amount = $this->db->get_where('payment_history', ['type' => 'payment', 'invoice_id' => $invoice_id, 'service_id' => $service_id, 'is_cancel' => 0])->row_array();
        if (empty($pay_amount)) {
            return 1;
        }
        if ($pay_amount['pay_amount'] == 0) {
            return 1;
        } else {
            if ($total_amount > $pay_amount['pay_amount']) {
                return 2;
            } else {
                return 3;
            }
        }
    }

    public function get_payment_history_details_by_payment_id($payment_id) {
        return $this->db->query("select * from payment_history where id = $payment_id")->row_array();
    }

    public function get_refund_amount($order_id) {
        $this->db->select('SUM(pay_amount) AS pay_amount');
        return $this->db->get_where('payment_history', ['type' => 'refund', 'order_id' => $order_id])->row_array();
    }

    public function save_payment($data) {
        $data = (object) $data;
        $insert_data = array('id' => '',
            'invoice_id' => $data->invoice_id,
            'order_id' => $data->order_id,
            'service_id' => $data->service_id,
            'payment_type' => $data->payment_type,
            'reference_no' => $data->ref_no,
            'pay_amount' => $data->payment_amount,
            'check_number' => $data->check_number,
            'authorization_id' => $data->authorization_id,
            'date' => date("Y-m-d", strtotime($data->payment_date)),
            'note' => $data->payment_note,
            'attachment' => $data->payment_file
        );
        if ($data->order_id == 'all' && $data->service_id == 'all') {
            $insert_batch_data = [];
            $services_list = $this->get_order_by_invoice_id($data->invoice_id);
            foreach ($services_list as $key => $sl) {
                $service_payble = get_total_payble_amount($sl['order_id']);
                $due_service_amount = ($sl['override_price'] * $sl['quantity'] ) - $service_payble['pay_amount'];
                if ($due_service_amount != 0) {
                    $insert_data['order_id'] = $sl['order_id'];
                    $insert_data['service_id'] = $sl['service_id'];
                    $insert_data['pay_amount'] = $due_service_amount;
                    $insert_batch_data[$key] = $insert_data;
                }
            }
            return $this->db->insert_batch('payment_history', $insert_batch_data);
        } else {
            return $this->db->insert('payment_history', $insert_data);
        }
    }

    public function save_refund($data) {
        $data = (object) $data;
        $insert_data = array('id' => '',
            'type' => 'refund',
            'invoice_id' => $data->invoice_id,
            'order_id' => $data->order_id,
            'service_id' => $data->service_id,
            'payment_type' => $data->payment_type,
            'reference_no' => $data->ref_no,
            'check_number' => $data->check_number,
            'authorization_id' => $data->authorization_id,
            'pay_amount' => $data->payment_amount,
            'date' => date("Y-m-d", strtotime($data->payment_date)),
            'note' => $data->payment_note,
            'attachment' => $data->payment_file,
            'is_cancel' => 1
        );
        return $this->db->insert('payment_history', $insert_data);
    }

    public function get_invoice_edit_data_by_id($invoice_id = "") {
        $invoice_type = $this->db->get_where('invoice_info', ['id' => $invoice_id])->row()->type;
        $where['inv.id'] = $invoice_id;
        if ($invoice_type == 1) {
            $select = $this->select_billing_1;
            $select[] = 'co.state_opened as state_opened';
            $select[] = 'co.type as company_type';
            $this->db->select(implode(', ', $select));
            $this->db->from('invoice_info inv');
            $this->db->join('company co', 'co.id = inv.reference_id');
            $this->db->join('title t', 't.company_id = inv.reference_id');
            $this->db->join('individual ind', 'ind.id = t.individual_id');
            $this->db->join('internal_data indt', 'indt.reference_id = inv.reference_id and indt.reference = "company"');
        } else {
            $select = $this->select_billing_2;
            $select[] = 't.id as title_id';
            $select[] = 't.individual_id as individual_id';
            $select[] = 'ind.language as individual_language_id';
            $select[] = 'ind.country_residence as country_of_residence_id';
            $select[] = 'ind.country_citizenship as country_citizenship_id';
            $select[] = 'ind.first_name as individual_first_name';
            $select[] = 'ind.middle_name as individual_middle_name';
            $select[] = 'ind.last_name as individual_last_name';
            $select[] = 'indt.partner as partner_id';
            $select[] = 'indt.manager as manager_id';
            $this->db->select(implode(', ', $select));
            $this->db->from('invoice_info inv');
            $this->db->join('title t', 't.company_id = inv.reference_id');
            $this->db->join('individual ind', 'ind.id = t.individual_id');
            $this->db->join('internal_data indt', 'indt.reference_id = t.individual_id and indt.reference = "individual"');
            $where['t.status'] = 1;
        }
        $this->db->where($where);
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $r = $this->db->get()->row_array();
        return $r;
    }

    public function get_title_id_by_individual_id($individual_id) {
        $this->db->order_by('id');
        $this->db->where(['individual_id' => $individual_id, 'status' => 1]);
        return $this->db->get('title')->row()->id;
    }

    public function cancel_Payment($data) {
        $data = (object) $data;
        $payment_id = $data->payment_id;
        $this->db->where('id', $payment_id);
        return $this->db->update('payment_history', ['is_cancel' => 1]);
    }

    public function update_invoice_services($data) {
        $existing_services = explode(',', $data['existing_services']);
        foreach ($data['edit_service_section'] as $key => $value) {
            $service_data = (object) $value;
            if (in_array($key, $existing_services)) {
                $index = array_search($key, $existing_services);
                unset($existing_services[$index]);
            }
            $order_id = $key;
            $service_request_where['order_id'] = $order_id;
            $service_request_where['services_id'] = $service_data->service_id;
            $service_request['price_charged'] = ($service_data->retail_price_override != '') ? $service_data->retail_price_override : $service_data->retail_price;

            $this->db->where($service_request_where);
            $this->db->update('service_request', $service_request);

            if (isset($service_data->notes)) {
                $reference_id = $this->notes->get_main_service_id($order_id, $service_data->service_id);
                if (!empty($reference_id)) {
                    $reference_id = $reference_id['id'];
                    $this->notes->insert_note(1, $service_data->notes, 'reference_id', $reference_id, 'service');
                }
            }

            if (isset($service_data->edit_note)) {
                foreach ($service_data->edit_note as $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $service_data->service_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $service_data->edit_note, $reference_id, 'service');
                    }
                }
            }

            // Update the total amount of order
            $this->db->select('sum(price_charged) as total_price');
            $total_price = $this->db->get_where('service_request', ['order_id' => $order_id])->row_array();

            $update_order_data['total_of_order'] = $total_price['total_price'];
            $update_order_data['quantity'] = $service_data->quantity;
            $this->db->where(['id' => $order_id]);
            $this->db->update('order', $update_order_data);
        }

        foreach ($existing_services as $order_id) {
            $order_info = $this->db->get_where('order', ['id' => $order_id])->row_array();
            if (!empty($order_info)) {
                $this->db->query('delete from service_request where order_id="' . $order_id . '"');
                $this->db->where(['id' => $order_id]);
                $this->db->delete('order');
            }
        }
    }

    public function insert_invoice_services($data, $invoice_id) {
        // echo "<pre>";
        // print_r($data);exit;
        $tracking = time();
        $today = date('Y-m-d h:i:s');
        if (isset($data['service_section'])) {
            foreach ($data['service_section'] as $key => $value) {
                $service_data = (object) $value;
                $order_data['order_date'] = date('Y-m-d h:i:s');
                $order_data['tracking'] = $tracking;
                $order_data['staff_requested_service'] = sess('user_id');
                $order_data['reference'] = 'invoice';
                $order_data['reference_id'] = $data['reference_id'];
                $order_data['status'] = 10;
                $order_data['category_id'] = 2;
                $order_data['service_id'] = $service_data->service_id;
                $order_data['quantity'] = $service_data->quantity;
                $order_data['invoice_id'] = $invoice_id;
                if (isset($data['staff_office'])) {
                    $order_data['staff_office'] = $data['staff_office'];
                } else {
                    $order_data['staff_office'] = '0';
                }

                if ($this->db->insert('order', $order_data)) {
                    $order_id = $this->db->insert_id();
                } else {
                    return false;
                }
                $target_query = $this->db->get_where("target_days", ["service_id" => $service_data->service_id])->row_array();
                $start_date = date('Y-m-d h:i:s', strtotime($today . ' + ' . $target_query['start_days'] . ' days'));
                $end_date = date('Y-m-d h:i:s', strtotime($start_date . ' + ' . $target_query['end_days'] . ' days'));


                $service_request['order_id'] = $order_id;
                $service_request['services_id'] = $service_data->service_id;
                $service_request['price_charged'] = ($service_data->retail_price_override != '') ? $service_data->retail_price_override : $service_data->retail_price;
                $service_request['tracking'] = $tracking;
                $service_request['date_started'] = $start_date;
                $service_request['date_completed'] = $end_date;
                $service_request['responsible_department'] = $this->system->getLoggedUserOfficeId();
                $service_request['responsible_staff'] = sess('user_id');
                $service_request['status'] = 2;
                $this->db->insert('service_request', $service_request);
                if (isset($service_data->notes)) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $service_data->service_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $service_data->notes, 'reference_id', $reference_id, 'service');
                    }
                }

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
            }
        }
    }

    public function insert_invoice_data($data) {
        $return_data['invoice_type'] = 1;
        $return_data['type_of_client'] = 0;
        $return_data['client_list'] = $data['reference_id'];
        $return_data['fein'] = '';
        $return_data['start_year'] = '';
        $return_data['reference'] = 'company';
        $return_data['reference_id'] = $data['reference_id'];
        $return_data['company_id'] = $data['reference_id'];
        $return_data['editval'] = '';
        if (isset($data['existing_practice_id'])) {
            $return_data['existing_practice_id'] = $data['existing_practice_id'];
        } else {
            $return_data['existing_practice_id'] = '';
        }
        $return_data['service_section'][0]['category_id'] = $this->get_service_by_id($data['service_id'])['category_id'];
        $return_data['service_section'][0]['service_id'] = $data['service_id'];
        $return_data['service_section'][0]['retail_price'] = $data['retail_price'];
        $return_data['service_section'][0]['retail_price_override'] = $data['retail_price_override'];
        $return_data['service_section'][0]['quantity'] = 1;
        if (isset($data['related_services']) && !empty($data['related_services']) && count($data['related_services']) != 0) {
            $related_services = $data['related_services'];
            foreach ($related_services as $key => $service_data) {
                $inv = $key + 1;
                $service_id = $related_services[$key];
                $service = $this->service->getService($service_id);
                $return_data['service_section'][$inv]['category_id'] = $service->category_id;
                $return_data['service_section'][$inv]['service_id'] = $service_id;
                $return_data['service_section'][$inv]['retail_price'] = $service->retail_price;
                if (isset($data['related_service']['override_price'][$service_id])) {
                    $return_data['service_section'][$inv]['retail_price_override'] = $data['related_service']['override_price'][$service_id];
                } else {
                    $return_data['service_section'][$inv]['retail_price_override'] = '';
                }
                $return_data['service_section'][$inv]['quantity'] = 1;
            }
        }
        $invoice_id = $this->request_create_invoice($return_data);
        if ($invoice_id) {
            $this->update_invoice_info($invoice_id, ['order_id' => $data['order_id']]);
            $this->update_order_summary($invoice_id);
            return $invoice_id;
        } else {
            return false;
        }
    }

    public function update_invoice_data($data) {
        $invoice_info = $this->get_invoice_by_order_id($data['order_id']);
        $invoice_id = $invoice_info['id'];
        $return_data['invoice_type'] = 1;
        $return_data['type_of_client'] = 0;
        $return_data['client_list'] = $data['reference_id'];
        $return_data['fein'] = '';
        $return_data['start_year'] = '';
        $return_data['reference'] = 'company';
        $return_data['reference_id'] = $data['reference_id'];
        $return_data['company_id'] = $data['reference_id'];
        $return_data['editval'] = $invoice_info['id'];
        if (isset($data['existing_practice_id'])) {
            $return_data['existing_practice_id'] = $data['existing_practice_id'];
        } else {
            $return_data['existing_practice_id'] = '';
        }
        if (isset($data['retail_price'])) {
            $invoice_order = $this->get_invoice_order_by_service_id_invoice_id($invoice_id, $data['service_id']);
            if (empty($invoice_order)) {
                $return_data['service_section'][0]['category_id'] = $this->get_service_by_id($data['service_id'])['category_id'];
                $return_data['service_section'][0]['service_id'] = $data['service_id'];
                $return_data['service_section'][0]['retail_price'] = $data['retail_price'];
                $return_data['service_section'][0]['retail_price_override'] = $data['retail_price_override'];
                $return_data['service_section'][0]['quantity'] = 1;
            } else {
                $return_data['edit_service_section'][$invoice_order['id']]['category_id'] = $this->get_service_by_id($data['service_id'])['category_id'];
                $return_data['edit_service_section'][$invoice_order['id']]['service_id'] = $data['service_id'];
                $return_data['edit_service_section'][$invoice_order['id']]['retail_price'] = $data['retail_price'];
                if (isset($data['retail_price_override'])) {
                    $return_data['edit_service_section'][$invoice_order['id']]['retail_price_override'] = $data['retail_price_override'];
                } else {
                    $return_data['edit_service_section'][$invoice_order['id']]['retail_price_override'] = $data['retail_price'];
                }
                $return_data['edit_service_section'][$invoice_order['id']]['quantity'] = 1;
            }
        }
        $main = 0;
        if (isset($data['related_service'][$data['order_id']][$data['service_id']])) {
            if (isset($data['related_services'])) {
                if (!in_array($data['service_id'], $data['related_services'])) {
                    $main++;
                }
            } else {
                $main++;
            }
        }
        if ($main != 0) {
            $invoice_order = $this->get_invoice_order_by_service_id_invoice_id($invoice_id, $data['service_id']);
            if (empty($invoice_order)) {
                $return_data['service_section'][1]['category_id'] = $this->get_service_by_id($data['service_id'])['category_id'];
                $return_data['service_section'][1]['service_id'] = $data['service_id'];
                $return_data['service_section'][1]['retail_price'] = $data['related_service'][$data['order_id']][$data['service_id']]['retail_price'];
                if (isset($data['related_service'][$data['order_id']][$data['service_id']]['override_price'])) {
                    $return_data['service_section'][1]['retail_price_override'] = $data['related_service'][$data['order_id']][$data['service_id']]['override_price'];
                } else {
                    $return_data['service_section'][1]['retail_price_override'] = '';
                }
                $return_data['service_section'][1]['quantity'] = 1;
            } else {
                $return_data['edit_service_section'][$invoice_order['id']]['category_id'] = $this->get_service_by_id($data['service_id'])['category_id'];
                $return_data['edit_service_section'][$invoice_order['id']]['service_id'] = $data['service_id'];
                $return_data['edit_service_section'][$invoice_order['id']]['retail_price'] = $data['related_service'][$data['order_id']][$data['service_id']]['retail_price'];
                if (isset($data['related_service'][$data['order_id']][$data['service_id']]['override_price'])) {
                    $return_data['edit_service_section'][$invoice_order['id']]['retail_price_override'] = $data['related_service'][$data['order_id']][$data['service_id']]['override_price'];
                } else {
                    $return_data['edit_service_section'][$invoice_order['id']]['retail_price_override'] = '';
                }
                $return_data['edit_service_section'][$invoice_order['id']]['quantity'] = 1;
            }
        }
        if (isset($data['related_services']) && !empty($data['related_services']) && count($data['related_services']) != 0) {
            $related_services = $data['related_services'];
            foreach ($related_services as $key => $service_data) {
                $inv = $key + 2;
                $service_id = $related_services[$key];
                $service = $this->service->getService($service_id);
                $invoice_order = $this->get_invoice_order_by_service_id_invoice_id($invoice_id, $service_id);
                if (empty($invoice_order)) {
                    $return_data['service_section'][$inv]['category_id'] = $service->category_id;
                    $return_data['service_section'][$inv]['service_id'] = $service_id;
                    $return_data['service_section'][$inv]['retail_price'] = $service->retail_price;
                    if (isset($data['related_service'][$data['order_id']][$service_id])) {
                        $return_data['service_section'][$inv]['retail_price_override'] = $data['related_service'][$data['order_id']][$service_id]['override_price'];
                    } else {
                        $return_data['service_section'][$inv]['retail_price_override'] = '';
                    }
                    $return_data['service_section'][$inv]['quantity'] = 1;
                } else {
                    $return_data['edit_service_section'][$invoice_order['id']]['category_id'] = $service->category_id;
                    $return_data['edit_service_section'][$invoice_order['id']]['service_id'] = $service_id;
                    $return_data['edit_service_section'][$invoice_order['id']]['retail_price'] = $service->retail_price;
                    if (isset($data['related_service'][$data['order_id']][$service_id])) {
                        $return_data['edit_service_section'][$invoice_order['id']]['retail_price_override'] = $data['related_service'][$data['order_id']][$service_id]['override_price'];
                    } else {
                        $return_data['edit_service_section'][$invoice_order['id']]['retail_price_override'] = '';
                    }
                    $return_data['edit_service_section'][$invoice_order['id']]['quantity'] = 1;
                }
            }
        }
        $invoice_service = $this->get_order_by_invoice_id($invoice_info['id']);
        $return_data['existing_services'] = implode(',', array_column($invoice_service, 'order_id'));
//        echo '<pre>';
//        print_r($return_data);exit;
        $invoice_id = $this->request_create_invoice($return_data);
        if ($invoice_id) {
            return true;
        } else {
            return false;
        }
    }

    public function update_invoice_info($invoice_id, $data) {
        $this->db->where(['id' => $invoice_id]);
        return $this->db->update('invoice_info', $data);
    }

    public function get_invoice_by_order_id($order_id) {
        $this->db->where(['order_id' => $order_id, 'status!=' => 0]);
        return $this->db->get('invoice_info')->row_array();
    }

    public function get_invoice_order_by_service_id_invoice_id($invoice_id, $service_id) {
        $this->db->where(['invoice_id' => $invoice_id, 'service_id' => $service_id, 'status!=' => 0]);
        return $this->db->get('order')->row_array();
    }

    public function refund_all_by_invoice_id($invoice_id) {
        $this->db->where(['id' => $invoice_id]);
        return $this->db->update('invoice_info', ['is_refund' => '1']);
    }

    public function staff_office_for_invoice($invoice_id) {
        return $this->db->get_where('order', ['invoice_id' => $invoice_id])->row_array()['staff_office'];
    }

    public function get_invoice_filter_element_value($element_key, $office) {
        $tracking_array = [
                ["id" => 1, "name" => "Not Started"],
                ["id" => 2, "name" => "Started"],
                ["id" => 3, "name" => "Completed"],
                ["id" => 7, "name" => "Canceled"]
        ];
        $status_array = [
                ["id" => 1, "name" => "Unpaid"],
                ["id" => 2, "name" => "Partial"],
                ["id" => 3, "name" => "Paid"]
        ];
        switch ($element_key):
            case 1: {
                    $invoice_list = $this->billing_list();
                    return array_column($invoice_list, 'invoice_id');
                }
                break;
            case 2: {
                    $invoice_list = $this->db->get_where('invoice_info', ['status !=' => '0', 'order_id!=' => '0'])->result_array();
                    return array_column($invoice_list, 'order_id');
                }
                break;
            case 3: {
                    return $tracking_array;
                }
                break;
            case 4: {
                    return $this->administration->get_all_office();
                }
                break;
            case 5: {
                    return [
                            ["id" => 1, "name" => "Business Client"],
                            ["id" => 2, "name" => "Individual"]
                    ];
                }
                break;
            case 6: {
                    return $status_array;
                }
                break;
            case 8: {
                    $this->db->select("st.id AS id,CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) AS name");
                    $this->db->from('staff AS st');
                    if ($office != ''):
                        $this->db->join('office_staff os', 'os.staff_id = st.id');
                        $this->db->where(['os.office_id' => $office]);
                    endif;
                    $this->db->where(['st.type!=' => 4]);
                    return $this->db->get()->result_array();
                }
                break;
            case 9: {
                    $result = $this->billing_list();
                    $client_list = $client_ids = [];
                    foreach ($result as $key => $value) {
                        if (!in_array($value['reference_id'], $client_ids)) {
                            $client_ids[$key] = $value['reference_id'];
                            $client_list[$key]['id'] = $value['reference_id'];
                            $client_list[$key]['name'] = $value['client_name'];
                        }
                    }
                    return $client_list;
                }
                break;
            case 10: {
                    $this->db->select('id, description AS name');
                    $this->db->order_by('name');
                    return $this->db->get_where("services", ['status' => 1])->result_array();
                }
                break;
            case 11: {
                    return [
                            ["id" => 'byme', "name" => "By ME"],
                            ["id" => 'tome', "name" => "By Others"]
                    ];
                }
                break;
            default: {
                    return [];
                }
                break;
        endswitch;
    }

    public function save_order_on_invoice1($invoice_id, $save_type = 'create') {
        $invoice_info = $this->db->get_where('invoice_info', ['id' => $invoice_id])->row_array();
        if ($invoice_info['is_order'] == 'n') {
            return true;
        }
        if ($invoice_info['type'] == 2) {
            $this->db->where('id', $invoice_id);
            $this->db->update('invoice_info', ['is_order' => 'n']);
            return true;
        }
        $this->db->trans_begin();
        $service_request_columns = $this->db->list_fields('service_request');
        unset($service_request_columns[0]);

        $this->db->select('id');
        $order_id_list = $this->db->get_where('order', ['invoice_id' => $invoice_id])->result_array();
        $order_ids = array_column($order_id_list, 'id');

        $this->db->select('service_request.' . implode(', service_request.', $service_request_columns));
        $this->db->from('service_request');
        $this->db->join('target_days', 'target_days.service_id = service_request.services_id');
        $this->db->order_by('service_request.id');
        $this->db->where(['target_days.input_form' => 'y']);
        $this->db->where_in('order_id', $order_ids);
        $service_request_info = $this->db->get()->result_array();

        if (empty($service_request_info)) {  //check input-form exist or not 
            $this->db->where('id', $invoice_id);
            $this->db->update('invoice_info', ['is_order' => 'n']);
            return true;
        }

        $this->db->order_by('id');
        $order_data = $this->db->get_where('order', ['invoice_id' => $invoice_id])->row_array();
        unset($order_data['id']);
        unset($order_data['new_existing']);
        unset($order_data['invoice_id']);

        $order_data['category_id'] = $this->service_model->get_service_by_id($service_request_info[0]['services_id'])['category_id'];
        $order_data['service_id'] = $service_request_info[0]['services_id'];
        $order_data['total_of_order'] = $invoice_info['total_amount'];
        $order_data['status'] = 2;
        $order_data['quantity'] = 0;
        $order_data['reference'] = $invoice_info['type'] == 1 ? 'company' : 'individual';

        $this->db->select('date_started');
        $this->db->where_in('order_id', $order_ids);
        $this->db->order_by('date_started', 'ASC');
        $target_start_date = $this->db->get('service_request')->row_array();

        $this->db->select('date_completed');
        $this->db->where_in('order_id', $order_ids);
        $this->db->order_by('date_completed', 'DESC');
        $target_end_date = $this->db->get('service_request')->row_array();

        if (!empty($target_start_date)) {
            $order_data['start_date'] = $target_start_date['date_started'];
            $order_data['target_start_date'] = $target_start_date['date_started'];
        }

        if (!empty($target_end_date)) {
            $order_data['complete_date'] = $target_end_date['date_completed'];
            $order_data['target_complete_date'] = $target_end_date['date_completed'];
        }
        if ($save_type == 'create') {
            $this->db->insert('order', $order_data);
            $order_id = $this->db->insert_id();
            $this->system->update_order_serial_id_by_order_id($order_id);
        } else {
            $order_update_data['category_id'] = $this->service_model->get_service_by_id($service_request_info[0]['services_id'])['category_id'];
            $order_update_data['service_id'] = $service_request_info[0]['services_id'];
            $order_update_data['total_of_order'] = $invoice_info['total_amount'];
            $order_id = $invoice_info['order_id'];
            $this->db->where(['id' => $order_id]);
            $this->db->update('order', $order_update_data);
            $this->db->where(['order_id' => $order_id]);
            $this->db->delete('service_request');
        }

        $service_request_data = $service_request_info;
        foreach ($service_request_data as $key => $srl) {
            $service_request_data[$key]['order_id'] = $order_id;
            $service_request_data[$key]['status'] = 2;
        }
        $this->db->insert_batch('service_request', $service_request_data);

        if ($save_type == 'create') {
            $this->db->where(['id' => $invoice_id]);
            $this->db->update('invoice_info', ['order_id' => $order_id]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function save_order_on_invoice($invoice_id, $save_type = 'create') {
        $invoice_info = $this->db->get_where('invoice_info', ['id' => $invoice_id])->row_array();
//        if ($invoice_info['is_order'] == 'n') {
//            return true;
//        }
        $this->db->trans_begin();
        if($invoice_info['type'] == 1){ //Business client

               $service_request_columns = $this->db->list_fields('service_request');
        unset($service_request_columns[0]);

        $this->db->select('id');
        $order_id_list = $this->db->get_where('order', ['invoice_id' => $invoice_id])->result_array();
        $order_ids = array_column($order_id_list, 'id');

        $this->db->select(implode(', ', $service_request_columns));
        $this->db->order_by('service_request.id');
        $this->db->where_in('order_id', $order_ids);
        $service_request_info = $this->db->get('service_request')->result_array();

//        $this->db->where_in('service_id', array_column($service_request_info, 'services_id'));
//        $this->db->where(['input_form' => 'y']);
//        $target_days = $this->db->get('target_days')->result_array();
//        if (empty($target_days)) {  //check input-form exist or not 
//            $this->db->where('id', $invoice_id);
//            $this->db->update('invoice_info', ['is_order' => 'n']);
//            return true;
//        }

        $this->db->order_by('id');
        $order_data = $this->db->get_where('order', ['invoice_id' => $invoice_id])->row_array();
        unset($order_data['id']);
        unset($order_data['new_existing']);
        unset($order_data['invoice_id']);

        $order_data['category_id'] = $this->service_model->get_service_by_id($service_request_info[0]['services_id'])['category_id'];
        $order_data['service_id'] = $service_request_info[0]['services_id'];
        $order_data['total_of_order'] = $invoice_info['total_amount'];
        $order_data['status'] = 2;
        $order_data['quantity'] = 0;
        $order_data['reference'] = $invoice_info['type'] == 1 ? 'company' : 'individual';

        $this->db->select('date_started');
        $this->db->where_in('order_id', $order_ids);
        $this->db->order_by('date_started', 'ASC');
        $target_start_date = $this->db->get('service_request')->row_array();

        $this->db->select('date_completed');
        $this->db->where_in('order_id', $order_ids);
        $this->db->order_by('date_completed', 'DESC');
        $target_end_date = $this->db->get('service_request')->row_array();

        if (!empty($target_start_date)) {
            $order_data['start_date'] = $target_start_date['date_started'];
            $order_data['target_start_date'] = $target_start_date['date_started'];
        }

        if (!empty($target_end_date)) {
            $order_data['complete_date'] = $target_end_date['date_completed'];
            $order_data['target_complete_date'] = $target_end_date['date_completed'];
        }
        if ($save_type == 'create') {
            $this->db->insert('order', $order_data);
            $order_id = $this->db->insert_id();
            $this->system->update_order_serial_id_by_order_id($order_id);
        } else {
            $order_update_data['category_id'] = $this->service_model->get_service_by_id($service_request_info[0]['services_id'])['category_id'];
            $order_update_data['service_id'] = $service_request_info[0]['services_id'];
            $order_update_data['total_of_order'] = $invoice_info['total_amount'];
            $order_id = $invoice_info['order_id'];
            $this->db->where(['id' => $order_id]);
            $this->db->update('order', $order_update_data);
            $this->db->where(['order_id' => $order_id]);
            $this->db->delete('service_request');
        }

        $service_request_data = $service_request_info;
        foreach ($service_request_data as $key => $srl) {
            $target_query = $this->db->get_where("target_days", ["service_id" => $service_request_data[$key]['services_id']])->row_array();
            $service_data = $this->db->get_where("services", ["id" => $service_request_data[$key]['services_id']])->row_array();
            // print_r($service_data['responsible_assign']);exit;
            $service_request_data[$key]['order_id'] = $order_id;
            if(($target_query['input_form'] == 'n' && $target_query['service_id'] == $service_request_data[$key]['services_id'] && $service_data['responsible_assign'] == 1 && $service_data['dept'] == 'NULL' ) || ($target_query['input_form'] == 'y' && $target_query['service_id'] == $service_request_data[$key]['services_id'] && $service_data['responsible_assign'] == 1 && $service_data['dept'] == 'NULL' )){
                   
                   $service_request_data[$key]['status'] = 0; 

                   $this->db->where('id', $order_id);
                   $this->db->update('order', array('status' => 0)); 
                }else{
                    $service_request_data[$key]['status'] = 2;
                }
                
        }
        $this->db->insert_batch('service_request', $service_request_data);

//         $check_if_all_services_not_started = $this->db->query('select * from service_request where  order_id="' .  $order_id . '"')->result_array();
// //          
            
//         if (!empty($check_if_all_services_not_started)) {
//             $k = 0;
//             $status_array = '';
//             $len = count($check_if_all_services_not_started);
//             foreach ($check_if_all_services_not_started as $val) {
//                 if ($k == $len - 1) {
//                     $status_array .= $val['status'];
//                 } else {
//                     $status_array .= $val['status'] . ',';
//                 }
//                 $k++;
//             }
//         }
// //            echo $status_array;die;
//         if($status_array == 2){
//             $this->db->where('id', $order_id);
//             $this->db->update('order', array('status' => 2));
//         }else if($status_array == '0,2' || $status_array == '2,0'){
//             $this->db->where('id', $order_id);
//             $this->db->update('order', array('status' => 1));
//         }else{
//             $status_array_values = explode(",", $status_array);
//             if (count(array_unique($status_array_values)) == 1) {
//                 $this->db->where('id', $order_id);
//                 $this->db->update('order', array('status' => 0));
//             }
//         }
        

        if ($save_type == 'create') {
            $this->db->where(['id' => $invoice_id]);
            $this->db->update('invoice_info', ['order_id' => $order_id]);
        }

        }else if ($invoice_info['type'] == 2) { //Individual client

        $service_request_columns = $this->db->list_fields('service_request');
        unset($service_request_columns[0]);

        $this->db->select('id');
        $order_id_list = $this->db->get_where('order', ['invoice_id' => $invoice_id])->result_array();
        $order_ids = array_column($order_id_list, 'id');

        $this->db->select(implode(', ', $service_request_columns));
        $this->db->order_by('service_request.id');
        $this->db->where_in('order_id', $order_ids);
        $service_request_info = $this->db->get('service_request')->result_array();

        $this->db->order_by('id');
        $order_data = $this->db->get_where('order', ['invoice_id' => $invoice_id])->row_array();
        unset($order_data['id']);
        unset($order_data['new_existing']);
        unset($order_data['invoice_id']);

        $order_data['category_id'] = $this->service_model->get_service_by_id($service_request_info[0]['services_id'])['category_id'];
        $order_data['service_id'] = $service_request_info[0]['services_id'];
        $order_data['total_of_order'] = $invoice_info['total_amount'];
        $order_data['status'] = 2;
        $order_data['quantity'] = 0;
        $order_data['reference'] = $invoice_info['type'] == 1 ? 'company' : 'individual';
        $order_data['client_id'] = $invoice_info['client_id'];
        $order_data['reference_id'] = $invoice_info['client_id'];

        $this->db->select('date_started');
        $this->db->where_in('order_id', $order_ids);
        $this->db->order_by('date_started', 'ASC');
        $target_start_date = $this->db->get('service_request')->row_array();

        $this->db->select('date_completed');
        $this->db->where_in('order_id', $order_ids);
        $this->db->order_by('date_completed', 'DESC');
        $target_end_date = $this->db->get('service_request')->row_array();

        if (!empty($target_start_date)) {
            $order_data['start_date'] = $target_start_date['date_started'];
            $order_data['target_start_date'] = $target_start_date['date_started'];
        }

        if (!empty($target_end_date)) {
            $order_data['complete_date'] = $target_end_date['date_completed'];
            $order_data['target_complete_date'] = $target_end_date['date_completed'];
        }
        if ($save_type == 'create') {
            $this->db->insert('order', $order_data);
            $order_id = $this->db->insert_id();
            $this->system->update_order_serial_id_by_order_id($order_id);
        } else {
            $order_update_data['category_id'] = $this->service_model->get_service_by_id($service_request_info[0]['services_id'])['category_id'];
            $order_update_data['service_id'] = $service_request_info[0]['services_id'];
            $order_update_data['total_of_order'] = $invoice_info['total_amount'];
            $order_id = $invoice_info['order_id'];
            $this->db->where(['id' => $order_id]);
            $this->db->update('order', $order_update_data);
            $this->db->where(['order_id' => $order_id]);
            $this->db->delete('service_request');
        }

        $service_request_data = $service_request_info;
        foreach ($service_request_data as $key => $srl) {
            $target_query = $this->db->get_where("target_days", ["service_id" => $service_request_data[$key]['services_id']])->row_array();
            $service_data = $this->db->get_where("services", ["id" => $service_request_data[$key]['services_id']])->row_array();
            // print_r($service_data['responsible_assign']);exit;
            $service_request_data[$key]['order_id'] = $order_id;
            if(($target_query['input_form'] == 'n' && $target_query['service_id'] == $service_request_data[$key]['services_id'] && $service_data['responsible_assign'] == 1 && $service_data['dept'] == 'NULL' ) || ($target_query['input_form'] == 'y' && $target_query['service_id'] == $service_request_data[$key]['services_id'] && $service_data['responsible_assign'] == 1 && $service_data['dept'] == 'NULL' )){
                   
                   $service_request_data[$key]['status'] = 0; 

                   $this->db->where('id', $order_id);
                   $this->db->update('order', array('status' => 0)); 
                }else{
                    $service_request_data[$key]['status'] = 2;
                }
                
        }
        $this->db->insert_batch('service_request', $service_request_data);

//         $check_if_all_services_not_started = $this->db->query('select * from service_request where  order_id="' .  $order_id . '"')->result_array();
// //          
            
//         if (!empty($check_if_all_services_not_started)) {
//             $k = 0;
//             $status_array = '';
//             $len = count($check_if_all_services_not_started);
//             foreach ($check_if_all_services_not_started as $val) {
//                 if ($k == $len - 1) {
//                     $status_array .= $val['status'];
//                 } else {
//                     $status_array .= $val['status'] . ',';
//                 }
//                 $k++;
//             }
//         }
// //            echo $status_array;die;
//         if($status_array == 2){
//             $this->db->where('id', $order_id);
//             $this->db->update('order', array('status' => 2));
//         }else if($status_array == '0,2' || $status_array == '2,0'){
//             $this->db->where('id', $order_id);
//             $this->db->update('order', array('status' => 1));
//         }else{
//             $status_array_values = explode(",", $status_array);
//             if (count(array_unique($status_array_values)) == 1) {
//                 $this->db->where('id', $order_id);
//                 $this->db->update('order', array('status' => 0));
//             }
//         }
        

        if ($save_type == 'create') {
            $this->db->where(['id' => $invoice_id]);
            $this->db->update('invoice_info', array('order_id' => $order_id));
        }

        }
        
        // $this->db->trans_begin();
     

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function billing_list($status = '', $by = '', $office = '', $payment_status = '', $reference_id = '', $filter_data = [], $sort = [], $is_recurrence = '') {
        $staff_info = staff_info();
        $staff_id = $staff_info['id'];
        $staffrole = $staff_info['role'];
        $staff_office = $staff_info['office'];
        $departments = explode(',', $staff_info['department']);
        $select = [
            'inv.id as invoice_id',
            'inv.reference_id as reference_id',
            'inv.order_id as order_id',
            'inv.new_existing as new_existing',
            'inv.created_time as created_time',
            'inv.existing_reference_id as existing_reference_id',
            'inv.type as invoice_type',
            'inv.is_order as is_order',
            'inv.created_by AS created_by',
            'inv.payment_status AS payment_status',
            'inv.total_amount AS sub_total',
            'inv.client_id as client_id',
            'inv.is_recurrence as is_recurrence',
            '(CASE WHEN inv.type = 1 THEN (SELECT `company`.`name` FROM `company` WHERE `company`.`id` = `inv`.`client_id`) ELSE (SELECT CONCAT(individual.last_name,", ",individual.first_name) FROM `individual` WHERE `individual`.`id` = `inv`.`client_id`) END) as client_name',
            '(CASE WHEN inv.created_by = ' . sess('user_id') . ' THEN \'byme\' ELSE \'byothers\' END) as request_type',
            '(CASE WHEN inv.created_by = ' . sess('user_id') . ' THEN CONCAT(\'byme-\', inv.payment_status) ELSE CONCAT(\'byothers-\', inv.payment_status) END) as filter_value',
            'inv.start_month_year as start_month_year',
            'inv.existing_practice_id as existing_practice_ID',
            'inv.status as invoice_status',
            '(SELECT COUNT(*) FROM `order` WHERE invoice_id = inv.id AND reference = \'invoice\') as services',
            'indt.office as office_id',
            '(SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office',
            '(SELECT ofc.office_id FROM office as ofc WHERE ofc.id = indt.office) as officeid',
            '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = indt.partner) as partner',
            '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = indt.manager) as manager',
            '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = inv.created_by) as created_by_name',
            '(SELECT CONCAT(",", GROUP_CONCAT(`service_id`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_services',
//            '(CAST((SELECT sr.price_charged FROM service_request sr WHERE sr.order_id = ord.id AND sr.services_id = ord.service_id) AS Decimal(10,2)) * ord.quantity) as sub_total',
            '(SELECT SUM(pay_amount) FROM payment_history WHERE payment_history.type = \'payment\' AND payment_history.invoice_id = inv.id AND payment_history.is_cancel = 0) AS pay_amount',
            '(SELECT pattern FROM invoice_recurence WHERE invoice_recurence.invoice_id = inv.id) as pattern',
            '(SELECT due_date FROM invoice_recurence WHERE invoice_recurence.invoice_id = inv.id) as due_date',
            '(SELECT next_occurance_date FROM invoice_recurence WHERE invoice_recurence.invoice_id = inv.id) as next_generation_date',
            '(SELECT total_generation_time FROM invoice_recurence WHERE invoice_recurence.invoice_id = inv.id) as total_generation_time',
            '(SELECT duration_time FROM invoice_recurence WHERE invoice_recurence.invoice_id = inv.id) as total_duration_time',
            '(SELECT start_date FROM invoice_recurence WHERE invoice_recurence.invoice_id = inv.id) as created_date',
            '(SELECT duration_type FROM invoice_recurence WHERE invoice_recurence.invoice_id = inv.id) as duration_type',
            ];
        $where['ord.reference'] = '`ord`.`reference` = \'invoice\' ';
        $where['status'] = 'AND `inv`.`status` != 0 ';
        if ($is_recurrence != '') {
            $where['inv.is_recurrence'] = " AND inv.is_recurrence='" . $is_recurrence . "' ";
        } else {
            $is_recurrence = 'n';
            $where['inv.is_recurrence'] = " AND inv.is_recurrence= '" . $is_recurrence . "' ";
        }
        if ($by != '') {
            if ($by == 'byme') {
                $where['inv.created_by'] = 'AND `inv`.`created_by` = ' . $staff_id . ' ';
            } else if ($by == 'tome') {
                if (in_array(2, $departments)) {
                    if ($staffrole == 2) {      // frinchisee manager
                        $where['inv.created_by'] = 'AND `inv`.`created_by` != ' . $staff_id . ' ';
                        $where['indt.office'] = 'AND `indt`.`office` IN (' . $staff_office . ') ';
                    } else {
                        return [];
                    }
                } else {  // admin/corporate
                    $where['inv.created_by'] = 'AND `inv`.`created_by` != ' . $staff_id . ' ';
                }
            } else {
                if (in_array(2, $departments)) {
                    $where['inv.created_by'] = 'AND `inv`.`created_by` = ' . $staff_id . ' ';
                    if ($staffrole == 2) {      // frinchisee manager
                        $where['indt.office'] = 'AND `indt`.`office` IN (' . $staff_office . ') ';
                    } else {
                        return [];
                    }
                }
            }
        } else {
            if (in_array(2, $departments)) {
                if ($staffrole == 2) {      // frinchisee manager
                    $where['indt.office'] = 'AND `indt`.`office` IN (' . $staff_office . ') ';
                } else {
                    $where['inv.created_by'] = 'AND `inv`.`created_by` = "' . $staff_id . '" ';
                }
            } else {
                $where_or = 'OR (`inv`.`created_by` = "' . $staff_id . '" AND `inv`.`status` NOT IN (0,7) AND inv.is_recurrence="' . $is_recurrence . '")';
            }
        }


        if ($status == '') {
            $where['inv.payment_status'] = 'AND (CASE WHEN `inv`.`status` = 3 THEN `inv`.`payment_status` IN (1, 2) ELSE `inv`.`payment_status` IN (1, 2, 3) END) ';
            $where['inv.status'] = 'AND `inv`.`status` NOT IN (7) ';
        } else {
            unset($where_or);
            if ($status == 3) {
                $where['inv.payment_status'] = 'AND `inv`.`payment_status` IN (1, 2) ';
            }
            $where['inv.status'] = 'AND `inv`.`status` = ' . $status . ' ';
        }

        if ($payment_status == '') {
            $where['inv.payment_status'] = 'AND (CASE WHEN `inv`.`payment_status` = 3 THEN `inv`.`status` NOT IN (3) ELSE `inv`.`status` IN (1, 2, 3) END) ';
        } else if ($payment_status == 3) {
            unset($where_or);
            $where['inv.payment_status'] = 'AND `inv`.`payment_status` = ' . $payment_status . ' ';
            $where['inv.status'] = 'AND `inv`.`status` NOT IN (3, 7) ';
        } else {
            unset($where_or);
            $where['inv.payment_status'] = 'AND `inv`.`payment_status` = ' . $payment_status . ' ';
        }


        $is_status = $is_tracking = 'n';
        if (!empty($filter_data)) {
            $key = 0;
            if (isset($filter_data['criteria_dropdown'])) {
                foreach ($filter_data['criteria_dropdown'] as $filter_key => $filter) {
                    unset($where_or);
                    $condition = isset($filter_data['condition_dropdown'][$key]) ? $filter_data['condition_dropdown'][$key] : 1;
                    if ($filter_key == "creation_date") {
                        if (strlen($filter[0]) == 10) {
                            $date_value = date("Y-m-d", strtotime($filter[0]));
                            // $where[$this->filter_element[$filter_key]] = 'AND ' . $this->filter_element[$filter_key] . ' ' . (($condition == 2 || $condition == 4) ? 'NOT ' : '') . 'IN ("' . $date_value . '") ';
                            $where[$this->filter_element[$filter_key]] = 'AND ' . $this->filter_element[$filter_key] . ' ' . (($condition == 2 || $condition == 4) ? 'not like ' : 'like') . '"' . $date_value . '%"';
                        } elseif (strlen($filter[0]) == 23) {
                            $date_value = explode(" - ", $filter[0]);
                            foreach ($date_value as $date_key => $date) {
                                $date_value[$date_key] = "'" . date("Y-m-d", strtotime($date)) . "'";
                            }
                            $where[$this->filter_element[$filter_key]] = 'AND (Date(' . $this->filter_element[$filter_key] . ') ' . (($condition == 3 || $condition == 4) ? 'NOT ' : '') . 'BETWEEN ' . implode(' AND ', $date_value) . ') ';
                        }
                    } elseif ($filter_key == "due_date") {

                        if (strlen($filter[0]) == 10) {
                            $date_value = date('Y-m-d', strtotime('-30 days', strtotime($filter[0])));

                            $where['inv.created_time'] = 'AND inv.created_time' . ' ' . (($condition == 3) ? 'not like ' : 'like') . '"' . $date_value . '%"';
                        } elseif (strlen($filter[0]) == 23) {
                            $date_value = explode(" - ", $filter[0]);

                            foreach ($date_value as $date_key => $date) {
                                $date_value[$date_key] = "'" . date("Y-m-d", strtotime('-30 days', strtotime($date))) . "'";
                            }
                            $where['inv.created_time'] = 'AND (Date(inv.created_time) ' . (($condition == 3 || $condition == 4) ? 'NOT ' : '') . ' BETWEEN ' . implode(' AND ', $date_value) . ') ';
                        }
                    } else {
                        if ($filter_key == 'tracking') {
                            $is_tracking = 'y';
                        }
                        if ($filter_key == 'status') {
                            $is_status = 'y';
                        }
                        if (!empty($filter)) {
                            if ($filter_key == 'request_type') {
                                if (implode('", "', $filter) == 'byme') {
                                    $where['inv.created_by'] = 'AND `inv`.`created_by` = ' . $staff_id . ' ';
                                } else if (implode('", "', $filter) == 'tome') {
                                    if (in_array(2, $departments)) {
                                        if ($staffrole == 2) {      // frinchisee manager
                                            $where['inv.created_by'] = 'AND `inv`.`created_by` != ' . $staff_id . ' ';
                                            $where['indt.office'] = 'AND `indt`.`office` IN (' . $staff_office . ') ';
                                        } else {
                                            return [];
                                        }
                                    } else {  // admin/corporate
                                        $where['inv.created_by'] = 'AND `inv`.`created_by` != ' . $staff_id . ' ';
                                    }
                                } else {
                                    if (in_array(2, $departments)) {
                                        $where['inv.created_by'] = 'AND `inv`.`created_by` = ' . $staff_id . ' ';
                                        if ($staffrole == 2) {      // frinchisee manager
                                            $where['indt.office'] = 'AND `indt`.`office` IN (' . $staff_office . ') ';
                                        } else {
                                            return [];
                                        }
                                    }
                                }
                            } else {
                                $where[$this->filter_element[$filter_key]] = 'AND ' . $this->filter_element[$filter_key] . ' ' . (($condition == 3 || $condition == 4) ? 'NOT ' : '') . 'IN ("' . implode('", "', $filter) . '") ';
                            }
                        }
                    }
                }
                $key++;
            }
        }

        $order_by = 'ORDER BY `inv`.`id` DESC ';
        if (!empty($sort) && count($sort) > 0) {
            $order_by = 'ORDER BY ' . $this->sorting_element[$sort['sort_criteria']] . ' ' . $sort['sort_type'];
        }

        if ($office != '') {
            unset($where_or);
            if (strpos($office, ',') !== false) {
                $where['indt.office'] = 'AND `indt`.`office` IN (' . $office . ') ';
            } else {
                $where['indt.office'] = 'AND `indt`.`office` = ' . $office . ' ';
            }
        }

        if ($reference_id != '') {
            unset($where_or);
            unset($where['inv.payment_status']);
            $reference = explode("-", $reference_id);
            $where['indt.reference_id'] = 'AND `indt`.`reference_id` = ' . $reference[0] . ' ';
            $where['indt.reference'] = 'AND `indt`.`reference` = "' . $reference[1] . '" ';
            $where['inv.status'] = 'AND `inv`.`status` NOT IN (7) ';
        }
        if (!empty($filter_data)) {
            if ($is_tracking == 'n') {
                unset($where['inv.status']);
            }
            if ($is_status == 'n') {
                unset($where['inv.payment_status']);
            }
        }

        $table = '`invoice_info` AS `inv` ' .
                'INNER JOIN `order` AS `ord` ON `ord`.`invoice_id` = `inv`.`id` ' .
                'INNER JOIN `internal_data` AS `indt` ON (CASE WHEN `inv`.`type` = 1 THEN `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "company" ELSE `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "individual" END) ';

        $this->db->query('SET SQL_BIG_SELECTS=1');
        return $this->db->query('SELECT ' . implode(', ', $select) . ' FROM ' . $table . 'WHERE ' . implode('', $where) . (isset($where_or) ? $where_or : '') . ' GROUP BY `ord`.`invoice_id` ' . $order_by . ' ')->result_array();
//        echo $this->db->last_query();die;
    }

    public function update_payment_status_by_invoice_id($invoice_id) {
        $update_data['payment_status'] = $this->billing_model->get_invoice_payment_status_by_invoice_id($invoice_id);
        $update_data['total_amount'] = number_format((float) array_sum(array_column($this->billing_model->get_order_by_invoice_id($invoice_id), 'sub_total')), 2, '.', '');
        $this->db->where('id', $invoice_id);
        return $this->db->update('invoice_info', $update_data);
    }

    public function save_invoice_service_note($note_data) {
        if (isset($note_data['note'])) {
            $reference_id = $this->notes->get_main_service_id($note_data['service_order_id'], $note_data['service_id']);
            if (!empty($reference_id)) {
                $reference_id = $reference_id['id'];
                $this->notes->insert_note(1, $note_data['note'][$note_data['service_order_id']], 'reference_id', $reference_id, 'service');
            }
        }

        if (isset($note_data['edit_note']) && !empty($note_data['edit_note'])) {
            $this->notes->update_note(1, $note_data['edit_note']);
        }
        return count(invoice_notes($note_data['service_order_id'], $note_data['service_id']));
    }

    public function get_office_id_by_individual_id($id) {
        $this->db->where('id', $id);
        $this->db->where('reference', 'individual');
        return $this->db->get('internal_data')->row_array()['office'];
    }

    public function get_royalty_reports_data($office= "",$date_range= "") {
        ## Read value
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $staff_info = staff_info();
        $staff_id = $staff_info['id'];
        $staffrole = $staff_info['role'];
        $staff_office = explode(',',$staff_info['office']);
        $departments = explode(',', $staff_info['department']);
 
        // if (in_array(2, $departments)) {
        //     if ($staffrole == 2) {      // frinchisee manager
        //         $this->db->where_in('office_id', $staff_office);
        //     } else {
        //         $this->db->where('created_by',$staff_id);
        //     }
        // }
        if ($office != "") {
            $this->db->where_in('office_id',$office);
        } else{
            if($staff_info['type'] == 3) {
                $this->db->where_in('office_id',$staff_office);
            }    
        }
        if ($date_range != "") {
            $date_value = explode("-", $date_range);
            $start_date = date("Y-m-d", strtotime($date_value[0]));
            $end_date = date("Y-m-d", strtotime($date_value[1]));
            
            $this->db->where('date >=',$start_date);
            $this->db->where('date <=',$end_date);
        }
        if ($searchValue != '') {
            $this->db->group_start();
            $this->db->like('client_id', $searchValue);
            $this->db->or_like('service_name', $searchValue);
            $this->db->or_like('service_name', $searchValue);
            $this->db->or_like('payment_status', $searchValue);
            $this->db->or_like('payment_type', $searchValue);
            $this->db->or_like('reference', $searchValue);
            $this->db->or_like('authorization_id', $searchValue);
            $this->db->or_like('office_fee', $searchValue);
            $this->db->group_end();
        }
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $res_for_all = $this->db->get('royalty_report')->num_rows();
        $qr = $this->db->last_query();
        $qr .= ' order by ' . $columnName . ' ' . $columnSortOrder;
        $qr .= ' limit ' . $row . ',' . $rowperpage;
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $royalty_reports_data = $this->db->query($qr)->result_array();

        $totalRecords = $res_for_all;
        $totalRecordwithFilter = $res_for_all;
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $royalty_reports_data
        );

        return $response;

    }

    public function get_payment_details_service_id($invoice_id, $order_id) {
        $sql = "pay.reference_no AS reference,pay.authorization_id,typ.name AS payment_type,pay.pay_amount AS collected";
        $this->db->select($sql);
        $this->db->from('payment_history pay');
        $this->db->join('payment_type typ', 'typ.id = pay.payment_type');
        $this->db->where("invoice_id", $invoice_id);
        $this->db->where("order_id", $order_id);
        $this->db->where('type', 'payment');
        $this->db->where('is_cancel !=', 1);
        return $this->db->get()->result_array();
    }

    public function get_total_price_report($office,$date_range) {
        $staff_info = staff_info();
        $staff_id = $staff_info['id'];
        $staffrole = $staff_info['role'];
        $staff_office = explode(',',$staff_info['office']);
        $departments = explode(',', $staff_info['department']);

        if (!empty($office)) {
            $this->db->where_in('office_id',$office);
        } else {
            if($staff_info['type'] == 3) {
                $this->db->where_in('office_id',$staff_office);
            }    
        }

        if ($date_range != "") {
            $date_value = explode("-", $date_range);
            $start_date = date("Y-m-d", strtotime($date_value[0]));
            $end_date = date("Y-m-d", strtotime($date_value[1]));
            
            $this->db->where('date >=',$start_date);
            $this->db->where('date <=',$end_date);
        }           
        $total_data = $this->db->get('royalty_report')->result_array();
        $total_arr = array(
            "invoice_id" => count($total_data),
            "retail_price" => array_sum(array_column($total_data,'retail_price')),
            "cost" => array_sum(array_column($total_data,'cost')),
            "collected" => array_sum(array_column($total_data,'collected')),
            "total_net" => array_sum(array_column($total_data,'total_net')),
            "override_price" => array_sum(array_column($total_data,'override_price')),
            "fee_with_cost" => array_sum(array_column($total_data,'fee_with_cost')),
            "fee_without_cost" => array_sum(array_column($total_data,'fee_without_cost'))

        );
        return $total_arr;        
    }

    public function get_start_date_royalty_report() {
        $sql = "SELECT MIN(created_time) as created_time FROM `invoice_info` where date_format(created_time,'%Y-%m-%d')!='0000-00-00' order by created_time asc";
        $start_date = $this->db->query($sql)->row_array()['created_time'];
        return date("m/d/Y", strtotime($start_date));
    }

    public function getInvoiceIsRecurrence($invoice_id) {
        return $this->db->get_where('invoice_info', ['id' => $invoice_id])->row()->is_recurrence;
    }

    public function getInvoiceRecurringDetails($invoice_id) {
        return $this->db->get_where('invoice_recurence', ['invoice_id' => $invoice_id])->row();
    }
    public function report_billing_list() {
        $data_office = $this->db->get('office')->result_array();
        // $data_office = $this->system->get_staff_office_list();
        $invoice_details = [];
        
        foreach ($data_office as $do) {    
            $data = [
                'id' => $do['id'],
                'office' => $do['name'],
                'total_invoice' => $this->db->get_where('report_dashboard_billing',array('office_id'=>$do['id']))->num_rows(),
                'amount_collected' => $this->amount_collected($do['id']),
                'unpaid' => $this->db->get_where('report_dashboard_billing',array('office_id'=>$do['id'],'payment_status'=>'Unpaid'))->num_rows(),
                'paid' => $this->db->get_where('report_dashboard_billing',array('office_id'=>$do['id'],'payment_status'=>'Paid'))->num_rows(),
                'partial' => $this->db->get_where('report_dashboard_billing',array('office_id'=>$do['id'],'payment_status'=>'Partial'))->num_rows(),
                'less_than_30' => $this->late_status_calculation_report_dashboard_billing($do['id'],'less_than_30'),
                'less_than_60' => $this->late_status_calculation_report_dashboard_billing($do['id'],'less_than_60'),
                'more_than_60' => $this->late_status_calculation_report_dashboard_billing($do['id'],'more_than_60')           
            ];
            array_push($invoice_details,$data);
        }
        return $invoice_details;
    }

    public function amount_collected($ofc_id) {
        $this->db->where('office_id',$ofc_id);
        $amount_data = $this->db->get('report_dashboard_billing')->result_array();
        return $amount_collected = array_sum(array_column($amount_data,'amount_collected'));
    }

    public function late_status_calculation_report_dashboard_billing($ofc_id,$late_span) {
        $this->db->where('office_id',$ofc_id);
        $reports_data = $this->db->get('report_dashboard_billing')->result_array();
        $date_arr = array_column($reports_data,'created_date');
        $date_arr_total = [];
        foreach ($date_arr as $da) {
            $current_date = date('Y-m-d');
            $date_difference = (strtotime($current_date) - strtotime($da))/60/60/24;
            array_push($date_arr_total,$date_difference);
        }
        if ($late_span == 'less_than_30') {
            $x = 0;
            foreach ($date_arr_total as $dat) {
                if ($dat < 30) {
                    $x++;
                }
            }
            return $x;
        }
        if ($late_span == 'less_than_60') {
            $y = 0;
            foreach ($date_arr_total as $dat) {
                if ($dat < 60) {
                    $y++;
                }
            }
            return $y;
        }
        if ($late_span == 'more_than_60') {
            $z = 0;
            foreach ($date_arr_total as $dat) {
                if ($dat > 60) {
                    $z++;
                }
            }
            return $z;
        }
    }
    public function recurring($invoice_id){
      return $this->db->query("select is_recurrence from invoice_info where id = $invoice_id")->result_array(); 
      
    }
}