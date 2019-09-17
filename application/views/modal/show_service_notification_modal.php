<div style="height:480px; overflow-y: scroll">
    <?php
    $notification_count = 0;
    foreach ($general_notification_list as $notification_index => $gnl) {
        $diff_days = $gnl['how_old_days'];
        $diff_text = 'more30';
        if ($diff_days == 0) {
            $diff_text = 'today';
        } elseif ($diff_days == 1) {
            $diff_text = 'yesterday';
        } elseif ($diff_days > 1 && $diff_days <= 7) {
            $diff_text = 'last7';
        } elseif ($diff_days > 7 && $diff_days <= 30) {
            $diff_text = 'last30';
        }
        ?>
        <div class="feed-element notification-item notification-<?= $gnl['reference']; ?> notification-<?= ($notification_index > 4) ? 'hide' : 'show'; ?> notification-<?= $diff_text; ?>" id="notification-div-<?= $gnl['id']; ?>">
            <?php if ($gnl['user_id'] == sess('user_id')): ?>
            <a href="javascript:void(0);" onclick="readActionNotification('<?= $gnl['id']; ?>','order');document.getElementById('notification-div-<?= $gnl['id']; ?>').remove();" class="pull-right text-muted p-5 p-t-0"><i class="fa fa-times"></i></a>
            <?php endif; ?>
            <a class="media-body" href="<?php echo base_url(); ?>services/home/view/<?php echo $gnl['reference_id']; ?>">
                <?= $gnl['notification_text']; ?> <br>
                <small class="text-muted"><?= ($diff_days == 0 ? date('h:i A', strtotime($gnl['added_on'])) . ', Today' : date('h:i A - m/d/Y', strtotime($gnl['added_on']))) . ' | <strong>' . $gnl['added_by_user_office'] . '</strong>'; ?></small>
            </a>
        </div>
        <?php
        $notification_count++;
    }
    ?>
</div>