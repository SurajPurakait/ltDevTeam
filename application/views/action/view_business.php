<?php
$user_info = staff_info();
$user_dept = $user_info['department'];
$usertype = $user_info['type'];
$style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"';
$check_project_exist = getProjectCountByClientId($company_name_option_data["id"]);
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-4">
            <b class="pull-left">Client ID: <?= $company_internal_data[0]['practice_id']; ?></b><br>
            <b class="pull-left">Office ID: <?= $office['office_id']; ?></b>
        </div>
        <div class="col-md-8">
            <div class="text-right">
                <button class="btn btn-primary" type="button" onclick="go('action/home/business_dashboard');">Go Back To List</button>
                <?php if ($usertype == 1 || $usertype == 2) { ?>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>billing/invoice/index/<?php echo base64_encode($company_name_option_data["id"]); ?>/<?= base64_encode(1); ?>" style="width: 170px">+ Create Invoice</a>
                    <a class="btn btn-success" href="<?php echo base_url(); ?>action/home/edit_business/<?php echo $company_name_option_data['id'] ?>/<?php echo $company_name_option_data['company_id'] ?>">Edit Client Info</a>
                    <?php if ($usertype == 1 || $user_dept == 14) { ?>
                        <a title="DELETE" class="btn btn-warning" href="javascript:void(0);" onclick="delete_business('<?php echo $company_name_option_data["id"]; ?>', '<?php echo $company_name_option_data["company_id"]; ?>', 'view-page');">Delete</a>
                        <a title="INACTIVE" class="btn btn-danger" href="javascript:void(0);" onclick="inactive_business('<?php echo $company_name_option_data["id"]; ?>', '<?php echo $company_name_option_data["company_id"]; ?>');">Inactive</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="tabs-container m-t-10">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a>
            </li>
            <li role="presentation">
                <a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">Contact</a>
            </li>
            <li role="presentation">
                <a href="#owner" aria-controls="owner" role="tab" data-toggle="tab">Owner</a>
            </li>
            <li role="presentation">
                <a href="#other" aria-controls="other" role="tab" data-toggle="tab">Other</a>
            </li>
            <li role="presentation">
                <a href="#account" aria-controls="invoice" role="tab" data-toggle="tab">Account Details</a>
            </li>
            <li role="presentation">
                <a href="#invoice" aria-controls="invoice" role="tab" data-toggle="tab" onclick="loadbusinesstab('invoice')">Invoice</a>
            </li>
             <li role="presentation">
                <a href="#invoice" aria-controls="invoice" role="tab" data-toggle="tab" onclick="loadbusinesstab('recurring_invoice')">Recurring Invoice</a>
            </li>
            <li role="presentation">
                <a href="#project" aria-controls="project" role="tab" data-toggle="tab" onclick="loadbusinesstab('project', '<?= $check_project_exist ?>')">Project</a>
            </li>
            <li role="presentation">
                <a href="#action" aria-controls="action" role="tab" data-toggle="tab" onclick="loadbusinesstab('action')">Action</a>
            </li>      
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general">
                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                        <tr>
                            <td <?= $style; ?> width="20%">
                                <b style="font-size: 15px;">Client Id:</b>
                            </td>
                            <td <?= $style; ?>>
                                <?= $company_internal_data[0]['practice_id'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">Company Name:</b>
                            </td>
                            <td <?= $style; ?>>
                                <?= $company_name_option_data['name']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">Type of Company:</b>
                            </td>
                            <td <?= $style; ?>>
                                <?= $company_type['type']; ?>                                
                            </td>
                        </tr>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">Federal Id:</b>
                            </td>
                            <td>
                                <?= $company_name_option_data['fein']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">State of Incorporation:</b>
                            </td>
                            <td>
                                <?= $state_data['state_name']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">DBA :</b>
                            </td>
                            <td>
                                <?= $company_name_option_data['dba']; ?>                                
                            </td>
                        </tr>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">Business Description:</b>
                            </td>
                            <td>
                                <?= $company_name_option_data['business_description']; ?>                                
                            </td>
                        </tr>
                        <tr>
                            <td <?= $style; ?>>
                                <b style="font-size: 15px;">Internal Data:</b>
                            </td>
                            <td class="p-0">
                                <table class="table table-striped table-bordered m-b-0">
                                    <tr>
                                        <th width="250" class="text-left no-top-border" style="font-size: 15px; padding-left: 60px;">Office:</th>
                                        <td class="no-top-border">
                                            <?= $office['name'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left" style="font-size: 15px; padding-left: 60px;">Manager:</th>
                                        <td><?= $manager_name['first_name'].' '.$manager_name['middle_name'].' '.$manager_name['last_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-left" style="font-size: 15px; padding-left: 60px;">Partner:</th>
                                        <td><?= $partner_name['first_name'].' '.$partner_name['middle_name'].' '.$partner_name['last_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-left" style="font-size: 15px; padding-left: 60px;">Client Association:</th>
                                        <td><?= $company_internal_data[0]['client_association'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-left" style="font-size: 15px; padding-left: 60px;">Referred Source:</th>
                                        <td>
                                            <?php
                                            if (isset($ref_by_src['source']) && $ref_by_src['source'] != '') {
                                                echo $ref_by_src['source'];
                                            } else {
                                                echo 'Unknown';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left" style="font-size: 15px; padding-left: 60px;">Referred Name:</th>
                                        <td>
                                            <?php
                                            if (isset($company_internal_data[0]['referred_by_name']) && $company_internal_data[0]['referred_by_name'] != '') {
                                                echo $company_internal_data[0]['referred_by_name'];
                                            } else {
                                                echo '';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left" style="font-size: 15px; padding-left: 60px;">Language:</th>
                                        <td><?= $language_list['language'] ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="contact">
                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                        <tr>
                            <td <?= $style; ?>>
                                Contact Info
                            </td>
                            <td <?= $style; ?>>
                                <?php foreach ($contact_info as $info) { ?>                        
                                    <b>Contact Type:</b>
                                    <?= ($info->type != '') ? $info->type : 'N/A'; ?><br>
                                    <b>Contact Name:</b>
                                    <?= ($info->first_name != '' && $info->last_name != '') ? $info->last_name . ', ' . $info->first_name . ' ' . $info->middle_name : 'N/A'; ?><br>
                                    <b>Phone:</b>
                                    <?= ($info->phone1 != '') ? $info->phone1 : 'N/A'; ?><br>
                                    <b>Email:</b>
                                    <a href="mailto:<?php echo $info->email1 ?>"><?= ($info->email1 != '') ? $info->email1 : 'N/A'; ?></a><br>
                                    <b>Address:</b>
                                    <?= $info->address1 . ', ' . $info->city . ', ' . $info->state_name . ', ' . $info->country_name ?><br>
                                    <b>Zip:</b>
                                    <?= ($info->zip != '') ? $info->zip : 'N/A'; ?><br>
                                    <hr>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="owner">
                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                        <tr>
                            <?php if (!empty($get_individual_data)) { 
                                // $count = (count($get_individual_data)-1);
                                
                                ?>
                                <td <?= $style; ?>>
                                    Owners
                                </td>

                                <td <?= $style; ?>>
                                    <?php foreach($get_individual_data as $ind){ ?>
                                    <!-- <div class="row"> -->
                                        <!-- <div class="col-lg-10" style="padding-top:8px"> -->
                                            
                                                <b><?= $ind['title'] ?></b><br>
                                                <b>Name:</b>
                                                <?= $ind['last_name'] . ', ' . '' . $ind['first_name'] . ' ' . $ind['middle_name']; ?><br>
                                                <b>Percentage</b>
                                                <?= $ind['percentage'] . '%' ?>  
                                                <hr>
                                           
                                        <!-- </div> -->
                                    <!-- </div> -->
                                <?php } ?>
                                </td>
                            <?php } else { ?>
                                <td <?= $style; ?>>
                                    Owners
                                </td>
                                <td <?= $style; ?>>
                                    <?= 'N/A' ?>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if (!empty($owner_contact)) { ?>
                                <td <?= $style; ?>>
                                    Owner Contact Info
                                </td>
                                <td <?= $style; ?>>
                                    <?php
                                    foreach ($owner_contact as $inf) {
                                        foreach ($inf as $info) {
                                            ?> 
                                            <b>Contact Type:</b>
                                            <?= $info->type ?><br>
                                            <b>Contact Name:</b>
                                            <?= $info->last_name . ', ' . $info->first_name . ' ' . $info->middle_name; ?><br>
                                            <b>Phone:</b>
                                            <?= $info->phone1 ?><br>
                                            <b>Email:</b>
                                            <a href="mailto:<?php echo $info->email1 ?>"><?= $info->email1 ?></a><br>
                                            <b>Address:</b>
                                            <?= $info->address1 . ', ' . $info->city . ', ' . $info->state . ', ' . $info->country_name ?>
                                            <hr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else { ?>
                                <td <?= $style; ?>>
                                    Owner Contact Info
                                </td>
                                <td <?= $style; ?>>
                                    <?= 'N/A' ?>
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="other">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                        <tr>
                            <?php if (!empty($notes)) { ?>
                                <td <?= $style; ?>>
                                    Notes
                                </td>
                                <td <?= $style; ?>>
                                    <?php foreach ($notes as $note) { ?>
                                        <?php echo $note['note'] ?>
                                    <?php } ?>
                                </td>
                            <?php } else { ?>
                                <td <?= $style; ?>>
                                    Notes
                                </td>
                                <td <?= $style; ?>>
                                    <?php echo 'N/A'; ?>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if ($company_data[0]['file_name'] != "") { ?>
                                <td <?= $style; ?>>
                                    Attachments
                                </td>
                                <td <?= $style; ?>>
                                    <?php echo $company_data[0]['file_name']; ?>
                                </td>
                            <?php } else { ?>
                                <td <?= $style; ?>>
                                    Attachments
                                </td>
                                <td <?= $style; ?>>
                                    <?php echo 'N/A'; ?>
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="account">
                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                        <tr>
                            <?php if (!empty($account_details)) { ?>
                                <td <?= $style; ?>><strong>Account Info</strong></td>
                                <td <?= $style; ?> >
                                    <?php foreach ($account_details as $ad) {
                                    $security_details= get_secuirity_details($ad['id']); ?>
                                        <b>Type of Account: </b>
                                        <?php echo (isset($ad['type_of_account']) && $ad['type_of_account']!=''?$ad['type_of_account']:'') ?><br>
                                        <b>Bank Name:</b>
                                        <?php echo $ad['bank_name'] ?><br>
                                        <b>Account Number:</b>
                                        <?php echo $ad['ban_account_number'] ?><br>
                                        <b>Routing Number:</b>
                                        <?php echo $ad['bank_routing_number'] ?><br>
                                        <?php
                                        if ($usertype != 3) {
                                        ?>
                                            <b>Website: </b>
                                            <?php echo (isset($ad['bank_website']) && $ad['bank_website']!=''?$ad['bank_website']:'') ?><br>
                                            <b>User: </b>
                                            <?php echo (isset($ad['user']) && $ad['user']!=''?$ad['user']:'') ?><br>
                                            <b>Password: </b><?php echo (isset($ad['password']) && $ad['password']!=''?$ad['password']:'') ?><br>

                                            <?php 
                                                if(!empty($security_details)){
                                                    foreach($security_details as $sec_ans){
                                                        echo "<b>Question : </b>".$sec_ans['security_question']."<br>";
                                                        echo "<b>Answer : </b>".$sec_ans['security_answer']."<br>";
                                                    } 
                                                } 
                                            }
                                        ?>
                                        <p>
                                            <!-- <i class="fa fa-edit" style="cursor:pointer" onclick="account_modal('edit', '<?//= $ad['id'] ?>', 'month_diff');" title="Edit this account"></i> -->
                                            <i class="fa fa-edit" style="cursor:pointer" onclick="account_modal('edit', '<?= $ad['id'] ?>', '');" title="Edit this account"></i>
                                            &nbsp;&nbsp;<i class="fa fa-trash" style="cursor:pointer" onclick="delete_account(<?= $ad['id'] ?>)" title="Remove this account"></i>
                                        </p>
                                        <hr />
                                    <?php } ?>
                                </td>
                            <?php } else { ?>
                                <td <?= $style; ?>>
                                    Account Info
                                </td>
                                <td <?= $style; ?>>
                                    <?php echo 'N/A'; ?>
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            
            <a title="Account Info" class="btn btn-primary" href="javascript:void(0);" onclick="task_account_modal('add', '', 'client');">+ ADD ACCOUNT INFO</a>
            <input type="hidden" value="<?= $reference_id; ?>" id="reference_id">
            </div>

            <div role="tabpanel" class="tab-pane" id="invoice">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                    <div class="ajaxdiv" id="dashboard_result_div"></div>
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="project">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                    <div class="ajaxdiv" id="action_dashboard_div"></div>
                    <div class = "text-center m-t-30" id="project_list_business" style="display: none">
                        <div class = "alert alert-danger">
                            <i class = "fa fa-times-circle-o fa-4x"></i>
                            <h3><strong>Sorry!</strong> no data found</h3>
                        </div>
                    </div>
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="action">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                    <div class="ajaxdiv" id="business_action_dashboard_div"></div>
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="recurring_invoice">

                <table class="table table-striped table-bordered" style="width:100%;">
                    <tbody>
                    <div class="ajaxdiv" id="recurring_result_div"></div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="accounts-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
    <script>
        function loadbusinesstab(tab_value, projectval = '') {
            if (tab_value == 'invoice') {
                loadBillingDashboard('', '', '', '', '<?= $reference_id . '-company'; ?>','','n');
            }
            if (tab_value == 'project') {
                if (projectval != 0) {
                    loadProjectDashboard('', '', '', '', '', '', '', '', '', '', '', '<?php echo $company_name_option_data["id"] ?>', '', '1');
                } else {
                    $('#project_list_business').show();
                }
            }
            if (tab_value == 'recurring_invoice') {
                loadBillingDashboard('', '', '', '', '<?= $reference_id . '-company'; ?>','','y');
            }
            if (tab_value == 'action') {
                loadActionDashboard('', '', '', '', '', '','<?= $reference_id . '-company'; ?>','');
            }
        }


    </script>
