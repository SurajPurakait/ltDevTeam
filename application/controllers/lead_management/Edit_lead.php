<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_lead extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("lead_management");
        $this->load->model("system");
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function edit_lead_prospect($id) {
        $render_data["data"] = $this->lead_management->fetch_data($id);
        $render_data["data"]["notes"] = explode(",", $render_data["data"]["notes"]);
        $render_data["type_of_contact"] = $this->lead_management->get_lead_types();
        $render_data["lead_source"] = $this->lead_management->get_lead_sources();
        $render_data["lead_agents"] = $this->lead_management->get_lead_agents();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["languages"] = $this->system->get_languages();
        $this->load->layout = 'dashboard';
        $title = "Edit Prospect";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'lead_management';
        $render_data['menu'] = 'lead_dashboard';
        $render_data['header_title'] = $title;
        $render_data['from_menu'] = 'lead';
        $this->load->template("lead_management/edit_prospect", $render_data);
    }

    public function edit_lead_referral_partner($id) {
        $render_data["data"] = $this->lead_management->fetch_data($id);
        $render_data["data"]["notes"] = explode(",", $render_data["data"]["notes"]);
        $render_data["type_of_contact"] = $this->lead_management->get_lead_types();
        $render_data["lead_source"] = $this->lead_management->get_lead_sources();
        $render_data["lead_agents"] = $this->lead_management->get_lead_agents();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["languages"] = $this->system->get_languages();
        $this->load->layout = 'dashboard';
        $title = "Edit Lead";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'reffer_lead';
        $render_data['header_title'] = $title;
        $this->load->template("referral_partner/edit_lead", $render_data);
    }

    public function edit_lead_referral($id) {
        $render_data["data"] = $this->lead_management->fetch_data($id);
//        print_r($render_data["data"]);die;
//        echo $render_data["data"]['lead_agent'];exit;
        $render_data["data"]["notes"] = explode(",", $render_data["data"]["notes"]);
        $render_data["type_of_contact"] = $this->lead_management->get_lead_referral();
        $render_data["lead_source"] = $this->lead_management->get_lead_sources();
        $render_data["lead_agents"] = $this->lead_management->get_lead_agents();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["languages"] = $this->system->get_languages();
        $this->load->layout = 'dashboard';
        $title = "Edit Lead Referral";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_dashboard';
        $render_data['header_title'] = $title;
        $render_data['from_menu'] = 'lead';
        $this->load->template("lead_management/edit_prospect", $render_data);
    }

    public function edit_lead_prospect_now($lead_id) {
        echo $this->lead_management->edit_lead_prospect_now($lead_id, $this->input->post());
    }

}
