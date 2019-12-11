<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-borderless">
            <?php if (!empty($task_list)) { ?>
                <tr>
                    <th style='width:8%;  text-align: center;'>Task ID</th>
                    <th style='width:8%;  text-align: center;'>Description</th>
                    <th style='width:8%;  text-align: center;'>Assign To</th>
                    <th style='width:8%;  text-align: center;'>Start Date</th>
                    <th style='width:8%;  text-align: center;'>Complete Date</th>
                    <th style='width:8%;  text-align: center;'>Tracking Description</th>
                    <th style="width:8%;  text-align: center;">SOS</th>
                    <th style="width:8%;  text-align: center;">Notes</th>
                    <th style="width:8%;  text-align: center;">Files</th>
                    <th style="width:8%;  text-align: center;">Input Form</th>
                </tr>
                <?php
                foreach ($task_list as $key=> $task) {
                    $taskId=$key+1;
                    $task_staff = ProjectTaskStaffList($task->id);
                    $stf = array_column($task_staff, 'staff_id');
                    $new_staffs = implode(',', $stf);
                    $created_at = $task->created_at;
//                                                            print_r($task);die;
                    $status = $task->tracking_description;
                    if ($status == 2) {
                        $tracking = 'Resolved';
                        $trk_class = 'label-primary';
                    } elseif ($status == 1) {
                        $tracking = 'Started';
                        $trk_class = 'label-yellow';
                    } elseif ($status == 0) {
                        $tracking = 'New';
                        $trk_class = 'label-success';
                    }elseif ($status == 3) {
                        $tracking = 'Ready';
                        $trk_class = 'label-secondary';
                    }
                    elseif ($status == 4) {
                        $tracking = 'Canceled';
                        $trk_class = 'label-danger';
                    }

                    $pattern_details = get_project_pattern($task->project_id);
                    $due_date = '';
                    $actual_day = $pattern_details->actual_due_day;
                    $actual_mnth = $pattern_details->actual_due_month;
                    $actual_yr = $pattern_details->actual_due_year;
                    if (strlen($actual_mnth) == 1) {
                        $actual_mnth = '0' . $actual_mnth;
                    }
                    if (strlen($actual_day) == 1) {
                        $actual_day = '0' . $actual_day;
                    }
                    $dueDate = $actual_yr . '-' . $actual_mnth . '-' . $actual_day;

//                                                             start date and complete date calculation
                    $created_at = strtotime(date('Y-m-d', strtotime($created_at)));
                    $due_date = strtotime($dueDate);
                    $start_date = $task->target_start_date . 'days';
                    $complete_date = $task->target_complete_date . 'days';
                    if ($task->target_start_day == 1) {
                        $targetSstartDate = date("Y-m-d", strtotime(("-$start_date"), $due_date));
                    } else {
                        $targetSstartDate = date("Y-m-d", strtotime(("+$start_date"), $created_at));
                    }
                    if ($task->target_complete_day == 1) {
                        $targetCompleteDate = $targetSstartDate = date("Y-m-d", strtotime(("-$complete_date"), $due_date));
                    } else {
                        $targetCompleteDate = date("Y-m-d", strtotime(("+$complete_date"), $created_at));
                    }
                    ?>
                    <tr>
                        <td title="Task Id" class="text-center"><?= $task->project_id.'-'.$taskId; ?></td>
                        <td title="Description" class="text-center"><?= $task->description; ?></td>
                        <!--<td title="Order" class="text-center"><?//= date('Y-m-d', strtotime($task->created_at)); ?></td>-->
        <!--                                                                <td title="Target Start Date" class="text-center"><?= $task->target_start_date; ?></td>
                        <td title="Target Complete Date" class="text-center"><?= $task->target_complete_date; ?></td>-->
                        <!--<td title="assign to"></td>-->
                        <?php if ($task->department_id == 2) { ?>
                            <td title="Assign To" class="text-center">
                                <?php
                                $resp_value = get_assigned_office_staff_project_main($task->project_id, '');
                                if (is_numeric($resp_value['name'])) {
                                    $resp_name = get_assigned_by_staff_name($resp_value['name']);
                                } else {
                                    $resp_name = $resp_value['name'];
                                }

                                if ($resp_value['office'] != 0) {
                                    $office_name = get_office_id($resp_value['office']);
                                } else {
                                    $office_name = 'Admin';
                                }
                                echo $resp_name . "<br><span class='text-info'>" . $office_name . " </span></td>";
                                ?> 
                            </td> <?php } else { ?> 
                            <td title="Assign To" class="text-center"><span class="text-success"><?php echo get_assigned_project_task_staff($task->id); ?></span><br><?php echo get_assigned_project_task_department($task->id); ?></td>                                                     
                        <?php } ?>
                        <td title="Start Date" class="text-center">T: <?= $targetSstartDate ?></td>
                        <td title="Complete Date" class="text-center">T: <?= $targetCompleteDate ?></td>
                        <td title="Tracking Description" class="text-center"><a href='javascript:void(0)' onclick='change_project_status_inner(<?= $task->id; ?>,<?= $status; ?>, <?= $task->id ?>);'><span id="trackinner-<?= $task->id ?>" projectid="<?= $id; ?>" class="label <?= $trk_class ?>"><?= $tracking ?></span></a></td>
                        <td title="SOS" style="text-align: center;">
                            <span>
                                <a id="projectsoscount-<?= $id; ?>-<?php echo $task->id; ?>" class="d-inline p-t-5 p-b-5 p-r-8 p-l-8 label <?php echo (get_sos_count('projects', $task->id, $id) == 0) ? 'label-primary' : 'label-danger'; ?>" title="SOS" href="javascript:void(0)" onclick="show_sos('projects', '<?= $task->id; ?>', '<?= $new_staffs ?>', '<?= $id; ?>', '<?= $task->project_id; ?>');"><?php echo (get_sos_count('projects', $task->id, $id) == 0) ? '<i class="fa fa-plus"></i>' : '<i class="fa fa-bell"></i>'; ?></a>                                                   
                            </span>
                        </td>
                       <!--  <td title='Note' class="text-center"><a id="notecount-<?= $task->id ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_task_notes(<?//= $task->id; ?>)"><b> <?//= get_project_task_note_count($task->id) ?></b></a></td> -->

                        <td title="Notes" class="text-center"><span> 
                                <?php
                                $read_status = project_task_notes_readstatus($task->id);
                                // print_r($read_status);

                                if (get_project_task_note_count($task->id) > 0 && in_array(0, $read_status)) {
                                    ?> 

                                    <a id="notecountinner-<?= $task->id ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task->id; ?>)"><b> <?= get_project_task_note_count($task->id) ?></b></a>

                                    <?php
                                } elseif (get_project_task_note_count($task->id) > 0 && in_array(1, $read_status)) {
                                    ?> 

                                    <a id="notecountinner-<?= $task->id ?>" class="label label-success" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task->id; ?>)"><b> <?= get_project_task_note_count($task->id) ?></b></a>

                                    <?php
                                } else {
                                    ?>

                                    <a id="notecountinner-<?= $task->id ?>" class="label label-secondary" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task->id; ?>)"><b> <?= get_project_task_note_count($task->id) ?></b></a>

                                    <?php
                                }
                                ?>
                            </span></td>
                        <?php
                        $file_count = getTaskFilesCount($task->id);
                        $unread_files_count = getUnreadTaskFileCount($task->id, 'task');
                        ?>
                        <?= '<td title="Files" class="text-center" ><span id="taskfilespan' . $task->id . '">' . (($unread_files_count->unread_files_count > 0) ? '<a class="label label-danger" href="javascript:void(0)" count="' . $file_count->files . '" id="taskfile' . $task->id . '" onclick="show_task_files(\'' . $task->id . '\',\'' . $new_staffs . $task->added_by_user . '\')"><b>' . $file_count->files . '</b></a>' : '<a class="label label-success" href="javascript:void(0)" count="' . $file_count->files . '" id="actionfile' . $task->id . '" onclick="show_task_files(\'' . $task->id . '\',\'' . $new_staffs . $task->added_by_user . '\')"><b>' . $file_count->files . '</b></a>') . '</span></td>'; ?>
                        <td style="text-align: center;">
                            <?php
                            $input_status = 'complete';
                            if ($task->is_input_form != 'y') {
                                echo 'N/A';
                            } else {
                                if ($task->input_form_status == 'n') {
                                    $input_status = 'incomplete';
                                    ?>
                                    <span class="label input-form-incomplete">Incomplete <a href="<?= base_url() . 'task/task_input_form/' . $task->id.'/'.$task->bookkeeping_input_type; ?>" class="text-white p-5" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i> </a></span>
                                <?php } else { ?>
                                    <span class="label input-form-complete">Completed <a href="<?= base_url() . 'task/task_input_form/' . $task->id.'/'.$task->bookkeeping_input_type; ?>" class="text-white p-5" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i> </a></span>
                                    <?php
                                }
                            }
                            ?>
                            <input type="hidden" class="input-form-status-<?= $task->id; ?>" value="<?= $input_status; ?>" />
                        </td>
                    </tr>
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
        </table>
    </div>
</div>
<!--task files modal-->
<div class="modal fade" id="showTaskFiles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
