<?php

class RoomStatusChange extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function RoomStatusChange_Val()
	{
		 $this->form_validation->set_rules('fromDate', 'From.Date', 'required');
		 $this->form_validation->set_rules('toDate', 'To.Date', 'required');
		 $this->form_validation->set_rules('BlockType', 'BlockType', 'required');		 
		 $this->form_validation->set_rules('roomid', 'Room.Num', 'required');
		 $this->form_validation->set_rules('reason', 'reason', 'required');
		 
		 if ($this->form_validation->run() == FALSE)
		 {
			 $output = $this->form_validation->return_f_error($this->input->post());
			 echo $output = json_encode($output);
		 }
		 else
		 {
			$output = $this->form_validation->return_success($this->input->post());
			echo $output = json_encode($output);
		 }
	}
	// function RoomStatusChange_exec()
	// {   
		
	// 	if($_REQUEST['BlockType']=='1')
	// 	{$FoBlock=1;
	// 	 $MBlock=0;}
	// 	else
	// 	{$FoBlock=0;
	// 	 $MBlock=1;}

	
	// 	 $qry1="insert into Trans_blockmas(dirty,blockdate,blockno,reason,roomid,mblock,foblock,fromdate,fromtime,todate,totime,blockeduserid,blocktime)
	// 	values('1',convert(varchar, getdate(), 23),dbo.BlockMasNo(),'".$_REQUEST['reason']."','".$_REQUEST['roomid']."','".$MBlock."','".$FoBlock."',
	// 	'".date("Y-m-d", strtotime($_REQUEST['fromDate']))."','".$_REQUEST['fromtime']."','".date("Y-m-d", strtotime($_REQUEST['toDate']))."','".$_REQUEST['totime']."','".User_id."',convert(VARCHAR,getdate(),108))";
		 
	// 	$qry2="update Room_Status set Status='N',blocked='1' ,mblock='".$MBlock."',foblock='".$FoBlock."' where Roomid='".$_REQUEST['roomid']."'";


	// 		$check = "select tb.fromdate, mr.roomtype_id, tb.todate from Trans_blockmas tb 
	// 				inner join mas_room room on  room.room_id = tb.roomid
	// 				inner join mas_roomtype mr on mr.roomtype_id = room.roomtype_id
	// 				where tb.blockid= IDENT_CURRENT('Trans_blockmas')
	// 				";
	// 		$checkqry = $this->db->query($check);
	// 		foreach ($checkqry->result_array() as $ress) {
	// 			$cid = $ress['fromdate'];
	// 			$typeid = $ress['typeid'];
	// 			$expcdate = $ress['todate'];
	// 		}

	// 		$aa_date = date_create($cid); 
	// 		$l_date = date_create($expcdate);
	// 		$diff = date_diff($aa_date, $l_date);
	// 		$difference = $diff->format("%a");
	// 		for ($i = 0; $i <= $difference; $i++) {
         
	// 		$insR = " exec Update_RoomAvailability   '" . $cid. "', '" . $typeid. "'";


	// 			$execute = $this->db->query($insR);

	// 			$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
	// 		}

		
		
	// 	echo "BEGIN Try ";
	// 	echo "BEGIN Transaction ";
	// 	echo "BEGIN Tran ";
	// 	echo "Declare @Siden INT; ";
	// 	echo $qry1;			
	// 	echo $qry2;
	// 	echo "set @Siden=@@identity; ";	   
	// 	echo " If @@error<>0 Rollback Tran else Commit Tran ";
	// 	echo "COMMIT ";
	// 	echo "end try ";
	// 	echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
	// 	echo "END CATCH ";
	// 	$sqc = ob_get_clean();
	// 	$qry=$sqc;
	// 	$res=$this->db->query($qry);
	// 	$msg=$this->db->error(); 
	// 	$output = array();
	// 	 $output['Success']=true;
 	// 	 $output['MSG']="Room Status Changed";		 
	// 	 print_r(json_encode($output));
	// 	// $this->Myclass->GetRec($msg,$res,$qry);  
          
		
	 
	// }


// 	function RoomStatusChange_exec()
// {   

// 	 $this->pweb->nightaudit();

	 
//     if ($_REQUEST['BlockType'] == '1') {
//         $FoBlock = 1;
//         $MBlock = 0;
//     } else {
//         $FoBlock = 0;
//         $MBlock = 1;
//     }

//     // Start output buffer to build dynamic SQL
//     ob_start();

//     echo "BEGIN TRY ";
//     echo "BEGIN TRANSACTION ";

//     // Insert into Trans_blockmas
//     echo "DECLARE @Siden INT; ";
//     echo "INSERT INTO Trans_blockmas (dirty, blockdate, blockno, reason, roomid, mblock, foblock, fromdate, fromtime, todate, totime, blockeduserid, blocktime) ";
//     echo "VALUES ('1', CONVERT(VARCHAR, GETDATE(), 23), dbo.BlockMasNo(), '" . $_REQUEST['reason'] . "', '" . $_REQUEST['roomid'] . "', '" . $MBlock . "', '" . $FoBlock . "', ";
//     echo "'" . date("Y-m-d", strtotime($_REQUEST['fromDate'])) . "', '" . $_REQUEST['fromtime'] . "', '" . date("Y-m-d", strtotime($_REQUEST['toDate'])) . "', '" . $_REQUEST['totime'] . "', '" . User_id . "', CONVERT(VARCHAR, GETDATE(), 108)); ";

//     echo "SET @Siden = SCOPE_IDENTITY(); ";

//     // Update Room_Status
//     echo "UPDATE Room_Status SET Status = 'N', blocked = '1', mblock = '" . $MBlock . "', foblock = '" . $FoBlock . "' WHERE Roomid = '" . $_REQUEST['roomid'] . "'; ";

//     // Return blockid for PHP
//     echo "SELECT @Siden AS blockid; ";

//     echo "COMMIT TRANSACTION; ";
//     echo "END TRY ";
//     echo "BEGIN CATCH ";
//     echo "ROLLBACK TRANSACTION; ";
//     echo "SELECT ERROR_NUMBER() AS ErrorNumber, ERROR_MESSAGE() AS ErrorMessage; ";
//     echo "END CATCH ";


//     $check = "	SELECT tb.fromdate, mr.roomtype_id AS typeid, tb.todate ,tb.roomgrcid
// 	FROM Trans_blockmas tb 
// 	INNER JOIN mas_room room ON room.room_id = tb.roomid
// 	INNER JOIN mas_roomtype mr ON mr.roomtype_id = room.roomtype_id
// 	where tb.blockid= IDENT_CURRENT('Trans_blockmas')";

//     $checkqry = $this->db->query($check);
//     foreach ($checkqry->result_array() as $ress) {
//         $cid = $ress['fromdate'];
//         $typeid = $ress['typeid'];
//         $expcdate = $ress['todate'];
//         // $roomgrcid = $ress['roomgrcid'];
//     }

// 	$aa_date = date_create($cid); 
// 	$l_date = date_create($expcdate);
// 	$diff = date_diff($aa_date, $l_date);
// 	$difference = $diff->format("%a");

// 	for ($i = 0; $i <= $difference; $i++) {
	
// 		$val = "exec roomavailability_validation '".$cid."','".$typeid."','0'";
		
		
// 		$validationResult = $this->db->query($val)->row_array();
// 		$this->db->close();
// 		$this->db->reconnect();



// 		if ($validationResult) {
		
// 			$insR = "exec Update_RoomAvailability   '" . $cid . "', '" . $typeid . "'";
			
// 			$execute = $this->db->query($insR);
// 			$this->db->close();
// 					$this->db->reconnect();

// 		}
		
	
// 		$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
		

// 	}

//     // $aa_date = date_create($cid);
//     // $l_date = date_create($expcdate);
//     // $diff = date_diff($aa_date, $l_date);
//     // $difference = $diff->format("%a");

//     // for($i = 0; $i <= $difference; $i++) {
//     //     $insR = "EXEC Update_RoomAvailability '" . $cid . "', '" . $typeid . "'";
//     //     $execute = $this->db->query($insR);
//     //     $cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
//     // }

//     $qry = ob_get_clean();
//     $res = $this->db->query($qry);

//     $output = array();
//     $output['Success'] = true;
//     $output['MSG'] = "Room Status Changed";
//     print_r(json_encode($output));



// }

function RoomStatusChange_exec()
{
    if ($_REQUEST['BlockType'] == '1') {
        $FoBlock = 1;
        $MBlock = 0;
    } else {
        $FoBlock = 0;
        $MBlock = 1;
    }

    ob_start(); 

   
    $qry1 = "
        INSERT INTO Trans_blockmas (
            dirty, blockdate, blockno, reason, roomid, mblock, foblock, 
            fromdate, fromtime, todate, totime, blockeduserid, blocktime
        ) VALUES (
            '1', CONVERT(VARCHAR, GETDATE(), 23), dbo.BlockMasNo(), '" . $_REQUEST['reason'] . "', '" . $_REQUEST['roomid'] . "', 
            '" . $MBlock . "', '" . $FoBlock . "',
            '" . date("Y-m-d", strtotime($_REQUEST['fromDate'])) . "', CONVERT(VARCHAR, GETDATE(), 108),
            '" . date("Y-m-d", strtotime($_REQUEST['toDate'])) . "', CONVERT(VARCHAR, GETDATE(), 108),
            '" . User_id . "', CONVERT(VARCHAR, GETDATE(), 108)
        );
    ";

    $qry2 = "
        UPDATE Room_Status 
        SET Status='N', blocked='1', mblock='" . $MBlock . "', foblock='" . $FoBlock . "' 
        WHERE Roomid='" . $_REQUEST['roomid'] . "';
    ";


    echo "BEGIN TRY ";
    echo "BEGIN TRANSACTION ";
    echo "DECLARE @Siden INT; ";
    echo $qry1;
    echo $qry2;
    echo "SET @Siden = @@IDENTITY; ";
    echo "IF @@ERROR <> 0 ROLLBACK TRAN ELSE COMMIT TRAN ";
    echo "END TRY ";
    echo "BEGIN CATCH ";
    echo "ROLLBACK TRAN; ";
    echo "SELECT ERROR_NUMBER() AS ErrorNumber, ERROR_MESSAGE() AS ErrorMessage; ";
    echo "END CATCH ";


    $sqc = ob_get_clean();
    $qry = $sqc;

    $res = $this->db->query($qry);
    $msg = $this->db->error();

 
    $check = "
        SELECT tb.fromdate, mr.roomtype_id AS typeid, tb.todate, tb.roomgrcid
        FROM Trans_blockmas tb 
        INNER JOIN mas_room room ON room.room_id = tb.roomid
        INNER JOIN mas_roomtype mr ON mr.roomtype_id = room.roomtype_id
        WHERE tb.blockid = IDENT_CURRENT('Trans_blockmas')
    ";

    $checkqry = $this->db->query($check);
    foreach ($checkqry->result_array() as $ress) {
        $cid = $ress['fromdate'];
        $typeid = $ress['typeid'];
        $expcdate = $ress['todate'];
        // $roomgrcid = $ress['roomgrcid']; // Unused
    }

    $aa_date = date_create($cid);
    $l_date = date_create($expcdate);
    $diff = date_diff($aa_date, $l_date);
    $difference = $diff->format("%a");

    for ($i = 0; $i <= $difference; $i++) {
        $val = "EXEC roomavailability_validation '" . $cid . "', '" . $typeid . "', '0'";
        $validationResult = $this->db->query($val)->row_array();


        $this->db->close();
        $this->db->reconnect();

        if ($validationResult) {
            $insR = "EXEC Update_RoomAvailability '" . $cid . "', '" . $typeid . "'";
            $this->db->query($insR);
            $this->db->close();
            $this->db->reconnect();
        }

        $cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
    }
	

    $output = array();
    $output['Success'] = true;
    $output['MSG'] = "Room Status Changed";
    echo json_encode($output);
}






}
?>