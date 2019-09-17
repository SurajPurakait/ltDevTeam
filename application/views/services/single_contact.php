<?php foreach ($contact as $cont): ?>

    <div id="contact_id_<?= $cont["id"] ?>" class="row">
        <input type="hidden" class="contact_id_array" name="contact_array[]" value="<?= $cont["id"]; ?>">
        <input type="hidden" class="contact_type_array" value="<?= $cont["type_id"]; ?>">
        <label class="col-lg-2 control-label"><?= $cont["type"]; ?></label>
        <div class="col-lg-10" style="padding-top:8px">
            <p>
                <b>Contact
                    Name: <?= $cont["first_name"]; ?> <?= $cont["middle_name"]; ?> <?= $cont["last_name"]; ?> </b>
                <br>
                Phones 1: <?= $cont["phone1"]; ?> (<?= $cont["phone1_country_name"]; ?>)
                <br>
                Email: <?= $cont["email1"]; ?>
                <br>
                <?= $cont["address1"]; ?>, <?= $cont["city"]; ?>, <?= $cont["state"]; ?>,
                ZIP: <?= $cont["zip"]; ?>, <?= $cont["country_name"]; ?>
            </p>
            <p>
                <i class="fa fa-edit contactedit" style="cursor:pointer"
                   onclick="open_contact_modal('edit', '', '', '<?= $cont["id"]; ?>')"
                   title="Edit this contact info"></i>
                &nbsp;&nbsp;<i class="fa fa-trash contactdelete text-danger" style="cursor:pointer"
                               onclick="delete_contact(<?= $cont["id"]; ?>)" title="Remove this contact info"></i>
            </p>
        </div>
    </div>

<?php endforeach; ?>