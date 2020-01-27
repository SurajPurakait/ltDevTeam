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
                                <label>First Name</label>
                                <input placeholder="" class="form-control" nameval="" type="text" id="recipient_first_name"
                                       name="recipient_first_name" title="First Name">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input placeholder="" class="form-control" nameval="" type="text" id="recipient_last_name"
                                       name="recipient_last_name" title="Last Name">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input class="form-control" type="text" phoneval="" name="recipient_phone_number" id="recipient_phone_number"
                                       title="Phone Number" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" type="text" name="recipient_address" id="recipient_address"
                                       title="Address" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input class="form-control" type="text" name="recipient_city" id="recipient_city"
                                       title="City" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <select title="State" class="form-control" name="recipient_state" id="recipient_state">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("all_state_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select title="Country" class="form-control" name="recipient_country"
                                        id="recipient_country">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("get_countries"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Zip Code</label>
                                <input class="form-control" type="text" name="recipient_zip_code" id="recipient_zip_code"
                                       title="Zip Code" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>TIN (Tax Identification Number)</label>
                                <input class="form-control" type="text" name="recipient_tin" id="recipient_tin"
                                       title="TIN" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Non-Employee Compensation</label>
                                <input class="form-control" type="text" name="compensation" id="compensation"
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
<!-- <?php //else: ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Edit Contact Info</h3>
            </div>
            <form role="form" id="form_contact" name="form_contact">
                <div class="modal-body">                   
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type<span class="text-danger">*</span></label>
                                <select title="Contact Type" class="form-control" name="contact[type]"
                                        id="contact_type" required="">
                                    <?php// load_ddl_option("get_contact_info_type", $data["type"]); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>First Name<span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" nameval="" type="text" id="first_name"
                                       name="contact[first_name]" title="Contact First Name" required
                                       value="<?//= $data["first_name"]; ?>" maxlength="20">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Last Name<span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" nameval="" type="text" id="last_name"
                                       name="contact[last_name]" title="Contact Last Name" required
                                       value="<?//= $data["last_name"]; ?>" maxlength="20">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Phone Country<span class="text-danger">*</span></label>
                                <select title="Phone Country" class="form-control"
                                        name="contact[phone1_country]" id="phone1_country" required>
                                    <option value="">Select an option</option>
                                    <?php// load_ddl_option("get_countries", $data["phone1_country"]); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Phone Number<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" phoneval="" name="contact[phone1]" id="phone1"
                                       title="Phone Number" value="<?//= $data["phone1"]; ?>" required>
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Email<span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" type="email" id="email1"
                                       name="contact[email1]" id="emailaddress" title="Email" required
                                       value="<?//= $data["email1"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company</label>
                                <input placeholder="" class="form-control" type="text" id="company" name="contact[company]" title="Company" value="<?//= $data["company"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Address<span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" type="text" id="address1"
                                       name="contact[address1]" title="Address" required=""
                                       value="<?//= $data["address1"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>City<span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" type="text" id="city"
                                       name="contact[city]" title="City" required value="<?//= $data["city"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>State<span class="text-danger">*</span></label>
                                <select title="State" class="form-control" name="contact[state]" id="state" required="">
                                    <option value="">Select an option</option>
                                    <?php //load_ddl_option("all_state_list", $data["state"]); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label>Zip<span class="text-danger">*</span></label>
                                <input placeholder="" class="form-control" type="text" zipval="" id="zip"
                                       name="contact[zip]" title="Zip" required value="<?//= $data["zip"]; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label>Country<span class="text-danger">*</span></label>
                                <select title="Country" class="form-control" name="contact[country]"
                                        id="country" required="">
                                    <option value="">Select an option</option>
                                    <?php //load_ddl_option("get_countries", $data["country"]); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    </div>                      
                    <div class="modal-footer">
                        <input type="hidden" name="contact[reference]" id="reference" value="<?= $reference; ?>">
                        <input type="hidden" name="contact[reference_id]" id="reference_id" value="<?= $reference_id; ?>">
                        <input type="hidden" name="edit_type_id" value="<?//= $data["type"]; ?>">
                        <input name="contact[id]" value="<?//= $data["id"]; ?>" type="hidden">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="save_contact();">Save changes
                        </button>
                    </div>
            </form>

        </div> -->

    <?php endif; ?>
    <!-- <script>
        $(function () {
            var availableTags = [<?//= get_array_states(); ?>];
            $("#tags").autocomplete({
                source: availableTags
            });
        });
    </script> -->