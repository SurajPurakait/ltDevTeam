<div class="col-md-12">
    <div class="form-group client_type_div0" id="client_list">
        <label class="col-lg-6 control-label">Client List<span class="text-danger">*</span></label>
        <select class="form-control individual_list client_type_field0" name="project[client_id]" id="individual_list_ddl" title="Individual List" required>
            <option value="">Select an option</option>
            <?php load_ddl_option("existing_individual_list_new", (isset($client_id))? $client_id:''); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>