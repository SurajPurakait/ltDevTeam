<div class="modal-dialog" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php if (isset($record_details) && !empty($record_details)) { ?>
            <div class="modal-header">
                <h3 class="modal-title">Recoded Time List</h3>

            </div>
            <div class="modal-body">
                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th style="text-align:center">#</th>
                            <th style="text-align:center">Recoded Time</th>
                            <th style="text-align:center">Entry Time</th>
                            <th style="text-align:center">Delete</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php foreach ($record_details as $key => $record) { ?>
                            <tr>
                                <td style="text-align:center"><?= $key + 1 ?></td>
                                <td style="text-align:center"><?= $record['record_time'] ?></td>
                                <td style="text-align:center"><?= date('m/d/Y h:i:sa', strtotime($record['created_at'])) ?></td>
                                <td style="text-align:center"><a href="javascript:void(0)" onclick="delete_recoded_time(<?= $record['id'] ?>,<?= $record['bank_id'] ?>)"><span class="fa fa-trash text-danger m-l-4"></span></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_recoded_modal(<?= $record['bank_id']; ?>, '<?= $section ?>')">Close</button>
            </div>
        <?php } else { ?>
            <div class = "text-center m-t-30">
                <div class = "alert alert-danger">
                    <i class = "fa fa-times-circle-o fa-4x"></i>
                    <h3><strong>Sorry!</strong> no data found</h3>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


