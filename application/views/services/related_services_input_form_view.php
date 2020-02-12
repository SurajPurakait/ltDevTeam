<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <h4>Service Id: <?= $service_id2; ?></h4>
            <h4>Service Name: <?= $service_details['description']; ?></h4>
            <h4>Client Id: <?= $client_id; ?></h4>
            <div class="hr-line-dashed"></div>
        </div>
        <?php $style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"'; ?>
        <table class="table table-striped table-bordered" style="width:100%;">
            <tbody>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>First Name:</b>
                    </td>
                    <td <?= $style; ?>><?= $payer_information['payer_first_name']; ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Last Name:</b>
                    </td>
                    <td <?= $style; ?>><?= $payer_information['payer_last_name']; ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Phone Number:</b>
                    </td>
                    <td <?= $style; ?>><?= $payer_information['payer_phone_number']; ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Address:</b>
                    </td>
                    <td <?= $style; ?>><?= $payer_information['payer_address']; ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>City:</b>
                    </td>
                    <td <?= $style; ?>><?= $payer_information['payer_city']; ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>State:</b>
                    </td>
                    <td <?= $style; ?>><?= $state_name; ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Country:</b>
                    </td>
                    <td <?= $style; ?>><?= $country_name; ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Zip:</b>
                    </td>
                    <td <?= $style; ?>><?= $payer_information['payer_zip']; ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b> TIN (Tax Identification Number):</b>
                    </td>
                    <td <?= $style; ?>><?= $payer_information['payer_tin']; ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b> Recipient's Information:</b>
                    </td>
                    <td <?= $style; ?>><div id="recipient-list"></div></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Attachment:</b>
                    </td>
                    <?php foreach ($related_service_files as $file) :
                                    $file_name = $file['file_name'];
                                    $file_id = $file['id'];?>
                    <td>
                        <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $file_name; ?>');max-width: 100%;">
                            <a href="<?php echo base_url(); ?>uploads/<?= $file_name; ?>" title="<?= $file_name; ?>"><i class="fa fa-download"></i></a>
                        </div>                       
                    </td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Service Note:</b>
                    </td>   
                </tr>
                <?php  endforeach;?>
            </tbody>
        </table>
    </div>       
</div>
<script>
    $(function () {
          <?php if(isset($payer_information['payer_first_name'])){?>
            get_recipient_list('<?= $order_details['reference_id']; ?>', '<?= $reference; ?>');
        <?php } ?>         
    });
</script>