<?php 
$return = '';
        if($variable_ddval==6){ //start date
             $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_range_mdy" type="text" title="Start Date" name="criteria_dropdown[startdate][]" value="">';   
        }
        elseif($variable_ddval==7){ //complete date
              $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_range_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">'; 
        }
        
         elseif($variable_ddval==11){ //complete date
              $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_range_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">'; 
        }
        
        
         elseif($variable_ddval==12){ //complete date
              $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_range_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">'; 
        }
        
         elseif($variable_ddval==13){ //complete date
              $return = '<input placeholder="dd/mm/yyyy" class="form-control datepicker_range_mdy" type="text" title="Complete Date" name="criteria_dropdown[completedate][]" value="">'; 
        }
        
        
        
        
        echo $return;

?>


<script type="text/javascript">
 $(function () {
    $(".datepicker_range_mdy").daterangepicker();
});
</script>