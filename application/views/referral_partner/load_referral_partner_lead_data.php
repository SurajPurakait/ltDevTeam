<?php //print_r($data); ?>
<?php if (!empty($referral_data)): ?>
    <?php foreach ($referral_data as $key => $value): ?>
        <?php $check_if_assigned = check_if_lead_assigned($value["id"]); 
        if($check_if_assigned<=0){?>
        <div class="panel panel-default service-panel type2 filter-active">
            <div class="panel-heading">
                <a href="<?= base_url("/lead_management/home/view/{$value["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-view"><i class="fa fa-eye" aria-hidden="true"></i>
                    View</a>

                <a href="<?= base_url("/lead_management/edit_lead/edit_lead_referral_partner/{$value["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>
                <a href="javascript:void(0)" onclick="assign_lead_to(<?= $value["id"]; ?>)" class="btn btn-primary btn-xs btn-service-assign"><i class="fa fa-asterisk" aria-hidden="true"></i>
                        Assign</a>            
                                                                                            
                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion"
                    href="#collapse89"
                    aria-expanded="false">                                                                             
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tbody>
                            <tr>
                                <th style="width:120px;">Type</th>
                                <th style="width:120px;">Name</th>
                                <th>Tracking</th>
                                <!-- <th>Requested By</th> -->
                                <th>Submission Date</th>
                                <th>Active Date</th>
                                <th>Inactive Date</th>
                                <th>Completed Date</th>
                                <th>Notes</th>
                            </tr>
                            <tr>
                                <td title="Type"><?= $value["type"]; ?></td>
                                <td title="Name"><?= $value["name"]; ?></td>
                                <td align='left' title="Tracking Description"><a
                                            href='javascript:void(0);'
                                            onclick='show_ref_partner_tracking_modal("<?= $value["id"]; ?>")'><span
                                                class='label label-primary'><?= $value["status"]; ?></span></a></td>
                                <!-- <td title="Requested By"><?php //$value["requested_by"]; ?></td> -->
                                <td title="Submission Date"><?= ($value["submission_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["submission_date"])) : "-"; ?></td>
                                <td title="Active Date"><?= ($value["active_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["active_date"])) : "-"; ?></td>
                                <td title="Inactive Date"><?= ($value["inactive_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["inactive_date"])) : "-"; ?></td>
                                <td title="Completed Date"><?= ($value["complete_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["complete_date"])) : "-"; ?></td>
                                <?php echo '<td title="Notes"><span>' . (($value["notes"] > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $value["id"] . '\')"><b>' . $value["notes"] . '</b></a>' : '<b class="label label-warning">' . $value["notes"] . '</b>') . '</span></td>'; ?>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </h5>
            </div>
            
        </div>
    <?php } ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>No Data Found</p>
<?php endif; ?>
