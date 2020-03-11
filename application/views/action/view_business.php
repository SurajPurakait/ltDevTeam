<?php
$user_info = staff_info();
$user_dept = $user_info['department'];
$usertype = $user_info['type'];
$style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"';
$check_project_exist = getProjectCountByClientId($company_name_option_data["id"]);
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-3">
            <b class="pull-left">Client ID: <?= $company_internal_data[0]['practice_id']; ?></b><br>
            <b class="pull-left">Office ID: <?= $office['office_id']; ?></b>
        </div>
        <div class="col-md-9">
            <div class="text-right">
                <button class="btn btn-primary" type="button" onclick="go('action/home/business_dashboard');">Go Back To List</button>
                <?php if ($usertype == 1 || $usertype == 2) { ?>

                    <a class="btn btn-primary" href="<?= base_url()?>action/home/create_action/1/<?= $reference_id?>/<?= $office['id']?>/<?= $company_internal_data[0]['practice_id'] ?>" target="_blank"><i class="fa fa-plus"></i> Create Action</a>

                    <a class="btn btn-primary" href="<?php echo base_url(); ?>billing/invoice/index/<?php echo base64_encode($company_name_option_data["id"]); ?>/<?= base64_encode(1); ?>" style="">+ Create Invoice</a>

                    <a class="btn btn-success" href="<?php echo base_url(); ?>action/home/edit_business/<?php echo $company_name_option_data['id'] ?>/<?php echo $company_name_option_data['company_id'] ?>">Edit Client Info</a>
                    
                    <?php if ($usertype == 1 || $user_dept == 14) { ?>
                        <a title="DELETE" class="btn btn-warning" href="javascript:void(0);" onclick="delete_business('<?php echo $company_name_option_data["id"]; ?>', '<?php echo $company_name_option_data["company_id"]; ?>', 'view-page');">Delete</a>
                        <a title="INACTIVE" class="btn btn-danger" href="javascript:void(0);" onclick="inactive_business('<?php echo $company_name_option_data["id"]; ?>', '<?php echo $company_name_option_data["company_id"]; ?>');">Inactive</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="tabs-container m-t-10" id="client-view-business">
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
                    <div class="ajaxdiv" id="action_ajax_dashboard_div"></div>
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
    <!--tracking modal-->
<div id="changeStatusinner" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad0" value="0"/>
                                <label for="rad0"><strong>Not Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad3" value="3"/>
                                <label for="rad3"><strong>Ready</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad1" value="1"/>
                                <label for="rad1"><strong>Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2" value="2"/>
                                <label for="rad2"><strong>Clarification</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad4" value="4"/>
                                <label for="rad4"><strong>Canceled</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad5" value="5"/>
                                <label for="rad5"><strong>Clarification</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="prosubid" value="">
                <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="project-tracking-save" class="btn btn-primary" onclick="updateProjectStatusinner('view')">Save changes</button>
            </div>
            <div class="modal-body" style="display: none;" id="log_modal">
                <div style="height:200px; overflow-y: scroll">
                    <table id="status_log" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>time</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
        function change_project_status_inner(id, status, section_id,project_id='',task_order='') {
        openModal('changeStatusinner');
        var txt = 'Tracking Project #' + project_id+'-'+task_order;
        $("#changeStatusinner .modal-title").html(txt);
        if (status == 0) {
            $("#changeStatusinner #rad0").prop('checked', true);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad5").prop('checked', false);
        } else if (status == 1) {
            $("#changeStatusinner #rad1").prop('checked', true);
            $("#changeStatusinner #rad0").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad5").prop('checked', false);
        } else if (status == 2) {
            $("#changeStatusinner #rad2").prop('checked', true);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad5").prop('checked', false);
        } else if (status == 3) {
            $("#changeStatusinner #rad3").prop('checked', true);
            $("#changeStatusinner #rad5").prop('checked', false);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
        } else if (status == 4) {
            $("#changeStatusinner #rad4").prop('checked', true);
            $("#changeStatusinner #rad5").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
        }
        else if (status == 5) {
            $("#changeStatusinner #rad5").prop('checked', true);
            $("#changeStatusinner #rad4").prop('checked', false);
            $("#changeStatusinner #rad3").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
        }
        $.get($('#baseurl').val() + "project/get_project_tracking_log/" + section_id + "/project_task", function (data) {
            $("#status_log > tbody > tr").remove();
            var returnedData = JSON.parse(data);
            for (var i = 0, l = returnedData.length; i < l; i++) {
                $('#status_log > tbody:last-child').append("<tr><td>" + returnedData[i]["stuff_id"] + "</td>" + "<td>" + returnedData[i]["department"] + "</td>" + "<td>" + returnedData[i]["status"] + "</td>" + "<td>" + returnedData[i]["created_time"] + "</td></tr>");
            }
            if (returnedData.length >= 1)
                $("#log_modal").show();
            else
                $("#log_modal").hide();
        });
        $("#changeStatusinner #prosubid").val(id);
    }

    </script>
