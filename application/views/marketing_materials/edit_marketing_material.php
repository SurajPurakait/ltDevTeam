<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_edit_training_videos">
                        <h3>Edit Marketing Material</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">For Which Site<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <?php 
                                $fwarr = array();
                                foreach($for_which as $fw){
                                    array_push($fwarr,$fw['for_which']);
                                }
                                 ?>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" <?php echo in_array('1',$fwarr) ? 'checked' : ''; ?> value="1" type="checkbox" id="forwhich1" name="for_which[]" title="For Which Site">Taxleaf
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" <?php echo in_array('2',$fwarr) ? 'checked' : ''; ?> value="2" type="checkbox" id="forwhich2" name="for_which[]" title="For Which Site">Contadormiami
                                </label>
                                <div class="errorMessage text-danger" id="for_which_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                 <?php 
                                $larr = array();
                                foreach($language as $l){
                                    array_push($larr,$l['language']);
                                }
                                 ?>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" <?php echo in_array('1',$larr) ? 'checked' : ''; ?> value="1" type="checkbox" id="language1" name="language[]" title="Language">English
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" <?php echo in_array('2',$larr) ? 'checked' : ''; ?> value="2" type="checkbox" id="language2" name="language[]" title="Language">Spanish
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" <?php echo in_array('3',$larr) ? 'checked' : ''; ?> value="3" type="checkbox" id="language3" name="language[]" title="Language">Portuguese
                                </label>
                                <div class="errorMessage text-danger" id="language_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" required title="Title" id="title" name="title" value="<?= $data['title']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Description<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" required title="Description" id="description" name="description"><?= $data['material_desc']; ?></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Price Type<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="radio-inline"><input class="gender" type="radio" value="1" name="price_type" title="Price Type" required="" <?php echo ($data['type']==1) ? 'checked' : ''; ?>>Static</label>
                                <label class="radio-inline"><input class="gender" type="radio" value="2" name="price_type" title="Price Type" required="" <?php echo ($data['type']==2) ? 'checked' : ''; ?>>Dynamic</label>
                                <div class="errorMessage text-danger" id="price_type_error"></div>
                            </div>
                        </div>
                        <div id="staticPrice" <?php echo ($data['type']==1) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                        <div class="form-group">
                            <label class="col-lg-2 control-label statprice">Price<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control statinput" type="text" numeric_valid="" required title="Price" id="price" name="price" value="<?= $data['price']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        </div>
                        <div id="priceWithQuantity" <?php echo ($data['type']==2) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                <label class="col-lg-2 control-label dynaprice">Price With Quantity</label>
                                <div class="col-lg-4">
                                    <input class="form-control dynainput" type="text" numeric_valid="" title="Dynamic Price" name="dynamic_price[]" placeholder="Price">
                                    <div class="errorMessage text-danger"></div>
                                </div>                            
                                <div class="col-lg-4">
                                    <input class="form-control dynamic_quantity dynainput" type="number" numeric_valid="" title="Dynamic Quantity" name="dynamic_quantity[]" placeholder="Quantity">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                                <div class="col-lg-2">
                                    <a href="javascript:void(0);" id="addPriceWithQuantity" class="btn"><i class="fa fa-plus"></i> Add Another</a>
                                </div>
                            </div>
                        </div>
                         <?php if(!empty($dynamic_price_quantity)){ ?>
                        <div id="previousPriceWithQuantity">
                            <?php
                                foreach($dynamic_price_quantity as $dpq){ ?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label"></label>
                                <div class="col-lg-4">
                                    <input class="form-control" type="text" numeric_valid="" title="Dynamic Price" name="dynamic_price[]" placeholder="Price" value="<?php echo $dpq['price']; ?>">
                                </div>                            
                                <div class="col-lg-4">
                                    <input class="form-control dynamic_quantity" type="number" numeric_valid="" title="Dynamic Quantity" name="dynamic_quantity[]" placeholder="Quantity" value="<?php echo $dpq['quantity']; ?>">
                                </div>
                                <div class="col-lg-2">
                                    <a href="javascript:void(0);" class="btn remove-price-with-quantity"><i class="fa fa-close text-danger"></i> Remove</a>
                                </div>
                            </div>
                            <?php }
                            ?>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Main Category<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select  class="form-control"  title="Main Category" name="main_cat" id="main_cat" required onchange="get_marketing_sub_cats()">
                                    <option value="">Select an option</option>          
                                    <?php
                                    if (!empty($main_cat)) {
                                        foreach ($main_cat as $c) {
                                            ?>
                                            <option <?= ($data['main_cat'] == $c['id']) ? 'selected' : ''; ?> value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sub Category<span class="text-danger">*</span></label>
                            <div class="col-lg-10 subcat">
                                <select  class="form-control"  title="Sub Category" name="sub_cat" id="sub_cat" required>
                                    <option value="">Select</option>
                                    <?php
                                    if (!empty($sub_cat)) {
                                        foreach ($sub_cat as $c) {
                                            ?>
                                            <option <?= ($data['sub_cat'] == $c['id']) ? 'selected' : ''; ?> value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-lg-offset-2 col-lg-3">
                                <div class="panel panel-default">
                                    <img width="100%" src="<?php echo base_url(); ?>uploads/<?= $data['featured_img']; ?>">
                                </div>
                            </div>           
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload Featured Image</label>
                            <div class="col-lg-10">
                                <input class="m-t-5 file-upload" allowed_types="gif|png|jpg|jpeg" id="image_file" type="file" name="image_file" title="Featured Image">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <input type="hidden" name="id" id="mt_id" value="<?= $data["id"]; ?>">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success save_btn" type="button" onclick="update_marketing_materials()">Save Changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_marketing_materials()">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="videomodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Preview</h4>
            </div>
            <div class="modal-body">
                <div id="vid"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="videomodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Preview</h4>
            </div>
            <div class="modal-body">
                <div id="vid"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.add-upload-file').on("click", function () {
            var text_file = $(this).prev('.upload-file-div').html();
            var file_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-2 control-label">' + file_label + '</label><div class="col-lg-10">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });

        $("input[name='price_type']").change(function(){
            var val = $(this).val();
            if(val==1){
                $("#staticPrice").show();
                $(".statprice").html('Price<span class="text-danger">*</span>');
                $(".statinput").prop('required',true);
                $(".dynaprice").html('Price With Quantity');
                $(".dynainput").removeAttr('required');
                $("#priceWithQuantity").hide();
            }else{
                $("#staticPrice").hide();
                $("#priceWithQuantity").show();
                $(".statprice").html('Price');
                $(".statinput").removeAttr('required');
                $(".dynaprice").html('Price With Quantity<span class="text-danger">*</span>');
                $(".dynainput").prop('required',true);
            }
        });

        $(document).on('change', '.dynamic_quantity',function(){
            var quantity = $(this).val();
            if(quantity < 1){
                $(this).val(1);
            }
        });

        $(document).on('focus', '.dynamic_quantity',function(){
            var quantity = $(this).val();
            if(quantity == ''){
                $(this).val(1);
            }
        });

        $(document).on('click', '#addPriceWithQuantity', function(e){
            e.preventDefault();
            var template = '<div class="form-group"><label class="col-lg-2 control-label"></label><div class="col-lg-4"><input class="form-control" type="text" numeric_valid="" title="Dynamic Price" name="dynamic_price[]" placeholder="Price"></div><div class="col-lg-4"><input class="form-control dynamic_quantity" type="number" numeric_valid="" title="Dynamic Quantity" name="dynamic_quantity[]" placeholder="Quantity"></div><div class="col-lg-2"><a href="javascript:void(0);" class="btn remove-price-with-quantity"><i class="fa fa-close text-danger"></i> Remove</a></div></div>';
            $(this).closest('.form-group').after(template);
        });

        $(document).on('click', '.remove-price-with-quantity', function(e){
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });
    });
    function removeFile(divID) {
        $("#" + divID).remove();
    }
</script>