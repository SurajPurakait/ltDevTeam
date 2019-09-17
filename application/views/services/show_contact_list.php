<?php foreach ($list as $contact) :
    $state_name = state_info($contact['state'])['state_name'];
 ?>
    <div class="row">
        <label class="col-lg-2 control-label"><?= $contact["type"]; ?></label>
        <div class="col-lg-10" style="padding-top:8px">
            <p>
                <b>Contact Name: <?= $contact["first_name"]; ?> <?= $contact["middle_name"]; ?> <?= $contact["last_name"]; ?> </b><br>
                Phones 1: <?= $contact["phone1"]; ?> (<?= $contact["phone1_country_name"]; ?>)<br>
                Email: <?= $contact["email1"]; ?><br>
                <?= $contact["address1"]; ?>, <?= $contact["city"]; ?>, <?= $state_name; ?>,
                ZIP: <?= $contact["zip"]; ?>, <?= $contact["country_name"]; ?>
            </p>
            <?php if ($disable != "y"): ?>
                <p>
                    <i class="fa fa-edit contactedit text-success" style="cursor:pointer" onclick="contact_modal('edit', '<?= $contact["reference"]; ?>', '<?= $contact["reference_id"]; ?>', '<?= $contact["id"]; ?>')"title="Edit this contact info"></i>
                    &nbsp;&nbsp;<i class="fa fa-trash contactdelete text-danger" style="cursor:pointer" onclick="contact_delete('<?= $contact["reference"]; ?>', '<?= $contact["reference_id"]; ?>', '<?= $contact["id"]; ?>')" title="Remove this contact info"></i>
                </p>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
<input type="hidden" title="Contact Info" id="contact-list-count" <?= ($disable != "y") ? 'required="required"' : ''; ?> value="<?= count($list) != 0 ? count($list) : ""; ?>">
<div class="errorMessage text-danger"></div>
<?php if ($disable == "y"): ?>
    <script>
        $(function () {
    //            $(".contactedit").addClass('dcedit');
    //            $(".contactdelete").addClass('dcdelete');
        });
    </script>
<?php endif; ?>
