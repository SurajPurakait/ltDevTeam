<?php
$added_by = staff_info_by_id($sales_tax_process_dtls['added_by_user']);
$client_name = get_client_name($sales_tax_process_dtls['client_id']);
$states = state_info($sales_tax_process_dtls["state_id"]);
$county = get_county_name($sales_tax_process_dtls['county_id']);
if ($sales_tax_process_dtls['period_of_time'] == 'm') {
    $period_of_time = 'Monthly';
    $yearval = $sales_tax_process_dtls['period_of_time_yearval'];
} elseif ($sales_tax_process_dtls['period_of_time'] == 'q') {
    $period_of_time = 'Quarterly';
    $yearval = $sales_tax_process_dtls['period_of_time_yearval'];
} else {
    $period_of_time = 'Yearly';
    $yearval = '';
}
?>
<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md">
        <h2 class="m-b-20">Sales Tax Processing Details</h2>
        <?php $style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"'; ?>
        <table class="table table-striped table-bordered" style="width:100%;">
            <tbody>
                <tr>
                    <td <?= $style; ?>>
                        Client Name
                    </td>
                    <td <?= $style; ?>>
                        <?= $client_name['name'] ?>
                    </td>
                </tr>
                <tr>
                    <td <?= $style; ?>>
                        Added By
                    </td>
                    <td <?= $style; ?>>
                        <?= $added_by['last_name'] . ' ' . $added_by['first_name'] ?>
                    </td>
                </tr>
                <tr>
                    <td <?= $style; ?>>
                        State
                    </td>
                    <td <?= $style; ?>>
                        <?= $states["state_name"] ?>
                    </td>
                </tr>
                <tr>
                    <td <?= $style; ?>>
                        County
                    </td>
                    <td <?= $style; ?>>
                        <?= $county["name"] ?>
                    </td>
                </tr>
                <tr>
                    <td <?= $style; ?>>
                        Rate
                    </td>
                    <td <?= $style; ?>>
                        <?= $sales_tax_process_dtls['rate']; ?>
                    </td>
                </tr>
                <tr>
                    <td <?= $style; ?>>
                        Gross Sales
                    </td>
                    <td <?= $style; ?>>
                        <?= $sales_tax_process_dtls['gross_sales']; ?>
                    </td>
                </tr>
                <tr>
                    <td <?= $style; ?>>
                        Sales Tax Collect
                    </td>
                    <td <?= $style; ?>>
                        <?= $sales_tax_process_dtls['sales_tax_collect']; ?>
                    </td>
                </tr>
                <tr>
                    <td <?= $style; ?>>
                        Collect Allowance
                    </td>
                    <td <?= $style; ?>>
                        <?= $sales_tax_process_dtls['collect_allowance'] ?>
                    </td>
                </tr>
                <tr>
                    <td <?= $style; ?>>
                        Total Due
                    </td>
                    <td <?= $style; ?>>
                        <?= $sales_tax_process_dtls['total_due'] ?>
                    </td>
                </tr>
                <tr>
                    <td <?= $style; ?>>
                        Period Of Time
                    </td>
                    <td <?= $style; ?>>
                        <?= $period_of_time ?>
                    </td>
                </tr>
                <?php if ($sales_tax_process_dtls['period_of_time'] != 'y') { ?>
                    <tr>
                        <td <?= $style; ?>>
                            Year
                        </td>
                        <td <?= $style; ?>>
                            <?= $yearval ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td <?= $style; ?>>
                        Confirmation Number
                    </td>
                    <td <?= $style; ?>>
                        <?= ($sales_tax_process_dtls['confirmation_number'] != '') ? $sales_tax_process_dtls['confirmation_number'] : 'N/A'; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>