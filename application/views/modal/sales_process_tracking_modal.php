<?php
$staff_info = staff_info();
$staff_id = sess('user_id');
$staff_dept = $staff_info['department'];
$stafftype = $staff_info['type'];
$staffrole = $staff_info['role'];
$staff_department = explode(',', $staff_info['department']);
$track = [];
if ($stafftype == 1 || $stafftype == 3 || ($stafftype == 2 && (in_array(6, $staff_department)))) {
    $track[] = 'new';
    $track[] = 'started';
}
if ($stafftype == 2 && (in_array(8, $staff_department))) {
    $track[] = 'completed';
}
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
                    <?php if (in_array('new', $track)): ?>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad0"
                                       value="0" <?= ($current_status == "0") ? "checked" : ""; ?>>
                                <label for="rad0"><strong>New</strong></label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('started', $track)): ?>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad1"
                                       value="1" <?= ($current_status == "1") ? "checked" : ""; ?>>
                                <label for="rad1"><strong>Started</strong></label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('completed', $track)): ?>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2"
                                       value="2" <?= ($current_status == "2") ? "checked" : ""; ?>>
                                <label for="rad2"><strong>Completed</strong></label>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" value="<?= $id ?>">
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="update_sales_process_status()">Save Changes</button>
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
                                <td><?= staff_department_name($value['id']); ?></td>
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
    function update_sales_process_status() {
        var status = $('input[name=radio]:checked').val();
        var id = $("#id").val();
        $.post(base_url + 'action/home/update_sales_process_status', {status: status, id: id}, function (result) {
            if (result == "1") {
                goURL(base_url + 'action/home/sales_tax_process');
            } else {
                swal("ERROR!", "Unable To Update Status", "error");
            }
        }
        );
    }
</script>