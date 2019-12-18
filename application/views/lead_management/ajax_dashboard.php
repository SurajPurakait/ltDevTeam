<div class="clearfix result-header">
    <?php if (count($lead_list) != 0): ?>
        <h2 class="text-primary pull-left result-count-h2"><?= count($lead_list); ?> Results found</h2>
    <?php endif; ?>
    <div class="pull-right text-right p-t-4">
        <div class="dropdown" style="display: inline-block;">
            <a href="javascript:void(0);" id="sort-by-dropdown" data-toggle="dropdown" class="dropdown-toggle btn btn-success">Sort By <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a id="type_of_contact-val" href="javascript:void(0);" onclick="sort_lead_dashboard('lm.type_of_contact')">Type</a></li>
                <li><a id="status-val" href="javascript:void(0);" onclick="sort_lead_dashboard('lm.status')">Tracking</a></li>
                <li><a id="office-val" href="javascript:void(0);" onclick="sort_lead_dashboard('office')">Office</a></li>
                <li><a id="client_name-val" href="javascript:void(0);" onclick="sort_lead_dashboard('full_name')">Staff</a></li>
                <li><a id="active_date-val" href="javascript:void(0);" onclick="sort_lead_dashboard('lm.active_date')">Active Date</a></li>
                <li><a id="complete_date-val" href="javascript:void(0);" onclick="sort_lead_dashboard('lm.complete_date')">Complete Date</a></li>
            </ul>
        </div>
        <div class="sort_type_div" style="display: none;">
            <a href="javascript:void(0);" id="sort-asc" onclick="sort_lead_dashboard('', 'DESC')" class="btn btn-success" data-toggle="tooltip" title="Ascending Order" data-placement="top"><i class="fa fa-sort-amount-asc"></i></a>
            <a href="javascript:void(0);" id="sort-desc" onclick="sort_lead_dashboard('', 'ASC')" class="btn btn-success" data-toggle="tooltip" title="Descending Order" data-placement="top"><i class="fa fa-sort-amount-desc"></i></a>
            <a href="javascript:void(0);" onclick="leadFilter();" class="btn btn-white text-danger" data-toggle="tooltip" title="Remove Sorting" data-placement="top"><i class="fa fa-times"></i></a>
        </div>
    </div>
</div>
<?php if (!empty($lead_list)): ?>
    <?php
    foreach ($lead_list as $lead):
        // $day0 = mail_campaign_list($lead['type_of_contact'], $lead['language'], 1);
        // $day3 = mail_campaign_list($lead['type_of_contact'], $lead['language'], 2);
        // $day6 = mail_campaign_list($lead['type_of_contact'], $lead['language'], 3);
        ?>
        <div class="panel panel-default service-panel type2 filter-active lead-<?= $lead['id']; ?>">
            <div class="panel-heading">
                 <a href="javascript:void(0);" onclick="delete_lead_management('<?= $lead["id"] ?>');" class="btn btn-danger btn-xs btn-service-delete manage-delete-btn"><i class="fa fa-remove" aria-hidden="true"></i> Delete</a>  
               
                <a href="<?= base_url("/lead_management/home/view/{$lead["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-view add-view-new"><i class="fa fa-eye" aria-hidden="true"></i> View</a>

                <?php
                    if ($lead["type_of_contact"] == 1 || $lead["type_of_contact"] == 2) {
                        ?>
                        <a href="<?= base_url("/lead_management/edit_lead/edit_lead_referral/{$lead["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i >Edit</a>
                        <?php
                    } else {
                        ?>
                        <a href="<?= base_url("/lead_management/edit_lead/edit_lead_prospect/{$lead["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                        <?php
                    }
                ?>
                
                <?php
                    if ($lead['status'] == 1) {
                        if($lead['type'] == 1) {
                        ?>
                        <?php
                        if ($lead['assigned_status'] == 'y') {
                            ?>
                            <a href="javascript:void(0);" class="btn btn-warning btn-xs btn-service-lead"> Assigned as Client</a>
                            <?php
                        } else {
                            ?>
                            <!-- <a href="javascript:void(0);" onclick="assign_as_client(<?//= $lead['id']; ?>,<?//= $lead['requested_staff_id']; ?>)" class="btn btn-primary btn-xs btn-assign-client" id="assign_as_client-<?//= $lead['id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i> Assign as Client</a> -->
                            <a href="javascript:void(0);" onclick="open_client_assign_popup(<?= $lead['id']; ?>,<?= $lead['requested_staff_id']; ?>)" class="btn btn-primary btn-xs btn-service-lead" id="assign_as_client-<?= $lead['id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i> Assign as Client</a>
                            <?php
                        }
                        ?>
                        <?php
                        } else {
                            if ($lead['assigned_status'] == 'y') {
                        ?>
                            <a href="javascript:void(0);" class="btn btn-warning btn-xs btn-service-lead"> Assigned as Partner</a>
                        <?php        
                            } else {
                        ?>
                        <a href="javascript:void(0);" onclick="assign_as_partner(<?= $lead['id']; ?>)" class="btn btn-primary btn-xs btn-service-lead" id="assign_as_partner-<?= $lead['id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i> Assign as Partner</a>
                        <?php        
                            }    
                        }
                    }
                ?>
                
                <h5 class="panel-title p-t-15" data-toggle="collapse" data-parent="#accordion" href="#collapse89" aria-expanded="false">
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th class="text-center" width="8">Type</th>
                                    <th class="text-center" width="8">Source</th>
                                    <th class="text-center" width="7">Name</th>
                                    <th class="text-center" width="7">Tracking</th>
                                    <th class="text-center" style="white-space:nowrap" width="7">Requested By</th>
                                    <th class="text-center" style="white-space:nowrap" width="7">Submission Date</th>
                                    <th class="text-center" width="7">Mail Campaign</th>
                                    
                                    <th class="bg-blue text-center" width="7">DAY 0</th>
                                    <th class="bg-blue text-center" width="7">DAY 3</th>
                                    <th class="bg-blue text-center" width="7">DAY 6</th>
                                    <th style="white-space:nowrap" class="text-center" width="7">Language</th>
<!--                                    <th style="white-space:nowrap" class="text-center" width="7">Active Date</th>
                                    <th style="white-space:nowrap" class="text-center" width="7">Inactive Date</th>
                                    <th style="white-space:nowrap" class="text-center" width="7">Completed Date</th>-->
                                    <th class="text-center" width="7">Notes</th>
                                </tr>
                                <tr>
                                    <td title="Type" class="text-center" width="8" style="word-break:break-all"><?= ($lead["contact_type_name"] != '') ? $lead["contact_type_name"] : 'N/A'; ?></td>
                                    <td title="Type" class="text-center" width="8" style="word-break:break-all"><?= ($lead["lead_source_detail"] != '') ? $lead["lead_source_detail"] : 'N/A'; ?></td> 
                                    <td title="Name" class="text-center" width="7"><?= implode(" ", explode(',', $lead["full_name"])); ?></td>
                                    <td align='left' title="Tracking Description" class="text-center" width="7">
                                        <?php
                                        if ($lead["status"] == 0) {
                                            $trk_class = "label label-success";
                                        } elseif ($lead["status"] == 3) {

                                            $trk_class = "label badge-warning"; //badge-warning for lead section only
                                        } elseif ($lead["status"] == 2) {
                                            $trk_class = "label label-danger";
                                        } elseif ($lead["status"] == 1) {
                                            $trk_class = "label label-primary";
                                            $lead["status_name"] = "Completed";
                                        }
                                        ?>
                                        <a href='javascript:void(0);' onclick='show_lead_tracking_modal("<?= $lead["id"]; ?>")'><span class="<?= $trk_class; ?>" id="lead_status_<?= $lead["id"]; ?>"><?= $lead["status_name"]; ?></span></a>
                                    </td>
                                    <td title="Requested By" class="text-center" width="7"><?= $lead["requested_staff_name"] . (($lead['office'] != '0') ? '<br><b>' . get_office_info_by_id($lead['office'])['office_id'] . '</b>' : ''); ?><?= "<br>" . $lead['request_staff_office_name']; ?></td>
                                    <td title="Submission Date" class="text-center" width="7"><?= ($lead["submission_date"] != "0000-00-00") ? date("m/d/Y", strtotime($lead["submission_date"])) : "-"; ?></td>
                                    <td class="text-center" title="Mail Campaign" width="7">
                                        <?php
                                            if ($lead["mail_campaign_status"] == 1) {
                                                $trk_class_campaign = "label label-primary";
                                                $mail_campaign_status_text = "YES";
                                            } elseif ($lead["mail_campaign_status"] == 0) {
                                                $trk_class_campaign = "label label-danger";
                                                $mail_campaign_status_text = "NO";
                                            }
                                        ?>
                                        <a href='javascript:void(0);' onclick='change_mail_campaign_status("<?= $lead["id"]; ?>")'><span class="<?= $trk_class_campaign; ?>" id="lead_mail_campaign_status_<?= $lead["id"]; ?>"><?= $mail_campaign_status_text; ?></span></a>
                                    </td>
                                    <td class="bg-blue text-center" title="DAY0" width="7"><?= (isset($lead['day_0_mail_date']) && $lead['day_0_mail_date'] != "0000-00-00") ? date("m/d/Y", strtotime($lead['day_0_mail_date'])) : " - "; ?></td>
                                    <td class="bg-blue text-center" title="DAY3" width="7"><?= (isset($lead['day_3_mail_date']) && $lead['day_3_mail_date'] != "0000-00-00") ? date("m/d/Y", strtotime($lead['day_3_mail_date'])) : " - "; ?></td>
                                    <td class="bg-blue text-center" title="DAY6" width="7"><?= (isset($lead['day_6_mail_date']) && $lead['day_6_mail_date'] != "0000-00-00") ? date("m/d/Y", strtotime($lead['day_6_mail_date'])) : " - "; ?></td>
                                    <td title="Type" class="text-center" width="8" style="word-break:break-all"><?= $lead["language"]; ?></td>

<!--                                <td title="Active Date" class="text-center" width="7"><//?= ($lead["active_date"] != "0000-00-00") ? date("m/d/Y", strtotime($lead["active_date"])) : "-"; ?></td>
                                    <td title="Inactive Date" class="text-center" width="7"><//?= ($lead["inactive_date"] != "0000-00-00") ? date("m/d/Y", strtotime($lead["inactive_date"])) : "-"; ?></td>
                                    <td title="Completed Date" class="text-center" width="7"><//?= ($lead["complete_date"] != "0000-00-00") ? date("m/d/Y", strtotime($lead["complete_date"])) : "-"; ?></td>-->
                                    <td title="Notes" class="text-center" width="7">
                                        <span><?= (($lead["notes_count"] > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_lead_notes(\'' . $lead["id"] . '\')"><b>' . $lead["notes_count"] . '</b></a>' : '<b class="label label-warning">' . $lead["notes_count"] . '</b>') ?></span>
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