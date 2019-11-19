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
                    $service_detail = get_service_by_id(explode(',',$rpd['all_services'])[$i]);
                    $office_fees = get_office_fees_by_service(explode(',',$rpd['all_services'])[$i],$rpd['office_id']);
                    $payment_history = get_payment_details_service_id($rpd['invoice_id'],explode(',',$rpd['all_orders'])[$i]);
                    $reference = implode(',',array_column($payment_history,'reference'));
                    $authorization_id = implode(',',array_column($payment_history,'authorization_id'));
                    $payment_type = implode(',',array_column($payment_history,'payment_type'));
                    $collected = array_sum(array_column($payment_history,'collected'));    
                    $total_net = (explode(',',$rpd['all_services_override'])[$i] != '') ? explode(',',$rpd['all_services_override'])[$i] - $service_detail['cost'] : $service_detail['retail_price'] - $service_detail['cost'];
                    $override_price = explode(',',$rpd['all_services_override'])[$i];
                    $date = date('m/d/Y', strtotime($rpd['created_time']));
                    $fee_with_cost = (($total_net * $office_fees)/100);                    
                    $fee_without_cost = (($override_price * $office_fees)/100);
                    if (($override_price - $collected) == 0) {
                        $payment_status = 'Paid';
                    } elseif (($override_price - $collected) == $override_price) {
                        $payment_status = 'Unpaid';
                    } elseif (($override_price - $collected) > 0 && ($override_price - $collected) < $override_price) {
                        $payment_status = 'Partial';
                    } else {
                        $payment_status = 'Late';
                    }

                    ?>
                    <tr>
                        <td title="Date"><?= $date; ?></td>
                        <td title="Client Id"><?= $rpd['practice_id']; ?></td>
                        <td title="Invoice Id"><?= $rpd['invoice_id']; ?></td>
                        <td title="Service Id"><?= $rpd['invoice_id']."-".$i; ?></td>
                        <td title="Service Name"><?= $service_detail['description']; ?></td>
                        <td title="Retail Price"><?= $service_detail['retail_price']; ?></td>
                        <td title="Override Price"><?= $override_price; ?></td>
                        <td title="Cost"><?= $service_detail['cost']; ?></td>
                        <td title="Payment Status"><?= $payment_status; ?></td>
                        <td title="Collected"><?= $collected.".00"; ?></td>
                        <td title="Payment Type"><?= ($payment_type != '') ? $payment_type:"N/A"; ?></td>
                        <td title="Authorization Id"><?= ($authorization_id != '') ? $authorization_id: "N/A"; ?></td>
                        <td title="Reference"><?= ($reference != '') ? $reference:"N/A"; ?></td>
                        <td title="Total Net"><?= $total_net.'.00'; ?></td>
                        <td title="Office Fee"><?= ($office_fees != '') ? $office_fees : '00.00'; ?></td>
                        <td title="Fee With Cost"><?= $fee_with_cost.'.00'; ?></td>
                        <td title="Fee Without Cost"><?= $fee_without_cost.'.00'; ?></td>
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
