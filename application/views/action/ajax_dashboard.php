<div class="clearfix">
    <?php if (count($action_list) != 0): ?>
        <h2 class="text-primary pull-left"><?= count($action_list); ?> Results found</h2>
    <?php endif; ?>
    <div class="pull-right text-right p-t-5">
        <div class="dropdown" style="display: inline-block;">
            <a href="javascript:void(0);" id="sort-by-dropdown" data-toggle="dropdown" class="dropdown-toggle btn btn-success">Sort By <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a id="id-val" href="javascript:void(0);" onclick="sort_dashboard('act.id')">ID</a></li>
                <li><a id="user_name-val" href="javascript:void(0);" onclick="sort_dashboard('user_name')">Created By</a></li>
                <!-- <li><a id="action_staff_name-val" href="javascript:void(0);" onclick="sort_dashboard('action_staff_name')">Assigned To</a></li> -->
                <li><a id="client_id-val" href="javascript:void(0);" onclick="sort_dashboard('act.client_id')">Client ID</a></li>
                <li><a id="status-val" href="javascript:void(0);" onclick="sort_dashboard('act.status')">Tracking</a></li>
                <li><a id="creation_date-val" href="javascript:void(0);" onclick="sort_dashboard('act.creation_date')">Requested Date</a></li>
                <!--<li><a id="start_date-val" href="javascript:void(0);" onclick="sort_dashboard('act.start_date')">Start Date</a></li>-->
                <li><a id="complete_date-val" href="javascript:void(0);" onclick="sort_dashboard('act.complete_date')">Complete Date</a></li>
                <li><a id="due_date-val" href="javascript:void(0);" onclick="sort_dashboard('act.due_date')">Due Date</a></li>
            </ul>
        </div>
        <div class="sort_type_div" style="display: none;">
            <a href="javascript:void(0);" id="sort-asc" onclick="sort_dashboard('', 'DESC')" class="btn btn-success" data-toggle="tooltip" title="Ascending Order" data-placement="top"><i class="fa fa-sort-amount-asc"></i></a>
            <a href="javascript:void(0);" id="sort-desc" onclick="sort_dashboard('', 'ASC')" class="btn btn-success" data-toggle="tooltip" title="Descending Order" data-placement="top"><i class="fa fa-sort-amount-desc"></i></a>
            <a href="javascript:void(0);" onclick="actionFilter();" class="btn btn-white text-danger" data-toggle="tooltip" title="Remove Sorting" data-placement="top"><i class="fa fa-times"></i></a>
        </div>
    </div>
</div>



<?php
$user_info = staff_info();
$user_department = $user_info['department'];
$user_type = $user_info['type'];
$role = $user_info['role'];
if (!empty($action_list)):
    foreach ($action_list as $key => $action):
        $action_staffs = action_staff_by_action_id($action["id"]);
        $added_staff_department = get_dept_name_by_dept_id($action['created_department']);
        $stf = array_column($action_staffs, 'staff_id');
        $new_staffs = implode(',', $stf);
        if ($action["tracking_status"] == 'New') {
            $trk_class = 'label-success';
        } elseif ($action["tracking_status"] == 'Resolved') {
            $trk_class = 'label-primary';
        } elseif ($action["tracking_status"] == 'Started') {
            $trk_class = 'label-yellow';
        } elseif ($action["tracking_status"] == 'Canceled') {
            $trk_class = 'label-danger';
        } else {
            $trk_class = 'bg-purple';
        }
        $check_if_action_assigned = array_column($action_staffs, 'staff_id');
        ?>
        <div class="panel panel-default service-panel type2 filter-active" id="action<?= $action["id"]; ?>">
            <div class="panel-heading">
                <?php if (count($action_staffs) != 1): ?>
                    <?php //if (in_array(0, $check_if_action_assigned)): ?>
                    <div class="assigned-status">
                        <?php //if (($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)): ?>
                        <?php if ($user_type == 1 || ($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)) { ?>
                            <a href="javascript:void(0);" onclick="show_action_assign_modal('<?= $action["id"]; ?>');" class="label label-success"><i class="fa fa-plus"></i> Assign</a>
                        <?php } else { ?>
                            <a href="javascript:void(0);" onclick="assignAction('<?= $action["id"]; ?>', '<?= sess('user_id'); ?>')" class="label label-success"><i class="fa fa-plus"></i> Assign</a>
                        <?php } ?>&nbsp;
                        <!--  <label class="label label-default">Unassigned</label> -->
                    </div>
                <?php else: ?>
                    <div class="assigned-status"><!-- <label class="label label-primary">Assigned</label> -->
                        <?php if ($user_type == 1 || ($user_type == 2 && $role == 4)) { ?>
                            <a href="javascript:void(0);" onclick="assignAction('<?= $action["id"]; ?>', 0);" class="label label-danger"><i class="fa fa-remove"></i> Unassign</a>
                        <?php } ?>
                    </div>
                <?php
                endif;
                $check_if_sos_exists = check_if_sos_exists('action', $action["id"]);
                if (!empty($check_if_sos_exists)) {
                    $sos_flag = '<img src="' . base_url() . 'assets/img/badge_sos_priority.png" class="m-t-5"/>';
                } else {
                    $sos_flag = '';
                }
                switch ($action["priority"]) {
                    case 1:
                        echo '<div class="priority"><img src="' . base_url() . 'assets/img/badge_high_priority.png" />';
                        echo $sos_flag;
                        echo '</div>';
                        break;
                    case 2:
                        echo '<div class="priority"><img src="' . base_url() . 'assets/img/badge_medium_priority.png" />';
                        echo $sos_flag;
                        echo '</div>';
                        break;
                    case 3:
                        echo '<div class="priority"><img src="' . base_url() . 'assets/img/badge_low_priority.png" />';
                        echo $sos_flag;
                        echo '</div>';
                        break;
                    default:
                        break;
                }
                if (in_array(sess('user_id'), action_edit_permission($action["id"]))) {
                    ?>
                    <a href="<?= base_url("/action/home/view_action/{$action["id"]}"); ?>"
                       class="btn btn-primary btn-xs btn-add btn-service-view"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                    <?php

                    if ($action['status'] == '0') {
                        ?>
                        <a href="<?= base_url("/action/home/edit_action/{$action["id"]}"); ?>"
                           class="btn btn-primary btn-xs btn-add btn-service-lead"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                       <?php } ?>

                   <?php } ?>
                <a class="panel-title" data-toggle="collapse" data-parent="#accordion"
                   href="#collapse89"
                   aria-expanded="false" style="cursor: default;">
                    <div class="table-responsive" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $action['id']; ?>" aria-expanded="false" class="collapsed">
                        <table class="table table-borderless text-center" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th style="width:8%; text-align: center">
                                        Action ID
                                        <input type="hidden" class="action-all-staffs-<?= $action['id']; ?>" value="<?= ltrim($action["all_action_staffs"], ',') . $action['added_by_user']; ?>" />
                                    </th>
                                    <th style="width:8%; text-align: center">Created By</th>
                                    <th style="width:8%; text-align: center">Assigned To</th>
                                    <th style="width:10%; text-align: center">Client ID</th>
                                    <th style="width:8%; text-align: center">Tracking</th>
                                    <th style="width:8%; text-align: center">Subject</th>
                                    <!-- <th style="width:10%; text-align: center">Message</th> -->
                                    <th style="width:8%; text-align: center" class="">Creation Date</th>
                                    <!-- <th style="width:8%; text-align: center" class="">Start Date</th>
                                    <th style="width:8%; text-align: center" class="">Completed Date</th> -->
                                    <th style="width:8%; text-align: center" class="">Due Date</th>
                                    <th style="width:120px; text-align: center">Files</th>
                                    <th style="width:120px; text-align: center">Notes</th>
                                    <th style="width:120px; text-align: center">SOS</th>
                                </tr>
                                <tr>
                                    <td title="Action ID">#<?= $action["id"]; ?></td>
                                    <td title="Created By">
                                        <!--onclick="user_details('<?//= $action['added_by_user']; ?>')"-->
                                        <?php
                                        //$get_add_by_user_ofc = get_add_by_user_ofc_id($action["id"]);
                                        $get_ofc_by_id = get_ofc_by_id($action["created_office"]);
                                        ?>
                                        <span class="text-success"><?= $action["user_name"]; ?></span><br><?= $added_staff_department; ?><br><span class="text-info"><?= $get_ofc_by_id['office_id']; ?></span>
                                    </td>
                                    <?php
                                    // if($action["department_id"]==2){
                                    //   $ofc_dept_name = staff_office_ofc_id($action_staffs[0]['staff_id']);
                                    // }else{
                                    //   $ofc_dept_name = get_office_info_by_id(17)['office_id'];
                                    // }                                        
                                    ?>
                                    <?php if (isset($action_staffs[0]['staff_id']) && $action_staffs[0]['staff_id'] != 0) { ?>
                                        <td title="Assign To">
                                            <?php
                                            if (count($action_staffs) != 1) {
                                                echo '<span class="text-success">' . $action["department_name"] . '</span><br>';
                                                if ($action['department_id'] == 2) {
                                                    echo '<span class="text-info">' . get_office_name_by_office_id($action['office_id']) . '</span>';
                                                } else {
                                                    echo '<span class="text-info">' . get_office_info_by_id('17')['office_id'] . '</span>';
                                                }
                                            } else {
                                                echo '<span class="text-success">' . staff_info_by_id($action_staffs[0]['staff_id'])['full_name'] . '</span><br>' . $action["department_name"] . '<br>';

                                                if ($action['department_id'] == 2) {
                                                    echo '<span class="text-info">' . get_office_name_by_office_id($action['office_id']) . '</span>';
                                                } else {
                                                    echo '<span class="text-info">' . get_office_info_by_id('17')['office_id'] . '</span>';
                                                }
                                            }
                                            ?>
                                        </td>
                                    <?php } else { ?>
                                        <td title="Assign To"><label class="label label-default">Unassigned</label></td>
                                    <?php } ?>

                                  <?php if($action["client_id"] != ''){
                                   $a = explode(",",$action["client_id"]); ?>
                                    <td>
                                        <?php foreach($a as $val){ 
                                            $v = $val;
                                            $get_name = get_company_or_individual_name($action['id'],$v);
                                        ?>
                                            <a  href="javascript:void(0)" onclick="show_action_client_view_page('<?= $action['id']?>','<?= $v ?>')" title="<?= $get_name; ?>"><?= $val ?></a>
                                        <?php } ?>


                                    </td>
                                <?php }else{ ?>
                                    <td title="Client ID"></td>
                                <?php } ?>

                                    <td align='left' title="Tracking Description" class="text-center">
                                        <a href='javascript:void(0);' id='actiontracking-<?php echo $action["id"]; ?>' onclick='show_action_tracking_modal("<?= $action["id"]; ?>", "ajax_dashboard")'>
                                            <span class='label <?php echo $trk_class; ?>'><?= $action["tracking_status"]; ?></span>
                                        </a>
                                    </td>

                                    <td title="Subject"><a href=""><?php echo ($action["subject"] != '') ? substr($action["subject"], 0, 30) : 'N/A'; ?></a></td>

                        <!-- <td title="Message"> -->
                                    <!-- <div class="panel-heading"> -->
                                    <!-- <div class="form-group"> -->
                                    <!-- <a href="javascript:void(0);"><?php
                                    // echo substr($action['message'], 0, 30) . '...'; 
                                    ?>
                                    </a> -->
                                    <!-- </div> -->
                                    <!-- </div> -->
                                    <!-- </td> -->
                                    <td title="Creation Date"><?= ($action["creation_date"] != "") ? date("m/d/Y", strtotime($action["creation_date"])) : "-"; ?></td>
        <!--                                     <td title="Start Date"><?//= ($action["start_date"] != "0000-00-00") ? date("m/d/Y", strtotime($action["start_date"])) : "-"; ?></td>
                                    <td title="Completed Date" class="text-green"><?//= ($action["complete_date"] != "0000-00-00") ? date("m/d/Y", strtotime($action["complete_date"])) : "-"; ?></td> -->
                                    <?php
                                        if($action["due_date"] != "0000-00-00"){
                                        $duedate = date("m/d/Y", strtotime($action["due_date"]));
                                        $today = date("m/d/Y");
                                        if($today>$duedate){
                                    ?>
                                           <td title="Due Date" class="text-danger">
                                           <?php echo $duedate; ?>
                                            </td> 
                                    <?php
                                        }else{
                                    ?>
                                        <td title="Due Date">
                                           <?php echo $duedate; ?>
                                            </td> 
                                    <?php
                                         } 
                                        }else{
                                    ?>
                                        <td title="Due Date">
                                        <?php  echo "-"; ?>
                                           </td>
                                    <?php
                                     }

                                    ?>
                                   <!--  <td title="Due Date"><?//= ($action["due_date"] != "0000-00-00") ? date("m/d/Y", strtotime($action["due_date"])) : "-"; ?></td> -->

                                    <?= '<td title="Files"><span id="actionfilespan' . $action["id"] . '">' . (($action["unread_files_count"] > 0) ? '<a class="label label-danger" href="javascript:void(0)" count="' . $action["files"] . '" id="actionfile' . $action["id"] . '" onclick="show_action_files(\'' . $action["id"] . '\',\'' . ltrim($action["all_action_staffs"], ',') . $action['added_by_user'] . '\')"><b>' . $action["files"] . '</b></a>' : '<a class="label label-success" href="javascript:void(0)" count="' . $action["files"] . '" id="actionfile' . $action["id"] . '" onclick="show_action_files(\'' . $action["id"] . '\',\'' . ltrim($action["all_action_staffs"], ',') . $action['added_by_user'] . '\')"><b>' . $action["files"] . '</b></a>') . '</span></td>'; ?>
                                    <td title="Notes"><span> 
                                            <?php
                                            // $read_status = notes_read_status($action["id"]);
                                            $read_status = action_notes_read_status($action["id"],$user_info['id']);
                                            // print_r($read_status);

                                            if ($action["notes"] > 0 && in_array(0, $read_status)) {
                                                ?>    
                                                <a id="notecount-<?= $action["id"]; ?>" class="label label-danger" href="javascript:void(0)" onclick="show_action_notes(<?= $action["id"]; ?>,<?= sess('user_id') ?>)"><b> <?= $action["notes"] ?></b></a>
                                                <?php
                                            } elseif ($action["notes"] > 0 && in_array(1, $read_status)) {
                                                ?>    
                                                <a id="notecount-<?= $action["id"]; ?>" class="label label-success" href="javascript:void(0)" onclick="show_action_notes(<?= $action["id"]; ?>,<?= sess('user_id')?>)"><b> <?= $action["notes"] ?></b></a>
                                                <?php
                                            } else {
                                                ?>    
                                                <a id="notecount-<?= $action["id"]; ?>" class="label label-warning" href="javascript:void(0)" onclick="show_action_notes(<?= $action["id"]; ?>,<?= sess('user_id') ?>)"><b> <?= $action["notes"] ?></b></a>
                                                <?php
                                            }

                                            // (($action["notes"] > 0) ? '<a id="notecount-'.$action["id"].'" class="label label-warning" href="javascript:void(0)" onclick="show_action_notes(\'' . $action["id"] . '\')"><b>' . $action["notes"] . '</b></a>' : '<a id="notecount-'.$action["id"].'" class="label label-warning" href="javascript:void(0)" onclick="show_action_notes(\'' . $action["id"] . '\')"><b>' . $action["notes"] . '</b></a>')
                                            ?>
                                        </span></td>
                                    <td title="SOS"><span>
                                            <?php if ($action["tracking_status"] != 'Completed') { ?>
                                                <a id="soscount-<?= $action["id"]; ?>" class="d-inline p-t-5 p-b-5 p-l-8 p-r-8 label <?php echo (get_sos_count('action', '', $action["id"]) == 0) ? 'label-primary' : 'label-danger'; ?>" title="SOS" href="javascript:void(0)" onclick="show_sos('action', '', '<?= $new_staffs; ?>', '<?= $action["id"]; ?>', '');"><?php echo (get_sos_count('action', '', $action["id"]) == 0) ? '<i class="fa fa-plus"></i>' : '<i class="fa fa-bell"></i>'; ?></a>
                                                <?php
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </a>
            </div>
            <div id="collapse<?= $action['id']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <div class="table-responsive">
                        <h4 class="text-center"><pre style='display: initial !important; background:transparent; border: none;padding: 9.5px 0 0;margin-bottom: 0;font-family: inherit; white-space: pre-wrap; white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;'><?= $action['message']; ?></pre></h4>        
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i> 
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
<?php endif; ?>

<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function show_action_client_view_page(action_id,client_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'action/home/show_action_client_view_page',
        data: {
            action_id: action_id,
            client_id: client_id
        },
        success: function (result) {
            // alert(result);return false;
            var obj = JSON.parse(result);
            var client_id = obj.client_list_id;
            var company_id = obj.company_id;
            var client_type = obj.client_type;
            var reference_id = obj.reference_id;
            if(client_type == 1){
            window.open(base_url + 'action/home/view_business/' + client_id + '/' + company_id );
          }else if(client_type == 2){
            window.open(base_url + 'action/home/view_individual/' + reference_id );
          }
        }
    });
}
</script>