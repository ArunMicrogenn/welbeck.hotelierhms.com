<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->nightaudit();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Reservation Advance Refund');
$this->pfrm->FrmHead1('Transaction / Reservation Advance Refund',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

$Res=$this->Myclass->Get_Resclno();
foreach($Res as $row)
 { $id=$row['number'];
 }

 $year = "select dbo.YearPrefix() as id";
 $res = $this->db->query($year);
 foreach($res->result_array() as $r){
   $yearPrefix= $r['id'];
 }
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$reserveid; ?>" >
      <table class="FrmTable T-8" >
        <tr>
            <td align="right" class="F_val">Reservation No</td>
            <td align="left" class="F_val">
            <?php if(@$reserveid){ ?>
              <input type="text" readonly class="scs-ctrl" value="<?php echo @$yearprefix.'/'.@$ResNo; ?>" name="ResNo" id="ResNo">
              <input type="hidden" readonly class="scs-ctrl" value="<?php echo @$reserveid; ?>" name="roomid" id="roomid">
            <?php } else{?>
            <input type="hidden" name="roomid" id="roomid1">
            <select onchange="fetchdepdate(this.value);" id="roomid" name="roomid" class="scs-ctrl scs-ctrl-select">
              <option value="">---Select Res.No---</option>
                  <?php $sql="select * from trans_reservecancel_mas mas 
                                Inner join Trans_Reserve_Mas rmas on rmas.resid=mas.reserveid
                                where isnull(mas.refund,0)=0 and isnull(advamount,0)<>0";
                      $res=$this->db->query($sql);
                      foreach ($res->result_array() as $row)
                      {
                        echo '<option value="'.$row['Resid'].'">'.$row['ResNo'].'</option>';
                      }?>
            </select>
            <?php }?>
            <div class="roomid"></div>
          </td>
          <td align="right" class="F_val">Receipt.No</td>
          <td align="left" class="F_val"><input type="Text" readonly  class="scs-ctrl" value="<?php if(@$reserveid){ echo $yearprefix.'/'.$resno; }else{ echo $yearPrefix.'/'.$id; }?>"  id="ReceiptNo" name="ReceiptNo"/></td>
        </tr>
        <tr>
            <td align="right" class="F_val">Guest Name</td>
            <td align="left" class="F_val"><input type="Text" class="scs-ctrl" value="<?php echo @$Name; ?>"  id="Guest" name="Guest"/></td>
            <td align="right" class="F_val">Date</td>
            <td align="left" class="F_val"><input type="Text" readonly value="<?php echo date("d-m-Y") ?>" class="scs-ctrl rmm" id="Date" name="Date"/></td>
        </tr>
        <tr>
            <td align="right" class="F_val">Refund Amount</td>
            <td align="left" class="F_val"><input onChange="AmountValidate(this.value)" type="Text" value="<?php echo @$refund; ?>" class="scs-ctrl rmm" num=1 id="Amount" name="Amount"/>
            <div class="Amount"></div></td>
            <td align="right" class="F_val">Paid Advance</td>
            <td align="left" class="F_val"><input type="Text" readonly class="scs-ctrl rmm" num=1 id="Paid" value="<?php echo @$advamount; ?>" name="Paid"/></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Paymode</td>
          <td align="left">
           <input type="hidden" name="paymode" id="paymode1">
            <select required class="scs-ctrl scs-ctrl-select"
            onchange="paymodevalidate(this.value)" name="paymode" id="paymode" ><option value="">--Paymode--</option>
                  <?php 
                  $Res=$this->Myclass->PayMode();
                  foreach($Res as $row) 
                  {
                    if($row['InActive'] ==0 && $row['PayMode'] =='CASH')
                      {
                      echo '<option value="'.$row['PayMode_Id'].'"	 >'.$row['PayMode'].'</option>';
                    }
                  }
                  ?>
                  </select>
            <div class="paymode" ></div></td>
            <td align="right" class="F_val">Remark</td>
            <td align="left"><input required type="text" placeholder="Remark" id="Remark" name="Remark" value="<?php echo @$Remarks; ?>"  class="scs-ctrl" />
              <div class="Remark" ></div></td>
        </tr>        
        <tr >
            <td align="right" class="F_val"><div id="caption" style="display:none">Card Number</div></td>
            <td><input type="text" style="display:none" class="scs-ctrl" value="<?php echo @$chqno; ?>" placeholder="Card Number" name="cardnumber" id="cardnumber" > <div style="display:none" id="errcardnumber" class="cardnumber"></div></td>
            <td align="right" class="F_val" ><div id="Bankcaption" style="display:none">Bank</div></td>
            <td>
              <input type="hidden" name="bank" id="bank1">
              <select style="display:none" name="bank" class="scs-ctrl scs-ctrl-select" id="bank"><option value="">--Bank--</option>
                <?php 
                $Res=$this->Myclass->Bank();
                foreach($Res as $row) 
                {
                  echo '<option value="'.$row['Bankid'].'"	 >'.$row['bank'].'</option>';
                  
                }
                ?>
                </select><div style="display:none" id="errbank" class="bank"></div>
            </td>            
        </tr>
        <tr>
        <td align="right" class="F_val"><div id="Validcaption" style="display:none">Valid Date</div></td>
        <td><input type="date" style="display:none" class="scs-ctrl"  value="<?php if(@$validdate){echo date('Y-m-d',strtotime(@$validdate));} ?>" id="validate" name="validate"><div style="display:none" id="errvalidate" class="validate"></div></td>   
        <tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button" class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
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
 
 $(document).ready(function(e) {      
    $('#paymode').val(<?php echo @$payid; ?>);  
    $('#paymode1').val(<?php echo @$payid; ?>);  
    $('#bank').val(<?php echo @$bankid; ?>);      
    $('#bank1').val(<?php echo @$bankid; ?>);      
    var id=<?php if(@$payid){echo @$payid;}else {echo "1"; } ?>;
    if(id ==1 )
   {
    document.getElementById("caption").style.display = "none";
     document.getElementById("cardnumber").style.display = "none"; 
     document.getElementById("bank").style.display = "none"; 
     document.getElementById("errbank").style.display = "none"; 
     document.getElementById("errcardnumber").style.display = "none"; 
     document.getElementById("errvalidate").style.display = "none"; 
     document.getElementById("validate").style.display = "none"; 
     document.getElementById("Validcaption").style.display = "none";
    document.getElementById("Bankcaption").style.display = "none";
    document.getElementById("bank").value = '';
  
   }else if( id == 13){
    document.getElementById("caption").style.display = "none";
    document.getElementById("Validcaption").style.display = "none";
    document.getElementById("Bankcaption").style.display = "block";
    document.getElementById("cardnumber").style.display = "none"; 
    document.getElementById("bank").style.display = "block"; 
    document.getElementById("errbank").style.display = "block"; 
    document.getElementById("errvalidate").style.display = "none"; 
    document.getElementById("errcardnumber").style.display = "none"; 
    document.getElementById("validate").style.display = "none"; 

   }
	else if(id != 1 && id != 13)
	{
    document.getElementById("caption").style.display = "block";
    document.getElementById("Validcaption").style.display = "block";
    document.getElementById("Bankcaption").style.display = "block";
    document.getElementById("cardnumber").style.display = "block"; 
    document.getElementById("bank").style.display = "block"; 
    document.getElementById("errbank").style.display = "block"; 
    document.getElementById("errvalidate").style.display = "block"; 
    document.getElementById("errcardnumber").style.display = "block"; 
    document.getElementById("validate").style.display = "block"; 
  	}  
  });
  function AmountValidate(value)  { 
     var paid= document.getElementById("Paid").value;
     paid=parseInt(paid);     
     if(value >paid )
     {  swal("More than the Advance...!", "Sorry You cannot make refund more than the Advance", "warning");
        document.getElementById("Amount").value='0';
     }
     
  }
 function paymodevalidate(id)
 {  
   payid=id;
   if(id ==1 )
   {
    document.getElementById("caption").style.display = "none";
     document.getElementById("cardnumber").style.display = "none"; 
     document.getElementById("bank").style.display = "none"; 
     document.getElementById("errbank").style.display = "none"; 
     document.getElementById("errcardnumber").style.display = "none"; 
     document.getElementById("errvalidate").style.display = "none"; 
     document.getElementById("validate").style.display = "none"; 
     document.getElementById("Validcaption").style.display = "none";
    document.getElementById("Bankcaption").style.display = "none";
    document.getElementById("bank").value = '';
    document.getElementById("cardnumber").value= ''; 
    

   }else if( id == 13){

        $.ajax({
        type:"POST",
        url:"<?php echo scs_index ?>Transaction/UpiOptions",
        data:"id"+id,
        success: function (html){
          // console.log(html)
          $("#bank").html(html)
        }
      })
    document.getElementById("caption").style.display = "none";
    document.getElementById("Validcaption").style.display = "none";
    document.getElementById("Bankcaption").style.display = "block";
    document.getElementById("cardnumber").style.display = "none"; 
    document.getElementById("bank").style.display = "block"; 
    document.getElementById("errbank").style.display = "block"; 
    document.getElementById("errvalidate").style.display = "none"; 
    document.getElementById("errcardnumber").style.display = "none"; 
    document.getElementById("validate").style.display = "none"; 
    document.getElementById("cardnumber").value= ''; 
   }
	else if(id != 1 && id != 13)
	{
    $.ajax({
       type:"POST",
       url:"<?php echo scs_index ?>Transaction/CompanyModeSettleCreditt",
       success: function (html){
         $("#bank").html(html)
       }
     })
    document.getElementById("caption").style.display = "block";
    document.getElementById("Validcaption").style.display = "block";
    document.getElementById("Bankcaption").style.display = "block";
    document.getElementById("cardnumber").style.display = "block"; 
    document.getElementById("bank").style.display = "block"; 
    document.getElementById("errbank").style.display = "block"; 
    document.getElementById("errvalidate").style.display = "block"; 
    document.getElementById("errcardnumber").style.display = "block"; 
    document.getElementById("validate").style.display = "block"; 
  	}
  }
 function fetchdepdate(Resid)
 {
	$.ajax({
		     url:"<?php echo scs_index ?>Transaction/GetCancelReservationGuestDetails?Resid="+Resid,
         	 type: "POST",
			 dataType: "json",
			 success:function(response){
						
				// $('#depdate').val(result.depdate);
				 var len = response.length;		 
					 // Read values				
				 var Name = response[0].Name;								 
         var Paid =parseFloat(response[0].Amount).toFixed(2);         
         //var Roomgrcid = response[0].Roomgrcid;
					 $('#Guest').val(Name);
           $('#Paid').val(Paid);       
					
			 }
			});
 }
 </script>

 
<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>