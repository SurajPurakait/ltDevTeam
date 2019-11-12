<?php $element_name = $element_key != '' ? str_replace(" ", "_", strtolower($element_array[$element_key])) : ''; ?>
<?php if ($element_key == 3) : //date ?>
    <input placeholder="mm/dd/yyyy" class="form-control <?= ($condition == 2 || $condition == 4) ? 'datepicker_range_mdy' : 'datepicker_mdy'; ?>" type="text" title="<?= $element_array[$element_key]; ?>" name="criteria_dropdown[<?= $element_name; ?>][]">
<?php else: ?>
    <select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' title="<?= $element_array[$element_key]; ?>" name='criteria_dropdown[<?= $element_name; ?>][]'>
        <option value=''>All Criteria</option>
        <?php if (isset($element_value_list) && count($element_value_list) > 0):

            ?>
            <?php
            foreach($element_value_list as $evl):
                if($element_name == 'event_name'){
                ?>
                <option value="<?= ($element_name == 'event_name') ? $evl['event_name'] : ''; ?>"><?= $evl['event_name']; ?></option>
            <?php }elseif ($element_name == 'office') {?>
                <option value="<?= ($element_name == 'office') ? $evl['name'] : ''; ?>"><?= $evl['name']; ?></option>
            <?php }elseif ($element_name == 'location') {?>
                <option value="<?= ($element_name == 'location') ? $evl['location'] : ''; ?>"><?= $evl['location']; ?></option>
            <?php } ?>
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