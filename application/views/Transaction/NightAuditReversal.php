<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','Night Audit Reversal');
$this->pfrm->FrmHead2('Master / Night Audit Reversal',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

  $date=date("Y-m-d");
  $time= date("H:i:s");
  $previousdate=date('Y-m-d', strtotime("-1 days"));

  $sql="select DateofAudit,* from night_audit";
  $res=$this->db->query($sql);
  foreach ($res->result_array() as $row)
	{ $auditdate=$row['DateofAudit']; }
	 $creditdate=date('Y-m-d',strtotime($auditdate.'-1 days'));
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$Floor_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Current Account Date :</td>
          <td align="left" class="F_val"><?php echo date('d-m-Y',strtotime($auditdate)); ?><div class="DateChange" ></div></td>
        </tr>
		<tr>
		  <td align="right" class="F_val">Create Audit Reversal Process :</td>
		  <td align="left" class="F_val"><input id="validatebox" type="checkbox" onclick="validatenightaudit()"/><div class="Createauditprocess" ></div></td>
		</tr>
		<tr id="opendate">
		  <td align="right" class="F_val">Reversal Date :</td>
		  <td align="left" class="F_val"><?php echo date('d-m-Y',strtotime($creditdate)); ?></td>
		</tr>
		<input type="hidden" name="reversaldate" id="reversaldate" value=<?php echo $creditdate; ?>>
		<tr id="Remark">
		  <td align="right" class="F_val">Reason :</td>
		  <td align="left" class="F_val"><input required type="text" name="Remark" id="Remark" class="scs-ctrl" /> <div class="Remark"></div></td>
		</tr>
		<tr id="donebutton">
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
        </tr>
      </table>
	  <table id="errortable" class="FrmTable T-6">
	    <tr>
		  <td align="right" class="F_val">Unable to Reversal Account Date</td>
		  <td align="left" class="F_val" id="errorcaption"></td>
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
?>
<script>

 
 $(document).ready(function(e) {
    document.getElementById('opendate').style.visibility = 'hidden';
	document.getElementById('donebutton').style.visibility = 'hidden';
	document.getElementById('errortable').style.visibility = 'hidden';
	document.getElementById('Remark').style.visibility = 'hidden';
	});
	function validatenightaudit()
	{
		var id="2";
		$.ajax({ 
        type: "POST",
        url: "<?php echo scs_index ?>Transaction/validatenightauditreversal",
        data: "customerId="+id,
        //async:false,
        success: function(data) {
           if(data=='Sucress')
		   { document.getElementById('opendate').style.visibility = 'visible'; 
			 document.getElementById('donebutton').style.visibility = 'visible';
			 document.getElementById('Remark').style.visibility = 'visible'; }
	       else
		   { document.getElementById('opendate').style.visibility = 'hidden';
	         document.getElementById('donebutton').style.visibility = 'hidden'; 
			 document.getElementById('errortable').style.visibility = 'visible'; 
			 document.getElementById('errorcaption').innerHTML  =data;
			 document.getElementById('validatebox').checked = false;
		   }
        }
      });
	}
 </script>

