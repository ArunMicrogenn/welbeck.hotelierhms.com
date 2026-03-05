<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','State');
$this->pfrm->FrmHead1('Master / State',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
?>

 
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$State_id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">State</td>
          <td align="left"><input type="text" placeholder="State" id="State" name="State" value="<?php echo @$State; ?>" class="scs-ctrl" />
            <div class="State" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Country</td>
          <td align="left">
          <select name="Country_Id" id="Country_Id" class="scs-ctrl " >
           
          <?php    
          $res = $this->Myclass->Country();
          $count = 0;
          foreach($res as $row){
            ?>
            <option value="<?php echo @$row['Country_Id']; ?>"><?php echo @$row['Country']; ?></option>
          <?php
          $count++;
         }
          ?>
          </select>
            <div class="Country_Id" ></div></td>
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
   
 $('#Country_Id').val(<?php echo @$Country_id; ?>);
 
});
</script>
 
