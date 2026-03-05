<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Print','Checkout Reprint');
$this->pfrm->FrmHeader('Print / Checkout Reprint','CheckoutBill',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");


$Res=$this->Myclass->Hotel_Details();
	foreach($Res as $row) 
	{
		$Company=$row['Company'];
		$Address=$row['Address'];
		$Address1=$row['Address1'];
        $Citys=$row['City'];
		$Pin=$row['PinCode']; 
		$State=$row['State'];
		$Gstinn=$row['Gstinn'];
		$Phone=$row['Phone'];
		$logo=$row['logo'];
		if($row['Email']=='')
		{ $Email='';}
	    else { $Email='Email:'.$row['Email']; } 
	}

 
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
		$Actrackrate=$row['Actrackrate'];
		$UserName=$row['EmailId'];
		 $GCompany=$row['Company'];
		$GGstno=$row['Gstno'];
		$yearprefix = $row['yearPrefix'];
	}	
	                
?>

<?php 
  $cityses = "select City from mas_city where Cityid = '".$Citys."'";
  $cityqry = $this->db->query($cityses)->row_array(); 
  $native = $cityqry['City'];
  ?>
<style>
/* A4 Height Settings */
.page-a4 {
    width: 100%; /* Keep your existing width */
    min-height: 29.7cm; /* A4 height */
    height: auto;
    margin: 0 auto;
    padding: 1cm;
    background: white;
    box-sizing: border-box;
}

.page-break {
    page-break-after: always;
}

.page-container {
    margin-bottom: 0;
}

.last-page {
    page-break-after: auto;
}

.footer-content {
    margin-top: 20px;
}

@media print {
    @page {
        size: A4;
        margin: 0.5cm;
    }
    
    body {
        margin: 0;
        padding: 0;
        background: white;
    }
    
    .page-a4 {
        width: 100%;
        min-height: 29.7cm;
        height: auto;
        margin: 0;
        padding: 1cm;
        box-shadow: none;
        page-break-inside: avoid;
    }
    
    .page-break {
        page-break-after: always;
    }
    
    .no-print {
        display: none;
    }
    
    .last-page {
        page-break-after: auto;
    }
    
    .footer-content {
        margin-top: 20px;
    }
}

/* Reduce rows per page to fit A4 height */
.a4-content {
    max-height: 27.7cm; /* 29.7cm - 2cm padding */
    overflow: hidden;
}

.a4-content{
    max-height:27.7cm;
    overflow:hidden;
}

/* Compact styling for A4 height */
.compact-table {
    font-size: 12px;
    line-height: 1.2;
}

.compact-table td,
.compact-table th {
    padding: 2px 4px;
}

/* Space calculation classes */
.space-calculator {
    visibility: hidden;
    position: absolute;
    left: -9999px;
}

.footer-section {
    margin-top: 10px;
}
</style>
<?php 
$sql1="select sum(creditheadid) as totaldays from Trans_credit_entry where grcid='". $Grcid."'and creditheadid=1";
$exe=$this->db->query($sql1);
foreach ($exe->result_array() as $row1)
{
	 $totaldays=$row1['totaldays'];
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
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
     <div id="printing">
		<?php

        $allRows = array();
        $TotalCredit = 0; 
        $Totaldebit = 0;
        $rowcount = 0;

        $begin = new DateTime($checkindate);
        $end = new DateTime($Checkoutdate);  

        for($i = $begin; $i <= $end; $i->modify('+1 day')) {   
            $Daytotal = 0;
            $loopdate = $i->format("Y-m-d");

             $sql1="SELECT mr.creditordebit, ce.CreditDate, ce.CreditNo, mr.RevenueHead, ce.Amount, Ord, chNo
                   FROM Trans_Credit_Entry ce
                   INNER JOIN Mas_Revenue mr ON mr.Revenue_Id = ce.Creditheadid
                   WHERE Roomgrcid='".$Roomgrcid."' AND CreditDate='".$loopdate."'
                   UNION 
                   SELECT 'D' as creditordebit, rptdate as CreditDate, Receiptno as CreditNo, 'Advance' as RevenueHead,
                          Amount,'5' as Ord , '' as chNo
                   FROM Trans_Receipt_mas 
                   WHERE roomgrcid='".$Roomgrcid."' AND cancel=0 AND ISNULL(ReceiptType,'')='C'  AND rptdate='".$loopdate."'
                   ORDER BY Ord";

            $res1=$this->db->query($sql1);     

            $lastKey = '';
            $Daytotal = 0;
            $shownCRDate = false;  

            foreach ($res1->result_array() as $row1) {
                $key = $row1['CreditNo'] . '_' . $row1['CreditDate'];
                $Creditordebit = $row1['creditordebit'];

                $showDate = '';
                $showRef  = '';

                if ($key !== $lastKey) {
                    $showDate = date('d-m-Y', strtotime($row1['CreditDate']));
                    $showRef  = $row1['CreditNo'];
                    $lastKey = $key;
                }

                if (strpos($row1['CreditNo'], 'CR') === 0) {
                    if ($shownCRDate) { $showDate = ''; } 
                    else { $showDate = date('d-m-Y', strtotime($row1['CreditDate'])); $shownCRDate = true; }
                }

                if (strpos($row1['CreditNo'], 'REC') === 0) { $showDate = ''; }

                $RevenueHead = $row1['RevenueHead'];
                if ($row1['RevenueHead'] == 'Transfer CR') {
                    $RevenueHead .= ' (' . $row1['chNo'] . ')';
                }

                if ($Creditordebit == 'C') {
                    $Daytotal += $row1['Amount'];
                    $TotalCredit += $row1['Amount'];
                    $allRows[] = array(
                        'type' => 'transaction',
                        'date' => $showDate,
                        'ref' => $showRef,
                        'particulars' => $RevenueHead,
                        'charges' => number_format($row1['Amount'],2),
                        'credit' => '0.00',
                        'total' => '0.00'
                    );
                    $rowcount++;
                } else {
                    $Daytotal -= $row1['Amount'];
                    $Totaldebit += $row1['Amount'];
                    $allRows[] = array(
                        'type' => 'transaction',
                        'date' => $showDate,
                        'ref' => $showRef,
                        'particulars' => $RevenueHead,
                        'charges' => '0.00',
                        'credit' => number_format($row1['Amount'],2),
                        'total' => '0.00'
                    );
                    $rowcount++;
                }
            }

            if($Daytotal != 0) { 
                $allRows[] = array(
                    'type' => 'daytotal',
                    'date' => '',
                    'ref' => '',
                    'particulars' => 'Day Total',
                    'charges' => '',
                    'credit' => '',
                    'total' => number_format($Daytotal,2)
                );
                $rowcount++;
            }
        }

        // Calculate space needed for footer
        $footerHeight = 400; // Approximate height in pixels for footer content
        
        // Split into pages - adjust rows per page based on available space
        $rowsPerPageFirst = 19; // Reduced to accommodate footer
        $rowsPerPageOther = 19;
        
        $totalRows = count($allRows);
        $currentPage = 1;

        // Function to render header
        function renderHeader($Company, $logo, $Address, $Address1, $native, $Pin, $State, $Phone, $Email, $Gstinn, 
                             $Title, $gname, $RoomType, $RoomNo, $checkindate, $checkintime, $Noofpersons, 
                             $Checkoutdate, $Checkouttime, $totaldays, $Mobile, $FoodPlan, $Actrackrate, 
                             $GAddress1, $GAddress2, $city, $GCompany, $GGstno, $yearprefix, $Checkoutno) {
        ?>
        <!-- Header for each page -->
        <div id="page-header">
        <table style="border:1px solid #000; width:100%; border-collapse:collapse;">
    <thead>
        <!-- <tr>
            <th rowspan="5" style="width:20%; text-align:center; vertical-align:middle;">
                <img style="width:80%;" src="<?php  ?>" />
            </th>
            </tr> -->
            <tr>

            <th colspan="4" style="width:80%; text-align:center;">
                <h2><?php echo $Company; ?></h2>
            </th>
        </tr>

        <tr>
            <th colspan="4" style="text-align:center;">
                <p><?php echo $Address." ".$Address1; ?></p>
            </th>
        </tr>

        <tr>
            <th colspan="4" style="text-align:center;">
                <p><?php echo $native." - ".$Pin.". ".$State; ?></p>
            </th>
        </tr>

        <tr>
            <th colspan="4" style="text-align:center;">
                <p><?php echo "Phone : ". $Phone ?></p>
            </th>
        </tr>
        <tr>
            <th colspan="4" style="text-align:center;">
                <p><?php echo  $Email ?></p>
            </th>
        </tr>

        <tr>
            <th colspan="4" style="text-align:center;">
                <p><?php echo "GSTNO - ".$Gstinn; ?></p>
            </th>
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
					<td style="border-bottom:1px solid #000;width:30%"> <b>&nbsp;Room &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>&nbsp;<?php echo $RoomNo; ?></td>
    			  </tr> 
				  <tr>
    				<td style="width:40%" ><?php echo $GAddress1." , ".$GAddress2; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>&nbsp;Arr.Date &nbsp;&nbsp;:</b>&nbsp;<?php echo  date('d-m-Y', strtotime($checkindate))."-".substr($checkintime,10,6); ?></td>
					<td style="border-bottom:1px solid #000;width:30%"><b>&nbsp;Pax &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>&nbsp;<?php echo $Noofpersons; ?></td>
    			  </tr>
				  <tr>
    				<td style="width:40%"><?php echo $native; ?></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>&nbsp;Dep.Date :</b>&nbsp;<?php echo date('d-m-Y',strtotime($Checkoutdate))."-".substr($Checkouttime,10,6); ?></td>
					<td style="border-bottom:1px solid #000;width:30%"><b>&nbsp;Days &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b>&nbsp;<?php echo number_format($totaldays); ?></td>
				</tr>
				  <tr>
    				<td style="width:40%"><b><?php echo "Mobile No : ".$Mobile; ?></b></td>
    				<td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:30%"><b>&nbsp;Plan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>&nbsp;<?php echo $FoodPlan; ?></td>
					<td style="border-bottom:1px solid #000;width:30%"><b> &nbsp;Rack Tariff :</b>&nbsp;<?php echo $Actrackrate; ?></td>
    			  </tr>
				  <?php if(substr($Checkoutno,0,3) != 'WHK'){ ?>
					
				  <tr>  
				    <td style="width:50%"><?php echo $GCompany.' - '.$GGstno; ?></td>
				    <td style="border-left:1px solid #000;width:50%;text-align:center" colspan="2"><?php echo "<b>TAX INVOICE<b>" ?></td>
				  </tr>
				  <?php } ?>
				</tbody>
		</table> 
	 </div>
        <?php
        }

        // Function to render transactions table
        function renderTransactionsTable($pageRows = array(), $rowsPerPage = 30) {
        ?>
        <!-- Transactions Table -->
        <table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:100%">
          <thead>
            <tr>
              <th style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%">Date</th>
              <th style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%">Ref.No</th>
              <th style="background:#aad0ff;border-bottom:1px solid #000;border-right:1px solid #000;width:40%;text-align:center">Particulars</th>
              <th style="background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Charges</th>
              <th style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Credit</th>
              <th style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;width:10%">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $pageRowCount = 0;
            if(!empty($pageRows)) {
                foreach($pageRows as $rowData) { 

                  
                    $pageRowCount++;
            ?>
            <tr>
                <td style="text-align:center;border-right:1px solid #000;width:15%"><?= $rowData['date'] ?></td>
                <td style="text-align:center;border-right:1px solid #000;width:15%"><?= $rowData['ref'] ?></td>
                <td style="border-right:1px solid #000;width:40%"><?= $rowData['particulars'] ?></td>
                <td style="text-align:right;border-right:1px solid #000;width:10%"><?= $rowData['charges'] ?></td>
                <td style="text-align:right;border-right:1px solid #000;width:10%"><?= $rowData['credit'] ?></td>
                <td style="text-align:right;width:10%"><?= $rowData['total'] ?></td>
            </tr>
            <?php } 
            }?>
            
            <!-- Fill remaining rows to make exactly the required rows per page -->
            <?php for($i = $pageRowCount; $i < $rowsPerPage; $i++) { ?>
            <tr>
                <td style="text-align:center;border-right:1px solid #000;width:15%">&nbsp;</td>
                <td style="text-align:center;border-right:1px solid #000;width:15%">&nbsp;</td>
                <td style="border-right:1px solid #000;width:40%">&nbsp;</td>
                <td style="text-align:right;border-right:1px solid #000;width:10%">&nbsp;</td>
                <td style="text-align:right;border-right:1px solid #000;width:10%">&nbsp;</td>
                <td style="text-align:right;width:10%">&nbsp;</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php
        }

       
        function renderFooter($currentPage, $totalPages) {
        ?>
        <!-- Page number -->
        <div style="text-align: right; margin-top: 10px; padding: 5px;">
            Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?>
        </div>
        <?php
        }

        // Function to render summary section
        function renderSummarySection($TotalCredit, $Totaldebit, $Roundoff, $UserName, $PayMode, $SettledCompany, $City, $taxsummary = false, $taxData = array()) {
            $number = ($TotalCredit)-($Totaldebit);						 
            if ($number < 0) {
                $number = $number * -1;
            }
            
            $no = round($number);
            $words = array(
                0=>'zero',1=>'One',2=>'Two',3=>'Three',4=>'Four',5=>'Five',
                6=>'Six',7=>'Seven',8=>'Eight',9=>'Nine',10=>'Ten',
                11=>'Eleven',12=>'Twelve',13=>'Thirteen',14=>'Fourteen',
                15=>'Fifteen',16=>'Sixteen',17=>'Seventeen',18=>'Eighteen',
                19=>'Nineteen',20=>'Twenty',30=>'Thirty',40=>'Forty',
                50=>'Fifty',60=>'Sixty',70=>'Seventy',80=>'Eighty',90=>'Ninety'
            );
            $digits = array('', 'Thousand', 'Lakh', 'Crore');
            
            function convertNumberToWords($num, $words, $digits) {
                if ($num == 0) return 'Zero';
                $str = '';
                $i = 0;
            
                while ($num > 0) {
                    $divider = ($i == 0) ? 1000 : 100;
                    $current = $num % $divider;
                    $num = (int)($num / $divider);
            
                    $part = '';
                    $hundreds = (int)($current / 100);
                    $tensUnits = $current % 100;
            
                    if ($hundreds) $part .= $words[$hundreds] . ' Hundred ';
            
                    if ($tensUnits) {
                        if ($tensUnits < 21) $part .= $words[$tensUnits] . ' ';
                        else {
                            $part .= $words[(int)($tensUnits / 10) * 10] . ' ';
                            if ($tensUnits % 10) $part .= $words[$tensUnits % 10] . ' ';
                        }
                    }
            
                    if ($current && $i > 0) $part .= $digits[$i] . ' ';
                    $str = $part . $str;
                    $i++;
                }
            
                return trim($str);
            }
            
            $result = convertNumberToWords($no, $words, $digits);
            $net = $TotalCredit-$Totaldebit + $Roundoff;
            ?>
            
            <!-- COMPACT SUMMARY SECTION -->
            <div class="summary-section">
            <table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
            <tfoot>
                <tr>
                  <td style="width:50%"><b>Rupees :</b>  <?php echo $result  ?> Only</td>
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
                  <?php if($PayMode != '') { ?>					 
                  <td colspan="2" style="width:20%;text-align:right;"><b>By <?php echo $PayMode; ?></b></td>		
                  <?php } ?>				  
                </tr>
                <tr>
                  <td style="width:50%">Thank You !!! Safe Journey ... Kindly Visit Again .</td>
                      <td style="width:20%;text-align:right;"><b>NET AMOUNT</b></td>
                  <td style="width:10%;text-align:right;"><b><?php echo number_format($net,2); ?></b></td>					
                  <td colspan="2" style="width:10%;text-align:right;"><?php echo $SettledCompany; ?></td>						  
                </tr>
            </tfoot>						
            </table>

            <?php if($taxsummary) { ?>
            <!-- Compact TAX SUMMARY (only if exists) -->
            <table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%; margin-top: 5px;">								
               <tbody>
               <tr>
                <td colspan="7" style="text-align:center;border-bottom:1px solid #000;"><b> TAX SUMMARY </b></td>									
                </tr>
                <tr>
                    <td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%"><b>Description</b></td>
                    <td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%"><b>HSN Code</b></td>
                    <td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%"><b>Taxable Amt</b></td>
                    <td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%"><b>CGST%</b></td>
                    <td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%"><b>CGST</b></td>
                    <td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%"><b>SGST%</b></td>
                    <td style="background:#aad0ff;text-align:center;border-bottom:1px solid #000;width:15%"><b>SGST</b></td>
                </tr>
                <?php
                foreach ($taxData as $row)
                {
                ?>
                <tr>
                    <td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%">ROOM RENT</td>
                    <td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%"></td>
                    <td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:20%"><?php echo number_format ($row['Amount'],2); ?></td>
                    <td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">2.50</td>
                    <td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:15%"><?php echo number_format(($row['Amount']*6)/100,2); ?></td>
                    <td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">2.50</td>
                    <td style="text-align:center;border-bottom:1px solid #000;width:15%"><?php echo number_format(($row['Amount']*6)/100,2); ?></td>
                </tr>
                <?php 
                }
                ?>
                </tbody>						
            </table>
            <?php } ?>

            <!-- Compact Footer -->
            <div class="footer-section">
            <table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
                <tfoot>
                 <tr>
                    <td colspan="4"> We Hope you Enjoyed Your Stay and would Like to Welcome You Back</td>
                 </tr>
                 <tr>
                    <td style="width:50%;"><b>PLEASE DEPOSIT YOUR KEY ON DEPARTURE</b></td>
                    <!-- <td colspan="3" style="width:50%;">All Disputes will be settled at <php echo $City; ?> Jurisdiction Only</td> -->
                 </tr>
                 <tr>
                    <td style="width:30%;border-top:1px solid #000;"><br><br><br></td>
                    <td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;text-align:center;text-color:green;"><b>Cashier's Signature</b></td>
                    <!-- <td style="width:20%;border-top:1px solid #000;border-left:1px solid #000;text-align:center;"><b>Manager's Signature</b></td> -->
                    <td style="width:30%;border-top:1px solid #000;border-left:1px solid #000;text-align:center;text-wrap:nowrap;"><b>Guest's Signature</b></td>
                 </tr>
                </tfoot>						
            </table>
            </div>
            </div> <!-- End summary-section -->
            <?php
        }

        // Get payment details for summary
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

   
        $sql="select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce
            inner join Mas_Revenue mr on mr.Revenue_Id=ce.Creditheadid
            where Roomgrcid='".$Roomgrcid."' and mr.RevenueHead in ('ROOM RENT','Extra Bed')";
        $res=$this->db->query($sql); 
        $taxsummary= $res->num_rows();
        $taxData = $res->result_array();

        // Calculate if first page has enough space for footer
        $firstPageHasSpace = ($totalRows <= $rowsPerPageFirst);
        
        // Render pages
        if ($firstPageHasSpace) {
            // All content fits on first page with footer
            ?>
            <div class="page-container last-page">
                <?php renderHeader($Company, $logo, $Address, $Address1, $native, $Pin, $State, $Phone, $Email, $Gstinn, 
                                 $Title, $gname, $RoomType, $RoomNo, $checkindate, $checkintime, $Noofpersons, 
                                 $Checkoutdate, $Checkouttime, $totaldays, $Mobile, $FoodPlan, $Actrackrate, 
                                 $GAddress1, $GAddress2, $city, $GCompany, $GGstno, $yearprefix, $Checkoutno); ?>

                <?php renderTransactionsTable($allRows, $rowsPerPageFirst); ?>
                
                <?php renderSummarySection($TotalCredit, $Totaldebit, $Roundoff, $UserName, $PayMode, $SettledCompany, $native, $taxsummary, $taxData); ?>
                
                <?php renderFooter(1, 1); ?>
            </div>
            <?php
        } else {
            // Multiple pages needed
            $pages = array_chunk($allRows, $rowsPerPageFirst);
            $totalPages = count($pages);
            
            foreach($pages as $pageNumber => $pageRows) {
                $isLastPage = ($pageNumber == $totalPages - 1);
                ?>
                <div class="page-container <?php echo (!$isLastPage) ? 'page-break' : 'last-page'; ?>">
                    <?php renderHeader($Company, $logo, $Address, $Address1, $native, $Pin, $State, $Phone, $Email, $Gstinn, 
                                     $Title, $gname, $RoomType, $RoomNo, $checkindate, $checkintime, $Noofpersons, 
                                     $Checkoutdate, $Checkouttime, $totaldays, $Mobile, $FoodPlan, $Actrackrate, 
                                     $GAddress1, $GAddress2, $city, $GCompany, $GGstno, $yearprefix, $Checkoutno); ?>

                    <?php 
                    // Use different row count for first page vs other pages
                    $currentRowsPerPage = ($pageNumber == 0) ? $rowsPerPageFirst : $rowsPerPageOther;
                    renderTransactionsTable($pageRows, $currentRowsPerPage); 
                    ?>
                    
                    <?php if($isLastPage) { ?>
                        <?php renderSummarySection($TotalCredit, $Totaldebit, $Roundoff, $UserName, $PayMode, $SettledCompany, $City, $taxsummary, $taxData); ?>
                    <?php } ?>
                    
                    <?php renderFooter($pageNumber + 1, $totalPages); ?>
                </div>
                <?php
            }
        }
        ?>

        <!-- Print Button -->
        <!-- <div class="no-print" style="text-align: center; margin: 20px;">
            <button onclick="printDiv('printing')" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Print Bill</button>
        </div> -->
         
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
function printDiv(divId) {
    // Store scroll position
    var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
    
    // Store original content
    var originalContents = document.body.innerHTML;
    
    // Get the element to print
    var printElement = document.getElementById(divId);
    
    // Create a new div for printing to preserve page structure
    var printContainer = document.createElement('div');
    printContainer.id = 'print-container';
    
    // Add print-specific CSS with side-only margins
    var printCSS = `
        <style>
            /* Hide everything in print view */
            body * {
                visibility: hidden;
            }
            
            /* Show only the print container */
            #print-container, #print-container * {
                visibility: visible;
            }
            
            #print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                background: white;
                box-sizing: border-box;
            }
            
            /* Hide print container on screen */
            @media screen {
                #print-container {
                    display: none;
                }
            }
            
            /* Print-specific styles - SIDE MARGINS ONLY */
            @media print {
                @page {
                    margin-top: 0 !important;    /* Remove top margin */
                    margin-bottom: 0 !important; /* Remove bottom margin */
                    margin-left: 20mm !important;  /* Left margin only */
                    margin-right: 20mm !important; /* Right margin only */
                }
                
                body {
                    margin: 0 !important;
                    padding: 0 !important;
                    width: 100% !important;
                    min-height: 100vh;
                }
                
                /* Container with side padding only */
                #print-container {
                    padding: 0 10px !important; /* Left & right padding only */
                    margin: 0 auto;
                    box-sizing: border-box;
                    width: 100%;
                    min-height: 100vh;
                }
                
                /* Ensure child content has side padding only */
                #print-container > div {
                    padding: 0 10px !important; /* Left & right only */
                    box-sizing: border-box;
                    width: 100%;
                }
                
                /* Prevent horizontal overflow */
                #print-container * {
                    max-width: 100% !important;
                    box-sizing: border-box;
                }
                
                /* Special handling for tables */
                #print-container table {
                    width: 100% !important;
                    border-collapse: collapse;
                    margin-left: 0 !important;
                    margin-right: 0 !important;
                }
                
                #print-container table td,
                #print-container table th {
                    padding-left: 8px !important;
                    padding-right: 8px !important;
                }
                
                /* Ensure no horizontal scroll */
                html, body {
                    overflow-x: hidden !important;
                }
                
                /* Reset top/bottom margins for all elements */
                #print-container > *:first-child {
                    margin-top: 0 !important;
                    padding-top: 0 !important;
                }
                
                #print-container > *:last-child {
                    margin-bottom: 0 !important;
                    padding-bottom: 0 !important;
                }
            }
            
            /* Content wrapper with side-only spacing */
            .print-content-wrapper {
                padding: 0 20px !important; /* Left & right only */
                box-sizing: border-box;
                width: 100%;
            }
        </style>
    `;
    
    // Clone the element to avoid modifying original
    var elementToPrint = printElement.cloneNode(true);
    
    // Add wrapper div with side-only padding
    var wrapperDiv = document.createElement('div');
    wrapperDiv.className = 'print-content-wrapper';
    wrapperDiv.innerHTML = elementToPrint.innerHTML;
    
    // Set up the print view with wrapper
    document.body.innerHTML = printCSS + wrapperDiv.outerHTML;
    document.body.setAttribute('id', 'print-container');
    
    // Add inline styles to body - side only
    document.body.style.margin = '0';
    document.body.style.padding = '0 15px'; // Left & right only
    document.body.style.width = '100%';
    document.body.style.boxSizing = 'border-box';
    document.body.style.minHeight = '90vh';
    
    // Remove any interactive elements
    var links = document.querySelectorAll('a');
    links.forEach(function(link) {
        link.style.textDecoration = 'none';
        link.style.color = 'inherit';
        // Replace with span to completely remove URL
        var text = link.textContent;
        link.outerHTML = '<span>' + text + '</span>';
    });
    
    // Hide interactive elements
    var buttons = document.querySelectorAll('button, input[type="button"], input[type="submit"]');
    buttons.forEach(function(button) {
        button.style.display = 'none';
    });
    
    // Print after a short delay
    setTimeout(function() {
        window.print();
        
        // Restore original content
        document.body.innerHTML = originalContents;
        window.scrollTo(0, scrollPosition);
        
        // Force reflow/repaint
        document.body.style.display = 'none';
        document.body.offsetHeight;
        document.body.style.display = '';
    }, 100);
}
</SCRIPT>

