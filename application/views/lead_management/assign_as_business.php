<div class="wrapper wrapper-content m-t-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_create_new_company">
                        <h3>Business Information</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="company[state_opened]" id="state_opened" title="State of Incorporation" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Name of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Name of Company" class="form-control" id="name1" type="text" name="new_company[name1]" title="Name of Business" required="">
                                <div class="errorMessage text-danger"></div>
                                <input style="display: none;" placeholder="Option 2" class="form-control" type="text" name="new_company[name2]" title="Name of Business">
                                <input style="display: none;" placeholder="Option 3" class="form-control" type="text" name="new_company[name3]" title="Name of Business">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Federal ID</label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" class="form-control" id="fein" type="text" name="company[fein]" value="" title="Federal ID">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="company[type]" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="company[fye]" id="fye" title="Fiscal year end" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end", 12); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        
                         <div class="form-group" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="company[dba]" title="DBA">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Business Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="company[business_description]" id="business_description" title="Business Description"></textarea>
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
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[office]" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("staff_office_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[partner]" id="partner" title="Partner" required>
                                    <option value="">Select an option</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[manager]" id="manager" title="Manager" required>
                                    <option value="">Select an option</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client Association</label>
                            <div class="col-lg-10">
                                <input placeholder="Client Association" class="form-control" type="text" name="internal_data[client_association]" id="client_association" title="Client Association">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hidden">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Practice Id</label>
                            <div class="col-lg-10">
                                <input placeholder="Practice Id" class="form-control" type="text" name="internal_data[practice_id]" id="practice_id" title="Practice Id">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        </div>  
                            <div class="form-group">
                            <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[referred_by_source]" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("referer_by_source"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                            <div class="col-lg-10">
                                <input placeholder="Referred By Name" class="form-control" type="text" id="referred_by_name" name="internal_data[referred_by_name]" title="Referred By Name">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" id="language" name="internal_data[language]" title="Language" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("language_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div>
                            <?= note_func('Notes', 'n', 1, 'reference_id', $reference_id); ?>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <h3>Documents &nbsp; (<a onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>');" href="javascript:void(0);">Add Document</a>)</h3>
                        <div id="document-list"></div>
                        <div class="hr-line-dashed"></div>
                         <div class="form-group">
                                <label class="col-lg-2 control-label">Attachments</label>
                                <div class="col-lg-10">
                                    <input placeholder="Attachments" id="attachments" type="file" name="attachments" >
                                    <!--<div class="errorMessage text-danger"></div>-->
                                </div>
                            </div>
                         <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_new_company">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <input type="hidden" name="editval" id="editval" value="">
                                <button class="btn btn-success" type="button" onclick="request_create_business()">Save</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="go('action/home/business_dashboard')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;">
</div>

<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;">
</div>