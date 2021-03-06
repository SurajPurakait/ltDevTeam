<?php $staff_info = staff_info(); ?>
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
                            <input <?php echo ($staff_info['type']==4)? 'disabled' : ''; ?> type="radio" name="radio" id="rad0"
                                   value="0" <?= ($current_status == "0") ? "checked" : ""; ?>>
                            <label for="rad0"><strong>New</strong></label>
                        </div>
                    </div>
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <input <?php echo ($staff_info['type']==4)? 'disabled' : ''; ?> type="radio" name="radio" id="rad3"
                                   value="3" <?= ($current_status == "3") ? "checked" : ""; ?>>
                            <label for="rad3"><strong>Active</strong></label>
                        </div>
                    </div>
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <input <?php echo ($staff_info['type']==4)? 'disabled' : ''; ?> type="radio" name="radio" id="rad1"
                                   value="1" <?= ($current_status == "1") ? "checked" : ""; ?>>
                            <label for="rad1"><strong>Complete</strong></label>
                        </div>
                    </div>
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <input <?php echo ($staff_info['type']==4)? 'disabled' : ''; ?> type="radio" name="radio" id="rad2"
                                   value="2" <?= ($current_status == "2") ? "checked" : ""; ?>>
                            <label for="rad2"><strong>Inactive</strong></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="id" id="id" value="<?= $id ?>">

        <div class="modal-footer text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <?php 
                if($staff_info['type']!=4){
             ?>
            <button type="button" class="btn btn-primary" onclick="update_lead_status()">Save Changes</button>
        <?php } ?>
        </div>
        <?php if (!empty($tracking_logs)): ?>
            <div class="modal-body">
                <div style="height:200px; overflow-y: scroll">
                    <table id="status_log" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>time</th>
                        </tr>
                        </thead>
                        <?php foreach ($tracking_logs as $value): ?>
                            <tr>
                                <td><?= $value["stuff_id"]; ?></td>
                                <td><?= staff_department_name($value["id"]); ?></td>
                                <td><?= $value["status"]; ?></td>
                                <td><?= $value["created_time"]; ?></td>
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

<script type="application/javascript">
    function update_lead_status() {
        var status = $('input[name=radio]:checked').val();
        var id = $("#id").val();
        $.post(base_url + 'lead_management/home/update_action_status', {status: status, id: id}, function (result) {
                if (result == "1") {
                    swal({title: "Success!", text: "Status Successfully Updated!", type: "success"}, function () {
                        //load_partners_dashboard();
                        //$('#modal_area').modal('toggle');
                        location.reload(true);
                    });
                } else {
                    swal("ERROR!", "Unable To Update Status", "error");
                }
            }
        );
    }
</script>