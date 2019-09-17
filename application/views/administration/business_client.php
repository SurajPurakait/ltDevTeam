<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" href="javascript:void(0);"
                   onclick="show_business_client_modal('add', '');"><i class="fa fa-plus"></i> Add Sales Tax Rate</a>
                <div class="ibox-content m-t-10">
                    <div class="table-responsive">
                        <table id="company-tab" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>County</th>
                                <th>State</th>
                                <th>Rate</th>
                                <th>Due On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($business_client) && count($business_client) > 0) {
                                foreach ($business_client as $value) {
                                    $states = state_info($value["state"]);
                                    ?>
                                    <tr>
                                        <td><?= $value['name']; ?></td>
                                        <td><?= $states['state_name']; ?></td>
                                        <td><?= $value['rate']; ?></td>
                                        <td><?= ($value['due_date'] != "0000-00-00" && $value['due_date'] != '') ? date('d', strtotime($value['due_date'])) : 'N/A'; ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="editmodal edit_service" onclick="show_business_client_modal('edit', '<?= $value['id']; ?>');" title="EDIT"><i class="fa fa-edit"></i></a>&nbsp;
                                            <a href="javascript:void(0);" title="DELETE" onclick="delete_business_client('<?= $value['id'] ?>');"><i class="fa fa-trash"></i></a>
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
<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($company_list) && count($company_list) > 0) { ?>
            if ($('#company-tab').length > 0) {
                $("#company-tab").dataTable();
            }
<?php } ?>
    });
</script>