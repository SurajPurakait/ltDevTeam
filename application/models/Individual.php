<?php

class Individual extends CI_Model {

    public $id;

    public function getIndividual($id) {
        $sql = "select i.id, i.first_name, i.middle_name, i.last_name, i.birth_date, i.ssn_itin, i.type, 
                i.language as language_id, l.language, 
                c1.id as country_residence_id, c1.country_name as country_residence_name, 
                c2.id as country_citizenship_id, c2.country_name as country_citizenship_name 
                from individual i
                left join languages l on l.id = i.language
                left join countries c1 on c1.id = i.country_residence
                left join countries c2 on c2.id = i.country_citizenship
                where i.id = $id";
        $conn = new Connection();
        $data = $conn->query($sql);
        if ($data) {
            return $data->fetch_object();
        } else {
            return false;
        }
    }

    public function individual_list() {
        $this->db->select("tl.id, tl.title, tl.percentage, tl.company_id, concat(idv.last_name, ', ',idv.first_name, ' ',idv.middle_name) as name, tl.existing_reference_id");
        $this->db->from('title tl');
        $this->db->join('individual idv', 'idv.id = tl.individual_id');
        $this->db->where(['tl.status' => 1]);
        $this->db->group_by('tl.individual_id');
        return $this->db->get()->result_array();
    }

    public function individual_list_new($office_id = '') {
        $staff_info = staff_info();
        $this->db->select("tl.id, tl.title, tl.percentage, tl.company_id, TRIM(CONCAT(idv.last_name, ', ',idv.first_name)) as name, idv.last_name, tl.existing_reference_id, idv.id as individual_id");
        $this->db->from('title tl');
        $this->db->join('individual idv', 'idv.id = tl.individual_id');
        if ($staff_info['type'] == 3) {
            $this->db->join("internal_data ind", "ind.reference_id = idv.id and ind.reference='individual'");
            $this->db->where_in('ind.office', explode(',', $staff_info['office']));
        } elseif ($office_id != '' && $office_id != null) {
            $this->db->join("internal_data ind", "ind.reference_id = idv.id and ind.reference='individual'");
            $this->db->where('ind.office', $office_id);
        }
        $this->db->where(['tl.status' => 1]);
        $this->db->group_by('tl.individual_id');
        // $this->db->order_by('name');
        $this->db->where('idv.first_name is NOT NULL', NULL, FALSE);
        $this->db->where('idv.first_name!=', '');
        // $this->db->where('idv.middle_name is NOT NULL', NULL, FALSE);
        $this->db->where('idv.last_name is NOT NULL', NULL, FALSE);
        $this->db->where('idv.last_name!=', '');
        $this->db->where("idv.status", '1');
        $this->db->group_by('idv.id');
        $this->db->order_by('name');
        return $this->db->get()->result_array();
    }

    public function individual_info_by_title_id($title_id) {
        $this->db->select('tl.id, tl.individual_id, tl.title, tl.company_id as existing_reference_id, tl.percentage, tl.company_type,
                idv.first_name, idv.middle_name, idv.last_name, idv.birth_date, idv.ssn_itin, idv.type, idv.language, idv.country_residence, idv.country_citizenship, CONCAT(idv.last_name, \', \',idv.first_name) as name, tl.existing_reference_id as existing_ref_id');
        $this->db->from('title tl');
        $this->db->join('individual idv', 'idv.id = tl.individual_id');
        $this->db->where(['tl.id' => $title_id]);
        return $this->db->get()->row_array();
    }

    public function getIndividualContactInfo($id) {
        $sql = "select * from contact_info where reference='individual' and reference_id = $id";
        $conn = new Connection();
        $data = $conn->query($sql);
        if ($data) {
            return $data->fetch_object();
        } else {
            return false;
        }
    }

    public function getIndividualInternalData($id) {
        $sql = "select * from internal_data where reference='individual' and reference_id = $id";
        $conn = new Connection();
        $data = $conn->query($sql);
        if ($data) {
            return $data->fetch_object();
        } else {
            return false;
        }
    }

    public function save_Owner($data) {

        $data = (object) $data; // convert the post array into an object
        $conn = $this->db;
        $this->load->model('System');
        $date = $this->System->invertDate($data->birth_date);

        $individual_insert_data = array(
            'first_name' => $data->first_name,
            'middle_name' => $data->middle_name,
            'last_name' => $data->last_name,
            'birth_date' => $date,
            'ssn_itin' => $data->ssn_itin,
            'type' => '',
            'language' => $data->language,
            'country_residence' => $data->country_residence,
            'country_citizenship' => $data->country_citizenship,
            'status' => 1,
            "added_by_user" => sess('user_id')
        );

        $this->db->insert('individual', $individual_insert_data);

        $insert_id = $this->db->insert_id();

        $this->System->log("insert", "individual", $insert_id);

        $title_insert_data = array(
            'company_id' => 0,
            'individual_id' => $insert_id,
            'company_type' => $data->type,
            'title' => $data->title,
            'percentage' => $data->percentage,
            'status' => 1,
            'existing_reference_id' => 0
        );

        $this->db->insert('title', $title_insert_data);


        $this->System->log("insert", "title", $this->db->insert_id());
        return true;
    }

    public function owner_total_percentage($data) {
        $data = (object) $data;
        $company_id = $data->company_id;
        $sql = "select SUM(percentage) as total from title where company_id='$company_id' and status=1 and individual_id<>" . $data->individual_id;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function saveOwner($data) {
        $added_by_user = sess('user_id');
        $data = (object) $data; // convert the post array into an object
        $conn = $this->db;
        $this->load->model('System');

        $sql1 = "update title set company_type='{$data->type}', title='{$data->title}', percentage={$data->percentage}, status=1 where id={$data->title_id}";
        if ($conn->query($sql1)) {
            $this->System->log("insert", "title", $data->title_id);
        } else {
            return false;
        }

        $ssn = str_replace("-", "", $data->ssn_itin);
        if (isset($data->birth_date) && $data->birth_date != '') {
            $dob = $this->System->invertDate($data->birth_date);
        } else {
            $dob = '';
        }

        $sql2 = "update individual set
                first_name='{$data->first_name}',
                middle_name='{$data->middle_name}',
                last_name='{$data->last_name}',
                birth_date='{$dob}',
                language={$data->language},
                country_residence='{$data->country_residence}',
                country_citizenship='{$data->country_citizenship}',
                ssn_itin='{$ssn}',
                status=1,
                added_by_user={$added_by_user}
                where id={$data->individual_id}";
        if ($conn->query($sql2)) {
            $this->System->log("insert", "individual", $data->individual_id);
        } else {
            return false;
        }
        return true;
    }

    function saveIndividual() {
        $data = post();
        $added_by_user = sess('user_id');
        $this->load->model('internal_model');
        $reference_id = $data['company_id'];
        $data['internal_data']['reference_id'] = $data['reference_id'];
        $data['internal_data']['reference'] = "individual";
        if (!$this->internal_model->save_internal_data($data['internal_data'])) {
            return false;
        }
        $data = (object) $data; // convert the post array into an object
        $conn = $this->db;
        $this->load->model('System');
//        title='{$data->title}', percentage={$data->percentage},
        $sql1 = "update title set company_type='{$data->type}', status=1 where id={$data->title_id}";
        if ($conn->query($sql1)) {
            $this->System->log("insert", "title", $data->title_id);
        } else {
            return false;
        }
//        print_r($_FILES);die;
        if ($_FILES['attachments']['name'] != '') {
            if ($this->uploadpdffiles($_FILES['attachments'])) {
                $attachment_filename = $this->file_uploaded;
            } else {
                $attachment_filename = '';
            }
        } else {
            $attachment_filename = '';
        }
        $sql = "update title set file_name='$attachment_filename' where id={$data->title_id}";
        $this->db->query($sql);

//            
//        $data= (object) $data;
        if (isset($data->notes)) {
            $this->notes->insert_note(1, $data->notes, 'reference_id', $data->reference_id, $data->reference);
        }
        $ssn = str_replace("-", "", $data->ssn_itin);
        if (isset($data->birth_date) && $data->birth_date != '') {
            $dob = $this->System->invertDate($data->birth_date);
        } else {
            $dob = '';
        }

        $sql2 = "update individual set
                first_name='{$data->first_name}',
                middle_name='{$data->middle_name}',
                last_name='{$data->last_name}',
                birth_date='{$dob}',
                language={$data->language},
                country_residence='{$data->country_residence}',
                country_citizenship='{$data->country_citizenship}',
                ssn_itin='{$ssn}',
                status=1,
                added_by_user={$added_by_user}
                where id={$data->individual_id}";
        if ($conn->query($sql2)) {
            $this->System->log("insert", "individual", $data->individual_id);
        } else {
            return false;
        }
        return true;
    }

    public function get_individual_info_by_title_id($title_id) {
        $this->db->select('tl.id, tl.individual_id, tl.company_id as reference_id');
        $this->db->from('title tl');
        $this->db->join('individual idv', 'idv.id = tl.individual_id');
        $this->db->where(['tl.id' => $title_id]);
        return $this->db->get()->row_array();
    }

    public function get_individual_info_by_refernce_id($reference_id) {
        $this->db->select('*');
        $this->db->from('title tl');
        $this->db->join('individual idv', 'idv.id = tl.individual_id');
        $this->db->where(['tl.company_id' => $reference_id]);
        return $this->db->get()->result_array();
    }

    public function get_individual_by_id($individual_id) {
        $this->db->select('ind.*, CONCAT(ind.last_name,", ",ind.first_name) as individual_name');
        $this->db->from('individual ind');
        $this->db->where(['ind.id' => $individual_id]);
        return $this->db->get()->row_array();
    }

    private function uploadpdffiles($file) {

        $upload_dir = FCPATH . 'uploads/';
        $temp = explode('.', $file['name']);
        $extension = strtolower(end($temp));
        $filename = trim(strtolower(reset($temp)));
        $save_as = time() . "_" . $filename . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('pdf');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['size'] > $max_size) {
                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message = "File uploaded successfully";
                    $this->file_uploaded = $save_as;
                    return true;
                }
            }
        }
    }

    public function get_business_notes($id) {
        return $this->db->query("select note from notes where reference_id='$id'")->result_array();
        ;
    }

    public function check_if_title_exists($title, $company_id) {
        $sql = "select * from title where company_id='" . $company_id . "' and title='" . $title . "' and status=1";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function check_if_duplicate_exists($data) {
        $data['first_name'] = trim($data['first_name']);
        $data['middle_name'] = trim($data['middle_name']);
        $data['last_name'] = trim($data['last_name']);
        $sql = "select * from individual where LOWER(`first_name`) = '" . strtolower($data['first_name']) . "' and LOWER(`middle_name`) = '" . strtolower($data['middle_name']) . "' and LOWER(`last_name`) = '" . strtolower($data['last_name']) . "' and status=1";
        $query = $this->db->query($sql);
        $res = $query->row_array();
        if ($res == '') {
            return array();
        } else {
            return $res;
        }
    }

}
