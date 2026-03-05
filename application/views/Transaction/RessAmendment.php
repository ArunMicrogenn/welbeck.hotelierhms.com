<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
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
left outer join mas_city mci on mci.Cityid = mc.Cityid
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
  $duedate =   date("Y-m-d", strtotime($row['duedate']));
   $yearPrefix = $row['yearprefix'];

}

?>
<div class="col-sm-12" style="color:black;">
  <div class="the-box F_ram">
	<form id="reserveform" method="POST" action='<?php echo scs_index ?>Transaction/ReservationEdit_save'>
    <fieldset>

	
        <table class="FrmTable T-3" styel="width:30%;" >
			<tr>
			<td style="text-align: right;" class="F_val">Reservation No</td>
			<td align="left">
			<input type="hidden"  readonly id="resnumber"   name="resno" value="<?php echo $ResNo;?>" class="f-ctrl rmm"><div class="Name"> 
			<input type="hidden"  readonly id="prefix"   name="prefix" value="<?php echo $yearPrefix;?>" class="f-ctrl rmm"><div class="Name"> 

            <input type="text" id="resno" readonly    value="<?php echo $yearPrefix.'/'.$ResNo;?>" class="f-ctrl rmm"><div class="Name"> 
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
			left outer join mas_city mci on mci.Cityid = mc.Cityid
			left outer join mas_title mt on mt.Titleid =mc.Titelid
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
			<td><input name="todate[]" id="Departuredate<?php echo $count ?>" onchange="validatetodate(this.value,'<?php echo $count; ?>')"  value="<?php echo date('Y-m-d', strtotime(substr($row1['todate'],0,10)));?>" type="date" min="<?php echo date("Y-m-d");?>"  class="scs-ctrl rmm" /></td>
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
			<!-- <td>
                <input type="hidden" id="City_id" name="City_id" value = '<php echo $cityid;?>' class="f-ctrl rmm">
                <input type="text" id="City" name="City"  value="<php echo $city;?>
                " onkeydown="return /[a-z]/i.test(event.key)"  class="f-ctrl rmm"> <div class="City"></div><td> -->

                
            		<td>
				<!-- <input type="hidden" id="City_id" name="City_id" value = '<php echo @$cityid;?>' class="f-ctrl rmm"> -->
				<!-- <input type="text" id="City" name="City"  value="<php echo @$city;?>" onkeydown="return /[a-z]/i.test(event.key)"  class="f-ctrl rmm">  -->
				<div class="City"></div>

	           <select id="City_id" name="City_id" class="f-ctrl rmm">
              <option value="">Select City</option>
                 <?php  
               $Resqry = "SELECT * FROM mas_city ORDER BY City ASC";
                 $res = $this->db->query($Resqry)->result_array();
           foreach($res as $row) { 
        $selected = ($row['Cityid'] == @$cityid) ? 'selected' : '';
        echo '<option value="'.$row['Cityid'].'" '.$selected.'>'.$row['City'].'</option>';
             } 
               ?>
          </select>
	  <td>
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
						<option  <?php if($waitlist == $row['ReservationMode_Id']){echo "selected";} ?> value="<?php echo $row['ReservationMode'] ?>"><?php echo $row['ReservationMode'] ?></option>
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
             <?php if($duedate == '') { ?>
                    <td id="datevaluetd" style="display:none"><input name="duedate" id="datevalue"  value="<?php echo date("Y-m-d");?>" type="date" min="<?php echo date("Y-m-d");?>" class="scs-ctrl rmm" /></td>
           <?php } else { ?>
            <td id="datevaluetd" ><input name="duedate" id="datevalue"  value="<?php echo $duedate;?>" type="date" min="<?php echo date("Y-m-d");?>" class="scs-ctrl rmm" /></td>
           <?php } ?>
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
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
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

     function validatetodate(a,b){

        var resno = document.getElementById("resnumber").value;
    var prefix = document.getElementById("prefix").value;
	var Roomtype = document.getElementById("Roomtype"+b).value;
	
	var fromDate = document.getElementById("Arrivaldate"+b).value;
	var todate = document.getElementById("Departuredate"+b).value;
	var totalRooms = document.getElementById("noofrooms"+b).value;

    $.ajax({
            url: "<?php echo scs_index ?>Transaction/reserve_amend_validation", 
            method: 'POST',
            data: {
                roomtypeid: Roomtype,
                noofrooms: totalRooms,
                fromdate: fromDate,
                todate: todate,
				resno:resno,
				prefix : prefix

            },

            success: function(response) {

              
                // alert(response);
                response = "[" + response.replace(/}{/g, "},{") + "]";
var data = JSON.parse(response);

var availableRooms = 0;
var roomTypeName = "";
var date = 0;

if (data.length > 0) {
    for (let i = 0; i < data.length; i++) {
        availableRooms = data[i].available;
        roomTypeName = data[i].room_type;
        date = data[i].date;

        if (totalRooms > availableRooms) {
            alert("Only " + availableRooms + " rooms available for " + roomTypeName + " Room Type for this " + date);
            document.getElementById("noofrooms" + b).value = availableRooms;
            return;
        }
    }
}


    
    
    

        // if (totalRooms > availableRooms) { 
        //     alert("Only " + availableRooms + " rooms available for " + roomTypeName + " Room Type");
        //     document.getElementById("noofrooms"+b).value = availableRooms;
        // } else {
        //     document.getElementById("noofrooms"+b).value = availableRooms;  
           
        // }
        },
            error: function() {
                alert("An error occurred while checking room availability.");
            }
        });

     }


	 function Reserve() {
    let isValid = true;
    let lastRoomTypeId = null;
    const counts = parseInt(document.getElementById("count").value, 10);

    for (let i = 1; i <= counts; i++) {
        const Mobile = document.getElementById("Mobile").value.trim();
        const Firstname = document.getElementById("Firstname").value.trim();
        const City = document.getElementById("City").value.trim();
        const Indate = document.getElementById("Arrivaldate" + i).value.trim();
        const Todate = document.getElementById("Departuredate" + i).value.trim();
        const roomtype = document.getElementById("Roomtype" + i).value;
        const Adults = document.getElementById("Adult" + i).value;
        const foodplan = document.getElementById("foodplan" + i).value;
        const Tariff = document.getElementById("Tariff" + i).value;
		let noOfRooms = document.getElementById("noofrooms"+i).value; 
		const status = document.getElementById("ReservationMode").value; 


        	
	if(status=='0')
	{ alert('Please Select Reservation Status'); 
		return; }

        if (!Mobile) {
            alert('Mobile Number is required');
            return;
        }

        if (!Firstname) {
            alert('Guest Name is required');
            return;
        }

        if (!City) {
            alert('City is required');
            return;
        }

        if (!Indate) {
            alert('Arrival Date is required');
            return;
        }

        if (!roomtype || roomtype == 0) {
            alert('Please select the Room Type');
            return;
        }

		if (noOfRooms == '' || noOfRooms == 0) {
            alert('Please select No of rooms');
            return;
        }

        if (!Adults || Adults == 0) {
            alert('Please select the number of Adults');
            return;
        }

        if (!foodplan || foodplan == 0) {
            alert('Please select the food plan');
            return;
        }

        if (!Tariff || Tariff == 0) {
            alert('Tariff is required');
            return;
        }

        lastRoomTypeId = roomtype;
		Arrdate = Indate;
		deptdate = Todate;
    }


    const values = [];
    $('input[name="noofrooms[]"]').each(function () {
        values.push(parseInt($(this).val()));
    });

    // const totalRooms = values[values.length - 1];
    var resno = document.getElementById("resnumber").value;
    var prefix = document.getElementById("prefix").value;


    let totalRooms = values[values.length - 1];
    let x = Number(document.getElementById("count").value);
    let max_fields = 10;

    $.ajax({
        type: 'POST',
        url: "<?php echo scs_index ?>Transaction/reserve_amend_validation",
        data: {
            rooms: totalRooms,
            roomtypeid: lastRoomTypeId
        },
        success: function (response) {
            let availableRooms = response;

            if (totalRooms > availableRooms) {
				// alert(availableRooms);
                alert("Sorry! You have only " + availableRooms + " rooms available");
				return;
            
            } 
        },
        error: function (xhr, status, error) {
            alert("AJAX Error: " + error);
        }
    });




           

        
                $.ajax({
                    type: 'POST',
                    url: '<?php echo scs_index ?>Transaction/ReservationEdit_save',
                    data: $('#reserveform').serialize(),
                    success: function (result) {
						// console.log(result);
                        if (result.trim() === 'success') {
                            swal("Success!", "Amendment Saved Successfully!", "success")
                                .then(() => {
                                    window.location.href = '<?php echo scs_index ?>Transaction/AmendmentList';
                                });
                        } else {
                            swal("Failed!", "Amendment Save Failed!", "error")
                                .then(() => {
                                    window.location.href = '<?php echo scs_index ?>Transaction/AmendmentList';
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
    var resno = document.getElementById("resnumber").value;
    var prefix = document.getElementById("prefix").value;
	var Roomtype = document.getElementById("Roomtype"+b).value;
	
	var fromDate = document.getElementById("Arrivaldate"+b).value;
	var todate = document.getElementById("Departuredate"+b).value;
	var totalRooms = document.getElementById("noofrooms"+b).value;

    $.ajax({
            url: "<?php echo scs_index ?>Transaction/reserve_amend_validation", 
            method: 'POST',
            data: {
                roomtypeid: Roomtype,
                noofrooms: totalRooms,
                fromdate: fromDate,
                todate: todate,
				resno:resno,
				prefix : prefix

            },

            success: function(response) {
			
            response = "[" + response.replace(/}{/g, "},{") + "]";
        var data = JSON.parse(response);

  
        var availableRooms = 0;
        var roomTypeName = "";
        
    
        if (data.length > 0) {
            availableRooms = parseInt(data[0].available); 
            roomTypeName = data[0].room_type;  
        }

        if (totalRooms > availableRooms) {
            alert("Only " + availableRooms + " rooms available for " + roomTypeName + " Room Type.");
            document.getElementById("noofrooms"+b).value = availableRooms;
        } else {
            roomAvailability[roomTypeId] = availableRooms;  
        }
        },
            error: function() {
                alert("An error occurred while checking room availability.");
            }
        });
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
	

	// var roomAvailability = {}; 
    // var roomsBooked = {}; 
    var resno = document.getElementById("resnumber").value;
    var prefix = document.getElementById("prefix").value;
	var Roomtype = document.getElementById("Roomtype"+b).value;
	
	var fromDate = document.getElementById("Arrivaldate"+b).value;
	var totalRooms = document.getElementById("noofrooms"+b).value;




	

	$.ajax({
            url: "<?php echo scs_index ?>Transaction/reserve_amend_validation", 
            method: 'POST',
            data: {
                roomtypeid: Roomtype,
                noofrooms: totalRooms,
                fromdate: fromDate,
				resno:resno,
				prefix : prefix

            },
            success: function(response) {
			
                response = "[" + response.replace(/}{/g, "},{") + "]";
            var data = JSON.parse(response);

      
            var availableRooms = 0;
            var roomTypeName = "";
            
        
            if (data.length > 0) {
                availableRooms = parseInt(data[0].available); 
                roomTypeName = data[0].room_type;  
            }

            if (totalRooms > availableRooms) {
                alert("Only " + availableRooms + " rooms available for " + roomTypeName + " Room Type.");
                document.getElementById("noofrooms"+b).value = availableRooms;
            } else {
                roomAvailability[roomTypeId] = availableRooms;  
            }
            },
            error: function() {
                alert("An error occurred while checking room availability.");
            }
        });
	
	// let rcount = $('#mytable .tb').length
	// // alert(rcount)
	//  for(let j = 1; j<=rcount; j++){
	// 	let changing = document.getElementById("Roomtype"+j).value;
	// 	let  cur = document.getElementById("Roomtype"+b).value
	// 	if(j == rcount){
	// 		continue
	// 	}
	// 	if(changing == cur){
	// 		// alert("same")
	// 		document.getElementById("Roomtype"+b).value = ''
	// 	}
		
	//  }

     let rcount = parseInt(document.getElementById("count").value);
    let currentValue = document.getElementById("Roomtype" + b).value;

    for (let j = 1; j <= rcount; j++) {
        if (j == b) continue; // Skip comparing to itself

        let compareElement = document.getElementById("Roomtype" + j);
        if (!compareElement) continue;

        let compareValue = compareElement.value;

        // If duplicate found
        if (currentValue !== "" && currentValue === compareValue) {
            document.getElementById("Roomtype" + b).value = ""; // reset to "Select Roomtype"
            alert("This room type already exists. Please choose another.");
            break;
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

        var resno = document.getElementById("resnumber").value;
    var prefix = document.getElementById("prefix").value;
	var Roomtype = document.getElementById("Roomtype"+b).value;
	
	var fromDate = document.getElementById("Arrivaldate"+b).value;
	var Departuredate = document.getElementById("Departuredate"+b).value;
	var totalRooms = document.getElementById("noofrooms"+b).value;

	
	
	

	$.ajax({
            url: "<?php echo scs_index ?>Transaction/reserve_amend_validation", 
            method: 'POST',
            data: {
                roomtypeid: Roomtype,
                noofrooms: totalRooms,
                fromdate: fromDate,
				resno:resno,
				prefix : prefix

            },

		
            success: function(response) {
			    var data = JSON.parse(response);
				// alert("134");
    
    var availableRooms = parseInt(data.available); 
    var roomTypeName = data.room_type;    

				
                // var availableRooms = parseInt(response); 
                if (totalRooms > availableRooms) {
               
                    $("#noofrooms" + b).val(availableRooms); 
                    alert("Only " + availableRooms + " rooms are available for " + roomTypeName + " RoomType");
                } else {
                    
                    roomAvailability[roomTypeId] = availableRooms;
                }
                if (callback) callback(availableRooms); 
            },
            error: function() {
                alert("An error occurred while checking room availability.");
            }
        });
	var Roomtype =document.getElementById("Roomtype"+b).value;
	var Plantype =document.getElementById("Ratetype"+b).value;

	$.ajax({
            // url: "<?php echo scs_index ?>Transaction/roomtypegettariff_amendment?type="+Roomtype+"&pax="+a+"&plantype="+Plantype,
            url: "<?php echo scs_index ?>Transaction/roomtypegettariff?type="+Roomtype+"&pax="+a+"&plantype="+Plantype +"&Arrivaldate="+fromDate +"&Departuredate="+Departuredate,
            type: 'POST',
            success: function (data) {
               	 $('#Tariff'+b).val(data);	
		    }
			
        }); 
 }

		
 $(document).ready(function () {
    var max_fields = 60000;
    var wrapper = $(".input_fields_wrap");
    var roomAvailability = {}; 
    var roomsBooked = {}; 
    var resno = document.getElementById("resnumber").value;
    var prefix = document.getElementById("prefix").value;

   
function checkRoomAvailability(roomTypeId, totalRooms, rowId, fromDate, callback) {
    $.ajax({
        url: "<?php echo scs_index ?>Transaction/reserve_amend_validation", 
        method: 'POST',
        data: {
            roomtypeid: roomTypeId,
                noofrooms: totalRooms,
                fromdate: fromDate,
				resno:resno,
				prefix : prefix
        },
        success: function(response) {

           
            response = "[" + response.replace(/}{/g, "},{") + "]";
            var data = JSON.parse(response);

      
            var availableRooms = 0;
            var roomTypeName = "";
            
        
            if (data.length > 0) {
                availableRooms = parseInt(data[0].available); 
                roomTypeName = data[0].room_type;  
            }

            if (totalRooms > availableRooms) {
                alert("Only " + availableRooms + " rooms available for " + roomTypeName + " Room Type.");
                $("#noofrooms" + rowId).val(availableRooms); 
            } else {
                roomAvailability[roomTypeId] = availableRooms;  
            }

            if (callback) callback(availableRooms); 
        },
        error: function() {
            alert("An error occurred while checking room availability.");
        }
    });
}

  
    $(wrapper).on("input", "input[name='noofrooms[]']", function () {
        var rowId = $(this).attr("id").replace("noofrooms", "");
        var roomTypeId = $("#Roomtype" + rowId).val();
        var fromDate = $("#Arrivaldate" + rowId).val();
        var noOfRooms = parseInt($(this).val()); 


        if (roomTypeId && !isNaN(noOfRooms) && noOfRooms > 0) {
          
            var totalBookedRoomsForType = 0;
            $("select[name='Roomtype_id[]']").each(function(index) {
                var type = $(this).val();
                if (type == roomTypeId) {
                    totalBookedRoomsForType += parseInt($("input[name='noofrooms[]']").eq(index).val()) || 0;
                }
            });

        
            checkRoomAvailability(roomTypeId, totalBookedRoomsForType, rowId, fromDate, function(availableRooms) {
                if (totalBookedRoomsForType > availableRooms) {
                  
                    // alert("Only " + availableRooms + " rooms are available for this type. You have " + (availableRooms - (totalBookedRoomsForType - noOfRooms)) + " rooms remaining.");
                    $(this).val(availableRooms); 
                }
            });
        } else {
            $(this).val(""); 
        }
    });

    
    $(wrapper).on("click", ".add_field_button", function (e) {
        e.preventDefault();

        let currentIndex = Number(document.getElementById("count").value);
        let roomtype = $("#Roomtype" + currentIndex).val();
        let foodplan = $("#foodplan" + currentIndex).val();
        let Tariff = $("#Tariff" + currentIndex).val();
        let Adults = $("#Adult" + currentIndex).val();
        let noofrooms = $("#noofrooms" + currentIndex).val();
		

        
        if (!roomtype || roomtype == "0") {
            alert("Select Room Type ");
            return;
        }
        if (!Adults || Adults == "0") {
            alert("Select Pax ");
            return;
        }

		if (noofrooms == '' || noofrooms == "0") {
            alert("Select No Of Rooms ");
            return;
        }


        if (!foodplan || foodplan == "0") {
            alert("Select Food Plan");
            return;
        }
        if (!Tariff || Tariff == "0") {
            alert("Enter Tariff ");
            return;
        }

       
        if (currentIndex < max_fields) {
            var newIndex = currentIndex + 1;

         
            $('#tb' + currentIndex).after(`
                <tr class="tb" id="tb${newIndex}">
                    <td style="text-align:center">
                        <input style="text-align: center;" type="text" class="scs-ctrl" name="ID[]" id="ID${newIndex}" value="${newIndex}">
                    </td>
                    <td>
                        <select onchange="Roomvalidate(this.value, ${newIndex})" name="Roomtype_id[]" id="Roomtype${newIndex}" class="f-ctrl rmm">
                            <option value="">Select Room type</option>
                            <?php  
                            $Res=$this->Myclass->RoomType(0); 
                            foreach($Res as $row){
                                echo "<option value=".$row['RoomType_Id'].">".$row['RoomType']."</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input id="noofrooms${newIndex}" name="noofrooms[]" value="1" type="number" min="1" max="10" class="scs-ctrl rmm" />
                    </td>
                    <td>
                        <input name="Indate[]" id="Arrivaldate${newIndex}" class="arrival" onchange="validatefromtime(this.value, ${newIndex})" value="<?php echo date('Y-m-d');?>" type="date" min="<?php echo date('Y-m-d');?>" class="scs-ctrl Dat rmm" />
                    </td>
                    <td>
                        <select name="FHr[]" id="FHr${newIndex}" onchange="validatetime(this.value, ${newIndex})" class="f-ctrl rmm">
                            <?php for($i=0; $i<24; $i++) { echo "<option value=".$i.">$i</option>"; } ?>
                        </select>
                    </td>
                    <td>
                        <select name="FMi[]" id="FMi${newIndex}" class="f-ctrl rmm">
                            <?php for($i=0; $i<60; $i++) { echo "<option value=".$i.">$i</option>"; } ?>
                        </select>
                    </td>
                    <td>
                        <input name="todate[]" id="Departuredate${newIndex}"  onchange="validatetodate(this.value,${newIndex})" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" type="date" min="<?php echo date('Y-m-d');?>" class="scs-ctrl Dat rmm" />
                    </td>
                    <td>
                        <select name="THr[]" id="THr${newIndex}" class="f-ctrl rmm">
                            <?php for($i=0; $i<24; $i++) { echo "<option value=".$i.">$i</option>"; } ?>
                        </select>
                    </td>
                    <td>
                        <select name="TMi[]" id="TMi${newIndex}" class="f-ctrl rmm">
                            <?php for($i=0; $i<60; $i++) { echo "<option value=".$i.">$i</option>"; } ?>
                        </select>
                    </td>
                    <td>
                        <select onchange="gettarriff(this.value, ${newIndex})" name="Adults[]" id="Adult${newIndex}" class="f-ctrl rmm">
                            <option value="0">0</option>
                        </select>
                    </td>
                    <td>
                        <input name="Child[]" id="Child${newIndex}" value="1" class="f-ctrl rmm" />
                    </td>
                    <td>
                        <select name="RateCode[]" id="Ratetype${newIndex}" class="f-ctrl rmm">
                            <option value="">Select Rate type</option>
                            <?php
                            $Res=$this->Myclass->RatePlan(0);
                            foreach($Res as $row){
                                echo "<option value=".$row['RatePlan_Id'].">".$row['RC']."</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input name="Tariff[]" id="Tariff${newIndex}" value="" class="f-ctrl rmm" />
                    </td>
                    <td>
                        <select name="foodplan[]" id="foodplan${newIndex}" class="f-ctrl rmm">
                            <option value="0">Select Plan</option>
                            <?php 
                            $qry="select * from Mas_FoodPlan"; 
                            $res=$this->db->query($qry); 
                            foreach ($res->result_array() as $row){
                                echo "<option value=".$row['FoodPlan_Id'].">".$row['ShortName']."</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <div style="width:50%; float: left" id="${newIndex}" class="remove_field">
                            <i class="fa fa-2x fa-minus-square"></i>
                        </div>
                        <div style="width:50%; padding-left:5px; float: right" id="${newIndex}" class="add_field_button">
                            <i class="fa fa-2x fa-check-square"></i>
                        </div>
                    </td>
                </tr>
            `);

            // Update row count
            document.getElementById("count").value = newIndex;

            // Trigger room availability check for the new row
            var roomTypeId = $("#Roomtype" + newIndex).val();
            var fromDate = $("#Arrivaldate" + newIndex).val();
            var noOfRooms = $("#noofrooms" + newIndex).val();
            // checkRoomAvailability(roomTypeId, noOfRooms, newIndex, fromDate);
        }
    });

	$(wrapper).on("click", ".remove_field", function (e) {
        e.preventDefault();

        let rowId = $(this).attr("id");
        $('#tb' + rowId).remove();

        // Reindex rows and IDs
        $(".tb").each(function(index) {
            let newIndex = index + 1;
            $(this).attr('id', 'tb' + newIndex);
            $(this).find("input, select").each(function() {
                let id = $(this).attr('id');
                if (id) {
                    $(this).attr('id', id.replace(/\d+$/, newIndex));
                }
            });
        });

        // Update the row count
        document.getElementById("count").value = $(".tb").length;
    });
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
	 if(status == 'TENTATIVE'){
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
	    // var todayDate = new Date(leastdate).toISOString().slice(0, 10);
		// document.getElementById("datevalue").style.display = "block"
		// document.getElementById("datevalue").max = todayDate

        var currentdate = new Date();

        var currentdate = new Date();

// Format it to YYYY-MM-DD
var formattedDate = currentdate.toISOString().slice(0, 10);


        
        
		document.getElementById("datevalue").style.display = "block";
		document.getElementById("datevaluetd").style.display = "block";
        document.getElementById("datevalue").max = currentdate;
	    // alert(todayDate)
		document.getElementById("datevaluetd").style.display = "block"
        document.getElementById("datevalue").value = formattedDate;
	 }else{
		document.getElementById("datevalue").style.display = "none"
		document.getElementById("datevaluetd").style.display = "none"
        document.getElementById("datevalue").value = currentdate;
	 }
	 

})
</SCRIPT>


<script>




    let counts = Number(document.getElementById("count").value);
    let isValid = true;
    let lastRoomTypeId = null;

    for (let i = 1; i <= counts; i++) {
        if (document.getElementById("Roomtype" + i)) {
            let roomtype = document.getElementById("Roomtype" + i).value;
            let foodplan = document.getElementById("foodplan" + i).value;
            let Tariff = document.getElementById("Tariff" + i).value;
            let Adults = document.getElementById("Adult" + i).value;
            let noofrooms = document.getElementById("noofrooms" + i).value;

            if (roomtype == "" || roomtype == 0) {
                alert("Select Room Type");
                return;
            }

			if (noofrooms == 0 || noofrooms == "") {
                alert("Select No Of Rooms ");
                return;
            }

            if (Adults == 0 || Adults === "") {
                alert("Select Pax ");
                return;
            }

            if (foodplan == 0 || foodplan === "") {
                alert("Select Food Plan");
                return;
            }

            if (Tariff == 0 || Tariff === "") {
                alert("Enter Tariff");
                return;
            }

            lastRoomTypeId = roomtype;
        }
    }

    let values = [];
    $('input[name="noofrooms[]"]').each(function () {
        values.push(parseInt($(this).val()));
    });

    let totalRooms = values[values.length - 1];
    let x = Number(document.getElementById("count").value);
    let max_fields = 10;

    $.ajax({
        type: 'POST',
        url: "<?php echo scs_index ?>Transaction/reserve_amend_validation",
        data: {
            rooms: totalRooms,
            roomtypeid: lastRoomTypeId
        },
        success: function (response) {
            let availableRooms = response;

            if (totalRooms > availableRooms) {
				// alert(availableRooms);
                alert("Sorry! You have only " + availableRooms + " rooms available");
            
            } 
        },
        error: function (xhr, status, error) {
            alert("AJAX Error: " + error);
        }
    });


</script>
	
	
	<script>
         $(document).ready(function () {
          
        var resstatus = document.getElementById("ReservationMode").value;
       
if(resstatus === 'TENTATIVE'){

    var currentdate = new Date();
		document.getElementById("datevalue").style.display = "block";
		document.getElementById("datevaluetd").style.display = "block";
        document.getElementById("datevalue").max = currentdate;
     
}else{
    document.getElementById("datevalue").style.display = "none";
		document.getElementById("datevaluetd").style.display = "none";
		document.getElementById("datevalue").value = currentdate;
        // document.getElementById("datevalue").max = currentdate;
}
         });
    </script>
	


	
	