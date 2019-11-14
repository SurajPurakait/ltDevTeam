<?php
    // echo "<pre>";
    // print_r($royalty_reports_data);exit;
?>
<div class="">
<table id="report-tab" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Client Id</th>
            <th>Invoice Id</th>
            <th>Service Id</th>
            <th>Service Name</th>
            <th>Retail Price</th>
            <th>Override Price</th>
            <th>Cost</th>
            <th>Payment Status</th>
            <th>Collected</th>
            <th>Payment Type</th>
            <th>Authorization Id</th>
            <th>Reference</th>
            <th>Total Net</th>
            <th>Office Fee %</th>
            <th>Fee With Cost</th>
            <th>Fee Without Cost</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php 
            if(count($royalty_reports_data) > 0) { 
                foreach ($royalty_reports_data as $rpd) { 
                for($i=1; $i <= $rpd['services']; $i++) {
                    if ($rpd['payment_status'] == 1) {
                        $payment_status = 'Unpaid';
                    } elseif ($rpd['payment_status'] == 2) {
                        $payment_status = 'Partial';
                    } elseif ($rpd['payment_status'] == 3) {
                        $payment_status = 'Paid';
                    } else {
                        $payment_status = 'Late';
                    }
                    $service_detail = get_service_by_id(explode(',',$rpd['all_services'])[$i]);
                    ?>
                    <tr>
                        <td><?= date('m/d/Y', strtotime($rpd['created_time'])); ?></td> <!-- Date -->
                        <td><?= $rpd['client_id']; ?></td> <!-- Client Id -->
                        <td><?= $rpd['invoice_id'];?></td> <!-- Invoice Id -->
                        <td><?= $rpd['invoice_id']."-".$i; ?></td> <!-- Service Id -->     
                        <td><?= $service_detail['description']; ?></td> <!-- Service Name -->
                        <td><?= $service_detail['retail_price']; ?></td> <!-- Retail Price -->
                        <td><?= explode(',',$rpd['all_services_override'])[$i]; ?></td> <!-- Override Price -->
                        <td><?= "demo"; ?></td> <!-- Cost -->
                        <td><?= $payment_status; ?></td> <!-- Payment Status -->
                        <td><?= "demo"; ?></td> <!-- Collected -->
                        <td><?= "demo"; ?></td> <!-- Payment Type -->
                        <td><?= "demo"; ?></td> <!-- Authorization Id -->
                        <td><?= "demo"; ?></td> <!-- Reference -->
                        <td><?= "demo"; ?></td> <!-- Total Net -->
                        <td><?= "demo"; ?></td> <!-- Office Fee % -->
                        <td><?= "demo"; ?></td> <!-- Fee With Cost -->
                        <td><?= "demo"; ?></td> <!-- Fee Without  Cost -->
                    </tr>
                    <?php
                    }
                }
            } else {
                echo '<tr><th colspan="6">No Data Found</th></tr>';
            }
        ?>
    </tbody>
</table>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        if ($('#report-tab').length > 0) {
            $("#report-tab").dataTable();
        }
    });
</script>