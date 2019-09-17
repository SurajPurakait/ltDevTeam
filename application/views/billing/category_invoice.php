<div class="wrapper wrapper-content">
    <div class="row">
        <?php foreach ($service_category_list as $scl): ?>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <a class="widget p-lg text-center ibox-content link-panel">
                    <img src="<?php echo base_url() ?>assets/img/settings.svg" alt="Merchant CC Service image" class="svg-icon m-b-md"/>
                    <h3 class="font-bold no-margins"></h3>
                    <div class="col-lg-12">
                        <center>
                            <select class="form-control text-center" title="Service" onchange="javascript:if (this.value != '')window.location.href = '<?= base_url('billing/invoice/create_invoice/'); ?>' + this.value;">
                                <option value="">--- <?= $scl['name']; ?> ---</option>
                                <?php load_ddl_option("get_service_list_by_category_id", "", $scl['id']); ?>
                            </select>
                        </center>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>