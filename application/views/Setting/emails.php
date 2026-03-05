<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Setting','emails');
$this->pfrm->FrmHead1('Setting / SMTP SETTING',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$SMTP_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">EMAIL</td>
          <td align="left"><input type="text" placeholder="EMAIL" id="EMAIL" name="EMAIL" value="<?php echo @$EMAIL; ?>" class="scs-ctrl" />
            <div class="EMAIL" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">SERVERNAME</td>
          <td align="left"><input type="text" placeholder="SERVERNAME" id="SERVERNAME" value="<?php echo @$SERVERNAME; ?>" name="SERVERNAME" class="scs-ctrl" />
            <div class="SERVERNAME" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">PORT</td>
          <td align="left"><input type="text" placeholder="PORT" value="<?php echo @$PORT; ?>" id="PORT" name="PORT" class="scs-ctrl" />
            <div class="PORT" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">USERNAME</td>
          <td align="left"><input type="text" placeholder="USERNAME" value="<?php echo @$USERNAME; ?>" id="USERNAME" name="USERNAME" class="scs-ctrl" />
            <div class="USERNAME" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">PASSWORD</td>
          <td align="left"><input type="text" placeholder="PASSWORD" value="<?php echo @$PASSWORD; ?>" id="PASSWORD" name="PASSWORD" class="scs-ctrl" />
            <div class="PASSWORD" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">SECURITY</td>
          <td align="left"><select  id="SECURITY" name="SECURITY" class="scs-ctrl" >
            <option value="" >SELECT</option>
              <option value="1" >None</option>
              <option value="2" >SSL</option>
              <option value="3" >TLS</option>
            </select>
            <div class="ROUTE" ></div></td>
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
    $("#SECURITY").val('<?php echo @$SECURITY; ?>');
	<?php if($BUT=="DELETE")
	{
	  echo "$('.scs-ctrl').attr('readonly','readonly')";
	}
	?>
});
</script>
