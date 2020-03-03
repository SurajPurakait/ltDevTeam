<?php // print_r($related_service_files);die;            ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">

            <form class="form-horizontal" method="post" id="project_input_form" onsubmit="saveInputForms(); return false;">
                <div class="ibox">
                    <div class="ibox-content">
                        <h2>Input Forms</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <?php
                                    $project_data = get_project_office_client($project_id);
//                                    $task_task = get_project_task_details($task_id);
                                    ?>
                                    <tr>
                                        <td style="width: 150px;"><b>Project ID: </b></td>
                                        <td><?= $project_id ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><b>Project Name: </b></td>
                                        <td><?= $project_data->title ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><b>Client ID: </b></td>
                                        <td><?= getProjectClientPracticeId($project_data->client_id, $project_data->client_type); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><b>Office ID: </b></td>
                                        <td><?= get_project_office_name($project_data->office_id); ?></td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <?php
//                                    $project_data = get_project_office_client($project_id);
                                    $task_data = get_project_task_details($task_id);
                                    ?>
                                    <tr>
                                        <td style="width: 150px;"><b>Task ID: </b></td>
                                        <td><?= $task_data->id ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><b>Task Title: </b></td>
                                        <td><?= $task_data->task_title ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><b>Description: </b></td>
                                        <td><?= $task_data->description; ?></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?php if ($input_form_type == 3) { ?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Client Name<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" id="client_name" name="client_name" title="Client Name" value="<?= $client_name ?>" required readonly>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control" name="state" id="state" title="County" required="" onchange="get_county('', this.value)">
                                        <option value="">Select</option>
                                        <?php
                                        foreach ($state as $sted) {
                                            ?>
                                            <option value="<?= $sted['id']; ?>" <?php echo (isset($sales_tax_process->state_id) ? ($sted['id'] == $sales_tax_process->state_id ? 'selected' : '') : '') ?>><?= $sted['state_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div id="sted_county"></div>
                            <div id="county_rate"></div>
                        </div>
                        <div class="well">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Exempt Sales<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" id="exempt_sales" name="exempt_sales" value="<?= (isset($sales_tax_process->exempt_sales) ? ($sales_tax_process->exempt_sales != '' ? $sales_tax_process->exempt_sales : '') : '') ?>" title="Exempt Sales" required onkeyup="sales_gross_collect()"><div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Taxable Sales<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" id="taxable_sales" name="taxable_sales" value="<?= (isset($sales_tax_process->taxable_sales) ? ($sales_tax_process->taxable_sales != '' ? $sales_tax_process->taxable_sales : '') : '') ?>" title="Taxable Sales" required onkeyup="sales_gross_collect()" ><div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Gross Sales<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" disabled class="form-control" type="text" id="gross_sales" name="gross_sales" value="<?= (isset($sales_tax_process->gross_sales) ? ($sales_tax_process->gross_sales != '' ? $sales_tax_process->gross_sales : '') : '') ?>" title="Gross Sales" required ><div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Sales Tax Collected<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" disabled class="form-control" type="text" id="sales_tax_collect" name="sales_tax_collect" value="<?= (isset($sales_tax_process->sales_tax_collect) ? ($sales_tax_process->sales_tax_collect != '' ? $sales_tax_process->sales_tax_collect : '') : '') ?>" title="Sales Tax Collected" required ><div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Collection Allowance<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" disabled class="form-control" type="text" id="collection_allowance" name="collection_allowance" value="<?= (isset($sales_tax_process->collect_allowance) ? ($sales_tax_process->collect_allowance != '' ? $sales_tax_process->collect_allowance : '') : '') ?>" title="Collection Allowance" required ><div class="errorMessage text-danger" id="coll_err"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Total Due<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" disabled class="form-control" type="text" id="total_due" name="total_due" value="<?= (isset($sales_tax_process->total_due) ? ($sales_tax_process->total_due != '' ? $sales_tax_process->total_due : '') : '') ?>" title="Total Due" required ><div class="errorMessage text-danger"></div>
                                </div>
                            </div>                        
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Period of Time<span class="text-danger">*</span></label>
                                <div class="col-lg-10 period_div">
                                    <select class="form-control" name="period_time" id="period_time" title="Period of Time" required="" >
                                        <option value="">Select</option>
                                        <?php foreach ($period_time as $key => $val) { ?>
                                            <option value="<?= $key ?>" <?= (isset($sales_tax_process->period_of_time) ? ($key == $sales_tax_process->period_of_time ? 'selected' : '') : '') ?>><?= $val ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group period_year_div" style="display: none;">
                                <label class="col-lg-2 control-label">Year<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <?php $year = date('Y'); ?>
                                    <select class="form-control" name="period_time_year" id="period_time_year" title="Year" required="">
                                        <option value="">Select</option>
                                        <option value="<?php echo ($year - 3); ?>"><?php echo ($year - 3); ?></option>
                                        <option value="<?php echo ($year - 2); ?>"><?php echo ($year - 2); ?></option>
                                        <option value="<?php echo ($year - 1); ?>"><?php echo ($year - 1); ?></option>
                                        <option selected value="<?php echo ($year); ?>"><?php echo ($year); ?></option>
                                        <option value="<?php echo ($year + 1); ?>"><?php echo ($year + 1); ?></option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <input type="hidden" name="peroidval" value="" id="peroidval">

                            <!--                        <div class="form-group">
                                                        <label class="col-lg-2 control-label">Upload File</label>
                                                        <div class="col-lg-10">
                                                            <div class="upload-file-div m-b-5">
                                                                <input class="m-t-5 file-upload" id="action_file" type="file" name="upload_file[]" title="Upload File">
                                                                <div class="errorMessage text-danger"></div>
                                                            </div>
                                                            <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i> Add File</a>
                                                        </div>
                                                    </div>-->
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Sales Tax Number<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control required_field" type="text" id="sales_tax_number" name="sales_tax_number" title="Sales Tax Number" value="<?= (isset($sales_tax_process->sales_tax_number) ? ($sales_tax_process->sales_tax_number != '' ? $sales_tax_process->sales_tax_number : '') : '') ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Business Partner Number<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control required_field" type="text" id="business_partner_number" name="business_partner_number" title="Business Partner Number" value="<?= (isset($sales_tax_process->business_partner_number) ? ($sales_tax_process->business_partner_number != '' ? $sales_tax_process->business_partner_number : '') : '') ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Sales Tax Business Description<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <textarea class="form-control value_field required_field" name="sales_tax_business_description" id="sales_tax_business_description" title="Sales Tax Business Description" ><?= (isset($sales_tax_process->sales_tax_business_description) ? ($sales_tax_process->sales_tax_business_description != '' ? $sales_tax_process->sales_tax_business_description : '') : '') ?></textarea>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <?php
                            $bank_account_no = '';
                            $bank_routing_no = '';
                            if (isset($bank_account_details) && !empty($bank_account_details)) {
                                $bank_account_no = $bank_account_details->account_number;
                                $bank_routing_no = $bank_account_details->routing_number;
                            } else {
                                if (isset($sales_tax_process) && !empty($sales_tax_process)) {
                                    $bank_account_no = $sales_tax_process->bank_account_no;
                                    $bank_routing_no = $sales_tax_process->bank_routing_no;
                                }
                            }
                            ?>
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Bank Account Number<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control required_field" type="text" id="sales_bank_account_number" name="bank_account_number" title="Bank Account Number" value="<?= $bank_account_no ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="referred-label" class="col-lg-2 control-label">Bank Routing Number<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control required_field" type="text" id="sales_bank_routing_number" name="bank_routing_number" title="Bank Routing Number" value="<?= $bank_routing_no ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Frequency Of Salestax<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control frequeny_of_bookkeeping" name="frequeny_of_salestax" id="frequeny_of_salesteax" title="Frequency Of salestex" required="">
                                        <option value="">Select</option>
                                        <option value="m"<?= ((isset($sales_tax_process->frequency_of_sales_tax) && $sales_tax_process->frequency_of_sales_tax == 'm' ) ? 'selected' : '') ?> >Monthly</option>
                                        <option value="q"<?= ((isset($sales_tax_process->frequency_of_sales_tax) && $sales_tax_process->frequency_of_sales_tax == 'q' ) ? 'selected' : '') ?>>Quarterly</option>
                                        <option value="y"<?= ((isset($sales_tax_process->frequency_of_sales_tax) && $sales_tax_process->frequency_of_sales_tax == 'y' ) ? 'selected' : '') ?>>Yearly</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div id="frequency_of_salestax_month" style="display:none">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Months<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control frequeny_of_bookkeeping" id="months" name="frequency_of_salestax_month"  title="Frequency Of salestex" >
                                            <?php
                                            $i = 0;
                                            $months = ['Select', 'January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                            for ($i = 0; $i <= 12; $i++) {
                                                ?>   
                                                <option value="<?php echo $months[$i]; ?>"><?php echo $months[$i]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="year1" name="frequency_of_salestax_years1"  title="Year" >
                                            <?php
                                            $i = 0;
                                            $year = ['Select', date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1];
                                            for ($i = 0; $i <= 5; $i++) {
                                                ?>
                                                <option value="<?php echo $year[$i]; ?>" <?php
                                                if ($year[$i] == date('Y')) {
                                                    echo "selected";
                                                }
                                                ?>><?php echo $year[$i]; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="frequency_of_salestax_querter" style="display:none">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Quarter<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control frequeny_of_bookkeeping" id="quarter" name="frequency_of_salestax_quarter"  title="Frequency Of salestex" >
                                            <?php
                                            $i = 0;
                                            $querter = ['Select', 'Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'];
                                            for ($i = 0; $i <= 4; $i++) {
                                                ?>
                                                <option value="<?php echo $querter[$i]; ?>"><?php echo $querter[$i]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="year2" name="frequency_of_salestax_years2"  title="Year" >
                                            <?php
                                            $i = 0;
                                            $year = ['Select', date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1];
                                            for ($i = 0; $i <= 5; $i++) {
                                                ?>
                                                <option value="<?php echo $year[$i]; ?>" <?php
                                                if ($year[$i] == date('Y')) {
                                                    echo "selected";
                                                }
                                                ?>><?php echo $year[$i]; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="frequency_of_salestax_years" style="display:none">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control frequeny_of_bookkeeping" id="year" name="frequency_of_salestax_years"  title="Year" >
                                            <?php
                                            $i = 0;
                                            $year = ['Select', date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1];
                                            for ($i = 0; $i <= 5; $i++) {
                                                ?>
                                                <option value="<?php echo $year[$i]; ?>" <?php
                                                if ($year[$i] == date('Y')) {
                                                    echo "selected";
                                                }
                                                ?>><?php echo $year[$i]; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Confirmation Number</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" id="confirmation_number" name="confirmation_number" title="Confirmation Number" value="<?= (isset($sales_tax_process->confirmation_number) ? ($sales_tax_process->confirmation_number != '' ? $sales_tax_process->confirmation_number : '') : '') ?>">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <!--                        <div class="form-group">
                                                        <label class="col-lg-2 control-label">Confirm<span class="text-danger">*</span></label>
                                                        <div class="col-lg-10">
                                                            <div class="p-t-5">
                                                                <input type="checkbox" name="confirmation" title="Confirmation" id="confirmation" value="" required>
                                                                I agree to waive the collections allowance.
                                                            </div>
                                                            <div class="errorMessage text-danger"></div>
                                                        </div>
                                                    </div>-->
                            <input type="hidden" name="user_id" id="user_id" value="<?= $staffInfo['id']; ?>">
                            <input type="hidden" name="user_type" id="user_type" value="<?= $staffInfo['type']; ?>">
                            <div class="hr-line-dashed"></div>
                        <?php } ?>
                        <?php
                        if ($input_form_type == 1):
                            if ($bookkeeping_input_type == 1) {
                                ?>
                                <!--New bookkeeping input form section-->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <?php if (!empty($client_account_details)) { ?>
                                                <tr>
                                                    <th style='width:8%;  text-align: center;'>Bank Name</th>
                                                    <th style='width:8%;  text-align: center;'>Account Number</th>
                                                    <th style='width:8%;  text-align: center;'>Routing Number</th>
                                                    <th style='width:8%;  text-align: center;'>Tracking</th>
                                                    <th style='width:10%;  text-align: center;'>Time & Date</th>
                                                    <th style="width:7%;  text-align: center;">Notes</th>
                                                    <th style="width:7%;  text-align: center;">Attachments</th>
                                                </tr>
                                                <?php
                                                foreach ($client_account_details as $key => $accounts) {
                                                    $status = $accounts['tracking'];
                                                    if ($status == 2) {
                                                        $tracking = 'Not Required';
                                                        $trk_class = 'label-secondary';
                                                    } elseif ($status == 1) {
                                                        $tracking = 'Complete';
                                                        $trk_class = 'label-success';
                                                    } elseif ($status == 0) {
                                                        $tracking = 'Incomplete';
                                                        $trk_class = 'label-danger';
                                                    }
                                                    if ($accounts['created_at'] != '') {
                                                        $created_at = date('m/d/Y h:i', strtotime($accounts['created_at']));
                                                    } else {
                                                        $created_at = '-';
                                                    }
                                                    $task_staff = ProjectTaskStaffList($task_id);
                                                    $stf = array_column($task_staff, 'staff_id');
                                                    $new_staffs = implode(',', $stf);
                                                    $account_length= strlen($accounts['account_number']);
                                                    $routing_length=(strlen($accounts['routing_number'])-4);
                                                    ?>
                                                    <tr>
                                                        <td title="Bank Name" class="text-center"><?= $accounts['bank_name']; ?></td>
                                                        <td title="Account Number" class="text-center"><?= substr_replace($accounts['account_number'], str_repeat("*", ($account_length)-4),0,-4); ?></td>
                                                        <td title="Routing Number" class="text-center"><?= substr_replace($accounts['routing_number'], str_repeat("*", (($routing_length>=0)?$routing_length:0)),0,-4); ?></td>
                                                        <td title="Tracking" class="text-center"><a href='javascript:void(0)' onclick='change_bookkeeping_finance_input_status("<?= $accounts['id']; ?>", "<?= $status ?>")'> <span id="trackinner-<?= $accounts['id'] ?>" class="label <?= $trk_class ?>"><?= $tracking ?></span></a></td>
                                                        <td title="Time & Date" class="text-center"><?= $created_at; ?></td>
                                                        <td title="Notes" class="text-center"><span> 
                                                                <?php
                                                                $read_status = project_task_notes_readstatus($task_id);
                                                                // print_r($read_status);

                                                                if (get_project_task_note_count($task_id) > 0 && in_array(0, $read_status)) {
                                                                    ?> 

                                                                    <a id="notecountinner-<?= $task_id ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task_id; ?>)"><b> <?= get_project_task_note_count($task_id) ?></b></a>

                                                                    <?php
                                                                } elseif (get_project_task_note_count($task_id) > 0 && in_array(1, $read_status)) {
                                                                    ?> 

                                                                    <a id="notecountinner-<?= $task_id ?>" class="label label-success" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task_id; ?>)"><b> <?= get_project_task_note_count($task_id) ?></b></a>

                                                                    <?php
                                                                } else {
                                                                    ?>

                                                                    <a id="notecountinner-<?= $task_id ?>" class="label label-secondary" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task_id; ?>)"><b> <?= get_project_task_note_count($task_id) ?></b></a>

                                                                    <?php
                                                                }
                                                                ?>
                                                            </span></td>
                                                        <?php
                                                        $file_count = getTaskFilesCount($task_id);
                                                        $unread_files_count = getUnreadTaskFileCount($task_id, 'task');
                                                        ?>
                                                        <?= '<td title="Files" class="text-center" ><span id="taskfilespan' . $task_id . '">' . (($unread_files_count->unread_files_count > 0) ? '<a class="label label-danger" href="javascript:void(0)" count="' . $file_count->files . '" id="taskfile' . $task_id . '" onclick="show_task_files(\'' . $task_id . '\',\'' . $new_staffs . $task_data->added_by_user . '\')"><b>' . $file_count->files . '</b></a>' : '<a class="label label-success" href="javascript:void(0)" count="' . $file_count->files . '" id="actionfile' . $task_id . '" onclick="show_task_files(\'' . $task_id . '\',\'' . $new_staffs . $task_data->added_by_user . '\')"><b>' . $file_count->files . '</b></a>') . '</span></td>'; ?>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class = "text-center m-t-30">
                                                    <div class = "alert alert-danger">
                                                        <i class = "fa fa-times-circle-o fa-4x"></i>
                                                        <h3><strong>Sorry!</strong> no data found</h3>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>

                            <?php } else if ($bookkeeping_input_type == 2) { ?>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <?php if (!empty($client_account_details)) { ?>
                                                <tr>
                                                    <th style='width:8%;  text-align: center;'>Bank Name</th>
                                                    <th style='width:8%;  text-align: center;'>Account Number</th>
                                                    <th style='width:6%;  text-align: center;'>Total Transactions</th>
                                                    <th style='width:6%;  text-align: center;'>Uncategorized Items</th>
                                                    <th style='width:8%;  text-align: center;'>Tracking</th>
                                                    <th style='width:10%;  text-align: center;'>Time</th>
                                                    <th style="width:7%;  text-align: center;">Notes</th>
                                                </tr>
                                                <?php
                                                foreach ($client_account_details as $key => $accounts) {
                                                    $account_length=strlen($accounts['account_number']);
                                                    $status = $accounts['tracking'];
                                                    if ($status == 2) {
                                                        $tracking = 'Not Required';
                                                        $trk_class = 'label-secondary';
                                                    } elseif ($status == 1) {
                                                        $tracking = 'Complete';
                                                        $trk_class = 'label-success';
                                                    } elseif ($status == 0) {
                                                        $tracking = 'Incomplete';
                                                        $trk_class = 'label-danger';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td title="Bank Name" class="text-center"><?= $accounts['bank_name']; ?></td>
                                                        <td title="Account Number" class="text-center"><?= substr_replace($accounts['account_number'], str_repeat("*", ($account_length)-4),0,-4); ?></td>
                                                        <td title="Total Transactions" class="text-center"><input type="text" name="total_transaction" id="total_transaction" onblur="save_transaction(<?= $accounts['id'] ?>, this.value)" value="<?= $accounts['total_transaction'] != '' ? $accounts['total_transaction'] : '' ?>" style="border-left: 0;border-right: 0;border-top: 0;border-bottom: 1px solid #676a6c70;text-align: center"></td>
                                                        <td title="Uncategorized Items" class="text-center"><input type="text" name="uncategorized_item" id="uncategorized_item" onblur="save_uncategorized_item(<?= $accounts['id'] ?>, this.value)" value="<?= $accounts['uncategorized_item'] != '' ? $accounts['uncategorized_item'] : '' ?>" style="border-left: 0;border-right: 0;border-top: 0;border-bottom: 1px solid #676a6c70;text-align: center" ></td>
                                                        <td title="Tracking" class="text-center"><a href='javascript:void(0)' onclick='change_bookkeeping_input_form2_status("<?= $accounts['id']; ?>", "<?= $status ?>")'> <span id="trackinner-<?= $accounts['id'] ?>" class="label <?= $trk_class ?>"><?= $tracking ?></span></a></td>
                                                        <td title="Time" class="text-center">
                                                            <div class="form-group">
                                                                <div class="col-lg-10">
                                                                    <div class="watch">
                                                                        <a href="javascript:void(0)" class="start" title="Record" id="start" name="start" onclick="add(<?= $accounts['id'] ?>)"><i class="fa fa-dot-circle-o" aria-hidden="true"></i></a>
                                                                        <a href="javascript:void(0)" class="stop" title="Pause" id="stop" name="stop" onclick="stop_record()"><i class="fa fa-pause-circle" aria-hidden="true"></i></a>
                                                                        <a href="javascript:void(0)" class="save" title="Save Entry" id="clear" name="clear" onclick="clear_record(<?= $accounts['id'] ?>)"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                                                        <h3 id="total_time"></h3>
                                                                    </div>

                                                                    <input type="hidden" id="bank_id" value="<?= $accounts['id'] ?>">
                                                                    <div id="load_record_time-<?= $accounts['id'] ?>" >
                                                                        <?php
                                                                        $record_details = get_bookkeeping_records_details($accounts['id']); ?>
                                                                        <a href="javascript:void(0)" id="time_modal" onclick="show_record_modal(<?= $accounts['id'] ?>,'add')">Recoded time details(<?= count($record_details) ?>)</a>
                                                                     </div>
                                                                    <div id="timer_result-<?= $accounts['id'] ?>"></div>
                                                                </div>
                                                            </div></td>
                                                        <td title="Notes" class="text-center"><span> 
                                                                <?php
                                                                $read_status = project_task_notes_readstatus($task_id);
                                                                // print_r($read_status);

                                                                if (get_project_task_note_count($task_id) > 0 && in_array(0, $read_status)) {
                                                                    ?> 

                                                                    <a id="notecountinner-<?= $task_id ?>" class="label label-danger" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task_id; ?>)"><b> <?= get_project_task_note_count($task_id) ?></b></a>

                                                                    <?php
                                                                } elseif (get_project_task_note_count($task_id) > 0 && in_array(1, $read_status)) {
                                                                    ?> 

                                                                    <a id="notecountinner-<?= $task_id ?>" class="label label-success" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task_id; ?>)"><b> <?= get_project_task_note_count($task_id) ?></b></a>

                                                                    <?php
                                                                } else {
                                                                    ?>

                                                                    <a id="notecountinner-<?= $task_id ?>" class="label label-secondary" href="javascript:void(0)" onclick="show_project_task_notes(<?= $task_id; ?>)"><b> <?= get_project_task_note_count($task_id) ?></b></a>

                                                                    <?php
                                                                }
                                                                ?>
                                                            </span></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class = "text-center m-t-30">
                                                    <div class = "alert alert-danger">
                                                        <i class = "fa fa-times-circle-o fa-4x"></i>
                                                        <h3><strong>Sorry!</strong> no data found</h3>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <div>
                                        <input type="button" name="clarification" id="clarification" class="btn btn-primary m-t-10" value="Need Clarification?" onclick="need_clarification('<?= $task_id ?>','<?= $client_type ?>','<?= $client_id ?>','<?= $project_id ?>')">
                                    </div>
                                </div>

                            <?php } else if ($bookkeeping_input_type == 3) { ?>
                                <!--<h3>REVIEW CLIENT MANAGER</h3>-->
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Adjustment Needed<span class="text-danger">*</span></label>
                                    <label class="checkbox-inline">
                                        <input class="checkclass" value="y" type="radio" id="need_adjustment" name="need_adjustment" onclick="check_adjustment(this.value)" required title="Input Form" <?= (isset($bookkeeper_details->adjustment) ? ($bookkeeper_details->adjustment == 'y' ? 'checked' : '') : '') ?>> Yes
                                    </label>
                                    <label class="checkbox-inline">
                                        <input class="checkclass" value="n" type="radio" id="need_adjustment2" name="need_adjustment" onclick="check_adjustment(this.value)" required title="Input Form" <?= (isset($bookkeeper_details->adjustment) ? ($bookkeeper_details->adjustment == 'n' ? 'checked' : '') : '') ?>> No
                                    </label>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            <?php } endif; ?>
                        <?php if (!empty($related_service_files)): ?>
                            <?php if ($bookkeeping_input_type != 1) { ?>
                                <ul class="uploaded-file-list">
                                    <?php
                                    foreach ($related_service_files as $file) :
                                        $file_name = $file['file_name'];
                                        $file_id = $file['id'];
                                        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                                        $allowed_extension = array('jpg', 'jpeg', 'gif', 'png');
                                        if (in_array($extension, $allowed_extension)):
                                            ?>
                                            <li id="file_show_<?= $file_id; ?>">
                                                <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $file_name; ?>');max-width: 100%;">
                                                    <a href="<?php echo base_url(); ?>uploads/<?= $file_name; ?>" title="<?= $file_name; ?>"><i class="fa fa-search-plus"></i></a>
                                                </div>
                                                <p class="text-overflow-e" title="<?= $file_name; ?>"><?= $file_name; ?></p>
                                                <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                            </li>
                                        <?php else: ?>
                                            <li id="file_show_<?= $file_id; ?>">
                                                <div class="preview preview-file">
                                                    <a target="_blank" href="<?php echo base_url(); ?>uploads/<?= $file_name; ?>" title="<?= $file_name; ?>"><i class="fa fa-download"></i></a>
                                                </div>
                                                <p class="text-overflow-e" title="<?= $file_name; ?>"><?= $file_name; ?></p>
                                                <a class='text-danger text-right show m-t-5 p-5' href="javascript:void(0)" onclick="deleteFile(<?= $file_id; ?>)"><i class='fa fa-times-circle'></i> Remove</a>
                                            </li>
                                        <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                            <?php } endif; ?>
                                <div id="bookkeeping_check3" style="display:none">
                            <?php if ($bookkeeping_input_type != 1 && $bookkeeping_input_type != 2) { ?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-2 control-label">Attachment:</label>
                                    <div class="col-sm-9 col-md-10">
                                        <div class="upload-file-div">
                                            <input class="file-upload" id="action_file" type="file" name="project_attachment[]" title="Upload File">
                                            <div class="errorMessage text-danger m-t-5"></div>
                                        </div>
                                        <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i> Add File</a>
                                    </div>
                                </div>
                                <?php
                                if (isset($notes_data)) {
                                    foreach ($notes_data as $index => $nl) {
                                        $rand = rand(000, 999);
                                        if ($nl['user_id'] != $this->session->userdata('user_id')) {
                                            ?>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label"><?= $index == 0 ? $note_title : ""; ?></label>
                                                <div class="col-lg-10">
                                                    <div title="<?= $note_title ?>"><?= $nl['note']; ?></div>
                                                    <div>By: <?= $nl['staff_name']; ?></div>
                                                    <div>Department: <?= staff_department_name($nl['user_id']); ?></div>
                                                    <div>Time: <?= $nl['time']; ?></div>                                            
                                                </div>
                                            </div>
                                            <textarea style="display:none;" <?= $required == 'y' ? "required='required'" : ""; ?> class="form-control" name="edit_task_note[]"  title="<?= $note_title ?>"><?= $nl['note']; ?></textarea>
                                        <?php } else { ?>
                                            <div class="form-group" id="<?= $table . '_div_' . $index . $rand; ?>">
                                                <label class="col-lg-2 control-label"><?= $index == 0 ? $note_title : ""; ?></label>
                                                <div class="col-lg-10">
                                                    <div class="note-textarea">
                                                        <textarea <?= $required == 'y' ? "required='required'" : ""; ?> class="form-control" name="edit_task_note[]"  title="<?= $note_title ?>"><?= $nl['note']; ?></textarea>
                                                    </div>
                                                    <div class="pull-right"><b>By: <?= $nl['staff_name']; ?> | Department: <?= staff_department_name($nl['user_id']); ?> | Time: <?= $nl['time']; ?></b></div>
                                                    <?php if ($multiple == 'y') { ?><a href="javascript:void(0);" onclick="deleteTaskNote('<?= $table . '_div_' . $index . $rand; ?>', '<?= $nl['note_id']; ?>', '<?= $related_table_id; ?>');" class="text-danger"><i class="fa fa-times"></i> Remove Note</a><?php } ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-2 control-label">Notes:</label>
                                    <div class="col-sm-9 col-md-10" id="add_note_div">
                                        <div class="note-textarea">
                                            <textarea class="form-control" name="task_note[]"  title="Task Note"></textarea>
                                        </div>
                                        <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                            <div id="adjustment_no" class="p-l-35 text-success">
                            <h4 id="adjustment_no_result"></h4>
                            <h4><?= (isset($bookkeeper_details->created_at)?'on '.(date("m/d/Y h:i:sa",strtotime($bookkeeper_details->created_at))):'') ?></h4>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-12 text-right">
                                <input type="hidden" name="task_id" id="service_request_id" value="<?= $task_id; ?>">
                                <!--for sales tax-->
                                <input type="hidden" name="input_form_type" id="input_form_type" value="<?= $input_form_type ?>">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <input type="hidden" name="editval" id="editval" value="<?= $task_id; ?>">
                                <input type="hidden" name="bookkeeping_input_type" id="task_key" value=<?= $bookkeeping_input_type ?>>
                                <?php if ($input_form_type == 1 && $bookkeeping_input_type == 1) { ?>
                                    <input type="hidden" name="reference_id" id="reference_id" value="<?= $client_id; ?>">
                                <?php } if($type!='v'){?>
                                    <button class="btn btn-success" type="button" onclick="saveInputForms()">Save changes</button> &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-default" type="button" onclick="go('project')">Cancel</button>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="accounts-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="recordModal" class="modal fade" role="dialog">
        </div>
<!--bookkeeping input form 1 tracking -->
<div id="changetrackinginner-<?= $task_id ?>" class="modal fade" role="dialog">
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
                                <input type="radio" name="status" id="rad0" value="0"/>
                                <label for="rad0"><strong>Incomplete</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="status" id="rad1" value="1"/>
                                <label for="rad1"><strong>Complete</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="status" id="rad2" value="2"/>
                                <label for="rad2"><strong>Not Required</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="input_id" value="">
                <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
            </div>
            <div class="modal-footer text-center">
                <input type="hidden" id="bookkeeping_input_form_type" name="bookkeeping_input_form_type" value="<?= $bookkeeping_input_type ?>">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateBookkeeping_inputStatusinner(<?= $task_id ?>)">Save changes</button>
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
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bookkeeping task input form1 files modal-->
<div class="modal fade" id="showTaskFiles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Files</h4>
            </div>
            <div id="files-modal-body" class="modal-body"></div>
        </div>
    </div>
</div>
<!--task note modal-->
<div class="modal fade" id="showProjectTaskNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" id="project_task_modal_note_form_update" onsubmit="update_project_task_notes();">
                <div id="notes-modal-body" class="modal-body p-b-0"></div>
                <div class="modal-body p-t-0 text-right">
                    <button type="button" id="update_note" onclick="update_project_task_notes();" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
           <!--  <form method="post" id="modal_note_form" action="<?//= base_url(); ?>action/home/addNotesmodal"> -->
            <form method="post" id="project_task_modal_note_form" onsubmit="add_project_task_notes();">
                <div class="modal-body">
                    <h4>Add New Note</h4>
                    <!-- <div class="col-lg-10">
                        <label class="checkbox-inline">
                            <input type="checkbox"  name="pending_request" id="pending_request" value="1"><b>Add to SOS Notification</b>
                        </label>
                    </div> -->
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="task_note[]"  title="Task Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="taskid" id="taskid">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="add_project_task_notes();" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end task note modal-->
<!--recoded time modal-->

<script>
    get_financial_account_list('<?= $client_id; ?>', 'project', '<?= $task_id; ?>');
<?php if ($bookkeeping_input_type == 3) { ?>
        check_adjustment('<?= (isset($bookkeeper_details->adjustment) && $bookkeeper_details->adjustment!=''?$bookkeeper_details->adjustment:'') ?>', 'edit');
<?php } ?>
    $(function () {
        $('.add-upload-file').on("click", function () {
            var text_file = $(this).prev('.upload-file-div').html();
            var file_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-2 control-label"></label><div class="col-lg-10">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
        $('.add-task-note').click(function () {
//            alert("hlw");
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group">' + '<label class="col-sm-3 col-md-2 control-label"></label>' + '<div class="col-sm-9 col-md-10" id="note_div' + div_count + '"> ' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger removenoteselector"><i class="fa fa-times"></i> Remove Note</a>' +
                    '</div>' + '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });
    function removeFile(divID) {
        $("#" + divID).remove();
    }
    function deleteFile(file_id) {
        swal({
            title: "Delete!",
            text: "Are you sure to delete this file?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type: "GET",
                url: '<?= base_url(); ?>task/delete_project_input_form_file/' + file_id,
                success: function (data) {
                    if (parseInt(data.trim()) === 1) {
                        swal("Deleted!", "File has been deleted.", "success");
                        $("#file_show_" + file_id).remove();
                    }
                }
            });
        });
    }
    get_county('<?= isset($sales_tax_process->county_id) ? $sales_tax_process->county_id : '' ?>', '<?= isset($sales_tax_process->state_id) ? $sales_tax_process->state_id : '' ?>');
    function removeFile(divID) {
        $("#" + divID).remove();
    }
<?php if ($bookkeeping_input_type == 2) { ?>
        h3 = document.getElementById('total_time');
        //                start = document.getElementById('start'),
        //                stop = document.getElementById('stop'),
        //                clear = document.getElementById('clear'),
        seconds = 0, minutes = 0, hours = 0,
                t='';
        function add(bank_id) {
            //            h3 = document.getElementById('total_time-'+bank_id),
            seconds++;
            if (seconds >= 60) {
                seconds = 0;
                minutes++;
                if (minutes >= 60) {
                    minutes = 0;
                    hours++;
                }
            }
            h3.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
            //            $("#total_time-"+bank_id).html(a);
            timer();
        }
        function timer() {
            t = setTimeout(add, 1000);
        }
        function stop_record() {
            clearTimeout(t);
        }
        function clear_record(bank_id) {
            clearTimeout(t);
            var record_time = h3.textContent;
            $.ajax({
                type: "POST",
                data: {record_time: record_time, bank_id: bank_id},
                url: base_url + 'task/update_project_bookkeeping_record_time',
                dataType: "html",
                success: function (result) {
                    $("#load_record_time-" + bank_id).hide();
                    $("#timer_result-" + bank_id).html(result);
                }
            });
            h3.textContent = "00:00:00";
            seconds = 0;
            minutes = 0;
            hours = 0;
        }
<?php } ?>
    function check_adjustment(adjustment, type = '') {
        if (adjustment == 'n') {
            $("#bookkeeping_check3").hide();
            if (type == '') {
                swal({
                    title: "Did you review bookkeeping report with the client?",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: 'Yes',
                    confirmButtonColor: 'green',
                    cancelButtonText: 'No'
                }, function () {
//                    $.ajax({
//                        type: "POST",
//                        data: {record_time: record_time, bank_id: bank_id},
//                        url: base_url + 'task/update_project_bookkeeping_record_time',
//                        dataType: "html",
//                        success: function (result) {
//                            $("#load_record_time-" + bank_id).hide();
//                            $("#timer_result-" + bank_id).html(result);
//                        }
//                    });
                    setTimeout(function () {
                        swal("I confirm that bookkeeping was done correctly.");
                        $("#adjustment_no_result").html('Confirming Bookkeeping was done correctly');
                        $("#adjustment_no_result").show();
                    }, 500);
                });
                
            }else{
                $("#adjustment_no_result").html('Confirming Bookkeeping was done correctly');
                $("#adjustment_no_result").show();
            }
        } else if(adjustment=='y') {
            $("#bookkeeping_check3").show();
            $("#adjustment_no_result").hide();
        }else{
            $("#bookkeeping_check3").hide();
            $("#adjustment_no_result").hide();
        }
    }
</script>