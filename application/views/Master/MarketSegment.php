<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','Market Segment');
$this->pfrm->FrmHead1('Master / Market Segment',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$MarketSegment_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Market Segment</td>
          <td align="left"><input type="text" placeholder="Market Segment" id="MarketSegment" name="MarketSegment" value="<?php echo @$MarketSegment; ?>" class="scs-ctrl" />
            <div class="MarketSegment" ></div></td>
        </tr>
         
          <tr>
          <td align="right" class="F_val">In Active</td>
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