<div class="form-group">
    <label class="col-lg-2 control-label">Office<span class="spanclass text-danger">*</span></label>
    <div class="col-lg-10">
        <select required class="form-control" title="Office" name="office" id="office" onchange="get_action_staff('','','');">
            <?= $department_id == 2 ? '<option value="">Select an option</option>' : ''; ?>
            <?php foreach ($office_list as $ol): ?>
                <option value="<?= $ol["id"]; ?>" <?= $select_office == $ol["id"] ? "selected='selected'" : ""; ?>><?= $ol["name"]; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>