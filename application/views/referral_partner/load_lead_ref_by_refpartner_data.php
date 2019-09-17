<?php if (count($lead_data) != 0): ?>
    <h2 class="text-primary"><?= count($lead_data); ?> Results found</h2>
<?php endif; ?>
<?php if (!empty($lead_data)): ?>
    <?php foreach ($lead_data as $key => $value): ?>
        <div class="panel panel-default service-panel type2 filter-active">
            <div class="panel-heading">
                <a href="<?= base_url("/referral_partner/referral_partners/view_leads/{$value["id"]}/{$value["assigned_clientid"]}/"); ?>" class="btn btn-primary btn-xs btn-service-view referred-leads"><i class="fa fa-eye" aria-hidden="true"></i>
                    View</a>
                <a href="javascript:void(0);" class="btn btn-danger btn-xs btn-service-delete referred-leads m-r-10" onclick="delete_reffererd_leads('<?= $value["id"] ?>','<?= $value["assigned_clientid"] ?>');"><i class="fa fa-times" aria-hidden="true"></i>
                    Delete</a>                            

                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value['id']; ?>" aria-expanded="false">                                                                             
                    <div class="table-responsive">
                        <table class="table table-borderless text-center" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th width="10%" class="text-center">Type</th>
                                    <th width="15%" class="text-center">Name</th>
                                    <th width="8%" class="text-center">Tracking</th>
                                    <th width="10%" class="text-center">Referred By</th>
                                    <th width="10%" class="text-center">Referred To</th>
                                    <th width="8%" class="text-center">Submission Date</th>
                                    <th width="8%" class="text-center">Active Date</th>
                                    <th width="8%" class="text-center">Inactive Date</th>
                                    <th width="8%" class="text-center">Completed Date</th>
                                    <th width="5%" class="text-center">Notes</th>
                                </tr>
                                <tr>
                                    <td title="Type" ><?= $value["type"]; ?></td>
                                    <td title="Name"><?= $value["name"]; ?></td>
                                    <td title="Tracking Description"><a
                                            href='javascript:void(0);'
                                            onclick='show_ref_partner_tracking_modal("<?= $value["id"]; ?>")'><span
                                                class='label label-primary'><?= $value["status"]; ?></span></a></td>
                                    <td title="Requested By"><?= $value["requested_by"]; ?></td>
                                    <td title="Requested To"><?= get_assigned_by_staff_name($value["assigned_clientid"]); ?></td>
                                    <td title="Submission Date"><?= ($value["submission_date"] != "0000-00-00") ? date('m/d/Y', strtotime($value["submission_date"])) : "-"; ?></td>
                                    <td title="Active Date"><?= ($value["active_date"] != "0000-00-00") ? date('m/d/Y', strtotime($value["active_date"])) : "-"; ?></td>
                                    <td title="Inactive Date"><?= ($value["inactive_date"] != "0000-00-00") ? date('m/d/Y', strtotime($value["inactive_date"])) : "-"; ?></td>
                                    <td title="Completed Date"><?= ($value["complete_date"] != "0000-00-00") ? date('m/d/Y', strtotime($value["complete_date"])) : "-"; ?></td>
                                    <?php echo '<td title="Notes"><span>' . (($value["notes"] > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_lead_ref_partner_notes(\'' . $value["id"] . '\')"><b>' . $value["notes"] . '</b></a>' : '<a class="label label-warning" href="javascript:void(0)" onclick="show_lead_ref_partner_notes(\'' . $value["id"] . '\')"><b>' . $value["notes"] . '</b></a>') . '</span></td>'; ?>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </h5>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i> 
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
<?php endif; ?>
