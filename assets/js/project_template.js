function getServiceList(category_id, service_id = '') {
    if (category_id == 20) {
        $('#service').removeAttr('required');
        $("#template_service_id").hide();
    } else {
        var category_id = $("#service_category option:selected").val();
        if (category_id == 20) {
            $('#service').removeAttr('required');
            $("#template_service_id").hide();
        } else {
            $.ajax({
                type: "POST",
                data: {category_id: category_id, select_service: service_id}, //add_new_action
                url: base_url + 'administration/template/get_service_list',
                dataType: "html",
                success: function (result) {
                    $('#service').html(result);
                    $("#template_service_id").show();

                },
                beforeSend: function () {
                    openLoading();
                },
                complete: function (msg) {
                    closeLoading();
                }
            });
        }
}
}

//department staff uttam (new)
function get_template_office_new(is_all = '', department_id = '', staff_id = '') {
//    alert(department_id);
    var department_id = $("#department option:selected").val();
    if (department_id != '') {
        var staff_type = $("#staff_type").val();
        var disable_field = $("#disable_field").val();
        $.ajax({
            type: "POST",
            data: {
                department_id: department_id,
                select_staffs: staff_id,
                is_all: is_all,
                ismyself: 0
            },
            url: base_url + 'administration/template/get_template_office_ajax_new',
            dataType: "html",
            success: function (result) {
                $("#dept_staff_div").html(result);
                $("#dept_staff_div").show();
                if (disable_field == "y") {
                    $(".is_all").attr("disabled", "disabled");
                    $("#dept_staff").attr("disabled", "disabled");
                    $("#dept_staff").removeAttr('required');
                } else {
                    if ($("#dept_staff").attr("disabled")) {
                        $("#dept_staff").removeAttr("disabled");
                    }
                    if ($(".is_all").attr("disabled")) {
                        $(".is_all").removeAttr("disabled");
                    }
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
        $("#dept_staff_div").hide();
}
}
//responsible staff
function get_template_responsible_staff(res_department = '', res_staff = '', is_all = '', staff_id = '') {
//    alert(res_department);
    var user_type = $("#user_type option:selected").val();
    if (user_type != '') {
        var staff_type = $("#ofc_staff_type").val();
        var disable_field = $("#disable_field").val();
        $.ajax({
            type: "POST",
            data: {
                user_type: user_type,
                res_department: res_department,
                res_staff: res_staff,
                is_all: is_all,
                select_staff: staff_id
//                ismyself: 0,
//                partner: partner,
//                manager: manager,
//                associate: associate
            },
            url: base_url + 'administration/template/get_template_responsible_staff_ajax',
            dataType: "html",
            success: function (result) {
//                alert(user_type);
                $('#responsible_francise_div').html(result);
                if (user_type == 3 && user_type != 1 && user_type != 2) {
                    $('#responsible_francise_div').show();
                    $('#responsible_staff_div').hide();
//                    get_responsible_staff(user_type);
                } else {
                    if (user_type == 1) {
                        get_responsible_staff_list(staff_id, is_all, user_type)
                    }
                    $('#responsible_francise_div').show();
                    $('#responsible_staff_div').hide();
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
        $('#responsible_francise_div').hide();
        $('#responsible_staff_div').hide();
}
}
function get_responsible_staff(user_type = '') {
    if (user_type != '') {
        $.ajax({
            type: "POST",
            data: {
                user_type: user_type,
                responsible_staff: responsible_staff
            },
            url: base_url + 'administration/template/get_responsible_francise_staff',
            dataType: "html",
            success: function (result) {
//                alert(user_type);
                $('#responsible_staff_div').html(result);
                $('#responsible_staff_div').show();
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    } else {
        $('#responsible_staff_div').hide();
}
}
function get_responsible_staff_list(select_staff = '', is_all = '', user_type = '') {
    var department_id = $("#responsible_department option:selected").val();
//    alert(user_type);
    if (department_id != '') {
        $.ajax({
            type: "POST",
            data: {
                department_id: department_id,
                ismyself: 0,
                select_staffs: select_staff,
                is_all: is_all,
                user_type: user_type
            },
            url: base_url + 'administration/template/get_responsible_staff_list_ajax',
            dataType: "html",
            success: function (result) {
//                alert(user_type);
                $('#responsible_staff_div').html(result);
                $('#responsible_staff_div').show();
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    } else {
        $('#responsible_staff_div').hide();
}
}
//office staff    uttam(new)
function get_template_office_staff(is_all = '', office_id = '', staff_id = '', partner = '', manager = '', associate = '') {
//    alert(staff_id);return false;
    var office_id = $("#office option:selected").val();
    if (office_id != '') {
        var staff_type = $("#ofc_staff_type").val();
        var disable_field = $("#disable_field").val();
        $.ajax({
            type: "POST",
            data: {
                select_office: office_id,
                select_staffs: staff_id,
                is_all: is_all,
                ismyself: 0,
                partner: partner,
                manager: manager,
                associate: associate
            },
            url: base_url + 'administration/template/get_template_office_staff_ajax',
            dataType: "html",
            success: function (result) {
                $("#ofic_staff_div").html(result);
                $("#ofic_staff_div").show();
                if (disable_field == "y") {
                    $(".is_all").attr("disabled", "disabled");
                    $("#office_staff").attr("disabled", "disabled");
                    $("#staff-hidden").val(1);
                    $("#office_staff").removeAttr('required');
                } else {
                    if ($("#office_staff").attr("disabled")) {
                        $("#office_staff").removeAttr("disabled");
                    }
                    if ($(".is_all").attr("disabled")) {
                        $(".is_all").removeAttr("disabled");
                    }
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
        $("#ofic_staff_div").hide();
}
}

//task deparment list
function get_task_department_staff(select_staffs = "", is_all = "", responsible_staff = "") {
//    alert(is_all);
    var department_id = $("#task_department option:selected").val();

    if (department_id != '') {
        var staff_type = $("#task_staff_type").val();
        var disabled = $("#task_disable_field").val();
        var assign_myself = '';
        var ismyself = $(".ismyself").val();

        $.ajax({
            type: "POST",
            data: {
                department_id: department_id,
                disabled: disabled,
                responsible_staff: responsible_staff,
                select_staff: select_staffs,
                ismyself: ismyself,
                is_all: is_all
            },
            url: base_url + 'administration/template/get_task_department_office_ajax',
            dataType: "html",
            success: function (result) {
                $("#task_office_div").html(result);
                $("#task_office_div").show();
                $("#task_staff_div").hide();
//                if (parseInt(department_id) != 2 && parseInt(staff_type) == 1) {
//                    $("#task_office_div").hide();
//                    get_task_staff(select_staffs, assign_myself, disabled);
//                    //$("#office").attr("disabled", "disabled");
//                } else if (parseInt(department_id) != 2 && parseInt(staff_type) == 2) {
//                    $("#task_office_div").hide();
//                    get_task_staff(select_staffs, assign_myself, disabled);
//                    //$("#office").attr("disabled", "disabled");
//                } else if (parseInt(department_id) != 2 && parseInt(staff_type) == 3) {
//                    $("#task_office_div").hide();
//                    get_task_staff(select_staffs, assign_myself, disabled,is_all,responsible_staff);
//                    //$("#office").attr("disabled", "disabled");
//                } else if (disabled == "y") {
//                    $("#office").attr("disabled", "disabled");
//                } else {
//                    $("#task_office_div").show();
//                    $("#task_staff_div").hide();
//                    // if ($("#office").attr("disabled")) {
//                    //     $("#office").removeAttr("disabled");
//                    // }
//                }

            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    } else {
        $("#task_office_div").hide();
        $("#task_staff_div").hide();
}
}
function get_task_staff(select_staffs = '', assign_myself = '', disabled = '', is_all = '', responsible_staff = '') {
//    alert(is_all);
    var department_id = $("#task_department option:selected").val();
    var office_id = $("#task_office option:selected").val();
    var ismyself = $(".ismyself").val();
    if (department_id != '' && office_id != '') {

        var disable_field = $("#disable_field").val();
        $.ajax({
            type: "POST",
            data: {
                department_id: department_id,
                office_id: office_id,
                select_staffs: select_staffs,
                ismyself: ismyself,
                disabled: disabled,
                is_all: is_all,
                responsible_staff: responsible_staff
            },
            url: base_url + 'administration/template/get_template_task_staff_ajax',
            dataType: "html",
            success: function (result) {
//                alert(assign_myself);
                $("#task_staff_div").html(result);
                $("#task_staff_div").show();
                if (disable_field == "y") {
                    $(".is_all").attr("disabled", "disabled");
                    $("#task_staff").attr("disabled", "disabled");
                    $("#staff-hidden").val(1);
                    $("#task_staff").removeAttr('required');
                } else {
//                    alert('b');
//                    $("#task_staff_div").show();
//                     if ($("#staff").attr("disabled")) {
//                         $("#staff").removeAttr("disabled");
//                     }
//                     if ($(".is_all").attr("disabled")) {
//                         $(".is_all").removeAttr("disabled");
//                     }
                }
                if (assign_myself != '') {
                    hide_task_ofc_staff_div_in_editcase(assign_myself);
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
        $("#task_staff_div").hide();
}
}
function hide_task_ofc_staff_div_in_editcase(assign_myself) {
//    alert(assign_myself);
    if (assign_myself != 0) {
        $("#is_chk_mytask").prop('checked', true);
        $("#task_department").removeAttr("required");
        $("#task_office").removeAttr("required");
        $(".spanclass").html('');
        $(".dept_div").hide();
        $("#task_office_div").hide();
        $("#task_staff_div").hide();
    } else {
//        var dept = $("#task_department option:selected").val();
//        if (dept == 2) {
//            $("#task_office_div").show();
//        }
        $("#is_chk_mytask").prop('checked', false);
        $("#task_department").attr("required", "required");
        $("#task_office").attr("required", "required");
        $(".spanclass").html('*');
        $(".dept_div").show();
        $("#task_staff_div").show();
    }
}

//end task department staff

function request_create_template() {
if (!requiredValidation('save_template_main')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("save_template_main"));
    var pattern = $("#pattern option:selected").val();
    if (pattern == '') {
        $("#err_generation").html("Please Select Pattern From Generation.");
        return false;
    }
    if ($("#occur_weekdays").prop("checked") == true) {
        var occur_weekdays = '1';
    } else {
        var occur_weekdays = '0';
    }

    if ($("#client_fiscal_year_end").prop("checked") == true) {
        var client_fiscal_year_end = '1';
        var client_fiscal_year_type = $('input[name="recurrence[due_fiscal]"]:checked').val();
        if (client_fiscal_year_type == 1) {
            var client_fiscal_year_day = $('input[name="recurrence[due_fiscal_day]"]').val();
            ;
            var client_fiscal_year_wday = '0';
            var client_fiscal_year_month = $('input[name="recurrence[due_fiscal_day]"] option:selected').val();
        } else {
            var client_fiscal_year_day = $('input[name="recurrence[due_fiscal_month]"] option:selected').val();
            var client_fiscal_year_wday = $('input[name="recurrence[due_fiscal_wday]"] option:selected').val();
            var client_fiscal_year_month = $('input[name="recurrence[due_fiscal_month]"] option:selected').val();
        }
    } else {
        var client_fiscal_year_end = '0';
        var client_fiscal_year_type = '0';
        var client_fiscal_year_day = '0';
        var client_fiscal_year_wday = '0';
        var client_fiscal_year_month = '0';
    }
    if (pattern == 'annually') {
        if (client_fiscal_year_end == 1) {
            var due_day = '0';
            var due_month = '0';
        } else {
            var due_day = $("#r_day").val();
            var due_month = $("#r_month option:selected").val();
        }
    } else if (pattern == 'none') {
        var due_day = $("#r_day").val();
        var due_month = $("#r_month option:selected").val();
    } else if (pattern == 'weekly') {
        var due_day = $("#r_day").val();
        var due_month = $('input[name="recurrence[due_month]"]:checked').val();
    } else if (pattern == 'quarterly') {
        var due_day = $("#r_day").val();
        var due_month = $("#r_month option:selected").val();
    } else if(pattern=='periodic'){
        var due_day = $("#r_day").val();
        var due_month = $("#r_month").val();
        var periodic_days= new Array();
        var periodic_months= new Array();
        $("input[name='due_days[]']").each(function(){
            periodic_days.push($(this).val());
        });
        var periodic_months = $('.periodic_mnth').map(function(){
            return this.value;
        }).get();
        var periodic_due_days=JSON.stringify(periodic_days);
        var periodic_due_months=JSON.stringify(periodic_months);
    }
    else {
        var due_day = $("#r_day").val();
        var due_month = $("#r_month").val();
    }
    var expiration_type = $('input[name="recurrence[expiration_type]"]:checked').val();
    var end_occurrence = $("#end_occurrence").val();
    var target_start_days = $("#t_start_day").val();
    var target_start_months = $("#t_start_month").val();
    var target_end_days = $("#t_end_day").val();
    var target_end_months = $("#t_end_month").val();
    var target_start_day = $('input[name="recurrence[target_start_day]"]:checked').val();
    var target_end_day = $('input[name="recurrence[target_end_day]"]:checked').val();
    var generation_type = $('input[name="recurrence[generation_type]"]:checked').val();
    var generation_day = $("#generation_day").val();
    var generation_month = $("#generation_month").val();

    form_data.append('recurrence[pattern]', pattern);
    form_data.append('recurrence[occur_weekdays]', occur_weekdays);
    form_data.append('recurrence[client_fiscal_year_end]', client_fiscal_year_end);
    form_data.append('recurrence[due_day]', due_day);
    form_data.append('recurrence[due_month]', due_month);
    form_data.append('recurrence[periodic_due_day]', periodic_due_days);
    form_data.append('recurrence[periodic_due_month]', periodic_due_months);
    form_data.append('recurrence[expiration_type]', expiration_type);
    form_data.append('recurrence[end_occurrence]', end_occurrence);
    form_data.append('recurrence[target_start_days]', target_start_days);
    form_data.append('recurrence[target_start_months]', target_start_months);
    form_data.append('recurrence[target_start_day]', target_start_day);
    form_data.append('recurrence[target_end_days]', target_end_days);
    form_data.append('recurrence[target_end_months]', target_end_months);
    form_data.append('recurrence[target_end_day]', target_end_day);
    form_data.append('recurrence[generation_type]', generation_type);
    form_data.append('recurrence[generation_day]', generation_day);
    form_data.append('recurrence[generation_month]', generation_month);
    form_data.append('recurrence[fye_type]', client_fiscal_year_type);
    form_data.append('recurrence[fye_day]', client_fiscal_year_day);
    form_data.append('recurrence[fye_is_weekday]', client_fiscal_year_wday);
    form_data.append('recurrence[fye_month]', client_fiscal_year_month);

    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'administration/template/request_create_template',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result); 
//console.log(result); return false;
            if (result.trim() != "-1") {
                swal({
                    title: "Success!",
                    text: "Template Successfully Added!",
                    type: "success"
                }, function () {
                    $('#task_btn').val(result);
                    $('#task_btn').prop('disabled', false);
                    $("#nav-link-2").trigger("click");
                    //goURL(base_url + 'action/home');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Template", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function get_template_task_modal(template_id) {
    $.ajax({
        type: "POST",
        url: base_url + 'modal/get_template_task_modal',
        dataType: "html",
        data: {template_id: template_id},
        success: function (result) {
            $('#taskModal').modal();
            $('#taskModal').html(result);

        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });

}
function tetmplate_task_edit_modal(task_id,template_id='') {
    //alert(template_id);
    $.ajax({
        type: "POST",
        url: base_url + 'modal/edit_template_task_modal',
        dataType: "html",
        data: {task_id: task_id,template_id:template_id},
        success: function (result) {
//            alert(result);
            $('#taskModal').html(result);
            $('#taskModal').modal();
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function change_due_pattern(val) {
    if (val == 'annually') {
        $(".none-div").show();
        $(".annual-check-div").show();
        $('#weekend_val').show();
        $(".due-div").html('<label class="control-label m-r-5"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day" class="m-r-5"> Due on every</label>&nbsp;<select class="form-control m-r-5" id="r_month" name="recurrence[due_month]" value="1"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day">');
    } else if (val == 'weekly') {
        $(".none-div").show();
        $(".annual-check-div").hide();
        $('#weekend_val').show();
        $(".due-div").html('<label class="control-label m-r-5"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due every</label>&nbsp;<input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" value="1" style="width: 100px" id="r_day">&nbsp;week(s) on the following days:&nbsp;<div class="m-t-10"><div class="m-b-10"><span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="1" checked="" class="m-r-5">&nbsp;Sunday&nbsp;</span><span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="2" class="m-r-5">&nbsp;Monday&nbsp;</span><span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="3" class="m-r-5">&nbsp;Tuesday&nbsp;</span><span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="4" class="m-r-5">&nbsp;Wednesday&nbsp;</span></div><span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="5" class="m-r-5">&nbsp;Thursday&nbsp;</span><span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="6" class="m-r-5">&nbsp;Friday&nbsp;</span><span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="7" class="m-r-5">&nbsp;Saturday</span></div>');
    } else if (val == 'quarterly') {
        $(".none-div").show();
        $(".annual-check-div").hide();
        $('#weekend_val').show();
        $(".due-div").html('<label class="control-label m-r-5"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due on day</label>&nbsp;<input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" value="1" style="width: 100px" id="r_day"><label class="control-label m-r-5">of</label>&nbsp;<select class="form-control m-r-5" id="r_month" name="recurrence[due_month]"><option value="1">First</option><option value="2">Second</option><option value="3">Third</option></select>&nbsp;<label class="control-label m-r-5" id="control-label">month in quarter</label>');
    } else if (val == 'monthly') {
        $(".none-div").show();
        $(".annual-check-div").hide();
        $('#weekend_val').show();
        $(".due-div").html('<label class="control-label m-r-5"><input type="radio" class="m-r-5" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due on day</label>&nbsp;<input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" value="1" style="width: 100px" id="r_day"><label class="control-label m-r-5">of every</label>&nbsp;<input class="form-control m-r-5" type="number" name="recurrence[due_month]" min="1" max="12" value="1" style="width: 100px" id="r_month">&nbsp;<label class="control-label" id="control-label">month(s)</label>');
    } else if (val == 'periodic') {
        $(".none-div").show();
        $(".annual-check-div").hide();
        $('#weekend_val').hide();
        $(".due-div").addClass("recurrence-date");
        $(".due-div").html('<div class="row"><div class="col-md-12 m-b-5"><label class="control-label m-r-5">Due on day</label>&nbsp;<input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" value="1" style="width: 100px" id="r_day"><label class="control-label m-r-5">of month</label>&nbsp;<select class="form-control m-r-5" id="r_month" name="recurrence[due_month]" value="1"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<a href="javascript:void(0);" onclick="addPeriodicDate()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Periodic Date"> <i class="fa fa-plus" aria-hidden="true"></i> </a></div></div>');
    } else {
        $(".none-div").hide();
        $(".annual-check-div").hide();
        $('#weekend_val').show();
        $(".due-div").html('<label class="control-label m-r-5"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day" class="m-r-5"> Due on every</label>&nbsp;<select class="form-control m-r-5" id="r_month" name="recurrence[due_month]"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day">');
    }
}
    
function addPeriodicDate(){
    var random = Math.floor((Math.random() * 999) + 1);
    var clone='<div class="row" id="clone-'+random+'"><div class="col-md-12 m-b-5"><label class="control-label m-r-5"> Due on day</label>&nbsp;<input class="form-control m-r-5 test" type="number" name="due_days[]" min="1" max="31" value="1" style="width: 100px" id="r_day1"><label class="control-label m-r-5">of month</label>&nbsp;<select class="form-control m-r-2 periodic_mnth" id="r_month1" name="due_months[]" value="1"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp; <a href="javascript:void(0);" onclick="removePeriodicDate(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>';
    $(".due-div").append(clone);
}
function removePeriodicDate(random) {
    var variableArray = [];
    var elementArray = [];
    var divID = 'clone-' + random;
    var variableDropdownValue = $("#clone-" + random).val();
    var index = variableArray.indexOf(variableDropdownValue);
    variableArray.splice(index, 1);
    $("#" + divID).remove();
}

function closeRecurrenceModal() {
    var get_content = $('#RecurranceModal .modal-body').html();

    // var form_data = $('#template-task-modal').serialize(); 
    // var form_data = "Hello";
    // alert($("#due_on_the_second").val());return false;

    // alert($("#due_on_day:checked").val());
    // alert($("#due_on_the:checked").val());
    $('#pattern_show').html('');

    //if ($("#due_on_day").is(":checked")) {
    var patterntext = $("#pattern option:selected").text();
    // var patternval = $("#pattern option:selected").val();
    // var rday = $("#r_day").val();
    // var rmonth = $("#r_month").val();
    // // form_data.push($("#r_day").val());
    // // form_data.push($("#r_month").val());
    // //}
    // // else if($("#due_on_the").is(":checked")){
    // //     form_data.push($("#pattern").val());
    // //     form_data.push($("#due_on_the_first option:selected").val());
    // //     form_data.push($("#due_on_the_second option:selected").val());
    // //     form_data.push($("#due_on_the_every").val());        
    // // }
    // if (patternval == 'yearly') {
    //     var ryear = $("#r_year").val();
    // } else {
    //     var ryear = '';
    // }
    // if (ryear != '') {
    //     get_data += ' ' + ryear + ' Year';
    // }

    $('#pattern_show').html(patterntext);
    // var a=patterntext;
    // if(a==''){
    //     alert('hi');
    // }
    //$('#RecurranceModalContainer').html(get_content);
    $('#RecurranceModal').modal('hide');

}
function save_task() {
    if (!requiredValidation('template-task-modal')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("template-task-modal"));
    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'administration/template/project_template_task',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //alert(result);
            if (result.trim() != "-1") {
                swal({
                    title: "Success!",
                    text: "Template Task Successfully Added!",
                    type: "success"
                }, function () {
                    $("#task_list").html(result);
                    $("#taskModal").modal('hide');
                }
                );
            } else {
                swal("ERROR!", "Unable To Add Template Task.", "error");
            }

        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function go(url) {
    window.location.href = base_url + url;
}
function request_edit_template() {
    if (!requiredValidation('update_template_main')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("update_template_main"));
    var pattern = $("#pattern option:selected").val();
    if ($("#occur_weekdays").prop("checked") == true) {
        var occur_weekdays = '1';
    } else {
        var occur_weekdays = '0';
    }
    if ($("#client_fiscal_year_end").prop("checked") == true) {
        var client_fiscal_year_end = '1';
        var client_fiscal_year_type = $('input[name="recurrence[due_fiscal]"]:checked').val();
        if (client_fiscal_year_type == 1) {
            var client_fiscal_year_day = $('input[name="recurrence[due_fiscal_day]"]').val();
            ;
            var client_fiscal_year_wday = '0';
            var client_fiscal_year_month = $('input[name="recurrence[due_fiscal_day]"] option:selected').val();
        } else {
            var client_fiscal_year_day = $('input[name="recurrence[due_fiscal_month]"] option:selected').val();
            var client_fiscal_year_wday = $('input[name="recurrence[due_fiscal_wday]"] option:selected').val();
            var client_fiscal_year_month = $('input[name="recurrence[due_fiscal_month]"] option:selected').val();
        }
    } else {
        var client_fiscal_year_end = '0';
        var client_fiscal_year_type = '0';
        var client_fiscal_year_day = '0';
        var client_fiscal_year_wday = '0';
        var client_fiscal_year_month = '0';
    }
    if (pattern == 'annually') {
        if (client_fiscal_year_end == 1) {
            var due_day = '0';
            var due_month = '0';
        } else {
            var due_day = $("#r_day").val();
            var due_month = $("#r_month option:selected").val();
        }
    } else if (pattern == 'none') {
        var due_day = $("#r_day").val();
        var due_month = $("#r_month option:selected").val();
    } else if (pattern == 'weekly') {
        var due_day = $("#r_day").val();
        var due_month = $('input[name="recurrence[due_month]"]:checked').val();
    } else if (pattern == 'quarterly') {
        var due_day = $("#r_day").val();
        var due_month = $("#r_month option:selected").val();
    }else if (pattern == 'periodic') {
       var due_day = $("#r_day").val();
        var due_month = $("#r_month").val();
        var periodic_days= new Array();
        var periodic_months= new Array();
        $("input[name='due_days[]']").each(function(){
            periodic_days.push($(this).val());
        });
        var periodic_months = $('.periodic_mnth').map(function(){
            return this.value;
        }).get();
        var periodic_due_days=JSON.stringify(periodic_days);
        var periodic_due_months=JSON.stringify(periodic_months);
    }  
    else {
        var due_day = $("#r_day").val();
        var due_month = $("#r_month").val();
    }

    var expiration_type = $('input[name="recurrence[expiration_type]"]:checked').val();
    var end_occurrence = $("#end_occurrence").val();
    var target_start_days = $("#t_start_day").val();
    var target_start_months = $("#t_start_month").val();
    var target_end_days = $("#t_end_day").val();
    var target_end_months = $("#t_end_month").val();
    var target_start_day = $('input[name="recurrence[target_start_day]"]:checked').val();
    var target_end_day = $('input[name="recurrence[target_end_day]"]:checked').val();
    var generation_type = $('input[name="recurrence[generation_type]"]:checked').val();
    var generation_day = $("#generation_day").val();
    var generation_month = $("#generation_month").val();

    form_data.append('recurrence[pattern]', pattern);
    form_data.append('recurrence[occur_weekdays]', occur_weekdays);
    form_data.append('recurrence[client_fiscal_year_end]', client_fiscal_year_end);
    form_data.append('recurrence[due_day]', due_day);
    form_data.append('recurrence[due_month]', due_month);
    form_data.append('recurrence[periodic_due_day]', periodic_due_days);
    form_data.append('recurrence[periodic_due_month]', periodic_due_months);
    form_data.append('recurrence[expiration_type]', expiration_type);
    form_data.append('recurrence[end_occurrence]', end_occurrence);
    form_data.append('recurrence[target_start_days]', target_start_days);
    form_data.append('recurrence[target_start_months]', target_start_months);
    form_data.append('recurrence[target_start_day]', target_start_day);
    form_data.append('recurrence[target_end_days]', target_end_days);
    form_data.append('recurrence[target_end_months]', target_end_months);
    form_data.append('recurrence[target_end_day]', target_end_day);
    form_data.append('recurrence[generation_type]', generation_type);
    form_data.append('recurrence[generation_day]', generation_day);
    form_data.append('recurrence[generation_month]', generation_month);
    form_data.append('recurrence[fye_type]', client_fiscal_year_type);
    form_data.append('recurrence[fye_day]', client_fiscal_year_day);
    form_data.append('recurrence[fye_is_weekday]', client_fiscal_year_wday);
    form_data.append('recurrence[fye_month]', client_fiscal_year_month);

    var edit_template = $("#edit_template").val();
    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'administration/template/request_edit_template/' + edit_template,
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result);return false;
            if (result.trim() != "-1") {
                swal({
                    title: "Success!",
                    text: "Template Successfully Added!",
                    type: "success"
                }, function () {
                    $('#task_btn').val(result);
                    $('#task_btn').prop('disabled', false);
                    $("#nav-link-2").trigger("click");
                    //goURL(base_url + 'action/home');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Template", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function CreateProjectModal(modal_type, project_id = '') {
    $.ajax({
        type: "POST",
        data: {
            project_id: project_id,
            modal_type: modal_type
        },
        url: base_url + 'modal/ajax_manage_project',
        success: function (project_result) {
            $("#projectModal").html(project_result);
            $("#projectModal").modal();
            $('#projectModal').modal({
                backdrop: 'static'
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
function project_client_list(office_id = '', client_id = '', mode = '') {
//    alert(mode);
    $.ajax({
        type: "POST",
        data: {
            office_id: office_id,
            client_id: client_id,
            mode: mode
        },
        url: base_url + 'project/get_project_completed_orders_officewise',
        dataType: "html",
        success: function (result) {
            $("#client_list_project").html(result);
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function project_responsible_client(client) {
//    var client= $("#client_list_project option:selected").val();
//    alert(client);
}

function request_create_project() {
    if (!requiredValidation('form_save_project')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("form_save_project"));

    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'project/request_create_project',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result);
            if (result.trim() != "-1") {
                $('#projectModal').hide();
                swal({
                    title: "Success!",
                    text: "Project Successfully Added!",
                    type: "success"
                }, function () {
                    var category='';
                    if(result=='1'){
                            category="1-bookkeeping";
                        }else if(result=='2'){
                            category= '2-tax_returns';
                        }else if(result=='3'){
                            category= '3-sales_tax';
                        }else{
                            category= '4-annual_report';
                        }
                    goURL(base_url + 'Project/index/'+category+'/'+result);
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Data", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function request_update_project(project_id) {
    if (!requiredValidation('form_save_project')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("form_save_project"));

    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'project/request_update_project/' + project_id,
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({
                    title: "Success!",
                    text: "Project Updated Successfully!",
                    type: "success"
                }, function () {
                    goURL(base_url + 'project');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Data", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function update_task(task_id, template_id) {
//    alert(task_id);return false;
    if (!requiredValidation('template-task-edit-modal')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("template-task-edit-modal"));
    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'administration/template/update_project_template_task/' + task_id + '/' + template_id,
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //alert(result);
            if (result.trim() != "-1") {
                swal({
                    title: "Success!",
                    text: "Template Task Successfully Updated!",
                    type: "success"
                }, function () {
                    $("#task_list").html(result);
                    $("#taskModal").modal('hide');
                }
                );
            } else {
                swal("ERROR!", "Unable To Add Template Task.", "error");
            }

        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function request_edit_project_main() {
    if (!requiredValidation('update_project_main')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("update_project_main"));

    var pattern = $("#pattern option:selected").val();
    if ($("#occur_weekdays").prop("checked") == true) {
        var occur_weekdays = '1';
    } else {
        var occur_weekdays = '0';
    }
    if ($("#client_fiscal_year_end").prop("checked") == true) {
        var client_fiscal_year_end = '1';
        var client_fiscal_year_type = $('input[name="recurrence[due_fiscal]"]:checked').val();
        if (client_fiscal_year_type == 1) {
            var client_fiscal_year_day = $('input[name="recurrence[due_fiscal_day]"]').val();
            ;
            var client_fiscal_year_wday = '0';
            var client_fiscal_year_month = $('input[name="recurrence[due_fiscal_day]"] option:selected').val();
        } else {
            var client_fiscal_year_day = $('input[name="recurrence[due_fiscal_month]"] option:selected').val();
            var client_fiscal_year_wday = $('input[name="recurrence[due_fiscal_wday]"] option:selected').val();
            var client_fiscal_year_month = $('input[name="recurrence[due_fiscal_month]"] option:selected').val();
        }
    } else {
        var client_fiscal_year_end = '0';
        var client_fiscal_year_type = '0';
        var client_fiscal_year_day = '0';
        var client_fiscal_year_wday = '0';
        var client_fiscal_year_month = '0';
    }
    if (pattern == 'annually') {
        if (client_fiscal_year_end == 1) {
            var due_day = '0';
            var due_month = '0';
        } else {
            var due_day = $("#r_day").val();
            var due_month = $("#r_month option:selected").val();
        }
    } else if (pattern == 'none') {
        var due_day = $("#r_day").val();
        var due_month = $("#r_month option:selected").val();
    } else if (pattern == 'weekly') {
        var due_day = $("#r_day").val();
        var due_month = $('input[name="recurrence[due_month]"]:checked').val();
    } else if (pattern == 'quarterly') {
        var due_day = $("#r_day").val();
        var due_month = $("#r_month option:selected").val();
    } else if(pattern == 'periodic'){
        var due_day = $("#r_day").val();
        var due_month = $("#r_month").val();
        var periodic_days= new Array();
        var periodic_months= new Array();
        $("input[name='due_days[]']").each(function(){
            periodic_days.push($(this).val());
        });
        var periodic_months = $('.periodic_mnth').map(function(){
            return this.value;
        }).get();
        var periodic_due_days=JSON.stringify(periodic_days);
        var periodic_due_months=JSON.stringify(periodic_months);
    } 
    else {
        var due_day = $("#r_day").val();
        var due_month = $("#r_month").val();
    }

    var expiration_type = $('input[name="recurrence[expiration_type]"]:checked').val();
    var end_occurrence = $("#end_occurrence").val();
    var target_start_days = $("#t_start_day").val();
    var target_end_days = $("#t_end_day").val();
    var target_start_day = $('input[name="recurrence[target_start_day]"]:checked').val();
    var target_end_day = $('input[name="recurrence[target_end_day]"]:checked').val();
    var generation_type = $('input[name="recurrence[generation_type]"]:checked').val();
    var generation_day = $("#generation_day").val();
    var generation_month = $("#generation_month").val();

    form_data.append('recurrence[pattern]', pattern);
    form_data.append('recurrence[occur_weekdays]', occur_weekdays);
    form_data.append('recurrence[client_fiscal_year_end]', client_fiscal_year_end);
    form_data.append('recurrence[due_day]', due_day);
    form_data.append('recurrence[due_month]', due_month);
    form_data.append('recurrence[periodic_due_day]', periodic_due_days);
    form_data.append('recurrence[periodic_due_month]', periodic_due_months);
    form_data.append('recurrence[expiration_type]', expiration_type);
    form_data.append('recurrence[end_occurrence]', end_occurrence);
    form_data.append('recurrence[target_start_days]', target_start_days);
    form_data.append('recurrence[target_start_day]', target_start_day);
    form_data.append('recurrence[target_end_days]', target_end_days);
    form_data.append('recurrence[target_end_day]', target_end_day);
    form_data.append('recurrence[generation_type]', generation_type);
    form_data.append('recurrence[generation_day]', generation_day);
    form_data.append('recurrence[generation_month]', generation_month);
    form_data.append('recurrence[fye_type]', client_fiscal_year_type);
    form_data.append('recurrence[fye_day]', client_fiscal_year_day);
    form_data.append('recurrence[fye_is_weekday]', client_fiscal_year_wday);
    form_data.append('recurrence[fye_month]', client_fiscal_year_month);

    var edit_template = $("#edit_template").val();
    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'project/request_update_project_main',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result);
            if (result.trim() != "-1") {
                swal({
                    title: "Success!",
                    text: "Project info Successfully Updated!",
                    type: "success"
                }, function () {
                    $('#task_btn').val(result);
                    $('#task_btn').prop('disabled', false);
                    $("#nav-link-2").trigger("click");
                    //goURL(base_url + 'action/home');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Template", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function project_task_edit_modal(task_id,project_id='') {
//    alert(project_id);
    $.ajax({
        type: "POST",
        url: base_url + 'modal/edit_project_task_modal',
        dataType: "html",
        data: {task_id: task_id , project_id:project_id},
        success: function (result) {
//            alert(result);
            $('#taskModal').html(result);
            $('#taskModal').modal();
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function update_project_task(task_id, template_id, project_id) {
//    alert(task_id);return false;
    if (!requiredValidation('project-task-edit-modal')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("project-task-edit-modal"));
    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'project/update_project_task/' + task_id + '/' + template_id + '/' + project_id,
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //alert(result);
            if (result.trim() != "-1") {
                swal({
                    title: "Success!",
                    text: "Project Task Successfully Updated!",
                    type: "success"
                }, function () {
                    $("#task_list").html(result);
                    $("#taskModal").modal('hide');
                }
                );
            } else {
                swal("ERROR!", "Unable To Update Project Task.", "error");
            }

        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function get_project_task_modal(template_id, project_id) {
//    alert(project_id);return false;
    $.ajax({
        type: "POST",
        url: base_url + 'modal/get_project_task_modal',
        dataType: "html",
        data: {template_id: template_id, project_id: project_id},
        success: function (result) {
            $('#taskModal').modal();
            $('#taskModal').html(result);

        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });

}
function save_project_task() {
    if (!requiredValidation('project-task-modal')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("project-task-modal"));
    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'project/add_project_task',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //alert(result);
            if (result.trim() != "-1") {
                swal({
                    title: "Success!",
                    text: "Project Task Successfully Added!",
                    type: "success"
                }, function () {
                    $("#task_list").html(result);
                    $("#taskModal").modal('hide');
                }
                );
            } else {
                swal("ERROR!", "Unable To Add Project Task.", "error");
            }

        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function get_fiscal_year_options() {
    if ($("#client_fiscal_year_end").prop("checked") == true) {
        var fiscal_val = '1';
    } else {
        var fiscal_val = '0';
    }

    if (fiscal_val == 1) {
        $(".due-div").html('<label class="control-label m-r-5"><input type="radio" name="recurrence[due_fiscal]" checked="" value="1"> Due on every</label>&nbsp;<select class="form-control" name="recurrence[due_fiscal_month]"><option value="1">First</option><option value="2">Second</option><option value="3">Third</option><option value="4">Fourth</option></select>&nbsp;<label class="control-label m-r-5">month after FYE on day</label>&nbsp;<input class="form-control m-r-5" value="1" type="number" name="recurrence[due_fiscal_day]" min="1" max="30" style="width: 100px">');
        //$(".due-div").html('<label class="control-label m-r-5"><input type="radio" name="recurrence[due_fiscal]" checked="" value="1"> Due on every</label>&nbsp;<select class="form-control" name="recurrence[due_fiscal_month]"><option value="1">First</option><option value="2">Second</option><option value="3">Third</option><option value="4">Fourth</option></select><label class="control-label m-r-5">month after FYE on day</label>&nbsp;<input class="form-control m-r-5" value="1" type="number" name="recurrence[due_fiscal_day]" min="1" max="30" style="width: 100px">&nbsp;<label class="control-label m-r-5"><input type="radio" name="recurrence[due_fiscal]" value="2"> Due on the</label>&nbsp;<select class="form-control" name="recurrence[due_fiscal_day]"><option value="1">First</option><option value="2">Last</option></select>&nbsp;<select class="form-control" name="recurrence[due_fiscal_wday]"><option value="1">Weekday</option><option value="2">Weekend</option></select><label class="control-label m-r-5">of</label>&nbsp;<select class="form-control" name="recurrence[due_fiscal_month]"><option value="1">First</option><option value="2">Second</option><option value="3">Third</option><option value="4">Fourth</option><option value="5">Fifth</option><option value="6">Sixth</option><option value="7">Seventh</option><option value="8">Eighth</option><option value="9">Ninth</option><option value="10">Tenth</option><option value="11">Eleventh</option><option value="12">Twelfth</option></select>&nbsp;month after FYE');
    } else {
        $(".due-div").html('<label class="control-label m-r-5"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day" class="m-r-5"> Due on every</label>&nbsp;<select class="form-control m-r-5" id="r_month" name="recurrence[due_month]"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day">');
    }
}
//find project client depending on client type
function projectContainerAjax(client_type='', client_id='', project_id='',office_id='')
{
//    alert(client_type);return false;
    var url = '';
    if (project_id != '') {
        url = 'project/get_edit_project_container_ajax';
    } else {
//        alert("hi");return false;
        url = 'project/get_project_container_ajax';
    }
    $.ajax({
        type: 'POST',
        url: base_url + url,
        data: {
            project_id: project_id,
            client_type: client_type,
            client_id: client_id,
            office_id:office_id
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result);
            if (result != '0') {
                $('#project_container').find('#individual_list_ddl').chosen('destroy');
                $('#project_container').html(result);
                $('#project_container').find('#individual_list_ddl').chosen();
            } else {
                go('project');
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function refresh_existing_client_list(office_id = '', client_id = '') {
    $.ajax({
        type: "POST",
        data: {
            office_id: office_id,
            client_id: client_id
        },
        url: base_url + 'project/get_completed_orders_officewise',
        dataType: "html",
        success: function (result) {
//            alert(result);
            $("#client_list").show();
            $("#client_list_ddl").chosen("destroy");
            $("#client_list_ddl").html(result);
            $("#client_list_ddl").chosen();
            
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function sort_project_dashboard(sort_criteria = '', sort_type = '') {
    var form_data = new FormData(document.getElementById('filter-form'));
    if (sort_criteria == '') {
        var sc = $('.dropdown-menu li.active').find('a').attr('id');
        var ex = sc.split('-');
        if (ex[0] == 'project_template') {
            var sort_criteria = ex[0];
        } else if(ex[0] == 'pattern'){
            var sort_criteria ='prm.'+ex[0];
        } else if(ex[0]=='all_project_staffs'){
            var sort_criteria = ex[0];
        }else if(ex[0]=='status'){
            var sort_criteria = 'pm.' + ex[0];
        }
        else {
            var sort_criteria = 'pro.' + ex[0];
        }
    }
    if (sort_type == '') {
        var sort_type = 'ASC';
    }

    if (sort_criteria.indexOf('.') > -1)
    {
        var sp = sort_criteria.split(".");
        var activehyperlink = sp[1] + '-val';
    } else {
        var activehyperlink = sort_criteria + '-val';
    }
    form_data.append('sort_criteria', sort_criteria);
    form_data.append('sort_type', sort_type);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'project/sort_project_dashboard',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (action_result) {
//                    alert(action_result);return false;
            var data = JSON.parse(action_result);
            $("#action_dashboard_div").html(data.result);
            $(".dropdown-menu li").removeClass('active');
            $("#" + activehyperlink).parent('li').addClass('active');
            if (sort_type == 'ASC') {
                $(".sort_type_div #sort-desc").hide();
                $(".sort_type_div #sort-asc").css({display: 'inline-block'});
            } else {
                $(".sort_type_div #sort-asc").hide();
                $(".sort_type_div #sort-desc").css({display: 'inline-block'});
            }
            $(".sort_type_div").css({display: 'inline-block'});
            var text = $('.dropdown-menu li.active').find('a').text();
//                   alert(text);return false;
            var textval = 'Sort By : ' + text + ' <span class="caret"></span>';
            $("#sort-by-dropdown").html(textval);
            $("[data-toggle=popover]").popover();
            // $("#clear_filter").html('');
            // $("#clear_filter").hide();
            //$('#btn_clear_filter').hide();
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function projectFilter(select_year) {
    var category=$('#cat').val();
    var statusArray = category.split('-');
    var form_data = new FormData(document.getElementById('filter-form'));
//    form_data.append('year', select_year);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'project/project_filter/'+select_year+'/'+statusArray[0],
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result); return false;
            $("#action_dashboard_div").html(result);
            $("[data-toggle=popover]").popover();
            $("#clear_filter").show();
            $('#bookkeeping_btn_clear_filter').show();
            $('#tax_btn_clear_filter').show();
            $('#sales_btn_clear_filter').show();
            $('#annual_btn_clear_filter').show();
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function loadProjectDashboard(status = '', request = '', templateID = '', officeID = '', departmentID = '', filter_assign = '', filter_data = '', sos_value = '', sort_criteria = '', sort_type = '', client_type = '', client_id = '', clients = '', pageNumber = 0,template_cat_id='',month='',year='') {
    if(year==''){
        var year =$('#due_year').val();
    }
    if(month==''){
        var month=$("#due_month").val();
    }
    $.ajax({
        type: "POST",
        data: {
            status: status,
            request: request,
            template_id: templateID,
            office_id: officeID,
            department_id: departmentID,
            filter_assign: filter_assign,
            filter_data: filter_data,
            sos_value: sos_value,
            sort_criteria: sort_criteria,
            sort_type: sort_type,
            client_type: client_type,
            client_id: client_id,
            page_number: pageNumber,
            template_cat_id:template_cat_id,
            month:month,
            year:year
        },
        url: base_url + 'project/dashboard_ajax',
        success: function (project_result) {
//            console.log(project_result); return false;      
            if (project_result.trim() != '') {
                if (pageNumber == 1 || pageNumber == 0) {
                    $("#action_dashboard_div").html(project_result);
                    //$("a.filter-button span:contains('-')").html(0);
                    
                } else {
                    $(".ajaxdiv").append(project_result);
                    $("#action_dashboard_div").append(project_result);
                    $('.result-header').not(':first').remove();
                }
                if (pageNumber != 0) {
                    $('.load-more-btn').not(':last').remove();
                }
                $(".status-dropdown").val(status);
                $(".request-dropdown").val(request);
                $("[data-toggle=popover]").popover();
            }
            if (status != '' || status == '0') {
//                $("#clear_filter").html(filter_data + ' &nbsp; ');
//                $("#clear_filter").show();
                $("#project_apply_filter").show();
                $('#bookkeeping_btn_clear_filter').show();
                $("#project_hide_filter").show();
                $("#project_add_filter").hide();
            }
            else {
//                $("#clear_filter").html('');
//                $("#clear_filter").hide();
                $('#bookkeeping_btn_clear_filter').hide();
                $('#tax_btn_clear_filter').hide();
                $('#sales_btn_clear_filter').hide();
                $('#annual_btn_clear_filter').hide();
                $("#project_apply_filter").hide();
                $("#project_hide_filter").hide();
                $("#project_add_filter").show();
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
            jumpDiv();
            if (clients == 'clients') {
                $("#action_dashboard_div").find(".clearfix").remove();
            }
        }
    });
}
function add_project_sos() {
    var formData = new FormData(document.getElementById('sos_project_form'));
    var projectid = $("#sos_project_form #refid").val();
    var taskid = $("#sos_project_form #serviceid").val();
    formData.append('project_id', projectid);
    $.ajax({
        type: 'POST',
        url: base_url + 'home/addSos',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            swal({title: "Success!", text: "Successfully Added!", type: "success"}, function () {
                //if(result!='0'){
                var prevsoscount = $("#projectsoscount-" + projectid + '-' + taskid).text();
                var soscount = parseInt(prevsoscount) + parseInt(1);
                $("#projectsoscount-" + projectid + '-' + taskid).text(soscount);
                //}
                $("#projectsoscount-" + projectid + '-' + taskid).removeClass('label label-primary').addClass('label label-danger');
                //$("#soscount-"+projectid).html(soscount);
                $("#projectsoscount-" + projectid + '-' + taskid).html('<i class="fa fa-bell"></i>');
                document.getElementById("sos_project_form").reset();
                var prevbymecount = $("#sos-byme").html();
                if (result == 0) {
                    var newbymecount = parseInt(prevbymecount) + 1;
                    $("#sos-byme").html(newbymecount);
                }
                //$(".notification-btn .label-byme").html(newbymecount);
//                        $("#action"+projectid).find(".priority").find('.m-t-5').remove();
//                        $("#action"+projectid).find(".priority").append('<img src="'+base_url+'/assets/img/badge_sos_priority.png" class="m-t-5"/>');
                $('#showSos').modal('hide');
            });
        },
        beforeSend: function () {
            $("#save_sos").prop('disabled', true).html('Processing...');
            openLoading();
        },
        complete: function (msg) {
            $("#save_sos").removeAttr('disabled').html('Save SOS');
            closeLoading();
        }
    });
}
function tetmplate_task_delete_modal(task_id, template_id) {
    $.ajax({
        type: "POST",
        url: base_url + 'administration/template/delete_template_task_modal',
        dataType: "html",
        data: {task_id: task_id, template_id: template_id},
        success: function (result) {
//            alert(result);
            if (result.trim() != "-1") {
                swal({
                    title: "Success!",
                    text: "Project Task Successfully Deleted!",
                    type: "success"
                }, function () {
                    $("#task_list").html(result);
                    $("#taskModal").modal('hide');
                }
                );
            } else {
                swal("ERROR!", "Unable To Delete Project Task.", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function delete_project(project_id, project_template_id) {
    $.ajax({
        type: "POST",
        url: base_url + 'project/delete_project/',
        dataType: "html",
        data: {project_id: project_id, project_template_id: project_template_id},
        success: function (result) {
//            alert(result);return false;
            if (result.trim() != "-1") {
                swal({
                    title: "Success!",
                    text: "Project Successfully Deleted!",
                    type: "success"
                }, function () {
                    loadProjectDashboard();
                }
                );
            } else {
                swal("ERROR!", "Unable To Delete Project.", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function taskDashboard() {
    goURL(base_url + 'task');
}

function load_project_tasks(id, created_at, dueDate) {
    if (!$('#collapse' + id).hasClass('in')) {
        $('#collapse' + id).html('<div class="text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>');

        $.ajax({
            type: "POST",
            url: base_url + 'project/load_project_tasks',
            dataType: "html",
            data: {id: id, created_at: created_at, dueDate: dueDate},
            success: function (result) {
                if (result.trim() != '') {
                    $("#collapse" + id).html(result.trim());
                }
            }
        });
    }
}
var saveInputForms = function () {
    if (!requiredValidation('project_input_form')) {
        return false;
    }
    $("#gross_sales").attr('disabled', false);
    $("#sales_tax_collect").attr('disabled', false);
    $("#collection_allowance").attr('disabled', false);
    $("#total_due").attr('disabled', false);
    var userid = $("#user_id").val();
    var user_type = $("#user_type").val();
    var total_time=$("#total_time").text();
//    var input_form_type=$("#input_form_type").val();
    var form_data = new FormData(document.getElementById('project_input_form'));
    form_data.append('total_time', total_time);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'task/save_project_input_form',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result);return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'project');
            } else {
                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function deleteTaskNote(divID, noteID, relatedTableID) {
    $.ajax({
        type: 'POST',
        url: base_url + 'home/delete_note',
        data: {
            note_id: noteID,
            related_table_id: relatedTableID
        }
    });
    $("#" + divID).remove();
}
function save_task_account(section='') {

//update_financial_account_by_date
    if (!requiredValidation('form_accounts')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('form_accounts'));
    var company_id = $("#company_id").val();
    var order_id = $("#editval").val();
    var client_id = $("#client_id").val();
    var is_client = $("#section").val();

    form_data.append('section', section);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/accounting_services/save_account',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Financial account successfully saved!", type: "success"}, function () {
                    $('#accounts-form').modal('hide');
                    if (is_client == 'client') {
                        goURL(base_url+'action/home/view_business/'+client_id+'/'+company_id);    
                    } else {
                        get_financial_account_list(company_id, section, order_id);    
                    }
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable to save financial account", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function inactive_project_template(project_id) {
    $.ajax({
        type: "POST",
        data: {id : project_id},
        url: base_url + 'administration/template/inactive_project_template',
        dataType: "html",
        success: function (result) {
            if (result != 0) {
                swal({
                    title: "Success!",
                    text: "Successfully Inactivated!",
                    type: "success"
                }, function () {
                    goURL(base_url + 'projects/template');
                });
            } else {
                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });        
}
function delete_project_template(project_id) {
    $.ajax({
        type: "POST",
        data: {id : project_id},
        url: base_url + 'administration/template/delete_project_template',
        dataType: "html",
        success: function (result) {
            if (result != 0) {
                swal({
                    title: "Success!",
                    text: "Template deleted successfully!",
                    type: "success"
                }, function () {
                    goURL(base_url + 'projects/template');
                });
            } else {
                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });        
}
function get_pattern_detais(template_id,project_id='',section=''){
    $.ajax({
        type: "POST",
        data: {id : template_id,project_id:project_id,section:section},
        url: base_url + 'project/get_template_pattern_details',
        cache:false,
        success: function (result) {
//            alert(result);return false;
            if (result != '0') {
                $("#template_recurrence").html(result);
                $("#template_recurrence").show();
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    }); 
}
function delete_recoded_time(record_id,bank_id){
//    alert(record_id);
    $.ajax({
        type: "POST",
        data: {record_id : record_id,bank_id:bank_id},
        url: base_url + 'task/delete_bookkeeping_timer_record',
        cache:false,
        success: function (result) {
//            alert(result);return false;
            if (result) {
                $("#load_record_time-" + bank_id).hide();
                $("#timer_result-" + bank_id).html(result);
            }
        },
    });
}
function change_bookkeeping_finance_input_status(id = '', status = '') {
        openModal('changetrackinginner');
        var txt = 'Tracking Account #' + id;
        $("#changetrackinginner .modal-title").html(txt);
        if (status == 0) {
            $("#changetrackinginner #rad0").prop('checked', true);
            $("#changetrackinginner #rad1").prop('checked', false);
            $("#changetrackinginner #rad2").prop('checked', false);
        } else if (status == 1) {
            $("#changetrackinginner #rad1").prop('checked', true);
            $("#changetrackinginner #rad0").prop('checked', false).attr('disabled', true);
            $("#changetrackinginner #rad2").prop('checked', false);
        } else {
            $("#changetrackinginner #rad2").prop('checked', true);
            $("#changetrackinginner #rad1").prop('checked', false);
            $("#changetrackinginner #rad0").prop('checked', false).attr('disabled', true);
        }
        $("#changetrackinginner #input_id").val(id);
    }
    function updateBookkeeping_input1Statusinner() {
        var statusval = $('#changetrackinginner input:radio[name=radio]:checked').val();
        var id = $("#input_id").val();
        var base_url = $('#baseurl').val();
        $.ajax({
            type: "POST",
            data: {statusval: statusval, id: id},
            url: base_url + 'task/update_project_bookkeeping_input_form_status',
            dataType: "html",
            success: function (result) {
//                alert(result);return false;
//                var res = JSON.parse(result.trim());
                if (result == '0') {
                    var tracking = 'Incomplete';
                    var trk_class = 'label label-danger';
                } else if (result == 1) {
                    var tracking = 'Complete';
                    var trk_class = 'label label-success';
                } else {
                    var tracking = 'Not Required';
                    var trk_class = 'label label-secondary';
                }
                $("#trackinner-" + id).removeClass().addClass(trk_class);
                $("#trackinner-" + id).parent('a').removeAttr('onclick');
                $("#trackinner-" + id).parent('a').attr('onclick', 'change_bookkeeping_finance_input_status(' + id + ',' + statusval + ');');
                $("#trackinner-" + id).html(tracking);
                if (result.trim() != 0) {
                    $("#changetrackinginner").modal('hide');
                }
            }
        });
    }
    function save_transaction(id, transaction_val) {
        $.ajax({
            type: "POST",
            data: {transaction_val: transaction_val, id: id},
            url: base_url + 'task/update_project_bookkeeping_transaction_val',
            dataType: "html",
            success: function (result) {
//                
            }
        });
    }
    function save_uncategorized_item(id, uncategorized_item) {
        $.ajax({
            type: "POST",
            data: {uncategorized_item: uncategorized_item, id: id},
            url: base_url + 'task/update_project_bookkeeping_uncategorized_item',
            dataType: "html",
            success: function (result) {

            }
        });
    }
    function need_clarification(task_id,client_type,client_id,project_id){
        var action_message= prompt("Need Clarification?");
        $.ajax({
            type: "POST",
            data: {task_id: task_id, client_type: client_type,client_id:client_id,project_id:project_id,action_message:action_message},
            url: base_url + 'task/add_action_for_bookkeeping_need_clarification',
            dataType: "html",
            success: function (result) {
                swal("Clarification done successfully.");
            }
        });
    }