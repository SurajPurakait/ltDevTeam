<?php $staff_info = staff_info(); ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="filters"> 
                        <div class="panel">
                            <div class="panel-body">
                                <div clas="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img src="<?= base_url('assets/img/account-img.jpg'); ?>" width="200"/>
                                            </div>
                                            <div class="col-md-7 text-center">
                                                <h1 class="text-green"><b>OPERATIONS MANUAL</b></h1>
                                                <p>COPYRIGHT © <?php echo date('Y'); ?> by Taxleaf Franchise Corporation</p>
                                            </div>
                                        </div>
                                        <div class="text-center m-t-20">
                                            <p style="font-size: 10px;">ALL RIGHTS RESERVED. NO PART OF THIS PUBLICATION MAY BE REPRODUCED IN ANY FOR WITHOUT PERMISSION IN WRITING FROM TAXLEAF FRANCHISE CORPORATION.</p>
                                            <p style="font-size: 10px;">ALL EMPLOYEES AND STAFF ARE ENCOURAGED TO READ THIS MANUAL, ONLY UNDER ULTIMATELY RESPONSIBLE TO ENSURE THAT THE CONTENTS ARE KEPT STRICTLY CONFIDENTIAL. FAILURE TO DO SO IS A BREACH OF THE AGREEMENT YOU HAVE SIGNED WITH TAXLEAF FRANCHISE CORPORATION.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($staff_info['type']==1){ ?>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12 pull-right">
                                <div class="form-group">
                                    <a href="<?= base_url("/operational_manuals/add_forms/") ?>" class="btn btn-primary btn-sm pull-right" title="Add Operational Forms">
                                        <i class="fa fa-plus"></i> Add
                                    </a>
                                </div>
                            </div> 
                        </div>
                    <?php } ?>
                    </div>                    
                    <div id="load_data">
                        <?php
                        if (!empty($forms)):
                            foreach ($forms as $key => $row):
                                ?>
                                <div class="panel panel-default service-panel type2 filter-active">
                                    <div class="panel-heading">                                          
                                        <div class="table-responsive">
                                            <table class="table table-borderless" style="margin-bottom: 0px;">
                                                <tbody>
                                                    <tr>
                                                        <th width="33%">Title</th>
                                                        <th width="33%">File Name</th>
                                                        <th width="33%">Download</th>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $row['title']; ?></td>
                                                        <td>
                                                        <?php 
                                                            $ex = explode("_",$row['upload_file']);
                                                            echo end($ex);
                                                        ?></td>
                                                        <td><a href="<?php echo base_url(); ?>operational_manuals/download_file/<?php echo $row['upload_file']; ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <div class="text-center m-t-30">
                                <div class="alert alert-danger">
                                    <i class="fa fa-times-circle-o fa-4x"></i> 
                                    <h3><strong>Sorry !</strong> no data found</h3>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>