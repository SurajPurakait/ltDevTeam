<?php
foreach ($departments as $key => $value) {
    if ($value['id'] == '2') {
        unset($departments[$key]);
    }
}
?>
<?php if($department_id!=3 && $department_id!=1){?>
<div class="form-group clearfix">
    <label class="col-lg-2 control-label text-right">Department<span class="spanclass text-danger">*</span></label>
    <div class="col-lg-10">
        <select required class="form-control" title="Department" name="template_main[responsible_department]" id="responsible_department" <?php echo $disabled; ?> onchange="get_responsible_staff_list('','');">
            <?= $department_id != 3 ? '<option value="">Select an option</option>' : ''; ?>
            <?php foreach ($departments as $ol): ?>
                <option value="<?= $ol["id"]; ?>" <?= $res_department == $ol["id"] ? "selected='selected'" : ""; ?>><?= $ol["name"]; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<?php }elseif($department_id==3 && $department_id!=1){ ?>
<div class="form-group">
    <label class="col-lg-2 control-label text-right">Responsible Staff<span class="spanclass text-danger">*</span></label>
    <div class="col-lg-10">
        <select required class="form-control" title="Assign Staff" name="template_main[francise_staff]" id="responsible_office" <?php echo $disabled; ?>>
            <option value="">Select an option</option>
            <option value="1" <?= $res_staff==1 ?'selected':'' ?> >Partner</option>
            <option value="2" <?= $res_staff==2 ?'selected':'' ?> >Manager</option>
            <option value="3" <?= $res_staff==3 ?'selected':'' ?> >Client Association</option>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<?php }?>
<script>
    <?php if($department_id!=3){ ?>
    get_responsible_staff_list('<?= $select_staff ?>','<?= $is_all ?>',<?= $department_id ?>);
    <?php } ?>
    </script>
