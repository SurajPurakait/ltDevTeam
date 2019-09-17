<?php if ($modal_type != "edit") { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Renewal Dates</h3>
            </div>
            <form id="add-renewal-dates-form-modal" name="add-renewal-dates-form-modal">
                <div class="modal-body">                                          
                    <div class="form-group">
                        <label>State<span class="text-danger">*</span></label>
                        <select id="state" name="state" title="State" required class="form-control">
                            <option value="">Select an option</option>
                            <?php load_ddl_option("state_list"); ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Type Of Company<span class="text-danger">*</span></label>
                        <select class="form-control value_field required_field" name="type" id="type" title="Type of Company" required="">
                            <option value="">Select an option</option>
                            <?php load_ddl_option("company_type_list"); ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Due Date<span class="text-danger">*</span></label>
                        <input placeholder="dd/mm/yyyy" class="form-control datepicker_my value_field" type="text" title="Due Date" name="start_year"
                               id="due_date" value="" required>
                    </div>                       
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_renewal_dates()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Edit Renewal Dates</h3>
            </div>
            <form id="edit-renewal-dates-form-modal" name="edit-renewal-dates-form-modal">
                <div class="modal-body">                    
                    <input type="hidden" id="client_id" name="client_id" value="<?= $renewal_dates["id"]; ?>">
                    <?php $states = state_info($renewal_dates["state"]); ?>
                    <div class="form-group">
                        <label>State<span class="text-danger">*</span></label>
                        <select id="state" name="state" title="State" required class="form-control">
                            <option value="">Select</option>
                            <?php
                            foreach ($state as $val) {
                                ?>
                                <option value="<?= $val['id']; ?>" <?php echo ($val['id'] == $states['id'] ? 'selected' : ''); ?> ><?= $val['state_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <?php $companys = company_type_info($renewal_dates["type"]); ?>
                    <div class="form-group">
                        <label>Type Of Company<span class="text-danger">*</span></label>
                        <select id="type" name="type" title="Type of Company" required class="form-control">
                            <option value="">Select</option>
                            <?php
                            foreach ($company as $val) {
                                ?>
                                <option value="<?= $val['id']; ?>" <?php echo ($val['id'] == $companys['id'] ? 'selected' : ''); ?> ><?= $val['type']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Due Date<span class="text-danger">*</span></label>
                        <input placeholder="dd/mm/yyyy" class="form-control datepicker_my value_field" type="text" title="Due Date" name="start_year"
                               id="due_date" value="<?php echo $renewal_dates['date']; ?>" required>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_renewal_dates()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<script>
    $(document).ready(function () {
        $(".datepicker_my").datepicker({format: 'dd-mm-yyyy', autoHide: true});

    });
</script>