<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referred_source extends CI_Controller
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
        $title = "Referred by Source";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'referred_by_source';
        $render_data['header_title'] = $title;
        $render_data['source_list'] = $this->administration->get_source_list();
        $this->load->template('administration/referred_by_source', $render_data);
    }

    public function add_source_type()
    {
        $source_name = $this->input->post("source_name");

        $check = $this->administration->check_if_source_exists($source_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->administration->add_source_type($source_name)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function edit_source_type()
    {
        $source_name = $this->input->post("source_name");
        $source_id = $this->input->post("source_id");

        $check = $this->administration->check_if_source_exists($source_name, $source_id);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->administration->update_source_type($source_name, $source_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function delete_source_type()
    {
        $source_id = $this->input->post("source_id");
        if ($this->administration->delete_source_type($source_id)) {
            echo "1";
        } else {
            echo "0";
        }
    }

}