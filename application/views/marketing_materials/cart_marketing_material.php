<?php $staff_info = staff_info(); ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div id="cart-main-id" <?php echo (!empty($cart_data))?'class="col-md-9"':'class="col-md-12"'; ?>>
            <div class="ibox items-ibox">
            	<div class="ibox-title">
                    <h5>Total <b class="item-count"><?php echo count($cart_data); ?></b> items in your cart &nbsp;</h5>
                </div>
                	
                    <?php //print_r($cart_data);
                    $total = 0;
                    if(!empty($cart_data)){
                    	?>
                    	<div class="ibox-content cart-th-class">
	                		<div class="table-responsive">
	                            <table class="table shoping-cart-table m-b-0">
	                                <thead>
	                                <tr>
	                                    <th width="10%"></th>
	                                    <th class="desc" width="15%">Product Description</th>
	                                    <th width="15%" class="text-center">Item Price</th>
	                                    <th width="10%" class="text-center">Quantity</th>
                                        <th width="15%" class="text-center">Language</th>
	                                    <th width="15%" class="text-center">Total Price</th>
	                                    <th width="12%" class="text-center">Action</th>
	                                    <th width="12%" class="text-center">Note</th>
	                                </tr>
	                                </thead>
	                            </table>
	                        </div>
	                	</div>
                    	<?php
                    	foreach($cart_data as $key=>$cd){
                            if($cd['language']==1){
                                $lang = 'English';
                            }elseif($cd['language']==2){
                                $lang = 'Spanish';
                            }else{
                                $lang = 'Portuguese';
                            }
                            if($cd['type']==2){
                                $price = get_dynamic_price($cd['material_id'],$cd['quantity']);
                            }else{
                                $price = $cd['price'];
                            }
                            $total += $price*$cd['quantity'];
                    		?>
                    		<div class="ibox-content cart-item-class" id="cart-item-<?php echo $cd['id']; ?>">
	                            <div class="table-responsive">
	                                <table class="table shoping-cart-table">
	                                    <tbody>
	                                    <tr>
	                                        <td width="10%">
	                                        	<?php if($cd['featured_img']!=''){
	                                        		echo '<img style="width: auto; max-width: 100%; max-height: 100px;" src="'.base_url().'uploads/'.$cd['featured_img'].'">';
	                                        	} else {
	                                        		echo '<div class="cart-product-imitation"></div>';
	                                        	}
	                                        	?>
	                                            
	                                        </td>
	                                        <td class="desc" width="15%">
	                                            <h3><?php echo $cd['title'] ?></h3>
	                                            <p class="small">
	                                                <?php echo (strlen($cd['material_desc'])>150)?substr($cd['material_desc'],0,150).'...':$cd['material_desc']; ?>
	                                            </p>
	                                        </td>
	                                        <td width="15%" class="text-center">
	                                            $<?php echo $price; ?>
	                                        </td>
	                                        <td width="10%" class="text-center">
	                                            <input type="number" onchange="change_quantity('<?php echo $cd['id'] ?>',this.value);" onkeyup="change_quantity('<?php echo $cd['id'] ?>',this.value);" id="item-quantity-<?php echo $cd['id'] ?>" min="1" class="form-control" value="<?php echo $cd['quantity']; ?>">
	                                        </td>
                                            <td width="15%" class="text-center">
                                                <?php echo $lang; ?>
                                            </td>
	                                        <td width="15%" class="text-center">
	                                            <h4 id="price-cart-<?php echo $cd['id']; ?>">
	                                                $<?php echo $price*$cd['quantity']; ?>
	                                            </h4>
	                                        </td>
	                                        <td width="12%" class="text-center">
                                                    <a href="javascript:void(0);" onclick="remove_from_cart('<?php echo $cd['id']; ?>')" data-toggle="tooltip" data-placement="top" title="Delete Item" class="text-danger"><i class="fa fa-lg fa-trash"></i></a>
	                                        </td>
	                                        <td width="12%" class="text-center">
                                                    <a href="javascript:void(0);" onclick="add_note_cart('<?php echo $cd['id']; ?>')" data-toggle="tooltip" data-placement="top" title="Add Note" class="text-success"><i class="fa fa-lg fa-file-text-o"></i></a>
	                                        </td>
	                                    </tr>
	                                    </tbody>
	                                </table>
	                            </div>

	                        </div>
                    		<?php
                    	}
                     ?>
                    
                <?php } else {
                	echo '<div class="ibox-content">';
                	echo 'Currently you have no items in your cart. <a href="'.base_url("/marketing_materials/").'">Continue Shopping</a>';
                	echo '</div>';
                } ?>
                
            </div>
        </div>
        <?php if(!empty($cart_data)){ ?>
	        <div class="col-md-3">
	        		<div class="ibox checkout-ibox">
	                    <div class="ibox-title">
	                        <h5>Cart Summary</h5>
	                    </div>
	                    <div class="ibox-content">
	                        <span>
	                            Total
	                        </span>
	                        <h2 class="font-bold m-b-0" id="cart-total">
                                <?php 
                                   $quan = 0;
                                    foreach($cart_data as $cd){
                                        $quan += $cd['quantity'];
                                        $marketing_id = $cd['material_id'];
                                        if($cd['type']==1){
                                         $itemprice = $cd['price'];
                                        }else{
                                          $itemprice = get_dynamic_price($cd['id'],$cd['quantity']);
                                        }
                                    }
                                    //$check_if_discount = check_if_discount($quan,$marketing_id); 

                                // if(!empty($check_if_discount)){
                                //     $dis_quan = $check_if_discount['quantity'];
                                //     $dis_price = $check_if_discount['price'];
                                //     // $remain_quan = $quan - $dis_quan;
                                //     // $price_dis_new = $dis_price*$dis_quan;
                                //     // $price_old = $itemprice*$remain_quan;
                                //     $new_price = $dis_price*$quan;
                                //     echo '$'.$new_price;
                                // }else{
                                //     echo '$'.$total;
                                // } 
                                    echo '$'.$total;
                                    ?>
	                        </h2>
	                    </div>
	                    <div class="ibox-content">
	                        <a href="<?php echo base_url("/marketing_materials/proceed_to_checkout/") ?>" class="btn btn-primary btn-block m-b-15"><i class="fa fa-shopping-cart"></i> Checkout</a>
	                        <a href="<?php echo base_url("/marketing_materials/") ?>" class="btn btn-white btn-block"> Cancel</a>
	                    </div>
	                </div>
	        </div>
        <?php } ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <!-- <form method="post" id="update_modal_form" action="<?//= base_url(); ?>marketing_materials/updateNotes">
                <div id="notes-modal-body" class="modal-body p-b-0"></div>
                <div class="modal-body p-t-0 text-right">
                    <button onclick="document.getElementById('update_modal_form').submit();this.disabled = true;this.innerHTML = 'Processing...';" type="submit" class="btn btn-primary">Update Note</button>
                </div>
            </form> -->
            <hr class="m-0"/>
            <form method="post" id="modal_note_form" action="<?= base_url(); ?>marketing_materials/addCartNotesmodal">
                <div class="modal-body">
                    <h4>Add New Note</h4>
                    <!-- <div class="col-lg-10">
                        <label class="checkbox-inline">
                            <input type="checkbox"  name="pending_request" id="pending_request" value="1"><b>Add to SOS Notification</b>
                        </label>
                    </div> -->
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="marketing_note[]"  title="Marketing Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-marketing-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="cartid" id="cartid">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="document.getElementById('modal_note_form').submit();this.disabled = true;this.innerHTML = 'Processing...';" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<script>
	$(function(){
		$('[data-toggle=tooltip]').tooltip();
	});
	function add_note_cart(id){
        $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>' + 'modal/add_note_cart',
        data: {
            id: id
        },
        success: function (result) {
            $('#showNotes #notes-modal-body').html(result);
            $("#showNotes #cartid").val(id);
            openModal('showNotes');
        }
       });
     }
</script>