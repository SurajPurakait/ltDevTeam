<?php if (!empty($data)): ?>
    <?php
    foreach ($data as $key => $value):
        $action_staffs = action_staff_by_action_id($value["id"]);
        $added_staff_department = staff_department_name($value['added_by_user']);
        ?>
        <div class="panel panel-default service-panel type2 filter-active">
            <div class="panel-heading">
                <?php if (count($action_staffs) != 1): ?>
                    <div class="assigned-status"><label class="label label-default"><i class="fa fa-info-circle"></i> Unassigned</label></div>
                <?php else: ?>
                    <div class="assigned-status"><label class="label label-primary"><i class="fa fa-check"></i> Assigned</label></div>
                <?php
                endif;
                //$value["priority"] = 3;
                switch ($value["priority"]) {
                    case 1:
                        echo '<div class="priority"><img src="' . base_url() . '/assets/img/badge_high_priority.png" /></div>';
                        break;
                    case 2:
                        echo '<div class="priority"><img src="' . base_url() . '/assets/img/badge_medium_priority.png" /></div>';
                        break;
                    case 3:
                        echo '<div class="priority"><img src="' . base_url() . '/assets/img/badge_low_priority.png" /></div>';
                        break;
                    default:
                        break;
                }
                if (in_array(sess('user_id'), action_edit_permission($value["id"]))) {
                    ?>
                    <a href="<?= base_url("/action/home/edit_action/{$value["id"]}"); ?>"
                       class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    <a href="<?= base_url("/action/home/view_action/{$value["id"]}"); ?>"
                       class="btn btn-primary btn-xs btn-service-view"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                   <?php } ?>
                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion"
                    href="#collapse89"
                    aria-expanded="false">
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th style="width:8%;">Action ID</th>
                                    <th style="width:8%;">Created By</th>
                                    <th style="width:8%;">Assign To</th>
                                    <th style="width:10%;">Client ID</th>
                                    <th style="width:8%;">Tracking</th>
                                    <th style="width:10%;">Message</th>
                                    <th style="width:8%;">Creation Date</th>
                                    <th style="width:8%;">Start Date</th>
                                    <th style="width:8%;">Completed Date</th>
                                    <th style="width:8%;">Due Date</th>
                                    <th style="width:8%;">Files</th>
                                    <th style="width:8%;">Notes</th>
                                </tr>
                                <tr>
                                    <td  style="width:8%;" title="Action ID">#<?= $value["id"]; ?></td>
                                    <td  style="width:8%;" title="Created By">
                                        <!--href="javascript:void(0);" onclick="user_details('<?= $value['added_by_user']; ?>')"-->
                                        <span class="text-success"><?= $value["user_name"]; ?></span><br><?= $added_staff_department; ?>
                                    </td>
                                    <td  style="width:8%;" title="Assign To"><?= (count($action_staffs) != 1) ? $value["department_name"] : '<span class="text-success">' . staff_info_by_id($action_staffs[0]['staff_id'])['full_name'] . '</span><br>' . staff_department_name($action_staffs[0]['staff_id']); ?></td>
                                    <td  style="width:10%;" title="Client ID"><?= $value["client_id"]; ?></td>
                                    <td  style="width:8%;" align='left' title="Tracking Description">
                                        <a href='javascript:void(0);' onclick='show_action_tracking_modal("<?= $value["id"]; ?>")'>
                                            <span class='label label-primary'><?= $value["tracking_status"]; ?></span>
                                        </a>
                                    </td>
                                    <td  style="width:10%;" style="width:120px;" title="Message">
                                        <a href="javascript:void(0);" onclick="msg_details('<?= $value['id']; ?>')"><?= substr($value['message'], 0, 30) . '...'; ?></a>
                                    </td>
                                    <td  style="width:8%;" title="Creation Date"><?= ($value["creation_date"] != "") ? date("m/d/Y", strtotime($value["creation_date"])) : "-"; ?></td>
                                    <td  style="width:8%;" title="Start Date"><?= ($value["start_date"] != "0000-00-00") ? date("m/d/Y", strtotime($value["start_date"])) : "-"; ?></td>
                                    <td style="width:8%;" title="Completed Date"><?= ($value["complete_date"] != "0000-00-00") ? date("m/d/Y", strtotime($value["complete_date"])) : "-"; ?></td>
                                    <td  style="width:8%;" title="Due Date"><?= ($value["due_date"] != "0000-00-00") ? date("m/d/Y", strtotime($value["due_date"])) : "-"; ?></td>
                                    <?= '<td  style="width:8%;" title="Files"><span>' . (($value["files"] > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_action_files(\'' . $value["id"] . '\')"><b>' . $value["files"] . '</b></a>' : '<b class="label label-warning">' . $value["files"] . '</b>') . '</span></td>'; ?>
                                    <?= '<td  style="width:8%;" title="Notes"><span>' . (($value["notes"] > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_action_notes(\'' . $value["id"] . '\')"><b>' . $value["notes"] . '</b></a>' : '<b class="label label-warning">' . $value["notes"] . '</b>') . '</span></td>'; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </h5>
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
