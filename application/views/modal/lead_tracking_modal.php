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
                            <input type="radio" name="radio" id="rad0" class="inactive_msg"
                                   value="0" <?= ($current_status == "0") ? "checked" : "";?> <?= ($current_status == "2") ? "disabled": ""; ?>>
                            <label for="rad0"><strong>New</strong></label>
                        </div>
                    </div>
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <input type="radio" name="radio" id="rad3"
                                   class="inactive_msg" value="3" <?= ($current_status == "3") ? "checked" : ""; ?>  <?= ($current_status == "2") ? "disabled": ""; ?>>
                            <label for="rad3"><strong>Active</strong></label>
                        </div>
                    </div>
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <input type="radio" name="radio" id="rad1" class="inactive_msg"
                                   value="1" <?= ($current_status == "1") ? "checked" : ""; ?> <?= ($current_status == "2") ? "disabled": ""; ?>>
                            <label for="rad1"><strong>Complete</strong></label>
                        </div>
                    </div>
                    <div class="funkyradio">
                        <div class="funkyradio-success">
                            <input type="radio" name="radio" id="rad2" class="inactive_msg"
                                   value="2" <?= ($current_status == "2") ? "checked" : ""; ?> <?= ($current_status == "2") ? "disabled": ""; ?>>
                            <label for="rad2"><strong>Inactive</strong></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" value="<?= $id ?>">
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary lead_tracking_save_btn" onclick="update_lead_status(<?= $current_status;?>)">Save Changes</button>
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
<script type="text/javascript">
    function update_lead_status(status) {
        if (status != 2) {
            var status = $('input[name=radio]:checked').val();
            var id = $("#id").val();
            $.ajax({
                type: 'POST',
                url: base_url + 'lead_management/home/update_lead_status',
                data: {
                    status: status,
                    id: id
                },
                success: function (result) {
                    if (result.trim() == "1") {
                        swal({title: "Success!", text: "Status Successfully Updated!", type: "success"}, function () {
                            $.ajax({
                                type : 'POST',
                                url : base_url + 'lead_management/home/get_updated_lead_status',
                                data : {lead_id : id },
                                success: function(result) {
                                    var cls = "";
                                    if (result == 'Completed') {
                                        cls = 'label label-primary';
                                    } else if(result == 'Active') {
                                        cls = 'label lead-warning';
                                    } else if(result == 'Inactive') {
                                        cls = 'label label-danger';
                                    } else {
                                        cls = 'label label-success';
                                    }
                                    $("#lead_status_"+id).replaceWith('<span class="'+cls+'" id="lead_status_'+id+'">'+ result+'</span>');
                                }
                            });                            
                        });
                        $('#modal_area').modal('hide');
                    } else {
                        swal("ERROR!", "Unable To Update Status", "error");
                    }
                },
                beforeSend: function () {
                     $(".lead_tracking_save_btn").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    closeLoading();
                }
            });
        } else {
            swal("ERROR!", "Unable To Update Status of Inactive Lead", "error");    
        }    
    }
</script>