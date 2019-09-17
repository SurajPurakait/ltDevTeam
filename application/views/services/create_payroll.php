<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <form class="form-horizontal" method="post" id="form_create_payroll" onsubmit="request_create_payroll(); return false;">
                      <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Your Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="staff_office" id="staff_office" title="Office" required="">
                                    <option value="">Select Office</option>
                                        <?php if (strpos($staff_info['office'], ',') !== false) {
                                                load_ddl_option("staff_office_list", "", "staff_office");
                                            }else{
                                                load_ddl_option("staff_office_list", $staff_info['office'], "staff_office");
                                            } 
                                        ?>      
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <h3>Business Information</h3><span class="company-data"></span>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Existing Client<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type_of_client" name="type_of_client" id="type_of_client_ddl" onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" title="Type Of Client" required>
                                    <option value="0">Yes</option>
                                    <option selected="selected" value="1">No</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div0" id="client_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control client_list client_type_field0" name="client_list" id="client_list_ddl" title="Client List" onchange="fetchExistingClientData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);">
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group client_type_div1" id="name_of_business">
                            <label class="col-lg-2 control-label">Name of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Company Name" id="name_of_company" class="form-control client_type_field1" type="text" name="name_of_company" title="Name of Company" >
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="state_div">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="istate" id="state" title="State of Incorporation" required="" onchange="select_other_state(this.value);">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="state_other" style="display:none;">
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="text" name="state_other" class="form-control" >
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group display_div" id="type_div">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="type" id="type" title="Type of Company" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div">
                            <label class="col-lg-2 control-label">Month & Year to Start</label>
                            <div class="col-lg-10">
                                <input placeholder="mm/yyyy" id="month" class="form-control datepicker_my value_field" type="text" title="Month & Year to Start" name="start_year" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="fiscal_year_end_div">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control value_field required_field" name="fye" id="fye" title="Fiscal year end" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end", 12); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group display_div" id="business_description_div">
                            <label class="col-lg-2 control-label">Business Description<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control value_field required_field" name="business_description"  title="Business Description"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <h3>Company Data</h3><span class="company-data"></span>
                        <div class="form-group" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="dba" title="DBA">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group" id="company_address_div">
                            <label class="col-lg-2 control-label">Company Address<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="company_address" id="company_address" title="Company Address" required placeholder="Company Address"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="fein_div">
                            <label class="col-lg-2 control-label">FEIN<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" id="fein" class="form-control required_field" type="text" name="fein" title="FEIN" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group" id="fein_file_div">
                            <label class="col-lg-2 control-label">FEIN File</label>
                            <div class="col-lg-10">
                                <input placeholder="FEIN File" id="fein_file" type="file" name="fein_file" title="FEIN File">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="company_started_div">
                            <label class="col-lg-2 control-label">Company Started</label>
                            <div class="col-lg-10">
                                <input placeholder="dd/mm/yyyy"  class="form-control datepicker_mdy" type="text" title="Company Started" name="company_started" id="company_started" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group" id="company_phone_div">
                            <label class="col-lg-2 control-label">Phone Number<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Phone Number" id="company_phone" phoneval="" class="form-control" required type="text" name="company_phone" title="Phone Number">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group" id="company_fax_div">
                            <label class="col-lg-2 control-label">Fax</label>
                            <div class="col-lg-10">
                                <input placeholder="Fax" id="company_fax" class="form-control" type="text" name="company_fax" title="Fax">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group" id="company_email_div">
                            <label class="col-lg-2 control-label">Email<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Email" id="company_email" class="form-control" type="text" required name="company_email" title="Email">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?= service_note_func('Notes', 'n', 'company', "", "", "n"); ?>

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

                        <div id="documents_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>'); return false;" href="javascript:void(0);">Add document</a>)</h3> 
                            <div id="document-list"></div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Account number where Payroll well be debited</h3>
                        <div class="accounts-details">
                            <div id="accounts-list"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bank Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="bank_name" id="bank_name" required title="Bank Name" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bank Account #<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="bank_account" id="bank_account" required title="Bank Account" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bank Routing #<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="bank_routing" id="bank_routing" required title="Bank Routing" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div class="rt6-div ibox-content bg-2">
                        <h3>RT6 Unemployment App</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Do you have a RT-6 #?<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="radio-inline"><input type="radio" name="Rt6" value="Yes" id="Rt6_1" title="RT6" required="">Yes</label>
                                <label class="radio-inline"><input type="radio" name="Rt6" value="No" id="Rt6_2" title="RT6" required="">No</label>
                                <div class="errorMessage text-danger" id="Rt6_error"></div><!-- onclick="activeRt6Price(this.value);"-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload Void Cheque (pdf)<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="file" name="void_cheque" id="void_cheque" title="Void cheque" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="rt6yes" style="display:none;">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">RT-6 Number<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="rt6_number" id="rt6_number" title="RT-6 Number" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="state" title="State" id="statert6" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="rt6no" style="display:none;">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Select Resident or Non-resident<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input type="radio" name="residenttype" title="Resident Type" value="Resident">Resident</label>
                                    <label class="radio-inline"><input type="radio" name="residenttype" title="Resident Type" value="Non-Resident">Non-Resident</label>
                                    <div class="errorMessage text-danger" id="residenttype_error"></div>
                                </div>
                            </div>
                        </div> 
                        <div class="residentclass" style="display:none;">
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
                        </div>
                        <div class="non-residentclass" style="display:none;">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Non-resident Upload</label>
                                <div class="col-lg-10">
                                    <label>Passport (pdf)<span class="text-danger">*</span></label> 
                                    <input class="form-control non_resident_file" type="file" name="passport" id="passport" title="Passport">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                                <label class="col-lg-2 control-label"></label>
                                <div class="col-lg-10">
                                    <label>Lease (pdf)<span class="text-danger">*</span></label> 
                                    <input class="form-control non_resident_file" type="file" name="lease" id="lease" title="Lease">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row">-->
                        <div class="rt6no" style="display:none;">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Retail Price</label>
                                <div class="col-lg-10">
                                    <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="<?= $rt6_data['retail_price']; ?>" id="retail-price">
                                    <input type="hidden" name="retail_price" id="retail-price-hidd" value="<?= $rt6_data['retail_price']; ?>">
                                    <input type="hidden" id="retail-price-initialamt" value="<?= $rt6_data['retail_price']; ?>" />
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Override Price</label>
                                <div class="col-lg-10">
                                    <input placeholder="" numeric_valid="" id="retail_price_override" class="form-control" type="text" name="retail_price_override" id="retail_price_override" title="Retail Price" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <?= note_func('Rt6 Note', 'n', 5, 'reference_id', $reference_id); ?>
                        </div>
                    </div> <!-- end rt6div -->


                    <div class="ibox-content">
                        <div id="payroll_data_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Payroll Data</h3>
                            <div class="form-group" id="payroll_frequency_div">
                                <label class="col-lg-2 control-label">Payroll Frequency<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input class="payroll_frequency" onclick="document.getElementById('frq_div').style.display = 'block';document.getElementById('pay_period_ending_div').style.display = 'none';" required="" type="radio" value="Weekly" name="payroll_frequency" title="Payroll Frequency" title="Payroll Frequency">Weekly</label>
                                    <label class="radio-inline"><input class="payroll_frequency" onclick="document.getElementById('frq_div').style.display = 'block';document.getElementById('pay_period_ending_div').style.display = 'none';" required="" type="radio" value="Biweekly" name="payroll_frequency" title="Payroll Frequency" title="Payroll Frequency">Biweekly</label>
                                    <label class="radio-inline"><input class="payroll_frequency" onclick="document.getElementById('frq_div').style.display = 'none';document.getElementById('pay_period_ending_div').style.display = 'block';" required="" type="radio" value="Monthly" name="payroll_frequency" title="Payroll Frequency" title="Payroll Frequency">Monthly</label>
                                    <div class="errorMessage text-danger" id="payroll_frequency_error"></div>
                                </div>
                            </div>
                            <div id="frq_div" style="display: none">
                                <div class="form-group" id="payday_div">
                                    <label class="col-lg-2 control-label">Payday<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <!-- <input placeholder="Payday" id="payday" class="form-control" type="text" name="payday" title="Payday"> -->
                                        <select name="payday" id="payday" class="form-control" title="Payday">
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                            <option value="Saturday">Saturday</option>
                                            <option value="Sunday">Sunday</option>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <label class="pay-period"></label><br>
                                <label>*Please note: We need three business days after the day you approve the payroll for the direct deposit to go through</label>
                            </div>
                            <div class="form-group" id="pay_period_ending_div" style="display: none">
                                <label class="col-lg-2 control-label">Pay Period Ending</label>
                                <div class="col-lg-10">
                                    <input placeholder="Pay Period Ending" readonly id="pay_period_ending" class="form-control" type="text" name="pay_period_ending" value="Month" title="Pay Period Ending">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>


                        <div id="payroll_data_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Payroll Approver<span class="text-danger">*</span></h3>

                            <div id="owner-list-payroll"></div>                            
                            <div class="link-content m-b-10">
                                <input type="hidden" id="payroll_approver_quantity" value="0">
                                <a href="javascript:void(0);" id="copy-contact" ref_id="<?= $reference_id; ?>">Copy Main Contact</a>
                                <a href="javascript:void(0);" onclick="show_payroll_approver_modal(); return false;">Add Payroll Approver</a>
                            </div>
                            <div class="form-group" id="payroll_first_name_div">
                                <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="First Name" id="payroll_first_name" class="form-control payroll_copy_field" required="" type="text" name="payroll_first_name" title="First Name">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="payroll_last_name_div">
                                <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Last Name" id="payroll_last_name" class="form-control payroll_copy_field" required="" type="text" name="payroll_last_name" title="Last Name">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="payroll_title_div">
                                <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Title" id="payroll_title" class="form-control payroll_copy_field" required="" type="text" name="payroll_title" title="Payroll Title">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="payroll_social_security_div">
                                <label class="col-lg-2 control-label">Social Security #<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Social Security" id="payroll_social_security" required="" class="form-control payroll_copy_field" type="text" name="payroll_social_security" title="Payroll Social Security">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="payroll_phone_div">
                                <label class="col-lg-2 control-label">Phone Number</label>
                                <div class="col-lg-10">
                                    <input placeholder="Phone Number" phoneval="" id="payroll_phone" class="form-control payroll_copy_field" type="text" name="payroll_phone" title="Phone Number">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="payroll_ext_div">
                                <label class="col-lg-2 control-label">Ext</label>
                                <div class="col-lg-10">
                                    <input placeholder="Ext" id="payroll_ext" class="form-control payroll_copy_field" type="text" name="payroll_ext" title="Ext">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="payroll_fax_div">
                                <label class="col-lg-2 control-label">Fax</label>
                                <div class="col-lg-10">
                                    <input placeholder="Fax" id="payroll_fax" class="form-control payroll_copy_field" type="text" name="payroll_fax" title="Fax">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="payroll_email_div">
                                <label class="col-lg-2 control-label">Email<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Email" required="" id="payroll_email" class="form-control payroll_copy_field" type="text" name="payroll_email" title="Email">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>

                        <div id="internal_data_div" class="display_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Internal Data</h3><span class="internal-data"></span>
                            <div class="form-group office-internal">
                                <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("staff_office_list"); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="partner" id="partner" class="form-control value_field required_field" title="Partner" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="manager" class="form-control value_field required_field" id="manager" title="Manager" required>
                                        <option value="">Select an option</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Client Association</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" id="client_association" name="client_association" title="Client Association" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("referer_by_source"); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" id="referred_by_name" name="referred_by_name" title="Referred By Name" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control value_field required_field" id="language" name="language" title="Language" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option("language_list"); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Existing Practice ID</label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control value_field" type="text" name="existing_practice_id" title="Existing Practice ID" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>

                        <div id="company_principal_data_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Company Principal</h3>
                            <div id="owner-list-payroll2"></div>
                            <div class="link-content m-b-10">
                                <input type="hidden" id="company_principal_quantity" value="0">
                                <a href="javascript:void(0);" onclick="copyPrincipal(0);">Copy Main Contact</a>
                                <a href="javascript:void(0);" onclick="copyPrincipal(1);">Same as Payroll Approver</a>
                            </div>
                            <div class="form-group" id="company_principal_first_name_div">
                                <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="First Name" required="" id="company_principal_first_name" class="form-control company_principal_copy_field" type="text" name="company_principal_first_name" title="First Name">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="company_principal_last_name_div">
                                <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Last Name" required="" id="company_principal_last_name" class="form-control company_principal_copy_field" type="text" name="company_principal_last_name" title="Last Name">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="company_principal_title_div">
                                <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Title" required="" id="company_principal_title" class="form-control company_principal_copy_field" type="text" name="company_principal_title" title="Title">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="company_principal_social_security_div">
                                <label class="col-lg-2 control-label">Social Security #<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Social Security" required="" id="company_principal_social_security" class="form-control company_principal_copy_field" type="text" name="company_principal_social_security" title="Social Security">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="company_principal_phone_div">
                                <label class="col-lg-2 control-label">Phone Number</label>
                                <div class="col-lg-10">
                                    <input placeholder="Phone Number" phoneval="" id="company_principal_phone" class="form-control company_principal_copy_field" type="text" name="company_principal_phone" title="Phone Number">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="company_principal_ext_div">
                                <label class="col-lg-2 control-label">Ext</label>
                                <div class="col-lg-10">
                                    <input placeholder="Ext" id="company_principal_ext" class="form-control company_principal_copy_field" type="text" name="company_principal_ext" title="Ext">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="company_principal_fax_div">
                                <label class="col-lg-2 control-label">Fax</label>
                                <div class="col-lg-10">
                                    <input placeholder="Fax" id="company_principal_fax" class="form-control company_principal_copy_field" type="text" name="company_principal_fax" title="Fax">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="company_principal_email_div">
                                <label class="col-lg-2 control-label">Email<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Email" required="" id="company_principal_email" class="form-control company_principal_copy_field" type="text" name="company_principal_email" title="Email">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                        </div>

                        <div id="signer_data_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Signer Data</h3>
                            <div id="owner-list-payroll3"></div>
                            <div class="link-content m-b-10">
                                <input type="hidden" id="signer_data_quantity" value="0">
                                <a href="javascript:void(0);" onclick="copySigner(0);">Copy Main Contact</a>
                                <a href="javascript:void(0);" onclick="copySigner(1);">Same as Payroll Approver</a>
                                <a href="javascript:void(0);" onclick="copySigner(2);">Same as Company Principal</a>
                            </div>
                            <div class="form-group" id="signer_first_name_div">
                                <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="First Name" required="" id="signer_first_name" class="form-control signer_data_copy_field" type="text" name="signer_first_name" title="First Name">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="signer_last_name_div">
                                <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Last Name" required="" id="signer_last_name" class="form-control signer_data_copy_field" type="text" name="signer_last_name" title="Last Name">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>

                            <div class="form-group" id="signer_social_security_div">
                                <label class="col-lg-2 control-label">Social Security #<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Social Security" required="" id="signer_social_security" class="form-control signer_data_copy_field" type="text" name="signer_social_security" title="Social Security">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>

                        <div id="employee_data_div">
                            <div class="hr-line-dashed"></div>
                            <h3>Employee Data<span class="text-danger">*</span></h3>
                            <div id="related_service_<?= $service_id; ?>">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">How many people are on payroll</label>
                                    <div class="col-lg-10">
                                        <select class="form-control payroll_people_total" id="payroll_employee_people_total" name="employee_related_service[payroll_people_total]" title="Payroll People Total">
                                            <option value="1-10">1-10</option>
                                            <option value="11-20">11-20</option>
                                            <option value="21-30">21-30</option>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Retail Price ($ Per Month)</label>
                                    <div class="col-lg-10">
                                        <input disabled placeholder="" id="employee-retail-price" class="form-control retprice" type="text" title="Retail Price" value="99">
                                        <input class="retprice" id="employee-retail-price-hidd" type="hidden" title="Retail Price" value="99" name="employee_related_service[retail_price]">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Override Price</label>
                                    <div class="col-lg-10">
                                        <input placeholder="" numeric_valid="" id="employee_related_service" class="form-control" type="text" name="employee_related_service[override_price]" title="Retail Price" value="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <?= note_func('Payroll Note', 'n', 4, 'reference_id', $reference_id); ?>
                            </div>
                            <h3>Employee Info<span class="employee-data text-danger">*</span> (<a href="javascript:void(0);" onclick="employee_modal('add', ''); return false;">Add Employee</a>)</h3>
                            <div id="employee-list">
                                <input type="hidden" name="employee_info" id="employee_info" value="" required title="Employee Info">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div id="employee_data_div">
                            <h3>Bi-Weekly Wage Calculator &nbsp;&nbsp; <a href="<?= base_url() ?>forms/Bi-Weekly Wage Calculator.xls" download="Bi-Weekly Wage.xls">Download The XLS</a></h3><span class="employee-data"></span>
                            <h3>Weekly Wage Calculator &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?= base_url() ?>forms/Weekly Wage Calculator.xls" download="Weekly Wage.xls">Download The XLS</a></h3><span class="employee-data"></span>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div id="wage_data_div">
                            <h3>Fillup And Upload Wage Calculator Sheet</h3>                        
                            <div class="form-group" id="fein_file_div">
                                <label class="col-lg-2 control-label">Bi-Weekly Wage Calculator (Xls)</label>
                                <div class="col-lg-10">
                                    <input placeholder="Bi-Weekly Wage Calculator" id="bi_weekly" type="file" name="bi_weekly" title="Bi-Weekly Wage Calculator">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group" id="fein_file_div">
                                <label class="col-lg-2 control-label">Weekly Wage Calculator (Xls)</label>
                                <div class="col-lg-10">
                                    <input placeholder="Weekly Wage Calculator" id="weekly" type="file" name="weekly" title="Weekly Wage Calculator">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="new_reference_id" id="new_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_payroll">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_employee" id="quant_employee" value="0">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="">
                                <button class="btn btn-success" type="button" onclick="request_create_payroll()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelRequestCreatePayroll()">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="employee-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="payroll-approver-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="accounts-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script>
    clientTypeChange(1, <?= $reference_id; ?>, '<?= $reference; ?>', 1);
    $(function () {
        $('input[type=radio][name=payroll_frequency]').click(function () {
            var payroll_frequency = $('input[type=radio][name=payroll_frequency]:checked').val();
            var payday = $("#payday option:selected").val();
            var base_url = '<?= base_url(); ?>';
            if (payday != '' && payroll_frequency != '') {
                $.ajax({
                    type: "POST",
                    data: {
                        payroll_frequency: payroll_frequency,
                        payday: payday
                    },
                    url: base_url + 'services/accounting_services/get_pay_period',
                    //            dataType: "html",
                    success: function (result) {
                        $(".pay-period").html(result);
                    }
                });
            }

        });

        $("#payday").change(function () {
            var payroll_frequency = $('input[type=radio][name=payroll_frequency]:checked').val();
            var payday = $("#payday option:selected").val();
            var base_url = '<?= base_url(); ?>';
            if (payday != '' && payroll_frequency.trim() != 'undefined') {
                $.ajax({
                    type: "POST",
                    data: {
                        payroll_frequency: payroll_frequency,
                        payday: payday
                    },
                    url: base_url + 'services/accounting_services/get_pay_period',
                    //            dataType: "html",
                    success: function (result) {
                        $(".pay-period").html(result);
                    }
                });
            }
        });

        $('input[type=radio][name=Rt6]').change(function () {
            $(".non_resident_file").removeAttr('required');
            if (this.value == 'Yes') {
                $(".rt6yes").show();
                $(".rt6no").hide();
                $(".non-residentclass").hide();
                $(".residentclass").hide();
                $('input[type=radio][name=residenttype]').removeAttr('checked');
                $('input[type=radio][name=residenttype]').removeAttr('required');
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
        $("#payroll_employee_people_total").change(function () {
            var val = $("#payroll_employee_people_total").val();
            var amt = 99;
            if (val == '1-10') {
                amt = 99;
            } else if (val == '11-20') {
                amt = 149;
            } else if (val == '21-30') {
                amt = 199;
            }
            $("#employee-retail-price-hidd").val(amt);
            $("#employee-retail-price").val(amt);
        });

        $('.add-note-rt6').click(function () {//alert('ff');
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"><label class="col-lg-2 control-label">' + note_label + '</label><div class="col-lg-10">' + textnote + '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });

        $("#copy-contact").click(function () {
            $("#payroll_first_name").val('');
            $("#payroll_last_name").val('');
            $("#payroll_email").val('');
            $("#payroll_phone").val('');
            $("#payroll_title").val('');
            $("#payroll_social_security").val('');
            $("#payroll_fax").val('');
            $("#payroll_ext").val('');
            var ref_id = $('#reference_id').val();
            $.ajax({
                type: "POST",
                                url: '<?= base_url(); ?>services/accounting_services/copy_contact_payroll_section',
                                data: {ref_id: ref_id}, 
                                cache: false,
                                success: function (data) {
                    //alert(data);
                    if (data != 0) {
                        var res = JSON.parse(data);
                        //alert(res);
                        $("#payroll_approver_quantity").val(1);
                        $("#payroll_first_name").val(res.first_name);
                        $("#payroll_last_name").val(res.last_name);
                        $("#payroll_email").val(res.email1);
                        $("#payroll_phone").val(res.phone1);
                    } else {
                        swal("Error", "No Main Contact Added", "error");
                    }
                }
            });
        });
    });   //document.ready end
    function copyMainContact(type) {
        $("." + type + "_copy_field").val('');
        var reference_id = $('#reference_id').val();
        $.ajax({
            type: "POST",
            url: '<?= base_url(); ?>services/home/copy_main_contact_info',
            data: {
                reference_id: reference_id
            }, 
            cache: false,
            success: function (data) {
                if (data != 0) {
                    var res = JSON.parse(data);
                    if (type == 'payroll') {
                        $("#payroll_approver_quantity").val(1);
                        $("#payroll_first_name").val(res.first_name);
                        $("#payroll_last_name").val(res.last_name);
                        $("#payroll_email").val(res.email1);
                        $("#payroll_phone").val(res.phone1);
                    } else if (type == 'company_principal') {
                        $("#company_principal_quantity").val(1);
                        $("#company_principal_first_name").val(res.first_name);
                        $("#company_principal_last_name").val(res.last_name);
                        $("#company_principal_email").val(res.email1);
                        $("#company_principal_phone").val(res.phone1);
                    } else if (type == 'signer_data') {
                        $("#signer_data_quantity").val(1);
                        $("#signer_first_name").val(res.first_name);
                        $("#signer_last_name").val(res.last_name);
                    }
                } else {
                    swal("Error", "No Main Contact Added", "error");
                }
            }
        });
    }

    function removeLicense(divID) {
        $("#" + divID).remove();
    }
// company principal radio buttton section
    function copyPrincipal(company_princpal) {
//        $('input[type=radio][name=company_princpal_radio]').click(function () {
//            var company_princpal = $('input[type=radio][name=company_princpal_radio]:checked').val();
        var base_url = '<?= base_url(); ?>';
        var reference_id = $("#reference_id").val();
        $.ajax({
            type: "POST",
            data: {
                company_princpal: company_princpal, reference_id: reference_id
            },
            url: base_url + 'services/accounting_services/set_company_principal',
            //            dataType: "html",
            success: function (result) {
                $("#company_principal_first_name").val('');
                $("#company_principal_last_name").val('');
                $("#company_principal_email").val('');
                $("#company_principal_phone").val('');
                $("#company_principal_title").val('');
                $("#company_principal_social_security").val('');
                $("#company_principal_fax").val('');
                $("#company_principal_ext").val('');
                if (company_princpal == 0) { //main contact
                    if (result != 0) {
                        res = JSON.parse(result);
                        $("#company_principal_quantity").val(1);
                        $("#company_principal_first_name").val(res.first_name);
                        $("#company_principal_last_name").val(res.last_name);
                        $("#company_principal_email").val(res.email1);
                        $("#company_principal_phone").val(res.phone1);
                    } else {
                        swal("Error", "No Main Contact Added", "error");
                    }

                } else {
                    if (result != 0) {
                        res = JSON.parse(result);
                        var payroll_first_name = $("#payroll_first_name").val();
                        var payroll_last_name = $("#payroll_last_name").val();
                        var payroll_title = $("#payroll_title").val();
                        var payroll_social_security = $("#payroll_social_security").val();
                        var payroll_phone = $("#payroll_phone").val();
                        var payroll_ext = $("#payroll_ext").val();
                        var payroll_fax = $("#payroll_fax").val();
                        var payroll_email = $("#payroll_email").val();
                        $("#company_principal_quantity").val(1);
                        $("#company_principal_first_name").val(payroll_first_name);
                        $("#company_principal_last_name").val(payroll_last_name);
                        $("#company_principal_email").val(payroll_email);
                        $("#company_principal_phone").val(payroll_phone);
                        $("#company_principal_title").val(payroll_title);
                        $("#company_principal_social_security").val(payroll_social_security);
                        $("#company_principal_fax").val(payroll_fax);
                        $("#company_principal_ext").val(payroll_ext);
                        // $("#company_principal_first_name").val(res.fname);
                        // $("#company_principal_last_name").val(res.lname);
                        // $("#company_principal_email").val(res.email);
                        // $("#company_principal_phone").val(res.phone);
                        // $("#company_principal_title").val(res.title);
                        // $("#company_principal_social_security").val(res.social_security);
                        // $("#company_principal_fax").val(res.fax);
                        // $("#company_principal_ext").val(res.ext);
                    } else {
                        swal("Error", "No Payroll Approver Added", "error");
                    }
                }
                //alert(result);
            }
        });
    }

    // signer data radio section
    function copySigner(signer_data) {
        var base_url = '<?= base_url(); ?>';
        var reference_id = $("#reference_id").val();
        $.ajax({
            type: "POST",
            data: {
                signer_data: signer_data,
                reference_id: reference_id
            },
            url: base_url + 'services/accounting_services/set_signer_data',
            success: function (result) {
                $("#signer_first_name").val('');
                $("#signer_last_name").val('');
                $("#signer_social_security").val('');
                if (signer_data == 0) { //main contact
                    if (result != 0) {
                        res = JSON.parse(result);
                        $("#signer_data_quantity").val(1);
                        $("#signer_first_name").val(res.first_name);
                        $("#signer_last_name").val(res.last_name);
                    } else {
                        swal("Error", "No Main Contact Added", "error");
                    }

                } else if (signer_data == 1) { //payroll approver
                    if (result != 0) {
                        res = JSON.parse(result);
                        var payroll_first_name = $("#payroll_first_name").val();
                        var payroll_last_name = $("#payroll_last_name").val();
                        var payroll_social_security = $("#payroll_social_security").val();
                        $("#signer_data_quantity").val(1);
                        $("#signer_first_name").val(payroll_first_name);
                        $("#signer_last_name").val(payroll_last_name);
                        $("#signer_social_security").val(payroll_social_security);
                        // $("#signer_data_quantity").val(1);
                        // $("#signer_first_name").val(res.fname);
                        // $("#signer_last_name").val(res.lname);
                        // $("#signer_social_security").val(res.social_security);
                    } else {
                        swal("Error", "No Payroll Approver Added", "error");
                    }
                } else {
                    if (result != 0) {
                        res = JSON.parse(result);
                        // $("#signer_data_quantity").val(1);
                        // $("#signer_first_name").val(res.fname);
                        // $("#signer_last_name").val(res.lname);
                        // $("#signer_social_security").val(res.social_security);
                        var company_first_name = $("#company_principal_first_name").val();
                        var company_last_name = $("#company_principal_last_name").val();
                        var company_social_security = $("#company_principal_social_security").val();
                        $("#signer_data_quantity").val(1);
                        $("#signer_first_name").val(company_first_name);
                        $("#signer_last_name").val(company_last_name);
                        $("#signer_social_security").val(company_social_security);
                    } else {
                        swal("Error", "No Company Principal Added", "error");
                    }
                }
                //alert(result);
            }
        });

    }
    function copy_values(ownerid, forvalue) {
        if (forvalue == 'payroll_approver') {

            $("#payroll_first_name").val('');
            $("#payroll_last_name").val('');
            $("#payroll_email").val('');
            $("#payroll_phone").val('');
            $("#payroll_title").val('');
            $("#payroll_social_security").val('');
            $("#payroll_fax").val('');
            $("#payroll_ext").val('');
            var base_url = '<?= base_url(); ?>';
            var reference_id = $("#reference_id").val();
            $.ajax({
                type: "POST",
                data: {ownerid: ownerid, reference_id: reference_id},
                url: base_url + 'services/accounting_services/copy_owner_data',
                dataType: "html",
                success: function (result) {
                    //alert(result);
                    if (result != 0) {
                        res = JSON.parse(result);
                        //alert(res);
                        $("#payroll_approver_quantity").val(1);
                        $("#payroll_first_name").val(res.first_name);
                        $("#payroll_last_name").val(res.last_name);
                        $("#payroll_title").val(res.title);
                        $("#payroll_social_security").val(res.ssn_itin);
                        //$("#payroll_phone").val(res.type);
                    }
                }
            });

        } else if (forvalue == 'company_principal') {
            $("#company_principal_first_name").val('');
            $("#company_principal_last_name").val('');
            $("#company_principal_title").val('');
            $("#company_principal_social_security").val('');
            $("#company_principal_phone").val('');
            $("#company_principal_ext").val('');
            $("#company_principal_fax").val('');
            $("#company_principal_email").val('');
            var base_url = '<?= base_url(); ?>';
            var reference_id = $("#reference_id").val();
            $.ajax({
                type: "POST",
                data: {ownerid: ownerid, reference_id: reference_id},
                url: base_url + 'services/accounting_services/copy_owner_data',
                dataType: "html",
                success: function (result) {
                    //alert(result);
                    if (result != 0) {
                        res = JSON.parse(result);
                        //alert(res);
                        $("#company_principal_quantity").val(1);
                        $("#company_principal_first_name").val(res.first_name);
                        $("#company_principal_last_name").val(res.last_name);
                        $("#company_principal_title").val(res.title);
                        $("#company_principal_social_security").val(res.ssn_itin);
                    }
                }
            });
        } else {
            $("#signer_first_name").val('');
            $("#signer_last_name").val('');
            $("#signer_social_security").val('');
            var base_url = '<?= base_url(); ?>';
            var reference_id = $("#reference_id").val();
            $.ajax({
                type: "POST",
                data: {ownerid: ownerid, reference_id: reference_id},
                url: base_url + 'services/accounting_services/copy_owner_data',
                dataType: "html",
                success: function (result) {
                    //alert(result);
                    if (result != 0) {
                        res = JSON.parse(result);
                        //alert(res);
                        $("#signer_data_quantity").val(1);
                        $("#signer_first_name").val(res.first_name);
                        $("#signer_last_name").val(res.last_name);
                        $("#signer_social_security").val(es.ssn_itin);
                    }
                }
            });
        }

    }

    function copy_financial_account(financial_account_id)
    {
        $("#bank_name").val('');
        $("#bank_account").val('');
        $("#bank_routing").val('');

        var base_url = '<?= base_url(); ?>';

        $.ajax({
            type: "POST",
            data: {financial_account_id: financial_account_id},
            url: base_url + 'services/accounting_services/populate_financial_account_data',
            dataType: "html",
            success: function (result) {
                if (result != 0) {
                    res = JSON.parse(result);
                    $("#bank_name").val(res.bank_name);
                    $("#bank_account").val(res.account_number);
                    $("#bank_routing").val(res.routing_number);
                }
            }
        });
    }

</script>
