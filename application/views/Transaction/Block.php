<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','DateChange');
$this->pfrm->FrmHead2('Transaction / DateChange',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

  $date=date("Y-m-d");
  $time= date("H:i:s");
  $previousdate=date('Y-m-d', strtotime("-1 days"));
  $sql="select DateofAudit,* from night_audit";
  $res=$this->db->query($sql);
  foreach ($res->result_array() as $row)
	{ $auditdate=$row['DateofAudit']; }
  $creditdate=date('Y-m-d',strtotime($auditdate.'+1 days'));
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Newdate</td>
          <td align="left"><input type="text" placeholder="Newdate" id="Newdate" name="Newdate" value="<?php echo  $creditdate; ?>" class="scs-ctrl" />
            <div class="Block" ></div></td>
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

 
 </script>
