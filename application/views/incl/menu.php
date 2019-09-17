<?php
$staff_info = staff_info();
// echo "<pre>";print_r($staff_info);exit;
$user_logo = "";
if (strpos($staff_info['office'], ',') != true) {
    $user_logo = get_user_logo($staff_info['office']);
}
$office_id = get_office_id($staff_info['office']);
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">

            <?php
            if ($user_logo != "" && !file_exists(base_url() . 'uploads/' . $user_logo)) {
                ?>
                <li onclick="go('<?= (staff_info()['type'] != 4) ? 'home/dashboard' : 'referral_partner/referral_partners/referral_partner_dashboard'; ?>');" class ="logo text-center taxleaf-big-logo"><img src="<?= base_url() . 'uploads/' . $user_logo; ?>" class="img-responsive"></li>
                <li onclick="go('<?= (staff_info()['type'] != 4) ? 'home/dashboard' : 'referral_partner/referral_partners/referral_partner_dashboard'; ?>');" class ="logo text-center taxleaf-small-logo"><img src="<?= base_url() . 'uploads/' . $user_logo; ?>" class="img-responsive"></li>    
                <?php
            } else {
                ?> 
                <li onclick="go('<?= (staff_info()['type'] != 4) ? 'home/dashboard' : 'referral_partner/referral_partners/referral_partner_dashboard'; ?>');" class ="logo text-center taxleaf-big-logo"><img src="<?= base_url() ?>assets/img/logo.png" class="img-responsive"></li>
                <li onclick="go('<?= (staff_info()['type'] != 4) ? 'home/dashboard' : 'referral_partner/referral_partners/referral_partner_dashboard'; ?>');" class ="logo text-center taxleaf-small-logo"><img src="<?= base_url() ?>assets/img/logo-small.png"></li>
                <?php
            }
            ?>      
            <li class="nav-header">                
                <div class="dropdown profile-element">
                    <?php //if ($staff_info['type'] != 4) { ?>
                    <?php
                    $profile_picture = get_profile_picture();
                    if ($profile_picture != '') {
                        $full_image = base_url() . 'uploads/' . $profile_picture;
                    } else {
                        $full_image = base_url() . 'assets/img/user-demo.jpg';
                    }
                    ?>
                    <label data-toggle="modal" data-target="#fileuploadmodal" class="profile-picture" style="background: url('<?php echo $full_image; ?>')" id="profilepicturefield"></label>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
                        <div class="block m-t-xs text-center"> 
                            <strong class="font-bold">
                                <?php
                                echo $staff_info['first_name'] . ' ' . $staff_info['last_name'];
                                echo "<br>";
                                echo $office_id;
                                ;
                                ?>
                                <?php
                                if ($staff_info['type'] == 2 && $staff_info['role'] == 4) {
                                    echo ' (Manager)';
                                } elseif ($staff_info['type'] == 3 && $staff_info['role'] == 2) {
                                    echo ' (Manager)';
                                }
                                ?>    
                            </strong>
                        </div>
                        <div class="text-muted text-xs block text-center">
                            <?php if ($staff_info['type'] != 4) { ?>
                                <?= staff_department_name($staff_info['id']); ?>&nbsp;<?= ($staff_info['type'] == 2 || $staff_info['type'] == 3) ? '<br>' . staff_office_name($staff_info['id'], $staff_info['office_manager']) : ''; ?> <b class="caret"></b>
                                <?php
                            } else {
                                echo 'Referral Partner <b class="caret"></b>';
                            }
                            ?>
                        </div>
                    </a>
                    <?php
                    // } else {
                    //     echo '<a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">';
                    //     echo '<div class="text-muted text-xs block text-center">';
                    //     echo 'Referral Partner <b class="caret"></b>';
                    //     echo '</div>';
                    //     echo '</a>';
                    // }
                    ?>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a href="<?php echo base_url(); ?>home/view_profile">Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?= base_url() ?>home/logout">Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    <small>Hello!</small><br/>
                    <a href="javascript:void(0);" class="show">
                        <?= substr($staff_info['last_name'], 0, 1) . substr($staff_info['first_name'], 0, 1); ?>
                    </a>
                </div>
            </li>
            <!-- Home  -->
            <li>
                <a href="<?= base_url((staff_info()['type'] != 4) ? 'home/dashboard' : 'referral_partner/referral_partners/referral_partner_dashboard'); ?>"><i class="fa fa-home"></i>Home</a>
            </li>
            <?php if ($staff_info['type'] != 4) { ?>
                <?php if ($staff_info['department'] == '1') { ?>
                    <!-- Administration -->
                    <li <?= active_menu($main_menu, "administration"); ?> >
                        <a href="javascript:void(0);">
                            <i class="fa fa-gears"></i>
                            <span class="nav-label">Administration</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" style="height: 0px;">
                            <li <?= active_menu($menu, "template"); ?>>
                                <a href="<?= base_url(); ?>administration/template">Project Template</a>
                            </li>
                            <li <?= active_menu($menu, "departments"); ?>>
                                <a href="<?= base_url(); ?>administration/departments">Departments</a>
                            </li>
                            <li <?= active_menu($menu, "franchise"); ?>>
                                <a href="<?= base_url(); ?>administration/office">Offices</a>
                            </li>
                            <li <?= active_menu($menu, "manage_staff"); ?>>
                                <a href="<?= base_url(); ?>administration/manage_staff">Manage Staff</a>
                            </li>
                            <li <?= active_menu($menu, "service_setup"); ?>>
                                <a href="<?= base_url(); ?>administration/service_setup">Service Setup</a>
                            </li>
                            <li <?= active_menu($menu, "company_type"); ?>>
                                <a href="<?= base_url(); ?>administration/company_type">Company Type</a>
                            </li>
                            <li <?= active_menu($menu, "referred_by_source"); ?>>
                                <a href="<?= base_url(); ?>administration/referred_source">Referred by Source</a>
                            </li>
                            <li <?= active_menu($menu, "manage_log"); ?>>
                                <a href="<?= base_url(); ?>administration/manage_log">Manage Log</a>
                            </li>
                            <li <?= active_menu($menu, "business_client"); ?>>
                                <a href="<?= base_url(); ?>administration/Business_client">Sales Tax Rate</a>
                            </li>
                            <li <?= active_menu($menu, "renewal_dates"); ?>>
                                <a href="<?= base_url(); ?>administration/Renewal_dates">Renewal Dates</a>
                            </li>
                            <li <?= active_menu($menu, "paypal_account_setup"); ?>>
                                <a href="<?= base_url(); ?>administration/paypal_account_setup">Paypal Account Setup</a>
                            </li>
                        </ul>
                    </li>

                <?php } ?>
                <!-- Actions -->
                <li <?= active_menu($main_menu, "action"); ?> >
                    <div class="dashboard-icons pull-right">
                        <a href="<?= base_url(); ?>action/home/index/0/0/byme" class="icon-complete-new" data-toggle="tooltip" data-placement="top" title="New"><?= action_list('byme_tome_task', '0'); ?></a>
                        <a href="<?= base_url(); ?>action/home/index/1/0/byme" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Started"><?= action_list('byme_tome_task', '1'); ?></a>
                    </div>
                    <a href="javascript:void(0);">
                        <i class="fa fa-flash"></i>
                        <span class="nav-label">Actions</span>
                        <span class="fa arrow main-cat"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li <?= active_menu($menu, "action_dashboard"); ?>>
                            <a href="<?= base_url(); ?>action/home">Dashboard</a>
                        </li>
                        <li <?= active_menu($menu, "create_action"); ?>>
                            <a href="<?= base_url(); ?>action/home/create_action">- Add New Action</a>
                        </li>                        
                        <li <?= active_menu($menu, "sales_tax_process"); ?>>
                            <a href="<?= base_url(); ?>action/home/sales_tax_process">Sales Tax Processing</a>
                        </li>
                    </ul>
                </li>
                <!-- Services -->
                <li <?= active_menu($main_menu, "services"); ?>>
                    <div class="dashboard-icons pull-right">
                        <a href="<?= base_url(); ?>services/home/index/2" class="icon-complete-new" data-toggle="tooltip" data-placement="top" title="Not Started">
                            <?php
                            if ($staff_info['type'] == 2) {
                                echo count_services(2, 'tome');
                            } elseif ($staff_info['type'] == 3) {
                                echo count_services(2, 'byme');
                            } else {
                                echo count_services(2);
                            }
                            ?>
                        </a>
                        <a href="<?= base_url(); ?>services/home/index/1" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Started">
                            <?php
                            if ($staff_info['type'] == 2) {
                                echo count_services(1, 'tome');
                            } elseif ($staff_info['type'] == 3) {
                                echo count_services(1, 'byme');
                            } else {
                                echo count_services(1);
                            }
                            ?>        
                        </a>
                    </div>
                    <a href="javascript:void(0);">
                        <i class="fa fa-plus-square"></i>
                        <span class="nav-label">Services</span>
                        <span class="fa arrow main-cat"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li <?= active_menu($menu, "service_dashboard"); ?>>
                            <a href="<?= base_url(); ?>services/home">Dashboard</a>
                        </li>
                        <li <?= active_menu($menu, "incorporation"); ?>>
                            <div class="dashboard-icons pull-right">
                                <a href="<?= base_url(); ?>services/home/index/2/1" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Not Started"><?= count_services(2, '', 1); ?></a>
                                <a href="<?= base_url(); ?>services/home/index/1/1" class="icon-complete" data-toggle="tooltip" data-placement="top" title="Started"><?= count_services(1, '', 1); ?></a>
                            </div>
                            <a href="<?= base_url(); ?>services/incorporation">Incorporation</a>
                        </li>
                        <li <?= active_menu($menu, "accounting_services"); ?>>
                            <div class="dashboard-icons pull-right">
                                <a href="<?= base_url(); ?>services/home/index/2/2" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Not Started"><?= count_services(2, '', 2); ?></a>
                                <a href="<?= base_url(); ?>services/home/index/1/2" class="icon-complete" data-toggle="tooltip" data-placement="top" title="Started"><?= count_services(1, '', 2); ?></a>
                            </div>
                            <a href="<?= base_url(); ?>services/accounting_services">Accounting</a>
                        </li>
                        <li <?= active_menu($menu, "tax_services"); ?>>
                            <div class="dashboard-icons pull-right">
                                <a href="<?= base_url(); ?>services/home/index/2/3" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Not Started"><?= count_services(2, '', 3); ?></a>
                                <a href="<?= base_url(); ?>services/home/index/1/3" class="icon-complete" data-toggle="tooltip" data-placement="top" title="Started"><?= count_services(1, '', 3); ?></a>
                            </div>
                            <a href="<?= base_url(); ?>services/tax_services">Tax</a>
                        </li>
                        <li <?= active_menu($menu, "business_services"); ?>>
                            <div class="dashboard-icons pull-right">
                                <a href="<?= base_url(); ?>services/home/index/2/4" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Not Started"><?= count_services(2, '', 4); ?></a>
                                <a href="<?= base_url(); ?>services/home/index/1/4" class="icon-complete" data-toggle="tooltip" data-placement="top" title="Started"><?= count_services(1, '', 4); ?></a>
                            </div>
                            <a href="<?= base_url(); ?>services/business_services">Business</a>
                        </li>
                        <li <?= active_menu($menu, "partner_services"); ?>>
                            <div class="dashboard-icons pull-right">
                                <a href="<?= base_url(); ?>services/home/index/2/5" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Not Started"><?= count_services(2, '', 5); ?></a>
                                <a href="<?= base_url(); ?>services/home/index/1/5" class="icon-complete" data-toggle="tooltip" data-placement="top" title="Started"><?= count_services(1, '', 5); ?></a>
                            </div>
                            <a href="<?= base_url(); ?>services/partner_services">Partner</a>
                        </li>
                    </ul>
                </li>
                <?php // if (in_array(1, explode(',', $staff_info['department'])) || in_array(2, explode(',', $staff_info['department'])) || in_array(3, explode(',', $staff_info['department']))) {     ?>
                <!-- Billing -->
                <li <?= active_menu($main_menu, "billing"); ?> >
                    <a href="javascript:void(0);"><i class="fa fa-usd"></i> <span class="nav-label">Billing</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li <?= active_menu($menu, "billing_dashboard"); ?>>                            
                            <a href="<?= base_url(); ?>billing/home/index">Dashboard</a>
                        </li>
                        <li <?= active_menu($menu, "create_invoice"); ?>>
                            <a href="<?= base_url(); ?>billing/invoice">- Add New Invoice</a>
                        </li>
                        <li <?= active_menu($menu, "documents"); ?>>
                            <a href="<?= base_url(); ?>billing/home/documents">Documents</a>
                        </li>
                    </ul>
                </li>
                <!-- Clients -->
                <li <?= active_menu($main_menu, "clients"); ?> >
                    <a href="javascript:void(0);"><i class="fa fa-address-card"></i> <span class="nav-label">Clients</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li <?= active_menu($menu, "business_dashboard"); ?> >
                            <a href="<?= base_url(); ?>action/home/business_dashboard">Business</a>
                        </li>
                        <li <?= active_menu($menu, "add_business"); ?> >
                            <a href="<?= base_url(); ?>action/home/add_business">- Add New Business</a>
                        </li>
                        <li <?= active_menu($menu, "individual_dashboard"); ?> >
                            <a href="<?= base_url(); ?>action/home/individual_dashboard">Individual</a>
                        </li>
                        <li <?= active_menu($menu, "add_individual"); ?> >
                            <a href="<?= base_url(); ?>action/home/add_individual">- Add New Individual</a>
                        </li>
                        <?php if ($staff_info['department'] == '1') { ?>
                            <li <?= active_menu($menu, "import_clients"); ?> >
                                <a href="<?= base_url(); ?>action/home/import_clients">Import Clients</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>                    
                <!-- Project Dashboard -->
                <?php // if ($staff_info['type'] != 3) { ?>
                    <li <?= active_menu($main_menu, "project_dashboard"); ?> >
                        <a href="javascript:void(0);"><i class="fa fa-file"></i> <span class="nav-label">Projects</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" style="height: 0px;">
                            <li <?= active_menu($menu, "project"); ?>>                            
                                <a href="<?= base_url(); ?>project">Dashboard</a>
                            </li>
                            <li <?= active_menu($menu, "project_dashboard"); ?>>
                                <a href="javascript:void(0);" onclick="CreateProjectModal('add', '');">- Add New Project</a>
                            </li>
                        </ul>
                    </li>
                <?php // } ?>
                <!--Task Dashboard-->
                <?php // if ($staff_info['type'] != 3) { ?>
                    <li <?= active_menu($main_menu, "task_dashboard"); ?> >
                        <a href="<?= base_url(); ?>task"><i class="fa fa-tasks"></i> <span class="nav-label">Tasks</span></a>
                        <!--                        <ul class="nav nav-second-level collapse" style="height: 0px;">
                                                    <li <?//= active_menu($menu, "project"); ?>>                            
                                                        <a href="<?//= base_url(); ?>project">Dashboard</a>
                                                    </li>
                                                    <li <?//= active_menu($menu, "project_dashboard"); ?>>
                                                        <a href="javascript:void(0);" onclick="CreateProjectModal('add', '');">- Add New Project</a>
                                                    </li>
                                                </ul>-->
                    </li>
                <?php // } ?>
    <!--                <li <?= active_menu($main_menu, "messages"); ?> >
    <a href="javascript:void(0);">
        <i class="fa fa-envelope"></i>
        <span class="nav-label">Messages</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse" style="height: 0px;">
                <?php if ($staff_info['type'] == 2 || $staff_info['type'] == 1) : ?>
                                <li <?= active_menu($menu, "messages_2"); ?>>
                                    <a href="<?= base_url(); ?>messages/index/2">For Corporate</a>
                                </li>
                <?php endif; ?>
                <?php if ($staff_info['type'] == 3 || $staff_info['type'] == 1) : ?>
                                <li <?= active_menu($menu, "messages_3"); ?>>
                                    <a href="<?= base_url(); ?>messages/index/3">For Franchise</a>
                                </li>
                <?php endif; ?>
    </ul>
    </li>-->


                <!-- Partners -->
                <li id="show-menubadge" <?= active_menu($main_menu, "referral_partners"); ?> >

                    <a href="javascript:void(0);"><i class="fa fa-users"></i> <span class="nav-label">Partners</span><span class="fa arrow main-cat"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li <?= active_menu($menu, "partners"); ?>>
                            <a href="<?= base_url(); ?>partners">Dashboard</a>
                        </li>
<!--                         <li <?//= active_menu($menu, "leads_ref_by_refpartner_dashboard"); ?>>
                            <div class="dashboard-icons pull-right">
                                <a href="<?//= base_url(); ?>referral_partner/referral_partners/leads_ref_by_refpartner_dashboard/4/1/0" class="icon-complete-new" data-toggle="tooltip" data-placement="top" title="New"><?php // echo count_leads_ref_by_refpartner(1, 0); ?></a>
                                <a href="<?//= base_url(); ?>referral_partner/referral_partners/leads_ref_by_refpartner_dashboard/4/1/3" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Active"><?php // echo count_leads_ref_by_refpartner(1, 3); ?></a>
                            </div>
                            <a href="<?//= base_url(); ?>referral_partner/referral_partners/leads_ref_by_refpartner_dashboard/4">Referred Leads</a>
                        </li> -->
                        <li <?= active_menu($menu, "partners"); ?>>
                            <a href="<?= base_url(); ?>referral_partner/referral_partners/partners">Partners List</a>
                        </li>
                        <li <?= active_menu($menu, "reffer_lead"); ?>>
                            <a href="<?= base_url(); ?>referral_partner/referral_partners/new_referral_agent?q=partner">- Add New Partner</a>
                        </li>
                        
<!--                         <li <?//= active_menu($menu, "partners"); ?>>
                            <a href="<?//= base_url(); ?>partners/create_referral_agent">- New Referral Agent</a>
                        </li> -->
                        <li <?= active_menu($menu, "partners"); ?>>
                            <a href="<?= base_url(); ?>partners/referral_agent_type">Referral Agent Type</a>
                        </li>
                    </ul>
                </li>


                <?php // }     ?>
                <!-- Leads -->
                <li <?= active_menu($main_menu, "leads"); ?> >
                    <div class="dashboard-icons pull-right">
                        <a href="<?= base_url(); ?>lead_management/home/index/0/1" class="icon-complete-new" data-toggle="tooltip" data-placement="top" title="New"><?php echo get_new_lead_count(1); ?></a>
                        <a href="<?= base_url(); ?>lead_management/home/index/3/1" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Active"><?php echo get_active_lead_count(1); ?></a>
                        <div class="clearfix"></div>
                        <a href="<?= base_url(); ?>lead_management/home/index/0/2" class="icon-complete-new" data-toggle="tooltip" data-placement="top" title="New"><?php echo get_new_lead_count(2); ?></a>
                        <a href="<?= base_url(); ?>lead_management/home/index/3/2" class="icon-incomplete" data-toggle="tooltip" data-placement="top" title="Active"><?php echo get_active_lead_count(2); ?></a>
                    </div>
                    <a href="javascript:void(0);" class="four-noti">
                        <i class="fa fa-user-plus"></i>
                        <span class="nav-label">Leads</span>
                        <span class="fa arrow main-cat"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li <?= active_menu($menu, "lead_dashboard"); ?>>
                            <a href="<?= base_url(); ?>lead_management/home">Dashboard</a>
                        </li>
                        <li <?= active_menu($menu, "new_lead"); ?>>
                            <a href="<?= base_url(); ?>lead_management/new_prospect">- Add New Lead</a>
                        </li>
                        <!-- <li <?//= active_menu($menu, "new_referral_agent"); ?>>
                            <a href="<?//= base_url(); ?>lead_management/new_referral_agent">- New Referral Agent</a>
                        </li> -->
                        <!-- <li <?//= active_menu($menu, "events"); ?>>
                            <a href="<?//= base_url(); ?>lead_management/event">Events</a>
                        </li>
                        <li <?//= active_menu($menu, "new_event"); ?>>
                            <a href="<?//= base_url(); ?>lead_management/new_event">- New Event</a>
                        </li> -->
                        <?php if ($staff_info['department'] == '1') { ?>
                            <li <?= active_menu($menu, "lead_type"); ?>>
                                <a href="<?= base_url(); ?>lead_management/lead_type">Lead Type</a>
                            </li>
                            <!-- <li <?//= active_menu($menu, "referral_agent_type"); ?>>
                                <a href="<?//= base_url(); ?>lead_management/referral_agent_type">Referral Agent Type</a>
                            </li> -->
                            <li <?= active_menu($menu, "lead_source"); ?>>
                                <a href="<?= base_url(); ?>lead_management/lead_source">Lead Source</a>
                            </li>
                            <li <?= active_menu($menu, "lead_mail"); ?>>
                                <a href="<?= base_url(); ?>lead_management/lead_mail">Promotion Mails</a>
                            </li>
                            <li <?= active_menu($menu, "lead_mail_campaign"); ?>>
                                <a href="<?= base_url(); ?>lead_management/lead_mail/lead_mail_campaign">Mail Campaign</a>
                            </li>                            
                            <li <?= active_menu($menu, "get_leads"); ?>>
                                <a href="<?= base_url(); ?>administration/get_leads">Get Leads</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <!-- Events -->
                <li id="show-menubadge" <?= active_menu($main_menu, "events"); ?>>
                    <a href="javascript:void(0);"><i class="fa fa-calendar"></i> <span class="nav-label">Events</span><span class="fa arrow main-cat"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li <?= active_menu($menu, "events_dashboard"); ?>>
                            <div class="dashboard-icons pull-right">
                            </div>
                            <a href="<?= base_url(); ?>lead_management/event">Dashboard</a>
                        </li>
                        <li <?= active_menu($menu, "new_event"); ?>>
                            <a href="<?= base_url(); ?>lead_management/new_event">- Add New Event</a>
                        </li>
                    </ul>
                </li>
                <!-- Training Materials -->
                <li <?= active_menu($main_menu, "training_materials"); ?> >
                    <a href="javascript:void(0);">
                        <i class="fa fa-video-camera"></i>
                        <span class="nav-label">Training Materials</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <?php if ($staff_info['type'] != 3) { ?>
                            <li <?= active_menu($menu, "training_materials_dashboard_2"); ?>>
                                <a href="<?= base_url() ?>training_materials/index/2">For Corporate</a>
                            </li>
                        <?php } ?>
                        <li <?= active_menu($menu, "training_materials_dashboard_3"); ?>>
                            <a href="<?= base_url() ?>training_materials/index/3">For Franchisee</a>
                        </li>
                        <?php if ($staff_info['type'] != 3) { ?>
                            <li <?= active_menu($menu, "training_materials_dashboard_4"); ?>>
                                <a href="<?= base_url() ?>training_materials/index/4">For Client</a>
                            </li>
                            <li <?= active_menu($menu, "training_materials_dashboard_"); ?>>
                                <a href="<?= base_url() ?>training_materials/add_training_material">- Add Training Material</a>
                            </li>
                        <?php } ?>
                        <?php if ($staff_info['department'] == '1') { ?>
                            <li <?= active_menu($menu, "training_materials_category"); ?>>
                                <a href="<?= base_url(); ?>training_materials/training_materials_category">Main Category</a>
                            </li>
                            <li <?= active_menu($menu, "training_materials_subcategory"); ?>>
                                <a href="<?= base_url(); ?>training_materials/training_materials_subcategory">Sub Category</a>
                            </li>
                        <?php } ?>
                        <?php if ($staff_info['department'] == '1' || $staff_info['department'] == '9') { ?>
                            <li <?= active_menu($menu, "training_materials_suggestions"); ?>>
                                <a href="<?= base_url(); ?>training_materials/training_materials_suggestions">Suggestions</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <!-- Marketing Materials -->
                <li <?= active_menu($main_menu, "marketing_materials"); ?> >
                    <a href="javascript:void(0);">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="nav-label">Marketing Materials</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">   
                        <li <?= active_menu($menu, "marketing_materials_dashboard"); ?>>
                            <a href="<?= base_url() ?>marketing_materials/index">Dashboard</a>
                        </li>
                        <li <?= active_menu($menu, "marketing_materials_purchase_list"); ?>>
                            <a href="<?= base_url() ?>marketing_materials/marketing_materials_purchase_list">Purchase List</a>
                        </li>
                        <?php if ($staff_info['department'] == '1') { ?>
                            <li <?= active_menu($menu, "marketing_materials_category"); ?>>
                                <a href="<?= base_url(); ?>marketing_materials/marketing_materials_category">Main Category</a>
                            </li>
                            <li <?= active_menu($menu, "marketing_materials_subcategory"); ?>>
                                <a href="<?= base_url(); ?>marketing_materials/marketing_materials_subcategory">Sub Category</a>
                            </li>
                        <?php } ?>
                        <?php if ($staff_info['department'] == '1' || $staff_info['department'] == '9') { ?>
                            <li <?= active_menu($menu, "marketing_materials_suggestions"); ?>>
                                <a href="<?= base_url(); ?>marketing_materials/marketing_materials_suggestions">Suggestions</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <!-- Operational Manuals -->
                <li <?= active_menu($main_menu, "operational_manuals"); ?> >
                    <a href="javascript:void(0);">
                        <i class="fa fa-question-circle"></i>
                        <span class="nav-label">Operational Manuals</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">   
                        <li <?= active_menu($menu, "operational_manuals_dashboard"); ?>>
                            <a href="<?= base_url() ?>operational_manuals/index">Taxleaf Manual</a>
                        </li>
                        <li <?= active_menu($menu, "operational_manuals_forms"); ?>>
                            <a href="<?= base_url() ?>operational_manuals/forms">Forms</a>
                        </li>
                        <?php //if ($staff_info['department'] == '1') {  ?>
                            <!-- <li <?//= active_menu($menu, "operational_manuals_category"); ?>>
                                <a href="<?//= base_url(); ?>operational_manuals/operational_manuals_category">Main Category</a>
                            </li>
                            <li <?//= active_menu($menu, "operational_manuals_subcategory"); ?>>
                                <a href="<?//= base_url(); ?>operational_manuals/operational_manuals_subcategory">Sub Category</a>
                            </li> -->
                        <?php //}  ?>
                    </ul>    
                </li>

                <!--Reports-->
                <li <?= active_menu($main_menu, "reports"); ?>>
                    <a href="javascript:void(0);">
                        <i class="fa fa-question-circle"></i>
                        <span class="nav-label">Reports</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">   
                        <li <?= active_menu($menu, "report_1"); ?>>
                            <a href="<?= base_url() ?>reports/index/1">Admin</a>
                        </li>
                        <li <?= active_menu($menu, "report_2"); ?>>
                            <a href="<?= base_url() ?>reports/index/2">Corporate</a>
                        </li>
                        <li <?= active_menu($menu, "report_3"); ?>>
                            <a href="<?= base_url() ?>reports/index/3">Franchisees</a>
                        </li>
                        <li <?= active_menu($menu, "report_4"); ?>>
                            <a href="<?= base_url() ?>reports/index/4">Franchisees</a>
                        </li>
                    </ul>    
                </li>

                <!-- News and Updates -->
                <li <?= active_menu($main_menu, "news"); ?> >
                    <?php
                    if ($staff_info['type'] != '1') {

                        if ($staff_info['type'] == '2')
                            $ret = count_unread_news_update_by_userId($staff_info['id'], $staff_info['type'], $staff_info['department']);
                        else
                            $ret = count_unread_news_update_by_userId($staff_info['id'], $staff_info['type'], $staff_info['office']);

                        if ($ret) {
                            ?>
                            <a href="javascript:void(0)" class="pull-right notification">
                                <i class="fa fa-bell m-r-0"></i>
                            </a>
                            <?php
                        }
                    }
                    ?>
                    <a href="<?= base_url(); ?>news">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="nav-label">News and Updates</span>                                            
                    </a>
                </li>
                <!-- Contact Us -->
                <li <?= active_menu($main_menu, "contact_us"); ?> >
                    <a href="javascript:void(0);">
                        <i class="fa fa-comment"></i>
                        <span class="nav-label">Contact Us</span>
                    </a>
                </li>

                <?php if ($staff_info['type'] == 2 || $staff_info['type'] == 1) { ?>
                    <!-- Visitation -->
                    <li <?= active_menu($main_menu, "visitation"); ?> >
                        <a href="<?= base_url(); ?>visitation/visitation_home/index">
                            <i class="fa fa-users"></i>
                            <span class="nav-label">Visitation</span>
                        </a>
                    </li>
                <?php } ?>

            <?php } else { ?>
                <li <?= active_menu($main_menu, "referral_partners"); ?> >
                    <a href="javascript:void(0);"><i class="fa fa-users"></i> <span class="nav-label">Referral Partners</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li <?= active_menu($menu, "reffer_partner_dashboard"); ?>>
                            <a href="<?= base_url(); ?>referral_partner/referral_partners/referral_partner_dashboard">Dashboard</a>
                        </li>
                        <li <?= active_menu($menu, "refferred_leads_dashboard"); ?>>
                            <a href="<?= base_url(); ?>referral_partner/referral_partners/refferred_leads">Refered Leads</a>
                        </li>
                    </ul>
                </li>



                <div class="box-profile">
                    <?php
                    $user_who_referred = user_who_referred(sess('user_id'));
                    $referred_info = staff_info_by_id($user_who_referred['office_manager']);
                    $referred_address_info = staff_address_by_id($user_who_referred['office_manager']);
                    if ($referred_info['photo'] != '') {
                        ?>
                        <img src="<?php echo base_url(); ?>uploads/<?php echo $referred_info['photo']; ?>" alt="" class="img-circle"/>
                    <?php } else { ?>
                        <img src="<?php echo base_url(); ?>assets/img/user-demo.jpg" alt="" class="img-circle">
                    <?php } ?>
                    <h5><?php echo $referred_info['last_name'] . ', ' . $referred_info['first_name']; ?> </h5>
                    <p><?php echo staff_office_name($referred_info['id']); ?></p>
                    <hr class="m-t-xs m-b-xs">
                    <p><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $referred_info['user']; ?></p>
                    <p><i class="fa fa-address-card-o" aria-hidden="true"></i> <?php echo $referred_address_info['address'] . " , " . $referred_address_info['city']; ?></p>
                    <p><i class="fa fa-phone" aria-hidden="true"></i> <?php echo ($referred_info['phone'] != '') ? $referred_info['phone'] : 'N/A'; ?></p>
                </div>
            <?php } ?>
        </ul>
    </div>
</nav>
<div id="projectModal" class="modal fade" role="dialog" data-backdrop="static"></div>
<!-- Modal -->
<div id="fileuploadmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload and Crop</h4>
            </div>
            <div class="modal-body">
                <form name="school-logo-form" id="school-logo-form" enctype="multipart/form-data">
                    <div class="image-wrapper"></div>
                    <input id="width" name="width" type="hidden">
                    <input id="height" name="height" type="hidden">
                    <input id="x" name="x" type="hidden">
                    <input id="y" name="y" type="hidden">
                    <input type="file" name="school-logo" id="school-logo" onchange="change_profile_picture(this);">
                </form>   
            </div>
            <div class="modal-footer">
                <input type="button" name="logo-submit" id="logo-submit" value="Crop" onclick="uploadcropperimg();" class="btn btn-primary">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#side-menu').find('a').each(function () {
            if ($(this).attr('href') != 'javascript:void(0);') {
                $(this).click(function () {
                    loadHomeDashboard('stop');
                });
            }
        });
    });
</script>