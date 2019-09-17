<?php if ($modal_type != "edit"): ?>
    <div class="modal-dialog" id="seller_info_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Add Seller Info</h4>
            </div>
            <form role="form" id="seller_info_form" name="seller_info_form" method="POST">
            <div class="modal-body">                
                <input type="hidden" name="reference" value="<?= $reference; ?>">
                <input type="hidden" name="reference_id" value="<?= $reference_id; ?>">
                <div class="row form-group">
                    <div class="" id="has_itin_div">
                        <label class="col-lg-3">Have ITIN ?<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <label class="radio-inline"><input type="radio" name="have_itin" value="Yes" title="Yes" required="" checked>Yes</label>
                            <label class="radio-inline"><input type="radio" name="have_itin" value="No" title="No" required="">No</label>
                            <div class="errorMessage text-danger" id="has_itin_error"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group itin_number_div">
                    <label class="">ITIN Number #<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="itin_number" id="itin_number" required title="ITIN Number" value="" phoneval>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="no_itin" style="display:none;">
                <div class="form-group">
                    <div class="">
                        <label>Passport (pdf)<span class="text-danger">*</span></label>
                    </div>
                    <div class="">
                        <input class="form-control" type="file" name="passport" id="passport">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>    
                <div class="form-group"> 
                    <div class="">
                        <label>Visa (pdf)<span class="text-danger">*</span></label>
                    </div>   
                    <div class="">
                        <input class="form-control" type="file" name="visa" id="visa">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="">
                        <label>Full Foreign Address<span class="text-danger">*</span></label>
                    </div>
                    <div class="">
                        <textarea class="form-control" name="full_foreign_address" id="full_foreign_address" title="Full Foreign Address" placeholder="Full Foreign Address"></textarea>
                        <div class="errorMessage text-danger"></div>
                    </div>
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
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_seller_info()">Save changes
                </button>
            </div>
           </form>  
        </div>
    </div>

<?php else: ?>
    <div class="modal-dialog" id="seller_info_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Add Seller Info</h4>
            </div>
            <form role="form" id="seller_info_form" name="seller_info_form" method="POST">
            <div class="modal-body">                
                <input type="hidden" name="reference" value="<?= $reference; ?>">
                <input type="hidden" name="reference_id" value="<?= $seller_data['reference_id']; ?>">
                <div class="row form-group">
                    <div class="" id="has_itin_div">
                        <label class="col-lg-3">Have ITIN ?<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <label class="radio-inline"><input type="radio" name="have_itin" value="Yes" title="Yes" required="" <?= ($seller_data['itin_number'] != 0) ? 'checked':''; ?>
                            >Yes</label>
                            <label class="radio-inline"><input type="radio" name="have_itin" value="No" title="No" required="" <?= ($seller_data['itin_number'] != 0) ? '':'checked'; ?>>No</label>
                            <div class="errorMessage text-danger" id="has_itin_error"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group itin_number_div" <?= ($seller_data['itin_number'] != 0) ? '':'style="display:none;"'; ?>>
                    <label class="">ITIN Number #<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="itin_number" id="itin_number" required title="ITIN Number" value="<?= $seller_data['itin_number']; ?>" phoneval>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="no_itin" <?= ($seller_data['itin_number'] != 0) ? 'style="display:none;"':''; ?>>
                <div class="form-group">
                    <div class="">
                        <label>Passport (pdf)<span class="text-danger">*</span></label>
                    </div>
                    <div class="">
                        <input class="form-control" type="file" name="passport" id="passport">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <a href="<?= base_url() . 'uploads/'.$seller_data['passport']; ?>" target="_blank"><?= $seller_data['passport']; ?></a>    
                <div class="form-group"> 
                    <div class="">
                        <label>Visa (pdf)<span class="text-danger">*</span></label>
                    </div>   
                    <div class="">
                        <input class="form-control" type="file" name="visa" id="visa">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <a href="<?= base_url() . 'uploads/'.$seller_data['visa']; ?>" target="_blank"><?= $seller_data['visa']; ?></a>
                <div class="form-group">
                    <div class="">
                        <label>Full Foreign Address<span class="text-danger">*</span></label>
                    </div>
                    <div class="">
                        <textarea class="form-control" name="full_foreign_address" id="full_foreign_address" title="Full Foreign Address" placeholder="Full Foreign Address"><?php echo $seller_data['full_address'] ;?></textarea>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                </div>
                <div class="form-group">
                    <label class="">Full Name<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="full_name" id="full_name" required title="Full Name" value="<?= $seller_data['fullname']; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="">Contact Information<span class="text-danger">*</span></label>
                    <div class="">
                        <input placeholder="" class="form-control" type="text" name="contact_information" id="contact_information" required title="Conatct Information" value="<?= $seller_data['contact_information']; ?>" phoneval>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>       
           </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="update_seller_info(<?= $seller_data['id']; ?>)">Save changes
                </button>
            </div>
           </form>  
        </div>
    </div>
<?php endif; ?>

<script type="text/javascript">
    
    $(function () {
        // $('input[type=radio][name=have_itin]').bind('load change', function () {
        $('input[type=radio][name=have_itin]').change(function () {
            if (this.value == 'Yes') {
                $(".no_itin").hide();
                $(".itin_number_div").show();
                $("#passport").removeAttr('required');
                $("#visa").removeAttr('required');
                $("#full_foreign_address").removeAttr('required');
            } else {
                $(".no_itin").show();
                $(".itin_number_div").hide();
                $("#itin_number").removeAttr('required');
                $('#passport').attr('required', 'required');
                $('#visa').attr('required', 'required');
                $('#full_foreign_address').attr('required', 'required');
            }
        });    
    });
</script>