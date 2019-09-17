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
        <label class="m-r-10"><input type="radio" <?php echo $req; ?> <?= $is_all=='1'?'checked':'' ?> id="is_chk_all" class="is_all" name="template_main[dept_is_all]" value="1" onclick="selectDeptStaffAll(this.value);" title="Assign Type"> Entire Department</label>
        <label><input type="radio" <?php echo $req; ?> <?= $is_all=='0'?'checked':'' ?> id="not_chk_all" class="is_all" name="template_main[dept_is_all]" value="0" onclick="selectDeptStaffAll(this.value);" title="Assign Type"> Individual Staff</label>
        <!-- <label><input type="radio" required id="is_chk_mytask" class="is_all" name="is_all" value="2" onclick="selectAll(this.value);" title="Assign Type"> Assign Myself</label> -->
        <div class="errorMessage text-danger" id="is_all_error"></div>
    </div>
</div>
<div class="form-group clearfix" id="dept_staff_list" style="display: none;">
    <label class="col-lg-2 control-label text-right">Staff<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select class="form-control" title="Staff" name="template_main[department_staff][]" id="dept_staff" multiple="">
            <?php foreach ($dept_staff_list as $sl): ?>
                <option value="<?= $sl["id"]; ?>" <?php echo $sl["id"]==$select_staffs? "selected" : "" ?> ><?= $sl["name"]; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<script>
    selectDeptStaffAll(<?= $is_all ?>)
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
                    selectDeptStaffAll(0);
                    $('#staff option[value="' + selected_staff + '"]').prop('selected', true);
                } else {
                    $('#is_chk_all').prop('checked', true);
                    $('#not_chk_all').prop('checked', false);
                    $('#is_chk_mytask').prop('checked', false);
                    selectDeptStaffAll(1);
                }
            }
<?php else: ?>
            $('#is_chk_all').prop('checked', false);
            $('#not_chk_all').prop('checked', false);
            $('#is_chk_mytask').prop('checked', true);
            selectDeptStaffAll(2);
<?php endif; ?>
    });
    function selectDeptStaffAll(assign_type) {
        if (assign_type == 1) {
            $('#dept_staff option[value=""]').remove();
            $('#dept_staff').attr('multiple', 'multiple');
            $('#dept_staff').removeAttr('required');
//            $('#dept_staff option').prop('selected', true);
            $('#dept_staff_list').hide();
        } else if (assign_type == 0) {
//            $('#dept_staff option').prop('selected');
            $('#dept_staff').prepend('<option value="">Select an option</option>');
            $('#dept_staff').removeAttr('multiple');
            $('#dept_staff').attr('required', 'required');
            $('#dept_staff_list').show();
        } else {
            $('#dept_staff').prepend('<option value="">Select an option</option>');
            $('#dept_staff option[value=""]').remove();
            $('#dept_staff').attr('multiple', 'multiple');
            $('#dept_staff').removeAttr('required');
//            $('#dept_staff option').prop('selected', true);
            $('#dept_staff_list').hide();
        }
    }
</script>