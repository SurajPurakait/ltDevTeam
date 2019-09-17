<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="dropdown pull-right">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i
                            class="fa fa-plus"></i></button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo base_url("/lead_management/lead_mail/add_new_mail") ?>">
                                Add New Email
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="ibox-content">
                    <?php
                    if (!empty($lead_mail_content)) {
                        foreach ($lead_mail_content as $lmc) {
                            ?>
                    <a href="<?php echo base_url("/lead_management/lead_mail/copy_mail/" . $lmc['id'] . "") ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i>Copy Mail</a>
                            <div class="panel panel-default service-panel">
                                <div class="panel-heading">
                                    <?php if ($lmc['status'] == 0) { ?><a href="<?php echo base_url("/lead_management/lead_mail/edit_new_mail/" . $lmc['id'] . "") ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a><?php } ?>
                                    <a href="javascript:void(0);" onclick="delete_lead_mail('<?= $lmc['id'] ?>');" class="btn btn-danger btn-xs btn-service-delete"><i class="fa fa-times" aria-hidden="true"></i>Delete</a>
                                    <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse89" aria-expanded="false">
                                        <div class="table-responsive">
                                            <table class="table table-borderless" style="margin-bottom: 0px;">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:300px;">Email Subject</th>
                                                        <th style="width:300px;">Email Schedule Date</th>
                                                        <th>Email Body</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $lmc['subject']; ?></td>
                                                        <td><?php echo date('m/d/Y',strtotime($lmc['schedule_date'])); ?></td>
                                                        <td><?php echo substr(urldecode($lmc['body']), 0, 30); ?></td>
                                                        <td><?php echo ($lmc['status'] == 0) ? 'Pending' : 'Sent'; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </h5>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo 'No data found';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>