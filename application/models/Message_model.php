<?php

class Message_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function request_save_message($save_data) {
        $this->db->trans_begin();
        $save_data['added_by'] = sess('user_id');
        $this->db->insert("messages", $save_data);
        $message_id = $this->db->insert_id();

        $this->db->where(['is_delete' => 'n']);
        $this->db->where_in('type', [1, $save_data['message_type']]);
        $staff_list = $this->db->get('staff')->result_array();

        $message_staff_data = [];
        foreach ($staff_list as $key => $staff) {
            $message_staff_data[$key]['staff_id'] = $staff['id'];
            $message_staff_data[$key]['message_id'] = $message_id;
        }
        if (!empty($message_staff_data)) {
            $this->db->insert_batch('message_staffs', $message_staff_data);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function read_message($staff_id, $message_id) {
        $this->db->trans_begin();
        $message_id_list = explode(',', $message_id);
        foreach ($message_id_list as $msg_id) {
            $this->db->where(['staff_id' => $staff_id, 'message_id' => $msg_id]);
            $this->db->update('message_staffs', ['read_status' => 'y']);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_message_list($message_type) {
        $this->db->select('msg.*, msg_st.staff_id AS staff_id, msg_st.read_status AS read_status');
        $this->db->from('messages AS msg');
        $this->db->join('message_staffs AS msg_st', 'msg_st.message_id = msg.id');
        $this->db->where(['msg.message_type' => $message_type]);
        $this->db->where(['msg_st.staff_id' => sess('user_id')]);
        $this->db->where(['msg_st.read_status' => 'n']);
        $result = $this->db->get()->result_array();
//        echo $this->db->last_query();
        return $result;
    }

}
