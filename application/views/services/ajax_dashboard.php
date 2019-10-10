<div class="clearfix result-header">
    <?php if (count($result) != 0): ?>
        <h2 class="text-primary pull-left result-count-h2"><?= isset($page_number) ? ($page_number * 20) : count($result) ?> Results found <?= isset($page_number) ? 'of ' . count($result) : '' ?></h2>
    <?php endif; ?>
    <div class="pull-right text-right p-t-4">
        <div class="dropdown" style="display: inline-block;">
            <a href="javascript:void(0);" id="sort-by-dropdown" data-toggle="dropdown" class="dropdown-toggle btn btn-success">Sort By <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a id="order_serial_id-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.order_serial_id')">ID</a></li>
                <li><a id="client_name-val" href="javascript:void(0);" onclick="sort_service_dashboard('client_name')">Client Name</a></li>
                <li><a id="office_id-val" href="javascript:void(0);" onclick="sort_service_dashboard('office_id')">Office ID</a></li>
                <li><a id="status-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.status')">Tracking</a></li>
                <li><a id="order_date-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.order_date')">Requested Date</a></li>
                <li><a id="start_date-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.start_date')">Start Date</a></li>
                <li><a id="complete_date-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.complete_date')">Complete Date</a></li>
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
$usertype = $user_info['type'];
$row_number = 0;
if (!empty($result)):
    foreach ($result as $row_count => $row):        
        if(isset($page_number)){
            if($page_number != 1){
                if($row_count < (($page_number - 1) * 20)){
                    continue;
                }
            }
            if($row_count == ($page_number * 20)){
                break;
            }
        }
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
        $late_status = $row->late_status;
        if ($late_status == '1') {
            $late_class = $row->department_id . '-late';
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
//        $services_list = service_list_by_order_id($row->id);
        ?>
        <div id="order<?= $row->id; ?>" class="panel panel-default service-panel category<?= $row->category_id; ?> filter-<?= $row->department_id . '-' . $status . ' ' . $late_class; ?>">
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
                    <?php if ($row->assign_user_id == 1) { ?>
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
                <a class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $row->id; ?>" onclick="serviceListAjax('<?= $row->id ?>', '<?= $row->all_staffs ?>');" aria-expanded="false" class="collapsed" style="cursor:default;">
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tr>
                                <th style="width:8%; text-align: center;">ID#</th>
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
                                <td style="font-weight: normal; width:10%; text-align: center;" title="Client Name" style="word-break: break-all;"><?= $row->client_name; ?></td>
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Tracking" id="trackingmain-<?= $row->id; ?>">
                                    <span class="label <?php echo $trk_class; ?> label-block" style="width: 80px; display: inline-block; text-align: center;">
                                        <?= $tracking; ?>
                                    </span>
                                </td>
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Order Date"><?= date('m/d/Y', $order_date); ?></td>
                                <td style="font-weight: normal; width:10%; text-align: center;" title="Office"><?= $row->office; ?></td>                                
                                <td style="font-weight: normal; width:8%; text-align: center;" title="Requested by"><?= $row->requested_staff_name; ?></td>
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
            <div id="collapse<?= $row->id; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;"></div>
        </div>
        <?php
        $row_number = $row_count + 1;
    endforeach;
    if(isset($page_number) && $row_number < count($result)): ?>
        <div class="text-center p-0 load-more-btn">
            <a href="javascript:void(0);" onclick="loadServiceDashboard('', '', 'on_load', '', <?= $page_number + 1; ?>);" class="btn btn-success btn-sm m-t-30 p-l-15 p-r-15"><i class="fa fa-arrow-down"></i> Load more result</a>
        </div>
    <?php endif; ?>    
        <script>
            $(function () {
                $('h2.result-count-h2').html('<?= $row_number . ' Results found of ' . count($result) ?>');
                <?php if(isset($page_number) && $row_number == count($result)): ?>
                    $('.load-more-btn').remove();
                <?php endif; ?>
            });
        </script>
    <?php if(isset($load_type) && isset($page_number) && $page_number == 1):
        $filter_array = isset($load_type) ? array_merge(array_count_values(array_column($result, 'tome_filter_value')), array_count_values(array_column($result, 'byothers_filter_value')), array_count_values(array_column($result, 'byme_filter_value')), array_count_values(array_column($result, 'tome_late_filter_value')), array_count_values(array_column($result, 'byothers_late_filter_value')), array_count_values(array_column($result, 'byme_late_filter_value'))) : [];
        $assign_status = isset($load_type) ? array_count_values(array_column($result, 'assign_status')) : [];
        ?>
        <script>
            $(function () {
                <?php foreach ($filter_array as $key => $value): ?>
                    $('a#filter-<?= $key; ?> span.label').html('<?= $value != '' ? $value : 0; ?>');
                <?php endforeach; ?>
                $('a#filter-unassigned-u span.label').html('<?= isset($assign_status['unassigned']) ? $assign_status['unassigned'] : 0; ?>');                    
            });
        </script>        
    <?php endif; 
else: ?>
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
