<?php
$user_info = $this->session->userdata('staff_info');
$user_department = $user_info['department'];
$user_type = $user_info['type'];
$role = $user_info['role'];
?>
<div class="clearfix result-header">
    <?php if (count($project_list) != 0): ?>
        <h2 class="text-primary pull-left result-count-h2"><?= isset($page_number) ? ($page_number * 20) : count($project_list) ?> Results found <?= isset($page_number) ? 'of ' . count($project_list) : '' ?></h2>
    <?php endif; ?>
    <div class="pull-right text-right p-t-5">
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
$row_number = 0;
if (!empty($project_list)) {
    foreach ($project_list as $row_count => $list) {
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
        $templatedetails = getProjectTemplateDetailsById($list['id']);
//         $office_dtls = get_assigned_project_main_template_office($list['id']);
// //                                                            print_r($office_dtls);die;
//         $office_name = [];
//         foreach ($office_dtls as $key => $ofc) {
//             $office_name[] = $ofc;
//         }
        //$task_list = getProjectTaskList($list['id']);
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
        if($actual_mnth<=12){
            $dueDate = $actual_yr . '-' . $actual_mnth . '-' . $actual_day;
        }else{
            $dueDate = $actual_yr . '-' .($actual_mnth % 12).'-' . $actual_day;
        }
//                                } else {
//                                    $dueDate= 'N/A';
//                                }
        ?>
        <div class="panel panel-default service-panel type2 filter-active" id="action<?= $list['id'] ?>">
            <div class="panel-heading" onclick="load_project_tasks('<?php echo $list['id']; ?>', '<?php echo $list['created_at']; ?>', '<?php echo $dueDate; ?>');"> 
                <a href="javascript:void(0)" onclick="delete_project(<?= $list['id']; ?>,<?= $list['template_id']; ?>)" class="btn btn-danger btn-xs btn-service-edit"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a> &nbsp;
                <!-- <a href="javascript:void(0)" onclick="CreateProjectModal('edit',<?//= $list['id'] ?>);" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>  &nbsp; --> 
                <a target="_blank" href="<?= base_url() . 'project/edit_project_template/' . base64_encode($list['id']); ?>" class="btn btn-primary btn-xs btn-service-edit-project"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Project</a> 

                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $list['id']; ?>" aria-expanded="false" class="collapsed">
                    <div class="table-responsive">
                        <table class="table table-borderless text-center" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th style="width:8%; text-align: center">Project ID</th>
                                    <th style="width:8%; text-align: center">Category</th>
                                    <th style="width:8%; text-align: center">Project Name</th>
                                    <th style="width:10%; text-align: center">Pattern</th>
                                    <!--<th style="width:8%; text-align: center">Client Type</th>-->
                                    <th style="width:8%; text-align: center">Client Id</th>
                                    <th style="width:8%; text-align: center">Responsible</th>
                                    <th style="width:8%; text-align: center">Requested By</th>
                                    <th style="width:8%; text-align: center">Assigned To</th>
                                    <th style="width:8%; text-align: center">Tracking</th>
                                    <th style="width:8%; text-align: center">Creation Date</th>
                                    <th style="width:8%; text-align: center">Due Date</th>
                                    <th style="width:8%; text-align: center">Next Recurrence</th>
                                    <th style="width:8%; text-align: center">Note</th>
                                </tr>
                                <tr>
                                    <td title="ID"><?= $list['id'] ?></td>
                                    <td title="Category"><?= get_template_category_name($list['template_cat_id']) ?></td>
                                    <td title="Project Name">
                                        <span class=""><?= $templatedetails->title ?></span>
                                    </td>
                                    <td title="Pattern"><?= ucfirst($pattern_details->pattern) ?></td>
                                    <!--<td title="Client Type"><? ($list['client_type'] == '1') ? 'Business Client' : 'Individual Client' ?></td>-->
                                    <!--<td title="Client"><?php // echo getProjectClientName($list['client_id'], $list['client_type']); ?><br><span class="text-info"><?php // echo getProjectClient($list['office_id']);      ?> </span></td>--> 
                                    <td title="Client"><?php echo getProjectClientPracticeId($list['client_id'], $list['client_type']); ?><br><span class="text-info"><?php // echo getProjectClient($list['office_id']);      ?> </span></td>                                                 
                                    <td title="Responsible"><?php
                                        $resp_value = get_assigned_office_staff_project_main($list['id'], $list['client_id']);
                                        if (is_numeric($resp_value['name'])) {
                                            $resp_name = get_assigned_by_staff_name($resp_value['name']);
                                        } else {
                                            $resp_name = $resp_value['name'];
                                        }
                                        if ($resp_value['office'] != 0) {
                                            $office_name = get_office_id($resp_value['office']);
                                        } else {
                                            if ($list['project_office_id'] == 1) {
                                                $office_name = 'Admin';
                                            } elseif ($list['project_office_id'] == 2) {
                                                $office_name = 'Corporate';
                                            } else {
                                                $office_name = 'Franchise';
                                            }
                                        }
                                        echo $resp_name . "<br><span class='text-info'>" . $office_name . " </span></td>";
                                        ?> </td>   
                                    <td title="Requested By"><?php echo isset(staff_info_by_id($list['added_by_user'])['full_name']) ? staff_info_by_id($list['added_by_user'])['full_name'] : ''; ?></td>
                                    <td title="Assign To"><span class="text-success"><?php echo get_assigned_dept_staff_project_main($list['id']); ?></span><br><?php
                                        if ($list['office_id'] != '2') {
                                            echo get_department_name_by_id($list['department_id']);
                                        } else {
                                            echo get_office_id($list['office_id']);
                                        }
                                        ?>
                                    </td>                                                  
                                    <td title="Tracking" class="text-center"><span id="trackouter-<?php echo $list['id']; ?>" class="label <?= $trk_class ?>"><?= $tracking ?></span></td>
                                    <td title="Creation Date"><?= date('m/d/Y', strtotime($list['created_at'])) ?></td>
                                    <td title="Due Date"><?= date('m/d/Y',strtotime($dueDate)) ?></td>
                                    <td title="Recurrence Date"><?= date('m/d/Y',strtotime($pattern_details->generation_date)); ?></td>

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
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </h5>
            </div>
            <!-- collapse section -->
            <div id="collapse<?= $list['id']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">

            </div>
        </div>
        <?php
        $row_number = $row_count + 1;
    }
    if (isset($page_number) && $row_number < count($project_list)):
        ?>
        <div class="text-center p-0 load-more-btn">
            <a href="javascript:void(0);" onclick="loadProjectDashboard('', '', '', '', '', '', '', '', '', '', '', '', '', <?= $page_number + 1; ?>);" class="btn btn-success btn-sm m-t-30 p-l-15 p-r-15"><i class="fa fa-arrow-down"></i> Load more results</a>
        </div>
    <?php endif; ?>
    <script>
        $(function () {
            $('h2.result-count-h2').html('<?= $row_number . ' Results found of ' . count($project_list) ?>');
    <?php if (isset($page_number) && $row_number === count($project_list)): ?>
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