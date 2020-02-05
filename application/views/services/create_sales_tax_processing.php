<?php $staff_info = staff_info(); ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_sales_tax_processing" onsubmit="request_create_salestax_processing(); return false;">
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Your Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="staff_office" id="staff_office" title="Office" required="">
                                    <option value="">Select Office</option>
                                        <?php if (strpos($staff_info['office'], ',') !== false) {
                                                load_ddl_option("users_office_list", "", "staff_office");
                                            }else{
                                                load_ddl_option("users_office_list", $staff_info['office'], "staff_office");
                                            } ?>
                                    
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <h3>Business Information</h3><span class="company-data"></span>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Existing Client<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type_of_client" name="type_of_client" id="type_of_client_ddl" onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" title="Type Of Client" required>
                                    <option value="">Select an option</option>
                                    <option value="0">Yes</option>
                                    <option selected value="1">No</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control client_list client_type_field0" name="client_list" id="client_list_ddl" title="Client List" onchange="fetchExistingClientData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);">
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div1" id="name_of_business">
                            <label class="col-lg-2 control-label">Name of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Company Name" id="name_of_company" class="form-control client_type_field1" type="text" name="name_of_company" title="Name of Company">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="istate" id="state" title="State of Incorporation" required="" onchange="select_other_state(this.value);">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="state_other" style="display:none;">
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="text" name="state_other" class="form-control" >
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                                               
                        <div class="form-group display_div" id="type_div">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Start Date<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="dd/mm/yyyy" id="month" class="form-control datepicker_mdy value_field required_field" type="text" title="Start Date" name="start_year" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="fiscal_year_end_div">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type-of-company value_field required_field" name="fye" id="fye" title="Fiscal year end" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end", 12); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Federal ID<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" class="form-control required_field" id="fein" type="text" name="fein" value="" title="Federal ID">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="form-group display_div" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="dba" title="DBA">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="business_description_div">
                            <label class="col-lg-2 control-label">Business Description<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control value_field required_field" name="business_description" id="business_description" title="Business Description"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Contact Phone Number</label>
                            <div class="col-lg-10">
                                <input placeholder="" numeric_valid="" id="contact_phone_no" class="form-control" type="text" name="contact_phone_no" title="Contact Phone Number" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="documents_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>'); return false;" href="javascript:void(0);">Add document</a>)</h3> 
                            <div id="document-list"></div>
                        </div>

                        <div id="contact_info_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Contact Info<span class="text-danger">*</span><span class="display_div">&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Contact</a>)</span></h3>
                            <div id="contact-list">
                                <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="owners_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Owners<span class="text-danger">*</span> &nbsp; (<a href="javascript:void(0);" class="owneradd" onclick="open_owner_popup(1, '<?= $reference_id; ?>', 0); return false;">Add owner</a>)</h3>
                            <div id="owners-list">
                                <input type="hidden" class="required_field" title="Owners" id="owners-list-count" required="required" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        
                        <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="<?php echo $service['retail_price']?>" id="retail-price">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="<?php echo $service['retail_price']?>">
                                <input type="hidden" id="retail-price-initialamt" value="0" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" numeric_valid="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" title="Retail Price" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                         <?= service_note_func('Sales Tax Note', 'n','company'); ?>  
                        
                        <div class="hr-line-dashed"></div>
                        
                        
                        <div class="hr-line-dashed"></div>
                        <div id="internal_data_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Internal Data</h3><span class="internal-data"></span>
                            <div class="form-group office-internal">
                                <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("staff_office_list"); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                   <select name="partner" id="partner" class="form-control value_field required_field" title="Partner" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="manager" class="form-control value_field required_field" id="manager" title="Manager" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Client Association</label>
                                <div class="col-lg-10">
                                   <input placeholder="" class="form-control value_field" type="text" id="client_association" name="client_association" title="Client Association" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("referer_by_source"); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" id="referred_by_name" name="referred_by_name" title="Referred By Name" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" id="language" name="language" title="Language" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("language_list"); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Existing Practice ID</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" name="existing_practice_id" title="Existing Practice ID" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ibox-content">
                            <div id="sales_tax_input_form_div" class="display_div">
                                <h3>Sales Tax Input Form</h3><span class=""></span>
                                <div class="form-group">
                                    <label id="referred-label" class="col-lg-2 control-label">Sales Tax Number #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="" class="form-control required_field" type="text" id="sales_tax_number" name="sales_tax_number" title="Sales Tax Number" value="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="referred-label" class="col-lg-2 control-label">Business Partner Number #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="" class="form-control required_field" type="text" id="business_partner_number" name="business_partner_number" title="Business Partner Number" value="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group display_div">
                                    <label class="col-lg-2 control-label">Sales Tax Business Description<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control value_field required_field" name="sales_tax_business_description" id="sales_tax_business_description" title="Sales Tax Business Description"></textarea>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="referred-label" class="col-lg-2 control-label">Bank Account Number #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="" class="form-control required_field" type="text" id="bank_account_number" name="bank_account_number" title="Bank Account Number" value="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="referred-label" class="col-lg-2 control-label">Bank Routing Number #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="" class="form-control required_field" type="text" id="bank_routing_number" name="bank_routing_number" title="Bank Routing Number" value="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Frequency Of Salestax<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control frequeny_of_bookkeeping"  name="frequeny_of_salestax" id="frequency_of_salestax" title="Frequency Of salestex" required="">
                                            <option value="">Select</option>
                                            <option value="m">Monthly</option>
                                            <option value="q">Quarterly</option>
                                            <option value="y">Yearly</option>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div id="frequency_of_salestax_month" style="display:none">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Months<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select class="form-control frequeny_of_bookkeeping" id="months" name="frequency_of_salestax_month"  title="Frequency Of salestex" >
                                                <?php 
                                                    $i=0;
                                                    $months=['Select','January','Febuary','March','April','May','June','July','August','September','October','November','December'];
                                                    for($i=0;$i<=12;$i++) {
                                                ?>   
                                                <option value="<?php echo $months[$i];?>"><?php echo $months[$i];?></option>
                                                <?php  
                                                    } 
                                                ?>
                                            </select>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select class="form-control" id="year1" name="frequency_of_salestax_years1"  title="Year" >
                                                <?php
                                                    $i=0;
                                                    $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                                    for($i=0;$i<=5;$i++) { 
                                                ?>
                                                <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
                                                <?php  
                                                    } 
                                                ?>
                                            </select>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="frequency_of_salestax_querter" style="display:none">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Quarter<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select class="form-control frequeny_of_bookkeeping" id="quarter" name="frequency_of_salestax_quarter"  title="Frequency Of salestex" >
                                                <?php 
                                                    $i=0;
                                                    $querter=['Select','Quarter 1','Quarter 2','Quarter 3','Quarter 4'];
                                                    for($i=0;$i<=4;$i++) {
                                                ?>
                                                <option value="<?php echo $querter[$i];?>"><?php echo $querter[$i];?></option>
                                                <?php  
                                                    } 
                                                ?>
                                            </select>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select class="form-control" id="year2" name="frequency_of_salestax_years2"  title="Year" >
                                            <?php
                                                $i=0;
                                                $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                                for($i=0;$i<=5;$i++) { 
                                            ?>
                                            <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
                                            <?php  
                                                } 
                                            ?>
                                            </select>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="frequency_of_salestax_years" style="display:none">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select class="form-control frequeny_of_bookkeeping" id="year" name="frequency_of_salestax_years"  title="Year" >
                                            <?php
                                                $i=0;
                                                $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                                for($i=0;$i<=5;$i++) { 
                                            ?>
                                            <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
                                            <?php  
                                                } 
                                            ?>
                                            </select>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group state_div">
                                    <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control" onchange="county_ajax(this.value, '');" name="state" id="salesstate" title="State of Recurring" required="">
                                            <option value="">Select an option</option>
                                             <?php
                                            foreach ($state as $data) { ?>
                                                    <option value="<?= $data['id']; ?>"><?= $data['state_name']; ?></option>
                                                    <?php } ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group county_div" id="county_div">
                                    <label class="col-lg-2 control-label">County<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <div id="county"><select class="form-control" name="county" id="county" title="County of Recurring" required="">

                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>        

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="current_reference_id" id="current_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_sales_tax_processing">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_employee" id="quant_employee" value="0">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="">
                                <button class="btn btn-success" type="button" onclick="request_create_salestax_processing()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelRequestCreateSalestaxprocessing()">Cancel</button>
                            </div>
                        </div>
                     </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;">
</div>

<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;">
</div>
<script>
    clientTypeChange(1, <?= $reference_id; ?>, '<?= $reference; ?>', 1);
     
    $(document).ready(function(){
       // $("#months").change(function(){
       //      var month=$("#months").val();
       //     if(month!= 0){
       //          $("#frequency_of_salestax_years").show();
       //     }else{
       //           $("#frequency_of_salestax_years").hide();
       //     }
       // });
      
       // $("#quarter").change(function(){
       //     var quarter=$("#quarter").val();
       //       if(quarter!= 0){
       //          $("#frequency_of_salestax_years").show();
       //     }else{
       //           $("#frequency_of_salestax_years").hide();
       //     }
       // });
       
        $("#frequency_of_salestax").change(function(){       
            var frequency_of_salestax=$("#frequency_of_salestax").val();              
            if(frequency_of_salestax=='m') {
                $("#frequency_of_salestax_month").show();
                $("#months").attr('required', "required");
                $("#year1").attr('required', "required");
                $("#frequency_of_salestax_querter").hide();
                $("#quarter").removeAttr('required').val("");
                $("#year2").removeAttr('required').val("");
                $("#frequency_of_salestax_years").hide();
                $("#year").removeAttr('required').val(""); 
             } else if(frequency_of_salestax=='q') {
                $("#frequency_of_salestax_querter").show();
                $("#quarter").attr('required', "required");
                $("#year2").attr('required', "required");
                $("#frequency_of_salestax_month").hide();
                $("#month").removeAttr('required').val("");
                $("#year1").removeAttr('required').val("");
                $("#frequency_of_salestax_years").hide();
                $("#year").removeAttr('required').val(""); 
             } else {
                $("#frequency_of_salestax_years").show();
                $("#year").attr('required', "required");
                $("#frequency_of_salestax_querter").hide();
                $("#quarter").removeAttr('required').val("");
                $("#year2").removeAttr('required').val("");
                $("#frequency_of_salestax_month").hide();
                $("#months").removeAttr('required').val("");
                $("#year1").removeAttr('required').val("");         
            }      
        });
    });
</script>