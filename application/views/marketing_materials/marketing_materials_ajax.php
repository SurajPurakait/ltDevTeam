<?php
$user_info = staff_info();
$usertype = $user_info['type'];
//print_r($all_materials); exit;
if (!empty($all_materials)):
    ?>
    <div id="sortable">
        <?php
        foreach ($all_materials as $key => $row):
//        $visible_array = explode(",", $row['visible_by']);
//        if (in_array($usertype, $visible_array)) {
            ?>
            <article data-article-id="<?php echo $row['id']; ?>">
                <div class="panel panel-default service-panel type2 filter-active">
                    <div class="panel-heading">
                        <?php if ($usertype == 1) { ?>
                            <a href="<?= base_url("/marketing_materials/edit_marketing_material/{$row["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            <a href="javascript:void(0);" onclick="delete_marketing_materials('<?php echo $row['id'] ?>');" class="btn btn-danger btn-xs btn-service-delete m-r-5"><i class="fa fa-times" aria-hidden="true"></i>Delete</a><?php } ?>
                        <h5 class="panel-title"></h5>
                        <div class="row">
                            <div class="col-md-3 text-center p-t-10 p-b-10">
                                <!-- images here -->
                                <a href="javascript:void(0);" onclick="enlargeImage('<?= $row['featured_img']; ?>')">
                                    <img style="width: auto; max-width: 100%; max-height: 160px;" src="<?php echo base_url(); ?>uploads/<?= $row['featured_img']; ?>"></a>
                            </div>
                            <div class="col-md-9">
                                <div class="description p-t-5">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-5 m-b-10">
                                            <label class="price-metarials">Title :</label> 
                                            <span><?= $row['title']; ?></span> 
                                        </div>
                                        <?php $get_languages = get_marketing_languages($row["id"]);
                                            if(!empty($get_languages)){
                                         ?>
                                        <div class="col-sm-6 col-md-5 m-b-10">
                                            <?php foreach($get_languages as $gl) {
                                                  if($gl['language']==1){
                                                    $lang = 'English';
                                                  }elseif($gl['language']==2){
                                                    $lang = 'Spanish';
                                                  }else{
                                                    $lang = 'Portuguese';
                                                  }  
                                             ?>
                                            <label class="checkbox-inline m-l-0 m-r-5" style="font-weight: 600"><input type="checkbox" name="lang_check<?php echo $row['id'] ?>[]" value="<?php echo $gl['language']; ?>"><?php echo $lang; ?></label>
                                            <?php } ?>
                                        </div> 
                                        <?php } ?>                                       
                                        <!--<div class="col-md-3 col-xs-6 m-b-10">                                             
                                            <a href="javascript:void(0);" onclick="show_marketing_notes('<?php //echo $row['id'] ?>')" class="btn btn-success m-t-10 btn-xs"><i class="fa fa-plus"></i> Add Note</a>
                                        </div>-->
                                    </div>
                                    <hr class="m-t-5 m-b-10"/>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-5 m-b-10">
                                            <label>Description:</label>
                                            <span><?= $row['material_desc']; ?></span> 
                                        </div>
                                        <?php if($row['type']==1){ ?>
                                        <div class="col-md-4 col-xs-6 m-b-10">
                                            <label>Quantity :</label> 
                                            <input type="number" name="item_quantity" id="item-quantity-<?php echo $row['id'] ?>" class="form-control quantity-class" min="1" value="1">
                                        </div>
                                        <?php } else { 
                                            $marketing_q_p = marketing_q_p($row['id']);
                                        ?>
                                            <div class="col-md-4 col-xs-6 m-b-10">
                                            <label>Quantity With Price :</label> 
                                            <select onchange="get_dynamice_price(this);" class="form-control" title="Quantity With Price" name="price_quantity" id="price-quantity-<?php echo $row['id'] ?>">
                                            <option value="">Select an option</option>          
                                                <?php
                                                if (!empty($marketing_q_p)) {
                                                    foreach ($marketing_q_p as $c) {
                                                        ?>
                                                        <option value="<?= $c['price']; ?>"><?= $c['quantity']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php } ?>
                                        <div class="col-sm-6 col-md-3 m-b-10">                                            
                                            <label class="price-metarials">Price:</label>                                                
                                            <span class="p-l-10 price<?= $row['id']; ?>">$<?= $row['price']; ?> </span>  
                                        </div>
                                    </div>
                                </div>
                                <hr class="m-t-5 m-b-10"/>
                                <div class="row">
                                    <div class="col-md-5 m-b-10">                                       
                                        <label>Main Category:</label>                                            
                                        <span><?= $row['main_cat_name']; ?></span>                                             
                                    </div>
                                    <div class="col-md-4 m-b-10">                                        
                                        <label class="sub-materials">Sub Category:</label>                                            
                                        <span><?= $row['sub_cat_name']; ?></span>                                           
                                    </div>
                                    <div class="col-md-3 m-b-10">
                                        <div class="clearfix cart-section">
                                            <a href="javascript:void(0);" onclick="add_to_cart('<?php echo $row['id'] ?>');" class="price-metarials text-danger"><i class="fa fa-cart-plus" aria-hidden="true"></i> <b>Add To Cart</b></a>
                                        </div>
                                    </div>
                                </div>

                            </div>                   
                        </div>
                    </div>
                </div>
        </div>
        </article>
        <?php
        //} 
    endforeach;
    ?>
    </div>
<?php else: ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i> 
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
<?php endif; ?>
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
    function get_dynamice_price(that){
        var val = $(that).attr('id');
        var sp = val.split('-');
        var price = $("#"+val+" option:selected").val();
        if(price==''){
            price = '0';
        }
        var priceval = '$'+price;
        $(".price"+sp[2]).html(priceval);
    }
</script>