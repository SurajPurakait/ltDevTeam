<?php $staff_info = staff_info();
?>
    <div class="form-group client_type_div0">
        <label class="col-lg-2 control-label">Office</label>
        <div class="col-lg-10">
        <select class="form-control client_type_field0" name="office_id" id="staff_office" onchange="refresh_existing_client_list(this.value,'');" title="Office">
            <option value="">Select Office</option>
            <!-- <?php //load_ddl_option("staff_office_list",(isset($office_id)? $office_id:''), (staff_info()['type'] != 1) ? "staff_office" : ""); ?> -->
            <?php load_ddl_option("staff_office_list",$staff_info['office'], (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
        </select>
        </div>
        <div class="errorMessage text-danger"></div>
    </div>

    <div class="form-group client_type_div0" id="client_list">
        <label class="col-lg-2 control-label">Individual List</label>
        <div class="col-lg-10">
        <select class="form-control individual_list client_type_field0" name="client_list_id[]" id="individual_list_ddl" title="Individual List" <?php echo (isset($client_id) && $client_id !='') ? 'disabled' : ''; ?> onchange = "get_individual_client_id();" multiple>
            <option value="">Select an option</option>
            <?php load_ddl_option("existing_individual_list_new", (isset($client_id))? $client_id:''); ?>
        </select>
        </div>
        <div class="errorMessage text-danger"></div>
    </div>

<script>
    <?php if(isset($action_id) && $action_id!=''){ ?>
        refresh_existing_client_list('<?= $office_id ?>','<?= $client_id ?>');
   <?php }?>
   $("#individual_list_ddl").chosen();

    function get_individual_client_id() {
        var dropDown = document.getElementById('individual_list_ddl'), clientArray = [], i;
        for (i = 0; i < dropDown.options.length ; i += 1) {
            if (dropDown.options[i].selected) {
                clientArray.push( dropDown.options[i].value);
            }
        }
            // alert(clientArray);
            $.ajax({
            type: "POST",
            data: {
                client_id: clientArray
            },
            url: base_url + 'action/home/get_individual_practice_id',
            dataType: "html",
            success: function (result) {
                $("#client_id").val(result);
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }
    </script>