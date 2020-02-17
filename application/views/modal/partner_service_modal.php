<?php 
    if ($modal_type != "edit") {
?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Partner Service</h3>
            </div>
            <form role="form" id="add-partner-services-form" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Service Category</label>
                        <select title="Service Category" class="form-control chosen-select" name="servicecat" id="servicecat" required>
                            <option value="5">Partner Services</option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Service Name<span class="text-danger">*</span></label>
                        <input title="Service Name" class="form-control" type="text" onkeyup="generate_shortcode();" name="servicename" id="servicename" required>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label>Service Shortname</label>
                        <input title="Service Shortname" class="form-control" type="text" name="servicesn" id="servicesn" value="" disabled>
                        <input type="hidden" name="shorthidden" id="shorthidden">
                    </div>
                    <div class="form-group">
                        <label>Partner Type</label>
                        <select title="Partner Type" class="form-control chosen-select" name="partnertype" id="partnertype" required>
                            <?php
                                foreach ($partners_type_list as $value) {                                
                            ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label>Responsible Assigned<span class="text-danger">*</span></label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="1" type="radio" id="responsible_franchisee" name="responsible_assigned" required="" title="Responsible Assigned" checked=""> Partner
                        </label>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label>Input Form<span class="text-danger">*</span></label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="y" type="radio" id="inputform1" name="input_form" required="" title="Input Form" checked=""> Yes
                        </label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="n" type="radio" id="inputform2" name="input_form" required="" title="Input Form"> No
                        </label>
                        <div class="errorMessage text-danger" id="input_form_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="note" id="note"></textarea>
                    </div>                           

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
                    <button type="button" class="btn btn-primary" onclick="addPartnerService()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function () {
            generate_shortcode();
        });
    </script>
<?php
    } else {
?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Partner Service</h3>
            </div>
            <form role="form" id="edit-partner-services-form" method="POST">
                <div class="modal-body">
                    <input type="hidden" value="<?= $partner_service_info["id"]; ?>" name="service_id" id="service_id">
                    <div class="form-group">
                        <label>Service Category</label>
                        <select title="Service Category" class="form-control chosen-select" name="servicecat" id="servicecat" required>
                            <option value="5" selected>Partner Services</option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Service Name<span class="text-danger">*</span></label>
                        <input title="Service Name" class="form-control" type="text" name="servicename" id="servicename" value="<?= $partner_service_info['description']; ?>" required>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label>Service Shortname</label>
                        <input title="Service Shortname" class="form-control" type="text" name="servicesn" id="servicesn" value="<?php echo $partner_service_info['ideas']; ?>" disabled>
                        <input type="hidden" name="shorthidden" id="shorthidden" value="<?php echo $partner_service_info['ideas']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Partner Type</label>
                        <select title="Partner Type" class="form-control chosen-select" name="partnertype" id="partnertype" required>
                            <?php
                                foreach ($partners_type_list as $value) {                                
                            ?>
                            <option value="<?= $value['id'] ?>" <?= ($partner_service_info['partner_type'] == $value['id']) ? 'selected':'';  ?>><?= $value['name'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label>Responsible Assigned<span class="text-danger">*</span></label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="1" type="radio" id="responsible_franchisee" name="responsible_assigned" required="" title="Responsible Assigned" checked=""> Partner
                        </label>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label>Input Form<span class="text-danger">*</span></label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="y" type="radio" id="inputform1" name="input_form" required="" title="Input Form" <?= ($partner_service_info['input_form'] == 'y') ? 'checked':''; ?>> Yes
                        </label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="n" type="radio" id="inputform2" name="input_form" required="" title="Input Form" <?= ($partner_service_info['input_form'] == 'n') ? 'checked':''; ?>> No
                        </label>
                        <div class="errorMessage text-danger" id="input_form_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="note" id="note"><?= $partner_service_info['note'] ?></textarea>
                    </div>                           

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
                    <button type="button" class="btn btn-primary" onclick="updatePartnerService()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>    
<?php        
    }
?>