<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_service_setup extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('administration');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index()
    {
        $this->load->layout = 'dashboard';
        $title = "Partner Service Setup";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'partner_service_setup';
        $render_data['header_title'] = $title;
        $render_data['partner_service_list'] = $this->administration->get_partner_service_list();
        $this->load->template('administration/partner_service_setup', $render_data);
    }

    public function add_partner_service() {
        $servicename = $this->input->post("description");
        $check = $this->administration->check_if_partner_service_name_exists($servicename);

        if ($check != 0) {
            echo "0";
        } else {
            echo $this->administration->add_partner_service(post());    
        }
    }

    public function update_partner_service() {
        $servicename = $this->input->post("description");
        $id = $this->input->post("id");
        $check = $this->administration->check_if_partner_service_name_exists_at_update($servicename,$id);

        if ($check != 0) {
            echo "0";
        } else {
            echo $this->administration->update_partner_service(post());
        }
    }

    public function change_partner_service_status() {
        echo $this->administration->change_partner_service_status(post());
    }
}    