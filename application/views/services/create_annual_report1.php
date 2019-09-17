<?php $total = $delaware['retail_price'] + $florida['retail_price']; ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_create_annual_report" onsubmit="request_create_annual_report()">
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
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("existing_client_list"); ?>
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
                                <select class="form-control value_field required_field disabled_field" name="istate" id="state" title="State of Incorporation" required=""  onchange="change_due_date(this.value, document.getElementById('type').value)">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list"); ?>
                                </select>
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
                            <label class="col-lg-2 control-label">Business Description<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control value_field required_field" name="business_description" id="business_description" title="Business Description"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="documents_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>');
                                    return false;" href="javascript:void(0);">Add document</a>)</h3> 
                            <div id="document-list"></div>
                        </div>

                        <div id="contact_info_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Contact Info<span class="text-danger">*</span><span class="display_div">&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>');
                                    return false;">Add Contact</a>)</span></h3>
                            <div id="contact-list">
                                <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="owners_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Owners<span class="text-danger">*</span> &nbsp; (<a href="javascript:void(0);" class="owneradd" onclick="open_owner_popup(1, '<?= $reference_id; ?>', 0);
                                    return false;">Add owner</a>)</h3>
                            <div id="owners-list">
                                <input type="hidden" class="required_field" title="Owners" id="owners-list-count" required="required" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>


                        <div class="hr-line-dashed"></div>
                        <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Due Date</label>
                            <div class="col-lg-10">
                                <input placeholder="dd/mm/yyyy" readonly="" class="form-control" type="text" title="Due Date" name="due_date" id="due_date" value="" required>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Price</label>
                            <div class="col-lg-10">
                                <label class="checkbox-inline">
                                    <input type="checkbox" onchange="calculateRetailPrice();" name="annual_report_florida" id="annual_report_florida" value="Annual Florida"><b>Annual Florida</b>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" onchange="calculateRetailPrice();" name="annual_report_delaware" id="annual_report_delaware" value="Annual Delware"><b>Annual Delaware</b>
                                </label>
                                <label id="annual_div" class="checkbox-inline" style="display:none">
                                    <input type="checkbox" onchange="calculateRetailPrice();" name="registered_agent" id="registered_agent" value="Registered Agent"><b>Registered Agent</b>
                                </label>
                                <input type="hidden" id="retail-price-initialamt" value="0" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control retail_price" type="text" title="Retail Price" value="" id="retail-price" name="retail_price">
                                <input type="hidden" name="retail_price_florida" id="retail-price-hidd-florida" value="<?php echo $florida['retail_price'] ?>">
                                <input type="hidden" name="retail_price_delaware" id="retail-price-hidd-delaware" value="<?php echo $delaware['retail_price'] ?>">
                                <input type="hidden" name="retail_price_registered_agent" id="retail-price-hidd-registered-agent" value="<?php echo $regestered_agent['retail_price'] ?>">
                                <input type="hidden" name="retail_price_both" id="retail-price-hidd-both" value="<?php echo $total; ?>">
                                <input type="hidden" name="retail_price_registered_agent" id="retail-price-hidd-registered_agrent" value="100">
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
                        <div class="hr-line-dashed"></div>
                        <div id="internal_data_div" class="display_div">

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
                        </div>
                        <div class="hr-line-dashed"></div>
                        <h3>Notes</h3>
                        <?php service_note_func('Order Notes', 'n', 'order'); ?>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="new_reference_id" id="new_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" id="service_id_florida" value="<?= $florida['id'] ?>">
                                <input type="hidden" id="service_id_delaware" value="<?= $delaware['id'] ?>">
                                <input type="hidden" name="action" id="action" value="create_annual_report">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="">
                                <input type="hidden" name="annual_report_sub_cat" id="annual_report_sub_cat" value="1">
                                <button class="btn btn-success" type="button" onclick="request_create_annual_report()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelRequestCreateAnnualReport()">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;">
</div>

<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;">

</div>
<script>
    clientTypeChange(1, <?= $reference_id; ?>, '<?= $reference; ?>', 3);
    $(document).ready(function () {
        setInterval(function () {
            if ($('#annual_report_delaware').is(':checked')) {
                $("#service_id").val($('#service_id_delaware').val());
            } else {
                $("#service_id").val($('#service_id_florida').val());
            }
        }, 100);
        var florida = parseInt($("#retail-price-hidd-florida").val());
        var delaware = parseInt($("#retail-price-hidd-delaware").val());
        var registered_agent = parseInt($("#retail-price-hidd-registered-agent").val());
        var total = florida + delaware + registered_agent;
        $('input[name="annual_report_delaware"]').click(function () {
            if (this.checked) {
                $("#annual_div").css({"display": "inline-block"});
                $("#registered_agent").prop('checked', true);
            } else {
                $("#annual_div").css({"display": "none"});
                $("#registered_agent").prop('checked', false);
            }
        });
//
//        $("#registered_agent").click(function () {
//            var p = $("#retail-price").val();
//
//            if (this.checked) {
////                alert(p);
//                p = parseInt(p) + registered_agent;
//                $("#retail-price").val(p);
//            } else {
////                alert('hi');
//                p = parseInt(p) - registered_agent;
//                $("#retail-price").val(p);
//            }
    });
//        $('input[name="annual_report_florida"]').change(function () {
//            if (this.checked) {
//                $("#retail-price").val(florida);
//            } else {
//                $("#retail-price").val('');
//            }
//
//            if ($('#annual_report_florida').is(':checked') && $('#annual_report_delaware').is(':checked')) {
//                $("#retail-price").val(total);
//            } else if ($('#annual_report_florida').is(':checked')) {
//                $("#retail-price").val(florida);
//            } else if ($('#annual_report_delaware').is(':checked')) {
//                $("#retail-price").val(delaware);
//            } else {
//                $("#retail-price").val('');
//            }
//        });
//
//        $('input[name="annual_report_delaware"]').change(function () {
//            if (this.checked) {
//                $("#retail-price").val(delaware + registered_agent);
//            }
//
//            if ($('#annual_report_florida').is(':checked') && $('#annual_report_delaware').is(':checked')) {
//                $("#retail-price").val(total);
//            } else if ($('#annual_report_florida').is(':checked')) {
//                $("#retail-price").val(florida);
//            } else if ($('#annual_report_delaware').is(':checked')) {
//                $("#retail-price").val(delaware + registered_agent);
//            } else {
//                $("#retail-price").val('');
//
//            }
//        });
//
//    });

    function change_due_date(state, type) {
        $.ajax({
            type: 'POST',
            url: base_url + 'services/home/change_due_date',
            data: {
                state: state,
                type: type
            },
            success: function (result) {
                $('#due_date').val(result);
            }
        });
    }

    function calculateRetailPrice() {
        var retail_price = 0;
        if ($('#annual_report_florida').is(':checked') && $('#annual_report_florida').val() != '') {
            retail_price += parseInt($("#retail-price-hidd-florida").val());
        }
        if ($('#annual_report_delaware').is(':checked') && $('#annual_report_delaware').val() != '') {
            retail_price += parseInt($("#retail-price-hidd-delaware").val());
        }
        if ($('#registered_agent').is(':checked') && $('#registered_agent').val() != '') {
            retail_price += parseInt($("#retail-price-hidd-registered-agent").val());
        }
        if (retail_price != 0) {
            $("#retail-price").val(retail_price);
        } else {
            $("#retail-price").val('');
        }
    }

</script>