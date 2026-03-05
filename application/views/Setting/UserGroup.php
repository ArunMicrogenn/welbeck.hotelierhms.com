<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Setting','UserGroup');
$this->pfrm->FrmHead1('Setting / UserGroup',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$UserGroup_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">UserGroup</td>
          <td align="left"><input type="text" placeholder="UserGroup" id="UserGroup" name="UserGroup" value="<?php echo @$UserGroup; ?>" class="scs-ctrl" />
            <div class="UserGroup" ></div></td>
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
    $("#ROUTE").val('<?php echo @$ROUTE; ?>');
	
	<?php if($BUT=="DELETE")
	{
	  echo "$('.scs-ctrl').attr('readonly','readonly')";
	}
	?>
});
</script>
