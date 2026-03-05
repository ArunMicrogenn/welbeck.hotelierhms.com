<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Consolidate');
$this->pfrm->FrmHead2('Report / Consolidate',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$MemberType_Id; ?>" >
      <table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="Type" name="Type"   class="scs-ctrl Dat2" />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="Type" name="Type"   class="scs-ctrl Dat2" />
            <div class="Type" ></div></td>        
          <td align="left"><a class="btn btn-success btn-sm" >GET</a></td>
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
 