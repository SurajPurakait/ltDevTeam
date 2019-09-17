<div class="p-10">
    
            <?php
//        print_r($notes_data);
            if ($files_data) {

            ?>
            <table class="table table-striped">
                <tbody>
            <?php    
                echo '<ul class="uploaded-file-list">';
                $all_list = array();
                foreach ($files_data as $data) {
                    array_push($all_list, $data['filename']);
                    ?> 
                    <?php
                    $fileval = explode(".", $data['filename']);
                    $exten = end($fileval);
                    $allowed_extensios = array('jpg', 'jpeg', 'gif', 'png');
                    $filename = explode("_",$data['filename']);
                    if (in_array($exten, $allowed_extensios)) {
                        ?>

                    <li><div class="preview preview-image" style="background-image: url(<?php echo base_url(); ?>uploads/<?php echo $data['filename']; ?>);">
                        <a href="<?php echo base_url(); ?>uploads/<?php echo $data['filename']; ?>" title="<?php echo $data['filename']; ?>">
                            <i class="fa fa-search-plus"></i>
                        </a></div> 
                        <p class="text-overflow-e" title="<?php echo $filename[2]; ?>"><?php echo $filename[2]; ?></p>
                    </li>
                            <?php } else { ?>

                    <li><div class="preview preview-file">
                    <a target="_blank" href="<?php echo base_url(); ?>uploads/<?php echo $data['filename']; ?>" title="<?php echo $data['filename']; ?>">
                        <i class="fa fa-download"></i>
                        </a></div>
                     <p class="text-overflow-e" title="<?php echo $filename[2]; ?>"><?php echo $filename[2]; ?></p>   
                    </li>

                    <?php

                            }
                        }
                        echo '</ul>';
                         // print_r($all_list);
                    ?>
                    </tbody>
                </table>

                   <form name="download_form" method="POST" action="<?= base_url('visitation/Visitation_home/visit_download_zip'); ?>">
                        <input type="hidden" id="filesarray" name="filesarray" value="<?= implode(',', $all_list); ?>">
                        <button class="btn btn-info m-t-10" type="submit"><i class="fa fa-download"></i> Download All Files</button>
                    </form>

        <?php

                    }
                    ?>

                     <form name="file_upload" method="POST" id="file_upload_action_modal">
                        <div class="form-group">
                            <input type="hidden" id="visit_id" name="visit_id" value="<?php echo $id; ?>">
                        </div>
                        <div class="form-group">   
                        <label class="col-lg-3 control-label">Upload File</label> 

                            <div class="col-lg-9">
                            <div class="upload-file-div">
                                
                                <input class="file-upload" id="action_file" type="file" name="upload_file[]" title="Upload File">
                                <div class="errorMessage text-danger m-t-5"></div>
                            </div>
                                <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i> Add File</a><br>
                                
                                </div>
                        </div>
                        <button class="btn btn-info m-t-10 upload-file-butt" type="button" onclick="fileupload_visitation()">Upload</button>
                    </form>
    

            <!-- <a href="" class="btn btn-success">Download All</a> -->
                    
        
</div>

<script>
    $(function () {
        // $('.preview-image a').click(function (e) {
        //     e.preventDefault();
        //     var imageUrl = $(this).attr('href');
        //     $('#image_preview').html('<img src="' + imageUrl + '" style="max-width: 100%;" />');
        //     $('#enlargeImage').modal({
        //         backdrop: 'static',
        //         keyboard: false
        //     });
        // });

        $('.add-upload-file').on("click", function () {
            // alert("Hello");return false;
            var text_file = $(this).prev('.upload-file-div').html();
            // alert(text_file);return false;
            var file_label = $(this).parent().parent().find("label").html();
            // alert(file_label);return false;
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-3 control-label">' + file_label + '</label><div class="col-lg-9">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            // alert(newHtml);return false;
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });

    function removeFile(divID) {
        $("#" + divID).remove();
    }
</script>