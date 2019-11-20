var base_url = document.getElementById('base_url').value;

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

function get_total_price_report(office = '',date_range = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/royalty_reports_totals',
        data: {'ofc': office,'daterange':date_range},
        success: function (result) {
            $("#total").html(result);
        },
    });
}