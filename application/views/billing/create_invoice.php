<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_create_invoice" onsubmit="saveInvoice(); return false;">
                        <div class="form-group">
                            <label class="col-lg-2 control-label" style="font: 24px;">Invoice Type<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" onchange="invoiceContainerAjax(this.value, <?= $reference_id; ?>, '','');" name="invoice_type" id="invoice_type" title="Invoice Type" required="">
                                    <option value="1" <?= (isset($client_id) && $client_id == '1') ? 'selected' : ''; ?>>Business Client</option>
                                    <option value="2" <?= (isset($client_id) && $client_id == '2') ? 'selected' : ''; ?>>Individual</option>
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
                        <?= service_note_func('Invoice Notes', 'n', 'invoice'); ?>

                        <div id="recurring_section"></div>
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
<?php if ($client_id != '' && $reference_id != ''){ ?>
        invoiceContainerAjax(<?= $client_id ?>, <?= $reference_id; ?>, '','');
<?php } else{ ?>
        invoiceContainerAjax(1, <?= $reference_id; ?>, '','');
<?php } ?>
</script>
