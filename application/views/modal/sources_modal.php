<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog">        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Referred By Source</h3>
            </div>
            <form id="add-source-form" name="add-source-form">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Source Name</label>
                            <input class="form-control" type="text" title="Source Name" name="source_name"
                                   id="source_name" required>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>                       
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_source_type()">Save
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
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Update Referred By Source</h3>
            </div>
            <form id="edit-source-form" name="edit-source-form">
                <div class="modal-body">
                    <input type="hidden" id="source_id" name="source_id" value="<?= $source_name["id"]; ?>">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Source Name</label>
                            <input class="form-control" type="text" title="Source Name" name="source_name"
                                   id="source_name" required value="<?= $source_name["source"]; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_source_type()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php endif; ?>
