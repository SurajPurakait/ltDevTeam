<option value="">Select an option</option>
<?php
if(!empty($completed_orders)){
foreach ($completed_orders as $data) {
    ?>
    <option value="<?= $data['reference_id']; ?>" <?= ($data['reference_id']==$client_id)? 'selected':'' ?> ><?= $data['name']; ?></option>
    <?php
}
}
?>