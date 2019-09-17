<?php
$user_info = staff_info();
$user_type = $user_info['type'];
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-center"></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <input type="radio" name="radio" id="rad0"
                                   value="0" 
                                   <?php
                                   if ($current_status == "0") {
                                       echo "checked";
                                   } elseif ($current_status == "6" && sess('user_id') != $added_by_user_id) {
                                       echo "disabled";
                                   } elseif ($current_status == "1") {
                                       echo "disabled";
                                   } else {
                                       echo "";
                                   }
                                   ?>
                                   >
                            <label for="rad0"><strong>New</strong></label>
                        </div>
                    </div>
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <input type="radio" name="radio" id="rad1"
                                   value="1" <?php
                                   if ($current_status == "1") {
                                       echo "checked";
                                   } elseif ($current_status == "6" && sess('user_id') != $added_by_user_id) {
                                       echo "disabled";
                                   } else {
                                       echo "";
                                   }
                                   ?>
                                   >
                            <label for="rad1"><strong>Started</strong></label>
                        </div>
                    </div>
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <input type="radio" name="radio" id="rad6"
                                   value="6" 
                                   <?php
                                   if ($current_status == "6") {
                                       echo "checked";
                                       if ($sos_read_status == '0') {
                                           echo 'onclick = clear_sos_msg("resolved");';
                                       } else {
                                           echo "";
                                       }
                                   } else {
                                       if ($sos_read_status == '0') {
                                           echo 'onclick = clear_sos_msg("resolved");';
                                       } else {
                                           echo '';
                                       }
                                   }
                                   ?>>
                            <label for="rad6"><strong>Resolved</strong></label>
                        </div>
                    </div>
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <?php
                            if ($priority==1 && sess("user_id") != $added_by_user_id && $user_type != 1) { 
                                $disable='disabled';
                            }else{
                                $disable='';
                            }
?>
                            <input type="radio" name="radio" <?= $disable ?> id="rad2"
                                   value="2" 
                                   <?php
                                   
                                       if ($current_status == "2") {
                                           echo "checked";
                                           if ($sos_read_status == '0') {
                                               echo 'onclick = clear_sos_msg("completed")';
                                           }else{
                                               echo '';
                                           }
                                       } elseif (($priority == "1" && sess('user_id') != $added_by_user_id)) {
                                           if ($sos_read_status == '0') {
                                               echo 'onclick = clear_sos_msg("completed")';
                                           } else {
                                               echo '';
                                           }
                                       } else {
                                           if ($sos_read_status == '0') {
                                               echo 'onclick = clear_sos_msg("completed")';
                                           } else {
                                               echo '';
                                           }
                                       }
                                   
                                   ?>
                                   >
                            <label for="rad2"><strong>Completed</strong></label>
                        </div>
                    </div>
                    <?php
                    if ($page_name == 'view_action') {
                        if ($added_by_user_id == sess('user_id')) {
                            ?>
                            <div class="funkyradio">
                                <div class="funkyradio-success">
                                    <input type="radio" name="radio" <?= $disable ?> id="rad7"
                                           value="7" 
                                           <?php
                                           
                                               if ($current_status == "7") {
                                                   echo "checked";
                                                   if ($sos_read_status == '0') {
                                                       echo 'onclick = clear_sos_msg("cancelled")';
                                                   }
                                               } else {
                                                   if ($sos_read_status == '0') {
                                                       echo 'onclick = clear_sos_msg("cancelled")';
                                                   } else {
                                                       echo "";
                                                   }
                                               }
                                           
                                           ?>>
                                    <label for="rad7"><strong>Canceled</strong></label>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" <?= $disable ?> id="rad7"
                                       value="7" 
                                       <?php
                                           if ($current_status == "7") {
                                               echo "checked";
                                               if ($sos_read_status == '0') {
                                                   echo 'onclick = clear_sos_msg("cancelled")';
                                               }
                                           } else {
                                               if ($sos_read_status == '0') {
                                                   echo 'onclick = clear_sos_msg("cancelled")';
                                               }
                                               echo "";
                                           }
                                       
                                       ?>>
                                <label for="rad7"><strong>Canceled</strong></label>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <h5>Add Comment</h5>
                        <div class="note-textarea">
                            <textarea class="form-control" id="tracking_comment" name="tracking_comment" title="Action Tracking Comment"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" value="<?= $id ?>">

        <input type="hidden" name="page_name" id="page_name" value="<?= $page_name ?>">

        <div class="modal-footer text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="tracking-button" onclick="update_action_status()">Save Changes</button>
        </div>
        <?php if (!empty($tracking_logs)): ?>
            <div class="modal-body">
                <div style="height:200px; overflow-y: scroll">
                    <table id="status_log" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Department</th>
                                <th>Status</th>
                                <!-- <th>Comment</th> -->
                            </tr>
                        </thead>
                        <?php foreach ($tracking_logs as $value): ?>
                            <tr>
                                <td><?=
                                    // echo $value['created_time'];
                                    date('m/d/Y - h:i A', strtotime($value['created_time']));
                                    ?></td>
                                <td><?= $value["stuff_id"]; ?></td>
                                <td><?= staff_department_name($value['id']); ?></td>
                                <td><?= $value["status"]; ?></td>

                                                                                            <!-- <td> -->
                                <?php
                                // echo $value["comment"]; 
                                ?>

                                <!-- </td> -->
                            </tr>
                        <?php endforeach; ?>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
<?php
if (!empty($tracking_logs)) {
    ?>
        $('#status_log').dataTable({
            "bFilter": false,
            "bInfo": false,
            "bPaginate": false,
            "sDom": '<"top">rt<"bottom"flp><"clear">'
        });
    <?php
}
?>
    function update_action_status() {
        // alert(page_name);return false;
        var status = $('input[name=radio]:checked').val();
        // alert(status);return false;
        var id = $("#id").val();
        var page_name = $("#page_name").val();
        // alert(page_name);return false;
        var comment = $("#tracking_comment").val();
        var allstaffs = $(".action-all-staffs-"+id).val();
        $.ajax({
            type: 'POST',
            url: base_url + '/action/home/update_action_status',
            data: {
                status: status,
                id: id,
                comment: comment,
                allstaffs: allstaffs
            },
            success: function (result) {
                if (result == "1") {
                    if (page_name == 'ajax_dashboard') {
                        //goURL(base_url + 'action/home');
                        //goURL(base_url + 'action/home/view_action/'+ id);
                        if (status == 0) {
                            var tracking = 'New';
                            var trk_class = 'label-success';
                        } else if (status == 1) {
                            var tracking = 'Started';
                            var trk_class = 'label-yellow';
                        } else if (status == 2) {
                            var tracking = 'Completed';
                            var trk_class = 'bg-purple';
                        } else if (status == 6) {
                            var tracking = 'Resolved';
                            var trk_class = 'label-primary';
                        } else if (status == 7) {
                            var tracking = 'Canceled';
                            var trk_class = 'label-danger';
                        }
                        $("#actiontracking-" + id).find('span').removeClass().addClass('label ' + trk_class);
                        $("#actiontracking-" + id).find('span').html(tracking);
                        $("#modal_area").modal('hide');
                    } else if (page_name == 'view_action') {
                        goURL(base_url + 'action/home/view_action/' + id);
                    }
                } else {
                    swal("ERROR!", "Unable To Update Status", "error");
                }
            },
            beforeSend: function () {
                $("#tracking-button").prop('disabled', true).html('Processing...');
                openLoading();
            },
            complete: function (msg) {
                //$("#tracking-button").removeAttr('disabled').html('Save Changes');
                closeLoading();
            }
        });
    }
</script>