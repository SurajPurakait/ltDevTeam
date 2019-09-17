<?php
if($reference=='company'){ ?>
<div class="form-group" id="client_list">
    <label>Business Client List<span class="text-danger">*</span></label>
        <select class="form-control client_type_field0" name="client_list" id="client_list_ddl" title="Business Client List" required="">
            <option value="">Select an option</option>
            <?php
            foreach ($completed_orders as $data) {
                ?>
                <option value="<?= $data['reference_id']; ?>"><?= $data['name']; ?></option>
                <?php
            }
            ?>
        </select>
        <div class="errorMessage text-danger"></div>
</div>
 <?php } else{ ?>
    <div class="form-group">
    	<label>Individual List<span class="text-danger">*</span></label>
            <select class="form-control individual_list client_type_field0" name="individual_list" id="individual_list_ddl" title="Individual List">
                <option value="">Select an option</option>
                <?php load_ddl_option("existing_individual_list_new"); ?>
            </select>
            <div class="errorMessage text-danger"></div>
    </div>
 <?php } ?>
