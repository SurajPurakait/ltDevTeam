<?php

Class Notes extends CI_Model {

    public function saveNotes($data) {
        foreach ($data['notes'] as $reference => $notes_data) {
            foreach ($notes_data as $reference_id => $noteArr) {
                foreach ($noteArr as $eachNote) {
                    $data = array();
                    $data['reference'] = $reference;
                    $data['reference_id'] = $reference_id;
                    $data['note'] = $eachNote;
                    $this->db->insert('notes', $data);
                }
            }
        }
    }

    public function get_invoice_note($order_id, $service_id = '') {
        if ($service_id != '') {
            $reference_id = $this->get_main_service_id($order_id, $service_id);
            if (!empty($reference_id)) {
                $reference_id = $reference_id['id'];
                return $this->db->get_where('notes', ['reference' => 'service', 'reference_id' => $reference_id])->result_array();
            } else {
                return [];
            }
        } else {
            // in this section $order_id as invoive_id
            return $this->db->get_where('notes', ['reference' => 'invoice', 'reference_id' => $order_id])->result_array();
        }
    }

    public function get_main_service_id($order_id, $services_id) {
        $this->db->where(['order_id' => $order_id, 'services_id' => $services_id]);
        return $this->db->get('service_request')->row_array();
    }

    public function saveupdateNotes($data) {
        foreach ($data['notes'] as $reference => $notes_data) {
            foreach ($notes_data as $reference_id => $noteArr) {
                $this->db->delete('notes', array('reference_id' => $reference_id));
                foreach ($noteArr as $eachNote) {
                    $data = array();
                    $data['reference'] = $reference;
                    $data['reference_id'] = $reference_id;
                    $data['note'] = $eachNote;
                    $this->db->insert('notes', $data);
                }
            }
        }
    }

    public function updateNotes($data, $table_name) {
        foreach ($data['notes'] as $p_id => $notes_data) {
            $this->db->where('id', $p_id);
            $this->db->update($table_name, array('note' => $notes_data));
        }
    }

    public function getNotesContent($reference, $reference_id) {
        $data = $this->db->get_where('notes', array('reference' => $reference, 'reference_id' => $reference_id))->result();
        return $data;
    }

    public function getmainServiceNotesContent($order_id, $services_id) {
        $sql = "select * from service_request where order_id='$order_id' and services_id='$services_id'";
        $result = $this->db->query($sql)->result_array();
        if (!empty($result)) {
            $idval = $result[0]['id'];
            return $this->getNotesContent('service', $idval);
        }
    }

    public function get_related_note_table_by_id($related_table_id) {
        $table[1] = 'notes';
        $table[2] = 'action_notes';
        $table[3] = 'lead_notes';
        $table[4] = 'payroll_employee_notes';
        $table[5] = 'payroll_rt6_notes';
        $table[6] = 'marketing_notes';
        $table[7] = 'cart_notes';
        $table[8] ='template_task_note';
        $table[9] = 'project_note';
        $table[10] = 'visitation_notes';
        $table[11]='project_task_note';
        return $table[$related_table_id];
    }

    public function note_list_with_log($related_table_id, $foreign_column, $foreign_value, $foreign_value2 = "") {
        $table = $this->get_related_note_table_by_id($related_table_id);
        $this->db->select('nt.id note_id, nl.user_id, nt.note note, nl.date_time time, CONCAT(st.last_name, ", ", st.first_name) staff_name, st.department staff_department');
        $this->db->from($table . ' nt');
        $this->db->join('notes_log nl', 'nt.id = nl.note_id');
        $this->db->join('staff st', 'st.id = nl.user_id');
        if ($related_table_id == 1) {
            $this->db->where(['nt.reference' => $foreign_value2]);
        }
        $this->db->where(['nt.' . $foreign_column => $foreign_value, 'nl.related_table_id' => $related_table_id, 'nl.user_id!=' => $this->session->userdata('user_id')]);
        $return1 = $this->db->get()->result_array();
//        echo $this->db->last_query();
        $this->db->select('nt.id note_id, nl.user_id, nt.note note, nl.date_time time, CONCAT(st.last_name, ", ", st.first_name) staff_name, st.department staff_department');
        $this->db->from($table . ' nt');
        $this->db->join('notes_log nl', 'nt.id = nl.note_id');
        $this->db->join('staff st', 'st.id = nl.user_id');
        if ($related_table_id == 1) {
            $this->db->where(['nt.reference' => $foreign_value2]);
        }
        $this->db->where(['nt.' . $foreign_column => $foreign_value, 'nl.related_table_id' => $related_table_id, 'nl.user_id' => $this->session->userdata('user_id')]);
        $return2 = $this->db->get()->result_array();
//        echo $this->db->last_query();die;
        return array_merge($return1, $return2);
    }

    public function insert_note($related_table_id, $notes_data, $foreign_column, $foreign_value, $reference = "") {
        $table = $this->get_related_note_table_by_id($related_table_id);
        $user_id = $this->session->userdata('user_id');
        foreach ($notes_data as $note) {
            if (trim($note) != "") {
                $insert_data[$foreign_column] = $foreign_value;
                $insert_data['note'] = $note;
                if($related_table_id==6 || $related_table_id==7 || $related_table_id==8 || $related_table_id==9 || $related_table_id==10 || $related_table_id==2){
                   $insert_data['added_by_user'] = $user_id; 
               }                
                if ($related_table_id == 1) {
                    $insert_data['reference'] = $reference;
                }
                $this->db->insert($table, $insert_data);
                $note_id = $this->db->insert_id();

                $this->db->insert("notes_log", ['note_id' => $note_id, 'user_id' => $user_id, 'related_table_id' => $related_table_id, 'date_time' => date('Y-m-d H:i:s')]);

                    if($reference=='order'){
                        $this->system->save_general_notification('order', $foreign_value, 'note');
                    }elseif($reference=='invoice'){
                        $this->system->save_general_notification('invoice', $foreign_value, 'note');    
                    }elseif($reference=='action'){
                        $this->system->save_general_notification('action', $foreign_value, 'note');
                    }
            }
          }
    }

    public function update_note($related_table_id, $notes_data, $reference_id = "", $reference = "") {
        $table = $this->get_related_note_table_by_id($related_table_id);
        foreach ($notes_data as $note_id => $note) {
            if ($note != "") {
                $update_data['note'] = $note;
                if ($related_table_id == 1 && $reference == "service") {
                    $update_data['reference_id'] = $reference_id;
                }
                $this->db->where('id', $note_id);
                $this->db->update($table, $update_data);
            }
        }
    }

    public function delete_note($note_id, $related_table_id) {
        $table = $this->get_related_note_table_by_id($related_table_id);
        if ($this->db->delete($table, ['id' => $note_id])) {
            return $this->db->delete('notes_log', ['note_id' => $note_id, 'related_table_id' => $related_table_id]);
        } else {
            return false;
        }
    }

    public function note_notification_list_with_log($related_table_id, $reference, $bywhom = '') {
        $staff_info = staff_info();
        $table = $this->get_related_note_table_by_id($related_table_id);
        $this->db->select("nt.id note_id, st.id staff_id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) as staff_name, nt.note note, nl.date_time time, ntf.reference_id reference_id, ntf.id nid,ntf.read_status");
        $this->db->from('note_notification ntf');
        $this->db->join($table . ' nt', 'nt.id = ntf.note_id');
        $this->db->join('notes_log nl', 'nl.note_id = nt.id');
        $this->db->join('staff st', 'st.id = nl.user_id');
        if($bywhom=='tome'){
            if($staff_info['type']==1){
                $this->db->where(['ntf.reference' => $reference, 'ntf.staff_id' => sess('user_id'), 'nl.user_id!=' => sess('user_id'), 'nl.related_table_id' => $related_table_id, 'ntf.read_status' => '0']);
            }else{
                $this->db->where(['ntf.reference' => $reference, 'ntf.staff_id' => sess('user_id'), 'nl.user_id!=' => sess('user_id'), 'nl.related_table_id' => $related_table_id, 'ntf.read_status' => '0']);
            }            
        }else{
           $this->db->where(['ntf.reference' => $reference, 'ntf.staff_id' => sess('user_id'), 'nl.user_id' => sess('user_id'), 'nl.related_table_id' => $related_table_id, 'ntf.read_status' => '0']); 
       }        
        $this->db->group_by('nt.id');
        return $this->db->get()->result_array();
    }

    public function change_read_status($data){
        foreach($data as $d){
            $this->db->where('id', $d['nid']);
            $this->db->update('note_notification', array('read_status' => 1));
        }
    }

    public function change_read_status_notes($id){
        // echo $id;die;
        $data = array(
            'read_status' => '1'
        );
        // $this->db->set('read_status',1);
        $this->db->where('action_id',$id);
        $this->db->update('action_notes',$data);
    }


    public function change_read_status_visitnotes($id){
        
        $data = array(
            'read_status' => '1'
        );
        $this->db->where('visitation_id',$id);
        $this->db->update('visitation_notes',$data);
    }

    public function change_task_read_status_notes($id){
        // echo $id;die;
        $data = array(
            'read_status' => '1'
        );
        // $this->db->set('read_status',1);
        $this->db->where('task_id',$id);
        $this->db->update('template_task_note',$data);
    }
    public function note_read_status_change($id){
        $this->db->set('read_status',1);
        $this->db->where('reference_id',$id);
        $this->db->update('notes');
    }

    public function getNoteData($reference, $reference_id){
        return $this->db->get_where('notes', array('reference' => $reference, 'reference_id' => $reference_id))->result_array();
    }
    public function change_project_task_read_status_notes($id){
        // echo $id;die;
        $data = array(
            'read_status' => '1'
        );
        // $this->db->set('read_status',1);
        $this->db->where('task_id',$id);
        $this->db->update('project_task_note',$data);
    }
}
