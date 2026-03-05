<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Settlement','Advance Resettlement');
$this->pfrm->FrmHead2('Settlement / Advance Resettlement',$F_Class."/".'AdvanceResettlement',$F_Class."/".$F_Ctrl."_View");

 
?>

<?php 


  //  $adva = "select roomgrcid from Trans_Advancereceipt_mas where receiptid ='".@$ID."' and type ='RMS'";

  // $advqry = $this->db->query($adva)->row_array();

 	// 	 	$checkmas = "select * from Trans_checkout_mas where roomgrcid ='".$advqry['roomgrcid']."' and isnull(cancelflag,0) = 0 and checkoutno not like 'AHK%'";
  //       $checkcount = $this->db->query($checkmas)->num_rows();




?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$ID; ?>" >
      <table class="FrmTable T-8" >
        <tr>
          <td align="right" class="F_val">Room No</td>
          <td align="left"><input type="text" placeholder="RoomNo" id="RoomNo" readonly name="RoomNo" value="<?php echo @$RoomNo; ?>" class="scs-ctrl" />
            <div class="RoomNo" ></div></td>
          <td align="right" class="F_val">Receipt No</td>
          <td align="left"><input type="text" placeholder="Receiptno" id="Receiptno" readonly name="Receiptno" value="<?php echo @$yearprefix.'/'.@$Receiptno; ?>" class="scs-ctrl" />
            <div class="Receiptno" ></div></td>
        </tr>

        <tr>
          <td align="right" class="F_val">Guest Name</td>
          <td align="left"><input type="text" placeholder="Guest Name" id="GuestName" readonly name="GuestName" value="<?php echo $Title.'.'.$Firstname; ?>" class="scs-ctrl" />
            <div class="GuestName" ></div></td>
          <td align="right" class="F_val">Date</td>
          <td align="left"><input type="text" placeholder="date" id="date" name="date" readonly value="<?php echo date('d-m-Y', strtotime($rptdate)).' - '.substr($rpttime,11,5) ; ?>" class="scs-ctrl" />
            <div class="date" ></div></td>
        </tr>

        <tr>
          <td align="right" class="F_val">Advance Amount</td>
          <td align="left"><input type="text" placeholder="Advance" id="Advance" name="Advance" value="<?php echo $Amount; ?>" class="scs-ctrl" readonly />
            <div class="Advance" ></div></td>
          <td align="right" class="F_val">Previous mode</td>
          <td align="left"><input type="text" placeholder="PrePayMode" id="PrePayMode" name="PrePayMode" readonly value="<?php echo $PayMode ; ?>" class="scs-ctrl" />
            <div class="PrePayMode" ></div></td>
        </tr>      
        
        <tr>
          <td align="right" class="F_val">Paymode</td>
          <td align="left"><select required class="scs-ctrl"
                  onchange="paymodevalidate(this.value)" name="paymode" id="paymode" ><option value="">--Paymode--</option>
                  <?php 
                  $Res=$this->Myclass->PayMode();
                  foreach($Res as $row) 
                  {
                    if($row['InActive'] ==0 && $row['PayMode'] !='COMPANY' && $row['PayMode'] !='TOROOM' && $row['PayMode'] !='CASH ON DELIVERY')
                    {
                      echo '<option value="'.$row['PayMode'].'"	 >'.$row['PayMode'].'</option>';
                    }
                  }
                  ?>
                  </select>
            <div class="paymode" ></div></td>
          <td align="right" class="F_val">Remark</td>
          <td align="left"><input required type="text" placeholder="Remark" id="Remark" name="Remark" value="" class="scs-ctrl" />
            <div class="Remark" ></div></td>
        </tr> 
        <tr >
          <td style="display:none" id="caption" align="right" class="F_val">Bank Details</td>
          <td ><input type="text" style="display:none" id="cardnumber" class="scs-ctrl num" placeholder="Card Number" name="cardnumber"  ><div style="display:none" id="cardnumberdiv" class="cardnumber" ></div></td>
          <td><select name="bank" style="display:none"  class="scs-ctrl" id="bank"><option value="">--Bank--</option>
            <?php 
            $Res=$this->Myclass->Bank();
            foreach($Res as $row) 
            {
              echo '<option value="'.$row['Bankid'].'"	 >'.$row['bank'].'</option>';
              
            }
            ?>
            </select> <div style="display:block" id="bankdiv" class="bank" ></div>
          </td>
          <td><input style="display:none" type="date"  min="<?php echo date('Y-m-d'); ?>" class="scs-ctrl" id="validate" name="validate"><div style="display:none" id="validatediv" class="validate" ></div></td>   
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
        
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo @$BUT; ?>"   /></td>
   
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
  var bank=0;
 var card=0;
 var validate=0;
 var payid =0;
 function paymodevalidate(id) {  

    document.getElementById("caption").style.display = "none";
    document.getElementById("cardnumber").style.display = "none";
    document.getElementById("validate").style.display = "none"; 
    document.getElementById("cardnumberdiv").style.display = "none";
    document.getElementById("bankdiv").style.display = "none";
    document.getElementById("validatediv").style.display = "none";
    document.getElementById("bank").style.display = "none";

    if (id == "CASH") {
        return;
    } else if (id == "UPI") {
        $.ajax({
            type: "POST",
            url: "<?php echo scs_index ?>Transaction/UpiOptions",
            data: { id: id }, 
            success: function (html) {
                $("#bank").html(html);
            }
        });
        document.getElementById("bank").style.display = "block";
          document.getElementById("caption").style.display = "none";
    document.getElementById("cardnumber").style.display = "none";
    document.getElementById("validate").style.display = "none"; 
    document.getElementById("cardnumberdiv").style.display = "none";
    document.getElementById("bankdiv").style.display = "none";
    document.getElementById("validatediv").style.display = "none";
    } else {

            $.ajax({
            type: "POST",
            url: "<?php echo scs_index ?>Transaction/Otheroption",
            data: { id: id }, 
            success: function (html) {
                $("#bank").html(html);
            }
        });
        document.getElementById("bank").style.display = "block";
      
        document.getElementById("caption").style.display = "block";
        document.getElementById("cardnumber").style.display = "block";
        document.getElementById("validate").style.display = "block"; 
        document.getElementById("cardnumberdiv").style.display = "block";
        document.getElementById("validatediv").style.display = "block";
        document.getElementById("bankdiv").style.display = "block";
    }
}

 $(document).ready(function(e) {
    
	$('#Active').val(<?php echo @$Active; ?>);
	
});


</script>