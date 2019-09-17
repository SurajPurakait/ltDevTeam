<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 b-r">
                        <h2 class="m-t-none m-b">Add Document</h2>
                        <form role="form" id="form_document">
                            <input type="hidden" name="reference" value="<?= $reference; ?>">
                            <input type="hidden" name="reference_id" value="<?= $reference_id; ?>">
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" name="doc_type" required>
                                    <option value="DRIVERS LICENSE">DRIVER'S LICENSE</option>
                                    <option value="PASSPORT">PASSPORT</option>
                                    <option value="VISA">VISA</option>
                                    <option value="SSN CARD">SSN CARD</option>
                                    <option value="OTHER">OTHER</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>File</label>
                                <input class="form-control" type="file" name="doc_file" required>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="insert_document()">Save changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>

<?php endif; ?>