<?php

class Employee extends CI_Model {

    public $id;

    public function check_add_employee_email($email) {
        return $this->db->get_where('payroll_employee_info', ['email' => $email])->num_rows();
    }

    public function add_employee($data) {
        return $this->db->insert("payroll_employee_info", $data);
    }

    public function loadEmployeeList($reference_id) {
        return $this->db->get_where('payroll_employee_info', ['reference_id' => $reference_id])->result_array();
    }
    
    public function get_employee_by_id($employee_id) {
        return $this->db->get_where('payroll_employee_info', ['id' => $employee_id])->row_array();
    }
    
    public function check_update_employee_email($employee_id, $email) {
        return $this->db->get_where('payroll_employee_info', ['id !=' => $employee_id, 'email' => $email])->num_rows();
    }
    
    public function update_employee($employee_id, $data) {
        $this->db->where("id" , $employee_id);
        return $this->db->update("payroll_employee_info", $data);
    }
    
    public function delete_employee_by_id($employee_id) {
        return $this->db->delete("payroll_employee_info", ['id' => $employee_id]);
    }

}

?>
