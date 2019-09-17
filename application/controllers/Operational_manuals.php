<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Operational_manuals extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('system');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('operational_model', "om");
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Operational Manuals Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'operational_manuals';
        $render_data['menu'] = 'operational_manuals_dashboard';
        $render_data['header_title'] = $title;
        $render_data['main_title'] = $this->om->get_main_title();
        
//        print_r($render_data['main_cat']);
        if(!empty($render_data['main_title'])){
            $render_data['operstional_manual_data'] = $this->om->get_operational_manual_data($render_data['main_title'][0]['id'], null);
            $render_data['selected_cat'] = $render_data['main_title'][0]['id'];
        }else{
            $render_data['selected_cat'] = null;
        }
        $render_data['sub_cat'] = $this->om->get_sub_title();
        $render_data['selected_sub_cat'] = null;
        $render_data['clicked'] = 0;
        
        $this->load->template('operational_manuals/dashboard', $render_data);
    }

    public function dashboard($selected_cat, $selected_sub_cat = null,$clicked = 0) {
        $this->load->layout = 'dashboard';
        $title = "Operational Manuals Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'operational_manuals';
        $render_data['menu'] = 'operational_manuals_dashboard';
        $render_data['header_title'] = $title;
        $render_data['main_cat'] = $this->om->get_main_cats();
        $render_data['operstional_manual_data'] = $this->om->get_operational_manual_data($selected_cat, $selected_sub_cat);
        //print_r($render_data['operstional_manual_data']);
        $render_data['selected_cat'] = $selected_cat;
        $render_data['selected_sub_cat'] = $selected_sub_cat;
        $render_data['clicked'] = $clicked;
        $this->load->template('operational_manuals/dashboard', $render_data);
    }

    public function forms(){
       $this->load->layout = 'dashboard';
        $title = "Operational Manuals Forms";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'operational_manuals';
        $render_data['menu'] = 'operational_manuals_forms';
        $render_data['header_title'] = $title;
        $render_data['forms'] = $this->om->get_forms();
        $this->load->template('operational_manuals/forms', $render_data); 
    }

    public function add_forms(){
        $this->load->layout = 'dashboard';
        $title = "Operational Manuals Add Form";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'operational_manuals';
        $render_data['menu'] = 'operational_manuals_forms';
        $render_data['header_title'] = $title;
        $this->load->template('operational_manuals/add_forms', $render_data); 
    }

    public function download_file($filename){
        $this->load->helper('download');
        $filepath = realpath(APPPATH . '../uploads/'.$filename);
        force_download($filepath, NULL);
    }

    public function download_pdf() {

        // $this->load->helper('pdf_helper');
        // $render_data['main_title'] = $this->om->get_main_title();        
        // $this->load->view('operational_manuals/download_pdf', $render_data);

       $this->load->helper('download');
        $filepath = realpath(APPPATH . '../uploads/Version_1-TAXLEAF_manual.pdf');
        force_download($filepath, NULL);
    }

    public function insert_operational_forms(){
        echo $this->om->insert_operational_forms(post());
    }

    public function add_operational_manual() {
        $this->load->layout = 'dashboard';
        $title = "Add Operational Manual";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'operational_manuals';
        $render_data['menu'] = 'operational_manuals_dashboard';
        $render_data['header_title'] = $title;
        $render_data['main_cat'] = $this->om->get_main_cats();
        $this->load->template('operational_manuals/add_operational_manual', $render_data);
    }

    public function get_subcat_by_maincat() {
        $main_cat = request('main_cat');
        $render_data['sub_cat'] = $this->om->get_operational_subcat($main_cat);
        $this->load->view('operational_manuals/sub_category_dropdown', $render_data);
    }

    public function insert_operational_manuals() {
        echo $this->om->insert_operational_manuals(post());
    }

    public function operational_manuals_category() {
        $this->load->layout = 'dashboard';
        $title = "Operational Manuals Main Category";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'operational_manuals';
        $render_data['menu'] = 'operational_manuals_category';
        $render_data['header_title'] = $title;
        $render_data['main_cat_list'] = $this->om->get_main_cats();
        $this->load->template('operational_manuals/main_category', $render_data);
    }

    public function operational_manuals_subcategory() {
        $this->load->layout = 'dashboard';
        $title = "Operational Manuals Sub Category";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'operational_manuals';
        $render_data['menu'] = 'operational_manuals_subcategory';
        $render_data['header_title'] = $title;
        $render_data['sub_cat_list'] = $this->om->get_sub_cats();
        $this->load->template('operational_manuals/sub_category', $render_data);
    }

    public function insert_operational_manuals_category() {
        $main_cat_name = post("main_cat_name");
        $icon = post("icon");
        $check = $this->om->check_if_name_exists($main_cat_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->om->insert_operational_manuals_category($main_cat_name, $icon)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function insert_operational_manuals_title() {
        $title = post("title");
        $desc = post("desc");
        $edit_main_title_id = post('edit_main_title_id');
        if(isset($edit_main_title_id) && $edit_main_title_id!=''){
             $check = $this->om->check_if_name_exists($title, $edit_main_title_id);
            if ($check != 0) {
                echo "0";
            } else {
                if ($this->om->update_operational_manuals_title($title, $desc, $edit_main_title_id)) {
                    echo "1";
                } else {
                    echo "-1";
                }
            }
        }else{
            $check = $this->om->check_if_name_exists($title);
            if ($check != 0) {
                echo "0";
            } else {
                if ($this->om->insert_operational_manuals_title($title, $desc)) {
                    echo "1";
                } else {
                    echo "-1";
                }
            }
        }        
    }

    public function insert_operational_manuals_subcategory() {
        $sub_cat_name = post("sub_cat_name");
        $main_cat_name = post('main_cat_name');
        $check = $this->om->check_if_subname_exists($sub_cat_name, '', $main_cat_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->om->insert_operational_manuals_subcategory($sub_cat_name, $main_cat_name)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function insert_operational_manuals_sub_title() {
        $sub_title = post("title");
        $sub_desc = post('desc');
        $main_title_id = post('main_title_id');
        $edit_sub_title_id = post('edit_sub_title_id');
        if(isset($edit_sub_title_id) && $edit_sub_title_id!=''){
                $check = $this->om->check_if_subname_exists($sub_title, $edit_sub_title_id, '');
                if ($check != 0) {
                    echo "0";
                } else {
                    if ($this->om->update_operational_manuals_sub_title($sub_title, $sub_desc, $edit_sub_title_id)) {
                        echo "1";
                    } else {
                        echo "-1";
                    }
                }
        }else{
           $check = $this->om->check_if_subname_exists($sub_title, '', $main_title_id);
            if ($check != 0) {
                echo "0";
            } else {
                if ($this->om->insert_operational_manuals_sub_title($sub_title, $sub_desc, $main_title_id)) {
                    echo "1";
                } else {
                    echo "-1";
                }
            } 
        }
        
    }

    public function update_operational_manuals_category() {
        $main_cat_name = post("main_cat_name");
        $icon = post("icon");
        $cat_id = post("cat_id");
        $check = $this->om->check_if_name_exists($main_cat_name, $cat_id);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->om->update_operational_manuals_category($main_cat_name, $icon, $cat_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function update_operational_manuals() {       
        
        $description = post("description");
        $title = post("title");
        $manual_id = post("manual_id");

        if ($this->om->update_operational_manuals($title, $description, $manual_id)) {
            echo "1";
        } else {
            echo "-1";
        }
    }

    public function delete_operational_manuals() {
        $om_id = post("id");
        $check_if_associated = $this->om->check_if_associated_sub($om_id);
        if ($check_if_associated < 1) {
            if ($this->om->delete_operational_manuals($om_id)) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
    }

    public function delete_operational_manuals_category() {
        $cat_id = post("cat_id");
        $check_if_associated = $this->om->check_if_associated_main($cat_id);
        $check_if_has_subcat = $this->om->check_if_has_subcat($cat_id);
        if ($check_if_associated < 1 && $check_if_has_subcat < 1) {
            if ($this->om->delete_operational_manuals_category($cat_id)) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
    }

    public function update_operational_manuals_subcategory() {
        $sub_cat_name = post("sub_cat_name");
        $main_cat_name = post('main_cat_name');
        $cat_id = post("cat_id");

        $check = $this->om->check_if_subname_exists($sub_cat_name, $cat_id, '');
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->om->update_operational_manuals_subcategory($sub_cat_name, $main_cat_name, $cat_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function delete_operational_manuals_subcategory() {
        $cat_id = post("cat_id");
        $check_if_associated = $this->om->check_if_associated_sub($cat_id);
        if ($check_if_associated < 1) {
            if ($this->om->delete_operational_manuals_subcategory($cat_id)) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
    }

    public function get_title_data(){
        $id = post('id');
        echo json_encode($this->om->get_title_data($id));
    }
    public function get_sub_title_data(){
        $id = post('id');
        echo json_encode($this->om->get_sub_title_data($id));
    }

    public function check_if_subtitle_exists($id){
        echo $this->om->check_if_subtitle_exists($id);
    }

    public function delete_title(){
        $id = post('id');
        $result = $this->om->delete_title($id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function delete_subtitle(){
         $id = post('id');
        $result = $this->om->delete_subtitle($id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

}

?>