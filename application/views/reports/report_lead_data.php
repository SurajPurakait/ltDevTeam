<?php 
    if ($category == 'status') {
?>
<div class="row">
    <div class="col-md-10">
        <table class="table table-bordered billing-report-table table-striped text-center m-b-0" id="lead-report-bystatus">
            <thead>
                <tr>
                    <th class="text-uppercase" style="white-space: nowrap;">Office</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Total</th>
                    <th class="text-uppercase" style="white-space: nowrap;">New</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Active</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Inactive</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Completed</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($lead_list as $ldl) {
                ?>                
                <tr>   
                    <td><?= $ldl['office']; ?></td>
                    <td><?= $ldl['total_lead']; ?></td>
                    <td><?= $ldl['new']; ?></td>
                    <td><?= $ldl['active']; ?></td>
                    <td><?= $ldl['inactive']; ?></td>
                    <td><?= $ldl['completed']; ?></td>
                </tr>
                <?php        
                    } 
                ?>
            </tbody>
        </table>
    </div>
    <?php
        if (staff_info()['type'] != 3) {
    ?>
    <div class="col-md-2" style="margin-top: 80px">
        <h4 class="text-center">Offices</h4>
    <?php 
        foreach ($reports as $key => $value) {
            $data_id = array_column($lead_list,'id');        
            $data_total = array_column($lead_list,'total_lead');
            $data = array_combine($data_id, $data_total);        
    ?>
    <div class="lead-office-donut-<?= $key ?> text-center" data-size="100" id="lead_office_donut_<?= $key ?>" data-json="lead_office_data_<?= $key ?>"></div>
    
    <script>
        var lead_office_data_<?= $key ?> = [
            {'section_label': 'Contador Fort Lauderdale ', 'value': <?= $data[34]; ?>, 'color': '#FFB046'}, 
            {'section_label': 'Contador Miami ', 'value': <?= $data[1]; ?>, 'color': '#06a0d6'}, 
            {'section_label': 'Contador Orlando', 'value': <?= $data[44]; ?>, 'color': '#ff8c1a'},
            {'section_label': 'Contador Sunny Isles', 'value':<?= $data[18];?>, 'color': '#009900'},
            {'section_label': 'Corporate', 'value':<?= $data[17];?>, 'color': '#663300'},
            {'section_label': 'LeafNet Office', 'value':<?= $data[41];?>, 'color': '#ff66cc'},
            {'section_label': 'Nalogi Miami', 'value':<?= $data[32];?>, 'color': '#ffdb4d'},
            {'section_label': 'TaxLeaf Aventura', 'value':<?= $data[30];?>, 'color': '#00ff99'},
            {'section_label': 'TaxLeaf Coral Gables', 'value':<?= $data[25];?>, 'color': '#99ff99'},
            {'section_label': 'TaxLeaf Coral Springs', 'value':<?= $data[29];?>, 'color': '#669900'},
            {'section_label': 'TaxLeaf Doral', 'value':<?= $data[22];?>, 'color': '#ffcc00'},
            {'section_label': 'Taxleaf DSM', 'value':<?= $data[39];?>, 'color': '#99ff66'},
            {'section_label': 'TaxLeaf Fort Lauderdale', 'value':<?= $data[26];?>, 'color': '#66ffff'},
            {'section_label': 'TaxLeaf Hallandale', 'value':<?= $data[24];?>, 'color': '#ff8c66'},
            {'section_label': 'TaxLeaf Hialeah', 'value':<?= $data[28];?>, 'color': '#e600ac'},
            {'section_label': 'TaxLeaf Kendall', 'value':<?= $data[27];?>, 'color': '#aaaa55'},
            {'section_label': 'TaxLeaf Lake Mary', 'value':<?= $data[31];?>, 'color': '#ff9900'},
            {'section_label': 'TaxLeaf Miramar', 'value':<?= $data[23];?>, 'color': '#004de6'},
            {'section_label': 'TaxLeaf North Miami Beach', 'value':<?= $data[19];?>, 'color': '#993333'},
            {'section_label': 'TaxLeaf Pembroke Pines', 'value':<?= $data[20];?>, 'color': '#003300'}
        ];                    
    </script>
    <script>
         pieChart('lead-office-donut-<?= $key ?>');
    </script>
    <?php
        }
    ?>
    <h4 class="m-t-40 text-center">Status</h4>
    <?php
      foreach ($reports as $key => $value) {
        $new = array_sum(array_column($lead_list,'new'));
        $active = array_sum(array_column($lead_list,'active')); 
        $inactive = array_sum(array_column($lead_list,'inactive'));          
        $completed = array_sum(array_column($lead_list,'completed'));          
    ?>
    <div class="lead-tracking-donut-<?= $key ?> text-center" data-size="100" id="lead_tracking_donut_<?= $key ?>" data-json="lead_tracking_data_<?= $key ?>"></div>
    
    <script>
        var lead_tracking_data_<?= $key ?> = [
            {'section_label': 'New ', 'value': <?= $new; ?>, 'color': '#1c84c6'}, 
            {'section_label': 'Active ', 'value': <?= $active; ?>, 'color': '#f8ac59'}, 
            {'section_label': 'Inactive', 'value': <?= $inactive; ?>, 'color': '#1ab394'},
            {'section_label': 'Completed', 'value': <?= $completed; ?>, 'color': '#993333'}
        ];                    
    </script>
    <script>
        pieChart('lead-tracking-donut-<?= $key ?>');
    </script>
    <?php
        }
    ?>
    </div>
    <?php
        }
    ?>
</div>
<?php
    }
    if ($category == 'type') {
?>
<div class="row">
    <div class="col-md-10">
        <table class="table table-bordered billing-report-table table-striped text-center m-b-0" id="lead-report-bytype">
            <thead>
                <tr>
                    <th class="text-uppercase" style="white-space: nowrap;">Office</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Total</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Client Lead</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Partner Lead</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($lead_list as $ldl) {
                ?>                
                <tr>   
                    <td><?= $ldl['office']; ?></td>
                    <td><?= $ldl['total_lead']; ?></td>
                    <td><?= $ldl['client_lead']; ?></td>
                    <td><?= $ldl['partner_lead']; ?></td>
                </tr>
                <?php        
                    } 
                ?>
            </tbody>
        </table>
    </div>
    <?php
        if (staff_info()['type'] != 3) {
    ?>
    <div class="col-md-2" style="margin-top: 80px">
        <h4 class="text-center">Offices</h4>
    <?php 
        foreach ($reports as $key => $value) {
            $data_id = array_column($lead_list,'id');        
            $data_total = array_column($lead_list,'total_lead');
            $data = array_combine($data_id, $data_total);        
    ?>
    <div class="leadtype-office-donut-<?= $key ?> text-center" data-size="100" id="leadtype_office_donut_<?= $key ?>" data-json="leadtype_office_data_<?= $key ?>"></div>
    
    <script>
        var leadtype_office_data_<?= $key ?> = [
            {'section_label': 'Contador Fort Lauderdale ', 'value': <?= $data[34]; ?>, 'color': '#FFB046'}, 
            {'section_label': 'Contador Miami ', 'value': <?= $data[1]; ?>, 'color': '#06a0d6'}, 
            {'section_label': 'Contador Orlando', 'value': <?= $data[44]; ?>, 'color': '#ff8c1a'},
            {'section_label': 'Contador Sunny Isles', 'value':<?= $data[18];?>, 'color': '#009900'},
            {'section_label': 'Corporate', 'value':<?= $data[17];?>, 'color': '#663300'},
            {'section_label': 'LeafNet Office', 'value':<?= $data[41];?>, 'color': '#ff66cc'},
            {'section_label': 'Nalogi Miami', 'value':<?= $data[32];?>, 'color': '#ffdb4d'},
            {'section_label': 'TaxLeaf Aventura', 'value':<?= $data[30];?>, 'color': '#00ff99'},
            {'section_label': 'TaxLeaf Coral Gables', 'value':<?= $data[25];?>, 'color': '#99ff99'},
            {'section_label': 'TaxLeaf Coral Springs', 'value':<?= $data[29];?>, 'color': '#669900'},
            {'section_label': 'TaxLeaf Doral', 'value':<?= $data[22];?>, 'color': '#ffcc00'},
            {'section_label': 'Taxleaf DSM', 'value':<?= $data[39];?>, 'color': '#99ff66'},
            {'section_label': 'TaxLeaf Fort Lauderdale', 'value':<?= $data[26];?>, 'color': '#66ffff'},
            {'section_label': 'TaxLeaf Hallandale', 'value':<?= $data[24];?>, 'color': '#ff8c66'},
            {'section_label': 'TaxLeaf Hialeah', 'value':<?= $data[28];?>, 'color': '#e600ac'},
            {'section_label': 'TaxLeaf Kendall', 'value':<?= $data[27];?>, 'color': '#aaaa55'},
            {'section_label': 'TaxLeaf Lake Mary', 'value':<?= $data[31];?>, 'color': '#ff9900'},
            {'section_label': 'TaxLeaf Miramar', 'value':<?= $data[23];?>, 'color': '#004de6'},
            {'section_label': 'TaxLeaf North Miami Beach', 'value':<?= $data[19];?>, 'color': '#993333'},
            {'section_label': 'TaxLeaf Pembroke Pines', 'value':<?= $data[20];?>, 'color': '#003300'}
        ];                    
    </script>
    <script>
         pieChart('leadtype-office-donut-<?= $key ?>');
    </script>
    <?php
        }
    ?>
    <h4 class="m-t-40 text-center">Type</h4>
    <?php
      foreach ($reports as $key => $value) {
        $client_lead = array_sum(array_column($lead_list,'client_lead'));
        $partner_lead = array_sum(array_column($lead_list,'partner_lead'));          
    ?>
    <div class="lead-type-donut-<?= $key ?> text-center" data-size="100" id="lead_type_donut_<?= $key ?>" data-json="lead_type_data_<?= $key ?>"></div>
    
    <script>
        var lead_type_data_<?= $key ?> = [
            {'section_label': 'Client Lead', 'value': <?= $client_lead; ?>, 'color': '#1c84c6'}, 
            {'section_label': 'Partner Lead', 'value': <?= $partner_lead; ?>, 'color': '#f8ac59'}
        ];                    
    </script>
    <script>
        pieChart('lead-type-donut-<?= $key ?>');
    </script>
    <?php
        }
    ?>
    </div>
    <?php
        }
    ?>
</div>        
<?php
    }
    if ($category == 'mail_campaign') {
?>
<div class="row">
    <div class="col-md-10">
        <table class="table table-bordered billing-report-table table-striped text-center m-b-0" id="lead-report-bycampaign">
            <thead>
                <tr>
                    <th class="text-uppercase" style="white-space: nowrap;">Office</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Total</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Day 0</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Day 3</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Day 6</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Mail Campaign On</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Mail Campaign Off</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($lead_list as $ldl) {
                ?>                
                <tr>   
                    <td><?= $ldl['office']; ?></td>
                    <td><?= $ldl['total_lead']; ?></td>
                    <td><?= $ldl['day_0']; ?></td>
                    <td><?= $ldl['day_3']; ?></td>
                    <td><?= $ldl['day_6']; ?></td>
                    <td><?= $ldl['campaign_on']; ?></td>
                    <td><?= $ldl['campaign_off']; ?></td>
                </tr>
                <?php        
                    } 
                ?>
            </tbody>
        </table>
    </div>
    <?php
        if (staff_info()['type'] != 3) {
    ?>
    <div class="col-md-2" style="margin-top: 80px">
        <h4 class="text-center">Offices</h4>
    <?php 
        foreach ($reports as $key => $value) {
            $data_id = array_column($lead_list,'id');        
            $data_total = array_column($lead_list,'total_lead');
            $data = array_combine($data_id, $data_total);        
    ?>
    <div class="lead-mailcampaign-donut-<?= $key ?> text-center" data-size="100" id="lead_mailcampaign_donut_<?= $key ?>" data-json="lead_mailcampaign_data_<?= $key ?>"></div>
    
    <script>
        var lead_mailcampaign_data_<?= $key ?> = [
            {'section_label': 'Contador Fort Lauderdale ', 'value': <?= $data[34]; ?>, 'color': '#FFB046'}, 
            {'section_label': 'Contador Miami ', 'value': <?= $data[1]; ?>, 'color': '#06a0d6'}, 
            {'section_label': 'Contador Orlando', 'value': <?= $data[44]; ?>, 'color': '#ff8c1a'},
            {'section_label': 'Contador Sunny Isles', 'value':<?= $data[18];?>, 'color': '#009900'},
            {'section_label': 'Corporate', 'value':<?= $data[17];?>, 'color': '#663300'},
            {'section_label': 'LeafNet Office', 'value':<?= $data[41];?>, 'color': '#ff66cc'},
            {'section_label': 'Nalogi Miami', 'value':<?= $data[32];?>, 'color': '#ffdb4d'},
            {'section_label': 'TaxLeaf Aventura', 'value':<?= $data[30];?>, 'color': '#00ff99'},
            {'section_label': 'TaxLeaf Coral Gables', 'value':<?= $data[25];?>, 'color': '#99ff99'},
            {'section_label': 'TaxLeaf Coral Springs', 'value':<?= $data[29];?>, 'color': '#669900'},
            {'section_label': 'TaxLeaf Doral', 'value':<?= $data[22];?>, 'color': '#ffcc00'},
            {'section_label': 'Taxleaf DSM', 'value':<?= $data[39];?>, 'color': '#99ff66'},
            {'section_label': 'TaxLeaf Fort Lauderdale', 'value':<?= $data[26];?>, 'color': '#66ffff'},
            {'section_label': 'TaxLeaf Hallandale', 'value':<?= $data[24];?>, 'color': '#ff8c66'},
            {'section_label': 'TaxLeaf Hialeah', 'value':<?= $data[28];?>, 'color': '#e600ac'},
            {'section_label': 'TaxLeaf Kendall', 'value':<?= $data[27];?>, 'color': '#aaaa55'},
            {'section_label': 'TaxLeaf Lake Mary', 'value':<?= $data[31];?>, 'color': '#ff9900'},
            {'section_label': 'TaxLeaf Miramar', 'value':<?= $data[23];?>, 'color': '#004de6'},
            {'section_label': 'TaxLeaf North Miami Beach', 'value':<?= $data[19];?>, 'color': '#993333'},
            {'section_label': 'TaxLeaf Pembroke Pines', 'value':<?= $data[20];?>, 'color': '#003300'}
        ];                    
    </script>
    <script>
         pieChart('lead-mailcampaign-donut-<?= $key ?>');
    </script>
    <?php
        }
    ?>
    <h4 class="m-t-40 text-center">Type</h4>
    <?php
      foreach ($reports as $key => $value) {
        $campaign_on = array_sum(array_column($lead_list,'campaign_on'));
        $campaign_off = array_sum(array_column($lead_list,'campaign_off'));          
    ?>
    <div class="lead-campaignstatus-donut-<?= $key ?> text-center" data-size="100" id="lead_campaignstatus_donut_<?= $key ?>" data-json="lead_campaignstatus_data_<?= $key ?>"></div>
    
    <script>
        var lead_campaignstatus_data_<?= $key ?> = [
            {'section_label': 'Mail Campaign On', 'value': <?= $campaign_on; ?>, 'color': '#1c84c6'}, 
            {'section_label': 'Mail Campaign Off', 'value': <?= $campaign_off; ?>, 'color': '#f8ac59'}
        ];                    
    </script>
    <script>
        pieChart('lead-campaignstatus-donut-<?= $key ?>');
    </script>
    <?php
        }
    ?>
    </div>
    <?php
        }
    ?>
</div>
<?php
    }
?>
<script type="text/javascript">
    $('#lead-report-bystatus').DataTable().destroy();
    $('#lead-report-bystatus').DataTable({
        'dom': '<"html5buttons"B>lTfgitp',
        'buttons': [ 
            {extend: 'excel', title: 'LeadByStatusReport'},
            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                },
                title: '',
                messageTop: function () {
                    return '<h2 style="color:#8ab645;text-align:center;font-weight:bold;margin-bottom:10px">Lead By Status Report</h2>';
                }
            }
        ],
        "bFilter": false,
        "paging":   false,
        "ordering": false,
        "info":     false

    });

    $('#lead-report-bytype').DataTable().destroy();
    $('#lead-report-bytype').DataTable({
        'dom': '<"html5buttons"B>lTfgitp',
        'buttons': [ 
            {extend: 'excel', title: 'LeadByTypeReport'},
            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                },
                title: '',
                messageTop: function () {
                    return '<h2 style="color:#8ab645;text-align:center;font-weight:bold;margin-bottom:10px">Lead By Type Report</h2>';
                }
            }
        ],
        "bFilter": false,
        "paging":   false,
        "ordering": false,
        "info":     false

    });

    $('#lead-report-bycampaign').DataTable().destroy();
    $('#lead-report-bycampaign').DataTable({
        'dom': '<"html5buttons"B>lTfgitp',
        'buttons': [ 
            {extend: 'excel', title: 'LeadByCampaignReport'},
            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                },
                title: '',
                messageTop: function () {
                    return '<h2 style="color:#8ab645;text-align:center;font-weight:bold;margin-bottom:10px">Lead By Campaign Report</h2>';
                },
            }
        ],
        "bFilter": false,
        "paging":   false,
        "ordering": false,
        "info":     false

    });

</script>