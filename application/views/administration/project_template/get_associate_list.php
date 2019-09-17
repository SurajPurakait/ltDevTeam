<select class="form-control" title="Associate" name="template_main[associate]" id="associate" required>
    <option value="">Select Option</option>
    <?php foreach ($staff_list as $sl): ?>
        <option value="<?= $sl["id"]; ?>" <?= in_array($sl["id"], explode(",", $select_staffs)) ? "selected='selected'" : ""; ?>><?= $sl["name"]; ?></option>
    <?php endforeach; ?>
</select>
<div class="errorMessage text-danger"></div>