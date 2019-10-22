var base_url = document.getElementById('base_url').value;

function edit_department(department_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/edit_department',
        data: {
            department_id: department_id
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            $('#edit-dept-form').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_franchise_modal(modal_type, franchise_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_franchise_modal',
        data: {
            modal_type: modal_type,
            franchise_id: franchise_id
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            $('#franchise-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_staff_modal(modal_type, staff_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_staff_modal',
        data: {
            modal_type: modal_type,
            staff_id: staff_id
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            $('#staff-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}


function show_visitation_modal(modal_type, id = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/add_visitation_modal',
        data: {
            modal_type: modal_type,
            id: id
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            $("#visitation-form-modal").html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_visit_notes_modal(id) {
    $.ajax({
        url: base_url + 'modal/show_visit_notes_modal',
        data: {
            id: id
        },
        type: 'POST',
        dataType: 'html',
        cache: false,
        success: function (result) {
            $('#visitation-note-modal #notes-modal-body').html(result);
            $("#visitation-note-modal #visitation_id").val(id);
            $("#notecount-" + id).removeClass('label label-danger').addClass('label label-success');
            openModal('visitation-note-modal');
        },

    });

}


function change_visitation_status(visitation_id, visitation_status) {
    $.ajax({
        type: "POST",
        data: {
            visitation_id: visitation_id,
            visitation_status: visitation_status
        },
        url: base_url + 'modal/change_visitation_status',
        success: function (result) {
            $('#changeStatusVisitation').show();
            $('#changeStatusVisitation').html(result).modal({
                backdrop: 'static',
                keyboard: false
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



function show_department_modal() {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_department_modal',
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            $('#department-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_service_modal(modal_type, service_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_service_modal',
        data: {
            modal_type: modal_type,
            service_id: service_id
        },
        success: function (result) {
            $('#service-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#service-form-modal').on('shown.bs.modal', function () {
                $(".chosen-select").chosen("destroy");
                $(".chosen-select").chosen();
            });
        }
    });
}

function show_company_modal(modal_type, company_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_company_modal',
        data: {
            modal_type: modal_type,
            company_id: company_id
        },
        success: function (result) {
            $('#company-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_source_modal(modal_type, source_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_source_modal',
        data: {
            modal_type: modal_type,
            source_id: source_id
        },
        success: function (result) {
            $('#source-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_lead_type_modal(modal_type, lead_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_lead_type_modal',
        data: {
            modal_type: modal_type,
            lead_id: lead_id
        },
        success: function (result) {
            $('#new-lead-type-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_lead_ref_modal(modal_type, ref_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_lead_ref_modal',
        data: {
            modal_type: modal_type,
            ref_id: ref_id
        },
        success: function (result) {
            $('#lead-ref-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_lead_source_modal(modal_type, source_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_lead_source_modal',
        data: {
            modal_type: modal_type,
            source_id: source_id
        },
        success: function (result) {
            $('#lead-source-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_action_tracking_modal(id, page_name) {
    // alert(page_name);return false;
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_action_tracking_modal',
        data: {
            id: id,
            page_name: page_name
        },
        success: function (result) {
            $('#modal_area').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_lead_tracking_modal(id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_lead_tracking_modal',
        data: {
            id: id
        },
        success: function (result) {
            $('#modal_area').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_ref_partner_tracking_modal(id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_ref_partner_tracking_modal',
        data: {
            id: id
        },
        success: function (result) {
            $('#modal_area').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_action_notes(id) {
    // alert(id);return false;
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_action_notes',
        data: {
            id: id
        },
        success: function (result) {
            // alert(result);return false;
            $('#showNotes #notes-modal-body').html(result);
            $("#showNotes #actionid").val(id);
            $("#showNotes input#all_staffs").val($("input.action-all-staffs-" + id).val());
            $("#notecount-" + id).removeClass('label label-danger').addClass('label label-success');
            openModal('showNotes');
        }
    });
}

function show_action_files(id,staff) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_action_files',
        data: {
            id: id,
            staff : staff
        },
        success: function (result) {
            if($("#actionfilespan" + id).find("a").hasClass('label-danger')) {
                $("#actionfilespan" + id).find("a").removeClass('label-danger');
                $("#actionfilespan" + id).find("a").addClass('label-success');
            }
            $('#showFiles #files-modal-body').html(result);
            openModal('showFiles');
        }
    });
}

function show_lead_notes(id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_lead_notes',
        data: {
            id: id
        },
        success: function (result) {
            $('#showNotes #notes-modal-body').html(result);
            openModal('showNotes');
        }
    });
}

function assign_ref_partner_password(id,requested_by_staff_id) {
    $("#setpwd #hiddenid").val(id);
    $("#setpwd #staffrequestedby").val(requested_by_staff_id);
    openModal('setpwd');
}

function assign_ref_partner_to(id) {
    $("#assignto #hiddenid").val(id);
    openModal('assignto');
}

function show_ref_partner_notes(id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_ref_partner_notes',
        data: {
            id: id
        },
        success: function (result) {
            $('#showNotes #notes-modal-body').html(result);
            $('#showNotes .modal-body #lead_id').val(id);
            openModal('showNotes');
        }
    });
}

function open_contact_modal(modal_type, reference, reference_id, id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_add_contact',
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

function show_document_modal(modal_type, reference, reference_id, id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_add_document',
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

function account_modal(modal_type, id, section) {
    var reference_id = $("#reference_id").val();
    var exist_client_id=$("#exist_client_id").val();
    if ($("#editval").val() == '') {
        reference_id = $("#new_reference_id").val();
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_financial_account',
        data: {
            modal_type: modal_type,
            id: id,
            reference_id: reference_id,
            order_id: $("#editval").val(),
            section: section,
            client_id:exist_client_id
        },
        success: function (result) {
            if(result){
                $('#accounts-form').html(result).modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#bookkeeping_account_list").show();
            }else{
                $("#bookkeeping_account_list").hide();
                $("#acc_type").val('');
                $("#bank_name").val('');
                $("#acc_no").val('');
                $("#routing_no").val('');
                $("#website").val('');
                $("#user_id").val('');
                $("#password").val('');
            }
        }
    });
}
function set_exist_bookkeeping_value(account_type,bank_name,account_no,routing_no,bank_url,user,password){
    if(bank_name!='' && account_no!=''){
        $("#acc_type").val(account_type);
        $("#bank_name").val(bank_name);
        $("#acc_no").val(account_no);
        $("#routing_no").val(routing_no);
        $("#website").val(bank_url)
        $("#user_id").val(user);
        $("#password").val(password);
    }else{
        $("#acc_type").val('');
        $("#bank_name").val('');
        $("#acc_no").val('');
        $("#routing_no").val('');
        $("#website").val('');
        $("#user_id").val('');
        $("#password").val('');
    }
}

function open_owner_modal(modal_type, service_id, reference_id, reference, id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_owner_modal',
        data: {
            modal_type: modal_type,
            reference: reference,
            reference_id: reference_id,
            id: id,
            service_id: service_id
        },
        success: function (result) {
            $('#financial-account').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_payroll_approver_modal() {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_payroll_approver_modal',
        success: function (result) {
            $('#payroll-approver-form').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function openModal(id) {
    $('#' + id).modal({
        backdrop: 'static',
        keyboard: false
    });
}


/** msg modal **/
function msg_details(action_id) {
    $.ajax({
        type: "POST",
        data: {action_id: action_id},
        url: base_url + 'modal/get_msg_details',
        dataType: "html",
        success: function (result) {
            //alert(result);
            $("#showmsg #msg-modal-body").html(result);
            openModal('showmsg');
        }
    });
}

function user_details(user_id) {
    $.ajax({
        type: "POST",
        data: {user_id: user_id},
        url: base_url + 'modal/get_user_details',
        dataType: "html",
        success: function (result) {
            //alert(result);
            $("#showuserdetails #user-details-modal-body").html(result);
            openModal('showuserdetails');
        }
    });
}


function show_main_cat_modal(modal_type, source_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_main_cat_modal',
        data: {
            modal_type: modal_type,
            source_id: source_id
        },
        success: function (result) {
            $('#main-cat-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_marketing_main_cat_modal(modal_type, source_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_marketing_main_cat_modal',
        data: {
            modal_type: modal_type,
            source_id: source_id
        },
        success: function (result) {
            $('#main-cat-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_operational_main_cat_modal(modal_type, source_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_operational_main_cat_modal',
        data: {
            modal_type: modal_type,
            source_id: source_id
        },
        success: function (result) {
            $('#main-cat-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_operational_manual_modal(modal_type, source_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_operational_manual_modal',
        data: {
            modal_type: modal_type,
            source_id: source_id
        },
        success: function (result) {
            $('#manual-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_sub_cat_modal(modal_type, source_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_sub_cat_modal',
        data: {
            modal_type: modal_type,
            source_id: source_id
        },
        success: function (result) {
            $('#sub-cat-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_marketing_sub_cat_modal(modal_type, source_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_marketing_sub_cat_modal',
        data: {
            modal_type: modal_type,
            source_id: source_id
        },
        success: function (result) {
            $('#sub-cat-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_operational_sub_cat_modal(modal_type, source_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_operational_sub_cat_modal',
        data: {
            modal_type: modal_type,
            source_id: source_id
        },
        success: function (result) {
            $('#sub-cat-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function open_payment_modal(modal_type, invoice_id, service_id, order_id, due_amount, id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_payment_modal',
        data: {
            modal_type: modal_type,
            invoice_id: invoice_id,
            service_id: service_id,
            order_id: order_id,
            due_amount: due_amount,
            id: id
        },
        success: function (result) {
            $('#addPayment').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function open_refund_modal(modal_type, invoice_id, service_id, order_id, payble_amount, id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_refund_modal',
        data: {
            modal_type: modal_type,
            invoice_id: invoice_id,
            service_id: service_id,
            order_id: order_id,
            payble_amount: payble_amount,
            id: id
        },
        success: function (result) {
            $('#addRefund').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}
function show_business_client_modal(modal_type, client_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_business_client_modal',
        data: {
            modal_type: modal_type,
            client_id: client_id
        },
        success: function (result) {
            $('#business-client-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}
function show_renewal_dates_modal(modal_type, client_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_renewal_dates_modal',
        data: {
            modal_type: modal_type,
            client_id: client_id
        },
        success: function (result) {
            $('#business-client-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}
function show_sales_process_tracking_modal(id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/showSalesProcessTrackingModal',
        data: {
            id: id
        },
        success: function (result) {
            $('#modal_area').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}
function show_training_materials_attachments_modal(training_material_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/training_materials_attachments_modal',
        data: {
            training_material_id: training_material_id
        },
        success: function (result) {
            $('#modal_area').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function generate_shortcode() {
    var servicename = $("#servicename").val();
    servicename = servicename.replace("-", "");
    servicename = servicename.replace("  ", " ");
    var servicecat = $("#servicecat option:selected").text();
    var servcat_allias = servicecat.slice(0, 3).toLowerCase();
    var sp = servicename.split(' ');
    var len = sp.length;
    var i;
    var sc = '';
    for (i = 0; i < len; i++) {
        if (i == (len - 1)) {
            sc += sp[i].charAt(0).toLowerCase();
        } else {
            sc += sp[i].charAt(0).toLowerCase() + '_';
        }
    }
    sc = servcat_allias + '_' + sc;
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/check_shortname',
        data: {
            sc: sc
        },
        success: function (result) {
            if (result.trim() == 1) {
                sc = sc + '2';
                $("#servicesn").val(sc);
                $("#shorthidden").val(sc);
            } else {
                $("#servicesn").val(sc);
                $("#shorthidden").val(sc);
            }
        }
    });
}

function show_action_assign_modal(action_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_action_assign_modal',
        data: {
            action_id: action_id
        },
        success: function (result) {
            $('#modal_area').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_order_assign_modal(order_id, all_staffs) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_order_assign_modal',
        data: {
            order_id: order_id,
            all_staffs: all_staffs
        },
        success: function (result) {
            $('#modal_area').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_service_assign_modal(service_id, all_staffs) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_service_assign_modal',
        data: {
            service_id: service_id,
            all_staffs: all_staffs
        },
        success: function (result) {
            $('#modal_area').html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function show_sos(reference, service_id, staffs, order_id, service_req_id) {
    if (service_id == '') {
        service_id = '0';
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_sos',
        data: {
            reference: reference,
            service_id: service_id,
            staffs: staffs,
            order_id: order_id,
            service_req_id: service_req_id
        },
        success: function (result) {
            $("#showSos #refid").val(order_id);
            $("#showSos #serviceid").val(service_id);
            $("#showSos #staffs").val(staffs);
            $("#showSos #servreqid").val(service_req_id);
            $("#showSos #notes-modal-body").html(result);
            $('#showSos').modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function sos_filter(dashboard_type, byval) {
    var by;
    if (byval == 'byme') {
        by = 'By Me';
    } else {
        by = 'To Me';
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/sos_filter',
        data: {
            dashboard_type: dashboard_type,
            byval: byval
        },
        success: function (result) {
            if (dashboard_type == 'order') {
                $(".ajaxdiv").html(result);
                $(".filter-text").addClass('btn btn-ghost');
                $(".filter-text").html('<span class="byclass ' + byval + '">Sos ' + by + ' <a href="javascript:void(0);" onclick="clear_sos_filter();"><i class="fa fa-times" aria-hidden="true"></i></a></span>');
                $("#hiddenflag").val('');
            } else {
                $("#action_dashboard_div").html(result);
                $("[data-toggle=popover]").popover();
                $("#clear_filter").html('Sos' + by);
                $("#clear_filter").show();
                $('#btn_clear_filter').show();
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

function clear_sos_filter() {
    loadServiceDashboard('4', '', '', '', '');
    $(".filter-text").html('');
    $(".filter-text").removeClass('btn btn-ghost');
}

function clear_sos_notifications(sosids, reference, reference_id, service_id = '', task_id = '') {
    //task_id used only project releted sos
//    alert(reference_id+','+task_id);return false;
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this Notifications!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, clear it!",
        cancelButtonText: "No, cancel plz!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'POST',
                url: base_url + 'modal/clear_sos_notifications',
                data: {
                    sosids: sosids,
                    reference: reference,
                    reference_id: reference_id
                },
                success: function (result) {
                    if (reference == 'order') {
        //                $("#order" + reference_id).find(".priority").find('.m-t-5').remove();
                        $("#sosservicecount-" + reference_id).removeClass('label label-danger').addClass('label label-primary');
                        $("#sosservicecount-" + reference_id).html('<i class="fa fa-plus"></i>');
                        $('#showSos').modal('hide');
                        $('#sos-notification-div-'+ sosids).remove();
        //                goURL(base_url + 'services/home');
                    } else if (reference == 'projects') {
        //                goURL(base_url + 'project');
                        $("#projectsoscount-" + reference_id + '-' + task_id).removeClass('label label-danger').addClass('label label-primary');
                        $("#projectsoscount-" + reference_id + '-' + task_id).html('<i class="fa fa-plus"></i>');
                        $('#showSos').modal('hide');
                        $('#sos-notification-div-'+ sosids).remove();
                    } else {
                        $("#action" + reference_id).find(".priority").find('.m-t-5').remove();
        //                $("#sos-byme").html('0');
        //                $("#sos-tome").html('0');
                        $("#soscount-" + reference_id).removeClass('label label-danger').addClass('label label-primary');
                        $("#soscount-" + reference_id).html('<i class="fa fa-plus"></i>');
                        $('#showSos').modal('hide');
                        $('#sos-notification-div-'+ sosids).remove();
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

function clear_sos(sosids, reference, reference_id, service_id = '', task_id = '') {
    //task_id used only project releted sos
//    alert(reference_id+','+task_id);return false;
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/clear_sos',
        data: {
            sosids: sosids,
            reference: reference,
            reference_id: reference_id
        },
        success: function (result) {
            if (reference == 'order') {
//                $("#order" + reference_id).find(".priority").find('.m-t-5').remove();
                $("#sosservicecount-" + reference_id).removeClass('label label-danger').addClass('label label-primary');
                $("#sosservicecount-" + reference_id).html('<i class="fa fa-plus"></i>');
                $('#showSos').modal('hide');
//                goURL(base_url + 'services/home');
            } else if (reference == 'projects') {
//                goURL(base_url + 'project');
                $("#projectsoscount-" + reference_id + '-' + task_id).removeClass('label label-danger').addClass('label label-primary');
                $("#projectsoscount-" + reference_id + '-' + task_id).html('<i class="fa fa-plus"></i>');
                $('#showSos').modal('hide');
            } else {
                $("#action" + reference_id).find(".priority").find('.m-t-5').remove();
//                $("#sos-byme").html('0');
//                $("#sos-tome").html('0');
                get_sos_count(); // only effective on By Me Count              

                $("#soscount-" + reference_id).removeClass('label label-danger').addClass('label label-primary');
                $("#soscount-" + reference_id).html('<i class="fa fa-plus"></i>');
                $('#showSos').modal('hide');
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
function get_sos_count() { //to  action note count 
    $.ajax({
        url: base_url + 'action/home/sos_count',
        success: function (result) {
            $("#sos-byme").replaceWith("<span class='label label-danger'>" + result + "</span>");
        }
    });
}
function setReply(user_id) {
    $("#showSos #sos_note_form_reply_" + user_id).show();
}

function addnewSos() {
    $("#showSos #replyto").val('');
    $("#showSos #add_sos_div").show();
}
function show_task_notes(id) {
    // alert(id);return false;
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_task_notes',
        data: {
            id: id
        },
        success: function (result) {
            // alert(result);return false;
            $('#showTaskNotes #notes-modal-body').html(result);
            $("#showTaskNotes #taskid").val(id);
            $("#notecount-" + id).removeClass('label label-danger').addClass('label label-success');
            openModal('showTaskNotes');
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function show_project_notes(id) {
    // alert(id);return false;
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_project_notes',
        data: {
            id: id
        },
        success: function (result) {
            // alert(result);return false;
            $('#showProjectNotes #notes-modal-body').html(result);
            $("#showProjectNotes #project_id").val(id);
            $("#notecount-" + id).removeClass('label label-danger').addClass('label label-success');
            openModal('showProjectNotes');
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

var file_upload_action = () => {
    if (!requiredValidation('file_upload_action_modal')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("file_upload_action_modal"));
    var action_id = $("#action_id").val();
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'modal/file_upload_actions',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            // console.log(result);return false;
            var oldactionfilecount = $("#actionfile" + action_id).attr('count');
            if (result.trim() == oldactionfilecount) {
                swal("ERROR!", "Unable To Add Empty File", "error");
            } else {
                swal({title: "Success!", text: "Successfully Saved!", type: "success"}, function () {
                    // var oldactionfilecount = $("#actionfile" + action_id).attr('count');
                    // var newactionfilecount = parseInt(oldactionfilecount) + parseInt(result.trim());
                    //alert(newactionfilecount);
                    $("#actionfilespan" + action_id).html('<a class="label label-danger" href="javascript:void(0)" onclick="show_action_files(' + action_id + ')"><b>' + result + '</b></a>');
                });
            }
            document.getElementById("file_upload_action_modal").reset();
            $("#showFiles").modal('hide');
        },
        beforeSend: function () {
            $(".upload-file-butt").prop('disabled', true).html('Processing...');
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

var openActionNotificationModal = function (forvalue = '') {
    if (forvalue == '') {
        forvalue = $("#notifcation-toggle").attr('value');
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/action_notification_modal',
        data: {
            forvalue: forvalue
        },
        success: function (result) {
            if (parseInt(result.trim()) !== 0) {
                $('#action_notification_modal #notification-modal-body').html(result);
                if (forvalue == 'forother') {
                    $("#notifcation-toggle").attr('value', 'forme');
                    $(".notification_title").attr("title", "For Others");
                    $("#notification-clear").hide();
                } else {
                    $("#notifcation-toggle").attr('value', 'forother');
                    $(".notification_title").attr("title", "For Me");
                    $("#notification-clear").show();
                }

                openModal('action_notification_modal');
            } else {
                swal("ERROR!", "Notifications not found...!", "error");
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
function closeNotificationModal() {
    $("#notifcation-toggle").attr('value', 'forme');
}
var openServiceNotificationModal = function (forvalue) {
    if (forvalue == '') {
        forvalue = $("#service-notifcation-toggle").attr('value');
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/service_notification_modal',
        data: {
            forvalue: forvalue
        },
        success: function (result) {
            if (parseInt(result.trim()) !== 0) {
                $('#service_notification_modal #service-modal-body').html(result);
                if (forvalue == 'forother') {
                    $("#service-notifcation-toggle").attr('value', 'forme');
                    $(".service_title").attr('title', 'For Others');
                    $("#service-notification-clear").hide();
                } else {
                    $("#service-notifcation-toggle").attr('value', 'forother');
                    $(".service_title").attr('title', 'For Me');
                    $("#service-notification-clear").show();
                }
                openModal('service_notification_modal');
            } else {
                swal("ERROR!", "Notifications not found...!", "error");
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
function closeServiceNotificationModal() {
    $("#service-notifcation-toggle").attr('value', 'forme');
}

var openNotificationModal = function (reference, action) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/notification_modal',
        data: {
            action: action,
            reference: reference
        },
        success: function (result) {
            if (parseInt(result.trim()) !== 0) {
                $('#notification_modal #notification-modal-body').html(result);
                openModal('notification_modal');
            } else {
                swal("ERROR!", "Notifications not found...!", "error");
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

var openProjectNotificationModal = function () {
    $.ajax({
        type: 'GET',
        url: base_url + 'modal/project_notification_modal',
        success: function (result) {
            if (parseInt(result.trim()) !== 0) {
                $('#action_notification_modal #notification-modal-body').html(result);
                openModal('action_notification_modal');
            } else {
                swal("ERROR!", "Notifications not found...!", "error");
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
function sos_filter_project(dashboard_type, byval) {
    if (byval == 'byme') {
        by = 'By Me';
    } else {
        by = 'To Me';
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/sos_filter_project',
        data: {
            dashboard_type: dashboard_type,
            byval: byval
        },
        success: function (result) {
            if (dashboard_type == 'order') {
                $(".ajaxdiv").html(result);
                $(".filter-text").addClass('btn btn-ghost');
                $(".filter-text").html('<span class="byclass ' + byval + '">Sos ' + by + ' <a href="javascript:void(0);" onclick="clear_sos_filter();"><i class="fa fa-times" aria-hidden="true"></i></a></span>');
                $("#hiddenflag").val('');
            } else {
                $("#action_dashboard_div").html(result);
                $("[data-toggle=popover]").popover();
                $("#clear_filter").html('Sos' + by);
                $("#clear_filter").show();
                $('#btn_clear_filter').show();
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
function clearActionNotificationList(userid) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this Notifications!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, clear it!",
        cancelButtonText: "No, cancel plz!",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'POST',
                url: base_url + 'home/clear_notification_list',
                data: {
                    userid: userid,
                    reference: 'action'
                },
                success: function (result) {
                    if (result) {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        $('#action_notification_modal').hide();
                        goURL(base_url + 'action/home');
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
function clearServiceNotificationList(userid) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this Notifications!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, clear it!",
        cancelButtonText: "No, cancel plz!",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'POST',
                url: base_url + 'home/clear_notification_list',
                data: {
                    userid: userid,
                    reference: 'order'
                },
                success: function (result) {
                    if (result) {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        $('#service_notification_modal').hide();
                        goURL(base_url + 'services/home');
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
function readActionNotification(notificationID, reference) {
    $.ajax({
        type: 'POST',
        url: base_url + 'home/read_notification',
        data: {
            notification_id: notificationID,
            reference: reference
        },
        success: function (result) {
            if (parseInt(result.trim()) != 0) {
                openActionNotificationModal('forme');
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
function buyer_info_modal(modal_type, reference, reference_id, id) {
    $.ajax({
        type: "POST",
        data: {
            modal_type: modal_type,
            reference: reference,
            reference_id: reference_id,
            id: id
        },
        url: base_url + 'modal/buyer_info_modal',
        success: function (result) {
            $('#buyer_info_modal_div').html(result).modal({
                backdrop: 'static',
                keyboard: false
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

function seller_info_modal(modal_type, reference, reference_id, id) {
    $.ajax({
        type: "POST",
        data: {
            modal_type: modal_type,
            reference: reference,
            reference_id: reference_id,
            id: id
        },
        url: base_url + 'modal/seller_info_modal',
        success: function (result) {
            $('#seller_info_modal_div').html(result).modal({
                backdrop: 'static',
                keyboard: false
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
function sos_filter_task(dashboard_type, byval) {
    if (byval == 'byme') {
        by = 'By Me';
    } else {
        by = 'To Me';
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/sos_filter_task',
        data: {
            dashboard_type: dashboard_type,
            byval: byval
        },
        success: function (result) {
            if (dashboard_type == 'order') {
                $(".ajaxdiv").html(result);
                $(".filter-text").addClass('btn btn-ghost');
                $(".filter-text").html('<span class="byclass ' + byval + '">Sos ' + by + ' <a href="javascript:void(0);" onclick="clear_sos_filter();"><i class="fa fa-times" aria-hidden="true"></i></a></span>');
                $("#hiddenflag").val('');
            } else {
                $("#task_dashboard_div").html(result);
                $("[data-toggle=popover]").popover();
                $("#clear_filter").html('Sos' + by);
                $("#clear_filter").show();
                $('#btn_clear_filter').show();
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

function add_leads_modal(modal_type, id) {

    $.ajax({
        type: "POST",
        url: base_url + 'modal/add_lead_modal',
        data: {
            modal_type: modal_type,
            id: id
        },
        success: function (result) {
            $('#addlead-form-modal').show();
            $('#addlead-form-modal').html(result).modal({
                backdrop: 'static',
                keyboard: false
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


function save_add_leads_modal() {
    // alert("ok"); return false;
    if (!requiredValidation('add_leads_form')) {
        return false;

    }
    // alert("hi");return false;
    var form_data = new FormData(document.getElementById('add_leads_form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/event/save_add_leads_modal',
        dataType: "html",
        // enctype: 'multipart/form-data',
        cache: false,
        processData: false,
        contentType: false,
        success: function (result) {
            // console.log(result);return false;

            $.ajax({
                type: "POST",
                data: {id: result},
                url: base_url + 'lead_management/event/leads_list',
                dataType: "html",
                success: function (data) {
                    // alert(data); return false;
                    $("#leads_information").append(data);
                    $('#addlead-form-modal').modal('hide');
                },
                beforeSend: function () {
                    openLoading();
                },
                complete: function (msg) {
                    closeLoading();
                }
            });

            // addlead_info(result);
            $("#lead_id").append('<div><input type="hidden" name="lead_id[]" value=' + result + ' /></div>');
            // }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}


function update_addlead_modal(id) {
    // alert(id);return false;    
    var form_data = new FormData(document.getElementById('edit_addleads_form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/event/update_addlead_modal/' + id,
        dataType: "html",
        // enctype: 'multipart/form-data',
        cache: false,
        processData: false,
        contentType: false,
        success: function (result) {
            // console.log(result);return false;
            if (result.trim() == 1) {
                swal("Success!", "Successfully updated lead!", "success");
                $('#addlead-form-modal').modal('hide');

                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: base_url + 'lead_management/event/leads_list',
                    dataType: "html",
                    success: function (data) {
                        // alert(data); return false;
                        $("#lead_info_div_" + id).html(data);
                        // $('#addlead-form-modal').modal('hide');         
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });

                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: base_url + 'lead_management/event/show_event_edit_details',
                    dataType: "html",
                    success: function (data) {
                        $("#lead_info_div_" + id).html(data);
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });

                //   $.get(base_url + "lead_management/event/leads_list/" + id, function (data) {
                //     $("#lead_id" + id).replaceWith(data);
                //     $('#addlead-form-modal').modal('hide');
                // });

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




function show_project_task_notes(id) {
//     alert(id);return false;
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_project_task_notes',
        data: {
            id: id
        },
        success: function (result) {
//             alert(result);return false;
            $('#showProjectTaskNotes #notes-modal-body').html(result);
            $("#showProjectTaskNotes #taskid").val(id);
            $("#notecount-" + id).removeClass('label label-danger').addClass('label label-success');
            openModal('showProjectTaskNotes');
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function show_task_files(id,staff) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_task_files',
        data: {
            id: id,
            staff : staff
        },
        success: function (result) {
            if($("#taskfilespan" + id).find("a").hasClass('label-danger')) {
                $("#taskfilespan" + id).find("a").removeClass('label-danger');
                $("#taskfilespan" + id).find("a").addClass('label-success');
            }
            $('#showTaskFiles #files-modal-body').html(result);
            openModal('showTaskFiles');
        }
    });
}
var file_upload_task = () => {
    if (!requiredValidation('file_upload_task_modal')) {
        return false;
    }
    var form_data = new FormData(document.getElementById("file_upload_task_modal"));
    var task_id = $("#task_id").val();
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'modal/file_upload_task',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            // console.log(result);return false;
            var oldactionfilecount = $("#taskfile" + task_id).attr('count');
            if (result.trim() == oldactionfilecount) {
                swal("ERROR!", "Unable To Add Empty File", "error");
            } else {
                swal({title: "Success!", text: "Successfully Saved!", type: "success"}, function () {
                    // var oldactionfilecount = $("#actionfile" + action_id).attr('count');
                    // var newactionfilecount = parseInt(oldactionfilecount) + parseInt(result.trim());
                    //alert(newactionfilecount);
                    $("#taskfilespan" + task_id).html('<a class="label label-danger" href="javascript:void(0)" onclick="show_task_files(' + task_id + ')"><b>' + result + '</b></a>');
                });
            }
            document.getElementById("file_upload_task_modal").reset();
            $("#showTaskFiles").modal('hide');
        },
        beforeSend: function () {
            $(".upload-file-butt").prop('disabled', true).html('Processing...');
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}