<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" id="add_staff" onclick="show_partner_service_modal('add', '');"
                   href="javascript:void(0);"><i class="fa fa-plus"></i> Add New Partner Service</a>
                <div class="ibox-content m-t-10">
                    <div class="" id="service-tab-setup-wrap">
                        <table id="partner-service-tab" class="table table-bordered table-striped" width="100%">
                        <thead>
                        <tr>
                            <th>Service Category</th>
                            <th>Service Name</th>
                            <th>Partner Type</th>
                            <th>Input Form</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($partner_service_list as $val) {
                        ?>    
                        <tr>
                            <td><?= $val['service_category_name']; ?></td>
                            <td><?= $val['description']; ?></td>
                            <td><?= $val['partner_type_name']; ?></td>
                            <td><?= ($val['input_form'] == 'y') ? 'Yes':'No'; ?></td>
                            <td>
                                <a href="javascript:void(0);" class="editmodal edit_service" onclick="show_partner_service_modal('edit', '<?php echo $val['id']; ?>');" title="EDIT"><i class="fa fa-pencil-square-o text-blue f-s-16"></i></a>&nbsp;

                                <a href="javascript:void(0);" title="<?= (isset($val['is_active']) ? $val['is_active'] == 'y' ?'Activate':'Deactivate':'') ?>" onclick="change_partner_service('<?= $val['id'] ?>','<?= isset($val['is_active'])?$val['is_active']:''?>');"><i class="<?= isset($val['is_active']) ? $val['is_active'] == 'y'?'fa fa-check-circle text-green f-s-16':'fa fa-minus-circle text-danger f-s-16':'' ?>" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php
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

<div id="partner-service-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php //if (isset($service_list) && count($service_list) > 0) { ?>
        if ($('#partner-service-tab').length > 0) {
            $("#partner-service-tab").dataTable({
                "scrollX": true
            });
            //$('.col-md-6').addClass('pull-left');
            // $('.dataTables_length').parent('.col-md-6').addClass('length-short-box');
            // $('.dataTables_filter').parent('.col-md-6').addClass('filter-search-box');
        }
        <?php 
    // } 
    ?>
    });
</script>