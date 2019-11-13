<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('lead_management', "lm");
        $this->load->model("system");
        $this->filter_element = [
            1 => "Event Name",
            2 => "Office",
            3 => "Date",
            4 => "Location"
        ];
    }

    public function index($office_id=""){
    	$this->load->layout = 'dashboard';
        $title = "Event Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'events';
        $render_data['menu'] = 'events_dashboard';
        $render_data['header_title'] = $title;

        $render_data['event_details'] = $this->lm->get_event_details($office_id);
        $render_data['filter_element_list'] = $this->filter_element;
        // $render_data['office_id'] = $office_id;

        $this->load->template('lead_management/event_dashboard', $render_data);
    }

    public function dashboard_ajax() {
        $render_data["event_list"] = $this->lm->get_event_details();
        // $render_data['lead_event'] = $this->lm->get_lead_event();

        $render_data["prospect_list"] = $this->lm->get_prospects();

        $this->load->view("lead_management/ajax_dashboard_event", $render_data);
    }

    public function view($id = ''){
        $this->load->layout = 'dashboard';
        $title = "View Events Details";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_dashboard';
        $render_data['header_title'] = $title;
        $render_data["events_list"] = $this->lm->get_event_details_by_id($id);
        $this->load->template("lead_management/view_event_details",$render_data);
    }

    public function edit_event($id = ''){
        $this->load->layout = 'dashboard';
        $title = "Edit Event";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        $render_data['menu'] = 'lead_dashboard';
        $render_data['header_title'] = $title;
        $render_data['from_menu'] = 'lead';

        $render_data["events_data"] = $this->lm->get_event_details_by_id($id);
        
        $this->load->template("lead_management/edit_event", $render_data);
    }

    public function update_event($id){
        if($this->input->post("lead_id") != ""){
        $leadid = implode(",",$this->input->post("lead_id"));
    }else{
         $leadid ="";
    }
        if($this->lm->update_event($id, $this->input->post(),$leadid)){
            echo 1;
        }else{
            echo 0;
        } 
    }
    

    public function create_event(){
        $this->load->layout = 'dashboard';
        $title = "Create New Event";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'events';
        $render_data['menu'] = 'events_dashboard';
        $render_data['header_title'] = $title;

        $this->load->template('lead_management/create_event', $render_data);
    }

    public function insert_new_event(){
        
        // $id = implode(",",$this->input->post("lead_id"));
        if($this->input->post("lead_id") != ""){
         $id = implode(",",$this->input->post("lead_id"));
        }else{
            $id ="";
        }
        // echo $id;exit;
        if ($this->lm->insert_new_event($id,post())) {
            echo 1;
        } else {
            echo 0;
        }
    }


    public function save_add_leads_modal(){
        // print_r(post());die;
        echo $this->lm->save_add_leads_modal(post());
    }


    public function update_addlead_modal($id){
        // echo $id;exit;
        echo $this->lm->update_addlead_modal($id,post());
    }


    public function leads_list() {
       
         // echo $this->input->post('id');exit;
        $render_data['lead_info_list'] = $this->lm->get_addleads_information($this->input->post('id'));
        $this->load->view('lead_management/add_leads_info', $render_data);
    }


    public function show_event_edit_details($id){
    
        $this->load->layout = 'dashboard';
        $title = "Edit New Event";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'events';
        $render_data['menu'] = 'events_dashboard';
        $render_data['header_title'] = $title;

        $render_data['eventdetails'] = $this->lm->get_event_details_by_id($id);
        $render_data['lead_list_details'] = $this->lm->get_addlead_details_by_id($id);
        // print_r($render_data['lead_list_details']);exit;
         $this->load->template('lead_management/event_edit_page', $render_data);

    }

    public function filter_dropdown_option_event_dashboard() {
        $result['element_key'] = $element_key = post('variable');
        $result['condition'] = '';
        if (post('condition')) {
            $result['condition'] = post('condition');
        }
        // $office = '';
        // if (post('office')) {
        //     $office = post('office');
        // }
        $result['element_array'] = $this->filter_element;
        // $result['element_value_list'] = $this->lead_management->get_lead_filter_element_value($element_key, $office);
         $result['element_value_list'] = $this->lm->get_event_filter_element_value($element_key);
        $this->load->view('lead_management/filter_dropdown_option_event_dashboard', $result);
    }

    public function event_filter() {
       
        $render_data["event_details"] = $this->lm->get_event_list('',post());
        $this->load->view("lead_management/event_ajax_dashboard", $render_data);
    }

}

?>    