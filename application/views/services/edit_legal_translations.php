<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_legal_translations" onsubmit="request_create_legal_translations(); return false;">
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Your Office</label>
                            <div class="col-lg-10">
                                <select class="form-control" disabled="" name="staff_office" id="staff_office" title="Office">
                                    <?php load_ddl_option("staff_office_list", $edit_data['staff_office'], "staff_office"); ?>
                                </select>
                                
                            </div>
                        </div>
                        <h3>Business Information</h3><span class="company-data"></span>
                        <div class="form-group" id="existing-check-div">
                            <label class="col-lg-2 control-label">Existing Client</label>
                            <div class="col-lg-10">
                                <select disabled="" class="form-control type_of_client" name="type_of_client" id="type_of_client_ddl" onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" title="Type Of Client">
                                    <option value="0" <?= ($edit_data['new_existing'] == 0) ? 'selected' : ''; ?>>Yes</option>
                                    <option value="1" <?= ($edit_data['new_existing'] == 1) ? 'selected' : ''; ?>>No</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List</label>
                            <div class="col-lg-10">
                                <select disabled="" class="form-control client_list client_type_field0" name="client_list" id="client_list_ddl" title="Client List" onchange="fetchExistingClientData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("existing_client_list", $reference_id); ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group client_type_div1" id="name_of_business">
                            <label class="col-lg-2 control-label">Name of Business</label>
                            <div class="col-lg-10">
                                <input placeholder="Business Name" id="business_name" class="form-control client_type_field1" type="text" name="name_of_company" title="Name of Business" >
                               
                            </div>
                        </div>
                        <div class="form-group display_div" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation</label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="state" id="state" title="State of Incorporation">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list", '', 'FL'); ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group display_div" id="type_div">
                            <label class="col-lg-2 control-label">Type of Company</label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="type" id="type" title="Type of Company">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list"); ?>
                                </select>
                               
                            </div>
                        </div>
                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Month & Year to Start</label>
                            <div class="col-lg-10">
                                <input placeholder="mm/yyyy" class="form-control datepicker_my value_field" type="text" title="Month & Year to Start" id="start_month_year" name="start_year" value="">
                               
                            </div>
                        </div>
                        <div class="form-group display_div" id="fiscal_year_end_div">
                            <label class="col-lg-2 control-label">Fiscal Year End</label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="fiscal_year_end" id="fye" title="Fiscal year end">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end", 12); ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Federal ID</label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" class="form-control value_field" id="fein" type="text" name="fein" value="" title="Federal ID">
                               
                            </div>
                        </div>
                        <div class="form-group display_div" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="dba" title="DBA">
                              
                            </div>
                        </div>
                        <div class="form-group display_div" id="business_description_div">
                            <label class="col-lg-2 control-label">Business Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control value_field" name="business_description" id="business_description" title="Business Description"></textarea>
                                
                            </div>
                        </div>
                        <div id="contact_info_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Contact Info<span class="display_div">&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Contact</a>)</span></h3>
                            <div id="contact-list">
                                <input type="hidden" title="Contact Info" id="contact-list-count" value="">
                                
                            </div>
                        </div>
                        <div id="owners_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Owners &nbsp; (<a href="javascript:void(0);" class="owneradd" onclick="open_owner_popup(1, '<?= $reference_id; ?>', 0); return false;">Add owner</a>)</h3>
                            <div id="owners-list">
                                <input type="hidden" class="required_field" title="Owners" id="owners-list-count" value="">
                                
                            </div>
                        </div>
                        <div id="internal_data_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Internal Data</h3><span class="internal-data"></span>
                            <div class="form-group office-internal">
                                <label class="col-lg-2 control-label">Office</label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("staff_office_list"); ?>
                                    </select>
                                                                        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Partner</label>
                                <div class="col-lg-10">
                                    <select name="partner" id="partner" class="form-control value_field required_field" title="Partner" >
                                        <option value="">Select an option</option>
                                    </select>
                                  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Manager</label>
                                <div class="col-lg-10">
                                    <select name="manager" class="form-control value_field required_field" id="manager" title="Manager" >
                                        <option value="">Select an option</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Client Association</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" id="client_association" name="client_association" title="Client Association" value="">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Referred By Source</label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("referer_by_source"); ?>
                                    </select>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" id="referred_by_name" name="referred_by_name" title="Referred By Name" value="">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Language</label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" id="language" name="language" title="Language" >
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("language_list"); ?>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Existing Practice ID</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" name="existing_practice_id" id="existing_practice_id" title="Existing Practice ID" value="">
                                 
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <h3>Language</h3>
                        <!-- <div class="form-group">
                            <label class="col-lg-2 control-label">Default Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" id="language_dif" name="language_dif" title="Language" required="">
                                        <option value="">Select an option</option>
                                        <?php //load_ddl_option("language_list"); ?>
                                    </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div> -->
                         <div class="form-group">
                            <label class="col-lg-2 control-label">Translation To</label>
                            <div class="col-lg-10">
                                <!-- <?php 
                                    
                                
                                    //for ($i=0; $i < count($lang_data); $i++) { 
                                         //load_ddl_option("language_list_multiple_select",$lang_data[$i]); 
                                    //}
                                ?> -->
                                <select class="form-control" id="language_new" name="language_new[]" title="Language"  multiple>
                                        <option value="">Select an option</option>
                                        <?php
                                        $lang_data = explode(",",$order_extra_data['translation_to']);
                            
                                        load_ddl_option("language_list_multiple_select",$lang_data); ?>     
                                    </select>

                                <!-- <div class="errorMessage text-danger"></div> -->
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input readonly="" placeholder=""  id="employee-retail-price" class="form-control" type="text" title="Retail Price" value="<?= $edit_data['retail_price']; ?>" name="retail_price">
                                <!-- <input id="retail_price" name="related_service[<?//= $edit_data['id']; ?>][<?= $service_id; ?>][retail_price]" type="hidden" value="<?//= $edit_data['retail_price']; ?>"> -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Amount Of Pages</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="pages" id="pages" onchange="change_price(<?= $edit_data['retail_price']; ?>,this.value);">
                                    <!-- <option value="1" selected>1</option> -->
                                    <?php for($i=1; $i<=10; $i++){
                                        // print_r($order_extra_data['amount_of_pages']);exit;
                                        echo "<option value=".$i.($i == $order_extra_data['amount_of_pages']? ' selected':'').">".$i."</option>";
                                    }
                                      ?> 
                                    <!--<option name=""> </option>-->   
                                       </select> 
                                <!-- <div class="errorMessage text-danger"></div>         -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                               <!--  <input placeholder="" class="form-control" type="text" id="retail_price_override" name="related_service[<?//= $edit_data['id']; ?>][<?= $service_id; ?>][override_price]" numeric_valid="" title="Override Price" value="<?//= $edit_data['total_of_order']; ?>"> -->
                               <input placeholder="" class="form-control" type="text" id="retail_price_override" name="related_service[<?= $edit_data['id']; ?>][<?= $service_id; ?>][override_price]" numeric_valid="" title="Override Price" value="<?= $edit_data['price_charged']; ?>">
                                <!-- <div class="errorMessage text-danger"></div>         -->
                            </div>
                        </div>

                        <?= service_note_func('Note', 'n', 'service', $edit_data['id'], $service_id); ?>
                        <div class="hr-line-dashed"></div>

                        <div id="documents_div">
                            <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', '<?= $reference ?>', ''); return false;" href="javascript:void(0);">Add document</a>)</h3> 
                            <div id="document-list"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                             <h3>Translation Files</h3>
                            <label class="col-lg-2 control-label">Attach Files</label>
                            <div class="col-lg-10">
                                 <input class="form-control" type="file" name="doc_file" id="doc_file" title="Attach Files" value="<?php $order_extra_data['attach_files']; ?>">

                                 <?php if ($order_extra_data['attach_files'] != '') {
                                    ?>
                                <a href="<?= base_url() . "uploads/" . $order_extra_data['attach_files']; ?>" target="_blank"><?= $order_extra_data['attach_files']; ?></a>
                                <?php }
                                ?>

                            </div>
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
                                <button class="btn btn-success" type="button" onclick="request_create_legal_translations();">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="go('services/home');">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="accounts-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script>
    clientTypeChange('<?= $edit_data['new_existing']; ?>', '<?= $reference_id; ?>', '<?= $reference; ?>', 1);

    change_price('<?= $edit_data['retail_price']; ?>','<?= $order_extra_data['amount_of_pages']?>');

  //   function change_referred_name_status(val)
  // {
  //   var a = (25*val);
  //   if(a != 0){
  //    document.getElementById("retail_price").value = a;
  //   }

  // }
    $(function () {
        var client_type = $('#type_of_client_ddl').val();
        if (client_type == '0') {
            fetchExistingClientData('<?= $reference_id; ?>', <?= $reference_id; ?>, '<?= $reference; ?>', 1);
            get_document_list('<?= $company_id; ?>', 'company');
            $('.display_div').hide();
        } else {
            get_contact_list('<?= $company_id; ?>', 'company');
            reload_owner_list('<?= $company_id; ?>', 'main');
            getInternalData('<?= $reference_id; ?>', 'company');
            setIdVal('state', '<?= $edit_data['state_opened']; ?>');
            setIdVal('type', '<?= $edit_data['company_type']; ?>');
            setIdVal('business_description', '<?= urlencode($edit_data['business_description']); ?>');
            setIdVal('fye', '<?= $edit_data['fiscal_year_end']; ?>');
            setIdVal('business_name', '<?= $edit_data['company_name']; ?>');
            setIdVal('dba', '<?= $edit_data['dba']; ?>');
            setIdVal('fein', '<?= $edit_data['fein']; ?>');
            setIdVal('start_month_year', "<?= $edit_data['start_month_year']; ?>");
        }
    });
</script>