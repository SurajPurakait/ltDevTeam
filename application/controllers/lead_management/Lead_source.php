<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_source extends CI_Controller
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
        $title = "Lead Source";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_source';
        $render_data['header_title'] = $title;
        $render_data["lead_source_list"] = $this->lead_management->get_lead_sources();
        $this->load->template('lead_management/lead_source', $render_data);
    }

    public function add_lead_source()
    {
        $source_name = $this->input->post("source_name");
        $check = $this->lead_management->check_if_lead_source_exists($source_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->lead_management->add_lead_source($source_name)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function edit_lead_source()
    {
        $source_name = $this->input->post("source_name");
        $source_id = $this->input->post("source_id");

        $check = $this->lead_management->check_if_lead_source_exists($source_name, $source_id);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->lead_management->update_lead_source($source_name, $source_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function delete_lead_source()
    {
        $source_id = $this->input->post("source_id");
        if ($this->lead_management->delete_lead_source($source_id)) {
            echo "1";
        } else {
            echo "0";
        }
    }

}


