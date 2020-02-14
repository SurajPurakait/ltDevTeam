<?php
// echo "<pre>";
// print_r($contact_info);exit;
$user_info = staff_info();
$user_dept = $user_info['department'];
$usertype = $user_info['type'];
$style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"';
?>
<div class="wrapper wrapper-content">  
    <div class="tabs-container">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a>
            </li>
            <li role="presentation">
                <a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">Contact</a>
            </li>
            <li role="presentation">
                <a href="#other_info" aria-controls="other_info" role="tab" data-toggle="tab">Other</a>
            </li>
            <li role="presentation">
                <a href="#business_info" aria-controls="business_info" role="tab" data-toggle="tab">Business</a>
            </li>
            <li role="presentation">
                <a href="#invoice" aria-controls="invoice" role="tab" data-toggle="tab">Invoice</a>
            </li>
            <li role="presentation">
                <a href="#project" aria-controls="project" role="tab" data-toggle="tab">Project</a>
            </li>
            <li role="presentation">
                <a href="#action" aria-controls="action" role="tab" data-toggle="tab">Action</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">Individual Name</b>
                            </td>
                            <td <?= $style; ?>>
                                <?= $get_individual_data['last_name'] . ', ' . $get_individual_data['first_name'] . ' ' . $get_individual_data['middle_name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">SSN/ITIN</b>
                            </td>
                            <td <?= $style; ?>>
                                <?php if ($get_individual_data['ssn_itin'] == "") { ?>
                                    <?= 'N/A' ?>
                                <?php } else { ?>
                                    <?= $get_individual_data['ssn_itin'] ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">Date of Birth</b>
                            </td>
                            <?php $date = date('m/d/Y', strtotime($get_individual_data['birth_date'])); ?>
                            <td <?= $style; ?>>
                                <?php
                                if ($date == '11/30/-0001') {
                                    echo "unknown";
                                } else {
                                    echo $date;
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <div class="">
                                    <b style="font-size: 15px;">Internal Data</b>
                                </div>
                                <div class="m-l-30">
                                    <b>Office:</b>
                                    <br/>
                                    <b>Partner:</b>
                                    <br/>
                                    <b>Manager:</b>
                                    <br/>
                                    <b>Client Association:</b> 
                                    <br/>
                                    <b>Practice Id:</b>
                                    <br/>
                                    <b>Referred By Source:</b>
                                    <br/>
                                    <b>Referred By Name:</b> 
                                </div>
                            </td>
                            <td <?= $style; ?>>
                                <br>
                                <?= $office['name'] ?>
                                <br>
                                <?= $partner_name['last_name'] . ', ' . $partner_name['first_name'] . ' ' . $partner_name['middle_name']; ?>
                                <br>
                                <?= $manager_name['last_name'] . ', ' . $manager_name['first_name'] . ' ' . $manager_name['middle_name']; ?>
                                <br>
                                <?= ($get_individual_data['client_association'] != '') ? $get_individual_data['client_association'] : '------'; ?>
                                <br>
                                <?= ($get_individual_data['practice_id'] != '') ? $get_individual_data['practice_id'] : '------' ?>
                                <br>
                                <?= $ref_by_src['source']; ?>
                                <br>
                                <?= ($get_individual_data['referred_by_name'] != '') ? $get_individual_data['referred_by_name'] : "------"; ?>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="contact">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                        <tr>
                            <td <?= $style; ?>>
                                Contact Info
                            </td>
                            <td <?= $style; ?>>
                                <?php foreach ($contact_info as $info) { ?>
                                    <b>Contact Type:</b>
                                    <?= $info->type; ?><br>
                                    <b>Contact Name:</b>
                                    <?= $info->last_name . ', ' . $info->first_name . ' ' . $info->middle_name; ?><br>
                                    <b>Phone:</b>
                                    <?= $info->phone1; ?><br>
                                    <b>Email:</b>
                                    <a href="mailto:<?php echo $info->email1 ?>"><?= $info->email1; ?></a><br>

                                    <b>Address:</b>
                                    <?= $info->address1 . ', ' . $info->city . ', ' . $info->state_name . ', ' . $info->country_name; ?>
                                    <br>
                                    <b>Zipcode:</b>
                                    <?= $info->zip; ?><br>
                                    <hr>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="other_info">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                        <tr>
                            <td <?= $style; ?>>
                                Other Info
                            </td>
                            <td <?= $style; ?>>
                                <b>Language:</b>
                                <?= ($language_list['language'] != '') ? $language_list['language'] : 'UNKNOWN'; ?><br>
                                <b>Country Of Residence:</b>
                                <?= ($country_residence['country_name'] != '') ? $country_residence['country_name'] : 'UNKNOWN'; ?><br>
                                <b>Country of Citizenship:</b>
                                <?= ($country_citizenship['country_name'] != '') ? $country_citizenship['country_name'] : 'UNKNOWN'; ?><br>
                            </td>
                        </tr>
                        <tr>
                            <?php if (!empty($notes)) { ?>
                                <td <?= $style; ?>>
                                    Notes
                                </td>
                                <td <?= $style; ?>>
                                    <?php foreach ($notes as $note) { ?>
                                        <?php echo $note['note'] ?>
                                    <?php } ?>
                                </td>
                            <?php } else { ?>
                                <td <?= $style; ?>>
                                    Notes
                                </td>
                                <td <?= $style; ?>>
                                    <?php echo 'N/A'; ?>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if ($attachment['file_name'] != "") { ?>
                                <td <?= $style; ?>>
                                    Attachments
                                </td>
                                <td <?= $style; ?>>
                                    <?php echo $attachment['file_name']; ?>
                                </td>
                            <?php } else { ?>
                                <td <?= $style; ?>>
                                    Attachments
                                </td>
                                <td <?= $style; ?>>
                                    <?php echo 'N/A'; ?>
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div role="tabpanel" class="tab-pane" id="business_info">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                        <?php
                        if (!empty($business_info)) {
                            foreach ($business_info as $bi) {
                                ?>   
                                <tr>
                                    <td>
                                        <b><?php echo $bi['name']; ?></b>
                                    </td>   
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td>
                                    <b>N/A</b>
                                </td>   
                            </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="invoice">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                    <div class="ajaxdiv" id="dashboard_result_div"></div>
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="project">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                    <div class="ajaxdiv" id="action_dashboard_div"></div>
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="action">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                    <div class="ajaxdiv" id="individual_action_dashboard_div"></div>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <button class="btn btn-primary" type="button" onclick="go('action/home/individual_dashboard');" style="width: 250px">Go Back To List</button>        
    </div>
<?php if ($usertype == 1 || $usertype == 2) { ?>
        <div class="col-sm-2 text-center">    
            <a class="btn btn-success" href="<?php echo base_url(); ?>action/home/edit_individual/<?php echo $get_individual_data['id'] ?>" style="width: 170px">Edit Client Info</a>
        </div>
    <div class="col-sm-2 text-center">
        <a class="btn btn-primary" href="<?php echo base_url(); ?>billing/invoice/index/<?php echo base64_encode($get_individual_data['title_id']); ?>/<?= base64_encode(2);?>" style="width: 170px">+ Create Invoice</a>        
    </div>    
    <?php if ($usertype == 1 || $user_dept == 14) { ?>
            <div class="col-sm-2 text-center">
                <a title="INACTIVE" class="btn btn-warning" href="javascript:void(0);" onclick="inactive_individual('<?php echo $get_individual_data["id"]; ?>');" style="width: 170px;">Inactive</a>
            </div>
            <div class="col-sm-3 text-right">    
                <a title="DELETE" class="btn btn-danger" href="javascript:void(0);" onclick="delete_individual('<?php echo $get_individual_data['id']; ?>', 'view-page');" style="width: 250px">Delete</a>
            </div>
        <?php } ?>        
<?php } ?>

</div>
<script>
    loadBillingDashboard('', '', '', '', '<?= $reference_id . '-individual'; ?>');
    loadProjectDashboard('', '', '', '', '', '', '', '', '', '', '2', '<?php echo $get_individual_data["id"] ?>', 'clients');
    loadActionDashboard('', '', '', '', '', '', '','<?= $reference_id . '-individual'; ?>');
</script>