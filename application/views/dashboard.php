<?php
$staffInfo = staff_info();
$stafftype = $staffInfo['type'];
$staffrole = $staffInfo['role'];
$user_id = sess('user_id');
$staff_office_array = explode(',', $staffInfo['office']);
$staff_department_array = explode(',', $staffInfo['department']);
?>
<script src="<?= base_url(); ?>assets/js/dashboard.js"></script>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-12 text-center text-uppercase welcome-note">
            <?php
                $staff_info = staff_info();
                $user_logo = "";
                if (strpos($staff_info['office'], ',') != true) {
                    $user_logo = get_user_logo($staff_info['office']);
                }

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
            <h3 class="p-20 m-b-20" style="background-color: white"><span style="color:black">Hello,</span> <span style="color:green"><?= $staffInfo['first_name'] . " " . $staffInfo['last_name']; ?></span> <span style="color:black">Welcome to leafnet</span></h3>

        </div>
        <div class="col-lg-4">
            <div class="ibox" id="widget_action">
                <div class="ibox-title">
                    <h5 class="">Actions</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="loadHomeDashboard('action', '<?= sess('user_id'); ?>', '', '', '');">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">                            
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('action', '<?= sess('user_id'); ?>', '', '', '');setIdVal('action_office_ddl', '');setIdVal('action_department_ddl', '');"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding" style="display: none;">
                    <div class="p-10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Office: </label>
                                    <?php if ($stafftype == 1 || in_array(14, $staff_department_array) || count($staff_office_array) > 1): ?>
                                        <select class="form-control" id="action_office_ddl" onchange="loadHomeDashboard('action', <?= sess('user_id'); ?>, this.value, getIdVal('action_department_ddl'), '');showDepartmentDdl(this.value);">
                                            <option value="">---- All ----</option>
                                            <?php foreach ($office_list as $ol) : ?>
                                                <?php if ($stafftype == 1 || in_array(14, $staff_department_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php elseif (in_array($ol['id'], $staff_office_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <h3 class="label label-default"><?= get_office_info_by_id($staff_office_array[0])['name']; ?></h3>
                                    <?php endif; ?>
                                    <input type="hidden" id="corporate_office_list" value="<?= implode(',', array_column($corporate_office_list, 'id')); ?>">
                                </div>
                            </div>
                            <?php if ($stafftype != 3): ?>
                                <div class="col-md-6 action_department_div">
                                    <div class="form-group">
                                        <label>Department: </label>
                                        <?php if ($stafftype == 1 || in_array(14, $staff_department_array) || count($staff_department_array) > 1): ?>
                                            <select class="form-control" id="action_department_ddl" onchange="loadHomeDashboard('action', <?= sess('user_id'); ?>, getIdVal('action_office_ddl'), this.value, '');">
                                                <option value="">---- All ----</option>
                                                <?php foreach ($department_list as $dl) : ?>
                                                    <?php if ($stafftype == 1 || in_array(14, $staff_department_array)): ?>
                                                        <option value="<?= $dl['id']; ?>"><?= $dl['name']; ?></option>
                                                    <?php elseif (in_array($dl['id'], $staff_department_array)): ?>
                                                        <option value="<?= $dl['id']; ?>"><?= $dl['name']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php else: ?>
                                            <h3 class="label label-default"><?= get_department_info_by_id($staff_department_array[0])['name']; ?></h3>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="action-section text-uppercase"></div>                    
                </div>
            </div>

            <div class="ibox" id="widget_service">
                <div class="ibox-title">
                    <h5 class="">Services</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="loadHomeDashboard('service', '<?= sess('user_id'); ?>', '', '', '');">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('service', '<?= sess('user_id'); ?>', '', '', '');setIdVal('service_office_ddl', '');"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding" style="display: none;">
                    <div class="p-10">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Office: </label>
                                    <?php if ($stafftype == 1 || in_array(14, $staff_department_array) || count($staff_office_array) > 1): ?>
                                        <select class="form-control" id="service_office_ddl" onchange="loadHomeDashboard('service', <?= sess('user_id'); ?>, this.value, '', '');">
                                            <option value="">---- All Options ----</option>
                                            <?php foreach ($office_list as $ol) : ?>
                                                <?php if ($stafftype == 1 || in_array(14, $staff_department_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php elseif (in_array($ol['id'], $staff_office_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <h3 class="label label-default"><?= get_office_info_by_id($staff_office_array[0])['name']; ?></h3>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="service-section text-uppercase"></div>
                </div>
            </div>

            <div class="ibox" id="widget_billing">
                <div class="ibox-title">
                    <h5 class="">Billing</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="loadHomeDashboard('billing', '<?= sess('user_id'); ?>', '', '', '');">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">                            
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('billing', '<?= sess('user_id'); ?>', '', '', '');setIdVal('billing_office_ddl', '');"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding" style="display: none;">
                    <div class="p-10">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Office: </label>
                                    <?php if ($stafftype == 1 || in_array(14, $staff_department_array) || count($staff_office_array) > 1): ?>
                                        <select class="form-control" id="billing_office_ddl" onchange="loadHomeDashboard('billing', <?= sess('user_id'); ?>, this.value, '', '');">
                                            <option value="">---- All Options ----</option>
                                            <?php foreach ($office_list as $ol) : ?>
                                                <?php if ($stafftype == 1 || in_array(14, $staff_department_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php elseif (in_array($ol['id'], $staff_office_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <h3 class="label label-default"><?= get_office_info_by_id($staff_office_array[0])['name']; ?></h3>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="billing-section text-uppercase"></div>
                </div>
            </div>

            <div class="ibox" id="widget_partner">
                <div class="ibox-title">
                    <h5 class="">Partners</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="loadHomeDashboard('partner', '<?= sess('user_id'); ?>', '', '', '');">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('partner', '<?= sess('user_id'); ?>', '', '', '');setIdVal('lead_type_ddl', '', '');"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding">
                    <div class="partner-section text-uppercase"></div>
                </div>
            </div>

            <div class="ibox" id="widget_report">
                <div class="ibox-title">
                    <h5 class="">Reports</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick=""><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding" style="display: none;">
                    <div class="report-section text-uppercase"></div>
                </div>
            </div>
        </div>        

        <div class="col-lg-4">
            <div class="ibox" id="widget_task">
                <div class="ibox-title">
                    <h5 class="">Tasks</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick=""><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding" style="display: none;">
                    <div class="task-section text-uppercase"></div>
                </div>
            </div>            
            
            <div class="ibox" id="widget_project">
                <div class="ibox-title">
                    <h5 class="">Projects</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick=""><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding" style="display: none;">
                    <div class="project-section text-uppercase"></div>
                </div>
            </div>

            <div class="ibox" id="widget_client">
                <div class="ibox-title">
                    <h5 class="">Clients</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="loadHomeDashboard('client', '<?= sess('user_id'); ?>', '', '', '');">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('client', '<?= sess('user_id'); ?>', '', '', '');setIdVal('client_office_ddl', '');"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding" style="display: none;">
                    <div class="p-10">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Office: </label>
                                    <?php if ($stafftype == 1 || in_array(14, $staff_department_array) || count($staff_office_array) > 1): ?>
                                        <select class="form-control" id="client_office_ddl" onchange="loadHomeDashboard('client', <?= sess('user_id'); ?>, this.value, '', '');">
                                            <option value="">---- All Options ----</option>
                                            <?php foreach ($office_list as $ol) : ?>
                                                <?php if ($stafftype == 1 || in_array(14, $staff_department_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php elseif (in_array($ol['id'], $staff_office_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <h3 class="label label-default"><?= get_office_info_by_id($staff_office_array[0])['name']; ?></h3>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="client-section text-uppercase"></div>
                </div>
            </div>
            
            <div class="ibox" id="widget_lead">
                <div class="ibox-title">
                    <h5 class="">Leads</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="loadHomeDashboard('lead', '<?= sess('user_id'); ?>', '', '', '');">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">                            
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('lead', '<?= sess('user_id'); ?>', '', '', '');setIdVal('lead_type_ddl', '', '');"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding" style="display: none;">
                    <div class="p-10">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Lead type: </label>
                                    <select class="form-control" id="lead_type_ddl" onchange="loadHomeDashboard('lead', <?= sess('user_id'); ?>, '', '', this.value);">
                                        <option value="">---- All Options ----</option>
                                        <?php foreach ($lead_type_list as $ltl) : ?>
                                            <option value="<?= $ltl['id']; ?>"><?= $ltl['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lead-section text-uppercase"></div>
                </div>
            </div>

            <div class="ibox" id="widget_event">
                <div class="ibox-title">
                    <h5 class="">Events</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)" onclick="loadHomeDashboard('event', '<?= sess('user_id'); ?>', '', '', '');">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-5">
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('event', '<?= sess('user_id'); ?>', '', '', '');setIdVal('event_office_ddl', '');"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content no-padding" style="display: none;">

                    <div class="p-10">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Office: </label>
                                    <?php if ($stafftype == 1 || in_array(14, $staff_department_array) || count($staff_office_array) > 1): ?>
                                        <select class="form-control" id="event_office_ddl" onchange="loadHomeDashboard('event', <?= sess('user_id'); ?>, this.value, '', '');">
                                            <option value="">---- All Options ----</option>
                                            <?php foreach ($office_list as $ol) : ?>
                                                <?php if ($stafftype == 1 || in_array(14, $staff_department_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php elseif (in_array($ol['id'], $staff_office_array)): ?>
                                                    <option value="<?= $ol['id']; ?>"><?= $ol['name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <h3 class="label label-default"><?= get_office_info_by_id($staff_office_array[0])['name']; ?></h3>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="event-section text-uppercase"></div>
                </div>
            </div>


        </div>

        <div class="col-lg-4">
            <div class="ibox" id="widget_sos">
                <div class="ibox-title">
                    <h5 class="">SOS Notifications</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right m-r-10">
                            <div class="dropdown pull-right m-l-10">                            
                                <!--<i class="fa fa-refresh" title="Loading"></i>-->
                                <a href="javascript:void(0);" title="Clear All" onclick="clearSOSList('<?= sess('user_id'); ?>');"><i class="fa fa-trash-o"></i></a>
                            </div>
                            <button class="btn btn-white btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-filter"></i> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" onclick="displaySOSItems('order');">Services</a></li>
                                <li><a href="javascript:void(0);" onclick="displaySOSItems('action');">Actions</a></li>
                            </ul>
                        </div> 
                        <div class="dropdown pull-right m-r-10">
                            <button class="btn btn-white btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-calendar"></i> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" onclick="displaySOSItems('today');">Today</a></li>
                                <li><a href="javascript:void(0);" onclick="displaySOSItems('yesterday');">Yesterday</a></li>
                                <li><a href="javascript:void(0);" onclick="displaySOSItems('last7');">Last 7 Days</a></li>
                                <li><a href="javascript:void(0);" onclick="displaySOSItems('last30');">Last 30 Days</a></li>
                                <li><a href="javascript:void(0);" onclick="displaySOSItems('more30');">More than 30 Days</a></li>
                            </ul>
                        </div>
                        <div class="dropdown pull-right m-r-10">                            
                            <!--<i class="fa fa-refresh" title="Loading"></i>-->
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('sos', '<?= sess('user_id'); ?>', '', '');"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12 text-right">
                        </div>
                    </div>
                    <div class="sos-section"></div>
                    <div class="clear-sos"></div>
                </div>
            </div>

            <div class="ibox" id="news_updates">
                <div class="ibox-title">
                    <h5 class="">NEWS AND UPDATES</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right">
                            <div class="dropdown pull-right m-r-5 m-l-5">                            
                                <i class="fa fa-refresh" title="Loading"></i>
                                <a href="javascript:void(0);" title="Clear All" onclick="loadHomeDashboard('news_update', '<?= sess('user_id'); ?>', '', '', '', '', '', '', 'clear');"><i class="fa fa-trash-o"></i></a>
                            </div>
                            <button class="btn btn-white btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-filter"></i> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" onclick="displayNewsUpdate('news');">News</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNewsUpdate('update');">Update</a></li>
                            </ul>
                        </div>
                        <div class="dropdown pull-right m-r-5">
                            <button class="btn btn-white btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-calendar"></i> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" onclick="displayNewsUpdate('today');">Today</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNewsUpdate('yesterday');">Yesterday</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNewsUpdate('last7');">Last 7 Days</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNewsUpdate('last30');">Last 30 Days</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNewsUpdate('more30');">More than 30 Days</a></li>
                            </ul>
                        </div>
                        <div class="dropdown pull-right m-r-5">                            
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('news_update', '<?= sess('user_id'); ?>', '', '');"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12 text-right">
                        </div>
                    </div>
                    <div class="news_update-section"></div>
                </div>
            </div>

            <div class="ibox" id="widget_notification">
                <div class="ibox-title">
                    <h5 class="">Notifications</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="javascript:void(0)">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="dropdown pull-right">
                            <div class="dropdown pull-right m-r-5 m-l-5">                            
                                <!--<i class="fa fa-refresh" title="Loading"></i>-->
                                <a href="javascript:void(0);" title="Clear All" onclick="clearNotificationList('<?= sess('user_id'); ?>');"><i class="fa fa-trash-o"></i></a>
                            </div>
                            <button class="btn btn-white btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-filter"></i> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" onclick="displayNotificationItems('action');">Action</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNotificationItems('invoice');">Billing</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNotificationItems('order');">Service</a></li>
                            </ul>
                        </div>
                        <div class="dropdown pull-right m-r-5">
                            <button class="btn btn-white btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-calendar"></i> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" onclick="displayNotificationItems('today');">Today</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNotificationItems('yesterday');">Yesterday</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNotificationItems('last7');">Last 7 Days</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNotificationItems('last30');">Last 30 Days</a></li>
                                <li><a href="javascript:void(0);" onclick="displayNotificationItems('more30');">More than 30 Days</a></li>
                            </ul>
                        </div>
                        <div class="dropdown pull-right m-r-5">                            
                            <i class="fa fa-refresh" title="Loading"></i>
                            <a href="javascript:void(0);" title="Refresh" onclick="loadHomeDashboard('notification', '<?= sess('user_id'); ?>', '', '', '', '', '', 'refresh');"><i class="fa fa-refresh"></i></a>
                        </div>
                        <div class="dropdown pull-right m-r-5"> 
                            <button class="btn btn-white btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-user-circle-o"></i> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" onclick="loadHomeDashboard('notification', '<?= sess('user_id') ?>', '', '', '', '', '', '', '', 'forme');">By Me</a></li>
                                <li><a href="javascript:void(0);" onclick="loadHomeDashboard('notification', '<?= sess('user_id') ?>', '', '', '', '', '', '', '', 'forother');">By Others</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="notification-section"></div>
                    <div class="clear-notification"></div>
                </div>
                <div class=""></div>
            </div>            
        </div>
    </div>
</div>
<script type="text/javascript">
    loadHomeDashboard('sos', '<?= sess('user_id'); ?>', '', '', '');
    loadHomeDashboard('notification', '<?= sess('user_id') ?>', '', '', '', '', '', '', '', 'forme');
    loadHomeDashboard('news_update', '<?= sess('user_id'); ?>', '', '', '');
//    loadHomeDashboard('service', '<?//= sess('user_id'); ?>', '', '', '');
//    loadHomeDashboard('action', '<?//= sess('user_id'); ?>', '', '', '');
    function displaySOSItems(findType) {
        $('.sos-item').hide();
        $('.sos-' + findType).show();
        if (findType == 'item') {
            $('.sos-see-more-btn').attr('onclick', 'displaySOSItems("show");').html('<i class="fa fa-arrow-up"></i> Less item');
        }
        if (findType == 'show') {
            $('.sos-see-more-btn').attr('onclick', 'displaySOSItems("item");').html('<i class="fa fa-arrow-down"></i> Show More');
        }
        if ($('.sos-' + findType).length == 0) {
            $('.sos-empty').show();
        } else {
            $('.sos-empty').hide();
        }
    }

    function displayNewsUpdate(findType) {
        $('.news-item').hide();
        $('.newss-' + findType).show();
        if (findType == 'item') {
            $('.newss-see-more-btn').attr('onclick', 'displayNewsUpdate("show");').html('<i class="fa fa-arrow-up"></i> Less item');
        }
        if (findType == 'show') {
            $('.newss-see-more-btn').attr('onclick', 'displayNewsUpdate("item");').html('<i class="fa fa-arrow-down"></i> Show More');
        }
        if ($('.newss-' + findType).length == 0) {
            $('.newss-empty').show();
        } else {
            $('.newss-empty').hide();
        }
    }
    function displayNotificationItems(findType) {
        $('.notification-item').hide();
        $('.notification-' + findType).show();
        if (findType == 'item') {
            $('.notification-see-more-btn').attr('onclick', 'displayNotificationItems("show");').html('<i class="fa fa-arrow-up"></i> Less item');
        }
        if (findType == 'show') {
            $('.notification-see-more-btn').attr('onclick', 'displayNotificationItems("item");').html('<i class="fa fa-arrow-down"></i> Show More');
        }
        if ($('.notification-' + findType).length == 0) {
            $('.notification-empty').show();
        } else {
            $('.notification-empty').hide();
        }
    }
    function showDepartmentDdl(officeID) {
        var corporateOffice = $('#corporate_office_list').val();
        var corporateOfficeList = corporateOffice.split(',');
        if (officeID == '') {
            $('.action_department_div').show();
        } else {
            if (corporateOfficeList.indexOf(officeID) >= 0) {
                $('.action_department_div').show();
            } else {
                $('.action_department_div').hide();
            }
        }
    }

</script>