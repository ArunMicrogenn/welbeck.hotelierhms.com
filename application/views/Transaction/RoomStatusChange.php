<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','RoomStatusChange');
$this->pfrm->FrmHead2('Transaction / RoomStatusChange',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

  $date=date("Y-m-d");
  $time= date("H:i:s");
  $previousdate=date('Y-m-d', strtotime("-1 days"));
  $sql="select DateofAudit,* from night_audit";
  $res=$this->db->query($sql);
  foreach ($res->result_array() as $row)
	{ $auditdate=$row['DateofAudit']; }
	 $creditdate=date('Y-m-d',strtotime($auditdate.'+1 days'));
?>
<?php
$res = $this->db->query("SELECT DateofAudit FROM night_audit ORDER BY DateofAudit DESC");

if ($row = $res->row_array()) {
  $auditdate = date('Y/m/d', strtotime($row['DateofAudit']));
}

?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
        <table class="FrmTable T-8" >
        <tr>
          <td align="right" class="F_val">Room Number</td>
          <td align="left">
		   <select id="roomid" onchange="fetchroomtype(this.value);" name="roomid" class="scs-ctrl">
		    <option value="">---Select Room---</option>
            <?php $sql="select * from Room_Status rs
					Inner Join Mas_Room rm on rm.Room_Id=rs.Roomid
					where Status<>'Y' and isnull(blocked,0)=0";
				  $res=$this->db->query($sql);
				  foreach ($res->result_array() as $row)
				  {
                   echo '<option value="'.$row['Room_Id'].'">'.$row['RoomNo'].'</option>';
  			      }?>
			 </select>
			 	<div class="roomid"></div>
            </td>
			<td ></td>
			<td></td>
        </tr>
		<tr><input type="hidden" id="roomtypeid" name ="roomtypeid" value=""></tr>
		<tr>
		<td align="right" class="F_val">From Date</td>
			<td align="left">
                    <input readonly name="fromDate" onchange="fetchdate(this.value);" id="fromDate" type="text"  class="scs-ctrl Dat rmm" />
			<div class="fromDate"></div>
			</td>
			<td align="right" class="F_val"> From Time</td>
			<td align="left">
            <input name="fromtime" id="fromtime" type="time" max="<?php echo date('H:i:s'); ?>" class="scs-ctrl rmm" />
			<div class="fromtim"></div>
			</td>
		 <td></td>
		 <td></td>
		 </tr>
		 <tr>
		<td align="right" class="F_val"> To Date</td>
			<td align="left">
				<input readonly name="toDate" id="toDate" type="text"  class="scs-ctrl Dat rmm" />
			    <div class="toDate"></div>
			</td>
			<td align="right" class="F_val"> To Time</td>
			<td align="left">
                    <input name="totime" id="totime" type="time"  class="scs-ctrl  rmm" />
			<div class="totime"></div>
			</td>
		 <td></td>
		 <td></td>
		 </tr>		
        <tr>
          <td align="right" class="F_val">Block Type</td>
          <td align="left">
		   <select onchange="fetchdepdate(this.value);" id="BlockType" name="BlockType" class="scs-ctrl">
		     <option value="">---Select Type---</option>
             <option value="1">Fo-Block</option>
             <option value="2">M-Block</option>
           </select>
			<div class="BlockType"></div>
            </td>
			<td ></td>
			<td></td>
        </tr>
		<input type="hidden" id="grcid" name="grcid"/>
		<tr>
		  <td  align="right">Reason</td>
		  <td  align="Left"><input type="text" Name="reason" id="reason" class="scs-ctrl" /> <div class="reason"></div></td>
          <td align="right">&nbsp;</td>
        </tr>
		<tr>
		 <td align="right">&nbsp;</td>         
		 <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXECs" name="EXECs" value="Update"   />
		           		  </td>
		  <td></td>
		  <td></td>
		</tr>
      </table>
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

<script>
function fetchdate()
 {
	const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const currentTime = `${hours}:${minutes}`;

	// alert(currentTime);


    document.getElementById('fromtime').value = currentTime;
    document.getElementById('totime').value = currentTime;

 }
 
</script>
<script>
document.getElementById("EXECs").addEventListener("click", function () {
    var roomid = document.getElementById("roomid").value;
    var fromDate = document.getElementById("fromDate").value;
    var toDate = document.getElementById("toDate").value;
    var roomtypeid = document.getElementById("roomtypeid").value;
    var totalRooms = 1;


    var parts = fromDate.split("-");

    if (parts.length === 3) {
        let day = parts[0].padStart(2, '0');
        let month = parts[1].padStart(2, '0');
        let year = parts[2].padStart(4, '20');

        var formatted = `${year}-${month}-${day}`;
    }


    var secparts = toDate.split("-");

    if (secparts.length === 3) {
        let day = secparts[0].padStart(2, '0');
        let month = secparts[1].padStart(2, '0');
        let year = secparts[2].padStart(4, '20');

        var todateed = `${year}-${month}-${day}`;
    }

    var today = new Date().getFullYear() + '/' + ("0" + (new Date().getMonth() + 1)).slice(-2) + '/' + ("0" + new Date().getDate()).slice(-2);

    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }

    $.ajax({
        url: "<?php echo scs_index ?>Transaction/room_validation",
        method: 'POST',
        data: {
            roomtypeid: roomtypeid,
            noofrooms: totalRooms,
            fromdate: formatted,
            todate: todateed
        },
        success: function (response) {
            try {
               
                if (response.includes("}{")) {
                    response = "[" + response.replace(/}{/g, "},{") + "]";
                }
                var data = JSON.parse(response);

               
                if (Array.isArray(data) && data.length > 0) {
                    for (let i = 0; i < data.length; i++) {
                        let availableRooms = Number(data[i].available || 0);
                        let roomTypeName = data[i].room_type || "Unknown";
                        let date = data[i].date || "Unknown";

                  
                        if (totalRooms > availableRooms) {
                            alert("Only " + availableRooms + " rooms available for " + roomTypeName + " on " + date);
                            return;
                        }
                    }
                }

             
                submitRoomstatuschange();
            } catch (err) {
                console.error("Invalid JSON response:", response);
                alert("Error processing server response.");
            }
        },
        error: function () {
            alert("An error occurred while checking room availability.");
        }
    });
});


function submitRoomstatuschange() {
    var BlockType = document.getElementById("BlockType").value;
    var reason = document.getElementById("reason").value;
    var fromDate = document.getElementById("fromDate").value;
    var toDate = document.getElementById("toDate").value;
    var roomid = document.getElementById("roomid").value;
    var fromtime = document.getElementById("fromtime").value;
    var totime = document.getElementById("totime").value;

    


    $.ajax({
        url: "<?php echo scs_index ?>Transaction/RoomStatusChange_exec",
        method: "POST",
        data: {
            roomid: roomid,
            BlockType: BlockType,
            reason: reason,
            fromDate: fromDate,
            toDate: toDate,
            fromtime: fromtime,
            totime: totime
        },
        success: function (response) {
            try {
                var result = JSON.parse(response);
                if (result.success) {
					swal({
                        icon: 'success',
                        title: 'Room Status Changed',
                        text: 'Room Status updated successfully.',
                    }).then(() => {
                        location.reload(); 
                    }); 
                } else {
					swal({
                        icon: 'error',
                        title: 'Update Failed',
                        text: result.error || 'An unknown error occurred.',
                    });
                }
            } catch (err) {
                console.warn("Non-JSON response from server. Proceeding to reload.");
                swal({
                    icon: 'warning',
                    title: 'Guest Stay Updated',
                    text: 'There was an issue processing your request.',
                }).then(() => {
                    location.reload();
                });
            }
        },
        error: function () {
			swal({
                icon: 'error',
                title: 'Failed to Update',
                text: 'An error occurred while updating guest stay.',
            });
        }
    });
}

</script>

<script>
	 function fetchroomtype(Roomid)
 {

			$.ajax({
    url: "<?php echo scs_index ?>Transaction/getroomtypeid?Roomid=" + Roomid,
    type: "POST",
    dataType: "json",
    success: function(response) {
        if (response && response.roomtypeid) {
         
            document.getElementById("roomtypeid").value = response.roomtypeid;
        } else {
            alert("Room type not found.");
            document.getElementById("roomtypeid").value = ""; 
        }
    },
    error: function() {
        alert("AJAX error occurred.");
    }
});


 }

</script>


