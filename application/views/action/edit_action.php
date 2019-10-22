<?php
$staff_info = staff_info();
if ($data["added_by_user"] == sess("user_id")) {
    $disabled = '';
}
else {
    $disabled = 'disabled';
}
if ($data["added_by_user"] == sess("user_id") || ($staff_info['type'] == 1 || $staff_info['department'] == 14)) {
    $disable = '';
} else {
    $disable = 'disabled';
}
?>
<style type="text/css">
    #not-active{
        pointer-events: none; 
        cursor: default; 
    }

</style>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="edit_action">
                        <h3>Action ID<span><?php echo ' #' . $action_id; ?></span></h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">My Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="created_office" id="created_office" title="Office" required="" disabled="true">
                                    <option value="">Select Office</option>
                                    <?php load_ddl_option("staff_office_list", $data['created_office'], "staff_office"); ?>

                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">My Department<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="created_department" id="created_department" title="Department" required="" disabled="true" <?= $disabled ?> >
                                    <?php
                                    $searchString = ',';

                                    if (strpos($staff_info['department'], $searchString) !== false) {
                                        $dataArr = explode(',', $staff_info['department']);
                                        foreach ($dataArr as $value) {
                                            $dataval = get_department_info_by_id($value);
                                            ?>
                                            <option <?php echo ($dataval['id'] == $data['created_department']) ? 'selected' : ''; ?> value="<?= $dataval['id']; ?>"><?= $dataval['name']; ?></option>    
                                            <?php
                                        }
                                    } else {
                                        $dataval = get_department_info_by_id($data['created_department']);
                                        ?>
                                        <option value="<?= $dataval['id']; ?>" selected><?= $dataval['name']; ?></option>                             
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Priority<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select required class="form-control" title="Priority" name="priority" id="priority" required="" <?= $disabled ?> disabled="true">
                                    <option value="">Select an option</option>
                                    <option value="1" <?= ($data["priority"] == 1) ? "selected" : ""; ?>>Urgent</option>
                                    <option value="2" <?= ($data["priority"] == 2) ? "selected" : ""; ?>>Important</option>
                                    <option value="3" <?= ($data["priority"] == 3) ? "selected" : ""; ?>>Regular</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>     

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Assign Myself</label>
                            <div class="col-lg-10 checkbox">
                                <label><input type="checkbox" <?php echo ($data['my_task'] != 0) ? 'checked' : ''; ?> id="assign_to_myself" name="assign_to_myself" title="Assign Myself" <?= $disable ?> ></label>
                            </div>
                        </div>  
                        <div class="form-group dept_div">
                            <label class="col-lg-2 control-label">Assign to Department<span class="spanclass text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select required class="form-control" title="Department" name="department" id="department" onchange="get_action_office();">
                                    <?php
                                    foreach ($departments as $value):
//                                        if ($value['name'] != "Franchise" || ($value['name'] == "Franchise" && $staff_info['type'] != 3)): 
                                        ?>
                                        <option value="<?= $value["id"]; ?>" <?= ($value["id"] == $data["department"]) ? "selected" : ""; ?>> <?= $value["name"]; ?> </option>
                                        <?php
                                        //endif;
                                    endforeach;
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="office_div"></div>

                        <div id="staff_div"></div>
                        <input type="hidden" id="staff-hidden" name="staff-hidden" value="">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client ID</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="client_id" title="Cient ID" value="<?= $data["client_id"]; ?>" readonly>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Subject<span class="spanclass text-danger">*</span></label>
                            <div class="col-sm-9 col-md-10">
                                <input placeholder="" class="form-control" value="<?php echo $data['subject']; ?>" type="text" name="subject" title="Subject" <?= $disable ?>>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Message<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="message" required name="message" title="Message" <?= $disable ?>><?= $data["message"]; ?></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?php if (!empty($data["files"][0])): ?>
                            <ul class="uploaded-file-list">
                                <?php
                                foreach ($data['files'] as $file) :
                                    $value = $file['file_name'];
                                    $file_id = $file['id'];
                                    $extension = pathinfo($value, PATHINFO_EXTENSION);
                                    $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                    $filename = explode("_", $value);
                                    if (in_array($extension, $allowed_extension)):
                                        ?>
                                        <li id="file_show_<?= $file_id; ?>">
                                            <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $value; ?>');max-width: 100%;">
                                                <a href="<?php echo base_url(); ?>uploads/<?= $value; ?>" title="<?= $value; ?>"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                            <p class="text-overflow-e" title="<?= $value; ?>"><?= $filename[2]; ?></p>
                                            <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteActionFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                        </li>
                                    <?php else: ?>
                                        <li id="file_show_<?= $file_id; ?>">
                                            <div class="preview preview-file">
                                                <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $value; ?>" title="<?= $value; ?>"><i class="fa fa-download"></i></a>

                                            </div>
                                            <p class="text-overflow-e" title="<?= $value; ?>"><?= $filename[2]; ?></p>
                                            <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteActionFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                        </li>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                            </ul>
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload File</label>
                            <div class="col-lg-10">
                                <div class="upload-file-div">
                                    <input class="m-t-5 file-upload" type="file" id="upload_file" name="upload_file[]" title="Upload File" disabled>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-upload-file" id="not-active"><i class="fa fa-plus"></i>Add File</a>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <?= note_func('Notes', 'n', 2, 'action_id', $data['id']); ?> 
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Due Date<span class="dueclass text-danger" <?= ($data["priority"] == 2) ? '' : 'style="display: none;"'; ?>>*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="mm/dd/yyyy" id="due_date" class="form-control datepicker_mdy_due" type="text" title="Due Date" name="due_date" value="<?= $data["due_date"] != '0000-00-00' ? date('m/d/Y', strtotime($data["due_date"])) : ''; ?>" <?= $disable ?> disabled>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <input type="hidden" name="id" id="id" value="<?= $data["id"]; ?>">
                        <input type="hidden" name="old_department_id" id="old_dept_id" value="<?= $data["department"]; ?>">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" id="disable_field" value="<?= ($data["added_by_user"] != sess("user_id"))? "y" : "n"; ?>">
                                <input type="hidden" id="staff_type" value="<?= $staff_info['type']; ?>">
                                <input type="hidden" id="edit_val" value="<?= $data["id"] ?>">
                                <input type="hidden" id="ismyself" class="ismyself" value="<?= $data["my_task"] ?>">
                                <button class="btn btn-success save_btn" type="button" onclick="request_edit_action()">Save Changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_edit_action(<?= $data["id"]; ?>)">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    get_action_office("<?= $data["office"]; ?>", "<?= implode(",", $data["staffs"]) ?>", "<?= $data['my_task']; ?>","");
    $(function () {
        $(".datepicker_mdy_due").datepicker({format: 'mm/dd/yyyy', autoHide: true, startDate: new Date()});
        $('.add-upload-file').on("click", function () {
            var text_file = $(this).prev('.upload-file-div').html();
            var file_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-2 control-label">' + file_label + '</label><div class="col-lg-10">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
        $("#assign_to_myself").click(function () {
            if ($(this).prop("checked") == true) {
                $("#is_chk_mytask").prop('checked', true);
                $("#department").removeAttr("required");
                $("#office").removeAttr("required");
                $(".spanclass").html('');
                $(".dept_div").hide();
                $("#office_div").hide();
                $("#staff_div").hide();
            } else {
                var dept = $("#department option:selected").val();
                if (dept == 2) {
                    $("#office_div").show();
                }
                $("#is_chk_mytask").prop('checked', false);
                $("#department").attr("required", "required");
                $("#office").attr("required", "required");
                $(".spanclass").html('*');
                $(".dept_div").show();
                $("#staff_div").show();
            }
        });
        $("#priority").change(function () {
            if ($(this).val() == 2) {
                $("#due_date").attr("required", "required");
                $(".dueclass").html('*');
            } else {
                $("#due_date").removeAttr("required");
                $(".dueclass").html('');
            }
        });
    });
    function removeFile(divID) {
        $("#" + divID).remove();
    }
    function deleteActionFile(file_id) {
        swal({
            title: "Delete!",
            text: "Are you sure to delete this file?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type: "POST",
                url: '<?= base_url(); ?>action/home/delete_action_file',
                data: {
                    file_id: file_id
                },
                cache: false,
                success: function (data) {
                    if (data == 1) {
                        swal("Deleted!", "File has been deleted.", "success");
                        $("#file_show_" + file_id).remove();
                    }
                }
            });
        });
    }
</script>

