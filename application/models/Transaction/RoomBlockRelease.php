<?php

class RoomBlockRelease extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function RoomBlockRelease_Val()
	{
		 $this->form_validation->set_rules('fromDate', 'From.Date', 'required');
		 $this->form_validation->set_rules('toDate', 'To.Date', 'required');		 
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
	function RoomBlockRelease_exec()
	{  

		date_default_timezone_set('Asia/Kolkata');
		 $Up="update Room_Status set notready=0,blocked=0,foblock=0,mblock=0 where Roomid='".$_REQUEST['roomid']."'";
		$qry = $this->db->query($Up);
        $fromDate = $_REQUEST['fromDate'];
        $toDate = $_REQUEST['toDate'];
        $fromtime = $_REQUEST['fromtime'];
        $totime = $_REQUEST['totime'];
	
		$qry1="update Trans_blockmas set Reblockeduserid='".User_id."',blockrelasedate='".date('Y-m-d')."',blockrelasetime=convert(VARCHAR,getdate(),108),unblockreason='".$_REQUEST['reason']."' where blockid='".$_REQUEST['blockid']."'";		 			
		$qryes = $this->db->query($qry1);
		
		
		$setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

		$set = $this->db->query($setqry)->row_array();

	

		if($set['Enablebeehivesroominventoryintergration'] == 1) {

			$troomexe = "select RoomNo from mas_room where Room_id = '".$_REQUEST['roomid']."'";

			$troom = $this->db->query($troomexe)->row_array();

		  	$fromroomnoqry = "SELECT mrtype.RoomType_Id, mrtype.RoomType,mr.RoomNo,rs.grcid,rs.roomgrcid FROM mas_room mr
			inner join mas_roomtype mrtype on mrtype.RoomType_Id = mr.RoomType_Id 
			inner join room_status rs on rs.Roomid = mr.Room_Id
			WHERE mr.Room_id = '".$_REQUEST['roomid']."'";

		

			$fromroomno = $this->db->query($fromroomnoqry)->row_array();

		
		    $rsdetqry1 = "INSERT INTO trans_roomstatus_det
		(fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus)
		VALUES ('".$fromroomno['RoomNo']."','".$_REQUEST['roomid']."','".$fromroomno['RoomType_Id']."','".$fromroomno['grcid']."','".$fromroomno['roomgrcid']."','".$fromroomno['RoomType']."','".date("Y-m-d",strtotime($fromDate)) ."','".$fromtime ."','".date("Y-m-d",strtotime($toDate))."','".$totime."','ROOM BLOCK RELEASE')";
	$exe1 = $this->db->query($rsdetqry1);



		}

		
    $check = "SELECT tb.fromdate, mr.roomtype_id AS typeid, tb.todate ,tb.roomgrcid
              FROM Trans_blockmas tb 
              INNER JOIN mas_room room ON room.room_id = tb.roomid
              INNER JOIN mas_roomtype mr ON mr.roomtype_id = room.roomtype_id
             where tb.blockid= IDENT_CURRENT('Trans_blockmas')";

    $checkqry = $this->db->query($check);
    foreach ($checkqry->result_array() as $ress) {


        $cid = $ress['fromdate'];
        $typeid = $ress['typeid'];
        $expcdate = $ress['todate'];
      
    }
	


    $aa_date = date_create($cid);
    $l_date = date_create($expcdate);
    $diff = date_diff($aa_date, $l_date);
    $difference = $diff->format("%a");

	
	for ($i = 0; $i <= $difference; $i++) {
	
		$val = "exec roomavailability_validation '".$cid."','".$typeid."'";
		
		
		$validationResult = $this->db->query($val);
		$this->db->close();
		$this->db->reconnect();


		if ($validationResult) {
		
			$insR = "exec Update_RoomAvailability   '" . $cid . "', '" . $typeid . "'";
			
			$execute = $this->db->query($insR);
			$this->db->close();
			$this->db->reconnect();
		}
		
	
		$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
		

	}


	// echo "BEGIN Try ";
	// 	echo "BEGIN Transaction ";
	// 	echo "BEGIN Tran ";
	// 	echo "Declare @Siden INT; ";
	// 	echo $qry1;			
	// 	echo $Up;
	// 	echo $insR;	
	// 	echo "set @Siden=@@identity; ";	   
	// 	echo " If @@error<>0 Rollback Tran else Commit Tran ";
	// 	echo "COMMIT ";
	// 	echo "end try ";
	// 	echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
	// 	echo "END CATCH ";


		// $sqc = ob_get_clean();
		// $qry=$sqc;
		// $res=$this->db->query($qry);
		// $msg=$this->db->error(); 
		$output = array();
		 $output['Success']=true;
 		 $output['MSG']="Room Status Changed";		 
		 print_r(json_encode($output));
		// $this->Myclass->GetRec($msg,$res,$qry);  
	 
	}
}
?>