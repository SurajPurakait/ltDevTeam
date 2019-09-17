<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add Sub Category</h3>
            </div>
            <form id="add-sub-cat-form" name="add-sub-cat-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Main Category</label>
                        <select  class="form-control"  title="Main Category Name" name="main_cat_name"
                                 id="main_cat_name" required>
                                     <?php
                                     if (!empty($main_cat)) {
                                         foreach ($main_cat as $c) {
                                             ?>
                                    <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Sub Category Name</label>
                        <input class="form-control" type="text" title="Sub Category Name" name="sub_cat_name"
                               id="sub_cat_name" required>
                        <div class="errorMessage text-danger"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_operational_sub_cat()">Save
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
                <h3 class="modal-title">Update Sub Category</h3>
            </div>
            <form id="edit-sub-cat-form" name="edit-sub-cat-form">
                <div class="modal-body">
                    <input type="hidden" id="cat_id" name="cat_id"
                           value="<?= $sub_cat_name["id"]; ?>">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input class="form-control" type="text" title="Sub Category Name" name="sub_cat_name"
                               id="sub_cat_name" required value="<?= $sub_cat_name["name"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Main Category</label>
                        <select  class="form-control"  title="Main Category Name" name="main_cat_name"
                                 id="main_cat_name" required>
                                     <?php
                                     if (!empty($main_cat)) {
                                         foreach ($main_cat as $c) {
                                             ?>
                                    <option <?php echo ($sub_cat_name['main_cat_id'] == $c['id']) ? 'selected' : ''; ?> value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_operational_sub_cat()">Save
                        Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php endif; ?>
