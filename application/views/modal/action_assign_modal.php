<?php $staff_list = action_staff_by_action_id($action_id); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Assign Action</h3>
        </div>
        <form class="form-horizontal" method="post" id="form_action_modal" onsubmit="return false;">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">All Staff<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select id="action_staff" name="staff" class="form-control" id="action_staff" title="Staff">
                            <?php foreach ($staff_list as $sl) { ?>
                                <option value="<?= $sl['staff_id']; ?>"><?= staff_info_by_id($sl['staff_id'])['full_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="button" onclick="assignAction(<?= $action_id ?>, getIdVal('action_staff'))">Assign</button> &nbsp;&nbsp;&nbsp;
                <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>