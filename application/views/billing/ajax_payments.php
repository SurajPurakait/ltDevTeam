<h2 class="text-primary dashboard-item-result"></h2>
<?php
$user_id = sess('user_id');
$user_info = staff_info();
$user_dept = $user_info['department'];
$usertype = $user_info['type'];
$status = [
    1 => 'Not Paid',
    2 => 'Partial',
    3 => 'Paid',
    4 => 'Completed'
];

$i = 0;
foreach ($result as $value):
    $row = (object) $value;
    $service_list = billing_services($row->invoice_id);
    $payment_status = $row->payment_status;
    $totel_price = array_sum(array_column($service_list, 'override_price'));
    
    $tracking_class = 'label-success';
        if($payment_status == 1){
            $tracking_class = 'label-danger';
        }elseif($payment_status == 2){
            $tracking_class = 'label-yellow';
        }elseif($payment_status == 3){
            $tracking_class = 'label-primary';
        }
    if ($filter_status != ''):
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
            <?php if (in_array(3, explode(',', $user_dept)) && $payment_status != 4): ?>
                <a href="javascript:void(0);" onclick="changePaymentStatus(<?= $row->invoice_id; ?>);" class="btn btn-primary btn-xs btn-service-edit "><i class="fa fa-check" aria-hidden="true"></i> Complete</a>
            <?php endif; ?>
            <a href="<?= base_url() . 'billing/payments/details/' . base64_encode($row->invoice_id); ?>" class="btn-show-details"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $row->invoice_id; ?>" aria-expanded="false" class="collapsed">
                <div class="table-responsive">
                    <table class="table table-borderless text-center" style="margin-bottom: 0px;">
                        <tr>
                            <th class="text-center" width="10%">Invoice#</th>
                            <th class="text-center" width="15%">Client Name</th>
                            <th class="text-center" width="10%">Tracking</th>
                            <th class="text-center" width="10%">Create Time</th>
                            <th class="text-center" width="10%">Office ID</th>
                            <th class="text-center" width="5%">Services</th>
                            <th class="text-center" width="10%">Total$$$</th>
                            <th class="text-center" width="10%">Paid$$$</th>
                            <th class="text-center" width="10%">Due$$$</th>
                            <th class="text-center" width="10%">Requested by</th>
                        </tr>
                        <tr>
                            <td title="ID">#<?= $row->invoice_id; ?></td>
                            <td title="Client Name" style="word-break: break-all;"><?= ($row->invoice_type == 1) ? $row->name_of_company : $row->individual_name; ?></td>
                            <td title="Tracking"><a href="javascript:void(0);"><span class="label <?= $tracking_class ?>"><b><?= $status[$payment_status]; ?></b></span></a></td>
                            <td title="Create Time"><?= date('m/d/Y', strtotime($row->created_time)); ?></td>
                            <td title="Office"><?= $row->office; ?></td>
                            <td align="center" title="Services"><span class="label label-warning"><b><?= count($service_list); ?></b></span></td>
                            <td title="Total Amount">$<?= $total_price; ?></td>
                            <td title="Paid Amount">$<?= $total_payble_amount; ?></td>
                            <td title="Due Amount">$<?= $due_amount; ?></td>
                            <td title="Requested by"><?= $row->created_by; ?></td>
                        </tr>
                    </table>
                </div>
            </h5>
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
                            <th class="text-center">Refund</th>
                            <th class="text-center">Notes</th>
                        </tr>
                        <?php
//                            print_r($service_list);
                        if (!empty($service_list)):
                            foreach ($service_list as $row_inner):
                                $order_id = $row_inner['order_id'];
                                $service_id = $row_inner['service_id'];
                                $row_inner = (object) $row_inner;
                                $note_list = invoice_notes($order_id, $service_id);
                                $service_payble_amount = total_payble_amount($row_inner->order_id)['pay_amount'];
                                $service_refund_amount = total_refund_amount($row_inner->order_id)['pay_amount'];
                                $service_total_amount = $row_inner->override_price * $row_inner->quantity;
                                ?>
                                <tr>
                                    <td title="ID">#<?= $row_inner->order_id; ?></td>
                                    <td title="Category"><?= $row_inner->service_category; ?></td>
                                    <td title="Service Name"><?= $row_inner->service; ?></td>
                                    <td title="Retail Price">$<?= number_format((float) $row_inner->retail_price, 2, '.', ''); ?></td>
                                    <td title="Override Price">$<?= number_format((float) $row_inner->override_price, 2, '.', ''); ?></td>
                                    <td title="Quantity"><?= $row_inner->quantity; ?></td>
                                    <td title="Total">$<?= number_format((float) $service_total_amount, 2, '.', ''); ?></td>
                                    <td title="Received">$<?= number_format((float) $service_payble_amount, 2, '.', ''); ?></td>
                                    <td title="Due">$<?= number_format((float) $service_total_amount - $service_payble_amount, 2, '.', ''); ?></td>
                                    <td title="Refund">$<?= number_format((float) $service_refund_amount, 2, '.', ''); ?></td>
                                    <td title="Notes"><span><a class="label label-warning" href="javascript:void(0)" <?= (count($note_list) != 0) ? 'onclick="billingDashboardNoteModal(' . $order_id . ',' . $service_id . ')"' : ''; ?>><b><?= count($note_list); ?></b></a></span></td>
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
    <?php
    $i++;
endforeach;
if ($i == 0):
    ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i> 
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
<?php else: ?>
    <script>
        $(function () {
            $('.dashboard-item-result').html('<?= $i; ?> Results found');
        });
    </script>
<?php endif; ?>