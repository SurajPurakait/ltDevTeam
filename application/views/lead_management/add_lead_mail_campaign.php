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
                                    <select required class="form-control" title="Service" onchange="changeoptions(1);" id="service" name="service">
                                        <option value="">Select</option>
                                        <?php foreach ($type_of_contact as $value): ?>
                                            <option value="<?= $value["id"]; ?>"><?= $value["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select required class="form-control" id="language" onchange="changeoptions(2);" name="language" title="Language">
                                        <option value="">Select</option>
                                        <?php
                                        foreach ($languages as $value):
                                            if ($value['id'] != 4) {
                                                ?>
                                                <option value="<?= $value["id"]; ?>"><?= $value["language"]; ?></option>
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
                                            <option value="<?= $key; ?>"><?= $value; ?></option>
<?php endforeach; ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div> <!-- end ajaxdiv -->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Subject<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Subject" id="lead_subject" required class="form-control" type="text" name="subject" title="Subject" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Body<span class="text-danger">*</span></label>
                            
                            <div class="col-lg-10">
                                <textarea rows="12" class="form-control" required="" id="lead_body" name="body" title="Body" placeholder="Body"></textarea>
                                <!--<div class="summernote" required="" id="lead_body" name="body" title="Body"></div>-->
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
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
    });
</script>