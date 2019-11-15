<?php

if (!function_exists('active_menu')) {

    function active_menu($main_menu, $for) {
        return $main_menu == $for ? 'class="active"' : "";
    }

}

if (!function_exists('common_upload')) {

    function common_upload($name, $allowed_types = "", $max_size = "", $max_width = "", $max_height = "") {
        $ci = &get_instance();
        $return['success'] = 0;
        $return['status_msg'] = '';
        if ($max_size == "") {
            $max_size = 1024 * 1024 * 5;
        }
        if ($allowed_types == "") {
            $allowed_types = "*";
        }
        $upload_path = FCPATH . 'uploads/';
        if (!file_exists($upload_path)) {
            @mkdir($upload_path, 0777);
        }
        $file_name = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $_FILES[$name]['name']));
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = $allowed_types;
        $config['max_size'] = $max_size;
        $config['max_width'] = $max_width;
        $config['max_height'] = $max_height;
        $config['file_name'] = $file_name;
        $ci->upload->initialize($config);
        if ($ci->upload->do_upload($name)) {
            $return['success'] = 1;
            $return['status_msg'] = $file_name;
        } else {
            $return['success'] = 0;
            $return['status_msg'] = $ci->upload->display_errors();
        }
        return $return;
    }

}

if (!function_exists('payeezy_payment')) {

    function payeezy_payment($token, $amount, $card_number, $card_holder_name, $card_expiry, $card_cvv, $card_type, $currency_code = 'USD', $merchant_ref = 'Astonishing-Sale') {
        $service_url = 'https://api.payeezy.com/v1/transactions';
        $api_key = "Tz0ldP1ZjDGSsOO7IiySBsA2yZmm2wHx";
        $api_secret = "87100cbde7b7d5e4a3a7ff15e13e17856904e0e485182aae3f625b699c7441ea";
//        $token = "fdoa-94b55270942cbaf8e3d98a86d06edf945292897c5da2fb19";
        $amount = $amount * 100;
        $nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));
        $timestamp = strval(time() * 1000);
        $payload_data = [
            'merchant_ref' => strval(htmlspecialchars(stripslashes(trim($merchant_ref)))),
            'transaction_type' => "purchase",
            "partial_redemption" => "false",
            'method' => 'credit_card',
            'amount' => strval(htmlspecialchars(stripslashes(trim($amount)))),
            'currency_code' => strtoupper(strval(htmlspecialchars(stripslashes(trim($currency_code))))),
            'credit_card' => [
                'type' => strval(htmlspecialchars(stripslashes(trim($card_type)))),
                'cardholder_name' => strval(htmlspecialchars(stripslashes(trim($card_holder_name)))),
                'card_number' => strval(htmlspecialchars(stripslashes(trim($card_number)))),
                'exp_date' => strval(htmlspecialchars(stripslashes(trim($card_expiry)))), #mmdd
                'cvv' => strval(htmlspecialchars(stripslashes(trim($card_cvv)))),
            ]
        ];
        $payload_encode_data = json_encode($payload_data, JSON_FORCE_OBJECT);
        $header_authorization_data = $api_key . $nonce . $timestamp . $token . $payload_encode_data;

        ### Make sure the HMAC hash is in hex -->
        $header_authorization_hash_data = hash_hmac("sha256", $header_authorization_data, $api_secret, false);
        $headers = [
            'Content-Type: application/json',
            'apikey:' . strval($api_key),
            'token:' . strval($token),
            'Authorization:' . base64_encode($header_authorization_hash_data),
            'nonce:' . $nonce,
            'timestamp:' . $timestamp,
        ];

        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload_encode_data);

        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $json_response = curl_exec($curl);
        $return_data['status'] = $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//    $response = json_decode($json_response, true);print_r($response);

        if ($status != 201) {
            $return_data['message'] = "Error: call to URL $service_url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl);
        }
        curl_close($curl);
        $return_data['message'] = "\nJSON response is: " . $json_response . "\n";
        return $return_data;
    }

}

if (!function_exists('ref_gen')) {

    function ref_gen() {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->create_reference_id();
    }

}

if (!function_exists('sess')) {

    function sess($session_index) {
        $ci = &get_instance();
        return $ci->session->userdata($session_index);
    }

}

if (!function_exists('flash')) {

    function flash($session_index) {
        $ci = &get_instance();
        return $ci->session->flashdata($session_index);
    }

}
if (!function_exists('get_user_logo')) {

    function get_user_logo($id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_user_logo($id);
    }

}
if (!function_exists('get_office_id')) {

    function get_office_id($id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_office_id($id);
    }

}


if (!function_exists('post')) {

    function post($post_index = "") {
        $ci = &get_instance();
        if ($post_index == "") {
            return $ci->input->post();
        } else {
            return $ci->input->post($post_index);
        }
    }

}

if (!function_exists('get')) {

    function get($get_index = "") {
        $ci = &get_instance();
        if ($get_index == "") {
            return $ci->input->post();
        } else {
            return $ci->input->get($get_index);
        }
    }

}

if (!function_exists('request')) {

    function request($request_index = "") {
        $ci = &get_instance();
        if ($request_index == "") {
            return $ci->input->post();
        } else {
            return $ci->input->get_post($request_index);
        }
    }

}

if (!function_exists('check_duplicate_field')) {

    function check_duplicate_field($table, $field_column, $field_value, $primary_column = "", $primary_value = "") {
        $ci = &get_instance();
        $ci->load->model('system');
        $where_data[$field_column] = $field_value;
        if ($primary_column == "" && $primary_value == "") {
            return $ci->system->count_duplicate_field($table, $where_data);
        } else {
            $where_data[$primary_column . '!='] = $primary_value;
            return $ci->system->count_duplicate_field($table, $where_data);
        }
    }

}

if (!function_exists('staff_department_name')) {

    function staff_department_name($staff_id) {
        $ci = &get_instance();
        $ci->load->model('administration');
        $result = $ci->administration->get_department_by_staff_id($staff_id);
        $department_name = [];
        foreach ($result as $val) {
            $department_name[] = $val['name'];
        }
        if (count($department_name) > 0) {
            return implode(', ', $department_name);
        } else {
            return "";
        }
    }

}

if (!function_exists('get_department_name_by_id')) {

    function get_department_name_by_id($id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_department_name_by_id($id);
    }

}

if (!function_exists('staff_office_name')) {

    function staff_office_name($staff_id, $get_manager = '') {
        $ci = &get_instance();
        $ci->load->model('administration');
        $result = $ci->administration->get_office_by_staff_id($staff_id);
        $office_name = [];
        foreach ($result as $val) {
            $office_name[] = ($get_manager == $val['id']) ? $val['name'] . ' - (Manager)' : $val['name'];
        }
        if (count($office_name) > 0) {
            return implode(', ', $office_name);
        } else {
            return "";
        }
    }

}

if (!function_exists('staff_office_ofc_id')) {

    function staff_office_ofc_id($staff_id, $get_manager = '') {
        $ci = &get_instance();
        $ci->load->model('administration');
        $result = $ci->administration->get_office_by_staff_id($staff_id);
        $office_name = [];
        foreach ($result as $val) {
            $office_name[] = ($get_manager == $val['id']) ? $val['office_id'] . ' - (Manager)' : $val['office_id'];
        }
        if (count($office_name) > 0) {
            return implode(', ', $office_name);
        } else {
            return "";
        }
    }

}

if (!function_exists('load_ddl_option')) {

    function load_ddl_option($action, $selected = "", $service_id = null) {
        $ci = &get_instance();
        $ci->load->model('system');
        $ci->load->model('service');
        $ci->load->model('individual');
        $ci->load->model('service_model');
        $ci->load->model('billing_model');
        $ci->load->model('administration');
        $staff_info = $ci->system->get_staff_info(sess('user_id'));

        switch ($action) {

            case "company_type_list":
                $item_list = $ci->system->get_all_company_type();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item['id'] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='" . $item['id'] . "'>" . $item['type'] . "</option>";
                }
                break;
            case "state_list":
                if ($service_id == 'FL') {
                    $item_list = $ci->system->get_all_state(['FL']);
                } else {
                    $item_list = $ci->system->get_all_state(['DE', 'FL', 'BVI', 'OTH']);
                }
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item['id'] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='" . $item['id'] . "'>" . $item['state_name'] . "</option>";
                }
                break;
            case "all_state_list":
                $item_list = $ci->system->get_all_state();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item['id'] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='" . $item['id'] . "'>" . $item['state_name'] . "</option>";
                }
                break;
            case "staff_office_list_action":
                // $item_list = $ci->system->get_staff_office_list(($staff_info['type'] == 3 || $service_id == 'staff_office') ? sess('user_id') : "");
            $item_list = $ci->system->get_staff_office_list((($staff_info['type'] == 1)||($staff_info['type'] == 2)||($staff_info['type'] == 3)) ? sess('user_id') : "");
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item['id'] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='" . $item['id'] . "'>" . $item['name'] . "</option>";
                }
                break;
            case "staff_office_list":
                $item_list = $ci->system->get_staff_office_list(($staff_info['type'] == 3) ? sess('user_id') : ""); // This values are deleted required to client requirment ($staff_info['type'] == 3 || $service_id == 'staff_office') ? sess('user_id') : ""
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item['id'] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='" . $item['id'] . "'>" . $item['name'] . "</option>";
                }
                break;
            case "users_office_list":
                $item_list = $ci->system->get_staff_office_list(($staff_info['type'] == 3 || $service_id == 'staff_office') ? sess('user_id') : ""); // This values are deleted required to client requirment ($staff_info['type'] == 3 || $service_id == 'staff_office') ? sess('user_id') : ""
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item['id'] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='" . $item['id'] . "'>" . $item['name'] . "</option>";
                }
            break; 
            case "staff_office_list_multiple_select":
                $item_list = $ci->system->get_staff_office_list(($staff_info['type'] == 3 || $service_id == 'staff_office') ? sess('user_id') : "");
                foreach ($item_list as $item) {
                    if (in_array($item['id'], $selected)) {
                        echo "<option selected value='" . $item['id'] . "'>" . $item['name'] . "</option>";
                    } else {
                        echo "<option value='" . $item['id'] . "'>" . $item['name'] . "</option>";
                    }
                }
                break;
            case "fiscal_year_end":
                for ($item = 1; $item <= 12; $item++) {
                    $select = ($selected != "" && $item == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='" . $item . "'>" . date("F", strtotime("2000-$item-01")) . "</option>";
                }
                break;
            case "language_list":
                $item_list = $ci->system->get_languages();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item["id"] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='" . $item['id'] . "'>" . $item['language'] . "</option>";
                }
                break;

            case "language_list_multiple_select":
                $item_list = $ci->system->get_languages();
                foreach ($item_list as $item) {
                    if (in_array($item['id'], $selected)) {
                        echo "<option selected value='" . $item['id'] . "'>" . $item['language'] . "</option>";
                    } else {
                        echo "<option value='" . $item['id'] . "'>" . $item['language'] . "</option>";
                    }
                }
                break;

            case "referer_by_source":
                $item_list = $ci->system->get_refered_by_source();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item["id"] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['id']}'>{$item['source']}</option>";
                }
                break;
            case "get_select_service":
                $item_list = $ci->system->get_select_service($service_id);
                foreach ($item_list as $item) {
                    $select = (!empty($selected) != "" && in_array($item["id"], $selected)) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['id']}'>{$item['description']}</option>";
                }
                break;
            case "get_countries":
                $item_list = $ci->system->get_all_countries();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item['id'] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['id']}'>{$item['country_name']}</option>";
                }
                break;
            case "get_contact_info_type":
                $item_list = $ci->system->get_contact_info_type();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item["id"] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['id']}'>{$item['type']}</option>";
                }
                break;
            case "get_months":
                $item_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                foreach ($item_list as $key => $item) {
                    $select = ($selected != "" && $key == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='$key'>{$item}</option>";
                }
                break;
            case "get_service_list_by_category_id":
                $item_list = $ci->billing_model->get_service_list_by_category_id($service_id);
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item["id"] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['id']}'>{$item['description']}</option>";
                }
                break;
            case "get_service_list":
                $item_list = $ci->administration->get_service_list();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item["id"] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['id']}'>{$item['description']}</option>";
                }
                break;
            case "manager_staff_list":
                $item_list = $ci->system->get_manager_staff_list();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item['id'] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='" . $item['id'] . "'>" . $item['name'] . "</option>";
                }
                break;
            case "get_service_category":
                $item_list = $ci->billing_model->get_service_category();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item["id"] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['id']}'>{$item['name']}</option>";
                }
                break;
            case "existing_individual_list":
                $item_list = $ci->individual->individual_list();
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item["id"] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['id']}'>{$item['name']}</option>";
                }
                break;
            case "existing_individual_list_new":
                $item_list = $ci->individual->individual_list_new($service_id);
                foreach ($item_list as $item) {
                    if ($selected != "") {
                        $individual_details = $ci->individual->individual_info_by_title_id($selected);
                        if (!empty($individual_details) && $individual_details['individual_id'] == $item['individual_id']) {
                            $item = $individual_details;
                        }
                    }
                    $select = ($selected != "" && $item["id"] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['id']}'>{$item['name']}</option>";
                }
                break;
            case "existing_client_list":
                $item_list = $ci->service->completed_orders($service_id);
                foreach ($item_list as $item) {
                    $select = ($selected != "" && $item["reference_id"] == $selected) ? "selected = 'selected'" : "";
                    echo "<option $select value='{$item['reference_id']}'>{$item['name']}</option>";
                }
                break;
        }
    }

}

if (!function_exists('note_func')) {

    function note_func($note_title, $required, $related_table_id, $foreign_column = "", $foreign_value = "") {
        $ci = &get_instance();
        $ci->load->model('notes');
        $data['table'] = $ci->notes->get_related_note_table_by_id($related_table_id);
        $data['note_title'] = $note_title;
        $data['required'] = $required;
        $data['related_table_id'] = $related_table_id;
        if ($foreign_column != "" && $foreign_value != "") {
            $data['note_list'] = $ci->notes->note_list_with_log($related_table_id, $foreign_column, $foreign_value);
        }
        $ci->load->view('note_form', $data);
    }

}

if (!function_exists('service_note_func')) {

    function service_note_func($note_title, $required, $reference, $order_id = "", $services_id = "", $multiple = "y") {
        $ci = &get_instance();
        $ci->load->model('notes');
        $data['table'] = 'notes';
        $data['note_title'] = $note_title;
        $data['required'] = $required;
        $data['reference'] = $reference;
        $data['multiple'] = $multiple;
        $data['related_table_id'] = 1;
        if ($reference == 'service') {
            $data['add_name'] = $reference . '_notes[' . $services_id . '][]';
        } else {
            $data['add_name'] = $reference . '_notes[]';
        }
        if ($order_id != "") {
            if ($reference == 'service') {
                $data['edit_name'] = 'edit_' . $reference . '_notes[' . $services_id . ']';
            } else {
                $data['edit_name'] = 'edit_' . $reference . '_notes';
            }
            $data['note_list'] = [];
            $foreign_value = $order_id;
            if ($reference == 'service' && $services_id != "") {
                $related_service = $ci->notes->get_main_service_id($order_id, $services_id);
                if (!empty($related_service)) {
                    $foreign_value = $related_service['id'];
                }
            }
            $data['note_list'] = $ci->notes->note_list_with_log($data['related_table_id'], 'reference_id', $foreign_value, $reference);
        }
        $ci->load->view('service_note_form', $data);
    }

}

if (!function_exists('get_array_states')) {

    function get_array_states() {
        $ci = &get_instance();
        $ci->db->select("GROUP_CONCAT('\"',state_name,'\"') as string");
        $res = $ci->db->get_where("states", ['id!=' => 0])->row_array();
        if (!empty($res)) {
            return $res['string'];
        }
    }

}

if (!function_exists('getNoteCount')) {

    function getNoteCount($reference, $reference_id) {
        $ci = &get_instance();
        return $ci->db->get_where('notes', array('reference' => $reference, 'reference_id' => $reference_id, 'note!=' => ''))->num_rows();
    }

}

if (!function_exists('getReadStatus')) {

    function getReadStatus($reference, $reference_id) {
        $ci = &get_instance();
        $ci->load->model('notes');
        return $ci->notes->getNoteData($reference, $reference_id);
    }

}

if (!function_exists('get_office_name')) {

    function get_office_name($reference, $reference_id) {
        $ci = &get_instance();
        $sql = "select idata.*,(select name from office where id=idata.office) as office_name from internal_data idata where idata.reference='" . $reference . "' and idata.reference_id='" . $reference_id . "'";
        return $ci->db->query($sql)->row();
    }

}
//not//
if (!function_exists('getBookkeepingdata')) {

    function getBookkeepingdata($ref_id) {
        $ci = &get_instance();
        return $ci->db->get_where("bookkeeping", ["company_id" => $ref_id])->row_array();
    }

}
//not//
if (!function_exists('normalizeDatehelper')) {

    function normalizeDatehelper($date) {
        $date = str_replace(" / ", " - ", $date);
        $formatted_date = date_create($date);
        return date_format($formatted_date, 'm/d/Y');
    }

}

if (!function_exists('get_services_count')) {

    function get_services_count($order_id) {
        $ci = &get_instance();
        $ci->db->where(['order_id' => $order_id]);
        return $ci->db->get('service_request')->num_rows();
    }

}

if (!function_exists('listServicesOrderajaxdashboard')) {

    function listServicesOrderajaxdashboard($order_id, $status, $ref_id, $service_id) {
        $ci = &get_instance();
        $sql = "select 
                sr.id as rowid,sr.services_id as id,sr.id as service_req_id,sr.assign_user,s.ideas AS service_shortname,sr.order_id, sr.price_charged, sr.tracking, sr.date_started, sr.date_completed, sr.date_start_actual, sr.date_complete_actual, sr.beginning_month, sr.frequency,sr.status,
                s.description as service_name, s.retail_price,s.category_id, sr.input_form_status,
                sr.responsible_staff as responsible_staff_id, concat(st.last_name, ', ', st.first_name) as responsible_staff,
                s.dept as responsible_department_id, dp.name as responsible_department,
                (select name from department where id = s.dept) as service_department_name,
                (select department from staff where id = '" . sess('user_id') . "') as staff_dept
                from service_request sr
                inner join services s on s.id = sr.services_id
                inner join staff st on st.id = sr.responsible_staff
                inner join department dp on dp.id = s.dept
                where sr.order_id = $order_id";
        $data = $ci->db->query($sql)->result();
        //echo $ci->db->last_query();
        return $data;
    }

}

if (!function_exists('getNoteCountforpayrollform')) {

    function getNoteCountforpayrollform($note_title, $required, $related_table_id, $foreign_column = "", $foreign_value = "") {
        $ci = &get_instance();
        $ci->load->model('Notes');
        $data['table'] = $ci->Notes->get_related_note_table_by_id($related_table_id);
        $data['note_title'] = $note_title;
        $data['required'] = $required;
        $data['related_table_id'] = $related_table_id;
        if ($foreign_column != "" && $foreign_value != "") {
            $data['note_list'] = $ci->Notes->note_list_with_log($related_table_id, $foreign_column, $foreign_value);
        }
        return count($data['note_list']);
    }

}

if (!function_exists('get_sum_of_amount_from_financial_acc')) {

    function get_sum_of_amount_from_financial_acc($order_id, $column_name) {
        $ci = &get_instance();
        $query = 'select sum(' . $column_name . ') as total from financial_accounts where order_id="' . $order_id . '"';
        return $ci->db->query($query)->result_array();
    }

}

if (!function_exists('get_corp_tax_return_from_bookkeeping')) {

    function get_corp_tax_return_from_bookkeeping($ref_id) {
        $ci = &get_instance();
        $query = 'select * from bookkeeping where company_id="' . $ref_id . '"';
        return $ci->db->query($query)->result_array();
    }

}

if (!function_exists('staff_info')) {

    function staff_info() { 
        return $_SESSION['staff_info'];
    }

}

if (!function_exists('dd')) {

    function dd($data) {
        print_r($data);
    }

}

if (!function_exists('getService')) {

    function getService($id) {
        $ci = &get_instance();
        $ci->load->model('Service');
        return $ci->Service->getService($id);
    }

}

if (!function_exists('getRelatedService')) {

    function getRelatedService($id) {
        $ci = &get_instance();
        $ci->load->model('Service');
        return $ci->Service->getRelatedService($id);
    }

}

if (!function_exists('getmainServiceNotesContent')) {

    function getmainServiceNotesContent($id, $val) {
        $ci = &get_instance();
        $ci->load->model('Notes');
        return $ci->Notes->getmainServiceNotesContent($id, $val);
    }

}

if (!function_exists('getSpecificServiceData')) {

    function getSpecificServiceData($id, $val) {
        $ci = &get_instance();
        $ci->load->model('Service');
        return $ci->Service->getSpecificServiceData($id, $val);
    }

}

if (!function_exists('get_not_started_services_count')) {

    function get_not_started_services_count() {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->get_not_started_services_count();
    }

}

if (!function_exists('get_started_services_count')) {

    function get_started_services_count() {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->get_started_services_count();
    }

}

if (!function_exists('get_not_started_action_count')) {

    function get_not_started_action_count() {
        $ci = &get_instance();
        $ci->load->model('action_model');
        return $ci->action_model->get_actions_count(0);
    }

}

if (!function_exists('get_started_action_count')) {

    function get_started_action_count() {
        $ci = &get_instance();
        $ci->load->model('action_model');
        return $ci->action_model->get_actions_count(1);
    }

}

if (!function_exists('get_new_lead_count')) {

    function get_new_lead_count() {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return $ci->lead_management->get_leads_count();
    }

}



if (!function_exists('get_active_lead_count')) {

    function get_active_lead_count() {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return $ci->lead_management->get_active_leads_count();
    }

}

if (!function_exists('get_not_started_services_count_catwise')) {

    function get_not_started_services_count_catwise($cat) {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->get_not_started_services_count_catwise('', $cat, '', '');
    }

}

if (!function_exists('get_started_services_count_catwise')) {

    function get_started_services_count_catwise($cat) {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->get_started_services_count_catwise('', $cat, '', '');
    }

}


if (!function_exists('get_service_details')) {

    function get_service_details($srv_id) {
        $ci = &get_instance();
        $ci->load->model('Service');
        return $ci->Service->get_service_details($srv_id);
    }

}

if (!function_exists('get_resp_dept')) {

    function get_resp_dept($srv_id) {
        $ci = &get_instance();
        $ci->load->model('Service');
        return $ci->Service->get_resp_dept($srv_id);
    }

}

if (!function_exists('get_tracking_srv')) {

    function get_tracking_srv($srv_id) {
        $ci = &get_instance();
        $ci->load->model('Service');
        return $ci->Service->get_tracking($srv_id);
    }

}

if (!function_exists('get_staff_type_by_id')) {

    function get_staff_type_by_id($id) {
        $ci = &get_instance();
        $ci->load->model('administration');
        return $ci->administration->get_staff_type_by_id($id);
    }

}

if (!function_exists('staff_info_by_id')) {

    function staff_info_by_id($staff_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_staff_info($staff_id);
    }

}

if (!function_exists('staff_address_by_id')) {

    function staff_address_by_id($staff_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_staff_address_info($staff_id);
    }

}

if (!function_exists('check_franchise_client')) {

    function check_franchise_client($staff_requested_service) {
        $ci = &get_instance();
        $ci->load->model('system');
        $staff_info = staff_info();
        $staff_requested_info = $ci->system->get_staff_info($staff_requested_service);
        if ($staff_requested_service != sess('user_id')) {
            if ($staff_info['type'] == 3 && $staff_requested_info['type'] == 3) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

}

if (!function_exists('check_client')) {

    function check_client($staff_requested_service) {
        $ci = &get_instance();
        $ci->load->model('system');
        $staff_info = staff_info();
        $staff_requested_info = $ci->system->get_staff_info($staff_requested_service);
        if ($staff_info['type'] == 3) {
            if ($staff_requested_service == sess('user_id')) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

}

if (!function_exists('get_training_videos')) {

    function get_training_videos($id) {
        $ci = &get_instance();
        $ci->load->model('videos_model');
        return $ci->videos_model->fetch_file_data($id);
    }

}

if (!function_exists('filter_staff_ddl')) {

    function filter_staff_ddl($attr = "") {
        $staff_info = staff_info();
        $ci = &get_instance();
        $ci->load->model('system');
        $staff_ids = [];
        $return = "";
        if ($staff_info['type'] == 1) {
            $staff_list = $ci->system->get_all_staff();
            foreach ($staff_list as $sl):
                if ($sl['id'] != sess("user_id")):
                    $staff_ids[] = $sl['id'];
                endif;
            endforeach;
        }
        elseif ($staff_info['type'] == 3 && $staff_info['office_manager'] != "") {
            $office_manager = explode(",", $staff_info['office_manager']);
            $staff_list = $ci->system->get_staff_ids_by_office_id($office_manager);
            foreach ($staff_list as $sl):
                if ($sl['staff_id'] != sess("user_id")):
                    $staff_ids[] = $sl['staff_id'];
                endif;
            endforeach;
            $return .= "</select>";
        }
        if (count($staff_ids) > 0) {
            $return .= "<select id='filter_staff_list' $attr name='filter_staff_list'>";
            $return .= "<option value=''>Select a staff</option>";
            foreach (array_unique($staff_ids) as $staff_id):
                $st = $ci->system->get_staff_info($staff_id);
                $return .= "<option value='" . $st['id'] . "'>" . $st['first_name'] . " " . $st['last_name'] . "</option>";
            endforeach;
            $return .= "</select>";
        }else {
            $return .= "<select id='filter_staff_list' style='display:none;' $attr name='filter_staff_list'>";
            $return .= "<option value=''>Select a staff</option>";
            $return .= "</select>";
        }
        return $return;
    }

}

if (!function_exists('cart_count')) {

    function cart_count() {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return count($ci->billing_model->get_cart_info(10, "", "", sess('user_id')));
    }

}

if (!function_exists('compose_mail')) {

    function compose_mail($to_mail, $subject = "", $message = "") {
        $ci = &get_instance();
//        $from_name = 'Team taxleaf';
//
//        $from = 'codetestml0016@gmail.com';
//        $config = Array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'ssl://smtp.gmail.com',
//            'smtp_port' => 465,
//            'smtp_user' => 'codetestml0016@gmail.com', // change it to yours
//            'smtp_pass' => 'codetestml0016@123', // change it to yours
//            'mailtype' => 'html',
//            'charset' => 'utf-8',
//            'wordwrap' => TRUE
//        );

        $from = 'developer@leafnet.us';
        $config = Array(
            //'protocol' => 'smtp',
            'smtp_host' => 'mail.leafnet.us',
            'smtp_port' => 465,
            'smtp_user' => 'developer@leafnet.us', // change it to yours
            'smtp_pass' => 'developer@123', // change it to yours
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
        $user_details = staff_info();
        $from = $user_details['user'];
        $from_name = $user_details['first_name'] . ' ' . $user_details['last_name'];

        $ci->load->library('email', $config);
        $ci->email->set_newline("\r\n");
        $ci->email->from($from, $from_name); // change it to yours
        $ci->email->to($to_mail); // change it to yours
        $ci->email->subject($subject);
        $ci->email->message($message);
        return $ci->email->send();
    }

}


if (!function_exists('state_info')) {

    function state_info($state_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_state_by_id($state_id);
    }

}

if (!function_exists('county_info')) {

    function county_info($county_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_county_by_id($county_id);
    }

}

if (!function_exists('normalize_date')) {

    function normalize_date($date) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->normalizeDate($date);
    }

}

if (!function_exists('internal_data')) {

    function internal_data($reference_id, $reference) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_internal_data_by_reference($reference_id, $reference);
    }

}

if (!function_exists('company_type_info')) {

    function company_type_info($type_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_company_type_by_id($type_id);
    }

}


if (!function_exists('invoice_notes')) {

    function invoice_notes($order_id, $service_id) {
        $ci = &get_instance();
        $ci->load->model('notes');
        return $ci->notes->get_invoice_note($order_id, $service_id);
    }

}

if (!function_exists('billing_history')) {

    function billing_history($status = '', $by = '', $office = '') {
        $ci = &get_instance();
        $ci->load->model('billing_model');

        $ci->load->library('session');

        if ($status == '' && $by == '' && $office == '') {
            return count($ci->billing_model->billing_list($status, $by, $office));
        } else {
            if ($by == '') {
                if ($status == 1) {
                    if ($ci->session->userdata('nts_invoices')) {
                        return $ci->session->userdata('nts_invoices');
                    } else {

                        return $_SESSION['nts_invoices'] = count($ci->billing_model->billing_list($status, $by, $office));
                    }
                } elseif ($status == 2) {
                    if ($ci->session->userdata('s_invoices')) {
                        return $ci->session->userdata('s_invoices');
                    } else {

                        return $_SESSION['s_invoices'] = count($ci->billing_model->billing_list($status, $by, $office));
                    }
                }
            } else {
                return count($ci->billing_model->billing_list($status, $by, $office));
            }
        }
    }

}


if (!function_exists('mod_invoices_count')) {

    function mod_invoices_count($status_from = '', $status_to = '') {

        $ci = &get_instance();
        $ci->load->library('session');

        if ($status_from == '') {

            if ($status_to == 1) {
                $ci->session->set_userdata('nts_invoices', $ci->session->userdata('nts_invoices') + 1);
            }
        } else {
            if ($status_from == 2 && $status_to == 1) {

                if ($ci->session->userdata('s_invoices') > 0) {
                    $ci->session->set_userdata('s_invoices', $ci->session->userdata('s_invoices') - 1);
                }
                $ci->session->set_userdata('nts_invoices', $ci->session->userdata('nts_invoices') + 1);
            } elseif ($status_from == 3 && $status_to == 1) {

                $ci->session->set_userdata('nts_invoices', $ci->session->userdata('nts_invoices') + 1);
            } elseif ($status_from == 1 && $status_to == 2) {

                if ($ci->session->userdata('nts_invoices') > 0) {
                    $ci->session->set_userdata('nts_invoices', $ci->session->userdata('nts_invoices') - 1);
                }
                $ci->session->set_userdata('s_invoices', $ci->session->userdata('s_invoices') + 1);
            } elseif ($status_from == 3 && $status_to == 2) {

                $ci->session->set_userdata('s_invoices', $ci->session->userdata('s_invoices') + 1);
            } elseif ($status_from == 1 && $status_to == 3) {

                if ($ci->session->userdata('nts_invoices') > 0) {
                    $ci->session->set_userdata('nts_invoices', $ci->session->userdata('nts_invoices') - 1);
                }
            } elseif ($status_from == 2 && $status_to == 3) {

                if ($ci->session->userdata('s_invoices') > 0) {
                    $ci->session->set_userdata('s_invoices', $ci->session->userdata('s_invoices') - 1);
                }
            }
        }
    }

}

if (!function_exists('payment_history')) {

    function payment_history($status = '', $by = '', $office = '', $payment_status = '') {
        $ci = &get_instance();
        $ci->load->model('billing_model');

        if ($status == 'payment') {

            if ($by == '') {
                if ($payment_status == 1) {
                    if ($ci->session->userdata('nts_payments')) {
                        return $ci->session->userdata('nts_payments');
                    } else {

                        return $_SESSION['nts_payments'] = count($ci->billing_model->billing_list($status, $by, $office, $payment_status));
                    }
                } elseif ($payment_status == 2) {
                    if ($ci->session->userdata('prt_payments')) {
                        return $ci->session->userdata('prt_payments');
                    } else {

                        return $_SESSION['prt_payments'] = count($ci->billing_model->billing_list($status, $by, $office, $payment_status));
                    }
                }
            } else {
                return count($ci->billing_model->billing_list($status, $by, $office, $payment_status));
            }
        } else {
            return $ci->billing_model->billing_list($status, $by, $office, $payment_status);
        }
    }

}


if (!function_exists('mod_payments_count')) {

    function mod_payments_count($status_from = '', $status_to = '') {

        $ci = &get_instance();
        $ci->load->library('session');

        if ($status_from == '') {

            if ($status_to == 1) {
                $ci->session->set_userdata('nts_payments', $ci->session->userdata('nts_payments') + 1);
            }
        } else {
            if ($status_from == 2 && $status_to == 1) {

                if ($ci->session->userdata('prt_payments') > 0) {
                    $ci->session->set_userdata('prt_payments', $ci->session->userdata('prt_payments') - 1);
                }
                $ci->session->set_userdata('nts_payments', $ci->session->userdata('nts_payments') + 1);
            } elseif ($status_from == 3 && $status_to == 1) {

                $ci->session->set_userdata('nts_payments', $ci->session->userdata('nts_payments') + 1);
            } elseif ($status_from == 1 && $status_to == 2) {

                if ($ci->session->userdata('nts_payments') > 0) {
                    $ci->session->set_userdata('nts_payments', $ci->session->userdata('nts_payments') - 1);
                }
                $ci->session->set_userdata('prt_payments', $ci->session->userdata('prt_payments') + 1);
            } elseif ($status_from == 3 && $status_to == 2) {

                $ci->session->set_userdata('prt_payments', $ci->session->userdata('prt_payments') + 1);
            } elseif ($status_from == 1 && $status_to == 3) {

                if ($ci->session->userdata('nts_payments') > 0) {
                    $ci->session->set_userdata('nts_payments', $ci->session->userdata('nts_payments') - 1);
                }
            } elseif ($status_from == 2 && $status_to == 3) {

                if ($ci->session->userdata('prt_payments') > 0) {
                    $ci->session->set_userdata('prt_payments', $ci->session->userdata('prt_payments') - 1);
                }
            }
        }
    }

}

if (!function_exists('billing_services')) {

    function billing_services($invoice_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_order_by_invoice_id($invoice_id);
    }

}


if (!function_exists('responsible_department_name')) {

    function responsible_department_name($service_id) {
        $ci = &get_instance();
        $ci->load->model('administration');
        $result = $ci->administration->get_department_by_service_id($service_id);
        return $result[0]['dept_name'];
    }

}

if (!function_exists('get_office_name_by_office_id')) {

    function get_office_name_by_office_id($office_id) {
        $ci = &get_instance();
        $sql = "select * from office where id='" . $office_id . "'";
        return $ci->db->query($sql)->row_array()['name'];
    }

}


if (!function_exists('get_dept_name_by_dept_id')) {

    function get_dept_name_by_dept_id($dept_id) {
        $ci = &get_instance();
        $sql = "select * from department where id='" . $dept_id . "'";
        return $ci->db->query($sql)->row_array()['name'];
    }

}

if (!function_exists('get_language_name_by_id')) {

    function get_language_name_by_id($id) {
        $ci = &get_instance();
        $sql = "select * from languages where id='" . $id . "'";
        if (isset($ci->db->query($sql)->row()->language)) {
            return $ci->db->query($sql)->row()->language;
        } else
            return 'N/A';
    }

}

if (!function_exists('action_edit_permission')) {

    function action_edit_permission($action_id) {
        $ci = &get_instance();
        $ci->load->model('action_model');
        return $ci->action_model->get_action_edit_permission($action_id);
    }

}

if (!function_exists('reference_by_source')) {

    function reference_by_source($reference_by_source) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_reference_by_source($reference_by_source);
    }

}

if (!function_exists('get_payment_history')) {

    function get_payment_history($invoice_id, $service_id, $order_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_payment_history($invoice_id, $service_id, $order_id);
    }

}
if (!function_exists('get_payment_history_type')) {

    function get_payment_history_type($payment_type) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_payment_history_type($payment_type);
    }

}

if (!function_exists('get_total_payble_amount')) {

    function get_total_payble_amount($order_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_total_payble_amount($order_id);
    }

}

if (!function_exists('count_services')) {

    function count_services($status, $by = "", $category = "", $request_by = "") {
        $ci = &get_instance();
        $ci->load->model('service_model');

        if ($by == "") {

            $ci->load->library('session');

            if ($category == "") {

                if ($status == 2) {

                    if ($ci->session->userdata('nts_services')) {
                        return $ci->session->userdata('nts_services');
                    } else {
                        return $_SESSION['nts_services'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('nts_services', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 1) {

                    if ($ci->session->userdata('s_services')) {
                        return $ci->session->userdata('s_services');
                    } else {
                        return $_SESSION['s_services'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('s_services', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                }
            } else {

                if ($status == 2 && $category == 1) {
                    if ($ci->session->userdata('nts_incorporation')) {
                        return $ci->session->userdata('nts_incorporation');
                    } else {
                        return $_SESSION['nts_incorporation'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('nts_incorporation', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 2 && $category == 2) {
                    if ($ci->session->userdata('nts_accounting')) {
                        return $ci->session->userdata('nts_accounting');
                    } else {
                        return $_SESSION['nts_accounting'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('nts_accounting', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 2 && $category == 3) {
                    if ($ci->session->userdata('nts_tax')) {
                        return $ci->session->userdata('nts_tax');
                    } else {
                        return $_SESSION['nts_tax'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('nts_tax', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 2 && $category == 4) {
                    if ($ci->session->userdata('nts_business')) {
                        return $ci->session->userdata('nts_business');
                    } else {
                        return $_SESSION['nts_business'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('nts_business', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 2 && $category == 5) {
                    if ($ci->session->userdata('nts_partner')) {
                        return $ci->session->userdata('nts_partner');
                    } else {
                        return $_SESSION['nts_partner'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('nts_partner', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 1 && $category == 1) {
                    if ($ci->session->userdata('s_incorporation')) {
                        return $ci->session->userdata('s_incorporation');
                    } else {
                        return $_SESSION['s_incorporation'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('s_incorporation', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 1 && $category == 2) {
                    if ($ci->session->userdata('s_accounting')) {
                        return $ci->session->userdata('s_accounting');
                    } else {
                        return $_SESSION['s_accounting'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('s_accounting', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 1 && $category == 3) {
                    if ($ci->session->userdata('s_tax')) {
                        return $ci->session->userdata('s_tax');
                    } else {
                        return $_SESSION['s_tax'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('s_tax', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 1 && $category == 4) {
                    if ($ci->session->userdata('s_business')) {
                        return $ci->session->userdata('s_business');
                    } else {
                        return $_SESSION['s_business'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('s_business', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                } elseif ($status == 1 && $category == 5) {
                    if ($ci->session->userdata('s_partner')) {
                        return $ci->session->userdata('s_partner');
                    } else {
                        return $_SESSION['s_partner'] = $ci->service_model->count_service_filter($status, $by, $category, $request_by);
//                    return $ci->session->set_userdata('s_partner', $ci->service_model->count_service_filter($status, $by, $category, $request_by));
                    }
                }
            }
        } else {

            return $ci->service_model->count_service_filter($status, $by, $category, $request_by);
        }
    }

}

if (!function_exists('mod_services_count')) {

    function mod_services_count($status_from = '', $status_to = '', $section_name) {

        $ci = &get_instance();
        $ci->load->library('session');

        if ($section_name == 'incorporation') {

            if ($status_from == '') {

                if ($status_to == 2) {
                    $ci->session->set_userdata('nts_incorporation', $ci->session->userdata('nts_incorporation') + 1);
                }
            } else {

                if ($status_from == 0 && $status_to == 1) {
                    $ci->session->set_userdata('s_incorporation', $ci->session->userdata('s_incorporation') + 1);
                } elseif ($status_from == 2 && $status_to == 1) {

                    if ($ci->session->userdata('nts_incorporation') > 0) {
                        $ci->session->set_userdata('nts_incorporation', $ci->session->userdata('nts_incorporation') - 1);
                    }
                    $ci->session->set_userdata('s_incorporation', $ci->session->userdata('s_incorporation') + 1);
                } elseif ($status_from == 3 && $status_to == 1) {

                    $ci->session->set_userdata('s_incorporation', $ci->session->userdata('s_incorporation') + 1);
                } elseif ($status_from == 0 && $status_to == 2) {

                    $ci->session->set_userdata('nts_incorporation', $ci->session->userdata('nts_incorporation') + 1);
                } elseif ($status_from == 1 && $status_to == 2) {

                    if ($ci->session->userdata('s_incorporation') > 0) {
                        $ci->session->set_userdata('s_incorporation', $ci->session->userdata('s_incorporation') - 1);
                    }
                    $ci->session->set_userdata('nts_incorporation', $ci->session->userdata('nts_incorporation') + 1);
                } elseif ($status_from == 3 && $status_to == 2) {

                    $ci->session->set_userdata('nts_incorporation', $ci->session->userdata('nts_incorporation') + 1);
                } elseif ($status_from == 1 && ($status_to == 0 || $status_to == 3)) {

                    $ci->session->set_userdata('s_incorporation', $ci->session->userdata('s_incorporation') - 1);
                } elseif ($status_from == 2 && ($status_to == 0 || $status_to == 3)) {

                    $ci->session->set_userdata('nts_incorporation', $ci->session->userdata('nts_incorporation') - 1);
                }
            }
        } elseif ($section_name == 'accounting_services') {
            if ($status_from == '') {

                if ($status_to == 2) {
                    $ci->session->set_userdata('nts_accounting', $ci->session->userdata('nts_accounting') + 1);
                }
            } else {
                if ($status_from == 0 && $status_to == 1) {
                    $ci->session->set_userdata('s_accounting', $ci->session->userdata('s_accounting') + 1);
                } elseif ($status_from == 2 && $status_to == 1) {

                    if ($ci->session->userdata('nts_accounting') > 0) {
                        $ci->session->set_userdata('nts_accounting', $ci->session->userdata('nts_accounting') - 1);
                    }
                    $ci->session->set_userdata('s_accounting', $ci->session->userdata('s_accounting') + 1);
                } elseif ($status_from == 3 && $status_to == 1) {

                    $ci->session->set_userdata('s_accounting', $ci->session->userdata('s_accounting') + 1);
                } elseif ($status_from == 0 && $status_to == 2) {

                    $ci->session->set_userdata('nts_accounting', $ci->session->userdata('nts_accounting') + 1);
                } elseif ($status_from == 1 && $status_to == 2) {

                    if ($ci->session->userdata('s_accounting') > 0) {
                        $ci->session->set_userdata('s_accounting', $ci->session->userdata('s_accounting') - 1);
                    }
                    $ci->session->set_userdata('nts_accounting', $ci->session->userdata('nts_accounting') + 1);
                } elseif ($status_from == 3 && $status_to == 2) {

                    $ci->session->set_userdata('nts_accounting', $ci->session->userdata('nts_accounting') + 1);
                } elseif ($status_from == 1 && ($status_to == 0 || $status_to == 3)) {

                    $ci->session->set_userdata('s_accounting', $ci->session->userdata('s_accounting') - 1);
                } elseif ($status_from == 2 && ($status_to == 0 || $status_to == 3)) {

                    $ci->session->set_userdata('nts_accounting', $ci->session->userdata('nts_accounting') - 1);
                }
            }
        }

        mod_main_services_count();
    }

}

if (!function_exists('mod_main_services_count')) {

    function mod_main_services_count() {

        $ci = &get_instance();
        $ci->load->library('session');

        $ci->session->set_userdata('nts_services', $ci->session->userdata('nts_incorporation') + $ci->session->userdata('nts_accounting') + $ci->session->userdata('nts_tax') + $ci->session->userdata('nts_business') + $ci->session->userdata('nts_partner'));
        $ci->session->set_userdata('s_services', $ci->session->userdata('s_incorporation') + $ci->session->userdata('s_accounting') + $ci->session->userdata('s_tax') + $ci->session->userdata('s_business') + $ci->session->userdata('s_partner'));
    }

}

if (!function_exists('get_client_name')) {

    function get_client_name($client_id) {
        $ci = &get_instance();
        $ci->load->model('action_model');
        return $ci->action_model->get_client_name_by_id($client_id);
    }

}

if (!function_exists('get_county_name')) {

    function get_county_name($county_id) {
        $ci = &get_instance();
        $ci->load->model('action_model');
        return $ci->action_model->get_county_name_by_id($county_id);
    }

}

if (!function_exists('get_bookkeeping_by_order_id')) {

    function get_bookkeeping_by_order_id($order_id) {
        $ci = &get_instance();
        $ci->load->model('bookkeeping_model');
        return $ci->bookkeeping_model->get_bookkeeping_by_order_id($order_id);
    }

}

if (!function_exists('service_request_invoice_link')) {

    function service_request_invoice_link($order_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        $result = $ci->billing_model->get_invoice_by_order_id($order_id);
        $return = '';
        if (!empty($result)) {
            $url = base_url('billing/invoice/edit/' . base64_encode($result['id']));
            $return .= '<div class="pull-center"><span class="text-success">If you will change this service, Please change the invoice also </span>';
            $return .= "(<a href='$url' target='_blank'><i class='fa fa-pencil'></i>Change</a>)";
            $return .= '</div>';
        }
//        return $return;
        return '';
    }

}

if (!function_exists('invoice_info_by_order_id')) {

    function invoice_info_by_order_id($order_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_invoice_by_order_id($order_id);
    }

}

if (!function_exists('invoice_payment_status')) {

    function invoice_payment_status($invoice_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_invoice_payment_status_by_invoice_id($invoice_id);
    }

}

if (!function_exists('get_office_info_by_id')) {

    function get_office_info_by_id($office_id) {
        $ci = &get_instance();
        $ci->load->model('administration');
        return $ci->administration->get_office_by_id($office_id);
    }

}


if (!function_exists('get_department_info_by_id')) {

    function get_department_info_by_id($department_id) {
        $ci = &get_instance();
        $ci->load->model('administration');
        return $ci->administration->get_department_by_id($department_id);
    }

}

if (!function_exists('payment_documents_by_deposit_id')) {

    function payment_documents_by_deposit_id($deposit_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_payment_documents_by_deposit_id($deposit_id);
    }

}

if (!function_exists('get_assigned_data')) {

    function get_assigned_data($partner_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->get_assigned_data($partner_id);
    }

}

if (!function_exists('get_assigned_client_name')) {

    function get_assigned_client_name($client_type, $client_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->get_assigned_client_name($client_type, $client_id);
    }

}

if (!function_exists('total_payble_amount')) {

    function total_payble_amount($order_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_total_payble_amount($order_id);
    }

}

if (!function_exists('total_refund_amount')) {

    function total_refund_amount($order_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_refund_amount($order_id);
    }

}

// if (!function_exists('get_sales_tax_process_notes')) {
//     function get_sales_tax_process_notes($salestax_id) {
//         $ci = &get_instance();
//         $ci->load->model('Sales_tax_process');
//         return $ci->Sales_tax_process->get_sales_tax_process_notes($salestax_id);
//     }
// }

if (!function_exists('check_if_lead_assigned')) {

    function check_if_lead_assigned($lead_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->check_if_lead_assigned($lead_id);
    }

}

if (!function_exists('get_type_of_contact_name')) {

    function get_type_of_contact_name($type_of_contact, $lead_type) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->get_type_of_contact_name($type_of_contact, $lead_type);
    }

}

if (!function_exists('get_notes_ref_partner')) {

    function get_notes_ref_partner($lead_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->get_notes_ref_partner($lead_id);
    }

}

if (!function_exists('get_assigned_by_staff_name')) {

    function get_assigned_by_staff_name($staff_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        $ret = $ci->Referral_partner->get_assigned_by_staff_name($staff_id);
        return $ret['last_name'] . ', ' . $ret['first_name'];
    }

}

if (!function_exists('action_staff_by_action_id')) {

    function action_staff_by_action_id($action_id) {
        $ci = &get_instance();
        $ci->load->model('action_model');
        return $ci->action_model->get_action_staff_by_action_id($action_id);
    }

}

if (!function_exists('get_ref_note_count')) {

    function get_ref_note_count($ref_partner_table_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->get_ref_note_count($ref_partner_table_id);
    }

}

if (!function_exists('load_ref_partner_count')) {

    function load_ref_partner_count($by) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->load_ref_partner_count($by);
    }

}

if (!function_exists('load_partner_count')) {

    function load_partner_count($by, $status) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        $arr_val = array(
            'type' => $by,
            'status' => $status
        );
        return count($ci->Referral_partner->load_referral_partners_dashboard_data('', $arr_val));
    }

}

if (!function_exists('load_referred_leads_count')) {

    function load_referred_leads_count($status) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->load_referred_leads_count($status);
    }

}

if (!function_exists('count_leads_ref_by_refpartner')) {

    function count_leads_ref_by_refpartner($by = '', $status = '') {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->count_leads_ref_by_refpartner($by, $status);
    }

}

if (!function_exists('user_who_referred')) {

    function user_who_referred($user_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->Referral_partner->get_user_who_referred_id($user_id);
    }

}

if (!function_exists('check_rt6_status')) {

    function check_rt6_status($order_id) {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->check_rt6_status($order_id);
    }

}

if (!function_exists('get_all_dept')) {

    function get_all_dept() {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_all_dept();
    }

}

if (!function_exists('input_form_check')) {

    function input_form_check($service_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->input_form_check($service_id);
    }

}

if (!function_exists('check_if_related_service_exists')) {

    function check_if_related_service_exists($service_id, $order_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->check_if_related_service_exists($service_id, $order_id);
    }

}

if (!function_exists('edit_order_link')) {

    function edit_order_link($order_id) {
        $ci = &get_instance();
        $user_info = staff_info();
        $usertype = $user_info['type'];
        $ci->load->model('service_model');
        $result = $ci->service_model->get_order_by_id($order_id);
        if (empty($result)) {
            return '';
        }
        $row = (object) $result;
        $service = $ci->service_model->get_service_by_id($row->service_id);
        $serviceid = $ci->service_model->get_service_by_shortname('acc_s_t_r');
        $serviceid = $serviceid['id'];
        $status = $row->status;
        $url = '';
        if ($usertype != '3') {
            if ($row->category_id == 1) {
                if ($row->service_id == '3' || $row->service_id == '39' || $row->service_id == '48') {
                    $url = 'services/accounting_services/edit_annual_report/' . base64_encode($row->id);
                } elseif ($row->service_id == '2' || $row->service_id == '4' || $row->service_id == '6' || $row->service_id == '53') {
                    $url = 'services/home/edit/' . base64_encode($row->id);
                } elseif ($row->service_id == '5' || $row->service_id == '54' || $row->service_id == '55') {
                    $url = 'services/home/edit/' . base64_encode($row->id);
                } elseif ($row->service_id == '7') {
                    $url = 'services/home/edit/' . base64_encode($row->id);
                } else {
                    if ($service['ideas'] == 'inc_n_c_d' || $service['ideas'] == 'inc_n_c_f') {
                        $url = 'services/incorporation/edit_company/' . base64_encode($row->id);
                    } else {
                        $url = 'services/home/edit/' . base64_encode($row->id);
                    }
                }
            } else {
                if ($row->service_id == 10 || $row->service_id == '41') {
                    $res = get_bookkeeping_by_order_id($row->id);
                    if (!empty($res)) {
                        if ($res['sub_category'] == 2) {
                            $url = 'services/accounting_services/edit_bookkeeping_by_date/' . base64_encode($row->id);
                        } else {
                            $url = 'services/accounting_services/edit_bookkeeping/' . base64_encode($row->id);
                        }
                    } else {
                        $url = 'services/accounting_services/edit_bookkeeping/' . base64_encode($row->id);
                    }
                } elseif ($row->service_id == '11') {
                    $url = 'services/accounting_services/edit_payroll/' . base64_encode($row->id);
                } elseif ($row->service_id == '12') {
                    $url = 'services/accounting_services/edit_sales_tax_application/' . base64_encode($row->id);
                } elseif ($row->service_id == '14') {
                    $url = 'services/accounting_services/edit_rt6_unemployment_app/' . base64_encode($row->id);
                } elseif ($row->service_id == $serviceid) {
                    $url = 'services/accounting_services/edit_sales_tax_recurring/' . base64_encode($row->id);
                } elseif ($row->service_id == '13') { //change in live
                    $url = 'services/accounting_services/edit_sales_tax_processing/' . base64_encode($row->id);
                } elseif ($row->service_id == '3' || $row->service_id == '48') {
                    $url = 'services/accounting_services/edit_annual_report/' . base64_encode($row->id);
                } elseif ($row->service_id == '48' || $row->service_id == '39') {
                    $url = 'services/accounting_services/edit_annual_report/' . base64_encode($row->id);
                } else {
                    $url = 'services/home/edit/' . base64_encode($row->id);
                }
            }
            if (in_array($service['ideas'], edit_by_shortname_array())) {
                $url = 'services/home/edit/' . base64_encode($row->id);
            }
        } else {
            if ($usertype == '3' && $status == 2) {
                if ($row->category_id == 1) {
                    if ($row->service_id == '3' || $row->service_id == '39' || $row->service_id == '48') {
                        $url = 'services/accounting_services/edit_annual_report/' . base64_encode($row->id);
                    } else {
                        if ($service['ideas'] == 'inc_n_c_d' || $service['ideas'] == 'inc_n_c_f') {
                            $url = 'services/incorporation/edit_company/' . base64_encode($row->id);
                        } else {
                            $url = 'services/home/edit/' . base64_encode($row->id);
                        }
                    }
                } else {
                    if ($row->service_id == 10 || $row->service_id == '41') {
                        $res = get_bookkeeping_by_order_id($row->id);
                        if (!empty($res)) {
                            if ($res['sub_category'] == 2) {
                                $url = 'services/accounting_services/edit_bookkeeping_by_date/' . base64_encode($row->id);
                            } else {
                                $url = 'services/accounting_services/edit_bookkeeping/' . base64_encode($row->id);
                            }
                        } else {
                            $url = 'services/accounting_services/edit_bookkeeping/' . base64_encode($row->id);
                        }
                    } elseif ($row->service_id == '11') {
                        $url = 'services/accounting_services/edit_payroll/' . base64_encode($row->id);
                    } elseif ($row->service_id == '12') {
                        $url = 'services/accounting_services/edit_sales_tax_application/' . base64_encode($row->id);
                    } elseif ($row->service_id == '14') {
                        $url = 'services/accounting_services/edit_rt6_unemployment_app/' . base64_encode($row->id);
                    } elseif ($row->service_id == $serviceid) {
                        $url = 'services/accounting_services/edit_sales_tax_recurring/' . base64_encode($row->id);
                    } elseif ($row->service_id == '13') { //change in live
                        $url = 'services/accounting_services/edit_sales_tax_processing/' . base64_encode($row->id);
                    } else {
                        $url = 'services/home/edit/' . base64_encode($row->id);
                    }
                }
                if (in_array($service['ideas'], edit_by_shortname_array())) {
                    $url = 'services/home/edit/' . base64_encode($row->id);
                }
            }
        }
        return $url;
    }

}

if (!function_exists('view_order_link')) {

    function view_order_link($order_id) {
        $ci = &get_instance();
        $ci->load->model('service_model');
        $result = $ci->service_model->get_order_by_id($order_id);
        $row = (object) $result;
        $service = $ci->service_model->get_service_by_id($row->service_id);
        $url = 'services/home/view/' . $row->id . '/' . $row->category_id . '/' . $row->reference_id . '/' . $row->service_id;
        return '<a title=\'' . $service['description'] . '\' href="javascript:void(0);" onclick=\'go("' . $url . '");\'>#' . $row->id . '</a>';
    }

}

if (!function_exists('action_list')) {

    function action_list($request = '', $status = '', $priority = '', $office_id = '', $department_id = '') {
        $ci = &get_instance();
        $ci->load->model('action_model');

        $ci->load->library('session');

        if ($request == '') {
            if ($status == 0) {

                if ($ci->session->userdata('nw_actions')) {
                    return $ci->session->userdata('nw_actions');
                } else {

                    return $_SESSION['nw_actions'] = count($ci->action_model->get_action_list($request, $status, $priority, $office_id, $department_id));
                }
            } elseif ($status == 1) {

                if ($ci->session->userdata('s_actions')) {
                    return $ci->session->userdata('s_actions');
                } else {

                    return $_SESSION['s_actions'] = count($ci->action_model->get_action_list($request, $status, $priority, $office_id, $department_id));
                }
            }
        } else {
            return count($ci->action_model->get_action_list($request, $status, $priority, $office_id, $department_id));
        }
    }

}

if (!function_exists('mod_actions_count')) {

    function mod_actions_count($status_from = '', $status_to = '') {

        $ci = &get_instance();
        $ci->load->library('session');

        if ($status_from == '') {

            if ($status_to == 0) {
                $ci->session->set_userdata('nw_actions', $ci->session->userdata('nw_actions') + 1);
            }
        } else {

            if ($status_from == 0 && $status_to == 1) {

                if ($ci->session->userdata('nw_actions') > 0) {
                    $ci->session->set_userdata('nw_actions', $ci->session->userdata('nw_actions') - 1);
                }
                $ci->session->set_userdata('s_actions', $ci->session->userdata('s_actions') + 1);
            } elseif ($status_from == 0 && $status_to == 2) {

                if ($ci->session->userdata('nw_actions') > 0) {
                    $ci->session->set_userdata('nw_actions', $ci->session->userdata('nw_actions') - 1);
                }
            } elseif ($status_from == 1 && $status_to == 2) {

                if ($ci->session->userdata('s_actions') > 0) {
                    $ci->session->set_userdata('s_actions', $ci->session->userdata('s_actions') - 1);
                }
            } elseif ($status_from == 1 && $status_to == 0) {

                if ($ci->session->userdata('s_actions') > 0) {
                    $ci->session->set_userdata('s_actions', $ci->session->userdata('s_actions') - 1);
                }
                $ci->session->set_userdata('nw_actions', $ci->session->userdata('nw_actions') + 1);
            } elseif ($status_from == 2 && $status_to == 0) {

                $ci->session->set_userdata('nw_actions', $ci->session->userdata('nw_actions') + 1);
            } elseif ($status_from == 2 && $status_to == 1) {

                $ci->session->set_userdata('s_actions', $ci->session->userdata('s_actions') + 1);
            }
        }
    }

    mod_main_services_count();
}

if (!function_exists('note_notification')) {

    function note_notification($related_table_id, $reference, $bywhom) {
        $ci = &get_instance();
        $staff_info = staff_info();
        $ci->load->model('notes');
        return $ci->notes->note_notification_list_with_log($related_table_id, $reference, $bywhom);
    }

}

if (!function_exists('get_delaware_serv_id')) {

    function get_delaware_serv_id() {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->get_service_by_shortname('inc_n_c_d');
    }

}


if (!function_exists('filter_stafftype_ddl')) {

    function filter_stafftype_ddl($attr = "") {
        $ci = &get_instance();
        $ci->load->model('system');
        $return = "";
        $types = $ci->system->get_user_types();
        $return .= "<select id='filter_stafftype_list' $attr name='filter_stafftype_list'>";
        $return .= "<option value=''>All types</option>";
        foreach ($types as $t):
            $return .= "<option value='" . $t['id'] . "'>" . $t['name'] . "</option>";
        endforeach;
        $return .= "</select>";
        return $return;
    }

}

if (!function_exists('get_all_ofc')) {

    function get_all_ofc() {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_all_ofc();
    }

}

if (!function_exists('get_filter_dropdown_options')) {

    function get_filter_dropdown_options($val, $ofc_val) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_filter_dropdown_options($val, $ofc_val);
    }

}

if (!function_exists('get_filter_dropdown_options_ref_partner')) {

    function get_filter_dropdown_options_ref_partner($val) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_filter_dropdown_options_ref_partner($val);
    }

}

if (!function_exists('check_if_new_sos')) {

    function check_if_new_sos($ref, $order_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->check_if_new_sos($ref, $order_id);
    }

}

if (!function_exists('get_sos_count')) {

    function get_sos_count($reference, $service_id, $order_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_sos_count($reference, $service_id, $order_id);
    }

}
if (!function_exists('get_sos_count_action')) {

    function get_sos_count_action($reference, $service_id, $order_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_sos_count_action($reference, $service_id, $order_id);
    }

}

if (!function_exists('sos_dashboard_count')) {

    function sos_dashboard_count($reference, $byval) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->sos_dashboard_count($reference, $byval);
    }

}

if (!function_exists('sos_dashboard_count_for_reply')) {

    function sos_dashboard_count_for_reply($reference, $byval) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->sos_dashboard_count_for_reply($reference, $byval);
    }

}

if (!function_exists('check_if_sos_exists')) {

    function check_if_sos_exists($reference, $reference_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->check_if_sos_exists($reference, $reference_id);
    }

}

if (!function_exists('related_service_note_list')) {

    function related_service_note_list($order_id, $service_id) {
        $ci = &get_instance();
        $ci->load->model('notes');
        $related_service = $ci->notes->get_main_service_id($order_id, $service_id);
        if (!empty($related_service)) {
            return $ci->notes->note_list_with_log(1, 'reference_id', $related_service['id'], 'service');
        } else {
            return [];
        }
    }

}

if (!function_exists('get_contact_list')) {

    function get_contact_list($reference_id, $reference) {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->get_contact_list_by_reference($reference_id, $reference);
    }

}

if (!function_exists('get_document_list')) {

    function get_document_list($reference_id, $reference) {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->get_document_list_by_reference($reference_id, $reference);
    }

}

if (!function_exists('marketing_cart_count')) {

    function marketing_cart_count() {
        $ci = &get_instance();
        $ci->load->model('marketing_model');
        return $ci->marketing_model->cart_count();
    }

}

if (!function_exists('removecartItem')) {

    function removecartItem($cart_data) {
        $ci = &get_instance();
        $ci->load->model('marketing_model');
        return $ci->marketing_model->removecartItem($cart_data);
    }

}

if (!function_exists('insertpurchaseList')) {

    function insertpurchaseList($cart_data, $TransactionID) {
        $ci = &get_instance();
        $ci->load->model('marketing_model');
        return $ci->marketing_model->insertpurchaseList($cart_data, $TransactionID);
    }

}

if (!function_exists('get_paypal_details')) {

    function get_paypal_details() {
        $ci = &get_instance();
        $ci->load->model('administration');
        return $ci->administration->paypal_details();
    }

}

if (!function_exists('edit_by_shortname_array')) {

    function edit_by_shortname_array() {
        return [
            'inc_c_a',
            'inc_f_a',
            'inc_c_o_g_s_d',
            'inc_c_o_g_s_f',
            'inc_o_a',
            'inc_2_b_c_o_s',
            'inc_c_b',
            'inc_f_a_r',
            'inc_d_a_r',
            'inc_n_c_f',
            'inc_n_c_d',
            'inc_n_c_n_p_f',
            'inc_n_f_p',
            'tax_f'
        ];
    }

}

if (!function_exists('service_request_info')) {

    function service_request_info($order_id = '', $service_id = '') {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->service_request_info($order_id, $service_id);
    }

}

if (!function_exists('get_profile_picture')) {

    function get_profile_picture() {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_profile_picture();
    }

}

if (!function_exists('count_services_order')) {

    function count_services_order($status, $cat = '') {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->count_services_order($status, $cat);
    }

}

if (!function_exists('count_actions')) {

    function count_actions($status) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->count_actions($status);
    }

}

if (!function_exists('count_invoice')) {

    function count_invoice($status) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->count_invoice($status);
    }

}

if (!function_exists('count_payment')) {

    function count_payment($status) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->count_payment($status);
    }

}

if (!function_exists('get_marketing_languages')) {

    function get_marketing_languages($id) {
        $ci = &get_instance();
        $ci->load->model('marketing_model');
        return $ci->marketing_model->get_marketing_languages($id);
    }

}

if (!function_exists('check_if_discount')) {

    function check_if_discount($quan, $marketing_id) {
        $ci = &get_instance();
        $ci->load->model('marketing_model');
        return $ci->marketing_model->check_if_discount($quan, $marketing_id);
    }

}

if (!function_exists('marketing_q_p')) {

    function marketing_q_p($marketing_id) {
        $ci = &get_instance();
        $ci->load->model('marketing_model');
        return $ci->marketing_model->marketing_q_p($marketing_id);
    }

}

if (!function_exists('get_dynamic_price')) {

    function get_dynamic_price($marketing_id, $quantity) {
        $ci = &get_instance();
        $ci->load->model('marketing_model');
        return $ci->marketing_model->get_dynamic_price($marketing_id, $quantity);
    }

}

if (!function_exists('get_add_by_user_ofc')) {

    function get_add_by_user_ofc($action_id) {
        $ci = &get_instance();
        $ci->load->model('action_model');
        return $ci->action_model->get_add_by_user_ofc($action_id);
    }

}

if (!function_exists('get_add_by_user_ofc_id')) {

    function get_add_by_user_ofc_id($action_id) {
        $ci = &get_instance();
        $ci->load->model('action_model');
        return $ci->action_model->get_add_by_user_ofc_id($action_id);
    }

}

if (!function_exists('array_multiply')) {

    function array_multiply($array) {
        $result = 0;
        foreach ($array as $key => $value) {
            if ($key == 0) {
                $result = $value;
            } else {
                $result *= $value;
            }
        }
        return $result;
    }

}

if (!function_exists('mail_campaign_list')) {

    function mail_campaign_list($leadtype, $language, $day, $status = '') {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return $ci->lead_management->lead_campaign_mails($leadtype, $language, $day, $status);
    }

}


if (!function_exists('get_event_lead_details')) {

    function get_event_lead_details($event_id) {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return $ci->lead_management->get_event_lead_details($event_id);
    }

}

if (!function_exists('get_event_lead_by_id')) {

    function get_event_lead_by_id($event_id) {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return $ci->lead_management->get_event_lead_by_id($event_id);
    }

}

if (!function_exists('operational_file_list')) {

    function operational_file_list($operational_manual_id) {
        $ci = &get_instance();
        $ci->load->model('operational_model');
        return $ci->operational_model->fetch_file_data($operational_manual_id);
    }

}

if (!function_exists('office_manager_by_office_id')) {

    function office_manager_by_office_id($office_id) {
        $ci = &get_instance();
        $ci->load->model('administration');
        return $ci->administration->get_office_manager_info_by_office_id($office_id);
    }

}

if (!function_exists('get_operational_sub_titles_by_id')) {

    function get_operational_sub_titles_by_id($main_title_id) {
        $ci = &get_instance();
        $ci->load->model('operational_model');
        return $ci->operational_model->get_operational_sub_titles_by_id($main_title_id);
    }

}

if (!function_exists('get_content')) {

    function get_content($type, $id) {
        $ci = &get_instance();
        $ci->load->model('operational_model');
        return $ci->operational_model->get_content($type, $id);
    }

}

if (!function_exists('lead_list')) {

    function lead_list($lead_type, $status, $request_by = "", $lead_contact_type = "") {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return $ci->lead_management->get_lead_list($lead_type, $status, $request_by, $lead_contact_type);
    }

}

if (!function_exists('get_assigned_dept_news')) {

    function get_assigned_dept_news($news_id, $office_type) {
        $ci = &get_instance();
        $ci->load->model('News_Update_model');
        return $ci->News_Update_model->get_assigned_dept_news($news_id, $office_type);
    }

}

if (!function_exists('get_assigned_staff_news')) {

    function get_assigned_staff_news($news_id) {
        $ci = &get_instance();
        $ci->load->model('News_Update_model');
        return $ci->News_Update_model->get_assigned_staff_news($news_id);
    }

}

if (!function_exists('get_news_view_count')) {

    function get_news_view_count($news_id) {
        $ci = &get_instance();
        $ci->load->model('News_Update_model');
        return $ci->News_Update_model->get_news_view_count($news_id);
    }

}
if (!function_exists('get_all_assigened_staff_news')) {

    function get_all_assigened_staff_news($news_id) {
        $ci = &get_instance();
        $ci->load->model('News_Update_model');
        return $ci->News_Update_model->get_all_assigened_staff_news($news_id);
    }

}


if (!function_exists('staff_office_for_invoice')) {

    function staff_office_for_invoice($invoice_id) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->staff_office_for_invoice($invoice_id);
    }

}

if (!function_exists('check_if_service_already_assigned')) {

    function check_if_service_already_assigned($service_id) {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->check_if_service_already_assigned($service_id);
    }

}

if (!function_exists('count_unassign_orders')) {

    function count_unassign_orders() {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->count_unassign_orders();
    }

}

if (!function_exists('get_dept_mngr')) {

    function get_dept_mngr($dept_id) {
        $ci = &get_instance();
        $ci->load->model('administration');
        return $ci->administration->get_dept_mngr($dept_id);
    }

}

if (!function_exists('get_ofc_mngr')) {

    function get_ofc_mngr($ofc_id) {
        $ci = &get_instance();
        $ci->load->model('administration');
        return $ci->administration->get_ofc_mngr($ofc_id);
    }

}

if (!function_exists('count_unread_news_update_by_userId')) {

    function count_unread_news_update_by_userId($user_id, $type, $dept_str) {
        $ci = &get_instance();
        $ci->load->model('News_Update_model');
        return $ci->News_Update_model->count_unread_news_update_by_userId($user_id, $type, $dept_str);
    }

}

if (!function_exists('get_document_count')) {

    function get_document_count($reference_id, $reference,$order_id) {
        $ci = &get_instance();
        $ci->load->model('Service_model');
        $number_of_docs = $ci->Service_model->get_document_list_by_reference_id($reference_id, $reference,$order_id);
        return sizeof($number_of_docs);
    }

}
if (!function_exists('get_assigned_dept_staff_project_template')) {

    function get_assigned_dept_staff_project_template($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_dept_staff_project_template($template_id);
    }

}
if (!function_exists('get_assigned_dept_staff_project_main')) {

    function get_assigned_dept_staff_project_main($project_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_dept_staff_project_main($project_id);
    }

}
if (!function_exists('getTemplateTaskList')) {

    function getTemplateTaskList($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->db->get_where('project_template_task', ['template_main_id' => $template_id])->result();
    }

}
if (!function_exists('getProjectTaskList')) {

    function getProjectTaskList($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        $ci->db->select('pt.*,pm.template_cat_id');
        $ci->db->from('project_task  pt');
        $ci->db->join('project_main  pm','pt.project_id=pm.project_id');
        $ci->db->where('pt.project_id',$template_id);
        return $ci->db->get()->result();
    }

}

if (!function_exists('getTemplateStaffList')) {

    function getTemplateStaffList($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        $department_id = $ci->Project_Template_model->getTemplateStaffList($template_id);
        $office_id = '';
        $department = $department_id->department_id;
        if ($department == 2) {
            $office_id = $department_id->office_id;
            return $ci->Project_Template_model->getTemplateOfficeStaffList($office_id, $department);
        } else {
            return $ci->Project_Template_model->getTemplateOfficeStaffList($office_id, $department);
        }
    }

}

if (!function_exists('get_assigned_task_staff')) {

    function get_assigned_task_staff($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_task_staff($template_id);
    }

}
if (!function_exists('get_assigned_project_task_staff')) {

    function get_assigned_project_task_staff($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_project_task_staff($template_id);
    }

}
if (!function_exists('get_assigned_task_department')) {

    function get_assigned_task_department($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_task_department($template_id);
    }

}
if (!function_exists('get_assigned_project_task_department')) {

    function get_assigned_project_task_department($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_project_task_department($template_id);
    }

}
if (!function_exists('get_task_note_count')) {

    function get_task_note_count($task_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getTaskNoteCount($task_id);
    }

}
if (!function_exists('get_assigned_template_department')) {

    function get_assigned_template_department($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_template_department($template_id);
    }

}
if (!function_exists('get_assigned_project_main_department')) {

    function get_assigned_project_main_department($project_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_project_main_department($project_id);
    }

}
if (!function_exists('get_assigned_template_office')) {

    function get_assigned_template_office($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_template_office($template_id);
    }

}
if (!function_exists('get_assigned_project_main_template_office')) {

    function get_assigned_project_main_template_office($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_project_main_template_office($template_id);
    }

}

if (!function_exists('get_template_responsible_staff')) {

    function get_template_responsible_staff($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_template_responsible_staff($template_id);
    }

}

if (!function_exists('notes_read_status')) {

    function notes_read_status($id) {
        $ci = &get_instance();
        $ci->load->model('Action_model');
        return $ci->Action_model->get_read_status($id);
    }

}

if (!function_exists('get_lead_note_count')) {

    function get_lead_note_count($id) {
        $ci = &get_instance();
        $ci->load->model('Lead_management');
        return $ci->Lead_management->get_lead_note_count($id);
    }

}

if (!function_exists('action_notes_read_status')) {

    function action_notes_read_status($id,$staffid) {
        $ci = &get_instance();
        $ci->load->model('Action_model');
        return $ci->Action_model->get_action_notes_read_status($id,$staffid);
    }

}


if (!function_exists('project_notes_read_status')) {

    function project_notes_read_status($id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_project_notes_read_status($id);
    }

}


if (!function_exists(' project_task_notes_readstatus')) {

    function project_task_notes_readstatus($id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_project_task_notes_readstatus($id);
    }

}

if (!function_exists('visitnotes_read_status')) {

    function visitnotes_read_status($id) {
        $ci = &get_instance();
        $ci->load->model('Visitation_model');
        return $ci->Visitation_model->get_read_visitstatus($id);
    }

}

if (!function_exists('get_ofc_by_id')) {

    function get_ofc_by_id($ofc_id) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_ofc_by_id($ofc_id);
    }

}
if (!function_exists('get_template_pattern')) {

    function get_template_pattern($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getTemplatePatternValue($template_id);
    }

}
if (!function_exists('get_project_pattern')) {

    function get_project_pattern($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getProjectPatternValue($template_id);
    }

}

if (!function_exists('get_sos_list')) {

    function get_sos_list($action, $serviceid, $actionid) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->show_sos($action, $serviceid, $actionid);
    }

}

if (!function_exists('get_action_status')) {

    function get_action_status($related_table_id, $foreign_column, $foreign_value) {
        $ci = &get_instance();
        $ci->load->model('notes');
        return $ci->notes->note_list_with_log($related_table_id, $foreign_column, $foreign_value);
    }

}
if (!function_exists('get_pattern_details')) {

    function get_pattern_details($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_pattern_details($template_id);
    }

}
if (!function_exists('get_project_pattern_details')) {

    function get_project_pattern_details($project_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_project_pattern_details($project_id);
    }

}
if (!function_exists('get_assigned_office_staff_project_template')) {

    function get_assigned_office_staff_project_template($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_office_staff_project_template($template_id);
    }

}
if (!function_exists('get_assigned_office_staff_project_main')) {

    function get_assigned_office_staff_project_main($project_id, $client_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_assigned_office_staff_project_main($project_id, $client_id);
    }

}
if (!function_exists('getTemplateOfficeStaff')) {

    function getTemplateOfficeStaff($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getTemplateOfficeStaff($template_id);
    }

}
if (!function_exists('getProjectOfficeStaff')) {

    function getProjectOfficeStaff($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getProjectOfficeStaff($template_id);
    }

}
if (!function_exists('getTemplateDepartmentStaff')) {

    function getTemplateDepartmentStaff($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getTemplateDepartmentStaff($template_id);
    }

}
if (!function_exists('getProjectDepartmentStaff')) {

    function getProjectDepartmentStaff($project_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getProjectDepartmentStaff($project_id);
    }

}
if (!function_exists('getTaskStaffList')) {

    function getTaskStaffList($task_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getTaskStaffList($task_id);
    }

}
if (!function_exists('getProjectTaskStaffList')) {

    function getProjectTaskStaffList($task_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getProjectTaskStaffList($task_id);
    }

}
if (!function_exists('getProjectTemplateDetailsById')) {

    function getProjectTemplateDetailsById($template_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getTemplateDetailsById($template_id)->row();
    }

}
if (!function_exists('get_project_note_count')) {

    function get_project_note_count($project_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getProjectNoteCount($project_id);
    }

}
if (!function_exists('getProjectClient')) {

    function getProjectClient($project_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getProjectClient($project_id);
    }

}
if (!function_exists('getProjectClientName')) {

    function getProjectClientName($client_id, $client_type) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getProjectClientName($client_id, $client_type);
    }

}

if (!function_exists('get_secuirity_details')) {

    function get_secuirity_details($id) {
        $ci = &get_instance();
        $ci->load->model('service');
        return $ci->service->getSecuirityDetails($id);
    }

}

if (!function_exists('get_client_fye')) {

    function get_client_fye($ref_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_client_fye($ref_id);
    }

}

if (!function_exists('get_p_m_ca_name')) {

    function get_p_m_ca_name($resp_value, $project_id, $client_type) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_p_m_ca_name($resp_value, $project_id, $client_type);
    }

}
if (!function_exists('get_p_m_ca_ofc_name')) {

    function get_p_m_ca_ofc_name($resp_value, $project_id, $client_type) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_p_m_ca_ofc_name($resp_value, $project_id, $client_type);
    }

}


if (!function_exists('get_individual_by_id')) {

    function get_individual_by_id($individual_id) {
        $ci = &get_instance();
        $ci->load->model('individual');
        return $ci->individual->get_individual_by_id($individual_id);
    }

}

if (!function_exists('get_action_notifications_count')) {

    function get_action_notifications_count($forvalue) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_action_notifications_count($forvalue);
    }

}
if (!function_exists('get_lead_notifications_count')) {

    function get_lead_notifications_count($forvalue) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_lead_notifications_count($forvalue);
    }

}
if (!function_exists('get_partner_notifications_count')) {

    function get_partner_notifications_count($forvalue) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_partner_notifications_count($forvalue);
    }

}
if (!function_exists('get_service_notifications_count')) {

    function get_service_notifications_count($forvalue) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_service_notifications_count($forvalue);
    }

}
if (!function_exists('get_invoice_notifications_count')) {

    function get_invoice_notifications_count() {
        $where['gn.action'] = 'tracking';
        $where['gn.reference'] = 'invoice';
        $ci = &get_instance();
        $ci->load->model('system');
        $result = $ci->system->get_general_notification_by_user_id(sess('user_id'), '', $where);
        if (!empty($result)) {
            return count($result);
        } else {
            return 0;
        }
    }

}

if (!function_exists('get_action_sos_added_username')) {

    function get_action_sos_added_username($reference, $reference_id, $userid) {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_action_sos_added_user($reference, $reference_id, $userid);
    }

}

if (!function_exists('invoice_service_payment_status')) {

    function invoice_service_payment_status($invoice_id, $service_id, $total_amount) {
        $ci = &get_instance();
        $ci->load->model('billing_model');
        return $ci->billing_model->get_invoice_service_payment_status($invoice_id, $service_id, $total_amount);
    }

}
if (!function_exists('project_list')) {

    function project_list($request = '', $status = '', $priority = '', $office_id = '', $department_id = '',$template_cat_id='') {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');

        $ci->load->library('session');
//        echo $ci->session->userdata('nw_actions');die;
        if ($request == '') {
            if ($status == 0) {

                if ($ci->session->userdata('nw_actions')) {
                    return $ci->session->userdata('nw_actions');
                } else {

                    return $_SESSION['nw_actions'] = count($ci->Project_Template_model->get_project_list($request, $status, $priority, $office_id, $department_id,$template_cat_id));
                }
            } elseif ($status == 1) {

                if ($ci->session->userdata('s_actions')) {
                    return $ci->session->userdata('s_actions');
                } else {

                    return $_SESSION['s_actions'] = count($ci->Project_Template_model->get_project_list($request, $status, $priority, $office_id, $department_id,$template_cat_id));
                }
            }
        } else {
            return count($ci->Project_Template_model->get_project_list($request, $status, $priority, $office_id, $department_id));
        }
    }

}
if (!function_exists('get_project_notifications_count')) {

    function get_project_notifications_count() {
        $ci = &get_instance();
        $ci->load->model('system');
        return $ci->system->get_project_notifications_count();
    }

}

if (!function_exists('get_visitation_note_count')) {

    function get_visitation_note_count($id) {
        $ci = &get_instance();
        $ci->load->model('Visitation_model');
        return $ci->Visitation_model->get_visitation_note_count($id);
    }

}

if (!function_exists('get_visitation_attachment_count')) {

    function get_visitation_attachment_count($id) {
        $ci = &get_instance();
        $ci->load->model('Visitation_model');
        return $ci->Visitation_model->get_visitation_attachment_count($id);
    }

}

if (!function_exists('service_list_by_order_id')) {

    function service_list_by_order_id($order_id) {
        $ci = &get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->get_service_list_by_order_id($order_id);
    }

}
if (!function_exists('get_requested_to_partner')) {

    function get_requested_to_partner($id) {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return $ci->lead_management->get_requested_to_partner($id);
    }

}
if (!function_exists('get_requested_to_partner_id')) {

    function get_requested_to_partner_id($id) {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return $ci->lead_management->get_requested_to_partner_id($id);
    }

}


if (!function_exists('service_fees')) {

    function service_fees($office_id, $service_id) {
        $ci = &get_instance();
        $ci->load->model('administration');
        return $ci->administration->get_service_fees($office_id, $service_id);
    }

}
if (!function_exists('task_list')) {

    function task_list($request = '', $status = '', $priority = '', $office_id = '', $department_id = '') {
        $ci = &get_instance();
        $ci->load->model('Task_model');

        $ci->load->library('session');
//        echo $ci->session->userdata('nw_actions');die;
        if ($request == '') {
            if ($status == 0) {

                if ($ci->session->userdata('nw_actions')) {
                    return $ci->session->userdata('nw_actions');
                } else {

                    return $_SESSION['nw_actions'] = count($ci->Task_model->get_task_list($request, $status, $priority, $office_id, $department_id));
                }
            } elseif ($status == 1) {

                if ($ci->session->userdata('s_actions')) {
                    return $ci->session->userdata('s_actions');
                } else {

                    return $_SESSION['s_actions'] = count($ci->Task_model->get_task_list($request, $status, $priority, $office_id, $department_id));
                }
            }
        } else {
            return count($ci->Task_model->get_task_list($request, $status, $priority, $office_id, $department_id));
        }
    }

}
if (!function_exists('get_lead_list_to_partner')) {

    function get_lead_list_to_partner($lead_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        // return $ci->referral_partner->get_lead_list_referred_by_partner($lead_id);
        return $ci->referral_partner->load_referral_partners_dashboard_data($lead_id);
    }

}
if (!function_exists('get_lead_list_by_partner')) {

    function get_lead_list_by_partner($lead_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return $ci->referral_partner->load_referred_leads_dashboard_data('', $lead_id);
    }

}

if (!function_exists('get_partner_to_staff_count')) {

    function get_partner_to_staff_count($lead_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        // return count($ci->referral_partner->load_referral_partners_dashboard_data('', '', $lead_id));
        return count($ci->referral_partner->load_referral_partners_dashboard_data($lead_id));
    }

}
if (!function_exists('get_staff_to_partner_count')) {

    function get_staff_to_partner_count($lead_id) {
        $ci = &get_instance();
        $ci->load->model('Referral_partner');
        return count($ci->referral_partner->load_referred_leads_dashboard_data('', $lead_id));
    }

}

if (!function_exists('ProjectTaskStaffList')) {

    function ProjectTaskStaffList($taskid) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->projectTaskStaffList($taskid);
    }

}
if (!function_exists('get_project_task_note_count')) {

    function get_project_task_note_count($task_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->getProjectTaskNoteCount($task_id);
    }

}

if (!function_exists('get_project_officeID_by_project_id')) {

    function get_project_officeID_by_project_id($project_id) {
        $ci = &get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_project_officeID_by_project_id($project_id);
    }

}
if (!function_exists('partnerList')) {

    function partnerList($status, $request) {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return count($ci->lead_management->get_leads_referred_by_to_him($status, $request));
    }

}

if (!function_exists('get_partner_count')) {

    function get_partner_count($request_type) {
        $ci = &get_instance();
        $ci->load->model('lead_management');
        return count($ci->referral_partner->getReferralPartnerData($request_type));
    }

}

if (!function_exists('get_partnes')) {

    function get_partnes() {
        $ci = &get_instance();
        $ci->load->model('referral_partner');
        return $ci->referral_partner->getPartnerData();
    }

}

if(!function_exists('getTaskFilesCount')){
    function getTaskFilesCount($task_id){
       $ci = &get_instance();
       $ci->load->model('project_template_model');
       return $ci->project_template_model->getTaskFilesCount($task_id);
    }
}
if(!function_exists('getUnreadTaskFileCount')){
    function getUnreadTaskFileCount($task_id,$reference){
        $ci = &get_instance();
       $ci->load->model('project_template_model');
       return $ci->project_template_model->getUnreadTaskFileCount($task_id,$reference);
    }
}
if(!function_exists('getTemplateCategoryProjectList')){
    function getTemplateCategoryProjectList($template_id,$template_cat_id='',$month=''){
        $ci=&get_instance();
        $ci->load->model("project_template_model");
        return $ci->project_template_model->get_project_list('','',$template_id,'','','','','','','','','',$template_cat_id,$month);
    }
}
if(!function_exists('getProjectListAccordingToMonth')){
    function getProjectListAccordingToMonth($template_cat_id='',$month=''){
        $ci=&get_instance();
        $ci->load->model("project_template_model");
        return $ci->project_template_model->get_project_list('','','','','','','','','','','','',$template_cat_id,$month);
    }
}
if(!function_exists('getProjectCountByClientId')){
    function getProjectCountByClientId($client_id){
        $ci =&get_instance();
        $ci->load->model('Project_Template_model');
        return $ci->Project_Template_model->get_project_count_by_client_id($client_id);
    }
}
if(!function_exists('get_service_by_id')){
    function get_service_by_id($id){
        $ci =&get_instance();
        $ci->load->model('service_model');
        return $ci->service_model->get_service_by_id($id);
    }
}
