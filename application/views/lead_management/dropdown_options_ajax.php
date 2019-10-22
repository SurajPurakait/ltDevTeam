<?php if (!empty($check_if_mail_exists)) { ?>
    <?php if ($ddval == 1) { ?>                           
        <div class="form-group">
            <!-- <label class="col-lg-2 control-label">Service<span class="text-danger">*</span></label> -->
            <label class="col-lg-2 control-label">Lead Type<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <!-- <select required class="form-control" title="Service" id="service" onchange="changeoptions(1);" name="service"> -->
                    <select required class="form-control" title="Lead Type" id="leadtype" onchange="changeoptions(1);" name="leadtype">
                    <option value="">Select</option>
                    <?php
                    foreach ($type_of_contact as $value):
                        if ($value['id'] != $check_if_mail_exists['lead_type']) {
                            ?>
                            <option value="<?= $value["id"]; ?>"><?= $value["type"]; ?></option>
            <?php } endforeach; ?>
                </select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <select required class="form-control" id="language" onchange="changeoptions(2);" name="language">
                    <option value="">Select</option>
        <?php foreach ($languages as $value):
            if ($value['id'] != 4) {
                ?>
                            <option <?php echo ($language==$value["id"]) ? 'selected' : ''; ?> value="<?= $value["id"]; ?>"><?= $value["language"]; ?></option>
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
        <?php foreach ($day_array as $key => $value):
            ?>
                        <option <?php echo ($day==$key) ? 'selected' : ''; ?> value="<?= $key; ?>"><?= $value; ?></option>
        <?php endforeach; ?>
                </select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
    <?php } elseif ($ddval == 2) { ?>
    <div class="form-group">
            <!-- <label class="col-lg-2 control-label">Service<span class="text-danger">*</span></label> -->
            <label class="col-lg-2 control-label">Lead Type<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <!-- <select required class="form-control" title="Service" id="service" onchange="changeoptions(1);" name="service"> -->
                    <select required class="form-control" title="Lead Type" id="leadtype" onchange="changeoptions(1);" name="leadtype">
                    <option value="">Select</option>
        <?php foreach ($type_of_contact as $value):
            ?>
                        <option <?php echo ($leadtype==$value["id"]) ? 'selected' : ''; ?> value="<?= $value["id"]; ?>"><?= $value["type"]; ?></option>
        <?php endforeach; ?>
                </select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <select required class="form-control" id="language" onchange="changeoptions(2);" name="language">
                    <option value="">Select</option>
                    <?php foreach ($languages as $value):
                        if ($value['id'] != 4 || $value['id'] != $check_if_mail_exists['language']) {
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
        <?php foreach ($day_array as $key => $value):
            ?>
                        <option <?php echo ($day==$key) ? 'selected' : ''; ?> value="<?= $key; ?>"><?= $value; ?></option>
        <?php endforeach; ?>
                </select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
        <?php } else { ?>
        <div class="form-group">
            <!-- <label class="col-lg-2 control-label">Service<span class="text-danger">*</span></label> -->
            <label class="col-lg-2 control-label">Lead Type<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <!-- <select required class="form-control" title="Service" id="service" onchange="changeoptions(1);" name="service"> -->
                    <select required class="form-control" title="Lead Type" id="leadtype" onchange="changeoptions(1);" name="leadtype">
                    <option value="">Select</option>
        <?php foreach ($type_of_contact as $value):
            ?>
                        <option <?php echo ($leadtype==$value["id"]) ? 'selected' : ''; ?> value="<?= $value["id"]; ?>"><?= $value["type"]; ?></option>
        <?php endforeach; ?>
                </select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <select required class="form-control" id="language" onchange="changeoptions(2);" name="language">
                    <option value="">Select</option>
        <?php foreach ($languages as $value):
            if ($value['id'] != 4) {
                ?>
                            <option <?php echo ($language==$value["id"]) ? 'selected' : ''; ?> value="<?= $value["id"]; ?>"><?= $value["language"]; ?></option>
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
                    <?php
                    foreach ($day_array as $key => $value):
                        if ($key != $check_if_mail_exists['type']) {
                            ?>
                            <option value="<?= $key; ?>"><?= $value; ?></option>
            <?php } endforeach; ?>
                </select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>                          
        <div class="form-group">
            <!-- <label class="col-lg-2 control-label">Service<span class="text-danger">*</span></label> -->
            <label class="col-lg-2 control-label">Lead Type<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <!-- <select required class="form-control" title="Service" id="service" onchange="changeoptions(1);" name="service"> -->
                    <select required class="form-control" title="Lead Type" id="leadtype" onchange="changeoptions(1);" name="leadtype">
                    <option value="">Select</option>
        <?php foreach ($type_of_contact as $value):
            ?>
                        <option <?php echo ($leadtype==$value["id"]) ? 'selected' : ''; ?> value="<?= $value["id"]; ?>"><?= $value["type"]; ?></option>
        <?php endforeach; ?>
                </select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <select required class="form-control" id="language" onchange="changeoptions(2);" name="language">
                    <option value="">Select</option>
        <?php foreach ($languages as $value):
            if ($value['id'] != 4) {
                ?>
                            <option <?php echo ($language==$value["id"]) ? 'selected' : ''; ?> value="<?= $value["id"]; ?>"><?= $value["language"]; ?></option>
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
        <?php foreach ($day_array as $key => $value):
            ?>
                        <option <?php echo ($day==$key) ? 'selected' : ''; ?> value="<?= $key; ?>"><?= $value; ?></option>
        <?php endforeach; ?>
                </select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
    <?php } ?>