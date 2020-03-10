<?php $staff_info = staff_info(); ?>
<div class="wrapper wrapper-content">

    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs template-menu" role="tablist">
                            <li class="active"><a class="nav-link active" id="nav-link-1" data-toggle="tab" href="#tab-1">Main</a></li>
                            <li><a class="nav-link" id="nav-link-2" data-toggle="tab" href="#tab-2">Task</a></li>
                            <!--                            <li><a class="nav-link" data-toggle="tab" href="#tab-3">Custom Fields</a></li>-->
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form method="post" id="save_template_main">
                                        <h3>Identification :</h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Template Category:<span class="spanclass text-danger">*</span></label>
                                                    <select class="form-control" id="template_category" name="template_main[template_cat_id]" title="Template Category" required>
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        if (!empty($template_category)) {
                                                            foreach ($template_category as $category) {
                                                                ?>
                                                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Id:<span class="spanclass text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="Id" title="Id" name="template_main[Id]" required>
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div><!-- col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Project Name:<span class="spanclass text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="title" name="template_main[title]" title="Title" required>
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div><!-- col-md-6 -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Description:</label>
                                                    <textarea class="form-control" id="description" name="template_main[description]" title="description"></textarea>
                                                </div>
                                            </div><!-- col-md-6 -->

                                        </div><!-- row --> 
                                        <hr class="hr-line-dashed"/>
                                        <h3>Project Information :</h3>
                                        <!--id 20 for others service category-->
                                        <?php
                                        if (!empty($service_category)) {
                                            array_push($service_category, array('id' => 20, 'name' => 'Miscellaneous'));
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Service Category:<span class="spanclass text-danger">*</span></label>
                                                    <select class="form-control" id="service_category" name="template_main[service_category]" onchange="getServiceList(this.value);" title="Service Category" required>
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        if (!empty($service_category)) {
                                                            foreach ($service_category as $service_arr) {
                                                                ?>
                                                                <option value="<?= $service_arr['id'] ?>"><?= $service_arr['name'] ?></option>>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div><!-- ./col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="form-group" id="template_service_id">
                                                    <label class="control-label">Service:<span class="spanclass text-danger">*</span></label>
                                                    <select class="form-control" name="template_main[service]" id="service" title="Service" required>
                                                        <option value="">Select Service</option>                                                        
                                                    </select>
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div><!-- ./col-md-6 -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Tracking:<span class="spanclass text-danger">*</span></label>
                                                    <select class="form-control" name="template_main[status]" id="tracking" title="Tracking">
                                                        <option value="0">Not Started</option>
                                                        <option value="1">Started</option>
                                                        <option value="2">Completed</option>
                                                    </select>
                                                </div>
                                            </div><!-- ./col-md-6 -->

                                        </div><!-- ./row --> 
                                        <hr class="hr-line-dashed"/>
                                        <h3>Responsible</h3>
                                        <div class="row">
                                            <div class="form-group dept_div" style="display: inline-block;width: 100%;">
                                                <label class="col-sm-3 col-md-2 control-label text-right">Responsible Department<span class="spanclass text-danger">*</span></label>
                                                <div class="col-sm-9 col-md-10">
                                                    <select required class="form-control" title="Responsible User" name="template_main[office]" id="user_type" onchange="get_template_responsible_staff('', '');" required>
                                                        <option value="">Select an option</option>
                                                        <?php
                                                        foreach ($staff_type as $key => $value):
                                                            ?>
                                                            <option value="<?= $value["id"]; ?>"><?= $value["name"]; ?></option>
                                                            <?php
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div>
                                            <div id="responsible_francise_div" class="clearfix"></div>

                                            <div id="responsible_staff_div"></div>
                                        </div>

                                        <hr class="hr-line-dashed"/>
                                        <h3>Assigned :</h3>
                                        <?php
//                                        foreach ($departments as $key => $value) {
//                                            if ($value['id'] == '2') {
//                                                unset($departments[$key]);
//                                            }
//                                        }
                                        ?>
                                        <div class="row">

                                            <div class="form-group dept_div" style="display: inline-block;width: 100%;">
                                                <label class="col-sm-3 col-md-2 control-label text-right">Department<span class="spanclass text-danger">*</span></label> 
                                                <div class="col-sm-9 col-md-10">
                                                    <!--get_template_department_staff-->
                                                    <select required class="form-control" title="Department" name="template_main[department]" id="department" onchange="get_template_office_new();" required>
                                                        <option value="">Select an option</option>
                                                        <?php
                                                        foreach ($departments as $key => $value):
                                                            ?>
                                                            <option value="<?= $value["id"]; ?>"><?= $value["name"]; ?></option>
                                                            <?php
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div>
                                            <div id="dept_staff_div"></div>

                                            <div id="staff_div" class="form-group" style="display: none;width: 100%;">
                                                <label class="col-md-2 control-label text-right">Assign Type<span class="text-danger">*</span></label>
                                                <div class="col-md-10">

                                                </div>
                                            </div>
                                            <div id="staff_list" class="form-group" style="display: none;width: 100%;">
                                                <label class="col-sm-3 col-md-2 control-label text-right">Staff<span class="spanclass text-danger">*</span></label>
                                                <div class="col-sm-9 col-md-10">

                                                </div>
                                            </div>

                                        </div>
                                        <hr class="hr-line-dashed"/>
                                        <h3>Generation:</h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#RecurranceModal" title="Add Recurrence"><i class="fa fa-refresh"></i></button> &nbsp;<b id="pattern_show"></b>

                                                </h4>
                                                <div class="errorMessage text-danger" id="err_generation"></div>
                                            </div><!-- ./col-md-12 -->
                                            <!-- <div id="RecurranceModalContainer" style="display: none;"></div> -->
                                            <!-- Recurrence Modal -->
                                            <div id="RecurranceModal" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h2 class="modal-title">Recurrence</h2>
                                                        </div><!-- modal-header -->
                                                        <div class="modal-body">
                                                            <h3 class="m-0 p-b-20">Frequency:</h3>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Pattern:</label>
                                                                        <select class="form-control" id="pattern" name="recurrence[pattern]" onchange="change_due_pattern(this.value);">
                                                                            <option value="">Select Pattern</option>
                                                                            <option value="monthly">Monthly</option>
                                                                            <option value="weekly">Weekly</option>
                                                                            <option value="quarterly">Quarterly</option>
                                                                            <option value="annually">Annually</option>
                                                                            <option value="periodic">Periodic</option>
                                                                            <option value="none">None</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">    
                                                                    <div class="form-group m-t-25" id="weekend_val">
                                                                        <label class="control-label"><input type="checkbox" name="recurrence[occur_weekdays]" id="occur_weekdays"> Must occur on weekdays</label>
                                                                    </div>
                                                                    <div class="annual-check-div" style="display: none;">
                                                                        <div class="form-group">
                                                                            <label class="control-label"><input type="checkbox" name="recurrence[client_fiscal_year_end]" onclick="get_fiscal_year_options()" id="client_fiscal_year_end"> Based on Client fiscal year ends</label>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- ./col-md-6 -->
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="form-inline due-div">
                                                                            <label class="control-label m-r-5"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due on day</label>&nbsp;
                                                                            <input class="form-control m-r-5" type="number" name="recurrence[due_day]" value="1" min="1" max="31" style="width: 100px" id="r_day">
                                                                            <label class="control-label m-r-5">of every</label>&nbsp;
                                                                            <input class="form-control m-r-5" type="number" name="recurrence[due_month]" value="1" min="1" max="12" style="width: 100px" id="r_month">&nbsp;
                                                                            <label class="control-label m-r-5" id="control-label">month(s)</label>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                            </div><!-- ./row -->
                                                            <hr class="hr-line-dashed"/>                                                   
                                                            <h3 class="m-0 p-b-20">Target Dates:</h3>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-md-6 p-r-0">
                                                                                <label class="">For Start</label>
                                                                                <input class="form-control" type="number" id="t_start_month" name="recurrence[target_start_months]" min="0" max="12" value="1" style="width: 100px">
                                                                                <label class="control-label">month(s)</label>
                                                                            </div>
                                                                            <div class="col-md-6 p-l-0">
                                                                                <label class="">&nbsp;</label>
                                                                                <input class="form-control" type="number" name="recurrence[target_start_days]" value="1" min="1" style="width: 100px" id="t_start_day">
                                                                                <label class="control-label">day(s)</label>
                                                                            </div>
                                                                            <div class="col-md-12 m-t-10">
                                                                                <label class="control-label"><input style="vertical-align: text-bottom;" type="radio" name="recurrence[target_start_day]" value="1" checked="">&nbsp; Before due date</label>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-md-6 p-r-0">
                                                                                <label class="">For Complete</label>
                                                                                <input class="form-control" type="number" id="t_end_month" name="recurrence[target_end_months]" min="0" max="12" value="1" style="width: 100px">
                                                                                <label class="control-label">month(s)</label>
                                                                            </div>
                                                                            <div class="col-md-6 p-l-0">
                                                                                <label class="">&nbsp;</label>   
                                                                                <input class="form-control" type="number" name="recurrence[target_end_days]" value="1" min="1" style="width: 100px" id="t_end_day">
                                                                                <label class="control-label">day(s)</label>
                                                                            </div>
                                                                            <div class="col-md-12 m-t-10">
                                                                                <label class="control-label"><input style="vertical-align: text-bottom;" type="radio" name="recurrence[target_end_day]" value="1" checked="">&nbsp; Before due date</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- ./row -->
                                                            <div class="none-div">
                                                                <hr class="hr-line-dashed"/>
                                                                <h3 class="m-0 p-b-20">Expiration:</h3>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="form-inline">
                                                                                <label class="control-label"><input type="radio" name="recurrence[expiration_type]" checked="" value="0"> No end date</label>&nbsp;
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="form-inline">
                                                                                <label class="control-label"><input type="radio" name="recurrence[expiration_type]" value="1"> End after</label>&nbsp;
                                                                                <input class="form-control" type="number" id="end_occurrence" name="recurrence[end_occurrence]" min="1" max="31" style="width: 100px">
                                                                                <label class="control-label">Occurrences</label>
                                                                            </div>
                                                                        </div> 
                                                                    </div>

                                                                </div><!--./row -->
                                                                <hr class="hr-line-dashed"/>
                                                                <h3 class="m-0 p-b-20">Generation:</h3>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="control-label"><input type="radio" disabled name="recurrence[generation_type]" value="0" onclick="//check_generation_type(this.value)">&nbsp; When previous project is Complete</label>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-inline">
                                                                            <label class="control-label"><input type="radio" name="recurrence[generation_type]" value="1" onclick="//check_generation_type(this.value)"></label>&nbsp;
                                                                            <input class="form-control" type="number" id="generation_month" name="recurrence[generation_month]" min="0" max="12" value="1" style="width: 100px">&nbsp;
                                                                            <label class="control-label">month(s)</label>&nbsp;
                                                                            <input class="form-control" type="number" id="generation_day" name="recurrence[generation_day]" min="1" max="31" value="1" style="width: 100px">&nbsp;
                                                                            <label class="control-label">Day(s) before next occurrence due date</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="control-label"><input type="radio" name="recurrence[generation_type]" value="2" checked="" onclick="//check_generation_type(this.value)">&nbsp; None</label>
                                                                    </div>

                                                                </div> <!-- ./row -->
                                                            </div>
                                                        </div><!-- ./modal-body -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" onclick="closeRecurrenceModal();">Save</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        </div><!-- modal-footer -->
                                                    </div><!-- Modal content-->

                                                </div><!-- ./modal-dialog -->
                                            </div><!-- ./Recurrence Modal -->
                                        </div>
                                        <input type="hidden" id="disable_field" value="n">
                                        <input type="hidden" id="staff_type" value="<?= $staff_info['type']; ?>">
                                        <hr class="hr-line-dashed"/>
                                        <div class="col-md-12 text-right">
                                            <input type="hidden" id="tmplt_id" value="3">
                                            <button type="button" class="btn btn-primary" onclick="request_create_template();">Save</button>
                                        </div>
                                    </form> 
                                </div>
                            </div><!-- #tab-1 -->

                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="clearfix">
                                        <button type="button" class="btn btn-primary pull-right m-b-20" id="task_btn" onclick="get_template_task_modal(this.value);" disabled><i class="fa fa-plus"></i> &nbsp;Create Task</button>
                                        <!--<button type="button" class="btn btn-primary pull-right m-b-20" onclick="back_to_dashboard();"><i class="fa fa-backward"></i> &nbsp;Back To Dashboard &nbsp;</button>-->
                                    </div>

                                    <div id="task_list">

                                        <?php
                                        if (!empty($task_list)) {
                                            foreach ($task_list as $key => $value) {
                                                if (strlen($value['description']) > 20) {
                                                    $description = substr($value['description'], 0, 20) . '...';
                                                } else {
                                                    $description = $value['description'];
                                                }
                                                ?>
                                                <div class="panel panel-default service-panel type2 filter-active" id="action<?= $value['id'] ?>">
                                                    <div class="panel-heading">
                                                        <a href="javascript:void(0);" onclick="get_template_task_modal(<?= $value['id'] ?>);" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                                        <a href="javascript:void(0);" onclick="tetmplate_task_edit_modal(<?= $value['id'] ?>);" class="btn btn-danger btn-xs btn-service-edit btn-prj-template-delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
                                                        <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value['id'] ?>" aria-expanded="false">
                                                            <div class="table-responsive">
                                                                <table class="table table-borderless text-center" style="margin-bottom: 0px;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th style="width:8%; text-align: center">Task Id</th>
                                                                            <th style="width:8%; text-align: center">Title</th>
                                                                            <th style="width:8%; text-align: center">Assigned To</th>
                                                                            <th style="width:8%; text-align: center">Notes</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td title="ID"><?= $value['task_order'] ?></td>
                                                                            <td title="Title"><?= $value['task_title'] ?></td>
                                                                            <!--<td title="Assign To"><span></span></td>-->
                                                                            <td title="Assign To"><span class="text-success"><?php echo get_assigned_task_staff($value['id']); ?></span><br><?php echo get_assigned_task_department($value['id']); ?></td>                                                    

                                                                            <td title="Notes"><?= get_task_note_count($value['id']) ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </h5>
                                                    </div>
                                                    <div id="collapse<?= $value['id'] ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                        <div class="panel-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-borderless">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th style="width:8%; text-align: center">Description</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td title="Description" align="center"><span><?= $value['description'] ?></span>
                                                                                <!--<a href="javascript:void(0);" data-toggle="popover" data-placement="top" data-content="test description" data-trigger="hover" title="" data-original-title=""><?php //echo $value['description']      ?></a>-->
                                                                            </td>

                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <div class = "text-center m-t-30">
                                                <div class = "alert alert-danger">
                                                    <i class = "fa fa-times-circle-o fa-4x"></i>
                                                    <h3><strong>Sorry!</strong> no data found</h3>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div><!-- ./panel-body -->
                                <!--<button class="btn btn-danger pull-right" type="button" onclick="go('administration/template');">Back to dashboard</button>-->
                            </div><!-- #tab-2 -->

                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Field Name:</label>
                                                <input placeholder="" id="" class="form-control" type="text" name="" title="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Description</label>
                                                <input placeholder="" id="" class="form-control" type="text" name="" title="">
                                            </div>
                                            <div class="col-md-12 text-right p-t-20 p-b-20">
                                                <a class="btn btn-success" id="" href="javascript:void(0);"><i class="fa fa-plus"></i> Add More</a>
                                            </div>
                                            <hr class="hr-line-dashed"/>
                                            <div class="col-md-12 text-right p-t-20 p-b-20">
                                                <button type="button" class="btn btn-primary">save</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div><!-- #tab-3 -->
                        </div><!-- ./tab-content -->
                    </div><!-- ./tabs-container -->
                </div><!-- ./col-md-12 -->
            </div><!-- ./row -->
        </div><!-- ./ibox-content -->
    </div><!-- ./ibox -->

    <!-- Task Modal -->

    <div id="taskModal" class="modal fade" role="dialog">
    </div><!-- ./Recurrence Modal -->


</div>

<script>
//get_template_office();
    $(document).ready(function () {
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });
    });


</script>


