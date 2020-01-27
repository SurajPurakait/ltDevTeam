<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_1099_write_up" onsubmit="request_create_1099_write_up(); return false;">
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
                                            } 
                                        ?>      
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <h3>Business Information</h3><span class="company-data"></span>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Existing Client<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type_of_client" name="type_of_client" id="type_of_client_ddl" onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" title="Type Of Client" required>
                                    <option value="0">Yes</option>
                                    <option selected="selected" value="1">No</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div0">
                            <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control chosen-select client_type_field0" name="client_office" id="client_office" onchange="refresh_existing_client_list(this.value, '');" title="Office" required="">
                                    <option value="">Select Office</option>
                                    <?php load_ddl_option("staff_office_list",'', (staff_info()['type'] != 1) ? "client_office" : ""); ?>
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
                            <label class="col-lg-2 control-label">Name of Business<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Business Name" id="business_name" class="form-control client_type_field1" type="text" name="name_of_company" title="Name of Business" >
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group display_div" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="state" id="state" title="State of Incorporation" required="" onchange="select_other_state(this.value);">
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
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end", 12); ?>
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
                                <textarea class="form-control value_field" name="business_description"  title="Business Description"></textarea>
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
                            <div class="form-group" style="display: none;">
                                <label class="col-lg-2 control-label">Existing Practice ID</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" name="existing_practice_id" id="existing_practice_id" title="Existing Practice ID" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Practice ID</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" name="practice_id" id="practice_id" title="Practice ID" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div id="documents_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>'); return false;" href="javascript:void(0);">Add document</a>)</h3> 
                            <div id="document-list"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <h3>Payer's Information : <span class="text-danger">*</span></h3>

                        <div class="link-content m-b-10">
                                <input type="hidden" id="payer_information_quantity" value="0">
                                <button class="btn btn-success btn-xs" id="copy-contact" ref_id="<?= $reference_id; ?>">&nbsp;<i class="fa fa-copy"></i>&nbsp;Copy Main Contact</button>&nbsp;
                        </div>

                        <div id="payer_information_div">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="First Name" class="form-control" type="text" id="payer_first_name" name="payer_first_name" title="First Name" value="" required="">
                                    <div class="errorMessage text-danger"></div>        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Last Name" class="form-control" type="text" id="payer_last_name" name="payer_last_name" title="Last Name" value="" required="">
                                    <div class="errorMessage text-danger"></div>        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Phone Number<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Phone Number" phoneval class="form-control" type="text" id="payer_phone_number" name="payer_phone_number" title="Phone Number" value="" required="">
                                    <div class="errorMessage text-danger"></div>        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Address<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Address" class="form-control" type="text" id="payer_address" name="payer_address" title="Address" value="" required="">
                                    <div class="errorMessage text-danger"></div>        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">City<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="City" class="form-control" type="text" id="payer_city" name="payer_city" title="City" value="" required="">
                                    <div class="errorMessage text-danger"></div>        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select title="State" class="form-control" name="payer_state" id="payer_state" required="">
                                            <option value="">Select an option</option>
                                            <?php load_ddl_option("all_state_list"); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Country<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select title="Country" class="form-control" name="payer_country" id="payer_country" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("get_countries"); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Zip<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Zip Code" class="form-control" type="text" id="payer_zip_code" name="payer_zip_code" title="Zip Code" zipval value="" required="">
                                    <div class="errorMessage text-danger"></div>        
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">TIN (Tax Identification Number)<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="TIN" class="form-control" type="text" id="payer_tin" name="payer_tin" title="TIN" value="" required="">
                                <div class="errorMessage text-danger"></div>        
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div> 

                        <input type="hidden" title="Recipient List" id="recipient_id_list" name="recipient_id_list" value="">

                        <div id="recipient_info_div">
                            <h3>Recipient(s)&nbsp; (<a href="javascript:void(0);" class="recipientadd" onclick="recipient_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>','','<?= $service_info['retail_price']; ?>'); return false;">Add Recipient</a>)</span></h3>
                            <div id="recipient-list">
                                <!-- <input type="hidden" title="Contact Info" id="contact-list-count" value="">
                                <div class="errorMessage text-danger"></div> -->
                            </div>
                        </div>
                        
                        <div class="hr-line-dashed"></div>

                        <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input name="retail_price" id="retail_price" readonly="" placeholder="" class="form-control" type="text" title="Retail Price" value="<?= $service_info['retail_price']; ?>">
                                <!-- <input name="retail_price" type="hidden" value="<?//= $service_info['retail_price']; ?>"> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" numeric_valid="" title="Retail Price" value="">
                                <div class="errorMessage text-danger"></div>        
                            </div>
                        </div>
                        <?= service_note_func('Note', 'n', 'service', "", $service_id); ?>

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
                                <input type="hidden" name="editval" id="editval" value="">
                                <button class="btn btn-success" type="button" onclick="request_create_1099_write_up();">Save changes</button> &nbsp;&nbsp;&nbsp;
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
<div id="recipient-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="accounts-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script>
    clientTypeChange(1, <?= $reference_id; ?>, '<?= $reference; ?>', 1);
    $(function () {
    $("#copy-contact").click(function () {
            $("#payer_first_name").val('');
            $("#payer_last_name").val('');
            $("#payer_phone_number").val('');
            $("#payer_address").val('');
            $("#payer_city").val('');
            $("#payer_state").val('');
            $("#payer_country").val('');
            $("#payer_zip_code").val('');
            var ref_id = $('#reference_id').val();
            $.ajax({
                type: "POST",
                                url: '<?= base_url(); ?>services/accounting_services/copy_contact_for_1099_write_up',
                                data: {ref_id: ref_id}, 
                                cache: false,
                                success: function (data) {
                    //alert(data);
                    if (data != 0) {
                        var res = JSON.parse(data);
                        //alert(res);
                        $("#payer_information_quantity").val(1);
                        $("#payer_first_name").val(res.first_name);
                        $("#payer_last_name").val(res.last_name);
                        $("#payer_phone_number").val(res.phone1);
                        $("#payer_address").val(res.address1);
                        $("#payer_city").val(res.city);
                        $("#payer_state").val(res.state);
                        $("#payer_country").val(res.country);
                        $("#payer_zip_code").val(res.zip);
                        $("#payer_information_div").show();
                    } else {
                        swal("Error", "No Main Contact Added", "error");
                    }
                }
            });
        });
    });   //document.ready end
</script>