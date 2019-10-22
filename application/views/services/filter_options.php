<?php
$return = '';
        if($val==1){ //category
            $options_val = get_filter_dropdown_options($val,$ofc_val);
             if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[category][]'>";
                $return .= "<option value=''>All Criteria</option>";
                $new_sort=array();
                foreach ($options_val as $key => $ov):
                    $new_sort[$key]= $ov['name'];
                endforeach;
                array_multisort($new_sort, SORT_ASC, $options_val);
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['id'] . "'>" . $ov['name'] . "</option>";
                endforeach;
                $return .= "</select>";
            }
        }elseif($val==2){ //service name
            $options_val = get_filter_dropdown_options($val,$ofc_val);
            if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[servicename][]'>";
                $return .= "<option value=''>All Criteria</option>";
                $new_sort=array();
                foreach ($options_val as $key => $ov):
                    $new_sort[$key]= $ov['description'];
                endforeach;
                array_multisort($new_sort, SORT_ASC, $options_val);
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['id'] . "'>" . $ov['description'] . "</option>";
                endforeach;
                $return .= "</select>";
            }
        }elseif($val==3){ //office
            $options_val = get_filter_dropdown_options($val,$ofc_val);
            if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[office][]'>";
                $return .= "<option value=''>All Criteria</option>";
                $new_sort=array();
                foreach ($options_val as $key => $ov):
                    $new_sort[$key]= $ov['name'];
                endforeach;
                array_multisort($new_sort, SORT_ASC, $options_val);
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['id'] . "'>" . $ov['name'] . "</option>";
                endforeach;
                $return .= "</select>";
            }
        }elseif($val==14){ //office
            $options_val = get_filter_dropdown_options($val,$ofc_val);
            
            if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[office][]'>";
                $return .= "<option value=''>All Criteria</option>";
                $new_sort=array();
                foreach ($options_val as $key => $ov):
                    $new_sort[$key]= $ov['name'];
                endforeach;
                array_multisort($new_sort, SORT_ASC, $options_val);
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['id'] . "'>" . $ov['name'] . "</option>";
                endforeach;
                $return .= "</select>";
            }
        }
        
        
        elseif($val==4){ //tracking
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[tracking][]'>";
                $return .= "<option value=''>All Criteria</option>";
                $return .= '<option value="2">Not Started</option>';
                $return .= '<option value="1">Started</option>';
                $return .= '<option value="0">Completed</option>';
                $return .= '<option value="3">Late</option>';
                $return .= '<option value="4">Not Completed</option>';
                $return .= '<option value="7">Cancelled</option>';
                $return .= "</select>";
        }elseif($val==5){ //staff
            $options_val = get_filter_dropdown_options($val,$ofc_val);
                if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[staff][]'>";
                $return .= "<option value=''>All Criteria</option>";
                $new_sort=array();
                foreach ($options_val as $key => $ov):
                    $new_sort[$key]= $ov['first_name'];
                endforeach;
                array_multisort($new_sort, SORT_ASC, $options_val);
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['id'] . "'>" . $ov['first_name'] .' '.$ov['last_name']. "</option>";
                endforeach;
                $return .= "</select>";
            }
        }elseif($val==6){ //start date
             $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Start Date" name="criteria_dropdown[startdate][]" value="">';   
        }
        elseif($val==7){ //complete date
              $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">'; 
        }
        elseif($val==11){ //start date
             $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Start Date" name="criteria_dropdown[startdate][]" value="">';   
        }
        elseif($val==12){ //complete date
              $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">'; 
        }
        
        elseif($val==13){ //complete date
              $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">'; 
        }
        
       
        
        elseif($val==8) { //order
            $options_val = get_filter_dropdown_options($val,$ofc_val);
            if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[orderno][]'>";
                $return .= "<option value=''>All Criteria</option>";
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['order_serial_id'] . "'>" . $ov['order_serial_id'] . "</option>";
                endforeach;
                $return .= "</select>";
            }
        }elseif($val==9) { //invoice
            $options_val = get_filter_dropdown_options($val,$ofc_val);
            if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[invoiceno][]'>";
                $return .= "<option value=''>All Criteria</option>";
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['id'] . "'>" . $ov['id'] . "</option>";
                endforeach;
                $return .= "</select>";
            }
        }elseif($val==10) { //clientname
            $options_val = get_filter_dropdown_options($val,$ofc_val);
            if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[clientname][]'>";
                $return .= "<option value=''>All Criteria</option>";
                $new_sort=array();
                foreach ($options_val as $key => $ov):
                    $new_sort[$key]= $ov['name'];
                endforeach;
                array_multisort($new_sort, SORT_ASC, $options_val);
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['id'] . "'>" . $ov['name'] . "</option>";
                endforeach;
                $return .= "</select>";
            }
        }
        echo $return;

?>
<script type="text/javascript">
 $(function () {
    $(".datepicker_mdy").datepicker({format: 'mm/dd/yyyy', autoHide: true});
});
</script>