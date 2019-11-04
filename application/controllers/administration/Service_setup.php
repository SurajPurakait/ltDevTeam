<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service_setup extends CI_Controller
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
        $title = "Service Setup";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'service_setup';
        $render_data['header_title'] = $title;
        $render_data['service_list'] = $this->administration->get_service_list();
        $this->load->template('administration/service_setup', $render_data);
    }

    public function get_related_services()
    {
        $id = $this->input->post("id");
        //$related_services = $this->administration->get_related_services($id);

        $array = [];
        if ($this->input->post("prev") != "") {
            $array = explode(",", $this->input->post("prev"));
        }
        if($this->input->post("current") != ""){
            $related_services = $this->administration->get_related_services_without_catwise($this->input->post("current"));
        }else{
           $related_services = $this->administration->get_related_services_without_catwise(); 
        }
        $service_html = "";
        foreach ($related_services as $value) {
            in_array($value["id"], $array) ? $flag = "selected" : $flag = "";
            $service_html .= "<option value='{$value["id"]}'" . $flag . ">" . $value["description"] . "</option>";
        }
        echo $service_html;
    }

    public function add_related_service()
    {
        $servicename = $this->input->post("servicename");
        $check = $this->administration->check_if_name_exists($servicename);
        // echo $check;exit;
        if ($check != 0) {
            echo "0";
            // return;
        } else {
            $retailprice = $this->input->post("retailprice");
            $servicecat = $this->input->post("servicecat");
            $relatedserv = $this->input->post("relatedserv");
            $startdays = $this->input->post("startdays");
            $dept = $this->input->post("dept");
            $enddays = $this->input->post("enddays");
            $input_form = $this->input->post("input_form");
            $shortcode = $this->input->post("shortcode");
            $note = $this->input->post('note');
            $fixedcost = $this->input->post('fixedcost');

            echo $this->administration->add_related_services($servicename, $retailprice, $servicecat, $relatedserv, $startdays, $enddays, $dept, $input_form, $shortcode,$note,$fixedcost);

        }
    }

    public function update_related_service()
    {
        $servicename = $this->input->post("servicename");
        $service_id = $this->input->post("id");
        $check = $this->administration->check_if_name_exists($servicename, $service_id);
        if ($check != 0) {
            echo "0";
            // return;
        } else {
            $retailprice = $this->input->post("retailprice");
            $servicecat = $this->input->post("servicecat");
            $relatedserv = $this->input->post("relatedserv");
            $startdays = $this->input->post("startdays");
            $dept = $this->input->post("dept");
            $enddays = $this->input->post("enddays");
            $input_form = $this->input->post("input_form");
            $shortcode = $this->input->post("shortcode");
            $note = $this->input->post('note');
            $fixedcost = $this->input->post('fixedcost');
            // echo $fixedcost;exit;
            echo $this->administration->update_related_services($service_id, $servicename, $retailprice, $servicecat, $relatedserv, $startdays, $enddays, $dept, $input_form, $shortcode,$note, $fixedcost);

        }
    }

    public function delete_service_controller()
    {
        $id = $this->input->post("service_id");
        $result = $this->administration->delete_service($id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function get_service_relations($service_id)
    {
        echo $this->administration->get_service_relations($service_id);
    }

}
