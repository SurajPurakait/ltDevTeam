<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins form-inline">
                <select name="ofc" id="ofc" class="form-control" onchange="loadRoyaltyReportsData(this.value);">
                	<option value="">All Office</option>   
                	<?php
                		load_ddl_option("users_office_list", "","");
                	?>
                </select> &nbsp;
                <input type="text" class="form-control" id="reportrange" name="daterange" placeholder="Select Period">

               	<!-- <input placeholder="dd-mm-yyyy" class="form-control datepicker_range_mdy" type="text" title="" name="daterange" id="date_range"> -->
               	<button type="button" class="btn btn-success" onclick="loadRoyaltyReportsData('',document.getElementById('reportrange').value)" style="margin: 0px 0px 0px 5px;border: 0px;border-radius: 0px;">Apply</button>
                <div class="ibox-content ajaxdiv-reports m-t-25">
                    <div class="">
                        <table id="reports-tab" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="white-space: nowrap;">Date</th>
                                    <th style="white-space: nowrap;">Client Id</th>
                                    <th style="white-space: nowrap;">Invoice Id</th>
                                    <th style="white-space: nowrap;">Service Id</th>
                                    <th style="white-space: nowrap;">Service Name</th>
                                    <th style="white-space: nowrap;">Retail Price</th>
                                    <th style="white-space: nowrap;">Override Price</th>
                                    <th style="white-space: nowrap;">Cost</th>
                                    <th style="white-space: nowrap;">Payment Status</th>
                                    <th style="white-space: nowrap;">Collected</th>
                                    <th style="white-space: nowrap;">Payment Type</th>
                                    <th style="white-space: nowrap;">Authorization Id</th>
                                    <th style="white-space: nowrap;">Reference</th>
                                    <th style="white-space: nowrap;">Total Net</th>
                                    <th style="white-space: nowrap;">Office Fee %</th>
                                    <th style="white-space: nowrap;">Fee With Cost</th>
                                    <th style="white-space: nowrap;">Fee Without Cost</th>
                                </tr>
                            </thead>
                        </table><br>
                        <table class="table table-bordered table-striped">
                        	<?php 
                        		$data = get_total_price_report();
                        	?>
                        	<tr>
                        		<th rowspan="2" style="padding:25px;">Total</th>
                        		<th>Retail Price</th>
                        		<th>Override Price</th>
                        		<th>Cost</th>
                        		<th>Collected</th>
                        		<th>Total Net</th>
                        		<th>Office Fee %</th>
                        		<th>Fee With Cost</th>
                        		<th>Fee Without Cost</th>
                        	</tr>
                        	<tr>
                        		<td><?= $data['retail_price']; ?></td>
                        		<td><?= $data['override_price']; ?></td>
                        		<td><?= $data['cost']; ?></td>
                        		<td><?= $data['collected']; ?></td>
                        		<td><?= $data['total_net']; ?></td>
                        		<td><?= $data['total_net']; ?></td>
                        		<td><?= $data['fee_with_cost']; ?></td>
                        		<td><?= $data['fee_without_cost']; ?></td>           			
                        	</tr>
                        </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	loadRoyaltyReportsData();
		$(function () {
        	var start = moment().subtract(29, 'days');
            var end = moment();
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);
    	});	
</script>
