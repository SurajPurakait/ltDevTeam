<?php
// echo '<pre>';
// print_r($recurring_data);die;
//echo $recurring_data->existing_ref_id;die;
//echo $edit_data[0]['id'];exit;
$service_id = $recurring_data->service_id;

$reference = 'company';
$reference_id = $edit_data['reference_id'];
$state_id=$state->id;
//print_r($state);die;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <?= service_request_invoice_link($edit_data['id']); ?>
                <form class="form-horizontal" method="post" id="form_create_sales_tax_recurring" >
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
                                    <option value="0" <?= ($recurring_data->new_existing == 0) ? 'selected' : ''; ?>>Yes</option>
                                    <option value="1" <?= ($recurring_data->new_existing == 1) ? 'selected' : ''; ?>>No</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="disabled" class="form-control client_type_field0 disabled_field" name="client_list" title="Client List" <?= $recurring_data->existing_ref_id != 0 ? "required=''" : ""; ?>>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("existing_client_list", $recurring_data->existing_ref_id); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div1" id="name_of_company_div">
                            <label class="col-lg-2 control-label">Name of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Company Name" id="name_of_company" class="form-control client_type_field1 required_field" type="text" name="name_of_company" title="Name of Company" value="<?= $company_data['name']; ?>" <?= $recurring_data->existing_ref_id == 0 ? "required=''" : ""; ?>>
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
                                <input placeholder="dd/mm/yyyy" id="month" class="form-control datepicker_mdy value_field required_field" type="text" title="Start Date" name="start_year" value="<?= $recurring_data->start_month_year; ?>">
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
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="dba" title="DBA" value="<?php echo $company_data['dba']; ?>">
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
                        
                        <div class="form-group" id="tax_id">
                            <label class="col-lg-2 control-label">Sales Tax Id<span class="text-danger">*</span></label>
                            <div class="col-lg-10">

                                <input type="text" class="form-control" name="sales_tax_id" required="required" value="<?php echo $recurring_data->sales_tax_id; ?>">

                            </div>
                            <div class="errorMessage text-danger"></div>

                        </div>
                        <div class="form-group" id="password">
                            <label class="col-lg-2 control-label">Password<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="password" required="required" value="<?php echo $recurring_data->password; ?>" id="sales_password" title="Sales Tax Password">
                            </div>
                            <div class="errorMessage text-danger"></div>

                        </div>
                        <div class="form-group" id="website">
                            <label class="col-lg-2 control-label">Website<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="website" required="required" value="<?php echo $recurring_data->website; ?>">
                            </div>
                            <div class="errorMessage text-danger"></div>

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
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="100" id="retail-price">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="100">
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

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Frequency Of Salestax<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control frequeny_of_bookkeeping" name="frequeny_of_salestax" id="frequeny_of_bookkeeping" title="Frequency Of Bookkeeping" required>
                                    <option value="">Select</option>
                                    <option value="m" <?= ($recurring_data->freq_of_salestax == 'm') ? 'Selected' : '' ?>>Monthly</option>
                                    <option value="q" <?= ($recurring_data->freq_of_salestax == 'q') ? 'Selected' : '' ?>>Quarterly</option>
                                    <option value="y" <?= ($recurring_data->freq_of_salestax == 'y') ? 'Selected' : '' ?>>Yearly</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group state_div" id="state_div">
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
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Existing Practice ID</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="existing_practice_id" title="Existing Practice ID" value="<?= $recurring_data->existing_practice_id; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="current_reference_id" id="current_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_sales_tax_recurring">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_employee" id="quant_employee" value="0">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="<?php echo $edit_data['id'];?>">
                                <button class="btn btn-success" type="button" onclick="request_create_salestax_recurring()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelRequestCreateSalestaxRecurring()">Cancel</button>
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

<script type="text/javascript">
    county_ajax(<?= $state_id;?>, <?= $recurring_data->county; ?>);        
     
 clientTypeChange(<?= $recurring_data->new_existing; ?>, <?= $reference_id; ?>, '<?= $reference; ?>', 1);
    $(function () {        
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
    });
    
</script>