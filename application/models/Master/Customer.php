<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','Customer');
$this->pfrm->FrmHead1('Master / Customer',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$Customer_Id; ?>" >	  
      <table class="FrmTable T-8" >
        <tr>
		<td align="right" class="F_val">FirstName<label style="Color:red">*</label></td>
          <td align="left">
		    <input type="text" placeholder="FirstName" id="FirstName" name="FirstName" value="<?php echo @$Firstname; ?>" class="scs-ctrl" />
            <div class="FirstName" ></div>
		  </td>
          <td align="right" class="F_val">Titel</td>
          <td align="left" style="width:40%" >
		     <select style="width:40%" id="Titel" name="Titel"  class="scs-ctrl" >
			 <?php $sql="select * from Mas_Title"; 
			       $res=$this->db->query($sql);
		           foreach ($res->result_array() as $row) { ?>
              <option <?php if($row['Titleid']==@$Titelid){ echo "selected"; } ?> value="<?php  echo $row['Titleid'];?>"><?php echo $row['Title'];?></option>
				   <?php } ?>
             </select>
             <div class="Titel" ></div>
		 </td>
		  
        </tr>
        <tr>
          <td align="right" class="F_val">LastName</td>
          <td align="left"><input /*onkeypress="return /[a-z]/i.test(event.key)"*/ type="text" placeholder="LastName" id="LastName" name="LastName" value="<?php echo @$Lastname; ?>" class="scs-ctrl" />
          <div class="LastName" ></div></td>
			
		  <td align="right" class="F_val">Address1<!--<label style="Color:red">*</label>--></td>
          <td align="left"><input   type="text" placeholder="Address" id="Address1" name="Address1" value="<?php echo @$HomeAddress1; ?>" class="scs-ctrl " />
          <div class="Address1" ></div></td>
        </tr>
		<tr>
           <td align="right" class="F_val">Address2</td>
           <td align="left"><input   type="text" placeholder="Address" id="Address2" name="Address2" value="<?php echo @$HomeAddress2; ?>" class="scs-ctrl " />
           <div class="Address2" ></div></td>
		   <td align="right" class="F_val">Address3</td>
           <td align="left"><input   type="text" placeholder="Address" id="Address3" name="Address3" value="<?php echo @$HomeAddress3; ?>" class="scs-ctrl " />
           <div class="Address3" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Mobile<label style="Color:red">*</label></td>
          <td align="left"><input maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" placeholder="Mobile" id="Mobile" name="Mobile" value="<?php echo @$Mobile; ?>" class="scs-ctrl " />
            <div class="Mobile" ></div></td>
		  <td align="right" class="F_val">Phone</td>
          <td align="left"><input maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '');"  type="text" placeholder="Phone" id="Phone" name="Phone" value="<?php echo @$Phone; ?>" class="scs-ctrl " />
            <div class="Phone" ></div></td>
        </tr>
		<tr>
		  <td align="right" class="F_val">Email</td>
          <td align="left"><input   type="email" oninput="this.value=value.replace(/[^a-z0-9/@/.]/gi,'')"  placeholder="Email" id="Email" name="Email" value="<?php echo @$Email_ID; ?>" class="scs-ctrl " />
           <div class="Email" ></div></td>
			
          <td align="right" class="F_val">City<label style="Color:red">*</label></td>
          <td align="left"><input type="Hidden" id="City_id" name="City_id" value="<?php echo @$Cityid; ?>" />
          <input type="text" placeholder="City" id="City" name="City" value="<?php echo @$City; ?>" class="scs-ctrl " />
            <div class="City" ></div></td>
        </tr>
	     <tr id="dataTable1">
          <td align="right" class="F_val">Company</td>
          <td align="left"><input type="text" placeholder="Company" id="Company" name="Company" value="<?php echo @$Company; ?>" class="scs-ctrl" />
		  <input type="text" placeholder="Company_Id" id="Company_Id" name="Company_Id" value="<?php echo @$Company_id; ?>" class="scs-ctrl" />
            <div class="Company" ></div></td>
        
          <td align="right" class="F_val">DOB</td>
          <td align="left"><input readonly type="text" placeholder="DOB" id="DOB" name="DOB" value="<?php echo date("d-m-Y", strtotime(substr(@$DOB,0,10)) ); ?>" class="scs-ctrl Dat1 rmm" />
            <div class="DOB" ></div></td>
        </tr>
        
        <!--tr>
          <td align="right" class="F_val">Search Location</td>
          <td align="left"><input type="text" id="autocomplete" placeholder="Search Location"
             onFocus="geolocate()" class="scs-ctrl" style="background-color:#93CFA8"  />
            <div class="Search" ></div></td>
        </tr--->
        
        <tr>
          <td align="right" class="F_val">State</td>
          <td align="left"><input readonly type="Hidden" id="State_id" name="State_id" value="<?php echo @$State_id; ?>" /><input   type="text" placeholder="State" readonly id="State" name="State" value="<?php echo @$State; ?>" class="scs-ctrl " />
            <div class="State" ></div></td>
        
          <td align="right" class="F_val">Country</td>
          <td align="left"><input readonly type="Hidden" id="Country_id" name="Country_id" value="<?php echo @$Country_id; ?>" /><input type="text" placeholder="Country" readonly id="Country" name="Country" value="<?php echo @$Country; ?>" class="scs-ctrl " />
            <div class="Country" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">PINCode</td>
          <td align="left"><input maxlength="7"  type="text" placeholder="PINCode" id="PINCode" name="PINCode" value="<?php echo @$Homepincode; ?>" class="scs-ctrl " />
            <div class="PINCode" ></div></td>
			
          <td align="right" class="F_val">In Active</td>
          <td align="left"> <select name="Active" id="Active" class="scs-ctrl" >
          <option value="0" >No</option>
          <option value="1" >Yes</option>
          
          </select>
            <div class="Active" ></div></td>
        
        </tr>
        <tr>
          
        </tr>
        <tr>
        
        </tr>
          
        
        
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
        </tr>
      </table>
      <table id="address" style="display:none">
        <tr>
          <td class="label">Street address</td>
          <td class="slimField"><input class="field" id="street_number"
              disabled="true">
            </input></td>
          <td class="wideField" colspan="2"><input class="field" id="route"
              disabled="true">
            </input></td>
        </tr>
        <tr>
          <td class="label">City</td>
          <!-- Note: Selection of address components in this example is typical.
             You may need to adjust it for the locations relevant to your app. See
             https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform
        -->
          <td class="wideField" colspan="3"><input class="field" id="locality"        disabled="true">
            </input></td>
        </tr>
        <tr>
          <td class="label">State</td>
          <td class="slimField"><input class="field"
              id="administrative_area_level_1" disabled="true">
            </input></td>
          <td class="label">Zip code</td>
          <td class="wideField"><input  class="field" id="postal_code"
              disabled="true">
            </input></td>
        </tr>
        <tr>
          <td class="label">Country</td>
          <td class="wideField" colspan="3"><input class="field"
              id="country" disabled="true">
            </input></td>
        </tr>
      </table>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>

<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
?>

<script>

 
 $(document).ready(function(e) {
    
	$('#Active').val(<?php echo @$Inactive; ?>);
	
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
       $("#Country").val(ui.item.Country);			  
			 $("#State_id").val(ui.item.State_id);
       $("#State").val(ui.item.State);
			 $("#City_id").val(ui.item.Cityid);
			 $("#City").val(ui.item.City);
			
         }
     });
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
			 $("#Company_Id").val(ui.item.Company_Id);			
       $("#Company").val(ui.item.Company);			  
					
         }
     });
 </script>
