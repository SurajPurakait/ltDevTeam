<div class="wrapper wrapper-content">
    <div class="row">
        <?php
        if (!empty($main_cat)) {
            foreach ($main_cat as $mc) {
                ?>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <a class="widget p-lg text-center ibox-content link-panel" href="<?= base_url() . "marketing_materials/dashboard/" . $mc['id']; ?>">
                        <i class="fa <?= $mc['icon']; ?> fa-4x m-b-md"></i>
                        <h3 class="font-bold no-margins">
                            <?= $mc['name']; ?>
                        </h3>
                    </a>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <a class="widget p-lg text-center ibox-content link-panel" href="javascript:void(0);">
                    <i class="fa fa-plus-circle fa-4x m-b-md"></i>
                    <h3 class="font-bold no-margins">
                        No Category Found
                    </h3>
                </a>
            </div>
        <?php } ?>
    </div>
</div>