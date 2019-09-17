<div class="form-group">
  <div class="col-lg-10">
        <label class="checkbox-inline">
            <input type="checkbox" name="extra_services[]" onclick="add_extra_service_price(<?php echo $corporate_service_info['retail_price']; ?>,this)" price="<?php echo $corporate_service_info['retail_price']; ?>" id="corporate_bylaws" value="<?php echo $corporate_service_info['id']; ?>"><b>Corporate Bylaws</b>
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="extra_services[]" onclick="add_extra_service_price(<?php echo $corporate_service_info['retail_price']; ?>,this)" price="<?php echo $shareholders_service_info['retail_price']; ?>" id="shareholders_agreement" value="<?php echo $shareholders_service_info['id']; ?>"><b>Shareholders Agreement</b>
        </label>
    </div>
</div>