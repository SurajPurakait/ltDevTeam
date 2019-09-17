<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Update Operational Manual</h3>
        </div>
        <form id="edit-operational-manual-form" name="edit-operational-manual-form">
            <div class="modal-body">
                <input type="hidden" id="manual_id" name="manual_id" value="<?= $data[0]["id"]; ?>">
                <div class="form-group">
                    <label>Title<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" title="Title" name="title" id="title" required value="<?= $data[0]["title"]; ?>">
                    <div class="errorMessage text-danger"></div>
                </div>
                <div class="form-group">
                    <label>Description<span class="text-danger">*</span></label>
                    <textarea class="form-control" type="text" name="description" id="description" required ><?= $data[0]["description"]; ?></textarea>>
                    <div class="errorMessage text-danger"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="edit_operational_manual()">Save
                    Changes
                </button>
            </div>
        </form>
    </div>
</div>