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
                                <input type="radio" name="radio" id="rad1" value="1" <?= ($status == "1") ? "checked" : ""; ?>/>
                                <label for="rad1"><strong>New</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2" value="2" <?= ($status == "2") ? "checked" : ""; ?>/>
                                <label for="rad2"><strong>Completed</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad3" value="3" <?= ($status == "3") ? "checked" : ""; ?>/>
                                <label for="rad3"><strong>Canceled</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="visit_id" id="visit_id" value="<?= $visitation_id; ?>">
                <input type="hidden" name="visitation_status" id="visitation_status" value="<?= $status; ?>">
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="visitation-tracking-button" onclick="updateStatusVisitation()">Save changes</button>
            </div>

            
        </div>
    </div>


    <script type="text/javascript">
        <?php 
        if(!empty($tracking_logs)){
    ?>
        $('#status_log').dataTable({
            "bFilter": false, 
            "bInfo": false,
            "bPaginate": false,
            "sDom": '<"top">rt<"bottom"flp><"clear">'
        });
    <?php
        }
    ?>
    </script>