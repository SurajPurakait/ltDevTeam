<div class="wrapper wrapper-content m-t-0">
    <div class="ibox-content">
        <h2 class="p-b-25"><b>Mail Campaign Template</b></h2>
        <div class="mail-campaign-wrap" id="mail_campaign_wrap">
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="newsletter-box" <?= $is_campaign == 'n' ? 'style="opacity: 0.5;filter: alpha(opacity=50);"' : ''; ?> onclick="displayMailCampaignTemplate(<?= base64_decode($lead_id); ?>, 1, '<?= $is_campaign; ?>');" data-toggle="modal">
                        <img src="<?= base_url() . "assets/img/newsletter.jpg"; ?>"/>
                        <div class="newsletter-overlay overlay-bg1">Day 0</div>
                    </div> 
                </div>
                <div class="col-md-3 text-center">
                    <div class="newsletter-box" <?= $is_campaign == 'n' ? 'style="opacity: 0.5;filter: alpha(opacity=50);"' : ''; ?> onclick="displayMailCampaignTemplate(<?= base64_decode($lead_id); ?>, 2, '<?= $is_campaign; ?>');" data-toggle="modal">
                        <img src="<?= base_url() . "assets/img/newsletter.jpg"; ?>"/>
                        <div class="newsletter-overlay overlay-bg2">Day 3</div>
                    </div> 
                </div>
                <div class="col-md-3 text-center">
                    <div class="newsletter-box" <?= $is_campaign == 'n' ? 'style="opacity: 0.5;filter: alpha(opacity=50);"' : ''; ?> onclick="displayMailCampaignTemplate(<?= base64_decode($lead_id); ?>, 3, '<?= $is_campaign; ?>');" data-toggle="modal">
                        <img src="<?= base_url() . "assets/img/newsletter.jpg"; ?>"/>
                        <div class="newsletter-overlay overlay-bg3">Day 6</div>
                    </div> 
                </div>
            </div>
        </div>
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