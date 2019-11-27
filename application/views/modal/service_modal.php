<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Service</h3>
            </div>
            <form role="form" id="add-services-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Service Category</label>
                        <select title="Service Category" class="form-control chosen-select" name="servicecat" id="servicecat" onchange="get_related_services('');" required>
                            <?php
                            if (!empty($categories)) {
                                foreach ($categories as $value) {
                                    ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Service Name<span class="text-danger">*</span></label>
                        <input title="Service Name" class="form-control" type="text" onkeyup="generate_shortcode();" name="servicename" id="servicename" required>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label>Service Shortname</label>
                        <input title="Service Shortname" class="form-control" type="text" name="servicesn" id="servicesn" value="" disabled>
                        <input type="hidden" name="shorthidden" id="shorthidden">
                    </div>
                    <div class="form-group">
                        <label>Fixed Cost<span class="text-danger">*</span></label>
                        <input title="Fixed Cost" class="form-control" type="text" name="fixedcost" id="fixedcost" required phoneval>
                        <!-- <span>&#36;</span>  -->
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Retail Price<span class="text-danger">*</span></label>
                        <input title="Retail Price" class="form-control" type="number" name="retailprice" id="retailprice" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Target For Start(days)<span class="text-danger">*</span></label>
                        <input title="Target For Start(days)" class="form-control" type="number" name="startdays" id="startdays" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Target For Completion(days)<span class="text-danger">*</span></label>
                        <input title="Target For Completion(days)" class="form-control" type="number" name="enddays" id="enddays" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Input Form<span class="text-danger">*</span></label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="y" type="radio" id="inputform1" name="input_form" required="" title="Input Form"> Yes
                        </label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="n" type="radio" id="inputform2" name="input_form" required="" title="Input Form"> No
                        </label>
                        <div class="errorMessage text-danger" id="input_form_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Select Department</label>
                        <select id="dept" name="dept" class="form-control" title="Department" required>
                            <?php
                            if (!empty($department_list)) {
                                foreach ($department_list as $key => $value) {
                                    if ($value['id'] != 1 && $value['id'] != 2) {
                                        ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Related Services</label>
                        <select title="Related Services" class="form-control" id="relatedserv" name="relatedserv" multiple="multiple">
                            <option value=""></option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea class="form-control" name="note" id="note"></textarea>
                    </div>                           

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
                    <button type="button" class="btn btn-primary" onclick="addRelatedservice()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function () {
            get_related_services("", "");
            generate_shortcode();
        });
    </script>

<?php else: ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Edit Service</h3>
            </div>
            <form role="form" id="edit-services-form">
                <div class="modal-body">
                    <input type="hidden" value="<?= $service_info["id"]; ?>" name="service_id" id="service_id">
                    <div class="form-group">
                        <label>Service Category</label>
                        <select title="Service Category" class="form-control chosen-select" name="servicecat" id="servicecat" onchange="get_related_services('<?= $service_info["related_services"]; ?>')" required>
                            <?php
                            if (!empty($categories)) {
                                foreach ($categories as $value) {
                                    ?>
                                    <option value="<?= $value['id']; ?>" <?= ($service_info["catid"] == $value["id"]) ? "selected" : ""; ?>><?= $value['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Service Name</label>
                        <input title="Service Name" class="form-control" type="text" name="servicename" id="servicename" value="<?= $service_info["servicename"]; ?>" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Service Shortname</label>
                        <input title="Service Shortname" class="form-control" type="text" name="servicesn" id="servicesn" value="<?php echo $service_info['ideas']; ?>" disabled>
                        <input type="hidden" name="shorthidden" id="shorthidden" value="<?php echo $service_info['ideas']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Fixed Cost<span class="text-danger">*</span></label>
                        <input title="Fixed Cost" class="form-control" type="text" name="fixedcost" id="fixedcost" value="<?= $service_info["fixedcost"]; ?>" required phoneval>
                        <!-- <span>&#36;</span>  -->
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Retail Price</label>
                        <input title="Retail Price" class="form-control" type="number" name="retailprice" id="retailprice" value="<?= $service_info["price"]; ?>" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Target For Start(days)</label>
                        <input title="Target For Start(days)" class="form-control" type="number" name="startdays" id="startdays" value="<?= $service_info["start_days"]; ?>" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Target For Completion(days)</label>
                        <input title="Target For Completion(days)" class="form-control" type="number" name="enddays" id="enddays" value="<?= $service_info["end_days"]; ?>" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Input Form<span class="text-danger">*</span></label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="y" type="radio" id="inputform1" name="input_form" required="" title="Input Form" <?= ($service_info["input_form"] == 'y') ? 'checked' : ''; ?>> Yes
                        </label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="n" type="radio" id="inputform2" name="input_form" required="" title="Input Form" <?= ($service_info["input_form"] == 'n') ? 'checked' : ''; ?>> No
                        </label>
                        <div class="errorMessage text-danger" id="input_form_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Select Department</label>
                        <select id="dept" name="dept" class="form-control" title="Department" required>
                            <?php
                            if (!empty($department_list)) {
                                foreach ($department_list as $key => $value) {
                                    if ($value['id'] != 1 && $value['id'] != 2){
                                    ?>
                                    <option value="<?= $value['id']; ?>" <?= ($service_info["department"] == $value["id"]) ? "selected" : ""; ?>><?= $value['name']; ?></option>
                                    <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Related Services</label>
                        <select title="Related Services" class="form-control" id="relatedserv" name="relatedserv" multiple="multiple">
                            <option value=""></option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea class="form-control" name="note" id="note"><?php echo $service_info['note'] ?></textarea>
                    </div>                        

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
                    <button type="button" class="btn btn-primary" onclick="updateRelatedservice()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function () {
            get_related_services('<?= $service_info["related_services"]; ?>', '<?= $service_info["id"]; ?>');
        });
    </script>

<?php endif; ?>
