<div class="row">
    <?php foreach ($employee_list as $el) { ?>
        <div class="col-lg-4" style="padding-top:8px">
            <div class="alert alert-info">
                <i class="fa fa-edit employeeedit" style="cursor:pointer" onclick="employee_modal('edit', <?php echo $el['id']; ?>)" title="Edit this employee info"></i>
                <label class="control-label"><?php echo $el['employee_type']; ?></label>
                <i class="fa fa-trash employeedelete" style="cursor:pointer" onclick="delete_employee(<?php echo $el['id']; ?>)" title="Remove this employee info"></i>
                <p>
                    <b>Employee Name: <?php echo $el['first_name'] . " " . $el['last_name']; ?></b><br>
                    Phones: <?php echo $el['phone_number']; ?> <br>
                    Email: <?php echo $el['email']; ?> <br>
                    <?php echo $el['address']; ?>, <?php echo $el['city']; ?>, <?php echo $el['state']; ?>, ZIP: <?php echo $el['zip']; ?>
                </p>
            </div>
        </div>

    <?php } ?>
</div>
<?php if (count($employee_list) == 0) { ?>
    <input type="hidden" name="employee_info" id="employee_info" value="" required title="Employee Info">
<?php } else { ?>
    <input type="hidden" name="employee_info" value="<?php echo count($employee_list); ?>" required="" id="employee_info" title="Employee Info">
<?php } ?>
<div class="errorMessage text-danger"></div>