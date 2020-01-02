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
            
    </div>
</div>
<?php
    }
?>
