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
<div class="form-group clearfix">
     <label class="col-lg-2 control-label text-right">Assign Type<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <label class="m-r-10"><input type="radio" <?php echo $req; ?> <?= $is_all == '1' ? 'checked' : '' ?> id="is_chk_all" class="is_all" name="template_main[ofc_is_all]" value="1" onclick="selectAllStaff(this.value);" title="Assign Type"> Entire Office Staff</label>
        <label><input type="radio" <?php echo $req; ?> <?= $is_all == '0' ? 'checked' : '' ?> id="not_chk_all" class="is_all" name="template_main[ofc_is_all]" value="0" onclick="selectAllStaff(this.value);" title="Assign Type"> Individual Office Staff</label>
        <!-- <label><input type="radio" required id="is_chk_mytask" class="is_all" name="is_all" value="2" onclick="selectAll(this.value);" title="Assign Type"> Assign Myself</label> -->
        <div class="errorMessage text-danger" id="is_all_error"></div>
    </div>
</div>
<div class="form-group clearfix" id="ofc_staff_div" style="display: none;">
    <label class="col-lg-2 control-label text-right">Staff<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select class="form-control" title="Staff" name="template_main[office_staff][]" id="office_staff" multiple="">
            <?php foreach ($office_list as $sl): ?>
                <option value="<?= $sl["id"]; ?>" <?= $sl["id"] == $select_staffs ? "selected='selected'" : ""; ?> ><?= $sl["name"]; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div id="ofc_partner_staff_list" class="form-group clearfix"  style="display: none;">
    <label class="col-sm-2 col-md-2 control-label text-right">Partner</label>
    <div class="col-lg-10">
        <select class="form-control" title="Staff" name="template_main[partner]" id="office_partner" multiple="">
            <?php foreach ($office_list as $sl): ?>
                <option value="<?= $sl["id"]; ?>" <?= $sl["id"] == $partner ? "selected='selected'" : ""; ?>><?= $sl["name"]; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div id="ofc_manager_staff_list" class="form-group clearfix"  style="display: none;">
    <label class="col-sm-2 col-md-2 control-label text-right">Manager</label>
    <div class="col-lg-10">
        <select class="form-control" title="Manager" name="template_main[manager]" id="office_manager" multiple="">
            <?php foreach ($office_list as $sl): ?>
                <option value="<?= $sl["id"]; ?>" <?= $sl["id"] == $manager ? "selected='selected'" : ""; ?>><?= $sl["name"]; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div id="ofc_associate_staff_list" class="form-group clearfix" style="display: none;">
    <label class="col-sm-2 col-md-2 control-label text-right">Associate</label>
    <div class="col-lg-10">
        <select class="form-control" title="Staff" name="template_main[associate]" id="office_associate" multiple="">
            <?php foreach ($office_list as $sl): ?>
                <option value="<?= $sl["id"]; ?>" <?= $sl["id"] == $associate ? "selected='selected'" : ""; ?> ><?= $sl["name"]; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<script>
    selectAllStaff(<?= $is_all ?>);
    $(function () {
////        $(".select2").select2();
//        var no_of_staff = $('#staff option').length;
////        alert(no_of_staff);
        var no_of_selected_staff_new = $('#office_staff option:selected').length;
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
                    var selected_staff = $('#office_staff').val();
                    selectAllStaff(0);
                    $('#office_staff option[value="' + selected_staff + '"]').prop('selected', true);
                } else {
                    $('#is_chk_all').prop('checked', true);
                    $('#not_chk_all').prop('checked', false);
                    $('#is_chk_mytask').prop('checked', false);
                    selectAllStaff(1);
                }
            }
<?php else: ?>
            $('#is_chk_all').prop('checked', false);
            $('#not_chk_all').prop('checked', false);
            $('#is_chk_mytask').prop('checked', true);
            selectAllStaff(2);
<?php endif; ?>
    });
    function selectAllStaff(assign_type) {
//        if (param.checked) {
//            $('#staff option').prop('selected', true);
//        } else {
//            $('#staff option').prop('selected', false);
//        }
        if (assign_type == 1) {
            $('#office_staff option[value=""]').remove();
            $('#office_staff').attr('multiple', 'multiple');
            $('#office_staff').removeAttr('required');
//            $('#office_staff option').prop('selected', true);
            $('#ofc_staff_div').hide();
            $('#ofc_partner_staff_list').hide();
            $('#ofc_manager_staff_list').hide();
            $('#ofc_associate_staff_list').hide();
        } else if (assign_type == 0) {
//            $('#office_staff option').prop('selected', false);
            $('#office_staff').prepend('<option value="">Select an option</option>');
            $('#office_staff').removeAttr('multiple');
            $('#office_staff').attr('required', 'required');
            $('#ofc_staff_div').show();

            $('#office_partner').prepend('<option value="">Select an option</option>');
            $('#office_partner').removeAttr('multiple');
            $('#ofc_partner_staff_list').show();

            $('#office_manager').prepend('<option value="">Select an option</option>');
            $('#office_manager').removeAttr('multiple');
            $('#ofc_manager_staff_list').show();

            $('#office_associate').prepend('<option value="">Select an option</option>');
            $('#office_associate').removeAttr('multiple');
            $('#ofc_associate_staff_list').show();
        } else {
            $('#office_staff option[value=""]').remove();
            $('#office_staff').attr('multiple', 'multiple');
            $('#office_staff').removeAttr('required');
//            $('#office_staff option').prop('selected', true);
            $('#ofc_staff_div').hide();
            $('#ofc_partner_staff_list').hide();
            $('#ofc_manager_staff_list').hide();
            $('#ofc_associate_staff_list').hide();
        }
    }
</script>