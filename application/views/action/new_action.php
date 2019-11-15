<?php $staff_info = staff_info(); 
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="save_action">
                        <div class="row m-b-10">
                            <div class="col-sm-6">
                                <h3>Create New Action</h3>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="<?= base_url().'action/Home'; ?>" class="btn btn-primary">Back To Dashboard</a>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">My Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="created_office" id="created_office" title="Office" required="">
                                    <option value="">Select Office</option>
                                    <?php 
                                    
                                        // $searchString = ',';

                                        // if( strpos($staff_info['office'], $searchString) !== false ) {
                                        //      load_ddl_option("staff_office_list","", "staff_office");
                                        // }else{
                                        //     load_ddl_option("staff_office_list", $staff_info['office'], "staff_office");
                                        // }
                                     $searchString = ',';

                                        if( strpos($staff_info['office'], $searchString) !== false ) {
                                             load_ddl_option("users_office_list","", "");
                                        }else{
                                            load_ddl_option("users_office_list", $staff_info['office'], "");
                                        }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">My Department<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="created_department" id="created_department" title="Department" required="">
                                    <option value="">Select Department</option>
                                    <?php 
                                    
                                        $searchString = ',';

                                        if( strpos($staff_info['department'], $searchString) !== false ) {
                                            $dataArr = explode(',', $staff_info['department']);
                                            foreach ($dataArr as $value) {
                                                $data = get_department_info_by_id($value);
                                    ?>
                                    <option value="<?= $data['id']; ?>"><?= $data['name']; ?></option>    
                                    <?php
                                            }
                                        }else{
                                            $data = get_department_info_by_id($staff_info['department']);
                                    ?>
                                    <option value="<?= $data['id']; ?>" selected><?= $data['name']; ?></option>                             
                                    <?php        
                                        }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Priority<span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-10">
                                <select required class="form-control" title="Priority" name="priority" id="priority" required="">
                                    <option value="">Select an option</option>
                                    <option value="1">Urgent</option>
                                    <option value="2">Important</option>
                                    <option value="3">Regular</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Assign Myself</label>
                            <div class="col-sm-9 col-md-10 checkbox">
                                <label><input type="checkbox" id="assign_to_myself" name="assign_to_myself" title="Assign Type"></label>
                            </div>
                        </div>
                        
                        <div class="form-group dept_div">
                            <label class="col-sm-3 col-md-2 control-label">Department<span class="spanclass text-danger">*</span></label>
                            <div class="col-sm-9 col-md-10">
                                <select required class="form-control" title="Department" name="department" id="department" onchange="get_action_office();">
                                    <option value="">Select an option</option>
                                    <?php
                                    foreach ($departments as $value):
//                                        if ($value['name'] != "Franchise" || ($value['name'] == "Franchise" && $staff_info['type'] != 3)):
                                        ?>
                                        <option value="<?= $value["id"]; ?>"><?= $value["name"]; ?></option>
                                        <?php
//                                        endif;
                                    endforeach;
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="office_div"></div>

                        <div id="staff_div"></div>

                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Client ID</label>
                            <div class="col-sm-9 col-md-10">
                                <input placeholder="" class="form-control" type="text" name="client_id" title="Cient ID">
                                <!--<div class="errorMessage text-danger"></div>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Subject<span class="spanclass text-danger">*</span></label>
                            <div class="col-sm-9 col-md-10">
                                <input placeholder="" class="form-control" type="text" name="subject" title="Cient ID">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Message<span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-10">
                                <textarea class="form-control" required name="message" id="message" title="Message"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Upload File</label>
                            <div class="col-sm-9 col-md-10">
                                <div class="upload-file-div">
                                    <input class="file-upload" id="action_file" type="file" name="upload_file[]" title="Upload File">
                                    <div class="errorMessage text-danger m-t-5"></div>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i> Add File</a>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <?= note_func('Notes', 'n', 2); ?>
                        
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Due Date<span class="dueclass text-danger" style="display: none;">*</span></label>
                            <div class="col-sm-9 col-md-10">
                                <input placeholder="mm/dd/yyyy" id="due_date" class="form-control datepicker_mdy_due" type="text" title="Due Date" name="due_date">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9 col-md-offset-2 col-md-10">
                                <input type="hidden" id="disable_field" value="n">
                                <input type="hidden" id="staff_type" value="<?= $staff_info['type']; ?>">
                                <input type="hidden" id="edit_val">
                                <input type="hidden" id="ismyself" class="ismyself" value="">
                                <button class="btn btn-success save_btn" type="button" onclick="request_create_action()">Save</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_action()">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    get_action_office();
    $(function () {
        $(".datepicker_mdy_due").datepicker({format: 'mm/dd/yyyy', autoHide: true, startDate: new Date()});
        $('.add-upload-file').on("click", function () {
            var text_file = $(this).prev('.upload-file-div').html();
            var file_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-2 control-label">' + file_label + '</label><div class="col-lg-10">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
        $("#assign_to_myself").click(function(){
             if($(this).prop("checked") == true){
               $("#is_chk_mytask").prop('checked', true);
               $("#department").removeAttr("required");
               $("#office").removeAttr("required");
               $(".spanclass").html('');
               $(".dept_div").hide();
               $("#office_div").hide();
               $("#staff_div").hide();
            }else{
                var dept = $("#department option:selected").val();
                if(dept==2){
                    $("#office_div").show();
                }
               $("#is_chk_mytask").prop('checked', false);
               $("#department").attr("required","required");
               $("#office").attr("required","required");
               $(".spanclass").html('*');
               $(".dept_div").show();
               $("#staff_div").show();
            }
        });
        $("#priority").change(function(){
            if($(this).val() == 2){
                $("#due_date").attr("required","required");
                $(".dueclass").show();
                $(".dueclass").html('*');
            }else{
                $("#due_date").removeAttr("required");
                $(".dueclass").html('');
            }
        });
    });
    function removeFile(divID) {
        $("#" + divID).remove();
    }
</script>

