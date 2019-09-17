<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add Lead Source</h3>
            </div>
            <form id="add-lead-source-form" name="add-lead-source-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" title="Lead Source Name" name="source_name"
                               id="source_name" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_lead_source()">Save
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
                <h3 class="modal-title">Update Lead Source</h3>
            </div>
            <form id="edit-lead-source-form" name="edit-lead-source-form">
                <div class="modal-body">
                    <input type="hidden" id="source_id" name="source_id"
                           value="<?= $lead_source_name["id"]; ?>">
                    <div class="form-group">
                        <label>Source Name</label>
                        <input class="form-control" type="text" title="Lead Source Name" name="source_name"
                               id="source_name" required value="<?= $lead_source_name["name"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_lead_source()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
