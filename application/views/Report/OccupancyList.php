<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Occupancy Report');
$this->pfrm->FrmHead6('Report /Occupancy Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>

<?php 	date_default_timezone_set('Asia/Kolkata');  ?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">As On Date</td>
          <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="frmdate"  name="frmdate"   class="scs-ctrl " />
            <div class="Type" ></div></td>    
		   <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
           <td align="left">
            <!-- <div style="display:flex; justify-content:space-around;">
                <div><label>In House<label></div>
               <div><input type="checkbox" name="inhouse" <php if(@$_POST['inhouse']){ echo "checked";} ?> class="btn btn-success btn-block" value="1"></div>
               
            </div> -->
            </td>
        </tr>
      	</table>
	   </form>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
    <div id="printing" class="col-sm-12"  style="overflow-x: auto; max-height: 500px;">
		<?php

		if(@$_POST['submit'])
		{
		  ?>




        <table class="table table-bordered table-hover"  style="overflow:scroll">  
              <colgroup>
                <col style="width: 5%;" />
                <col style="width: 15%;" />
                <col style="width: 7%;" />
                <col style="width: 8%;" />
                <col style="width: 8%;" />
                <col style="width: 15%;" />
                <col style="width: 8%;" />
                <col style="width: 10%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 4%;" />
                <col style="width: 3%;" />
            </colgroup>
		    <div>
				<h4 class="text-center">Occupancy Report  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> <h4>
		    </div>           
		   <tbody>
		    <?php 
			 $i=1;	
             $todayroomno ='';$lastroomno = '';$chkroomno='';$vroomno=''; $dirtyroom ='';$mroom=''; $foroom='';
             $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
            //  if(@$_POST['inhouse']== 1){

                $houseqry="exec  Inhouse '".$fromdate."'";

            
          
                 $qry="exec  occupany__List__General '".$fromdate."'";
             
            
			 $exec=$this->db->query($qry);
			 $advance= $exec->num_rows();

             $lastCheckinRooms = '';
             $todaycheckin = '';
             $todaycheckout = '';
$today = date('Y-m-d');

foreach ($exec->result_array() as $row) {





    $checkinDate = date('Y-m-d', strtotime($row['checkindate']));
    $checkoutDate = date('Y-m-d', strtotime($row['checkoutdate']));
    
    

    if ($checkinDate <= $today) {
        $lastCheckinRooms .= $row['roomno'] . ',';
    }
      if ($checkinDate === $today) {
        $todaycheckin .= $row['roomno'] . ',';
    }
      if ($checkoutDate === $today) {
        $todaycheckout .= $row['roomno'] . ',';
    }
}



    
             $pax=0;$occroom=0;
			?>
           
        <tr style="background-color:#c9c6c6;">
                    <th style="text-align:center;">S.No</th>
                    <th style="text-align:center;">Company</th>
                    <th style="text-align:center;">Roomno</th>
                    <th style="text-align:center;">Roomtype</th>
                    <th style="text-align:center;">Guestname</th>
                    <th style="text-align:center;">Address</th>
                    <th style="text-align:center;">City</th>
                    <th style="text-align:center;">Mobile</th>
                    <th style="text-align:center;">In Date / Time</th>
                    <th style="text-align:center;">Out Date / Time</th>
                    <th style="text-align:center;">Food Plan</th>
                    <th style="text-align:center;">Tariff</th>
                    <th style="text-align:center;">Adult</th>
                    <th style="text-align:center;">Child</th>
                    <th style="text-align:center;">Ndays</th>
                </tr>
			 <?php 
                     echo '<tr>';		 

            echo '   <th colspan="14">CHECKOUTS</th>';
               echo '</tr>';		    	
			  foreach ($exec->result_array() as $rows)
			  {
                // print_r($rows);
                $checkinDate = substr($rows['checkindate'], 0, 10); 
$cindate = new DateTime($checkinDate); 
$chinformatteddate = $cindate->format('d-m-Y');


$checkoutDate = substr($rows['checkoutdate'], 0, 10);
$coutdate = new DateTime($checkoutDate); 
$choutformatteddate = $coutdate->format('d-m-Y');

 $checkinTime = substr($rows['checkintime'], 11, 8); 
 $checkoutTime = substr($rows['checkouttime'], 11, 8); 

$ExpDate = substr($rows['ExpDate'], 0, 10);
$exp = new DateTime($ExpDate); 
$Expformatteddate = $exp->format('d-m-Y');

$Exptime = substr($rows['ExpTime'], 11, 8); 



            //    $pax +=$rows['noadults'];
       		 

               echo '<tr>';		 
             echo '<td style="text-align: center; width:5%;">'.$i++.'</td>';
echo '<td style="text-align: left; width:15%;">'.$rows['company'].'</td>';
echo '<td style="text-align: left; width:7%;">'.$rows['roomno'].'</td>';                    
echo '<td style="text-align: left; width:8%;">'.$rows['printingname'].'</td>';
echo '<td style="text-align: center; width:8%;">'.$rows['Title'].'.'.$rows['customer'].'</td>';
echo '<td style="text-align: center; width:15px;">' . $rows['HomeAddress1'] . '<br> ' . $rows['HomeAddress2'] . '</td>';
 if($rows['Homepincode'] != '') {
echo '<td style="text-align: center; width:8%;">' . htmlspecialchars($rows['city']) . ' - ' . htmlspecialchars($rows['Homepincode']) . '</td>';
  } else{
echo '<td style="text-align: center; width:8%;">' . htmlspecialchars($rows['city']) . '</td>';
  }
echo '<td style="text-align: center; width:10%;">'.$rows['Mobile'].'</td>';
echo '<td style="text-align: center; width:6%;">'.htmlspecialchars($chinformatteddate . ' / ' . $checkinTime).'</td>';
if ($choutformatteddate != '' && $checkoutTime != '') {
    echo '<td style="text-align: center; width:6;">'.htmlspecialchars($choutformatteddate . ' / ' . $checkoutTime).'</td>';
} else {
    echo '<td style="text-align: center; width:6;">'.htmlspecialchars($Expformatteddate . ' / ' . $Exptime).'</td>';
}
echo '<td style="text-align: right; width:2%;">'.$rows['foodplan'].'</td>';
echo '<td style="text-align: right; width:2%;">'.$rows['roomrent'].'</td>';
echo '<td style="text-align: right; width:4%;">'.$rows['noofpersons'].'</td>';
echo '<td style="text-align: right; width:4%;">'.$rows['child'].'</td>';
echo '<td style="text-align: right; width:3%;">'.$rows['indays'].'</td>';
             
    		
             }
 
			
                $foot = "exec occupany_footer  '".$fromdate."'";
                $fooex = $this->db->query($foot);
                foreach($fooex->result_array() as $frow){

                   
                    $lastcheckin = $frow['lastcheckin'];
                    $todaycheckin = $frow['todaycheckin'];
                    $todaycheckout = $frow['todaycheckout'];
                    $total = $frow['total'];
                    $vaccant = $frow['vaccant'];
                    $dirty = $frow['dirty'];
                    $mblock = $frow['mblock'];
                    $foblock = $frow['foblock'];
                }
                $foot1 = "exec todaycheckinRooms  '".$fromdate."'";
                $fooex = $this->db->query($foot1);
                foreach($fooex->result_array() as $frow){
                    $todayroomno .= $frow['RoomNo'].',';
                }

                 $foot2 = "exec lastcheckinRooms  '".$fromdate."'";
                $fooex = $this->db->query($foot2);
                foreach($fooex->result_array() as $frow){
                    $lastroomno .= $frow['RoomNo'].',';
                }

                $foot3 = "exec todaycheckoutRooms  '".$fromdate."'";
                $fooex = $this->db->query($foot3);
                foreach($fooex->result_array() as $frow){
                    $chkroomno .= $frow['RoomNo'].',';
                }
                
                $foot4 = "exec vaccant ";
                $fooex = $this->db->query($foot4);
                foreach($fooex->result_array() as $frow){
                    $vroomno .= $frow['RoomNo'].',';
                }

                $foot5 = "exec dirty ";
                $fooex = $this->db->query($foot5);
                foreach($fooex->result_array() as $frow){
                    $dirtyroom .= $frow['RoomNo'].',';
                }

                $foot6 = "exec mblock ";
                $fooex = $this->db->query($foot6);
                $mblkcnt = $fooex->num_rows();
                foreach($fooex->result_array() as $frow){
                    $mroom .= $frow['RoomNo'].',';
                }

                $foot7 = "exec foblock ";
                $fooex = $this->db->query($foot7);
                $foblkcnt = $fooex->num_rows();

                foreach($fooex->result_array() as $frow){
                    $foroom .= $frow['RoomNo'].',';
                }
                
                $foot8 = "exec occ__roomcount ";
                $fooex8 = $this->db->query($foot8);
                foreach($fooex8->result_array() as $frow){
                    $occroom = $frow['roomcount'];
                }
                $foot9 = " select * from Room_Status where Status='Y' AND isnull(billsettle,0) = 0";
                   $fooex9 = $this->db->query($foot9);
                    foreach($fooex9->result_array() as $frow){
                    $pax += $frow['Noofpersons'];
                }
                echo '<tr>';
				echo '<td colspan="10" class="text-bold" style="text-align: center;">&nbsp;</td>';				
				echo '</tr>';
                       echo '   <th colspan="12">INHOUSE</th>';
     
               			 $house=$this->db->query($houseqry);
			 $houseadvance= $house->num_rows();

             $lastCheckinRooms = '';
             $todaycheckin = '';
             $todaycheckout = '';
$today = date('Y-m-d');
  $s = 1;

   $tcin = " SELECT tcm.grcid, tcm.checkindate, rs.roomid, rs.status AS room_status,mr.roomno, mr.roomno FROM trans_checkin_mas tcm
JOIN room_status rs ON tcm.grcid = rs.grcid JOIN mas_room mr ON rs.roomid = mr.room_id
WHERE tcm.checkindate = '".$today."'";

    			 $todayin=$this->db->query($tcin);
			 $todayincount= $todayin->num_rows();


          $tcout = "SELECT tcout.checkoutdate, rs.roomid, rs.status AS room_status,mr.roomno, mr.roomno FROM trans_checkout_mas tcout
left JOIN room_status rs ON tcout.roomgrcid = rs.roomgrcid 
left JOIN mas_room mr ON rs.roomid = mr.room_id
WHERE tcout.checkoutdate = '".$today."'";

	 $todayout=$this->db->query($tcout);
			 $todayoutcount= $todayout->num_rows();

                //    foreach($todayin->result_array() as $tckinno ) {
                //         print_r($tckinno);
                //    }



                        foreach($house->result_array() as $hquey ) {


                            // print_r($hquey);

                           $checkinDate1 = substr($hquey['checkindate'], 0, 10); 


$cindate1 = new DateTime($checkinDate1); 
$chinformatteddate1 = $cindate1->format('d-m-Y');
                           
$checkinTime1 = substr($hquey['checkintime'], 11, 8); 

 $checkoutDate1 = substr($hquey['checkoutdate'], 0, 10);
$coutdate1 = new DateTime($checkoutDate1); 
$choutformatteddate1 = $coutdate1->format('d-m-Y'); 

$checkoutTime1 = substr($hquey['checkouttime'], 11, 8); 
$ExpDate1 = substr($hquey['ExpDate'], 0, 10);
$exp1 = new DateTime($ExpDate1); 
$expformatteddate1 = $exp1->format('d-m-Y'); 

$Exptime1 = substr($hquey['ExpTime'], 11, 8); 


             $pax = $hquey['noofpersons'];
             $child = $hquey['child'];
               echo '<tr>';		 
             echo '<td style="text-align: center; width:5%;">'.$s++.'</td>';
echo '<td style="text-align: left; width:15%;">'.$hquey['company'].'</td>';
echo '<td style="text-align: left; width:7%;">'.$hquey['roomno'].'</td>';                    
echo '<td style="text-align: left; width:8%;">'.$hquey['printingname'].'</td>';
echo '<td style="text-align: center; width:8%;">'.$hquey['customer'].'</td>';
echo '<td style="text-align: center; width:15px;">' . $hquey['HomeAddress1'] . '<br> ' . $hquey['HomeAddress2'] . '</td>';
 if($hquey['Homepincode'] != '') {
echo '<td style="text-align: center; width:8%;">' . htmlspecialchars($hquey['city']) . ' - ' . htmlspecialchars($hquey['Homepincode']) . '</td>';
  } else{
echo '<td style="text-align: center; width:8%;">' . htmlspecialchars($hquey['city']) . '</td>';
  }
echo '<td style="text-align: center; width:10%;">'.$hquey['Mobile'].'</td>';
echo '<td style="text-align: center; width:6%;">'.htmlspecialchars($chinformatteddate1 . ' / ' . $checkinTime1).'</td>';
if ($choutformatteddate1 != '' && $checkoutTime1 != '') {
    echo '<td style="text-align: center; width:6;">'.htmlspecialchars($choutformatteddate1 . ' / ' . $checkoutTime1).'</td>';
} else {
    echo '<td style="text-align: center; width:6;">'.htmlspecialchars($expformatteddate1 . ' / ' . $Exptime1).'</td>';
}
echo '<td style="text-align: right; width:2%;">'.$hquey['foodplan'].'</td>';
echo '<td style="text-align: right; width:2%;">' .$hquey['roomrent'].'</td>';
echo '<td style="text-align: right; width:4%;">'.$pax.'</td>';
echo '<td style="text-align: right; width:4%;">'.$child.'</td>';
echo '<td style="text-align: right; width:3%;">'.$hquey['indays'].'</td>';
             
                        }

                                   echo '<tr>';
				echo '<td colspan="10" class="text-bold" style="text-align: center;">&nbsp;</td>';				
				echo '</tr>';
                
                echo '<tr>';

				                echo '<tr>';
				echo '<td colspan="3" class="text-bold" style="text-align: center;">Occupancy: </td>';
				echo '<td style="text-align: left;" colspan="7">'.$occroom.'</td>';							
				echo '</tr>';
				echo '<tr>';
				echo '<td colspan="3" class="text-bold" style="text-align: center;">Occupancy Pax: </td>';
				echo '<td style="text-align: left;" colspan="7">'.$pax.'</td>';							
				echo '</tr>';
   
    echo '<tr>';
    echo '<td colspan="3" class="text-bold" style="text-align: center;">Last CheckIn: Room No : </td>';
      if (!empty($lastroomno)) {
    echo '<td style="text-align: left;" colspan="7">' . rtrim($lastroomno, ',') . '</td>';
    }
    echo '</tr>';

                		echo '<tr>';
				echo '<td colspan="3" class="text-bold" style="text-align: center;">Today CheckIn: </td>';
                    if (!empty($todayincount)) {
				echo '<td style="text-align: left;" colspan="7">'.rtrim($todayincount, ',').'</td>';	
             }
				echo '</tr>';
                		echo '<tr>';
				echo '<td colspan="3" class="text-bold" style="text-align: center;">Today CheckOut: </td>';
                  if (!empty($todayoutcount)) {
				echo '<td style="text-align: left;" colspan="7">'.rtrim($todayoutcount, ',').'</td>';	
             }
				echo '</tr>';
                // echo '<tr>';
				// echo '<td colspan="3" class="text-bold" style="text-align: right;">Last Checkin: </td>';
				// echo '<td style="text-align: left;" colspan="1">'.$lastcheckin.'</td>';	
                // echo '<td style="text-align: left;" colspan="6">'.$lastroomno.'</td>';							
				// echo '</tr>';		
                // echo '<tr>';
				// echo '<td colspan="3" class="text-bold" style="text-align: right;">Today Checkin: </td>';
				// echo '<td style="text-align: left;" colspan="1">'.$todaycheckin.'</td>';	
                // echo '<td style="text-align: left;" colspan="6">'.$todayroomno.'</td>';						
				// echo '</tr>';
                // echo '<tr>';
				// echo '<td colspan="3" class="text-bold" style="text-align: right;">Today Checkout: </td>';
				// echo '<td style="text-align: left;" colspan="1">'.$todaycheckout.'</td>';		
                // echo '<td style="text-align: left;" colspan="6">'.$chkroomno.'</td>';						
				// echo '</tr>';	
                // echo '<tr>';
				// echo '<td colspan="3" class="text-bold" style="text-align: right;">Occupancy Pax: </td>';
				// echo '<td style="text-align: left;" colspan="7">'.$total.'</td>';							
				// echo '</tr>';
                echo '<tr>';
				echo '<td colspan="3" class="text-bold" style="text-align: center;">Vaccant Room Cnt: </td>';
				echo '<td style="text-align: left;" colspan="1">'.$vaccant.'</td>';	
                echo '<td style="text-align: left;" colspan="6">'.$vroomno.'</td>';								
				echo '</tr>';	
                echo '<tr>';
				echo '<td colspan="3" class="text-bold" style="text-align: center;">Dirty Room Cnt: </td>';
				echo '<td style="text-align: left;" colspan="1">'.$dirty.'</td>';
                echo '<td style="text-align: left;" colspan="6">'.$dirtyroom.'</td>';								
				echo '</tr>';
                echo '<tr>';
				echo '<td colspan="3" class="text-bold" style="text-align: center;">M Block Room Cnt: </td>';
				echo '<td style="text-align: left;" colspan="1">'.$mblkcnt.'</td>';
                echo '<td style="text-align: left;" colspan="6">'.$mroom.'</td>';								
				echo '</tr>';
                echo '<tr>';
				echo '<td colspan="3" class="text-bold" style="text-align: center;">F Block Room Cnt: </td>';
				echo '<td style="text-align: left;" colspan="1">'.$foblock.'</td>';		
                echo '<td style="text-align: left;" colspan="6">'.$foroom.'</td>';						
				echo '</tr>';
            			
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
              filename: "Occupancy List Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("Occupancy List Report.pdf");
                }
            });
        });
   

	</SCRIPT>

    <script>

    document.addEventListener('DOMContentLoaded', function () {
  
        document.getElementById('Rload')?.remove();

        document.getElementById("exportpdf")?.remove();

    });
</script>



