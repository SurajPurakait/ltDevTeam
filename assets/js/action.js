var base_url = document.getElementById('base_url').value;

function get_action_office(select_office = "", select_staffs = "", assign_myself = "", disabled = "") {
//    alert('dfdf'+disabled);return false;
    var department_id = $("#department option:selected").val();
    if (department_id != '') {
        var staff_type = $("#staff_type").val();
        var disable_field = $("#disable_field").val();
        $.ajax({
            type: "POST",
            data: {
                department_id: department_id,
                select_office: select_office,
                disabled: disabled
            },
            url: base_url + 'action/home/get_action_office_ajax',
            dataType: "html",
            success: function (result) {
                $("#office_div").html(result);
                if (parseInt(department_id) != 2 && parseInt(staff_type) == 1) {
                    $("#office_div").hide();
                    //$("#office").attr("disabled", "disabled");
                } else if (parseInt(department_id) != 2 && parseInt(staff_type) == 2) {
                    $("#office_div").hide();
                    //$("#office").attr("disabled", "disabled");
                } else if (parseInt(department_id) != 2 && parseInt(staff_type) == 3) {
                    $("#office_div").hide();
                    //$("#office").attr("disabled", "disabled");
                } else if (disable_field == "y") {
                    $("#office").attr("disabled", "disabled");
                } else {
                    $("#office_div").show();
                    // if ($("#office").attr("disabled")) {
                    //     $("#office").removeAttr("disabled");
                    // }
                }
                get_action_staff(select_staffs, assign_myself, disabled);
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    } else {
        $("#office_div").hide();
        $("#staff_div").hide();
}
}

function get_action_office_for_news(select_office = "", select_staffs = "", assign_myself = "") {
    var department_id = 2;
    
    if (department_id != '') {
        var staff_type = $("#staff_type").val();
        var disable_field = $("#disable_field").val();
        $.ajax({
            type: "POST",
            data: {
                department_id: department_id,
                select_office: select_office
            },
            url: base_url + 'action/home/get_action_office_ajax',
            dataType: "html",
            success: function (result) {
                $("#office_div").html(result);
                if (parseInt(department_id) != 2 && parseInt(staff_type) == 1) {
                    $("#office_div").hide();
                    //$("#office").attr("disabled", "disabled");
                } else if (parseInt(department_id) != 2 && parseInt(staff_type) == 2) {
                    $("#office_div").hide();
                    //$("#office").attr("disabled", "disabled");
                } else if (parseInt(department_id) != 2 && parseInt(staff_type) == 3) {
                    $("#office_div").hide();
                    //$("#office").attr("disabled", "disabled");
                } else if (disable_field == "y") {
                    $("#office").attr("disabled", "disabled");
                } else {
                    $("#office_div").show();
                    if ($("#office").attr("disabled")) {
                        $("#office").removeAttr("disabled");
                    }
                }
                get_action_staff_news(select_staffs, assign_myself);
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    } else {
        $("#office_div").hide();
        $("#staff_div").hide();
}
}

function hide_ofc_staff_div_in_editcase(assign_myself) {
    if (assign_myself != 0) {
        $("#is_chk_mytask").prop('checked', true);
        $("#department").removeAttr("required");
        $("#office").removeAttr("required");
        $(".spanclass").html('');
        $(".dept_div").hide();
        $("#office_div").hide();
        $("#staff_div").hide();
    } else {
        var dept = $("#department option:selected").val();
        if (dept == 2) {
            $("#office_div").show();
        }
        $("#is_chk_mytask").prop('checked', false);
        $("#department").attr("required", "required");
        $("#office").attr("required", "required");
        $(".spanclass").html('*');
        $(".dept_div").show();
        $("#staff_div").show();
    }
}

function get_action_staff(select_staffs, assign_myself, disabled) {
//    alert(disabled);return false;
    var department_id = $("#department option:selected").val();
    var office_id = $("#office option:selected").val();
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
                disabled: disabled
            },
            url: base_url + 'action/home/get_action_staff_ajax',
            dataType: "html",
            success: function (result) {
                //alert(result);
                $("#staff_div").html(result);
                $("#staff_div").show();
                if (disable_field == "y") {
//                    $(".is_all").attr("disabled", "");
//                    $("#staff").attr("disabled", "");
                    $("#staff-hidden").val(1);
                    $("#staff").removeAttr('required');
                } else {
                    // if ($("#staff").attr("disabled")) {
                    //     $("#staff").removeAttr("disabled");
                    // }
                    // if ($(".is_all").attr("disabled")) {
                    //     $(".is_all").removeAttr("disabled");
                    // }
                }
                if (assign_myself != '') {
                    hide_ofc_staff_div_in_editcase(assign_myself);
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
        $("#staff_div").hide();
    }
}

function get_action_staff_news(select_staffs, assign_myself) {
    var department_id = 2;
    var office_id = $("#department option:selected").val();
    var ismyself = $(".ismyself").val();
    if (department_id != '' && office_id != '') {
        
        var disable_field = $("#disable_field").val();
        $.ajax({
            type: "POST",
            data: {
                department_id: department_id,
                office_id: office_id,
                select_staffs: select_staffs,
                ismyself: ismyself
            },
            url: base_url + 'action/home/get_action_staff_ajax',
            dataType: "html",
            success: function (result) {
                $("#staff_div").html(result);
                $("#staff_div").show();
                if (disable_field == "y") {
                    $(".is_all").attr("disabled", "disabled");
                    $("#staff").attr("disabled", "disabled");
                    $("#staff-hidden").val(1);
                    $("#staff").removeAttr('required');
                } else {
                    if ($("#staff").attr("disabled")) {
                        $("#staff").removeAttr("disabled");
                    }
                    if ($(".is_all").attr("disabled")) {
                        $(".is_all").removeAttr("disabled");
                    }
                }
                if (assign_myself != '') {
                    hide_ofc_staff_div_in_editcase(assign_myself);
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
        $("#staff_div").hide();
    }
}

function request_create_action() {
    if (!requiredValidation('save_action')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("save_action"));
    $.ajax({
        type: "POST",
        data: form_data, //add_new_action
        url: base_url + 'action/home/request_create_action',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Action", "error");
            } else if (result) {
                swal({
                    title: "Success!",
                    text: "Action Successfully Added!",
                    type: "success"
                }, function () {
                    goURL(base_url + 'action/home/view_action/'+result);
                });
            }
        },
        beforeSend: function () {
            $(".save_btn").prop('disabled', true).html('Processing...');
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });

}

function request_edit_action() {
    if (!requiredValidation('edit_action')) {
        return false;
    }
    if ($("#office").attr("disabled")) {
        $("#office").removeAttr("disabled");
    }
    var action_id = $("#edit_val").val();
    if ($("#staff").attr("disabled")) {
        $("#staff").removeAttr("disabled");
    }
    if ($("#department").attr("disabled")) {
        $("#department").removeAttr("disabled");
    }
    if ($(".is_all").attr("disabled")) {
        $(".is_all").removeAttr("disabled");
    }
    if ($("#due_date").attr("disabled")) {
        $("#due_date").removeAttr("disabled");
    }
    if ($("#upload_file").attr("disabled")) {
        $("#upload_file").removeAttr("disabled");
    }
    
    var form_data = new FormData(document.getElementById("edit_action"));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'action/home/request_edit_action/' + action_id,
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({
                    title: "Success!",
                    text: "Action Successfully Updated!",
                    type: "success"
                }, function () {
                    goURL(base_url + 'action/home/view_action/' + action_id);
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Update Action", "error");
            }
        },
        beforeSend: function () {
            $(".save_btn").prop('disabled', true).html('Processing...');
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function action_dashboard_ajax(type, status) {
    $.ajax({
        type: "POST",
        data: {
            type: type
        },
        url: base_url + 'action/home/get_action_dashboard',
        success: function (result) {
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });







    if (type != 'main') {
        if (typeof type == 'number' && typeof status == 'number') {
            if (type == 0) {
                var typeval = 'Requested by me';
            } else if (type == 1) {
                var typeval = 'Requested to me';
            }
            if (status == 0) {
                var statusval = 'New';
            } else if (status == 1) {
                var statusval = 'Started';
            } else if (status == 2) {
                var statusval = 'Completed';
            }
        }
        $("#clear_filter span").html('');
        $("#clear_filter span").html(typeval + ' ' + statusval);
        $("#clear_filter").show();
    } else {
        $("#clear_filter span").html('');
        $("#clear_filter").hide();
    }

    $.get(base_url + "action/home/load_data/" + type + "/" + status, function (data) {
        //alert(data);
        $("#load_data").html(data);
    });

    $.get(base_url + "action/home/load_count_data", function (data) {
        var values = JSON.parse(data);
        //alert(JSON.stringify(values));
        if (values["requested_by_me_new"] == null) {
            $("#requested_by_me_new").html(0);
        } else {
            $("#requested_by_me_new").html(values["requested_by_me_new"]);
        }
        if (values["requested_by_me_started"] == null) {
            $("#requested_by_me_started").html(0);
        } else {
            $("#requested_by_me_started").html(values["requested_by_me_started"]);
        }
        if (values["requested_by_me_completed"] == null) {
            $("#requested_by_me_completed").html(0);
        } else {
            $("#requested_by_me_completed").html(values["requested_by_me_completed"]);
        }
        if (values["requested_to_me_new"] == null) {
            $("#requested_to_me_new").html(0);
        } else {
            $("#requested_to_me_new").html(values["requested_to_me_new"]);
        }
        if (values["requested_to_me_started"] == null) {
            $("#requested_to_me_started").html(0);
        } else {
            $("#requested_to_me_started").html(values["requested_to_me_started"]);
        }
        if (values["requested_to_me_completed"] == null) {
            $("#requested_to_me_completed").html(0);
        } else {
            $("#requested_to_me_completed").html(values["requested_to_me_completed"]);
        }
    });
}

function cancel_action() {
    goURL('../home');
}

function cancel_edit_action(id) {
    goURL(base_url+'/action/home/view_action/'+id);
}

function request_create_business() {
    if (!requiredValidation('form_create_new_company')) {
        return false;
    }

    var company_type = $("#type option:selected").val();

//    if (company_type == '1' || company_type == '2' || company_type == '3' || company_type == '4' || company_type == '5') {

    var total_percentage = $("#owner_percentage_total").val();
    if (total_percentage != '100.00') {
        swal("Error", "Percentage of all partners should equal to 100%", "error");
        return false;
    }
//    }

    company_type_enable();

    var form_data = new FormData(document.getElementById('form_create_new_company'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'action/home/request_create_business',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
           // alert(result);
           // return false;
            // console.log("Result: " + result);
            if (result != 0) {
                swal({
                    title: "Success!",
                    text: "Successfully saved!",
                    type: "success"
                }, function () {
                    goURL(base_url + 'action/home/business_dashboard');
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
function saveIndividual(lead_id='',is_admin = '') {
    if (!requiredValidation('form_title')) {
        return false;
    }
    if (lead_id != '') {
        $('#first_name').removeAttr("disabled");
        $('#last_name').removeAttr("disabled");
    }
    if (is_admin != '') {
        $('#practice_id').removeAttr("disabled");
    }
//    var num = document.getElementById("per_id").value;
//    if (isNaN(num)) {
//        $("#per_id").next('.errorMessage').html('Please, enter numeric value');
//        return false;
//    } else {
//        $("#per_id").next('.errorMessage').html("");
//    }

    var reference = $("#reference").val();
    var reference_id = $("#reference_id").val();
    var company_id = $("#company_id").val();
    var formData = new FormData(document.getElementById('form_title'));
    var individual_id = $("#individual_id").val();
    if (lead_id != '') {
       formData.append('lead_id', lead_id); 
    }

    $.ajax({
        type: 'POST',
        url: base_url + 'action/home/save_individualData',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            if (result == 1) {
            //clearCacheFormFields('form_title');
                if (lead_id != '') {
                    swal({
                        title: "Success!",
                        text: "Successfully assigned as Client!",
                        type: "success"
                    }, function () {
                        opener.location.reload();
                        window.close();
                    });
                } else {
                    swal({
                        title: "Success!",
                        text: "Successfully saved!",
                        type: "success"
                    }, function () {
                        goURL(base_url + 'action/home/view_individual/' + individual_id);
                    });    
                }
            } else if (result == 2) {
                swal("ERROR!", "If you choose LLC, total share should be always 100%", "error");
            } else if (result == 0) {
                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
            }else if (result == 3) {
                swal("ERROR!", "Individual already exists", "error");
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
function get_county(county_id = '', select_state = '') {
    var state = $("#state option:selected").val();
    if (state != '') {
        $.ajax({
            type: "POST",
            data: {
                state_id: select_state,
                select_county: county_id
            },
            url: base_url + 'action/home/get_county',
            dataType: "html",
            success: function (result) {
                if (result != '') {
                    $("#sted_county").html(result);
                    $("#sted_county").show();
                } else {
                    $("#sted_county").hide();
                }
                get_county_rate(county_id);
            }
        });
    } else {
        $("#sted_county").hide();
}
}

function get_county_rate(county_id = '') {
    var county_id = $("#county option:selected").val();
    if (county_id != '') {
        $.ajax({
            type: "POST",
            data: {
                county_id: county_id
            },
            url: base_url + 'action/home/get_county_rate',
            dataType: "html",
            success: function (result) {
                if (result != '') {
                    $("#county_rate").html(result);
                    $("#county_rate").show();
                } else {
                    $("#county_rate").hide();
                }
            }
        });
    } else {
        $("#county_rate").hide();
}
}

function sales_gross_collect() {
    var exempt_sales = parseFloat($("#exempt_sales").val());
    var taxable_sales = parseFloat($("#taxable_sales").val());
    var sales_tax_rate = parseFloat($("#rate").val());

    var gross_sales = exempt_sales + taxable_sales;
    var sales_tax_collect = sales_tax_rate * taxable_sales;
    var collection_allowance = sales_tax_collect * (2.5 / 100);
    if (collection_allowance > 30) {
        var total_due = sales_tax_collect - 30;
    } else {
        var total_due = sales_tax_collect - collection_allowance;
    }

    if (collection_allowance > 30) {
        $("#coll_err").html("Collection allowance maxes out at 30");
        collection_allowance = 30;
    } else {
        $("#coll_err").html("");
    }
    if (isNaN(gross_sales)) {
        $("#gross_sales").val('');
        $("#sales_tax_collect").val('');
        $("#collection_allowance").val('');
        $("#total_due").val('');

    } else {
        $("#gross_sales").val(gross_sales.toFixed(2));
        $("#sales_tax_collect").val(sales_tax_collect.toFixed(2));
        $("#collection_allowance").val(collection_allowance.toFixed(2));
        $("#total_due").val(total_due.toFixed(2));
    }
}
function saveSalesProcess() {
    if (!requiredValidation('save_sales_process')) {
        return false;
    }
    $("#gross_sales").attr('disabled', false);
    $("#sales_tax_collect").attr('disabled', false);
    $("#collection_allowance").attr('disabled', false);
    $("#total_due").attr('disabled', false);
    var userid = $("#user_id").val();
    var user_type = $("#user_type").val();
    var formData = new FormData(document.getElementById('save_sales_process'));

    $.ajax({
        type: 'POST',
        url: base_url + 'action/home/save_sales_tax_process',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            if (result == 1) {
//                clearCacheFormFields('form_title');
                swal({
                    title: "Success!",
                    text: "Successfully saved!",
                    type: "success"
                }, function () {
                    goURL(base_url + 'action/home/sales_tax_process');
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

function updateSalesProcess() {
    if (!requiredValidation('edit_sales_process')) {
        return false;
    }

    $("#gross_sales").attr('disabled', false);
    $("#sales_tax_collect").attr('disabled', false);
    $("#collection_allowance").attr('disabled', false);
    $("#total_due").attr('disabled', false);

    var userid = $("#user_id").val();
    var user_type = $("#user_type").val();
    var sales_processId = $("#edit_process").val();
    var formData = new FormData(document.getElementById('edit_sales_process'));

    $.ajax({
        type: 'POST',
        url: base_url + 'action/home/update_sales_tax_process/' + sales_processId,
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            if (result == 1) {
//                clearCacheFormFields('form_title');
                swal({
                    title: "Success!",
                    text: "Successfully update!",
                    type: "success"
                }, function () {
                    goURL(base_url + 'action/home/sales_tax_process');
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


function reset_all_fields() {
    $("#state").val('');
    $("#sted_county").hide();
    $("#rate").val('');
    $("#exempt_sales").val('');
    $("#taxable_sales").val('');
    $("#gross_sales").val('');
    $("#sales_tax_collect").val('');
    $("#collection_allowance").val('');
    $("#total_due").val('');
    $("#period_time").empty();
    $("#period_time").append('<option value="">Select</option>');
}

function assignAction(action_id, staff_id) {
    swal({
        title: 'Are you sure?',
        text: "You want to " + (staff_id == 0 ? 'un' : '') + "assign the action!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, '+ (staff_id == 0 ? 'un' : '') +'assign!'
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                data: {
                    action_id: action_id,
                    staff_id: staff_id
                },
                url: base_url + 'action/home/assign_action',
                cache: false,
                success: function (result) {
                    if (result != 0) {
                        swal("Success!", "Successfully " + (staff_id == 0 ? 'un' : '') + "assigned!", "success");
                        if (staff_id == '') {
                            goURL(base_url + 'action/home/view_action/' + action_id);
                        } else {
                            goURL(base_url + 'action/home');
                        }
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
    });
}
function loadActionDashboard(status, request, priority, officeID, departmentID, filter_assign) {
//    if (request != '') {
//        activeShortColumn(request, short_column);
//    } else {
//        $(".short-value-dropdown").hide();
//    }
    $.ajax({
        type: "POST",
        data: {
            status: status,
            request: request,
            priority: priority,
            office_id: officeID,
            department_id: departmentID,
            filter_assign: filter_assign
        },
        url: base_url + 'action/home/dashboard_ajax',
        success: function (action_result) {
            //console.log("Result: " + action_result); return false;
            var data = JSON.parse(action_result);
//            if (short_column != '') {
//                $(".short-value-dropdown").html(data.column_value).show();
//            } else {
//                $(".short-value-dropdown").hide();
//            }
            $(".status-dropdown").val(status);
            $(".request-dropdown").val(request);
            $("#action_dashboard_div").html(data.result);
            $("[data-toggle=popover]").popover();
            var filter_result = '';
            if (request == 'byme') {
                filter_result = 'By Me';
            } else if (request == 'tome') {
                filter_result = 'To Me';
            } else if (request == 'byother') {
                filter_result = 'By Other';
            } else if (request == 'mytask') {
                filter_result = 'My Task';
            }
            if (filter_result != '') {
                var status_arr = ['New', 'Started', 'Resolved', 'Completed', 'Not Completed', 'All'];
                if (status != '') {
                    filter_result += ' - ' + status_arr[parseInt(status)];
                } else if (status == '0') {
                    filter_result += ' - ' + status_arr[0];
                }
                $("#clear_filter").html(filter_result + ' &nbsp; ');
                $("#clear_filter").show();
                $('#btn_clear_filter').show();
            } else {
                $("#clear_filter").html('');
                $("#clear_filter").hide();
                $('#btn_clear_filter').hide();
            }

            if(request=='byme_tome_task'){
                $(".variable-dropdown").val('');
                $(".condition-dropdown").val('');
                $(".criteria-dropdown").val('');
                $('.criteria-dropdown').empty().append('<option value="">All Criteria</option>'); 
                $(".criteria-dropdown").trigger("chosen:updated");
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
            jumpDiv();
        }
    });
}

function activeShortColumn(request, short_column) {
    var resultHTML = '<option value="">Sort By</option>';
    if (request == 'byme') {     // byme
        resultHTML += '<option value="department">Department</option>';
        resultHTML += '<option value="staff">Staff</option>';
        resultHTML += '<option value="office">Office</option>';
    } else {    // tome, byother, mytask
        resultHTML += '<option value="department">Department</option>';
        resultHTML += '<option value="staff">Staff</option>';
        resultHTML += '<option value="office">Office</option>';
    }
    $(".short-column-dropdown").html(resultHTML).show();
    $(".short-column-dropdown").val(short_column);
}


function noteNotificationModal(relatedTableID, notificationReference, bywhom = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/note_notification',
        data: {
            related_table_id: relatedTableID,
            notification_reference: notificationReference,
            bywhom: bywhom
        },
        success: function (result) {
            if (result != 0) {
                $('#notification').html(result).modal({
                    backdrop: 'static',
                    keyboard: false
                });
                if (bywhom == 'tome') {
                    $(".label-tome").html('0');
                } else {
                    $(".label-byme").html('0');
                }
            } else {
                swal("ERROR!", "Note notification not found!", "error");
            }
        }
    });
}
function actionFilter() {
    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'action/home/action_filter',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result); return false;
            $("#action_dashboard_div").html(result);
            $("[data-toggle=popover]").popover();
            $("#clear_filter").html('');
            $("#clear_filter").show();
            $('#btn_clear_filter').show();
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function loadSalesTaxDashboard(monthYear, requestType, status, isFilter, isInsert) {
    var filterRequestValue = '';
    var filterStatusValue = '';
    if (requestType == 'others') {
        filterRequestValue = $('.others_request_type_title').html();
    } else if (requestType == 'my') {
        filterRequestValue = $('.my_request_type_title').html();
    }
    if (status === 0) {
        filterStatusValue = 'New';
    } else if (status === 1) {
        filterStatusValue = 'Started';
    } else if (status === 2) {
        filterStatusValue = 'Completed';
    }
    var ajaxData = new FormData(document.getElementById('filter-form'));
    ajaxData.append('month_year', monthYear);
    ajaxData.append('request_type', requestType);
    ajaxData.append('status', status);
    ajaxData.append('is_filter', isFilter);
    ajaxData.append('is_insert', isInsert);
    $.ajax({
        type: "POST",
        url: base_url + 'action/home/sales_tax_dashboard_ajax',
        data: ajaxData,
        processData: false,
        contentType: false,
        success: function (result) {
//            console.log(result);
            var decode_result = JSON.parse(result);
            $("#sales_tax_process_dashboard_div").html(decode_result.sales_tax_data);
            $("#search_month b").html(decode_result.search_month);
            var summary_count = decode_result.summary_count;
            summary_count.forEach(function (summary) {
                var element = summary.split("-");
                $("#" + element[0]).html(element[1]);
            });
            if (status !== '') {
                $("#clear_filter").show();
                $("#clear_filter span").html('');
                $("#clear_filter span").html(filterRequestValue + ' - ' + filterStatusValue);
            } else {
                $("#clear_filter span").html('');
                $("#clear_filter").hide();
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

function insert_excel_form(type) {
    if(type=='b'){
        var form_id = 'excel-form';
        var url = 'action/home/insert_import_clients';
    }else{
        var form_id = 'excel-form-individual';
        var url = 'action/home/insert_import_individuals';
    }
    if (!requiredValidation(form_id)) {
        return false;
    }

    var formData = new FormData(document.getElementById(form_id));

    swal({
        title: "Are you sure?",
        text: "You want to import!!",
        type: "info",
        showCancelButton: true,
        confirmButtonClass: "btn-info",
        confirmButtonText: "Yes, import it!",
        closeOnConfirm: false
    },
            function () {
                swal.close();
                $.ajax({
                type: 'POST',
                url: base_url + url,
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    //console.log(result); return false;
                    if (result == 1) {
                        swal({
                            title: "Success!",
                            text: "Successfully imported!",
                            type: "success"
                        });

                    } else {
                        swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
                    }
                },
                beforeSend: function () {
                    $(".save_btn").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $(".save_btn").removeAttr('disabled').html('Save Changes');
                    closeLoading();
                }
            });
            });
}

function delete_individual(id,page=''){
    $.get(base_url + "action/home/check_if_individual_associated/" + id, function (result) {
        if (result != 0) {
            swal({
                title: "Error",
                text: "Individual Is Associated. Can Not Delete!!",
                type: "error"
            });
        } else {
            swal({
                title: "Are you sure want to delete?",
                text: "Your will not be able to recover this individual!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/action/home/delete_individual',
                    data: {
                        id: id,
                        page:page
                    },
                    success: function (result) {
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "Individual been deleted successfully!",
                                "type": "success"
                            }, function () {
                                if(page=='view-page'){
                                  window.top.close(); 
                              }else{
                                  goURL(base_url + 'action/home/individual_dashboard');  
                              }
                            });
                        } else {
                            swal("ERROR!", "Unable to delete this individual", "error");
                        }
                    }
                });
            });
          }
    });
}

function inactive_individual(id){
    swal({
        title: "Are you sure want to inactive?",
        text: "Your may later will be able to recover this individual!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, inactive it!",
        closeOnConfirm: false
    },
    function () {
        $.ajax({
            type: 'POST',
            url: base_url + '/action/home/delete_individual',
            data: {
                id: id
            },
            success: function (result) {
                if (result == "1") {
                    swal({
                        title: "Success!",
                        "text": "Individual been inactive successfully!",
                        "type": "success"
                    }, function () {
                        goURL(base_url + 'action/home/individual_dashboard');
                    });
                } else {
                    swal("ERROR!", "Unable to inactive this individual", "error");
                }
            }
        });
    });
}
function active_individual(id){
    swal({
        title: "Are you sure want to active?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes, Active it!",
        closeOnConfirm: false
    },
    function () {
        $.ajax({
            type: 'POST',
            url: base_url + '/action/home/activate_individual',
            data: {
                id: id
            },
            success: function (result) {
                if (result == "1") {
                    swal({
                        title: "Success!",
                        "text": "Individual been active successfully!",
                        "type": "success"
                    }, function () {
                        goURL(base_url + 'action/home/individual_dashboard');
                    });
                } else {
                    swal("ERROR!", "Unable to inactive this individual", "error");
                }
            }
        });
    });
}

function inactive_business(reference_id,id){
    swal({
        title: "Are you sure want to inactive?",
        text: "Your may later will be able to recover this business!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, inactive it!",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                            type: 'POST',
                            url: base_url + '/action/home/delete_business',
                            data: {
                                id: id,
                                reference_id: reference_id
                            },
                            success: function (result) {
                                if (result == "1") {
                                    swal({
                                        title: "Success!",
                                        "text": "Business been inactive successfully!",
                                        "type": "success"
                                    }, function () {
                                        goURL(base_url + 'action/home/business_dashboard');                                         
                                    });
                                } else {
                                    swal("ERROR!", "Unable to inactive this business", "error");
                                }
                            }
                        });
            });
}
function active_business(reference_id,id){
    swal({
        title: "Are you sure want to active?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes, Active it!",
        closeOnConfirm: false
    },
    function () {
        $.ajax({
            type: 'POST',
            url: base_url + '/action/home/activate_business',
            data: {
                id: id,
                reference_id: reference_id
            },
            success: function (result) {
                if (result == "1") {
                    swal({
                        title: "Success!",
                        "text": "Business been active successfully!",
                        "type": "success"
                    }, function () {
                        goURL(base_url + 'action/home/business_dashboard');                                         
                    });
                } else {
                    swal("ERROR!", "Unable to inactive this business", "error");
                }
            }
        });
    });
}

function delete_business(reference_id,id,page=''){
    $.get(base_url + "action/home/check_if_business_associated/" + reference_id, function (result) {
        if (result != 0) {
            swal({
                title: "Error",
                text: "Business Is Associated. Can Not Delete!!",
                type: "error"
            });
        } else {
            swal({
                title: "Are you sure want to delete?",
                text: "Your will not be able to recover this business!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/action/home/delete_business',
                    data: {
                        id: id,
                        reference_id: reference_id,
                        page:page
                    },
                    success: function (result) {
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "Business been deleted successfully!",
                                "type": "success"
                            }, function () {
                                if(page=='view-page'){
                                  window.top.close(); 
                              }else{
                                  goURL(base_url + 'action/home/business_dashboard');  
                              }                                        
                            });
                        } else {
                            swal("ERROR!", "Unable to delete this business", "error");
                        }
                    }
                });
            });
        }
    });
}


function sort_dashboard(sort_criteria='',sort_type=''){
    // alert("Hello");return false;
    var form_data = new FormData(document.getElementById('filter-form'));
    if(sort_criteria==''){
        var sc = $('.dropdown-menu li.active').find('a').attr('id');
        // alert(sc);return false;
        var ex = sc.split('-');
        if(ex[0]=='user_name'){
            var sort_criteria = ex[0];
        }else{
            var sort_criteria = 'act.'+ex[0];
        }      
    }
    if(sort_type==''){
      var sort_type = 'ASC';  
    }
    
    if (sort_criteria.indexOf('.') > -1)
    {
      var sp = sort_criteria.split(".");
      var activehyperlink = sp[1]+'-val';  
    }else{
        var activehyperlink = sort_criteria+'-val';
    }
    form_data.append('sort_criteria',sort_criteria);
    form_data.append('sort_type',sort_type);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'action/home/sort_dashboard',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (action_result) {
            //alert(action_result);
            var data = JSON.parse(action_result);   
            $("#action_dashboard_div").html(data.result);
            $(".dropdown-menu li").removeClass('active');
            $("#"+activehyperlink).parent('li').addClass('active');
            if(sort_type=='ASC'){
                $(".sort_type_div #sort-desc").hide();
                $(".sort_type_div #sort-asc").css({display: 'inline-block'});
            }else{
                $(".sort_type_div #sort-asc").hide();
                $(".sort_type_div #sort-desc").css({display: 'inline-block'});
            }
            $(".sort_type_div").css({display: 'inline-block'});
            var text = $('.dropdown-menu li.active').find('a').text();
            var textval = 'Sort By : '+text+' <span class="caret"></span>'; 
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

function add_action_notes(){
    var formData = new FormData(document.getElementById('modal_note_form'));
    var actionid = $("#modal_note_form #actionid").val();
    $.ajax({
                type: 'POST',
                url: base_url + 'action/home/addNotesmodal',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                   swal({title: "Success!", text: "Successfully Saved!", type: "success"}, function () {
                       if(result!='0'){
                            var prevnotecount = $("#notecount-"+actionid).text();
                           var notecount = parseInt(prevnotecount)+parseInt(result);
                           $("#notecount-"+actionid).text(notecount);
                       }
                       $("#notecount-"+actionid).removeClass('label label-warning').addClass('label label-danger');
                        document.getElementById("modal_note_form").reset(); 
                        $(".removenoteselector").trigger('click');
                        $('#showNotes').modal('hide');
                    });
                },
                beforeSend: function () {
                    $("#save_note").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $("#save_note").removeAttr('disabled').html('Save Note');
                    closeLoading();
                }
            });
}

function add_action_sos(){
    if (!requiredValidation('sos_note_form')) {
        return false;
    }    
    var formData = new FormData(document.getElementById('sos_note_form'));
    var actionid = $("#sos_note_form #refid").val();
    formData.append('actionid',actionid);
    $.ajax({
        type: 'POST',
        url: base_url + 'home/addSos',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
//                    alert(result); return false;
           swal({title: "Success!", text: "Successfully Added!", type: "success"}, function () {
               //if(result!='0'){
                   var prevsoscount = $("#soscount-"+actionid).text();
                   var soscount = parseInt(prevsoscount)+parseInt(1);
                   $("#soscount-"+actionid).text(soscount);
               //}
               $("#soscount-"+actionid).removeClass('label label-primary').addClass('label label-danger');
               //$("#soscount-"+actionid).html(soscount);
               $("#soscount-"+actionid).html('<i class="fa fa-bell"></i>');
                document.getElementById("sos_note_form").reset(); 
                var prevbymecount =  $("#sos-byme").html();
                if(result==0){
                    var newbymecount = parseInt(prevbymecount)+1;
                    $("#sos-byme").html(newbymecount);
                }                        

                //$(".notification-btn .label-byme").html(newbymecount);
                $("#action"+actionid).find(".priority").find('.m-t-5').remove();
                $("#action"+actionid).find(".priority").append('<img src="'+base_url+'/assets/img/badge_sos_priority.png" class="m-t-5"/>');
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
function reply_action_sos(form_id){
    var formData = new FormData(document.getElementById('sos_note_form_reply_'+form_id));
    $.ajax({
                type: 'POST',
                url: base_url + 'home/replySos',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                   swal({title: "Success!", text: "Successfully Replied!", type: "success"}, function () {
                        $('#showSos').modal('hide');
                    });
                },
                beforeSend: function () {
                    $("#save_sos_"+form_id).prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $("#save_sos_"+form_id).removeAttr('disabled').html('Save SOS');
                    closeLoading();
                }
            });
}


function update_action_notes(){
    var formData = new FormData(document.getElementById('modal_note_form_update'));
    //var actionid = $("#modal_note_form_update #actionid").val();
    $.ajax({
                type: 'POST',
                url: base_url + 'action/home/updateNotes',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                   swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                        document.getElementById("modal_note_form_update").reset(); 
                        $('#showNotes').modal('hide');
                    });
                },
                beforeSend: function () {
                    $("#update_note").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $("#update_note").removeAttr('disabled').html('Save Note');
                    closeLoading();
                }
            });
}




//function salesTaxFilter(monthYear, requestType, status, isFilter) {
//    var filterRequestValue = '';
//    var filterStatusValue = '';
//    if (requestType == 'others') {
//        filterRequestValue = $('.others_request_type_title').html();
//    } else if (requestType == 'my') {
//        filterRequestValue = $('.my_request_type_title').html();
//    }
//    if (status === 0) {
//        filterStatusValue = 'New';
//    } else if (status === 1) {
//        filterStatusValue = 'Started';
//    } else if (status === 2) {
//        filterStatusValue = 'Completed';
//    }
//    $.ajax({
//        type: "POST",
//        url: base_url + 'action/home/sales_tax_dashboard_ajax',
//        data: {
//            month_year: monthYear,
//            request_type: requestType,
//            status: status,
//            filter_data: {}
//        },
//        success: function (result) {
//            var decode_result = JSON.parse(result);
//            $("#sales_tax_process_dashboard_div").html(decode_result.sales_tax_data);
//            $("#search_month b").html(decode_result.search_month);
//            var summary_count = decode_result.summary_count;
//            summary_count.forEach(function (summary) {
//                var element = summary.split("-");
//                $("#" + element[0]).html(element[1]);
//            });
//            if (status !== '') {
//                $("#clear_filter").show();
//                $("#clear_filter span").html('');
//                $("#clear_filter span").html(filterRequestValue + ' - ' + filterStatusValue);
//            } else {
//                $("#clear_filter span").html('');
//                $("#clear_filter").hide();
//            }
//        },
//        beforeSend: function () {
//            openLoading();
//        },
//        complete: function (msg) {
//            closeLoading();
//        }
//    });
//}
function add_task_notes(){
    var formData = new FormData(document.getElementById('modal_note_form'));
    var taskid = $("#modal_note_form #taskid").val();
    $.ajax({
                type: 'POST',
                url: base_url + 'administration/template/addTaskNotesmodal',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                   swal({title: "Success!", text: "Successfully Saved!", type: "success"}, function () {
                       if(result!='0'){
                            var prevnotecount = $("#notecount-"+taskid).text();
                           var notecount = parseInt(prevnotecount)+parseInt(result);
                           $("#notecount-"+taskid).text(notecount);
                       }
                       $("#notecount-"+taskid).removeClass('label label-warning').addClass('label label-danger');
                        document.getElementById("modal_note_form").reset(); 
                        $(".removenoteselector").trigger('click');
                        $('#showTaskNotes').modal('hide');
                    });
                },
                beforeSend: function () {
                    $("#save_note").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $("#save_note").removeAttr('disabled').html('Save Note');
                    closeLoading();
                }
            });
}
function add_project_task_notes(){
    var formData = new FormData(document.getElementById('project_task_modal_note_form'));
    var taskid = $("#project_task_modal_note_form #taskid").val();
    $.ajax({
                type: 'POST',
                url: base_url + 'task/addProjectTaskNotesmodal',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                   swal({title: "Success!", text: "Successfully Saved!", type: "success"}, function () {
                       if(result!='0'){
                            var prevnotecount = $("#notecountinner-"+taskid).text();
                           var notecount = parseInt(prevnotecount)+parseInt(result);
                           $("#notecountinner-"+taskid).text(notecount);
                       }
                       $("#notecountinner-"+taskid).removeClass('label label-warning').addClass('label label-danger');
                        document.getElementById("project_task_modal_note_form").reset(); 
                        $(".removenoteselector").trigger('click');
                        $('#showProjectTaskNotes').modal('hide');
                    });
                },
                beforeSend: function () {
                    $("#save_note").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $("#save_note").removeAttr('disabled').html('Save Note');
                    closeLoading();
                }
            });
}
function update_task_notes(){
    var formData = new FormData(document.getElementById('modal_note_form_update'));
    //var actionid = $("#modal_note_form_update #actionid").val();
    $.ajax({
                type: 'POST',
                url: base_url + 'administration/template/updateTaskNotes',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                   swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                        document.getElementById("modal_note_form_update").reset(); 
                        $('#showTaskNotes').modal('hide');
                    });
                },
                beforeSend: function () {
                    $("#update_note").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $("#update_note").removeAttr('disabled').html('Save Note');
                    closeLoading();
                }
            });
}
function update_project_task_notes(){
    var formData = new FormData(document.getElementById('project_task_modal_note_form_update'));
    //var actionid = $("#modal_note_form_update #actionid").val();
    $.ajax({
                type: 'POST',
                url: base_url + 'task/updateProjectTaskNotes',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                   swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                        document.getElementById("project_task_modal_note_form_update").reset(); 
                        $('#showProjectTaskNotes').modal('hide');
                    });
                },
                beforeSend: function () {
                    $("#update_note").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $("#update_note").removeAttr('disabled').html('Save Note');
                    closeLoading();
                }
            });
}
function update_project_notes(){
    var formData = new FormData(document.getElementById('modal_note_form_update'));
    //var actionid = $("#modal_note_form_update #actionid").val();
    $.ajax({
                type: 'POST',
                url: base_url + 'project/updateProjectNotes',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                   swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                        document.getElementById("modal_note_form_update").reset(); 
                        $('#showProjectNotes').modal('hide');
                    });
                },
                beforeSend: function () {
                    $("#update_note").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $("#update_note").removeAttr('disabled').html('Save Note');
                    closeLoading();
                }
            });
}
function add_project_notes(){
    var formData = new FormData(document.getElementById('modal_note_form'));
    var project_id = $("#modal_note_form #project_id").val();
//    alert(project_id);
    $.ajax({
                type: 'POST',
                url: base_url + 'project/addProjectNotesmodal',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                   swal({title: "Success!", text: "Successfully Saved!", type: "success"}, function () {
                       if(result!='0'){
                            var prevnotecount = $("#notecount-"+project_id).text();
                           var notecount = parseInt(prevnotecount)+parseInt(result);
                           $("#notecount-"+project_id).text(notecount);
                       }
                       $("#notecount-"+project_id).removeClass('label label-warning').addClass('label label-danger');
                        document.getElementById("modal_note_form").reset(); 
                        $(".removenoteselector").trigger('click');
                        $('#showProjectNotes').modal('hide');
                    });
                },
                beforeSend: function () {
                    $("#save_note").prop('disabled', true).html('Processing...');
                    openLoading();
                },
                complete: function (msg) {
                    $("#save_note").removeAttr('disabled').html('Save Note');
                    closeLoading();
                }
            });
}

function load_business_dashboard(ofc = '', manager_id = '', partner_id = '', ref_source = '', company_type = '') {
    $('#service-tab').DataTable({
        'processing': false,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': base_url + 'action/home/load_data_business',
            'type': 'POST',
            'data': {
                'ofc': ofc,
                'manager_id': manager_id,
                'partner_id': partner_id,
                'ref_source': ref_source,
                'company_type': company_type
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        },
        'columns': [
            {data: 'name'},
            {data: 'practice_id'},
            {data: 'office_id'},
            {data: 'action'}
        ]
    });
}

function load_individual_dashboard(ofc_id = '', manager_id = '', partner_id = '', ref_source = '') {
    $('#service-tab').DataTable({
        'processing': false,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': base_url + 'action/home/load_data_individual',
            'type': 'POST',
            'data': {
                'ofc_id': ofc_id,
                'manager_id': manager_id,
                'partner_id': partner_id,
                'ref_source': ref_source
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        },
        'columns': [
            {data: 'first_name'},
            {data: 'last_name'},
            {data: 'practice_id'},
            {data: 'office_id'},
            {data: 'action'}
        ]
    });
}
var clear_sos_msg =(value) => {
    if (value == 'completed') {
        swal("ERROR!", "YOU STILL HAVE AN SOS UNCLEARED", "error");
        $("#rad2").removeAttr('checked');
    }else if(value == 'resolved'){
        swal("ERROR!", "YOU STILL HAVE AN SOS UNCLEARED", "error");
        $("#rad6").removeAttr('checked');
    } else if (value == 'cancelled') {
        swal("ERROR!", "YOU STILL HAVE AN SOS UNCLEARED", "error");
        $("#rad7").removeAttr('checked');
    }
        
}