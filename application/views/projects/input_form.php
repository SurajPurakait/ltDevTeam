<?php // print_r($related_service_files);die;       ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" id="project_input_form" onsubmit="saveInputForms(); return false;">
            <div class="ibox">
                <div class="ibox-content">
                        <h2>Input Forms</h2>
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
                                            <option value="<?= $sted['id']; ?>" <?php echo (isset($sales_tax_process->state_id) ? ($sted['id']==$sales_tax_process->state_id?'selected':''):'') ?>><?= $sted['state_name']; ?></option>
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
                                <input placeholder="" class="form-control" type="text" id="exempt_sales" name="exempt_sales" value="<?= (isset($sales_tax_process->exempt_sales)?($sales_tax_process->exempt_sales!=''?$sales_tax_process->exempt_sales:''):'') ?>" title="Exempt Sales" required onkeyup="sales_gross_collect()"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Taxable Sales<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="taxable_sales" name="taxable_sales" value="<?= (isset($sales_tax_process->taxable_sales)?($sales_tax_process->taxable_sales!=''?$sales_tax_process->taxable_sales:''):'') ?>" title="Taxable Sales" required onkeyup="sales_gross_collect()" ><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Gross Sales<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="gross_sales" name="gross_sales" value="<?= (isset($sales_tax_process->gross_sales)?($sales_tax_process->gross_sales!=''?$sales_tax_process->gross_sales:''):'') ?>" title="Gross Sales" required ><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sales Tax Collected<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="sales_tax_collect" name="sales_tax_collect" value="<?= (isset($sales_tax_process->sales_tax_collect)?($sales_tax_process->sales_tax_collect!=''?$sales_tax_process->sales_tax_collect:''):'') ?>" title="Sales Tax Collected" required ><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Collection Allowance<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="collection_allowance" name="collection_allowance" value="<?= (isset($sales_tax_process->collect_allowance)?($sales_tax_process->collect_allowance!=''?$sales_tax_process->collect_allowance:''):'') ?>" title="Collection Allowance" required ><div class="errorMessage text-danger" id="coll_err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Total Due<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" disabled class="form-control" type="text" id="total_due" name="total_due" value="<?= (isset($sales_tax_process->total_due)?($sales_tax_process->total_due!=''?$sales_tax_process->total_due:''):'') ?>" title="Total Due" required ><div class="errorMessage text-danger"></div>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Period of Time<span class="text-danger">*</span></label>
                            <div class="col-lg-10 period_div">
                                <select class="form-control" name="period_time" id="period_time" title="Period of Time" required="" >
                                    <option value="">Select</option>
                                    <?php foreach ($period_time as $key=> $val){?>
                                    <option value="<?= $key ?>" <?= (isset($sales_tax_process->period_of_time)?($key==$sales_tax_process->period_of_time?'selected':''):'') ?>><?= $val ?></option>
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
                                        <input placeholder="" class="form-control required_field" type="text" id="sales_tax_number" name="sales_tax_number" title="Sales Tax Number" value="<?= (isset($sales_tax_process->sales_tax_number)?($sales_tax_process->sales_tax_number!=''?$sales_tax_process->sales_tax_number:''):'') ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label id="referred-label" class="col-lg-2 control-label">Business Partner Number<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input placeholder="" class="form-control required_field" type="text" id="business_partner_number" name="business_partner_number" title="Business Partner Number" value="<?=(isset($sales_tax_process->business_partner_number)?($sales_tax_process->business_partner_number!=''?$sales_tax_process->business_partner_number:''):'') ?>">
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sales Tax Business Description<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control value_field required_field" name="sales_tax_business_description" id="sales_tax_business_description" title="Sales Tax Business Description" ><?=(isset($sales_tax_process->sales_tax_business_description)?($sales_tax_process->sales_tax_business_description!=''?$sales_tax_process->sales_tax_business_description:''):'') ?></textarea>
                                        <div class="errorMessage text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Frequency Of Salestax<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select class="form-control frequeny_of_bookkeeping" name="frequeny_of_salestax" id="frequeny_of_salesteax" title="Frequency Of salestex" required="">
                                            <option value="">Select</option>
                                               <option value="m"<?=((isset($sales_tax_process->frequency_of_sales_tax) && $sales_tax_process->frequency_of_sales_tax == 'm' )? 'selected':'') ?> >Monthly</option>
                                               <option value="q"<?=((isset($sales_tax_process->frequency_of_sales_tax) && $sales_tax_process->frequency_of_sales_tax == 'q' )? 'selected':'') ?>>Quarterly</option>
                                            <option value="y"<?=((isset($sales_tax_process->frequency_of_sales_tax) && $sales_tax_process->frequency_of_sales_tax == 'y' )? 'selected':'') ?>>Yearly</option>
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
                                                    $i=0;
                                                    $months=['Select','January','Febuary','March','April','May','June','July','August','September','October','November','December'];
                                                    for($i=0;$i<=12;$i++) {
                                                ?>   
                                                <option value="<?php echo $months[$i];?>"><?php echo $months[$i];?></option>
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
                                                    $i=0;
                                                    $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                                    for($i=0;$i<=5;$i++) { 
                                                ?>
                                                <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
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
                                                    $i=0;
                                                    $querter=['Select','Quarter 1','Quarter 2','Quarter 3','Quarter 4'];
                                                    for($i=0;$i<=4;$i++) {
                                                ?>
                                                <option value="<?php echo $querter[$i];?>"><?php echo $querter[$i];?></option>
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
                                                $i=0;
                                                $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                                for($i=0;$i<=5;$i++) { 
                                            ?>
                                            <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
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
                                                $i=0;
                                                $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                                for($i=0;$i<=5;$i++) { 
                                            ?>
                                            <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
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
                                <input class="form-control" type="text" id="confirmation_number" name="confirmation_number" title="Confirmation Number" value="<?= (isset($sales_tax_process->confirmation_number)?($sales_tax_process->confirmation_number!=''?$sales_tax_process->confirmation_number:''):'') ?>">
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
                    <?php if ($input_form_type == 1):
                        if($bookkeeping_input_type==1){
                        ?>
                        <h3>BANK STATEMENT RETRIEVAL LEAFCLOUD DEPARTMENT</h3>
                            <div id="documents_div" class="display_div">
                                <div class="hr-line-dashed"></div>
                                <h3>Documents &nbsp; (<a data-toggle="modal"  id="add_document_btn" onclick="document_modal('add', 'project', '<?= $task_id ?>'); return false;" href="javascript:void(0);">Add document</a>)</h3> 
                                <div id="document-list"></div>
                            </div>
                        <?php
                            if (!empty($list)) {
                                foreach ($list as $document) {
                                    ?>
                                    <div class="row" id='document_id_<?= $document['id']; ?>' >
                                        <label class="col-lg-2 control-label"><?= $document['doc_type']; ?></label>
                                        <div class="col-lg-10" style="padding-top:8px">
                                            <p>
                                                <a href ='javascript:void(0)' onClick="MyWindow = window.open('<?= base_url("/uploads/" . $document["document"]); ?>', 'Document Preview', width = 600, height = 300); return false;"><?= $document["document"]; ?></a>
                                                &nbsp;&nbsp;<i class="fa fa-trash" style="cursor:pointer" onclick="delete_document('<?= $document["reference"]; ?>', '<?= $document["reference_id"]; ?>', '<?= $document["id"]; ?>', '<?= $document["document"]; ?>')" title="Remove this document"></i>
                                            </p>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                            <div class="accounts-details">
                                <h3>Financial Accounts<span class="text-danger">*</span>&nbsp; (<a href="javascript:void(0);" onclick="task_account_modal('add', '', 'project');">Add Financial Account</a>)</h3>
                                <div id="accounts-list">
                                    <input type="hidden" title="Financial Accounts" id="accounts-list-count" required="required" value="">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Frequency<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control frequeny_of_bookkeeping" name="frequency" id="frequeny_of_bookkeeping" title="Frequency Of Bookkeeping" required>
                                        <option value="">Select an option</option>
                                        <option value="m" <?= $bookkeeping_details['frequency'] == 'm' ? 'selected' : ''; ?>>Monthly</option>
                                        <option value="q" <?= $bookkeeping_details['frequency'] == 'q' ? 'selected' : ''; ?>>Quarterly</option>
                                        <option value="y" <?= $bookkeeping_details['frequency'] == 'y' ? 'selected' : ''; ?>>Yearly</option>
                                    </select>
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                        <?php }else if($bookkeeping_input_type==2){ ?>
                        <h3>BOOKKEEPING BOOKKEEPER DEPARTMENT</h3>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Number of Bank Account<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" id="bank_acc_no" name="bank_account_no" value="<?= (isset($bookkeeper_details->bank_account_no)?($bookkeeper_details->bank_account_no!=''?$bookkeeper_details->bank_account_no:''):'') ?>" title="Total Due" required ><div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Total Transaction<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" id="bank_acc_no" name="transaction" value="<?= (isset($bookkeeper_details->transaction)?($bookkeeper_details->transaction!=''?$bookkeeper_details->transaction:''):'') ?>" title="Total Due" required ><div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Uncategorized Item<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input placeholder="" class="form-control" type="text" id="bank_acc_no" name="item_uncategorize" value="<?= (isset($bookkeeper_details->item_uncategorize)?($bookkeeper_details->item_uncategorize!=''?$bookkeeper_details->item_uncategorize:''):'') ?>" title="Total Due" required ><div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Reconciled<span class="text-danger">*</span></label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" value="1" type="radio" id="reconciled" name="reconciled" required title="Input Form" <?= (isset($bookkeeper_details->reconciled)?($bookkeeper_details->reconciled == 1 ? 'checked' : ''):'') ?>> Yes
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" value="0" type="radio" id="reconciled2" name="reconciled" required title="Input Form" <?= (isset($bookkeeper_details->reconciled)?($bookkeeper_details->reconciled == 0 ? 'checked' : ''):'')?>> No
                                </label>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        
                        <?php }else if($bookkeeping_input_type==3){?>
                        <h3>REVIEW CLIENT MANAGER</h3>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Adjustment Needed<span class="text-danger">*</span></label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" value="y" type="radio" id="need_adjustment" name="need_adjustment" required title="Input Form" <?= (isset($bookkeeper_details->adjustment)?($bookkeeper_details->adjustment == 'y' ? 'checked' : ''):'') ?>> Yes
                                </label>
                                <label class="checkbox-inline">
                                    <input class="checkclass" value="n" type="radio" id="need_adjustment2" name="need_adjustment" required title="Input Form" <?= (isset($bookkeeper_details->adjustment)?($bookkeeper_details->adjustment == 'n' ? 'checked' : ''):'')?>> No
                                </label>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        <?php } endif; ?>
                    <?php if (!empty($related_service_files)): ?>
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
                    <?php endif; ?>

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
                    <?php if($bookkeeping_input_type==2){?>
                    <div class="form-group">
                            <label class="col-lg-2 control-label">Total Time Spent</label>
                            <div class="col-lg-10">
                                <div class="watch">
                                    <h3 id="total_time" name='total_time'><?= (isset($bookkeeper_details->total_time)?($bookkeeper_details->total_time!='' ? $bookkeeper_details->total_time: ''):'')?></h3>
                                    <input type='button' class="btn btn-success" id='start' name="start" onclick="add()" value="Start">
                                    <input type="button" class="btn btn-warning" id='stop' name="stop" value="Stop">
                                    <input type="button" class="btn btn-danger" id='clear' name="clear" value="Clear">
                                </div>
                            </div>
                    </div>
                    <?php } ?>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <input type="hidden" name="task_id" id="service_request_id" value="<?= $task_id; ?>">
                            <!--for sales tax-->
                            <input type="hidden" name="input_form_type" id="input_form_type" value="<?= $input_form_type ?>">
                            <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                            <input type="hidden" name="editval" id="editval" value="<?= $task_id; ?>">
                            <input type="hidden" name="bookkeeping_input_type" id="task_key" value=<?= $bookkeeping_input_type ?>>
                            <?php if($input_form_type==1 && $bookkeeping_input_type==1){ ?>
                            <input type="hidden" name="reference_id" id="reference_id" value="<?= $client_id; ?>">
                            <?php } ?>
                            <button class="btn btn-success" type="button" onclick="saveInputForms()">Save changes</button> &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-default" type="button" onclick="go('project')">Cancel</button>
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
<script>
    get_financial_account_list('<?= $client_id; ?>', 'project', '<?= $task_id; ?>');
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
</script>
<script>
    get_county('<?= isset($sales_tax_process->county_id)?$sales_tax_process->county_id:'' ?>','<?= isset($sales_tax_process->state_id)?$sales_tax_process->state_id:'' ?>');
    function removeFile(divID) {
        $("#" + divID).remove();
    }
    
    var h3 = document.getElementById('total_time'),
    start = document.getElementById('start'),
    stop = document.getElementById('stop'),
    clear = document.getElementById('clear'),
    seconds = 0, minutes = 0, hours = 0,
    t;
    function add() {
//        alert('hi');
    seconds++;
    if (seconds >= 60) {
        seconds = 0;
        minutes++;
        if (minutes >= 60) {
            minutes = 0;
            hours++;
        }
    }
    
    h3.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9   ? seconds : "0" + seconds);

    timer();
    }
    function timer() {
//        alert('hi');
    t = setTimeout(add, 1000);
    }
//     timer();


    /* Start button */
    start.onclick = timer;

    /* Stop button */
    stop.onclick = function() {
//        alert('hi');
    clearTimeout(t);

    }

    /* Clear button */
    clear.onclick = function() {
//        alert('hi');
    h3.textContent = "00:00:00";
    seconds = 0; minutes = 0; hours = 0;
    }

</script>