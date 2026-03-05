<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Configurations','SmsUsers');
$this->pfrm->FrmHead1('Configurations / SmsUsers',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$smsuserid;  ?>"  >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">User Name</td>
          <td align="left"><input type="text" placeholder="User Name" id="Username" name="Username" value="<?php echo @$smsusername; ?>" class="scs-ctrl" />
          <div class="Username" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Mobile Number</td>
          <td align="left"><input type="text" placeholder="Mobile Number" id="mobile" onchange="mobileCheck();" maxlength="10" minlength="10" name="mobile" value="<?php echo @$mobileno; ?>" class="scs-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
          <div class="mobile" ></div></td>
		  <td>(Excluding Country Code)</td>
          <td align="left"></td>
        </tr>
        <tr>
           <td align="right" class="F_val">In Active</td>
           <td align="left"> 
            <input type="hidden" value="500" name="type" id="type" >
		        <select name="InActive" id="InActive" class="scs-ctrl" >
              <option value="0" >No</option>
              <option value="1" >Yes</option>
              </select>
            <div class="InActive" ></div></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT; ?>"/></td>
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
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

 $(document).ready(function(e) {
    
	$('#InActive').val(<?php echo @$InActive; ?>);
	
});

const mobileCheck = () =>{
    
    a = document.getElementById('mobile').value;
    if(Number(a.length) < 10){
        var msg = 'Enter a valid mobile number';
        return alert(msg);
    }
}





 </script>
