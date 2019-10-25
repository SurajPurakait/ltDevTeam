<style type="text/css">
    .service-requests {
        width: 100%;
    }

    .service-requests tr th,
    .service-requests tr td {
        padding: 8px;
    }

    .service-mother {
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .service-mother.has-child {
        cursor: pointer;
    }

    .service-child {
        background: #fff;
        border-bottom: 1px solid #ddd;
    }

    .label-block {
        display: block;
        padding: 5px 8px;
    }
</style>
<?php
$staff_info = staff_info();
$staff_department = explode(',', $staff_info['department']);
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
                                <form name="filter_form" id="filter-form"  method="post" onsubmit="invoiceFilter()">
                                    <div class="form-group filter-inner">
                                        <div class="row">
                                            <div class="m-b-8 pull-left col-md-8">
                                                <a href="<?= base_url() ?>billing/invoice" title="Create Invoice" class="btn btn-primary dropdown-toggle"><i class="fa fa-plus"></i> Create Invoice</a>
                                            </div>                                            
                                        </div>
                                        <div class="filter-div m-b-20 row" id="original-filter">                                           
                                            <div class="col-sm-3 m-t-10">
                                                <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="changeVariable(this)">
                                                    <option value="">All Variable</option>
                                                    <?php foreach ($filter_element_list as $key => $fel): ?>
                                                        <option value="<?= $key ?>"><?= $fel ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 m-t-10">
                                                <select class="form-control condition-dropdown" name="condition_dropdown[]" onchange="changeCondition(this)">
                                                    <option value="">All Condition</option>
                                                    <option value="1">Is</option>
                                                    <option value="2">Is in the list</option>
                                                    <option value="3">Is not</option>
                                                    <option value="4">Is not in the list</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 m-t-10 criteria-div">
                                                <select class="form-control criteria-dropdown chosen-select" placeholder="All Criteria" name="criteria_dropdown[][]">
                                                    <option value="">All Criteria</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 m-t-10 p-l-0">
                                                <div class="add_filter_div text-right">
                                                    <a href="javascript:void(0);" onclick="addFilterRow()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Filter">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> 
                                                    </a>
                                                </div>  
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">                        
                                            <div class="">
                                                <button class="btn btn-success" type="button" onclick="invoiceFilter()">Apply Filter</button>
                                                <a href="javascript:void(0);" onclick="loadBillingDashboard('', '', '');" class="btn btn-ghost" id="btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless" style="border-collapse: separate;">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <th class="text-center">Unpaid</th>
                                            <th class="text-center">Partial</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Late</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>By Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-1" onclick="reflactFilterWithSummery('1-Unpaid', 'byme-By ME');loadBillingDashboard('', 'byme', '', 1, '');">
                                                    <span class="label label-warning filter-byme-1">-</span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2" onclick="reflactFilterWithSummery('2-Partial', 'byme-By ME');loadBillingDashboard('', 'byme', '', 2, '');">
                                                    <span class="label label-success filter-byme-2">-</span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-3" onclick="reflactFilterWithSummery('3-Paid', 'byme-By ME');loadBillingDashboard('', 'byme', '', 3, '');">
                                                    <span class="label label-primary filter-byme-3">-</span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-4" onclick="reflactFilterWithSummery('4-Late', 'byme-By ME');loadBillingDashboard('', 'byme', '', 4, '');">
                                                    <span class="label label-danger filter-byme-4">-</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php if ($stafftype == 1 || $stafftype == 2 || ($stafftype == 3 && $staffrole == 2)) { ?>
                                            <tr>
                                                <th>By Others</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-1" onclick="reflactFilterWithSummery('1-Unpaid', 'tome-By Others');loadBillingDashboard('', 'tome', '', 1, '');">
                                                        <span class="label label-warning filter-byothers-1">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-2" onclick="reflactFilterWithSummery('2-Partial', 'tome-By Others');loadBillingDashboard('', 'tome', '', 2, '');">
                                                        <span class="label label-success filter-byothers-2">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-3" onclick="reflactFilterWithSummery('3-Paid', 'tome-By Others');loadBillingDashboard('', 'tome', '', 3, '');">
                                                        <span class="label label-primary filter-byothers-3">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-4" onclick="reflactFilterWithSummery('4-Late', 'tome-By Others');loadBillingDashboard('', 'tome', '', 4, '');">
                                                        <span class="label label-danger filter-byothers-4">-</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <tbody>
                                </table>
                            </div>
                            <div class="row m-t-10">                                
                                <div class="m-b-4 pull-right col-md-6">
                                    <select class="form-control" onchange="loadBillingDashboard('', '', this.value);">
                                        <option value="">All office</option>
                                        <option value="<?= implode(',', array_column($contador_office_list, 'id')); ?>">Contador</option>
                                        <option value="<?= implode(',', array_column($taxleaf_office_list, 'id')); ?>">TaxLeaf</option>
                                    </select>
                                </div>
                                <div class="m-b-4 m-t-5 pull-right col-md-6">
                                    <a href="javascript:void(0)" class="pull-right" onclick="openNotificationModal('invoice', 'tracking');">
                                        <strong>Notification&nbsp;</strong>
                                        <span class="label label-primary notification-count-label"><?= get_invoice_notifications_count(); ?></span>
                                    </a>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <hr class="hr-line-dashed m-t-0">
                    <div class="clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2 class="text-primary dashboard-item-result result-header"></h2>
                            </div>
                            <div class="col-lg-6">
                                <div class="pull-right text-right">
                                    <div class="dropdown" style="display: inline-block;">
                                        <a href="javascript:void(0);" id="sort-by-dropdown" data-toggle="dropdown" class="dropdown-toggle btn btn-success">Sort By <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($sorting_element as $sorting_index => $sorting_value) : ?>
                                                <li><a id="<?= str_replace(' ', '_', strtolower($sorting_value)) . '-sorting'; ?>" href="javascript:void(0);" onclick="sortInvoiceDashboard('<?= str_replace(' ', '_', strtolower($sorting_value)); ?>', 'ASC')"><?= $sorting_value; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="sort_type_div" style="display: none;">
                                        <a href="javascript:void(0);" id="sort-asc" onclick="sortInvoiceDashboard('', 'DESC')" class="btn btn-success" data-toggle="tooltip" title="Ascending Order" data-placement="top"><i class="fa fa-sort-amount-asc"></i></a>
                                        <a href="javascript:void(0);" id="sort-desc" onclick="sortInvoiceDashboard('', 'ASC')" class="btn btn-success" data-toggle="tooltip" title="Descending Order" data-placement="top"><i class="fa fa-sort-amount-desc"></i></a>
                                        <a href="javascript:void(0);" onclick="loadBillingDashboard('', '', '');" class="btn btn-white text-danger" data-toggle="tooltip" title="Remove Sorting" data-placement="top"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ajaxdiv" id="dashboard_result_div"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="last_filter" value="load">
<input type="hidden" id="last_sort" value="load">
<input type="hidden" id="dept" value="<?= $staff_info['department']; ?>">
<div class="modal fade" id="showNotes1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <div class="modal-body form-horizontal" id="note-body-div"></div>
            <div class="modal-footer">                    
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Notifications</h4>
            </div>
            <div id="notification-modal-body" class="modal-body"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="change_status_billing_div" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal
         content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad1" value="1"/>
                                <label for="rad1"><strong>Not Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2" value="2"/>
                                <label for="rad2"><strong>Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad3" value="3"/>
                                <label for="rad3"><strong>Completed</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad7" value="7"/>
                                <label for="rad7"><strong>Canceled</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="invoice_id" value="">
            </div>
            <div class="modal-footer text-center">
                <input type="hidden" id="current_status" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?php if (in_array(3, explode(',', $staff_info['department'])) || in_array(14, explode(',', $staff_info['department'])) || $stafftype == 1) : ?>
                    <button type="button" class="btn btn-primary" onclick="updateStatusBilling()">Save changes</button>
                <?php endif; ?>
            </div>
            <div class="modal-body" style="display: none;" id="log_modal">
                <div style="height:200px; overflow-y: scroll">
                    <table id="status_log" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>time</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Service Note Modal -->
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Invoice Service Notes</h4>
            </div>            
            <form method="post" id="modal_note_form" onsubmit="saveInvoiceNotes();">
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="hidden" name="service_id" id="service_id" />
                    <input type="hidden" name="service_order_id" id="service_order_id" />
                    <button type="button" id="save_note" onclick="saveInvoiceNotes();" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div> 
<script>
    loadBillingDashboard('<?= isset($status) ? $status : ''; ?>', '', '<?= $office_id; ?>', '', 'on_load', 1);
    var content = $(".filter-div").html();
    var variableArray = [];
    var elementArray = [];
    function addFilterRow() {
        var random = Math.floor((Math.random() * 999) + 1);
        var clone = '<div class="filter-div row m-b-20" id="clone-' + random + '">' + content + '<div class="col-sm-1 text-right p-l-0"><a href="javascript:void(0);" onclick="removeFilterRow(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>';
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
        var officeValue = '';
        if (checkElement == true) {
            variableArray.pop();
            variableArray.push(variableValue);
        } else {
            elementArray.push(element);
            variableArray.push(variableValue);
        }
        if (variableValue == 4) {
            var checkOfficeValue = variableArray.includes('3');
            if (checkOfficeValue == true) {
                officeValue = $("select[name='criteria_dropdown[office][]']").val();
            }
        }
        $.ajax({
            type: "POST",
            data: {
                variable: variableValue,
                office: officeValue
            },
            url: '<?= base_url(); ?>' + 'billing/home/filter_dropdown_option_ajax',
            dataType: "html",
            success: function (result) {
                $("#" + divID).find('.criteria-div').html(result);
                $(".chosen-select").chosen();
                $("#" + divID).find('.condition-dropdown').removeAttr('disabled').val('');
                if (variableValue == 11) {
                    $("#" + divID).find('.condition-dropdown option:not(:eq(0),:eq(1))').remove();
                } else {
                    $("#" + divID).find('.condition-dropdown').html('<option value="">All Condition</option><option value="1">Is</option><option value="2">Is in the list</option><option value="3">Is not</option><option value="4">Is not in the list</option>');
                }
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
        if (variableValue == 7) {
            if (conditionValue == 2 || conditionValue == 4) {
                $.ajax({
                    type: "POST",
                    data: {
                        condition: conditionValue,
                        variable: variableValue
                    },
                    url: '<?= base_url(); ?>' + 'billing/home/filter_dropdown_option_ajax',
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
                        variable: variableValue
                    },
                    url: '<?= base_url(); ?>' + 'billing/home/filter_dropdown_option_ajax',
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
    var reflactFilterWithSummery = function (status, requestType) {
        clearFilter();
        $("select.variable-dropdown:first").val(6);
        var statusArray = status.split('-');
        $('select.criteria-dropdown:first').empty().html('<option value="' + statusArray[0] + '">' + statusArray[1] + '</option>').attr({'readonly': true, 'name': 'criteria_dropdown[status][]'});
        $("select.criteria-dropdown:first").trigger("chosen:updated");
        $("select.condition-dropdown:first").val(1).attr('disabled', true);
        elementArray.push($("select.condition-dropdown:first"));
        variableArray.push(6);
        addFilterRow();
        $("select.variable-dropdown:eq(1)").val(11);
        var requestTypeArray = requestType.split('-');
        $('select.criteria-dropdown:eq(1)').empty().html('<option value="' + requestTypeArray[0] + '">' + requestTypeArray[1] + '</option>').attr({'readonly': true, 'name': 'criteria_dropdown[request_type][]'});
        $("select.criteria-dropdown:eq(1)").trigger("chosen:updated");
        $("select.condition-dropdown:eq(1)").val(1).attr('disabled', true);
        elementArray.push($("select.condition-dropdown:eq(1)"));
        variableArray.push(6);
    }
</script>