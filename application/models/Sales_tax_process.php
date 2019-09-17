<?php

class Sales_tax_process extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model("notes");
    }

    function saveSalesTaxProcess($data, $files) {
        $data_array = array(
            'client_id' => $data['client_name'],
            'state_id' => $data['state'],
            'county_id' => $data['county'],
            'added_by_user' => sess('user_id'),
            'user_type' => $data['user_type'],
            'rate' => $data['rate'],
            'exempt_sales' => $data['exempt_sales'],
            'taxable_sales' => $data['taxable_sales'],
            'gross_sales' => $data['gross_sales'],
            'sales_tax_collect' => $data['sales_tax_collect'],
            'collect_allowance' => $data['collection_allowance'],
            'total_due' => $data['total_due'],
            'period_of_time' => $data['peroidval'],
            'period_of_time_val' => $data['period_time'],
            'period_of_time_yearval' => $data['period_time_year'],
            'confirmation_number' => $data['confirmation_number'],
            'status' => 0
        );

        $this->db->trans_begin();

        $this->db->insert('sales_tax_process', $data_array);

        $insert_id = $this->db->insert_id();

        if (!empty($data['sales_tax_process_notes'])) {
            $this->notes->insert_note(1, $data['sales_tax_process_notes'], 'reference_id', $insert_id, 'sales_tax_process');
        }
        if (!empty($files["name"])) {
            $filesCount = count($files['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['userFile']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['userFile']['type'] = $files['type'][$i];
                $_FILES['userFile']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['userFile']['error'] = $files['error'][$i];
                $_FILES['userFile']['size'] = $files['size'][$i];

                $uploadPath = FCPATH . 'uploads/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = "*";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['sales_tax_process_id'] = $insert_id;
                }
            }
        }

        if (!empty($uploadData)) {
            $this->db->insert_batch('sales_tax_process_files', $uploadData);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    function updateSalesTaxProcess($data, $salesid, $files) {
        $data_array = array(
            'client_id' => $data['client_name'],
            'state_id' => $data['state'],
            'county_id' => $data['county'],
            'added_by_user' => sess('user_id'),
            'user_type' => $data['user_type'],
            'rate' => $data['rate'],
            'exempt_sales' => $data['exempt_sales'],
            'taxable_sales' => $data['taxable_sales'],
            'gross_sales' => $data['gross_sales'],
            'sales_tax_collect' => $data['sales_tax_collect'],
            'collect_allowance' => $data['collection_allowance'],
            'total_due' => $data['total_due'],
            'period_of_time' => $data['peroidval'],
            'period_of_time_val' => $data['period_time'],
            'period_of_time_yearval' => $data['period_time_year'],
            'confirmation_number' => $data['confirmation_number'],
            'status' => 0
        );

        $this->db->trans_begin();

        $this->db->set($data_array)->where("id", $salesid)->update("sales_tax_process");

        if (!empty($data['sales_tax_process_notes'])) {
            $this->notes->insert_note(1, $data['sales_tax_process_notes'], 'reference_id', $salesid, 'sales_tax_process');
        }
        if (!empty($data['edit_sales_tax_process_notes'])) {
            $this->notes->update_note(1, $data['edit_sales_tax_process_notes'], $salesid, 'sales_tax_process');
        }

        if (!empty($files["name"])) {
            $filesCount = count($files['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['userFile']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['userFile']['type'] = $files['type'][$i];
                $_FILES['userFile']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['userFile']['error'] = $files['error'][$i];
                $_FILES['userFile']['size'] = $files['size'][$i];

                $uploadPath = FCPATH . 'uploads/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = "*";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['sales_tax_process_id'] = $salesid;
                }
            }
        }

        if (!empty($uploadData)) {
            $this->db->insert_batch('sales_tax_process_files', $uploadData);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }
    
    // public function get_sales_tax_process_notes($salestax_id){
    //     return $this->db->query("select * from notes where reference = 'sales_tax_process' and reference_id = '".$salestax_id."'")->result_array();
    // }
}
