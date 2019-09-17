<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_services extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Partner Services";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'services';
        $render_data['menu'] = 'partner_services';
        $render_data['header_title'] = $title;
        $this->load->template('services/partner_services', $render_data);
    }

}

?>