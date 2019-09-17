<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins form-inline">
<!--                <select name="ofc" id="ofc" class="form-control">
                    <option value="">Select Office</option>   
                    <?php foreach ($staff_office as $so) { ?>
                        <option value="<?php echo $so['id']; ?>"><?php echo $so['name']; ?></option>
                    <?php } ?>
                </select>-->
                <div class="ibox-content" id="ajax-div-log">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    get_log_data_ajx();
</script>
