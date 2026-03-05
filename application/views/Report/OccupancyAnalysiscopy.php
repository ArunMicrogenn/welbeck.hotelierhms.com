<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Occupancy Analysis');
$this->pfrm->FrmHead6('Report /Occupancy Analysis',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 

$qryy = "select count(*) as roomcount from mas_room where inactive<>1";
$exee = $this->db->query($qryy);
foreach($exee->result_array() as $Rom ){
  $roomcount = $Rom['roomcount'];
}
?>
 

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="frmdate" name="frmdate"   class="scs-ctrl Dat2" />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="todate" name="todate"   class="scs-ctrl Dat2" />
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
           $totalamount = 0;$totalpax=0;$totalbedamount=0;$totalcount=0; $perocc=0;
		  ?>
		
        <table class="table table-bordered table-hover"  >  
		    <div>
				<h3 class="text-center">Occupancy Analysis  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?><h3>
		    </div>           
		   <tbody>
		    <?php 
			 $i=1;	
             $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
             $todate = date('Y-m-d', strtotime($_POST['todate']));

             $qry = "select RoomType_id,RoomType from Mas_RoomType  where Inactive<>1 order by Roomtype_id";
             $exec=$this->db->query($qry);
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';
                echo '<td style="text-align: center;">Date</td>';	

                foreach($exec ->result_array() as $row){
                    echo '<td colspan="2">'. $row['RoomType'].'</td>';

                }
                echo '<td colspan="2">Total</td>';
                echo '<td>Occ%</td>';
                echo '<td colspan="2">Extra Bed</td>';
				echo '</tr>';
                echo '<tr>';
                echo '<td></td>';
                echo '<td>Room Rent</td>';	
                echo '<td>Occ</td>';
               	 
                foreach($exec ->result_array() as $row){
                    echo '<td>Room Rent</td>';
                    echo '<td>Occ</td>';

                }
                echo '<td>%</td>';
                echo '<td>Nos.</td>';
                echo '<td>Amount</td>';
				echo '</tr>';
             
			  }		

              $a_date = $fromdate;
              $b_date = $todate;
             
              $aa_date =date_create($fromdate); // convert the date to string
              $l_date=date_create($todate);
              $diff=date_diff($aa_date ,$l_date );
               $difference = $diff->format("%a");
              for($i=0; $i<=$difference ; $i++){	 
              echo '<tr>';
             
              echo '<td style="text-align: right;">'.date('d-m-Y', strtotime($a_date)).'</td>';		
              $ro ="select * from mas_roomtype where inactive<>1 order by RoomType_id";
              $ex = $this->db->query($ro);
              foreach($ex -> result_array() as $ro){
              $qry1 = "select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce
              inner join trans_roomdet_det det on ce.roomid=det.roomid and ce.roomgrcid=det.roomgrcid and ce.grcid=det.grcid
              where ce.CreditDate between '".$a_date."' and '".$a_date."' and det.typeid='".$ro['RoomType_Id']."'
              
             ";

              $exe = $this->db->query($qry1);
            	
			  foreach ($exe->result_array() as $rows)
			  {
               
                echo '<td style="text-align: right;">'.$rows['Amount'].'</td>';			
			  }
             $qry3 = "select isnull(sum(noofpersons),0) as pax from Trans_Credit_Entry ce
              inner join trans_roomdet_det det on ce.roomid=det.roomid and ce.roomgrcid=det.roomgrcid and ce.grcid=det.grcid
              where ce.CreditDate between '".$a_date."' and '".$a_date."' and det.typeid='".$ro['RoomType_Id']."' and creditheadid= (select revenue_id from Mas_Revenue where RevenueHead='ROOM RENT')";
              $exe = $this->db->query($qry3);
			  foreach ($exe->result_array() as $rows)
			  {
                
                echo '<td style="text-align: right;">'.$rows['pax'].'</td>';	
			  }

            }

            $qry4 = "select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce where ce.CreditDate  between '".$a_date."' and '".$a_date."'";
            $exc = $this->db->query($qry4);
            foreach($exc ->result_array() as $exc){
                $totalamount += $exc['Amount'];
                echo '<td style="text-align: right;">'.$exc['Amount'].'</td>';	
            }

            $qry5 = "select isnull(sum(detr.noofpersons),0) as totalpax from trans_roomdet_det detr 
            inner join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
            and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='ROOM RENT')
            where tce.CreditDate  between '".$a_date."' and '".$a_date."' ";
            $exc = $this->db->query($qry5);
            foreach($exc ->result_array() as $excc){
                $totalpax += $excc['totalpax'];
                echo '<td style="text-align: right;">'.$excc['totalpax'].'</td>';
                if($excc['totalpax'] !=0){
                  $perocc +=$excc['totalpax']/$roomcount;
                  echo '<td style="text-align: right;">'.(($excc['totalpax']/$roomcount)).'%'.'</td>';
                }
                
            }

           

            $qry7 = "select isnull(sum(detr.extrabed),0) as extracount from trans_roomdet_det detr 
            left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
            and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
            where tce.CreditDate between '".$a_date."' and '".$a_date."' ";
            $exc = $this->db->query($qry7);
            foreach($exc ->result_array() as $excc){
                $totalcount += $excc['extracount'];
                echo '<td style="text-align: right;">'.$excc['extracount'].'</td>';	
            }


            $qry6 ="select isnull(sum(Amount),0) as extrabedAmount from trans_roomdet_det detr 
                    left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                    and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                    where tce.CreditDate between '".$a_date."' and '".$a_date."' ";
                    $exc = $this->db->query($qry6);
                    foreach($exc ->result_array() as $excc){
                        $totalbedamount += $excc['extrabedAmount'];
                        echo '<td style="text-align: right;">'.$excc['extrabedAmount'].'</td>';	
                    }
              echo '</tr>';
              $a_date = date("Y-m-d",strtotime ('+1 day' , strtotime ($a_date)));
                }
             
			 if($advance !=0)
			  {
				echo '<tr>';
                echo '<td style="text-align: right;">Total</td>';
                $ro ="select * from mas_roomtype where inactive<>1 order by RoomType_id";
                $ex = $this->db->query($ro);
                foreach($ex -> result_array() as $ro){
                $qry1 = "select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce
              inner join trans_roomdet_det det on ce.roomid=det.roomid and ce.roomgrcid=det.roomgrcid and ce.grcid=det.grcid
              where ce.CreditDate between '".$fromdate."' and '".$todate."' and det.typeid='".$ro['RoomType_Id']."'
              
             ";

              $exe = $this->db->query($qry1);
              
			  foreach ($exe->result_array() as $rows)
			  {
               
          echo '<td style="text-align: right;">'.$rows['Amount'].'</td>';			
			  }
            $qry3 = "select isnull(sum(noofpersons),0) as pax from Trans_Credit_Entry ce
              inner join trans_roomdet_det det on ce.roomid=det.roomid and ce.roomgrcid=det.roomgrcid and ce.grcid=det.grcid
              where ce.CreditDate between '".$fromdate."' and '".$todate."' and det.typeid='".$ro['RoomType_Id']."' and creditheadid= (select revenue_id from Mas_Revenue where RevenueHead='ROOM RENT')";
              $exe = $this->db->query($qry3);
			  foreach ($exe->result_array() as $rows)
			  {
              
          echo '<td style="text-align: right;">'.$rows['pax'].'</td>';	
			  }	
            }
            echo '<td style="text-align: right;">'.$totalamount.'</td>';	
            echo '<td style="text-align: right;">'.$totalpax.'</td>';
            echo '<td style="text-align: right;">'.(($perocc/$roomcount)*100).'%'.'</td>';		
            echo '<td style="text-align: right;">'.$totalcount.'</td>';	
            echo '<td style="text-align: right;">'.$totalbedamount.'</td>';	
               
				echo '</tr>';			
        
        echo '<tr>';
        echo '<td style="text-align: right;"></td>';	
        echo '<td style="text-align: right;"></td>';
        $ro ="select * from mas_roomtype where inactive<>1 order by RoomType_id";
        $ex = $this->db->query($ro);
        foreach($ex -> result_array() as $ro){
          $qry3 = "select isnull(sum(noofpersons),0) as pax from Trans_Credit_Entry ce
              inner join trans_roomdet_det det on ce.roomid=det.roomid and ce.roomgrcid=det.roomgrcid and ce.grcid=det.grcid
              where ce.CreditDate between '".$fromdate."' and '".$todate."' and det.typeid='".$ro['RoomType_Id']."' and creditheadid= (select revenue_id from Mas_Revenue where RevenueHead='ROOM RENT')";
              $exe = $this->db->query($qry3);
			  foreach ($exe->result_array() as $rows)
			  {
           if($rows['pax'] != 0){
          echo '<td style="text-align: right;">'.(($rows['pax']/$totalpax)*100).'%'.'</td>';	
          echo '<td style="text-align: right;"></td>';	
           }
			  }		
        }
        echo '<td style="text-align: right;"></td>';	
        echo '</tr>';

        echo '<tr>';
        $qurys = "select * from usertable where User_id='".User_id."' ";
        $ops = $this->db->query($qurys);
        foreach($ops -> result_array() as $rows){
        echo '<td colspan="6">'.'USER NAME: '.$rows['EmailId'].'</td>';
        echo '<td colspan="6">'.'DATE : '.date('d-m-Y').'</td>';
        }
        echo '</tr>';
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
              filename: "Occupancy Analysis Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("Occupancy Analysis Report.pdf");
                }
            });
        });
	</SCRIPT>


