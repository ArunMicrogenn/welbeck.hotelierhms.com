<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Ota Bookings Report');
$this->pfrm->FrmHead6('Report /Ota Bookings Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 
 <?php date_default_timezone_set('Asia/Kolkata') ?>
<div class="col-sm-12">
<div class="the-box F_ram">
    <fieldset>
        <form action="" method="POST">
            <table style="width: 100%; border-collapse: separate; border-spacing: 10px;">
                <tr>
                    <!-- Radio Buttons Column -->
                    <td style="vertical-align: top; white-space: nowrap;">
                        <label style="display: block;">
                            <input type="radio" name="report_type" value="booking"
                                <?php if (!isset($_POST['report_type']) || $_POST['report_type'] == 'booking') echo 'checked'; ?>>
                            Booking Date
                        </label>
                        <label style="display: block; margin-top: 5px;">
                            <input type="radio" name="report_type" value="arrival"
                                <?php if (isset($_POST['report_type']) && $_POST['report_type'] == 'arrival') echo 'checked'; ?>>
                            Arrival Date
                        </label>
                    </td>
                    <td>
                    <select type="text" name="company"  class="scs-ctrl"/>		
		  <option value="0">All</option>  
		  <?php
		  $sql="select * from mas_company where companytype_id = '1'";
		   $exec=$this->db->query($sql); 
		    foreach ($exec->result_array() as $rows)
			  {
		  ?>
		   <option <?php if(@$_POST['company']==$rows['Company_Id']){echo "selected "; }?> value="<?php echo $rows['Company_Id']; ?>"><?php echo $rows['Company']; ?></option>
			  <?php } ?>
		  </select>
                    </td>

             
              <td style="white-space: nowrap;">
                <label for="frmdate">From Date</label><br>
               <input type="date" id="frmdate"  name="frmdate" value="<?php echo isset($_POST['frmdate']) ? $_POST['frmdate'] : date('Y-m-d'); ?>"
                max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl">
              </td>


              <td style="white-space: nowrap;">
              <label for="todate">To Date</label><br>
              <input type="date" id="todate" name="todate" value="<?php echo isset($_POST['todate']) ? $_POST['todate'] : date('Y-m-d'); ?>"
              max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl">
                     </td>

                 
                    <td style="white-space: nowrap;">
                        <br>
                        <input type="submit" name="submit" class="btn btn-success" value="Show Details">
                    </td>

                    
               
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
		
        <table class="table table-bordered table-hover">  
		    <div>
				<h4 class="text-center"> OTA's Bookings Report From  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?><h4>
		    </div>           
		   <tbody>
		    <?php 
			 $i=1;	
             $report_type = isset($_POST['report_type']) ? $_POST['report_type'] : 'booking';
             $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
             $todate = date('Y-m-d', strtotime($_POST['todate']));
        

             if ($report_type == 'arrival') {
                $qry = "exec Getotareport_arrivaldate '".$fromdate."', '".$todate."'";
              
            } else {
                  $qry = "exec Getotareport_Bookingdate '".$fromdate."', '".$todate."'";
            
              
            }
            
			 $exec=$this->db->query($qry);$pax=0;
			 $advance= $exec->num_rows();
			//   if($advance !=0)
			//   {
				echo '<tr style="background-color:#c9c6c6;">';		 
				echo '<td style=" text-align:center;" >S.No</td>';
                echo '<td style="text-align: center;">OTA</td>';
                echo '<td style="text-align: center;">OTA Booking ID</td>';
                echo '<td style="text-align: center;">Guest Name</td>';	
				echo '<td  style="text-align: center;">Res No</td>';
                echo '<td style="text-align: center;">Arr.Date</td>';
                echo '<td style="text-align: center;">Dep.Date</td>';
				echo '<td style="text-align: center;">Res.Date</td>';
                echo '<td style="text-align: center;">RoomType</td>';	
                echo '<td style="text-align: center;">Tarrif</td>';			
                echo '<td style="text-align: center;">Rooms</td>';			
                echo '<td style="text-align: center;">Pax</td>';			
				echo '</tr>';	
			//   }			
			  foreach ($exec->result_array() as $rows)
			  {
                // print_r($rows);
                // echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['Checkindate'])).'</td>';
                // echo '<td style="text-align: center;">'.date('H:i',strtotime($rows['checkintime'])).'</td>';      
               
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
                echo '<td  style="text-align: left;">'.$rows['OTA'].'</td>';
                echo '<td  style="text-align: left;">'.$rows['onlinebookingno'].'</td>';              
                echo '<td  style="text-align: left;">'.$rows['guest'].'</td>';
				echo '<td  style="text-align: left;">'.$rows['resno'].'</td>';
                echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['fromdate'])).'</td>';
                echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['todate'])).'</td>';
			    echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['resdate'])).'</td>';
				echo '<td style="text-align: center;">'.$rows['roomtype'].'</td>';
				echo '<td style="text-align: left;">'.$rows['roomrent'].'</td>';
				echo '<td style="text-align: left;">'.$rows['rooms'].'</td>';
				echo '<td style="text-align: right;">'.$rows['pax'].'</td>';
				$pax +=  $rows['pax'];				
			  }
			//   if($advance !=0)
			//   {
				echo '<tr>';
				echo '<td class="text-bold" colspan="15" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';	
				echo '<tr>';
				// echo '<td colspan="3" class="text-bold" style="text-align: left;">Total Checkin</td>';
				// echo '<td style="text-align: right;" colspan="2">'.($i-1).'</td>';
				echo '<td  colspan="10" style="text-align: right;"></td>';					
				echo '</tr>';	
				echo '<tr>';
				echo '<td  colspan="3" style="text-align: left;" class="text-bold">Total Pax</td>';
				echo '<td style="text-align: right;" colspan="2">'.$pax.'</td>';
				echo '<td  colspan="10"></td>';
				echo '</tr>';					
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




