<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Document</h3>
            </div>
            <form role="form" id="form_document">
                <div class="modal-body">
                            <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                            <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" name="doc_type" id="doc_type" title="Type">
                                    <!-- required -->
                                    <option value="DRIVERS LICENSE">DRIVER'S LICENSE</option>
                                    <option value="PASSPORT">PASSPORT</option>
                                    <option value="VISA">VISA</option>
                                    <option value="SSN CARD">SSN CARD</option>
                                    <option value="CONTRACT OF SALE">CONTRACT OF SALE</option>
                                    <option value="PURCHASE CONTRACT">PURCHASE CONTRACT</option>
                                    <option value="OTHER">OTHER</option>
                                </select>
                                <!-- <div class="errorMessage text-danger"></div> -->
                            </div>
                            <div class="form-group">
                                <label>File</label>
                                <input class="" type="file" name="doc_file" allowed_types="pdf|doc|docx|gif|png|jpg|jpeg" id="doc_file" title="Document File">
                                <!-- required -->
                                <!-- <div class="errorMessage text-danger"></div> -->
                            </div>                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save_document()">Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php else: ?>

<?php endif; ?>