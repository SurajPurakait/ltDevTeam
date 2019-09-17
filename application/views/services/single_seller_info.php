<?php foreach ($seller_list as $seller): ?>

    <div id="seller_id_<?= $seller["id"] ?>" class="row">
        <div class="col-lg-10 col-lg-offset-2" style="padding-top:8px">
            <p>
                <span <?= ($seller["itin_number"] != 0) ? '':'style="display:none"'; ?>><b>ITIN Number:</b><?= $seller["itin_number"]; ?></span><br>
                <b>Full Name:</b><?= $seller["fullname"]; ?><br> 
                <b>Contact Information:</b> <?= $seller["contact_information"]; ?><br>
                <span <?= ($seller["full_address"] == '') ? 'style="display:none"':''; ?>><b>Full Address:</b> <?= $seller["full_address"]; ?></span>
                <input type="hidden" name="reference_id" value="<?= $seller["reference_id"]; ?>">
            </p>

            <p>
                <i class="fa fa-edit contactedit" style="cursor:pointer"
                   onclick="seller_info_modal('edit', '', '', '<?= $seller["id"]; ?>')"
                   title="Edit this seller info"></i>
                &nbsp;&nbsp;
                <i class="fa fa-trash contactdelete text-danger" style="cursor:pointer"
                    onclick="delete_seller(<?= $seller["id"]; ?>)" title="Remove this seller info"></i>
            </p>
        </div>
    </div>

<?php endforeach; ?>
<?php if (count($seller_list) == 0) { ?>
    <input type="hidden" name="seller_info" id="seller_info" value="" required title="seller Info">
<?php } else { ?>
    <input type="hidden" name="seller_info" value="<?php echo count($seller_list); ?>" required="" id="seller_info" title="seller Info">
<?php } ?>
<div class="errorMessage text-danger"></div>