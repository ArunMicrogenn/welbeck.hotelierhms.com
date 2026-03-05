<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Guest Depature Register');
$this->pfrm->FrmHead6('Report /Guest Depature Register',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="date" value="<?php echo date('Y-m-d'); ?>" id="frmdate" name="frmdate" max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl " />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="date" max="<?php echo date('Y-m-d'); ?>" id="todate" name="todate" value="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl " />
            <div class="Type" ></div></td>        
		   <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
        </tr>
      	</table>
	   </form>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
    <div id="printing" class="col-sm-12 col-lg-12 col-md-12 table-responsive">
		<?php

		if(@$_POST['submit'])
		{
		  ?>
		<!-- <div class=" table-responsive "> -->
        <table class="table table-responsive table-bordered table-hover"  >  
		    <div>
				<h4 class="text-center">Guest Depature Register  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?><h4>
		    </div>           
		   <tbody>
		    <?php 
			 $i=1;	
             $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
             $todate = date('Y-m-d', strtotime($_POST['todate']));
             $qry="exec  GuestDepatureRegister '".$fromdate."', '".$todate."'";
			 $exec=$this->db->query($qry);
			 $pax=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';			 
				echo '<td style=" text-align:center;" >S.No</td>';
                echo '<td  style="text-align: center;">Room Type</td>';
                echo '<td style="text-align: center;">Room No</td>';
                echo '<td style="text-align: center;">Guest Name</td>';
                echo '<td style="text-align: center;">Company</td>';
                echo '<td style="text-align: center;">TravelAgent</td>';
                echo '<td style="text-align: center;">Pax</td>';
                echo '<td style="text-align: center;">BillNo</td>';
                echo '<td style="text-align: center;">In Date & Time</td>';
				echo '<td style="text-align: center;">Out Date & Time</td>';
                echo '<td style="text-align: center;">Amount</td>';	
				echo '<td style="text-align: center;">Paymode</td>';	
                echo '<td style="text-align: center;">Mobile</td>';	
                echo '<td style="text-align: center;">Email</td>';		
                echo '<td style="text-align: center;">User</td>';			
				echo '</tr>';	
			  }			
			  foreach ($exec->result_array() as $rows)
			  {
               
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
                echo '<td  style="text-align: left;">'.$rows['Roomtype'].'</td>';
                echo '<td  style="text-align: left;">'.$rows['Roomno'].'</td>';
                echo '<td  style="text-align: left;">'.$rows['Guestname'].'</td>';
                echo '<td style="text-align: center;">'.$rows['pycom'].'</td>';
                echo '<td style="text-align: center;">'.$rows['travelagent'].'</td>';
                echo '<td style="text-align: right;">'.$rows['Noofpersons'].'</td>';
                echo '<td  style="text-align: left;">'.$rows['yearPrefix'].'/'.$rows['checkoutno'].'</td>';
                echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['Checkindate'])).'&'.date('H:i',strtotime($rows['checkintime'])).'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['checkoutdate'])).'&'.date('H:i',strtotime($rows['Checkouttime'])).'</td>';              
                echo '<td style="text-align: center;">'.$rows['amount'].'</td>';
				echo '<td style="text-align: left;">'.$rows['paymode'].'</td>';
                echo '<td style="text-align: left;">'.$rows['Mobile'].'</td>';
                echo '<td style="text-align: left;">'.$rows['Email_ID'].'</td>';
                echo '<td style="text-align: left;">'.$rows['EmailId'].'</td>';
				$pax +=  $rows['Noofpersons'];
							
			  }
			  if($advance !=0)
			  {

				echo '<tr>';
				echo '<td class="text-bold" colspan="15" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';	
				echo '<tr>';
				echo '<td colspan="3" class="text-bold" style="text-align: left;">Total Checkout</td>';
				echo '<td style="text-align: right;" colspan="2">'.($i-1).'</td>';
				echo '<td  colspan="10" style="text-align: right;"></td>';					
				echo '</tr>';	
				echo '<tr>';
				echo '<td  colspan="3" style="text-align: left;" class="text-bold">Total Pax</td>';
				echo '<td style="text-align: right;" colspan="2">'.$pax.'</td>';
				echo '<td  colspan="10"></td>';
				echo '</tr>';			
			  }	 
		   ?>		   
		   </tbody>
		 </table>
         <!-- </div> -->
		
		
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
              filename: "Guest Departure Register" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("Guest Departure Register.pdf");
                }
            });
        });
	</SCRIPT>