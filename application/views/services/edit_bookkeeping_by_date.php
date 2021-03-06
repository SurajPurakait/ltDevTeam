<?php
$service_id = 41;
$reference = 'company';
$reference_id = $edit_data[0]['reference_id'];
$get_bookkeeping_data = $get_bookkeeping['new_existing'];
$existing_reference_id = $get_bookkeeping['existing_ref_id'];
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <?= service_request_invoice_link($edit_data[0]['id']); ?>
                <form class="form-horizontal" method="post" id="form_create_bookkeeping_by_date" onsubmit="requestService(); return false;">
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
                                <select disabled="" class="form-control type_of_client" name="type_of_client" title="Type Of Client" id="type_of_client_ddl"  onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" required>
                                    <option value="">Select an option</option>
                                    <option value="0" <?= ($get_bookkeeping_data == 0) ? 'selected' : ''; ?>>Yes</option>
                                    <option value="1" <?= ($get_bookkeeping_data == 1) ? 'selected' : ''; ?>>No</option>
                                </select> 
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="" class="form-control client_type_field0" name="client_list" id="client_list_ddl" title="Client List">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("existing_client_list", $get_bookkeeping['existing_ref_id']); ?>

                                </select> 
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div1" id="name_of_business">
                            <label class="col-lg-2 control-label">Name of Business<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Option 1" id="business_name" value="<?= $edit_data[0]['name']; ?>" class="form-control client_type_field1" type="text" name="name_of_business1" title="Name of Business">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="state" id="state" title="State of Incorporation" required="" onchange="select_other_state(this.value);">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list", $edit_data[0]['state_opened']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="state_other" <?php echo ($other_state == "") ? "style='display:none'" : ""; ?>>
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="text" name="state_other" class="form-control" value="<?= $other_state; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group display_div" id="type_div">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list", $edit_data[0]['company_type']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="fiscal_year_end_div">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="fiscal_year_end" id="fye" title="Fiscal year end" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end", $edit_data[0]['fye']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group display_div" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="dba" title="DBA" value="<?php echo $edit_data[0]['dba'] ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="business_description_div">
                            <label class="col-lg-2 control-label">Business Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="business_description" title="Business Description"><?= urldecode($edit_data[0]['business_description']); ?></textarea>
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
                                    <select class="form-control" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("staff_office_list", $edit_data[0]['office']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="partner" id="partner" class="form-control required_field value_field" title="Partner" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="manager" class="form-control required_field value_field" id="manager" title="Manager" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Client Association</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="client_association" id="client_association" title="Client Association" value="<?php echo $edit_data[0]['client_association']; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("referer_by_source", $edit_data[0]['referred_by_source']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" id="referred_by_name" name="referred_by_name" title="Referred By Name" value="<?php echo $edit_data[0]['referred_by_name']; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control" id="language" name="language" title="Language" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("language_list", $edit_data[0]['language']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Existing Practice ID</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="existing_practice_id" title="Existing Practice ID" value="<?= $get_bookkeeping['existing_practice_id']; ?>">
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
                        <div class="accounts-details">
                            <h3>Financial Accounts<span class="text-danger">*</span>&nbsp; (<a href="javascript:void(0);" onclick="account_modal('add', '', 'month_diff');">Add Financial Account</a>)</h3>
                            <div id="accounts-list">
                                <input type="hidden" title="Financial Accounts" id="accounts-list-count" required="required" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" id="retail-price" type="text" title="Retail Price" value="0">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="0">
                                <input type="hidden" id="retail-price-initialamt" name="related_service[<?= $edit_data[0]['id'] ?>][41][retail_price]" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input numeric_valid="" placeholder="" id="retail_price_override" class="form-control" type="text" name="related_service[<?= $edit_data[0]['id'] ?>][41][override_price]" title="Retail Price" value="<?= $edit_data[0]['price_charged']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?= service_note_func('Bookkeeping Note', 'n', 'service', $edit_data[0]['id'], $service_id); ?>
                        <!--                        <div class="hr-line-dashed"></div>
                                                <h3>Notes</h3>-->
                        <?php // service_note_func('Order Notes', 'n', 'company', $reference_id); ?>

                        <div class="hr-line-dashed"></div>

                        <!--                        <label>Payment Options Form</label>
                                                <div class="hr-line-dashed"></div>-->

                        <h3>Confirmation</h3>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirm<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="checkbox" name="confirmation" title="Confirmation" id="confirmation" value=""  required>
                                I confirm to be aware that the information added above is correct.
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $company_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_bookkeeping_by_date">
                                <input type="hidden" name="quant_title" id="quant_title" value="<?= $quant_title; ?>">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="<?= $quant_contact; ?>">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="<?= 1; ?>">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="<?= $edit_data[0]['id']; ?>">
                                <input type="hidden" name="quant_account" id="quant_account" value="<?= $quant_account; ?>">
                                <input type="hidden" name="bookkeeping_sub_cat" id="bookkeeping_sub_cat" value="2">
                                <button class="btn btn-success" type="button" onclick="return request_create_bookkeeping_by_date()">Save changes</button> &nbsp;&nbsp;&nbsp;
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

    clientTypeChange('<?= $get_bookkeeping_data; ?>', '<?= $reference_id; ?>', '<?= $reference; ?>', 1);
    $(function () {
        var client_type = $('#type_of_client_ddl').val();
        if (client_type == '0') {
            fetchExistingClientData('<?= $existing_reference_id; ?>', <?= $reference_id; ?>, '<?= $reference; ?>', 1);
            $('.display_div').hide();
        } else {
            get_contact_list('<?= $company_id; ?>', 'company');
            reload_owner_list('<?= $company_id; ?>', 'main');
            get_document_list('<?= $company_id; ?>', 'company');
        }
        get_financial_account_list('<?= $company_id; ?>', 'month_diff', '<?= $edit_data[0]['id']; ?>');
        interval_total_amounts();
        $('#start_month,#complete_month').datepicker({dateFormat: 'mm/yy'});
        $('#start_month,#complete_month').attr("onblur", 'checkDate(this);');


    });
//        $('#start_month,#complete_month').datepicker({dateFormat: 'mm/yy'});
//        $('#start_month,#complete_month').attr("onblur", 'checkDate(this);');
//        get_contact_list('<?= $company_id; ?>', 'company');
//        reload_owner_list('<?= $company_id; ?>', 'main');
//        get_document_list('<?= $company_id; ?>', 'company');
//        get_financial_account_list('<?= $company_id; ?>', 'month_diff');
//        interval_total_amounts();
    $(function () {
        //$("#client_list, #name_of_business").hide();
        setInterval(function () {
            var total_amounts = document.getElementsByClassName('total_amounts');
            //var payroll_people_total = $(".payroll_people_total").val();
            var office_visit = $(".office_visit").val();
            var corporate_tax_return = $(".corporate_tax_return").val();
            var price_initialam = $("#retail-price-initialamt").val();
            var total = 0;
            total += parseInt(price_initialam);
            for (i = 0; i < total_amounts.length; i++) {
                total += parseInt(total_amounts[i].value);
            }
            // if(payroll_people_total == '1-10'){
            //     total += 50;
            // }else if(payroll_people_total == '11-20'){
            //     total += 100;
            // }else if(payroll_people_total == '21-30'){
            //     total += 150;
            // }

//            if (total_amounts.length > 0) {
//                $(".accounts-details").addClass('background-image');
//            } else {
//                $(".accounts-details").removeClass('background-image');
//            }

            if (office_visit == 'y') {
                total += 50;
            }
            if (corporate_tax_return == 'y') {
                total += 35;
            }
            $("#retail-price").val(total + ".00");
            $("#retail-price-hidd").val(total);
        }, 100);

        load_partner_manager_ddl('<?= $edit_data[0]['office']; ?>', '<?= $edit_data[0]['partner']; ?>', '<?= $edit_data[0]['manager']; ?>');

        $('.add-secq').click(function () {//alert('ff');
            var qval = $(this).prev('.secq-text').html();
            var qlabel = $(this).parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="secq_div' + div_count + '"><label>' + qlabel + '</label>' + qval + '<a href="javascript:void(0)" onclick="removeSecq(\'secq_div' + div_count + '\')" class="text-danger rem-secq"><i class="fa fa-times"></i> Remove Security Question</a></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });

        $("#start_month, #complete_month").blur(function () {
            var val = $("#no_of_transactions option:selected").val();
            var amt = 0;
            if (val != '') {
                if (val == '0-100') {
                    amt = 149;
                } else if (val == '101-200') {
                    amt = 175;
                } else if (val == '201-300') {
                    amt = 200;
                }
            } else {
                amt = 149;
            }
            var count_fc_ac = document.getElementsByClassName('total_amounts').length;
            if (count_fc_ac > 0) {
                if (val != '') {
                    if (val == '0-100') {
                        amt = 25;
                    } else if (val == '101-200') {
                        amt = 50;
                    } else if (val == '201-300') {
                        amt = 75;
                    }
                } else {
                    amt = 25;
                }
            }
            var start = $("#start_month").val();
            var end = $("#complete_month").val();
            if (start != "" && end != "") {
                monthDiff(start, end, function (result) {
                    if (result.trim() != "N") {
                        $("#grand_total_amount").val(result * amt);
                    } else {
                        $("#grand_total_amount").val(amt);
                    }
                });
            }
        });

        $("#no_of_transactions").change(function () {
            var val = $("#no_of_transactions option:selected").val();
            var amtval = $("#retail-price-hidd").val();
            if (val != '') {
                if (val == '0-100') {
                    var amt = '149';
                } else if (val == '101-200') {
                    var amt = '175';
                } else if (val == '201-300') {
                    var amt = '200';
                }
            } else {
                var amt = '149';
            }
            var count_fc_ac = document.getElementsByClassName('total_amounts').length;
            if (count_fc_ac > 0) {
                if (val != '') {
                    if (val == '0-100') {
                        var amt = '25';
                    } else if (val == '101-200') {
                        var amt = '50';
                    } else if (val == '201-300') {
                        var amt = '75';
                    }
                } else {
                    var amt = '25';
                }
            }
            $("#total_amount").val(amt);
            $("#retail-price-hidd").val(amt);
            $("#retail-price").val(amt);
        });
        $(".payroll_people_total").change(function () {
            var val = $(".payroll_people_total option:selected").val();
            var amtval = $("#payroll-price-hidd").val();
            var initialamt = $("#payroll-price-hidd").val();
            if (val != '0') {
                if (val == '1-10') {
                    var amt = parseInt(amtval) + 50;
                } else if (val == '11-20') {
                    var amt = parseInt(amtval) + 100;
                } else if (val == '21-30') {
                    var amt = parseInt(amtval) + 150;
                }
            } else {
                var amt = parseInt(initialamt);
            }
            $(".retprice").val(amt);
            $(".retpricehidd").val(amt);
        });
        $(".office_visit").change(function () {
            var val = $(".office_visit option:selected").val();
            var amtval = $("#payroll-price-hidd").val();
            var initialamt = $("#retail-price-initialamt").val();
            if (val != '') {
                if (val == 'y') {
                    var amt = parseInt(amtval) + 50;
                } else if (val == 'n') {
                    var amt = parseInt(amtval) - 50;
                }
            } else {
                var amt = parseInt(initialamt);
            }
            $("#retail-price-hidd").val(amt);
            $("#retail-price").val(amt);
        });
//        $(".client_list").change(function () {
//            clearErrorMessageDiv()
//            var clientid = $(".client_list option:selected").val();
//            var new_reference_id = $("#reference_id").val();
//            var base_url = $("#base_url").val();
//            delete_contact_list(new_reference_id);
//            delete_owner_list(new_reference_id);
//            if (clientid != '') {
//                get_contact_list(clientid, 'company', "y");
//                save_contact_list('company', clientid, new_reference_id);
//                reload_owner_list(clientid, 'main');
//                save_owner_list(clientid, new_reference_id);
//                set_internal_data(clientid);
//                set_company_type(clientid);
//                set_state_of_incorporation(clientid);
//                $("#owners_div, #internal_data_div, #documents_div, #business_description_div, #fiscal_year_end_div, #type_div, #state_div").hide();
//                // $(".internal-data").html('<a href="javascript:void(0);" value="0">Edit Internal Data</a>');
//                // $('.office-internal #office').prop('disabled', true);
//                // $('#partner').prop('disabled', true);
//                // $('#manager').prop('disabled', true);
//                // $("#client_association").prop("disabled", true);
//                //  $("#referred_by_source").prop('disabled', true);
//                //  $("#referred_by_name").prop("disabled", true);
//                //  $("#language").prop('disabled', true);
//            } else {
//                $("#contact-list").html(blank_contact_list());
//                //                $("#accounts-list").html('');
//                $("#owners-list").html(blank_owner_list());
//                $(".office-internal #office, #state").val('');
//                $("#partner").val('');
//                $("#manager").val('');
//                $("#client_association").val('');
//                $("#referred_by_source").val('');
//                $("#referred_by_name").val('');
//                $("#language").val('');
//
//
//                $(".internal-data").html('');
//                $(".contact-data").html('');
//                $(".contactedit").removeClass('dcedit');
//                $(".contactdelete").removeClass('dcdelete');
//                $(".owner-data").html('');
//                $(".owneredit").removeClass('doedit');
//                $(".ownerdelete").removeClass('dodelete');
//                $('.office-internal #office').prop('disabled', false);
//                $('#partner').prop('disabled', false);
//                $('#manager').prop('disabled', false);
//                $("#client_association").prop("disabled", false);
//                $("#referred_by_source").prop('disabled', false);
//                $("#referred_by_name").prop("disabled", false);
//                $("#language").prop('disabled', false);
//                $('#state').prop('disabled', false);
//                $("#type").val("");
//                $('#type').prop('disabled', false);
//                $("#owners_div, #internal_data_div, #documents_div, #business_description_div, #fiscal_year_end_div, #type_div, #state_div").show();
//            }
//        });

        //click on disable button to re-enable
//
//        $(".internal-data").click(function () {
//            $(".internal-data").html('');
//            $('.office-internal #office').prop('disabled', false);
//            $('#partner').prop('disabled', false);
//            $('#manager').prop('disabled', false);
//            $("#client_association").prop("disabled", false);
//            $("#referred_by_source").prop('disabled', false);
//            $("#referred_by_name").prop("disabled", false);
//            $("#language").prop('disabled', false);
//        });
//        $(".contact-data").click(function () {
//            $(".contact-data").html('');
//            $(".contactedit").removeClass('dcedit');
//            $(".contactdelete").removeClass('dcdelete');
//        });
//        $(".owner-data").click(function () {
//            $(".owner-data").html('');
//            $(".owneredit").removeClass('doedit');
//            $(".ownerdelete").removeClass('dodelete');
//        });
//        $(".company-data").click(function () {
//            $(".company-data").html('');
//            $("#type").prop('disabled', false);
//        });

        //click on disable button to re-enable
    });  //end document.ready

    function monthDiff(start_date, end_date, return_data) {
        var base_url = $('#baseurl').val();
        $.ajax({
            type: "POST",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            url: base_url + 'Services/AccountingServices/get_month_diff',
            //            dataType: "html",
            success: function (result) {
                return_data(result);
            }
        });
    }

//    function set_company_type(reference_id) { //setCompanyType
//        $.ajax({
//            type: "POST",
//            data: {
//                reference_id: reference_id
//            },
//            url: base_url + 'services/accounting_services/get_company_data',
//            dataType: "html",
//            success: function (result) {
//                if (result != 0) {
//                    var res = JSON.parse(result);
//                    console.log(res);
//                    $("#type").val(res.type);
//                    $("#type").prop('disabled', true);
//                    //               $(".company-data").html('<a href="javascript:void(0);" value="0">Edit Company Data</a>');
//                }
//            }
//        });
//    }
//
//    function set_state_of_incorporation(reference_id) { //setStateOfIncorporation
//        $.ajax({
//            type: "POST",
//            data: {reference_id: reference_id},
//            url: base_url + 'services/accounting_services/get_company_data',
//            dataType: "html",
//            success: function (result) {
//                //alert(result);
//                if (result != 0) {
//                    var res = JSON.parse(result);
//                    if (res.state_opened != null && res.state_opened != 0) {
//                        $("#state").val(res.state_opened);
//                        $("#state").prop('disabled', true);
//                    } else {
//                        $("#state").val("");
//                        $("#state").prop('disabled', true);
//                    }
//                    //               $(".company-data").html('<a href="javascript:void(0);" value="0">Edit Company Data</a>');
//                }
//            }
//        });
//    }
//
//    function set_internal_data(reference_id) { //setInternaldata
//        var partner_id = '';
//        var manager_id = '';
//        $.ajax({
//            type: "POST",
//            data: {reference: 'company', reference_id: reference_id},
//            url: base_url + 'services/accounting_services/get_internal_data',
//            dataType: "html",
//            success: function (result) {
//                if (result != 0) {
//                    var res = JSON.parse(result);
//                    console.log(res);
//
//                    $(".office-internal #office").val(res.office);
//                    load_partner_manager_ddl(res.office, res.partner, res.manager);
//                    //$("#partner").val(res.partner);
//                    //$("#manager").val(res.manager);
//                    $("#client_association").val(res.client_association);
//                    $("#referred_by_source").val(res.referred_by_source);
//                    $("#referred_by_name").val(res.referred_by_name);
//                    $("#language").val(res.language);
//
//                    //               $(".internal-data").html('<a href="javascript:void(0);" value="0">Edit Internal Data</a>');
//                    //               $(".contact-data").html('<a href="javascript:void(0);" value="0">Edit Contact</a>');
//                    $(".contactedit").addClass('dcedit');
//                    $(".contactdelete").addClass('dcdelete');
//                    //               $(".owner-data").html('<a href="javascript:void(0);" value="0">Edit Owner</a>');
//                    $(".owneredit").addClass('doedit');
//                    $(".ownerdelete").addClass('dodelete');
//                    $('.office-internal #office').prop('disabled', true);
//                    $('#partner').prop('disabled', true);
//                    $('#manager').prop('disabled', true);
//                    $("#client_association").prop("disabled", true);
//                    $("#referred_by_source").prop('disabled', true);
//                    $("#referred_by_name").prop("disabled", true);
//                    $("#language").prop('disabled', true);
//
//                } else {
//                    //                  $(".internal-data").html('');
//                    //                  $(".contact-data").html('');
//                    $(".contactedit").removeClass('dcedit');
//                    $(".contactdelete").removeClass('dcdelete');
//                    //                   $(".owner-data").html('');
//                    $(".owneredit").removeClass('doedit');
//                    $(".ownerdelete").removeClass('dodelete');
//                    $('.office-internal #office').prop('disabled', false);
//                    $('#partner').prop('disabled', false);
//                    $('#manager').prop('disabled', false);
//                    $("#client_association").prop("disabled", false);
//                    $("#referred_by_source").prop('disabled', false);
//                    $("#referred_by_name").prop("disabled", false);
//                    $("#language").prop('disabled', false);
//                }
//            }
//        });
//    }

    function checkConfirmation()
    {
        if ($("#confirmation").prop('checked'))
        {
            $("#confirmation").val("1");
        } else
        {
            $("#confirmation").val("");
        }
    }


    function removeNote(divID)
    {
        $("#" + divID).remove();
    }
    function removeSecq(divID)
    {
        $("#" + divID).remove();
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
