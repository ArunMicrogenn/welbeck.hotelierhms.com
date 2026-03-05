<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session); 
$this->pweb->Cheader('Print','Checkout Receipt');
$this->pfrm->FrmHead4('Print / Checkout Receipt','Transaction/RoomStatusOnline',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");




 $sql_chkid = "SELECT Checkoutid, checkoutno, Splitbillno 
              FROM trans_checkout_mas 
              WHERE grcid = $checkoutId
              AND checkoutno LIKE '%CHK%' 
              AND ISNULL(SETTLE, 0) <> 1 
              AND ISNULL(cancelflag, 0) <> 1";

$res = $this->db->query($sql_chkid);


if ($res) {
    $arr_chkid = $res->result_array();
    $row = $res->row_array();
    if ($row && empty($checkoutId)) {
        $checkoutId = $row['Checkoutid'];
    }

    $sql2 = "SELECT det.roomgrcid
             FROM Trans_Checkout_mas mas
             INNER JOIN Trans_Roomdet_det det ON det.Grcid = mas.Grcid
             WHERE mas.grcid = $checkoutId AND ISNULL(det.isrentpartialpost, 0) = 0";

    $query2 = $this->db->query($sql2);

    if ($query2) {
        $data = $query2->result_array();
    }
} else {
    echo "SQL Error: " . $this->db->last_query();
    return;
}

$noofbills = count($data);
if($noofbills >= 1)
{
	$Res=$this->Myclass->Hotel_Details();


	foreach($Res as $row) 
	{

		
		$Company=$row['Company'];
		$Address=$row['Address'];
		$Address1=$row['Address1'];
		$City=$row['City'];
		$Pin=$row['PinCode'];
		$State=$row['State'];
		$Gstinn=$row['Gstinn'];
		$Phone=$row['Phone'];
		if($row['Email']=='')
		{ $Email='';}
	    else { $Email='Email:'.$row['Email']; } 
	}
	$NetAmount='0'; 
	$Roundoff='0';
   $sql="select ci.city ,* from Trans_checkout_mas  cmas
		inner join Mas_Customer cus on cmas.Customerid=cus.Customer_Id
		inner join Mas_Title ti on ti.Titleid=cus.Titelid
		inner join Trans_Roomdet_det rdet on rdet.roomgrcid=cmas.Roomgrcid
		inner join Mas_RoomType rtype on rtype.RoomType_Id=rdet.typeid
		inner join Mas_Room rm on rm.Room_Id=rdet.Roomid
		inner join Trans_Checkin_mas ckmas on ckmas.Grcid=rdet.grcid
		inner join Mas_City ci on ci.Cityid=cus.Cityid
		left outer join Mas_Company com on com.Company_Id=cmas.companyid
		left outer join UserTable us on us.User_id=cmas.userid
		where cmas.grcid='".$checkoutId."' and isnull(cmas.cancelflag,0)<>1 ";
		// and isnull(cmas.settle,0)<>1
	$res=$this->db->query($sql); 



	
	foreach ($res->result_array() as $row)
	{   

		
	
		$Grcid=$row['Grcid'];
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
		$Mobile=$row['Mobile'];
		$FoodPlan='';
		$Actrackrate=$row['Actrackrate'];
		$UserName=$row['EmailId'];
		$GCompany=$row['Company'];
		$GGstno=$row['Gstno'];
		$NetAmount =$row['totalamount'];
		$Roundoff =$row['roundoff'];
		$yearprefix = $row['yearPrefix'];
		
	}	

$adv = "
    SELECT SUM(tam.Amount) AS Amount 
    FROM Trans_advancereceipt_mas tam
    INNER JOIN trans_receipt_mas trm ON trm.roomgrcid = tam.roomgrcid 
    WHERE tam.roomgrcid = '".$Roomgrcid."' AND ISNULL(tam.type, '') = 'RMS'
";

$advres = $this->db->query($adv);
$advance = $advres->row_array(); 

$tadv = isset($advance['Amount']) ? $advance['Amount'] : 0; 


	                 
?>


<div style="display: flex; align-items: center; gap: 10px;" class="col-6 col-sm-6 margin">
    <label for="checkout_id" style="margin-bottom: 0;">Bill Number</label>
    <select name="checkout_id" id="checkout_id" onchange="redirectWithCheckoutId(this)" class="scs-ctrl" style="flex: 1; padding: 5px;">
        <?php
        $defaultSet = false;
        foreach ($arr_chkid as $index => $row):
            $selected = '';
            if ($checkoutId != "" && $checkoutId == $row['Checkoutid']) {
                $selected = 'selected';
                $defaultSet = true;
            } elseif ($checkoutId == "" && $index == 0) {
                $selected = 'selected';
                $defaultSet = true;
            }
        ?>
            <option value="<?= htmlspecialchars($row['Checkoutid']) ?>" <?= $selected ?>>
                <?= htmlspecialchars($row['checkoutno']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
     <div id="printing">
<table style="width:100%; border:1px solid #000; border-collapse:collapse;">
    <tr>
	<th rowspan="5" style="">
    <img style="width:100%;margin-left:40px;" src="<?php echo scs_url . $logo; ?>" />
                  </th>
			
        <td colspan="2" style="text-align:center; ">
            <h2><?php echo $Company; ?></h2>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center; ">
            <?php echo $Address . " " . $Address1; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center; ">
            <?php echo $City . "-" . $Pin . ". " . $State; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center; ">
            <?php echo "PHONE : " . $Phone; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center; margin-bottom:10px">
            <?php echo $Email; ?>
        </td>
    </tr>
</table>

		<table style="border-right:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;width:100%">
    			<tbody>
					<tr>
				    <td style="border-bottom:1px solid #000;width:100%;text-align:center" colspan="3"><?php echo "<b>TAX INVOICE<b>" ?></td>

					</tr>
    			  <tr>
    				<td  style="width:40%"><b>Guest Details : </b></td>
    				<td  style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>Invoice No :</b><?php echo $Checkoutno; ?></td>
					<td  style="border-bottom:1px solid #000;width:30%"> <b>Date :</b> <?php echo date('d-m-Y', strtotime($Checkoutdate)); ?></td>
    			  </tr> 
				  <tr>
    				<td style="width:40%" ><?php echo  $Title.".".$gname; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>Plan :</b><?php echo $FoodPlan; ?></td>
    				<!-- <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%" >Type :<?php echo $RoomType; ?></td> -->
					<td style="border-bottom:1px solid #000;width:30%"> <b>Room :</b><?php echo $RoomNo; ?></td>
    			  </tr> 
				  <tr>
    				<td style="width:40%" ><?php echo $GAddress1." , ".$GAddress2; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>Arr.Date :</b><?php echo  date('d-m-Y', strtotime($checkindate))."-".substr($checkintime,10,6); ?></td>
					<td style="border-bottom:1px solid #000;width:30%"> <b>Pax  :  </b><?php echo $Noofpersons; ?></td>
    			  </tr>
				  <tr>
    				<td style="width:40%"><?php echo $city; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>Dep.Date :</b><?php echo date('d-m-Y',strtotime($Checkoutdate))."-".substr($Checkouttime,10,6); ?></td>
					<td style="border-bottom:1px solid #000;width:30%"> <b>Days  :  </b><?php echo number_format($noofdays); ?></td>
    			  </tr>
				  <tr>
    				<td style="width:40%"><?php echo "Mobile No:".$Mobile; ?></td>
    				<!-- <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%">Plan :<?php echo $FoodPlan; ?></td> -->
					<td style="border:1px solid #000;" colspan="2"> <b>Rack Tariff  : </b><?php echo $Actrackrate; ?></td>
    			  </tr>
				    <tr>
    				<td style="width:40%"></td>
    				<!-- <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%">Plan :<?php echo $FoodPlan; ?></td> -->
					<td style="border:1px solid #000;" colspan="2"> <b>PAN NO  : </b><?php echo $Actrackrate; ?></td>
    			  </tr>
				  	 <tr>
    				<td style="width:40%"></td>
    				<!-- <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%">Plan :<?php echo $FoodPlan; ?></td> -->
					<td style="border:1px solid #000;" colspan="3"> <b>GST NO  : </b><?php echo $Gstinn; ?></td>
    			  </tr>
				  
				  <?php if(substr($Checkoutno,0,3) != 'WHK'){ ?>
					<?php if($GCompany) { ?>
				  <tr>  
				    <td style="width:50%"><?php echo $GCompany.' - '.$GGstno; ?></td>
				</tr>
				<?php } ?>
				<?php } ?>
				</tbody>
		</table> 		
		<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:100%">								
    			   <tbody>
					<tr>
    					<td style="background:#05C3DD;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%">Date</td>
    					<td style="background:#05C3DD;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%">Ref.No</td>
						<td style="background:#05C3DD;border-bottom:1px solid #000;border-right:1px solid #000;width:40%">Particulars</td>
						<td style="background:#05C3DD;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Charges</td>
						<td style="background:#05C3DD;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Credit</td>
						<td style="background:#05C3DD;text-align:right;border-bottom:1px solid #000;width:10%">Total</td>
    				</tr>
			<?php 
			    $begin = new DateTime($checkindate);
				$end = new DateTime($Checkoutdate);  $NextPage=0;
				 $rowcount=1; $TotalCredit=0; $Totaldebit=0; $NextPageHeader=0;
				for($i = $begin; $i <= $end; $i->modify('+1 day'))
				{   $Daytotal=0;
					$loopdate= $i->format("Y-m-d");
				
				 	$sql1="select mr.ord,mr.creditordebit,ce.CreditDate,ce.CreditNo,mr.RevenueHead,
					ce.Amount, chNo from Trans_Credit_Entry ce
					inner join Mas_Revenue mr on mr.Revenue_Id=ce.Creditheadid
					 where Roomgrcid='".$Roomgrcid."' and CreditDate='".$loopdate."'
					 union 
					 select 5 ord,'D' as creditordebit,rptdate as CreditDate,Receiptno as CreditNo,
					 'Advance' as RevenueHead,Amount,'' as chNo  from Trans_Receipt_mas 
					 where roomgrcid='".$Roomgrcid."' and cancel=0 and isnull(ReceiptType,'')='C'  and rptdate='".$loopdate."' order by ord";
					$res1=$this->db->query($sql1); 							
					foreach ($res1->result_array() as $row1)
					{ 			  
					$Creditordebit=$row1['creditordebit'];
			        if($Creditordebit=='C')
					{		?>
					<tr>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"><?php echo  date('d-m-Y', strtotime($row1['CreditDate'])); ?></td>
    					<td style="text-align:center;border-right:1px solid #000;width:15%"><?php echo $row1['CreditNo']; ?></td>
						<td style="border-right:1px solid #000;width:40%"><?php if($row1['RevenueHead'] == 'Transfer CR'){ echo $row1['RevenueHead'].' ('. $row1['chNo'].')'; } else {echo $row1['RevenueHead']; } ?></td>
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
					where Roomgrcid='".$Roomgrcid."' and mr.RevenueHead in ('ROOM RENT','Extra Bed') 
					/*Group by ce.Amount*/ ";
					$res=$this->db->query($sql); 
					$taxsummary= $res->num_rows();
				if($taxsummary !=0)
				{
				?>
				<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
    			   <tbody>
				   <tr>
    				<td colspan="7" style="text-align:center;border-bottom:1px solid #000;"> TAX SUMMARY</td>									
	    			</tr>
					<tr>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%">Description</td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">HSN Code</td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%">Tax Amt</td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">CGST%</td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%">CGST</td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">SGST%</td>
						<td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;width:15%">SGST</td>
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
					   $number = $Daytotal;						 
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
					 
					?>

					<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
    			    <tfoot>
					    <tr>
						  <td style="width:50%">Rupees : <?php echo $result ?>Only</td>
						  <td style="width:20%;text-align:right;">Total</td>
						  <td style="width:10%;text-align:right;"><?php echo number_format($TotalCredit,2); ?></td>
						  <td style="width:10%;text-align:right;"><?php echo number_format($Totaldebit,2); ?></td>
						  <td style="width:10%;text-align:right;"> </td>						  
						</tr>
						<tr>
						  <td style="width:50%">Billing Instructions</td>
						  <td style="width:20%;text-align:right;">Round Off</td>
						  <td style="width:10%;text-align:right;"><?php echo $Roundoff; ?></td>
						  <td style="width:10%;text-align:right;"></td>
						  <td style="width:10%;text-align:right;"></td>						  
						</tr>
						<tr>
						  <td style="width:50%">Prepared By - <?php echo $UserName; ?></td>
						  <td style="width:20%;text-align:right;">Advance</td>
					
						  <td style="width:10%;text-align:right;"><?php echo $tadv ?></td>
					
						  <td style="width:10%;text-align:right;"></td>
						  <td style="width:10%;text-align:right;">By</td>						  
						</tr>
						<tr>
						  <td style="width:50%">Thank You !!! Safe Journey ... Kindly Visit Again .</td>
							  <td style="width:20%;text-align:right;">NET AMOUNT</td>
						  <td style="width:10%;text-align:right;"><?php echo number_format($NetAmount,2); ?></td>
						  <td style="width:10%;text-align:right;"></td>
						  <td style="width:10%;text-align:right;"></td>						  
						</tr>
					</tfoot>						
					</table>
					<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
    			    <tfoot>
					 <tr>
					    <td colspan="4">I Agree that i am responsible for the full payment of this bill in the event it is not paid by the company , organisation of person</td>
					 </tr>
					 <tr>
					    <td style="width:50%;">PLEASE DEPOSIT YOUR KEY ON DEPARTURE</td>
						<td colspan="3" style="width:50%;">All Disputes will be settled at Coimbatore Jurisdiction Only</td>
					 </tr>
					 <tr>
					    <td style="width:40%;border-top:1px solid #000;"></td>
						<td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;">Cashieris Signature</td>
						<td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;">Manager's Signature</td>
						<td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;">Guest's Signature</td>
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
}

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

		$(document).ready(function() {
			var selectedCheckoutId = "<?= $checkoutId ?>";

			if (selectedCheckoutId !== "") {
				$('#checkout_id').val(selectedCheckoutId);
			} else {
				$('#checkout_id option:first').prop('selected', true);
			}
			
		});

		function redirectWithCheckoutId(selectElement) {
			const checkoutId = selectElement.value;
			const url = new URL(window.location.href);
			url.searchParams.set('checkoutid', checkoutId);
			window.location.href = url.toString();  
		}

	</SCRIPT>