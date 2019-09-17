<?php

class Visitation_model extends CI_Model {

        function insert_visit_data($data) {
            //print_r($data);
            $this->db->trans_begin();

            $newDate = date("Y-m-d", strtotime($data['due_date']));
        
            $values = array(
                'subject'=>$data['subject'],
                'date'=>$newDate,
                'start_time'=>$data['start_time'],
                'end_time'=>$data['end_time'],
                'added_by_user'=> sess('user_id')
            );

            $result = $this->db->insert('visitation', $values);
            $insert_id = $this->db->insert_id();

            if(!empty($data['manager'])){
               foreach($data['manager'] as $val){
                //$staff_val = $this->db->get_where('staff',array('id'=>$val))->row_array();

                    $r = array(
                        'visitation_id'=>$insert_id,
                        'participant_id'=>$val
                        );

              $this->db->insert('visitation_participants',$r);
             } 
            }
            
            if(!empty($data['office'])){
            foreach($data['office'] as $val){

                    $r = array(
                        'visitation_id'=>$insert_id,
                        'office'=>$val
                        );

             $this->db->insert('visitation_office',$r);
            }
           }

            $notedata = $this->input->post('visit_note');
            $this->insert_visitation_note(10, $notedata, "visitation_id", $insert_id, 'visitation');

            if (isset($_FILES['upload_file'])) {

                $count = count($_FILES['upload_file']['name']);
                $uploadData = array();
                for ($i = 0; $i < $count; $i++) {
                    $_FILES['multi_img']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $_FILES['upload_file']['name'][$i]));
                    $_FILES['multi_img']['type'] = $_FILES['upload_file']['type'][$i];
                    $_FILES['multi_img']['tmp_name'] = $_FILES['upload_file']['tmp_name'][$i];
                    $_FILES['multi_img']['error'] = $_FILES['upload_file']['error'][$i];
                    $_FILES['multi_img']['size'] = $_FILES['upload_file']['size'][$i];
                    $config['upload_path'] = "./uploads";
                    $config['allowed_types'] = 'gif|jpg|png';
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('multi_img')) {
                        $fileData = $this->upload->data();
                        $uploadData[$i]['visitation_id'] = $insert_id;
                        $uploadData[$i]['filename'] = $fileData['file_name'];
                    }
                }
            }
             if (!empty($uploadData)) {
               $this->db->insert_batch('visitation_attachments', $uploadData);
              
             }

            if ($this->db->trans_status() === 0) {
                $this->db->trans_rollback();
                return 0;
            } else {
                $this->db->trans_commit();
                return 1;
            }

    }

    public function get_related_note_table_by_id_task($related_table_id) {
        $table[1] = 'notes';
        $table[2] = 'action_notes';
        $table[3] = 'lead_notes';
        $table[4] = 'payroll_employee_notes';
        $table[5] = 'payroll_rt6_notes';
        $table[6] = 'marketing_notes';
        $table[7] = 'cart_notes';
        $table[8] = 'template_task_note';
        $table[9] = 'project_note';
        $table[10] = 'visitation_notes';
        return $table[$related_table_id];
    }

    public function insert_visitation_note($related_table_id, $notes_data, $foreign_column, $foreign_value, $reference = "") {
        $table = $this->get_related_note_table_by_id_task($related_table_id);
        $user_id = $this->session->userdata('user_id');
        foreach ($notes_data as $note) {
            if (trim($note) != "") {
                $insert_data[$foreign_column] = $foreign_value;
                $insert_data['note'] = $note;
                if ($related_table_id == 6 || $related_table_id == 7 || $related_table_id == 8 || $related_table_id == 9 || $related_table_id == 10) {
                    $insert_data['added_by_user'] = $user_id;
                }
                if ($related_table_id == 1) {
                    $insert_data['reference'] = $reference;
                }
                $this->db->insert($table, $insert_data);
                $note_id = $this->db->insert_id();
                $this->db->insert("notes_log", ['note_id' => $note_id, 'user_id' => $user_id, 'related_table_id' => $related_table_id, 'date_time' => date('Y-m-d H:i:s')]);
            }
        }
    }


        // public function view_visit_data(){

        //     $this->db->select("v.*,vo.*,o.office_id as office_name");
        //     $this->db->from('visitation v');
        //     $this->db->join('visitation_office vo', "vo.visitation_id=v.id");
        //     $this->db->join('office o', "o.id=vo.office");
        //     $this->db->where(['v.status' => 1]);
        //     $result = $this->db->get()->result_array();
        //     return $result;
        // }

         public function view_visit_data(){
            $this->db->select('v.*,REPLACE(CONCAT((SELECT GROUP_CONCAT(office) FROM visitation_office WHERE visitation_id = v.id)), " ", "") AS office,REPLACE(CONCAT((SELECT GROUP_CONCAT(participant_id) FROM visitation_participants WHERE visitation_id = v.id)), " ", "") AS participants');
            $this->db->from('visitation v');
            $result = $this->db->get()->result_array();
            return $result;
        }

         public function view_visit_pagedetails($id){
            $this->db->select('v.*,REPLACE(CONCAT((SELECT GROUP_CONCAT(office) FROM visitation_office WHERE visitation_id = v.id)), " ", "") AS office,REPLACE(CONCAT((SELECT GROUP_CONCAT(participant_id) FROM visitation_participants WHERE visitation_id = v.id)), " ", "") AS participants');
            $this->db->from('visitation v');
            // $this->db->where(['v.status' => 1]);
            $this->db->where('v.id',$id);
            $result = $this->db->get()->row_array();
            return $result;
        }

        public function get_visitation_note_count($id){
            $this->db->select("count(id) as notecount");
            $this->db->from('visitation_notes');
            $this->db->where(['visitation_id' => $id]);
            $row = $this->db->get()->row_array();
            return $row['notecount'];
        }

        public function get_visitation_attachment_count($id){
            $this->db->select("count(id) as attachmentcount");
            $this->db->from('visitation_attachments');
            $this->db->where(['visitation_id' => $id]);
            $row = $this->db->get()->row_array();
            return $row['attachmentcount'];
        }


        // public function show_edit_visitation($edit_id){

        // $this->db->select("v.*,o.office_id as office_name");
        // $this->db->from('visitation v');
        // $this->db->join('office o', "o.id=v.office");     
        // $this->db->where('v.id',$edit_id);
        // $result = $this->db->get()->row_array();
        // return $result;
        // }

        public function show_edit_visitation($edit_id){

        $this->db->select('v.*,REPLACE(CONCAT((SELECT GROUP_CONCAT(office) FROM visitation_office WHERE visitation_id = v.id)), " ", "") AS office,REPLACE(CONCAT((SELECT GROUP_CONCAT(participant_id) FROM visitation_participants WHERE visitation_id = v.id)), " ", "") AS participants');
        $this->db->from('visitation v'); 
        //$this->db->join('visitation_office vo', "vo.visitation_id=v.id");   
        $this->db->where('v.id',$edit_id);
        $result = $this->db->get()->row_array();
        return $result;

        }

        public function show_participation($edit_id){
            $this->db->select('v.*,REPLACE(CONCAT((SELECT GROUP_CONCAT(participant_id) FROM visitation_participants WHERE visitation_id = v.id)), " ", "") AS participant');
            $this->db->from('visitation v');
            $this->db->where('v.id',$edit_id);
            $result = $this->db->get()->row_array();
            return $result;
        }

        public function show_notes_in_modalpage($id){
        $this->db->select("v.*,vn.*");
        $this->db->from('visitation v');
        $this->db->join('visitation_notes vn', "v.id=vn.visitation_id");     
        $this->db->where('v.id',$id);
        $result = $this->db->get()->result_array();
        return $result;

        }

        public function show_attachment_in_editpage($edit_id){
            $this->db->select("v.*,va.*");
            $this->db->from('visitation v');
            $this->db->join('visitation_attachments va', "v.id=va.visitation_id");
            $this->db->where('v.id',$edit_id);
            $result = $this->db->get()->result_array();
            return $result;
        }


        function update_visit_data($id,$data){

             $this->db->trans_begin();
              // alert($id);exit;
            $newDate = date("Y-m-d", strtotime($data['due_date']));
            // $staff_val = $this->db->get_where('staff',array('id'=>$data['manager']))->row_array();
            
            $values = array(
                'subject'=>$data['subject'],
                'date'=>$newDate,
                'start_time'=>$data['start_time'],
                'end_time'=>$data['end_time'],
                'added_by_user'=> sess('user_id')
            );

           
            $this->db->set($values);
          
            $this->db->where('id', $id);
            $this->db->update('visitation');
             //echo $this->db->last_query(); exit;
        // $result = $this->db->insert('visitation', $values);
        // $insert_id = $this->db->insert_id();


             if(!empty($data['manager'])){
                $this->db->where('visitation_id', $id);
                $this->db->delete('visitation_participants'); 

               foreach($data['manager'] as $val){
                // $staff_val = $this->db->get_where('staff',array('id'=>$val))->row_array();

                    $r = array(
                        'visitation_id'=>$id,
                        'participant_id'=>$val
                        // 'phone' => $staff_val['phone'],
                        // 'email'=> $staff_val['user'] 
                        );

               $this->db->insert('visitation_participants',$r);
             } 
            }
            
            if(!empty($data['office'])){
                $this->db->where('visitation_id', $id);
                $this->db->delete('visitation_office'); 

            foreach($data['office'] as $val){

                    $r = array(
                        'visitation_id'=>$id,
                        'office'=>$val
                        );

                $this->db->insert('visitation_office',$r);
            }
           }


        $visitation_notes = $this->input->post('visitation_notes');
        $edit_visitation_notes = $this->input->post('edit_visitation_notes');
        $this->load->model('notes');

        if (!empty($visitation_notes)) {
        $this->notes->insert_note(10, $visitation_notes, "visitation_id", $id);
        }

        if (!empty($edit_visitation_notes)) {
        $this->notes->update_note(10, $edit_visitation_notes);
        }

        if (isset($_FILES['upload_file'])) {

            $count = count($_FILES['upload_file']['name']);
            $uploadData = array();
            for ($i = 0; $i < $count; $i++) {
                $_FILES['multi_img']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $_FILES['upload_file']['name'][$i]));
                $_FILES['multi_img']['type'] = $_FILES['upload_file']['type'][$i];
                $_FILES['multi_img']['tmp_name'] = $_FILES['upload_file']['tmp_name'][$i];
                $_FILES['multi_img']['error'] = $_FILES['upload_file']['error'][$i];
                $_FILES['multi_img']['size'] = $_FILES['upload_file']['size'][$i];
                $config['upload_path'] = "./uploads";
                $config['allowed_types'] = 'gif|jpg|png';
                $this->upload->initialize($config);
                if ($this->upload->do_upload('multi_img')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['visitation_id'] = $id;
                    $uploadData[$i]['filename'] = $fileData['file_name'];
                }
            }
        }
         if (!empty($uploadData)) {
           $this->db->insert_batch('visitation_attachments', $uploadData);
          
         }

        if ($this->db->trans_status() === 0) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }

        }


        public function getvisitFilesContent($id) {
            $this->db->select("v.*,va.*");
            $this->db->from('visitation v');
            $this->db->join('visitation_attachments va', "v.id=va.visitation_id");
            $this->db->where('v.id',$id);
            $result = $this->db->get()->result_array();
            return $result;
        }


    public function fileupload_visitation($id, $files) {
        // print_r($files); echo $data; exit;
        if (!empty($files["name"])) {
            $filesCount = count($files['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['userFile']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['userFile']['type'] = $files['type'][$i];
                $_FILES['userFile']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['userFile']['error'] = $files['error'][$i];
                $_FILES['userFile']['size'] = $files['size'][$i];

                // $uploadPath = FCPATH . 'uploads/';
                 $config['upload_path'] = "./uploads";
                // $config['upload_path'] = $uploadPath;
                // $config['allowed_types'] = "*";
                 $config['allowed_types'] = 'gif|jpg|png';


                // $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['filename'] = $fileData['file_name'];
                    // $uploadData[$i]['added_by_user'] = sess('user_id');
                    $uploadData[$i]['visitation_id'] = $id;
                }
            }
        }

        if (!empty($uploadData)) {
            $this->db->insert_batch('visitation_attachments', $uploadData);
        }
        return $filesCount;
    }


    public function get_read_visitstatus($id) {
        $result = $this->db->get_where('visitation_notes', array('visitation_id' => $id))->result_array();
        return array_column($result, 'read_status');
        // return $result['read_status'];
    }


    public function get_stafflist_by_office_id($office_id) {
        if (is_array($office_id)){
            $office_id = $office_id;
        }else{
            $office_id = explode(",",$office_id);
        }
        $this->db->distinct('st.id');
        $this->db->select("st.id, concat(st.last_name, ', ',st.first_name,' ',st.middle_name) as name");
        $this->db->from('staff st');
        $this->db->join('office_staff ost', 'ost.staff_id = st.id');
        $this->db->where_in('ost.office_id',$office_id);
        $this->db->where(['st.is_delete' => 'n', 'st.status' => '1']);
        $this->db->where('st.first_name is NOT NULL', NULL, FALSE);
        $this->db->where('st.middle_name is NOT NULL', NULL, FALSE);
        $this->db->where('st.last_name is NOT NULL', NULL, FALSE);
        return $this->db->get()->result_array();

    }


    public function get_current_visitation_status($table_name, $id) {
        return $this->db->query("select status from $table_name where id = '$id'")->row_array()["status"];
    }


    public function update_visitation_status($visit_id,$status){

            $this->db->set('status',$status);
          
            $this->db->where('id', $visit_id);
            return $this->db->update('visitation');
    }


    }

?>
