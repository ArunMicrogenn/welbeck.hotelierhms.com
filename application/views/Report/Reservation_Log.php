<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Print','Advance Receipt');
$this->pfrm->FrmHead1('Master / TariffSetup',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");


$Res=$this->Myclass->Hotel_Details();
	foreach($Res as $row) 
	{
		$Company=$row['Company'];
		$Address=$row['Address'];
		$City=$row['City'];
		$Pin=$row['PinCode'];
		$State=$row['State'];
		$Phone=$row['Phone'];
		if($row['Email']=='')
		{ $Email='';}
	    else { $Email='Email:'.$row['Email']; } 
	}
 
?>

<table  id="printTable">
	<tbody><tr>
		<th style="border:0px;border-left:solid #CDCDCD  1px;width:50%">First Name</th>
		<th>Last Name</th>		
		<th>Points</th>
	</tr>
	<tr>
		<td>Jill</td>
		<td>Smith</td>		
		<td>50</td>
	</tr>
	<tr>
		<td>Eve</td>
		<td>Jackson</td>		
		<td>94</td>
	</tr>
	<tr>
		<td>John</td>
		<td>Doe</td>		
		<td>80</td>
	</tr>
	<tr>
		<td>Adam</td>
		<td>Johnson</td>		
		<td>67</td>
	</tr>
</tbody></table>

<br />
<br />

<button>Print me</button>




<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
     <div id="printing">
        <table  class="mytable" style="margin-top:20px; width=100% ">
        <tbody id="dataTable" >
		<tr id="dataTable1" >
          <td  colspan="2" style="text-align:center">
		     <h3><?php echo $Company; ?></h3>
			 <p><?php echo $Address; ?></p>
			 <p><?php echo $City.'-'.$Pin.', '.$State.'.'; ?></p>
			 <p><?php echo $Phone.' '.$Email;  ?></p>
		  </td>
		 </tr>
		<tr id="dataTable1">
		  <td  colspan="2" style="text-align:center"><h4>Advance Receipts<h4></td>
		</tr>
		 <?php  $sql=" select PayMode,rem.billremark,rem.Amount,Firstname,RoomNo,Receiptno,PrintingName,rpttime,rptdate,Noofpersons from Trans_Receipt_mas rem
			 Inner join Trans_roomdet_det rd on rd.grcid=rem.grcid
			 Inner join Mas_Paymode pm on pm.PayMode_Id=rem.paymodeid
			 Inner Join Mas_Room rm on rm.Room_Id=rd.Roomid 
			 Inner join Mas_RoomType rt on rt.RoomType_Id=rd.typeid 
			 Inner join Mas_Customer cus on cus.Customer_Id=rem.customerid
			 Inner join Mas_Title ti on ti.Titleid=cus.Titelid
			 where rem.Receiptid='1'"; 
				$result = $this->db->query($sql);
				foreach($result->result() as $row)
				{ $RoomNo=$row->RoomNo; $Receiptno=$row->Receiptno;
                  $RoomType=$row->PrintingName;	$rptdate=$row->rptdate;	 $Noofpersons=$row->Noofpersons;
				  $rpttime=$row->rpttime; }	?>
		<tr id="dataTable1" style="width:100%;border:0px;">		   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Room No:</b> <?php echo $RoomNo ?></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p><b>Receipt No:</b> <?php echo $Receiptno ?></P></td>
		</tr>
		<tr id="dataTable1" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Room  Type :</b> <?php echo $RoomType ?></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p><b>Receipt Date&Time :</b> <?php echo  date("d/m/Y",strtotime($rptdate)); echo"&".substr($rpttime,11) ?></P></td>
		</tr>
		<tr id="dataTable1" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Guest Name :</b> <?php echo $row->Firstname; ?></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p> <b>No of Pax :</b> <?php echo $Noofpersons ?></P></td>

		</tr>	
		<tr id="dataTable1" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Advance Amount :</b> <?php echo $row->Amount; ?></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p> <b>Paymode :</b> <?php echo $row->PayMode; ?></P></td>
		</tr>
		<tr id="dataTable1" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Remark :</b> <?php echo $row->billremark; ?></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p> </P></td>
			
		</tr>	
		<tr id="dataTable1">
		  <td  style="text-align:left"><p> <b>&nbsp;&nbsp;Casier Signature :</b></P></td>
		  <td  style="text-align:left"><p> <b>&nbsp;&nbsp;Guest Signature :</b></P></td>
		</tr>
		<!---tr id="dataTable1" style="width:100%">	
		 <td></td>
		 <td></td>		
		</tr>
		<tr id="dataTable1" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:40%"><p> <b>&nbsp;&nbsp;Received With  thanks from </b></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:60%"><p> <?php echo $row->Title.'.'.$row->Firstname;  ?></P></td>
		</tr--->
		</tbody>
		</table>		
		
		</div>     
    </fieldset>
	

  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
?>
<SCRIPT language="javascript">
function printData()
{
   var divToPrint=document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('button').on('click',function(){
printData();
})
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