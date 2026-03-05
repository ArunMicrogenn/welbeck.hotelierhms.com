<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Subscription','Pay Now');
$this->pfrm->FrmHead3('Subscription / Pay Now',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

$sql="select * from mas_Hotel where Hotel_id=1";
$exe = $this->db->query($sql);
foreach($exe -> result_array() as $row){
   $Company=$row['Company'];
   $Gstinn=$row['Gstinn'];
   $Email=$row['Email'];
   $City=$row['City'];
}
?>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0"/>
<?php
require_once("PaytmChecksum.php");
	
$paytmParams = array();
//define('PAYTM_ENVIRONMENT', 'https://securegw.paytm.in');
?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form name="scsfrm" id="scsfrm" method="POST" action="<?php echo scs_index ?>Subscription/PaymentGateway">
    <input type="hidden" name="idv" value="<?php echo @$Facility_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Subscriber</td>
          <td align="left"><input type="text" readonly placeholder="Subscriber" id="Subscriber" name="Subscriber" value="<?php echo $Company; ?>" class="scs-ctrl" />
            <div class="Subscriber" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Gstinn</td>
          <td align="left"><input type="text" readonly placeholder="Gstinn" id="Gstinn" name="Gstinn" value="<?php echo $Gstinn; ?>" class="scs-ctrl" />
            <div class="Gstinn" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Email</td>
          <td align="left"><input type="text" readonly placeholder="Email" id="Email" name="Email" value="<?php echo $Email; ?>" class="scs-ctrl" />
            <div class="Email" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Order Ref No</td>
          <td align="left"><input type="text" readonly placeholder="Ref No" id="RefNo" name="RefNo" value="<?php echo $_POST['RefNo'] ?>" class="scs-ctrl" />
            <div class="Email" ></div></td>
        </tr>
         <tr>
          <td align="right" class="F_val">Subscription Type</td>
          <td align="left"> 
		  <select onchange="Subscriptionselection(this.value)" name="Subscription" id="Subscription" class="scs-ctrl" >
		    <option value="1">Select Subscription Type</option>
		 	<option value="1000">Monthly Subscription 30Days</option>
			<option value="6000">6 Monthly Subscription 180Days</option>
			<option value="10000">yearly Subscription 360Days</option>          
          </select>
            <div class="Subscription" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Amount</td>
          <td align="left"><input type="text" readonly required placeholder="Amount" id="Amount" name="Amount" value="<?php echo $_POST['Amount'] ?>" class="scs-ctrl" />
            <div class="Amount" ></div></td>
        </tr>
         
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left">			
			<input type="submit"  class="btn btn-success btn-sm" id="PayNow" disabled name="PayNow" value="Please wait.."   /></td>
        </tr>
      </table>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div class="form-group form-button">                                
                                <a class="form-submit" name="blinkCheckoutPayment" id="blinkCheckoutPayment" value="Pay"></a>
                            </div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script>
    $(document).ready(function(e) {
   
   $('#Subscription').val(<?php echo $_POST['Subscription']; ?>);
   
  });
</script>
<?php 
	function getTransactionToken(){
	
	//	$generatedOrderID = "PYTM_BLINK_".time();
		$generatedOrderID=$_POST['RefNo'];
		$amount = $_POST['Amount'];
		$callbackUrl = scs_url.'index.php/Subscription/Paytm_Response';
	
		$paytmParams["body"] = array(
									"requestType" 	=> "Payment",
									"mid" 			=> "wfKxHF13214905669128",
									"websiteName" 	=> "mrsresidency",
									"orderId" 		=> $generatedOrderID,
									"callbackUrl" 	=> $callbackUrl,
									"txnAmount" 	=> array(
															"value" => $amount,
															"currency" => "INR",
														),
									"userInfo" 		=> array(
														"custId" => "CUST_".time(),
													),
								);
	
			$generateSignature = PaytmChecksum::generateSignature(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), 'RHCuObUIW0se&#dB');
	
			$paytmParams["head"] = array(
									"signature"	=> $generateSignature
								);
	
			$url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=wfKxHF13214905669128&orderId=". $generatedOrderID;
	
			$getcURLResponse = getcURLRequest($url, $paytmParams);
	
			if(!empty($getcURLResponse['body']['resultInfo']['resultStatus']) && $getcURLResponse['body']['resultInfo']['resultStatus'] == 'S'){
				$result = array('success' => true, 'orderId' => $generatedOrderID, 'txnToken' => $getcURLResponse['body']['txnToken'], 'amount' => $amount, 'message' => $getcURLResponse['body']['resultInfo']['resultMsg']);
			}else{
				$result = array('success' => false, 'orderId' => $generatedOrderID, 'txnToken' => '', 'amount' => $amount, 'message' => $getcURLResponse['body']['resultInfo']['resultMsg']);
			}
			return $result;
		
		}
		function getcURLRequest($url , $postData = array(), $headers = array("Content-Type: application/json")){
	
			$post_data_string = json_encode($postData, JSON_UNESCAPED_SLASHES);
	
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
			$response = curl_exec($ch);
			return json_decode($response,true);
		}
	
		function getSiteURL(){
			$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			return str_replace('config.php', '', $actual_link);
		}
		
		 $result = getTransactionToken();
	?>
    <script type="application/javascript" src="https://securegw.paytm.in/merchantpgpui/checkoutjs/merchants/wfKxHF13214905669128.js"  crossorigin="anonymous"></script>	
<script>
    $(document).ready(function(e) {
   
   $('#Subscription').val(<?php echo $_POST['Subscription']; ?>);
   
  });
	
    setTimeout("CallButton()",2000)
    function CallButton()
    {
       document.getElementById("blinkCheckoutPayment").click();   		
    }
     document.getElementById("blinkCheckoutPayment").addEventListener("click", function(){			 
         alert('<?php echo $result['orderId']?>');
         alert('<?php echo $result['txnToken']?>');
         alert('<?php echo $result['amount']?>');
             openBlinkCheckoutPopup('<?php echo $result['orderId']?>','<?php echo $result['txnToken']?>','<?php echo $result['amount']?>');
         }
     );
     
    function openBlinkCheckoutPopup(orderId, txnToken, amount)
     {			 
         // console.log(orderId, txnToken, amount);
         var config = {
             "root": "",
             "flow": "DEFAULT",
             "data": {
                 "orderId": orderId, 
                 "token": txnToken, 
                 "tokenType": "TXN_TOKEN",
                 "amount": amount 
             },
             "handler": {
             "notifyMerchant": function(eventName,data){
                 console.log("notifyMerchant handler function called");
                 console.log("eventName => ",eventName);
                 console.log("data => ",data);
                 ///location.reload();
                 window.history.go(-1);
             } 
             }
         };
          if(window.Paytm && window.Paytm.CheckoutJS){
                 // initialze configuration using init method 
                 window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
                     // after successfully updating configuration, invoke checkoutjs
                     window.Paytm.CheckoutJS.invoke();
                 }).catch(function onError(error){
                     console.log("error => ",error);
                 });
         }
    }
  </script>