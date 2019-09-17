<?php
if (isset($note_list)) {
    foreach ($note_list as $index => $nl) {
        $rand = rand(000, 999);
        if ($nl['user_id'] != $this->session->userdata('user_id')) {
            ?>
            <div class="form-group">
                <label class="col-lg-2 control-label"><?= $index == 0 ? $note_title : ""; ?></label>
                <div class="col-lg-10">
                    <div title="<?= $note_title ?>"><?= $nl['note']; ?></div>
                    <div>By: <?= $nl['staff_name']; ?></div>
                    <div>Department: <?= staff_department_name($nl['user_id']); ?></div>
                    <div>Time: <?= $nl['time']; ?></div>                                            
                </div>
            </div>
            <textarea style="display:none;" <?= $required == 'y' ? "required='required'" : ""; ?> class="form-control" name="<?= $edit_name . '[' . $nl['note_id'] . ']'; ?>"  title="<?= $note_title ?>"><?= $nl['note']; ?></textarea>
        <?php } else { ?>
            <div class="form-group" id="<?= $table . '_div_' . $index . $rand; ?>">
                <label class="col-lg-2 control-label"><?= $index == 0 ? $note_title : ""; ?></label>
                <div class="col-lg-10">
                    <div class="note-textarea">
                        <textarea <?= $required == 'y' ? "required='required'" : ""; ?> class="form-control" name="<?= $edit_name . '[' . $nl['note_id'] . ']'; ?>"  title="<?= $note_title ?>"><?= $nl['note']; ?></textarea>
                    </div>
                    <div class="pull-right"><b>By: <?= $nl['staff_name']; ?> | Department: <?= staff_department_name($nl['user_id']); ?> | Time: <?= $nl['time']; ?></b></div>
                    <?php if ($multiple == 'y') { ?><a href="javascript:void(0);" onclick="deleteNote('<?= $table . '_div_' . $index . $rand; ?>', '<?= $nl['note_id']; ?>', '<?= $related_table_id; ?>');" class="text-danger"><i class="fa fa-times"></i> Remove Note</a><?php } ?>
                </div>
            </div>
            <?php
        }
    }
    ?>
    <?php if ($multiple == 'y') { ?>
        <div class="form-group">
            <label class="col-lg-2 control-label"><?= count($note_list) > 0 ? '' : $note_title; ?></label>
            <div class="col-lg-10">
                <div class="note-textarea">
                    <textarea <?= $required == 'y' ? "required='required'" : ""; ?> class="form-control" name="<?= $add_name ?>"  title="<?= $note_title ?>"></textarea>
                </div>
                <a href="javascript:void(0)" class="text-success add-note"><i class="fa fa-plus"></i> Add Notes</a>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="form-group">
        <label class="col-lg-2 control-label"><?= $note_title; ?></label>
        <div class="col-lg-10">
            <div class="note-textarea">
                <textarea <?= $required == 'y' ? "required='required'" : ""; ?> class="form-control" name="<?= $add_name ?>"  title="<?= $note_title ?>"></textarea>
            </div>
            <?php if ($multiple == 'y') { ?><a href="javascript:void(0)" class="text-success add-note"><i class="fa fa-plus"></i> Add Notes</a><?php } ?>
        </div>
    </div>
<?php } ?>