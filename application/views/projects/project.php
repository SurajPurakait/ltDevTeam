<?php
$user_info = staff_info();
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
              <form name="filter_form" id="filter-form"  method="post" onsubmit="projectFilter()">
                <div class="form-group filter-inner">
                  <div class="row">
                    <div class="col-xs-12">
                      <?php if($user_type!=3){ ?>
                      <button type="button" class="btn btn-primary"  onclick="CreateProjectModal('add', '');" ><i class="fa fa-plus"></i> &nbsp;Create Project</button>
                      <?php } ?>
                      <button type="button" class="btn btn-success"  onclick="taskDashboard();" >&nbsp;Task Dahsboard</button>
                    </div>
                  </div>
                  <div class="filter-div m-b-20 row" id="original-filter">
                    <div class="col-sm-3 m-t-10">
                      <?php asort($filter_element_list); ?>
                      <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="changeVariableProject(this)">
                        <option value="">All Variable</option>
                        <?php foreach ($filter_element_list as $key => $fel): ?>
                        <option value="<?= $key ?>">
                        <?= $fel ?>
                        </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-sm-4 m-t-10">
                      <select class="form-control condition-dropdown" name="condition_dropdown[]" onchange="changeCondition(this)">
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
                      <div class="add_filter_div text-right"> <a href="javascript:void(0);" onclick="addProjectFilterRow()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Filter"> <i class="fa fa-plus" aria-hidden="true"></i> </a> </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="">
                      <button class="btn btn-success" type="button" onclick="projectFilter()">Apply Filter</button>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <h4 class="m-t-5 m-r-5"><span class="text-success" style="display: none;" id="clear_filter">By Me - Started &nbsp; </span><a href="javascript:void(0);" onclick="loadProjectDashboard('', '', '', '', '', '', '', '', '', '', '', '', '', 1);" class="btn btn-ghost" id="btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a></h4>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- summary box section -->
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
                    <th>By Me</th>
                    <td class="text-center"><a href="javascript:void(0)" class="filter-button" id="filter-byme-0"> <span class="label label-success" id="requested_by_me_new" onclick="loadProjectDashboard(0, 'byme', '', '', '', '', '', '', '', '', '', '', '', 1);">
                      <?= project_list('byme', 0); ?>
                      </span> </a></td>
                    <td class="text-center"><a href="javascript:void(0)" class="filter-button" id="filter-byme-1"> <span class="label label-warning" id="requested_by_me_started" onclick="loadProjectDashboard(1, 'byme', '', '', '', '', '', '', '', '', '', '', '', 1);">
                      <?= project_list('byme', 1); ?>
                      </span> </a></td>
                    <td class="text-center"><a href="javascript:void(0)" class="filter-button" id="filter-byme-2"> <span class="label bg-purple" id="requested_by_me_completed" onclick="loadProjectDashboard(2, 'byme', '', '', '', '', '', '', '', '', '', '', '', 1);">
                      <?= project_list('byme', 2); ?>
                      </span> </a></td>
                    <!-- <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-7">
                                                    <span class="label label-warning" id="requested_by_me_canceled" onclick="loadProjectDashboard(7, 'byme', '', '', '', '');"><?//= action_list('byme', 7); ?></span>
                                                </a>
                                            </td> -->
                    <td class="text-center"><a class="filter-button" onclick="sos_filter_project('projects', 'byme');" title="By Me"><span class="label label-danger label-byme">
                      <?= sos_dashboard_count('projects', 'byme'); ?>
                      </span></a></td>
                  </tr>
                  <tr id="tome">
                    <th>To Me</th>
                    <td class="text-center"><a href="javascript:void(0)" class="filter-button" id="filter-tome-0"> <span class="label label-success" id="requested_to_me_new" onclick="loadProjectDashboard(0, 'tome', '', '', '', '', '', '', '', '', '', '', '', 1);">
                      <?= project_list('tome', 0); ?>
                      </span> </a></td>
                    <td class="text-center"><a href="javascript:void(0)" class="filter-button" id="filter-tome-1"> <span class="label label-warning" id="requested_to_me_started" onclick="loadProjectDashboard(1, 'tome', '', '', '', '', '', '', '', '', '', '', '', 1);">
                      <?= project_list('tome', 1); ?>
                      </span> </a></td>
                    <td class="text-center"><a href="javascript:void(0)" class="filter-button" id="filter-tome-2"> <span class="label bg-purple" id="requested_to_me_completed" onclick="loadProjectDashboard(2, 'tome', '', '', '', '', '', '', '', '', '', '', '', 1);">
                      <?= project_list('tome', 2); ?>
                      </span> </a></td>
                    <!-- <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-7">
                                                    <span class="label label-warning" id="requested_to_me_canceled" onclick="loadProjectDashboard(7, 'tome', '', '', '', '');"><?//= action_list('tome', 7); ?></span>
                                                </a>
                                            </td> -->
                    <td class="text-center"><a class="filter-button" onclick="sos_filter_project('projects', 'tome');" title="To Me"><span class="label label-danger label-tome">
                      <?= sos_dashboard_count('projects', 'tome'); ?>
                      </span></a></td>
                  </tr>
                  <?php // if ($user_type == 1 || ($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)): ?>
                  <!--                                            <tr id="byother">
                                                <th>Requested By Other</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-0">
                                                        <span class="label label-warning" id="requested_by_other_new" onclick="loadProjectDashboard(0, 'byother', '', '', '', '');"><?//= action_list('byother', 0); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-1">
                                                        <span class="label label-warning" id="requested_by_other_started" onclick="loadProjectDashboard(1, 'byother', '', '', '', '');"><?//= action_list('byother', 1); ?></span>
                                                    </a>
                                                </td>
                                                 <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-2">
                                                        <span class="label label-warning" id="requested_by_other_completed" onclick="loadProjectDashboard(2, 'byother', '', '', '', '');"><?//= action_list('byother', 2); ?></span>
                                                    </a>
                                                </td> 
                                                 <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-7">
                                                        <span class="label label-warning" id="requested_by_other_canceled" onclick="loadProjectDashboard(7, 'byother', '', '', '', '');"><?//= action_list('byother', 7); ?></span>
                                                    </a>
                                                </td> 
                                                 <td class="text-center">
                                                   <a class="filter-button" onclick="sos_filter('action', 'byother');" title="By Other"><span class="label label-warning label-byother"><?//= sos_dashboard_count('action', 'byother'); ?></span></a>
                                                </td> 
                                            </tr>-->
                  <?php
//                                        endif;
                                        if ($user_type==1 || ($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)):
                                            ?>
                  <tr id="toother">
                    <th>Others</th>
                    <td class="text-center"><a href="javascript:void(0)" class="filter-button" id="filter-toother-0"> <span class="label label-success" id="requested_to_other_new" onclick="loadProjectDashboard(0, 'toother', '', '', '', '', '', '', '', '', '', '', '', 1);">
                      <?= project_list('toother', 0); ?>
                      </span> </a></td>
                    <td class="text-center"><a href="javascript:void(0)" class="filter-button" id="filter-toother-1"> <span class="label label-warning" id="requested_to_other_started" onclick="loadProjectDashboard(1, 'toother', '', '', '', '', '', '', '', '', '', '', '', 1);">
                      <?= project_list('toother', 1); ?>
                      </span> </a></td>
                    <td class="text-center"><a href="javascript:void(0)" class="filter-button" id="filter-toother-2"> <span class="label bg-purple" id="requested_to_other_completed" onclick="loadProjectDashboard(2, 'toother', '', '', '', '', '', '', '', '', '', '', '', 1);">
                      <?= project_list('toother', 2); ?>
                      </span> </a></td>
                    <!--                                                 <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-7">
                                                        <span class="label label-warning" id="requested_to_other_canceled" onclick="loadProjectDashboard(7, 'toother', '', '', '', '');"><?//= action_list('toother', 7); ?></span>
                                                    </a>
                                                </td> --> 
                  </tr>
                  <?php endif; ?>
                  <!--                                        <tr id="mytask">
                                            <th>My Task</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-0">
                                                    <span class="label label-warning" id="requested_mytask_new" onclick="loadProjectDashboard(0, 'mytask', '', '', '', '');"><?= project_list('mytask', 0); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-1">
                                                    <span class="label label-warning" id="requested_mytask_started" onclick="loadProjectDashboard(1, 'mytask', '', '', '', '');"><?= project_list('mytask', 1); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-3">
                                                    <span class="label label-warning" id="requested_mytask_completed" onclick="loadProjectDashboard(2, 'mytask', '', '', '', '');"><?= project_list('mytask', 2); ?></span>
                                                </a>
                                            </td>
                                             <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-7">
                                                    <span class="label label-warning" id="requested_mytask_canceled" onclick="loadProjectDashboard(7, 'mytask', '', '', '', '');"><?//= action_list('mytask', 7); ?></span>
                                                </a>
                                            </td> 
                                        </tr>--> 
                  <!--                                        <tr id="unassigned">
                                            <th>Unassigned</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-unassigned-0">
                                                    <span class="label label-warning" id="unassigned_new" onclick="loadProjectDashboard(0, 'unassigned', '', '', '', '');"><?//= action_list('unassigned', 0); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-unassigned-1">
                                                    <span class="label label-warning" id="unassigned_started" onclick="loadProjectDashboard(1, 'unassigned', '', '', '', '');"><?//= action_list('unassigned', 1); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-unassigned-2">
                                                    <span class="label label-warning" id="unassigned_completed" onclick="loadProjectDashboard(2, 'unassigned', '', '', '', '');"><?//= action_list('unassigned', 2); ?></span>
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
                                                                    <a class="btn notification-btn" onclick="loadProjectDashboard(0, 'unassigned', '', '', '', '');" title="By Me">Unassigned <span class="label label-success label-byme"><? action_list('unassigned', 0); ?></span></a>
                                                                </div>-->
              <div class="col-sm-4 col-xs-12"> <a class="btn notification-btn" id="notification-project-button" onclick="openProjectNotificationModal();" href="javascript:void(0);" title="Project Notifications">Notifications <span class="label label-danger">
                <?= get_project_notifications_count(); ?>
                </span></a> </div>
              <a class="pull-right" style="opacity:0.3;" title="Recurrence Cron" href="<?php echo base_url(); ?>project_recurrence_cron.php" target="_blank"><i class="fa fa-crosshairs fa-1x"></i></a> </div>
            <div class="row">
              <div class="col-sm-12 p-t-5">
                <?php
                                    $sos_notification_count = sos_dashboard_count_for_reply('projects', 'tome');
                                    if ($sos_notification_count != 0) {
                                        ?>
                <span class="label label-danger p-5" style="display: inline-block;padding: 0px 5px;">
                <h4 style="font-size: 12px;"> <i class="fa fa-bell"></i>
                  <?php if ($sos_notification_count == 1) { ?>
                  You have received
                  <?= sos_dashboard_count_for_reply('projects', 'tome'); ?>
                  new reply for your sos notification.
                  <?php } else { ?>
                  You have received
                  <?= sos_dashboard_count_for_reply('projects', 'tome'); ?>
                  new replies for your sos notification.
                  <?php } ?>
                </h4>
                </span> <a href="javascript:void(0);" onclick="this.parentElement.style.display = 'none';" class="m-l-5"><i class="fa fa-times text-danger" aria-hidden="true"></i></a>
                <?php } ?>
              </div>
            </div>
          </div>
          <!-- end summary box section --> 
        </div>
        <div class="clearfix"></div>
        <div class="row"> 
          
          <!-- Nav tabs -->
          <ul class="nav nav-tabs tab" role="tablist">
            <li role="presentation" class="active "><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Bookkeeping</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Tax Returns</a></li>
            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Sales Tax</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Annual Report</a></li>
          </ul>
          
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">1</div>
            <div role="tabpanel" class="tab-pane" id="profile">
            <div class="row">
              <div class="form-group col-md-4">
                <label class="col-lg-2 m-t-5 control-label">Year:</label>
                <div class="col-lg-10">
                  <input placeholder="2019" readonly="" class="form-control" type="text" value="2019" name="" id="" required="" title="">
                  <div class="errorMessage text-danger"></div>
                </div>
              </div>
                  </div>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-2 m-l-15">
                  <div class="alert-primar row">
                  <h3 class="col-md-3 m-t-15 f-s-14"> 1065 </h3>
                  <div class="col-md-4"> <span class="label label-primary label-block" style="width: 40px; display: inline-block; text-align: center;"> 23 </span> <span class="label label-warning label-block" style="width: 40px; display: inline-block; text-align: center;"> 42 </span> <span class="label label-success label-block" style="width: 40px; display: inline-block; text-align: center;"> 12 </span> </div>
                  <div class="col-md-5">
                    <div class="donut-widget "></div>
                  </div>
                </div></div>
                <div class="col-md-2 m-l-15">
                  <div class="alert-primar row">
                  <h3 class="col-md-3 m-t-15 f-s-14"> 1065 </h3>
                  <div class="col-md-4"> <span class="label label-primary label-block" style="width: 40px; display: inline-block; text-align: center;"> 23 </span> <span class="label label-warning label-block" style="width: 40px; display: inline-block; text-align: center;"> 42 </span> <span class="label label-success label-block" style="width: 40px; display: inline-block; text-align: center;"> 12 </span> </div>
                  <div class="col-md-5">
                    <div class="donut-widget-new "></div>
                  </div>
                </div></div>
             
            </div> </div>
            <div role="tabpanel" class="tab-pane" id="messages">3</div>
            <div role="tabpanel" class="tab-pane" id="settings">4</div>
          </div>
          <hr class="hr-line-dashed  m-t-5 m-b-5">
          <div id="action_dashboard_div"> 
            <!--                        <div class="clearfix">
                                                <h2 class="text-primary pull-left"><?php // echo (!empty($project_list)) ? count($project_list) : '';  ?> Results found</h2><div class="pull-right text-right p-t-5">
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
            
            <!--                        <div class="funkyradio">
                                                    <div class="funkyradio-success">
                                                        <input type="radio" name="radio" id="rad7" value="7"/>
                                                        <label for="rad7"><strong>Canceled</strong></label>
                                                    </div>
                                                </div>--> 
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
    loadProjectDashboard('<?= $status; ?>', '<?= $request_type; ?>', '<?= $template_id; ?>', '<?= $office_id; ?>', '<?= $department_id; ?>', '', '', '', '', '', '', '', '', 1);
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
    function change_project_status_inner(id, status, section_id) {
        openModal('changeStatusinner');
        var txt = 'Change Status of SubOrder id #' + id;
        $("#changeStatusinner .modal-title").html(txt);
        if (status == 0) {
            $("#changeStatusinner #rad0").prop('checked', true);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad7").prop('checked', false);
        } else if (status == 1) {
            $("#changeStatusinner #rad1").prop('checked', true);
            $("#changeStatusinner #rad0").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad7").prop('checked', false);
        } else if (status == 2) {
            $("#changeStatusinner #rad2").prop('checked', true);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
            $("#changeStatusinner #rad7").prop('checked', false);
        }
//        else if (status == 7) {
//            $("#changeStatusinner #rad7").prop('checked', true);
//            $("#changeStatusinner #rad2").prop('checked', false);
//            $("#changeStatusinner #rad1").prop('checked', false);
//            $("#changeStatusinner #rad0").prop('checked', false);
//        }
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
//                alert(result);return false;
                if (result.trim() != 0) {
//                    $("#changeStatusinner").modal('hide');
//                    return false;
                    //swal("Success!", "Successfully updated!", "success");
                    if(statusval==0){
                        var tracking = 'Not Started';
                        var trk_class = 'label label-success';
                    }else if(statusval==1){
                        var tracking = 'Started';
                        var trk_class = 'label label-yellow';
                    }else if(statusval==2){
                        var tracking = 'Completed';
                        var trk_class = 'label label-primary';
                    }
                    $("#trackinner-"+prosubid).removeClass().addClass(trk_class);
                    $("#trackinner-"+prosubid).parent('a').removeAttr('onclick');
                    $("#trackinner-"+prosubid).parent('a').attr('onclick','change_project_status_inner('+prosubid+','+statusval+', '+prosubid+');');
                    $("#trackinner-"+prosubid).html(tracking);
                    var projectid = $("#trackinner-"+prosubid).attr('projectid');
                    $("#trackouter-"+projectid).removeClass().addClass(trk_class);
                    $("#trackouter-"+projectid).html(tracking);
                    $('#changeStatusinner').modal('hide');
                }
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
    var content = $(".filter-div").html();
    var variableArray = [];
    var elementArray = [];
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
            }else{
               var officeValue = '';
            }
        }else{
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
        var clone = '<div class="filter-div row m-b-20" id="clone-' + random + '">' + content + '<div class="col-sm-1 text-right p-l-0"><a href="javascript:void(0);" onclick="removeProjectFilterRow(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>';
        $('.filter-inner').append(clone);
        $.each(variableArray, function (key, value) {
            $("#clone-" + random + " .variable-dropdown option[value='" + value + "']").remove();
        });
        $("div.add_filter_div:not(:first)").remove();
    }
    function removeProjectFilterRow(random) {
        var divID = 'clone-' + random;
        var variableDropdownValue = $("#clone-" + random + " .variable-dropdown option:selected").val();
        var index = variableArray.indexOf(variableDropdownValue);
        variableArray.splice(index, 1);
        $("#" + divID).remove();
    }
    
</script> 
<script>
        $(function () {
            DonutChart('.donut-widget', '55');
        });

        $(function () {
            DonutChart('.donut-widget-new', '55');
        });


        function DonutChart(element, size) {
            if (typeof d3 == 'undefined') {
                console.warn('Warning - d3.min.js is not loaded.');
                return;
            }

            // Initialize chart only if element exsists in the DOM
            if ($(element).length > 0) {


                // Basic setup
                // ------------------------------

                // Add data set
                var data = [
                    {
                        "browser": "Sec1",
                        "value": 14,
                        "color": "#1ab394"
                    }, {
                        "browser": "Sec2",
                        "value": 6,
                        "color": "#f8ac59"
                    }, {
                        "browser": "Sec3",
                        "value": 2,
                        "color": "#1c84c6"
                    }
                ];

                // Main variables
                var d3Container = d3.select(element),
                    distance = 2, // reserve 2px space for mouseover arc moving
                    radius = (size / 2) - distance,
                    sum = d3.sum(data, function (d) { return d.value; });



                // Tooltip
                // ------------------------------

                var tip = d3.tip()
                    .attr('class', 'd3-tip')
                    .offset([-10, 0])
                    .direction('e')
                    .html(function (d) {
                        return '<ul class="list-unstyled mb-1">' +
                            '<li>' + '<div class="font-size-base mb-1 mt-1">' + d.data.browser + ': ' + d.value + '</div>' + '</li>' +
                            '</ul>';
                    });


                // Create chart
                // ------------------------------

                // Add svg element
                var container = d3Container.append('svg').call(tip);

                // Add SVG group
                var svg = container
                    .attr('width', size)
                    .attr('height', size)
                    .append('g')
                    .attr('transform', 'translate(' + (size / 2) + ',' + (size / 2) + ')');



                // Construct chart layout
                // ------------------------------

                // Pie
                var pie = d3.layout.pie()
                    .sort(null)
                    .startAngle(Math.PI)
                    .endAngle(3 * Math.PI)
                    .value(function (d) {
                        return d.value;
                    });

                // Arc
                var arc = d3.svg.arc()
                    .outerRadius(radius)
                    .innerRadius(radius / 2);



                //
                // Append chart elements
                //

                // Group chart elements
                var arcGroup = svg.selectAll('.d3-arc')
                    .data(pie(data))
                    .enter()
                    .append('g')
                    .attr('class', 'd3-arc')
                    .style('stroke', '#fff')
                    .style('cursor', 'pointer');

                // Append path
                var arcPath = arcGroup
                    .append('path')
                    .style('fill', function (d) { return d.data.color; });

                // Add tooltip
                arcPath
                    .on('mouseover', function (d, i) {

                        // Transition on mouseover
                        d3.select(this)
                            .transition()
                            .duration(500)
                            .ease('elastic')
                            .attr('transform', function (d) {
                                d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                                var x = Math.sin(d.midAngle) * distance;
                                var y = -Math.cos(d.midAngle) * distance;
                                return 'translate(' + x + ',' + y + ')';
                            });
                    })

                    .on('mousemove', function (d) {

                        // Show tooltip on mousemove
                        tip.show(d)
                            .style('top', (d3.event.pageY - 40) + 'px')
                            .style('left', (d3.event.pageX + 30) + 'px');
                    })

                    .on('mouseout', function (d, i) {

                        // Mouseout transition
                        d3.select(this)
                            .transition()
                            .duration(500)
                            .ease('bounce')
                            .attr('transform', 'translate(0,0)');

                        // Hide tooltip
                        tip.hide(d);
                    });

                // Animate chart on load
                arcPath
                    .transition()
                    .delay(function (d, i) { return i * 500; })
                    .duration(500)
                    .attrTween('d', function (d) {
                        var interpolate = d3.interpolate(d.startAngle, d.endAngle);
                        return function (t) {
                            d.endAngle = interpolate(t);
                            return arc(d);
                        };
                    });
            }
        }
    </script>