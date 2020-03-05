<table class="table table-hover table-striped" style="cursor: pointer;">
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
        if(!empty($recurrence_client_details)) {
			foreach ($recurrence_client_details as $rcd) {
		?>    	
    	<tr onclick="link_to_invoice('<?= $rcd['client_id'] ?>','<?= $pattern ?>')">
        	<td class="text-center"><?= $rcd['client_id']; ?></td>
        	<td class="text-center"><?= $rcd['no_of_invoices']; ?></td>
        	<td class="text-center"><?= $rcd['total_billed']; ?></td>
        	<td class="text-center"><?= $rcd['amount_collected']; ?></td>
        	<td class="text-center"><?= (int)$rcd['total_billed'] - (int)$rcd['amount_collected']; ?></td>
        	<td class="text-center"><?= $rcd['manager']; ?></td>
        </tr>
        <?php
			}
        } else {
        ?>
        <tr>
            <td colspan="6" class="text-center text-danger"><b>Sorry! no data found</b></td>
        </tr>    
        <?php        
            }
		?>
    </tbody>
</table>
<script type="text/javascript">
    function link_to_invoice(client_id,pattern) {
        var encoded_client_id = window.btoa(client_id);
        var encoded_pattern = window.btoa(pattern);
        window.open(
          'http://localhost/leafnet/billing/home/index/'+encoded_client_id+'/0/0/'+encoded_pattern,
          '_blank'
        );
    }
</script>