<?php
$colors = array('bg-light-blue', 'bg-light-green', 'bg-light-red', '', 'bg-light-orange', 'bg-light-purple', 'bg-light-aqua');
foreach ($services as $key => $ord) {
    $random_keys = array_rand($colors);
    ?>
    <div class="well <?php echo $colors[$random_keys]; ?>" id="service_result_div_<?= $ord['order_id']; ?>">
        <div class="form-group" id="category_div_<?= $ord['order_id']; ?>">
            <label class="col-lg-2 control-label">Service Category<span class="text-danger">*</span></label>
            <div class="col-lg-10">
                <select disabled="" class="form-control disabled_field" name="edit_service_section[<?= $ord['order_id']; ?>][category_id]" onchange="getServiceDropdownByCategory(this.value, '', '<?= $ord['order_id']; ?>');" id="category_<?= $ord['order_id']; ?>" title="Service Category" required="">
                    <option value="">Select an option</option>
                    <?php load_ddl_option("get_service_category", $ord['category_id']); ?>
                </select>
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
        <div id="service_dropdown_div_<?= $ord['order_id']; ?>">
            <div class="form-group" id="service_dropdown_div_<?= $ord['order_id']; ?>">
                <label class="col-lg-2 control-label">Service<span class="text-danger">*</span></label>
                <div class="col-lg-10">
                    <select disabled="" class="form-control disabled_field" name="edit_service_section[<?= $ord['order_id']; ?>][service_id]" onchange="getServiceInfoById(this.value, <?= $ord['category_id']; ?>, <?= $ord['order_id']; ?>);" id="service<?= $ord['order_id']; ?>" title="Service" required="">
                        <option value="">Select an option</option>';
                        <?php load_ddl_option("get_service_list_by_category_id", $ord['service_id'], $ord['category_id']); ?>
                    </select>
                    <div class="errorMessage text-danger"></div>
                </div>
            </div>
        </div>
        <div id="service_div_<?= $ord['order_id']; ?>">
            <h3>Price</h3>
            <div class="form-group">
                <label class="col-lg-2 control-label">Retail Price</label>
                <div class="col-lg-10">
                    <input disabled class="form-control retail_price" type="text" title="Retail Price" value="<?= $ord['retail_price']; ?>" id="retail-price-<?= $ord['order_id']; ?>">
                    <input type="hidden" name="edit_service_section[<?= $ord['order_id']; ?>][retail_price]" value="<?= $ord['retail_price']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Override Price</label>
                <div class="col-lg-10">
                    <input placeholder="" numeric_valid="" onblur="countTotalPrice(<?= $ord['order_id']; ?>, this.value, '<?= $ord['retail_price']; ?>', document.getElementById('quantity<?= $ord['order_id']; ?>').value);" onkeyup="countTotalPrice(<?= $ord['order_id']; ?>, this.value, '<?= $ord['retail_price']; ?>', document.getElementById('quantity<?= $ord['order_id']; ?>').value);" class="form-control override_price" type="text" id="retail_price_override<?= $ord['order_id']; ?>" name="edit_service_section[<?= $ord['order_id']; ?>][retail_price_override]" title="Retail Price" value="<?= $ord['override_price']; ?>">
                    <div class="errorMessage text-danger"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Quantity<span class="text-danger">*</span></label>
                <div class="col-lg-10">
                    <select placeholder="" required="" class="form-control quantity" onchange="countTotalPrice(<?= $ord['order_id']; ?>, document.getElementById('retail_price_override<?= $ord['order_id']; ?>').value, '<?= $ord['retail_price']; ?>', this.value);" id="quantity<?= $ord['order_id']; ?>" name="edit_service_section[<?= $ord['order_id']; ?>][quantity]" title="Quantity">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option <?= $ord['quantity'] == $i ? 'selected="selected"' : ''; ?> value="<?= $i; ?>"><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Sub Total</label>
                <div class="col-lg-10">
                    <input readonly="" type="text" id="base_price_<?= $ord['order_id']; ?>" class="form-control total_price_each_service" value="<?= number_format((float) $ord['override_price'] * $ord['quantity'], 2, '.', ''); ?>">
                </div>
            </div>
            <?php
            $note_list = invoice_notes($ord['order_id'], $ord['service_id']);
            foreach ($note_list as $note) {
                ?>
                <div class="form-group" id="note_div_<?= $ord['order_id'] . '_' . $note['id']; ?>">
                    <label class="col-lg-2 control-label">Notes</label>
                    <div class="col-lg-10">
                        <div class="note-textarea-<?= $ord['order_id']; ?>">
                            <textarea class="form-control" name="edit_service_section[<?= $ord['order_id']; ?>][edit_note][<?= $note['id']; ?>]'; ?>" title="Notes"><?= $note['note']; ?></textarea>
                        </div>                        
                        <a href="javascript:void(0);"  onclick="deleteNote('note_div_<?= $ord['order_id'] . '_' . $note['id']; ?>', '<?= $note['id']; ?>', '1');" class="text-danger"><i class="fa fa-times"></i> Remove Note</a>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="form-group">
                <label class="col-lg-2 control-label">Notes</label>
                <div class="col-lg-10">
                    <div class="note-textarea-<?= $ord['order_id']; ?>">
                        <textarea class="form-control" name="edit_service_section[<?= $ord['order_id']; ?>][notes][]" title="Notes"></textarea>
                    </div>
                    <a href="javascript:void(0)" id="note_link_<?= $ord['order_id']; ?>" onclick="addNote(<?= $ord['order_id']; ?>);" class="text-success"><i class="fa fa-plus"></i> Add Notes</a>
                </div>
            </div>
            <?php if (end($services)['order_id'] == $ord['order_id']) { ?>
                <a href="javascript:void(0)" id="section_link_<?= $ord['order_id']; ?>" onclick="addService();" class="text-success pull-right"><h3><i class="fa fa-plus"></i> Add Another Service</h3></a><br>
            <?php } else { ?>
                <a href="javascript:void(0)" id="section_link_<?= $ord['order_id']; ?>" onclick="removeService(<?= $ord['order_id']; ?>);" class="text-danger pull-right"><h3><i class="fa fa-times"></i> Remove Service</h3></a><br>
                        <?php }
                        ?>            
        </div>
    </div>
<?php } ?>