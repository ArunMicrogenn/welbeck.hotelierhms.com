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
$this->pfrm->FrmHead2('Transaction/ Reservation',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>
    
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$PlanType_Id; ?>" >
       <input type="hidden" name="Keey" id="Keey" value="<?php echo @$Keey; ?>" >
      <table class="FrmTable T-3" >
        <tr>
          <td style="text-align: right;" class="F_val">Reservation No</td>
          <td align="left"> 
              <?php
          $Res=$this->Myclass->Get_ResNo();
		  foreach($Res as $row)
			{
			    $resnumber= $row['number'];
			}
		  ?> <input type="text" readonly name="Resnumber" id="Resnumber" value=<?php echo $resnumber; ?> >
            <div class="RoomType_Id" ></div></td>
        
        </tr>
        </table>
        
           <table width="100%" class="mytable" style="margin-top:20px">
              <thead>
				<tr>
				<th>S.No</th>
				<th>Room Type</th>
				<th>Arrival Date</th>
				<th colspan="2" style="width: 150px;">Arrival Time</th>
				<th>Departure Date</th>
				<th colspan="2" style="width: 150px;">Departure Time</th>
				<th>Room No</th>
				<th>Adult</th>
				<th>Child</th>
				<th>Rate Type</th>		
				<th>Tariff</th>
				<th>Plan</th>
				<th>Action</th>
				</tr>
			  </thead>
				<tbody  class="input_fields_wrap">
				<tr id="tb1">
				<td style="text-align:center"><input style="text-align: center;" class="scs-ctrl" type="text" name="ID[]" id="ID1" value='1'></td>                                      
				<td> 
				  <select onchange="Roomvalidate(this.value)" name="Roomtype[]" id="Roomtype1" class="f-ctrl rmm">
				  <option value="">Select Room type</option>
			      <?php 
			      $Res=$this->Myclass->RoomType(0);
    		      foreach($Res as $row)
			      {
				   echo "<option value=".$row['RoomType_Id'].">".$row['RoomType']."</option>";
			      }	?>
			      </select></td> 
                <td><input name="Arrivaldate[]" id="Arrivaldate1" onchange="validatefromtime(this.value)" value="" type="text"  class="scs-ctrl Dat rmm" /></td>
		        <td><select name="FHr[]" id="FHr1" class="f-ctrl rmm">
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
		        <td><input name="Departuredate[]" id="Departuredate1" value="" type="text"  class="scs-ctrl Dat rmm" /></td>
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
              <td> <select name="RoomNo[]" id="RoomNo1" class="f-ctrl rmm">
		          <option value=''>Select Room Number</option>
			      </select>
			  </td>
		      <td><select onchange="gettarriff(this.value)" name="Adult[]" id="Adult1" class="f-ctrl rmm">
			  <option value='0'>0</option>
			  </select></td>
		      <td><input name="Child[]" id="Child1" value=""  num=1 class="f-ctrl rmm"  /></td>				
              <td> <select name="Ratetype[]" id="Ratetype1" class="f-ctrl rmm">
		        <option value=''>Select Rate type</option>
			   
		        </select>
			   </td>      
              <td><input name="Tariff[]" id="Tariff1" value=""  num=1 class="f-ctrl rmm"  /></td>
		      <td><select name="foodplan[]" class="f-ctrl rmm"><option value="0">Select Plan</option>
		       <?php
		       $qry="select * from Mas_FoodPlan";
		       $res=$this->db->query($qry);
		       foreach ($res->result_array() as $row)
		       { echo "<option value=".$row['FoodPlan_Id'].">".$row['FoodPlan']."</option>";			   }
		       ?>
		       <select></td>	                                     
               <td><a href="" id="1" class="add_field_button"><i class="fa fa-2x fa-check-square"></i></a><a href="" style="display:none" class="add_field_button1"><i class="fa fa-2x fa-check-square"></i></a></td>
               </tr>
               </tbody>
              </table>  
    
		<br>
		<table class="FrmTable T-10" >
       <tr>
	   <td style="text-align: right;">Mobile</td>
	   <td><input type="text"  num=1 Placeholder="+91-19865999" name="mobile" id="mobile"  class="f-ctrl rmm">
	        <div class="mobile" ></div></td>
	   <td style="text-align: right;">Name<td>
	   <td><input type="text" id="Name" name="Name" class="f-ctrl rmm"><div class="Name"></div> <td>
	   <td style="text-align: right;">Email<td>
	   <td><input type="text" id="Email" name="Email" class="f-ctrl rmm">  <td>
	   <td style="text-align: right;">City<td>
	   <td><input type="text" id="City" name="City" class="f-ctrl rmm"> <div class="City"></div><td>
	   </tr>
	   </table>
	   <br>
	   <table class="FrmTable T-10" >
	   <tr>
	    <td style="text-align: right;">Guest Status</td>
		<td style="text-align: left;">
		  <select name="GuestStatus" id="GuestStatus" class="f-ctrl rmm"><option>Select Ststus</option>
		  <?php 
			      $Res=$this->Myclass->GuestStatus(0);
    		      foreach($Res as $row)
			      {
				   echo "<option value=".$row['GuestStatus_Id'].">".$row['GuestStatus']."</option>";
			}	?>
		  </select></td>
		<td style="text-align: right;">Reservation Mode</td>
		<td style="text-align: left;">
		  <select id="ReservationMode" name="ReservationMode" class="f-ctrl rmm"><option>Select Ststus</option>
		  <?php 
			      $Res=$this->Myclass->ReservationMode(0);
    		      foreach($Res as $row)
			      {
				   echo "<option value=".$row['ReservationMode_Id'].">".$row['ReservationMode']."</option>";
			}	?>
		  </select></td>
		<td style="text-align: right;">Guest Type</td>
		<td style="text-align: left;">
		  <select  name="GuestType" id="GuestType" class="f-ctrl rmm"><option>Select Ststus</option>
		  <?php 
			      $Res=$this->Myclass->GuestType(0);
    		      foreach($Res as $row)
			      {
				   echo "<option value=".$row['GuestType_Id'].">".$row['GuestType']."</option>";
			}	?>
		  </select></td>
	   </tr>
	    <tr>
		  <td style="text-align: right;">Billing Insturction</td>
		  <td style="text-align: left;">
		    <select name="BillingInsturction" id="BillingInsturction" class="f-ctrl rmm"><option>Select Insturction</option>
			<?php 
			      $Res=$this->Myclass->BillingInstruction(0);
    		      foreach($Res as $row)
			      {
				   echo "<option value=".$row['BillingInstruction_Id'].">".$row['BillingInstruction']."</option>";
			}	?>
			</select> </td>
		  <td style="text-align: right;">Market Segment</td>
		  <td style="text-align: left;">
		    <select name="MarketSegment" id="MarketSegment" class="f-ctrl rmm"><option>Select Market Segment</option>
			<?php 
			      $Res=$this->Myclass->MarketSegment(0);
    		      foreach($Res as $row)
			      {
				   echo "<option value=".$row['MarketSegment_Id'].">".$row['MarketSegment']."</option>";
			}	?>
			</select> </td> 
		  <td style="text-align: right;">Business Source</td>
		  <td style="text-align: left;">
		    <select name="BusinessSource" id="BusinessSource" class="f-ctrl rmm"><option value="">Select Business Source</option>
			<?php 
			      $Res=$this->Myclass->BusinessSource(0);
    		      foreach($Res as $row)
			      {
				   echo "<option value=".$row['BusinessSource_Id'].">".$row['BusinessSource']."</option>";
			}	?>
			</select> </td>
		</tr>
		<tr>
		<td style="text-align: right;">Company Name</td>
		  <td style="text-align: left;">
		    <select name="Company" id="Company" class="f-ctrl rmm"><option value="">Select Company</option>
			<?php 
			      $qry="select * from Mas_Company cm
		         inner join Mas_CompanyType ct on ct.CompanyType_Id=cm.CompanyType_Id where CompanyType !='Travel Agent'";
				  $Res=$this->db->query($qry);
    		      foreach ($Res->result_array() as $row)
	              { 
				   echo "<option value=".$row['Company_Id'].">".$row['Company']."</option>";
			}	?>
			</select> </td>
		
		<td style="text-align: right;">Travel Agent</td>
		  <td style="text-align: left;">
		    <select name="TravelAgent" id="TravelAgent" class="f-ctrl rmm"><option value="">Select Travel Agent</option>
			<?php 
			     $qry="select * from Mas_Company cm
		         inner join Mas_CompanyType ct on ct.CompanyType_Id=cm.CompanyType_Id where CompanyType ='Travel Agent'";
				  $Res=$this->db->query($qry);
    		      foreach ($Res->result_array() as $row)
	              { 
				   echo "<option value=".$row['Company_Id'].">".$row['Company']."</option>";
			}	?>
			</select> </td>
		  <td style="text-align: right;">Booking Id</td>
		  <td style="text-align: left;">
		  <input type="Text" name="bookingid" id="bookingid" class="f-ctrl rmm">
		  </td>
		</tr>
		<tr>
		<td style="text-align: right;">Tariff Discount %</td>
		  <td style="text-align: left;">
		  
		  <input type="text"  num=1 name="TariffDiscountper" id="TariffDiscountper"  class="f-ctrl rmm" >
		  </td>
	      <td style="text-align: right;">Tariff Discount Amount</td>
		  <td style="text-align: left;">
		  <input type="text"  num=1 name="TariffDiscountamt" id="TariffDiscountamt"  class="f-ctrl rmm" >
		  </td>
		</tr>
		<tr>
		<td style="text-align: right;">Plan Discount %</td>
		  <td style="text-align: left;">
		  <input type="text"  num=1 name="PlanDiscountper" id="PlanDiscountper"  class="f-ctrl rmm" >
		  </td>
	      <td style="text-align: right;">Plan Discount Amont</td>
		  <td style="text-align: left;">
		  <input type="text"  num=1 name="PlanDiscountamt" id="PlanDiscountamt"  class="f-ctrl rmm" >
		  </td>
		</tr>
		</table>
        <div style="margin-top:15px;" align="right">
        <input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   />
      </div>
    </fieldset>
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
<SCRIPT language="javascript">

var d = new Date(); // for now
var h =d.getHours(); // => 9
var s =d.getMinutes(); // =>  30
document.getElementById("FHr1").disabled = true;
document.getElementById("FMi1").disabled = true;
$('#FHr1').val(h);
$('#FMi1').val(s);
$('#THr1').val(h);
$('#TMi1').val(s);
	 var x = 1; 
function validatefromtime(a)
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
	     document.getElementById("FHr1").disabled = true;
		 document.getElementById("FMi1").disabled = true;	
	}
 }
 function Roomvalidate(a)
 {
	    $.ajax({
            url: "<?php echo scs_index ?>Transaction/roomtypegetroomnumber?type="+a,
            type: 'POST',
            success: function (data) {
                $('#RoomNo'+x).empty();
                $('#RoomNo'+x).append(data);
		    }
			
        });   
		$.ajax({
            url: "<?php echo scs_index ?>Transaction/roomtypegetPlanid?type="+a,
            type: 'POST',
            success: function (data) {
                $('#Ratetype'+x).empty();
                $('#Ratetype'+x).append(data);
		    }
			
        }); 
		$.ajax({
            url: "<?php echo scs_index ?>Transaction/roomtypegetadults?type="+a,
            type: 'POST',
            success: function (data) {
                $('#Adult'+x).empty();
                $('#Adult'+x).append(data);
		    }
			
        });    
 }
 function gettarriff(a)
 {
	var Roomtype =document.getElementById("Roomtype"+x).value;
	$.ajax({
            url: "<?php echo scs_index ?>Transaction/roomtypegettariff?type="+Roomtype+"&pax="+a,
            type: 'POST',
            success: function (data) {
               	 $('#Tariff'+x).val(data);	
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
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            
             var b_id=$(this).attr("id")                                               
            $('#tb'+b_id+'').after('<tr id="tb'+x+'"><td style="text-align:center"><input style="text-align: center;" type="text" class="scs-ctrl" name="ID[]" id="ID'+x+'" value="'+x+'"></td><td><select onchange="Roomvalidate(this.value)" name="Roomtype[]" id="Roomtype'+x+'" class="f-ctrl rmm"> <option value="">Select Room type</option><?php  $Res=$this->Myclass->RoomType(0); foreach($Res as $row){ echo "<option value=".$row['RoomType_Id'].">".$row['RoomType']."</option>";	}?> </select> </td>	<td><input name="Arrivaldate[]" id="Arrivaldate'+x+'" onchange="validatefromtime(this.value)" value="" type="date"  class="scs-ctrl Dat rmm" /></td> <td><select name="FHr[]" id="FHr'+x+'" class="f-ctrl rmm"><?php for($i=0;$i<24;$i++) { echo "<option value=".$i." >$i</option>"; } ?> </select> </td><td> <select name="FMi[]" id="FMi'+x+'" class="f-ctrl rmm"> <?php   for($i=0;$i<60;$i++){    echo "<option value=".$i." >$i</option>"; } ?></select></td> <td><input name="Departuredate[]" id="Departuredate'+x+'" value="" type="text"  class="scs-ctrl Dat rmm" /></td><td><select name="THr[]" id="THr'+x+'" class="f-ctrl rmm">  <?php  for($i=0;$i<24;$i++) {  echo "<option value=".$i." >$i</option>"; }  ?> </select></td> <td><select name="TMi[]" id="TMi'+x+'" class="f-ctrl rmm"><?php for($i=0;$i<60;$i++){  echo "<option value=".$i." >$i</option>";  }?> </select></td>	<td> <select name="RoomNo[]" id="RoomNo'+x+'" class="f-ctrl rmm">  <option value="">Select Room Number</option> <?php $Res=$this->Myclass->Room(0);  foreach($Res as $row) { echo "<option value=".$row['Room_Id'].">".$row['RoomNo']."</option>";  }?>  </select></td> <td><select onchange="gettarriff(this.value)" name="Adult[]" id="Adult'+x+'" value=""  class="f-ctrl rmm" ><option values="0">0</option</select></td>  <td><input name="Child[]" id="Child'+x+'" value=""  num=1 class="f-ctrl rmm"  /></td><td> <select name="Ratetype[]" id="Ratetype'+x+'" class="f-ctrl rmm"> <option value="">Select Rate type</option>  <?php $Res=$this->Myclass->RatePlan(0); foreach($Res as $row) { echo "<option value=".$row['RatePlan_Id'].">".$row['RC']."</option>";   }	?> </select> </td> <td><input name="Tariff[]" id="Tariff'+x+'" value=""  num=1 class="f-ctrl rmm"  /></td>  <td><select name="foodplan[]" id="foodplan'+x+'" class="f-ctrl rmm"><option value="0">Select Plan</option> <?php $qry="select * from Mas_FoodPlan"; $res=$this->db->query($qry); foreach ($res->result_array() as $row){ echo "<option value=".$row['FoodPlan_Id'].">".$row['FoodPlan']."</option>";	} ?><select></td><td><div style="width:50%; float: left" id='+x+' class="remove_field"><i class="fa fa-2x fa-minus-square"></i></div><div style="width:50%; padding-left:5px; float: right"  id='+x+' class="add_field_button"><i class="fa fa-2x fa-check-square"></i></div></td></tr>');
        
                      
           }
		    var d = new Date(); // for now
			var h =d.getHours(); // => 9
			var s =d.getMinutes(); // =>  30
			document.getElementById("FHr1").disabled = true;
			document.getElementById("FMi1").disabled = true;
			$('#FHr'+x).val(h);
			$('#FMi'+x).val(s);
			$('#THr'+x).val(h);
			$('#TMi'+x).val(s);
    });
      
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        var b_id=$(this).attr("id");                                          
        $('#tb'+b_id+'').remove();        

    })
});


	</SCRIPT>
	
	