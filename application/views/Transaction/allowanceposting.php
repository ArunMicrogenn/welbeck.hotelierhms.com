<style>
</style>
<?php
  $sql=" Select * from Mas_Room Rm
 Inner join room_status rs on Rm.Room_Id=rs.Roomid
 Inner join trans_roomcustomer_Det rd on rd.grcid=rs.grcid
 Inner join Mas_Customer cus on cus.Customer_Id=rd.Customerid
 Inner join Mas_Title mt on mt.Titleid=cus.Titelid
 where Rm.Room_Id='".$_REQUEST['Room_id']."'";
 $res=$this->db->query($sql);
 $Roomid=$_REQUEST['Room_id'];
 foreach ($res->result_array() as $row)
 {
	 $Roomno=$row['RoomNo']; 
	 $gname=$row['Firstname'];
	 $Title=$row['Title'];
	 $grcid=$row['grcid']; $roomgrcid=$row['roomgrcid'];
 }
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
	<legend style="font-size:13px" ><strong></strong></legend>	
  <form id="Postbillsave">
  <table class="FrmTable" style="width:100%">
   <tr>
    <td>Room No:</td><td> <input type='text' class="m-ctrl" style="background-color:#FFF59B;" Readonly value="<?php echo $Roomno; ?>"></td>
    <td>Receipt No:</td><td><input type="text" class="m-ctrl" style="background-color:#FFF59B;" readonly value="<?php echo $yearPrefix.'/'.$Creditno; ?>"></td>
   </tr>
   <tr>
    <td>Guest Name:</td><td><input type="text" class="m-ctrl" style="background-color:#FFF59B;" value="<?php echo  $Title.".".$gname; ?>" readonly ></td>
	<td>Date:</td><td><input type="text" class="m-ctrl" style="background-color:#FFF59B;" value=<?php echo date("d/m/Y-H:i"); ?> readonly ></td>
   </tr>
   <tr>
	<td>Revenue Head</td>
	<td> <select class="m-ctrl" required name="Revenue_Id" id="Revenue_Id"><option value="">---Select---</option>
		 <?php 
		 $sql="select * from Mas_revenue where Isnull(IsAllowance,0)=1 and RevenueHead not in ('ROOM RENT','CGST','SGST')";
		 $res=$this->db->query($sql);
		 foreach ($res->result_array() as $row)
		 {
		 echo '<option value="'.$row['Revenue_Id'].'"	 >'.$row['RevenueHead'].'</option>';
		 }
         ?>
		</select>
	</td>
    <td>Post Amount:</td><td><input name="Postamt" required id="Postamt" class="m-ctrl" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
	</tr>
   <tr>
	<td>Remark:</td>
	<td><textarea id="remark" name="remark"></textarea></td>
	<td></td>
	<td></td>
   </tr>
   <tr>
    <td></td><td></td>
	<td></td><td><input type="submit" value="Save" id="chkbtn" class="btn btn-warning btn-sm">
	<img id="loaderimg" src="../../assets/formloader.gif" width="20px" style="display:none;"/>
</td>
   </tr>
  </table>
   <input type="hidden" value=<?php echo $Roomid;?> id="Roomid" name="Roomid">
   <input type="hidden" value=<?php echo $grcid;?> id="grcid" name="grcid">
   <input type="hidden" value=<?php echo $roomgrcid;?> id="roomgrcid" name="roomgrcid">
 </form> 
 <script>

	$("#Postbillsave").on('submit', function (e) {
       e.preventDefault();
	   	   document.getElementById("chkbtn").disabled=true;
           document.getElementById("loaderimg").style.display="inline";
          $.ajax({
            type: 'get',
            url: "<?php echo scs_index ?>Transaction/Postbillsave?Roomid=<?php echo $Roomid; ?>",
            data: $('#Postbillsave').serialize(),
            success: function (result) {
			  var id=result;
              swal({
				  title: "Bill Posting Save Successfully..!",
				  text: "Did you Need Print..!",
				  icon: "success",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {
				    window.location.href ="<?php echo scs_index ?>Transaction/BillEntryReceipt?Receiptid="+id;
				  } else {
					location.reload();	
				  }
				});
			   }			
          });
          		   
        });
 </script>