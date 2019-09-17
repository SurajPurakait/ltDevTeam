<?php
$ci = &get_instance();
$ci->load->model('service_model');
if (!empty($related_service_id_arr)) {
    foreach ($related_service_id_arr as $key => $rel_ser_id) {
        $service2 = $ci->service_model->get_service_by_id($rel_ser_id);
        ?>
        <div id="related_service_<?= $rel_ser_id ?>" class="related_service row bg-<?= $key + 1 ?>">
            <div class="col-md-12">
                <br/>
                <h3><?= $service2['description'] ?></h3>
                <?php if ($rel_ser_id == 11) { ?>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">How many people are on payroll</label>
                        <div class="col-lg-10">
                            <select class="form-control payroll_people_total" name="payroll_people_total" title="Payroll People Total">
                                <option value="0">0</option>
                                <option value="1-10">1-10</option>
                                <option value="11-20">11-20</option>
                                <option value="21-30">21-30</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="payroll-price-hidd" value="<?= $related_service[$rel_ser_id] ?>">
                <?php } ?>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Retail Price</label>
                    <div class="col-lg-10">
                        <input disabled placeholder="" class="form-control retprice" type="text" title="Retail Price" value="<?= $related_service[$rel_ser_id] ?>">
                        <input type="hidden" name="related_service[retail_price][<?= $rel_ser_id ?>]" value="<?= $related_service[$rel_ser_id] ?>" class="retpricehidd">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Override Price</label>
                    <div class="col-lg-10">
                        <input placeholder="" class="form-control" type="text" numeric_valid="" id="override_price_<?= $rel_ser_id ?>" name="related_service[override_price][<?= $rel_ser_id ?>]" title="Retail Price" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
                <?= service_note_func('Note', 'n', 'service', "", $rel_ser_id); ?>
            </div>
        </div>
        <?php
    }
}
?>
<script src="<?= base_url(); ?>assets/js/system.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".payroll_people_total").change(function () {
            var val = $(".payroll_people_total option:selected").val();
            var amtval = $("#payroll-price-hidd").val();
            var initialamt = $("#payroll-price-hidd").val();
            var amt = parseInt(initialamt);
            if (val != '0') {
                if (val == '1-10') {
                    amt = parseInt(amtval) + 50;
                } else if (val == '11-20') {
                    amt = parseInt(amtval) + 100;
                } else if (val == '21-30') {
                    amt = parseInt(amtval) + 150;
                }
            }
            $(".retprice").val(amt);
            $(".retpricehidd").val(amt);
        });
    });
</script>