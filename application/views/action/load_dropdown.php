<?php
if (!empty($data)) {
    foreach ($data as $data_arr) {
        ?>
        <option value="<?php echo $data_arr['id']; ?>"><?php echo $data_arr['name']; ?></option>
        <?php
    }
}
?>
