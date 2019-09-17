<div class="">
    <table id="service-tab" class="table table-bordered table-striped">
    <thead>
        <tr>            
            <th style="white-space: nowrap;">Action</th>
            <th style="white-space: nowrap;">Client ID</th>
            <th style="white-space: nowrap;">First Name</th>
            <th style="white-space: nowrap;">Last Name</th>
            <th style="white-space: nowrap;">Office ID</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data)): ?>
            <?php
            foreach ($data as $key => $value):
                //$partner = staff_info_by_id($value['partner']);
                //$manager = staff_info_by_id($value['manager']);
                $office_id = get_office_info_by_id($value['office'])['office_id'];
                ?>

                <!-- <tr onclick="window.open('<?//= base_url("action/home/view_individual/{$value["id"]}"); ?>', '_blank');" style="cursor: pointer;"> -->
                    <tr>
                    <!-- <td><?//= $value["last_name"] . ', ' . $value["first_name"] . ' ' . $value["middle_name"]; ?></td> -->
                    <td>                        
                        <a title="VIEW" target="_blank" href="<?= base_url("/action/home/view_individual/{$value["id"]}"); ?>"><i class="fa fa-eye"></i></a>&nbsp;
                        <a title="EDIT" target="_blank" href="<?= base_url("/action/home/edit_individual/{$value["id"]}"); ?>"><i class="fa fa-edit"></i></a>
                        <a title="DELETE" href="javascript:void(0);" onclick="delete_individual('<?php echo $value["id"]; ?>');"><i class="fa fa-trash"></i></a>
                    </td>
                    <td><?= ($value["practice_id"]!='') ? $value["practice_id"] : 'N/A'; ?></td>
                    <td><?= ($value["first_name"]!='') ? $value["first_name"] : ''; ?></td>
                    <td><?= ($value["last_name"]!='') ? $value["last_name"] : ''; ?></td>
                    <td><?= $office_id; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><th colspan="4">No Data Found</th></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($data) && count($data) > 0 && $data != 0) { ?>
            if ($('#service-tab').length > 0) {
                $("#service-tab").dataTable();
            }
<?php } ?>
    });
</script>