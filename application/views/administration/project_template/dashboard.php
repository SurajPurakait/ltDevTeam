<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form" method="post" onsubmit="actionFilter()">
                                    <div class="form-group filter-inner">
                                        <div class="row">
                                            <div class="m-b-10 pull-left col-md-12">
                                                <a class="btn btn-primary" href="<?= base_url("/administration/template/create_template"); ?>"><i class="fa fa-plus"></i> Create New Template</a>
                                            </div>
                                        </div>                                        
                                    </div>                                    
                                </form>
                            </div>
                        </div>

                    </div>

                    <hr class="hr-line-dashed  m-t-5 m-b-5">
                    <div id="action_dashboard_div"><h2 class="text-primary"><?= count($project_list) ?> Results found</h2>
                        <?php
                        if (!empty($project_list)) {
                            foreach ($project_list as $list) {
                                $status = $list['status'];
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
                                $task_list = getTemplateTaskList($list['id']);
                                ?>
                                <div class="panel panel-default service-panel type2 filter-active" id="action<?= $list['id'] ?>">
                                    <div class="panel-heading">  
                                        <a target="_blank" href="<?= base_url().'administration/template/edit_project_template/'.$list['id'] ?>" class="btn btn-primary btn-xs btn-service-edit project-btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                        <a href="javascript:void(0)" class="btn btn-warning btn-xs btn-service-edit project-btn-edit" onclick="inactive_project_template('<?= $list['id']; ?>')"><i class="fa fa-ban" aria-hidden="true"></i> Inactive</a>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-xs btn-service-edit project-btn-edit" onclick="delete_project_template('<?= $list['id']; ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
                                        <?//= base_url().'administration/template/inactive_project_template/'.$list['id'] ?>                                
                                        <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $list['id']; ?>" aria-expanded="false" class="collapsed">
                                            <div class="table-responsive">
                                                <table class="table table-borderless text-center" style="margin-bottom: 0px;">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:8%; text-align: center">Template ID</th>
                                                            <th style="width:8%; text-align: center">Project Name</th>
                                                            <th style="width:10%; text-align: center">Description</th>
                                                            <th style="width:8%; text-align: center">Responsible</th>
                                                            <th style="width:8%; text-align: center">Assigned To</th>
                                                            <!--<th style="width:8%; text-align: center">Tracking</th>-->
                                                            <th style="width:8%; text-align: center" class="">Pattern</th>
                                                        </tr>
                                                        <tr>
                                                            <td title="Action ID"><?= $list['template_id'] ?></td>
                                                            <td title="Created By">
                                                                <!--onclick="user_details('<?//= $action['added_by_user']; ?>')"-->
                                                                <span class=""><?= $list['title'] ?></span>
                                                                <!--<br>Data<br><span class="text-info">CORP</span>-->
                                                            </td>
                                                             <td title="Message">
                                                                <a href="javascript:void(0);" data-toggle="popover" data-placement="top" data-content="<?= $list['description'] ?>" data-trigger="hover" title="" data-original-title=""><?= $list['description'] ?></a>
                                                            </td>
                                                             <!--$office_dtls= get_assigned_template_office($list['id']);-->
                                                            <?php $office_dtls= get_template_responsible_staff($list['id']);
//                                                            print_r($office_dtls);die;
                                                            $office_name=[];
                                                            foreach($office_dtls as $key => $ofc){
                                                                $office_name[]=$ofc;
                                                            }
                                                            ?>
                                                            <td title="Responsible"><span class="text-success"><?php echo get_assigned_office_staff_project_template($list['id']); ?></span><br><span><?php echo $office_name[0]; ?></span><br><span class="text-info"> <?php // echo $office_name[1]; ?> </span></td>   <!--
                                                            <-->
                                                            <!--<td></td>-->
                                                            <td title="Assign To"><span class="text-success"><?php echo get_assigned_dept_staff_project_template($list['id']); ?></span><br><?php echo get_assigned_template_department($list['id']); ?></td>                                                  
<!--                                                            <td title="Tracking Description" class="text-center" align="left">
                                                                <a href="javascript:void(0);" onclick="show_action_tracking_modal( & quot; 147 & quot; )">
                                                                    <span class="label <?= $trk_class ?>"><?= $tracking ?></span>
                                                                </a>
                                                            </td>-->
                                                            <!--<td title="Creation Date"><?= date('Y-m-d', strtotime($list['created_at'])) ?></td>/-->
                                                            <td title="Pattern"><?= ucfirst(get_template_pattern($list['id'])->pattern); ?> </td>
                                                            
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
                                                        <th style='width:20%;  text-align: center;'>Description</th>
                                                        <!--<th style='width:8%;  text-align: center;'>Created Date</th>-->
<!--                                                        <th style='width:8%;  text-align: center;'>Target Start Date Before Due Date</th>
                                                        <th style='width:8%;  text-align: center;'>Target Complete Date Before Due Date</th>-->
                                                        <th style='width:8%;  text-align: center;'>Assign To</th>
                                                        <th style='width:8%;  text-align: center;'>Note</th>
                                                    </tr>
                                                    <?php
                                                        foreach ($task_list as $task) {
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
                                                            ?>
                                                            <tr>
                                                                <td title="Order" class="text-center"><?= $task->task_order; ?></td>
                                                                <td title="Description" class="text-center"><?= (strlen($task->description)>100)?(substr_replace($task->description,'...',100)):$task->description; ?></td>
                                                                <!--<td title="Order" class="text-center"><?= date('Y-m-d', strtotime($task->created_at)); ?></td>-->
<!--                                                                <td title="Target Start Date" class="text-center"><?= $task->target_start_date; ?></td>
                                                                <td title="Target Complete Date" class="text-center"><?= $task->target_complete_date; ?></td>-->
                                                                <!--<td title="assign to"></td>-->
                                                                <td title="Assign To" class="text-center"><span class="text-success"><?php echo get_assigned_task_staff($task->id); ?></span><br><?php echo get_assigned_task_department($task->id); ?></td>                                                    
                                                                <!--<td title="Tracking Description" class="text-center"><span class="label <? $trk_class ?>"><? $tracking ?></span></td>-->
                                                                <td title='Note' class="text-center"><a id="notecount-<?= $task->id ?>" class="label label-danger" href="javascript:void(0)" onclick="show_task_notes(<?= $task->id; ?>)"><b> <?= get_task_note_count($task->id) ?></b></a></td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showTaskNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" id="modal_note_form_update" onsubmit="update_task_notes();">
                <div id="notes-modal-body" class="modal-body p-b-0"></div>
                <div class="modal-body p-t-0 text-right">
                    <button type="button" id="update_note" onclick="update_task_notes();" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
           <!--  <form method="post" id="modal_note_form" action="<?//= base_url(); ?>action/home/addNotesmodal"> -->
            <form method="post" id="modal_note_form" onsubmit="add_task_notes();">
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
                    <button type="button" id="save_note" onclick="add_task_notes();" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>