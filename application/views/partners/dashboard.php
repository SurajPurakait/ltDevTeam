<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                    <?php
                        // echo "<pre>";
                        // print_r($leads_list);exit;
                    if (count($leads_list) != 0): ?>
                        <h2 class="text-primary"><?= count($leads_list); ?> Results found</h2>
                    <?php endif; ?>
                    <?php if (!empty($leads_list)): ?>
                        <?php
                        foreach ($leads_list as $lead):
                            $staff_data_by = staff_info_by_id($lead["referred_by"]);
                            $staff_data_to = staff_info_by_id($lead["referred_to"]);
                            ?>
                            <div class="panel panel-default service-panel type2 filter-active">
                                <div class="panel-heading">
                                    <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse89" aria-expanded="false">
                                        <div class="table-responsive">
                                            <table class="table table-borderless" style="margin-bottom: 0px;">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-center" width="10%">Type</th>
                                                        <th class="text-center" width="20%">Name</th>
                                                        <th class="text-center" width="20%">Tracking</th>
                                                        <th class="text-center" style="white-space:nowrap" width="15%">Requested By</th>
                                                        <th class="text-center" style="white-space:nowrap" width="15%">Requested To</th>
                                                        <th class="text-center" style="white-space:nowrap" width="20%">Submission Date</th>
                                                    </tr>
                                                    <tr>
                                                        <td title="Type" class="text-center" width="10%" style="word-break:break-all"><?= ($lead["type_of_contact"]!=0) ? $lead["type_of_contact"] : 'Unknown'; ?></td>

                                                        <td title="Name" class="text-center" width="20%"><?= $lead["first_name"]." ".$lead["last_name"] ; ?></td>
                                                        <td align='left' title="Tracking Description" class="text-center" width="20%">
                                                            <?php
                                                                if ($lead["status"] == 0) {
                                                                    $trk_class = "label label-success";
                                                                    $status_name = "New";   
                                                                }elseif ($lead["status"] == 3) {
                                                                    $trk_class = "label badge-warning"; //badge-warning for lead section only
                                                                    $status_name = "Active";
                                                                }elseif ($lead["status"] == 2) {
                                                                    $trk_class = "label label-danger";
                                                                    $status_name = "Inactive";
                                                                }elseif ($lead["status"] == 1) {
                                                                    $trk_class = "label label-primary";
                                                                    $status_name = "Completed";
                                                                }
                                                                 
                                                            ?>
                                                            <a href='javascript:void(0);' onclick='show_lead_tracking_modal("<?= $lead["lead_id"]; ?>")'><span class="<?= $trk_class; ?>"><?= $status_name ?></span></a>
                                                       </td>
                                                        <td title="Requested By" class="text-center" width="15%">
                                                            <?php if(isset($staff_data_by) && !empty($staff_data_by)){
                                                                echo $staff_data_by["last_name"].', '.$staff_data_by["first_name"];
                                                            }else{
                                                                echo '-';
                                                            } ?>
                                                        </td>
                                                        <td title="Requested To" class="text-center" width="15%">
                                                            <?php if(isset($staff_data_to) && !empty($staff_data_to)){
                                                                echo $staff_data_to["last_name"].', '.$staff_data_to["first_name"];
                                                            }else{
                                                                echo '-';
                                                            } ?>
                                                        </td>
                                                        <td title="Submission Date" class="text-center" width="20%">
                                                            <?= ($lead["submission_date"] != "0000-00-00") ? date('m/d/Y',strtotime($lead["submission_date"])) : "-"; ?>
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
                    </div>
                    <hr class="hr-line-dashed m-b-10">
                    <div class="row m-b-0">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>