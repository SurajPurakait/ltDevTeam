<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_type extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('lead_management');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index()
    {
        $this->load->layout = 'dashboard';
        $title = "Lead Type";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_type';
        $render_data['header_title'] = $title;
        $render_data["lead_type_list"] = $this->lead_management->get_lead_types();
        $this->load->template('lead_management/lead_type', $render_data);
    }

    public function add_lead_type()
    {
        $lead_type_name = $this->input->post("lead_name");
        $check = $this->lead_management->check_if_type_exists($lead_type_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->lead_management->add_lead_type($lead_type_name)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function edit_lead_type()
    {
        $lead_type_name = $this->input->post("lead_name");
        $lead_id = $this->input->post("type_id");

        $check = $this->lead_management->check_if_type_exists($lead_type_name, $lead_id);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->lead_management->update_lead_type($lead_type_name, $lead_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function delete_lead_type()
    {
        $lead_id = $this->input->post("lead_id");
        if ($this->lead_management->delete_lead_type($lead_id)) {
            echo "1";
        } else {
            echo "0";
        }
    }

}

