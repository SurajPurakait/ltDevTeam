<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" href="javascript:void(0);"
                   onclick="show_operational_sub_cat_modal('add', '');"><i class="fa fa-plus"></i> Add Sub Category</a>
                <div class="ibox-content m-t-10">
                    <table id="sub-cat-tab" class="table table-bordered table-striped">

                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Sub Category Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        if (isset($sub_cat_list) && count($sub_cat_list) > 0) {
                            foreach ($sub_cat_list as $value) { ?>
                                <tr>
                                    <td><?php echo $value['name']; ?></td>
                                    <td><?php echo $value['main_cat_name']; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="editmodal edit_service"
                                           onclick="show_operational_sub_cat_modal('edit', '<?php echo $value['id']; ?>');"
                                           title="EDIT"><i
                                                    class="fa fa-edit"></i></a>&nbsp;
                                        <a href="javascript:void(0);" title="DELETE"
                                           onclick="delete_operational_sub_cat('<?php echo $value['id'] ?>');"><i
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

<div id="sub-cat-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if (isset($sub_cat_list) && count($sub_cat_list) > 0) { ?>
        if ($('#sub-cat-tab').length > 0) {
            $("#sub-cat-tab").dataTable();
        }
        <?php } ?>
    });
</script>