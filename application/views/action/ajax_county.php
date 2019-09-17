<div class="form-group">
    <label class="col-lg-2 control-label">County<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select class="form-control" name="county" id="county" title="County" required="" onchange="get_county_rate()">
            <option value="">Select</option>
            <?php
            foreach ($county as $val) {
                ?>
                <option value="<?= $val['id']; ?>" <?= ($selected_county == $val['id']) ? 'selected' : ''; ?>><?= $val['name']; ?></option>
                <?php
            }
            ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>