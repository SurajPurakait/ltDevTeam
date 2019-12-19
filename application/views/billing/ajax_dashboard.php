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
    if (isset($page_number)) {
        if ($page_number != 1) {
            if ($row_count < (($page_number - 1) * 20)) {
                continue;
            }
        }
        if ($row_count == ($page_number * 20)) {
            break;
        }
    }
    $row = (object) $value;
    
    $status_class = 'label-yellow';
    if ($row->payment_status == 1) {
        $status_class = 'label-yellow';
    } elseif ($row->payment_status == 2) {
        $status_class = 'label-success';
    } elseif ($row->payment_status == 3) {
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
    $is_recurrence=$value->is_recurrence;
    ?>
    <div class="panel panel-default service-panel">
        <div class="panel-heading" style="padding-right: 0px">
            <a href="<?= base_url("billing/invoice/place/" . base64_encode($row->invoice_id) . "/" . base64_encode('view')); ?>" target="_blank" class="btn btn-primary btn-xs btn-service-lead"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
            <a href="<?= base_url("billing/invoice/details/" . base64_encode($row->invoice_id)); ?>" target="_blank" class="btn btn-primary btn-xs btn-service-lead"><i class="fa fa-dollar" aria-hidden="true"></i> Invoice</a>
            <?php if ($row->invoice_status == 1 && ($usertype == 1 || in_array(14, explode(',', $user_dept)) || in_array(3, explode(',', $user_dept)) || $row->created_by == sess('user_id'))) { ?>
                <a href="<?= (($row->is_order == 'y' && $row->order_id != 0) || ($row->is_order == 'n' && $row->order_id == 0)) ? base_url("billing/invoice/edit/" . base64_encode($row->invoice_id)) : (edit_order_link($row->order_id) != '' ? base_url() . edit_order_link($row->order_id) : base_url("billing/invoice/edit/" . base64_encode($row->invoice_id))); ?>" target="_blank" class="btn btn-primary btn-xs btn-service-lead"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
            <?php } ?>
            <a href="<?= base_url() . 'billing/payments/details/' . base64_encode($row->invoice_id); ?>" target="_blank" class="btn-show-details"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            <a class="panel-title" style="cursor: default;" data-toggle="collapse" onclick="invoiceServiceListAjax('<?= $row->invoice_id ?>');" data-parent="#accordion" href="#collapse<?= $row->invoice_id; ?>" aria-expanded="false" class="collapsed">
                <div class="table-responsive">
                    <table class="table table-borderless text-center m-t-15" style="margin-bottom: 0px;">
                        <tr>
                            <th class="text-center" width="5%">Order&nbsp;ID#</th>
                            <th class="text-center" width="15%">Client&nbsp;Name</th>
                            <th class="text-center" width="5%">Office&nbsp;ID</th>
                            <?php 
                            if($is_recurrence == 'y') { ?>                           
                            <!--<th class="text-center" width="5%">Pattern</th>-->
                            <th class="text-center" width="5%">Next&nbsp;Generation&nbsp;Date</th>
                            <?php } else{ ?>
                            <th class="text-center" width="5%">Partner</th>
                            <th class="text-center" width="5%">Manager</th>
                            <?php } ?>
                            <th class="text-center" width="10%">Tracking</th>
                            <th class="text-center" width="10%">Requested&nbsp;by</th>
                            <th class="text-center" width="10%">Created&nbsp;Date</th>
                            <th class="text-center" width="5%">Due Date</th>
                            <?php if($is_recurrence == 'y') { ?>                           
                            <th class="text-center" width="5%">Pattern</th>
                            <?php } ?>
                            <th class="text-center" width="5%">Services</th>
                            <th class="text-center" width="5%">Total</th>
                            <th class="text-center" width="5%">Status</th>
                        </tr>
                        <tr>
                            <td title="ID"><a href="<?= base_url("billing/invoice/details/" . base64_encode($row->invoice_id)); ?>">#<?= $row->invoice_id; ?></a></td><td title="Client Name" style="word-break: break-all;"><?= ($row->invoice_type == 1) ? $row->client_name : $row->client_name; ?></td>
                            <?php if($is_recurrence == 'y'){?>
                            <td title="Office"><?='<b>'. $row->officeid .'</b>'; ?><?= "<br>". $row->manager; ?></td>
                            <?php } else{ ?>
                            <td title="Office"><?= $row->officeid ; ?></td>
                            <?php } ?>
                            <?php if($is_recurrence == 'y'){?>
                            <!--<td title="Pattern"><//?= $row->pattern; ?></td>-->
                            <td title="Next Generation Date"><?= $row->next_generation_date; ?></td>
                            <?php } else { ?>
                            <td title="Partner"><?= $row->partner; ?></td>
                            <td title="Manager"><?= $row->manager; ?></td>
                            <?php } ?>
                            <td title="Tracking"><a href="javascript:void(0)" onclick="billingDashboardTrackingModal(<?= $row->invoice_id; ?>, <?= $row->invoice_status; ?>);"><span class="label <?= $tracking_class ?> invoice-tracking-span-<?= $row->invoice_id; ?>"><b><?= $tracking[$row->invoice_status]; ?></b></span></a></td>
                            <td title="Requested by"><?= $row->created_by_name; ?></td>
                            <td title="Create Time"><?= date('m/d/Y', strtotime($row->created_time)); ?></td>
                            <td title="Create Time"><?= date('m/d/Y', strtotime('+30 days', strtotime($row->created_time))); ?></td>  
                            <?php if($is_recurrence == 'y'){?>
                            <td title="Pattern"><?= $row->pattern; ?></td>                          
                            <?php } ?>
                            <td align="center" title="Services"><span class="label label-success"><b><?= (substr_count($row->all_services, ',') - 1); ?></b></span></td>
                            <td title="Total Amount">$<?= $row->sub_total; ?></td>
                            <td title="Payment status"><a href="javascript:void(0);"><span class="label <?= $status_class ?>"><b><?= $payment_status_array[$row->payment_status]; ?></b></span></a></td>
                        </tr>
                    </table>
                </div>
            </a>
        </div>
        <div id="collapse<?= $row->invoice_id; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;"></div>
    </div>
    <?php if (isset($reference_id) && $reference_id != ''): ?>
        <h3 class="pull-right alert alert-warning"><i class="fa fa-warning"></i> Total Due: $<?= number_format((float) array_sum(array_column($result, 'sub_total')) - array_sum(array_column($result, 'pay_amount')), 2, '.', ''); ?></h3>
        <?php
    endif;
    $row_number = $row_count + 1;
endforeach;
if (isset($page_number) && $row_number < count($result)):
    ?>
    <div class="text-center p-0 load-more-btn">
        <a href="javascript:void(0);" onclick="loadBillingDashboard('', '', '', '', 'on_load', <?= $page_number + 1; ?>);" class="btn btn-success btn-sm m-t-30 p-l-15 p-r-15"><i class="fa fa-arrow-down"></i> Load more result</a>
    </div>
<?php endif; ?>
<?php
if ($row_number == 0):
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
            $('.dashboard-item-result').html('<?= isset($page_number) ? ((($page_number * 20) > count($result)) ? count($result) : ($page_number * 20) ) : ""; ?> Results found of <?= count($result); ?>');
                    $('[data-toggle="tooltip"]').tooltip();
    <?php if (isset($page_number) && $row_number == count($result)): ?>
                        $('.load-more-btn').remove();
    <?php endif; ?>
                });
    </script>
<?php endif; ?>