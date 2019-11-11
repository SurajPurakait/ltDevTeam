<?php $staff_info = staff_info(); ?>
<form method="POST" id="template-task-edit-modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Edit Task</h2>
            </div><!-- modal-header -->
            <div class="modal-body">
                <h3 class="text-success">Identification :</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Order:<span class="spanclass text-danger">*</span></label>
                            <input type="text" class="form-control" id="task_order" name="task[task_order]" value="<?= $task_details->task_order ?>" required title="Order">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Description:</label>
                            <textarea class="form-control" id="description" name="task[description]" > <?= $task_details->description ?></textarea>
                        </div>
                    </div>
                </div><!-- row -->
                <hr class="hr-line-dashed"/>
                <h3 class="text-success">Target Dates :<span class="spanclass text-danger">*</span></h3>
                <div class="row">
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label class="">For Start (days before due date)</label>
                            <input title="" class="form-control" type="number" min="1" max="31" id="target_start_date" name="task[target_start_date]" value="<?= $task_details->target_start_date ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="">For Complete (days before due date)</label>
                            <input title="" class="form-control" type="number" min="1" max="31" id="target_complete_date" name="task[target_complete_date]" value="<?= $task_details->target_complete_date ?>">
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="">For Start</label>
                            <input class="form-control" type="number" name="task[target_start_date]" value="<?= $task_details->target_start_date ?>" min="0" style="width: 100px" id="target_start_date" required>
                            <!--<label class="control-label"><input type="radio" <?php // echo ($task_details->target_start_day==1) ? 'checked' : ''; ?> name="task[target_start_day]" value="1">&nbsp; Days before due date</label>-->
                            <label class="control-label"><input type="radio" <?php echo ($task_details->target_start_day==2) ? 'checked' : ''; ?> name="task[target_start_day]" value="2" required>&nbsp; Days after creation date</label>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="">For Complete</label>
                            <input class="form-control" type="number" name="task[target_complete_date]" value="<?= $task_details->target_complete_date ?>" min="0" style="width: 100px" id="target_complete_date" required>
                            <!--<label class="control-label"><input type="radio" <?php // echo ($task_details->target_complete_day==1) ? 'checked' : ''; ?> name="task[target_complete_day]" value="1">&nbsp; Days before due date</label>-->
                            <label class="control-label"><input type="radio" <?php echo ($task_details->target_complete_day==2) ? 'checked' : ''; ?> name="task[target_complete_day]" value="2" required>&nbsp; Days after creation date</label>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                </div><!-- ./row -->
                <hr class="hr-line-dashed"/>
                <h3 class="text-success">Task Information :</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Tracking Description:</label>
                            <select class="form-control" id="description" name="task[tracking_description]">
                                <option value="0" value="<?= $task_details->tracking_description=='0'?'selected':'' ?>">Not Started</option>
                                <option value="1" value="<?= $task_details->tracking_description=='1'?'selected':'' ?>">Started</option>
                                <option value="2" value="<?= $task_details->tracking_description=='2'?'selected':'' ?>">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php // $satff_list = getTemplateStaffList($template_id);
                            ?>
                            <label class="control-label">Assigned Department:<span class="spanclass text-danger">*</span></label>
                            <select class="form-control" id="task_department" name="task[department]" title="Assign Department" onchange="get_task_department_staff()" required>
                                <option value="">Select Department</option>
                                <?php
                                foreach ($departments as $key => $value):
                                    ?>
                                    <option value="<?= $value["id"]; ?>" <?= $value["id"]==$task_details->department_id ?'selected':'' ?> ><?= $value["name"]; ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div><!-- ./col-md-6 -->
                    
                    <div id="task_office_div"></div>
                    
                    <div id="task_staff_div"></div>
                    
                </div><!-- ./row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Input Form<span class="text-danger">*</span></label>
                            <label class="checkbox-inline">
                                <input class="checkclass" value="y" type="radio" id="task_inputform1" name="task[is_input_form]" required title="Input Form" <?= ($task_details->is_input_form == 'y') ? 'checked' : ''; ?>> Yes
                            </label>
                            <label class="checkbox-inline">
                                <input class="checkclass" value="n" type="radio" id="task_inputform2" name="task[is_input_form]" required title="Input Form" <?= ($task_details->is_input_form == 'n') ? 'checked' : ''; ?>> No
                            </label>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Allow sales tax processing</label>
                        <input type="checkbox" name="task[input_form_type]" title="Allow Sales Tax" id="confirmation" value="1" <?php echo ($task_details->input_form_type == '1') ? 'checked' : ''; ?> required>
                    </div>
                </div>
                <hr class="hr-line-dashed"/>
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">Notes:</label>
                        <div class="form-group" id="add_note_div">
                            <div class="note-textarea">
                                <textarea class="form-control" name="task_note[]"  title="Task Note"></textarea>
                            </div>
                            <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                        </div>
                    </div>
                </div>
            </div><!-- ./modal-body -->
            <div class="modal-footer">
                <input type="hidden" id="task_disable_field" value="n">
                <input type="hidden" id="task_staff_type" value="<?= $staff_info['type']; ?>">
                <input type="hidden" id="main_id" name="task[template_main_id]" value="<?= $task_details->template_main_id ?>">
                <button class="btn btn-success" type="button" onclick="update_task(<?= $task_details->id ?>,<?= $task_details->template_main_id ?>)">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div><!-- modal-footer -->
        </div><!-- Modal content-->

    </div><!-- ./modal-dialog -->
</form>
<?php
$staff_id=getTaskStaffList($task_details->id);
//print_r($staff_id);
if(!empty($staff_id)){
    $staffid=$staff_id;
}else{
    $staffid='';
}
?>
<script>
    get_task_department_staff('<?= $staffid ?>','<?= $task_details->is_all ?>','<?= $task_details->responsible_task_staff?>');
    $(document).ready(function () {
//        alert('hi');
        $('.add-task-note').click(function () {
//            alert("hlw");
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger removenoteselector"><i class="fa fa-times"></i> Remove Note</a>' +
                    '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });
</script>