<?php
$user_id = sess('user_id');
$user_info = staff_info();
$user_dept = $user_info['department'];
$usertype = $user_info['type'];
$payment_status_array = [
    1 => 'Unpaid',
    2 => 'Partial',
    3 => 'Paid',
    4 => 'Late'
];
$tracking = [
    1 => 'Not Started',
    2 => 'Started',
    3 => 'Completed',
    7 => 'Canceled'
];
$i = 0;
$row_number = 0;
foreach ($result as $row_count => $value):
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
    $row = (object) $value;
    $service_list = billing_services($row->invoice_id);
    $payment_status = $row->payment_status;
    $totel_price = array_sum(array_column($service_list, 'override_price'));

    $status_class = 'label-yellow';
    if ($payment_status == 1) {
        $status_class = 'label-yellow';
    } elseif ($payment_status == 2) {
        $status_class = 'label-success';
    } elseif ($payment_status == 3) {
        $status_class = 'label-primary';
    }

    $tracking_class = 'label-danger';
    if ($row->invoice_status == 1) {
        $tracking_class = 'label-success';
    } elseif ($row->invoice_status == 2) {
        $tracking_class = 'label-yellow';
    } elseif ($row->invoice_status == 3) {
        $tracking_class = 'label-primary';
    }
    if (isset($filter_status) && $filter_status != ''):
        if ($filter_status != $payment_status):
            continue;
        endif;
    else:
        if ($payment_status == 4):
            continue;
        endif;
    endif;
    /*  Payment detail start */
    $total_payble_amount = $total_price = $total_refund_amount = $due_amount = 0;
    $service_receive = $payble_amount = [];
    foreach ($service_list as $key => $val) {
        $payble_amount[] = total_payble_amount($val['order_id'])['pay_amount'];
        $service_list[$key]['refund_amount'] = $refund_amount[] = total_refund_amount($val['order_id'])['pay_amount'];
    }
    $total_refund_amount = number_format((float) array_sum($refund_amount), 2, '.', '');
    $total_payble_amount = number_format((float) array_sum($payble_amount), 2, '.', '');
    foreach ($service_list as $val) {
        $total_price += number_format((float) $val['sub_total'], 2, '.', '');
    }
    $total_price = number_format((float) $total_price, 2, '.', '');
    $due_amount = number_format((float) $total_price - $total_payble_amount, 2, '.', '');
    /* Payment detail end */
    ?>
    <div class="panel panel-default service-panel">
        <div class="panel-heading">
            <?php if ($row->invoice_status == 1 && ($usertype == 1 || in_array(14, explode(',', $user_dept)) || in_array(3, explode(',', $user_dept)) || $row->created_by == sess('user_id'))) { ?>
                <a href="<?= (($row->is_order == 'y' && $row->order_id != 0) || ($row->is_order == 'n' && $row->order_id == 0)) ? base_url("billing/invoice/edit/" . base64_encode($row->invoice_id)) : (edit_order_link($row->order_id) != '' ? base_url() . edit_order_link($row->order_id) : base_url("billing/invoice/edit/" . base64_encode($row->invoice_id))); ?>" target="_blank" class="btn btn-primary btn-xs btn-service-edit btn-service-invoice-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
            <?php } ?>
            <?php if (in_array(3, explode(',', $user_dept)) && $payment_status != 4): ?>
                    <!--<a href="javascript:void(0);" onclick="changePaymentStatus(<?= $row->invoice_id; ?>);" class="btn btn-primary btn-xs btn-service-assign "><i class="fa fa-check" aria-hidden="true"></i> Complete</a>-->
            <?php endif; ?>

            <a href="<?= base_url("billing/invoice/details/" . base64_encode($row->invoice_id)); ?>" target="_blank" class="btn btn-primary btn-xs btn-service-edit-project btn-service-invoice"><i class="fa fa-dollar" aria-hidden="true"></i> Invoice</a>
            <a href="<?= base_url("billing/invoice/place/" . base64_encode($row->invoice_id) . "/" . base64_encode('view')); ?>" target="_blank" class="btn btn-primary btn-xs btn-service-view"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
            <a href="<?= base_url() . 'billing/payments/details/' . base64_encode($row->invoice_id); ?>" target="_blank" class="btn-show-details"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            <a class="panel-title" style="cursor: default;" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $row->invoice_id; ?>" aria-expanded="false" class="collapsed">
                <div class="table-responsive">
                    <table class="table table-borderless text-center m-t-15" style="margin-bottom: 0px;">
                        <tr>
                            <th class="text-center" width="5%">Order&nbsp;ID#</th>
                            <th class="text-center" width="15%">Client&nbsp;Name</th>
                            <th class="text-center" width="5%">Office&nbsp;ID</th>
                            <th class="text-center" width="5%">Partner</th>
                            <th class="text-center" width="5%">Manager</th>
                            <th class="text-center" width="10%">Tracking</th>
                            <th class="text-center" width="10%">Requested&nbsp;by</th>
                            <th class="text-center" width="10%">Created&nbsp;Date</th>
                            <th class="text-center" width="5%">Due Date</th>
                            <th class="text-center" width="5%">Services</th>
                            <th class="text-center" width="5%">Total</th>
                            <th class="text-center" width="5%">Status</th>
                        </tr>
                        <tr>
                            <td title="ID"><a href="<?= base_url("billing/invoice/details/" . base64_encode($row->invoice_id)); ?>">#<?= $row->invoice_id; ?></a></td>
                            <!-- <td title="ORDER ID"><?//= ($row->order_id != 0) ? view_order_link($row->order_id) : 'N/A'; ?></td> -->
                            <td title="Client Name" style="word-break: break-all;"><?= ($row->invoice_type == 1) ? $row->client_name : $row->client_name; ?></td>
                            <td title="Office"><?= $row->officeid; ?></td>
                            <td title="Partner"><?= $row->partner; ?></td>
                            <td title="Manager"><?= $row->manager; ?></td>
                            <td title="Tracking"><a href="javascript:void(0)" onclick="billingDashboardTrackingModal(<?= $row->invoice_id; ?>, <?= $row->invoice_status; ?>);"><span class="label <?= $tracking_class ?> invoice-tracking-span-<?= $row->invoice_id; ?>"><b><?= $tracking[$row->invoice_status]; ?></b></span></a></td>
                            <td title="Requested by"><?= $row->created_by_name; ?></td>
                            <td title="Create Time"><?= date('m/d/Y', strtotime($row->created_time)); ?></td>
                            <td title="Create Time"><?= date('m/d/Y', strtotime('+30 days', strtotime($row->created_time))); ?></td>                            
                            <td align="center" title="Services"><span class="label label-success"><b><?= count($service_list); ?></b></span></td>
                            <td title="Total Amount">$<?= $total_price; ?></td>
                            <td title="Payment status"><a href="javascript:void(0);"><span class="label <?= $status_class ?>"><b><?= $payment_status_array[$payment_status]; ?></b></span></a></td>
                        </tr>
                    </table>
                </div>
            </a>
        </div>
        <div id="collapse<?= $row->invoice_id; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-borderless text-center">
                        <tr>
                            <th class="text-center">Service#</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Service Name</th>
                            <th class="text-center">Retail Price</th>
                            <th class="text-center">Override Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Received</th>
                            <th class="text-center">Due</th>                            
                            <th class="text-center">Notes</th>
                            <th class="text-center">Status</th>
                        </tr>
                        <?php
//                            print_r($service_list);
                        if (!empty($service_list)):
                            foreach ($service_list as $key => $row_inner):
                                $order_id = $row_inner['order_id'];
                                $service_id = $row_inner['service_id'];
                                $row_inner = (object) $row_inner;
                                $note_list = invoice_notes($order_id, $service_id);
                                $service_payble_amount = total_payble_amount($row_inner->order_id)['pay_amount'];
                                $service_refund_amount = total_refund_amount($row_inner->order_id)['pay_amount'];
                                $service_total_amount = $row_inner->override_price * $row_inner->quantity;
                                $row_inner_status = ($service_total_amount != 0) ? invoice_service_payment_status($row->invoice_id, $service_id, $service_total_amount) : 3;
                                $status_class = 'label-warning';
                                if ($row_inner_status == 1) {
                                    $status_class = 'label-warning';
                                } elseif ($row_inner_status == 2) {
                                    $status_class = 'label-success';
                                } elseif ($row_inner_status == 3) {
                                    $status_class = 'label-primary ';
                                }
                                ?>
                                <tr>
                                    <td title="ID"><?= $row->invoice_id . '-' . ($key + 1); ?></td>
                                    <td title="Category"><?= $row_inner->service_category; ?></td>
                                    <td title="Service Name"><?= $row_inner->service; ?></td>
                                    <td title="Retail Price">$<?= number_format((float) $row_inner->retail_price, 2, '.', ''); ?></td>
                                    <td title="Override Price">$<?= number_format((float) $row_inner->override_price, 2, '.', ''); ?></td>
                                    <td title="Quantity"><?= $row_inner->quantity; ?></td>
                                    <td title="Total">$<?= number_format((float) $service_total_amount, 2, '.', ''); ?></td>
                                    <td title="Received">$<?= number_format((float) $service_payble_amount, 2, '.', ''); ?></td>
                                    <td title="Due">$<?= number_format((float) $service_total_amount - $service_payble_amount, 2, '.', ''); ?></td>
                                    <td title="Notes"><span><a class="label label-warning" href="javascript:void(0)" onclick="invoiceNoteModal('<?= $order_id; ?>', '<?= $service_id; ?>');"><b class="note-count-<?= $order_id . '-' . $service_id; ?>"><?= count($note_list); ?></b></a></span></td>
                                    <td title="Status"><a href="javascript:void(0);"><span class="label <?= $status_class ?>"><b><?= $payment_status_array[$row_inner_status]; ?></b></span></a></td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>                            
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($reference_id) && $reference_id != ''): ?>
        <h3 class="pull-right alert alert-warning"><i class="fa fa-warning"></i> Total Due: $<?= number_format((float) array_sum(array_column($result, 'sub_total')) - array_sum(array_column($result, 'pay_amount')), 2, '.', ''); ?></h3>
        <?php
    endif;
    $i++;
    $row_number = $row_count + 1;
endforeach;
if(isset($page_number) && $row_number < count($result)): ?>
    <div class="text-center p-0 load-more-btn">
        <a href="javascript:void(0);" onclick="loadBillingDashboard('', '', '', '', 'on_load',<?= $page_number + 1; ?>);" class="btn btn-success btn-sm m-t-30 p-l-15 p-r-15"><i class="fa fa-arrow-down"></i> Load more result</a>
    </div>
<?php endif; ?>
<?php
if ($i == 0):
    ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i> 
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
    <script>
        $(function () {
            $('.dashboard-item-result').html('');
        });
    </script>
    <?php
else:
    $filter_array = isset($load_type) ? array_count_values(array_column($result, 'filter_value')) : [];
    ?>
    <script>
        $(function () {
    <?php foreach ($filter_array as $key => $value): ?>
                $('span.filter-<?= $key; ?>').html('<?= $value != '' ? $value : 0; ?>');
    <?php endforeach; ?>
            $('.dashboard-item-result').html('<?= isset($page_number) ? ((($page_number * 20) > count($result)) ? count($result):($page_number * 20) ) : ""; ?> Results found of <?= isset($page_number) ? count($result) : "" ; ?>');
            $('[data-toggle="tooltip"]').tooltip();
            <?php if(isset($page_number) && $row_number == count($result)): ?>
                $('.load-more-btn').remove();
            <?php endif; ?>
        });
    </script>
<?php endif; ?>