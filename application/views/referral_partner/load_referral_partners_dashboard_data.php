<?php 
// echo '<pre>';
// print_r($referral_partner_data);
// echo '</pre>'; exit; 
?>
<?php if (!empty($referral_partner_data)): ?>
    <?php foreach ($referral_partner_data as $key => $value):
        $staff_data = staff_info_by_id($value["staff_requested_by"]);
        if($value["status"]==0){
            $status = 'New';
            $trk_class = 'label-success';
        }elseif ($value["status"]==1) {
            $status = 'Completed';
            $trk_class = 'label-primary';
        }elseif ($value["status"]==2) {
             $status = 'Inactive';
             $trk_class = 'label-danger';
        }elseif ($value["status"]==3) {
            $status = 'Active';
            $trk_class = 'label-yellow';
        }
        if($value["type"]==1){
            $type = get_type_of_contact_name($value['type_of_contact'],1)['name'];
        }else{
            $type = get_type_of_contact_name($value['type_of_contact'],2)['name'];
        }
        $notes = get_notes_ref_partner($value['lead_id']);  

     ?>
        <div class="panel panel-default service-panel type2 filter-active">
            <div class="panel-heading">                           
              <a href="<?= base_url("/lead_management/home/view/{$value["id"]}/1/"); ?>" class="btn btn-primary btn-xs btn-service-view" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i>
                    View</a> 
                <!-- <a href="<?//= base_url("/referral_partner/referral_partners/edit_lead_prospect/{$value["id"]}"); ?>"
                       class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a> -->                                                                             
                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion"
                    href="#collapse89"
                    aria-expanded="false">                                                                             
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tbody>
                            <tr>
                                <th class="text-center" style="width: 14%">Type</th>
                                <th class="text-center" style="width: 14%">Name</th>
                                <th class="text-center" style="width: 14%">Tracking</th>
                                <th class="text-center" style="width: 14%">Requested By</th>
                                <!-- <th>Referred By</th>
                                <th>Referred Date</th> -->
                                <th class="text-center" style="width: 14%">Submission Date</th>
<!--                                 <th>Active Date</th>
                                <th>Inactive Date</th>
                                <th>Completed Date</th> -->
                                <th class="text-center" style="width: 14%">Notes</th>
                                <th class="text-center" style="width: 14%">Input Form</th>
                            </tr>
                            <tr>
                                <td title="Type" class="text-center" style="width: 14%"><?= $type; ?></td>
                                <td title="Name" style="width: 14%" class="text-center"><?= $value["last_name"].', '.$value["first_name"]; ?></td>
                                <td title="Tracking Description" class="text-center" style="width: 14%"><a
                                            href='javascript:void(0);'
                                            onclick='show_ref_partner_tracking_modal("<?= $value["id"]; ?>")'><span style="width: 80px; display: inline-block; text-align: center;"
                                                class=<?= $trk_class; ?>><?= $status; ?></span></a></td>
                                <td title="Requested By" class="text-center" style="width: 14%"><?= $staff_data["last_name"].', '.$staff_data["first_name"]; ?></td>
                                <td title="Submission Date" class="text-center" style="width: 14%"><?= ($value["submission_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["submission_date"])) : "-"; ?></td>
                                <!-- <td title="Active Date"><?//= ($value["active_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["active_date"])) : "-"; ?></td>
                                <td title="Inactive Date"><?//= ($value["inactive_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["inactive_date"])) : "-"; ?></td>
                                <td title="Completed Date"><?//= ($value["complete_date"] != "0000-00-00") ? date('m/d/Y',strtotime($value["complete_date"])) : "-"; ?></td> -->
                                <?php echo '<td title="Notes" style="width: 14%" class="text-center"><span>' . (($notes > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $value["id"] . '\')"><b>' . $notes . '</b></a>' : '<a class="label label-warning" href="javascript:void(0)" onclick="show_ref_partner_notes(\'' . $value["id"] . '\')"><b>' . $notes . '</b></a>') . '</span></td>'; ?>
                                <?php
                                    if (!empty($value["client_reference"]) && !empty($value["client_id"])) {
                                ?>
                                <td class="text-center" class="text-center" style="width: 14%"><a href="javascript:void(0)" class="label label-primary" target="_blank" onclick="show_mortgage_information('<?= $value["client_reference"] ?>','<?= $value["client_id"]; ?>','<?= $value["id"]; ?>')">Mortgage</a></td>
                                <?php
                                    } else {
                                ?>
                                <td class="text-center" style="width: 14%">N/A</td>
                                <?php        
                                    }
                                ?>
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