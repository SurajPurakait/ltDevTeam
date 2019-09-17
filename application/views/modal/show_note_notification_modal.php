<div class="modal-dialog modal-notification">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Note Notification</h3>
        </div>
        <div class="modal-body">
            <?php foreach ($notification_details as $key => $nd) : ?>
                <a href="javascript:void(0);">
                <div id="<?php echo 'note-noti-'.$nd['nid']; ?>" class="<?= (count($notification_details) != $key + 1) ? 'notification-area ' : ''; ?>p-b-10 p-t-10">
                    <ul class="notification-list">
                        <li>#<?= $nd['reference_id']; ?></li>
                        <li><?= $nd['staff_name']; ?></li>
                        <li>(<?= staff_department_name($nd['staff_id']); ?>)</li>
                    </ul>
                    <p class="notification-text-area"><?= $nd['note']; ?></p>
                </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>