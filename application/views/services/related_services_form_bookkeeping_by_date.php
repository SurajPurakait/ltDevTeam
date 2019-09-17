<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="related_create_bookkeeping_by_date" onsubmit="related_create_bookkeeping_by_date(); return false;">
                        <div class="accounts-details">
                            <h3>Financial Accounts<span class="text-danger">*</span>&nbsp; (<a href="javascript:void(0);" onclick="account_modal('add', '', 'month_diff');">Add Financial Account</a>)</h3>
                            <div id="accounts-list">
                                <input type="hidden" title="Financial Accounts" id="accounts-list-count" required="required" value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="0" id="retail-price">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="0">
                                <input type="hidden" id="retail-price-initialamt" value="0" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" numeric_valid="" id="retail_price_override" name="retail_price_override" title="Retail Price" value="<?php echo $override_price; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="new_reference_id" id="new_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_bookkeeping">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="">
                                <input type="hidden" name="order_id" id="order_id" value="<?= $order_id; ?>">
                                <input type="hidden" name="bookkeeping_sub_cat" id="bookkeeping_sub_cat" value="2">
                                <button class="btn btn-success" type="button" onclick="related_create_bookkeeping_by_date('related_create_bookkeeping_by_date')">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelRelatedServiceForm('related_create_bookkeeping_by_date')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="accounts-form" class="modal fade" aria-hidden="true" style="display: none;"></div>



<script>
    interval_total_amounts();
    var base_url = document.getElementById('base_url').value;
    get_financial_account_list('<?= $reference_id; ?>', 'month_diff', '<?= $order_id; ?>');

    function monthDiff(start_date, end_date, return_data) {
        var base_url = $('#baseurl').val();
        $.ajax({
            type: "POST",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            url: base_url + 'Services/AccountingServices/get_month_diff',
            //            dataType: "html",
            success: function (result) {
                return_data(result);
            }
        });
    }

    $(function () {
        $('#start_month,#complete_month').datepicker({dateFormat: 'mm/yy'});
        $('#start_month,#complete_month').attr("onblur", 'checkDate(this);');

        $("#start_month, #complete_month").blur(function () {
            var val = $("#no_of_transactions option:selected").val();
            var amt = 0;
            if (val != '') {
                if (val == '0-100') {
                    amt = 149;
                } else if (val == '101-200') {
                    amt = 175;
                } else if (val == '201-300') {
                    amt = 200;
                }
            } else {
                amt = 149;
            }
            var count_fc_ac = document.getElementsByClassName('total_amounts').length;
            if (count_fc_ac > 0) {
                if (val != '') {
                    if (val == '0-100') {
                        amt = 25;
                    } else if (val == '101-200') {
                        amt = 50;
                    } else if (val == '201-300') {
                        amt = 75;
                    }
                } else {
                    amt = 25;
                }
            }
            var start = $("#start_month").val();
            var end = $("#complete_month").val();
            if (start != "" && end != "") {
                monthDiff(start, end, function (result) {
                    if (result.trim() != "N") {
                        $("#grand_total_amount").val(result * amt);
                    } else {
                        $("#grand_total_amount").val(amt);
                    }
                });
            }
        });

        setInterval(function () {
            var total_amounts = document.getElementsByClassName('total_amounts');
            //var payroll_people_total = $(".payroll_people_total").val();
            var office_visit = $(".office_visit").val();
            var corporate_tax_return = $(".corporate_tax_return").val();
            var price_initialam = $("#retail-price-initialamt").val();
            var total = 0;
            total += parseInt(price_initialam);
            for (i = 0; i < total_amounts.length; i++) {
                total += parseInt(total_amounts[i].value);
            }
            // if(payroll_people_total == '1-10'){
            //     total += 50;
            // }else if(payroll_people_total == '11-20'){
            //     total += 100;
            // }else if(payroll_people_total == '21-30'){
            //     total += 150;
            // }

//            if (total_amounts.length > 0) {
//                $(".accounts-details").addClass('background-image');
//            } else {
//                $(".accounts-details").removeClass('background-image');
//            }

            if (office_visit == 'y') {
                total += 50;
            }
            if (corporate_tax_return == 'y') {
                total += 35;
            }
            $("#retail-price").val(total + ".00");
            $("#retail-price-hidd").val(total);
        }, 100);


        $("#no_of_transactions").change(function () {
            var val = $("#no_of_transactions option:selected").val();
            var amtval = $("#retail-price-hidd").val();
            if (val != '') {
                if (val == '0-100') {
                    var amt = '149';
                } else if (val == '101-200') {
                    var amt = '175';
                } else if (val == '201-300') {
                    var amt = '200';
                }
            } else {
                var amt = '149';
            }
            var count_fc_ac = document.getElementsByClassName('total_amounts').length;
            if (count_fc_ac > 0) {
                if (val != '') {
                    if (val == '0-100') {
                        var amt = '25';
                    } else if (val == '101-200') {
                        var amt = '50';
                    } else if (val == '201-300') {
                        var amt = '75';
                    }
                } else {
                    var amt = '25';
                }
            }
            $("#total_amount").val(amt);
            $("#retail-price-hidd").val(amt);
            $("#retail-price").val(amt);
        });
    }); //end document.ready

</script>