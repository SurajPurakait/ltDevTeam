var base_url = document.getElementById('base_url').value;

/* royalty report */
function loadRoyaltyReportsData(office = '',date_range = '') {
    $('#reports-tab').DataTable().destroy();

    $('#reports-tab').DataTable({
        'processing': false,
        'serverSide': true,
        'scrollX':true,
        'dom': '<"html5buttons"B>lTfgitp',
        'buttons': [ 
            {extend: 'excel', title: 'RoyaltyReport'},
            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ],
        'serverMethod': 'post',
        'serverMethod': 'post',
        'ajax': {
            'url': base_url + 'reports/get_royalty_reports_data',
            'type': 'POST',
            'data': {'ofc': office,'daterange':date_range},
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
                render: function ( data, type, row ) {
                    return data.split('-')[1]+'-'+data.split('-')[2]+'-'+data.split('-')[0];
                }
            },
            {data: 'client_id'},
            {data: 'invoice_id'},
            {data: 'service_id'},
            {data: 'service_name'},
            {data: 'retail_price',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'override_price',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'cost',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'payment_status'},
            {data: 'collected',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'payment_type'},
            {data: 'authorization_id'},
            {data: 'reference'},
            {data: 'total_net',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'office_fee',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'fee_with_cost',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'fee_without_cost',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )}
        ]
    });
}
/* royalty report total calculation */
function get_total_royalty_report(office = '',date_range = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/royalty_reports_totals',
        data: {'ofc': office,'daterange':date_range},
        success: function (result) {
            $("#total").html(result);
        },
    });
}

/* weekly sales report */
function loadSalesReportsData(office = '',date_range = '') {
    $('#sales-reports-tab').DataTable().destroy();

    $('#sales-reports-tab').DataTable({
        'processing': false,
        'serverSide': true,
        'scrollX':true,
        'dom': '<"html5buttons"B>lTfgitp',
        'buttons': [ 
            {extend: 'excel', title: 'SalesReport'},
            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ],
        'serverMethod': 'post',
        'serverMethod': 'post',
        'ajax': {
            'url': base_url + 'reports/get_weekly_sales_report_data',
            'type': 'POST',
            'data': {'ofc': office,'daterange':date_range},
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
                render: function ( data, type, row ) {
                    return data.split('-')[1]+'-'+data.split('-')[2]+'-'+data.split('-')[0];
                }
            },
            {data: 'client_id'},
            {data: 'service_id'},
            {data: 'service_name'},
            {data: 'status'},
            {data: 'retail_price',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'override_price',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'cost',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'collected',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'total_net',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'franchisee_fee',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'gross_profit',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'notes'}
        ]
    });
}

/* sales report total calculation */
function get_total_sales_report(office = '',date_range = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/weekly_sales_reports_totals',
        data: {'ofc': office,'daterange':date_range},
        success: function (result) {
            $("#total_sales_data").html(result);
        },
    });
}

// show franchisee result
function show_service_franchise_result() {
    $("#service_by_franchise").toggle();
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_service_by_franchise_data',
        success: function (result) {
            $("#service_by_franchise").html(result);
        },
    });
}