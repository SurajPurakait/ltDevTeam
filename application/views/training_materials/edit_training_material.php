<?php
if(!empty($user_type)){
    foreach($user_type as $ut){
        $us_ty[] = $ut['user_type'];
    }
}else{
    $us_ty = [];
} 
//print_r($us_ty);
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_edit_training_videos">
                        <h3>Edit Training Material</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Usertype<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" value="2" <?= (in_array('2',$us_ty)) ? 'checked' : ''; ?> type="checkbox" id="usertype2" name="visible_by[]" title="Usertype">Corporate
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" value="3" <?= (in_array('3',$us_ty)) ? 'checked' : ''; ?> type="checkbox" id="usertype3" name="visible_by[]" title="Usertype">Franchise
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" value="4" <?= (in_array('4',$us_ty)) ? 'checked' : ''; ?> type="checkbox" id="usertype4" name="visible_by[]" title="Usertype">Client
                                </label>
                                <div class="errorMessage text-danger" id="visible_by_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" required title="Title" id="title" name="title" value="<?= $data['title']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Keywords<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" required title="Keywords" id="keywords" name="keywords" value="<?= $data['keywords']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Text<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" required title="Text" id="text" name="text"><?= $data['text']; ?></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Main Category<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select  class="form-control"  title="Main Category" name="main_cat" id="main_cat" required onchange="get_sub_cats()">
                                    <option value="">Select an option</option>          
                                    <?php
                                    if (!empty($main_cat)) {
                                        foreach ($main_cat as $c) {
                                            ?>
                                            <option <?= ($data['main_cat'] == $c['id']) ? 'selected' : ''; ?> value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sub Category<span class="text-danger">*</span></label>
                            <div class="col-lg-10 subcat">
                                <select  class="form-control"  title="Sub Category" name="sub_cat" id="sub_cat" required>
                                    <option value="">Select</option>
                                    <?php
                                    if (!empty($sub_cat)) {
                                        foreach ($sub_cat as $c) {
                                            ?>
                                            <option <?= ($data['sub_cat'] == $c['id']) ? 'selected' : ''; ?> value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-lg-offset-3 col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-body p-0 text-center">   
                                    <?php $uploaded_file = $data['video'];
                                          $ex = explode('.', $uploaded_file);
                                          if($ex[1]=='mp4'){  
                                     ?>                               
                                        <video width="100%" id="videoFile<?= $data['id']; ?>" controls>
                                            <source src="<?= base_url(); ?>uploads/<?= $data['video']; ?>" type="video/mp4">
                                            <source src="<?= base_url(); ?>uploads/<?= $data['video']; ?>" type="video/ogg">
                                        </video>
                                        <?php } else { ?>
                                            <a href="<?= base_url(); ?>uploads/<?= $data['video']; ?>" target="_blank"><img width="200" src="<?= base_url(); ?>assets/img/pdf.svg"></a>
                                        <?php } ?>
                                    </div>
                                    <div class="panel-footer">
                                        <p class="text-overflow-e m-b-0" title="<?= substr($data['video'], 18); ?>"><?= substr($data['video'], 18); ?>
                                        <?php if($ex[1]=='mp4'){ ?>
                                            <a href="javascript:void(0);" onclick="count_views('<?= $data['id'] ?>');" class="vidclass pull-right" title="<?= $data['video']; ?>"><i class="fa fa-window-maximize" aria-hidden="true"></i></a>
                                            <?php } else { ?>
                                               <a href="<?= base_url(); ?>uploads/<?= $data['video']; ?>" target="_blank" onclick="count_views('<?= $data['id'] ?>');" class="pull-right" title="<?= $data['video']; ?>"><i class="fa fa-window-maximize" aria-hidden="true"></i></a> 
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>           
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload Video(mp4)/Upload Pdf<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="m-t-5 file-upload" id="video_file" allowed_types="mp4|pdf" type="file" name="video_file" title="Upload Video">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?php if (!empty($file_data)): ?>
                            <ul class="uploaded-file-list">
                                <?php
                                foreach ($file_data as $value) :
                                    $extension = pathinfo($value['file_name'], PATHINFO_EXTENSION);
                                    $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                    $allowed_extension_videos = array('mp4');
                                    if (in_array($extension, $allowed_extension)) {
                                        ?>
                                        <li>
                                            <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $value['file_name']; ?>');max-width: 100%;">
                                                <a href="javascript:void(0);" class="imgclass" title="<?= $value['file_name']; ?>"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                            <p class="text-overflow-e" title="<?= $value['file_name']; ?>"><?= $value['file_name']; ?></p>
                                            <!--<a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteTrainingMaterialAttachment(<?= $value['id']; ?>)"><i class='fa fa-times-circle'></i> Remove</a>-->
                                        </li>
                                    <?php } elseif (in_array($extension, $allowed_extension_videos)) { ?> 
                                        <li>
                                            <div class="preview preview-video">
                                                <a href="javascript:void(0);" class="vidclass" title="<?= $value['file_name']; ?>"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                            <p class="text-overflow-e" title="<?= $value['file_name']; ?>"><?= $value['file_name']; ?></p>
                                        </li>
                                    <?php } else { ?>
                                        <li>
                                            <div class="preview preview-file">
                                                <a target="_blank" href="<?= base_url(); ?>uploads/<?= $value['file_name']; ?>" title="<?= $value['file_name']; ?>"><i class="fa fa-download"></i></a>
                                            </div>
                                            <p class="text-overflow-e" title="<?= $value['file_name']; ?>"><?= $value['file_name']; ?></p>
                                        </li>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Attachments</label>
                            <div class="col-lg-10">
                                <div class="upload-file-div">
                                    <input class="m-t-5 file-upload" id="action_file" type="file" name="upload_file[]" title="Attachments">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-upload-file m-t-5"><i class="fa fa-plus"></i> Add File</a>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <input type="hidden" name="id" id="v_id" value="<?= $data["id"]; ?>">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success save_btn" type="button" onclick="update_videos_training()">Save Changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_videos_training()">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="videomodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Preview</h4>
            </div>
            <div class="modal-body">
                <div id="vid"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="videomodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Preview</h4>
            </div>
            <div class="modal-body">
                <div id="vid"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.add-upload-file').on("click", function () {
            var text_file = $(this).prev('.upload-file-div').html();
            var file_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-2 control-label">' + file_label + '</label><div class="col-lg-10">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
        $(".vidclass").click(function () {
            var vidval = $(this).attr('title');
            //alert(vidval);
            var videotag = '<video width="100%" controls><source src="<?= base_url(); ?>uploads/' + vidval + '" type="video/mp4"></video>';
            //alert(videotag);
            $("#videomodal #vid").html(videotag);
            $('#videomodal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        $(".imgclass").click(function () {
            var imgval = $(this).attr('title');
            //alert(vidval);
            var imgtag = '<img style="max-width:100%;" src="<?= base_url(); ?>uploads/' + imgval + '">';
            //alert(videotag);
            $("#videomodal #vid").html(imgtag);
            $('#videomodal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    });
    function removeFile(divID) {
        $("#" + divID).remove();
    }
</script>