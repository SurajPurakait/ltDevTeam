var base_url = document.getElementById('base_url').value;
function interval_total_amounts() {
    setInterval(function () {
        var total_amounts = document.getElementsByClassName('total_amounts');
        var corporate_tax_return = $(".corporate_tax_return").val();
        var price_initialam = $("#retail-price-initialamt").val();
        var total = 0;
        total += parseInt(price_initialam);
        for (i = 0; i < total_amounts.length; i++) {
            total += parseInt(total_amounts[i].value);
        }
        if (corporate_tax_return == 'y') {
            total += 35;
        }
        $("#retail-price").val(total + ".00");
        $("#retail-price-hidd").val(total);
    }, 100);
}

function client_type_change(client_type) {
//    $("#accounts-list").html("");
    var type_of_client = client_type.value;
    var new_reference_id = $("#reference_id").val();
    var clientid = $(".client_list option:selected").val();
    clearErrorMessageDiv()
    if (type_of_client == 0) {
        $("#client_list").show();
        $(".client_list").attr('required', "required");
        $("#name_of_business").hide();
        $("#business_name").removeAttr('required').val("");
    } else if (type_of_client == 1) {
        $("#name_of_business").show().attr('required');
        $("#business_name").attr('required', "required");
        $("#client_list").hide();
        $(".client_list").removeAttr('required').val("");
        $("#contact-list").html(blank_contact_list());
        $("#owners-list").html(blank_owner_list());
        $(".office-internal #office").val('');
        $("#partner").val('');
        $("#manager").val('');
        $("#client_association").val('');
        $("#referred_by_source").val('');
        $("#referred-by-name").val('');
        $("#language").val('');
        delete_contact_list(new_reference_id);
        delete_owner_list(new_reference_id);
        $(".internal-data").html('');
        $("#contact-list").html(blank_contact_list());
        $("#owners-list").html(blank_owner_list());
        $(".contactedit").removeClass('dcedit');
        $(".contactdelete").removeClass('dcdelete');
        $(".owner-data").html('');
        $(".owneredit").removeClass('doedit');
        $(".ownerdelete").removeClass('dodelete');
        $('.office-internal #office').prop('disabled', false);
        $('#partner').prop('disabled', false);
        $('#manager').prop('disabled', false);
        $("#client_association").prop("disabled", false);
        $("#referred_by_source").prop('disabled', false);
        $("#referred-by-name").prop("disabled", false);
        $("#language").prop('disabled', false);
        $("#owners_div, #internal_data_div, #documents_div, #business_description_div, #fiscal_year_end_div, #type_div, #state_div").show();
    }
    if (type_of_client == "") {
        $("#client_list, #name_of_business").hide();
        $("#business_name, .client_list").removeAttr('required').val("");
        $("#contact-list").html(blank_contact_list());
        $("#owners-list").html(blank_owner_list());
        $(".office-internal #office").val('');
        $("#partner").val('');
        $("#manager").val('');
        $("#client_association").val('');
        $("#referred_by_source").val('');
        $("#referred-by-name").val('');
        $("#language").val('');
        delete_contact_list(new_reference_id);
        delete_owner_list(new_reference_id);
        $(".internal-data").html('');
        $(".contact-data").html('');
        $(".contactedit").removeClass('dcedit');
        $(".contactdelete").removeClass('dcdelete');
        $(".owner-data").html('');
        $(".owneredit").removeClass('doedit');
        $(".ownerdelete").removeClass('dodelete');
        $('.office-internal #office').prop('disabled', false);
        $('#partner').prop('disabled', false);
        $('#manager').prop('disabled', false);
        $("#client_association").prop("disabled", false);
        $("#referred_by_source").prop('disabled', false);
        $("#referred-by-name").prop("disabled", false);
        $("#language").prop('disabled', false);
        $("#owners_div, #internal_data_div, #documents_div, #business_description_div, #fiscal_year_end_div, #type_div, #state_div").show();
    }
    $('.office-internal #office').prop('disabled', false);
    $('#partner').prop('disabled', false);
    $('#manager').prop('disabled', false);
    $("#client_association").prop("disabled", false);
    $("#referred_by_source").prop('disabled', false);
    $("#referred_by_name").prop("disabled", false);
    $("#language").prop('disabled', false);
    $('#state').prop('disabled', false);
    $('#type').val("");
    $('#type').prop('disabled', false);
}

function delete_contact_list(reference_id) {
    $.ajax({
        type: "POST",
        data: {
            reference_id: reference_id
        },
        url: base_url + 'services/home/delete_contact_ist',
        dataType: "html",
        success: function (result) {
            //alert(result);
        }
    });
}

function delete_owner_list(reference_id) {
    $.ajax({
        type: "POST",
        data: {
            reference_id: reference_id
        },
        url: base_url + 'services/home/delete_owner_list',
        dataType: "html",
        success: function (result) {
            //alert(result);
        }
    });
}

// function seller_info_modal(modal_type, reference, reference_id, id){

// }
function contact_modal(modal_type, reference, reference_id, id) {
    if (modal_type == "edit") {
        if ($(".contactedit").hasClass("dcedit")) {
            return false;
        }
    }
    if (modal_type == "add") {
        if ($("a").hasClass("contactadd")) {
            if ($(".contactadd").hasClass("dcadd")) {
                return false;
            }
        }
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_contact',
        data: {
            modal_type: modal_type,
            reference: reference,
            reference_id: reference_id,
            id: id
        },
        success: function (result) {
            $('#contact-form').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function document_modal(modal_type, reference, reference_id) {
    if (reference_id == '') {
        reference_id = $("#reference_id").val();
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_document',
        data: {
            modal_type: modal_type,
            reference: reference,
            reference_id: reference_id
        },
        success: function (result) {
            $('#document-form').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function save_contact() {
    if (!requiredValidation('form_contact')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('form_contact'));
    var reference = $("form#form_contact #reference").val();
    var reference_id = $("form#form_contact #reference_id").val();
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/home/save_contact',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log(result); return false;
            if (result == -1) {
                swal("ERROR!", "Error Processing Data", "error");
            } else if (result == -2) {
                swal("ERROR!", "Same Type Can't Exist", "error");
            } else if (result == -3) {
                swal("ERROR!", "Email/Phone Already Exists", "error");
            } else {
                $('#contact-form').modal('hide');
                get_contact_list(reference_id, reference);
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

function save_document() {
    if (!requiredValidation('form_document')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('form_document'));
    var reference = $("form#form_document #reference").val();
    var reference_id = $("form#form_document #reference_id").val();

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/home/save_document',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result == -1) {
                alert("Error Processing Data");
            } else {
                $('#document-form').modal('hide');
                get_document_list(reference_id, reference);
            }
        }
    });
}

function get_contact_list(reference_id, reference, disable = "") {
    $.ajax({
        type: "POST",
        data: {
            reference: reference,
            reference_id: reference_id,
            disable: disable
        },
        url: base_url + 'services/home/get_contact_list',
        dataType: "html",
        success: function (result) {
            $("#contact-list").html(result);
        }
    });
}

function get_document_list(reference_id, reference) {
    $.ajax({
        type: "POST",
        data: {
            reference: reference,
            reference_id: reference_id
        },
        url: base_url + 'services/home/get_document_list',
        dataType: "html",
        success: function (result) {
            $("#document-list").html(result);
        }
    });
}

// function get_document_list_new(reference_id, reference, order_id){
//     $.ajax({
//         type: "POST",
//         data: {
//             reference: reference,
//             reference_id: reference_id,
//             order_id: order_id
//         },
//         url: base_url + 'services/home/get_document_list_new',
//         dataType: "html",
//         success: function (result) {
//             $("#document-list").html(result);
//         }
//     });
// }

function contact_delete(reference, reference_id, id) {
    if ($(".contactdelete").hasClass("dcdelete")) {
        return false;
    }
    swal({
        title: "Are you sure?",
        text: "Your will not be able to recover this contact!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function () {
        $.ajax({
            type: "POST",
            data: {
                id: id,
                reference: reference,
                reference_id: reference_id
            },
            url: base_url + "services/home/delete_contact",
            dataType: "html",
            success: function (result) {
                if (result == '2') {
                    get_contact_list(reference_id, reference);
                    swal("Deleted!", "Your contact has been deleted.", "success");
                } else if (result == '1') {
                    swal("Unable To Delete!", "You should have atleast one contact!", "error");
                } else {
                    swal("Error!", "Error to Delete Contact.", "error");
                }
            }
        });
    });
}

function delete_document(reference, reference_id, id, file_name) {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this document!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function () {
        $.get(base_url + "services/home/delete_document/" + id + "/" + file_name, function (data) {
            if (data == 1) {
                get_document_list(reference_id, reference);
                swal("Deleted!", "Your document has been deleted.", "success");
            } else {
                swal("Unable To Delete document");
            }
        });
    });
}

function employee_modal(modal_type, employee_id) {
    if (modal_type == "add") {
        var employee_count = $("#employee_info").val();
        if (typeof $("#payroll_employee_people_total option:selected").val() !== 'undefined') {
            var max_employee = $("#payroll_employee_people_total option:selected").val().split("-");
            max_employee = max_employee[1];
            if (parseInt(employee_count) > parseInt(max_employee)) {
                swal("ERROR!", "Can not add employee more than " + max_employee, "error");
                return false;
            }
        }
    }
    $.ajax({
        type: "POST",
        data: {
            modal_type: modal_type,
            employee_id: employee_id
        },
        url: base_url + "modal/show_employee_modal",
        dataType: "html",
        success: function (result) {
            $('#employee-form').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function save_employee() {

    if (!requiredValidation('form_employee')) {
        return false;
    }

    var D1 = new Date($("#date_of_birth").val());
    var D2 = new Date($('#date_of_hire').val());


    //if(hire_date.getTime()>=birth_date.getTime() )
    if (D2.getTime() <= D1.getTime()) {
        swal("Error", "Date of Hire Should be Greater Than Date of Birth!", "error");
        return false;
    }

    var reference_id = $("#reference_id").val();

    var formData = new FormData(document.getElementById('form_employee'));
    formData.append('reference_id', reference_id);
//    formData.append('action', 'save_employee');

    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/save_employee',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            console.log("Result: " + result);
            if (result == 2) {
                swal("ERROR!", "Error to upload file", "error");
            } else if (result == 3) {
                swal("ERROR!", "Email already exists", "error");
            } else if (result == 0) {
                swal("ERROR!", "Error to insert employee", "error");
            } else {
                cleanFormFields('form_employee');
                $('#employee-form').modal('hide');
                document.getElementById('quant_employee').value = parseInt(document.getElementById('quant_employee').value) + 1;
                get_employee_list(reference_id);
            }
            closeLoading();
            console.log("Reference Id: " + $("#reference_id").val());
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function get_employee_list(reference_id) {
    // reload_employee_list
    $.ajax({
        type: "POST",
        data: {
            reference_id: reference_id
        },
        url: base_url + 'services/accounting_services/get_employee_list',
        dataType: "html",
        success: function (result) {
            document.getElementById('employee-list').innerHTML = result;
        }
    });
}

function delete_employee(employee_id) {
    swal({
        title: "Are you sure?",
        text: "This employee will be deleted!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            type: "POST",
            data: {
                employee_id: employee_id
            },
            url: base_url + 'services/accounting_services/delete_employee',
            dataType: "html",
            success: function (result) {
                if (result != 0) {
                    var reference_id = $("#reference_id").val();
//                    document.getElementById('quant_employee').value = parseInt(document.getElementById('quant_employee').value) - 1;
                    get_employee_list(reference_id);
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
    });
}

function save_payroll_approver() {
    if (!requiredValidation('form_payroll_approver')) {
        return false;
    }
    var reference = $("#reference").val();
    var reference_id = $("#reference_id").val();
    var order_id = $("#editval").val();
    var formData = new FormData(document.getElementById('form_payroll_approver'));
    formData.append('reference', reference);
    formData.append('reference_id', reference_id);
    formData.append('order_id', order_id);

    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/save_payroll_approver',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            //alert(result);
            console.log("Result: " + result);
            if (result != 0) {
                clean_form_fields('form_payroll_approver');
                $('#payroll-approver-form').modal('hide');
                $("#payroll_first_name").val('');
                $("#payroll_last_name").val('');
                $("#payroll_email").val('');
                $("#payroll_phone").val('');
                $("#payroll_title").val('');
                $("#payroll_social_security").val('');
                $("#payroll_fax").val('');
                $("#payroll_ext").val('');
                $("#payroll_approver_quantity").val(1);
                var res = JSON.parse(result);
                $("#payroll_first_name").val(res.fname);
                $("#payroll_last_name").val(res.lname);
                $("#payroll_title").val(res.title);
                $("#payroll_social_security").val(res.social_security);
                $("#payroll_phone").val(res.phone);
                $("#payroll_ext").val(res.ext);
                $("#payroll_fax").val(res.fax);
                $("#payroll_email").val(res.email);
                $("#payroll_approver_div").show();
            } else {
                swal("ERROR!", "You cannot add more than one payroll approver", "error");
            }
            closeLoading();
            console.log("Reference Id: " + $("#reference_id").val());
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function clean_form_fields(formId) {
    var form = document.getElementById(formId);
    for (var i = 0; i < form.elements.length; i++) {
        form.elements[i].value = '';
    }
}