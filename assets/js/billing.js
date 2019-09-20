var base_url = document.getElementById('base_url').value;
function saveDocument() {
    if (!requiredValidation('form_add_document')) {
        return false;
    }
    var formData = new FormData(document.getElementById('form_add_document'));
    $.ajax({
        type: 'POST',
        url: base_url + 'billing/home/request_save_document',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
//            alert(result);return false;
            console.log("Result: " + result);
            if (result != 0) {
//                alert('Hi');
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'billing/home/documents');
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

function getServiceDropdownByCategory(category_id, service_id, section_id) {
    if (category_id == '') {
        $('#service_dropdown_div_' + section_id + ', #service_div_' + section_id).html('');
    } else {
        $.ajax({
            type: "POST",
            data: {
                category_id: category_id,
                service_id: service_id,
                section_id: section_id
            },
            url: base_url + 'billing/invoice/get_service_dropdown_by_category_id',
            dataType: "html",
            success: function (result) {
//                console.log(result);
                if (result != '0') {
                    $('#service_dropdown_div_' + section_id).html(result);
                    if (service_id == '') {
                        $('#service_div_' + section_id).html('');
                    }
                } else {
                    $('#service_dropdown_div_' + section_id + ', #service_div_' + section_id).html('');
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
}

function getServiceInfoById(service_id, category_id, section_id) {
    if (category_id == '' && service_id == '') {
        $('#service_div').html('');
    } else {
        $.ajax({
            type: "POST",
            data: {
                service_id: service_id,
                section_id: section_id
            },
            url: base_url + 'billing/invoice/get_service_info_by_id',
            dataType: "html",
            success: function (result) {
//                console.log(result);
                if (result != '0') {
                    $('#service_div_' + section_id).html(result);
                } else {
                    $('#service_div_' + section_id).html('');
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
}


function addService() {
    var section_id = $('#section_id').val();
    $.ajax({
        type: "POST",
        url: base_url + 'billing/invoice/add_service',
        data: {
            section_id: section_id
        },
        dataType: "html",
        success: function (result) {
            if (result != '0') {
                var obj = $.parseJSON(result);
                var newHtml = obj.section_result;
                if (obj.last_section_id == 'new') {
                    $('#service_section_div').html(newHtml);
                } else {
                    var section_link = $('#section_link_' + obj.last_section_id);
                    section_link.attr('onclick', 'removeService(' + obj.last_section_id + ');');
                    section_link.removeClass('text-success');
                    section_link.addClass('text-danger');
                    section_link.html('<h3><i class="fa fa-times"></i> Remove Service</h3>');
                    section_link.blur();
                    $(newHtml).insertAfter($('#service_result_div_' + obj.last_section_id));
                }
                $('#section_id').val(obj.section_id_hidden);
            } else {
                $('#service_section_div').html('');
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

function showExistingServices() {
    var invoice_id = $('#editval').val();
    $.ajax({
        type: "POST",
        url: base_url + 'billing/invoice/show_existing_services',
        data: {
            invoice_id: invoice_id
        },
        dataType: "html",
        success: function (result) {
//            alert(result);
            if (result != '0') {
                var obj = $.parseJSON(result);
                var newHtml = decodeURI(obj.section_result);
//                alert(newHtml);
                $('#service_section_div').html(newHtml);
                $('#section_id').val(obj.section_id_hidden);
//                addService();
            } else {
                $('#service_section_div').html('');
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


function removeService(remove_id) {
    var section_id = $('#section_id').val();
    $.ajax({
        type: "POST",
        url: base_url + 'billing/invoice/remove_service',
        data: {
            section_id: section_id,
            remove_id: remove_id
        },
        dataType: "html",
        success: function (result) {
            if (result != '0') {
                if (result == 'blank') {
                    $('#section_id').val('');
                } else {
                    $('#section_id').val(result);
                }
                $("#service_result_div_" + remove_id).remove();
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

function addNote(section_id, is_label = 'y') {
    var textnote = $('#note_link_' + section_id).prev('.note-textarea-' + section_id).html();
    var div_count = Math.floor((Math.random() * 999) + 1);
    var newHtml = '';
    if (is_label === 'n') {
        newHtml = '<div class="form-group" id="note_div_' + section_id + '_' + div_count + '"> ' +
                textnote +
                '<a href="javascript:void(0)" onclick="removeNote(\'note_div_' + section_id + '_' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a>' +
                '</div>';
    } else {
        newHtml = '<div class="form-group" id="note_div_' + section_id + '_' + div_count + '"> ' +
                '<label class="col-lg-2 control-label"></label>' +
                '<div class="col-lg-10">' +
                textnote +
                '<a href="javascript:void(0)" onclick="removeNote(\'note_div_' + section_id + '_' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a>' +
                '</div>' +
                '</div>';
    }
    $(newHtml).insertAfter($('#note_link_' + section_id).closest('.form-group'));
}

function saveInvoice() {
    if (!requiredValidation('form_create_invoice')) {
        return false;
    }
    company_type_enable();
    var editval = $("#editval").val();
    if (editval != '') {
        $('.disabled_field').removeAttr('disabled');
    }
    var form_data = new FormData(document.getElementById('form_create_invoice'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'billing/invoice/request_create_invoice',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//             console.log(result); return false;
            if (editval == '') {
                if (result != 0) {
                    goURL(base_url + 'billing/invoice/place/' + result);
                } else {
                    swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
                }
            } else {
                if (result != 0) {
                    swal({
                        title: "Success!",
                        text: "Successfully updated invoice!",
                        type: "success"
                    }, function () {
                        if ($("#edit_type").val() == 'edit_place') {
                            goURL(base_url + 'billing/invoice/place/' + result);
                        } else {
                            goURL(base_url + 'billing/home');
                        }
                    });
                } else {
                    swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
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
}
function placeOrder(invoice_id, emails) {
    $.ajax({
        type: "POST",
        data: {
            invoice_id: invoice_id,
            emails: emails
        },
        url: base_url + 'modal/show_invoice_email_modal',
        dataType: "html",
        success: function (result) {
            $('#emailsending').show();
            $("#emailsending").html(result).modal({
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


function sendInvoiceEmail() {
    if (!requiredValidation('invoice_email_form')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('invoice_email_form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'billing/invoice/export',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result != 0) {
                swal("Wel Done!", "Successfully send your mail!", "success");
                $('#emailsending').modal('hide');
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


function printOrder() {
    var doPrint = window.open();
    var printHtml = '<style type="text/css">body {background: #fff !important;} *{ font-size: 13px;}</style>';
    printHtml = printHtml + $('.order_summary').html();
    doPrint.document.write(printHtml);
    doPrint.print();
    doPrint.close();
}
function loadBillingDashboard(status = '', by = '', office = '', payment_status = '', reference_id = '') {
    $.ajax({
        type: "POST",
        url: base_url + 'billing/home/dashboard_ajax',
        data: {
            status: status,
            by: by,
            office: office,
            payment_status: payment_status,
            reference_id: reference_id
        },
        dataType: "html",
        success: function (result) {
            if (result != '0') {
                $('#dashboard_result_div').html(result);
                $('.dropdown-menu li.active').removeClass('active');
                $(".sort_type_div #sort-desc").hide();
                $(".sort_type_div #sort-asc").css({display: 'inline-block'});
                $("#sort-by-dropdown").html('Sort By <span class="caret"></span>');
                $('.sort_type_div').css('display', 'none');
                $(".variable-dropdown").val('');
                $(".condition-dropdown").val('');
                $(".criteria-dropdown").val('');
                $('.criteria-dropdown').empty().append('<option value="">All Criteria</option>');
                $(".criteria-dropdown").trigger("chosen:updated");
                $('#btn_clear_filter').css('display', 'none');
                $("a.filter-button span:contains('-')").html(0);
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

//var processing;
//$(document).scroll(function (e) {
//    if (processing) {
//        return false;
//    }
//    if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
//        processing = true;
//        $.post('/echo/html/', 'html=<div class="loadedcontent">new div</div>', function (data) {
//            $('#container').append(data);
//            processing = false;
//        });
//    }
//});
function getInvoiceServiceList(invoiceID) {
    $.ajax({
        type: "POST",
        url: base_url + 'billing/home/invoice_service_list_ajax',
        data: {
            invoice_id: invoiceID
        },
        dataType: "html",
        success: function (result) {
            if (result != '0') {
                $('#dashboard_result_div').html(result);
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

function billingDashboardNoteModal(order_id, service_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'billing/home/billing_dashboard_note_ajax',
        data: {
            order_id: order_id,
            service_id: service_id
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result != '0') {
                var notes = JSON.parse(result);
                var resultHTML = '';
                for (var i = 0; i < notes.length; i++) {
                    resultHTML += '<div class="form-group"><div class="col-lg-12"><div class="note-textarea">';
                    resultHTML += '<textarea readonly="readonly" style="resize: none;" class="form-control" title="Invoice Service Note">' + notes[i].note + '</textarea>';
                    resultHTML += '</div></div></div>';
                }
                $('#note-body-div').html(resultHTML);
                $('#showNotes').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            } else {
                $('#note-body-div').html('');
                $('#showNotes').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        }
    });
}

function billingDashboardTrackingModal(invoice_id, status) {
    openModal('change_status_billing_div');
    var txt = 'Change Status of SubOrder id #' + invoice_id;
    $("#changeStatusinner .modal-title").html(txt);
    if (status == 1) {
        $("#change_status_billing_div #rad1").prop('checked', true);
        $("#change_status_billing_div #rad2").prop('checked', false);
        $("#change_status_billing_div #rad3").prop('checked', false);
        $("#change_status_billing_div #rad7").prop('checked', false);
    } else if (status == 2) {
        $("#change_status_billing_div #rad1").prop('checked', false);
        $("#change_status_billing_div #rad2").prop('checked', true);
        $("#change_status_billing_div #rad3").prop('checked', false);
        $("#change_status_billing_div #rad7").prop('checked', false);
    } else if (status == 3) {
        $("#change_status_billing_div #rad1").prop('checked', false);
        $("#change_status_billing_div #rad2").prop('checked', false);
        $("#change_status_billing_div #rad3").prop('checked', true);
        $("#change_status_billing_div #rad7").prop('checked', false);
    } else if (status == 7) {
        $("#change_status_billing_div #rad1").prop('checked', false);
        $("#change_status_billing_div #rad2").prop('checked', false);
        $("#change_status_billing_div #rad3").prop('checked', false);
        $("#change_status_billing_div #rad7").prop('checked', true);
    }
    $("#change_status_billing_div #current_status").val(status);
    $.get(base_url + "billing/home/get_tracking_log/" + invoice_id + "/invoice_info", function (data) {
        $("#status_log > tbody > tr").remove();
        var returnedData = JSON.parse(data);
        var trackingList = returnedData.tracking_list;
        for (var i = 0, l = trackingList.length; i < l; i++) {
            $('#status_log > tbody:last-child').append("<tr><td>" + trackingList[i]["stuff_id"] + "</td>" + "<td>" + trackingList[i]["department"] + "</td>" + "<td>" + trackingList[i]["status"] + "</td>" + "<td>" + trackingList[i]["created_time"] + "</td></tr>");
        }
        if (returnedData.disabled == 'y') {
            $('input[type="radio"]:not(:checked)').prop('disabled', true);
        } else {
            $('input[type="radio"]:not(:checked)').prop('disabled', false);
        }
        if (trackingList.length >= 1)
            $("#log_modal").show();
        else
            $("#log_modal").hide();
    });
    $("#invoice_id").val(invoice_id);
}

function updateStatusBilling() {
    var status = $('#change_status_billing_div input:radio[name=radio]:checked').val();
    var invoice_id = $('#change_status_billing_div #invoice_id').val();
    var status_value = $('#change_status_billing_div input:radio[name=radio]:checked').parent().find('strong').html();
    var current_status = parseInt($("#change_status_billing_div #current_status").val());
    var status_class_array = [
        'label-danger',
        'label-success',
        'label-yellow',
        'label-primary'
    ];
    $.ajax({
        type: "POST",
        data: {
            status: status,
            invoice_id: invoice_id
        },
        url: base_url + 'billing/home/update_billing_status',
        dataType: "html",
        success: function (result) {
            if (result.trim() != 0) {
                $('.invoice-tracking-span-' + invoice_id + ' b').html(status_value);
                $('.invoice-tracking-span-' + invoice_id).removeClass(current_status === 7 ? status_class_array[0] : status_class_array[current_status]);
                $('.invoice-tracking-span-' + invoice_id).addClass(status === 7 ? status_class_array[0] : status_class_array[status]);
                $('.invoice-tracking-span-' + invoice_id).parent('a').attr('onclick', 'billingDashboardTrackingModal(' + invoice_id + ',' + status + ');');
                $("#change_status_billing_div").modal('hide');
//                goURL(base_url + 'billing/home');
            }
        }
    });
}

function buyService() {
    $.ajax({
        type: "POST",
        url: base_url + 'billing/invoice/export',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            alert(result);
//            return false;
//            console.log("Result: " + result);
//            if (result != 0) {
//                swal("Success!", "Successfully saved!", "success");
//                goURL(base_url);
//            } else {
//                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
//            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function cancelInvoice() {
    goURL('../');
}

function invoiceContainerAjax(invoice_type, reference_id, invoice_id) {
    var url = '';
    if (invoice_id != '') {
        url = 'billing/invoice/get_edit_invoice_container_ajax';
    } else {
        url = 'billing/invoice/get_invoice_container_ajax';
    }
    $.ajax({
        type: 'POST',
        url: base_url + url,
        data: {
            invoice_id: invoice_id,
            invoice_type: invoice_type,
            reference_id: reference_id,
            client_id: $('#client_id').val()
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result != '0') {
                $('#invoice_container').html(result);
            } else {
                go('billing/home');
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

//function individualTypeChange(type) {
//
//    if (type == '0') {
//        $("#individual_list").show();
//        $("#personal_information, #other_info_div, #internal_data_div, .display_div").hide();
//    } else {
//        $("#individual_list").hide();
//        $("#existing_individual_id, #existing_reference_id, .personal_info, .other_info").val('');
//        $(".internal_data").val('');
//        $("#personal_information, #other_info_div, #internal_data_div").show();
//        $("#contact-list").html(blank_contact_list());
//        $('.display_div').show();
//    }
//}

function existingIndividual(individual) {
    if (individual == '') {
        $("#existing_individual_id, #existing_reference_id, .personal_info, .other_info").val('');
        $(".internal_data").val('');
        $("#personal_information, #other_info_div, #internal_data_div").hide();
        $('.required_field').prop('required', true);
        $("#contact-list").html(blank_contact_list());
    } else {
        $('.required_field').prop('required', false);
        $("#personal_information, #other_info_div, #internal_data_div").hide();
        individualInfoById(individual);
    }
}

function individualInfoById(title_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'billing/invoice/get_individual_info_ajax',
        data: {
            title_id: title_id
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result != '0') {
                var individual_info = JSON.parse(result);
                var individual_id = $('#individual_id').val();
                var company_id = $('#company_id').val();
                var existing_reference_id = individual_info.existing_reference_id;
//                $("#individual_title").val(individual_info.title);
//                $("#individual_percentage").val(individual_info.percentage);
                $("#individual_first_name").val(individual_info.first_name);
                $("#individual_middle_name").val(individual_info.middle_name);
                $("#individual_last_name").val(individual_info.last_name);
                $("#individual_ssn_itin").val(individual_info.ssn_itin);
                $("#individual_dob").val(individual_info.birth_date);
                $("#individual_language").val(individual_info.language);
                $("#individual_country_residence").val(individual_info.country_residence);
                $("#individual_country_citizenship").val(individual_info.country_citizenship);
                $("#existing_reference_id").val(individual_info.existing_reference_id);
                $("#existing_individual_id").val(individual_info.individual_id);
                get_contact_list(individual_info.individual_id, 'individual', "y");
                setInternalData(existing_reference_id, 'individual');
                $("#personal_information, #other_info_div").hide();
            } else {
                $("#personal_information, #other_info_div").show();
                $("#existing_individual_id, #existing_reference_id, .personal_info, other_info").val('');
                $("#contact-list").html(blank_contact_list());
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

function setInternalData(reference_id, reference) {
    $.ajax({
        type: "POST",
        data: {
            reference: reference,
            reference_id: reference_id
        },
        url: base_url + 'services/accounting_services/get_internal_data',
        dataType: "html",
        success: function (result) {
            if (result != 0) {
                var res = JSON.parse(result);
                $(".office-internal #office").val(res.office);
                load_partner_manager_ddl(res.office, res.partner, res.manager);
                $("#client_association").val(res.client_association);
                $("#referred_by_source").val(res.referred_by_source);
                $("#referred_by_name").val(res.referred_by_name);
                $("#language").val(res.language);
                $('#internal_data_div').hide();
            } else {
                $('.internal_data').val("");
                $('#internal_data_div').hide();
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

function getInternalData(reference_id, reference) {
    $.ajax({
        type: "POST",
        data: {
            reference: reference,
            reference_id: reference_id
        },
        url: base_url + 'services/accounting_services/get_internal_data',
        dataType: "html",
        success: function (result) {
            if (result != 0) {
                var res = JSON.parse(result);
                $(".office-internal #office").val(res.office);
                load_partner_manager_ddl(res.office, res.partner, res.manager);
                $("#client_association").val(res.client_association);
                $("#referred_by_source").val(res.referred_by_source);
                $("#referred_by_name").val(res.referred_by_name);
                $("#language").val(res.language);
                if (res.practice_id != '') {
                    $("#existing_practice_id").val(res.practice_id);
                }
                change_referred_name_status(res.referred_by_source);
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

function loadPayments(status, by, office, payment_status) {
    $.ajax({
        type: "POST",
        url: base_url + 'billing/payments/payments_ajax',
        data: {
            status: status,
            by: by,
            office: office,
            payment_status: payment_status
        },
        dataType: "html",
        success: function (result) {
            if (result != '0') {
                $('#payments_div').html(result);
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

function savePayment()
{
    if (!requiredValidation('form_save_payment')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('form_save_payment'));
    var pay_amount = parseFloat(document.getElementById('payment_amount').value);
    var due_amount = parseFloat(document.getElementById('due_amount').value);
    if (pay_amount > due_amount) {
        swal("ERROR!", "payment amount can't exceed the due amount", "error");
        return false;
    }
    var cardType = "";
    var cardNumber = $("input#card_number").val();
    if (cardNumber != '') {
        if (cardNumber.length != 16){
            $("input#card_number").next('div.errorMessage').html('Card Number Not Valid');
            return false;
        }
        cardType = GetCardType(cardNumber);
        if (cardType == "") {
            $("input#card_number").next('div.errorMessage').html('Card Number Not Valid');
            return false;
        }
    }
    form_data.append('card_type', cardType);

    var invoice_id = $("#invoice_id").val();
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'billing/payments/save_payment',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result);
//            return false;
//            console.log("Result: " + result);
            if (result == 1) {
//                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'billing/payments/details/' + btoa(invoice_id));
            } else if (result == 0) {
                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
            } else {
                swal("ERROR!", result, "error");
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

function saveRefund()
{
    if (!requiredValidation('form_save_payment')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('form_save_payment'));
    var pay_amount = parseFloat(document.getElementById('payment_amount').value);
    var refund_amount = parseFloat(document.getElementById('payble_amount').value);
    if (pay_amount > refund_amount) {
        swal("ERROR!", "Refund amount can't exceed the payble amount", "error");
        return false;
    }
    var invoice_id = $("#invoice_id").val();
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'billing/payments/save_refund',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result != 0) {
                goURL(base_url + 'billing/payments/details/' + btoa(invoice_id));
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

function countTotalPrice(section_id, override_price, retail_price, sub_total) {
    var base_price = retail_price * sub_total;
    if (override_price != '') {
        base_price = override_price * sub_total;
    }
    $('#base_price_' + section_id).val(base_price.toFixed(2));
}

setInterval(function () {
    var base_price_list = document.getElementsByClassName('total_price_each_service');
    var total_price = 0;
    if (base_price_list.length != 0) {
        for (i = 0; i < base_price_list.length; i++) {
            total_price += parseFloat(base_price_list[i].value);
        }
    }
    if (total_price != 0) {
        $('#base_price_div').show();
        $('#total_price').html(total_price.toFixed(2));
    } else {
        $('#base_price_div').hide();
    }
}, 1000);
function paymentDashboardNoteModal(payment_id) {
    var resultHTML = '<div class="form-group"><div class="col-lg-12"><div class="note-textarea">';
    resultHTML += '<textarea readonly="readonly" style="resize: none;" class="form-control" title="Service Note">' + $("#note_hidden_" + payment_id).val() + '</textarea>';
    resultHTML += '</div></div></div>';
    $('#note-body').html(resultHTML);
    $('#showPaymentNotes').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function paymentDashboardFileModal(payment_id) {
    var resultHTML = '<img src="' + base_url + 'uploads/' + $("#file_hidden_" + payment_id).val() + '" style="max-width: 100%;">';
    $('#image_preview').html(resultHTML);
    $('#showPaymentFile').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function cancelPayment(payment_id, invoice_id) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel it!'
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                data: {
                    payment_id: payment_id,
                },
                url: base_url + 'billing/payments/cancel_payment',
                cache: false,
                success: function (result) {
                    if (result != 0) {
                        swal("Success!", "Successfully Payment Canceled!", "success");
                        goURL(base_url + 'billing/payments/details/' + btoa(invoice_id));
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

function refundAll(invoice_id) {
    swal({
        title: 'Are you sure?',
        text: "You refund all amounts to the client!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, refund!'
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                data: {
                    invoice_id: invoice_id,
                },
                url: base_url + 'billing/payments/refund_all',
                cache: false,
                success: function (result) {
                    if (result != 0) {
                        swal("Success!", "Successfully refunded!", "success");
                        goURL(base_url + 'billing/payments/details/' + btoa(invoice_id));
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

function changePaymentStatus(invoice_id) {
    swal({
        title: 'Are you sure?',
        text: "You want to complete the status!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change!'
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                data: {
                    invoice_id: invoice_id,
                },
                url: base_url + 'billing/payments/change_payment_status',
                cache: false,
                success: function (result) {
                    if (result != 0) {
                        swal("Success!", "Successfully changed!", "success");
                        goURL(base_url + 'billing/payments');
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



function addDocumentAjax(deposit_id) {
    var section_id = $('#section_id').val();
    $.ajax({
        type: "POST",
        url: base_url + 'billing/home/add_document_ajax',
        data: {
            section_id: section_id,
            deposit_id: deposit_id
        },
        dataType: "html",
        success: function (result) {
            if (result != '0') {
                var obj = $.parseJSON(result);
                var newHtml = obj.section_result;
                if (deposit_id == '') {
                    if (obj.last_section_id == 'new') {
                        $('#document_container_div').html(newHtml);
                    } else {
                        var section_link = $('#section_link_' + obj.last_section_id);
                        section_link.attr('onclick', 'removeDocument(' + obj.last_section_id + ');');
                        section_link.removeClass('text-success');
                        section_link.addClass('text-danger');
                        section_link.html('<h4><i class="fa fa-times"></i> Remove</h4>');
                        section_link.blur();
                        $(newHtml).insertAfter($('#document_result_div_' + obj.last_section_id));
                    }
                    $('#section_id').val(obj.section_id_hidden);
                } else {
                    $('#document_container_div').html(newHtml);
                    $('#section_id').val(obj.section_id_hidden);
                }
            } else {
                $('#document_container_div').html('');
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

function removeDocument(sectionID) {
    $("#document_result_div_" + sectionID).remove();
}

function refresh_existing_individual_list(officeID = '', clientID = '') {
    $.ajax({
        type: "POST",
        data: {
            office_id: officeID,
            client_id: clientID
        },
        url: base_url + 'billing/invoice/individual_list_by_office',
        dataType: "html",
        success: function (result) {
            $("#individual_list_ddl").html(result);
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function invoiceFilter() {
    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'billing/home/invoice_filter',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result); return false;
            $("#dashboard_result_div").html(result);
            $("[data-toggle=popover]").popover();
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

var changeAlternateFields = function (PaymentTypeID) {
    $(".alternate-field-div, div.pay-now-div").hide();
    $(".alternate-field-div input").prop('required', false);
    $('#ref_no').prev().html('Reference');
    $('#ref_no').prop({'title': 'Reference', 'placeholder': 'Reference'});
    $('div.pay-now-div').find('input').prop('required', false);
    switch (parseInt(PaymentTypeID)) {
        case 1:     //Cash
            $('#ref_no').parent().show();
            break;
        case 2:     //Check
            $('#check_number').parent().show();
            $('#check_number').prop('required', true);
            $('#payment_file').parent().show();
            $('#payment_file').prop('required', false);
            break;
        case 3:     //Credit Card
        case 5:     //Paypal
            $('#authorization_id').parent().show();
            $('#authorization_id').prop('required', true);
            break;
        case 4:     //Wire Transfer
        case 6:     //ACH
        case 7:     //Zelle
            $('#ref_no').parent().show();
            $('#ref_no').prop('required', true);
            $('#ref_no').prev().html('Reference ID<span class="text-danger">*</span>');
            break;
        case 8:     //WRITE OFF
            $('#ref_no').prev().html('Authorized By');
            $('#ref_no').parent().show();
            $('#ref_no').prop({'title': 'Authorized By', 'placeholder': 'Authorized By'});
            $('#payment_file').parent().show();
            $('#payment_file').prop('required', false);
            break;
        case 9:     //Pay NOW
            $('div.pay-now-div').show();
            $('div.pay-now-div').find('input').prop('required', true);
            break;
        default:
            $("#payment_note").parent().show();
    }
};
function sortInvoiceDashboard(sortCriteria = '', sortType = '') {
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
        url: base_url + 'billing/home/sort_invoice',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            $("#dashboard_result_div").html(result);
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

function invoiceNoteModal(order_id, service_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'billing/home/billing_dashboard_note_ajax',
        data: {
            order_id: order_id,
            service_id: service_id
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            var resultHTML = '';
            if (result != '0') {
                var notes = JSON.parse(result);
                for (var i = 0; i < notes.length; i++) {
                    resultHTML += '<div class="form-group" id="note_div_' + order_id + '_' + notes[i].id + '">';
                    resultHTML += '<div class="note-textarea-' + order_id + '-' + notes[i].id + '">';
                    resultHTML += '<textarea class="form-control" name="edit_note[' + notes[i].id + ']" title="Notes">' + notes[i].note + '</textarea>';
                    resultHTML += '</div>';
                    resultHTML += '<a href="javascript:void(0);"  onclick="deleteNote(\'note_div_' + order_id + '_' + notes[i].id + '\', ' + notes[i].id + ', 1);" class="text-danger"><i class="fa fa-times"></i> Remove Note</a>';
                    resultHTML += '</div>';
//                    resultHTML += '<div class="form-group"><div class="col-lg-12"><div class="note-textarea">';
//                    resultHTML += '<textarea readonly="readonly" style="resize: none;" class="form-control" title="Invoice Service Note">' + notes[i].note + '</textarea>';
//                    resultHTML += '</div></div></div>';
                }
            }
            resultHTML += '<div class="form-group">';
            resultHTML += '<div class="note-textarea-' + order_id + '">';
            resultHTML += '<textarea class="form-control" name="note[' + order_id + '][]" title="Note"></textarea>';
            resultHTML += '</div>';
            resultHTML += '<a href="javascript:void(0)" id="note_link_' + order_id + '" onclick="addNote(' + order_id + ', \'n\');" class="text-success note-add-link"><i class="fa fa-plus"></i> Add Note</a>';
            resultHTML += '</div>';
            $('#showNotes input#service_order_id').val(order_id);
            $('#showNotes input#service_id').val(service_id);
            $('#showNotes div.modal-body').html(resultHTML);
            $('#showNotes').modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
}

function saveInvoiceNotes() {
    var formData = new FormData(document.getElementById('modal_note_form'));
    var serviceOrderID = $('#showNotes input#service_order_id').val();
    var serviceID = $('#showNotes input#service_id').val();
    $.ajax({
        type: 'POST',
        url: base_url + 'billing/home/save_invoice_note',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            swal({title: "Success!", text: "Successfully Saved!", type: "success"}, function () {
                $(".note-count-" + serviceOrderID + '-' + serviceID).html(result);
                $('#showNotes').modal('hide');
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