<?php foreach ($data as $contact) : ?>

    <div class="row">
        <label class="col-lg-2 control-label"><?= $contact["type"]; ?></label>
        <div class="col-lg-10" style="padding-top:8px">
            <p>
                <b>Contact
                    Name: <?= $contact["first_name"]; ?> <?= $contact["middle_name"]; ?> <?= $contact["last_name"]; ?> </b>
                <br>
                Phones 1: <?= $contact["phone1"]; ?> (<?= $contact["phone1_country_name"]; ?>)
                <br>
                Email: <?= $contact["email1"]; ?>
                <br>
                <?= $contact["address1"]; ?>, <?= $contact["city"]; ?>, <?= $contact["state"]; ?>,
                ZIP: <?= $contact["zip"]; ?>, <?= $contact["country_name"]; ?>
            </p>
            <p>
                <i class="fa fa-edit contactedit text-success" style="cursor:pointer"
                   onclick="open_contact_modal('edit', '', '', '<?= $contact["id"]; ?>')"
                   title="Edit this contact info"></i>
                &nbsp;&nbsp;<i class="fa fa-trash contactdelete text-danger" style="cursor:pointer"
                               onclick="deleteContact(<?= $contact["id"]; ?>)" title="Remove this contact info"></i>
            </p>
        </div>
    </div>

<?php endforeach; ?>