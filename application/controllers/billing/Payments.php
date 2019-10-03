<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

    private $invoce_type_array;

    function __construct() {
        parent::__construct();
        if (!sess('user_id') && sess('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('system');
        $this->load->model('billing_model');
        $this->load->model('service_model');
        $this->load->model('administration');
        $this->invoce_type_array = [
            '1' => 'Business Client',
            '2' => 'Individual'
        ];
    }

    public function index($payment_status = '', $office_id = '') {
        $this->load->layout = 'dashboard';
        $title = "Payments";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'billing';
        $render_data['menu'] = 'payments';
        $render_data['header_title'] = $title;
        $render_data['page_heading'] = 'Payments';
        if ($payment_status == 0) {
            $payment_status = '';
        }
        $render_data['office_id'] = $office_id;
        $staff_info = staff_info();
        if ($staff_info['type'] == 3) {
            $render_data['staff_office'] = $this->administration->get_office_by_staff_id($staff_info['id']);
        } else {
            $render_data['staff_office'] = $this->administration->get_all_office();
        }
        $render_data['payment_status'] = $payment_status;
        $render_data['result'] = $this->billing_model->billing_list('', '', '', $payment_status);
        $this->load->template('billing/payments', $render_data);
    }

    public function payments_ajax() {
        $status = post('status');
        $by = post('by');
        $office = post('office');
        $payment_status = post('payment_status');
        $render_data['filter_status'] = post('payment_status');
        $render_data['result'] = $this->billing_model->billing_list('', $by, $office, $payment_status);
        $this->load->view('billing/ajax_payments', $render_data);
    }

    public function details($invoice_id = '') {
        if ($invoice_id != '') {
            $invoice_id = base64_decode($invoice_id);
            $this->load->layout = 'dashboard';
            $title = "Payment Details";
            $render_data['title'] = $title . ' | Tax Leaf';
            $render_data['main_menu'] = 'billing';
            $render_data['menu'] = 'payments';
            $render_data['header_title'] = $title;
            $render_data['page_heading'] = 'Payment Details';
            $render_data['payment_type'] = $this->billing_model->get_payment_type();

            $payment_details = $this->billing_model->get_payment_details($invoice_id);
            $render_data['payment_details'] = $payment_details;
            $reference_id = $payment_details['reference_id'];

            if (count($payment_details) == 0) {
                redirect(base_url() . 'billing/invoice');
            }
            $render_data['payment_details'] = $payment_details;
            $render_data['payment_details']['invoice_type_id'] = $invoice_type = $payment_details['invoice_type'];
            $render_data['payment_details']['invoice_type'] = $this->invoce_type_array[$invoice_type];
            $render_data['payment_details']['contact_info'] = $this->service_model->get_contact_list_by_reference($reference_id, $invoice_type == 1 ? 'company' : "individual");
            if ($invoice_type == 1) {
                $render_data['payment_details']['owners'] = $this->service_model->show_owner_list($reference_id);
            }
            $render_data['payment_details']['documents'] = $this->billing_model->get_document_list($invoice_type == 1 ? $reference_id : $payment_details['individual_id'], $invoice_type == 1 ? 'company' : "individual");
            $service = $this->billing_model->get_order_by_invoice_id($invoice_id);
            $total_payble_amount = $total_price = $total_refund_amount = 0;
            $service_receive = [];
            foreach ($service as $key => $val) {
                $payble_amount[] = $this->billing_model->get_total_payble_amount($val['order_id'])['pay_amount'];
                $service[$key]['refund_amount'] = $refund_amount[] = $this->billing_model->get_refund_amount($val['order_id'])['pay_amount'];
            }
            $total_refund_amount = number_format((float) array_sum($refund_amount), 2, '.', '');
            $total_payble_amount = number_format((float) array_sum($payble_amount), 2, '.', '');
            $render_data['payment_details']['total_refund'] = $total_refund_amount;
            $render_data['payment_details']['total_pay_amount'] = $total_payble_amount;
            $render_data['payment_details']['services'] = $service;
            foreach ($service as $val) {
                $total_price += number_format((float) $val['sub_total'], 2, '.', '');
            }
            $render_data['payment_details']['total_price'] = number_format((float) $total_price, 2, '.', '');
            $render_data['payment_details']['due_amount'] = $render_data['payment_details']['total_price'] - $total_payble_amount;
            $this->load->template('billing/payment_details', $render_data);
        } else {
            redirect(base_url() . 'billing/payments');
        }
    }

    public function save_payment() {
        $data = post();

        foreach ($_FILES as $file_name => $file) {
            if ($file['name'] != '') {
                $upload_result = common_upload($file_name);
                if ($upload_result['success'] == 0) {
                    $return['success'] = 0;
                    $return['error_field'][] = [$file_name, $upload_result['status_msg']];
                    $data[$file_name] = '';
                } else {
                    $data[$file_name] = $upload_result['status_msg'];
                }
            } else {
                $data[$file_name] = '';
            }
        }
        $invoice_info = $this->billing_model->get_invoice_by_id($data['invoice_id']);
        $office_id = $invoice_info['office_id'];
        $office_info = $this->administration->get_office_by_id($office_id);

        if ($data['payment_type'] == 9) {
            if ($office_info['merchant_token'] != '') {
                $data['card_expiry'] = str_replace("/", "", $data['card_expiry']);
                $result = payeezy_payment($office_info['merchant_token'], $data['payment_amount'], $data['card_number'], $data['card_holder_name'], $data['card_expiry'], $data['cvv'], $data['card_type']);
                if ($result['status'] != 201) {
                    exit($result['message']);
                }
            } else {
                exit("Token missing, Please add merchant token for the office and try again.");
            }
        }

        $prev_status = $this->billing_model->get_invoice_payment_status_by_invoice_id($data['invoice_id']);
        $result = $this->billing_model->save_payment($data);
        if ($result) {
            $status = $this->billing_model->get_invoice_payment_status_by_invoice_id($data['invoice_id']);
            //insert action on invoice
            $data = $invoice_info;
            $staff_info = staff_info();
            $this->db->where_in('department_id', '3');
            $department_staffs = $this->db->get('department_staff')->result_array();
            $department_staff = array_column($department_staffs, 'staff_id');


            $action_data['created_office'] = $office_id;
            $action_data['priority'] = '3';
            $action_data['department'] = '3';
            $action_data['office'] = '17';
            $action_data['is_all'] = '1';
            $action_data['staff'] = $department_staff;
            $action_data['client_id'] = '';
            $action_data['subject'] = 'New Payment has been placed';
            $action_data['message'] = $staff_info['full_name'] . ' has added a payment on invoice #' . $data['invoice_id'];
            $action_data['action_notes'] = array();
            $action_data['due_date'] = '';
            $this->action_model->insert_client_action($action_data);
            mod_payments_count($prev_status, $status);
            echo 1;
        } else {
            echo 0;
        }
    }

    function cancel_payment() {
        $data = post();
        $details = $this->billing_model->get_payment_history_details_by_payment_id($data['payment_id']);
        $prev_status = $this->billing_model->get_invoice_payment_status_by_invoice_id($details['invoice_id']);
        $result = $this->billing_model->cancel_Payment($data);
        if ($result) {
            $status = $this->billing_model->get_invoice_payment_status_by_invoice_id($details['invoice_id']);
            mod_payments_count($prev_status, $status);
            echo 1;
        } else {
            echo 0;
        }
    }

    public function save_refund() {
        $data = post();
        foreach ($_FILES as $file_name => $file) {
            if ($file['name'] != '') {
                $upload_result = common_upload($file_name);
                if ($upload_result['success'] == 0) {
                    $return['success'] = 0;
                    $return['error_field'][] = [$file_name, $upload_result['status_msg']];
                    $data[$file_name] = '';
                } else {
                    $data[$file_name] = $upload_result['status_msg'];
                }
            } else {
                $data[$file_name] = '';
            }
        }
        $result = $this->billing_model->save_refund($data);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function refund_all() {
        $invoice_id = post('invoice_id');
        $result = $this->billing_model->refund_all_by_invoice_id($invoice_id);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function change_payment_status() {
        $invoice_id = post('invoice_id');
        $result = $this->billing_model->update_invoice_info($invoice_id, ['payment_status' => '1']);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
