<?php $staff_info = staff_info(); ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <div class="response-data">
                <div class="ibox">
                    <div class="ibox-title">
                        Payment Method
                    </div>
                    <div class="ibox-content">
                        <?php //print_r($cart_data);
                        $total = 0;
                        if(!empty($cart_data)){
                            $quan = 0;
                            foreach($cart_data as $key=>$cd){
                                $quan += $cd['quantity'];
                                $marketing_id = $cd['material_id'];
                                if($cd['type']==2){
                                    $itemprice = get_dynamic_price($cd['material_id'],$cd['quantity']);
                                }else{
                                    $itemprice = $cd['price'];
                                }
                                 $total += $itemprice*$cd['quantity'];
                            }
                            //$check_if_discount = check_if_discount($quan,$marketing_id);
                            // if(!empty($check_if_discount)){
                            //         $dis_quan = $check_if_discount['quantity'];
                            //         $dis_price = $check_if_discount['price'];
                            //         // $remain_quan = $quan - $dis_quan;
                            //         // $price_dis_new = $dis_price*$dis_quan;
                            //         // $price_old = $itemprice*$remain_quan;
                            //         $new_price = $dis_price*$quan;
                            //     }else{
                            //         $new_price = $total;
                            //     }
                            $new_price = $total;
                        }else{
                            $new_price = 0;
                        }
                         ?>
                       <form class="form-horizontal" method="post" id="form_checkout_marketing_materials" name="DoDirectPaymentForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Card Type<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="creditCardType" id="creditCardType" onChange="javascript:generateCC(); return false;"  title="Card Type" required>
                                                <option value="Visa" selected="selected">Visa</option>
                                                <option value="MasterCard">MasterCard</option>
                                                <option value="Discover">Discover</option>
                                                <option value="Amex">American Express</option>
                                            </select>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Card Number<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control" required type="text" size="19" maxlength="19" title="Card Number" id="creditCardNumber" name="creditCardNumber">
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Expiry Date<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                           <select class="form-control" name="expDateMonth">
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="expDateYear">
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>  
                                                <option value="2022">2022</option>                        
                                                <option value="2023">2023</option>  
                                                <option value="2024">2024</option>  
                                            </select>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">CVV<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control" title="CVV" id="cvv2Number" type="password" numeric_valid="" size="3" maxlength="4" name="cvv2Number" value="" required>
                                            <div class="errorMessage text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="amount" value="<?php echo $new_price; ?>">
                            <div class="hr-line-dashed"></div>

                            <div class="form-group m-b-0">
                                <div class="text-center">
                                    <button class="btn btn-success save_btn" type="button" onclick="pay_with_paypal()">
                                        Pay
                                    </button> &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-default" type="button" onclick="cancel_pay_with_paypal()">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center">
                    <img src="<?php echo base_url(); ?>assets/img/payment-mode.png" />
                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function generateCC(){
        var cc_number = new Array(16);
        var cc_len = 16;
        var start = 0;
        var rand_number = Math.random();

        switch(document.DoDirectPaymentForm.creditCardType.value)
        {
            case "Visa":
                cc_number[start++] = 4;
                break;
            case "Discover":
                cc_number[start++] = 6;
                cc_number[start++] = 0;
                cc_number[start++] = 1;
                cc_number[start++] = 1;
                break;
            case "MasterCard":
                cc_number[start++] = 5;
                cc_number[start++] = Math.floor(Math.random() * 5) + 1;
                break;
            case "Amex":
                cc_number[start++] = 3;
                cc_number[start++] = Math.round(Math.random()) ? 7 : 4 ;
                cc_len = 15;
                break;
        }

        for (var i = start; i < (cc_len - 1); i++) {
            cc_number[i] = Math.floor(Math.random() * 10);
        }

        var sum = 0;
        for (var j = 0; j < (cc_len - 1); j++) {
            var digit = cc_number[j];
            if ((j & 1) == (cc_len & 1)) digit *= 2;
            if (digit > 9) digit -= 9;
            sum += digit;
        }

        var check_digit = new Array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);
        cc_number[cc_len - 1] = check_digit[sum % 10];

        document.DoDirectPaymentForm.creditCardNumber.value = "";
        for (var k = 0; k < cc_len; k++) {
            document.DoDirectPaymentForm.creditCardNumber.value += cc_number[k];
        }
    }
</script>