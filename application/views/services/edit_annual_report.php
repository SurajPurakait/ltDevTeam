<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_annual_report" onsubmit="request_create_annual_report(); return false;">
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Your Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" disabled="" name="staff_office" id="staff_office" title="Office" required="">
                                <?php 
                                    load_ddl_option("staff_office_list", $edit_data['staff_office'], "staff_office");
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
                                <select disabled="" class="form-control client_list client_type_field0" name="client_list" id="client_list_ddl" title="Client List" onchange="fetchExistingClientData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);annual_date(this.value);">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("existing_client_list", $reference_id); ?>
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
                        <div class="form-group" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field disabled_field" name="state" id="state" title="State of Incorporation" required="" onchange="select_other_state(this.value);">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list"); ?>
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
                        <div class="form-group" id="type_div">
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
                                <input placeholder="mm/yyyy" class="form-control datepicker_my value_field" type="text" title="Month & Year to Start" id="start_month_year" name="start_year" value="">
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
                                <textarea class="form-control value_field" name="business_description" id="business_description" title="Business Description"></textarea>
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
                        <div id="documents_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>'); return false;" href="javascript:void(0);">Add document</a>)</h3> 
                            <div id="document-list"></div>
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
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Select Service</label>
                            <div class="col-lg-10 related-service-div">
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" <?= $service_id == $florida['id'] ? 'checked' : ''; ?> name="service_id" id="service_florida" onchange="changeServiceRadio(this.value, '<?= $florida['retail_price']; ?>');" retail_price="<?= $florida['retail_price']; ?>" value="<?= $florida['id']; ?>">
                                    <label for="service_florida"><?= $florida['description']; ?></label>
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" class="service_radio" required="" title="Service" <?= $service_id == $delaware['id'] ? 'checked' : ''; ?> name="service_id" id="service_delaware" onchange="changeServiceRadio(this.value, '<?= $delaware['retail_price']; ?>');" retail_price="<?= $delaware['retail_price']; ?>" value="<?= $delaware['id']; ?>">
                                    <label for="service_delaware"><?= $delaware['description']; ?></label>
                                </label>
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
                                <input readonly="" id="retail_price" name="retail_price" class="form-control" type="text" title="Retail Price" value="<?= $service['retail_price']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" numeric_valid="" title="Retail Price" value="<?= $edit_data['price_charged']; ?>">
                                <div class="errorMessage text-danger"></div>        
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Add Related Services</label>
                            <div class="col-lg-10">
                                <select data-placeholder="Select one option" title="Related Services" class="chosen-select get_select_service" name="related_services[]" id="related_services" style="width: 100%;" multiple="">
                                    <?php load_ddl_option("get_select_service", $selected_services, $service_id); ?>
                                </select>
                            </div>
                        </div>

                        <div id="related_service_container">
                            <?php
                            foreach ($all_related_services as $key => $data) {
                                if ($data['related_services_id'] != 1) {
                                    $service2 = getService($data['related_services_id']);
                                    $related_service2 = getRelatedService($data['related_services_id']);
                                    $all_notes_service = getmainServiceNotesContent($edit_data['id'], $data['related_services_id']);
                                    $specific_services = getSpecificServiceData($edit_data['id'], $data['related_services_id']);
                                    ?>
                                    <div id="related_service_<?= $data['related_services_id'] ?>" data-serviceid="<?= $data['related_services_id'] ?>" class="related_service bg-<?= ($key > 3) ? (($key + 1) % 4) : $key + 1; ?> row"  style="display: <?= (in_array($data['related_services_id'], $selected_services)) ? 'block' : 'none'; ?>">
                                        <div class="col-md-12">
                                            <br/>
                                            <h3><?= $service2->description ?></h3>
                                            <input type="hidden" name="related_service[<?= $edit_data['id'] ?>][<?= $data['related_services_id'] ?>][service_id]" value="<?= $data['related_services_id'] ?>">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Retail Price</label>
                                                <div class="col-lg-10">
                                                    <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="<?= $service2->retail_price; ?>">
                                                    <input type="hidden" name="related_service[<?= $edit_data['id'] ?>][<?= $data['related_services_id'] ?>][retail_price]" value="<?= $service2->retail_price ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Override Price</label>
                                                <div class="col-lg-10">
                                                    <input placeholder="" id="override_price_<?= $data['related_services_id'] ?>" numeric_valid="" class="form-control" type="text" name="related_service[<?= $edit_data['id'] ?>][<?= $data['related_services_id'] ?>][override_price]" title="Retail Price" value="<?= isset($specific_services[0]['price_charged']) ? $specific_services[0]['price_charged'] : ''; ?>">
                                                    <div class="errorMessage text-danger"></div>
                                                </div>
                                            </div>
                                            <?= service_note_func('Note', 'n', 'service', $edit_data['id'], $data['related_services_id']); ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <?= service_note_func('Order Notes', 'n', 'order', $edit_data['id']); ?>                            
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
                                <input type="hidden" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url(); ?>">
                                <input type="hidden" name="editval" id="editval" value="<?= $edit_data['id']; ?>">
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
<input type="hidden" id="hiddenrelatedvalues" value="<?= implode(',', array_column($all_related_services, 'related_services_id')); ?>">
<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script>
    clientTypeChange('<?= $edit_data['new_existing']; ?>', '<?= $reference_id; ?>', '<?= $reference; ?>', 1);
    function changeServiceRadio(serviceID, retailPrice) {
//        loadDdlOptionsAjax('get_select_service', '', serviceID);
        setIdVal('service_id', serviceID);
        setIdVal('retail_price', retailPrice);
//        $('.related_service').hide();
//        setIdHTML('related_service_container', '');
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
                    $("#service_florida, #service_delaware").prop("disabled", true);
                    changeServiceRadio(getIdVal('service_delaware'), $('#service_delaware').attr('retail_price'));
                } else if (state == 10) {
                    $('#service_florida').prop("checked", true);
                    $('#service_delaware').prop("checked", false);
                    $("#service_florida, #service_delaware").prop("disabled", true);
                    changeServiceRadio(getIdVal('service_florida'), $('#service_florida').attr('retail_price'));
                } else {
                    $("#service_florida, #service_delaware").prop("disabled", false);
                }
                $('#due_date').val(result);
            }
        });
    }
    $(function () {
        var client_type = $('#type_of_client_ddl').val();
        if (client_type == '0') {
            fetchExistingClientData('<?= $reference_id; ?>', <?= $reference_id; ?>, '<?= $reference; ?>', 1);
            $('.display_div').hide();
            annual_date('<?= $reference_id; ?>');
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
            setIdVal('fein', '<?= $edit_data['fein']; ?>');
            setIdVal('start_month_year', "<?= $edit_data['start_month_year']; ?>");
            change_due_date('<?= $edit_data['state_opened']; ?>', '<?= $edit_data['company_type']; ?>');
        }
    });
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
        $(selector).on('change', function (evt, params) {
            var selVal = $(this).val();
            var field_name = $(this).attr('name');
            $that = $(this);
            var prevselected = $("#hiddenrelatedvalues").val();
            var prevselectedarray = prevselected.split(",");
            if (field_name == 'related_services[]') {
                if (selVal == null) {
                    $('.related_service').hide();
                } else {
                    $('.related_service').each(function () {
                        var currentId = $(this).attr('data-serviceid');
                        if (jQuery.inArray(currentId, selVal) == -1) {
                            $('#related_service_' + currentId).hide();
                        } else {
                            $('#related_service_' + currentId).show();
                        }
                    });
                }
                $("#hiddenrelatedvalues").val(selVal);
            }

        });
    }
</script>
