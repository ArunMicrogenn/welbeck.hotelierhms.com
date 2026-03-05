<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Reinstate Noshows Report');
$this->pfrm->FrmHead6('Report /Reinstate Noshows Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="date"  value="<?php echo isset($_POST['frmdate']) ? $_POST['frmdate'] : date('Y-m-d'); ?>" id="frmdate" name="frmdate" max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl Dat2" />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="date"  onchange="todate(this.value)" value="<?php echo isset($_POST['todate']) ? $_POST['todate'] : date('Y-m-d') ?>" id="todate" name="todate" max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl Dat2" />
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
				<h4 class="text-center">Reinstate Noshows Report  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?><h4>
		    </div>           
		   <tbody>
		    <?php 
			 $i=1;	
             $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
             $todate = date('Y-m-d', strtotime($_POST['todate']));
            //  $qry="exec  reinstate__noshow__report '".$fromdate."', '".$todate."'";

            $qry = "  select tit.title , cu.Firstname as customer,trns.entrydate,trns.entrytime,trns.resno,trns.noshowarrivaldate,trns.noshowdeparturedate,trns.newarrivaldate,trns.newdeparturedate,un.username , trns.newarrivaltime,
			trns.newdeparturetime,trns.noshowarrivaltime,trns.noshowdeparturetime
			from trans_reservenoshow trns 
                inner join trans_Reserve_mas trm on trm.resid=trns.resid
                inner join mas_customer cu on cu.customer_id=trm.cusid  inner join mas_title tit on tit.titleid = cu.titelid 
                inner join username un on un.userid=trns.userid 
                where trns.entrydate between  '".$fromdate."'and '".$todate."'";

			 $exec=$this->db->query($qry);
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';		 
				echo '<td style=" text-align:center;" >S.No</td>';
                echo '<td style="text-align: center;">Entry Date</td>';
                echo '<td style="text-align: center;">Entry Time</td>';
                echo '<td style="text-align: center;">Res.No</td>';
                echo '<td style="text-align: center;">Customer</td>';	
				echo '<td  style="text-align: center;">Arrival Date</td>';
                echo '<td style="text-align: center;">Departure Date</td>';
				echo '<td style="text-align: center;">New Arrival Date</td>';
                echo '<td style="text-align: center;">New Departure Date</td>';
                echo '<td style="text-align: center;">Username</td>';			
				echo '</tr>';	
			  }			
			  foreach ($exec->result_array() as $rows)
			  {

				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
                echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['entrydate'])).'</td>';
                echo '<td style="text-align: center;">'.date('H:i:s',strtotime($rows['entrytime'])).'</td>';                
                echo '<td  style="text-align: left;">'.$rows['resno'].'</td>';
				echo '<td  style="text-align: left;">'.$rows['customer'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['noshowarrivaldate'])).' / '.date('H:i:s',strtotime($rows['noshowarrivaltime'])).'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['noshowdeparturedate'])).' / '.date('H:i:s',strtotime($rows['noshowdeparturetime'])).'</td>';
                echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['newarrivaldate'])).' / '.date('H:i:s',strtotime($rows['newarrivaltime'])).'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['newdeparturedate'])).' / '.date('H:i:s',strtotime($rows['newdeparturetime'])).'</td>';				
				echo '<td style="text-align: left;">'.$rows['username'].'</td>';				
			  }
			//   if($advance !=0)
			//   {
			// 	echo '<tr>';
			// 	echo '<td colspan="4" class="text-bold" style="text-align: right;">Total </td>';
			// 	echo '<td style="text-align: right;">'.number_format($creditTotal,2).'</td>';
            //     echo '<td style="text-align: right;">'.number_format($debitTotal,2).'</td>';								
			// 	echo '</tr>';				
			//   }	 
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
              filename: "ReinStateNoShowReport" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("ReinStateNoShowReport.pdf");
                }
            });
        });
	</SCRIPT>

	<script>
$(document).ready(function() {
    $('#frmdate').on('change', function() {
        var fromdate = $(this).val(); 
        var todate = $('#todate').val();

        var fromDateObj = new Date(fromdate);
        var toDateObj = new Date(todate);

        if (fromDateObj > toDateObj) {
         
            fromDateObj.setDate(fromDateObj.getDate() + 1);

            var newToDate = fromDateObj.toISOString().split('T')[0];

            
            $('#todate').val(newToDate);
        }
    });
});

	</script>

<script>
$(document).ready(function() {
    $('#todate').on('change', function() {
        var todate = $(this).val(); 
        var fromdate = $('#frmdate').val();

        var fromDateObj = new Date(fromdate);
        var toDateObj = new Date(todate);

        if (fromDateObj > toDateObj) {
         
            toDateObj.setDate(toDateObj.getDate() - 1);

            var newToDate = toDateObj.toISOString().split('T')[0];

            
            $('#frmdate').val(newToDate);
        }
    });
});

	</script>