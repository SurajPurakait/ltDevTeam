<?php
if ($section == 'service') {
    ?>
    <option value="">Select Service</option>
    <?php
    if (!empty($service_list)) {
        foreach ($service_list as $service_arr) {
            ?>
            <option value="<?= $service_arr['id'] ?>" <?= ($select_sevice == $service_arr['id']) ? 'selected' : '' ?> ><?= $service_arr['description'] ?></option>
            <?php
        }
    }
}
?>