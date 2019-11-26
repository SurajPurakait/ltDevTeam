<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing_materials extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('system');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('Marketing_model', "mm");
        $this->load->model('administration');
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Marketing Materials Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        // $render_data['main_menu'] = 'marketing_materials';
        $render_data['main_menu'] = 'corporate_menu';
        $render_data['menu'] = 'marketing_materials_dashboard';
        $render_data['header_title'] = $title;
        $render_data['main_cat'] = $this->mm->get_main_cats();
        $render_data['sub_cat'] = $this->mm->get_sub_cats();
        $this->load->template('marketing_materials/dashboard', $render_data);
    }

    public function dashboard($selected_cat) {
        $this->load->layout = 'dashboard';
        $title = "Marketing Materials Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'marketing_materials';
        $render_data['menu'] = 'marketing_materials_dashboard';
        $render_data['header_title'] = $title;
        $render_data['main_cat'] = $this->mm->get_main_cats();
        $render_data['sub_cat'] = $this->mm->get_marketing_subcat($selected_cat);
        $render_data['selected_cat'] = $selected_cat;
        $this->load->template('marketing_materials/dashboard_view', $render_data);
    }

    public function marketing_materials_category() {
        $this->load->layout = 'dashboard';
        $title = "Marketing Materials Main Category";
        $render_data['title'] = $title . ' | Tax Leaf';
        // $render_data['main_menu'] = 'marketing_materials';
        $render_data['main_menu'] = 'corporate_menu';
        $render_data['menu'] = 'marketing_materials_category';
        $render_data['header_title'] = $title;
        $render_data['main_cat_list'] = $this->mm->get_main_cats();
        $this->load->template('marketing_materials/main_category', $render_data);
    }

    public function marketing_materials_subcategory() {
        $this->load->layout = 'dashboard';
        $title = "Marketing Materials Sub Category";
        $render_data['title'] = $title . ' | Tax Leaf';
        // $render_data['main_menu'] = 'marketing_materials';
        $render_data['main_menu'] = 'corporate_menu';
        $render_data['menu'] = 'marketing_materials_subcategory';
        $render_data['header_title'] = $title;
        $render_data['sub_cat_list'] = $this->mm->get_sub_cats();
        $this->load->template('marketing_materials/sub_category', $render_data);
    }

    public function marketing_materials_purchase_list() {
        $this->load->layout = 'dashboard';
        $title = "Marketing Materials Purchase List";
        $render_data['title'] = $title . ' | Tax Leaf';
        // $render_data['main_menu'] = 'marketing_materials';
        $render_data['main_menu'] = 'corporate_menu';
        $render_data['menu'] = 'marketing_materials_purchase_list';
        $render_data['header_title'] = $title;
        $render_data['staff_office'] = $this->administration->get_all_office();
        $render_data['main_cat'] = $this->mm->get_main_cats();
        $render_data['staff_list'] = $this->system->get_staff_list();
        $this->load->template('marketing_materials/purchase_list', $render_data);
    }

    public function insert_marketing_materials_category() {
        $main_cat_name = post("main_cat_name");
        $icon = post("icon");
        $check = $this->mm->check_if_name_exists($main_cat_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->mm->insert_marketing_materials_category($main_cat_name, $icon)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function update_marketing_materials_category() {
        $main_cat_name = post("main_cat_name");
        $icon = post("icon");
        $cat_id = post("cat_id");
        $check = $this->mm->check_if_name_exists($main_cat_name, $cat_id);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->mm->update_marketing_materials_category($main_cat_name, $icon, $cat_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function delete_marketing_materials_category() {
        $cat_id = post("cat_id");
        $check_if_associated = $this->mm->check_if_associated_main($cat_id);
        $check_if_has_subcat = $this->mm->check_if_has_subcat($cat_id);
        if ($check_if_associated < 1 && $check_if_has_subcat < 1) {
            if ($this->mm->delete_marketing_materials_category($cat_id)) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
    }

    public function insert_marketing_materials_subcategory() {
        $sub_cat_name = post("sub_cat_name");
        $main_cat_name = post('main_cat_name');
        $check = $this->mm->check_if_subname_exists($sub_cat_name, '', $main_cat_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->mm->insert_marketing_materials_subcategory($sub_cat_name, $main_cat_name)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function update_marketing_materials_subcategory() {
        $sub_cat_name = post("sub_cat_name");
        $main_cat_name = post('main_cat_name');
        $cat_id = post("cat_id");

        $check = $this->mm->check_if_subname_exists($sub_cat_name, $cat_id, '');
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->mm->update_marketing_materials_subcategory($sub_cat_name, $main_cat_name, $cat_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }

    public function delete_marketing_materials_subcategory() {
        $cat_id = post("cat_id");
        $check_if_associated = $this->mm->check_if_associated_sub($cat_id);
        if ($check_if_associated < 1) {
            if ($this->mm->delete_marketing_materials_subcategory($cat_id)) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
    }

    public function load_marketing_materials() {
        $main_cat = request('main_cat');
        $sub_cat = request('sub_cat');
        $render_data['all_materials'] = $this->mm->load_marketing_materials($main_cat, $sub_cat);
        $this->load->view('marketing_materials/marketing_materials_ajax', $render_data);
    }

    public function add_marketing_material() {
        $this->load->layout = 'dashboard';
        $title = "Add Marketing Materials";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'marketing_materials';
        $render_data['menu'] = 'marketing_materials_dashboard';
        $render_data['header_title'] = $title;
        $render_data['main_cat'] = $this->mm->get_main_cats();
        $this->load->template('marketing_materials/add_marketing_material', $render_data);
    }

    public function insert_marketing_materials() {
        echo $this->mm->insert_marketing_materials(post());
    }

    public function get_subcat_by_maincat() {
        $main_cat = request('main_cat');
        $render_data['sub_cat'] = $this->mm->get_subcat_by_maincat($main_cat);
        $this->load->view('marketing_materials/sub_category_dropdown', $render_data);
    }

    public function delete_marketing_materials() {
        $id = post("id");
        if ($this->mm->delete_marketing_materials($id)) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function edit_marketing_material($id) {
        $this->load->layout = 'dashboard';
        $title = "Edit Marketing Materials";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'marketing_materials';
        $render_data['header_title'] = $title;
        $render_data["data"] = $this->mm->fetch_data($id);
        $render_data["for_which"] = $this->mm->fetch_for_which($id);
        $render_data["language"] = $this->mm->fetch_language($id);
        $render_data["dynamic_price_quantity"] = $this->mm->fetch_dynamic_price_quantity($id);
        $render_data['menu'] = 'marketing_materials_dashboard';
        $render_data['main_cat'] = $this->mm->get_main_cats();
        $render_data['sub_cat'] = $this->mm->get_sub_cats_by_main($render_data['data']['main_cat']);
        $this->load->template('marketing_materials/edit_marketing_material', $render_data);
    }

    public function update_marketing_materials() {
        $mkt_id = post('id');
        echo $this->mm->update_marketing_materials($mkt_id, post());
    }

    public function add_to_cart() {
        $mkt_id = post('id');
        $quantity = post('quantity');
        $lang = post('lang');
        $price_type = post('pricetype');
        $this->mm->add_to_cart($mkt_id, $quantity, $lang, $price_type);
        echo $this->mm->cart_count();
    }

    public function change_quantity() {
        $cart_id = post('id');
        $quantity = post('quantity');
        $this->mm->change_quantity($cart_id, $quantity);
        $result1 = $this->mm->updated_itemval($cart_id);
        $cart_data = $this->mm->fetch_cart_data();
        if(!empty($cart_data)){
            $quan = 0;
            $total = 0;
            foreach($cart_data as $key=>$cd){
                $quan += $cd['quantity'];
                $marketing_id = $cd['material_id'];
                 $itemprice = $cd['price'];
                 $total += $cd['price']*$cd['quantity'];
            }
            $check_if_discount = check_if_discount($quan,$marketing_id);
            if(!empty($check_if_discount)){
                    $dis_quan = $check_if_discount['quantity'];
                    $dis_price = $check_if_discount['price'];
                    // $remain_quan = $quan - $dis_quan;
                    // $price_dis_new = $dis_price*$dis_quan;
                    // $price_old = $itemprice*$remain_quan;
                    $result2['total_cart_price'] = $dis_price*$quan;
                }else{
                    $result2['total_cart_price'] = $total;
                }
        }
        echo json_encode(array_merge($result1,$result2));
    }

    public function view_cart() {
        $this->load->layout = 'dashboard';
        $title = "Cart Marketing Materials";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'marketing_materials';
        $render_data['header_title'] = $title;
        $render_data["cart_data"] = $this->mm->fetch_cart_data();
        $render_data['menu'] = 'marketing_materials_dashboard';
        $this->load->template('marketing_materials/cart_marketing_material', $render_data);
    }

    public function proceed_to_checkout() {
        $this->load->layout = 'dashboard';
        $title = "Checkout Marketing Materials";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'marketing_materials';
        $render_data['header_title'] = $title;
        $render_data["cart_data"] = $this->mm->fetch_cart_data();
        $render_data['menu'] = 'marketing_materials_dashboard';
        $this->load->template('marketing_materials/checkout_marketing_material', $render_data);
    }

    public function pay_with_paypal() {
        $render_data['formdata'] = post();
        $render_data["cart_data"] = $this->mm->fetch_cart_data();
        $this->load->view('marketing_materials/paypal_marketing_material', $render_data);
    }

    public function load_marketing_materials_purchase_list() {
        $type = post('type');
        $main_cat = post('main_cat');
        $sub_cat = post('sub_cat');
        $ofc = post('ofc');
        $staff = post('staff');
        $render_data['all_list'] = $this->mm->load_marketing_materials_purchase_list($type, $main_cat, $sub_cat, $ofc, $staff);
        $this->load->view('marketing_materials/marketing_materials_purchase_list_ajax', $render_data);
    }

    public function remove_from_cart() {
        $mkt_id = post('id');
        $this->mm->remove_from_cart($mkt_id);
        echo $this->mm->total_cart_price();
    }

    public function updatePurchaseStatus() {
        $status = post('status');
        $id = post('id');
        $this->mm->updatePurchaseStatus($status, $id);
        echo '1';
    }

    public function updateSuggestionStatus() {
        $status = post('status');
        $id = post('id');
        $this->mm->updateSuggestionStatus($status, $id);
        echo '1';
    }

    public function addNotesmodal() {
        $notes = post('marketing_note');
        $id = post('marketingid');
        $this->load->model('notes');
        if (!empty($notes)) {
            $this->notes->insert_note(6, $notes, "marketing_id", $id, 'marketing');
        }
        redirect(base_url() . 'marketing_materials');
    }

    public function addSuggestionsmodal() {
        $suggestions = post('marketing_suggestion');
        if (!empty($suggestions)) {
            $this->mm->insert_suggestions($suggestions);
        }
        redirect(base_url() . 'marketing_materials');
    }

    public function marketing_materials_suggestions() {
        $this->load->layout = 'dashboard';
        $title = "Suggestions";
        $render_data['title'] = $title . ' | Tax Leaf';
        // $render_data['main_menu'] = 'marketing_materials';
        $render_data['main_menu'] = 'corporate_menu';
        $render_data['menu'] = 'marketing_materials_suggestions';
        $render_data['header_title'] = $title;
        $render_data['suggestions'] = $this->mm->marketing_materials_suggestions();
        $this->load->template('marketing_materials/suggestions', $render_data);
    }

    public function addCartNotesmodal() {
        $notes = post('marketing_note');
        $id = post('cartid');
        $this->load->model('notes');
        if (!empty($notes)) {
            $this->notes->insert_note(7, $notes, "cart_id", $id, 'cart');
        }
        redirect(base_url() . 'marketing_materials/view_cart');
    }

    public function updateNotes() {
        if (!empty(post('notes'))) {
            $this->load->model('Notes');
            $this->Notes->updateNotes(post(), post('notestable'));
            redirect(base_url() . 'marketing_materials');
        } else {
            redirect(base_url() . 'marketing_materials');
        }
    }

    public function get_marketing_subcat() {
        $main_cat_id = post('main_cat_id');
        $render_data['sub_cat'] = $this->mm->get_marketing_subcat($main_cat_id);
        $this->load->view('marketing_materials/marketing_subcat', $render_data);
    }

}
