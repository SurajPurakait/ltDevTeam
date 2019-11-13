<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" id="form_add_new_prospect">
                <div class="ibox-content m-b-20">
                    <a href="<?= base_url() . 'lead_management/home'; ?>" class="btn btn-primary m-r-10 m-b-15">Leads Dashboard</a>
                    <a href="<?= base_url() . 'referral_partner/referral_partners/partners'; ?>" class="btn btn-success m-b-15">Partner Dashboard</a>
                    <h3>Add New Prospect</h3>
                    <div class="form-group" style="display: none;">
                        <label class="col-lg-2 control-label">Event Id</label>
                        <div class="col-lg-10">
                            <?php
                            if (isset($_GET['id'])) {
                                $event_id = $_GET['id'];
                                $event_lead = "event_lead";
                                ?>
                                <input type="text" name="event_id" value="<?php echo $event_id; ?>" class="form-control">
                                <?php
                            } else {
                                $event_lead = "";
                            }
                            ?>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-control" name="office" id="office" onchange="loadStaffDLLValue(this.value, '');" title="Office" required="">
                                <option value="">Select Office</option>
                                <?php load_ddl_option("staff_office_list", "", (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Lead Type<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select required class="form-control" id="lead_type" title="Type of Contact" name="lead_type" onchange="change_type_of_contact(this.value)">
                                <?php foreach ($type_of_leads as $value): ?>
                                    <option value="<?= $value["id"]; ?>"><?= $value["type"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Type of Contact<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select required class="form-control" id="contact_type" title="Type of Contact" name="type_of_contact">                                
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input placeholder="" required class="form-control" nameval="" type="text" id="first_name" name="first_name" title="First Name">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input placeholder="" required class="form-control" nameval="" type="text" id="last_name" name="last_name" title="Last Name">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Company Name</label>
                        <div class="col-lg-10">
                            <input placeholder="" class="form-control" nameval="" type="text" id="company_name" name="company_name" title="Company Name">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Website</label>
                        <div class="col-lg-10">
                            <input placeholder="" class="form-control" type="text" id="website" name="website" title="Website">
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
                            <input placeholder="" class="form-control" nameval="" type="text" id="city" name="city" title="City">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">State</label>
                        <div class="col-lg-10">
                            <select class="form-control" title="State" name="state">
                                <option value="">Select</option>
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
                        <label class="col-lg-2 control-label">Country</label>
                        <div class="col-lg-10">
                            <select class="form-control" title="Country" name="country"> 
                                <!-- onchange="change_zip_by_country(this.value)" -->
                                <option value="">Select</option>
                                <?php
                                foreach ($countries as $value):
                                    if ($value['id'] != 0) {
                                        ?>
                                        <option value="<?= $value["id"]; ?>"><?= $value["country_name"]; ?></option>
                                    <?php } endforeach;
                                ?>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group" id="zip_div">
                        <label class="col-lg-2 control-label">Zip Code</label>
                        <div class="col-lg-10">
                            <input placeholder="" class="form-control" type="text" id="zip" name="zip" zipval="" title="Zip Code">
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
                        <label class="col-lg-2 control-label">Phone 1</label>
                        <div class="col-lg-10">
                            <input placeholder="" class="form-control" type="text" phoneval="" id="phone1" name="phone1" title="Phone 1">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Phone 2</label>
                        <div class="col-lg-10">
                            <input placeholder="" class="form-control" type="text" phoneval="" id="phone2" name="phone2" title="Phone 2">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Email Address
                            <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input placeholder="" required class="form-control" type="email" id="email" name="email" title="Email Address">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Lead Source<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select required class="form-control" title="Lead Source" id="lead_source" onload="LeadSourceTypeChange(this.value);" name="lead_source">
                                <option value="">Select an option</option>
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
                            <select class="form-control" title="Lead Agent" name="lead_agent">
                                <?php foreach ($lead_agents as $value): ?>
                                    <option value="<?= $value["id"]; ?>"><?= $value["first_name"] . ", " . $value["last_name"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>                    

                    <div class="form-group lead-source-detail-class">
                        <label class="col-lg-2 control-label">Lead Source Detail</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" title="Lead Networking" name="lead_source_detail" id="lead_source_detail">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Date of First Contact<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" required title="Date of First Contact" id="date_of_first_contact" name="date_of_first_contact">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <?= note_func('Notes', 'n', 3); ?> 
                    <div class="hr-line-dashed"></div>

                    <div class="form-group mail-campaign-class">
                        <label class="col-lg-2 control-label">Mail Campaign</label>
                        <div class="col-lg-10">
                            <select class="form-control" onchange="document.getElementById('mail_campaign_wrap').style.display = (this.value == '0') ? 'none' : 'block';" title="Mail Campaign" id="mail_campaign_status" name="mail_campaign_status">
                                <option value="0" selected="">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="mail-campaign-wrap" id="mail_campaign_wrap" style="display: none;">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-2 text-center">
                                <div class="newsletter-box" onclick="viewMailCampaignTemplate(getIdVal('lead_type'), getIdVal('language'), 1, getIdVal('first_name'), getIdVal('company_name'), getIdVal('phone1'), getIdVal('email'),getIdVal('contact_type'),getIdVal('office'),getIdVal('date_of_first_contact'),getIdVal('lead_source'),getIdVal('lead_source_detail'));" data-toggle="modal">
                                    <img src="<?= base_url() . "assets/img/newsletter_day_0.jpg"; ?>"/>
                                    <!-- <div class="newsletter-overlay overlay-bg1">Day 0</div> -->
                                </div> 
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="newsletter-box" onclick="viewMailCampaignTemplate(getIdVal('lead_type'), getIdVal('language'), 2, getIdVal('first_name'), getIdVal('company_name'), getIdVal('phone1'), getIdVal('email'),getIdVal('contact_type'),getIdVal('office'),getIdVal('date_of_first_contact'),getIdVal('lead_source'),getIdVal('lead_source_detail'));" data-toggle="modal">
                                    <img src="<?= base_url() . "assets/img/newsletter_day_3.jpg"; ?>"/>
                                    <!-- <div class="newsletter-overlay overlay-bg2">Day 3</div> -->
                                </div> 
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="newsletter-box" onclick="viewMailCampaignTemplate(getIdVal('lead_type'), getIdVal('language'), 3, getIdVal('first_name'), getIdVal('company_name'), getIdVal('phone1'), getIdVal('email'),getIdVal('contact_type'),getIdVal('office'),getIdVal('date_of_first_contact'),getIdVal('lead_source'),getIdVal('lead_source_detail'));" data-toggle="modal">
                                    <img src="<?= base_url() . "assets/img/newsletter_day_6.jpg"; ?>"/>
                                    <!-- <div class="newsletter-overlay overlay-bg3">Day 6</div> -->
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <input type="hidden" name="type" id="type" value="1">
                            <input type="hidden" name="partner_section" value="">
                            <input type="hidden" name="referred_status" value="">
                            <!-- <button class="btn btn-success" type="button" onclick="add_lead_prospect('notrefagent','<?= $event_lead ?>')">Save Changes</button> &nbsp;&nbsp;&nbsp; -->
                            <button class="btn btn-success" type="button" onclick="confirm_sender_email('notrefagent', '<?= $event_lead ?>')">Save Changes</button> &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-default" type="button" onclick="cancel_lead_prospect('notrefagent')">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mail-campaign-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirm Sender's Email</h4>
            </div>
            <form method="post" onsubmit="return false;">
                <div id="email-modal-body" class="modal-body">
                    <?php 
                        $user_details = staff_info();
                    ?>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="sender_email" checked onchange="document.getElementById('other_email').style.display = 'none';" value="<?= $user_details['user']; ?>"><b><?= $user_details['user']; ?></b>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" id="other_email_radio" name="sender_email" onchange="document.getElementById('other_email').style.display = 'block';this.value = document.getElementById('other_email').value;"><b>Other</b>
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="other_email" id="other_email" onblur="document.getElementById('other_email_radio').value = this.value;" style="display: none" class="form-control" placeholder="Enter Email">    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="add_lead_prospect('notrefagent', '<?= $event_lead ?>');">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="mail-campaign-template-modal" class="modal fade newsletter-sec" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mail Campaign Template Review</h4>
            </div>
            <div class="modal-body">
                <!--<table style="width:100%; border-collapse:collapse; font-size: 15px; font-family: arial; " border="0" cellpadding="0" cellspacing="0">
                    <tr style="background: #fff">
                        <td style="padding-bottom: 10px">
                            <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align: left; padding-left: 60px; padding-top: 55px; background: #fff; width: 200px;">
                                        <img src="<?= base_url() . "assets/img/logo.png"; ?>" alt="site-logo" style="width: 200px;">
                                    </td>
                                    <td style="background-image: url('<?= base_url() . "assets/img/top-bg.png"; ?>'); background-repeat: no-repeat; background-position: right; background-size: 242px">
                                        <p style="color: #667581; font-style: italic; text-align: right; padding-right: 65px; padding-top: 65px;">January 10, 2019</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="background: #fff">
                        <td style="padding: 0px">
                            <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align: left; padding: 40px 60px 0 60px;">
                                        <p style="color: #52565a; font-size: 18px;"><strong id="mail-subject"></strong></p>
                                        <p style="color: #52565a; font-size: 16px; line-height: 22px;" id="mail-body"></p>
                                        <p style="color: #52565a; padding-top: 20px; font-size: 18px;"><strong>Thanks, <br/>Team LeafNet</strong></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="background: #fff">
                        <td>
                            <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background-image: url('<?= base_url() . "assets/img/bottom-left-bg.png"; ?>'); background-repeat: no-repeat; background-position: left; background-size: 242px; width: 350px; height: 176px;">
                                        <img src="<?= base_url() . "assets/img/ambulance.png"; ?>" style="padding-left: 60px;"/>
                                    </td>
                                    <td style="background-image: url('<?= base_url() . "assets/img/bottom-right-bg.png"; ?>'); background-repeat: no-repeat; background-position: right; background-size: 242px">
                                        <p style="color: #9dabb6; text-align: left; font-size: 14px;">&COPY; 2019 taxleaf.com</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>-->
                <table  border="0" align="center" cellpadding="0" cellspacing="10" style="border:10px solid #8ab645;width:100%; background:#8ab645;padding: 15px;border-collapse:collapse; ">
                    <tr>
                        <td>
                            <table  border="0" align="center" cellpadding="0" cellspacing="0" style="width:100%;">
                                <tr>
                                    <td style="background: #fff">
                                        <img src="http://www.taxleaf.com/Email/header.gif" width="300" height="98" />
                                    </td>
                                </tr>
                            </table>
                            <table  border="0" cellspacing="0" cellpadding="0" style="width:100%;">
                                <tr>
                                    <td>
                                        <img src="http://www.taxleaf.com/Email/divider2.gif" width="100%" height="30" />
                                    </td>
                                </tr>
                            </table>
                            <table   border="0" align="center" cellpadding="0" cellspacing="15" style="width:100%; background: #ffffff;margin-top: 5px">
                                <tr>
                                    <td valign="top" style="color:#000;padding: 15px" class="textoblanco" style="padding: 15px"><p><span class="textonegro"><strong>
                                        </strong><p id="mail-body"></p></span></p>    
                                    </td>
                                </tr>
                            </table></td>
                    </tr>
                    <tr>
                        <td height="50" valign="top">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    change_type_of_contact(1);
    LeadSourceTypeChange(1);
    loadStaffDLLValue(getIdVal('office'), '');
    $(function () {
        $("#lead_source").change(function () {
            var value = $("#lead_source").val();
            if (value == "7") {
                $(".lead-client-class").show();
                $(".lead-agent-class").hide();

            } else if (value == "5") {
                $(".lead-client-class").hide();
                $(".lead-agent-class").show();


            } else if (value == "8") {
                $("lead-client-class, .lead-agent-class").hide();
                $(".lead-staff-div").show();
            } else {
                $(".lead-client-class").hide();
                $(".lead-agent-class").hide();
                $(".lead-staff-div").hide();
            }
        });
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
