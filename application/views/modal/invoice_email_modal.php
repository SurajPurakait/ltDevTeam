<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Send Email</h4>
        </div>
        <form  method="post" id="invoice_email_form" name="invoice_email_form" onsubmit="sendInvoiceEmail();">    
            <div class="modal-body">
                <div class="row" id="row_div">
                    <?php foreach ($email_list as $key => $email) { ?>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">
                                <input type="checkbox" checked id="contact-email-<?= ($key + 1); ?>" name="email[]" value="<?= $email; ?>">&nbsp;
                                <!-- Contact email<?//= ($key + 1); ?> -->
                                Send to:
                            </label>
                            <div class="col-lg-9">
                                <p id="contact-email-text-<?= ($key + 1); ?>"><?= $email; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="form-group">
                        <?php
                            if ($email_list[0] != '') {
                        ?>
                        <label class="col-lg-3 control-label"><input type="checkbox" name="email[]" onchange="this.value = getIdVal('new_email');" id="new_email_checkbox" name="">&nbsp;
                        <?php        
                            } else {
                        ?>
                        <label class="col-lg-3 control-label"><input type="checkbox" name="email[]" onchange="this.value = getIdVal('new_email');" id="new_email_checkbox" name="" checked>&nbsp;
                        <?php        
                            }
                        ?>
                        
                        <!-- New email -->
                        Send to:
                    </label>
                        <div class="col-lg-9">
                            <input class="form-control" type="email" id="new_email" title="New Email"  onchange="setIdVal('new_email_checkbox', this.value);">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="invoice_id" id="invoice_id" value="<?= $invoice_id ?>">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="sendInvoiceEmail();">Submit</button>
            </div>
        </form>
    </div>
</div>