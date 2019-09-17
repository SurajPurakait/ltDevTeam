<h3>Price</h3>
<div class="form-group">
    <label class="col-lg-2 control-label">Retail Price</label>
    <div class="col-lg-10">
        <input disabled class="form-control retail_price" type="text" title="Retail Price" value="<?= $service_info['retail_price']; ?>" id="retail-price-<?= $section_id; ?>">
        <input type="hidden" name="service_section[<?= $section_id; ?>][retail_price]" value="<?= $service_info['retail_price']; ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Override Price</label>
    <div class="col-lg-10">
        <input placeholder="" numeric_valid="" onblur="countTotalPrice(<?= $section_id; ?>, this.value, '<?= $service_info['retail_price']; ?>', document.getElementById('quantity<?= $section_id; ?>').value);" onkeyup="countTotalPrice(<?= $section_id; ?>, this.value, '<?= $service_info['retail_price']; ?>', document.getElementById('quantity<?= $section_id; ?>').value);" class="form-control override_price" type="text" id="retail_price_override<?= $section_id; ?>" name="service_section[<?= $section_id; ?>][retail_price_override]" title="Retail Price" value="">
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Quantity<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select required="" onchange="countTotalPrice(<?= $section_id; ?>, document.getElementById('retail_price_override<?= $section_id; ?>').value, '<?= $service_info['retail_price']; ?>', this.value);" class="form-control quantity" id="quantity<?= $section_id; ?>" name="service_section[<?= $section_id; ?>][quantity]" title="Quantity">
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="<?= $i; ?>"><?= $i; ?></option>
            <?php endfor; ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Sub Total</label>
    <div class="col-lg-10">
        <input readonly="" type="text" id="base_price_<?= $section_id; ?>" class="form-control total_price_each_service" value="<?= $service_info['retail_price']; ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Notes</label>
    <div class="col-lg-10">
        <div class="note-textarea-<?= $section_id; ?>">
            <textarea class="form-control" name="service_section[<?= $section_id; ?>][notes][]" title="Notes"></textarea>
        </div>
        <a href="javascript:void(0)" id="note_link_<?= $section_id; ?>" onclick="addNote(<?= $section_id; ?>);" class="text-success"><i class="fa fa-plus"></i> Add Notes</a>
    </div>
</div>
<a href="javascript:void(0)" id="section_link_<?= $section_id; ?>" onclick="addService();" class="text-success pull-right"><h3><i class="fa fa-plus"></i> Add Another Service</h3></a><br>