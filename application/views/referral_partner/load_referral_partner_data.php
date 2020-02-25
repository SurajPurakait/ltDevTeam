<?php 
// echo "<pre>";
// print_r($referral_data);exit;
if (count($referral_data) != 0): ?>
    <h2 class="text-primary"><?= count($referral_data); ?> Results found</h2>
<?php endif; ?>
<?php if (!empty($referral_data)): ?>

    <?php foreach ($referral_data as $key => $value): ?>
        <div class="panel panel-default service-panel type2 filter-active">
            <div class="panel-heading alllead" id="alllead-<?= $value['id']; ?>" aria-expanded="false" data-toggle="tooltip" data-placement="top" title="All Lead">
                <div class="referral-partner-status-btn-list">
                      <a href="javascript:void(0)" onclick="delete_referral_partner(<?= $value["id"]; ?>)" class="btn btn-danger btn-xs btn-service-delete btn-service-lead"><i class="fa fa-times" aria-hidden="true"></i>
                        Delete</a> 
                           <a href="<?= base_url("/referral_partner/referral_partners/view_referral/{$value["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-lead"><i class="fa fa-eye" aria-hidden="true"></i>
                        View</a>
                        <a href="<?= base_url("/referral_partner/referral_partners/edit_referral_agent/{$value['id']}"); ?>" class="btn btn-primary btn-xs btn-service-lead"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>
                          <a href="javascript:void(0)" onclick="assign_ref_partner_to(<?= $value["id"]; ?>)" class="btn btn-primary btn-xs btn-service-lead"><i class="fa fa-asterisk" aria-hidden="true"></i>
                        Assign Client</a>
                          <a href="javascript:void(0)" onclick="reffer_lead_to_partner_view(<?= $value['id']; ?>,'<?= $value["email"]; ?>',1)" class="btn btn-primary btn-xs btn-service-lead"><i class="fa fa-key" aria-hidden="true"></i>
                        Refer New Lead</a>
                  

                    <a href="javascript:void(0)" onclick="assign_ref_partner_password(<?= $value["id"]; ?>,<?= $value["requested_by_id"]; ?>,'<?= $value["email"]; ?>')" class="btn btn-primary btn-xs btn-service-lead"><i class="fa fa-key" aria-hidden="true"></i>
                        Setup</a>
                  
                    
                 
                                                   
                </div>    
                <h5 class="panel-title">                                                                             
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th width="10%">Type</th>
                                    <th width="15%">Name</th>
                                    <th width="15%">Requested By</th>
                                    <th width="15%">Language</th>
                                    <th width="15%">Requested Date</th>
                                    <th width="10%">Source</th>
                                    <th width="10%">Leads</th>
                                    <th width="10%">Notes</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td title="Type"><?= $value["type"]; ?></td>
                                    <td title="Name"><?= $value["name"]; ?></td>
                                    <td title="Requested By"><?= $value["requested_by"]; ?></td>
                                    <td title="Language"><?= $value["language"]; ?></td>
                                    <td title="Requested Date"><?= ($value["submission_date"] != "0000-00-00") ? date('m/d/Y', strtotime($value["submission_date"])) : "-"; ?></td>
                                    <td title="Source"><?= $value["source"]; ?></td>
                                    <td>
                                        <?php
                                            $partner_to_staff_count = get_partner_to_staff_count($value["id"]); // green // Referred // 0
                                            $staff_to_partner_count = get_staff_to_partner_count($value["id"]); // blue // Sent // 1
                                        ?>
                                        <a id="countbyme-<?= $value['id']; ?>" aria-expanded="false" class="label label-success countbyme" data-toggle="tooltip" data-placement="top" title="By Me"><span ></span><?= $staff_to_partner_count; ?></a>&nbsp;
                                        <a id="counttome-<?= $value['id']; ?>" aria-expanded="false" class="label label-primary counttome" data-toggle="tooltip" data-placement="top" title="To Me"><span ><?= $partner_to_staff_count; ?></span></a>&nbsp;
                                    </td>
                                    <?php echo '<td title="Notes"><span>' . (($value["notes"] > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $value["id"] . '\')"><b>' . $value["notes"] . '</b></a>' : '<b class="label label-warning">' . $value["notes"] . '</b>') . '</span></td>'; ?>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </h5>
            </div>
            <?php
            $lead_list_referred_to_me = get_lead_list_to_partner($value['id']);
            // tome
            if (!empty($lead_list_referred_to_me)) {
                ?>
                <div id="collapse_tome<?= $value['id']; ?>" class="panel-collapse collapse" aria-expanded="false" style="display: none;">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Status</th>
                                    <th>Client Type</th>
                                    <th>Client Name</th>
                                    <th>Tracking</th>
                                    <th>Referred Date</th>
                                    <th>Note</th>
                                </tr>
                                <?php foreach ($lead_list_referred_to_me as $ad) { 
                                      $notes = get_notes_ref_partner($ad['id']);  
                                ?>
                                    <tr>
                                        <td><span <?= ($ad['referred_status'] == 1) ? 'class="label label-success"':'class="label label-primary"'; ?>><?= ($ad['referred_status'] == 1) ? 'Sent' : 'Referred'; ?></span></td>
                                        <td><?= ($value["type"] != '') ? $value["type"]:'N/A'; ?></td>
                                        <td><?= $ad['first_name']." ".$ad['last_name'] ;?></td>
                                        <td>
                                            <?php
                                            if ($ad["status"] == 0) {
                                                $trk_class = "label label-success";
                                                $ad_status = "New";   
                                            }elseif ($ad["status"] == 3) {
                                                $trk_class = "label badge-warning"; //badge-warning for lead section only
                                                $ad_status = "Active";
                                            }elseif ($ad["status"] == 2) {
                                                $trk_class = "label label-danger";
                                                $ad_status = "Inactive";
                                            }elseif ($ad["status"] == 1) {
                                                $trk_class = "label label-primary";
                                                $ad_status = "Completed";
                                            }
                                             
                                        ?>
                                        <a href='javascript:void(0);' onclick='show_lead_tracking_modal("<?= $ad["id"]; ?>")'><span class="<?= $trk_class; ?>"><?= $ad_status; ?></span></a>
                                        </td>
                                        <td><?= ($ad["referred_date"] != "0000-00-00") ? date("m/d/Y", strtotime($ad["referred_date"])) : "-"; ?></td>
                                        <?php echo '<td title="Notes"><span>' . (($notes > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $ad["id"] . '\')"><b>' . $notes . '</b></a>' : '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $ad["id"] . '\')"><b>' . $notes . '</b></a>') . '</span></td>'; ?>
                                    </tr>
                                <?php }
                                ?>                        
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>

            
            <?php
                $lead_list_referred_by_or_to_me = get_lead_list_associated_with_partner($value['id']);    
            ?>
            <div id="alllead<?= $value['id']; ?>" class="panel-collapse collapse" aria-expanded="false" style="display: none;">
                 <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th>Status</th>
                                <th>Client Type</th>
                                <th>Client Name</th>
                                <th>Tracking</th>
                                <th>Referred Date</th>
                                <th>Note</th>
                                <th>Id</th>
                            </tr>
                            <?php foreach ($lead_list_referred_by_or_to_me as $all) { 
                                  $notes = get_notes_ref_partner($all['id']);  
                            ?>
                                <tr>
                                    <td><span <?= ($all['referred_status'] == 1) ? 'class="label label-success"':'class="label label-primary"'; ?>><?= ($all['referred_status'] == 1) ? 'Sent' : 'Referred'; ?></span></td>
                                    <td><?= ($value["type"] != '') ? $value["type"]:'N/A'; ?></td>
                                    <td><?= $all['first_name']." ".$all['last_name'] ;?></td>
                                    <td>
                                        <?php
                                        if ($all["status"] == 0) {
                                            $trk_class = "label label-success";
                                            $all_status = "New";   
                                        }elseif ($ad["status"] == 3) {
                                            $trk_class = "label badge-warning"; //badge-warning for lead section only
                                            $all_status = "Active";
                                        }elseif ($ad["status"] == 2) {
                                            $trk_class = "label label-danger";
                                            $all_status = "Inactive";
                                        }elseif ($ad["status"] == 1) {
                                            $trk_class = "label label-primary";
                                            $all_status = "Completed";
                                        }
                                         
                                    ?>
                                    <a href='javascript:void(0);' onclick='show_lead_tracking_modal("<?= $all["id"]; ?>")'><span class="<?= $trk_class; ?>"><?= $all_status; ?></span></a>
                                    </td>
                                    <td><?= ($all["referred_date"] != "0000-00-00") ? date("m/d/Y", strtotime($all["referred_date"])) : "-"; ?></td>
                                    <?php echo '<td title="Notes"><span>' . (($notes > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $all["id"] . '\')"><b>' . $notes . '</b></a>' : '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $all["id"] . '\')"><b>' . $notes . '</b></a>') . '</span></td>'; ?>
                                    <?php
                                        if (!empty($all["client_reference"]) && !empty($all["client_id"])) {
                                    ?>
                                    <td><a href="javascript:void(0)" class="label label-primary" onclick="show_mortgage_information('<?= $all["client_reference"] ?>','<?= $all["client_id"]; ?>','<?= $all["id"]; ?>')">Mortgage</a>
                                    </td>
                                    <?php
                                        }
                                    ?>
                                    <td><?= $all['id']; ?></td>
                                </tr>
                            <?php }
                            ?>                        
                        </table>
                    </div>
                </div>       
            </div>
            <!-- byme -->
            <?php
            $lead_list_referred_by_me = get_lead_list_by_partner($value['id']);
            // tome
            if (!empty($lead_list_referred_by_me)) {
                ?>
                <div id="collapse_byme<?= $value['id']; ?>" class="panel-collapse collapse" aria-expanded="false" style="display: none;">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Status</th>
                                    <th>Client Type</th>
                                    <th>Client Name</th>
                                    <th>Tracking</th>
                                    <th>Referred Date</th>
                                    <th>Note</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($lead_list_referred_by_me as $ad) { 
                                      $notes = get_notes_ref_partner($ad['id']);  
                                ?>
                                    <tr>
                                        <td><span <?= ($ad['referred_status'] == 1) ? 'class="label label-success"':'class="label label-primary"'; ?>><?= ($ad['referred_status'] == 1) ? 'Sent' : 'Referred'; ?></span></td>
                                        <td><?= ($value["type"] != '') ? $value["type"]:'N/A'; ?></td>
                                        <td><?= $ad['first_name']." ".$ad['last_name'] ;?></td>
                                        <td>
                                            <?php
                                            if ($ad["status"] == 0) {
                                                $trk_class = "label label-success";
                                                $ad_status = "New";   
                                            }elseif ($ad["status"] == 3) {
                                                $trk_class = "label badge-warning"; //badge-warning for lead section only
                                                $ad_status = "Active";
                                            }elseif ($ad["status"] == 2) {
                                                $trk_class = "label label-danger";
                                                $ad_status = "Inactive";
                                            }elseif ($ad["status"] == 1) {
                                                $trk_class = "label label-primary";
                                                $ad_status = "Completed";
                                            }
                                             
                                        ?>
                                        <a href='javascript:void(0);' onclick='show_lead_tracking_modal("<?= $ad["id"]; ?>")'><span class="<?= $trk_class; ?>"><?= $ad_status; ?></span></a>
                                        </td>
                                        <td><?= ($ad["referred_date"] != "0000-00-00") ? date("m/d/Y", strtotime($ad["referred_date"])) : "-"; ?></td>
                                        <?php echo '<td title="Notes"><span>' . (($notes > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $ad["id"] . '\')"><b>' . $notes . '</b></a>' : '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $ad["id"] . '\')"><b>' . $notes . '</b></a>') . '</span></td>'; ?>
                                        <?php
                                            if (!empty($ad["client_reference"]) && !empty($ad["client_id"])) {
                                        ?>
                                        <td><a href="javascript:void(0)" class="label label-primary" onclick="show_mortgage_information('<?= $ad["client_reference"] ?>','<?= $ad["client_id"]; ?>','<?= $ad["id"]; ?>')">Mortgage</a>
                                        </td>
                                        <?php
                                            }
                                        ?>
                                    </tr>
                                <?php }
                                ?>                        
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>

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
<script type="text/javascript">
    $(document).ready(function(){
        $(".countbyme").click(function(){            
            if (!e) var e = window.event;
            e.cancelBubble = true;
            if (e.stopPropagation) e.stopPropagation();
            var cls = $(this).hasClass('countbyme');
            if (cls) {
                var id = $(this).attr('id');
                var ex = id.split("-");
                var collid = ex[1];
                
                $("#collapse_tome"+collid).hide();
                $("#alllead"+collid).hide();
                $("#collapse_byme"+collid).slideToggle(1000);            
            }     
        });

        $(".counttome").click(function(){            
            if (!e) var e = window.event;
            e.cancelBubble = true;
            if (e.stopPropagation) e.stopPropagation();
            var cls = $(this).hasClass('counttome');
            if (cls) {
                var id = $(this).attr('id');
                var ex = id.split("-");
                var collid = ex[1];

                $("#collapse_byme"+collid).hide();
                $("#alllead"+collid).hide();
                $("#collapse_tome"+collid).slideToggle(1000);            
            }
        });

        $(".alllead").click(function(){
            var cls = $(this).hasClass('alllead');
            if (cls) {
                var id = $(this).attr('id');
                var ex = id.split("-");
                var collid = ex[1];

                $("#collapse_tome"+collid).hide();
                $("#collapse_byme"+collid).hide();    
                $("#alllead"+collid).slideToggle(1000);            
            }
        });

    });
</script>