<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contacts
 *
 * @author rafael
 */
class Contacts extends CI_Model {

    public $id;

    public function check_if_email_exists($data) {
        $data = (object) $data;
        $check_if_email_exists_query = "select * from contact_info where email1='{$data->email1}' and status='1'";
        $check_result = $this->db->query($check_if_email_exists_query);
        $check_count = $check_result->num_rows(); //exit;
        return $check_count;
    }

    public function saveContact($data) {

        $data = (object) $data; // convert the post array into an object

        $ref = $data->reference;
        $ref_id = $data->reference_id;
        $type = $data->type;
        $check_if_contact_type_exists_query = "select * from contact_info where reference='$ref' and reference_id='$ref_id' and type='$type' and status='1'";
        $check_result = $this->db->query($check_if_contact_type_exists_query);
        $check_count = $check_result->num_rows(); //exit;
        //if($check_count==0){

        if (!$data->phone1_country)
            $data->phone1_country = 0;
        // if (!$data->phone2_country)
        //     $data->phone2_country = 0;
        if (!$data->country)
            $data->country = 0;

        if (!$data->id) {

            if ($check_count == 0) {
                $sql = "insert into contact_info
                    (reference, reference_id, type, first_name, middle_name,last_name,
                    phone1_country, phone1, phone2_country, phone2, email1, email2, skype, whatsapp, website, 
                    address1, address2, city, state, zip, country, status)
                    values
                    (
                    '{$data->reference}',
                    '{$data->reference_id}',
                    {$data->type},
                    '{$data->contact_first_name}',
                    '',
                    '{$data->contact_last_name}',    
                    {$data->phone1_country}, '{$data->phone1}',
                    '', '',
                    '{$data->email1}',
                    '{null}',
                    '',
                    '',
                    '',
                    '{$data->address1}', '',
                    '{$data->city}',
                    '{$data->state}',
                    '{$data->zip}',
                    {$data->country},
                    1
                    )";

                $action = "insert";
                $this->db->query($sql);
                $this->id = $this->db->insert_id();
                $this->load->model('System');
                $this->System->log($action, 'contact_info', $this->id);

                return $this->id;
            } else {
                return false;
            }
        } else {
            if ($check_count == 0) {
                $sql = "update contact_info set
                    type={$data->type},
                    first_name='{$data->contact_first_name}',
                    last_name='{$data->contact_last_name}',    
                    phone1_country={$data->phone1_country}, 
                    phone1='{$data->phone1}',
                    email1='{$data->email1}',
                    address1='{$data->address1}',
                    city='{$data->city}',
                    state='{$data->state}',
                    zip='{$data->zip}',
                    country={$data->country}
                    where id = {$data->id}";

                $action = "update";
                $this->db->query($sql);
                $this->id = $data->id;
                $this->load->model('System');
                $this->System->log($action, 'contact_info', $this->id);

                return $this->id;
            } else {
                $check_data = $check_result->result_array();
                $old_id = $check_data[0]['id'];
                if ($old_id == $data->id) {
                    $sql = "update contact_info set
                    type={$data->type},
                    first_name='{$data->contact_first_name}',
                    last_name='{$data->contact_last_name}',    
                    phone1_country={$data->phone1_country}, 
                    phone1='{$data->phone1}',
                    email1='{$data->email1}',
                    address1='{$data->address1}',
                    city='{$data->city}',
                    state='{$data->state}',
                    zip='{$data->zip}',
                    country={$data->country}
                    where id = {$data->id}";

                    $action = "update";
                    $this->db->query($sql);
                    $this->id = $data->id;
                    $this->load->model('System');
                    $this->System->log($action, 'contact_info', $this->id);

                    return $this->id;
                } else {
                    return false;
                }
            }
        }
    }

    public function saveContactbook($data) {

        $data = (object) $data; // convert the post array into an object

        $ref = $data->reference;
        $ref_id = $data->reference_id;
        $type = $data->type;
        $check_if_contact_type_exists_query = "select * from contact_info where reference='$ref' and reference_id='$ref_id' and type='$type' and status='1'";
        $check_result = $this->db->query($check_if_contact_type_exists_query);
        $check_count = $check_result->num_rows(); //exit;
        //if($check_count==0){

        if (!$data->phone1_country)
            $data->phone1_country = 0;
        // if (!$data->phone2_country)
        //     $data->phone2_country = 0;
        if (!$data->country)
            $data->country = 0;

        if (!$data->id) {

            if ($check_count == 0) {
                $sql = "insert into contact_info
                    (reference, reference_id, type, first_name, middle_name,last_name,
                    phone1_country, phone1, phone2_country, phone2, email1, email2, skype, whatsapp, website, 
                    address1, address2, city, state, zip, country, status)
                    values
                    (
                    '{$data->reference}',
                    '{$data->reference_id}',
                    {$data->type},
                    '{$data->contact_first_name}',
                    '',
                    '{$data->contact_last_name}',    
                    {$data->phone1_country}, '{$data->phone1}',
                    '', '',
                    '{$data->email1}',
                    '{null}',
                    '',
                    '',
                    '',
                    '{$data->address1}', '',
                    '{$data->city}',
                    '{$data->state}',
                    '{$data->zip}',
                    {$data->country},
                    1
                    )";

                $action = "insert";
                $this->db->query($sql);
                $this->id = $this->db->insert_id();
                $this->load->model('System');
                $this->System->log($action, 'contact_info', $this->id);

                return $this->id;
            } else {
                return false;
            }
        } else {
            if ($check_count == 0) {
                $sql = "update contact_info set
                    type={$data->type},
                    first_name='{$data->contact_first_name}',
                    last_name='{$data->contact_last_name}',    
                    phone1_country={$data->phone1_country}, 
                    phone1='{$data->phone1}',
                    email1='{$data->email1}',
                    address1='{$data->address1}',
                    city='{$data->city}',
                    state='{$data->state}',
                    zip='{$data->zip}',
                    country={$data->country}
                    where id = {$data->id}";

                $action = "update";
                $this->db->query($sql);
                $this->id = $data->id;
                $this->load->model('System');
                $this->System->log($action, 'contact_info', $this->id);

                return $this->id;
            } else {
                $check_data = $check_result->result_array();
                $old_id = $check_data[0]['id'];
                if ($old_id == $data->id) {
                    $sql = "update contact_info set
                    type={$data->type},
                    first_name='{$data->contact_first_name}',
                    last_name='{$data->contact_last_name}',    
                    phone1_country={$data->phone1_country}, 
                    phone1='{$data->phone1}',
                    email1='{$data->email1}',
                    address1='{$data->address1}',
                    city='{$data->city}',
                    state='{$data->state}',
                    zip='{$data->zip}',
                    country={$data->country}
                    where id = {$data->id}";

                    $action = "update";
                    $this->db->query($sql);
                    $this->id = $data->id;
                    $this->load->model('System');
                    $this->System->log($action, 'contact_info', $this->id);

                    return $this->id;
                } else {
                    return false;
                }
            }
        }
    }

    public function saveCopiedContact($resdata, $reference_id) {
        // print_r($resdata); exit;
        foreach ($resdata as $data) {
            $type_id = $data['type_id'];
            $first_name = $data['first_name'];
            $middle_name = $data['middle_name'];
            $last_name = $data['last_name'];
            $phone1_country = $data['phone1_country'];
            $phone1 = $data['phone1'];
            $phone2_country = $data['phone2_country'];
            $phone2 = $data['phone2'];
            $email1 = $data['email1'];
            $email2 = $data['email2'];
            $skype = $data['skype'];
            $whatsapp = $data['whatsapp'];
            $website = $data['website'];
            $address1 = $data['address1'];
            $address2 = $data['address2'];
            $city = $data['city'];
            $state = $data['state'];
            $zip = $data['zip'];
            $country = $data['country'];
            $sql = "INSERT INTO `contact_info` (`id`, `reference`, `reference_id`, `type`, `first_name`, `phone1_country`, `phone1`, `phone2_country`, `phone2`, `email1`, `email2`, `skype`, `whatsapp`, `website`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `status`, `middle_name`, `last_name`) VALUES (NULL, 'individual', '" . $reference_id . "', '" . $type_id . "', '" . $first_name . "', '" . $phone1_country . "', '" . $phone1 . "', '" . $phone2_country . "', '" . $phone2 . "', '" . $email1 . "', '" . $email2 . "', '" . $skype . "', '" . $whatsapp . "', '" . $website . "', '" . $address1 . "', '" . $address2 . "', '" . $city . "', '" . $state . "', '" . $zip . "', '" . $country . "', '1', '" . $middle_name . "', '" . $last_name . "')";
            //echo $sql; exit;
            $this->db->query($sql);
        }
        //return $this->db->insert_id();
    }

    public function saveCopiedContact_add_owner($data) {
        $type_id = $data['type_id'];
        $first_name = $data['first_name'];
        $middle_name = $data['middle_name'];
        $last_name = $data['last_name'];
        $phone1_country = $data['phone1_country'];
        $phone1 = $data['phone1'];
        $phone2_country = $data['phone2_country'];
        $phone2 = $data['phone2'];
        $email1 = $data['email1'];
        $email2 = $data['email2'];
        $skype = $data['skype'];
        $whatsapp = $data['whatsapp'];
        $website = $data['website'];
        $address1 = $data['address1'];
        $address2 = $data['address2'];
        $city = $data['city'];
        $state = $data['state'];
        $zip = $data['zip'];
        $country = $data['country'];
        $sql = "INSERT INTO `contact_info` (`id`, `reference`, `reference_id`, `type`, `first_name`, `phone1_country`, `phone1`, `phone2_country`, `phone2`, `email1`, `email2`, `skype`, `whatsapp`, `website`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `status`, `user_id`, `middle_name`, `last_name`) VALUES (NULL, 'individual', '', '" . $type_id . "', '" . $first_name . "', '" . $phone1_country . "', '" . $phone1 . "', '" . $phone2_country . "', '" . $phone2 . "', '" . $email1 . "', '" . $email2 . "', '" . $skype . "', '" . $whatsapp . "', '" . $website . "', '" . $address1 . "', '" . $address2 . "', '" . $city . "', '" . $state . "', '" . $zip . "', '" . $country . "', '1', '" . sess('user_id') . "', '" . $middle_name . "', '" . $last_name . "')";
        //echo $sql; exit;
        $this->db->query($sql);
    }

    public function saveExistingContact($resdata, $reference_id) {
        // print_r($resdata); exit;
        foreach ($resdata as $data) {
            $type_id = $data['type_id'];
            $first_name = $data['first_name'];
            $middle_name = $data['middle_name'];
            $last_name = $data['last_name'];
            $phone1_country = $data['phone1_country'];
            $phone1 = $data['phone1'];
            $phone2_country = $data['phone2_country'];
            $phone2 = $data['phone2'];
            $email1 = $data['email1'];
            $email2 = $data['email2'];
            $skype = $data['skype'];
            $whatsapp = $data['whatsapp'];
            $website = $data['website'];
            $address1 = $data['address1'];
            $address2 = $data['address2'];
            $city = $data['city'];
            $state = $data['state'];
            $zip = $data['zip'];
            $country = $data['country'];
            $reference = $data['reference'];
            $sql = "INSERT INTO `contact_info` (`id`, `reference`, `reference_id`, `type`, `first_name`, `phone1_country`, `phone1`, `phone2_country`, `phone2`, `email1`, `email2`, `skype`, `whatsapp`, `website`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `status`, `middle_name`, `last_name`) VALUES (NULL, '" . $reference . "', '" . $reference_id . "', '" . $type_id . "', '" . $first_name . "', '" . $phone1_country . "', '" . $phone1 . "', '" . $phone2_country . "', '" . $phone2 . "', '" . $email1 . "', '" . $email2 . "', '" . $skype . "', '" . $whatsapp . "', '" . $website . "', '" . $address1 . "', '" . $address2 . "', '" . $city . "', '" . $state . "', '" . $zip . "', '" . $country . "', '1', '" . $middle_name . "', '" . $last_name . "')";
            //echo $sql; exit;
            $this->db->query($sql);
        }
        //return $this->db->insert_id();
    }

    public function deleteContact($id) {
        $sql = "update contact_info set status = 0 where id = $id";
        $conn = $this->db;
        if ($conn->query($sql)) {
            $this->load->model('System');
            $this->System->log('delete', 'contact_info', $id);
            return true;
        } else {
            return false;
        }
    }

    public function deleteContactList($reference_id) {
        $sql = "update contact_info set status=2 where reference ='company' and reference_id = '" . $reference_id . "'";
        $conn = $this->db;
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function loadContactList($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id";

        $data = $this->db->query($sql)->result();
        if ($data) {
            foreach ($data as $contact) {
                echo "<div class=\"row\">
                            <label class=\"col-lg-2 control-label\">{$contact->type}</label>
                            <div class=\"col-lg-10\" style=\"padding-top:8px\">
                                <p>
                                    <b>Contact Name: {$contact->first_name}" . " {$contact->middle_name}" . " {$contact->last_name} </b><br>
                                    Phones 1: {$contact->phone1} ({$contact->phone1_country_name}) <br>
                                    Email: {$contact->email1} <br>
                                    {$contact->address1}, {$contact->city}, {$contact->state}, ZIP: {$contact->zip}, {$contact->country_name}
                                </p>
                                <p>
                                    <i class=\"fa fa-edit contactedit\" style=\"cursor:pointer\" onclick=\"editContact({$contact->id})\" title=\"Edit this contact info\"></i>
                                    &nbsp;&nbsp;<i class=\"fa fa-trash contactdelete\" style=\"cursor:pointer\" onclick=\"deleteContact({$contact->id})\" title=\"Remove this contact info\"></i>
                                </p>
                            </div>
                        </div>";
            }
        }

        $quant_contact = $this->getQuantContactByReference($reference, $reference_id);
        if ($quant_contact == 0) {
            echo '<input type="hidden" name="contact_info" id="contact_info" required title="Contact Info">';
        } else {
            echo '<input type="hidden" name="contact_info" id="contact_info" title="Contact Info">';
        }
    }

    public function loadContactListpdf($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, st.state_name, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join states st on st.id = ci.state
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id";

        $data = $this->db->query($sql)->result();
        return $data;
    }

    public function loadContactListbookkeeping($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id";

        $data = $this->db->query($sql)->result();
        if ($data) {
            foreach ($data as $contact) {
                echo "<div class=\"row\">
                            <label class=\"col-lg-2 control-label\">{$contact->type}</label>
                            <div class=\"col-lg-10\" style=\"padding-top:8px\">
                                <p>
                                    <b>Contact Name: {$contact->first_name}" . " {$contact->middle_name}" . " {$contact->last_name} </b><br>
                                    Phones 1: {$contact->phone1} ({$contact->phone1_country_name}) <br> 
                                    Email: {$contact->email1} <br>
                                    {$contact->address1}, {$contact->city}, {$contact->state}, ZIP: {$contact->zip}, {$contact->country_name}
                                </p>
                                <p>
                                    <i class=\"fa fa-edit contactedit\" style=\"cursor:pointer\" onclick=\"editContactbookkeeping({$contact->id})\" title=\"Edit this contact info\"></i>
                                    &nbsp;&nbsp;<i class=\"fa fa-trash contactdelete\" style=\"cursor:pointer\" onclick=\"deleteContactbookkeeping({$contact->id})\" title=\"Remove this contact info\"></i>
                                </p>
                            </div>
                        </div>";
            }
        }

        $quant_contact = $this->getQuantContactByReference($reference, $reference_id);
        if ($quant_contact == 0) {
            echo '<input type="hidden" name="contact_info" id="contact_info" required title="Contact Info">';
        } else {
            echo '<input type="hidden" name="contact_info" id="contact_info" title="Contact Info">';
        }
    }

    public function loadContactListbookkeepingpdf($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id";

        $data = $this->db->query($sql)->result();
        return $data;
    }

    public function get_existing_contact_list($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.reference, ci.first_name, ci.middle_name, ci.last_name,ci.phone1_country,ci.phone2_country,ci.type as type_id,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id";

        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function copy_contact_list_ajax($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.reference, ci.first_name, ci.middle_name, ci.last_name,ci.phone1_country,ci.phone2_country,ci.type as type_id,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id and ci.type='1'";

        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function copy_contact_list_add_owner($contact_id) {
        $sql = "select ci.id, ct.type, ci.reference, ci.first_name, ci.middle_name, ci.last_name,ci.phone1_country,ci.phone2_country,ci.type as type_id,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.id=" . $contact_id . " and ci.type='1'";

        $data = $this->db->query($sql)->row_array();
        return $data;
    }

    public function copy_main_contact_payroll($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.reference, ci.first_name, ci.middle_name, ci.last_name,ci.phone1_country,ci.phone2_country,ci.type as type_id,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id and ci.type='1'";

        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getContactJson($id) {
        $contact = $this->getContactById($id);
        if ($contact) {
            return json_encode($contact);
        }
    }

    public function getContactById($id) {
        $sql = "select ci.* from contact_info ci where ci.id=$id";
        $conn = $this->db;
        $data = $conn->query($sql)->result()[0];
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function getcopiedcontact($ref_id) {
        $sql = "select ci.id, ct.type, ci.reference, ci.first_name, ci.middle_name, ci.last_name,ci.phone1_country,ci.phone2_country,ci.type as type_id,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='individual' and ci.reference_id=$ref_id and ci.type='1'";
        $conn = $this->db;
        $data = $conn->query($sql)->result_array();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function getQuantContactByReference($reference, $reference_id) {
        $sql = "select count(*) as total from contact_info where reference='$reference' and reference_id=$reference_id and status=1";
        $conn = $this->db;
        $data = $conn->query($sql)->result()[0];
        if ($data) {
            return $data->total;
        } else {
            return 0;
        }
    }

    public function check_if_contact_exists($reference_id) {
        return $this->db->get_where('contact_info', ['reference' => 'individual', 'reference_id' => $reference_id, 'status' => 1, 'type' => '1'])->num_rows();
    }

    public function check_if_existing_contact_exists($reference, $reference_id) {
        return $this->db->get_where('contact_info', ['reference' => $reference, 'reference_id' => $reference_id, 'status' => 1])->num_rows();
    }

    public function check_main_contact_exists($company_id) {
        return $this->db->get_where('contact_info', ['reference_id' => $company_id, 'reference' => 'company', 'type' => '1'])->num_rows();
    }

    public function loadOwnerContactList($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id group by ci.reference_id";

        $data = $this->db->query($sql)->result();
        return $data;
    }

    public function copy_contact_for_1099_write_up($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.reference, ci.first_name, ci.middle_name, ci.last_name,ci.phone1_country,ci.phone2_country,ci.type as type_id,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id";

        $data = $this->db->query($sql)->result_array();
        return $data;
    }

}

?>
