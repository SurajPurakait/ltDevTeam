<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="form-group clearfix" style="display: none">
                        <label class="col-lg-2 control-label">Client Type</label>
                        <div class="col-lg-10">
                            <input placeholder="" class="form-control" type="text" id="clienttype" name="clienttype" title="Client Type" value="Individual" disabled>
                        </div>
                    </div>
                    <!-- Individual Client -->
                    <div id="individual-client-assign">    
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    load_lead_client('0','<?= $lead_id; ?>','<?= $partner_id; ?>');
    function load_lead_client(type,lead_id,partner_id) {
        $.ajax({
            type: "POST",
            data: {
                type:type,
                lead_id: lead_id,
                partner_id: partner_id
            },
            url: base_url + 'lead_management/home/add_individual_assign',
            dataType: "html",
            success: function (result) {
                $("#individual-client-assign").html(result);
            },
        });
    }
</script>                    