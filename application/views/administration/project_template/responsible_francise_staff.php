
<div class="form-group">
    <label class="col-lg-2 control-label">Assign Staff<span class="spanclass text-danger">*</span></label>
    <div class="col-lg-10">
        <select required class="form-control" title="Assign Staff" name="template_main[francise_staff]" id="responsible_office" <?php echo $disabled; ?>>
            <option value="">Select an option</option>
            <option value="1">Partner</option>
            <option value="2">Manager</option>
            <option value="3">Client Association</option>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>