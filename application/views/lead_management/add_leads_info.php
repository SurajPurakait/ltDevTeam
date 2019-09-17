<?php foreach ($lead_info_list as $lead): ?>

    <div id="lead_info_div_<?= $lead["id"] ?>" class="row">
        <div class="col-lg-10 col-lg-offset-2" style="padding-top:8px">
            <p>
                <b></b><?= $lead["last_name"]." ," .$lead["first_name"] ?><br>
                <!-- <b>Last Name:</b><?//= $lead["last_name"]; ?><br>  -->
                <b>Email:</b> <?= $lead["email"]; ?><br>
                <b>Phone:</b> <?= $lead["phone1"]; ?><br>
                <b>Company:</b> <?= $lead["company_name"]; ?><br>
                <!-- <b>Language:</b> <?//= $lead["language"]; ?><br> -->
                <!-- <input type="hidden" name="event_id[]" value="<?//= $lead["id"]; ?>"> -->
            </p>

            <p>
                <i class="fa fa-edit contactedit" style="cursor:pointer"
                   onclick="add_leads_modal('edit', '<?= $lead["id"]; ?>')"
                   title="Edit this addlead info"></i>
                <!-- &nbsp;&nbsp;
                <i class="fa fa-trash contactdelete text-danger" style="cursor:pointer"
                    onclick="delete_buyer(<?//= $buyer["id"]; ?>)" title="Remove this buyer info"></i> -->
            </p>
        </div>
    </div>

<?php endforeach; ?>
<?php if (count($lead_info_list) == 0) { ?>
    <input type="hidden" name="addlead_info" id="addlead_info" value="" required title="lead Info">
<?php } else { ?>
    <input type="hidden" name="addlead_info" value="<?php echo count($lead_info_list); ?>" required="" id="addlead_info" title="lead Info">
<?php } ?>
<div class="errorMessage text-danger"></div>