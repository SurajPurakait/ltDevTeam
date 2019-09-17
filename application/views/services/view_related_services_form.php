<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md">
        <?php
        $content = '';
        if ($service_shortcode == 'acc_b_b_d') {
            $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>';
            if ($override_price != "") {
                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Bookkeeping Price:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $override_price . '</td>
                </tr>';
            }
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Financial Accounts:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

            if ($acc_list) {
                foreach ($acc_list as $title) {
                    $type = $title->type_of_account;
                    if (strpos($type, 'Account') !== false) {
                        $short_type = str_replace('Account', '', $type);
                    } else {
                        $short_type = $type;
                    }

                    $content .= "<div class='media-body'><label class='label label-primary'>" . $short_type . "</label>
                              <h4 class='media-heading'> " . $title->bank_name . " </h4>
                                <p>
                                    Total Amount: " . "$" . $title->total_amount . " <br>
                                    # Of Transactions: " . $title->number_of_transactions . "
                                </p></div>";
                }
            }
            $content .= '</td>
            </tr>';
            $content .= '</tbody></table><tbody><table>';
        } elseif ($service_shortcode == 'acc_r_b') {
            $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>';
            if ($override_price != "") {
                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Bookkeeping Price:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $override_price . '</td>
                </tr>';
            }
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Financial Accounts:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
            if ($acc_list) {
                foreach ($acc_list as $title) {
                    $type = $title->type_of_account;
                    if (strpos($type, 'Account') !== false) {
                        $short_type = str_replace('Account', '', $type);
                    } else {
                        $short_type = $type;
                    }

                    $content .= "<div class='media-body'><label class='label label-primary'>" . $short_type . "</label>
                                            <h4 class='media-heading'> " . $title->bank_name . " </h4>
                                            <p>
                                                Grand Total Amount: " . "$" . $title->grand_total . " <br>
                                                # Of Transactions: " . $title->number_of_transactions . "
                                            </p></div>";
                }
            }
            $content .= '</td>
            </tr>';
            $content .= '<tr>
                    <td>Frequency Of Bookkeeping:</td>';
            if (isset($bookkeeping_data['frequency']) && $bookkeeping_data['frequency'] == 'm') {
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Monthly</td>';
            } elseif (isset($bookkeeping_data['frequency']) && $bookkeeping_data['frequency'] == 'q') {
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Quarterly</td>';
            } elseif (isset($bookkeeping_data['frequency']) && $bookkeeping_data['frequency'] == 'y') {
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Yearly</td>';
            }
            $content .= '</tr>';
            $content .= '</tbody></table><tbody><table>';
        } elseif ($service_shortcode == 'acc_p') {
            $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>';
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['bank_name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Account #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['ban_account_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Routing #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['bank_routing_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Do you
                    have a RT-6 #?:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['rt6_availability'] . '</td>
            </tr>';
            if ($payroll_account_numbers['rt6_availability'] == "Yes") {
                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        RT-6 Number:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['rt6_number'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['state'] . '</td>
                </tr>';
            } else {
                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Resident or Non-resident:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['resident_type'] . '</td></tr>';
            }


            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Frequency:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_data['payroll_frequency'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Payday:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_data['payday'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Pay
                    Period Ending:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month</td></tr>';

            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver First Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['fname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Last Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['lname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Title:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['title'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Social Security #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['social_security'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Phone Number:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['phone'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Ext:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['ext'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Fax:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['fax'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Email:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['email'] . '</td></tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal First Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['fname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Last Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['lname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Title:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['title'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Social Security #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['social_security'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Phone Number:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['phone'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Ext:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['ext'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Fax:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['fax'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Email:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['email'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Signer
                    Data First Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $signer_data['fname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Signer
                    Data Last Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $signer_data['lname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Signer
                    Data Social Security #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $signer_data['social_security'] . '</td>
            </tr>';

            $content .= '</tbody></table><tbody><table>';
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Employee Data:
                </td>';

            if ($employee_list) {
                $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                foreach ($employee_list as $el) {
                    $content .= "<div class='media-body'><label
                                    class='label label-primary'>" . $el['employee_type'] . "</label>
                            <h4 class='media-heading'>Employee
                                Name: " . $el['first_name'] . " " . $el['last_name'] . " </h4>
                            <p>
                                Phones: " . $el['phone_number'] . "<br>
                                Email: " . $el['email'] . "<br>
                                Address: " . $el['address'] . "<br>
                                City: " . $el['city'] . "<br>
                                State: " . $el['state'] . "<br>
                                Zip: " . $el['zip'] . "<br>
                                Home Phone: " . $el['phone_number'] . "<br>
                                SS #: " . $el['ss'] . "<br>
                                Gender: " . $el['gender'] . "<br>
                                Email: " . $el['email'] . "<br>
                                Pay Type: " . $el['is_paid'] . "<br>
                                Date Of Birth: " . date('m/d/Y', strtotime($el['date_of_birth'])) . "<br>
                                Date Of Hire: " . date('m/d/Y', strtotime($el['date_of_hire'])) . "<br>
                                Payroll Check Receive Type: " . $el['payroll_check'] . "<br>";
                    if ($el['payroll_check'] == 'Direct Deposit') {
                        $content .= "Bank Account Type: " . $el['zip'] . "<br>
                                    Bank Account #: " . $el['zip'] . "<br>
                                    Bank Routing #: " . $el['zip'] . "<br>";
                    }
                    $content .= "Hourly Rate or Salary Per Pay Period: " . $el['hourly_rate'] . "<br>
                                Filing Status: " . $el['filing_status'] . "<br>
                                # of Allowances from IRS Form W-4: " . $el['irs_form'] . "
                            </p></div>";
                }
                $content .= "</td>";
            }

            $content .= '</tr>
                <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">How many people are on payroll:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $employee_details['payroll_people_total'] . '</td>
                </tr>
                <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Retail Price ($ Per Month):
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $employee_details['retail_price'] . '</td>
                </tr>
                <tr>    
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Override Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $employee_details['override_price'] . '</td>
                </tr>';
            if (!empty($payroll_wage_files)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Wage Files:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($payroll_wage_files);
                foreach ($payroll_wage_files as $wage_files) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $wage_files['file_name'] . ' ;>' . $wage_files['file_name'] . '</a><br>';
                    if ($i == $len - 1) {
                        $filesval .= $wage_files['file_name'];
                    } else {
                        $filesval .= $wage_files['file_name'] . ', ';
                    }
                    $i++;
                }
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="' . base_url() . 'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="' . $filesval . '">';
                $content .= '<button type="submit">Download All</button></form></td>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Wage Files:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $content .= 'N/A';
                $content .= '</td></tr>';
            }

            if (!empty($payroll_account_numbers)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $payroll_account_numbers['void_cheque'] . ' ;>' . $payroll_account_numbers['void_cheque'] . '</a><br>';

                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= 'N/A';

                $content .= '</td></tr>';
            }
            if ($payroll_account_numbers['passport'] != "") {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $payroll_account_numbers['passport'] . ' ;>' . $payroll_account_numbers['passport'] . '</a><br>';

                $content .= '</td></tr>';
            } else {

                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $content .= 'N/A';
                $content .= '</td></tr>';
            }

            if ($payroll_account_numbers['lease'] != "" && file_exists($payroll_account_numbers['lease'])) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $payroll_account_numbers['lease'] . ' ;>' . $payroll_account_numbers['lease'] . '</a><br>';

                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $content .= 'N/A';
                $content .= '</td></tr>';
            }
            if ($payroll_company_data['fein_filename'] != "" && file_exists($payroll_company_data['fein_filename'])) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FEIN File:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $payroll_company_data['fein_filename'] . ' ;>' . $$payroll_company_data['fein_filename'] . '</a><br>';

                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FEIN File:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $content .= 'N/A';
                $content .= '</td></tr>';
            }

            if (!empty($payroll_driver_license_data)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll Driver License File:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

                foreach ($payroll_driver_license_data as $license_data) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $license_data['file_name'] . ' ;>' . $license_data['file_name'] . '</a><br>';
                }
                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll Driver License File:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $content .= 'N/A';
                $content .= '</td></tr>';
            }
            $content .= '</td></tr>';
            $content .= '</tbody></table><tbody><table>';
        } elseif ($service_shortcode == 'acc_s_t_a') {
            $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>';
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State of Sales Tax:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . ($sales_tax_data['state_recurring'] != 0 ? state_info($sales_tax_data['state_recurring'])['state_name'] : 'N/A') . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">County of Sales Tax:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . ($sales_tax_data['country_recurring'] != 0 ? county_info($sales_tax_data['country_recurring'])['name'] : 'N/A') . '</td>
            </tr>';
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Account #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_account_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Routing #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_routing_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Do you
                    have a RT-6 #?:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['rt6_availability'] . '</td>
            </tr>';
            if ($sales_tax_data['rt6_availability'] == "Yes") {
                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        RT-6 Number:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['rt6_number'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['state'] . '</td>
                </tr>';
            } else {
                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Resident or Non-resident:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['resident_type'] . '</td>
                </tr>';
            }
            if ($sales_tax_data['void_cheque'] != "") {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['void_cheque'] . ' ;>' . $sales_tax_data['void_cheque'] . '</a><br>';

                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= 'N/A';

                $content .= '</td></tr>';
            }

            if ($sales_tax_data['passport'] != "") {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['passport'] . ' ;>' . $sales_tax_data['passport'] . '</a><br>';

                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= 'N/A';

                $content .= '</td></tr>';
            }
            if ($sales_tax_data['lease'] != "") {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['lease'] . ' ;>' . $sales_tax_data['lease'] . '</a><br>';

                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $content .= 'N/A';
                $content .= '</td></tr>';
            }
            if (!empty($salestax_driver_license_data)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Salestax Driver License File:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

                foreach ($salestax_driver_license_data as $license_data) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $license_data['file_name'] . ' ;>' . $license_data['file_name'] . '</a><br>';
                }
                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Salestax Driver License File:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= 'N/A';

                $content .= '</td></tr>';
            }
            $content .= '</td></tr>';
            $content .= '</tbody></table>';
        } elseif ($service_shortcode == 'acc_s_t_r') {
            if ($recurring_data->freq_of_salestax == 'm') {
                $freq_of_salesrax = 'Monthly';
            } else if ($recurring_data->freq_of_salestax == 'q') {
                $freq_of_salesrax = 'Quarterly';
            } else if ($recurring_data->freq_of_salestax == 'b') {
                $freq_of_salesrax = 'BI-ANNUAL';
            } else if ($recurring_data->freq_of_salestax == 'y') {
                $freq_of_salesrax = 'Yearly';
            }
            $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>';
            $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $override_price['price_charged'] . '</td>
                </tr>';
            $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Sales Tax Id:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $recurring_data->sales_tax_id . '
            </td>
        </tr>';
            $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
            Password:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $recurring_data->password . '
            </td>
        </tr>';

            $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
            Website:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $recurring_data->website . '
            </td>
        </tr>';
            $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
           Frequency Of Salestax:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $freq_of_salesrax . '
            </td>
        </tr>';

            $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State of Salestax:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $state_name->state_name . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        County of Salestax:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $county->name . '</td>
                </tr>';
            $content .= '</tbody></table>';
        } elseif ($service_shortcode == 'acc_s_t_p') {
            if ($processing_data->frequeny_of_salestax == 'm') {
                $freq_of_salesrax = 'Monthly';
            } else if ($processing_data->frequeny_of_salestax == 'q') {
                $freq_of_salesrax = 'Quarterly';
            } else if ($processing_data->frequeny_of_salestax == 'y') {
                $freq_of_salesrax = 'Yearly';
            }
            $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>';
            $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $override_price['price_charged'] . '</td>
                </tr>';
            $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
           Frequency Of Salestax:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $freq_of_salesrax . '
            </td>
        </tr>';

            $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State of Recurring:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $state_name->state_name . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        County of Recurring:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $county->name . '</td>
                </tr>';
            $content .= '</tbody></table>';
        } elseif ($service_shortcode == 'acc_r_u_a') {
            $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>';
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Account #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_account_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Routing #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_routing_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Will the company need Sales Tax Application as well?:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['salestax_availability'] . '</td>
            </tr>';
            if ($sales_tax_data['salestax_availability'] == "Yes") {
                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Sales Tax Number:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['salestax_number'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['state'] . '</td>
                </tr>';
            } else {
                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Resident or Non-resident:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['resident_type'] . '</td>
                </tr>';
            }
            if ($sales_tax_data['void_cheque'] != "" && file_exists($sales_tax_data['void_cheque'])) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['void_cheque'] . ' ;>' . $sales_tax_data['void_cheque'] . '</a><br>';

                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= 'N/A';

                $content .= '</td></tr>';
            }
            if (!empty($salestax_driver_license_data)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Salestax Driver License File:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

                foreach ($salestax_driver_license_data as $license_data) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $license_data['file_name'] . ' ;>' . $license_data['file_name'] . '</a><br>';
                }
                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Salestax Driver License File:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= 'N/A';

                $content .= '</td></tr>';
            }
            if ($sales_tax_data['passport'] != "") {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['passport'] . ' ;>' . $sales_tax_data['passport'] . '</a><br>';

                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= 'N/A';

                $content .= '</td></tr>';
            }
            if ($sales_tax_data['lease'] != "" && file_exists($sales_tax_data['lease'])) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['lease'] . ' ;>' . $sales_tax_data['lease'] . '</a><br>';

                $content .= '</td></tr>';
            } else {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $content .= 'N/A';
                $content .= '</td></tr>';
            }
            $content .= '</td></tr>';
            $content .= '</tbody></table>';
        }
        echo $content;
        ?>  

        <div class="text-right">
            <button class="btn btn-danger" type="button" onclick="go('services/home');">Back to dashboard</button>
        </div>
    </div>
</div>