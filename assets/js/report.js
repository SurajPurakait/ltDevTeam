var base_url = document.getElementById('base_url').value;

function loadRoyaltyReportsData(offce_id = '',date_range = '') {
    $('#reports-tab').DataTable().destroy();

    $('#reports-tab').DataTable({
        'processing': false,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': base_url + 'reports/get_royalty_reports_data',
            'type': 'POST',
            'data': {'ofc': offce_id,'daterange':date_range},
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
// function loadRoyaltyReportsData1(offce_id = '',date_range = '') { 
//     var date = date_range.split('-');
//     var start_date = date[0].split('/');
//     start_date.push(start_date[2],start_date[0],start_date[1]);

//     var end_date = date[1].split('/').reverse().join('-');
//     var date_range = start_date +','+ end_date;
//     alert(date_range);
// }