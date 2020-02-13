<?php
if(isset($project_id) && $project_id!=''){
    $disabled= "pointer-events:none";
    $readonly= 'readonly';
}else{
    $disabled='';
    $readonly='';
}
?>
<div class="col-md-12">
    <div class="form-group client_type_div0">
        <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
        <select class="form-control client_type_field0" name="project[office_id]" id="staff_office" title="Office" required="" onchange="refresh_existing_individual_list(this.value)" style="<?= $disabled ?>" <?= $readonly ?>>
            <option value="">Select Office</option>
            <?php load_ddl_option("staff_office_list",(isset($office_id)? $office_id:''), (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<?php if(isset($project_id) && $project_id!=''){ ?>
<div class="col-md-12">
    <div class="form-group client_type_div0" id="client_list">
        <label class="col-lg-6 control-label">Client List<span class="text-danger">*</span></label>
        <select class="form-control individual_list client_type_field0" name="project[client_id][]" id="individual_list_ddl_edit" title="Individual List" required style="<?= $disabled ?>" <?= $readonly ?>>
            <option value="">Select an option</option>
            <option value="<?= $client_id; ?>" <?= $client_id!=''?'selected':''?> ><?= $client_name; ?></option>
            <?php // load_ddl_option("existing_individual_list_new", (isset($client_id))? $client_id:''); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<?php }else{?>
<div class="col-md-12">
    <div class="form-group client_type_div0" id="client_list">
        <label class="col-lg-6 control-label">Client List<span class="text-danger">*</span></label>
        <select class="form-control individual_list client_type_field0" name="project[client_id][]" id="individual_list_ddl" title="Individual List" required>
            <option value="">Select an option</option>
            <?php load_ddl_option("existing_individual_list_new", (isset($client_id))? $client_id:''); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<?php } ?>
<script>
    <?php if(isset($project_id) && $project_id!=''){ ?>
        refresh_existing_individual_list('<= $office_id ?>','<= $client_id ?>');
   <?php }else{?>
   $("#individual_list_ddl").chosen();
   <?php } ?>
    </script>