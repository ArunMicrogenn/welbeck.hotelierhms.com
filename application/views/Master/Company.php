<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Company','Company');
$this->pfrm->FrmHead1('Company / Company',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

 <div class="col-sm-12">
  <div class="the-box F_ram">

    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#home">Company Details</a></li>
	  <li><a data-toggle="tab" href="#menu2">Tax Details</a></li>
      <li><a data-toggle="tab" href="#menu1">Other Details</a></li>
    </ul>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <legend>Company Details : -</legend>
      <input type="hidden" name="idv" value="<?php echo @$Company_Id; ?>" >
	  <table class="FrmTable T-12" >
	  <tr>
	   <td align="right" class="F_val">Company</td>
	   <td align="left"><input type="text" placeholder="Company" id="Company" name="Company" value="<?php echo @$Company; ?>" class="scs-ctrl" />
	   <div class="Company" ></div></td>
		
	   <td align="right" class="F_val">Company Shortname</td>
	   <td align="left"><input type="text" placeholder="Company Shortname" id="Company_Shortname" name="Company_Shortname" value="<?php echo @$Company_Shortname; ?>" class="scs-ctrl" />
	   <div class="Company_Shortname" ></div></td>			 
	  </tr>
	  
	  <tr>
	   <td align="right" class="F_val">Address1</td>
   	   <td align="left"><input   type="text" placeholder="Address1" id="Address1" name="Address1" value="<?php echo @$Address1; ?>" class="scs-ctrl " />
	   <div class="Address1" ></div></td>
	   
	   <td align="right" class="F_val">Address2</td>
	   <td align="left"><input   type="text" placeholder="Address2" id="Address2" name="Address2" value="<?php echo @$Address2; ?>" class="scs-ctrl " />
	   <div class="Address2" ></div></td>
	  </tr>
	  
	  <tr>
	   <td align="right" class="F_val">Address3</td>
	   <td align="left"><input   type="text" placeholder="Address3" id="Address3" name="Address3" value="<?php echo @$Address3; ?>" class="scs-ctrl " />
	   <div class="Address3" ></div></td>
	  </tr>
	  
	  <!--tr>
	   <td align="right" class="F_val">Search Location</td>
	   <td colspan="3" align="left"><input type="text" id="autocomplete" placeholder="Search Location" onFocus="geolocate()" class="scs-ctrl" style="background-color:#93CFA8"  />
	   <div class="Search" ></div></td>
	  </tr--->
	  
	  <tr>
	   <td align="right" class="F_val">City</td>
	   <td align="left">
	   <select id="City_id" name="City_id" onchange="getcity(this.value)"  class="scs-ctrl">
              <option value="">Select City</option>
                 <?php  
               $Resqry = "SELECT * FROM mas_city ORDER BY City ASC";
                 $res = $this->db->query($Resqry)->result_array();
           foreach($res as $row) { 
        $selected = ($row['Cityid'] == @$Cityid) ? 'selected' : '';
        echo '<option value="'.$row['Cityid'].'" '.$selected.'>'.$row['City'].'</option>';
             } 
               ?>
          </select>
	   </td>

	   <!-- <input type="Hidden" value="<php echo @$Cityid; ?>" name="City_id" id="City_id"/> -->
		<input hidden   type="text" placeholder="City" id="City" name="City" value="<?php echo @$City; ?>" class="scs-ctrl " />
	   <div class="City_id" ></div>
	   
	   <td align="right" class="F_val">State</td>
	   <td align="left"><input type="Hidden" value="<?php echo @$State_id; ?>"  name="State_id" id="State_id"/>
	   <input   type="text" Readonly placeholder="State" id="State" name="State" value="<?php echo @$State; ?>" class="scs-ctrl " />
	   <div class="State" ></div></td>
	  </tr>
		 
      <tr>
	   <td align="right" class="F_val">Country</td>
	   <td align="left"><input type="Hidden" value="<?php echo @$Country_Id; ?>" name="Country_id" id="Country_id"/>
	   <input Readonly  type="text" placeholder="Country" id="Country" name="Country" value="<?php echo @$Country; ?>" class="scs-ctrl " />
	   <div class="Country" ></div></td>
	
   	   <td align="right" class="F_val">Zipcode</td>
	   <td align="left"><input   type="text" placeholder="Zipcode" maxlength="6" id="Zipcode" name="Zipcode" value="<?php echo @$Zipcode; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="scs-ctrl " />
	   <div class="Zipcode" ></div></td>
	  </tr>
		 
	  <tr>
	   <td align="right" class="F_val">Phoneno</td>
	   <td align="left"><input   type="text" placeholder="Phoneno" id="Phoneno" name="Phoneno" value="<?php echo @$Phoneno; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="scs-ctrl " />
	   <div class="Phoneno" ></div></td>
		
	   <td align="right" class="F_val">Fax</td>
	   <td align="left"><input   type="text" placeholder="Fax" id="Fax" name="Fax" value="<?php echo @$Fax; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="scs-ctrl " />
	   <div class="Fax" ></div></td>
      </tr>
	
  	  <tr>
	   <td align="right" class="F_val">E_mail</td>
	   <td align="left"><input   type="text" placeholder="E_mail" id="E_mail" name="E_mail" value="<?php echo @$E_mail; ?>" class="scs-ctrl " />
	   <div class="E_mail" ></div></td>

	   <?php $bksql = "select * from extraoption";
	         $exbk = $this->db->query($bksql)->row_array() ;?>

			 <?php if($exbk['Enablebooklogic'] == 1) { ?>

	   <td align="right" class="F_val">Hotel Code</td>
	   <td align="left"><input   type="text" placeholder="hotelcode" id="hotelcode" name="hotelcode" value="<?php echo @$hotelcode; ?>" class="scs-ctrl " />
	   <div class="hotelcode" ></div></td>

	   <?php } ?>


        
	   <!-- <td align="right" class="F_val">TravelAgent</td>
	   <td align="left"><input  type="text" placeholder="travelagent" id="travelagent" name="travelagent" value="<?php echo @$travelagent; ?>" class="scs-ctrl " />
	   <div class="travelagent" ></div></td> -->
	  </tr>	


	</table>
		
	 <fieldset>
	  <legend>Company Contact Details : -</legend>
	   <table class="FrmTable T-12" >
        <tr>
		<td align="right" class="F_val">Contact Person</td>
		<td align="left"><input onClick="Travelagent(this.value)"   type="text" placeholder="Contact Person" id="Cotactperson" name="Cotactperson" value="<?php echo @$Cotactperson; ?>" class="scs-ctrl " />
		<div class="Cotactperson" ></div></td>
		<td align="right" class="F_val">Contact Number</td>
		<td align="left"><input   type="text" placeholder="Contact Number" id="Contactno" name="Contactno" value="<?php echo @$Contactno; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="scs-ctrl " />
		<div class="Contactno" ></div></td>
		</tr>
		
		<tr>
		<td align="right" class="F_val">Designation</td>
		<td align="left"><input  type="text" placeholder="Designation" id="Designation" name="Designation" value="<?php echo @$Designation; ?>" class="scs-ctrl " />
		<div class="Designation" ></div></td>	
		<td align="right" class="F_val">Email</td>
		<td align="left"><input   type="mail" placeholder="Email" id="com_email" name="com_email" value="<?php echo @$Conatcat_Email; ?>" class="scs-ctrl " />
		<div class="com_email" ></div></td>	      	  
	    </tr>
		
	    </table>
	 </div>
	 
	 <div id="menu2" class="tab-pane fade">
	 <fieldset>
	 <legend>GST Details : -</legend>
      <table class="FrmTable T-12" >		  
	    <tr>
		 <td align="right" class="F_val">GST Registration Type</td>
		 <td align="left">
		   <select type="text"    id="GstType_Id" name="GstType_Id"   class="scs-ctrl" >
		   <option value="0" >Registered</option>
		   <option value="1" >Un Registered</option>          
		   </select>
		  <div class="GstType_Id" ></div></td>
		  
		 <td align="right" class="F_val">GST Number</td>
		 <td align="left"><input  maxlength="15" type="text" placeholder="GST Number" id="Gstno" name="Gstno" value="<?php echo @$Gstno; ?>" class="scs-ctrl " />
		 <div class="Gstno" ></div></td>
		</tr>
	  </table>
		
	  <fieldset>
	   <legend>Credit Details : -</legend>
		<table class="FrmTable T-12" >
  	     <tr>
		  <td align="right" class="F_val">CreditLimit</td>
		  <td align="left"><input   type="text" placeholder="CreditLimit" num=1 id="CreditLimit" name="CreditLimit" value="<?php echo @$CreditLimit; ?>" class="scs-ctrl " />
		  <div class="CreditLimit" ></div></td>
		  
		  <td align="right" class="F_val">Creditdays</td>
		  <td align="left"><input   type="Number" placeholder="Creditdays" num=1 id="Creditdays" name="Creditdays" value="<?php echo @$Creditdays; ?>" class="scs-ctrl " />
		  <div class="Creditdays" ></div></td>
		 </tr>
		 
		 <tr>
		  <td align="right" class="F_val">Remarks</td>
		  <td align="left"><textarea placeholder="Remarks" id="Remarks" name="Remarks" value="<?php echo @$Remarks; ?>" class="scs-ctrl " ></textarea>
		  <div class="Remarks" ></div></td>
		 </tr>
		</table>
	   <fieldset>
		<legend>Company Type : -</legend>
		 <table class="FrmTable T-12" >
  	      <tr>
		   <td align="right" class="F_val">Company Type</td>
		   <td align="left">
		     <select  type="text"    id="CompanyType_Id" name="CompanyType_Id"   class="scs-ctrl" >
		     <option value="" > -- Select CompanyType -- </option>
			  <?php
			  $Res=$this->Myclass->CompanyType();
			  $count=1;
			   foreach($Res as $row)
				{if($row['Active'] !=1)
				   {
					echo '<option value="'.$row['CompanyType_Id'].'"   	 >'.$row['CompanyType'].'</option>';
				   }
				}
			   ?>
			  </select>
			<div class="CompanyType_Id" ></div></td>

			<td align="right" class="F_val">Ota</td>
	   <td align="left"><input  type="text" placeholder="Ota" id="Ota" name="Ota" value="<?php echo @$Ota; ?>" class="scs-ctrl " />
	   <div class="Ota" ></div></td>
		   </tr>

			
		   <tr>
			<td align="right" class="F_val">Commission %</td>
			<td align="left"><input   type="number" placeholder="Commission %" maxlength="2" max="99" num=1 id="Commissionper" name="Commissionper" value="<?php echo @$ComCommissionper; ?>" class="scs-ctrl " />
			<div class="Commissionper" ></div></td>
			
			<td align="right" class="F_val">Comission TAX %</td>
			<td align="left"><input   type="number" placeholder="Commission TAX %" maxlength="2" max="99" num=1 id="Commissiontaxper" name="Commissiontaxper" value="<?php echo @$ComCommissiontaxper; ?>" class="scs-ctrl " />
			<div class="Commissiontaxper" ></div></td>
		   </tr>
		  
		  <tr>
		    <td align="right" class="F_val">Default Checkin Time</td>
			<td align="left"><input   type="time" placeholder="00:00:00" num=1 id="checkintime" name="checkintime" value="<?php echo substr(@$Com_Checkintime,11,5); ?>" class="scs-ctrl " />
			<div class="Commissionper" ></div></td>
			
			<td align="right" class="F_val">Default Checkout Time</td>
			<td align="left"><input   type="time" placeholder="00:00:00" num=1 id="checkouttime" name="checkouttime" value="<?php echo substr(@$Com_Checkouttime,11,5); ?>" class="scs-ctrl " />
			<div class="Commissiontaxper" ></div></td>
		  </tr>
		</table>
       </div>    
	   <div id="menu1" class="tab-pane fade">
        <fieldset>
		 <legend>Company Bill Printing : -</legend>
		   <table class="FrmTable T-12" >
		    <tr>
		     <td align="left" class="F_val">Company Bill Printing </td>
		     <td align="left">
			  <select type="text"    id="CompanyGroup_Id" name="CompanyGroup_Id"   class="scs-ctrl" >
			  <option selected value="0" > -- Select Company Bill Printing -- </option>
			  <?php
			  $Res=$this->Myclass->CompanyGroup();
			  $count=1;				 
			  foreach($Res as $row)
				{if($row['Active'] !=1)
				   {
					echo '<option value="'.$row['CompanyGroup_Id'].'"   	 >'.$row['CompanyGroup'].'</option>';
				   }
				}
			  ?>
			  </select>
			<div class="CompanyGroup_Id" ></div></td>
		    </tr>
		  </table>
		   </br>
	  <fieldset>
	   <legend>Other Details : -</legend>
	    <table class="FrmTable T-12" >
		 <tr>
		 <td align="right" class="F_val">MarketSegment</td>
		 <td align="left">
		   <select type="text"    id="MarketSegment_Id" name="MarketSegment_Id"   class="scs-ctrl" >
		   <option selected value="0" > -- Select MarketSegment -- </option>
			<?php
			$Res=$this->Myclass->MarketSegment();
			$count=1;
			foreach($Res as $row)
			 { if($row['Active'] !=1)
				   {
				echo '<option value="'.$row['MarketSegment_Id'].'"   	 >'.$row['MarketSegment'].'</option>';
				   }
			 }
			  ?>
			</select>
		  <div class="MarketSegment_Id" ></div></td>
	   
		  <td align="right" class="F_val">BusinessSource</td>
		  <td align="left">
		    <select type="text"    id="BusinessSource_Id" name="BusinessSource_Id"   class="scs-ctrl" >
			<option selected value="0" > -- Select BusinessSource -- </option>
			 <?php
			 $Res=$this->Myclass->BusinessSource();
			 $count=1;
			 foreach($Res as $row)
				{
					if($row['Active'] !=1)
				   {
					echo '<option value="'.$row['BusinessSource_Id'].'"   	 >'.$row['BusinessSource'].'</option>';
				   }
				}
			  ?>
			 </select>
		   <div class="BusinessSource_Id" ></div></td>
		 </tr>
		
		 <tr>	  
		  <td align="right" class="F_val">PayMode</td>
		  <td align="left">
		    <select type="text"    id="PayMode_Id" name="PayMode_Id"   class="scs-ctrl" >
			<option selected value="0" > -- Select PayMode -- </option>
			  <?php
			  $Res=$this->Myclass->PayMode();
			  $count=1;
			  foreach($Res as $row)
				{ 
				   if($row['InActive'] !=1)
				   {
					echo '<option value="'.$row['PayMode_Id'].'"   	 >'.$row['PayMode'].'</option>';
				   }
				}
			  ?>
			</select>
		  <div class="PayMode_Id" ></div></td>
		
		  <td align="right" class="F_val">ReservationMode</td>
		  <td align="left">
		    <select type="text"    id="ReservationMode_Id" name="ReservationMode_Id"   class="scs-ctrl" >
			<option selected value="0"> -- Select ReservationMode -- </option>
			<?php
			$Res=$this->Myclass->ReservationMode();
		    $count=1;
			foreach($Res as $row)
			 {
				if($row['Active'] !=1)
				{
				echo '<option value="'.$row['ReservationMode_Id'].'"   	 >'.$row['ReservationMode'].'</option>';
				}
			 }
			 ?>
			</select>
		  <div class="ReservationMode_Id" ></div></td>
		</tr>
		<tr>
          <td align="right" class="F_val">In Active</td>
          <td align="left"> <select name="Active" id="Active" class="scs-ctrl" >
          <option value="0" >No</option>
          <option value="1" >Yes</option>
          
          </select>
            <div class="Active" ></div></td>
        </tr>		
	</table>  
    </div>
    </div>
	 <table>  
	  <td align="right">&nbsp;</td>
      <td align="left">
	  <input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
	 </table>  
 </div> 
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
	$('#Active').val(<?php echo @$Inactive; ?>);
	$('#PayMode_Id').val(<?php echo @$PayMode_Id; ?>);
	$('#GstType_Id').val(<?php echo @$GstType_Id; ?>);
	$('#ReservationMode_Id').val(<?php echo @$ReservationMode_Id; ?>);
	$('#BusinessSource_Id').val(<?php echo @$BusinessSource_Id; ?>);
	$('#MarketSegment_Id').val(<?php echo @$MarketSegment_Id; ?>);
	$('#CompanyGroup_Id').val(<?php echo @$CompanyGroup_Id; ?>);
	$('#CompanyType_Id').val(<?php echo @$CompanyType_Id; ?>);


});



$("#Designation").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/Designation",
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
			 $("#Designation").val(ui.item.Designation);				
         }
     });
// $("#City").autocomplete({
//          source: function(request, response) {
//              $.ajax({
//                  url: "<php echo scs_index; ?>Auto_c/city",
//                  dataType: "json",
//                  data: {
//                      term: request.term
//                  },
//                  success: function(data) {
//                      response(data);
//                  }
//              });
//          },
//          minLength: 2,
//          select: function(event, ui) {
// 			    event.preventDefault();  
// 			 $("#Country_id").val(ui.item.Country_Id);			
//        $("#Country").val(ui.item.Country);			  
// 			 $("#State_id").val(ui.item.State_id);
//        $("#State").val(ui.item.State);
// 			 $("#City_id").val(ui.item.Cityid);
// 			 $("#City").val(ui.item.City);
			
//          }
//      });
</script>



<script>

function getcity(val) {
    var value = val;

    if (!value || value.trim() === '') {
        return;
    }
    
    $.ajax({
        url: "<?php echo scs_index; ?>Auto_c/getallcitydet",
        type: "POST",
        dataType: "json",
        data: {
            term: value
        },
        success: function(response) {
            if (response && response.length > 0 && response[0].Cityid) {

                if ($("#Country_id").length) {
                    $("#Country_id").val(response[0].Country_Id);
                    $("#Country").val(response[0].Country);
                }
                if ($("#State_id").length) {
                    $("#State_id").val(response[0].State_id);
			        $("#State").val(response[0].State);

                }
                if ($("#City_id").length) {
                    $("#City_id").val(response[0].Cityid);
			        $("#City").val(response[0].City);

                }
            } else {
                console.warn("No data found for city ID:", value);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("Error fetching city data. Please try again.");
        }
    });
}
</script>
     