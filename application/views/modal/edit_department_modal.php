<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Edit Department Information</h3>
        </div>
        <form class="form-horizontal" method="post" id="edit_dept_form" onsubmit="return false;">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Name<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="Name" readonly="" class="form-control" type="text"
                               value="<?php echo $department_info['name']; ?>" name="name" id="name" required
                               title="Name" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
               <!--  <div class="form-group">
                    <label class="col-lg-3 control-label">Department Manager</label>
                    <div class="col-lg-9">
                        <select title="Department Manager" class="form-control" name="deptmngr" id="deptmngr">
                            <option value="">Select an option</option>
                            <?php //foreach ($department_staffs as $ds) { ?>
                                <option <?//= (isset($selected_manager) && $selected_manager['manager_id'] == $ds['staff_id']) ? 'selected="selected"' : ''; ?> value="<?//= $ds['staff_id']; ?>"><?//= $ds['staff_name']; ?></option>
                            <?php //} ?>
                        </select>
                    </div>
                </div> -->

                <div class="form-group">
                    <label class="col-lg-3 control-label">Phone<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="Phone" class="form-control" phoneval="" type="text" value="<?php echo $department_info['phone']; ?>" name="phone" id="phone" required title="Phone" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Extension<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="Extension" class="form-control" id="extension" type="text"
                               value="<?php echo $department_info['extension']; ?>" name="extension" required
                               title="Extension" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Email Address<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="Email Address" class="form-control" id="emailaddress" type="email"
                               value="<?php echo $department_info['email']; ?>" name="email" required
                               title="Email address" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="dept_id" value="<?php echo $department_info['id']; ?>">
                <button class="btn btn-success" type="button" onclick="update_departments();">Save changes</button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>