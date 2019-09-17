<div class="table-responsive">
    <table id="service-tab" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Office</th>
                            <th>Type</th>
                            <th>Username</th>
                            <th>Department</th>
                            <th style="display: none;">Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($staff_list) && count($staff_list) > 0) {
                            foreach ($staff_list as $sl) {
                                $department = staff_department_name($sl['id']);
                                $office = staff_office_name($sl['id']);
                                ?>
                                <tr class="<?php echo ($sl['status']==0) ? 'bg-red' : ''; ?>" onclick="show_staff_modal('edit', '<?= $sl['id']; ?>');">
                                    <td><?= $sl['last_name']  . ",&nbsp;" . $sl['first_name']. "&nbsp;" . $sl['middle_name']; ?></td>
                                    <!--<td><?= (($sl['birth_date'] != NULL && $sl['birth_date'] != '0000-00-00') ? date('m/d/Y', strtotime($sl['birth_date'])) : ''); ?></td>-->
                                    <td><?= $office; ?></td>
                                    <td><?= isset($sl['type']) ? get_staff_type_by_id($sl['type'])['name'] : ""; ?></td>
                                    <td><?= $sl['user']; ?></td>
                                    <td><?= $department; ?></td>
                                    <td style="display: none;"><?= $sl['status']; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="editmodal edit_staff"
                                           onclick="show_staff_modal('edit', '<?= $sl['id']; ?>');" title="EDIT"><i
                                                    class="fa fa-edit"></i></a>&nbsp;
                                        <a href="javascript:void(0);" title="DELETE"
                                           onclick="delete_staff('<?= $sl['id'] ?>');"><i class="fa fa-trash"></i></a>
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
<script type="text/javascript">
    $(document).ready(function () {
        <?php if (isset($staff_list) && count($staff_list) > 0 && $staff_list != 0) { ?>
        if ($('#service-tab').length > 0) {
            $("#service-tab").dataTable({
                "order": [[ 5, "desc" ]]
            });
        }
        <?php } ?>
    });
</script>