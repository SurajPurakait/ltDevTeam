<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add Type Of Contact Referral</h3>
            </div>
            <form id="add-lead-ref-form" name="add-lead-ref-form">            
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" title="Lead Reference Name" name="ref_name"
                               id="ref_name" required>
                        <div class="errorMessage text-danger"></div>
                    </div>                       
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_lead_ref()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php else: ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Update Type Of Contact Referral</h3>
            </div>
            <form id="edit-lead-ref-form" name="edit-lead-ref-form">
                <div class="modal-body">
                    <input type="hidden" id="ref_id" name="ref_id" value="<?= $lead_ref_name["id"]; ?>">
                    <div class="form-group">
                        <label>Source Name</label>
                        <input class="form-control" type="text" title="Lead Reference Name" name="ref_name"
                               id="ref_name" required value="<?= $lead_ref_name["name"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_lead_ref()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php endif; ?>
