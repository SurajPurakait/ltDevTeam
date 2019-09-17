<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Attachments</h4>
        </div>
        <div class="modal-body" id="attachment_files">
            <div class="p-10">
                <table class="table table-striped">
                    <tbody>
                        <?php
                        if ($files_data) {
                            echo '<ul class="uploaded-file-list">';
                            foreach ($files_data as $data) {
                                ?> 
                                <?php
                                $fileval = explode(".", $data['file_name']);
                                $exten = end($fileval);
                                $allowed_extensios = array('jpg', 'jpeg', 'gif', 'png');
                                if (in_array($exten, $allowed_extensios)) {
                                    ?>
                                <li><div class="preview preview-image" style="background-image: url(<?php echo base_url(); ?>uploads/<?php echo $data['file_name']; ?>);"><a href="<?php echo base_url(); ?>uploads/<?php echo $data['file_name']; ?>" title="<?php echo $data['file_name']; ?>"><i class="fa fa-search-plus"></i></a></div> <p class="text-overflow-e" title="<?php echo $data['file_name']; ?>"><?php echo $data['file_name']; ?></p></li>
                            <?php } else { ?>
                                <li><div class="preview preview-file"><a target="_blank" href="<?php echo base_url(); ?>uploads/<?php echo $data['file_name']; ?>" title="<?php echo $data['file_name']; ?>"><i class="fa fa-download"></i></a></div><p class="text-overflow-e" title="<?php echo $data['file_name']; ?>"><?php echo $data['file_name']; ?></p></li>
                                <?php
                            }
                        }
                        echo '</ul>';
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.preview-image a').click(function (e) {
            e.preventDefault();
            var imageUrl = $(this).attr('href');
            $('#image_preview').html('<img src="' + imageUrl + '" style="max-width: 100%;" />');
            $('#enlargeImage').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    });
</script>