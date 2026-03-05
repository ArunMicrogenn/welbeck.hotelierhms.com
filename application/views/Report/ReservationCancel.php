<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Reservation Cancel Report');
$this->pfrm->FrmHead6('Report /Reservation Cancel Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 
 <?php date_default_timezone_set('Asia/Kolkata') ?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="date" value="<?php echo date('Y-m-d'); ?>" id="frmdate" name="frmdate"   class="scs-ctrl" />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="date"  id="todate" name="todate" value="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl" />
            <div class="Type" ></div></td>        
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
		  ?>
		
        <table class="table table-bordered table-hover" >  
		    <div>
				<h4 class="text-center">Reservation Cancel Report  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?><h4>
		    </div>           
		   <tbody>
		    <?php 
			 $i=1;	
             $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
             $todate = date('Y-m-d', strtotime($_POST['todate']));
             $qry="select trm.resno,trcm.resdate,trcm.restime,trm.onlinebookingno,tit.title ,cu.Firstname as customer,rt.roomtype,rt.PrintingName,
             trd.fromdate,trd.fromtime,trd.todate,trd.totime,co.company,trd.noofrooms,trcm.remarks,trcd.refund,un.username
              from trans_Reserve_mas trm
                                  inner join trans_reserve_det trd on trd.resid=trm.resid  inner join trans_reservecancel_mas trcm on trcm.reserveid=trm.resid 
                                  inner join trans_reservecancel_det trcd on trcd.resid = trcm.resid 
                                  inner join mas_customer cu on cu.customer_id = trm.cusid 
                                  inner join mas_roomtype rt on rt.roomtype_id=trd.typeid     
                                 inner join mas_title tit on tit.titleid = cu.titelid
                                  left outer join mas_company co on co.company_id = cu.company_id  inner join username un on un.userid=trm.userid
                                  where ISNULL(trd.stat,'N')='C'  
                                  and  trcm.resdate between '".$fromdate."'  and '".$todate."'
                                  order by trm.resno";
			 $exec=$this->db->query($qry);$pax=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';		 
				echo '<td style=" text-align:center;" >S.No</td>';
                echo '<td style="text-align: center;">ResNo</td>';
                echo '<td style="text-align: center;">Room Type</td>';
                echo '<td style="text-align: center;">From Date / Time</td>';	
				echo '<td  style="text-align: center;">To Date / Time</td>';
                echo '<td style="text-align: center;">Guest Name</td>';
				echo '<td style="text-align: center;">Company</td>';
                echo '<td style="text-align: center;">Rooms</td>';
				echo '<td style="text-align: center;">Refund Amount</td>';
                echo '<td style="text-align: center;">Reason</td>';			
                echo '<td style="text-align: center;">Username</td>';	
				echo '</tr>';	
			  }		
			  	
			  foreach ($exec->result_array() as $rows)
			  {

				// print_r($rows);			

				$fr = explode(" ", $rows['fromdate']);          
				$fm = explode(" ", $rows['fromtime']);          
				$fromdate = date('d-m-Y', strtotime($fr[0]));    
				$fromtime = date('H:i:s', strtotime($fm[1]));    
				
				// TO DATE & TIME
				$to = explode(" ", $rows['todate']);
				$tm = explode(" ", $rows['totime']);
				$todate = date('d-m-Y', strtotime($to[0]));
				$totime = date('H:i:s', strtotime($tm[1]));




               
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
                // echo '<td  style="text-align: left;">'.$rows['yearPrefix'].'/'.$rows['Grcno'].'</td>';
                echo '<td style="text-align: center;">'.$rows['resno'].'</td>';
                echo '<td style="text-align: center;">'.$rows['PrintingName'].'</td>';                
				echo '<td style="text-align: left;">' . $fromdate . ' / ' . $fromtime . '</td>';
				echo '<td style="text-align: left;">' . $todate . ' / ' . $totime . '</td>';
                echo '<td style="text-align: center;">'.$rows['title'].'.'.$rows['customer'].'</td>';
				echo '<td  style="text-align: left;">'.$rows['company'].'</td>';
				echo '<td style="text-align: right;">'.$rows['noofrooms'].'</td>';
				echo '<td style="text-align: center;">'.$rows['refund'].'</td>';
				echo '<td style="text-align: right;">'.$rows['remarks'].'</td>';
				echo '<td style="text-align: left;">'.$rows['username'].'</td>';
							
			  }
			  if($advance !=0)
			  {
				// echo '<tr>';
				// echo '<td class="text-bold" colspan="15" style="text-align: center;">&nbsp;</td>';			
				// echo '</tr>';	
				// echo '<tr>';
				// echo '<td colspan="3" class="text-bold" style="text-align: left;">Total Checkin</td>';
				// echo '<td style="text-align: right;" colspan="2">'.($i-1).'</td>';
				// echo '<td  colspan="10" style="text-align: right;"></td>';					
				// echo '</tr>';	
				// echo '<tr>';
				// echo '<td  colspan="3" style="text-align: left;" class="text-bold">Total Pax</td>';
				// echo '<td style="text-align: right;" colspan="2">'.$pax.'</td>';
				// echo '<td  colspan="10"></td>';
				// echo '</tr>';					
			  }	 
		   ?>		   
		   </tbody>
		 </table>
		
		
		  <?php
		} ?>
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
              filename: "Arrival Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("Arrival Report.pdf");
                }
            });
        });
	</SCRIPT>




