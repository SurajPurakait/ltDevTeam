<table class="table table-bordered">
    <tbody>
        <?php
        if ($notes_data) {
            foreach ($notes_data as $data) {
                ?>
                <tr>
                    <td>                       
                        <?php if ($data['user_id'] == $this->session->userdata('user_id')) { ?>
                            <div class="notes-view">
                                <h4>
                                    <pre style='background:transparent; border: none;padding: 9.5px 0 0;margin-bottom: 0;font-family: inherit;'><?php echo $data['note']; ?>
                                        </pre><br>
                                    <?php 
                                        // echo $data['note']; 
                                    ?>
                                </h4>
                            </div>
                            <div class="notes-edit" style="display: none;">
                                <textarea type="textarea" name="notes[<?php echo $data['note_id']; ?>]" rows="10" class="form-control"><?php echo $data['note']; ?></textarea>
                            </div>
                            <p><span class="text-info"><b>By:</b> <?= $data['staff_name']; ?> </span> | <span class="text-warning"><b>Time:</b> <?= $data['time']; ?></span> | <span class="text-success"><b>Department:</b> <?= staff_department_name($data['user_id']); ?></span></p>
                        <?php } else { ?>
                            <div class="notes-view-blocked">
                                <h4>
                                    <?php echo $data['note']; ?>
                                </h4>
                            </div>
                            <p><span class="text-info"><b>By:</b> <?= $data['staff_name']; ?></span> | <span class="text-warning"><b>Time:</b> <?= $data['time']; ?></span> | <span class="text-success"><b>Department:</b> <?= staff_department_name($data['user_id']); ?></span></p>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<input type="hidden" id="notes-table" name="notestable" value="<?php echo $notes_table; ?>">
<script>
    $(function () {
        $('.service-requests tr').click(function () {
            var childId = $(this).attr('id');
            $('.' + childId).toggle();
        });
        $('.notes-view').click(function () {
            $(this).next('.notes-edit').show();
            $(this).hide();
        });
    });
</script>