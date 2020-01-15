<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patch extends CI_Controller {

    private $access = true; //for active patch set $access = true

    function __construct() {
        parent::__construct();
        if (!$this->access) {
            exit('Access denied (404) for active patch set $access = true');
        }
        $this->load->model('system');
        $this->load->model('service_model');
        $this->load->model('administration');
        $this->load->model('lead_management');
    }

    public function service_patch() {
        $result = $this->db->get("services")->result_array();
        foreach ($result as $service) {
            if ($this->db->get_where("target_days", ['service_id' => $service['id']])->num_rows() == 0) {
                $this->db->insert("target_days", [
                    "service_id" => $service['id'],
                    "service_name" => $service['description'],
                    "start_days" => 0,
                    "end_days" => 0,
                    "category_id" => $service['category_id'],
                ]);
            }
        }
    }

    public function patch_individual2() {
        $result = $this->db->get("individual")->result_array();
        foreach ($result as $individual) {
//            $this->db->where(['individual_id' => $individual['id']]);
            $main_reference_id = $this->db->select_min('company_id')->get_where("title", ['individual_id' => $individual['id']])->row()->company_id;
            $this->db->where(['individual_id' => $individual['id']]);
            $this->db->update("title", ['existing_reference_id' => $main_reference_id]);
//            print_r($main_reference_id);
        }
    }

    public function patch_country() {
        $result = $this->db->get_where("countries", ['id!=' => 230])->result_array();
        foreach ($result as $country) {
            $this->db->where(['id' => $country['id']]);
            $this->db->update("countries", ['sort_order' => $country['id'] + 1]);
        }
        $this->db->where(['id' => 230]);
        $this->db->update("countries", ['sort_order' => 0]);
    }

    public function patch_individual() {
        $result = $this->db->get_where("individual", ['status' => 1])->result_array();
        foreach ($result as $ld) {
            $select = 'select id from individual where first_name="' . $ld['first_name'] . '" and last_name="' . $ld['last_name'] . '" and birth_date="' . $ld['birth_date'] . '" and id!="' . $ld['id'] . '"';
            $result_val = $this->db->query($select)->result_array();
            foreach ($result_val as $ldval) {
                $sql = 'delete from individual where id="' . $ldval['id'] . '"';
                $this->db->query($sql);
                $sql2 = 'delete from title where individual_id="' . $ldval['id'] . '"';
                $this->db->query($sql2);
            }
        }
    }

    public function update_order_serial_id() {
        $result = $this->db->get_where("order", ['invoice_id' => 0])->result_array();
        foreach ($result as $key => $ord) {
            $serial_id = $key + 1;
            $this->db->where(['id' => $ord['id']]);
            $this->db->update("order", ['order_serial_id' => $serial_id]);
        }
    }

    public function service_shortcode() {
        $result = $this->db->get("services")->result_array();
        foreach ($result as $key => $srv) {
            $servicename = trim($srv['description']);
            $servicecat = $srv['category_id'];
            $servcat_name = $this->system->get_servicecat_name($servicecat)['name'];
            $servcat_allias = strtolower(substr($servcat_name, 0, 3));
            $sp = explode(' ', $servicename);
            $len = count($sp);
            $i;
            $sc = '';
            for ($i = 0; $i < $len; $i++) {
                if ($sp[$i] != '-') {

                    if ($i == ($len - 1)) {
                        $sc .= strtolower($sp[$i][0]);
                    } else {
                        $sc .= strtolower($sp[$i][0]) . '_';
                    }
                }
            }
            $sc = $servcat_allias . '_' . $sc;
            $check_shortname = $this->service_model->check_shortname($sc);
            if ($check_shortname != 0) {
                $sc = $sc . '2';
            }
            $this->db->where(['id' => $srv['id']]);
            $this->db->update("services", ['ideas' => $sc]);
        }
    }

    public function patch_update_delaware() {
        $data = $this->db->query("select * from `order` o inner join company c on o.reference_id=c.id where o.service_id='1' and c.state_opened='8' and o.order_serial_id!='0'")->result_array();
        foreach ($data as $result) {
            $order_id = $result['id'];
            $srq = $this->db->query("select * from service_request where order_id='$order_id' and services_id=1")->row_array();
            if (!empty($srq)) {
                if ($srq['price_charged'] == 500) {
                    $this->db->query("update `order` set total_of_order = (`total_of_order` + 300) where id = $order_id");
                    $this->db->query("update service_request set services_id = '44', price_charged = '800' where id = '" . $srq['id'] . "'");
                }
            }
        }
    }

    public function update_late_status() {
        $data = $this->db->query("select * from `order` where order.complete_date > CURRENT_DATE() ")->result_array();
        foreach ($data as $val) {
            $order_id = $val['order_serial_id'];
            $this->db->query("update `order` set late_status=0 where order.order_serial_id=$order_id and late_status=1;");
        }
    }

    public function update_invoice_id_in_order_table() {
        $result = $this->db->get_where("invoice_info", ['order_id!=' => 0])->result_array();
        foreach ($result as $inv) {
            $this->db->where(['id' => $inv['order_id']]);
            $this->db->update("order", ['invoice_id' => $inv['id']]);
        }
    }

    public function delete_blank_individuals() {
        $this->db->select('*');
        $this->db->from('individual');
        // $where = '((first_name = '' OR first_name is NULL) AND (last_name = '' OR last_name is NULL))';
        $this->db->where(['first_name' => '']);
        $this->db->or_where(['first_name is NULL' => NULL]);
        $this->db->where(['last_name' => '']);
        $this->db->or_where(['last_name is NULL' => NULL]);
        $query = $this->db->get();
        $res = $query->result_array();
        foreach ($res as $r) {
            $ind_id = $r['id'];
            $this->db->delete('contact_info', ['reference' => 'individual', 'reference_id' => $ind_id]);
            $this->db->delete('title', ['individual_id' => $ind_id]);
            $this->db->delete('individual', ['id' => $ind_id]);
        }
    }

    public function insert_import_clients() {
        $this->load->model('system');
        $fullpath = FCPATH . 'uploads/new_list_revised.csv';

        $this->load->library('csvreader');
        $result = $this->csvreader->parse_file($fullpath); //path to csv file
        if (!empty($result)) {
            foreach ($result as $data) {
                $check_if_company_exists = $this->action_model->check_if_company_exists($data['company_name']);
                if (!empty($check_if_company_exists)) {
                    $reference_id = $check_if_company_exists['id'];

                    $p = trim($data['partner']);
                    $m = trim($data['manager']);
                    $pex = explode(" ", $p);
                    $mex = explode(" ", $m);
                    // print_r($pex);
                    // print_r($mex); 
                    $p_f = $pex[0];
                    $p_l = $pex[1];
                    $m_f = $mex[0];
                    $m_l = $mex[1];

                    $this->db->like('first_name', trim($p_f), 'after');
                    $this->db->like('last_name', trim($p_l), 'after');
                    $result1 = $this->db->get('staff')->row_array();

                    $p_id = $result1['id'];

                    $this->db->like('first_name', trim($m_f), 'after');
                    $this->db->like('last_name', trim($m_l), 'after');
                    $result2 = $this->db->get('staff')->row_array();

                    $m_id = $result2['id'];

                    $this->db->set(["partner" => $p_id, "manager" => $m_id])->where("reference", 'company')->where("reference_id", $reference_id)->update('internal_data');
                    $p_m_f = trim($data['partner_mngr_fname']);
                    $p_m_l = trim($data['partner_mngr_lname']);

                    $this->db->where('first_name', trim($p_m_f));
                    $this->db->where('last_name', trim($p_m_l));
                    $result = $this->db->get('staff')->row_array();
                    //echo $this->db->last_query(); exit;
                    $staff_id = $result['id'];
                    $this->db->delete('office_staff', ["staff_id" => $staff_id]);
                    $this->db->delete('department_staff', ["staff_id" => $staff_id]);
                    $this->db->delete('staff', ["id" => $staff_id]);
                }
            }
            echo '1';
        } else {
            echo '0';
        }
    }

    public function action_add_by_office() {
        $this->db->select('*');
        $this->db->from('actions');
        $query = $this->db->get();
        $res = $query->result_array();
        foreach ($res as $a) {
            $this->db->where(['staff_id' => $a['added_by_user']]);
            $q = $this->db->get('office_staff');
            $r = $q->result_array();
            foreach ($r as $o) {
                $data = array(
                    'id' => '',
                    'action_id' => $a['id'],
                    'office_id' => $o['office_id']
                );
                $this->db->insert('action_add_by_user_office', $data);
            }
        }
    }

    public function change_individual_from_nmb_to_tlc() {
        $this->db->select('*');
        $this->db->from('internal_data');
        $this->db->where(['office' => '19']);
        $query = $this->db->get();
        $res = $query->result_array();
        foreach ($res as $r) {
            $this->db->where(['id' => $r['id']]);
            $this->db->update("internal_data", ['office' => '17', 'partner' => '76', 'manager' => '76']);
        }
    }

    public function change_individual_from_nalogi_to_csi() {
        $this->db->select('*');
        $this->db->from('internal_data');
        $this->db->where(['office' => '32']);
        $query = $this->db->get();
        $res = $query->result_array();
        foreach ($res as $r) {
            $this->db->where(['id' => $r['id']]);
            $this->db->update("internal_data", ['office' => '18', 'partner' => '61', 'manager' => '61']);
        }
    }

    public function update_contact_info_of_business() {
        $this->db->select('*');
        $this->db->from('contact_info');
        $this->db->where(['reference' => 'company', 'status' => '1']);
        $query = $this->db->get();
        $res = $query->result_array();
        $ref_id = array_column($res, 'reference_id');
        $unique_ref_id = array_unique($ref_id);
        //print_r($unique_ref_id);
        foreach ($unique_ref_id as $r) {
            $this->db->select('*');
            $this->db->from('contact_info');
            $this->db->where(['reference' => 'company', 'reference_id' => $r, 'status' => '1']);
            $inner_query = $this->db->get();
            $inner_res = $inner_query->result_array();
            if (!empty($inner_res)) {
                if (count($inner_res) != 1) {
                    foreach ($inner_res as $key => $val) {
                        if ($key != 0) {
                            $idval = $val['id'];
                            $this->db->where(['id' => $idval]);
                            $this->db->update("contact_info", ['status' => '3']);
                        }
                    }
                }
            }
        }
    }

    public function update_contact_info_of_individual() {
        $this->db->select('*');
        $this->db->from('contact_info');
        $this->db->where(['reference' => 'individual', 'status' => '1']);
        $this->db->limit(0, 17221);
        $query = $this->db->get();
        $res = $query->result_array();
        $ref_id = array_column($res, 'reference_id');
        $unique_ref_id = array_unique($ref_id);
        //print_r($unique_ref_id);
        foreach ($unique_ref_id as $r) {
            $this->db->select('*');
            $this->db->from('contact_info');
            $this->db->where(['reference' => 'individual', 'reference_id' => $r, 'status' => '1']);
            $inner_query = $this->db->get();
            $inner_res = $inner_query->result_array();
            if (!empty($inner_res)) {
                if (count($inner_res) != 1) {
                    foreach ($inner_res as $key => $val) {
                        if ($key != 0) {
                            $idval = $val['id'];
                            $this->db->where(['id' => $idval]);
                            $this->db->update("contact_info", ['status' => '3']);
                        }
                    }
                }
            }
        }
    }

    public function update_staff_office_in_order() {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where(['reference' => 'company', 'staff_office' => '0', 'status!=' => '10']);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        $res = $query->result_array();
        //print_r($res); exit;
        foreach ($res as $r) {
            $ofc = $this->administration->get_office_by_staff_id($r['staff_requested_service']);
            $ofc_id = $ofc[0]['id'];
            $idval = $r['id'];
            $this->db->where(['id' => $idval]);
            $this->db->update("order", ['staff_office' => $ofc_id]);
            // echo $this->db->last_query(); exit;
        }
    }

    public function individual_fix_patch() {
        $this->db->select('idv.*,tit.company_id');
        $this->db->from('individual idv');
        $this->db->join('title tit', 'tit.individual_id = idv.id');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        $res = $query->result_array();
        if (!empty($res)) {
            foreach ($res as $r) {
                $company_id = $r['company_id'];
                $idval = $r['id'];
                $this->db->select('id');
                $this->db->from('internal_data');
                $this->db->where(['reference' => 'individual', 'reference_id' => $company_id]);
                $query2 = $this->db->get();
                $res2 = $query2->row_array();
                if (!empty($res2)) {
                    $internal_id = $res2['id'];
                    $this->db->where(['id' => $internal_id, 'reference' => 'individual']);
                    $this->db->update("internal_data", ['reference_id' => $idval]);
                }
            }
        }
    }

    public function individual_fix_patch2() {
        $this->db->select('*');
        $this->db->from('internal_data');
        $this->db->where(['reference' => 'company']);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        $res = $query->result_array();
        if (!empty($res)) {
            foreach ($res as $r) {
                $reference_id = $r['reference_id'];
                $this->db->select('*');
                $this->db->from('title');
                $this->db->where(['company_id' => $reference_id]);
                $query2 = $this->db->get();
                $res2 = $query2->result_array();
                if (!empty($res2)) {
                    foreach ($res2 as $r2) {
                        $individual_id = $r2['individual_id'];
                        $insert_data = $r;
                        unset($insert_data['id']);
                        $insert_data['reference'] = 'individual';
                        $insert_data['reference_id'] = $individual_id;
                        //print_r($insert_data); exit;
                        $this->db->insert('internal_data', $insert_data);
                    }
                }
            }
        }
    }

    public function update_payment_status() {
        $invoice_list = $this->db->get('invoice_info')->result_array();
        $this->load->model('billing_model');
        foreach ($invoice_list as $il) {
            $update_data['payment_status'] = $this->billing_model->get_invoice_payment_status_by_invoice_id($il['id']);
            $update_data['total_amount'] = number_format((float) array_sum(array_column($this->billing_model->get_order_by_invoice_id($il['id']), 'sub_total')), 2, '.', '');
            $this->db->where('id', $il['id']);
            $this->db->update('invoice_info', $update_data);
        }
    }

    public function client_due_amount() {
        $this->db->where_not_in('status', [0, 7]);
        $this->db->group_by('reference_id');
        $invoice_list = $this->db->get('invoice_info')->result_array();
        $result_array = [];
        foreach ($invoice_list as $key => $il) {
            $this->db->where('reference_id', $il['reference_id']);
            $client_invoice_list = $this->db->get('invoice_info')->result_array();
            $due = 0;
            foreach ($client_invoice_list as $cil) {
                $this->db->select('SUM(pay_amount) AS pay_amount');
                $payment_history = $this->db->get_where('payment_history', ['type' => 'payment', 'invoice_id' => $cil['id'], 'is_cancel' => 0])->row_array();
                if (empty($payment_history)) {
                    $pay_amount = 0;
                } else {
                    $pay_amount = $payment_history['pay_amount'];
                }
                $due += (number_format((float) array_sum(array_column($this->billing_model->get_order_by_invoice_id($cil['id']), 'sub_total')), 2, '.', '')) - $pay_amount;
            }
            if ($due != 0) {
                $result_array[$key]['AMOUNT_DUE'] = $due;
                if ($il['type'] == 1) {
                    $this->db->select("c.name, ind.practice_id, (SELECT ofc.name FROM office as ofc WHERE ofc.id = ind.office) as office_name");
                    $this->db->from("company c");
                    $this->db->join("internal_data ind", "ind.reference_id = c.id and ind.reference='company'");
                    $this->db->where("c.id", $il['reference_id']);
                    $bsn = $this->db->get()->row_array();
                    $result_array[$key]['CLIENT_TYPE'] = 'Business Client';
                    $result_array[$key]['CLIENT_ID'] = $bsn['practice_id'];
                    $result_array[$key]['CLIENT_NAME'] = $bsn['name'];
                    $result_array[$key]['OFFICE'] = $bsn['office_name'];
                } else {
                    $this->db->select("ind.first_name,ind.middle_name,ind.last_name,int.practice_id, (SELECT ofc.name FROM office as ofc WHERE ofc.id = int.office) as office_name");
                    $this->db->from("individual ind");
                    $this->db->join("title tit", "ind.id = tit.individual_id");
                    $this->db->join("internal_data int", "int.reference_id = ind.id and int.reference='individual'");
                    $this->db->where("tit.company_id", $il['reference_id']);
                    $this->db->group_by('ind.id');
                    $ind = $this->db->get()->row_array();
                    $result_array[$key]['CLIENT_TYPE'] = 'Individual';
                    $result_array[$key]['CLIENT_ID'] = $ind['practice_id'];
                    $result_array[$key]['CLIENT_NAME'] = $ind['last_name'] . ', ' . $ind['first_name'] . ' ' . $ind['middle_name'];
                    $result_array[$key]['OFFICE'] = $ind['office_name'];
                }
            }
        }
        echo '<center><table border="1">
                <tr>
                    <th>CLIENT TYPE</th>
                    <th>CLIENT ID</th>
                    <th>CLIENT NAME</th>
                    <th>OFFICE</th>
                    <th>AMOUNT DUE</th>                    
                </tr>';
        foreach ($result_array as $val) {
            echo '<tr>
                    <th>' . $val['CLIENT_TYPE'] . '</th>
                    <th>' . $val['CLIENT_ID'] . '</th>
                    <th>' . $val['CLIENT_NAME'] . '</th>
                    <th>' . $val['OFFICE'] . '</th>
                    <th>' . $val['AMOUNT_DUE'] . '</th>                    
                </tr>';
        }
        echo '</table></center>';
    }

    public function update_referral_partner() {
        $partner_list = $this->db->get('referral_partner')->result_array();
        if (!empty($partner_list)) {
            foreach ($partner_list as $il) {
                $update_data['assigned_to_userid'] = $this->lead_management->get_added_by_user_by_lead_id($il['partner_id']);
                $this->db->where('id', $il['id']);
                $this->db->update('referral_partner', $update_data);
            }
        }
    }

    public function add_old_action_staff() {
        $actions_id = $this->db->get('actions')->result_array();
        foreach ($actions_id as $id) {
            $action_id = $this->db->get_where('action_staffs', ['action_id' => $id['id']])->row();
            if (empty($action_id)) {
                $id = $id['id'];
                $result = $this->db->get_where('actions', ['id' => $id])->row();
                $department_id = $result->department;
                $office_id = $result->office;
                if ($department_id == 2) {
                    $office_staffs = $this->db->get_where('office_staff', ['office_id' => $office_id])->result_array();
                    if (!empty($office_staffs)) {
                        foreach ($office_staffs as $staffs) {
                            $action_staffs['staff_id'] = $staffs['staff_id'];
                            $action_staffs['action_id'] = $id;
                            $this->db->insert('action_staffs', $action_staffs);
                        }
                    }
                } else {
                    $department_staffs = $this->db->get_where('department_staff', ['department_id' => $department_id])->result_array();
                    if (!empty($department_staffs)) {
                        foreach ($department_staffs as $dept_staff) {
                            $actions_staff['action_id'] = $id;
                            $actions_staff['staff_id'] = $dept_staff['staff_id'];
                            $this->db->insert('action_staffs', $actions_staffs);
                        }
                    }
                }
            }
        }
    }

    public function project_recurrence_fix() {
        $list = $this->db->get_where("project_recurrence_main", ['pattern' => 'monthly'])->result_array();
        if (!empty($list)) {
            foreach ($list as $l) {
                $created_day = date('d', strtotime($l['created_at']));
                if ($created_day <= $l['actual_due_day']) {
                    $update_data['actual_due_month'] = date('m', strtotime($l['created_at']));
                    $this->db->where('id', $l['id']);
                    $this->db->update('project_recurrence_main', $update_data);
                }
            }
        }
    }

    public function duplicate_individual() {
        $res = $this->db->query('SELECT `company_id`, COUNT(`company_id`) FROM `title` WHERE status = 1 GROUP BY `company_id` HAVING COUNT(`company_id`) > 1')->result_array();
//        echo implode(',', (array_column($res, 'company_id')));
        $this->db->select("*");
        $this->db->from("individual ind");
        $this->db->join("title tit", "ind.id = tit.individual_id");
        $this->db->where_in("tit.company_id", array_column($res, 'company_id'));
        $this->db->where("ind.status", 1);
        $this->db->group_by("tit.company_id");
        $ind = $this->db->get()->result_array();
        foreach ($ind as $i) {
            $this->db->where_not_in("status", [0, 7]);
            $invoice_info = $this->db->get_where('invoice_info', ['type' => 2, 'reference_id' => $i['company_id']])->row_array();
            if (!empty($invoice_info))
                echo $invoice_info['id'] . ',';
        }
//        echo count($ind);
//        echo '<pre>';
//        print_r($ind);
//        echo '</pre>';
    }

    public function update_invoice_client_id() {
        $this->db->query('UPDATE `invoice_info` SET `client_id` = `reference_id`');
        $invoice_list = $this->db->get_where('invoice_info', ['type' => 2])->result_array();
        foreach ($invoice_list as $il) {
            $title_info = $this->db->get_where("title", ["company_id" => $il['reference_id'], "status" => 1])->row_array();
            if (!empty($title_info)) {
                $this->db->where('id', $il['id']);
                $this->db->update('invoice_info', ['client_id' => $title_info['individual_id']]);
            } else {
                echo $il['id'] . '<br>';
            }
        }
    }

    public function update_action_is_all_value() {
        $data = $this->db->query("SELECT adr.action_id,adr.is_all FROM action_assign_to_department_rel adr INNER JOIN actions a ON(a.id=adr.action_id)")->result_array();
        if (!empty($data)) {
            foreach ($data as $val) {
                $this->db->where('id', $val['action_id']);
                $this->db->update('actions', ['is_all' => $val['is_all']]);
            }
        }
    }

    public function update_practice_id() {
        $sql = "SELECT * FROM `internal_data` WHERE `practice_id`=''";
        $client_list = $this->db->query($sql)->result_array();
        foreach ($client_list as $key => $cl) {
//            if (trim($cl['practice_id']) == '') {   // this condition is removed for updating all client's practice_id update
                $reference_id = $cl['reference_id'];
                if ($cl['reference'] == 'individual') {
                    $details = $this->db->get_where('individual', ['id' => $reference_id])->row_array();
                    $name = trim($details['last_name']) . trim($details['first_name']);
                    if (empty($name)) {
                        $details = $this->db->get_where('company', ['company_id' => $reference_id])->row_array();
                        $name = strtoupper(str_replace(' ', '', trim($details['name'])));
                        $c = preg_replace("/[^a-zA-Z0-9]/", "", $name);
                        $practice_id = substr($c, 0, 11);                            
                    }
                    $name = strtoupper(str_replace(' ', '', $name));
                    $c = preg_replace("/[^a-zA-Z0-9]/", "", $name);
                    $practice_id = substr($c, 0, 11);

                } elseif ($cl['reference'] == 'company') {
                    $details = $this->db->get_where('company', ['id' => $reference_id])->row_array();
                    $name = strtoupper(str_replace(' ', '', trim($details['name'])));
                    $c = preg_replace("/[^a-zA-Z0-9]/", "", $name);
                    $practice_id = substr($c, 0, 11);
                }

                $update_data['practice_id'] = $practice_id;
                $this->db->where('id', $cl['id']);
                $this->db->update('internal_data', $update_data);
//            }  //end practice_id blank checking   
        } //end foreach
        echo "success";
    }

    public function update_service_request_department() {
        $service_request_list = $this->db->get('service_request')->result_array();
        foreach ($service_request_list as $srl) {
            $result = $this->db->get_where('services', ['id' => $srl['services_id']])->row_array();
            if (!empty($result)) {
                $this->db->where('id', $srl['id']);
                $this->db->update('service_request', ['responsible_department' => $result['dept']]);
            }
        }
    }

    public function project_due_date_generation_date_fix() {
        $data = $this->db->get('project_recurrence_main')->result_array();
        //print_r($data); exit;
        if (!empty($data)) {
            foreach ($data as $val) {
                $due_date = $val['actual_due_year'] . '-' . $val['actual_due_month'] . '-' . $val['actual_due_day'];

                if ($val['generation_month'] == '') {
                    $val['generation_month'] = '0';
                }

                if ($val['generation_day'] == '') {
                    $val['generation_day'] = '0';
                }

                $update_data['due_date'] = $due_date;

                if ($val['pattern'] == 'monthly') {
                    $next_due_date = date("Y-m-d", strtotime("+1 month", strtotime($due_date)));
                    $update_data['next_due_date'] = $next_due_date;
                } elseif ($val['pattern'] == 'annually') {
                    $next_due_date = date("Y-m-d", strtotime("+1 year", strtotime($due_date)));
                    $update_data['next_due_date'] = $next_due_date;
                } elseif ($val['pattern'] == 'weekly') {
                    $next_due_date = date("Y-m-d", strtotime("+7 days", strtotime($due_date)));
                    $update_data['next_due_date'] = $next_due_date;
                } elseif ($val['pattern'] == 'quarterly') {
                    $next_due_date = date("Y-m-d", strtotime("+3 months", strtotime($due_date)));
                    $update_data['next_due_date'] = $next_due_date;
                } else {
                    $update_data['next_due_date'] = '0000-00-00';
                }
                if ($val['generation_type'] == 1) {
                    $generation_days = ((int) $val['generation_month'] * 30) + (int) $val['generation_day'];

                    $generation_date = date('Y-m-d', strtotime('-' . $generation_days . ' days', strtotime($update_data['next_due_date'])));
                    $update_data['generation_date'] = $generation_date;
                }
                $this->db->where('id', $val['id']);
                $this->db->update('project_recurrence_main', $update_data);
            }
        }
    }

    public function remove_non_input_form_invoice_orders() {
        $this->db->where(['is_order' => 'y', 'order_id!=' => 0]);
        $invoice_list = $this->db->get('invoice_info')->result_array();
        $order_id_array = [];
        foreach ($invoice_list as $il) {
            $this->db->select('id');
            $order_id_list = $this->db->get_where('order', ['invoice_id' => $il['id']])->result_array();
            $order_ids = array_column($order_id_list, 'id');
            if (empty($order_ids)) {
                continue;
            }
            $this->db->select('service_request.services_id');
            $this->db->where_in('order_id', $order_ids);
            $service_request_info = $this->db->get('service_request')->result_array();

            $this->db->where_in('service_id', array_column($service_request_info, 'services_id'));
            $this->db->where(['input_form' => 'y']);
            $target_days = $this->db->get('target_days')->result_array();
            if (empty($target_days)) {  //check input-form exist or not 
                $this->db->where('id', $il['id']);
                $this->db->update('invoice_info', ['is_order' => 'n', 'order_id' => 0]);
                $this->db->where('id', $il['order_id']);
                $this->db->update('order', ['status' => '7', 'late_status' => '0']);
                $order_id_array[] = $il['order_id'];
            }
        }
        echo implode(', ', $order_id_array) . ' orders has been canceled';
    }
    public function remove_old_mail_campaign() {
        $lead_mail_data = $this->db->get('lead_mail_chain')->result_array();
        foreach ($lead_mail_data as $lmd) {
            if ($lmd['lead_type'] == '0') {
                $this->db->where('lead_type', '0');
                $this->db->delete('lead_mail_chain');
            }
        }
        echo "Old Mail Campaign Data's are Successfully Removed";
    }

    public function import_royalty_reports_data() {
        $staff_info = staff_info();
        $staff_id = $staff_info['id'];
        $staffrole = $staff_info['role'];
        $staff_office = $staff_info['office'];
        $departments = explode(',', $staff_info['department']);
        $this->db->query('TRUNCATE royalty_report');
        $select = [
            'inv.id as invoice_id',
            'inv.reference_id as reference_id',
            'inv.order_id as order_id',
            'inv.new_existing as new_existing',
            'inv.created_time as created_time',
            'srv.price_charged as override_price',
            'srv.services_id as service_id',
            'inv.existing_reference_id as existing_reference_id',
            'inv.type as invoice_type',
            'inv.is_order as is_order',
            'inv.created_by AS created_by',
            'inv.payment_status AS payment_status',
            'inv.total_amount AS sub_total',
            'inv.client_id as client_id',
            'indt.practice_id as practice_id',
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
            '(SELECT CONCAT(",",GROUP_CONCAT(`service_id`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_services',
            '(SELECT CONCAT(",",GROUP_CONCAT(`id`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_orders',
            '(SELECT CONCAT(",",GROUP_CONCAT(`total_of_order`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_services_override',
            // '(CASE WHEN ord.quantity = 0 THEN (SELECT SUM(srv.price_charged) FROM `order` WHERE `ord`.`id` = `srv`.`order_id`) ELSE (SELECT SUM(srv.price_charged*ord.quantity) FROM `order` WHERE `ord`.`id` = `srv`.`order_id`) END) as all_services_override',
            '(SELECT CONCAT(",",GROUP_CONCAT(`payment_type`), ",") FROM `payment_history` WHERE `invoice_id` = ord.invoice_id AND `order_id` = ord.id) AS payment_types',
            '(SELECT SUM(pay_amount) FROM payment_history WHERE payment_history.type = \'payment\' AND payment_history.invoice_id = inv.id AND payment_history.is_cancel = 0) AS pay_amount',
        ];
        $where['ord.reference'] = '`ord`.`reference` = \'invoice\' ';
        $where['status'] = 'AND `inv`.`status` != 0 ';

        if (in_array(2, $departments)) {
            if ($staffrole == 2) {      // frinchisee manager
                $where['indt.office'] = 'AND `indt`.`office` IN (' . $staff_office . ') ';
            } else {
                $where['inv.created_by'] = 'AND `inv`.`created_by` = "' . $staff_id . '" ';
            }
        } else {
            $where_or = 'OR (`inv`.`created_by` = "' . $staff_id . '" AND `inv`.`status` NOT IN (7)) ';
        }

        $table = '`invoice_info` AS `inv` ' .
                'INNER JOIN `order` AS `ord` ON `ord`.`invoice_id` = `inv`.`id` ' .
                'INNER JOIN `internal_data` AS `indt` ON (CASE WHEN `inv`.`type` = 1 THEN `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "company" ELSE `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "individual" END)'.
                'INNER JOIN `service_request` AS `srv` ON `srv`.`order_id` = `inv`.`order_id`'. 
                'INNER JOIN `payment_history` AS `pyh` ON `pyh`.`invoice_id` = `inv`.`id`';

        $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . 'WHERE ' . implode('', $where) . (isset($where_or) ? $where_or : '') . ' GROUP BY `ord`.`invoice_id`';
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $royalty_reports_data = $this->db->query($query)->result_array();

        if (!empty($royalty_reports_data)) {
            foreach ($royalty_reports_data as $rpd) { 
                for($i=1; $i <= $rpd['services']; $i++) {
                    $service_detail = get_service_by_id(explode(',',$rpd['all_services'])[$i]);
                    $office_fees = get_office_fees_by_service(explode(',',$rpd['all_services'])[$i],$rpd['office_id']);
                    $payment_history = get_payment_details_service_id($rpd['invoice_id'],explode(',',$rpd['all_orders'])[$i]);
                    $reference = implode(',',array_column($payment_history,'reference'));
                    $authorization_id = implode(',',array_column($payment_history,'authorization_id'));
                    $payment_type = implode(',',array_column($payment_history,'payment_type'));
                    $collected = array_sum(array_column($payment_history,'collected'));    
                    $total_net = (explode(',',$rpd['all_services_override'])[$i] != '') ? explode(',',$rpd['all_services_override'])[$i] - $service_detail['cost'] : $service_detail['retail_price'] - $service_detail['cost'];
                    $override_price = explode(',',$rpd['all_services_override'])[$i];
                    $date_val = date('Y-m-d', strtotime($rpd['created_time']));
                    $fee_with_cost = (($total_net * $office_fees)/100);                    
                    $fee_without_cost = (($override_price * $office_fees)/100);
                    if (($override_price - $collected) == 0) {
                        $payment_status = 'Paid';
                    } elseif (($override_price - $collected) == $override_price) {
                        $payment_status = 'Unpaid';
                    } elseif (($override_price - $collected) > 0 && ($override_price - $collected) < $override_price) {
                        $payment_status = 'Partial';
                    } else {
                        $payment_status = 'Late';
                    }

                    $data = array(
                        "date" => $date_val,
                        "client_id" => $rpd['practice_id'],
                        "invoice_id" => $rpd['invoice_id'],
                        "service_id" => $rpd['invoice_id']."-".$i,
                        "service_name" => $service_detail['description'],
                        "retail_price" => $service_detail['retail_price'],
                        "override_price" => $override_price,
                        "cost" => $service_detail['cost'],
                        "payment_status" => $payment_status,
                        "collected" => $collected.".00",
                        "payment_type" => ($payment_type != '') ? $payment_type:"N/A",
                        "authorization_id" => ($authorization_id != '') ? $authorization_id: "N/A",
                        "reference" => ($reference != '') ? $reference : "N/A",
                        "total_net" => $total_net.'.00',
                        "office_fee" => ($office_fees != '') ? $office_fees : '00.00',
                        "fee_with_cost" => $fee_with_cost.'.00',
                        "fee_without_cost" => $fee_without_cost.'.00',
                        "office_id" => $rpd['office_id'],
                        "created_by" => $rpd['created_by']
                    );
                    $this->db->insert('royalty_report',$data);
                } 
            }
            // $total_data = $this->db->get('royalty_report')->result_array();
            // $total_arr = array(
            //     "invoice_id" => count($total_data)-1,
            //     "retail_price" => array_sum(array_column($total_data,'retail_price')),
            //     "cost" => array_sum(array_column($total_data,'cost')),
            //     "collected" => array_sum(array_column($total_data,'collected')),
            //     "total_net" => array_sum(array_column($total_data,'total_net')),
            //     "override_price" => array_sum(array_column($total_data,'override_price')),
            //     "fee_with_cost" => array_sum(array_column($total_data,'fee_with_cost')),
            //     "fee_without_cost" => array_sum(array_column($total_data,'fee_without_cost'))

            // );
            // $this->db->where('id',1);
            // $this->db->update('royalty_report',$total_arr);
            echo "Successfully Inserted";
        } else {
            $data = array();
        }
    }
    function update_project_due_date(){
        $ids=$this->db->query("SELECT id FROM project_recurrence_main WHERE created_at LIKE '%2019-12-06%'")->result_array();
        foreach($ids as $id){
            $this->db->set('due_date', '2019-12-19');
            $this->db->set('actual_due_year', 2019);
            $this->db->set('next_due_date','2020-01-19');
            $this->db->set('generation_date','2020-01-01');
            $this->db->where_in('id',$id);
            $this->db->update('project_recurrence_main');
        }
    }

    public function update_added_by_user_action_notes() {
        $added_by_user_ids = $this->db->get('action_notes')->result_array();
        foreach ($added_by_user_ids as $val) {
            if ($val['added_by_user'] == 0) {
                $action_added_by = $this->db->get_where('actions',array('id'=>$val['action_id']))->row_array()['added_by_user'];
                $data = array('added_by_user' => $action_added_by);
                $this->db->where('action_id',$val['action_id']);
                $this->db->where('added_by_user','0');
                $this->db->update('action_notes',$data);
            }
        }
        echo "Successfully Updated";
    }

    public function update_quantity_for_same_service() {
        $order_data = $this->db->get('order')->result_array();

        foreach ($order_data as $od) {
            $this->db->where('order_id',$od['id']);
            $this->db->where('services_id',$od['service_id']);
            $service_request_data = $this->db->get('service_request')->num_rows();

            if ($service_request_data > 1) {
                // echo "<pre>";
                $this->db->where('order_id',$od['id']);
                $this->db->where('services_id',$od['service_id']);
                $service_request_data_inner = $this->db->get('service_request')->result_array();

                // print_r($service_request_data_inner);
                $id_arr = array_column($service_request_data_inner,'id');
                $price_charged = array_sum(array_column($service_request_data_inner,'price_charged'));
                $status_arr = array_column($service_request_data_inner,'status');
                $data = array(
                    'quantity' => $service_request_data,
                    'price_charged' => $price_charged
                );
                $this->db->where('id',$id_arr[0]);
                $this->db->update('service_request',$data);

                for ($i=1; $i < count($id_arr) ; $i++) { 
                    $this->db->where('id',$id_arr[$i]);
                    $this->db->delete('service_request');    
                }
            }
        }
        echo "Successfully Updated";
    }

    public function update_clients() {
        $client_id_arr = Array(
            '3GPASSETMAN','3GPASSETMFL','4147CLOCKTO','4710SLEEPYM','8965RHODESS','ADVANCERINV','AGNINVESTME','AGOSTINHOJE','AJSUNINVEST','ALVESCHRIST','ALVESLUIZ','AMARASSED','AMERICANSTA','ANDRADEPONT','ARCHINADELG','ARCHINAROBE','ARDITTIGUST','ARDITTIMARI','ARNTINVESTM','ARNTPAULORO','ASSEDMARTIN','BAENAROBERT','BAPTISTALUI','BARBOSALUCA','BARBOSAMARC','BARBOZAISAB','BARBOZAVITO','BARROSOJULI','BERGERRAQUE','BIOELEVENLL','BLUEBIRDASS','BONINIFABIA','BOUNCEINPLA','BRIGHOUSING','BRUMDOMINIK','BRUNOMAURIN','BRUXELJOAOG','BTEGINVESTM','BUENOANGELA','BUENOCAUAN','CADOCARINE','CALVOANTONI','CANFIELDBRA','CANFIELDINV','CAPELATEROS','CARVALHOCAI','CASAFORTINV','CCD4LLC','CELLISINVES','CELLISUSASE','CHRISPILLC','CHRISTESFLA','CMHOUSEVACA','CORREAOGIHA','COUSSEAUAIR','COUSSEAUINV','COUSSEAUSAL','CRUZMAIASOL','CUNHAASSETS','CXCOMPANYIN','CYRINOADRIA','DAOUFILHOJO','DAOUNETOJOS','DAOUSOPHIEM','DASILVABRUN','DASILVAMARC','DEALMEIDAIN','DEALMEIDARO','DEALMEIDAVE','DEALMEIDAWA','DEANDRADEFR','DEARAUJORAM','DEBARROSAGN','DEFREITASEL','DEFREITASPA','DEMACENAJAN','DEMATTOSFIL','DEMELLONEY','DEMELOJOSE','DEMOURAALBE','DEOLIVEIRAL','DESOUSATERE','DESOUZARODR','DESOUZAVIRG','DGBREALTYLL','DGG72LLC','DGUSASOLUTI','DIASMARA','DIEGOESTEVE','DIOGOESTEVE','DMPCONSULTI','DOLINEDECI','DOSSANTOSWA','DREAMHOMEIN','DREAMHOMERE','DRIM','DRIMFRANCHI','DRIMHOLDING','ECUAHOMELLC','ENLACCIINVE','ESTEVES8400','ESTEVESDIEG','ESTEVESHUMB','ESTRELLAROD','FAMILYSPROP','FARIASABRIN','FARIASLUCIO','FELTRIMEBER','FERRAZFABIA','FERRAZINVES','FERRAZPAULA','FERRAZPROPE','FERREIRAANT','FERREIRADAR','FERREIRAPAU','FERREIRATHI','FFREALESTAT','FIGUEIROFLA','FIVESTARSAP','FJLASSETSLL','FLORIDANEWS','FONTANAPABL','FRANCOALESS','FRANZENJOSE','GARCIACGABR','GEMINI313LL','GENTILIDANI','GOLDENHILLS','GOMESANAP','GOMESANDREA','GONCALVESRE','GOUVEAROBER','GOUVEIANILS','GPMPARTICIP','GUEDESGEORG','GUISANDEKAR','HAYASHIFABI','HAYECKFABRI','HELEBRANDOR','HIGASHIMAGD','HIGASHIOSMA','HOPEBLESSLL','HUMBERTOEST','IGNACIOALBE','IKONIKBYDRI','INGLADAMARI','ITOERIKAIGN','JAMJSTOREYL','JLCCAINVEST','JOINTECHLLC','K2INTERIOR','KALFELZMART','KARAGULIANJ','KFURIELIZAB','KIMIOLEONAR','KINGFUZZLLC','KLEFENZGABR','KLEFENZMARI','KLEFENZRAFA','KURAHASHICA','KURAHASHIGR','KURAHASHIMI','KURAHASHITI','LANGONIRAFA','LARAFABRICI','LCKHOMELLC','LEANDRODIOG','LECHIVVINIC','LEFARDONLLC','LEITEDAOUBR','LEITEFERNAN','LEMOSANA','LENGSFELDMO','LGRHOMELLC','LMASSETS','LMVIANALLC','LOIOLAINVES','LOPESJOAOTA','LOPESLOURIV','LOROMADEIRA','LOURENCOBAR','LUAINVESTME','LUCHINIANDR','LUCIDELIFAB','MACEDOREIS','MADUREIRAPA','MAHOGANYFLO','MAIAOSSIRES','MAIARAFAEL','MANRUBIOSAM','MANSANOMARC','MARCALFABIO','MARCONETTIE','MARCRISTINV','MARINHOLIAN','MARINHORENA','MARQUESPATR','MARRONIRITA','MARTINICHEN','MASCAGNIMAR','MASCHIOEDLA','MATOGARRAIN','MATSUOADRIA','MATTOSBRUNO','MATTOSOCARM','MATUCKJULIA','MAUROPIRES','MAYERHOFERT','MEIRARAFAEL','MELLFINCORP','MEROLEFLORI','MIRANDASERG','MKTBYDRIMLL','MMLASSETSLL','MORAESROMER','MOUSTAFAAHM','NASCIMCESAR','NASCIMRONAL','NAZARETHFEL','NEVESCATIAD','NEVESSAMUEL','OHPARPROPER','OLIVEIRAELI','OLIVEIRAFER','OLIVEIRAJAO','OLIVEIRAREI','OMNIUSAREAL','OTACITOTORR','PACHECOSIMO','PACIFICRENT','PADRAOGLEYC','PADRAOMARCI','PADRAOMARIA','PALEARIANDR','PALEARIFABI','PALEARIRONA','PAZ3387','PELEGRINIRA','PEREIRAGUIO','PEREIRANELS','PIRESLUIZMA','PISSONILUIZ','PLACEHOLDIN','PLACELOGIST','PONTARAKATI','POZASVICTOR','PROVENSIDAN','PSMFHOLDING','PUIGALESSAN','QUINTANADEN','RAJUREALEST','RAMMGLOBALL','RAMOSPE3865','RAMOSVIVIAN','RAMOSWILLIA','RANGELGLAUB','RANGELUSASE','RARDIINVEST','RBSEGAINVES','RCUSALLC','REGISSANDRA','REISEDUARDO','RHDASSETSLL','RIBEIROLEAN','RICCIGUSTAV','ROCCOASSETS','ROLIMROBERT','ROMEROIVANA','ROSSETTIELI','RPARNTINVES','SADOVSKIINV','SADOVSKIJEF','SALGUEROANT','SALIMARIA','SANCHESPERE','SANDECINVES','SANDEXINVES','SANTICRISTI','SANTIMARCIA','SANTOSJOILS','SANTOSRODRI','SCARONIANAR','SCBVASSETSL','SCHLOESSER','SEGARENATO','SEVENREALTY','SILVABRUXEL','SILVASANDRA','SILVEIRALEA','SISASSETS','SLOBODAGUST','SOUZALETICI','SPINDLERMAR','STRONGHIVE','STRONGHOLDI','SZEREMETADO','TIGREFERNAN','TOLEDOTHIAG','TPAGLIARBER','ULRYCHCHARL','USPHERIAUSA','VAGLEARNSTE','VAGLEMADHAV','VASCOALINE','VELOZMARIEL','VERBISKILIN','VIANAMARCEL','VICENTEANDR','VICENTEVINI','VIEIRARICAR','VILLAVAGLEL','VILLELAFABI','VINCPOLLUSA','WINTERPARKP','WQUATROLLC','XAVIERALEXA','YAMADAALESA','YAMADAINVES','ZAIDANLUIZA','ZAMBONATORO','ZIPOLIMARIA','ZUNINOGABRI'
        );

        $internal_datas = $this->db->get('internal_data')->result_array();
        foreach ($internal_datas as $val) {
            if (in_array($val['practice_id'],$client_id_arr)) {
                $update_arr = array(
                    'office' => '44',
                    'partner' => '536',
                    'manager' => '536'
                );

                $this->db->where('practice_id',$val['practice_id']);
                $this->db->update('internal_data',$update_arr);
                echo "Success";
                echo "<hr>";
            }
        }
    }
    public function update_financial_account(){
        $order_id=$this->db->get('financial_accounts')->result_array();
        if(!empty($order_id)){
            foreach($order_id as $val){
                $o_id=$val['order_id'];
                if(!empty($o_id) && $o_id!=0){
                    $client_id=$this->db->get_where('order',['id'=>$val['order_id']])->row()->reference_id;
                    if(!empty($client_id)){
                        $this->db->where('order_id',$val['order_id']);
                        $this->db->update('financial_accounts',['client_id'=>$client_id]);
                    }
                }
            }
        }
    }
}
    