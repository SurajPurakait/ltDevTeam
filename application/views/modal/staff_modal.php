<?php
$ci = &get_instance();
$ci->load->model('system');
$ci->load->model('administration');
if ($modal_type == "edit") {
    ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Edit Staff</h3>
            </div>
            <form class="form-horizontal" method="post" id="edit_staff_form" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Select Type<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="edit_staff_type" name="type" class="form-control" title="Staff Type" onchange="displayRoleField(this.value);" required="">
                                <?php foreach ($staff_type_list as $stl) { ?>
                                    <option value="<?php echo $stl['id']; ?>" <?php echo $staff_info['type'] == $stl['id'] ? "selected='selected'" : ""; ?>><?php echo $stl['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group role_div">
                        <label class="col-lg-3 control-label">Role</label>
                        <div class="col-lg-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="m" <?= ($staff_info['role'] == 2 || $staff_info['role'] == 4) ? 'checked=\'checked\'' : ''; ?> name="staff_role" title="Staff Role" id="staff_role" />Manager
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">First Name<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="First name" nameval="" class="form-control" type="text" name="first_name" id="first_name" title="First name" required="" value="<?php echo $staff_info['first_name']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Middle Name</label>
                        <div class="col-lg-9">
                            <input placeholder="Middle name" class="form-control" nameval="" type="text" name="middle_name"
                                   id="middle_name" title="Middle name"
                                   value="<?php echo $staff_info['middle_name']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Last Name<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Last name" class="form-control" required="" nameval="" type="text" name="last_name"
                                   id="last_name" title="Last name" value="<?php echo $staff_info['last_name']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Date of Birth<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <?php
                            if ($staff_info['birth_date'] != NULL && $staff_info['birth_date'] != '0000-00-00') {
                                $dob = strtr($staff_info['birth_date'], '-', '/');
                                $birth_date = date('m/d/Y', strtotime($dob));
                            } else {
                                $birth_date = '';
                            }
                            ?>
                            <input id="birth_date" placeholder="mm/dd/yyyy" class="form-control datepicker_mdy" type="text" 
                                   title="Date of birth" name="birth_date"
                                   value="<?php echo date('m/d/Y', strtotime($birth_date)); ?>" required="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <?php 
                    $maskedssn = substr_replace($staff_info['ssn_itin'], '-', 4, 0);
                    $maskedssn = substr_replace($maskedssn, '-', 7, 0);
                     ?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">SSN/ITIN</label>
                        <div class="col-lg-9">
                            <input data-mask="999-99-9999" placeholder="___-__-____" class="form-control" type="text" name="ssn_itin" id="ssn_itin" title="SSN/ITIN" value="<?php echo $maskedssn; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="edit-inner-div">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <select id="office"
                                        class="form-control" <?php echo $staff_info['type'] == "3" ? "multiple" : ""; ?>
                                        name="office[]" title="Office" required="">
                                            <?php
                                            echo $staff_info['type'] != "3" ? "<option value=''>Select</option>" : "";
                                            foreach ($office_list as $ol) {
                                                $select = !empty($ci->administration->get_office_staff_by_office_id_staff_id($staff_info['id'], $ol['id'])) ? "selected='selected'" : "";
                                                echo "<option $select value='" . $ol['id'] . "'>" . $ol['name'] . "</option>";
                                            }
                                            ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?php //if ($staff_info['type'] == 3) { ?>
                            <!-- <div class="form-group">
                                <label class="col-lg-3 control-label">Role<span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select id="role" class="form-control" name="role" title="Role" required="">
                                        <option value=''>Select</option>
                                        <option <?php //echo ($staff_info['role']==1) ? 'selected' : '';             ?> value='1'>Standard</option>
                                        <option <?php //echo ($staff_info['role']==2) ? 'selected' : '';             ?> value='2'>Manager</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div> -->
                            <!-- <input type="hidden" id="role" name="role" value="<?php //echo $staff_info['role']; ?>"> -->
                        <?php //} ?>
                        <?php if ($staff_info['type'] == 2) { ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Department<span class="text-danger">*</span></label>
                                <div class="col-lg-9 dept-inner">
                                    <select id="department" <?php echo $staff_info['type'] == "2" ? "multiple" : ""; ?>
                                            name="department[]" class="form-control" title="Department" required="">
                                                <?php
                                                echo $staff_info['type'] != "2" ? "<option value=''>Select</option>" : "";
                                                foreach ($department_list as $dl) {
                                                    $select = !empty($ci->administration->get_department_staff_by_department_id_staff_id($staff_info['id'], $dl['id'])) ? "selected='selected'" : "";
                                                    echo "<option $select value='" . $dl['id'] . "'>" . $dl['name'] . "</option>";
                                                }
                                                ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="department[]" value="<?php echo $department_list[0]['id']; ?>">
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Phone</label>
                        <div class="col-lg-9">
                            <input placeholder="Phone" id="phone" phoneval="" class="form-control" type="text" name="phone" title="Phone" value="<?php echo $staff_info['phone']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Cell</label>
                        <div class="col-lg-9">
                            <input placeholder="Cell" id="cell" class="form-control" type="text" name="cell" title="Cell" value="<?php echo $staff_info['cell']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Extension</label>
                        <div class="col-lg-9">
                            <input placeholder="Extension" id="extension" class="form-control" type="text" name="extension" title="Extension" value="<?php echo $staff_info['extension']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email / Username<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Email address" id="user" class="form-control" type="email" name="user" title="Email / Username" value="<?php echo $staff_info['user']; ?>" title="Email" required="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Password<span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input placeholder="Password" class="form-control" passval="" type="password" name="password" required
                                   readonly="" value="***********" title="Password" id="password">
                            <div class="errorMessage text-danger"></div>
                        </div>
                        <a href="javascript:void(0);" id="edit-password"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <input type="hidden" value="0" name="hidpwd" id="hidpwd">
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Re-Type Password<span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input placeholder="Password" class="form-control" passval="" type="password" name="retype_password" 
                                   readonly=""  value="" title="Password" id="retype_password">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <?php if ($staff_info['photo'] != "") {
                        ?>
                        <div class="form-group" id="uploaded_photo">
                            <label class="col-lg-3 control-label">Photo</label>
                            <div class="col-lg-9">
                                <img src="<?php echo base_url(); ?>uploads/<?php echo $staff_info['photo']; ?>"
                                     class="editimg" height="50" width="50">
                            </div>
                        </div>
                    <?php }
                    ?>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Upload Photo</label>
                        <div class="col-lg-9">
                            <input class="m-t-5" type="file" name="photo" id="photo" allowed_types="jpg|png|jpeg" title="Photo">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Status</label>
                        <div class="col-lg-9">
                            <label class="radio-inline">
                                <input type="radio" value="1" required="" <?php echo ($staff_info['status'] == 1) ? 'checked=""' : ''; ?> title="Status" name="status" id="staff_active"><label for="staff_active">Active</label>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="0" required="" <?php echo ($staff_info['status'] == 0) ? 'checked=""' : ''; ?> title="Status" name="status" id="staff_inactive"><label for="staff_inactive">Inactive</label>
                            </label>
                            <div class="errorMessage text-danger" id="status_error"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="rowid" value="<?php echo $staff_info['id']; ?>">
                    <button class="btn btn-success" type="button" id="save_changes" onclick="update_staff()">Save changes</button> &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add New Staff</h3>
            </div>
            <form class="form-horizontal" method="post" id="add_staff_form" enctype="multipart/form-data"
                  onsubmit="return false;">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Select Type<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="edit_staff_type" name="type" class="form-control" title="Staff Type" onchange="displayRoleField(this.value);" required="">
                                <?php foreach ($staff_type_list as $stl) {
                                    ?>
                                    <option value="<?php echo $stl['id']; ?>"><?php echo $stl['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group role_div">
                        <label class="col-lg-3 control-label">Role</label>
                        <div class="col-lg-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="m" name="staff_role" title="Staff Role" id="staff_role" />Manager
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">First Name<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="First name" class="form-control" required="" nameval="" type="text" name="first_name" id="first_name" title="First name">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Middle Name</label>
                        <div class="col-lg-9">
                            <input placeholder="Middle name" class="form-control" nameval="" type="text" name="middle_name" id="middle_name" title="Middle name">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Last Name<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Last name" class="form-control" nameval="" required="" type="text" name="last_name" id="last_name" title="Last name">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Date of Birth<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input id="birth_date" placeholder="mm/dd/yyyy" class="form-control datepicker_mdy" type="text" title="Date of birth" name="birth_date" required="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">SSN/ITIN</label>
                        <div class="col-lg-9">
                            <input data-mask="999-99-9999" placeholder="___-__-____" class="form-control" type="text" name="ssn_itin" id="ssn_itin" title="SSN/ITIN">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="edit-inner-div">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <select id="office" class="form-control" name="office[]" title="Office" required="">
                                    <option value=''>Select</option>
                                    <?php
                                    foreach ($office_list as $ol) {
                                        echo "<option value='" . $ol['id'] . "'>" . $ol['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?php
                        $staff_info = staff_info();
                        if ($staff_info['type'] == 2) {
                            ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Department<span class="text-danger">*</span></label>
                                <div class="col-lg-9 dept-inner">
                                    <select id="department" name="department[]" class="form-control" title="Department" required="">
                                        <option value=''>Select</option>
                                        <?php
                                        foreach ($department_list as $dl) {
                                            echo "<option selected value='" . $dl['id'] . "'>" . $dl['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="department[]" value="<?php echo $department_list[0]['id']; ?>">
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Phone</label>
                        <div class="col-lg-9">
                            <input placeholder="Phone" id="phone" phoneval="" class="form-control" type="text" name="phone" title="Phone" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Cell</label>
                        <div class="col-lg-9">
                            <input placeholder="Cell" id="cell" class="form-control" type="text" name="cell" title="Cell" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Extension</label>
                        <div class="col-lg-9">
                            <input placeholder="Extension" id="extension" class="form-control" type="text" name="extension" title="Extension" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email / Username<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Email address" id="user" class="form-control" type="email" name="user" title="Email / Username" title="Email" required="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Password<span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input placeholder="Password" passval="" class="form-control" type="password" name="password" required title="Password" id="password">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Re-Type Password<span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input placeholder="Password" passval="" class="form-control" type="password" name="retype_password" required title="Password" id="retype_password">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Upload Photo</label>
                        <div class="col-lg-9">
                            <input class="m-t-5" type="file" name="photo" id="photo" allowed_types="jpg|png|jpeg" title="Photo">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Status</label>
                        <div class="col-lg-9">
                            <label class="radio-inline">
                                <input type="radio" value="1" required="" checked="" title="Status" name="status" id="staff_active"><label for="staff_active">Active</label>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="0" required="" title="Status" name="status" id="staff_inactive"><label for="staff_inactive">Inactive</label>
                            </label>
                            <div class="errorMessage text-danger" id="status_error"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" onclick="insert_staff()">Submit</button> &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<script>
    displayRoleField(getIdVal('edit_staff_type'));
    function displayRoleField(type) {
        $('.role_div').hide();
        if (type == 2 || type == 3) {
            $('.role_div').show();
        }
    }
    $(document).ready(function () {
        $(".datepicker_my").datepicker({format: 'mm/yyyy', autoHide: true});
        $(".datepicker_mdy").datepicker({format: 'mm/dd/yyyy', autoHide: true});
        $(".datepicker_my, .datepicker_mdy").attr("onblur", 'checkDate(this);');
        $("#edit_staff_type").change(function () {
            var staff_type = $(this).val();
            if (staff_type != '') {
                $.ajax({
                    type: "POST",
                    data: {
                        staff_type: staff_type
                    },
                    url: '<?php echo base_url(); ?>administration/manage_staff/office_department_staffwise_ajax',
                    dataType: "html",
                    success: function (result) {
                        $(".edit-inner-div").html(result);
                    }
                });
            }
        });
        $("#edit-password").click(function () {
            if ($('#password').is('[readonly]')) {
                $("#password").attr("readonly", false);
                $("#retype_password").attr("readonly", false);
                $("#retype_password").attr("required", true);
                $("#hidpwd").val(1);
                $("#password").val("");
            } else {
                $("#password").attr("readonly", true);
                $("#retype_password").attr("readonly", true);
                $('#retype_password').prop('required', false);
                $("#hidpwd").val(0);
                $("#password").val("***********");
            }
        });
    });
</script>