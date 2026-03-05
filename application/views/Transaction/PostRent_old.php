<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Audit');
$this->pfrm->FrmHead2('Transaction / Audit',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

  $date=date("Y-m-d");
  $time= date("H:i:s");
  $previousdate=date('Y-m-d', strtotime("-1 days"));
 // $bool=true;
  $sql="select DateofAudit,* from night_audit";
  $res=$this->db->query($sql);
  foreach ($res->result_array() as $row)
	{ $auditdate=$row['DateofAudit']; }
  if($previousdate <  $auditdate )
  {
	  $bool=false;	
  }
  else if($previousdate ==  $auditdate)
  {
	  $bool=false; 	
  }
  else 
  {
	  $bool=True;
  }
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$Floor_Id; ?>" >
       <table  width="100%" class="mytable" style="margin-top:20px">
	     <thead>
		 <tr>
		  <th>S.No</th>
		  <th>Room No</th>
		  <th>Rent/Charges Tariff</th>
		  <th>Guest Charges</th>
		  <th>Room Rent</th>
		  <th>Dept.Date</th>
		  <tr>
         </thead>
		 <?php 
		 $i=1;
		 $Res=$this->Myclass->Get_NightAuditrooms();
		  foreach($Res as $row)
		  {
			$charges = $row['Extrabed'] * $row['Extrabedamount'];
			echo '<tr>'; 
			echo '<td><input readonly value='.$i.' class="f-ctrl rmm" style="text-align:center" /></td>';
			echo '<td><input readonly value='.$row['RoomNo'].' class="f-ctrl rmm" style="text-align:center"  /></td>';
			echo '<td><input readonly value='.$row['roomrent'].' class="f-ctrl rmm" style="text-align:right"  /></td>';
			echo '<td><input readonly value='.$charges.' class="f-ctrl rmm" style="text-align:right"  /></td>';
			echo '<td><input readonly value='.$row['Actroomrent'].' class="f-ctrl rmm" style="text-align:right"  /></td>';
			echo '<td><input readonly value='.date('d-m-Y', strtotime($row['depdate'])).' class="f-ctrl rmm" style="text-align:right"  /></td>';
			echo '</tr>';  
			$i++;
		 } ?>
        <tr>
          <td align="right">&nbsp;</td>
		  <td align="right">&nbsp;</td>
		  <td align="right">&nbsp;</td>
		  <td align="right">&nbsp;</td>
		  <td align="right">&nbsp;</td>
          <td align="left"><?php if ($bool==true){ ?><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="Save"   /><?php } else { echo 'Post Rent Not Avilable ';}?></td>
        
      </table>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
?>
<script>

 

 </script>

