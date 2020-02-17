<?php if ($modal_type != "edit"): ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Add Recipient Info</h4>
            </div>
            <form role="form" id="form_recipient" name="form_recipient" onsubmit="save_recipient(); return false;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" nameval="" type="text" id="recipient_first_name"
                                       name="recipient_first_name" title="First Name" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Last Name <span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" nameval="" type="text" id="recipient_last_name"
                                       name="recipient_last_name" title="Last Name" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Phone Number <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" phoneval="" name="recipient_phone_number" id="recipient_phone_number"
                                       title="Phone Number" value="" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Address <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="recipient_address" id="recipient_address"
                                       title="Address" value="" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>City <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="recipient_city" id="recipient_city"
                                       title="City" value="" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>State <span class="text-danger">*</span></label>
                                <select title="State" class="form-control" name="recipient_state" required="" id="recipient_state">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("all_state_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Country <span class="text-danger">*</span></label>
                                <select title="Country" class="form-control" name="recipient_country"
                                        id="recipient_country" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("get_countries"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Zip Code <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" required="" name="recipient_zip_code" id="recipient_zip_code"
                                       title="Zip Code" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>TIN (Tax Identification Number) <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="recipient_tin" required="" id="recipient_tin"
                                       title="TIN" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Non-Employee Compensation <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" required="" name="compensation" id="compensation"
                                       title="Non-Employee Compensation" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
    
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="reference" id="reference" value="<?= $reference ?>">
                    <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id ?>">
                    <input name="id" value="" type="hidden">
                    <input type="hidden" name="retail_price" id="retail_price" value="<?= $retail_price ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save_recipient();">Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Edit Contact Info</h3>
            </div>
            <form role="form" id="form_recipient" name="form_recipient" onsubmit="update_recipient(); return false;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" nameval="" type="text" id="recipient_first_name"
                                       name="recipient_first_name" value="<?= $data['recipient_first_name']; ?>" title="First Name" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Last Name <span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" nameval="" type="text" id="recipient_last_name"
                                       name="recipient_last_name" value="<?= $data['recipient_last_name']; ?>" title="Last Name" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Phone Number <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" phoneval="" name="recipient_phone_number" id="recipient_phone_number"
                                       title="Phone Number" value="<?= $data['recipient_phone_number']; ?>" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Address <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="recipient_address" id="recipient_address"
                                       title="Address" value="<?= $data['recipient_address']; ?>" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>City <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="recipient_city" id="recipient_city"
                                       title="City" value="<?= $data['recipient_city']; ?>" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>State <span class="text-danger">*</span></label>
                                <select title="State" class="form-control" name="recipient_state" required="" id="recipient_state">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("all_state_list", $data['recipient_state']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Country <span class="text-danger">*</span></label>
                                <select title="Country" class="form-control" name="recipient_country"
                                        id="recipient_country" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("get_countries", $data['recipient_country']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Zip Code <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" required="" name="recipient_zip_code" id="recipient_zip_code"
                                       title="Zip Code" value="<?= $data['recipient_zip']?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>TIN (Tax Identification Number) <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="recipient_tin" required="" id="recipient_tin"
                                       title="TIN" value="<?= $data['recipient_tin']?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Non-Employee Compensation <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" required="" name="compensation" id="compensation"
                                       title="Non-Employee Compensation" value="<?= $data['compensation']?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
    
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="reference" id="reference" value="<?= $reference ?>">
                    <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id ?>">
                    <input name="id" type="hidden" value="<?= $data['id']?>">
                    <input type="hidden" name="retail_price" id="retail_price" value="<?= $retail_price ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="update_recipient();">Save changes
                    </button>
                </div>
            </form>

        </div>

    <?php endif; ?>
    <script>
        $(function () {
            var availableTags = [<?= get_array_states(); ?>];
            $("#tags").autocomplete({
                source: availableTags
            });
        });
    </script> 
