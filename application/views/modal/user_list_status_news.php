<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Edit Leads</h4>
        </div>
        <div class="modal-body">  
            <div class="alert alert-success p-t-0 p-b-0" style="background: #fff;borderborder-color: #5fcc61">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="p-t-10 p-b-10 m-b-0"><strong>Read By</strong></>
                    </div>
                    <div class="col-sm-9" style="border-left: 1px solid #5fcc61">
                        <?php 
                        if(!empty($read_assigned_list)) {
                            foreach ($read_assigned_list as $ral) {
                        ?>    
                        <span style="display: inline-block;word-break: break-word;color: #333;" class="p-5 m-t-2"><?= "|".strtoupper($ral['name']); ?></span>
                        <?php
                            }
                        } else {
                        ?>
                        <p class="text-center">Not yet read by anyone</p>    
                        <?php    
                        }    
                        ?>
                    </div>
                </div>
            </div>
            <div class="alert alert-danger p-t-0 p-b-0" style="background: #fff;borderborder-color: #a94442">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="p-t-10 p-b-0 m-b-0"><strong>Unread By</strong></p>
                    </div>
                    <div class="col-sm-9" style="border-left: 1px solid #a94442">
                    <?php
                        foreach ($total_assigned_list as $tal) {
                    ?>    
                        <span style="display: inline-block;word-break: break-word;color: #333;" class="p-5"><?= "|".strtoupper($tal['name']); ?></span>
                    <?php        
                        }    
                    ?>    
                    </div>
                </div>
            </div>  
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>  
    </div>
</div>