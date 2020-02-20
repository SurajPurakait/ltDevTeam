<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <h4>Service Id: <?= $service_id2; ?></h4>
            <h4>Service Name: <?= $service_details['description']; ?></h4>
            <h4>Client Id: <?= $client_id; ?></h4>
            <div class="hr-line-dashed"></div>
        </div>
        <?php $style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"'; 
        if (isset($payer_information) && $payer_information != '') {?>
        <table class="table table-striped table-bordered" style="width:100%;">
            <tbody>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>First Name:</b>
                    </td>
                    <td <?= $style; ?>><?php if(isset($payer_information['payer_first_name'])) { echo $payer_information['payer_first_name']; } else { echo 'N/A';}?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Last Name:</b>
                    </td>
                    <td <?= $style; ?>><?php if(isset($payer_information['payer_last_name'])) { echo $payer_information['payer_last_name']; } else { echo 'N/A';}?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Phone Number:</b>
                    </td>
                    <td <?= $style; ?>><?php if(isset($payer_information['payer_phone_number'])) { echo $payer_information['payer_phone_number']; } else { echo 'N/A';} ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Address:</b>
                    </td>
                    <td <?= $style; ?>><?php if(isset($payer_information['payer_address'])) { echo $payer_information['payer_address']; } else { echo 'N/A'; }?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>City:</b>
                    </td>
                    <td <?= $style; ?>><?php if(isset($payer_information['payer_city'])) { echo $payer_information['payer_city']; } else { echo 'N/A';} ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>State:</b>
                    </td>
                    <td <?= $style; ?>><?php if(isset($state_name)) {echo  $state_name; } else { echo 'N/A';} ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Country:</b>
                    </td>
                    <td <?= $style; ?>><?php if(isset($country_name)){ echo $country_name; }else { echo "N/A"; } ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Zip:</b>
                    </td>
                    <td <?= $style; ?>><?php if(isset($payer_information['payer_zip'])) { echo $payer_information['payer_zip'];} else { echo "N/A"; } ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b> TIN (Tax Identification Number):</b>
                    </td>
                    <td <?= $style; ?>><?php if(isset($payer_information['payer_tin'])) { echo $payer_information['payer_tin'];} else { echo "N/A"; } ?></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b> Recipient's Information:</b>
                    </td>
                    <td <?= $style; ?>><div id="recipient-list"></div></td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b>Attachment:</b>
                    </td>
                    <?php foreach ($related_service_files as $file) :
                                    $file_name = $file['file_name'];
                                    $file_id = $file['id'];?>
                    <td>
                        <?php if($file_name != '') {?>
                        <div class="preview preview-image" style="background-image: url('<?= base_url(); ?>uploads/<?= $file_name; ?>');max-width: 100%;">                           
                            <a href="<?php echo base_url(); ?>uploads/<?= $file_name; ?>" title="<?= $file_name; ?>"><i class="fa fa-download"></i></a>
                        </div>   
                        <?php } else {
                                echo 'No file selected';
                        }?>
                    </td>
                </tr>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b> Service Note:</b>
                    </td>
                     <?php if(isset($notes) && $notes != ''){ ?>
                        <td <?= $style; ?>>
                            <?php foreach($notes as $note) { ?>
                                <div> <?= $note['note']; ?></div><br>    
                            <?php } ?>    
                        </td>
                     <?php } ?>
                </tr>
                <?php  endforeach;?>
            </tbody>
        </table>
        <?php } elseif(isset ($header_title) && $header_title == "Bookkeeping By Date") {
            ?>
        <table class="table table-striped table-bordered" style="width:100%;">
            <tbody>
                <tr>
                    <td width="300" <?= $style; ?>>
                        <b> Financial Accounts:</b>
                    </td>
                    <td <?= $style; ?>>
                    <div id="accounts-list">
                        <input type="hidden" title="Financial Accounts" id="accounts-list-count" required="required" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    </td>
                </tr>  
            </tbody>
        </table>
       <?php } elseif(isset ($header_title) && $header_title == "New Company - Florida"){
               if(isset($company_name_option['name1']) && $company_name_option['name1'] != '') {
           ?>
           <table class="table table-striped table-bordered" style="width:100%;">
               <tbody>
                   <tr>
                      <td width="300" <?= $style; ?>>
                        <b>Name of Business</b>
                      </td>  
                      <td width="300" <?= $style; ?>>
                        <?php echo $company_name_option['name1']."<br>"; ?>
                        <?php if($company_name_option['name2'] != ''){
                              echo "<hr>".$company_name_option['name2']."<br>"."<hr>"; }
                              if($company_name_option['name3'] != '') {
                              echo $company_name_option['name3']; }
                        ?>
                      </td>                      
                   </tr>
               </tbody>
           </table>
       <?php } else { ?> 
                <div class="col-lg-12">            
                    <div class = "text-center m-t-30">
                        <div class = "alert alert-danger">
                            <i class = "fa fa-times-circle-o fa-4x"></i>
                            <h3><strong>Sorry!</strong> incomplete input form</h3>
                        </div>
                    </div>
                </div>
           <?php } } elseif(isset ($header_title) && $header_title == "Recurring Bookkeeping") { ?>
            <table class="table table-striped table-bordered" style="width:100%;">
                <tbody>
                    <tr>
                        <td width="300" <?= $style; ?>>
                            <b> Financial Accounts:</b>
                        </td>
                        <td <?= $style; ?>>
                        <div id="accounts-list">
                            <input type="hidden" title="Financial Accounts" id="accounts-list-count" required="required" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                        </td>
                    </tr>  
                </tbody>
            </table>
           <?php } elseif (isset ($header_title) && $header_title == "Sales Tax Application") { ?>
            <table class="table table-striped table-bordered" style="width:100%;">
                <tbody>
                    <tr>
                        <td width="300" <?= $style; ?>>
                            <b> State of Sales Tax:</b>
                        </td> 
                        <td width="300" <?= $style; ?>>
                        
                        </td>
                    </tr>  
                    <tr>
                        <td width="300" <?= $style; ?>>
                            <b> County of Sales Tax:</b>
                        </td>  
                        <td width="300" <?= $style; ?>>
                        
                        </td>
                    </tr>  
                    <tr>
                        <td width="300" <?= $style; ?>>
                            <b> Bank Name:</b>
                        </td>  
                        <td width="300" <?= $style; ?>>
                        
                        </td>
                    </tr> 
                    <tr>
                        <td width="300" <?= $style; ?>>
                            <b> Bank Account #:</b>
                        </td>  
                        <td width="300" <?= $style; ?>>
                        
                        </td>
                    </tr> 
                    <tr>
                        <td width="300" <?= $style; ?>>
                            <b> Bank Routing #:</b>
                        </td>  
                        <td width="300" <?= $style; ?>>
                        
                        </td>
                    </tr>  
                    <tr>
                        <td width="300" <?= $style; ?>>
                            <b> Personal Or Business Account:</b>
                        </td>  
                        <td width="300" <?= $style; ?>>
                        
                        </td>
                    </tr>  
                    <tr>
                        <td width="300" <?= $style; ?>>
                            <b> Checking Or Savings Account:</b>
                        </td>  
                        <td width="300" <?= $style; ?>>
                        
                        </td>
                    </tr>  
                </tbody>
            </table>
             <?php  } else { ?>
        <div class="col-lg-12">            
            <div class = "text-center m-t-30">
                <div class = "alert alert-danger">
                    <i class = "fa fa-times-circle-o fa-4x"></i>
                    <h3><strong>Sorry!</strong> incomplete input form</h3>
                </div>
            </div>
        </div>
        <?php }?>
    </div>       
</div>
<script>
    $(function () {
          <?php if(isset($payer_information['payer_first_name'])){?>
            get_recipient_list('<?= $order_details['reference_id']; ?>', '<?= $reference; ?>');
        <?php } 
        if(isset($service_shortname) && $service_shortname != '')
        {
          if ($service_shortname == 'acc_b_b_d') { ?>
                get_financial_account_list('<?= $reference_id; ?>', 'month_diff', '<?= $order_id; ?>');
        <?php
        } else if ($service_shortname == 'acc_r_b') {
        ?>
                get_financial_account_list('<?= $reference_id; ?>', '', '<?= $order_id; ?>');
        <?php
        }
        }
        ?>         
    });
</script>