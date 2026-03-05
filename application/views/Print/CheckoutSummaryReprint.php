<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Print','Checkout Summary Reprint');
$this->pfrm->FrmHead4('Print / Checkout Summary Reprint','CheckoutBill',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");


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
		$logo=$row['logo'];
		if($row['Email']=='')
		{ $Email='';}
	    else { $Email='Email:'.$row['Email']; } 
	}


  $cityses = "select City from mas_city where Cityid = '".$City."'";
  $cityqry = $this->db->query($cityses)->row_array(); 

 
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
		where cmas.Checkoutid='".$_REQUEST['Checkoutid']."' and  isnull(cmas.cancelflag,0)<>1 ";
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
		$noofdayss=$row['noofdayss'];
		$Mobile=$row['Mobile'];
		$FoodPlan='';
		$Actrackrate=$row['Actrackrate'];
		$UserName=$row['EmailId'];
		 $GCompany=$row['Company'];
		$GGstno=$row['Gstno'];
		$yearprefix = $row['yearPrefix'];
	}	
	                
?>
<style>
#printing table tr td{
	/*padding:0px 10px 0px 10px;*/
	padding:10px 10px 0px 10px;
}

</style>


<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
     <div id="printing">
        <table style="border-right:1px solid #000;border-top:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;width:100%">
		<thead>
					<tr>
					<tr>
					 <th rowspan="5" style="width:20%;margin-left:20px;">
					 <img style="width:100%;margin-left:40px;" src="<?php echo scs_url . $logo; ?>" />

                  </th>
					 <th colspan="4" style="width:80%;margin-left:40px;" ><h2 style="margin-left:60px;"><?php echo $Company; ?></h2></th>									
					</tr>				
					<tr>
					<th colspan="4" style="width:80%;margin-left:40px;" ><p style="margin-left:60px;"><?php echo $Address." ".$Address1; ?></p></th>
					</tr> 					
					<tr>
                        
					 <th colspan="4" style="width:80%;margin-left:40px;"><p style="margin-left:60px;"><?php echo $cityqry['City']."-".$Pin.". ".$State; ?></p></th>
					</tr>
					<tr>
					 <th colspan="4" style="width:80%;margin-left:40px;"> <p style="margin-left:60px;"><?php echo $Phone." " .$Email; ?></p></th>
					</tr>
					<!-- <tr>
					 <th colspan="4" style="width:80%;margin-left:40px;"> <p style="margin-left:60px;"><?php echo "GSTNO - ".$Gstinn; ?></p></th>
					</tr> -->
					
				</thead>
		</table>
		<table style="border-right:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;width:100%">
    			<tbody>
					<tr>
				    <td style="border-bottom:1px solid #000;width:50%;text-align:center" colspan="3"><?php echo "<b>TAX INVOICE <b>" ?></td>
					</tr>
    			  <tr>
    				<td  style="width:40%"><b>Guest Details : </b></td>
    				<td  style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b> &nbsp; Bill No &nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;<?php echo $yearprefix.'/'.$Checkoutno;?></b></td>					
					<td style="border-bottom:1px solid #000;width:30%"><b>B.Date &nbsp;&nbsp;&nbsp;: </b><?php echo date('d-m-y', strtotime($Checkoutdate)); ?></td>

    			  </tr> 
				  <tr>
    				<td style="width:40%" ><?php echo  $Title.".".$gname; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%" ><b>&nbsp;Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b>&nbsp;<?php echo $RoomType; ?></td>
					<td style="border-bottom:1px solid #000;width:30%"> <b>&nbsp;Room &nbsp;&nbsp;&nbsp;: </b>&nbsp;<?php echo $RoomNo; ?></td>
    			  </tr> 
				  <tr>
    				<td style="width:40%" ><?php echo $GAddress1." , ".$GAddress2; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>&nbsp;Arr.Date &nbsp;&nbsp;:</b>&nbsp;<?php echo  date('d-m-Y', strtotime($checkindate))."-".substr($checkintime,10,6); ?></td>
					<td style="border-bottom:1px solid #000;width:30%"><b>&nbsp;Pax &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>&nbsp;<?php echo $Noofpersons; ?></td>
    			  </tr>
				  <tr>
    				<td style="width:40%"><?php echo $cityqry['City']; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>&nbsp;Dep.Date :</b>&nbsp;<?php echo date('d-m-Y',strtotime($Checkoutdate))."-".substr($Checkouttime,10,6); ?></td>
					<td style="border-bottom:1px solid #000;width:30%"><b>&nbsp;Days &nbsp;&nbsp;&nbsp;&nbsp; :</b>&nbsp;<?php echo number_format($noofdays); ?></td>
    			  </tr>
				  <tr>
    				<td style="width:40%"><b><?php echo "Mobile No : ".$Mobile; ?></b></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>&nbsp;Plan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>&nbsp;<?php echo $FoodPlan; ?></td>
					<td style="border-bottom:1px solid #000;width:30%"><b> Tariff&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b>&nbsp;<?php echo $Actrackrate; ?></td>
    			  </tr>
				    <tr>
						<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"></td>
					<td style="border-bottom:1px solid #000;width:30%"><b> GST NO &nbsp;&nbsp;&nbsp;&nbsp; : </b>&nbsp;&nbsp;<?php echo $Gstinn; ?></td>

    			  </tr>
				  <?php if(substr($Checkoutno,0,3) != 'WHK'){ ?>
					<?php if($GCompany || $GGstno) { ?>
				  <tr>  
				    <td style="width:50%"><?php echo $GCompany.' - '.$GGstno; ?></td>
					<!-- $Gstinn -->
				  </tr>
				  <?php } ?>
				  <?php } ?>
				</tbody>
		</table> 		
		<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:100%">
    <tbody>
        <tr>
		<!-- <td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%;text-align:center;"><b>Ref.NO</b></td> -->
            <td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%;text-align:center;"><b>Particulars</b></td>
            <td style="background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;text-align:center;"><b>Amount</b></td>
        </tr>
        <?php 
	
        $begin = new DateTime($checkindate);
        $end = new DateTime($Checkoutdate);
		 $interval = $begin->diff($end);
		 $dayCount = $interval->days + 1 . " Days";
		if ($begin == $end) {
			$dayCount = "1 Day";
		} 

        $RoomRentCumulative = 0;
        $CGSTCumulative = 0;
		$laundaryCumulative = 0;
        $SGSTCumulative = 0;
		$FoodCumulative = 0;
		$roomallowamount = 0;
		$NextPage=0;
		$advanceamount=0;
		$Discountamt=0;
		$creditno='';
		$rowcount=1; $TotalCredit=0; $Totaldebit=0; $NextPageHeader=0;

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            $loopdate = $i->format("Y-m-d");

             $sql1 = "SELECT mr.RevenueHead, ce.Amount,ce.creditno
                     FROM Trans_Credit_Entry ce
                     INNER JOIN Mas_Revenue mr ON mr.Revenue_Id = ce.Creditheadid
                     WHERE Roomgrcid = '".$Roomgrcid."' AND CreditDate = '".$loopdate."'
                     UNION 
                     SELECT 'Advance' AS RevenueHead, Amount ,receiptno
                     FROM Trans_Receipt_mas 
                     WHERE roomgrcid = '".$Roomgrcid."' AND cancel = 0 AND ISNULL(ReceiptType, '') = 'C'
					--  AND rptdate = '".$loopdate."'
					  ";

            $res1 = $this->db->query($sql1);

            foreach ($res1->result_array() as $row1) {

				// print_r($row1);

		
			
				$Totaldebit=$Totaldebit+$row1['Amount'];
                if ($row1['RevenueHead'] == 'ROOM RENT') {
                    $RoomRentCumulative += $row1['Amount'];
                } elseif ($row1['RevenueHead'] == 'CGST') {
                     $CGSTCumulative += $row1['Amount'];
                } elseif ($row1['RevenueHead'] == 'SGST') {
                    $SGSTCumulative += $row1['Amount'];
                }
				elseif ($row1['RevenueHead'] == 'FOOD') {
				    $FoodCumulative += $row1['Amount'];
                
                }
				elseif ($row1['RevenueHead'] == 'Laundary') {
				    $laundaryCumulative += $row1['Amount'];
                
                }
				// elseif ($row1['RevenueHead'] == 'Advance') {
			
                //   $advanceamount += $row1['Amount']; 
				 
				// 	 $creditno = $row1['creditno'];
                // }
					elseif ($row1['RevenueHead'] == 'Discount') {
			
                  $Discountamt  += $row1['Amount']; 
				 
				
                }

				elseif ($row1['RevenueHead'] == 'ROOM RENT Allowance') {
                    $roomallowamount += $row1['Amount'];
					//  $creditno = $row1['creditno'];
                }


			
				
            }
        }

		$advanceAmounts = [];
foreach ($res1->result_array() as $row1) {
    if ($row1['RevenueHead'] == 'Advance') {
        $advanceAmounts[$row1['creditno']] = $row1['Amount'];
    }
}


$advanceamount += array_sum($advanceAmounts);

		$TotalAmount = $RoomRentCumulative + $CGSTCumulative +  $SGSTCumulative + $FoodCumulative -$advanceamount - $Discountamt ;
        ?>
		
    	<tr> 
			<!-- <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;"></td> -->
            <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;"> Room Rent - <?php echo $dayCount;?></td>
            <td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;"><?php echo number_format($RoomRentCumulative, 2); ?></td>
        </tr>
        <tr>
			<!-- <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;"></td> -->
            <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;">CGST  - <?php echo $dayCount;?> </td>
            <td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;"><?php echo number_format($CGSTCumulative, 2); ?></td>
        </tr>
        <tr>
		<!-- <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;"></td> -->
            <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;"> SGST  - <?php echo $dayCount;?></td>
            <td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;"><?php echo number_format($SGSTCumulative, 2); ?></td>
        </tr>

		<?php if($FoodCumulative !=0) { ?>
		<tr>

            <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;">FOOD </td>
            <td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;"><?php echo number_format($FoodCumulative, 2); ?></td>
        </tr>
	<?php } ?>

	<?php if($roomallowamount !=0) { ?>
		<tr>

            <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;">ROOM RENT Allowance </td>
            <td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;"><?php echo number_format($roomallowamount, 2); ?></td>
        </tr>
	<?php } ?>

	<?php if($laundaryCumulative !=0) { ?>
		<tr>

            <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;">Laundary </td>
            <td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;"><?php echo number_format($laundaryCumulative, 2); ?></td>
        </tr>
	<?php } ?>
	<?php if($advanceamount !=0) { ?>
		<tr>
		<!-- <td style="text-align:center;padding-left:10px;border-right:1px solid #000;width:50%;"><?php echo $creditno; ?></td> -->
            <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;">Advance </td>
            <td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;"><?php echo number_format($advanceamount, 2); ?></td>
        </tr>
	<?php } ?>

	

	<?php if($Discountamt !=0) { ?>
		<tr>
            <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;">Discount </td>
            <td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;"><?php echo number_format($Discountamt, 2); ?></td>
        </tr>
	<?php } ?>

        <!-- <tr> -->
		<!-- <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;"></td> -->
            <!-- <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;"><b>Total Tax Amount  - <?php echo $dayCount;?></b></td>
            <td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;"><b><?php echo number_format($CGSTCumulative + $SGSTCumulative, 2); ?></b></td>
        </tr> -->
        <tr>
		<!-- <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;"></td> -->
            <td style="text-align:left;padding-left:10px;border-right:1px solid #000;width:50%;padding-bottom: 290px;"><b>Grand Total  </b></td>
         
			<td style="text-align:right;padding-right:10px;border-right:1px solid #000;width:50%;padding-bottom: 290px;"><b><?php echo number_format($TotalAmount, 2); ?></b></td>
		
		</tr>
		

    </tbody>
</table>


				<?php 
				$sql="select Amount from Trans_Credit_Entry ce
					inner join Mas_Revenue mr on mr.Revenue_Id=ce.Creditheadid
					where Roomgrcid='".$Roomgrcid."' and mr.RevenueHead='ROOM RENT'
					Group by ce.Amount ";
					$res=$this->db->query($sql); 
					$taxsummary= $res->num_rows();
				if($taxsummary !=0)
				{
				?>
			
					<?php
					 foreach ($res->result_array() as $row)
					{
					?>
					
					<?php 
					}
					?>
					
					<?php
				}
					   $number = $TotalAmount;						 
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
						left outer join Trans_pay_det det on det.checkoutid=ch.checkoutid
						left outer join mas_paymode py on py.PayMode_Id=det.Paymodeid
						left outer join Mas_company com on com.Company_Id=det.Bankid
						left outer join Mas_Bank bk on bk.Bankid=det.bankid
						left outer join mas_room mr on mr.Room_id = det.Bankid
						left outer join mas_roomtype mrt on mr.roomtype_id = mrt.roomtype_id
						where ch.Checkoutid=".$_REQUEST['Checkoutid'];
					$res2=$this->db->query($sql2); 
					foreach($res2 -> result_array() as $row2){	
						if($k !='1')
						{
							$PayMode=$PayMode.'/ ';
							$SettledCompany=$SettledCompany.'/ ';
						}					
						$PayMode=$PayMode.$row2['PayMode'];		
						$k++;
						if($row2['PayMode']=='COMPANY ' || $row2['PayMode']=='COMPANY')
						{					
							$SettledCompany=$SettledCompany.$row2['Company'];
						}
						else if($row2['PayMode'] == "TO ROOM"){
							$SettledCompany=$SettledCompany.$row2['RoomNo'].'/'.$row2['RoomType'];
						}
						else
						{
							$SettledCompany=$SettledCompany.$row2['bank'];
						}
						$NETAMOUNT=$row2['totalamount'];
						$Roundoff=$row2['roundoff'];
					}
					?>
					<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
    			    <tfoot>
					    <tr>
						  <td style="width:50%">Rupees  <?php echo $result  ?>Only</td>
						  <td style="width:20%;text-align:right;"><b>Sub Total</b></td>
						  <td style="width:30%;text-align:right;"></td>
						  <!-- <td style="width:10%;text-align:right;"><b><?php echo number_format($TotalCredit,2); ?></b></td> -->
						  <td style="width:10%;text-align:right;"><b></b></td> 
						  <td style="width:10%;text-align:right;"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($TotalAmount,2); ?></b></td>
						  						  
						</tr>
						<tr>
						  <td style="width:50%"><b>Billing Instructions</b></td>
						  <td style="width:20%;text-align:right;">Round Off</td>
						  <td style="width:10%;text-align:right;"></td>
						  <td style="width:10%;text-align:right;"></td>
						  <td style="width:10%;text-align:right;padding-right: -5px;">
							<?php echo str_pad($Roundoff, 10, " ", STR_PAD_LEFT); ?>
						</td>

						  <!-- <td style="width:10%;text-align:right;"></td>
						  <td style="width:10%;text-align:right;"></td>						   -->
						</tr>
						<tr>
						  <td style="width:50%"><b>Prepared By - </b><?php echo $UserName; ?></td>
						  <td style="width:20%;text-align:right;"><b>NET AMOUNT</b></td>
						  <td style="width:10%;text-align:right;"></td>
						  <td style="width:10%;text-align:right;"></td>
						  <td style="width:10%;text-align:right;"><b><?php echo number_format($TotalAmount + $Roundoff,2); ?></b></td>						 
						  <!-- <td colspan="2" style="width:20%;text-align:right;"><b>By <?php echo $PayMode; ?></b></td>						   -->
						</tr>
						<tr>
						  <td style="width:72%">Thank You !!! Safe Journey ... Kindly Visit Again .</td>
						 <td colspan="4" style="width:20%;text-align:right;"><b>By <?php echo $PayMode; ?></b>&nbsp;<?php echo $SettledCompany; ?></td>
						  <td style="width:10%;text-align:right;"></td>						
						 						
						</tr>
						<tr>
							  <!-- <td colspan="5" style="width:20%;text-align:right;"><?php echo $SettledCompany; ?></td> -->
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
        <td style="width:33.33%; border-top:1px solid #000; border-left:1px solid #000; text-align:center; color:black; padding-top:50px;">
            <b>Cashier's Signature</b>
        </td>
        <td style="width:33.33%; border-top:1px solid #000; border-left:1px solid #000; text-align:center; padding-top:50px;">
            <b>Manager's Signature</b>
        </td>
        <td style="width:33.33%; border-top:1px solid #000; border-left:1px solid #000; text-align:center; padding-top:50px;">
            <b>Guest's Signature</b>
        </td>
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