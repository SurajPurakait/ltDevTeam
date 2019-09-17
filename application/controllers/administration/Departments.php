<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("administration");
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index()
    {
        $this->load->layout = 'dashboard';
        $title = "Departments";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'departments';
        $render_data['header_title'] = $title;
        $render_data['department_list'] = $this->administration->get_all_departments();
        $this->load->template('administration/departments', $render_data);
    }

    public function update_departments()
    {
        if ($this->administration->update_departments($this->input->post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

     public function insert_departments()
    {
        if ($this->administration->insert_departments($this->input->post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function delete_department()
    {
        $id = $this->input->post("department_id");
        $result = $this->administration->delete_department($id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function get_department_relations($department_id)
    {
        echo $this->administration->get_department_relations($department_id);
    }

}
