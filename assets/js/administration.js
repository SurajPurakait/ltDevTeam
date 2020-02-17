var base_url = document.getElementById('base_url').value;

function update_departments() {
    if (!requiredValidation('edit_dept_form')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('edit_dept_form'));
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/departments/update_departments',
        data: form_data,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            console.log(result);
            if (result == 1) {
                swal("Success!", "Successfully updated!", "success");
                goURL(base_url + 'administration/departments');
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

function insert_departments() {
    if (!requiredValidation('add_dept_form')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('add_dept_form'));
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/departments/insert_departments',
        data: form_data,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            console.log(result);
            if (result == 1) {
                swal("Success!", "Successfully added!", "success");
                goURL(base_url + 'administration/departments');
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

function add_franchise() {
    if (!requiredValidation('form_office_modal')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('form_office_modal'));
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/office/insert_franchise',
        data: form_data,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            console.log(result);
            if (result == 1) {
                swal("Success!", "Successfully inserted!", "success");
                goURL(base_url + 'administration/office');
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

function update_franchise() {
    if (!requiredValidation('form_office_modal')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('form_office_modal'));
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/office/update_franchise',
        data: form_data,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            console.log(result);
            if (result == 1) {
                save_office_manager();
                swal("Success!", "Successfully updated!", "success");
                goURL(base_url + 'administration/office');
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


function save_service_fees() {
    // alert("Hello");return false;

    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/office/save_service_fees',
        data: form_data,
        // enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {

            if (result == 1) {
                // save_office_manager();
                swal("Success!", "Successfully saved!", "success");
                // goURL(base_url + 'administration/office');
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

function cancel_office() {
    goURL('../index');
}

function insert_staff() {
    if (!requiredValidation('add_staff_form')) {
        return false;
    }
    var password = $("#password").val();
    var retype_password = $("#retype_password").val();

    if (retype_password != "" && password != retype_password) {
        swal("ERROR!", "Password Mismatch! \n Please, try again.", "error");
        return false;

    }
    var form_data = new FormData(document.getElementById('add_staff_form'));
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/manage_staff/insert_staff',
        data: form_data,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            clearErrorMessageDiv();
            var obj = $.parseJSON(result);
            if (obj.success == 0) {
                var error = obj.error_field;
                for (var i = 0; i < error.length; i++) {
                    printErrorMessage(error[i][0], error[i][1]);
                }
            } else if (obj.status_msg == 2) {
                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
            } else {
                swal("Success!", "Successfully added staff!", "success");
                goURL(base_url + 'administration/manage_staff');
            }
        }
    });
}

function update_staff() {
    if (!requiredValidation('edit_staff_form')) {
        return false;
    }
    var password = $("#password").val();
    var retype_password = $("#retype_password").val();

    if (retype_password != "" && password != retype_password) {
        swal("ERROR!", "Password Mismatch! \n Please, try again.", "error");
        return false;

    }
    var form_data = new FormData(document.getElementById('edit_staff_form'));
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/manage_staff/update_staff',
        data: form_data,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            clearErrorMessageDiv();
            var obj = $.parseJSON(result);
            if (obj.success == 0) {
                var error = obj.error_field;
                for (var i = 0; i < error.length; i++) {
                    printErrorMessage(error[i][0], error[i][1]);
                }
            } else if (obj.status_msg == 2) {
                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
            } else {
                swal("Success!", "Successfully updated staff!", "success");
                goURL(base_url + 'administration/manage_staff');
            }
        }
    });

}


function get_related_services(previous_services, current_service) {
    var service_id = $("#servicecat").find(":selected").val();
    $.post(base_url + "/administration/service_setup/get_related_services", {
        id: service_id,
        prev: previous_services,
        current: current_service
    }, function (data) {
        $("#relatedserv option").remove();
        $("#relatedserv").append(data);
    });
}

function addPartnerService() {
    if (!requiredValidation('add-partner-services-form')) {
        return false;
    }
    var servicecat = $('#add-partner-services-form #servicecat option:selected').val();
    var servicename = $('#add-partner-services-form #servicename').val();
    var input_form = $('#add-partner-services-form input[name="input_form"]:checked').val();
    var shortcode = $('#add-partner-services-form #shorthidden').val();
    var note = $('#add-partner-services-form #note').val();
    var responsible_assigned = $('#add-partner-services-form input[name="responsible_assigned"]:checked').val();
    var partnertype = $('#add-partner-services-form #partnertype option:selected').val();
    
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/partner_service_setup/add_partner_service',
        data: {
            category_id:servicecat,
            description : servicename,
            ideas : shortcode,
            responsible_assigned : responsible_assigned,
            partner_type : partnertype,
            input_form : input_form,
            note : note   
        },
        success: function (result) {
            if (result.trim() == "1") {
                swal({
                    title: "Success!",
                    "text": "Successfully added!",
                    "type": "success"
                }, function () {
                    goURL(base_url + 'administration/partner_service_setup');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Partner Service", "error");
            } else if (result.trim() == "0") {
                swal("ERROR!", "Service Name Exists", "error");
            }
        }
    });       
}

function addRelatedservice() {
    if (!requiredValidation('add-services-form')) {
        return false;
    }

    var servicecat = $('#add-services-form #servicecat option:selected').val();
    var servicename = $('#add-services-form #servicename').val();
    var retailprice = $('#add-services-form #retailprice').val();
    var relatedserv = $('#add-services-form #relatedserv').val();
    var startdays = $('#add-services-form #startdays').val();
    var enddays = $('#add-services-form #enddays').val();
    // var dept = $('#add-services-form #dept option:selected').val();
    var input_form = $('#add-services-form input[name="input_form"]:checked').val();
    var shortcode = $('#add-services-form #shorthidden').val();
    var note = $('#add-services-form #note').val();
    var fixedcost = $('#add-services-form #fixedcost').val();

    var responsible_assigned = $('#add-services-form input[name="responsible_assigned"]:checked').val();
    if(responsible_assigned == 2){
      var dept = $('#add-services-form #dept option:selected').val();  
  }else{
      var dept = "NULL"; 
  }

    var client_type = [];
            $.each($("input[name='client_type']:checked"), function(){
                client_type.push($(this).val());
            });
    if(client_type == 0){
        client_type = 0;
    }else if(client_type == 1){
        client_type = 1;
    }else if(client_type == "0,1"){
        client_type = 2;
    }
   
    $.ajax({
        type: "POST",
        data: {
            servicecat: servicecat,
            servicename: servicename,
            retailprice: retailprice,
            relatedserv: relatedserv,
            startdays: startdays,
            enddays: enddays,
            dept: dept,
            input_form: input_form,
            shortcode: shortcode,
            note: note,
            fixedcost: fixedcost,
            responsible_assigned:responsible_assigned,
            client_type: client_type
        },
        url: base_url + '/administration/service_setup/add_related_service',
        dataType: "html",
        success: function (result) {
            // console.log(result);return false;
            if (result.trim() == "1") {
                swal({
                    title: "Success!",
                    "text": "Successfully added!",
                    "type": "success"
                }, function () {
                    goURL(base_url + 'administration/service_setup');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Service", "error");
            } else if (result.trim() == "0") {
                swal("ERROR!", "Service Name Exists", "error");
            }
        }
    });
}

function delete_service(id) {
    $.get(base_url + "administration/service_setup/get_service_relations/" + id, function (result) {
        if (result != 0) {
            swal({
                title: "Error",
                text: "Service Is Used. Can Not Delete!!",
                type: "error"
            });
        } else {
            swal({
                title: "Are you sure want to delete?",
                text: "Your will not be able to recover this service!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
                    function () {
                        $.ajax({
                            type: 'POST',
                            url: base_url + '/administration/service_setup/delete_service_controller',
                            data: {
                                service_id: id
                            },
                            success: function (result) {
                                if (result == "1") {
                                    swal({
                                        title: "Success!",
                                        "text": "Service been deleted successfully!",
                                        "type": "success"
                                    }, function () {
                                        goURL(base_url + 'administration/service_setup');
                                    });
                                } else {
                                    swal("ERROR!", "Unable to delete the service", "error");
                                }
                            }
                        });
                    });
        }
    });
}

function delete_department(id) {
    $.get(base_url + "administration/departments/get_department_relations/" + id, function (result) {
        if (result != 0) {
            swal({
                title: "Error",
                text: "Department Is In Use. Can Not Delete!!",
                type: "error"
            });
        } else {
            swal({
                title: "Are you sure want to delete?",
                text: "Your will not be able to recover this department!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
                    function () {
                        $.ajax({
                            type: 'POST',
                            url: base_url + '/administration/departments/delete_department',
                            data: {
                                department_id: id
                            },
                            success: function (result) {
                                if (result == "1") {
                                    swal({
                                        title: "Success!",
                                        "text": "Service been deleted successfully!",
                                        "type": "success"
                                    }, function () {
                                        goURL(base_url + 'administration/departments');
                                    });
                                } else {
                                    swal("ERROR!", "Unable to delete this department", "error");
                                }
                            }
                        });
                    });
        }
    });
}

function delete_office(id) {
    // alert(id);return false;
    $.get(base_url + "administration/office/get_office_relations/" + id, function (result) {
        if (result != 0) {
            swal({
                title: "Error",
                text: "Office Is In Use. Can Not Delete!!",
                type: "error"
            });
        } else {
            swal({
                title: "Are you sure want to delete?",
                text: "Your will not be able to recover this department!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
                    function () {
                        $.ajax({
                            type: 'POST',
                            url: base_url + '/administration/office/delete_office',
                            data: {
                                office_id: id
                            },
                            success: function (result) {
                                if (result == "1") {
                                    swal({
                                        title: "Success!",
                                        "text": "Office been deleted successfully!",
                                        "type": "success"
                                    }, function () {
                                        goURL(base_url + 'administration/office');
                                    });
                                } else {
                                    swal("ERROR!", "Unable to delete this office", "error");
                                }
                            }
                        });
                    });
        }
    });
}


function deactive_office(id, status = '') {
//     alert(status);return false;
    if (status == 3) {
        var title = 'Do you want to activate?';
        var msg = "Office has been activated successfully!";
    } else {
        title = 'Do you want to deactivate?';
        msg = "Office has been deactivated successfully!";
    }
    $.get(base_url + "administration/office/get_office_relations/" + id, function (result) {
        if (result != 0) {
            swal({
                title: title,
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, change it!",
                closeOnConfirm: false
            },
                    function () {
                        $.ajax({
                            type: 'POST',
                            url: base_url + '/administration/office/deactivate_office',
                            data: {
                                office_id: id
                            },
                            success: function (results) {
                                if (results == 1) {
                                    swal({
                                        title: "Success!",
                                        "text": msg,
                                        "type": "success"
                                    }, function () {
                                        goURL(base_url + 'administration/office');
                                    });
                                } else {
                                    swal("ERROR!", "Unable to change this office status", "error");
                                }
                            }
                        });
                    });
        }
    });
}

function delete_staff(id) {
    $.get(base_url + "administration/manage_staff/get_staff_relations/" + id, function (result) {
        if (result != 0) {
            swal({
                title: "Error",
                text: "Staff Is In Use. Can Not Delete!!",
                type: "error"
            });
        } else {
            swal({
                title: "Are you sure want to delete?",
                text: "Your will not be able to recover this staff!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
                    function () {
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'administration/manage_staff/delete_staff',
                            data: {
                                staff_id: id
                            },
                            success: function (result) {
                                if (result == "1") {
                                    swal({
                                        title: "Success!",
                                        "text": "Staff been deleted successfully!",
                                        "type": "success"
                                    }, function () {
                                        goURL(base_url + 'administration/manage_staff');
                                    });
                                } else {
                                    swal("ERROR!", "Unable to delete this staff", "error");
                                }
                            }
                        });
                    });
        }
    });
}

function updatePartnerService() {
    if (!requiredValidation('edit-partner-services-form')) {
        return false;
    }
    var id = $('#edit-partner-services-form #service_id').val();
    var servicecat = $('#edit-partner-services-form #servicecat option:selected').val();
    var servicename = $('#edit-partner-services-form #servicename').val();
    var input_form = $('#edit-partner-services-form input[name="input_form"]:checked').val();
    var shortcode = $('#edit-partner-services-form #shorthidden').val();
    var note = $('#edit-partner-services-form #note').val();
    var responsible_assigned = $('#edit-partner-services-form input[name="responsible_assigned"]:checked').val();
    var partnertype = $('#edit-partner-services-form #partnertype option:selected').val();

    $.ajax({
        type: "POST",
        data: {
            id : id,
            category_id:servicecat,
            description : servicename,
            ideas : shortcode,
            responsible_assigned : responsible_assigned,
            partner_type : partnertype,
            input_form : input_form,
            note : note
        },
        url: base_url + '/administration/partner_service_setup/update_partner_service',
        dataType: "html",
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                    goURL(base_url + 'administration/partner_service_setup');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Update Partner Service", "error");
            } else {
                swal("ERROR!", "Partner Service Name Already Exists", "error");
            }
        }
    });

}

function updateRelatedservice() {
    if (!requiredValidation('edit-services-form')) {
        return false;
    }

    var servicecat = $('#edit-services-form #servicecat option:selected').val();
    var servicename = $('#edit-services-form #servicename').val();
    var retailprice = $('#edit-services-form #retailprice').val();
    var relatedserv = $('#edit-services-form #relatedserv').val();
    var startdays = $('#edit-services-form #startdays').val();
    var enddays = $('#edit-services-form #enddays').val();
    // var dept = $('#edit-services-form #dept option:selected').val();
    var id = $('#edit-services-form #service_id').val();
    var input_form = $('#edit-services-form input[name="input_form"]:checked').val();
    var shortcode = $('#edit-services-form #shorthidden').val();
    var note = $('#edit-services-form #note').val();
    var fixedcost = $('#edit-services-form #fixedcost').val();

    var responsible_assigned = $('#edit-services-form input[name="responsible_assigned"]:checked').val();
    if(responsible_assigned == 2){
      var dept = $('#edit-services-form #dept option:selected').val();  
    }else{
      var dept = "NULL"; 
   }

    var client_type = [];
            $.each($("input[name='client_type']:checked"), function(){
                client_type.push($(this).val());
            });
    if(client_type == 0){
        client_type = 0;
    }else if(client_type == 1){
        client_type = 1;
    }else if(client_type == "0,1"){
        client_type = 2;
    }

    $.ajax({
        type: "POST",
        data: {
            servicecat: servicecat,
            servicename: servicename,
            retailprice: retailprice,
            relatedserv: relatedserv,
            startdays: startdays,
            enddays: enddays,
            dept: dept,
            id: id,
            input_form: input_form,
            shortcode: shortcode,
            note: note,
            fixedcost: fixedcost,
            responsible_assigned: responsible_assigned,
            client_type: client_type
        },
        url: base_url + '/administration/service_setup/update_related_service',
        dataType: "html",
        success: function (result) {
            // console.log(result);return false;
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                    goURL(base_url + 'administration/service_setup');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Update Service", "error");
            } else {
                swal("ERROR!", "Service Name Already Exists", "error");
            }
        }
    });

}

function add_company_type() {
    if (!requiredValidation('add-company-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('add-company-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'administration/company_type/add_company_type',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Successfully Added!", type: "success"}, function () {
                    goURL(base_url + 'administration/company_type');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Company", "error");
            } else {
                swal("ERROR!", "Name Already Exists", "error");
            }
        }
    });

}

function edit_company_type() {
    if (!requiredValidation('edit-company-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('edit-company-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'administration/company_type/edit_company_type',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                    goURL(base_url + 'administration/company_type');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Update Company", "error");
            } else {
                swal("ERROR!", "Name Already Exists", "error");
            }
        }
    });
}

function delete_company(company_id) {
    $.get(base_url + "/administration/company_type/get_company_relations/" + company_id, function (result) {
        if (result != 0) {
            swal({
                title: "Error",
                text: "Company Type Is Used. Can Not Delete!!",
                type: "error"
            });
        } else {
            swal({
                title: "Are you sure want to delete?",
                text: "Your will not be able to recover this company!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
                    function () {
                        $.ajax({
                            type: 'POST',
                            url: base_url + '/administration/company_type/delete_company_type',
                            data: {
                                company_id: company_id
                            },
                            success: function (result) {
                                if (result == "1") {
                                    swal({
                                        title: "Success!",
                                        "text": "Company been deleted successfully!",
                                        "type": "success"
                                    }, function () {
                                        goURL(base_url + 'administration/company_type');
                                    });
                                } else {
                                    swal("ERROR!", "Unable to delete the company!", "error");
                                }
                            }
                        });
                    });
        }
    });
}


function add_source_type() {
    if (!requiredValidation('add-source-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('add-source-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'administration/referred_source/add_source_type',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Source Successfully Added!", type: "success"}, function () {
                    goURL(base_url + 'administration/referred_source');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Source", "error");
            } else {
                swal("ERROR!", "Name Already Exists", "error");
            }
        }
    });

}

function edit_source_type() {
    if (!requiredValidation('edit-source-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('edit-source-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'administration/referred_source/edit_source_type',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Source Successfully Updated!", type: "success"}, function () {
                    goURL(base_url + 'administration/referred_source');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Update Source", "error");
            } else {
                swal("ERROR!", "Name Already Exists", "error");
            }
        }
    });
}

function delete_source(source_id) {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this source!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'administration/referred_source/delete_source_type',
                    data: {
                        source_id: source_id
                    },
                    success: function (result) {
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "source been deleted successfully!",
                                "type": "success"
                            }, function () {
                                goURL(base_url + 'administration/referred_source');
                            });
                        } else {
                            swal("ERROR!", "Unable to delete this source!", "error");
                        }
                    }
                });
            });
}

function loadstaffdata(ofc = '', dept = '', type = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/manage_staff/load_staff_data',
        data: {
            ofc: ofc,
            dept: dept,
            type: type
        },
        success: function (result) {
            $(".ajaxdiv-staff").html(result);
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function get_log_data_ajx() {
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/manage_log/load_staff_data',
        success: function (result) {
            $("#ajax-div-log").html(result);
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function get_staff_for_role() {
    var office_type = $("#ofc_type").val();
    var office_id = $("#franchise_office_id").val();
    $.ajax({
        type: 'POST',
        url: base_url + 'administration/office/get_office_staff',
        data: {
            office_id: office_id
        },
        success: function (result) {
            if (office_type == 2) {
                $("#manager_div").show();
                $("#manager").html(result).removeAttr("disabled");
            } else {
                $("#manager_div").hide();
                $("#manager").html("<option value=''>Select an option</option>").attr("disabled", "disabled");
            }
        }
    });
}

function save_office_manager() {
    var office_type = $("#ofc_type").val();
    if (office_type == 2) {
        var office_id = $("#franchise_office_id").val();
        var staff = $("#manager").val();
        $.ajax({
            type: 'POST',
            url: base_url + 'administration/office/save_office_manager',
            data: {
                office_id: office_id,
                staff_id: staff
            },
            success: function (result) {
            }
        });
    }
}

function add_business_client() {
    if (!requiredValidation('add-business-client-form-modal')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('add-business-client-form-modal'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'administration/business_client/add_business_client',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result == "1") {
                swal({title: "Success!", text: "Successfully Added!", type: "success"}, function () {
                    goURL(base_url + 'administration/business_client');
                });
            } else if (result == "-1") {
                swal("ERROR!", "Unable To Add Business Client", "error");
            } else {
                swal("ERROR!", "Name Already Exists", "error");
            }
        }
    });

}
function add_renewal_dates() {
    if (!requiredValidation('add-renewal-dates-form-modal')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('add-renewal-dates-form-modal'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'administration/renewal_dates/add_renewal_dates',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Successfully Added!", type: "success"}, function () {
                    goURL(base_url + 'administration/renewal_dates');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Renewal Dates", "error");
            } else {
                swal("ERROR!", "Name Already Exists", "error");
            }
        }
    });

}
function edit_renewal_dates() {
    if (!requiredValidation('edit-renewal-dates-form-modal')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('edit-renewal-dates-form-modal'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'administration/renewal_dates/edit_renewal_dates',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                    goURL(base_url + 'administration/renewal_dates');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Update Renewal Dates", "error");
            } else {
                swal("ERROR!", "Name Already Exists", "error");
            }
        }
    });
}
function delete_renewal_dates(client_id) {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this client!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/administration/renewal_dates/delete_renewal_dates',
                    data: {
                        client_id: client_id
                    },
                    success: function (result) {
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "Client been deleted successfully!",
                                "type": "success"
                            }, function () {
                                goURL(base_url + 'administration/renewal_dates');
                            });
                        } else {
                            swal("ERROR!", "Unable to delete the client!", "error");
                        }
                    }
                });
            });
//        }
//    });
}

function edit_business_client() {
    if (!requiredValidation('edit-business-client-form-modal')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('edit-business-client-form-modal'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'administration/business_client/edit_business_client',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result == "1") {
                swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                    goURL(base_url + 'administration/business_client');
                });
            } else if (result == "-1") {
                swal("ERROR!", "Unable To Update Business Client", "error");
            } else {
                swal("ERROR!", "Name Already Exists", "error");
            }
        }
    });
}
function delete_business_client(client_id) {
//    $.get(base_url + "/administration/business_client/get_company_relations/" + client_id, function (result) {
//        if (result != 0) {
//            swal({
//                title: "Error",
//                text: "Company Type Is Used. Can Not Delete!!",
//                type: "error"
//            });
//        } else {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this client!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/administration/business_client/delete_business_client',
                    data: {
                        client_id: client_id
                    },
                    success: function (result) {
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "Client been deleted successfully!",
                                "type": "success"
                            }, function () {
                                goURL(base_url + 'administration/business_client');
                            });
                        } else {
                            swal("ERROR!", "Unable to delete the client!", "error");
                        }
                    }
                });
            });
//        }
//    });
}

function insert_import_lead() {
    var atLeastOneIsChecked = $('input[name="import_lead[]"]:checked').length > 0;
    if (atLeastOneIsChecked == false) {
        swal("ERROR!", "Please check at least one lead for import", "error");
    } else {
        var form_data = new FormData(document.getElementById('import_lead_form'));
        var lead_count = $('input[name="import_lead[]"]:checked').length;

        $.ajax({
            type: "POST",
            data: form_data,
            url: base_url + 'administration/get_leads/insert_import_lead',
            dataType: "html",
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            cache: false,
            success: function (result) {
                //alert(result); return false;
                if (result == "1") {
                    swal({title: "Success!", text: "Successfully Imported!", type: "success"}, function () {
                        $("#import_lead_div").html('<span class="text-info">' + lead_count + ' Leads Successfully Imported</span>');
                    });
                } else {
                    swal("ERROR!", "Unable To Import Leads", "error");
                }
            }
        });
    }
}



