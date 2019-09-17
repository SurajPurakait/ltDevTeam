<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" href="javascript:void(0);"
                   onclick="show_company_modal('add', '');"><i class="fa fa-plus"></i> Add Company Type</a>
                <div class="ibox-content m-t-10">
                    <div class="">
                        <table id="company-tab" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Company Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            if (isset($company_list) && count($company_list) > 0) {
                                foreach ($company_list as $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $value['type']; ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="editmodal edit_service"
                                               onclick="show_company_modal('edit', '<?php echo $value['id']; ?>');"
                                               title="EDIT"><i
                                                    class="fa fa-edit"></i></a>&nbsp;
                                            <a href="javascript:void(0);" title="DELETE"
                                               onclick="delete_company('<?php echo $value['id'] ?>');"><i
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

<div id="company-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($company_list) && count($company_list) > 0) { ?>
            if ($('#company-tab').length > 0) {
                $("#company-tab").dataTable();
            }
<?php } ?>
    });
</script>