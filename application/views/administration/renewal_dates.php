
<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" href="javascript:void(0);"
                   onclick="show_renewal_dates_modal('add', '');"><i class="fa fa-plus"></i> Add Renewal Dates</a>
                <div class="ibox-content m-t-10">
                    <div class="table-responsive">
                        <table id="company-tab" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>State</th>
                                <th>Type Of Company</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            if (isset($renewal_dates) && count($renewal_dates) > 0) {
                                foreach ($renewal_dates as $value) {
                                    $states = state_info($value["state"]);
                                    $company_type = company_type_info($value["type"]);
                                    ?>
                                    <tr>
                                        <td><?php echo $states['state_name']; ?></td>
                                        <td><?php echo $company_type['type']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($value['date'])); ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="editmodal edit_service"
                                               onclick="show_renewal_dates_modal('edit', '<?php echo $value['id']; ?>');"
                                               title="EDIT"><i
                                                    class="fa fa-edit"></i></a>&nbsp;
                                            <a href="javascript:void(0);" title="DELETE"
                                               onclick="delete_renewal_dates('<?php echo $value['id'] ?>');"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>

                                <?php
                                }
                            } else {
                                echo '<tr><th colspan="3">No Data Found</th></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="business-client-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>
