<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormFields
 *
 * @author rafael
 */
class FormFields extends CI_Model {

    public $field_id;
    public $field_title;
    public $field_name;
    public $field_class;
    public $field_placeholder;
    public $field_width;
    public $selected_id;
    public $required;
    public $multiple;
    public $array_states;
    public $save_form_cache;

    function __construct() {
        $this->field_class = "chosen-select";
        $this->field_placeholder = "Select one option";
        $this->required = false;
        $this->multiple = false;
        $this->selected_id = 0;
        $this->field_width = 0;
        $this->save_form_cache = 0;
    }

    public function getSelectStates() {
        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $this->field_name . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\')"' : '' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';
        echo '<option value=""></option>';
        $conn = $this->db;
        $sql = "select id, state_name, state_code from states " . ( $this->array_states ? "where state_code in ($this->array_states)" : "");
        $data = $conn->query($sql)->result();
        foreach ($data as $state) {
            echo "<option value=\"{$state->id}\" " . ( ( $this->selected_id && ($state->id == $this->selected_id )) ? "selected" : "" ) . ">{$state->state_name}</option>";
        }
        echo '</select>';
    }

    public function getArrayStates() {
        $sql = "SELECT GROUP_CONCAT('\"',state_name,'\"') as string  FROM states where id!=0";
        $data = $this->db->query($sql)->result()[0]->string;

        if ($data) {
            echo $data;
        }
    }

    public function getSelectCompanyType($company_id='') {

        $ci = &get_instance();
        $ci->load->model('Company');
        $result = 0;

        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select '. ( ($result==0) ? "" : "disabled" ) .' data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $this->field_name . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\')"' : '' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';
        echo '<option value=""></option>';
        $sql = "select id, type from company_type where status = 1";
        $data = $this->db->query($sql)->result();
        foreach ($data as $type) {
            echo "<option value=\"{$type->id}\" " . ( ( $this->selected_id && ($type->id == $this->selected_id )) ? "selected" : "" ) . ">{$type->type}</option>";
        }
        echo '</select>';
    }

    public function getSelectMonths($val='') {
        if($val==''){
             $this->selected_id = '12';
        }else{
            $this->selected_id = $val; 
        }
       
        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $this->field_name . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\')"' : '' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';
        echo '<option value=""></option>';
        for ($i = 1; $i <= 12; $i++) {
            echo '<option value="' . $i . '" ' . ( ( $this->selected_id && ($i == $this->selected_id )) ? "selected" : '' ) . '>' . date("F", strtotime("2000-$i-01")) . '</option>';
        }
        echo '</select>';
    }

    public function getSelectLanguages() {
        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $this->field_name . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\')"' : '' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';
        echo '<option value=""></option>';

        $sql = "select id, language from languages where status=1 order by language";
        $data = $this->db->query($sql)->result();
        foreach ($data as $language) {
            echo "<option value='{$language->id}' " . ( ( $this->selected_id && ($language->id == $this->selected_id )) ? "selected" : "" ) . ">{$language->language}</option>";
        }
        echo '</select>';
    }

//    
    public function getSelectCountries() {
        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $this->field_name . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\')"' : '' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';
        echo '<option value=""></option>';
        $sql = "select id, country_code, country_name from countries where id = 230 "
                . "UNION "
                . " select id, country_code, country_name from countries where id!=0 and id!= 230";
        $data = $this->db->query($sql)->result();
        foreach ($data as $country) {
            echo "<option value='{$country->id}' " . ( ( $this->selected_id && ($country->id == $this->selected_id )) ? "selected" : "" ) . ">{$country->country_name}</option>";
        }
        echo '</select>';
    }

//    
//    
//    
//    
    public function getSelectAddressType() {
        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $this->field_name . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\')"' : '' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';

        $sql = "select id, type from address_type where status = 1";
        $data = $this->db->query($sql)->result();
        foreach ($data as $type) {
            echo "<option value=\"{$type->id}\" " . ( ( $this->selected_id && ($type->id == $this->selected_id )) ? "selected" : "" ) . ">{$type->type}</option>";
        }
        echo '</select>';
    }

//    
//    
    public function getSelectContactInfoType() {
        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $this->field_name . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\')"' : '' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';

        $sql = "select id, type from contact_info_type where status = 1";
        $data = $this->db->query($sql)->result();
        foreach ($data as $type) {
            echo "<option value=\"{$type->id}\" " . ( ( $this->selected_id && ($type->id == $this->selected_id )) ? "selected" : "" ) . ">{$type->type}</option>";
        }
        echo '</select>';
    }

//    
    public function getSelectReferredBySource() {
        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $this->field_name . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\')"' : '' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';
        echo '<option value=""></option>';

        $sql = "select id, source from referred_by_source where status = 1";
        $data = $this->db->query($sql)->result();
        foreach ($data as $type) {
            echo "<option value=\"{$type->id}\" " . ( ( $this->selected_id && ($type->id == $this->selected_id )) ? "selected" : "" ) . ">{$type->source}</option>";
        }
        echo '</select>';
    }

//    
    public function getSelectOffice($office_id='') {
        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $this->field_name . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\');loadPartnerManager(this.value);"' : 'onchange="loadPartnerManager(this.value)' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';
        echo '<option value=""></option>';
        if($office_id==''){
            $sql = "select id, name from office where status = 1";
        }else{
            if (strpos($office_id, ',') !== false) {
               $sql = "select id, name from office where id in ($office_id) and status = 1";  
            }else{
               $sql = "select id, name from office where id='$office_id' and status = 1";   
            }
        }
        $data = $this->db->query($sql)->result();
        foreach ($data as $office) {
            echo "<option value=\"{$office->id}\" " . ( ( $this->selected_id && ($office->id == $this->selected_id )) ? "selected" : "" ) . ">{$office->name}</option>";
        }
        echo '</select>';
    }

//    
    public function getSelectServices($service_id) {
        
        $id = $this->field_name;
        if ($this->multiple)
            $this->field_name .= "[]";
        echo '<select data-placeholder="' . $this->field_placeholder . '" title="' . $this->field_title . '" class="' . $this->field_class . '" name="' . $this->field_name . '" id="' . $id . '" ' . ( $this->field_width > 0 ? 'style="width:' . $this->field_width . '%"' : '' ) . ' ' . ( $this->save_form_cache ? 'onchange="saveCacheFormFields(\'' . $this->save_form_cache . '\')"' : '' ) . ' ' . ($this->multiple ? 'multiple' : '') . ' ' . ($this->required ? 'required' : '') . '>';
        echo '<option value=""></option>';

        $sql = "select id, description from services where id in 
                (select related_services_id from related_services where services_id = $service_id)
                and status = 1 order by description";
        $data = $this->db->query($sql)->result();
        foreach ($data as $service) {
            echo "<option value=\"{$service->id}\" " . ( ( $this->selected_id && in_array($service->id,$this->selected_id) ) ? "selected" : "" ) . ">{$service->description}</option>";
            //echo "<option value=\"{$service->id}\" " . ( ( $this->selected_id && ($service->id == $this->selected_id )) ? "selected" : "" ) . ">{$service->description}</option>";
        }
        echo '</select>';
    }

}
