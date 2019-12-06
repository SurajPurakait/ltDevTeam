    <?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Office extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('staff');
        $this->load->model('administration');
        $this->load->model('system');
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index() {
        $this->load->layout = 'dashboard';
        $title = "Offices";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        // $render_data['main_menu'] = 'franchisee_menu';
        $render_data['menu'] = 'franchise';
        $render_data['header_title'] = $title;
        $render_data['get_staff'] = $this->staff->get_staff($this->session->userdata('user_id'));
        $render_data['staff_info'] = $this->staff->get_staff_info($this->session->userdata('user_id'));
        $render_data['franchise_list'] = $this->administration->get_all_office();
        $this->load->template('administration/franchise', $render_data);
    }

    public function insert_franchise() {
        $data = post();
        if ($_FILES['photo']) {

            $photo = common_upload('photo');
            if ($photo['success'] == 1) {
                $data['photo'] = $photo['status_msg'];
            }
        }
        if ($this->administration->insert_franchise($data)) {

            echo 1;
        } else {
            echo 0;
        }
    }

    public function update_franchise() {
        $data = post();
        if ($_FILES['photo']) {

            $photo = common_upload('photo');
            if ($photo['success'] == 1) {
                $data['photo'] = $photo['status_msg'];
            }
        }
        if ($this->administration->update_franchise($data)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function save_service_fees(){
        $result = $this->administration->insert_service_fees(post());
        if($result){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function delete_franchise($id) {
        $this->administration->delete_franchise($id);
        redirect(base_url() . 'administration/office');
    }

    public function get_office_relations($office_id) {

        echo $this->administration->get_office_relations($office_id);
    }

    public function delete_office() {
        $id = $this->input->post("office_id");
        
        $result = $this->administration->delete_office($id);
        if ($result == 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function deactivate_office(){
     $id = $this->input->post("office_id");      
    $this->administration->deactivate_office($id);
    }

    
    public function get_office_staff() {
        $office_id = post("office_id");
        $result = $this->administration->get_office_staff_by_office_id($office_id);
        echo "<option value=''>Select an option</option>";
        foreach ($result as $st) {
            $select = (in_array($office_id, explode(",", $st["office_manager"]))) ? "selected='selected'" : "";
            echo "<option {$select} value='{$st['id']}'>{$st['name']}</option>";
        }
    }

    public function save_office_manager() {
        $office_id = post("office_id");
        $staff_id = post("staff_id");
        $this->administration->save_office_staff_manager($staff_id, $office_id);
    }


    public function show_office_edit_info($edit_id) {
        // $render_data['modal_type'] = $this->input->post('modal_type');
        // $render_data['state_list'] = $this->system->get_all_state();
        // $render_data['office_type_list'] = $this->administration->get_all_office_type();
        // $render_data['office_list'] = $this->administration->get_all_office();
        // if ($render_data['modal_type'] == "edit") {
        //     $render_data['franchise_info'] = $this->administration->get_office_by_id($this->input->post('franchise_id'));
        //     $render_data['office_staff'] = $this->administration->get_all_office_staff_by_office_id(post("franchise_id"));
        // }
        $this->load->layout = 'dashboard';
        $title = "Offices";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'administration';
        $render_data['menu'] = 'franchise';
        $render_data['header_title'] = $title;
        $render_data['state_list'] = $this->system->get_all_state();
        $render_data['office_type_list'] = $this->administration->get_all_office_type();
        $render_data['office_list'] = $this->administration->get_all_office();
        $render_data['franchise_info'] = $this->administration->get_office_by_id($edit_id);
        $render_data['office_staff'] = $this->administration->get_all_office_staff_by_office_id($edit_id);
        // $render_data['info_service'] = $this->administration->get_service_fees_list($edit_id);
        $render_data['info_service_list'] = $this->administration->get_service_list();
        $this->load->template('administration/edit_office_information', $render_data);
    }

    // public function servicelist_dropdown_option_ajax(){

    //     $result['element_key'] = $element_key = post('variable');
    //     // $result['condition'] = '';
    //     // if (post('condition')) {
    //     //     $result['condition'] = post('condition');
    //     // }
    //     // $office = '';
    //     // if (post('office')) {
    //     //     $office = post('office');
    //     // }
    //     if (post('dashboard_type')) {
    //         $result['element_array'] = $this->sales_tax_filter_element;
    //         $result['element_value_list'] = $this->action_model->get_salestax_filter_element_value($element_key);
    //     } else {
    //         $result['element_array'] = $this->filter_element;
    //         $result['element_value_list'] = $this->action_model->get_action_filter_element_value($element_key, $office);
    //     }
    //     $this->load->view('action/filter_dropdown_option_ajax', $result);
    // }

}
