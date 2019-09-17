<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" href="javascript:void(0);"
                   onclick="show_operational_main_cat_modal('add', '');"><i class="fa fa-plus"></i> Add Main Category</a>
                <div class="ibox-content m-t-10">
                    <table id="main-cat-tab" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($main_cat_list) && count($main_cat_list) > 0) {
                                foreach ($main_cat_list as $value) {
                                    ?>
                                    <tr>
                                        <td><?= $value['name']; ?></td>
                                        <td><?= $value['icon']; ?> <i class="fa <?= $value['icon']; ?> fa-2x"></i></td>
                                        <td>
                                            <a href="javascript:void(0);" class="editmodal edit_service" onclick="show_operational_main_cat_modal('edit', '<?= $value['id']; ?>');" title="EDIT"><i class="fa fa-edit"></i></a>&nbsp;
                                            <a href="javascript:void(0);" title="DELETE" onclick="delete_operational_main_cat('<?= $value['id'] ?>');"><i class="fa fa-trash"></i></a>
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
<div id="main-cat-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script type="text/javascript">
    $(document).ready(function () {
        if ($('#main-cat-tab').length > 0) {
            $("#main-cat-tab").dataTable();
        }
    });
</script>