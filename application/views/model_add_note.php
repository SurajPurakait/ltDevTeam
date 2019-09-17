<div class="form-group">
    <div class="note-textarea">
        <textarea <?= $required == 'y' ? "required='required'" : ""; ?> class="form-control" name="<?= $add_name; ?>"  title="<?= $note_title; ?>"></textarea>
    </div>
    <?php if ($multiple == 'y') { ?><a href="javascript:void(0)" class="text-success add-note show m-t-10"><i class="fa fa-plus"></i> Add Notes</a><?php } ?>
</div>
<script>
    $(document).ready(function () {
        $('.add-note').click(function () {
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger show m-t-10"><i class="fa fa-times"></i> Remove Note</a>' +
                    '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });
</script>
