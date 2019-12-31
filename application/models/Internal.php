<?php

Class Internal extends CI_Model {

    public function saveInternalData($data) {
        $this->load->model('system');
        $this->db->trans_begin();
        $internal_data_columns = $this->db->list_fields('internal_data');
        $save_data = [];
        unset($internal_data_columns['id']);
        foreach ($internal_data_columns as $column) {
            if (isset($data[$column])) {
                if ($column == 'practice_id') {
                    if (isset($data['practice_id'])) {
                        $save_data['practice_id'] = $data['practice_id'] == '' ? $this->system->generete_practice_id($data['reference_id'], $data['reference']) : $data['practice_id'];
                    } else {
                        $save_data['practice_id'] = $this->system->generete_practice_id($data['reference_id'], $data['reference']);
                    }
                } else {
                    $save_data[$column] = $data[$column];
                }
            }
        }
        $exist_internal_data = $this->db->get_where('internal_data', ['reference' => $data['reference'], 'reference_id' => $data['reference_id']])->row_array();
        if (!empty($exist_internal_data)) {     // Update section
            unset($save_data['reference']);
            unset($save_data['reference_id']);
            $internal_data_id = $exist_internal_data['id'];
            $this->db->where('id', $internal_data_id);
            $this->db->update('internal_data', $save_data);
            $this->system->log("update", "internal_data", $internal_data_id);
        } else {    // Insert section
            // $save_data['status'] = 1;
            
            $check_duplicate_practice_id_1 = $this->db->get_where('internal_data', ['practice_id' => $save_data['practice_id']])->row_array();
            if($save_data['practice_id'] == $check_duplicate_practice_id_1['practice_id']){
                $save_data['practice_id'] = substr_replace($save_data['practice_id'], 1 , -1); 
                
                $check_duplicate_practice_id_2 = $this->db->get_where('internal_data', ['practice_id' => $save_data['practice_id']])->row_array();
                if($save_data['practice_id'] == $check_duplicate_practice_id_2['practice_id']){
                    $save_data['practice_id'] = substr_replace($save_data['practice_id'], 2 , -1); 

                    $check_duplicate_practice_id_3 = $this->db->get_where('internal_data', ['practice_id' => $save_data['practice_id']])->row_array();
                    if($save_data['practice_id'] == $check_duplicate_practice_id_3['practice_id']){
                        $save_data['practice_id'] = substr_replace($save_data['practice_id'], 3 , -1); 

                        $save_data['status'] = 1; 
                        $this->db->insert('internal_data', $save_data);
                        $internal_data_id = $this->db->insert_id();
                        $this->system->log("insert", "internal_data", $internal_data_id); 

                    }
                    
                    $save_data['status'] = 1; 
                    $this->db->insert('internal_data', $save_data);
                    $internal_data_id = $this->db->insert_id();
                    $this->system->log("insert", "internal_data", $internal_data_id);    
                }

                $save_data['status'] = 1;
                $this->db->insert('internal_data', $save_data);
                $internal_data_id = $this->db->insert_id();
                $this->system->log("insert", "internal_data", $internal_data_id);
            }else{
                $save_data['status'] = 1;
                $this->db->insert('internal_data', $save_data);
                $internal_data_id = $this->db->insert_id();
                $this->system->log("insert", "internal_data", $internal_data_id);
            }

            // $this->db->insert('internal_data', $save_data);
            // $internal_data_id = $this->db->insert_id();
            // $this->system->log("insert", "internal_data", $internal_data_id);
        }

        if ($data['reference'] == 'company') { // Save company owner internal data
            $owner_list = $this->system->get_owner_list_by_company_id($data['reference_id']);
            foreach ($owner_list as $ol) {
                $save_data['reference'] = 'individual';
                $save_data['reference_id'] = $reference_id = $ol['individual_id'];
                $save_data['practice_id'] = '';
                $exist_owner_internal_data = $this->db->get_where('internal_data', ['reference' => 'individual', 'reference_id' => $reference_id])->row_array();
                if (!empty($exist_owner_internal_data)) {     // Update section
                    // if (isset($save_data['reference'])) {
                    //     unset($save_data['reference']);
                    // }
                    // if (isset($save_data['reference_id'])) {
                    //     unset($save_data['reference_id']);
                    // }
                    // if (isset($save_data['status'])) {
                    //     unset($save_data['status']);
                    // }
                    if (!empty($exist_owner_internal_data['practice_id'])) {
                        $save_data['practice_id'] = $this->system->generete_practice_id($save_data['reference_id'], $save_data['reference']);
                        // print_r($save_data['practice_id']);exit;
                    }
                    $internal_data_id = $exist_owner_internal_data['id'];
                    $this->db->where('id', $internal_data_id);
                    $this->db->update('internal_data', $save_data);
                    $this->system->log("update", "internal_data", $internal_data_id);
                } else {    // Insert section
                    if ($save_data['practice_id'] == '') {
                        $save_data['practice_id'] = $this->system->generete_practice_id($save_data['reference_id'], $save_data['reference']);
                        $check_duplicate_owner_practice_id_1 = $this->db->get_where('internal_data', ['practice_id' => $save_data['practice_id']])->row_array();
                        if($save_data['practice_id'] == $check_duplicate_owner_practice_id_1['practice_id']){

                            $save_data['practice_id'] = substr_replace($save_data['practice_id'], 1 , -1);

                            $check_duplicate_owner_practice_id_2 = $this->db->get_where('internal_data', ['practice_id' => $save_data['practice_id']])->row_array();
                            if($save_data['practice_id'] == $check_duplicate_owner_practice_id_2['practice_id']){

                                $save_data['practice_id'] = substr_replace($save_data['practice_id'], 2 , -1);

                                $check_duplicate_owner_practice_id_3 = $this->db->get_where('internal_data', ['practice_id' => $save_data['practice_id']])->row_array();

                                if($save_data['practice_id'] == $check_duplicate_owner_practice_id_3['practice_id']){

                                    $save_data['practice_id'] = substr_replace($save_data['practice_id'], 3 , -1);
                                    
                                    $save_data['status'] = 1;
                                    $this->db->insert('internal_data', $save_data);
                                    $internal_data_id = $this->db->insert_id();
                                    $this->system->log("insert", "internal_data", $internal_data_id);

                                } 
                                $save_data['status'] = 1;
                                $this->db->insert('internal_data', $save_data);
                                $internal_data_id = $this->db->insert_id();
                                $this->system->log("insert", "internal_data", $internal_data_id);
                            }

                            $save_data['status'] = 1;
                            $this->db->insert('internal_data', $save_data);
                            $internal_data_id = $this->db->insert_id();
                            $this->system->log("insert", "internal_data", $internal_data_id);

                        }else{
                            $save_data['status'] = 1;
                            $this->db->insert('internal_data', $save_data);
                            $internal_data_id = $this->db->insert_id();
                            $this->system->log("insert", "internal_data", $internal_data_id);
                        }
                    }
                    // $save_data['status'] = 1;
                    // $this->db->insert('internal_data', $save_data);
                    // $internal_data_id = $this->db->insert_id();
                    // $this->system->log("insert", "internal_data", $internal_data_id);
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

    public function get_internal_data($reference, $reference_id) {
        $sql = "select * from internal_data where reference_id=$reference_id and status=1";
        return $this->db->query($sql)->result_array();
    }

}
