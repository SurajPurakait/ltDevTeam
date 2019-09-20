<?php
if ($modal_type == "edit") {
    ?>

<?php } else {
    ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Refund</h4>
            </div>
            <form method="post" id="form_save_payment" onsubmit="saveRefund(); return false;">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Refund Date<span class="text-danger">*</span></label>
                        <input type="text" name="payment_date" id="payment_date" class="form-control datepicker_mdy" title="Refund Date" placeholder="Refund Date" required="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Refund Type<span class="text-danger">*</span></label>
                        <select class="form-control" name="payment_type" id="payment_type" required="" onchange="changeAlternateFields(this.value);" title="Refund Type">
                            <option value="">-- Select --</option>
                            <?php
                            foreach ($payment_type as $val) {
                                if ($val['name'] == 'Pay NOW') {
                                    continue;
                                }
                                ?>
                                <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Refund Amount<span class="text-danger">*</span></label>
                        <input type="text" numeric_valid="" name="payment_amount" id="payment_amount" class="form-control" title="Refund Amount" placeholder="Refund Amount" required="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group alternate-field-div">
                        <label>Check Number<span class="text-danger">*</span></label>
                        <input type="text" name="check_number" id="check_number" class="form-control" title="Check Number" placeholder="Check Number">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group alternate-field-div">
                        <label>Authorization ID<span class="text-danger">*</span></label>
                        <input type="text" name="authorization_id" id="authorization_id" class="form-control" title="Authorization ID" placeholder="Authorization ID">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group alternate-field-div">
                        <label>Reference</label>
                        <input type="text" name="ref_no" id="ref_no" class="form-control" title="Reference" placeholder="Reference">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="payment_note" id="payment_note" class="form-control" title="Note" placeholder="Note"></textarea>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group alternate-field-div">
                        <label>Attachments<span class="text-danger">*</span></label>
                        <input type="file" title="File" name="payment_file" id="payment_file">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="invoice_id" id="invoice_id" value="<?= $invoice_id; ?>"/>
                    <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>"/>
                    <input type="hidden" name="order_id" id="order_id" value="<?= $order_id; ?>"/>
                    <input type="hidden" name="payble_amount" id="payble_amount" value="<?= $payble_amount; ?>"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveRefund()">Save</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<script>
    $(function () {
        $("#payment_date").datepicker({format: 'mm/dd/yyyy', autoHide: true});
        $("#payment_date").attr("onblur", 'checkDate(this);');
    });
    changeAlternateFields('')
</script>