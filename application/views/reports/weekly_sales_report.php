<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins form-inline">
                <div class="sales_header sticky_report_header m-0" id="salesHeader">
                    <div class="row">
                        <div class="col-md-6">        
                            <select name="ofc[]" id="ofc" class="form-control chosen-select ofc" data-placeholder="Select Office" multiple>
                                <?php
                                load_ddl_option("users_office_list", "", "");
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="reportrange" name="daterange" placeholder="Select Period">
                            <button type="button" class="btn btn-success" id="btn" style="margin: 0px 0px 0px 5px;border: 0px;border-radius: 0px;">Apply</button>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-warning" id="royalty-btn" onclick="reload_sales_report_data()"><i class="fa fa-refresh"></i>&nbsp;Refresh</button>
                        </div>
                    </div>
                    <div id="total_sales_data" class="m-t-25"></div>
                </div>    
                <div class="ibox-content ajaxdiv-reports m-t-0">
                    <div class="" id="dt-reports-wrap">
                        <table id="sales-reports-tab" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="white-space: nowrap; width: 97px;">Date</th>
                                    <th style="white-space: nowrap;">Client Id</th>
                                    <th style="white-space: nowrap;">Service Id</th>
                                    <th style="white-space: nowrap;">Service Name</th>
                                    <th style="white-space: nowrap;">Status</th>
                                    <th style="white-space: nowrap;">Retail Price</th>
                                    <th style="white-space: nowrap;">Price</th>
                                    <th style="white-space: nowrap;">Cost</th>
                                    <th style="white-space: nowrap;">Collected</th>
                                    <th style="white-space: nowrap;">Total Net</th>
                                    <th style="white-space: nowrap;">Franchisee Fee</th>
                                    <th style="white-space: nowrap;">Gross Profit</th>
                                    <th style="white-space: nowrap;">Notes</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    loadSalesReportsData();
    $(function () {
        $(".chosen-select").chosen();
        var start = moment("<?= $start_date; ?>", "MM-DD-YYYY");
        var end = moment();
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Select': [moment("<?= $start_date; ?>", "MM-DD-YYYY"), moment()],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);

        $("#btn").click(function () {
            var report_range = document.getElementById('reportrange').value;
            var office = $('#ofc').val();
            loadSalesReportsData(office, report_range);
            get_total_sales_report(office, report_range);
        });

        get_total_sales_report('', '');
    });
</script>