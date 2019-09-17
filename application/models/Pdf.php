<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Pdf extends CI_Model {

   public function getstatename($state_id) {
         $sql = "select * from `states` where id = '$state_id'";
         $result = $this->db->query($sql)->row_array();
         return $result;
    }
    public function getOffice($office_id) {
         $sql = "select id, name from office where id='$office_id' and status = 1";
         $result = $this->db->query($sql)->row_array();
         return $result;
    }
    public function getOfficeStaff($id) {
        $sql = "SELECT * FROM staff WHERE id='$id'";
        return $this->db->query($sql)->row_array();
    }
    public function gettypename($type_id) {
         $sql = "select * from `company_type` where id = $type_id";
         $result = $this->db->query($sql)->row_array();
         return $result;
    }
    
    public function getReferredBySource($id) {
        $sql = "SELECT * FROM referred_by_source WHERE id='$id'";
        return $this->db->query($sql)->row_array();
    }
    
    public function getLanguages($id) {
        $sql = "SELECT * FROM languages WHERE id='$id'";
        return $this->db->query($sql)->row_array();
    }

    public function getsubcat($ref_id){
       return $this->db->get_where("bookkeeping",["company_id" => $ref_id])->row_array(); 
    }

    public function getMainContactName($ref_id){
       return $this->db->get_where("contact_info",["reference" => "company", "reference_id" => $ref_id, "type" => "1"])->row_array(); 
    }
    

}

