var base_url = document.getElementById('base_url').value;
function county_ajax(state_id, county_id) {
    if (state_id != "") {
        $.ajax({
            type: "POST",
            data: {
                state_id: state_id,
                county_id: county_id
            },
            url: base_url + 'services/accounting_services/county_list',
            dataType: "html",
            success: function (result) {
                $("#county select").html(result);
            }
        });
    }
}

function load_partner_manager_ddl(office_id, partner_id = "", manager_id = "") {
    $.ajax({
        type: "POST",
        data: {
            office_id: office_id
        },
        url: base_url + 'services/home/load_partner_manager',
        dataType: "html",
        success: function (result) {
            var partner = document.getElementById('partner');
            var manager = document.getElementById('manager');
            partner.innerHTML = "";
            manager.innerHTML = "";
            if (result != 0) {
                var staff = JSON.parse(result);
                partner.options[partner.options.length] = new Option("Select an option", "");
                manager.options[manager.options.length] = new Option("Select an option", "");
                for (var i = 0; i < staff.length; i++) {
                    partner.options[partner.options.length] = new Option(staff[i].name, staff[i].id);
                    manager.options[manager.options.length] = new Option(staff[i].name, staff[i].id);
                }
                if (partner_id != '') {
                    $('#partner').val(partner_id);
                }
                if (manager_id != '') {
                    $('#manager').val(manager_id);
                }
            } else {
                partner.options[partner.options.length] = new Option("Select an option", "");
                manager.options[manager.options.length] = new Option("Select an option", "");
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

function change_referred_name_status(referred_source) {
    if (referred_source == '1' || referred_source == '9' || referred_source == '10' || referred_source == '') {
        $("#referred-label").html('Referred By Name');
        $("#referred_by_name").removeAttr('required');
        $(".chosen-select").chosen();
    } else {
        $("#referred-label").html('Referred By Name<span class="text-danger">*</span>');
        $("#referred_by_name").attr('required', true);
        $(".chosen-select").chosen();
    }
}

function load_service_container(service_id) {
    if (service_id != '') {
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
            $(selector).on('change', function (evt, params) {
                var field_name = $(this).attr('name');
                if (field_name == 'related_services[]') {
                    var $this = $(this);
                    var relative_service_id = $this.val();
                    $.ajax({
                        type: 'POST',
                        data: {
                            service_id: service_id,
                            relative_service_id: relative_service_id,
                        },
                        url: base_url + 'services/home/get_related_service_container',
                        dataType: 'html',
                        success: function (result) {
                            $('#related_service_container').html(result);
                        }
                    });
                }

            });
        }
    }
}

function request_create_company() {
    if (!requiredValidation('form_create_new_company')) {
        return false;
    }

    var company_type = $("#type option:selected").val();
//    if (company_type == '3') {

    var total_percentage = $("#owner_percentage_total").val();
    if (total_percentage != '100.00') {
        swal("Error", "Percentage of all partners should equal to 100%", "error");
        return false;
    }
//    }

    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }

    company_type_enable();
    $('.related_service').each(function () {
        if (!$(this).is(':visible')) {
            $(this).remove();
        }
    });
    $('.state_opened').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_new_company'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/incorporation/request_create_company',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {

            //console.log("Result: " + result); return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function request_create_company_non_profit_fl() {
    if (!requiredValidation('form_create_company_non_profit_fl')) {
        return false;
    }
    var company_type = $("#type option:selected").val();
    var total_percentage = $("#owner_percentage_total").val();
    if (total_percentage != '100.00') {
        swal("Error", "Percentage of all partners should equal to 100%", "error");
        return false;
    }
    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }
    company_type_enable();
    $('.related_service').each(function () {
        if (!$(this).is(':visible')) {
            $(this).remove();
        }
    });
    $('.state_opened').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_company_non_profit_fl'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/incorporation/request_create_company_non_profit_fl',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {

            //console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function request_create_new_florida_pa() {
    if (!requiredValidation('form_create_new_florida_pa')) {
        return false;
    }
    var company_type = $("#type option:selected").val();
    var total_percentage = $("#owner_percentage_total").val();
    if (total_percentage != '100.00') {
        swal("Error", "Percentage of all partners should equal to 100%", "error");
        return false;
    }
    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }
    company_type_enable();
    $('.related_service').each(function () {
        if (!$(this).is(':visible')) {
            $(this).remove();
        }
    });
    $('.state_opened').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_new_florida_pa'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/incorporation/request_create_new_florida_pa',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {

            //console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function getretailprice(value) {
    if (value == 8) {
        var service_id = 44;
        $("#service_id").val(service_id);
    } else {
        var service_id = 1;
        $("#service_id").val(service_id);
    }

    $.ajax({
        type: 'POST',
        url: base_url + 'services/incorporation/getretailprice',
        data: {
            service_id: service_id
        },
        success: function (result) {
            $('#retail_price').val(result);
            $.ajax({
                type: 'POST',
                url: base_url + 'services/incorporation/getrelatedservices',
                data: {
                    service_id: service_id
                },
                success: function (data) {
                    if (data.trim != '') {
                        $(".related-service-div").html('');
                        $(".related-service-div").html('<select data-placeholder="Select one option" title="Related Services" class="chosen-select" name="related_services[]" id="related_services" style="width: 100%;" multiple="">' + data.trim() + '</select>');
                        $(".chosen-select").chosen();
                        load_service_container(service_id);
                    }

                }
            });
        }
    });
}

function request_create_annual_report() {
    if (!requiredValidation('form_create_annual_report')) {
        return false;
    }
    $('.disabled_field, .service_radio, .retail_price, .type_of_client, .client_list').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_annual_report'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/incorporation/request_create_annual_report',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {

            //console.log("Result: " + result); return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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


function open_owner_popup(service_id, company_id, title_id) {
    if ($(".owneredit").hasClass("doedit")) {
        return false;
    } else {
        var e = document.getElementById("type");
        var company_type = e.options[e.selectedIndex].value;
        if (company_type == '') {
            $("#owners-list-count").next('div.errorMessage').html("You have to select company type first!");
            return false;
        } else {
            $("#owners-list-count").next('div.errorMessage').html("");
            var url = base_url + 'services/home/owner_form/' + service_id + '/' + company_id;
            if (parseInt(title_id) > 0) {
                url = url + '/' + title_id;
            }

            url = url + '?q=' + company_type;
            url += '&sid=' + $("#service_id").val();
            url += '&tid=' + title_id;
            window.open(url, 'Add Owner', "width=1200, height=600, top=100, left=110, scrollbars=yes");
        }
    }
}

function show_contact_list(ref, ref_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/show_contact_list',
        data: {
            ref: ref,
            ref_id: ref_id
        },
        success: function (result) {
            $('#contact-list').html(result);
        }
    });
}

function show_owner_list(id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/show_owner_list',
        data: {
            id: id
        },
        success: function (result) {
            $('#owners-list').html(result);
        }
    });
}

function insert_contact() {
    if (!requiredValidation('form_contact')) {
        return false;
    }

    var form_data = new FormData($('#form_contact')[0]);
    var old_types = $('.contact_type_array').map(function () {
        return $(this).val();
    }).get();
    form_data.append("old_types", old_types);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/home/insert_contact',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            switch (result) {
                case "-1":
                    swal("Error Processing Data");
                    break;
                case "-2":
                    swal("Same Type Can't Exist");
                    break;
                case "-3":
                    swal("Email Already Exists");
                    break;
                default:
                    update_contact_list(result);
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

function update_contact_list(id) {
    $.get(base_url + "services/home/update_list/" + id, function (data) {
        $("#contact-list").append(data);
        $("#contact-list-count").val(parseInt($("#contact-list-count").val() + 1));
        $('#contact-form').modal('toggle');
    });
}

function get_all_contacts(ref_id) {
    $.get(base_url + "services/home/get_all_contacts/" + ref_id, function (data) {
        $("#contact-list").append(data);
    });
}

function loadServiceDashboard(status, categoryID, requestType, officeID, pageNumber = 0) {
    var requestBy = $('.staff-dropdown option:selected').val();
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/service_dashboard_filter',
        data: {
            category_id: categoryID,
            request_type: requestType,
            status: status,
            request_by: requestBy,
            office_id: officeID,
            page_number: pageNumber
        },
        success: function (result) {
            //alert(result);
            //console.log(result); return false;
            if (result.trim() != '') {
                if (pageNumber == 1 || pageNumber == 0) {
                    $(".ajaxdiv").html(result);
                    $("a.filter-button span:contains('-')").html(0);
                    $(".variable-dropdown").val('');
                    $(".condition-dropdown").val('').removeAttr('disabled');
                    $(".criteria-dropdown").val('');
                    $('.criteria-dropdown').removeAttr('readonly').empty().append('<option value="">All Criteria</option>');
                    $(".criteria-dropdown").trigger("chosen:updated");
                    $('form#filter-form').children('div.filter-inner').children('div.filter-div').not(':first').remove();
                    $('#btn_service').css('display', 'none');
                } else {
                    $(".ajaxdiv").append(result);
                    $('.result-header').not(':first').remove();
                }
                if (pageNumber != 0) {
                    $('.load-more-btn').not(':last').remove();
                }
                if(requestType=='on_load'){
                    $('#btn_service').hide();
//                    clearFilter();
                }
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

function insert_document() {
    if (!requiredValidation('form_document')) {
        return false;
    }

    var form_data = new FormData($('#form_document')[0]);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/home/insert_document',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result == -1) {
                alert("Error Processing Data");
            } else {
                update_document_list(result);
            }
        }
    });
}

function update_document_list(id) {
    $.get(base_url + "services/home/update_doc_list/" + id, function (data) {
        $("#attached_docs").append(data);
        $("#doc-list-count").val(parseInt($("#doc-list-count").val() + 1));
        $.get(base_url + "services/home/loadDocumentList/" + id, function (data) {
            $("#document-list").append(data);
        });
        $('#contact-form').modal('toggle');
    });
}

function document_list_by_ref(ref_id) {
    $.get(base_url + "services/home/loadDocumentListByRef/" + ref_id, function (data) {
        $("#document-list").append(data);
    });
}

function update_contact(id) {
    if (!requiredValidation('form_contact')) {
        return false;
    }

    var form_data = new FormData($('#form_contact')[0]);
    var old_types = $('.contact_type_array').map(function () {
        return $(this).val();
    }).get();
    form_data.append("old_types", old_types);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/home/update_contact/' + id,
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            switch (result) {
                case "-1":
                    swal("Error Processing Data");
                    break;
                case "-2":
                    swal("Same Type Can't Exist");
                    break;
                case "-3":
                    swal("Email Already Exists");
                    break;
                default:
                    $.get(base_url + "services/home/update_list/" + id, function (data) {
                        $("#contact_id_" + id).replaceWith(data);
                        $('#contact-form').modal('toggle');
                    });
            }
        }
    });
}

function delete_contact(id) {
    swal({
        title: "Are you sure?",
        text: "Your will not be able to recover this contact!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.get(base_url + "services/home/delete_contact/" + id, function (data) {
                    if (data == 1) {
                        $("#contact_id_" + id).remove();
                        $("#contact-list-count").val(parseInt($("#contact-list-count").val()) - 1);
                        swal("Deleted!", "Your contact has been deleted.", "success");
                    } else {
                        swal("Unable To Delete Contact");
                    }
                });
            });
}

function delete_document1(id, file_name) {
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this document!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                $.get(base_url + "services/home/delete_document/" + id + "/" + file_name, function (data) {
                    if (data == 1) {
                        $("#document_id_" + id).remove();
                        $("#doc-list-count").val(parseInt($("#doc-list-count").val()) - 1);
                        swal("Deleted!", "Your document has been deleted.", "success");
                    } else {
                        swal("Unable To Delete document");
                    }
                });
            });
}

function update_contact_list_copy_contact(id) {
    $.get(base_url + "services/home/update_list/" + id, function (data) {
        $("#contact-list").append(data);
        $("#contact-list-count").val(parseInt($("#contact-list-count").val() + 1));
    });
}

//function saveOwnerform() {
//
//    if (!requiredValidation('form_title')) {
//        return false;
//    }
//    var num = document.getElementById("per_id").value;
//    if (isNaN(num)) {
//        $("#per_id").next('.errorMessage').html('Please, enter numeric value');
//        return false;
//    } else {
//        $("#per_id").next('.errorMessage').html("");
//    }
//
//    var reference = $("#reference").val();
//    var reference_id = $("#reference_id").val();
//
//    var formData = new FormData(document.getElementById('form_title'));
//
//    var quant_contact = parseInt(document.getElementById('quant_contact').value);
//    // if (!quant_contact){
//    //     swal("Error", "You have to enter at least one contact info!", "error");
//    //     return false;
//    // }
//
//    var quant_documents = parseInt(document.getElementById('quant_documents').value);
//    // if (!quant_documents){
//    //     swal("Error", "You have to enter at least one document for this owner!", "error");
//    //     return false;
//    // }
//
//    $.ajax({
//        type: 'POST',
//        url: base_url + 'services/home/save_owner',
//        data: formData,
//        enctype: 'multipart/form-data',
//        cache: false,
//        contentType: false,
//        processData: false,
//        success: function (result) {
//            alert(result);
//
//            // console.log("Result: " + result);
//            // if (result == 1) {
//            //     clearCacheFormFields('form_title');
//            //     window.opener.reloadOwnerList(company_id, base_url);
//            window.opener.reload_owner_list_for_payroll_section(company_id, base_url);
//            //     window.opener.reload_owner_list_for_payroll_section2(company_id, base_url);
//            //     window.opener.reload_owner_list_for_payroll_section3(company_id, base_url);
//
//            //     var quant_title = parseInt(window.opener.document.getElementById('quant_title').value);
//            //     window.opener.document.getElementById('quant_title').value = quant_title + 1;
//
//            //     window.opener.swal("Success!", "Successfully saved!", "success");
//            //     window.opener.disable_company_type();
//            //     self.close();
//            // } else if (result == 2) {
//            //     swal("ERROR!", "If you choose LLC, total share should be always 100%", "error");
//            // } else if (result == 0) {
//            //     swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
//            // } else {
//            //     swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
//            // }
//        },
//        beforeSend: function () {
//            openLoading();
//        },
//        complete: function (msg) {
//            closeLoading();
//        }
//    });
//}

function select_existing_owner() {
    var company_id = $("#company_id").val();
    var individual_id = $("#individual_list_ddl option:selected").val();
    var ownertitle = $("#ownertitle option:selected").val();
    var company_type = $("#type").val();
    var percentage = $("#percentage_shares").val();
    var old_individual_id = $("#individual_id").val();
    var title_id = $("#title_id").val();
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/select_existing_owner',
        data: {company_id: company_id, individual_id: individual_id, company_type: company_type, percentage: percentage, old_individual_id: old_individual_id, title_id: title_id, ownertitle: ownertitle},
        datatype: "html",
        success: function (result) {

            //console.log("Result: " + result); return false;
            // reload_owner_list(company_id, "main");
            window.opener.reload_owner_list(company_id, "main");
            window.opener.disable_company_type1();
            self.close();
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function save_owner() {
    if (!requiredValidation('form_title')) {
        return false;
    }
    var num = document.getElementById("per_id").value;
    if (isNaN(num)) {
        $("#per_id").next('.errorMessage').html('Please, enter numeric value');
        return false;
    } else {
        $("#per_id").next('.errorMessage').html("");
    }

    var reference = $("#reference").val();
    var reference_id = $("#reference_id").val();
    var company_id = $("#company_id").val();
    var formData = new FormData(document.getElementById('form_title'));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/save_owner',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {

            console.log("Result: " + result);
            if (result == 1) {
//                clearCacheFormFields('form_title');
                window.opener.reload_owner_list(company_id, "main");
                if ($("#service_id").val() == 11) {
                    window.opener.reload_owner_list(company_id, "payroll");
                    window.opener.reload_owner_list(company_id, "payroll2");
                    window.opener.reload_owner_list(company_id, "payroll3");
                }
//                window.opener.swal("Success!", "Successfully saved!", "success");
                window.opener.disable_company_type1();
                self.close();
            } else if (result == 2) {
                swal("ERROR!", "If you choose LLC, total share should be always 100%", "error");
            } else if (result == 0) {
                swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
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

function disable_company_type1() {
    $('#type').prop('disabled', true);
}

function reload_owner_list(company_id, section) {
    $.ajax({
        type: "POST",
        data: {
            company_id: company_id,
            section: section
        },
        url: base_url + 'services/home/reload_owner_list',
        dataType: "html",
        success: function (result) {
            if (section == "main") {
                document.getElementById('owners-list').innerHTML = result;
            } else {
                document.getElementById('owner-list-' + section).innerHTML = result;
            }
        }
    });
}

function delete_owner(owner_id) {
    if ($(".ownerdelete").hasClass("dodelete")) {
        return false;
    } else {
        swal({
            title: "Are you sure?",
            text: "This owner will be deleted!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false

        }, function () {
            var company_id = $("#reference_id").val();
            $.ajax({
                type: "POST",
                data: {
                    owner_id: owner_id,
                    company_id: company_id
                },
                url: base_url + 'services/home/delete_owner',
                dataType: "html",
                success: function (result) {
//                    alert('hi');
//                    swal("ERROR!", "An error ocurred! \n Please, try again.", "error");

//                    if (result != 0) {                        
//                        reload_owner_list(company_id, "main");
//                        if ($("#service_id").val() == 11) {
//                            reload_owner_list(company_id, "payroll");
//                            reload_owner_list(company_id, "payroll2");
//                            reload_owner_list(company_id, "payroll3");
//                        }
//                        enable_company_type(company_id);
//                    } else {
//                        swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
//                    }

                    if (result == '2') {
                        swal("Deleted!", "Owner has been deleted Successfully.", "success");
                        reload_owner_list(company_id, "main");
                        if ($("#service_id").val() == 11) {
                            reload_owner_list(company_id, "payroll");
                            reload_owner_list(company_id, "payroll2");
                            reload_owner_list(company_id, "payroll3");
                        }
                        enable_company_type(company_id);
                    } else if (result == '1') {
                        swal("Unable To Delete!", "You should have atleast one owner!", "error");
                    } else {
                        swal("Error!", "Error to Delete Owner.", "error");
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
}

function enable_company_type(company_id) {
    $.ajax({
        type: "POST",
        data: {
            company_id: company_id
        },
        url: base_url + 'services/home/enable_company_type',
        dataType: "html",
        success: function (result) {
            if (result.trim() == 0) {
                company_type_enable();
            }
        }
    });
}

function company_type_enable() {
    $('#type').prop('disabled', false);
    $('#state').prop('disabled', false);
    $('.office-internal #office').prop('disabled', false);
    $('#partner').prop('disabled', false);
    $('#manager').prop('disabled', false);
    $("#client_association").prop("disabled", false);
    $("#referred_by_source").prop('disabled', false);
    $("#referred-by-name").prop("disabled", false);
    $("#language").prop('disabled', false);
}

function get_financial_account_list(company_id, list_type, order_id) {
    $.ajax({
        type: "POST",
        data: {
            order_id: order_id,
            company_id: company_id,
            list_type: list_type
        },
        url: base_url + 'services/home/get_financial_account_list',
        dataType: "html",
        success: function (result) {
            $("#accounts-list").html(result);
        }
    });
}

function delete_account(id) {
    swal({
        title: "Are you sure?",
        text: "This contact will be deleted!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            type: "POST",
            data: {
                account_id: id
            }, //services/accounting_services/delete_financial_account
            url: base_url + 'services/accounting_services/delete_account',
            dataType: "html",
            success: function (result) {
                if (result != 0) {
                    var reference_id = $("#reference_id").val();
                    var order_id = $("#editval").val();
                    get_financial_account_list(reference_id, "", order_id);
                    swal("Deleted!", "Your financial account has been deleted.", "success");
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

function save_account(section) {

//update_financial_account_by_date
    if (!requiredValidation('form_accounts')) {
        return false;
    }
    var form_data = new FormData(document.getElementById('form_accounts'));
    var company_id = $("#company_id").val();
    var order_id = $("#editval").val();
    var modal_type=$("#modal_type").val();
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
//            alert(result); return false;
            if (result.trim() == "1") {
                swal({title: "Success!", text: "Financial account successfully saved!", type: "success"}, function () {
                    $('#accounts-form').modal('hide');
                    get_financial_account_list(company_id, section, order_id);
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

function request_create_bookkeeping() {

    if (!requiredValidation('form_create_bookkeeping')) {
        return false;
    }
    if ($('#type_of_client_ddl').val() == '1') {
        var company_type = $("#type option:selected").val();
//        if (company_type == '3') {

        var total_percentage = $("#owner_percentage_total").val();
        if (total_percentage != '100.00') {
            swal("Error", "Percentage of all partners should equal to 100%", "error");
            return false;
        }
//        }

        var override_price = $("#retail_price_override").val();
        if (isNaN(override_price)) {
            $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
            return false;
        } else {
            $("#retail_price_override").next(".errorMessage").html('');
        }

        company_type_enable();
        $('.related_service').each(function () {
            if (!$(this).is(':visible')) {
                $(this).remove();
            }
        });
    }

    if ($("#editval").val() != '') {
        $('.disabled_field').removeAttr('disabled');
    }
    var form_data = new FormData(document.getElementById('form_create_bookkeeping'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/accounting_services/request_create_bookkeeping',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            // alert(result);
            // return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function save_owner_list(company_id, new_reference_id) {
    $.ajax({
        type: "POST",
        data: {
            company_id: company_id,
            new_reference_id: new_reference_id
        },
        url: base_url + 'services/home/save_existing_owner_list',
        dataType: "html",
        success: function (result) {
            //alert(result);
            if (result.trim() != 0) {
                document.getElementById('quant_title').value = result;
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

function save_contact_list(reference, reference_id, new_reference_id) {
    $.ajax({
        type: "POST",
        data: {
            reference: reference,
            reference_id: reference_id,
            new_reference_id: new_reference_id
        },
        url: base_url + 'services/home/save_existing_contact_list',
        dataType: "html",
        success: function (result) {
            //alert(result);
            if (result.trim() != 0) {
                document.getElementById('quant_contact').value = result;
            }
        }
    });
}

function request_create_bookkeeping_by_date() {
    // alert("Hello");return false;
    if (!requiredValidation('form_create_bookkeeping_by_date')) {
        return false;
    }
    if ($("#type_of_client_ddl").val() == '1') {
        var company_type = $("#type option:selected").val();
//        if (company_type == '3') {

        var total_percentage = $("#owner_percentage_total").val();
        if (total_percentage != '100.00') {
            swal("Error", "Percentage of all partners should equal to 100%", "error");
            return false;
        }
//        }

        var override_price = $("#retail_price_override").val();
        if (isNaN(override_price)) {
            $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
            return false;
        } else {
            $("#retail_price_override").next(".errorMessage").html('');
        }

        company_type_enable();
    }
    $('.related_service').each(function () {
        if (!$(this).is(':visible')) {
            $(this).remove();
        }
    });
    if ($("#editval").val() != '') {
        $('.disabled_field').removeAttr('disabled');
    }
    var form_data = new FormData(document.getElementById('form_create_bookkeeping_by_date'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/accounting_services/request_create_bookkeeping_by_date',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            // alert(result);
//            return false;
            //console.log("Result: " + result); return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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
function blank_contact_list() {
    return '<input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">' +
            '<div class="errorMessage text-danger"></div>';
}

function blank_owner_list() {
    return '<input type="hidden" class="required_field" title="Owners" id="owners-list-count" value="">' +
            '<div class="errorMessage text-danger"></div>';
}

function request_create_payroll() {
    if (!requiredValidation('form_create_payroll')) {
        return false;
    }

    var rt6check = $('input[type=radio][name=Rt6]:checked').length;
    if (rt6check == 0) {
        swal("ERROR!", "Please check do you have Rt-6?", "error");
        return false;
    }

    var rt6val = $('input[type=radio][name=Rt6]:checked').val();
    if (rt6val == 'No') {
        var residenttype = $('input[type=radio][name=residenttype]:checked').length;
        if (residenttype == 0) {
            swal("ERROR!", "Please Select Resident or Non-resident", "error");
            return false;
        }
        var residenttypeval = $('input[type=radio][name=residenttype]:checked').val();
        if (residenttypeval == 'Resident') {
            if (document.getElementById("license").files.length == 0) {
//                swal("ERROR!", "Please Upload Driver License", "error");
//                return false;
            }
        } else {
            if (document.getElementById("passport").files.length == 0) {
                if (document.getElementById("editval").value != "" && document.getElementById("payroll_passport_count").value == "") {
                    swal("ERROR!", "Please Upload Passport", "error");
                    return false;
                } else {
                    swal("ERROR!", "Please Upload Passport", "error");
                    return false;
                }
            }
            if (document.getElementById("lease").files.length == 0) {
                if (document.getElementById("editval").value != "" && document.getElementById("payroll_lease_count").value == "") {
                    swal("ERROR!", "Please Upload Lease", "error");
                    return false;
                } else {
                    swal("ERROR!", "Please Upload Lease", "error");
                    return false;
                }
            }
        }
    }

    if (document.getElementById("editval").value == "") {
        if (document.getElementById("void_cheque").files.length == 0) {
            swal("ERROR!", "Please Upload Void Cheque", "error");
            return false;
        }
    }

    var payroll_approver_quantity = $("#payroll_approver_quantity").val();
    if (payroll_approver_quantity == 0) {
        swal("ERROR!", "Please Add Payroll Approver", "error");
        return false;
    }

    var company_principal_quantity = $("#company_principal_quantity").val();
    if (company_principal_quantity == 0) {
        swal("ERROR!", "Please Add Company Principal", "error");
        return false;
    }

    var signer_data_quantity = $("#signer_data_quantity").val();
    if (signer_data_quantity == 0) {
        swal("ERROR!", "Please Add Signer Data", "error");
        return false;
    }

    $('#type').prop('disabled', false);
    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }
    if ($("#editval").val() != '') {
        $('.disabled_field').removeAttr('disabled');
    }

    company_type_enable();
    var formData = new FormData(document.getElementById('form_create_payroll'));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/request_create_payroll',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            //alert(result);
            // console.log("Result: " + result); return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
//                clearCacheFormFields('form_create_payroll');
                goURL(base_url + 'services/home/view/' + result.trim());
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

function delete_company_data() {

    $("#dba").val('');
    $("#company_address").val('');
    $("#company_city").val('');
    $("#company_state").val('');
    $("#company_zip").val('');
    $("#fein").val('');
    $("#type").val('');
    $("#fye").val('');
    $("#company_started").val('');
    $("#company_phone").val('');
    $("#company_fax").val('');
    $("#company_email").val('');
    $("#business_description").val('');
}

function load_company_data(clientid, new_reference_id) {
    $.ajax({
        type: "POST",
        data: {
            clientid: clientid,
            new_reference_id: new_reference_id
        },
        url: base_url + 'services/accounting_services/get_payroll_company_data',
        dataType: "html",
        success: function (result) {
            //alert(result);
            if (result != '0') {
                res = JSON.parse(result);
                //alert(res.dba);
                if (res.dba) {
                    $("#dba").val(res.dba);
                }
                if (res.company_address) {
                    $("#company_address").val(res.company_address);
                }
                if (res.city) {
                    $("#company_city").val(res.city);
                }
                if (res.state) {
                    $("#company_state").val(res.state);
                }
                if (res.city) {
                    $("#company_zip").val(res.zip);
                }
                if (res.fein) {
                    $("#fein").val(res.fein);
                }
                if (res.type) {
                    $("#type").val(res.type);
                }
                if (res.fye) {
                    $("#fye").val(res.fye);
                }
                if (res.company_started) {
                    $("#company_started").val(res.company_started);
                }
                if (res.phone_number) {
                    $("#company_phone").val(res.phone_number);
                }
                if (res.fax) {
                    $("#company_fax").val(res.fax);
                }
                if (res.email) {
                    $("#company_email").val(res.email);
                }
                if (res.business_description != 'null') {
                    $("#business_description").val(res.business_description);
                }
                // notes remaining
            }
        }
    });
}

function request_create_salestax_processing() {
//    alert("ok"); return false;

    if (!requiredValidation('form_create_sales_tax_processing')) {
        return false;
    }
    var existing = $("#type_of_client_ddl").val();
    if (existing == "") {
        $("#type_of_client_ddl").next(".text-danger").html('Please Select Yes From Dropdown');
        return false;
    } else {
        $("#type_of_client_ddl").next(".text-danger").html('');
    }


    $('#type').prop('disabled', false);
    $("#istate").prop('disabled', false);
    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }

    if ($("#editval").val() != '') {
        $('.disabled_field').removeAttr('disabled');
    }

    company_type_enable();
    var formData = new FormData(document.getElementById('form_create_sales_tax_processing'));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/request_create_sales_tax_processing',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
            //console.log("Result: " + result); return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function related_create_sales_tax_processing(val) {
    if (!requiredValidation(val)) {
        return false;
    }

    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }

    var formData = new FormData(document.getElementById(val));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/related_create_sales_tax_processing',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
            console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home');
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

function related_create_sales_tax_recurring(val) {
    if (!requiredValidation(val)) {
        return false;
    }
    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }
    var formData = new FormData(document.getElementById(val));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/related_create_sales_tax_recurring',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
            console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home');
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

function request_create_salestax_recurring() {
    if (!requiredValidation('form_create_sales_tax_recurring')) {
        return false;
    }
    var existing = $("#type_of_client_ddl").val();
    if (existing == "") {
        $("#type_of_client_ddl").next(".text-danger").html('Please Select Yes From Dropdown');
        return false;
    } else {
        $("#type_of_client_ddl").next(".text-danger").html('');
    }


    $('#type').prop('disabled', false);
    $("#istate").prop('disabled', false);
    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }

    if ($("#editval").val() != '') {
        $('.disabled_field').removeAttr('disabled');
    }

    company_type_enable();
    var formData = new FormData(document.getElementById('form_create_sales_tax_recurring'));
//    alert(formData);

    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/request_create_sales_tax_recurring',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
//            alert(result);return false;
            //console.log("Result: " + result); return false;
            if (result != 0) {
//                alert('Hi');
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function request_create_fien_application() {
    if (!requiredValidation('form_create_fein_application')) {
        return false;
    }
    if ($("#editval").val() != '') {
        $('.disabled_field, .client_type_field0, .type_of_client').removeAttr('disabled');
    }
    $('#type').removeAttr('disabled');
    var formData = new FormData(document.getElementById('form_create_fein_application'));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/incorporation/request_create_fien_application',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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
function request_create_sales_tax_application() {
    if (!requiredValidation('form_create_sales_tax_application')) {
        swal("Form Incompleted!", "Variable field is missing", "error");
        return false;
    }

    var rt6check = $('input[type=radio][name=Rt6]:checked').length;
    if (rt6check == 0) {
        swal("ERROR!", "Please check do you have Rt-6?", "error");
        return false;
    }

    var rt6val = $('input[type=radio][name=Rt6]:checked').val();
    var editval = $('#editval').val();
    if (editval == "") {
        if (rt6val == 'No') {
            var residenttype = $('input[type=radio][name=residenttype]:checked').length;
            if (residenttype == 0) {
                swal("ERROR!", "Please Select Resident or Non-resident", "error");
                return false;
            }
            var residenttypeval = $('input[type=radio][name=residenttype]:checked').val();
            if (residenttypeval == 'Resident') {
                if (document.getElementById("license").files.length == 0) {
//                swal("ERROR!", "Please Upload Driver License", "error");
//                return false;
                }
            } else {
                if (document.getElementById("passport").files.length == 0) {
                    if (document.getElementById("editval").value != "" && document.getElementById("payroll_passport_count").value == "") {
                        swal("ERROR!", "Please Upload Passport", "error");
                        return false;
                    } else {
                        swal("ERROR!", "Please Upload Passport", "error");
                        return false;
                    }
                }
                if (document.getElementById("lease").files.length == 0) {
                    if (document.getElementById("editval").value != "" && document.getElementById("payroll_lease_count").value == "") {
                        swal("ERROR!", "Please Upload Lease", "error");
                        return false;
                    } else {
                        swal("ERROR!", "Please Upload Lease", "error");
                        return false;
                    }
                }
            }
        }

    }

    $('#type').prop('disabled', false);
    $("#istate").prop('disabled', false);
    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }

    if ($("#editval").val() != '') {
        $('.disabled_field').removeAttr('disabled');
    }

    company_type_enable();
    var formData = new FormData(document.getElementById('form_create_sales_tax_application'));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/request_create_sales_tax_application',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
//            alert(result);
            //console.log("Result: " + result); return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
//                clearCacheFormFields('form_create_payroll');
                goURL(base_url + 'services/home/view/' + result.trim());
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

function related_create_sales_tax_application(val) {
    if (!requiredValidation(val)) {
        return false;
    }

    var rt6check = $('input[type=radio][name=Rt6]:checked').length;
    if (rt6check == 0) {
        swal("ERROR!", "Please check do you have Rt-6?", "error");
        return false;
    }

    var rt6val = $('input[type=radio][name=Rt6]:checked').val();
    if (rt6val == 'No') {
        var residenttype = $('input[type=radio][name=residenttype]:checked').length;
        if (residenttype == 0) {
            swal("ERROR!", "Please Select Resident or Non-resident", "error");
            return false;
        }
        var residenttypeval = $('input[type=radio][name=residenttype]:checked').val();
        if (residenttypeval == 'Resident') {
            if (document.getElementById("license").files.length == 0) {
//                swal("ERROR!", "Please Upload Driver License", "error");
//                return false;
            }
        } else {
            if (document.getElementById("passport").files.length == 0) {
                if (document.getElementById("editval").value != "" && document.getElementById("payroll_passport_count").value == "") {
                    swal("ERROR!", "Please Upload Passport", "error");
                    return false;
                } else {
                    swal("ERROR!", "Please Upload Passport", "error");
                    return false;
                }
            }
            if (document.getElementById("lease").files.length == 0) {
                if (document.getElementById("editval").value != "" && document.getElementById("payroll_lease_count").value == "") {
                    swal("ERROR!", "Please Upload Lease", "error");
                    return false;
                } else {
                    swal("ERROR!", "Please Upload Lease", "error");
                    return false;
                }
            }
        }
    }

    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }

    if ($("#editval").val() != '') {
        $('.disabled_field').removeAttr('disabled');
    }

    company_type_enable();
    var formData = new FormData(document.getElementById(val));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/related_create_sales_tax_application',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
//            alert(result);
            console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
//                clearCacheFormFields('form_create_payroll');
                goURL(base_url + 'services/home');
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

function request_create_rt6_unemployment_app() {
    if (!requiredValidation('form_create_rt6_unemployment_app')) {
        return false;
    }

    var rt6check = $('input[type=radio][name=Rt6]:checked').length;
    if (rt6check == 0) {
        swal("ERROR!", "Please check do you have Rt-6?", "error");
        return false;
    }

    var rt6val = $('input[type=radio][name=Rt6]:checked').val();
    if (rt6val == 'No') {
        var residenttype = $('input[type=radio][name=residenttype]:checked').length;
        if (residenttype == 0) {
            swal("ERROR!", "Please Select Resident or Non-resident", "error");
            return false;
        }
        var residenttypeval = $('input[type=radio][name=residenttype]:checked').val();
        if (residenttypeval == 'Resident') {
            if (document.getElementById("license").files.length == 0) {
//                swal("ERROR!", "Please Upload Driver License", "error");
//                return false;
            }
        } else {
            if (document.getElementById("passport").files.length == 0) {
                if (document.getElementById("editval").value != "" && document.getElementById("payroll_passport_count").value == "") {
                    swal("ERROR!", "Please Upload Passport", "error");
                    return false;
                } else {
                    swal("ERROR!", "Please Upload Passport", "error");
                    return false;
                }
            }
            if (document.getElementById("lease").files.length == 0) {
                if (document.getElementById("editval").value != "" && document.getElementById("payroll_lease_count").value == "") {
                    swal("ERROR!", "Please Upload Lease", "error");
                    return false;
                } else {
                    swal("ERROR!", "Please Upload Lease", "error");
                    return false;
                }
            }
        }
    }

    $('#type').prop('disabled', false);
    $("#istate").prop('disabled', false);
    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }


    if ($("#editval").val() != '') {
        $('.disabled_field').removeAttr('disabled');
    }
    company_type_enable();
    var formData = new FormData(document.getElementById('form_create_rt6_unemployment_app'));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/request_create_rt6_unemployment_app',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
//                clearCacheFormFields('form_create_payroll');
                goURL(base_url + 'services/home/view/' + result.trim());
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

function related_create_rt6_unemployment_app(val) {
    if (!requiredValidation(val)) {
        return false;
    }

    var rt6check = $('input[type=radio][name=Rt6]:checked').length;
    if (rt6check == 0) {
        swal("ERROR!", "Please check do you have Rt-6?", "error");
        return false;
    }

    var rt6val = $('input[type=radio][name=Rt6]:checked').val();
    if (rt6val == 'No') {
        var residenttype = $('input[type=radio][name=residenttype]:checked').length;
        if (residenttype == 0) {
            swal("ERROR!", "Please Select Resident or Non-resident", "error");
            return false;
        }
        var residenttypeval = $('input[type=radio][name=residenttype]:checked').val();
        if (residenttypeval == 'Resident') {
            if (document.getElementById("license").files.length == 0) {
//                swal("ERROR!", "Please Upload Driver License", "error");
//                return false;
            }
        } else {
            if (document.getElementById("passport").files.length == 0) {
                if (document.getElementById("editval").value != "" && document.getElementById("payroll_passport_count").value == "") {
                    swal("ERROR!", "Please Upload Passport", "error");
                    return false;
                } else {
                    swal("ERROR!", "Please Upload Passport", "error");
                    return false;
                }
            }
            if (document.getElementById("lease").files.length == 0) {
                if (document.getElementById("editval").value != "" && document.getElementById("payroll_lease_count").value == "") {
                    swal("ERROR!", "Please Upload Lease", "error");
                    return false;
                } else {
                    swal("ERROR!", "Please Upload Lease", "error");
                    return false;
                }
            }
        }
    }

    var override_price = $("#retail_price_override").val();
    if (isNaN(override_price)) {
        $("#retail_price_override").next(".errorMessage").html('Override price must be numreic');
        return false;
    } else {
        $("#retail_price_override").next(".errorMessage").html('');
    }

    var formData = new FormData(document.getElementById(val));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/accounting_services/related_create_rt6_unemployment_app',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            //alert(result);
            console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
//                clearCacheFormFields('form_create_payroll');
                goURL(base_url + 'services/home');
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
//function change_sales_tax(account){
//    if(parseInt(account)==0){
//           $("#tax_id").show();
//           $("#website").show();
//           $("#password").show();
//       }else{
//           $("#tax_id").hide();
//           $("#website").hide();
//           $("#password").hide();
//       }
//   
//   }
function LeadSourceTypeChange(lead_source_type) {
    clearErrorMessageDiv();
    if (parseInt(lead_source_type) == 1) {
        $(".lead-client-class, .lead-agent-class").hide();
    }
    if (parseInt(lead_source_type) == 8) {
        $(".lead-client-class, .lead-agent-class").hide();
        $(".lead-staff-div").show();
    }
}
function clientTypeChange(client_type, new_reference_id, reference, service_id) {
    clearErrorMessageDiv();
    if (parseInt(client_type) == 0) {
        $('.chosen-select').chosen();
        $('.client_type_field0').prop('required', true);
        $('.client_type_div0').show();
        $('.client_type_field1').val('');
        $('.client_type_field1').prop('required', false);
        $('.client_type_div1').hide();
        $('.display_div').hide();
        if ($('input[type=hidden][name=editval]').val() === '') {
            $.ajax({
                type: 'POST',
                url: base_url + 'services/home/get_existing_client_list',
                success: function (result) {
                    $('#client_list_ddl').html("<option value=''>Select an option</option>" + result);
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
    } else if (parseInt(client_type) == 1) {
        $('.chosen-select').chosen();
        $('.client_type_field1').prop('required', true);
        $('.client_type_div1').show();
        $('.client_type_field0').val('');
        $('.client_type_field0').prop('required', false);
        $('.client_type_div0').hide();
        $('.display_div').show();
        $("#contact-list").html(blank_contact_list());
        $("#owners-list").html(blank_owner_list());
    } else {
        $('.chosen-select').chosen();
        $('.client_type_field1').prop('required', false);
        $('.client_type_div1').hide();
        $('.client_type_field0, .client_type_div1').val('');
        $('.client_type_field0').prop('required', false);
        $('.client_type_div0').hide();
        $('.display_div').hide();
    }
    setReferenceId('', new_reference_id, reference, service_id);
    $('.value_field').val('');
    $('.required_field').prop('required', true);
    $('.disabled_field').prop('disabled', false);
    change_referred_name_status('');
}

function clientTypeYes(client_type) {
    if (parseInt(client_type) == 0) {
        $.ajax({
            type: 'POST',
            url: base_url + 'services/home/clientTypeYes',
            success: function (result) {
                $('#county_div').after(result);
            }
        });
    } else if (parseInt(client_type) == 1) {
        $.ajax({
            type: 'POST',
            // url: base_url + 'services/home/clientTypeYes',
            success: function (result) {
                $('#existing_client_extra_field').hide();
                $('#existing_client_extra_field').remove();
            }
        });
    }

}

function fetchExistingClientData(reference_id, new_reference_id, reference, service_id) {
    clearErrorMessageDiv();
    $('.value_field').val('');
    setReferenceId(reference_id, new_reference_id, reference, service_id);
    if (reference_id != '') {
        get_contact_list(reference_id, 'company', "y");
        $('.required_field').prop('required', false);
        getCompanyData(reference_id);
        get_state_of_incorporation_value(reference_id);
        get_company_type(reference_id);
//        $('.disabled_field').prop('disabled', true);
          $('.disabled_field').prop('disabled', false);
 //get_state_county_val(reference_id)
        payroll_account_details(reference_id);
        $('#exist_client_id').val(reference_id);
    } else {
        $("#contact-list").html(blank_contact_list());
        $("#owners-list").html(blank_owner_list());
        $('.required_field').prop('required', false);
        $('.disabled_field').prop('disabled', false);
    }
}
function get_state_of_incorporation_value(ref_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/get_state_of_incorporation_value',
        data: {
            ref_id: ref_id
        },
        success: function (result) {
            if (result.trim() != '') {
                $("#state").val(result);
            }
        }
    });
}
function get_company_type(ref_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/get_company_type',
        data: {
            ref_id: ref_id
        },
        success: function (result) {
            if (result.trim() != '') {
                $("#type").val(result);
            }
        }
    });
}
function get_state_county_val(ref_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/get_state_county_val',
        data: {
            ref_id: ref_id
        },
        success: function (result) {
            if (result.trim() != '') {
                alert(result);
            }
        }
    });
}
function annual_date(reference_id) {
    var florida = parseInt($('#service_florida').attr('retail_price'));
    var delaware = parseInt($('#service_delaware').attr('retail_price'));
    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/annual_date',
        data: {
            reference: reference_id
        },
        success: function (result) {
            $('#due_date').val();
            if (result != '0') {
                result = JSON.parse(result);
                var state = result.state.trim();
                if (state == 8) {
                    $('#service_delaware').prop("checked", true);
                    $('#service_florida').prop("checked", false);
                    $("#service_florida, #service_delaware").prop("disabled", true);
                    changeServiceRadio(getIdVal('service_delaware'), $('#service_delaware').attr('retail_price'));
                } else if (state == 10) {
                    $('#service_florida').prop("checked", true);
                    $('#service_delaware').prop("checked", false);
                    $("#service_florida, #service_delaware").prop("disabled", true);
                    changeServiceRadio(getIdVal('service_florida'), $('#service_florida').attr('retail_price'));
                } else {
                    $("#service_florida, #service_delaware").prop("disabled", false);
                }
                $('#due_date').val(result.date);




//                console.log(result);
//                alert(result.state);
//                if (result.state.trim() == 8) {
//                    $('#annual_report_florida').removeAttr('checked');
//                    $('#annual_report_delaware').prop('checked', true);
//                    $("#retail-price").val(delaware + registered_agent);
//                    $('#annual_div').show();
//                } else {
//                    $('#annual_report_delaware').removeAttr('checked');
//                    $('#annual_report_florida').prop('checked', true);
//                    $("#retail-price").val(florida);
//                    $('#annual_div').hide();
//                }
//                $('#due_date').val(result.date);
            } else {
                $("#service_florida, #service_delaware").prop("disabled", false);
                $('#due_date').val('');
                return false;
            }
        }
    });
}
function individualTypeChange(client_type, new_reference_id, reference) {
    clearErrorMessageDiv();
    if (parseInt(client_type) == 0) {
        $('.chosen-select').chosen();
        $('.client_type_field0').prop('required', true);
        $('.client_type_div0').show();
        $('.required_field').prop('required', false);
        $('.display_div').hide();
    } else {
        $('.chosen-select').chosen();
        $('.client_type_field0').val('');
        $('.client_type_field0').prop('required', false);
        $('.client_type_div0').hide();
        $('.required_field').prop('required', true);
        $('.display_div').show();
        $("#contact-list").html(blank_contact_list());
        $("#owners-list").html(blank_owner_list());
    }
    $('.value_field').val('');
    change_referred_name_status('');
}
function fetchExistingIndividualData(title_id, new_reference_id, reference) {
    clearErrorMessageDiv();
    $('.value_field').val('');
    if (title_id != '') {
        individualInfoByTitleId(title_id, new_reference_id, reference);
    } else {
        $('.disabled_field').prop('disabled', false);
        $('.required_field').prop('required', true);
        $('.display_div').show();
    }
}


function individualInfoByTitleId(title_id, new_reference_id, reference) {
    $.ajax({
        type: 'POST',
        url: base_url + 'billing/invoice/individual_info_ajax',
        data: {
            title_id: title_id
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result != '0') {
                var individual_info = JSON.parse(result);
                var reference_id = individual_info.individual_id;
                get_contact_list(reference_id, reference, "y");
                setReferenceId(reference_id, new_reference_id, reference, 1);
                $('.display_div').hide();
                $('.required_field').prop('required', false);
            } else {
                setReferenceId('', new_reference_id, reference, 1);
                $('.disabled_field').prop('disabled', false);
                $('.required_field').prop('required', true);
                $('.display_div').show();
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

function setReferenceId(reference_id, new_reference_id, reference, service_id) {
    var result_reference_id = new_reference_id;
    if (reference_id != '') {
        result_reference_id = reference_id;
    }
    $("#reference_id").val(result_reference_id);
//    if ($("a").hasClass("contactadd")) {
//        $("#contact-list").html(blank_contact_list());
//        $(".contactadd").attr('onclick', 'contact_modal("add", "' + reference + '", ' + result_reference_id + '); return false;');
//    }
//    if ($("a").hasClass("owneradd")) {
//        $("#owners-list").html(blank_owner_list());
//        $(".owneradd").attr('onclick', 'open_owner_popup(' + service_id + ',' + result_reference_id + ', 0); return false;');
//    }
//    if ($("a").hasClass("documentadd")) {
//        $("#document-list").html('');
//        $(".documentadd").attr('onclick', 'document_modal("add", "' + reference + '", ' + result_reference_id + '); return false;');
//    }
}

function getCompanyData(reference_id) {
    $.ajax({
        type: "POST",
        data: {
            reference_id: reference_id
        },
        url: base_url + 'services/accounting_services/get_company_data',
        dataType: "html",
        success: function (result) {
            if (result != 0) {
                var res = JSON.parse(result);
                if (res.start_month_year != null && res.start_month_year != '') {
                    $("#start_month_year").val(res.start_month_year);
//                    $("#start_month_year_div").hide();
                } else {
                    $("#start_month_year").val('');
                    //$("#start_month_year_div").show();
                }
                if (res.fein != null && res.fein != '') {
                    $("#fein").val(res.fein);
//                    $("#fein_div").hide();
                    $("#fein_div").show();
                } else {
                    $("#fein").val("");
                    $("#fein_div").show();
                }
            }

        }
    });
}

function cancelRelatedServiceForm(val) {
    clearCacheFormFields(val);
    goURL(base_url + 'services/home/');
}

function related_create_bookkeeping_by_date(val) {
    if (!requiredValidation(val)) {
        return false;
    }

    var form_data = new FormData(document.getElementById(val));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/accounting_services/related_create_bookkeeping_by_date',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result);
//            return false;
            console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home');
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

function related_create_recurring_bookkeeping(val) {
    if (!requiredValidation(val)) {
        return false;
    }

    var form_data = new FormData(document.getElementById(val));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/accounting_services/related_create_recurring_bookkeeping',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result);
//            return false;
            console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home');
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

function related_create_payroll(val) {
    if (!requiredValidation(val)) {
        return false;
    }

    var form_data = new FormData(document.getElementById(val));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/accounting_services/related_create_payroll',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
//            alert(result);
//            return false;
            console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home');
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

function request_create_corporate_amendment() {
    if (!requiredValidation('form_create_corporate_amendment')) {
        return false;
    }
    if ($("#editval").val() != '') {
        $('.disabled_field, .client_type_field0, .type_of_client').removeAttr('disabled');
    }
    $('#type').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_corporate_amendment'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/incorporation/request_create_corporate_amendment',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result); return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function request_create_certificate_of_good_standing() {
    if (!requiredValidation('form_create_certificate_of_good_standing')) {
        return false;
    }
    if ($("#editval").val() != '') {
        $('.disabled_field, .client_type_field0, .type_of_client').removeAttr('disabled');
    }
    $('#type').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_certificate_of_good_standing'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/incorporation/request_create_certificate_of_good_standing',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function request_create_certificate_shares() {
    if (!requiredValidation('form_create_certificate_shares')) {
        return false;
    }
    if ($("#editval").val() != '') {
        $('.disabled_field, .client_type_field0, .type_of_client').removeAttr('disabled');
    }
    $('#type').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_certificate_shares'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/incorporation/request_create_certificate_shares',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result); return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function request_create_operating_agreement() {
    if (!requiredValidation('form_create_operating_agreement')) {
        return false;
    }
    if ($("#editval").val() != '') {
        $('.disabled_field, .client_type_field0, .type_of_client').removeAttr('disabled');
    }
    $('#type').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_operating_agreement'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/incorporation/request_create_operating_agreement',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result);
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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

function service_filter_form() {
    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/home/filter_form',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result);
            $(".ajaxdiv").html(result);
            $("#btn_service").show();
            $("#hiddenflag").val('');
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function changeService(state, section_id_dl, retail_price_dl, section_id_fl, retail_price_fl) {
    if (state == 10) {  // Florida
        $('#service_id').val(section_id_fl);
        $('#retail_price, #retail_price_hdn').val(retail_price_fl);
    } else if (state == 8) {  // Delaware
        $('#service_id').val(section_id_dl);
        $('#retail_price, #retail_price_hdn').val(retail_price_dl);
    } else { // Blank
        $('#service_id').val(section_id_dl);
        $('#retail_price, #retail_price_hdn').val(0);
    }
}

function assignOrder(order_id, staff_id) {
    swal({
        title: 'Are you sure?',
        text: "You want to " + (staff_id == 0 ? 'un' : '') + "assign the order!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, assign!'
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                data: {
                    order_id: order_id,
                    staff_id: staff_id
                },
                url: base_url + 'services/home/assign_order',
                cache: false,
                success: function (result) {
                    if (result != 0) {
                        swal("Success!", "Successfully " + (staff_id == 0 ? 'un' : '') + "assigned!", "success");
//                        if (staff_id == '') {
//                            goURL(base_url + 'services/home/view/' + order_id);
//                        } else {
                        goURL(base_url + 'services/home');
//                        }
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

function assignService(service_id, staff_id) {
    swal({
        title: 'Are you sure?',
        text: "You want to " + (staff_id == 0 ? 'un' : '') + "assign the service!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + (staff_id == 0 ? 'un' : '') + 'assign!'
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                data: {
                    service_id: service_id,
                    staff_id: staff_id
                },
                url: base_url + 'services/home/assign_service',
                cache: false,
                success: function (result) {
                    if (result != 0) {
                        swal("Success!", "Successfully " + (staff_id == 0 ? 'un' : '') + "assigned!", "success");
//                        if (staff_id == '') {
//                            goURL(base_url + 'services/home/view/' + order_id);
//                        } else {
                        goURL(base_url + 'services/home');
//                        }
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

function loadRelatedServiceContainer(service_id) {
    var related_services = [];
    $.each($("input[name='related_services[]']:checked"), function () {
        related_services.push($(this).val());
    });
    console.log(related_services);
    $.ajax({
        type: 'POST',
        data: {
            service_id: service_id,
            relative_service_id: related_services,
        },
        url: base_url + 'services/home/get_related_service_container',
        dataType: 'html',
        success: function (result) {
            $('#related_service_container').html(result);
        }
    });
}

var add_service_notes = () => {
    // alert("Hello");return false;
    var formData = new FormData(document.getElementById('modal_note_form'));
    var orderid = $("#modal_note_form #order_id").val();
    var serviceid = $("#modal_note_form #serviceid").val();
    var ref_id = $("#modal_note_form #reference_id").val();
    // var reference = $("#modal_note_form #reference").val();
    // alert(reference);return false;
    formData.append('service_id', serviceid);
    // alert(orderid);
    // alert(serviceid);
    // return false;

    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/addNotesmodal',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            // alert(result);return false;
            swal({title: "Success!", text: "Successfully Saved!", type: "success"}, function () {
                if (result != '0') {
                    if (ref_id == orderid) {
                        // if (serviceid == "") {
                        var prevnotecount = $("#notecount-" + orderid).attr('count');
                        // alert(prevnotecount);return false;   
                        var notecount = parseInt(prevnotecount) + parseInt(result);
                        $("#notecount-" + orderid).attr('count', notecount);
                        $("#notecount-" + orderid).find('b').html(notecount);
                    }
                    // }
                    else {
                        var prevnotecount = $("#collapse" + orderid).find("#orderservice-" + serviceid + "-" + ref_id).attr('count');
                        var notecount = parseInt(prevnotecount) + parseInt(result);

                        $("#collapse" + orderid).find("#orderservice-" + serviceid + "-" + ref_id).attr('count', notecount);
                        $("#collapse" + orderid).find("#orderservice-" + serviceid + "-" + ref_id).find('b').html(notecount);

                    }
                }
                $("#notecount-" + orderid).removeClass('label label-warning').addClass('label label-danger');
                document.getElementById("modal_note_form").reset();
                $(".removenoteselector").trigger('click');
                $('#show_notes').modal('hide');

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

var update_service_note = () => {
    var formData = new FormData(document.getElementById('modal_note_form_update'));

    $.ajax({
        type: 'POST',
        url: base_url + 'services/home/updateNotes',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            swal({title: "Success!", text: "Successfully Updated!", type: "success"}, function () {
                document.getElementById("modal_note_form_update").reset();
                $('#show_notes').modal('hide');
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

var add_sos = () => {
    var formData = new FormData(document.getElementById('sos_note_form'));
    var orderid = $("#sos_note_form #refid").val();
    formData.append('orderid', orderid);
    var serviceid = $("#sos_note_form #serviceid").val();
    formData.append('serviceid', serviceid);
    $.ajax({
        type: 'POST',
        url: base_url + 'home/addSos',
        data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            swal({title: "Success!", text: "Successfully Saved!", type: "success"}, function () {
                $(".removenoteselector").trigger('click');

                if (result == 0) {
                    var prevsoscountbyme = $(".notification-btn").find(".label-byme").html();
                    var newsoscountbyme = parseInt(prevsoscountbyme) + 1;
                    $(".notification-btn .label-byme").html(newsoscountbyme);
                }

                var prevsoscountofservice = $("#sosservicecount-" + orderid + "-" + serviceid).text();
                var newsoscountofservice = parseInt(prevsoscountofservice) + 1;
                $("#sosservicecount-" + orderid + "-" + serviceid).text(newsoscountofservice);

                $("#sosservicecount-" + orderid).removeClass('label label-primary').addClass('label label-danger');
                $("#sosservicecount-" + orderid).html('<i class="fa fa-bell"></i>');

                $("#order" + orderid).find(".priority").find('.m-t-5').remove();
                $("#order" + orderid).find(".priority").append('<img src="' + base_url + '/assets/img/badge_sos_priority.png" class="m-t-5"/>');

                document.getElementById("sos_note_form").reset();

                $('#showSos').modal('hide');
            });
        },
        beforeSend: function () {
            $("#save_sos").prop('disabled', true).html('Processing...');
            openLoading();
        },
        complete: function (msg) {
            $("#save_sos").removeAttr('disabled').html('Post SOS');
            closeLoading();
        }
    });
}

function sort_service_dashboard(sort_criteria = '', sort_type = '') {
    var form_data = new FormData(document.getElementById('filter-form'));
    if (sort_criteria == '') {
        var sc = $('.dropdown-menu li.active').find('a').attr('id');
        var ex = sc.split('-');

        if (ex[0] == 'office_id' || ex[0] == 'client_name') {
            var sort_criteria = ex[0];
        } else {
            var sort_criteria = 'o.' + ex[0];
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
        url: base_url + 'services/home/sort_service_dashboard',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (service_result) {
            if (service_result.trim() != '') {
                $(".ajaxdiv").html(service_result);
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

function serviceFilter() {
    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/home/service_filter',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            $(".ajaxdiv").html(result);
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function select_other_state(value) {
    if (value == '53') {
        document.getElementById('state_other').style.display = "block";
    } else {
        document.getElementById('state_other').style.display = "none";
    }
}

function save_buyer_info() {
    if (!requiredValidation('buyer_info_form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('buyer_info_form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/tax_services/save_buyer_info',
        dataType: "html",
        cache: false,
        processData: false,
        contentType: false,
        success: function (result) {
            switch (result) {
                case "-1":
                    swal("Error Processing Data");
                    break;
                default:
                    buyer_info(result);
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
function save_seller_info() {
    if (!requiredValidation('seller_info_form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('seller_info_form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/tax_services/save_seller_info',
        dataType: "html",
        enctype: 'multipart/form-data',
        cache: false,
        processData: false,
        contentType: false,
        success: function (result) {
            switch (result) {
                case "-1":
                    swal("Error Processing Data");
                    break;
                default:
                    seller_info(result);
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
function buyer_info(id) {
    $.get(base_url + "services/tax_services/buyer_list/" + id, function (data) {
        $("#buyer_information").append(data);
        $('#buyer_info_modal').hide();
    });
}
function seller_info(id) {
    $.get(base_url + "services/tax_services/seller_list/" + id, function (data) {
        $("#seller_information").append(data);
        $('#seller_info_modal').hide();
    });
}
function delete_buyer(id) {
    swal({
        title: "Are you sure?",
        text: "This buyer will be deleted!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: base_url + 'services/tax_services/delete_buyer_info',
            dataType: "html",
            success: function (result) {
                if (result != 0) {
                    swal("Deleted!", "Buyer info has been deleted.", "success");
                    $("#buyer_id_" + id).remove();
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
function delete_seller(id) {
    swal({
        title: "Are you sure?",
        text: "This seller will be deleted!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: base_url + 'services/tax_services/delete_seller_info',
            dataType: "html",
            success: function (result) {
                if (result != 0) {
                    swal("Deleted!", "Seller info has been deleted.", "success");
                    $("#seller_id_" + id).remove();
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
function update_buyer_info(id) {
    if (!requiredValidation('buyer_info_form')) {
        return false;
    }

    var form_data = new FormData($('#buyer_info_form')[0]);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/tax_services/update_buyer/' + id,
        dataType: "html",
        processData: false,
        contentType: false,
        cache: false,
        success: function (result) {
            switch (result) {
                case "-1":
                    swal("Error Processing Data");
                    break;
                default:
                    $.get(base_url + "services/tax_services/buyer_list/" + id, function (data) {
                        $("#buyer_id_" + id).replaceWith(data);
                        $('#buyer_info_modal').hide();
                    });
            }
        }
    });
}
function update_seller_info(id) {
    if (!requiredValidation('seller_info_form')) {
        return false;
    }

    var form_data = new FormData($('#seller_info_form')[0]);
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/tax_services/update_seller/' + id,
        dataType: "html",
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        success: function (result) {
            switch (result) {
                case "-1":
                    swal("Error Processing Data");
                    break;
                default:
                    $.get(base_url + "services/tax_services/seller_list/" + id, function (data) {
                        $("#seller_id_" + id).replaceWith(data);
                        $('#seller_info_modal').hide();
                    });
            }
        }
    });
}

function request_create_firpta() {
    if (!requiredValidation('form_create_firpta')) {
        return false;
    }
    if ($("#editval").val() != '') {
        $('.disabled_field, .client_type_field0, .type_of_client').removeAttr('disabled');
    }
    $('#type').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_firpta'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/tax_services/request_create_firpta',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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
function get_firpta_buyer_list(id) {
    $.ajax({
        type: "POST",
        data: {
            id: id
        },
        url: base_url + 'services/tax_services/buyer_list_order_id',
        dataType: "html",
        success: function (result) {
            $("#buyer_information").html(result);
        }
    });
}
function get_firpta_seller_list(id) {
    $.ajax({
        type: "POST",
        data: {
            id: id
        },
        url: base_url + 'services/tax_services/seller_list_order_id',
        dataType: "html",
        success: function (result) {
            $("#seller_information").html(result);
        }
    });
}

var saveRelatedService = function () {
    if (!requiredValidation('related_service_form')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('related_service_form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/home/request_save_related_service',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home');
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

var serviceListAjax = function (orderID, allStaffs) {
    if (!$('#collapse' + orderID).hasClass('in')) {
        $('#collapse' + orderID).html('<div class="text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>');
        $.ajax({
            type: "POST",
            data: {
                order_id: orderID,
                all_staffs: allStaffs
            },
            url: base_url + 'services/home/service_list_ajax',
            dataType: "html",
            success: function (result) {
                if (result != 0) {
                    $('#collapse' + orderID).html(result);
                } else {
                    swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
                }
            }
        });
    }
}
function payroll_account_details(reference_id) {
    $.ajax({
        type: "POST",
        data: {
            reference_id: reference_id
        },
        url: base_url + 'services/home/get_payroll_account_list',
        dataType: "html",
        success: function (result) {
//            alert(result);return false;
            if (result) {
                $("#payroll-accounts-details").html(result);
                $("#payroll-accounts-details").show();
            } else {
                $("#payroll-accounts-details").hide();
                $("#bank_name").val('');
                $("#bank_account").val('');
                $("#bank_routing").val('');
            }
        }
    });
}
function set_exist_account_details(bank_name, bank_number, route_number) {
    if (bank_name != '' && bank_number != '' && route_number != '') {
        $("#bank_name").val(bank_name);
        $("#bank_account").val(bank_number);
        $("#bank_routing").val(route_number);
    } else {
        $("#bank_name").val('');
        $("#bank_account").val('');
        $("#bank_routing").val('');
    }
}


function request_create_legal_translations() {
    if (!requiredValidation('form_create_legal_translations')) {
        return false;
    }
    if ($("#editval").val() != '') {
        $('.disabled_field, .client_type_field0, .type_of_client').removeAttr('disabled');
    }
    $('#type').removeAttr('disabled');
    var form_data = new FormData(document.getElementById('form_create_legal_translations'));
//    alert(form_data);return false;
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'services/business_services/request_create_legal_translations',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
           // alert(result);return false;
            //console.log("Result: " + result); return false;
            if (result != 0) {
                swal("Success!", "Successfully saved!", "success");
                goURL(base_url + 'services/home/view/' + result.trim());
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


function change_price(price,val) {
    var changed_price = (price*val);
    if(changed_price != 0){
        document.getElementById("employee-retail-price").value = changed_price;
    }
}


function deactive_service(service_id, is_active = '') {
//     alert(status);return false;
    if (is_active == 'n') {
        var title = 'Do you want to activate?';
        var msg = "Service has been activated successfully!";
    } else {
        title = 'Do you want to deactivate?';
        msg = "Service has been deactivated successfully!";
    }
    $.get(base_url + "administration/service_setup/get_service_setup_relations/" + service_id, function (result) {
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
                            url: base_url + '/administration/service_setup/deactive_service',
                            data: {
                                service_id: service_id
                            },
                            success: function (results) {
                                if (results == 1) {
                                    swal({
                                        title: "Success!",
                                        "text": msg,
                                        "type": "success"
                                    }, function () {
                                        goURL(base_url + 'administration/service_setup');
                                    });
                                } else {
                                    swal("ERROR!", "Unable to change this service status", "error");
                                }
                            }
                        });
                    });
        }
    });
}
