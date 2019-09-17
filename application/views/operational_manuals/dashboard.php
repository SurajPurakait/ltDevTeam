<?php $staff_info = staff_info(); ?>
<div class="wrapper wrapper-content" id="top-panel">
    <div class="row">
        <div class="col-sm-5 col-md-4 col-lg-3">
            <div class="ibox float-e-margins sidebar-fixed affix">                
                <div class="ibox-content p-20">
                    <div class="manuals-left">
                        <ol class="p-0 item-ordered-list">
                            <?php
                            if (!empty($main_title)) {
                                foreach ($main_title as $mt) {
                                    ?>
                                    <li>
                                        <div>
                                            <a href="" data-href="maintitle<?php echo $mt['id']; ?>"><span><?php echo $mt['name']; ?></span></a> 
                                            <?php if ($staff_info['type'] == 1) { ?>
                                                <span class="service-btn">
                                                    <a href="javascript:void(0);" class="m-r-5 text-green" onclick="openSubTitleModal('<?php echo $mt['id']; ?>')" title="Add Sub-Title"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0);" title="Edit Title" onclick="openEditTitleModal('<?php echo $mt['id']; ?>')" class="m-r-5 text-green"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0);" onclick="deleteTitle('<?php echo $mt['id']; ?>')" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                </span>
                                            <?php } ?>
                                        </div>
                                        <ol class="p-0">
                                            <?php
                                            $subtitle = get_operational_sub_titles_by_id($mt['id']);
                                            if (!empty($subtitle)) {
                                                foreach ($subtitle as $st) {
                                                    ?> 
                                                    <li>
                                                        <div>
                                                            <a href="" data-href="subtitle<?php echo $st['id']; ?>"><span><?php echo $st['name']; ?></span></a>
                                                            <?php if ($staff_info['type'] == 1) { ?>
                                                                <span class="service-btn">
                                                                    <a href="javascript:void(0);" onclick="deleteSubtitle('<?php echo $st['id']; ?>')" class="pull-right text-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                                    <a href="javascript:void(0);" title="Edit Sub-Title" onclick="openEditSubTitleModal('<?php echo $st['id']; ?>')" class="pull-right m-r-10 text-green"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                </span>
                                                            <?php } ?>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ol>
                                    </li>                            
                                    <?php
                                }
                            }
                            ?>                         
                        </ol>
                        <?php if ($staff_info['type'] == 1) { ?>
                            <a class="btn btn-primary btn-sm btn-block" href="" data-toggle="modal" data-target="#addTitle"><i class="fa fa-plus"></i> Add Title</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7 col-md-8 col-lg-9">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a class="btn btn-success text-right" href="<?php echo base_url(); ?>operational_manuals/download_pdf/"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                        </div>
                        <div class="col-md-6">
                            <img src="<?= base_url('assets/img/account-img.jpg'); ?>" width="200"/>
                        </div>
                        <div class="col-md-6 text-center">
                            <h1 class="text-green"><b>OPERATIONS MANUAL</b></h1>
                            <p>COPYRIGHT © <?php echo date('Y'); ?> by Taxleaf Franchise Corporation</p>
                        </div>
                    </div>
                    <div class="text-center m-t-20">
                        <p  style="font-size: 10px;">ALL RIGHTS RESERVED. NO PART OF THIS PUBLICATION MAY BE REPRODUCED IN ANY FOR WITHOUT PERMISSION IN WRITING FROM TAXLEAF FRANCHISE CORPORATION.</p>
                        <p  style="font-size: 10px;">ALL EMPLOYEES AND STAFF ARE ENCOURAGED TO READ THIS MANUAL, ONLY UNDER ULTIMATELY RESPONSIBLE TO ENSURE THAT THE CONTENTS ARE KEPT STRICTLY CONFIDENTIAL. FAILURE TO DO SO IS A BREACH OF THE AGREEMENT YOU HAVE SIGNED WITH TAXLEAF FRANCHISE CORPORATION.</p>
                    </div>
                </div>
            </div>
            <div class="ibox float-e-margins">                
                <div class="ibox-content manuals-right">
                    <?php
                    if (!empty($main_title)) {
                        foreach ($main_title as $mt) {
                            ?>
                            <div class="m-b-30 m-t-20" id="maintitle<?php echo $mt['id']; ?>">
                                <!-- Title -->
                                <div class="section-title clearfix">
                                    <h2 class="m-t-0 m-b-10"><?php echo $mt['name']; ?></h2>
                                    <?php if ($staff_info['type'] == 1) { ?>
                                        <span class="service-btn">
                                            <a href="javascript:void(0);" class="m-r-5 text-green" onclick="openSubTitleModal('<?php echo $mt['id']; ?>')" title="Add Sub-Title"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            <a href="javascript:void(0);" title="Edit Title" onclick="openEditTitleModal('<?php echo $mt['id']; ?>')" class="m-r-5 text-green"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a href="javascript:void(0);" onclick="deleteTitle('<?php echo $mt['id']; ?>')" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </span>
                                    <?php } ?>
                                </div>
                                <hr class="m-t-0 m-b-10" />
                                <?php $title_content = get_content('main', $mt['id']); ?>
                                <p><?php echo $title_content['description']; ?></p>

                                <!-- Sub-Title -->
                                <?php
                                $subtitle = get_operational_sub_titles_by_id($mt['id']);
                                if (!empty($subtitle)) {
                                    foreach ($subtitle as $st) {
                                        ?> 
                                        <div class="sub-title-section m-t-20" id="subtitle<?php echo $st['id']; ?>">
                                            <div class="section-subtitle clearfix">
                                                <h3 class="m-t-0"><?php echo $st['name']; ?></h3>
                                                <?php if ($staff_info['type'] == 1) { ?>
                                                    <span class="service-btn">
                                                        <a href="javascript:void(0);" onclick="deleteSubtitle('<?php echo $st['id']; ?>')" class="pull-right text-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                        <a href="javascript:void(0);" title="Edit Sub-Title" onclick="openEditSubTitleModal('<?php echo $st['id']; ?>')" class="pull-right m-r-10 text-green"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                    </span>
                                                <?php } ?>
                                                <?php $sub_title_content = get_content('sub', $st['id']); ?>
                                                <p><?php echo $sub_title_content['description']; ?></p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="text-center">
                        <a class="btn btn-success" href="<?php echo base_url(); ?>operational_manuals/download_pdf/"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Back to top button -->
    <a id="backTop" href="#page-wrapper"><i class="fa fa-arrow-up"></i></a>
</div>


<!-- Add Title -->
<!-- Modal -->
<div class="modal fade" id="addTitle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Title</h4>
            </div>
            <form id="add-operational-main-title-form" name="add-operational-main-title-form" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Title</label>
                        <input type="text" name="title" title="Title" id="title" class="form-control" required="" />
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Content</label>
                        <textarea class="form-control" name="desc" title="Description" id="desc" required rows="8"></textarea>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <input type="hidden" name="edit_main_title_id" id="edit_main_title_id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_operation_title()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Add Sub-title -->
<!-- Modal -->
<div class="modal fade" id="addSubtitle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Sub-title</h4>
            </div>
            <form id="add-operational-sub-title-form" name="add-operational-sub-title-form" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Sub Title</label>
                        <input type="text" name="title" title="Title" id="subtitle" class="form-control" required/>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Content</label>
                        <textarea class="form-control" name="desc" id="subdesc" title="Description" required rows="8"></textarea>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <input type="hidden" name="main_title_id" id="main_title_id">
                <input type="hidden" name="edit_sub_title_id" id="edit_sub_title_id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_operation_sub_title()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    function openSubTitleModal(id) {
        $("#addSubtitle").find("#main_title_id").val(id);
        $('#addSubtitle').modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function openEditTitleModal(id) {
        $.ajax({
            type: 'POST',
            url: base_url + 'operational_manuals/get_title_data',
            data: {id: id},
            datatype: 'html',
            success: function (result) {
                console.log(result);
                var res = JSON.parse(result);
                $("#addTitle").find("#myModalLabel").html("Edit Title");
                $("#addTitle").find("#title").val(res.name);
                $("#addTitle").find("#desc").val(res.main_title_desc);
                $("#addTitle").find("#edit_main_title_id").val(res.id);
                $('#addTitle').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }

    function openEditSubTitleModal(id) {
        $.ajax({
            type: 'POST',
            url: base_url + 'operational_manuals/get_sub_title_data',
            data: {id: id},
            datatype: 'html',
            success: function (result) {
                console.log(result);
                var res = JSON.parse(result);
                $("#addSubtitle").find("#myModalLabel").html("Edit Sub-title");
                $("#addSubtitle").find("#subtitle").val(res.name);
                $("#addSubtitle").find("#subdesc").val(res.sub_title_desc);
                $("#addSubtitle").find("#edit_sub_title_id").val(res.id);
                $('#addSubtitle').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }

    $(document).ready(function () {
        $(document).on('click', '.manuals-left a', function (event) {
            event.preventDefault();
            var hash = $(this).attr('data-href');
            var offset = $('#'+hash).offset().top - 70;
            
            $('html, body').animate({
                scrollTop: offset
            }, 500, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                //window.location.hash = hash;
            });

        });
    });

    $(window).scroll(function () {
        
        if ($(window).scrollTop() > $(document).height() - $(window).height() - 320) {
            $('.sidebar-fixed').addClass('fixed-sidebar-space');
            $('.sidebar-fixed').addClass('affix');
        } else {
        $('.sidebar-fixed').removeClass('fixed-sidebar-space');
        }
     });

</script>