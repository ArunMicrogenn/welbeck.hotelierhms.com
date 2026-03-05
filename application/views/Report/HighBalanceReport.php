<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','High Balance Report');
$this->pfrm->FrmHead6('Report / High Balance Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div id="printing" class="col-sm-12">
			
        <table class="table table-bordered table-hover"  >   
		    <div>
				<h4 class="text-center">High Balance Report  <h4>
		    </div>       
		   <tbody>
		    <?php 
			 $i=1;
			 $norow=0; $CASH=0; $CARD=0; $NEFT=0; $ROOM=0;

	    //   echo  $qry="select cin.CheckinDate,cin.CheckinTime,cin.Noadults,rs.roomgrcid,isnull(adv.amount,0) advance,isnull(trc.billamount,0) billamount,isnull(trd.discamt,0) as discamt  ,rmas.roomno,ti.title + '.' +cmas.Firstname as customer,case when isnull(cp.company,'') <> '' then cp.company else cin.company end as company,tdet.depdate,cast(tdet.deptime as datetime) as deptime  from  (select roomgrcid from room_status where status='Y') as rs  
		// 	 left outer join  (select sum(isnull(mas.amount,0)) amount,mas.roomgrcid from trans_advancereceipt_mas mas  
		// 		 inner join trans_receipt_mas trm on trm.receiptid=mas.receiptid where mas.type='RMS' and  mas.roomgrcid in (select roomgrcid from room_status rs where status='Y')   group by mas.roomgrcid) as adv on rs.roomgrcid=adv.roomgrcid  
		// 		  left outer join (select sum(isnull(amount,0)) billamount,roomgrcid from trans_credit_entry tc 
		// 		 left outer join Mas_Revenue cd on cd.Revenue_Id=tc.creditheadid where creditordebit<>'D'   and roomgrcid in (select roomgrcid from room_status where status='Y') group by roomgrcid) as trc on trc.roomgrcid=rs.roomgrcid  
		// 		  left outer join (select sum(isnull(amount,0)) Discamt,roomgrcid from trans_credit_entry tc  
		// 		 left outer join Mas_Revenue cd on cd.Revenue_Id=tc.creditheadid where creditordebit = 'D' and Taxhead not in ('ADVANCE')  and roomgrcid in (select roomgrcid from room_status where status='Y') group by roomgrcid) as trd on trd.roomgrcid=rs.roomgrcid 
		// 		 inner join trans_roomdet_Det tdet on rs.roomgrcid=tDet.roomgrcid 
		// 		  inner join Mas_Room rmas on rmas.Room_Id=tDet.roomid 
		// 		 inner join trans_roomcustomer_det cdet on cdet.grcroomdetid=tdet.grcroomdetid 
		// 		 inner join trans_checkin_mas cin on cin.grcid = tdet.grcid 
		// 		  inner join Mas_Customer cmas on cmas.Customer_Id=cdet.customerid
		// 		 left outer join mas_Title ti on ti.Titleid=cmas.Titelid 
		// 		 left outer join mas_company cp on cp.Company = cmas.company  ORDER BY billamount desc";
		$qry = "select cin.CheckinDate,cin.CheckinTime,cin.Noadults,rs.roomgrcid,isnull(adv.amount,0) advance,isnull(trc.billamount,0) + isnull(ttrc.billamount,0)  as totalbillamount,
		isnull(trc.billamount,0) billamount,isnull(trd.discamt,0) as discamt  ,rmas.roomno,isnull(ttrc.billamount,0) tempbillamount,
		ti.title + '.' +cmas.Firstname as customer,case when isnull(cp.company,'') <> '' then cp.company else cin.company end as company,
		tdet.depdate,cast(tdet.deptime as datetime) as deptime  from  (select roomgrcid from room_status where status='Y') as rs  
		left outer join  (select sum(isnull(mas.amount,0)) amount,mas.roomgrcid from trans_advancereceipt_mas mas  
		inner join trans_receipt_mas trm on trm.receiptid=mas.receiptid where mas.type='RMS' and  mas.roomgrcid in (select roomgrcid from room_status rs where status='Y')   group by mas.roomgrcid) as adv on rs.roomgrcid=adv.roomgrcid  
		left outer join (select sum(isnull(amount,0)) billamount,roomgrcid from trans_credit_entry tc left outer join Mas_Revenue cd on cd.Revenue_Id=tc.creditheadid where creditordebit<>'D'   and roomgrcid in (select roomgrcid from room_status where status='Y') group by roomgrcid) as trc on trc.roomgrcid=rs.roomgrcid  
		left outer join (select sum(isnull(amount,0)) Discamt,roomgrcid from trans_credit_entry tc  left outer join Mas_Revenue cd on cd.Revenue_Id=tc.creditheadid where creditordebit = 'D' and Taxhead not in ('ADVANCE')  and roomgrcid in (select roomgrcid from room_status where status='Y') group by roomgrcid) as trd on trd.roomgrcid=rs.roomgrcid 
		left outer join (select sum(isnull(amount,0)) billamount,roomgrcid from temp_trans_credit_entry ttc left outer join Mas_Revenue cd on cd.Revenue_Id=ttc.creditheadid where creditordebit<>'D'   and roomgrcid in (select roomgrcid from room_status where status='Y') group by roomgrcid) as ttrc on ttrc.roomgrcid=rs.roomgrcid  
		inner join trans_roomdet_Det tdet on rs.roomgrcid=tDet.roomgrcid 
		inner join Mas_Room rmas on rmas.Room_Id=tDet.roomid 
		inner join trans_roomcustomer_det cdet on cdet.grcroomdetid=tdet.grcroomdetid 
		inner join trans_checkin_mas cin on cin.grcid = tdet.grcid 
		inner join Mas_Customer cmas on cmas.Customer_Id=cdet.customerid
		left outer join mas_Title ti on ti.Titleid=cmas.Titelid 
		left outer join mas_company cp on cp.Company = cmas.company  ORDER BY billamount desc";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';	 
				echo '<td  style="text-align: center;">Room No</td>';
				echo '<td  style="text-align: center;">No.Of Pax</td>';
				echo '<td style="text-align: center;">Customer</td>';
				echo '<td style="text-align: center;">Company</td>';
				echo '<td style="text-align: center;">In Date</td>';
				echo '<td style="text-align: center;">In Time</td>';
				echo '<td style="text-align: center;">Bill.Amt</td>';
				echo '<td style="text-align: center;">Advance</td>';
				echo '<td style="text-align: center;">Balance</td>';
				echo '<td style="text-align: center;">Refund</td>';
				
				echo '</tr>';			
			  }			 
			  $totalbill_total = 0;
			  $advance_total = 0;
			  $balance_total = 0;
			  $balce = 0;
			  $refunnd = 0;
			  $refundtotal = 0;
			  
			  foreach ($exec->result_array() as $rows) {
				  $total = $rows['totalbillamount'];
				  $advance = $rows['advance'];
				  $balance = $total - $advance;

				  if($balance < 0){
					$refunnd = $balance;
					$balce = 0;
				  } else {
					$balce =  $balance;
					$refunnd = 0;

					
				  }


			  
				  echo '<tr>';		 
				  echo '<td style="text-align: center;">'.$rows['roomno'].'</td>';
				  echo '<td style="text-align: center;">'.$rows['Noadults'].'</td>';
				  echo '<td style="text-align: left;">'.$rows['customer'].'</td>';
				  echo '<td style="text-align: left;">'.$rows['company'].'</td>';				
				  echo '<td style="text-align: center;">'.date('d-m-Y', strtotime($rows['CheckinDate'])).'</td>';
				  echo '<td style="text-align: center;">'.substr($rows['CheckinTime'], 11, 5).'</td>';
				  echo '<td style="text-align: center;">'.number_format($total, 2).'</td>';
				  echo '<td style="text-align: right;">'.number_format($advance, 2).'</td>';
				
		
				echo '<td style="text-align: right;">'.number_format($balce, 2).'</td>';
				echo '<td style="text-align: right;">'.number_format(abs($refunnd), 2).'</td>';

				  echo '</tr>';
			  
				  
				  $totalbill_total += $total;
				  $advance_total += $advance;
				  $balance_total += $balce;
				  $refundtotal += abs($refunnd);
				  $ex = abs($refundtotal);

			  }
			  
			  // Totals row
			  echo '<tr style="font-weight:bold;">';
			  echo '<td colspan="6" style="text-align:right;">Total</td>';
			  echo '<td style="text-align: center;">'.number_format($totalbill_total, 2).'</td>';
			  echo '<td style="text-align: right;">'.number_format($advance_total, 2).'</td>';
			  echo '<td style="text-align: right;">'.number_format($balance_total, 2).'</td>';
			  echo '<td style="text-align: right;">'.number_format($ex, 2).'</td>';
			  echo '</tr>';
		   ?>		   
		   </tbody>
		 </table>	
	</div>
	<?php 
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
              filename: "High Balance Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("High balance Report.pdf");
                }
            });
        });
	</SCRIPT>