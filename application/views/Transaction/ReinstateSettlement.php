<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->nightaudit();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Transaction', 'ReinstateSettlement');
$this->pfrm->FrmHead3('Transaction/ ReinstateSettlement', $F_Class . "/" . $F_Ctrl . "/" . $ID, $F_Class . "/" . $F_Ctrl . "_View");


?>

<?php
 $qury = "select * from usertable where User_id='" . User_id . "' ";
$op = $this->db->query($qury);
foreach ($op->result_array() as $row) {
	$percent = $row['disper'];
	$disamount = $row['disAmount'];
}
?>


<div class="col-sm-12">
	<div class="the-box F_ram">
		<fieldset>

		</fieldset>
	</div>
	<div class="the-box D_IS"></div>
</div>
<div>

	<table class="table table-bordered table-hover">
		<tbody>
			<?php
			$i = 1;
			$fromdate = date('Y-m-d');
			   $qry = "select mas.checkoutno, mas.checkoutdate,mas.yearprefix, mr.roomno,mrt.RoomType,
             mt.Title+'.'+mc.Firstname+' '+mc.Lastname as Guestname,isnull(mcom.company,' ') as company,
             mas.checkoutid,pdet.Amount,mp.paymode,mb.bank, isnull(mcc.company, '') as paidcompany, mas.Roomgrcid, mas.grcid, mas.Roomid from trans_checkout_mas mas 
             inner join room_status rs on mas.Roomid=rs.roomid
             inner join mas_room mr on mr.Room_Id = rs.Roomid 
             inner join mas_roomType mrt on mrt.RoomType_Id= mr.RoomType_Id 
             inner join mas_customer mc on mc.Customer_Id = mas.Customerid 
             inner join mas_title mt on mc.titelid=mt.Titleid 
             left join mas_company mcom on mcom.company_id = mas.companyid 
             inner join trans_pay_det pdet on pdet.checkoutid=mas.checkoutid and isnull(pdet.cancelflag,0)<>1
             left join mas_paymode mp on pdet.Paymodeid = mp.PayMode_Id
             left join mas_bank mb on pdet.Bankid = mb.Bankid
             left join mas_company mcc on mcc.Company_Id = pdet.Bankid and mp.paymode='COMPANY'
              where mas.Checkoutdate='" . $fromdate . "' and mas.checkoutno like 'CHK%'   and isnull(mas.cancelflag,0)<>1 and isnull(mas.settle,0) = 1
              order by mas.checkoutno";
			$exec = $this->db->query($qry);
			$totalAdvance = 0;
			$advance = $exec->num_rows();
			$count = 1;
			if ($advance != 0) {
				echo '<tr style="background-color:#c9c6c6;" >';	
				echo '<td  style="text-align: center;">Invoice No</td>';
				echo '<td  style="text-align: center;">Room No</td>';
				echo '<td style="text-align: center;">GuestName</td>';
				echo '<td style="text-align: center;">Amount</td>';
				echo '<td style="text-align: center;">Paymode</td>';
				echo '<td style="text-align: center;">company</td>';
				echo '<td style="text-align: center;">Action</td>';
				echo '</tr>';
			}
			foreach ($exec->result_array() as $row1) {
				echo '<form id="reserveform'.$count.'" method="POST">	';
				?>
				<input type="hidden" num=1 name="checkoutid" id="resdetid<?php echo $count; ?>"
					value="<?php echo $row1['checkoutid']; ?>" class="f-ctrl rmm">
				<input type="hidden" num=1 name="roomgrcid" id="roomgrcid<?php echo $count; ?>"
					value="<?php echo $row1['Roomgrcid']; ?>" class="f-ctrl rmm">
				<input type="hidden" num=1 name="grcid" id="grcid<?php echo $count; ?>"
					value="<?php echo $row1['grcid']; ?>" class="f-ctrl rmm">
				<input type="hidden" num=1 name="roomid" id="roomid<?php echo $count; ?>"
					value="<?php echo $row1['Roomid']; ?>" class="f-ctrl rmm">
					<input type="hidden" num=1 name="guest" id="guest<?php echo $count; ?>"
					value="<?php echo $row1['Guestname']; ?>" class="f-ctrl rmm">
				<input type="hidden" num=1 name="checkoutdate" id="checkoutdate<?php echo $count; ?>"
					value="<?php echo date('Y-m-d', strtotime($row1['checkoutdate'])); ?>" class="f-ctrl rmm">
				<?php echo '<tr>';
				echo '<td  style="text-align: center;">' . $row1['yearprefix'] . '/' . $row1['checkoutno'] . '</td>';
				echo '<td style="text-align: right;">' . $row1['roomno'] . '</td>';
				echo '<td style="text-align: left;">' . $row1['Guestname'] . '</td>';
				echo '<td style="text-align: center;">' . $row1['Amount'] . '</td>';
				echo '<td style="text-align: right;">' . $row1['paymode'] . '</td>';
				echo '<td style="text-align: right;">' . $row1['paidcompany'] . '</td>';
				echo '<td style="text-align: center;">';
				?>
				<button type="button" class="btn btn-primary btn-sm" id="savebtn<?php echo $count; ?>"
					onclick="Reserve('<?php echo $count; ?>')" value="save" /> <i class="fa fa-edit"></i></button></td>
				<?php 
				echo '</tr>';
				echo '</form>';
				$count++;
			}
			?>
		</tbody>
	</table>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>


<script>
	function Reserve(a) {
		swal({
			text: 'Reason for Re-Instate Settlement',
			content: "input",
			button: {
				text: "Save",
				closeModal: false,
			},
		})
			.then(name => {
				if (!name) throw null;
				$.ajax({
					type: 'post',
					url: '<?php echo scs_index ?>Transaction/ReinstateSettlementSave',
					data: $('#reserveform' + a).serialize() + "&Reason="+name,
					success: function (result) {
						// alert(result);
					
						if (result.trim() == 'success') {
							swal("Success...!", "Saved Successfully", "success")
								.then(function () {
									window.location.href = '<?php echo scs_index ?>Transaction/ReinstateSettlement';
								});
						}
						else {
							swal("Faild...!", "Room Already Checked in!..", "error")
								.then(function () {
									window.location.href = '<?php echo scs_index ?>Transaction/ReinstateSettlement';

								});
						}

					}
				});
			})
			.catch(err => {
				if (err) {
					swal("Oh noes!", "The AJAX request failed!", "error");
				} else {
					swal.stopLoading();
					swal.close();
				}
			});


	}

</script>


<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>