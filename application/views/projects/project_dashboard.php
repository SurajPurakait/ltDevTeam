<?php
$user_info = staff_info();
$user_department = $user_info['department'];
$user_type = $user_info['type'];
$role = $user_info['role'];
?>
<div class="clearfix">
    <h2 class="text-primary pull-left"><?php echo (!empty($project_list)) ? count($project_list) : ''; ?> Results found</h2><div class="pull-right text-right p-t-5">
        <div class="dropdown" style="display: inline-block;">
            <a href="javascript:void(0);" id="sort-by-dropdown" data-toggle="dropdown" class="dropdown-toggle btn btn-success">Sort By <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a id="id-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.id')">Project ID</a></li>
                <li><a id="project_template-val" href="javascript:void(0);" onclick="sort_project_dashboard('pm.template_id')">Project Template</a></li>
                <li><a id="pattern-val" href="javascript:void(0);" onclick="sort_project_dashboard('prm.pattern')">Pattern</a></li> 
                <li><a id="client_type-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.client_type')">Client Type</a></li>
                <li><a id="client_id-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.client_id')">Client</a></li>
                <li><a id="responsible-val" href="javascript:void(0);" onclick="sort_project_dashboard('pm.responsible')">Responsible</a></li>
                <li><a id="assign_to-val" href="javascript:void(0);" onclick="sort_project_dashboard('pm.assign_to')">Assign To</a></li>
                <li><a id="status-val" href="javascript:void(0);" onclick="sort_project_dashboard('pm.status')">Tracking</a></li>
                <li><a id="created_at-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.created_at')">Creation Date</a></li>
                <!--<li><a id="due_date-val" href="javascript:void(0);" onclick="sort_project_dashboard('pro.due_date')">Due Date</a></li>-->
            </ul>
        </div>
        <div class="sort_type_div" style="display: none;">
            <a href="javascript:void(0);" id="sort-asc" onclick="sort_project_dashboard('', 'DESC')" class="btn btn-success" data-toggle="tooltip" title="Ascending Order" data-placement="top"><i class="fa fa-sort-amount-asc"></i></a>
            <a href="javascript:void(0);" id="sort-desc" onclick="sort_project_dashboard('', 'ASC')" class="btn btn-success" data-toggle="tooltip" title="Descending Order" data-placement="top"><i class="fa fa-sort-amount-desc"></i></a>
            <a href="javascript:void(0);" onclick="projectFilter();" class="btn btn-white text-danger" data-toggle="tooltip" title="Remove Sorting" data-placement="top"><i class="fa fa-times"></i></a>
        </div>
    </div>
</div>
<?php
$due_day = array(1, 2, 3, 4, 5, 6, 7);
$due_m = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'Jun', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
if (!empty($project_list)) {
    foreach ($project_list as $list) {
        $templatedetails = getProjectTemplateDetailsById($list['id']);
        $office_dtls = get_assigned_project_main_template_office($list['id']);
//                                                            print_r($office_dtls);die;
        $office_name = [];
        foreach ($office_dtls as $key => $ofc) {
            $office_name[] = $ofc;
        }
        $task_list = getProjectTaskList($list['id']);
        $pattern_details = get_project_pattern($list['id']);
//                                print_r($pattern_details);die;
//                                $due_date=$pattern_details['actual_due_day'];
//                                print_r($templatedetails);
        $status = $templatedetails->status;
        if ($status == 2) {
            $tracking = 'Completed';
            $trk_class = 'label-primary';
        } elseif ($status == 1) {
            $tracking = 'Started';
            $trk_class = 'label-yellow';
        } elseif ($status == 0) {
            $tracking = 'Not Started';
            $trk_class = 'label-success';
        }
//                                $client_name=getProjectClientName($list['client_id']);


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
        // if ($actual_day == 1) {
        //     $due_date = $actual_day."st";
        // } elseif ($actual_day == 2) {
        //     $due_date = $actual_day."nd";
        // }elseif ($actual_day == 3) {
        //     $due_date = $actual_day."rd";
        // }else {
        //     $due_date = $actual_day."th";
        // }
        // $dueDate= $due_date.' '.$due_m[$actual_mnth];
        $dueDate = $actual_yr . '-' . $actual_mnth . '-' . $actual_day;
//                                } else {
//                                    $dueDate= 'N/A';
//                                }
        ?>
        <div class="panel panel-default service-panel type2 filter-active" id="action<?= $list['id'] ?>">
            <div class="panel-heading"> 
                <a href="javascript:void(0)" onclick="delete_project(<?= $list['id']; ?>,<?= $list['template_id']; ?>)" class="btn btn-danger btn-xs btn-service-view-project"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a> &nbsp;
                <a href="javascript:void(0)" onclick="CreateProjectModal('edit',<?= $list['id'] ?>);" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>  &nbsp; 
                <a href="<?= base_url() . 'project/edit_project_template/' . base64_encode($list['id']); ?>" class="btn btn-primary btn-xs btn-service-edit-project"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Project</a> 
                                                
                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $list['id']; ?>" aria-expanded="false" class="collapsed">
                    <div class="table-responsive">
                        <table class="table table-borderless text-center" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th style="width:8%; text-align: center">Project ID</th>
                                    <th style="width:8%; text-align: center">Project Template</th>
                                    <th style="width:10%; text-align: center">Pattern</th>
                                    <th style="width:8%; text-align: center">Client Type</th>
                                    <th style="width:8%; text-align: center">Client Id</th>
                                    <th style="width:8%; text-align: center">Responsible</th>
                                    <th style="width:8%; text-align: center">Requested By</th>
                                    <th style="width:8%; text-align: center">Assigned To</th>
                                    <th style="width:8%; text-align: center">Tracking</th>
                                    <th style="width:8%; text-align: center">Creation Date</th>
                                    <th style="width:8%; text-align: center">Due Date</th>
                                    <th style="width:8%; text-align: center">Note</th>
                                </tr>
                                <tr>
                                    <td title="ID"><?= $list['id'] ?></td>
                                    <td title="Project Title">
                                        <span class=""><?= $templatedetails->title ?></span>
                                    </td>
                                    <td title="Pattern"><?= ucfirst($pattern_details->pattern) ?></td>
                                    <td title="Pattern"><?= ($list['client_type'] == '1') ? 'Business Client' : 'Individual Client' ?></td>
                                    <td title="Client"><?php echo getProjectClientName($list['client_id'], $list['client_type']); ?><br><span class="text-info"><?php // echo getProjectClient($list['office_id']);     ?> </span></td>                                                 
                                    <td title="Responsible"><?php
                                        $resp_value = get_assigned_office_staff_project_main($list['id']);
//                                        echo get_p_m_ca_name($resp_value, $list['id'],$list['client_type']);
                                        if (trim($resp_value) == 'Partner' || trim($resp_value) == 'Manager' || trim($resp_value) == 'Client Association') {
                                            echo get_p_m_ca_name($resp_value, $list['id'],$list['client_type'])."<br><span class='text-info'>".get_p_m_ca_ofc_name($resp_value, $list['id'],$list['client_type']). "</span></td>";
                                        } else {
                                            echo $resp_value."<br><span class='text-info'> $office_name[0] </span></td>";
                                        }
                                        ?> </td>   
                                    <td title="Requested By"><?php echo staff_info_by_id($list['added_by_user'])['full_name']; ?></td>
                                    <td title="Assign To"><span class="text-success"><?php echo get_assigned_dept_staff_project_main($list['id']); ?></span><br><?php echo get_assigned_project_main_department($list['id']); ?></td>                                                  
                                    <td title="Tracking" class="text-center"><span class="label <?= $trk_class ?>"><?= $tracking ?></span></td>
                                    <td title="Creation Date"><?= date('Y-m-d', strtotime($list['created_at'])) ?></td>
                                    <td title="Due Date"><?= $dueDate ?></td>

                                    <!-- <td title='Note'><a id="notecount-<?//= $list['id'] ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_notes(<?//= $list["id"]; ?>)"><b> <?//= get_project_note_count($list['id']) ?></b></a> -->


                                    <!-- </td> -->

                                     <td title="Notes"><span> 
                                            <?php
                                            $read_status = project_notes_read_status($list['id']);
                                            // print_r($read_status);

                                            if (get_project_note_count($list['id']) > 0 && in_array(0, $read_status)) {
                                                ?> 

                                               <a id="notecount-<?= $list['id'] ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_notes(<?= $list["id"]; ?>)"><b> <?= get_project_note_count($list['id']) ?></b></a>

                                                <?php
                                            } elseif (get_project_note_count($list['id']) > 0 && in_array(1, $read_status)) {
                                                ?> 

                                               <a id="notecount-<?= $list['id'] ?>" class="label label-success" href="javascript:void(0)" onclick="show_project_notes(<?= $list["id"]; ?>)"><b> <?= get_project_note_count($list['id']) ?></b></a>

                                                <?php
                                            } else {
                                                ?>

                                                <a id="notecount-<?= $list['id'] ?>" class="label label-secondary" href="javascript:void(0)" onclick="show_project_notes(<?= $list["id"]; ?>)"><b> <?= get_project_note_count($list['id']) ?></b></a>

                                                <?php
                                            }

                                            ?>
                                        </span></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </h5>
            </div>
            <div id="collapse<?= $list['id']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <?php if (!empty($task_list)) { ?>
                                <tr>
                                    <th style='width:8%;  text-align: center;'>Task ID</th>
                                    <th style='width:8%;  text-align: center;'>Description</th>
                                    <th style='width:8%;  text-align: center;'>Assign To</th>
                                    <th style='width:8%;  text-align: center;'>Start Date</th>
                                    <th style='width:8%;  text-align: center;'>Completed Date</th>
                                    <th style='width:8%;  text-align: center;'>Tracking Description</th>
                                    <th style="width:8%;  text-align: center;">SOS</th>
                                    <th style="width:8%;  text-align: center;">Note</th>
                                </tr>
                                <?php
                                foreach ($task_list as $task) {
                                    $task_staff= ProjectTaskStaffList($task->id);
                                    $stf = array_column($task_staff, 'staff_id');
                                    $new_staffs = implode(',', $stf);
//                                                            print_r($task);die;
                                    $status = $task->tracking_description;
                                    if ($status == 2) {
                                        $tracking = 'Completed';
                                        $trk_class = 'label-primary';
                                    } elseif ($status == 1) {
                                        $tracking = 'Started';
                                        $trk_class = 'label-yellow';
                                    } elseif ($status == 0) {
                                        $tracking = 'Not Started';
                                        $trk_class = 'label-success';
                                    }
//                                                             start date and complete date calculation
                                    $created_at = strtotime(date('Y-m-d', strtotime($list['created_at'])));
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
                                        <td title="Order" class="text-center"><?= $task->task_order; ?></td>
                                        <td title="Description" class="text-center"><?= $task->description; ?></td>
                                        <!--<td title="Order" class="text-center"><?//= date('Y-m-d', strtotime($task->created_at)); ?></td>-->
                <!--                                                                <td title="Target Start Date" class="text-center"><?= $task->target_start_date; ?></td>
                                        <td title="Target Complete Date" class="text-center"><?= $task->target_complete_date; ?></td>-->
                                        <!--<td title="assign to"></td>-->
                                        <?php if($task->department_id==2){ ?>
                                        <td title="Assign To" class="text-center"><?php
                                        $resp_value = get_assigned_office_staff_project_main($task->project_id);
//                                        echo get_p_m_ca_name($resp_value, $list['id'],$list['client_type']);
                                        if (trim($resp_value) == 'Partner' || trim($resp_value) == 'Manager' || trim($resp_value) == 'Client Association') {
                                            echo get_p_m_ca_name($resp_value, $task->project_id,1)."<br><span class='text-info'>".get_p_m_ca_ofc_name($resp_value, $task->project_id,1). "</span></td>";
                                        } else {
                                            echo $resp_value."<br><span class='text-info'> $office_name[0] </span></td>";
                                        }
                                        ?> </td> <?php } else{?> 
                                        <td title="Assign To" class="text-center"><span class="text-success"><?php echo get_assigned_project_task_staff($task->id); ?></span><br><?php echo get_assigned_project_task_department($task->id); ?></td>                                                     
                                        <?php } ?>
                                        <td title="Start Date" class="text-center"><?= $targetSstartDate ?></td>
                                        <td title="Complete Date" class="text-center"><?= $targetCompleteDate ?></td>
                                        <td title="Tracking Description" class="text-center"><a href='javascript:void(0)' onclick='change_project_status_inner(<?= $task->id; ?>,<?= $status; ?>, <?= $task->id ?>);'><span class="label <?= $trk_class ?>"><?= $tracking ?></span></a></td>
                                        <td title="SOS" style="text-align: center;">
                                            <span>
                                                <a id="projectsoscount-<?= $list['id']; ?>-<?php echo $task->id; ?>" class="d-inline p-t-5 p-b-5 p-r-8 p-l-8 label <?php echo (get_sos_count('projects', $task->id, $list['id']) == 0) ? 'label-primary' : 'label-danger'; ?>" title="SOS" href="javascript:void(0)" onclick="show_sos('projects', '<?= $task->id; ?>', '<?= $new_staffs ?>', '<?= $list['id']; ?>', '<?= $task->project_id; ?>');"><?php echo (get_sos_count('projects', $task->id, $list['id']) == 0) ? '<i class="fa fa-plus"></i>' : '<i class="fa fa-bell"></i>'; ?></a>                                                   
                                            </span>
                                        </td>
                                       <!--  <td title='Note' class="text-center"><a id="notecount-<?= $task->id ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_task_notes(<?//= $task->id; ?>)"><b> <?//= get_project_task_note_count($task->id) ?></b></a></td> -->

                                       <td title="Notes" class="text-center"><span> 
                                            <?php
                                            $read_status = project_task_notes_readstatus($task->id);
                                            // print_r($read_status);

                                            if (get_project_task_note_count($task->id) > 0 && in_array(0, $read_status)) {
                                                ?> 

                                              <a id="notecount-<?= $task->id ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task->id; ?>)"><b> <?= get_project_task_note_count($task->id) ?></b></a>

                                                <?php
                                            } elseif (get_project_task_note_count($task->id) > 0 && in_array(1, $read_status)) {
                                                ?> 

                                              <a id="notecount-<?= $task->id ?>" class="label label-success" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task->id; ?>)"><b> <?= get_project_task_note_count($task->id) ?></b></a>

                                                <?php
                                            } else {
                                                ?>

                                               <a id="notecount-<?= $task->id ?>" class="label label-secondary" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task->id; ?>)"><b> <?= get_project_task_note_count($task->id) ?></b></a>

                                                <?php
                                            }

                                            ?>
                                        </span></td>

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