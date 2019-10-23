<?php
if (!empty($main_title_array)) {
    foreach ($main_title_array as $lmc) {

        // $lead_campaign_mails = mail_campaign_list($lmc['service'], $lmc['language'], $day, $status);
        $lead_campaign_mails = mail_campaign_list($lmc['lead_type'], $lmc['language'], $day, '');
        $status = (array_multiply(array_column($lead_campaign_mails, 'status'))) == 0 ? 0 : 1;
        
        if($lmc['lead_name'] !=''){
        ?>
        <div class="panel panel-default service-panel">
            <div class="panel-heading">
                <div class="priority"><img src="<?= base_url('assets/img/' . (($status == 0) ? 'badge_inactive.png' : 'badge_active.png')); ?>" /></div>
                <a href="javascript:void(0);" onclick="changeCampaignStatus(<?= $lmc['lead_type']; ?>, <?= $lmc['language']; ?>, <?= ($status == 0) ? 1 : 0; ?>);" class="btn btn-<?= ($status == 0) ? 'info' : 'danger'; ?> btn-xs btn-service-edit"><i class="fa fa-<?= ($status == 0) ? 'anchor' : 'remove'; ?>" aria-hidden="true"></i> <?= ($status == 0) ? 'Active' : 'Inactive'; ?></a>
                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $lmc['id']; ?>" aria-expanded="false">
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th class="text-center" width="50%">Lead Type</th>
                                    <th class="text-center" width="50%">Language</th>
                                    <!-- <th style="width:200px;">Language</th> -->
                                </tr>
                                <tr>
                                    <td class="text-center" width="50%"><?= $lmc['lead_name']; ?></td>
                                    
                                    <td class="text-center" width="50%"><?= $lmc['language_name']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </h5>
            </div>            
            <div id="collapse<?= $lmc['id']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">                    
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th class="text-center" width="25%">Day</th>
                                <th class="text-center" width="25%">Subject</th>
                                <th class="text-center" width="25%">Body</th>
                                <th class="text-center" width="25%">Action</th>
                            </tr>
                            <?php
                            foreach ($lead_campaign_mails as $inner_lmc) {
                                if ($inner_lmc['type'] == 1) {
                                    $day_name = 'Day 0';
                                } elseif ($inner_lmc['type'] == 2) {
                                    $day_name = 'Day 3';
                                } else {
                                    $day_name = 'Day 6';
                                }
                                ?>
                                <tr>
                                    <td class="text-center" width="25%"><?= $day_name; ?></td>
                                    <td class="text-center" width="25%"><?= $inner_lmc['subject']; ?></td>
                                    <td class="text-center" width="25%"><?= substr(urldecode($inner_lmc['body']), 0, 30); ?></td>
                                    <td class="text-center" width="25%">
                                        <a href="<?= base_url("/lead_management/lead_mail/edit_mail_campaign/" . $inner_lmc['id'] . "") ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                        <a href="javascript:void(0);" onclick="delete_mail_campaign('<?= $inner_lmc['id'] ?>');" class="btn btn-danger btn-xs"><i class="fa fa-times" aria-hidden="true"></i> Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
  }
} else {
    echo 'No data found';
}
?>