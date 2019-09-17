<?php if (count($all_videos) != 0): ?>
    <h2 class="text-primary"><?= count($all_videos); ?> Results found</h2>
<?php endif; ?>
<?php
$user_info = staff_info();
$usertype = $user_info['type'];
//print_r($all_videos);
if (!empty($all_videos)):
    ?>
    <div id="sortable">
        <?php
        foreach ($all_videos as $key => $row):
//        $visible_array = explode(",", $row['visible_by']);
//        if (in_array($usertype, $visible_array)) {
            $added_videos = get_training_videos($row['id']);
            ?>
            <article data-article-id="<?php echo $row['id']; ?>">
                <div class="panel panel-default service-panel type2 filter-active">
                    <div class="panel-heading">
                        <?php if ($usertype == 1) { ?>
                            <div class="clearfix training-status-btn-list">
                                <a href="<?= base_url("/training_materials/edit_training_material/{$row["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                <a href="javascript:void(0);" onclick="delete_training_materials('<?php echo $row['id'] ?>');" class="btn btn-danger btn-xs btn-service-delete m-r-5"><i class="fa fa-times" aria-hidden="true"></i>Delete</a>
                            </div>
                        <?php } ?>
                        <h5 class="panel-title"></h5>
                        <div class="row">
                            <div class="col-sm-5 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-body p-0 text-center">
                                    <?php $uploaded_file = $row['video'];
                                          $ex = explode('.', $uploaded_file);
                                          if($ex[1]=='mp4'){  
                                     ?>                                
                                        <video width="100%" id="videoFile<?= $row['id']; ?>" controls>
                                            <source src="<?= base_url(); ?>uploads/<?= $row['video']; ?>" type="video/mp4">
                                            <source src="<?= base_url(); ?>uploads/<?= $row['video']; ?>" type="video/ogg">
                                        </video>
                                    <?php } else { ?>
                                        <a href="<?= base_url(); ?>uploads/<?= $row['video']; ?>" target="_blank"><img width="200" src="<?= base_url(); ?>assets/img/pdf.svg"></a>
                                    <?php } ?>
                                    </div>
                                    <div class="panel-footer">
                                        <p class="text-overflow-ellipsis m-b-0" title="<?= substr($row['video'], 18); ?>">
                                            <?php if($ex[1]=='mp4'){ ?>
                                            <a href="javascript:void(0);" onclick="count_views('<?= $row['id'] ?>');" class="vidclass pull-right m-l-5" title="<?= $row['video']; ?>"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
                                            <?php } else { ?>
                                                <a href="<?= base_url(); ?>uploads/<?= $row['video']; ?>" target="_blank" onclick="count_views('<?= $row['id'] ?>');" class="pull-right m-l-5" title="<?= $row['video']; ?>"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
                                            <?php } ?>  <?= substr($row['video'], 18); ?> 
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7 col-md-8">
                                <div class="description p-t-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Main-category:</label>
                                            <p><?= $row['main_cat_name']; ?></p>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <label>Sub Category:</label>
                                            <p><?= $row['sub_cat_name']; ?></p>                                                                      
                                        </div>
                                    </div>
                                    <hr class="m-t-5 m-b-10"/>
                                    <div class="row">                                       
                                        <div class="col-md-12">
                                            <label>Title :</label>
                                            <p><?= $row['title']; ?></p>                                                                      
                                        </div>
                                        <div class="col-md-12">
                                            <label>Description:</label>
                                            <p><?= $row['text']; ?></p> 
                                        </div>
                                    </div>
                                    <hr class="m-t-5 m-b-10"/>
                                    <div class="row">
                                        <div class="col-xs-6 col-md-6">
                                            <label>Attachment:</label>
                                            <p><a class="label label-warning" href="javascript:void(0)" <?php if (count($added_videos) != 0): ?> onclick="show_training_materials_attachments_modal('<?= $row["id"]; ?>');" <?php endif; ?>><?= count($added_videos); ?></a></p> 
                                        </div>
                                        <div class="col-xs-6 col-md-6">
                                            <label>No of views:</label>
                                            <p class="no_of_views<?= $row['id']; ?>"><?= $row['video_views']; ?></p>                                    
                                        </div>                                        
                                    </div>                                    
                                </div>                   
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <?php
            //} 
        endforeach;
        ?>
    </div>
<?php else: ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i> 
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
<?php endif; ?>
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
        var sort_order = '';
        $('#sortable > article').each(function () {
            sort_order += ((sort_order != '') ? ',' : '') + $(this).attr('data-article-id');
        });
        console.log(sort_order);

        $("#sortable").sortable({
            update: function (event, ui) {
                save_sorting(ui.item, sort_order);
            }
        });

        $(".vidclass").click(function () {
            var vidval = $(this).attr('title');
            //alert(vidval);
            var videotag = '<video width="100%" controls><source src="<?= base_url(); ?>uploads/' + vidval + '" type="video/mp4"><source src="<?= base_url(); ?>uploads/' + vidval + '" type="video/ogg"></video>';
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

    function save_sorting(item, sort_order) {
        current_item = $(item).attr('data-article-id');
        var sort_order_new = '';
        $('#sortable > article').each(function () {
            sort_order_new += ((sort_order_new != '') ? ',' : '') + $(this).attr('data-article-id');
        });
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>' + 'training_materials/sort_training_materials',
            data: {
                sort_order: sort_order,
                sort_order_new: sort_order_new,
                current_item: current_item
            },
            enctype: 'multipart/form-data',
            cache: false,
            success: function (result) {
                console.log(result);
            }
        });
    }
</script>
