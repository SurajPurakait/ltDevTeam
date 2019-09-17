<?php if ($modal_type != "edit"): ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add Main Category</h3>
            </div>
            <form id="add-operational-main-cat-form"  name="add-operational-main-cat-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" title="Main Category Name" name="main_cat_name" id="main_cat_name" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <!-- <div class="form-group">
                        <label>Icon<span class="text-danger"></span></label>
                        <input class="form-control" type="text" title="Category Icon" name="icon" id="main_cat_icon">
                        <div class="errorMessage text-danger"></div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_operational_main_cat()">Save
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
                <h3 class="modal-title">Update Main Category</h3>
            </div>
            <form id="edit-operational-main-cat-form" name="edit-operational-main-cat-form">
                <div class="modal-body">
                    <input type="hidden" id="cat_id" name="cat_id" value="<?= $main_cat_name["id"]; ?>">
                    <div class="form-group">
                        <label>Category Name<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" title="Main Category Name" name="main_cat_name" id="main_cat_name" required value="<?= $main_cat_name["name"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
<!--                    <div class="form-group">
                        <label>Icon<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" title="Category Icon" name="icon" id="main_cat_icon" required value="<?= $main_cat_name["icon"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_operational_main_cat()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
