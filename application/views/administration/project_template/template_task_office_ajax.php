<?php if ($department_id == 2) { ?>

    <div class="form-group">
        <label class="col-lg-2 control-label">Responsible Staff<span class="spanclass text-danger">*</span></label>
        <div class="col-lg-10">
            <select required class="form-control" title="Assign Staff" name="task[responsible_task_staff]" id="responsible_office" <?php echo $disabled; ?>>
                <option value="">Select an option</option>
                <option value="1" <?= $responsible_staff == 1 ? 'selected' : '' ?> >Partner</option>
                <option value="2" <?= $responsible_staff == 2 ? 'selected' : '' ?>>Manager</option>
                <option value="3" <?= $responsible_staff == 3 ? 'selected' : '' ?>>Client Association</option>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
<?php } else { ?>
    <?php
    $staff_info = staff_info();
    if (isset($ismyself)) {
        if ($ismyself == 0) {
            $req = 'required';
        } else {
            $req = '';
        }
    } else {
        $req = 'required';
    }
    ?>
    <div class="form-group">
        <label class="col-lg-2 control-label">Assign Type<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <label class="m-r-10"><input type="radio" <?php echo $disabled; ?> <?php echo $req; ?> <?php if (isset($is_all) && $is_all=='1') echo ($is_all == '1') ? 'checked' : '' ?> id="is_chk_all" class="is_all" name="task[is_all]" value="1" onclick="selectTaskAll(this.value);" title="Assign Type" > Entire Department</label>
            <label><input type="radio" <?php echo $disabled; ?> <?php echo $req; ?> <?php if (isset($is_all)&& $is_all=='0') echo ($is_all == '0') ? 'checked' : '' ?> id="not_chk_all" class="is_all" name="task[is_all]" value="0" onclick="selectTaskAll(this.value);" title="Assign Type" > Individual Staff</label>
            <!-- <label><input type="radio" required id="is_chk_mytask" class="is_all" name="is_all" value="2" onclick="selectAll(this.value);" title="Assign Type"> Assign Myself</label> -->
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group" id="staff_ddl_div_task" style="display: none;">
        <label class="col-lg-2 control-label">Staff<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control task_staff_list" title="Task Staff" name="task[staff][]" id="staff">
                <option value="">Select Staff</option>
                <?php foreach ($staff_list as $sl): ?>
                    <option value="<?= $sl["id"]; ?>" <?php echo $sl['id'] == $select_staffs ? 'selected' : ''; ?> ><?= $sl["name"]; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <script>
        selectTaskAll(<?= $is_all ?>);
//        $(function () {
//            var no_of_selected_staff_new = $('#task_staff option:selected').length;
//        });
        function selectTaskAll(assign_type) {
            
            if (assign_type == 1) {
            $('#staff option[value=""]').remove();
//            $('#staff').attr('multiple', 'multiple');
            $('.task_staff_list').removeAttr('required');
            $('#staff option').prop('selected', true);
            $('#staff_ddl_div_task').hide();
        } else if (assign_type == 0) {
//            $('#staff option').prop('selected', false);
            $('#staff').prepend('<option value="">Select an option</option>');
//            $('#staff').removeAttr('multiple');
            $('.task_staff_list').attr('required', true);
            $('#staff_ddl_div_task').show();
        } else {
            $('#staff option[value=""]').remove();
//            $('#staff').attr('multiple', 'multiple');
            $('.task_staff_list').removeAttr('required');
            $('#staff option').prop('selected', true);
            $('#staff_ddl_div_task').hide();
        }
        }
    </script>
<?php } ?>
   