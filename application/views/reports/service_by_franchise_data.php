<table class="table table-bordered report-table text-center">
    <thead>
        <tr>
            <th>Offices</th>
            <th>Totals</th>
            <th>New</th>
            <th>Started</th>
            <th>Completed</th>
            <th>< 30</th>
            <th>< 60</th>
            <th>+ 60</th>
            <th>SOS</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($service_by_franchise_list as $value) {
        ?>
        <tr>
            <td><?= $value['office_name']; ?></td>
            <td><?= $value['totals']; ?></td>
            <td><?= $value['new']; ?></td>
            <td><?= $value['started']; ?></td>
            <td><?= $value['completed']; ?></td>
            <td><?= $value['less_than_30']; ?></td>
            <td><?= $value['less_than_60']; ?></td>
            <td><?= $value['more_than_60']; ?></td>
            <td><?= $value['sos']; ?></td>
        </tr>
        <?php 
            }
        ?>
    </tbody>
</table>
