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
class State extends CI_Model {
  
    public function get_state_info(){
        $sql = "select * from states";
        $result = $this->db->query($sql);
        $result_array=$result->result_array(); 
        return $result_array; 
    }

    

    
    
}
