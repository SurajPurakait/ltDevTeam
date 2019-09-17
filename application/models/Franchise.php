<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Company
 *
 * @author rafael
 */
class Franchise extends CI_Model {

    public function get_franchise_info() {
        $sql = "select office.*,states.id as stid,state_name from office,states where office.state=states.id and office.status=1";
        $result = $this->db->query($sql);
        $result_array = $result->result_array();
        return $result_array;
    }

    public function get_franchise_associated_staff_info($ofid) {
        $sql = "select staff.* from office_staff,staff where office_id=" . $ofid . " AND staff_id=staff.id";
        $result = $this->db->query($sql);
        $result_array = $result->result_array();
        return $result_array;
    }

    public function get_deptinfo() {
        $sql = "select * from department";
        $result = $this->db->query($sql);
        $result_array = $result->result_array();
        return $result_array;
    }

    public function delete_department($id) {
        $sql = "delete from `department` where id='$id'";
        $result = $this->db->query($sql);
    }

    public function update_dept($data) {
        $ins_data = array(
            'name' => $data['name'],
            'manager_fname' => $data['manager_fname'],
            'manager_lname' => $data['manager_lname'],
            'phone' => $data['phone'],
            'extension' => $data['extension'],
            'email' => $data['emailaddress']
        );
        $this->db->where('id', $data['dept_id']);
        $this->db->update('department', $ins_data);
        return true;
    }

}
