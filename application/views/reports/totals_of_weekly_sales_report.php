<table class="table table-bordered table-striped">
    <tr>
		<th rowspan="2" style="padding:25px;">Total</th>
        <th>Total Price</th>
        <th>Total Cost</th>
		<th>Total Collected</th>
		<th>Total Net</th>
		<th>Total Franchisee Fee</th>
		<th>Total Gross Profit</th>
    </tr>
    <tr>
        <td><?= "$".$sales_total_data['override_price'] ;?></td>           	
        <td><?= "$".$sales_total_data['cost'] ;?></td>           	
        <td><?= "$".$sales_total_data['collected'] ;?></td>           	
        <td><?= "$".$sales_total_data['total_net'] ;?></td>           	
        <td><?= "$".$sales_total_data['franchisee_fee'] ;?></td>           	
        <td><?= "$".$sales_total_data['gross_profit'] ;?></td>           	
    </tr>
</table>