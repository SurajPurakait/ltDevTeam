<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" href="javascript:void(0);"
                   onclick="show_source_modal('add', '');"><i class="fa fa-plus"></i> Add Referred By Source</a>
                <div class="ibox-content m-t-10">
                    <table id="source-tab" class="table table-bordered table-striped">

                        <thead>
                        <tr>
                            <th>Source Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        if (isset($source_list) && count($source_list) > 0) {
                            foreach ($source_list as $value) { ?>
                                <tr>
                                    <td><?php echo $value['source']; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="editmodal edit_service"
                                           onclick="show_source_modal('edit', '<?php echo $value['id']; ?>');"
                                           title="EDIT"><i
                                                    class="fa fa-edit"></i></a>&nbsp;
                                        <a href="javascript:void(0);" title="DELETE"
                                           onclick="delete_source('<?php echo $value['id'] ?>');"><i
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

<div id="source-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if (isset($source_list) && count($source_list) > 0) { ?>
        if ($('#source-tab').length > 0) {
            $("#source-tab").dataTable();
        }
        <?php } ?>
    });
</script>