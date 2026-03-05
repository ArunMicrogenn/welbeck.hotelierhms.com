<style>
</style>
<?php
   $sql="select Firstname,* from trans_reserve_mas res
	inner join Trans_reserve_det det on res.Resid=det.resid
	Inner join Mas_Room rm on rm.Room_Id=res.Roomid
	Inner join Mas_Customer ms on ms.Customer_Id=res.cusid
	Inner join Mas_City ci on ci.Cityid=ms.Cityid
	Inner join Mas_Title ti on ti.Titleid=ms.Titelid
	where res.Resid='".$_REQUEST['Room_id']."'";
 $Resid=$_REQUEST['Room_id'];
 $res=$this->db->query($sql);
 foreach ($res->result_array() as $row)
 {   $cusid=$row['Customer_Id'];
	 $Room_Id = $row['Room_Id'];
	 $Roomno=$row['RoomNo'];  $ResNo=$row['ResNo'];
	 $gname=$row['Firstname'];
	 $Title=$row['Title'];  $RoomType_Id=$row['RoomType_Id'];
  }
  $Res=$this->Myclass->Get_ResaddNo();
  foreach($Res as $row)
  {
  	$AvanceNo=$row['number'];
  }

   $sqls="select sum(amount) as Amount from Trans_Advancereceipt_mas rm  where roomgrcid='".$Resid."'";
   $ress=$this->db->query($sqls);
	foreach ($ress->result_array() as $rows)
	{ $paidamt=$rows['Amount'];  }
 if($paidamt=='' || $paidamt==0)
 {$paidamt ="0.00";}
  ?>
  
  <legend style="font-size:13px" ><strong></strong></legend>	
  <form id="Advanceentry">
  <table class="FrmTable" style="width:100%">
   <tr>
    <td>Reserve No</td><td> <input type='text' style="background-color:#FFF59B;" Readonly class="m-ctrl" name="Reservationnum" id="Reservationnum" value="<?php echo $ResNo; ?>"></td>
    <td>Receipt No</td><td><input type="text" style="background-color:#FFF59B;" readonly class="m-ctrl" value="<?php echo $AvanceNo; ?>"></td>
   </tr>
   <tr>
    <td>Guest Name</td><td><input type="text" style="background-color:#FFF59B;" class="m-ctrl" value="<?php echo  $Title.".".$gname; ?>" readonly ></td>
	<td>Date</td><td><input type="text" style="background-color:#FFF59B;" class="m-ctrl" value=<?php echo date("d/m/Y-H:i"); ?> readonly ></td>
   </tr>
   <tr>
    <td>Advance Amount</td><td><input required type="text" name="givenadvance" id="givenadvance" class="m-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
	<td>Already Paid</td><td><input type="text" readonly style="background-color:#FFF59B;" class="m-ctrl" value="<?php echo $paidamt; ?>"></td>
   </tr>
   <tr>
    <td>Paymode</td>
	<td><select required class="m-ctrl"
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
	<td>Remark</td>
	<td><textarea rows="3" name="advanceremark" id="advanceremark"></textarea></td>
   </tr>   	
	</table> 
	 <table class="FrmTable" style="width:100%;display:none;" id="caption">
    <td>Bank Details</td>
	<td><input type="text" class="m-ctrl" placeholder="Card Number" name="cardnumber" id="cardnumber" ></td>
	<td><select name="bank" class="m-ctrl" id="bank"><option value="">--Bank--</option>
		<?php 
		$Res=$this->Myclass->Bank();
		foreach($Res as $row) 
		{
		   echo '<option value="'.$row['Bankid'].'"	 >'.$row['bank'].'</option>';
			
		}
		?>
		</select>
	</td>
	<td><input type="date" class="m-ctrl" id="validate" name="validate"></td>   
   </table>
    <center> 
	 <input type="submit" value="Save" class="btn btn-warning btn-sm">
		  </center>   
  <input type="hidden" value="<?php echo $RoomType_Id; ?>" name="RoomType_Id" id="RoomType_Id">
  <input type="hidden" value="<?php echo $_REQUEST['Room_id']; ?>" name="resid" id="resid">
  <input type="hidden" value="<?php echo $Roomno; ?>" name="Roomno" id="Roomno">
  <input type="hidden" value="<?php echo $cusid; ?>" name="cusid" id="cusid">
  <input Type="hidden" value="<?php echo $Room_Id; ?>" name="Room_Id" id="Room_Id" >
 </form>
 
 <script>
 var bank=0;
 var card=0;
 var validate=0;
 var payid =0;
 function paymodevalidate(id)
 {  
   payid=id;
   if(id !=1)
   { document.getElementById("caption").style.display = "block";
	 document.getElementById("cardnumber").required = true;
	 document.getElementById("validate").required = true; }
	else
	{
     document.getElementById("bank").required = false;
	 document.getElementById("cardnumber").required = false;
	 document.getElementById("validate").required = false;
     document.getElementById("caption").style.display = "none";
	}
 }

	$("#Advanceentry").on('submit', function (e) {
       e.preventDefault();

          $.ajax({
            type: 'POST',
            url: "<?php echo scs_index ?>Transaction/ReservationAdvanceentrysave",
            data: $('#Advanceentry').serialize(),
            success: function (result) {
			var id=result;
             swal({
				  title: "Reservation Advance Save Successfully..!",
				  text: "Did you Need Print..!",
				  icon: "success",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {
				   window.location.href ="<?php echo scs_index ?>Transaction/ReservationAdvanceReceipt?Receiptid="+id;
				  } else {
					window.location.href ="<?php echo scs_index ?>Transaction/RoomChart";
				  }
				});
			  
			   }			
          });
          		   
        });
 </script>