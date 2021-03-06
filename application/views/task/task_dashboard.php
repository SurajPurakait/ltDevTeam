<?php
$user_info = $this->session->userdata('staff_info');
$user_department = $user_info['department'];
$user_type = $user_info['type'];
$role = $user_info['role'];
?>
<div class="clearfix result-header">
    <?php if (count($task_list) != 0): ?>
        <h2 class="text-primary pull-left result-count-h2"><?= isset($page_number) ? ($page_number * 20) : count($task_list) ?> Results found <?= isset($page_number) ? 'of ' . count($task_list) : '' ?></h2>
    <?php endif; ?>
    <div class="pull-right text-right p-t-5">
        <div class="dropdown" style="display: inline-block;">
            <a href="javascript:void(0);" id="sort-by-dropdown" data-toggle="dropdown" class="dropdown-toggle btn btn-success">Sort By <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a id="id-val" href="javascript:void(0);" onclick="sort_task_dashboard('pt.id')">ID</a></li>
                <!--                <li><a id="project_template-val" href="javascript:void(0);" onclick="//sort_project_dashboard('pm.template_id')">Project Template</a></li>
                                <li><a id="pattern-val" href="javascript:void(0);" onclick="//sort_project_dashboard('prm.pattern')">Pattern</a></li> 
                                <li><a id="client_type-val" href="javascript:void(0);" onclick="//sort_project_dashboard('pro.client_type')">Client Type</a></li>
                                <li><a id="client_id-val" href="javascript:void(0);" onclick="//sort_project_dashboard('pro.client_id')">Client</a></li>
                                <li><a id="responsible-val" href="javascript:void(0);" onclick="//sort_project_dashboard('pm.responsible')">Responsible</a></li>-->
                <li><a id="assign_staff-val" href="javascript:void(0);" onclick="sort_task_dashboard('pt.assign_staff')">Assign To</a></li>
                <li><a id="tracking_description-val" href="javascript:void(0);" onclick="sort_task_dashboard('pt.tracking_description')">Tracking</a></li>
                <!--<li><a id="created_at-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.created_at')">Creation Date</a></li>-->
                <!--<li><a id="due_date-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.due_date')">Due Date</a></li>-->
            </ul>
        </div>
        <div class="sort_type_div" style="display: none;">
            <a href="javascript:void(0);" id="sort-asc" onclick="sort_task_dashboard('', 'DESC')" class="btn btn-success" data-toggle="tooltip" title="Ascending Order" data-placement="top"><i class="fa fa-sort-amount-asc"></i></a>
            <a href="javascript:void(0);" id="sort-desc" onclick="sort_task_dashboard('', 'ASC')" class="btn btn-success" data-toggle="tooltip" title="Descending Order" data-placement="top"><i class="fa fa-sort-amount-desc"></i></a>
            <a href="javascript:void(0);" onclick="taskFilter();" class="btn btn-white text-danger" data-toggle="tooltip" title="Remove Sorting" data-placement="top"><i class="fa fa-times"></i></a>
        </div>
    </div>
</div>
<?php
$row_number = 0;
if (!empty($task_list)) {
    foreach ($task_list as $row_count => $task) {
//                                                            print_r($task);die;

        if (isset($page_number)) {
            if ($page_number != 1) {
                if ($row_count < (($page_number - 1) * 20)) {
                    continue;
                }
            }
            if ($row_count == ($page_number * 20)) {
                break;
            }
        }
        $task_staff = ProjectTaskStaffList($task['id']);
        $stf = array_column($task_staff, 'staff_id');
        $new_staffs = implode(',', $stf);
        $status = $task['tracking_description'];
        if ($status == 2) {
            $tracking = 'Completed';
            $trk_class = 'label-primary';
        } elseif ($status == 1) {
            $tracking = 'Started';
            $trk_class = 'label-yellow';
        } elseif ($status == 0) {
            $tracking = 'Not Started';
            $trk_class = 'label-success';
        } elseif ($status == 3) {
            $tracking = 'Ready';
            $trk_class = 'label-secondary';
        }
        elseif ($status == 4) {
            $tracking = 'Canceled';
            $trk_class = 'label-danger';
        }
        $pattern_details = get_project_pattern($task['project_id']);

        $due_date = '';
//                                if ($pattern_details->pattern != '' && $pattern_details->pattern == 'annually') {
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

        $created_at =strtotime(get_project_created_date($task['project_id']));
        $due_date = strtotime($dueDate);
        $start_date = $task['target_start_date'] . 'days';
        $complete_date = $task['target_complete_date'] . 'days';
        if ($task['target_start_day'] == 1) {
            $targetSstartDate = date("Y-m-d", strtotime(("+$start_date"), $created_at));
        } else {
            $targetSstartDate = date("Y-m-d", strtotime(("-$start_date"),$due_date));
        }
        if ($task['target_complete_day'] == 1) {
            $targetCompleteDate = date("Y-m-d", strtotime(("+$complete_date"), $created_at));
        } else {
            $targetCompleteDate = date("Y-m-d", strtotime(("-$complete_date"), $due_date));
        }
        if (strlen($task['description']) > 20) {
            $description = substr($task['description'], 0, 20) . '...';
            $data_description=$task['description'];
        } else {
            $description = $task['description'];
            $data_description=$task['description'];
        }
        ?>
        <div class="panel panel-default service-panel type2 filter-active" id="action">
            <div class="panel-heading"> 
        <!--        <a href="javascript:void(0)" onclick="delete_project(<?//= $task['id']; ?>)" class="btn btn-danger btn-xs btn-service-view-project"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a> &nbsp;
                <a href="javascript:void(0)" onclick="CreateProjectModal('edit',<?//= $task['id'] ?>);" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>  &nbsp; 
                <a href="<?//= base_url() . 'project/edit_project_template/' . base64_encode($task['id']); ?>" class="btn btn-primary btn-xs btn-service-edit-project"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Project</a> -->

                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $task['id']; ?>" aria-expanded="false" class="collapsed">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <?php
                            $due_m = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'Jun', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
                            ?>
                            <tr>
                                <th style='width:8%;  text-align: center;'>Task ID</th>
                                <th style='width:8%;  text-align: center;'>Task Title</th>
                                <th style='width:8%;  text-align: center;'>Assign To</th>
                                <th style='width:8%;  text-align: center;'>Start Date</th>
                                <th style='width:8%;  text-align: center;'>Complete Date</th>
                                <th style='width:8%;  text-align: center;'>Tracking Description</th>
                                <th style="width:8%;  text-align: center;">SOS</th>
                                <th style="width:8%;  text-align: center;">Note</th>
                                <th style="width:8%;  text-align: center;">Files</th>
                                <th style="width:8%;  text-align: center;">Input Form</th>
                            </tr>

                            <tr>
                                <td title="ID" class="text-center"><?= $task['project_id'].'-'.$task['task_order'] ?></td>
                                <td title="Order" class="text-center"><?= $task['task_title']; ?></td>
                                <!--<td title="Order" class="text-center"><?//= date('Y-m-d', strtotime($task->created_at)); ?></td>-->
        <!--                                                                <td title="Target Start Date" class="text-center"><?= $task->target_start_date; ?></td>
                                <td title="Target Complete Date" class="text-center"><?= $task['target_complete_date']; ?></td>-->
                                <!--<td title="assign to"></td>-->
                                <?php if ($task['department_id'] == 2) { ?>
                                    <td title="Assign To" class="text-center"><?php
                                    $resp_value = get_assigned_office_staff_project_task($task['id'],$task['project_id'], $task['responsible_task_staff']);
                                    echo "<span class='text-success'>". $resp_value['staff_name'] ."</span><br>" . $resp_value['office'] . "</td>";
                                    ?> 
                                    </td> <?php } else { ?> 
                                    <td title="Assign To" class="text-center"><span class="text-success"><?php echo get_assigned_project_task_staff($task['id']); ?></span><br><?php echo get_assigned_project_task_department($task['id']); ?></td>                                                     
                                <?php } ?>
                <!--<td title="Assign To" class="text-center"><span class="text-success"><?php // echo get_assigned_project_task_staff($task['id']);   ?></span><br><?php // echo get_assigned_project_task_department($task['id']);   ?></td>-->                                                     
                                <td title="Start Date" class="text-center">T: <?= date('m-d-Y',strtotime($targetSstartDate)) ?></td>
                                <td title="Complete Date" class="text-center">T: <?= date('m-d-Y',strtotime($targetCompleteDate)) ?></td>
                                <td title="Tracking Description" class="text-center"><a href='javascript:void(0)' onclick='change_project_status_inner(<?= $task['id']; ?>,<?= $status; ?>, <?= $task['id'] ?>);'><span class="label <?= $trk_class ?>"><?= $tracking ?></span></a></td>
                                <td title="SOS" style="text-align: center;">
                                    <span>
                                        <a id="projectsoscount-<?= $task['project_id']; ?>-<?php echo $task['id']; ?>" class="d-inline p-t-5 p-b-5 p-r-8 p-l-8 label <?php echo (get_sos_count('projects', $task['id'], $task['project_id']) == 0) ? 'label-primary' : 'label-danger'; ?>" title="SOS" href="javascript:void(0)" onclick="show_sos('projects', '<?= $task['id']; ?>', '<?= $new_staffs ?>', '<?= $task['project_id']; ?>', '');"><?php echo (get_sos_count('projects', $task['id'], $task['project_id']) == 0) ? '<i class="fa fa-plus"></i>' : '<i class="fa fa-bell"></i>'; ?></a>                                                   
                                    </span>
                                </td>
                               <!--  <td title='Note' class="text-center"><a id="notecount-<?//= $task['id'] ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_task_notes(<?//= $task['id']; ?>)"><b> <?//= get_project_task_note_count($task['id']) ?></b></a></td>
                                -->
                                <td title="Notes" class="text-center"><span> 
                                        <?php
                                        $read_status = project_task_notes_readstatus($task['id']);
                                        // print_r($read_status);

                                        if (get_project_task_note_count($task['id']) > 0 && in_array(0, $read_status)) {
                                            ?> 

                                            <a id="notecount-<?= $task['id'] ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task['id']; ?>)"><b> <?= get_project_task_note_count($task['id']) ?></b></a>

                                            <?php
                                        } elseif (get_project_task_note_count($task['id']) > 0 && in_array(1, $read_status)) {
                                            ?> 

                                            <a id="notecount-<?= $task['id'] ?>" class="label label-success" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task['id']; ?>)"><b> <?= get_project_task_note_count($task['id']) ?></b></a>

                                            <?php
                                        } else {
                                            ?>

                                            <a id="notecount-<?= $task['id'] ?>" class="label label-warning" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task['id']; ?>)"><b> <?= get_project_task_note_count($task['id']) ?></b></a>

                                            <?php
                                        }
                                        ?>
                                    </span></td>
                                <?php
                                $file_count = getTaskFilesCount($task['id']);
                                $unread_files_count = getUnreadTaskFileCount($task['id'], 'task');
                                ?>
                                <?= '<td title="Files" class="text-center" ><span id="taskfilespan' . $task['id'] . '">' . (($unread_files_count->unread_files_count > 0) ? '<a class="label label-danger" href="javascript:void(0)" count="' . $file_count->files . '" id="taskfile' . $task['id'] . '" onclick="show_task_files(\'' . $task['id'] . '\',\'' . $new_staffs . $task['added_by_user'] . '\')"><b>' . $file_count->files . '</b></a>' : '<a class="label label-success" href="javascript:void(0)" count="' . $file_count->files . '" id="actionfile' . $task['id'] . '" onclick="show_task_files(\'' . $task['id'] . '\',\'' . $new_staffs . $task['added_by_user'] . '\')"><b>' . $file_count->files . '</b></a>') . '</span></td>'; ?>
                                
                                <td style="text-align: center;">
                                    <?php
                                    $input_status = 'complete';
                                    if ($task['is_input_form'] != 'y') {
                                        echo 'N/A';
                                    } else {
                                        if ($task['input_form_status'] == 'n') {
                                            $input_status = 'incomplete';
                                            ?>
                                    <a href="<?= base_url() . 'task/task_input_form/' . $task['id'].'/'.$task['bookkeeping_input_type']; ?>" class="text-white label input-form-incomplete p-t-10 p-l-10 p-b-10" target="_blank">Incomplete <span class="p-10"><i class="fa fa-plus" aria-hidden="true"></i> </span></a>
                                        <?php } else { ?>
                                             <a href="<?= base_url() . 'task/task_input_form/' . $task['id'].'/'.$task['bookkeeping_input_type']; ?>" class="text-white label input-form-complete p-t-10 p-l-10 p-b-10" target="_blank">Completed<span class="p-10"> <i class="fa fa-pencil" aria-hidden="true"></i> </span></a>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <input type="hidden" class="input-form-status-<?= $task['id']; ?>" value="<?= $input_status; ?>" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </h5>
            </div>
            <div id="collapse<?= $task['id'] ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width:8%; text-align: center">Description</th>
                                </tr>
                                <tr>
                                    <td title="Description" align="center"><span><?= $task['description'] ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $row_number = $row_count + 1;
    }
    if (isset($page_number) && $row_number < count($task_list)):
        ?>
        <div class="text-center p-0 load-more-btn">
            <a href="javascript:void(0);" onclick="loadTaskDashboard('', '', '', '', '', '', '', '', '', '', '', '', '', <?= $page_number + 1; ?>);" class="btn btn-success btn-sm m-t-30 p-l-15 p-r-15"><i class="fa fa-arrow-down"></i> Load more results</a>
        </div>
    <?php endif; ?>
    <script>
        $(function () {
            $('h2.result-count-h2').html('<?= $row_number . ' Results found of ' . count($task_list) ?>');
    <?php if (isset($page_number) && $row_number === count($task_list)): ?>
                $('.load-more-btn').remove();
    <?php endif; ?>
        });
    </script>
<?php } else {
    ?>
    <div class = "text-center m-t-30">
        <div class = "alert alert-danger">
            <i class = "fa fa-times-circle-o fa-4x"></i>
            <h3><strong>Sorry!</strong> no data found</h3>
        </div>
    </div>
<?php } ?>
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