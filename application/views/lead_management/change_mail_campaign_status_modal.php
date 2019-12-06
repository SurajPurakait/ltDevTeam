<div class="modal-dialog" style="width: 400px !important;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Mail Campaign Status</h3>
        </div>
        <form class="form-horizontal" method="post" id="change_mail_campaign_status_modal">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Change Mail Campaign Status</h4>
                        <label class="radio-inline">
                            <input type="radio" name="mail_campaign_status_lead" value="1" <?= ($lead_data['mail_campaign_status'] == 1) ? "checked":"" ; ?> > Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="mail_campaign_status_lead" value="0" <?= ($lead_data['mail_campaign_status'] == 0) ? "checked":"" ; ?>> No
                        </label>
                    </div> 
                </div>
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <h4>Confirm Email</h4>
                        <label class="radio-inline">
                            <input type="radio" name="lead_email"  value="<?= $lead_data['email']; ?>" onchange="show_confirm_email_div(0);" checked> <?= $lead_data['email']; ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="lead_email" value="other" onchange="show_confirm_email_div(1);"> Other
                        </label>
                   </div>
                </div>
                <input type="hidden" name="lead_id" value="<?= $lead_data['id']; ?>">
                
                <div class="row m-t-20" style="display: none;" id="confirm_email_div">
                    <div class="col-md-2 m-t-5">
                        <label>Email<span class="text-danger">*</span></label> 
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="text" class="form-control" name="confirm_email" id="confirm_email" placeholder="Confirm Your Email" title="Email" required>
                            <div class="errorMessage text-danger m-t-2 m-l-2"></div>
                        </div>    
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="button" onclick="update_mail_campaign_status_lead()">Confirm</button> 
                <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>