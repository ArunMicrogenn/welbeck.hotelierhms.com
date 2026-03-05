<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Print','Bill Entry Receipt');
$this->pfrm->FrmHead4('Master / Bill Entry Receipt',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");


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
	$cityses = "select City from mas_city where Cityid = '".$City."'";
	$cityqry = $this->db->query($cityses)->row_array(); 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
     <div id="printing">
        <table  class="mytable" style="margin-top:20px; width=100% ">
        <tbody id="dataTable" >
		<tr id="dataTable1" >
          <td  colspan="4" style="text-align:center">
		     <h3><?php echo $Company; ?></h3>
			 <p><?php echo $Address; ?></p>
			 <p><?php echo $cityqry['City'].'-'.$Pin.', '.$State.'.'; ?></p>
			 <p><?php echo $Phone.' '.$Email;  ?></p>
		  </td>
		 </tr>
		<tr id="dataTable1">
		  <td  colspan="4" style="text-align:center"><h4>Bill Entry Receipt<h4></td>
		</tr>
		 <?php  $sql="select * from Mas_Revenue re
			 Inner join Trans_Credit_Entry ce on ce.Creditheadid= re.Revenue_Id
			 inner join UserTable us on us.User_id=ce.UserID
			 inner join Mas_Room room on room.Room_Id=ce.Roomid 
			 inner join Trans_RoomCustomer_det det on det.grcid=ce.Grcid
		 	inner join Mas_Customer cus on cus.Customer_Id=det.Customerid
			 where Credid='".$_REQUEST['Receiptid']."'"; 
				$result = $this->db->query($sql);
				foreach($result->result() as $row)
				{ $RoomNo=$row->RoomNo; $Receiptno=$row->CreditNo;
                  $RoomType=$row->RevenueHead;	$rptdate=$row->CreditDate;	$yearprefix=$row->yearprefix; 
				  }	?>
		<tr id="dataTable1" style="width:100%;border:0px;">		   
		    <td colspan='2' style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Room No:</b> <?php echo $RoomNo ?></P></td>
			<td colspan='2' style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p></P></td>
		</tr>		
		<tr id="dataTable1" style="width:100%;border:0px;">		  	   
		    <td colspan='2' style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Guest Name :</b> <?php echo $row->Firstname; ?></P></td>
			<td colspan='2' style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p> </P></td>
		</tr>	

		<tr id="dataTable1">
		  <td  style="text-align:center"><p> <b>Receipt No</b></P></td>
		  <td  style="text-align:center"><p> <b>Receipt Date</b></P></td>
		  <td  style="text-align:center"><p> <b>Credit Head</b></P></td>
		  <td  style="text-align:center"><p> <b>Amount</b></P></td>
		</tr>
		
		<tr id="dataTable1">
		  <td  style="text-align:center"><p> <b><?php echo $yearprefix.'/'.$Receiptno ?></b></P></td>
		  <td  style="text-align:center"><p> <b><?php echo  date("d/m/Y",strtotime($rptdate));  ?></b></P></td>
		  <td  style="text-align:center"><p> <b><?php echo $RoomType ?></b></P></td>
		  <td  style="text-align:right;"><p  style="padding:10px"> <b><?php echo $row->Amount; ?></b></P></td>
		</tr>
		
		<tr id="dataTable1">
		  <td  colspan='2' style="text-align:left"><p> <b>&nbsp;&nbsp;Cashier Signature :</b></P></td>
		  <td  colspan='2' style="text-align:left"><p style="padding:10px"> <b>&nbsp;&nbsp;Guest Signature :</b></P></td>
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
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<SCRIPT language="javascript">
		function printDiv(a) {
			 var printContents = document.getElementById(a).innerHTML;
			 var originalContents = document.body.innerHTML;
			 document.body.innerHTML = printContents;
			 window.print();
			 document.body.innerHTML = originalContents;
		}
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