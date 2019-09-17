<?php

        use PayPal\CoreComponentTypes\BasicAmountType;
        use PayPal\EBLBaseComponents\AddressType;
        use PayPal\EBLBaseComponents\CreditCardDetailsType;
        use PayPal\EBLBaseComponents\DoDirectPaymentRequestDetailsType;
        use PayPal\EBLBaseComponents\PayerInfoType;
        use PayPal\EBLBaseComponents\PaymentDetailsType;
        use PayPal\EBLBaseComponents\PersonNameType;
        use PayPal\PayPalAPI\DoDirectPaymentReq;
        use PayPal\PayPalAPI\DoDirectPaymentRequestType;
        use PayPal\Service\PayPalAPIInterfaceServiceService;
       require_once(APPPATH.'libraries/merchant-sdk-php-master/PPBootStrap.php');

       $staff_info = staff_info();

       $address = new AddressType();
        $address->Name = $staff_info['first_name'].' '.$staff_info['last_name'];
        $address->Street1 = 'Test1 address';
        $address->Street2 = 'Test2 address';
        $address->CityName = 'Test City';
        $address->StateOrProvince = 'Test State';
        $address->PostalCode = '1111111';
        $address->Country = 'US';
        $address->Phone = '23332323';

        $paymentDetails = new PaymentDetailsType();
        $paymentDetails->ShipToAddress = $address;

                    $total = 0;
                    $quan = 0;
                    if(!empty($cart_data)){
                        foreach($cart_data as $key=>$cd){
                            //$total += $cd['price']*$cd['quantity'];
                             $quan += $cd['quantity'];
                            $marketing_id = $cd['material_id'];
                             $itemprice = $cd['price'];
                             if($cd['type']==2){
                                $price = get_dynamic_price($cd['material_id'],$cd['quantity']);
                            }else{
                                $price = $cd['price'];
                            }
                            $total += $price*$cd['quantity'];
                        }
                        // $check_if_discount = check_if_discount($quan,$marketing_id); 

                        //         if(!empty($check_if_discount)){
                        //             $dis_quan = $check_if_discount['quantity'];
                        //             $dis_price = $check_if_discount['price'];
                        //             // $remain_quan = $quan - $dis_quan;
                        //             // $price_dis_new = $dis_price*$dis_quan;
                        //             // $price_old = $itemprice*$remain_quan;
                        //             $new_price = $dis_price*$quan;
                        //         }else{
                        //            $new_price = $total;
                        //         }
                                $new_price = $total;
                     }
        $paymentDetails->OrderTotal = new BasicAmountType('USD', $new_price);
/*
 *      Your URL for receiving Instant Payment Notification (IPN) about this transaction. If you do not specify this value in the request, the notification URL from your Merchant Profile is used, if one exists.

*/
//$paymentDetails->NotifyURL = base_url().'asd';


$personName = new PersonNameType();
$personName->FirstName = $staff_info['first_name'];
$personName->LastName = $staff_info['last_name'];

//information about the payer
$payer = new PayerInfoType();
$payer->PayerName = $personName;
$payer->Address = $address;
$payer->PayerCountry = 'US';

$cardDetails = new CreditCardDetailsType();
$cardDetails->CreditCardNumber = $formdata['creditCardNumber'];

/*
 *
Type of credit card. For UK, only Maestro, MasterCard, Discover, and
Visa are allowable. For Canada, only MasterCard and Visa are
allowable and Interac debit cards are not supported. It is one of the
following values:

* Visa
* MasterCard
* Discover
* Amex
* Solo
* Switch
* Maestro: See note.
`Note:
If the credit card type is Maestro, you must set currencyId to GBP.
In addition, you must specify either StartMonth and StartYear or
IssueNumber.`
*/
$cardDetails->CreditCardType = $formdata['creditCardType'];
$cardDetails->ExpMonth = $formdata['expDateMonth'];
$cardDetails->ExpYear = $formdata['expDateYear'];
$cardDetails->CVV2 = $formdata['cvv2Number'];
$cardDetails->CardOwner = $payer;

$ddReqDetails = new DoDirectPaymentRequestDetailsType();
$ddReqDetails->CreditCard = $cardDetails;
$ddReqDetails->PaymentDetails = $paymentDetails;
$ddReqDetails->PaymentAction = 'Sale';

$doDirectPaymentReq = new DoDirectPaymentReq();
$doDirectPaymentReq->DoDirectPaymentRequest = new DoDirectPaymentRequestType($ddReqDetails);

/*
 *       ## Creating service wrapper object
Creating service wrapper object to make API call and loading
Configuration::getAcctAndConfig() returns array that contains credential and config parameters
*/
$paypalService = new PayPalAPIInterfaceServiceService(Configuration::getAcctAndConfig());
try {
    /* wrap API method calls on the service object with a try catch */
    $doDirectPaymentResponse = $paypalService->DoDirectPayment($doDirectPaymentReq);
    //echo 'success';
    if(isset($doDirectPaymentResponse)) {
        if($doDirectPaymentResponse->Ack!='Failure'){
            removecartItem($cart_data);
            insertpurchaseList($cart_data,$doDirectPaymentResponse->TransactionID);
            echo '<div class="ibox">
                    <div class="ibox-content text-center p-t-40 p-b-40">
                        <img src="'.base_url().'assets/img/check_anim.gif?v='.rand(000,999).'">
                        <h1 class="m-b-20">Payment '.$doDirectPaymentResponse->Ack.'!</h1>
                        <h3>Transaction ID : <b>'.$doDirectPaymentResponse->TransactionID.'</b></h3>
                    </div>
                </div>';
        }else{
            echo '<div class="ibox">
                    <div class="ibox-content text-center p-t-40 p-b-40">
                        <img src="'.base_url().'assets/img/cross_anim.gif?v='.rand(000,999).'">
                        <h1 class="m-b-20 text-danger">Payment '.$doDirectPaymentResponse->Ack.'!</h1>
                        <h3>Error : <b>'.$doDirectPaymentResponse->Errors[0]->LongMessage.'</b></h3>
                        <div class="text-center m-t-20"><a class="btn btn-danger" href="'.base_url("/marketing_materials/view_cart").'"><i class="fa fa-refresh"></i> Try Again!</a></div>
                    </div>
                </div>';
        }
        
        // echo "<pre>";
        // print_r($doDirectPaymentResponse);
        // echo "</pre>";
    }
} catch (Exception $ex) {
    //include_once("../Error.php");
    //print_r($ex);
    echo '<div class="ibox">
                    <div class="ibox-content text-center p-t-40 p-b-40">
                        <img src="'.base_url().'assets/img/cross_anim.gif?v='.rand(000,999).'">
                        <h1 class="m-b-20 text-danger">Payment Not Successful!</h1>
                        <h3>Error : <b>Some Error Occured</b></h3>
                        <div class="text-center m-t-20"><a class="btn btn-danger" href="'.base_url("/marketing_materials/view_cart").'"><i class="fa fa-refresh"></i> Try Again!</a></div>
                    </div>
                </div>';
    //echo 'failure';
    exit;
}
//print_r($doDirectPaymentResponse);
?>