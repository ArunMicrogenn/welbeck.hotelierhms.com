<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Reservation');
$this->pfrm->FrmHead3('Transaction/ Reservation',$F_Class."/".$F_Ctrl."/".$ID,$F_Class."/".$F_Ctrl."_View");


?>
<?php 
$qury = "select * from usertable where User_id='".User_id."' ";
$op = $this->db->query($qury);
foreach($op -> result_array() as $row){
	$percent = $row['disper'];
	$disamount = $row['disAmount'];
}

 $sql="select mr.RoomType, * from Trans_Reserve_Mas rm 
inner join Trans_Reserve_Det rd on rm.Resid=rd.resid
inner join Mas_Customer mc on mc.Customer_Id= rm.cusid
inner join Mas_RoomType mr on mr.RoomType_Id=rd.typeid
inner join Mas_PlanType mp on mp.PlanType_Id=rd.ratetypeid
inner join Mas_FoodPlan mf on mf.FoodPlan_Id=rd.ratetypeid
inner join mas_city mci on mci.Cityid = mc.Cityid
where rm.ResNo='".$ID."' and isnull(rd.stat, '')<> 'Y'";

$exe = $this->db->query($sql);
foreach($exe->result_array() as $row){
 $fromdate = $row['fromdate'];
 $todate = $row['todate'];
 $mobile= $row['Mobile'];
 $firstname = $row['Firstname'];
 $email= $row['Email_ID'];
 $customerid = $row['Customer_Id'];
 $roomid= $row['RoomType_Id'];
 $fromtime= $row['fromtime'];
 $totime= $row['totime'];
 $foodplanid = $row['FoodPlan_Id'];
 $roomtypeid=$row['RoomType_Id'];
 $PlanType_Id= $row['planid'];
 $pax = $row['noofpax'];
 $city = $row['City'];
 $cityid = $row['Cityid'];
 $travelagentid = $row['travelagentid'];
 $plandisc = $row['plandisc'];
 $plancharges = $row['plancharges'];
 $discper = $row['discper'];
 $discount = $row['discount'];
 $waitlist= $row['waitlist'];
 $company = $row['company'];
 $bookingid = $row['onlinebookingno'];
  $ResNo = $row['ResNo'];
   $totalrent = $row['roomrent'];
   $duedate = date('Y-m-d', strtotime(substr($row['duedate'], 0,10)));

}

?>
<div class="col-sm-12" style="color:black;">
  <div class="the-box F_ram">
	<form id="reserveform" method="POST" action='<?php echo scs_index ?>Transaction/ReservationEdit_save'>
    <fieldset>
        <table class="FrmTable T-3" >
			<tr>
			<td style="text-align: right;" class="F_val">Reservation No</td>
			<td align="left">
            <input type="text" id="resno" readonly   name="resno" value="<?php echo $ResNo;?>" class="f-ctrl rmm"><div class="Name"> 
			<div class="ResNo" ></div></td>
			</tr>
	    </table>
       
		<table id="mytable" width="100%" class="mytable" style="margin-top:20px">
			<thead>
			<tr>
			<th>S.No</th>
			<th>Room Type</th>
			<th>No Of Rooms</th>
			<th>Arrival Date</th>
			
			<th colspan="2" style="width: 150px;">Arrival Time</th>
			<th>Departure Date</th>
			<th colspan="2" style="width: 150px;">Departure Time</th>
			<th>Adult</th>
			<th>Child</th>
			<th>Rate Type</th>		
			<th>Tariff</th>
			<th>Plan</th>
			<th>Action</th>
			</tr>
			</thead>
			<?php 
			$sql="select mr.RoomType, * from Trans_Reserve_Mas rm 
			inner join Trans_Reserve_Det rd on rm.Resid=rd.resid
			inner join Mas_Customer mc on mc.Customer_Id= rm.cusid
			inner join Mas_RoomType mr on mr.RoomType_Id=rd.typeid
			inner join Mas_PlanType mp on mp.PlanType_Id=rd.ratetypeid
			inner join Mas_FoodPlan mf on mf.FoodPlan_Id=rd.ratetypeid
			inner join mas_city mci on mci.Cityid = mc.Cityid
			inner join mas_title mt on mt.Titleid =mc.Titelid
			where rm.ResNo='".$ID."' and isnull(rd.stat, '')<> 'Y'";
			
			$exe = $this->db->query($sql);
			$count = 1;
			$no = $exe->num_rows();
			foreach($exe->result_array() as $row1){
				$fromtime = $row1['fromtime'];
				$totime = $row1['totime'];
				$fromtime = new DateTime($fromtime);
				$totime = new DateTime($totime);
				$title= $row1['Titleid'];
			?>
			<tbody  class="input_fields_wrap">
			<tr  class="tb" id="tb<?php echo $count;?>">
			<input type="hidden"  num=1 name="bookingid" id="bookingid"  value="" class="f-ctrl rmm" >
			<input type="hidden"  num=1 name="roomcount" id="roomcount"  value="" class="f-ctrl rmm" >
			<input type="hidden"  num=1 name="Roomid" id="Roomid"  value="" class="f-ctrl rmm" >
            <input type="hidden"  num=1 name="customerid" id="customerid"  value="<?php echo $customerid; ?>" class="f-ctrl rmm" >
			<td style="text-align:center"><input style="text-align: center;" class="scs-ctrl" type="text" name="ID[]" id="ID1" value='<?php echo $count ?>'></td>                                      
			<td> 
				<select onchange="Roomvalidate(this.value, '<?php echo $count; ?>')" name="Roomtype_id[]" id="Roomtype<?php echo $count; ?>" class="f-ctrl rmm">
				<option value="">Select Room type</option>
				<?php 
				$Res=$this->Myclass->RoomType(0);
				foreach($Res as $row)
				{
				?>
				<option  <?php if($row1['RoomType_Id']==$row['RoomType_Id']){ echo "selected";}?> value="<?php echo $row['RoomType_Id']; ?>"><?php echo $row['RoomType'] ?></option>
				<?php }	?>
				</select></td> 
				<td><input id="noofrooms<?php echo $count ?>"  name="noofrooms[]"  onkeyup="noRooms(this.value)" value="<?php echo $row1['noofrooms'];?>" type="number" min="1" max="10"  class="scs-ctrl rmm" /></td>
			<td><input 
				id="Arrivaldate<?php echo $count;?>"  name="Indate[]" onchange="validatefromtime(this.value, '<?php echo $count;?>')" value="<?php echo date('Y-m-d', strtotime(substr($row1['fromdate'],0,10)));?>" type="date" min="<?php echo date('Y-m-d')?>" class="scs-ctrl  rmm" /></td>
			<td><select name="FHr[]" id="FHr<?php echo $count;?>" class="f-ctrl rmm" onchange="validatetime(this.value,'<?php echo $count;?>')">
				<?php
				
				for($i=0;$i<24;$i++)
				{
					?>
				<option <?php if($fromtime->format('H') == $i){echo "selected";}?> value="<?php echo $i; ?>" ><?php echo $i; ?></option>
			<?php 
				}
				?>
				</select>
			</td>	
			<td> <select name="FMi[]" id="FMi1" class="f-ctrl rmm">
				<?php   for($i=0;$i<60;$i++)
				{?>
					<option <?php if($fromtime->format('i') == $i){echo "selected";}?> value="<?php echo $i; ?>" ><?php echo $i; ?></option>
				<?php 
				}
				?></select>
			</td>
			<td><input name="todate[]" id="Departuredate<?php echo $count ?>"  value="<?php echo date('Y-m-d', strtotime(substr($row1['todate'],0,10)));?>" type="date" min="<?php echo date("Y-m-d");?>"  class="scs-ctrl rmm" /></td>
			<td><select name="THr[]" id="THr1" class="f-ctrl rmm">
				<?php
				for($i=0;$i<24;$i++)
				{
					?>
					<option <?php if($totime->format('H') == $i){echo "selected";}?> value="<?php echo $i; ?>" ><?php echo $i; ?></option>
				<?php 
				}  ?>
				</select>	
			</td>
			<td><select name="TMi[]" id="TMi1" class="f-ctrl rmm">
				<?php
				for($i=0;$i<60;$i++)
				{
					?>
					<option <?php if($totime->format('i') == $i){echo "selected";}?> value="<?php echo $i; ?>" ><?php echo $i; ?></option>
				<?php 
				}?>
				</select>
			</td>	
			<!-- <td> <select name="RoomNo[]" id="RoomNo1" class="f-ctrl rmm">
			<?php 
				$sql = "select * from mas_room";
				$ex= $this->db->query($sql);
				foreach($ex->result_array() as $row){
			?>
				<option  value='<?php echo $row['Room_Id']?>'><?php echo $row['RoomNo']?></option>
				<?php } ?>
				</select>
			</td> -->
			<td><select onchange="gettarriff(this.value, '<?php echo $count ?>' )" name="Adults[]" id="Adult<?php echo $count ?>" class="f-ctrl rmm">
			<option value='<?php echo $pax;?>'><?php echo $row1['noofpax'];?></option>
			</select></td>
			<td><input name="Child[]" id="Child<?php echo $count ?>" value="0" maxlength="1" num=1 class="f-ctrl rmm"  /></td>				
			<td> <select name="RateCode[]" id="Ratetype<?php echo $count ?>" class="f-ctrl rmm">
			<?php 
				$sql = "select * from mas_plantype";
				$ex= $this->db->query($sql);
				foreach($ex->result_array() as $row){
			?>
				<option <?php if($row1['ratetypeid']== $row['PlanType_Id']){echo "selected";}?> value='<?php echo $row['PlanType_Id']?>'><?php echo $row['RateCode']?></option>
				<?php } ?>
			</select>
			</td>      
			<td><input name="Tariff" id="Tariff<?php echo $count ?>" readonly  value="<?php echo $row1['roomrent'];?>"   num=1 class="f-ctrl rmm"  /></td>
			<td><select name="foodplan[]" id="foodplan<?php echo $count ?>" class="f-ctrl rmm"><option value="0">Select Plan</option>
			<?php
			$qry="select * from Mas_FoodPlan";
			$res=$this->db->query($qry);
			foreach ($res->result_array() as $row)
			{ ?>
			<option <?php if($row1['planid']== $row['FoodPlan_Id']){echo "selected";}?>
			 value="<?php echo $row['FoodPlan_Id']; ?>" ><?php echo $row['ShortName']?></option>			   
			<?php }?>
			<select></td>	
			                               
			<td><?php if($no == $count){?>  <a href="" id="1" class="add_field_button"><i class="fa fa-2x fa-check-square"></i></a><a href="" style="display:none" class="add_field_button1"><i class="fa fa-2x fa-check-square"></i></a><?php } ?></td>
			
		</tr>
			</tbody>
			
			<?php  $count++ ; } ?>
			<input type="hidden" value="<?php echo $count-1?>" id="count" name="rowcount">
			</table>  
			

			<br>
			<table class="FrmTable T-10" >
			<tr>
			<td style="text-align: right;">Mobile</td>
			<td><input type="text"   Placeholder="+91-19865999" name="Mobile" id="Mobile"  value="<?php  echo $mobile?>" class="f-ctrl rmm">
			<div class="Mobile" ></div></td>
			<td style="text-align: right;">Title<td>
			<td>
				<select id="Title" name="Title"  class="f-ctrl rmm">
				<?php 
				  echo $ti = "select * from mas_title";
				  $execc = $this->db->query($ti);
				  foreach($execc->result_array() as $tii){
				?>
				<option <?php if($title == $tii['Titleid'] ){ echo "selected"; } ?> value="<?php echo $tii['Titleid']?>"><?php echo $tii['Title'] ?></option>
				<?php } ?>
				</select>
			<div class="Title"></div> 
			<td>
			<td style="text-align: right;">Name<td>
			<td><input type="text"    name="Firstname" id="Firstname" value="<?php echo $firstname;?>" class="f-ctrl rmm"><div class="Firstname"></div> <td>
			<td style="text-align: right;">Email<td>
			<td><input type="text" id="Email" name="Email"    value="<?php echo $email;?>" class="f-ctrl rmm">  <td>
			<td style="text-align: right;">City<td>
			<td><input type="hidden" id="City_id" name="City_id" value = '<?php echo $cityid;?>' class="f-ctrl rmm"><input type="text" id="City" name="City"  value="<?php echo $city;?>" class="f-ctrl rmm"> <div class="City"></div><td>
			</tr>
			</table>
			<br>
			<table class="FrmTable T-10" >
			<tr>
	
			<td style="text-align: right;">Reservation Status</td>
			<td style="text-align: left;">
				<select id="ReservationMode" name="ReservationMode" class="f-ctrl rmm"><option value='0'>Select Status</option>
				<?php 
						$Res=$this->Myclass->ReservationMode(0);
						foreach($Res as $row)
						{
						?>
						<option  <?php if($waitlist == $row['ReservationMode_Id']){echo "selected";} ?> value="<?php echo $row['ReservationMode_Id'] ?>"><?php echo $row['ReservationMode'] ?></option>
				<?php }	?>
				</select></td>

				<td style="text-align: right;">Travel Agent</td>
				<td style="text-align: left;">
				<select name="travelagent_Id" id="TravelAgent" class="f-ctrl rmm"><option value="">Select Travel Agent</option>
				<?php 
						$qry="select * from Mas_Company cm
						inner join Mas_CompanyType ct on ct.CompanyType_Id=cm.CompanyType_Id where CompanyType ='Travel Agent'";
						$Res=$this->db->query($qry);
						foreach ($Res->result_array() as $row)
						{ 
						?>
						<option <?php if($travelagentid== $row['Company_Id']){echo "selected";} ?>  value="<?php echo $row['Company_Id'] ?>"><?php echo $row['Company'] ?></option>
						<?php
				}	?>
				</select> </td>

			</tr>
			<tr>	
			</tr>
			<tr>
			<td style="text-align: right;">Company Name</td>
				<td style="text-align: left;">
				
				<select name="CompanyId" id="Company" class="f-ctrl rmm"><option value="">Select Company</option>
				<?php 
						$qry="select * from Mas_Company cm
						inner join Mas_CompanyType ct on ct.CompanyType_Id=cm.CompanyType_Id where CompanyType !='Travel Agent'";
						$Res=$this->db->query($qry);
						foreach ($Res->result_array() as $row)
						{ 
						?>
						<option <?php if($company == $row['Company_Id']){echo "selected";} ?> value="<?php echo $row['Company_Id'] ?>"><?php echo $row['Company'] ?></option>
			<?php 	}	?>
				</select> </td>
				<td style="text-align: right;">Tariff Discount %</td>
				<td style="text-align: left;">
				<input type="hidden" id="DISP" value="<?php echo $percent;  ?>">
				<input type="text"  num=1 name="discper" id="TariffDiscountper" value="<?php echo $discper ?>"  class="f-ctrl rmm" >
				</td>
			
			
			</tr>
			<tr>
			
			    
				<td style="text-align: right;">Tariff Discount Amount</td>
				<td style="text-align: left;">
				<input type="hidden" id="DISA" value="<?php echo $disamount;  ?>">
				<input type="text"  num=1 name="discamt" id="TariffDiscountamt"  value="<?php echo $discount?>" class="f-ctrl rmm" >
				</td>
				<td style="text-align: right;"></td>
				<td id="datevaluetd" style="display:none"><input name="duedate" id="datevalue" style="display:none" value="<?php echo $duedate;?>" type="date" min="<?php echo date("Y-m-d");?>" class="scs-ctrl rmm" /></td>
				</td>
				<td style="text-align: left;">
				<input type="button"  onclick="Reserve()" class="btn btn-success btn-sm" id="btn" name="btn" value="save"  />
				</td>
				<!-- <td style="text-align: right;">Plan Discount Amont</td>
				<td style="text-align: left;">
				<input type="text"  num=1 name="plancharges" id="PlanDiscountamt" value="<?php echo $plancharges;?>" class="f-ctrl rmm" >
				</td> -->
			</tr>
			<tr>
			<!-- <td style="text-align: right;">Plan Discount %</td>
				<td style="text-align: left;">
				<input type="text"  num=1 name="plandisc" id="PlanDiscountper" value="<?php echo $plandisc;?>" class="f-ctrl rmm" >
				</td> -->
				
			</div>
			</tr>
		</table>
		<div id="edit"></div>
    </fieldset>
	</form>
  </div>
  <div class="the-box D_ISS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
?>
<!-- <script>
	var btn = document.getElementById("btn")
	btn.addEventListener("click", () => {
		var resno = document.getElementById("resno").value
		$.ajax({
			type:"POST",
			url:"<?php echo scs_index ?>Transaction/ReserveCheckin",
			data:"resno="+resno,
			success:function(html){
				$("#edit").html(html)
			}
		})
	});
</script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<SCRIPT language="javascript">



var discper=document.getElementById("TariffDiscountper");
var discamtbtn=document.getElementById("TariffDiscountamt");
var disp = document.getElementById("DISP").value;
var disa = document.getElementById("DISA").value;
discper.addEventListener('change', () =>{
	$("#discamt").val('0.00');	
	var discper=Number(document.getElementById("TariffDiscountper").value);
	
	if(discper > disp || discper <0){
		document.getElementById("TariffDiscountper").value= "0.00";
	   var msg = `you can give discount up to ${disp}% only`;
	   return swal( msg);
	   
      } 
 });

discamtbtn.addEventListener('change', () =>{

	$("#discper").val('0');		
	var discamt=Number(document.getElementById("TariffDiscountamt").value);

	if(disa < discamt){
	   document.getElementById("TariffDiscountamt").value= "0.00";
	   var msg = `you can give discount up to ${disa} only`;
       return swal( msg);
	   
	   	
      } 
	});
$("#Mobile").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/Customer",
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
			 $("#Lastname").val(ui.item.Lastname);			  
			 $("#Mobile").val(ui.item.Mobile);
			 $("#Title").val(ui.item.Title);
			 $("#Email").val(ui.item.Email_ID);
			 $("#Firstname").val(ui.item.Firstname);
			 $("#Country_id").val(ui.item.Countryid);			  
			 $("#State_id").val(ui.item.Stateid);
			 $("#City_id").val(ui.item.Cityid);
			 $("#City").val(ui.item.City);
			 $("#Middlename").val(ui.item.Middlename);
			 $("#address1").val(ui.item.HomeAddress1);
			 $("#address2").val(ui.item.HomeAddress2);
			 $("#address3").val(ui.item.HomeAddress3);
			 $("#pincode").val(ui.item.Homepincode);
			 $("#phone").val(ui.item.ResidentialPhone);
			 $("#workaddress1").val(ui.item.WorkAddress1);
			 $("#workaddress2").val(ui.item.WorkAddress2);
			 $("#workaddress3").val(ui.item.WorkAddress3);
			 $("#workpincode").val(ui.item.Workpincode);
			 $("#workphone").val(ui.item.WorPhone);
			 $("#profession").val(ui.item.Profession);
			// $("#dob").val(ui.item.Birthdate.split(' ')[0]);
			 //$("#anniversarydate").val(ui.item.Weddingdate.split(' ')[0]);
			 $("#likes").val(ui.item.Likes);
			 $("#dislikes").val(ui.item.Dislikes);
			 $("#preferredroom").val(ui.item.Preffered_Room);
			 $("#hotelcommends").val(ui.item.Hotel_Commends);
			 $("#passportno").val(ui.item.passportno);
			 //$("#dateofissue").val(ui.item.Passport_issuedate.split(' ')[0]);
			 $("#issueplace").val(ui.item.Passport_issueplace);
			 //$("#expirydate").val(ui.item.Passport_Expirydate.split(' ')[0]);
			 $("#visano").val(ui.item.VISA_No);
			 //$("#visadateofissue").val(ui.item.VISA_Issuedate.split(' ')[0]);
			 $("#visaissueplace").val(ui.item.VISA_Issueplace);
			 //$("#visaexpirydate").val(ui.item.VISA_Expirydate.split(' ')[0]);
			 $("#documenttype").val(ui.item.Id_Documenttype);
			 $("#documentno").val(ui.item.Id_Documentno);			  
			 $("#Nationality").val(ui.item.Nationality);
		
			
         }
     });

     $("#City").autocomplete({
         source: function(request, response) {
            $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/city",
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
			 $("#Country_id").val(ui.item.Country_Id);			  
			 $("#State_id").val(ui.item.State_id);
			 $("#City_id").val(ui.item.Cityid);
			 $("#City").val(ui.item.City);
			
         }
     });
   
     $("#Firstname").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/CustomerName",
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
			 $("#Lastname").val(ui.item.Lastname);			  
			 $("#Mobile").val(ui.item.Mobile);
			 $("#Email").val(ui.item.Email_ID);
			 $("#Firstname").val(ui.item.Firstname);
			 $("#Country_id").val(ui.item.Countryid);			  
			 $("#State_id").val(ui.item.Stateid);
			 $("#City_id").val(ui.item.Cityid);
			 $("#City").val(ui.item.City);
			 $("#Middlename").val(ui.item.Middlename);
			 $("#address1").val(ui.item.HomeAddress1);
			 $("#address2").val(ui.item.HomeAddress2);
			 $("#address3").val(ui.item.HomeAddress3);
			 $("#pincode").val(ui.item.Homepincode);
			 $("#phone").val(ui.item.ResidentialPhone);
			 $("#workaddress1").val(ui.item.WorkAddress1);
			 $("#workaddress2").val(ui.item.WorkAddress2);
			 $("#workaddress3").val(ui.item.WorkAddress3);
			 $("#workpincode").val(ui.item.Workpincode);
			 $("#workphone").val(ui.item.WorPhone);
			 $("#profession").val(ui.item.Profession);
			 $("#dob").val(ui.item.Birthdate);
			 $("#anniversarydate").val(ui.item.Weddingdate);
			 $("#likes").val(ui.item.Likes);
			 $("#dislikes").val(ui.item.Dislikes);
			 $("#preferredroom").val(ui.item.Preffered_Room);
			 $("#hotelcommends").val(ui.item.Hotel_Commends);
			 $("#passportno").val(ui.item.passportno);
			 $("#dateofissue").val(ui.item.Passport_issuedate);
			 $("#issueplace").val(ui.item.Passport_issueplace);
			 $("#expirydate").val(ui.item.Passport_Expirydate);
			 $("#visano").val(ui.item.VISA_No);
			 $("#visadateofissue").val(ui.item.VISA_Issuedate);
			 $("#visaissueplace").val(ui.item.VISA_Issueplace);
			 $("#visaexpirydate").val(ui.item.VISA_Expirydate);
			 $("#documenttype").val(ui.item.Id_Documenttype);
			 $("#documentno").val(ui.item.Id_Documentno);
			 $("#Nationid").val(ui.item.Nationid);			  
			 $("#Nationality").val(ui.item.Nationality);
	
			
         }
     });


	 function Reserve()
	{
	const counts = document.getElementById("count").value;
	// alert(counts)
	for(let i = 1; i<=counts; i++){
	var Mobile=document.getElementById("Mobile").value;
	var roomtype=document.getElementById("Roomtype"+i).value;
	var Indate=document.getElementById("Arrivaldate"+i).value;
	var Firstname=document.getElementById("Firstname").value;  
	var Email_ID=document.getElementById("Email").value;
	var Adults=document.getElementById("Adult1").value;
	var Child=document.getElementById("Child"+i).value;
	var City=document.getElementById("City").value;
	var RateCode=document.getElementById("Ratetype"+i).value;
	var discper=document.getElementById("TariffDiscountper").value;
	var discamt=document.getElementById("TariffDiscountamt").value;
	var foodplan=document.getElementById("foodplan"+i).value;
	var Tariff=document.getElementById("Tariff"+i).value;
	if(Mobile=='')
	{ alert('Mobile Number Empty'); 
		return; }

	if(Firstname =='')
	{ alert('Guest Name Empty'); 
		return; }
	if(City =='')
	{ alert('Please Select the City'); 
		return; }
	if(Indate == ''){
		alert('Please Select Arrival Date'); 
		return;
	}
	if(roomtype==0){
		alert('Please Select the Roomtype'); 
		return;
	}
	if(Adults==0){
		alert('Please Select the  no of Adults'); 
		return;
	}
	if(foodplan==0){
		alert('Please Select the plan'); 
		return;
	}
	if(Tariff ==0){
		alert('Tariff is empty'); 
		return;
	}
    }

    $.ajax({
      type: 'post',
      url: '<?php echo scs_index ?>Transaction/ReservationEdit_save',
      data: $('#reserveform').serialize(),
      success: function (result) {
        if(result =='success')		
      {
        swal("Success...!", "Amendment Save Successfully...!", "success")
        .then(function() {
          window.location.href='<?php echo scs_index?>Transaction/AmendmentList';	

          });
      }
      else
      {
        swal("Faild...!", "Amentment Save Faild...!", "error")
        .then(function() {
            window.location.href='<?php echo scs_index?>Transaction/AmendmentList';		

          });
      }
    
    }
  });
}
	

</script>

<script>
// var d = new Date(); // for now
// var h =d.getHours(); // => 9
// var s =d.getMinutes(); // =>  30
// // document.getElementById("FHr1").disabled = true;
// // document.getElementById("FMi1").disabled = true;
// $('#FHr1').val(h);
// $('#FMi1').val(s);
// $('#THr1').val(h);
// $('#TMi1').val(s);
	 var x = 1; 
function validatefromtime(a,b)
 {  
	var Indate =a;
    var date = Indate.substring(0, 2);
    var month = Indate.substring(3, 5);
    var year = Indate.substring(6, 10); 
    var InDate = new Date(year, month - 1, date);
	var currentdate = new Date();
	if(currentdate <= InDate)
    {
	     document.getElementById("FHr1").disabled = false;
		 document.getElementById("FMi1").disabled = false;	
	}
	else
	{
	    //  document.getElementById("FHr1").disabled = true;
		//  document.getElementById("FMi1").disabled = true;	
	}
	var today = new Date(a); // Or Date.today()
    var tomorrow = today.setDate(today.getDate() + 1);
	var newdate = new Date(tomorrow).toISOString().slice(0,10);
	document.getElementById("Departuredate"+b).value = newdate
 }
 function Roomvalidate(a,b)
 {
     
	
	let rcount = $('#mytable .tb').length
	// alert(rcount)
	 for(let j = 1; j<=rcount; j++){
		let changing = document.getElementById("Roomtype"+j).value;
		let  cur = document.getElementById("Roomtype"+b).value
		if(j == rcount){
			continue
		}
		if(changing == cur){
			// alert("same")
			document.getElementById("Roomtype"+b).value = ''
		}
		
	 }

	    $.ajax({
            url: "<?php echo scs_index ?>Transaction/roomtypegetroomnumber?type="+a,
            type: 'POST',
            success: function (data) {
                $('#RoomNo'+b).empty();
                $('#RoomNo'+b).append(data);
		    }
			
        });   
		$.ajax({
            url: "<?php echo scs_index ?>Transaction/roomtypegetPlanid?type="+a,
            type: 'POST',
            success: function (data) {
                $('#Ratetype'+b).empty();
                $('#Ratetype'+b).append(data);
				console.log('#Ratetype'+b)
		    }
			
        }); 
		$.ajax({
            url: "<?php echo scs_index ?>Transaction/roomtypegetadults?type="+a,
            type: 'POST',
            success: function (data) {
                $('#Adult'+b).empty();
                $('#Adult'+b).append(data);
		    }
			
        });    
 }
 function gettarriff(a,b)
 {
	var Roomtype =document.getElementById("Roomtype"+b).value;
	var Plantype =document.getElementById("Ratetype"+b).value;
    // alert()
	$.ajax({
            url: "<?php echo scs_index ?>Transaction/roomtypegettariff?type="+Roomtype+"&pax="+a+"&plantype="+Plantype,
            type: 'POST',
            success: function (data) {
               	 $('#Tariff'+b).val(data);	
		    }
			
        }); 
 }

		
    $(document).ready(function() {

    var max_fields      = 60000; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
  
    
    $(wrapper).on("click",".add_field_button", function(e)
    { //on add input button click
        e.preventDefault();
		const counts = $('#mytable .tb').length
	     for(let i = 1; i<=counts; i++){
			var roomtype=document.getElementById("Roomtype"+i).value;
			var foodplan=document.getElementById("foodplan"+i).value;
	        var Tariff=document.getElementById("Tariff"+i).value;
			var Adults=document.getElementById("Adult"+i).value;
			if(roomtype == 0){
				alert("select roomtype")
				return
			}
			if(foodplan == 0){
				alert("select Foodplan")
				return
				
			}
			if(Tariff == 0){
				alert("Empty Tariff")
				return
			}
			if(Adults == 0){
				alert("select pax")
				return
			}
		 }
		let x = $('#mytable .tb').length
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            //  var b_id=$(this).attr("id")  
			var b_id = $('#mytable .tb').length

           $('#tb'+b_id+'').after('<tr class="tb" id="tb'+x+'"><td style="text-align:center"><input style="text-align: center;" type="text" class="scs-ctrl" name="ID[]" id="ID'+x+'" value="'+x+'"></td><td><select onchange="Roomvalidate(this.value, '+x+')" name="Roomtype_id[]" id="Roomtype'+x+'" class="f-ctrl rmm"> <option value="">Select Room type</option><?php  $Res=$this->Myclass->RoomType(0); foreach($Res as $row){ echo "<option value=".$row['RoomType_Id'].">".$row['RoomType']."</option>";	}?> </select> </td><td><input id="noofrooms'+x+'" onkeyup="noRooms(this.value)" name="noofrooms[]"  value="1" min="1" max="10" type="text"  class="scs-ctrl rmm" /></td>		<td><input name="Indate[]" id="Arrivaldate'+x+'" onchange="validatefromtime(this.value, '+x+')" value="<?php echo date('Y-m-d') ?>" min="<?php echo date('Y-m-d');?>" type="date"  class="scs-ctrl  rmm" /></td> <td><select name="FHr[]" id="FHr'+x+'" onchange="validatetime(this.value, '+x+')"class="f-ctrl rmm"><?php for($i=0;$i<24;$i++) { echo "<option value=".$i." >$i</option>"; } ?> </select> </td><td> <select name="FMi[]" id="FMi'+x+'" class="f-ctrl rmm"> <?php   for($i=0;$i<60;$i++){    echo "<option value=".$i." >$i</option>"; } ?></select></td> <td><input name="todate[]" id="Departuredate'+x+'" value="<?php echo date('Y-m-d');?>" min="<?php echo date('Y-m-d');?>" type="date"  class="scs-ctrl  rmm" /></td><td><select name="THr[]" id="THr'+x+'" class="f-ctrl rmm">  <?php  for($i=0;$i<24;$i++) {  echo "<option value=".$i." >$i</option>"; }  ?> </select></td> <td><select name="TMi[]" id="TMi'+x+'" class="f-ctrl rmm"><?php for($i=0;$i<60;$i++){  echo "<option value=".$i." >$i</option>";  }?> </select></td> <td><select onchange="gettarriff(this.value, '+x+')" name="Adults[]" id="Adult'+x+'" value=""  class="f-ctrl rmm" ><option values="0">0</option</select></td>  <td><input name="Child[]" id="Child'+x+'" value=""  num=1 class="f-ctrl rmm"  /></td><td> <select name="RateCode[]" id="Ratetype'+x+'" class="f-ctrl rmm"> <option value="">Select Rate type</option>  <?php $Res=$this->Myclass->RatePlan(0); foreach($Res as $row) { echo "<option value=".$row['RatePlan_Id'].">".$row['RC']."</option>";   }	?> </select> </td> <td><input name="Tariff[]" id="Tariff'+x+'" value=""  num=1 class="f-ctrl rmm"  /></td>  <td><select name="foodplan[]" id="foodplan'+x+'" class="f-ctrl rmm"><option value="0">Select Plan</option> <?php $qry="select * from Mas_FoodPlan"; $res=$this->db->query($qry); foreach ($res->result_array() as $row){ echo "<option value=".$row['FoodPlan_Id'].">".$row['ShortName']."</option>";	} ?><select></td><td><div style="width:50%; float: left" id='+x+' class="remove_field"><i class="fa fa-2x fa-minus-square"></i></div><div style="width:50%; padding-left:5px; float: right"  id='+x+' class="add_field_button"><i class="fa fa-2x fa-check-square"></i></div></td></tr>');
            document.getElementById("count").value = $('#mytable .tb').length
                      
           }
		    var d = new Date(); // for now
			var h =d.getHours(); // => 9
			var s =d.getMinutes(); // =>  30
			// document.getElementById("FHr1").disabled = true;
			// document.getElementById("FMi1").disabled = true;
			$('#FHr'+x).val(h);
			$('#FMi'+x).val(s);
			$('#THr'+x).val(h);
			$('#TMi'+x).val(s);
    });
      
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        var b_id=$(this).attr("id");                                          
        $('#tb'+b_id+'').remove();  
		document.getElementById("count").value = $('#mytable .tb').length     

    })



	let resvalue = Number(document.getElementById("ReservationMode").value)
	let rcount = $('#mytable .tb').length
	 let leastdate
	 if(Number(resvalue) == 3){
		for(let a = 1; a<=rcount ; a++){
			if(a == 1){
				leastdate = document.getElementById("Arrivaldate"+a).value
			}
		let arr = document.getElementById("Arrivaldate"+a).value
		arr = new Date(arr).toLocaleDateString()
		if(leastdate > arr){
			leastdate = arr
		}
	 }
	    var todayDate = new Date(leastdate).toISOString().slice(0, 10);
		document.getElementById("datevalue").style.display = "block"
		document.getElementById("datevalue").max = todayDate
		// alert(todayDate)
		document.getElementById("datevaluetd").style.display = "block"
	 }else{
		document.getElementById("datevalue").style.display = "none"
		document.getElementById("datevaluetd").style.display = "none"
	 }
});




const counts = document.getElementById("count")
const noRooms = (a) => {
   let totalrooms = 0;
   let co = counts.value
   for(let i=1; i<=co ; i++){
	totalrooms += Number(document.getElementById("noofrooms"+i).value) 
   }
   document.getElementById("roomcount").value = totalrooms
}


const validatetime = (a,b) =>{
	date = new Date()
	currentHour = date.getHours()
	var Indate=document.getElementById("Arrivaldate"+b).value;
	Indate = new Date(Indate).toLocaleDateString()
	date = date.toLocaleDateString()
	if(date == Indate){
	if(Number(a) < currentHour){
		document.getElementById("FHr"+b).value = currentHour
	}
}
	
}


const reservationstatus = document.getElementById("ReservationMode")
reservationstatus.addEventListener("change", () =>{
	 let rcount = $('#mytable .tb').length
	 let status = reservationstatus.value
	 let leastdate
	 if(Number(status) == 3){
		for(let a = 1; a<=rcount ; a++){
			if(a == 1){
				leastdate = document.getElementById("Arrivaldate"+a).value
			}
		let arr = document.getElementById("Arrivaldate"+a).value
		arr = new Date(arr).toLocaleDateString()
		if(leastdate > arr){
			leastdate = arr
		}
	 }
	    var todayDate = new Date(leastdate).toISOString().slice(0, 10);
		document.getElementById("datevalue").style.display = "block"
		document.getElementById("datevalue").max = todayDate
	    // alert(todayDate)
		document.getElementById("datevaluetd").style.display = "block"
	 }else{
		document.getElementById("datevalue").style.display = "none"
		document.getElementById("datevaluetd").style.display = "none"
	 }
	 

})
</SCRIPT>
	
	


	
	