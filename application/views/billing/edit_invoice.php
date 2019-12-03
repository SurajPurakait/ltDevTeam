<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_create_invoice" onsubmit="saveInvoice(); return false;">
                        <div class="form-group">
                            <label class="col-lg-2 control-label" style="font: 24px;">Invoice Type<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select disabled="" class="form-control disabled_field" onchange="invoiceContainerAjax(this.value, <?= $reference_id; ?>, '');" name="invoice_type" id="invoice_type" title="Invoice Type" required="">
                                    <option <?= $order_summary['invoice_type'] == 1 ? 'selected=\'selected\'' : ''; ?> value="1">Business Client</option>
                                    <option <?= $order_summary['invoice_type'] == 2 ? 'selected=\'selected\'' : ''; ?> value="2">Individual</option>
                                </select>
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
                        <?= service_note_func('Invoice Notes', 'n', 'invoice', $invoice_id); ?>
                        <div class="hr-line-dashed"></div>
                        <?php
                        $invoice_recurrence = get_invoice_recurring_details($invoice_id);
                        ?>
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
                                                        <input placeholder="mm/dd/yyyy" id="start_date" class="form-control datepicker_mdy_due" type="text" title="Start Date" name="recurrence[start_date]" value="<?= isset($invoice_recurrence->start_date)?($invoice_recurrence->start_date != '0000-00-00' ? date('m/d/Y', strtotime($invoice_recurrence->start_date)) : ''):''; ?>">
                                                        <div class="errorMessage text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Pattern:</label>
                                                        <select class="form-control" id="pattern" name="recurrence[pattern]" onchange="change_invoice_pattern(this.value);">
                                                            <option value="monthly" <?php echo isset($invoice_recurrence->pattern)?(($invoice_recurrence->pattern == 'monthly') ? 'selected' : ''):''; ?>>Monthly</option>     
                                                            <option value="weekly" <?php echo isset($invoice_recurrence->pattern)?(($invoice_recurrence->pattern == 'weekly') ? 'selected' : ''):''; ?>>Weekly</option>
                                                            <option value="quarterly" <?php echo isset($invoice_recurrence->pattern)?(($invoice_recurrence->pattern == 'quarterly') ? 'selected' : ''):''; ?>>Quarterly</option>
                                                            <option value="annually" <?php echo isset($invoice_recurrence->pattern)?(($invoice_recurrence->pattern == 'annually') ? 'selected' : ''):''; ?>>Annually</option>
                                                            <!--<option value="none" <?php // echo ($invoice_recurrence->pattern == 'none') ? 'selected' : '';  ?>>None</option>-->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Generation:</label>
                                                        <div class="form-inline due-div">
                                                            <?php
                                                            if (isset($invoice_recurrence->pattern) && $invoice_recurrence->pattern == 'annually') {
                                                                ?>
                                                                    <label class="control-label">
                                                                                        <input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due on every</label>&nbsp;<select class="form-control" id="r_month" name="recurrence[due_month]">
                                                                                        <option value="1" <?php echo ($invoice_recurrence->due_month == '1') ? 'selected' : ''; ?>>January</option>
                                                                                        <option value="2" <?php echo ($invoice_recurrence->due_month == '2') ? 'selected' : ''; ?>>February</option>
                                                                                        <option value="3" <?php echo ($invoice_recurrence->due_month == '3') ? 'selected' : ''; ?>>March</option>
                                                                                        <option value="4" <?php echo ($invoice_recurrence->due_month == '4') ? 'selected' : ''; ?>>April</option>
                                                                                        <option value="5" <?php echo ($invoice_recurrence->due_month == '5') ? 'selected' : ''; ?>>May</option>
                                                                                        <option value="6" <?php echo ($invoice_recurrence->due_month == '6') ? 'selected' : ''; ?>>June</option>
                                                                                        <option value="7" <?php echo ($invoice_recurrence->due_month == '7') ? 'selected' : ''; ?>>July</option>
                                                                                        <option value="8" <?php echo ($invoice_recurrence->due_month == '8') ? 'selected' : ''; ?>>August</option>
                                                                                        <option value="9" <?php echo ($invoice_recurrence->due_month == '9') ? 'selected' : ''; ?>>September</option>
                                                                                        <option value="10" <?php echo ($invoice_recurrence->due_month == '10') ? 'selected' : ''; ?>>October</option>
                                                                                        <option value="11" <?php echo ($invoice_recurrence->due_month == '11') ? 'selected' : ''; ?>>November</option>
                                                                                        <option value="12" <?php echo ($invoice_recurrence->due_month == '12') ? 'selected' : ''; ?>>December</option>
                                                                                    </select>&nbsp;
                                                                                    <input class="form-control" type="number" name="recurrence[due_day]" min="1" value="<?php echo $invoice_recurrence->due_day; ?>" max="31" style="width: 100px" id="r_day">
                                                                    <?php
                                                            }  elseif (isset($invoice_recurrence->pattern) && $invoice_recurrence->pattern == 'weekly') { ?>
                                                                <label class="control-label"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due every</label>&nbsp;
                                                                <input class="form-control" value="<?php echo $invoice_recurrence->due_day; ?>" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day">&nbsp;week(s) on the following days:&nbsp;
                                                                <div class="m-t-10">
                                                                    <div class="m-b-10">
                                                                        <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="1" <?php echo ($invoice_recurrence->due_month == '1') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Sunday&nbsp;</span>
                                                                        <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="2" <?php echo ($invoice_recurrence->due_month == '2') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Monday&nbsp;</span>
                                                                        <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="3" <?php echo ($invoice_recurrence->due_month == '3') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Tuesday&nbsp;</span>
                                                                        <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="4" <?php echo ($invoice_recurrence->due_month == '4') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Wednesday&nbsp;</span>
                                                                    </div>
                                                                    <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="5" <?php echo ($invoice_recurrence->due_month == '5') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Thursday&nbsp;</span>
                                                                    <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="6" <?php echo ($invoice_recurrence->due_month == '6') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Friday&nbsp;</span>
                                                                    <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="7" <?php echo ($invoice_recurrence->due_month == '7') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Saturday</span>
                                                                </div>
                                                            <?php } elseif (isset($invoice_recurrence->pattern) && $invoice_recurrence->pattern == 'quarterly') { ?>
                                                                <label class="control-label">
                                                                    <input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day" class="m-r-5"> Due on day</label>&nbsp;
                                                                <input class="form-control" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day" value="<?php echo $invoice_recurrence->due_day; ?>"><label class="control-label">of</label>&nbsp;
                                                                <select class="form-control" id="r_month" name="recurrence[due_month]">
                                                                    <option value="1" <?php echo ($invoice_recurrence->due_month == '1') ? 'selected' : ''; ?>>First</option>
                                                                    <option value="2" <?php echo ($invoice_recurrence->due_month == '2') ? 'selected' : ''; ?>>Second</option>
                                                                    <option value="3" <?php echo ($invoice_recurrence->due_month == '3') ? 'selected' : ''; ?>>Third</option>
                                                                </select>&nbsp;
                                                                <label class="control-label" id="control-label">month in quarter</label>
                                                                <?php } else { ?>
                                                                <label class="control-label"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due on day</label>&nbsp;
                                                                <input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day" value="<?php echo isset($invoice_recurrence->due_day) && $invoice_recurrence->due_day; ?>">
                                                                <label class="control-label m-r-5">of every</label>&nbsp;
                                                                <input class="form-control" type="number" name="recurrence[due_month]" min="1" max="12" style="width: 100px" id="r_month" value="<?php echo isset($invoice_recurrence->due_month) && $invoice_recurrence->due_month; ?>">&nbsp;
                                                                <label class="control-label" id="control-label">month(s)</label>
                                                                <?php } ?>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div><!-- ./row -->
                                            <div class="row">
                                                <label class="control-label p-l-15">Duration:</label>
                                                <div class="col-md-12">
                                                    <label class="control-label"><input type="radio" name="recurrence[duration_type]" value="0" <?php echo isset($invoice_recurrence->duration_type)?(($invoice_recurrence->duration_type == '0') ? 'selected' : ''):''; ?> >&nbsp; Never</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-inline">
                                                        <label class="control-label"><input type="radio" name="recurrence[duration_type]" value="1" <?php echo isset($invoice_recurrence->duration_type)?(($invoice_recurrence->duration_type == '1') ? 'selected' : ''):''; ?> onclick="//check_generation_type(this.value)"></label>&nbsp;
                                                        <label class="control-label">After</label>&nbsp;
                                                        <input class="form-control" type="text" id="duration_time" name="recurrence[duration_time]" value="<?php echo isset($invoice_recurrence->duration_time)?(($invoice_recurrence->duration_time !='') ? $invoice_recurrence->duration_time : ''):''; ?>" style="width: 100px">&nbsp;
                                                        <label class="control-label">generations</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-inline">
                                                        <label class="control-label"><input type="radio" name="recurrence[duration_type]" value="2" <?php echo (isset($invoice_recurrence->duration_type)?(($invoice_recurrence->duration_type == '2') ? 'selected' : ''):'') ?> checked=""></label>&nbsp;
                                                        <label class="control-label">Until date</label>&nbsp;
                                                        <input placeholder="mm/dd/yyyy" id="until_date" class="form-control datepicker_mdy_due" type="text" title="Until Date" name="recurrence[until_date]" value="<?= isset($invoice_recurrence->until_date)?($invoice_recurrence->until_date != '0000-00-00' ? date('m/d/Y', strtotime($invoice_recurrence->until_date)) : ''):''; ?>"  style="width: 100px">
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
                        <div class="hr-line-dashed"></div>
                        <h3>Confirmation</h3>
                        <div class="form-group" style="display: none">
                            <label class="col-lg-2 control-label">Create order</label>
                            <div class="col-lg-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" disabled="" <?= $order_summary['is_order'] == 'y' ? 'checked="checked"' : ''; ?> name="is_create_order" title="Create order" id="is_create_order" value="yes">  Check if you want to create an order with this invoice
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirm<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="checkbox" name="confirmation" title="Confirmation" id="confirmation" value="" required>
                                I confirm to be aware that the information added above is correct.
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="existing_services" id="existing_services" value="<?= implode(',', array_column($order_summary['services'], 'order_id')); ?>">
                                <input type="hidden" id="section_id" value="">
                                <input type="hidden" id="edit_type" value="<?= base64_decode($edit_type); ?>">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="company_id" id="company_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="<?= $invoice_id; ?>">
                                <input type="hidden" name="is_recurrence" id="is_recurrence" value="<?= $is_recurrence; ?>">
                                <input type="hidden" name="client_id" id="client_id">
                                <button class="btn btn-success" type="button" onclick="saveInvoice()">Update</button> &nbsp;&nbsp;&nbsp;
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
    invoiceContainerAjax(<?= $order_summary['invoice_type']; ?>, <?= $reference_id; ?>, <?= $invoice_id; ?>);
</script>
