<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','City');
$this->pfrm->FrmHead1('Master / City',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
?>

 
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$Cityid; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">City</td>
          <td align="left"><input type="text" placeholder="City" id="City" name="City" value="<?php echo @$City; ?>" class="scs-ctrl" />
            <div class="City" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">State</td>
          <td align="left">
          <select name="State_Id" id="State_Id" class="scs-ctrl " >
          <?php    
          $res = $this->Myclass->State();
          $count = 0;
          foreach($res as $row){
            ?>
            <option value="<?php echo @$row['State_id']; ?>"><?php echo @$row['State']; ?></option>
          <?php
          $count++;
         }
          ?>
          </select>
            <div class="State_Id" ></div></td>
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
   
 $('#State_Id').val(<?php echo @$State_id; ?>);
 
});
</script>
 
