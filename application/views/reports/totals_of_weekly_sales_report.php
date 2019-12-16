<table class="table table-bordered table-striped" id="weekly-sales-total">
    <tr>
        <th rowspan="2" style="padding:25px;font-size: 14px;" class="text-uppercase">Total</th>
        <th class="text-uppercase">Total Price</th>
        <th class="text-uppercase">Total Cost</th>
        <th class="text-uppercase">Total Collected</th>
        <th class="text-uppercase">Total Net</th>
        <th class="text-uppercase">Total Franchisee Fee</th>
        <th class="text-uppercase">Total Gross Profit</th>
    </tr>
    <tr>
        <td><?= "$" . $sales_total_data['override_price']; ?></td>           	
        <td><?= "$" . $sales_total_data['cost']; ?></td>           	
        <td><?= "$" . $sales_total_data['collected']; ?></td>           	
        <td><?= "$" . $sales_total_data['total_net']; ?></td>           	
        <td><?= "$" . $sales_total_data['franchisee_fee']; ?></td>           	
        <td><?= "$" . $sales_total_data['gross_profit']; ?></td>           	
    </tr>
</table>