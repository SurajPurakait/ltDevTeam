<?php 
// echo '<pre>';
// print_r($referral_partner_data);
// echo '</pre>'; exit; ?>
<?php if (!empty($referral_partner_data)): ?>
    <?php foreach ($referral_partner_data as $key => $value):
        $staff_data = staff_info_by_id($value["staff_requested_by"]);
        if($value["status"]==0){
            $status = 'New';
        }elseif ($value["status"]==1) {
             $status = 'Complete';
        }elseif ($value["status"]==2) {
             $status = 'Inactive';
        }elseif ($value["status"]==3) {
             $status = 'Active';
        }
        
         if($value["type"]==1){
            $type = get_type_of_contact_name($value['type_of_contact'],1)['name'];
         }else{
            $type = get_type_of_contact_name($value['type_of_contact'],2)['name'];
         }
         $notes = get_notes_ref_partner($value['partner_id']);  

     ?>
        <div class="panel panel-default service-panel type2 filter-active">
            <div class="panel-heading">                           
              <a href="<?= base_url("/lead_management/home/view/{$value["id"]}/1/"); ?>" class="btn btn-primary btn-xs btn-service-view"><i class="fa fa-eye" aria-hidden="true"></i>
                    View</a> 
                <a href="<?= base_url("/referral_partner/referral_partners/edit_lead_prospect/{$value["id"]}"); ?>"
                       class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>                                                                             
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
                                <th>Requested By</th>
                                <!-- <th>Referred By</th>
                                <th>Referred Date</th> -->
                                <th>Submission Date</th>
                                <th>Active Date</th>
                                <th>Inactive Date</th>
                                <th>Completed Date</th>
                                <th>Notes</th>
                            </tr>
                            <tr>
                                <td title="Type"><?= $type; ?></td>
                                <td title="Name"><?= $value["last_name"].', '.$value["first_name"]; ?></td>
                                <td align='left' title="Tracking Description"><a
                                            href='javascript:void(0);'
                                            onclick='show_ref_partner_tracking_modal("<?= $value["id"]; ?>")'><span
                                                class='label label-primary'><?= $status; ?></span></a></td>
                                <td title="Requested By"><?= $staff_data["last_name"].', '.$staff_data["first_name"]; ?></td>
                                <td title="Submission Date"><?= ($value["submission_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["submission_date"])) : "-"; ?></td>
                                <td title="Active Date"><?= ($value["active_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["active_date"])) : "-"; ?></td>
                                <td title="Inactive Date"><?= ($value["inactive_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["inactive_date"])) : "-"; ?></td>
                                <td title="Completed Date"><?= ($value["complete_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["complete_date"])) : "-"; ?></td>
                                <?php echo '<td title="Notes"><span>' . (($notes > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $value["id"] . '\')"><b>' . $notes . '</b></a>' : '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $value["id"] . '\')"><b>' . $notes . '</b></a>') . '</span></td>'; ?>
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