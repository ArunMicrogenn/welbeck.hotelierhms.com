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
$this->pweb->Cheader('Transaction','Post Bill');
$this->pfrm->FrmHead1('Transaction / Post Bill',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

$Res=$this->Myclass->Get_Credit_Entry_No();
foreach($Res as $row)
{ $Creditno=$row['number'];
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
    <input type="hidden" name="idv" value="<?php echo @$Credid; ?>" >
    <input type="hidden" name="Roomgrcid" id="Roomgrcid">
      <table class="FrmTable T-8" >
        <tr>
            <td align="right" class="F_val">Room Number</td>
            <td align="left">
            <input type="hidden" name="roomid" id="roomid1">
            <select onchange="fetchdepdate(this.value);" id="roomid" name="roomid" class="scs-ctrl scs-ctrl-select">
              <option value="">---Select Room---</option>
                  <?php $sql="select * from Room_Status rs
                Inner Join Mas_Room rm on rm.Room_Id=rs.Roomid
                where Status='Y' and isnull(billsettle,0)=0 ";
                $res=$this->db->query($sql);
                foreach ($res->result_array() as $row)
                {
                        echo '<option value="'.$row['Room_Id'].'">'.$row['RoomNo'].'</option>';
                    }?>
            </select>
            <div class="roomid"></div>
          </td>
          <td align="right" class="F_val">Receipt.No</td>
          <td align="left" class="F_val"><input type="Text" class="scs-ctrl" value="<?php if(@$Credid){ echo $yearprefix.'/'.$CreditNo; }else{ echo $yearPrefix.'/'.$Creditno; }?>" id="ReceiptNo" name="ReceiptNo"/></td>
        </tr>
        <tr> 
            <td align="right" class="F_val">Guest Name</td>
            <td align="left" class="F_val"><input type="Text" class="scs-ctrl" value="<?php echo @$Name; ?>"  id="Guest" name="Guest"/></td>
            <td align="right" class="F_val">Date</td>
            <td align="left" class="F_val"><input type="Text" readonly value="<?php echo date("d-m-Y") ?>" class="scs-ctrl rmm" id="Date" name="Date"/></td>
        </tr>
        <tr>         
            <td align="right" class="F_val">Revenue Head</td>
          <td align="left">
            <input type="hidden" name="RevenueHead" id="RevenueHead1">
            <select required class="scs-ctrl scs-ctrl-select"  name="RevenueHead" id="RevenueHead" ><option value="">--Revenue Head--</option>
                  <?php 
                 $sql="select * from Mas_revenue where Isnull(IsAllowance,0)=0 and Isnull(ApplicableForPostBill,0)=1 and RevenueHead not in ('Advance','Discount','ROOM RENT','CGST','SGST')";
                 $res=$this->db->query($sql);
                 foreach ($res->result_array() as $row)                 
                  {
                      echo '<option value="'.$row['Revenue_Id'].'">'.$row['RevenueHead'].'</option>';
                    
                  }
                  ?>
                  </select>
            <div class="RevenueHead" ></div></td>
            <td align="right" class="F_val">Post Amount</td>
            <td align="left" class="F_val"><input type="Text" value="<?php echo @$Amount; ?>" class="scs-ctrl rmm" num=1 id="Amount" name="Amount"/>
            <div class="Amount"></div></td>
        </tr>
        <tr>           
            <td align="right" class="F_val">Remark</td>
            <td align="left"><input required type="text" placeholder="Remark" id="Remark" value="<?php echo @$remarks; ?>" name="Remark" value="" class="scs-ctrl" />
              <div class="Remark" ></div></td>
        </tr>     
              
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
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
    $('#roomid').val(<?php echo @$Room_Id; ?>);   
    $('#roomid1').val(<?php echo @$Room_Id; ?>);   
    $('#RevenueHead').val(<?php echo @$Creditheadid; ?>);      
    $('#RevenueHead1').val(<?php echo @$Creditheadid; ?>);      
  });

 function fetchdepdate(Roomid)
 {
	$.ajax({
		     url:"<?php echo scs_index ?>Transaction/GetAdvanceGuestDetails?Roomid="+Roomid,
         	 type: "POST",
			 dataType: "json",
			 success:function(response){

        console.log(response);
						
				// $('#depdate').val(result.depdate);
				 var len = response.length;		 
					 // Read values				
				 var Name = response[0].Name;								 
         var Paid = response[0].Amount;         
         var Roomgrcid = response[0].Roomgrcid;
					 $('#Guest').val(Name);           
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
