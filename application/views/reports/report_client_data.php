<?php
    if ($category == 'clients_by_office') {    
?>
<div class="row">
    <div class="col-md-10">
        <table class="table table-bordered report-table table-striped text-center m-b-0">
            <thead>
                <tr>
                    <th class="text-uppercase">Offices</th>
                    <th class="text-uppercase">Total Clients</th>
                    <th class="text-uppercase">Business Clients</th>
                    <th class="text-uppercase">Individual Clients</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($client_list as $value) {
                ?>
                <tr>   
                    <td><?= $value['office_name']; ?></td>
                    <td><?= $value['total_clients']; ?></td>
                    <td><?= $value['business']; ?></td>
                    <td><?= $value['individuals']; ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-2 m-t-40">
        <h4 class="text-center">Offices</h4>
        <?php 
            foreach ($reports as $key => $value) {
                $data_id = array_column($client_list,'id');        
                $data_total = array_column($client_list,'total_clients');
                $data = array_combine($data_id, $data_total);        
        ?>
        <div class="total-client-donut-<?= $key ?> text-center" data-size="100" id="total_client_donut_<?= $key ?>" data-json="total_client_data_<?= $key ?>"></div>
        
        <script>
            var total_client_data_<?= $key ?> = [
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
             pieChart('total-client-donut-<?= $key ?>');
        </script>
        <?php
             }
        ?>

        <h4 class="m-t-40 text-center">Client Type</h4>
        <?php 
            foreach ($reports as $key => $value) {

                $business = array_sum(array_column($client_list,'business'));
                $individuals = array_sum(array_column($client_list,'individuals'));           
        ?>
        <div class="client-type-donut-<?= $key ?> text-center" data-size="100" id="client_type_donut_<?= $key ?>" data-json="client_type_data_<?= $key ?>"></div>
        
        <script>
            var client_type_data_<?= $key ?> = [
                {'section_label': 'Business ', 'value': <?= $business; ?>, 'color': '#1c84c6'}, 
                {'section_label': 'Individual ', 'value': <?= $individuals; ?>, 'color': '#f8ac59'}
            ];                    
        </script>
        <script>
             pieChart('client-type-donut-<?= $key ?>');
        </script>
        <?php
            }
        ?>    
        </div> 
    </div>
<?php
    } else if ($category == 'business_clients_by_office') { 
?>

<div class="row">
    <div class="col-md-10">
        <table class="table table-bordered report-table table-striped text-center m-b-0">
            <thead>
                <tr>
                    <th class="text-uppercase">Offices</th>
                    <th class="text-uppercase">Total Clients</th>
                    <th class="text-uppercase">LLC</th>
                    <th class="text-uppercase">Single LLC</th>
                    <th class="text-uppercase">C Corp</th>
                    <th class="text-uppercase">F Corp</th>
                    <th class="text-uppercase">S Corp</th>
                    <th class="text-uppercase">Non Profit</th>
                    <th class="text-uppercase">Active</th>
                    <th class="text-uppercase">Inactive</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($client_list as $value) {
                ?>
                <tr>        
                    <td><?= $value['office_name']; ?></td>
                    <td><?= $value['total_clients']; ?></td>
                    <td><?= $value['llc']; ?></td>
                    <td><?= $value['singlellc']; ?></td>
                    <td><?= $value['ccrop']; ?></td>
                    <td><?= $value['fcrop']; ?></td>
                    <td><?= $value['scrop']; ?></td>
                    <td><?= $value['nonprofit']; ?></td>
                    <td><?= $value['active']; ?></td>
                    <td><?= $value['inactive']; ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-2">
        <h4 class="text-center">Offices</h4>
        <?php 
            foreach ($reports as $key => $value) {
                $data_id = array_column($client_list,'id');        
                $data_total = array_column($client_list,'total_clients');
                $data = array_combine($data_id, $data_total);        
        ?>
        <div class="business-client-donut-<?= $key ?> text-center" data-size="100" id="business_client_donut_<?= $key ?>" data-json="business_client_data_<?= $key ?>"></div>
        
        <script>
            var business_client_data_<?= $key ?> = [
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
             pieChart('business-client-donut-<?= $key ?>');
        </script>
        <?php
             }
        ?>

        <h4 class="m-t-40 text-center">Client Type</h4>
        <?php 
            foreach ($reports as $key => $value) {

                $llc = array_sum(array_column($client_list,'llc'));
                $singlellc = array_sum(array_column($client_list,'singlellc'));           
                $ccrop = array_sum(array_column($client_list,'ccrop'));           
                $fcrop = array_sum(array_column($client_list,'fcrop'));           
                $scrop = array_sum(array_column($client_list,'scrop'));           
                $nonprofit = array_sum(array_column($client_list,'nonprofit'));           
        ?>
        <div class="business-type-donut-<?= $key ?> text-center" data-size="100" id="business_type_donut_<?= $key ?>" data-json="business_type_data_<?= $key ?>"></div>
        
        <script>
            var business_type_data_<?= $key ?> = [
                {'section_label': 'LLC ', 'value': <?= $llc; ?>, 'color': '#1c84c6'}, 
                {'section_label': 'Single Member LLC ', 'value': <?= $singlellc; ?>, 'color': '#f8ac59'},
                {'section_label': 'C Corporation', 'value':<?= $ccrop; ?>, 'color': '#ff9900'},
                {'section_label': 'S Corporation', 'value':<?= $fcrop; ?>, 'color': '#004de6'},
                {'section_label': 'F Corporation', 'value':<?= $scrop; ?>, 'color': '#993333'},
                {'section_label': 'Non Profit Corporation', 'value':<?= $nonprofit; ?>, 'color': '#003300'}
            ];                    
        </script>
        <script>
             pieChart('business-type-donut-<?= $key ?>');
        </script>
        <?php
            }
        ?>    
    </div>
</div>
<?php 
    } else if ($category == 'individual_clients_by_office') {
?>
<div class="row">
    <div class="col-md-10">
        <table class="table table-bordered report-table table-striped text-center m-b-0">
            <thead>
                <tr>
                    <th class="text-uppercase">Offices</th>
                    <th class="text-uppercase">Total Clients</th>
                    <th class="text-uppercase">US Residents</th>
                    <th class="text-uppercase">Non Residents</th>
                    <th class="text-uppercase">Active</th>
                    <th class="text-uppercase">Inactive</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($client_list as $value) {
                ?>
                <tr>        
                    <td><?= $value['office_name']; ?></td>
                    <td><?= $value['total_clients']; ?></td>
                    <td><?= $value['usresidents']; ?></td>
                    <td><?= $value['nonresidents']; ?></td>
                    <td><?= $value['active']; ?></td>
                    <td><?= $value['inactive']; ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-2">
        <h4 class="text-center">Offices</h4>
        <?php 
            foreach ($reports as $key => $value) {
                $data_id = array_column($client_list,'id');        
                $data_total = array_column($client_list,'total_clients');
                $data = array_combine($data_id, $data_total);        
        ?>
        <div class="individual-client-donut-<?= $key ?> text-center" data-size="100" id="individual_client_donut_<?= $key ?>" data-json="individual_client_data_<?= $key ?>"></div>
        
        <script>
            var individual_client_data_<?= $key ?> = [
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
             pieChart('individual-client-donut-<?= $key ?>');
        </script>
        <?php
             }
        ?>

        <h4 class="m-t-40 text-center">Client Type</h4>
        <?php 
            foreach ($reports as $key => $value) {

                $usresidents = array_sum(array_column($client_list,'usresidents'));
                $nonresidents = array_sum(array_column($client_list,'nonresidents'));            
        ?>
        <div class="individual-type-donut-<?= $key ?> text-center" data-size="100" id="individual_type_donut_<?= $key ?>" data-json="individual_type_data_<?= $key ?>"></div>
        
        <script>
            var individual_type_data_<?= $key ?> = [
                {'section_label': 'US Residents', 'value': <?= $usresidents; ?>, 'color': '#1c84c6'}, 
                {'section_label': 'Non Residents ', 'value': <?= $nonresidents; ?>, 'color': '#f8ac59'},
            ];                    
        </script>
        <script>
             pieChart('individual-type-donut-<?= $key ?>');
        </script>
        <?php
            }
        ?>    
    </div>
</div>
<?php
    }
?>
