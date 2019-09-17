<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_new_company" onsubmit="requestService(); return false;">
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
                        <h3>Business Information</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control state_opened" disabled="" name="state" id="state_opened" title="State of Incorporation" required="" onchange="changeServiceInfo(getIdVal('new_company_' + this.value));select_other_state(this.value);">
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

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Name of Business<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Option 1" class="form-control" type="text" name="name_of_business1" id="name_of_business1" title="Name of Business" required>
                                <div class="errorMessage text-danger"></div>
                                <input placeholder="Option 2" class="form-control" type="text" name="name_of_business2" id="name_of_business2" title="Name of Business">
                                <input placeholder="Option 3" class="form-control" type="text" name="name_of_business3" id="name_of_business3" title="Name of Business">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="fiscal_year_end" id="fye" title="Fiscal year end" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="dba" title="DBA">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Business Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="business_description" name="business_description" title="Business Description"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Contact Info<span class="text-danger">*</span>&nbsp; (<a href="javascript:void(0);" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Contact</a>)</h3> 
                        <div id="contact-list">
                            <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Owners<span class="text-danger">*</span> &nbsp; (<a href="javascript:void(0);" onclick="open_owner_popup(<?= $service_id; ?>, '<?= $reference_id; ?>', 0); return false;">Add owner</a>)</h3> 
                        <div id="owners-list">
                            <input type="hidden" title="Owners" id="owners-list-count" required="required" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Internal Data</h3>
                        <div class="form-group office-internal">
                            <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("staff_office_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select name="partner" id="partner" class="form-control" title="Partner" required>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select name="manager" id="manager" class="form-control" title="Manager" required></select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client Association</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="client_association" id="client_association" title="Client Association">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("referer_by_source"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="referred_by_name" name="referred_by_name" title="Referred By Name">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" id="language" name="language" title="Language" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("language_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <h3>Documents &nbsp; (<a onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>');" href="javascript:void(0);">Add Document</a>)</h3> 
                        <div id="document-list">
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Main Service</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="<?= $service['retail_price']; ?>">
                                <input type="hidden" name="retail_price" value="<?= $service['retail_price']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input numeric_valid="" class="form-control" type="text" name="retail_price_override" title="Retail Price" id="retail_price_override" value="<?= $edit_data['price_charged']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?= service_note_func('Note', 'n', 'service', $edit_data['id'], 1); ?>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Add Related Services</label>
                            <div class="col-lg-10 related-service-div">
                                <select data-placeholder="Select one option" title="Related Services" class="chosen-select get_select_service" name="related_services[]" id="related_services" style="width: 100%;" multiple="">
                                    <?php load_ddl_option("get_select_service", $selected_services, $service_id); ?>
                                </select>
                            </div>
                        </div>

                        <div id="related_service_container">
                            <?php
                            foreach ($all_related_services as $key => $data) {
                                if ($data['related_services_id'] != $service_id) {
                                    $service2 = getService($data['related_services_id']);
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
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="editval" id="editval" value="<?= $edit_data['id']; ?>">
                                <input type="hidden" class="service_hidden service_florida" id="new_company_10" retail_price="<?= $florida['retail_price']; ?>" value="<?= $florida['id']; ?>">
                                <input type="hidden" class="service_hidden service_delaware" id="new_company_8" retail_price="<?= $delaware['retail_price']; ?>" value="<?= $delaware['id']; ?>">
                                <input type="hidden" class="service_hidden service_bvi" id="new_company_52" retail_price="<?= $bvi['retail_price']; ?>" value="<?= $bvi['id']; ?>">
                                <input type="hidden" class="service_hidden service_oth" id="new_company_53" retail_price="<?= $oth['retail_price']; ?>" value="<?= $oth['id']; ?>">
                                <button class="btn btn-success" type="button" onclick="request_create_company()">Save changes</button> &nbsp;&nbsp;&nbsp;
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
<input type="hidden" id="hiddenrelatedvalues" value="<?= implode(',', array_column($all_related_services, 'related_services_id')); ?>">
<script>
    get_contact_list('<?= $company_id; ?>', 'company');
    reload_owner_list('<?= $company_id; ?>', 'main');
    get_document_list('<?= $company_id; ?>', 'company');
    getInternalData('<?= $reference_id; ?>', 'company');
    setIdVal('state_opened', '<?= $edit_data['state_opened']; ?>');
    setIdVal('name_of_business1', '<?= $edit_data['company_name']; ?>');
    setIdVal('name_of_business2', '<?= (!empty($company_name_option)) ? $company_name_option['name2'] : ''; ?>');
    setIdVal('name_of_business3', '<?= (!empty($company_name_option)) ? $company_name_option['name3'] : ''; ?>');
    setIdVal('type', '<?= $edit_data['company_type']; ?>');
    setIdVal('fye', '<?= $edit_data['fiscal_year_end']; ?>');
    setIdVal('dba', '<?= $edit_data['dba']; ?>');
    setIdVal('business_description', '<?= $edit_data['business_description']; ?>');
//    changeServiceInfo(getIdVal('new_company_<?//= $edit_data['state_opened']; ?>'));
  
    function changeServiceInfo(serviceID) {
        setIdVal('service_id', serviceID);
        if ($('.service_delaware').val() == serviceID) {
            setIdVal('retail_price', <?= $delaware['retail_price']; ?>);
        } else if($('.service_florida').val() == serviceID) {
            setIdVal('retail_price', <?= $florida['retail_price']; ?>);
        }else if($('.service_bvi').val() == serviceID) {
            setIdVal('retail_price', <?= $bvi['retail_price']; ?>);
        }else if($('.service_oth').val() == serviceID) {
            setIdVal('retail_price', <?= $oth['retail_price']; ?>);
        }
    }

    function checkConfirmation() {
        if ($("#confirmation").prop('checked')) {
            $("#confirmation").val("1");
        } else {
            $("#confirmation").val("");
        }
    }

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
            var base_url = $('#baseurl').val();
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
                        //alert(jQuery.inArray(currentId,selVal));
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
