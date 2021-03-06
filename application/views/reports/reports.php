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
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-billing">Billings</a></li>
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
                                                // $date_range_service_report    
                                            ?>
                                            <div class="ibox m-t-25" id="service_by_franchise_1" onclick="show_service_franchise_result('franchise')">
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
                                            <div class="ibox" id="service_by_department_1" onclick="show_service_franchise_result('department')">
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
                                            <div class="ibox" id="service_by_category_1" onclick="show_service_franchise_result('service_category')">
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
                                            <div class="ibox m-t-25" id="partners_by_type_section" onclick="show_partner_data()">
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

            $("#report-service-range-btn").click(function () {
                var report_range = document.getElementById('reportrange').value;
                show_service_franchise_result('franchise',report_range);       
            });
        }); 
</script>