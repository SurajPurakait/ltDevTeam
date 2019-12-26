<div class="row">
	<div class="col-md-10">
        <table id="partners-table" class="table table-bordered billing-report-table table-striped text-center m-b-0">
            <thead>
                <tr>
                    <th class="text-uppercase" style="">Office</th>
                    <th class="text-uppercase" style="">Total</th>
                    <th class="text-uppercase" style="">Banker</th>
                    <th class="text-uppercase" style="">Business Owner</th>
                    <th class="text-uppercase" style="">Consultant</th>
                    <th class="text-uppercase" style="">Property Manager</th>
                    <th class="text-uppercase" style="">Insurance Agent</th>
                    <th class="text-uppercase" style="">Lawyer</th>
                    <th class="text-uppercase" style="">Real Estate Agent</th>
                    <th class="text-uppercase" style="">Vendor</th>
                    <th class="text-uppercase" style="">Other</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($partner_list as $ptl) {
                ?>                
                <tr>   
                    <td style=""><?= $ptl['office']; ?></td>
                    <td style=""><?= $ptl['total_partner']; ?></td>
                    <td style=""><?= $ptl['banker']; ?></td>
                    <td style=""><?= $ptl['business_owner']; ?></td>
                    <td style=""><?= $ptl['consultant']; ?></td>
                    <td style=""><?= $ptl['property_manager']; ?></td>
                    <td style=""><?= $ptl['insurance']; ?></td>
                    <td style=""><?= $ptl['lawyer']; ?></td>
                    <td style=""><?= $ptl['real_estate']; ?></td>
                    <td style=""><?= $ptl['vendor']; ?></td>
                    <td style=""><?= $ptl['other']; ?></td>
                </tr>
                <?php        
                    } 
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-2" style="margin-top: 80px">
        <h4 class="text-center">Offices</h4>
    <?php 
        foreach ($reports as $key => $value) {
            $data_id = array_column($partner_list,'id');        
            $data_total = array_column($partner_list,'total_partner');
            $data = array_combine($data_id, $data_total);        
    ?>
    <div class="partner-office-donut-<?= $key ?> text-center" data-size="100" id="partner_office_donut_<?= $key ?>" data-json="partner_office_data_<?= $key ?>"></div>
    
    <script>
        var partner_office_data_<?= $key ?> = [
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
         pieChart('partner-office-donut-<?= $key ?>');
    </script>
    <?php
        }
    ?>
    <h4 class="m-t-40 text-center">Type</h4>
    <?php
      foreach ($reports as $key => $value) {
        $banker = array_sum(array_column($partner_list,'banker'));
        $business_owner = array_sum(array_column($partner_list,'business_owner')); 
        $consultant = array_sum(array_column($partner_list,'consultant'));          
        $property_manager = array_sum(array_column($partner_list,'property_manager'));          
        $insurance = array_sum(array_column($partner_list,'insurance'));          
        $lawyer = array_sum(array_column($partner_list,'lawyer'));          
        $real_estate = array_sum(array_column($partner_list,'real_estate'));          
        $vendor = array_sum(array_column($partner_list,'vendor'));          
        $other = array_sum(array_column($partner_list,'other'));          
    ?>
    <div class="partner-type-donut-<?= $key ?> text-center" data-size="100" id="partner_type_donut_<?= $key ?>" data-json="partner_type_data_<?= $key ?>"></div>
    
    <script>
        var partner_type_data_<?= $key ?> = [
            {'section_label': 'Banker', 'value': <?= $banker; ?>, 'color': '#1c84c6'}, 
            {'section_label': 'Business Owner', 'value': <?= $business_owner; ?>, 'color': '#f8ac59'}, 
            {'section_label': 'Consultant', 'value': <?= $consultant; ?>, 'color': '#993333'},
            {'section_label': 'Property Manager', 'value': <?= $property_manager; ?>, 'color': '#1ab394'},
            {'section_label': 'Insurance Agent', 'value': <?= $insurance; ?>, 'color': '#e600ac'},
            {'section_label': 'Lawyer', 'value': <?= $lawyer; ?>, 'color': '#aaaa55'},
            {'section_label': 'Real Estate', 'value': <?= $real_estate; ?>, 'color': '#ff9900'},
            {'section_label': 'Vendor', 'value': <?= $vendor; ?>, 'color': '#004de6'},
            {'section_label': 'Other', 'value': <?= $other; ?>, 'color': '#003300'}
        ];                    
    </script>
    <script>
        pieChart('partner-type-donut-<?= $key ?>');
    </script>
    <?php
        }
    ?>
    </div>
</div>