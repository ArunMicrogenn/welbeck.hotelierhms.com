<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Setting','SMS');
$this->pfrm->FrmHead1('Setting / SMS',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$API_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">APIURL</td>
          <td align="left"><input type="text" placeholder="APIURL" id="APIURL" name="APIURL" value="<?php echo @$APIURL; ?>" class="scs-ctrl" />
            <div class="APIURL" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">APIKEY</td>
          <td align="left"><input type="text" placeholder="APIKEY" id="APIKEY" value="<?php echo @$APIKEY; ?>" name="APIKEY" class="scs-ctrl" />
            <div class="APIKEY" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">SENDERID</td>
          <td align="left"><input type="text" placeholder="SENDERID" value="<?php echo @$SENDERID; ?>" id="SENDERID" name="SENDERID" class="scs-ctrl" />
            <div class="SENDERID" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">CHANNEL</td>
          <td align="left"><input  type="text" placeholder="CHANNEL" value="<?php echo @$CHANNEL; ?>" id="CHANNEL" name="CHANNEL" class="scs-ctrl" />
            <div class="CHANNEL" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">ROUTE</td>
          <td align="left"><select   id="ROUTE" name="ROUTE" class="scs-ctrl" >
            <option value="" >SELECT</option>
              <option value="1" >OTP</option>
              <option value="2" >Transactional</option>
              <option value="3" >Promotional</option>
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
    $("#ROUTE").val('<?php echo @$ROUTE; ?>');
	
	<?php if($BUT=="DELETE")
	{
	  echo "$('.scs-ctrl').attr('readonly','readonly')";
	}
	?>
});
</script>
