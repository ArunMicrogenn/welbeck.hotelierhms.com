<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Check-In Table</title>
<style>
/* Table styling */
.checkin-table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    margin-top: 20px;
}

.checkin-table th, .checkin-table td {
    border: 1px solid #ccc;
    padding: 8px 10px;
    text-align: center;
    vertical-align: middle;
}

.checkin-table th {

    font-weight: bold;
}

/* Inputs & selects styling */
.checkin-table input,
.checkin-table select {
    padding: 5px 6px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    width: 100%;
    background-color: transparent; /* transparent background */
    text-align: center;
    box-sizing: border-box;
}

/* Time group styling */
.time-group {
    display: flex;
    justify-content: center;
    gap: 3px;
}

/* Check-In button styling */
.checkin-table button {
    padding: 6px 20px;
    background-color: #ff9800;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

.checkin-table button:hover {
    background-color: #e68900;
}
</style>
</head>
<body>

<form id="checkInForm">
<table class="checkin-table">
    <thead>
        <tr>
            <th>Room No</th>
            <th>On Date</th>
            <th>On Time</th>
            <th>EXP.OFF Date</th>
            <th>EXP.OFF Time</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php    
            
            date_default_timezone_set('Asia/Kolkata');

            $setqry = "select enablepower from extraoption";

            $set = $this->db->query($setqry)->row_array();
        
            if($set['enablepower'] == 1) {
                
                  
                    $otherDB = $this->load->database('another_db', TRUE);
                  
                 
                        $process = "select Status_Id from mas_status where upper(status) = 'MAINTENANCE'";
                      
                        $process_id = $otherDB->query($process)->row_array();
                      
                       $selqry = "select Ptime from mas_process where Process_Id='".$process_id['Status_Id']."'" ;
       
                       $sel = $otherDB->query($selqry)->row_array();
                       // $sel['Ptime'];
       
       
                   
                }
       
                // $offtime = date('H:i:s', strtotime('+' . $sel['Ptime'] . ' minute'));
            $currdate = date('d-m-Y');
            $currtime = date('H:i:s');

            $startDateTime = $currdate . ' ' . $currtime;  

$calcDateTime  = strtotime($startDateTime . ' +' . $sel['Ptime'] . ' minute');

$offdate = date('d-m-Y', $calcDateTime);  // final date
$offtime = date('H:i:s', $calcDateTime);  // final time
 

$endDateTime = date('Y-m-d H:i:s', strtotime($startDateTime . ' +' . $sel['Ptime'] . ' minute'));

             $Roomid=$_POST['roomid'];

             $nextdate = date('d-m-Y', strtotime('+1 day'));



  $rooomtype = "select mr.RoomType_Id,mr.Room_id,mr.RoomNo from mas_room mr 
inner join mas_roomtype mt on mt.RoomType_Id = mr.RoomType_Id 
where mr.room_id='".$Roomid."'";
$rooomtypeqry =$this->db->query($rooomtype)->row_array(); ?>

            <td><input type="text" id="roomNo" name ="roomNo" placeholder="Room No" value="<?php echo $rooomtypeqry['RoomNo']  ?>"></td>
            <td><input type="text" id="inDate" name ="inDate" placeholder="Indate" value="<?php echo $currdate  ?>"></td>
            <td>
            <input type="text" id="intime" name ="intime" placeholder="intime" value="<?php echo $currtime  ?>"></td>
            </td>
            <td>
            <input type="text" id="outDate" name ="outDate" placeholder="outDate" value="<?php echo $offdate  ?>"></td>

            </td>
            <td>
            <input type="text" id="totime" name ="totime" placeholder="totime" value="<?php echo $offtime  ?>"></td>

            </td>
            <td><input type="text" id="Remarks" name ="Remarks" placeholder="Remarks"></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:center;">
                <button type="button" onclick="cleaning()">Proceed</button>
            </td>
        </tr>
        <input type="hidden" name ="roomid"  id="roomid" value="<?php echo $rooomtypeqry['Room_id']  ?>">
    </tbody>
</table>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function cleaning() {
    var roomNo = document.getElementById("roomNo").value;

    var inDate = document.getElementById("inDate").value;
    var outDate = document.getElementById("outDate").value;
    var intime = document.getElementById("intime").value;
    var totime = document.getElementById("totime").value;
    var Remarks = document.getElementById("Remarks").value;
    var roomid = document.getElementById("roomid").value;

    // if(!roomNo || !inDate || !intime || !inMin || !outDate || !outHr || !outMin || !username) {
    //     alert("Please fill all fields!");
    //     return;
    // }

    var formData = new FormData();
    formData.append("roomNo", roomNo);
    formData.append("inDate", inDate );
    formData.append("outDate", outDate );
    formData.append("intime", intime );
    formData.append("totime", totime );
    formData.append("Remarks", Remarks);
    formData.append("roomid", roomid);

    // console.log(formData);

    $.ajax({
        url: "<?php echo scs_index ?>Transaction/maintainancesave",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            alert(response);
            location.reload();
        },
        error: function() {
            alert("Error saving Maintainance!");
        }
    });
}
</script>

</body>
</html>
