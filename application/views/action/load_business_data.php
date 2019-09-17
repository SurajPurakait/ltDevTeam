<div>
    <table id="service-tab" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="70">Action</th>
                <th style="white-space: nowrap;">Practice ID</th>
                <th style="white-space: nowrap;">Company Name</th>
                <th style="white-space: nowrap;">Office</th>
                <!-- <th style="white-space: nowrap;">Partner</th>
                <th style="white-space: nowrap;">Manager</th> 
                <th style="white-space: nowrap;">Referred by Source</th>-->
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $value['reference'] = 'company';
                    //$internal_data = internal_data($value['id'], $value['reference']);
                    //$partner = staff_info_by_id($internal_data['partner']);
                    //$manager = staff_info_by_id($internal_data['manager']);
                    //$refer_by_source = reference_by_source($internal_data['referred_by_source']);
                    $office_name = get_office_name_by_office_id($value['office']);
                    ?>
                   <!--  <tr onclick="window.open('<?//= base_url("action/home/view_business/{$value["id"]}/{$value["company_id"]}"); ?>', '_blank');" style="cursor: pointer;"> -->
                    <tr>
                        <td>
                            <a href="<?= base_url("/action/home/view_business/{$value["id"]}/{$value["company_id"]}"); ?>" target="_blank" class="editmodal edit_staff" title="VIEW" style="font-size: 17px;"><i class="fa fa-eye"></i></a>&nbsp;
                            <a href="<?= base_url("/action/home/edit_business/{$value["id"]}/{$value["company_id"]}"); ?>" target="_blank" class="editmodal edit_staff" title="EDIT"><i class="fa fa-edit"></i></a>
                            <a title="DELETE" href="javascript:void(0);" onclick="delete_business('<?php echo $value["id"]; ?>','<?php echo $value["company_id"]; ?>');"><i class="fa fa-trash"></i></a>
                        </td>
                        <td><?= $value["practice_id"]; ?></td>
                        <td><?= $value["name"]; ?></td>
                        <td><?= $office_name; ?></td>
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
<?php if (!empty($data) && count($data) > 0) { ?>
            if ($('#service-tab').length > 0) {
                $("#service-tab").dataTable({
                    aaSorting: [[2, 'asc']]
                });
            }
<?php } ?>
    });
</script>
