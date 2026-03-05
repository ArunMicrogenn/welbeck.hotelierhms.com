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

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form method="POST" action="<?php echo scs_index ?>Subscription/PaymentGateway">
    <input type="hidden" name="idv" value="<?php echo @$Facility_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Subscriber</td>
          <td align="left"><input type="text" readonly required placeholder="Subscriber" id="Subscriber" name="Subscriber" value="<?php echo $Company; ?>" class="scs-ctrl" />
            <div class="Subscriber" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Gstinn</td>
          <td align="left"><input type="text" readonly required placeholder="Gstinn" id="Gstinn" name="Gstinn" value="<?php echo $Gstinn; ?>" class="scs-ctrl" />
            <div class="Gstinn" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Email</td>
          <td align="left"><input type="text" readonly required placeholder="Email" id="Email" name="Email" value="<?php echo $Email; ?>" class="scs-ctrl" />
            <div class="Email" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Order Ref No</td>
          <td align="left"><input type="text" readonly placeholder="Ref No" id="RefNo" name="RefNo" value="<?php echo strtoupper(substr($Company,0,2)).rand(1000,9999).date('d').substr($City,0,2); ?>" class="scs-ctrl" />
            <div class="Email" ></div></td>
        </tr>
         <tr>
          <td align="right" class="F_val">Subscription Type</td>
          <td align="left"> 
		  <select onchange="Subscriptionselection(this.value)" name="Subscription" id="Subscription" class="scs-ctrl" >
              <option value="0" selected>Select Subscription Type</option>
              <?php 
                $sql="select * from mas_Subscription";
                $exe = $this->db->query($sql);
                foreach($exe -> result_array() as $row)
                {
              ?> <option value="<?php echo $row['Sub_Id']; ?>"><?php echo  $row['Subscription']; ?></option>		            		  	         
              <?php } ?>         
          </select>
            <div class="Subscription" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Amount</td>
          <td align="left"><input type="text" readonly required placeholder="Amount" id="Amount" name="Amount" value="" class="scs-ctrl" />
            <div class="Amount" ></div></td>
        </tr>
         
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left">			
			<input type="submit"  class="btn btn-success btn-sm" id="PayNow" name="PayNow" value="Pay Now"   /></td>
        </tr>
      </table>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script>

function Subscriptionselection(a){
 
      $.ajax({
        type:"POST",
        url:"<?php echo scs_index;?>Subscription/GetAmount/"+a,
        //data:{ label:a},
        success: function(a)
        {
 //         $("#Amount").html(html);
          $('#Amount').val(a);
        }		 
      });	
    }


  </script>

 
