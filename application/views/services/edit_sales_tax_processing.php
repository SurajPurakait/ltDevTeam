<?php

$service_id = $recurring_data->service_id;

$reference = 'company';
$reference_id = $edit_data['reference_id'];
$state_id=$state->id;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <?= service_request_invoice_link($edit_data['id']); ?>
                <form class="form-horizontal" method="post" id="form_create_sales_tax_processing" >
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Your Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" disabled="" name="staff_office" id="staff_office" title="Office" required="">
                                    <?php load_ddl_option("staff_office_list", $edit_data['staff_office'], "staff_office"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <h3>Business Information</h3><span class="company-data"></span>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Existing Client<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="disabled" class="form-control type_of_client type-of-company disabled_field" name="type_of_client" id="type_of_client" onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" title="Type Of Client" required>
                                    <option value="">Select an option</option>
                                    <option value="0" <?= ($recurring_data->type_of_client == 0) ? 'selected' : ''; ?>>Yes</option>
                                    <option value="1" <?= ($recurring_data->type_of_client == 1) ? 'selected' : ''; ?>>No</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="disabled" class="form-control client_type_field0 disabled_field" name="client_list" title="Client List" <?= $recurring_data->new_existing != 0 ? "required=''" : ""; ?>>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("existing_client_list", $recurring_data->new_existing); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div1" id="name_of_company_div">
                            <label class="col-lg-2 control-label">Name of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Company Name" id="name_of_company" class="form-control client_type_field1 required_field" type="text" name="name_of_company" title="Name of Company" value="<?= $company_data['name']; ?>" <?= $recurring_data->new_existing == 0 ? "required=''" : ""; ?>>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control required_field" name="istate" id="istate" title="State of Incorporation" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list", $company_data['state_opened']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="state_other" <?php echo ($other_state == "")? "style='display:none'":"" ;?>>
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="text" name="state_other" class="form-control" value="<?= $other_state; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                                               
                        <div class="form-group display_div" id="type_div">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type-of-company required_field" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list", $company_data['type']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Start Date<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="dd/mm/yyyy" id="month" class="form-control datepicker_mdy value_field required_field" type="text" title="Start Date" name="start_year" value="<?= $recurring_data->start_year; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="fiscal_year_end_div">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type-of-company required_field" name="fye" id="fye" title="Fiscal year end" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end", $company_data['fye']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Federal ID<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" id="fein" class="form-control required_field" type="text" name="fein" value="<?= $company_data['fein']; ?>" title="FEIN" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group display_div" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="dba" title="DBA" value="<?php echo $company_data['dba'];?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="business_description_div">
                            <label class="col-lg-2 control-label">Business Description<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control required_field" name="business_description" id="business_description" title="Business Description"><?= urldecode($company_data['business_description']); ?></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Contact Phone Number</label>
                            <div class="col-lg-10">
                                <input placeholder="" numeric_valid="" id="contact_phone_no" class="form-control" type="text" name="contact_phone_no" title="Contact Phone Number" value="<?php if(isset($recurring_data->contact_phone_no)){ echo $recurring_data->contact_phone_no;} ?>">
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

                         <div class="hr-line-dashed"></div>

                        <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="<?php echo $service['retail_price'];?>" id="retail-price">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="<?php echo $service['retail_price'];?>">
                                <input type="hidden" id="retail-price-initialamt" value="0" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" numeric_valid="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" title="Retail Price" value="<?php echo $edit_data['total_of_order']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                         <?= service_note_func('Sales Tax Note', 'n', 'service', "", 1); ?>  

                        <div class="hr-line-dashed"></div>

                        <div id="internal_data_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Internal Data</h3><span class="internal-data"></span>
                            <div class="form-group office-internal">
                                <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control type-of-company required_field value_field" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("staff_office_list", $inter_data['office']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="partner" id="partner" class="form-control type-of-company required_field value_field" title="Partner" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="manager" class="form-control type-of-company required_field value_field" id="manager" title="Manager" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Client Association</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" id="client_association" value="<?= $inter_data['client_association']; ?>" name="client_association" title="Client Association" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control required_field value_field" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("referer_by_source", $inter_data['referred_by_source']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" id="referred_by_name" name="referred_by_name" title="Referred By Name" value="<?= $inter_data['referred_by_name']; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control required_field value_field" id="language" name="language" title="Language" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("language_list", $inter_data['language']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Existing Practice ID</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="existing_practice_id" title="Existing Practice ID" value="<?= $recurring_data->existing_practice_id; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ibox-content">
                            <div id="sales_tax_input_form_div" class="display_div1">
                                <h3>Sales Tax Input Form</h3><span class=""></span>
                                <div class="form-group">
                                    <label id="referred-label" class="col-lg-2 control-label">Sales Tax Number #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="" class="form-control required_field" type="text" id="sales_tax_number" name="sales_tax_number" title="Sales Tax Number" value="<?= $recurring_data->sales_tax_number ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="referred-label" class="col-lg-2 control-label">Business Partner Number #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="" class="form-control required_field" type="text" id="business_partner_number" name="business_partner_number" title="Business Partner Number" value="<?= $recurring_data->business_partner_number ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
<!--                            <div class="form-group">
                                    <label class="col-lg-2 control-label">Sales Tax Business Description<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control value_field required_field" name="sales_tax_business_description" id="sales_tax_business_description" title="Sales Tax Business Description"><?= $recurring_data->sales_tax_business_description ?></textarea>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sales Tax Business Description<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control required_field" name="sales_tax_business_description" id="sales_tax_business_description" title="Sales Tax Business Description"><?= $recurring_data->sales_tax_business_description ?></textarea>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="referred-label" class="col-lg-2 control-label">Bank Account Number #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="" class="form-control required_field" type="text" id="sales_bank_account_number" name="sales_bank_account_number" title="Bank Account Number" value="<?= $recurring_data->sales_bank_account_number; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="referred-label" class="col-lg-2 control-label">Bank Routing Number #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="" class="form-control required_field" type="text" id="sales_bank_routing_number" name="sales_bank_routing_number" title="Bank Routing Number" value="<?= $recurring_data->sales_bank_routing_number; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Frequency Of Salestax<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control frequeny_of_bookkeeping" name="frequeny_of_salestax" id="frequency_of_salestax" title="Frequency Of Bookkeeping" required>
                                            <option value="">Select</option>
                                            <option value="m" <?= ($recurring_data->frequeny_of_salestax == 'm') ? 'Selected' : '' ?>>Monthly</option>
                                            <option value="q" <?= ($recurring_data->frequeny_of_salestax == 'q') ? 'Selected' : '' ?>>Quarterly</option>
                                            <option value="y" <?= ($recurring_data->frequeny_of_salestax == 'y') ? 'Selected' : '' ?>>Yearly</option>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>


                                <div id="frequency_of_salestax_month" <?= ($recurring_data->frequeny_of_salestax == 'm') ? 'style="display:block;"' : 'style="display:none;"' ?>>
                                  <div class="form-group">
                                    <label class="col-lg-2 control-label">Months<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control frequeny_of_bookkeeping" id="months" name="frequency_of_salestax_month"  title="Frequency Of salestex" <?= ($recurring_data->frequeny_of_salestax == 'm') ? 'required=""' : '' ?>>
        <!--                                    <option value="">Select</option>-->
                                            <?php 
                                        $i=0;
                                        $months=['Select','January','Febuary','March','April','May','June','July','August','September','October','November','December'];
                                        for($i=0;$i<=12;$i++){?>
                                           
                                         <option value="<?php echo $months[$i];?>"<?php if($recurring_data->frequency_of_salestax_val==$months[$i]) { echo " selected" ; }?>><?php echo $months[$i];?></option>
                                            <?php  } ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="year1" name="frequency_of_salestax_years1"  title="Year" <?= ($recurring_data->frequeny_of_salestax == 'm') ? 'required=""' : '' ?>>
                                            <?php
                                            $i=0;
                                            $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                            for($i=0;$i<=5;$i++){ ?>
                                            <option value="<?php echo $year[$i];?>" <?php if($recurring_data->frequency_of_salestax_years==$year[$i]) { echo " selected" ; }?>><?php echo $year[$i];?></option>
                                           <?php  } ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                </div>
                                <div id="frequency_of_salestax_querter" <?= ($recurring_data->frequeny_of_salestax == 'q') ? 'style="display:block;"' : 'style="display:none;"' ?>>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Quarter<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control frequeny_of_bookkeeping" id="quarter" name="frequency_of_salestax_quarter"  title="Frequency Of salestex" <?= ($recurring_data->frequeny_of_salestax == 'q') ? 'required=""' : '' ?>>
                                            
                                            <?php 
                                        $i=0;
                                        $querter=['Select','Querter 1','Querter 2','Querter 3','Querter 4'];
                                        for($i=0;$i<=4;$i++){?>
                                         <option value="<?php echo $querter[$i];?>" <?php if($recurring_data->frequency_of_salestax_val==$querter[$i]) { echo " selected" ; }?>><?php echo $querter[$i];?></option>
                                            <?php  } ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="year2" name="frequency_of_salestax_years2"  title="Year" <?= ($recurring_data->frequeny_of_salestax == 'q') ? 'required=""' : '' ?>>
                                            <?php
                                            $i=0;
                                            $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                            for($i=0;$i<=5;$i++){ ?>
                                            <option value="<?php echo $year[$i];?>" <?php if($recurring_data->frequency_of_salestax_years==$year[$i]) { echo " selected" ; }?>><?php echo $year[$i];?></option>
                                           <?php  } ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                </div>
                                <div id="frequency_of_salestax_years" <?= ($recurring_data->frequeny_of_salestax == 'y') ? 'style="display:block;"' : 'style="display:none;"' ?>>
                                      <div class="form-group">
                                        <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select class="form-control frequeny_of_bookkeeping" id="year" name="frequency_of_salestax_years"  title="Frequency Of salestex" <?= ($recurring_data->frequeny_of_salestax == 'y') ? 'required=""' : '' ?>>
                                                <?php
                                                $i=0;
                                                $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                                for($i=0;$i<=5;$i++){ ?>
                                                <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
                                               <?php  } ?>
                                            </select>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="frequency_of_salestax_years" value="">
                                </div>
                            
                                <div class="form-group state_div">
                                    <label class="col-lg-2 control-label">State of Recurring<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control" onchange="county_ajax(this.value, '');" name="state" id="salesstate" title="State of Recurring" required="">
                                            <option value="">Select an option</option>
                                             <?php
                                            foreach ($state_list as $st) {
                                                ?>
                                                <option value="<?= $st['id']?>" <?php echo ($state_id == $st['id']) ? 'selected' : ''; ?>><?= $st['state_name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group county_div" id="county_div">
                                    <label class="col-lg-2 control-label">County of Recurring<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <div id="county">
                                            <select id="county_ddl" class="form-control" name="county"  title="County of Recurring" required="">

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
                                <input type="hidden" name="editval" id="editval" value="<?php echo $edit_data['id'];?>">
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
       
    county_ajax(<?= $state_id;?>, <?= $recurring_data->county; ?>);        
     
    clientTypeChange(<?= $recurring_data->type_of_client; ?>, <?= $reference_id; ?>, '<?= $reference; ?>', 1);

    // reload_owner_list('<?= $reference_id; ?>', 'payroll');
    // reload_owner_list('<?= $reference_id; ?>', 'payroll2');
    // reload_owner_list('<?= $reference_id; ?>', 'payroll3');
    $(function () {
        // $("textarea#sales_tax_business_description").val(<?= $recurring_data->sales_tax_business_description ?>);

        var client_type = $('#type_of_client').val();
        if (client_type == '0') {
            fetchExistingClientData('<?= $reference_id; ?>', <?= $reference_id; ?>, '<?= $reference; ?>', 1);
            $('.display_div').hide();
        } else {
            get_contact_list('<?php echo $reference_id; ?>', 'company');
            reload_owner_list('<?php echo $reference_id; ?>', 'main');
            get_document_list('<?php echo $reference_id; ?>', 'company');
            getInternalData('<?= $reference_id; ?>', 'company');
        }


        $("#frequency_of_salestax").change(function(){
                
            var frequency_of_salestax=$("#frequency_of_salestax").val();
                  
            if(frequency_of_salestax=='m'){
                 $("#frequency_of_salestax_month").show();
                 $("#months").attr('required', "required");
                 $("#year1").attr('required', "required");
                 $("#frequency_of_salestax_querter").hide();
                 $("#quarter").removeAttr('required').val("");
                 $("#year2").removeAttr('required').val("");
                 $("#frequency_of_salestax_years").hide();
                 $("#year").removeAttr('required').val("");
                 
             }else if(frequency_of_salestax=='q'){
                 $("#frequency_of_salestax_querter").show();
                 $("#quarter").attr('required', "required");
                 $("#year2").attr('required', "required");
                 $("#frequency_of_salestax_month").hide();
                 $("#month").removeAttr('required').val("");
                 $("#year1").removeAttr('required').val("");
                 $("#frequency_of_salestax_years").hide();
                 $("#year").removeAttr('required').val("");
                 
             }else{
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

        $('.rel-serv-license-file').click(function () {
            var textlicense = $(this).prev('.license-file').html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group"  id="license_div' + div_count + '"><label class="col-lg-2 control-label"></label><div class="col-lg-10">' + textlicense + '<a href="javascript:void(0)" onclick="removeLicense(\'license_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove License</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
        $('.rel-serv-note').click(function () {
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"><label class="col-lg-2 control-label">' + note_label + '</label><div class="col-lg-10">' + textnote + '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
        
        $('.add-note-rt6').click(function () {//alert('ff');
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"><label class="col-lg-2 control-label">' + note_label + '</label><div class="col-lg-10">' + textnote + '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });

    });   //document.ready end

    function removeLicense(divID) {
        $("#" + divID).remove();
    }

    </script>