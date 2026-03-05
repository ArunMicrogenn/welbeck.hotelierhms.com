<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
 /* background-color: #f1f1f1;*/
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  border: 1px solid #ccc;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 10px 10px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
<?php
 $sql=" Select * from Mas_Room Rm
 Inner join room_status rs on Rm.Room_Id=rs.Roomid
 inner join Trans_roomdet_det det on det.grcid=rs.grcid
 Inner join trans_roomcustomer_Det rd on rd.grcid=rs.grcid
 Inner join Mas_Customer cus on cus.Customer_Id=rd.Customerid
 Inner join Mas_Title mt on mt.Titleid=cus.Titelid
 Inner join Mas_city ct on ct.Cityid=cus.Cityid
 Inner join Mas_Roomtype rt on rt.RoomType_Id=det.typeid
 Inner join Mas_PlanType pt on pt.PlanType_Id = det.ratetypeid
 left outer join Mas_Nationality na on na.Nationid=cus.Nationality
 where Rm.Room_Id='".$_REQUEST['Room_id']."'";
 $res=$this->db->query($sql);
 $Roomid=$_REQUEST['Room_id'];
 foreach ($res->result_array() as $row)
 {
	 $Roomno=$row['RoomNo']; 
	 $Firstname=$row['Firstname']; $Middlename=$row['Middlename'];
	 $Title=$row['Title']; $Lastname=$row['Lastname']; $email=$row['Email_ID']; $gphone=$row['Phone'];
	 $grcid=$row['grcid']; $roomgrcid=$row['roomgrcid'];  $City=$row['City']; $Nationality=$row['Nationality'];
	  $Mobile=$row['Mobile']; $Noofpersons=$row['Noofpersons'];
	  $Address1=$row['HomeAddress1']; $Address2=$row['HomeAddress2']; $Address3=$row['HomeAddress3'];
	  $workaddress1=$row['WorkAddress1']; $workaddress2=$row['WorkAddress2']; $workaddress3=$row['WorkAddress3'];
	  $discper=$row['discper']; $discAmount=$row['discamount'];$PlanType_Id = $row['PlanType_Id'];
	  $RateCode=$row['RateCode']; $PlanType_Id=$row['PlanType_Id']; 
	  $roomrent=$row['roomrent'];
	  $customer_id = $row['Customer_Id'];
 }

 $rent1="select * from Trans_Roomdet_det_rent Where  grcid='".$grcid."' and Rentdate=(select DateofAudit from Night_Audit)";
 $rentres1=$this->db->query($rent1);
 foreach ($rentres1->result_array() as $rentrow1)
 {
	if ($Noofpersons ==1){
		$Actrackrate= $rentrow1['singlerent'];	
	}else if($Noofpersons==2){
		$Actrackrate= $rentrow1['Doublerent'];		
	}
	else if($Noofpersons==3){
		$Actrackrate= $rentrow1['Triplerent'];		
	}
	else if($Noofpersons >=4)
	{
		if($rentrow1['Quartertriplerent']==0)
		{
			$Actrackrate = $rentrow1['Triple'] + $rentrow1['extraadultcharges'];		
		}
		else
		{
			$Actrackrate = $rentrow1['Quartertriplerent'];				  
		}
	}
 }

  $Res1=$this->Myclass->Get_Credit_Entry_No();
  foreach($Res1 as $row1)
  { $Creditno=$row1['number'];
  }
  ?>
  
<div id="GuestImageModal" class="modal">
	<div class="modal-content" style="width:60%">
		<div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle">
			<span class="ui-dialog-title">Guest Image</span>
			<span id="guestspan" class="close">&times;</span>	
			
		</div>
		<div id="gusetimageslider"></div>
	</div>

	
</div>

  	<form id="tariffsubmit" > 
	<div id="tariff" class="modal">
	<div class="modal-content" style="width:60%">
	   <div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle">
	 	<span class="ui-dialog-title">Checkin Room Rent Details</span>
		   <span id="span1" class="close">&times;</span>		
	   </div>
		
		<table class="FrmTable" >
		 <thead>
		  <tr>
		   <td>S.No</td>
		   <td>Date</td>
		   <td>Single</td>
		   <td>Double</td>
		   <td>Triple</td>
		   <td>Quarter Triple</td>
		   <td>Extra bed</td>
		  </tr>
		 </thead>
		 <tbody>
		 <?php $i=1;
		 $rent="select * from trans_roomdet_det_rent where grcid='".$grcid."' order by Rentdate";
		 $rentres=$this->db->query($rent);
		 foreach ($rentres->result_array() as $rentrow)
		 {  ?>		
		  <tr  style="width:100%">
		   <td  style="width:10%"><?php echo $i; ?></td>
		   <td align="left" style="width:15%"><input type="hidden" name="roomrentid" value="<?php echo $rentrow['roomrentid']; ?>"><?php echo date('d/m/Y', strtotime($rentrow['Rentdate']));?></td>
		   <td style="width:15%"><input <?php if($rentrow['nightauditcompleted']=='1') {echo 'readonly'; } ?> name="<?php echo $rentrow['roomrentid']; ?>single" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['singlerent']; ?>"></td>
		   <td style="width:15%"><input <?php if($rentrow['nightauditcompleted']=='1') {echo 'readonly'; } ?> name="<?php echo $rentrow['roomrentid']; ?>double" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['Doublerent']; ?>"></td>
		   <td style="width:15%"><input <?php if($rentrow['nightauditcompleted']=='1') {echo 'readonly'; } ?> name="<?php echo $rentrow['roomrentid']; ?>triple" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['Triplerent']; ?>"></td>
		   <td style="width:15%"><input <?php if($rentrow['nightauditcompleted']=='1') {echo 'readonly'; } ?> name="<?php echo $rentrow['roomrentid']; ?>quartertriple" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['Quartertriplerent']; ?>"></td>
		   <td style="width:10%"><input <?php if($rentrow['nightauditcompleted']=='1') {echo 'readonly'; } ?> name="<?php echo $rentrow['roomrentid']; ?>extrabed" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['extraadultcharges']; ?>"></td>
		  </tr>		
		 <?php $i++; } ?>
		   <tr>
		    <td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><input type="submit"   class="btn btn-warning btn-sm"></td>		
			<td><a onclick="closetariff()"class="btn btn-warning btn-sm">Cancel</a>			
			
			</td>			
		   </tr>
		 </tbody>
		</table>
	</div>
	</div>
	</form>

  	<div id="cityselect" class="modal">
	 <div class="modal-content" style="width:50%">
	   <div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle">
	 	<span class="ui-dialog-title">City's</span>
		   <span id="span1" onclick="closecity()" class="close">&times;</span>		
	   </div>
		
		<table class="FrmTable" >
		 <thead>
		  <tr>
		   <td>S.No</td>
		   <td>City</td>
		  </tr>
		 </thead>
		 <tbody>
		 <?php $i=1;
		 $gcity="exec Get_City 0";
		 $execity=$this->db->query($gcity);
		 foreach ($execity->result_array() as $cityrow)
		 { ?>
		
		  <tr  style="width:100%">
		   <td  style="width:10%"><?php echo $i; ?></td>
		   <td onclick="selectedcity(<?php echo $cityrow['Cityid']; ?>,'<?php echo $cityrow['City'] ?>')" align="left" style="width:15%"><?php echo $cityrow['City']?></td>
		  </tr>
		
		 <?php $i++; } ?>
		  </tr>
		 </tbody>
		</table>
	</div>
	</div>		
	
<div class="tab">
  <button class="tablinks" id="GuestDetailsopen" onclick="openCity(event, 'GuestDetails')">Guest Details</button>
  <button class="tablinks" onclick="openCity(event, 'Tariffdetails')">Tariff Details </button>
  <button class="tablinks" onclick="openCity(event, 'Otherdetails')">Other Details</button>
</div>

	
<form id="Guestamendmentsave" method="POST" enctype="multipart/form-data">
    <div id="GuestDetails" class="tabcontent">
		 <table class="FrmTable" style="width:100%">
	   <tr>
		<td>Mobile Number</td>
		<td><input name='Mobile' type='text' class="m-ctrl" value="<?php echo $Mobile; ?>"></td>
		<td>E Mail</td>
		<td><input name='email' type='email' class="m-ctrl" value="<?php echo $email; ?>"></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>First Name</td>
		<td><input name='Firstname' type='text' class="m-ctrl"  value="<?php echo $Firstname; ?>"></td>
		<td>City</td>
		<input type="hidden" name="Cityid" id="Cityid" value="<?php echo $row['Cityid']; ?>">
		<td><input name='City' id="City" onclick="cityselect()" type='text' class="m-ctrl" value="<?php echo $City; ?>"></td>
		<td></td>
		<td></td>
		</tr>
	   <tr>
		<td>Middle Name</td>
		<td><input name='Middlename' type='text' class="m-ctrl" Value="<?php echo $Middlename; ?>"></td>
		<td>Nationality</td>
		<input type="hidden" name="Nationid" id="Nationid"/>
		<td><input name='Nationality' id='Nationality'type='text' class="m-ctrl" Value="<?php echo $Nationality; ?>"></td>
		<td></td>
		<td></td>
	   </tr>
	   <tr>
		<td>Last Name</td>
		<td><input name='Lastname' type='text' class="m-ctrl"  value="<?php echo $Lastname; ?>"></td>
		<td>Phone</td>
		<td><input name='Phone' type='text' class="m-ctrl"  value="<?php echo $gphone; ?>"></td>
		<td></td>
		<td></td>
	   </tr>
	   <tr>
		<td>Address1</td>
		<td><input name='address1' type='text' class="m-ctrl"  value="<?php echo $Address1; ?>"></td>
		<td>Work Address1</td>
		<td><input name='workaddress1' type='text' class="m-ctrl"  value="<?php echo $workaddress1; ?>"></td>
		<td></td>
		<td></td>
	   </tr>
	   <tr>
		<td>Address2</td>
		<td><input name='address2' type='text' class="m-ctrl"  value="<?php echo $Address2; ?>"></td>
		<td>Work Address2</td>
		<td><input name='workaddress2' type='text' class="m-ctrl"  value="<?php echo $workaddress2; ?>"></td>
		<td></td>
		<td></td>
	   </tr>
	   <tr>
		<td>Address3</td>
		<td><input name='address3' type='text' class="m-ctrl"  value="<?php echo $Address3; ?>"></td>
		<td>Work Address3</td>
		<td><input name='workaddress3' type='text' class="m-ctrl"  value="<?php echo $workaddress3; ?>"></td>
		<td></td>
		<td></td>
	   </tr>
	   <tr>
		<td>Proof</td>
		<td><button type="button" onclick="viewProof('<?php echo $customer_id;?>');">View</button></td>
		<td>Re-upload</td>
		<td><input type="file" name="fileToUpload[]" multiple="multiple"/>
		<!-- <span style="color:red">*jpeg, *png,*gif</span> -->
	    </td>
		
		<td></td>
		<td></td>
		</tr>
	   <tr>
	   <td></td>
		<td>
	     <!-- <img width="100" height="100" id="proofimage"  style="display:none"/> -->
		</td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
	  
		
	   <tr>
		<td></td><td></td>
		<td></td><td></td>
		<td></td><td><input type="button" onclick="Guestamendment();" value="Save" class="btn btn-warning btn-sm"></td>
	   </tr>
	  </table>
    </div>

<div id="Tariffdetails" class="tabcontent">
  <table class="FrmTable" style="width:100%">
	   <tr>
		<td>Room Type</td>
		<td><input name='RoomType' readonly type='text' class="m-ctrl" value="<?php echo $row['RoomType']; ?>"></td>
		<td>Rate Type</td>
		<td><select  class="m-ctrl" name="ratetypid" id="rattypid">
			<option selected value='<?php echo $PlanType_Id; ?>'><?php echo $RateCode; ?></option>
		<?php
			$qry2="select * from Mas_plantype where PlanType_Id<>".$PlanType_Id;
			$res2=$this->db->query($qry2);
			foreach ($res2->result_array() as $row2)
			{ ?>
			 <option value="<?php echo $row2['PlanType_Id'] ?>"><?php echo $row2['RateCode']?></option>
			<?php 
			}
			?>
		   </select></td>
		<!-- <input type="hidden" name="ratetypeid" id="ratetypeid" value="<?php  //$row['PlanType_Id'] ?>" >
		<td><input readonly name='ratetype' type='text' class="m-ctrl" value="<?php  //$row['RateCode']; ?>"></td> -->
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>Rack Rate</td>
		<td><input name='rackrate' id='rackrate' readonly style="text-align:right" type='text' class="m-ctrl"  value="<?php echo $Actrackrate; ?>"></td>
		<td></td>
		 <td><a class="btn btn-warning btn-sm" id="tarifpop1" >Tariff Edit</a></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>Food Plan</td>
		<td><select  class="m-ctrl" name="foodplanid" id="foodplanid">
		<?php
			$qry2="select * from Mas_FoodPlan";
			$res2=$this->db->query($qry2);
			foreach ($res2->result_array() as $row2)
			{
			 echo '<option value="'.$row2['FoodPlan_Id'].'"	 >'.$row2['FoodPlan'].'</option>';
			}
			?>
		   </select></td>
		   <?php 
	 	$qurys = "select * from usertable where User_id='".User_id."' ";
		$ops = $this->db->query($qurys);
		foreach($ops -> result_array() as $rows){
			$percent = $rows['disper'];
			$disamount = $rows['disAmount'];
		}?>
		<td>Dis Per</td>
		<td><input type="hidden" id="DISP" value="<?php echo $percent;  ?>"><input style="text-align:right" onchange="discper1()" name="discper" id="discper" value="<?php echo @$discper ?>" placeholder="Disc.Per"  class="m-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" ></td>
		<td>Dis Amt</td>
		<td><input type="hidden" id="DISA" value="<?php echo $disamount;  ?>"><input style="text-align:right" onchange="discamt1()" name="discamt" id="discamt" value="<?php echo @$discAmount ?>" placeholder="Disc.Amt"  class="m-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" ></td>
		</tr>
		  <tr>
		<td></td><td></td>
		<td></td><td></td>
		<td></td><td><input type="submit" value="Save" class="btn btn-warning btn-sm"></td>
	   </tr>
	</table> 
</div>

<div id="Otherdetails" class="tabcontent">
   <table class="FrmTable" style="width:100%">
	   <tr>
		<td>Male</td>
		 <td><select onchange='Adults1()' name="male" id="male" class="m-ctrl">
			<option selected value='0'>0</option>
			<?php
			$pax=$row['Adults'];
			$extrabed=$row['Extrabedcount'];
			$totalpax=$pax+$extrabed;
			for($i=1; $i<=$totalpax;$i++)
			{
				echo '<option values='.$i.'>'.$i.'</option>';
			}			
			?>
		 </select>
		 <input type='hidden' name='totalocc' id='totalocc' value="<?php echo $totalpax; ?>"></td>
		<td>Female</td>
		 <td><select onchange='Adults1()' name="female" id="female" class="m-ctrl">
			<option selected value='0'>0</option>
			<?php
			$pax=$row['Adults'];
			$extrabed=$row['Extrabedcount'];
			$totalpax=$pax+$extrabed;
			for($i=1; $i<=$totalpax;$i++)
			{
				echo '<option values='.$i.'>'.$i.'</option>';
			}			
			?>
		 </select></td>
		 <td>child</td>
		 <td><select onchange='Adults1()' name="child" id="child" class="m-ctrl">
			<option selected value='0'>0</option>
			<?php
			 $pax=$row['Child'];
			$extrabed=$row['Extrabedcount'];
			$totalpax=$pax+$extrabed;
			for($i=1; $i<=$totalpax;$i++)
			{
				echo '<option values='.$i.'>'.$i.'</option>';
			}			
			?>
		 </select></td>
		<td>Number of Pax</td>
		<td><input name='Adults' id="Adults" type='text' value="<?php echo $row['Noofpersons']; ?>" readonly class="m-ctrl" ></td>
		</tr>
		<tr>
		<td>Comapny</td>
		<?php
			$company=''; $companyid=0;
			$qry3="select * from Mas_Company com
			 Inner Join Mas_CompanyType cty on cty.CompanyType_Id=com.CompanyType_Id
			 where cty.CompanyType<>'Travel Agent' and cty.CompanyType<>'Supplier' and isnull(com.Inactive,0)=0
			 and com.Company_Id=".$row['companyid'];
			$res3=$this->db->query($qry3);
			foreach ($res3->result_array() as $row3)
			{ $company=$row3['Company'];
			  $companyid=$row3['Company_Id'];} ?>
		<input type="hidden" name="Company_id" id="Company_id" value="<?php echo $companyid; ?>">
		<td><input name='Company' id='Company' type='text' class="m-ctrl"  value="<?php echo $company; ?>"></td>
		<td>Travelagent</td>
		<?php
			$Travelagent=''; $Travelagentid=0;
			$qry4="select * from Mas_Company com
			 Inner Join Mas_CompanyType cty on cty.CompanyType_Id=com.CompanyType_Id
			 where cty.CompanyType='Travel Agent'  and isnull(com.Inactive,0)=0
			 and com.Company_Id=".$row['companyid'];
			$res4=$this->db->query($qry4);
			foreach ($res4->result_array() as $row4)
			{ $Travelagent=$row4['Company'];
			  $Travelagentid=$row4['Company_Id'];} ?>
			<input type="hidden" id="Travelagentid" name="Travelagentid" value="<?php echo $Travelagentid; ?>" >
		<td><input name='Travelagent' id="Travelagent" type='text' class="m-ctrl" value="<?php echo $Travelagent; ?>"></td>
		<td>Booking Id</td>
		<td><input name='Bookingid' id="Bookingid" readonly type='text' class="m-ctrl" value=""></td>
		</tr>
	     <tr>
		<td></td><td></td>
		<td></td><td></td>
		<td></td><td><input type="submit" value="Save" class="btn btn-warning btn-sm"></td>
	   </tr>
	 </table>
</div>
 
   <input type="hidden" value=<?php echo $Roomid;?> id="Roomid" name="Roomid">
   <input type="hidden" value=<?php echo $grcid;?> id="grcid" name="grcid">
   <input type="hidden" value=<?php echo $roomgrcid;?> id="roomgrcid" name="roomgrcid">
 </form> 
 
<script>
 $(document).ready(function(e) {
   
	$('#male').val(<?php echo $row['male']; ?>);
	$('#female').val(<?php echo $row['female']; ?>);
	$('#child').val(<?php echo $row['Child']; ?>);
	
});

var rackrate = document.getElementById('rattypid');
rackrate.addEventListener('change', () =>{    
	ShowDynamicRent();
});

function ShowDynamicRent()
{
	var planid = rackrate.value;
	var pax = document.getElementById('Adults').value;
	$.ajax({		
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/rackRate",
		data:"&planid="+planid+"&roomgrcid="+<?php echo $roomgrcid;?>+"&roomid="+<?php echo $Roomid ?>+"&pax="+pax+"&actualplanid="+<?php echo $PlanType_Id ?>,
		dataType:'json',
		cache:false,		
		success: function(data)
		{  			
			document.getElementById("rackrate").value = data[0].Actrackrate;
			 //document.getElementById("Extra").value = result[0].Extrabedamount;			 
		}		 
	 });
}
$("#Company").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/Company",
                 dataType: "json",
                 data: {
                     term: request.term
                 },
                 success: function(data) {
                     response(data);
                 }
             });
         },
         minLength: 2,
         select: function(event, ui) {
			    event.preventDefault();  
			 $("#Company").val(ui.item.Company);			  
			 $("#Company_id").val(ui.item.Company_Id);
			 $("#Travelagent").val('');	
			 $("#Travelagentid").val('');			
			 $('#Bookingid').attr('readonly', true);
			 $('#Travelagent').attr('readonly', true);
         }
}); 
$("#Travelagent").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/Travel_Agent",
                 dataType: "json",
                 data: {
                     term: request.term
                 },
                 success: function(data) {
                     response(data);
                 }
             });
         },
         minLength: 2,
         select: function(event, ui) {
			    event.preventDefault();  
			 $("#Travelagent").val(ui.item.Company);			  
			 $("#Travelagentid").val(ui.item.Company_Id);
			 $('#Bookingid').attr('readonly', false);	
			 $("#Company").val('');	
			 $("#Company_id").val('');		
			 $('#Company').attr('readonly', true);	 
         } 
});
	$("#Nationality").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/Nationality",
                 dataType: "json",
                 data: {
                     term: request.term
                 },
                 success: function(data) {
                     response(data);
                 }
             });
         },
         minLength: 2,
         select: function(event, ui) {
			    event.preventDefault();  
			 $("#Nationid").val(ui.item.Nationid);			  
			 $("#Nationality").val(ui.item.Nationality);	
         }
     });
 function Adults1()
 {
	 var female =document.getElementById("female").value;
	 var male =document.getElementById("male").value;
	 var child =document.getElementById("child").value;
	 var totalocc =document.getElementById("totalocc").value;
	 var adu=(female * 1 )+(male * 1)+(child*1);
	 if(totalocc <  adu)
	 {
		 alert('Pax are greater than Room Max Occupany');
		
		 $("#Adults").val('0');
		  return;
	 }
	$("#Adults").val(adu);	
 }


 function discper1()
 {
	$("#discamt").val('0.00');	
	var discper=Number(document.getElementById("discper").value);
	var disp = document.getElementById("DISP").value;
	if(discper > disp || discper <0){

	   $("#discper").val('0');	
	   var msg = `you can give discount up to ${disp}% only`;
       return swal( msg);
      }  
 }
 function discamt1()
 {
	$("#discper").val('0');	
	var discamt=Number(document.getElementById("discamt").value);
	var disa = document.getElementById("DISA").value;
	if(disa < discamt){
		
	   document.getElementById("discamt").value= "0.00";
	   var msg = `you can give discount up to ${disa} only`;
       return swal( msg);
      }  
 }

document.getElementById("GuestDetailsopen").click();

function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

var btn2 = document.getElementById("tarifpop1");
 var modal1 = document.getElementById("tariff");
  var span1 = document.getElementById("span1");

btn2.onclick = function() {
  modal1.style.display = "block";
}
span1.onclick = function() {
  modal1.style.display = "none";

}
function closetariff()
{
	modal1.style.display = "none";
}
var modal2 = document.getElementById("cityselect");


function closecity()
{
	modal2.style.display = "none";
}

function cityselect()
{
  modal2.style.display = "block";
}


	///Room rent Edit Form Submit ////
$("#tariffsubmit").on('submit', function (e) {
		e.preventDefault();
		$.ajax({
		type: 'get',
		url: "<?php echo scs_index ?>Transaction/tarriffupdate?grcid=<?php echo $grcid; ?>&Numberofpax=<?php echo $Noofpersons; ?>",
		data: $('#tariffsubmit').serialize(),
		success: function (result) {
			alert(result);	
			var modal1 = document.getElementById("tariff");
			modal1.style.display = "none";
			}
		
		});
		setTimeout(ShowDynamicRent, 2000);
		//ShowDynamicRent();
		//guestmoredetails.style.display = "none";
	});
function selectedcity(a,b)
{
  var cityid=a;
  var cityname=b;
  $("#City").val(cityname); 
  $("#Cityid").val(cityid);
  modal2.style.display = "none";	
}


</script>
 <script>

function Guestamendment(){
		var form = $('#Guestamendmentsave')[0];

          $.ajax({
            type: 'POST',
            url: "<?php echo scs_index ?>Transaction/Guestamendmentsave?Roomid=<?php echo $Roomid; ?>",
			data:  new FormData(form),
				contentType: false,
				cache: false,
				processData: false,
            success: function (result) {
				swal("Success...!", "Guestamendment Save Successfully...!", "success");
				location.reload();	
				/*swal({
				  title: "Sucess...!",
				  text: "Guestamendment Save Sucessfully...!",
				  icon: "success",
				  buttons: true,
				  dangerMode: true,
				});/*
				.then((willDelete) => {
				  if (willDelete) {
				   window.location.href ="<?php echo scs_index ?>Transaction/RoomChart";
				  } else {
					window.location.href ="<?php echo scs_index ?>Transaction/RoomChart";
				  }
				});*/
			   }			  
			 });
          		   
				};
          		   
				
				const viewProof = (id)=>{
			$.ajax({
		type: 'get',
		url: "<?php echo scs_index ?>Transaction/viewProof?id="+id,
		success: function (result) {
			var modalImg = document.getElementById("GuestImageModal");
			modalImg.style.display = "block";
			document.getElementById("proofimage").setAttribute("src", `../../GuestProof/${result}`)
			
			}
		
		});
		}

		var guestspan = document.getElementById("guestspan");
		var modalImg = document.getElementById("GuestImageModal");
		guestspan.onclick = function() {
			document.getElementById("proofimage").removeAttribute("src", '');
        modalImg.style.display = "none";

        }
 </script>