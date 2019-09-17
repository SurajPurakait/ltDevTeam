<?php
$ci = &get_instance();
$ci->load->model('administration');
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" id="add_dept" onclick="show_department_modal();"
                   href="javascript:void(0);"><i class="fa fa-plus"></i> Add Department</a>
                <div class="ibox-content m-t-10">
                    <div class="">
                        <table id="service-tab" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Department</th>
                            <th>Manager Name</th>
                            <th>Phone</th>
                            <th>Extension</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($department_list) && count($department_list) > 0) {
                            foreach ($department_list as $dl) {
                                $dept_mngr = get_dept_mngr($dl['id']);
                                ?>
                                <tr>
                                    <td><?php echo $dl['name']; ?></td>
                                    <td><?php echo $dept_mngr; ?></td>
                                    <td><?php echo $dl['phone']; ?></td>
                                    <td><?php echo $dl['extension']; ?></td>
                                    <td><?php echo $dl['email']; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="editmodal edit-dept"
                                           onclick="edit_department('<?php echo $dl['id']; ?>');" title="EDIT"><i
                                                    class="fa fa-edit"></i></a>&nbsp;
                                        <a href="javascript:void(0);" title="DELETE"
                                           onclick="delete_department('<?= $dl['id']; ?>');"><i
                                                    class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                                <?php
                            }
                        } else {
                            echo '<tr><th colspan="4">No Data Found</th></tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>    
                </div><!-- ./ibox-content -->
            </div><!-- ./ibox float-e-margins -->
        </div><!-- ./col-md-12 -->
    </div><!-- ./row -->

</div>

<div id="edit-dept-form" class="modal fade" aria-hidden="true" style="display: none;">
</div>
<div id="department-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if (isset($department_list) && count($department_list) > 0) { ?>
        if ($('#service-tab').length > 0) {
            $("#service-tab").dataTable();
        }
        <?php } ?>
    });
</script>

