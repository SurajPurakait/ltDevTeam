<table class="table table-bordered table-striped">
    <tr>
	<th rowspan="2" style="padding:25px;">Total</th>
        <th>Invoices</th>
        <th>Retail Price</th>
		<th>Override Price</th>
		<th>Cost</th>
		<th>Collected</th>
		<th>Total Net</th>
		<th>Fee With Cost</th>
		<th>Fee Without Cost</th>
     </tr>
     <tr>
        <td><?= $total_data['invoice_id']; ?></td>
		<td><?= "$".$total_data['retail_price']; ?></td>
		<td><?= "$".$total_data['override_price']; ?></td>
		<td><?= "$".$total_data['cost']; ?></td>
		<td><?= "$".$total_data['collected']; ?></td>
		<td><?= "$".$total_data['total_net']; ?></td>
		<td><?= "$".$total_data['fee_with_cost']; ?></td>
		<td><?= "$".$total_data['fee_without_cost']; ?></td>           	
     </tr>
</table>