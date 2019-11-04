<div class="wrapper wrapper-content">
    <div class="m-b-40">
        <form>
            <div class="tabs-container">                   
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-link active"><a href="#lead_general_info" aria-controls="general-info" role="tab" data-toggle="tab">LEAD GENERAL INFO</a></li>
                    <li class="nav-link"><a href="#email_campaign" aria-controls="contact" role="tab" data-toggle="tab">EMAIL CAMPAIGN</a></li>
                    <li class="nav-link"><a href="#other_info" aria-controls="other" role="tab" data-toggle="tab">OTHER INFO</a></li>                                          
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="lead_general_info"> 
                        <div class="panel-body">
                            <?php $style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"'; ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <b style="font-size: 14px;" <?= $style; ?>>Office:</b>
                                            </td>
                                            <td>
                                                <?= get_office_info_by_id($data['office'])['name']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Type of Contact:</b>
                                            </td>
                                            <td>
                                                <?= ($contact['name'] != '') ? $contact['name'] : 'N/A'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Name:</b>
                                            </td>
                                            <td>
                                                <?= $data['last_name'] . ' ' . $data['first_name'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Company Name:</b>
                                            </td>
                                            <td>
                                                <?= $data['company_name'] != '' ? $data['company_name'] : 'N/A'; ?>
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Address:</b>
                                            </td>
                                            <td>
                                                <?= $data['address'] != '' ? $data['address'] : 'N/A'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">City:</b>
                                            </td>
                                            <td>
                                                <?= ($data['city'] != '') ? $data['city'] : 'N/A'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">State:</b>
                                            </td>
                                            <td>
                                                <?= $state['state_name'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Zip Code:</b>
                                            </td>
                                            <td>
                                                <?= ($data['zip'] != '') ? $data['zip'] : 'N/A'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Language:</b>
                                            </td>
                                            <td>
                                                <?= $language['language'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Phone1:</b>
                                            </td>
                                            <td>
                                                <?= $data['phone1'] != '' ? $data['phone1'] : 'N/A'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Phone2:</b>
                                            </td>
                                            <td>
                                                <?= $data['phone2'] != '' ? $data['phone2'] : 'N/A'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%">
                                                <b style="font-size: 14px;" <?= $style; ?>>Email Address:</b>
                                            </td>
                                            <td>
                                                <?= $data['email'] ?>
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td width="20%">
                                                <b style="font-size: 14px;" <?= $style; ?>>Lead Source:</b>
                                            </td>
                                            <td>
                                                <?= $data['last_name'] . ', ' . $data['first_name'] ?>
                                            </td>
                                        </tr>

                                        <?php if ($data['lead_source_detail'] != ''): ?>
                                            <tr>
                                                <td width="20%">
                                                    <b style="font-size: 14px;" <?= $style; ?>>Lead Source Detail:</b>
                                                </td>
                                                <td>
                                                    <?= $data['lead_source_detail']; ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php if ($data['lead_source'] == 7) { ?>
                                            <tr>
                                                <td width="20%" <?= $style; ?>>
                                                    <b style="font-size: 14px;">Lead Client:</b>
                                                </td>
                                                <td>
                                                    <?php echo $data['lead_agent']; ?>
                                                </td>
                                            </tr>
                                        <?php } else if ($data['lead_source'] == 5) { ?>
                                            <tr>
                                                <td width="20%" <?= $style; ?>>
                                                    <b style="font-size: 14px;">Lead Agent:</b>
                                                </td>
                                                <td>
                                                    <?php echo $client_name->first_name . '' . $client_name->last_name; ?>
                                                </td>
                                            </tr>
                                        <?php } else if ($data['lead_source'] == 8) { ?>
                                            <tr>
                                                <td width="20%" <?= $style; ?>>
                                                    <b style="font-size: 14px;">Lead Staff:</b>
                                                </td>
                                                <td>
                                                    <?= (!empty(staff_info_by_id($data['lead_staff']))) ? staff_info_by_id($data['lead_staff'])['full_name'] : "N/A"; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                        <?php if ($partner_showhide != '1') { ?>
                                            <tr>
                                                <td width="20%" <?= $style; ?>>
                                                    <b style="font-size: 14px;">Date Of First Contacts:</b>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($data['date_of_first_contact'] == '0000-00-00') {
                                                        echo 'N/A';
                                                    } else {
                                                        ?>
                                                        <?= date('m/d/Y', strtotime($data['date_of_first_contact'])); ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($assigned_client_id != '') { ?>
                                            <tr>
                                                <td width="20%" <?= $style; ?>>
                                                    <b style="font-size: 14px;">Referred By:</b>
                                                </td>
                                                <td>
                                                    <?= get_assigned_by_staff_name($assigned_client_id); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (count($tracking_logs) != 0 && !empty($tracking_logs)): ?>
                                            <tr>
                                                <td width="20%" <?= $style; ?>>
                                                    <b style="font-size: 14px;">Tracking</b>
                                                </td>
                                                <td class="table-responsive">
                                                    <table class="table table-striped table-bordered" style="width:100%;">
                                                        <tr>
                                                            <th>User</th>
                                                            <th>Department</th>
                                                            <th>Status</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        <?php foreach ($tracking_logs as $value): ?>
                                                            <tr>
                                                                <td><?= $value["stuff_id"]; ?></td>
                                                                <td><?= staff_department_name($value["id"]); ?></td>
                                                                <td><?= $value["status"]; ?></td>
                                                                <td><?= $value["created_time"]; ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </table>
                                                </td>   
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td width="20%" <?= $style; ?>>
                                                    <b style="font-size: 14px;">Tracking</b>
                                                </td>
                                                <td>
                                                    New
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="email_campaign">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:100%;">
                                    <tbody>
                                        <?php if ($partner_showhide != '1') { ?>
                                            <tr>
                                                <td width="20%" <?= $style; ?>>
                                                    <b style="font-size: 14px;">Mail Campaign:</b>
                                                </td>
                                                <td <?= $style; ?>>
                                                    <?= ($data['mail_campaign_status'] == '1') ? 'Active' : 'Inactive'; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Mail Campaign Template:</b>
                                            </td>
                                            <td <?= $style; ?>>
                                                <div class="mail-campaign-wrap" id="mail_campaign_wrap">
                                                    <div class="row">
                                                        <div class="col-md-2 text-center">
                                                            <div class="newsletter-box" <?= $data['mail_campaign_status'] != '1' ? 'style="opacity: 0.5;filter: alpha(opacity=50);"' : ''; ?> onclick="displayMailCampaignTemplate(<?= $data['id']; ?>, 1, '<?= $data['mail_campaign_status'] != '1' ? 'n' : 'y'; ?>');" data-toggle="modal">
                                                                <img src="<?= base_url() . "assets/img/newsletter.jpg"; ?>"/>
                                                                <div class="newsletter-overlay overlay-bg1">Day 0</div>
                                                            </div> 
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <div class="newsletter-box" <?= $data['mail_campaign_status'] != '1' ? 'style="opacity: 0.5;filter: alpha(opacity=50);"' : ''; ?> onclick="displayMailCampaignTemplate(<?= $data['id']; ?>, 2, '<?= $data['mail_campaign_status'] != '1' ? 'n' : 'y'; ?>');" data-toggle="modal">
                                                                <img src="<?= base_url() . "assets/img/newsletter.jpg"; ?>"/>
                                                                <div class="newsletter-overlay overlay-bg2">Day 3</div>
                                                            </div> 
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <div class="newsletter-box" <?= $data['mail_campaign_status'] != '1' ? 'style="opacity: 0.5;filter: alpha(opacity=50);"' : ''; ?> onclick="displayMailCampaignTemplate(<?= $data['id']; ?>, 3, '<?= $data['mail_campaign_status'] != '1' ? 'n' : 'y'; ?>');" data-toggle="modal">
                                                                <img src="<?= base_url() . "assets/img/newsletter.jpg"; ?>"/>
                                                                <div class="newsletter-overlay overlay-bg3">Day 6</div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="other_info">
                        <div class="panel-body">
                            <?php $style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"'; ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:100%;">
                                    <tbody>                                        
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Notes:</b>
                                            </td>
                                            <td <?= $style; ?>>
                                                <?php
                                                foreach($notes as $note){
                                                    if ($note['note'] == '') {
                                                        echo 'N/A';
                                                    } else {
                                                        ?>
                                                        <?= $note['note']; ?><br>
                                                        <?php echo $note['added_at']; ?><br><br>
                                                    <?php 
                                                    } 
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
<div id="mail-campaign-template-modal" class="modal fade newsletter-sec" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mail Campaign Template Review</h4>
            </div>
            <div class="modal-body">
                <table style="width:100%; border-collapse:collapse; font-size: 15px; font-family: arial; " border="0" cellpadding="0" cellspacing="0">
                    <tr style="background: #fff">
                        <td style="padding-bottom: 10px">
                            <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align: left; padding-left: 60px; padding-top: 55px; background: #fff; width: 200px;">
                                        <img src="<?= base_url() . "assets/img/logo.png"; ?>" alt="site-logo" style="width: 200px;">
                                    </td>
                                    <td style="background-image: url('<?= base_url() . "assets/img/top-bg.png"; ?>'); background-repeat: no-repeat; background-position: right; background-size: 242px">
                                        <p style="color: #667581; font-style: italic; text-align: right; padding-right: 65px; padding-top: 65px;">January 10, 2019</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="background: #fff">
                        <td style="padding: 0px">
                            <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align: left; padding: 40px 60px 0 60px;">
                                        <p style="color: #52565a; font-size: 18px;"><strong id="mail-subject"></strong></p>
                                        <p style="color: #52565a; font-size: 16px; line-height: 22px;" id="mail-body"></p>
                                        <p style="color: #52565a; padding-top: 20px; font-size: 18px;"><strong>Thanks, <br/>Team LeafNet</strong></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="background: #fff">
                        <td>
                            <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background-image: url('<?= base_url() . "assets/img/bottom-left-bg.png"; ?>'); background-repeat: no-repeat; background-position: left; background-size: 242px; width: 350px; height: 176px;">
                                        <img src="<?= base_url() . "assets/img/ambulance.png"; ?>" style="padding-left: 60px;"/>
                                    </td>
                                    <td style="background-image: url('<?= base_url() . "assets/img/bottom-right-bg.png"; ?>'); background-repeat: no-repeat; background-position: right; background-size: 242px">
                                        <p style="color: #9dabb6; text-align: left; font-size: 14px;">&COPY; 2019 taxleaf.com</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>