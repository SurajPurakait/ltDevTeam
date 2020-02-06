<div class="row">
    <div class="col-md-10">
        <div id="select_peroid_billing" class="pull-left"></div>
        <table class="table table-bordered billing-report-table table-striped text-center m-b-0" id="report-billing-invoice">
            <thead>
                <tr>
                    <th class="text-uppercase" style="white-space: nowrap;">Office</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Total Invoice</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Amount</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Collected</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Unpaid</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Partial</th>
                    <th class="text-uppercase" style="white-space: nowrap;">Paid</th>
                    <th class="text-uppercase" style="white-space: nowrap;">< 30</th>
                    <th class="text-uppercase" style="white-space: nowrap;">< 60</th>
                    <th class="text-uppercase" style="white-space: nowrap;">+ 60</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($billing_report_list as $brl) {
                ?>                
                <tr>   
                    <td><?= $brl['office'] ?></td>
                    <td><?= $brl['total_invoice'] ?></td>
                    <td><?= round($brl['total_amount']) ?></td>
                    <td><?= round($brl['amount_collected']) ?></td>
                    <td><?= ($brl['total_invoice']) ? round((((int)$brl['unpaid'] * 100) / (int)$brl['total_invoice']))."%": '0%'; ?></td>
                    <td><?= ($brl['total_invoice'] != 0 ) ? round((((int)$brl['paid'] * 100) / (int)$brl['total_invoice']))."%" : '0%'; ?></td>
                    <td><?= ($brl['total_invoice'] != 0) ? round((((int)$brl['partial'] * 100) / (int)$brl['total_invoice']))."%" :'0%'; ?></td>
                    <td><?= $brl['less_than_30'] ?></td>
                    <td><?= $brl['less_than_60'] ?></td>
                    <td><?= $brl['more_than_60'] ?></td>
                </tr>
                <?php        
                    } 
                ?>
                <tr>
                    <td>Total</td>
                    <td><?= $totals['total_no_of_invoice'] ; ?></td>
                    <td><?= round($totals['total_amounts']) ; ?></td>
                    <td><?= round($totals['total_amount_collected']) ; ?></td>
                    <td><?= round($totals['total_unpaid'])."%" ; ?></td>
                    <td><?= round($totals['total_partial'])."%" ; ?></td>
                    <td><?= round($totals['total_paid'])."%" ; ?></td>
                    <td><?= $totals['total_less_than_30'] ; ?></td>
                    <td><?= $totals['total_less_than_60'] ; ?></td>
                    <td><?= $totals['total_more_than_60'] ; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-2" style="margin-top: 80px">
        <h4 class="text-center">Offices</h4>
    <?php 
        foreach ($reports as $key => $value) {
            $data_id = array_column($billing_report_list,'id');        
            $data_total = array_column($billing_report_list,'total_invoice');
            $data = array_combine($data_id, $data_total);        
    ?>
    <div class="billing-franchise-donut-<?= $key ?> text-center" data-size="100" id="billing_franchise_donut_<?= $key ?>" data-json="billing_franchise_data_<?= $key ?>"></div>
    
    <script>
        var billing_franchise_data_<?= $key ?> = [
            {'section_label': 'Contador Fort Lauderdale ', 'value': <?= $data[34]; ?>, 'color': '#FFB046'}, 
            {'section_label': 'Contador Miami ', 'value': <?= $data[1]; ?>, 'color': '#06a0d6'}, 
            {'section_label': 'Contador Orlando', 'value': <?= $data[44]; ?>, 'color': '#ff8c1a'},
            {'section_label': 'Contador Sunny Isles', 'value':<?= $data[18];?>, 'color': '#009900'},
            {'section_label': 'Corporate', 'value':<?= $data[17];?>, 'color': '#663300'},
            {'section_label': 'LeafNet Office', 'value':<?= $data[41];?>, 'color': '#ff66cc'},
            {'section_label': 'Nalogi Miami', 'value':<?= $data[32];?>, 'color': '#ffdb4d'},
            {'section_label': 'TaxLeaf Aventura', 'value':<?= $data[30];?>, 'color': '#00ff99'},
            {'section_label': 'TaxLeaf Coral Gables', 'value':<?= $data[25];?>, 'color': '#99ff99'},
            {'section_label': 'TaxLeaf Coral Springs', 'value':<?= $data[29];?>, 'color': '#669900'},
            {'section_label': 'TaxLeaf Doral', 'value':<?= $data[22];?>, 'color': '#ffcc00'},
            {'section_label': 'Taxleaf DSM', 'value':<?= $data[39];?>, 'color': '#99ff66'},
            {'section_label': 'TaxLeaf Fort Lauderdale', 'value':<?= $data[26];?>, 'color': '#66ffff'},
            {'section_label': 'TaxLeaf Hallandale', 'value':<?= $data[24];?>, 'color': '#ff8c66'},
            {'section_label': 'TaxLeaf Hialeah', 'value':<?= $data[28];?>, 'color': '#e600ac'},
            {'section_label': 'TaxLeaf Kendall', 'value':<?= $data[27];?>, 'color': '#aaaa55'},
            {'section_label': 'TaxLeaf Lake Mary', 'value':<?= $data[31];?>, 'color': '#ff9900'},
            {'section_label': 'TaxLeaf Miramar', 'value':<?= $data[23];?>, 'color': '#004de6'},
            {'section_label': 'TaxLeaf North Miami Beach', 'value':<?= $data[19];?>, 'color': '#993333'},
            {'section_label': 'TaxLeaf Pembroke Pines', 'value':<?= $data[20];?>, 'color': '#003300'}
        ];                    
    </script>
    <script>
         pieChart('billing-franchise-donut-<?= $key ?>');
    </script>
    <?php
         }
    ?>
    <h4 class="m-t-40 text-center">Status</h4>
    <?php
      foreach ($reports as $key => $value) {
        $paid = array_sum(array_column($billing_report_list,'paid'));
        $unpaid = array_sum(array_column($billing_report_list,'unpaid')); 
        $partial = array_sum(array_column($billing_report_list,'partial'));          
    ?>
    <div class="billing-tracking-donut-<?= $key ?> text-center" data-size="100" id="billing_tracking_donut_<?= $key ?>" data-json="billing_tracking_data_<?= $key ?>"></div>
    
    <script>
        var billing_tracking_data_<?= $key ?> = [
            {'section_label': 'Unpaid ', 'value': <?= $paid; ?>, 'color': '#1c84c6'}, 
            {'section_label': 'Paid ', 'value': <?= $unpaid; ?>, 'color': '#f8ac59'}, 
            {'section_label': 'Partial', 'value': <?= $partial; ?>, 'color': '#1ab394'},
        ];                    
    </script>
    <script>
        pieChart('billing-tracking-donut-<?= $key ?>');
    </script>
    <?php
        }
    ?>
</div>
</div>
<script type="text/javascript">
    $('#report-billing-invoice').DataTable().destroy();
    $('#report-billing-invoice').DataTable({
        'dom': '<"html5buttons"B>lTfgitp',
        'buttons': [ 
            {extend: 'excel', title: 'InvoicePaymentReport'},
            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                },
                title: '',
                messageTop: function () {
                    return '<h2 style="color:#8ab645;text-align:center;font-weight:bold;margin-bottom:10px">Invoice Payment Report</h2>';
                }
            }
        ],
        "bFilter": false,
        "paging":   false,
        "ordering": false,
        "info":     false

    });
</script>