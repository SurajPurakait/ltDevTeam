<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_add_new_prospect">
                        <h3>Add Lead</h3>
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
                        <!-- <div class="form-group">
                            <label class="col-lg-2 control-label">Type of Contact
                                <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select required class="form-control" title="Type of Contact" name="type_of_contact">
                                    <?php //foreach ($type_of_contact as $value): ?>
                                        <option value="<?//= $value["id"]; ?>"><?//= $value["name"]; ?></option>
                                    <?php //endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div> -->
                        <input type="hidden" value="0" name="type_of_contact">
                         <input type="hidden" value="0" name="mail_campaign_status">
                 <input type="hidden" value="0" name="lead_staff"> 

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
                                    <?php foreach ($states as $value):
                                        if($value['id']!=0){
                                     ?>
                                        <option value="<?= $value["id"]; ?>"><?= $value["state_name"]; ?></option>
                                    <?php } endforeach; ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">ZIP Code</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="zip"
                                       name="zip" zipval="" title="ZIP Code">
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

                        <input type="hidden" title="Lead Source" value="" name="lead_source" value="1" id="lead_source">

                        <input type="hidden" title="Lead Agent" value="" name="lead_agent">
                        <input type="hidden" title="Partner" value="<?= $partner; ?>" name="referred_status">
                        <input type="hidden" title="Date of First Contact" id="date_of_first_contact" value="0000/00/00" name="date_of_first_contact">
                       
                        <div class="hr-line-dashed"></div>

                        <?= note_func('Notes', 'n', 3); ?>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="type" id="type" value="1">
                                <input type="hidden" name="partner_section" value="">
                                <input type="hidden" name="fromval" value="staff_section">
                                <input type="hidden" name="ref_partner_id" value="<?php echo isset($ref_partner_id) ? $ref_partner_id : ''; ?>">
                                <button class="btn btn-success" type="button" onclick="reffer_lead_to_partner('refer_lead')">
                                    Save Changes
                                </button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_lead_to_partner()">
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
    change_type_of_contact(1);
    $(function () {
        $("#lead_source").change(function () {
            var value = $("#lead_source option:selected").text();
            if (value == "Referral Agent") {
                $(".lead-agent-class").show();
            } else {
                $(".lead-agent-class").hide();
            }
        });

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

