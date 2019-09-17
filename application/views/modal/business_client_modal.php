<?php if ($modal_type != "edit"): ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Sales Tax Rate</h3>
            </div>
            <form id="add-business-client-form-modal" name="add-business-client-form-modal">
                <div class="modal-body">
                    <div class="form-group">
                        <label>State<span class="text-danger">*</span></label>
                        <select id="state" name="state" title="State" required class="form-control">
                            <option value="">Select</option>
                            <?php
                            foreach ($state as $val) {
                                ?>
                                <option value="<?= $val['id']; ?>"><?= $val['state_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>County<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" title="County" name="client_name" id="client_name" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Rate<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" title="Rate" name="client_rate" id="client_rate" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Due On<span class="text-danger">*</span></label>
                        <select class="form-control" title="Due Date" id="due_date" name="due_date" required="">
                            <?php for ($day = 1; $day <= 31; $day++): ?>
                                <option value="01/<?= $day; ?>/2000"><?= $day; ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_business_client()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Sales Tax Rate</h4>
            </div>
            <form id="edit-business-client-form-modal" name="edit-business-client-form-modal">
                <div class="modal-body">                                           
                            <input type="hidden" id="client_id" name="client_id" value="<?= $business_client["id"]; ?>">
                            <?php $states = state_info($business_client["state"]); ?>
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
                            <div class="form-group">
                                <label>County<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" title="County" name="client_name"
                                       id="client_name" required value="<?= $business_client["name"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Rate<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" title="Rate" name="client_rate"
                                       id="client_rate" required value="<?= $business_client["rate"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Due On<span class="text-danger">*</span></label>                                
                                <select class="form-control" title="Due Date" id="due_date" name="due_date" required="">
                                    <?php for ($day = 1; $day <= 31; $day++): ?>
                                        <option <?= date('d', strtotime($business_client['due_date'])) == $day ? "selected='selected'" : ''; ?> value="01/<?= $day; ?>/2000"><?= $day; ?></option>
                                    <?php endfor; ?>
                                </select>                                
                                <div class="errorMessage text-danger"></div>
                            </div>                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_business_client()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
    $(function () {
//        $('#due_date').datepicker({format: 'mm/dd/yyyy', autoHide: true});
    });
</script>
