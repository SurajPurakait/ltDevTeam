<?php $total = $delaware['retail_price'] + $florida['retail_price']; ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <?= service_request_invoice_link($edit_data[0]['id']); ?>
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_create_annual_report" onsubmit="request_create_annual_report()">
                        <h3>Business Information</h3><span class="company-data"></span>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Existing Client<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="disabled" class="form-control type_of_client" name="type_of_client" id="type_of_client" onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" title="Type Of Client" required>
                                    <option value="0" <?= ($annual_report['new_existing'] == 0) ? 'selected' : ''; ?> >Yes</option>
                                    <option  value="1" <?= ($annual_report['new_existing'] == 1) ? 'selected' : ''; ?>>No</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="disabled" class="form-control client_list client_type_field0" name="client_list" id="client_list_ddl" title="Client List" <?= $annual_report['existing_ref_id'] != 0 ? "required=''" : ""; ?>>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("existing_client_list", $annual_report['existing_ref_id']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div1" id="name_of_business">
                            <label class="col-lg-2 control-label">Name of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Company Name" id="name_of_company" class="form-control client_type_field1" type="text" name="name_of_company" title="Name of Company" value="<?= $company_data['name']; ?>" <?= $annual_report['existing_ref_id'] == 0 ? "required=''" : ""; ?>>
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

                        <div class="form-group display_div" id="type_div">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type-of-company required_field" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list", $edit_data[0]['type']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Month & Year to Start</label>
                            <div class="col-lg-10">
                                <input placeholder="mm/yyyy" id="month" class="form-control datepicker_my " type="text" title="Month & Year to Start" name="start_year" value="<?= $company_data['start_month_year']; ?>">
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
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" class="form-control" id="fein" type="text" name="fein" value="<?= $company_data['fein']; ?>" title="Federal ID">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="business_description_div">
                            <label class="col-lg-2 control-label">Business Description<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control  required_field" name="business_description" id="business_description" title="Business Description"><?php echo urldecode($company_data['business_description']); ?></textarea>
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
                        <?php // print_r($annual_report);?>

                        <div class="hr-line-dashed"></div>
                        <h3>Price</h3>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Due Date</label>
                            <div class="col-lg-10">

                                <input placeholder="dd/mm/yyyy" class="form-control datepicker_my" type="text" title="Due Date" name="due_date"
                                       id="due_date" value="<?php echo $annual_report['due_date']; ?>" required>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Price</label>
                            <div class="col-lg-10">
                                <label class="checkbox-inline">
                                    <input type="checkbox" <?php
                                    if ($annual_report['annual_florida'] == "1") {
                                        echo 'checked';
                                    }
                                    ?> name="annual_report_florida" onchange="calculateRetailPrice();" id="annual_report_florida" value="Annual Florida" ><b>Annual Florida</b>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox"  name="annual_report_delaware" <?php
                                    if ($annual_report['annual_delaware'] == "1") {
                                        echo 'checked';
                                    }
                                    ?> id="annual_report_delaware" onchange="calculateRetailPrice();" value="Annual Delware"><b>Annual Delaware</b>

                                </label>
                                <label id="annual_div" class="checkbox-inline" style=<?= $annual_report['registered_agent'] == 1 ? "" : "display:none"; ?>>
                                    <input type="checkbox" checked=""  name="registered_agent" <?php
                                    if ($annual_report['registered_agent'] == "1") {
                                        echo 'checked';
                                    }
                                    ?> id="registered_agent" onchange="calculateRetailPrice();" value="Registered Agent"><b>Registered Agent(100)</b>


                                </label>
                                <input type="hidden" id="retail-price-initialamt" value="0" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <?php if ($annual_report['annual_florida'] == '1' && $annual_report['annual_delaware'] == '0' && $annual_report['registered_agent'] == '0') { ?>

                                    <input type="hidden" name="retail_price_florida" id="retail-price-florida" value="<?php echo $annual_report['florida_price']; ?>">
                                    <?php
                                    $price = $annual_report['florida_price'];
                                }
                                ?>

                                <?php if ($annual_report['annual_florida'] == '1' && $annual_report['annual_delaware'] == '1' && $annual_report['registered_agent'] == '1') { ?>

                                    <input type="hidden" name="retail_price_florida" id="retail-price-total" value="<?php echo $annual_report['total_price']; ?>">
                                    <?php
                                    $price = $annual_report['total_price'];
                                }
                                ?>
                                <?php if ($annual_report['annual_florida'] == '1' && $annual_report['annual_delaware'] == '1' && $annual_report['registered_agent'] == '0') { ?>

                                    <input type="hidden" name="retail_price_florida" id="retail-price-total" value="<?php echo $annual_report['total_price']; ?>">
                                    <?php
                                    $price = $annual_report['total_price'];
                                }
                                ?>

                                <?php if ($annual_report['annual_delaware'] == '1' && $annual_report['annual_florida'] == '0' && $annual_report['registered_agent'] == '1') { ?>

                                    <input type="hidden" name="retail_price_florida" id="retail-price-delaware" value="<?php echo $annual_report['delaware_price']; ?>">
                                    <?php
                                    $price = $annual_report['delaware_price'];
                                }
                                ?>
                                <?php if ($annual_report['annual_delaware'] == '1' && $annual_report['annual_florida'] == '0' && $annual_report['registered_agent'] == '0') { ?>

                                    <input type="hidden" name="retail_price_florida" id="retail-price-delaware" value="<?php echo $annual_report['delaware_price']; ?>">
                                    <?php
                                    $price = $annual_report['delaware_price'];
                                }
                                ?>
                                <input disabled  placeholder="" class="form-control" name="retail_price" type="text" title="Retail Price" value="<?php echo $price; ?>" id="retail-price" >
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
                                <input placeholder="" numeric_valid="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" title="Retail Price" value="<?php echo $annual_report['override_price']; ?>">
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
                                        <?php load_ddl_option("staff_office_list", $inter_data['office']); ?>
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
                                    <input placeholder="" class="form-control value_field" type="text" id="client_association" name="client_association" title="Client Association" value="<?= $inter_data['client_association']; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
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
                                    <select class="form-control value_field required_field" id="language" name="language" title="Language" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("language_list", $inter_data['language']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="hr-line-dashed"></div>
                                                <h3>Notes</h3>-->
                        <?php //  service_note_func('Order Notes', 'n', 'company', $reference_id); ?>
                        <!--<div class="hr-line-dashed"></div>-->
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
                                <input type="hidden" name="editval" id="editval" value="<?php echo $edit_data[0]['id'] ?>">
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
    clientTypeChange(<?= $annual_report['new_existing']; ?>,<?= $reference_id; ?>, '<?= $reference; ?>', 3);
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

//        $("#registered_agent").click(function () {
//            var p = $("#retail-price").val();
//
//            if (this.checked) {
//                p = parseInt(p) + registered_agent;
//                $("#retail-price").val(p);
//            } else {
//                p = parseInt(p) - registered_agent;
//                $("#retail-price").val(p);
//            }
//        });
//
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
//                $("#retail-price").val(delaware);
//            } else {
//                $("#retail-price").val('');
//
//            }
//        });

    });


    $(document).ready(function () {
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