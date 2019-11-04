<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="edit_lead_prospect">
                        <h3>Edit Prospect</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="office" id="office" onchange="loadStaffDLLValue(this.value, '');" title="Office" required="">
                                    <option value="">Select Office</option>
                                    <?php load_ddl_option("staff_office_list", $data["office"], (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Partner Lead Type<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select required class="form-control" id="lead_type" title="Type of Contact" name="lead_type">
                                        <option value="1" <?= ($data['type'] == '1') ? 'selected':''; ?>>Client</option>
                                        <option value="2" <?= ($data['type'] == '3') ? 'selected':''; ?>>Partner</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Type of Contact
                                <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select required class="form-control" title="Type of Contact" name="type_of_contact">
                                    <?php foreach ($type_of_contact as $value): ?>
                                        <option value="<?= $value["id"]; ?>" <?= ($value["id"] == $data["type_of_contact"]) ? "selected" : ""; ?>><?= $value["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" required class="form-control" nameval="" type="text" id="first_name"  name="first_name" title="First Name" value="<?= $data["first_name"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" required class="form-control" nameval="" type="text" id="last_name" name="last_name" title="Last Name" value="<?= $data["last_name"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Company Name</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" nameval="" type="text" id="company_name" name="company_name" title="Company Name" value="<?= $data["company_name"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Address</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="address" name="address" title="Address"><?= $data["address"]; ?></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

<!--                         <div class="form-group">
                            <label class="col-lg-2 control-label">City</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" nameval="" type="text" id="city" name="city" title="City" value="<?//= $data["city"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label class="col-lg-2 control-label">State</label>
                            <div class="col-lg-10">
                                <select class="form-control" title="State" name="state">
                                    <?php
                                    foreach ($states as $value):
                                        if ($value['id'] != 0) {
                                            ?>
                                            <option value="<?= $value["id"]; ?>" <?= ($value["id"] == $data["state"]) ? "selected" : ""; ?>><?= $value["state_name"]; ?></option>
                                        <?php } endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Zip code</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="zip" name="zip" zipval="" title="Zip Code" value="<?= $data["zip"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select required class="form-control" id="language" name="language">
                                    <?php foreach ($languages as $value): ?>
                                        <option value="<?= $value["id"]; ?>" <?= ($value["id"] == $data["language"]) ? "selected" : ""; ?>><?= $value["language"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Phone 1<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" required class="form-control" type="text" phoneval="" id="phone1" name="phone1" title="Phone 1" value="<?= $data["phone1"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Phone 2</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" phoneval="" id="phone2" name="phone2"
                                       title="Phone 2" value="<?= $data["phone2"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Email Address
                                <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" required class="form-control" type="email" id="email"
                                       name="email" title="Email Address" value="<?= $data["email"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>                        

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Lead Source<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select required class="form-control" title="Lead Source" id="lead_source" onchange="changeLeadSource(this.value);" name="lead_source">
                                    <option value="">Select an option</option>
                                    <?php foreach ($lead_source as $value): ?>
                                        <option value="<?= $value["id"]; ?>" <?= ($value["id"] == $data["lead_source"]) ? "selected" : ""; ?>><?= $value["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group lead-staff-div">
                            <label class="col-lg-2 control-label">Lead Staff</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="lead_staff" id="lead_staff" title="Lead Staff">
                                    <option value="">Select an option</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>                        

                        <div class="form-group lead-agent-class">
                            <label class="col-lg-2 control-label">Lead Agent</label>
                            <div class="col-lg-10">
                                <select id="lead_agent" class="form-control" title="Lead Agent" name="lead_agent">
                                    <?php foreach ($lead_agents as $value): ?>
                                        <option value="<?= $value["id"]; ?>" <?= ($value["id"] == $data["lead_agent"]) ? "selected" : ""; ?>><?= $value["first_name"] . " " . $value["last_name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group lead-source-detail-class">
                            <label class="col-lg-2 control-label">Lead Source Detail</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" title="Lead Networking" name="lead_source_detail" value="<?php echo $data['lead_source_detail']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Date of First Contacts<span class="text-danger">*</span></label>
                            <?php
                            $date_of_first_contact = date('m/d/Y', strtotime($data['date_of_first_contact']));
                            ?>
                            <div class="col-lg-10">
                                <input class="form-control" type="text"
                                       required title="Date of First Contact" id="date_of_first_contact"
                                       name="date_of_first_contact" value="<?= $date_of_first_contact; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?= note_func('Notes', 'n', 3, 'lead_id', $data['id']); ?>

                        <div class="form-group mail-campaign-class">
                            <label class="col-lg-2 control-label">Mail Campaign</label>
                            <div class="col-lg-10">
                                <select class="form-control" title="Mail Campaign" name="mail_campaign_status" onchange="mail_campaign_status_change(<?= $data['id']; ?>,this.value);">
                                    <option value="0" <?php echo $data['mail_campaign_status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                    <option value="1" <?php echo $data['mail_campaign_status'] == 1 ? 'selected' : '' ?>>Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="type" value="<?= $data['type'] ?>">
                                <button class="btn btn-success" type="button" onclick="edit_lead_prospect('<?= $from_menu; ?>')">Save Changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_lead_prospect()">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    loadStaffDLLValue(getIdVal('office'), '<?= ($data["lead_staff"] != 0) ? $data["lead_staff"] : ''; ?>');
    function changeLeadSource(lead_source_id) {
        if (parseInt(lead_source_id) == 7) {
            $(".lead-agent-class").hide();
            $(".lead-client-class").show();
        } else if (parseInt(lead_source_id) == 5) {
            $(".lead-agent-class").show();
            $(".lead-client-class").hide();
        } else if (parseInt(lead_source_id) == 8) {
            $(".lead-client-class, .lead-agent-class").hide();
            $(".lead-staff-div").show();
        } else {
            $(".lead-client-class").hide();
            $(".lead-agent-class").hide();
            $(".lead-staff-div").hide();
        }
    }
    changeLeadSource(<?= $data["lead_source"]; ?>);
    $(function () {
        lead_source_box();
        $("#lead_source").change(function () {
            lead_source_box();
        });
        // $('.add-note').click(function () {
        //     var textnote = "<textarea required class=\"form-control\" name=\"notes[]\" title=\"Notes\"></textarea>";
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

    function lead_source_box() {
        var value = $("#lead_source option:selected").text();
        if (value == "Referral Agent") {
            $(".lead-agent-class").show();
        } else {
            $(".lead-agent-class").hide();
        }
    }

    function removeNote(divID) {
        $("#" + divID).remove();
    }

    function edit_lead_prospect(from_menu) {

        if (!requiredValidation('edit_lead_prospect')) {
            return false;
        }

        var form_data = new FormData($("#edit_lead_prospect")[0]);

        $.ajax({
            type: "POST",
            data: form_data,
            url: base_url + 'lead_management/edit_lead/edit_lead_prospect_now/<?= $data["id"] ?>',
            dataType: "html",
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            cache: false,
            success: function (result) {
                if (result.trim() == "1") {
                    if (from_menu == 'lead') {
                        swal({title: "Success!", text: "Lead Prospect Successfully Edited!", type: "success"}, function () {
                            goURL(base_url + 'lead_management/home');
                        });
                    } else {
                        swal({title: "Success!", text: "Lead Prospect Successfully Edited!", type: "success"}, function () {
                            goURL(base_url + 'referral_partner/referral_partners/referral_partner_dashboard');
                        });
                    }

                } else if (result.trim() == "-1") {
                    swal("ERROR!", "Unable To Edit Lead Prospect", "error");
                }
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });

    }
</script>

