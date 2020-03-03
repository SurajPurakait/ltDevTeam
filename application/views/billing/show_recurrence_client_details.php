<table class="table table-hover table-striped">
	<thead>
        <tr>                        
            <th class="text-center">Client Id</th>
            <th class="text-center">Total Invoices</th>
            <th class="text-center">Total Billed</th>
            <th class="text-center">Total Paid</th>
            <th class="text-center">Total Unpaid</th>
            <th class="text-center">Client Manager</th>
        </tr>
    </thead>
    <tbody>
		<?php
			foreach ($recurrence_client_details as $rcd) {
		?>    	
    	<tr>
        	<td class="text-center"><?= $rcd['client_id']; ?></td>
        	<td class="text-center"><?= $rcd['no_of_invoices']; ?></td>
        	<td class="text-center"><?= $rcd['total_billed']; ?></td>
        	<td class="text-center"><?= $rcd['amount_collected']; ?></td>
        	<td class="text-center"><?= (int)$rcd['total_billed'] - (int)$rcd['amount_collected']; ?></td>
        	<td class="text-center"><?= $rcd['manager']; ?></td>
        </tr>
        <?php
			}
		?>
    </tbody>
</table>