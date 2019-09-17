<?php $element_name = $element_key != '' ? str_replace(" ", "_", strtolower($element_array[$element_key])) : ''; ?>
<?php if ($element_key == 7) : //creation date       ?>
    <input placeholder="dd/mm/yyyy" class="form-control <?= ($condition == 2 || $condition == 4) ? 'datepicker_range_mdy' : 'datepicker_mdy'; ?>" type="text" title="<?= $element_array[$element_key]; ?>" name="criteria_dropdown[<?= $element_name; ?>][]">
<?php else: ?>
    <select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' title="<?= $element_array[$element_key]; ?>" name='criteria_dropdown[<?= $element_name; ?>][]'>
        <option value=''>All Criteria</option>
        <?php if (isset($element_value_list) && count($element_value_list) > 0): ?>
            <?php foreach ($element_value_list as $evl): ?>
                <option value="<?= is_array($evl) ? (($element_name == 'client') ? $evl['reference_id'] : $evl['id']) : $evl; ?>"><?= is_array($evl) ? $evl['name'] : $evl; ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
<?php endif; ?>
<script type="text/javascript">
    $(function () {
        $(".datepicker_mdy").datepicker({format: 'mm/dd/yyyy', autoHide: true});
        $(".datepicker_range_mdy").daterangepicker();
    });
</script>