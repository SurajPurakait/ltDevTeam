<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company_type extends CI_Controller
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
        $title = "Company Type";
        $render_data['title'] = $title . ' | Tax Leaf';
        // $render_data['main_menu'] = 'administration';
        $render_data['main_menu'] = 'clients';
        $render_data['menu'] = 'company_type';
        $render_data['header_title'] = $title;
        $render_data['company_list'] = $this->administration->get_company_list();
        $this->load->template('administration/company_type', $render_data);
    }

    public function add_company_type()
    {
        $company_name = $this->input->post("company_name");

        $check = $this->administration->check_if_company_exists($company_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->administration->add_company_type($company_name)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function edit_company_type()
    {
        $company_name = $this->input->post("company_name");
        $company_id = $this->input->post("company_id");

        $check = $this->administration->check_if_company_exists($company_name, $company_id);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->administration->update_company_type($company_name, $company_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function delete_company_type()
    {
        $company_id = $this->input->post("company_id");
        if ($this->administration->delete_company_type($company_id)) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function get_company_relations($company_id)
    {
        echo $this->administration->get_company_relations($company_id);
    }

}