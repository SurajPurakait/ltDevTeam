<div class="wrapper wrapper-content">
    <div class="row">
		<div class="col-md-12 m-t-20">
			<div id="r_monthly" aria-expanded="false" class="r_monthly" data-toggle="tooltip" data-placement="top">
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
	                    	<td class="text-center">Bookeeping</td>
	                    	<td class="text-center">Monthly</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                </tbody>
				</table>
			</div>
			<div id="collapse_monthly" class="panel-collapse collapse" aria-expanded="false" style="display: none;">
				<div class="row m-t-15 m-b-15">
		            <div class="col-md-4" id="ofc-multiselect-div">
		                <select name="ofc[]" id="ofc" class="form-control chosen-select ofc" data-placeholder="Select Office">
		                    <?php
		                    load_ddl_option("staff_office_list", "", "");
		                    ?>
		                </select>                        
		            </div>
		            <div class="col-md-3">
		                <select name="client[]" id="client" class="form-control chosen-select client" data-placeholder="Select Client">
		                	<option value="1">ABCDEFGHIJK</option>
		                	<option value="2">HTAKEFGHIJK</option>
		                	<option value="3">KOPOEFGHIJK</option>
		                	<option value="4">SAKLOFGHIJK</option>
		                	<option value="5">KOLKJFGHIJK</option>
		                	<option value="6">ASGIPFGHIJK</option>
		                </select>		 
		            </div>
		            <div class="col-md-2">
		            	<button type="button" class="btn btn-success" id="btn" style="margin: 0px 0px 0px 5px;border: 0px;border-radius: 0px;">Apply</button>
		            </div>
		        </div>
				<table class="table table-hover">
					<thead>
	                    <tr>                        
	                        <th class="text-center">Client Id</th>
	                        <th class="text-center">Total Invoices</th>
	                        <th class="text-center">Total Billed</th>
	                        <th class="text-center">Total Paid</th>
	                        <th class="text-center">Total Unpaid</th>
	                        <th class="text-center">Date Created</th>
	                        <th class="text-center">Client Manager</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<tr>
	                    	<td class="text-center">ABCDEFGHIJK</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                    <tr>
	                    	<td class="text-center">MNOPQRSTUVW</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                    <tr>
	                    	<td class="text-center">PQRSTVBJKOL</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                    <tr>
	                    	<td class="text-center">VBJSALKOTY</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                </tbody>
				</table>
			</div>
		</div>

		<div class="col-md-12 m-t-20">
			<div id="r_quarterly" aria-expanded="false" class="r_quarterly" data-toggle="tooltip" data-placement="top">
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
	                    	<td class="text-center">Bookeeping</td>
	                    	<td class="text-center">Quarterly</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                </tbody>
				</table>
			</div>
			<div id="collapse_quarterly" class="panel-collapse collapse" aria-expanded="false" style="display: none;">
				<div class="row m-t-15 m-b-15">
		            <div class="col-md-4" id="ofc-multiselect-div">
		                <select name="ofc[]" id="ofc" class="form-control chosen-select ofc" data-placeholder="Select Office">
		                    <?php
		                    load_ddl_option("staff_office_list", "", "");
		                    ?>
		                </select>                        
		            </div>
		            <div class="col-md-3">
		                <select name="client[]" id="client" class="form-control chosen-select client" data-placeholder="Select Client">
		                	<option value="1">ABCDEFGHIJK</option>
		                	<option value="2">HTAKEFGHIJK</option>
		                	<option value="3">KOPOEFGHIJK</option>
		                	<option value="4">SAKLOFGHIJK</option>
		                	<option value="5">KOLKJFGHIJK</option>
		                	<option value="6">ASGIPFGHIJK</option>
		                </select>		 
		            </div>
		            <div class="col-md-2">
		            	<button type="button" class="btn btn-success" id="btn" style="margin: 0px 0px 0px 5px;border: 0px;border-radius: 0px;">Apply</button>
		            </div>
		        </div>
				<table class="table table-hover">
					<thead>
	                    <tr>                        
	                        <th class="text-center">Client Id</th>
	                        <th class="text-center">Total Invoices</th>
	                        <th class="text-center">Total Billed</th>
	                        <th class="text-center">Total Paid</th>
	                        <th class="text-center">Total Unpaid</th>
	                        <th class="text-center">Date Created</th>
	                        <th class="text-center">Client Manager</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<tr>
	                    	<td class="text-center">ABCDEFGHIJK</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                    <tr>
	                    	<td class="text-center">MNOPQRSTUVW</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                    <tr>
	                    	<td class="text-center">PQRSTVBJKOL</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                    <tr>
	                    	<td class="text-center">VBJSALKOTY</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                </tbody>
				</table>
			</div>
		</div>


		<div class="col-md-12 m-t-20">
			<div id="r_yearly" aria-expanded="false" class="r_yearly" data-toggle="tooltip" data-placement="top">
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
	                    	<td class="text-center">Bookeeping</td>
	                    	<td class="text-center">Yearly</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                </tbody>
				</table>
			</div>
			<div id="collapse_yearly" class="panel-collapse collapse" aria-expanded="false" style="display: none;">
				<div class="row m-t-15 m-b-15">
		            <div class="col-md-4" id="ofc-multiselect-div">
		                <select name="ofc[]" id="ofc" class="form-control chosen-select ofc" data-placeholder="Select Office">
		                    <?php
		                    load_ddl_option("staff_office_list", "", "");
		                    ?>
		                </select>                        
		            </div>
		            <div class="col-md-3">
		                <select name="client[]" id="client" class="form-control chosen-select client" data-placeholder="Select Client">
		                	<option value="1">ABCDEFGHIJK</option>
		                	<option value="2">HTAKEFGHIJK</option>
		                	<option value="3">KOPOEFGHIJK</option>
		                	<option value="4">SAKLOFGHIJK</option>
		                	<option value="5">KOLKJFGHIJK</option>
		                	<option value="6">ASGIPFGHIJK</option>
		                </select>		 
		            </div>
		            <div class="col-md-2">
		            	<button type="button" class="btn btn-success" id="btn" style="margin: 0px 0px 0px 5px;border: 0px;border-radius: 0px;">Apply</button>
		            </div>
		        </div>
				<table class="table table-hover">
					<thead>
	                    <tr>                        
	                        <th class="text-center">Client Id</th>
	                        <th class="text-center">Total Invoices</th>
	                        <th class="text-center">Total Billed</th>
	                        <th class="text-center">Total Paid</th>
	                        <th class="text-center">Total Unpaid</th>
	                        <th class="text-center">Date Created</th>
	                        <th class="text-center">Client Manager</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<tr>
	                    	<td class="text-center">ABCDEFGHIJK</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                    <tr>
	                    	<td class="text-center">MNOPQRSTUVW</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                    <tr>
	                    	<td class="text-center">PQRSTVBJKOL</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                    <tr>
	                    	<td class="text-center">VBJSALKOTY</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    	<td class="text-center">----</td>
	                    </tr>
	                </tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$('.r_monthly').click(function(){
			$("#collapse_monthly").slideToggle();
		});

		$('.r_quarterly').click(function(){
			$("#collapse_quarterly").slideToggle();
		});

		$('.r_yearly').click(function(){
			$("#collapse_yearly").slideToggle();
		});
	});
</script>    	