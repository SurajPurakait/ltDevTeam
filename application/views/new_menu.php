<!DOCTYPE html>
<html>
    <head>
        <title><?= $title; ?></title>
    <input type="hidden" value="<?= base_url(); ?>" id="base_url">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon-->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?= base_url(); ?>assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

    <!-- Forms plugins -->
    <link href="<?= base_url(); ?>assets/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/cropper/cropper.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/datapicker/daterangepicker-bs3.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css"
          rel="stylesheet">

    <link href="<?= base_url(); ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet">

    <link href="<?= base_url(); ?>assets/css/loading.css" rel="stylesheet">

    <!-- sweetalert -->
    <link href="<?= base_url(); ?>assets/js/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet">
    <!-- c3 pie chart -->
    <link href="<?= base_url(); ?>assets/css/plugins/c3/c3.min.css" rel="stylesheet">

    <script src="<?= base_url(); ?>assets/js/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
    <!-- Mainly scripts -->
    <script src="<?= base_url(); ?>assets/js/scripts.js"></script>
    <script src="<?= base_url(); ?>assets/js/jquery-2.1.1.js"></script>
    <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- sweetalert -->
    <script src="<?= base_url(); ?>assets/js/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
    <!-- Data Tables -->
    <script src="<?= base_url(); ?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?= base_url(); ?>assets/js/inspinia.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins/pace/pace.min.js"></script>

    <!-- Chosen -->
    <script src="<?= base_url(); ?>assets/js/plugins/chosen/chosen.jquery.js"></script>

    <!-- pie chart -->
    <script src="<?= base_url(); ?>assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins/visualization/d3/d3_tooltip.js"></script>

    <script src="<?= base_url(); ?>assets/js/plugins/c3/c3.min.js"></script>

    <!-- JSKnob -->
    <script src="<?= base_url(); ?>assets/js/plugins/jsKnob/jquery.knob.js"></script>

    <!-- Input Mask-->
    <script src="<?= base_url(); ?>assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>

    <!-- Data picker -->
    <script src="<?= base_url(); ?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- bootstrap-touchspin -->
    <script src="<?= base_url(); ?>assets/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

    <!-- NouSlider -->
    <script src="<?= base_url(); ?>assets/js/plugins/nouslider/jquery.nouislider.min.js"></script>

    <!-- Clock picker -->
    <script src="<?= base_url(); ?>assets/js/plugins/clockpicker/clockpicker.js"></script>
    <link href="<?= base_url(); ?>assets/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

    <!-- Switchery -->
    <script src="<?= base_url(); ?>assets/js/plugins/switchery/switchery.js"></script>

    <!-- IonRangeSlider -->
    <script src="<?= base_url(); ?>assets/js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>

    <!-- iCheck -->
    <script src="<?= base_url(); ?>assets/js/plugins/iCheck/icheck.min.js"></script>

    <!-- MENU -->
    <script src="<?= base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Color picker -->
    <script src="<?= base_url(); ?>assets/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

    <!-- Image cropper -->
    <script src="<?= base_url(); ?>assets/js/plugins/cropper/cropper.min.js"></script>

    <link rel="stylesheet" href="<?= base_url(); ?>assets/js/plugins/jquery-ui/jquery-ui.css">
    <script src="<?= base_url(); ?>assets/js/plugins/jquery-ui/jquery-ui.js"></script>

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/plugins/select2/select2.css">
    <script src="<?= base_url(); ?>assets/js/plugins/select2/select2.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- cropper js -->
    <script src="<?= base_url(); ?>assets/js/rcrop.min.js" ></script>
    <link href="<?= base_url(); ?>assets/css/rcrop.min.css" rel="stylesheet">
    <!-- cropper js -->

    <script src="<?= base_url(); ?>assets/js/modal.js"></script>
    <script src="<?= base_url(); ?>assets/js/administration.js"></script>
    <script src="<?= base_url(); ?>assets/js/lead_management.js"></script>
    <script src="<?= base_url(); ?>assets/js/system.js"></script>
    <script src="<?= base_url(); ?>assets/js/services.js"></script>
    <script src="<?= base_url(); ?>assets/js/main_services.js"></script>
    <script src="<?= base_url(); ?>assets/js/videos.js"></script>
    <script src="<?= base_url(); ?>assets/js/operational_manuals.js"></script>
    <script src="<?= base_url(); ?>assets/js/action.js"></script>
    <script src="<?= base_url(); ?>assets/js/billing.js"></script>
    <script src="<?= base_url(); ?>assets/js/referral_partner.js"></script>
    <script src="<?= base_url(); ?>assets/js/newsandupdate.js"></script>
    <script src="<?= base_url(); ?>assets/js/project_template.js"></script>
    <script src="<?= base_url(); ?>assets/js/task.js"></script>
    <script src="<?= base_url(); ?>assets/js/marketing.js"></script>
    <script src="<?= base_url(); ?>assets/js/message.js"></script>
    <script src="<?= base_url(); ?>assets/datepicker.js"></script>
    <script src="<?= base_url(); ?>assets/js/visitation.js"></script>
    <!-- include summernote css/js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/datepicker.css">
    <script>
        $(function () {
            $('.hello').datepicker({
                autoHide: true
            });
            $('.summernote').summernote();
            
        });
        $(window).bind("load", function () {
            $('#loading_modal').css('display', 'none');
        });

    </script>
</head>
<body>
    <div class="modal_loading" id="loading_modal" style="display: block;">
        <div class="cssload-thecube">
            <div class="cssload-cube cssload-c1"></div>
            <div class="cssload-cube cssload-c2"></div>
            <div class="cssload-cube cssload-c4"></div>
            <div class="cssload-cube cssload-c3"></div>
        </div>
        <h2 class="text-center"><strong>Loading.. !</strong> Please Wait.</h2>
    </div>
    <div class="loader-mini"><div class="loading-text"><i class="fa fa-refresh fa-spin fa-fw"></i> Please wait. Loading...</div></div>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            
                <div class="sidebar-collapse" style="overflow: hidden; width: auto; height: 100%;">
                    <ul class="nav" id="side-menu">

                        <li onclick="go('home/dashboard');" class="logo text-center taxleaf-big-logo"><img src="https://leafnet.us:443/uploads/1554926317_103693_taxleaf-logo-TL-CORP.png" class="img-responsive"></li>
                        <li onclick="go('home/dashboard');" class="logo text-center taxleaf-small-logo"><img src="https://leafnet.us:443/uploads/1554926317_103693_taxleaf-logo-TL-CORP.png" class="img-responsive"></li>    

                        <li class="nav-header">                
                            <div class="dropdown profile-element">
                                <label data-toggle="modal" data-target="#fileuploadmodal" class="profile-picture" style="background: url('https://leafnet.us:443/assets/img/user-demo.jpg')" id="profilepicturefield"></label>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
                                    <div class="block m-t-xs text-center"> 
                                        <strong class="font-bold">
                                            ritesh admin<br>CORP                                    
                                        </strong>
                                    </div>
                                    <div class="text-muted text-xs block text-center">
                                        System Admin&nbsp; <b class="caret"></b>
                                    </div>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li>
                                        <a href="https://leafnet.us:443/home/view_profile">Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="https://leafnet.us:443/home/logout">Logout</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="logo-element">
                                <small>Hello!</small><br>
                                <a href="javascript:void(0);" class="show">
                                    ar                    </a>
                            </div>
                        </li>
                        <!-- Home  -->
                        <li>
                            <a href="https://leafnet.us:443/home/dashboard"><i class="fa fa-home"></i>Home</a>
                        </li>
                        <!-- Administration -->
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-gears"></i>
                                <span class="nav-label">Administration</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <a href="https://leafnet.us:443/administration/manage_staff">Manage Staff</a>
                                </li>                               
                                <li>
                                    <a href="https://leafnet.us:443/administration/departments">Departments</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/administration/office">Offices</a>
                                </li>                                
                                <li>
                                    <a href="https://leafnet.us:443/administration/service_setup">Service Setup</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/administration/company_type">Company Type</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/administration/Renewal_dates">Renewal Date</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/administration/Business_client">Sales Tax Rate</a>
                                </li> 
                                <li>
                                    <a href="https://leafnet.us:443/administration/referred_source">Referred by Source</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/administration/manage_log">Manage Log</a>
                                </li>                                                               
                                <li>
                                    <a href="https://leafnet.us:443/administration/paypal_account_setup">Paypal Account Setup</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Actions -->
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-flash"></i>
                                <span class="nav-label">Actions</span>
                                <span class="fa arrow main-cat"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <a href="https://leafnet.us:443/action/home">Dashboard</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/action/home/create_action"><i class="fa fa-plus"></i>Add New Action</a>
                                </li>                        
                                <li>
                                    <a href="https://leafnet.us:443/action/home/sales_tax_process">Sales Tax Processing</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Services -->
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-plus-square"></i>
                                <span class="nav-label">Services</span>
                                <span class="fa arrow main-cat"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <a href="https://leafnet.us:443/services/home">Dashboard</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/services/incorporation"><i class="fa fa-plus"></i>Incorporation</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/services/accounting_services"><i class="fa fa-plus"></i>Accounting</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/services/tax_services"><i class="fa fa-plus"></i>Taxes</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/services/business_services"><i class="fa fa-plus"></i>Business</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/services/partner_services"><i class="fa fa-plus"></i>Partner</a>
                                </li>
                                <li>                                    
                                    <a href="https://leafnet.us:443/services/partner_services">Services Setup</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Billing -->
                        <li>
                            <a href="javascript:void(0);"><i class="fa fa-usd"></i> <span class="nav-label">Billing</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>                            
                                    <a href="https://leafnet.us:443/billing/home/index">Dashboard</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/billing/invoice"><i class="fa fa-plus"></i>Add New Invoice</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/billing/home/documents">Documents</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Clients -->
                        <li>
                            <a href="javascript:void(0);"><i class="fa fa-address-card"></i> <span class="nav-label">Clients</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <a href="https://leafnet.us:443/action/home/business_dashboard">Business</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/action/home/individual_dashboard">Individual</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/action/home/add_client"><i class="fa fa-plus"></i>Add New Client</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/action/home/import_clients">Import Clients</a>
                                </li>
                            </ul>
                        </li>                    
                        <!-- Project Dashboard -->
                        <li>
                            <a href="javascript:void(0);"><i class="fa fa-file"></i> <span class="nav-label">Projects</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>                            
                                    <a href="https://leafnet.us:443/project">Dashboard</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" onclick="CreateProjectModal('add', '');"><i class="fa fa-plus"></i> Add New Project</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"> Manage Templates</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Partners -->
                        <li id="show-menubadge">

                            <a href="javascript:void(0);"><i class="fa fa-users"></i> <span class="nav-label">Partners</span><span class="fa arrow main-cat"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <a href="https://leafnet.us:443/partners">Dashboard</a>
                                </li>
                                <!--                         <li >
                                                            <div class="dashboard-icons pull-right">
                                                                <a href="referral_partner/referral_partners/leads_ref_by_refpartner_dashboard/4/1/0" class="icon-complete-new" data-toggle="tooltip" data-placement="top" title="New"></a>
                                                                <a href="referral_partner/referral_partners/leads_ref_by_refpartner_dashboard/4/1/3" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Active"></a>
                                                            </div>
                                                            <a href="referral_partner/referral_partners/leads_ref_by_refpartner_dashboard/4">Referred Leads</a>
                                                        </li> -->
                                <li>
                                    <a href="https://leafnet.us:443/referral_partner/referral_partners/partners">Partners List</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/referral_partner/referral_partners/new_referral_agent?q=partner"><i class="fa fa-plus"></i> Add New Partner</a>
                                </li>

                                <!--                         <li >
                                                            <a href="partners/create_referral_agent">- New Referral Agent</a>
                                                        </li> -->
                                <li>
                                    <a href="https://leafnet.us:443/partners/referral_agent_type">Referral Agent Type</a>
                                </li>
                            </ul>
                        </li>


                        <!-- Leads -->
                        <li>
                            <a href="javascript:void(0);" class="four-noti">
                                <i class="fa fa-user-plus"></i>
                                <span class="nav-label">Leads</span>
                                <span class="fa arrow main-cat"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <a href="https://leafnet.us:443/lead_management/home">Dashboard</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/lead_management/new_prospect"><i class="fa fa-plus"></i>Add New Lead</a>
                                </li>
                                <li>
                                    <a href="">Events Dashboard</a>
                                </li>
                                <li>
                                    <a href=""><i class="fa fa-plus"></i>Add New Event</a>
                                </li>
                                <li>
                                    <a href="">Source Type</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/lead_management/lead_type">Lead Type</a>
                                </li>                              
                                <li>
                                    <a href="https://leafnet.us:443/lead_management/lead_mail/lead_mail_campaign">Email Campaign</a>
                                </li>                            
                                <li>
                                    <a href="">Import Leads</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Media-->
                        <li id="show-menubadge">
                            <a href="javascript:void(0);"><i class="fa fa-newspaper-o"></i> <span class="nav-label">News &AMP; Updates</span><span class="fa arrow main-cat"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <div class="dashboard-icons pull-right">
                                    </div>
                                    <a href="https://leafnet.us:443/lead_management/event">Dashboard</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/lead_management/event/create_event"><i class="fa fa-plus"></i>Add New</a>
                                </li>
                            </ul>
                        </li>                       

                        <!-- Corporate -->
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-building"></i>
                                <span class="nav-label">Corporate</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">   
                                <li>
                                    <a href="">Operations Manual</a>
                                </li>
                                <li>
                                    <a href="">Training Material</a>
                                </li>
                                <li>
                                    <a href="">Marketing Material</a>
                                </li>
                                <li>
                                    <a href="">Materials Setup</a>
                                </li>
                                <li>
                                    <a href="">Suggestions</a>
                                </li>
                            </ul>    
                        </li>
                        <!--Franchise-->
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-handshake-o"></i>
                                <span class="nav-label">Franchise</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">   
                                <li>
                                    <a href="">Marchant Account</a>
                                </li>
                                <li>
                                    <a href="">Invoices</a>
                                </li>
                                <li>
                                    <a href="">Mettings</a>
                                </li>
                            </ul>    
                        </li>  
                        <!--Reports-->
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-question-circle"></i>
                                <span class="nav-label">Reports</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">   
                                <li>
                                    <a href="https://leafnet.us:443/reports/index/1">Admin</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/reports/index/2">Corporate</a>
                                </li>
                                <li>
                                    <a href="https://leafnet.us:443/reports/index/3">Franchisees</a>
                                </li>
                                <li>
                                    <a href="">Clients</a>
                                </li>
                            </ul>    
                        </li>                        
                        <!-- Contact  -->
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-comment"></i>
                                <span class="nav-label">Contact</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">   
                                <li>
                                    <a href="">General Information</a>
                                </li>                                
                                <li>
                                    <a href="">Leafnet Support</a>
                                </li>
                            </ul> 
                        </li>                        
                    </ul>
                </div>              
   
        </nav>
        <div id="page-wrapper" class="gray-bg <?= ($title == 'Owner | Tax Leaf' || $title == 'Mail Campaign Template | Tax Leaf') ? ' no-margins' : ''; ?>">
            <div class="row" <?= ($title == 'Owner | Tax Leaf' || $title == 'Mail Campaign Template | Tax Leaf') ? 'style="display:none;"' : ''; ?>>
                <div class="taxleaf-small-logo"><img src="<?= base_url(); ?>assets/img/logo-small.png"></div>
                <nav class="navbar navbar-static-top fixed-nav" role="navigation" style="margin-bottom: 0;">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
                    </div>
                    <div class="clearfix wrapper border-bottom white-bg page-heading">
                        <div class="">
                            <h2><?= ucwords(str_replace("_", " ", $main_menu)); ?></h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<?= base_url(); ?>home/dashboard">Home</a>
                                </li>
                                <?php if (isset($main_menu)) { ?>
                                    <li class="active">
                                        <strong><?= $header_title; ?></strong>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="active">
                                        <strong>Home</strong>
                                    </li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                </nav>
            </div>
            <br><br><br><br>
            <center><h1>New Sidebar</h1></center>
            <div class="footer">
                <div class="pull-right">
                    <strong>Copyright</strong> Tax Leaf &copy; <?php echo date("Y"); ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
