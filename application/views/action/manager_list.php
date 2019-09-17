<?php
if(!empty($mngrs)){ ?>
    <option value="">Select Manager</option>
<?php 
foreach($mngrs as $m){
    
if(is_array($selected)){ ?>
<option <?php echo (in_array($m['id'],$selected)) ? 'selected' : '';?> value="<?php echo $m['id']; ?>"><?php echo get_assigned_by_staff_name($m['id']); ?></option>
<?php }else{ ?>
<option <?php echo ($selected==$m['id']) ? 'selected' : '';?> value="<?php echo $m['id']; ?>"><?php echo get_assigned_by_staff_name($m['id']); ?></option>
<?php } 
} // endforeach ?>
<?php } else{ ?>
<option value="">Select Manager</option>
<?php } ?>