<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Company Type</h3>
            </div>
            <form id="add-company-form" name="add-company-form">
                <div class="modal-body">                    
                    <div class="form-group">
                        <label>Company Type</label>
                        <input class="form-control" type="text" title="Copmany Name" name="company_name"
                               id="company_name" required>
                        <div class="errorMessage text-danger"></div>
                    </div>                                          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_company_type()">Save
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
                <h3 class="modal-title">Add Company Type</h3>
            </div>
            <form id="edit-company-form" name="edit-company-form">
                <div class="modal-body">                 
                    <input type="hidden" id="company_id" name="company_id" value="<?= $company_name["id"]; ?>">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Company Type</label>
                            <input class="form-control" type="text" title="Copmany Name" name="company_name"
                                   id="company_name" required value="<?= $company_name["type"]; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>                              
                    </div>                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_company_type()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php endif; ?>
