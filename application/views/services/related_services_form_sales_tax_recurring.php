<?php if(isset($state)){$state_id = $state->id;} ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="related_create_sales_tax_recurring" onsubmit="related_create_sales_tax_recurring(); return false;">
                        <div class="form-group" id="tax_id">
                            <label class="col-lg-2 control-label">Sales Tax Id<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                               <input type="text" class="form-control" name="sales_tax_id" id="sales_tax_id" title="Sales Tax Id" required="" value="<?php echo isset($recurring_data->sales_tax_id) ? $recurring_data->sales_tax_id : ''; ?>">
                               <div class="errorMessage text-danger"></div>
                            </div>
                                
                           
                        </div>
                        <div class="form-group" id="password">
                            <label class="col-lg-2 control-label">Password<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="password" id="sales_password" title="Sales Tax Password" required="" value="<?php echo isset($recurring_data->password) ? $recurring_data->password : ''; ?>">
                                <div class="errorMessage text-danger"></div>    
                            </div>
                                
                           
                        </div>
                        <div class="form-group" id="website">
                            <label class="col-lg-2 control-label">Website<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                               <input type="text" class="form-control" title="Website" id="sales_website" name="website" required="" value="<?php echo isset($recurring_data->website) ? $recurring_data->website : ''; ?>">
                                <div class="errorMessage text-danger"></div>  
                            </div>
                               
                            
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                         
                         <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="100" id="retail-price">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="100">
                                <input type="hidden" id="retail-price-initialamt" value="0" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" numeric_valid="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" title="Retail Price" value="<?php echo isset($override_price['price_charged']) ? $override_price['price_charged'] : ''; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                         <div class="form-group">
                            <label class="col-lg-2 control-label">Frequency Of Salestax<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control frequeny_of_bookkeeping" name="frequeny_of_salestax" id="frequeny_of_salesteax" title="Frequency Of salestex" required="">
                                    <option value="">Select</option>
                                    <?php if(isset($recurring_data->freq_of_salestax)){ ?>
                                    <option value="m" <?= ($recurring_data->freq_of_salestax == 'm') ? 'Selected' : '' ?>>Monthly</option>
                                    <option value="q" <?= ($recurring_data->freq_of_salestax == 'q') ? 'Selected' : '' ?>>Quarterly</option>
                                    <option value="y" <?= ($recurring_data->freq_of_salestax == 'y') ? 'Selected' : '' ?>>Yearly</option>
                                <?php } else { ?>
                                    <option value="m">Monthly</option>
                                    <option value="q">Quarterly</option>
                                    <option value="y">Yearly</option>
                                <?php } ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="form-group state_div">
                            <label class="col-lg-2 control-label">State of Recurring<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" onchange="county_ajax(this.value, '');" name="state" id="salesstate" title="State of Recurring" required="">
                                    <option value="">Select an option</option>
                                     <?php
                                    foreach ($state_list as $st) {
                                            if(isset($state_id)){
                                            ?>
                                            <option value="<?= $st['id']?>" <?php echo ($state_id == $st['id']) ? 'selected' : ''; ?>><?= $st['state_name']; ?></option>
                                            <?php
                                           }else{ ?>
                                            <option value="<?= $st['id']; ?>"><?= $st['state_name']; ?></option>
                                    <?php   }
                                        
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group county_div" id="county_div">
                            <label class="col-lg-2 control-label">County of Recurring<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <div id="county"><select class="form-control" name="county" id="county" title="County of Recurring" required="">

                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    <div class="hr-line-dashed"></div>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="new_reference_id" id="new_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_sales_tax_recurring">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="">
                                <input type="hidden" name="order_id" id="order_id" value="<?= $order_id; ?>">
                                <button class="btn btn-success" type="button" onclick="related_create_sales_tax_recurring('related_create_sales_tax_recurring')">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelRelatedServiceForm('related_create_sales_tax_recurring')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    <?php if(isset($state_id)){ ?>
    county_ajax(<?= $state_id;?>, <?= $recurring_data->county; ?>);
    <?php } ?>
</script>



