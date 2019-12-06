<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md">
        <?php if ($view_type == 'place'): ?>        
            <h4 class="m-b-20 text-danger">Please Note, review all order information below and click save button to generate the invoice</h4>
        <?php endif; ?>
        <h2 class="m-b-20">ORDER ID: <?= $order_summary['invoice_id']; ?></h2>
        <?php $style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"'; ?>
        <table class="table table-striped table-bordered" style="width:100%;">
            <tbody>
                <?php
                if (!empty($order_summary)):
                    $skip = ['invoice_id', 'reference_id', 'new_existing', 'existing_reference_id', 'contact_info', 'owners', 'documents', 'services', 'total_price', 'individual_id', 'invoice_status', 'invoice_type_id', 'invoice_notes', 'office_photo', 'sub_total', 'office_id', 'is_order', 'order_ID'];
                    foreach ($order_summary as $column => $os):
                        if ($os != ''):
                            if ($column == 'order_id'):
                                $column = 'order_ID';
                            endif;
                            $title = ucwords(str_replace("_", " ", $column));
                            if (!in_array($column, $skip)):
                                ?>
                                <tr>
                                    <td width="300" <?= $style; ?>>
                                        <b><?= $title; ?></b>
                                    </td>
                                    <td <?= $style; ?>>
                                        <?= $os; ?>
                                    </td>
                                </tr>
                                <?php
                            endif;
                            if ($column == 'total_price'):
                                ?>
                                <tr>
                                    <td colspan="2" class="text-right" <?= $style; ?>>
                                        <h3><b><?= $title . ': ' . $order_summary['sub_total']; ?></b></h3>
                                    </td>
                                </tr>
                                <?php
                            endif;
                            if ($column == 'contact_info'):
                                if (count($os) != 0):
                                    ?>
                                    <tr class="bg-light-green">
                                        <td <?= $style; ?>>
                                            <h3><?= $title ?></h3>
                                        </td>
                                        <td <?= $style; ?>>
                                            <?php foreach ($os as $contact) : ?>                                            
                                                <div class="row">                                                
                                                    <div class="col-lg-10" style="padding-top:8px">
                                                        <p>
                                                            <b>Contact Type: <?= $contact["type"]; ?></b>
                                                            <br>
                                                            Name: <?= $contact["first_name"]; ?> <?= $contact["middle_name"]; ?> <?= $contact["last_name"]; ?>
                                                            <br>
                                                            Phone: <?= $contact["phone1"]; ?> (<?= $contact["phone1_country_name"]; ?>)
                                                            <br>
                                                            Email: <?= $contact["email1"]; ?>
                                                            <br>
                                                            Address: 
                                                            <?= $contact["address1"]; ?>, <?= $contact["city"]; ?>,
                                                            <?= $contact["state_name"]; ?>,
                                                            <!-- ZIP:  -->
                                                            <?= $contact["zip"]; ?>, 
                                                            <?= $contact["country_name"]; ?>
                                                        </p>
                                                    </div>
                                                </div>                                                                                    
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                    <?php
                                endif;
                            endif;
                            if ($column == 'owners'):
                                if (count($os) != 0):
                                    ?>
                                    <tr class="bg-light-red">
                                        <td <?= $style; ?>>
                                            <h3><?= $title ?></h3>
                                        </td>
                                        <td <?= $style; ?>>
                                            <?php
                                            foreach ($os as $owner) :
                                                ?>                                            
                                                <div class="row">
                                                    <div class="col-lg-10" style="padding-top:8px">
                                                        <p>
                                                            <b><?= $owner->title ?></b><br>
                                                            Name: <?= $owner->name ?><br>
                                                            Percentage: <?= $owner->percentage ?>%
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                    <?php
                                endif;
                            endif;
                            if ($column == 'documents'):
                                if (count($os) != 0):
                                    ?>
                                    <tr class="bg-light-purple">
                                        <td <?= $style; ?>>
                                            <h3><?= $title ?></h3>
                                        </td>
                                        <td <?= $style; ?>>
                                            <?php
                                            foreach ($os as $document) :
                                                ?>                                            
                                                <div class="row">
                                                    <div class="col-lg-10" style="padding-top:8px">
                                                        <p>
                                                            <b><?= $document['doc_type']; ?></b><br>
                                                            Document: <?= $document["document"]; ?>
                                                        </p>
                                                    </div>
                                                </div>                                                                                    
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                    <?php
                                endif;
                            endif;
                            if ($column == 'services'):
                                if (count($os) != 0):
                                    ?>
                                    <tr>
                                        <td class="theme-green-bg" <?= $style; ?> colspan="2">
                                            <h3 style="color:#fff;"><?= $title ?></h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="theme-green-bg" <?= $style; ?> colspan="2">
                                            <table style="width:100%;">
                                                <?php
                                                $colors = array('bg-light-green', 'bg-blue');
                                                $tracking = [
                                                            1 => 'Not Started',
                                                            2 => 'Started',
                                                            3 => 'Completed',
                                                            7 => 'Canceled'
                                                        ];
                                                foreach ($os as $key => $services) :

                                                    $tracking_class = 'label-danger';
                                                if ($services['status'] == 1) {
                                                    $tracking_class = 'label-success';
                                                } elseif ($services['status'] == 2) {
                                                    $tracking_class = 'label-yellow';
                                                } elseif ($services['status'] == 3) {
                                                    $tracking_class = 'label-primary';
                                                }
                                                    $random_keys = ($key % 2 == 0) ? 0 : 1;
                                                    $order_id = $services['order_id'];
                                                    $service_id = $services['service_id'];
                                                    ?>
                                                    <tr class="<?= $colors[$random_keys]; ?>">
                                                        <td style="border: 1px solid #8ab645; padding-left: 8px;" width="300">
                                                            <div class="row">
                                                                <div class="col-lg-10" style="padding-top:8px">
                                                                    <p>
                                                                        <b>Category: <?= $services['service_category']; ?></b><br>
                                                                        <b>Service:</b> <?= $services["service"]; ?><br>
                                                                        <b>Retail Price:</b> $<?= $services["retail_price"]; ?>.00<br>
                                                                        <b>Override Price:</b> $<?= $services["override_price"]; ?><br>
                                                                        <b>Quantity:</b> <?= $services["quantity"]; ?><br>
                                                                        <b>Total:</b> $<?= number_format((float) $services["override_price"] * $services["quantity"], 2, '.', ''); ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #8ab645; padding-left: 8px;">
                                                            <div class="row">
                                                                <div class="col-lg-12" style="padding-top:8px">
                                                                    <p><b>Tracking:</b>&nbsp;&nbsp;&nbsp;<span class="label <?= $tracking_class ?> invoice-tracking-span-<?= $services['invoice_id']; ?>"><b><?= $tracking[$services['status']]; ?></b></span><br>
                                                                        <b>Notes</b><br>
                                                                        <?php
                                                                        $note_list = invoice_notes($order_id, $service_id);
                                                                        foreach ($note_list as $note):
                                                                            echo $note['note'] . '<hr style="border: 0.5px solid #8ab645;">';
                                                                        endforeach;
                                                                        ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                endif;
                            endif;
                            if ($column == 'invoice_notes'):
                                if (count($os) != 0):
                                    ?>
                                    <tr style="background-color: #b4f0e5;">
                                        <td <?= $style; ?> colspan="2">
                                            <h3><?= $title ?></h3>
                                        </td>
                                    </tr>
                                    <?php
                                    foreach ($os as $note) :
                                        ?>
                                        <tr style="background-color: #b4f0e5;">
                                            <td <?= $style; ?> colspan="2">
                                                <div class="row">
                                                    <div class="col-lg-12" style="padding-top:8px">
                                                        <p>
                                                            <?= $note['note'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                endif;
                            endif;
                        endif;
                    endforeach;
                endif;
                $invoice_recurrence = get_invoice_recurring_details($invoice_id);
                if(!empty($invoice_recurrence)){
                ?>
                                        <tr class="bg-light-green">
                                            <td><h3>Invoice Recurrence</h3></td>
                                            <td><b>Pattern:</b> <?= $invoice_recurrence->pattern  ?><br>
                                                <b>Remaining Generation: </b><?= $invoice_recurrence->total_generation_time  ?><br>
                                                <b>Next Occurance Date: </b><?= $invoice_recurrence->next_occurance_date ?>
                                            </td>
                                        </tr>
                <?php } ?>
            </tbody>
        </table>
        <div clas="text-center">
            <?= isset($place) ? $place : ""; ?>
        </div>
    </div>
</div>