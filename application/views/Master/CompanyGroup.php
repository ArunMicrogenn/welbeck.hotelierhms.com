<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','CompanyGroup');
$this->pfrm->FrmHead1('Master / CompanyGroup',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$CompanyGroup_Id; ?>" >
      <table class="FrmTable T-10" >
        <tr>
          <td align="right" class="F_val">CompanyGroup</td>
          <td align="left"><input type="text" placeholder="CompanyGroup" id="CompanyGroup" name="CompanyGroup" value="<?php echo @$CompanyGroup; ?>" class="scs-ctrl" />
            <div class="CompanyGroup" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Address1</td>
          <td align="left"><input type="text" placeholder="Address" id="Address1" name="Address1" value="<?php echo @$Address1; ?>" class="scs-ctrl" />
            <div class="Address1" ></div></td>
        
          <td align="right" class="F_val">Address2</td>
          <td align="left"><input type="text" placeholder="Address" id="Address2" name="Address2" value="<?php echo @$Address2; ?>" class="scs-ctrl" />
            <div class="Address2" ></div></td>
        </tr>
 
        <tr>
          <td align="right" class="F_val">Mobile</td>
          <td align="left"><input type="text" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Mobile" id="Mobile" name="Mobile" value="<?php echo @$Mobile; ?>" class="scs-ctrl" />
            <div class="Mobile" ></div></td>
        
          <td align="right" class="F_val">Phone</td>
          <td align="left"><input type="text" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Phone" id="Phone" name="Phone" value="<?php echo @$Phone; ?>" class="scs-ctrl" />
            <div class="Phone" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Email</td>
          <td align="left"><input type="text" oninput="this.value=value.replace(/[^a-z0-9/@/.]/gi,'')"  placeholder="Email" id="Email" name="Email" value="<?php echo @$Email; ?>" class="scs-ctrl" />
            <div class="Email" ></div></td>
        </tr>
         
          <tr>
          <td align="right" class="F_val">Active</td>
          <td align="left"> <select name="Active" id="Active" class="scs-ctrl" >
          <option value="0" >No</option>
          <option value="1" >Yes</option>
          
          </select>
            <div class="Active" ></div></td>
        </tr>
         
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
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
<script>
 
 $(document).ready(function(e) {
    
	$('#Active').val(<?php echo @$Active; ?>);
	
});


</script>