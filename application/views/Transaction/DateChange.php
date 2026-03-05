<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','DateChange');
$this->pfrm->FrmHead2('Master / DateChange',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

  $date=date("Y-m-d");
  $time= date("H:i:s");

  $cur = date('Y-m-d'); 
 $currentDate = date('d-m-Y',strtotime($cur));


  $previousdate=date('Y-m-d', strtotime("-1 days"));
//  $bool=true;
  $sql="select DateofAudit,* from night_audit";
  $res=$this->db->query($sql);
  foreach ($res->result_array() as $row)
	{ $auditdate=$row['DateofAudit']; }
	 $creditdate=date('Y-m-d',strtotime($auditdate.'+1 days'));
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$Floor_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Last Account Date :</td>
          <td align="left" class="F_val"><?php echo date('d-m-Y',strtotime($auditdate)); ?><div class="DateChange" ></div></td>
	
        </tr>
			 <tr><td><input type="text" hidden id="last_audit_date" value="<?php echo date('d-m-Y',strtotime($auditdate)); ?>"></td></tr> 
			 <tr><td><input type="text" hidden id="currentDate" value="<?php echo $currentDate ?>"></td></tr> 
		<tr>
		  <td align="right" class="F_val">Create Night Audit Process :</td>
		  <td align="left" class="F_val"><input id="validatebox" type="checkbox" onclick="validatenightaudit()"/><div class="Createauditprocess" ></div></td>
		</tr>
		<tr id="opendate">
		  <td align="right" class="F_val">Open New Date :</td>
		  <td align="left" class="F_val"><?php echo date('d-m-Y',strtotime($creditdate)); ?></td>
		</tr>
		<?php 	$sq = "select * from trans_credit_entry where CreditDate='".$auditdate."'";
			$sqquery = $this->db->query($sq);
		$audicnt = $sqquery->num_rows(); ?>
	
		<tr id="donebutton">
          <td align="right">&nbsp;</td>
		  
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
        </tr>
      </table>
	  <table id="errortable" class="FrmTable T-6">
	    <tr>
		  <td align="right" class="F_val">Unable to Open Newdate</td>
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
$this->pweb->sms_footer($this->Menu);
 $this->pweb->sms_footer($this->Menu);
?>

<script>

 
 $(document).ready(function(e) {
    document.getElementById('opendate').style.visibility = 'hidden';
	document.getElementById('donebutton').style.visibility = 'hidden';
	document.getElementById('errortable').style.visibility = 'hidden';
	});

   var currentDate = document.getElementById('currentDate').value;
	var lastauddate = document.getElementById('last_audit_date').value;
	// if(lastauddate < currentDate){
	function validatenightaudit()
	{
		var id="2";
		$.ajax({ 
        type: "POST",
        url: "<?php echo scs_index ?>Transaction/validatenightaudit",
        data: "customerId="+id,
	
        success: function(data) {	
				
	
           if(data.trim()=='Sucress')
		   { document.getElementById('opendate').style.visibility = 'visible'; 
			 document.getElementById('donebutton').style.visibility = 'visible'; }
	       else
		   {
			  swal("Unable to Create Night Audit Process",data, "warning").then( () => {
				location.href = 'DateChange'
			})
				 
			    /*		   document.getElementById('opendate').style.visibility = 'hidden';
	         document.getElementById('donebutton').style.visibility = 'hidden'; 
			 document.getElementById('errortable').style.visibility = 'visible'; 
			 document.getElementById('errorcaption').innerHTML  =data;
			 document.getElementById('validatebox').checked = false;*/
		   }
        }
      });
	}
		// }
		// else{
			
		// }
 </script>

