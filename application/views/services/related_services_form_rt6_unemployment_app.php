<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="related_create_rt6_unemployment_app" onsubmit="related_create_rt6_unemployment_app(); return false;">
                       <div class="hr-line-dashed"></div>
                        <h3>Account number where Sales Tax will be debited</h3>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bank Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="bank_name" id="bank_name" required title="Bank Name" value="<?php echo isset($sales_tax_data['bank_name']) ? $sales_tax_data['bank_name'] : ''; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bank Account #<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="bank_account" id="bank_account" required title="Bank Account" value="<?php echo isset($sales_tax_data['bank_account_number']) ? $sales_tax_data['bank_account_number'] : ''; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bank Routing #<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" name="bank_routing" id="bank_routing" required title="Bank Routing" value="<?php echo isset($sales_tax_data['bank_routing_number']) ? $sales_tax_data['bank_routing_number'] : ''; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Personal Or Business Account<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="radio-inline"><input type="radio" <?php if(isset($sales_tax_data['acc_type1'])){echo ($sales_tax_data['acc_type1'] == 0) ? 'checked' : '';} ?> name="acctype1" value="0" id="acctype1_p" required="">Personal</label>
                                <label class="radio-inline"><input type="radio" <?php if(isset($sales_tax_data['acc_type1'])){echo ($sales_tax_data['acc_type1'] == 1) ? 'checked' : '';} ?> name="acctype1" value="1" id="acctype1_b" required="">Business</label>
                                <div class="errorMessage text-danger" id="acctype1_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Checking Or Savings Account<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="radio-inline"><input type="radio" <?php if(isset($sales_tax_data['acc_type2'])){echo ($sales_tax_data['acc_type2'] == 0) ? 'checked' : '';} ?> name="acctype2" value="0" id="acctype2_c" required="">Checking</label>
                                <label class="radio-inline"><input type="radio" <?php if(isset($sales_tax_data['acc_type2'])){echo ($sales_tax_data['acc_type2'] == 1) ? 'checked' : '';} ?> name="acctype2" value="1" id="acctype2_s" required="">Savings</label>
                                <div class="errorMessage text-danger" id="acctype2_error"></div>
                            </div>
                        </div>
                    
                    <div class="rt6-div ibox-content bg-2">
                        <h3>Sales Tax Application</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Will the company need Sales Tax Application as well?<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="radio-inline"><input <?php if(isset($sales_tax_data['salestax_availability'])){echo $sales_tax_data['salestax_availability'] == "Yes" ? "checked='checked'" : "";} ?> type="radio" name="Rt6" value="Yes" id="Rt6_1" required="">Yes</label>
                                <label class="radio-inline"><input <?php if(isset($sales_tax_data['salestax_availability'])){echo $sales_tax_data['salestax_availability'] == "No" ? "checked='checked'" : "";} ?> type="radio" name="Rt6" value="No" id="Rt6_2" required="">No</label>
                                <div class="errorMessage text-danger" id="Rt6_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload Void Cheque (pdf)<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="file" name="void_cheque" id="void_cheque" title="Void cheque" <?php if(isset($sales_tax_data['void_cheque'])) { echo ($sales_tax_data['void_cheque'] == '') ? "required" : "";} else { echo "required"; } ?>>
                                <div class="errorMessage text-danger"></div>
                                <?php if (isset($sales_tax_data['void_cheque'] )) {
                                    ?>
                                    <a href="<?= base_url() . "uploads/" . $sales_tax_data['void_cheque']; ?>" target="_blank">Cheque Pdf</a>
                                <?php }
                                ?>
                            </div>
                        </div>
                        <div class="rt6yes" <?php if(isset($sales_tax_data['salestax_availability'])){ echo $sales_tax_data['salestax_availability'] != "Yes" ? "style='display:none;'" : ""; } else { echo "style='display:none;'"; } ?>>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">RT-6 Number<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="rt6_number" id="rt6_number" title="RT-6 Number" value="<?php if(isset($sales_tax_data['salestax_number'])){echo $sales_tax_data['salestax_number'];} ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" name="state" title="State" id="statert6" value="<?php if(isset($sales_tax_data['state'])){echo $sales_tax_data['state'];} ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="rt6no" <?php if(isset($sales_tax_data['salestax_availability'])) { echo $sales_tax_data['salestax_availability'] != "No" ? "style='display:none;'" : ""; } else { echo "style='display:none;'"; } ?>>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Do you need Rt6?<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input type="radio" <?php if(isset($sales_tax_data['need_rt6'])){echo $sales_tax_data['need_rt6'] == "Yes" ? "checked='checked'" : "";} ?> name="Rt6need" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" <?php if(isset($sales_tax_data['need_rt6'])){echo $sales_tax_data['need_rt6'] == "No" ? "checked='checked'" : "";} ?> name="Rt6need" value="No">No</label>
                                    <div class="errorMessage text-danger" id="Rt6need_error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Select Resident or Non-resident<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <label class="radio-inline"><input type="radio" <?php if(isset($sales_tax_data['resident_type'])){echo $sales_tax_data['resident_type'] == "Resident" ? "checked='checked'" : "";} ?> name="residenttype" value="Resident">Resident</label>
                                    <label class="radio-inline"><input type="radio" <?php if(isset($sales_tax_data['resident_type'])){echo $sales_tax_data['resident_type'] == "Non-Resident" ? "checked='checked'" : "";} ?> name="residenttype" value="Non-Resident">Non-Resident</label>
                                    <div class="errorMessage text-danger" id="residenttype_error"></div>
                                </div>
                            </div>
                        </div> 
                        <div class="residentclass" <?php if(isset($sales_tax_data['resident_type'])) {echo $sales_tax_data['resident_type'] != "Resident" ? "style='display:none;'" : "";} else{ echo "style='display:none;'"; } ?>>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Resident Upload</label>
                                <div class="col-lg-10">
                                    <label>Upload Drivers License of All Owners</label>
                                    <div class="license-file">
                                        <input class="form-control license_file" type="file" name="license_file[]" id="license" title="Resident Upload">
                                    </div>
                                    <a href="javascript:void(0)" class="text-success add-license-file rel-serv-license-file"><i class="fa fa-plus"></i> Add License</a>
                                </div>
                            </div>
                            <?php if (!empty($all_driver_license)): ?>
                                <ul class="uploaded-file-list">
                                    <?php
                                    foreach ($all_driver_license as $adl):
                                        $extension = pathinfo($adl['file_name'], PATHINFO_EXTENSION);
                                        $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                        if (in_array($extension, $allowed_extension)):
                                            ?>
                                            <li>
                                                <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $adl['file_name']; ?>');max-width: 100%;">
                                                    <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $adl['file_name']; ?>" title="<?= $adl['file_name']; ?>"><i class="fa fa-search-plus"></i></a>
                                                </div>
                                                <p class="text-overflow-e" title="<?= $adl['file_name']; ?>"><?= $adl['file_name']; ?></p>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <div class="preview preview-file">
                                                    <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $adl['file_name']; ?>" title="<?= $adl['file_name']; ?>"><i class="fa fa-download"></i></a>
                                                </div>
                                                <p class="text-overflow-e" title="<?= $adl['file_name']; ?>"><?= $adl['file_name']; ?></p></li>
                                        <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                                <?php
                            endif;
                            ?>
                        </div>
                        <div class="non-residentclass" <?php if(isset($sales_tax_data['resident_type'])) { echo $sales_tax_data['resident_type'] != "Non-Resident" ? "style='display:none;'" : "";} else { echo "style='display:none;'"; } ?>>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Non-resident Upload</label>
                                <div class="col-lg-10">
                                    <label>Passport (pdf)<span class="text-danger">*</span></label> 
                                    <input class="form-control non_resident_file" type="file" name="passport" id="passport">
                                    <div class="errorMessage text-danger"></div>
                                    <?php if ($sales_tax_data['passport'] != '') {
                                        ?>
                                        <a href="<?php echo base_url() . "uploads/" . $sales_tax_data['passport']; ?>">Passport</a>
                                    <?php }
                                    ?>
                                </div>
                                <label class="col-lg-2 control-label"></label>
                                <div class="col-lg-10">
                                    <label>Lease (pdf)<span class="text-danger">*</span></label> 
                                    <input class="form-control non_resident_file" type="file" name="lease" id="lease">
                                    <div class="errorMessage text-danger"></div>
                                    <?php if ($sales_tax_data['lease'] != '') { ?>
                                        <a href="<?php echo base_url() . "uploads/" . $sales_tax_data['lease']; ?>">Lease</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row">-->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="99" id="retail-price">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="99">
                                <input type="hidden" id="retail-price-initialamt" value="99" />
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" numeric_valid="" id="retail_price_override" class="form-control" type="text" name="retail_price_override" id="retail_price_override" title="Retail Price" value="<?= count($get_override_price) > 0 ? $get_override_price[0]['price_charged'] : ""; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="new_reference_id" id="new_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_rt6_unemployment_app">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="">
                                <input type="hidden" name="order_id" id="order_id" value="<?= $order_id; ?>">
                                <input type="hidden" name="rt6_service_id" id="rt6_service_id" value="<?= $rt6_data['id']; ?>">
                                <button class="btn btn-success" type="button" onclick="related_create_rt6_unemployment_app('related_create_rt6_unemployment_app')">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelRelatedServiceForm('related_create_rt6_unemployment_app')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
        /* issue fixing js*/
        $('input[type=radio][name=Rt6]').change(function () {
            $(".non_resident_file").removeAttr('required');
            if (this.value == 'Yes') {
                $(".rt6yes").show();
                $(".rt6no").hide();
                $(".non-residentclass").hide();
                $(".residentclass").hide();
                $('input[type=radio][name=residenttype]').removeAttr('checked');
                $('input[type=radio][name=residenttype]').removeAttr('required');
                $("#rt6_number").prop('required', true);
                $("#statert6").prop('required', true);
                $(".license_file").removeAttr('required');
            } else {
                $(".rt6yes").hide();
                $(".rt6no").show();
                $(".residentclass").hide();
                $(".non-residentclass").hide();
                $('input[type=radio][name=residenttype]').removeAttr('checked');
                $('input[type=radio][name=residenttype]').attr('required', 'required');
                $("#rt6_number").prop('required', false);
                $("#statert6").prop('required', false);
            }
        });

         $('input[type=radio][name=residenttype]').change(function () {
            if (this.value == 'Resident') {
                $(".residentclass").show();
                $(".non-residentclass").hide();
//                $(".license_file").attr('required', 'required');
                $(".non_resident_file").removeAttr('required');
            } else {
                $(".residentclass").hide();
                $(".non-residentclass").show();
                $(".license_file").removeAttr('required');
                $(".non_resident_file").attr('required', 'required');
            }
        });

        $('.rel-serv-license-file').click(function () {
            var textlicense = $(this).prev('.license-file').html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group"  id="license_div' + div_count + '"><label class="col-lg-2 control-label"></label><div class="col-lg-10">' + textlicense + '<a href="javascript:void(0)" onclick="removeLicense(\'license_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove License</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });

    });   //document.ready end

    function removeLicense(divID) {
        $("#" + divID).remove();
    }
</script>





