<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" href="javascript:void(0);"
                   onclick="show_lead_type_modal('add', '');"><i class="fa fa-plus"></i> Add Type Of Contact Prospect</a>
                <div class="ibox-content m-t-10">
                    <table id="lead-type-tab" class="table table-bordered table-striped">

                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        if (isset($lead_type_list) && count($lead_type_list) > 0) {
                            foreach ($lead_type_list as $value) { ?>
                                <tr>
                                    <td><?php echo $value['name']; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="editmodal edit_service m-r-15"
                                           onclick="show_lead_type_modal('edit', '<?php echo $value['id']; ?>');"
                                           title="EDIT"><i
                                                    class="fa fa-edit"></i></a>&nbsp;
                                        <a href="javascript:void(0);" title="DELETE"
                                           onclick="delete_lead_type('<?php echo $value['id'] ?>');"><i
                                                    class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                            <?php }
                        } else {
                            echo '<tr><th colspan="3">No Data Found</th></tr>';
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="new-lead-type-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if (isset($lead_type_list) && count($lead_type_list) > 0) { ?>
        if ($('#lead-type-tab').length > 0) {
            $("#lead-type-tab").dataTable();
        }
        <?php } ?>
    });
</script>