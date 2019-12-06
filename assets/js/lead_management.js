var base_url = document.getElementById('base_url').value;

function add_lead_type() {
    if (!requiredValidation('add-lead-type-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('add-lead-type-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/Lead_type/add_lead_type',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Lead Type Successfully Added!", type: "success"}, function () {
                    goURL(base_url + 'lead_management/lead_type');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Lead Type", "error");
            } else {
                swal("ERROR!", "Lead Type Already Exists", "error");
            }
        }
    });

}

function edit_lead_type() {
    if (!requiredValidation('edit-lead-type-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('edit-lead-type-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/Lead_type/edit_lead_type',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Lead Type Name Successfully Updated!", type: "success"}, function () {
                    goURL(base_url + 'lead_management/lead_type');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Update Lead Type Name", "error");
            } else {
                swal("ERROR!", "Lead Type Name Already Exists", "error");
            }
        }
    });
}

function delete_lead_type(lead_id) {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this lead type!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'lead_management/Lead_type/delete_lead_type',
                    data: {
                        lead_id: lead_id
                    },
                    success: function (result) {
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "lead type been deleted successfully!",
                                "type": "success"
                            }, function () {
                                goURL(base_url + 'lead_management/lead_type');
                            });
                        } else {
                            swal("ERROR!", "Unable to delete this lead type!!", "error");
                        }
                    }
                });
            });
}

function add_lead_ref() {
    if (!requiredValidation('add-lead-ref-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('add-lead-ref-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'partners/add_ref',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Lead Reference Successfully Added!", type: "success"}, function () {
                    goURL(base_url + 'partners/referral_agent_type');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Lead Reference", "error");
            } else {
                swal("ERROR!", "Lead Reference Already Exists", "error");
            }
        }
    });

}

function edit_lead_ref() {
    if (!requiredValidation('edit-lead-ref-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('edit-lead-ref-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'partners/edit_ref',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({
                    title: "Success!",
                    text: "Lead Reference Name Successfully Updated!",
                    type: "success"
                }, function () {
                    goURL(base_url + 'partners/referral_agent_type');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Update Lead reference Name", "error");
            } else {
                swal("ERROR!", "Lead reference Name Already Exists", "error");
            }
        }
    });
}

function delete_lead_ref(lead_id) {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this lead reference!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'partners/delete_ref',
                    data: {
                        lead_id: lead_id
                    },
                    success: function (result) {
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "lead reference been deleted successfully!",
                                "type": "success"
                            }, function () {
                                goURL(base_url + 'partners/referral_agent_type');
                            });
                        } else {
                            swal("ERROR!", "Unable to delete this lead reference!!", "error");
                        }
                    }
                });
            });
}

function add_lead_source() {
    if (!requiredValidation('add-lead-source-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('add-lead-source-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/lead_source/add_lead_source',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Lead Source Successfully Added!", type: "success"}, function () {
                    goURL(base_url + 'lead_management/lead_source');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Lead Source", "error");
            } else {
                swal("ERROR!", "Lead Source Already Exists", "error");
            }
        }
    });

}

function edit_lead_source() {
    if (!requiredValidation('edit-lead-source-form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('edit-lead-source-form'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/lead_source/edit_lead_source',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Lead Source Name Successfully Updated!", type: "success"}, function () {
                    goURL(base_url + 'lead_management/lead_source');
                });
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Update Lead Source Name", "error");
            } else {
                swal("ERROR!", "Lead Source Name Already Exists", "error");
            }
        }
    });
}

function delete_lead_source(source_id) {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this lead source!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'lead_management/lead_source/delete_lead_source',
                    data: {
                        source_id: source_id
                    },
                    success: function (result) {
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "Lead Source Been Deleted Successfully!",
                                "type": "success"
                            }, function () {
                                goURL(base_url + 'lead_management/lead_source');
                            });
                        } else {
                            swal("ERROR!", "Unable To Delete This Lead Source!!", "error");
                        }
                    }
                });
            });
}

function confirm_sender_email(added_by, event_lead = "") {
    if (!requiredValidation('form_add_new_prospect')) {
        return false;
    }
    var mail_camapign_status = $("#mail_campaign_status").val();
    if (mail_camapign_status == '1') {
        openModal('mail-campaign-confirm');
    } else {
        add_lead_prospect(added_by, event_lead);
}
}

function add_lead_prospect(added_by, event_lead = "",refer_lead="") {
    var form_data = new FormData(document.getElementById('form_add_new_prospect'));
    form_data.append('added_by', added_by);
    if ($('input[name="sender_email"]:checked').val() != 'undefined') {
        form_data.append('sender_email', $('input[name="sender_email"]:checked').val());
    }
    if (refer_lead != "") {
        form_data.append('refer_lead', refer_lead);
    }
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/new_prospect/insert_new_prospect',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "0") {
                swal("ERROR!", "Email Already Exists For This Partner Lead!! Please Change the Email", "error");
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Lead Prospect", "error");
            } else {
                swal({title: "Success!", text: "Lead Prospect Successfully Added!", type: "success"}, function () {
                    if (added_by == 'refagent') {
                        goURL(base_url + 'referral_partner/referral_partners/referral_partner_dashboard');
                    } else if (event_lead == "event_lead") {
                        goURL(base_url + 'lead_management/event');
                    } else {
                        goURL(base_url + 'lead_management/home');
                    }
                });
                // window.open((($('#mail_campaign_status').val() != 0) ? base_url + 'lead_management/home/mail_campaign/y/' + result.trim() : base_url + 'lead_management/home/mail_campaign/n/' + result.trim()), 'Mail Campaign Popup', "width=1080, height=480, top=100, left=170, scrollbars=no");
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

function cancel_lead_prospect(added_by) {
    if (added_by == 'refagent') {
        goURL(base_url + 'referral_partner/referral_partners/referral_partner_dashboard');
    } else if(added_by == 'ref_cancel') {
        goURL(base_url + 'referral_partner/referral_partners/referral_partner_dashboard');
    } else {
        goURL(base_url + 'lead_management/home');
    }
}

function add_lead_referral(partner) {
    if (!requiredValidation('form_add_new_referral')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('form_add_new_referral'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'partners/insert_new_referral',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "0") {
                swal("ERROR!", "Lead Prospect Already Referral", "error");
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Add Lead Referral", "error");
            } else {
                if (partner != '') {
                    swal({title: "Success!", text: "Referral Partner Successfully Added!", type: "success"}, function () {
                        goURL(base_url + 'referral_partner/referral_partners/partners');
                    });
                } else {
                    swal({title: "Success!", text: "Lead Referral Successfully Added!", type: "success"}, function () {
                        goURL(base_url + 'lead_management/home');
                    });
                }
                // window.open((($('#mail_campaign_status').val() != 0) ? base_url + 'lead_management/home/mail_campaign/y/' + result.trim() : base_url + 'lead_management/home/mail_campaign/n/' + result.trim()), 'Mail Campaign Popup', "width=1080, height=480, top=100, left=170, scrollbars=no");
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

function cancel_save_lead_mail() {
    goURL(base_url + 'lead_management/lead_mail');
}


function save_lead_mail() {
    if (!requiredValidation('form_save_lead_mail')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('form_save_lead_mail'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/lead_mail/insert_mail_content',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Mail Content Successfully Saved", type: "success"}, function () {
                    goURL(base_url + 'lead_management/lead_mail');
                });
            } else {
                swal("ERROR!", "Some Error Occured", "error");
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

function cancel_save_lead_mail_campaign() {
    goURL(base_url + 'lead_management/lead_mail/lead_mail_campaign');
}

function save_lead_mail_campaign() {
    if (!requiredValidation('form_save_lead_mail')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('form_save_lead_mail'));

    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/lead_mail/insert_mail_campaign_content',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Mail Content Successfully Saved", type: "success"}, function () {
                    goURL(base_url + 'lead_management/lead_mail/lead_mail_campaign');
                });
            } else {
                swal("ERROR!", "Some Error Occured", "error");
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

function delete_lead_mail(id) {
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
                    url: base_url + '/lead_management/lead_mail/delete_lead_mail',
                    data: {
                        id: id
                    },
                    success: function (result) {
                        //alert(result);
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "Email deleted successfully!",
                                "type": "success"
                            }, function () {
                                goURL(base_url + '/lead_management/lead_mail');
                            });
                        } else {
                            swal("ERROR!", "Unable to delete the Email", "error");
                        }
                    }
                });
            });
}

function delete_mail_campaign(id) {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this mail!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'lead_management/lead_mail/delete_mail_campaign',
                    data: {
                        id: id
                    },
                    success: function (result) {
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "Mail has been deleted successfully!",
                                "type": "success"
                            }, function () {
                                goURL(base_url + 'lead_management/lead_mail/lead_mail_campaign');
                            });
                        } else {
                            swal("ERROR!", "Unable to delete this Mail!!", "error");
                        }
                    }
                });
            });
}

function load_campaign_mails(leadtype, language, day, status) {
    $.ajax({
        type: 'POST',
        url: base_url + 'lead_management/lead_mail/load_campaign_mails',
        data: {
            leadtype: leadtype, language: language, day: day, status: status
        },
        success: function (result) {
            $("#load_data").html(result);
        }
    });
}


function displayMailCampaignTemplate(leadID, day, isCampaign) {
    $.ajax({
        type: 'POST',
        url: base_url + 'lead_management/lead_mail/mail_campaign_template_ajax',
        data: {
            lead_id: leadID,
            day: day,
            is_campaign: isCampaign
        },
        success: function (result) {
            if (result != 0) {
                var mail_campaign = JSON.parse(result);
                $('#mail-subject').html(mail_campaign.subject);
                $('#mail-body').html(mail_campaign.body);
                $('#mail-campaign-template-modal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            } else {
                swal("ERROR!", "Lead mail not avalable...!", "error");
            }
        }
    });
}

function viewMailCampaignTemplate(leadType, language, day, firstName, companyName, phone, email,contactType,office,first_contact_date,lead_source,source_details) {
    $.ajax({
        type: 'POST',
        url: base_url + 'lead_management/lead_mail/show_mail_campaign_template_ajax',
        data: {
            leadtype: leadType,
            language: language,
            day: day,
            first_name: firstName,
            company_name: companyName,
            phone: phone,
            email: email,
            type_of_contact : contactType,
            office:office,
            first_contact_date :first_contact_date,
            lead_source : lead_source,
            source_details : source_details 
        },
        success: function (result) {
            if (result != 0) {
                var mail_campaign = JSON.parse(result);
//                console.log(mail_campaign);
                $('#mail-subject').html(mail_campaign.subject);
                $('#mail-body').html(mail_campaign.body);
                $('#mail-campaign-template-modal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            } else {
                swal("ERROR!", "Lead mail not avalable...!", "error");
            }
        }
    });
}

function loadLeadDashboard(leadType, status, requestBy, leadContactType, eventID = '') {
    if (leadType == '') {
        $("#btn_clear_filter").hide();
    }
    $.ajax({
        type: "POST",
        data: {
            lead_type: leadType,
            status: status,
            request_by: requestBy,
            lead_contact_type: leadContactType,
            event_id: eventID
        },
        url: base_url + 'lead_management/home/dashboard_ajax',
        success: function (lead_result) {
            // console.log(action_result);
            $("#lead_dashboard_div").html(lead_result);
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function loadEventDashboard() {
    $.ajax({
        type: "POST",
        url: base_url + 'lead_management/event/index',
        success: function () {
            $("#event_dashboard_div").hide();
            $("#event_dashboard_div2").show();
            // $("#btn_clear_filter").hide();
            $(".variable-dropdown").val('');
            $(".condition-dropdown").val('').removeAttr('disabled');
            $(".criteria-dropdown").val('');
            $('.criteria-dropdown').removeAttr('readonly').empty().append('<option value="">All Criteria</option>');
            $(".criteria-dropdown").trigger("chosen:updated");
            $('form#filter-form').children('div.filter-inner').children('div.filter-div').not(':first').remove();
            $('#btn_clear_filter').css('display', 'none');

            $(".sort_type_div #sort-desc").hide();
            $(".sort_type_div #sort-asc").css({display: 'inline-block'});
            $("#sort-by-dropdown").html('Sort By <span class="caret"></span>');
            $('.sort_type_div').css('display', 'none');
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function loadStaffDLLValue(officeID, staffID) {
    $.ajax({
        type: "POST",
        data: {
            office_id: officeID
        },
        url: base_url + 'services/home/load_partner_manager',
        dataType: "html",
        success: function (result) {
            var lead_staff = document.getElementById('lead_staff');
            lead_staff.innerHTML = "";
            if (result != 0) {
                var staff = JSON.parse(result);
                lead_staff.options[lead_staff.options.length] = new Option("Select an option", "");
                for (var i = 0; i < staff.length; i++) {
                    lead_staff.options[lead_staff.options.length] = new Option(staff[i].name, staff[i].id);
                }
                if (staffID != '') {
                    $('#lead_staff').val(staffID);
                }
            } else {
                lead_staff.options[lead_staff.options.length] = new Option("Select an option", "");
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

function changeCampaignStatus(leadtype, language, status) {
    swal({
        title: 'Are you sure?',
        text: "You want to " + (status == 0 ? 'In' : '') + "active!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Change!'
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                data: {
                    leadtype: leadtype,
                    language: language,
                    status: status
                },
                url: base_url + 'lead_management/home/change_mail_campaign_status',
                dataType: "html",
                success: function (result) {
                    if (result != 0) {
                        swal("Success!", "Successfully " + (status == 0 ? 'In' : '') + "actived!", "success");
                        goURL(base_url + 'lead_management/lead_mail/lead_mail_campaign');
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

function leadFilter() {
    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/home/lead_filter',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result);
            $("#lead_dashboard_div").html(result);
            $("[data-toggle=popover]").popover();
//            $("#clear_filter").show();
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

var delete_lead_management = (id) => {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this lead management!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'lead_management/home/delete_lead',
                    data: {
                        id: id
                    },
                    success: function (result) {
                        // alert(result);
                        if (result == "1") {
                            swal({
                                title: "Success!",
                                "text": "Lead Management been deleted successfully!",
                                "type": "success"
                            }, function () {
                                goURL(base_url + 'lead_management/home');
                            });
                        } else {
                            swal("ERROR!", "Unable to delete this Lead Management!!", "error");
                        }
                    }
                });
            });
}

function add_event() {
    if (!requiredValidation('form_add_new_event')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('form_add_new_event'));
    // console.log(form_data);return false;
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/event/insert_new_event',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            // alert(result);return false;
            if (result == 1) {
                swal("Success!", "Event Added Successfully", "success");
                goURL(base_url + 'lead_management/event');
            } else {
                swal("ERROR!", "Unable To Add Event", "error");
            }
        },
        beforeSend: function () {
            $("#eventadd").prop('disabled', true).html('Processing...');
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });

}

// function change_zip_by_country(val) {
//     if (val == '230') {
//         $("#zip_div").show();
//     } else {
//         $("#zip_div").hide();
//     }
// }

var mail_campaign_status_change = (id, value) => {
    $.ajax({
        type: "POST",
        data: {
            id: id,
            value: value
        },
        url: base_url + 'lead_management/home/change_tracking_status',
        dataType: "html",
        success: function (result) {
            if (result == 1) {
                swal("Success!", "Tracking is Actived Now", "success");
            }
        },
    });
}
function open_client_assign_popup(id, partner_id) { 
    var url = base_url + 'lead_management/home/assignment_form/'+ id + '/' + partner_id;
    window.open(url, 'Assignment Form', "width=1200, height=600, top=100, left=110, scrollbars=yes");
}

function assign_as_client(id, partner_id) {
    $.ajax({
        type: "POST",
        data: {
            id: id,
            partner_id: partner_id
        },
        url: base_url + 'lead_management/home/assign_lead_as_client',
        dataType: "html",
        success: function (result) {
            if (result == 1) {
                $("#assign_as_client-" + id).replaceWith('<a href="javascript:void(0);" class="btn btn-warning btn-xs btn-assign-client"> Assigned as Client</a>');
                swal("Success!", "Successfully Assigned as Client", "success");
            }
        },
    });
}

function assign_as_partner(id) {
    $.ajax({
        type: "POST",
        data: {
            id: id
        },
        url: base_url + 'lead_management/home/assign_lead_as_partner',
        dataType: "html",
        success: function (result) {
            if (result == 1) {
                $("#assign_as_partner-" + id).replaceWith('<a href="javascript:void(0);" class="btn btn-warning btn-xs btn-assign-client"> Assigned as Partner</a>');
                // $("#lead-" +id).hide();
                swal("Success!", "Successfully Assigned as Partner", "success");
            }
        },
    });
}
function update_event(id) {
    // alert(id);return false;   
    var form_data = new FormData(document.getElementById('event_modal_form_submit'));
    $.ajax({
        type: 'POST',
        url: base_url + 'lead_management/event/update_event/' + id,
        data: form_data,
        processData: false,
        contentType: false,
        success: function (result) {
            // alert(result);return false;
            if (result.trim() == 1) {
                swal("Success!", "Successfully updated event!", "success");
                $("#event-form-modal").modal('hide');
                goURL(base_url + 'lead_management/event');

            } else {
                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
            }

        },
        beforeSend: function () {
            $("#eventupdate").prop('disabled', true).html('Processing...');
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function sort_lead_dashboard(sort_criteria = '', sort_type = '') {
    var form_data = new FormData(document.getElementById('filter-form'));
    if (sort_criteria == '') {
        var sc = $('.dropdown-menu li.active').find('a').attr('id');
        var ex = sc.split('-');

        if (ex[0] == 'office_id' || ex[0] == 'client_name') {
            var sort_criteria = ex[0];
        } else {
            var sort_criteria = 'lm.' + ex[0];
        }
    }
    if (sort_type == '') {
        var sort_type = 'ASC';
    }
    if (sort_criteria.indexOf('.') > -1) {
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
        url: base_url + 'lead_management/home/sort_lead_dashboard',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (lead_result) {
            if (lead_result.trim() != '') {
                $("#lead_dashboard_div").html(lead_result);
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
                var textval = 'Sort By : ' + text + ' <span class="caret"></span>';
                $("#sort-by-dropdown").html(textval);
                $("[data-toggle=popover]").popover();
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

function change_type_of_contact(lead_type) {
    $.ajax({
        type: "POST",
        data: {
            lead_type: lead_type
        },
        url: base_url + 'lead_management/home/get_typeof_contact',
        dataType: "html",
        success: function (result) {
            var type_contact_list = document.getElementById('contact_type');
            type_contact_list.innerHTML = "";
            if (result != 0) {
                var lead = JSON.parse(result);
                // type_contact_list.options[type_contact_list.options.length] = new Option("Select an option", "");
                for (var i = 0; i < lead.length; i++) {
                    type_contact_list.options[type_contact_list.options.length] = new Option(lead[i].name, lead[i].id);
                }
            } else {
                type_contact_list.options[type_contact_list.options.length] = new Option("Select an option", "");
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


function eventFilter() {
    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/event/event_filter',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            // alert(result); return false;
            $("#event_dashboard_div").show();
            $("#event_dashboard_div").html(result);
            $("#event_dashboard_div2").hide();
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

function sortEventDashboard(sortCriteria = '', sortType = '') {
    var form_data = new FormData(document.getElementById('filter-form'));
    if (sortCriteria == '') {
        var sc = $('.dropdown-menu li.active').find('a').attr('id');
        sc = sc.split('-');
        sortCriteria = sc[0];
    }
    form_data.append('sort_criteria', sortCriteria);
    form_data.append('sort_type', sortType);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'lead_management/event/sort_event',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            // alert(result);return false;
            $("#event_dashboard_div2").hide();
            $("#event_dashboard_div").show();
            $("#event_dashboard_div").html(result);
            $(".dropdown-menu li").removeClass('active');
            $("#" + sortCriteria + "-sorting").parent('li').addClass('active');
            if (sortType == 'ASC') {
                $(".sort_type_div #sort-desc").hide();
                $(".sort_type_div #sort-asc").css({display: 'inline-block'});
            } else {
                $(".sort_type_div #sort-asc").hide();
                $(".sort_type_div #sort-desc").css({display: 'inline-block'});
            }
            $(".sort_type_div").css({display: 'inline-block'});
            var text = $('.dropdown-menu li.active').find('a').text();
            var textval = 'Sort By : ' + text + ' <span class="caret"></span>';
            $("#sort-by-dropdown").html(textval);
            $("[data-toggle=popover]").popover();
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function change_mail_campaign_status(id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'lead_management/home/change_mail_campaign_status_by_type',
        data: {
            id: id
        },
        cache: false,
        success: function (result) {
            $("#mail-campaign-modal").html(result).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });

}

function show_confirm_email_div(status) {
    if (status == 0) {
        $("#confirm_email_div").hide();
    } else {
        $("#confirm_email_div").show();
    }
}

function update_mail_campaign_status_lead () {
    var email_confimation_status = $("input[name=lead_email]:checked").val();

    if (email_confimation_status == 'other') {
        if (!requiredValidation('change_mail_campaign_status_modal')) {
            return false;
        }    
    }
    var form_data = new FormData(document.getElementById('change_mail_campaign_status_modal'));
    
    $.ajax({
        type: 'POST',
        url: base_url + 'lead_management/home/change_mail_campaign_status_lead',
        data: form_data,
        dataType: "html",
        processData: false,
        contentType: false,
        cache: false,
        success: function (result) {
            if (result.trim() == "0") {
                goURL(base_url + 'lead_management/home');
            } else if (result.trim() == "1") {
                swal({title: "Success!", text: "Mail Campaign Activated Successfully!", type: "success"}, function () {
                    goURL(base_url + 'lead_management/home');
                });
            } else if (result.trim() == "-1") {
                swal({title: "Success!", text: "Mail Campaign Inactivated Successfully!", type: "success"}, function () {
                    goURL(base_url + 'lead_management/home');
                });                
            } else {
                swal("ERROR!", "Unable to change mail campaign status!", "error");
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