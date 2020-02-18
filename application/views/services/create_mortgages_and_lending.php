<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
            	<form class="form-horizontal" method="post" id="create_mortgages_and_lending">
            		<div class="ibox-content">            			
            			<div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">Client Type<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
            					<select class="form-control" name="client_type" id="client_type" title="Client Type" required="" onchange="partnerServiceAjax(this.value,<?= $reference_id; ?>);">
                                    <option value="1">Business Client</option>
                                    <option value="2">Individual</option>
                                </select>
            				</div>	
            			</div>
            			<div class="hr-line-dashed"></div>
            			<div id="partner_service_container">
                            <!-- Add multiple service categories inside this div using ajax -->
                        </div>
                        
                        <div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">Assigned To<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
            					<select class="form-control" id="assigned_to" required="">
            						<option value="">Select Partner</option>
                                    <?php
            							foreach ($all_partners_list as $apl) {
            						?>
            						<option value="<?= $apl['id']; ?>"><?= $apl['first_name'].' '.$apl['last_name']; ?></option>
            						<?php
            							}
            						?>
            					</select>            					
            				</div>
            			</div>
            			<div class="hr-line-dashed"></div>
                        <h3>Mortgages And Lending</h3>
            			<div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">Status<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
                                            <select class="form-control" id="status" name="status" required="">
            						<option value="1">Foreign</option>
            						<option value="2">Domestic</option>	
            					</select>            					
            				</div>
            			</div>

            			<div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">Type of Mortgage<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
                                            <select class="form-control" id="typeofmortgage" name="typeofmortgage" required="">
            						<?php
            							foreach ($mortgages_list as $val) {				
            						?>
            						<option value="<?= $val['id']; ?>"><?= $val['name']; ?></option>	
            						<?php
            							}
            						?>
            					</select>            					
            				</div>
            			</div>

            			<div class="form-group">
                            <label class="col-lg-2 control-label">Purchase Price of Property<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" class="form-control" id="purchase_price" type="text" name="purchase_price" value="" title="Purchase Price of Property">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">What is Property Intended For ?<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
                                            <select class="form-control" id="whatispropertyfor" name="whatispropertyfor" required="">
            						<option value="1">Primary Residence</option>
            						<option value="2">Vacation or Secondary Home</option>	
            						<option value="3">Investment Property</option>	
            					</select>            					
            				</div>
            			</div>
						
						<div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">Realtor<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
                                            <select class="form-control" id="realtor" required="" name="realtor" onchange="changeRelator(this.value)">
            						<option value="1">Yes</option>
            						<option value="2" selected>No</option>		
            					</select>            					
            				</div>
            			</div>
            			<div style="display: none;" id="realtor_div">
							<div class="form-group">
	                            <label class="col-lg-2 control-label">Name</label>
	                            <div class="col-lg-10">
	                                <input placeholder="Realtor Name" class="form-control" id="realtorname" type="text" name="realtorname" value="" title="Realtor Name">
	                                <div class="errorMessage text-danger"></div>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-lg-2 control-label">Email</label>
	                            <div class="col-lg-10">
	                                <input placeholder="Realtor Email" class="form-control" id="realtoremail" type="text" name="realtoremail" value="" title="Realtor Email">
	                                <div class="errorMessage text-danger"></div>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-lg-2 control-label">Phone Number</label>
	                            <div class="col-lg-10">
	                                <input placeholder="Realtor Phone Number" class="form-control" id="realtorphone" type="text" name="realtorphone" value="" title="Realtor Phone Number">
	                                <div class="errorMessage text-danger"></div>
	                            </div>
	                        </div>            				
            			</div><br>
            			<div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">                                
                                <input type="hidden" id="reference_id" name="reference_id" value="<?= (isset($reference_id)) ? $reference_id : ''; ?>"> 
                            	<input type="hidden" name="client_id" id="client_id" value="<?= (isset($client_id)) ? $client_id : ''; ?>">
                            	<button class="btn btn-success" type="button" onclick="saveMortgages()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button">Cancel</button>
                            </div>
                        </div>                			
            		</div>	
            	</form>	
            </div>
        </div>
    </div>
</div>
<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script type="text/javascript">
	partnerServiceAjax(1, <?= $reference_id; ?>);
	function changeRelator(value) {
		if (value == 1) {
			$("#realtor_div").show();
		} else {
			$("#realtor_div").hide();
		}
	}
</script>            	