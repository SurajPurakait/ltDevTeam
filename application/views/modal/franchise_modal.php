<?php if ($modal_type == "edit") { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Edit Office Information</h3>
            </div>
            <form class="form-horizontal" method="post" id="form_office_modal" onsubmit="return false;">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Select Type<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="ofc_type" name="type" class="form-control" <?= count($office_staff) > 0 ? "disabled='disabled'" : ""; ?> title="Office Type" onchange="get_staff_for_role();">
                                <?php
                                if (!empty($office_type_list)) {
                                    foreach ($office_type_list as $otl) {
                                        ?>
                                        <option <?php echo $franchise_info['type'] == $otl['id'] ? "selected='selected'" : ""; ?>
                                            value="<?php echo $otl['id']; ?>"><?php echo $otl['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">From<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="from_type" name="from_type" class="form-control chosen-select"
                                    data-placeholder="Select One Option" required title="From Office">
                                <option value="1" <?php echo $franchise_info['from_type'] == '1' ? "selected='selected'" : ""; ?>>Taxleaf</option>
                                <option value="2" <?php echo $franchise_info['from_type'] == '2' ? "selected='selected'" : ""; ?>>ContadorMiami</option>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Name<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Name" class="form-control" nameval="" type="text" name="name" required id="name"
                                   title="Name" value="<?php echo $franchise_info['name']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Office ID<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Office Id" nameval="" class="form-control" type="text" name="office_id" required id="office_id"
                                   title="Office ID" value="<?php echo $franchise_info['office_id']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Merchant Token</label>
                        <div class="col-lg-9">
                            <input placeholder="Merchant Token" class="form-control" type="text" name="merchant_token" id="merchant_token"
                                   title="Merchant Token" value="<?php echo $franchise_info['merchant_token']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Address<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Address" class="form-control" type="text" name="address" id="address"
                                   required title="Address" value="<?php echo $franchise_info['address']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">City<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="City" nameval="" class="form-control" type="text" id="city" name="city" required
                                   title="City" value="<?php echo $franchise_info['city']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">State<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="state" name="state" class="form-control chosen-select"
                                    data-placeholder="Select One Option" required title="State">
                                <option value="">Select</option>
                                <?php
                                if (!empty($state_list)) {
                                    foreach ($state_list as $sl) {
                                        if ($sl['id'] != 0) {
                                            ?>
                                            <option <?php echo $franchise_info['state'] == $sl['id'] ? "selected='selected'" : ""; ?>
                                                value="<?php echo $sl['id']; ?>"><?php echo $sl['state_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Zip<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Zip" class="form-control" type="text" zipval="" id="zip" name="zip" required
                                   title="Zip" value="<?php echo $franchise_info['zip']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email Address<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Email address" class="form-control" id="emailaddress" type="email"
                                   name="email" required title="Email Address"
                                   value="<?php echo $franchise_info['email']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Phone<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Phone" class="form-control" type="text" phoneval="" id="phone" name="phone" required
                                   title="Phone" value="<?php echo $franchise_info['phone']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Fax</label>
                        <div class="col-lg-9">
                            <input placeholder="Fax" class="form-control" type="text" id="fax" name="fax" title="Fax"
                                   value="<?php echo $franchise_info['fax']; ?>">
                        </div>
                    </div>
                    <?php if ($franchise_info['photo'] != "") {
                        ?>
                        <div class="form-group" id="uploaded_photo">
                            <label class="col-lg-3 control-label">Photo</label>
                            <div class="col-lg-9">
                                <img src="<?php echo base_url(); ?>uploads/<?php echo $franchise_info['photo']; ?>"
                                     class="editimg" height="50" width="50">
                            </div>
                        </div>
                    <?php }
                    ?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Upload Photo</label>
                        <div class="col-lg-9">
                            <input class="p-t-5" type="file" name="photo" id="photo" allowed_types="jpg|png|jpeg" title="Photo">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                   <!--  <div class="form-group" id="manager_div" style="display: none;">
                        <label class="col-lg-3 control-label">Manager</label>
                        <div class="col-lg-9">
                            <select id="manager" disabled class="form-control" title="Manager">
                                <option value="">Select an option</option>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="franchise_office_id" value="<?php echo $franchise_info['id']; ?>">
                    <button class="btn btn-success" type="button" onclick="update_franchise()">Save changes</button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- <script>
        get_staff_for_role();
    </script> -->
<?php } else { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Office Information</h3>
            </div>
            <form class="form-horizontal" method="post" id="form_office_modal" onsubmit="return false;">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Select Type<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="ofc_type" name="type" class="form-control" title="Office Type">
                                <?php
                                if (!empty($office_type_list)) {
                                    foreach ($office_type_list as $otl) {
                                        ?>
                                        <option value="<?php echo $otl['id']; ?>"><?php echo $otl['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">From<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="from_type" name="from_type" class="form-control chosen-select"
                                    data-placeholder="Select One Option" required title="From Office">
                                <option value="1">Taxleaf</option>
                                <option value="2">ContadorMiami</option>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Name<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Name" nameval="" class="form-control" type="text" name="name" required id="name"
                                   title="Name" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Office ID<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Office Id" nameval="" class="form-control" type="text" name="office_id" required id="office_id"
                                   title="Office ID" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Merchant Token</label>
                        <div class="col-lg-9">
                            <input placeholder="Merchant Token" class="form-control" type="text" name="merchant_token" id="merchant_token"
                                   title="Merchant Token" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Address<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Address" class="form-control" type="text" name="address" id="address"
                                   required title="Address" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">City<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="City" nameval="" class="form-control" type="text" id="city" name="city" required
                                   title="City" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">State<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="state" name="state" class="form-control chosen-select"
                                    data-placeholder="Select One Option" required title="State">
                                <option value="">Select</option>
                                <?php
                                if (!empty($state_list)) {
                                    foreach ($state_list as $sl) {
                                        if ($sl['id'] != 0) {
                                            ?>
                                            <option value="<?php echo $sl['id']; ?>"><?php echo $sl['state_name']; ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Zip<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Zip" class="form-control" type="text" zipval="" id="zip" name="zip" required
                                   title="Zip" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email Address<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Email address" class="form-control" id="emailaddress" type="email"
                                   name="email" required title="Email Address" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Phone<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input placeholder="Phone" phoneval="" class="form-control" type="text" id="phone" name="phone" required
                                   title="Phone" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Fax</label>
                        <div class="col-lg-9">
                            <input placeholder="Fax" class="form-control" type="text" id="fax" name="fax" title="Fax"
                                   value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Upload Photo</label>
                        <div class="col-lg-9">
                            <input class="p-t-5" type="file" name="photo" id="photo" allowed_types="jpg|png|jpeg" title="Photo">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" onclick="add_franchise()">Save changes</button> &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>