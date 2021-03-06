<?php $staff_info = staff_info();
if(isset($ismyself)){
  if($ismyself==0){
    $req = 'required';
  }else{
    $req = '';
  }
}else{
    $req = 'required';
}
?>
<div class="form-group clearfix">
    <label class="col-lg-2 control-label text-right">Assign Type<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <label class="m-r-10"><input type="radio" <?php echo $disabled; ?> <?php echo $req; ?> <?php if(isset($is_all) and $is_all!='') echo $is_all==1 ? 'checked':'' ?> id="is_chk_all" class="is_all" name="template_main[is_all]" value="1" onclick="selectResponsibleAll(this.value);" title="Assign Type"> Entire Department</label>
        <label><input type="radio" <?php echo $disabled; ?> <?php echo $req; ?> <?php if(isset($is_all) and $is_all!='') echo $is_all==0 ? 'checked':'' ?> id="not_chk_all" class="is_all" name="template_main[is_all]" value="0" onclick="selectResponsibleAll(this.value);" title="Assign Type"> Individual Staff</label>
        <!-- <label><input type="radio" required id="is_chk_mytask" class="is_all" name="is_all" value="2" onclick="selectAll(this.value);" title="Assign Type"> Assign Myself</label> -->
        <div class="errorMessage text-danger" id="is_all_error"></div>
    </div>
</div>
<div class="form-group clearfix" id="staff_ddl_div" style="display: none;">
    <label class="col-lg-2 control-label text-right">Staff<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select class="form-control" title="Staff" name="template_main[res_dept_staff][]" id="task_staff" <?php echo $disabled; ?>>
            <option value="">Select Staff</option>
            <?php foreach ($staff_list as $sl): ?>
                <option value="<?= $sl["id"]; ?>" <?= $sl["id"]==$select_staffs ? "selected='selected'" : ""; ?>><?= $sl["name"]; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<script>
    selectResponsibleAll(<?= $is_all ?>)
    $(function () {
////        $(".select2").select2();
//        var no_of_staff = $('#staff option').length;
////        alert(no_of_staff);
        var no_of_selected_staff_new = $('#staff option:selected').length;
////        alert(no_of_selected_staff_new);
//        if (no_of_staff == no_of_selected_staff_new) {
//            $('#is_chk_all').prop('checked', true);
//        } else {
//            $('#is_chk_all').prop('checked', false);
//        }
//        $('#staff option').click(function () {
//            var no_of_selected_staff = $('#staff option:selected').length;
//
//            if (no_of_staff == no_of_selected_staff) {
//                $('#is_chk_all').prop('checked', true);
//            } else {
//                $('#is_chk_all').prop('checked', false);
//            }
//        });
<?php if ($ismyself == 0): ?>
            if (no_of_selected_staff_new != 0) {
                if (no_of_selected_staff_new == 1) {
                    $('#not_chk_all').prop('checked', true);
                    $('#is_chk_all').prop('checked', false);
                    $('#is_chk_mytask').prop('checked', false);
                    var selected_staff = $('#staff').val();
                    selectResponsibleAll(0);
                    $('#staff option[value="' + selected_staff + '"]').prop('selected', true);
                } else {
                    $('#is_chk_all').prop('checked', true);
                    $('#not_chk_all').prop('checked', false);
                    $('#is_chk_mytask').prop('checked', false);
                    selectResponsibleAll(1);
                }
            }
<?php else: ?>
            $('#is_chk_all').prop('checked', false);
            $('#not_chk_all').prop('checked', false);
            $('#is_chk_mytask').prop('checked', true);
            selectResponsibleAll(2);
<?php endif; ?>
    });
    function selectResponsibleAll(assign_type) {
//        if (param.checked) {
//            $('#staff option').prop('selected', true);
//        } else {
//            $('#staff option').prop('selected', false);
//        }
        if (assign_type == 1) {
            $('#staff option[value=""]').remove();
//            $('#staff').attr('multiple', 'multiple');
            $('#staff').removeAttr('required');
            $('#staff option').prop('selected', true);
            $('#staff_ddl_div').hide();
        } else if (assign_type == 0) {
            $('#staff option').prop('selected', false);
            $('#staff').prepend('<option value="">Select an option</option>');
//            $('#staff').removeAttr('multiple');
            $('#task_staff').attr('required', true);
            $('#staff_ddl_div').show();
        } else {
            $('#staff option[value=""]').remove();
//            $('#staff').attr('multiple', 'multiple');
            $('#staff').removeAttr('required');
            $('#staff option').prop('selected', true);
            $('#staff_ddl_div').hide();
        }
    }
</script>