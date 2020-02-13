
<?php if ($modal_type == 'edit') { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Edit Project</h3>
            </div><!-- Modal Header-->
            <div class="modal-body">
                <form method="post" id="form_save_project">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group client_type_div0">
                                <label class="col-lg-6 control-label">Project Template<span class="text-danger">*</span></label>
                                <select class="form-control client_type_field0" disabled="" name="project[template_id]" id="project_template" title="Project Template" required="" onchange="get_pattern_detais(this.value)">
                                    <option value="">Select Template</option>
                                    <?php
                                    if (!empty($template_list)) {
                                        asort($template_list);
                                        foreach ($template_list as $template) {
                                            ?>
                                            <option value="<?= $template['id'] ?>" <?= $template['id'] == $project_dtls->template_id ? 'selected' : '' ?> ><?= $template['title'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <!--business or individual client-->
                        <div class="col-md-12">
                            <div class="form-group client_type_div0">
                                <label class="col-lg-6 control-label">Client Type<span class="text-danger">*</span></label>
                                <select class="form-control client_type_field0" onchange="projectContainerAjax(this.value,<?= $project_dtls->client_id ?>,<?= $project_dtls->id ?>);" name="project[client_type]" id="client_type" title="Client Type" required="" style="pointer-events:none" readonly
                                    <option value="">Select Client Type</option>
                                    <option value="1" <?= ($project_dtls->client_type==1)? 'selected':'' ?> >Business Client</option>
                                    <option value="2" <?= ($project_dtls->client_type==2)? 'selected':'' ?> >Individual</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div id="project_container">
                            <!-- Add multiple service categories inside this div using ajax -->
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <div id="template_recurrence"></div>
                        <hr class="hr-line-dashed"/>
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" type="button" onclick="request_update_project(<?= $project_dtls->id ?>)">Save</button> &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>  
            </div><!-- Modal Body-->
        </div><!-- Modal content-->
    </div>
<?php } else { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add Project</h3>
            </div><!-- Modal Header-->
            <div class="modal-body">
                <form method="post" id="form_save_project">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group client_type_div0">
                                <label class="col-lg-6 control-label">Project Template<span class="text-danger">*</span></label>
                                <select class="form-control client_type_field0" name="project[template_id]" id="project_template" title="Project Template" required="" onchange="get_pattern_detais(this.value)">
                                    <option value="">Select Template</option>
                                    <?php
                                    if (!empty($template_list)) {
                                        usort($template_list, function($a, $b) {
                                            return $a['title'] <=> $b['title'];
                                        });
                                        foreach ($template_list as $template) {
                                            ?>
                                            <option value="<?= $template['id'] ?>"><?= $template['title'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <!--business or individual client-->
                        <div class="col-md-12">
                            <div class="form-group client_type_div0">
                                <label class="col-lg-6 control-label">Client Type<span class="text-danger">*</span></label>
                                <select class="form-control client_type_field0" onchange="projectContainerAjax(this.value, '', '');" name="project[client_type]" id="client_type" title="Client Type" required="">
                                    <option value="">Select Client Type</option>
                                    <option value="1">Business Client</option>
                                    <option value="2">Individual</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div id="project_container">
                            <!-- Add multiple service categories inside this div using ajax -->
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <div id="template_recurrence"></div>
                        
                        <div class="hr-line-dashed"></div>
                        <div class="col-md-12">
                            <label class="col-lg-12 control-label">Notes:</label>
                            <div class="form-group" id="add_note_div">
                                <div class="note-textarea">
                                    <textarea class="form-control" name="project_note[]"  title="Project Note"></textarea>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                            </div>
                        </div>
                        <hr class="hr-line-dashed"/>
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" type="button" onclick="request_create_project()">Save</button> &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>  
            </div><!-- Modal Body-->
        </div><!-- Modal content-->
    </div>
<?php } ?>
<script>
<?php if ($modal_type == 'edit') { ?>
    get_pattern_detais(<?= $project_dtls->template_id ?>,<?= $project_id ?>,'edit');
    projectContainerAjax(<?= $project_dtls->client_type ?>,'<?= $project_dtls->client_id ?>',<?= $project_dtls->id ?>,<?= $office_id ?>);
//        project_client_list(<? $project_dtls->office_id ?>,<? $project_dtls->client_id ?>, 'edit');
<?php } if($modal_type=='add'){ ?>
    projectContainerAjax(1,'','');
<?php } ?>
    $(document).ready(function () {
        $(".datepicker_creation_date").datepicker({format: 'mm/dd/yyyy', autoHide: true,startDate: new Date()});
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