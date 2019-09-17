<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-6 text-left p-b-10">
            <h2 class="text-primary">Messages</h2>
        </div>
        <?php if (staff_info()['type'] == 1): ?>
            <div class="col-md-6 text-right p-t-15">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#messageModal"><i class="fa fa-plus"></i> &nbsp;New message</button>
            </div>
        <?php endif; ?>
    </div>
    <div class="row" id="message-div">
        <?php if (count($message_list) != 0): ?>
            <?php foreach ($message_list as $ml): ?>
                <div class="col-md-12" id="message-div-<?= $ml['id']; ?>">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="text-success"><?= $ml['subject']; ?></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a href="javascript:void(0);" onclick="readMessage(<?= $ml['id']; ?>, <?= $message_type; ?>);">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <p><?= $ml['body']; ?></p> 
                        </div>
                    </div>
                </div><!-- /.col-md-12 -->
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center col-md-12">
                <div class="alert alert-danger">
                    <i class="fa fa-times-circle-o fa-4x"></i> 
                    <h3><strong>Sorry !</strong> no data found</h3>
                </div>
            </div>
        <?php endif; ?>
        <!--        <div class="col-md-12 text-right">
                    <button class="btn btn-primary" onclick="readMessage('<?= implode(',', array_column($message_list, 'id')); ?>', <?= $message_type; ?>);">Clear all</button>
                </div>-->
    </div><!-- /.row -->
</div><!-- /.wrapper -->
<!-- Message Modal -->
<div id="messageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">For <?= $message_type_name; ?></h3>
            </div><!-- Modal Header-->
            <div class="modal-body">
                <form method="post" id="form_save_message">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Subject:</label>
                                <input type="text" class="form-control" placeholder="Subject" id="subject" name="message[subject]" title="Subject" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Message:</label>
                                <textarea class="form-control" placeholder="Message" id="body" title="Message" name="message[body]" required=""></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <hr class="hr-line-dashed"/>
                        <div class="col-md-12 text-right">
                            <input type="hidden" name="message[message_type]" value="<?= $message_type; ?>">
                            <button type="button" class="btn btn-success" onclick="saveMessage(<?= $message_type; ?>);">Send</button>
                        </div>
                    </div>
                </form>  
            </div><!-- Modal Body-->
        </div><!-- Modal content-->
    </div><!-- modal-dialog -->
</div><!-- #messageModal -->

