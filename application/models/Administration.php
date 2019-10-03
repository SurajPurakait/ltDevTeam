<?php

class Administration extends CI_Model {

    public function get_all_departments($type_array = []) {
        if (!empty($type_array) && count($type_array) != 0) {
            $this->db->where_in('type', $type_array);
        }
        return $this->db->get("department")->result_array();
    }

    public function get_department_by_id($department_id) {
        $this->db->order_by('name', 'ASC');
        return $this->db->get_where("department", ['id' => $department_id])->row_array();
    }

    public function get_department_staffs_by_id($department_id) {
        $this->db->select("st.id AS staff_id, ds.department_id AS department_id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) as staff_name");
        $this->db->from('department_staff AS ds');
        $this->db->join('staff AS st', 'st.id = ds.staff_id');
        $this->db->where(['ds.department_id' => $department_id]);
        return $this->db->get()->result_array();
    }

    public function get_selected_manager_by_id($department_id) {
        return $this->db->get_where("department_manager", ['department_id' => $department_id])->row_array();
    }

    public function update_departments($data) {
        $department_id = $data['id'];
        //$manager_id = $data['deptmngr'];
        //$manager_data = $this->db->query("select * from staff where id='" . $manager_id . "'")->row_array();

        unset($data['id']);
        //unset($data['deptmngr']);
        // if (isset($manager_id) && $manager_id != '' && $manager_id != '0') {
        //     $this->db->set(["role" => '4'])->where("id", $manager_id)->update("staff");
        // } else {
        //     $this->db->set(["role" => '3'])->where("id", $manager_id)->update("staff");
        // }
        // $check_if_dept_manager_exists = $this->db->query("select * from department_manager where department_id='" . $department_id . "'")->row_array();
        // if (!empty($check_if_dept_manager_exists)) {
        //     if (isset($manager_id) && $manager_id != '' && $manager_id != '0') {
        //         $this->db->query("UPDATE `department_manager` SET `manager_id` = '" . $manager_id . "' WHERE department_id = '" . $department_id . "'");
        //     }
        // } else {
        //     if (isset($manager_id) && $manager_id != '' && $manager_id != '0') {
        //         $this->db->query("INSERT INTO `department_manager` (`id`, `department_id`, `manager_id`) VALUES ('', '" . $department_id . "', '" . $manager_id . "')");
        //     }
        // }
        //$data['manager_fname'] = $manager_data['first_name'];
        //$data['manager_lname'] = $manager_data['last_name'];
        $this->db->where("id", $department_id);
        return $this->db->update("department", $data);
    }

    public function insert_departments($data) {
        $insert_data = array(
            'id' => '',
            'type' => 3,
            'name' => $data['name'],
            'phone' => $data['phone'],
            'extension' => $data['extension'],
            'email' => $data['email']
        );
        return $this->db->insert("department", $insert_data);
    }

    public function get_all_office() {
        $this->db->order_by('name', 'ASC');
        return $this->db->get_where('office', ['status' => 1])->result_array();
    }

    public function get_all_dept() {
        $this->db->order_by('name', 'ASC');
        $this->db->where_not_in('id', array(1, 2));
        return $this->db->get('department')->result_array();
    }

    public function get_all_office_admin() {
        return $this->db->get_where('office', ['status' => 1, 'type' => 1])->result_array();
    }

    public function get_all_office_type() {
        return $this->db->get('office_type')->result_array();
    }

    public function get_office_type_by_id($office_type_id) {
        return $this->db->get_where("office_type", ["id" => $office_type_id])->row_array();
    }

    public function get_office_list_by_type($office_type_id) {
        return $this->db->get_where("office", ["type" => $office_type_id])->result_array();
    }

    public function get_office_by_id($office_id) {
        $this->db->select('office.*, (SELECT state_name FROM states WHERE id = office.state) AS state_name');
        return $this->db->get_where('office', ["id" => $office_id])->row_array();
    }

    public function get_office_list_by_name_like($office_name) {
        $this->db->like('name', $office_name, 'both');
        $this->db->where('status', 1);
        return $this->db->get("office")->result_array();
    }

    public function insert_franchise($data) {
        return $this->db->insert('office', $data);
    }

    public function update_franchise($data) {
        $franchise_id = $data['id'];
        unset($data['id']);
        $this->db->where("id", $franchise_id);
        return $this->db->update("office", $data);
    }

    public function delete_franchise($franchise_id) {
        $this->db->delete('office_staff', ['office_id' => $id]);
        $this->db->where("id", $franchise_id);
        return $this->db->update("office", ['status' => 2]);
    }

    public function check_departmentg_delete($department_id) {
        $return = true;
        if ($this->get_actions_by_department_id($department_id) > 0) {
            $return = false;
        }
        return $return;
    }

    public function get_actions_by_department_id($department_id) {
        return $this->db->get_where('actions', ["department" => $department_id])->num_rows();
    }

    public function get_all_staff() {
        return $this->db->get("staff")->result_array();
    }

    public function get_staff_type_by_id($staff_type_id) {
        return $this->db->get_where("staff_type", ["id" => $staff_type_id])->row_array();
    }

    public function get_all_staff_type() {
        return $this->db->get('staff_type')->result_array();
    }

    public function get_staff_by_id($staff_id) {
        return $this->db->get_where('staff', ["id" => $staff_id])->row_array();
    }

    public function get_all_admin_staffs_id() {
        $result = $this->db->get_where('staff', ["type" => 1])->result_array();
        if (!empty($result)) {
            return array_column($result, 'id');
        } else {
            return [];
        }
    }

    public function get_office_staff_by_office_id_staff_id($staff_id, $office_id) {
        return $this->db->get_where("office_staff", ["office_id" => $office_id, "staff_id" => $staff_id])->row_array();
    }

    public function get_department_staff_by_department_id_staff_id($staff_id, $department_id) {
        return $this->db->get_where("department_staff", ["department_id" => $department_id, "staff_id" => $staff_id])->row_array();
    }

    public function insert_staff($data) {
        if ($data['type'] == 1) {
            $department_data['department_id'] = [1];
            $data['role'] = 0;
        }
        if ($data['type'] == 2) {
            if (isset($data['staff_role'])) {
                $data['role'] = 4;
            } else {
                $data['role'] = 3;
            }
        }
        if ($data['type'] == 3) {
            if (isset($data['staff_role'])) {
                $data['role'] = 2;
            } else {
                $data['role'] = 1;
            }
            $department_data['department_id'] = [2];
        }

        $office_data = $data['office'];
        $department_data = $data['department'];
        $dob = strtr($data['birth_date'], '/', '-');
        $data['birth_date'] = date('Y-m-d', strtotime($dob));
        if (isset($data['ssn_itin']) && $data['ssn_itin'] != '') {
            $data['ssn_itin'] = str_replace("-", "", $data['ssn_itin']);
        } else {
            $data['ssn_itin'] = '';
        }

        unset($data['office']);
        unset($data['department']);
        unset($data['staff_role']);
        $data['password'] = md5($data['password']);
        $data['date'] = date('Y-m-d');
        $this->db->trans_begin();
        $this->db->insert('staff', $data);
        $staff_id = $this->db->insert_id();

        foreach ($department_data as $department_id) {
            $this->db->insert('department_staff', ['staff_id' => $staff_id, 'department_id' => $department_id]);
        }

        foreach ($office_data as $office_id) {
            $this->db->insert('office_staff', ['staff_id' => $staff_id, 'office_id' => $office_id]);
        }
        if ($data['type'] == 2) {
            $this->db->select('*');
            $this->db->from('actions act');
            $this->db->where_in('department', $department_data);
            $this->db->where(['act.office' => $office_data[0], 'act.is_all' => 1]);
            $action_details = $this->db->get()->result_array();
            if (count($action_details) != 0) {
                foreach ($action_details as $action) {
                    $data = array('action_id' => $action['id'], 'staff_id' => $staff_id);
                    $this->db->insert('action_staffs', $data);
                }
            }
        } else {
            $this->db->where_in('department', $department_data);
            $this->db->where('is_all', 1);
            $action_details = $this->db->get('actions')->result_array();
            if ($data['type'] != 3) {
                if (count($action_details) != 0) {
                    foreach ($action_details as $action) {
                        $data = array('action_id' => $action['id'], 'staff_id' => $staff_id);
                        $this->db->insert('action_staffs', $data);
                    }
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_staff($data) {
        if ($data['type'] == 1) {
            $department_data['department_id'] = [1];
            $data['role'] = 0;
        }
        if ($data['type'] == 2) {
            if (isset($data['staff_role'])) {
                $data['role'] = 4;
            } else {
                $data['role'] = 3;
            }
        }
        if ($data['type'] == 3) {
            if (isset($data['staff_role'])) {
                $data['role'] = 2;
            } else {
                $data['role'] = 1;
            }
            $department_data['department_id'] = [2];
        }
        unset($data['retype_password']);
        if ($data['password'] == "***********") {
            unset($data['password']);
        } else {
            $data['date'] = date('Y-m-d');
            $data['password'] = md5($data['password']);
        }

        $dob = strtr($data['birth_date'], '/', '-');
        $data['birth_date'] = date('Y-m-d', strtotime($dob));

        if (isset($data['ssn_itin']) && $data['ssn_itin'] != '') {
            $data['ssn_itin'] = str_replace("-", "", $data['ssn_itin']);
        } else {
            $data['ssn_itin'] = '';
        }

        $staff_id = $data['id'];
        $office_data = $data['office'];
        $department_data = $data['department'];
        unset($data['hidpwd']);
        unset($data['id']);
        unset($data['office']);
        unset($data['department']);
        unset($data['staff_role']);

        $this->db->trans_begin();
        $this->db->delete('department_staff', ['staff_id' => $staff_id]);

        foreach ($department_data as $department_id) {
            $this->db->insert('department_staff', ['staff_id' => $staff_id, 'department_id' => $department_id]);
        }

        $this->db->delete('office_staff', ['staff_id' => $staff_id]);

        foreach ($office_data as $office_id) {
            $this->db->insert('office_staff', ['staff_id' => $staff_id, 'office_id' => $office_id]);
        }

        $this->db->where(['id' => $staff_id]);
        $this->db->update('staff', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_office_by_staff_id($staff_id) {
        $this->db->select('ofc.name, ofc.id, ofc.office_id');
        $this->db->from('office_staff ofcst');
        $this->db->join('office ofc', 'ofcst.office_id = ofc.id');
        $this->db->where('ofcst.staff_id', $staff_id);
        $this->db->order_by('ofc.name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_department_by_staff_id($staff_id) {
        $this->db->select('dp.name, dp.id');
        $this->db->from('department_staff dpst');
        $this->db->join('department dp', 'dpst.department_id = dp.id');
        $this->db->where('dpst.staff_id', $staff_id);
        return $this->db->get()->result_array();
    }

    public function get_offices_staffwise($staff_type) {
        if ($staff_type == '1' || $staff_type == '2') {
            $this->db->where(['type' => 1]);
        } else {
            $this->db->where(['type' => 2]);
        }
        return $this->db->get("office")->result_array();
    }

    public function get_department_staffwise($staff_type) {
        if ($staff_type == '1') {
            $this->db->where(['type' => 1]);
        } elseif ($staff_type == '3') {
            $this->db->where(['type' => 2]);
        } elseif ($staff_type == '2') {
            $this->db->where(['type' => 3]);
        }
        return $this->db->get("department")->result_array();
    }

    public function get_service_list() {
        $sql = "select s.*,(select name from category where id=s.category_id) AS catname,td.start_days,td.end_days,d.name "
                . "from services s "
                . "inner join target_days td on(s.id=td.service_id) "
                . "inner join department d on(d.id=s.dept)"
                . "where status = 1 group by s.id order by s.description asc";

        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function get_service_fees_list($edit_id) {
        $this->db->select('*');
        $this->db->from('office_service_fees');
        $this->db->where('office_id', $edit_id);
        return $this->db->get()->result_array();
    }

    public function get_service_fees($office_id, $service_id) {
        return $this->db->get_where('office_service_fees', ['office_id' => $office_id, 'service_id' => $service_id])->row_array();
    }

    public function insert_service_fees($data) {
        if (!empty($data['service']) && !empty($data['percentage']) && $data['franchise_office_id'] != '') {
            foreach ($data['service'] as $key => $val) {
                $array_service[$key] = array(
                    'service_id' => $val,
                    'office_id' => $data['franchise_office_id'],
                    'percentage' => $data['percentage'][$key]
                );
            }
            $this->db->delete('office_service_fees', ['office_id' => $data['franchise_office_id']]);
            return $this->db->insert_batch('office_service_fees', $array_service);
        }
        // print_r($array_service);exit; 
    }

    public function get_all_categories() {
        return $this->db->get("category")->result_array();
    }

    public function get_related_services($id) {
        return $this->db->get_where("services", ["category_id" => $id])->result_array();
    }

    public function get_related_services_without_catwise($id = '') {
        $sql = "select * from services";
        if ($id != '') {
            $sql .= " where id!=" . $id . "";
        }
        return $this->db->query($sql)->result_array();
    }

    public function check_if_name_exists($servicename, $rowid = null) {
        $sql = "select * from services where description='$servicename'";
        if ($rowid != null) {
            $sql .= ' AND id!=' . $rowid;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function add_related_services($servicename, $retailprice, $servicecat, $relatedserv, $startdays, $enddays, $dept, $input_form, $shortcode, $note, $fixedcost) {
        $this->db->trans_begin();

        $insert_data = array('id' => '',
            'category_id' => $servicecat,
            'description' => $servicename,
            'ideas' => $shortcode,
            'tutorials' => 'NULL',
            'fixed_cost' => $fixedcost . '.00',
            'retail_price' => $retailprice . '.00',
            'dept' => $dept,
            'status' => 1,
            'note' => $note
        );
        $this->db->insert('services', $insert_data);
        $insert_id = $this->db->insert_id();

        $insval = array('id' => '',
            'service_id' => $insert_id,
            'service_name' => $servicename,
            'start_days' => $startdays,
            'end_days' => $enddays,
            'category_id' => $servicecat,
            'input_form' => $input_form
        );
        $this->db->insert('target_days', $insval);

        foreach ($relatedserv as $val) {
            $indata = array('id' => '',
                'services_id' => $insert_id,
                'related_services_id' => $val
            );
            $this->db->insert('related_services', $indata);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function update_related_services($service_id, $servicename, $retailprice, $servicecat, $relatedserv, $startdays, $enddays, $dept, $input_form, $shortcode, $note, $fixedcost) {
        $this->db->trans_begin();

        $update_data = array('category_id' => $servicecat,
            'description' => $servicename,
            'ideas' => $shortcode,
            'tutorials' => 'NULL',
            'fixed_cost' => $fixedcost . '.00',
            'retail_price' => $retailprice . '.00',
            'dept' => $dept,
            'status' => 1,
            'note' => $note
        );
        $this->db->set($update_data)->where("id", $service_id)->update("services");

        $update_data = array('service_name' => $servicename,
            'start_days' => $startdays,
            'end_days' => $enddays,
            'category_id' => $servicecat,
            'input_form' => $input_form
        );
        $this->db->set($update_data)->where("service_id", $service_id)->update("target_days");

        $this->db->where("services_id", $service_id)->delete("related_services");

        foreach ($relatedserv as $val) {
            $indata = array('id' => '',
                'services_id' => $service_id,
                'related_services_id' => $val
            );
            $this->db->insert('related_services', $indata);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function get_service_by_id($id) {
        $sql = "select s.id as id, s.description as servicename,s.note,s.fixed_cost as fixedcost,s.retail_price as price, s.category_id as catid, t.start_days, t.end_days, t.input_form, s.dept as department, s.ideas, group_concat(r.related_services_id) as related_services from services as s inner join target_days as t on t.service_id = s.id inner join related_services as r on r.services_id = s.id where s.id = '$id'";
        return $this->db->query($sql)->result_array()[0];
    }

    public function delete_service($id) {
        $this->db->trans_begin();
        $this->db->where("service_id", $id)->delete("target_days");
        $this->db->where("services_id", $id)->delete("related_services");
        $this->db->where("id", $id)->delete("services");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function get_company_list() {
        return $this->db->get("company_type")->result_array();
    }

    public function check_if_company_exists($company_name, $id = null) {
        $sql = "select * from company_type where type = '$company_name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function check_if_business_client_exists($company_name, $id = null) {
        $sql = "select * from company_type where type = '$company_name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function add_company_type($company_name) {
        return $this->db->insert('company_type', ["type" => $company_name, "status" => 1]);
    }

    public function get_company_by_id($company_id) {
        return $this->db->get_where("company_type", ['id' => $company_id])->row_array();
    }

    public function update_company_type($company_name, $company_id) {
        return $this->db->set(["type" => $company_name])->where("id", $company_id)->update("company_type");
    }

    public function delete_company_type($company_id) {
        return $this->db->where("id", $company_id)->delete("company_type");
    }

    public function get_source_list() {
        return $this->db->get_where("referred_by_source", ["status" => '1'])->result_array();
    }

    public function check_if_source_exists($source_name, $id = null) {
        $sql = "select * from referred_by_source where source = '$source_name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function add_source_type($source_name) {
        return $this->db->insert('referred_by_source', ["source" => $source_name, "status" => 1]);
    }

    public function get_source_by_id($source_id) {
        return $this->db->get_where("referred_by_source", ['id' => $source_id])->row_array();
    }

    public function update_source_type($source_name, $source_id) {
        return $this->db->set(["source" => $source_name])->where("id", $source_id)->update("referred_by_source");
    }

    public function delete_source_type($source_id) {
        //return $this->db->where("id", $source_id)->delete("referred_by_source");
        return $this->db->set(["status" => '2'])->where("id", $source_id)->update("referred_by_source");
    }

    public function get_company_relations($company_id) {
        return $this->db->where('type', $company_id)->from("company")->count_all_results();
    }

    public function get_service_relations($service_id) {
        return $this->db->where('services_id', $service_id)->from("service_request")->count_all_results();
    }

    public function get_department_relations($department_id) {
        $count = $this->db->where('department', $department_id)->from("actions")->count_all_results();
        $count += $this->db->where('department_id', $department_id)->from("department_staff")->count_all_results();
        return $count;
    }

    public function delete_department($id) {
        $this->db->trans_begin();
        $this->db->where("department_id", $id)->delete("department_staff");
        $this->db->where("department", $id)->delete("actions");
        $this->db->where("id", $id)->delete("department");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function get_office_relations($office_id) {
        $count = $this->db->where('office', $office_id)->from("internal_data")->count_all_results();
        $count += $this->db->where('office_id', $office_id)->from("office_staff")->count_all_results();
        return $count;
    }

    public function delete_office($id) {
        $this->db->trans_begin();
        $this->db->where("office", $id)->delete("internal_data");
        $this->db->where("office_id", $id)->delete("office_staff");
        $this->db->where("id", $id)->delete("office");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function get_staff_relations($staff_id) {
        $count = $this->db->where('staff_id', $staff_id)->from("action_staffs")->count_all_results();
        $count += $this->db->where('staff_requested_by', $staff_id)->from("lead_management")->count_all_results();
//        $count += $this->db->where('staff', $staff_id)->from("log")->count_all_results();
        $count += $this->db->where('staff_requested_service', $staff_id)->from("order")->count_all_results();
        $count += $this->db->where('responsible_staff', $staff_id)->from("service_request")->count_all_results();
        $count += $this->db->where('staff', $staff_id)->from("staff_message_board")->count_all_results();
        $count += $this->db->where('partner', $staff_id)->from("internal_data")->count_all_results();
        $count += $this->db->where(['id' => $staff_id, "role" => 2])->from("staff")->count_all_results();
        $count += $this->db->where('staff_id', $staff_id)->from("action_staffs")->count_all_results();
        $count += $this->db->where('added_by', $staff_id)->from("payment_deposit")->count_all_results();
        return $count;
    }

    public function delete_staff($staff_id) {
        $this->db->trans_begin();
//        $this->db->where('partner', $staff_id)->delete("internal_data");
//        $this->db->where('staff_id', $staff_id)->delete("action_staffs");
//        $this->db->where('staff_id', $staff_id)->delete("department_staff");
//        $this->db->where('staff_requested_by', $staff_id)->delete("lead_management");
//        $this->db->where('staff', $staff_id)->delete("log");
//        $this->db->where('staff_id', $staff_id)->delete("office_staff");
//        $this->db->where('staff_requested_service', $staff_id)->delete("order");
//        $this->db->where('responsible_staff', $staff_id)->delete("service_request");
//        $this->db->where('staff', $staff_id)->delete("staff_message_board");
//        $this->db->where('id', $staff_id)->delete("staff");
        $this->db->where('id', $staff_id)->update("staff", ['is_delete' => 'y']);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function get_all_staff_ajax($ofc = '', $dept = '', $type = '') {
        $this->db->select('st.*');
        $this->db->from('staff st');
        $this->db->join('department_staff ds', 'ds.staff_id = st.id');
        $this->db->join('office_staff os', 'os.staff_id = st.id');
        $sql = '';
        if ($ofc != '') {
            if ($sql == '') {
                $sql .= " os.office_id='" . $ofc . "'";
            } else {
                $sql .= " and os.office_id='" . $ofc . "'";
            }
        }

        if ($dept != '') {
            if ($sql == '') {
                $sql .= " ds.department_id='" . $dept . "'";
            } else {
                $sql .= " and ds.department_id='" . $dept . "'";
            }
        }

        if ($type != '') {
            if ($sql == '') {
                $sql .= " st.type='" . $type . "'";
            } else {
                $sql .= " and st.type='" . $type . "'";
            }
        }

        if ($sql != '') {
            $this->db->where($sql);
        }
        $this->db->where("st.is_delete", "n");
        //$this->db->where("st.status", "1");
        $this->db->order_by("st.status", 'DESC');
        $this->db->group_by('st.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_log_info() {
        return $this->db->get("log")->result_array();
    }

    public function get_office_staff_by_office_id($office_id) {
        $this->db->select("st.id, concat(st.last_name, ', ', st.first_name) as name, st.office_manager");
        $this->db->from("staff st");
        $this->db->join("office_staff ofcst", "ofcst.staff_id = st.id");
        $this->db->where(["ofcst.office_id" => $office_id, "st.is_delete" => "n", "st.type" => 3]);
        return $this->db->get()->result_array();
    }

    public function get_all_office_staff_by_office_id($office_id) {
        return $this->db->get_where("office_staff", ["office_id" => $office_id])->result_array();
    }

    public function get_all_office_staff_by_office_id_multiple($office_id) {
        $this->db->where_in('office_id', $office_id);
        return $this->db->get('office_staff')->result_array();
    }

    public function get_all_office_staff($staff_id) {
        $ofc_ids = $this->db->get_where('office_staff', ['staff_id' => $staff_id])->result_array();
        $ofc_ids = array_column($ofc_ids, 'office_id');
        $this->db->where_in('office_id', $ofc_ids);
        return $this->db->get('office_staff')->result_array();
    }

//    public function save_office_staff_manager($staff_id, $office_id) {
//        $this->load->model("system");
//        $staff_info = staff_info();
//        $office_manager = $staff_info['office_manager'];
//        $office_manager = ($office_manager == "") ? $office_id : $office_manager; // . "," . $office_id
//        $office_staff = $this->get_office_staff_by_office_id($office_id);
//        foreach ($office_staff as $st) {
//            if ($st['id'] != $staff_id) {
//                $st_inf = $this->system->get_staff_info($st['id']);
//                $om = $st_inf['office_manager'];
//                $manager = "";
//                $role = 1;
//                if ($st_inf['office_manager'] != "" && $st_inf['office_manager'] != $office_id) {
//                    $manager = explode(",", $st_inf['office_manager']);
//                    $pos = array_search($office_id, $manager);
//                    unset($manager[$pos]);
//                    $manager = implode(",", $st_inf['office_manager']);
//                    $role = 2;
//                }
//                $this->db->where("id", $st['id']);
//                $this->db->update("staff", ["role" => $role, "office_manager" => $manager]);
//            }
//        }
//        $this->db->where("id", $staff_id);
//        $this->db->update("staff", ["role" => 2, "office_manager" => $office_manager]);
//        return false;
//    }

    public function save_office_staff_manager($staff_id, $office_id) {
        $this->load->model("system");
        $staff_info = $this->get_office_manager_info_by_office_id($office_id);
        if (!empty($staff_info)) {
            $this->db->where("id", $staff_info['id']);
            $this->db->update("staff", ["role" => 1, "office_manager" => '']);
        }
        $this->db->where("id", $staff_id);
        return $this->db->update("staff", ["role" => 2, "office_manager" => $office_id]);
    }

    public function get_department_by_service_id($service_id) {
        $this->db->select("serv.*,dept.name as dept_name");
        $this->db->from("services serv");
        $this->db->join("department dept", "dept.id = serv.dept");
        $this->db->where(["serv.id" => $service_id]);
        return $this->db->get()->result_array();
    }

    public function get_all_office_stafftypewise($usertype) {
        if ($usertype == 1 || $usertype == 2) {
            $office_type = '1';
        } else {
            $office_type = '2';
        }
        return $this->db->get_where('office', ['status' => 1, 'type' => $office_type])->result_array();
    }

    public function get_business_client() {
        return $this->db->get_where("sales_tax_rate", ['status' => 0])->result_array();
    }

    public function get_business_client_by_id($business_client_id) {
        return $this->db->get_where('sales_tax_rate', ['id' => $business_client_id])->row_array();
    }

    public function add_business_client($data) {
        return $this->db->insert('sales_tax_rate', $data);
    }

    public function update_business_client($data, $client_id) {
        return $this->db->set($data)->where("id", $client_id)->update("sales_tax_rate");
    }

    public function delete_business_client($client_id) {
        return $this->db->set(['status' => 1])->where('id', $client_id)->update('sales_tax_rate');
    }

    public function add_renewal_dates($data) {
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        return $this->db->insert('renewal_dates', $data);
    }

    public function get_renewal_dates() {
        return $this->db->get("renewal_dates")->result_array();
    }

    public function get_renewal_dates_by_id($renewal_dates_id) {
        return $this->db->get_where('renewal_dates', ['id' => $renewal_dates_id])->row_array();
    }

    public function update_renewal_dates($data, $client_id) {
        return $this->db->set($data)->where("id", $client_id)->update("renewal_dates");
    }

    public function delete_renewal_dates($client_id) {
        return $this->db->query("delete from renewal_dates where id='$client_id' ");
    }

    public function get_office_manager_info_by_office_id($office_id) {
        return $this->db->get_where("staff", ['office_manager' => $office_id])->row_array();
    }

    public function get_leads() {
        $return_array = array();
        $taxleaf_db = $this->load->database('taxleaf_wp', TRUE);
        $sql = "SELECT `submit_time` AS 'Submitted',`form_name`,
 max(if(`field_name`='name', `field_value`, null )) AS 'name',
 max(if(`field_name`='your-name', `field_value`, null )) AS 'your-name',
 max(if(`field_name`='email', `field_value`, null )) AS 'email',
  max(if(`field_name`='your-email', `field_value`, null )) AS 'your-email',
 max(if(`field_name`='phone', `field_value`, null )) AS 'phone',
  max(if(`field_name`='your-phone', `field_value`, null )) AS 'your-phone',
  max(if(`field_name`='message', `field_value`, null )) AS 'message',
  max(if(`field_name`='your-message', `field_value`, null )) AS 'your-message',
  max(if(`field_name`='comments', `field_value`, null )) AS 'comments',
  max(if(`field_name`='notes', `field_value`, null )) AS 'notes',
 max(if(`field_name`='domain_city_name', `field_value`, null )) AS 'domain_city_name'
FROM `wp_cf7dbplugin_submits` GROUP BY `submit_time` 
ORDER BY `submit_time` DESC";
        $query = $taxleaf_db->query($sql);
        $render_data['result'] = $query->result_array();
        // echo '<pre>';
        // print_r($render_data['result']);  exit;
        foreach ($render_data['result'] as $key => $res) {
            if (trim($res['your-name']) != '') {
                $name = $res['your-name'];
            } elseif (trim($res['name']) != '') {
                $name = $res['name'];
            } else {
                $name = '';
            }
            if (trim($res['your-email']) != '') {
                $email = $res['your-email'];
            } elseif (trim($res['email']) != '') {
                $email = $res['email'];
            } else {
                $email = '';
            }
            if (trim($res['your-phone']) != '') {
                $phone = $res['your-phone'];
            } elseif (trim($res['phone']) != '') {
                $phone = $res['phone'];
            } else {
                $phone = '';
            }

            if (trim($res['your-message']) != '') {
                $lead_notes['note'] = $res['your-message'];
            } elseif (trim($res['message']) != '') {
                $lead_notes['note'] = $res['message'];
            } elseif (trim($res['comments']) != '') {
                $lead_notes['note'] = $res['comments'];
            } elseif (trim($res['notes']) != '') {
                $lead_notes['note'] = $res['notes'];
            } else {
                $lead_notes['note'] = '';
            }

            if ($email != '') {
                $check_if_lead_mail_exists = $this->db->query("select * from lead_management where email='" . $email . "'")->num_rows();
                if ($check_if_lead_mail_exists == 0) {
                    if ($name != '') {
                        $lead_type_contact = $this->db->query("select * from type_of_contact_prospect where name like ('%" . $res['form_name'] . "%')")->row_array();
                        if (!empty($lead_type_contact)) {
                            $ltc = $lead_type_contact['id'];
                        } else {
                            $ltc = '13';
                        }

                        if (trim($res['domain_city_name']) == '') {
                            $city = 'Unknown';
                            $ofc = '0';
                            $url = 'taxleaf.com';
                        } else {
                            $city = $res['domain_city_name'];
                            $ofc = '17';
                            if ($res['domain_city_name'] == 'Corporate') {
                                $url = 'taxleaf.com';
                            } else {
                                $url = strtolower($res['domain_city_name']) . '.taxleaf.com';
                            }
                        }

                        if (strpos($name, ' ') !== false) {
                            $nameval = explode(" ", $name);
                            $fname = $nameval[0];
                            $lname = $nameval[1];
                        } else {
                            $fname = $name;
                            $lname = '';
                        }


                        $insert_data = array(
                            'id' => '',
                            'type' => '1',
                            'type_of_contact' => $ltc,
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'company_name' => 'Unknown',
                            'address' => 'Unknown',
                            'city' => $city,
                            'state' => '10',
                            'zip' => '11111',
                            'language' => '1',
                            'phone1' => $phone,
                            'email' => $email,
                            'lead_source' => '2',
                            'lead_source_detail' => $url,
                            'office' => $ofc,
                            'staff_requested_by' => sess('user_id'),
                            'status' => '0',
                            'submission_date' => date('Y-m-d'),
                            'mail_campaign_status' => '0',
                            'import_status' => '0'
                        );
                        $this->db->insert('lead_management', $insert_data);
                        $lead_id = $this->db->insert_id();

                        $return_array[$key]['fname'] = $fname;
                        $return_array[$key]['lname'] = $lname;
                        $return_array[$key]['domain_city_name'] = $city;
                        $return_array[$key]['insert_id'] = $lead_id;

                        $this->load->model('notes');

                        if (!empty($lead_notes)) {
                            $this->notes->insert_note(3, $lead_notes, "lead_id", $lead_id);
                        }
                    }
                }
            }
        }
        return $return_array;
    }

    public function paypal_details() {
        return $this->db->get_where("paypal_account_details", ['id' => '1'])->row_array();
    }

    public function insert_import_lead($data) {
        $this->db->trans_begin();
        $import_lead = $data['import_lead'];
        if (!empty($import_lead)) {
            foreach ($import_lead as $il) {
                $this->db->set(["import_status" => '1'])->where("id", $il)->update("lead_management");
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function insert_paypal_details($data) {
        $this->db->trans_begin();

        $insert_data = array(
            'sandbox_or_live' => $data['sandbox_or_live'],
            'paypal_username' => $data['paypal_username'],
            'paypal_password' => $data['paypal_password'],
            'paypal_signature' => $data['paypal_signature']
        );

        $this->db->set($insert_data)->where("id", '1')->update("paypal_account_details");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function get_dept_mngr($dept_id) {
        if ($dept_id == 1) {
            return get_assigned_by_staff_name(4);
        } else {
            $sql = "select * from department_staff where department_id='" . $dept_id . "'";
            $res = $this->db->query($sql)->result_array();
            //print_r($res);          
            if (!empty($res)) {
                $dept_arr = [];
                foreach ($res as $a) {
                    $check_if_manager_sql = "select * from staff where id='" . $a["staff_id"] . "' and status='1' and role='4'";
                    $result = $this->db->query($check_if_manager_sql)->row_array();
                    if (!empty($result)) {
                        array_push($dept_arr, get_assigned_by_staff_name($result['id']));
                    }
                }
                if (!empty($dept_arr)) {
                    return implode(' / ', $dept_arr);
                } else {
                    return 'N/A';
                }
            } else {
                return 'N/A';
            }
        }
    }

    public function get_ofc_mngr($ofc_id) {
        // if($dept_id==1){
        //     return get_assigned_by_staff_name(4);
        // }else{
        $sql = "select * from office_staff where office_id='" . $ofc_id . "'";
        $res = $this->db->query($sql)->result_array();
        //print_r($res);          
        if (!empty($res)) {
            $ofc_arr = [];
            foreach ($res as $a) {
                $check_if_manager_sql = "select * from staff where id='" . $a["staff_id"] . "' and status='1' and role='2'";
                $result = $this->db->query($check_if_manager_sql)->row_array();
                //print_r($result);
                if (!empty($result)) {
                    array_push($ofc_arr, get_assigned_by_staff_name($result['id']));
                }
            }
            if (!empty($ofc_arr)) {
                return implode(' / ', $ofc_arr);
            } else {
                return 'N/A';
            }
        } else {
            return 'N/A';
        }
    }

    //}
}
