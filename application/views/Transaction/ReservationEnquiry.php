<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Reservation Enquiry');
$this->pfrm->FrmHead3('Transaction/ ReservationEnquiry',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>


<?php 
$qury = "select * from usertable where User_id='".User_id."' ";
$op = $this->db->query($qury);
foreach($op -> result_array() as $row){
	$percent = $row['disper'];
	$disamount = $row['disAmount'];
}

$year = "select dbo.YearPrefix() as id";
$res = $this->db->query($year);
foreach($res->result_array() as $r){
  $yearPrefix= $r['id'];
}
?>
<div class="col-sm-12" style="color:black;">
  <div class="the-box F_ram">
	<form id="reserveform" method="POST" action='<?php echo scs_index ?>Transaction/Reservation_save'>
    <fieldset>
        <table class="FrmTable T-3" >
			<tr>
			<td style="text-align: right;" class="F_val">Reservation No</td>
			<td align="left">
                <?php 
                    $sql = "select dbo.ResEnq() as reserveno";
                    $ex = $this->db->query($sql);
                    foreach($ex->result_array() as $row){
                        $reserveno = $row['reserveno'];
                    }
                ?>
				 <input type="hidden" readonly   name="resno" value="<?php echo $reserveno;?>" class="f-ctrl rmm"><div class="Name"> 
            <input type="text" id="resno" readonly   value="<?php echo $yearPrefix.'/'.$reserveno;?>" class="f-ctrl rmm"><div class="Name"> 
			<div class="ResNo" ></div></td>
			</tr>
	    </table>

		<table id="mytable" width="100%" class="mytable" style="margin-top:20px">
			<thead>
			<tr>
			<th>S.No</th>
			<th>Room Type</th>
			<th>No of rooms</th>
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
			<tbody  class="input_fields_wrap">
			<tr id="tb1" class="tb">
			<input type="hidden"  num=1 name="bookingid" id="bookingid"  value="" class="f-ctrl rmm" >
			<input type="hidden"  num=1 name="Roomid" id="Roomid"  value="" class="f-ctrl rmm" >
			<input type="hidden"  num=1 name="roomcount" id="roomcount"  value="1" class="f-ctrl rmm" >
			<td style="text-align:center"><input style="text-align: center;" class="scs-ctrl" type="text" name="ID[]" id="ID1" value='1'></td>                                      
			<td> 
				<select onchange="Roomvalidate(this.value,'1')" name="Roomtype_id[]" id="Roomtype1" class="f-ctrl rmm">
				<option value="0">Select Room type</option>
				<?php 
				$Res=$this->Myclass->RoomType(0);
				foreach($Res as $row)
				{
				?>
				<option   value="<?php echo $row['RoomType_Id']; ?>"><?php echo $row['RoomType'] ?></option>
				<?php }	?>
				</select></td> 
				<td><input id="noofrooms1"  name="noofrooms[]"  value = "1" onkeyup="noRooms(this.value)"  type="number" min="1" max="10"  class="scs-ctrl rmm" /></td>
			<td><input 
				id="Arrivaldate1"  name="Indate[]"  class="arrival" onchange="validatefromtime(this.value,'1')" value="<?php echo date("Y-m-d");?>" type="date"  min="<?php echo date('Y-m-d'); ?>"class="scs-ctrl  rmm" /></td>
			<td><select name="FHr[]" id="FHr1" class="f-ctrl rmm" onchange="validatetime(this.value, '1')">
				<?php
				for($i=0;$i<24;$i++)
				{
				echo '<option value="'.$i.'" >'.$i.'</option>';
				}
				?>
				</select>
			</td>	
			<td> <select name="FMi[]" id="FMi1" class="f-ctrl rmm">
				<?php   for($i=0;$i<60;$i++)
				{
				echo '<option value="'.$i.'" >'.$i.'</option>';
				}
				?></select>
			</td>
			<td><input name="todate[]" id="Departuredate1" value="<?php echo date("Y-m-d", strtotime(' +1 day'));?>" type="date" min="<?php echo date("Y-m-d");?>" class="scs-ctrl rmm" /></td>
			<td><select name="THr[]" id="THr1" class="f-ctrl rmm">
				<?php
				for($i=0;$i<24;$i++)
				{
				echo '<option value="'.$i.'" >'.$i.'</option>';
				}  ?>
				</select>	
			</td>
			<td><select name="TMi[]" id="TMi1" class="f-ctrl rmm">
				<?php
				for($i=0;$i<60;$i++)
				{
				echo '<option value="'.$i.'" >'.$i.'</option>';
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
			<td><select onchange="gettarriff(this.value, '1')" name="Adults[]" id="Adult1" class="f-ctrl rmm">
			<option value='0'>0</option>
			</select></td>
			<td><input name="Child[]" id="Child1" value="0" maxlength="1" num=1 class="f-ctrl rmm"  /></td>				
			<td> <select name="RateCode[]" id="Ratetype1" class="f-ctrl rmm">
			<?php 
				$sql = "select * from mas_plantype";
				$ex= $this->db->query($sql);
				foreach($ex->result_array() as $row){
			?>
				<option value='<?php echo $row['PlanType_Id']?>'><?php echo $row['RateCode']?></option>
				<?php } ?>
			</select>
			</td>      
			<td><input name="Tariff[]" id="Tariff1" readonly  value=""   num=1 class="f-ctrl rmm"  /></td>
			<td><select name="foodplan[]" id="foodplan1" class="f-ctrl rmm"><option value="0">Select Plan</option>
			<?php
			$qry="select * from Mas_FoodPlan";
			$res=$this->db->query($qry);
			foreach ($res->result_array() as $row)
			{ ?>
			<option 
			 value="<?php echo $row['FoodPlan_Id']; ?>" ><?php echo $row['ShortName']?></option>			   
			<?php }?>
			<select></td>	                                     
			<td><a href="" id="1" class="add_field_button"><i class="fa fa-2x fa-check-square"></i></a><a href="" style="display:none" class="add_field_button1"><i class="fa fa-2x fa-check-square"></i></a></td>
			</tr>
			<input type="hidden" value="1" id="count" name="rowcount">
			</tbody>
			</table>  
			<br>
			<table class="FrmTable T-10" >
			<tr>

			<td style="text-align: right;">Title</td>
			<td style="text-align: left;">
			<select id="Title" name="Title"  class="f-ctrl rmm">
				<?php 
				  echo $ti = "select * from mas_title";
				  $execc = $this->db->query($ti);
				  foreach($execc->result_array() as $tii){
				?>
				<option value="<?php echo $tii['Titleid']?>"><?php echo $tii['Title'] ?></option>
				<?php } ?>
				</select>
			</td>

			<td style="text-align: right;">Name</td>
			<td style="text-align: left;">
			<input type="text"    name="Firstname" id="Firstname" value="" class="f-ctrl rmm">
			</td>
			

			<td style="text-align: right;">Email</td>
			<td style="text-align: left;">
			<input type="text"    name="Email" id="Email" value="" class="f-ctrl rmm">
			</td>
			
			</tr>
			<tr>	
			</tr>

			<tr>
	
			<td style="text-align: right;">Mobile</td>
			<td style="text-align: left;">
			<input type="text"  oninput="this.value = this.value.replace(/[^0-9$?>.]/g, '').replace(/(\..*)\./g, '$1');"  maxlength="10" Placeholder="919865999" name="Mobile" id="Mobile"   class="f-ctrl rmm">
			</td>
			
			<td style="text-align: right;">Address</td>
			<td style="text-align: left;">
			<input type="text"    name="Address" id="Address" value="" class="f-ctrl rmm">
			</td>
			<td style="text-align: right;">Pincode</td>
			<td style="text-align: left;">
			<input type="text" id="Pincode" oninput="this.value = this.value.replace(/[^0-9$?>.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="6" name="Pincode" value = '' class="f-ctrl rmm">
			</td>
			</tr>
			<tr>
			<td style="text-align: right;">Company</td>
				<td style="text-align: left;">
				
				<select name="CompanyId" id="Company" class="f-ctrl rmm"><option value="">Select Company</option>
				<?php 
						$qry="select * from Mas_Company cm
						inner join Mas_CompanyType ct on ct.CompanyType_Id=cm.CompanyType_Id where CompanyType !='Travel Agent'";
						$Res=$this->db->query($qry);
						foreach ($Res->result_array() as $row)
						{ 
						?>
						<option  value="<?php echo $row['Company_Id'] ?>"><?php echo $row['Company'] ?></option>
			<?php 	}	?>
				</select> </td>
				<td style="text-align: right;">City</td>
				<td style="text-align: left;">
				<input type="hidden" id="City_id" name="City_id" value = '' class="f-ctrl rmm">
				<input type="text" id="City" name="City"  value="" class="f-ctrl rmm">
				</td>
				<td style="text-align: right;">Phone</td>
				<td style="text-align: left;">
				<input type="text" id="phone" name="Phone" oninput="this.value = this.value.replace(/[^0-9$?>.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="12" Placeholder="0422-2222" value = '' class="f-ctrl rmm">
				
				</td>
			</tr>
			<tr>
			<td style="text-align: right;">Enq.Date</td>
				<td style="text-align: left;">
				<input type="date" id="Enqdate" name="Enqdate" max="<?php echo date('Y-m-d');?>" value="<?php echo date('Y-m-d');?>" min="<?php echo date('Y-m-d');?>" class="f-ctrl rmm">
			</td>
			<td style="text-align: right;">Age</td>
				<td style="text-align: left;">
				<input type="text" id="Age" name="Age" oninput="this.value = this.value.replace(/[^0-9$?>.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="2" value = '' class="f-ctrl rmm">
				
			</td>
			<td style="text-align: right;">Remarks</td>
				<td style="text-align: left;">
				<input type="text" id="remarks" name="Remarks" value = '' class="f-ctrl rmm">
				
			</td>
			
			</tr>
			<tr>
			<td style="text-align: right;">Contact Person</td>
				<td style="text-align: left;">
				<input type="text" id="ConPerson" onkeydown="return /[a-z]/i.test(event.key)" name="ConPerson" value = '' class="f-ctrl rmm">
				
			</td>
			<td style="text-align: right;"></td>
				<td style="text-align: left;">
				<input type="button"  onclick="Reserve()" class="btn btn-success btn-sm" id="btn" name="btn" value="save"  />
				</td>
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<SCRIPT language="javascript">

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
			 $("#Mobile").val(ui.item.Mobile);
			 $("#Title").val(ui.item.Title);
			 $("#Email").val(ui.item.Email_ID);
			 $("#Firstname").val(ui.item.Firstname);
			 $("#City_id").val(ui.item.Cityid);
			 $("#City").val(ui.item.City);
			 $("#Address").val(ui.item.HomeAddress1);
			 $("#pincode").val(ui.item.Homepincode);
			 $("#phone").val(ui.item.ResidentialPhone);
			 $("#Age").val(ui.item.age);
			
			
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
				$("#Mobile").val(ui.item.Mobile);
			 $("#Title").val(ui.item.Title);
			 $("#Email").val(ui.item.Email_ID);
			 $("#Firstname").val(ui.item.Firstname);
			 $("#City_id").val(ui.item.Cityid);
			 $("#City").val(ui.item.City);
			 $("#Address").val(ui.item.HomeAddress1);
			 $("#Pincode").val(ui.item.Homepincode);
			 $("#phone").val(ui.item.ResidentialPhone);
			 $("#Age").val(ui.item.age);
         }
     });

     
	 function Reserve()
	{
		const counts = document.getElementById("count").value;
	for(let i = 1; i<=counts; i++){
	var Mobile=document.getElementById("Mobile").value;
	var Firstname=document.getElementById("Firstname").value;  
	var Email_ID=document.getElementById("Email").value;
	var City=document.getElementById("City").value;
	var Address=document.getElementById("Address").value; 
	var Pincode=document.getElementById("Pincode").value;
	var roomtype=document.getElementById("Roomtype"+i).value;
	var Indate=document.getElementById("Arrivaldate"+i).value;
	var Adults=document.getElementById("Adult"+i).value;
	var Child=document.getElementById("Child"+i).value;
	var RateCode=document.getElementById("Ratetype"+i).value;
	var foodplan=document.getElementById("foodplan"+i).value;
	var Tariff=document.getElementById("Tariff"+i).value;
	

	if(Firstname =='')
	{ alert('Guest Name Empty'); 
		return; }
	
	if(Email_ID =='')
	{ alert('Email ID Empty'); 
		return; }

	if(Mobile=='')
	{ alert('Mobile Number Empty'); 
		return; }
	if(Address =='')
	{ alert('Enter Address'); 
		return; }
	if(Pincode =='')
	{ alert('Enter Pincode'); 
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
	if(foodplan == 0){
		alert('select food plan')
		return
	}
   }

	// document.getElementById("reserveform").submit();
    $.ajax({
      type: 'post',
      url: '<?php echo scs_index ?>Transaction/ReservationEnquiry_save',
      data: $('#reserveform').serialize(),
      success: function (result) {
        if(result =='success')		
      {
        swal("Success...!", "Reservation Enquiry Save Successfully...!", "success")
        .then(function() {
			window.location.href='<?php echo scs_index?>Transaction/ReservationEnquiry';	

          });
      }
      else
      {
        swal("Faild...!", "Reservation Enquiry Save Faild...!", "error")
        .then(function() {
            window.location.href='<?php echo scs_index?>Transaction/ReservationEnquiry';		
          });
      }
    
    }
  });
	
	}
</script>

<script>
var d = new Date(); // for now
var h =d.getHours(); // => 9
var s =d.getMinutes(); // =>  30
// document.getElementById("FHr1").disabled = true;
// document.getElementById("FMi1").disabled = true;
$('#FHr1').val(h);
$('#FMi1').val(s);
$('#THr1').val(h);
$('#TMi1').val(s);
	 var x = 1; 
function validatefromtime(a, b)
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
 function Roomvalidate(a, b)
 {
	

	let rcount = $('#mytable .tb').length
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
			if(Adults == 0){
				alert("select pax")
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
			
		 }
        if(x < max_fields){ //max input box allowed
            x++; //text box increment

             var b_id=$(this).attr("id")                                               
            $('#tb'+b_id+'').after('<tr class="tb" id="tb'+x+'"><td style="text-align:center"><input style="text-align: center;" type="text" class="scs-ctrl" name="ID[]" id="ID'+x+'" value="'+x+'"></td><td><select onchange="Roomvalidate(this.value, '+x+')" name="Roomtype_id[]" id="Roomtype'+x+'" class="f-ctrl rmm"> <option value="">Select Room type</option><?php  $Res=$this->Myclass->RoomType(0); foreach($Res as $row){ echo "<option value=".$row['RoomType_Id'].">".$row['RoomType']."</option>";	}?> </select> </td><td><input id="noofrooms'+x+'" onkeyup="noRooms(this.value)" name="noofrooms[]"  value="1" type="number" min="1" max="10"  class="scs-ctrl rmm" /></td>		<td><input name="Indate[]" id="Arrivaldate'+x+'" class="arrival" onchange="validatefromtime(this.value, '+x+')" value="<?php echo date("Y-m-d");?>" type="date" min="<?php echo date("Y-m-d");?>" class="scs-ctrl Dat rmm" /></td> <td><select name="FHr[]" id="FHr'+x+'" onchange = "validatetime(this.value, '+x+')" class="f-ctrl rmm"><?php for($i=0;$i<24;$i++) { echo "<option value=".$i." >$i</option>"; } ?> </select> </td><td> <select name="FMi[]" id="FMi'+x+'" class="f-ctrl rmm"> <?php   for($i=0;$i<60;$i++){    echo "<option value=".$i." >$i</option>"; } ?></select></td> <td><input name="todate[]" id="Departuredate'+x+'" value="<?php echo date("Y-m-d", strtotime(' +1 day')); ?>" type="date" min="<?php echo date('Y-m-d');?>" class="scs-ctrl Dat rmm" /></td><td><select name="THr[]" id="THr'+x+'" class="f-ctrl rmm">  <?php  for($i=0;$i<24;$i++) {  echo "<option value=".$i." >$i</option>"; }  ?> </select></td> <td><select name="TMi[]" id="TMi'+x+'" class="f-ctrl rmm"><?php for($i=0;$i<60;$i++){  echo "<option value=".$i." >$i</option>";  }?> </select></td> <td><select onchange="gettarriff(this.value, '+x+')" name="Adults[]" id="Adult'+x+'" value=""  class="f-ctrl rmm" ><option values="0">0</option</select></td>  <td><input name="Child[]" id="Child'+x+'" value=""  num=1 class="f-ctrl rmm"  /></td><td> <select name="RateCode[]" id="Ratetype'+x+'" class="f-ctrl rmm"> <option value="">Select Rate type</option>  <?php $Res=$this->Myclass->RatePlan(0); foreach($Res as $row) { echo "<option value=".$row['RatePlan_Id'].">".$row['RC']."</option>";   }	?> </select> </td> <td><input name="Tariff[]" id="Tariff'+x+'" value=""  num=1 class="f-ctrl rmm"  /></td>  <td><select name="foodplan[]" id="foodplan'+x+'" class="f-ctrl rmm"><option value="0">Select Plan</option> <?php $qry="select * from Mas_FoodPlan"; $res=$this->db->query($qry); foreach ($res->result_array() as $row){ echo "<option value=".$row['FoodPlan_Id'].">".$row['ShortName']."</option>";	} ?><select></td><td><div style="width:50%; float: left" id='+x+' class="remove_field"><i class="fa fa-2x fa-minus-square"></i></div><div style="width:50%; padding-left:5px; float: right"  id='+x+' class="add_field_button"><i class="fa fa-2x fa-check-square"></i></div></td></tr>');
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

</SCRIPT>
	
	


	
	