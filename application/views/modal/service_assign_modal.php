<?php $staff_list = $all_staffs; ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Assign Service</h3>
        </div>
        <form class="form-horizontal" method="post" id="form_order_modal" onsubmit="return false;">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">All Staff<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select name="staff" class="form-control" id="service_staff" title="Staff">
                            <?php foreach ($staff_list as $staff_id) { ?>
                                <option value="<?= $staff_id; ?>"><?= staff_info_by_id($staff_id)['full_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="button" onclick="assignService(<?= $service_id ?>, getIdVal('service_staff'))">Assign</button> &nbsp;&nbsp;&nbsp;
                <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>