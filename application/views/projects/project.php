<?php
$user_info = staff_info();
$user_department = $user_info['department'];
$user_type = $user_info['type'];
$role = $user_info['role'];
?>
<style>
    .project-clear-filter{
        position: relative;
        top: -53px;
        left: 110px;
        width: 150px;
    }
</style>
<script src="<?= base_url(); ?>assets/js/dashboard.js"></script>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php if ($user_type != 3) { ?>
                                <button type="button" class="btn btn-primary"  onclick="CreateProjectModal('add', '');" ><i class="fa fa-plus"></i> &nbsp;Create Project</button>
                            <?php } ?>
                            <button type="button" class="btn btn-success"  onclick="taskDashboard();" >&nbsp;Task Dahsboard</button>
                            <a class="btn btn-info pull-right" target="new_blank" href="<?= base_url().'project_recurrence_patch.php' ?>">&nbsp;Recurrence</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row"> 
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab" role="tablist">
                                <li role="presentation" class="<?= ($category == '1-bookkeeping') ? 'active' : '' ?>"><a href="#bookkeeping" aria-controls="bookkeeping" role="tab" data-toggle="tab" onclick="reflactProjectFilterWithCategory('1-bookkeeping', '', );loadProjectDashboard('', '', '', '', '', '', '', '', '', '', '', '', '', 1, 1)">Bookkeeping</a></li>
                                <li role="presentation" class="<?= ($category == '2-tax_returns') ? 'active' : '' ?>" ><a href="#tax_returns" aria-controls="tax_returns" role="tab" data-toggle="tab" onclick="reflactProjectFilterWithCategory('2-tax_returns', '');loadProjectDashboard('', '', '', '', '', '', '', '', '', '', '', '', '', 1, 2)">Tax Returns</a></li>
                                <li role="presentation" class="<?= ($category == '3-sales_tax') ? 'active' : '' ?>"><a href="#sales_tax" aria-controls="sales_tax" role="tab" data-toggle="tab" onclick="reflactProjectFilterWithCategory('3-sales_tax', '');loadProjectDashboard('', '', '', '', '', '', '', '', '', '', '', '', '', 1, 3)">Sales Tax</a></li>
                                <li role="presentation" class="<?= ($category == '4-annual_report') ? 'active' : '' ?>"><a href="#annual_report" aria-controls="annual_report" role="tab" data-toggle="tab" onclick="reflactProjectFilterWithCategory('4-annual_report', '');loadProjectDashboard('', '', '', '', '', '', '', '', '', '', '', '', '', 1, 4)">Annual Report</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="#" class="btn btn-primary m-t-15" id="project_add_filter">Show Filter</a>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane <?= ($category == '1-bookkeeping') ? 'active' : '' ?>" id="bookkeeping">
                                    <div class="project-clear-filter"><!-- col-lg-1 row clear-project-btn-one -->
                                        <span class="text-success" style="display: none;" id="clear_filter">&nbsp; </span><a href="javascript:void(0);" onclick="clearProjectFilter();loadProjectDashboard('', '', '', '', '', '', 'clear', '', '', '', '', '', '', 1, 1);" class="btn btn-ghost" id="bookkeeping_btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-md-12 p-t-15">
                                            <div class="alert-primar-wrap">
                                        <?php
                                        foreach ($templateIds as $key => $value) {
                                            $projects_list = getTemplateCategoryProjectList($value['template_id'], 1, '', $select_year);
                                            $status_array = array_count_values(array_column($projects_list, 'status'));
                                            if (!empty($projects_list)) {
                                                ?>
                                                
                                                    <div class="alert-primar m-b-15">
                                                        <h4 class="p-l-15 p-r-15 f-s-14"> <a href="javascript:void(0);" data-toggle="popover" data-placement="top" data-content="<?= $value['title'] ?>" data-trigger="hover" title="" data-original-title=""><?= (strlen($value['title']) > 20 ? substr_replace($value['title'], '..', 20) : $value['title']) ?></a> </h4>
                                                        <div class="alert-primar-grid-container">
                                                        <div class="alert-primar-grid m-t-5">
                                                            <table>
                                                                <tr>
                                                                    <td style="text-align: right; padding-right: 5px;">New</td>
                                                                    <td><span class="label label-success label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('1-bookkeeping', '0-Not Started');loadProjectDashboard(0, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 1);"> <?= isset($status_array[0]) ? $status_array[0] : 0; ?> </span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: right; padding-right: 5px;">Started</td>
                                                                    <td><span class="label label-warning label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('1-bookkeeping', '1-Started');loadProjectDashboard(1, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 1);"> <?= isset($status_array[1]) ? $status_array[1] : 0; ?> </span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: right; padding-right: 5px;">Clarification</td>
                                                                    <td><span class="label label-info label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('1-bookkeeping', '5-Clarification');loadProjectDashboard(5, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 1);"> <?= isset($status_array[5]) ? $status_array[5] : 0; ?> </span>   </td>
                                                                </tr>
                                                            </table>
                                                            
                                                        </div>
                                                        <div class="alert-primar-grid">
                                                                <div class="project-bookkeeping-campaigns-donut-<?= $key ?> text-center" data-size="65" id="project_bookkeeping_donut_<?= $key ?>" data-json="project_bookkeeping_data_<?= $key ?>"></div>
                                                                <script>
                                                                    var project_bookkeeping_data_<?= $key ?> = [{'section_label': 'Start', 'value': <?= isset($status_array[1]) ? $status_array[1] : 0 ?>, 'color': '#FFB046'}, {'section_label': 'Not Started', 'value': <?= isset($status_array[0]) ? $status_array[0] : 0; ?>, 'color': '#06a0d6'}, {'section_label': 'Clarification', 'value': <?= isset($status_array[5]) ? $status_array[5] : 0; ?>, 'color': '#23c6c8'}];
                                                                </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                <script>
                                                    pieChart('project-bookkeeping-campaigns-donut-<?= $key ?>');
                                                </script>
                                                <?php
                                            }
                                        }
                                        ?>
                                             </div><!--./alert-primar-wrap --> 
                                         </div><!--./col-md-12 --> 
                                    </div><!--./row -->  

                                </div>
                                <div role="tabpanel" class="tab-pane <?= $category == '2-tax_returns' ? 'active' : '' ?>" id="tax_returns" >
                                    <div class="project-clear-filter">
                                        <span class="text-success" style="display: none;" id="clear_filter">&nbsp; </span><a href="javascript:void(0);" onclick="clearProjectFilter();loadProjectDashboard('', '', '', '', '', '', 'clear', '', '', '', '', '', '', 1, 2);" class="btn btn-ghost" id="tax_btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert-primar-wrap">
                                        <?php
                                        foreach ($templateIds as $key => $value) {
                                            $projects_list2 = getTemplateCategoryProjectList($value['template_id'], 2, '', $select_year);
                                            $status_array = array_count_values(array_column($projects_list2, 'status'));
                                            if (!empty($projects_list2)) {
                                                ?>
                                                
                                                    <div class="alert-primar m-b-15">
                                                        <h4 class="p-l-15 p-r-15 f-s-14"> <a href="javascript:void(0);" data-toggle="popover" data-placement="top" data-content="<?= $value['title'] ?>" data-trigger="hover" title="" data-original-title=""><?= (strlen($value['title']) > 20 ? substr_replace($value['title'], '..', 20) : $value['title']) ?></a> </h4>
                                                        <div class="alert-primar-grid-container">
                                                        <div class="alert-primar-grid m-t-5">
                                                            <table>
                                                                <tr>
                                                                    <td style="text-align: right; padding-right: 5px;">New</td>
                                                                    <td><span class="label label-success label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('2-tax_returns', '0-Not Started');loadProjectDashboard(0, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 2);"> <?= isset($status_array[0]) ? $status_array[0] : 0; ?> </span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: right; padding-right: 5px;">Started</td>
                                                                    <td><span class="label label-warning label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('2-tax_returns', '1-Started');loadProjectDashboard(1, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 2);"> <?= isset($status_array[1]) ? $status_array[1] : 0; ?> </span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: right; padding-right: 5px;">Clarification</td>
                                                                    <td><span class="label label-info label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('2-tax_returns', '5-Clarification');loadProjectDashboard(5, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 2);"> <?= isset($status_array[5]) ? $status_array[5] : 0; ?> </span>   </td>
                                                                </tr>
                                                            </table>
                                                            
                                                        </div>
                                                        <div class="alert-primar-grid">
                                                            <div class="project-tax-campaigns-donut-<?= $key ?> text-center" data-size="60" id="project_tax_donut_<?= $key ?>" data-json="project_tax_data_<?= $key ?>"></div>
                                                            <script>
                                                                var project_tax_data_<?= $key ?> = [{'section_label': 'Start', 'value': <?= isset($status_array[1]) ? $status_array[1] : 0 ?>, 'color': '#FFB046'}, {'section_label': 'Not Started', 'value': <?= isset($status_array[0]) ? $status_array[0] : 0; ?>, 'color': '#06a0d6'}, {'section_label': 'Clarification', 'value': <?= isset($status_array[5]) ? $status_array[5] : 0; ?>, 'color': '#23c6c8'}];
                                                            </script>
                                                        </div>
                                                        </div>
                                                    </div>
                                                
                                                <script>
                                                    pieChart('project-tax-campaigns-donut-<?= $key ?>');
                                                </script>
                                                <?php
                                            }
                                        }
                                        ?>
                                             </div><!--./alert-primar-wrap --> 
                                         </div><!--./col-md-12 --> 
                                    </div><!--./row -->                                
                                </div>
                                <div role="tabpanel" class="tab-pane <?= ($category == '3-sales_tax') ? 'active' : '' ?>" id="sales_tax" >
                                    <div class="project-clear-filter">
                                        <span class="text-success" style="display: none;" id="clear_filter">&nbsp; </span><a href="javascript:void(0);" onclick="clearProjectFilter();loadProjectDashboard('', '', '', '', '', '', 'clear', '', '', '', '', '', '', 1, 3);" class="btn btn-ghost" id="sales_btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert-primar-wrap">
                                        <?php
                                        foreach ($templateIds as $key => $value) {
                                            $projects_list3 = getTemplateCategoryProjectList($value['template_id'], 3, '', $select_year);
                                            $status_array1 = array_count_values(array_column($projects_list3, 'status'));
                                            if (!empty($projects_list3)) {
                                                ?>
                                                
                                                    <div class="alert-primar m-b-15">
                                                        <h4 class="p-l-15 p-r-15 f-s-14"><a href="javascript:void(0);" data-toggle="popover" data-placement="top" data-content="<?= $value['title'] ?>" data-trigger="hover" title="" data-original-title=""><?= (strlen($value['title']) > 20 ? substr_replace($value['title'], '..', 20) : $value['title']) ?></a></h4>
                                                        <div class="alert-primar-grid-container">
                                                            <div class="alert-primar-grid m-t-5"> 
                                                                <table>
                                                                    <tr>
                                                                        <td style="text-align: right; padding-right: 5px;">New</td>
                                                                        <td><span class="label label-success label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('3-sales_tax', '0-Not Started');loadProjectDashboard(0, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 3);"> <?= isset($status_array1[0]) ? $status_array1[0] : 0; ?> </span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align: right; padding-right: 5px;">Started</td>
                                                                        <td><span class="label label-warning label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('3-sales_tax', '1-Started');loadProjectDashboard(1, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 3);"> <?= isset($status_array1[1]) ? $status_array1[1] : 0; ?> </span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align: right; padding-right: 5px;">Clarification</td>
                                                                        <td><span class="label label-info label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('3-sales_tax', '5-Clarification');loadProjectDashboard(5, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 3);"> <?= isset($status_array1[5]) ? $status_array1[5] : 0; ?> </span></td>
                                                                    </tr>
                                                                   
                                                                </table>
                                                            </div>
                                                            <div class="alert-primar-grid">
                                                                <div class="project-sales-campaigns-donut-<?= $key ?> text-center" data-size="60" id="project_sales_donut_<?= $key ?>" data-json="project_sales_data_<?= $key ?>"></div>
                                                                <script>
                                                                    var project_sales_data_<?= $key ?> = [{'section_label': 'Start', 'value': <?= isset($status_array1[1]) ? $status_array1[1] : 0 ?>, 'color': '#FFB046'}, {'section_label': 'Not Started', 'value': <?= isset($status_array1[0]) ? $status_array1[0] : 0; ?>, 'color': '#06a0d6'}, {'section_label': 'Clarification', 'value': <?= isset($status_array1[5]) ? $status_array1[5] : 0; ?>, 'color': '#23c6c8'}];
                                                                </script>
                                                            </div>
                                                        </div>

                                                    </div>
                                                
                                                <script>
                                                    pieChart('project-sales-campaigns-donut-<?= $key ?>');
                                                </script>
                                                <?php
                                            }
                                        }
                                        ?>
                                            </div><!--./alert-primar-wrap -->
                                        </div><!--./col-md-12-->
                                    </div><!--./row-->
                                </div>
                                <div role="tabpanel" class="tab-pane <?= $category == '4-annual_report' ? 'active' : '' ?>" id="annual_report" >
                                    <div class="project-clear-filter">
                                        <span class="text-success" style="display: none;" id="clear_filter">&nbsp; </span><a href="javascript:void(0);" onclick="clearProjectFilter();loadProjectDashboard('', '', '', '', '', '', 'clear', '', '', '', '', '', '', 1, 4);" class="btn btn-ghost" id="annual_btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert-primar-wrap">
                                                
                                            
                                        <?php
                                        foreach ($templateIds as $key => $value) {
                                            $projects_list4 = getTemplateCategoryProjectList($value['template_id'], 4, '', $select_year);
                                            $status_array1 = array_count_values(array_column($projects_list4, 'status'));
                                            if (!empty($projects_list4)) {
                                                ?>
                                                
                                                    <div class="alert-primar m-b-15">
                                                        <h4 class="col-md-4 m-t-10 f-s-14"> <?= (strlen($value['title']) > 20 ? substr_replace($value['title'], '..', 20) : $value['title']) ?> </h4>
                                                        <div class="alert-primar-grid-container">
                                                        <div class="alert-primar-grid m-t-5">
                                                            <table>
                                                                <tr>
                                                                    <td style="text-align: right; padding-right: 5px;">New</td>
                                                                    <td><span class="label label-success label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('4-sales_tax', '0-Not Started');loadProjectDashboard(0, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 4);"> <?= isset($status_array1[0]) ? $status_array1[0] : 0; ?> </span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: right; padding-right: 5px;">Started</td>
                                                                    <td><span class="label label-warning label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('4-annual_report', '1-Started');loadProjectDashboard(1, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 4);"> <?= isset($status_array1[1]) ? $status_array1[1] : 0; ?> </span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: right; padding-right: 5px;">Clarification</td>
                                                                    <td><span class="label label-info label-block" style="width: 40px; display: inline-block; text-align: center; cursor: pointer;" onclick="reflactProjectFilterWithCategory('4-annual_report', '5-Clarification');loadProjectDashboard(5, '', '<?= $value['template_id'] ?>', '', '', '', '', '', '', '', '', '', '', 1, 4);"> <?= isset($status_array1[5]) ? $status_array1[5] : 0; ?> </span></td>
                                                                </tr>
                                                            </table>
                                                               
                                                        </div>
                                                        <div class="alert-primar-grid">
                                                            <div class="project-annual-campaigns-donut-<?= $key ?> text-center" data-size="60" id="project_annual_donut_<?= $key ?>" data-json="project_annual_data_<?= $key ?>"></div>
                                                            <script>
                                                                var project_annual_data_<?= $key ?> = [{'section_label': 'Start', 'value': <?= isset($status_array1[1]) ? $status_array1[1] : 0 ?>, 'color': '#FFB046'}, {'section_label': 'Not Started', 'value': <?= isset($status_array1[0]) ? $status_array1[0] : 0; ?>, 'color': '#06a0d6'}, {'section_label': 'Clarification', 'value': <?= isset($status_array1[5]) ? $status_array1[5] : 0; ?>, 'color': '#23c6c8'}];
                                                            </script>
                                                        </div>
                                                        </div>
                                                    </div>
                                                
                                                <script>
                                                    pieChart('project-annual-campaigns-donut-<?= $key ?>');
                                                </script>
                                                <?php
                                            }
                                        }
                                        ?>
                                                </div><!--/.alert-primar-wrap-->
                                        </div><!--/.col-md-12-->
                                    </div><!--/.row-->
                                </div>
                                <input type="hidden" id="cat">
                            </div>

                            <hr class="hr-line-dashed  m-t-5 m-b-5">
                            <div class="ajaxdiv" id="action_dashboard_div"> 
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showProjectNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" id="modal_note_form_update" onsubmit="update_project_notes();">
                <div id="notes-modal-body" class="modal-body p-b-0"></div>
                <div class="modal-body p-t-0 text-right">
                    <button type="button" id="update_note" onclick="update_project_notes();" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
            <!--  <form method="post" id="modal_note_form" action="<?//= base_url(); ?>action/home/addNotesmodal"> -->
            <form method="post" id="modal_note_form" onsubmit="add_project_notes();">
                <div class="modal-body">
                    <h4>Add New Note</h4>
                    <!-- <div class="col-lg-10">
                                  <label class="checkbox-inline">
                                      <input type="checkbox"  name="pending_request" id="pending_request" value="1"><b>Add to SOS Notification</b>
                                  </label>
                              </div> -->
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="project_note[]"  title="Project Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a> </div>
                    <input type="hidden" name="project_id" id="project_id">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="add_project_notes();" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--project modal--> 
<!--project task note-->
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
<!--end project task note-->
<div id="projectModal" class="modal fade" role="dialog" data-backdrop="static"></div>
<!-- Sos Modal -->
<div class="modal fade" id="showSos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                <h4 class="modal-title" id="myModalLabel">SOS</h4>
            </div>
            <div id="notes-modal-body" class="modal-body p-b-0"> </div>
            <!-- <form method="post" id="sos_note_form" action="<?//= base_url(); ?>home/addSos"> -->
            <form method="post" id="sos_project_form" onsubmit="add_project_sos()">
                <div class="modal-body">
                    <h4 id="sos-title">Add New SOS</h4>
                    <div class="form-group" id="add_sos_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="sos_note"  title="SOS Note"></textarea>
                        </div>
                        <!-- <a href="javascript:void(0)" class="text-success add-referreal-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a> --> 
                    </div>
                    <input type="hidden" name="reference" id="reference" value="projects">
                    <input type="hidden" name="refid" id="refid">
                    <input type="hidden" name="staffs" id="staffs">
                    <input type="hidden" name="serviceid" id="serviceid">
                    <input type="hidden" name="replyto" id="replyto" value="">
                    <input type="hidden" name="servreqid" id="servreqid" value="">
                </div>
                <div class="modal-footer"> 
                    <!-- <button type="submit" id="save_sos" class="btn btn-primary" onclick="document.getElementById('sos_note_form').submit();this.disabled = true;this.innerHTML = 'Processing...';">Post SOS</button> -->
                    <button type="button" id="save_sos" class="btn btn-primary" onclick="add_project_sos()">Post SOS</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- sos modal --> 
<!--tracking modal-->
<div id="changeStatusinner" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad0" value="0"/>
                                <label for="rad0"><strong>Not Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad3" value="3"/>
                                <label for="rad3"><strong>Ready</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad1" value="1"/>
                                <label for="rad1"><strong>Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2" value="2"/>
                                <label for="rad2"><strong>Completed</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad4" value="4"/>
                                <label for="rad4"><strong>Canceled</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad5" value="5"/>
                                <label for="rad5"><strong>Clarification</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="prosubid" value="">
                <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="project-tracking-save" class="btn btn-primary" onclick="updateProjectStatusinner()">Save changes</button>
            </div>
            <div class="modal-body" style="display: none;" id="log_modal">
                <div style="height:200px; overflow-y: scroll">
                    <table id="status_log" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>time</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var content = $(".filter-div").html();
    var variableArray = [];
    var elementArray = [];
    $("#project_add_filter").click(function(){
        $("#project_apply_filter").toggle();
        
        var random = Math.floor((Math.random() * 999) + 1);
        var clone = '<div class="filter-div row m-b-20" id="clone-' + random + '">' + content + '<div class="col-sm-1 text-center p-l-0"><a href="javascript:void(0);" onclick="removeProjectFilterRow(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>';
        $('.filter-inner').append(clone);

        $.each(variableArray, function (key, value) {
            $("#clone-" + random + " .variable-dropdown option[value='" + value + "']").remove();
        });
        clearProjectFilter();
        addProjectFilterRow();
        if($("#project_add_filter").text()=='Show Filter'){
            $("#project_add_filter").text('Hide Filter');
        }else{
            $("#project_add_filter").text('Show Filter');
        }
    });
    $("#project_add_filter").text('Show Filter');
    loadProjectDashboard('<?= $status; ?>', '<?= $request_type; ?>', '<?= $template_id; ?>', '<?= $office_id; ?>', '<?= $department_id; ?>', '', '', '', '', '', '', '', '', 1,<?= $template_cat_id ?>);
    reflactProjectFilterWithCategory('<?= $category ?>', '');
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function () {
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
    function change_project_status_inner(id, status, section_id,project_id='',task_order='') {
        openModal('changeStatusinner');
        var txt = 'Tracking Project #' + project_id+'-'+task_order;
        $("#changeStatusinner .modal-title").html(txt);
        if (status == 0) {
            $("#changeStatusinner #rad0").prop('checked', true);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad5").prop('checked', false);
        } else if (status == 1) {
            $("#changeStatusinner #rad1").prop('checked', true);
            $("#changeStatusinner #rad0").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad5").prop('checked', false);
        } else if (status == 2) {
            $("#changeStatusinner #rad2").prop('checked', true);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad5").prop('checked', false);
        } else if (status == 3) {
            $("#changeStatusinner #rad3").prop('checked', true);
            $("#changeStatusinner #rad5").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
        } else if (status == 4) {
            $("#changeStatusinner #rad4").prop('checked', true);
            $("#changeStatusinner #rad5").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
        }
        else if (status == 5) {
            $("#changeStatusinner #rad5").prop('checked', true);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
        }
        $.get($('#baseurl').val() + "project/get_project_tracking_log/" + section_id + "/project_task", function (data) {
            $("#status_log > tbody > tr").remove();
            var returnedData = JSON.parse(data);
            for (var i = 0, l = returnedData.length; i < l; i++) {
                $('#status_log > tbody:last-child').append("<tr><td>" + returnedData[i]["stuff_id"] + "</td>" + "<td>" + returnedData[i]["department"] + "</td>" + "<td>" + returnedData[i]["status"] + "</td>" + "<td>" + returnedData[i]["created_time"] + "</td></tr>");
            }
            if (returnedData.length >= 1)
                $("#log_modal").show();
            else
                $("#log_modal").hide();
        });
        $("#changeStatusinner #prosubid").val(id);
    }
    function updateProjectStatusinner() {
        var statusval = $('#changeStatusinner input:radio[name=radio]:checked').val();
        var prosubid = $('#changeStatusinner #prosubid').val();
        //        alert(prosubid);
        var base_url = $('#baseurl').val();
        $.ajax({
            type: "POST",
            data: {statusval: statusval, prosubid: prosubid},
            url: base_url + 'project/update_project_task_status',
            dataType: "html",
            success: function (result) {
//                alert(result.trim());return false;
                var res = JSON.parse(result.trim());
//                    alert(res.task_status+','+res.project_status);return false;
                if (res.task_status == '0') {
                    var tracking = 'Not Started';
                    var trk_class = 'label label-success';
                } else if (res.task_status == 1) {
                    var tracking = 'Started';
                    var trk_class = 'label label-yellow';
                } else if (res.task_status == 2) {
                    var tracking = 'Completed';
                    var trk_class = 'label label-primary';
                } else if (res.task_status == 3) {
                    var tracking = 'Ready';
                    var trk_class = 'label label-secondary';
                } else if (res.task_status == 4) {
                    var tracking = 'Canceled';
                    var trk_class = 'label label-danger';
                }else if (res.task_status == 5) {
                    var tracking = 'Clarification';
                    var trk_class = 'label label-info';
                }

                if (res.project_status == 0) {
                    var tracking_main = 'Not Started';
                    var trk_class_main = 'label label-success';
                } else if (res.project_status == 1) {
                    var tracking_main = 'Started';
                    var trk_class_main = 'label label-yellow';
                } else if (res.project_status == 2) {
                    var tracking_main = 'Completed';
                    var trk_class_main = 'label label-info';
                } else if (res.project_status == 4) {
                    var tracking_main = 'Canceled';
                    var trk_class_main = 'label label-danger';
                } else if (res.project_status == 5) {
                    var tracking_main = 'Clarification';
                    var trk_class_main = 'label label-info';
                }

                if (res.sub_taskid_status == 3) {
                    var tracking_sub = 'Ready';
                    var trk_class_sub = 'label label-secondary';
                    $("#trackinner-" + res.sub_taskid).removeClass().addClass(trk_class_sub);
                    $("#trackinner-" + res.sub_taskid).html(tracking_sub);
                }
                if (res.sub_taskid_status == 0) {
                    var tracking_sub = 'Not Started';
                    var trk_class_sub = 'label label-success';
                    $("#trackinner-" + res.sub_taskid).removeClass().addClass(trk_class_sub);
                    $("#trackinner-" + res.sub_taskid).html(tracking_sub);
                }

                $("#trackinner-" + prosubid).removeClass().addClass(trk_class);
                $("#trackinner-" + prosubid).parent('a').removeAttr('onclick');
                $("#trackinner-" + prosubid).parent('a').attr('onclick', 'change_project_status_inner(' + prosubid + ',' + statusval + ', ' + prosubid + ');');
                $("#trackinner-" + prosubid).html(tracking);
                var projectid = $("#trackinner-" + prosubid).attr('projectid');
                $("#trackouter-" + projectid).removeClass().addClass(trk_class_main);
                $("#trackouter-" + projectid).html(tracking_main);
                $('#changeStatusinner').modal('hide');

//                }
            },
            beforeSend: function () {
                $("#project-tracking-save").prop('disabled', true).html('Processing...');
                openLoading();
            },
            complete: function (msg) {
                $("#project-tracking-save").removeAttr('disabled').html('Save Changes');
                closeLoading();
            }
        });
    }
    
    function changeVariableProject(element) {
        var divID = $(element).parent().parent().attr('id');
        var variableValue = $(element).children("option:selected").val();
        //        alert(variableValue);
        var checkElement = elementArray.includes(element);
        var officeValue = '';
        if (checkElement == true) {
            variableArray.pop();
            variableArray.push(variableValue);
        } else {
            elementArray.push(element);
            variableArray.push(variableValue);
        }
        if (variableValue == 10) {
            var checkOfficeValue = variableArray.includes('3');
            if (checkOfficeValue == true) {
                var officeValue = $("select[name='criteria_dropdown[office][]']").val();
            } else {
                var officeValue = '';
            }
        } else {
            var officeValue = '';
        }

        $.ajax({
            type: "POST",
            data: {
                variable: variableValue,
                office: officeValue
            },
            url: base_url + 'project/project_filter_dropdown_option_ajax',
            dataType: "html",
            success: function (result) {
                $("select.condition-dropdown:first").val(1).attr('disabled', false);
                $("#" + divID).find('.criteria-div').html(result);
                $(".chosen-select").chosen();
                $("#" + divID).find('.condition-dropdown').val('');
                $("#" + divID).nextAll(".filter-div").each(function () {
                    $(this).find('.remove-filter-button').trigger('click');
                });
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }
    function changeCondition(element) {
        var divID = $(element).parent().parent().attr('id');
        //alert(divID);
        var conditionValue = $(element).children("option:selected").val();
        var variableValue = $(element).parent().parent().find(".variable-dropdown option:selected").val();
        if (variableValue == 9) {
            if (conditionValue == 2 || conditionValue == 4) {
                $.ajax({
                    type: "POST",
                    data: {
                        condition: conditionValue,
                        variable: variableValue
                    },
                    url: base_url + 'project/project_filter_dropdown_option_ajax',
                    dataType: "html",
                    success: function (result) {
                        $("#" + divID).find('.criteria-div').html(result);
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    data: {
                        variable: variableValue
                    },
                    url: '<?= base_url(); ?>' + 'project/project_filter_dropdown_option_ajax',
                    dataType: "html",
                    success: function (result) {
                        $("#" + divID).find('.criteria-div').html(result);
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
            }
        } else {
            if (conditionValue == 2 || conditionValue == 4) {
                $("#" + divID).find(".criteria-dropdown").chosen("destroy");
                $("#" + divID).find(".criteria-dropdown").attr("multiple", "");
                $("#" + divID).find(".criteria-dropdown").chosen();
                $("#" + divID).find(".search-choice-close").trigger('click');
            } else {
                $("#" + divID).find(".criteria-dropdown").removeAttr('multiple');
                $("#" + divID).find(".criteria-dropdown").chosen("destroy");
                $("#" + divID).find(".criteria-dropdown").val('');
                $("#" + divID).find(".criteria-dropdown").chosen();
                $("#" + divID).find(".search-choice-close").trigger('click');
            }
        }
    }
    function addProjectFilterRow() {
        var random = Math.floor((Math.random() * 999) + 1);
        var clone = '<div class="filter-div row m-b-20" id="clone-' + random + '">' + content + '<div class="col-sm-1 text-center p-l-0"><a href="javascript:void(0);" onclick="removeProjectFilterRow(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>';
        $('.filter-inner').append(clone);

        $.each(variableArray, function (key, value) {
            $("#clone-" + random + " .variable-dropdown option[value='" + value + "']").remove();
        });
        $("div.add_filter_div:not(:first)").remove();
        $("#clone-" + random).find(".variable-dropdown").removeAttr('readonly').attr("style", "pointer-events: block;");
        ;
        $("#clone-" + random).find(".condition-dropdown").removeAttr('disabled');
        $("#clone-" + random).find(".criteria-dropdown").html("<option value=''>All Criteria</option>");
        $("#clone-" + random).find(".criteria-dropdown").removeAttr('readonly');
    }
    function removeProjectFilterRow(random) {
        var divID = 'clone-' + random;
        var variableDropdownValue = $("#clone-" + random + " .variable-dropdown option:selected").val();
        var index = variableArray.indexOf(variableDropdownValue);
        variableArray.splice(index, 1);
        $("#" + divID).remove();
    }
    function reflactProjectFilterWithCategory(category, requestType = '') {
        clearProjectFilter();
        variableArray = [];
        elementArray = [];
        $("select.variable-dropdown:first").val(12).attr('readonly', 'readonly').attr("style", "pointer-events: none;");
        var statusArray = category.split('-');
        $('select.criteria-dropdown:first').empty().html('<option value="' + statusArray[0] + '">' + statusArray[1] + '</option>').attr({'readonly': true, 'name': 'criteria_dropdown[template_cat_id][]'});
        $("select.criteria-dropdown:first").trigger("chosen:updated");
        $("select.condition-dropdown:first").val(1).attr('disabled', true);
        elementArray.push($("select.condition-dropdown:first").val(1));
        variableArray.push(12);
        if (requestType != '') {
            addProjectFilterRow();
            $("select.variable-dropdown:eq(1)").val(8);
            var requestTypeArray = requestType.split('-');
            $('select.criteria-dropdown:eq(1)').empty().html('<option value="' + requestTypeArray[0] + '">' + requestTypeArray[1] + '</option>').attr({'readonly': true, 'name': 'criteria_dropdown[tracking][]'});
            $("select.criteria-dropdown:eq(1)").trigger("chosen:updated");
            $("select.condition-dropdown:eq(1)").val(1).attr('disabled', true);
            elementArray.push($("select.condition-dropdown:eq(1)"));
            variableArray.push(8);
        }
        if (statusArray[1] == 'bookkeeping') {
            $('#cat').val(statusArray[0] + '-' + statusArray[1]);
            $('#bookkeeping_btn_clear_filter').show();
            $("#project_add_filter").text('Show Filter');
        } else if (statusArray[1] == 'tax_returns') {
            $('#cat').val(statusArray[0] + '-' + statusArray[1]);
            $('#tax_btn_clear_filter').show();
            $("#project_add_filter").text('Show Filter');
        } else if (statusArray[1] == 'sales_tax') {
            $('#cat').val(statusArray[0] + '-' + statusArray[1]);
            $('#sales_btn_clear_filter').show();
            $("#project_add_filter").text('Show Filter');
        } else if (statusArray[1] == 'annual_report') {
            $('#cat').val(statusArray[0] + '-' + statusArray[1]);
            $('#annual_btn_clear_filter').show();
            $("#project_add_filter").text('Show Filter');
    }
//        $("#due_year").val(new Date().getFullYear());
    }
    function clearProjectFilter() {
        $('#btn_clear_filter').css('display', 'none');
        $(".criteria-dropdown").trigger("chosen:updated");
        $('form#filter-form').children('div.filter-inner').children('div.filter-div').not(':first').remove();
        $("#project_add_filter").text('Show Filter');
    }
    function change_project_year(year) {
        var category = $('#cat').val();
        var statusArray = category.split('-');
        $("#due_year").val(year);
        var month = $('#due_month').val();
        $('#due_month').val(month)
        reflactProjectFilterWithCategory(category, '');
        go('Project/index/' + category + '/' + statusArray[0] + '/' + year + '/' + month);
//        go('Project/index/' + 'n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/' + statusArray[0] + '/' + year + '/' + category + '/' + month);
    }
    function change_project_month(month) {
        var category = $('#cat').val();
        var statusArray = category.split('-');
        var year = $("#due_year").val();
        $("#due_year").val(year);
        $('#due_month').val(month)
        reflactProjectFilterWithCategory(category, '');
        go('Project/index/' + category +'/' + statusArray[0]+ '/' + year + '/' + month);
//        go('Project/index/' + 'n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/n' + '/' + statusArray[0] + '/' + year + '/' + category + '/' + month);
    }
</script> 