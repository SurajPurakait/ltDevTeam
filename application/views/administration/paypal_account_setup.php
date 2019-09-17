<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_insert_paypal">
                        <h3>Add New Marketing Material</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Live/Sandbox<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select  class="form-control" title="Live/Sandbox" name="sandbox_or_live" id="sandbox_or_live" required>
                                    <option value="1" <?php echo ($paypal_details['sandbox_or_live']==1) ? 'selected' : ''; ?>>Live</option>
                                    <option value="2" <?php echo ($paypal_details['sandbox_or_live']==2) ? 'selected' : ''; ?>>Sandbox</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Paypal Username<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" required title="Paypal Username" id="paypal_username" name="paypal_username" value="<?php echo $paypal_details['paypal_username']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Paypal Password<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" required title="Paypal Password" id="paypal_password" name="paypal_password" value="<?php echo $paypal_details['paypal_password']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Paypal Signature<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" required title="Paypal Signature" id="paypal_signature" name="paypal_signature" value="<?php echo $paypal_details['paypal_signature']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success save_btn" type="button" onclick="insert_paypal_details();">
                                    Save Changes
                                </button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="goURL('<?php echo base_url()."home/dashboard" ?>');">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function insert_paypal_details(){
        if (!requiredValidation('form_insert_paypal')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('form_insert_paypal'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'administration/paypal_account_setup/insert_paypal_details',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Paypal Details Successfully Updated!", type: "success"}, function () {
                    goURL(base_url + 'administration/paypal_account_setup');
                });
            } else {
                swal("ERROR!", "Some error occured", "error");
            }
        }
     });
    }
</script>