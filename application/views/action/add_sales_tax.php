<?php // print_r($staffInfo);        ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" id="save_sales_process">
                <div class="ibox">
                    <div class="ibox-content">
                        <!--<h3>Individual Information</h3>-->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="client_name" id="client_name" title="Client Name" required="">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($completed_salestax_orders as $data) {
                                        ?>
                                        <option value="<?= $data['reference_id']; ?>"><?= $data['name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="state" id="state" title="County" required="" onchange="get_county()">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($state as $sted) {
                                        ?>
                                        <option value="<?= $sted['id']; ?>"><?= $sted['state_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div id="sted_county"></div>
                        <div id="county_rate"></div>
                    </div>
                    <div class="well m-b-0">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Exempt Sales<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="exempt_sales" name="exempt_sales" title="Exempt Sales" required onkeyup="sales_gross_collect()"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Taxable Sales<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="taxable_sales" name="taxable_sales" title="Taxable Sales" required onkeyup="sales_gross_collect()" ><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Gross Sales<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="gross_sales" name="gross_sales" title="Gross Sales" required ><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sales Tax Collected<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="sales_tax_collect" name="sales_tax_collect" title="Sales Tax Collected" required ><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Collection Allowance<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="collection_allowance" name="collection_allowance" title="Collection Allowance" required ><div class="errorMessage text-danger" id="coll_err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Total Due<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="total_due" name="total_due" title="Total Due" required ><div class="errorMessage text-danger"></div>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Period of Time<span class="text-danger">*</span></label>
                            <div class="col-lg-10 period_div">
                                <select class="form-control" name="period_time" id="period_time" title="Period of Time" required="">
                                    <option value="">Select</option>
                                    <!-- <option value="m">Monthly</option>
                                    <option value="q">Quarterly</option>
                                    <option value="y">Yearly</option> -->
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group period_year_div" style="display: none;">
                            <label class="col-lg-2 control-label">Year<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <?php $year = date('Y'); ?>
                                <select class="form-control" name="period_time_year" id="period_time_year" title="Year" required="">
                                    <option value="">Select</option>
                                    <option value="<?php echo ($year - 3); ?>"><?php echo ($year - 3); ?></option>
                                    <option value="<?php echo ($year - 2); ?>"><?php echo ($year - 2); ?></option>
                                    <option value="<?php echo ($year - 1); ?>"><?php echo ($year - 1); ?></option>
                                    <option selected value="<?php echo ($year); ?>"><?php echo ($year); ?></option>
                                    <option value="<?php echo ($year + 1); ?>"><?php echo ($year + 1); ?></option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <input type="hidden" name="peroidval" value="" id="peroidval">

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload File</label>
                            <div class="col-lg-10">
                                <div class="upload-file-div m-b-5">
                                    <input class="m-t-5 file-upload" id="action_file" type="file" name="upload_file[]" title="Upload File">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i> Add File</a>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?= service_note_func('Sales Tax Process Notes', 'n', 'sales_tax_process'); ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirmation Number</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" id="confirmation_number" name="confirmation_number" title="Confirmation Number">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirm<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <div class="p-t-5">
                                    <input type="checkbox" name="confirmation" title="Confirmation" id="confirmation" value="" required>
                                    I agree to waive the collections allowance.
                                </div>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="user_id" id="user_id" value="<?= $staffInfo['id']; ?>">
                                <input type="hidden" name="user_type" id="user_type" value="<?= $staffInfo['type']; ?>">

                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <button class="btn btn-success" type="button" onclick="saveSalesProcess()">Save</button> &nbsp;
                                <button class="btn btn-default" type="button" onclick="go('action/home/sales_tax_process')">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    get_county();

    function get_period_of_time(timeval) {
        $("#peroidval").val(timeval);
        if (timeval == 'm') {
            var d = new Date();
            var n = d.getFullYear();
            $(".period_div").html('');
            var theMonths = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            var monthselect = '<select class="form-control" name="period_time" id="period_time" title="Period of Time" required=""><option value="">Select</option>';
            for (i = 0; i < theMonths.length; i++) {
                var monthselect = monthselect + '<option value="' + theMonths[i] + '">' + theMonths[i] + '</option>';
            }
            var monthselect = monthselect + '</select>';
            var monthselect = monthselect + '<div class="errorMessage text-danger"></div>';
            $(".period_div").html(monthselect);
            $(".period_year_div").show();
        } else if (timeval == 'q') {
            var d = new Date();
            var n = d.getFullYear();
            $(".period_div").html('');
            var quarterselect = '<select class="form-control" name="period_time" id="period_time" title="Period of Time" required=""><option value="">Select</option>';
            for (i = 1; i < 5; i++) {
                var quarterselect = quarterselect + '<option value="Quarter' + i + '">Quarter' + i + '</option>';
            }
            var quarterselect = quarterselect + '</select>';
            var quarterselect = quarterselect + '<div class="errorMessage text-danger"></div>';
            $(".period_div").html(quarterselect);
            $(".period_year_div").show();
        } else if (timeval == 'y') {
            $(".period_div").html('');
            var d = new Date();
            var n = d.getFullYear();
            var yearselect = '<select class="form-control" name="period_time" id="period_time" title="Period of Time" required=""><option value="">Select</option>';
            var yearselect = yearselect + '<option value="' + (n - 3) + '">' + (n - 3) + '</option>';
            var yearselect = yearselect + '<option value="' + (n - 2) + '">' + (n - 2) + '</option>';
            var yearselect = yearselect + '<option value="' + (n - 1) + '">' + (n - 1) + '</option>';
            var yearselect = yearselect + '<option selected value="' + (n) + '">' + (n) + '</option>';
            var yearselect = yearselect + '<option value="' + (n + 1) + '">' + (n + 1) + '</option>';
            var yearselect = yearselect + '</select>';
            var yearselect = yearselect + '<div class="errorMessage text-danger"></div>';
            $(".period_div").html(yearselect);
        }
    }
    $(document).ready(function () {
        $("#client_name").change(function () {
            var clval = $("#client_name option:selected").val();
            if (clval != '') {
                $.ajax({
                    type: "POST",
                    url: base_url + 'action/home/get_sales_tax_recurring',
                    data: {clval: clval},
                    success: function (data) {
                        if (data.trim != '') {
                            var resval = JSON.parse(data);
                            //console.log(resval);
                            $("#state").val(resval.state);
                            get_county(resval.county, resval.state);
                            //$("#period_time").val(resval.freq_of_salestax);
                            get_period_of_time(resval.freq_of_salestax);
                        }
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
            } else {
                reset_all_fields();
            }
        });
        $('.add-upload-file').on("click", function () {
            var text_file = $(this).prev('.upload-file-div').html();
            var file_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-2 control-label">' + file_label + '</label><div class="col-lg-10">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });

    function removeFile(divID) {
        $("#" + divID).remove();
    }
</script>