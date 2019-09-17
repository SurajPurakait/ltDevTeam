<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add Type Of Contact Prospect</h3>
            </div>
            <form id="add-lead-type-form" name="add-lead-type-form">            
                <div class="modal-body">                    
                    <div class="form-group">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" title="Lead Name" name="lead_name"
                                   id="lead_name" required>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_lead_type()">Save
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
                <h3 class="modal-title">Update Type Of Contact Prospect</h3>
            </div>
            <form id="edit-lead-type-form" name="edit-lead-type-form">
                <div class="modal-body">
                    <input type="hidden" id="type_id" name="type_id" value="<?= $lead_type_name["id"]; ?>">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Source Name</label>
                            <input class="form-control" type="text" title="Lead Name" name="lead_name"
                                   id="lead_name" required value="<?= $lead_type_name["name"]; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_lead_type()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php endif; ?>
