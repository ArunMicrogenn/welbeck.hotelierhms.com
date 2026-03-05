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
$this->pweb->Cheader('Transaction','checkoutCancellation');
$this->pfrm->FrmHead3('Transaction/ checkoutCancellation',$F_Class."/".$F_Ctrl."/".$ID,$F_Class."/".$F_Ctrl."_View");


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
    $sql="select mas.checkoutno, mas.checkoutdate,mas.yearprefix, mr.roomno,mrt.RoomType,mt.Title+'.'+mc.Firstname+' '+mc.Lastname as Guestname,
     isnull(mcom.company,' ') as company,mas.checkoutid,mas.Roomgrcid, mas.grcid,rs.Roomid from trans_checkout_mas mas
     inner join room_status rs on mas.roomgrcid=rs.roomgrcid
     inner join mas_room mr on mr.Room_Id = rs.Roomid
     inner join mas_roomType mrt on mrt.RoomType_Id= mr.RoomType_Id
     inner join mas_customer mc on mc.Customer_Id = mas.Customerid
     inner join mas_title mt on mc.titelid=mt.Titleid
     left join mas_company mcom on mcom.company_id = mas.companyid
     where mas.Checkoutdate='".$fromdate."' and rs.billsettle=1 and rs.status='Y'
      and isnull(rs.notready,0)=0 and isnull(mas.settle,0)<>1 and isnull(mas.cancelflag,0)<>1
     order by mas.checkoutno";
 
     $exe = $this->db->query($sql);
     $count = 1;
     $no = $exe->num_rows(); 

      $depqry = "select tdet.depdate from trans_checkout_mas tmas 
                  inner join trans_roomdet_det tdet on tdet.roomgrcid = tmas.roomgrcid";

                  $depdate = $this->db->query($depqry)->row_array();

     if($no !=0){
     ?>
     <table  class="table table-bordered table-hover">
			
			<tr style="background-color:#c9c6c6;" >	
			<td  style="text-align: center;">S.No</td>
            <td  style="text-align: center;">Invoice No</td>
            <td  style="text-align: center;">Room No</td>
			<td  style="text-align: center;">Guestname</td>
			<td  style="text-align: center;">Companyname</td>
            <td  style="text-align: center;">Action</td>
			</tr>
			
			<?php 
			foreach($exe->result_array() as $row1){
                
			?>
            <tbody  class="input_fields_wrap">
            <form id="reserveform<?php echo $count;?>" method="POST">
			  <tr  class="tb">
              
                <input type="hidden"  num=1 name="checkoutid" id="resdetid<?php echo $count;?>"  value="<?php echo $row1['checkoutid']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="roomid" id="roomid<?php echo $count;?>"  value="<?php echo $row1['Roomid']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="grcid" id="grcid<?php echo $count;?>"  value="<?php echo $row1['grcid']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="roomgrcid" id="roomgrcid<?php echo $count;?>"  value="<?php echo $row1['Roomgrcid']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="guest" id="guest<?php echo $count;?>"  value="<?php echo $row1['Guestname']; ?>" class="f-ctrl rmm" >
                <td style="text-align:center"><?php echo $count;?></td>                                   
                <td  style="text-align: center;">
                <?php echo $row1['yearprefix'].'/'.$row1['checkoutno']?>
                </td>
                <td style="text-align:center">
               <?php echo $row1['roomno']?>
                </td>
                <td  style="text-align: center;">
                <?php echo $row1['Guestname']?>
                </td> 
                <td  style="text-align: center;"><?php echo $row1['company'] ?></td>
                <td >
				<button type="button" class="btn btn-primary btn-sm" id="savebtn<?php echo $count; ?>"
					onclick="Reserve('<?php echo $count; ?>')" value="save" /> <i class="fa fa-edit"></i></button></td>
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
                    text: 'Reason for Checkout cancellation',
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
                        url: '<?php echo scs_index ?>Transaction/ReinstateCheckoutSave',
                        data: $('#reserveform' + a).serialize() + "&Reason=" + encodeURIComponent(reason),
                        success: function (result) {
                            if (result.trim() === 'Success') {
                                swal("Success!", "Saved Successfully", "success")
                                    .then(function () {
                                        window.location.href = '<?php echo scs_index ?>Transaction/ReinstateCheckout';
                                    });
                            } else {
                                swal("Failed!", "Unable to process", "error")
                                    .then(function () {
                                        window.location.href = '<?php echo scs_index ?>Transaction/ReinstateCheckout';
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

//    $.ajax({
//     url: "<php echo scs_index ?>Transaction/room_validation",
//     method: 'POST',
//     data: {
//         roomtypeid: rmtype,
//         noofrooms: 1,
//         fromdate: Indate,
//         todate: todate,
//     },
//     success: function (response) {
        
//         try {
//             const fixedResponse = "[" + response.replace(/}{/g, "},{") + "]";
//             const data = JSON.parse(fixedResponse);

//             if (Array.isArray(data) && data.length > 0) {
//                 for (let i = 0; i < data.length; i++) {
//                     const availableRooms = Number(data[i].available || 0);
//                     const roomTypeName = data[i].room_type || 'Unknown';
//                     const date = data[i].date || 'Unknown Date';

//                     if (availableRooms < 1) {
//                         alert("No rooms available on " + date);
//                         location.reload();
//                         return;
//                     }
//                 }

//                 swal({
//                     text: 'Reason for Checkout cancellation',
//                     content: "input",
//                     button: {
//                         text: "Save",
//                         closeModal: false,
//                     },
//                 })
//                 .then(reason => {
//                     if (!reason) throw null;

//                     $.ajax({
//                         type: 'POST',
//                         url: '<php echo scs_index ?>Transaction/ReinstateCheckoutSave',
//                         data: $('#reserveform' + a).serialize() + "&Reason=" + encodeURIComponent(reason),
//                         success: function (result) {
//                             if (result.trim() === 'Success') {
//                                 swal("Success!", "Saved Successfully", "success")
//                                     .then(function () {
//                                         window.location.href = '<php echo scs_index ?>Transaction/ReinstateCheckout';
//                                     });
//                             } else {
//                                 swal("Failed!", "Unable to process", "error")
//                                     .then(function () {
//                                         window.location.href = '<php echo scs_index ?>Transaction/ReinstateCheckout';
//                                     });
//                             }
//                         },
//                         error: function () {
//                             swal("Error", "Failed to save the data.", "error");
//                         }
//                     });
//                 })
//                 .catch(err => {
//                     if (err) {
//                         swal("Oops!", "The AJAX request failed!", "error");
//                     } else {
//                         swal.stopLoading();
//                         swal.close();
//                     }
//                 });
//             } else {
//                 alert("No data received from server.");
//             }
//         } catch (err) {
//             alert("Invalid response from server.");
//             console.error("Parsing Error:", err);
//         }
//     },
//     error: function () {
//         alert("Failed to connect to the server.");
//     }
// });



	}

</script>
<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>
