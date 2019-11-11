<?php
if ($stat == '') {
    $stat = '4';
}
$stat = ($stat == 'all') ? "" : $stat;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-7">                            
                            <a href="<?= base_url("/lead_management/new_prospect/index") ?>" class="btn btn-primary m-r-10"><i class="fa fa-plus"></i> Add Lead</a>
                            <!-- <a href="<?//= base_url("/lead_management/new_prospect/index") ?>" class="btn btn-primary m-r-10"><i class="fa fa-plus"></i> Add Partner Lead</a> -->
                            <a href="<?= base_url().'partners'; ?>" class="btn btn-success">Partner Dashboard</a>
                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form"  method="post" onsubmit="leadFilter()">
                                    <div class="form-group filter-inner">
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
                                                <select class="form-control condition-dropdown" name="condition_dr  opdown[]" onchange="changeCondition(this)">
                                                    <option value="">All Condition</option>
                                                    <option value="1">Is</option>
                                                    <option value="2">Is in the list</option>
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
                                                <button class="btn btn-success" type="button" onclick="leadFilter()">Apply Filter</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="m-t-5 m-r-5"><span class="text-success" style="display: none;" id="clear_filter">By Me - Started &nbsp; </span><a href="javascript:void(0);" onclick="loadLeadDashboard('', '', '', '', '', '');" class="btn btn-ghost" id="btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a></h4>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <th class="text-center">New</th>
                                            <th class="text-center">Active</th>
                                            <th class="text-center">Inactive</th>
                                            <th class="text-center">Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>LEADS</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-leads-0">
                                                    <span class="label label-success" id="lead_new" onclick="loadLeadDashboard(1, 0)"><?= count(lead_list(1, '0')); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-leads-3">
                                                    <span class="label label-warning" id="lead_active" onclick="loadLeadDashboard(1, 3)"><?= count(lead_list(1, 3)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-leads-2">
                                                    <span class="label label-danger" id="lead_inactive" onclick="loadLeadDashboard(1, 2)"><?= count(lead_list(1, 2)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-leads-1">
                                                    <span class="label label-primary" id="lead_complete" onclick="loadLeadDashboard(1, 1)"><?= count(lead_list(1, 1)); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <th>REFERRAL AGENT</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-ref-0">
                                                    <span class="label label-warning" id="ref_new" onclick="loadLeadDashboard(2, 0)"><?//= count(lead_list(2, '0')); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-ref-1">
                                                    <span class="label label-warning" id="ref_complete" onclick="loadLeadDashboard(2, 1)"><?//= count(lead_list(2, 1)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-ref-3">
                                                    <span class="label label-warning" id="ref_active" onclick="loadLeadDashboard(2, 3)"><?//= count(lead_list(2, 3)); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-ref-2">
                                                    <span class="label label-warning" id="ref_inactive" onclick="loadLeadDashboard(2, 2)"><?//= count(lead_list(2, 2)); ?></span>
                                                </a>
                                            </td>
                                        </tr> -->
                                    <tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row m-r-20">
                            <div class="col-sm-4 col-xs-12">
                                <a class="btn notification-btn" id="notifcation-toggle" value='' href="javascript:void(0);" title="Leads Notifications">Notifications <span class="label label-danger"><?= get_lead_notifications_count('lead'); ?></span></a>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-line-dashed m-b-10">
                    <div class="row m-b-0">
                    </div>
                    
                    <div id="load_data"></div>
                    <div id="lead_dashboard_div"></div>
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
            <form method="post" action="<?= base_url(); ?>lead_management/home/updateNotes">
                <div id="notes-modal-body" class="modal-body no-padding">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    loadLeadDashboard('<?= $type; ?>', '<?= $stat; ?>', '', '<?= $lead_type; ?>');
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
            url: '<?= base_url(); ?>' + 'lead_management/home/filter_dropdown_option_ajax',
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
                        variable: variableValue
                    },
                    url: '<?= base_url(); ?>' + 'lead_management/home/filter_dropdown_option_ajax',
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
                    url: '<?= base_url(); ?>' + 'lead_management/home/filter_dropdown_option_ajax',
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