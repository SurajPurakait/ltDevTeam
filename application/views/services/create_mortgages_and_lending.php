<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
            	<form class="form-horizontal" method="post" id="create_mortgages_and_lending">
            		<div class="ibox-content">
            			<h3>Client Information</h3><span class="company-data"></span>
            			<!-- <div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">Client Type<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
            					<select class="form-control" onchange="invoiceContainerAjax(this.value, <?= $reference_id; ?>, '','');" name="client_type" id="client_type" title="Client Type" required="">
                                    <option value="1" <?//= (isset($client_type) && $client_type == '1') ? 'selected' : ''; ?>>Business Client</option>
                                    <option value="2" <?//= (isset($client_type) && $client_type == '2') ? 'selected' : ''; ?>>Individual</option>
                                </select>
            				</div>	
            			</div> -->
            			<div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">Status<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
            					<select class="form-control" id="status" required="">
            						<option value="1">Foreign</option>
            						<option value="2">Domestic</option>	
            					</select>            					
            				</div>
            			</div>

            			<div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">Type of Mortgage<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
            					<select class="form-control" id="typeofmortgage" required="">
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

            			<div class="form-group display_div">
                            <label class="col-lg-2 control-label">Purchase Price of Property<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" class="form-control" id="purchase_price" type="text" name="purchase_price" value="" title="Purchase Price of Property">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">What is Property Intended For ?<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
            					<select class="form-control" id="whatisproperty" required="">
            						<option value="1">Primary Residence</option>
            						<option value="2">Vacation or Secondary Home</option>	
            						<option value="3">Investment Property</option>	
            					</select>            					
            				</div>
            			</div>
						
						<div class="form-group">
            				<label class="col-lg-2 control-label" style="font: 24px;">Realtor<span class="text-danger">*</span></label>
            				<div class="col-lg-10">
            					<select class="form-control" id="realtor" required="">
            						<option value="1">Yes</option>
            						<option value="2">No</option>		
            					</select>            					
            				</div>
            			</div>
            			<div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                            	<button class="btn btn-success" type="button">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button">Cancel</button>
                            </div>
                        </div>                			
            		</div>	
            	</form>	
            </div>
        </div>
    </div>
</div>            	