<?php
if ($modal_type != "edit"):
//    print_r($account_details);
    ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Account</h3>
            </div>
            <?php
            if (!empty($account_details)) {
                foreach ($account_details as $val) {
                    ?>
                    <div class="m-t-10">
                        <div class="col-md-6">
                            <div class="form-group" id="bookkeeping_account_list">
                                <a class="btn btn-success"  href="javascript:void(0)" onclick="set_exist_bookkeeping_value('<?= $val['type_of_account'] ?>', '<?= $val['bank_name'] ?>', '<?= $val['account_number'] ?>', '<?= $val['routing_number'] ?>', '<?= $val['bank_website'] ?>', '<?= $val['user'] ?>', '<?= $val['password'] ?>','<?= $val['number_of_transactions'] ?>','<?= $val['total_amount'] ?>')">
                                    <b>Bank Name: <?= $val['bank_name'] ?></b><br>
                                    <b>Account Number: </b><?= $val['account_number'] ?><br>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="clearfix"></div>
            <form role="form" id="form_accounts" name="form_accounts">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Type Of Account</label>
                        <select class="form-control" name="type_of_account" id="acc_type" title="Type Of Account" required="">
                            <option value="">Select</option>
                            <option value="Bank Account">Bank Account</option>
                            <option value="Credit Card Account">Credit Card Account</option>
                            <option value="Amazon Account">Amazon Account</option>
                            <option value="Paypal">Paypal</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Bank Name/Financial Institution<span class="text-danger">*</span></label> 
                        <input placeholder="" class="form-control" type="text" name="bank_name" title="Bank Name" id="bank_name" required="" >
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Account Number<span class="text-danger">*</span></label> 
                        <input placeholder="" class="form-control" zipval="" type="text" name="account_number" id="acc_no" title="Account Number" required="" >
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Routing Number</label> 
                        <input placeholder="" class="form-control" type="text" zipval="" name="routing_number" id="routing_no" title="Routing Number">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>User Id</label> 
                        <input placeholder="" class="form-control" type="text" name="user" id="user_id" title="User Id">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Password</label> 
                        <input placeholder="" class="form-control" passval="" type="text" name="password" id="password" title="Password">
                        <div class="errorMessage text-danger"></div>
                    </div>                   
                    <div class="form-group security_question bg-red">
                        <label>Security Questions</label> 
                        <div class="secq-text  m-b-5">
                            <input placeholder="" class="form-control" type="text" name="security_question[]" class="secq" title="Security Questions">
                            <label>Security Answer</label> 
                            <input placeholder="" class="form-control" type="text" name="security_answer[]" class="secq" title="Security Answer">
                        </div>
                        <a href="javascript:void(0)" class="text-success add-secq"><i class="fa fa-plus"></i> Add Security Question</a>
                    </div>                    
                    <div class="form-group">
                        <label>Website URL<span class="text-danger">*</span></label> 
                        <input placeholder="" class="form-control" type="text" id="website" name="bank_website" title="Website URL" required="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Number Of Transactions<span class="text-danger">*</span></label>
                        <select class="form-control" name="number_of_transactions" id="no_of_transactions" title="Number Of Transactions" required="">
                            <option value="">Select</option>
                            <option value="0-100">0-100</option>
                            <option value="101-200">101-200</option>
                            <option value="201-300">201-300</option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Upload</label><br>
                        <span id="uploadifle"></span>
                        <input class="m-t-5" type="file" name="acc_file" id="acc_file">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Total Amount (in $)</label> 
                        <input class="form-control" type="text" readonly id="total_amount" name="total_amount" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>                          
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="order_id" id="order_id" value="<?= $order_id; ?>">
                    <input type="hidden" name="company_id" id="company_id" value="<?= $reference_id; ?>">
                    <input type="hidden" name="edit_id" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sub_btn" onclick="save_account('');">Save changes</button>
                </div>
            </form>
        </div>
    </div>
<?php else : ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Edit Account</h3>
            </div>
            <form role="form" id="form_accounts" name="form_accounts">
                <div class="modal-body">                  
                    <div class="form-group">
                        <label>Type Of Account</label>
                        <select class="form-control" name="type_of_account" title="Type Of Account" required="">
                            <option value="">Select</option>
                            <option value="Bank Account" <?= ($data["type_of_account"] == "Bank Account") ? "selected" : ""; ?>>Bank Account</option>
                            <option value="Credit Card Account" <?= ($data["type_of_account"] == "Credit Card Account") ? "selected" : ""; ?>>Credit Card Account</option>
                            <option value="Amazon Account" <?= ($data["type_of_account"] == "Amazon Account") ? "selected" : ""; ?>>Amazon Account</option>
                            <option value="Paypal" <?= ($data["type_of_account"] == "Paypal") ? "selected" : ""; ?>>Paypal</option>
                            <option value="Other" <?= ($data["type_of_account"] == "Other") ? "selected" : ""; ?>>Other</option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Bank Name/Financial Institution<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="bank_name" id="bank_name" value="<?= $data["bank_name"]; ?>" title="Bank Name" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Account Number<span class="text-danger">*</span></label>
                        <input class="form-control" zipval="" type="text" name="account_number" id="account_number" title="Account Number" required value="<?= $data["account_number"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Routing Number</label>
                        <input class="form-control" type="text" zipval="" name="routing_number" id="routing_number" title="Routing Number" value="<?= $data["routing_number"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>User Id</label>
                        <input class="form-control" type="text" name="user" id="user" title="User Id" value="<?= $data["user"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" passval="" type="text" name="password" id="password" title="Password" value="<?= $data["password"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <?php
                    $questions = explode("|", $data["questions"]);
                    $answers = explode("|", $data["answers"]);
                    $question_array = [];
                    foreach ($questions as $key => $value) {
                        $question_array[$key]["question"] = $value;
                        $question_array[$key]["answer"] = $answers[$key];
                    }
                    $count = 0;
                    foreach ($question_array as $question):
                        $colorarray = array('sq-red', 'sq-green', 'sq-blue', 'sq-orange', 'sq-purple', 'sq-sky', 'sq-till');
                        $colorkey = array_rand($colorarray);
                        $randcolor = $colorarray[$colorkey];
                        ?>
                        <div class="security_question <?php echo $randcolor; ?>">
                            <div class="form-group m-b-5">
                                <label>Security Questions</label>
                                <div class="secq-text">
                                    <input class="form-control" type="text" name="security_question[]" class="secq" title="Security Questions" value="<?= $question["question"]; ?>">
                                    <label>Security Answer</label>
                                    <input class="form-control" type="text" name="security_answer[]" class="secq" title="Security Answer" value="<?= $question["answer"]; ?>">
                                </div>
                                <?php if ($count == 0) { ?>
                                    <a href="javascript:void(0)" class="text-success add-secq"><i class="fa fa-plus"></i>Add Security Question</a>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        $count++;
                    endforeach;
                    ?>
                    <div class="form-group">
                        <label>Website URL<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="bank_website" id="bank_website" title="Website URL" required value="<?= $data["bank_website"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <?php  if($data['reference'] == "project")
                    { ?>
                    <div class="form-group" style="display:none;">
                        <label>Number Of Transactions<span class="text-danger">*</span></label>
                        <select class="form-control" name="number_of_transactions" id="no_of_transactions" title="Number Of Transactions">
                            <option value="">Select</option>
                            <option value="0-100" <?= ($data["number_of_transactions"] == "0-100") ? "selected" : ""; ?>>0-100</option>
                            <option value="101-200" <?= ($data["number_of_transactions"] == "101-200") ? "selected" : ""; ?>>101-200</option>
                            <option value="201-300" <?= ($data["number_of_transactions"] == "201-300") ? "selected" : ""; ?>>201-300</option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <?php } else { ?>
                       <div class="form-group" style="display:block;">
                        <label>Number Of Transactions<span class="text-danger">*</span></label>
                        <select class="form-control" name="number_of_transactions" id="no_of_transactions" title="Number Of Transactions" required="">
                            <option value="">Select</option>
                            <option value="0-100" <?= ($data["number_of_transactions"] == "0-100") ? "selected" : ""; ?>>0-100</option>
                            <option value="101-200" <?= ($data["number_of_transactions"] == "101-200") ? "selected" : ""; ?>>101-200</option>
                            <option value="201-300" <?= ($data["number_of_transactions"] == "201-300") ? "selected" : ""; ?>>201-300</option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div> 
                    <?php
                    }
                        ?>
<!--                    <div class="form-group">
                        <label>Upload</label><br>
                        <span id="uploadifle"></span>
                        <input class="m-t-5" type="file" name="acc_file" id="acc_file">
                        <div class="errorMessage text-danger"></div>
                    </div>-->
                    <?php  if($data['reference'] == "project")
                    { ?>
                    <div class="form-group" style="display:none;">
                        <label>Total Amount (in $) Per Month</label>
                        <input class="form-control" type="text" readonly id="total_amount" name="total_amount" value="<?= $data["total_amount"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div>  
                    <?php } else {
                        ?>
                    <div class="form-group" style="display:block;">
                        <label>Total Amount (in $) Per Month</label>
                        <input class="form-control" type="text" readonly id="total_amount" name="total_amount" value="<?= $data["total_amount"]; ?>">
                        <div class="errorMessage text-danger"></div>
                    </div> 
                    
                   <?php }?>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="company_id" value="<?= $reference_id; ?>">
                    <input type="hidden" name="edit_id" value="<?= $id; ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save_account('');">Save changes</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<script>
    $(document).ready(function () {
        $('.add-secq').click(function () {//alert('ff');
            var qval = $(this).prev('.secq-text').html();
            var qlabel = $(this).parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var colorarray = ['sq-red', 'sq-green', 'sq-blue', 'sq-orange', 'sq-purple', 'sq-sky', 'sq-till'];
            var randcolor = colorarray[Math.floor(Math.random() * colorarray.length)];
            var newHtml = '<div class="security_question ' + randcolor + '" id="secq_div' + div_count + '"><div class="form-group"><label>' + qlabel + '</label>' + qval + '<a href="javascript:void(0)" onclick="removeSecq(\'secq_div' + div_count + '\')" class="text-danger rem-secq"><i class="fa fa-times"></i> Remove Security Question</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.security_question'));
        });
        $("#number_of_transactions").change(function () {
            var val = $("#number_of_transactions option:selected").val();
            var amt = 0;
            if (val != '') {
                if (val == '0-100') {
                    amt = 149;
                } else if (val == '101-200') {
                    amt = 175;
                } else if (val == '201-300') {
                    amt = 200;
                }
            } else {
                amt = 149;
            }
            var count_fc_ac = document.getElementsByClassName('total_amounts').length;
            if (count_fc_ac > 0) {
                if (val != '') {
                    if (val == '0-100') {
                        amt = 25;
                    } else if (val == '101-200') {
                        amt = 50;
                    } else if (val == '201-300') {
                        amt = 75;
                    }
                } else {
                    var amt = 25;
                }
            }
            $("#total_amount").val(amt);
        });
    });
    function removeSecq(divID) {
        $("#" + divID).remove();
    }
</script>