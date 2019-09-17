<?php
// echo '<pre>';print_r($payment_details);echo '</pre>'; 
$payment_status = invoice_payment_status($payment_details['invoice_id']);
$invoice_notes = invoice_notes($payment_details['invoice_id'], '');
if ($payment_details['due_amount'] != 0) {
    $full_payment_onclick = "open_payment_modal('add', " . $payment_details['invoice_id'] . ", 'all', 'all'," . $payment_details['due_amount'] . ", '');";
} else {
    $full_payment_onclick = 'swal(\'Can not pay!\', \'Your payment already completed!\', \'error\');';
}
?>
<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md">
        <div class="invoice-payments">
            <div class="row">
                <div class="col-md-6">
                    <p><b>INVOICE #</b> <?= $payment_details['invoice_id'] ?></p>
                    <p><b>DATE :</b><?= date('m/d/Y', strtotime($payment_details['created_time'])) ?></p>
                </div>
                <div class="col-md-6">
                    <div class="client-details">
                        <h3><?= $payment_details["invoice_type_id"] == 1 ? $payment_details["name_of_company"] : $payment_details["individual_name"]; ?></h3>
                        <p><?= $payment_details['office'] . ", " . $payment_details['invoice_type']; ?></p>
                        <p><b>Requested by :</b> <?= staff_info_by_id($payment_details['created_by'])['full_name']; ?></p>
                    </div>
                </div>
            </div>                
            <hr/>
            <div class="pricing-overview">
                <div class="row">
                    <div class="col-md-2">
                        <h5>Total Amount</h5>
                        <p>$<?= $payment_details['total_price']; ?></p>
                    </div>
                    <div class="col-md-2">
                        <h5>Amount Received</h5>
                        <p><?= ($payment_details['total_pay_amount'] != '') ? '$' . $payment_details['total_pay_amount'] : 'N/A'; ?></p>
                    </div>
                    <div class="col-md-2">
                        <h5>Due Amount</h5>
                        <p>$<?= number_format((float) $payment_details['due_amount'], 2, '.', ''); ?></p>
                    </div>
                    <div class="col-md-2">
                        <?php /* if ($payment_status == 3 && $payment_details['is_refund'] == '0'): ?>
                          <a href="javascript:void(0);" onclick="refundAll(<?= $payment_details['invoice_id']; ?>);" class="btn btn-info btn-xs pull-right"><i class="fa fa-minus-circle"></i> Refund All</a>
                          <?php endif; */ ?>
                        <h5>Total Refund</h5>
                        <p>
                            <?php
                            if ($payment_details['is_refund'] == '0'):
                                echo ($payment_details['total_refund'] != '') ? '$' . $payment_details['total_refund'] : 'N/A';
                            else:
                                echo $payment_details['total_price'];
                            endif;
                            ?>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <h5>Invoice Notes</h5>
                        <p class="pull-left"><a href="javascript:void(0);" title="Invoice Notes" <?= (count($invoice_notes) != 0) ? 'onclick="billingDashboardNoteModal(' . $payment_details['invoice_id'] . ', \'\')"' : ''; ?> class="btn btn-info btn-xs pull-right"><?= count($invoice_notes) ?></a></p>
                    </div>
                    <div class="col-md-2">
                        <h5></h5>
                        <a href="javascript:void(0);" title="Add full payment" onclick="<?= $full_payment_onclick; ?>" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus"></i> Full Payment</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <?php
                        $colors = array('bg-light-blue', 'bg-light-green', 'bg-light-red', 'bg-light-orange', 'bg-light-purple', 'bg-light-aqua');
                        foreach ($payment_details['services'] as $service) {
                            $random_keys = array_rand($colors);
                            $payment_history = get_payment_history($payment_details['invoice_id'], $service['service_id'], $service['order_id']);
                            $service_payble = get_total_payble_amount($service['order_id']);
                            $due_service_amount = ($service['override_price'] * $service['quantity'] ) - $service_payble['pay_amount'];
                            if ($due_service_amount != 0) {
                                $onclick = "open_payment_modal('add', " . $payment_details['invoice_id'] . "," . $service['service_id'] . "," . $service['order_id'] . "," . $due_service_amount . ", '');";
                            } else {
                                $onclick = 'swal(\'Can not pay!\', \'Your payment already completed!\', \'error\');';
                            }
                            $payble_amount = $service['sub_total'];
                            $note_list = invoice_notes($service['order_id'], $service['service_id']);
                            ?>
                            <br><div class="well table-responsive <?php echo $colors[$random_keys]; ?>">
                                <table class="table table-striped table-bordered m-b-0">
                                    <thead>
                                        <tr>
                                            <th class="text-right">Service#</th>
                                            <th class="text-right">Category</th>
                                            <th class="text-right">Service Name</th>
                                            <th class="text-right">Retail Price</th>
                                            <th class="text-right">Override Price</th>
                                            <th class="text-right">Quantity</th>
                                            <th class="text-right">Payble Amount</th>
                                            <th class="text-right">Received</th>
                                            <th class="text-right">Due</th>
                                            <th class="text-right">Refund</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="well <?= $colors[$random_keys]; ?>">
                                            <td class="text-right">#<?= $service['service_id']; ?></td>
                                            <td class="text-right"><?= $service['service_category']; ?></td>
                                            <td class="text-right"><?= $service['service']; ?></td>
                                            <td class="text-right">$<?= $service['retail_price']; ?></td>
                                            <td class="text-right">$<?= $service['override_price']; ?></td>
                                            <td class="text-right"><?= $service['quantity']; ?></td>
                                            <td class="text-right">$<?= number_format((float) $payble_amount, 2, '.', ''); ?></td>
                                            <td class="text-right"><?= ($service_payble['pay_amount'] != '') ? '$' . number_format((float) $service_payble['pay_amount'], 2, '.', '') : 'N/A'; ?></td>
                                            <td class="text-right">$<?= number_format((float) $due_service_amount, 2, '.', ''); ?></td>
                                            <td class="text-right"><?= ($service['refund_amount'] != '') ? '$' . number_format((float) $service['refund_amount'], 2, '.', '') : 'N/A'; ?></td>
                                            <td title="Notes"><span><a class="label label-warning" href="javascript:void(0)" <?= (count($note_list) != 0) ? 'onclick="billingDashboardNoteModal(' . $service['order_id'] . ',' . $service['service_id'] . ')"' : ''; ?>><b><?= count($note_list); ?></b></a></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="11">
                                                <h4 class="text-primary m-l-20 m-t-15">                                                
                                                    <a href="javascript:void(0);" onclick="<?= $onclick; ?>" class="btn btn-<?= $due_service_amount != 0 ? 'success' : 'danger'; ?> btn-xs pull-right m-r-20"><i class="fa fa-plus"></i> Payment</a>
                                                    <a href="javascript:void(0);" onclick="open_refund_modal('add',<?= $payment_details['invoice_id']; ?>,<?= $service['service_id']; ?>,<?= $service['order_id']; ?>, <?= $payble_amount; ?>, '');" class="btn btn-warning btn-xs pull-right m-r-20"><i class="fa fa-minus-circle"></i> Refund</a>
                                                    Payment History
                                                </h4>
                                                <div class="payment-history">
                                                    <table class="well table table-bordered m-b-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-right">Date</th>
                                                                <th class="text-right">Type</th>
                                                                <th class="text-right">Reference/Authorized By</th>
                                                                <th class="text-right">Amount Paid</th>
                                                                <th class="text-right">Check Number</th>
                                                                <th class="text-right">Authorization ID</th>
                                                                <th class="text-right" style="width: 80px;">Balance</th>
                                                                <th class="text-right">Notes</th>
                                                                <th class="text-right">Files</th>
                                                                <th class="text-right">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        foreach ($payment_history as $ind => $val) {
                                                            $deu_payment_amount = 0;
                                                            $payment_type = get_payment_history_type($val['payment_type']);
                                                            if ($val['is_cancel'] == 0) {
                                                                if ($ind == 0) {
                                                                    $deu_payment_amount = $payble_amount - $val['pay_amount'];
                                                                } else {
                                                                    $pay_amount = 0;
                                                                    for ($i = 0; $i <= $ind; $i++) {
                                                                        if ($payment_history[$i]['is_cancel'] == 0) {
                                                                            $pay_amount += $payment_history[$i]['pay_amount'];
                                                                        }
                                                                    }
                                                                    $deu_payment_amount = $payble_amount - $pay_amount;
                                                                }
                                                            }
                                                            ?>
                                                            <tbody>
                                                                <tr class="text-right <?= ($val['type'] == 'payment' && $val['is_cancel'] != 0) ? 'bg-light-red' : ''; ?> <?= ($val['type'] == 'refund') ? 'bg-light-orange' : ''; ?>">
                                                                    <td><?= date('m/d/Y', strtotime($val['date'])); ?></td>
                                                                    <td><?= $payment_type; ?></td>
                                                                    <td><?= $val['reference_no']; ?></td>                                                                    
                                                                    <td><?= number_format((float) $val['pay_amount'], 2, '.', ''); ?></td>
                                                                    <td><?= $val['check_number'] != '' ? $val['check_number'] : "N/A"; ?></td>
                                                                    <td><?= $val['authorization_id'] != '' ? $val['authorization_id'] : "N/A"; ?></td>
                                                                    <td><?= $val['is_cancel'] == 0 ? number_format((float) $deu_payment_amount, 2, '.', '') : 'N/A'; ?></td>                                                                    
                                                                    <td>
                                                                        <?php if ($val['note'] != ''): ?>
                                                                            <input type="hidden" id="note_hidden_<?= $val['id']; ?>" value="<?= $val['note']; ?>">
                                                                            <a class="label label-warning" href="javascript:void(0)" onclick="paymentDashboardNoteModal(<?= $val['id']; ?>)"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                                            <?php
                                                                        else:
                                                                            echo 'N/A';
                                                                        endif;
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($val['attachment'] != ''): ?>
                                                                            <input type="hidden" id="file_hidden_<?= $val['id']; ?>" value="<?= $val['attachment']; ?>">
                                                                            <a title="Note" class="label label-<?= $val['attachment'] != '' ? 'warning"' : 'danger'; ?>" href="<?= $val['attachment'] != '' ? base_url('uploads/' . $val['attachment']) : 'javascript:void(0);'; ?>" <?= $val['attachment'] != '' ? 'target="_blank"' : ''; ?>><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                                                            <?php
                                                                        else:
                                                                            echo 'N/A';
                                                                        endif;
                                                                        ?>
                                                                    </td>
                                                                    <?php
                                                                    if ($val['type'] == 'payment'):
                                                                        if ($val['is_cancel'] == 0):
                                                                            ?>
                                                                            <td><a title="Attachment" class='text-danger show m-t-5 p-5' href="javascript:void(0)" onclick="cancelPayment(<?= $val['id'] . ',' . $payment_details['invoice_id']; ?>)"><i class='fa fa-times-circle'></i> Cancel</a></td>
                                                                        <?php else: ?>
                                                                            <td>Canceled</td>
                                                                        <?php
                                                                        endif;
                                                                    else:
                                                                        ?>
                                                                        <td>Refunded</td>
                                                                    <?php
                                                                    endif;
                                                                    ?>
                                                                </tr>
                                                            </tbody>
                                                            <?php
                                                        }
                                                        ?>  
                                                    </table>
                                                </div>
                                            </td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
<div class="modal fade" id="addRefund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

<div class="modal fade" id="showPaymentNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <div class="modal-body form-horizontal" id="note-body"></div>
            <div class="modal-footer">                    
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="showPaymentFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Image Preview</h4>
            </div>
            <div class="modal-body" id="image_preview"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <div class="modal-body form-horizontal" id="note-body-div"></div>
            <div class="modal-footer">                    
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>