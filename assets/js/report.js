var base_url = document.getElementById('base_url').value;

function loadRoyaltyReportsData() {
    var ofc = '';
    $('#reports-tab').DataTable({
        'processing': false,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': base_url + 'reports/load_royalty_reports_data',
            'type': 'POST',
            'data': {'ofc': ofc},
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        },
        'columns': [
            {data: 'date'},
            {data: 'client_id'},
            {data: 'invoice_id'},
            {data: 'service_id'},
            {data: 'service_name'},
            {data: 'retail_price'},
            {data: 'override_price'},
            {data: 'cost'},
            {data: 'payment_status'},
            {data: 'collected'},
            {data: 'payment_type'},
            {data: 'authorization_id'},
            {data: 'reference'},
            {data: 'total_net'},
            {data: 'office_fee'},
            {data: 'fee_with_cost'},
            {data: 'fee_without_cost'}
        ]
    });
}