<?php
$user_info = staff_info();
$usertype = $user_info['type'];
$td_style = "padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;";
$all_document = [];
// echo "<pre>";
// print_r($order_info);exit;
//for edit
$invoice_info = invoice_info_by_order_id($order_info['id']);
$services_list = service_list_by_order_id($order_info['id']);

$status = $order_info['status'];
if ($status == 0) {
    $tracking = 'Completed';
    $trk_class = 'label-primary';
} elseif ($status == 1) {
    $tracking = 'Started';
    $trk_class = 'label-yellow';
} elseif ($status == 2) {
    $tracking = 'Not Started';
    $trk_class = 'label-success';
} elseif ($status == 7) {
    $tracking = 'Canceled';
    $trk_class = 'label-danger';
}
$url = '';
if ($usertype != '3') {
    if ($order_info['category_id'] == 1) {
        if ($order_info['service_id'] == '3' || $order_info['service_id'] == '39' || $order_info['service_id'] == '48') {
            $url = 'services/accounting_services/edit_annual_report/' . $order_info['id'];
        } elseif ($order_info['service_id'] == '2' || $order_info['service_id'] == '4' || $order_info['service_id'] == '6' || $order_info['service_id'] == '53') {
            $url = 'services/home/edit/' . $order_info['id'];
        } elseif ($order_info['service_id'] == '5' || $order_info['service_id'] == '54' || $order_info['service_id'] == '55') {
            $url = 'services/home/edit/' . $order_info['id'];
        } elseif ($order_info['service_id'] == '7') {
            $url = 'services/home/edit/' . $order_info['id'];
        } else {
            if ($order_info['service_shortname'] == 'inc_n_c_d' || $order_info['service_shortname'] == 'inc_n_c_f') {
                $url = 'services/incorporation/edit_company/' . $order_info['id'];
            } else {
                $url = 'services/home/edit/' . $order_info['id'];
            }
        }
    } else {
        if ($order_info['service_id'] == 10 || $order_info['service_id'] == '41') {
            $res = get_bookkeeping_by_order_id($order_info['id']);
            if (!empty($res)) {
                if ($res['sub_category'] == 2) {
                    $url = 'services/accounting_services/edit_bookkeeping_by_date/' . $order_info['id'];
                } else {
                    $url = 'services/accounting_services/edit_bookkeeping/' . $order_info['id'];
                }
            } else {
                $url = 'services/accounting_services/edit_bookkeeping/' . $order_info['id'];
            }
        } elseif ($order_info['service_id'] == '11') {
            $url = 'services/accounting_services/edit_payroll/' . $order_info['id'];
        } elseif ($order_info['service_id'] == '12') {
            $url = 'services/accounting_services/edit_sales_tax_application/' . $order_info['id'];
        } elseif ($order_info['service_id'] == '14') {
            $url = 'services/accounting_services/edit_rt6_unemployment_app/' . $order_info['id'];
        } elseif ($order_info['service_id'] == $service_id) {
            $url = 'services/accounting_services/edit_sales_tax_recurring/' . $order_info['id'];
        } elseif ($order_info['service_id'] == '13') { //change in live
            $url = 'services/accounting_services/edit_sales_tax_processing/' . $order_info['id'];
        } elseif ($order_info['service_id'] == '3' || $order_info['service_id'] == '48') {
            $url = 'services/accounting_services/edit_annual_report/' . $order_info['id'];
        } elseif ($order_info['service_id'] == '48' || $order_info['service_id'] == '39') {
            $url = 'services/accounting_services/edit_annual_report/' . $order_info['id'];
        } else {
            $url = 'services/home/edit/' . $order_info['id'];
        }
    }
    if (in_array($order_info['service_shortname'], edit_by_shortname_array())) {
        $url = 'services/home/edit/' . $order_info['id'];
    }
} else {
    if ($usertype == '3' && $status == 2) {
        if ($order_info['category_id'] == 1) {
            if ($order_info['service_id'] == '3' || $order_info['service_id'] == '39' || $order_info['service_id'] == '48') {
                $url = 'services/accounting_services/edit_annual_report/' . $order_info['id'];
            } else {
                if ($order_info['service_shortname'] == 'inc_n_c_d' || $order_info['service_shortname'] == 'inc_n_c_f') {
                    $url = 'services/incorporation/edit_company/' . $order_info['id'];
                } else {
                    $url = 'services/home/edit/' . $order_info['id'];
                }
            }
        } else {
            if ($order_info['service_id'] == 10 || $order_info['service_id'] == '41') {
                $res = get_bookkeeping_by_order_id($order_info['id']);
                if (!empty($res)) {
                    if ($res['sub_category'] == 2) {
                        $url = 'services/accounting_services/edit_bookkeeping_by_date/' . $order_info['id'];
                    } else {
                        $url = 'services/accounting_services/edit_bookkeeping/' . $order_info['id'];
                    }
                } else {
                    $url = 'services/accounting_services/edit_bookkeeping/' . $order_info['id'];
                }
            } elseif ($order_info['service_id'] == '11') {
                $url = 'services/accounting_services/edit_payroll/' . $order_info['id'];
            } elseif ($order_info['service_id'] == '12') {
                $url = 'services/accounting_services/edit_sales_tax_application/' . $order_info['id'];
            } elseif ($order_info['service_id'] == '14') {
                $url = 'services/accounting_services/edit_rt6_unemployment_app/' . $order_info['id'];
            } elseif ($order_info['service_id'] == $serviceid) {
                $url = 'services/accounting_services/edit_sales_tax_recurring/' . $order_info['id'];
            } elseif ($order_info['service_id'] == '13') { //change in live
                $url = 'services/accounting_services/edit_sales_tax_processing/' . $order_info['id'];
            } else {
                $url = 'services/home/edit/' . $order_info['id'];
            }
        }
        if (in_array($order_info['service_shortname'], edit_by_shortname_array())) {
            $url = 'services/home/edit/' . $order_info['id'];
        }
    }
}
?>
<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md"> 
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%;">

                  <?php if(isset($order_info['invoiced_id']) && $order_info['invoiced_id']!=''): ?>
                <tr>
                    <td style="<?= $td_style; ?>">
                        Order Id:
                    </td>
                    <td style="<?= $td_style; ?>">
                        <a href="<?= base_url("billing/invoice/place/" . base64_encode($order_info['invoiced_id']) . "/" . base64_encode('view')); ?>" target="_blank" >#<?= $order_info['invoiced_id']; ?></a>
                    </td>
                </tr>
                <?php endif ?>

                <tr>
                    <td colspan="2" style="<?= $td_style; ?>">
                        <h3><?= $order_info['service_name']; ?></h3>
                    </td>
                <div class="text-right m-b-20">
                    <?php
                    if ($url != ''):
                        if ($tracking == 'Started') {
                            ?>
                            <a href="<?= base_url($url) ?>" class="btn btn-primary  btn-service-edit m-r-10" style="display: none; width: 150px">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                            </a>
                            <?php
                        } else {
                            if (!empty($invoice_info) && $invoice_info['is_order'] == 'y') {
                                $url = 'billing/invoice/edit/' . base64_encode($invoice_info['id']);
                            }
                            ?>
                            <a href="<?= base_url($url) ?>" class="btn btn-primary btn-service-edit m-r-10" style="width: 150px">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                            </a>
                            <?php
                        }
                    endif;
                    ?>
                    <a href="<?= base_url("billing/invoice/place/" . base64_encode($order_info['invoiced_id']) . "/" . base64_encode('view')); ?>" target="_blank" class="btn btn-success btn-service-view m-r-10" style="width: 150px"><i class="fa fa-eye" aria-hidden="true"></i> View Invoice</a>
                    <button class="btn btn-danger" type="button" onclick="go('services/home');">Back to dashboard</button>

                </div>
                </tr>

                <?php if (isset($order_info['requested_staff_name']) && $order_info['requested_staff_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Requested By:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_info['requested_staff_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($order_info['create_date']) && $order_info['create_date'] != '' && $order_info['create_date'] != '0000-00-00'): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Date Requested:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= date('m/d/Y h:i:s', strtotime($order_info['create_date'])); ?>
                        </td>
                    </tr>
                <?php endif; ?>
                
                <?php
                if (isset($order_info['main_order_status']) && $order_info['main_order_status'] != ''):

                    if ($order_status_array[$order_info['main_order_status']] == 'Completed') {
                        $trk_class = 'label-primary';
                    } elseif ($order_status_array[$order_info['main_order_status']] == 'Started') {
                        $trk_class = 'label-yellow';
                    } elseif ($order_status_array[$order_info['main_order_status']] == 'Not Started') {
                        $trk_class = 'label-success';
                    } elseif ($order_status_array[$order_info['main_order_status']] == 'Canceled') {
                        $trk_class = 'label-danger';
                    }
                    ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Tracking:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <span class="label <?php echo $trk_class; ?> label-block" style="width: 80px; display: inline-block; text-align: center;">
                                <?= $order_status_array[$order_info['main_order_status']]; ?></span>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if(isset($order_info['service_id']) && $order_info['service_id']!=''): ?>

                
                <tr>
                    <td style="<?= $td_style; ?>">
                        Service Id:
                    </td>
                    <?php    if (!empty($services_list)) {
                                $keysval = 1;
                                foreach ($services_list as $keys => $row_inner) {
                                    $keysval = $keysval + $keys;
                ?>
                    <td style="<?= $td_style; ?>">
                        <!-- <?//= $order_info['service_id']; ?> -->
                        <?= $invoice_info['id']; ?>-<?= $keysval ?>
                    </td>
                     <?php }}  ?>
                </tr>

           
                <?php endif ?>

                <?php if(isset($order_info['service_name']) && $order_info['service_name']!=''): ?>
                <tr>
                    <td style="<?= $td_style; ?>">
                        Service Name:
                    </td>
                    <td style="<?= $td_style; ?>">
                        <?= $order_info['service_name']; ?>
                    </td>
                </tr>
                <?php endif ?>

                <?php if (isset($company_info["state_name"]) && $company_info["state_name"] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>width:180px;">
                            State of Incorporation:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= ($company_info["state_name"] != 'Other') ? $company_info["state_name"] : $company_info["state_others"]; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($company_info['name']) && $company_info['name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Name Of Business:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_info['name']; ?>
                            <?php if (!empty($company_name_option)): ?>
                                <?= $company_name_option['name2'] != "" ? "<br>" . $company_name_option['name2'] : ""; ?>
                                <?= $company_name_option['name3'] != "" ? "<br>" . $company_name_option['name3'] : ""; ?>
                            <?php endif; ?>                        
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($company_info['business_description']) && $company_info['business_description'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Business Description:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <!-- <?//= $company_info['business_description']; ?> -->
                            <?= urldecode($company_info['business_description']); ?>                       
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($company_info['fein']) && $company_info['fein'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Federal Id:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_info['fein']; ?>                       
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($order_extra_data[0]['contact_phone_no']) && $order_extra_data[0]['contact_phone_no'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Contact Phone No:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data[0]['contact_phone_no']; ?>                       
                        </td>
                    </tr>
                <?php endif; ?>
                

                <?php if (isset($order_info['start_date']) && $order_info['start_date'] != '' && $order_info['start_date'] != '0000-00-00'): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Start Date:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= date('m/d/Y', strtotime($order_info['start_date'])); ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($order_info['complete_date']) && $order_info['complete_date'] != '' && $order_info['complete_date'] != '0000-00-00'): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Completed Date:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= date('m/d/Y', strtotime($order_info['complete_date'])); ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($order_info['total_of_order']) && $order_info['total_of_order'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Amount:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= "$" . number_format((float) $order_info['total_of_order'], 2, '.', ''); ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($company_info['company_type']) && $company_info['company_type'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Type of Company:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_info['company_type']; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($company_info['fye']) && $company_info['fye'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Fiscal Year End:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= date("F", strtotime("2000-" . $company_info['fye'] . "-01")); ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($company_info['dba']) && $company_info['dba'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            DBA:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_info['dba']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <!--                 <?php //if (isset($company_info['business_description']) && $company_info['business_description'] != ''):    ?>
                                    <tr>
                                        <td style="<?= $td_style; ?>">
                                            Business Description:
                                        </td>
                                        <td style="<?= $td_style; ?>">
                                            <?//= urldecode($company_info['business_description']); ?>
                                        </td>
                                    </tr>
                <?php //endif; ?> -->
                <?php if (isset($company_extra_data['phone_number']) && $company_extra_data['phone_number'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Phone Number:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_extra_data['phone_number']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($company_extra_data['company_started']) && $company_extra_data['company_started'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Company Started:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_extra_data['company_started']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($company_extra_data['state']) && $company_extra_data['state'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            State:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_extra_data['state']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($company_extra_data['zip']) && $company_extra_data['zip'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            ZIP:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_extra_data['zip']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($company_extra_data['city']) && $company_extra_data['city'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            City:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_extra_data['city']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($company_extra_data['company_address']) && $company_extra_data['company_address'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Company Address:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $company_extra_data['company_address']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($order_extra_data) && array_key_exists('closing_date', $order_extra_data)): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Closing Date:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data['closing_date']; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td style="<?= $td_style; ?>">
                        Order Notes:
                      
                        
                    </td>
                    <td style="<?= $td_style; ?>">
                        <span>
                            <?php
                            $note_count = getNoteCount('order', $order_info['id']);
                            $note_data = getReadStatus('order', $order_info['id']);
                            $data = array_column($note_data, 'read_status');

                            if ($note_count == 0) {
                                ?>
                                <a id="notecount-<?php echo $order_info['id']; ?>" count="<?= $note_count; ?>" class="label label-warning" href="javascript:void(0)" onclick="show_notes_outer('order', '<?= $order_info['id']; ?>');">
                                    <b><?= $note_count; ?></b>
                                </a>
                                <?php
                            } else {
                                if (in_array(1, $data)) {
                                    ?>
                                    <a id="notecount-<?php echo $order_info['id']; ?>" count="<?= $note_count; ?>" class="label label-success" href="javascript:void(0)" onclick="show_notes_outer('order', '<?= $order_info['id']; ?>');">
                                        <b><?= $note_count; ?></b>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a id="notecount-<?php echo $order_info['id']; ?>" count="<?= $note_count; ?>" class="label label-danger" href="javascript:void(0)" onclick="show_notes_outer('order', '<?= $order_info['id']; ?>');">
                                        <b><?= $note_count; ?></b>
                                    </a>
                                    <?php
                                }
                            }
                            ?>  
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="<?= $td_style; ?>">
                        Service SOS
                    </td>
                    <td style="<?= $td_style; ?>">
                        <span>
                            <a id="soscount-<?= $order_info["id"]; ?>-<?php echo $order_info["service_id"]; ?>" class="d-inline p-t-5 p-b-5 p-r-8 p-l-8 label <?php echo (get_sos_count('order', '<?= $order_info["service_id"]; ?>', '<?= $order_info["id"]; ?>') == 0) ? 'label-primary' : 'label-danger'; ?>" title="SOS" href="javascript:void(0)" onclick="show_sos('order', '<?= $order_info["service_id"]; ?>', '', '<?= $order_info["id"]; ?>', '');"><?php echo (get_sos_count('order', '<?= $order_info["service_id"]; ?>', '<?= $order_info["id"]; ?>') == 0) ? '<i class="fa fa-plus"></i>' : '<i class="fa fa-bell"></i>'; ?></a>                                                   
                        </span> 
                    </td>
                </tr>

                <?php if (!empty($buyers_info)): ?>
                    <?php foreach ($buyers_info as $bi): ?>
                        <tr>
                            <td style="<?= $td_style; ?>">
                                <b>Buyer Information:</b>
                            </td>
                            <td style="<?= $td_style; ?>">
                                <div class='media-body'>
                                    <label class='label label-primary'></label>
                                    <h4 class='media-heading'></h4>
                                    <p>
                                        <b>ITIN Number : </b><?= $bi['itin_number']; ?><br>
                                        <b>Full Name : </b><?= $bi['fullname']; ?><br>
                                        <b>Contact Information : </b><?= $bi['contact_information']; ?><br>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>                
                <?php endif; ?>

                <?php if (!empty($sellers_info)): ?>
                    <?php foreach ($sellers_info as $si): ?>
                        <tr>
                            <td style="<?= $td_style; ?>">
                                <b>Seller Information :</b>
                            </td>
                            <td style="<?= $td_style; ?>">
                                <div class='media-body'>
                                    <label class='label label-primary'></label>
                                    <h4 class='media-heading'></h4>
                                    <p>
                                        <b>ITIN Number : </b><?= (!empty($si['itin_number'])) ? $si['itin_number'] : 'N/A'; ?><br>
                                        <b>Full Name : </b><?= $si['fullname']; ?><br>
                                        <b>Contact Information : </b><?= $si['contact_information']; ?><br>
                                        <b>Full Foreign Address : </b><?= (!empty($si['full_address']) ? $si['full_address'] : "N/A"); ?><br>
                                        <b>Passport : </b>
                                        <?php
                                        if (!empty($si['passport'])) {
                                            ?>
                                            <a href="<?= base_url() . 'uploads/' . $si['passport']; ?>"><?= $si['passport']; ?></a><br>
                                            <?php
                                        } else {
                                            echo "N/A<br>";
                                        }
                                        ?>                                            
                                        <b>Visa : </b>
                                        <?php
                                        if (!empty($si['passport'])) {
                                            ?>
                                            <a href="<?= base_url() . 'uploads/' . $si['visa']; ?>"><?= (!empty($si['visa']) ? $si['visa'] : "N/A"); ?></a><br>
                                            <?php
                                        } else {
                                            echo "N/A";
                                        }
                                        ?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>                
                <?php endif; ?>

                <tr <?= (!empty($order_extra_data) && array_key_exists('property_address', $order_extra_data)) ? '' : 'style="display:none"'; ?>>
                    <td style="<?= $td_style; ?>">
                        <b>Property Address:</b>
                    </td>
                    <td style="<?= $td_style; ?>">
                        <div class='media-body'>
                            <label class='label label-primary'></label>
                            <h4 class='media-heading'></h4>
                            <p>
                                <b>Address : </b><?= $order_extra_data['property_address']; ?><br>
                                <b>City : </b><?= $order_extra_data['property_city']; ?><br>
                                <b>State : </b><?= $order_extra_data['property_state']; ?><br>
                                <b>ZIP : </b><?= $order_extra_data['property_zip']; ?>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="<?= $td_style; ?>">
                        <b>Contact Info:</b>
                    </td>
                    <?php if (!empty($contact_list)): ?>
                        <td style="<?= $td_style; ?>">
                            <?php
                            foreach ($contact_list as $cl):
                                $state_name = state_info($cl['state'])['state_name'];
                                ?>
                                <div class='media-body'>
                                    <label class='label label-primary'><?= $cl['type']; ?></label>
                                    <h4 class='media-heading'>Contact Name: <?= $cl['last_name'] . ', ' . $cl['first_name'] . ' ' . $cl['middle_name']; ?></h4>
                                    <p>
                                        <b>Phones : </b><?= $cl['phone1'] . '(' . $cl['phone1_country_name'] . ')'; ?><br>
                                        <b>Email: </b><?= $cl['email1']; ?><br>
                                        <b>Address: </b><?= $cl['address1'] . ', ' . $cl['city'] . ', ' . $state_name . ', ZIP: ' . $cl['zip'] . ', ' . $cl['country_name']; ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    <?php else: ?>
                        <td style="<?= $td_style; ?>">
                            N/A
                        </td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <td style="<?= $td_style; ?>">
                        <b>Owners:</b>
                    </td>
                    <?php if (!empty($owner_list)): ?>
                        <td style="<?= $td_style; ?>">
                            <?php foreach ($owner_list as $ol): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class='media-body'><label class='label label-primary'><?= $ol['title']; ?></label>
                                            <h4 class='media-heading'>Name: <?= $ol['name']; ?></h4>
                                            <p>
                                                <b>Date of Birth: </b><?= ($ol['birth_date'] != '' && $ol['birth_date'] != '0000-00-00') ? date('m/d/Y', strtotime($ol['birth_date'])) : 'N/A'; ?><br>
                                                <b>Percentage: </b> <?= $ol['percentage'] . '%'; ?>, <b>Language: </b> <?= $ol['language']; ?><br>
                                                <b>Country of Residence: </b> <?= $ol['country_residence_name']; ?><br>
                                                <b>Country of Citizenship: </b> <?= $ol['country_citizenship_name']; ?><br>
                                                <b>SSN/ITIN: </b><?= ($ol['ssn_itin'] != '') ? $ol['ssn_itin'] : 'N/A'; ?><br>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <?php $owner_contact_list = get_contact_list($ol['individual_id'], 'individual'); ?>
                                        <b>Owner Contact Info:</b><br>
                                        <?php if (!empty($owner_contact_list)): ?>
                                            <?php foreach ($owner_contact_list as $ocl): ?>
                                                <div class='media-body'>
                                                    <label class='label label-primary'><?= $ocl['type']; ?></label>
                                                    <h4 class='media-heading'>Contact Name: <?= $ocl['last_name'] . ', ' . $ocl['first_name'] . ' ' . $ocl['middle_name']; ?></h4>
                                                    <p>
                                                        <b>Phones : </b><?= $ocl['phone1'] . '(' . $ocl['phone1_country_name'] . ')'; ?><br>
                                                        <b>Email: </b><?= $ocl['email1']; ?><br>
                                                        <b>Address: </b><?= $ocl['address1'] . ', ' . $ocl['city'] . ', ' . $ocl['state'] . ', ZIP: ' . $ocl['zip'] . ', ' . $ocl['country_name']; ?>
                                                    </p>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="hr-line-dashed m-t-5 m-b-5"></div>
                            <?php endforeach; ?>
                        </td>
                    <?php else: ?>
                        <td style="<?= $td_style; ?>">
                            N/A
                        </td>
                    <?php endif; ?>
                </tr>
                <?php if (isset($order_extra_data[0]['bank_name']) && $order_extra_data[0]['bank_name'] != ''): ?> 
                    <tr>
                        <td colspan="2" style="<?= $td_style; ?>">
                            <h4>Sales Tax Details</h4>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data[0]['bank_name']) && $order_extra_data[0]['bank_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Bank Name:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data[0]['bank_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data[0]['bank_account_number']) && $order_extra_data[0]['bank_account_number'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Bank Account:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data[0]['bank_account_number']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data[0]['bank_routing_number']) && $order_extra_data[0]['bank_routing_number'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Bank Routing:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data[0]['bank_routing_number']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data[0]['acc_type1']) && $order_extra_data[0]['acc_type1'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Personal or Business Account:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= ($order_extra_data[0]['acc_type1'] == 0) ? 'Personal' : 'Business'; ?>
                        </td>
                    </tr>
                <?php endif; ?> 
                <?php if (isset($order_extra_data[0]['acc_type2']) && $order_extra_data[0]['acc_type2'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Checking or Savings Account:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= ($order_extra_data[0]['acc_type2'] == 0) ? 'Checking' : 'Savings'; ?>
                        </td>
                    </tr>
                <?php endif; ?> 
                <?php if (isset($order_extra_data[0]['rt6_availability']) && $order_extra_data[0]['rt6_availability'] != ''): ?>
                    <tr>
                        <td colspan="2" style="<?= $td_style; ?>">
                            <h4>Sales Tax RT6 </h4>
                        </td>
                    </tr>
                <?php endif; ?> 
                <?php if (isset($order_extra_data[0]['rt6_availability']) && $order_extra_data[0]['rt6_availability'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            RT6 Availability:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data[0]['rt6_availability']; ?>
                        </td>
                    </tr>
                <?php endif; ?> 
                <?php if (isset($order_extra_data[0]['void_cheque']) && $order_extra_data[0]['void_cheque'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Upload Void Cheque:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <a href="<?= base_url() . 'uploads/' . $order_extra_data[0]['void_cheque']; ?>" target="_blank"><?= ltrim(stristr($order_extra_data[0]['void_cheque'], '_'), '_'); ?></a>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data[0]['rt6_number']) && $order_extra_data[0]['rt6_number'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            RT6 Number:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data[0]['rt6_number']; ?>
                        </td>
                    </tr>
                <?php endif; ?> 
                <?php if (isset($order_extra_data[0]['state']) && $order_extra_data[0]['state'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            State:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data[0]['state']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data[0]['need_rt6']) && $order_extra_data[0]['need_rt6'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Need RT6:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data[0]['need_rt6']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data[0]['resident_type']) && $order_extra_data[0]['resident_type'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Recident Type:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data[0]['resident_type']; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($order_extra_data[0]['passport']) && $order_extra_data[0]['passport'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Passport:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <a href="<?= base_url() . 'uploads/' . $order_extra_data[0]['passport']; ?>" target="_blank"><?= $order_extra_data[0]['passport']; ?></a>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data[0]['lease']) && $order_extra_data[0]['lease'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Lease:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <a href="<?= base_url() . 'uploads/' . $order_extra_data[0]['lease']; ?>" target="_blank"><?= $order_extra_data[0]['lease']; ?></a>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($sales_tax_data) && $sales_tax_data != ''): ?>
                    <tr>
                        <td colspan="2" style="<?= $td_style; ?>">
                            <h4>Sales Tax Account</h4>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($sales_tax_data['bank_name']) && $sales_tax_data['bank_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Bank name:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $sales_tax_data['bank_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($sales_tax_data['bank_account_number']) && $sales_tax_data['bank_account_number'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Bank Account:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $sales_tax_data['bank_account_number']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($sales_tax_data['bank_routing_number']) && $sales_tax_data['bank_routing_number'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Bank Routing:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $sales_tax_data['bank_routing_number']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($sales_tax_data['acc_type1']) && $sales_tax_data['acc_type1'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Personal or Business Account:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= ($sales_tax_data['acc_type1'] == 0) ? 'Personal' : 'Business'; ?>
                        </td>
                    </tr>
                <?php endif; ?> 
                <?php if (isset($sales_tax_data['acc_type2']) && $sales_tax_data['acc_type2'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Checking or Savings Account:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= ($sales_tax_data['acc_type2'] == 0) ? 'Checking' : 'Savings'; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2" style="<?= $td_style; ?>">
                        <!-- <h4>Sales Tax Application</h4> -->
                        <h4><?= $order_info['service_name']; ?></h4>
                    </td>
                </tr>
                <?php if (isset($sales_tax_data['rt6_availability']) && $sales_tax_data['rt6_availability'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            RT6 Availability:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $sales_tax_data['rt6_availability']; ?>
                        </td>
                    </tr>
                <?php endif; ?> 
                <?php if (isset($sales_tax_data['void_cheque']) && $sales_tax_data['void_cheque'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Upload Void Cheque:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <a href="<?= base_url() . 'uploads/' . $sales_tax_data['void_cheque']; ?>" target="_blank"><?= ltrim(stristr($sales_tax_data['void_cheque'], '_'), '_'); ?></a>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($sales_tax_data['rt6_number']) && $sales_tax_data['rt6_number'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            RT6 Number:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $sales_tax_data['rt6_number']; ?>
                        </td>
                    </tr>
                <?php endif; ?> 
                <?php if (isset($sales_tax_data['state']) && $sales_tax_data['state'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            State:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $sales_tax_data['state']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($sales_tax_data['need_rt6']) && $sales_tax_data['need_rt6'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Need RT6:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $sales_tax_data['need_rt6']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($sales_tax_data['resident_type']) && $sales_tax_data['resident_type'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Recident Type:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $sales_tax_data['resident_type']; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($sales_tax_data['passport']) && $sales_tax_data['passport'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Passport:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <a href="<?= base_url() . 'uploads/' . $sales_tax_data['passport']; ?>" target="_blank"><?= $sales_tax_data['passport']; ?></a>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($sales_tax_data['lease']) && $sales_tax_data['lease'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Lease:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <a href="<?= base_url() . 'uploads/' . $sales_tax_data['lease']; ?>" target="_blank"><?= $sales_tax_data['lease']; ?></a>
                        </td>
                    </tr>
                <?php endif; ?>   
                <tr>
                    <td colspan="2" style="<?= $td_style; ?>">
                        <h4>Internal Data</h4>
                    </td>
                </tr>
                <?php if (isset($internal_data['office_name']) && $internal_data['office_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Office:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $internal_data['office_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($internal_data['partner_name']) && $internal_data['partner_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Partner:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $internal_data['partner_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($internal_data['manager_name']) && $internal_data['manager_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Manager:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $internal_data['manager_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($internal_data['client_association']) && $internal_data['client_association'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Client Association:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $internal_data['client_association']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($internal_data['source_name']) && $internal_data['source_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Referred By Source:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $internal_data['source_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($internal_data['referred_by_name']) && $internal_data['referred_by_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Referred By Name:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $internal_data['referred_by_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($internal_data['language_name']) && $internal_data['language_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Language:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $internal_data['language_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($internal_data['existing_practice_id']) && $internal_data['existing_practice_id'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Existing Practice ID:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $internal_data['existing_practice_id']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($account_list)): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Financial Accounts:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?php
                            foreach ($account_list as $al) :
                                if (strpos($al['type_of_account'], 'Account') !== false):
                                    $al['type_of_account'] = str_replace('Account', '', $al['type_of_account']);
                                endif;
                                ?>
                                <div class='media-body'><label class='label label-primary'><?= $al['type_of_account']; ?></label>
                                    <h4 class='media-heading'><?= $al['bank_name']; ?></h4>
                                    <p><?= ($al['user'] == "") ? '' : "User Id : " . $al['user']; ?></p>
                                    <p><?= ($al['account_number'] == "") ? '' : "Account Number : " . $al['account_number']; ?></p>
                                    <p><?= ($al['routing_number'] == "") ? '' : "Routing Number: " . $al['routing_number']; ?></p>
                                    <p><?= ($al['password'] == "") ? '' : "Password : " . $al['password']; ?></p>
                                    <p><?= ($al['bank_website'] == "") ? '' : "Website URL : " . $al['bank_website']; ?></p>
                                    <p><?= ($al['acc_doc'] == "") ? '' : "File : " . $al['acc_doc']; ?></p>
                                    <?php
                                    $security_details = get_secuirity_details($al['id']);

                                    foreach ($security_details as $sd) {
                                        ?>
                                        <p><?= ($sd['security_question'] == "") ? '' : "Security Question : " . $sd['security_question']; ?></p>
                                        <p><?= ($sd['security_answer'] == "") ? '' : "Security Answer : " . $sd['security_answer']; ?></p>
                                        <p>                                    
                                            <?php
                                        }
                                        ?>
                                        <?php echo ($order_info['service_shortname'] == 'acc_b_b_d') ? 'Grand ' : ''; ?>Total Amount : <?= '$' . number_format((float) ($order_info['service_shortname'] == 'acc_b_b_d') ? $al['grand_total'] : $al['total_amount'], 2, '.', ''); ?><br>
                                        #Of Transactions : <?= $al['number_of_transactions']; ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data['frequency']) && $order_extra_data['frequency'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Frequency:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $frequency_array[$order_extra_data['frequency']]; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data['sales_tax_id']) && $order_extra_data['sales_tax_id'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Sales Tax ID:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data['sales_tax_id']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data['website']) && $order_extra_data['website'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Web site:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data['website']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data['activity']) && $order_extra_data['activity'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Activity:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data['activity']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data['social_activity']) && $order_extra_data['social_activity'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Social Activity:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data['social_activity']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data['professional_license_number']) && $order_extra_data['professional_license_number'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Professional License Number:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data['professional_license_number']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <!--                 <?php // if (!empty($note_list)):    ?>
                                    <tr>
                                        <td style="<?= $td_style; ?>">
                                            <b>Order Notes:</b>
                                        </td>
                                        <td style="<?= $td_style; ?>">
                <?php // foreach ($note_list as $nl):  ?>
                                                <div id="<?//= 'note-notification-' . $nl['note_id']; ?>">
                                                    <p class="notification-text-area"><?//= $nl['note']; ?></p>
                                                </div>
                <?php // endforeach;  ?>
                                        </td>
                                    </tr>
                <?php // endif;  ?> -->

                <?php
                if (!empty($payroll_data)) {
                    ?>
                    <tr>
                        <td style="<?= $td_style; ?>"><b>Payroll Data:</b></td>
                        <td style="<?= $td_style; ?>">
                            <b>Payroll Frequency :</b> <?= ($payroll_data['payroll_frequency'] != '') ? $payroll_data['payroll_frequency'] : 'N/A'; ?><br>
                            <b>Pay Day :</b> <?= ($payroll_data['payday'] != '') ? $payroll_data['payday'] : 'N/A'; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (!empty($payroll_approver)) {
                    ?>
                    <tr>
                        <td style="<?= $td_style; ?>"><b>Payroll Approver</b></td>
                        <td style="<?= $td_style; ?>">
                            <label class='label label-primary'><?= $payroll_approver['title']; ?></label><br>
                            <b>Name :</b> <?= ($payroll_approver['fname'] != '' && $payroll_approver['lname'] != '') ? $payroll_approver['fname'] . " " . $payroll_approver['lname'] : 'N/A'; ?><br>
                            <b>SSN :</b> <?= ($payroll_approver['social_security'] != '') ? $payroll_approver['social_security'] : 'N/A'; ?><br>
                            <b>Phone :</b> <?= ($payroll_approver['phone'] != '') ? $payroll_approver['phone'] : 'N/A'; ?><br>
                            <b>Email :</b> <?= ($payroll_approver['email'] != '') ? $payroll_approver['email'] : 'N/A'; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (!empty($company_principal)) {
                    ?>
                    <tr>
                        <td style="<?= $td_style; ?>"><b>Company Principal</b></td>
                        <td style="<?= $td_style; ?>">
                            <label class='label label-primary'><?= ($company_principal['title'] != '') ? $company_principal['title'] : 'N/A'; ?></label><br>
                            <b>Name :</b> <?= ($company_principal['fname'] != '' && $company_principal['lname'] != '') ? $company_principal['fname'] . " " . $company_principal['lname'] : 'N/A'; ?><br>
                            <b>SSN :</b> <?= ($company_principal['social_security'] != '') ? $company_principal['social_security'] : 'N/A'; ?><br>
                            <b>Phone :</b> <?= ($company_principal['phone'] != '') ? $company_principal['phone'] : 'N/A'; ?><br>
                            <b>Email :</b> <?= ($company_principal['email'] != '') ? $company_principal['email'] : 'N/A'; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (!empty($signer_data)) {
                    ?>
                    <tr>
                        <td style="<?= $td_style; ?>"><b>Signer Data</b></td>
                        <td style="<?= $td_style; ?>">
                            <b>Name :</b> <?= ($signer_data['fname'] != '' && $signer_data['lname'] != '') ? $signer_data['fname'] . " " . $signer_data['lname'] : 'N/A'; ?><br>
                            <b>SSN :</b> <?= ($signer_data['social_security'] != '') ? $signer_data['social_security'] : 'N/A'; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (!empty($payroll_account_numbers)) {
                    ?>
                    <tr>
                        <td style="<?= $td_style; ?>"><b>Account Number Where payroll will be debited</b></td>
                        <td style="<?= $td_style; ?>">
                            <b>Bank Name : </b><?= ($payroll_account_numbers['bank_name'] != '') ? $payroll_account_numbers['bank_name'] : 'N/A'; ?><br>
                            <b>Bank Account : </b><?= ($payroll_account_numbers['ban_account_number'] != '') ? $payroll_account_numbers['ban_account_number'] : 'N/A'; ?><br>
                            <b>Bank Routing : </b><?= ($payroll_account_numbers['bank_routing_number']) ? $payroll_account_numbers['bank_routing_number'] : 'N/A'; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (!empty($payroll_account_numbers)) {
                    ?>
                    <tr>
                        <td style="<?= $td_style; ?>"><b>RT-6 Unemployment App</b></td>
                        <td style="<?= $td_style; ?>">
                            <b>Do you have a RT-6 #? : </b><?= ($payroll_account_numbers['rt6_availability'] != '') ? $payroll_account_numbers['rt6_availability'] : 'N/A'; ?><br>
                            <b>Upload Void Cheque (pdf) : </b><a href="<?= base_url() . "uploads/" . $payroll_account_numbers['void_cheque']; ?>" target="_blank">Cheque Pdf</a><br>
                            <b>Select Resident or Non-resident : </b><?= ($payroll_account_numbers['resident_type'] != '') ? $payroll_account_numbers['resident_type'] : 'N/A'; ?><br>
                            <b>RT-6 Number : </b><?= ($payroll_account_numbers['rt6_number'] != '') ? $payroll_account_numbers['rt6_number'] : 'N/A'; ?><br>
                            <b>State : </b><?= ($payroll_account_numbers['state'] != '') ? $payroll_account_numbers['state'] : 'N/A'; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (!empty($employee_details)) {
                    ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            <b>Employee Data:</b>
                        </td>
                        <td style="<?= $td_style; ?>">
                            <b>How many people are on payroll : </b><?= ($employee_details['payroll_people_total'] != '') ? $employee_details['payroll_people_total'] : 'N/A'; ?><br>
                            <b>Retail Price ($ Per Month) : </b><?= ($employee_details['retail_price'] != '') ? $employee_details['retail_price'] : 'N/A'; ?><br>
                            <b>Override Price : </b><?= ($employee_details['override_price']) ? $employee_details['override_price'] : 'N/A'; ?>
                        </td>    
                    </tr>

                    <?php
                }
                ?>
                <?php if (!empty($employee_list)): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            <b>Employee Info:</b>
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?php foreach ($employee_list as $el): ?>                            
                                <div class='media-body'>
                                    <label class='label label-primary'><?= $el['employee_type']; ?></label>
                                    <h4 class='media-heading'>Employee Name: <?= $el['last_name'] . ', ' . $el['first_name']; ?></h4>
                                    <p>
                                        <b>Phones:</b> <?= $el['phone_number']; ?><br>
                                        <b>Email:</b> <?= $el['email']; ?><br>
                                        <b>Address:</b> <?= $el['address']; ?><br>
                                        <b>City:</b> <?= $el['city']; ?><br>
                                        <b>State:</b> <?= $el['state']; ?><br>
                                        <b>Zip:</b> <?= $el['zip']; ?><br>
                                        <b>Home Phone:</b> <?= $el['phone_number']; ?><br>
                                        <b>SS #:</b> <?= $el['ss']; ?><br>
                                        <b>Gender:</b> <?= $el['gender']; ?><br>
                                        <b>Email:</b> <?= $el['email']; ?><br>
                                        <b>Pay Type:</b> <?= $el['is_paid']; ?><br>
                                        <b>Date Of Birth:</b> <?= date('m/d/Y', strtotime($el['date_of_birth'])); ?><br>
                                        <b>Date Of Hire:</b> <?= date('m/d/Y', strtotime($el['date_of_hire'])); ?><br>
                                        <b>Payroll Check Receive Type:</b> <?= $el['payroll_check']; ?><br>
                                        <?php if ($el['payroll_check'] == 'Direct Deposit'): ?>
                                            <b>Bank Account Type:</b> <?= $el['bank_account_type']; ?><br>
                                            <b>Bank Account#:</b> <?= $el['bank_account']; ?><br>
                                            <b>Bank Routing#:</b> <?= $el['bank_routing']; ?><br>
                                        <?php endif; ?>
                                        <b>Hourly Rate or Salary Per Pay Period:</b> <?= $el['hourly_rate']; ?><br>
                                        <b>Filing Status:</b> <?= $el['filing_status']; ?><br>
                                        <b>#Of Allowances from IRS Form W-4:</b> <?= $el['irs_form']; ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (isset($order_extra_data['state_name']) && $order_extra_data['state_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            State:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data['state_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>  
                <?php if (isset($order_extra_data['county_name']) && $order_extra_data['county_name'] != ''): ?>
                    <tr>
                        <td style="<?= $td_style; ?>">
                            County:
                        </td>
                        <td style="<?= $td_style; ?>">
                            <?= $order_extra_data['county_name']; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td style="<?= $td_style; ?>">
                        <b>Services:</b>
                    </td>
                    <?php if (!empty($related_service_list)): ?>
                        <td style="<?= $td_style; ?>">
                            <?php
                        
                            foreach ($related_service_list as $key => $rsl):
                                if ($order_status_array[$rsl['service_request_status']] == 'Completed') {
                                    $trk_class = 'label-primary';
                                } elseif ($order_status_array[$rsl['service_request_status']] == 'Started') {
                                    $trk_class = 'label-yellow';
                                } elseif ($order_status_array[$rsl['service_request_status']] == 'Not Started') {
                                    $trk_class = 'label-success';
                                } elseif ($order_status_array[$rsl['service_request_status']] == 'Canceled') {
                                    $trk_class = 'label-danger';
                                }
                                ?>
                                <div class="row" id = "collapse<?= $order_info['id']; ?>">
                                    <div class="col-md-6">
                                        <div class='media-body'>


                                <h4 class='media-heading'><strong><?= ' #' . $invoice_info['id']; ?>-<?= $key+1; ?></strong>&nbsp;<label class='label label-primary'><?= $rsl['service_name']; ?></label></h4></label>


                                            <p> 
                                                <b>Service Category: </b> <?= $rsl['service_category']; ?><br>
                                                <b>Responsible Department: </b> <?= $rsl['responsible_department']; ?><br>
                                                <b>Notes: </b>
                                                
                                                <?php
                                                $note_count_inner = getNoteCount('service', $rsl['id']);

                                                if ($order_info['service_id'] == '11') {
                                                    if ($rsl['id'] == '11') {
                                                        echo "<span title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $order_info['service_id'].'-'.$rsl['id'] . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollemp\',\'' . $rsl['id'] . '\',\'' . $order_info['service_id'] . '\',\'' . $order_info['company_id'] . '\',\'' . $order_info['id'] . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $order_info['service_id'].'-'.$rsl['id'] . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollemp\',\'' . $rsl['id'] . '\',\'' . $order_info['service_id'] . '\',\'' . $order_info['company_id'] . '\',\'' . $order_info['id'] . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></span><br>";
                                                        ?>
                                                        <?php
                                                    } else {
                                                        echo "<span title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $order_info['service_id'] .'-'.$rsl['id'] . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollrt6\',\'' . $rsl['id'] . '\',\'' . $order_info['service_id'] . '\',\'' . $order_info['company_id'] . '\',\'' . $order_info['id'] . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $order_info['service_id'].'-'.$rsl['id'] . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollrt6\',\'' . $rsl['id'] . '\',\'' . $order_info['service_id'] . '\',\'' . $order_info['company_id'] . '\',\'' . $order_info['id'] . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></span><br>";
                                                    }
                                                } else {
                                                    echo "<span title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $order_info['service_id'].'-'.$rsl['id'] . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'service\',\'' . $rsl['id'] . '\',\'' . $order_info['service_id'] . '\',\'' . $order_info['company_id'] . '\',\'' . $order_info['id'] . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $order_info['service_id'].'-'.$rsl['id'] . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'service\',\'' . $rsl['id'] . '\',\'' . $order_info['service_id'] . '\',\'' . $order_info['company_id'] . '\',\'' . $order_info['id'] . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></span><br>";
                                                }
                                                ?>
                                                <b>Tracking Description: </b> 
                                                <span class="label <?php echo $trk_class; ?> label-block" style="width: 80px; display: inline-block; text-align: center;"><?= $order_status_array[$rsl['service_request_status']]; ?></span>
                                                <br>
                                                <b>Target Start: </b><?= ($rsl['start_date'] != '' && $rsl['start_date'] != '0000-00-00') ? date('m/d/Y', strtotime($rsl['start_date'])) : 'N/A'; ?><br>
                                                <b>Target Complete: </b><?= ($rsl['complete_date'] != '' && $rsl['complete_date'] != '0000-00-00') ? date('m/d/Y', strtotime($rsl['complete_date'])) : 'N/A'; ?><br>
                                                <b>Actual Complete: </b><?= ($rsl['service_request_status'] != '0' && $rsl['complete_date'] != '' && $rsl['complete_date'] != '0000-00-00') ? date('m/d/Y', strtotime($rsl['complete_date'])) : 'N/A'; ?><br>
                                                <b>Retail Price: </b> <?= $rsl['retail_price']; ?>, 
                                                <b>Override Price: </b><?= ($rsl['price_charged'] != '') ? $rsl['price_charged'] : 'N/A'; ?>
                                            </p>
                                    
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class='media-body'>                                        
                                            <?php
                                            // $service_note_list = related_service_note_list($order_info['id'], $rsl['service_id']); 
                                            ?>
                                            <?php
                                            // if (!empty($service_note_list)): 
                                            ?>
                                            <!-- <h4 class='media-heading'>Service Notes:</h4> -->
                                            <?php
                                            // foreach ($service_note_list as $snl): 
                                            ?>
                                                <!-- <div id="<?//= 'note-notification-' . $snl['note_id']; ?>"> -->
                                                    <!-- <p class="notification-text-area"> -->
                                            <?php
                                            // echo $snl['note']; 
                                            ?>
                                            <!-- </p>
                                        </div> -->
                                            <?php
                                            // endforeach; 
                                            ?>
                                            <?php
                                            // endif; 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed m-t-5 m-b-5"></div>
                            <?php endforeach; ?>
                        </td>
                    <?php else: ?>
                        <td style="<?= $td_style; ?>">
                            N/A
                        </td>
                    <?php endif; ?>
                </tr>
                <tr class="file_tr">
                    <td colspan="2" style="<?= $td_style; ?>">
                        <h4>All Files</h4>
                    </td>
                </tr>
                <tr class="file_tr">
                    <td colspan="2" style="<?= $td_style; ?>">
                        <?php if (!empty($document_list)): ?>
                            <b>Documents:</b>
                            <?php foreach ($document_list as $dl): ?>
                                <?php $all_document[] = $dl['document']; ?>
                                <div class='media-body'>
                                    <a href="<?= base_url('/uploads/') . $dl['document']; ?>"><?= $dl['document']; ?></a> 
                                    <b>(<?= $dl['doc_type']; ?>)</b><br>
                                </div>
                            <?php endforeach; ?>
                            <div class="hr-line-dashed m-t-5 m-b-5"></div>
                        <?php endif; ?>
                        <?php if (!empty($owner_list)): ?>
                            <?php foreach ($owner_list as $ol): ?>
                                <?php $owner_document_list = get_document_list($ol['individual_id'], 'individual'); ?>
                                <?php if (!empty($owner_document_list)): ?>
                                    <b>Owner Documents:</b>
                                    <?php foreach ($owner_document_list as $odl): ?>
                                        <?php $all_document[] = $odl['document']; ?>
                                        <div class='media-body'>
                                            <a href="<?= base_url('/uploads/') . $odl['document']; ?>"><?= $odl['document']; ?></a> 
                                            <b>(<?= $odl['doc_type']; ?>)</b><br>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="hr-line-dashed m-t-5 m-b-5"></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (isset($salestax_driver_license_data) && !empty($salestax_driver_license_data)): ?>
                            <b>Driver License:</b>
                            <?php foreach ($salestax_driver_license_data as $license_data): ?>
                                <?php $all_document[] = $license_data['file_name']; ?>
                                <div class='media-body'>
                                    <a href="<?= base_url('/uploads/') . $license_data['file_name']; ?>"><?= $license_data['file_name']; ?></a><br>
                                </div>
                            <?php endforeach; ?>
                            <div class="hr-line-dashed m-t-5 m-b-5"></div>
                        <?php endif; ?>
                        <?php if (isset($payroll_wage_files) && !empty($payroll_wage_files)): ?>
                            <b>Wage Files:</b>
                            <?php foreach ($payroll_wage_files as $wage_files): ?>
                                <?php $all_document[] = $wage_files['file_name']; ?>
                                <div class='media-body'>
                                    <a href="<?= base_url('/uploads/') . $wage_files['file_name']; ?>"><?= $wage_files['file_name']; ?></a><br>
                                </div>
                            <?php endforeach; ?>
                            <div class="hr-line-dashed m-t-5 m-b-5"></div>
                        <?php endif; ?>
                        <?php if (isset($company_extra_data['fein_filename']) && $company_extra_data['fein_filename'] != "" && file_exists($company_extra_data['fein_filename'])): ?>
                            <b>FIEN File:</b>
                            <?php $all_document[] = $company_extra_data['fein_filename']; ?>
                            <div class='media-body'>
                                <a href="<?= base_url('/uploads/') . $company_extra_data['fein_filename']; ?>"><?= $company_extra_data['fein_filename']; ?></a><br>
                            </div>
                            <div class="hr-line-dashed m-t-5 m-b-5"></div>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="text-right">
            <?php if (!empty($all_document)): ?>
                <form name="download_form" method="POST" action="<?= base_url('services/home/download_zip'); ?>">
                    <input type="hidden" id="filesarray" name="filesarray" value="<?= implode(',', $all_document); ?>">
                    <button class="btn btn-info m-t-10" type="submit"><i class="fa fa-download"></i> Download All Files</button>
                    <!--<button class="btn btn-danger m-t-10" type="button" onclick="go('services/home');">Back to dashboard</button>-->
                </form>
            <?php else: ?>
                <!--                <button class="btn btn-danger" type="button" onclick="go('services/home');">Back to dashboard</button>-->
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="show_notes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <!-- <form method="post" action="<?//= base_url(); ?>services/home/updateNotes"> -->
            <form method="post" id="modal_note_form_update" onsubmit="update_service_note()">    
                <div id="notes-modal-body" class="modal-body p-b-0">

                </div>
                <div class="modal-body p-t-0 text-right">
                    <button type="button" class="btn btn-primary" id="update_note" onclick="update_service_note()">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
            <!-- <form method="post" id="modal_note_form" action="<?//= base_url(); ?>services/home/addNotesmodal"> -->
            <form method="post" id="modal_note_form" onsubmit="add_service_notes()">    
                <div class="modal-body">
                    <h4>Add Note</h4>
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="referral_partner_note[]"  title="Referral Partner Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-referreal-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="reference_id" id="reference_id">
                    <input type="hidden" name="related_table_id" id="related_table_id">
                    <input type="hidden" name="reference" id="reference">

                    <input type="hidden" name="order_id" id="order_id">
                    <input type="hidden" name="serviceid" id="serviceid">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="add_service_notes();" class="btn btn-primary">Save Note</button>
                    <!-- <button type="submit" id="save_note" class="btn btn-primary" onclick="document.getElementById('modal_note_form').submit();this.disabled = true;this.innerHTML = 'Processing...';">Save Note</button> -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Sos Modal -->
<div class="modal fade" id="showSos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">SOS</h4>
            </div>
            <div id="notes-modal-body" class="modal-body p-b-0">

            </div>
            <!-- <form method="post" id="sos_note_form" action="<?//= base_url(); ?>home/addSos"> -->
            <form method="post" id="sos_note_form" onsubmit="add_sos()">    
                <div class="modal-body">
                    <h4 id="sos-title">Add New SOS</h4>
                    <div class="form-group" id="add_sos_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="sos_note"  title="SOS Note"></textarea>
                        </div>
                        <!-- <a href="javascript:void(0)" class="text-success add-referreal-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a> -->
                    </div>
                    <input type="hidden" name="reference" id="reference" value="order">
                    <input type="hidden" name="refid" id="refid">
                    <input type="hidden" name="staffs" id="staffs">
                    <input type="hidden" name="serviceid" id="serviceid">
                    <input type="hidden" name="replyto" id="replyto" value="">
                    <input type="hidden" name="servreqid" id="servreqid" value="">
                </div>
                <div class="modal-footer">
                    <!-- <button type="submit" id="save_sos" class="btn btn-primary" onclick="document.getElementById('sos_note_form').submit();this.disabled = true;this.innerHTML = 'Processing...';">Post SOS</button> -->
                    <button type="button" id="save_sos" class="btn btn-primary" onclick="add_sos()">Post SOS</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Sos Modal -->
<div id="changeStatusinner" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2" value="2"/>
                                <label for="rad2"><strong>Not Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad1" value="1"/>
                                <label for="rad1"><strong>Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad0" value="0"/>
                                <label for="rad0"><strong>Completed</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad7" value="7"/>
                                <label for="rad7"><strong>Canceled</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="suborderid" value="">
                <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateStatusinner()">Save changes</button>
            </div>
            <div class="modal-body" style="display: none;" id="log_modal">
                <div style="height:200px; overflow-y: scroll">
                    <table id="status_log" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- notes modal -->
<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="notification">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div id="msg-modal-body" class="modal-body"></div>
        </div>
    </div>
</div>
<!-- attachments modal -->

<div class="modal fade" id="modal_area_attach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="notification">
        <div class="modal-content">
            <div class="modal-header">Attachments</div>
            <div id="modal-body-attachments" class="modal-body"></div>
            <div class="modal-footer">   
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<?php if (empty($all_document)): ?>
    <script>
        $(function () {
            $('.file_tr').hide();
        });
    </script>
<?php endif; ?>

<script type="text/javascript">
    function show_notes_outer(reference, reference_id, new_staffs, order_id) {
        var url = '<?= base_url(); ?>services/home/getNotesContent';
        var data = {
            reference: reference,
            reference_id: reference_id,
            loc: 'outer'
        };
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                $('#notes-modal-body').html(data);
                $("#show_notes #reference_id").val(reference_id);
                $("#show_notes #order_id").val(reference_id);
                $("#reference").val(reference);
                $("#related_table_id").val(1);
                $.ajax({
                    url: '<?= base_url(); ?>services/home/add_model_note',
                    type: 'POST',
                    data: {
                        required: "n",
                        reference: reference,
                        reference_id: reference_id,
                        multiple: "y"
                    },
                    success: function (data) {
                        $('#add_note_div').html(data);
                        openModal('show_notes');
                    }
                });
            },
            dataType: 'html'
        });
    }

    function show_notes(reference, reference_id, service_id, row_inner_id, order_id) {
        // alert(order_id);return false;
        if (reference == 'payrollemp') {
            var url = '<?= base_url(); ?>services/home/getNotesContentPayrollform';
            var data = {reference: reference, reference_id: reference_id};
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
                    //alert(data);
                    $('#notes-modal-body').html(data);
                    $("#show_notes #reference_id").val(reference_id);
                    $("#show_notes #serviceid").val(service_id);
                    $("#show_notes #order_id").val(order_id);
                    $("#reference").val(reference);
                    $("#related_table_id").val(4);
                    $.ajax({
                        url: '<?= base_url(); ?>services/home/add_model_note',
                        type: 'POST',
                        data: {
                            required: "n",
                            reference: reference,
                            reference_id: reference_id,
                            multiple: "y"
                        },
                        success: function (data) {
                            $('#add_note_div').html(data);
                            openModal('show_notes');
                        }
                    });
                    openModal('show_notes');
                },
                dataType: 'html'
            });
        } else if (reference == 'payrollrt6') {
            var url = '<?= base_url(); ?>services/home/getNotesContentPayrollform';
            var data = {reference: reference, reference_id: reference_id};
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
                    //alert(data);
                    $('#notes-modal-body').html(data);
                    $("#show_notes #reference_id").val(reference_id);
                    $("#show_notes #serviceid").val(service_id);
                    $("#show_notes #order_id").val(order_id);
                    $("#reference").val(reference);
                    $("#related_table_id").val(5);
                    $.ajax({
                        url: '<?= base_url(); ?>services/home/add_model_note',
                        type: 'POST',
                        data: {
                            required: "n",
                            reference: reference,
                            reference_id: reference_id,
                            multiple: "y"
                        },
                        success: function (data) {
                            $('#add_note_div').html(data);
                            openModal('show_notes');
                        }
                    });
                    openModal('show_notes');
                },
                dataType: 'html'
            });
        } else {
            var url = '<?= base_url(); ?>services/home/getNotesContent';
            var data = {reference: reference, reference_id: reference_id, loc: 'inner', service_id: service_id};
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
                    // alert(data);
                    $('#notes-modal-body').html(data);
                    $("#show_notes #reference_id").val(reference_id);
                    $("#show_notes #serviceid").val(service_id);
                    $("#show_notes #order_id").val(order_id);
                    $("#reference").val(reference);
                    $("#related_table_id").val(1);

                    $.ajax({
                        url: '<?= base_url(); ?>services/home/add_model_note',
                        type: 'POST',
                        data: {
                            required: "n",
                            reference: reference,
                            reference_id: reference_id,
                            multiple: "y"
                        },
                        success: function (data) {
                            $('#add_note_div').html(data);

                            openModal('show_notes');
                        }
                    });
                    openModal('show_notes');
                },
                dataType: 'html'
            });
        }
    }
</script>