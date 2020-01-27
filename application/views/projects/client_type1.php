<?php //   $staff_office = staff_office_for_invoice($invoice_id);   ?>
<div class="col-md-12">
    <div class="form-group client_type_div0">
        <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
        <select class="form-control client_type_field0" name="project[office_id]" id="staff_office" onchange="refresh_existing_client_list(this.value,'');" title="Office" required="">
            <option value="">Select Office</option>
            <?php load_ddl_option("staff_office_list",(isset($office_id)? $office_id:''), (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<?php // print_r($completed_orders); ?>
<div class="col-md-12">
    <div class="form-group client_type_div0" id="client_list" style="display: none">
        <label class="col-lg-6 control-label">Client List<span class="text-danger">*</span></label>

        <select class="form-control client_type_field0" name="project[client_id][]" id="client_list_ddl" title="Client List" <?php echo (isset($client_id) && $client_id !='') ? 'disabled' : ''; ?> multiple required>
            <option value="">Select an option</option>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<script>
    <?php if(isset($project_id) && $project_id!=''){ ?>
        refresh_existing_client_list('<?= $office_id ?>','<?= $client_id ?>');
   <?php }?>
   $("#client_list_ddl").chosen();
    </script>