
<div class="form-group">
    <label class="col-lg-2 control-label">Rate<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <input placeholder="" class="form-control" type="text" id="rate" name="rate" title="Rate" required value="<?= ($county_rate['rate']!='' ? $county_rate['rate'] : "") ?>">
        <div class="errorMessage text-danger"></div>
    </div>
</div>