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
                            <th style="width: 15px;">Service Category</th>
                            <th style="width: 15px;">Service Name</th>
                            <!-- <th>Department</th> -->
                            <th style="width: 10px;">Responsible Assigned</th>
                            <th style="width: 10px;">Input Form</th>
                            <th style="width: 10px;">Target Started Days</th>
                            <th style="width: 10px;">Target Completed Days</th>
                            <th style="width: 10px;">Fixed Cost</th>
                            <th style="width: 10px;">Retail Price</th>
                            <th style="width: 10px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($service_list) && count($service_list) > 0) {
                            foreach ($service_list as $sl) {
                                ?>
                                <tr>
                                    <td><?php echo $sl['catname']; ?></td>
                                    <td><?php echo $sl['description']; ?></td>
                                    <td><?php echo $sl['name']; ?></td>
                                    <td><?php echo $sl['input_form']; ?></td> 
                                    <td><?php echo $sl['start_days']; ?></td>
                                    <td><?php echo $sl['end_days']; ?></td>
                                    <td><?php echo $sl['fixed_cost']; ?></td>
                                    <td><?php echo $sl['retail_price']; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="editmodal edit_service" onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');" title="EDIT"><i class="fa fa-edit"></i></a>&nbsp;
                                        <!--<a href="javascript:void(0);" title="DELETE" onclick="delete_service('<?php //echo $sl['id'] ?>');"><i class="fa fa-trash"></i></a>-->

                                        <a href="javascript:void(0);" title="<?= (isset($sl['is_active'])?$sl['is_active'] == 'y' ?'Activate':'Deactivate':'') ?>"onclick="deactive_service('<?= $sl['id'] ?>','<?= isset($sl['is_active'])?$sl['is_active']:''?>');"><i class="<?= isset($sl['is_active'])?$sl['is_active'] == 'y'?'fa fa-check':'fa fa-ban':'' ?>" aria-hidden="true"></i></a>
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
