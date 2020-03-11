var base_url = document.getElementById('base_url').value;

/* royalty report */
function loadRoyaltyReportsData(office = '', date_range = '') {
    $('#reports-tab').DataTable().destroy();
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/royalty_reports_max_limit_count',
        success: function (result) {
            $('#reports-tab').DataTable({
                'processing': false,
                'serverSide': true,
                'scrollX': true,
                "lengthMenu": [[10, 25, 50, 100, result], [10, 25, 50, 100, "All"]],
                "pageLength": 100,
                'dom': '<"html5buttons"B>lTfgitp',
                'buttons': [
                    {
                        extend: 'excel',
                        title: 'RoyaltyReport'
                    },
                    {
                        extend: 'print',
                        title: 'RoyaltyReport',
                        customize: function (win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                'columnDefs': [
                    { width: '100px', targets: 0 }
                ],
                'serverMethod': 'post',
                'serverMethod': 'post',
                'ajax': {
                    'url': base_url + 'reports/get_royalty_reports_data',
                    'type': 'POST',
                    'data': { 'ofc': office, 'daterange': date_range },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                },
                'columns': [
                    {
                        data: 'date',
                        render: function (data, type, row) {
                            return data.split('-')[1] + '-' + data.split('-')[2] + '-' + data.split('-')[0];
                        }
                    },
                    { data: 'client_id' },
                    { data: 'invoice_id' },
                    { data: 'service_id' },
                    { data: 'office_id_name' },
                    { data: 'service_name' },
                    { data: 'retail_price', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'override_price', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'cost', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'payment_status' },
                    { data: 'collected', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'payment_type' },
                    { data: 'authorization_id' },
                    { data: 'reference' },
                    { data: 'total_net', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'office_fee', render: $.fn.dataTable.render.number(',', '.', 0, '', '%') },
                    { data: 'fee_with_cost', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'fee_without_cost', render: $.fn.dataTable.render.number(',', '.', 2, '$') }
                ],
                'columnDefs': [
                    { width: '100px', targets: 0 }
                ],
            });
        },
    });
}
/* royalty report total calculation */
function get_total_royalty_report(office = '', date_range = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/royalty_reports_totals',
        data: { 'ofc': office, 'daterange': date_range },
        success: function (result) {
            $("#total").html(result);
        },
    });
}

/* weekly sales report */
function loadSalesReportsData(office = '', date_range = '') {
    $('#sales-reports-tab').DataTable().destroy();

    $('#sales-reports-tab').DataTable({
        'processing': false,
        'serverSide': true,
        'scrollX': true,
        'dom': '<"html5buttons"B>lTfgitp',
        'buttons': [
            { extend: 'excel', title: 'SalesReport' },
            {
                extend: 'print',
                customize: function (win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
        'columnDefs': [
            { width: '100px', targets: 0 }
        ],
        'serverMethod': 'post',
        'serverMethod': 'post',
        'ajax': {
            'url': base_url + 'reports/get_weekly_sales_report_data',
            'type': 'POST',
            'data': { 'ofc': office, 'daterange': date_range },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        },
        'columns': [
            {
                data: 'date',
                render: function (data, type, row) {
                    return data.split('-')[1] + '-' + data.split('-')[2] + '-' + data.split('-')[0];
                }
            },
            { data: 'client_id' },
            { data: 'service_id' },
            { data: 'service_name' },
            { data: 'status' },
            { data: 'retail_price', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'override_price', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'cost', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'collected', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'total_net', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'franchisee_fee', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'gross_profit', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'notes' }
        ]
    });
}

/* sales report total calculation */
function get_total_sales_report(office = '', date_range = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/weekly_sales_reports_totals',
        data: { 'ofc': office, 'daterange': date_range },
        success: function (result) {
            $("#total_sales_data").html(result);
        },
    });
}

// report service section js
function show_service_franchise_result(category = '', date_range = '', range_btn = '',office='') {
    if (category == 'franchise') {
        $("#service_by_franchise").toggle();
    } else if (category == 'department') {
        $("#service_by_department").toggle();
    } else if (category == 'service_category') {
        $("#service_by_category").toggle();
    }
    var date_range_service = $("#service_range_report").val();

    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_service_by_franchise_data',
        data: { 'category': category, 'date_range': date_range_service, 'range_btn': range_btn , 'fran_office':office },
        success: function (result) {
            // console.log(result);return false;
            if (category == 'franchise') {
                $("#service_by_franchise").html(result);
            } else if (category == 'department') {
                $("#service_by_department").html(result);
            } else if (category == 'service_category') {
                $("#service_by_category").html(result);
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
function show_service_franchise_date(date_range = '', range_btn = '', category = '',franchise_office='') {
    if ($("#service_by_franchise").css('display') == 'block') {
        category = 'franchise';
    } else if ($("#service_by_department").css('display') == 'block') {
        category = 'department';
    } else if ($("#service_by_category").css('display') == 'block') {
        category = 'service_category';
    } else {
        category = 'franchise';
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_range_service_report',
        data: { 'date_range_service': date_range, 'range_btn_service': range_btn },
        success: function (result) {
            $("#service_range_report").val(result);
            if (category == 'franchise') {
                show_service_franchise_result(category, result,'',franchise_office);
                $("#service_by_franchise").show();
            } else if (category == 'department') {
                show_service_franchise_result(category, result,'',franchise_office);
                $("#service_by_department").show();
            } else if (category == 'service_category') {
                show_service_franchise_result(category, result,'',franchise_office);
                $("#service_by_category").show();
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    })
}

function show_billing_data(date_range = '', start_date = '', fran_office = '') {
    $("#billing_invoice_payments").toggle();
    var date_range_check = date_range;
    if (date_range == '') {
        var date_range = $("#billing_range_report").val();
    }
    if (start_date == '') {
        start_date = moment("05-15-2018", "MM-DD-YYYY").format("MM/DD/YYYY");
    }
    var rangeText = '';
    if (date_range == moment(start_date).format("MM/DD/YYYY") + " - " + moment().format("MM/DD/YYYY")) {
        rangeText = "<h4 class='text-success'>Showing All Invoice Data</h4>";
    } else if (date_range == moment().format("MM/DD/YYYY") + " - " + moment().format("MM/DD/YYYY")) {
        rangeText = "<h4 class='text-success'>Showing Results for Today</h4>";
    } else if (date_range == moment().subtract(1, 'days').format("MM/DD/YYYY") + " - " + moment().subtract(1, 'days').format("MM/DD/YYYY")) {
        rangeText = "<h4 class='text-success'>Showing Results for Yesterday</h4>";
    } else if (date_range == moment().subtract(6, 'days').format("MM/DD/YYYY") + " - " + moment().format("MM/DD/YYYY")) {
        rangeText = "<h4 class='text-success'>Showing Results for Last 7 Day</h4>";
    } else if (date_range == moment().subtract(29, 'days').format("MM/DD/YYYY") + " - " + moment().format("MM/DD/YYYY")) {
        rangeText = "<h4 class='text-success'>Showing Results for Last 30 Day</h4>";
    } else if (date_range == moment().startOf('month').format("MM/DD/YYYY") + " - " + moment().endOf('month').format("MM/DD/YYYY")) {
        rangeText = "<h4 class='text-success'>Showing Results for This Month</h4>";
    } else if (date_range == moment().startOf('month').format("MM/DD/YYYY") + " - " + moment().endOf('month').format("MM/DD/YYYY")) {
        rangeText = "<h4 class='text-success'>Showing Results for Last Month</h4>";
    } else {
        if (date_range != '') {
            var start = date_range.split("-")[0];
            var end = date_range.split("-")[1];
            rangeText = "<h4 class='text-success'>Showing results from " + start + " to " + end + "</h4>";
        } else {
            rangeText = "<h4 class='text-success'>Showing All Invoice Data</h4>";
        }
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_range_billing_report',
        data: { 'date_range_billing': date_range },
        success: function (result) {
            $("#billing_range_report").val(result);
            var date_range_billing = $("#billing_range_report").val();

            $.ajax({
                type: 'POST',
                url: base_url + 'reports/get_show_billing_data',
                data: { 'date_range_billing': date_range_billing , 'fran_office':fran_office },
                success: function (res) {
                    $("#billing_invoice_payments").html(res);
                    $("#select_peroid_billing").html(rangeText);
                    if (date_range_check != '') {
                        $("#billing_invoice_payments").show();
                    }
                },
                beforeSend: function () {
                    openLoading();
                },
                complete: function (msg) {
                    closeLoading();
                }
            });
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    })
}

// report action section js
function show_action_data(category = '',fran_office='') {
    var date_range = $("#action_range_report").val();
    if (category == 'action_by_office') {
        $("#action_by_office").toggle();
    } else if (category == 'action_to_office') {
        $("#action_to_office").toggle();
    } else if (category == 'action_by_department') {
        $("#action_by_department").toggle();
    } else if (category == 'action_to_department') {
        $("#action_to_department").toggle();
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_action_data',
        data: { 'category': category, 'date_range': date_range ,'fran_office':fran_office },
        success: function (result) {
            if (category == 'action_by_office') {
                $("#action_by_office").html(result);
            } else if (category == 'action_to_office') {
                $("#action_to_office").html(result);
            } else if (category == 'action_by_department') {
                $("#action_by_department").html(result);
            } else if (category == 'action_to_department') {
                $("#action_to_department").html(result);
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

function get_action_range_date(date_range = "",fran_office = "") {
    // alert($date_range);return false;
    if ($("#action_by_office").css('display') == 'block') {
        category = 'action_by_office';
    } else if ($("#action_to_office").css('display') == 'block') {
        category = 'action_to_office';
    } else if ($("#action_by_department").css('display') == 'block') {
        category = 'action_by_department';
    } else if ($("#action_to_department").css('display') == 'block') {
        category = 'action_to_department';
    } else {
        category = 'action_by_office';
    }

    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_range_action_report',
        data: { 'date_range_action': date_range },
        success: function (result) {
            $("#action_range_report").val(result);
            if (category == 'action_by_office') {
                show_action_data(category, fran_office);
                $("#action_by_office").show();
            } else if (category == 'action_to_office') {
                show_action_data(category, fran_office);
                $("#action_to_office").show();
            } else if (category == 'action_by_department') {
                show_action_data(category, fran_office);
                $("#action_by_department").show();
            } else if (category == 'action_to_department') {
                show_action_data(category, fran_office);
                $("#action_to_department").show();
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    })
}

// report project section js
function show_project_data(category = '',fran_office='') {
    var date_range_project = $("#project_range_report").val();

    if (category == 'projects_by_office') {
        $("#projects_by_office").toggle();
    } else if (category == 'tasks_by_office') {
        $("#tasks_by_office").toggle();
    } else if (category == 'projects_to_department') {
        $("#projects_to_department").toggle();
    } else if (category == 'tasks_to_department') {
        $("#tasks_to_department").toggle();
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_project_data',
        data: { 'category': category, 'date_range': date_range_project ,'fran_office':fran_office },
        success: function (result) {
            if (category == 'projects_by_office') {
                $("#projects_by_office").html(result);
            } else if (category == 'tasks_by_office') {
                $("#tasks_by_office").html(result);
            } else if (category == 'projects_to_department') {
                $("#projects_to_department").html(result);
            } else if (category == 'tasks_to_department') {
                $("#tasks_to_department").html(result);
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

function get_project_date(date_range = '',fran_office='') {
    if ($("#projects_by_office").css('display') == 'block') {
        category = 'projects_by_office';
    } else if ($("#tasks_by_office").css('display') == 'block') {
        category = 'tasks_by_office';
    } else if ($("#projects_to_department").css('display') == 'block') {
        category = 'projects_to_department';
    } else if ($("#tasks_to_department").css('display') == 'block') {
        category = 'tasks_to_department';
    } else {
        category = 'projects_by_office';
    }

    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_range_project_report',
        data: { 'date_range_project': date_range },
        success: function (result) {
            $("#project_range_report").val(result);
            if (category == 'projects_by_office') {
                show_project_data(category, fran_office);
                $("#projects_by_office").show();
            } else if (category == 'tasks_by_office') {
                show_project_data(category, fran_office);
                $("#tasks_by_office").show();
            } else if (category == 'projects_to_department') {
                show_project_data(category, fran_office);
                $("#projects_to_department").show();
            } else if (category == 'tasks_to_department') {
                show_project_data(category, fran_office);
                $("#tasks_to_department").show();
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    })
}

// report lead section js
function show_lead_data(category, date_range = '',fran_office = '') {
    if (category == 'status') {
        $("#leads_by_status").toggle();
    } else if (category == 'type') {
        $("#leads_by_type").toggle();
    } else if (category == 'mail_campaign') {
        $("#leads_email_campaign").toggle();
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_leads_data',
        data: { 'category': category, 'date_range': date_range, 'fran_office':fran_office },
        success: function (result) {
            if (category == 'status') {
                $("#leads_by_status").html(result);
            } else if (category == 'type') {
                $("#leads_by_type").html(result);
            } else if (category == 'mail_campaign') {
                $("#leads_email_campaign").html(result);
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
function get_lead_range(date_range = '',fran_office='') {
    if ($("#leads_by_status").css('display') == 'block') {
        category = 'status';
    } else if ($("#leads_by_type").css('display') == 'block') {
        category = 'type';
    } else if ($("#leads_email_campaign").css('display') == 'block') {
        category = 'mail_campaign';
    } else {
        category = 'status';
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_range_lead_report',
        data: { 'date_range_lead': date_range },
        success: function (result) {
            $("#leads_range_report").val(result);
            if (category == 'status') {
                show_lead_data(category, result, fran_office);
                $("#leads_by_status").show();
            } else if (category == 'type') {
                show_lead_data(category,result ,fran_office);
                $("#leads_by_type").show();
            } else if (category == 'mail_campaign') {
                show_lead_data(category, result,fran_office);
                $("#leads_email_campaign").show();
            }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    })
}

function get_partner_date_range(date_range = '',fran_office = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_range_partners_report',
        data: { 'date_range_partner': date_range },
        success: function (result) {
            $("#partners_range_report").val(result);
            show_partner_data(fran_office);
            $("#partners_by_type").show();
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    })
}

// report partner section js
function show_partner_data(fran_office= '') {
    $("#partners_by_type").toggle();
    var date_range_partner = $("#partners_range_report").val();

    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_partner_data',
        data: { 'date_range': date_range_partner , 'fran_office':fran_office },
        success: function (result) {
            $("#partners_by_type").html(result);
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}

// report service section js
function show_clients_data(category,fran_office='') {
    if (category == 'clients_by_office') {
        $("#total_clients_by_office").toggle();
    } else if (category == 'business_clients_by_office') {
        $("#business_clients_by_office").toggle();
    } else if (category == 'individual_clients_by_office') {
        $("#individual_clients_by_office").toggle();
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_clients_data',
        data: { 'category': category ,'fran_office':fran_office},
        success: function (result) {
            if (category == 'clients_by_office') {
                $("#total_clients_by_office").html(result);
            } else if (category == 'business_clients_by_office') {
                $("#business_clients_by_office").html(result);
            } else if (category == 'individual_clients_by_office') {
                $("#individual_clients_by_office").html(result);
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

// reload data 
function refresh_service_report() {
    $.ajax({
        type: 'POST',
        url: base_url + 'report_dashboard_service_cron.php',
        success: function (result) {
            if (result == 1) {
                swal({
                    title: "Success!",
                    text: "Updated Successfully!",
                    type: "success"
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

function refresh_billing_report() {
    $.ajax({
        type: 'POST',
        url: base_url + 'report_dashboard_billing_cron.php',
        success: function (result) {
            if (result == 1) {
                swal({
                    title: "Success!",
                    text: "Updated Successfully!",
                    type: "success"
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

function refresh_action_report() {
    $.ajax({
        type: 'POST',
        url: base_url + 'report_dashboard_action_cron.php',
        success: function (result) {
            if (result == 1) {
                swal({
                    title: "Success!",
                    text: "Updated Successfully!",
                    type: "success"
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

function reload_royalty_report_data() {
    $.ajax({
        type: 'POST',
        url: base_url + 'royalty_report_cron.php',
        success: function (result) {
            if (result == 1) {
                swal({
                    title: "Success!",
                    text: "Updated Successfully!",
                    type: "success"
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

function reload_sales_report_data() {
    $.ajax({
        type: 'POST',
        url: base_url + 'sales_report_cron.php',
        success: function (result) {
            if (result == 1) {
                swal({
                    title: "Success!",
                    text: "Updated Successfully!",
                    type: "success"
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

function refresh_project_report() {
    $.ajax({
        type: 'POST',
        url: base_url + 'report_dashboard_project_cron.php',
        success: function (result) {
            if (result == 1) {
                swal({
                    title: "Success!",
                    text: "Updated Successfully!",
                    type: "success"
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

function refresh_client_report() {
    $.ajax({
        type: 'POST',
        url: base_url + 'report_dashboard_client_cron.php',
        success: function (result) {
            if (result == 1) {
                swal({
                    title: "Success!",
                    text: "Updated Successfully!",
                    type: "success"
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

function pieChart(className) {
    $('.' + className).each(function () {
        var element = '#' + $(this).attr('id');
        var size = $(this).attr('data-size');
        if (parseInt(size) > 1) {
            // Basic setup
            // ------------------------------
            var dataVariable = $(this).attr('data-json');

            // Add data set
            var data = window[dataVariable];

            // Main variables
            var d3Container = d3.select(element),
                distance = 2, // reserve 2px space for mouseover arc moving
                radius = (size / 2) - distance,
                sum = d3.sum(data, function (d) {
                    return d.value;
                });
            // Tooltip
            // ------------------------------
            var tip = d3.tip()
                .attr('class', 'd3-tip')
                .offset([-10, 0])
                .direction('e')
                .html(function (d) {
                    return "<ul class='list-unstyled mb-5'>" +
                        "<li>" + "<span class='text-semibold pull-right'>" + d.data.section_label + ' : ' + d.value + "</span>" + "</li>" +
                        "</ul>";
                });
            // Create chart
            // ------------------------------

            // Add svg element
            var container = d3Container.append("svg").call(tip);

            // Add SVG group
            var svg = container
                .attr("width", size)
                .attr("height", size)
                .append("g")
                .attr("transform", "translate(" + (size / 2) + "," + (size / 2) + ")");
            // Construct chart layout
            // ------------------------------

            // Pie
            var pie = d3.layout.pie()
                .sort(null)
                .startAngle(Math.PI)
                .endAngle(3 * Math.PI)
                .value(function (d) {
                    return d.value;
                });

            // Arc
            var arc = d3.svg.arc()
                .outerRadius(radius)
                .innerRadius(radius / 2);
            //
            // Append chart elements
            //
            // Group chart elements
            var arcGroup = svg.selectAll(".d3-arc")
                .data(pie(data))
                .enter()
                .append("g")
                .attr("class", "d3-arc")
                .style('stroke', '#fff')
                .style('cursor', 'pointer');

            // Append path
            var arcPath = arcGroup
                .append("path")
                .style("fill", function (d) {
                    return d.data.color;
                });
            // Add tooltip
            arcPath
                .on('mouseover', function (d, i) {

                    // Transition on mouseover
                    d3.select(this)
                        .transition()
                        .duration(500)
                        .ease('elastic')
                        .attr('transform', function (d) {
                            d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                            var x = Math.sin(d.midAngle) * distance;
                            var y = -Math.cos(d.midAngle) * distance;
                            return 'translate(' + x + ',' + y + ')';
                        });
                })
                .on("mousemove", function (d) {

                    // Show tooltip on mousemove
                    tip.show(d)
                        .style("top", (d3.event.pageY - 40) + "px")
                        .style("left", (d3.event.pageX + 30) + "px");
                })

                .on('mouseout', function (d, i) {

                    // Mouseout transition
                    d3.select(this)
                        .transition()
                        .duration(500)
                        .ease('bounce')
                        .attr('transform', 'translate(0,0)');

                    // Hide tooltip
                    tip.hide(d);
                });

            // Animate chart on load
            arcPath
                .transition()
                .delay(function (d, i) {
                    return i * 500;
                })
                .duration(500)
                .attrTween("d", function (d) {
                    var interpolate = d3.interpolate(d.startAngle, d.endAngle);
                    return function (t) {
                        d.endAngle = interpolate(t);
                        return arc(d);
                    };
                });
        }
    });
}
