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
                        <div class="col-md-6">
                            <h1 class="m-t-25 m-b-40">Action Dashboard</h1>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-aqua">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <th>New</th>
                                            <th>Started</th>
                                            <th>Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="byme">
                                            <th>Requested By Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-0">
                                                    <span class="label label-warning" id="requested_by_me_new" onclick="loadActionDashboard(0, 'byme', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('byme', 0)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-1">
                                                    <span class="label label-warning" id="requested_by_me_started" onclick="loadActionDashboard(1, 'byme', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('byme', 1)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                    <span class="label label-warning" id="requested_by_me_completed" onclick="loadActionDashboard(2, 'byme', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('byme', 2)); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr id="tome">
                                            <th>Requested To Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-0">
                                                    <span class="label label-warning" id="requested_to_me_new" onclick="loadActionDashboard(0, 'tome', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('tome', 0)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-1">
                                                    <span class="label label-warning" id="requested_to_me_started" onclick="loadActionDashboard(1, 'tome', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('tome', 1)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-2">
                                                    <span class="label label-warning" id="requested_to_me_completed" onclick="loadActionDashboard(2, 'tome', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('tome', 2)); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php if ($user_type == 1 || ($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)): ?>
                                            <tr id="byother">
                                                <th>Requested By Other</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-0">
                                                        <span class="label label-warning" id="requested_by_other_new" onclick="loadActionDashboard(0, 'byother', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('byother', 0)); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-1">
                                                        <span class="label label-warning" id="requested_by_other_started" onclick="loadActionDashboard(1, 'byother', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('byother', 1)); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byother-2">
                                                        <span class="label label-warning" id="requested_by_other_completed" onclick="loadActionDashboard(2, 'byother', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('byother', 2)); ?></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        endif;
                                        if (($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)):
                                            ?>
                                            <tr id="toother">
                                                <th>Requested To Other</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-0">
                                                        <span class="label label-warning" id="requested_to_other_new" onclick="loadActionDashboard(0, 'toother', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('toother', 0)); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-1">
                                                        <span class="label label-warning" id="requested_to_other_started" onclick="loadActionDashboard(1, 'toother', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('toother', 1)); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-toother-2">
                                                        <span class="label label-warning" id="requested_to_other_completed" onclick="loadActionDashboard(2, 'toother', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('toother', 2)); ?></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr id="mytask">
                                            <th>My Task</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-0">
                                                    <span class="label label-warning" id="requested_mytask_new" onclick="loadActionDashboard(0, 'mytask', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('mytask', 0)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-1">
                                                    <span class="label label-warning" id="requested_mytask_started" onclick="loadActionDashboard(1, 'mytask', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('mytask', 1)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-mytask-3">
                                                    <span class="label label-warning" id="requested_mytask_completed" onclick="loadActionDashboard(2, 'mytask', getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));"><?= count(action_list('mytask', 2)); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-line-dashed  m-t-5 m-b-5">
                    <div class="clearfix">
                        <div class="pull-right"><a class="btn btn-primary" href="<?= base_url("/action/home/create_action") ?>"><i class="fa fa-plus"></i> Create New Action</a></div>
                        <h3><span class="text-success" style="display: none;" id="clear_filter">By Me - Started</span> &nbsp; <a href="javascript:void(0);" onclick="loadActionDashboard('', '', '', '', '', '');" class="btn btn-ghost btn-xs" id="btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a></h3>
                    </div>
                    <div class="clearfix form-inline">
                        <label class="control-label">Filter :</label> &nbsp;
                        <select class="form-control request-dropdown" id="filter_request" onchange="loadActionDashboard(getIdVal('filter_status'), this.value, getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));">
                            <option value="">Select Request</option>                        
                            <option value="byme">By Me</option>
                            <option value="tome">To Me</option>
                            <?php if ($user_type == 1 || ($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)): ?>
                                <option value="byother">By Other</option>
                                <?php
                            endif;
                            if (($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)):
                                ?>
                                <option value="toother">To Other</option>
                            <?php endif; ?>
                            <option value="mytask">My Task</option>
                        </select>
                        <select class="form-control short-column-dropdown" id="filter_short_column" onchange="loadActionDashboard(getIdVal('filter_status'), getIdVal('filter_request'), getIdVal('filter_priority'), this.value, getIdVal('filter_short_value'), getIdVal('filter_assign'));">
                            <option value="">Sort By</option>
                            <option value="department">Department</option>
                            <!--<option value="staff">Staff</option>-->
                            <option value="office">Office</option>
                        </select>
                        <select class="form-control short-value-dropdown" id="filter_short_value" onchange="loadActionDashboard(getIdVal('filter_status'), getIdVal('filter_request'), getIdVal('filter_priority'), getIdVal('filter_short_column'), this.value, getIdVal('filter_assign'));" style="display:none">
                            <option value="">Select an option</option>
                        </select>
                        <select class="form-control status-dropdown" id="filter_status" onchange="loadActionDashboard(this.value, getIdVal('filter_request'), getIdVal('filter_priority'), getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));">
                            <option value="">Select Tracking</option>
                            <option <?= ($status != '' && $status == 0) ? 'selected' : ''; ?> value="0">New</option>
                            <option <?= ($status != '' && $status == 1) ? 'selected' : ''; ?> value="1">Started</option>
                            <option <?= ($status != '' && $status == 2) ? 'selected' : ''; ?> value="2">Completed</option>
                            <option <?= ($status != '' && $status == 3) ? 'selected' : ''; ?> value="3">Not Completed</option>
                            <option <?= ($status != '' && $status == 4) ? 'selected' : ''; ?> value="4">All Tracking</option>
                        </select>
                        <select class="form-control priority-dropdown" id="filter_priority" onchange="loadActionDashboard(getIdVal('filter_status'), getIdVal('filter_request'), this.value, getIdVal('filter_short_column'), getIdVal('filter_short_value'), getIdVal('filter_assign'));">
                            <option value="">Select Priority</option>
                            <option <?= ($priority != '' && $priority == 1) ? 'selected' : ''; ?> value="1">High</option>
                            <option <?= ($priority != '' && $priority == 2) ? 'selected' : ''; ?> value="2">Medium</option>
                            <option <?= ($priority != '' && $priority == 3) ? 'selected' : ''; ?> value="3">Low</option>
                        </select>
                        <select class="form-control assign-dropdown" id="filter_assign" onchange="loadActionDashboard(getIdVal('filter_status'), getIdVal('filter_request'), this.value, getIdVal('filter_short_column'), getIdVal('filter_short_value'), this.value);">
                            <option value="">Select Status</option>
                            <option value="1">Assigned</option>
                            <option value="2">Unassigned</option>
                        </select>
<!--                        <label class="form-control m-t-4 filter-text btn btn-ghost" style="display: none;"><span></span>
                            <a href="javascript:void(0);" onclick="loadActionDashboard('', '', '', '', '', '');"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </label>-->
                    </div>
                    <div id="action_dashboard_div"></div>
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
            <form method="post" action="<?= base_url(); ?>action/home/updateNotes">
                <div id="notes-modal-body" class="modal-body p-b-0"></div>
                <div class="modal-body p-t-0 text-right">
                    <button type="submit" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
            <form method="post" id="modal_note_form" action="<?php echo base_url(); ?>action/home/addNotesmodal">
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
                    <button type="button" id="save_note" onclick="document.getElementById('modal_note_form').submit();this.disabled = true;" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
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
<script>
    loadActionDashboard('<?= $status; ?>', '', '<?= $priority; ?>', '', '', '');
    $(document).ready(function () {
//        $('#save_note').on('click', function () {
//            $('#save_note').attr("disabled", true);
//        });
        $('.add-action-note').click(function () {
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a>' +
                    '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });
</script>