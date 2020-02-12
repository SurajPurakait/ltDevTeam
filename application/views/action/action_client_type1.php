
    <div class="form-group client_type_div0">
        <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
        <div class="col-lg-10">
        <select class="form-control client_type_field0" name="office_id" id="staff_office" onchange="refresh_existing_client_list(this.value,'');" title="Office" required="">
            <option value="">Select Office</option>
            <?php load_ddl_option("staff_office_list",(isset($office_id)? $office_id:''), (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
        </select>
       </div>
        <div class="errorMessage text-danger"></div>
    </div>

    <div class="form-group client_type_div0" id="client_list">
        <label class="col-lg-2 control-label">Client List<span class="text-danger">*</span></label>
        <div class="col-lg-10">
        <select class="form-control client_type_field0" name="client_list_id" id="client_list_ddl" title="Client List" <?php echo (isset($client_id) && $client_id !='') ? 'disabled' : ''; ?> onchange = "get_business_client_id(this.value);" required>
            <option value="">Select an option</option>
        </select>
        </div>
        <div class="errorMessage text-danger"></div>
    </div>

<script>
    <?php if(isset($action_id) && $action_id!=''){ ?>
        refresh_existing_client_list('<?= $office_id ?>','<?= $client_id ?>');
   <?php }?>
   $("#client_list_ddl").chosen();

   function get_business_client_id(client_id = "") {
        $.ajax({
            type: "POST",
            data: {
                client_id: client_id
            },
            url: base_url + 'action/home/get_company_practice_id',
            dataType: "html",
            success: function (result) {
                // alert(result);return false;
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