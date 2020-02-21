<?php 
	if ($mortgages_info['what_is_property_for'] == '1') {
		$what_is_property_for = 'Primary Residence'; 
	} elseif ($mortgages_info['what_is_property_for'] == '2') {
		$what_is_property_for = 'Vacation or Secondary Home';
	} elseif ($mortgages_info['what_is_property_for'] == '3') {
		$what_is_property_for = 'Investment Property';
	}
?>
<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md">
		<div class="table-responsive">
			<h3 class="m-b-25">Mortgages And Lending Information</h3>           
            <table class="table table-striped" style="width:100%;">
            	<tr>
            		<td>Mortagage Status</td>
            		<td><?= $mortgages_info['mortgage_status']; ?></td>
            	</tr>
            	<tr>
            		<td>Type of Mortgage</td>
            		<td><?= $mortgages_info['type_of_mortgage_name']; ?></td>
            	</tr>
            	<tr>
            		<td>Purchase Price</td>
            		<td><?= $mortgages_info['purchase_price']; ?></td>
            	</tr>
            	<tr>
            		<td>What is Property For</td>
            		<td>
						<?= $what_is_property_for; ?>            				
            		</td>
            	</tr>
            	<tr>
            		<td>Realtor</td>
            		<td><?= ($mortgages_info['realtor'] == '1') ? 'Yes' : 'No'; ?></td>
            	</tr>
            	<tr>
            		<td>Realtor Name</td>
            		<td><?= ($mortgages_info['realtor_name'] == '') ? 'N/A':$mortgages_info['realtor_name']; ?></td>
            	</tr>
            	<tr>
            		<td>Realtor Email</td>
            		<td><?= ($mortgages_info['realtor_email'] == '') ? 'N/A':$mortgages_info['realtor_email']; ?></td>
            	</tr>
            	<tr>
            		<td>Realtor Phone</td>
            		<td><?= ($mortgages_info['realtor_phone'] == '') ? 'N/A':$mortgages_info['realtor_phone']; ?></td>
            	</tr>
            	
            </table>
        </div>    	
	</div>
</div>	    	