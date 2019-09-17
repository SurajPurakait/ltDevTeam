<div class="row">
    <div class="col-md-12">
        <?php

        if (!empty($news_update_list)) {
            // echo "<pre>";
            // print_r($news_update_list);
            // exit;
            foreach ($news_update_list as $data) {

                $class = 'regular-msg-box';
                //read-msg-box

                if ($data['priority'] == 'important') {
                    $class = 'important-msg-box';
                }
                $img = '<div class="priority"><img src="' . base_url() . '/assets/img/badge_update.png" /></div>';
                if ($data['news_type'] == 'news') {
                    $img = '<div class="priority"><img src="' . base_url() . '/assets/img/badge_news.png" /></div>';
                }

                if ($data['is_read'] == 1) {
                    $class = 'read-msg-box';
                }
                ?>
                <div id="news-content-<?= $data['id'] ?>" class="ibox <?php echo $class ?>">
                    <?php echo $img ?>
                    <div class="ibox-title collapse-link" onclick="read_news_or_update(<?= sess('user_id'); ?>,<?= $data['id']; ?>)" id="collapse-id">
                        <div class="row">
                            <div class="col-xs-6 col-sm-2 text-overflow-ellipsis text-center">
                                <p class=""><b class="text-muted">Subject</b></p>
                                <p> <?php echo $data['subject']; ?></p>
                            </div>
                            <div class="col-xs-6 col-sm-2 text-center">
                                <p class=""><b class="text-muted"><?= ($data['office_type'] == 1) ? 'Department' : 'Office' ?></b></p>
                                <p>
                                    <?php
                                    $get_name = get_assigned_dept_news($data['id'], $data['office_type']);
                                    $str = implode(', ', $get_name);
                                    ?>
                                    <a href="javascript:void(0);" data-toggle="popover" data-placement="top" data-content="<?= $str ?>" data-trigger="hover" title="">
                                        <?php
                                        echo substr($str, 0, 30) . '...';
                                        ?>
                                    </a>
                                </p>
                            </div>
                            <div class="col-xs-6 col-sm-2 text-center">
                                <p class=""><b class="text-muted">Assign To</b></p>
                                <p><?php echo get_assigned_staff_news($data['id']); ?></p>
                            </div>
                            <div class="col-xs-6 col-sm-2 text-center">
                                <p class=""><b class="text-muted">Date</b></p>
                                <p><?php echo date('m/d/Y H:i', strtotime($data['created_type'])) ?></p>          
                            </div>
                            <div class="col-xs-6 col-sm-2 text-center m-t-20">
                                <?php 
                                    if ($data['is_read'] != '1') {
                                ?>
                                <a href="javascript:void(0)" class="btn btn-danger" id="unread_news" style="width:80px">UNREAD</a>
                                <?php        
                                    }else{
                                ?>
                                <a href="javascript:void(0)" class="btn btn-primary" style="width:80px">READ</a>
                                <?php        
                                    }
                                ?>
                            </div>
                            <div class="col-xs-6 col-sm-2 text-center m-t-20 del del<?= $data['id']; ?>">
                                <a href="javascript:void(0)" onclick="delNews(<?= sess('user_id'); ?>,<?= $data['id']; ?>)" style="font-size: 22px; color:#ed5565"><span class="fa fa-times-circle"></span></a>
                            </div>
                        </div>                       
                        <div class="ibox-tools">
                            <a href="javascript:void(0)" id="<?= sess('user_id') . '-' . $data['id'] ?>">
                                <i class="fa fa-chevron-up"></i>
                            </a>
        <!--              <span id="del-container-<?//= $data['id'] ?>">
                            <?php
                            /* if ($data['priority'] == 'important') {
                              if ($data['is_read'] == 1) {
                              ?>
                              <a href="javascript:void(0);" onclick="delNews('<?= sess('user_id') ?>', '<?= $data['id'] ?>')" class=""><i class="fa fa-times"></i></a>
                              <?php
                              }
                              }elseif($data['priority'] == 'regular'){ */
                            ?>
                                        <a href="javascript:void(0);" onclick="delNews('<?//= sess('user_id') ?>', '<?//= $data['id'] ?>')" class=""><i class="fa fa-times"></i></a>
                            <?php
                            //}
                            ?>
                            </span>-->
                        </div>
                    </div>
                    <div class="ibox-content break-word" style="display: none;">
                        <p><?php echo html_entity_decode($data['message']); ?></p> 
                    </div>
                </div><!-- /.ibox -->
                <?php
            }
        } else {
            ?>
            <div class = "text-center m-t-30">
                <div class = "alert alert-danger">
                    <i class = "fa fa-times-circle-o fa-4x"></i>
                    <h3><strong>Sorry!</strong> no data found</h3>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div><!-- /.col-md-12 -->

<script>

    // $(document).on('click', '.collapse-link', function () {
        
        //var ibox = $(this).closest('div.ibox');
        // var cur_id = $(this).attr('id');
        // var data_arr = cur_id.split('-');
        // $.ajax({
        //     type: "POST",
        //     url: base_url + 'news/update_read',
        //     data: {user_id: data_arr[0], news_id: data_arr[1]},
        //     success: function (result) {
        //         if (result.trim() == "1") {
        //             ibox.addClass('read-msg-box');
        //             if (ibox.hasClass('regular-msg-box')) {
        //                 ibox.removeClass('regular-msg-box');
        //             } else if (ibox.hasClass('important-msg-box')) {
        //                 ibox.removeClass('important-msg-box');
        //             }
        //             $('#del-container-' + data_arr[1]).html('<a href="javascript:void(0);" onclick="delNews(' + data_arr[0] + ',' + data_arr[1] + ')" class=" text-white"><i class="fa fa-times"></i></a>');
        //         }
        //     },
        //     beforeSend: function () {
        //         openLoading();
        //     },
        //     complete: function (msg) {
        //         closeLoading();
        //     }
        // });
    // });
</script>
