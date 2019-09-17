<?php
$staff_info = staff_info();
$stafftype = $staff_info['type'];
$staffrole = $staff_info['role'];
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form"  method="post" onsubmit="actionFilter()">
                                    <div class="form-group filter-inner m-b-0">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-primary" type="button" title="Create Sales Tax Processing" data-toggle="dropdown" onclick="window.location.href = '<?= base_url("/action/home/add_sales_tax") ?>';"><i class="fa fa-plus"></i> Create</button>
                                            </div>                        
                                            <div class="col-sm-4 m-b-10">
                                                <input placeholder="mm/yyyy" id="month_year" readonly="readonly" class="form-control" type="text" title="Month & Year" value="<?= date('m/Y'); ?>">
                                            </div>
                                            <div class="col-sm-2 m-b-10 text-right">
                                                <button onclick="loadSalesTaxDashboard(getIdVal('month_year'), '', '', '', 'insert');" class="btn btn-primary" type="button" title="Search"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <hr class="hr-line-dashed m-t-5 m-b-5">
                                        <div class="filter-div row m-b-10" id="original-filter">
                                            <div class="col-md-3 m-t-5">
                                                <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="changeVariable(this)">
                                                    <option value="">All Variable</option>
                                                    <?php foreach ($filter_element_list as $key => $fel): ?>
                                                        <option value="<?= $key ?>"><?= $fel ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 m-t-5">
                                                <select class="form-control condition-dropdown" name="condition_dropdown[]" onchange="changeCondition(this)">
                                                    <option value="">All Condition</option>
                                                    <option value="1">Is</option>
                                                    <option value="2">Is in the list</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 m-t-5 criteria-div">
                                                <select class="form-control criteria-dropdown chosen-select" placeholder="All Criteria" name="criteria_dropdown[][]">
                                                    <option value="">All Criteria</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1 m-t-5 p-l-0 text-right">
                                                <div class="add_filter_div">
                                                    <a href="javascript:void(0);" onclick="addFilterRow()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Filter">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> 
                                                    </a>
                                                </div>  
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="row">                        
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-success" type="button" onclick="loadSalesTaxDashboard(getIdVal('month_year'), '', '', 'y', '');">Apply Filter</button>
                                        </div>
                                        <h3 style="display: none;" id="clear_filter" class="pull-right m-t-0 m-r-5"><span class="text-success">By Me - Started</span> &nbsp; <a href="javascript:void(0);" onclick="loadSalesTaxDashboard(getIdVal('month_year'), '', '', '', '');" class="btn btn-ghost" id="btn_clear_filter"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a></h3>&nbsp;
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th><span id="search_month" class="label bg-success"><b><?= date('F'); ?></b></span></th>
                                            <th class="text-center">New</th>
                                            <th class="text-center">Started</th>
                                            <th class="text-center">Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="my_request_type_title">My Sales Tax</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="my-sales-tax-0">
                                                    <span class="label label-warning" id="my_sales_tax_new" onclick="loadSalesTaxDashboard(getIdVal('month_year'), 'my', 0, '', '');">0</span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="my-sales-tax-1">
                                                    <span class="label label-warning" id="my_sales_tax_started" onclick="loadSalesTaxDashboard(getIdVal('month_year'), 'my', 1, '', '');">0</span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="my-sales-tax-2">
                                                    <span class="label label-warning" id="my_sales_tax_completed" onclick="loadSalesTaxDashboard(getIdVal('month_year'), 'my', 2, '', '');">0</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php if ($stafftype == 1 || ($stafftype == 3 && $staffrole == 2) || ($stafftype == 2 && $staffrole == 4)) { ?>
                                            <tr>
                                                <th class="others_request_type_title"><?= ($staffrole == 4) ? 'Entire Department' : 'Total Sales Tax'; ?></th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="others-sales-tax-0">
                                                        <span class="label label-warning" id="others_sales_tax_new" onclick="loadSalesTaxDashboard(getIdVal('month_year'), 'others', 0, '', '');">0</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="others-sales-tax-1">
                                                        <span class="label label-warning" id="others_sales_tax_started" onclick="loadSalesTaxDashboard(getIdVal('month_year'), 'others', 1, '', '');">0</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="others-sales-tax-2">
                                                        <span class="label label-warning" id="others_sales_tax_completed" onclick="loadSalesTaxDashboard(getIdVal('month_year'), 'others', 2, '', '');">0</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-line-dashed m-t-5 m-b-5">
                    <div id="sales_tax_process_dashboard_div"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>
<!-- Modal -->
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" action="<?php echo base_url(); ?>action/home/updateSalesTaxProcessNotes">
                <div id="notes-modal-body" class="modal-body no-padding"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#month_year").datepicker({format: 'mm/yyyy', maxDate: "+2M", autoHide: true});
    loadSalesTaxDashboard(getIdVal('month_year'), '', '', '', '');
    function show_salestax_process_notes(reference, reference_id) {
        $.ajax({
            type: 'POST',
            url: base_url + 'modal/show_salestax_process_notes',
            data: {
                reference: reference,
                reference_id: reference_id
            },
            success: function (result) {
                $('#showNotes #notes-modal-body').html(result);
                openModal('showNotes');
            }
        });
    }
    var content = $(".filter-div").html();
    var variableArray = [];
    var elementArray = [];
    function addFilterRow() {
        var random = Math.floor((Math.random() * 999) + 1);
        var clone = '<div class="filter-div row m-b-20" id="clone-' + random + '">' + content + '<div class="col-md-1"><a href="javascript:void(0);" onclick="removeFilterRow(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>';
        $('.filter-inner').append(clone);
        $.each(variableArray, function (key, value) {
            $("#clone-" + random + " .variable-dropdown option[value='" + value + "']").remove();
        });
        $("div.add_filter_div:not(:first)").remove();
    }

    function removeFilterRow(random) {
        var divID = 'clone-' + random;
        var variableDropdownValue = $("#clone-" + random + " .variable-dropdown option:selected").val();
        var index = variableArray.indexOf(variableDropdownValue);
        variableArray.splice(index, 1);
        $("#" + divID).remove();
    }
    function changeVariable(element) {
        var divID = $(element).parent().parent().attr('id');
        var variableValue = $(element).children("option:selected").val();
//        alert(variableValue);
        var checkElement = elementArray.includes(element);
        if (checkElement == true) {
            variableArray.pop();
            variableArray.push(variableValue);
        } else {
            elementArray.push(element);
            variableArray.push(variableValue);
        }
        $.ajax({
            type: "POST",
            data: {
                variable: variableValue,
                dashboard_type: 'sales_tax'
            },
            url: '<?= base_url(); ?>' + 'action/home/filter_dropdown_option_ajax',
            dataType: "html",
            success: function (result) {
                $("#" + divID).find('.criteria-div').html(result);
                $(".chosen-select").chosen();
                $("#" + divID).find('.condition-dropdown').val('');
                $("#" + divID).nextAll(".filter-div").each(function () {
                    $(this).find('.remove-filter-button').trigger('click');
                });
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }
    function changeCondition(element) {
        var divID = $(element).parent().parent().attr('id');
        //alert(divID);
        var conditionValue = $(element).children("option:selected").val();
        var variableValue = $(element).parent().parent().find(".variable-dropdown option:selected").val();
        if (variableValue == 5 || variableValue == 6) {
            if (conditionValue == 2 || conditionValue == 4) {
                $.ajax({
                    type: "POST",
                    data: {
                        condition: conditionValue,
                        variable: variableValue,
                        dashboard_type: 'sales_tax'
                    },
                    url: '<?= base_url(); ?>' + 'action/home/filter_dropdown_option_ajax',
                    dataType: "html",
                    success: function (result) {
                        $("#" + divID).find('.criteria-div').html(result);
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    data: {
                        variable: variableValue,
                        dashboard_type: 'sales_tax'
                    },
                    url: '<?= base_url(); ?>' + 'action/home/filter_dropdown_option_ajax',
                    dataType: "html",
                    success: function (result) {
                        $("#" + divID).find('.criteria-div').html(result);
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
            }
        } else {
            if (conditionValue == 2 || conditionValue == 4) {
                $("#" + divID).find(".criteria-dropdown").chosen("destroy");
                $("#" + divID).find(".criteria-dropdown").attr("multiple", "");
                $("#" + divID).find(".criteria-dropdown").chosen();
                $("#" + divID).find(".search-choice-close").trigger('click');
            } else {
                $("#" + divID).find(".criteria-dropdown").removeAttr('multiple');
                $("#" + divID).find(".criteria-dropdown").chosen("destroy");
                $("#" + divID).find(".criteria-dropdown").val('');
                $("#" + divID).find(".criteria-dropdown").chosen();
                $("#" + divID).find(".search-choice-close").trigger('click');
            }
        }
    }
</script>