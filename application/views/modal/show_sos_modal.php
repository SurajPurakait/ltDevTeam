<?php
// echo "<pre>";
// print_r($all_sos);exit;
if (!empty($all_sos)) {
    $i = 0;
    $len = count($all_sos);
    $sosids = '';
    foreach ($all_sos as $key => $nd) :
        ?>
        <a href="javascript:void(0);">
            <div id="<?= 'sos-noti-' . $nd['id']; ?>" class="clearfix p-b-10 p-t-10 <?= ($nd['read_status'] == 1)  ? 'inactive-sos' : 'active-sos'; ?> <?= (($nd['added_by_user'] == sess('user_id')) && ($nd['read_status'] == 1)) ? 'alert alert-info' : 'alert alert-warning'; ?>">
                <!-- <ul class="notification-list"> -->
                    <!-- <li><?//= get_assigned_by_staff_name($nd['added_by_user']); ?></li> -->
                    <!-- <li>(<?//= staff_department_name($nd['added_by_user']); ?>)</li> -->
                    <!-- <li><?//= date('m-d-Y h:i', strtotime($nd['added_on'])); ?></li> -->
                <!-- </ul> -->
                <div class="row">
                    <div class="col-md-12"><h3 class="notification-text-area"><?= $nd['msg']; ?></h3></div>
                    <div class="text-left col-md-6"><p><?= get_assigned_by_staff_name($nd['added_by_user']); ?></p></div>
                    <div class="text-right col-md-6"><p><?= date('m-d-Y h:i', strtotime($nd['added_on'])); ?></p></div>
                </div>
                
            </div>
        </a>
        <?php if ($nd['added_by_user'] != sess('user_id')) { ?>
            <div class="clearfix">
                <a href="javascript:void(0);" class="replysos pull-right m-b-5" onclick="setReply('<?= $nd['id']; ?>')"><i class="fa fa-reply"></i> Reply</a>
            </div>
            <form style="display: none;" method="post" id="sos_note_form_reply_<?= $nd['id']; ?>">
                <div class="modal-body">
                    <h4 id="sos-title">Reply SOS</h4>
                    <div class="form-group" id="add_sos_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="sos_note"  title="SOS Note"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="mainsos" id="mainsos" value="<?= $nd['id']; ?>">
                    <input type="hidden" name="reference" id="reference" value="<?= $nd['reference']; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_sos_<?= $nd['id']; ?>" class="btn btn-primary" onclick="reply_action_sos('<?= $nd['id']; ?>');">Post</button>
                </div>
            </form>
            <hr>
        <?php
        }
        if ($i == $len - 1) {
            $sosids .= $nd['id'];
        } else {
            $sosids .= $nd['id'] . ',';
        }
        ?>
        <?php $i++;
    endforeach;
//    echo $all_sos[0]['reference'].','.$all_sos[0]['service_id'];
    if($all_sos[0]['reference']=='projects'){      // This is used only project related
        $task_id=$all_sos[0]['service_id'];
    }else{
        $task_id='';
    }
    ?>
            
    <div class="clearfix"><a href="javascript:void(0);" onclick="clear_sos('<?= $sosids; ?>', '<?= $all_sos[0]['reference']; ?>','<?= $all_sos[0]['reference_id'] ?>','','<?= $task_id ?>')" title="Clear SOS Notifications" class="pull-right">Clear SOS Notifications</a></div>
<?php } ?>
