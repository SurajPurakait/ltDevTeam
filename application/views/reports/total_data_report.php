<table class="table table-bordered m-t-5" id="royalty-total">
    <tr>
        <th rowspan="2" style="padding:25px;font-size: 14px;" class="text-uppercase">Total</th>
        <th class="text-uppercase">Invoices</th>
        <th class="text-uppercase">Retail Price</th>
        <th class="text-uppercase">Override Price</th>
        <th class="text-uppercase">Cost</th>
        <th class="text-uppercase">Collected</th>
        <th class="text-uppercase">Total Net</th>
        <th class="text-uppercase">Fee With Cost</th>
        <th class="text-uppercase">Fee Without Cost</th>
    </tr>
    <tr>
        <td><?= $total_data['invoice_id']; ?></td>
        <td><?= "$" . $total_data['retail_price']; ?></td>
        <td><?= "$" . $total_data['override_price']; ?></td>
        <td><?= "$" . $total_data['cost']; ?></td>
        <td><?= "$" . $total_data['collected']; ?></td>
        <td><?= "$" . $total_data['total_net']; ?></td>
        <td><?= "$" . $total_data['fee_with_cost']; ?></td>
        <td><?= "$" . $total_data['fee_without_cost']; ?></td>           	
    </tr>
</table>