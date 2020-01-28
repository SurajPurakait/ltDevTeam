<?php $staff_info = staff_info(); ?>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="tabs-container">
                        <table class="table table-bordered">
                            <?php
                            $project_data = get_project_office_client($project_id);
                            ?>
                            <tr>
                                <td style="width: 150px;"><b>Project ID: </b></td>
                                <td><?= $project_id ?></td>
                            </tr>
                            <tr>
                                <td style="width: 150px;"><b>Client ID: </b></td>
                                <td><?= getProjectClientPracticeId($project_data->client_id, $project_data->client_type); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 150px;"><b>Office ID: </b></td>
                                <td><?= get_project_office_name($project_data->office_id); ?></td>
                            </tr>

                        </table>
                        <ul class="nav nav-tabs template-menu" role="tablist">
                            <li class="active"><a class="nav-link active" id="nav-link-1" data-toggle="tab" href="#tab-1">Main</a></li>
                            <li><a class="nav-link" id="nav-link-2" data-toggle="tab" href="#tab-2">Task</a></li>
                            <!--                            <li><a class="nav-link" data-toggle="tab" href="#tab-3">Custom Fields</a></li>-->
                        </ul>
                        <div class="tab-content p-0">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form method="post" id="update_project_main">
                                        <h3>Identification :</h3>
                                        <div class="row">
                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Id:<span class="spanclass text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="Id" title="Id" name="template_main[template_id]" required value="<?= $template_details->template_id ?>">
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div> --><!-- col-md-6 -->
                                            <input type="hidden" class="form-control" id="Id" title="Id" name="template_main[template_id]" required value="<?= $template_details->template_id ?>">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Project Name:<span class="spanclass text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="title" name="template_main[title]" title="Title" required value="<?= $template_details->title ?>">
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div><!-- col-md-6 -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Description:</label>
                                                    <textarea class="form-control" id="description" name="template_main[description]" title="description"><?= $template_details->description ?></textarea>
                                                </div>
                                            </div><!-- col-md-6 -->

                                        </div><!-- row --> 
                                        <hr class="hr-line-dashed"/>
                                        <h3>Project Information :</h3>
                                        <?php
                                        if (!empty($service_category)) {
                                            array_push($service_category, array('id' => 20, 'name' => 'Miscellaneous'));
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Service Category:<span class="spanclass text-danger">*</span></label>
                                                    <select class="form-control" id="service_category" name="template_main[service_category]" onchange="getServiceList('', '');" title="Service Category" required>
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        if (!empty($service_category)) {
                                                            foreach ($service_category as $service_arr) {
                                                                ?>
                                                                <option value="<?= $service_arr['id'] ?>" <?= ($service_arr['id'] == $template_details->category_id) ? 'selected' : '' ?> ><?= $service_arr['name'] ?></option>>
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
                                                        <option value="0" <?= ($template_details->status == 0) ? 'selected' : '' ?>>Not Started</option>
                                                        <option value="1" <?= ($template_details->status == 1) ? 'selected' : '' ?>>Started</option>
                                                        <option value="2" <?= ($template_details->status == 2) ? 'selected' : '' ?>>Completed</option>
                                                    </select>
                                                </div>
                                            </div><!-- ./col-md-6 -->

                                        </div><!-- ./row --> 
                                        <hr class="hr-line-dashed"/>
                                        <h3>Responsible</h3>
                                        <div class="row">
                                            <div class="form-group dept_div" style="display: inline-block;width: 100%;">
                                                <label class="col-sm-3 col-md-2 control-label text-right">Responsible User<span class="spanclass text-danger">*</span></label>
                                                <div class="col-sm-9 col-md-10">
                                                    <select required class="form-control" title="Responsible User" name="template_main[office]" id="user_type" onchange="get_template_responsible_staff();" required>
                                                        <option value="">Select an option</option>
                                                        <?php
                                                        foreach ($staff_type as $key => $value):
                                                            ?>
                                                            <option value="<?= $value["id"]; ?>" <?= $value['id'] == $template_details->office_id ? 'selected' : '' ?>><?= $value["name"]; ?></option>
                                                            <?php
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div>
                                            <div id="responsible_francise_div"></div>

                                            <div id="responsible_staff_div"></div>
                                        </div>
                                        <!--                                        <div class="row">
                                                                                    <div class="form-group dept_div" style="display: inline-block;width: 100%;">
                                                                                        <label class="col-sm-3 col-md-2 control-label text-right">Office<span class="spanclass text-danger">*</span></label>
                                                                                        <div class="col-sm-9 col-md-10">
                                                                                            <select required class="form-control" title="Office" name="template_main[office]" id="office" onchange="get_template_office_staff();" required>
                                        <?php
//                                                        foreach ($office_list as $key => $value):
                                        ?>
                                                                                                    <option value="<? //$value["id"]; ?>" <? //$value["id"]==$template_details->office_id?'selected':'' ?> ><? //$value["name"]; ?></option>
                                        <?php
//                                                        endforeach;
                                        ?>
                                                                                            </select>
                                                                                            <div class="errorMessage text-danger"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="ofic_staff_div"></div>
                                                                                </div>-->
                                        <hr class="hr-line-dashed"/>
                                        <h3>Assigned:</h3>
                                        <?php
                                        foreach ($departments as $key => $value) {
                                            if ($value['id'] == '2') {
                                                unset($departments[$key]);
                                            }
                                        }
                                        ?>
                                        <div class="row">

                                            <div class="form-group dept_div" style="display: inline-block;width: 100%;">
                                                <label class="col-sm-3 col-md-2 control-label text-right">Department<span class="spanclass text-danger">*</span></label> 
                                                <div class="col-sm-9 col-md-10">
                                                    <!--get_template_department_staff-->
                                                    <select required class="form-control" title="Department" name="template_main[department]" id="department" onchange="get_template_office_new();" required>
                                                        <?php
                                                        foreach ($departments as $key => $value):
                                                            ?>
                                                            <option value="<?= $value["id"]; ?>" <?= ($value["id"] == $template_details->department_id) ? 'selected' : '' ?>><?= $value["name"]; ?></option>
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
                                        <?php
                                        $pattern_details = get_project_pattern_details($project_id);
                                        $periodic_pattern = get_project_main_periodic_data($project_id);
                                        ?>
                                        <h3>Generation:</h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#RecurranceModal" title="Add Recurrence"><i class="fa fa-refresh"></i></button> &nbsp;<b id="pattern_show"><?php echo ucfirst($pattern_details->pattern); ?></b>

                                                </h4>
                                            </div><!-- ./col-md-12 -->
                                            <div id="RecurranceModalContainer" style="display: none;"></div>

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
                                                                        <select class="form-control" id="pattern" name="recurrence[pattern]" onchange="change_due_pattern(this.value);" style="pointer-events:none" readonly>
                                                                            <option value="monthly" <?php echo ($pattern_details->pattern == 'monthly') ? 'selected' : ''; ?>>Monthly</option>     
                                                                            <option value="weekly" <?php echo ($pattern_details->pattern == 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                                                                            <option value="quarterly" <?php echo ($pattern_details->pattern == 'quarterly') ? 'selected' : ''; ?>>Quarterly</option>
                                                                            <option value="annually" <?php echo ($pattern_details->pattern == 'annually') ? 'selected' : ''; ?>>Annually</option>
                                                                            <option value="periodic" <?php echo ($pattern_details->pattern == 'periodic') ? 'selected' : ''; ?>>Periodic</option>
                                                                            <option value="none" <?php echo ($pattern_details->pattern == 'none') ? 'selected' : ''; ?>>None</option>
                                                                        </select>
                                                                    </div>
<?php if ($pattern_details->pattern != 'periodic') { ?>
                                                                        <div class="form-group">
                                                                            <label class="control-label"><input type="checkbox" name="recurrence[occur_weekdays]" id="occur_weekdays" <?php echo ($pattern_details->occur_weekdays == '0') ? '' : 'checked'; ?>> Must occur on weekdays</label>
                                                                        </div>
<?php } ?>
                                                                    <div class="annual-check-div" <?php echo ($pattern_details->pattern == 'annually') ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                                                                        <div class="form-group">
                                                                            <label class="control-label"><input type="checkbox" <?php echo ($pattern_details->client_fiscal_year_end == '0') ? '' : 'checked'; ?> name="recurrence[client_fiscal_year_end]" id="client_fiscal_year_end"> Based on Client fiscal year ends</label>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- ./col-md-12 -->
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="form-inline due-div">
                                                                            <?php
                                                                            if ($pattern_details->pattern == 'annually') {
                                                                                if ($pattern_details->client_fiscal_year_end == '0') {
                                                                                    ?>
                                                                                    <label class="control-label">
                                                                                        <input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due on every</label>&nbsp;<select class="form-control" id="r_month" name="recurrence[due_month]">
                                                                                        <option value="1" <?php echo ($pattern_details->due_month == '1') ? 'selected' : ''; ?>>January</option>
                                                                                        <option value="2" <?php echo ($pattern_details->due_month == '2') ? 'selected' : ''; ?>>February</option>
                                                                                        <option value="3" <?php echo ($pattern_details->due_month == '3') ? 'selected' : ''; ?>>March</option>
                                                                                        <option value="4" <?php echo ($pattern_details->due_month == '4') ? 'selected' : ''; ?>>April</option>
                                                                                        <option value="5" <?php echo ($pattern_details->due_month == '5') ? 'selected' : ''; ?>>May</option>
                                                                                        <option value="6" <?php echo ($pattern_details->due_month == '6') ? 'selected' : ''; ?>>June</option>
                                                                                        <option value="7" <?php echo ($pattern_details->due_month == '7') ? 'selected' : ''; ?>>July</option>
                                                                                        <option value="8" <?php echo ($pattern_details->due_month == '8') ? 'selected' : ''; ?>>August</option>
                                                                                        <option value="9" <?php echo ($pattern_details->due_month == '9') ? 'selected' : ''; ?>>September</option>
                                                                                        <option value="10" <?php echo ($pattern_details->due_month == '10') ? 'selected' : ''; ?>>October</option>
                                                                                        <option value="11" <?php echo ($pattern_details->due_month == '11') ? 'selected' : ''; ?>>November</option>
                                                                                        <option value="12" <?php echo ($pattern_details->due_month == '12') ? 'selected' : ''; ?>>December</option>
                                                                                    </select>&nbsp;
                                                                                    <input class="form-control" type="number" name="recurrence[due_day]" min="1" value="<?php echo $pattern_details->due_day; ?>" max="31" style="width: 100px" id="r_day">


    <?php } else { ?>
                                                                                    <label class="control-label m-r-5">
                                                                                        <input type="radio" name="recurrence[due_fiscal]" <?php echo ($pattern_details->fye_type == '1') ? 'checked' : ''; ?> value="1"> Due on every</label>&nbsp;
                                                                                    <select class="form-control" name="recurrence[due_fiscal_month]">
                                                                                        <option <?php echo ($pattern_details->fye_month == '1') ? 'selected' : ''; ?> value="1">First</option>
                                                                                        <option <?php echo ($pattern_details->fye_month == '2') ? 'selected' : ''; ?> value="2">Second</option>
                                                                                        <option <?php echo ($pattern_details->fye_month == '3') ? 'selected' : ''; ?> value="3">Third</option>
                                                                                        <option <?php echo ($pattern_details->fye_month == '4') ? 'selected' : ''; ?> value="4">Fourth</option>
                                                                                    </select>&nbsp;
                                                                                    <label class="control-label m-r-5">month after FYE on day</label>&nbsp;
                                                                                    <input class="form-control m-r-5" value="1" type="number" name="recurrence[due_fiscal_day]" min="1" max="30" style="width: 100px">&nbsp;
                                                                                    <!-- <label class="control-label m-r-5">
                                                                                        <input type="radio" name="recurrence[due_fiscal]" <?php //echo ($pattern_details->fye_type=='2') ? 'checked' : '';  ?> value="2"> Due on the</label>&nbsp;
                                                                                        <select class="form-control" name="recurrence[due_fiscal_day]">
                                                                                            <option value="1" <?php //echo ($pattern_details->fye_day=='1') ? 'selected' : '';  ?>>First</option>
                                                                                            <option value="2" <?php //echo ($pattern_details->fye_day=='2') ? 'selected' : '';  ?>>Last</option>
                                                                                        </select>&nbsp;
                                                                                        <select class="form-control" name="recurrence[due_fiscal_wday]">
                                                                                            <option value="1" <?php //echo ($pattern_details->fye_is_weekday=='1') ? 'selected' : '';  ?>>Weekday</option>
                                                                                            <option value="2" <?php //echo ($pattern_details->fye_is_weekday=='2') ? 'selected' : '';  ?>>Weekend</option>
                                                                                        </select>
                                                                                        <label class="control-label m-r-5">of</label>&nbsp;
                                                                                        <select class="form-control" name="recurrence[due_fiscal_month]">
                                                                                            <option <?php //echo ($pattern_details->fye_month=='1') ? 'selected' : '';  ?> value="1">First</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='2') ? 'selected' : '';  ?> value="2">Second</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='3') ? 'selected' : '';  ?> value="3">Third</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='4') ? 'selected' : '';  ?> value="4">Fourth</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='5') ? 'selected' : '';  ?> value="5">Fifth</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='6') ? 'selected' : '';  ?> value="6">Sixth</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='7') ? 'selected' : '';  ?> value="7">Seventh</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='8') ? 'selected' : '';  ?> value="8">Eighth</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='9') ? 'selected' : '';  ?> value="9">Ninth</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='10') ? 'selected' : '';  ?> value="10">Tenth</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='11') ? 'selected' : '';  ?> value="11">Eleventh</option>
                                                                                            <option <?php //echo ($pattern_details->fye_month=='12') ? 'selected' : ''; ?> value="12">Twelfth</option>
                                                                                        </select>&nbsp;month after FYE -->
                                                                                    <?php
                                                                                }
                                                                            } elseif ($pattern_details->pattern == 'none') {
                                                                                ?>
                                                                                <label class="control-label">
                                                                                    <input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due on every</label>&nbsp;<select class="form-control" id="r_month" name="recurrence[due_month]">
                                                                                    <option value="1" <?php echo ($pattern_details->due_month == '1') ? 'selected' : ''; ?>>January</option>
                                                                                    <option value="2" <?php echo ($pattern_details->due_month == '2') ? 'selected' : ''; ?>>February</option>
                                                                                    <option value="3" <?php echo ($pattern_details->due_month == '3') ? 'selected' : ''; ?>>March</option>
                                                                                    <option value="4" <?php echo ($pattern_details->due_month == '4') ? 'selected' : ''; ?>>April</option>
                                                                                    <option value="5" <?php echo ($pattern_details->due_month == '5') ? 'selected' : ''; ?>>May</option>
                                                                                    <option value="6" <?php echo ($pattern_details->due_month == '6') ? 'selected' : ''; ?>>June</option>
                                                                                    <option value="7" <?php echo ($pattern_details->due_month == '7') ? 'selected' : ''; ?>>July</option>
                                                                                    <option value="8" <?php echo ($pattern_details->due_month == '8') ? 'selected' : ''; ?>>August</option>
                                                                                    <option value="9" <?php echo ($pattern_details->due_month == '9') ? 'selected' : ''; ?>>September</option>
                                                                                    <option value="10" <?php echo ($pattern_details->due_month == '10') ? 'selected' : ''; ?>>October</option>
                                                                                    <option value="11" <?php echo ($pattern_details->due_month == '11') ? 'selected' : ''; ?>>November</option>
                                                                                    <option value="12" <?php echo ($pattern_details->due_month == '12') ? 'selected' : ''; ?>>December</option>
                                                                                </select>&nbsp;
                                                                                <input class="form-control" type="number" name="recurrence[due_day]" min="1" value="<?php echo $pattern_details->due_day; ?>" max="31" style="width: 100px" id="r_day">
                                                                                }
<?php } elseif ($pattern_details->pattern == 'weekly') { ?>
                                                                                <label class="control-label"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due every</label>&nbsp;
                                                                                <input class="form-control" value="<?php echo $pattern_details->due_day; ?>" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day">&nbsp;week(s) on the following days:&nbsp;
                                                                                <div class="m-t-10">
                                                                                    <div class="m-b-10">
                                                                                        <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="1" <?php echo ($pattern_details->due_month == '1') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Sunday&nbsp;</span>
                                                                                        <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="2" <?php echo ($pattern_details->due_month == '2') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Monday&nbsp;</span>
                                                                                        <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="3" <?php echo ($pattern_details->due_month == '3') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Tuesday&nbsp;</span>
                                                                                        <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="4" <?php echo ($pattern_details->due_month == '4') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Wednesday&nbsp;</span>
                                                                                    </div>
                                                                                    <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="5" class="m-r-5">&nbsp;Thursday&nbsp;</span>
                                                                                    <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="6" class="m-r-5">&nbsp;Friday&nbsp;</span>
                                                                                    <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="7" class="m-r-5">&nbsp;Saturday</span>
                                                                                </div>
<?php } elseif ($pattern_details->pattern == 'quarterly') { ?>
                                                                                <label class="control-label">
                                                                                    <input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day" class="m-r-5"> Due on day</label>&nbsp;
                                                                                <input class="form-control" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day" value="<?php echo $pattern_details->due_day; ?>"><label class="control-label">of</label>&nbsp;
                                                                                <select class="form-control" id="r_month" name="recurrence[due_month]">
                                                                                    <option value="1" <?php echo ($pattern_details->due_month == '1') ? 'selected' : ''; ?>>First</option>
                                                                                    <option value="2" <?php echo ($pattern_details->due_month == '2') ? 'selected' : ''; ?>>Second</option>
                                                                                    <option value="3" <?php echo ($pattern_details->due_month == '3') ? 'selected' : ''; ?>>Third</option>
                                                                                </select>&nbsp;
                                                                                <label class="control-label" id="control-label">month in quarter</label>
<?php } elseif ($pattern_details->pattern == 'periodic') { ?>
                                                                                <label class="control-label">Due on day</label>&nbsp;
                                                                                <input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day" value="<?php echo $pattern_details->due_day; ?>">
                                                                                <label class="control-label m-r-5">of month</label>&nbsp;
                                                                                <!--<input class="form-control" type="number" name="recurrence[due_month]" min="1" max="12" style="width: 100px" id="r_month" value="<?php echo $pattern_details->due_month; ?>">&nbsp;-->
                                                                                <select class="form-control" id="r_month" name="recurrence[due_month]">
                                                                                    <option value="1" <?php echo ($pattern_details->due_month == '1') ? 'selected' : ''; ?>>January</option>
                                                                                    <option value="2" <?php echo ($pattern_details->due_month == '2') ? 'selected' : ''; ?>>February</option>
                                                                                    <option value="3" <?php echo ($pattern_details->due_month == '3') ? 'selected' : ''; ?>>March</option>
                                                                                    <option value="4" <?php echo ($pattern_details->due_month == '4') ? 'selected' : ''; ?>>April</option>
                                                                                    <option value="5" <?php echo ($pattern_details->due_month == '5') ? 'selected' : ''; ?>>May</option>
                                                                                    <option value="6" <?php echo ($pattern_details->due_month == '6') ? 'selected' : ''; ?>>June</option>
                                                                                    <option value="7" <?php echo ($pattern_details->due_month == '7') ? 'selected' : ''; ?>>July</option>
                                                                                    <option value="8" <?php echo ($pattern_details->due_month == '8') ? 'selected' : ''; ?>>August</option>
                                                                                    <option value="9" <?php echo ($pattern_details->due_month == '9') ? 'selected' : ''; ?>>September</option>
                                                                                    <option value="10" <?php echo ($pattern_details->due_month == '10') ? 'selected' : ''; ?>>October</option>
                                                                                    <option value="11" <?php echo ($pattern_details->due_month == '11') ? 'selected' : ''; ?>>November</option>
                                                                                    <option value="12" <?php echo ($pattern_details->due_month == '12') ? 'selected' : ''; ?>>December</option>
                                                                                </select>&nbsp;<a href="javascript:void(0);" onclick="addPeriodicDate()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Periodic Date" style="pointer-events:none" disabled> <i class="fa fa-plus" aria-hidden="true"></i> </a>
    <?php
    if (!empty($periodic_pattern)) {
        foreach ($periodic_pattern as $val) {
            ?><div class="row" id="clone-<?= $val['id'] ?>">
                                                                                            <div class="col-md-12 m-b-5"><label class="control-label m-b-5"> Due on day</label>&nbsp;<input class="form-control m-r-5 test" type="number" name="due_days[]" min="1" max="31" value="<?= $val['due_day'] ?>" style="width: 100px" id="r_day1"><label class="control-label m-r-5">of month</label>
                                                                                                <select class="form-control m-r-2 periodic_mnth" id="r_month1" name="due_months[]" value="1">
                                                                                                    <option value="1" <?= $val['due_month'] == 1 ? 'selected' : '' ?> >January</option>
                                                                                                    <option value="2" <?= $val['due_month'] == 2 ? 'selected' : '' ?> >February</option>
                                                                                                    <option value="3" <?= $val['due_month'] == 3 ? 'selected' : '' ?> >March</option>
                                                                                                    <option value="4" <?= $val['due_month'] == 4 ? 'selected' : '' ?>>April</option>
                                                                                                    <option value="5" <?= $val['due_month'] == 5 ? 'selected' : '' ?>>May</option>
                                                                                                    <option value="6" <?= $val['due_month'] == 6 ? 'selected' : '' ?>>June</option>
                                                                                                    <option value="7" <?= $val['due_month'] == 7 ? 'selected' : '' ?>>July</option>
                                                                                                    <option value="8" <?= $val['due_month'] == 8 ? 'selected' : '' ?>>August</option>
                                                                                                    <option value="9" <?= $val['due_month'] == 9 ? 'selected' : '' ?>>September</option>
                                                                                                    <option value="10" <?= $val['due_month'] == 10 ? 'selected' : '' ?>>October</option>
                                                                                                    <option value="11" <?= $val['due_month'] == 11 ? 'selected' : '' ?>>November</option>
                                                                                                    <option value="12" <?= $val['due_month'] == 12 ? 'selected' : '' ?>>December</option>
                                                                                                </select>&nbsp;
                                                                                                <a href="javascript:void(0);" onclick="removePeriodicDate('<?= $val['id'] ?>')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>
        <?php }
    }
} else { ?>
                                                                                <label class="control-label"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due on day</label>&nbsp;
                                                                                <input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day" value="<?php echo $pattern_details->due_day; ?>">
                                                                                <label class="control-label m-r-5">of every</label>&nbsp;
                                                                                <input class="form-control" type="number" name="recurrence[due_month]" min="1" max="12" style="width: 100px" id="r_month" value="<?php echo $pattern_details->due_month; ?>">&nbsp;
                                                                                <label class="control-label" id="control-label">month(s)</label>
<?php } ?>
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
                                                                                <input class="form-control" type="number" id="t_start_month" name="recurrence[target_start_months]" value="<?php echo $pattern_details->target_start_months; ?>" min="0" max="12" style="width: 100px">
                                                                                <label class="control-label">month(s)</label>
                                                                            </div>
                                                                            <div class="col-md-6 p-l-0">
                                                                                <label class="">&nbsp;</label>
                                                                                <input class="form-control" type="number" name="recurrence[target_start_days]" value="<?php echo $pattern_details->target_start_days; ?>" min="1" style="width: 100px" id="t_start_day">
                                                                                <label class="control-label">day(s)</label>
                                                                            </div>
                                                                            <div class="col-md-12 m-t-10">
                                                                                <label class="control-label"><input style="vertical-align: text-bottom;" type="radio" name="recurrence[target_start_day]" value="1" <?php echo ($pattern_details->target_start_day == '1') ? 'checked' : ''; ?> checked="">&nbsp; Before due date</label>

                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                    
                                                                                                                                                <label class="">For Start</label>
                                                                                                                                                <input class="form-control" type="number" name="recurrence[target_start_days]" value="<?php // echo $pattern_details->target_start_days;  ?>" min="0" style="width: 100px" id="t_start_day">
                                                                                                                                                <label class="control-label"><input type="radio" name="recurrence[target_start_day]" value="1" <?php // echo ($pattern_details->target_start_day == '1') ? 'checked' : '';  ?>>&nbsp; Days before due date</label>
                                                                                                                                                <label class="control-label"><input type="radio" name="recurrence[target_start_day]" value="2" <?php // echo ($pattern_details->target_start_day == '2') ? 'checked' : '';  ?>>&nbsp; Days after creation date</label> -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-md-6 p-r-0">
                                                                                <label class="">For Complete</label>
                                                                                <input class="form-control" type="number" id="t_end_month" name="recurrence[target_end_months]" min="0" max="12" value="<?php echo $pattern_details->target_end_months; ?>" style="width: 100px">
                                                                                <label class="control-label">month(s)</label>
                                                                            </div>
                                                                            <div class="col-md-6 p-l-0">
                                                                                <label class="">&nbsp;</label>   
                                                                                <input class="form-control" type="number" name="recurrence[target_end_days]" value="<?php echo $pattern_details->target_end_days; ?>" min="1" style="width: 100px" id="t_end_day">
                                                                                <label class="control-label">day(s)</label>
                                                                            </div>
                                                                            <div class="col-md-12 m-t-10">
                                                                                <label class="control-label"><input style="vertical-align: text-bottom;" type="radio" name="recurrence[target_end_day]" value="1" <?php echo ($pattern_details->target_end_day == '1') ? 'checked' : ''; ?> checked="">&nbsp; Before due date</label>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                    
                                                                                                                                                <label class="">For Complete</label>
                                                                                                                                                <input class="form-control" type="number" name="recurrence[target_end_days]" value="<?php // echo $pattern_details->target_end_days;  ?>" min="0" style="width: 100px" id="t_end_day">
                                                                                                                                                <label class="control-label"><input type="radio" name="recurrence[target_end_day]" value="1" <?php // echo ($pattern_details->target_end_day == '1') ? 'checked' : '';  ?>>&nbsp; Days before due date</label>
                                                                                                                                                <label class="control-label"><input type="radio" name="recurrence[target_end_day]" value="2" <?php // echo ($pattern_details->target_end_day == '2') ? 'checked' : '';  ?>>&nbsp; Days after creation date</label>-->
                                                                    </div>
                                                                </div>
                                                            </div><!-- ./row -->
                                                            <div class="none-div" <?php echo ($pattern_details->pattern == 'none') ? 'style="display:none;"' : 'style="display:block;"'; ?>>
                                                                <hr class="hr-line-dashed"/>
                                                                <h3 class="m-0 p-b-20">Expiration:</h3>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="form-inline">
                                                                                <label class="control-label"><input type="radio" name="recurrence[expiration_type]" <?php echo ($pattern_details->expiration_type == '0') ? 'checked' : ''; ?> value="0"> No end date</label>&nbsp;
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="form-inline">
                                                                                <label class="control-label"><input type="radio" name="recurrence[expiration_type]" <?php echo ($pattern_details->expiration_type == '1') ? 'checked' : ''; ?> value="1"> End after</label>&nbsp;
                                                                                <input class="form-control" type="number" id="end_occurrence" name="recurrence[end_occurrence]" min="1" max="31" style="width: 100px" value="<?php echo $pattern_details->end_occurrence; ?>">
                                                                                <label class="control-label">Occurrences</label>
                                                                            </div>
                                                                        </div> 
                                                                    </div>

                                                                </div><!--./row -->
                                                                <hr class="hr-line-dashed"/>
                                                                <h3 class="m-0 p-b-20">Generation:</h3>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="control-label"><input type="radio" name="recurrence[generation_type]" disabled value="0" <?php echo ($pattern_details->generation_type == '0') ? 'checked' : ''; ?> onclick="//check_generation_type(this.value)">&nbsp; When previous project is Complete</label>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-inline">
                                                                            <label class="control-label"><input type="radio" name="recurrence[generation_type]" <?php echo ($pattern_details->generation_type == '1') ? 'checked' : ''; ?> value="1" onclick="//check_generation_type(this.value)"></label>&nbsp;
                                                                            <input class="form-control" type="number" id="generation_month" name="recurrence[generation_month]" value="<?php echo $pattern_details->generation_month; ?>" min="0" max="12" style="width: 100px">&nbsp;
                                                                            <label class="control-label">month(s)</label>&nbsp;
                                                                            <input class="form-control" value="<?php echo $pattern_details->generation_day; ?>" type="number" id="generation_day" name="recurrence[generation_day]" min="1" max="31" style="width: 100px">&nbsp;
                                                                            <label class="control-label">Day(s) before next occurrence due date</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="control-label"><input type="radio" name="recurrence[generation_type]" value="2" <?php echo ($pattern_details->generation_type == '2') ? 'checked' : ''; ?> onclick="//check_generation_type(this.value)">&nbsp; None</label>
                                                                    </div>

                                                                </div> <!-- ./row -->

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
                                                <!--<input type="hidden" id="tmplt_id" value="3">-->
                                                <input type="hidden" id="edit_project_main_id" name="template_main[project_id]" value="<?= $project_id ?>">
                                                <input type="hidden" id="edit_template" name="template_main[template_main_id]" value="<?= $template_main_id ?>">
                                                <button type="button" class="btn btn-primary" onclick="request_edit_project_main();">Save</button>
                                            </div>

                                        </div>
                                    </form> 
                                </div><!-- #tab-1 -->
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="clearfix">
                                        <button type="button" class="btn btn-primary pull-right m-b-20" id="task_btn" onclick="get_project_task_modal(<?= $template_main_id ?>,<?= $project_id ?>);"><i class="fa fa-plus"></i> &nbsp;Create Task</button>
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
                                                        <a href="javascript:void(0);" onclick="project_task_edit_modal(<?= $value['id'] ?>,<?= $value['project_id'] ?>);" class="btn btn-primary btn-xs btn-service-edit btn-prj-template-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>                                
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
                                                                            <td title="Task Id"><?= $value['task_order'] ?></td>
                                                                            <td title="Title"><?= $value['task_title'] ?></td>
                                                                            <!--<td title="Assign To"><span></span></td>-->
                                                                            <td title="Assign To"><span class="text-success"><?php echo get_assigned_project_task_staff($value['id']); ?></span><br><?php echo get_assigned_project_task_department($value['id']); ?></td>                                                    
                                                                            <!--get_task_note($value['id'])-->
                                                                            <td title='Note'><a id="notecount-<?= $value['id'] ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_task_notes(<?= $value["id"]; ?>)"><b> <?= get_project_task_note_count($value['id']) ?></b></a></td>
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
                                                                                <!--<a href="javascript:void(0);" data-toggle="popover" data-placement="top" data-content="test description" data-trigger="hover" title="" data-original-title=""><?//= $value['description'] ?></a>-->
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
                            <!-- ./tab-content -->
                        </div><!-- ./tabs-container -->
                    </div><!-- ./col-md-12 -->
                </div><!-- ./row -->
            </div><!-- ./ibox-content -->
        </div><!-- ./ibox -->

        <!-- Task Modal -->
        <div id="taskModal" class="modal fade" role="dialog">
        </div>

    </div>
</div>
<div class="modal fade" id="showProjectTaskNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" id="project_task_modal_note_form_update" onsubmit="update_project_task_notes();">
                <div id="notes-modal-body" class="modal-body p-b-0"></div>
                <div class="modal-body p-t-0 text-right">
                    <button type="button" id="update_note" onclick="update_project_task_notes();" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
            <!--  <form method="post" id="modal_note_form" action="<?//= base_url(); ?>action/home/addNotesmodal"> -->
            <form method="post" id="project_task_modal_note_form" onsubmit="add_project_task_notes();">
                <div class="modal-body">
                    <h4>Add New Note</h4>
                    <!-- <div class="col-lg-10">
                                  <label class="checkbox-inline">
                                      <input type="checkbox"  name="pending_request" id="pending_request" value="1"><b>Add to SOS Notification</b>
                                  </label>
                              </div> -->
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="task_note[]"  title="Task Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a> </div>
                    <input type="hidden" name="taskid" id="taskid">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="add_project_task_notes();" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$office_staff = getProjectOfficeStaff($project_id);
if (!empty($office_staff)) {
    $staff_id = $office_staff->staff_id;
} else {
    $staff_id = '';
}
$dept_staff = getProjectDepartmentStaff($project_id);
if (!empty($dept_staff)) {
    $dept_staff_id = $dept_staff->staff_id;
} else {
    $dept_staff_id = '';
}
?>
<script>
    get_template_responsible_staff('<?php echo $template_details->responsible_department ?>', '<?php echo $template_details->responsible_staff ?>', '<?php echo $template_details->ofc_is_all ?>',<?= $staff_id ?>);
//    get_template_office_staff(<? $template_details->ofc_is_all ?>,<? $template_details->office_id ?>,'<? $staff_id ?>','<? $template_details->partner_id ?>','<? $template_details->manager_id ?>','<? $template_details->associate_id ?>');
    get_template_office_new(<?= $template_details->dept_is_all ?>,<?= $template_details->department_id ?>, '<?= $dept_staff_id ?>');
    getServiceList(<?= $template_details->category_id ?>,<?= $template_details->service_id ?>);

    $(document).ready(function () {
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });
        $('.add-task-note').click(function () {
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


