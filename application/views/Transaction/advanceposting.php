<style>
</style>
<?php
$this->pweb->timezone();
  $sql=" Select * from Mas_Room Rm
 Inner join room_status rs on Rm.Room_Id=rs.Roomid
 Inner join trans_roomcustomer_Det rd on rd.grcid=rs.grcid
 Inner join Mas_Customer cus on cus.Customer_Id=rd.Customerid
 Inner join Mas_Title mt on mt.Titleid=cus.Titelid
 where Rm.Room_Id='".$_REQUEST['Room_id']."'";
 $Roomid=$_REQUEST['Room_id'];
 $res=$this->db->query($sql);
 foreach ($res->result_array() as $row)
 {   $cusid=$row['Customerid'];
	 $Roomno=$row['RoomNo']; 
	 $gname=$row['Firstname'];
	 $Title=$row['Title'];
	 $grcid=$row['grcid']; $roomgrcid=$row['roomgrcid'];}
 $Res=$this->Myclass->Get_Advancereceiptno();
 foreach($Res as $row)
  { $id=$row['number'];
  }
   $sqls="select sum(rm.amount) as Amount from Trans_Advancereceipt_mas rm 
   inner join Trans_Receipt_mas rmas on rmas.receiptid=rm.receiptid where isnull(rmas.cancel,0)=0 and rm.roomgrcid='".$roomgrcid."'";
 $ress=$this->db->query($sqls);
 foreach ($ress->result_array() as $rows)
 { $paidamt=$rows['Amount'];  }
 if($paidamt=='' || $paidamt==0)
 {$paidamt ="0.00";}

 $year = "select dbo.YearPrefix() as id";
 $res = $this->db->query($year);
 foreach($res->result_array() as $r){
   $yearPrefix= $r['id'];
 }
  ?>
  
  <legend style="font-size:13px" ><strong></strong></legend>	
  <form id="Advanceentry">
  <table class="FrmTable" style="width:100%">
   <tr>
    <td>Room No</td><td> <input type='text' style="background-color:#FFF59B;" Readonly class="m-ctrl" value="<?php echo $Roomno; ?>"></td>
    <td>Receipt No</td><td><input type="text" style="background-color:#FFF59B;" readonly class="m-ctrl" value="<?php echo $yearPrefix.'/'.$id; ?>"></td>
   </tr>
   <tr>
    <td>Guest Name</td><td><input type="text" style="background-color:#FFF59B;" class="m-ctrl" value="<?php echo  $Title.".".$gname; ?>" readonly ></td>
	<td>Date</td><td><input type="text" style="background-color:#FFF59B;" class="m-ctrl" value=<?php echo date("d/m/Y-H:i"); ?> readonly ></td>
   </tr>
   <tr>
    <td>Advance Amount</td>
	<td><input required type="text" name="givenadvance" id="givenadvance" class="m-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
	<td>Already Paid</td>
	<td><input type="text" readonly style="background-color:#FFF59B;" class="m-ctrl" value="<?php echo $paidamt; ?>"></td>
   </tr>
   <tr>
    <td>Paymode</td>
	<td><select required class="m-ctrl"
	onchange="paymodevalidate(this.value)" name="paymode" id="paymode" ><option value="">--Paymode--</option>
	<?php 
	$Res=$this->Myclass->PayMode();
	$exclude = ['COMPANY', 'TOROOM','CASH ON DELIVERY'];

foreach ($Res as $row) {
    if ($row['InActive'] == 0 && !in_array(trim($row['PayMode']), $exclude)) {
        echo '<option value="'.$row['PayMode'].'">'.$row['PayMode'].'</option>';
    }
}
	?>
	</select></td>
	<td>Remark</td>	
	<td><input type="text" name="advanceremark" id="advanceremark"  class="m-ctrl" ></td>
   </tr>   	
	<tr>
		<td><div style="display:none" id="Cardcaption">Card Number</div></td>
		<td><input type="text" style="display:none" class="m-ctrl" placeholder="Card Number" name="cardnumber" id="cardnumber" ></td>
		<td><div style="display:none" id="bankcaption">Bank</div></td>
		<td id="bankoption"><select style="display:none" name="bank" class="m-ctrl" id="bank"><option value="">--Bank--</option>
			<?php 
			$Res=$this->Myclass->Bank();
			foreach($Res as $row) 
			{
			echo '<option value="'.$row['Bankid'].'"	 >'.$row['bank'].'</option>';
				
			}
			?>
			</select>
		</td>			
	</tr> 
	<tr>
		<td><div style="display:none" id="validatecaption">Valid Date</div></td>
		<td><input style="display:none" type="date"  min="<?php echo date('Y-m-d'); ?>" class="m-ctrl" id="validate" name="validate"></td>  
	</tr>
   </table>
    <center> 
	 <input type="submit" value="Save" id="chkbtn" class="btn btn-warning btn-sm">
	 	 <img id="loaderimg" src="../../assets/formloader.gif" width="20px" style="display:none;"/>
	</center>   
  <input type="hidden" value="<?php echo $grcid; ?>" name="grcid" id="grcid">
  <input type="hidden" value="<?php echo $roomgrcid; ?>" name="roomgrcid" id="roomgrcid">
  <input type="hidden" value="<?php echo $Roomno; ?>" name="Roomno" id="Roomno">
  <input type="hidden" value="<?php echo $cusid; ?>" name="cusid" id="cusid">
 </form>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script>
 var bank=0;
 var card=0;
 var validate=0;
 var payid =0;
 function paymodevalidate(id)
 {  
	
   payid=id;

   if(id=="UPI"){
 
    $.ajax({
		type:"POST",
		url:"<?php echo scs_index ?>Transaction/UpiOption",
		data:"id"+id,
		success: function (html){
			$("#bank").html(html)
		}
   	})
	   document.getElementById("bank").required = true;
	 document.getElementById("cardnumber").required = false;
	 document.getElementById("validate").required = false;
	 document.getElementById("Cardcaption").style.display = "none";
	 document.getElementById("cardnumber").style.display = "none";
	 document.getElementById("bankcaption").style.display = "none";
	 document.getElementById("bank").style.display = "block";
	 document.getElementById("validate").style.display = "none";
	 document.getElementById("validatecaption").style.display = "none";
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
	document.getElementById("Cardcaption").style.display = "block";
	 document.getElementById("cardnumber").style.display = "block";
	 document.getElementById("bankcaption").style.display = "block";
	 document.getElementById("bank").style.display = "block";
	 document.getElementById("validate").style.display = "block";
	 document.getElementById("validatecaption").style.display = "block";
     document.getElementById("bank").required = true;
	 document.getElementById("cardnumber").required = true;
	 document.getElementById("validate").required = true; }
	else
	{
     document.getElementById("bank").required = false;
	 document.getElementById("cardnumber").required = false;
	 document.getElementById("validate").required = false;
	 document.getElementById("Cardcaption").style.display = "none";
	 document.getElementById("cardnumber").style.display = "none";
	 document.getElementById("bankcaption").style.display = "none";
	 document.getElementById("bank").style.display = "none";
	 document.getElementById("validate").style.display = "none";
	 document.getElementById("validatecaption").style.display = "none";
	}
 }

	$("#Advanceentry").on('submit', function (e) {
       e.preventDefault();
	   document.getElementById("chkbtn").disabled=true;
        document.getElementById("loaderimg").style.display="inline";
          $.ajax({
            type: 'get',
           url: "<?php echo scs_index; ?>Transaction/Advanceentrysave?Roomid=<?php echo $Roomid; ?>",
            data: $('#Advanceentry').serialize(),
            success: function (result) {
			var id=result;
              swal({
				  title: "Advance Save Successfully..!",
				  text: "Did you Need Print..!",
				  icon: "success",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {
				   window.location.href ="<?php echo scs_index ?>Transaction/AdvanceReceipt?Receiptid="+id;
				  } else {
					location.reload();	
				  }
				});
			  
			   }			
          });
          		   
        });
 </script>