<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Print','Advance Receipt');
$this->pfrm->FrmHead4('Print / Advance Receipt',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");


$Res=$this->Myclass->Hotel_Details();
	foreach($Res as $row) 
	{
		$Company=$row['Company'];
		$Address=$row['Address'];
		$City=$row['City'];
		$Pin=$row['PinCode'];
		$State=$row['State'];
		$Phone=$row['Phone'];
		if($row['Email']=='')
		{ $Email='';}
	    else { $Email='Email:'.$row['Email']; } 
	}

    $creditamount = 0;
    $debitamount = 0;
    $credittotal = 0;
    $debittotal = 0;
 $id =$_REQUEST['id'];
?>
 <?php 	date_default_timezone_set('Asia/Kolkata');  ?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
     <div id="printing">
        <table  class="mytable" style="margin-top:20px; width=100% ">
        <tbody id="dataTable" >
		<tr id="dataTable1" >
          <td  colspan="2" style="text-align:center">
		     <h3><?php echo $Company; ?></h3>
			 <p><?php echo $Address; ?></p>
			 <p><?php echo $City.'-'.$Pin.', '.$State.'.'; ?></p>
			 <p><?php echo $Phone.' '.$Email;  ?></p>
		  </td>
		 </tr>
		<tr id="dataTable1">
		  <td  colspan="2" style="text-align:center"><h4> Daily Cash Book<h4></td>
		</tr>
		 <?php   $sql = "select * from trans_cash_book where Dailyid='".$id."'";
			$exec = $this->db->query($sql);
			foreach($exec -> result_array() as $row){
				$dailyno = $row['DailyNo'];
				$totalAmount = $row['TotalAmount'];
				$date = date('d-m-y', strtotime($row['Cashdate']));	}
                      ?>
		<tr id="dataTable1" style="width:100%;border:0px;">	
			<td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p><b>Receipt No:</b> <?php echo $dailyno ?></P></td>	   
			<td style="border:0px;border-right:solid #CDCDCD  1px;width:50%"><p><b>Receipt Date :</b> <?php echo $date?></P></td>
			
		</tr>
		</tbody>
		</table>	
        
        <table  class="mytable" style="border-right:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;width:100%">
            <tbody>
            <tr id="dataTable2" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border:solid #CDCDCD  1px;width:20%;text-align:center"><b>&nbsp;&nbsp;Head Name</b></td>
			<td style="border:0px;border:solid #CDCDCD  1px;width:20%;text-align:center"><b>&nbsp;&nbsp;Credit</b></td>
			<td style="border:0px;border:solid #CDCDCD  1px;width:20%;text-align:center"><b>&nbsp;&nbsp;Debit</b></td>
			<td style="border:0px;border:solid #CDCDCD  1px;width:20%;text-align:center"><b>&nbsp;&nbsp;Narration</b></td>
            </tr>
            <?php 
            $sql1 = "select * from trans_cash_bookdet where Dailyid='".$id."'";
            $exec = $this->db->query($sql1);
            foreach($exec->result_array() as $row1){
                if($row1['Debitorcredit']=='C'){
                    $creditamount += $row1['Amount'];
                }
                if($row1['Debitorcredit']=='D'){
                    $debitamount += $row1['Amount'];
                }
            ?>
            <tr id="dataTable2" style="width:100%;border:0px;">	
            	  	   
		    <td style="border:0px;border:solid #CDCDCD  1px;width:20%;text-align:center"><?php echo $row1['Head'];?></td>
			<td style="border:0px;border:solid #CDCDCD  1px;width:20%;text-align:left">&nbsp;&nbsp;<?php if($row1['Debitorcredit']=='C'){ $credittotal +=$row1['Amount']; echo  $row1['Amount'];}?></td>
			<td style="border:0px;border:solid #CDCDCD  1px;width:20%;text-align:left">&nbsp;&nbsp;<?php if($row1['Debitorcredit']=='D'){ $debittotal +=$row1['Amount']; echo $row1['Amount'];}?></td>
			<td style="border:0px;border:solid #CDCDCD  1px;width:20%;text-align:center"><?php echo $row1['narr'];?></td>
           
            </tr>
            <?php 
            }?>

            <tr id="dataTable2" style="width:100%;border:0px;">		  	   
		    <td style="border:0px;border:solid #CDCDCD  1px;width:20%;text-align:Left"><b>&nbsp;&nbsp;Total </b></td>
			<td style="border:0px;border:solid #CDCDCD  1px;width:20%text-align:left"><b>&nbsp;&nbsp;<?php echo number_format($credittotal,2); ?></b></td>
			<td style="border:0px;border:solid #CDCDCD  1px;width:20%text-align:left" colspan="2"><b>&nbsp;&nbsp;<?php echo number_format($debittotal,2); ?></b></td>
            </tr>
            </tbody>
        </table>
		
        <table  class="mytable" style="border-right:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;width:100%">
        <tbody id="dataTable" >

        <tr id="dataTable1" >	
            <?php  $total = $creditamount - $debitamount; ?>   
			<td style="border:0px;border-left:solid #CDCDCD  1px;width:50%">&nbsp;&nbsp;<p><b>Net Total :</b> <?php echo Number_format($total,2)?></P></td>
			
		</tr>	
        <tr id="dataTable1" >	
            <?php 
            $number = $total;						 
            if ($number < 0) {
                $number = $number * -1;
            }										
           $no = floor($number);
           $point = round($number - $no, 2) * 100;
           $hundred = null;
           $digits_1 = strlen($no);
           $i = 0;
           $str = array();
           $words = array('0' => '', '1' => 'One', '2' => 'Two',
            '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
            '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
            '13' => 'Thirteen', '14' => 'Fourteen',
            '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
            '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
            '60' => 'Sixty', '70' => 'Seventy',
            '80' => 'Eighty', '90' => 'Ninety');
           $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
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
                  
            ?>
        <td style="border:0px;border-left:solid #CDCDCD  1px;width:50%"><p><b>Rupees: </b> <?php echo $result ?>Only</P>&nbsp;&nbsp;</td>	   

        </tr>
		<tr  id="dataTable1">
		  <td  style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p> <b>&nbsp;&nbsp;Cashier Signature :</b></P></td>
		  <td  style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p> <b>&nbsp;&nbsp;Guest Signature :</b></P></td>
		</tr>
		</tbody>
		</table>	
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