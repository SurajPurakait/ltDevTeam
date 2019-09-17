<?php
if (!empty($list)) {
    foreach ($list as $document) {
        ?>
        <div class="row" id='document_id_<?= $document['id']; ?>' >
            <label class="col-lg-2 control-label"><?= $document['doc_type']; ?></label>
            <div class="col-lg-10" style="padding-top:8px">
                <p>
                    <a href ='javascript:void(0)' onClick="MyWindow = window.open('<?= base_url("/uploads/" . $document["document"]); ?>', 'Document Preview', width = 600, height = 300); return false;"><?= $document["document"]; ?></a>
                    &nbsp;&nbsp;<i class="fa fa-trash" style="cursor:pointer" onclick="delete_document('<?= $document["reference"]; ?>', '<?= $document["reference_id"]; ?>', '<?= $document["id"]; ?>', '<?= $document["document"]; ?>')" title="Remove this document"></i>
                </p>
            </div>
        </div>
    <?php
    }
}
?>