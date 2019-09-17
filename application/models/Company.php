<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Company
 *
 * @author rafael
 */
class Company extends CI_Model {

    public $id;
    public $title_id;

    public function createReferenceId() {

        if ($this->db->insert('company', array('status' => 2))) {
            $this->id = $this->db->insert_id();
            $this->load->model('System');
            $this->db->query("insert into temp (reference, reference_id, date) values ('company', {$this->id}, '{$this->System->getDateTime()}')");
        } else {
            $this->id = 0;
        }
        return $this->id;
    }

    public function saveCompany($data) {
        $data = (object) $data; // convert the post array into an object
        $this->load->model('System');
        if (isset($data->name_of_business1)) {
            $data->name = $data->name_of_business1;
        }
        if (isset($data->name)) {
            $data->name = $data->name;
        }
        if (isset($data->state_other)) {
            $data->state_others = $data->state_other;
        }
        if ($data->reference_id) {
            $data->id = $data->reference_id;
        }
        if (!isset($data->incorporated_date)) {
            $data->incorporated_date = date("d/m/Y");
        }
        if (!isset($data->state)) {
            $data->state = 0;
        }
        if (!isset($data->fein)) {
            $data->fein = '';
        }
        if (isset($data->dba) && $data->dba != "") {
            $dba = $data->dba;
        } else {
            $dba = "";
        }
        $desc = urlencode($data->business_description);
        $this->db->where('id', $data->id);
        if(!isset($data->state_others)){
            $data->state_others = '';
        }

        $res = $this->db->update('company', ['name' => $data->name, 'dba' => $dba, 'type' => $data->type, 'state_opened' => $data->state, 'fye' => $data->fiscal_year_end, 'business_description' => $desc,'state_others' =>$data->state_others  ,'incorporated_date' => $this->System->invertDate($data->incorporated_date), 'fein' => $data->fein]);
        if ($res) {
            $query = $this->db->query("select * from company where id={$data->id}");
            $last_id = $query->row_array()['company_id'];
            $this->System->log("update", "company", $last_id);
            //  //insert action on invoice
            // $staff_info = staff_info();
            // $this->db->where_in('department_id', '6');
            // $department_staffs = $this->db->get('department_staff')->result_array();
            // $department_staff = array_column($department_staffs, 'staff_id');


            // $action_data['created_office'] = $data['office'];
            // $action_data['priority'] = '3';
            // $action_data['department'] = '6';
            // $action_data['office'] = $data['office'];
            // $action_data['is_all'] = '1';
            // $action_data['staff'] = $department_staff;
            // $action_data['client_id'] = '';
            // $action_data['subject'] = 'New Action Created';
            // $action_data['message'] = $staff_info['full_name'].' has added a new order';
            // $action_data['action_notes'] = array();
            // $action_data['due_date'] = '';

            // //print_r($action_data); exit;
            // $this->load->model('action_model');
            // $this->action_model->insert_client_action($action_data);
            // //insert action on invoice 
            return true;
        } else {
            return false;
        }
    }

    public function saveCompanydatapayroll($data) {
        $data = (object) $data; // convert the post array into an object
        $this->load->model('System');
        $desc = urlencode($data->business_description);
        if (!isset($data->incorporated_date)) {
            $data->incorporated_date = date("d/m/Y");
        }
        if (!isset($data->istate)) {
            $data->istate = 0;
        }

        $sql = "update company set
                name='{$data->name_of_company}',
                dba='{$data->dba}',
                fein='{$data->fein}',
                type='{$data->type}',  
                fye='{$data->fye}', 
                state_opened='{$data->istate}',  
                business_description='{$desc}',
                fax='{$data->company_fax}',
                email='{$data->company_email}',
                state_others='{$data->state_other}'
                where id='{$data->reference_id}'
                ";

        $conn = $this->db;
        if ($conn->query($sql)) {
            $last_id = $conn->insert_id();
            $this->System->log("update", "company", $last_id);
            return true;
        } else {
            return false;
        }
    }
    
    public function saveCompanyNameOptionsOnInsert($data) {
        $business_value_arr = array(
            'company_id'=> $data['reference_id'],
            'name1'=> $data['new_company']['name1'],
            'name2'=> $data['new_company']['name2'],
            'name3'=> $data['new_company']['name3']
        );
        $this->db->insert('new_company',$business_value_arr);
    }

    public function saveCompanyNameOptions($data) {
        $data = (object) $data; // convert the post array into an object

        if (isset($data->name_of_business2) && $data->name_of_business2 != '') {
            $name2 = $data->name_of_business2;
        } else {
            $name2 = '';
        }

        if (isset($data->name_of_business3) && $data->name_of_business3 != '') {
            $name3 = $data->name_of_business3;
        } else {
            $name3 = '';
        }


        $conn = $this->db;
        $exist = $conn->query("select id from new_company where company_id={$data->reference_id}");
        if ($exist->num_rows()) {
            $sql = "update new_company set 
                    name1='{$data->name_of_business1}',
                    name2='{$name2}',
                    name3='{$name3}'
                    where company_id={$data->reference_id}";
        } else {
            $sql = "insert into new_company
                    (company_id, name1, name2, name3) values 
                    ({$data->reference_id},'{$data->name_of_business1}', '{$name2}', '{$name3}')";
        }
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function removeCompanyTempFlag($id) {
        $sql = "update company set status=1 where id=$id";
        $conn = $this->db;
        if ($conn->query($sql)) {
            $conn->query("delete from temp where reference='company' and reference_id=$id");
            return true;
        } else {
            return false;
        }
    }

//    
//    public function getCompany($id) {
//        $sql = "select c.*, s.state_name from company c
//                left join states s on s.id = c.state_opened
//                where c.id = $id";
//        $conn = new Connection();
//        $data = $conn->query($sql);
//        if ($data) {
//            return $data->fetch_object();
//        } else {
//            return false;
//        }
//    }
//    
//    public function getCompanyContactInfo($id){
//        $sql = "select * from contact_info where reference='company' and reference_id = $id";
//        $conn = new Connection();
//        $data = $conn->query($sql);
//        if ($data) {
//            return $data->fetch_object();
//        } else {
//            return false;
//        }
//    }
//    
//    public function getCompanyInternalData($id){
//        $sql = "select * from internal_data where reference='company' and reference_id = $id";
//        $conn = new Connection();
//        $data = $conn->query($sql);
//        if ($data) {
//            return $data->fetch_object();
//        } else {
//            return false;
//        }
//    }
//    
    /* Title functions */
    public function getTitle($id) {
        $sql = "select t.id, t.individual_id, t.title, t.percentage, t.company_type,
                i.first_name, i.middle_name, i.last_name, i.birth_date, i.ssn_itin, i.type, 
                i.language as language_id, l.language, 
                c1.id as country_residence_id, c1.country_name as country_residence_name, 
                c2.id as country_citizenship_id, c2.country_name as country_citizenship_name,
                id.office, id.partner, id.manager, id.client_association, id.referred_by_source, id.referred_by_name
                from title t
                left join individual i on i.id = t.individual_id
                left join languages l on l.id = i.language
                left join countries c1 on c1.id = i.country_residence
                left join countries c2 on c2.id = i.country_citizenship
                left join internal_data id on id.reference='individual' and id.reference_id=i.id
                where t.id = $id";
        $conn = $this->db;
        $data = $conn->query($sql)->result()[0];
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

//    
    public function loadCompanyTitle($company_id) {
        $sql = "select t.id, t.title, t.percentage, t.company_id,
                concat(i.last_name, ', ',i.first_name, ' ',i.middle_name) as name
                from title t
                inner join individual i on i.id = t.individual_id
                where t.company_id = $company_id and t.status=1";

        $data = $this->db->query($sql)->result();
        if ($data) {
            foreach ($data as $title) {
                echo "<div class=\"row\">
                            <label class=\"col-lg-2 control-label\">{$title->title}</label>
                            <div class=\"col-lg-10\" style=\"padding-top:8px\">
                                <p>
                                    <b>Name: {$title->name} </b><br>
                                    Percentage: {$title->percentage}% 
                                </p>
                                <p>
                                    <i class=\"fa fa-edit owneredit\" style=\"cursor:pointer\" onclick=\"openOwnerFormPopup(0, {$title->company_id}, {$title->id})\" title=\"Edit this owner\"></i>
                                    &nbsp;&nbsp;<i class=\"fa fa-trash ownerdelete\" style=\"cursor:pointer\" onclick=\"deleteOwner({$title->id})\" title=\"Remove this owner\"></i>
                                </p>
                            </div>
                        </div>";
            }
        }
        $quant_title = $this->getQuantTitle($company_id);
        if ($quant_title == 0) {
            echo '<input type="hidden" name="owners" id="owners" required title="Owners">';
        } else {
            echo '<input type="hidden" name="owners" id="owners" title="Owners">';
        }

        $total_percentage = $this->owner_percentage_total($company_id);

        echo '<input type="hidden" name="owner_percentage_total" id="owner_percentage_total" value="' . $total_percentage[0]['total'] . '">';
    }

    public function loadCompanyTitlepdf($company_id) {
        $sql = "select t.id, t.individual_id, t.title, t.percentage, t.company_type,
                concat(i.last_name, ', ',i.first_name, ' ',i.middle_name) as name, i.birth_date, i.ssn_itin, i.type, 
                i.language as language_id, l.language, 
                c1.id as country_residence_id, c1.country_name as country_residence_name, 
                c2.id as country_citizenship_id, c2.country_name as country_citizenship_name,
                id.office, id.partner, id.manager, id.client_association, id.referred_by_source, id.referred_by_name
                from title t
                left join individual i on i.id = t.individual_id
                left join languages l on l.id = i.language
                left join countries c1 on c1.id = i.country_residence
                left join countries c2 on c2.id = i.country_citizenship
                left join internal_data id on id.reference='individual' and id.reference_id=i.id
                where t.company_id = $company_id and t.status=1";


//        $sql = "select t.id, t.title, t.percentage, t.company_id,
//                concat(i.last_name, ',',i.first_name, ' ',i.middle_name) as name
//                from title t
//                inner join individual i on i.id = t.individual_id
//                where t.company_id = $company_id and t.status=1";

        $data = $this->db->query($sql)->result();
        return $data;
    }

    public function get_owner_data($ownerid) {
        $sql = "select t.id, t.individual_id, t.title, t.percentage, t.company_type,
                concat(i.last_name, ', ',i.first_name, ' ',i.middle_name) as name, i.first_name, i.last_name, i.birth_date, i.ssn_itin, i.type, 
                i.language as language_id, l.language, 
                c1.id as country_residence_id, c1.country_name as country_residence_name, 
                c2.id as country_citizenship_id, c2.country_name as country_citizenship_name,
                id.office, id.partner, id.manager, id.client_association, id.referred_by_source, id.referred_by_name
                from title t
                left join individual i on i.id = t.individual_id
                left join languages l on l.id = i.language
                left join countries c1 on c1.id = i.country_residence
                left join countries c2 on c2.id = i.country_citizenship
                left join internal_data id on id.reference='individual' and id.reference_id=i.id
                where t.id = $ownerid and t.status=1";

        $data = $this->db->query($sql)->result()[0];
        return $data;
    }

    public function check_if_existing_owner_exists($company_id) {
        $sql = "select t.id, t.title, t.percentage, t.company_id,
                concat(i.last_name, ', ',i.first_name, ' ',i.middle_name) as name
                from title t
                inner join individual i on i.id = t.individual_id
                where t.company_id = $company_id and t.status=1";

        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function get_existing_owner_list($company_id) {
        $sql = "select t.*,i.*,
                concat(i.last_name, ', ',i.first_name, ' ',i.middle_name) as name
                from title t
                left join individual i on i.id = t.individual_id
                where t.company_id = $company_id and t.status=1";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function saveExistingowners($resultdata, $new_reference_id) {
        foreach ($resultdata as $data) {
            $id = $data['id'];
            $company_id = $data['company_id'];
            $company_type = $data['company_type'];
            $individual_id = $data['individual_id'];
            $title = $data['title'];
            $percentage = $data['percentage'];
            $status = $data['status'];
            $first_name = $data['first_name'];
            $middle_name = $data['middle_name'];
            $last_name = $data['last_name'];
            $birth_date = $data['birth_date'];
            $ssn_itin = $data['ssn_itin'];
            $type = $data['type'];
            $language = $data['language'];
            $country_residence = $data['country_residence'];
            $country_citizenship = $data['country_citizenship'];
            $name = $data['name'];

//            $sql = "INSERT INTO `individual` (`id`, `first_name`, `middle_name`, `last_name`, `birth_date`, `ssn_itin`, `type`, `language`, `country_residence`, `country_citizenship`, `status`) VALUES ('', '" . $first_name . "', '" . $middle_name . "', '" . $last_name . "', '" . $birth_date . "', '" . $ssn_itin . "', '" . $type . "', '" . $language . "', '" . $country_residence . "', '" . $country_citizenship . "', '1')";
//            echo $sql; exit;
//            $this->db->query($sql);
//            $individual_id = $this->db->insert_id();
            $this->db->where('company_id', $new_reference_id);
            $this->db->delete('title');
            $query = "INSERT INTO `title` (`id`, `company_id`, `individual_id`, `company_type`, `title`, `percentage`, `status`, `existing_reference_id`) VALUES ('', '" . $new_reference_id . "', '" . $individual_id . "', '" . $type . "', '" . $title . "', '" . $percentage . "', '2', '$company_id')";
            $this->db->query($query);
        }
    }

    public function update_title_status($new_reference_id) {
        $this->db->where(['company_id' => $new_reference_id]);
        $this->db->update('title', ['status' => 1]);
    }

    public function getownercount($company_id) {
        $sql = "select t.id, t.title, t.percentage, t.company_id,
                concat(i.last_name,', ',i.first_name, ' ',i.middle_name) as name
                from title t
                inner join individual i on i.id = t.individual_id
                where t.company_id = $company_id and t.status=1";

        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function createTitleReferenceId($company_id) {
        $conn = $this->db;

        $individual = $conn->query("insert into individual (status) values (2)");
        if ($individual) {
            $individual_id = $conn->insert_id();

            $title = $conn->query("insert into title (company_id, individual_id, status, existing_reference_id) values ($company_id, $individual_id, 2, '$company_id')");
            $title_id = $conn->insert_id();

            $this->load->model('System');
            $conn->query("insert into temp (reference, reference_id, date) values ('title', {$title_id}, '{$this->System->getDateTime()}')");
        } else {
            $title_id = 0;
        }
        return $title_id;
    }

//    
    public function getQuantTitle($company_id) {
        $sql = "select count(*) as total from title where company_id=$company_id and status=1";
        $conn = $this->db;
        $data = $conn->query($sql)->result()[0];
        if ($data) {
            return $data->total;
        } else {
            return 0;
        }
    }

//    
    public function deleteTitle($title_id) {
        $ind_id = $this->db->query("select individual_id from title where id=" . $title_id . "")->row_array()['individual_id'];
        $sql1 = "update individual set status=0 where id=" . $ind_id . "";
        $sql2 = "update title set status=0 where individual_id=" . $ind_id . "";
        $conn = $this->db;
        $this->load->model('System');
        if ($conn->query($sql1) && $conn->query($sql2)) {
            $this->System->log("delete", "title", $title_id);
            return true;
        } else {
            return false;
        }
    }

    public function deleteOwnerList($reference, $reference_id) {
        $sql = "update title set status=2 where company_id = '" . $reference_id . "'";
        $conn = $this->db;
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_owner_list($reference_id) {
        $sql = "update title set status=2 where company_id = '" . $reference_id . "'";
        $conn = $this->db;
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function owner_percentage_total($company_id) {
        $sql = "select SUM(percentage) as total from title where company_id=$company_id";
        $result = $this->db->query($sql);
        $result_array = $result->result_array();
        return $result_array;
    }

    public function get_company_types() {
        $sql = "select * from company_type";
        $result = $this->db->query($sql);
        $result_array = $result->result_array();
        return $result_array;
    }

    public function add_company_types($type) {
        $sql = "INSERT INTO `company_type` (`id`, `type`, `status`) VALUES ('', '$type', '1');";
        $result = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function delete_company_types($id) {
        $sql = "delete from `company_type` where id='$id'";
        $result = $this->db->query($sql);
    }

    public function update_company_types($type, $rowid) {
        $this->db->where('id', $rowid);
        $this->db->update('company_type', array('type' => $type));
        return $rowid;
    }

    public function get_company_data($reference_id) {
        $sql = "select * from company where id=$reference_id and status=1";
        $data = $this->db->query($sql);
        $result = $data->result_array();
        return $result;
    }

}
