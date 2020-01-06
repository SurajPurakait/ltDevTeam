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
                    <div class="" id="service-tab-setup-wrap">
                        <table id="service-tab" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="white-space: nowrap;">Service Category</th>
                            <th style="white-space: nowrap;">Service Name</th>
                            <!-- <th>Department</th> -->
                            <th style="white-space: nowrap;">Responsible</th>
                            <th style="white-space: nowrap;">Input Form</th>
                            <th style="white-space: nowrap;">Days To Start</th>
                            <th style="white-space: nowrap;">Days To Complete</th>
                            <th style="white-space: nowrap;">Fixed Cost</th>
                            <th style="white-space: nowrap;">Retail Price</th>
                            <th style="white-space: nowrap;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($service_list) && count($service_list) > 0) {
                            foreach ($service_list as $sl) {
                                ?>
                                <tr style="cursor: pointer;">
                                    <td onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');"><?php echo $sl['catname']; ?></td>
                                    <td onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');"><?php echo $sl['description']; ?></td>
                                    <td onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');"><?php 
                                            if($sl['dept'] == 0){
                                                echo "Franchisee";
                                            }else{
                                                echo $sl['name'];
                                            }?>
                                                
                                    </td>
                                    <td onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');"><?php if($sl['input_form'] == 'y'){
                                            echo "YES";
                                    }else if($sl['input_form'] == 'n'){
                                        echo "NO";
                                    } ?>
                                    </td> 
                                    <td onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');"><?php echo $sl['start_days']; ?></td>
                                    <td onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');"><?php echo $sl['end_days']; ?></td>
                                    <td onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');"><?php echo $sl['fixed_cost']; ?></td>
                                    <td onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');"><?php echo $sl['retail_price']; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="editmodal edit_service" onclick="show_service_modal('edit', '<?php echo $sl['id']; ?>');" title="EDIT"><i class="fa fa-pencil-square-o text-blue f-s-16"></i></a>&nbsp;
                                        <!--<a href="javascript:void(0);" title="DELETE" onclick="delete_service('<?php //echo $sl['id'] ?>');"><i class="fa fa-trash"></i></a>-->

                                        <a href="javascript:void(0);" title="<?= (isset($sl['is_active'])?$sl['is_active'] == 'y' ?'Activate':'Deactivate':'') ?>"onclick="deactive_service('<?= $sl['id'] ?>','<?= isset($sl['is_active'])?$sl['is_active']:''?>');"><i class="<?= isset($sl['is_active'])?$sl['is_active'] == 'y'?'fa fa-check-circle text-green f-s-16':'fa fa-minus-circle text-danger f-s-16':'' ?>" aria-hidden="true"></i></a>
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
            $("#service-tab").dataTable({
                "scrollX": true
            });
            //$('.col-md-6').addClass('pull-left');
            $('.dataTables_length').parent('.col-md-6').addClass('length-short-box');
            $('.dataTables_filter').parent('.col-md-6').addClass('filter-search-box');
        }
        <?php } ?>
    });
</script>
