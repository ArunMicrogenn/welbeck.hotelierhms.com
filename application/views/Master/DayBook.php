<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','DayBook');
$this->pfrm->FrmHead1('Master / DayBook',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 ?>


<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$Accid ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Acc.Name</td>
          <td align="left"><input type="text" placeholder="" id="ledgername" name="ledgername" value="<?php echo @$Accname?>" class="scs-ctrl" />
            <div class="ledgername" ></div>
          </td>
        </tr>
      
       <tr>
          <td align="right" class="F_val">In Active</td>
          <td align="left"> <select name="Active" id="Active" class="scs-ctrl" >
          <option value="0" >No</option>
          <option value="1" >Yes</option>
          </select>
            <div class="Active" ></div></td>
        </tr>
        <tr >
          <td align="right" class="F_val">Credit</td>
          <td align="left">
           <input type="radio" name="Creditordebit" <?php if(@$creditordebit == 'C'){echo "checked"; }else{ echo "checked";}?> value="C"  /> Debit
           <input type="radio" name="Creditordebit" <?php if(@$creditordebit == 'D'){echo "checked"; }?>  value="D" />
          </td>
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

  document.getElementById('ledgername').setAttribute('autocomplete', 'off');
    
	$('#Active').val(<?php echo @$inactive; ?>);
	
});

$("#ledgername").keypress(function(event) {
    var character = String.fromCharCode(event.keyCode);
    return isValid(character);     
});

function isValid(str) {
    return !/[~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}


</script>