<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','TariffSetup');
$this->pfrm->FrmHead12('Master / TariffSetup',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
<form id="tariffForm" method="POST" action="<?php echo scs_index ?>Master/TariffSetup_Val">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$TaxSetup_Id; ?>" >
        <input type="hidden"id="Validation" name="Validation" Value="Validation">
        <table  width="100%" class="mytable" style="margin-top:20px">
        <thead>
		<tr>
		<th>From Value</th>
		<th>To Value</th>
		<th>CGST</th>
		<th>SGST</th>
		<th>Validate From</th>
		<th>Validate To</th>
		<th>CGST Name</th>
		<th>SGST Name</th>
		<th>Grace Hours</th>
		<th>Action</th>
		</tr>
		</thead>
		<tbody id="dataTable">
		<?php 
		 $qry=" exec Get_TaxSetup ";
		 $res=$this->db->query($qry);
		 $i = 0;
		 foreach($res->result() as $row)
		{
			
		?> 
		<tr id="dataTable1">
		<td><input name="FAMT[]" value="<?php echo $row->FromAmt ?>"   num=1 class="f-ctrl rmm"  /></td>
		<td><input name="To[]"  value="<?php echo $row->ToAmt ?>"  num=1 class="f-ctrl rmm"  /></td>	
		<td><input name="CGST[]" value="<?php echo $row->CGST ?>" num=1 class="f-ctrl rmm"  /></td>
		<td><input name="SGST[]" value="<?php echo $row->SGST ?>" num=1 class="f-ctrl rmm"  /></td>
		<td><input name="dateFrom[]" value="<?php echo date("d-m-Y", strtotime($row->Validatefrom)); ?>" type="text"  class="scs-ctrl rmm" /></td>
		<td><input name="dateto[]" onChange="fromdatevalidate();" value="<?php echo date("d-m-Y", strtotime($row->Validateto)); ?>" type="text" class="scs-ctrl Dat rmm"  /></td>
		<td><input name="CGSTname[]" value="<?php echo $row->CGSTNAME ?>" type="text" class="f-ctrl rmm"  /></td>
		<td><input name="SGSTname[]" value="<?php echo $row->SGSTNAME ?>" type="text" class="f-ctrl rmm"  /></td>
		<td><input name="gracehours[]" value="<?php echo $row->gracehours ?>" type="text" maxlength="2" num=1 class="f-ctrl rmm"  /></td>
		<td><INPUT type="button"  value="Add Row" onclick="addRow('dataTable')" /></td>
		
		<!-- <td><INPUT type="button" value="Delete Row"  class="deleterow"  /></td> -->
		 
	    </tr>
		<?php $i++; } 
		?>
		<input type="hidden" value="<?php echo $i; ?>" id="rowcount" name="rowcount" />
		</tbody>
		</table>		
		
      <table class="FrmTable T-4" >
    <tr>
      <td colspan="4" align="right"> <input type="button"   class="btn btn-success btn-sm" id="subbtn" name="subbtn" value="SAVE"   /></td>
    </tr>
 </table>
    </fieldset>
  </div>
		</form>
  <div class="the-box D_IS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
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
			document.getElementById("rowcount").value = rowCount+1;
		}

		document.getElementById("subbtn").addEventListener("click", () =>{
			$.ajax({
				type:"POST",
				url:"<?php echo scs_index ?>Master/TariffSetup_Val",
				data:$("#tariffForm").serialize(),
				success: function(result){
					
					if(result.trim() == "success"){
						swal("Success...!", " Saved Successfully...!", "success")
						.then(function() {
						window.location.href="<?php echo scs_index?>Master/TariffSetup";
						});
					}else{
						swal("Failed...!", "Failed to save...!", "error")
						.then(function() {
						window.location.href="<?php echo scs_index?>Master/TariffSetup";
						});
					}
				}
			})
		})
	
		// function deleteRow(tableID) {
		// 	try {
		// 	var table = document.getElementById(tableID);
		// 	var rowCount = table.rows.length;
			

		// 	for(var i=0; i<rowCount; i++) {
		// 		var row = table.rows[i];
		// 		var chkbox = row.cells[0].childNodes[0];
		// 		// if(null != chkbox && true == chkbox.checked) {
		// 		// 	if(rowCount <= 1) {
		// 		// 		alert("Cannot delete all the rows.");
		// 		// 		break;
		// 		// 	}
		// 			// alert(rowCount)
		// 			// table.deleteRow(i);
		// 			// rowCount--;
		// 			// i--;


		// 	}
		// 	}catch(e) {
		// 		alert(e);
		// 	}
		// }


        // delete row function - 04.04.2023
		// let buttons = document.querySelectorAll('.deleterow');
		// var table = document.getElementById("dataTable");
		// var rowCount = table.rows.length;
		// 	buttons.forEach((button, index, Array) => {
		// 		// console.log(Array)
		// 		button.addEventListener('click', () =>{
		// 			if(rowCount <=1){
		// 				alert("Cannot delete all the rows")
		// 			}else{
		// 				table.deleteRow(index);
		// 				rowCount--;
		// 			}
		// 		})
		// 	});

	</SCRIPT>