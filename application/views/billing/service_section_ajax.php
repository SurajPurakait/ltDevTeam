<?php
$colors = array('bg-light-blue','bg-light-green','bg-light-red', '', 'bg-light-orange', 'bg-light-purple', 'bg-light-aqua');
$random_keys=array_rand($colors);
?>
<div class="well <?php echo $colors[$random_keys]; ?>" id="service_result_div_<?= $section_id; ?>">
    <div class="form-group" id="category_div_<?= $section_id; ?>">
        <label class="col-lg-2 control-label">Service Category<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control" name="service_section[<?= $section_id; ?>][category_id]" onchange="getServiceDropdownByCategory(this.value, '', '<?= $section_id; ?>');" id="category_<?= $section_id; ?>" title="Service Category" required="">
                <option value="">Select an option</option>
                <?php load_ddl_option("get_service_category"); ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div id="service_dropdown_div_<?= $section_id; ?>"></div>
    <div id="service_div_<?= $section_id; ?>"></div>
</div>