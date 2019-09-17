<table class="table table-bordered">
    <tbody>
        <?php
        if ($get_note_data) {
            foreach ($get_note_data as $data) {
                ?>
                <tr>
                    <td>
                        <div class="notes-view-blocked">
                            <h4>
                            <?php echo $data['note']; ?>
                            </h4>
                        </div>
                        <p><span class="text-info"><b>By:</b> <?= get_assigned_by_staff_name($data['assisned_by_userid']); ?></span> | <span class="text-warning"><b>Time:</b> <?= $data['date_time']; ?></span> | <span class="text-success"><b>Department:</b> <?= staff_department_name($data['assisned_by_userid']); ?></span></p>
                    </td>
                </tr>
                <?php
            }
        }
        ?>

    </tbody>
</table>