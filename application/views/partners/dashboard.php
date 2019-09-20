<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form"  method="post" onsubmit="partnerFilter()">
                                    <div class="form-group filter-inner">
                                        <div class="row">
                                            <div class="m-b-10 pull-left col-md-10">
                                                <a class="btn btn-primary" href="<?= base_url(); ?>referral_partner/referral_partners/new_referral_agent?q=partner"><i class="fa fa-plus"></i> Add New Partner</a>
                                            </div>
                                        </div>
                                        <div class="filter-div m-b-20 row" id="original-filter">                                           
                                            <div class="col-sm-3 m-t-10">
                                                <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="changeVariable(this)">
                                                    <option value="">All Variable</option>
                                                    <?php
                                                    // asort($filter_element_list);
                                                    foreach ($filter_element_list as $key => $fel):
                                                        ?>
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
                                                <button class="btn btn-success" type="button" onclick="partnerFilter()">Apply Filter</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="m-t-5 m-r-5"><span class="text-success" style="display: none;" id="clear_filter"> &nbsp; </span><a href="javascript:void(0);" onclick="" class="btn btn-ghost" id="btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a></h4>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center">New</th>
                                            <th class="text-center">Active</th>
                                            <th class="text-center">Complete</th> 
                                            <th class="text-center">Inactive</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="byme">
                                            <th>By Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-0">
                                                    <span class="label label-success" id="requested_by_me_new" onclick="loadPartnerDashboard(0,'byme'); "><?= partnerList(0,'byme'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-3">
                                                    <span class="label label-warning" id="requested_by_me_started" onclick="loadPartnerDashboard(3,'byme');"><?= partnerList(3,'byme'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-1">
                                                    <span class="label label-primary" id="requested_by_me_completed" onclick="loadPartnerDashboard(1,'byme');"><?= partnerList(1,'byme'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                    <span class="label label-danger" id="requested_by_me_important" onclick="loadPartnerDashboard(2,'byme');"><?= partnerList(2,'byme'); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr id="tome" class="action-row-border-bottom">
                                            <th>To Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-0">
                                                    <span class="label label-success" id="requested_to_me_new" onclick="loadPartnerDashboard(0,'tome');"><?= partnerList(0,'tome'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-3">
                                                    <span class="label label-warning" id="requested_to_me_started" onclick="loadPartnerDashboard(3,'tome');"><?= partnerList(3,'tome'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-1">
                                                    <span class="label label-primary" id="requested_to_me_completed" onclick="loadPartnerDashboard(1,'tome');"><?= partnerList(1,'tome'); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-2">
                                                    <span class="label label-danger" id="requested_to_me_important" onclick="loadPartnerDashboard(2,'tome');"><?= partnerList(2,'tome'); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-line-dashed m-b-10">
                    <div class="ajaxdiv"></div>
                    <div class="row m-b-0">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script type="text/javascript">
	loadPartnerDashboard('','');

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
            url: '<?= base_url(); ?>' + 'partners/filter_dropdown_option_ajax',
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
                    url: '<?= base_url(); ?>' + 'partners/filter_dropdown_option_ajax',
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
                    url: '<?= base_url(); ?>' + 'partners/filter_dropdown_option_ajax',
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