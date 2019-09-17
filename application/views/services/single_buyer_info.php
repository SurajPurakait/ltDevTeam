<?php foreach ($buyer_list as $buyer): ?>

    <div id="buyer_id_<?= $buyer["id"] ?>" class="row">
        <div class="col-lg-10 col-lg-offset-2" style="padding-top:8px">
            <p>
                <b>ITIN Number:</b><?= $buyer["itin_number"]; ?><br>
                <b>Full Name:</b><?= $buyer["fullname"]; ?><br> 
                <b>Contact Information:</b> <?= $buyer["contact_information"]; ?>
                <input type="hidden" name="reference_id" value="<?= $buyer["reference_id"];; ?>">
            </p>

            <p>
                <i class="fa fa-edit contactedit" style="cursor:pointer"
                   onclick="buyer_info_modal('edit', '', '', '<?= $buyer["id"]; ?>')"
                   title="Edit this buyer info"></i>
                &nbsp;&nbsp;
                <i class="fa fa-trash contactdelete text-danger" style="cursor:pointer"
                    onclick="delete_buyer(<?= $buyer["id"]; ?>)" title="Remove this buyer info"></i>
            </p>
        </div>
    </div>

<?php endforeach; ?>
<?php if (count($buyer_list) == 0) { ?>
    <input type="hidden" name="buyer_info" id="buyer_info" value="" required title="buyer Info">
<?php } else { ?>
    <input type="hidden" name="buyer_info" value="<?php echo count($buyer_list); ?>" required="" id="buyer_info" title="buyer Info">
<?php } ?>
<div class="errorMessage text-danger"></div>