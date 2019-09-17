<div class="">
    <table id="service-tab" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Reference</th>
            <th>Action</th>
            <th>Date</th>
            <th>IP</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($log_list) && count($log_list) > 0) {
            $i = 1;
            foreach ($log_list as $ll) {
                $staff_details = staff_info_by_id($ll['staff']);
                if (!empty($staff_details)):
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $staff_details['last_name']  . ",&nbsp;" . $staff_details['first_name']. "&nbsp;" . $staff_details['middle_name']; ?></td>
                        <td><?= $ll['reference']; ?></td>
                        <td><?= ucfirst($ll['action']); ?></td>
                        <td><?= date('m/d/Y', strtotime($ll['date'])); ?></td>
                        <td><?= $ll['ip']; ?></td>
                    </tr>
                    <?php
                endif;
                $i++;
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
<?php if (isset($log_list) && count($log_list) > 0 && $log_list != 0) { ?>
            if ($('#service-tab').length > 0) {
                $("#service-tab").dataTable();
            }
<?php } ?>
    });
</script>