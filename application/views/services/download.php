<?php
$td_style = "padding: 12px; vertical-align: top; border-top: 1px solid #ddd; line-height: 6px;";
$all_document = [];
?>
<table style="width: 100%; vertical-align: top;" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
           <td colspan="2"><?php if(isset($internal_data['office_photo']) && $internal_data['office_photo'] != ''): ?>
                <?php
                /*echo base_url('/uploads/') . $internal_data['office_photo'];
                echo var_dump(file_exists(FCPATH.'uploads/'.$internal_data['office_photo']));exit;*/
                if(file_exists(FCPATH.'uploads/'.$internal_data['office_photo'])): 
                ?><img src="<?= base_url('/uploads/') . $internal_data['office_photo']; ?>" height="40px" width="40px"><?php endif; ?>
            <?php endif; ?></td> 
        </tr>
        <tr><td></td></tr>
        <tr>   
            <td style="line-height: 6px; border: 1px solid #ddd; width:40%;font-size: 30px">&nbsp;&nbsp;<b style="font-size: 30px">Order#: </b></td><td style="line-height: 6px; border: 1px solid #ddd; width:60%;font-size: 30px">&nbsp;&nbsp;<?= $order_info['order_id']; ?></td>
        </tr>
        <tr><td style="line-height: 6px; border:1px solid #ddd; width:40%;font-size: 30px" >&nbsp;&nbsp;<b>Service Name: </b></td><td style="line-height: 6px; border: 1px solid #ddd; width:60%; border-left: 1px solid #ddd;font-size: 30px">&nbsp;&nbsp;<?= $order_info['service_name']; ?></td></tr>         
    </tbody>
</table><br/><br/>
<table style="width: 100%; border-top: 1px solid #ddd; border-right: 1px solid #ddd; border-left: 1px solid #ddd; font-size:30px">
    <tbody>
    <?php if (isset($company_info["state_name"]) && $company_info["state_name"] != ''): ?>
        <tr><td style="<?= $td_style; ?> width:40%; font-size: 30px">&nbsp;<b>State of Incorporation: </b></td><td style="<?= $td_style; ?> width:60%; font-size: 30px">&nbsp;<?= $company_info["state_name"]; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_info['name']) && $company_info['name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size: 30px">&nbsp;<b>Name Of Business: </b></td>
            <td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $company_info['name']; ?><?php if (!empty($company_name_option)): ?>
                    <?= $company_name_option['name2'] != "" ? "<br>" . $company_name_option['name2'] : ""; ?>
                    <?= $company_name_option['name3'] != "" ? "<br>" . $company_name_option['name3'] : ""; ?>
                <?php endif; ?>                        
            </td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_info['main_order_status']) && $order_info['main_order_status'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Tracking: </b></td><td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $order_status_array[$order_info['main_order_status']]; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_info['create_date']) && $order_info['create_date'] != '' && $order_info['create_date'] != '0000-00-00'): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Date Requested: </b></td><td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= date('m/d/Y', strtotime($order_info['create_date'])); ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_info['start_date']) && $order_info['start_date'] != '' && $order_info['start_date'] != '0000-00-00'): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Start Date: </b></td><td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= date('m/d/Y', strtotime($order_info['start_date'])); ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_info['complete_date']) && $order_info['complete_date'] != '' && $order_info['complete_date'] != '0000-00-00'): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Completed Date: </b></td>
            <td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= date('m/d/Y', strtotime($order_info['complete_date'])); ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_info['total_of_order']) && $order_info['total_of_order'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Amount: </b></td>
            <td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= "$" . number_format((float) $order_info['total_of_order'], 2, '.', ''); ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_info['requested_staff_name']) && $order_info['requested_staff_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Requested By: </b></td>
            <td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $order_info['requested_staff_name']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_info['company_type']) && $company_info['company_type'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Type of Company: </b></td>
            <td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $company_info['company_type']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_info['fye']) && $company_info['fye'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Fiscal Year End: </b></td>
            <td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= date("F", strtotime("2000-" . $company_info['fye'] . "-01")); ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_info['dba']) && $company_info['dba'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>DBA: </b></td><td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $company_info['dba']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_info['business_description']) && $company_info['business_description'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Business Description: </b></td><td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= urldecode($company_info['business_description']); ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_extra_data['phone_number']) && $company_extra_data['phone_number'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Phone Number: </b></td><td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $company_extra_data['phone_number']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_extra_data['company_started']) && $company_extra_data['company_started'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Company Started :</b></td><td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $company_extra_data['company_started']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_extra_data['state']) && $company_extra_data['state'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>State: </b></td>
            <td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $company_extra_data['state']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_extra_data['zip']) && $company_extra_data['zip'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>ZIP: </b></td><td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $company_extra_data['zip']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_extra_data['city']) && $company_extra_data['city'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>City: </b></td><td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $company_extra_data['city']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($company_extra_data['company_address']) && $company_extra_data['company_address'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>font-size: 30px">&nbsp;<b>Company Address: </b></td>
            <td style="<?= $td_style; ?> font-size: 30px">&nbsp;<?= $company_extra_data['company_address']; ?></td>
        </tr>
    <?php endif; ?>    
    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px;"><h3>&nbsp;Property Address: </h3></td>
    </tr>
    <tr>
        <td style="<?= $td_style; ?>">&nbsp;</td>
        <?php if (!empty($order_extra_data['property_address'])): ?><td style="<?= $td_style; ?> font-size: 30px; line-height: 5px;">&nbsp;<b>Property Address: </b><?= $order_extra_data['property_address']; ?><br/>&nbsp;<b>Property City:  </b><?= $order_extra_data['property_city']; ?><br/>&nbsp;<b>Property State:  </b><?= $order_extra_data['property_state']; ?><br/>&nbsp;<b>Property Zip:  </b><?= $order_extra_data['property_zip']; ?><br/>&nbsp;<b>Closing Date:  </b><?= $order_extra_data['closing_date']; ?>
                </td>
        <?php else: ?><td style="<?= $td_style; ?>"> N/A</td>
        <?php endif; ?>
    </tr>
    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px;"><h3>&nbsp;Buyer Information: </h3></td>
    </tr>
    <tr>
        <td style="<?= $td_style; ?>">&nbsp;</td>
        <?php if (!empty($buyers_info)): ?><td style="<?= $td_style; ?> font-size: 30px; line-height: 5px;"><?php foreach ($buyers_info as $bi): ?>&nbsp;<b>Itin Number: </b><?= $bi['itin_number']; ?><br/>&nbsp;<b>Full Name:  </b><?= $bi['fullname']; ?><br/>&nbsp;<b>Contact Information:  </b><?= $bi['contact_information']; ?><br><br>
                <?php endforeach; ?></td>
        <?php else: ?><td style="<?= $td_style; ?>"> N/A</td>
        <?php endif; ?>
    </tr>
    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px;"><h3>&nbsp;Seller Information: </h3></td>
    </tr>
    <tr>
        <td style="<?= $td_style; ?>">&nbsp;</td>
        <?php if (!empty($sellers_info)): ?><td style="<?= $td_style; ?> font-size: 30px; line-height: 5px;"><?php foreach ($sellers_info as $si): ?>&nbsp;<b>Itin Number: </b><?= ($si['itin_number'] != "" && $si['itin_number'] != 0) ? $si['itin_number']:"N/A"; ?><br/>&nbsp;<b>Full Name:  </b><?= $si['fullname']; ?><br/>&nbsp;<b>Contact Information:  </b><?= $si['contact_information']; ?><br/>&nbsp;<b>Full Address:  </b><?= ($si['full_address'] != "") ? $si['full_address']:"N/A"; ?><br/>&nbsp;<b>Passport:  </b><?= ($si['passport'] != "") ? $si['passport']:"N/A"; ?><br/>&nbsp;<b>Visa:  </b><?= ($si['visa'] != "") ? $si['visa']:"N/A" ?><br><br>
                <?php endforeach; ?></td>
        <?php else: ?><td style="<?= $td_style; ?>"> N/A</td>
        <?php endif; ?>
    </tr>
    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px;"><h3>&nbsp;Contact Info: </h3></td>
    </tr>
    <tr>
        <td style="<?= $td_style; ?>">&nbsp;</td>
        <?php if (!empty($contact_list)): ?><td style="<?= $td_style; ?> font-size: 30px; line-height: 5px;"><?php foreach ($contact_list as $cl): ?>&nbsp;<b><span style="background-color: #1ab394; display: inline-block; color: #fff; font-size: 24px; line-height:normal;">&nbsp; <?= $cl['type']; ?> &nbsp;</span><br>&nbsp;Contact Name: <?= $cl['last_name'] . ', ' . $cl['first_name'] . ' ' . $cl['middle_name']; ?></b><br/>&nbsp;<b>Phones: </b><?= $cl['phone1'] . '(' . $cl['phone1_country_name'] . ')'; ?><br/>&nbsp;<b>Email:  </b><?= $cl['email1']; ?><br/>&nbsp;<b>Address:  </b><?= $cl['address1'] . ', ' . $cl['city'] . ', '.'&nbsp;'. $cl['state'].',' . $cl['country_name']; ?><br/>&nbsp;<b>ZIP: </b><?= $cl['zip']  ?>
                <?php endforeach; ?></td>
        <?php else: ?><td style="<?= $td_style; ?>"> N/A</td>
        <?php endif; ?>
    </tr>

    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px"><h3>&nbsp;Owners: </h3></td>
    </tr>
    <?php if (!empty($owner_list)): ?>
    <?php foreach ($owner_list as $ol): ?>
    <tr>
        <td style="<?= $td_style; ?> border-top:none;">&nbsp;</td>
            <td style="padding: 12px; vertical-align: top; "><table width="100%" cellpadding="5" cellspacing="1" style="border:none ; font-size: 30px; line-height: 5px;"><tr><td><span style="background-color: #1ab394; display: inline-block; color: #fff; font-size: 24px;">&nbsp; <?= $ol['title']; ?> &nbsp;</span><br/><b>Name: <?= $ol['name']; ?></b><br/><b>Date of birth: </b><?= ($ol['birth_date'] != '' && $ol['birth_date'] != '0000-00-00') ? date('m/d/Y', strtotime($ol['birth_date'])) : 'N/A'; ?><br/><b>Percentage: </b> <?= $ol['percentage'] . '%'; ?><br/><b>Language: </b> <?= $ol['language']; ?><br/><b>Country of Residence: </b> <?= $ol['country_residence_name']; ?><br/><b>Country of Citizenship: </b> <?= $ol['country_citizenship_name']; ?><br/><b>SSN_ITIN: </b><?= ($ol['ssn_itin'] != '') ? $ol['ssn_itin'] : 'N/A'; ?>
                    </td></tr></table><table width="100%" border="0" style="line-height: 5px;"><tr><td style="font-size: 30px;"><?php $owner_contact_list = get_contact_list($ol['individual_id'], 'individual'); ?>&nbsp;<b style="color: #1ab394; font-size:34px;">Owner Contact Info: </b><br/>
                        <?php if (!empty($owner_contact_list)): ?>
                            <?php foreach ($owner_contact_list as $ocl): ?>
                               &nbsp;<span style="background-color: #1ab394; display: inline-block; color: #fff; font-size: 24px;"><?= $ocl['type']; ?></span><br/>
                                &nbsp;<b>Contact Name : <?= $ocl['last_name'] . ', ' . $ocl['first_name'] . ' ' . $ocl['middle_name']; ?></b><br/>&nbsp;<b>Phones: </b><?= $ocl['phone1'] . '(' . $ocl['phone1_country_name'] . ')'; ?><br/>&nbsp;<b>Email: </b><?= $ocl['email1']; ?><br/>&nbsp;<b>Address: </b><?= $ocl['address1'] . ', ' . $ocl['city'] . ', ' . $ocl['state'] . ','. $ocl['country_name'].'<br/>&nbsp;<b>ZIP: </b>' . $ocl['zip']  ; ?><br/>
                            <?php endforeach; ?>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td></tr></table>
                    <br/>              
            </td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <tr><td style="<?= $td_style; ?>">&nbsp;</td>
            <td style="<?= $td_style; ?> font-size: 30px;">
                N/A
            </td>            
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data[0]['bank_name']) && $order_extra_data[0]['bank_name'] != ''): ?>
    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px"><h3>&nbsp;Sales Tax Details: </h3></td>
    </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data[0]['bank_name']) && $order_extra_data[0]['bank_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Bank Name: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data[0]['bank_name']; ?></td>
        </tr>
    <?php endif; ?>
        
    <?php if (isset($order_extra_data[0]['bank_account_number']) && $order_extra_data[0]['bank_account_number'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Bank Account: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data[0]['bank_account_number']; ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($order_extra_data[0]['bank_routing_number']) && $order_extra_data[0]['bank_routing_number'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Bank Routing: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data[0]['bank_routing_number']; ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($order_extra_data[0]['acc_type1']) && $order_extra_data[0]['acc_type1']!=''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Personal or Business Account: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= ($order_extra_data[0]['acc_type1']==0)?'Personal':'Business'; ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($order_extra_data[0]['acc_type2']) && $order_extra_data[0]['acc_type2'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Checking or Savings Account: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= ($order_extra_data[0]['acc_type2']==0)?'Checking':'Savings'; ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($order_extra_data[0]['rt6_availability']) && $order_extra_data[0]['rt6_availability'] != ''): ?>
    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px"><h3>&nbsp;Sales Tax RT6: </h3></td>
    </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data[0]['rt6_availability']) && $order_extra_data[0]['rt6_availability'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>RT6 Availability: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data[0]['rt6_availability'] ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($order_extra_data[0]['void_cheque']) && $order_extra_data[0]['void_cheque'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Upload Void Cheque: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<a href="<?= base_url().'uploads/'.$order_extra_data[0]['void_cheque']; ?>" target="_blank"><?= $order_extra_data[0]['void_cheque']; ?></a></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($order_extra_data[0]['rt6_number']) && $order_extra_data[0]['rt6_number'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>RT6 Number: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data[0]['rt6_number']; ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($order_extra_data[0]['state']) && $order_extra_data[0]['state'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>State: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data[0]['state'] ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($order_extra_data[0]['need_rt6']) &&$order_extra_data[0]['need_rt6'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Need RT6: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data[0]['need_rt6'] ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($order_extra_data[0]['resident_type']) && $order_extra_data[0]['resident_type'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Recident Type: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data[0]['resident_type'] ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data[0]['passport']) && $order_extra_data[0]['passport'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Passport: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<a href="<?= base_url().'uploads/'.$order_extra_data[0]['passport']; ?>" target="_blank"><?= $order_extra_data[0]['passport']; ?></a></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data[0]['lease']) && $order_extra_data[0]['lease'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Lease: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<a href="<?= base_url().'uploads/'.$order_extra_data[0]['lease']; ?>" target="_blank"><?= $order_extra_data[0]['lease']; ?></a></td>
        </tr>
    <?php endif; ?>
        
        <!--sales tax data-->
    <?php if (isset($sales_tax_data['bank_name']) && $sales_tax_data['bank_name'] != ''): ?>
    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px"><h3>&nbsp;Sales Tax Account: </h3></td>
    </tr>
    
    <?php if (isset($sales_tax_data['bank_name']) && $sales_tax_data['bank_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Bank Name: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $sales_tax_data['bank_name']; ?></td>
        </tr>
    <?php endif; ?>
        
    <?php if (isset($sales_tax_data['bank_account_number']) && $sales_tax_data['bank_account_number'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Bank Account: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $sales_tax_data['bank_account_number']; ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($sales_tax_data['bank_routing_number']) && $sales_tax_data['bank_routing_number'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Bank Routing: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $sales_tax_data['bank_routing_number']; ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($sales_tax_data['acc_type1']) && $sales_tax_data['acc_type1']!=''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Personal or Business Account: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= ($sales_tax_data['acc_type1']==0)?'Personal':'Business'; ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($sales_tax_data['acc_type2']) && $sales_tax_data['acc_type2'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Checking or Savings Account: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= ($sales_tax_data['acc_type2']==0)?'Checking':'Savings'; ?></td>
        </tr>
    <?php endif; ?>
        <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px"><h3>&nbsp;Sales Tax Application: </h3></td>
    </tr>
    <?php if (isset($sales_tax_data['rt6_availability']) && $sales_tax_data['rt6_availability'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>RT6 Availability: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $sales_tax_data['rt6_availability'] ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($sales_tax_data['void_cheque']) && $sales_tax_data['void_cheque'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Upload Void Cheque: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<a href="<?= base_url().'uploads/'.$sales_tax_data['void_cheque']; ?>" target="_blank"><?= $sales_tax_data['void_cheque']; ?></a></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($sales_tax_data['rt6_number']) && $sales_tax_data['rt6_number'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>RT6 Number: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $sales_tax_data['rt6_number']; ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($sales_tax_data['state']) && $sales_tax_data['state'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>State: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $sales_tax_data['state'] ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($sales_tax_data['need_rt6']) &&$sales_tax_data['need_rt6'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Need RT6: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $sales_tax_data['need_rt6'] ?></td>
        </tr>
    <?php endif; ?>
        <?php if (isset($sales_tax_data['resident_type']) && $sales_tax_data['resident_type'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Recident Type: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $sales_tax_data['resident_type'] ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($sales_tax_data['passport']) && $sales_tax_data['passport'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Passport: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<a href="<?= base_url().'uploads/'.$sales_tax_data['passport']; ?>" target="_blank"><?= $sales_tax_data['passport']; ?></a></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($sales_tax_data['lease']) && $sales_tax_data['lease'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Lease: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<a href="<?= base_url().'uploads/'.$sales_tax_data['lease']; ?>" target="_blank"><?= $sales_tax_data['lease']; ?></a></td>
        </tr>
    <?php endif; ?>
        <?php endif; ?>
    <!--end sales tax data-->
    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px"><h3>&nbsp;Internal Data: </h3></td>
    </tr>
    
    <?php if (isset($internal_data['office_name']) && $internal_data['office_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Office: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $internal_data['office_name']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($internal_data['partner_name']) && $internal_data['partner_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Partner: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $internal_data['partner_name']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($internal_data['manager_name']) && $internal_data['manager_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Manager: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $internal_data['manager_name']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($internal_data['client_association']) && $internal_data['client_association'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Client Association: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $internal_data['client_association']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($internal_data['source_name']) && $internal_data['source_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Referred By Source: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $internal_data['source_name']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($internal_data['referred_by_name']) && $internal_data['referred_by_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Referred By Name: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $internal_data['referred_by_name']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($internal_data['language_name']) && $internal_data['language_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Language: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $internal_data['language_name']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($internal_data['existing_practice_id']) && $internal_data['existing_practice_id'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Existing Practice ID: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $internal_data['existing_practice_id']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (!empty($account_list)): ?>
        <tr>
            <td colspan="2"><table width="100%" style="line-height: 6px;" cellpadding="5" boder="0" cellspacing="0"><tr>
            <td style="<?= $td_style; ?> font-size:30px; width:40%"><b>Financial Accounts: </b></td>
            <td style="<?= $td_style; ?> font-size:30px ; width:60%"><?php
                // print_r($account_list);
                foreach ($account_list as $al) :
                    // if (strpos($al['type_of_account'], 'Account') !== false):
                    //     $al['type_of_account'] = str_replace('Account', '', $al['type_of_account']);
                    // endif;
                    ?><table width="100%" style="line-height: 5px;" cellpadding="5" boder="0" cellspacing="0"><tr><td colspan="2"><span style="background-color: #eda63f ;display: inline-block; width: 100px; color:#fff; font-size: 24px;"><?= $al['type_of_account']; ?></span><br/><b style="">Bank Name: </b> <?= $al['bank_name']; ?><br/>
                        <b style="">Routing Number: </b><?= $al['routing_number']; ?><br/>
                        <b style="">Website URL: </b><?= $al['bank_website']; ?><br/>
                        <?php if(isset($al['password'])&& $al['password']!=''){ ?>
                        <b>Password: </b><?= $al['password']; ?><br/>
                        <?php } if(isset($al['acc_doc'])&& $al['acc_doc']!='') {?>
                        <b>File: </b><?= $al['acc_doc']; ?><br/>
                        <?php
                        }
                            $security_details = get_secuirity_details($al['id']);
                                foreach ($security_details as $sd) {
                        ?>
                        <b>Security Questions: </b><?= $sd['security_question']; ?><br/>    
                        <b>Secuirity Answer: </b><?= $sd['security_answer']; ?><br/>    
                        <?php
                            }            
                        ?>
                        <b><?= ($order_info['service_shortname'] == 'acc_b_b_d') ? 'Grand ' : ''; ?>Total Amount: </b><?= '$' . number_format((float) ($order_info['service_shortname'] == 'acc_b_b_d') ? $al['grand_total'] : $al['total_amount'], 2, '.', ''); ?><br/>
                            <b>#Of Transactions: </b><?= $al['number_of_transactions']; ?>
                <?php endforeach; ?></td></tr></table>
            </td></tr></table></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data['frequency']) && $order_extra_data['frequency'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Frequency: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $frequency_array[$order_extra_data['frequency']]; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data['sales_tax_id']) && $order_extra_data['sales_tax_id'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Sales Tax ID: </b></td>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data['sales_tax_id']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data['website']) && $order_extra_data['website'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Web site: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data['website']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data['activity']) && $order_extra_data['activity'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Activity: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data['activity']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data['social_activity']) && $order_extra_data['social_activity'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>Social Activity: </b>
            </td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data['social_activity']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data['professional_license_number']) && $order_extra_data['professional_license_number'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?>">&nbsp;<b>Professional License Number: </b></td><td style="<?= $td_style; ?>">&nbsp;<?= $order_extra_data['professional_license_number']; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (!empty($note_list)): ?>
        <tr>
            <td style="<?= $td_style; ?>">&nbsp;<b>Order Notes: </b></td>
            <td style="<?= $td_style; ?>">&nbsp;<?php foreach ($note_list as $nl): ?><p><?= $nl['note']; ?></p><?php endforeach; ?></td>
        </tr>
    <?php endif; ?>
    <?php if (!empty($employee_list)): ?>
        <tr>            
            <td colspan="2" style="border-top: 2px solid #ddd;border-bottom: 2px solid #ddd; vertical-align: top; line-height: 6px"><h3>&nbsp;Employee Data: </h3></td>
        </tr>
        <tr>
            <td style="padding: 12px; vertical-align: top; "></td><td>
                <?php foreach ($employee_list as $el): ?><table cellpadding="0" cellspacing="0" border="0" style="line-height: 5px;"><tr>
                        <td><br/><span style="background-color: #1ab394; display: inline-block; color: #fff; font-size: 24px;">&nbsp; <?= $el['employee_type']; ?> &nbsp;</span><br/>
                        <b>Employee Name: </b><?= $el['last_name'] . ', ' . $el['first_name']; ?><br><b>Phones: </b><?= $el['phone_number']; ?><br><b>Email: </b><?= $el['email']; ?><br><b>Address: </b><?= $el['address']; ?><br><b>City: </b><?= $el['city']; ?><br>State: <?= $el['state']; ?><br><b>Zip: </b><?= $el['zip']; ?><br><b>Home Phone: </b><?= $el['phone_number']; ?><br><b>SS #: </b><?= $el['ss']; ?><br><b>Gender: </b><?= $el['gender']; ?><br><b>Email: </b><?= $el['email']; ?><br><b>Pay Type: </b> <?= $el['is_paid']; ?><br><b>Date Of Birth: </b><?= date('m/d/Y', strtotime($el['date_of_birth'])); ?><br><b>Date Of Hire: </b><?= date('m/d/Y', strtotime($el['date_of_hire'])); ?><br><b>Payroll Check Receive Type: </b><?= $el['payroll_check']; ?><br><?php if ($el['payroll_check'] == 'Direct Deposit'): ?><b>Bank Account Type: </b><?= $el['bank_account_type']; ?><br><b>Bank Account#: </b><?= $el['bank_account']; ?><br><b>Bank Routing#: </b><?= $el['bank_routing']; ?><br><?php endif; ?><b>Hourly Rate or Salary Per Pay Period: </b><?= $el['hourly_rate']; ?><br><b>Filing Status: </b><?= $el['filing_status']; ?><br><b>#Of Allowances from IRS Form W-4: </b><?= $el['irs_form']; ?>
                        <br/></td></tr>
                    </table>
                <?php endforeach; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if (isset($order_extra_data['state_name']) && $order_extra_data['state_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>State: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data['state_name']; ?></td>
        </tr>
    <?php endif; ?> 
    <?php if (isset($order_extra_data['county_name']) && $order_extra_data['county_name'] != ''): ?>
        <tr>
            <td style="<?= $td_style; ?> font-size:30px">&nbsp;<b>County: </b></td><td style="<?= $td_style; ?> font-size:30px">&nbsp;<?= $order_extra_data['county_name']; ?></td>
        </tr>
    <?php endif; ?>    
    <tr>
        <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px"><h3>&nbsp;Services: </h3></td>
    </tr>
    <?php if (!empty($related_service_list)): ?>
        <?php foreach ($related_service_list as $rsl): ?>
            <tr>
                <td style="<?= $td_style; ?>"></td>                
                <td style="<?= $td_style; ?> line-height: normal"><table cellpadding="5" cellspacing="0" style="line-height: 5px;"><tr><td><span style="background-color: #1ab394; display: inline-block; color: #fff; font-size: 24px;">&nbsp; <?= $rsl['service_name']; ?> &nbsp;</span><br/><b>Service Category: </b> <?= $rsl['service_category']; ?><br/><b>Responsible Department: </b> <?= $rsl['responsible_department']; ?><br/><b>Tracking Description: </b> <?= $order_status_array[$rsl['service_request_status']]; ?><br/><b>Target Start: </b><?= ($rsl['start_date'] != '' && $rsl['start_date'] != '0000-00-00') ? date('m/d/Y', strtotime($rsl['start_date'])) : 'N/A'; ?><br/><b>Target Complete: </b><?= ($rsl['complete_date'] != '' && $rsl['complete_date'] != '0000-00-00') ? date('m/d/Y', strtotime($rsl['complete_date'])) : 'N/A'; ?><br/><b>Actual Complete: </b><?= ($rsl['service_request_status'] != '0' && $rsl['complete_date'] != '' && $rsl['complete_date'] != '0000-00-00') ? date('m/d/Y', strtotime($rsl['complete_date'])) : 'N/A'; ?><br><b>Retail Price: </b> <?= $rsl['retail_price']; ?>,<br><b>Override Price: </b><?= ($rsl['price_charged'] != '') ? $rsl['price_charged'] : 'N/A'; ?></td></tr></table><br/><table cellpadding="0" cellspacing="0">
                    <tr>
                    <td><?php $service_note_list = related_service_note_list($order_info['id'], $rsl['service_id']); ?><?php if (!empty($service_note_list)): ?><b>Service Notes: </b><br/>
                            <?php foreach ($service_note_list as $snl): ?>
                                <?= $snl['note']; ?><br/>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td></tr></table>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
        <td colspan="2" style="<?= $td_style; ?>">
            N/A
        </td>
        </tr>

    <?php endif; ?>
    
    <?php if (!empty($document_list)): ?>
        <tr>
            <td colspan="2" style="<?= $td_style; ?>border-top-width:2px; border-bottom-width:2px"><h3>&nbsp;Documents: </h3></td>
        </tr>
        <?php foreach ($document_list as $dl): 
            $all_document[] = $dl['document'];

        ?>
        <tr>
            <td style="<?= $td_style; ?>"></td>
            <td style="padding: 12px; vertical-align: top; border-top: 1px solid #ddd;"><table cellpadding="5" cellspacing="0" border="0"><tr><td style="line-height: 2px;"><b>(<?= $dl['doc_type']; ?>)</b><br/><a href='<?php echo base_url().'uploads/'.trim($dl["document"]); ?>' style="text-decoration:none"><?php echo trim($dl["document"]); ?></a><br/><b>Upload Date: </b> <?= $dl['upload_date']; ?><br/></td></tr></table></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
        <td colspan="2" style="<?= $td_style; ?>">
            N/A
        </td>
        </tr>    
    <?php endif; ?>
    
    <?php foreach ($owner_list as $ol): ?>
        <?php $owner_document_list = get_document_list($ol['individual_id'], 'individual'); ?>
    <?php endforeach; ?>
    <?php if (!empty($owner_list) && !empty($owner_document_list)): ?>
        <tr>
            <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px"><h3>&nbsp;Owner Documents: </h3></td>
        </tr>
        <?php foreach ($owner_list as $ol): ?>
            <tr>
                <td style="<?= $td_style; ?>">&nbsp;</td>
                <td style="vertical-align: top; border-top: 1px solid #ddd;">
                    <table cellspacing="0" cellpadding="5" border="0"><tr><td><?php foreach ($owner_document_list as $odl): ?>
                            <?php $all_document[] = $odl['document']; ?>
                            <b>(<?= $odl['doc_type']; ?>)</b><br/>
                            <a style="text-decoration:none"><?= $odl['document']; ?></a><br/><b>Upload Date: </b> <?= $odl['upload_date']; ?>
                        <?php endforeach; ?></td></tr></table></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
        <td colspan="2" style="<?= $td_style; ?>">
            N/A
        </td>
        </tr>
    <?php endif; ?>


        <?php if (isset($all_driver_license) && !empty($all_driver_license)): ?>
            <tr>   
                <td colspan="2" style="<?= $td_style; ?>"><h3>&nbsp;Driver License: </h3></td>
            </tr>
            <?php foreach ($all_driver_license as $license_data): ?>
                <?php $all_document[] = $license_data['file_name']; ?>
            <tr>
                <td><?= $license_data['upload_date']; ?></td>
                <td style="padding: 12px; vertical-align: top; border-top: 1px solid #ddd;">
                    <a href="<?= base_url('/uploads/') . $license_data['file_name']; ?>"><?= $license_data['file_name']; ?></a><br>
                </td>    
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
        <tr>
        <td colspan="2" style="<?= $td_style; ?>">
            N/A
        </td>
        </tr>
        <?php endif; ?>
        

        <?php if (isset($payroll_wage_files) && !empty($payroll_wage_files)): ?>
            <tr>   
                <td colspan="2"  style="padding: 12px; vertical-align: top; border-top: 2px solid #ddd;border-bottom: 2px solid #ddd; line-height: 6px;"><h3> &nbsp;Wage Files: </h3>
                </td>
            </tr>
            <?php foreach ($payroll_wage_files as $wage_files): ?>
                <?php $all_document[] = $wage_files['file_name']; ?>
                <tr>                    
                    <td></td>
                    <td>
                        <table cellpadding="5">
                            <tr>
                               <td><a style="text-decoration:none;"><?= $wage_files['file_name']; ?></a><br><span style="font-size:28px;"><b>Upload Date: </b><?= $wage_files['upload_date']; ?></span></td> 
                            </tr>
                        </table>
                        
                    </td>                    
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="2" style="<?= $td_style; ?>">
                    N/A
                </td>
            </tr>
            <?php endif; ?>
        
            <tr><td colspan="2" style="border-bottom: 1px solid #ddd"></td></tr>

        
        <?php if (isset($company_extra_data['fein_filename']) && $company_extra_data['fein_filename'] != "" && file_exists($company_extra_data['fein_filename'])): ?>
            
            <tr>   
                <td colspan="2" style="<?= $td_style; ?> border-top-width:2px; border-bottom-width:2px"><h3> &nbsp;FIEN File: </h3></td>
            </tr>

            <?php $all_document[] = $company_extra_data['fein_filename']; ?>
            <tr>
                <td><?= $company_extra_data['upload_date']; ?></td>
                <td style="padding: 12px; vertical-align: top; border-top: 1px solid #ddd;">
                <a href="<?= base_url('/uploads/') . $company_extra_data['fein_filename']; ?>"><?= $company_extra_data['fein_filename']; ?></a><br>
                </td>
            </tr>
        <?php endif; ?>

    </tbody>
</table>












