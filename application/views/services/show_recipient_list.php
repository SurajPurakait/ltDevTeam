<?php foreach ($list as $key => $recipient) :       
 ?>
    <div class="row">
        <label class="col-lg-2 control-label"></label>
        <div class="col-lg-10" style="padding-top:8px">
            <p>
                <b>Recipient <?= $key+1 ?> : <?= $recipient["first_name"]; ?> <?= $recipient["last_name"]; ?> </b><br>
                <b>Phone Number: </b><?= ($recipient["recipient_phone_number"] !='') ? $recipient["recipient_phone_number"] : 'NA'; ?><br>
                <b>Address: </b><?= ($recipient["recipient_address"] !='') ? $recipient["recipient_address"] : 'NA'; ?><br>
                <b>City: </b><?= ($recipient["recipient_city"] !='') ? $recipient["recipient_city"] : 'NA'; ?><br>
                <b>State: </b><?= ($recipient["state_name"] !='')? $recipient["state_name"] : 'NA'; ?><br>
                <b>Country: </b><?= ($recipient["country_name"] !='') ? $recipient["country_name"] : 'NA'; ?><br>
                <b>Zip: </b><?= ($recipient["recipient_zip"] !='') ? $recipient["recipient_zip"] : 'NA'; ?><br> 
                <b>TIN: </b><?= ($recipient["recipient_tin"] !='') ? $recipient["recipient_tin"] : 'NA'; ?> 
            </p>
            <p>
                    <i class="fa fa-edit recipientedit text-success" style="cursor:pointer" onclick="recipient_modal('edit', '<?= $recipient["reference"]; ?>', '<?= $recipient["reference_id"]; ?>', '<?= $recipient["id"]; ?>')"title="Edit this recipient info"></i>
                    &nbsp;&nbsp;<i class="fa fa-trash recipientdelete text-danger" style="cursor:pointer" onclick="recipient_delete('<?= $recipient["id"]; ?>', '<?= $recipient["reference_id"]; ?>', '<?= $recipient["reference"]; ?>')" title="Remove this recipient info"></i>
            </p>
            <!-- <?php //if ($disable != "y"): ?>
                <p>
                    <i class="fa fa-edit contactedit text-success" style="cursor:pointer" onclick="contact_modal('edit', '<?//= $contact["reference"]; ?>', '<?//= $contact["reference_id"]; ?>', '<?//= $contact["id"]; ?>')"title="Edit this contact info"></i>
                    &nbsp;&nbsp;
                    <i class="fa fa-trash contactdelete text-danger" style="cursor:pointer" onclick="contact_delete('<?//= $contact["reference"]; ?>', '<?//= $contact["reference_id"]; ?>', '<?//= $contact["id"]; ?>')" title="Remove this contact info"></i>
                </p>
            <?php //endif; ?> -->
        </div>
    </div>
<?php endforeach; ?>
<!-- <input type="hidden" title="Recipient List" id="recipient-list-count" value="<?//= count($list) != 0 ? count($list) : ""; ?>"> -->
<!-- <div class="errorMessage text-danger"></div> -->
<!-- <?php //if ($disable == "y"): ?>
    <script>
        $(function () {
    //            $(".contactedit").addClass('dcedit');
    //            $(".contactdelete").addClass('dcdelete');
        });
    </script>
<?php //endif; ?> -->
<script type="text/javascript">
    $('#recipient_id_list').val(function(i,val) { 
         return val + (!val ? '' : ', ') + '<?= $recipient["id"]; ?>';
    });
</script>