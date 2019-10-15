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
            $payment_status_array = [
                1 => 'Unpaid',
                2 => 'Partial',
                3 => 'Paid',
                4 => 'Late'
            ];
            if (!empty($service_list)):
                foreach ($service_list as $key => $row_inner):
                    $order_id = $row_inner['order_id'];
                    $service_id = $row_inner['service_id'];
                    $row_inner = (object) $row_inner;
                    $note_list = invoice_notes($order_id, $service_id);
                    $service_payble_amount = total_payble_amount($row_inner->order_id)['pay_amount'];
                    $service_refund_amount = total_refund_amount($row_inner->order_id)['pay_amount'];
                    $service_total_amount = $row_inner->override_price * $row_inner->quantity;
                    $row_inner_status = ($service_total_amount != 0) ? invoice_service_payment_status($invoice_id, $service_id, $service_total_amount) : 3;
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
                        <td title="ID"><?= $invoice_id . '-' . ($key + 1); ?></td>
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