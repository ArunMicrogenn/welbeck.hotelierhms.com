<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','DayWise Settlement Report');
$this->pfrm->FrmHead6('Report / DayWise Settlement Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
?>

<?php
date_default_timezone_set('Asia/Kolkata');

$openingBal = 0;
$_openingDate = isset($_POST['frmdate']) ? date('Y-m-d', strtotime('-1 day', strtotime(preg_replace('/[^0-9\-]/', '', $_POST['frmdate'])))) : date('Y-m-d', strtotime('-1 day'));
$sql = "exec DayOpeningCash '".$_openingDate."'" ;
$res = $this->db->query($sql);
foreach($res-> result_array() as $row){
    $openingBal= $row['clbal'];
}
?>

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
<div id="printing"  class="col-sm-12" style="overflow:scroll;height:430px;">
    <?php
    if(@$_POST['submit'])
    {
        // Sanitize date inputs — strip anything that is not a digit or hyphen
        $_frmdate = date('Y-m-d', strtotime(preg_replace('/[^0-9\-]/', '', $_POST['frmdate'])));
        $_todate  = date('Y-m-d', strtotime(preg_replace('/[^0-9\-]/', '', $_POST['todate'])));

        // Get date range
        $startDate = new DateTime($_frmdate);
        $endDate = new DateTime($_todate);
        $endDate->modify('+1 day'); // Include the end date

        $dateInterval = new DateInterval('P1D');
        $datePeriod = new DatePeriod($startDate, $dateInterval, $endDate);
        
        // Store all totals
        $grandTotals = [
            'CASH' => 0,
            'CARD' => 0,
            'NEFT' => 0,
            'UPI' => 0,
            'TOROOM' => 0,
            'REFUND' => 0,
            'COMPANY' => 0,
            'TOTAL' => 0
        ];
        
        $creditTotal = 0;
        $debitTotal = 0;
        $totalRefund = 0;
    ?>        
        <table class="table table-bordered table-hover table-responsive">    
        <div>
            <h3 class="text-center">Day wise Report <?php echo date('d-m-Y', strtotime($_frmdate)); ?> To <?php echo date('d-m-Y', strtotime($_todate)); ?><h3>
        </div>     
        
        <tbody>
        <?php
        // Loop through each date
        foreach ($datePeriod as $date) {
            $currentDate = $date->format('Y-m-d');
            $displayDate = date('d-m-Y', strtotime($currentDate));
            
            // Skip if it's a future date
            if ($currentDate > date('Y-m-d')) {
                continue;
            }
            
            echo '<tr style="background:#337ab7;color:white;font-weight:bold">';
            echo '<td colspan="16">Date : '.$displayDate.'</td>';
            echo '</tr>';
            
            // Initialize daily totals
            $dailyTotals = [
                'CASH' => 0,
                'CARD' => 0,
                'NEFT' => 0,
                'UPI' => 0,
                'TOROOM' => 0,
                'REFUND' => 0,
                'COMPANY' => 0,
                'TOTAL' => 0
            ];
            
            $sectionTotals = [
                'advance' => ['TOTAL' => 0, 'CASH' => 0, 'CARD' => 0, 'NEFT' => 0, 'UPI' => 0, 'TOROOM' => 0, 'REFUND' => 0],
                'res_advance' => ['TOTAL' => 0, 'CASH' => 0, 'CARD' => 0, 'NEFT' => 0, 'UPI' => 0, 'TOROOM' => 0, 'REFUND' => 0],
                'checkout' => ['TOTAL' => 0, 'CASH' => 0, 'CARD' => 0, 'NEFT' => 0, 'UPI' => 0, 'TOROOM' => 0, 'REFUND' => 0],
                'group_checkout' => ['TOTAL' => 0, 'CASH' => 0, 'CARD' => 0, 'NEFT' => 0, 'UPI' => 0, 'TOROOM' => 0, 'REFUND' => 0],
                'company_checkout' => ['TOTAL' => 0, 'CASH' => 0, 'CARD' => 0, 'NEFT' => 0, 'UPI' => 0, 'TOROOM' => 0, 'REFUND' => 0]
            ];
            
            // 1. ADVANCE COLLECTION
            $qry = "select * from trans_receipt_mas recmas 
                   inner join mas_Room rmas on rmas.Room_id=recmas.roomid 
                   inner join trans_checkin_mas tcm on tcm.Grcid = recmas.grcid 
                   inner join Mas_Customer cs on cs.Customer_Id = recmas.customerid 
                   Left outer join Mas_Title ti on ti.Titleid=cs.Titelid
                   inner join mas_paymode pm on pm.PayMode_Id = recmas.paymodeid
                   inner join UserTable ut on ut.User_id=recmas.userid
                   where isnull(ReceiptType,'')<>'O' 
                   and isnull(cancel,0)<>1  
                   and convert(date, recmas.rptdate) = '".$currentDate."'";
            
            $exec = $this->db->query($qry);
            $advance = $exec->num_rows();
            
            if($advance != 0) {
                echo '<tr>';
                echo '<td colspan="16" class="text-bold" style="text-align: center;background-color:#e8e8e8;">Advance Collection</td>';            
                echo '</tr>';
                
                echo '<tr style="background-color:#f5f5f5">';         
                echo '<td style="text-align: center;">S.No</td>';
                echo '<td style="text-align: center;">Receipt.No</td>';
                echo '<td style="text-align: center;">Time</td>';
                echo '<td style="text-align: center;">Guest Name</td>';
                echo '<td style="text-align: center;">Total</td>';
                echo '<td style="text-align: center;">Cash</td>';
                echo '<td style="text-align: center;">Card</td>';
                echo '<td style="text-align: center;">Net</td>';
                echo '<td style="text-align: center;">To Room</td>';
                echo '<td style="text-align: center;">UPI</td>';
                echo '<td style="text-align: center;">Refund</td>';
                echo '<td style="text-align: center;">User</td>';
                echo '</tr>';
                
                $i = 1;
                $grouped = [];
                
                foreach ($exec->result_array() as $row) {
                    $rec = $row['roomgrcid'];
                    
                    if (!isset($grouped[$rec])) {
                        $grouped[$rec] = [
                            'Receiptno' => $row['Receiptno'],
                            'yearprefix'=> $row['yearprefix'],
                            'rpttime'   => $row['rpttime'],
                            'Title'     => $row['Title'],
                            'Firstname' => $row['Firstname'],
                            'EmailId'   => $row['EmailId'],
                            'Amt'    => 0,
                            'CASH'   => 0,
                            'CARD'   => 0,
                            'NEFT'   => 0,
                            'UPI'    => 0,
                            'TOROOM' => 0,
                            'REFUND' => 0,
                        ];
                    }
                    
                    $amt = (float)$row['Amount'];
                    $grouped[$rec]['Amt'] += $amt;
                    
                    switch ($row['PayMode']) {
                        case 'CASH':         $grouped[$rec]['CASH'] += $amt; break;
                        case 'CREDIT CARD':  $grouped[$rec]['CARD'] += $amt; break;
                        case 'NET TRANSFER': $grouped[$rec]['NEFT'] += $amt; break;
                        case 'UPI':          $grouped[$rec]['UPI'] += $amt; break;
                        case 'TO ROOM':      $grouped[$rec]['TOROOM'] += $amt; break;
                        default:
                            if ($amt < 0) {
                                $grouped[$rec]['REFUND'] += abs($amt);
                            }
                    }
                }
                
                foreach ($grouped as $row) {
                    echo '<tr>';
                    echo '<td align="center">'.$i++.'</td>';
                    echo '<td align="center">'.$row['yearprefix'].'/'.$row['Receiptno'].'</td>';
                    echo '<td align="center">'.substr($row['rpttime'],11,5).'</td>';
                    echo '<td>'.$row['Title'].'.'.$row['Firstname'].'</td>';
                    echo '<td align="right">'.number_format($row['Amt'],2).'</td>';
                    echo '<td align="right">'.number_format($row['CASH'],2).'</td>';
                    echo '<td align="right">'.number_format($row['CARD'],2).'</td>';
                    echo '<td align="right">'.number_format($row['NEFT'],2).'</td>';
                    echo '<td align="right">'.number_format($row['TOROOM'],2).'</td>';
                    echo '<td align="right">'.number_format($row['UPI'],2).'</td>';
                    echo '<td align="right">'.number_format($row['REFUND'],2).'</td>';
                    echo '<td>'.$row['EmailId'].'</td>';
                    echo '</tr>';
                    
                    // Add to section totals
                    $sectionTotals['advance']['TOTAL'] += $row['Amt'];
                    $sectionTotals['advance']['CASH'] += $row['CASH'];
                    $sectionTotals['advance']['CARD'] += $row['CARD'];
                    $sectionTotals['advance']['NEFT'] += $row['NEFT'];
                    $sectionTotals['advance']['UPI'] += $row['UPI'];
                    $sectionTotals['advance']['TOROOM'] += $row['TOROOM'];
                    $sectionTotals['advance']['REFUND'] += $row['REFUND'];
                }
                
                // Advance Collection Subtotal
                echo '<tr style="background-color:#e8f4f8;font-weight:bold">';
                echo '<td colspan="4" align="right">Advance Subtotal</td>';
                echo '<td align="right">'.number_format($sectionTotals['advance']['TOTAL'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['advance']['CASH'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['advance']['CARD'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['advance']['NEFT'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['advance']['TOROOM'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['advance']['UPI'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['advance']['REFUND'],2).'</td>';
                echo '<td></td>';
                echo '</tr>';
                
                echo '<tr><td colspan="16">&nbsp;</td></tr>';
            }
            
            // 2. RESERVATION ADVANCE COLLECTION
            $qry1 = "select * from trans_receipt_mas rmas
                    inner join trans_reserveadd_mas readd on readd.resaddid=rmas.Billid
                    inner join Mas_Customer cs on cs.Customer_Id = rmas.customerid
                    Left outer join Mas_Title ti on ti.Titleid=cs.Titelid
                    inner join mas_paymode pm on pm.PayMode_Id = rmas.paymodeid
                    inner join UserTable ut on ut.User_id=rmas.userid
                    where isnull(ReceiptType,'')='A'  
                    and convert(date, rmas.rptdate) = '".$currentDate."'";
            
            $exec1 = $this->db->query($qry1);
            $resadvance = $exec1->num_rows();
            
            if($resadvance != 0) {
                echo '<tr>';
                echo '<td colspan="16" class="text-bold" style="text-align: center;background-color:#e8e8e8;">Reservation Advance Collection</td>';            
                echo '</tr>';
                
                echo '<tr style="background-color:#f5f5f5">';         
                echo '<td style="text-align: center;">S.No</td>';
                echo '<td style="text-align: center;">Receipt.No</td>';
                echo '<td style="text-align: center;">Time</td>';
                echo '<td style="text-align: center;">Guest Name</td>';
                echo '<td style="text-align: center;">Total</td>';
                echo '<td style="text-align: center;">Cash</td>';
                echo '<td style="text-align: center;">Card</td>';
                echo '<td style="text-align: center;">Net</td>';
                echo '<td style="text-align: center;">To Room</td>';
                echo '<td style="text-align: center;">UPI</td>';
                echo '<td style="text-align: center;">Refund</td>';
                echo '<td style="text-align: center;">User</td>';
                echo '</tr>';
                
                $i = 1;
                $grouped = [];
                
                foreach ($exec1->result_array() as $row) {
                    $res = $row['Receiptno'];
                    
                    if (!isset($grouped[$res])) {
                        $grouped[$res] = [
                            'Receiptno' => $row['Receiptno'],
                            'yearprefix' => $row['yearprefix'],
                            'rpttime'    => $row['rpttime'],
                            'Title'      => $row['Title'],
                            'Firstname'  => $row['Firstname'],
                            'EmailId'    => $row['EmailId'],
                            'Amt'    => 0,
                            'CASH'   => 0,
                            'CARD'   => 0,
                            'NEFT'   => 0,
                            'UPI'    => 0,
                            'TOROOM' => 0,
                            'REFUND' => 0,
                        ];
                    }
                    
                    $amt = (float)$row['Amount'];
                    $grouped[$res]['Amt'] += $amt;
                    
                    switch ($row['PayMode']) {
                        case 'CASH':         $grouped[$res]['CASH'] += $amt; break;
                        case 'CREDIT CARD':  $grouped[$res]['CARD'] += $amt; break;
                        case 'NET TRANSFER': $grouped[$res]['NEFT'] += $amt; break;
                        case 'UPI':          $grouped[$res]['UPI'] += $amt; break;
                        case 'TO ROOM':      $grouped[$res]['TOROOM'] += $amt; break;
                        default:
                            if ($amt < 0) {
                                $grouped[$res]['REFUND'] += abs($amt);
                            }
                    }
                }
                
                foreach ($grouped as $row) {
                    echo '<tr>';
                    echo '<td align="center">'.$i++.'</td>';
                    echo '<td align="center">'.$row['yearprefix'].'/'.$row['Receiptno'].'</td>';
                    echo '<td align="center">'.substr($row['rpttime'],11,5).'</td>';
                    echo '<td>'.$row['Title'].'.'.$row['Firstname'].'</td>';
                    echo '<td align="right">'.number_format($row['Amt'],2).'</td>';
                    echo '<td align="right">'.number_format($row['CASH'],2).'</td>';
                    echo '<td align="right">'.number_format($row['CARD'],2).'</td>';
                    echo '<td align="right">'.number_format($row['NEFT'],2).'</td>';
                    echo '<td align="right">'.number_format($row['TOROOM'],2).'</td>';
                    echo '<td align="right">'.number_format($row['UPI'],2).'</td>';
                    echo '<td align="right">'.number_format($row['REFUND'],2).'</td>';
                    echo '<td>'.$row['EmailId'].'</td>';
                    echo '</tr>';
                    
                    // Add to section totals
                    $sectionTotals['res_advance']['TOTAL'] += $row['Amt'];
                    $sectionTotals['res_advance']['CASH'] += $row['CASH'];
                    $sectionTotals['res_advance']['CARD'] += $row['CARD'];
                    $sectionTotals['res_advance']['NEFT'] += $row['NEFT'];
                    $sectionTotals['res_advance']['UPI'] += $row['UPI'];
                    $sectionTotals['res_advance']['TOROOM'] += $row['TOROOM'];
                    $sectionTotals['res_advance']['REFUND'] += $row['REFUND'];
                }
                
                // Reservation Advance Subtotal
                echo '<tr style="background-color:#e8f4f8;font-weight:bold">';
                echo '<td colspan="4" align="right">Reservation Advance Subtotal</td>';
                echo '<td align="right">'.number_format($sectionTotals['res_advance']['TOTAL'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['res_advance']['CASH'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['res_advance']['CARD'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['res_advance']['NEFT'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['res_advance']['TOROOM'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['res_advance']['UPI'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['res_advance']['REFUND'],2).'</td>';
                echo '<td></td>';
                echo '</tr>';
                
                echo '<tr><td colspan="16">&nbsp;</td></tr>';
            }
            
            // 3. CHECKOUT BILLS (Regular)
            $qry3 = "select isnull(tpd.Paidamount,0) as Amt,(case when tpd.Paidamount< 0 then 'REFUND' else pm.paymode end) as PayMod, * from trans_checkout_mas tcm
                    left outer join Trans_Pay_Det tpd on tcm.Checkoutid=tpd.Checkoutid 
                    inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid 
                    Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
                    left outer join mas_paymode pm on pm.PayMode_Id=tpd.paymodeid 
                    inner join UserTable ut on ut.User_id=tcm.userid  
                    Where tcm.checkoutno like ('CHK%') 
                    and isnull(tpd.Paymodeid,0)<>18 
                    and isnull(tcm.groupcheckout,0) = 0 
                    and convert(date, tcm.Checkoutdate) = '".$currentDate."'
                    and tcm.settle <>0 
                    and isnull(tcm.cancelflag,0)=0
                    and isnull(tpd.Paymodeid,0)<> 4";
            
            $exec3 = $this->db->query($qry3);
            $checkout = $exec3->num_rows();
            
            if($checkout != 0) {
                echo '<tr>';
                echo '<td colspan="16" class="text-bold" style="text-align: center;background-color:#e8e8e8;">Checkout Bills</td>';            
                echo '</tr>';
                
                echo '<tr style="background-color:#f5f5f5">';         
                echo '<td style="text-align: center;">S.No</td>';
                echo '<td style="text-align: center;">Checkout No</td>';
                echo '<td style="text-align: center;">Time</td>';
                echo '<td style="text-align: center;">Guest Name</td>';
                echo '<td style="text-align: center;">Total</td>';
                echo '<td style="text-align: center;">Cash</td>';
                echo '<td style="text-align: center;">Card</td>';
                echo '<td style="text-align: center;">Net</td>';
                echo '<td style="text-align: center;">To Room</td>';
                echo '<td style="text-align: center;">UPI</td>';
                echo '<td style="text-align: center;">Refund</td>';
                echo '<td style="text-align: center;">User</td>';
                echo '</tr>';
                
                $i = 1;
                $grouped = [];
                
                foreach ($exec3->result_array() as $row) {
                    $chk = $row['Checkoutno'];
                    
                    if (!isset($grouped[$chk])) {
                        $grouped[$chk] = [
                            'Checkoutno'   => $row['Checkoutno'],
                            'yearPrefix'   => $row['yearPrefix'],
                            'Checkouttime' => $row['Checkouttime'],
                            'Title'        => $row['Title'],
                            'Firstname'    => $row['Firstname'],
                            'EmailId'      => $row['EmailId'],
                            'Amt'          => 0,
                            'CASH'         => 0,
                            'CARD'         => 0,
                            'UPI'          => 0,
                            'NEFT'         => 0,
                            'TOROOM'       => 0,
                            'REFUND'       => 0,
                        ];
                    }
                    
                    $amt = (float)$row['Amt'];
                    $grouped[$chk]['Amt'] += $amt;
                    
                    if ($row['PayMod'] == 'CASH') {
                        $grouped[$chk]['CASH'] += $amt;
                    }
                    elseif ($row['PayMod'] == 'CREDIT CARD') {
                        $grouped[$chk]['CARD'] += $amt;
                    }
                    elseif ($row['PayMod'] == 'UPI') {
                        $grouped[$chk]['UPI'] += $amt;
                    }
                    elseif ($row['PayMod'] == 'NET TRANSFER') {
                        $grouped[$chk]['NEFT'] += $amt;
                    }
                    elseif ($row['PayMod'] == 'TO ROOM') {
                        $grouped[$chk]['TOROOM'] += $amt;
                    }
                    elseif ($row['PayMod'] == 'REFUND' || $amt < 0) {
                        $grouped[$chk]['REFUND'] += abs($amt);
                    }
                }
                
                foreach ($grouped as $row) {
                    echo '<tr>';
                    echo '<td align="center">'.$i++.'</td>';
                    echo '<td align="center">'.$row['yearPrefix'].'/'.$row['Checkoutno'].'</td>';
                    echo '<td align="center">'.substr($row['Checkouttime'],11,5).'</td>';
                    echo '<td>'.$row['Title'].'.'.$row['Firstname'].'</td>';
                    echo '<td align="right">'.number_format($row['Amt'],2).'</td>';
                    echo '<td align="right">'.number_format($row['CASH'],2).'</td>';
                    echo '<td align="right">'.number_format($row['CARD'],2).'</td>';
                    echo '<td align="right">'.number_format($row['NEFT'],2).'</td>';
                    echo '<td align="right">'.number_format($row['TOROOM'],2).'</td>';
                    echo '<td align="right">'.number_format($row['UPI'],2).'</td>';
                    echo '<td align="right">'.number_format($row['REFUND'],2).'</td>';
                    echo '<td>'.$row['EmailId'].'</td>';
                    echo '</tr>';
                    
                    // Add to section totals
                    $sectionTotals['checkout']['TOTAL'] += $row['Amt'];
                    $sectionTotals['checkout']['CASH'] += $row['CASH'];
                    $sectionTotals['checkout']['CARD'] += $row['CARD'];
                    $sectionTotals['checkout']['NEFT'] += $row['NEFT'];
                    $sectionTotals['checkout']['UPI'] += $row['UPI'];
                    $sectionTotals['checkout']['TOROOM'] += $row['TOROOM'];
                    $sectionTotals['checkout']['REFUND'] += $row['REFUND'];
                }
                
                // Checkout Subtotal
                echo '<tr style="background-color:#e8f4f8;font-weight:bold">';
                echo '<td colspan="4" align="right">Checkout Subtotal</td>';
                echo '<td align="right">'.number_format($sectionTotals['checkout']['TOTAL'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['checkout']['CASH'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['checkout']['CARD'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['checkout']['NEFT'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['checkout']['TOROOM'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['checkout']['UPI'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['checkout']['REFUND'],2).'</td>';
                echo '<td></td>';
                echo '</tr>';
                
                echo '<tr><td colspan="16">&nbsp;</td></tr>';
            }
            
            // 3B. GROUP CHECKOUT BILLS
            $qry_grp = "select isnull(tpd.Paidamount,0) as Amt,(case when tpd.Paidamount< 0 then 'REFUND' else pm.paymode end) as PayMod, * from trans_checkout_mas tcm
                    left outer join Trans_Pay_Det tpd on tcm.Checkoutid=tpd.Checkoutid
                    inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid
                    Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
                    left outer join mas_paymode pm on pm.PayMode_Id=tpd.paymodeid
                    inner join UserTable ut on ut.User_id=tcm.userid
                    Where tcm.checkoutno like ('CHK%')
                    and isnull(tpd.Paymodeid,0)<>18
                    and isnull(tcm.groupcheckout,0) = 1
                    and convert(date, tcm.Checkoutdate) = '".$currentDate."'
                    and tcm.settle <>0
                    and isnull(tcm.cancelflag,0)=0
                    and isnull(tpd.Paymodeid,0)<> 4";

            $exec_grp = $this->db->query($qry_grp);
            $group_checkout = $exec_grp->num_rows();

            if($group_checkout != 0) {
                echo '<tr>';
                echo '<td colspan="16" class="text-bold" style="text-align: center;background-color:#e8e8e8;">Group Checkout Bills</td>';
                echo '</tr>';

                echo '<tr style="background-color:#f5f5f5">';
                echo '<td style="text-align: center;">S.No</td>';
                echo '<td style="text-align: center;">Checkout No</td>';
                echo '<td style="text-align: center;">Time</td>';
                echo '<td style="text-align: center;">Guest Name</td>';
                echo '<td style="text-align: center;">Total</td>';
                echo '<td style="text-align: center;">Cash</td>';
                echo '<td style="text-align: center;">Card</td>';
                echo '<td style="text-align: center;">Net</td>';
                echo '<td style="text-align: center;">To Room</td>';
                echo '<td style="text-align: center;">UPI</td>';
                echo '<td style="text-align: center;">Refund</td>';
                echo '<td style="text-align: center;">User</td>';
                echo '</tr>';

                $i = 1;
                $grouped = [];

                foreach ($exec_grp->result_array() as $row) {
                    $chk = $row['Checkoutno'];
                    if (!isset($grouped[$chk])) {
                        $grouped[$chk] = [
                            'Checkoutno'   => $row['Checkoutno'],
                            'yearPrefix'   => $row['yearPrefix'],
                            'Checkouttime' => $row['Checkouttime'],
                            'Title'        => $row['Title'],
                            'Firstname'    => $row['Firstname'],
                            'EmailId'      => $row['EmailId'],
                            'Amt'          => 0,
                            'CASH'         => 0,
                            'CARD'         => 0,
                            'UPI'          => 0,
                            'NEFT'         => 0,
                            'TOROOM'       => 0,
                            'REFUND'       => 0,
                        ];
                    }
                    $amt = (float)$row['Amt'];
                    $grouped[$chk]['Amt'] += $amt;
                    if ($row['PayMod'] == 'CASH')             { $grouped[$chk]['CASH']   += $amt; }
                    elseif ($row['PayMod'] == 'CREDIT CARD')  { $grouped[$chk]['CARD']   += $amt; }
                    elseif ($row['PayMod'] == 'UPI')          { $grouped[$chk]['UPI']    += $amt; }
                    elseif ($row['PayMod'] == 'NET TRANSFER') { $grouped[$chk]['NEFT']   += $amt; }
                    elseif ($row['PayMod'] == 'TO ROOM')      { $grouped[$chk]['TOROOM'] += $amt; }
                    elseif ($row['PayMod'] == 'REFUND' || $amt < 0) { $grouped[$chk]['REFUND'] += abs($amt); }
                }

                foreach ($grouped as $row) {
                    echo '<tr>';
                    echo '<td align="center">'.$i++.'</td>';
                    echo '<td align="center">'.$row['yearPrefix'].'/'.$row['Checkoutno'].'</td>';
                    echo '<td align="center">'.substr($row['Checkouttime'],11,5).'</td>';
                    echo '<td>'.$row['Title'].'.'.$row['Firstname'].'</td>';
                    echo '<td align="right">'.number_format($row['Amt'],2).'</td>';
                    echo '<td align="right">'.number_format($row['CASH'],2).'</td>';
                    echo '<td align="right">'.number_format($row['CARD'],2).'</td>';
                    echo '<td align="right">'.number_format($row['NEFT'],2).'</td>';
                    echo '<td align="right">'.number_format($row['TOROOM'],2).'</td>';
                    echo '<td align="right">'.number_format($row['UPI'],2).'</td>';
                    echo '<td align="right">'.number_format($row['REFUND'],2).'</td>';
                    echo '<td>'.$row['EmailId'].'</td>';
                    echo '</tr>';

                    $sectionTotals['group_checkout']['TOTAL']  += $row['Amt'];
                    $sectionTotals['group_checkout']['CASH']   += $row['CASH'];
                    $sectionTotals['group_checkout']['CARD']   += $row['CARD'];
                    $sectionTotals['group_checkout']['NEFT']   += $row['NEFT'];
                    $sectionTotals['group_checkout']['UPI']    += $row['UPI'];
                    $sectionTotals['group_checkout']['TOROOM'] += $row['TOROOM'];
                    $sectionTotals['group_checkout']['REFUND'] += $row['REFUND'];
                }

                echo '<tr style="background-color:#e8f4f8;font-weight:bold">';
                echo '<td colspan="4" align="right">Group Checkout Subtotal</td>';
                echo '<td align="right">'.number_format($sectionTotals['group_checkout']['TOTAL'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['group_checkout']['CASH'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['group_checkout']['CARD'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['group_checkout']['NEFT'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['group_checkout']['TOROOM'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['group_checkout']['UPI'],2).'</td>';
                echo '<td align="right">'.number_format($sectionTotals['group_checkout']['REFUND'],2).'</td>';
                echo '<td></td>';
                echo '</tr>';

                echo '<tr><td colspan="16">&nbsp;</td></tr>';
            }

            // 4. COMPANY CHECKOUT BILLS
            $qry7 = "select tpd.Amount as Amt,masc.Company as Com, * from trans_checkout_mas tcm
                    left outer join Trans_Pay_Det tpd on tcm.Checkoutid=tpd.Checkoutid  
                    and isnull(tpd.cancelflag,0)<>1
                    inner join Mas_Customer cus on cus.Customer_Id=tcm.customerid 
                    Left outer join Mas_Title ti on ti.Titleid=cus.Titelid
                    left outer join Mas_Company masc on masc.Company_Id = tpd.bankid
                    inner join UserTable ut on ut.User_id=tcm.userid  
                    Where tcm.checkoutno like ('CHK%') 
                    and isnull(tpd.Paymodeid,0)<>18 
                    and isnull(tcm.groupcheckout,0)=0 
                    and convert(date, tcm.Checkoutdate) = '".$currentDate."'
                    and tcm.settle <>0 
                    and isnull(tcm.cancelflag,0)=0  
                    and isnull(tpd.Paymodeid,0)=4";
            
            $exec7 = $this->db->query($qry7);
            $company_checkout = $exec7->num_rows();
            
            if($company_checkout != 0) {
                echo '<tr>';
                echo '<td colspan="16" class="text-bold" style="text-align: center;background-color:#e8e8e8;">Company Checkout Bills</td>';            
                echo '</tr>';
                
                echo '<tr style="background-color:#f5f5f5">';         
                echo '<td style="text-align: center;">S.No</td>';
                echo '<td style="text-align: center;">Checkout No</td>';
                echo '<td style="text-align: center;">Time</td>';
                echo '<td style="text-align: center;">Guest Name</td>';
                echo '<td style="text-align: center;">Total</td>';
                echo '<td style="text-align: center;">Company</td>';
                echo '<td colspan="6" style="text-align: center;">User</td>';
                echo '</tr>';
                
                $i = 1;
                foreach ($exec7->result_array() as $rows3) {
                    $Amt = $rows3['Amt'];
                    echo '<tr>';         
                    echo '<td align="center">'.$i++.'</td>';
                    echo '<td align="center">'.$rows3['yearPrefix'].'/'.$rows3['Checkoutno'].'</td>';
                    echo '<td align="center">'.substr($rows3['Checkouttime'],11,5).'</td>';
                    echo '<td>'.$rows3['Title'].'.'.$rows3['Firstname'].'</td>';                                 
                    echo '<td align="right">'.number_format($Amt,2).'</td>';     
                    echo '<td>'.$rows3['Com'].'</td>';
                    echo '<td colspan="6">'.$rows3['EmailId'].'</td>';
                    echo '</tr>';
                    
                    // Add to section totals (count as COMPANY)
                    $sectionTotals['company_checkout']['TOTAL'] += $Amt;
                    $grandTotals['COMPANY'] += $Amt;
                }
                
                // Company Checkout Subtotal
                echo '<tr style="background-color:#e8f4f8;font-weight:bold">';
                echo '<td colspan="4" align="right">Company Checkout Subtotal</td>';
                echo '<td align="right">'.number_format($sectionTotals['company_checkout']['TOTAL'],2).'</td>';
                echo '<td colspan="7">Company Amount</td>';
                echo '</tr>';
                
                echo '<tr><td colspan="16">&nbsp;</td></tr>';
            }
            
            // 5. DAILY CASH BOOK REPORT
            $qry91 = "exec cashBookReport '".$currentDate."', '".$currentDate."'";
            $qryres = $this->db->query($qry91);
            $qryno9 = $qryres->num_rows();
            
            if($qryno9 != 0) {
                echo '<tr>';
                echo '<td colspan="16" class="text-bold" style="text-align: center;background-color:#e8e8e8;">Daily Cash Book Report</td>';            
                echo '</tr>';              
                echo '<tr style="background-color:#f5f5f5">';         
                echo '<td style="text-align: center;">S.No</td>';
                echo '<td style="text-align: center;" colspan="2">Daily.No</td>';
                echo '<td style="text-align: center;" >Particular</td>';
                echo '<td style="text-align: center;" >Amount</td>';
                echo '<td style="text-align: center;" >Type</td>';                            
                echo '<td style="text-align: center;" colspan="2">User</td>';
                echo '</tr>';
                
                $i = 1;
                $dayCredit = 0;
                $dayDebit = 0;
                
                foreach ($qryres->result_array() as $rows) {
                    if ($rows['Debitorcredit'] == 'C') {
                        $creditAmount = $rows['Amount'];
                        $debitAmount = 0;
                        $dayCredit += $creditAmount;
                    } else {
                        $debitAmount = $rows['Amount'];
                        $creditAmount = 0;
                        $dayDebit += $debitAmount;
                    }
                    
                    echo '<tr>';         
                    echo '<td align="center">'.$i++.'</td>';
                    echo '<td align="center" colspan="2">'.$rows['DailyNo'].'</td>';
                    echo '<td colspan="3">'.$rows['Head'].'</td>';
                    
                    if ($rows['Debitorcredit'] == 'C') {
                        echo '<td align="right">'.number_format($creditAmount,2).'</td>';
                        echo '<td>Credit</td>';
                    } else {
                        echo '<td align="right">'.number_format($debitAmount,2).'</td>';
                        echo '<td>Debit</td>';
                    }
                    
                    echo '<td align="center" colspan="2">'.$rows['EmailId'].'</td>';
                    echo '</tr>';
                }
                
                // Cash Book Subtotal
                $totalcrdr = $dayCredit - $dayDebit;
                echo '<tr style="background-color:#e8f4f8;font-weight:bold">';
                echo '<td colspan="4" align="right">Cash Book Total</td>';
                echo '<td align="right">'.number_format($totalcrdr,2).'</td>';
                if($totalcrdr >= 0) {
                    echo '<td colspan="3">Credit Balance</td>';
                } else {
                    echo '<td colspan="3">Debit Balance</td>';
                }
                echo '<td></td>';
                echo '</tr>';
                
                // Add to grand totals
                $creditTotal += $dayCredit;
                $debitTotal += $dayDebit;
                
                echo '<tr><td colspan="16">&nbsp;</td></tr>';
            }
            
            // Calculate daily totals from all sections
            $dailyTotals['TOTAL'] = 
                $sectionTotals['advance']['TOTAL'] + 
                $sectionTotals['res_advance']['TOTAL'] + 
                $sectionTotals['checkout']['TOTAL'] + 
                $sectionTotals['group_checkout']['TOTAL'] + 
                $sectionTotals['company_checkout']['TOTAL'];
            
            $dailyTotals['CASH'] = 
                $sectionTotals['advance']['CASH'] + 
                $sectionTotals['res_advance']['CASH'] + 
                $sectionTotals['checkout']['CASH'] + 
                $sectionTotals['group_checkout']['CASH'];
            
            $dailyTotals['CARD'] = 
                $sectionTotals['advance']['CARD'] + 
                $sectionTotals['res_advance']['CARD'] + 
                $sectionTotals['checkout']['CARD'] + 
                $sectionTotals['group_checkout']['CARD'];
            
            $dailyTotals['NEFT'] = 
                $sectionTotals['advance']['NEFT'] + 
                $sectionTotals['res_advance']['NEFT'] + 
                $sectionTotals['checkout']['NEFT'] + 
                $sectionTotals['group_checkout']['NEFT'];
            
            $dailyTotals['UPI'] = 
                $sectionTotals['advance']['UPI'] + 
                $sectionTotals['res_advance']['UPI'] + 
                $sectionTotals['checkout']['UPI'] + 
                $sectionTotals['group_checkout']['UPI'];
            
            $dailyTotals['TOROOM'] = 
                $sectionTotals['advance']['TOROOM'] + 
                $sectionTotals['res_advance']['TOROOM'] + 
                $sectionTotals['checkout']['TOROOM'] + 
                $sectionTotals['group_checkout']['TOROOM'];
            
            $dailyTotals['REFUND'] = 
                $sectionTotals['advance']['REFUND'] + 
                $sectionTotals['res_advance']['REFUND'] + 
                $sectionTotals['checkout']['REFUND'] + 
                $sectionTotals['group_checkout']['REFUND'];
            
            // $dailyTotals['COMPANY'] = $sectionTotals['company_checkout']['COMPANY'];
            
            // DAILY TOTAL ROW
            echo '<tr style="background-color:#d9edf7;font-weight:bold;border-top: 2px solid #000;">';
            echo '<td colspan="4" align="right">'.$displayDate.' - Daily Total</td>';
            echo '<td align="right">'.number_format($dailyTotals['TOTAL'],2).'</td>';
            echo '<td align="right">'.number_format($dailyTotals['CASH'],2).'</td>';
            echo '<td align="right">'.number_format($dailyTotals['CARD'],2).'</td>';
            echo '<td align="right">'.number_format($dailyTotals['NEFT'],2).'</td>';
            echo '<td align="right">'.number_format($dailyTotals['TOROOM'],2).'</td>';
            echo '<td align="right">'.number_format($dailyTotals['UPI'],2).'</td>';
            echo '<td align="right">'.number_format($dailyTotals['REFUND'],2).'</td>';
            // echo '<td align="right">'.number_format($dailyTotals['COMPANY'],2).'</td>';
            echo '</tr>';

                 echo '<tr style="background-color:#f9f9f9;font-weight:bold">';
        echo '<td colspan="4" align="right">Payment Mode Breakdown</td>';
        echo '<td align="right">CASH</td>';
        echo '<td align="right">CARD</td>';
        echo '<td align="right">NEFT</td>';
        echo '<td align="right">TO ROOM</td>';
        echo '<td align="right">UPI</td>';
        echo '<td align="right">REFUND</td>';
        echo '<td align="right">COMPANY</td>';
        echo '<td></td>';
        echo '</tr>';
        
        echo '<tr style="background-color:#e8f4f8;font-weight:bold">';
        echo '<td colspan="4" align="right">Totals</td>';
        echo '<td align="right">'.number_format($dailyTotals['CASH'],2).'</td>';
        echo '<td align="right">'.number_format($dailyTotals['CARD'],2).'</td>';
        echo '<td align="right">'.number_format($dailyTotals['NEFT'],2).'</td>';
        echo '<td align="right">'.number_format($dailyTotals['TOROOM'],2).'</td>';
        echo '<td align="right">'.number_format($dailyTotals['UPI'],2).'</td>';
        echo '<td align="right">'.number_format($dailyTotals['REFUND'],2).'</td>';
        // echo '<td align="right">'.number_format($dailyTotals['COMPANY'],2).'</td>';
        echo '<td></td>';
        echo '</tr>';

            // Add to grand totals
            foreach ($dailyTotals as $key => $value) {
                $grandTotals[$key] += $value;
            }
            
            echo '<tr style="height: 20px;"><td colspan="16">&nbsp;</td></tr>';
        }
        
        // GRAND TOTALS FOR ENTIRE PERIOD
        echo '<tr style="background-color:#337ab7;color:white;font-weight:bold">';
        echo '<td colspan="16">Grand Summary - Period: ' . date('d-m-Y', strtotime($_frmdate)) . ' to ' . date('d-m-Y', strtotime($_todate)) . '</td>';
        echo '</tr>';
        
        echo '<tr style="background-color:#f9f9f9;font-weight:bold">';
        echo '<td colspan="4" align="right">Period Total Amount</td>';
        echo '<td align="right">'.number_format($grandTotals['TOTAL'],2).'</td>';
        echo '<td colspan="9"></td>';
        echo '</tr>';
        
        echo '<tr style="background-color:#f9f9f9;font-weight:bold">';
        echo '<td colspan="4" align="right">Payment Mode Breakdown</td>';
        echo '<td align="right">CASH</td>';
        echo '<td align="right">CARD</td>';
        echo '<td align="right">NEFT</td>';
        echo '<td align="right">TO ROOM</td>';
        echo '<td align="right">UPI</td>';
        echo '<td align="right">REFUND</td>';
        echo '<td align="right">COMPANY</td>';
        echo '<td></td>';
        echo '</tr>';
        
        echo '<tr style="background-color:#e8f4f8;font-weight:bold">';
        echo '<td colspan="4" align="right">Totals</td>';
        echo '<td align="right">'.number_format($grandTotals['CASH'],2).'</td>';
        echo '<td align="right">'.number_format($grandTotals['CARD'],2).'</td>';
        echo '<td align="right">'.number_format($grandTotals['NEFT'],2).'</td>';
        echo '<td align="right">'.number_format($grandTotals['TOROOM'],2).'</td>';
        echo '<td align="right">'.number_format($grandTotals['UPI'],2).'</td>';
        echo '<td align="right">'.number_format($grandTotals['REFUND'],2).'</td>';
        echo '<td align="right">'.number_format($grandTotals['COMPANY'],2).'</td>';
        echo '<td></td>';
        echo '</tr>';
        
        // CASH FLOW SUMMARY
        $cashOnHand = $grandTotals['CASH'] + $creditTotal - $debitTotal;
        $closingBalance = $openingBal + $cashOnHand + $grandTotals['CARD'] + $grandTotals['NEFT'] + $grandTotals['UPI'];
        
        // echo '<tr style="background-color:#f9f9f9;font-weight:bold;border-top: 2px solid #000;">';
        // echo '<td colspan="4" align="right">Cash Flow Summary</td>';
        // echo '<td colspan="9"></td>';
        // echo '</tr>';
        
        // echo '<tr style="background-color:#f5f5f5;">';
        // echo '<td colspan="4" align="right">Opening Balance</td>';
        // echo '<td align="right" colspan="3">'.number_format($openingBal,2).'</td>';
        // echo '<td colspan="6"></td>';
        // echo '</tr>';
        
        // echo '<tr style="background-color:#f5f5f5;">';
        // echo '<td colspan="4" align="right">Total Credit (Cash Book)</td>';
        // echo '<td align="right" colspan="3">'.number_format($creditTotal,2).'</td>';
        // echo '<td colspan="6"></td>';
        // echo '</tr>';
        
        // echo '<tr style="background-color:#f5f5f5;">';
        // echo '<td colspan="4" align="right">Total Debit (Cash Book)</td>';
        // echo '<td align="right" colspan="3">'.number_format($debitTotal,2).'</td>';
        // echo '<td colspan="6"></td>';
        // echo '</tr>';
        
        // echo '<tr style="background-color:#f5f5f5;">';
        // echo '<td colspan="4" align="right">Cash on Hand</td>';
        // echo '<td align="right" colspan="3">'.number_format($cashOnHand,2).'</td>';
        // echo '<td colspan="6"></td>';
        // echo '</tr>';
        
        // echo '<tr style="background-color:#e8f4f8;font-weight:bold;border-top: 2px solid #000;">';
        // echo '<td colspan="4" align="right">Closing Balance</td>';
        // echo '<td align="right" colspan="3">'.number_format($closingBalance,2).'</td>';
        // echo '<td colspan="6"></td>';
        // echo '</tr>';
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
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
<!-- Use newer version of html2canvas -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>

<SCRIPT language="javascript">
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        
        // Create a new window for printing
        var printWindow = window.open('', '_blank');
        
        // Get all styles
        var styles = '';
        var styleNodes = document.querySelectorAll('style, link[rel="stylesheet"]');
        styleNodes.forEach(function(node) {
            styles += node.outerHTML;
        });
        
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cashier Report</title>
                ${styles}
                <style>
                    @media print {
                        body { padding: 20px; }
                        #${divId} { 
                            overflow: visible !important; 
                            height: auto !important; 
                            max-height: none !important;
                        }
                        table { page-break-inside: auto; }
                        tr { page-break-inside: avoid; page-break-after: auto; }
                        thead { display: table-header-group; }
                        tfoot { display: table-footer-group; }
                    }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
            </html>
        `);
        
        printWindow.document.close();
        printWindow.focus();
        
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 500);
    }

    function addRow(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);
        var colCount = table.rows[0].cells.length;

        for(var i=0; i<colCount; i++) {
            var newcell = row.insertCell(i);
            newcell.innerHTML = table.rows[0].cells[i].innerHTML;
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
        } catch(e) {
            alert(e);
        }
    }

    $(function() {
        $("#exporttable").click(function(e) {
            var table = $("#printing");
            if(table && table.length) {
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "Cashier Report " + new Date().toISOString().slice(0,10) + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: false
                });
            } 
        });
    });

    // FIXED PDF EXPORT FUNCTION
    $("body").on("click", "#exportpdf", function () {
        var button = $(this);
        var element = $('#printing')[0];
        
        // Show loading state
        button.html('<i class="fa fa-spinner fa-spin"></i> Generating PDF...').prop('disabled', true);
        
        // Store original styles
        var originalStyles = {
            overflow: element.style.overflow,
            height: element.style.height,
            maxHeight: element.style.maxHeight
        };
        
        // Make element fully visible for capture
        element.style.overflow = 'visible';
        element.style.height = 'auto';
        element.style.maxHeight = 'none';
        
        // Use a timeout to ensure styles are applied
        setTimeout(function() {
            html2canvas(element, {
                scale: 2, // Higher quality
                logging: false,
                allowTaint: false,
                useCORS: true,
                backgroundColor: '#ffffff',
                windowWidth: element.scrollWidth,
                windowHeight: element.scrollHeight
            }).then(function(canvas) {
                // Restore original styles
                element.style.overflow = originalStyles.overflow;
                element.style.height = originalStyles.height;
                element.style.maxHeight = originalStyles.maxHeight;
                
                // Convert to image
                var imgData = canvas.toDataURL('image/png');
                
                // Calculate dimensions
                var imgWidth = 750; // Width in points for landscape
                var imgHeight = (canvas.height * imgWidth) / canvas.width;
                var pageHeight = 595; // A4 landscape height
                
                // Check if content needs multiple pages
                if (imgHeight > pageHeight) {
                    // Multi-page PDF
                    var docDefinition = {
                        pageSize: 'A4',
                        pageOrientation: 'landscape',
                        pageMargins: [20, 20, 20, 20],
                        content: []
                    };
                    
                    var numberOfPages = Math.ceil(imgHeight / pageHeight);
                    
                    for (var i = 0; i < numberOfPages; i++) {
                        // Create page canvas
                        var pageCanvas = document.createElement('canvas');
                        var pageContext = pageCanvas.getContext('2d');
                        
                        pageCanvas.width = canvas.width;
                        pageCanvas.height = Math.min(
                            canvas.height - (i * pageHeight * canvas.width / imgWidth),
                            pageHeight * canvas.width / imgWidth
                        );
                        
                        // Draw portion for this page
                        pageContext.drawImage(
                            canvas,
                            0, i * pageHeight * canvas.width / imgWidth,
                            canvas.width, pageCanvas.height,
                            0, 0, canvas.width, pageCanvas.height
                        );
                        
                        var pageImgData = pageCanvas.toDataURL('image/png');
                        
                        docDefinition.content.push({
                            image: pageImgData,
                            width: imgWidth,
                            height: (pageCanvas.height * imgWidth) / canvas.width,
                            pageBreak: i > 0 ? 'before' : undefined
                        });
                    }
                    
                    pdfMake.createPdf(docDefinition).download("CashierReport.pdf");
                } else {
                    // Single page PDF
                    var docDefinition = {
                        pageSize: 'A4',
                        pageOrientation: 'landscape',
                        pageMargins: [20, 20, 20, 20],
                        content: [{
                            image: imgData,
                            width: imgWidth,
                            alignment: 'center'
                        }]
                    };
                    
                    pdfMake.createPdf(docDefinition).download("CashierReport.pdf");
                }
                
                button.html('Export PDF').prop('disabled', false);
                
            }).catch(function(error) {
                console.error('Error:', error);
                alert('Error generating PDF. Please try again.');
                
                // Restore styles
                element.style.overflow = originalStyles.overflow;
                element.style.height = originalStyles.height;
                element.style.maxHeight = originalStyles.maxHeight;
                
                button.html('Export PDF').prop('disabled', false);
            });
        }, 500); // Small delay to ensure styles are applied
    });
</SCRIPT>
