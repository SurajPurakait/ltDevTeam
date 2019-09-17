<?php
if (!empty($list)) :
    if ($list_type == "month_diff") :
        foreach ($list as $data) :
            $type = $data->type_of_account;
            if (strpos($type, 'Account') !== false) {
                $short_type = str_replace('Account', '', $type);
            } else {
                $short_type = $type;
            }
            $security_details= get_secuirity_details($data->id);
            ?>
            <div class="row">
                <label class="col-lg-2 control-label"><?= $short_type ?></label>
                <div class="col-lg-10" style="padding-top:8px">
                    <p>
                        <input type="hidden" class="total_amounts" title="Total Amount" value="<?= $data->grand_total ?>">
                        <b><?= $data->bank_name ?></b><br>
                        Account Number:<?= $data->account_number ?><br>
                        Routing Number:<?= $data->routing_number ?><br>
                        User Id :<?= $data->user ?><br>
                        Password :<?= $data->password ?><br>
                        Website URL :<?= $data->bank_website ?><br>
                        <!-- Transaction Number :<?//= $data->number_of_transactions ?><br> -->
                        <?php if(!empty($security_details)){ ?>
                        <b>Security Questions Answer:</b><br>
                        <?php
                        foreach($security_details as $sec_ans){
                        echo "Security Question : ".$sec_ans['security_question']."<br>";
                        echo "Security Answer : ".$sec_ans['security_answer']."<br>";
                        } } ?>
                        Grand Total Amount: $ <?= $data->grand_total ?><br>
                        #Of Transactions: <?= $data->number_of_transactions ?><br>
                        File: <?= $data->acc_doc?>
                    </p>
                    <p>
                        <i class="fa fa-edit" style="cursor:pointer" onclick="account_modal('edit', '<?= $data->id ?>', 'month_diff');" title="Edit this owner"></i>
                        &nbsp;&nbsp;<i class="fa fa-trash" style="cursor:pointer" onclick="delete_account(<?= $data->id ?>)" title="Remove this account"></i>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif ($list_type == "button") : ?>
        <h4>Select from Accounts</h4>
        <div class="row">
            <?php
            foreach ($list as $data) :
                $type = $data->type_of_account;
                if (strpos($type, 'Account') !== false) {
                    $short_type = str_replace('Account', '', $type);
                } else {
                    $short_type = $type;
                }
                ?>
                <div class="col-md-4"><div class="alert alert-info text-center">
                        <a href="javascript:void(0);" class="payroll-own" onclick="copy_financial_account_btn(<?= $data->id; ?>)">
                            <b><?= $short_type; ?></b><br>
                            <b><?= $data->bank_name; ?></b>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    else :
        foreach ($list as $data) :
            $type = $data->type_of_account;
            if (strpos($type, 'Account') !== false) {
                $short_type = str_replace('Account', '', $type);
            } else {
                $short_type = $type;
            }
//            echo $data->id;die;
            $security_details= get_secuirity_details($data->id);
//            print_r($security_details);
            ?>
            <div class="row">
                <label class="col-lg-2 control-label"><?= $short_type ?></label>
                <div class="col-lg-10" style="padding-top:8px">
                    <p>
                        <input type="hidden" class="total_amounts" title="Total Amount" value="<?= $data->total_amount ?>">                        
                        <b><?= $data->bank_name ?> </b><br>
                        Account Number:<?= $data->account_number ?><br>
                        Routing Number:<?= $data->routing_number ?><br>
                        User Id :<?= $data->user ?><br>
                        Password :<?= $data->password ?><br>
                        Website URL :<?= $data->bank_website ?><br>
                        <!-- Transaction Number :<?//= $data->number_of_transactions ?><br> -->
                        <?php if(!empty($security_details)){ ?>
                        <b>Security Questions Answer:</b><br>
                        <?php
                        foreach($security_details as $key=> $sec_ans){
                        echo "Security Question : ".$sec_ans['security_question']."<br>";
                        echo "Security Answer : ".$sec_ans['security_answer']."<br>";
                        } } ?>
                        Total Amount: $<?= $data->total_amount ?><br>
                        #Of Transactions: <?= $data->number_of_transactions ?><br>
                        File: <?= $data->acc_doc ?>
                    </p>
                    <p>
                        <i class="fa fa-edit" style="cursor:pointer" onclick="account_modal('edit', '<?= $data->id ?>', '');" title="Edit this owner"></i>
                        <i class="fa fa-trash" style="cursor:pointer" onclick="delete_account(<?= $data->id ?>)" title="Remove this account"></i>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>
<?php if ($list_type != "button") : ?>
    <input type="hidden" title="Financial Accounts" id="accounts-list-count" required="required" value="<?= count($list) != 0 ? count($list) : ""; ?>">
    <div class="errorMessage text-danger"></div>
<?php endif; ?>