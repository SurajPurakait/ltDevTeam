<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_bookkeeping_by_date" onsubmit="request_create_bookkeeping_by_date(); return false;">
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
                                <select class="form-control client_list client_type_field0" name="client_list" id="client_list_ddl" title="Client List" onchange="fetchExistingClientData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);">
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div1" id="name_of_business">
                            <label class="col-lg-2 control-label">Name of Business<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Option 1" id="business_name" class="form-control client_type_field1" type="text" name="name_of_business1" title="Name of Business" >
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
                                <select class="form-control value_field required_field" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list"); ?>
                                </select>
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
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Existing Practice ID</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" name="existing_practice_id" title="Existing Practice ID" value="">
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
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="0" id="retail-price">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="0">
                                <input type="hidden" id="retail-price-initialamt" value="0" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" numeric_valid="" id="retail_price_override" name="retail_price_override" title="Retail Price" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?= service_note_func('Bookkeeping Note', 'n', 'service', "", $service_id); ?>
                        <div class="hr-line-dashed"></div>

                        <h3>Notes</h3>
                        <?= service_note_func('Order Notes', 'n', 'order'); ?>
                        <div class="hr-line-dashed"></div>

                        <label>Payment Options Form</label>
                        <div class="hr-line-dashed"></div>

                        <h3>Confirmation</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirm<span class="text-danger">*</span></label>
                            <div class="col-lg-10 m-t-5">
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
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_bookkeeping">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="">
                                <input type="hidden" name="bookkeeping_sub_cat" id="bookkeeping_sub_cat" value="2">
                                <button class="btn btn-success" type="button" onclick="request_create_bookkeeping_by_date()">Save changes</button> &nbsp;&nbsp;&nbsp;
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
    interval_total_amounts();
    $('#month').datepicker({dateFormat: 'mm/yy'});
    $('#month').attr("onblur", 'checkDate(this);');
    var base_url = document.getElementById('base_url').value;
    clientTypeChange(1, <?= $reference_id; ?>, '<?= $reference; ?>', 1);
    load_service_container(<?= $service_id ?>);
    $(function () {
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
//            if (clientid != '') {
//                delete_contact_list(new_reference_id);
//                delete_owner_list(new_reference_id);
//                set_company_type(clientid);
//                get_contact_list(clientid, 'company', "y");
//                save_contact_list('company', clientid, new_reference_id);
//                reload_owner_list(clientid, 'main');
//                save_owner_list(clientid, new_reference_id);
//                set_internal_data(clientid);
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
////                $("#accounts-list").html('');
//                $("#owners-list").html(blank_owner_list());
//                $(".office-internal #office, #state").val('');
//                $("#partner").val('');
//                $("#manager").val('');
//                $("#client_association").val('');
//                $("#referred_by_source").val('');
//                $("#referred_by_name").val('');
//                $("#language").val('');
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
    }); //end document.ready


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
////               $(".company-data").html('<a href="javascript:void(0);" value="0">Edit Company Data</a>');
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
////               $(".company-data").html('<a href="javascript:void(0);" value="0">Edit Company Data</a>');
//                }
//            }
//        });
//    }
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
////               $(".internal-data").html('<a href="javascript:void(0);" value="0">Edit Internal Data</a>');
////               $(".contact-data").html('<a href="javascript:void(0);" value="0">Edit Contact</a>');
//                    $(".contactedit").addClass('dcedit');
//                    $(".contactdelete").addClass('dcdelete');
////               $(".owner-data").html('<a href="javascript:void(0);" value="0">Edit Owner</a>');
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
////                  $(".internal-data").html('');
////                  $(".contact-data").html('');
//                    $(".contactedit").removeClass('dcedit');
//                    $(".contactdelete").removeClass('dcdelete');
////                   $(".owner-data").html('');
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
</script>
