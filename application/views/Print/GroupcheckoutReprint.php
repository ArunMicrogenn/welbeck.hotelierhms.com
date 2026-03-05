<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Print','GroupCheckout Reprint');
$this->pfrm->FrmHead4('Print / GroupCheckout Reprint','CheckoutBill',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");


$Res=$this->Myclass->Hotel_Details();
	foreach($Res as $row) 
	{
		$Company=$row['Company'];
		$Address=$row['Address'];
		$Address1=$row['Address1'];
		$City= $row['City'];
		$Pin=$row['PinCode']; 
		$State=$row['State'];
		$Gstinn=$row['Gstinn'];
		$Phone=$row['Phone'];
		$logo=$row['logo'];
		if($row['Email']=='')
		{ $Email='';}
	    else { $Email='Email:'.$row['Email']; } 
	}

	 $cityses = "select City from mas_city where Cityid = '".$City."'";
$cityqry = $this->db->query($cityses)->row_array();  

	$chidqry = "select grpcheckoutbillid from trans_checkout_mas where grpcheckoutbillid = '".$_REQUEST['Checkoutid']."'";
	$chidexes = $this->db->query($chidqry)->row_array();

      $sql="SELECT 
    ci.city,
    DATEDIFF(DAY, ckmas.CheckinDate, cmas.Checkoutdate) AS noofdayss,cus.Company,*
   FROM 
    Trans_checkout_mas cmas
		inner join Mas_Customer cus on cmas.Customerid=cus.Customer_Id
		inner join Mas_Title ti on ti.Titleid=cus.Titelid
		inner join Trans_Roomdet_det rdet on rdet.roomgrcid=cmas.Roomgrcid
		inner join Mas_RoomType rtype on rtype.RoomType_Id=rdet.typeid
		inner join Mas_Room rm on rm.Room_Id=rdet.Roomid
		inner join Trans_Checkin_mas ckmas on ckmas.Grcid=rdet.grcid
		inner join Mas_City ci on ci.Cityid=cus.Cityid
		left outer join Mas_Company com on com.Company_Id=cus.company_id 
		left outer join UserTable us on us.User_id=cmas.userid
		where cmas.grpcheckoutbillid = '".$chidexes['grpcheckoutbillid']."' and  isnull(cmas.cancelflag,0)<>1 ";

	$res=$this->db->query($sql); 
	foreach ($res->result_array() as $row)
	{   $Grcid=$row['Grcid'];
		$Roomgrcid=$row['Roomgrcid'];
		$Checkoutno=$row['Checkoutno'];
		$Checkoutdate=$row['Checkoutdate'];
		$Title=$row['Title'];
		$gname=$row['Firstname'];
		$RoomType=$row['RoomType'];
		$RoomNo=$row['RoomNo'];
		$GAddress1=$row['HomeAddress1'];
		$GAddress2=$row['HomeAddress2'];
		$checkindate=$row['CheckinDate'];
		$checkintime=$row['CheckinTime'];
		$Noofpersons=$row['Noofpersons'];
		$city=$row['city'];
		$Checkouttime=$row['Checkouttime'];
		$noofdays=$row['noofdays'];
		$noofdayss=$row['noofdayss'];
		$Mobile=$row['Mobile'];
		$FoodPlan='';
		 $Actrackrate=$row['roomrent'];
		$UserName=$row['EmailId'];
		 $GCompany=$row['Company'];
		$GGstno=$row['Gstno'];
		$yearprefix = $row['yearPrefix'];
	}	
	                
?>
<style>
#printing table tr td{
	padding:0px 10px 0px 10px;
}

</style>

<?php 
$chidqry = "select grpcheckoutbillid from trans_checkout_mas where grpcheckoutbillid = '".$_REQUEST['Checkoutid']."'";
$chidexes = $this->db->query($chidqry)->row_array();

    $Checkoutqry = "select RoomNo from trans_checkout_mas tmas 
inner join mas_room mr on mr.Room_Id = tmas.Roomid
where tmas.grpcheckoutbillid = '".$chidexes['grpcheckoutbillid']."'";

$chidexe = $this->db->query($Checkoutqry)->result_array();


  $totpaxqry  = "select isnull(noofpersons,0) as noofpersons from trans_checkout_mas 
where grpcheckoutbillid = '".$chidexes['grpcheckoutbillid']."'";

$totpax = $this->db->query($totpaxqry)->result_array();
$totalpax = 0;
foreach($totpax as $totpax){

	$totalpax += $totpax['noofpersons'];
	
}



$sql1="select sum(creditheadid) as totaldays from Trans_credit_entry where roomgrcid='". $Roomgrcid."'and creditheadid IN (select Revenue_Id from mas_revenue where RevenueHead = 'ROOM RENT')";
$exe=$this->db->query($sql1);
foreach ($exe->result_array() as $row1)
{
	 $totaldays=$row1['totaldays'];
}

$adv = "
    SELECT SUM(tam.Amount) AS Amount 
    FROM Trans_advancereceipt_mas tam
    INNER JOIN trans_receipt_mas trm ON trm.roomgrcid = tam.roomgrcid 
    WHERE tam.roomgrcid = '".$Roomgrcid."' AND ISNULL(tam.type, '') = 'RMS'";

$advres = $this->db->query($adv);
$advance = $advres->row_array(); 

$tadv = isset($advance['Amount']) ? $advance['Amount'] : 0; 

?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
     <div id="printing">
        <table style="border-right:1px solid #000;border-top:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;width:100%">
		<thead>
					<tr>
					 <!-- <th rowspan="5"  style="width:20%"><img style="width:100%;" src="<?php echo scs_url ?>upload/logo.png"/></th> -->

					 <th rowspan="5" style="width:20%">
    <img style="width:100%;" src="<?php echo scs_url . $logo; ?>" />
</th>
					 <th colspan="2" style="width:80%" ><h2><?php echo $Company; ?></h2></th>									
					</tr>				
					<tr>
					<th colspan="2" style="width:80%" ><?php echo $Address." ".$Address1; ?></th>
					</tr> 					
					<tr>
					 <th colspan="2" style="width:80%"><?php echo $cityqry['City']."-".$Pin.". ".$State; ?></th>
					</tr>
					<tr>
					 <th colspan="2" style="width:80%"> <?php echo $Phone." " .$Email;; ?></th>
					</tr>
					<tr>
					 <th colspan="2" style="width:80%"> <?php echo "GSTNO - ".$Gstinn; ?></th>
					</tr>
				</thead>
		</table>
		<table style="border-right:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;width:100%">
    			<tbody>
    			  <tr>
    				<td  style="width:40%"><b>Guest Details : </b></td>
    				<td  style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b> &nbsp; Bill No &nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;<?php echo $yearprefix.'/'.$Checkoutno;?></b></td>					<td  style="border-bottom:1px solid #000;width:30%"> <b>&nbsp; Bill Date &nbsp;&nbsp;&nbsp;: </b><b><?php echo date('d-m-Y', strtotime($Checkoutdate)); ?></b></td>
    			  </tr> 
				  <tr>
    				<td style="width:40%" ><?php echo  $Title.".".$gname; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%" ><b>&nbsp;Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b>&nbsp;<?php echo $RoomType; ?></td>
                 
        <td style="border-bottom:1px solid #000;width:30%">
        <b>&nbsp;Room &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>&nbsp; <?php echo $row['RoomNo']; ?></td>
    			  </tr> 
				  <tr>
    				<td style="width:40%" ><?php echo $GAddress1." , ".$GAddress2; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>&nbsp;Arr.Date &nbsp;&nbsp;:</b>&nbsp;<?php echo  date('d-m-Y', strtotime($checkindate))."-".substr($checkintime,10,6); ?></td>
					<td style="border-bottom:1px solid #000;width:30%"><b>&nbsp;Pax &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>&nbsp;<?php echo $totalpax; ?></td>
    			  </tr>
				  <tr>
    				<td style="width:40%"><?php echo $cityqry['City']; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>&nbsp;Dep.Date :</b>&nbsp;<?php echo date('d-m-Y',strtotime($Checkoutdate))."-".substr($Checkouttime,10,6); ?></td>
					<!-- <td style="border-bottom:1px solid #000;width:30%"><b>&nbsp;Days &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b>&nbsp;<?php echo number_format($noofdayss); ?></td> -->
					<td style="border-bottom:1px solid #000;width:30%"><b>&nbsp;Days &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b>&nbsp;<?php echo number_format($totaldays); ?></td>
				</tr>
				  <tr>
    				<td style="width:40%"><b><?php echo "Mobile No : ".$Mobile; ?></b></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>&nbsp;Plan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>&nbsp;<?php echo $FoodPlan; ?></td>
					<td style="border-bottom:1px solid #000;width:30%"><b> &nbsp;Rack Tariff :</b>&nbsp;<?php echo $Actrackrate; ?></td>
    			  </tr>
				  <tr>
                  <td style="width:50%"><b></b></td>
				    <td style="border-left:1px solid #000;border-bottom:1px solid #000;width:50%;text-align:left" colspan="2"><b>&nbsp;Room &nbsp;&nbsp;&nbsp;&nbsp;: </b>&nbsp;
                  
                    <?php 
                    $rooms = array_column($chidexe, 'RoomNo'); 
                    echo implode(', ', $rooms);
                          ?>
                   </td>

   
				  </tr>
				  <?php if(substr($Checkoutno,0,3) != 'WHK'){ ?>
					
				  <tr>  
				    <td style="width:50%"><?php echo $GCompany.' - '.$GGstno; ?></td>
				    <td style="border-left:1px solid #000;width:50%;text-align:center" colspan="2"><?php echo "<b>TAX INVOICE<b>" ?></td>
				  </tr>
				  <?php } ?>
				</tbody>
		</table> 		
		<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:100%">								
    			   <tbody>
					<tr>
    					<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%;text-align:center;"><b>Date</b></td>
    					<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%;text-align:center;"><b>Ref.No</b></td>
						<td style="background:#aad0ff;border-bottom:1px solid #000;border-right:1px solid #000;width:40%;text-align:center;"><b>Particulars</b></td>
						<td style="background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;text-align:center;"><b>Charges</b></td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;text-align:center;"><b>Credit</b></td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;width:10%;text-align:center;"><b>Total</b></td>
    				</tr>
			<?php 
			    $begin = new DateTime($checkindate);
				$end = new DateTime($Checkoutdate);  $NextPage=0;
				 $rowcount=1; $TotalCredit=0; $Totaldebit=0; $NextPageHeader=0;
				for($i = $begin; $i <= $end; $i->modify('+1 day'))
				{   $Daytotal=0;
					$loopdate= $i->format("Y-m-d");
				
				  	// $sql1="select mr.creditordebit,ce.CreditDate,ce.CreditNo,mr.RevenueHead,ce.Amount,Ord, chNo from Trans_Credit_Entry ce
					// inner join Mas_Revenue mr on mr.Revenue_Id=ce.Creditheadid
					//  where Roomgrcid='".$Roomgrcid."' and CreditDate='".$loopdate."'
					//  union 
					//  select 'D' as creditordebit,rptdate as CreditDate,Receiptno as CreditNo,'Advance' as RevenueHead,
					//  Amount,'5' as Ord , '' as chNo from Trans_Receipt_mas 
					//  where roomgrcid='".$Roomgrcid."' and cancel=0 and isnull(ReceiptType,'')='C'  and rptdate='".$loopdate."'
					//  Order by Ord ";
					$rmgrcqry = "select roomgrcid from trans_checkout_mas where grpcheckoutbillid = '".$_REQUEST['Checkoutid']."'";
					$rmgrc = $this->db->query($rmgrcqry)->result_array();
					foreach($rmgrc as $rmgrc) {
					 $sql1 ="select mrom.RoomNo,mr.creditordebit,ce.CreditDate,ce.CreditNo,mr.RevenueHead,ce.Amount,Ord, chNo from Trans_Credit_Entry ce 
                     inner join mas_room mrom on mrom.Room_id = ce.Roomid
                     inner join Mas_Revenue mr on mr.Revenue_Id=ce.Creditheadid where Roomgrcid = '".$rmgrc['roomgrcid']."' and CreditDate='".$loopdate."'
                      union 
					  select mrom.RoomNo , 'D' as creditordebit,rptdate as CreditDate,Receiptno as CreditNo,'Advance' as RevenueHead, sum(tmas.Amount),'5' as Ord , '' as chNo from Trans_Receipt_mas rmas
					  inner join trans_advancereceipt_mas tmas on rmas.receiptid = tmas.receiptid and isnull(tmas.type,'') = 'RMS'
					  left outer join  mas_room mrom on mrom.Room_id=rmas.Roomid
					  where tmas.roomgrcid ='".$rmgrc['roomgrcid']."' and isnull(cancel,0)=0 and isnull(ReceiptType,'')='C' and rptdate='".$loopdate."' 
					  group by rmas.rptdate,rmas.receiptno,mrom.RoomNo
					  Order by creditNo,creditDate,Ord";
					$res1=$this->db->query($sql1); 							
					foreach ($res1->result_array() as $row1)
					{ 			  
					$Creditordebit=$row1['creditordebit'];
			        if($Creditordebit=='C')
					{		?>
					<tr>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"><?php echo  date('d-m-Y', strtotime($row1['CreditDate'])); ?></td>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"><?php echo $row1['CreditNo']; ?></td>
						<td style="border-right:1px solid #000;width:40%">
						<?php if($row1['RevenueHead'] == 'Transfer CR')
						{ 
							echo $row1['RevenueHead'] .' ('. $row1['chNo'].')';
						 } 
						 else {
							if($row1['RevenueHead'] == 'ROOM RENT'){
								echo '#'.$row1['RoomNo'] . ' - ' . $row1['RevenueHead'] ; 
							} else{
								echo $row1['RevenueHead']; 

							}
							} ?></td>
						<td style="text-align:right;border-right:1px solid #000;width:10%"><?php echo number_format ($row1['Amount'],2); $Daytotal=$Daytotal+$row1['Amount']; $TotalCredit=$TotalCredit+$row1['Amount']; ?></td>
						<td style="text-align:right;border-right:1px solid #000;width:10%"><?php echo "0.00"; ?></td>
						<td style="text-align:right;width:10%"><?php echo "0.00"; ?></td>
    				</tr>
					
					<?php   }
					else
					{   ?>
					<tr>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"><?php echo  date('d-m-Y', strtotime($row1['CreditDate'])); ?></td>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"><?php echo $row1['CreditNo']; ?></td>
						<td style="border-right:1px solid #000;width:40%"><?php if($row1['RevenueHead'] == 'Transfer CR'){ echo $row1['RevenueHead'].' ('. $row1['chNo'].')'; } else {echo $row1['RevenueHead']; } ?></td>
						<td style="text-align:right;border-right:1px solid #000;width:10%">0.00</td>
						<td style="text-align:right;border-right:1px solid #000;width:10%"><?php echo number_format ($row1['Amount'],2); $Daytotal=$Daytotal-$row1['Amount']; $Totaldebit=$Totaldebit+$row1['Amount']; ?></td>
						<td style="text-align:right;width:10%">0.00</td>
    				</tr>	
			<?php	} 
					 ?>
											
			<?php	$rowcount++;}
				if($Daytotal !=0){ 						
				     ?>
					<tr>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"><?php echo  date('d-m-Y', strtotime($loopdate)); ?></td>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"></td>
						<td style="border-right:1px solid #000;width:40%"><?php echo "Day Total" ?></td>
						<td style="text-align:right;border-right:1px solid #000;width:10%"></td>
						<td style="text-align:right;border-right:1px solid #000;width:10%"></td>
						<td style="text-align:right;width:10%"><?php echo number_format ($Daytotal,2);  ?></td>
    				</tr>
				<?php	
				$rowcount++;		      
				}				
				if($rowcount >25)
				{ 				
					?>
				   <tr>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"></td>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"></td>
						<td style="border-right:1px solid #000;width:40%"><?php echo "To be continue..." ?></td>
						<td style="text-align:right;border-right:1px solid #000;width:10%"></td>
						<td style="text-align:right;border-right:1px solid #000;width:10%"></td>
						<td style="text-align:right;width:10%"></td>
    				</tr>
				<?php
				 for($j=$rowcount;$j<=35; $j++)
				 {  
					?>
				   <tr>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"></td>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"></td>
						<td style="border-right:1px solid #000;width:40%">&nbsp;</td>
						<td style="text-align:right;border-right:1px solid #000;width:10%"></td>
						<td style="text-align:right;border-right:1px solid #000;width:10%"></td>
						<td style="text-align:right;width:10%"></td>
    				</tr>
				<?php
					$NextPage=1;
				 }
				 if($NextPage !=0)
				 {  $NextPage=0;  
					$rowcount=1;
					$NextPageHeader=1;
				  ?>
					<table style="border-right:1px solid #000;border-top:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;width:100%">
					<thead>
						<tr>
						 <th rowspan="4"  style="width:20%"><img src="<?php echo scs_url ?>upload/logo.png"/></th>
						 <th colspan="2" style="width:80%"><h2><?php echo $Company; ?></h2></th>									
						</tr>
						<tr>
						 <th colspan="2" style="width:80%" ><?php echo $Address." ".$Address1; ?></th>
						</tr> 
						<tr>
						 <th colspan="2" style="width:80%"><?php echo $City."-".$Pin.". ".$State; ?></th>
						</tr>
						<tr>
						 <th colspan="2" style="width:80%"><?php echo $Phone."," .$Email;; ?></th>
						</tr>
					</thead>
					</table>
					<table style="border-right:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;width:100%">
					<tbody>
					  <tr>
						<td  style="width:40%">Guest Details : </td>
						<td  style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%">Bill No :<?php echo $yearprefix.'/'.$Checkoutno;; ?></td>
						<td  style="border-bottom:1px solid #000;width:30%">Bill Date :<?php echo date('d-m-Y', strtotime($Checkoutdate)); ?></td>
					  </tr> 
					  <tr>
						<td style="width:40%" ><?php echo  $Title.".".$gname; ?></td>
						<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%" >Type :<?php echo $RoomType; ?></td>
						<td style="border-bottom:1px solid #000;width:30%">Room :<?php echo $RoomNo; ?></td>
					  </tr> 
					  <tr>
						<td style="width:40%" ><?php echo $GAddress1." , ".$GAddress2; ?></td>
						<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%">Arr.Date :<?php echo  date('d-m-Y', strtotime($checkindate))."-".substr($checkintime,10,6); ?></td>
						<td style="border-bottom:1px solid #000;width:30%">Pax :<?php echo $Noofpersons; ?></td>
					  </tr>
					  <tr>
						<td style="width:40%"><?php echo $city; ?></td>
						<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%">Dep.Date :<?php echo date('d-m-Y',strtotime($Checkoutdate))."-".substr($Checkouttime,10,6); ?></td>
						<td style="border-bottom:1px solid #000;width:30%">Days :<?php echo number_format($noofdays); ?></td>
					  </tr>
					  <tr>
						<td style="width:40%"><?php echo "Mobile No:".$Mobile; ?></td>
						<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%">Plan :<?php echo $FoodPlan; ?></td>
						<td style="border-bottom:1px solid #000;width:30%">Rack Tariff :<?php echo $Actrackrate; ?></td>
					  </tr>
					  <?php if(substr($Checkoutno,0,3) != 'WHK'){ ?> 
					  <tr>  
						<td style="width:50%"><?php echo $GCompany.' - '.$GGstno; ?></td>
						<td style="border-left:1px solid #000;width:50%;text-align:center" colspan="2"><?php echo "<b>TAX INVOICE - ".$Gstinn."<b>" ?></td>
					  </tr>
					  <?php } ?>
					</tbody>
					</table> 		
				<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:100%">								
	   		    <tbody>
					<tr>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%">Date</td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%">Ref.No</td>
						<td style="background:#aad0ff;border-bottom:1px solid #000;border-right:1px solid #000;width:40%">Particulars</td>
						<td style="background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Charges</td>
						<td style="background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Credit</td>
						<td style="background:#aad0ff;text-align:right;border-bottom:1px solid #000;width:10%">Total</td>
					</tr>			
			<?php
				  }
				 
				}
			 }
			}	
			 if($rowcount < 25)	 
			 { 
				for($j=$rowcount;$j<=25; $j++)
				{  
				   ?>
				  <tr>
					   <td style="text-align:center;border-right:1px solid #000;width:15%"></td>
					   <td style="text-align:center;border-right:1px solid #000;width:15%"></td>
					   <td style="border-right:1px solid #000;width:40%">&nbsp;</td>
					   <td style="text-align:right;border-right:1px solid #000;width:10%"></td>
					   <td style="text-align:right;border-right:1px solid #000;width:10%"></td>
					   <td style="text-align:right;width:10%"></td>
				   </tr>
			   <?php
				  
				}
			 }
			?>  
				</tbody>	
				</table>
				<?php 
				$sql="select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce
					inner join Mas_Revenue mr on mr.Revenue_Id=ce.Creditheadid
					where  Roomgrcid IN(select roomgrcid from trans_checkout_mas where grpcheckoutbillid = '".$_REQUEST['Checkoutid']."') and mr.RevenueHead in ('ROOM RENT','Extra Bed') 
					/*Group by ce.Amount*/ ";
					$res=$this->db->query($sql); 
					$taxsummary= $res->num_rows();
				if($taxsummary !=0)
				{
				?>
				<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
    			   <tbody>
				   <tr>
    				<td colspan="7" style="text-align:center;border-bottom:1px solid #000;"><b> TAX SUMMARY </b></td>									
	    			</tr>
					<tr>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%"><b>Description</b></td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%"><b>HSN Code</b></td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%"><b>Tax Amt</b></td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%"><b>CGST%</b></td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%"><b>CGST</b></td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%"><b>SGST%</b></td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;width:15%"><b>SGST</b></td>
					</tr>
					<?php
					 foreach ($res->result_array() as $row)
					{
					?>
					<tr>
						<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%">ROOM RENT</td>
						<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%"></td>
						<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%"><?php echo number_format ($row['Amount'],2); ?></td>
						<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">6.00</td>
						<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%"><?php echo number_format(($row['Amount']*6)/100,2); ?></td>
						<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">6.00</td>
						<td style="text-align:center;border-bottom:1px solid #000;width:15%"><?php echo number_format(($row['Amount']*6)/100,2); ?></td>
					</tr>
					<?php 
					}
					?>
					</tbody>						
				</table>
					<?php
				}
					   $number = ($TotalCredit)-($Totaldebit);						 
						if ($number < 0) {
							$number = $number * -1;
						}										
					   $no = floor($number);
					   $point = round($number - $no, 2) * 100;
					   $hundred = null;
					   $digits_1 = strlen($no);
					   $i = 0;
					   $str = array();
					   $words = array('0' => '', '1' => 'one', '2' => 'two',
						'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
						'7' => 'seven', '8' => 'eight', '9' => 'nine',
						'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
						'13' => 'thirteen', '14' => 'fourteen',
						'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
						'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
						'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
						'60' => 'sixty', '70' => 'seventy',
						'80' => 'eighty', '90' => 'ninety');
					   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
					   while ($i < $digits_1) {
						 $divider = ($i == 2) ? 10 : 100;
						 $number = floor($no % $divider);
						 $no = floor($no / $divider);
						 $i += ($divider == 10) ? 1 : 2;
						 if ($number) {
							$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
							$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
							$str [] = ($number < 21) ? $words[$number] .
								" " . $digits[$counter] . $plural . " " . $hundred
								:
								$words[floor($number / 10) * 10]
								. " " . $words[$number % 10] . " "
								. $digits[$counter] . $plural . " " . $hundred;
						 } else $str[] = null;
					  }
					  $str = array_reverse($str);
					  $result = implode('', $str);
					  $points = ($point) ?
						"." . $words[$point / 10] . " " . 
							  $words[$point = $point % 10] : '';
					///  echo $result . "Rupees  " . $points . " Paise";
					 $PayMode=""; $k='1'; $SettledCompany=''; $NETAMOUNT=0; $Roundoff=0;
					 $sql2="select * from Trans_Checkout_mas ch
						left outer join Trans_pay_det det on det.grpcheckoutbillid=ch.grpcheckoutbillid
						left outer join mas_paymode py on py.PayMode_Id=det.Paymodeid
						left outer join Mas_company com on com.Company_Id=det.Bankid
						left outer join Mas_Bank bk on bk.Bankid=det.bankid
						left outer join mas_room mr on mr.Room_id = det.Bankid
						left outer join mas_roomtype mrt on mr.roomtype_id = mrt.roomtype_id
						where ch.grpcheckoutbillid=".$_REQUEST['Checkoutid'];

					
					$res2=$this->db->query($sql2); 

					$totalamt = 0;
					$payModes = [];
$settledCompanies = [];
$totalamt = 0;

foreach($res2->result_array() as $row2){

    $payModes[] = trim($row2['PayMode']);

    if ($row2['PayMode'] == 'COMPANY' || $row2['PayMode'] == 'COMPANY ') {
        $settledCompanies[] = $row2['Company'];
    } 
    else if ($row2['PayMode'] == 'TO ROOM') {
        $settledCompanies[] = $row2['RoomNo'].'/'.$row2['RoomType'];
    }
    else {
        $settledCompanies[] = $row2['bank'];
    }

    $NETAMOUNT = $row2['totalamount'];
    $Roundoff  = $row2['roundoff'];
    $totalamt += $row2['totalamount'];
}


$PayMode =  implode(' / ', array_unique($payModes));
$SettledCompany = implode(' / ', array_unique($settledCompanies));

					?>
					<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
    			    <tfoot>
					    <tr>
						  <td style="width:50%"><b>Rupees :</b>  <?php echo $result  ?>Only</td>
						  <td style="width:20%;text-align:right;"><b>Sub Total</b></td>
						  <td style="width:10%;text-align:right;"><b><?php echo number_format($TotalCredit,2); ?></b></td>
						  <td style="width:10%;text-align:right;"><b><?php echo number_format($Totaldebit,2); ?></b></td>
						  <td style="width:10%;text-align:right;"></td>						  
						</tr>
						<tr>
						  <td style="width:50%"><b>Billing Instructions</b></td>
						  <td style="width:20%;text-align:right;">Round Off</td>
						  <td style="width:10%;text-align:right;"><?php echo $Roundoff; ?></td>
						  <td style="width:10%;text-align:right;"></td>
						  <td style="width:10%;text-align:right;"></td>						  
						</tr>
						<tr>
						  <td style="width:50%"><b>Prepared By - </b><?php echo $UserName; ?></td>
						  <td style="width:20%;text-align:right;"><b></b></td>
						  <td style="width:10%;text-align:right;"><b></b></td>						 
						  <td colspan="2" style="width:20%;text-align:right;"><b>By <?php echo $PayMode; ?></b></td>						  
						</tr>
						<tr>
							<?php $tot = ($TotalCredit)-($Totaldebit) ?>
						  <td style="width:50%">Thank You !!! Safe Journey ... Kindly Visit Again .</td>
							  <td style="width:20%;text-align:right;"><b>NET AMOUNT</b></td>
						  <td style="width:10%;text-align:right;"><b><?php echo number_format($tot,2); ?></b></td>					
						  <td colspan="2" style="width:10%;text-align:right;"><?php echo $SettledCompany; ?></td>						  
						</tr>
					</tfoot>						
					</table>
					<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
    			    <tfoot>
					 <tr>
					    <td colspan="4">I Agree that i am responsible for the full payment of this bill in the event it is not paid by the company , organisation of person</td>
					 </tr>
					 <tr>
					    <td style="width:50%;"><b>PLEASE DEPOSIT YOUR KEY ON DEPARTURE</b></td>
						<td colspan="3" style="width:50%;">All Disputes will be settled at <?php echo $City; ?> Jurisdiction Only</td>
					 </tr>
					 <tr>
					    <td style="width:40%;border-top:1px solid #000;"></td>
						<td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;text-align:center;text-color:green ;"><b>Cashier's Signature</b></td>
						<td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;text-align:center;"><b>Manager's Signature</b></td>
						<td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;text-align:center;"><b>Guest's Signature</b></td>
						<td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;text-align:center;"></td>
						<td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;text-align:center;"></td>
					 </tr>
					</tfoot>						
					</table>
		 	<?php     
				   ?>		
		</div>     
    </fieldset>
	

  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
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