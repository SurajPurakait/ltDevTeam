
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referral_agent_type extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('lead_management');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    // public function index()
    // {
    //     $this->load->layout = 'dashboard';
    //     $title = "Referral Agent Type";
    //     $render_data['title'] = $title . ' | Tax Leaf';
    //     $render_data['main_menu'] = 'leads';
    //     $render_data['menu'] = 'referral_agent_type';
    //     $render_data['header_title'] = $title;
    //     $render_data["lead_agent_list"] = $this->lead_management->get_lead_referral();
    //     $this->load->template('lead_management/referral_agent_type', $render_data);
    // }

    // public function add_ref()
    // {
    //     $ref_name = $this->input->post("ref_name");
    //     $check = $this->lead_management->check_if_ref_exists($ref_name);
    //     if ($check != 0) {
    //         echo "0";
    //     } else {
    //         if ($this->lead_management->add_ref_type($ref_name)) {
    //             echo "1";
    //         } else {
    //             echo "-1";
    //         }
    //     }
    // }

    // public function edit_ref()
    // {
    //     $ref_name = $this->input->post("ref_name");
    //     $ref_id = $this->input->post("ref_id");

    //     $check = $this->lead_management->check_if_ref_exists($ref_name, $ref_id);
    //     if ($check != 0) {
    //         echo "0";
    //     } else {
    //         if ($this->lead_management->update_ref_type($ref_name, $ref_id)) {
    //             echo "1";
    //         } else {
    //             echo "-1";
    //         }
    //     }
    // }

    // public function delete_ref()
    // {
    //     $ref_id = $this->input->post("lead_id");
    //     if ($this->lead_management->delete_ref_type($ref_id)) {
    //         echo "1";
    //     } else {
    //         echo "0";
    //     }
    // }

}

