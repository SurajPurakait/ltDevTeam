<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="form-group clearfix">
                        <label class="col-lg-2 control-label">Client Type<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-control type_of_client" name="type_of_client" id="type_of_client" title="Type Of Client" onchange="select_type_of_client(this.value,<?= $lead_id; ?>,<?= $partner_id; ?>)" required>
                                <option value="0" selected>Individual</option>
                                <option value="1">Business</option>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <!-- Individual Client Section -->
                    <div id="individual-client-assign">    
                    
                    </div>
                    <!-- Business Client Section -->
                    <div id="business-client-assign">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    select_type_of_client('0','<?= $lead_id; ?>','<?= $partner_id; ?>');
    function select_type_of_client(type,lead_id,partner_id) {
        if (type == "0") {
            $.ajax({
                type: "POST",
                data: {
                    type:type,
                    lead_id: lead_id,
                    partner_id: partner_id
                },
                // url: base_url + 'action/home/add_individual',
                url: base_url + 'lead_management/home/add_individual_assign',
                dataType: "html",
                success: function (result) {
                    $("#business-client-assign").hide();
                    $("#individual-client-assign").show();
                    $("#individual-client-assign").html(result);
                },
            });
        }
        else if (type == "1") {
            $.ajax({
                type: "POST",
                data: {
                    type:type,
                    lead_id: lead_id,
                    partner_id: partner_id
                },
                url: base_url + 'lead_management/home/add_business_assign',
                // url: base_url + 'action/home/add_business',
                dataType: "html",
                success: function (result) {
                    $("#individual-client-assign").hide();    
                    $("#business-client-assign").show();    
                    $("#business-client-assign").html(result);
                },
            });
        }
        else {
            $("#individual-client-assign").hide();    
            $("#business-client-assign").hide();
        }
    }
</script>                    