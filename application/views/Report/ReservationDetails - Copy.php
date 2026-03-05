<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Reservation Details');
$this->pfrm->FrmHead4('Report / Reservation Details',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="frmdate" name="Fdate"   class="scs-ctrl Dat2" />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="todate" name="Tdate"   class="scs-ctrl Dat2" />
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
				<h3 class="text-center">Reservation Details  <?php echo date('d-m-Y', strtotime($_POST['Fdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['Tdate'])); ?><h3>
		    </div>        
		   <tbody>
		    <?php 

			       $i=1;
            //  $Fromdate=date('Y-m-d');
            //  $Todate = date('Y-m-d');
            //  if(isset($_POST['Fdate'])){
              $Fromdate= date('Y-m-d',strtotime($_POST['Fdate']));
              $Todate= date('Y-m-d',strtotime($_POST['Tdate']));
            //  }
			
		      	 $qry="select tmas.Amount as advanceamount, * from Trans_reserve_mas mas 
              inner join Trans_reserve_det det on  det.resid = mas.Resid 
              inner join Mas_roomtype on  RoomType_Id=(select RoomType_Id from Mas_Room where Room_Id=mas.Roomid) 
              left outer join Trans_Receipt_mas tmas on tmas.resdetid= det.resdetid and tmas.ReceiptType='A'
              where mas.stat<>'C' and mas.Resdate between '".$Fromdate."' and '".$Todate."' ";
			 $exec=$this->db->query($qry); 
			 $advance= $exec->num_rows();
       $advanceamt=0;
			  if($advance !=0)
			  {
				echo '<tr>';		 
				echo '<td  style="text-align: center;">S.no</td>';
				echo '<td  style="text-align: center;">ResNo</td>';
                echo '<td  style="text-align: center;">Res.Date</td>';
				echo '<td style="text-align: center;">Arr.Date</td>';
				echo '<td style="text-align: center;">Arr.Time</td>';
				echo '<td style="text-align: center;">Room Type</td>';
				echo '<td style="text-align: center;">Total Room rent</td>';
        echo '<td style="text-align: center;">Advance Amount</td>';
				echo '</tr>';			

			  }			 
			  foreach ($exec->result_array() as $rows)
			  {		
                $time= new dateTime($rows['fromtime']);	
                
                if($rows['advanceamount'] !=NULL){
                  $advanceamt=$rows['advanceamount'];
                }
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows['ResNo'].'</td>';
                echo '<td  style="text-align: center;">'.date('d-m-Y', strtotime(substr($rows['Resdate'],0,10))).'</td>';
                echo '<td  style="text-align: center;">'.date('d-m-Y', strtotime(substr($rows['fromdate'],0,10))).'</td>';
                echo '<td  style="text-align: center;">'.$time->format('H:i').'</td>';
                echo '<td  style="text-align: center;">'.$rows['RoomType'].'</td>';
                echo '<td  style="text-align: center;">'.$rows['totalroomrent'].'</td>';
                echo '<td  style="text-align: center;">'.$advanceamt.'</td>';

				
				echo '</tr>';				
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
?>
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

	</SCRIPT>