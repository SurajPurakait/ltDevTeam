<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_save_lead_mail" onsubmit="save_lead_mail(); return false;">
                        <h3>Mail Content</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Subject<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Subject" id="lead_subject" required class="form-control" type="text" name="subject" title="Subject" value="<?php echo $edit_lead_mail_content['subject']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Schedule Date<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Schedule Date" id="schedule_date" required class="form-control" type="text" name="schedule_date" title="Schedule Date">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Body<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea rows="12" class="form-control" required="" id="lead_body" name="body" title="Body" placeholder="Body"><?php echo urldecode($edit_lead_mail_content['body']); ?></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success" type="button" onclick="save_lead_mail()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_save_lead_mail()">Cancel</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var date = new Date();
        date.setDate(date.getDate());
        $("#schedule_date").datepicker({format: 'mm/dd/yyyy', startDate: date, autoHide: true});
        $("#schedule_date").attr("onblur", 'checkDate(this);');
    });
</script>