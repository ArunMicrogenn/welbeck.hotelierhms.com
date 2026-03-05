<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->nightaudit();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Reservation Advance');
$this->pfrm->FrmHead11('Transaction / Reservation Advance',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

$Res=$this->Myclass->Get_ResaddNo();
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
    <form id="reserveAdvance" method="POST" action="ReservationAdvances_save">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$resaddid; ?>" >
      <table class="FrmTable T-8" >
        <tr>
            <td align="right" class="F_val">Reservation No</td>
            <td align="left" class="F_val">
            <input type="hidden" name="roomid" id="roomid1">
            <input type="hidden" name="resvalue" value="<?php echo $BUT;?>" />
            <select onchange="fetchdepdate(this.value);" id="roomid" name="roomid1" class="scs-ctrl scs-ctrl-select">
              <option value="">---Select Res.No---</option>
                  <?php $sql="select mas.ResNo, mas.Resid from Trans_Reserve_mas mas
                          Inner Join Trans_Reserve_Det det on det.resid=mas.Resid
                          where isnull(det.Noshows,0) =0 and isnull(mas.stat,'')=''
                          group by mas.ResNo, mas.Resid";
                      $res=$this->db->query($sql);
                      foreach ($res->result_array() as $row)
                      {
                        echo '<option value="'.$row['Resid'].'">'.$row['ResNo'].'</option>';
                      }?>
            </select>
            <div class="roomid"></div>
          </td>
          <td align="right" class="F_val">Receipt.No</td>
          <td align="left" class="F_val"><input type="Text" readonly  class="scs-ctrl" value="<?php if(@$resaddid){ echo $yearprefix.'/'.$resadno; }else{ echo $yearPrefix.'/'.$id; }?>"  id="ReceiptNo" name="ReceiptNo"/></td>
        </tr>
        <tr>
            <td align="right" class="F_val">Guest Name</td>
            <td align="left" class="F_val"><input type="Text" class="scs-ctrl" value="<?php echo @$Name; ?>"  id="Guest" name="Guest"/></td>
            <td align="right" class="F_val">Date</td>
            <td align="left" class="F_val"><input type="Text" readonly value="<?php echo date("d-m-Y") ?>" class="scs-ctrl rmm" id="Date" name="Date"/></td>
        </tr>
        <tr>
            <td align="right" class="F_val">Advance Amount</td>
            <td align="left" class="F_val"><input type="Text" value="<?php echo @$Amount; ?>" class="scs-ctrl rmm" num=1 id="Amount" name="Amount"/>
            <div class="Amount"></div></td>
            <td align="right" class="F_val"><?php if(@!$resaddid) {?>Already Paid<?php } ?></td>
            <td align="left" class="F_val"><?php if(@!$resaddid) {?><input type="Text" readonly class="scs-ctrl rmm" num=1 id="Paid" name="Paid"/><?php } ?></td>
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
                    // && $row['PayMode'] =='CASH'
                    if($row['InActive'] ==0  && $row['PayMode'] !='COMPANY' && $row['PayMode'] !='TOROOM')
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
        <tr>
            <td align="right" class="F_val"><div id="caption" style="display:none">Card Number</div></td>
            <td><input type="text" style="display:none" class="scs-ctrl" value="<?php echo @$chno; ?>"   oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Card Number" name="cardnumber" id="cardnumber" > <div style="display:none" id="errcardnumber" class="cardnumber"></div></td>
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
        <td><input type="date" style="display:none" class="scs-ctrl" min="<?php echo date('Y-m-d') ?>"  value="<?php if(@$validdate){echo date('Y-m-d',strtotime(@$validdate));} ?>" id="validate" name="validate"><div style="display:none" id="errvalidate" class="validate"></div></td>   
        <tr>
        <tr>
          
          <td align="right" class="F_val" ><div id="typecaption" style="display:none"></div>Type</td>
          <td>
              <select name="typeid" class="scs-ctrl scs-ctrl-select" id="roomtypee" onchange="validateadvance(this.value)">
                <option value="">--Room Type--</option>
              </select>
            </td> 
            <td align="right">&nbsp;</td>
          <td align="left"><input type="button" class="btn btn-success btn-sm" id="btnsave" name="btnsave" value="<?php echo $BUT;?>"   /></td>
        </tr>
      </table>
    </fieldset>
    </form>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php
// $this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script> 
 
 $(document).ready(function(e) {    
    $('#roomid').val(<?php echo @$resid; ?>);   
    $('#roomid1').val(<?php echo @$resid; ?>);   
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
 function paymodevalidate(id)
 {  
   payid=id;

    if(id =="CASH")
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
    

   }else if( id == "UPI"){

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
	else if(id =="CREDIT CARD" || id == "CHEQUE" || id == 'NET TRANSFER')
	{
    $.ajax({
       type:"POST",
       url:"<?php echo scs_index ?>Transaction/Otheroption",
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
    document.getElementById("cardnumber").disabled = false;
  	}
    	else if(id == "TOROOM"){
      
		$.ajax({
			type:"POST",
			url :"<?php echo scs_index ?>Transaction/toroomSettle",
			success: function (html){
               $("#bank").html(html)
          }
		})
		document.getElementById("cardnumber").value='';
		document.getElementById("cardnumber").disabled = true
        document.getElementById("validate").disabled = true 
		 document.getElementById("bank").style.display = "block"; 

	}

  
 }
 function fetchdepdate(Resid)
 {
	$.ajax({
		     url:"<?php echo scs_index ?>Transaction/GetReservationGuestDetails?Resid="+Resid,
         	 type: "POST",
			 dataType: "json",
			 success:function(response){
						
				// $('#depdate').val(result.depdate);
				 var len = response.length;		 
					 // Read values				
				 var Name = response[0].Name;								 
         var Paid = response[0].Amount;         
         //var Roomgrcid = response[0].Roomgrcid;
					 $('#Guest').val(Name);
           $('#Paid').val(Paid);       
					
			 }
			});


      $.ajax({
		     url:"<?php echo scs_index ?>Transaction/GetReservationGuestDetailsTypeid?Resid="+Resid,
         	 type: "POST",
			     success:function(html){
					 $('#roomtypee').html(html)   
					
			 }
			});

 }

 function validateadvance(a){
  const resid = document.getElementById("roomid").value
  $.ajax({
		     url:"<?php echo scs_index ?>Transaction/GetReservationGuestDetailsAdvance?Resid="+resid+"&type="+a,
         	 type: "POST",
			     success:function(amount){
					 $('#Paid').val(amount)  
					
			 }
			});
 }

 const btn = document.getElementById("btnsave");
 const bank = document.getElementById("bank")
 const card = document.getElementById("cardnumber")
 const validate = document.getElementById("validate")
 const roomid = document.getElementById("roomid")
 const paymode = document.getElementById("paymode")
 const roomtype = document.getElementById("roomtypee")
 btn.addEventListener("click", () => {
  if(roomid.value ==''){
    alert("select Res.No")
    return
  }

  if(paymode.value == ''){
    alert("select paymode")
    return
  }

  if(paymode.value =="UPI" ){
    if(bank.value == ''){
      alert("select bank")
      return
    }
  }

  if(roomtype.value == ''){
      alert("select Roomtype")
      return
    }

  if(paymode.value !="CASH" && paymode.value != "UPI" ){

    if(bank.value == ''){
      alert("select bank")
      return
    }
    if(card.value == ''){
      alert("enter card number")
      return
    }
    if(validate.value == ''){
      alert("select date")
      return
    }
    if(roomtype.value == ''){
      alert("select Roomtype")
      return
    }

  }
  $.ajax({
    type:"post",
    url:"<?php echo scs_index?>/Transaction/ReservationAdvances_save",
    data: $('#reserveAdvance').serialize(),
    success: function(result){
      if(result !='failure')		
      {
        var idd= result
        // alert(idd)
				 swal({ 
				  title: "Reservation Advance Saved Successfully..!",
				  text: "Did you Need Print..!",
				  icon: "success",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {
				   window.location.href ="<?php echo scs_index ?>Transaction/ReservationAdvanceReceipt?Receiptid="+idd;
				  } else {
					location.reload();
				  }
				}); 
      }
      else
      {
        swal("Failed...!", "Advance Save Faild...!", "error")
        .then(function() {
          window.location.href="<?php echo scs_index?>Transaction/ReservationAdvances";
        });
      }
    }

  })

 })

 $(document).ready(function(e) {  
 const resid = document.getElementById("roomid").value
  // alert(resid)
    $.ajax({
		     url:"<?php echo scs_index ?>Transaction/GetReservationGuestDetailsTypeid?Resid="+resid,
         	 type: "POST",
			     success:function(html){
					 $('#roomtypee').html(html)   
					
			 }
			});
    })
 </script>

<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>


 
