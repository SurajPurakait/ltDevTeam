<?php $element_name = $element_key != '' ? str_replace(" ", "_", strtolower($element_array[$element_key])) : ''; ?>
<?php 
if ($element_key == 9) : //start date and complete date and creation date and due date      ?>
    <input placeholder="dd/mm/yyyy" class="form-control <?= ($condition == 2 || $condition == 4) ? 'datepicker_range_mdy' : 'datepicker_mdy'; ?>" type="text" title="<?= $element_array[$element_key]; ?>" name="criteria_dropdown[<?= 'created_at' ?>][]">
<?php
elseif($element_key == 11): ?>
    <input placeholder="dd/mm/yyyy" class="form-control <?= ($condition == 2 || $condition == 4) ? 'datepicker_range_mdy' : 'datepicker_mdy'; ?>" type="text" title="<?= $element_array[$element_key]; ?>" name="criteria_dropdown[<?= 'due_date' ?>][]">
<?php else: ?>
    <select class='form-control criteria-dropdown chosen-select' placeholder='All Criteria' title="<?= $element_array[$element_key]; ?>" name='criteria_dropdown[<?= $element_name; ?>][]'>
        <option value=''>All Criteria</option>
        <?php if (isset($element_value_list) && count($element_value_list) > 0):
            $new_sort=array();
            foreach ($element_value_list as $key => $evl):
                $new_sort[$key]= $evl['name'];
            endforeach;
            array_multisort($new_sort, SORT_ASC, $element_value_list);
            ?>
            <?php foreach ($element_value_list as $evl): ?>
                <option value="<?= ($element_name == 'client_id') ? '' : $evl['id']; ?>"><?= $evl['name']; ?></option>
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