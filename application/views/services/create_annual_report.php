<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_annual_report" onsubmit="request_create_annual_report()">
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

                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control client_list client_type_field0" name="client_list" id="client_list_ddl" title="Client List"  onchange="fetchExistingClientData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1); annual_date(this.value);">
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

                        <div class="form-group" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field disabled_field" name="istate" id="state" title="State of Incorporation" required=""  onchange="change_due_date(this.value, document.getElementById('type').value);select_other_state(this.value);">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list_annual_report"); ?>
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
                        

                        <div class="form-group" id="type_div">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field disabled_field" name="type" id="type" title="Type of Company" required="" onchange="change_due_date(document.getElementById('state').value, this.value)">
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
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" class="form-control" id="fein" type="text" name="fein" value="" title="Federal ID">
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

                        <div id="documents_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>');return false;" href="javascript:void(0);">Add document</a>)</h3> 
                            <div id="document-list"></div>
                        </div>

                        <div id="contact_info_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Contact Info<span class="text-danger">*</span><span class="display_div">&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>');return false;">Add Contact</a>)</span></h3>
                            <div id="contact-list">
                                <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="owners_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Owners<span class="text-danger">*</span> &nbsp; (<a href="javascript:void(0);" class="owneradd" onclick="open_owner_popup(1, '<?= $reference_id; ?>', 0);return false;">Add owner</a>)</h3>
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
                            <div class="hr-line-dashed"></div>
                        </div>                        

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Select Service</label>
                            <div class="col-lg-10 related-service-div">
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" name="service_id" id="service_florida" onchange="changeServiceRadio(this.value, '<?= $florida['retail_price']; ?>');" retail_price="<?= $florida['retail_price']; ?>" value="<?= $florida['id']; ?>">
                                    <label for="service_florida"><?= $florida['description']; ?></label>
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" name="service_id" id="service_delaware" onchange="changeServiceRadio(this.value, '<?= $delaware['retail_price']; ?>');" retail_price="<?= $delaware['retail_price']; ?>" value="<?= $delaware['id']; ?>">
                                    <label for="service_delaware"><?= $delaware['description']; ?></label>
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" name="service_id" id="service_arizona" onchange="changeServiceRadio(this.value, '<?= $arizona['retail_price']; ?>');" retail_price="<?= $arizona['retail_price']; ?>" value="<?= $arizona['id']; ?>">
                                    <label for="service_arizona"><?= $arizona['description']; ?></label>
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" name="service_id" id="service_wyoming" onchange="changeServiceRadio(this.value, '<?= $wyoming['retail_price']; ?>');" retail_price="<?= $wyoming['retail_price']; ?>" value="<?= $wyoming['id']; ?>">
                                    <label for="service_wyoming"><?= $wyoming['description']; ?></label>
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" name="service_id" id="service_michigan" onchange="changeServiceRadio(this.value, '<?= $michigan['retail_price']; ?>');" retail_price="<?= $michigan['retail_price']; ?>" value="<?= $michigan['id']; ?>">
                                    <label for="service_michigan"><?= $michigan['description']; ?></label>
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" name="service_id" id="service_texas" onchange="changeServiceRadio(this.value, '<?= $texas['retail_price']; ?>');" retail_price="<?= $texas['retail_price']; ?>" value="<?= $texas['id']; ?>">
                                    <label for="service_texas"><?= $texas['description']; ?></label>
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" name="service_id" id="service_new_jersey" onchange="changeServiceRadio(this.value, '<?= $new_jersey['retail_price']; ?>');" retail_price="<?= $new_jersey['retail_price']; ?>" value="<?= $new_jersey['id']; ?>">
                                    <label for="service_new_jersey"><?= $new_jersey['description']; ?></label>
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" name="service_id" id="service_new_york" onchange="changeServiceRadio(this.value, '<?= $new_york['retail_price']; ?>');" retail_price="<?= $new_york['retail_price']; ?>" value="<?= $new_york['id']; ?>">
                                    <label for="service_new_york"><?= $new_york['description']; ?></label>
                                </label><br>
                                <div class="errorMessage text-danger" id="service_id_error"></div>
                            </div>
                        </div>
                        <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Due Date</label>
                            <div class="col-lg-10">
                                <input placeholder="dd/mm/yyyy" readonly="" class="form-control" type="text" title="Due Date" name="due_date" id="due_date" value="" required>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input readonly="" id="retail_price" name="retail_price" class="form-control" type="text" title="Retail Price">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" numeric_valid="" title="Retail Price">
                                <div class="errorMessage text-danger"></div>        
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Add Related Services</label>
                            <div class="col-lg-10 related-service-div">
                                <select data-placeholder="Select one option" title="Related Services" class="chosen-select get_select_service" name="related_services[]" id="related_services" style="width: 100%;" multiple=""></select>
                            </div>
                        </div>
                        <div id="related_service_container"></div>
                        <div class="hr-line-dashed"></div>

                        <h3>Notes</h3>
                        <?php service_note_func('Order Notes', 'n', 'order'); ?>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="new_reference_id" id="new_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="editval" id="editval" value="">
                                <button class="btn btn-success" type="button" onclick="request_create_annual_report();">Save changes</button> &nbsp;&nbsp;&nbsp;
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
<script>
    clientTypeChange(1, <?= $reference_id; ?>, '<?= $reference; ?>', 3);
    load_service_container(getIdVal('service_id'));
    function changeServiceRadio(serviceID, retailPrice) {
        loadDdlOptionsAjax('get_select_service', '', serviceID);
        setIdVal('service_id', serviceID);
        setIdVal('retail_price', retailPrice);
        setIdHTML('related_service_container', '');
    }
    function change_due_date(state, type) {
        $.ajax({
            type: 'POST',
            url: base_url + 'services/home/change_due_date',
            data: {
                state: state,
                type: type
            },
            success: function (result) {
                if (state == 8) {
                    $('#service_delaware').prop("checked", true);
                    $('#service_florida').prop("checked", false);
//                    $("#service_florida, #service_delaware").prop("disabled", false);
                    changeServiceRadio(getIdVal('service_delaware'), $('#service_delaware').attr('retail_price'));
                } else if (state == 10) {
                    $('#service_florida').prop("checked", true);
                    $('#service_delaware').prop("checked", false);
//                    $("#service_florida, #service_delaware").prop("disabled", false);
                    changeServiceRadio(getIdVal('service_florida'), $('#service_florida').attr('retail_price'));
                }else if (state == 3) {
                    $('#service_arizona').prop("checked", true);
                    $('#service_florida').prop("checked", false);
                    $('#service_delaware').prop("checked", false);
//                    $("#service_florida, #service_delaware").prop("disabled", false);
                    changeServiceRadio(getIdVal('service_arizona'), $('#service_arizona').attr('retail_price'));
                }else if (state == 51) {
                    $('#service_wyoming').prop("checked", true);
                    $('#service_arizona').prop("checked", false);
                    $('#service_florida').prop("checked", false);
                    $('#service_delaware').prop("checked", false);
//                    $("#service_florida, #service_delaware, #service_arizona").prop("disabled", false);
                    changeServiceRadio(getIdVal('service_wyoming'), $('#service_wyoming').attr('retail_price'));
                }else if (state == 23) {
                    $('#service_michigan').prop("checked", true);
                    $('#service_wyoming').prop("checked", false);
                    $('#service_arizona').prop("checked", false);
                    $('#service_florida').prop("checked", false);
                    $('#service_delaware').prop("checked", false);
//                    $("#service_florida, #service_delaware, #service_arizona, #service_wyoming").prop("disabled", false);
                    changeServiceRadio(getIdVal('service_michigan'), $('#service_michigan').attr('retail_price'));
                }else if (state == 44) {
                    $('#service_texas').prop("checked", true);
                    $('#service_michigan').prop("checked", false);
                    $('#service_wyoming').prop("checked", false);
                    $('#service_arizona').prop("checked", false);
                    $('#service_florida').prop("checked", false);
                    $('#service_delaware').prop("checked", false);
//                    $("#service_florida, #service_delaware, #service_arizona, #service_wyoming, #service_michigan, #service_texas ").prop("disabled", false);
                    changeServiceRadio(getIdVal('service_texas'), $('#service_texas').attr('retail_price'));
                }else if (state == 31) {
                    $('#service_new_jersey').prop("checked", true);
                    $('#service_texas').prop("checked", false);
                    $('#service_michigan').prop("checked", false);
                    $('#service_wyoming').prop("checked", false);
                    $('#service_arizona').prop("checked", false);
                    $('#service_florida').prop("checked", false);
                    $('#service_delaware').prop("checked", false);
//                    $("#service_florida, #service_delaware, #service_arizona, #service_wyoming, service_michigan, #service_texas,  ").prop("disabled", false);
                    changeServiceRadio(getIdVal('service_new_jersey'), $('#service_new_jersey').attr('retail_price'));
                }else if (state == 33) {
                    $('#service_new_york').prop("checked", true);
                    $('#service_new_jersey').prop("checked", false);
                    $('#service_texas').prop("checked", false);
                    $('#service_michigan').prop("checked", false);
                    $('#service_wyoming').prop("checked", false);
                    $('#service_arizona').prop("checked", false);
                    $('#service_florida').prop("checked", false);
                    $('#service_delaware').prop("checked", false);
//                    $("#service_florida, #service_delaware, #service_arizona, #service_wyoming, service_michigan, #service_texas,  ").prop("disabled", false);
                    changeServiceRadio(getIdVal('service_new_york'), $('#service_new_york').attr('retail_price'));
                } else {
                    $("#service_florida, #service_delaware, #service_arizona, #service_wyoming, #service_michigan, #service_texas, #service_new_jersey, #service_new_york ").prop("disabled", false);
                }
                $('#due_date').val(result);
            }
        });
    }
</script>