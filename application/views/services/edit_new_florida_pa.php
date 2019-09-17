<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_new_florida_pa" onsubmit="request_create_new_florida_pa(); return false;">
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Your Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" disabled="" name="staff_office" id="staff_office" title="Office" required="">
                                    <option value="">Select Office</option>
                                    <?php load_ddl_option("staff_office_list", $edit_data['staff_office'], "staff_office"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <h3>Business Information</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control state_opened" disabled="" name="state" id="state_opened" title="State of Incorporation" required="">
                                    <?php load_ddl_option("state_list", '', 'FL'); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Name of Business<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Option 1" class="form-control" type="text" name="name_of_business1" id="name_of_business1" title="Name of Business" required>
                                <div class="errorMessage text-danger"></div>
                                <input placeholder="Option 2" class="form-control" type="text" name="name_of_business2" id="name_of_business2" title="Name of Business">
                                <input placeholder="Option 3" class="form-control" type="text" name="name_of_business3" id="name_of_business3" title="Name of Business">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="fiscal_year_end" id="fye" title="Fiscal year end" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="dba" title="DBA">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Business Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="business_description" name="business_description" title="Business Description"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Contact Info<span class="text-danger">*</span>&nbsp; (<a href="javascript:void(0);" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Contact</a>)</h3> 
                        <div id="contact-list">
                            <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Owners<span class="text-danger">*</span> &nbsp; (<a href="javascript:void(0);" onclick="open_owner_popup(<?= $service_id; ?>, '<?= $reference_id; ?>', 0); return false;">Add owner</a>)</h3> 
                        <div id="owners-list">
                            <input type="hidden" title="Owners" id="owners-list-count" required="required" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Internal Data</h3>
                        <div class="form-group office-internal">
                            <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("staff_office_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select name="partner" id="partner" class="form-control" title="Partner" required>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select name="manager" id="manager" class="form-control" title="Manager" required></select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client Association</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="client_association" id="client_association" title="Client Association">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("referer_by_source"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="referred_by_name" name="referred_by_name" title="Referred By Name">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" id="language" name="language" title="Language" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("language_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <h3>Documents &nbsp; (<a onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>');" href="javascript:void(0);">Add Document</a>)</h3> 
                        <div id="document-list">
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Main Service</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="<?= $service['retail_price']; ?>">
                                <input type="hidden" name="retail_price" value="<?= $service['retail_price']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input numeric_valid="" class="form-control" type="text" name="retail_price_override" title="Retail Price" id="retail_price_override" value="<?= $edit_data['price_charged']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?= service_note_func('Note', 'n', 'service', $edit_data['id'], $service_id); ?>                        
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Company Activity<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="activity" id="activity" title="Company Activity"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Social Activity<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="social_activity" id="social_activity" title="Social Activity"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Professional License Number<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input numeric_valid="" id="professional_license_number" class="form-control" type="text" name="professional_license_number" title="Professional License Number">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <h3>Confirmation</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirm<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="checkbox" name="confirmation" title="Confirmation" id="confirmation" required>
                                I confirm to be aware that the information added above is correct.
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="editval" id="editval" value="<?= $edit_data['id']; ?>">
                                <button class="btn btn-success" type="button" onclick="request_create_new_florida_pa()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="go('services/home');">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script>
    get_contact_list('<?= $company_id; ?>', 'company');
    reload_owner_list('<?= $company_id; ?>', 'main');
    get_document_list('<?= $company_id; ?>', 'company');
    getInternalData('<?= $reference_id; ?>', 'company');
    setIdVal('state_opened', '<?= $edit_data['state_opened']; ?>');
    setIdVal('name_of_business1', '<?= $edit_data['company_name']; ?>');
    setIdVal('name_of_business2', '<?= (!empty($company_name_option)) ? $company_name_option['name2'] : ''; ?>');
    setIdVal('name_of_business3', '<?= (!empty($company_name_option)) ? $company_name_option['name3'] : ''; ?>');
    setIdVal('type', '<?= $edit_data['company_type']; ?>');
    setIdVal('fye', '<?= $edit_data['fiscal_year_end']; ?>');
    setIdVal('dba', '<?= $edit_data['dba']; ?>');
    setIdVal('activity', '<?= $extra_data['activity']; ?>');
    setIdVal('social_activity', '<?= $extra_data['social_activity']; ?>');
    setIdVal('professional_license_number', '<?= $extra_data['professional_license_number']; ?>');
    setIdVal('business_description', '<?= urlencode($edit_data['business_description']); ?>');
    function checkConfirmation() {
        if ($("#confirmation").prop('checked')) {
            $("#confirmation").val("1");
        } else {
            $("#confirmation").val("");
        }
    }
</script>
