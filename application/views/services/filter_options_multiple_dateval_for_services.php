<?php 
$return = '';
        if($variable_ddval == 5){ // Start date
             $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_range_mdy" type="text" title="Start Date" name="criteria_dropdown[startdate][]" value="">';   
        }
        elseif($variable_ddval == 6){ // Complete date
              $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_range_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">'; 
        }
        echo $return;
?>
<script type="text/javascript">
 $(function () {
    $(".datepicker_range_mdy").daterangepicker();
});
</script>