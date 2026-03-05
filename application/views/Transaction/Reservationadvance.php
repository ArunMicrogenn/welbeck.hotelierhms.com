<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Reservation Advanca');
$this->pfrm->FrmHead2('Transaction/ Reservation Advance',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

$year = "select dbo.YearPrefix() as id";
$res = $this->db->query($year);
foreach($res->result_array() as $r){
  $yearPrefix= $r['id'];
}
?>

<div class="col-sm-12">
  <div class="the-box F_ram"> 
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$PlanType_Id; ?>" >
       <input type="hidden" name="Keey" id="Keey" value="<?php echo @$Keey; ?>" >
      <table class="FrmTable T-6" >
        <tr>
          <td style="text-align: right;" class="F_val">Reservation No</td>
          <td align="left"> 
              <?php
          $Res=$this->Myclass->Get_ResNo();
		  foreach($Res as $row)
			{
			    $resnumber= $row['number'];
			}
		  ?> <input type="text" readonly name="Resnumber" id="Resnumber" value="" >
            <div class="RoomType_Id" ></div></td>
        
         <td style="text-align: left;" class="F_val">Receipt No</td>
          <td align="left"> 
              <?php
          $Res=$this->Myclass->Get_ResaddNo();
		  foreach($Res as $row)
			{
			    $resnumber= $row['number'];
			}
		  ?> <input type="text" readonly name="Resnumber" id="Resnumber" value="<?php echo $resnumber; ?>" >
            <div class="RoomType_Id" ></div></td>
		</tr>
        </table>
        
         
    
	   <br>
	   <table class="FrmTable T-10" >
	   <tr>
	    <td style="text-align: right;">Guest Name</td>
		<td style="text-align: left;">
		<input type="text" name="Guestname" class="f-ctrl rmm" id="Guestname" >
		</td>
		<td style="text-align: right;">Rooms</td>
		<td style="text-align: left;">
		<input type="text" name="Rooms" class="f-ctrl rmm" id="Rooms" >
		</td>
		<td style="text-align: right;">Pax</td>
		<td style="text-align: left;">
		<input type="text" name="Pax" class="f-ctrl rmm" id="Pax" >  
		</td>
	   </tr>
	    <tr>
		  <td style="text-align: right;">Company</td>
		  <td style="text-align: left;">
		  <input type="text" name="Company" class="f-ctrl rmm" id="Company" >  
		  </td>
		  <td style="text-align: right;">Arrival Date & Time</td>
		  <td style="text-align: left;">
		  <input type="text" name="ArrivalDate" class="f-ctrl rmm" id="ArrivalDate" >  
		  </td> 
		  <td style="text-align: right;">Departure Date & Time</td>
		  <td style="text-align: left;">
		   <input type="text" name="DepartureDate" class="f-ctrl rmm" id="DepartureDate" > 
		   </td>
		</tr>
		<tr>
		<td style="text-align: right;">Tariff</td>
		  <td style="text-align: left;">
		  <input type="text" name="Tariff" class="f-ctrl rmm" id="Tariff" > 
		   </td>
		
		<td style="text-align: right;">Currency</td>
		  <td style="text-align: left;">
		   <input type="Currency" name="Currency" class="f-ctrl rmm" id="Tariff" > 
		   </td>
		  <td style="text-align: right;">Available Advance</td>
		  <td style="text-align: left;">
		  <input type="Text" name="AvailableAdvance" id="AvailableAdvance" class="f-ctrl rmm">
		  </td>
		</tr>
		<tr>
		<td style="text-align: right;">Amount</td>
		  <td style="text-align: left;">
		  <input type="text"  num=1 name="Amount" id="Amount"  class="f-ctrl rmm" >
		  </td>
	      <td style="text-align: right;">Narration</td>
		  <td style="text-align: left;">
		  <input type="text"  num=1 name="Narration" id="Narration"  class="f-ctrl rmm" >
		  </td>
		</tr>
		<tr>
		 <td style="text-align: right;">Paymode</td>
		<td><select required class="f-ctrl rmm"
		onchange="paymodevalidate(this.value)" name="paymode" id="paymode" ><option value="">--Paymode--</option>
		<?php 
		$Res=$this->Myclass->PayMode();
		foreach($Res as $row) 
		{
		  if($row['InActive'] ==0 && $row['PayMode'] !='COMPANY ')
		   {
		   echo '<option value="'.$row['PayMode_Id'].'"	 >'.$row['PayMode'].'</option>';
		   }
		}
		?>
		</select></td>
		 <td  style="text-align: right;">Bank Details</td>
	    <td><input type="text" class="f-ctrl rmm" placeholder="Card Number" name="cardnumber" id="cardnumber" ></td>
	    <td><select name="bank" class="f-ctrl rmm" id="bank"><option value="">--Bank--</option>
		<?php 
		$Res=$this->Myclass->Bank();
		foreach($Res as $row) 
		{
		   echo '<option value="'.$row['Bankid'].'"	 >'.$row['bank'].'</option>';
			
		}
		?>
		</select>
	    </td>
	    <td><input type="date" class="f-ctrl rmm" id="validate" name="validate"></td>
	    </tr>
		</table>
        <div style="margin-top:15px;" align="right">
        <input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   />
      </div>
    </fieldset>
  </div>
  <div class="the-box D_ISS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<SCRIPT language="javascript">
 var bank=0;
 var card=0;
 var validate=0;
 var payid =0;
 function paymodevalidate(id)
 {  
   payid=id;
   if(id !=1)
   { document.getElementById("caption").style.display = "block";
	///// document.getElementById("cardno").style.display = "block";
	// document.getElementById("bankse").style.display = "block";
	// document.getElementById("vdate").style.display = "block";
    // document.getElementById("bank").required = true;
	 document.getElementById("cardnumber").required = true;
	 document.getElementById("validate").required = true; }
	else
	{
     document.getElementById("bank").required = false;
	 document.getElementById("cardnumber").required = false;
	 document.getElementById("validate").required = false;
     document.getElementById("caption").style.display = "none";
	//  document.getElementById("cardno").style.display = "none";
	// document.getElementById("bankse").style.display = "none";
	// document.getElementById("vdate").style.display = "none"; 
	}
 }
	</SCRIPT>
	
	