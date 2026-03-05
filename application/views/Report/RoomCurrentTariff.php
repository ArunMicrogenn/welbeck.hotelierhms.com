<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Room Current Tariff');
$this->pfrm->FrmHead6('Report / Room Current Tariff',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
  <?php date_default_timezone_set('Asia/Kolkata') ?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      <table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">As on Date</td>
          <td align="left">
		  <input type="date" value="<?php if(@$_POST['frmdate'] ==''){ echo date('Y-m-d');}else{ echo $_POST['frmdate']; } ?>" id="frmdate" name="frmdate"  max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl" />
            <div class="Type" ></div></td>
			<td></td>
                    
          <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
        </tr>		   
      </table>
	   </form>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div id="printing" class="col-sm-12">
		<?php

		if(@$_POST['submit'])
		{
$roomamountr = 0; $roomchargeg=0;$cgstg=0;$sgstg=0;$extrabedg=0;$totalg=0;$paxg=0;

?>
		
        <table class="table table-bordered table-hover "  >
			<div>
				<h4 class="text-center">Room Current Tariff  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?><h4>
		    </div>
			<thead>
		    <tr style="background-color:#c9c6c6;">
			 <th style="text-align: center;">S.No</th>
			 <th style="text-align: center;">Room No</th>
			 <th style="text-align: center;">Room Type</th>
			 <th style="text-align: center;">Guest Name</th>
			 <th style="text-align: center;">Pax</th>
			 <th style="text-align: center;">Rack Tariff</th>
			 <th style="text-align: center;">Charged Tariff</th>
			 <th style="text-align: center;">Extrabed</th>
			 <th style="text-align: center;">CGST</th>
			 <th style="text-align: center;">SGST</th>
			 <th style="text-align: center;">Total</th>			 
			</tr>
		   </thead>
				  
		   <tbody>
		    <?php 
			//     $sql=" Select tcc.Amount as amt,tcc.Grcid,rdet.Actrackrate,* from Trans_credit_entry tcc
			//   Inner Join Mas_Revenue ror on ror.Revenue_Id=tcc.Creditheadid 
			//   Inner join Mas_Room rm on rm.Room_Id=tcc.Roomid
			//   Inner join Room_Status Rms on Rms.Roomid=rm.Room_Id
			//   Inner join Mas_Roomtype typ on typ.RoomType_Id=rm.RoomType_Id 
			//   Inner join Trans_roomdet_det rdet on rdet.grcid =tcc.grcid
			//   Inner join Trans_roomcustomer_det cdet on cdet.grcid= tcc.grcid
			//   Inner join Mas_Customer cus on cus.Customer_Id=cdet.Customerid
			//   Inner join Mas_Title ti on ti.Titleid=cus.Titelid
			//  where CreditDate='".date('Y-m-d',strtotime($_POST['frmdate']))."' and Rms.Status='Y' and ror.RevenueHead='ROOM RENT'";

			 $sql = " exec Inhouse_roomcurrtariff '".date('Y-m-d',strtotime($_POST['frmdate']))."'";
			 $res=$this->db->query($sql); $i=1; $cgst=0; $sgst=0; $total=0;
			 $norow= $res->num_rows(); 
			  if($norow !=0)
			  {
				echo '<tr>';
				echo '<td colspan="11" class="text-bold" style="text-align: left;">In House Rooms</td>';
				echo '</tr>';
			  }
			  $rackrate=0; $chargetariff=0; $cgsttol=0;$sgsttol=0; $grtotal=0; $guestchargetotal=0;
			 foreach ($res->result_array() as $row)
			 {
				// $row['guestcharge'] 
				// $row['Actrackrate'] 
				$guestcharge = 0;
				$Actrackrate = 0;
				// echo $row['Extrabedamount'];
				// $Res =$this->Myclass->Get_CGST($row['roomgrcid'],$row['amt'],$row['discamount'],$row['CreditDate']);
				// foreach($Res as $taxc){
				// 	echo $cgst= $taxc['CGST'];
				// }
				// $Res =$this->Myclass->Get_SGST($row['roomgrcid'],$row['amt'],$row['discamount'],$row['CreditDate']);
				// foreach($Res as $taxc){
				// 	echo $sgst= $taxc['SGST'];
				// }

				$rmrentqry = "	select roomrent from trans_roomdet_det where roomgrcid = '".$row['roomgrcid']."'";
				$rmrent = $this->db->query($rmrentqry)->row_array();

		     $sql1="Select sum(Amount) as Amt from Trans_credit_entry where roomgrcid='".$row['roomgrcid']."' and CreditDate='".date('Y-m-d',strtotime($_POST['frmdate']))."' and Creditheadid=2";	 
		      $res1=$this->db->query($sql1);
			  foreach ($res1->result_array() as $row1)
			  { $cgst=$row1['Amt'];}
			  $sql2="Select sum(Amount) as Amt from Trans_credit_entry where roomgrcid='".$row['roomgrcid']."' and CreditDate='".date('Y-m-d',strtotime($_POST['frmdate']))."' and Creditheadid=3";	 
		      $res2=$this->db->query($sql2);
			  foreach ($res2->result_array() as $row2)
			  { $sgst=$row2['Amt'];}
			   $total=$sgst+$cgst+$rmrent['roomrent'];
			 echo '<tr>';		 
			 echo '<td  style="text-align: center;">'.$i.'</td>';
			 echo '<td  style="text-align: center;">'.$row['roomno'].'</td>';
			 echo '<td style="text-align: left;">'.$row['printingname'].'</td>';	
			 echo '<td style="text-align: left;">'.$row['Title'].'.'.$row['Firstname'].'</td>';
			 echo '<td style="text-align: center;">'.$row['noofpersons'].'</td>';
			 echo '<td style="text-align: right;">'.number_format($Actrackrate,2).'</td>';
			 echo '<td style="text-align: right;">'.number_format($rmrent['roomrent'],2).'</td>';
			 echo '<td style="text-align: right;">'.number_format($guestcharge,2).'</td>';
			 echo '<td style="text-align: right;">'.number_format($cgst,2).'</td>';
			 echo '<td style="text-align: right;">'.number_format($sgst,2).'</td>';
			 echo '<td style="text-align: right;">'.number_format($total,2).'</td>';
			 echo '</tr>';
			 $rackrate=$rackrate+$Actrackrate;
			 $chargetariff=$chargetariff+$rmrent['roomrent']; $cgsttol=$cgsttol+$cgst; $sgsttol=$sgsttol+$sgst;
			 $grtotal=$grtotal+$total; $guestchargetotal=$guestchargetotal+$guestcharge;
			 $i++;
			 }
			 if($norow !=0)
			  {
				 echo '<tr>';
				 echo '<td style="text-align: right;"></td>';
				 echo '<td style="text-align: right;"></td>';
				 echo '<td style="text-align: right;"></td>';
				 echo '<td style="text-align: center;" class="text-bold" >Total</td>';
				 echo '<td style="text-align: right;"></td>';
				 echo '<td style="text-align: right;">'.number_format($rackrate,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($chargetariff,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($guestchargetotal,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($cgsttol,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($sgsttol,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($grtotal,2).'</td>';
				 echo '</tr>';

				 $roomchargeg +=$chargetariff; $roomamountr +=$rackrate ; $extrabedg +=$guestchargetotal;
				 $cgstg += $cgsttol; $sgstg += $sgsttol; $totalg += $grtotal;
			  }
		   ?>
		   <?php 
		   $rackrate=0; $chargetariff=0; $cgsttol=0;$sgsttol=0; $grtotal=0; $guestchargetotal=0;
			// echo  $sql=" Select tcc.Amount as amt,tcc.Grcid,* from Trans_credit_entry tcc
			//   Inner Join Mas_Revenue ror on ror.Revenue_Id=tcc.Creditheadid 
			//   Inner join Mas_Room rm on rm.Room_Id=tcc.Roomid
			//   Inner join Room_Status Rms on Rms.Roomid=rm.Room_Id
			//   Inner join Mas_Roomtype typ on typ.RoomType_Id=rm.RoomType_Id 
			//   Inner join Trans_roomdet_det rdet on rdet.roomgrcid =tcc.roomgrcid
			//   Inner join Trans_roomcustomer_det cdet on cdet.grcroomdetid= rdet.grcroomdetid
			//   Inner join Mas_Customer cus on cus.Customer_Id=cdet.Customerid
			//   inner join trans_checkout_mas checkmas on checkmas.Roomgrcid=rdet.roomgrcid
			//   Inner join Mas_Title ti on ti.Titleid=cus.Titelid
			//  where CreditDate='".date('Y-m-d',strtotime($_POST['frmdate']))."' and Rms.Status='N' and ror.RevenueHead='ROOM RENT' and checkmas.Checkoutno like 'CHK%'";

			 $sql = "
			Select rdet.roomrent as amt,tcc.Grcid,* from trans_checkout_mas tcc 
			Inner join Mas_Room rm on rm.Room_Id=tcc.Roomid 
			Inner join Mas_Roomtype typ on typ.RoomType_Id=rm.RoomType_Id 
			Inner join Trans_roomdet_det rdet on rdet.roomgrcid =tcc.roomgrcid 
			Inner join Mas_Customer cus on cus.Customer_Id=tcc.Customerid
			 left outer join Mas_Title ti on ti.Titleid=cus.Titelid where tcc.checkoutdate ='".date('Y-m-d',strtotime($_POST['frmdate']))."' and tcc.Checkoutno like 'CHK%'";

			 $res=$this->db->query($sql);

			  $selchkqry = "
			 SELECT * 
			 FROM night_audit 
			 WHERE DateofAudit = '" . date('Y-m-d', strtotime($_POST['frmdate'])) . "'
		 ";
		 
		 $selqrcnt = $this->db->query($selchkqry)->num_rows();
			 
			
			  $i=1; $cgst=0; $sgst=0; $total=0;
			 $norow= $res->num_rows();
			  if($norow !=0)
			  {
				echo '<tr>';
				echo '<td colspan="11" class="text-bold" style="text-align: left;">Checkout Rooms</td>';
				echo '</tr>';
			  }
			 foreach ($res->result_array() as $row)
			 {

				

				if ($selqrcnt > 0) {
					$roomrentss = $row['roomrent'];
					$rowamt = $row['amt'];
				
				} else {
					$roomrentss = 0;
					$rowamt = 0;
				}
			
			  $sql1="Select sum(Amount) as Amt from Trans_credit_entry where roomgrcid='".$row['Grcid']."' and CreditDate='".date('Y-m-d',strtotime($_POST['frmdate']))."' and Creditheadid=2";	 
		      $res1=$this->db->query($sql1);
			  foreach ($res1->result_array() as $row1)
			  { $cgst=$row1['Amt'];}
			  $sql2="Select sum(Amount) as Amt from Trans_credit_entry where roomgrcid='".$row['Grcid']."' and CreditDate='".date('Y-m-d',strtotime($_POST['frmdate']))."' and Creditheadid=3";	 
		      $res2=$this->db->query($sql2);
			  foreach ($res2->result_array() as $row2)
			  { $sgst=$row2['Amt'];}
			  $total=$sgst+$cgst+$rowamt;
			 echo '<tr>';		 
			 echo '<td  style="text-align: center;">'.$i.'</td>';
			 echo '<td  style="text-align: center;">'.$row['RoomNo'].'</td>';
			 echo '<td style="text-align: left;">'.$row['PrintingName'].'</td>';
			 echo '<td style="text-align: left;">'.$row['Title'].'.'.$row['Firstname'].'</td>';
			 echo '<td style="text-align: center;">'.$row['Noofpersons'].'</td>';
			 echo '<td style="text-align: right;">'.$roomrentss.'</td>';
			 echo '<td style="text-align: right;">'.$rowamt.'</td>';
			 echo '<td style="text-align: right;">'.number_format($row['guestcharge'],2).'</td>';
			 echo '<td style="text-align: right;">'.number_format($cgst,2).'</td>';
			 echo '<td style="text-align: right;">'.number_format($sgst,2).'</td>';
			 echo '<td style="text-align: right;">'.number_format($total,2).'</td>';
			 echo '</tr>';
			 $rackrate=$rackrate+$roomrentss;
			 $chargetariff=$chargetariff+$rowamt; $cgsttol=$cgsttol+$cgst; $sgsttol=$sgsttol+$sgst;
			 $grtotal=$grtotal+$total; $guestchargetotal=$guestchargetotal+$row['guestcharge'];
			 $i++;
			 }
			  if($norow !=0)
			  {
				 echo '<tr>';
				 echo '<td style="text-align: right;"></td>';
				 echo '<td style="text-align: right;"></td>';
				 echo '<td style="text-align: right;"></td>';
				 echo '<td style="text-align: center;" class="text-bold">Total</td>';
				 echo '<td style="text-align: right;"></td>';
				 echo '<td style="text-align: right;">'.number_format($rackrate,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($chargetariff,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($guestchargetotal,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($cgsttol,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($sgsttol,2).'</td>';
				 echo '<td style="text-align: right;">'.number_format($grtotal,2).'</td>';
				 echo '</tr>';
				 
				 $roomchargeg +=$chargetariff; $roomamountr +=$rackrate ; $extrabedg +=$guestchargetotal;
				 $cgstg += $cgsttol; $sgstg += $sgsttol; $totalg += $grtotal;
			  }
			  
			  		  echo '<tr><td colspan="11">&nbsp;</td></tr>';

			  echo '<tr>';
			  echo '<td style="text-align: right;"></td>';
			  echo '<td style="text-align: right;"></td>';
			  echo '<td style="text-align: right;"></td>';
			  echo '<td style="text-align: center;" class="text-bold">Grand Total</td>';
			  echo '<td style="text-align: right;"></td>';
			  echo '<td style="text-align: right;">'.number_format($roomamountr,2).'</td>';
			  echo '<td style="text-align: right;">'.number_format($roomchargeg,2).'</td>';
			  echo '<td style="text-align: right;">'.number_format($extrabedg,2).'</td>';
			  echo '<td style="text-align: right;">'.number_format($cgstg,2).'</td>';
			  echo '<td style="text-align: right;">'.number_format($sgstg,2).'</td>';
			  echo '<td style="text-align: right;">'.number_format($totalg,2).'</td>';
			  echo '</tr>';
			  
		   ?>
		   
		   </tbody>
		 </table>
		
</div>


		  <?php
		}
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
 

 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>
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

		$(function() {
        $("#exporttable").click(function(e)
		{

          var table = $("#printing");
          if(table && table.length)
		  {
            $(table).table2excel({
              exclude: ".noExl",
              name: "Excel Document Name",
              filename: "Room Current Tarriff" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true,
              preserveColors: false
            });
          } 
		});
      });

	  $("body").on("click", "#exportpdf", function () {
            html2canvas($('#printing')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("RoomCurrentTarriff.pdf");
                }
            });
        });

	</SCRIPT>