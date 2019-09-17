<div class="row">
    <div class="col-md-12">
        <?php
        if (!empty($news_update_list)) {

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
//                                    
                ?>
                <div id="news-admin-content-<?= $data['id'] ?>" class="ibox <?php echo $class ?>">
                    <?php echo $img ?>
                    <div class="ibox-title collapse-link">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 text-overflow-ellipsis text-center">
                                <p class=""><b class="text-muted">Subject</b></p>
                                <p><?php echo $data['subject']; ?></p>
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
                            <?php

                                // read by user or staff
                                $news_read_by_user = get_news_view_count($data['id']);
                                if (!empty($news_read_by_user)) {
                                    $news_read_by_user_id = array_column($news_read_by_user, 'id');
                                }else {
                                    $news_read_by_user_id = [] ;
                                }
                                 
                                // total assigned staff
                                $news_data = get_all_assigened_staff_news($data['id']); 
                                $news_data_staff = array_column($news_data, 'staff_id');
                                
                            ?>
                            <div class="col-xs-6 col-sm-2 text-center">
                                <span class="badge m-t-25"><a href="javascript:void(0)" onclick="show_news_staff(<?= $data['id']; ?>)"><?= count($news_read_by_user_id)." / ". count($news_data_staff); ?></a></span>
                            </div>
                        </div>                       
                        <div class="ibox-tools">
<!--                             <a href="javascript:void(0)" class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a> -->
                            <a href="javascript:void(0)" id="" onclick="getCreateNewsModal('<?= $data['id'] ?>');">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <span id="del-container-<?= $data['id'] ?>">

                                <a href="javascript:void(0);" onclick="delNewsAdmin('<?= $data['id'] ?>')" class=""><i class="fa fa-times"></i></a>

                            </span>
                        </div>
                    </div>
                    <div class="ibox-content break-word" style="display: none;">
                        <p><?php echo html_entity_decode($data['message']); ?></p>
                    </div>
                </div><!-- .ibox -->
                <?php
            }
        } else {
//                                
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


