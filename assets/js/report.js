var base_url = document.getElementById('base_url').value;

function loadRoyaltyReportsData() {
	$.ajax({
        type: 'POST',
        url: base_url + 'reports/load_royalty_reports_data',
        success: function (result) {
            $(".ajaxdiv-reports").html(result);
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}