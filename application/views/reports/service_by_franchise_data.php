<?php
    if ($category == 'franchise') {    
?>
<div class="row">
    <div class="col-md-10">
<table class="table table-bordered report-table table-striped text-center m-b-0">
    <thead>
        <tr>
            <th class="text-uppercase">Offices</th>
            <th class="text-uppercase">Totals</th>
            <th class="text-uppercase">New</th>
            <th class="text-uppercase">Started</th>
            <th class="text-uppercase">Completed</th>
            <th class="text-uppercase">< 30</th>
            <th class="text-uppercase">< 60</th>
            <th class="text-uppercase">+ 60</th>
            <th class="text-uppercase">SOS</th>
            
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($service_by_franchise_list as $value) {
        ?>
        <tr>   
            <td><?= $value['office_name']; ?></td>
            <td><?= $value['totals']; ?></td>
            <td><?= $value['new']; ?></td>
            <td><?= $value['started']; ?></td>
            <td><?= $value['completed']; ?></td>
            <td><?= $value['less_than_30']; ?></td>
            <td><?= $value['less_than_60']; ?></td>
            <td><?= $value['more_than_60']; ?></td>
            <td><?= $value['sos']; ?></td>
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
            $data_id = array_column($service_by_franchise_list,'id');        
            $data_total = array_column($service_by_franchise_list,'totals');
            $data = array_combine($data_id, $data_total);        
    ?>
    <div class="service-franchise-donut-<?= $key ?> text-center" data-size="100" id="service_franchise_donut_<?= $key ?>" data-json="service_franchise_data_<?= $key ?>"></div>
    
    <script>
        var service_franchise_data_<?= $key ?> = [
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
         pieChart('service-franchise-donut-<?= $key ?>');
    </script>
    <?php
         }
    ?>

    <h4 class="m-t-40 text-center">Tracking</h4>
    <?php 
        foreach ($reports as $key => $value) {
            $new = array_sum(array_column($service_by_franchise_list,'new'));
            $started = array_sum(array_column($service_by_franchise_list,'started')); 
            $completed = array_sum(array_column($service_by_franchise_list,'completed'));
            // echo $new."-".$Started."-".$completed;          
    ?>
    <div class="service-tracking-donut-<?= $key ?> text-center" data-size="100" id="service_tracking_donut_<?= $key ?>" data-json="service_tracking_data_<?= $key ?>"></div>
    
    <script>
        var service_tracking_data_<?= $key ?> = [
            {'section_label': 'New ', 'value': <?= $new; ?>, 'color': '#1c84c6'}, 
            {'section_label': 'Started ', 'value': <?= $started; ?>, 'color': '#f8ac59'}, 
            {'section_label': 'Completed', 'value': <?= $completed; ?>, 'color': '#1ab394'},
        ];                    
    </script>
    <script>
         pieChart('service-tracking-donut-<?= $key ?>');
    </script>
<?php
    }
?>    
</div>
</div>
<?php
    } else if ($category == 'department') { 
?>

<div class="row">
    <div class="col-md-10">
<table class="table table-bordered report-table table-striped text-center m-b-0">
    <thead>
        <tr>
            <th class="text-uppercase">Departments</th>
            <th class="text-uppercase">Totals</th>
            <th class="text-uppercase">New</th>
            <th class="text-uppercase">Started</th>
            <th class="text-uppercase">Completed</th>
            <th class="text-uppercase">< 30</th>
            <th class="text-uppercase">< 60</th>
            <th class="text-uppercase">+ 60</th>
            <th class="text-uppercase">SOS</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($service_by_franchise_list as $value) {
        ?>
        <tr>        
            <td><?= $value['department_name']; ?></td>
            <td><?= $value['totals']; ?></td>
            <td><?= $value['new']; ?></td>
            <td><?= $value['started']; ?></td>
            <td><?= $value['completed']; ?></td>
            <td><?= $value['less_than_30']; ?></td>
            <td><?= $value['less_than_60']; ?></td>
            <td><?= $value['more_than_60']; ?></td>
            <td><?= $value['sos']; ?></td>
        </tr>
        <?php 
            }
        ?>
    </tbody>
</table>
        
    </div>
    <div class="col-md-2">
        <h4 class="m-t-40 text-center">Department</h4>
        <?php 
            foreach ($reports as $key => $value) {
                $data_id = array_column($service_by_franchise_list,'id');        
                $data_total = array_column($service_by_franchise_list,'totals');
                $data = array_combine($data_id,$data_total);        
            ?>
            <div class="service-department-donut-<?= $key ?> text-center" data-size="100" id="service_department_donut_<?= $key ?>" data-json="service_department_data_<?= $key ?>"></div>
            
            <script>
                var service_department_data_<?= $key ?> = [
                    {'section_label': 'Billing ', 'value': <?= $data[3]; ?>, 'color': '#cc6600'}, 
                    {'section_label': 'Payroll ', 'value': <?= $data[4]; ?>, 'color': '#06a0d6'}, 
                    {'section_label': 'Bookkeeping', 'value': <?= $data[5]; ?>, 'color': '#ff8c1a'},
                    {'section_label': 'Data', 'value':<?= $data[6];?>, 'color': '#009900'},
                    {'section_label': 'Franchisor', 'value':<?= $data[7];?>, 'color': '#663300'},
                    {'section_label': 'Government', 'value':<?= $data[8];?>, 'color': '#ff66cc'},
                    {'section_label': 'Marketing', 'value':<?= $data[10];?>, 'color': '#ffdb4d'},
                    {'section_label': 'Leafnet', 'value':<?= $data[11];?>, 'color': '#00ff99'},
                    {'section_label': 'Leafcloud', 'value':<?= $data[12];?>, 'color': '#99ff99'},
                    {'section_label': 'CPA ', 'value':<?= $data[13];?>, 'color': '#669900'},
                    {'section_label': 'Admin', 'value':<?= $data[14];?>, 'color': '#ffcc00'},
                ];                    
            </script>
            <script>
                 pieChart('service-department-donut-<?= $key ?>');
            </script>
            <h4 class="m-t-40 text-center">Tracking</h4>
            <?php
                 }
            ?>
            <?php 
                foreach ($reports as $key => $value) {
                    $new = array_sum(array_column($service_by_franchise_list,'new'));
                    $started = array_sum(array_column($service_by_franchise_list,'started')); 
                    $completed = array_sum(array_column($service_by_franchise_list,'completed'));          
            ?>
            <div class="department-tracking-donut-<?= $key ?> text-center" data-size="100" id="department_tracking_donut_<?= $key ?>" data-json="department_tracking_data_<?= $key ?>"></div>
            
            <script>
                var department_tracking_data_<?= $key ?> = [
                    {'section_label': 'New ', 'value': <?= $new; ?>, 'color': '#1c84c6'}, 
                    {'section_label': 'Started ', 'value': <?= $started; ?>, 'color': '#f8ac59'}, 
                    {'section_label': 'Completed', 'value': <?= $completed; ?>, 'color': '#1ab394'},
                ];                    
            </script>
            <script>
                 pieChart('department-tracking-donut-<?= $key ?>');
            </script>
            <?php
                 }
            ?>
    </div>
</div>
<?php 
    } else if ($category == 'service_category') {
?>
<div class="row">
    <div class="col-md-10">
<table class="table table-bordered report-table table-striped text-center m-b-0">
    <thead>
        <tr>
            <th class="text-uppercase">Category</th>
            <th class="text-uppercase">Totals</th>
            <th class="text-uppercase">New</th>
            <th class="text-uppercase">Started</th>
            <th class="text-uppercase">Completed</th>
            <th class="text-uppercase">< 30</th>
            <th class="text-uppercase">< 60</th>
            <th class="text-uppercase">+ 60</th>
            <th class="text-uppercase">SOS</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($service_by_franchise_list as $value) {
        ?>
        <tr>        
            <td><?= $value['category_name']; ?></td>
            <td><?= $value['totals']; ?></td>
            <td><?= $value['new']; ?></td>
            <td><?= $value['started']; ?></td>
            <td><?= $value['completed']; ?></td>
            <td><?= $value['less_than_30']; ?></td>
            <td><?= $value['less_than_60']; ?></td>
            <td><?= $value['more_than_60']; ?></td>
            <td><?= $value['sos']; ?></td>
        </tr>
        <?php 
            }
        ?>
    </tbody>
</table>
    </div>
    <div class="col-md-2">
            <h4 class="text-center">Category</h4>
            <?php 
                foreach ($reports as $key => $value) {
                    $data = array_column($service_by_franchise_list,'totals');        
            ?>
            <div class="service-category-donut-<?= $key ?> text-center" data-size="100" id="service_category_donut_<?= $key ?>" data-json="service_category_data_<?= $key ?>"></div>
            
            <script>
                var service_category_data_<?= $key ?> = [
                    {'section_label': 'Incorporation ', 'value': <?= $data[0]; ?>, 'color': '#FFB046'}, 
                    {'section_label': 'Accounting Services ', 'value': <?= $data[1]; ?>, 'color': '#06a0d6'}, 
                    {'section_label': 'Tax Services', 'value': <?= $data[2]; ?>, 'color': '#ff8c1a'},
                    {'section_label': 'Business Services', 'value':<?= $data[3]; ?>, 'color': '#009900'},
                    {'section_label': 'Partner Services', 'value':<?= $data[4]; ?>, 'color': '#663300'},
                ];                    
            </script>
            <script>
                 pieChart('service-category-donut-<?= $key ?>');
            </script>
            <?php
                 }
            ?>
            <h4 class="text-center">Tracking</h4>
            <?php 
                foreach ($reports as $key => $value) {
                    $new = array_sum(array_column($service_by_franchise_list,'new'));
                    $started = array_sum(array_column($service_by_franchise_list,'started')); 
                    $completed = array_sum(array_column($service_by_franchise_list,'completed'));          
            ?>
            <div class="category-tracking-donut-<?= $key ?> text-center" data-size="100" id="category_tracking_donut_<?= $key ?>" data-json="category_tracking_data_<?= $key ?>"></div>
            
            <script>
                var category_tracking_data_<?= $key ?> = [
                    {'section_label': 'New ', 'value': <?= $new; ?>, 'color': '#1c84c6'}, 
                    {'section_label': 'Started ', 'value': <?= $started; ?>, 'color': '#f8ac59'}, 
                    {'section_label': 'Completed', 'value': <?= $completed; ?>, 'color': '#1ab394'},
                ];                    
            </script>
            <script>
                 pieChart('category-tracking-donut-<?= $key ?>');
            </script>
            <?php
                 }
            ?>
    </div>
</div>
<?php
    }
?>
