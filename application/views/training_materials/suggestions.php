<?php $staff_info = staff_info(); ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="service-tab" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Suggestion</th>
                                <th>Added By</th>
                                <th>Office</th>
                                <th>Added On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($suggestions) && count($suggestions) > 0) {
                                foreach ($suggestions as $sl) {
                                    $staff_info = staff_info_by_id($sl['added_by_user']);
                                    if ($sl['status'] == 0) {
                                        $status = 'New';
                                    } elseif ($sl['status'] == 1) {
                                        $status = 'Started';
                                    } else {
                                        $status = 'Completed';
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $sl['suggestion']; ?></td>
                                        <td><?php echo $staff_info['last_name'] . ', ' . $staff_info['first_name']; ?></td>
                                        <td><?php echo staff_office_name($sl['added_by_user']); ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($sl['added_on'])); ?></td>
                                        <td><a href='javascript:void(0);' onclick='change_suggestion_status("<?= $sl['id']; ?>", "<?= $sl['status']; ?>");'><span class='label label-primary label-block' style="width: 80px;"><?= $status; ?></span></a></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><th colspan="5">No Data Found</th></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="changePurchaseStatus" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad0" value="0"/>
                                <label for="rad0"><strong>New</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad1" value="1"/>
                                <label for="rad1"><strong>Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2" value="2"/>
                                <label for="rad2"><strong>Completed</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="rowid" value="">
                <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-btn" onclick="updateSuggestionStatus(1)">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($suggestions) && count($suggestions) > 0 && $suggestions != 0) { ?>
            if ($('#service-tab').length > 0) {
                $("#service-tab").dataTable();
            }
<?php } ?>
    });
    function change_suggestion_status(id, status) {
        $("#changePurchaseStatus #rowid").val(id);
        $("#changePurchaseStatus #rad" + status).attr('checked', 'checked');
        $('#changePurchaseStatus').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
</script>