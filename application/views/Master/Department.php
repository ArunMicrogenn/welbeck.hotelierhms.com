<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','Department');
$this->pfrm->FrmHead1('Master / Department',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$Deptid; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Department</td>
          <td align="left"><input type="text" placeholder="Department" id="Department" name="Department" value="<?php echo @$Department; ?>" class="scs-ctrl" />
            <div class="Department" ></div></td>
        </tr>
       
		 <tr>
           <td align="right" class="F_val">In Active</td>
           <td align="left"> 
		     <select name="Active" id="Active" class="scs-ctrl"  >
             <option value="0" >No</option>
             <option value="1" >Yes</option>
              </select>
            <div class="Active" ></div></td>
        </tr>
        <!--tr>
          <td align="right" class="F_val">Active</td>
          <td align="left"><input type="checkbox"   id="Active" name="Active"   <?php if(@$Active==1) { echo 'checked'; } ?>   />
            <div class="Active" ></div></td>
        </tr--->
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
$this->pcss->wjs(@$F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script>
 $(document).ready(function(e) {
    
	$('#Active').val(<?php echo @$Inactive; ?>);
	
});
</script>
 
