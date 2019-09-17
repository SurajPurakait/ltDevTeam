<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Training_materials extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('system');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('videos_model', "vm");
    }

    public function index($visible_by = '2') {
        $this->load->layout = 'dashboard';
        $title = "Training Materials Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'training_materials';
        $render_data['menu'] = 'training_materials_dashboard_' . $visible_by;
        $render_data['header_title'] = $title;
        $render_data['main_cat'] = $this->vm->get_main_cats();
        $render_data['sub_cat'] = $this->vm->get_sub_cats();
        $render_data['visible_by'] = $visible_by;
        $this->load->template('training_materials/dashboard', $render_data);
    }

    public function dashboard($visible_by = '2', $selected_cat) {
        $this->load->layout = 'dashboard';
        $title = "Training Materials Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'training_materials';
        $render_data['menu'] = 'training_materials_dashboard_' . $visible_by;
        $render_data['header_title'] = $title;
        $render_data['main_cat'] = $this->vm->get_main_cats();
        $render_data['sub_cat'] = $this->vm->get_training_subcat($selected_cat);
        $render_data['visible_by'] = $visible_by;
        $render_data['selected_cat'] = $selected_cat;
        $this->load->template('training_materials/dashboard_view', $render_data);
    }

    public function add_training_material($visible_by = '') {
        $this->load->layout = 'dashboard';
        $title = "Add Training Materials";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'training_materials';
        $render_data['menu'] = 'training_materials_dashboard_' . $visible_by;
        $render_data['header_title'] = $title;
        $render_data['visible_by'] = $visible_by;
        $render_data['main_cat'] = $this->vm->get_main_cats();
        $this->load->template('training_materials/add_training_material', $render_data);
    }

    public function edit_training_material($id) {
        $this->load->layout = 'dashboard';
        $title = "Edit Training Materials";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'training_materials';
        $render_data['header_title'] = $title;
        $render_data["data"] = $this->vm->fetch_data($id);
        $visible_by = $render_data["data"]['visible_by'];
        $render_data['menu'] = 'training_materials_dashboard_' . $visible_by;
        $render_data['main_cat'] = $this->vm->get_main_cats();
        $render_data['sub_cat'] = $this->vm->get_sub_cats_by_main($render_data['data']['main_cat']);
        $render_data["file_data"] = $this->vm->fetch_file_data($id);
        $render_data["user_type"] = $this->vm->fetch_user_type($id);
        $this->load->template('training_materials/edit_training_material', $render_data);
    }

    public function training_materials_category() {
        $this->load->layout = 'dashboard';
        $title = "Training Materials Main Category";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'training_materials';
        $render_data['menu'] = 'training_materials_category';
        $render_data['header_title'] = $title;
        $render_data['main_cat_list'] = $this->vm->get_main_cats();
        $this->load->template('training_materials/main_category', $render_data);
    }

    public function insert_training_materials_category() {
        $main_cat_name = post("main_cat_name");
        $icon = post("icon");
        $check = $this->vm->check_if_name_exists($main_cat_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->vm->insert_training_materials_category($main_cat_name, $icon)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function update_training_materials_category() {
        $main_cat_name = post("main_cat_name");
        $icon = post("icon");
        $cat_id = post("cat_id");
        $check = $this->vm->check_if_name_exists($main_cat_name, $cat_id);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->vm->update_training_materials_category($main_cat_name, $icon, $cat_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function delete_training_materials_category() {
        $cat_id = post("cat_id");
        $check_if_associated = $this->vm->check_if_associated_main($cat_id);
        $check_if_has_subcat = $this->vm->check_if_has_subcat($cat_id);
        if ($check_if_associated < 1 && $check_if_has_subcat < 1) {
            if ($this->vm->delete_training_materials_category($cat_id)) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
    }

    public function training_materials_subcategory() {
        $this->load->layout = 'dashboard';
        $title = "Training Materials Sub Category";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'training_materials';
        $render_data['menu'] = 'training_materials_subcategory';
        $render_data['header_title'] = $title;
        $render_data['sub_cat_list'] = $this->vm->get_sub_cats();
        $this->load->template('training_materials/sub_category', $render_data);
    }

    public function insert_training_materials_subcategory() {
        $sub_cat_name = post("sub_cat_name");
        $main_cat_name = post('main_cat_name');
        $check = $this->vm->check_if_subname_exists($sub_cat_name, '', $main_cat_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->vm->insert_training_materials_subcategory($sub_cat_name, $main_cat_name)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function update_training_materials_subcategory() {
        $sub_cat_name = post("sub_cat_name");
        $main_cat_name = post('main_cat_name');
        $cat_id = post("cat_id");
        $check = $this->vm->check_if_subname_exists($sub_cat_name, $cat_id, '');
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->vm->update_training_materials_subcategory($sub_cat_name, $main_cat_name, $cat_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function delete_training_materials_subcategory() {
        $cat_id = post("cat_id");
        $check_if_associated = $this->vm->check_if_associated_sub($cat_id);
        if ($check_if_associated < 1) {
            if ($this->vm->delete_training_materials_subcategory($cat_id)) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
    }

    public function get_subcat_by_maincat() {
        $main_cat = request('main_cat');
        $render_data['sub_cat'] = $this->vm->get_subcat_by_maincat($main_cat);
        $this->load->view('training_materials/sub_category_dropdown', $render_data);
    }

    public function insert_training_materials() {
        echo $this->vm->insert_training_materials(post());
    }

    public function load_videos() {
        $title = request('title');
        $keywords = request('keywords');
        $main_cat = request('main_cat');
        $sub_cat = request('sub_cat');
        $visible_by = request('visible_by');
        $render_data['all_videos'] = $this->vm->load_videos($title, $keywords, $main_cat, $sub_cat, $visible_by);
        $this->load->view('training_materials/training_materials_ajax', $render_data);
    }

    public function update_training_materials() {
        $videos_id = post('id');
        echo $this->vm->update_training_materials($videos_id, post());
    }

    public function delete_training_materials() {
        $id = post("id");
        if ($this->vm->delete_training_materials($id)) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function count_views() {
        echo $this->vm->add_count_views(request('training_material_id'));
    }

    public function sort_training_materials() {
        $sort_order = post('sort_order');
        $sort_order_new = post('sort_order_new');
        $current_item = post('current_item');
        echo $this->vm->sort_training_materials($sort_order, $sort_order_new, $current_item);
    }

    public function addSuggestionsmodal() {
        $suggestions = post('training_suggestion');
        if (!empty($suggestions)) {
            $this->vm->insert_suggestions($suggestions);
        }
        redirect(base_url() . 'training_materials/index/2');
    }

    public function training_materials_suggestions() {
        $this->load->layout = 'dashboard';
        $title = "Suggestions";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'training_materials';
        $render_data['menu'] = 'training_materials_suggestions';
        $render_data['header_title'] = $title;
        $render_data['suggestions'] = $this->vm->training_materials_suggestions();
        $this->load->template('training_materials/suggestions', $render_data);
    }

    public function get_training_subcat() {
        $main_cat_id = post('main_cat_id');
        $render_data['sub_cat'] = $this->vm->get_training_subcat($main_cat_id);
        $this->load->view('training_materials/training_subcat', $render_data);
    }

}
