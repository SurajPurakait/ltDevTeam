<div id="existing_client_extra_field">
    <div class="form-group" id="business_description_div">
        <label class="col-lg-2 control-label">Business Description<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <textarea class="form-control value_field required_field" name="business_description" id="business_description" title="Business Description"></textarea>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Start Date<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <input placeholder="mm/dd/yyyy" id="month" class="form-control datepicker_mdy value_field required_field" type="text" title="Start Date" name="start_year" value="">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".datepicker_mdy").datepicker({dateFormat: 'mm/dd/yy', autoHide: true});
</script>