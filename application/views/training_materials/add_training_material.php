<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_add_training_videos">
                        <h3>Add New Training Material</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Usertype<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="checkbox-inline">
                                    <input class="checkclass" value="2" multi="" required="" <?= ($visible_by == '2') ? 'checked' : ''; ?> type="checkbox" id="usertype2" name="visible_by[]" title="Usertype">Corporate
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" value="3" multi="" required="" <?= ($visible_by == '3') ? 'checked' : ''; ?> type="checkbox" id="usertype3" name="visible_by[]" title="Usertype">Franchise
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" value="4" multi="" required="" <?= ($visible_by == '4') ? 'checked' : ''; ?> type="checkbox" id="usertype4" name="visible_by[]" title="Usertype">Client
                                </label>
                                <div class="errorMessage text-danger" id="visible_by_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" required title="Title" id="title" name="title">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Keywords<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" required title="Keywords" id="keywords" name="keywords">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Text<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" required title="Text" id="text" name="text"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Main Category<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select  class="form-control"  title="Main Category" name="main_cat" id="main_cat" required onchange="get_sub_cats()">
                                    <option value="">Select</option>          
                                    <?php
                                    if (!empty($main_cat)) {
                                        foreach ($main_cat as $c) {
                                            ?>
                                            <option value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
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
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload Video(mp4)/Upload Pdf<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="m-t-5 file-upload" allowed_types="mp4|pdf" id="video_file" type="file" name="video_file" title="Upload Video" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
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

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success save_btn" type="button" onclick="add_videos_training('<?= $visible_by; ?>')">
                                    Save Changes
                                </button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_videos_training()">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
    });

    function removeFile(divID) {
        $("#" + divID).remove();
    }
</script>