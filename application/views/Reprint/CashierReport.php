<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Cashier Report');
$this->pfrm->FrmHead3('Report / Cashier Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 
 <?php 	date_default_timezone_set('Asia/Kolkata');  ?>
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
<div>
		<?php

		if(@$_POST['submit'])
		{
		  ?>
		
        <table class="table table-bordered table-hover"  >         
		   <tbody>
		    <?php 
			 $i=1;
			 $norow=0; $CASH=0; $CARD=0; $NEFT=0; $ROOM=0; $REFUND=0;

			 $qry="select * from trans_receipt_mas recmas 
			 inner join mas_Room rmas on rmas.Room_id=recmas.roomid 
			 inner join trans_checkin_mas tcm on tcm.Grcid = recmas.grcid 
			 inner join Mas_Customer cs on cs.Customer_Id = recmas.customerid 
			 Left outer join Mas_Title ti on ti.Titleid=cs.Titelid
			 inner join mas_paymode pm on pm.PayMode_Id = recmas.paymodeid
			 inner join UserTable ut on ut.User_id=recmas.userid
			 where isnull(ReceiptType,'')<>'O' 
			 and isnull(cancel,0)<>1  and recmas.rptdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and '".date('Y-m-d',strtotime($_POST['todate']))."' ";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="10" class="text-bold" style="text-align: center;">Advance Collection</td>';			
				echo '</tr>';

				echo '<tr>';		 
				echo '<td  style="text-align: center;">S.No</td>';
				echo '<td  style="text-align: center;">Receipt.No</td>';
				echo '<td style="text-align: center;">Rec.Dt</td>';
				echo '<td style="text-align: center;">Rec.Time</td>';
				echo '<td style="text-align: center;">Room.No</td>';
				echo '<td style="text-align: center;">Guest Name</td>';		
				echo '<td style="text-align: center;">Pax</td>';
				echo '<td style="text-align: center;">Total Amount</td>';		
				echo '<td style="text-align: center;">Mode</td>';
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
				echo '<td  style="text-align: center;">'.$rows['Receiptno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['rptdate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows['rpttime'],11,5).'</td>';
				echo '<td style="text-align: center;">'.$rows['RoomNo'].'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].'</td>';								
				echo '<td style="text-align: center;">'.$rows['Noadults'].'</td>';
				echo '<td style="text-align: right;">'.$rows['Amount'].'</td>';				
				echo '<td style="text-align: left;">'.$rows['PayMode'].'</td>';
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
				echo '<td style="text-align: center;"></td>';								
				echo '</tr>';				
			  }

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
				echo '<td colspan="10" class="text-bold" style="text-align: center;">Reservation Advance Collection</td>';			
				echo '</tr>';

				echo '<tr>';		 
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
				echo '<td  style="text-align: center;">'.$rows1['resadno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows1['rptdate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows1['rpttime'],11,5).'</td>';
				echo '<td  style="text-align: center;">'.$rows1['ResNo'].'</td>';
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
			  }

            $qry3="select pdet.Amount as Amt, * from trans_checkout_mas tcm
		  	left outer join Trans_Pay_Det tpd on tcm.Checkoutid=tpd.Checkoutid 
		  	inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid 
			Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
		  	inner join Mas_Room room on room.Room_Id=tcm.Roomid 
		  	left outer join mas_paymode pm on pm.PayMode_Id=tpd.paymodeid 
		  	inner join Trans_Checkin_mas chmas on chmas.Grcid=tcm.grcid 
			  inner join Trans_Pay_Det pdet on pdet.Checkoutid=tcm.Checkoutid
			  inner join UserTable ut on ut.User_id=tcm.userid  Where tcm.checkoutno like
		   ('CHK%') and isnull(tpd.Paymodeid,0)<>18 and isnull(tcm.groupcheckout,0)=0 and
			tcm.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and '".date('Y-m-d',strtotime($_POST['todate']))."' and tcm.totalamount<>'0.00'  ";
			 $exec3=$this->db->query($qry3); $totalAdvance=0;
			 $checkout= $exec3->num_rows(); $i=1;
			  if($checkout !=0)
			  {
				echo '<tr>';
				echo '<td class="text-bold" colspan="10" style="text-align: center;">Checkout Bills</td>';			
				echo '</tr>';			  
				echo '<tr>';		 
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
				if($rows3['totalamount'] >=0)
				{ $credit=$rows3['totalamount'];
				  $debit=0; }
				else
				{  $credit=0;
					$debit=$rows3['totalamount']; }
				$TotalCheckout = $TotalCheckout+ $rows3['Amt'];
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i++.'</td>';
				echo '<td  style="text-align: center;">'.$rows3['Checkoutno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows3['Checkoutdate'])).'</td>';
				echo '<td style="text-align: center;">'.substr($rows3['Checkouttime'],11,5).'</td>';
				echo '<td style="text-align: center;">'.$rows3['RoomNo'].'</td>';
				echo '<td style="text-align: left;">'.$rows3['Title'].'.'.$rows3['Firstname'].'</td>';								
				echo '<td style="text-align: center;">'.$rows3['Noofpersons'].'</td>';
				echo '<td style="text-align: right;">'.$rows3['Amt'].'</td>';		
				echo '<td style="text-align: left;">'.$rows3['PayMode'].'</td>';
				echo '<td style="text-align: left;">'.$rows3['EmailId'].'</td>';
				echo '</tr>';
				$totalAdvance=$totalAdvance+$rows3['totalamount'];			
				if($rows3['PayMode']=='CASH')
				{ $CASH=$CASH+$rows3['Amount']; }
				else if($rows3['PayMode']=='CREDIT CARD')
				{ $CARD=$CARD + $rows3['Amount']; }
				else if($rows3['PayMode']=='NET TRANSFER')
				{ $NEFT=$NEFT+$rows3['Amount']; }
				else if($rows3['PayMode']=='TO ROOM')
				{ $ROOM=$ROOM+$rows3['Amount'];}
			  }
			  if($checkout !=0){
				echo '<tr>';
			    echo '<td style="text-align: center;" class="text-bold" colspan="7 ">Total CheckOut Bill Amount</td>';
			    echo '<td style="text-align: right;" class="">'.$TotalCheckout.'</td>';
			    echo '</tr>';

			  }			  

			  if($checkout !=0)
			  {
				echo '<tr>';
				echo '<td class="text-bold" colspan="5" style="text-align: center;">Total Checkout Collection</td>';				
				echo '<td style="text-align: center;"></td>';			
				echo '<td style="text-align: center;"></td>';
				echo '<td style="text-align: right;">'.number_format($totalAdvance,2).'</td>';
				echo '<td style="text-align: center;"></td>';		
				echo '<td style="text-align: center;"></td>';				
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
				 echo '<td class="text-bold" colspan="10" style="text-align: center;">Reservation Refund</td>';			
				 echo '</tr>';			  
				 echo '<tr>';		 
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
				 echo '<td  style="text-align: center;">'.$rows4['resno'].'</td>';
				 echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows4['resdate'])).'</td>';
				 echo '<td style="text-align: center;">'.substr($rows4['restime'],11,5).'</td>';
				 echo '<td  style="text-align: center;">'.$rows4['ResNo'].'</td>';
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
			  if($CASH !=0 || $CASH !='0.00') 
			  { echo '<tr>';
			  	echo '<td class="text-bold" colspan="2" style="text-align: left;"> CASH </td>';
			  	echo '<td  colspan="2" style="text-align: right;">'.number_format($CASH,2).'</td>';
			  	echo '<td  colspan="8"></td>';
			  	echo '</tr>';
			  }
			  if($CARD !=0 || $CARD !='0.00') 
			  {
			  	echo '<tr>';
			  	echo '<td class="text-bold" colspan="2" style="text-align: left;">CREDITCARD</td>';
			  	echo '<td colspan="2" style="text-align: right;">'.number_format($CARD,2).'</td>';
			  	echo '<td  colspan="8"></td>';
			  	echo '</tr>';		
			  }
			  if($NEFT !=0 || $NEFT !='0.00') 
			  {
				echo '<tr>';
				echo '<td  class="text-bold text-left" colspan="2" >NET TRANSFER</td>';
				echo '<td colspan="2" style="text-align: right;">'.number_format($NEFT,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
			  }
			  if($ROOM !=0 || $ROOM !='0.00') 
			  {
				echo '<tr>';
				echo '<td class="text-bold" colspan="2" style="text-align: left;">TOROOM</td>';
				echo '<td style="text-align: right;" colspan="2">'.number_format($ROOM,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
			  }
			  if($ROOM !=0 || $ROOM !='0.00') 
			  {
				echo '<tr>';
				echo '<td class="text-bold" colspan="2" style="text-align: left;">TOROOM</td>';
				echo '<td style="text-align: right;" colspan="2">'.number_format($ROOM,2).'</td>';
				echo '<td  colspan="8"></td>';
				echo '</tr>';
			  }
			  echo '<tr>';
			  echo '<td class="text-bold" colspan="2"  style="text-align: left;">GRAND TOTAL</td>';
			  echo '<td colspan="2" class="text-bold" style="text-align: right;">'.number_format($CASH+$CARD+$NEFT+$ROOM,2).'</td>';
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
 