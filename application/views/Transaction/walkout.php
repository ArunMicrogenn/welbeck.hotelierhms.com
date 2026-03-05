<?Php  
  $date=date("Y-m-d");
  $time= date("H:i:s");
  $Roomid=$_REQUEST['Room_id'];
  $Res=$this->Myclass->Get_Checkoutno();
  foreach($Res as $row)
  { $Checkoutno=$row['number'];  } 
  
  $Res=$this->Myclass->Get_NightAuditdate();
  foreach($Res as $row)
  { $DateofAudit=$row['DateofAudit'];  }
 
  $sq1="select EnableSplitBill,* from ExtraOption ";
  $res1=$this->db->query($sq1);
  foreach ($res1->result_array() as $row1)
  {  $EnableSplitBill=$row1['EnableSplitBill']; }

//  $sql3="Exec_Temp_Trans_credit_entry   $Roomid, '".$date."'";
//   $res3=$this->db->query($sql3);

 $sql2="Get_Checkout_Amount_Details  $Roomid";
  $res2=$this->db->query($sql2);
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

	 $city=$row2['City']; $company=$row2['company'];
	 $grandtotal=($row2['billamount']+ $row2['Tempbillamount']) - ($row2['advance']+$row2['TempDiscamt']+$row2['discamt']+$row2['Allowance'] );
  } 
  

  $Update="Update Trans_Credit_Entry set groupno='',splitbillno='' where grcid='".$grcid."' ";
  $resup=$this->db->query($Update);
  $Update1="Update Temp_Trans_Credit_Entry set groupno='',splitbillno='' where grcid='".$grcid."' ";
  $resup=$this->db->query($Update1);
  $Update2="update Trans_Roomdet_det set splitbill=0 where grcid='".$grcid."' ";
  $resup=$this->db->query($Update2);
  $Update3="update Trans_receipt_mas set groupno='',splitbillno=0 where grcid='".$grcid."' ";
  $resup=$this->db->query($Update3);


  $Walkout = "select * from Extraoption";
  $exe = $this->db->query($Walkout);
  foreach($exe->result_array() as $walk){
	 $walkoutprint = $walk['walkoutbillprint'];
  }


 ?>

<div id="splitbillopen" class="modal">
	<div class="modal-content" style="width:90%;">
		<span class="close">&times;</span>
		<body>
		<form id="BillSplitForm">
		<?php echo $walkoutprint ?>
			<input type="hidden" name="Roomgrcid" id="Roomgrcid" Value="<?php echo $Roomgrcid; ?>" />
			<input type="hidden" name="grcid" id="grcid" Value="<?php echo $grcid; ?>" />
			<input type="hidden" name="checkindate" id="checkindate" Value="<?php echo $checkindate; ?>" />
			<input type="hidden" name="outdate" id="outdate" Value="<?php echo $date; ?>" />
			<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
				<tbody>
					<tr>
						<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Date</td>
						<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Ref.No</td>
						<td style="padding-right:5px;padding-left:5px;background:#aad0ff;border-bottom:1px solid #000;border-right:1px solid #000;width:30%">Particulars</td>
						<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:13%">Charges</td>
						<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:13%">Credit</td>
						<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:14%">Total</td>
						<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:right;border-bottom:1px solid #000;width:10%">Split.No</td>
					</tr> 
					<?php
						$begin = new DateTime($checkindate);
						$end   = new DateTime( $date );							
						for($i = $begin; $i <= $end; $i->modify('+1 day'))
						{   $daytotal=0;
							$dates = $i->format("Y-m-d");
							 $sql6="select  rev.RevenueNature,rev.RevenueHead,tce.Amount,tce.CreditDate,tce.CreditNo,Ord  from Mas_Revenue rev
							Inner join Trans_credit_entry tce on tce.Creditheadid =rev.Revenue_Id
							Where tce.grcid='".$grcid."' and CreditDate='".$dates."'
							Union
							select  rev.RevenueNature,rev.RevenueHead,ttce.Amount,ttce.CreditDate,ttce.CreditNo,Ord  from Mas_Revenue rev
							Inner Join Temp_Trans_credit_entry ttce on ttce.Creditheadid =rev.Revenue_Id
							Where ttce.grcid='".$grcid."' and CreditDate='".$dates."'
							Order by Ord"; $CreditNo= ', CreditDate,Credid '; 
							$res6=$this->db->query($sql6);
							foreach ($res6->result_array() as $row6)
							{ 
								if($row6['RevenueNature']==1)
								{	$Charges=$row6['Amount'];	$Credit=0;	}
								else
								{	$Credit=$row6['Amount'];	$Charges=0;		}
								?>
								<tr>
									<td style="text-align:Center;width:10%;border-right:1px solid #000;"><?php echo date('d-m-Y', strtotime($row6['CreditDate'])); ?></td>
									<td style="padding-right:5px;padding-left:5px;text-align:center;width:10%;border-right:1px solid #000;"><?php echo $row6['CreditNo']; ?></td>
									<td style="padding-right:5px;padding-left:5px;width:30%;border-right:1px solid #000;"><?php echo $row6['RevenueHead']; ?></td>
									<td style="padding-right:5px;padding-left:5px;text-align:right; width:13%;border-right:1px solid #000;"><?php echo $Charges; ?></td>
									<td style="padding-right:5px;padding-left:5px;text-align:right; width:13%;border-right:1px solid #000;"><?php echo $Credit; ?></td>
									<td style="text-align:right; width:14%"></td>
									<td style="padding-right:2px;padding-left:2px;text-align:center;border-left:1px solid #000;width:10%">
									<?php if($CreditNo != $row6['CreditNo']) { ?>
									<input Type="text" num='1' name="<?php echo $row6['CreditNo']; ?>" id="<?php echo $row6['CreditNo']; ?>" maxlength="2" class="m-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
									<?php } ?></td>
								</tr>
								<?php 
								echo $daytotal=($daytotal+$Charges)-$Credit;						
								$CreditNo=$row6['CreditNo'];
							}
							$sql8="	select * from Trans_Receipt_mas where grcid='".$grcid."' and rptdate ='".$dates."' order by Receiptid";
							$res8=$this->db->query($sql8);
							foreach ($res8->result_array() as $row8)
							{ ?>
								<tr>
									<td style="text-align:Center;width:10%;border-right:1px solid #000;"><?php echo date('d-m-Y', strtotime($row8['rptdate'])); ?></td>
									<td style="padding-right:5px;padding-left:5px;text-align:center;width:10%;border-right:1px solid #000;"><?php echo $row8['Receiptno']; ?></td>
									<td style="padding-right:5px;padding-left:5px;width:30%;border-right:1px solid #000;"><?php echo "ADVANCE"; ?></td>
									<td style="padding-right:5px;padding-left:5px;text-align:right;width:13%;border-right:1px solid #000;"><?php echo  "0"; ?></td>
									<td style="padding-right:5px;padding-left:5px;text-align:right;width:13%;border-right:1px solid #000;"><?php echo $row8['Amount']; ?></td>
									<td style="width:14%;"></td>
									<td style="padding-right:2px;padding-left:2px;text-align:center;border-left:1px solid #000;width:10%">
									<input Type="text" num='1' name="R<?php echo $row8['Receiptid']; ?>" id="R<?php echo $row8['Receiptid']; ?>" class="m-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
								</tr>
							<?php
							$daytotal=$daytotal-$row8['Amount'];
							}
							if($daytotal !='0.00' || $daytotal !='0')
							{
							?>
							<tr>
								<td style="text-align:Center;width:10%;border-right:1px solid #000;"></td>
								<td style="padding-right:5px;padding-left:5px;width:10%;border-right:1px solid #000;">-</td>
								<td style="padding-right:5px;padding-left:5px;width:35%;border-right:1px solid #000;">Days Total</td>
								<td style="padding-right:5px;padding-left:5px;width:15%;border-right:1px solid #000;">-</td>
								<td style="padding-right:5px;padding-left:5px;width:15%;border-right:1px solid #000;">-</td>
								<td style="padding-right:5px;padding-left:5px;text-align:right;width:15%;border-right:1px solid #000;"><?php echo number_format($daytotal,2); ?></td>
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
  <div class="modal-content" style="width:80%;">
    <span class="close">&times;</span>  
	<body>	
		<div id='DivIdToPrint'>
			<table style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;width:100%">								
			<tbody>
				<tr>
					<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Date</td>
					<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;width:10%">Ref.No</td>
					<td style="padding-right:5px;padding-left:5px;background:#aad0ff;border-bottom:1px solid #000;border-right:1px solid #000;width:35%">Particulars</td>
					<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:15%">Charges</td>
					<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:right;border-bottom:1px solid #000;border-right:1px solid #000;width:15%">Credit</td>
					<td style="padding-right:5px;padding-left:5px;background:#aad0ff;text-align:right;border-bottom:1px solid #000;width:15%">Total</td>
				</tr> 
				<?php
					$begin = new DateTime($checkindate);
					$end   = new DateTime( $date );							
					for($i = $begin; $i <= $end; $i->modify('+1 day'))
					{   $daytotal=0;
						$dates = $i->format("Y-m-d");
						$sql6="select  rev.RevenueNature,rev.RevenueHead,tce.CreditDate,tce.Amount,tce.CreditNo,Ord,tce.Credid from Mas_Revenue rev
						Inner join Trans_credit_entry tce on tce.Creditheadid =rev.Revenue_Id
						Where tce.grcid='".$grcid."' and CreditDate='".$dates."' 
						Union
						select  rev.RevenueNature,rev.RevenueHead,ttce.CreditDate,ttce.Amount,ttce.CreditNo,Ord,ttce.Credid from Mas_Revenue rev
						Inner Join Temp_Trans_credit_entry ttce on ttce.Creditheadid =rev.Revenue_Id
						Where ttce.grcid='".$grcid."' and CreditDate='".$dates."'
						Order by Ord,CreditDate,Credid";
						$res6=$this->db->query($sql6);
						foreach ($res6->result_array() as $row6)
						{ 
							if($row6['RevenueNature']==1)
							{	$Charges=$row6['Amount'];	$Credit=0;	}
							else
							{	$Credit=$row6['Amount'];	$Charges=0;		}
							?>
							<tr>
								<td style="text-align:Center;width:10%;border-right:1px solid #000;"><?php echo date('d-m-Y', strtotime($row6['CreditDate'])); ?></td>
								<td style="padding-right:5px;padding-left:5px;text-align:center;width:10%;border-right:1px solid #000;"><?php echo $row6['CreditNo']; ?></td>
								<td style="padding-right:5px;padding-left:5px;width:35%;border-right:1px solid #000;"><?php echo $row6['RevenueHead']; ?></td>
								<td style="padding-right:5px;padding-left:5px;text-align:right; width:15%;border-right:1px solid #000;"><?php echo $Charges; ?></td>
								<td style="padding-right:5px;padding-left:5px;text-align:right; width:15%;border-right:1px solid #000;"><?php echo $Credit; ?></td>
								<td style="text-align:right; width:15%"></td>
							</tr>
							<?php 
							$daytotal=($daytotal+$Charges)-$Credit;						
						}
						$sql8="	select * from Trans_Receipt_mas where grcid='".$grcid."' and rptdate ='".$dates."'";
						$res8=$this->db->query($sql8);
						foreach ($res8->result_array() as $row8)
						{ ?>
							<tr>
								<td style="text-align:Center;width:10%;border-right:1px solid #000;"><?php echo date('d-m-Y', strtotime($row8['rptdate'])); ?></td>
								<td style="padding-right:5px;padding-left:5px;text-align:center;width:10%;border-right:1px solid #000;"><?php echo $row8['Receiptno']; ?></td>
								<td style="padding-right:5px;padding-left:5px;width:35%;border-right:1px solid #000;"><?php echo "ADVANCE"; ?></td>
								<td style="padding-right:5px;padding-left:5px;text-align:right;width:15%;border-right:1px solid #000;"><?php echo  "0"; ?></td>
								<td style="padding-right:5px;padding-left:5px;text-align:right;width:15%;border-right:1px solid #000;"><?php echo $row8['Amount']; ?></td>
								<td style="width:15%;"></td>
							</tr>
						<?php
						$daytotal=$daytotal-$row8['Amount'];
						}
						if($daytotal !='0.00' || $daytotal !='0')
						{
						?>
						<tr>
							<td style="text-align:Center;width:10%;border-right:1px solid #000;"></td>
							<td style="padding-right:5px;padding-left:5px;width:10%;border-right:1px solid #000;">-</td>
							<td style="padding-right:5px;padding-left:5px;width:35%;border-right:1px solid #000;">Days Total</td>
							<td style="padding-right:5px;padding-left:5px;width:15%;border-right:1px solid #000;">-</td>
							<td style="padding-right:5px;padding-left:5px;width:15%;border-right:1px solid #000;">-</td>
							<td style="padding-right:5px;padding-left:5px;text-align:right;width:15%;border-right:1px solid #000;"><?php echo number_format($daytotal,2); ?></td>
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
	<div>
	<form id="checkoutsave">
	<table class="FrmTable" style="width:100%">
	<tr>
		<td>Room No </td>
		<td><input type='text' style="background-color:#FFF59B;" Readonly class="m-ctrl" value="<?php echo $Roomno; ?>"></td>
		<td>Bill No </td>
		<td>
            <?php $sql = "select dbo.WalkoutNo() as Walkoutno";
                  $ex = $this->db->query($sql);
                  foreach($ex->result_array() as $row){
                   $Walkoutno = $row['Walkoutno'];
                  }
				  
				$sql1 = "select dbo.YearPrefix() as id ";
				$exc = $this->db->query($sql1);
				foreach($exc->result_array() as $year){
				$yearPrefix = $year['id'];
				}
            ?>
            <input type="text" class="m-ctrl" value="<?php echo  $yearPrefix.'/'.$Walkoutno; ?>" readonly style="background-color:#FFF59B;"></td>
	</tr>
	<tr>
		<td>No of Pax </td>
		<td><input type='text' style="background-color:#FFF59B;" Readonly class="m-ctrl" value="<?php echo $Noofpersons; ?>"></td>
		<td>Checkin</td>
		<td><input type="text" class="m-ctrl" value="<?php echo date("d/m/Y", strtotime($checkindate))."-".substr($checkintime,11,5);  ?>" readonly style="background-color:#FFF59B;"></td>
	</tr>
	<tr>
		<td>Guest Name</td>
		<td><input type="text" readonly class="m-ctrl" value="<?php echo $customer; ?>" style="background-color:#FFF59B;"></td>
		<td>Date & Time</td>
		<td><input type="text" readonly class='m-ctrl' value="<?php echo date("d/m/Y-H:i") ?>" style="background-color:#FFF59B;"></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><input type="text" readonly class='m-ctrl' value="<?php echo $Address1 ?>" style="background-color:#FFF59B;"></td>
		<td>Res No</td>
		<td><input type="text" readonly class="m-ctrl" value="" style="background-color:#FFF59B;"></td>
	</tr>
	<tr>
		<td>Address2</td>
		<td><input type="text" readonly class="m-ctrl" value="<?php echo $Address2 ?>" style="background-color:#FFF59B;"></td>
		<td>Company</td>
		<td><input type="text" readonly class="m-ctrl" value="<?php echo $company ?>" style="background-color:#FFF59B;"></td>
	</tr>
	<tr>
		<td>City</td>
		<td><input type="text" readonly class="m-ctrl" value="<?php echo $city ?>" style="background-color:#FFF59B;"></td>
		<td>Travel Agent</td>
		<td><input type="text" readonly class="m-ctrl" style="background-color:#FFF59B;"></td>
	</tr>
	<tr>
		<td>Bill Amount</td>
		<td><input Type="text" readonly value="<?php echo  number_format($grandtotal,2); ?>" class="m-ctrl" style="background-color:#FFF59B;"></td>
		<td><input type="Button" id="Billdetails" value="Details" class="btn btn-warning btn-sm">
		<?php if($EnableSplitBill==1){ ?>	<input type="Button" id="SplitBill" value="SplitBill" disabled class="btn btn-warning btn-sm"></td> <?php } ?>
		<td><input type="submit" value="Checkout" id="chkbtn" class="btn btn-warning btn-sm">
		<img id="loaderimg" src="../../assets/formloader.gif" width="20px" style="display:none;"/></td>
	</tr>
	</table>

		<input type="hidden" value="<?php echo $Roomid ?>" name="Room_id" value="Room_id">
	</form>
	</div>

<script>
  var modal = document.getElementById("popupopen");
  var btn = document.getElementById("Billdetails");
  var span = document.getElementsByClassName("close")[1];
  var span1 = document.getElementsByClassName("close")[0];
  var modal1 = document.getElementById("splitbillopen");

  btn.onclick = function() {
    modal.style.display = "block";
  }

  span.onclick = function() {
    modal.style.display = "none";
    modal1.style.display = "none";
  }

  span1.onclick = function() {
    modal.style.display = "none";
    modal1.style.display = "none";
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
    if (event.target == modal1) {
      modal1.style.display = "none";
    }
  }

  <?php if($EnableSplitBill == 1) { ?>
    var btn1 = document.getElementById("SplitBill");
    btn1.onclick = function() {
      modal1.style.display = "block";
    }
  <?php } ?>
  
	$("#checkoutsave").on('submit', function (e) {
			    document.getElementById("chkbtn").disabled=true;
        document.getElementById("loaderimg").style.display="inline";
       e.preventDefault();
          $.ajax({
            type: 'get',
            url: "<?php echo scs_index ?>Transaction/Walkoutsave?Roomid=<?php echo $Roomid; ?>",
            data: $('#checkoutsave').serialize(),
            success: function (result) {
				var id=result;
				 swal({ 
				  title: "Checkout Save Successfully..!",
				  text: "Did you Need Print..!",
				  icon: "success",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				
				  if (willDelete) {
					<?php if($walkoutprint == 1){
						?>
						  window.location.href ="<?php echo scs_index ?>Transaction/CheckoutReceipt?checkoutId="+id;
						 
						
						<?php } else{?>
							location.reload();
			

				   <?php } ?>}
				   else {
					location.reload();
						

				  }
				}); 
			  
			   }			
          });
          		   
    });
	$("#BillSplitForm").on('submit', function (e) {
       e.preventDefault();
        $.ajax({
    	    type: 'get',
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
