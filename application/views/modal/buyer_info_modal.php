<?php if ($modal_type != "edit"): ?>

    <div class="modal-dialog" id="buyer_info_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Add Buyer Info</h4>
            </div>
            <form role="form" id="buyer_info_form" name="buyer_info_form" method="POST">
            <div class="modal-body">  
                <input type="hidden" name="reference" value="<?= $reference; ?>">
                <input type="hidden" name="reference_id" value="<?= $reference_id; ?>">
                <div class="form-group">
                    <label class="">ITIN Number #<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="itin_number" id="itin_number" required title="ITIN Number" value="" phoneval>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="">Full Name<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="full_name" id="full_name" required title="Full Name" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="">Contact Information<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="contact_information" id="contact_information" required title="Conatct Information" value="" phoneval>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>                   
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_buyer_info()">Save changes
                </button>
             </div>
             </form>  
        </div>
    </div>

<?php else: ?>
    <div class="modal-dialog" id="buyer_info_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Add Buyer Info</h4>
            </div>
            <form role="form" id="buyer_info_form" name="buyer_info_form" method="POST">
            <div class="modal-body">  
                <input type="hidden" name="reference" value="<?= $reference; ?>">
                <input type="hidden" name="reference_id" value="<?php echo $buyer_data['reference_id'] ; ?>">
                <div class="form-group">
                    <label class="">ITIN Number #<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="itin_number" id="itin_number" required title="ITIN Number" value="<?php echo $buyer_data['itin_number'] ; ?>" phoneval>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="">Full Name<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="full_name" id="full_name" required title="Full Name" value="<?php echo $buyer_data['fullname'] ; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="">Contact Information<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="contact_information" id="contact_information" required title="Conatct Information" value="<?php echo $buyer_data['contact_information']; ?>" phoneval>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>                   
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="update_buyer_info(<?= $buyer_data['id']; ?>)">Save changes
                </button>
             </div>
             </form>  
        </div>
    </div>        

<?php endif; ?>