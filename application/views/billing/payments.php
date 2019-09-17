<style type="text/css">
    .service-requests {
        width: 100%;
    }

    .service-requests tr th,
    .service-requests tr td {
        padding: 8px;
    }

    .service-mother {
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .service-mother.has-child {
        cursor: pointer;
    }

    .service-child {
        background: #fff;
        border-bottom: 1px solid #ddd;
    }

    .label-block {
        display: block;
        padding: 5px 8px;
    }
</style>
<?php
$staff_info = staff_info();
$staff_department = explode(',', $staff_info['department']);
$stafftype = $staff_info['type'];
$staffrole = $staff_info['role'];
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">                
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1><br>Dashboard for Payments</h1>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless" style="border-collapse: separate;">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <th class="text-center">Not Paid</th>
                                            <th class="text-center">Partial</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Payment by me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-1" onclick="loadPayments('payment', 'byme', '', 1)">
                                                    <span class="label label-warning">
                                                        <?= payment_history('payment', 'byme', '', 1); ?>
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2" onclick="loadPayments('payment', 'byme', '', 2)">
                                                    <span class="label label-warning">
                                                        <?= payment_history('payment', 'byme', '', 2); ?>
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-3" onclick="loadPayments('payment', 'byme', '', 3)">
                                                    <span class="label label-warning">
                                                        <?= payment_history('payment', 'byme', '', 3); ?>
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-4" onclick="loadPayments('payment', 'byme', '', 4)">
                                                    <span class="label label-warning">
                                                        <?= payment_history('payment', 'byme', '', 4); ?>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php if ($stafftype == 1 || $stafftype == 2 || ($stafftype == 3 && $staffrole == 2)) { ?>
                                            <tr>
                                                <th>Payment by others</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-tome-1" onclick="loadPayments('payment', 'tome', '', 1)">
                                                        <span class="label label-warning">
                                                            <?= payment_history('payment', 'tome', '', 1); ?>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-tome-2" onclick="loadPayments('payment', 'tome', '', 2)">
                                                        <span class="label label-warning">
                                                            <?= payment_history('payment', 'tome', '', 2); ?>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-tome-3" onclick="loadPayments('payment', 'tome', '', 3)">
                                                        <span class="label label-warning">
                                                            <?= payment_history('payment', 'tome', '', 3); ?>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-tome-4" onclick="loadPayments('payment', 'tome', '', 4)">
                                                        <span class="label label-warning">
                                                            <?= payment_history('payment', 'tome', '', 4); ?>
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-line-dashed">
                    <?php if (count(payment_history('', '', ''))): ?>
                        <div class="form-group new-form clearfix">
                            <div class="col-md-4">
                                <select class="form-control m-b-10" id="filter_office" onchange="loadPayments('payment', '', this.value, document.getElementById('filter_tracking').value);">
                                    <option value="">Select an Office</option>   
                                    <?php foreach ($staff_office as $so) { ?>
                                        <option <?= $office_id == $so['id'] ? "selected='selected'" : ""; ?> value="<?= $so['id']; ?>"><?= $so['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control status-dropdown m-b-10" id="filter_tracking" onchange="loadPayments('payment', '', document.getElementById('filter_office').value, this.value);">
                                    <option value="">All Tracking Descriptions</option>'; ?>
                                    <option <?= $payment_status == '1' ? "selected='selected'" : ''; ?> value="1">Not Paid</option>
                                    <option <?= $payment_status == '2' ? "selected='selected'" : ''; ?> value="2">Partial</option>
                                    <option <?= $payment_status == '3' ? "selected='selected'" : ''; ?> value="3">Paid</option>
                                    <option <?= $payment_status == '4' ? "selected='selected'" : ''; ?> value="4">Completed</option>     
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="add_payment text-right m-b-10">
                                    <a href="" title="Add New Payment" class="btn btn-primary"><i class="fa fa-plus"></i> New Payment</a>                                   
                                </div>
                            </div>
                        </div>
                        <hr class="hr-line-dashed">
                        <div class="ajaxdiv" id="payments_div"></div>
                    <?php else: ?>
                        <div class="text-center m-t-30">
                            <div class="alert alert-danger">
                                <i class="fa fa-times-circle-o fa-4x"></i> 
                                <h3><strong>Sorry !</strong> no data found</h3>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="dept" value="<?= $staff_info['department']; ?>">
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
<div id="change_status_billing_div" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal
         content-->
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
                                <input type="radio" name="radio" id="rad1" value="1"/>
                                <label for="rad1"><strong>Not Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2" value="2"/>
                                <label for="rad2"><strong>Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad3" value="3"/>
                                <label for="rad3"><strong>Completed</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="invoice_id" value="">
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateStatusBilling()">Save changes</button>
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
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    loadPayments('payment', '', '<?= $office_id; ?>', '<?= $payment_status; ?>');
</script>