<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Print','Advance Receipt');
$this->pfrm->FrmHead4('Master / TariffSetup',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");




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
          <td  colspan="2" style="text-align:center">
		     <h3><?php echo $Company; ?></h3>
			 <p><?php echo $Address; ?></p>
			 <p><?php echo $cityqry['City'].'-'.$Pin.', '.$State.'.'; ?></p>
			 <p><?php echo $Phone.' '.$Email;  ?></p>
		  </td>
		 </tr>
		<tr id="dataTable1">
		  <td  colspan="2" style="text-align:center"><h4>Reservation Advance Receipts<h4></td>
		</tr>
		 <?php  /* $sql=" select PayMode,rem.billremark,rem.Amount,Firstname,PrintingName,RoomNo,Receiptno,rpttime,rptdate,billno from Trans_Receipt_mas rem			 
			 Inner join Mas_Paymode pm on pm.PayMode_Id=rem.paymodeid
			 Inner Join Mas_Room rm on rm.Room_Id=rem.Roomid 
			 Inner join Mas_Customer cus on cus.Customer_Id=rem.customerid
			 Inner join Mas_RoomType rt on rt.RoomType_Id=rm.RoomType_Id 
			 Inner join Mas_Title ti on ti.Titleid=cus.Titelid
			 where rem.Receiptid='".$_REQUEST['Receiptid']."'";  */
			  $sql=" select  rem.Amount as AMT,rt.PrintingName,masb.bank, * from Trans_Receipt_mas rem 
			  inner join Mas_Paymode pm on pm.PayMode_Id=rem.paymodeid
			   inner join trans_reserveadd_mas rmas on rmas.resaddid=rem.Billid 
			   inner join trans_reserveadd_det rdett on rdett.resaddid=rmas.resaddid
			   Inner join Mas_Customer cus on cus.Customer_Id=rem.customerid 
			   inner join  Mas_RoomType rt on rt.RoomType_Id=rdett.typeid
			   left Join Mas_Room rm on rm.Room_Id=rem.Roomid 
			   left join mas_bank masb on rem.bank= masb.Bankid
			   Inner join Mas_Title ti on ti.Titleid=cus.Titelid where rem.Receiptid='".$_REQUEST['Receiptid']."'";
			$result = $this->db->query($sql);
			$row = $result->row();
				 $RoomNo=$row->RoomNo; $Receiptno=$row->billno;
                  $RoomType=$row->PrintingName;	$rptdate=$row->rptdate;	
				  $rpttime=$row->rpttime; 	$yearprefix=$row->yearprefix;?>
		<tr id="dataTable1" style="width:100%;border:0px;">		   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Res No:</b> <?php echo $yearprefix.'/'.$row->resno; ?></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p><b>Receipt No:</b> <?php echo $yearprefix.'/'.$Receiptno ?></P></td>
		</tr>
		<tr id="dataTable1" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Room  Type :</b> <?php echo $RoomType ?></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p><b>Receipt Date&Time :</b> <?php echo  date("d/m/Y",strtotime($rptdate)); echo"&".substr($rpttime,11,5) ?></P></td>
		</tr>
		<tr id="dataTable1" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Guest Name :</b> <?php echo $row->Firstname; ?></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p> <b>Advance Amount :</b> <?php echo $row->AMT;  ?></P></td>

		</tr>	
		<tr id="dataTable1" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p> <b>&nbsp;&nbsp;Remark :</b> <?php echo $row->billremark; ?></P></td>
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p> <b>Paymode :</b> <?php echo $row->PayMode; ?> </P></td>
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