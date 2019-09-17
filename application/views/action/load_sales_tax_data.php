<?php
$staff_info = staff_info();
$staff_id = sess('user_id');
$staff_dept = $staff_info['department'];
$stafftype = $staff_info['type'];
$staffrole = $staff_info['role'];
$staff_department = explode(',', $staff_info['department']);
if (!empty($sales_tax_process)) {
    foreach ($sales_tax_process as $key => $value):
        $client_name = get_client_name($value['client_id']);
        $states = state_info($value["state_id"]);
        $county = get_county_name($value['county_id']);
        $added_by = staff_info_by_id($value['added_by_user']);
        if ($value['status'] == 0) {
            $status = 'New';
        } elseif ($value['status'] == 1) {
            $status = 'Started';
        } else {
            $status = 'Completed';
        }
        if ($value['period_of_time'] == 'm') {
            $period_of_time = 'Monthly';
        } elseif ($value['period_of_time'] == 'q') {
            $period_of_time = 'Quarterly';
        } else {
            $period_of_time = 'Yearly';
        }
        $note_count = getNoteCount('sales_tax_process', $value["id"]);
        ?>
        <div class="panel panel-default service-panel type2 filter-active">
            <div class="panel-heading">
                <a href="<?= base_url("/action/home/view_sales_process/{$value["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-view"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                <?php if ($stafftype == 1 || ($stafftype == 2 && (in_array(6, $staff_department))) || ($stafftype == 3 && ($staffrole == 2 || $value['added_by_user'] == $staff_id))) { ?>
                    <a href="<?= base_url("/action/home/edit_sales_tax_process/" . $value["id"]); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                <?php } ?>
                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse89" aria-expanded="false">
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th style="width:120px;">Sales Tax ID</th>
                                    <th style="width:120px;">Client Name</th>
                                    <th style="width:120px;">Added By</th>
                                    <th>State</th>
                                    <th>County</th>
                                    <th>Tracking</th>
                                    <th>Rate</th>
                                    <th>Gross Sales</th>
                                    <th>Sales Tax Collect</th>
                                    <th>Collect Allowance</th>
                                    <th>Total Due</th>
                                    <th>Period Of Time</th>
                                    <th>Note</th>
                                </tr>
                                <tr>
                                    <td title="Sales Tax ID">#<?= $value["id"]; ?></td>
                                    <td title="Client Name"><?= $client_name['name'] ?></td>
                                    <td title="Added By"><?= $added_by['last_name'] . ' ' . $added_by['first_name'] ?></td>
                                    <td title="State"><?= $states["state_name"]; ?></td>
                                    <td title="County"><?= $county["name"]; ?></td>
                                    <td align='left' title="Tracking Description">
                                        <?php if ($stafftype == 1 || ($stafftype == 2 && (in_array(6, $staff_department))) || ($stafftype == 3)) { ?>
                                            <a href='javascript:void(0);' onclick='show_sales_process_tracking_modal("<?= $value["id"]; ?>")'>
                                                <span class='label label-primary'><?= $status; ?></span>
                                            </a>
                                        <?php } else if ($status != 2 && in_array(8, $staff_department)) {
                                            ?>
                                            <a href='javascript:void(0);' onclick='show_sales_process_tracking_modal("<?= $value["id"]; ?>")'>
                                                <span class='label label-primary'><?= $status; ?></span>
                                            </a>
                                        <?php } else {
                                            ?> 
                                            <a href='javascript:void(0);'>
                                                <span class='label label-primary'><?= $status; ?></span>
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td title="Rate"><?= round($value['rate'], 2); ?></td>
                                    <td title="Gross Sales"><?= round($value['gross_sales'], 2); ?></td>
                                    <td title="Sales Tax Collect"><?= round($value['sales_tax_collect'], 2); ?></td>
                                    <td title="Collect Allowance"><?= round($value['collect_allowance'], 2); ?></td>
                                    <td title="Total Due"><?= round($value['total_due'], 2); ?></td>
                                    <td title="Period Of Time"><?= $period_of_time; ?></td>
                                    <td title="Notes">
                                        <span>
                                            <?php if ($note_count > 0): ?>
                                                <a class="label label-warning" href="javascript:void(0)" onclick="show_salestax_process_notes('sales_tax_process', '<?= $value['id']; ?>');">
                                                    <b><?= $note_count; ?></b>
                                                </a>
                                            <?php else: ?>   
                                                <b class="label label-warning"><?= $note_count; ?></b>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </h5>
            </div>
        </div>
    <?php endforeach; ?>
<?php } else { ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i> 
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
<?php } ?>
