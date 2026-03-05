<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();

?>

 <?php 
 $sql ="select * from mas_Hotel where company='Meena Residency'";
 $res = $this->db->query($sql);
 foreach($res->result_array() as $row){
	$company = $row['Company'];
	$address = $row['Address'];
	$city = $row['City'];
	$pincode = $row['PinCode'];
	$email = $row['Email'];
	$mobile = $row['MobileNo'];
	$phone = $row['Phone']; 
 }

 $sql2 = "select * from usertable where User_id='".User_id."'";
 $res1= $this->db->query($sql2);
 foreach($res1->result_array() as $row1){
	$username = $row1['EmailId'];
 }
 ?>
 <style>
    thead td{
        border:1px solid whitesmoke;
    }
	@page
	 {
  size: A4;
  margin: 11mm 17mm 17mm 17mm;
}

@media print {
  header,footer {
    position: fixed;
   
  }
  #pageDiv{
	position: fixed;
    bottom: 0;
    width: 100%;
    height: 2.5rem; 
  }
}

	body {
    counter-reset: pageFooter;
}

#pageDiv {
	page-break-after: always;
	/* border-bottom: 1px solid #000; */
	position: fixed;
	bottom: 0;
	height: 2.5rem;  
	display: flex;
	flex-direction: row;
	justify-content: space-between;    
}

	#pageFooter:after {
    counter-increment: pageFooter;
    content:"Page " counter(pageFooter);
    left: 0; 
    top: 100%;
    white-space: nowrap; 
    z-index: 20;
    -moz-border-radius: 5px; 
    -moz-box-shadow: 0px 0px 4px #222;  
    background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);  
  }   

  thead{
	border: 0.1rem solid #000;
	border-bottom:0.2rem solid #000;
  }
 </style>


</div>
    <div id="printing" class="col-sm-12">		
        <table   class="table table-responsive " style="padding:0px;" >   
			<thead>
				<tr>
					<td colspan="2" style="border:none;width:40px; padding-bottom:0px !important;"><h4><?php echo $company;?></h4></td>
					<td id="caption" colspan="6" class="text-uppercase align-center" rowspan="3" style="text-align:center; border:none;width:40px;"><h4>High Balance Report From <?php echo date('d-m-Y') ?></h4></td>
                    <td rowspan="3" colspan="2" style="text-align:center; border:none; width:20px; padding-bottom:0px !important;"><img  style="width:80px; height:80px;" src="../../upload/logo.png"> </td>
				</tr>
                <tr >
					<td colspan="3" style="border:none;width:40px; padding-top:0px !important; padding-bottom:0px !important"><?php echo $address.$city.'.'; echo "</br>".'Mobile No: '.$mobile; echo "<br>".'Phone No: '.$phone;?></td>
				</tr>
                <tr >
					<td colspan="11" style="border:1px solid #000; border-top:none; padding-top:0px !important;" >Date : <?php echo date('d-m-Y h:i:sa')?> </td>
				</tr>
			</thead>
		   <tbody id="tbody">
		    <?php 
			 $i=1;
			 $norow=0; $CASH=0; $CARD=0; $NEFT=0; $ROOM=0;

	         $qry="select cin.CheckinDate,cin.CheckinTime,cin.Noadults,rs.roomgrcid,isnull(adv.amount,0) advance,isnull(trc.billamount,0) billamount,isnull(trd.discamt,0) as discamt  ,rmas.roomno,ti.title + '.' +cmas.Firstname as customer,case when isnull(cp.company,'') <> '' then cp.company else cin.company end as company,tdet.depdate,cast(tdet.deptime as datetime) as deptime  from  (select roomgrcid from room_status where status='Y') as rs  
			     left outer join  (select sum(isnull(mas.amount,0)) amount,mas.roomgrcid from trans_advancereceipt_mas mas  
				 inner join trans_receipt_mas trm on trm.receiptid=mas.receiptid where mas.type='RMS' and  mas.roomgrcid in (select roomgrcid from room_status rs where status='Y')   group by mas.roomgrcid) as adv on rs.roomgrcid=adv.roomgrcid  
				  left outer join (select sum(isnull(amount,0)) billamount,roomgrcid from trans_credit_entry tc 
				 left outer join Mas_Revenue cd on cd.Revenue_Id=tc.creditheadid where creditordebit<>'D'   and roomgrcid in (select roomgrcid from room_status where status='Y') group by roomgrcid) as trc on trc.roomgrcid=rs.roomgrcid  
				  left outer join (select sum(isnull(amount,0)) Discamt,roomgrcid from trans_credit_entry tc  
				 left outer join Mas_Revenue cd on cd.Revenue_Id=tc.creditheadid where creditordebit = 'D' and Taxhead not in ('ADVANCE')  and roomgrcid in (select roomgrcid from room_status where status='Y') group by roomgrcid) as trd on trd.roomgrcid=rs.roomgrcid 
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
				echo '<tr>';		 
				echo '<td  style="text-align: center;">Room No-Pax</td>';
				echo '<td  style="text-align: center;">No.Days</td>';
				echo '<td style="text-align: center;">Customer</td>';
				echo '<td style="text-align: center;">Company</td>';
				echo '<td style="text-align: center;">Chk.Dt</td>';
				echo '<td style="text-align: center;">Chk.Time</td>';
				echo '<td style="text-align: center;">Bill.Amt</td>';
				echo '<td style="text-align: center;">Advance</td>';
				echo '<td style="text-align: center;">Balance</td>';
				echo '<td style="text-align: center;">Refund</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {				
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$rows['roomno'].'-'.$rows['Noadults'].'</td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;">'.$rows['customer'].'</td>';
				echo '<td style="text-align: left;">'.$rows['company'].'</td>';				
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['CheckinDate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows['CheckinTime'],11,5).'</td>';
				echo '<td style="text-align: center;">'.$rows['billamount'].'</td>';
				echo '<td style="text-align: right;">'.$rows['advance'].'</td>';
				echo '<td style="text-align: right;">'.$rows['billamount']-$rows['advance'].'</td>';
				echo '</tr>';				
			  }	
			

				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';	
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
				echo '</tr>';
				echo '<tr>';		 
				echo '<td  style="text-align: center;"></td>';
				echo '<td  style="text-align: center;">1</td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;"></td>';
				echo '</tr>';
		   ?>	
		
		   </tbody>

		 </table>

      
	</div>

	<div id="pageDiv">
			</div>

<?php 
$this->pweb->wfoott();
$this->pcss->wjs($F_Ctrl);
?>
 <SCRIPT>

$(document).ready(function(){

	window.onload = addPageNumbers();
	window.print();

function addPageNumbers() {

    var totalPages = Math.ceil(document.body.scrollHeight / 842 ); //842px A4 pageheight for 72dpi, 1123px A4 pageheight for 96dpi, 
    for (var i = 1; i <= totalPages; i++) {
	var pageNumberDiv = document.createElement("div");
	var pageNumber = document.createTextNode("Page " + i + " of " + totalPages);
	pageNumberDiv.style.position = "absolute";
	pageNumberDiv.style.top = "calc((" + i + " * (297mm - 0.5px)) - 30px)"; //297mm A4 pageheight; 0,5px unknown needed necessary correction value; additional wanted 40px margin from bottom(own element height included)
	pageNumberDiv.style.height = "16px";
	pageNumberDiv.appendChild(pageNumber);
	document.body.insertBefore(pageNumberDiv, document.getElementById("pageDiv"));
	pageNumberDiv.style.left = "calc(100% - (" + pageNumberDiv.offsetWidth + "px + 20px))";
	var userDiv = document.createElement("div");
	var user = document.createTextNode("User : " + '<?php echo $username?>');
	userDiv.style.position = "absolute";
	userDiv.style.top = "calc((" + i + " * (297mm - 0.5px)) - 30px)"; //297mm A4 pageheight; 0,5px unknown needed necessary correction value; additional wanted 40px margin from bottom(own element height included)
	userDiv.style.height = "16px";
	userDiv.appendChild(user);
	document.body.insertBefore(userDiv, document.getElementById("pageDiv"));
	userDiv.style.right = "calc(100% - (" + userDiv.offsetWidth + "px + 20px))";
  }

}

window.location.href ="<?php echo scs_index ?>Report/HighBalanceReport";

});
</SCRIPT>