var base_url = document.getElementById('base_url').value;

function assignContainerAjax(select_type, edit_mode) {
      $.ajax({
        type: 'POST',
        url: base_url + 'referral_partner/referral_partners/load_assign_container',
        data: {
            select_type: select_type,
            edit_mode: edit_mode
        },
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            if (result != '0') {
                $('#assign_container').html(result);
            }
        }
    });
}

function assign_client(){
     if (!requiredValidation('assignto-form')) {
        return false;
    }

    var formData = new FormData(document.getElementById('assignto-form'));
//    alert(formData);

    $.ajax({
        type: 'POST',
        url: base_url + 'referral_partner/Referral_partners/assign_client',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
//            alert(result);return false;
            console.log("Result: " + result);
            if (result != 0) {
//                alert('Hi');
                swal("Success!", "Successfully assigned!", "success");

                goURL(base_url + 'referral_partner/referral_partners/partners');
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


function assign_lead_to(id){
    swal({
        title: "Are you sure?",
        text: "Your want to assign!",
        type: "success",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes, assign it!",
        closeOnConfirm: false
    }, 
       function () {
    $.ajax({
         type: 'POST',
         url: base_url + 'referral_partner/Referral_partners/assign_lead',
         data: {
               lead_id: id
                },
        success: function (result) {
//            alert(result);return false;
            console.log("Result: " + result);
            if (result != 0) {
//                alert('Hi');
                swal("Success!", "Successfully assigned!", "success");

                goURL(base_url + 'referral_partner/referral_partners/lead_dashboard');
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

function show_lead_ref_partner_notes(id) {
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


function show_ref_partner_client_notes_modal(ref_partner_table_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'modal/show_ref_partner_client_notes_modal',
        data: {
            ref_partner_table_id: ref_partner_table_id
        },
        success: function (result) {
             $('#showNotesclient #notes-modal-body').html(result);
             $("#ref_partner_table_id").val(ref_partner_table_id);
            openModal('showNotesclient');
        }
    });
}


function reffer_lead_to_partner() {
    if (!requiredValidation('form_add_new_prospect')) {
        return false;
    }

    var form_data = new FormData(document.getElementById('form_add_new_prospect'));
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
            //console.log(result); return false;
            if (result.trim() == "0") {
                swal("ERROR!", "Lead Prospect Already Exists", "error");
            } else if (result.trim() == "-1") {
                swal("ERROR!", "Unable To Refer Lead Prospect", "error");
            } else {
               swal({title: "Success!", text: "Lead Prospect Successfully Referred!", type: "success"}, function () {
                    goURL(base_url + 'referral_partner/referral_partners/partners');                    
                });
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

function cancel_lead_to_partner() {
    goURL(base_url + 'referral_partner/referral_partners/partners');
}

function ref_partner_filter_form() {
    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'referral_partner/referral_partners/filter_form',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (data) {
            $("#load_data").html(data);
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

function delete_reffererd_leads(id,assigned_client_id){
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this reffered lead!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
    function () {
        $.ajax({
            type: 'POST',
            url: base_url + 'referral_partner/referral_partners/delete_reffererd_lead',
            data: {
                id: id,assigned_client_id:assigned_client_id
            },
            success: function (result) {
                if (result == "1") {
                    swal({
                        title: "Success!",
                        "text": "Reffered Lead been deleted successfully!",
                        "type": "success"
                    }, function () {
                        goURL(base_url + 'referral_partner/referral_partners/leads_ref_by_refpartner_dashboard');
                    });
                } else {
                    swal("ERROR!", "Unable to delete this Reffered Lead!!", "error");
                }
            }
        });
    });
}

var delete_referral_partner = (id) =>{
    // alert(id);return false;
    swal({
        title: "Are you sure want to delete?",
        text: "Your will not be able to recover this referral partner!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
    function () {
        $.ajax({
            type: 'POST',
            url: base_url + 'referral_partner/referral_partners/delete_referral_partner',
            data: {
                id: id
            },
            success: function (result) {
                // alert(result);
                // return false;

                if (result == "1") {
                    swal({
                        title: "Success!",
                        "text": "Referral Partners have been deleted successfully!",
                        "type": "success"
                    }, function () {
                        goURL(base_url + 'referral_partner/referral_partners/partners');
                    });
                } else {
                    swal("ERROR!", "Unable to delete this Reffered Lead!!", "error");
                }
            }
        });
    });
}

function loadPartnerDashboard(status, request) {
    $.ajax({
        type: 'POST',
        url: base_url + 'partners/ajax_dashboard',
        data : { 
            status: status,
            request: request
        },
        success: function (result) {
            if (result.trim() != '') {
                $(".ajaxdiv").html(result);
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

function partnerFilter() {
    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'partners/partner_filter',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            console.log(result);
            $(".ajaxdiv").html(result);
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