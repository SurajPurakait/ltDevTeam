<?php
$office_info = get_office_info_by_id($order_summary['office_id']);
if ($export_type == 'email') {
    ?>
    <div class="invoice preview">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox-content p-xl">
                <div class="table-responsive">    
                    <table width="100%">
                        <tr>
                            <td width="50%" class="p-r-5">
                                <h4 style="margin-bottom: 0;">ORDER ID:</h4>
                                <h4 class="text-navy m-b-20"><?= $order_summary['invoice_id']; ?></h4>
                            </td>
                            <td align="right" class="p-l-5">
                                <h5 style="margin-bottom: 0;">Invoice Date:</h5>
                                <p><span><?php echo date("m/d/Y", strtotime($order_summary["created_time"])); ?></span></p>                        
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" class="p-r-5">
                                <h5>From:</h5><br/>
                                <address>
                                    <strong><?= $office_info['name']; ?></strong><br>
                                    <?= $office_info['address']; ?><br>
                                    <?= $office_info['state_name']; ?>, <?= $office_info['city']; ?> <?= $office_info['zip']; ?><br>
                                    <abbr title="Phone">P:</abbr><?= $office_info['phone']; ?><br/>
                                    <?php if ($office_info['fax'] != '') { ?><abbr title="Fax">F:</abbr> <?php
                                        echo $office_info['fax'];
                                    }
                                    ?>
                                </address>
                            </td>
                            <td align="right" valign="top" class="p-l-5">
                                <span>To:</span><br/>
                                <address>
                                    <strong><?= $order_summary["invoice_type_id"] == 1 ? $order_summary["name_of_company"] : $order_summary["individual_name"]; ?></strong><br>
                                    <?php
                                    $i = 0;
                                    foreach ($order_summary["contact_info"] as $contact_info) {
                                        if ($contact_info['type_id'] == 3) {
                                            echo $contact_info["address1"];
                                            ?><br>
                                            <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                            <abbr title="Phone">P:</abbr> <?= $contact_info["phone1"] ?>
                                            <?php
                                            $i++;
                                            break;
                                        }
                                    }
                                    foreach ($order_summary["contact_info"] as $contact_info) {
                                        if ($contact_info['type_id'] == 1 && $i == 0) {
                                            echo $contact_info["address1"];
                                            ?><br>
                                            <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                            <abbr title="Phone">P:</abbr> <?= $contact_info["phone1"] ?>
                                            <?php
                                            $i++;
                                            break;
                                        }
                                    }
                                    foreach ($order_summary["contact_info"] as $contact_info) {
                                        if ($i == 0) {
                                            echo $contact_info["address1"];
                                            ?><br>
                                            <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                            <abbr title="Phone">P:</abbr> <?= $contact_info["phone1"] ?>
                                            <?php
                                            break;
                                        }
                                    }
                                    ?>
                                </address>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive"> 
                    <table class="table invoice-table m-b-5">
                        <thead>
                            <tr>
                                <th style="text-align: left;">ORDER#</th>
                                <!-- <th style="text-align: right;">Retail Price</th> -->
                                <th style="text-align: right;">Price</th>
                                <th style="text-align: right;">Quantity</th>
                                <th style="text-align: right;">Final Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($order_summary["services"] as $services_info) {
                                echo '<tr>';
                                echo '<td>' . $services_info['service'] . '</td>';
                                //echo '<td style="text-align: right;">' . $services_info['retail_price'] . '</td>';
                                echo '<td style="text-align: right;">' . ($services_info['override_price'] != '' ? $services_info['override_price'] : $services_info['retail_price']) . '</td>';
                                echo '<td style="text-align: right;">' . $services_info['quantity'] . '</td>';
                                echo '<td style="text-align: right;">' . $services_info['sub_total'] . '</td>';
                                echo '</tr>';
                            }
                            ?> 
                        </tbody>
                    </table>
                </div>    
                <hr class="m-0"/>
                <div class="table-responsive">     
                    <table class="table invoice-total">
                        <tbody>
                            <tr>
                                <td style="text-align: right;"><strong>TOTAL :</strong></td>
                                <td style="text-align: right; width: 15%;">$<?= $order_summary["sub_total"] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php if (count($order_summary['invoice_notes']) != 0): ?>
                    <h3><b>Invoice Notes</b></h3><hr>
                    <?php foreach ($order_summary['invoice_notes'] as $value):
                        ?>
                        <p>                        
                        <?= $value['note']; ?><hr>
                        </p>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
<?php } else if ($export_type == 'download') { ?>
    <br/>
    <?php if ($order_summary['office_photo'] != '') { ?>
        <p><img src="<?= file_exists(FCPATH . 'uploads/' . $order_summary['office_photo']) ? base_url('uploads/' . $order_summary['office_photo']) : base_url('assets/img/logo.png'); ?>" height="40" /></p>
    <?php } else { ?>
        <p><img src="<?= base_url() ?>assets/img/logo.png" height="40" /></p>
    <?php } ?>
    <div class="table-responsive">    
        <table width="100%">
            <tr>
                <td width="50%">
                    <h4 style="margin-bottom: 0;"><b>ORDER ID:</b> <?= $order_summary['invoice_id']; ?></h4>
                </td>
                <td align="right">
                    <p style="margin-bottom: 0;"><b>Invoice Date:</b> <?php echo date("m/d/Y", strtotime($order_summary["created_time"])); ?></p>
                </td>
            </tr>
            <tr>
                <td width="50%" valign="top" class="p-r-5">
                    <p>From:</p><p><strong><?= $office_info['name']; ?></strong><br/><?= $office_info['address']; ?><br/><?= $office_info['state_name']; ?>, <?= $office_info['city']; ?> <?= $office_info['zip']; ?><br/><abbr title="Phone"><strong style="color:#de2336">P:</strong></abbr> <?= $office_info['phone']; ?><br/><?php if ($office_info['fax'] != '') { ?><abbr title="Fax"><strong style="color:#089f24">F:</strong></abbr> <?php
                            echo $office_info['fax'];
                        }
                        ?>
                    </p>
                </td>
                <td align="right" valign="top" class="p-l-5">
                    <p>To:</p><p><strong><?= $order_summary["invoice_type_id"] == 1 ? $order_summary["name_of_company"] : $order_summary["individual_name"]; ?></strong><br>
                        <?php
                        $i = 0;
                        foreach ($order_summary["contact_info"] as $contact_info) {
                            if ($contact_info['type_id'] == 3) {
                                echo $contact_info["address1"];
                                ?><br>
                                <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                <strong style="color:#de2336">P:</strong> <?= $contact_info["phone1"] ?><br />
                                <strong>E:</strong> <?= $contact_info["email1"] ?></p>
                            <?php
                            $i++;
                            break;
                        }
                    }
                    foreach ($order_summary["contact_info"] as $contact_info) {
                        if ($contact_info['type_id'] == 1 && $i == 0) {
                            echo $contact_info["address1"];
                            ?><br>
                            <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                            <strong style="color:#de2336">P:</strong> <?= $contact_info["phone1"] ?><br />
                            <strong>E:</strong> <?= $contact_info["email1"] ?></p>
                            <?php
                            $i++;
                            break;
                        }
                    }
                    foreach ($order_summary["contact_info"] as $contact_info) {
                        if ($i == 0) {
                            echo $contact_info["address1"];
                            ?><br>
                            <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                            <strong style="color:#de2336">P:</strong> <?= $contact_info["phone1"] ?><br />
                            <strong>E:</strong> <?= $contact_info["email1"] ?></p>
                            <?php
                            break;
                        }
                    }
                    ?>

                </td>
            </tr>
        </table>
    </div>    
    <p> &nbsp; &nbsp; </p>
    <div class="table-responsive">     
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
            <thead>
                <tr>
                    <th style="text-align: left;"><strong>ORDER#</strong></th>
                    <th style="text-align: right;"><strong>Price</strong></th>
                    <th style="text-align: right;">Quantity</th>
                    <th style="text-align: right;"><strong>Final Price</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($order_summary["services"] as $services_info) {
                    echo '<tr>';
                    echo '<td>' . $services_info['service'] . '</td>';
                    echo '<td align="right">' . ($services_info['override_price'] != '' ? $services_info['override_price'] : $services_info['retail_price']) . '</td>';
                    echo '<td style="text-align: right;">' . $services_info['quantity'] . '</td>';
                    echo '<td style="text-align: right;">' . $services_info['sub_total'] . '</td>';
                    echo '</tr>';
                }
                ?> 
            </tbody>
        </table>
    </div>    
    <hr class="m-0"/>
    <div class="table-responsive">     
        <table width="100%" border="0" cellspacing="0" cellpadding="5" align="right">
            <tbody>
                <tr>
                    <td align="right"><strong>TOTAL :</strong> $<?= $order_summary["sub_total"] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php if (count($order_summary['invoice_notes']) != 0): ?>
        <h3><b>Invoice Notes</b></h3><hr>
        <?php foreach ($order_summary['invoice_notes'] as $value):
            ?>
            <p>                        
            <?= $value['note']; ?><hr>
            </p>
            <?php
        endforeach;
    endif;
    ?>
<?php } else { ?>
    <div class="order_summary" style="display: none;">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.css" />
        <div class="container">
            <div class="table-responsive">
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <h4 style="margin-bottom: 0;">ORDER ID: <span class="text-navy m-b-20"><?= $order_summary['invoice_id']; ?></span></h4>  
                        </td>
                        <td align="right">
                            <h5 style="margin-bottom: 0;"><b>Invoice Date:</b> <span><?php echo date("m/d/Y", strtotime($order_summary["created_time"])); ?></span></h5>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" class="p-r-5">
                            <h5 class="m-b-0">From:</h5>
                            <address>
                                <strong><?= $office_info['name']; ?></strong><br>
                                <?= $office_info['address']; ?><br>
                                <?= $office_info['state_name']; ?>, <?= $office_info['city']; ?> <?= $office_info['zip']; ?><br>
                                <abbr title="Phone">P:</abbr><?= $office_info['phone']; ?><br/>
                                <?php if ($office_info['fax'] != '') { ?><abbr title="Fax">F:</abbr> <?php
                                    echo $office_info['fax'];
                                }
                                ?>
                            </address>
                        </td>
                        <td align="right" valign="top" class="p-l-5">
                            <span>To:</span>
                            <address>
                                <strong><?= $order_summary["invoice_type_id"] == 1 ? $order_summary["name_of_company"] : $order_summary["individual_name"]; ?></strong><br>
                                <?php
                                $i = 0;
                                foreach ($order_summary["contact_info"] as $contact_info) {
                                    if ($contact_info['type_id'] == 3) {
                                        echo $contact_info["address1"];
                                        ?><br>
                                        <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                        <abbr title="Phone">P:</abbr> <?= $contact_info["phone1"] ?>
                                        <?php
                                        $i++;
                                        break;
                                    }
                                }
                                foreach ($order_summary["contact_info"] as $contact_info) {
                                    if ($contact_info['type_id'] == 1 && $i == 0) {
                                        echo $contact_info["address1"];
                                        ?><br>
                                        <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                        <abbr title="Phone">P:</abbr> <?= $contact_info["phone1"] ?>
                                        <?php
                                        $i++;
                                        break;
                                    }
                                }
                                foreach ($order_summary["contact_info"] as $contact_info) {
                                    if ($i == 0) {
                                        echo $contact_info["address1"];
                                        ?><br>
                                        <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                        <abbr title="Phone">P:</abbr> <?= $contact_info["phone1"] ?>
                                        <?php
                                        break;
                                    }
                                }
                                ?>
                                <br>
                            </address>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table-responsive"> 
                <table class="table invoice-table m-b-5" style="width: 100%; border-collapse: collapse; margin-top: 30px;">
                    <thead>
                        <tr>
                            <th style="text-align: left;">ORDER#</th>
                            <!-- <th style="text-align: right;">Retail Price</th> -->
                            <th style="text-align: right;">Price</th>
                            <th style="text-align: right;">Quantity</th>
                            <th style="text-align: right;">Final Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($order_summary["services"] as $services_info) {
                            echo '<tr>';
                            echo '<td>' . $services_info['service'] . '</td>';
                            //echo '<td style="text-align: right;">' . $services_info['retail_price'] . '</td>';
                            //echo '<td style="text-align: right;">' . $services_info['override_price'] . '</td>';
                            echo '<td style="text-align: right;">' . ($services_info['override_price'] != '' ? $services_info['override_price'] : $services_info['retail_price']) . '</td>';
                            echo '<td style="text-align: right;">' . $services_info['quantity'] . '</td>';
                            echo '<td style="text-align: right;">' . $services_info['sub_total'] . '</td>';
                            echo '</tr>';
                        }
                        ?>  
                    </tbody>
                </table>
            </div>    
            <hr class="m-0"/>
            <div class="table-responsive">  
                <table class="table invoice-total" style="width: 100%; border-collapse: collapse;">
                    <tbody>
                        <tr>
                            <td style="text-align: right;"><strong>TOTAL :</strong></td>
                            <td style="text-align: right; width: 15%;">$<?= $order_summary["sub_total"] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if (count($order_summary['invoice_notes']) != 0): ?>
                <h3><b>Invoice Notes</b></h3><hr>
                <?php foreach ($order_summary['invoice_notes'] as $value):
                    ?>
                    <p>                        
                    <?= $value['note']; ?><hr>
                    </p>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="ibox-content m-b-md">
            <?php if ($order_summary['office_photo'] != '') { ?>
                <p><img src="<?php echo base_url() . 'uploads/' . $order_summary['office_photo'] ?>" height="40" /></p>
            <?php } else { ?>
                <p><img src="<?php echo base_url() ?>assets/img/logo.png" height="40" /></p>
            <?php } ?>
            <div class="table-responsive">    
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <h4 style="margin-bottom: 0;">ORDER ID: <?= $order_summary['invoice_id']; ?></h4>
                        </td>
                        <td align="right">
                            <p style="margin-bottom: 0;"><b>Invoice Date:</b> <?php echo date("m/d/Y", strtotime($order_summary["created_time"])); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"> &nbsp;</td>
                    </tr>
                    <tr>
                        <td width="50%" valign="top" class="p-r-5">
                            <p>From:<br/>
                                <strong><?= $office_info['name']; ?></strong><br>
                                <?= $office_info['address']; ?><br>
                                <?= $office_info['state_name']; ?>, <?= $office_info['city']; ?> <?= $office_info['zip']; ?><br>
                                <!-- <a title="Phone"> -->
                                    <strong class="text-danger">P:</strong>
                                <!-- </a> -->
                                 <?= $office_info['phone']; ?><br/>
                                <?php if ($office_info['fax'] != '') { ?>
                                    <!-- <a title="Fax"> -->
                                        <strong class="text-navy">F:</strong>
                                    <!-- </a> -->
                                    <?php echo $office_info['fax'];
                                }
                                ?>
                            </p>
                        </td>
                        <td align="right" valign="top" class="p-l-5">
                            <p>To:<br/><strong><?= $order_summary["invoice_type_id"] == 1 ? $order_summary["name_of_company"] : $order_summary["individual_name"]; ?></strong><br>
                                <?php
                                $i = 0;
                                foreach ($order_summary["contact_info"] as $contact_info) {
                                    if ($contact_info['type_id'] == 3) {
                                        echo $contact_info["address1"];
                                        ?><br>
                                        <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                        <strong>P:</strong> <?= $contact_info["phone1"] ?></p>
                                    <?php
                                    $i++;
                                    break;
                                }
                            }
                            foreach ($order_summary["contact_info"] as $contact_info) {
                                if ($contact_info['type_id'] == 1 && $i == 0) {
                                    echo $contact_info["address1"];
                                    ?><br>
                                    <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                    <strong>P:</strong> <?= $contact_info["phone1"] ?></p>
                                    <?php
                                    $i++;
                                    break;
                                }
                            }
                            foreach ($order_summary["contact_info"] as $contact_info) {
                                if ($i == 0) {
                                    echo $contact_info["address1"];
                                    ?><br>
                                    <?php echo $contact_info["country_name"] . ', ' . $contact_info["city"] . ' ' . $contact_info["zip"]; ?><br>
                                    <strong>P:</strong> <?= $contact_info["phone1"] ?></p>
                                    <?php
                                    break;
                                }
                            }
                            ?>

                        </td>
                    </tr>
                </table>
            </div>    
            <p> &nbsp; &nbsp; </p>
            <div class="table-responsive">     
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: left;">ORDER#</th>
                            <!-- <th style="text-align: right;">Retail Price</th> -->
                            <th style="text-align: right;">Price</th>
                            <th style="text-align: right;">Quantity</th>
                            <th style="text-align: right;">Final Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($order_summary["services"] as $services_info) {
                            echo '<tr>';
                            echo '<td>' . $services_info['service'] . '</td>';
                            //echo '<td align="right">' . $services_info['retail_price'] . '</td>';
                            //echo '<td align="right">' . $services_info['override_price'] . '</td>';
                            echo '<td align="right">' . ($services_info['override_price'] != '' ? $services_info['override_price'] : $services_info['retail_price']) . '</td>';
                            echo '<td style="text-align: right;">' . $services_info['quantity'] . '</td>';
                            echo '<td style="text-align: right;">' . $services_info['sub_total'] . '</td>';
                            echo '</tr>';
                        }
                        ?> 

                    </tbody>
                </table>
            </div>    
            <hr class="m-0"/>
            <div class="table-responsive"> 
                <table class="table invoice-total">
                    <tbody>
                        <tr>
                            <td align="right"><strong>TOTAL :</strong> $<?= $order_summary["sub_total"] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if (count($order_summary['invoice_notes']) != 0): ?>
                <h3><b>Invoice Notes</b></h3><hr>
                <?php foreach ($order_summary['invoice_notes'] as $value):
                    ?>
                    <p>                        
                    <?= $value['note']; ?><hr>
                    </p>
                    <?php
                endforeach;
            endif;
            ?>
            <div clas="text-center">
                <?= isset($place) ? $place : ""; ?>
            </div>
        </div>
    </div>
<?php } ?>


<!-- Email modal -->
<div id="emailsending" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
</div>
<!-- End of email modal -->
