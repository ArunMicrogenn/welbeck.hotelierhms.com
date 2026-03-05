<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Pending Collection Report');
$this->pfrm->FrmHead6('Report / Pending Collection Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 <?php date_default_timezone_set('Asia/Kolkata') ?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="Date" value="<?php echo date('Y-m-d'); ?>" id="frmdate" name="Fdate"   class="scs-ctrl" />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="Date" value="<?php echo date('Y-m-d'); ?>" id="todate" name="Tdate"   class="scs-ctrl " />
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
        <table class="table table-bordered table-hover"  >  
        <div>
				<h4 class="text-center">Pending Collection Report  <?php echo date('d-m-Y', strtotime($_POST['Fdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['Tdate'])); ?><h4>
		    </div>        
		   <tbody>
		    <?php 

			       $i=1;
            //  $Fromdate=date('Y-m-d');
            //  $Todate = date('Y-m-d');
            //  if(isset($_POST['Fdate'])){
              $Fromdate= date('Y-m-d',strtotime($_POST['Fdate']));
              $Todate= date('Y-m-d',strtotime($_POST['Tdate']));
			  $company = '';
			              //  }
			
		   	 $qry="select creditdate,dets.creditid,creditno receiptno,paymode.paymode,isnull(dets.amount,0) as amount,cp.company,u.emailid as username,b.bank,dets.chqno,dets.validdate,cmas.yearprefix +'/'+cmas.checkoutno as checkoutNo from trans_billpay_mas mas 
              inner join trans_billpay_det  dets on  dets.creditid = mas.creditid 
              inner join mas_paymode paymode on  paymode.paymode_id=dets.paymodeid
              left outer join mas_company cp on cp.company_id = mas.customerid
			  left outer join mas_bank b on b.bankid =  dets.bankid left outer join UserTable u on u.User_id = mas.userid
			  inner join Trans_Checkout_mas cmas on dets.Checkoutid = cmas.Checkoutid
              where mas.settleorcollection='C' and mas.creditdate between '".$Fromdate."' and '".$Todate."' ";
			 $exec=$this->db->query($qry); 
			 $advance= $exec->num_rows();
       $advanceamt=0;
			  ///if($advance !=0)
			  ///{

				echo '<tr style="background-color:#c9c6c6;">';		 
				echo '<td  style="text-align: center;">S.no</td>';
				echo '<td  style="text-align: center;">Bill.No</td>';
				echo '<td  style="text-align: center;">Receipt No</td>';
                echo '<td  style="text-align: center;">Coll.Date</td>';
				// echo '<td style="text-align: center;">Company</td>';
				echo '<td style="text-align: center;">Amount</td>';
				echo '<td style="text-align: center;">Paymode</td>';
				echo '<td style="text-align: center;">Bank/Card</td>';
                echo '<td style="text-align: center;">Card No</td>';
		        // echo '<td style="text-align: center;">Valid date</td>';
				echo '</tr>';			

			 /// }			 
			  foreach ($exec->result_array() as $rows)
			  {		

				if($company != $rows['company']){
					if($i != 1){
						echo '<tr><td colspan="8">&nbsp;</td></tr>';
					}
			   
				echo'<tr>';
				echo '<td  style="text-align: center;"class="text-bold" colspan="8">' . $rows['company'] . '</td>';
				echo '</tr>';
				}
				
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows['checkoutNo'].'</td>';
				echo '<td  style="text-align: center;">'.$rows['receiptno'].'</td>';
                echo '<td  style="text-align: center;">'.date('d-m-Y', strtotime(substr($rows['creditdate'],0,10))).'</td>';
                // echo '<td  style="text-align: center;">'.$rows['company'].'</td>';
                echo '<td  style="text-align: right;">'.$rows['amount'].'</td>';
                echo '<td  style="text-align: center;">'.$rows['paymode'].'</td>';
                echo '<td  style="text-align: center;">'.$rows['bank'].'</td>';
				 echo '<td  style="text-align: center;">'.$rows['chqno'].'</td>';
				
				echo '</tr>';	

				$company = $rows['company'];			
			  }			 
		   ?>		   
		   </tbody>
		 </table>	
     <?php
    }
     ?>

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
              filename: "Pending Collection Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("Pending Collection Report.pdf");
                }
            });
        });
	</SCRIPT>