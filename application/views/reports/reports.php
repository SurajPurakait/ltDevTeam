<?php 
    $staff_info = staff_info();
?>
<div class="wrapper wrapper-content report-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12" id="nav-tabs-div">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a class="nav-link" data-toggle="tab" href="#tab-1">Services</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-2">Billings</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-3">Actions</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-4">Projects</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-5">Clients</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-6">Partners</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-7">Leads</a></li>
                                </ul>
                                <div class="tab-content" id="tab-content-div">
                                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <!-- <div class="row">
                                                <div class="col-md-2">
                                                    <h4 class="bg-success p-5 text-center f-s-16">Period Time</h4>
                                                </div>
                                                <div class="col-md-2">
                                                   <input type="text" class="form-control" id="reportrange" name="daterange" placeholder="Select Period"> 
                                                </div>
                                            </div> -->
                                            <h4 class="m-b-15"> Period Time : <span class="btn-sm btn-default text-dark">Last 30 Days</span></h4>
                                            <?php 
                                                if ($staff_info['type'] == 1 || $staff_info['department'] == 14){
                                            ?>
                                            <div class="ibox m-t-25" id="service_by_franchise_1">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Services By Franchisee</h5>
                                                    <div class="ibox-tools">
                                                        <a class="" onclick="show_service_franchise_result('franchise')">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="service_by_franchise" style="display: none;"></div>
                                            </div>
                                            <?php   
                                                } 
                                                if (($staff_info['type'] == 1 || $staff_info['department'] == 14) || $staff_info['type'] == 2){
                                            ?>
                                            <div class="ibox" id="service_by_department_1">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Services By Department</h5>
                                                    <div class="ibox-tools">
                                                        <a class="" onclick="show_service_franchise_result('department')">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="service_by_department" style="display: none;"></div>
                                            </div>
                                            <?php
                                                } 
                                                if (($staff_info['type'] == 1 || $staff_info['department'] == 14)) {
                                            ?>
                                            <div class="ibox" id="service_by_category_1">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Services By Category</h5>
                                                    <div class="ibox-tools">
                                                        <a class="" onclick="show_service_franchise_result('service_category')">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="service_by_category" style="display: none;">
                                                    
                                                </div>
                                            </div>
                                            <?php 
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-2" class="tab-pane">
                                        <div class="panel-body">
                                            test data
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(function () {
            var start = moment();
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