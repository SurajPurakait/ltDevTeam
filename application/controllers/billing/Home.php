<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $filter_element;
    private $sorting_element;

    function __construct() {
        parent::__construct();
        if (!sess('user_id') && sess('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('system');
        $this->load->model('administration');
        $this->load->model('billing_model');
        $this->filter_element = [
            1 => "ID",
//            2 => "Order ID",
            3 => "Tracking",
            4 => "Office",
            5 => "Client Type",
            6 => "Status",
            7 => "Creation Date",
            8 => "Requested By",
            9 => "Client ID",
            10 => "Service Name",
            11 => "Request Type",
            12 => "Due Date"
        ];
        $this->sorting_element = [
            "invoice_id" => "ID",
//            "order_id" => "Order ID",
            "status" => "Tracking",
            "officeid" => "Office ID",
            "invoice_type" => "Invoice Type",
            "payment_status" => "Status",
            "created_time" => "Creation Date",
            "created_by" => "Requested By",
            "client_name" => "Client Name"
        ];
        asort($this->sorting_element);
    }

    public function index($is_recurrence='',$status = '', $office_id = '',$pattern='') {
        $this->load->layout = 'dashboard';
        $render_data['main_menu'] = 'billing';
        if($is_recurrence=='y'){
            $title = "Recurring Invoice";
            $render_data['menu'] = 'recurring_invoice';
        }else{
            $client_id_r = base64_decode($is_recurrence);
            $pattern_r = base64_decode($pattern);
            if (!empty($client_id_r)) {
                $render_data['client_id_r'] = $client_id_r;
                $render_data['pattern_r'] = $pattern_r;
            }else {
                $render_data['client_id_r'] = '';
                $render_data['pattern_r'] = '';
            }
            $title = "Invoice Dashboard";
            $render_data['menu'] = 'billing_dashboard';
        }
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['header_title'] = $title;
        $render_data['page_heading'] = 'Billing Dashboard';
        if($is_recurrence =='y'){
            $is_recurrence ='y';
        }else{
            $is_recurrence ='';
        }
        if ($status == 0) {
            $status = '';
        }
        if ($office_id == 0) {
            $office_id = '';
        }
        $render_data['status'] = $status;
        $render_data['office_id'] = $office_id;
        $render_data['is_recurrence']=$is_recurrence;
        asort($this->filter_element);
        $render_data['filter_element_list'] = $this->filter_element;
        $render_data['sorting_element'] = $this->sorting_element;
        $render_data['contador_office_list'] = $this->administration->get_office_list_by_name_like('Contador');
        $render_data['taxleaf_office_list'] = $this->administration->get_office_list_by_name_like('TaxLeaf');
        $this->load->template('billing/dashboard', $render_data);
    }

    public function dashboard_ajax() {
        $status = post('status');
        $by = post('by');
        $office = post('office');
        $payment_status = post('payment_status');
        if (post('reference_id') == 'on_load') {
            $render_data['load_type'] = 'on_load';
            $render_data['reference_id'] = $reference_id = '';
        } else {
            $render_data['reference_id'] = $reference_id = post('reference_id');
        }
        if (post('page_number') != 0) {
            $render_data['page_number'] = request('page_number');
        }
        if (post('invoice_id')) {
            $invoice_id = post('invoice_id');
        } else {
            $invoice_id = '';
        }
        if (post('pattern')) {
            $pattern = post('pattern');
        } else {
            $pattern = '';
        }
        
        $render_data['is_recurrence']=$is_recurrence=post('is_recurrence');
        $render_data['filter_status'] = post('payment_status');
        $render_data['result'] = $this->billing_model->billing_list($status, $by, $office, $payment_status, $reference_id,'','',$is_recurrence,$invoice_id,$pattern);
        $this->load->view('billing/ajax_dashboard', $render_data);
    }

    public function invoice_filter() {
        $render_data["result"] = $this->billing_model->billing_list('', '', '', '', '', post());
        $this->load->view("billing/ajax_dashboard", $render_data);
    }

    public function sort_invoice() {
        $data = post();
        $sort['sort_criteria'] = $data['sort_criteria'];
        $sort['sort_type'] = $data['sort_type'];
        unset($data['sort_criteria']);
        unset($data['sort_type']);
        $render_data["result"] = $this->billing_model->billing_list('', '', '', '', '', $data, $sort);
        $this->load->view("billing/ajax_dashboard", $render_data);
    }

    public function invoice_service_list_ajax() {
        $render_data['invoice_id'] = post('invoice_id');
        $render_data['service_list'] = billing_services($render_data['invoice_id']);
        $this->load->view('billing/ajax_invoice_service_list', $render_data);
    }

    public function billing_dashboard_note_ajax() {
        $order_id = post('order_id');
        $service_id = post('service_id');
        $note_list = invoice_notes($order_id, $service_id);
        if (count($note_list) != 0) {
            echo json_encode($note_list);
        } else {
            echo 0;
        }
    }

    public function get_tracking_log($id, $table_name) {
        $staff_info = staff_info();
        $return_data['tracking_list'] = $this->billing_model->get_tracking_log($id, $table_name);
        if (in_array(3, explode(',', $staff_info['department'])) || in_array(14, explode(',', $staff_info['department'])) || $staff_info['type'] == 1) {
            $return_data['disabled'] = 'n';
        } else {
            $return_data['disabled'] = 'y';
        }
        echo json_encode($return_data);
    }

    public function update_billing_status() {
        $invoice_id = post('invoice_id');
        $status = post('status');

        $details = $this->db->query("select status from invoice_info where id=$invoice_id")->row_array();

        if ($this->billing_model->update_billing_status($invoice_id, $status)) {
            $this->system->save_general_notification('invoice', $invoice_id, 'tracking');
            mod_invoices_count($details['status'], $status);
            echo 1;
        } else {
            echo 0;
        }
    }

    public function documents() {
        $this->load->layout = 'dashboard';
        $title = "Payment Documents";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'billing';
        $render_data['menu'] = 'documents';
        $render_data['header_title'] = $title;
        $render_data['page_heading'] = 'Payment Documents';
        $render_data['result'] = $this->billing_model->get_payment_deposit_list();
        $this->load->template('billing/documents', $render_data);
    }

    public function add_document() {
        $this->load->layout = 'dashboard';
        $title = "Add Document";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'billing';
        $render_data['menu'] = 'documents';
        $render_data['header_title'] = $title;
        $render_data['page_heading'] = 'Add Document';
        $this->load->template('billing/add_document', $render_data);
    }

    public function edit_document($id) {
        $this->load->layout = 'dashboard';
        $title = "Edit Document";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'billing';
        $render_data['menu'] = 'documents';
        $render_data['header_title'] = $title;
        $render_data['page_heading'] = 'Edit Document';
        $render_data['payment_deposit'] = $this->billing_model->payment_deposit_details($id);
        $render_data['document_list'] = $this->billing_model->get_payment_documents_by_deposit_id($id);
        $this->load->template('billing/edit_document', $render_data);
    }

    public function add_document_ajax() {
        $deposit_id = post('deposit_id');
        $section_id = post('section_id');
        if ($deposit_id != '') {
            $render_data['document_list'] = $this->billing_model->get_payment_documents_by_deposit_id($deposit_id);
            $section_id_hidden = post('section_id');
        } else {
            if ($section_id == '') {
                $render_data['section_id'] = 1;
                $section_id_hidden = 1;
                $return['last_section_id'] = 'new';
            } else {
                $section_id = explode(',', $section_id);
                for ($i = 1; $i <= count($section_id) + 1; $i++) {
                    if (!in_array($i, $section_id)) {
                        $render_data['section_id'] = $i;
                        break;
                    }
                }
                $return['last_section_id'] = end($section_id);
                $section_id_hidden = post('section_id') . ',' . $render_data['section_id'];
            }
        }
        $return['section_result'] = $this->load->view('billing/document_section_ajax', $render_data, TRUE);
        $return['section_id_hidden'] = $section_id_hidden;
        echo json_encode($return);
    }

    public function request_save_document() {
        $this->load->model('billing_model');
        if ($this->billing_model->request_save_document(post())) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function filter_dropdown_option_ajax() {
        $result['element_key'] = $element_key = post('variable');
        $result['condition'] = '';
        if (post('condition')) {
            $result['condition'] = post('condition');
        }
        $office = '';
        if (post('office')) {
            $office = post('office');
        }
        $result['element_array'] = $this->filter_element;
        $result['element_value_list'] = $this->billing_model->get_invoice_filter_element_value($element_key, $office);
        $this->load->view('billing/filter_dropdown_option_ajax', $result);
    }

    public function save_invoice_note() {
        $result = $this->billing_model->save_invoice_service_note(post());
        if ($result) {
            echo $result;
        } else {
            echo 'error';
        }
    }

    public function recurring_plans() {
        $this->load->layout = 'dashboard';
        $title = 'Billing / Recurring Plans';
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'billing';
        $render_data['menu'] = 'recurring_plans';
        $render_data['header_title'] = $title;
        $render_data['recurrence_pattern_data'] = $this->billing_model->get_recurrence_pattern_data();
        $this->load->template('billing/recurring_plans', $render_data);
    }

    public function show_recurrence_client_details() {
        $render_data['recurrence_client_details'] = $this->billing_model->show_recurrence_client_details(post());
        $render_data['pattern'] = post('pattern');
        $this->load->view('billing/show_recurrence_client_details', $render_data);
    }

}
