<option value="">Select an option</option>
<?php
if(!empty($completed_orders)){
	foreach ($completed_orders as $data) {
	    ?>
	    <option <?= $client_id != "" ? 'selected="selected"' : '' ?> value="<?= $data['reference_id']; ?>"><?= $data['name']; ?></option>
	    <?php
	}
}
?>