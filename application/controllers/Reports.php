<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function index($type = 1) {
        $this->load->layout = 'dashboard';
        $title = "Manage Reports";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'reports';
        $render_data['menu'] = 'report_' . $type;
        $render_data['header_title'] = $title;
        $this->load->template('reports/reports', $render_data);
    }

}
