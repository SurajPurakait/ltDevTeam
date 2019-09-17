<style type="text/css">
    .service-requests {
        width: 100%;
    }

    .service-requests tr th,
    .service-requests tr td {
        padding: 8px;
    }

    .service-mother {
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .service-mother.has-child {
        cursor: pointer;
    }

    .service-child {
        background: #fff;
        border-bottom: 1px solid #ddd;
    }

    .label-block {
        display: block;
        padding: 5px 8px;
    }
</style>
<?php
$staff_info = staff_info();
$staff_department = explode(',', $staff_info['department']);
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group new-form">                        
                        <div class="filters">
                            <label></label>
                            <div class="dropdown pull-right">
                                <a href="<?php echo base_url() ?>billing/home/add_document" title="Add Document" class="btn btn-primary dropdown-toggle"><i class="fa fa-plus"></i> Document</a>
                            </div>
                        </div>
                    </div>
                    <div class="ajaxdiv" id="document_dashboard_div">
                        <?php
                        $user_id = sess('user_id');
                        $user_info = staff_info();
                        $user_dept = $user_info['department'];
                        $usertype = $user_info['type'];
                        $i = 0;
                        foreach ($result as $value):
                            $row = (object) $value;
                            $document_list = payment_documents_by_deposit_id($row->id);
                            if ($row->added_by == sess('user_id') || !in_array(2, $staff_department)):
                                ?>
                                <div class="panel panel-default service-panel">
                                    <div class="panel-heading">
                                        <a href="<?= base_url() . 'billing/home/edit_document/' . $row->id; ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                        <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $row->id; ?>" aria-expanded="false" class="collapsed">
                                            <div class="table-responsive">
                                                <table class="table table-borderless" style="margin-bottom: 0px;">
                                                    <tr>
                                                        <th>ID#</th>
                                                        <th style="width:120px;">Invoice ID</th>                                                    
                                                        <th>Create Time</th>
                                                        <th>Requested by</th>
                                                        <th>Documents</th>
                                                    </tr>
                                                    <tr>
                                                        <td title="ID">#<?= $row->id; ?></td>
                                                        <td title="Invoice ID"><?= $row->invoice_id; ?></td>
                                                        <td title="Create Time"><?= date('m/d/Y', strtotime($row->create_time)); ?></td>
                                                        <td title="Requested by"><?= $row->requested_by; ?></td>
                                                        <td title="Documents"><span><a class="label label-warning" href="javascript:void(0)"><b><?= count($document_list); ?></b></a></span></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </h5>
                                    </div>
                                    <div id="collapse<?= $row->id; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th>Document#</th>
                                                        <th>Name</th>
                                                        <th>File</th>
                                                        <th>Date</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                    <?php if (!empty($document_list)): ?>
                                                        <?php foreach ($document_list as $row_inner): ?>
                                                            <tr>
                                                                <td title="ID">#<?= $row_inner['id']; ?></td>
                                                                <td title="File Name"><?= substr($row_inner['document'], 18); ?></td>
                                                                <td>
                                                                    <?php
                                                                    $document = $row_inner['document'];
                                                                    $extension = pathinfo($document, PATHINFO_EXTENSION);
                                                                    $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                                                    if (in_array($extension, $allowed_extension)):
                                                                        ?>
                                                                        <a href="javascript:void(0);" onclick="document.getElementById('modal_image_src').src = '<?= base_url('uploads/' . $document); ?>';" data-toggle="modal" data-target="#myModal"><img src="<?= base_url('uploads/' . $document); ?>" style="height: 25px; width: 25px;"/></a>
                                                                    <?php else: ?>
                                                                        <div>
                                                                            <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $document; ?>" title="<?= $document; ?>"><i class="fa fa-download"></i></a>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td title="Date"><?= date('m/d/Y', strtotime($row_inner['date'])); ?></td>
                                                                <td title="Notes">
                                                                    <input type="hidden" id="note_hidden_<?= $row_inner['id']; ?>" value="<?= $row_inner['note']; ?>">
                                                                    <a href="javascript:void(0);" onclick="paymentDashboardNoteModal(<?= $row_inner['id']; ?>);"><i class="fa fa-file-text-o"></i></a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>                            
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $i++;
                            endif;
                        endforeach;
                        if ($i == 0):
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
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Preview</h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="modal_image_src" src="<?= base_url('assets/img/no_image.png'); ?>" title="Preview" class="img-responsive"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showPaymentNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <div class="modal-body form-horizontal" id="note-body"></div>
            <div class="modal-footer">                    
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>