<?php $state_id = $state->id; ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <?= service_request_invoice_link($edit_data['id']); ?>
                <form class="form-horizontal" method="post" id="form_create_sales_tax_application" onsubmit="request_create_sales_tax_application(); return false;">
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Your Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" disabled="" name="staff_office" id="staff_office" title="Office" required="">
                                    <?php load_ddl_option("staff_office_list", $edit_data['staff_office'], "staff_office"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <h3>Business Information</h3><span class="company-data"></span>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Existing Client<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="disabled" class="form-control type_of_client type-of-company disabled_field" name="type_of_client" id="type_of_client" onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" title="Type Of Client" required>
                                    <option value="">Select an option</option>
                                    <option value="0" <?= ($sales_tax_data['new_existing'] == 0) ? 'selected' : ''; ?>>Yes</option>
                                    <option value="1" <?= ($sales_tax_data['new_existing'] == 1) ? 'selected' : ''; ?>>No</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="disabled" class="form-control client_type_field0 disabled_field" name="client_list" title="Client List" <?= $sales_tax_data['existing_ref_id'] != 0 ? "required=''" : ""; ?>>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("existing_client_list", $sales_tax_data['existing_ref_id']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div1" id="name_of_company_div">
                            <label class="col-lg-2 control-label">Name of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Company Name" id="name_of_company" class="form-control client_type_field1 required_field" type="text" name="name_of_company" title="Name of Company" value="<?= $company_data['name']; ?>" <?= $sales_tax_data['existing_ref_id'] == 0 ? "required=''" : ""; ?>>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control required_field" name="istate" id="istate" title="State of Incorporation" required="" onchange="select_other_state(this.value);">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list", $company_data['state_opened']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="state_other" <?php echo ($other_state == "")? "style='display:none'":"" ;?>>
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="text" name="state_other" class="form-control" value="<?= $other_state; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="type_div">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type-of-company required_field" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list", $company_data['type']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Start Date<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="dd/mm/yyyy" id="month" class="form-control datepicker_mdy value_field required_field" type="text" title="Start Date" name="start_year" value="<?= $sales_tax_data['start_month_year']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="fiscal_year_end_div">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type-of-company required_field" name="fye" id="fye" title="Fiscal year end" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end", $company_data['fye']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Federal ID<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" id="fein" class="form-control required_field" type="text" name="fein" value="<?= $company_data['fein']; ?>" title="FEIN" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group display_div" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="dba" title="DBA" value="<?php echo $company_data['dba'];?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="business_description_div">
                            <label class="col-lg-2 control-label">Business Description<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control required_field" name="business_description" id="business_description" title="Business Description"><?= urldecode($company_data['business_description']); ?></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Contact Phone Number</label>
                            <div class="col-lg-10">
                                <input placeholder="" numeric_valid="" id="contact_phone_no" class="form-control" type="text" name="contact_phone_no" title="Contact Phone Number" value="<?php if(isset($sales_tax_data['contact_phone_no'])){ echo $sales_tax_data['contact_phone_no'];} ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="documents_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>'); return false;" href="javascript:void(0);">Add document</a>)</h3> 
                            <div id="document-list"></div>
                        </div>

                        <div id="contact_info_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Contact Info<span class="text-danger">*</span><span class="display_div">&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Contact</a>)</span></h3>
                            <div id="contact-list">
                                <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div id="owners_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Owners<span class="text-danger">*</span> &nbsp; (<a href="javascript:void(0);" class="owneradd" onclick="open_owner_popup(1, '<?= $reference_id; ?>', 0); return false;">Add owner</a>)</h3>
                            <div id="owners-list">
                                <input type="hidden" class="required_field" title="Owners" id="owners-list-count" required="required" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group state_div">
                            <label class="col-lg-2 control-label">State of Recurring<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" onchange="county_ajax(this.value, '');" name="state_recurring" id="salesstate" title="State of Recurring" required="">
                                    <option value="">Select an option</option>
                                    <?php
                                    foreach ($state_list as $st) {
                                        ?>
                                        <option value="<?= $st['id'] ?>" <?php echo ($state_id == $st['id']) ? 'selected' : ''; ?>><?= $st['state_name']; ?></option>
                                        <?php }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group county_div" id="county_div">
                            <label class="col-lg-2 control-label">County of Recurring<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <div id="county"><select class="form-control" name="county" id="county" title="County of Recurring" required="">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Account number where Sales Tax will be debited</h3>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bank Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="bank_name" id="bank_name" required title="Bank Name" value="<?= $sales_tax_data['bank_name']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bank Account #<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="bank_account" id="bank_account" required title="Bank Account" value="<?= $sales_tax_data['bank_account_number']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bank Routing #<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="bank_routing" id="bank_routing" required title="Bank Routing" value="<?= $sales_tax_data['bank_routing_number']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Personal Or Business Account<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="radio-inline"><input type="radio" <?= ($sales_tax_data['acc_type1'] == 0) ? 'checked' : ''; ?> name="acctype1" value="0" id="acctype1_p" required="">Personal</label>
                                <label class="radio-inline"><input type="radio" <?= ($sales_tax_data['acc_type1'] == 1) ? 'checked' : ''; ?> name="acctype1" value="1" id="acctype1_b" required="">Business</label>
                                <div class="errorMessage text-danger" id="acctype1_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Checking Or Savings Account<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="radio-inline"><input type="radio" <?= ($sales_tax_data['acc_type2'] == 0) ? 'checked' : ''; ?> name="acctype2" value="0" id="acctype2_c" required="">Checking</label>
                                <label class="radio-inline"><input type="radio" <?= ($sales_tax_data['acc_type2'] == 1) ? 'checked' : ''; ?> name="acctype2" value="1" id="acctype2_s" required="">Savings</label>
                                <div class="errorMessage text-danger" id="acctype2_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="rt6-div ibox-content bg-2">
                        <h3>RT6 Unemployment App</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Do you have a RT-6 #?<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="radio-inline"><input <?= $sales_tax_data['rt6_availability'] == "Yes" ? "checked='checked'" : ""; ?> type="radio" name="Rt6" value="Yes" id="Rt6_1" required="">Yes</label>
                                <label class="radio-inline"><input <?= $sales_tax_data['rt6_availability'] == "No" ? "checked='checked'" : ""; ?> type="radio" name="Rt6" value="No" id="Rt6_2" required="">No</label>
                                <div class="errorMessage text-danger" id="Rt6_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload Void Cheque (pdf)<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="file" name="void_cheque" id="void_cheque" title="Void cheque" <?= ($sales_tax_data['void_cheque'] == '') ? "required" : ""; ?>>
                                <div class="errorMessage text-danger"></div>
                                <?php if ($sales_tax_data['void_cheque'] != '') {
                                    ?>
                                    <a href="<?= base_url() . "uploads/" . $sales_tax_data['void_cheque']; ?>" target="_blank">Cheque Pdf</a>
                                <?php }
                                ?>
                            </div>
                        </div>
                        <div class="rt6yes" <?= $sales_tax_data['rt6_availability'] != "Yes" ? "style='display:none;'" : ""; ?>>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">RT-6 Number<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="rt6_number" id="rt6_number" title="RT-6 Number" value="<?= $sales_tax_data['rt6_number']; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="state" title="State" id="statert6" value="<?= $sales_tax_data['state']; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="rt6no" <?= $sales_tax_data['rt6_availability'] != "No" ? "style='display:none;'" : ""; ?>>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Do you need Rt6?<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input type="radio" <?= $sales_tax_data['need_rt6'] == "Yes" ? "checked='checked'" : ""; ?> name="Rt6need" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" <?= $sales_tax_data['need_rt6'] == "No" ? "checked='checked'" : ""; ?> name="Rt6need" value="No">No</label>
                                    <div class="errorMessage text-danger" id="Rt6need_error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Select Resident or Non-resident<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input type="radio" <?= $sales_tax_data['resident_type'] == "Resident" ? "checked='checked'" : ""; ?> name="residenttype" value="Resident">Resident</label>
                                    <label class="radio-inline"><input type="radio" <?= $sales_tax_data['resident_type'] == "Non-Resident" ? "checked='checked'" : ""; ?> name="residenttype" value="Non-Resident">Non-Resident</label>
                                    <div class="errorMessage text-danger" id="residenttype_error"></div>
                                </div>
                            </div>
                        </div> 
                        <div class="residentclass" <?= $sales_tax_data['resident_type'] != "Resident" ? "style='display:none;'" : ""; ?>>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Resident Upload</label>
                                <div class="col-lg-10">
                                    <label>Upload Drivers License of All Owners</label>
                                    <div class="license-file">
                                        <input class="form-control license_file" type="file" name="license_file[]" id="license" title="Resident Upload">
                                    </div>
                                    <a href="javascript:void(0)" class="text-success add-license-file rel-serv-license-file"><i class="fa fa-plus"></i> Add License</a>
                                </div>
                            </div>
                            <?php if (!empty($all_driver_license)): ?>
                                <ul class="uploaded-file-list">
                                    <?php
                                    foreach ($all_driver_license as $adl):
                                        $extension = pathinfo($adl['file_name'], PATHINFO_EXTENSION);
                                        $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                        if (in_array($extension, $allowed_extension)):
                                            ?>
                                            <li>
                                                <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $adl['file_name']; ?>');max-width: 100%;">
                                                    <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $adl['file_name']; ?>" title="<?= $adl['file_name']; ?>"><i class="fa fa-search-plus"></i></a>
                                                </div>
                                                <p class="text-overflow-e" title="<?= $adl['file_name']; ?>"><?= $adl['file_name']; ?></p>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <div class="preview preview-file">
                                                    <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $adl['file_name']; ?>" title="<?= $adl['file_name']; ?>"><i class="fa fa-download"></i></a>
                                                </div>
                                                <p class="text-overflow-e" title="<?= $adl['file_name']; ?>"><?= $adl['file_name']; ?></p></li>
                                        <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                                <?php
                            endif;
                            ?>
                        </div>
                        <div class="non-residentclass" <?= $sales_tax_data['resident_type'] != "Non-Resident" ? "style='display:none;'" : ""; ?>>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Non-resident Upload</label>
                                <div class="col-lg-10">
                                    <label>Passport (pdf)<span class="text-danger">*</span></label> 
                                    <input class="form-control non_resident_file" type="file" name="passport" id="passport" title="Passport">
                                    <div class="errorMessage text-danger"></div>
                                    <?php if ($sales_tax_data['passport'] != '') {
                                        ?>
                                        <a href="<?php echo base_url() . "uploads/" . $sales_tax_data['passport']; ?>">Passport</a>
                                    <?php }
                                    ?>
                                </div>
                                <label class="col-lg-2 control-label"></label>
                                <div class="col-lg-10">
                                    <label>Lease (pdf)<span class="text-danger">*</span></label> 
                                    <input class="form-control non_resident_file" type="file" name="lease" id="lease" title="Lease">
                                    <div class="errorMessage text-danger"></div>
                                    <?php if ($sales_tax_data['lease'] != '') { ?>
                                        <a href="<?php echo base_url() . "uploads/" . $sales_tax_data['lease']; ?>">Lease</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row">-->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="99" id="retail-price">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="99">
                                <input type="hidden" id="retail-price-initialamt" value="99" />
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" numeric_valid="" id="retail_price_override" class="form-control" type="text" name="retail_price_override" id="retail_price_override" title="Retail Price" value="<?= count($get_override_price) > 0 ? $get_override_price[0]['price_charged'] : ""; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?= note_func('Rt6 Note', 'n', 5, 'reference_id', $reference_id); ?>
                    </div> <!-- end rt6div -->


                    <div class="ibox-content">
                        <div id="internal_data_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Internal Data</h3><span class="internal-data"></span>
                            <div class="form-group office-internal">
                                <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control type-of-company required_field value_field" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("staff_office_list", $inter_data['office']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="partner" id="partner" class="form-control type-of-company required_field value_field" title="Partner" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="manager" class="form-control type-of-company required_field value_field" id="manager" title="Manager" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Client Association</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" id="client_association" value="<?= $inter_data['client_association']; ?>" name="client_association" title="Client Association" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control required_field value_field" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("referer_by_source", $inter_data['referred_by_source']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" id="referred_by_name" name="referred_by_name" title="Referred By Name" value="<?= $inter_data['referred_by_name']; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control required_field value_field" id="language" name="language" title="Language" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("language_list", $inter_data['language']); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Existing Practice ID</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="existing_practice_id" title="Existing Practice ID" value="<?= $sales_tax_data['existing_practice_id']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="current_reference_id" id="current_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_sales_tax_application">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_employee" id="quant_employee" value="0">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="<?= $edit_data['id']; ?>">
                                <input type="hidden" id="payroll_passport_count" value="<?= $sales_tax_data['passport'] ?>">
                                <input type="hidden" id="payroll_lease_count" value="<?= $sales_tax_data['lease'] ?>">
                                <button class="btn btn-success" type="button" onclick="request_create_sales_tax_application()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelRequestCreateSalesTaxApplication()">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;">
</div>

<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;">
</div>

<script>
    clientTypeChange(<?= $sales_tax_data['new_existing']; ?>, <?= $reference_id; ?>, '<?= $reference; ?>', 1);

    county_ajax(<?= $state_id; ?>, <?= $sales_tax_data['country_recurring']; ?>);
    // reload_owner_list('<?= $reference_id; ?>', 'payroll');
    // reload_owner_list('<?= $reference_id; ?>', 'payroll2');
    // reload_owner_list('<?= $reference_id; ?>', 'payroll3');
    $(function () {

        var client_type = $('#type_of_client').val();
        if (client_type == '0') {
            fetchExistingClientData('<?= $reference_id; ?>', <?= $reference_id; ?>, '<?= $reference; ?>', 1);
            $('.display_div').hide();
        } else {
            get_contact_list('<?php echo $reference_id; ?>', 'company');
            reload_owner_list('<?php echo $reference_id; ?>', 'main');
            get_document_list('<?php echo $reference_id; ?>', 'company');
            getInternalData('<?= $reference_id; ?>', 'company');
        }

        $('input[type=radio][name=Rt6]').change(function () {
            $(".non_resident_file").removeAttr('required');
            if (this.value == 'Yes') {
                $(".rt6yes").show();
                $(".rt6no").hide();
                $(".non-residentclass").hide();
                $(".residentclass").hide();
                $('input[type=radio][name=residenttype]').removeAttr('checked');
                $('input[type=radio][name=residenttype]').removeAttr('required');
                $('input[type=radio][name=Rt6need]').removeAttr('checked');
                $('input[type=radio][name=Rt6need]').removeAttr('required');
                $("#rt6_number").prop('required', true);
                $("#statert6").prop('required', true);
                $(".license_file").removeAttr('required');
            } else {
                $(".rt6yes").hide();
                $(".rt6no").show();
                $(".residentclass").hide();
                $(".non-residentclass").hide();
                $('input[type=radio][name=residenttype]').removeAttr('checked');
                $('input[type=radio][name=residenttype]').attr('required', 'required');
                $('input[type=radio][name=Rt6need]').removeAttr('checked');
                $('input[type=radio][name=Rt6need]').attr('required', 'required');
                $("#rt6_number").prop('required', false);
                $("#statert6").prop('required', false);
            }
        });

        $('input[type=radio][name=residenttype]').change(function () {
            if (this.value == 'Resident') {
                $(".residentclass").show();
                $(".non-residentclass").hide();
//                $(".license_file").attr('required', 'required');
                $(".non_resident_file").removeAttr('required');
            } else {
                $(".residentclass").hide();
                $(".non-residentclass").show();
                $(".license_file").removeAttr('required');
                $(".non_resident_file").attr('required', 'required');
            }
        });

        $('input[type=radio][name=Rt6need]').change(function () {
            var initial = $("#retail-price-initialamt").val();
            if (this.value == 'Yes') {
                $("#retail-price").val(initial);
                $("#retail-price-hidd").val(initial);
            } else {
                $("#retail-price").val(50);
                $("#retail-price-hidd").val(50);
            }
        });

        $('.rel-serv-license-file').click(function () {
            var textlicense = $(this).prev('.license-file').html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group"  id="license_div' + div_count + '"><label class="col-lg-2 control-label"></label><div class="col-lg-10">' + textlicense + '<a href="javascript:void(0)" onclick="removeLicense(\'license_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove License</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
        $('.rel-serv-note').click(function () {
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"><label class="col-lg-2 control-label">' + note_label + '</label><div class="col-lg-10">' + textnote + '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });

        $('.add-note-rt6').click(function () {//alert('ff');
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"><label class="col-lg-2 control-label">' + note_label + '</label><div class="col-lg-10">' + textnote + '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });

    });   //document.ready end

    function removeLicense(divID) {
        $("#" + divID).remove();
    }
</script>