<?php
$user_info = staff_info();
$user_department = $user_info['department'];
$user_type = $user_info['type'];
// $office_name = get_office_name_by_office_id($user_info['office']);
$office_name = get_office_name_for_action_view($data['id']);
foreach ($data['staffs'] as $staff) {
    $staffinfo[] = staff_info_by_id($staff);
}
$added_by = staff_info_by_id($data['added_by_user']);
$added_by_office = staff_office_name($data['added_by_user']);
$added_by_department = get_department_name_by_id($data['created_department']);
$created_by_office = get_office_name_by_office_id($data['created_office']);


$tracking_status = "";
$trk_class = "";

if ($data["status"] == 0) {
    $tracking_status = "New";
    $trk_class = "label-success";
} elseif ($data["status"] == 1) {
    $tracking_status = "Started";
    $trk_class = "label-yellow";
} elseif ($data["status"] == 2) {
    $tracking_status = "Completed";
    $trk_class = "bg-purple";
} elseif ($data['status'] == 6) {
    $tracking_status = "Resolved";
    $trk_class = "label-primary";
} else {
    $tracking_status = "Canceled";
    $trk_class = "label-danger";
}
?>
<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md">
        <div class="row">
            <div class="col-md-3">                
                <h2 class="m-b-20">Action ID <b>#<?= $action_id; ?></b></h2>
            </div>
            <div class="col-md-9">
                <div class="row text-right m-b-20">
                    <div class="col-md-4">
                        <a class="btn btn-primary w-100 m-b-10 f-s-11" href="<?= base_url("/action/home/create_action") ?>"><i class="fa fa-plus"></i> Create New Action</a>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-success w-100 m-b-10 f-s-11" href="<?= base_url("/action/home") ?>">Go Back To Dashboard</a>
                    </div>
                    <?php if ($data['status'] == '0') { ?>

                        <div class="col-md-4">
                            <a href="<?= base_url("/action/home/edit_action/{$action_id}"); ?>" class="btn btn-warning btn-service-edit w-100 m-b-10 f-s-11"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>



        <div class="clearfix"></div>
        <?php $verticale = 'style=" {
    border-left: 6px solid green;
    height: 500px;
    position: absolute;
    left: 50%;
    margin-left: -3px;
    top: 0;"' ?>
        <?php $style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"'; ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" style="width:100%;">
                <tbody>
                    <tr align='center'>
                        <td class="bg-light-green" colspan='2' style="width:50%;" <?= $style; ?>>
                            <h3><b>From</b></h3>
                        </td>

                        <td class="bg-light-orange" colspan='2' style="width:50%;" <?= $style; ?>>
                            <h3><b>To</b></h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-light-green" <?= $style; ?> width="12%">
                            <b>Name:</b>
                        </td>
                        <td class="bg-light-green" <?= $style; ?> width="38%">
                            <?= $added_by['last_name'] . ', ' . $added_by['first_name'] . ' ' . $added_by['middle_name'] ?>
                        </td>
                        <td class="bg-light-orange" width="12%">
                            <b>Name:</b>
                        </td>
                        <td class="bg-light-orange" <?= $style; ?> width="38%">
                            <?php
                            $count = count($staffinfo);
                            if ($count == 1) {
                                foreach ($staffinfo as $staff):
                                    if(isset($staff['last_name'])){
                                        $last_name = $staff['last_name'];
                                    }else{
                                        $last_name = '';
                                    }
                                    if(isset($staff['first_name'])){
                                        $first_name = $staff['first_name'];
                                    }else{
                                        $first_name = '';
                                    }
                                    if(isset($staff['middle_name'])){
                                        $middle_name = $staff['middle_name'];
                                    }else{
                                        $middle_name = '';
                                    }
                                    if($last_name!='' && $first_name!=''){
                                        echo $last_name . ', ' . $first_name . ' ' . $middle_name;
                                    }
                                endforeach;
                            }
                            ?>
                            <?php
                            $user_info = staff_info();
                            $user_department = $user_info['department'];
                            $user_type = $user_info['type'];
                            $role = $user_info['role'];

                            $action_staffs = action_staff_by_action_id($action_id);

                            if (count($action_staffs) != 1) {
                                if ($user_type == 1 || ($user_type == 2 && $role == 4) || ($user_type == 3 && $role == 2)) {
                                    ?>
                                    <a href="javascript:void(0);" onclick="show_action_assign_modal('<?= $data["id"]; ?>');" class="label label-success"><i class="fa fa-plus"></i> Assign</a>
                                <?php } else { ?>
                                    <a href="javascript:void(0);" onclick="assignAction('<?= $data["id"]; ?>', '<?= sess('user_id'); ?>')" class="label label-success"><i class="fa fa-plus"></i> Assign</a>
                                <?php } ?>&nbsp;
                                <!-- <label class="label label-default">Unassigned</label> -->
                                <?php
                            } else {
                                ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;<label class="label label-primary">Assigned</label>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-light-green" <?= $style; ?>>
                            <b>Department:</b>
                            <!-- <b>Office:</b> -->
                        </td>
                        <td class="bg-light-green" <?= $style; ?>>
                            <?php
                            echo $added_by_department;
                            ?>
                        </td>
                        <td class="bg-light-orange" <?= $style; ?>>
                            <b>Department:</b>
                        </td>
                        <td class="bg-light-orange" <?= $style; ?>>
                            <?php
                            foreach ($departments as $value):
                                ?>
                                <?= ($value["id"] == $data["department"]) ? $value["name"] : ''; ?>
                                <?php
                                //endif;
                            endforeach;
                            ?>
                        </td>
                    </tr>
                    <?php if ($data['department'] != 3) { ?>
                        <tr>
                            <td class="bg-light-green" <?= $style; ?>>
                                <b>Office:</b>
                            </td>
                            <td class="bg-light-green" <?= $style; ?>>
                                <?php
                                echo $created_by_office;
                                ?>
                            </td>
                            <td class="bg-light-orange" <?= $style; ?>>
                                <b>Office:</b>
                            </td>
                            <td class="bg-light-orange" <?= $style; ?>>
                                <?php
                                // if($count != 1){
                                //     echo "Taxleaf Corporate";
                                // }else{
                                //    echo $office_name; 
                                // }
                                echo $office_name['name'];
                                ?>
                            </td>
                        </tr>
                    <?php } ?>                    
                </tbody>
            </table>
        </div>

        <div class="action-details m-t-20">
            <?php
            if ($data['priority'] != 0) {
                echo '<div class="priority-horizontal">';
                switch ($data['priority']) {
                    case 1:
                        //echo 'High';
                        echo '<img src="' . base_url() . 'assets/img/badge_high_priority_horizontal.png" />';
                        break;
                    case 2:
                        //echo 'Medium';
                        echo '<img src="' . base_url() . 'assets/img/badge_medium_priority_horizontal.png" />';
                        break;
                    case 3:
                        //echo 'Low';
                        echo '<img src="' . base_url() . 'assets/img/badge_low_priority_horizontal.png" />';
                        break;
                    default:
                        break;
                }
                echo '</div>'; //.priority
            }
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered"> 

                    <?php
                    if ($data['client_id'] != '') {
                        ?>
                        <tr>
                            <td <?= $style; ?> width="220"> 
                                <b>Client ID:</b>
                            </td>
                            <td><?= $data['client_id']; ?></td>

                        </tr>
                    <?php } ?>  
                    <tr>
                        <td>
                            <b style="white-space: nowrap;">Tracking</b>
                        </td>
                        <td>
                            <a href='javascript:void(0);' onclick='show_action_tracking_modal("<?= $action_id; ?>", "view_action")' class="d-inline m-t-10">
                                <span class='label <?php echo $trk_class; ?>'><?= $tracking_status ?></span>
                            </a>
                        </td>
                    </tr>            

                    <?php if ($data['creation_date'] != '0000-00-00') { ?>
                        <tr class="">
                            <td <?= $style; ?>>
                                <b style="white-space: nowrap;">Created Date:</b>
                            </td>
                            <td><?= date('m/d/Y - h:i A', strtotime($data['creation_date'])); ?></td>
                        </tr>
                    <?php } else { ?>
                        <tr class="bg-light-purple">
                            <td <?= $style; ?>>
                                <b style="white-space: nowrap;">Created Date:</b>
                            </td>
                            <td><?php echo 'N/A'; ?></td>
                        </tr>   
                    <?php } ?>
                    <?php if ($data['start_date'] != '0000-00-00') { ?>
                        <tr class="">
                            <td <?= $style; ?>>
                                <b style="white-space: nowrap;">Start Date:</b>
                            </td>
                            <td><?= date('m/d/Y', strtotime($data['start_date'])); ?></td>
                        </tr>
                    <?php } else { ?>
                        <tr class="">
                            <td <?= $style; ?>>
                                <b style="white-space: nowrap;">Start Date:</b>
                            </td>
                            <td><?php echo 'N/A'; ?></td>
                        </tr>   
                    <?php } ?>
                    <?php if ($data['complete_date'] != '0000-00-00') { ?>
                        <tr class="">
                            <td <?= $style; ?>>
                                <b style="white-space: nowrap;">Complete Date:</b>
                            </td>
                            <td><?= date('m/d/Y', strtotime($data['complete_date'])); ?></td>
                        </tr>
                    <?php } else { ?>
                        <tr class="">
                            <td <?= $style; ?>>
                                <b style="white-space: nowrap;">Complete Date:</b>
                            </td>
                            <td><?php echo 'N/A'; ?></td>
                        </tr>   
                    <?php } ?>

                    <tr>
                        <td <?= $style; ?>>
                            <b style="white-space: nowrap;">Subject:</b>
                        </td>
                        <td><?= $data['subject']; ?></td>
                    </tr>

                    <tr>
                        <td <?= $style; ?>>
                            <b style="white-space: nowrap;">Message:</b>
                        </td>
                        <td><?= "<p  style='white-space: normal;'>" . $data['message'] . "</p>"; ?></td>
                    </tr>

                    <?php if ($data['due_date'] != '0000-00-00') { ?>
                        <tr class="">
                            <td <?= $style; ?>>
                                <b style="white-space: nowrap;">Due Date:</b>
                            </td>
                            <td><?= date('m/d/Y', strtotime($data['due_date'])); ?></td>
                        </tr>
                    <?php } else { ?>
                        <tr class="">
                            <td <?= $style; ?>>
                                <b style="white-space: nowrap;">Due Date:</b>
                            </td>
                            <td><?php echo 'N/A'; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if (!empty($data['notes'])) { ?>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="white-space: nowrap;">Notes:</b>
                            </td>
                            <td>
                                <span style="margin-bottom: 10px; display: inline-block;"> 
                                    <?php
                                    $read_status = notes_read_status($action_id);
                                    // print_r($read_status);
                                    $note_added_data = get_action_status(2, 'action_id', $action_id);

                                    if (count($note_added_data) > 0 && in_array(0, $read_status)) {
                                        ?>    
                                        <a id="notecount-<?= $action_id; ?>" class="label label-danger" href="javascript:void(0)" onclick="show_action_notes(<?= $action_id; ?>)"><b> <?= count($note_added_data); ?></b></a>
                                        <?php
                                    } elseif (count($note_added_data) > 0 && in_array(1, $read_status)) {
                                        ?>    
                                        <a id="notecount-<?= $action_id; ?>" class="label label-success" href="javascript:void(0)" onclick="show_action_notes(<?= $action_id; ?>)"><b> <?= count($note_added_data); ?></b></a>
                                        <?php
                                    } else {
                                        ?>    
                                        <a id="notecount-<?= $action_id; ?>" class="label label-warning" href="javascript:void(0)" onclick="show_action_notes(<?= $action_id; ?>)"><b> <?= count($note_added_data); ?></b></a>
                                        <?php
                                    }
                                    ?>
                                </span>
                                <?php
                                // $separator_count = 0;
                                // print_r($data['notes']);
                                // echo $data['creation_date'];
                                // $note_added_data = get_action_status(2,'action_id',$action_id);
                                // print_r($note_added_data);die();
                                // $note_added_on = $note_added_data[0]['time'];
                                // $note_added_by = $note_added_data[0]['staff_name'];


                                foreach ($note_added_data as $note) {
                                    ?>
                            <li style="list-style-type: none;margin-bottom: 10px;"><?php
                                echo "<pre style='white-space: inherit;background:transparent; border: none;padding: 9.5px 0 0;margin-bottom: 5px;font-family: inherit; font-weight:600; color:#676a6c;'>" . $note['note'] . "</pre>";

                                echo "<span class='text-info'><b>By:&nbsp;</b>" . $note['staff_name'] . "</span> | <span class='text-warning'><b>Time:&nbsp;</b>" . date('m/d/Y - h:i A', strtotime($note['time'])) . "</span>";
                                ?></li>
                            <?php
                        }


                        // echo ($separator_count > 0) ? '<hr/>' : '' . $note;
                        // $separator_count++;
                        ?>
                        </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td <?= $style; ?>>
                            <b style="white-space: nowrap;">SOS</b>
                        </td>
                        <td>
                            <?php
                            $action_staffs = action_staff_by_action_id($action_id);
                            $stf = array_column($action_staffs, 'staff_id');
                            $new_staffs = implode(',', $stf);
                            ?>
                            <?php
                            $soslist = get_sos_list('action', 0, $action_id);
                            if (!empty($soslist)) {
                                ?>
                                <span>
                                    <a id="soscount-<?= $action_id; ?>" class="d-inline p-t-5 p-b-5 p-l-8 p-r-8 label <?php echo (get_sos_count_action('action', '', $action_id) == 0) ? 'label-primary' : 'label-danger'; ?>" title="SOS" href="javascript:void(0)" onclick="show_sos('action', '', '<?= $new_staffs; ?>', '<?= $action_id; ?>', '');">
                                        <?php 
                                            // echo (get_sos_count_action('action', '', $action_id) == 0) ? '<i class="fa fa-plus"></i>' : get_sos_count_action('action', '', $action_id);
                                            echo (get_sos_count('action', '', $action_id) == 0) ? '<i class="fa fa-plus label-green"></i>' : '<i class="fa fa-bell"></i>'; 
                                        ?>    
                                    </a>
                                </span>
                                <?php
                                foreach ($soslist as $value) {
                                    $added_sos_user = get_action_sos_added_username('action', $value['reference_id'], $value['added_by_user']);
                                    ?>
                            <li style="list-style-type: none;margin-bottom: 10px;"><?php
                                echo "<pre style='background:transparent; border: none;padding: 9.5px 0 0;margin-bottom: 5px;font-family: inherit; font-weight:600; color:#676a6c;'>" . $value['msg'] . "</pre>";

                                echo "<span class='text-info'><b>By:&nbsp;</b>" . $added_sos_user . "</span> | <span class='text-warning'><b>Time:&nbsp;</b>" . date('m/d/Y - h:i A', strtotime($value['added_on'])) . "</span>";
                                ?></li>

                            <!--                                <li style="list-style-type: none;">
                            <?php
//                                        echo $value['msg'];
//                                        echo "<br>  "."<b>Added On: </b>";
//                                        echo date('m/d/Y - h:i A', strtotime($value['added_on']));
//                                        // echo $value['added_on'];
//                                        echo "<br>"."<b>Added By: </b>";
//                                        echo $added_by['full_name'];
                            ?>        
                                                            </li>-->

                            <?php
                        }
                    } else {
                        ?>
                        <a id="soscount-<?= $action_id; ?>" class="d-inline p-t-5 p-b-5 p-l-8 p-r-8 label label-primary" title="SOS" href="javascript:void(0)" onclick="show_sos('action', '', '<?= $new_staffs; ?>', '<?= $action_id; ?>', '');"><i class="fa fa-plus"></i></a>
                    <?php }
                    ?>
                    </td>
                    </tr>


                    <tr>
                        <td <?= $style; ?>>
                            <b style="white-space: nowrap;">Action Files:</b>
                        </td>
                        <?php
//if (!empty($data['files'])) {
                        ?>
                        <td>
                            <?= '<span id="actionfilespan' . $action_id . '">' . ((count($data['files']) > 0) ? '<a class="label label-primary" href="javascript:void(0)" count="' . count($data['files']) . '" id="actionfile' . $action_id . '" onclick="show_action_files(\'' . $action_id . '\')"><b>' . count($data['files']) . '</b></a>' : '<a class="label label-warning" href="javascript:void(0)" count="' . count($data['files']) . '" id="actionfile' . $action_id . '" onclick="show_action_files(\'' . $action_id . '\')"><b>' . count($data['files']) . '</b></a>') . '</span><br><br>';
                            ?>

                            <?php
                            foreach ($data['files'] as $value) {
                                $file_id = $value['id'];
                                $extension = pathinfo($value['file_name'], PATHINFO_EXTENSION);
                                $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                $filename = explode("_", $value['file_name']);

                                if ($value['added_by_user'] != 0) {
                                    $added_by_userinfo = staff_info_by_id($value['added_by_user']);
                                    $added_files_username = $added_by_userinfo['last_name'] . ', ' . $added_by_userinfo['first_name'] . ' ' . $added_by_userinfo['middle_name'];
                                } else {
                                    $added_files_username = '';
                                }

                                if (in_array($extension, $allowed_extension)) {
                                    ?>
                            <li style="list-style-type: none">
                                <a href="<?= base_url(); ?>uploads/<?= $value['file_name']; ?>" target = "_blank"><i class="fa fa-search-plus"></i> <?= $filename[2]; ?></a>
                                <br>
                                <span class='text-info'><b>By:&nbsp;</b><?php echo $added_files_username; ?></span> | <span class='text-warning'><b>Time:&nbsp;</b><?php echo ($value['added_on'] != '0000-00-00 00:00:00') ? date('m/d/Y - h:i A', strtotime($value['added_on'])) : ''; ?></span>
                            </li>

                                                                                                                                <!--                                                    <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $value['file_name']; ?>');width: 150px; height: 150px;background-size: 100%;">
                                                                                                                                                                                        <a target = "_blank" href="<?php echo base_url(); ?>uploads/<?= $value['file_name']; ?>" title="<?= $value['file_name']; ?>"><i class="fa fa-search-plus"></i> <?= $value['file_name']; ?></a>
                                                                                                                                                                                    </div>-->
                        <?php } else {
                            ?>
                            <li style="list-style-type: none">
                                <a href="<?= base_url(); ?>uploads/<?= $value['file_name']; ?>" target = "_blank"><i class="fa fa-download"></i> <?= $filename[2]; ?></a>
                                <br>
                                <span class='text-info'><b>By:&nbsp;</b><?php echo $added_files_username; ?></span> | <span class='text-warning'><b>Time:&nbsp;</b><?php echo ($value['added_on'] != '0000-00-00 00:00:00') ? date('m/d/Y - h:i A', strtotime($value['added_on'])) : ''; ?></span>
                            </li>
                        <!-- <a target = "_blank" href = "<?php //echo base_url();                 ?>uploads/<?//= $value['file_name']; ?>" title = "<?//= $value['file_name']; ?>"><i class = "fa fa-download"></i> <?//= $value['file_name']; ?></a> -->
                            <!--                                    </div>-->
                            <?php
                        }
                    }
                    ?>


                    </td>
                    <?php // }   ?>
                    </tr>

                </table>
            </div>
        </div>

    </div>
</div>
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
           <!--  <form method="post" id="modal_note_form" action="<?//= base_url(); ?>action/home/addNotesmodal"> -->
            <form method="post" id="modal_note_form" onsubmit="add_action_notes();">
                <div class="modal-body">
                    <h4>Add New Note</h4>
                    <!-- <div class="col-lg-10">
                        <label class="checkbox-inline">
                            <input type="checkbox"  name="pending_request" id="pending_request" value="1"><b>Add to SOS Notification</b>
                        </label>
                    </div> -->
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="action_note[]"  title="Action Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-action-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="actionid" id="actionid">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="add_action_notes();" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                    <h4 id="sos-title">Add New SOS</h4>
                    <div class="form-group" id="add_sos_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="sos_note" title="SOS Note"></textarea>
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
                    <button type="button" id="save_sos" onclick="add_action_sos();" class="btn btn-primary">Save SOS</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

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

<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>