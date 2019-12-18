<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <hr>
                    <div class="filters">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <!-- <select class="form-control" title="Service" id="service" name="service"> -->
                                        <select class="form-control" title="Lead Type" id="leadtype" name="leadtype">
                                        <option value="">Select Lead Type</option>
                                        <?php foreach ($type_of_contact as $value): ?>
                                            <option value="<?= $value["id"]; ?>"><?= $value["type"]; ?></option>
                                        <?php endforeach; ?>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control" id="language" name="language" title="Language">
                                        <option value="">Select Language</option>
                                        <?php
                                        foreach ($languages as $value):
                                            if ($value['id'] != 4 && $value['id'] != 5) {
                                                ?>
                                                <option value="<?= $value["id"]; ?>"><?= $value["language"]; ?></option>
                                            <?php } endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php $day_array = array('1' => 'Day 0', '2' => 'Day 3', '3' => 'Day 6'); ?>
                                    <select class="form-control" title="Day" name="day" id="day">
                                        <option value="">Select Day</option>
                                        <?php foreach ($day_array as $key => $value): ?>
                                            <option value="<?= $key; ?>"><?= $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control" id="status" name="status" title="Status">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="dropdown pull-right">
                                <a class="btn btn-primary" href="<?= base_url("/lead_management/lead_mail/add_mail_campaign"); ?>"><i class="fa fa-plus"></i> Add Email</a>
                            </div>
                        </div>
                    </div>   
                    <hr class="hr-line-dashed">
                    <div id="load_data"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    load_campaign_mails('', '', '', '');
    $(function () {
        $("#leadtype").change(function () {
            var leadtype = $("#leadtype option:selected").val();
            var language = $("#language option:selected").val();
            var day = $("#day option:selected").val();
            var status = $("#status option:selected").val();
            load_campaign_mails(leadtype, language, day, status);
        });

        $("#language").change(function () {
            var leadtype = $("#leadtype option:selected").val();
            var language = $("#language option:selected").val();
            var day = $("#day option:selected").val();
            var status = $("#status option:selected").val();
            load_campaign_mails(leadtype, language, day, status);
        });

        $("#day").change(function () {
            var leadtype = $("#leadtype option:selected").val();
            var language = $("#language option:selected").val();
            var day = $("#day option:selected").val();
            var status = $("#status option:selected").val();
            load_campaign_mails(leadtype, language, day, status);
        });
        $("#status").change(function () {
            var leadtype = $("#leadtype option:selected").val();
            var language = $("#language option:selected").val();
            var day = $("#day option:selected").val();
            var status = $("#status option:selected").val();
            load_campaign_mails(leadtype, language, day, status);
        });
    });
</script>