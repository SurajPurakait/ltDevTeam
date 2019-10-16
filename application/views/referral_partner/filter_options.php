<?php
$return = '';
        if($val==1){ //type
            $options_val = get_filter_dropdown_options_ref_partner($val);
             if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[type][]'>";
                $return .= "<option value=''>All Criteria</option>";
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['id'] . "'>" . $ov['name'] . "</option>";
                endforeach;
                $return .= "</select>";
            }
        }elseif($val==2){ //requested by
            $options_val = get_filter_dropdown_options_ref_partner($val);
            if (isset($options_val) && count($options_val) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[requested_by][]'>";
                $return .= "<option value=''>All Criteria</option>";
                foreach ($options_val as $ov):
                    $return .= "<option value='" . $ov['id'] . "'>" . $ov['last_name'].', '.$ov['first_name'] . "</option>";
                endforeach;
                $return .= "</select>";
            }
        }elseif($val==3){ //added date
            $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Added Date" name="criteria_dropdown[added_date][]" value="">';
        }elseif ($val==4) { //partner name 
            $options_val_name = get_partnes();
            if (isset($options_val_name) && count($options_val_name) > 0) {
                $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[partner_name][]'>";
                $return .= "<option value=''>All Criteria</option>";
                foreach ($options_val_name as $ovn):
                    $return .= "<option value='".$ovn['id']."'>" . $ovn['last_name'].', '.$ovn['first_name'] . "</option>";
                endforeach;
                $return .= "</select>"; 
            }
        }
        // }elseif($val==4){ //tracking
        //         $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[tracking][]'>";
        //         $return .= "<option value=''>All Criteria</option>";
        //         $return .= '<option value="2">Not Started</option>';
        //         $return .= '<option value="1">Started</option>';
        //         $return .= '<option value="0">Completed</option>';
        //         $return .= '<option value="3">Late</option>';
        //         $return .= '<option value="4">Not Completed</option>';  
        //         $return .= "</select>";
        // }elseif($val==5){ //staff
        //     $options_val = get_filter_dropdown_options($val,$ofc_val);
        //         if (isset($options_val) && count($options_val) > 0) {
        //         $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[staff][]'>";
        //         $return .= "<option value=''>All Criteria</option>";
        //         foreach ($options_val as $ov):
        //             $return .= "<option value='" . $ov['id'] . "'>" . $ov['first_name'] .' '.$ov['last_name']. "</option>";
        //         endforeach;
        //         $return .= "</select>";
        //     }
        // }elseif($val==6){ //start date
        //      $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Start Date" name="criteria_dropdown[startdate][]" value="">';   
        // }
        // elseif($val==7){ //complete date
        //       $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">'; 
        // }
        echo $return;

?>
<script type="text/javascript">
 $(function () {
    $(".datepicker_mdy").datepicker({format: 'mm/dd/yyyy', autoHide: true});
});
</script>