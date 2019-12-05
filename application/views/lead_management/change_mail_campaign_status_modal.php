<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Change Mail Campaign Status</h3>
        </div>
        <form class="form-horizontal" method="post" id="change_mail_campaign_status_modal">
            <div class="modal-body">
                <h4>Do you Want To Activate Mail Campaign ?</h4>
                <div class="row m-l-2">
                    <label class="radio-inline">
                        <input type="radio" name="mail_campaign_status[]" value="1" <?= ($lead_data['mail_campaign_status'] == 1) ? "checked":"" ; ?> > <b>Active</b>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="mail_campaign_status[]" value="0" <?= ($lead_data['mail_campaign_status'] == 0) ? "checked":"" ; ?>> <b>Inactive</b>
                    </label>
                </div>
<!--                 <div class="col-md-12">
                    
                </div>
                <div class="col-md-12"><h4> Email: example@gmail.com </h4></div>
                <div class="col-md-12 row">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="confirm_email" placeholder="Confirm Your Email">
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="button">Confirm</button> &nbsp;&nbsp;&nbsp;
                <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>