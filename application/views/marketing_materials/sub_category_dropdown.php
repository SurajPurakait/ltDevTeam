<select  class="form-control"  title="Sub Category" name="sub_cat" id="sub_cat" required>
<option value="">Select</option>
<?php if(!empty($sub_cat)){
        foreach($sub_cat as $c){ ?>
        <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
        <?php } } ?>
    </select>
<div class="errorMessage text-danger"></div>