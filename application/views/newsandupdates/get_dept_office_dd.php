<?php
if($type_val == '1'){
?>
<label class="col-sm-3 col-md-2 control-label">Department<span class="spanclass text-danger">*</span><input type="checkbox" class="m-l-10 m-r-5 m-0" id="chk_all" name="chk_all" value="chk_all"> All</label>
<div class="col-sm-9 col-md-10">
    <!--<select required class="form-control" title="Department" name="department" id="department" onchange="get_action_office();">-->
    <select required class="form-control" title="Department" name="department[]" id="department" multiple="multiple">
        <option id="no_val" value="">Select an option</option>
        <?php
        foreach ($departments as $value):
//                                        if ($value['name'] != "Franchise" || ($value['name'] == "Franchise" && $staff_info['type'] != 3)):
            ?>
            <option onclick="rev_chk()" value="<?= $value["id"]; ?>"><?= $value["name"]; ?></option>
            <?php
//                                        endif;
        endforeach;
        ?>
    </select>
    <div class="errorMessage text-danger"></div>
</div>
<?php
}elseif($type_val == '2'){
?>
<label class="col-sm-3 col-md-2 control-label">Office<span class="spanclass text-danger">*</span><input type="checkbox" class="m-l-10 m-r-5 m-0" id="chk_all" name="chk_all" value="chk_all"> All</label>
<div class="col-sm-9 col-md-10">
<!--    <select required class="form-control" title="Department" name="office" id="department" onchange="get_action_office_for_news();">-->
    <select required class="form-control" title="Department" name="office[]" id="department" multiple="multiple">
        <option id="no_val" value="">Select an option</option>
        <?php
        foreach ($departments as $value):
//                                        if ($value['name'] != "Franchise" || ($value['name'] == "Franchise" && $staff_info['type'] != 3)):
            ?>
            <option onclick="rev_chk()" value="<?= $value["id"]; ?>"><?= $value["name"]; ?></option>
            <?php
//                                        endif;
        endforeach;
        ?>
    </select>
    <div class="errorMessage text-danger"></div>
</div>
<?php
}
?>

