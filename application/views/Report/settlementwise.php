<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','settlement Wise  Report');
$this->pfrm->FrmHead6('Report / settlement Wise Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>
   <?php date_default_timezone_set('Asia/Kolkata') ?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From </td>
          <td align="left"><input type="date" value="<?php echo date('Y-m-d'); ?>" id="frmdate" name="frmdate"   max="<?php echo date('Y-m-d'); ?>" class="scs-ctrl " />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To </td>
          <td align="left"><input type="date" value="<?php echo date('Y-m-d'); ?>" id="todate" name="todate"   max="<?php echo date('Y-m-d'); ?>" class="scs-ctrl " />
            <div class="Type" ></div></td>        
		   <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
           <td align="right" class="F_val">Mode</td>
           <td align="left">
               
                    
               
                    <select name="paymode" id="paymode" class="scs-ctrl">
                        <option value="0">Select Plan</option>
                        <?php
                        $qry="select * from Mas_Paymode";
                        $res=$this->db->query($qry);
                        foreach ($res->result_array() as $row)
                        {
                        echo '<option value="'.$row['PayMode_Id'].'"	 >'.$row['PayMode'].'</option>';
                        }
                        ?>
                    <select>
               
                
                </div>
            </td>
        </tr>
      	</table>
	   </form>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div id="printing"  class="col-sm-12">
		<?php

		if(@$_POST['submit'])
		{
		  ?>
		
        <table class="table table-bordered table-hover table-responsive"  >    
		<div>
				<h4 class="text-center">settlement Wise Report  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?><h4>
				
		    </div>     
		   <tbody>
		    <?php 
			 $i=1;
			 $norow=0; $CASH=0; $CARD=0; $NEFT=0; $ROOM=0; $REFUND=0; $upi = 0; $company = 0;$collection= 0;
			 $creditTotal = 0;
             $debitTotal = 0;
             $creditAmount = 0;
             $debitAmount = 0;
             if(@$_POST['paymode'] !=0 ){
                 $pay1 = "Exec Get_Paymode '".@$_POST['paymode']."' ";
             }else{
                $pay1 = "Exec Get_Paymode ";
             }
             $pay1e = $this->db->query($pay1);

             foreach($pay1e->result_array() as $p7){
			  $qry="select * from trans_receipt_mas recmas 
			 inner join mas_Room rmas on rmas.Room_id=recmas.roomid 
			 inner join trans_checkin_mas tcm on tcm.Grcid = recmas.grcid 
			 inner join Mas_Customer cs on cs.Customer_Id = recmas.customerid 
			 Left outer join Mas_Title ti on ti.Titleid=cs.Titelid
			 inner join mas_paymode pm on pm.PayMode_Id = recmas.paymodeid
			 inner join UserTable ut on ut.User_id=recmas.userid
			 where isnull(ReceiptType,'')<>'O'  and pm.PayMode_Id='".$p7['PayMode_Id']."'
			 and isnull(cancel,0)<>1  and recmas.rptdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and '".date('Y-m-d',strtotime($_POST['todate']))."' ";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';	
				echo '<td colspan="7" class="text-bold" style="text-align: center;">Advance Collection - '.$p7['PayMode'].'</td>';			
				echo '</tr>';

				echo '<tr style="background-color:#c9c6c6;">';		 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt.No</td>';
				echo '<td style="text-align: center;">Rec.Dt</td>';
				echo '<td style="text-align: center;">Rec.Time</td>';
				echo '<td style="text-align: center;">Room.No</td>';
				echo '<td style="text-align: center;">Guest Name</td>';		
				echo '<td style="text-align: center;">Pax</td>';
				echo '<td style="text-align: center;">Total Amount</td>';		
				echo '<td style="text-align: center;">User</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {
				if($rows['PayMode']=='CASH')
				{ $CASH=$CASH+$rows['Amount']; }
				else if($rows['PayMode']=='CREDIT CARD')
				{ $CARD=$CARD + $rows['Amount']; }
				else if($rows['PayMode']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows['Amount']; }
				else if($rows['PayMode']=='TO ROOM')
				{ $ROOM=$ROOM+$rows['Amount'];}
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows['yearprefix'].'/'.$rows['Receiptno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['rptdate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows['rpttime'],11,5).'</td>';
				echo '<td style="text-align: center;">'.$rows['RoomNo'].'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].'</td>';								
				echo '<td style="text-align: center;">'.$rows['Noadults'].'</td>';
				echo '<td style="text-align: right;">'.number_format($rows['Amount'],2).'</td>';				
				echo '<td style="text-align: left;">'.$rows['EmailId'].'</td>';
				echo '</tr>';
				$totalAdvance=$totalAdvance+$rows['Amount'];
			  }
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="7" class="text-bold" style="text-align: center;">Total Advance Collection</td>';
				echo '<td style="text-align: right;">'.number_format($totalAdvance,2).'</td>';
				echo '<td style="text-align: right;"></td>';
											
				echo '</tr>';				
			  }
            }
             
             foreach($pay1e->result_array() as $p1){
			  $qry1="select * from trans_receipt_mas rmas
			  inner join trans_reserveadd_mas readd on readd.resaddid=rmas.Billid
			  inner join Mas_Customer cs on cs.Customer_Id = rmas.customerid
			  Left outer join Mas_Title ti on ti.Titleid=cs.Titelid
			  inner join mas_paymode pm on pm.PayMode_Id = rmas.paymodeid
			  inner join trans_reserve_mas remas on remas.Resid=readd.resid
			  inner join UserTable ut on ut.User_id=rmas.userid
			  where isnull(ReceiptType,'')='A'  and rptdate  between  '".date('Y-m-d',strtotime($_POST['frmdate']))."'
               and '".date('Y-m-d',strtotime($_POST['todate']))."' and pm.paymode_id='".$p1['PayMode_Id']."' ";
			 $exec1=$this->db->query($qry1); $totalAdvance=0;
			 $resadvance= $exec1->num_rows(); $i=1;
			  if($resadvance !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';	
				echo '<td colspan="9" class="text-bold" style="text-align: center;">Reservation Advance Collection - '.$p1['PayMode'].'</td>';			
				echo '</tr>';

				echo '<tr style="background-color:#c9c6c6;">';			 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt</td>';
				echo '<td style="text-align: center;">Res.date</td>';
				echo '<td style="text-align: center;">Res.time</td>';
				echo '<td style="text-align: center;">Res.No</td>';
				echo '<td style="text-align: center;">Guest Name</td>';			
				echo '<td style="text-align: center;">No.Room</td>';
				echo '<td style="text-align: center;">Total Amount</td>';				
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
								
				echo '</tr>';				
			  }
            }
			 
            foreach($pay1e->result_array() as $p2){
			
              $qry3="select pdet.Paidamount as Amt, * from trans_checkout_mas tcm
		  	left outer join Trans_Pay_Det tpd on tcm.Checkoutid=tpd.Checkoutid 
		  	inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid 
			Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
		  	inner join Mas_Room room on room.Room_Id=tcm.Roomid 
		  	left outer join mas_paymode pm on pm.PayMode_Id=tpd.paymodeid 
		  	inner join Trans_Checkin_mas chmas on chmas.Grcid=tcm.grcid 
			left outer join  Trans_Pay_Det pdet on pdet.Checkoutid=tcm.Checkoutid
			inner join UserTable ut on ut.User_id=tcm.userid  Where tcm.checkoutno like
		   ('CHK%') and isnull(tpd.Paymodeid,0)<>18 and isnull(tcm.groupcheckout,0)=0 and
		   isnull(tcm.cancelflag,0) <> 1 and tcm.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' 
			and '".date('Y-m-d',strtotime($_POST['todate']))."' and tcm.settle <>0 
			and isnull(tpd.Paymodeid,0)<>4 and  isnull(pdet.Paymodeid,0)<>4 and pdet.Paymodeid ='".$p2['PayMode_Id']."'";
			 $exec3=$this->db->query($qry3); $totalAdvance=0;
			 $checkout= $exec3->num_rows(); $i=1;
			  if($checkout !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';	
				echo '<td class="text-bold" colspan="9" style="text-align: center;">Checkout Bills - '.$p2['PayMode'].'</td>';			
				echo '</tr>';			  
				echo '<tr style="background-color:#c9c6c6;">';		 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt.No</td>';
				echo '<td  style="text-align: center;">Rec.Date</td>';
				echo '<td  style="text-align: center;">Rec.Time</td>';
				echo '<td style="text-align: center;">Room.No</td>';
				echo '<td style="text-align: center;">Guest Name</td>';							
				echo '<td style="text-align: center;">Pax</td>';				
				echo '<td style="text-align: center;">Total Amount</td>';				
				echo '<td style="text-align: center;">User</td>';
				echo '</tr>';
			  }
			  $debittotal=0; 
			  $credittotal=0;
			  $TotalCheckout = 0;
			  foreach ($exec3->result_array() as $rows3)
			  {		
				
				 $Amt=$rows3['Amt'];
				 $TotalCheckout = $TotalCheckout + $Amt;
				if($rows3['PayMode'])
				{				
					$PayMode=$rows3['PayMode'];
				}
				else
				{
					$PayMode='Refund';
				}

				if($rows3['PayMode']=='TO ROOM'){
					$Amt= $rows3['Amount'];
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
				echo '<td style="text-align: left;">'.$rows3['EmailId'].'</td>';
				echo '</tr>';
				$totalAdvance=$totalAdvance+$rows3['totalamount'];			
				if($rows3['PayMode']=='CASH')
				{ $CASH=$CASH+$rows3['Amount']; }
				else if($rows3['PayMode']=='CREDIT CARD')
				{ $CARD=$CARD + $rows3['Amount']; }
				else if($rows3['PayMode']== 'UPI'){
					$upi = $upi +$rows3['Amount'];
				}
				else if($rows3['PayMode']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows3['Amount']; }
				else if($rows3['PayMode']=='TO ROOM')
				{ $ROOM=$ROOM+$rows3['Amount'];}
				else{
					$CASH=$CASH+$rows3['Amt'];
				}
			  }
			  if($checkout !=0){
				echo '<tr>';
			    echo '<td style="text-align: center;" class="text-bold" colspan="7">Total Bill Amount</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($TotalCheckout,2).'</td>';
                echo '<td style="text-align: right;" class=""></td>';
			    echo '</tr>';
			  }	
			  
            }


			foreach($pay1e->result_array() as $p2){
				// echo '<pre>';
			
				    $qry3="select tpd.Paidamount as Amt, * from trans_checkout_mas tcm
				left outer join Trans_Pay_Det tpd on tcm.grpcheckoutbillid=tpd.grpcheckoutbillid 
				inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid 
			  Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
				inner join Mas_Room room on room.Room_Id=tcm.Roomid 
				left outer join mas_paymode pm on pm.PayMode_Id=tpd.paymodeid 
				inner join Trans_Checkin_mas chmas on chmas.Grcid=tcm.grcid 
			  inner join UserTable ut on ut.User_id=tcm.userid  Where tcm.checkoutno like
			 ('CHK%') and isnull(tpd.Paymodeid,0)<>18  and isnull(tcm.groupcheckout,0) = 1 and
			 isnull(tcm.cancelflag,0) <> 1 and tcm.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' 
			  and '".date('Y-m-d',strtotime($_POST['todate']))."' and isnull(tcm.settle,0) <>0 
			  and isnull(tpd.Paymodeid,0)<>4  and tpd.Paymodeid ='".$p2['PayMode_Id']."' order by tcm.checkoutno desc";

			   $exec3=$this->db->query($qry3); $totalAdvance=0;
			   $checkout= $exec3->num_rows(); $i=1;
				if($checkout !=0)
				{
				  echo '<tr style="background-color:#c9c6c6;">';	
				  echo '<td class="text-bold" colspan="9" style="text-align: center;">Group Checkout Bills - '.$p2['PayMode'].'</td>';			
				  echo '</tr>';			  
				  echo '<tr style="background-color:#c9c6c6;">';		 
				  echo '<td  style="text-align: center;">S.No</td>';
				  echo '<td  style="text-align: center;">Receipt.No</td>';
				  echo '<td  style="text-align: center;">Rec.Date</td>';
				  echo '<td  style="text-align: center;">Rec.Time</td>';
				  echo '<td style="text-align: center;">Room.No</td>';
				  echo '<td style="text-align: center;">Guest Name</td>';							
				  echo '<td style="text-align: center;">Pax</td>';				
				  echo '<td style="text-align: center;">Total Amount</td>';				
				  echo '<td style="text-align: center;">User</td>';
				  echo '</tr>';
				}
				$debittotal=0; 
				$credittotal=0;
				$TotalCheckout = 0;
				$shown_groups = ''; 
				$shown_rooms = '';
				
				foreach ($exec3->result_array() as $rows3)
				{		

					if($shown_groups == $rows3['grpcheckoutbillid'] && $shown_rooms = $rows3['RoomNo'] ) {
	
						$Amt = '0.00';
						 $PayMode = '';
   
					 } else {
				  
				   $Amt=$rows3['Amt'];
				   $TotalCheckout = $TotalCheckout + $Amt;
				  if($rows3['PayMode'])
				  {				
					  $PayMode=$rows3['PayMode'];
				  }
				  else
				  {
					  $PayMode='Refund';
				  }
  
				  if($rows3['PayMode']=='TO ROOM'){
					  $Amt= $rows3['Amount'];
				  }
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
				  echo '<td style="text-align: left;">'.$rows3['EmailId'].'</td>';
				  echo '</tr>';
				  $totalAdvance=$totalAdvance+$rows3['totalamount'];			
				  if($rows3['PayMode']=='CASH')
				  { $CASH=$CASH+$Amt; }
				  else if($rows3['PayMode']=='CREDIT CARD')
				  { $CARD=$CARD + $Amt; }
				  else if($rows3['PayMode']== 'UPI'){
					  $upi = $upi +$Amt;
				  }
				  else if($rows3['PayMode']=='NET TRANSFER')
				  { $NEFT=$NEFT+$Amt; }
				  else if($rows3['PayMode']=='TO ROOM')
				  { $ROOM=$ROOM+$Amt;}
				  else{
					  $CASH=$CASH+$Amt;
				  }

				  $shown_groups = $rows3['grpcheckoutbillid'];
				  $shown_rooms = $rows3['RoomNo'];
				}
				if($checkout !=0){
				  echo '<tr>';
				  echo '<td style="text-align: center;" class="text-bold" colspan="7">Total Bill Amount</td>';
				  echo '<td style="text-align: right;" class="">'.number_format($TotalCheckout,2).'</td>';
				  echo '<td style="text-align: right;" class=""></td>';
				  echo '</tr>';
				}	
				
			  }
             
            foreach($pay1e->result_array() as $p3){
			 $qry9="select mas.Creditno,mp.paymode as bank, det.Amount as Paidamount, mas.creditid,ut.Emailid,mas.yearprefix from trans_billpay_mas mas
			  inner join trans_billpay_det det on mas.creditid = det.Creditid
			  inner join UserTable ut on ut.User_id= mas.userid
			  inner join mas_paymode mp on mp.PayMode_Id = det.Paymodeid 
			  where mas.Creditdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and
			  '".date('Y-m-d',strtotime($_POST['todate']))."' and mp.PayMode_Id='".$p3['PayMode_Id']."'";
			  $exec3=$this->db->query($qry9); $totalAdvance=0;
			  $checkout= $exec3->num_rows(); $i=1;
			   if($checkout !=0)
			   {
				echo '<tr style="background-color:#c9c6c6;">';	
				 echo '<td class="text-bold" colspan="9" style="text-align: center;">Pending Collection - '.$p3['PayMode'].'</td>';			
				 echo '</tr>';			  
				 echo '<tr style="background-color:#c9c6c6;">';		 
				 echo '<td  style="text-align: center;">S.No</td>';
				 echo '<td  style="text-align: center;" colspan="2">Receipt No</td>';
				 echo '<td  style="text-align: center;" colspan="3">Checkout No</td>';									
				 echo '<td style="text-align: center;">Paid Amount</td>';					
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
				inner join trans_pay_det dett on dett.Checkoutid = det.checkoutid 
				inner join mas_company mc on mc.Company_Id = dett.Bankid
				inner join Mas_CompanyType mct on mct.companytype_id = mc.companytype_id 
				where Creditid='".$rows3['creditid']."' and mct.CompanyType<>'travelagent' and   isnull(mas.cancelflag,0) <> 1";
				$exec = $this->db->query($sql1);
				forEach($exec->result_array() as $row){
					$yearPrefix = $row['yearPrefix'].'/'.$row['Checkoutno'];
					$billnos .=$yearPrefix.' ';
					$companyname = $row['paymode'];
					

				}
				
				echo '<tr>';
				if($creditbillno != $rows3['Creditno']){		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;" colspan="2">'.$rows3['yearprefix'].'/'.$rows3['Creditno'].'</td>';
				echo '<td style="text-align: center;" colspan="3">'.$billnos.'</td>';
				}else{
					echo '<td  style="text-align: center;"></td>';
					echo '<td  style="text-align: center;" colspan="2"></td>';
				    echo '<td style="text-align: center;" colspan="3"></td>';
				}							
				echo '<td style="text-align: right;">'.$rows3['Paidamount'].'</td>';			
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
				 echo '<td style="text-align: center;" class="text-bold" colspan="7">Total Collection Amount</td>';
				 echo '<td style="text-align: right;">'.number_format($TotalCheckout,2).'</td>';
                 echo '<td style="text-align: right;" class=""></td>';
				 echo '</tr>';
			   }	
			 
            }




			  $check = "select * from ExtraOption";
			  $exe = $this->db->query($check);
			  foreach($exe->result_array() as $extraoption){
				  $checkwalkout = $extraoption['walkoutbillshowincashierreport'];
			  }
            

            
              foreach($pay1e->result_array() as $p4){
		     $qry7="select pdet.Amount as Amt,masc.Company as Com, * from trans_checkout_mas tcm
		  	left outer join Trans_Pay_Det tpd on tcm.Checkoutid=tpd.Checkoutid 
		  	inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid 
			Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
		  	inner join Mas_Room room on room.Room_Id=tcm.Roomid 
		  	left outer join mas_paymode pm on pm.PayMode_Id=tpd.paymodeid 
			left outer join Mas_Company masc on masc.Company_Id =  tpd.bankid
		  	inner join Trans_Checkin_mas chmas on chmas.Grcid=tcm.grcid 
			left outer join  Trans_Pay_Det pdet on pdet.Checkoutid=tcm.Checkoutid
			inner join UserTable ut on ut.User_id=tcm.userid  Where tcm.checkoutno like
		   ('CHK%') and isnull(tpd.Paymodeid,0)<>18 and isnull(tcm.groupcheckout,0)=0 and
			tcm.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."'  
			 and '".date('Y-m-d',strtotime($_POST['todate']))."'  and isnull(tcm.cancelflag,0) <> 1 and tcm.settle <>0 and 
			isnull(tpd.Paymodeid,0)=4 and isnull(pdet.Paymodeid,0)=4 and isnull(tpd.Paymodeid,0)='".$p4['PayMode_Id']."' and isnull(pdet.Paymodeid,0)='".$p4['PayMode_Id']."'   ";
			 $exec3=$this->db->query($qry7); $totalAdvance=0;
			 $checkout= $exec3->num_rows(); $i=1;
			  if($checkout !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';	
				echo '<td class="text-bold" colspan="9" style="text-align: center;">Company Checkout Bills - '.$p4['PayMode'].'</td>';			
				echo '</tr>';			  
				echo '<tr style="background-color:#c9c6c6;">';		 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt.No</td>';
				echo '<td  style="text-align: center;">Rec.Date</td>';
				echo '<td  style="text-align: center;">Rec.Time</td>';
				echo '<td style="text-align: center;">Room.No</td>';
				echo '<td style="text-align: center;">Guest Name</td>';							
				echo '<td style="text-align: center;">Pax</td>';				
				echo '<td style="text-align: center;">Total Amount</td>';				
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
					$CASH=$CASH+$rows3['Amt'];
				}
				
			  }
			  if($checkout !=0){
				echo '<tr>';
			    echo '<td style="text-align: center;" class="text-bold" colspan="7 ">Total CheckOut Bill Amount</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($TotalCheckout,2).'</td>';
                echo '<td style="text-align: right;" class=""></td>';
			    echo '</tr>';
			  }	
            }

             $check = "select * from ExtraOption";
			 $exe = $this->db->query($check);
			 foreach($exe->result_array() as $extraoption){
                 $checkwalkout = $extraoption['walkoutbillshowincashierreport'];
			 }

              foreach($pay1e->result_array() as $p5){
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
		   isnull(tcm.cancelflag,0) <> 1 and 
			tcm.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' 
			and '".date('Y-m-d',strtotime($_POST['todate']))."' and tcm.settle <>0 
			and isnull(ut.comcheckoutoptioncashierreport, 0) <>0 and isnull(tpd.Paymodeid,0)='".$p5['PayMode_Id']."' order by tcm.checkoutno  ";
			 $exec3=$this->db->query($qry8); $totalAdvance=0;
			 $checkout= $exec3->num_rows(); $i=1;
			  if($checkout !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';	
				echo '<td class="text-bold" colspan="9" style="text-align: center;">complementary Checkout Bills - '.$p5['PayMode'].'</td>';			
				echo '</tr>';			  
				echo '<tr style="background-color:#c9c6c6;">';		 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt.No</td>';
				echo '<td  style="text-align: center;">Rec.Date</td>';
				echo '<td  style="text-align: center;">Rec.Time</td>';
				echo '<td style="text-align: center;">Room.No</td>';
				echo '<td style="text-align: center;">Guest Name</td>';							
				echo '<td style="text-align: center;">Pax</td>';				
				echo '<td style="text-align: center;">Total Amount</td>';				
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
			    echo '<td style="text-align: center;" class="text-bold" colspan="7">Total CheckOut Bill Amount</td>';
			    echo '<td style="text-align: right;" class="">'.number_format($TotalCheckout,2).'</td>';
                echo '<td style="text-align: right;" class=""></td>';
			    echo '</tr>';
			  }	
			}
            }

            foreach($pay1e->result_array() as $p6){
		
			 $qry4="select mt.Title+'.'+cus.Firstname as Name,* from trans_reservecancel_mas mas
			  Inner join Trans_Reserve_mas rmas on rmas.Resid=mas.reserveid 
			  Inner join Mas_Customer cus on cus.Customer_Id=rmas.cusid
			  Inner join Mas_Title mt on mt.Titleid=cus.Titelid 
			  left outer join mas_paymode pm on pm.PayMode_Id=mas.payid 
			  inner join UserTable ut on ut.User_id=mas.userid  
			  where isnull(mas.refund,0)<>0 and isnull(advamount,0)<>0 and mas.resdate
			  between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and 
              '".date('Y-m-d',strtotime($_POST['todate']))."' and  pm.PayMode_Id='".$p6['PayMode_Id']."'";
			  $exec4=$this->db->query($qry4); $totalAdvance=0;
			  $resrefund= $exec4->num_rows(); $i=1;
			   if($resrefund !=0)
			   {
				echo '<tr style="background-color:#c9c6c6;">';	
				 echo '<td class="text-bold" colspan="9" style="text-align: center;">Reservation Refund - '.$p6['PayMode'].'</td>';			
				 echo '</tr>';			  
				 echo '<tr style="background-color:#c9c6c6;">';		 
				 echo '<td  style="text-align: center;">S.No</td>';
				 echo '<td  style="text-align: center;">Receipt.No</td>';
				 echo '<td  style="text-align: center;">Rec.Date</td>';
				 echo '<td  style="text-align: center;">Rec.Time</td>';
				 echo '<td style="text-align: center;">Res.No</td>';
				 echo '<td style="text-align: center;">Guest Name</td>';							
				 echo '<td style="text-align: center;">No.Rooms</td>';				
				 echo '<td style="text-align: center;">Refund Amount</td>';				
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
												
					echo '</tr>';				
				}
            }

			  echo '<tr>';
			  echo '<td class="text-bold" colspan="9" style="text-align: center;">&nbsp;</td>';			
			  echo '</tr>';				  
			
				echo '<td class="text-bold" colspan="7"  style="text-align: right;">GRAND TOTAL</td>';
				echo '<td colspan="1" class="text-bold" style="text-align: right;">'.number_format($CASH+$CARD+$NEFT+$upi+$creditTotal-$debitTotal,2).'</td>';
				echo '<td  colspan="1"></td>';
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
              filename: "Settlement__wise__Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("settlement__wise__Report.pdf");
                }
            });
        });
	</SCRIPT>