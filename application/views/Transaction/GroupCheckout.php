<?Php  
  $date=date("Y-m-d");
  $time= date("H:i:s");
  $Roomid=$_REQUEST['Room_id'];
  $Res=$this->Myclass->Get_Checkoutno();
  foreach($Res as $row)
  { $Checkoutno=$row['number'];  } 

  date_default_timezone_set('Asia/Kolkata');
  
  $year = "select dbo.YearPrefix() as id";
  $res = $this->db->query($year);
  foreach($res->result_array() as $r){
	$yearPrefix= $r['id'];
  }

  $Res=$this->Myclass->Get_NightAuditdate();
  foreach($Res as $row)
  { $DateofAudit=$row['DateofAudit'];  }
 
  $sq1="select isnull(enablespilitbill,0) as En from ExtraOption ";
  $res1=$this->db->query($sq1);
  foreach ($res1->result_array() as $row1)
  {   $EnableSplitBill=$row1['En']; }

//  $sql3="Exec_Temp_Trans_credit_entry   $Roomid, '".$date."'";
//   $res3=$this->db->query($sql3);

$selqry ="select GROUPCHECKIN from room_status where Roomid = '".$Roomid."'"; 
           $sel = $this->db->query($selqry)->row_array();
            

   $sql2="Get_Checkout_Amount_Details_alter  '".$Roomid."','".$sel['GROUPCHECKIN']."'";

//    $sql2="Get_Checkout_Amount_Details  '".$Roomid."','".$sel['GROUPCHECKIN']."'";
  $res2=$this->db->query($sql2);

  $totperson = 0;
  foreach ($res2->result_array() as $row2)
  {  $Roomgrcid=$row2['roomgrcid'];
	 $grcid =$row2['grcid']; 
	 $Roomno=$row2['roomno'];
	 $checkindate=$row2['checkindate'];
	 $Noofpersons=$row2['Noofpersons'];
	 $customer=$row2['customer'];
	 $Address1=$row2['HomeAddress1'];
	 $Address2=$row2['HomeAddress2'];
	 $checkintime=$row2['checkintime'];
	 $yearPrefix = $row2['yearPrefix'];
	 $city=$row2['City']; $company=$row2['company'];
	 $grand_total=($row2['billamount']+ $row2['Tempbillamount']) - ($row2['advance']+$row2['TempDiscamt']+$row2['discamt']+$row2['Allowance'] );
     $totperson +=$Noofpersons;
  } 
  
//   $Update="Update Trans_Credit_Entry set groupno='',splitbillno='' where grcid='".$grcid."' ";
//   $resup=$this->db->query($Update);
//   $Update1="Update Temp_Trans_Credit_Entry set groupno='',splitbillno='' where grcid='".$grcid."' ";
//   $resup=$this->db->query($Update1);
//   $Update2="update Trans_Roomdet_det set splitbill=0 where grcid='".$grcid."' ";
//   $resup=$this->db->query($Update2);
//   $Update3="update Trans_receipt_mas set groupno='',splitbillno=0 where grcid='".$grcid."' ";
//   $resup=$this->db->query($Update3);

 ?>


<style>
.container {
    display: flex;
    width: 700px;
    

}

.left-section,
.right-section {
    /* flex: 0.55; */
}

/* .same-style-table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
}

.same-style-table td,
.same-style-table th {
    padding: 10px;
    border: 1px solid #ddd;
    font-size: 14px;
}

.same-style-table td:first-child {
    width: 30%;
    font-weight: bold;
} */

/* .m-ctrl {
    width: 100%;
    padding: 7px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 14px;
} */

.scrollable-table {
    max-height: 500px;
    overflow-y: auto;
    max-width:200px !important;
}

.scrollable-table th {
    position: sticky;
    top: 0;
 
    /* z-index: 10; */
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
        width: 100%;
    }
}

/* .FrmTable td,
.FrmTable input,
.FrmTable label {
    font-size: 12px !important;
    line-height: 1.2;
    font-family: Arial, sans-serif;
} */

/* Labels same width so all rows align */
/* .FrmTable td:first-child,
.FrmTable td:nth-child(3) {
    width: 22%;
    font-weight: bold;
} */

/* Small input fields */
/* .m-ctrl {
    width: 100%;
    padding: 4px 6px;
    font-size: 12px !important;
    height: 26px;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: #FFF59B;
} */

/* Table spacing small and consistent */
/* .FrmTable td {
    padding: 6px 8px !important;
    border: 1px solid #ddd;
} */

#details {
    border-collapse: collapse;   /* important to show single clean lines */
    width: 100%;
}


#details td {
    border: 1px solid ;
    /* padding: 2px;                 */
    font-size: 12px;
}
#details th{
    border: 1px solid ;
    padding: 6px;                
    font-size: 12px;
}


#Billdetails {
    height: 20px;       
    padding-top:0;
    /* padding: 5px 5px;     */

    /* line-height: 1;      */
}

.scrollable-table {
    max-height: 150px;      
    overflow-y: auto;        /* Enable vertical scroll */
    display: block;          /* Important: allow scrolling */
    border: 1px solid #ddd;
}

/* Make table fill container but allow scrolling */
.scrollable-table table {
    width: 100%;
    border-collapse: collapse;
}

/* Optional: sticky headers */
.scrollable-table th {
    position: sticky;
    top: 0;
    background: transparent;
    z-index: 10;
}



</style>

<div id="splitbillopen" class="modal">
	<div class="modal-content" style="width:60%;">
		<span class="close ">&times;</span>
		<body>
		<form id="BillSplitForm">
			<input type="hidden" name="Roomgrcid" id="Roomgrcid" Value="<?php echo $Roomgrcid; ?>" />
			<input type="hidden" name="grcid" id="grcid" Value="<?php echo $grcid; ?>" />
			<input type="hidden" name="checkindate" id="checkindate" Value="<?php echo $checkindate; ?>" />
			<input type="hidden" name="outdate" id="outdate" Value="<?php echo $date; ?>" />
			<table class="table table-borderless">								
				<tbody>
				   <tr style=" width:100%; border-top: 2px solid #333 !important; border-bottom:2px solid #333">
						<td style="width:10%">Date</td>
						<td style="width:10%">Time</td>
						<td style="width:10%">Ref.No</td>
						<td style="width:30%">Particulars</td>
						<td style="width:13%">Charges</td>
						<td style="width:13%">Credit</td>
						<td style="width:14%">Total</td>
						<td style="width:10%">Split.No</td>
					</tr> 
					<?php
						$begin = new DateTime($checkindate);
						$end   = new DateTime( $date );							
						for($i = $begin; $i <= $end; $i->modify('+1 day'))
						{   $daytotal=0;
							$dates = $i->format("Y-m-d");
							$sql6="select rev.RevenueNature,rev.RevenueHead,tce.CreditDate,tce.Amount,tce.CreditNo,Ord,tce.Creditheadid,tce.groupno,rev.creditordebit  from Mas_Revenue rev
							Inner join Trans_credit_entry tce on tce.Creditheadid =rev.Revenue_Id
							Where tce.roomgrcid='".$Roomgrcid."' and CreditDate='".$dates."'
							Union
							select rev.RevenueNature,rev.RevenueHead,ttce.CreditDate,ttce.Amount,ttce.CreditNo,Ord,ttce.Creditheadid ,ttce.groupno,rev.creditordebit from Mas_Revenue rev
							Inner Join Temp_Trans_credit_entry ttce on ttce.Creditheadid =rev.Revenue_Id
							Where ttce.roomgrcid='".$Roomgrcid."' and CreditDate='".$dates."'
							Order by CreditDate,Ord"; 
							$CreditNo= ', CreditDate,Credid '; 
							$res6=$this->db->query($sql6);
							foreach ($res6->result_array() as $row6)
							{ 
								if($row6['RevenueNature']==1)
								{	$Charges=$row6['Amount'];	$Credit=0;	}
								else
								{	$Credit=$row6['Amount'];	$Charges=0;		}
								?>
								<tr>
									<td style="text-align:Center;width:10%;"><?php echo date('d-m-Y', strtotime($row6['CreditDate'])); ?></td>
									<td style="text-align:center;width:10%;"><?php echo $row6['CreditNo']; ?></td>
									<td style="width:30%;"><?php echo $row6['RevenueHead']; ?></td>
									<td style="text-align:right; width:13%;"><?php echo $Charges; ?></td>
									<td style="text-align:right; width:13%;"><?php echo $Credit; ?></td>
									<td style="text-align:right; width:14%"></td>
									<td style="text-align:center;width:10%" class="splitid">
									<?php if($CreditNo != $row6['CreditNo']) { ?>
									<input Type="text" num='1' name="<?php echo $row6['CreditNo']; ?>" id="<?php echo $row6['CreditNo']; ?>" 
									maxlength="2" class="m-ctrl" value="<?php echo $row6['groupno']; ?>" 
									oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off">
									<input Type="hidden" class="creditordebit" value="<?php echo $row6['creditordebit']; ?>" />
									<?php } ?></td>
								</tr>
								<?php 
								$daytotal=($daytotal+$Charges)-$Credit;						
								$CreditNo=$row6['CreditNo'];
							}
							$sql8="	select * from Trans_Receipt_mas where roomgrcid='".$Roomgrcid."' and rptdate ='".$dates."'  and isnull(cancel,0) = 0 order by Receiptid";
							$res8=$this->db->query($sql8);
							foreach ($res8->result_array() as $row8)
							{ 
							
								?>
								<tr>
									<td style="text-align:Center;width:10%;"><?php echo date('d-m-Y', strtotime($row8['rptdate'])); ?></td>
									<td style="text-align:center;width:10%;"><?php echo $row8['Receiptno']; ?></td>
									<td style="width:30%;"><?php echo "ADVANCE"; ?></td>
									<td style="text-align:right;width:13%;"><?php echo  "0"; ?></td>
									<td style="text-align:right;width:13%;"><?php echo $row8['Amount']; ?></td>
									<td style="width:14%;"></td>
									<td style="text-align:center;width:10%">
										<input Type="text" num='1' name="R<?php echo $row8['Receiptid']; ?>" id="R<?php echo $row8['Receiptid']; ?>" 
										class="m-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off">
										<input Type="hidden" class="creditordebit" value="D" />
									</td>
								</tr>
							<?php
							$daytotal=$daytotal-$row8['Amount'];
							}
							if($daytotal !='0.00' || $daytotal !='0')
							{
							?>
							<tr style="border-top:2px solid #333;">
								<td style="text-align:Center;width:10%;"></td>
								<td style="width:10%;">-</td>
								<td style="width:35%;">Days Total</td>
								<td style="width:15%;">-</td>
								<td style="width:15%;">-</td>
								<td style="text-align:right;width:15%;"><?php echo number_format($daytotal,2); ?></td>
							</tr>
							<?php
							}
						}	?>
				</tbody>
    		</table>
			<div style="text-align: end; padding:5px" >
				<input type="submit" value="Split Bill Save" class="btn btn-warning btn-sm">
			</div>
		</form>
		</body>
	</div>
</div>
<div id="popupopen" class="modal">
  <!-- Modal content -->
  <div class="modal-content" style="width:60%;">
    <span class="close">&times;</span>  
	<body>	
		<div id='DivIdToPrint'>
			<table class="table table-borderless table-hover" >
			<tbody>
				<tr style=" width:100%; border-top: 2px solid #333 !important; border-bottom:2px solid #333">
					<td>Date</td>
					<td>Ref.No</td>
					<td>Particulars</td>
					<td>Charges</td>
					<td>Credit</td>
					<td>Total</td>
				</tr> 
				<?php
					$begin = new DateTime($checkindate);
					$end   = new DateTime( $date );							
					for($i = $begin; $i <= $end; $i->modify('+1 day'))
					{   $daytotal=0;
						$dates = $i->format("Y-m-d");
						$sql6="select rev.RevenueNature,rev.RevenueHead,tce.CreditDate,tce.Amount,tce.CreditNo,Ord,tce.Credid,tce.Creditheadid from Mas_Revenue rev
						inner join Trans_credit_entry tce on tce.Creditheadid =rev.Revenue_Id
						Where tce.roomgrcid='".$Roomgrcid."' and CreditDate='".$dates."' 
						Union
						select rev.RevenueNature,rev.RevenueHead,ttce.CreditDate,ttce.Amount,ttce.CreditNo,Ord,ttce.Credid,ttce.Creditheadid from Mas_Revenue rev
						inner Join Temp_Trans_credit_entry ttce on ttce.Creditheadid =rev.Revenue_Id
						Where ttce.roomgrcid='".$Roomgrcid."' and CreditDate='".$dates."'
						Order by CreditDate,Ord";
						$res6=$this->db->query($sql6);

						
					
						foreach ($res6->result_array() as $row6)
						{ 
							// print_r($row6);
							if($row6['RevenueNature']==1)
							{	$Charges=$row6['Amount'];	$Credit=0;	}
							else
							{	$Credit=$row6['Amount'];	$Charges=0;		}
							?>
							<tr  style="width:100%">
								<td style="text-align:Center;width:15%;"><?php echo date('d-m-Y', strtotime($row6['CreditDate'])); ?></td>
								<td style="text-align:center;width:10%;"><?php echo $row6['CreditNo']; ?></td>
								<td style="width:30%"><?php echo $row6['RevenueHead']; ?></td>
								<td style="text-align:right; width:15%;"><?php echo $Charges; ?></td>
								<td style="text-align:right; width:15%;"><?php echo $Credit; ?></td>
								<td style="text-align:right; width:15%"></td>
							</tr>
							<?php 
							$daytotal=($daytotal+$Charges)-$Credit;						
						}
						 $sql8="	select * from Trans_Receipt_mas trm 
						inner join trans_advancereceipt_mas tarm on tarm.receiptid = trm.Receiptid
						where tarm.receiptid='".$grcid."' and trm.rptdate ='".$dates."'";
						$res8=$this->db->query($sql8);
						foreach ($res8->result_array() as $row8)
						{ ?>
							<tr>
								<td style="text-align:Center;width:10%;"><?php echo date('d-m-Y', strtotime($row8['rptdate'])); ?></td>
								<td style="text-align:center;width:10%;"><?php echo $row8['Receiptno']; ?></td>
								<td style="width:35%;"><?php echo "ADVANCE"; ?></td>
								<td style="text-align:right;width:15%;"><?php echo  "0"; ?></td>
								<td style="text-align:right;width:15%;"><?php echo $row8['Amount']; ?></td>
								<td style="width:15%;"></td>
							</tr>
						<?php
						$daytotal=$daytotal-$row8['Amount'];
						}
						if($daytotal !='0.00' || $daytotal !='0')
						{
						?>
						<tr>
							<td style="text-align:Center;width:10%;"></td>
							<td style="width:10%;">-</td>
							<td style="width:35%;">Days Total</td>
							<td style="width:15%;">-</td>
							<td style="width:15%;">-</td>
							<td style="text-align:right;width:15%;"><?php echo number_format($daytotal,2); ?></td>
						</tr>
						<?php
						}
					}
				?>
			</tbody>
			</table>
		</div>	 
	<body>		 
  </div>
</div>



<div class="container">

    <!-- LEFT SECTION -->
    <div class="left-section">
        <form id="checkoutsave">
            <table class="FrmTable same-style-table">

                <tr>
                    <td>Bill No</td>
                    <td>
                        <input type="text" class="m-ctrl"
                            value="<?php echo $yearPrefix.'/'.$Checkoutno; ?>" 
                            readonly style="background-color:#FFF59B;">
                    </td>
                    <td>No of Pax</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly
                            style="background-color:#FFF59B;"
                            value="<?php echo $totperson; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Checkin</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly
                            style="background-color:#FFF59B;"
                            value="<?php echo date("d/m/Y", strtotime($checkindate)).'-'.substr($checkintime,11,5); ?>">
                    </td>
                    <td>Guest Name</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly
                            value="<?php echo $customer; ?>"
                            style="background-color:#FFF59B;">
                    </td>
                </tr>

                <tr>
                    <td>Date & Time</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly
                            value="<?php echo date("d/m/Y-H:i") ?>"
                            style="background-color:#FFF59B;">
                    </td>
                    <td>Address</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly
                            value="<?php echo $Address1; ?>"
                            style="background-color:#FFF59B;">
                    </td>
                </tr>

                <tr>
                    <td>Res No</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly style="background-color:#FFF59B;">
                    </td>
                    <td>Address2</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly
                            value="<?php echo $Address2; ?>"
                            style="background-color:#FFF59B;">
                    </td>
                </tr>

                <tr>
                    <td>Company</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly
                            value="<?php echo $company; ?>"
                            style="background-color:#FFF59B;">
                    </td>
                    <td>City</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly
                            value="<?php echo $city; ?>"
                            style="background-color:#FFF59B;">
                    </td>
                </tr>

                <tr>
                    <td>Travel Agent</td>
                    <td>
                        <input type="text" class="m-ctrl" readonly style="background-color:#FFF59B;">
                    </td>
                    <td>Bill Amount</td>
                    <td>
                    <?php $selqry ="select GROUPCHECKIN from room_status where Roomid = '".$Roomid."'"; 
           $sel = $this->db->query($selqry)->row_array();
            

   $romqry="Get_Checkout_Amount_Details_alter  '".$Roomid."','".$sel['GROUPCHECKIN']."'";

        
        $rom = $this->db->query($romqry)->result_array();
        $grand = 0;
foreach($rom as $room) {  

 	 $grand_total=($room['billamount']+ $room['Tempbillamount']) - ($room['advance']+$room['TempDiscamt']+$room['discamt']+$room['Allowance'] ); 
         $grand += $grand_total;

}
           
           ?>
                    <input type="text" id="hid_grandtotal"  readonly value="<?php echo round($grand); ?>">

                    </td>
                </tr>

                <tr>
                    <td>
                        <?php if($EnableSplitBill == 1): ?>
                            <input type="button" id="SplitBill" value="SplitBill"
                                class="btn btn-warning btn-sm">
                        <?php endif; ?>
                    </td>
                    <td colspan="3">
                        <input type="button" id="chkbtn" value="Checkout"
                            class="btn btn-warning btn-sm">
                        <img id="loaderimg" src="../../assets/formloader.gif" width="20"
                            style="display:none;">
                    </td>
                </tr>

            </table>
            <input type="hidden" value="<?php echo $Roomid ?>" name="Room_id" value="Room_id">
        </form>
    </div>


    <div class="right-section">


        <div class="scrollable-table">
            <form id="checkoutsave1">
                <table class="FrmTable same-style-table" id="details">
           <?php $selqry ="select GROUPCHECKIN from room_status where Roomid = '".$Roomid."'"; 
           $sel = $this->db->query($selqry)->row_array();
            

   $romqry="Get_Checkout_Amount_Details_alter  '".$Roomid."','".$sel['GROUPCHECKIN']."'";

        
        $rom = $this->db->query($romqry)->result_array();
           
           ?>

                    <thead>
                        <tr>
                    
                            <th style="text-align:center;background: #FFFAA0;">Room No</th>
                       
                            <th style="text-align:center;background: #FFFAA0;">Bill Amount</th>
                        
                        </tr>
                    </thead>

                    <tbody>


<?php 


$grand = 0;
foreach($rom as $room) {  

 	 $grand_total=($room['billamount']+ $room['Tempbillamount']) - ($room['advance']+$room['TempDiscamt']+$room['discamt']+$room['Allowance'] ); 
      
?>
                        <tr>
                         
                        <td style="text-align:center">
        <input type="hidden" name="Room_id[]" value="<?php echo $room['Room_id']; ?>">
        <?php echo $room['RoomNo']; ?>
    </td>
                         
                            <td style="text-align:center"><?php echo $grand_total ?></td>
                            <!-- <td style="text-align:center">
                                <input type="button" id="Billdetails" value="D" 
                                    class="btn btn-warning btn-sm">
                            </td> -->
                        </tr>
                        <?php } ?>
                       
                    </tbody>

                </table>
            </form>
        </div>
    </div>

  
</div>


<script>
var modal = document.getElementById("popupopen");
var btn = document.getElementById("Billdetails");
// var span = document.getElementsByClassName("close")[1];
// var span1 = document.getElementsByClassName("close")[0];
var span = document.querySelector("#splitbillopen .close");
var span1 = document.querySelector("#popupopen .close");
var modal1 = document.getElementById("splitbillopen");

<?php if($EnableSplitBill==1){ ?> 
	var btn1 = document.getElementById("SplitBill"); 
	btn1.onclick = function() {
  modal1.style.display = "block";
}
	<?php } ?>

//const grandtotalConst = Number(document.getElementById("hid_grandtotal").value);

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
  modal1.style.display = "none";
}
span1.onclick = function() 
{  modal.style.display = "none";
  modal1.style.display = "none"; }
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";	
  }
  if (event.target == modal1) {
	modal1.style.display = "none";
  }
}


	$("#BillSplitForm").on('submit', function (e) {
        e.preventDefault(); 
        const allRows = document.querySelectorAll("#BillSplitForm tbody tr");
        let creditValues = [];
        let isValid = true;
        let missedEntry = true;
        let InvalidEntry = true;
        let values = [];
        let totalAmount = 0;

    allRows.forEach(row => {
        const creditOrDebit = row.querySelector(".creditordebit");
        const inputField = row.querySelector("input[type='text']");

        if (!creditOrDebit || !inputField) return;

        const value = inputField.value.trim();

        if (value === "") {
            missedEntry = false;
            return;
        }

        if (creditOrDebit.value === "C") {
            if (!/^\d+$/.test(value)) {
                InvalidEntry = false;
                return;
            }
            creditValues.push(value);
        }
    });

    allRows.forEach(row => {
        const creditOrDebit = row.querySelector(".creditordebit");
        const inputField = row.querySelector("input[type='text']");

        if (!creditOrDebit || !inputField) return;

        const value = inputField.value.trim();

        if (creditOrDebit.value === "D") {
            if (!creditValues.includes(value)) {
                values.push(value);
                isValid = false;
            }
        }
    });

	if (!missedEntry) {
        swal("Missing Entry", "All split number fields are mandatory.", "warning");
        return false; 
    }
	else if (!InvalidEntry) {
        swal("Invalid Entry", "Invalid input for split number entry", "warning");
        return false; 
    }
	else if (!isValid) {
        if (values.length > 0) {
            swal("Invalid Entry", "Debit split number(s): " + values.join(", ") + " not linked to any Credit split number", "warning");
        }
        return false; 
    }


        $.ajax({
    	    type: 'POST',
            url: "<?php echo scs_index ?>Transaction/tempBillSplitform?Roomid=<?php echo $Roomid; ?>",
            data: $('#BillSplitForm').serialize(),
            success: function (result) {
				var id=result;
				if (id=='Success')
				{
				swal("Success...!", "BillSplit Save Successfully...!", "success");	
				modal1.style.display = "none";	
				}
				else
				{
				  swal("Please Enter the Same Groupno", "Enter the Same groupno for Debit and Credit Amount", "warning");	
			  	  modal1.style.display = "none";	
				}
			}			
        });          		   
    });
</script>


<script>
    $("#chkbtn").on('click', function (e) {

	
let text1 ="";
let id = 0;
document.getElementById("chkbtn").disabled=true;
document.getElementById("loaderimg").style.display="inline";

let data = $('#checkoutsave, #checkoutsave1').serialize();


e.preventDefault();

    $.ajax({
    type: 'POST',
    url: "<?php echo scs_index ?>Transaction/groupcheckoutsave",
    data: data,
    
    success: function (result) {
        
//    console.log(result);
            id=result;
   


        if(Number(document.getElementById("hid_grandtotal").value) < 0){
                text1 = "Do youwant to post it another room";
        }else{
            text1 = "Do you want print out?..";
        }					
    
            swal({ 
            title: "Checkout Saved Succesfully!..",
            text: text1,
            icon: "success",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            
            if (willDelete) {

            
            window.location.href ="<?php echo scs_index ?>Reprint/GroupCheckoutReprint?Checkoutid="+id;
             

        }
            else {
            if(Number(document.getElementById("hid_grandtotal").value) < 0){
                $.ajax({
                    type:"POST",
                    url: "<?php echo scs_index ?>Transaction/refundupdate",
                    data: "id="+id,
                    success:function (result){ 
                        if(result == "success"){	
                            window.location.href ="<?php echo scs_index ?>Transaction/CheckoutReceipt?grcid="+id;
                        }
                    }
                })
            }
            else
            {
            location.reload();	
            }
            
            }
        }); 
    }			
    });
                 
});

</script>
