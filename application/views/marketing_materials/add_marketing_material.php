<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_add_training_videos">
                        <h3>Add New Marketing Material</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">For Which Site<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" value="1" type="checkbox" id="forwhich1" name="for_which[]" title="For Which Site">Taxleaf
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" value="2" type="checkbox" id="forwhich2" name="for_which[]" title="For Which Site">Contadormiami
                                </label>
                                <div class="errorMessage text-danger" id="for_which_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" value="1" type="checkbox" id="language1" name="language[]" title="Language">English
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" value="2" type="checkbox" id="language2" name="language[]" title="Language">Spanish
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" required="" multi="" value="3" type="checkbox" id="language3" name="language[]" title="Language">Portuguese
                                </label>
                                <div class="errorMessage text-danger" id="language_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" required title="Title" id="title" name="title">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Description<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" required title="Description" id="description" name="description"></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Price Type<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <label class="radio-inline"><input class="gender" type="radio" value="1" name="price_type" title="Price Type" required="">Static</label>
                                <label class="radio-inline"><input class="gender" type="radio" value="2" name="price_type" title="Price Type" required="">Dynamic</label>
                                <div class="errorMessage text-danger" id="price_type_error"></div>
                            </div>
                        </div>
                        <div id="staticPrice" style="display: none;">
                        <div class="form-group">
                            <label class="col-lg-2 control-label statprice">Price</label>
                            <div class="col-lg-10">
                                <input class="form-control statinput" type="text" numeric_valid="" title="Price" id="price" name="price">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        </div>
                        <div id="priceWithQuantity" style="display: none;">
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
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Main Category<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select  class="form-control"  title="Main Category" name="main_cat" id="main_cat" required onchange="get_marketing_sub_cats()">
                                    <option value="">Select</option>          
                                    <?php
                                    if (!empty($main_cat)) {
                                        foreach ($main_cat as $c) {
                                            ?>
                                            <option value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
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
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload Featured Image<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="m-t-5 file-upload" allowed_types="gif|png|jpg|jpeg" id="image_file" type="file" name="image_file" title="Featured Image" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success save_btn" type="button" onclick="add_marketing_materials()">
                                    Save Changes
                                </button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancel_marketing_materials()">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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