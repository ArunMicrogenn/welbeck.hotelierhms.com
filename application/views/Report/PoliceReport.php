<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Police Report');
$this->pfrm->FrmHead8('Report /Police Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 

$Res = $this->Myclass->Hotel_Details();
foreach ($Res as $row) {
	$Company = $row['Company'];
	$Address = $row['Address'];
	$City = $row['City'];
	$Pin = $row['PinCode'];
	$State = $row['State'];
	$Phone = $row['Phone'];
	if ($row['Email'] == '') {
		$Email = '';
	} else {
		$Email = 'Email:' . $row['Email'];
    }
}

?>
  <?php date_default_timezone_set('Asia/Kolkata') ?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="date" value="<?php if(@$_POST['frmdate']){echo @$_POST['frmdate']; }else{echo date('Y-m-d');} ?>" id="frmdate" name="frmdate"  max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl " />
            <div class="Type" ></div></td>    
		   <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
           <td align="left">
            <div style="display:flex; justify-content:space-around;">
                <div><label>In House<label></div>
               <div><input type="checkbox" name="inhouse" <?php if(@$_POST['inhouse']){ echo "checked";} ?> class="btn btn-success btn-block" value="1"></div>
               
            </div>
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
            <thead>
            <tr>
                <!-- <td colspan="2">
                    <img src="../../upload/logo.png" alt="Logo" style="width:100%;">
                </td> -->
                <td colspan="8">
                    <div style="text-align:center;">
                        <h3>
                            <?php echo $Company; ?>
                        </h3>
                        <p>
                            <?php echo $Address; ?>
                        </p>
                        <p>
                            <?php echo $City . '-' . $Pin . ', ' . $State . '.'; ?>
                        </p>
                        <p>
                            <?php echo $Phone . ' ' . $Email; ?>
                        </p>
                    </div>
                </td>
            </tr> 

            </thead>
                   
		   <tbody>
		    <?php 
			 $i=1;	
             $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
             if(@$_POST['inhouse']== "1"){

                $qry="exec  police__report__inhouse ";

             }
             else{

              $qry="exec  police__report '".$fromdate."'";
             }
            
			 $exec=$this->db->query($qry);
			 $advance= $exec->num_rows();
             $pax=0;
			  if($advance !=0)
			  {
                echo '<tr style="background-color:#c9c6c6;" >';			 
				echo '<td style=" text-align:center;" >S.No</td>';
                echo '<td style="text-align: center;">RoomNo / RoomType</td>';
                echo '<td style="text-align: center;">Pax</td>';
                echo '<td style="text-align: center;">Guest Details</td>';
                echo '<td style="text-align: center;">Arr.Date</td>';	
				echo '<td  style="text-align: center;">Arr.Time</td>';
				echo '<td  style="text-align: center;">ID Type</td>';
				echo '<td  style="text-align: center;">ID No</td>';
                // echo '<td style="text-align: center;">Dep.Date</td>';
				// echo '<td style="text-align: center;">Dep.Time</td>';
                echo '<td style="text-align: center;" colspan="2">Image</td>';		
				echo '</tr>';	
			  }		
              
              foreach($exec->result_array() as $row){
                // print_r($row);
                $photopath = $row['Photopath'];
                // print_r($photopath); echo"<br>";
                //    print_r($photopath);
                if ($photopath != '') {
                    $directory = $photopath . "/" . $row['mobile']. "_";
                } else {
                    $directory = '../../assets/img/cards/noimage.png';
                }

                echo '<tr  >';		 		 
				echo '<td style=" text-align:center;" >'.$i.'</td>';
                echo '<td style="text-align: center;">'.$row['room'].'</td>';
                echo '<td style="text-align: center;">'.$row['noofpersons'].'</td>';
                echo '<td style="text-align: center;">'.$row['guestdetails'].'</td>';
                echo '<td style="text-align: center;">'.$row['arrdate'].'</td>';	
				echo '<td  style="text-align: center;">'.$row['arrtime'].'</td>';
				echo '<td  style="text-align: center;">'.$row['idname'].'</td>';
				echo '<td  style="text-align: center;">'.$row['Id_Documentno'].'</td>';
                // echo '<td style="text-align: center;">'.$row['depdate'].'</td>';
				// echo '<td style="text-align: center;">'.$row['deptime'].'</td>';
                if ($photopath != '') {
                    $j = 0;
                    foreach (glob($directory . "*.{jpg,png,gif}", GLOB_BRACE) as $file) {
                        if ($j <= 1) {
                            ?>
                            <td>
                            <img class="d-block w-50"
                                style="margin:auto;width:120px;height:80px;border:solid #CDCDCD 1px;"
                                src="../../<?php echo $file; ?>" alt="GuestProof">
                            </td>
                            

                            <?php
                        }
                        $j++;
                    }
                }else{
                    echo '<td></td>';
                    echo '<td></td>';
                }
				echo '</tr>';	
                $i++;
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


	// 	$(function() {
    //     $("#exporttable").click(function(e)
	// 	{

    //       var table = $("#printing");
    //       if(table && table.length)
	// 	  {
    //         $(table).table2excel({
    //           exclude: ".noExl",
    //           name: "Excel Document Name",
    //           filename: "Police Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
    //           fileext: ".xls",
    //           exclude_img: true,
    //           exclude_links: true,
    //           exclude_inputs: true,
    //           preserveColors: false
    //         });
    //       } 
	// 	});
    //   });

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
                    pdfMake.createPdf(docDefinition).download("Police Report.pdf");
                }
            });
        });

	</SCRIPT>


