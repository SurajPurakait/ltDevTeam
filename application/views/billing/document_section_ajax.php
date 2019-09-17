<?php
$colors = array('bg-light-blue', 'bg-light-green', 'bg-light-red', '', 'bg-light-orange', 'bg-light-purple', 'bg-light-aqua');
if (isset($document_list)):
    foreach ($document_list as $key => $dl) :
        $random_keys = array_rand($colors);
        $dl['document'] = $dl['document'];
        ?>
        <div class="well <?= $colors[$random_keys]; ?>" id="document_result_div_<?= $dl['id']; ?>">
            <?php if ($dl['document'] != ''): ?>
                <div class="form-group" id="file_view_div_<?= $dl['id']; ?>">
                    <input type="hidden" name="document[<?= $dl['id']; ?>][previous_file]" value="<?= $dl['document']; ?>">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-10">
                        <ul class="uploaded-file-list">
                            <?php
                            $extension = pathinfo($dl['document'], PATHINFO_EXTENSION);
                            $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                            if (in_array($extension, $allowed_extension)):
                                ?>
                                <li id="file_show_<?= $dl['id']; ?>">
                                    <div class="preview preview-image" id="file_hide" style="background-image: url('<?= base_url(); ?>uploads/<?= $dl['document']; ?>');max-width: 100%;">
                                        <a href="<?= base_url(); ?>uploads/<?= $dl['document']; ?>" title="<?= $dl['document']; ?>"><i class="fa fa-search-plus"></i></a>
                                    </div>
                                    <p class="text-overflow-e" title="<?= $dl['document']; ?>"><?= $dl['document']; ?></p>
                                    <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteDocumentFile(<?= $dl['id']; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                </li>
                            <?php else: ?>
                                <li id="file_show_<?= $dl['id']; ?>">
                                    <div class="preview preview-file" id="file_hide">
                                        <a target="_blank" href="<?= base_url(); ?>uploads/<?= $dl['document']; ?>" title="<?= $dl['document']; ?>"><i class="fa fa-download"></i></a>
                                    </div>
                                    <p class="text-overflow-e" title="<?= $dl['document']; ?>"><?= $dl['document']; ?></p>
                                    <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" id="remove" onclick="deleteDocumentFile(<?= $dl['id']; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                </li>
                            <?php
                            endif;
                            ?>
                        </ul>
                    </div>                    
                </div>
            <?php endif; ?>            
            <div class="form-group" id="file_div_<?= $dl['id']; ?>">
                <label class="col-lg-2 control-label">Document<span class="text-danger">*</span></label>
                <div class="col-lg-10">
                    <input type="file" name="file_input_<?= $dl['id']; ?>" id="document_<?= $dl['id']; ?>" title="Document" <?= $dl['document'] == '' ? 'required="required"' : ''; ?>>
                    <div class="errorMessage text-danger"></div>
                </div>
            </div>
            <div class="form-group" id="file_div_<?= $dl['id']; ?>">
                <label class="col-lg-2 control-label">Date</label>
                <div class="col-lg-10">
                    <input placeholder="mm/dd/yyyy" type="text" name="document[<?= $dl['id']; ?>][date]" id="date_<?= $dl['id']; ?>" title="date"   value="<?= isset($dl['date']) ? (($dl['date'] != '0000-00-00') ? date('m/d/Y', strtotime($dl['date'])) : '') : ""; ?>" class="form-control datepicker_mdy">
                    <div class="errorMessage text-danger"></div>
                </div>
            </div>
            <div class="form-group" id="file_div_<?= $dl['id']; ?>">
                <label class="col-lg-2 control-label">Note</label>
                <div class="col-lg-10">
                    <textarea placeholder="notes" class="form-control"  name="document[<?= $dl['id']; ?>][note]" id="note_<?= $dl['id']; ?>" title="note"><?= isset($dl['note']) ? $dl['note'] : ""; ?></textarea>
                    <div class="errorMessage text-danger"></div>
                </div>
            </div>
            <?php if (end($document_list)['id'] == $dl['id']) { ?>
                <a href="javascript:void(0)" id="section_link_<?= $dl['id']; ?>" onclick="addDocumentAjax('');" class="text-success pull-right"><h4><i class="fa fa-plus"></i> Document</h4></a><br>
            <?php } else { ?>
                <a href="javascript:void(0)" id="section_link_<?= $dl['id']; ?>" onclick="removeDocument(<?= $dl['id']; ?>);" class="text-danger pull-right"><h4><i class="fa fa-times"></i> Remove</h4></a><br><br>
            <?php }
            ?>            
        </div>
        <?php
    endforeach;
else:
    $random_keys = array_rand($colors);
    ?>
    <div class="well <?= $colors[$random_keys]; ?>" id="document_result_div_<?= $section_id; ?>">    
        <div class="form-group" id="file_div_<?= $section_id; ?>">
            <label class="col-lg-2 control-label">Document<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <input type="file" name="file_input_<?= $section_id; ?>" id="document_<?= $section_id; ?>" title="Document" required="required">
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
        <div class="form-group" id="file_div_<?= $section_id; ?>">
            <label class="col-lg-2 control-label">Date</label>
            <div class="col-lg-10">
                <input placeholder="mm/dd/yyyy" type="text" name="document[<?= $section_id; ?>][date]" id="date_<?= $section_id; ?>" title="date" class="form-control datepicker_mdy">
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
        <div class="form-group" id="file_div_<?= $section_id; ?>">
            <label class="col-lg-2 control-label">Note</label>
            <div class="col-lg-10">
                <textarea placeholder="notes" class="form-control"  name="document[<?= $section_id; ?>][note]" id="note_<?= $section_id; ?>" title="note"></textarea>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
        <a href="javascript:void(0)" id="section_link_<?= $section_id; ?>" onclick="addDocumentAjax('');" class="text-success pull-right"><h4><i class="fa fa-plus"></i> Document</h4></a><br>
    </div>
<?php endif; ?>
<script>
    $(function () {
        $(".datepicker_mdy").datepicker({format: 'mm/dd/yyyy', autoHide: true});
    });
    $('.rel-serv-license-file').click(function () {
        var textlicense = $(this).prev('.license-file').html();
        var div_count = Math.floor((Math.random() * 999) + 1);
        var newHtml = '<div class="form-group"  id="license_div' + div_count + '"><label class="col-lg-2 control-label"></label><div class="col-lg-10">' + textlicense + '<a href="javascript:void(0)" onclick="removeLicense(\'license_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove License</a></div></div>';
        $(newHtml).insertAfter($(this).closest('.form-group'));
    });
</script>
