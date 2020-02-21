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
            <table class="table table-striped p-b-0" style="width:100%;">
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
            		<td><?= '$ '.$mortgages_info['purchase_price']; ?></td>
            	</tr>
            	<tr>
            		<td>What is Property For</td>
            		<td>
						<?= $what_is_property_for; ?>            				
            		</td>
            	</tr>
            	<tr>
            		<td>
            			<span>Realtor</span><br><br>
            			<table class="table m-b-0 m-l-30">
            				<tr>
            					<td>Realtor Name</td>            					            				
            				</tr>
            				<tr>
            					<td>Realtor Email</td>
            				</tr>
            				<tr>
            					<td>Realtor Phone</td>
            				</tr>
            			</table>
            			
            			
            			
            		</td>
            		<td>
            			<?= ($mortgages_info['realtor'] == '1') ? 'Yes' : 'No'; ?><br><br>
            			<table class="table table-hover m-b-0">
            				<tr>
            					<td>
            						<?= ($mortgages_info['realtor_name'] == '') ? 'N/A':$mortgages_info['realtor_name'];?>            						
            					</td>            					
            				</tr>
            				<tr>
            					<td>
            						<?= ($mortgages_info['realtor_email'] == '') ? 'N/A':$mortgages_info['realtor_email']; ?>            						
            					</td>
            				</tr>
            				<tr>
								<td>
            						<?= ($mortgages_info['realtor_phone'] == '') ? 'N/A':$mortgages_info['realtor_phone']; ?>            						
            					</td>            					
            				</tr>
            			</table>            			
            		</td>
            	</tr>            					
            </table>
        </div>    	
	</div>
</div>	    	