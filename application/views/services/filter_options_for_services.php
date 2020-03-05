<?php
$return = '';
if ($val == 1) { // Service Id (invoice id)
    $options_val = get_filter_dropdown_options_for_services($val);
    if (isset($options_val) && count($options_val) > 0) {
        $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[invoiceno][]'>";
        $return .= "<option value=''>All Criteria</option>";
        foreach ($options_val as $ov):
            $return .= "<option value='" . $ov['id'] . "'>" . $ov['id'] . "</option>";
        endforeach;
        $return .= "</select>";
    }
}elseif ($val == 2) { // Service name
    $options_val = get_filter_dropdown_options_for_services($val);
    if (isset($options_val) && count($options_val) > 0) {
        $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[servicename][]'>";
        $return .= "<option value=''>All Criteria</option>";
        $new_sort = array();
        foreach ($options_val as $key => $ov):
            $new_sort[$key] = strtolower($ov['description']);
        endforeach;
        array_multisort($new_sort, SORT_ASC, $options_val);
        foreach ($options_val as $ov):
            $return .= "<option value='" . $ov['id'] . "'>" . $ov['description'] . "</option>";
        endforeach;
        $return .= "</select>";
    }
}elseif ($val == 3) { // Department
    $options_val = get_filter_dropdown_options_for_services($val);

    if (isset($options_val) && count($options_val) > 0) {
        $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[department][]'>";
        $return .= "<option value=''>All Criteria</option>";
        $new_sort = array();
        foreach ($options_val as $key => $ov):
            $new_sort[$key] = strtolower($ov['name']);
        endforeach;
        array_multisort($new_sort, SORT_ASC, $options_val);
        foreach ($options_val as $ov):
            $return .= "<option value='" . $ov['id'] . "'>" . $ov['name'] . "</option>";
        endforeach;
        $return .= "</select>";
    }
}elseif ($val == 4) { // Tracking
    $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[tracking][]'>";
    $return .= "<option value=''>All Criteria</option>";
    $return .= '<option value="7">Cancelled</option>';
    $return .= '<option value="0">Completed</option>';
    $return .= '<option value="3">Late</option>';
    $return .= '<option value="4">Not Completed</option>';
    $return .= '<option value="2">Not Started</option>';
    $return .= '<option value="1">Started</option>';
    $return .= "</select>";
}elseif ($val == 5) { // Start date
    $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Start Date" name="criteria_dropdown[startdate][]" value="">';
} elseif ($val == 6) { // Complete date
    $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">';
} elseif ($val == 7) { //Request type
    $return .= "<select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' name='criteria_dropdown[request_type][]'>";
    $return .= "<option value=''>All Criteria</option>";
    $return .= '<option value="byme">By ME</option>';
    $return .= '<option value="tome">To ME</option>';
    $return .= '<option value="byothers">Others</option>';
    $return .= "</select>";
} else {
    $return .= '<select class="form-control criteria-dropdown chosen-select" placeholder="All Criteria" name="criteria_dropdown[][]">';
    $return .= "<option value=''>All Criteria</option>";
    $return .= '</select>';
}
echo $return;
?>
<script type="text/javascript">
    $(function () {
        $(".datepicker_mdy").datepicker({format: 'mm/dd/yyyy', autoHide: true});
    });
</script>