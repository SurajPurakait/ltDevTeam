<?php
$ci = &get_instance();
$ci->load->model('administration');
$ci->load->model('system');
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" id="add_franchise" onclick="show_franchise_modal('add', '');"
                   href="javascript:void(0);"><i class="fa fa-plus"></i> Add Office</a>
                <div class="ibox-content m-t-10">
                    <div class="">
                        <table id="service-tab" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Office Name</th>
                                    <th>Office ID</th>
                                    <th>Manager</th>
<!--                                     <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Zip</th> -->
                                    <th>TELF</th>
                                    <th>Email</th>                                    
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (isset($franchise_list) && count($franchise_list) > 0) {
                                    foreach ($franchise_list as $fl) {
                                        $manager_info = office_manager_by_office_id($fl['id']);
                                        $ofc_mngr = get_ofc_mngr($fl['id']);
                                        ?>
                                        <!-- <tr onclick="show_franchise_modal('edit', '<?//= $fl['id']; ?>');"> -->
                                            <tr style="cursor: pointer;" class="<?= $fl['status']==3?'bg-red odd':'bg-default odd' ?>" > 
                                            <td onclick="redirect_page(<?= $fl['id']; ?>);"><?= isset($fl['type']) ? $ci->administration->get_office_type_by_id($fl['type'])['name'] : ""; ?></td>
                                            <td onclick="redirect_page(<?= $fl['id']; ?>);"><?= $fl['name']; ?></td>
                                            <td onclick="redirect_page(<?= $fl['id']; ?>);"><?= $fl['office_id']; ?></td>
                                            <td onclick="redirect_page(<?= $fl['id']; ?>);"><?= $ofc_mngr; ?></td>
                                            <!-- <td><?//= $fl['address']; ?></td> -->
                                            <!-- <td><?//= $fl['city']; ?></td> -->
                                            <!-- <td><?//= isset($fl['state']) ? $ci->system->get_state_by_id($fl['state'])['state_name'] : ""; ?></td> -->
                                            <!-- <td><?//= $fl['zip']; ?></td> -->
                                            <td onclick="redirect_page(<?= $fl['id']; ?>);"><?= $fl['phone']; ?></td>
                                            <td onclick="redirect_page(<?= $fl['id']; ?>);"><?= $fl['email']; ?></td>                                            
                                            <td>
                                                <a href="<?= base_url('administration/office/show_office_edit_info/' . $fl['id']); ?>" class="editmodal edit-franchise"
                                                  
                                                   title="EDIT" target="_blank"><i class="fa fa-edit"></i></a>&nbsp;
                                                <a href="javascript:void(0);" title="DELETE"
                                                   onclick="delete_office('<?= $fl['id'] ?>');"><i
                                                        class="fa fa-trash"></i></a>
                                                        
                                                        <a href="javascript:void(0);" title="<?= $fl['status']==3?'Deactivate':'Activate' ?>"
                                                   onclick="deactive_office('<?= $fl['id'] ?>','<?= $fl['status']?>');"><i class="<?= $fl['status']==3?'fa fa-ban':'fa fa-check' ?>" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><th colspan="8">No Data Found</th></tr>';
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
<div id="franchise-form-modal" class="modal fade" aria-hidden="true" style="display: none;">
</div>
<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($franchise_list) && count($franchise_list) > 0) { ?>
            if ($('#service-tab').length > 0) {
                $("#service-tab").dataTable();
            }
<?php } ?>
    });

    function redirect_page(edit_id){
        window.open('<?= base_url("administration/office/show_office_edit_info/"); ?>'+ edit_id ,'_blank');
    }
</script>