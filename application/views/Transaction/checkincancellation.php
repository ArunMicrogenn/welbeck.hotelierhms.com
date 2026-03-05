<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->nightaudit();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Checkincancellation');
$this->pfrm->FrmHead3('Transaction/ Checkincancellation',$F_Class."/".$F_Ctrl."/".$ID,$F_Class."/".$F_Ctrl."_View");


?>
<?php 
$qury = "select * from usertable where User_id='".User_id."' ";
$op = $this->db->query($qury);
foreach($op -> result_array() as $row){
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

  <?php
     
     $fromdate = date('Y-m-d');
       $sql="  select mas.checkindate,mas.groupcheckin,mas.checkintime,mas.ExpDate,mas.yearprefix, mr.roomno,mrt.RoomType_id,mt.Title+'.'+mc.Firstname+' '+mc.Lastname as Guestname, isnull(mcom.company,' ') as company, mas.grcid,rs.Roomid,rs.roomgrcid, mas.noadults from trans_checkin_mas mas 
       inner join room_status rs on mas.grcid=rs.grcid 
       inner join mas_room mr on mr.Room_Id = rs.Roomid
       inner join trans_roomdet_det trd on trd.roomgrcid = rs.roomgrcid
        inner join Trans_RoomCustomer_det mrc on mrc.Grcroomdetid =trd.Grcroomdetid
        inner join mas_roomType mrt on mrt.RoomType_Id= mr.RoomType_Id 
        inner join mas_customer mc on mc.Customer_Id = mrc.Customerid 
        inner join mas_title mt on mc.titelid=mt.Titleid 
     left join mas_company mcom on mcom.company_id = mas.company where mas.Checkindate='". $fromdate."' and isnull(mas.cancelflag,0) <> 1";
 
     $exe = $this->db->query($sql);
     $count = 1;
     $no = $exe->num_rows(); 

      $depqry = "select tdet.depdate from trans_checkout_mas tmas 
                  inner join trans_roomdet_det tdet on tdet.roomgrcid = tmas.roomgrcid";

                  $depdate = $this->db->query($depqry)->row_array();

      $setqry = "select enablecheckintiming,checkintiming from Extraoption";
      $set = $this->db->query($setqry)->row_array();

      






     if($no !=0){
     ?>
     <table  class="table table-bordered table-hover">
			
			<tr style="background-color:#c9c6c6;" >	
			<td  style="text-align: center;">S.No</td>
            <td  style="text-align: center;">Room No</td>
            <td  style="text-align: center;">Customer Name</td>
			<td  style="text-align: center;">Company Name</td>
			<td  style="text-align: center;">Checkin Date</td>
			<td  style="text-align: center;">Checkin Time</td>
			<td  style="text-align: center;">Pax</td>
            <td  style="text-align: center;">Action</td>
			</tr>
			
			<?php 
			foreach($exe->result_array() as $row1){
                $checkinTime = date("H:i:s", strtotime($row1['checkintime'])); 
$checkinTiming = $set['checkintiming'];
$enablecheckintiming = $set['enablecheckintiming'];


$checkinTimestamp = strtotime($checkinTime);
$allowedTimestamp = strtotime("+{$checkinTiming} minutes", $checkinTimestamp);
$currentTime = strtotime(date("H:i:s")); 
                
			?>
            <tbody  class="input_fields_wrap">
            <form id="reserveform<?php echo $count;?>" method="POST">
			  <tr  class="tb">
              
                <!-- <input type="hidden"  num=1 name="checkoutid" id="resdetid<php echo $count;?>"  value="<?php echo $row1['checkoutid']; ?>" class="f-ctrl rmm" > -->
                <input type="hidden"  num=1 name="roomid" id="roomid<?php echo $count;?>"  value="<?php echo $row1['Roomid']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="grcid" id="grcid<?php echo $count;?>"  value="<?php echo $row1['grcid']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="roomgrcid" id="roomgrcid<?php echo $count;?>"  value="<?php echo $row1['roomgrcid']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="roomtypeid" id="roomtypeid<?php echo $count;?>"  value="<?php echo $row1['RoomType_id']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="fromdate" id="fromdate<?php echo $count;?>"  value="<?php echo $row1['checkindate']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="todate" id="todate<?php echo $count;?>"  value="<?php echo $row1['ExpDate']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="guest" id="guest<?php echo $count;?>"  value="<?php echo $row1['Guestname'] ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="groupcheckin" id="groupcheckin<?php echo $count;?>"  value="<?php echo $row1['groupcheckin'] ?>" class="f-ctrl rmm" >
                <td style="text-align:center"><?php echo $count;?></td>                                   
                <td  style="text-align: center;">
                <?php echo $row1['roomno']?>
                </td>
                <td style="text-align:center">
               <?php echo $row1['Guestname']?>
                </td>
                <td  style="text-align: center;">
                <?php echo $row1['company']?>
                </td> 
                <td  style="text-align: center;"><?php echo date("d-m-Y",strtotime($row1['checkindate'])) ?></td>
                <td  style="text-align: center;"><?php echo date("H:m",strtotime($row1['checkintime'])) ?></td>
                <td  style="text-align: center;"><?php echo $row1['noadults'] ?></td>
                <td>
                <?php   if ($enablecheckintiming == 1) { ?>
             <?php   if ($currentTime <= $allowedTimestamp) { ?>
                <button type="button" class="btn btn-primary btn-sm" id="savebtn<?php echo $count; ?>"
					onclick="Reserve('<?php echo $count; ?>')" value="save" /> <i class="fa fa-edit"></i></button></td>
                  <?php   } else { ?>
                    <button type="button" class="btn btn-primary btn-sm" id="savebtn<?php echo $count; ?>"
					onclick="time(<?php echo $checkinTiming ?>)" value="save" /> <i class="fa fa-edit"></i></button></td>
                  <?php   }  ?>
                  <?php   } else {  ?>
                    <button type="button" class="btn btn-primary btn-sm" id="savebtn<?php echo $count; ?>"
					onclick="Reserve('<?php echo $count; ?>')" value="save" /> <i class="fa fa-edit"></i></button></td>
                  <?php   }  ?>

		
				</td>
		    </tr>
            </form>
		    </tbody>
			<?php  $count++ ;} ?>
          
			</table>  
            <?php }?>

<div>



<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
	function Reserve(a) {

        swal({
                    text: 'Reason for Checkin cancellation',
                    content: "input",
                    button: {
                        text: "Save",
                        closeModal: false,
                    },
                })
                .then(reason => {
                    if (!reason) throw null;

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo scs_index ?>Transaction/Checkincancellationsave',
                        data: $('#reserveform' + a).serialize() + "&Reason=" + encodeURIComponent(reason),
                        success: function (result) {
                            if (result.trim() === 'success') {
                                swal("Success!", "Checkin Cancel Successfully", "success")
                                    .then(function () {
                                        window.location.href = '<?php echo scs_index ?>Transaction/checkincancellation';
                                    });
                            } else {
                                swal("Failed!", "Unable to process", "error")
                                    .then(function () {
                                        window.location.href = '<?php echo scs_index ?>Transaction/checkincancellation';
                                    });
                            }
                        },
                        error: function () {
                            swal("Error", "Failed to save the data.", "error");
                        }
                    });
                })
                .catch(err => {
                    if (err) {
                        swal("Oops!", "The AJAX request failed!", "error");
                    } else {
                        swal.stopLoading();
                        swal.close();
                    }
                });

	}

</script>


<script>
    function time(a){
        swal("Warning!", "Checkin Cancel within " + a +" min", "warning")
                                    .then(function () {
                                        window.location.href = '<?php echo scs_index ?>Transaction/checkincancellation';
                                    });
    }
</script>
<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>
