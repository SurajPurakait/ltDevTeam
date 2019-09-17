<?php if (count($data) != 0): ?>
    <h2 class="text-primary"><?= count($data); ?> Results found</h2>
<?php endif; ?>
<?php if (!empty($data)): ?>
    <?php
    foreach ($data as $key => $value):
        $day0 = mail_campaign_list($value['type_of_contact'], $value['language'], 1);
//        print_r($day0);echo $day0[0]['submission_date'];
        $day3 = mail_campaign_list($value['type_of_contact'], $value['language'], 2);
        $day6 = mail_campaign_list($value['type_of_contact'], $value['language'], 3);
        ?>
        <div class="panel panel-default service-panel type2 filter-active">
            <div class="panel-heading">
                <?php if ($value["lead_type"] == 1): ?>
                    <a href="<?= base_url("/lead_management/edit_lead/edit_lead_prospect/{$value["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
                <?php elseif ($value["lead_type"] == 2): ?>
                    <a href="<?= base_url("/lead_management/edit_lead/edit_lead_referral/{$value["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
                <?php endif; ?>
                <a href="<?= base_url("/lead_management/home/view/{$value["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-view"><i class="fa fa-eye" aria-hidden="true"></i>View</a>
                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse89" aria-expanded="false">
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th class="text-center" width="10%">Type</th>
                                    <th class="text-center" width="8%">Name</th>
                                    <th class="text-center" width="8%">Tracking</th>
                                    <th class="text-center" style="white-space:nowrap" width="8%">Requested By</th>
                                    <th class="text-center" style="white-space:nowrap" width="8%">Submission Date</th>
                                    <th class="bg-blue text-center" colspan="3" width="20%">
                                        Mail Campaign
                                        <!--                                        <br>
                                                                                &nbsp;&nbsp;DAY0&nbsp;&nbsp;-&nbsp;&nbsp;DAY3&nbsp;&nbsp;-&nbsp;&nbsp;DAY6-->
                                    </th>
                                    <th style="white-space:nowrap" class="text-center" width="8%">Active Date</th>
                                    <th style="white-space:nowrap" class="text-center" width="8%">Inactive Date</th>
                                    <th style="white-space:nowrap" class="text-center" width="8%">Completed Date</th>
                                    <th class="text-center" width="5%">Notes</th>
                                </tr>
                                <tr>
                                    <td title="Type" class="text-center" width="10%" style="word-break:break-all"><?= $value["type"]; ?></td>
                                    <td title="Name" class="text-center" width="8%"><?= $value["first_name"] . (($value['office'] != '0') ? '<br><b>' . get_office_info_by_id($value['office'])['office_id'] . '</b>' : ''); ?></td>
                                    <td align='left' title="Tracking Description" class="text-center" width="8%">
                                        <a href='javascript:void(0);' onclick='show_lead_tracking_modal("<?= $value["id"]; ?>")'><span class='label label-primary'><?= $value["status"]; ?></span></a>
                                    </td>
                                    <td title="Requested By" class="text-center" width="9%"><?= $value["requested_by"]; ?></td>
                                    <td title="Submission Date" class="text-center" width="9%"><?= ($value["submission_date"] != "0000-00-00") ? date("m/d/Y", strtotime($value["submission_date"])) : "-"; ?></td>
                                    <td class="bg-blue text-center" title="DAY0">DAY0<br><?= (isset($day0[0]['submission_date']) && $day0[0]['submission_date'] != "NULL") ? date("m/d/Y", strtotime($day0[0]['submission_date'])) : " - "; ?></td>
                                    <td class="bg-blue text-center" title="DAY3">DAY3<br><?= (isset($day3[0]['submission_date']) && $day3[0]['submission_date'] != "NULL") ? date("m/d/Y", strtotime($day3[0]['submission_date'])) : " - "; ?></td>
                                    <td class="bg-blue text-center" title="DAY6">DAY6<br><?= (isset($day6[0]['submission_date']) && $day6[0]['submission_date'] != "NULL") ? date("m/d/Y", strtotime($day6[0]['submission_date'])) : " - "; ?></td>
                                    <td title="Active Date" class="text-center" width="8%"><?= ($value["active_date"] != "0000-00-00") ? date("m/d/Y", strtotime($value["active_date"])) : "-"; ?></td>
                                    <td title="Inactive Date" class="text-center" width="8%"><?= ($value["inactive_date"] != "0000-00-00") ? date("m/d/Y", strtotime($value["inactive_date"])) : "-"; ?></td>
                                    <td title="Completed Date" class="text-center" width="8%"><?= ($value["complete_date"] != "0000-00-00") ? date("m/d/Y", strtotime($value["complete_date"])) : "-"; ?></td>
                                    <td title="Notes" class="text-center" width="5%">
                                        <span><?= (($value["notes"] > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_lead_notes(\'' . $value["id"] . '\')"><b>' . $value["notes"] . '</b></a>' : '<b class="label label-warning">' . $value["notes"] . '</b>') ?></span>
                                    </td>
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
