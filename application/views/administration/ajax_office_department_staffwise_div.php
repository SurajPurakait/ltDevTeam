<?php if ($staff_type == '1') { ?>
    <div class="form-group">
        <label class="col-lg-3 control-label">Office<span class="text-danger">*</span></label>
        <div class="col-lg-9 office-inner">
            <select id="office" name="office[]" class="form-control" title="Office" required="">
                <option value="">Select</option>
                <?php
                if (!empty($office_list)) {
                    foreach ($office_list as $ol) {
                        ?>
                        <option value="<?php echo $ol['id']; ?>"><?php echo $ol['name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>

   <!--  <div class="form-group">
        <label class="col-lg-3 control-label">Deptartment<span class="text-danger">*</span></label>
        <div class="col-lg-9 dept-inner">
            <select id="department" name="department[]" class="form-control" title="Department" required="">
                <option value="">Select</option>
                <?php
                if (!empty($department_list)) {
                    foreach ($department_list as $dl) {
                        ?>
                        <option selected value="<?php echo $dl['id']; ?>"><?php echo $dl['name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div> -->
    <input type="hidden" name="department[]" value="<?php echo $department_list[0]['id']; ?>">
<?php } elseif ($staff_type == '2') { ?>
    <div class="form-group">
        <label class="col-lg-3 control-label">Office<span class="text-danger">*</span></label>
        <div class="col-lg-9 office-inner">
            <select id="office" name="office[]" class="form-control" title="Office" required="">
                <option value="">Select</option>
                <?php
                if (!empty($office_list)) {
                    foreach ($office_list as $ol) {
                        ?>
                        <option value="<?php echo $ol['id']; ?>"><?php echo $ol['name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Deptartment<span class="text-danger">*</span></label>
        <div class="col-lg-9 dept-inner">
            <select id="department" name="department[]" class="form-control" title="Department" required="" multiple>
                <?php
                if (!empty($department_list)) {
                    foreach ($department_list as $dl) {
                        ?>
                        <option value="<?php echo $dl['id']; ?>"><?php echo $dl['name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
<?php } elseif ($staff_type == '3') { ?>
    <div class="form-group">
        <label class="col-lg-3 control-label">Office<span class="text-danger">*</span></label>
        <div class="col-lg-9 office-inner">
            <select id="office" name="office[]" class="form-control" title="Office" multiple required="">
                <?php
                if (!empty($office_list)) {
                    foreach ($office_list as $ol) {
                        ?>
                        <option value="<?php echo $ol['id']; ?>"><?php echo $ol['name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
   <!--  <div class="form-group">
        <label class="col-lg-3 control-label">Role<span class="text-danger">*</span></label>
        <div class="col-lg-9">
            <select id="role" class="form-control" name="role" title="Role" required="">
                <option value=''>Select</option>
                <option value='1'>Standard</option>
                <option value='2'>Manager</option>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div> -->
    <input type="hidden" id="role" name="role" value="1">
    <input type="hidden" name="department[]" value="<?php echo $department_list[0]['id']; ?>">
    <!-- <div class="form-group">
        <label class="col-lg-3 control-label">Deptartment<span class="text-danger">*</span></label>
        <div class="col-lg-9 dept-inner">
            <select id="department" name="department[]" class="form-control" title="Department" required="">
                <option value="">Select</option>
                <?php
                if (!empty($department_list)) {
                    foreach ($department_list as $dl) {
                        ?>
                        <option selected value="<?php echo $dl['id']; ?>"><?php echo $dl['name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div> -->
<?php } ?>