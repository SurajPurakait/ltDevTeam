
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" id="edit_sales_process">
                <div class="ibox">
                    <div class="ibox-content">
                        <!--<h3>Individual Information</h3>-->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="client_name" id="client_name" title="Client Name" required="">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($completed_orders as $data) {
                                        ?>
                                        <option value="<?= $data['reference_id']; ?>" <?php echo $data['reference_id'] == $sales_tax_process_dtls['client_id'] ? 'selected' : '' ?> ><?= $data['name']; ?></option>
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
                                        <option value="<?= $sted['id']; ?>" <?= $sales_tax_process_dtls['state_id'] == $sted['id'] ? 'selected' : '' ?>><?= $sted['state_name']; ?></option>
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
                                <input placeholder="" class="form-control" type="text" id="exempt_sales" name="exempt_sales" title="Exempt Sales" required onkeyup="sales_gross_collect()" value="<?= $sales_tax_process_dtls['exempt_sales'] ?>"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Taxable Sales<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="taxable_sales" name="taxable_sales" title="Taxable Sales" required onkeyup="sales_gross_collect()" value="<?= $sales_tax_process_dtls['taxable_sales'] ?>"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    </div>                    
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Gross Sales<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="gross_sales" name="gross_sales" title="Gross Sales" required value="<?= $sales_tax_process_dtls['gross_sales'] ?>"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sales Tax Collected<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="sales_tax_collect" name="sales_tax_collect" title="Sales Tax Collected" required value="<?= $sales_tax_process_dtls['sales_tax_collect'] ?>"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Collection Allowance<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="collection_allowance" name="collection_allowance" title="Collection Allowance" required value="<?= $sales_tax_process_dtls['collect_allowance'] ?>"><div class="errorMessage text-danger" id="coll_err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Total Due<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="total_due" name="total_due" title="Total Due" required value="<?= $sales_tax_process_dtls['total_due'] ?>"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Period of Time<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <?php
                                if ($sales_tax_process_dtls['period_of_time'] == 'm') {
                                    $year = date('Y');
                                    ?>
                                    <select class="form-control" name="period_time" id="period_time" title="Period of Time" required="">
                                        <option value="">Select</option>
                                        <?php
                                        for ($m = 1; $m <= 12; $m++) {
                                            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                            ?>
                                            <option <?php echo ($month == $sales_tax_process_dtls['period_of_time_val']) ? 'selected' : ''; ?> value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                        <?php } ?>
                                    </select>   
                                    <?php
                                } elseif ($sales_tax_process_dtls['period_of_time'] == 'q') {
                                    $year = date('Y');
                                    ?>
                                    <select class="form-control" name="period_time" id="period_time" title="Period of Time" required="">
                                        <option value="">Select</option>
                                        <?php for ($i = 1; $i < 5; $i++) {
                                            ?>
                                            <option <?php echo ('Quarter' . $i == $sales_tax_process_dtls['period_of_time_val']) ? 'selected' : ''; ?> value="<?php echo 'Quarter' . $i; ?>"><?php echo 'Quarter' . $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php
                                } else {
                                    $year = date('Y');
                                    ?>
                                    <select class="form-control" name="period_time" id="period_time" title="Period of Time" required="">
                                        <option value="">Select</option>
                                        <option <?php echo (($year - 3) == $sales_tax_process_dtls['period_of_time_val']) ? 'selected' : ''; ?> value="<?php echo ($year - 3); ?>"><?php echo ($year - 3); ?></option>
                                        <option <?php echo (($year - 2) == $sales_tax_process_dtls['period_of_time_val']) ? 'selected' : ''; ?> value="<?php echo ($year - 2); ?>"><?php echo ($year - 2); ?></option>
                                        <option <?php echo (($year - 1) == $sales_tax_process_dtls['period_of_time_val']) ? 'selected' : ''; ?> value="<?php echo ($year - 1); ?>"><?php echo ($year - 1); ?></option>
                                        <option <?php echo (($year) == $sales_tax_process_dtls['period_of_time_val']) ? 'selected' : ''; ?> value="<?php echo ($year); ?>"><?php echo ($year); ?></option>
                                        <option <?php echo (($year + 1) == $sales_tax_process_dtls['period_of_time_val']) ? 'selected' : ''; ?> value="<?php echo ($year + 1); ?>"><?php echo ($year + 1); ?></option>
                                    </select>
                                <?php } ?>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group period_year_div" <?php echo ($sales_tax_process_dtls['period_of_time'] == 'q' || $sales_tax_process_dtls['period_of_time'] == 'm') ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                            <label class="col-lg-2 control-label">Year<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <?php $year = date('Y'); ?>
                                <select class="form-control" name="period_time_year" id="period_time_year" title="Year" required="">
                                    <option value="">Select</option>
                                        <option <?php echo (($year - 3) == $sales_tax_process_dtls['period_of_time_yearval']) ? 'selected' : ''; ?> value="<?php echo ($year - 3); ?>"><?php echo ($year - 3); ?></option>
                                        <option <?php echo (($year - 2) == $sales_tax_process_dtls['period_of_time_yearval']) ? 'selected' : ''; ?> value="<?php echo ($year - 2); ?>"><?php echo ($year - 2); ?></option>
                                        <option <?php echo (($year - 1) == $sales_tax_process_dtls['period_of_time_yearval']) ? 'selected' : ''; ?> value="<?php echo ($year - 1); ?>"><?php echo ($year - 1); ?></option>
                                        <option <?php echo (($year) == $sales_tax_process_dtls['period_of_time_yearval']) ? 'selected' : ''; ?> value="<?php echo ($year); ?>"><?php echo ($year); ?></option>
                                        <option <?php echo (($year + 1) == $sales_tax_process_dtls['period_of_time_yearval']) ? 'selected' : ''; ?> value="<?php echo ($year + 1); ?>"><?php echo ($year + 1); ?></option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <input type="hidden" name="peroidval" value="<?php echo $sales_tax_process_dtls['period_of_time']; ?>" id="peroidval">
                        <?php //print_r($sales_tax_process_files);  ?>    

                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Upload File</label>
                            <div class="col-lg-10">
                                <div class="upload-file-div">
                                    <input class="m-t-5 file-upload" type="file" name="upload_file[]" title="Upload File">
                                </div>
                                <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i>Add File</a>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-lg-2">Uploaded Files</label>
                            <div class="col-lg-10">
                                <?php if (!empty($sales_tax_process_files)): ?>
                                    <ul class="uploaded-file-list">
                                        <?php
                                        foreach ($sales_tax_process_files as $file) :
                                            $value = $file['file_name'];
                                            $file_id = $file['id'];
                                            $extension = pathinfo($value, PATHINFO_EXTENSION);
                                            $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                            if (in_array($extension, $allowed_extension)):
                                                ?>
                                                <li id="file_show_<?= $file_id; ?>">
                                                    <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $value; ?>');max-width: 100%;">
                                                        <a href="<?php echo base_url(); ?>uploads/<?= $value; ?>" title="<?= $value; ?>"><i class="fa fa-search-plus"></i></a>
                                                    </div>
                                                    <p class="text-overflow-e" title="<?= $value; ?>"><?= $value; ?></p>
                                                    <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteSalesTaxProcessFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                                </li>
                                            <?php else: ?>
                                                <li id="file_show_<?= $file_id; ?>">
                                                    <div class="preview preview-file">
                                                        <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $value; ?>" title="<?= $value; ?>"><i class="fa fa-download"></i></a>

                                                    </div>
                                                    <p class="text-overflow-e" title="<?= $value; ?>"><?= $value; ?></p>
                                                    <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteSalesTaxProcessFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                                </li>
                                            <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?= service_note_func('Sales Tax Process Note', 'n', 'sales_tax_process', $sales_tax_process_dtls["id"]); ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirmation Number</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" id="confirmation_number" name="confirmation_number" title="Confirmation Number" value="<?= $sales_tax_process_dtls['confirmation_number']; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirm<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="checkbox" name="confirmation" title="Confirmation" id="confirmation" value="" required>
                                I agree to waive the collections allowance.
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>                        
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="user_id" id="user_id" value="<?= $staffInfo['id']; ?>">
                                <input type="hidden" name="user_type" id="user_type" value="<?= $staffInfo['type']; ?>">
                                <input type="hidden" id="edit_process" value="<?= $sales_tax_process_dtls["id"] ?>">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <button class="btn btn-success" type="button" onclick="updateSalesProcess()">Save</button> &nbsp;
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
    get_county(<?= $sales_tax_process_dtls['county_id'] ?>,<?= $sales_tax_process_dtls['state_id'] ?>);
    
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
    function deleteSalesTaxProcessFile(file_id) {
        swal({
            title: "Delete!",
            text: "Are you sure to delete this file?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type: "POST",
                url: '<?= base_url(); ?>action/home/delete_sales_tax_process_file',
                data: {
                    file_id: file_id
                },
                cache: false,
                success: function (data) {
                    if (data == 1) {
                        swal("Deleted!", "File has been deleted.", "success");
                        $("#file_show_" + file_id).remove();
                    }
                }
            });
        });
    }
</script>
