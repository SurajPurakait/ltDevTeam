<div class="clearfix">
    <?php if (count($result) != 0): ?>
        <h2 class="text-primary pull-left"><?= count($result); ?> Results found</h2>
    <?php endif; ?>
    <div class="pull-right text-right p-t-4">
        <div class="dropdown" style="display: inline-block;">
            <a href="javascript:void(0);" id="sort-by-dropdown" data-toggle="dropdown" class="dropdown-toggle btn btn-success">Sort By <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a id="order_serial_id-val" href="javascript:void(0);" onclick="sort_service_dashboard('o.order_serial_id')">ID</a></li>
                <li><a id="client_name-val" href="javascript:void(0);" onclick="sort_service_dashboard('client_name')">Client Name</a></li>
                <li><a id="office_id-val" href="javascript:void(0);" onclick="sort_service_dashboard('office_id')">Office ID</a></li>
                <li><a id="status-val" href="javascript:void(0);" onclick="sort_service_dashboard('o.status')">Tracking</a></li>
                <li><a id="order_date-val" href="javascript:void(0);" onclick="sort_service_dashboard('o.order_date')">Requested Date</a></li>
                <li><a id="start_date-val" href="javascript:void(0);" onclick="sort_service_dashboard('o.start_date')">Start Date</a></li>
                <li><a id="complete_date-val" href="javascript:void(0);" onclick="sort_service_dashboard('o.complete_date')">Complete Date</a></li>
            </ul>
        </div>
        <div class="sort_type_div" style="display: none;">
            <a href="javascript:void(0);" id="sort-asc" onclick="sort_service_dashboard('', 'DESC')" class="btn btn-success" data-toggle="tooltip" title="Ascending Order" data-placement="top"><i class="fa fa-sort-amount-asc"></i></a>
            <a href="javascript:void(0);" id="sort-desc" onclick="sort_service_dashboard('', 'ASC')" class="btn btn-success" data-toggle="tooltip" title="Descending Order" data-placement="top"><i class="fa fa-sort-amount-desc"></i></a>
            <a href="javascript:void(0);" onclick="serviceFilter();" class="btn btn-white text-danger" data-toggle="tooltip" title="Remove Sorting" data-placement="top"><i class="fa fa-times"></i></a>
        </div>
    </div>
</div>    
<?php
$user_id = sess('user_id');
$user_info = staff_info();
$user_dept = $user_info['department'];
$usertype = $user_info['type'];
$role = $user_info['role'];
if (!empty($result)):
    foreach ($result as $row):
        $added_by = $row->staff_requested_service;
        $added_by = (array) $added_by;
        $staff = explode(',', $row->all_staffs);
        $st = array_merge($staff, $added_by);
        $stf = array_unique($st);
        $new_staffs = implode(',', $stf);
        $invoice_info = invoice_info_by_order_id($row->id);
        $target_start_date = date("m/d/Y", strtotime($row->target_start_date));
        $target_complete_date = date("m/d/Y", strtotime($row->target_complete_date));
        $note_count = getNoteCount('order', $row->id);
        $status = $row->status;
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
        $sql_query_result = get_office_name($row->reference, $row->reference_id);
        if (!empty($sql_query_result)) {
            $office_name = $sql_query_result->office_name;
        } else {
            $office_name = '-';
        }

        $late_status = $row->late_status;
        if ($late_status == '1') {
            $late_class = $row->dept . '-late';
        } else {
            $late_class = '';
        }
        $order_date = strtotime($row->order_date);
        $url = '';
        if ($usertype != '3') {
            if ($row->category_id == 1) {
                if ($row->service_id == '3' || $row->service_id == '39' || $row->service_id == '48') {
                    $url = 'services/accounting_services/edit_annual_report/' . $row->id;
                } elseif ($row->service_id == '2' || $row->service_id == '4' || $row->service_id == '6' || $row->service_id == '53') {
                    $url = 'services/home/edit/' . $row->id;
                } elseif ($row->service_id == '5' || $row->service_id == '54' || $row->service_id == '55') {
                    $url = 'services/home/edit/' . $row->id;
                } elseif ($row->service_id == '7') {
                    $url = 'services/home/edit/' . $row->id;
                } else {
                    if ($row->service_shortname == 'inc_n_c_d' || $row->service_shortname == 'inc_n_c_f') {
                        $url = 'services/incorporation/edit_company/' . $row->id;
                    } else {
                        $url = 'services/home/edit/' . $row->id;
                    }
                }
            } else {
                if ($row->service_id == 10 || $row->service_id == '41') {
                    $res = get_bookkeeping_by_order_id($row->id);
                    if (!empty($res)) {
                        if ($res['sub_category'] == 2) {
                            $url = 'services/accounting_services/edit_bookkeeping_by_date/' . $row->id;
                        } else {
                            $url = 'services/accounting_services/edit_bookkeeping/' . $row->id;
                        }
                    } else {
                        $url = 'services/accounting_services/edit_bookkeeping/' . $row->id;
                    }
                } elseif ($row->service_id == '11') {
                    $url = 'services/accounting_services/edit_payroll/' . $row->id;
                } elseif ($row->service_id == '12') {
                    $url = 'services/accounting_services/edit_sales_tax_application/' . $row->id;
                } elseif ($row->service_id == '14') {
                    $url = 'services/accounting_services/edit_rt6_unemployment_app/' . $row->id;
                } elseif ($row->service_id == $serviceid) {
                    $url = 'services/accounting_services/edit_sales_tax_recurring/' . $row->id;
                } elseif ($row->service_id == '13') { //change in live
                    $url = 'services/accounting_services/edit_sales_tax_processing/' . $row->id;
                } elseif ($row->service_id == '3' || $row->service_id == '48') {
                    $url = 'services/accounting_services/edit_annual_report/' . $row->id;
                } elseif ($row->service_id == '48' || $row->service_id == '39') {
                    $url = 'services/accounting_services/edit_annual_report/' . $row->id;
                } else {
                    $url = 'services/home/edit/' . $row->id;
                }
            }
            if (in_array($row->service_shortname, edit_by_shortname_array())) {
                $url = 'services/home/edit/' . $row->id;
            }
        } else {
            if ($usertype == '3' && $status == 2) {
                if ($row->category_id == 1) {
                    if ($row->service_id == '3' || $row->service_id == '39' || $row->service_id == '48') {
                        $url = 'services/accounting_services/edit_annual_report/' . $row->id;
                    } else {
                        if ($row->service_shortname == 'inc_n_c_d' || $row->service_shortname == 'inc_n_c_f') {
                            $url = 'services/incorporation/edit_company/' . $row->id;
                        } else {
                            $url = 'services/home/edit/' . $row->id;
                        }
                    }
                } else {
                    if ($row->service_id == 10 || $row->service_id == '41') {
                        $res = get_bookkeeping_by_order_id($row->id);
                        if (!empty($res)) {
                            if ($res['sub_category'] == 2) {
                                $url = 'services/accounting_services/edit_bookkeeping_by_date/' . $row->id;
                            } else {
                                $url = 'services/accounting_services/edit_bookkeeping/' . $row->id;
                            }
                        } else {
                            $url = 'services/accounting_services/edit_bookkeeping/' . $row->id;
                        }
                    } elseif ($row->service_id == '11') {
                        $url = 'services/accounting_services/edit_payroll/' . $row->id;
                    } elseif ($row->service_id == '12') {
                        $url = 'services/accounting_services/edit_sales_tax_application/' . $row->id;
                    } elseif ($row->service_id == '14') {
                        $url = 'services/accounting_services/edit_rt6_unemployment_app/' . $row->id;
                    } elseif ($row->service_id == $serviceid) {
                        $url = 'services/accounting_services/edit_sales_tax_recurring/' . $row->id;
                    } elseif ($row->service_id == '13') { //change in live
                        $url = 'services/accounting_services/edit_sales_tax_processing/' . $row->id;
                    } else {
                        $url = 'services/home/edit/' . $row->id;
                    }
                }
                if (in_array($row->service_shortname, edit_by_shortname_array())) {
                    $url = 'services/home/edit/' . $row->id;
                }
            }
        }
        $total = '-';
        if ($row->total_of_order != '' && isset($row->total_of_order)) {
            $total = '$' . $row->total_of_order;
        }
//        $services_list = listServicesOrderajaxdashboard($row->id, $status, $row->reference_id, $row->service_id);
        $services_list = service_list_by_order_id($row->id);
        ?>
        <div id="order<?= $row->id; ?>" class="panel panel-default service-panel category<?= $row->category_id; ?> filter-<?= $row->dept . '-' . $status . ' ' . $late_class; ?>">
            <div class="panel-heading">
                <a title="<?= $row->service_name; ?>" href="<?= base_url('services/home/view/' . $row->id); ?>" class="btn btn-primary btn-xs btn-service-view" target="_blank">
                    <i class="fa fa-eye" aria-hidden="true"></i> View
                </a>
                <?php
                if ($url != ''):
                    if ($tracking == 'Started') {
                        ?>
                        <a href="<?= base_url($url) ?>" class="btn btn-primary btn-xs btn-service-edit" style="display: none" target="_blank">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                        </a>
                        <?php
                    } else {
                        if (!empty($invoice_info) && $invoice_info['is_order'] == 'y') {
                            $url = 'billing/invoice/edit/' . base64_encode($invoice_info['id']);
                        }
                        ?>
                        <a href="<?= base_url($url) ?>" class="btn btn-primary btn-xs btn-service-edit" target="_blank">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                        </a>
                        <?php
                    }
                endif;
                ?>
                <div class="assigned-status">
                    <a title="<?= $row->service_name; ?>" href="<?= base_url() . 'services/home/download/' . $row->id; ?>" class="label btn-service-pdf bookkeepingbydate">
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF
                    </a>
                    <?php if ($row->assign_user == 1) { ?>
                        <label class="label label-primary"><i class="fa fa-check"></i> Assigned</label>
                    <?php } else {
                        ?>
                        <label class="label label-default">Unassigned</label>
                    <?php } ?>
                </div>
                <?php
                $check_if_sos_exists = check_if_sos_exists('order', $row->id);
                if (!empty($check_if_sos_exists)) {
                    echo '<div class="priority"><img class="m-t-5" src="' . base_url() . '/assets/img/badge_sos_priority.png" /></div>';
                } else {
                    echo '<div class="priority"></div>';
                }
                ?>
                <a class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $row->id; ?>" aria-expanded="false" class="collapsed" style="cursor:default;">
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tr>
                                <th style="width:8%; text-align: center;">ID#</th>
                                <!--<th style="width:8%; text-align: center;">INV#</th>-->
                                <th style="width:10%; text-align: center;white-space: nowrap;">Client Name</th>
                                <th style="width:8%; text-align: center;">Tracking</th>
                                <th style="width:10%; text-align: center;">Requested</th>
                                <th style="width:8%; text-align: center;">Office</th>                                
                                <th style="width:10%; text-align: center;">Requested by</th>
                                <th style="width:8%; text-align: center; white-space: nowrap;">
                                    <?php if ($row->status == "2" || $row->status == "3"): ?>
                                        Target Start
                                    <?php else: ?>
                                        Start Date&nbsp;<span data-toggle="tooltip" data-placement="top" title="<?= "Expected Start Date : " . $target_start_date; ?>"><i class="fa fa-info-circle"></i></span>
                                    <?php endif; ?>
                                </th>
                                <th style="width:8%; text-align: center; white-space: nowrap;">
                                    <?php if ($row->status == "2" || $row->status == "3"): ?>
                                        Target Complete
                                    <?php else: ?>
                                        Complete Date&nbsp;<span data-toggle="tooltip" data-placement="top" title="<?= "Expected Complete Date : " . $target_complete_date; ?>"><i class="fa fa-info-circle"></i></span>
                                    <?php endif; ?>
                                </th>                                
                                <th style="width:8%; text-align: center;">Amount$$$</th>
                                <th style="width:8%; text-align: center;">Notes</th>
                                <th style="width:8%; text-align: center;">Services</th>
                                <th style="width:8%; text-align: center;">Attachments</th>
                            </tr>
                            <tr>
                                <td style="font-weight: normal; width:8%;  text-align: center;" title="ID"><?= (!empty($invoice_info)) ? "<a href='javascript:void(0);' onclick=\"go('billing/invoice/details/" . base64_encode($invoice_info['id']) . "');\" target='_blank'>#" . $invoice_info['id'] . "</a>" : 'N/A'; ?></td>
                                <!--<td style="font-weight: normal; width:8%;  text-align: center;" title="ID">#<?php // $row->order_serial_id;                             ?></td>-->
                                <!--<td style="font-weight: normal; width:8%; text-align: center;" title="INV ID"><?php // (!empty($invoice_info)) ? "<a href='javascript:void(0);' onclick=\"go('billing/invoice/details/" . base64_encode($invoice_info['id']) . "');\" target='_blank'>#" . $invoice_info['id'] . "</a>" : 'N/A';                             ?></td>-->
                                <td style="font-weight: normal; width:10%; text-align: center;" title="Client Name" style="word-break: break-all;"><?= $row->client_name; ?></td>
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Tracking" id="trackingmain-<?= $row->id; ?>">
                                    <span class="label <?php echo $trk_class; ?> label-block" style="width: 80px; display: inline-block; text-align: center;">
                                        <?= $tracking; ?>
                                    </span>
                                </td>
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Order Date"><?= date('m/d/Y', $order_date); ?></td>
                                <td style="font-weight: normal; width:10%; text-align: center;" title="Office"><?= $row->office; ?></td>                                
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Requested by"><?= $row->requested_staff; ?></td>
                                <td style="font-weight: normal; width:8%; text-align: center;" align="left" title="Start Date">
                                    T:<?= ($row->target_start_date != '') ? date("m/d/Y", strtotime($row->target_start_date)) : '-'; ?><br>
                                    <?php if ($row->status == 1) { ?>
                                        A:<?= ($row->start_date != '') ? date("m/d/Y", strtotime($row->start_date)) : '-'; ?>
                                    <?php } ?>
                                </td>
                                <td style="font-weight: normal; width:8%; text-align: center;" align="left" title="Complete Date" <?= $late_class != '' ? 'style="color:red;"' : ''; ?>>
                                    T:<?= ($row->target_complete_date != '') ? date("m/d/Y", strtotime($row->target_complete_date)) : '-'; ?><br>
                                    <?php if ($status == 0) { ?>
                                        A:<?= ($row->complete_date != '') ? date("m/d/Y", strtotime($row->complete_date)) : '-'; ?>
                                    <?php } ?>
                                </td>
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Amount"><?= $total; ?></td>
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Notes">
                                    <span>
                                        <?php
                                        $note_data = getReadStatus('order', $row->id);
                                        $data = array_column($note_data, 'read_status');

                                        if ($note_count == 0) {
                                            ?>
                                            <a id="notecount-<?php echo $row->id; ?>" count="<?= $note_count; ?>" class="label label-warning" href="javascript:void(0)" onclick="show_notes_outer('order', '<?= $row->id; ?>');">
                                                <b><?= $note_count; ?></b>
                                            </a>
                                            <?php
                                        } else {
                                            if (in_array(1, $data)) {
                                                ?>
                                                <a id="notecount-<?php echo $row->id; ?>" count="<?= $note_count; ?>" class="label label-success" href="javascript:void(0)" onclick="show_notes_outer('order', '<?= $row->id; ?>');">
                                                    <b><?= $note_count; ?></b>
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <a id="notecount-<?php echo $row->id; ?>" count="<?= $note_count; ?>" class="label label-danger" href="javascript:void(0)" onclick="show_notes_outer('order', '<?= $row->id; ?>');">
                                                    <b><?= $note_count; ?></b>
                                                </a>
                                                <?php
                                            }
                                        }
                                        ?>  

                                    </span>
                                </td>
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Services">
                                    <span class="label label-warning"><?= get_services_count($row->id); ?></span>
                                </td>
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Attachment">
                                    <?php
                                    $number_of_document = get_document_count($row->reference_id, $row->reference);
                                    if ($number_of_document == 0) {
                                        ?>
                                        <span class="label label-warning">
                                            <a class="label label-warning" href="javascript:void(0)" onclick="show_attachments('<?= $row->reference; ?>', '<?= $row->reference_id; ?>');" style="padding: 0px;margin:0px;">
                                                <?php echo $number_of_document; ?>
                                            </a>
                                        </span>    
                                        <?php
                                    } else {
                                        ?>
                                        <span class="label label-primary">
                                            <a class="label label-primary" href="javascript:void(0)" onclick="show_attachments('<?= $row->reference; ?>', '<?= $row->reference_id; ?>');" style="padding: 0px;margin:0px;">
                                                <?php echo $number_of_document; ?>
                                            </a>
                                        </span>    
                                        <?php
                                    }
                                    ?>                                 
                                </td>
                            </tr>
                        </table>
                    </div>
                </a>
            </div>
            <div id="collapse<?= $row->id; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th style='width:11%;  text-align: center;'>Service ID</th>
                                <th style='width:11%;  text-align: center;'>Assign</th>
                                <th style='width:11%;  text-align: center;'>Name</th>
                                <th style='width:11%; text-align: center;'>Retail Price</th>
                                <th style='width:11%; text-align: center;'>Override Price</th>
                                <th style='width:11%; text-align: center;'>Responsible Dept</th>
                                <th style='width:11%; text-align: center;'>Tracking</th>
                                <th style='width:11%; text-align: center;'>Start</th>
                                <!-- <th style='width:11%; text-align: center;'>Actual Start</th> -->
                                <th style='width:11%; text-align: center;'>Complete</th>
                                <!-- <th style='width:11%; text-align: center;'>Actual Complete</th> -->
                                <th style='width:5%; text-align: center;'>Notes</th>
                                <th style='width:5%; text-align: center;'>SOS</th>
                                <th style='width:11%; text-align: center; white-space: nowrap;'>Input Form</th>
                            </tr>
                            <?php
                            $service_id = $row->service_id;
                            $order_id = $row->id;
                            $ref_id = $row->reference_id;
                            //print_r($services_list);
                            if (!empty($services_list)) {
                                $keysval = 1;
                                foreach ($services_list as $keys => $row_inner) {
                                    $keysval = $keysval + $keys;
                                    /* check if rt6 yes or no */
                                    if (trim($row_inner->service_name) == 'Rt6') {
                                        $check_rt6_status = check_rt6_status($row_inner->order_id);
                                        if ($check_rt6_status['rt6_availability'] == 'No') {
                                            $status_rt6_val = 'Yes';
                                        } else {
                                            $status_rt6_val = 'No';
                                        }
                                    } else {
                                        $status_rt6_val = 'Yes';
                                    }
                                    /* check if rt6 yes or no */
                                    $note_count_inner = 0;
                                    if ($service_id == '11') {
                                        if ($row_inner->service_id == '11') {
                                            $note_count_inner = getNoteCountforpayrollform('Note', 'n', 4, 'reference_id', $ref_id);
                                        } elseif ($row_inner->service_id == '42') {
                                            $note_count_inner = getNoteCountforpayrollform('Rt6 Note', 'n', 5, 'reference_id', $ref_id);
                                        } else {
                                            $note_count_inner = getNoteCount('service', $row_inner->service_request_id);
                                        }
                                    } else {
                                        $note_count_inner = getNoteCount('service', $row_inner->service_request_id);
                                    }

                                    if ($row_inner->service_name == 'Create New Company'):
                                        $row_inner->service_name = "New Corporation";
                                    endif;
                                    $start_date = date('m/d/Y', strtotime($row_inner->date_started));
                                    $end_date = date('m/d/Y', strtotime($row_inner->date_completed));

                                    if ($row_inner->date_start_actual != '') {
                                        $actual_start = date('m/d/Y', strtotime($row_inner->date_start_actual));
                                    } else {
                                        $actual_start = '';
                                    }

                                    if ($row_inner->date_complete_actual != '') {
                                        $actual_complete = date('m/d/Y', strtotime($row_inner->date_complete_actual));
                                    } else {
                                        $actual_complete = '';
                                    }
                                    if ($row_inner->status == 0) {
                                        $tracking = 'Completed';
                                        // $actual_complete = $end_date;
                                        // $actual_start = $start_date;
                                        $trk_inner_class = 'label-primary';
                                    } elseif ($row_inner->status == 1) {
                                        $tracking = 'Started';
                                        // $actual_complete = '';
                                        // $actual_start = $start_date;
                                        $trk_inner_class = 'label-yellow';
                                    } elseif ($row_inner->status == 2) {
                                        $tracking = 'Not Started';
                                        // $actual_complete = '';
                                        // $actual_start = '';
                                        $trk_inner_class = 'label-success';
                                    } elseif ($row_inner->status == 7) {
                                        $tracking = 'Canceled';
                                        // $actual_complete = '';
                                        // $actual_start = $start_date;
                                        $trk_inner_class = 'label-danger';
                                    }
                                    if ($row_inner->service_id == '10' || $row_inner->service_id == '41') {
                                        $query_result = get_sum_of_amount_from_financial_acc($row->id, 'grand_total');
                                        if ($query_result[0]['total'] != '0') {
                                            $sub_tot = $query_result[0]['total'];
                                            $query_corp_result = get_bookkeeping_by_order_id($order_id);
                                            $corp_tax = $query_corp_result['corporate_tax_return'];
                                            if ($corp_tax == 'y') {
                                                $tot = $sub_tot + 35;
                                            } else {
                                                $tot = $sub_tot;
                                            }
                                        } else {
                                            $query_sub_result = get_sum_of_amount_from_financial_acc($row->id, 'total_amount');
                                            $tot = $query_sub_result[0]['total'];
                                        }
                                        if ($tot == '' || $tot == 0) {
                                            $tot = $row_inner->retail_price;
                                        }
                                    }
                                    $requested_staff_id = $row->staff_requested_service;
                                    if ($status_rt6_val == 'Yes') { //check rt6 start
                                        ?>
                                        <!-- <tr <?//= ($row_inner->status == 1 && $row->late_status == 1) || ($row_inner->status == 2 && $row->late_status == 1) ? "class='text-danger'" : ""; ?>> -->
                                        <tr <?= ( strtotime($row_inner->date_completed) < strtotime(date('Y-m-d')) ) ? "class='text-danger'" : ""; ?>>
                                            <td title="Service ID" style="text-align: center;">#<?= $invoice_info['id']; ?>-<?= $keysval ?></td>
                                            <td title="Assign" style="text-align: center;" class="">
                                                <?php if ($row_inner->assign_user_id == 0): ?>
                                                    <?php
                                                    if ($usertype != 3) {
                                                        if ($usertype == 1 || ($usertype == 2 & $role == 4)) {
                                                            ?>
                                                            <a href="javascript:void(0);" onclick="show_service_assign_modal('<?= $row_inner->service_request_id; ?>', '<?= $row->all_staffs; ?>');" class="label label-success status_assign"><i class="fa fa-plus"></i> Assign</a>
                                                        <?php } else { ?>
                                                            <a href="javascript:void(0);" onclick="assignService('<?= $row_inner->service_request_id; ?>', '<?php echo $user_id; ?>');" class="label label-success status_assign"><i class="fa fa-plus"></i> Assign</a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                <?php else: ?>
                                                    <label class="label label-primary m-b-5 p-t-5 p-b-5 status_assign"><?= staff_info_by_id($row_inner->assign_user_id)['full_name']; ?></label>
                                                    <?php
                                                    if ($usertype == 3 || ($usertype == 2 && $role == 3)) {
                                                        
                                                    } else {
                                                        ?>
                                                        <a href="javascript:void(0);" onclick="assignService(<?= $row_inner->service_request_id; ?>, 0);" class="label label-danger status_assign"><i class="fa fa-remove"></i></a>
                                                    <?php } ?>
                                                <?php endif; ?>
                                            </td> 
                                            <td title="Service Name" style="text-align: center;"><?= $row_inner->service_name; ?></td>
                                            <td title="Retail Price" style="text-align: center;">
                                                $<?= ($row_inner->service_id == '10' || $row_inner->service_id == '41') ? $tot : $row_inner->retail_price; ?>
                                            </td>
                                            <td title="Override Price" style="text-align: center;">$<?= $row_inner->price_charged; ?></td>    
                                            <td title="Responsible Dept" style="text-align: center;"><?= $row_inner->service_department_name; ?></td>
                                            <?php if ($usertype == "3"): ?>
                                                <td align='left' title="Tracking Description">
                                                    <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                                </td>
                                            <?php else: ?>
                                                <td align='center' title="Tracking Description">
                                                    <?php
                                                    if (($usertype == 3 && $role == 1) || ($usertype == 2 && $role == 3)) {
                                                        $check_if_service_already_assigned = check_if_service_already_assigned($row_inner->service_request_id);
                                                        if ($check_if_service_already_assigned == 0) {
                                                            ?>
                                                            <a href='javascript:void(0);' id='trackinginner-<?php echo $row_inner->service_request_id; ?>' onclick='change_status_inner(<?= $row_inner->service_request_id; ?>,<?= $row_inner->status; ?>, <?= $row_inner->service_request_id ?>);'>
                                                                <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                                            </a>
                                                            <?php
                                                        } else {
                                                            if ($check_if_service_already_assigned == sess('user_id')) {
                                                                ?>
                                                                <a href='javascript:void(0);' id='trackinginner-<?php echo $row_inner->service_request_id; ?>' onclick='change_status_inner(<?= $row_inner->service_request_id; ?>,<?= $row_inner->status; ?>, <?= $row_inner->service_request_id ?>);'>
                                                                    <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                                                </a>
                                                            <?php } else {
                                                                ?>
                                                                <a href='javascript:void(0);' id='trackinginner-<?php echo $row_inner->service_request_id; ?>'>
                                                                    <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                                                </a>
                                                                <?php
                                                            }
                                                        }
                                                    } else {
                                                        ?>
                                                        <a href='javascript:void(0);' id='trackinginner-<?php echo $row_inner->service_request_id; ?>' onclick='change_status_inner(<?= $row_inner->service_request_id; ?>,<?= $row_inner->status; ?>, <?= $row_inner->service_request_id ?>);'>
                                                            <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            <?php endif; ?>
                                            <td align='center' title="Start Date" style="text-align: center;">
                                                T:<?= $start_date; ?><br>
                                                <?php if (isset($actual_start) && $actual_start != '') { ?>
                                                    A:<?= $actual_start; ?> 
                                                <?php } ?>       
                                            </td>
                                            <td align='center' title="Complete Date" style="text-align: center;">
                                                T:<?= $end_date; ?><br>
                                                <?php if (isset($actual_complete) && $actual_complete != '') { ?>
                                                    A:<?= $actual_complete; ?>
                                                <?php } ?>    
                                            </td>
                                            <?php
                                            if ($service_id == '11') {
                                                if ($row_inner->service_id == '11') {
                                                    echo "<td align='center' title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $row_inner->service_id . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollemp\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $ref_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $row_inner->service_id . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollemp\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $ref_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></td>";
                                                } else {
                                                    echo "<td align='center' title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $row_inner->service_id . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollrt6\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $ref_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $row_inner->service_id . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollrt6\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $ref_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></td>";
                                                }
                                            } else {
                                                echo "<td align='center' title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $row_inner->service_id . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'service\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $ref_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $row_inner->service_id . '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'service\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $ref_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></td>";
                                            }
                                            ?>
                                            <td title="SOS" style="text-align: center;">
                                                <span>
                                                    <a id="sosservicecount-<?= $order_id; ?>" class="d-inline p-t-5 p-b-5 p-r-8 p-l-8 label service-sos-count-<?= $row_inner->service_request_id; ?> <?php echo (get_sos_count('order', $row_inner->service_id, $order_id) == 0) ? 'label-primary' : 'label-danger'; ?>" title="SOS" href="javascript:void(0)" onclick="show_sos('order', '<?= $row_inner->service_id; ?>', '<?= $new_staffs; ?>', '<?= $order_id; ?>', '<?= $row_inner->service_request_id; ?>');"><?php echo (get_sos_count('order', $row_inner->service_id, $order_id) == 0) ? '<i class="fa fa-plus"></i>' : '<i class="fa fa-bell"></i>'; ?></a>                                                   
                                                </span>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php
                                                $input_status = 'complete';
                                                if ($row_inner->service_id != $row->service_id) {
                                                    if ($row_inner->input_form != 'y') {
                                                        echo 'N/A';
                                                    } else {
                                                        if ($row_inner->input_form_status == 'n') {
                                                            $input_status = 'incomplete';
                                                            ?>
                                                            <span class="label input-form-incomplete">Incomplete <a href="<?= base_url() . 'services/home/related_services/' . $row_inner->service_request_id; ?>" class="text-white p-5"><i class="fa fa-plus" aria-hidden="true"></i> </a></span>
                                                        <?php } else { ?>
                                                            <span class="label input-form-complete">Complete <a href="<?= base_url() . 'services/home/related_services/' . $row_inner->service_request_id; ?>" class="text-white p-5"><i class="fa fa-pencil" aria-hidden="true"></i> </a></span>
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                                <input type="hidden" class="input-form-status-<?= $row_inner->service_request_id; ?>" value="<?= $input_status; ?>" />
                                            </td>
                                        </tr>
                                        <?php
                                    } //check rt6 end
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endforeach;
else:
    ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i> 
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
<?php endif; ?>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
