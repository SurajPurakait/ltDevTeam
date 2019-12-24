<?php 
    if ($category == 'status') {
?>
<div class="row">
    <div class="col-md-10">
        <table class="table table-bordered billing-report-table table-striped text-center m-b-0">
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
</div>
<?php
    }
    if ($category == 'type') {
?>
<div class="row">
    <div class="col-md-10">
        <table class="table table-bordered billing-report-table table-striped text-center m-b-0">
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
</div>        
<?php
    }
    if ($category == 'mail_campaign') {
?>
<div class="row">
    <div class="col-md-10">
        <table class="table table-bordered billing-report-table table-striped text-center m-b-0">
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
</div>
<?php
    }
?>
