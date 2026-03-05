<?Php
  $date=date("Y-m-d");
  $time= date("H:i:s");
  $Resid=$_REQUEST['Room_id'];
  $Res=$this->Myclass->Get_Resclno();
  foreach($Res as $row)
  { $Checkoutno=$row['number'];
  } 
  $Res=$this->Myclass->Get_NightAuditdate();
  foreach($Res as $row)
  { $DateofAudit=$row['DateofAudit'];
  }
 
 $sqls="select sum(amount) as Amount from Trans_Advancereceipt_mas rm  where roomgrcid=".$Resid;
 $ress=$this->db->query($sqls);
 $Amount = $ress->row();

 $sql="select Firstname,* from trans_reserve_mas res
	inner join Trans_reserve_det det on res.Resid=det.resid
	Inner join Mas_Room rm on rm.Room_Id=res.Roomid
	Inner join Mas_Customer ms on ms.Customer_Id=res.cusid
	Inner join Mas_City ci on ci.Cityid=ms.Cityid
	Inner join Mas_Title ti on ti.Titleid=ms.Titelid
	where res.Resid=".$Resid;
 $res=$this->db->query($sql);
 $row = $res->row();
 $cusid=$row->Customer_Id;
 $Roomno=$row->RoomNo;
 $city=$row->City;
 $ResNo=$row->ResNo;
 $gname=$row->Firstname;
 $Address1=$row->HomeAddress1;
 $Address2=$row->HomeAddress2;
 $Title=$row->Title;
 $Roomid=$row->Roomid;  
 
//	$date1=date_create($checkindate);
//	$date2=date_create($DateofAudit);
	//$diff=date_diff($date1,$date2);
//	$noofdays=$diff->format("%a");
	
?>

  <form id="reservecancelsave">
  <table class="FrmTable" style="width:100%">
   <tr>
	<td>Res No</td>
	<td><input type='text' style="background-color:#FFF59B;" Readonly class="m-ctrl" value="<?php echo $ResNo; ?>"></td>
	<td>Cancel No </td>
	<td><input type="text" class="m-ctrl" value="<?php echo $Checkoutno; ?>" readonly style="background-color:#FFF59B;"></td>
   </tr>
   <tr>
    <td>Guest Name</td>
	<td><input type="text" readonly class="m-ctrl" value="<?php echo  $Title.".".$gname; ?>" style="background-color:#FFF59B;"></td>
	<td>Date & Time</td>
	<td><input type="text" readonly class='m-ctrl' value="<?php echo date("d/m/Y-H:i") ?>" style="background-color:#FFF59B;"></td>
   </tr>
   <tr>
    <td>Address</td>
	<td><input type="text" readonly class='m-ctrl' value="<?php echo $Address1 ?>" style="background-color:#FFF59B;"></td>
	<td>Travel Agent</td>
	<td><input type="text" readonly class="m-ctrl" style="background-color:#FFF59B;"></td>
   </tr>
   <tr>
    <td>Address2</td>
	<td><input type="text" readonly class="m-ctrl" value="<?php echo $Address2 ?>" style="background-color:#FFF59B;"></td>
	<td>Booking No</td>
	<td><input type="text" readonly class="m-ctrl" value="" style="background-color:#FFF59B;"></td>
   </tr>
   <tr>
    <td>City</td>
	<td><input type="text" readonly class="m-ctrl" value="<?php echo $city ?>" style="background-color:#FFF59B;"></td>
	
	<td>Company</td>
	<td><input type="text" readonly class="m-ctrl" style="background-color:#FFF59B;"></td>
   </tr>
   <tr>
    <td>Remarks</td>
	<td><textarea Type="text" required name="remark" id="remark" rows="4" cols="24" style="background-color:#FFF59B;"></textarea></td>
	<td></td>
	<td><input type="submit" value="Save" class="btn btn-warning btn-sm"></td>
   </tr>
  </table>

     <input type="hidden" value="<?php echo $Roomid ?>" name="Room_id" value="Room_id">
	 <input type="hidden" name="resid" id="resid"  value="<?php echo  $row->Resid; ?>" >
  </form>  

 <script>
 var bank=0;
 var card=0;
 var validate=0;
 var payid =0;

	$("#reservecancelsave").on('submit', function (e) {
       e.preventDefault();

          $.ajax({
            type: 'get',
            url: "<?php echo scs_index ?>Transaction/reservecancelsave?Roomid=<?php echo $Resid; ?>",
            data: $('#reservecancelsave').serialize(),
            success: function (result) {				 
				swal("Success...!", "Reservation Save Successfully...!", "success")
					.then(function() {
    					window.location.href ="<?php echo scs_index ?>Transaction/RoomChart";
					});
			    }			
          });
          		   
        });
 </script>