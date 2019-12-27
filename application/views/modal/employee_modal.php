<?php if (isset($employee_details)) { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 b-r">
                        <h2 class="m-t-none m-b">Edit Employee Info</h2>
                        <form role="form" id="form_employee" name="form_employee" onsubmit="save_employee(); return false;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" id="emp_first_name" type="text" name="first_name" value="<?= $employee_details['first_name']; ?>" title="First Name" required="" >
                                        <div class="errorMessage text-danger"></div>
                                    </div>            
                                    <div class="form-group">
                                        <label>Address<span class="text-danger">*</span></label> 
                                        <input placeholder="" class="form-control" type="text" id="emp_address" name="address" value="<?= $employee_details['address']; ?>" title="Address" required="" >
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>State<span class="text-danger">*</span></label> 
                                        <div class="ui-widget">
                                            <input placeholder="" class="form-control" type="text" id="emp_state" name="state" value="<?= $employee_details['state']; ?>" title="State" required="">
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Home Phone<span class="text-danger">*</span></label>
                                        <input class="form-control" phoneval="" type="text" name="phone_number" id="emp_phone_number" value="<?= $employee_details['phone_number']; ?>" title="Home Phone" value="" required="" >
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gender<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="gender" type="radio" <?= $employee_details['gender'] == "Male" ? "checked='checked'" : ""; ?> value="Male" name="gender" title="Gender" required="">Male</label>
                                            <label class="radio-inline"><input class="gender" type="radio" <?= $employee_details['gender'] == "Female" ? "checked='checked'" : ""; ?> value="Female" name="gender" title="Gender" required="">Female</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Employee is paid<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="is_paid" type="radio" <?= $employee_details['is_paid'] == "Hourly" ? "checked='checked'" : ""; ?> value="Hourly" name="is_paid" title="Employee is paid" required="">Hourly</label>
                                            <label class="radio-inline"><input class="is_paid" type="radio" <?= $employee_details['is_paid'] == "Salary" ? "checked='checked'" : ""; ?> value="Salary" name="is_paid" title="Employee is paid" required="">Salary</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Hire<span class="text-danger">*</span></label>
                                        <input class="form-control datepicker_mdy" type="text" title="Date of hire" id="date_of_hire" name="date_of_hire" value="<?= date('m/d/Y',strtotime($employee_details['date_of_hire'])); ?>" value="" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="text" name="last_name" id="emp_last_name" value="<?= $employee_details['last_name']; ?>" title="Last Name" value="" required="" >
                                        <div class="errorMessage text-danger"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>City<span class="text-danger">*</span></label> 
                                        <input placeholder="" class="form-control" type="text" name="city"  id="emp_city" value="<?= $employee_details['city']; ?>" title="City" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Zip<span class="text-danger">*</span></label> 
                                        <input placeholder="" class="form-control" type="text" zipval="" name="zip" id="emp_zip" value="<?= $employee_details['zip']; ?>" title="Zip" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>SS #<span class="text-danger">*</span></label> 
                                        <input placeholder="" class="form-control" type="text" name="ss" id="emp_ss" value="<?= $employee_details['ss']; ?>" title="SS #" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="email" name="email" id="email" value="<?= $employee_details['email']; ?>" id="email" title="Email" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of birth<span class="text-danger">*</span></label>
                                        <input class="form-control datepicker_mdy" type="text" title="Date of birth" id="date_of_birth" name="date_of_birth" value="<?= date('m/d/Y',strtotime($employee_details['date_of_birth'])); ?>" value="" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Employee Type<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="employee_type" type="radio" <?= $employee_details['employee_type'] == "Full-Time" ? "checked='checked'" : ""; ?> value="Full-Time" name="employee_type" title="Employee Type" required="">Full-Time</label>
                                            <label class="radio-inline"><input class="employee_type" type="radio" <?= $employee_details['employee_type'] == "Part-Time" ? "checked='checked'" : ""; ?> value="Part-Time" name="employee_type" title="Employee Type" required="">Part-Time</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>How would the employee like to receive their payroll check?<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="payroll_check" onclick="show_div('bank_info_div', 'check_div');" type="radio" <?= $employee_details['payroll_check'] == "Direct Deposit" ? "checked='checked'" : ""; ?> value="Direct Deposit" name="payroll_check" title="Payroll check" required="">Direct Deposit</label>
                                            <label class="radio-inline"><input class="payroll_check" onclick="show_div('check_div', 'bank_info_div');" type="radio" <?= $employee_details['payroll_check'] == "Paper Check" ? "checked='checked'" : ""; ?> value="Paper Check" name="payroll_check" title="Payroll check" required="">Paper Check</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Voided Cheque (pdf)<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="file" name="bank_file" title="Voided Cheque " id="bank_file" <?= $employee_details['bank_file'] != "" ? "required" : ""; ?>>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="bank_info_div">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bank account type<span class="text-danger">*</span></label>
                                            <div class="radio">
                                                <label class="radio-inline"><input class="bank_account_type" type="radio" value="Checking" name="bank_account_type" <?= $employee_details['bank_account_type'] == "Checking" ? "checked='checked'" : ""; ?> title="Bank account type">Checking</label>
                                                <label class="radio-inline"><input class="bank_account_type" type="radio" value="Saving" name="bank_account_type" <?= $employee_details['bank_account_type'] == "Saving" ? "checked='checked'" : ""; ?> title="Bank account type">Saving</label>
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bank Routing #<span class="text-danger">*</span></label>
                                            <input placeholder="" class="form-control" type="text" id="bank_routing_modal" name="bank_routing" value="<?= $employee_details['bank_routing']; ?>" title="Bank Routing #">
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Bank Account #<span class="text-danger">*</span></label>
                                            <input placeholder="" class="form-control" type="text" id="bank_account_modal" name="bank_account" value="<?= $employee_details['bank_account']; ?>" title="Bank Account #">
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hourly Rate or Salary Per Pay Period<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="text" name="hourly_rate" id="hourly_rate" value="<?= $employee_details['hourly_rate']; ?>" title="Pay Period" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label># of Allowances from IRS Form W-4<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="text" name="irs_form" id="irs_form" value="<?= $employee_details['irs_form']; ?>" title="IRS Form W-4" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Filing Status<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="filing_status" type="radio" <?= $employee_details['filing_status'] == "Single" ? "checked='checked'" : ""; ?> value="Single" name="filing_status" title="Filing Status" required="">Single</label>
                                            <label class="radio-inline"><input class="filing_status" type="radio" <?= $employee_details['filing_status'] == "Married" ? "checked='checked'" : ""; ?> value="Married" name="filing_status" title="Filing Status" required="">Married</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="employee_data_div">
                                        <?php if ($employee_details['w4_file'] != "") { ?>
                                            <h3>W4 Form &nbsp;&nbsp; <a href="<?= base_url() ?>uploads/<?= $employee_details['w4_file']; ?>" download="Form_W4.pdf">Download Previous PDF</a></h3><span class="employee-data"></span>
                                        <?php } else { ?>
                                            <h3>W4 Form &nbsp;&nbsp; <a href="<?= base_url() ?>forms/w4.pdf" download="Form_W4.pdf">Download New PDF</a></h3><span class="employee-data"></span>
                                        <?php
                                        }

                                        if ($employee_details['i9_file'] != "") {
                                            ?>
                                            <h3>I9 Form &nbsp;&nbsp;&nbsp;&nbsp; <a href="<?= base_url() ?>uploads/<?= $employee_details['i9_file']; ?>" download="Form_I9.pdf">Download Previous PDF</a></h3><span class="employee-data"></span>
                                        <?php } else { ?>
                                            <h3>I9 Form &nbsp;&nbsp;&nbsp;&nbsp; <a href="<?= base_url() ?>forms/i9.pdf" download="Form_I9.pdf">Download New PDF</a></h3><span class="employee-data"></span>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="row">
                                <div id="signer_data_div">
                                    <div class="col-md-12">
                                        <label>Fillup And Upload Payroll Forms<span class="text-danger">*</span></label>
                                        <input placeholder="W4 Form" id="w4" class="form-control" type="file" name="w4" title="W4 Form">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Upload I9 From (Pdf)<span class="text-danger">*</span></label>
                                        <input placeholder="I9 From" id="i9" class="form-control" type="file" name="i9" title="I9 From">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="editval" id="employee_id" value="<?= $employee_details['id']; ?>">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="save_employee()">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 b-r">
                        <h2 class="m-t-none m-b">Add Employee Info</h2>
                        <input type="radio" id="w2_id" class="category" name="category" checked="" onclick="category()">W2 &nbsp;&nbsp;&nbsp;
                        <input type="radio" id="1099_id" class="category" name="category" onclick="category()">1099
                        <form role="form" id="form_employee" name="form_employee" onsubmit="save_employee(); return false;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="text" id="emp_first_name" name="first_name" title="First Name" value="" required="" >
                                        <div class="errorMessage text-danger"></div>
                                    </div>            
                                    <div class="form-group">
                                        <label>Address<span class="text-danger">*</span></label> 
                                        <input placeholder="" class="form-control" type="text" id="emp_address" name="address" title="Address" required="" >
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>State<span class="text-danger">*</span></label> 
                                        <div class="ui-widget">
                                            <input placeholder="" class="form-control" type="text" id="emp_state" name="state" title="State" required="">
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Home Phone<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" phoneval="" id="emp_phone_number" name="phone_number" title="Home Phone" value="" required="" >
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gender<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="gender" type="radio" value="Male" name="gender" title="Gender" required="">Male</label>
                                            <label class="radio-inline"><input class="gender" type="radio" value="Female" name="gender" title="Gender" required="">Female</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Employee is paid<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="is_paid" type="radio" value="Hourly" name="is_paid" class="is_paid" title="Employee is paid" required="">Hourly</label>
                                            <label class="radio-inline"><input class="is_paid" type="radio" value="Salary" name="is_paid" class="is_paid" title="Employee is paid" required="">Salary</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Hire<span class="text-danger">*</span></label>
                                        <input class="form-control datepicker_mdy" type="text" title="Date of hire" id="date_of_hire" name="date_of_hire" value="" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="text" id="emp_last_number" name="last_name" title="Last Name" value="" required="" >
                                        <div class="errorMessage text-danger"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>City<span class="text-danger">*</span></label> 
                                        <input placeholder="" class="form-control" type="text" id="emp_city" name="city" title="City" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Zip<span class="text-danger">*</span></label> 
                                        <input placeholder="" class="form-control" type="text" zipval="" id="emp_zip" name="zip" title="Zip" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>

                                    <div class="form-group" id="xyz">
                                        <label>SS #<span class="text-danger">*</span></label> 
                                        <input placeholder="" class="form-control" type="text" id="emp_ss" name="ss" title="SS #" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group" id="email_div">
                                        <label>Email<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="email" name="email" id="email" title="Email" value="" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of birth<span class="text-danger">*</span></label>
                                        <input class="form-control datepicker_mdy" type="text" title="Date of birth" id="date_of_birth" name="date_of_birth" value="" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group" id="e_type">
                                        <label>Employee Type<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="employee_type" type="radio" value="Full-Time" name="employee_type" class="employee_type" title="Employee Type" required="">Full-Time</label>
                                            <label class="radio-inline"><input class="employee_type" type="radio" value="Part-Time" name="employee_type" class="employee_type" title="Employee Type" required="">Part-Time</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>How would the employee like to receive their payroll check?<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="payroll_check" onclick="show_div('bank_info_div', 'check_div');" type="radio" value="Direct Deposit" name="payroll_check" title="Payroll check" required="">Direct Deposit</label>
                                            <label class="radio-inline"><input class="payroll_check" onclick="show_div('check_div', 'bank_info_div');" type="radio" value="Paper Check" name="payroll_check" title="Payroll check" required="">Paper Check</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="v_cheque">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Voided Cheque (pdf)<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="file" name="bank_file" title="Voided Cheque" id="bank_file" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="bank_info_div">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bank account type<span class="text-danger">*</span></label>
                                            <div class="radio">
                                                <label class="radio-inline"><input class="bank_account_type" type="radio" value="Checking" name="bank_account_type" title="Bank account type">Checking</label>
                                                <label class="radio-inline"><input class="bank_account_type" type="radio" value="Saving" name="bank_account_type" title="Bank account type">Saving</label>
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bank Routing #<span class="text-danger">*</span></label>
                                            <input placeholder="" class="form-control" type="text" id="bank_routing_modal" name="bank_routing" title="Bank Routing #">
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Bank Account #<span class="text-danger">*</span></label>
                                            <input placeholder="" class="form-control" type="text" id="bank_account_modal" name="bank_account" title="Bank Account #">
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hourly Rate or Salary Per Pay Period<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="text" name="hourly_rate" id="hourly_rate" title="Pay Period" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <label># of Allowances from IRS Form W-4<span class="text-danger">*</span></label>
                                        <input placeholder="" class="form-control" type="text" name="irs_form" id="irs_form" title="IRS Form W-4" required="">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Filing Status<span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline"><input class="filing_status" type="radio" value="Single" name="filing_status" title="Filing Status" required="">Single</label>
                                            <label class="radio-inline"><input class="filing_status" type="radio" value="Married" name="filing_status" title="Filing Status" required="">Married</label>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="form_id">
                                    <div id="employee_data_div">
                                        <h3>W4 Form &nbsp;&nbsp; <a href="<?= base_url() ?>forms/w4.pdf" download="Form_W4.pdf">Download The PDF</a></h3><span class="employee-data"></span>
                                        <h3>I9 Form &nbsp;&nbsp;&nbsp;&nbsp; <a href="<?= base_url() ?>forms/i9.pdf" download="Form_I9.pdf">Download The PDF</a></h3><span class="employee-data"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="row" id="f_u_w4_i9_form">
                                <div id="signer_data_div">
                                    <div class="col-md-12" id="pdf1">
                                        <label>Fillup And Upload W4 From (Pdf)<span class="text-danger">*</span></label>
                                        <input placeholder="W4 Form" id="w4" class="form-control" type="file" name="w4" required="" title="W4 Form">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                    <div class="col-md-12" id="pdf2">
                                        <label>Fillup And Upload I9 From (Pdf)<span class="text-danger">*</span></label>
                                        <input placeholder="I9 From" id="i9" class="form-control" type="file" name="i9" required="" title="I9 From">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="abc" hidden="">
                                <label>SSN:<span class="text-danger">*</span></label>                                       
                                <input data-mask="999-99-9999" placeholder="___-__-____" class="form-control" type="text" id="ssn_name" name="ssn_name" title="SSN" required="">
                                <div class="errorMessage text-danger"></div>                                   
                            </div>
                            <div class="form-group" id="mno" hidden="">
                                <label>Salary Rate<span class="text-danger">*</span></label>                                       
                                <input placeholder="$" class="form-control" type="text" id="salary_rate" name="salary_rate" title="Salary Rate" required="">
                                <div class="errorMessage text-danger"></div>                                   
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="editval" id="employee_id" value="">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="save_employee()">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
        $(function () {
        $('#date_of_birth,#date_of_hire').datepicker({format: 'mm/dd/yyyy',autoHide: true});
        $('#date_of_birth,#date_of_hire').attr("onblur", 'checkDate(this);');
        var availableTags = [<?= get_array_states(); ?>];
        $("#emp_state").autocomplete({
            source: availableTags
        });
<?php
if (isset($employee_details)) {
    if ($employee_details["payroll_check"] == "Direct Deposit") {
        ?>
                $("#check_div").hide();
                $("#bank_info_div").show();
    <?php } else { ?>
                $("#check_div").show();
                $("#bank_info_div").hide();
        <?php
    }
} else {
    ?>
            $("#check_div").hide();
            $("#bank_info_div").hide();
<?php } ?>
    });
    function show_div(show, hide) {
        if (show == "bank_info_div") {
            $("#bank_account_modal").attr("required", "required");
            $("#bank_routing_modal").attr("required", "required");
            $(".bank_account_type").attr("required", "required");
            $("#bank_file").attr("required", "required");
        } else if (show == "check_div") {
            $("#bank_file").removeAttr("required");
            $("#bank_account_modal").removeAttr("required");
            $("#bank_routing_modal").removeAttr("required");
            $(".bank_account_type").removeAttr("required");
        } else {
            $("#bank_file").removeAttr("required");
            $("#bank_account_modal").removeAttr("required");
            $("#bank_routing_modal").removeAttr("required");
            $(".bank_account_type").removeAttr("required");
        }
        <?php
        if (isset($employee_details)) {
            if ($employee_details["payroll_check"] == "Direct Deposit") {
                ?>
                        $("#bank_file").removeAttr("required");
                <?php
            }
        }
        ?>
        $("#" + show).show();
        $("#" + hide).hide();
    }
    
        if(document.getElementById('w2_id').checked == true)
        {
             $("#ssn_name").removeAttr('required');
             $("#salary_rate").removeAttr('required');
             $("#abc").hide();
             $("#mno").hide();
             $("#xyz").show();
             $("#email_div").show();
             $("#email").attr("required", "required");
             $("#e_type").show();
             $("#v_cheque").show();
             $("#f_u_w4_i9_form").show();    
        }
        function category() 
        {
        if(document.getElementById('1099_id').checked == true)
        {
            $("#abc").show();
            $("#mno").show();
            $("#emp_ss").removeAttr('required');
            $("#xyz").hide();
            $("#email").removeAttr('required');
            $("#email_div").hide();
            $(".employee_type").removeAttr('required');
            $("#e_type").hide();
            $("#bank_file").removeAttr('required');
            $("#v_cheque").hide(); 
            $("#w4").removeAttr('required');
            $("#pdf1").hide();
            $("#i9").removeAttr('required');
            $("#pdf2").hide();
            $("#form_id").hide();
        }
        if(document.getElementById('w2_id').checked == true)
        {
             $("#ssn_name").removeAttr('required');
             $("#salary_rate").removeAttr('required');
             $("#abc").hide();
             $("#mno").hide();
             $("#xyz").show();
             $("#email_div").show();
             $("#email").attr("required", "required");
             $("#e_type").show();
             $("#v_cheque").show();
             $("#bank_file").attr("required", "required");
             $("#f_u_w4_i9_form").show();  
             $("#pdf1").show();
             $("#w4").attr("required", "required");
             $("#pdf2").show();
             $("#i9").attr("required", "required");
             $("#form_id").show();
        }
    }
        
    
</script>