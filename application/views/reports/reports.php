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
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-billing" id="report_billing">Billings</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-action">Actions</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-projects">Projects</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-clients">Clients</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-partners">Partners</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-leads">Leads</a></li>
                                </ul>
                                <div class="tab-content" id="tab-content-div">
                                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-2 m-t-5" style="width: 120px;">
                                                    <h4>Select Period</h4> 
                                                </div>
                                                <div class="col-md-3 p-r-0 p-l-0">
                                                    <input type="text" class="form-control" id="reportrange" name="daterange" placeholder="Select Period">    
                                                </div>
                                                <div class="col-md-2 p-l-0">
                                                    <button type="button" class="btn btn-success" id="report-service-range-btn" style="border-radius: 0;">Apply</button>    
                                                </div>
                                            </div>
                                            <?php 
                                                if (($staff_info['type'] == 1 || $staff_info['department'] == 14) || $staff_info['type'] == 2){
                                                
                                                $current_date = date('m/d/Y');
                                                $dateRangeService = $order_start_date.' - '.$current_date;
                                                    
                                            ?>
                                            <input type="hidden" name="service_range_report_value" id="service_range_report">
                                            <div class="ibox m-t-25" id="service_by_franchise_1" onclick="show_service_franchise_result('franchise','')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Services By Franchisee</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
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
                                            <div class="ibox" id="service_by_department_1" onclick="show_service_franchise_result('department','')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Services By Department</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="service_by_department" style="display: none;"></div>
                                            </div>
                                            <?php
                                                } 
                                                if (($staff_info['type'] == 1 || $staff_info['department'] == 14) || $staff_info['type'] == 2) {
                                            ?>
                                            <div class="ibox" id="service_by_category_1" onclick="show_service_franchise_result('service_category','')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Services By Category</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
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
                                    <div role="tabpanel" id="tab-billing" class="tab-pane">
                                        <div class="panel-body">
                                         <div class="row">
                                                <div class="col-md-2 m-t-5" style="width: 120px;">
                                                    <h4>Select Period</h4> 
                                                </div>
                                                <div class="col-md-3 p-r-0 p-l-0">
                                                    <input type="text" class="form-control" id="reportrange6" name="daterange" placeholder="Select Period">    
                                                </div>
                                                <div class="col-md-2 p-l-0">
                                                    <button type="button" class="btn btn-success" id="report-service-range-btn6" style="border-radius: 0;">Apply</button>
                                                </div>
                                            </div>
                                            <?php 
                                                $current_date = date('m/d/Y');
                                                $dateRangeBilling = $order_start_date.' - '.$current_date;
                                            ?>    
                                            <input type="hidden" name="billing_range_report_value" id="billing_range_report">
                                            <div class="ibox m-t-25" id="billing_invoice_payments_section" onclick="show_billing_data()">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Invoice Payments</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="billing_invoice_payments" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-action" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-2 m-t-5" style="width: 120px;">
                                                    <h4>Select Period</h4> 
                                                </div>
                                                <div class="col-md-3 p-r-0 p-l-0">
                                                    <input type="text" class="form-control" id="reportrange4" name="daterange" placeholder="Select Period">    
                                                </div>
                                                <div class="col-md-2 p-l-0">
                                                    <button type="button" class="btn btn-success" id="report-actions-range-btn" style="border-radius: 0;">Apply</button>    
                                                </div>
                                            </div> 
                                            <div class="ibox m-t-25" id="action_by_office_section" onclick="show_action_data('action_by_office')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Actions By Office</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="action_by_office" style="display: none;"></div>
                                            </div>                                        
                                            <div class="ibox m-t-25" id="action_to_office_section" onclick="show_action_data('action_to_office')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Actions To Office</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="action_to_office" style="display: none;"></div>
                                            </div>
                                            <div class="ibox m-t-25" id="action_by_department_section" onclick="show_action_data('action_by_department')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Actions By Department</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="action_by_department" style="display: none;"></div>
                                            </div>
                                            <div class="ibox m-t-25" id="action_to_department_section" onclick="show_action_data('action_to_department')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Actions To Department</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="action_to_department" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-projects" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-2 m-t-5" style="width: 120px;">
                                                    <h4>Select Period</h4> 
                                                </div>
                                                <div class="col-md-3 p-r-0 p-l-0">
                                                    <input type="text" class="form-control" id="reportrange3" name="daterange" placeholder="Select Period">    
                                                </div>
                                                <div class="col-md-2 p-l-0">
                                                    <button type="button" class="btn btn-success" id="report-projects-range-btn" style="border-radius: 0;">Apply</button>    
                                                </div>
                                            </div>  
                                            <div class="ibox m-t-25" id="projects_by_office_section" onclick="show_project_data('projects_by_office')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Projects By Office</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="projects_by_office" style="display: none;"></div>
                                            </div>                                        
                                            <div class="ibox m-t-25" id="tasks_by_office_section" onclick="show_project_data('tasks_by_office')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Tasks By Office</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="tasks_by_office" style="display: none;"></div>
                                            </div>
                                            <div class="ibox m-t-25" id="projects_to_department_section" onclick="show_project_data('projects_to_department')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Projects To Department</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="projects_to_department" style="display: none;"></div>
                                            </div>
                                            <div class="ibox m-t-25" id="tasks_to_department_section" onclick="show_project_data('tasks_to_department')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Tasks To Department</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="tasks_to_department" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-clients" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="ibox m-t-25" id="total_clients_by_office_section" onclick="show_clients_data('clients_by_office')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Total Clients By Office</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="total_clients_by_office" style="display: none;"></div>
                                            </div>                                        
                                            <div class="ibox m-t-25" id="business_clients_by_office_section" onclick="show_clients_data('business_clients_by_office')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Business Clients By Office</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="business_clients_by_office" style="display: none;"></div>
                                            </div>
                                            <div class="ibox m-t-25" id="individual_clients_by_office_section" onclick="show_clients_data('individual_clients_by_office')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Individual Clients By Office</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="individual_clients_by_office" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-partners" class="tab-pane">
                                        <div class="panel-body"> 
                                            <div class="row">
                                                <div class="col-md-2 m-t-5" style="width: 120px;">
                                                    <h4>Select Period</h4> 
                                                </div>
                                                <div class="col-md-3 p-r-0 p-l-0">
                                                    <input type="text" class="form-control" id="reportrange2" name="daterange" placeholder="Select Period">    
                                                </div>
                                                <div class="col-md-2 p-l-0">
                                                    <button type="button" class="btn btn-success" id="report-partners-range-btn" style="border-radius: 0;">Apply</button>    
                                                </div>
                                            </div>
                                            <?php 
                                                $date_range_partner = $this->session->userdata('date_range_partner');    
                                                if (!empty($date_range_partner)) {
                                                    $dateRangePartner = $date_range_partner;
                                                } 
                                                else {
                                                    $date_service = date('m/d/Y');
                                                    $dateRangePartner = $order_start_date.' - '.$date_service;
                                                }    
                                            ?>
                                            <div class="ibox m-t-25" id="partners_by_type_section" onclick="show_partner_data('<?= $dateRangePartner ?>')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Partners By Type</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="partners_by_type" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-leads" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-2 m-t-5" style="width: 120px;">
                                                    <h4>Select Period</h4> 
                                                </div>
                                                <div class="col-md-3 p-r-0 p-l-0">
                                                    <input type="text" class="form-control" id="reportrange1" name="daterange" placeholder="Select Period">    
                                                </div>
                                                <div class="col-md-2 p-l-0">
                                                    <button type="button" class="btn btn-success" id="report-leads-range-btn" style="border-radius: 0;">Apply</button>    
                                                </div>
                                            </div>    
                                            <div class="ibox m-t-25" id="leads_by_status_section" onclick="show_lead_data('status')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Leads By Status</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="leads_by_status" style="display: none;"></div>
                                            </div>                                        
                                            <div class="ibox m-t-25" id="leads_by_type_section" onclick="show_lead_data('type')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Leads By Type</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="leads_by_type" style="display: none;"></div>
                                            </div>
                                            <div class="ibox m-t-25" id="leads_email_campaign_section" onclick="show_lead_data('mail_campaign')">
                                                <div class="ibox-title p-t-15 p-b-40">
                                                    <h5 class="m-0 f-s-16">Leads Email Campaign</h5>
                                                    <div class="ibox-tools">
                                                        <a class="">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content p-0" id="leads_email_campaign" style="display: none;"></div>
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
</div>
<script type="text/javascript">
        $(function () {
            if('<?= $dateRangeService; ?>' != '') {
                var range = '<?= $dateRangeService ?>';
                var start = range.split("-")[0];
                var end = range.split("-")[1];
            } else {
                var start = moment();
                var end = moment();    
            }
            
            function cb(start, end) {
                if('<?= $dateRangeService; ?>' != '') {
                    $('#reportrange span').html(start + ' - ' + end);
                } else {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'All data': [moment("<?= $order_start_date; ?>", "MM-DD-YYYY"), moment()],
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);

            $("#report-service-range-btn").click(function () {
                var report_range = document.getElementById('reportrange').value;
                show_service_franchise_date(report_range,'range_btn');       
            });
        }); 
        
        $(function () {
            var start = moment();
            var end = moment();
            function cb(start, end) {
                $('#reportrange1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange1').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'All data': [moment("<?= $order_start_date; ?>", "MM-DD-YYYY"), moment()],
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);

            $("#report-leads-range-btn").click(function () {
                var report_range1 = document.getElementById('reportrange1').value;
                show_lead_data('status',report_range1);    
                show_lead_data('type',report_range1);
                show_lead_data('mail_campaign',report_range1);
            });
        }); 
        
        $(function () {
            if('<?= $dateRangePartner; ?>' != '') {
                var range = '<?= $dateRangePartner ?>';
                var start = range.split("-")[0];
                var end = range.split("-")[1];
            } else {
                var start = moment();
                var end = moment();    
            }
            function cb(start, end) {
                if ('<?= $dateRangePartner; ?>' != '') {
                    $('#reportrange2 span').html(start + ' - ' + end);
                } else {
                    $('#reportrange2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            }

            $('#reportrange2').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'All data': [moment("<?= $order_start_date; ?>", "MM-DD-YYYY"), moment()],
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);

            $("#report-partners-range-btn").click(function () {
                var report_range2 = document.getElementById('reportrange2').value;
                get_partner_date_range(report_range2,'range_btn_partner');       
            });
        }); 
        
        $(function () {
            var start = moment();
            var end = moment();
            function cb(start, end) {
                $('#reportrange3 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange3').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'All data': [moment("<?= $order_start_date; ?>", "MM-DD-YYYY"), moment()],
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);

            $("#report-projects-range-btn").click(function () {
                var report_range3 = document.getElementById('reportrange3').value;
                show_project_data('projects_by_office',report_range3);    
            });
        }); 
        
        $(function () {
            var start = moment();
            var end = moment();
            function cb(start, end) {
                $('#reportrange4 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange4').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'All data': [moment("<?= $order_start_date; ?>", "MM-DD-YYYY"), moment()],
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);

            $("#report-actions-range-btn").click(function () {
                var report_range4 = document.getElementById('reportrange4').value;
                show_action_data('action_by_office',report_range4);    
            });
        });
        
        $(function () {
            if('<?= $dateRangeBilling; ?>' != '') {
                var range = '<?= $dateRangeBilling ?>';
                var start = range.split("-")[0];
                var end = range.split("-")[1];
            } else {
                var start = moment();
                var end = moment();    
            }
            function cb(start, end) {
                if ('<?= $dateRangeBilling; ?>' != '') {
                    $('#reportrange6 span').html(start + ' - ' + end);
                } else {
                    $('#reportrange6 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            }

            $('#reportrange6').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'All data': [moment("<?= $order_start_date; ?>", "MM-DD-YYYY"), moment()],
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);

            $("#report-service-range-btn6").click(function () {
                var report_range6 = document.getElementById('reportrange6').value;
                get_billing_date_range(report_range6,'range_btn_billing');    
            });
        });
</script>