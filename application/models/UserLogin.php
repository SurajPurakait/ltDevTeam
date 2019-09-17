<?php

Class UserLogin extends CI_Model {

    function login($username, $password) {

        $this->db->select('id, security_level, status');
        $this->db->from('staff');
        $this->db->where('user', $username);
        $this->db->where('password', MD5($password));
        $this->db->limit(1);

        $query = $this->db->get();
        $result = $query->result_array()[0];
//        print_r($result);exit;
        if ($query->num_rows() == 1) {
            $this->session->set_userdata('user_id', $result['id']);
            $id = $result['id'];
            $get_office = $this->db->query("select * from office_staff where staff_id='$id'")->result_array();
            $this->session->set_userdata('user_office_id', $get_office[0]['office_id']);
            $this->session->set_userdata('security_level', $result['security_level']);
            $this->session->set_userdata('login', "ok");
            $this->load->model('Service');
            $this->Service->updateLateStatus();
            $this->load->model('System');
            $this->System->log('login', 'staff', $result['id']);
            return true;
        } else {
            return false;
        }
    }

    function logout() {
        $this->load->model('System');
        $this->System->log('logout', 'staff', $this->session->userdata('user_id'));
        $this->session->unset_userdata(['user_id', 'user_office_id', 'security_level', 'login']);
    }

}
?>

