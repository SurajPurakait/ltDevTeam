<?php
if ($section == 'service') {
    foreach ($service_category_list as $scl) {
        ?>       
        <p class="p-10 text-success p-b-0" data-toggle="collapse" data-target="#collapse_<?php echo $scl['id'] ?>"><strong><?= ucfirst($scl['category_name']); ?></strong></p>
        <hr class="m-t-5 m-b-5">
        <div class="table-responsive collapse in" id="collapse_<?php echo $scl['id'] ?>">
            <table class="table table-striped">        
                <thead>
                    <tr>
                        <!-- <th width="30%" class="v-align-middle">Name</th> -->
                        <th width="15%" class="v-align-middle">Total</th>
                        <th class="text-center v-align-middle" width="15%">Not Start</th>
                        <th class="text-center v-align-middle" width="15%">Start</th>
                        <th class="text-center v-align-middle" width="15%">Late</th>
                        <th width="20%" class="v-align-middle">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- <td class="v-align-middle"><?//= ($office_id == '') ? 'ALL' : get_office_info_by_id($office_id)['office_id']; ?></td> -->
                        <td class="v-align-middle p-t-2 p-b-2"><a class="label bg-dark-grey p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('services/home/index/4/' . $scl['id'] . (($office_id != '') ? '/' . $office_id : '')); ?>" title="Total"><?= $service[$scl['category_name']]['total']; ?></a></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-blue-new p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('services/home/index/2/' . $scl['id'] . (($office_id != '') ? '/' . $office_id : '')); ?>" title="Not Start"><?= $service[$scl['category_name']]['not_start']; ?></a></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-yellow p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('services/home/index/1/' . $scl['id'] . (($office_id != '') ? '/' . $office_id : '')); ?>" title="Start"><?= $service[$scl['category_name']]['start']; ?></a></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-red p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('services/home/index/3/' . $scl['id'] . (($office_id != '') ? '/' . $office_id : '')); ?>" title="Late"><?= $service[$scl['category_name']]['late']; ?></a></td>
                        <td class="text-center v-align p-t-2 p-b-2">
                            <div class="service-campaigns-donut" data-size="50" id="service_donut_<?= $scl['id']; ?>" data-json="service_data_<?= $scl['id']; ?>"></div>
                            <script>
                                var service_data_<?= $scl['id']; ?> = [{'section_label': 'Not Started', 'value': <?= $service[$scl['category_name']]['not_start']; ?>, 'color': '#06a0d6'}, {'section_label': 'Started', 'value': <?= $service[$scl['category_name']]['start']; ?>, 'color': '#FFB046'}];
                                // var service_data_<?//= $scl['id']; ?> = [{'section_label': 'Not Started', 'value': <?//= $service[$scl['category_name']]['not_start']; ?>, 'color': '#FFB046'}, {'section_label': 'Started', 'value': <?//= $service[$scl['category_name']]['start']; ?>, 'color': '#18A689'}, {'section_label': 'Late', 'value': <?//= $service[$scl['category_name']]['late']; ?>, 'color': '#FF6C6C'}];
                            </script>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php }
    ?>
    <script type="text/javascript">
        pieChart('service-campaigns-donut');
    </script>
    <?php
}

if ($section == 'billing') {
    ?>
    <div class="table-responsive collapse in" id="collapse_billing">
        <table class="table table-striped">        
            <thead>
                <tr>
                    <th width="20%" class="v-align-middle">Status</th>
                    <th class="text-center v-align-middle" width="20%">Not Started</th>
                    <th class="text-center v-align-middle" width="20%">Started</th>
                    <th class="text-center v-align-middle" width="20%">Completed</th>
                    <th width="20%"class="v-align-middle">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($billing as $patment_status => $billing_array) { ?>
                    <tr>
                        <td class="v-align-middle p-t-2 p-b-2"><?= $patment_status; ?></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2">
                            <a class="label bg-blue-new p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('billing/home/index/1' . (($office_id != '') ? '/' . $office_id : '')); ?>" title="Not Started">
                                <?= $billing_array['not_started']; ?>
                            </a>
                        </td>
                        <td class="text-center v-align-middle p-t-2 p-b-2">
                            <a class="label bg-yellow p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('billing/home/index/2' . (($office_id != '') ? '/' . $office_id : '')); ?>" title="Started">
                                <?= $billing_array['started']; ?>
                            </a>
                        </td>
                        <td class="text-center v-align-middle p-t-2 p-b-2">
                            <a class="label bg-green p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('billing/home/index/3' . (($office_id != '') ? '/' . $office_id : '')); ?>" title="Completed">
                                <?= $billing_array['completed']; ?>
                            </a>
                        </td>
                        <td class="text-center v-align p-t-2 p-b-2">
                            <div class="billing-campaigns-donut" data-size="50" id="billing_donut_<?= $patment_status; ?>" data-json="billing_data_<?= $patment_status; ?>"></div>
                            <script>
                                var billing_data_<?= $patment_status; ?> = [{'section_label': 'Not Started', 'value': <?= $billing_array['not_started']; ?>, 'color': '#06a0d6'}, {'section_label': 'Started', 'value': <?= $billing_array['started']; ?>, 'color': '#FFB046'}, {'section_label': 'Completed', 'value': <?= $billing_array['completed']; ?>, 'color': '#18A689'}];
                            </script>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        pieChart('billing-campaigns-donut');
    </script>
    <?php
}

if ($section == 'client') {
    ?>
    <div class="table-responsive collapse in" id="collapse_client">
        <table class="table table-striped">        
            <thead>
                <tr>
                    <th width="20%" class="v-align-middle">Office</th>
                    <th class="text-center v-align-middle" width="20%">Business</th>
                    <th class="text-center v-align-middle" width="20%">Individual</th>
                    <th width="20%"class="v-align-middle">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="v-align-middle p-t-2 p-b-2"><?= ($office_id == '') ? 'ALL' : get_office_info_by_id($office_id)['name']; ?></td>
                    <td class="text-center v-align-middle p-t-2 p-b-2">
                        <a class="label bg-blue-new p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('/action/home/business_dashboard'); ?>" title="Business Client">
                            <?= $client['business']; ?>
                        </a>
                    </td>
                    <td class="text-center v-align-middle p-t-2 p-b-2">
                        <a class="label bg-blue-new p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('/action/home/individual_dashboard'); ?>" title="Individual">
                            <?= $client['individual']; ?>
                        </a>
                    </td>
                    <td class="text-center v-align p-t-2 p-b-2">
                        <div class="client-campaigns-donut" data-size="50" id="client_donut" data-json="client_data"></div>
                        <script>
                            var client_data = [{'section_label': 'Business Client', 'value': <?= $client['business']; ?>, 'color': '#06a0d6'}, {'section_label': 'Individual', 'value': <?= $client['individual']; ?>, 'color': '#18A689'}];
                        </script>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        pieChart('client-campaigns-donut');
    </script>
    <?php
}


if ($section == 'event') {
    ?>
    <div class="table-responsive collapse in" id="collapse_client">
        <table class="table table-striped">        
            <thead>
                <tr>
                    <th width="20%" class="v-align-middle">Office</th>
                    <th class="text-center v-align-middle" width="20%">Event</th>
                   <!--  <th class="text-center v-align-middle" width="20%">Individual</th> -->
                    <th width="20%"class="v-align-middle">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="v-align-middle p-t-2 p-b-2"><?= ($office_id == '') ? 'ALL' : get_office_info_by_id($office_id)['name']; ?></td>
                    <td class="text-center v-align-middle p-t-2 p-b-2">
                        <a class="label bg-blue-new p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('/lead_management/event/index/'.$office_id); ?>" title="Event">
                             <?= $event; ?>
                        </a>
                    </td>
                    
                    <td class="text-center v-align p-t-2 p-b-2">
                        <!-- <div class="client-campaigns-donut" data-size="50" id="client_donut" data-json="client_data"></div>
                        <script>
                            var client_data = [{'section_label': 'Business Client', 'value': <?//= $client['business']; ?>, 'color': '#06a0d6'}, {'section_label': 'Individual', 'value': <?//= $client['individual']; ?>, 'color': '#18A689'}];
                        </script> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- <script type="text/javascript">
        pieChart('client-campaigns-donut');
    </script> -->
    <?php
}



if ($section == 'action') {
    foreach ($request_type_list as $rtl) {
        $arrow = '';
        if ($rtl['request_name'] == 'By Me' || $rtl['request_name'] == 'To Other') {
            $arrow = '<i class="fa fa-arrow-up" style="color: #01997a;font-size: 15px;"></i>';
        }
        if ($rtl['request_name'] == 'To Me' || $rtl['request_name'] == 'By Other') {
            $arrow = '<i class="fa fa-arrow-down" style="color: #ce4e59;font-size: 15px;"></i>';
        }

        if ($rtl['request_name'] == 'My Task') {
            $arrow = '<i class="fa fa-arrow-right" style="color: #cc891a;font-size: 15px;" ></i>';
        }
        if ($rtl['request_name'] != 'Unassigned') {
            ?>
            <p class="p-10 text-success p-b-0" data-toggle="collapse" data-target="#collapse_<?php echo str_replace(' ', '_', $rtl['request_name']); ?>"><strong><?= $rtl['request_name'] . ' ' . $arrow; ?></strong></p>
            <hr class="m-t-5 m-b-5">
            <div class="table-responsive collapse in" id="collapse_<?php echo str_replace(' ', '_', $rtl['request_name']) ?>">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="20%"></th>
                            <th class="text-center v-align-middle" width="20%">New</th>
                            <th class="text-center v-align-middle" width="20%">start</th>
                            <th class="text-center v-align-middle" width="20%">Resolved</th>
                            <!-- <th class="text-center v-align-middle" width="20%">Complete</th> -->
                            <th width="20%" class="v-align-middle">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($priority_list as $priority_index => $priority) {
//                                if($priority=='important') continue;
                            ?>
                            <tr>
                                <td class="v-align-middle p-t-2 p-b-2"><span class="action-<?= $priority; ?>"><b><?= strtoupper($priority); ?></b></span></td>
                                <td class="text-center v-align-middle p-t-2 p-b-2"
                                <?php
                                //echo ($priority == 'important') ? 'style="display:none;"':''
                                ?>
                                    ><a class="label bg-blue-new p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('action/home/index/0/' . $priority_index . '/' . $rtl['request'] . '/' . (($office_id != '') ? '/' . $office_id : '0') . '/' . (($department_id != '') ? '/' . $department_id : '0')); ?>" title="New"><?= $action[$rtl['request']][$priority]['new']; ?></a></td>
                                <td class="text-center v-align-middle p-t-2 p-b-2"
                                <?php
                                //echo ($priority == 'important') ? 'style="display:none;"':''
                                ?>
                                    ><a class="label bg-yellow p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('action/home/index/1/' . $priority_index . '/' . $rtl['request'] . '/' . (($office_id != '') ? '/' . $office_id : '0') . '/' . (($department_id != '') ? '/' . $department_id : '0')); ?>" title="Start"><?= $action[$rtl['request']][$priority]['start']; ?></a></td>
                                <td class="text-center v-align-middle p-t-2 p-b-2"
                                <?php
                                //echo ($priority == 'important') ? 'style="display:none;"':''
                                ?>
                                    ><a class="label bg-green p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('action/home/index/6/' . $priority_index . '/' . $rtl['request'] . '/' . (($office_id != '') ? '/' . $office_id : '0') . '/' . (($department_id != '') ? '/' . $department_id : '0')); ?>" title="Resolved"><?= $action[$rtl['request']][$priority]['resolved']; ?></a></td>
                                    <!-- <td class="text-center v-align-middle"><a class="label bg-green p-l-10 p-r-10 p-t-5 p-b-5" href="<?//= base_url('action/home/index/2/' . $priority_index . '/' . $rtl['request'] . '/' . (($office_id != '') ? '/' . $office_id : '0') . '/' . (($department_id != '') ? '/' . $department_id : '0')); ?>" title="Complete"><?//= $action[$rtl['request']][$priority]['complete']; ?></a></td> -->
                                <td class="text-center v-align p-t-2 p-b-2"
                                <?php
                                //echo ($priority == 'important') ? 'style="display:none;"':''
                                ?>
                                    >
                                    <div class="action-campaigns-donut" data-size="50" id="action_donut_<?= $rtl['request'] . '_' . $priority; ?>" data-json="action_data_<?= $rtl['request'] . '_' . $priority; ?>"></div>
                                    <script>
                                        // var action_data_<?//= $rtl['request'] . '_' . $priority; ?> = [{'section_label': 'Complete', 'value': <?//= $action[$rtl['request']][$priority]['complete']; ?>, 'color': '#18A689'}, {'section_label': 'Start', 'value': <?//= $action[$rtl['request']][$priority]['start']; ?>, 'color': '#FFB046'}, {'section_label': 'New', 'value': <?//= $action[$rtl['request']][$priority]['new']; ?>, 'color': '#06a0d6'}];
                                        var action_data_<?= $rtl['request'] . '_' . $priority; ?> = [{'section_label': 'Start', 'value': <?= $action[$rtl['request']][$priority]['start']; ?>, 'color': '#FFB046'}, {'section_label': 'New', 'value': <?= $action[$rtl['request']][$priority]['new']; ?>, 'color': '#06a0d6'},
                                            {'section_label': 'Resolved', 'value': <?= $action[$rtl['request']][$priority]['resolved']; ?>, 'color': 'green'}];
                                    </script>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
    }
    ?>
    <script type="text/javascript">
        pieChart('action-campaigns-donut');
    </script>
    <?php
}
if ($section == 'lead') {
    ?>
    <p class="p-10 text-success p-b-0" data-toggle="collapse" data-target="#leadAll"><strong>All Leads</strong></p>
    <hr class="m-t-5 m-b-5">
    <div class="table-responsive collapse in" id="leadAll">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="20%" class="v-align-middle"></th>
                    <th class="text-center v-align-middle" width="15%">Total</th>
                    <th class="text-center v-align-middle" width="15%">New</th>
                    <th class="text-center v-align-middle" width="15%">Active</th>
                    <th class="text-center v-align-middle" width="15%">Inactive</th>
                    <th width="20%" class="v-align-middle">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lead as $lead_index => $lead_array) { ?>
                    <tr>
                        <td class="v-align-middle"><?//= ucwords(str_replace('_', ' ', $lead_index)); ?></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-dark-grey p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('lead_management/home/index/all/' . (($lead_index == 'client_leads') ? '1' : '2') . (($lead_type_id != '') ? '/' . $lead_type_id : '')); ?>" title="Total"><?= $lead_array['total']; ?></a></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-blue-new p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('lead_management/home/index/0/' . (($lead_index == 'client_leads') ? '1' : '2') . (($lead_type_id != '') ? '/' . $lead_type_id : '')); ?>" title="New"><?= $lead_array['new']; ?></a></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-yellow p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('lead_management/home/index/3/' . (($lead_index == 'client_leads') ? '1' : '2') . (($lead_type_id != '') ? '/' . $lead_type_id : '')); ?>" title="Active"><?= $lead_array['active']; ?></a></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-light-grey p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('lead_management/home/index/2/' . (($lead_index == 'client_leads') ? '1' : '2') . (($lead_type_id != '') ? '/' . $lead_type_id : '')); ?>" title="Inactive"><?= $lead_array['inactive']; ?></a></td>
                        <td class="text-center v-align p-t-2 p-b-2">
                            <div class="lead-campaigns-donut" data-size="50" id="lead_donut_<?= $lead_index; ?>" data-json="lead_data_<?= $lead_index; ?>"></div>
                            <script>
                                var lead_data_<?= $lead_index; ?> = [{'section_label': 'Inactive', 'value': <?= $lead_array['inactive']; ?>, 'color': '#d2d2d280'}, {'section_label': 'Active', 'value': <?= $lead_array['active']; ?>, 'color': '#FFB046'}, {'section_label': 'New', 'value': <?= $lead_array['new']; ?>, 'color': '#06a0d6'}];
                            </script>
                        </td>
                    </tr>

                <?php }
                ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        pieChart('lead-campaigns-donut');
    </script>
    <?php
}
if ($section == 'partner') {
?>  
    <p class="p-10 text-success p-b-0" data-toggle="collapse" data-target="#referralPartner"><strong>Referral Partners</strong></p>
    <div class="table-responsive collapse in" id="referralPartner">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td class="v-align-middle">Referred By Me</td>
                    <td class="text-center v-align-middle p-t-2 p-b-2"><a href="<?= base_url('referral_partner/referral_partners/partners/1'); ?>" class="label bg-blue-new p-l-10 p-r-10 p-t-5 p-b-5" ><?= $partner_list['referred_by_me']; ?></a></td> </tr>
                <tr>
                    <td class="v-align-middle">Referred By Others</td>
                    <td class="text-center v-align-middle p-t-2 p-b-2"><a href="<?= base_url('referral_partner/referral_partners/partners/2'); ?>" class="label bg-yellow p-l-10 p-r-10 p-t-5 p-b-5" ><?= $partner_list['referred_by_other']; ?></a></td>
                </tr>
            </tbody>
        </table>        
    </div>
    <p class="p-10 text-success p-b-0" data-toggle="collapse" data-target="#leadPartner"><strong>Partners' Lead</strong></p>
    <div class="table-responsive collapse in" id="leadPartner">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="25%" class="v-align-middle"></th>
                    <th class="text-center v-align-middle" width="20%">New</th>
                    <th class="text-center v-align-middle" width="20%">Active</th>
                    <th class="text-center v-align-middle" width="20%">Inactive</th>
                    <th width="15%" class="text-center v-align-middle">&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($partner as $partner_index => $partner_array) { 
                    $partner_index_param = str_replace('_', '', $partner_index);
                    ?>
                    <tr>
                        <td class="v-align-middle"><?= ucwords(str_replace('_', ' ', $partner_index)); ?></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-blue-new p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('partners/index/0/' . (($partner_index_param != '') ? $partner_index_param : '0')); ?>" title="New"><?= $partner_array['new']; ?></a></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-yellow p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('partners/index/3/' . (($partner_index_param != '') ? $partner_index_param : '0')); ?>" title="Active"><?= $partner_array['active']; ?></a></td>
                        <td class="text-center v-align-middle p-t-2 p-b-2"><a class="label bg-light-grey p-l-10 p-r-10 p-t-5 p-b-5" href="<?= base_url('partners/index/2/' . (($partner_index_param != '') ? $partner_index_param : '0')); ?>" title="Inactive"><?= $partner_array['inactive']; ?></a></td>
                        <td class="text-center v-align p-t-2 p-b-2">
                            <div class="partner-campaigns-donut" data-size="50" id="lead_donut_<?= $partner_index; ?>" data-json="partner_data_<?= $partner_index; ?>"></div>
                            <script>
                                var partner_data_<?= $partner_index; ?> = [{'section_label': 'Inactive', 'value': <?= $partner_array['inactive']; ?>, 'color': '#d2d2d280'}, {'section_label': 'Active', 'value': <?= $partner_array['active']; ?>, 'color': '#FFB046'}, {'section_label': 'New', 'value': <?= $partner_array['new']; ?>, 'color': '#06a0d6'}];
                            </script>
                        </td>
                    </tr>

                <?php }
                ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        pieChart('partner-campaigns-donut');
    </script>    
<?php    
}
if ($section == 'sos') {
    $sos_count = 0;
    ?>
    <div class="feed-activity-list">
        <?php
        // echo "<pre>";
        // print_r($sos_notification_list);
        foreach ($sos_notification_list as $sos_index => $snl) {
            $diff_days = $snl['how_old_days'];
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
            $action_type = '';
            $class1 = '';
            if ($snl['reference'] == 'action') {
                $action_type = 'Action';
                $class1 = 'bg-green';
                $view_url = base_url() . 'action/home/view_action/' . $snl['reference_id'];
            }
            if ($snl['reference'] == 'order') {
                $action_type = 'Service';
                $class1 = 'bg-yellow';
                $view_url = base_url() . 'services/home/view/' . $snl['reference_id'];
            }
            if ($snl['reference'] == 'projects') {
                $action_type = 'Project';
                $class1 = 'bg-info';
                $view_url = "#";
            }
            ?>
            <div class="feed-element sos-item sos-<?= $snl['reference']; ?> sos-<?= ($sos_index > 4) ? 'hide' : 'show'; ?> sos-<?= $diff_text; ?>" <?= ($sos_index > 4) ? 'style="display: none;"' : ''; ?> id="sos-notification-div-<?= $snl['id']; ?>">
                <?php // if ($snl['added_by_user'] == sess('user_id')):   ?>
                <a href="javascript:void(0);" onclick="clear_sos_notifications('<?= $snl['id']; ?>', '', '<?= $snl['reference_id']; ?>');
                // document.getElementById('sos-notification-div-<?//= $snl['id']; ?>').remove();
                " class="pull-right text-muted p-5"> <i class="fa fa-times"></i></a>
                <?php // endif;   ?>
                <a class="media-body" href="<?php echo $view_url; ?>">
                    <span class="label <?= $class1 ?>  d-inline"><?= $action_type ?></span>&nbsp;&nbsp;&nbsp;<b># <?= $snl['reference_id']; ?></b><br><strong>Message: <?= $snl['msg']; ?></strong><br>
                    <small class="text-muted"><b>By: <?= ($snl['added_by_user'] == sess('user_id') ? 'You' : staff_info_by_id($snl['added_by_user'])['full_name']); ?>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;To: <?php echo get_department_name_by_id($snl['department']); ?><br><?= $diff_days == 0 ? date('h:i A', strtotime($snl['added_on'])) . '| Today' : date('h:i A | m/d/Y', strtotime($snl['added_on'])); ?></b></small>
                </a>
            </div>
            <?php
            $sos_count++;
        }
        ?>
        <p class="text-danger sos-empty" <?= $sos_count != 0 ? 'style="display: none;"' : ''; ?>>Notification not found</p>
    </div>
    <?php if (count($sos_notification_list) > 5) { ?>
        <button onclick="displaySOSItems('item');" class="btn btn-primary btn-block m-t sos-see-more-btn"><i class="fa fa-arrow-down"></i> Show More</button>
        <?php
    }
}
if ($section == 'notification') {
//    echo count($general_notification_list);
//    echo "hi";die;
    $notification_counts = '';
    $row_number=0;
    ?>
    <div class="feed-activity-list">
        <?php
        if (!empty($general_notification_list)) {
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

                // if (strpos($gnl['notification_text'], 'YOU') !== false) {
                //     $ref_by = "byme";
                // } else {
                //     $ref_by = "byothers";
                // }
                $view_url='';
                if ($gnl['reference'] == 'invoice') {
                    $reference_type = "Billing";
                    $class = 'invoice';
                    $class1 = 'bg-blue-new';
                    $view_url = base_url() . 'billing/invoice/details/' . base64_encode($gnl['reference_id']);
                }if ($gnl['reference'] == 'action') {
                    $reference_type = "Action";
                    $class = 'action';
                    $class1 = 'bg-green';
                    $view_url = base_url() . 'action/home/view_action/' . $gnl['reference_id'];
                }if ($gnl['reference'] == 'order') {
                    $reference_type = "Service";
                    $class = 'order';
                    $class1 = 'bg-yellow';
                    $view_url = base_url() . 'services/home/view/' . $gnl['reference_id'];
                }
                if ($gnl['reference'] == 'lead') {
                    $reference_type = "Lead";
                    $class = 'lead';
                    $class1 = 'bg-purpel';
                    $view_url = base_url() . 'lead_management/home/view/' . $gnl['reference_id'];
                }
                if ($gnl['reference'] == 'partner') {
                    $reference_type = "Partner";
                    $class = 'partner';
                    $class1 = 'bg-sucess';
                    $view_url = $view_url = base_url() . 'referral_partner/referral_partners/view_referral/' . $gnl['reference_id'];
                }
                if ($gnl['reference'] == 'refer') {
                    $reference_type = "Partner";
                    $class = 'partner';
                    $class1 = 'bg-sucess';
                    $view_url = $view_url = base_url() . 'referral_partner/referral_partners/view_referral/' . $gnl['reference_id'];
                }

                ?>
                <div class="feed-element notification-item notification-<?= $gnl['reference']; ?>  notification-<?= ($notification_index > 4) ? 'hide' : 'show'; ?> notification-<?= $diff_text; ?>" <?= ($notification_index > 4) ? 'style="display: none;"' : ''; ?> id="notification-div-<?= $gnl['id']; ?>">
                    <?php //if ($gnl['added_by'] != sess('user_id')):   ?>
                    <a href="javascript:void(0);" onclick="readNotification('<?= $gnl['id']; ?>');document.getElementById('notification-div-<?= $gnl['id']; ?>').remove();" class="pull-right text-muted p-5 p-t-0"><i class="fa fa-times"></i></a>
                    <?php //endif;   ?>
                    <a class="media-body" href="<?php echo $view_url; ?>">
                        <span class="label <?= $class1 ?>  d-inline"><?= $reference_type ?></span>&nbsp;<?= $gnl['notification_text']; ?><br>
                        <small class="text-muted"><?= ($diff_days == 0 ? date('h:i A', strtotime($gnl['added_on'])) . '|  Today' : date('h:i A | m/d/Y', strtotime($gnl['added_on']))) . ' | <strong>' . $gnl['added_by_user_office'] . '</strong>'; ?></small>
                    </a>
                </div>
                <?php
                $notification_counts++;
                $row_number= $notification_index+1;
            }
            $notification_count = $notification_count + $notification_counts;
        } else {
            ?>
            <p class="text-danger notification-empty" <?= $notification_counts != 0 ? 'style="display: none;"' : ''; ?>>Notification not found</p>
        <?php } ?>
    </div>
    <?php if ($notification_counts != 0) {
        if($start!=$notification_count){
        ?>   
        <input type="hidden" name="start_val" id="start_val" value="<?= $notification_count ?>">
        <button onclick="loadHomeDashboard('notification', '<?= sess('user_id') ?>', '', '', '', '', '<?= $notification_count ?>', '', '', '<?= $request_type ?>','<?= $page_number+1?>');" class="btn btn-primary btn-block m-t notification-see-more-btn" id='load_more'><i class="fa fa-arrow-down"></i> Load More</button>
        <?php
    }
    }
}
if ($section == 'news_update') {

    $staff_info = staff_info();
    $user_department = $staff_info['department'];
    //print_r($staff_info);
    $user_type = $staff_info['type'];
    ?>
    <div class="feed-activity-list">
        <?php
        if (!empty($news_update_list)) {
            foreach ($news_update_list as $news_update) {

                $class = 'label-update';

                if ($news_update['priority'] == 'important') {
                    $class = 'label-news';
                }

                if ($user_department != 14) {
                    if ($user_type != 1 && $news_update['is_read'] == '1') {
                        $class = 'label-read';
                    }
                }
                $class1 = 'bg-update';
                $class2 = 'update';
                if ($news_update['news_type'] == 'news') {
                    $class1 = 'bg-news';
                    $class2 = 'news';
                }
                $diff_days = $news_update['how_old_days'];
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

                <div id="news-notification-<?= $news_update['id'] ?>" class="feed-element news-item newss-<?= $news_update['news_type'] ?> newss-<?= $diff_text; ?>"><div class="<?= $class ?>">
                        <?php
                        if ($staff_info['type'] == 1 || $user_department == 14) {
                            ?>
                            <a href="javascript:void(0);" onclick="delNewsNotificationAdmin('<?= $news_update['id'] ?>')" class="pull-right"><i class="fa fa-times"></i></a>
                            <?php
                        } else {
                            if ($news_update['priority'] == 'important') {
                                if ($news_update['is_read'] == 1) {
                                    ?>
                                    <a href="javascript:void(0);" onclick="delNewsNotification('<?= $news_update['id'] ?>', '<?= $staff_info['id'] ?>')" class="pull-right"><i class="fa fa-times"></i></a>
                                    <?php
                                }
                            } else {
                                ?>
                                <a href="javascript:void(0);" onclick="delNewsNotification('<?= $news_update['id'] ?>', '<?= $staff_info['id'] ?>')" class="pull-right"><i class="fa fa-times"></i></a>
                                <?php
                            }
                        }
                        ?>
                        <!-- <a id="text-link-<?//= $news_update['id'] ?>" class="media-body <?= $class ?>" href="javascript:void(0)" onclick="getNewsDetailsModal('<?//= $news_update['id'] ?>', '<?//= $staff_info['type'] ?>', '<?//= $staff_info['id'] ?>');"> -->
                        <a id="text-link-<?= $news_update['id'] ?>" class="media-body <?= $class ?>" href="<?= base_url().'news'; ?>">    
                            <span class="label d-inline <?= $class1 ?>"><?= $news_update['news_type'] ?></span>&nbsp;<strong><?php echo ((strlen($news_update['subject']) > 25) ? (substr_replace($news_update['subject'], '...', 25)) : $news_update['subject']) ?></strong><br>
                            <small class="text-muted"><?= ($diff_days == 0 ? date('h:i A', strtotime($news_update['created_type'])) . ', Today' : date('h:i A - m/d/Y', strtotime($news_update['created_type']))) ?><?php if ($staff_info['type'] == 1 || $user_department == 14) { ?> |&nbsp;<?php
                                    $get_name = get_assigned_dept_news($news_update['id'], $news_update['office_type']);
                                    echo implode('<br>', $get_name);
                                }
                                ?>|&nbsp;<b><?php echo get_assigned_staff_news($news_update['id']); ?></b></small>
                        </a> 
                    </div>
                </div>
                <div id="new_details_div"></div>
            <?php } ?>
            <a href="javascript:void(0)" id="news_view_more_link" class="btn btn-primary btn-block m-t newss-see-more-btn">View More</a>
            <div class="clearfix m-t-10">
                <a href="<?= base_url(); ?>news" class="pull-right text-success" style="text-decoration:underline">View All</a>
            </div>
            <?php
        }
        ?>
        <p class="text-danger newss-empty" <?= !empty($news_update_list) ? 'style="display: none;"' : ''; ?>>News and Update not found</p>

    </div>
    <?php
}
