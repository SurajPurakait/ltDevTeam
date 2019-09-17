<?php
if ($news_id == '') {
    ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add News</h3>
            </div><!-- Modal Header-->
            <div class="modal-body">
                <form method="post" id="form_save_news">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Priority</label>
                                <select id="priority" name="priority" class="form-control">
                                    <option value="important">Important</option>
                                    <option value="regular">Regular</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Type <span class="spanclass text-danger">*</span></label>
                                <select id="type" name="office_type" title="Type" class="form-control" required="" onchange="get_dept_office(this.value);">
                                    <option value="">Select</option>
                                    <?php
                                    if (!empty($office_type)) {
                                        foreach ($office_type as $ofc_data) {
                                            ?>
                                            <option value="<?= $ofc_data['id'] ?>"><?= $ofc_data['name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorNews errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" id="dept_div"></div>
                        </div>                       
                        <div id="staff_div"></div>
                        <div class="col-md-12 m-t-15">
                            <div class="form-group">                                
                                <label class="m-r-20">
                                    <input type="radio" checked="checked" value="news" id="" name="news_type" required="" class="m-r-5">News
                                </label>
                                <label> 
                                    <input type="radio" checked="" value="update" id="" name="news_type" required="" class="m-r-5">Update 
                                </label>
                                <div class="errorNews errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Subject <span class="spanclass text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Subject" id="subject" title="Subject" name="subject" required="" >
                                <div class="errorNews errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Message <span class="spanclass text-danger">*</span></label>
                                <textarea class="form-control" placeholder="News" id="body" title="News" name="news[body]" required="" rows="5"></textarea>
                                <div class="errorNews errorMessage text-danger"></div>
                            </div>
                        </div>
                        <hr class="hr-line-dashed"/>
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" type="button" onclick="request_create_newandupdate()">Save</button> &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>  
            </div><!-- Modal Body-->
        </div><!-- Modal content-->
    </div><!-- modal-dialog -->
    <?php
} else {
    //print_r($details);exit;
    ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Edit News</h3>
            </div><!-- Modal Header-->
            <div class="modal-body">
                <form method="post" id="form_save_news">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Priority</label>
                                <select id="priority" name="priority" class="form-control">
                                    <option value="important" <?= ($details['priority'] == 'important') ? 'selected="selected"' : '' ?>>Important</option>
                                    <option value="regular" <?= ($details['priority'] == 'regular') ? 'selected="selected"' : '' ?>>Regular</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Type <span class="spanclass text-danger">*</span></label>
                                <select id="type" name="office_type" title="Type" class="form-control" required="" onchange="get_dept_office(this.value);">
                                    <option value="">Select</option>
                                    <?php
                                    if (!empty($office_type)) {
                                        foreach ($office_type as $ofc_data) {
                                            ?>
                                            <option value="<?= $ofc_data['id'] ?>" <?= ($ofc_data['id'] == $details['office_type']) ? 'selected="selected"' :  ''  ?>><?= $ofc_data['name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorNews errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" id="dept_div"></div>
                        </div>                       

                        <div id="staff_div"></div>
                        <div class="col-md-12 m-t-15">
                            <div class="form-group">                                
                                <label class="m-r-20">
                                    <input type="radio" value="news" id="" name="news_type" required="" class="m-r-5" <?= ($details['news_type'] == 'news') ? 'checked="checked"' : '' ?>>News
                                </label>
                                <label> 
                                    <input type="radio" value="update" id="" name="news_type" required="" class="m-r-5" <?= ($details['news_type'] == 'update') ? 'checked="checked"' : '' ?>>Update 
                                </label>
                                <div class="errorNews errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Subject <span class="spanclass text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Subject" id="subject" title="Subject" name="subject" required="" value="<?= $details['subject'] ?>" >
                                <div class="errorNews errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Message <span class="spanclass text-danger">*</span></label>
                                <textarea class="form-control" placeholder="News" id="body" title="News" name="news[body]" required="" rows="5"><?= $details['message'] ?></textarea>
                                <div class="errorNews errorMessage text-danger"></div>
                            </div>
                        </div>
                        <hr class="hr-line-dashed"/>
                        <input type="hidden" name="news_id" value="<?= $news_id ?>">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" type="button" onclick="request_save_newandupdate()">Save</button> &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>  
            </div><!-- Modal Body-->
        </div><!-- Modal content-->
    </div><!-- modal-dialog -->
    
    <script>
        $(function(){
            
            <?php
            if($details['office_type'] == 1){
            ?>
                get_dept_office(<?= $details['office_type'] ?>,'<?php echo implode(',',$assigned_dept) ?>');
            <?php
            }elseif($details['office_type'] == 2){
            ?>
                get_dept_office(<?= $details['office_type'] ?>, '<?php echo implode(',',$assigned_office) ?>');
            <?php
            }
            ?>
            
        });
        
    </script>
    <?php
}
?>
