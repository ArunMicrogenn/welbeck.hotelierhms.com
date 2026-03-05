<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Audit');
$this->pfrm->FrmHead2('Transaction / Audit',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

  $date=date("Y-m-d");
 $time= date("H:i:s");
  $previousdate=date('Y-m-d',strtotime($date.'-1 days'));
 //$qry="SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106)";
  $bool=false;
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
      <input type="hidden" name="idv" value="<?php echo @$TaxSetup_Id; ?>" >
        <input type="hidden"id="Validation" name="Validation" Value="Validation">
        <table  width="100%" class="mytable" style="margin-top:20px">
        <thead>
		<tr>
		<th>S.No</th>
		<th>Room No</th>
		<th>Rate/Charges Tariff</th>
		<th>Guest Charges</th>
		<th>Room Rent</th>
		<th>Dept.Date</th>
		</tr>
		</thead>
		<tbody id="dataTable">
		<?php 
		 $qry=" exec Get_TaxSetup '".User_id."' ";
		 $res=$this->db->query($qry);
		 foreach($res->result() as $row)
		{
			
		?> 
		<tr id="dataTable1">
		<td><input name="FAMT[]" value="<?php echo $row->FromAmt ?>"   num=1 class="f-ctrl rmm"  /></td>
		<td><input name="To[]"  value="<?php echo $row->ToAmt ?>"  num=1 class="f-ctrl rmm"  /></td>	
		<td><input name="CGST[]" value="<?php echo $row->CGST ?>" num=1 class="f-ctrl rmm"  /></td>
		<td><input name="SGST[]" value="<?php echo $row->SGST ?>" num=1 class="f-ctrl rmm"  /></td>
		<td><input name="dateFrom[]" value="<?php echo date("d-m-Y", strtotime($row->Validatefrom)); ?>" type="text"  class="scs-ctrl Dat rmm" /></td>
		<td><input name="dateto[]" onchange="fromdatevalidate()" value="<?php echo date("d-m-Y", strtotime($row->Validateto)); ?>" type="text" class="scs-ctrl Dat rmm"  /></td>
		<td><input name="CGSTname[]" value="<?php echo $row->CGSTNAME ?>" type="text" class="f-ctrl rmm"  /></td>
		<td><input name="SGSTname[]" value="<?php echo $row->SGSTNAME ?>" type="text" class="f-ctrl rmm"  /></td>
		<td><INPUT type="button" value="Add Row" onclick="addRow('dataTable')" /></td>
	    </tr>
		<?php } ?>
		</tbody>
		</table>		
 <?php if($bool==True) { ?>  		
      <table class="FrmTable T-4" >
   <tr>
      <td colspan="4" align="right"> <input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="SAVE"   /></td>
    </tr>
 </table> 
 <?php } ?>  
    </fieldset>
	

	<!--INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable1')" /------>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
?><SCRIPT language="javascript">
       function fromdatevalidate()
	   {
		 var a= document.getElementsByName("dateFrom")[0].value;
		 alert(a);
	   }
		function addRow(tableID) {

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var colCount = table.rows[0].cells.length;

			for(var i=0; i<colCount; i++) {

				var newcell	= row.insertCell(i);

				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
					case "checkbox":
							newcell.childNodes[0].checked = false;
							break;
					case "select-one":
							newcell.childNodes[0].selectedIndex = 0;
							break;
				}
			}
		}

		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}


			}
			}catch(e) {
				alert(e);
			}
		}

	</SCRIPT>