<div class="wrapper wrapper-content">
    <div class="row">
    	<?php
    		foreach ($recurrence_pattern_data as $rpd) {
    	?>
		<div class="col-md-12 m-t-20">
			<input type="hidden" id="recurrence_invoice_id" value="<?= $rpd['invoice_id']; ?>">
			<!-- main div -->
			<div aria-expanded="false" class="r_monthly" data-toggle="tooltip" data-placement="top" onclick="show_recurrence_clients('<?= $rpd['invoice_id']; ?>','<?= $rpd['service_name']; ?>','<?= $rpd['pattern']; ?>')">
				<table class="table text-white m-b-0" style="background: #263949">
					<thead>
	                    <tr>                        
	                        <th class="text-center">Plan</th>
	                        <th class="text-center">Recurrence</th>
	                        <th class="text-center"># Of Clients</th>
	                        <th class="text-center">Total Of Invoices</th>
	                        <th class="text-center">Total Billed</th>
	                        <th class="text-center">Total Unpaid</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<tr>
	                    	<td class="text-center"><?= $rpd['service_name']; ?></td>
	                    	<td class="text-center"><?= $rpd['pattern']; ?></td>
	                    	<td class="text-center"><?= $rpd['no_of_clients']; ?></td>
	                    	<td class="text-center"><?= $rpd['no_of_invoices']; ?></td>
	                    	<td class="text-center"><?= $rpd['total_billed']; ?></td>
	                    	<td class="text-center"><?= (int)$rpd['total_billed']-(int)$rpd['amount_collected']; ?></td>
	                    </tr>
	                </tbody>
				</table>
			</div>
			<!-- inner div -->
			<div id="collapse-recurring-<?= $rpd['invoice_id']; ?>" class="panel-collapse collapse" aria-expanded="false" style="display: none;">
				<div class="row m-t-15 m-b-15">
		            <div class="col-md-4" id="ofc-multiselect-div">
		                <select name="ofc[]" id="ofc" class="form-control chosen-select ofc" data-placeholder="Select Office">
		                    <!-- <option value="0">Select Office</option> -->
		                    <?php
		                    load_ddl_option("staff_office_list", "", "");
		                    ?>
		                </select>                        
		            </div>
		            <div class="col-md-3">
		                <select name="client[]" id="client" class="form-control chosen-select client" data-placeholder="Select Client">
		                	<!-- <option value="0">Select Client</option> -->
		                	<?php
		                		$client_list = get_client_list_on_recurrence_pattern($rpd['service_name'],$rpd['pattern']);
		                		foreach ($client_list as $cl) {
		                	?>
		                		<option value="<?= $cl['client_id']; ?>"><?= $cl['client_id']; ?></option>
		                	<?php
		                		}
		                	?>
		                </select>		 
		            </div>
		            <div class="col-md-2">
		            	<button type="button" class="btn btn-success" id="btn" style="margin: 0px 0px 0px 5px;border: 0px;border-radius: 0px;" onclick="show_recurrence_clients('<?= $rpd['invoice_id']; ?>','<?= $rpd['service_name']; ?>','<?= $rpd['pattern']; ?>','filter')">Apply</button>
		            </div>
		        </div>
				<div id="clients-recurring-data<?= $rpd['invoice_id']; ?>">
					
				</div>
			</div> <!-- inner div end -->
		</div>
		<?php
			}
		?> 
	</div>
</div>    	