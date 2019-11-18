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
               	<input placeholder="dd-mm-yyyy" class="form-control datepicker_range_mdy" type="text" title="" name="daterange" id="date_range"><button type="button" class="btn btn-success" onclick="loadRoyaltyReportsData('',document.getElementById('date_range').value)" style="margin: 0px 0px 0px 5px;border: 0px;border-radius: 0px;">Apply</button>
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
        $('input[name="daterange"]').daterangepicker();
    });	
</script>
