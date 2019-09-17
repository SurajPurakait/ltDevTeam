<?php
$user_info = staff_info();
$user_type = $user_info['type'];
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form"  method="post">
                                    <div class="form-group filter-inner">                                    
                                        <div class="filter-div m-b-20 row" id="original-filter">                                           
                                            <div class="col-sm-3 m-t-10">
                                                <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="changeVariable(this)">
                                                    <option value="">Select Variable</option>
                                                    <?php foreach ($filter_element_list as $key => $fel): ?>
                                                        <option value="<?= $key ?>"><?= $fel ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 m-t-10">
                                                <select class="form-control condition-dropdown" name="condition_dropdown[]" onchange="changeCondition(this)">                                                
                                                    <option value="">Select Condition</option>
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
                                                <button class="btn btn-success" type="button" onclick="newsFilter()">Apply Filter</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="m-t-5 m-r-5"><a href="javascript:void(0);" class="btn btn-ghost" id="btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a></h4>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-8 col-sm-6 p-b-10">
                            <h2 class="text-primary m-t-0">News &AMP; Updates</h2>
                            <!--                        <div class="form-group m-t-20">
                            <?php
//                            if ($filter == '') {
//                                $news_chk = 'checked="checked"';
//                                $update_chk = 'checked="checked"';
//                            } elseif ($filter == 1) {
//                                if ($news == 'news') {
//                                    $news_chk = 'checked="checked"';
//                                } else {
//                                    $news_chk = '';
//                                }
//
//                                if ($update == 'update') {
//                                    $update_chk = 'checked="checked"';
//                                } else {
//                                    $update_chk = '';
//                                }
//                            }
                            ?>
                                                        <label class="m-r-10">
                                                            <input class="filter-status" type="checkbox" value="news" id=""  name="news" <?= $news_chk ?>> News                
                                                        </label>
                                                        <label>
                                                            <input class="filter-status" type="checkbox"  value="update" id="" name="update" <?= $update_chk ?>> Update               
                                                        </label>
                                                    </div>-->
                        </div>
                        <?php
                        if ($user_type == 1) {
                            ?>
                            <div class="col-xs-4 col-sm-6 text-right">
                                <button type="button" class="btn btn-primary"  onclick="getCreateNewsModal('');"><i class="fa fa-plus"></i> &nbsp;Add</button>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div id="new_update_dashboard_div" class="news-box p-b-0"></div>                    
                </div>
            </div>
        </div>
    </div>
</div><!-- /.wrapper -->

<!-- News Modal -->
<div id="newsModal" class="modal fade" role="dialog"></div>

<div id="usersModal" class="modal fade" role="dialog"></div>

<script>
    loadNewsUpdateDashboard();

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
            url: '<?= base_url(); ?>' + 'news/filter_dropdown_option_ajax',
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
                        variable: variableValue
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

    $('#btn_clear_filter').click(function () {
        $(this).css('display', 'none');
        loadNewsUpdateDashboard();
    });
</script>
