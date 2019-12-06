<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_create_invoice" onsubmit="saveInvoice(); return false;">
                        <div class="form-group">
                            <label class="col-lg-2 control-label" style="font: 24px;">Invoice Type<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <?php if($is_recurrence == 'y'){ ?>
                                <select class="form-control" onchange="invoiceContainerAjax(this.value, <?= $reference_id; ?>, '','y');" name="invoice_type" id="invoice_type" title="Invoice Type" required="">
                                    <option value="1" <?= (isset($client_type) && $client_type == '1') ? 'selected' : ''; ?>>Business Client</option>
                                    <option value="2" <?= (isset($client_type) && $client_type == '2') ? 'selected' : ''; ?>>Individual</option>
                                </select>

                                 <?php } else{ ?>

                                    <select class="form-control" onchange="invoiceContainerAjax(this.value, <?= $reference_id; ?>, '','');" name="invoice_type" id="invoice_type" title="Invoice Type" required="">
                                    <option value="1" <?= (isset($client_type) && $client_type == '1') ? 'selected' : ''; ?>>Business Client</option>
                                    <option value="2" <?= (isset($client_type) && $client_type == '2') ? 'selected' : ''; ?>>Individual</option>
                                </select>
                            <?php } ?>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div id="invoice_container">
                            <!-- Add multiple service categories inside this div using ajax -->
                        </div>
                        <div id="base_price_div" style="display: none;">
                            <div class="alert alert-success">
                                <h3><i class="fa fa-money"></i> Total Price: $<span id="total_price"></span></h3>
                            </div>
                        </div>
                        <h3>Notes</h3>
                        <?= service_note_func('Invoice Notes', 'n', 'invoice'); ?>

                        <?php if($is_recurrence == 'y'){ ?>
                        <hr class="hr-line-dashed"/>
                        <h3>Recurring Invoice :</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <h4><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#RecurranceModal" title="Add Recurrence"><i class="fa fa-refresh"></i></button> &nbsp;<b id="pattern_show"></b>

                                </h4>
                                <div class="errorMessage text-danger" id="err_generation"></div>
                            </div><!-- ./col-md-12 -->
                            <!-- <div id="RecurranceModalContainer" style="display: none;"></div> -->
                            <!-- Recurrence Modal -->
                            <div id="RecurranceModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h2 class="modal-title">Recurrence</h2>
                                        </div><!-- modal-header -->
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Start Date:</label>
                                                        <input placeholder="mm/dd/yyyy" id="start_date" class="form-control datepicker_mdy_due" type="text" title="Start Date" name="recurrence[start_date]">
                                                        <div class="errorMessage text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Pattern:</label>
                                                        <select class="form-control" id="pattern" name="recurrence[pattern]" onchange="change_invoice_pattern(this.value);">
                                                            <option value="">Select Pattern</option>
                                                            <option value="monthly">Monthly</option>
                                                            <option value="weekly">Weekly</option>
                                                            <option value="quarterly">Quarterly</option>
                                                            <option value="annually">Annually</option>
                                                            <!--<option value="none">None</option>-->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Generation:</label>
                                                        <div class="form-inline due-div">
                                                            <label class="control-label m-r-5"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> New invoice on day</label>&nbsp;
                                                            <input class="form-control m-r-5" type="number" name="recurrence[due_day]" value="1" min="1" max="31" style="width: 100px" id="r_day">
                                                            <label class="control-label m-r-5">of every</label>&nbsp;
                                                            <input class="form-control m-r-5" type="number" name="recurrence[due_month]" value="1" min="1" max="12" style="width: 100px" id="r_month">&nbsp;
                                                            <label class="control-label m-r-5" id="control-label">month(s)</label>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div><!-- ./row -->
                                            <div class="row">
                                                <label class="control-label p-l-15">Duration:</label>
                                                <div class="col-md-12">
                                                    <label class="control-label"><input type="radio" name="recurrence[duration_type]" value="0">&nbsp; Never</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-inline">
                                                        <label class="control-label"><input type="radio" name="recurrence[duration_type]" value="1" checked onclick="//check_generation_type(this.value)"></label>&nbsp;
                                                        <label class="control-label">After</label>&nbsp;
                                                        <input class="form-control" type="text" id="duration_time" name="recurrence[duration_time]" style="width: 100px">&nbsp;
                                                        <label class="control-label">generations</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-inline">
                                                        <label class="control-label"><input type="radio" name="recurrence[duration_type]" value="2"></label>&nbsp;
                                                        <label class="control-label">Until date</label>&nbsp;
                                                        <input placeholder="mm/dd/yyyy" id="until_date" class="form-control datepicker_mdy_due" type="text" title="Start Date" name="recurrence[until_date]" style="width: 100px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- ./modal-body -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="closeInvoiceRecurrenceModal();">Ok</button>
                                        </div><!-- modal-footer -->
                                    </div><!-- Modal content-->

                                </div><!-- ./modal-dialog -->
                            </div><!-- ./Recurrence Modal -->
                        </div>
                        <?php } ?>

                        <div class="hr-line-dashed"></div>
                        <h3>Confirmation</h3>
                        <div class="form-group" style="display: none;">
                            <label class="col-lg-2 control-label">Create order</label>
                            <div class="col-lg-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"  name="is_create_order" checked="" title="Create order" id="is_create_order" value="yes">  Check if you want to create an order with this invoice
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirm<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"  name="confirmation" title="Confirmation" id="confirmation" value="" required>  I confirm to be aware that the information added above is correct.
                                    </label>
                                </div>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="company_id" id="company_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="client_id" id="client_id" value="<?= (isset($client_id)) ? $client_id : ''; ?>">
                                <input type="hidden" name="editval" id="editval" value="">
                                <input type="hidden" name="recurring" id="recurring" value="<?= (isset($is_recurrence)) ? $is_recurrence : ''; ?>">
                                <button class="btn btn-success" type="button" onclick="saveInvoice()">Place</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelInvoice()">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="accounts-form" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script>
    $(function () {
        $(".datepicker_mdy_due").datepicker({format: 'mm/dd/yyyy', autoHide: true, startDate: new Date()});
    });
<?php if ($client_id != ''){ ?>
        invoiceContainerAjax(<?= $client_type ?>, <?= $reference_id; ?>, '','');
<?php } else if($is_recurrence != ''){ ?>
        invoiceContainerAjax(1, <?= $reference_id; ?>, '','y');
<?php }else{ ?>
        invoiceContainerAjax(1, <?= $reference_id; ?>, '','');
<?php } ?>
</script>
