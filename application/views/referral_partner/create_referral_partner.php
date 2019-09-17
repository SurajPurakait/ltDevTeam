<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_add_new_referral">
                        <h3>Add New Referral Partner</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="office" id="office" onchange="loadStaffDLLValue(this.value, '');" title="Office" required="">
                                    <?php load_ddl_option("staff_office_list", "", (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">
                                Type of Contact
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-10">
                                <select required class="form-control" id="contact_type" title="Type of Contact" name="type_of_contact">
                                    <?php foreach ($type_of_contact as $value): ?>
                                        <option value="<?= $value["id"]; ?>"><?= $value["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" required class="form-control" nameval="" type="text" id="first_name"
                                       name="first_name" title="First Name">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" required class="form-control" nameval="" type="text" id="last_name"
                                       name="last_name" title="Last Name">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Company Name</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" nameval="" type="text" id="company_name"
                                       name="company_name" title="Company Name">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Address</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="address" name="address" title="Address"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">City</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" nameval="" type="text" id="city" name="city"
                                       title="City">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">State</label>
                            <div class="col-lg-10">
                                <select class="form-control" title="State" name="state">
                                    <option value="">Select..</option>
                                    <?php
                                    foreach ($states as $value):
                                        if ($value['id'] != 0) {
                                            ?>
                                            <option value="<?= $value["id"]; ?>"><?= $value["state_name"]; ?></option>
                                        <?php } endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Zip Code</label>
                            <div class="col-lg-10">
                                <input placeholder="" zipval="" class="form-control" type="text" id="zip"
                                       name="zip" title="Zip Code">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select required class="form-control" id="language" name="language">
                                    <?php foreach ($languages as $value): ?>
                                        <option value="<?= $value["id"]; ?>"><?= $value["language"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Phone 1<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" required class="form-control" type="text" phoneval="" id="phone1"
                                       name="phone1" title="Phone 1">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Phone 2</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" phoneval="" id="phone2" name="phone2"
                                       title="Phone 2">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Email Address
                                <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" required class="form-control" type="email" id="email"
                                       name="email" title="Email Address">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Lead Source<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select required class="form-control" title="Lead Source" id="lead_source" name="lead_source" onload="LeadSourceTypeChange(this.value);">
                                    <?php foreach ($lead_source as $value): ?>
                                        <option value="<?= $value["id"]; ?>"><?= $value["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group lead-staff-div" style="display: none;">
                            <label class="col-lg-2 control-label">Lead Staff</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="lead_staff" id="lead_staff" title="Lead Staff">
                                    <option value="">Select an option</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group lead-agent-class" style="display:none;">
                            <label class="col-lg-2 control-label">Lead Agent</label>
                            <div class="col-lg-10">
                                <select class="form-control" id="lead_agent" title="Lead Agent" name="lead_agent">
                                    <?php foreach ($lead_agents as $value): ?>
                                        <option value="<?= $value["id"]; ?>"><?= $value["first_name"] . " " . $value["last_name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group lead-source-detail-class">
                            <label class="col-lg-2 control-label">Lead Source Detail</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" title="Lead Networking" name="lead_source_detail">
                            </div>
                        </div>
                        <!--                        <div class="form-group lead-client-class" style="display:none;">
                                                    <label class="col-lg-2 control-label">Lead Client</label>
                                                    <div class="col-lg-10">
                                                      <input type="text" name="lead_client" id="lead_client" class="form-control" >
                                                    </div>
                                                </div>
                                                <div class="form-group lead-client-class-other" style="display:none;">
                                                    <label class="col-lg-2 control-label">Other</label>
                                                    <div class="col-lg-10">
                                                      <input type="text" name="lead_client_other" id="lead_client_other" class="form-control" >
                                                    </div>
                                                </div>-->

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Date of First Contact<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text"
                                       required title="Date of First Contact" id="date_of_first_contact"
                                       name="date_of_first_contact">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <!-- <div class="hr-line-dashed"></div> -->

                        <!-- <?//= note_func('Notes', 'n', 3); ?>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group mail-campaign-class">
                            <label class="col-lg-2 control-label">Mail Campaign</label>
                            <div class="col-lg-10">
                                <select class="form-control" title="Mail Campaign" onchange="document.getElementById('mail_campaign_wrap').style.display = (this.value == '0') ? 'none' : 'block';" name="mail_campaign_status">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="mail-campaign-wrap" id="mail_campaign_wrap" style="display: none;">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-2 text-center">
                                    <div class="newsletter-box" onclick="viewMailCampaignTemplate(getIdVal('contact_type'), getIdVal('language'), 1, getIdVal('first_name'), getIdVal('company_name'), getIdVal('phone1'), getIdVal('email'));" data-toggle="modal">
                                        <img src="<?//= base_url() . "assets/img/newsletter.jpg"; ?>"/>
                                        <div class="newsletter-overlay overlay-bg1">Day 0</div>
                                    </div> 
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="newsletter-box" onclick="viewMailCampaignTemplate(getIdVal('contact_type'), getIdVal('language'), 2, getIdVal('first_name'), getIdVal('company_name'), getIdVal('phone1'), getIdVal('email'));" data-toggle="modal">
                                        <img src="<?//= base_url() . "assets/img/newsletter.jpg"; ?>"/>
                                        <div class="newsletter-overlay overlay-bg2">Day 3</div>
                                    </div> 
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="newsletter-box" onclick="viewMailCampaignTemplate(getIdVal('contact_type'), getIdVal('language'), 3, getIdVal('first_name'), getIdVal('company_name'), getIdVal('phone1'), getIdVal('email'));" data-toggle="modal">
                                        <img src="<?//= base_url() . "assets/img/newsletter.jpg"; ?>"/>
                                        <div class="newsletter-overlay overlay-bg3">Day 6</div>
                                    </div> 
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="hr-line-dashed"></div> -->

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="type" id="type" value="2">
                                <input type="hidden" name="partner_section" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : ''; ?>">
                                <button class="btn btn-success" type="button" onclick="add_lead_referral('partner')">
                                    Save Changes
                                </button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_lead_prospect()">
                                    Cancel
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    loadStaffDLLValue(getIdVal('office'), '');
    $(function () {

        $("#lead_source").change(function () {
            var value = $("#lead_source").val();
            if (value == "7") {
                $(".lead-client-class").show();
                $(".lead-agent-class").hide();
                $(".lead-client-class-other").hide();

            } else if (value == "5") {
                $(".lead-client-class").hide();
                $(".lead-client-class-other").hide();
                $(".lead-agent-class").show();


            } else if (value == "6") {
                $(".lead-client-class").hide();
                $(".lead-agent-class").hide();
                $(".lead-client-class-other").show();

            } else {
                $(".lead-client-class").hide();
                $(".lead-agent-class").hide();
                $(".lead-client-class-other").hide();
            }
        });


//        $("#lead_source").change(function () {
//            var value = $("#lead_source option:selected").text();
//            if (value == "Referral Agent") {
//                $(".lead-agent-class").show();
//                $(".lead-client-class").hide();
//                
//            } else {
//                $(".lead-agent-class").hide();
//            }
//        });

        // $('.add-note').click(function () {
        //     var textnote = $(this).prev('.note-textarea').html();
        //     var note_label = $(this).parent().parent().find("label").html();
        //     var div_count = Math.floor((Math.random() * 999) + 1);
        //     var newHtml = '<div class="form-group" id="note_div' + div_count + '"><label class="col-lg-2 control-label">' + note_label + '</label><div class="col-lg-10">' + textnote + '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a></div></div>';
        //     $(newHtml).insertAfter($(this).closest('.form-group'));
        // });

        $("#date_of_first_contact").datepicker({
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: 'mm/dd/yyyy',
            autoHide: true
        });
        $("#date_of_first_contact").attr("onblur", 'checkDate(this);');
    });

    function removeNote(divID) {
        $("#" + divID).remove();
    }

</script>

