<?php

class Company_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('company');
        $this->load->model('company_model');
        $this->load->model('action_model');
        $this->load->model('service_model');
        $this->load->model('salestax_model');
        $this->load->model('system');
        $this->load->model('notes');
        $this->load->model('internal');
        $this->load->model('service');
        $this->load->model('billing_model');
        $this->load->model('internal_model');
    }

    public function save_company($data) {
        $data = (object) $data; // convert array to object
        if ($data->name_of_business1) {
            $company_data['name'] = $data->name_of_business1;
        }
        if (isset($data->type)) {
            $company_data['type'] = $data->type;
        }
        if (!isset($data->incorporated_date)) {
            $company_data['incorporated_date'] = date("Y-m-d");
        } else {
            $company_data['incorporated_date'] = $data->incorporated_date;
        }
        if (isset($data->state)) {
            $company_data['state_opened'] = $data->state;
        } elseif (isset($data->istate)) {
            $company_data['state_opened'] = $data->istate;
        } else {
            $company_data['state_opened'] = 0;
        }
        if (isset($data->start_year)) {
            $company_data['start_month_year'] = $data->start_year;
        }
        if (isset($data->fein)) {
            $company_data['fein'] = $data->fein;
        }
        if (isset($data->dba)) {
            $company_data['dba'] = $data->dba;
        }
        if (isset($data->business_description)) {
            $company_data['business_description'] = $data->business_description;
        }
        if (isset($data->fiscal_year_end)) {
            $company_data['fye'] = $data->fiscal_year_end;
        }
        if (isset($data->state_other)) {
            $company_data['state_others'] = $data->state_other;
        }
        if (isset($data->reference_id)) {
            $check = $this->db->get_where('company', ['id' => $data->reference_id]);
            if ($check->num_rows() == 0) {
                $company_data['id'] = $data->reference_id;
                $company_data['status'] = 1;
                $result = $this->db->insert('company', $company_data);
                if ($result) {
                    $temp_data = [
                        "reference" => "company",
                        "reference_id" => $company_data['id'],
                        "date" => $this->system->getDateTime()
                    ];
                    $this->db->insert("temp", $temp_data);
                    $this->system->log("insert", "company", $company_data['id']);
                    return true;
                } else {
                    return false;
                }
            } else {
                $reference_id = $data->reference_id;
                $this->db->where(['id' => $reference_id]);
                $result = $this->db->update('company', $company_data);
                if ($result) {
                    $this->system->log("update", "company", $reference_id);
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function save_company_data($data) {
        if (!isset($data['incorporated_date'])) {
            $data['incorporated_date'] = date("d/m/Y");
        }

        $data['incorporated_date'] = $this->system->invertDate($data['incorporated_date']);
        $this->db->where(['id' => $data['id']]);
        $check = $this->db->get('company');

        if ($check->num_rows() == 0) {
            $data['status'] = 1;
            $result = $this->db->insert('company', $data);
//            exit;
//            echo $this->db->last_query();
            if ($result) {
                $temp_data = [
                    "reference" => "company",
                    "reference_id" => $data['id'],
                    "date" => $this->system->getDateTime()
                ];
                $this->db->insert("temp", $temp_data);
//                  echo $this->db->last_query();
                $this->system->log("insert", "company", $data['id']);
//                  echo $this->db->last_query();
                return true;
            } else {
                return false;
            }
        } else {
            $reference_id = $data['id'];
            $this->db->where(['id' => $reference_id]);
            $result = $this->db->update('company', $data);
            if ($result) {
                $this->system->log("update", "company", $reference_id);
                return true;
            } else {
                return false;
            }
        }
    }

    public function make_company_data($data) {
        $data = (object) $data; // convert the post array into an object

        if ($data->name_of_business1) {
            $return_data['name'] = $data->name_of_business1;
        }
        if ($data->type) {
            $return_data['type'] = $data->type;
        }
        if ($data->state_other) {
            $return_data['state_others'] = $data->state_other;
        }
        if ($data->reference_id) {
            $return_data['id'] = $data->reference_id;
        }
        if (!isset($data->incorporated_date)) {
            $return_data['incorporated_date'] = date("d/m/Y");
        } else {
            $return_data['incorporated_date'] = $data->incorporated_date;
        }
        if (!isset($data->state)) {
            $return_data['state_opened'] = 0;
        } else {
            $return_data['state_opened'] = $data->state;
        }
        if (isset($data->start_year) && $data->start_year != "") {
            $return_data['start_month_year'] = $data->start_year;
        }
        if (isset($data->fein) && $data->fein != "") {
            $return_data['fein'] = $data->fein;
        }
        if (isset($data->dba) && $data->dba != "") {
            $return_data['dba'] = $data->dba;
        } else {
            $return_data['dba'] = "";
        }

        $return_data['business_description'] = $data->business_description;
        $return_data['fye'] = $data->fiscal_year_end;

        return $return_data;
    }

    public function make_payroll_company_data($data) {
        $data = (object) $data; // convert the post array into an object

        if ($data->name_of_company) {
            $return_data['name'] = $data->name_of_company;
        }
        if ($data->type) {
            $return_data['type'] = $data->type;
        }
        if ($data->reference_id) {
            $return_data['id'] = $data->reference_id;
        }
        if (!isset($data->incorporated_date)) {
            $return_data['incorporated_date'] = date("d/m/Y");
        } else {
            $return_data['incorporated_date'] = $data->incorporated_date;
        }
//        echo $data->istate; exit;
//        if (!isset($data->istate)) {
//            $return_data['state_opened'] = 0;
//        } else {
//            $return_data['state_opened'] = $data->istate;
//        }
        if (!isset($data->company_email)) {
            $return_data['email'] = '';
        } else {
            $return_data['email'] = $data->company_email;
        }
        if (!isset($data->company_fax)) {
            $return_data['fax'] = '';
        } else {
            $return_data['fax'] = $data->company_fax;
        }
        if (!isset($data->dba)) {
            $return_data['dba'] = '';
        } else {
            $return_data['dba'] = $data->dba;
        }
        if (!isset($data->state_other)) {
            $return_data['state_others'] = '';
        } else {
            $return_data['state_others'] = $data->state_other;
        }
        $return_data['state_opened'] = $data->istate;
        $return_data['business_description'] = $data->business_description;
        $return_data['fye'] = $data->fye;
        $return_data['fein'] = $data->fein;
        $return_data['start_month_year'] = $data->start_year;

        return $return_data;
    }

    public function remove_company_temp_flag($id) {
        $sql = "update company set status=1 where id=$id";
        $conn = $this->db;
        if ($conn->query($sql)) {
            $conn->query("delete from temp where reference='company' and reference_id=$id");
            return true;
        } else {
            return false;
        }
    }

    public function save_company_name_options($data, $reference_id) {
        $this->db->select('id');
        $exist = $this->db->get_where("new_company", ['company_id' => $reference_id]);
        if ($exist->num_rows()) {
            $this->db->where(['company_id' => $reference_id]);
            $result = $this->db->update('new_company', $data);
        } else {
            $data['company_id'] = $reference_id;
            $result = $this->db->insert("new_company", $data);
        }
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_company_details($id) {

        $this->db->select("*");
        $this->db->from("company");
        $this->db->where("id", $id);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function get_company_type($id) {
        $this->db->select("*");
        $this->db->from("company_type");
        $this->db->where("id", $id);

        $data = $this->db->get()->row_array();
        return $data;
    }

    public function request_create_annual_report($data) {
        $this->db->trans_begin();
//        print_r($data);
//        exit;
        if ($data['type_of_client'] == 0) {
            $company_data = $this->company_model->get_company_by_id($data['client_list']);
            $data['name_of_business1'] = $data['name_of_company'] = $company_data['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        if ($data['editval'] == '') {
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }

            //    Save order 
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }

            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->insert_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end

            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');

                // $action_data['created_office'] = $staff_info['office'];
                // $action_data['created_department'] = $staff_info['department'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                if (!$this->internal->saveInternalData($data)) {    // Save internal data
                    return false;
                }
            }

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            //print_r($data);exit;
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            if (isset($data['edit_company_notes'])) {
                $this->notes->update_note(1, $data['edit_company_notes']);
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }

            if (isset($data['edit_order_notes'])) {
                $this->notes->update_note(1, $data['edit_order_notes']);
            }

            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function get_retail_price($description) {
        return $this->db->query("select retail_price from services where `description` like '$description'")->row_array();
    }

    public function getretailprice($data) {

        $service_id = $data['service_id'];
        return $this->db->query("select * from services where id='$service_id'")->row_array();
    }

    public function request_create_company($data) {
        $staff_info = staff_info();
        $this->load->model('billing_model');
        $this->db->trans_begin();
        $data['type_of_client'] = 1;
        if ($data['editval'] == '') {
            $data['company']['name'] = $data['new_company']['name1'];

            $data['company']['id'] = $data['reference_id'];
            $data['company']['state_others'] = $data['state_other'];
            $reference_id = $data['reference_id'];
            if (!$this->save_company_data($data['company'])) {
                return false;
            } else {
                $this->remove_company_temp_flag($reference_id);
            }

            $this->company->saveCompanyNameOptionsOnInsert($data);

            $data['internal_data']['reference_id'] = $reference_id;
            $data['internal_data']['reference'] = "company";
            $data['internal_data']['practice_id'] = $data['internal_data']['practice_id'];
            // Save company internal data
            if (!$this->internal_model->save_internal_data($data['internal_data'])) {
                return false;
            }//    Save order 

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }

            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->insert_invoice_data($data);
            if ($staff_info['office_manager'] != '') {
                $data['client'] = 'new company';
            }
//            $this->action_model->insert_client_action($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end
            //insert action on invoice
            $staff_info = staff_info();
            $this->db->where_in('department_id', '6');
            $department_staffs = $this->db->get('department_staff')->result_array();
            $department_staff = array_column($department_staffs, 'staff_id');

            $action_data['created_office'] = $data['staff_office'];
            $action_data['priority'] = '3';
            $action_data['department'] = '6';
            $action_data['office'] = '17';
            $action_data['is_all'] = '1';
            $action_data['staff'] = $department_staff;
            $action_data['client_id'] = '';
            $action_data['subject'] = 'New Client has been created';
            $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
            $action_data['action_notes'] = array();
            $action_data['due_date'] = '';

            //print_r($action_data); exit;
            $this->load->model('action_model');
            $this->action_model->insert_client_action($action_data);
            //insert action on invoice
        } else {
            $this->load->model('System');
            $this->load->model('Notes');
            if (!$this->company->saveCompany($data)) {
                return false;
            } else {
                $this->company->removeCompanyTempFlag($data['reference_id']);
            }

            // Save company internal data
            $this->load->model('Internal');
            if (!$this->internal->saveInternalData($data)) {
                return false;
            }

            // Save name options for the new company
            $this->company->saveCompanyNameOptions($data);

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            //print_r($data);exit;
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            if (isset($data['edit_company_notes'])) {
                $this->notes->update_note(1, $data['edit_company_notes']);
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }

            if (isset($data['edit_order_notes'])) {
                $this->notes->update_note(1, $data['edit_order_notes']);
            }

            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }

        /* mail section */
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function request_create_company_non_profit_fl($data) {
        $staff_info = staff_info();
        $this->load->model('billing_model');
        $this->db->trans_begin();
        $data['type_of_client'] = 1;
        if ($data['editval'] == '') {
            $data['company']['name'] = $data['new_company']['name1'];
            $data['company']['id'] = $data['reference_id'];
            $reference_id = $data['reference_id'];
            if (!$this->save_company_data($data['company'])) {
                return false;
            } else {
                $this->remove_company_temp_flag($reference_id);
            }
            $data['internal_data']['reference_id'] = $reference_id;
            $data['internal_data']['reference'] = "company";
            // Save company internal data
            if (!$this->internal_model->save_internal_data($data['internal_data'])) {
                return false;
            }//    Save order 

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }

            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }
            $extra_data['activity'] = $data['activity'];
            $this->service_model->save_order_extra_data($data['order_id'], $extra_data);
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->insert_invoice_data($data);
            if ($staff_info['office_manager'] != '') {
                $data['client'] = 'new company';
            }
//            $this->action_model->insert_client_action($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end
            //insert action on invoice
            $staff_info = staff_info();
            $this->db->where_in('department_id', '6');
            $department_staffs = $this->db->get('department_staff')->result_array();
            $department_staff = array_column($department_staffs, 'staff_id');


            $action_data['created_office'] = $data['staff_office'];
            $action_data['priority'] = '3';
            $action_data['department'] = '6';
            $action_data['office'] = '17';
            $action_data['is_all'] = '1';
            $action_data['staff'] = $department_staff;
            $action_data['client_id'] = '';
            $action_data['subject'] = 'New Client has been created';
            $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
            $action_data['action_notes'] = array();
            $action_data['due_date'] = '';

            //print_r($action_data); exit;
            $this->load->model('action_model');
            $this->action_model->insert_client_action($action_data);
            //insert action on invoice
        } else {
            $this->load->model('System');
            $this->load->model('Notes');
            if (!$this->company->saveCompany($data)) {
                return false;
            } else {
                $this->company->removeCompanyTempFlag($data['reference_id']);
            }

            // Save company internal data
            $this->load->model('Internal');
            if (!$this->internal->saveInternalData($data)) {
                return false;
            }

            // Save name options for the new company
            $this->company->saveCompanyNameOptions($data);

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            //print_r($data);exit;
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            if (isset($data['edit_company_notes'])) {
                $this->notes->update_note(1, $data['edit_company_notes']);
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }

            if (isset($data['edit_order_notes'])) {
                $this->notes->update_note(1, $data['edit_order_notes']);
            }
            $extra_data['activity'] = $data['activity'];
            $this->service_model->save_order_extra_data($data['order_id'], $extra_data);
            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }

        /* mail section */
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function request_create_new_florida_pa($data) {
        $staff_info = staff_info();
        $this->load->model('billing_model');
        $this->db->trans_begin();
        $data['type_of_client'] = 1;
        if ($data['editval'] == '') {
            $data['company']['name'] = $data['new_company']['name1'];
            $data['company']['id'] = $data['reference_id'];
            $reference_id = $data['reference_id'];
            if (!$this->save_company_data($data['company'])) {
                return false;
            } else {
                $this->remove_company_temp_flag($reference_id);
            }
            $data['internal_data']['reference_id'] = $reference_id;
            $data['internal_data']['reference'] = "company";
            // Save company internal data
            if (!$this->internal_model->save_internal_data($data['internal_data'])) {
                return false;
            }//    Save order 

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }

            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }
            $extra_data['activity'] = $data['activity'];
            $extra_data['social_activity'] = $data['social_activity'];
            $extra_data['professional_license_number'] = $data['professional_license_number'];
            $this->service_model->save_order_extra_data($data['order_id'], $extra_data);
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->insert_invoice_data($data);
            if ($staff_info['office_manager'] != '') {
                $data['client'] = 'new company';
            }
//            $this->action_model->insert_client_action($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end
            //insert action on invoice
            $staff_info = staff_info();
            $this->db->where_in('department_id', '6');
            $department_staffs = $this->db->get('department_staff')->result_array();
            $department_staff = array_column($department_staffs, 'staff_id');


            $action_data['created_office'] = $data['staff_office'];
            $action_data['priority'] = '3';
            $action_data['department'] = '6';
            $action_data['office'] = '17';
            $action_data['is_all'] = '1';
            $action_data['staff'] = $department_staff;
            $action_data['client_id'] = '';
            $action_data['subject'] = 'New Client has been created';
            $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
            $action_data['action_notes'] = array();
            $action_data['due_date'] = '';

            //print_r($action_data); exit;
            $this->load->model('action_model');
            $this->action_model->insert_client_action($action_data);
            //insert action on invoice
        } else {
            $this->load->model('System');
            $this->load->model('Notes');
            if (!$this->company->saveCompany($data)) {
                return false;
            } else {
                $this->company->removeCompanyTempFlag($data['reference_id']);
            }

            // Save company internal data
            $this->load->model('Internal');
            if (!$this->internal->saveInternalData($data)) {
                return false;
            }

            // Save name options for the new company
            $this->company->saveCompanyNameOptions($data);

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            //print_r($data);exit;
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            if (isset($data['edit_company_notes'])) {
                $this->notes->update_note(1, $data['edit_company_notes']);
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }

            if (isset($data['edit_order_notes'])) {
                $this->notes->update_note(1, $data['edit_order_notes']);
            }
            $extra_data['activity'] = $data['activity'];
            $extra_data['social_activity'] = $data['social_activity'];
            $extra_data['professional_license_number'] = $data['professional_license_number'];
            $this->service_model->save_order_extra_data($data['order_id'], $extra_data);
            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }

        /* mail section */
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function getService($id) {
        $sql = "SELECT s.id, s.category_id, c.name as category_name, c.description as category_description, s.description, s.ideas, s.tutorials, s.retail_price 
                FROM services s
                INNER JOIN category c on c.id = s.category_id
                where s.id = $id";
        $data = $this->db->query($sql)->result()[0];
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function get_company_data($reference_id) {

        $this->db->select("*");
        $this->db->from("company");
        $this->db->where("id", $reference_id);

        $data = $this->db->get()->result_array();
//        print_r($data);
        return $data;
    }

    public function get_company_by_id($id) {
        $this->db->select('company.*, (SELECT type FROM company_type WHERE id = company.type) AS company_type, (SELECT state_name FROM states WHERE id = company.state_opened) AS state_name');
        return $this->db->get_where("company", ["id" => $id])->row_array();
    }

    public function get_company_name_option_data($reference_id) {
        $this->db->select("*");
        $this->db->from("new_company");
        $this->db->where("company_id", $reference_id);

        $data = $this->db->get()->result_array();
//        print_r($data);
        return $data;
    }

    public function get_company_order_data($reference_id) {
        $this->db->select("*");
        $this->db->from("order");
        $this->db->where("reference", "company");
        $this->db->where("reference_id", $reference_id);

        $data = $this->db->get()->result_array();
//        print_r($data);
        return $data;
    }

    public function get_company_internal_data($reference_id) {
        $this->db->select("*");
        $this->db->from("internal_data");
        $this->db->where("reference", "company");
        $this->db->where("reference_id", $reference_id);

        $data = $this->db->get()->result_array();
//        print_r($data);
        return $data;
    }

    public function update_contact($contact_id, $reference_id) {
        $this->db->where('id', $contact_id);
        $this->db->update('contact_info', ['reference_id' => $reference_id]);
    }

    public function update_document($document_id, $reference_id) {
        $this->db->where('id', $document_id);
        $this->db->update('documents', ['reference_id' => $reference_id]);
    }

    public function get_account_details($reference_id,$client_id='') {
//        echo $reference_id;die;
        $this->db->select("*");
        $this->db->from("payroll_account_numbers");
        $this->db->join("company", "company.id=payroll_account_numbers.reference_id");
        $this->db->where("reference_id", $reference_id);
        $this->db->group_by("ban_account_number");
        $data = $this->db->get()->result_array();
        return $data;
    }
    public function getOrderID($reference_id){
        $this->db->select('id');
        $this->db->from('order');
        $this->db->where(['reference_id'=>$reference_id,'reference'=>'company']);
        return $this->db->get()->result_array();
    }
    public function getFinancialAccountDetails($orderid,$client_id){
        $oid=array();
        foreach($orderid as $val){
           $oid[]= $val['id'];
        }
        if(!empty($client_id)){
            $this->db->select("id,client_id,bank_name, account_number as ban_account_number, routing_number as bank_routing_number,type_of_account,user,bank_website,password");
            $this->db->from('financial_accounts');
            $this->db->where('client_id',$client_id);
//            $this->db->where_in('order_id',$oid);
            $this->db->group_by('account_number');
            return $this->db->get()->result_array();
        }else{
            return array();
        }
    }

    public function get_account_details_bookkeeping($reference_id,$reference='',$client_id='') {
        if($reference==''){
            $this->db->where('client_id',$client_id);
            $this->db->or_where('client_id',$reference_id);
            $this->db->group_by("account_number");
            return $this->db->get('financial_accounts')->result_array();
//            return $this->db->get_where('financial_accounts',['client_id'=>$client_id])->result_array();
//            $order_list = $this->db->get_where('order', ['reference_id' => $reference_id, 'reference' => 'company'])->result_array();
//            if (!empty($order_list)) {
//                $this->db->where_in("order_id", array_column($order_list, 'id'));
//                $this->db->group_by("account_number");
//                return $this->db->get('financial_accounts')->result_array();
//            } else {
//                return [];
//            }
        }else{
            $this->db->where('client_id',$reference_id);
            $this->db->group_by("account_number");
            return $this->db->get('financial_accounts')->result_array();
        }
    }

    public function get_fein_details($id) {
        $this->db->select("*");
        $this->db->from("fein_application");
        $this->db->where("reference_id", $id);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function request_create_corporate_amendment($data) {
        $this->db->trans_begin();
        if ($data['type_of_client'] == 0) {
            $company_data = $this->company_model->get_company_by_id($data['client_list']);
            $data['name_of_business1'] = $data['name_of_company'] = $company_data['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        if ($data['editval'] == '') {
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }
            //    Save order 
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);

            // if(isset($data['doc_ids']) && $data['doc_ids']!=''){
            //     $doc_array = explode(",",$data['doc_ids']);
            //     $this->db->where_in('id', $doc_array);
            //     $this->db->update('documents', array('order_id' => $order_id));
            // }

            $this->billing_model->insert_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end
            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['staff_office'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                if (!$this->internal->saveInternalData($data)) {    // Save internal data
                    return false;
                }
            }
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);

            // if(isset($data['doc_ids']) && $data['doc_ids']!=''){
            //     $doc_array = explode(",",$data['doc_ids']);
            //     $this->db->where_in('id', $doc_array);
            //     $this->db->update('documents', array('order_id' => $order_id));
            // }

            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function request_create_fien_application($data) {
        $this->db->trans_begin();
        if ($data['type_of_client'] == 0) {
            $company_data = $this->company_model->get_company_by_id($data['client_list']);
            $data['name_of_business1'] = $data['name_of_company'] = $company_data['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        if ($data['editval'] == '') {
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }
            //    Save order 
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->insert_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end

            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['office'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                if (!$this->internal->saveInternalData($data)) {    // Save internal data
                    return false;
                }
            }
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function request_create_certificate_of_good_standing($data) {
        $this->db->trans_begin();
        if ($data['type_of_client'] == 0) {
            $company_data = $this->company_model->get_company_by_id($data['client_list']);
            $data['name_of_business1'] = $data['name_of_company'] = $company_data['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        if ($data['editval'] == '') {
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }
            //    Save order 
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }

            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->insert_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end

            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['staff_office'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                if (!$this->internal->saveInternalData($data)) {    // Save internal data
                    return false;
                }
            }
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            if (isset($data['edit_company_notes'])) {
                $this->notes->update_note(1, $data['edit_company_notes']);
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function request_create_certificate_shares($data) {
        $this->db->trans_begin();
//        print_r($data);
//        exit;
        if ($data['type_of_client'] == 0) {
            $company_data = $this->company_model->get_company_by_id($data['client_list']);
            $data['name_of_business1'] = $data['name_of_company'] = $company_data['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        if ($data['editval'] == '') {
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }

            //    Save order 
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }

            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);

            $this->billing_model->insert_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end

            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['staff_office'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                if (!$this->internal->saveInternalData($data)) {    // Save internal data
                    return false;
                }
            }

            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }

//            if (isset($data['certificate_shares_optional_service'])) {
//                $extra_service_data1 = $this->service_model->get_service($data['certificate_shares_optional_service']);
//                $data['related_service'][$data['editval']][$data['certificate_shares_optional_service']]['retail_price'] = (int) $extra_service_data1['retail_price'];
//                $data['related_service'][$data['editval']][$data['certificate_shares_optional_service']]['override_price'] = (int) $extra_service_data1['retail_price'];
//                $data['related_services'][] = $data['certificate_shares_optional_service'];
//            }
//            if (isset($data['shares_transfer_completion'])) {
//                $extra_service_data2 = $this->service_model->get_service($data['shares_transfer_completion']);
//                $data['related_service'][$data['editval']][$data['shares_transfer_completion']]['retail_price'] = (int) $extra_service_data2['retail_price'];
//                $data['related_service'][$data['editval']][$data['shares_transfer_completion']]['override_price'] = (int) $extra_service_data2['retail_price'];
//                $data['related_services'][] = $data['shares_transfer_completion'];
//            }
//            if (isset($data['extra_10'])) {
//                $extra_service_data3 = $this->service_model->get_service($data['extra_10']);
//                $data['related_service'][$data['editval']][$data['extra_10']]['retail_price'] = (int) $extra_service_data3['retail_price'];
//                $data['related_service'][$data['editval']][$data['extra_10']]['override_price'] = (int) $extra_service_data3['retail_price'];
//                $data['related_services'][] = $data['extra_10'];
//            }
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            if (isset($data['edit_company_notes'])) {
                $this->notes->update_note(1, $data['edit_company_notes']);
            }

            if (isset($data['order_notes'])) {
                $this->notes->insert_note(1, $data['order_notes'], 'reference_id', $order_id, 'order');
            }

            if (isset($data['edit_order_notes'])) {
                $this->notes->update_note(1, $data['edit_order_notes']);
            }

            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }
        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function request_create_operating_agreement($data) {
        $this->db->trans_begin();
        if ($data['type_of_client'] == 0) {
            $company_data = $this->company_model->get_company_by_id($data['client_list']);
            $data['name_of_business1'] = $data['name_of_company'] = $company_data['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        if ($data['editval'] == '') {
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }

            //    Save order 
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            if ($data['type'] != 3 && $data['type'] != 6) {

                foreach ($data['extra_services'] as $id => $serv_id) {
                    // if ($id == 0) {
                    //     $data['service_id'] = $serv_id;
                    // }else {
                    //     $data['related_services'][] = $serv_id;
                    // }
                    if ($serv_id != $data['service_id']) {
                        $data['related_services'][] = $serv_id;
                    }
                }
            }
            // print_r($data['related_services']); exit;
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $data['service_id']);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }

            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->insert_invoice_data($data);
            $extra_data = array('id' => '', 'order_id' => $order_id, 'document_date' => $data['doc_date']);
            $this->db->insert('order_extra_data', $extra_data);
            $this->system->save_general_notification('order', $order_id, 'insert');


            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['staff_office'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                if (!$this->internal->saveInternalData($data)) {    // Save internal data
                    return false;
                }
            }

            if ($data['type'] != 3 && $data['type'] != 6) {

                foreach ($data['extra_services'] as $id => $serv_id) {
                    // if ($id == 0) {
                    //     $data['service_id'] = $serv_id;
                    // }else {
                    //     $data['related_services'][] = $serv_id;
                    // }
                    if ($serv_id != $data['service_id']) {
                        $extra_service_data = $this->service_model->get_service($serv_id);
                        $data['related_service'][$data['editval']][$serv_id]['retail_price'] = (int) $extra_service_data['retail_price'];
                        $data['related_service'][$data['editval']][$serv_id]['override_price'] = (int) $extra_service_data['retail_price'];
                        $data['related_services'][] = $serv_id;
                    }
                }
            }
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            if (isset($data['company_notes'])) {
                $this->notes->insert_note(1, $data['company_notes'], 'reference_id', $data['reference_id'], 'company');
            }
            if (isset($data['edit_company_notes'])) {
                $this->notes->update_note(1, $data['edit_company_notes']);
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);
            $this->billing_model->update_invoice_data($data);
            $extra_data = array('document_date' => $data['doc_date']);
            $this->db->where(['order_id' => $order_id]);
            $this->db->update('order_extra_data', $extra_data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function get_company_name_by_company_id($company_id) {
        return $this->db->get_where('new_company', ["company_id" => $company_id])->row_array();
    }

    public function request_create_firpta($data) {
        $this->db->trans_begin();
        if ($data['type_of_client'] == 0) {
            $company_data = $this->company_model->get_company_by_id($data['client_list']);
            $data['name_of_business1'] = $data['name_of_company'] = $company_data['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        if ($data['editval'] == '') {
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }
            //    Save order 
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }




            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);

            $this->service_model->update_buyer_order_id($data['new_reference_id'], $order_id);
            $this->service_model->update_seller_order_id($data['new_reference_id'], $order_id);

            $extra_data['order_id'] = $order_id;
            $extra_data['property_address'] = $data['property_address'];
            $extra_data['property_city'] = $data['property_city'];
            $extra_data['property_state'] = $data['property_state'];
            $extra_data['property_zip'] = $data['property_zip'];
            $extra_data['closing_date'] = date('Y-m-d', strtotime($data['closing_date']));

            $this->db->insert('order_extra_data', $extra_data);

            $this->billing_model->insert_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end
            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['staff_office'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                if (!$this->internal->saveInternalData($data)) {    // Save internal data
                    return false;
                }
            }
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }

            $this->service_model->update_buyer_order_id($data['new_reference_id'], $order_id);
            $this->service_model->update_seller_order_id($data['new_reference_id'], $order_id);

            $extra_data['property_address'] = $data['property_address'];
            $extra_data['property_city'] = $data['property_city'];
            $extra_data['property_state'] = $data['property_state'];
            $extra_data['property_zip'] = $data['property_zip'];
            $extra_data['closing_date'] = date('Y-m-d', strtotime($data['closing_date']));

            $this->db->where('order_id', $order_id);
            $this->db->update('order_extra_data', $extra_data);

            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);

            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }


    public function request_create_legal_translations($data) {
        $this->db->trans_begin();
        if ($data['type_of_client'] == 0) {
            $company_data = $this->company_model->get_company_by_id($data['client_list']);
            $data['name_of_business1'] = $data['name_of_company'] = $company_data['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        if ($data['editval'] == '') {
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->internal->saveInternalData($data)) {
                    return false;
                }

//                $this->action_model->insert_client_action($data);
            }
            //    Save order 
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);

            // if(isset($data['doc_ids']) && $data['doc_ids']!=''){
            //     $doc_array = explode(",",$data['doc_ids']);
            //     $this->db->where_in('id', $doc_array);
            //     $this->db->update('documents', array('order_id' => $order_id));
            // }
            $this->service_model->order_extra_data_fields($data,$order_id);
                
            $this->billing_model->insert_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end
            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '14');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['staff_office'];
                $action_data['priority'] = '3';
                $action_data['department'] = '14';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else { // update started
            // print_r($data['editval']);exit;
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                if (!$this->internal->saveInternalData($data)) {    // Save internal data
                    return false;
                }
            }
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            // print_r($data['order_id']);exit;
            
            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);

            // if(isset($data['doc_ids']) && $data['doc_ids']!=''){
            //     $doc_array = explode(",",$data['doc_ids']);
            //     $this->db->where_in('id', $doc_array);
            //     $this->db->update('documents', array('order_id' => $order_id));
            // }
            $this->service_model->update_order_extra_data_fields($data,$order_id);
            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            
            return $order_id;
        }
    }


     public function request_create_1099_write_up($data) {
        $this->db->trans_begin();
        if ($data['type_of_client'] == 0) {
            $company_data = $this->company_model->get_company_by_id($data['client_list']);
            $data['name_of_business1'] = $data['name_of_company'] = $company_data['name'];
        } else {
            $data['name_of_business1'] = $data['name_of_company'];
        }
        if ($data['editval'] == '') {   // Insert section
            if ($data['type_of_client'] == 1) {     // Save company information
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                // Save company internal data
                if (!$this->internal->saveInternalData($data)) {
                    return false;
                }
//                $this->action_model->insert_client_action($data);
            }
            //    Save order 
            if (isset($data['retail_price_override'])) {
                $data['retail_price'] = ($data['retail_price_override'] == '') ? $data['retail_price'] : $data['retail_price_override'];
            } else {
                $data['retail_price'] = $data['retail_price'];
            }
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($order_id, $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->update_order_serial_id_by_order_id($order_id);
            $this->system->log("insert", "order", $order_id);

            $this->service_model->payer_data_fields($data,$order_id);
            $this->service_model->recipient_data_fields($data["reference_id"],$order_id,$data['recipient_id_list']);

            $this->billing_model->insert_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'insert');
            //end

            if ($data['type_of_client'] == 1) {
                //insert action on invoice
                $staff_info = staff_info();
                $this->db->where_in('department_id', '6');
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');


                $action_data['created_office'] = $data['office'];
                $action_data['priority'] = '3';
                $action_data['department'] = '6';
                $action_data['office'] = '17';
                $action_data['is_all'] = '1';
                $action_data['staff'] = $department_staff;
                $action_data['client_id'] = '';
                $action_data['subject'] = 'New Client has been created';
                $action_data['message'] = $staff_info['full_name'] . ' has added a new client on order #' . $order_id;
                $action_data['action_notes'] = array();
                $action_data['due_date'] = '';

                //print_r($action_data); exit;
                $this->load->model('action_model');
                $this->action_model->insert_client_action($action_data);
                //insert action on invoice
            }
        } else {   // Update section
            if ($data['type_of_client'] == 1) {
                if (!$this->company_model->save_company($data)) {
                    return false;
                }
                if (!$this->internal->saveInternalData($data)) {    // Save internal data
                    return false;
                }
            }
            //    Save order
            $data['order_id'] = $order_id = $this->service_model->save_order($data);
            if (isset($data['service_notes'])) {
                foreach ($data['service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->insert_note(1, $note_data, 'reference_id', $reference_id, 'service');
                    }
                }
            }
            if (isset($data['edit_service_notes'])) {
                foreach ($data['edit_service_notes'] as $services_id => $note_data) {
                    $reference_id = $this->notes->get_main_service_id($data['editval'], $services_id);
                    if (!empty($reference_id)) {
                        $reference_id = $reference_id['id'];
                        $this->notes->update_note(1, $note_data, $reference_id, 'service');
                    }
                }
            }
            $this->company->update_title_status($data["reference_id"]);
            $this->system->log("insert", "order", $order_id);


            $this->service_model->update_payer_data_fields($data,$order_id);
            $this->service_model->recipient_data_fields($data["reference_id"],$order_id,$data['recipient_id_list']);

            $this->billing_model->update_invoice_data($data);
            $this->system->save_general_notification('order', $order_id, 'edit');
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }

    public function get_company_id_client_id($client_id) {
        return $this->db->get_where('company',array('id'=>$client_id))->row_array()['company_id'];
    }

}
