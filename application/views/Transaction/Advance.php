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
$this->pweb->Cheader('Transaction','Advance');
$this->pfrm->FrmHead1('Transaction / Advance',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

$Res=$this->Myclass->Get_Advancereceiptno();
foreach($Res as $row)
 { $id=$row['number'];
 }
 $year = "select dbo.YearPrefix() as id";
 $res = $this->db->query($year);
 foreach($res->result_array() as $r){
   $yearPrefix= $r['id'];
 }
?>


<?php if($BUT != 'Delete'){ ?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$Receiptid; ?>" >
    <input type="hidden" name="Roomgrcid" id="Roomgrcid">
      <table class="FrmTable T-8" >
        <tr>
            <td align="right" class="F_val">Room Number</td>
            <td align="left" class="F_val">
            <input type="hidden" id="roomid1" name="roomid" >
            <select onchange="fetchdepdate(this.value);" id="roomid" name="roomid" class="scs-ctrl scs-ctrl-select">
              <option value="">---Select Room---</option>
                  <?php  $sql="select * from Room_Status rs
                Inner Join Mas_Room rm on rm.Room_Id=rs.Roomid
                where isnull(Status,'') ='Y' and isnull(billsettle,0)=0";
                $res=$this->db->query($sql);
                foreach ($res->result_array() as $row)
                {
                        echo '<option value="'.$row['Room_Id'].'">'.$row['RoomNo'].'</option>';
                    }?>
            </select>
            <div class="roomid"></div>
          </td>
          <td align="right" class="F_val">Receipt.No </td>
          <td align="left" class="F_val"><input type="Text" class="scs-ctrl" value="<?php if(@$Receiptid){ echo $yearprefix.'/'.$Receiptno; }else{ echo $yearPrefix.'/'.$id; }?>"  id="ReceiptNo" name="ReceiptNo"/></td>
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
            <td align="right" class="F_val"><?php if(@!$Receiptid) {?>Already Paid<?php } ?></td>
            <td align="left" class="F_val"><?php if(@!$Receiptid) {?><input type="Text" class="scs-ctrl rmm" num=1 id="Paid" name="Paid"/><?php } ?></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Paymode</td>
          <td align="left">
            <input type="hidden" id="paymode1" name="paymode1"  >
            <select required class="scs-ctrl scs-ctrl-select"
            onchange="paymodevalidate(this.value)"  name="paymode" id="paymode" ><option value="">--Paymode--</option>
                  <?php 
                  $Res=$this->Myclass->PayMode();
                  foreach($Res as $row) 
                  {
                    if($row['InActive'] ==0 && $row['PayMode'] !='COMPANY ')
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
            <td align="right" class="F_val"><div style="display:none" id="caption" >Card Number</div></td>
            <td><input type="text" style="display:none" class="scs-ctrl" value="<?php echo @$cardnumber; ?>" placeholder="Card Number" name="cardnumber" id="cardnumber" > <div style="display:none"  id="errcardnumber" class="cardnumber"></div></td>
            <td align="right" class="F_val" ><div style="display:none" id="Bankcaption" >Bank</div></td>
            <td>
              <input type="hidden" id="bank1" name="bank" >
              <select name="bank" style="display:none" class="scs-ctrl scs-ctrl-select" id="bank"><option value="">--Bank--</option>
                <?php 
                
                $Res=$this->Myclass->Bank();
                foreach($Res as $row) 
               
                {
                  echo '<option value="'.$row['Bankid'].'"	 >'.$row['bank'].'</option>';
                  
                }              
                ?>

                </select><div id='errbank' style="display:none" class="bank"></div>
            </td>            
        </tr>
        <tr>
        <td align="right" class="F_val"><div style="display:none" id="Validcaption">Valid Date</div></td>
        <td><input type="date" style="display:none" class="scs-ctrl"  min="<?php echo date('Y-m-d'); ?>"  value="<?php if(@$validdate){echo date('Y-m-d',strtotime(@$validdate));} ?>" id="validate" name="validate"><div style="display:none" id="errvalidate" class="validate"></div></td>   
        <tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
        </tr>
      </table>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php } else {  ?>

  <div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$Receiptid; ?>" >
    <input type="hidden" name="Roomgrcid" id="Roomgrcid">
      <table class="FrmTable T-8" >
        <tr>
            <td align="right" class="F_val">Room Number</td>
            <td align="left" class="F_val">
            <input type="hidden" id="roomid1" name="roomid" >
            <select disabled onchange="fetchdepdate(this.value);" id="roomid" name="roomid" class="scs-ctrl scs-ctrl-select" readonly>
              <option value="">---Select Room---</option>
                  <?php  $sql="select * from Room_Status rs
                Inner Join Mas_Room rm on rm.Room_Id=rs.Roomid
                where isnull(Status,'') ='Y' and isnull(billsettle,0)=0";
                $res=$this->db->query($sql);
                foreach ($res->result_array() as $row)
                {
                        echo '<option value="'.$row['Room_Id'].'">'.$row['RoomNo'].'</option>';
                    }?>
            </select>
            <div class="roomid"></div>
          </td>
          <td align="right" class="F_val">Receipt.No </td>
          <td align="left" class="F_val"><input type="Text" class="scs-ctrl" value="<?php if(@$Receiptid){ echo $yearprefix.'/'.$Receiptno; }else{ echo $yearPrefix.'/'.$id; }?>"  id="ReceiptNo" name="ReceiptNo" readonly/></td>
        </tr>
        <tr>
            <td align="right" class="F_val">Guest Name</td>
            <td align="left" class="F_val"><input type="Text"  readonly class="scs-ctrl" value="<?php echo @$Name; ?>"  id="Guest" name="Guest"/></td>
            <td align="right" class="F_val">Date</td>
            <td align="left" class="F_val"><input type="Text" readonly value="<?php echo date("d-m-Y") ?>" class="scs-ctrl rmm" id="Date" name="Date"/></td>
        </tr>
        <tr>
            <td align="right" class="F_val">Advance Amount</td>
            <td align="left" class="F_val"><input type="Text" readonly value="<?php echo @$Amount; ?>" class="scs-ctrl rmm" num=1 id="Amount" name="Amount"/>
            <div class="Amount"></div></td>
            <td align="right" class="F_val"><?php if(@!$Receiptid) {?>Already Paid<?php } ?></td>
            <td align="left" class="F_val"><?php if(@!$Receiptid) {?><input type="Text" class="scs-ctrl rmm" num=1 id="Paid" name="Paid"/><?php } ?></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Paymode</td>
          <td align="left">
            <input type="hidden" id="paymode1" name="paymode1"  >

            <select required class="scs-ctrl scs-ctrl-select" disabled
            onchange="paymodevalidate(this.value)"  name="paymode" id="paymode" ><option value="">--Paymode--</option>
                  <?php 
                  $Res=$this->Myclass->PayMode();
                  foreach($Res as $row) 
                  {
                    if($row['InActive'] ==0 && $row['PayMode'] !='COMPANY ')
                      {
                      echo '<option value="'.$row['PayMode'].'"	readonly >'.$row['PayMode'].'</option>';
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
            <td align="right" class="F_val"><div style="display:none" id="caption" >Card Number</div></td>
            <td><input type="text" style="display:none" class="scs-ctrl" value="<?php echo @$cardnumber; ?>" placeholder="Card Number" name="cardnumber" id="cardnumber" > <div style="display:none"  id="errcardnumber" class="cardnumber"></div></td>
            <td align="right" class="F_val" ><div style="display:none" id="Bankcaption" >Bank</div></td>
            <td>
              <input type="hidden" id="bank1" name="bank" >
              <select name="bank" style="display:none" class="scs-ctrl scs-ctrl-select" id="bank"><option value="">--Bank--</option>
                <?php 
                
                $Res=$this->Myclass->Bank();
                foreach($Res as $row) 
               
                {
                  echo '<option value="'.$row['Bankid'].'"	 >'.$row['bank'].'</option>';
                  
                }              
                ?>

                </select><div id='errbank' style="display:none" class="bank"></div>
            </td>            
        </tr>
        <tr>
        <td align="right" class="F_val"><div style="display:none" id="Validcaption">Valid Date</div></td>
        <td><input type="date" style="display:none" class="scs-ctrl"  min="<?php echo date('Y-m-d'); ?>"  value="<?php if(@$validdate){echo date('Y-m-d',strtotime(@$validdate));} ?>" id="validate" name="validate"><div style="display:none" id="errvalidate" class="validate"></div></td>   
        <tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
        </tr>
      </table>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
  <?php } ?>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script> 
 
 $(document).ready(function(e) {    
    $('#roomid').val(<?php echo @$Room_Id; ?>);   
    $('#roomid1').val(<?php echo @$Room_Id; ?>); 
    $('#paymode1').val(<?php echo @$paymodeid; ?>);  
    $('#paymode').val(<?php echo @$paymodeid; ?>);  
    $('#bank').val(<?php echo @$bank; ?>);  
    $('#bank1').val(<?php echo @$bank1; ?>);
    // document.getElementById('bank').value = (<?php echo @$bank; ?>);    
    var id=<?php if(@$paymodeid){echo @$paymodeid;}else {echo "1"; } ?>;
    if(id =="CASH" )
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
    

   }else if( id == "COMPANY"){

      //   $.ajax({
      //   type:"POST",
      //   url:"<?php echo scs_index ?>Transaction/UpiOptions",
      //   data:"id"+id,
      //   success: function (html){
      //     // console.log(html)
      //     $("#bank").html(html)
      //   }
      // })
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
	else if(id != "CASH" && id != "COMPANY")
	{
    // $.ajax({
    //    type:"POST",
    //    url:"<?php echo scs_index ?>Transaction/CompanyModeSettleCreditt",
    //    success: function (html){
    //      $("#bank").html(html)
    //    }
    //  })
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

   if(id == "CASH")
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
    

   } else if( id == "UPI"){

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

   else if( id == "TOROOM"){

        $.ajax({
        type:"POST",
        url:"<?php echo scs_index ?>Transaction/toroomSettle",
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
	// else if(id != "CASH" && id != "COMPANY")
	// {
  //   $.ajax({
  //      type:"POST",
  //      url:"<php echo scs_index ?>Transaction/CompanyModeSettleCreditt",
  //      success: function (html){
  //        $("#bank").html(html)
  //      }
  //    })
  //   document.getElementById("caption").style.display = "block";
  //   document.getElementById("Validcaption").style.display = "block";
  //   document.getElementById("Bankcaption").style.display = "block";
  //   document.getElementById("cardnumber").style.display = "block"; 
  //   document.getElementById("bank").style.display = "block"; 
  //   document.getElementById("errbank").style.display = "block"; 
  //   document.getElementById("errvalidate").style.display = "block"; 
  //   document.getElementById("errcardnumber").style.display = "block"; 
  //   document.getElementById("validate").style.display = "block"; 
  // 	}
    else if(id == "CREDIT CARD" || id == "CHEQUE" || id == "NET TRANSFER"){
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
      
    }
 }
 function fetchdepdate(Roomid)
 {
	$.ajax({
		     url:"<?php echo scs_index ?>Transaction/GetAdvanceGuestDetails?Roomid="+Roomid,
         	 type: "POST",
			 dataType: "json",
			 success:function(response){
						
				// $('#depdate').val(result.depdate);
				 var len = response.length;		 
					 // Read values				
				 var Name = response[0].Name;								 
         var Paid = response[0].Amount;         
         var Roomgrcid = response[0].Roomgrcid;
					 $('#Guest').val(Name);
           $('#Paid').val(Paid);
           $('#Roomgrcid').val(Roomgrcid);	
					
			 }
			});
 }
 </script>
<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>
 
