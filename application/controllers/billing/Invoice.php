<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    private $invoce_type_array;

    function __construct() {
        parent::__construct();
        if (!sess('user_id') && sess('user_id') == '') {
            redirect(base_url());
        }
        $this->load->model('system');
        $this->load->model("payroll_model");
        $this->load->model("staff");
        $this->load->model("service");
        $this->load->model("service_model");
        $this->load->model("action_model");
        $this->load->model("bookkeeping_model");
        $this->load->model("billing_model");
        $this->load->model('company');
        $this->load->model('contacts');
        $this->load->model('documents');
        $this->load->model('individual');
        $this->invoce_type_array = [
            '1' => 'Business Client',
            '2' => 'Individual'
        ];
    }

    public function index($client_id = "", $client_type = "") {
        $this->load->layout = 'dashboard';
        $title = "Create Invoice";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'billing';
        $render_data['menu'] = 'create_invoice';
        $render_data['header_title'] = $title;
        $render_data['page_heading'] = 'Create Invoice';
        $render_data['client_id'] = '';
        $render_data['office_id'] = '';
        if (!empty($client_id)) {
            $render_data['client_id'] = base64_decode($client_id);
            $render_data['office_id'] = $this->billing_model->get_office_id_by_individual_id($client_id);
        }
        if (!empty($client_type)) {
            $render_data['client_type'] = base64_decode($client_type);
        }
        $render_data['reference_id'] = $this->system->create_reference_id();
        $this->load->template('billing/create_invoice', $render_data);
    }

    public function get_service_dropdown_by_category_id() {
        $category_id = post('category_id');
        $service_id = post('service_id');
        $section_id = post('section_id');
        if ($category_id != '') {
            echo '<div class="form-group" id="service_dropdown_div_' . $section_id . '">
            <label class="col-lg-2 control-label">Service<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <select class="form-control" name="service_section[' . $section_id . '][service_id]" onchange="getServiceInfoById(this.value, ' . $category_id . ', ' . $section_id . ');" id="service' . $section_id . '" title="Service" required="">
                    <option value="">Select an option</option>';
            load_ddl_option("get_service_list_by_category_id", $service_id != '' ? $service_id : '', $category_id);
            echo '</select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>';
        } else {
            echo 0;
        }
    }

    public function add_service() {
        $section_id = post('section_id');
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
        $return['section_result'] = $this->load->view('billing/service_section_ajax', $render_data, TRUE);
        $return['section_id_hidden'] = $section_id_hidden;
        echo json_encode($return);
    }

    public function remove_service() {
        $section_id = post('section_id');
        $remove_id = post('remove_id');
        $section_array = explode(',', $section_id);
        if ($section_id != '' && $remove_id != '') {
            if (in_array($remove_id, $section_array)) {
                unset($section_array[array_search($remove_id, $section_array)]);
                if (count($section_array) == 0) {
                    echo 'blank';
                } else {
                    echo implode(',', $section_array);
                }
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function get_service_info_by_id() {
        $render_data['service_id'] = post('service_id');
        $render_data['section_id'] = post('section_id');
        $render_data['service_info'] = $this->billing_model->get_service_by_id($render_data['service_id']);
        if (!empty($render_data['service_info'])) {
            $this->load->view('billing/service_info_ajax', $render_data);
        } else {
            echo 0;
        }
    }

    public function request_create_invoice() {
        $result = $this->billing_model->request_create_invoice(post());
        if ($result) {
            echo base64_encode($result);
        } else {
            echo 0;
        }
    }

    public function place($invoice_id = "", $type = "place") {
        if ($invoice_id != '') {
            $invoice_id = base64_decode($invoice_id);
            $this->load->layout = 'dashboard';
            $title = "Invoice Details";
            $render_data['title'] = $title . ' | Tax Leaf';
            $render_data['main_menu'] = 'billing';
            $render_data['menu'] = 'billing_dashboard';
            $render_data['header_title'] = $title;
            $render_data['page_heading'] = 'Invoice Details';

            $order_summary = $this->billing_model->get_invoice_by_id($invoice_id);
            if (count($order_summary) == 0) {
                redirect(base_url() . 'billing/invoice');
            }
            $render_data['view_type'] = $type;
            $reference_id = $order_summary['reference_id'];
            $render_data['order_summary'] = $order_summary;
            $render_data['order_summary']['invoice_type_id'] = $invoice_type = $order_summary['invoice_type'];
            $render_data['order_summary']['invoice_type'] = $this->invoce_type_array[$invoice_type];
            $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($reference_id, $invoice_type == 1 ? 'company' : "individual");
            if ($invoice_type == 1) {
                $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($reference_id, 'company');
                $render_data['order_summary']['owners'] = $this->service_model->show_owner_list($reference_id);
            } else {
                $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($order_summary['individual_id'], "individual");
            }
            $render_data['order_summary']['documents'] = $this->billing_model->get_document_list($invoice_type == 1 ? $reference_id : $order_summary['individual_id'], $invoice_type == 1 ? 'company' : "individual");
            $render_data['order_summary']['services'] = $this->billing_model->get_order_by_invoice_id($invoice_id);
            $render_data['order_summary']['invoice_notes'] = invoice_notes($invoice_id, '');
            $render_data['order_summary']['total_price'] = '$' . number_format((float) array_sum(array_column($render_data['order_summary']['services'], 'override_price')), 2, '.', '');
            $render_data['order_summary']['sub_total'] = number_format((float) array_sum(array_column($render_data['order_summary']['services'], 'sub_total')), 2, '.', '');
            if ($type == 'place') {
                $render_data['place'] = '<div class="text-right">
                    <button class="btn btn-danger" type="button" onclick="window.location.href = \'' . base_url('billing/invoice') . '\';">Discard</button>
                    <button class="btn btn-primary" type="button" onclick="go(\'billing/invoice/details/' . base64_encode($invoice_id) . '/' . base64_encode('place') . '\');">Save</button>
                    <button class="btn btn-warning" type="button" onclick="go(\'billing/invoice/edit/' . base64_encode($invoice_id) . '/' . base64_encode('edit_place') . '\');">Edit</button>
                </div>';
            } else {
                $render_data['place'] = '<div class="text-right">
                    <button class="btn btn-danger" type="button" onclick="window.location.href = \'' . base_url('billing/home') . '\';">Back to dashboard</button>
                </div>';
            }
            $this->load->template('billing/order_summary', $render_data);
        } else {
            redirect(base_url() . 'billing/home');
        }
    }

    public function details($invoice_id = "", $place = "") {
//        echo $invoice_id.'/'.$place.'/'.$view;die;
        if ($invoice_id != '') {
            $invoice_id = base64_decode($invoice_id);
            if ($place != "") {
                $this->billing_model->update_order_summary($invoice_id);
            }
            $this->load->layout = 'dashboard';
            $title = "Invoice Details";
            $render_data['title'] = $title . ' | Tax Leaf';
            $render_data['main_menu'] = 'billing';
            $render_data['menu'] = 'billing_dashboard';
            $render_data['header_title'] = $title;
            $render_data['page_heading'] = 'Invoice Details';

            $order_summary = $this->billing_model->get_invoice_by_id($invoice_id);
            if ($place != "" && $order_summary['is_order'] == 'y') {
                $this->billing_model->save_order_on_invoice($invoice_id);
            }
            //insert action on invoice
            $staff_info = staff_info();
            $this->db->where_in('department_id', '6');
            $department_staffs = $this->db->get('department_staff')->result_array();
            $department_staff = array_column($department_staffs, 'staff_id');
            $services_array = $this->billing_model->get_order_by_invoice_id($invoice_id);
            //print_r($services_array);exit;
            $services_name = '';
            $i = 0;
            $len = count($services_array);
            if (!empty($services_array)) {
                foreach ($services_array as $sa) {
                    if ($i == $len - 1) {
                        $services_name .= $this->service_model->get_service_by_id($sa['service_id'])['description'];
                    } else {
                        $services_name .= $this->service_model->get_service_by_id($sa['service_id'])['description'] . ', ';
                    }
                    // …
                    $i++;
                }
            }
            if ($place != '') {
                $action_data['created_office'] = $order_summary['office_id'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Invoice Created';
                $action_data['message'] = $staff_info['full_name'] . ' has created invoice #' . $invoice_id . ' with the services: ' . $services_name;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;

                $this->action_model->insert_client_action($action_data);
            }
            if ($order_summary['invoice_type'] == 1) {
                if ($order_summary['new_existing'] == 1) {
                    $action_data['subject'] = 'New Client Created';
                    $action_data['message'] = $staff_info['full_name'] . ' has added a new client on invoice #' . $invoice_id;
                    $this->action_model->insert_client_action($action_data);
                }
            } else {
                if ($order_summary['new_existing'] == 1) {
                    $action_data['subject'] = 'New Client Created';
                    $action_data['message'] = $staff_info['full_name'] . ' has added a new client on invoice #' . $invoice_id;
                    $this->action_model->insert_client_action($action_data);
                }
            }

            //insert action on invoice
            if (count($order_summary) == 0) {
                redirect(base_url() . 'billing/invoice');
            }
            $reference_id = $order_summary['reference_id'];
            $render_data['order_summary'] = $order_summary;
            $render_data['order_summary']['invoice_type_id'] = $invoice_type = $order_summary['invoice_type'];
            $render_data['order_summary']['invoice_type'] = $this->invoce_type_array[$invoice_type];
            $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($reference_id, $invoice_type == 1 ? 'company' : "individual");
            if ($invoice_type == 1) {
                $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($reference_id, 'company');
                $render_data['order_summary']['owners'] = $this->service_model->show_owner_list($reference_id);
            } else {
                $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($order_summary['individual_id'], "individual");
            }

            $render_data['contact_email_list'] = array_column($render_data['order_summary']['contact_info'], 'email1');

            $render_data['order_summary']['documents'] = $this->billing_model->get_document_list($invoice_type == 1 ? $reference_id : $order_summary['individual_id'], $invoice_type == 1 ? 'company' : "individual");
            $render_data['order_summary']['services'] = $this->billing_model->get_order_by_invoice_id($invoice_id);
            $render_data['order_summary']['total_price'] = '$' . number_format((float) array_sum(array_column($render_data['order_summary']['services'], 'override_price')), 2, '.', '');
            $render_data['order_summary']['sub_total'] = number_format((float) array_sum(array_column($render_data['order_summary']['services'], 'sub_total')), 2, '.', '');
            $render_data['order_summary']['invoice_notes'] = invoice_notes($invoice_id, '');
            $render_data['place'] = '<div class="text-center">
            <button class="btn btn-default m-t-10 m-r-5" type="button" onclick="window.location.href = \'' . base_url('billing/home') . '\';">Close</button>
            <button class="btn btn-success m-t-10 m-r-5" type="button" onclick="placeOrder(\'' . $invoice_id . '\', \'' . implode(',', $render_data['contact_email_list']) . '\');"><i class="fa fa-envelope-o"></i> Email</button>
            <button class="btn bg-purple m-t-10 m-r-5" type="button" onclick="printOrder();"><i class="fa fa-print"></i> Print</button>
            <button class="btn btn-warning m-t-10 m-r-5" type="button" onclick="go(\'billing/invoice/export/' . $invoice_id . '\');"><i class="fa fa-file-pdf-o"></i> Download PDF</button>
            <button class="btn btn-primary m-t-10" type="button" onclick="go(\'billing/payments/details/' . base64_encode($invoice_id) . '\')">Pay Invoice</button>
        </div>';
            $render_data['export_type'] = 'view';
            $this->load->template('billing/invoice_details', $render_data);
        } else {
            redirect(base_url() . 'billing/home');
        }
    }

    public function export($invoice_id = '') {
        if (post('invoice_id')) {
            $invoice_id = post('invoice_id');
        }
        if ($invoice_id != '') {
            $order_summary = $this->billing_model->get_invoice_by_id($invoice_id);
            $reference_id = $order_summary['reference_id'];
            $render_data['order_summary'] = $order_summary;
            $client_name = $order_summary['invoice_type'] == 1 ? $order_summary['name_of_company'] : $order_summary['individual_name'];
            $render_data['order_summary']['invoice_type_id'] = $invoice_type = $order_summary['invoice_type'];
            $render_data['order_summary']['invoice_type'] = $this->invoce_type_array[$invoice_type];
            $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($reference_id, $invoice_type == 1 ? 'company' : "individual");
            if ($invoice_type == 1) {
                $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($reference_id, 'company');
                $render_data['order_summary']['owners'] = $this->service_model->show_owner_list($reference_id);
            } else {
                $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($order_summary['individual_id'], "individual");
            }
            $render_data['order_summary']['documents'] = $this->billing_model->get_document_list($invoice_type == 1 ? $reference_id : $order_summary['individual_id'], $invoice_type == 1 ? 'company' : "individual");
            $render_data['order_summary']['services'] = $this->billing_model->get_order_by_invoice_id($invoice_id);
            $render_data['order_summary']['total_price'] = '$' . number_format((float) array_sum(array_column($render_data['order_summary']['services'], 'override_price')), 2, '.', '');
            $render_data['order_summary']['sub_total'] = number_format((float) array_sum(array_column($render_data['order_summary']['services'], 'sub_total')), 2, '.', '');
            $render_data['order_summary']['invoice_notes'] = invoice_notes($invoice_id, '');
            $render_data['export_type'] = 'email';
            $subject = 'Billing Invoice #' . str_pad($order_summary['invoice_id'], 10, 0, STR_PAD_LEFT) . ' for ' . $order_summary['services'] . ' totaling $' . $render_data['order_summary']['sub_total'] . ' has been successfully placed';
//            $subject = 'New Invoice received from '. $render_data['order_summary']['office'];
            $staff_info = staff_info();

            $message = '<!DOCTYPE html>';
            $message .= '<html lang="en">';
            $message .= '<head>';
            $message .= '<meta charset="utf-8">';
            $message .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
            $message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
            $message .= '<title>' . $subject . '</title>';
            $message .= '<style type="text-css">';
            $message .= 'body {
                            color: #333;
                        }
                        .table {
                            width: 100%;
                        }
                        .invoice-table tbody > tr > td {
                            border-bottom: 1px solid #DDDDDD;
                        }
                        .invoice-table tbody > tr > td:last-child,
                        .invoice-table tbody > tr > td:nth-child(4),
                        .invoice-table tbody > tr > td:nth-child(3),
                        .invoice-table tbody > tr > td:nth-child(2) {
                            text-align: right;
                        }
                        .invoice-table thead > tr > th:last-child,
                        .invoice-table thead > tr > th:nth-child(4),
                        .invoice-table thead > tr > th:nth-child(3),
                        .invoice-table thead > tr > th:nth-child(2) {
                            text-align: right;
                        }
                        .invoice-total > tbody > tr > td:first-child {
                            text-align: right;
                        }
                        .invoice-total > tbody > tr > td {
                            border: 0 none;
                        }
                        .invoice-total > tbody > tr > td:last-child {
                            /*border-bottom: 1px solid #DDDDDD;*/
                            text-align: right;
                            width: 15%;
                        }';
            $message .= '</style>';
            $message .= '</head>';
            $message .= '<body style="background: #f3f3f4; padding:30px;">';
            $message .= '<table style="width:90%; margin: 20px auto;"><tr><td align="left">';
            $message .= $client_name . ',<br>' . $subject . ' on your LeafCloud Portal.';
            $message .= '</td><td align="right"><img src="' . base_url() . 'assets/img/logo.png" height="100" /></td></tr>';
            $message .= '<tr><td colspan="2">';
            $message .= '<table style="background: #ffffff; border-radius: 6px; width: 100%; margin-top: 10px;"><tr><td style="padding: 10px 20px 20px;">';
            $message .= $this->load->view('billing/invoice_details', $render_data, true);
            $message .= '</td></tr></table>';
            $message .= '</td></tr></table>';
            $message .= '</body>';
            $message .= '</html>';

            if (post('invoice_id')) {
                $email_list = post('email');
                $status = 0;
                if (empty($email_list)) {
                    $email_list[] = $staff_info['user'];
                }
                // foreach ($email_list as $email) {
                    if (compose_mail($email_list, $subject, $message)) {
                        $status++;
                    }
                // }
                echo $status;
            } else {
                $this->load->helper('pdf_helper');
                tcpdf();
                $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $obj_pdf->SetCreator(PDF_CREATOR);
                $title = "PDF Report";
                $obj_pdf->SetTitle($title);
                $obj_pdf->AddPage();
                ob_start();
                $render_data['export_type'] = 'download';
                $content = $this->load->view('billing/invoice_details', $render_data, TRUE);
                ob_end_clean();
                $obj_pdf->writeHTML($content, true, false, true, false, '');
                $obj_pdf->Output("Taxleaf_" . date('dmY') . ".pdf", 'D');
            }
        } else {
            echo 0;
        }
    }

//    public function get_invoice_container_ajax() {
//        $invoice_type = post('invoice_type');
//        $reference_id = post('reference_id');
//        $render_data['reference_id'] = $reference_id;
//        $render_data['service_category_list'] = $this->billing_model->get_service_category();
//        if ($invoice_type == '1') {
//            $render_data['reference'] = 'company';
//            $render_data['completed_orders'] = $this->service->completed_orders();
//        } else {
//            $title_id = $this->company->createTitleReferenceId($reference_id);
//            if ($title_id) {
//                $title_array = $this->company->getTitle($title_id);
//                $individual_id = $title_array->individual_id;
//            } else {
//                $title_array = false;
//                $title_id = 0;
//                $individual_id = 0;
//            }
//            $render_data['title_val'] = $title_array;
//            $render_data['reference'] = 'individual';
//            $render_data['reference_id'] = $reference_id;
//            $render_data['staffInfo'] = staff_info();
//            $render_data['individual_id'] = $individual_id;
//            $render_data['title_id'] = $title_id;
//        }
//        $this->load->view('billing/invoice_type' . $invoice_type, $render_data);
//    }

    public function get_completed_orders_officewise() {
        $office_id = post('office_id');
        $render_data['client_id'] = $client_id = post('client_id');
        $render_data['completed_orders'] = $this->service->completed_orders("", $office_id);
        $this->load->view('billing/existing_client_list', $render_data);
    }

    public function individual_list_by_office() {
        echo '<option value="">Select an option</option>';
        load_ddl_option("existing_individual_list_new", post('client_id'), post('office_id'));
    }

    public function get_invoice_container_ajax() {
        $invoice_type = post('invoice_type');
        $reference_id = post('reference_id');
        $render_data['client_id'] = $client_id = post('client_id');
        $render_data['reference_id'] = $reference_id;
        $render_data['service_category_list'] = $this->billing_model->get_service_category();
        if ($invoice_type == '1') {
            $render_data['reference'] = 'company';
        } else {
            $render_data['reference'] = 'individual';
        }
        $render_data['office_id'] = $render_data['title_id'] = '';
        if ($client_id != '') {
            $internal_data = $this->system->get_internal_data_by_reference($client_id, $render_data['reference']);
            if (!empty($internal_data)) {
                $render_data['office_id'] = $internal_data['office'];
            }
            if ($invoice_type == '2') {
                $individual_info = $this->individual->individual_info_by_title_id($client_id);
                $render_data['title_id'] = $client_id;
                $render_data['client_id'] = $individual_info['individual_id'];
            }
        }
        $this->load->view('billing/invoice_type' . $invoice_type, $render_data);
    }

    public function get_individual_info_ajax() {
        $title_id = post('title_id');
        if ($title_id != '') {
            $individual_info = $this->individual->individual_info_by_title_id($title_id);
            if (count($individual_info) != 0) {
                $individual_info['birth_date'] = date('m/d/Y', strtotime($individual_info['birth_date']));
                $return = $individual_info;
                echo json_encode($return);
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function individual_info_ajax() {
        $title_id = post('title_id');
        if ($title_id != '') {
            $individual_info = $this->individual->get_individual_info_by_title_id($title_id);
            if (count($individual_info) != 0) {
                echo json_encode($individual_info);
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function edit($invoice_id = "", $type = "") {
        if ($invoice_id != '') {
            $invoice_id = base64_decode($invoice_id);
            $this->load->layout = 'dashboard';
            $title = "Edit Invoice";
            $render_data['title'] = $title . ' | Tax Leaf';
            $render_data['main_menu'] = 'billing';
            $render_data['menu'] = 'billing_dashboard';
            $render_data['header_title'] = $title;
            $render_data['page_heading'] = 'Edit Invoice';
            $order_summary = $this->billing_model->get_invoice_by_id($invoice_id);
            if (count($order_summary) == 0) {
                redirect(base_url() . 'billing/invoice');
            }
            $reference_id = $order_summary['reference_id'];
            $render_data['reference_id'] = $reference_id;
            $render_data['invoice_id'] = $invoice_id;
            $render_data['order_summary'] = $order_summary;
            $render_data['edit_type'] = $type;
            $render_data['order_summary']['services'] = $this->billing_model->get_order_by_invoice_id($invoice_id);
            $this->load->template('billing/edit_invoice', $render_data);
        } else {
            redirect(base_url() . 'billing/home');
        }
    }

    public function get_edit_invoice_container_ajax() {
        $invoice_id = post('invoice_id');
        $render_data['service_category_list'] = $this->billing_model->get_service_category();
        $order_summary = $this->billing_model->get_invoice_edit_data_by_id($invoice_id);
        $render_data['client_name'] = $order_summary['invoice_type'] == 2 ? $order_summary['individual_name'] : $order_summary['name_of_company'];
        if (empty($order_summary) && count($order_summary) == 0) {
            echo 0;
        } else {
            $reference_id = $order_summary['reference_id'];
            $render_data['order_summary'] = $order_summary;
            $invoice_type = $order_summary['invoice_type'];
            $render_data['order_summary']['invoice_type'] = $this->invoce_type_array[$invoice_type];
//            $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($reference_id, $invoice_type == 1 ? 'company' : "individual");
            if ($invoice_type == 1) {
                $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($reference_id, 'company');
                $render_data['order_summary']['owners'] = $this->service_model->show_owner_list($reference_id);
            } else {
                $render_data['order_summary']['contact_info'] = $this->service_model->get_contact_list_by_reference($order_summary['individual_id'], "individual");
            }
            $render_data['order_summary']['documents'] = $this->billing_model->get_document_list($invoice_type == 1 ? $reference_id : $order_summary['individual_id'], $invoice_type == 1 ? 'company' : "individual");
            $render_data['order_summary']['services'] = $this->billing_model->get_order_by_invoice_id($invoice_id);
            $render_data['order_summary']['total_price'] = number_format((float) array_sum(array_column($render_data['order_summary']['services'], 'override_price')), 2, '.', '');
            $render_data['order_summary']['sub_total'] = number_format((float) array_sum(array_column($render_data['order_summary']['services'], 'sub_total')), 2, '.', '');
            $render_data['reference_id'] = $reference_id;
            $render_data['invoice_id'] = $invoice_id;
            if ($invoice_type == '1') {
                $render_data['reference'] = 'company';
                $render_data['completed_orders'] = $this->service->completed_orders();
            } else {
                $order_summary['title_id'] = $this->billing_model->get_title_id_by_individual_id($order_summary['individual_id']);
                $render_data['reference'] = 'individual';
                $render_data['staffInfo'] = staff_info();
                $render_data['individual_id'] = $order_summary['individual_id'];
                $render_data['title_id'] = $order_summary['title_id'];
            }
//            print_r($render_data);
        }
        $this->load->view('billing/edit_invoice_type' . $invoice_type, $render_data);
    }

    public function show_existing_services() {
        $invoice_id = post('invoice_id');
        $order_summary = $this->billing_model->get_invoice_edit_data_by_id(post('invoice_id'));
        $reference_id = $order_summary['reference_id'];
        $invoice_type = $order_summary['invoice_type'];
        $render_data['services'] = $this->billing_model->get_order_by_invoice_id($invoice_id);
        $return['section_result'] = urldecode($this->load->view('billing/existing_service_container', $render_data, TRUE));
        $return['section_id_hidden'] = implode(',', array_column($render_data['services'], 'order_id'));
        echo json_encode($return);
    }

}
