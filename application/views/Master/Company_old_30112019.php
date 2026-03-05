<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->session);
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
		  <tr>
			<td align="right" class="F_val">Search Location</td>
			<td colspan="3" align="left"><input type="text" id="autocomplete" placeholder="Search Location"
					 onFocus="geolocate()" class="scs-ctrl" style="background-color:#93CFA8"  />
			  <div class="Search" ></div></td>
		  </tr>
		  <tr>
			<td align="right" class="F_val">City</td>
			<td align="left"><input onClick="Pop_city(this.value)" Readonly  type="text" placeholder="City" id="City" name="City" value="<?php echo @$City; ?>" class="scs-ctrl " />
			  <div class="City" ></div></td>
			<td align="right" class="F_val">State</td>
			<td align="left"><input   type="text" placeholder="State" id="State" name="State" value="<?php echo @$State; ?>" class="scs-ctrl " />
			  <div class="State" ></div></td>
		  </tr>
		  <tr>
			<td align="right" class="F_val">Country</td>
			<td align="left"><input   type="text" placeholder="Country" id="Country" name="Country" value="<?php echo @$Country; ?>" class="scs-ctrl " />
			  <div class="Country" ></div></td>
			<td align="right" class="F_val">Zipcode</td>
			<td align="left"><input   type="text" placeholder="Zipcode" id="Zipcode" name="Zipcode" value="<?php echo @$Zipcode; ?>" class="scs-ctrl " />
			  <div class="Zipcode" ></div></td>
		  </tr>
		  <tr>
			<td align="right" class="F_val">Phoneno</td>
			<td align="left"><input   type="text" placeholder="Phoneno" id="Phoneno" name="Phoneno" value="<?php echo @$Phoneno; ?>" class="scs-ctrl " />
			  <div class="Phoneno" ></div></td>
			<td align="right" class="F_val">Fax</td>
			<td align="left"><input   type="text" placeholder="Fax" id="Fax" name="Fax" value="<?php echo @$Fax; ?>" class="scs-ctrl " />
			  <div class="Fax" ></div></td>
		  </tr>
			</tr>
		  
		  <tr>
			<td align="right" class="F_val">E_mail</td>
			<td align="left"><input   type="text" placeholder="E_mail" id="E_mail" name="E_mail" value="<?php echo @$E_mail; ?>" class="scs-ctrl " />
			  <div class="E_mail" ></div></td>
			  
		
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
			  <td align="left"><input   type="text" placeholder="Contact Number" id="Contactno" name="Contactno" value="<?php echo @$Contactno; ?>" class="scs-ctrl " />
			  <div class="Contactno" ></div></td>
			
		     </tr>
			 <tr>
			 <td align="right" class="F_val">Designation</td>
			  <td align="left"><input   type="text" placeholder="Designation" id="Designation" name="Designation" value="<?php echo @$Designation; ?>" class="scs-ctrl " />
			  <div class="Designation" ></div></td>	
			 <td align="right" class="F_val">Email</td>
			  <td align="left"><input   type="mail" placeholder="Email" id="com_email" name="com_email" value="<?php echo @$com_email; ?>" class="scs-ctrl " />
			  <div class="com_email" ></div></td>	      	  
			
		     </tr>
		  </table>
		
    </div>
    <div id="menu1" class="tab-pane fade">
        <fieldset>
		  <legend>Company Bill Printing : -</legend>
		   <table class="FrmTable T-12" >
		   <tr>
		
			  <td align="left" class="F_val">Company Bill Printing </td>
		  <td align="left"><select type="text"    id="CompanyGroup_Id" name="CompanyGroup_Id"   class="scs-ctrl" >
			  <option value="" > -- Select Company Bill Printing -- </option>
			  <?php
			  $Res=$this->Myclass->CompanyGroup();
				$count=1;
				 
			 foreach($Res as $row)
				{
					echo '<option value="'.$row['CompanyGroup_Id'].'"   	 >'.$row['CompanyGroup'].'</option>';
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
		  <td align="left"><select type="text"    id="MarketSegment_Id" name="MarketSegment_Id"   class="scs-ctrl" >
			  <option value="" > -- Select MarketSegment -- </option>
			  <?php
			  $Res=$this->Myclass->MarketSegment();
				$count=1;
				 
			 foreach($Res as $row)
				{
					echo '<option value="'.$row['MarketSegment_Id'].'"   	 >'.$row['MarketSegment'].'</option>';
				}
			  ?>
			</select>
			<div class="MarketSegment_Id" ></div></td>
	   
		  <td align="right" class="F_val">BusinessSource</td>
		  <td align="left"><select type="text"    id="BusinessSource_Id" name="BusinessSource_Id"   class="scs-ctrl" >
			  <option value="" > -- Select BusinessSource -- </option>
			  <?php
			  $Res=$this->Myclass->BusinessSource();
				$count=1;
				 
			 foreach($Res as $row)
				{
					echo '<option value="'.$row['BusinessSource_Id'].'"   	 >'.$row['BusinessSource'].'</option>';
				}
			  ?>
			</select>
			<div class="BusinessSource_Id" ></div></td>
		</tr>
		
		 <tr>
	  
		  <td align="right" class="F_val">PayMode</td>
		  <td align="left"><select type="text"    id="PayMode_Id" name="PayMode_Id"   class="scs-ctrl" >
			  <option value="" > -- Select PayMode -- </option>
			  <?php
			  $Res=$this->Myclass->PayMode();
				$count=1;
				 
			 foreach($Res as $row)
				{
					echo '<option value="'.$row['PayMode_Id'].'"   	 >'.$row['PayMode'].'</option>';
				}
			  ?>
			</select>
			<div class="PayMode_Id" ></div></td>
		
		  <td align="right" class="F_val">ReservationMode</td>
		  <td align="left"><select type="text"    id="ReservationMode_Id" name="ReservationMode_Id"   class="scs-ctrl" >
			  <option value="" > -- Select ReservationMode -- </option>
			  <?php
			  $Res=$this->Myclass->ReservationMode();
				$count=1;
				 
			 foreach($Res as $row)
				{
					echo '<option value="'.$row['ReservationMode_Id'].'"   	 >'.$row['ReservationMode'].'</option>';
				}
			  ?>
			</select>
			<div class="ReservationMode_Id" ></div></td>
		</tr>
		
	</table>
  
    </div>
    <div id="menu2" class="tab-pane fade">
	  <fieldset>
		  <legend>GST Details : -</legend>
    <table class="FrmTable T-12" >		  
		  <tr>
			  <td align="right" class="F_val">GST Registration Type</td>
		   <td align="left"><select type="text"    id="GstType_Id" name="GstType_Id"   class="scs-ctrl" >
				  <option value="0" >Registered</option>
				  <option value="1" >Un Registered</option>          
				</select>
				<div class="GstType_Id" ></div></td>
			<td align="right" class="F_val">GST Number</td>
			<td align="left"><input   type="text" placeholder="GST Number" id="Gstno" name="Gstno" value="<?php echo @$Gstno; ?>" class="scs-ctrl " />
			  <div class="Gstno" ></div></td>
		     </tr>
			  
			 </table>
			   <fieldset>
		  <legend>Credit Details : -</legend>
			  <table class="FrmTable T-12" >

		  
		   <tr>
			<td align="right" class="F_val">CreditLimit</td>
			<td align="left"><input   type="text" placeholder="CreditLimit" num=1 id="CreditLimit" name="CreditLimit" value="<?php echo @$Gstno; ?>" class="scs-ctrl " />
			  <div class="CreditLimit" ></div></td>
			   <td align="right" class="F_val">Creditdays</td>
			<td align="left"><input   type="text" placeholder="Creditdays" num=1 id="Creditdays" name="Creditdays" value="<?php echo @$Creditdays; ?>" class="scs-ctrl " />
			  <div class="Creditdays" ></div></td>
			
		  </tr>
			  
		  <tr>
			<td align="right" class="F_val">Remarks</td>
			<td align="left"><textarea placeholder="Remarks" id="Remarks" name="Remarks" value="<?php echo @$Remarks; ?>" class="scs-ctrl " ></textarea>
			  <div class="Remarks" ></div></td>
			  </tr>
						 
			</tr>
		  </table>
		   <fieldset>
		  <legend>Company Type : -</legend>
		   <table class="FrmTable T-12" >

		  
		   <tr>
		    <td align="left" class="F_val">Company Type</td>
		  <td align="left"><select  type="text"    id="CompanyType_Id" name="CompanyType_Id"   class="scs-ctrl" >
			  <option value="" > -- Select CompanyType -- </option>
			  <?php
			  $Res=$this->Myclass->CompanyType();
				$count=1;
				 
			 foreach($Res as $row)
				{
					echo '<option value="'.$row['CompanyType_Id'].'"   	 >'.$row['CompanyType'].'</option>';
				}
			  ?>
			</select>
			<div class="CompanyType_Id" ></div></td>
			</tr>
			
		   <tr>
			<td align="right" class="F_val">Commission %</td>
			<td align="left"><input   type="number" placeholder="Commission %" num=1 id="Commissionper" name="Commissionper" value="<?php echo @$Gstno; ?>" class="scs-ctrl " />
			  <div class="Commissionper" ></div></td>
			   <td align="right" class="F_val">Comission TAX %</td>
			<td align="left"><input   type="number" placeholder="Commission TAX %" num=1 id="Commissiontaxper" name="Commissiontaxper" value="<?php echo @$Creditdays; ?>" class="scs-ctrl " />
			  <div class="Commissiontaxper" ></div></td>
			
		  </tr>
		  <tr>
			<td align="right" class="F_val">Default Checkin Time</td>
			<td align="left"><input   type="number" placeholder="00:00:00" num=1 id="checkintime" name="checkintime" value="<?php echo @$Gstno; ?>" class="scs-ctrl " />
			  <div class="Commissionper" ></div></td>
			   <td align="right" class="F_val">Default Checkout Time</td>
			<td align="left"><input   type="number" placeholder="00:00:00" num=1 id="checkouttime" name="checkouttime" value="<?php echo @$Creditdays; ?>" class="scs-ctrl " />
			  <div class="Commissiontaxper" ></div></td>
			
		  </tr>
			
			</table>
    </div>    
  </div>


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
      <td class="wideField" colspan="3"><input class="field" id="locality"
              disabled="true">
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
  <td align="right">&nbsp;</td>
               <td align="left">
	  <input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>

<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
?>
       <script type="text/javascript">
 $(document).ready(function(e) {
    $('#CompanyType_Id').val(<?php echo @$CompanyType_Id; ?>);
	$('#CompanyGroup_Id').val(<?php echo @$CompanyGroup_Id; ?>);
	$('#MarketSegment_Id').val(<?php echo @$MarketSegment_Id; ?>);
	$('#BusinessSource_Id').val(<?php echo @$BusinessSource_Id; ?>);
	$('#GuestType_Id').val(<?php echo @$GuestType_Id; ?>);
	$('#PayMode_Id').val(<?php echo @$PayMode_Id; ?>);
	$('#ReservationMode_Id').val(<?php echo @$ReservationMode_Id; ?>);
	$('#GstType_Id').val(<?php echo @$GstType_Id; ?>);
 
	
});


      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
  /*
      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'long_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */ /*(document.getElementById('autocomplete')),
           {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
	        if("administrative_area_level_1"==addressType)
			{
				$("#State").val(val);
			}
			if("country"==addressType)
			{
				$("#Country").val(val);
			}
			if("locality"==addressType)
			{
				$("#City").val(val);
			}
			if("postal_code"==addressType)
			{
				$("#PINCode").val(val);
			}
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIlNvvqpux9tXoVlV8tD60pkH-3mY-_fk&libraries=places&callback=initAutocomplete"
        async defer> */
		
		</script> 
