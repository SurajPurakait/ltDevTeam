<?php
    // echo "<pre>";
    // load_ddl_option("existing_client_list",$edit_data['company_name']);
    // print_r($edit_data);
    // print_r($service_info);
    // print_r($ov_price);
    // print_r($extra_services);
    // ddl_option("company_type_list");
    // exit;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_firpta" onsubmit="request_create_firpta(); return false;">
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Your Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" disabled="" name="staff_office" id="staff_office" title="Office" required="">
                                    <?php 
                                        load_ddl_option("staff_office_list", $staff_info['office'], "staff_office");                            
                                    ?>      
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <h3>Business Information</h3><span class="company-data"></span>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Existing Client<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="" class="form-control type_of_client" name="type_of_client" id="type_of_client_ddl" onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" title="Type Of Client" required>
                                    <option value="0" <?= ($edit_data['new_existing'] == 0) ? 'selected' : ''; ?>>Yes</option>
                                    <option value="1" <?= ($edit_data['new_existing'] == 1) ? 'selected' : ''; ?>>No</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="" class="form-control client_list client_type_field0" name="client_list" id="client_list_ddl" title="Client List" onchange="fetchExistingClientData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("existing_client_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group client_type_div1" id="name_of_business">
                            <label class="col-lg-2 control-label">Name of Business<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Business Name" id="business_name" class="form-control client_type_field1" type="text" name="name_of_company" title="Name of Business" value="<?= $edit_data['company_name']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group display_div" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="state" id="state" title="State of Incorporation" required="" onchange="select_other_state(this.value);">
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
                                <select class="form-control value_field required_field disabled_field" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Month & Year to Start</label>
                            <div class="col-lg-10">
                                <input placeholder="mm/yyyy" id="month" class="form-control datepicker_my value_field" type="text" title="Month & Year to Start" name="start_year" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group display_div" id="fiscal_year_end_div">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="fiscal_year_end" id="fye" title="Fiscal year end" required="">
                                    <?php load_ddl_option("fiscal_year_end"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Federal ID</label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" class="form-control value_field" id="fein" type="text" name="fein" value="" title="Federal ID">
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
                            <label class="col-lg-2 control-label">Business Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control value_field" name="business_description" id="business_description" title="Business Description"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        
                        <h3>Property Address</h3><span class="company-data"></span>
                        <div class="form-group" id="prop_address_div">
                            <label class="col-lg-2 control-label">Address<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control value_field" name="property_address" id="property_address" title="Property Address" required=""></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="prop_city_div">
                            <label class="col-lg-2 control-label">City<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="CITY" id="property_city" class="form-control" type="text" name="property_city" title="CITY" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="prop_state_div">
                            <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="STATE" id="property_state" class="form-control" type="text" name="property_state" title="STATE" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="prop_zip_div">
                            <label class="col-lg-2 control-label">ZIP<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="ZIP" id="property_zip" class="form-control" type="text" name="property_zip" title="ZIP" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="closing_date_div">
                            <label class="col-lg-2 control-label">Closing Date<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="dd/mm/yyyy"  class="form-control datepicker_mdy" type="text" title="Closing Date" name="closing_date" id="closing_date" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="buyer_info_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Buyer(s) Info<span class="text-danger">*</span><span>&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="buyer_info_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Buyer Info</a>)</span></h3>
                            <div id="buyer_information">
                                <input type="hidden" name="buyer_info" id="buyer_info" value="" required title="Buyer Info">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div id="seller_info_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Seller(s) Info<span class="text-danger">*</span><span>&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="seller_info_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Seller Info</a>)</span></h3>
                            <div id="seller_information">
                                <input type="hidden" name="seller_info" id="seller_info" value="" required title="seller Info">
                                <div class="errorMessage text-danger"></div>
                            </div>
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
                                    <input placeholder="" class="form-control value_field" type="text" name="existing_practice_id" id="existing_practice_id" title="Existing Practice ID" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input id="retail_price" readonly="" placeholder="" class="form-control" type="text" title="Retail Price" value="<?= $shareholders_service_info['retail_price']; ?>">
                                <input name="retail_price" type="hidden" value="<?= $shareholders_service_info['retail_price']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" numeric_valid="" title="Retail Price" value="<?= $edit_data['price_charged']; ?>">
                                <div class="errorMessage text-danger"></div>        
                            </div>
                        </div>
                        <?= service_note_func('Note', 'n', 'service', $edit_data['id'], $service_id); ?>
                        <div class="hr-line-dashed"></div>

                        <div id="documents_div">
                            <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', '<?= $reference ?>', ''); return false;" href="javascript:void(0);">Add document</a>)</h3> 
                            <div id="document-list"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <h3>Confirmation</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirm<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="checkbox" name="confirmation" title="Confirmation" id="confirmation" value="" required>
                                I confirm to be aware that the information added above is correct.
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="new_reference_id" id="new_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url(); ?>">
                                <input type="hidden" name="editval" id="editval" value="<?= $edit_data['id']; ?>">
                                <button class="btn btn-success" type="button" onclick="request_create_firpta();">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="go('services/home');">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="buyer_info_modal_div" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="seller_info_modal_div" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;">

<script>

    clientTypeChange(<?= $edit_data['new_existing']; ?>, <?= $reference_id; ?>, '<?= $reference; ?>', 1);
    
    $(function () {
        var client_type = $('#type_of_client_ddl').val();
        if (client_type == '0') {
            fetchExistingClientData('<?= $reference_id; ?>', <?= $reference_id; ?>, '<?= $reference; ?>', 1);
            $('.display_div').hide();
            get_document_list('<?= $company_id; ?>', 'company');
            annual_date('<?= $reference_id; ?>');
            setIdVal('client_list_ddl', '<?= $reference_id; ?>');
        } else {
            get_contact_list('<?= $company_id; ?>', 'company');
            reload_owner_list('<?= $company_id; ?>', 'main');
            get_document_list('<?= $company_id; ?>', 'company');            
            getInternalData('<?= $reference_id; ?>', 'company');
            setIdVal('state', '<?= $edit_data['state_opened']; ?>');
            setIdVal('type', '<?= $edit_data['company_type']; ?>');
            setIdVal('business_description', '<?= urlencode($edit_data['business_description']); ?>');
            setIdVal('fye', '<?= $edit_data['fiscal_year_end']; ?>');
            setIdVal('business_name', '<?= $edit_data['company_name']; ?>');
            setIdVal('dba', '<?= $edit_data['dba']; ?>');
            setIdVal('retail_price_override', '<?= $edit_data['price_charged']; ?>');
            setIdVal('fein', '<?= $edit_data['fein']; ?>');
            
        }
        setIdVal('property_city', '<?= $extra_data['property_city']; ?>');
        setIdVal('property_state', '<?= $extra_data['property_state']; ?>');
        setIdVal('property_zip', '<?= $extra_data['property_zip']; ?>');
        setIdVal('closing_date', '<?= $extra_data['closing_date']; ?>');
        setIdVal('property_address', '<?= $extra_data['property_address']; ?>');
        get_firpta_buyer_list('<?= $edit_data['id']; ?>');
        get_firpta_seller_list('<?= $edit_data['id']; ?>');
    });
</script>