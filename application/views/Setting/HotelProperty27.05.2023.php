<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Setting','Hotel Property');
$this->pfrm->FrmHead3('Setting / Hotel Property',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <form action="" id="peropertyForm" enctype="multipart/form-data" method="POST">
    <fieldset>      	  
      <table class="FrmTable T-8" >
        <tr>
		<td align="right" class="F_val">Property Name</td>
          <td align="left">
		    <input type="text" placeholder="Property" id="Company" name="Company" value="<?php echo @$Company; ?>" class="scs-ctrl" />
            <div class="Company" ></div>
		  </td>
          <td align="right" class="F_val">City</td>
            <td align="left"><input type="Hidden" id="City_id" name="City_id" value="" /><input onClick="Pop_city(this.value)" readonly type="text" placeholder="City" id="City" name="City" value="<?php echo @$City; ?>" class="scs-ctrl " />
            <div class="City" ></div></td>
		  
        </tr>
        <tr>
          <td align="right" class="F_val">Address1</td>
          <td align="left"><input   type="text" placeholder="Address" id="Address" name="Address" value="<?php echo @$Address; ?>" class="scs-ctrl " />
          <div class="Address" ></div></td>
		  <td align="right" class="F_val">State</td>
          <td align="left"><input type="Hidden" id="State_id" name="State_id" value="" /><input   type="text" placeholder="State" readonly id="State" name="State" value="<?php echo @$State; ?>" class="scs-ctrl " />
            <div class="State" ></div></td>
		</tr>
		<tr>        
		   <td align="right" class="F_val">Address2</td>
           <td align="left"><input   type="text" placeholder="Address" id="Address1" name="Address1" value="<?php echo @$Address1; ?>" class="scs-ctrl " />
           <div class="Address1" ></div></td>
		   <td align="right" class="F_val">Country</td>
          <td align="left"><input type="Hidden" id="Country_id" name="Country_id" value="" /><input type="text" placeholder="Country" readonly id="Country" name="Country" value="<?php echo @$Country; ?>" class="scs-ctrl " />
            <div class="Country" ></div></td>
		 
        </tr>
		<tr>
          <td align="right" class="F_val">Mobile</td>
          <td align="left"><input maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" placeholder="Mobile" id="MobileNo" name="MobileNo" value="<?php echo @$MobileNo; ?>" class="scs-ctrl " />
            <div class="MobileNo" ></div></td>
		  <td align="right" class="F_val">PinCode</td>
           <td align="left"><input onkeypress="return /[0-9]/i.test(event.key)"   type="text" placeholder="PinCode" id="PinCode" name="PinCode" value="<?php echo @$PinCode; ?>" class="scs-ctrl " />
           <div class="PinCode" ></div></td>
          
        </tr>
		<tr>
		  <td align="right" class="F_val">Email</td>
          <td align="left"><input   type="email" oninput="this.value=value.replace(/[^a-z0-9/@/.]/gi,'')"  placeholder="Email" id="Email" name="Email" value="<?php echo @$Email; ?>" class="scs-ctrl " />
           <div class="Email" ></div></td>
			
          <td align="right" class="F_val">Web Site</td>
           <td align="left"><input  type="text" placeholder="website" id="website" name="website" value="<?php echo @$Web; ?>" class="scs-ctrl " />
            <div class="website" ></div></td>
        </tr>
        
        <tr>
		 <td align="right" class="F_val">Phone</td>
          <td align="left"><input maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '');"  type="text" placeholder="Phone" id="Phone" name="Phone" value="<?php echo @$Phone; ?>" class="scs-ctrl " />
            <div class="Phone" ></div></td>

			<td align="right" class="F_val">GST Number</td>
          <td align="left"><input  type="text" placeholder="GST Number" id="gstnumber" name="gstnumber" value="<?php echo @$Gstinn; ?>" class="scs-ctrl " />
            <div class="gstnumber" ></div></td>
        </tr>
        <tr>
          
        </tr>
        <tr>
        <td align="right" class="F_val">Logo</td>
          <td align="left"><input type="file" id="logo" name="fileToUpload" class="scs-ctrl " />
          <span style="color:red">*jpeg, *png,*gif</span>
            <div class="logo" ></div></td>

            <td align="right" class="F_val">Logo</td>
          <td align="left"><img src="../../upload/logo.png" width="100px" height="100px" alt="logo" />
            <div class="logo" ></div></td>
        </tr>
          
        
        
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button" onclick="submitHandler();"   class="btn btn-success btn-sm" value="<?php echo $BUT;?>"   /></td>
        </tr>
      </table>
      
    </fieldset>
    </form>
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

const company = document.getElementById("Company");
const city = document.getElementById("City");
const mobile = document.getElementById("MobileNo");
const address = document.getElementById("Address");

const submitHandler = ()=>{
  if(company.value == ''){
    swal("unable to process!", "company is empty!", "warning");
    return;
  }

  if(city.value == ''){
    swal("unable to process!", "city is empty!", "warning");
    return;
  }

  if(mobile.value == '' || mobile.value==0){
    swal("unable to process!", "Mobile is empty!", "warning");
    return;
  }
 
  if(address.value == ''){
    swal("unable to process!", "address is empty!", "warning");
    return;
  }

  // document.getElementById("peropertyForm").submit();
  var form = $('#peropertyForm')[0];
  $.ajax({
      type: 'post',
      url: '<?php echo scs_index ?>Setting/HotelProperty_Val',
      data:  new FormData(form),
      contentType: false,
      cache: false,
      processData: false,
      success: function (result) {
        if(result =='success')		
      {
        swal("Success...!", "Hotel Property Details saved...!", "success")
        .then(function() {
          window.location.reload();
          window.location.href="<?php echo scs_index?>Setting/HotelProperty";

          });
      }
      else
      {
        swal("Failed...!", "Hotel Property Details save Faild...!", "error")
        .then(function() {
          window.location.href="<?php echo scs_index?>Setting/HotelProperty";
          });
      }
    
    }
  });

}
 </script>
