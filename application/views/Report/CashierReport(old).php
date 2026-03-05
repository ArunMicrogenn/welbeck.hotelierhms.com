<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Cashier Report');
$this->pfrm->FrmHead6('Report / Cashier Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 
 <?php
 $openingBal = 0;
  $sql = "exec DayOpeningCash '".date('Y-m-d', strtotime('-1Day'))."'" ;
  $res = $this->db->query($sql);
  foreach($res-> result_array() as $row){
	$openingBal= $row['clbal'];
  }
 
 ?>

 <style>
	/* *{
		font-size:12px;
	} */
 </style>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="date" value="<?php if(@$_POST['frmdate']){echo $_POST['frmdate']; }else { echo date('Y-m-d'); } ?>" id="frmdate" name="frmdate" max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl " />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="date" value="<?php if(@$_POST['todate']){echo $_POST['todate']; }else { echo date('Y-m-d'); } ?>" id="todate" name="todate" max="<?php echo date('Y-m-d'); ?>"   class="scs-ctrl " />
            <div class="Type" ></div></td>        
		   <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
        </tr>
      	</table>
	</form>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div id="printing"  class="col-sm-12"  style="overflow-x: auto; max-height: 500px;">
		<?php

		if(@$_POST['submit'])
		{
		  ?>		
        <table class="table table-bordered table-hover table-responsive">    
		<div>
				<h3 class="text-center">Cashier Report  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?><h3>
				<!-- <h5>Opening : <?php echo $openingBal;?></h5> -->
		    </div>     
		   <tbody>
		    <?php 
			 $i=1;
			 $norow=0; $CASH=0; $CARD=0; $NEFT=0; $ROOM=0; $REFUND=0; $upi = 0; $company = 0;$collection= 0;
			 $creditTotal = 0;
             $debitTotal = 0;
             $creditAmount = 0;
             $debitAmount = 0;$REFUNDCHK = 0;

			 $qry="select * from trans_receipt_mas recmas 
			 inner join mas_Room rmas on rmas.Room_id=recmas.roomid 
			 inner join trans_checkin_mas tcm on tcm.Grcid = recmas.grcid 
			 inner join Mas_Customer cs on cs.Customer_Id = recmas.customerid 
			 Left outer join Mas_Title ti on ti.Titleid=cs.Titelid
			 inner join mas_paymode pm on pm.PayMode_Id = recmas.paymodeid
			 left outer join Mas_RoomType mst on mst.RoomType_Id = rmas.RoomType_Id
			  inner join trans_roomdet_det trd on trd.grcid=tcm.grcid
			 inner join UserTable ut on ut.User_id=recmas.userid
			 where isnull(ReceiptType,'') ='O' 
			 and isnull(cancel,0)<>1  and recmas.rptdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and '".date('Y-m-d',strtotime($_POST['todate']))."' ";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="14" class="w-100 text-bold" style="text-align: center;background-color:#c9c6c6;">Advance Collection</td>';			
				echo '</tr>';

				echo '<tr  style="background-color:#c9c6c6">';		 
				echo '<td  style="text-align: center;">L.No</td>';
				echo '<td  style="text-align: center;text-wrap:nowrap">Receipt.No</td>';
				echo '<td style="text-align: center;">Room.No</td>';
					echo '<td style="text-align: center;">Guest Name</td>';		
				echo '<td style="text-align: center;">Chk.Dt</td>';
				echo '<td style="text-align: center;">Chk.Time</td>';
		
			
				echo '<td style="text-align: center;">Pax</td>';
				echo '<td style="text-align: center;">Extra Bed</td>';
				echo '<td style="text-align: center;">Credit</td>';		
				echo '<td style="text-align: center;">Debit</td>';		
				echo '<td style="text-align: center;">Mode</td>';
				echo '<td style="text-align: center;">User</td>';
				echo '<td style="text-align: center;">Curr.Tarrif</td>';
				echo '<td style="text-align: center;">Remarks</td>';
				echo '</tr>';			
			  }		
			  $totaltarrif = 0;	 
			  $adv_total_credit  =  0;
			  $adv_total_debit  =  0;
			  foreach ($exec->result_array() as $rows)
			  {


				$currtarrif = $rows['roomrent'];
				$totaltarrif = $totaltarrif + $currtarrif;

				// print_r($rows);
                $credit_debit = $currtarrif + $rows['Extrabedamount'];
				//  $Amt + $rows3['Extrabedamount'] + $food['food'] - ($allowance['allowance'] +  $rows3['Discount'] + $rows3['Advance']); 
                  $adv_debit = 0;
                  $adv_credit = 0;
				if($credit_debit < 0){
                      $adv_debit = $credit_debit;
				} else{
					$adv_credit = $credit_debit;
				}


				
				$adv_t_debit =  $adv_debit ;
				$adv_total_debit = $adv_total_debit + $adv_t_debit;

				$adv_t_credit =  $adv_credit ;
				$adv_total_credit = $adv_total_credit + $adv_t_credit;

				if($rows['PayMode']=='CASH')
				{ $CASH=$CASH+$rows['Amount']; }
				else if($rows['PayMode']=='CREDIT CARD')
				{ $CARD=$CARD + $rows['Amount']; }
				else if($rows['PayMode']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows['Amount']; }
				else if($rows['PayMode']=='TO ROOM')
				{ $ROOM=$ROOM+$rows['Amount'];}
				else if($rows['PayMode']== 'UPI'){
					$upi = $upi +$rows['Amount'];
				}
				echo '<tr  >';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows['yearprefix'].'/'.$rows['Receiptno'].'</td>';
				echo '<td style="text-align: center;">'.$rows['RoomNo'].'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].'</td>';	
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['rptdate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows['rpttime'],11,5).'</td>';
			
										
				echo '<td style="text-align: center;">'.$rows['Noadults'].'</td>';
				echo '<td style="text-align: center;">'.$rows['Extrabedamount'].'</td>';
				echo '<td style="text-align: right;">'.	$adv_credit.'</td>';				
				echo '<td style="text-align: right;">'.	$adv_debit.'</td>';				
				echo '<td style="text-align: left;">'.$rows['PayMode'].'</td>';
				echo '<td style="text-align: left;">'.$rows['EmailId'].'</td>';
				echo '<td style="text-align: center;">'.$rows['roomrent'].'</td>';
				echo '<td style="text-align: center;">'.$rows['billremark'].'</td>';
				echo '</tr>';
				$totalAdvance=$totalAdvance+$rows['Amount'];
			  }
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="7" class="text-bold" style="text-align: center;">Total Advance Collection</td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: right;">'.number_format($adv_total_credit,2).'</td>';
				echo '<td style="text-align: center;">'.number_format($adv_total_debit,2).'</td>';								
				echo '<td style="text-align: center;"></td>';								
				echo '<td style="text-align: center;"></td>';								
									
				echo '<td style="text-align: center;">'.number_format($totaltarrif).'</td>';								
				echo '</tr>';		
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';			
			  }

			  	echo '<tr>';
				echo '<td colspan="14" class="w-100 text-bold" style="text-align: center;background-color:#c9c6c6;">Further Advance Collection</td>';			
				echo '</tr>';

				echo '<tr  style="background-color:#c9c6c6">';		 
				echo '<td  style="text-align: center;">L.No</td>';
				echo '<td  style="text-align: center;text-wrap:nowrap">Receipt.No</td>';
				echo '<td style="text-align: center;">Room.No</td>';
					echo '<td style="text-align: center;">Guest Name</td>';		
				echo '<td style="text-align: center;">Adv Ent.Dt</td>';
				echo '<td style="text-align: center;">Adv Ent.Tm</td>';
				echo '<td style="text-align: center;">Pax</td>';
				echo '<td style="text-align: center;">Extra Bed</td>';
				echo '<td style="text-align: center;">Credit</td>';		
				echo '<td style="text-align: center;">Debit</td>';		
				echo '<td style="text-align: center;">Mode</td>';
				echo '<td style="text-align: center;">User</td>';
				echo '<td style="text-align: center;">Remarks</td>';
				echo '</tr>';

						 $fur_qry="select * from trans_receipt_mas recmas 
			 inner join mas_Room rmas on rmas.Room_id=recmas.roomid 
			 inner join trans_checkin_mas tcm on tcm.Grcid = recmas.grcid 
			 inner join Mas_Customer cs on cs.Customer_Id = recmas.customerid 
			 Left outer join Mas_Title ti on ti.Titleid=cs.Titelid
			 inner join mas_paymode pm on pm.PayMode_Id = recmas.paymodeid
			 left outer join Mas_RoomType mst on mst.RoomType_Id = rmas.RoomType_Id
			  inner join trans_roomdet_det trd on trd.grcid=tcm.grcid
			 inner join UserTable ut on ut.User_id=recmas.userid
			 where isnull(ReceiptType,'') ='C' 
			 and isnull(cancel,0)<>1  and recmas.rptdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and '".date('Y-m-d',strtotime($_POST['todate']))."' ";
			 $fur_exec=$this->db->query($fur_qry); $totalAdvance=0;
			 $fur_advance= $fur_exec->num_rows();
					  foreach ($fur_exec->result_array() as $rows)
			  {

				$currtarrif = $rows['roomrent'];
				$totaltarrif = $totaltarrif + $currtarrif;

				if($rows['PayMode']=='CASH')
				{ $CASH=$CASH+$rows['Amount']; }
				else if($rows['PayMode']=='CREDIT CARD')
				{ $CARD=$CARD + $rows['Amount']; }	
				else if($rows['PayMode']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows['Amount']; }
				else if($rows['PayMode']=='TO ROOM')
				{ $ROOM=$ROOM+$rows['Amount'];}
				else if($rows['PayMode']== 'UPI'){
					$upi = $upi +$rows['Amount'];
				}
				echo '<tr  >';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows['yearprefix'].'/'.$rows['Receiptno'].'</td>';
				echo '<td style="text-align: center;">'.$rows['RoomNo'].'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].'</td>';	
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['rptdate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows['rpttime'],11,5).'</td>';
			
										
				echo '<td style="text-align: center;">'.$rows['Noadults'].'</td>';
				echo '<td style="text-align: center;">'.$rows['Extrabedamount'].'</td>';
				echo '<td style="text-align: right;"></td>';				
				echo '<td style="text-align: right;"></td>';				
				echo '<td style="text-align: left;">'.$rows['PayMode'].'</td>';
				echo '<td style="text-align: left;">'.$rows['EmailId'].'</td>';
				echo '<td style="text-align: center;">'.$rows['billremark'].'</td>';
				echo '</tr>';
				$totalAdvance=$totalAdvance+$rows['Amount'];
			  }

			  	  if($fur_advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="7" class="text-bold" style="text-align: center;">Total Advance Collection</td>';
				echo '<td style="text-align: right;">'.number_format($totalAdvance,2).'</td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: center;"></td>';								
				echo '<td style="text-align: center;"></td>';								
				echo '<td style="text-align: center;"></td>';							
										
				echo '<td style="text-align: center;">'.number_format($totaltarrif).'</td>';								
				echo '</tr>';		
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';			
			  }

			echo '<tr>';
				echo '<td colspan="7" class="text-bold" style="text-align: center;">Total </td>';
				echo '<td style="text-align: right;">'.number_format($totalAdvance,2).'</td>';
				echo '<td style="text-align: right;"></td>';
				echo '<td style="text-align: center;"></td>';								
				echo '<td style="text-align: center;"></td>';								
				echo '<td style="text-align: center;"></td>';								
									
				echo '<td style="text-align: center;"></td>';								
				echo '</tr>';		
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';			

			

			 $qry1="select * from trans_receipt_mas rmas
			  inner join trans_reserveadd_mas readd on readd.resaddid=rmas.Billid
			  inner join Mas_Customer cs on cs.Customer_Id = rmas.customerid
			  Left outer join Mas_Title ti on ti.Titleid=cs.Titelid
			  inner join mas_paymode pm on pm.PayMode_Id = rmas.paymodeid
			  inner join trans_reserve_mas remas on remas.Resid=readd.resid
			  inner join UserTable ut on ut.User_id=rmas.userid
			  where isnull(ReceiptType,'')='A'  and rptdate  between  '".date('Y-m-d',strtotime($_POST['frmdate']))."' and '".date('Y-m-d',strtotime($_POST['todate']))."' ";
			 $exec1=$this->db->query($qry1); $totalAdvance=0;
			 $resadvance= $exec1->num_rows(); $i=1;
			  if($resadvance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="10" class="text-bold" style="text-align: center;background-color:#c9c6c6;">Reservation Advance Collection</td>';			
				echo '</tr>';

				echo '<tr  style="background-color:#c9c6c6">';		 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt</td>';
				echo '<td style="text-align: center;">Res.date</td>';
				echo '<td style="text-align: center;">Res.time</td>';
				echo '<td style="text-align: center;">Res.No</td>';
				echo '<td style="text-align: center;">Guest Name</td>';			
				echo '<td style="text-align: center;">No.Room</td>';
				echo '<td style="text-align: center;">Total Amount</td>';				
				echo '<td style="text-align: center;">Mode</td>';
				echo '<td style="text-align: center;">User</td>';
				echo '</tr>';
			  }			 

			  foreach ($exec1->result_array() as $rows1)
			  {
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows1['yearprefix'].'/'.$rows1['resadno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows1['rptdate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows1['rpttime'],11,5).'</td>';
				echo '<td  style="text-align: center;">'.$rows1['yearprefix'].'/'.$rows1['ResNo'].'</td>';
				echo '<td style="text-align: left;">'.$rows1['Title'].'.'.$rows1['Firstname'].'</td>';												
				echo '<td style="text-align: right;">'.$rows1['totrooms'].'</td>';
				echo '<td style="text-align: right;">'.$rows1['Amount'].'</td>';
				echo '<td style="text-align: left;">'.$rows1['PayMode'].'</td>';
				echo '<td style="text-align: left;">'.$rows1['EmailId'].'</td>';
				echo '</tr>';
				$totalAdvance=$totalAdvance+$rows1['Amount'];
				if($rows1['PayMode']=='CASH')
				{ $CASH=$CASH+$rows1['Amount']; }
				else if($rows1['PayMode']=='CREDIT CARD')
				{ $CARD=$CARD + $rows1['Amount']; }
				else if($rows1['PayMode']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows1['Amount']; }
				else if($rows1['PayMode']=='TO ROOM')
				{ $ROOM=$ROOM+$rows1['Amount'];}
			  }
			  if($resadvance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="7" class="text-bold" style="text-align: center;">Total Res Advance Collection</td>';
				echo '<td style="text-align: right;">'.number_format($totalAdvance,2).'</td>';				
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: center;"></td>';				
				echo '</tr>';	
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';				
			  }
			 
			  
           $qry3="select isnull(tpd.Paidamount,0) as Amt,(case when tpd.Paidamount< 0 then 'REFUND' else pm.paymode end) as PayMod, * from trans_checkout_mas tcm
		  	left outer join Trans_Pay_Det tpd on tcm.Checkoutid=tpd.Checkoutid 
		  	inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid 
			Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
		  	inner join Mas_Room room on room.Room_Id=tcm.Roomid 
		  	left outer join mas_paymode pm on pm.PayMode_Id=tpd.paymodeid 
		  	inner join Trans_Checkin_mas chmas on chmas.Grcid=tcm.grcid 
			inner join Trans_Roomdet_det tdet on tdet.roomgrcid=tcm.roomgrcid
			left outer join mas_foodplan mfp on tdet.planid=mfp.FoodPlan_Id
			left outer join Trans_credit_entry tce on tce.roomgrcid=tdet.roomgrcid
			left outer join Mas_RoomType mst on mst.RoomType_Id = room.RoomType_Id
			left outer join Trans_Advancereceipt_mas tas on tas.receiptid = tpd.receiptid
			inner join UserTable ut on ut.User_id=tcm.userid  Where tcm.checkoutno like
		   ('CHK%') and isnull(tpd.Paymodeid,0)<>18 and isnull(tcm.groupcheckout,0)=0 and
			tcm.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' 
			and '".date('Y-m-d',strtotime($_POST['todate']))."' and tcm.settle <>0 and isnull(tcm.cancelflag,0)=0
			and isnull(tpd.Paymodeid,0)<> 4 order by tcm.Checkoutno desc ";
			 $exec3=$this->db->query($qry3); $totalAdvance=0;
			 $checkout= $exec3->num_rows(); $i=1;
			 
			  if($checkout !=0)
			  {
				echo '<tr>';
				echo '<td class="text-bold" colspan="17" style="text-align: center;background-color:#c9c6c6;">Checkout Bills</td>';			
				echo '</tr>';			  
				echo '<tr  style="background-color:#c9c6c6">';		 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt.No</td>';
				// echo '<td  style="text-align: center;">Rec.Date</td>';
				// echo '<td  style="text-align: center;">Rec.Time</td>';
				echo '<td style="text-align: center;">Room.No</td>';
				echo '<td style="text-align: center;">Advance</td>';
				echo '<td style="text-align: center;">Tot.Amt</td>';
				echo '<td style="text-align: center;">Ds / Pax</td>';				
				echo '<td style="text-align: center;">Ex.Bed</td>';				
				echo '<td style="text-align: center;">Food</td>';				
				echo '<td style="text-align: center;">All.nce</td>';				
				echo '<td style="text-align: center;">Disc</td>';				
				echo '<td style="text-align: center;">Credit</td>';				
				echo '<td style="text-align: center;">Debit</td>';				
				echo '<td style="text-align: center;">Date</td>';				
				echo '<td style="text-align: center;">Mode / Time</td>';	
					echo '<td style="text-align: center;">User</td>';	
				echo '<td style="text-align: center;">Details</td>';						
				echo '<td style="text-align: center;">Mode</td>';
			
				echo '</tr>';
			  }
			  $debittotal=0; 
			  $credittotal=0;
			  $TotalCheckout = 0;
			  $totalAdvance = 0;
			  $totalnoofdays = 0;
			  $totalNoofpersons = 0;
			  $totalexbed = 0;
			  $totalfood = 0;
			  $totalallowance = 0;
			  $totaldiscount = 0;
			  $totalcredit = 0;
			  $totaldebit = 0;
			  foreach ($exec3->result_array() as $rows3)
			  {		
		$foodquery = "
    SELECT SUM(amount) AS food 
    FROM Trans_credit_entry tce 
    INNER JOIN mas_Revenue mr ON tce.Creditheadid = mr.Revenue_Id 
    WHERE tce.roomgrcid = '".$rows3['Roomgrcid']."' 
    AND mr.revenuehead IN ('FOOD')
";

$query = $this->db->query($foodquery);
$food = $query->row_array();  

			 		$allowanceqry = " select sum(amount) as allowance from  Trans_credit_entry tce 
			 inner join mas_Revenue mr on tce.Creditheadid= mr.Revenue_Id
			 where tce.roomgrcid='".$rows3['Roomgrcid']."' and ISnull(mr.isAllowance,0) = 1";
			 $allquery = $this->db->query($allowanceqry);
                 $allowance = $allquery->row_array();  


		     
			
                $t_food = $food['food'];
				$totalfood = $totalfood + $t_food;

				    $t_allowance = $allowance['allowance'];
				$totalallowance = $totalallowance + $t_allowance;

				$t_discount = $rows3['Discount'];
				$totaldiscount = $totaldiscount + $t_discount;

				
				 $Amt=$rows3['Amt'];
				 $TotalCheckout = $TotalCheckout + $Amt;
				 $Advance = $rows3['Advance'];
				 $noofdays = $rows3['noofdays'];
				 $Noofpersons = $rows3['Noofpersons'];
				 $Extrabedamount = $rows3['Extrabedamount'];
				//  $totalAdvance = $totalAdvance + $Advance;
				 $totalnoofdays = $totalnoofdays + $noofdays;
				 $totalNoofpersons = $totalNoofpersons + $Noofpersons;
				 $totalexbed = $totalexbed + $Extrabedamount;

				if($rows3['PayMod'])
				{				
					$PayMode=$rows3['PayMode'];
				}
				else
				{
					$PayMode='Refund';
				}
				if($rows3['PayMod']=='REFUND'){
					$PayMode = $rows3['PayMod'];
				}
				if($rows3['PayMod']=='TO ROOM'){
					$Amt= $rows3['Amount'];
				}

				   $cr_deb = $Amt + $rows3['Extrabedamount'] + $food['food'] - ($allowance['allowance'] +  $rows3['Discount'] + $rows3['Advance']);   
				   
				   $debit = 0;
                   $credit = 0;

				   if($cr_deb < 0){  
                      $debit = $cr_deb;
				   } else{
                     $credit = $cr_deb;
				   }

				   	$t_credit = $credit;
				$totalcredit = $totalcredit + $t_credit;

				   	$t_debit = $debit;
				$totaldebit = $totaldebit + $t_debit;
		
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows3['yearPrefix'].'/'.$rows3['Checkoutno'].'</td>';
				// echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows3['Checkoutdate'])).'</td>';
				// echo '<td style="text-align: center;">'.substr($rows3['Checkouttime'],11,5).'</td>';
				echo '<td style="text-align: center;">'.$rows3['RoomNo'].'</td>';
				echo '<td style="text-align: center;">'.$rows3['Advance'].'</td>';
				echo '<td style="text-align: right;">'.$Amt.'</td>';
				echo '<td style="text-align: center;">'. $rows3['noofdays'] . ' / '.$rows3['Noofpersons'].'</td>';
				echo '<td style="text-align: center;">'. $rows3['Extrabedamount'] .'</td>';
				echo '<td style="text-align: center;">'. $food['food'].'</td>';				
				echo '<td style="text-align: center;">'.$allowance['allowance'].'</td>';				
				echo '<td style="text-align: center;">'. $rows3['Discount'] .'</td>';				
				echo '<td style="text-align: center;">'.  $debit.'</td>';				
				echo '<td style="text-align: center;">'. $credit .'</td>';				
		       echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows3['Checkoutdate'])).'</td>';			
				echo '<td style="text-align: center;">'.$rows3['PayMode'].' / '.substr($rows3['Checkouttime'],11,5).'</td>';	
				echo '<td style="text-align: left;">'.$rows3['EmailId'].'</td>';
			    echo '<td style="text-align: left;">' . $rows3['RoomNo'] . ' - ' . $rows3['Firstname'] . '</td>';	
		
				echo '<td style="text-align: left;">'.$PayMode.'</td>';
			
				echo '</tr>';
				$totalAdvance=$totalAdvance+$rows3['totalamount'];			
				if($rows3['PayMod']=='CASH')
				{ $CASH=$CASH+$rows3['Amount']; }
				else if($rows3['PayMod']=='CREDIT CARD')
				{ $CARD=$CARD + $rows3['Amount']; }
				else if($rows3['PayMod']== 'UPI'){
					$upi = $upi +$rows3['Amount'];
				}
				else if($rows3['PayMod']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows3['Amount']; }
				else if($rows3['PayMod']=='TO ROOM')
				{ $ROOM=$ROOM+$rows3['Amount'];}
				elseif($rows3['PayMod']=='REFUND'){
				$REFUNDCHK += abs($rows3['Amt']);
				}else{
					$CASH=$CASH+$rows3['Amt'];
				}
			  }
			  if($checkout !=0){
				echo '<tr>';
			    echo '<td style="text-align: center;" class="text-bold" colspan="3">Sub Total</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($totalAdvance,2).'</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($TotalCheckout,2).'</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($totalnoofdays,2).' / '.number_format($totalNoofpersons,2).'</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($totalexbed,2).'</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($totalfood,2).'</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($totalallowance,2).'</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($totaldiscount,2).'</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($totaldebit,2).'</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($totalcredit,2).'</td>';

			    echo '</tr>';	
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';	
			  }	
			  
			  
             

		
			  $qry9="select mas.Creditno,mp.paymode as bank, det.Amount as Paidamount, mas.creditid,ut.Emailid,mas.yearprefix from trans_billpay_mas mas
			  inner join trans_billpay_det det on mas.creditid = det.Creditid
			  inner join UserTable ut on ut.User_id= mas.userid
			  inner join mas_paymode mp on mp.PayMode_Id = det.Paymodeid 
			  where mas.Creditdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and
			  '".date('Y-m-d',strtotime($_POST['todate']))."' ";
			  $exec3=$this->db->query($qry9); $totalAdvance=0;
			  $checkout= $exec3->num_rows(); $i=1;
			   if($checkout !=0)
			   {
				 echo '<tr >';
				 echo '<td class="text-bold" colspan="10" style="text-align: center;background-color:#c9c6c6;">Pending Collection</td>';			
				 echo '</tr>';			  
				 echo '<tr  style="background-color:#c9c6c6">';		 
				 echo '<td  style="text-align: center;">S.No</td>';
				 echo '<td  style="text-align: center;" colspan="2">Receipt No</td>';
				 echo '<td  style="text-align: center;" colspan="3">Checkout No</td>';									
				 echo '<td style="text-align: center;">Paid Amount</td>';	
				 echo '<td style="text-align: center;">PayMode</td>';				
				 echo '<td style="text-align: center;">Company</td>';
				 echo '<td style="text-align: center;">User</td>';
				 echo '</tr>';
			   }
			   $debittotal=0; 
			   $credittotal=0;
			   $TotalCheckout=0;
			 
			   $creditnos = '';
			   $creditbillno = '';
			   $totalpaidamount = 0;
			   $totalAmount = 0;
			   foreach ($exec3->result_array() as $rows3)
			   {	
				$billnos ='';
				$companyname ='';
			   $sql1 = "select mas.Checkoutno,mas.yearPrefix,mc.company as paymode from trans_bill_det  det
				inner join trans_checkout_mas mas on mas.checkoutid = det.checkoutid
				inner join trans_pay_det dett on dett.Checkoutid = det.checkoutid and isnull(dett.cancelflag,0)<>1
				inner join mas_company mc on mc.Company_Id = dett.Bankid
				inner join Mas_CompanyType mct on mct.companytype_id = mc.companytype_id 
				where Creditid='".$rows3['creditid']."' and mct.CompanyType<>'travelagent' and det.paidamount <>0";
				$exec = $this->db->query($sql1);
				forEach($exec->result_array() as $row){
					$yearprefixbillno = $row['yearPrefix'];
					$yearPrefix = $row['yearPrefix'].'/'.$row['Checkoutno'];
					$billnos .=$yearPrefix.' ';
					$companyname = $row['paymode'];
					

				}
				
				echo '<tr>';
				if($creditbillno != $rows3['Creditno']){		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;" colspan="2">'.$yearprefixbillno.'/'.$rows3['Creditno'].'</td>';
				echo '<td style="text-align: center;" colspan="3">'.$billnos.'</td>';
				}else{
					echo '<td  style="text-align: center;"></td>';
					echo '<td  style="text-align: center;" colspan="2"></td>';
				    echo '<td style="text-align: center;" colspan="3"></td>';
				}							
				echo '<td style="text-align: right;">'.$rows3['Paidamount'].'</td>';
				echo '<td style="text-align: left;">'.$rows3['bank'].'</td>';			
				echo '<td style="text-align: left;">'.$companyname.'</td>';
				echo '<td style="text-align: left;">'.$rows3['Emailid'].'</td>';
				echo '</tr>';
				
				
				$creditbillno = $rows3['Creditno'];
			    $TotalCheckout = $TotalCheckout+ $rows3['Paidamount'];
				  
						
				if($rows3['bank']=='CASH')
				{ $CASH=$CASH+$rows3['Paidamount']; }
				else if($rows3['bank']=='CREDIT CARD')
				{ $CARD=$CARD + $rows3['Paidamount']; }
				else if($rows3['bank']== 'UPI'){
					$upi = $upi +$rows3['Paidamount'];
				}
				else if($rows3['bank']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows3['Paidamount']; }
				else if($rows3['bank']=='TO ROOM')
				{ $ROOM=$ROOM+$rows3['Paidamount'];}
				else{
					$CASH=$CASH+$rows3['Paidamount'];
				}
			  
			}
			  
			 
			   if($checkout !=0){
				 echo '<tr>';
				 echo '<td style="text-align: center;" class="text-bold" colspan="6 ">Total Collection Amount</td>';
				 echo '<td style="text-align: right;">'.number_format($TotalCheckout,2).'</td>';
				 echo '</tr>';
				 echo '<tr>';
				 echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				 echo '</tr>';	
			   }	
			 
	
			  $check = "select * from ExtraOption";
			  $exe = $this->db->query($check);
			  foreach($exe->result_array() as $extraoption){
				  $checkwalkout = $extraoption['walkoutbillshowincashierreport'];
			  }
			 
 
			
			

		 $qry7="select tpd.Amount as Amt,masc.Company as Com, * from trans_checkout_mas tcm
		  	left outer join Trans_Pay_Det tpd on tcm.Checkoutid=tpd.Checkoutid  and isnull(tpd.cancelflag,0)<>1
		  	inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid 
			Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
		  	inner join Mas_Room room on room.Room_Id=tcm.Roomid 
		  	left outer join mas_paymode pm on pm.PayMode_Id=tpd.paymodeid 
			left outer join Mas_Company masc on masc.Company_Id =  tpd.bankid
		  	inner join Trans_Checkin_mas chmas on chmas.Grcid=tcm.grcid 
			inner join UserTable ut on ut.User_id=tcm.userid  Where tcm.checkoutno like
		   ('CHK%') and isnull(tpd.Paymodeid,0)<>18 and isnull(tcm.groupcheckout,0)=0 and
			tcm.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and 
			'".date('Y-m-d',strtotime($_POST['todate']))."' and tcm.settle <>0 and isnull(tcm.cancelflag,0)=0  and 
			isnull(tpd.Paymodeid,0)=4 order by tcm.Checkoutno desc ";
			 $exec3=$this->db->query($qry7); $totalAdvance=0;
			 $checkout= $exec3->num_rows(); $i=1;
			  if($checkout !=0)
			  {
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;background-color:#c9c6c6;">Company Checkout Bills</td>';			
				echo '</tr>';			  
				echo '<tr  style="background-color:#c9c6c6">';		 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt.No</td>';
				echo '<td  style="text-align: center;">Rec.Date</td>';
				echo '<td  style="text-align: center;">Rec.Time</td>';
				echo '<td style="text-align: center;">Room.No</td>';
				echo '<td style="text-align: center;">Guest Name</td>';							
				echo '<td style="text-align: center;">Pax</td>';				
				echo '<td style="text-align: center;">Total Amount</td>';				
				echo '<td style="text-align: center;">Mode</td>';
				echo '<td style="text-align: center;">User</td>';
				echo '</tr>';
			  }
			  $debittotal=0; 
			  $credittotal=0;
			  $TotalCheckout=0;
			  foreach ($exec3->result_array() as $rows3)
			  {							
				
				 $Amt=$rows3['Amt'];
				$TotalCheckout = $TotalCheckout+ $Amt;
				if($rows3['PayMode'])
				{				
					$PayMode=$rows3['PayMode'];
				}
				else
				{
					$PayMode='Refund';
				}
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows3['yearPrefix'].'/'.$rows3['Checkoutno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows3['Checkoutdate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows3['Checkouttime'],11,5).'</td>';
				echo '<td style="text-align: center;">'.$rows3['RoomNo'].'</td>';
				echo '<td style="text-align: left;">'.$rows3['Title'].'.'.$rows3['Firstname'].'</td>';								
				echo '<td style="text-align: center;">'.$rows3['Noofpersons'].'</td>';
				echo '<td style="text-align: right;">'.$Amt.'</td>';		
				echo '<td style="text-align: left;">'.$rows3['Com'].'</td>';
				echo '<td style="text-align: left;">'.$rows3['EmailId'].'</td>';
				echo '</tr>';
				$totalAdvance=$totalAdvance+$rows3['totalamount'];			
				if($rows3['PayMode']=='CASH')
				{ $CASH=$CASH+$rows3['Amount']; }
				else if($rows3['PayMode']=='CREDIT CARD')
				{ $CARD=$CARD + $rows3['Amount']; }
				else if($rows3['PayMode']== 'UPI'){
					$upi = $upi +$rows3['Amount'];
				}else if($rows3['PayMode']== 'COMPANY '){
					$company = $company + $rows3['Amount'];
				}
				else if($rows3['PayMode']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows3['Amount']; }
				else if($rows3['PayMode']=='TO ROOM')
				{ $ROOM=$ROOM+$rows3['Amount'];}
				else{
					$company=$company+$rows3['Amt'];
				}
				
			  }
			  if($checkout !=0){
				echo '<tr>';
			    echo '<td style="text-align: center;" class="text-bold" colspan="7 ">Total CheckOut Bill Amount</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($TotalCheckout,2).'</td>';
			    echo '</tr>';
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';	
			  }	

			 
             $check = "select * from ExtraOption";
			 $exe = $this->db->query($check);
			 foreach($exe->result_array() as $extraoption){
                 $checkwalkout = $extraoption['walkoutbillshowincashierreport'];
			 }
			 if($checkwalkout==1){
		 $qry8="select pdet.Amount as Amt,masc.Company as Com, * from trans_checkout_mas tcm
		  	left outer join Trans_Pay_Det tpd on tcm.Checkoutid=tpd.Checkoutid 
		  	inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid 
			Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
		  	inner join Mas_Room room on room.Room_Id=tcm.Roomid 
		  	left outer join mas_paymode pm on pm.PayMode_Id=tpd.paymodeid 
			left outer join Mas_Company masc on masc.Company_Id =  tpd.bankid
		  	inner join Trans_Checkin_mas chmas on chmas.Grcid=tcm.grcid 
			left outer join  Trans_Pay_Det pdet on pdet.Checkoutid=tcm.Checkoutid
			inner join UserTable ut on ut.User_id=tcm.userid  Where tcm.checkoutno like
		   ('WHK%') and isnull(tpd.Paymodeid,0)<>18 and isnull(tcm.groupcheckout,0)=0 and
			tcm.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' 
			and '".date('Y-m-d',strtotime($_POST['todate']))."' and tcm.settle <>0 
			and isnull(ut.comcheckoutoptioncashierreport, 0) <>0 order by tcm.checkoutno";
			 $exec3=$this->db->query($qry8); $totalAdvance=0;
			 $checkout= $exec3->num_rows(); $i=1;
			  if($checkout !=0)
			  {
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;background-color:#c9c6c6;">complementary Checkout Bills</td>';			
				echo '</tr>';			  
				echo '<tr  style="background-color:#c9c6c6">';		 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt.No</td>';
				echo '<td  style="text-align: center;">Rec.Date</td>';
				echo '<td  style="text-align: center;">Rec.Time</td>';
				echo '<td style="text-align: center;">Room.No</td>';
				echo '<td style="text-align: center;">Guest Name</td>';							
				echo '<td style="text-align: center;">Pax</td>';				
				echo '<td style="text-align: center;">Total Amount</td>';				
				echo '<td style="text-align: center;">Mode</td>';
				echo '<td style="text-align: center;">User</td>';
				echo '</tr>';
			  }
			  $debittotal=0; 
			  $credittotal=0;
			  $TotalCheckout=0;
			  foreach ($exec3->result_array() as $rows3)
			  {							
				if($rows3['Amt']='')
				{ $Amt=$rows3['Amt'];}
				else
				{ $Amt=$rows3['totalamount'];}
				$TotalCheckout = $TotalCheckout+ $Amt;
				if($rows3['PayMode'])
				{				
					$PayMode=$rows3['PayMode'];
				}
				else
				{
					$PayMode='Refund';
				}
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows3['yearPrefix'].'/'.$rows3['Checkoutno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows3['Checkoutdate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows3['Checkouttime'],11,5).'</td>';
				echo '<td style="text-align: center;">'.$rows3['RoomNo'].'</td>';
				echo '<td style="text-align: left;">'.$rows3['Title'].'.'.$rows3['Firstname'].'</td>';								
				echo '<td style="text-align: center;">'.$rows3['Noofpersons'].'</td>';
				echo '<td style="text-align: right;">'.$Amt.'</td>';		
				echo '<td style="text-align: left;">'.$rows3['PayMode'].'</td>';
				echo '<td style="text-align: left;">'.$rows3['EmailId'].'</td>';
				echo '</tr>';
				$totalAdvance=$totalAdvance+$rows3['totalamount'];			
				if($rows3['PayMode']=='CASH')
				{ $CASH=$CASH+$rows3['Amount']; }
				else if($rows3['PayMode']=='CREDIT CARD')
				{ $CARD=$CARD + $rows3['Amount']; }
				else if($rows3['PayMode']== 'UPI'){
					$upi = $upi +$rows3['Amount'];
				}else if($rows3['PayMode']== 'COMPANY'){
					$company = $company + $rows3['Amount'];
				}
				else if($rows3['PayMode']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows3['Amount']; }
				else if($rows3['PayMode']=='TO ROOM')
				{ $ROOM=$ROOM+$rows3['Amount'];}
				else{
					$CASH=$CASH+$rows3['totalamount'];
				}
			  }
			  if($checkout !=0){
				echo '<tr>';
			    echo '<td style="text-align: center;" class="text-bold" colspan="7 ">Total CheckOut Bill Amount</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($TotalCheckout,2).'</td>';
			    echo '</tr>';
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';
			  }	
			}
		
			
			$qry91 = "exec cashBookReport '".date('Y-m-d',strtotime($_POST['frmdate']))."',
			 '".date('Y-m-d',strtotime($_POST['todate']))."' ";
			 $qryres = $this->db->query($qry91);
			 $qryno9 = $qryres->num_rows(); $i=1;
			 if($qryno9 !=0){
				echo '<tr>';
				 echo '<td class="text-bold" colspan="10" style="text-align: center;background-color:#c9c6c6;">Daily Cash Book Report</td>';			
				 echo '</tr>';			  
				 echo '<tr style="background-color:#c9c6c6">';		 
				 echo '<td  style="text-align: center;">S.No</td>';
				 echo '<td  style="text-align: center;"colspan="2">Receipt.No</td>';
				 echo '<td  style="text-align: center;" >Rec.Date</td>';
				 echo '<td  style="text-align: center;"colspan="3">Particular</td>';
				 echo '<td style="text-align: center;" >Credit / Debit</td>';
				//  echo '<td style="text-align: center;" >Debit</td>';							
				 echo '<td style="text-align: center;"colspan="2">User</td>';
				 echo '</tr>';
			 }
			 foreach($qryres ->result_array() as $rows){
				if($rows['Debitorcredit']=='C'){
                    $creditTotal += $rows['Amount'];
                    $creditAmount = $rows['Amount'];

                }else{
                    $debitTotal += $rows['Amount'];
                    $debitAmount =$rows['Amount'];
                }
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;"colspan="2" >'.$rows['DailyNo'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['Cashdate'])).'</td>';
				echo '<td style="text-align: left;" colspan="3">'.$rows['Head'].'</td>';	
                if($rows['Debitorcredit']=='C'){			
				echo '<td style="text-align: right;" >'.$creditAmount.' Cr'.'</td>';
                }else{
                    echo '<td style="text-align: right;" >'.$debitAmount.' Dr'.'</td>';
                }	
                // if($rows['Debitorcredit']=='D'){				
				// echo '<td style="text-align: right;" >'.$debitAmount.'</td>';
                // }else{
                //     echo '<td style="text-align: right;" >0.00</td>'; 
                // }
				echo '<td style="text-align: center;" colspan="2">'.$rows['EmailId'].'</td>';				
				echo '</tr>';
			 }
			 if($qryno9 !=0){
				$totalcrdr = $creditTotal-$debitTotal;
				if($totalcrdr<0){
					$crdr = number_format($totalcrdr,2) . ' Dr';
				}else{
					$crdr = number_format($totalcrdr,2) . ' Cr';
				}
				echo '<tr>';
			    echo '<td style="text-align: center;" class="text-bold" colspan="7 ">Total Credit and Debit</td>';
			    echo '<td style="text-align: right;" class="">'.$crdr.'</td>';
				// echo '<td style="text-align: right;" class="">'.number_format($debitTotal,2).'</td>';
			    echo '</tr>';
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';	
			  }	
		
			
			 $qry4="select mt.Title+'.'+cus.Firstname as Name,* from trans_reservecancel_mas mas
			  Inner join Trans_Reserve_mas rmas on rmas.Resid=mas.reserveid 
			  Inner join Mas_Customer cus on cus.Customer_Id=rmas.cusid
			  Inner join Mas_Title mt on mt.Titleid=cus.Titelid 
			  left outer join mas_paymode pm on pm.PayMode_Id=mas.payid 
			  inner join UserTable ut on ut.User_id=mas.userid  
			  where isnull(mas.refund,0)<>0 and isnull(advamount,0)<>0 and mas.resdate
			  between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and '".date('Y-m-d',strtotime($_POST['todate']))."'";
			  $exec4=$this->db->query($qry4); $totalAdvance=0;
			  $resrefund= $exec4->num_rows(); $i=1;
			   if($resrefund !=0)
			   {
				 echo '<tr>';
				 echo '<td class="text-bold" colspan="10" style="text-align: center;background-color:#c9c6c6;">Reservation Refund</td>';			
				 echo '</tr>';			  
				 echo '<tr style="background-color:#c9c6c6">';		 
				 echo '<td  style="text-align: center;">S.No</td>';
				 echo '<td  style="text-align: center;">Receipt.No</td>';
				 echo '<td  style="text-align: center;">Rec.Date</td>';
				 echo '<td  style="text-align: center;">Rec.Time</td>';
				 echo '<td style="text-align: center;">Res.No</td>';
				 echo '<td style="text-align: center;">Guest Name</td>';							
				 echo '<td style="text-align: center;">No.Rooms</td>';				
				 echo '<td style="text-align: center;">Refund Amount</td>';				
				 echo '<td style="text-align: center;">Mode</td>';
				 echo '<td style="text-align: center;">User</td>';
				 echo '</tr>';
			   }
			   foreach ($exec4->result_array() as $rows4)
			   {
				 echo '<tr>';		 
				 echo '<td  style="text-align: center;">'.$i++.'</td>';
				 echo '<td  style="text-align: center;">'.$rows4['yearprefix'].'/'.$rows4['resno'].'</td>';
				 echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows4['resdate'])).'</td>';
				 echo '<td style="text-align: center;">'.substr($rows4['restime'],11,5).'</td>';
				 echo '<td  style="text-align: center;">'.$rows4['yearprefix'].'/'.$rows4['ResNo'].'</td>';
				 echo '<td style="text-align: left;">'.$rows4['Title'].'.'.$rows4['Firstname'].'</td>';												
				 echo '<td style="text-align: right;">'.$rows4['totrooms'].'</td>';
				 echo '<td style="text-align: right;">'.number_format($rows4['refund'],2).'</td>';
				 echo '<td style="text-align: left;">'.$rows4['PayMode'].'</td>';
				 echo '<td style="text-align: left;">'.$rows4['EmailId'].'</td>';
				 echo '</tr>';
				$totalAdvance=$totalAdvance+$rows4['refund'];
				 
				 if($rows4['PayMode']=='CASH')
				 { $CASH=$CASH-$rows4['refund']; }
				 else if($rows4['PayMode']=='CREDIT CARD')
				 { $CARD=$CARD - $rows4['refund']; }
				 else if($rows4['PayMode']=='NET TRANSFER')
				 { $NEFT=$NEFT-$rows4['refund']; }
				 else if($rows4['PayMode']=='TO ROOM')
				 { $ROOM=$ROOM-$rows4['refund'];}
			   }
			   if($resrefund !=0)
				{
					echo '<tr>';
					echo '<td colspan="7" class="text-bold" style="text-align: center;">Total Reservation Refund</td>';
					echo '<td style="text-align: right;">'.number_format($totalAdvance,2).'</td>';
					echo '<td style="text-align: right;"></td>';
					echo '<td style="text-align: center;"></td>';								
					echo '</tr>';				
				}
			  echo '<tr>';
			  echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
			  echo '</tr>';	
			  
			 
	
				  echo '<tr>';
				  echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				  echo '</tr>';	

			    echo '<tr>';
			  	echo '<td  colspan="2" style="text-align: left;"> CASH </td>';
			  	echo '<td  colspan="2" style="text-align: right;">'.number_format($CASH,2).'</td>';
			  	echo '<td  colspan="8"></td>';
			  	echo '</tr>';
	
			 
			  	echo '<tr>';
			  	echo '<td  colspan="2" style="text-align: left;">CREDITCARD</td>';
			  	echo '<td colspan="2" style="text-align: right;">'.number_format($CARD,2).'</td>';
			  	echo '<td  colspan="8"></td>';
			  	echo '</tr>';		
			
				echo '<tr>';
				echo '<td  class=" text-left" colspan="2" >NET TRANSFER</td>';
				echo '<td colspan="2" style="text-align: right;">'.number_format($NEFT,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
		
				echo '<tr>';
				echo '<td  colspan="2" style="text-align: left;">TOROOM</td>';
				echo '<td style="text-align: right;" colspan="2">'.number_format($ROOM,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
		
				echo '<tr>';
				echo '<td  colspan="2" style="text-align: left;">UPI</td>';
				echo '<td style="text-align: right;" colspan="2">'.number_format($upi,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';

				echo '<tr>';
				echo '<td  colspan="2" style="text-align: left;">COMPANY</td>';
				echo '<td style="text-align: right;" colspan="2">'.number_format($company,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="text-bold" colspan="2"  style="text-align: left;">GRAND TOTAL</td>';
				echo '<td colspan="2" class="text-bold" style="text-align: right;">'.number_format($CASH+$CARD+$NEFT+$upi+$creditTotal-$debitTotal,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';



				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">&nbsp;</td>';			
				echo '</tr>';		
				echo '<tr>';
				echo '<td  class="text-bold"  colspan="2" style="text-align: left;">OPENING </td>';
				echo '<td  colspan="2" style="text-align: right;">'.number_format($openingBal,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';

				echo '<tr>';
				echo '<td  colspan="2" style="text-align: left;">INCOME</td>';
				echo '<td style="text-align: right;" colspan="2">'.number_format($creditTotal,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td  colspan="2" style="text-align: left;">EXPENSE</td>';
				echo '<td style="text-align: right;" colspan="2">'.number_format($debitTotal,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td  colspan="2" style="text-align: left;">REFUND</td>';
				echo '<td style="text-align: right;" colspan="2">'.number_format($REFUNDCHK,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="text-bold" colspan="2" style="text-align: left;">CASH ON HAND</td>';
				echo '<td class="text-bold" style="text-align: right;" colspan="2">'.number_format($CASH+$creditTotal-$debitTotal,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="text-bold" colspan="2" style="text-align: left;">CLOSING</td>';
				echo '<td class="text-bold" style="text-align: right;" colspan="2">'.number_format($openingBal+$CASH+$creditTotal-$debitTotal+$CARD+$NEFT+$upi,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
				
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
              filename: "Cashier Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("CashierReport.pdf");
                }
            });
        });

		</script>