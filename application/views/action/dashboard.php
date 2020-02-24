<?php
$user_info = staff_info();
$user_department = $user_info['department'];
$user_type = $user_info['type'];
$role = $user_info['role'];
//echo 'a'.$filter_val;
//echo 'b'.$fileter_request_type;die;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form"  method="post" onsubmit="actionFilter()">
                                    <div class="form-group filter-inner">
                                        <div class="row">
                                            <div class="m-b-10 pull-left col-md-10">
                                                <a class="btn btn-primary" href="<?= base_url("/action/home/create_action") ?>"><i class="fa fa-plus"></i> Create New Action</a>
                                            </div>
                                        </div>
                                        <div class="filter-div m-b-20 row" id="original-filter">                                           
                                            <div class="col-sm-3 m-t-10">
                                                <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="changeVariable(this)">
                                                    <option value="">All Variable</option>
                                                    <?php
                                                    asort($filter_element_list);
                                                    foreach ($filter_element_list as $key => $fel):
                                                       if ($fel != "Start Date"){ ?>
                                                        <option value="<?= $key ?>"><?= $fel ?></option>
                                                        
                                                    <?php } endforeach; ?>
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
                                                <div class="add_filter_div text-right">
                                                    <a href="javascript:void(0);" onclick="addFilterRow()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Filter">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> 
                                                    </a>
                                                </div>  
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-success" type="button" onclick="actionFilter()">Apply Filter</button>&nbsp;
                                            <a href="javascript:void(0);" onclick="loadActionDashboard('', 'byme_tome_task', '', '', '', '');" class="btn btn-ghost" id="btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a>
                                        </div>
                                        <!--                                        <div class="col-md-9">
                                                                                    <h4 class="m-r-5"><span class="text-success" style="display: none;" id="clear_filter">By Me - Started &nbsp; </span><a href="javascript:void(0);" onclick="loadActionDashboard('', 'byme_tome_task', '', '', '', '');" class="btn btn-ghost" id="btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a></h4>
                                                                                </div>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center">New</th>
                                            <th class="text-center">Started</th>
                                            <th class="text-center">Resolved</th> 
                                           <!-- <th class="text-center">Canceled</th> -->
                                            <th class="text-center">URGENT</th>
                                            <th class="text-center">SOS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="byme">
                                            <th>By Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-0">
                                                    <span class="label label-success" id="requested_by_me_new" onclick="reflactFilterWithSummery('0-New', 'byme-By ME');loadActionDashboard(0, 'byme', '', '', '', '');"><?= action_list('byme', '0'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-1">
                                                    <span class="label label-warning" id="requested_by_me_started" onclick="reflactFilterWithSummery('1-Started', 'byme-By ME');loadActionDashboard(1, 'byme', '', '', '', '');"><?= action_list('byme', '1'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                    <span class="label label-primary" id="requested_by_me_completed" onclick="reflactFilterWithSummery('6-Resolved', 'byme-By ME');loadActionDashboard(6, 'byme', '', '', '', '');"><?= action_list('byme', '6'); ?></span>
                                                </a>
                                            </td>
                                            <!-- <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-7">
                                                    <span class="label label-warning" id="requested_by_me_canceled" onclick="loadActionDashboard(7, 'byme', '', '', '', '');"><?//= action_list('byme', 7); ?></span>
                                                </a>
                                            </td> -->

                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                    <span class="label label-danger" id="requested_by_me_important" onclick="loadActionDashboard('', 'byme', '1', '', '', '');"><?= action_list('byme', '', '1', '', ''); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a class="filter-button" onclick="sos_filter('action', 'byme');" title="By Me"><span class="label label-danger label-byme" id="sos-byme"><?= sos_dashboard_count('action', 'byme'); ?></span></a>
                                            </td>
                                        </tr>
                                        <tr id="tome" class="action-row-border-bottom">
                                            <th>To Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-0">
                                                    <span class="label label-success" id="requested_to_me_new" onclick="reflactFilterWithSummery('0-New', 'tome-To ME');loadActionDashboard(0, 'tome', '', '', '', '');"><?= action_list('tome', '0'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-1">
                                                    <span class="label label-warning" id="requested_to_me_started" onclick="reflactFilterWithSummery('1-Started', 'tome-To ME');loadActionDashboard(1, 'tome', '', '', '', '');"><?= action_list('tome', '1'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-2">
                                                    <span class="label label-primary" id="requested_to_me_completed" onclick="reflactFilterWithSummery('6-Resolved', 'tome-To ME');loadActionDashboard(6, 'tome', '', '', '', '');"><?= action_list('tome', '6'); ?></span>
                                                </a>
                                            </td>
                                            <!-- <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-7">
                                                    <span class="label label-warning" id="requested_to_me_canceled" onclick="loadActionDashboard(7, 'tome', '', '', '', '');"><?//= action_list('tome', 7); ?></span>
                                                </a>
                                            </td> -->

                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                    <span class="label label-danger" id="requested_to_me_important" onclick="loadActionDashboard('', 'tome', '1', '', '', '');"><?= action_list('tome', '', '1', '', ''); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a class="filter-button" onclick="sos_filter('action', 'tome');" title="To Me"><span class="label label-danger label-tome" id="sos-tome"><?= sos_dashboard_count('action', 'tome'); ?></span></a>
                                            </td>
                                        </tr>

                                        <?php if ($user_type == 1 || ($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)): ?>
                                            <tr id="byother" style="background: #596571;">
                                                <!-- <th>By Others</th> -->
                                                <th>By My Team</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-0">
                                                        <span class="label label-success" id="requested_by_other_new" onclick="reflactFilterWithSummery('0-New', 'byother-By Others');loadActionDashboard(0, 'byother', '', '', '', '');"><?= action_list('byother', '0'); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-1">
                                                        <span class="label label-warning" id="requested_by_other_started" onclick="reflactFilterWithSummery('1-Started', 'byother-By Others');loadActionDashboard(1, 'byother', '', '', '', '');"><?= action_list('byother', '1'); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-2">
                                                        <span class="label label-primary" id="requested_by_other_completed" onclick="reflactFilterWithSummery('6-Resolved', 'byother-By Others');loadActionDashboard(6, 'byother', '', '', '', '');"><?= action_list('byother', '6'); ?></span>
                                                    </a>
                                                </td> 
                                                <!-- <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-7">
                                                        <span class="label label-warning" id="requested_by_other_canceled" onclick="loadActionDashboard(7, 'byother', '', '', '', '');"><?//= action_list('byother', 7); ?></span>
                                                    </a>
                                                </td> -->

                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                        <span class="label label-danger" id="requested_by_me_important" onclick="loadActionDashboard('', 'byother', '1', '', '', '');"><?= action_list('byother', '', '1', '', ''); ?></span>
                                                    </a>
                                                </td>
                                                <?php if (($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)): ?>
                                                    <td class="text-center">
                                                        <a class="filter-button" onclick="sos_filter('action', 'byother');" title="By Other"><span class="label label-danger label-byother"><?= sos_dashboard_count('action', 'byother'); ?></span></a>
                                                    </td> 
                                                <?php else: ?>
                                                    <td></td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php
                                        endif;
                                        if (($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)):
                                            ?>
                                            <tr id="toother" style="background: #596571;">
                                                <!-- <th>To Others</th> -->
                                                <th>To My Team</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-0">
                                                        <span class="label label-success" id="requested_to_other_new" onclick="reflactFilterWithSummery('0-New', 'toother-To Others');loadActionDashboard(0, 'toother', '', '', '', '');"><?= action_list('toother', '0'); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-1">
                                                        <span class="label label-warning" id="requested_to_other_started" onclick="reflactFilterWithSummery('1-Started', 'toother-To Others');loadActionDashboard(1, 'toother', '', '', '', '');"><?= action_list('toother', '1'); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-2">
                                                        <span class="label label-primary" id="requested_to_other_completed" onclick="reflactFilterWithSummery('6-Resolved', 'toother-To Others');loadActionDashboard(6, 'toother', '', '', '', '');"><?= action_list('toother', '6'); ?></span>
                                                    </a>
                                                </td> 
                                                <!-- <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-7">
                                                        <span class="label label-warning" id="requested_to_other_canceled" onclick="loadActionDashboard(7, 'toother', '', '', '', '');"><?//= action_list('toother', 7); ?></span>
                                                    </a>
                                                </td> -->

                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                        <span class="label label-danger" id="requested_by_me_important" onclick="loadActionDashboard('', 'toother', '1', '', '', '');"><?= action_list('toother', '', '1', '', ''); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a class="filter-button" onclick="sos_filter('action', 'toother');" title="By Other"><span class="label label-danger label-byother"><?= sos_dashboard_count('action', 'toother'); ?></span></a>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr id="mytask" class="action-row-border-top">
                                            <th>My Tasks</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-0">
                                                    <span class="label label-success" id="requested_mytask_new" onclick="reflactFilterWithSummery('0-New', 'mytask-My Tasks');loadActionDashboard(0, 'mytask', '', '', '', '');"><?= action_list('mytask', '0'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-1">
                                                    <span class="label label-warning" id="requested_mytask_started" onclick="reflactFilterWithSummery('1-Started', 'mytask-My Tasks');loadActionDashboard(1, 'mytask', '', '', '', '');"><?= action_list('mytask', '1'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-3">
                                                    <span class="label label-primary" id="requested_mytask_completed" onclick="reflactFilterWithSummery('6-Resolved', 'mytask-My Tasks');loadActionDashboard(6, 'mytask', '', '', '', '');"><?= action_list('mytask', '6'); ?></span>
                                                </a>
                                            </td>
                                            <!-- <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-7">
                                                    <span class="label label-warning" id="requested_mytask_canceled" onclick="loadActionDashboard(7, 'mytask', '', '', '', '');"><?//= action_list('mytask', 7); ?></span>
                                                </a>
                                            </td> -->

                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                    <span class="label label-danger" id="requested_by_me_important" onclick="loadActionDashboard('', 'mytask', '1', '', '', '');"><?= action_list('mytask', '', '1', '', ''); ?></span>
                                                </a>
                                            </td>
                                            <td></td>
                                        </tr>
<!--                                        <tr id="unassigned">
                                            <th>Unassigned</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-unassigned-0">
                                                    <span class="label label-warning" id="unassigned_new" onclick="loadActionDashboard(0, 'unassigned', '', '', '', '');"><?//= action_list('unassigned', 0); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-unassigned-1">
                                                    <span class="label label-warning" id="unassigned_started" onclick="loadActionDashboard(1, 'unassigned', '', '', '', '');"><?//= action_list('unassigned', 1); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-unassigned-2">
                                                    <span class="label label-warning" id="unassigned_completed" onclick="loadActionDashboard(2, 'unassigned', '', '', '', '');"><?//= action_list('unassigned', 2); ?></span>
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
                                <div class="col-sm-4 col-xs-12">
                                    <a class="btn notification-btn" onclick="loadActionDashboard(0, 'unassigned', '', '', '', '');" title="By Me">Unassigned <span class="label label-success label-byme"><?= action_list('unassigned', 0); ?></span></a>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <a class="btn notification-btn" id="notifcation-toggle" value='forme' onclick="openActionNotificationModal('');" href="javascript:void(0);" title="Action Notifications">Notifications <span class="label label-danger"><?= get_action_notifications_count('forme'); ?></span></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 p-t-5">
                                    <?php
                                    $sos_notification_count = sos_dashboard_count_for_reply('action', 'tome');
                                    if ($sos_notification_count != 0) {
                                        ?>
                                        <span class="label label-danger p-5" style="display: inline-block;padding: 0px 5px;">
                                            <h4 style="font-size: 12px;"> <i class="fa fa-bell"></i>
                                                <?php if ($sos_notification_count == 1) { ?>    
                                                    You have received <?= sos_dashboard_count_for_reply('action', 'tome'); ?> new reply for your sos notification.
                                                <?php } else { ?>
                                                    You have received <?= sos_dashboard_count_for_reply('action', 'tome'); ?> new replies for your sos notification.
                                                <?php } ?>
                                            </h4>
                                        </span>
                                        <a href="javascript:void(0);" onclick="this.parentElement.style.display = 'none';" class="m-l-5"><i class="fa fa-times text-danger" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="hr-line-dashed  m-t-5 m-b-5">
                    <div id="action_ajax_dashboard_div"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>
<!-- Modal -->
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" id="modal_note_form_update" onsubmit="update_action_notes();">
                <div id="notes-modal-body" class="modal-body p-b-0"></div>
                <div class="modal-body p-t-0 text-right">
                    <button type="button" id="update_note" onclick="update_action_notes();" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
            <form method="post" id="modal_note_form" onsubmit="add_action_notes();">
                <div class="modal-body">
                    <h4>Add New Note</h4>
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="action_note[]"  title="Action Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-action-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="actionid" id="actionid">
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="all_staffs" />
                    <button type="button" id="save_note" onclick="add_action_notes();" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
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
            <form method="post" id="sos_note_form" onsubmit="add_action_sos();">
                <div class="modal-body">
                    <!-- <h4 id="sos-title">Add New SOS</h4> -->
                    <div class="form-group" id="add_sos_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="sos_note" id="sos_note" title="SOS Note" required="" placeholder="ADD TEXT HERE"></textarea>
                            <div class="errorMessage text-danger"></div>
                        </div>
                        <!-- <a href="javascript:void(0)" class="text-success add-referreal-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a> -->
                    </div>
                    <input type="hidden" name="reference" id="reference" value="action">
                    <input type="hidden" name="refid" id="refid">
                    <input type="hidden" name="staffs" id="staffs">
                    <input type="hidden" name="serviceid" id="serviceid">
                    <input type="hidden" name="replyto" id="replyto" value="">
                    <input type="hidden" name="servreqid" id="servreqid" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_sos" onclick="add_action_sos();" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Sos Modal -->
<div class="modal fade" id="showFiles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Files</h4>
            </div>
            <div id="files-modal-body" class="modal-body"></div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="enlargeImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Image Preview</h4>
            </div>
            <div class="modal-body" id="image_preview"></div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="showuserdetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">User Info</h4>
            </div>
            <div id="user-details-modal-body" class="modal-body"></div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="showmsg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Message</h4>
            </div>
            <div id="msg-modal-body" class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="notification">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div id="msg-modal-body" class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="action_notification_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close m-t-2" data-dismiss="modal" aria-label="Close" onclick="closeNotificationModal()"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Notifications
                    <!--<div class="dropdown pull-right m-r-5">-->  
                    <a class="pull-right m-r-5" href="javascript:void(0);" title="Clear All" id="notification-clear" onclick="clearActionNotificationList('<?= sess('user_id'); ?>');"><i class="fa fa-trash-o"></i></a>
                    <a class="pull-right m-r-5 notification_title" href="javascript:void(0);" value='forother' id="notifcation-toggle" title="For Me" onclick="openActionNotificationModal('');"><i class="fa fa-exchange"></i></a>
                    <!--<span id="notification_modal_type">For Me</span>-->
                    <!--</div>-->
                </h4>
            </div>
            <div id="notification-modal-body" class="modal-body"></div>
            <div id="notification_clear"></div>
        </div>
    </div>
</div>
<script>
    reflactFilterWithSummery('<?= $filter_val ?>', '<?= $fileter_request_type ?>');
    loadActionDashboard('<?= $status; ?>', '<?= $request_type != '' ? $request_type : 'byme_tome_task'; ?>', '<?= $priority; ?>', '<?= $office_id; ?>', '<?= $department_id; ?>', '');
    
    $(document).ready(function () {
        $('.add-action-note').click(function () {
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
    var content = $(".filter-div").html();
    var variableArray = [];
    var elementArray = [];
    function addFilterRow() {
        var random = Math.floor((Math.random() * 999) + 1);
        var clone = '<div class="filter-div row m-b-20" id="clone-' + random + '">' + content + '<div class="col-sm-1 text-right p-l-0"><a href="javascript:void(0);" onclick="removeFilterRow(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>';
        $('.filter-inner').append(clone);
        $.each(variableArray, function (key, value) {
            $("#clone-" + random + " .variable-dropdown option[value='" + value + "']").remove();
        });
        $("div.add_filter_div:not(:first)").remove();
    }

    function removeFilterRow(random) {
        var divID = 'clone-' + random;
        var variableDropdownValue = $("#clone-" + random + " .variable-dropdown option:selected").val();
        var index = variableArray.indexOf(variableDropdownValue);
        variableArray.splice(index, 1);
        $("#" + divID).remove();
    }
    function changeVariable(element) {
        var divID = $(element).parent().parent().attr('id');
        var variableValue = $(element).children("option:selected").val();
        // alert(variableValue);return false;
        var checkElement = elementArray.includes(element);
        var officeValue = '';
        if (checkElement == true) {
            variableArray.pop();
            variableArray.push(variableValue);
        } else {
            elementArray.push(element);
            variableArray.push(variableValue);
        }

        if (variableValue == 8) {
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
            url: '<?= base_url(); ?>' + 'action/home/filter_dropdown_option_ajax',
            dataType: "html",
            success: function (result) {
                // alert(result);return false;
                $("#" + divID).find('.criteria-div').html(result);
                $(".chosen-select").chosen();
                $("#" + divID).find('.condition-dropdown').removeAttr('disabled').val('');
//                if (variableValue == 13) {
//                    $("#" + divID).find('.condition-dropdown option:not(:eq(0),:eq(1))').remove();
//                } else
                {
                    $("#" + divID).find('.condition-dropdown').html('<option value="">All Condition</option><option value="1">Is</option><option value="2">Is in the list</option><option value="3">Is not</option><option value="4">Is not in the list</option>');
                }
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
        if (variableValue == 5 || variableValue == 6 || variableValue == 11 || variableValue == 12) {
            if (conditionValue == 2 || conditionValue == 4) {
                $.ajax({
                    type: "POST",
                    data: {
                        condition: conditionValue,
                        variable: variableValue
                    },
                    url: '<?= base_url(); ?>' + 'action/home/filter_dropdown_option_ajax',
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
                    url: '<?= base_url(); ?>' + 'action/home/filter_dropdown_option_ajax',
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

    function reflactFilterWithSummery(status, requestType) {
//    alert(requestType);
        if(status!=''){
            clearFilter();
            variableArray = [];
            elementArray = [];
            $("select.variable-dropdown:first").val(2);
            var statusArray = status.split('-');
            $('select.criteria-dropdown:first').empty().html('<option value="' + statusArray[0] + '">' + statusArray[1] + '</option>').attr({'readonly': true, 'name': 'criteria_dropdown[tracking][]'});
            $("select.criteria-dropdown:first").trigger("chosen:updated");
            $("select.condition-dropdown:first").val(1).attr('disabled', true);
            elementArray.push($("select.condition-dropdown:first"));
            variableArray.push(2);
            if (requestType != '') {
                addFilterRow();
                $("select.variable-dropdown:eq(1)").val(13);
                var requestTypeArray = requestType.split('-');
                $('select.criteria-dropdown:eq(1)').empty().html('<option value="' + requestTypeArray[0] + '">' + requestTypeArray[1] + '</option>').attr({'readonly': true, 'name': 'criteria_dropdown[request_type][]'});
                $("select.criteria-dropdown:eq(1)").trigger("chosen:updated");
                $("select.condition-dropdown:eq(1)").val(1).attr('disabled', true);
                elementArray.push($("select.condition-dropdown:eq(1)"));
                variableArray.push(13);
            }
        }
    }
</script>
