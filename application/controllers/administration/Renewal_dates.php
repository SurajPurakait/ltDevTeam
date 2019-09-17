<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Renewal_dates extends CI_Controller {
    
    function __construct() {
        parent::__construct();
       $this->load->model('administration');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }
    
    
    function index() {
        
        $this->load->layout = 'dashboard';
        $title = "Renewal Dates";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'renewal dates';
        $render_data['header_title'] = $title;
        $render_data['renewal_dates'] = $this->administration->get_renewal_dates();
//        print_r($render_data);die;
        $this->load->template('administration/renewal_dates', $render_data);
    }
    
    function add_renewal_dates() {
       
        $data = array(
            'state'=>$this->input->post('state'),
            'type' => $this->input->post("type"),
            'date' => $this->input->post('start_year')
        );
       if ($this->administration->add_renewal_dates($data)) {
            echo "1";
        } else {
            echo "-1";
        }
    }
    function edit_renewal_dates() {
       
        $client_id=$this->input->post('client_id');

        $data = array(
            'state'=>$this->input->post('state'),
            'type' => $this->input->post("type"),
            'date' => $this->input->post('start_year')
        );
        if ($this->administration->update_renewal_dates($data,$client_id)) {
            echo "1";
        } else {
            echo "-1";
        }
    }
    function delete_renewal_dates(){
        
        $client_id = $this->input->post("client_id");
        if ($this->administration->delete_renewal_dates($client_id)) {
            echo "1";
        } else {
            echo "0";
        }
    }

    
    
    
    
    
    
    
}