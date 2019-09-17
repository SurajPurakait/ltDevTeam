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

}
