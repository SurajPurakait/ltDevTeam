<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_save_lead_mail" onsubmit="save_lead_mail_campaign(); return false;">
                        <h3>Mail Content</h3>
                        <div class="ajaxsection">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Service<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select required class="form-control" onchange="changeoptions(1);" title="Service" name="service" id="service">
                                        <option value="">Select</option>
                                        <?php foreach ($type_of_contact as $value): ?>
                                            <option <?php echo ($edit_lead_mail_chain_content['service'] == $value["id"]) ? 'selected' : ''; ?> value="<?= $value["id"]; ?>"><?= $value["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select required class="form-control" onchange="changeoptions(2);" id="language" name="language" title="Language">
                                        <option value="">Select</option>
                                        <?php
                                        foreach ($languages as $value):
                                            if ($value['id'] != 4) {
                                                ?>
                                                <option <?php echo ($edit_lead_mail_chain_content['language'] == $value["id"]) ? 'selected' : ''; ?> value="<?= $value["id"]; ?>"><?= $value["language"]; ?></option>
                                            <?php } endforeach; ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php $day_array = array('1' => 'Day 0', '2' => 'Day 3', '3' => 'Day 6'); ?>
                                <label class="col-lg-2 control-label">Day<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select required class="form-control" onchange="changeoptions(3);" title="Day" name="day" id="day">
                                        <option value="">Select</option>
                                        <?php foreach ($day_array as $key => $value): ?>
                                            <option <?php echo ($edit_lead_mail_chain_content['type'] == $key) ? 'selected' : ''; ?> value="<?= $key; ?>"><?= $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Subject<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Subject" id="lead_subject" required class="form-control" type="text" name="subject" title="Subject" value="<?php echo $edit_lead_mail_chain_content['subject']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Body<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <!--<div class="summernote" required="" id="lead_body" name="body" title="Body"><?php echo urldecode($edit_lead_mail_chain_content['body']); ?></div>-->
                                <textarea rows="12" class="form-control" required="" id="lead_body" name="body" title="Body" placeholder="Body"><?php echo urldecode($edit_lead_mail_chain_content['body']); ?></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Status</label>
                            <div class="col-lg-10">
                                <input type="checkbox" id="check-onoff" <?php echo ($edit_lead_mail_chain_content['status'] == 1) ? 'checked' : ''; ?> name="checkonoff" value="<?php echo $edit_lead_mail_chain_content['status']; ?>">
                            </div>
                        </div>
                        <input type="hidden" name="hidden_onoff" id="hidden_onoff" value="<?php echo $edit_lead_mail_chain_content['status']; ?>">
                        <input type="hidden" name="email_id" value="<?php echo $edit_lead_mail_chain_content['id']; ?>">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success" type="button" onclick="save_lead_mail_campaign()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_save_lead_mail_campaign()">Cancel</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // parameter which dropdown 1,2,3
    function changeoptions(ddval) {
        var service = $("#service option:selected").val();
        var language = $("#language option:selected").val();
        var day = $("#day option:selected").val();
        $.ajax({
            type: "POST",
            data: {service: service, language: language, day: day, ddval: ddval},
            url: base_url + 'lead_management/lead_mail/change_dropdown_options',
            success: function (result) {
                //alert(result); return false;
                if (result.trim() != "0") {
                    $(".ajaxsection").html(result);
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

    $(document).ready(function () {
        //setInterval(changeoptions,1000);
        $('#check-onoff').bootstrapToggle();
        $('#check-onoff').change(function () {
            var togval = $(this).val();
            if (togval == 1) {
                $(this).val(0);
                $("#hidden_onoff").val(0);
            } else {
                $(this).val(1);
                $("#hidden_onoff").val(1);
            }
        });
    });

</script>