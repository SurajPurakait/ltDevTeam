<?php // print_r($related_service_files);die;     ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="project_input_form" onsubmit="saveInputForms(); return false;">
                        <h2>Input Forms</h2>
                        <div class="hr-line-dashed"></div>
                        <?php if (!empty($related_service_files)): ?>
                            <ul class="uploaded-file-list">
                                <?php
                                foreach ($related_service_files as $file) :
                                    $file_name = $file['file_name'];
                                    $file_id = $file['id'];
                                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                                    $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                    if (in_array($extension, $allowed_extension)):
                                        ?>
                                        <li id="file_show_<?= $file_id; ?>">
                                            <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $file_name; ?>');max-width: 100%;">
                                                <a href="<?php echo base_url(); ?>uploads/<?= $file_name; ?>" title="<?= $file_name; ?>"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                            <p class="text-overflow-e" title="<?= $file_name; ?>"><?= $file_name; ?></p>
                                            <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                        </li>
                                    <?php else: ?>
                                        <li id="file_show_<?= $file_id; ?>">
                                            <div class="preview preview-file">
                                                <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $file_name; ?>" title="<?= $file_name; ?>"><i class="fa fa-download"></i></a>
                                            </div>
                                            <p class="text-overflow-e" title="<?= $file_name; ?>"><?= $file_name; ?></p>
                                            <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                        </li>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                            </ul>
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Attachment:</label>
                            <div class="col-sm-9 col-md-10">
                                <div class="upload-file-div">
                                    <input class="file-upload" id="action_file" type="file" name="project_attachment[]" title="Upload File">
                                    <div class="errorMessage text-danger m-t-5"></div>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i> Add File</a>
                            </div>
                        </div>
                        <?php
                        if (isset($notes_data)) {
                            foreach ($notes_data as $index => $nl) {
                                $rand = rand(000, 999);
                                if ($nl['user_id'] != $this->session->userdata('user_id')) {
                                    ?>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label"><?= $index == 0 ? $note_title : ""; ?></label>
                                        <div class="col-lg-10">
                                            <div title="<?= $note_title ?>"><?= $nl['note']; ?></div>
                                            <div>By: <?= $nl['staff_name']; ?></div>
                                            <div>Department: <?= staff_department_name($nl['user_id']); ?></div>
                                            <div>Time: <?= $nl['time']; ?></div>                                            
                                        </div>
                                    </div>
                                    <textarea style="display:none;" <?= $required == 'y' ? "required='required'" : ""; ?> class="form-control" name="edit_task_note[]"  title="<?= $note_title ?>"><?= $nl['note']; ?></textarea>
                                <?php } else { ?>
                                    <div class="form-group" id="<?= $table . '_div_' . $index . $rand; ?>">
                                        <label class="col-lg-2 control-label"><?= $index == 0 ? $note_title : ""; ?></label>
                                        <div class="col-lg-10">
                                            <div class="note-textarea">
                                                <textarea <?= $required == 'y' ? "required='required'" : ""; ?> class="form-control" name="edit_task_note[]"  title="<?= $note_title ?>"><?= $nl['note']; ?></textarea>
                                            </div>
                                            <div class="pull-right"><b>By: <?= $nl['staff_name']; ?> | Department: <?= staff_department_name($nl['user_id']); ?> | Time: <?= $nl['time']; ?></b></div>
                                            <?php if ($multiple == 'y') { ?><a href="javascript:void(0);" onclick="deleteTaskNote('<?= $table . '_div_' . $index . $rand; ?>', '<?= $nl['note_id']; ?>', '<?= $related_table_id; ?>');" class="text-danger"><i class="fa fa-times"></i> Remove Note</a><?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                            ?>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Notes:</label>
                            <div class="col-sm-9 col-md-10" id="add_note_div">
                                <div class="note-textarea">
                                    <textarea class="form-control" name="task_note[]"  title="Task Note"></textarea>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="task_id" id="service_request_id" value="<?= $task_id; ?>">
                                <button class="btn btn-success" type="button" onclick="saveInputForms()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="go('project')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.add-upload-file').on("click", function () {
            var text_file = $(this).prev('.upload-file-div').html();
            var file_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-2 control-label"></label><div class="col-lg-10">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
        $('.add-task-note').click(function () {
//            alert("hlw");
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group">' + '<label class="col-sm-3 col-md-2 control-label"></label>' + '<div class="col-sm-9 col-md-10" id="note_div' + div_count + '"> ' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger removenoteselector"><i class="fa fa-times"></i> Remove Note</a>' +
                    '</div>' + '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });
    function removeFile(divID) {
        $("#" + divID).remove();
    }
    function deleteFile(file_id) {
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
                type: "GET",
                url: '<?= base_url(); ?>task/delete_project_input_form_file/' + file_id,
                success: function (data) {
                    if (parseInt(data.trim()) === 1) {
                        swal("Deleted!", "File has been deleted.", "success");
                        $("#file_show_" + file_id).remove();
                    }
                }
            });
        });
    }
</script>