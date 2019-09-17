<?php
$ci = &get_instance();
$ci->load->model('administration');
$ci->load->model('system');
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" id="add_staff" onclick="show_service_modal('add', '');"
                   href="javascript:void(0);"><i class="fa fa-plus"></i> Add New Service</a>
                <div class="ibox-content m-t-10">
                    <div class="">
                        <table id="service-tab" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Category</th>
                            <th>Retail Price</th>
                            <th>Target Start Days</th>
                            <th>Target End Days</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($service_list) && count($service_list) > 0) {
                            foreach ($service_list as $sl) {
                                ?>
                                <tr>
                                    <td><?php echo $sl['description']; ?></td>
                                    <td><?php echo $sl['name']; ?></td>
                                    <td><?php echo $sl['catname']; ?></td>
                                    <td><?php echo $sl['retail_price']; ?></td>
                                    <td><?php echo $sl['start_days']; ?></td>
                                    <td><?php echo $sl['end_days']; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="editmodal edit_service" onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');" title="EDIT"><i class="fa fa-edit"></i></a>&nbsp;
                                        <!--<a href="javascript:void(0);" title="DELETE" onclick="delete_service('<?php echo $sl['id'] ?>');"><i class="fa fa-trash"></i></a>-->
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><th colspan="6">No Data Found</th></tr>';
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

<div id="service-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if (isset($service_list) && count($service_list) > 0) { ?>
        if ($('#service-tab').length > 0) {
            $("#service-tab").dataTable();
        }
        <?php } ?>
    });
</script>
