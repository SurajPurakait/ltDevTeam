<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" id="add_operational_forms">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="title" name="title" title="Title" required >
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload File<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <div class="upload-file-div m-b-5">
                                    <input class="m-t-5 file-upload" allowed_types="pdf" id="image_file" type="file" name="image_file" title="Upload File" required="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <button class="btn btn-success save_btn" type="button" onclick="addForms()">Save</button> &nbsp;
                                <button class="btn btn-default" type="button" onclick="go('operational_manuals/forms/')">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>