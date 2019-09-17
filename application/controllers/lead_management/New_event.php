<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class New_event extends CI_Controller{
	function __construct() {
        parent::__construct();
        $this->load->model('lead_management', "lm");
        $this->load->model("system");
    }

    public function index(){
    	$this->load->layout = 'dashboard';
        $title = "Create New Event";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'new_event';
        $render_data['header_title'] = $title;

        $this->load->template('lead_management/create_event', $render_data);
    }

    public function insert_new_event(){
    	// print_r(post());exit;
    	if ($this->lm->insert_new_event(post())) {
            echo 1;
        } else {
            echo 0;
        }
    } 
}

?>