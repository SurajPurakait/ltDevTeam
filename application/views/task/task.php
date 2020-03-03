<?php
$user_info = $this->session->userdata('staff_info');
$user_department = $user_info['department'];
$user_type = $user_info['type'];
$role = $user_info['role'];
?>
<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form"  method="post" onsubmit="taskFilter()">
                                    <div class="form-group filter-inner">
                                        <div class="row">
                                            <!--                                            <div class="col-xs-2 col-sm-3 pull-left">
                                                                                            <button type="button" class="btn btn-primary"  onclick="CreateProjectModal('add', '');" ><i class="fa fa-plus"></i> &nbsp;Create Project</button>
                                                                                        </div>
                                                                                        <div class="col-xs-2 col-sm-3 pull-left">
                                                                                            <button type="button" class="btn btn-success"  onclick="taskDashboard(  );" >&nbsp;Task Dahsboard</button>
                                                                                        </div>-->
                                        </div>
                                        <div class="filter-div m-b-20 row" id="original-filter">                                           
                                            <div class="col-sm-3 m-t-10">
                                                <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="changeVariableTask(this)">
                                                    <option value="">All Variable</option>
                                                    <?php foreach ($filter_element_list as $key => $fel): ?>
                                                        <option value="<?= $key ?>"><?= $fel ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 m-t-10">
                                                <select class="form-control condition-dropdown" name="condition_dropdown[]" onchange="changeTaskCondition(this)">
                                                    <option value="">All Condition</option>
                                                    <option value="1">Is</option>
                                                    <option value="2">Is in the list</option>
                                                    <option value="3">Is not</option>
                                                    <option value="4">Is not in the list</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 m-t-10 criteria-div">
                                                <select class="form-control criteria-dropdown chosen-select" placeholder="All Criteria" name="criteria_dropdown[][]">
                                                    <option value="">All Criteria</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 m-t-10 p-l-0">
                                                <div class="add_filter_div text-right">
                                                    <a href="javascript:void(0);" onclick="addTaskFilterRow()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Filter">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> 
                                                    </a>
                                                </div>  
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">                        
                                            <div class="">
                                                <button class="btn btn-success" type="button" onclick="taskFilter()">Apply Filter</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="m-t-5 m-r-5"><span class="text-success" style="display: none;" id="clear_filter">By Me - Started &nbsp; </span><a href="javascript:void(0);" onclick="loadTaskDashboard('', '', '', '', '', '', '', '', '', '', '', '', '', 1);" class="btn btn-ghost" id="task_btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a></h4>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <th class="text-center">Not Started</th>
                                            <th class="text-center">Started</th>
                                            <th class="text-center">Completed</th> 
                                            <!-- <th class="text-center">Canceled</th> -->
                                            <th class="text-center">SOS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="byme">
                                            <th>Requested By Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-0">
                                                    <span class="label label-warning" id="requested_by_me_new" onclick="loadTaskDashboard(0, 'byme', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('byme', '0'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-1">
                                                    <span class="label label-warning" id="requested_by_me_started" onclick="loadTaskDashboard(1, 'byme', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('byme', '1'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                    <span class="label label-warning" id="requested_by_me_completed" onclick="loadTaskDashboard(2, 'byme', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('byme', '2'); ?></span>
                                                </a>
                                            </td> 
                                            <!-- <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-7">
                                                    <span class="label label-warning" id="requested_by_me_canceled" onclick="loadTaskDashboard(7, 'byme', '', '', '', '');"><?//= action_list('byme', 7); ?></span>
                                                </a>
                                            </td> -->
                                            <td class="text-center">
                                                <a class="filter-button" onclick="sos_filter_task('projects', 'byme');" title="By Me"><span class="label label-warning label-byme"><?= sos_dashboard_count('projects', 'byme'); ?></span></a>
                                            </td>
                                        </tr>
                                        <tr id="tome">
                                            <th>Requested To Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-0">
                                                    <span class="label label-warning" id="requested_to_me_new" onclick="loadTaskDashboard(0, 'tome', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('tome', '0'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-1">
                                                    <span class="label label-warning" id="requested_to_me_started" onclick="loadTaskDashboard(1, 'tome', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('tome', '1'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-2">
                                                    <span class="label label-warning" id="requested_to_me_completed" onclick="loadTaskDashboard(2, 'tome', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('tome', '2'); ?></span>
                                                </a>
                                            </td>
                                            <!-- <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-7">
                                                    <span class="label label-warning" id="requested_to_me_canceled" onclick="loadTaskDashboard(7, 'tome', '', '', '', '');"><?//= action_list('tome', 7); ?></span>
                                                </a>
                                            </td> -->
                                            <td class="text-center">
                                                <a class="filter-button" onclick="sos_filter_project('projects', 'tome');" title="To Me"><span class="label label-warning label-tome"><?= sos_dashboard_count('projects', 'tome'); ?></span></a>
                                            </td>
                                        </tr>
                                        <?php if ($user_type == 1 || ($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)): ?>
                                            <tr id="byother">
                                                <th>Requested By Other</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-0">
                                                        <span class="label label-warning" id="requested_by_other_new" onclick="loadTaskDashboard(0, 'byother', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('byother', '0'); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-1">
                                                        <span class="label label-warning" id="requested_by_other_started" onclick="loadTaskDashboard(1, 'byother', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('byother', '1'); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-2">
                                                        <span class="label label-warning" id="requested_by_other_completed" onclick="loadTaskDashboard(2, 'byother', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('byother', '2'); ?></span>
                                                    </a>
                                                </td> 
    <!--                                                 <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-7">
                                                        <span class="label label-warning" id="requested_by_other_canceled" onclick="loadTaskDashboard(7, 'byother', '', '', '', '');"><?//= task_list('byother', 7); ?></span>
                                                    </a>
                                                </td> 
                                                 <td class="text-center">
                                                   <a class="filter-button" onclick="sos_filter('action', 'byother');" title="By Other"><span class="label label-warning label-byother"><?//= sos_dashboard_count('action', 'byother'); ?></span></a>
                                                </td> -->
                                            </tr>
                                            <?php
                                        endif;
                                        if (($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)):
                                            ?>
                                            <tr id="toother">
                                                <th>Requested To Other</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-0">
                                                        <span class="label label-warning" id="requested_to_other_new" onclick="loadTaskDashboard(0, 'toother', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('toother', '0'); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-1">
                                                        <span class="label label-warning" id="requested_to_other_started" onclick="loadTaskDashboard(1, 'toother', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('toother', '1'); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-2">
                                                        <span class="label label-warning" id="requested_to_other_completed" onclick="loadTaskDashboard(2, 'toother', '', '', '', '', '', '', '', '', '', '', '', 1);"><?= task_list('toother', '2'); ?></span>
                                                    </a>
                                                </td> 
    <!--                                                 <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-7">
                                                        <span class="label label-warning" id="requested_to_other_canceled" onclick="loadTaskDashboard(7, 'toother', '', '', '', '');"><?//= action_list('toother', 7); ?></span>
                                                    </a>
                                                </td> -->
                                            </tr>
                                        <?php endif; ?>
<!--                                        <tr id="mytask">
                                        <th>My Task</th>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="filter-button" id="filter-mytask-0">
                                                <span class="label label-warning" id="requested_mytask_new" onclick="loadTaskDashboard(0, 'mytask', '', '', '', '');"><?//= task_list('mytask', 0); ?></span>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="filter-button" id="filter-mytask-1">
                                                <span class="label label-warning" id="requested_mytask_started" onclick="loadTaskDashboard(1, 'mytask', '', '', '', '');"><?//= task_list('mytask', 1); ?></span>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="filter-button" id="filter-mytask-3">
                                                <span class="label label-warning" id="requested_mytask_completed" onclick="loadTaskDashboard(2, 'mytask', '', '', '', '');"><?//= task_list('mytask', 2); ?></span>
                                            </a>
                                        </td>
                                         <td class="text-center">
                                            <a href="javascript:void(0)" class="filter-button" id="filter-mytask-7">
                                                <span class="label label-warning" id="requested_mytask_canceled" onclick="loadTaskDashboard(7, 'mytask', '', '', '', '');"><?//= action_list('mytask', 7); ?></span>
                                            </a>
                                        </td> 
                                    </tr>-->
<!--                                        <tr id="unassigned">
                                        <th>Unassigned</th>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="filter-button" id="filter-unassigned-0">
                                                <span class="label label-warning" id="unassigned_new" onclick="loadTaskDashboard(0, 'unassigned', '', '', '', '');"><?//= action_list('unassigned', 0); ?></span>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="filter-button" id="filter-unassigned-1">
                                                <span class="label label-warning" id="unassigned_started" onclick="loadTaskDashboard(1, 'unassigned', '', '', '', '');"><?//= action_list('unassigned', 1); ?></span>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="filter-button" id="filter-unassigned-2">
                                                <span class="label label-warning" id="unassigned_completed" onclick="loadTaskDashboard(2, 'unassigned', '', '', '', '');"><?//= action_list('unassigned', 2); ?></span>
                                            </a>
                                        </td>
                                    </tr>-->
                                    </tbody>
                                </table>
                            </div>
                            <div class="row m-r-20">
                                <!-- <div class="col-sm-4 col-xs-12">
                                    <a class="btn notification-btn" onclick="sos_filter('action', 'tome');" title="To Me">SOS To Me <span class="label label-danger label-tome"><?//= sos_dashboard_count('action', 'tome'); ?></span></a>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <a class="btn notification-btn" onclick="sos_filter('action', 'byme');" title="By Me">SOS By Me <span class="label label-success label-byme"><?//= sos_dashboard_count('action', 'byme'); ?></span></a>
                                </div> -->
                                <!--                                <div class="col-sm-4 col-xs-12">
                                                                    <a class="btn notification-btn" onclick="loadTaskDashboard(0, 'unassigned', '', '', '', '');" title="By Me">Unassigned <span class="label label-success label-byme"><? action_list('unassigned', 0); ?></span></a>
                                                                </div>-->
                                <!--                                <div class="col-sm-4 col-xs-12">
                                                                    <a class="btn notification-btn" id="notification-project-button" onclick="openProjectNotificationModal();" href="javascript:void(0);" title="Project Notifications">Notifications <span class="label label-danger"><?= get_project_notifications_count(); ?></span></a>
                                                                </div>-->
                            </div>
                            <div class="row">
                                <div class="col-sm-12 p-t-5">
                                    <?php
                                    $sos_notification_count = sos_dashboard_count_for_reply('projects', 'tome');
                                    if ($sos_notification_count != 0) {
                                        ?>
                                        <span class="label label-danger p-5" style="display: inline-block;padding: 0px 5px;">
                                            <h4 style="font-size: 12px;"> <i class="fa fa-bell"></i>
                                                <?php if ($sos_notification_count == 1) { ?>    
                                                    You have received <?= sos_dashboard_count_for_reply('projects', 'tome'); ?> new reply for your sos notification.
                                                <?php } else { ?>
                                                    You have received <?= sos_dashboard_count_for_reply('projects', 'tome'); ?> new replies for your sos notification.
                                                <?php } ?>
                                            </h4>
                                        </span>
                                        <a href="javascript:void(0);" onclick="this.parentElement.style.display = 'none';" class="m-l-5"><i class="fa fa-times text-danger" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">

                    </div>

                    <hr class="hr-line-dashed  m-t-5 m-b-5">
                    <div id="task_dashboard_div">
                        <!--                        <div class="clearfix">
                                                <h2 class="text-primary pull-left"><?php // echo (!empty($task_list)) ? count($task_list) : '';  ?> Results found</h2><div class="pull-right text-right p-t-5">
                                                    <div class="dropdown" style="display: inline-block;">
                                                        <a href="javascript:void(0);" id="sort-by-dropdown" data-toggle="dropdown" class="dropdown-toggle btn btn-success">Sort By <span class="caret"></span></a>
                                                        <ul class="dropdown-menu">
                                                            <li><a id="id-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.id')">Project ID</a></li>
                                                            <li><a id="project_template-val" href="javascript:void(0);" onclick="sort_project_dashboard('temp.project_template')">Project Template</a></li>
                                                            <li><a id="pattern-val" href="javascript:void(0);" onclick="sort_project_dashboard('rec.pattern')">Pattern</a></li> 
                                                            <li><a id="client_type-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.client_type')">Client Type</a></li>
                                                            <li><a id="client_id-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.client_id')">Client</a></li>
                                                            <li><a id="responsible-val" href="javascript:void(0);" onclick="sort_project_dashboard('temp.responsible')">Responsible</a></li>
                                                            <li><a id="assign_to-val" href="javascript:void(0);" onclick="sort_project_dashboard('temp.assign_to')">Assign To</a></li>
                                                            <li><a id="status-val" href="javascript:void(0);" onclick="sort_project_dashboard('temp.status')">Tracking</a></li>
                                                            <li><a id="created_at-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.created_at')">Creation Date</a></li>
                                                            <li><a id="due_date-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.due_date')">Due Date</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="sort_type_div" style="display: none;">
                                                        <a href="javascript:void(0);" id="sort-asc" onclick="sort_project_dashboard('', 'DESC')" class="btn btn-success" data-toggle="tooltip" title="Ascending Order" data-placement="top"><i class="fa fa-sort-amount-asc"></i></a>
                                                        <a href="javascript:void(0);" id="sort-desc" onclick="sort_project_dashboard('', 'ASC')" class="btn btn-success" data-toggle="tooltip" title="Descending Order" data-placement="top"><i class="fa fa-sort-amount-desc"></i></a>
                                                        <a href="javascript:void(0);" onclick="projectFilter();" class="btn btn-white text-danger" data-toggle="tooltip" title="Remove Sorting" data-placement="top"><i class="fa fa-times"></i></a>
                                                    </div>
                                                </div>
                                                </div>-->

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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
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
                        <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
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
<!--task note modal-->
<div class="modal fade" id="showProjectTaskNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
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
                        <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
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
<!--end task note modal-->
<div id="projectModal" class="modal fade" role="dialog" data-backdrop="static"></div>
<!-- Sos Modal -->
<div class="modal fade" id="showSos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">SOS</h4>
            </div>
            <div id="notes-modal-body" class="modal-body p-b-0">

            </div>
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
                <button type="button" class="btn btn-primary" onclick="updateProjectStatusinner('task')">Save changes</button>
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
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    loadTaskDashboard('<?= $status; ?>', '<?= $request_type; ?>', '<?= $priority; ?>', '<?= $office_id; ?>', '<?= $department_id; ?>', '', '', '', '', '', '', '', '', 1);
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
        var txt = 'Tracking Task #' + project_id+'-'+task_order;
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
            $("#changeStatusinner #rad0").prop('checked', false).attr('disabled',true);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad5").prop('checked', false);
        } else if (status == 2) {
            $("#changeStatusinner #rad2").prop('checked', true);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false).attr('disabled',true);
            $("#changeStatusinner #rad3").prop('checked', false).attr('disabled',true);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad5").prop('checked', false);
        }
        else if (status == 3) {
            $("#changeStatusinner #rad3").prop('checked', true);
            $("#changeStatusinner #rad5").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false).attr('disabled',true);
        }
        else if (status == 4) {
            $("#changeStatusinner #rad4").prop('checked', true);
            $("#changeStatusinner #rad5").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false).attr('disabled',true);
            $("#changeStatusinner #rad2").prop('checked', false).attr('disabled',true);
            $("#changeStatusinner #rad1").prop('checked', false).attr('disabled',true);
            $("#changeStatusinner #rad0").prop('checked', false).attr('disabled',true);
        }
        else if (status == 5) {
            $("#changeStatusinner #rad5").prop('checked', true);
            $("#changeStatusinner #rad4").prop('checked', true).attr('disabled',true);
            $("#changeStatusinner #rad3").prop('checked', false).attr('disabled',true);
            $("#changeStatusinner #rad2").prop('checked', false).attr('disabled',true);
            $("#changeStatusinner #rad1").prop('checked', false).attr('disabled',true);
            $("#changeStatusinner #rad0").prop('checked', false).attr('disabled',true);
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
    function updateProjectStatusinner(type = '') {
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
//                alert(result);return false;
                if (result.trim() != 0) {
                    $("#changeStatusinner").modal('hide');
//                    return false;
                    //swal("Success!", "Successfully updated!", "success");
                    if (type == 'task') {
                        goURL(base_url + 'task');
                    } else {
                        goURL(base_url + 'project');
                    }
                }
            }
        });
    }
    var content = $(".filter-div").html();
    var variableArray = [];
    var elementArray = [];
    function changeVariableTask(element) {
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
        if (variableValue == 4) {
            var checkOfficeValue = variableArray.includes('3');
            if (checkOfficeValue == true) {
                officeValue = $("select[name='criteria_dropdown[office][]']").val();
            }
        }
        $.ajax({
            type: "POST",
            data: {
                variable: variableValue,
                office: officeValue
            },
            url: base_url + 'task/task_filter_dropdown_option_ajax',
            dataType: "html",
            success: function (result) {
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
    function changeTaskCondition(element) {
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
                    url: base_url + 'task/task_filter_dropdown_option_ajax',
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
                    url: '<?//= base_url(); ?>' + 'task/task_filter_dropdown_option_ajax',
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
    function addTaskFilterRow() {
        var random = Math.floor((Math.random() * 999) + 1);
        var clone = '<div class="filter-div row m-b-20" id="clone-' + random + '">' + content + '<div class="col-sm-1 text-right p-l-0"><a href="javascript:void(0);" onclick="removeTaskFilterRow(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>';
        $('.filter-inner').append(clone);
        $.each(variableArray, function (key, value) {
            $("#clone-" + random + " .variable-dropdown option[value='" + value + "']").remove();
        });
        $("div.add_filter_div:not(:first)").remove();
    }
    function removeTaskFilterRow(random) {
        var divID = 'clone-' + random;
        var variableDropdownValue = $("#clone-" + random + " .variable-dropdown option:selected").val();
        var index = variableArray.indexOf(variableDropdownValue);
        variableArray.splice(index, 1);
        $("#" + divID).remove();
    }
</script>