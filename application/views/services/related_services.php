<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <?php
//            print_r($order_extra_data);
            ?>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="related_service_form" onsubmit="saveRelatedService(); return false;">
                        <h2><?= $service_details['description']; ?></h2>
                        <div class="hr-line-dashed"></div>

                        <?php if ($service_shortname == 'acc_p'): //Payroll ?>
                            <h3>Account number where Payroll well be debited</h3>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bank Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="table[payroll_account_numbers][bank_name]" id="bank_name" required title="Bank Name" value="<?= isset($payroll_account_details['bank_name']) ? $payroll_account_details['bank_name'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bank Account #<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="table[payroll_account_numbers][ban_account_number]" id="bank_account" required title="Bank Account" value="<?= isset($payroll_account_details['ban_account_number']) ? $payroll_account_details['ban_account_number'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bank Routing #<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="table[payroll_account_numbers][bank_routing_number]" id="bank_routing" required title="Bank Routing" value="<?= isset($payroll_account_details['bank_routing_number']) ? $payroll_account_details['bank_routing_number'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div id="payroll_data_div">
                                <div class="hr-line-dashed"></div>
                                <h3>Payroll Data</h3>
                                <div class="form-group" id="payroll_frequency_div">
                                    <label class="col-lg-2 control-label">Payroll Frequency<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <label class="radio-inline"><input class="payroll_frequency" onclick="document.getElementById('frq_div').style.display = 'block';document.getElementById('pay_period_ending_div').style.display = 'none';" required="" type="radio" <?= ($payroll_data['payroll_frequency'] == 'Weekly') ? 'checked' : ''; ?> value="Weekly" name="table[payroll_data][payroll_frequency]" title="Payroll Frequency" title="Payroll Frequency">Weekly</label>
                                        <label class="radio-inline"><input class="payroll_frequency" onclick="document.getElementById('frq_div').style.display = 'block';document.getElementById('pay_period_ending_div').style.display = 'none';" required="" type="radio" <?= ($payroll_data['payroll_frequency'] == 'Biweekly') ? 'checked' : ''; ?> value="Biweekly" name="table[payroll_data][payroll_frequency]" title="Payroll Frequency" title="Payroll Frequency">Biweekly</label>
                                        <label class="radio-inline"><input class="payroll_frequency" onclick="document.getElementById('frq_div').style.display = 'none';document.getElementById('pay_period_ending_div').style.display = 'block';" required="" type="radio" <?= ($payroll_data['payroll_frequency'] == 'Monthly') ? 'checked' : ''; ?> value="Monthly" name="table[payroll_data][payroll_frequency]" title="Payroll Frequency" title="Payroll Frequency">Monthly</label>
                                        <div class="errorMessage text-danger" id="payroll_frequency_error"></div>
                                    </div>
                                </div>
                                <div id="frq_div" <?= (isset($payroll_data['payroll_frequency']) && $payroll_data['payroll_frequency'] == 'Monthly') ? 'style="display: none"' : ''; ?>>
                                    <div class="form-group" id="payday_div">
                                        <label class="col-lg-2 control-label">Payday<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select name="table[payroll_data][payday]" id="payday" class="form-control" title="Payday">
                                                <option value="Monday" <?= ($payroll_data['payday'] == "Monday") ? 'selected' : ''; ?>>Monday</option>
                                                <option value="Tuesday" <?= ($payroll_data['payday'] == "Tuesday") ? 'selected' : ''; ?>>Tuesday</option>
                                                <option value="Wednesday" <?= ($payroll_data['payday'] == "Wednesday") ? 'selected' : ''; ?>>Wednesday</option>
                                                <option value="Thursday" <?= ($payroll_data['payday'] == "Thursday") ? 'selected' : ''; ?>>Thursday</option>
                                                <option value="Friday" <?= ($payroll_data['payday'] == "Friday") ? 'selected' : ''; ?>>Friday</option>
                                                <option value="Saturday" <?= ($payroll_data['payday'] == "Saturday") ? 'selected' : ''; ?>>Saturday</option>
                                                <option value="Sunday" <?= ($payroll_data['payday'] == "Sunday") ? 'selected' : ''; ?>>Sunday</option>
                                            </select>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <label class="pay-period"><?php
                                        if (isset($payroll_data['payroll_frequency'])) {
                                            $payroll_frequency = $payroll_data['payroll_frequency'];
                                            $payday = $payroll_data['payday'];
                                            $payday_timestamp = strtotime($payday);
                                            $payday_end = date('l', strtotime($payday . ' -3 Weekdays'));
                                            if ($payroll_frequency == 'Weekly') {
                                                $payday_start = date('l', strtotime($payday_end . '-6 days'));
                                            } elseif ($payroll_frequency == 'Biweekly') {
                                                $payday_start = date('l', strtotime($payday_end . '-13 days'));
                                            } else {
                                                $payday_start = date('l', strtotime($payday_end . '-30 days'));
                                            }
                                            echo "Pay period would be " . $payday_start . " - " . $payday_end;
                                        }
                                        ?>
                                    </label><br>
                                    <label>*Please note: We need three business days after the day you approve the payroll for the direct deposit to go through</label>
                                </div>
                                <div class="form-group" id="pay_period_ending_div" <?= (isset($payroll_data['payroll_frequency']) && $payroll_data['payroll_frequency'] != 'Monthly') ? 'style="display: none"' : ''; ?>>
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
                                <input type="hidden" id="payroll_approver_quantity" value="0">
                                <button class="btn btn-success btn-xs" id="copy-contact" ref_id="<?= $reference_id; ?>">&nbsp;<i class="fa fa-copy"></i>&nbsp;Copy Main Contact</button>&nbsp;

                                <div class="form-group" id="payroll_first_name_div">
                                    <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="First Name" id="payroll_first_name" class="form-control payroll_copy_field" required="" type="text" name="table[payroll_approver][fname]" title="First Name" value="<?= $payroll_approver['fname']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="payroll_last_name_div">
                                    <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Last Name" id="payroll_last_name" class="form-control payroll_copy_field" required="" type="text" name="table[payroll_approver][lname]" title="Last Name" value="<?= $payroll_approver['lname']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="payroll_title_div">
                                    <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Title" id="payroll_title" class="form-control" required="" value="<?= $payroll_approver['title']; ?>" type="text" name="table[payroll_approver][title]" title="Payroll Title">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="payroll_social_security_div">
                                    <label class="col-lg-2 control-label">Social Security #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Social Security" id="payroll_social_security" required="" value="<?= $payroll_approver['social_security']; ?>" class="form-control" type="text" name="table[payroll_approver][social_security]" title="Payroll Social Security">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="payroll_phone_div">
                                    <label class="col-lg-2 control-label">Phone Number</label>
                                    <div class="col-lg-10">
                                        <input placeholder="Phone Number" phoneval="" id="payroll_phone" class="form-control" value="<?= $payroll_approver['phone']; ?>" type="text" name="table[payroll_approver][phone]" title="Phone Number">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="payroll_ext_div">
                                    <label class="col-lg-2 control-label">Ext</label>
                                    <div class="col-lg-10">
                                        <input placeholder="Ext" id="payroll_ext" class="form-control" type="text" value="<?= $payroll_approver['ext']; ?>" name="table[payroll_approver][ext]" title="Ext">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="payroll_fax_div">
                                    <label class="col-lg-2 control-label">Fax</label>
                                    <div class="col-lg-10">
                                        <input placeholder="Fax" id="payroll_fax" class="form-control" type="text" name="table[payroll_approver][fax]" title="Fax" value="<?= $payroll_approver['fax']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="payroll_email_div">
                                    <label class="col-lg-2 control-label">Email<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Email" required="" id="payroll_email" class="form-control" value="<?= $payroll_approver['email']; ?>" type="email" name="table[payroll_approver][email]" title="Email">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="company_principal_data_div">
                                <div class="hr-line-dashed"></div>
                                <h3>Company Principal</h3>
                                <div id="owner-list-payroll2"></div>
                                <input type="hidden" id="company_principal_quantity" value="0">
                                <button class="btn btn-success btn-xs" onclick="copyPrincipal(0);">&nbsp;<i class="fa fa-copy"></i>&nbsp;Copy Main Contact</button>&nbsp;
                                <button class="btn btn-success btn-xs" onclick="copyPrincipal(1);">&nbsp;<i class="fa fa-clipboard"></i>&nbsp;Same as Payroll Approver</button>
                                <div class="form-group" id="company_principal_first_name_div">
                                    <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="First Name" required="" id="company_principal_first_name" class="form-control" type="text" name="table[company_principal][fname]" title="First Name" value="<?= $company_principal['fname']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="company_principal_last_name_div">
                                    <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Last Name" required="" id="company_principal_last_name" class="form-control" type="text" name="table[company_principal][lname]" title="Last Name" value="<?= $company_principal['lname']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="company_principal_title_div">
                                    <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Title" required="" id="company_principal_title" class="form-control" type="text" name="table[company_principal][title]" title="Title" value="<?= $company_principal['title']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="company_principal_social_security_div">
                                    <label class="col-lg-2 control-label">Social Security #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Social Security" required="" id="company_principal_social_security" class="form-control" type="text" name="table[company_principal][social_security]" title="Social Security" value="<?= $company_principal['social_security']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="company_principal_phone_div">
                                    <label class="col-lg-2 control-label">Phone Number</label>
                                    <div class="col-lg-10">
                                        <input placeholder="Phone Number" phoneval="" id="company_principal_phone" class="form-control" type="text" name="table[company_principal][phone]" title="Phone Number" value="<?= $company_principal['phone']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="company_principal_ext_div">
                                    <label class="col-lg-2 control-label">Ext</label>
                                    <div class="col-lg-10">
                                        <input placeholder="Ext" id="company_principal_ext" class="form-control" type="text" name="table[company_principal][ext]" title="Ext" value="<?= $company_principal['ext']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="company_principal_fax_div">
                                    <label class="col-lg-2 control-label">Fax</label>
                                    <div class="col-lg-10">
                                        <input placeholder="Fax" id="company_principal_fax" class="form-control" type="text" name="table[company_principal][fax]" title="Fax" value="<?= $company_principal['fax']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="company_principal_email_div">
                                    <label class="col-lg-2 control-label">Email<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Email" required="" id="company_principal_email" class="form-control" type="email" name="table[company_principal][email]" title="Email" value="<?= $company_principal['email']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="signer_data_div">
                                <div class="hr-line-dashed"></div>
                                <h3>Signer Data</h3>
                                <div id="owner-list-payroll3"></div>
                                <input type="hidden" id="signer_data_quantity" value="0">
                                <button class="btn btn-success btn-xs" onclick="copySigner(0);">&nbsp;<i class="fa fa-copy"></i>&nbsp;Copy Main Contact</button>&nbsp;
                                <button class="btn btn-success btn-xs" onclick="copySigner(1);">&nbsp;<i class="fa fa-clipboard"></i>&nbsp;Same as Payroll Approver</button>&nbsp;
                                <button class="btn btn-success btn-xs" onclick="copySigner(2);">&nbsp;<i class="fa fa-clipboard"></i>&nbsp;Same as Company Principal</button>

                                <div class="form-group" id="signer_first_name_div">
                                    <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="First Name" required="" id="signer_first_name" class="form-control" type="text" name="table[signer_data][fname]" title="First Name" value="<?= $signer_data['fname']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="signer_last_name_div">
                                    <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Last Name" required="" id="signer_last_name" class="form-control" type="text" name="table[signer_data][lname]" title="Last Name" value="<?= $signer_data['lname']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group" id="signer_social_security_div">
                                    <label class="col-lg-2 control-label">Social Security #<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="Social Security" required="" id="signer_social_security" class="form-control" type="text" name="table[signer_data][social_security]" title="Social Security" value="<?= $signer_data['social_security']; ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <h3>Employee Info<span class="employee-data text-danger">*</span> (<a href="javascript:void(0);" onclick="employee_modal('add', ''); return false;">Add Employee</a>)</h3>
                            <div id="employee-list">
                                <input type="hidden" name="employee_info" id="employee_info" value="" required title="Employee Info">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        <?php endif; ?>

                        <?php if ($service_shortname == 'acc_r_b' || $service_shortname == 'acc_b_b_d'): ?>
                            <div class="accounts-details">
                                <h3>Financial Accounts<span class="text-danger">*</span>&nbsp; (<a href="javascript:void(0);" onclick="account_modal('add', '', '');">Add Financial Account</a>)</h3>
                                <div id="accounts-list">
                                    <input type="hidden" title="Financial Accounts" id="accounts-list-count" required="required" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($service_shortname == 'acc_s_t_p'):   //Sales Tax Processing ?>                            
                            <div class="form-group state_div">
                                <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control" onchange="county_ajax(this.value, '');" name="table[sales_tax_processing][state]" id="salesstate" title="State" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option('all_state_list', isset($sales_tax_processing_details['state']) ? $sales_tax_processing_details['state'] : ''); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group county_div" id="county_div">
                                <label class="col-lg-2 control-label">County<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <div id="county">
                                        <select class="form-control" name="table[sales_tax_processing][county]" id="county" title="County of Recurring" required="">
                                            <option value="">Select an option</option>
                                        </select>
                                    </div>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Frequency<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control frequeny" name="table[sales_tax_processing][frequeny_of_salestax]" id="frequeny" title="Frequency" required>
                                        <option value="">Select an option</option>
                                        <option value="m" <?= $sales_tax_processing_details['frequeny_of_salestax'] == 'm' ? 'selected' : ''; ?>>Monthly</option>
                                        <option value="q" <?= $sales_tax_processing_details['frequeny_of_salestax'] == 'q' ? 'selected' : ''; ?>>Quarterly</option>
                                        <option value="y" <?= $sales_tax_processing_details['frequeny_of_salestax'] == 'y' ? 'selected' : ''; ?>>Yearly</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($service_shortname == 'acc_s_t_r'):   //Sales Tax Recurring ?>
                            <div class="form-group" id="tax_id">
                                <label class="col-lg-2 control-label">Sales Tax ID<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="table[sales_tax_recurring][sales_tax_id]" id="sales_tax_id" title="Sales Tax Id" required="" value="<?= isset($sales_tax_recurring_details['sales_tax_id']) ? $sales_tax_recurring_details['sales_tax_id'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group" id="password">
                                <label class="col-lg-2 control-label">Password<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="table[sales_tax_recurring][password]" id="sales_password" title="Sales Tax Password" required="" value="<?= isset($sales_tax_recurring_details['password']) ? $sales_tax_recurring_details['password'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>    
                                </div>
                            </div>
                            <div class="form-group" id="website">
                                <label class="col-lg-2 control-label">Website<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" title="Website" id="sales_website" name="table[sales_tax_recurring][website]" required="" value="<?= isset($sales_tax_recurring_details['website']) ? $sales_tax_recurring_details['website'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>  
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group state_div">
                                <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control" onchange="county_ajax(this.value, '');" name="table[sales_tax_recurring][state]" id="salesstate" title="State" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option('all_state_list', isset($sales_tax_recurring_details['state']) ? $sales_tax_recurring_details['state'] : ''); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group county_div" id="county_div">
                                <label class="col-lg-2 control-label">County<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <div id="county">
                                        <select class="form-control" name="table[sales_tax_recurring][county]" id="county" title="County of Recurring" required="">
                                            <option value="">Select an option</option>
                                        </select>
                                    </div>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Frequency<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control frequeny" name="table[sales_tax_recurring][freq_of_salestax]" id="frequeny" title="Frequency" required>
                                        <option value="">Select an option</option>
                                        <option value="m" <?= $sales_tax_recurring_details['freq_of_salestax'] == 'm' ? 'selected' : ''; ?>>Monthly</option>
                                        <option value="q" <?= $sales_tax_recurring_details['freq_of_salestax'] == 'q' ? 'selected' : ''; ?>>Quarterly</option>
                                        <option value="y" <?= $sales_tax_recurring_details['freq_of_salestax'] == 'y' ? 'selected' : ''; ?>>Yearly</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($service_shortname == 'acc_r_a_-_u'):   //  Rt6 Unemployment App ?>
                            <h3>Account number where Rt6 will be debited</h3>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bank Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="table[rt6_unemployment_app][bank_name]" id="bank_name" required title="Bank Name" value="<?= isset($rt6_details['bank_name']) ? $rt6_details['bank_name'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bank Account #<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="table[rt6_unemployment_app][bank_account_number]" id="bank_account" required title="Bank Account" value="<?= isset($rt6_details['bank_account_number']) ? $rt6_details['bank_account_number'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bank Routing #<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="table[rt6_unemployment_app][bank_routing_number]" id="bank_routing" required title="Bank Routing" value="<?= isset($rt6_details['bank_routing_number']) ? $rt6_details['bank_routing_number'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Personal Or Business Account<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input type="radio" <?= (isset($rt6_details['acc_type1']) && $rt6_details['acc_type1'] == 0) ? 'checked' : ''; ?> name="table[rt6_unemployment_app][acc_type1]" value="0" id="acctype1_p" required="">Personal</label>
                                    <label class="radio-inline"><input type="radio" <?= (isset($rt6_details['acc_type1']) && $rt6_details['acc_type1'] == 1) ? 'checked' : ''; ?> name="table[rt6_unemployment_app][acc_type1]" value="1" id="acctype1_b" required="">Business</label>
                                    <div class="errorMessage text-danger" id="acctype1_error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Checking Or Savings Account<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input type="radio" <?= (isset($rt6_details['acc_type2']) && $rt6_details['acc_type2'] == 0) ? 'checked' : ''; ?> name="table[rt6_unemployment_app][acc_type2]" value="0" id="acctype2_c" required="">Checking</label>
                                    <label class="radio-inline"><input type="radio" <?= (isset($rt6_details['acc_type2']) && $rt6_details['acc_type2'] == 1) ? 'checked' : ''; ?> name="table[rt6_unemployment_app][acc_type2]" value="1" id="acctype2_s" required="">Savings</label>
                                    <div class="errorMessage text-danger" id="acctype2_error"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        <?php endif; ?>

                        <?php if ($service_shortname == 'acc_s_t_a'):   //Sales Tax Application ?>
                            <div class="form-group state_div">
                                <label class="col-lg-2 control-label">State of Sales Tax<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control" onchange="county_ajax(this.value, '');" name="table[sales_tax_application][state_recurring]" id="salesstate" title="State of Recurring" required="">
                                        <option value="">Select an option</option>
                                        <?php load_ddl_option('all_state_list', isset($sales_tax_application_details['state_recurring']) ? $sales_tax_application_details['state_recurring'] : ''); ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group county_div" id="county_div">
                                <label class="col-lg-2 control-label">County of Sales Tax<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <div id="county">
                                        <select class="form-control" name="table[sales_tax_application][country_recurring]" id="county" title="County of Recurring" required="">
                                            <option value="">Select an option</option>
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
                                    <input placeholder="" class="form-control" type="text" name="table[sales_tax_application][bank_name]" id="bank_name" required title="Bank Name" value="<?= isset($sales_tax_application_details['bank_name']) ? $sales_tax_application_details['bank_name'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bank Account #<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="table[sales_tax_application][bank_account_number]" id="bank_account" required title="Bank Account" value="<?= isset($sales_tax_application_details['bank_account_number']) ? $sales_tax_application_details['bank_account_number'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bank Routing #<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="table[sales_tax_application][bank_routing_number]" id="bank_routing" required title="Bank Routing" value="<?= isset($sales_tax_application_details['bank_routing_number']) ? $sales_tax_application_details['bank_routing_number'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Personal Or Business Account<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input type="radio" <?= (isset($sales_tax_application_details['acc_type1']) && $sales_tax_application_details['acc_type1'] == 0) ? 'checked' : ''; ?> name="table[sales_tax_application][acc_type1]" value="0" id="acctype1_p" required="">Personal</label>
                                    <label class="radio-inline"><input type="radio" <?= (isset($sales_tax_application_details['acc_type1']) && $sales_tax_application_details['acc_type1'] == 1) ? 'checked' : ''; ?> name="table[sales_tax_application][acc_type1]" value="1" id="acctype1_b" required="">Business</label>
                                    <div class="errorMessage text-danger" id="acctype1_error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Checking Or Savings Account<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input type="radio" <?= (isset($sales_tax_application_details['acc_type2']) && $sales_tax_application_details['acc_type2'] == 0) ? 'checked' : ''; ?> name="table[sales_tax_application][acc_type2]" value="0" id="acctype2_c" required="">Checking</label>
                                    <label class="radio-inline"><input type="radio" <?= (isset($sales_tax_application_details['acc_type2']) && $sales_tax_application_details['acc_type2'] == 1) ? 'checked' : ''; ?> name="table[sales_tax_application][acc_type2]" value="1" id="acctype2_s" required="">Savings</label>
                                    <div class="errorMessage text-danger" id="acctype2_error"></div>
                                </div>
                            </div>                            

                            <?php /* <div class="rt6-div ibox-content bg-2">
                              <h3>RT6 Unemployment App</h3>
                              <div class="form-group">
                              <label class="col-lg-2 control-label">Do you have a RT-6 #?<span class="text-danger">*</span></label>
                              <div class="col-lg-10">
                              <label class="radio-inline"><input <?= (isset($sales_tax_application_details['rt6_availability']) && $sales_tax_application_details['rt6_availability'] == "Yes") ? "checked='checked'" : ""; ?> type="radio" name="Rt6" value="Yes" id="Rt6_1" required="">Yes</label>
                              <label class="radio-inline"><input <?= (isset($sales_tax_application_details['rt6_availability']) && $sales_tax_application_details['rt6_availability'] == "No") ? "checked='checked'" : ""; ?> type="radio" name="Rt6" value="No" id="Rt6_2" required="">No</label>
                              <div class="errorMessage text-danger" id="Rt6_error"></div>
                              </div>
                              </div>
                              <div class="form-group">
                              <label class="col-lg-2 control-label">Upload Void Cheque (pdf)<span class="text-danger">*</span></label>
                              <div class="col-lg-10">
                              <input type="file" name="void_cheque" id="void_cheque" title="Void cheque" allowed_types="pdf" <?= (isset($sales_tax_application_details['void_cheque']) && $sales_tax_application_details['void_cheque'] == '') ? "required" : ''; ?>>
                              <div class="errorMessage text-danger"></div>
                              <?php if (isset($sales_tax_application_details['void_cheque'])) { ?>
                              <a href="<?= base_url() . "uploads/" . $sales_tax_application_details['void_cheque']; ?>" target="_blank">Cheque Pdf</a>
                              <?php } ?>
                              </div>
                              </div>
                              <div class="rt6yes" <?= (isset($sales_tax_application_details['rt6_availability']) && $sales_tax_application_details['rt6_availability'] != "Yes") ? "style='display:none;'" : ""; ?>>
                              <div class="form-group">
                              <label class="col-lg-2 control-label">RT-6 Number<span class="text-danger">*</span></label>
                              <div class="col-lg-10">
                              <input placeholder="" class="form-control" type="text" name="rt6_number" id="rt6_number" title="RT-6 Number" value="<?= (isset($sales_tax_application_details['rt6_number'])) ? $sales_tax_application_details['rt6_number'] : ''; ?>">
                              <div class="errorMessage text-danger"></div>
                              </div>
                              </div>
                              <div class="form-group">
                              <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                              <div class="col-lg-10">
                              <input placeholder="" class="form-control" type="text" name="state" title="State" id="statert6" value="<?= (isset($sales_tax_application_details['state'])) ? $sales_tax_application_details['state'] : ''; ?>">
                              <div class="errorMessage text-danger"></div>
                              </div>
                              </div>
                              </div>
                              <div class="rt6no" <?= (isset($sales_tax_application_details['rt6_availability']) && $sales_tax_application_details['rt6_availability'] != "No") ? "style='display:none;'" : ''; ?>>
                              <div class="form-group">
                              <label class="col-lg-2 control-label">Do you need Rt6?<span class="text-danger">*</span></label>
                              <div class="col-lg-10">
                              <label class="radio-inline">
                              <input type="radio" <?= (isset($sales_tax_application_details['need_rt6']) && $sales_tax_application_details['need_rt6'] == "Yes") ? "checked='checked'" : ''; ?> name="Rt6need" value="Yes">Yes
                              </label>
                              <label class="radio-inline">
                              <input type="radio" <?= (isset($sales_tax_application_details['need_rt6']) && $sales_tax_application_details['need_rt6'] == "No") ? "checked='checked'" : ''; ?> name="Rt6need" value="No">No
                              </label>
                              <div class="errorMessage text-danger" id="Rt6need_error"></div>
                              </div>
                              </div>
                              <div class="form-group">
                              <label class="col-lg-2 control-label">Select Resident or Non-resident<span class="text-danger">*</span></label>
                              <div class="col-lg-10">
                              <label class="radio-inline">
                              <input type="radio" <?= (isset($sales_tax_application_details['resident_type']) && $sales_tax_application_details['resident_type'] == "Resident") ? "checked='checked'" : ''; ?> name="residenttype" value="Resident">Resident
                              </label>
                              <label class="radio-inline">
                              <input type="radio" <?= (isset($sales_tax_application_details['resident_type']) && $sales_tax_application_details['resident_type'] == "Non-Resident") ? "checked='checked'" : ''; ?> name="residenttype" value="Non-Resident">Non-Resident
                              </label>
                              <div class="errorMessage text-danger" id="residenttype_error"></div>
                              </div>
                              </div>
                              </div>
                              <div class="residentclass" <?= (isset($sales_tax_application_details['resident_type']) && $sales_tax_application_details['resident_type'] != "Resident") ? "style='display:none;'" : ''; ?>>
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
                              <a target="_blank" href="<?= base_url(); ?>uploads/<?= $adl['file_name']; ?>" title="<?= $adl['file_name']; ?>"><i class="fa fa-search-plus"></i></a>
                              </div>
                              <p class="text-overflow-e" title="<?= $adl['file_name']; ?>"><?= $adl['file_name']; ?></p>
                              </li>
                              <?php else: ?>
                              <li>
                              <div class="preview preview-file">
                              <a target="_blank" href="<?= base_url(); ?>uploads/<?= $adl['file_name']; ?>" title="<?= $adl['file_name']; ?>"><i class="fa fa-download"></i></a>
                              </div>
                              <p class="text-overflow-e" title="<?= $adl['file_name']; ?>"><?= $adl['file_name']; ?></p></li>
                              <?php endif; ?>
                              <?php endforeach; ?>
                              </ul>
                              <?php endif; ?>
                              </div>
                              <div class="non-residentclass" <?= (isset($sales_tax_application_details['resident_type'])) ? ($sales_tax_application_details['resident_type'] != "Non-Resident" ? "style='display:none;'" : '') : "style='display:none;'"; ?>>
                              <div class="form-group">
                              <label class="col-lg-2 control-label">Non-resident Upload</label>
                              <div class="col-lg-10">
                              <label>Passport (pdf)<span class="text-danger">*</span></label>
                              <input class="form-control non_resident_file" allowed_types="pdf" type="file" name="passport" id="passport">
                              <div class="errorMessage text-danger"></div>
                              <?php if ($sales_tax_application_details['passport'] != '') { ?>
                              <a href="<?php echo base_url() . "uploads/" . $sales_tax_application_details['passport']; ?>">Passport</a>
                              <?php } ?>
                              </div>
                              <label class="col-lg-2 control-label"></label>
                              <div class="col-lg-10">
                              <label>Lease (pdf)<span class="text-danger">*</span></label>
                              <input class="form-control non_resident_file" type="file" allowed_types="pdf" name="lease" id="lease">
                              <div class="errorMessage text-danger"></div>
                              <?php if ($sales_tax_application_details['lease'] != '') { ?>
                              <a href="<?php echo base_url() . "uploads/" . $sales_tax_application_details['lease']; ?>">Lease</a>
                              <?php } ?>
                              </div>
                              </div>
                              </div>
                              </div> */ ?>
                            <div class="hr-line-dashed"></div>
                        <?php endif; ?>

                        <?php if (($service_shortname == 'inc_n_f_p' || $service_shortname == 'inc_n_c_n_p_f' || $service_shortname == 'inc_n_c_f' || $service_shortname == 'inc_n_c_d' || $service_shortname == 'inc_n_c_b_v_i' || $service_shortname == 'inc_n_c_o')): ?>
                            <!--   Company || New Florida PA | Create Company - Non Profit Florida    -->
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Name of Business<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="Option 1" class="form-control" id="name1" type="text" name="table[new_company][name1]" title="Name of Business" required="" value="<?= isset($company_name_option['name1']) ? $company_name_option['name1'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                    <input placeholder="Option 2" class="form-control" type="text" name="table[new_company][name2]" title="Name of Business"  value="<?= isset($company_name_option['name2']) ? $company_name_option['name2'] : ''; ?>">
                                    <input placeholder="Option 3" class="form-control" type="text" name="table[new_company][name3]" title="Name of Business"  value="<?= isset($company_name_option['name3']) ? $company_name_option['name3'] : ''; ?>">
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($service_shortname == 'inc_n_f_p' || $service_shortname == 'inc_n_c_n_p_f'):   // New Florida PA && Create Company - Non Profit Florida  ?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Company Activity<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="activity" title="Company Activity" name="table[order_extra_data][activity]"><?= isset($order_extra_data['activity']) ? $order_extra_data['activity'] : ''; ?></textarea>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($service_shortname == 'inc_n_f_p'):   // New Florida PA   ?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Social Activity<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="social_activity" title="Social Activity" name="table[order_extra_data][social_activity]"><?= isset($order_extra_data['social_activity']) ? $order_extra_data['social_activity'] : ''; ?></textarea>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Professional License Number<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input numeric_valid="" id="professional_license_number" class="form-control" type="text" title="Professional License Number" name="table[order_extra_data][professional_license_number]" value="<?= isset($order_extra_data['professional_license_number']) ? $order_extra_data['professional_license_number'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($due_date)): ?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Due Date</label>
                                <div class="col-lg-10">
                                    <input placeholder="dd/mm/yyyy" class="form-control" readonly="" type="text" title="Due Date" value="<?= $due_date; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!--                        <h3>Price</h3>
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">Retail Price</label>
                                                    <div class="col-lg-10">
                                                        <input disabled class="form-control retail-price" type="text" title="Retail Price" value="0" id="retail-price">
                                                        <input type="hidden" class="retail-price" name="retail_price" id="retail-price-hidd" value="">
                                                        <input type="hidden" class="retail-price"  id="retail-price-initialamt" value="0" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">Override Price</label>
                                                    <div class="col-lg-10">
                                                        <input placeholder="" numeric_valid="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" title="Retail Price">
                                                        <div class="errorMessage text-danger"></div>
                                                    </div>
                                                </div>-->
                        <?php if (!empty($related_service_files)): ?>
                            <ul class="uploaded-file-list">
                                <?php
                                foreach ($related_service_files as $file) :
                                    $file_name = $file['file_name'];
                                    $file_id = $file['id'];
                                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                                    $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                    if (in_array($extension, $allowed_extension)):
                                        ?>
                                        <li id="file_show_<?= $file_id; ?>">
                                            <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $file_name; ?>');max-width: 100%;">
                                                <a href="<?php echo base_url(); ?>uploads/<?= $file_name; ?>" title="<?= $file_name; ?>"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                            <p class="text-overflow-e" title="<?= $file_name; ?>"><?= $file_name; ?></p>
                                            <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                        </li>
                                    <?php else: ?>
                                        <li id="file_show_<?= $file_id; ?>">
                                            <div class="preview preview-file">
                                                <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $file_name; ?>" title="<?= $file_name; ?>"><i class="fa fa-download"></i></a>
                                            </div>
                                            <p class="text-overflow-e" title="<?= $file_name; ?>"><?= $file_name; ?></p>
                                            <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                        </li>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                            </ul>
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Attachment</label>
                            <div class="col-sm-9 col-md-10">
                                <div class="upload-file-div">
                                    <input class="file-upload" id="action_file" type="file" name="service_attachment[]" title="Upload File">
                                    <div class="errorMessage text-danger m-t-5"></div>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i> Add File</a>
                            </div>
                        </div>                       

                        <?= service_note_func('Service Note', 'n', 'service', $order_id, $service_id); ?>

                        <?php if ($service_shortname == 'acc_r_b' || $service_shortname == 'acc_b_b_d'): ?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Frequency<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control frequeny_of_bookkeeping" name="table[bookkeeping][frequency]" id="frequeny_of_bookkeeping" title="Frequency Of Bookkeeping" required>
                                        <option value="">Select an option</option>
                                        <option value="m" <?= $bookkeeping_details['frequency'] == 'm' ? 'selected' : ''; ?>>Monthly</option>
                                        <option value="q" <?= $bookkeeping_details['frequency'] == 'q' ? 'selected' : ''; ?>>Quarterly</option>
                                        <option value="y" <?= $bookkeeping_details['frequency'] == 'y' ? 'selected' : ''; ?>>Yearly</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($service_shortname == 'inc_o_a'): ?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Document Date</label>
                                <div class="col-lg-10">
                                    <input placeholder="dd/mm/yyyy" id="doc_date" class="form-control datepicker_mdy" type="text" title="Document Date" name="table[order_extra_data][document_date]" value="<?= isset($order_extra_data['document_date']) ? $order_extra_data['document_date'] : ''; ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="new_existing" id="new_existing" value="<?= $order_details['new_existing']; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="service_shortname" id="service_shortname" value="<?= $service_shortname; ?>" />
                                <input type="hidden" name="editval" id="editval" value="<?= $order_id; ?>">
                                <input type="hidden" name="order_id" id="order_id" value="<?= $order_id; ?>">
                                <input type="hidden" name="quant_employee" id="quant_employee" value="0">
                                <input type="hidden" name="service_request_id" id="service_request_id" value="<?= $service_request_id; ?>">
                                <button class="btn btn-success" type="button" onclick="saveRelatedService()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="go('services/home')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="accounts-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="employee-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script>
    $(function () {
        var serviceShortName = $('#service_shortname').val();
        //        $('.retail-price').val('<?// $service_details['retail_price']; ?>');
        //        $('#retail_price_override').val('<?// $service_request_details['price_charged']; ?>');
        if (serviceShortName == 'acc_b_b_d') {
            get_financial_account_list('<?= $reference_id; ?>', 'month_diff', '<?= $order_id; ?>');
        } else if (serviceShortName == 'acc_r_b') {
            get_financial_account_list('<?= $reference_id; ?>', '', '<?= $order_id; ?>');
        }
        if (serviceShortName == 'acc_p') {
            reload_owner_list('<?= $reference_id; ?>', 'payroll');
            reload_owner_list('<?= $reference_id; ?>', 'payroll2');
            reload_owner_list('<?= $reference_id; ?>', 'payroll3');
            get_employee_list('<?= $reference_id; ?>');
            $('input[type=radio][class=payroll_frequency]').change(function () {
                var payroll_frequency = $('input[type=radio][class=payroll_frequency]:checked').val();
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
                        success: function (result) {
                            $(".pay-period").html(result);
                        }
                    });
                }
            });

            $("#payday").change(function () {
                var payroll_frequency = $('input[type=radio][class=payroll_frequency]:checked').val();
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
                        success: function (result) {
                            $(".pay-period").html(result);
                        }
                    });
                }
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
                        if (data != 0) {
                            var res = JSON.parse(data);
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
        }

        if (serviceShortName == 'acc_s_t_a') {
            county_ajax('<?= isset($sales_tax_application_details['state_recurring']) ? $sales_tax_application_details['state_recurring'] : ''; ?>', '<?= isset($sales_tax_application_details['country_recurring']) ? $sales_tax_application_details['country_recurring'] : ''; ?>');
        }
        if (serviceShortName == 'acc_s_t_p') {
            county_ajax('<?= isset($sales_tax_processing_details['state']) ? $sales_tax_processing_details['state'] : ''; ?>', '<?= isset($sales_tax_processing_details['county']) ? $sales_tax_processing_details['county'] : ''; ?>');
        }
        if (serviceShortName == 'acc_s_t_r') {
            county_ajax('<?= isset($sales_tax_recurring_details['state']) ? $sales_tax_recurring_details['state'] : ''; ?>', '<?= isset($sales_tax_recurring_details['county']) ? $sales_tax_recurring_details['county'] : ''; ?>');
        }
        interval_total_amounts();
        $('.add-upload-file').on("click", function () {
            var text_file = $(this).prev('.upload-file-div').html();
            var file_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-2 control-label"></label><div class="col-lg-10">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });
    function removeFile(divID) {
        $("#" + divID).remove();
    }
    function deleteFile(file_id) {
        swal({
            title: "Delete!",
            text: "Are you sure to delete this file?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type: "GET",
                url: '<?= base_url(); ?>services/home/delete_related_service_file/' + file_id,
                success: function (data) {
                    if (parseInt(data.trim()) === 1) {
                        swal("Deleted!", "File has been deleted.", "success");
                        $("#file_show_" + file_id).remove();
                    }
                }
            });
        });
    }

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

    function copyPrincipal(company_princpal) {
        var base_url = '<?= base_url(); ?>';
        var reference_id = $("#reference_id").val();
        $.ajax({
            type: "POST",
            data: {
                company_princpal: company_princpal, reference_id: reference_id
            },
            url: base_url + 'services/accounting_services/set_company_principal',
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
                    } else {
                        swal("Error", "No Payroll Approver Added", "error");
                    }
                } else {
                    if (result != 0) {
                        res = JSON.parse(result);
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
                    if (result != 0) {
                        res = JSON.parse(result);
                        $("#payroll_approver_quantity").val(1);
                        $("#payroll_first_name").val(res.first_name);
                        $("#payroll_last_name").val(res.last_name);
                        $("#payroll_title").val(res.title);
                        $("#payroll_social_security").val(res.ssn_itin);
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
                    if (result != 0) {
                        res = JSON.parse(result);
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

    function copy_financial_account(financial_account_id) {
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