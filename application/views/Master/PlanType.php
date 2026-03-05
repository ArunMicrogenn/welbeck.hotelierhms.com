<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader(' Rates & Inventory ','Rate Type');
$this->pfrm->FrmHead1(' Rates & Inventory  / Rate Type ',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$PlanType_Id; ?>" >
      <table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">RateCode</td>
          <td align="left"><input type="text" placeholder="RateCode" id="RateCode" name="RateCode" value="<?php echo @$RateCode; ?>" class="scs-ctrl" />
            <div class="RateCode" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">RateCaption</td>
          <td align="left"><input type="text" placeholder="RateCaption" id="RateCaption" name="RateCaption" value="<?php echo @$RateCaption; ?>" class="scs-ctrl" />
            <div class="RateCaption" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">ShortName</td>
          <td align="left"><input type="text"   id="ShortName" name="ShortName" value="<?php echo @$ShortName; ?>" class="scs-ctrl" />
            <div class="ShortName" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Show Caption in Checkout Bill</td>
          <td align="left"><input type="checkbox"   id="SCCB" name="SCCB"  <?php if(@$SCCB==1) { echo 'checked'; } ?>   />
            <div class="SCCB" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Defaults</td>
          <td align="left"><input type="checkbox"   id="DEFA" name="DEFA"  <?php if(@$DEFA==1) { echo 'checked'; } ?>    />
            <div class="DEFA" ></div></td>
        </tr>
        
        <tr>
          <td align="right" class="F_val">Published Tariff</td>
          <td align="left"><input type="checkbox"   id="PubTarriff" name="PubTarriff"    <?php if(@$PubTarriff==1) { echo 'checked'; } ?>    />
            <div class="PubTarriff" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Net Tariff</td>
          <td align="left"><input type="checkbox"   id="NetTarriff" name="NetTarriff"    <?php if(@$NetTarriff==1) { echo 'checked'; } ?>      />
            <div class="NetTarriff" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">In Active</td>
          <td align="left"><input type="checkbox"   id="Act" name="Act"   <?php if(@$Act==1) { echo 'checked'; } ?>   />
            <div class="Act" ></div></td>
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
$this->pcss->wjs(@$F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script>
 
