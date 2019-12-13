<?php
    if ($category == 'franchise') {    
?>
<table class="table table-bordered report-table table-striped text-center m-b-0">
    <thead>
        <tr>
            <th>Offices</th>
            <th>Totals</th>
            <th>New</th>
            <th>Started</th>
            <th>Completed</th>
            <th>< 30</th>
            <th>< 60</th>
            <th>+ 60</th>
            <th>SOS</th>
            <th>
                <div class="row">
                    <div class="col-md-6">
                        <div class="franchise_office" width="60"></div>
                        <script type="text/javascript">
                            
                        </script>
                    </div>
                    <div class="col-md-6">
                        <div class="franchise_tracking" width="60"></div>
                    </div>
                </div>
            </th>
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
            <td></td>
        </tr>
        <?php 
            }
        ?>
    </tbody>
</table>
<script type="text/javascript">
    pieChart('franchise_office');
    pieChart('franchise_tracking');
</script>
<?php
    } else if ($category == 'department') { 
?>
<table class="table table-bordered report-table table-striped text-center m-b-0">
    <thead>
        <tr>
            <th>Offices</th>
            <th>Totals</th>
            <th>New</th>
            <th>Started</th>
            <th>Completed</th>
            <th>< 30</th>
            <th>< 60</th>
            <th>+ 60</th>
            <th>SOS</th>
            <th>
                <div class="row">
                    <div class="col-md-6">
                        <div class="department_office" width="60"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="department_tracking" width="60"></div>
                    </div>
                </div>
            </th>
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
            <td></td>
        </tr>
        <?php 
            }
        ?>
    </tbody>
</table>
<script type="text/javascript">
    pieChart('department_office');
    pieChart('department_tracking');
</script>
<?php 
    } else if ($category == 'service_category') {
?>
<table class="table table-bordered report-table table-striped text-center m-b-0">
    <thead>
        <tr>
            <th>Offices</th>
            <th>Totals</th>
            <th>New</th>
            <th>Started</th>
            <th>Completed</th>
            <th>< 30</th>
            <th>< 60</th>
            <th>+ 60</th>
            <th>SOS</th>
            <th>
                <div class="row">
                    <div class="col-md-6">
                        <div class="category_office" width="60"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="category_tracking" width="60"></div>
                    </div>
                </div>
            </th>
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
            <td></td>
        </tr>
        <?php 
            }
        ?>
    </tbody>
</table>
<script type="text/javascript">
    pieChart('category_office');
    pieChart('category_tracking');    
</script>
<?php
    }
?>
