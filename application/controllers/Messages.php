<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('system');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('message_model');
    }

    public function index($message_type = 2) {
        $this->load->layout = 'dashboard';
        $title = "Messages";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'messages';
        if ($message_type != 2 && $message_type != 3) {
            $message_type = 2;
        }
        $render_data['menu'] = 'messages_' . $message_type;
        $render_data['header_title'] = $title;
        $render_data['message_type'] = $message_type;
        $render_data['message_type_name'] = $message_type == 2 ? 'Corporate' : 'Franchise';
        $render_data['message_list'] = $this->message_model->get_message_list($message_type);
        $this->load->template('messages', $render_data);
    }

    public function save_message() {
        if ($this->message_model->request_save_message(post('message'))) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function read_message() {
        if ($this->message_model->read_message(sess('user_id'), post('message_id'))) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
