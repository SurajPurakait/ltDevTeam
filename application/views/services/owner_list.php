<?php
$staff_info = staff_info();
if (!empty($list)) :
    if ($section == "main") :
        foreach ($list as $title) :
            ?>
            <div class="row">
                <label class="col-lg-2 control-label"><?= $title->title ?></label>
                <div class="col-lg-10" style="padding-top:8px">
                    <p>
                        <b>Name: <?= $title->name ?></b><br>
                        Percentage: <?= $title->percentage ?>%
                    </p>
                    <?php if ($title->existing_reference_id == $title->company_id): ?>
                        <p <?= (($staff_info['type'] == 1 || $staff_info['type'] == 2 || ($staff_info['type'] == 3 && $staff_info['role'] == 2))) ? '':'style="display:none"'; ?>>
                            <i class="fa fa-edit owneredit" style="cursor:pointer" onclick="open_owner_popup(0, '<?= $title->company_id; ?>', '<?= $title->id; ?>');" title="Edit This Owner"></i>
                            &nbsp;&nbsp;<i class="fa fa-trash ownerdelete" style="cursor:pointer" onclick="delete_owner('<?= $title->id; ?>');" title="Remove this owner"></i>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif ($section == "payroll") : ?>
        <h4>Select from Owners</h4>
        <div class="row">
            <?php foreach ($list as $data) : ?>
                <div class="col-md-4">
                    <div class="alert alert-info text-center">
                        <a href="javascript:void(0);" class="payroll-own" onclick="copy_values(<?php echo $data->id; ?>, 'payroll_approver')"><b><?php echo $data->name; ?></b></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif ($section == "payroll2") : ?>
        <h4>Select from Owners</h4>
        <div class="row">
            <?php foreach ($list as $data) : ?>
                <div class="col-md-4">
                    <div class="alert alert-info text-center">
                        <a href="javascript:void(0);" class="payroll-own" onclick="copy_values(<?php echo $data->id; ?>, 'company_principal')"><b><?php echo $data->name; ?></b></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif ($section == "payroll3") : ?>
        <h4>Select from Owners</h4>
        <div class="row">
            <?php foreach ($list as $data) : ?>
                <div class="col-md-4">
                    <div class="alert alert-info text-center">
                        <a href="javascript:void(0);" class="payroll-own" onclick="copy_values(<?php echo $data->id; ?>, 'signer_data')"><b><?php echo $data->name; ?></b></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php if ($section == "main") : ?>
    <input type="hidden" title="Owners" id="owners-list-count" value="<?= count($list) != 0 ? count($list) : ""; ?>">
    <div class="errorMessage text-danger"></div>
<?php endif; ?>
<input type="hidden" name="owner_percentage_total" id="owner_percentage_total" value="<?= $total_percentage ?>">
