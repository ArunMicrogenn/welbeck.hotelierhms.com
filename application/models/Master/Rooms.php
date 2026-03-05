<?php

class Rooms extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function Room_Val()
	{
		 $this->form_validation->set_rules('RoomNo', 'RoomNo', 'required');
		 $this->form_validation->set_rules('Floor_Id', 'Floor', 'required');
		 $this->form_validation->set_rules('Block_Id', 'Block', 'required');
		 $this->form_validation->set_rules('BedType_Id', 'BedType', 'required');
		 $this->form_validation->set_rules('RoomType_Id', 'BedType', 'required');
		 
		 // Validate that at least one facility is selected
		 if (!isset($_POST['FAC']) || empty($_POST['FAC'])) {
			 $output = array(
				 'Success' => false,
				 'Facility' => 'Please select at least one facility'
			 );
			 echo json_encode($output);
			 return;
		 }
		 
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
	function Room_exec()
	{
		$qry=" del_Room_Facility '".$_REQUEST['RoomNo']."'";
		$this->db->query($qry);
		
		$cou=count($_POST['FAC']);
		
		for($i=0;$i<$cou;$i++)
		{
			if(@$_REQUEST['FAC'][$i])
			{
				$qry=" Exec_Room_Facility '".$_REQUEST['RoomNo']."','".$_REQUEST['FAC'][$i]."',1";
				$this->db->query($qry);
			}
		}
		
		 if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_RoomNo '".$_REQUEST['RoomNo']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This RoomNo Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
			$qry= " Exec_Room 
			'".$_REQUEST['RoomNo']."',
			'".$_REQUEST['Floor_Id']."',
			'".$_REQUEST['Block_Id']."',
			'".$_REQUEST['BedType_Id']."',
			'".$_REQUEST['RoomType_Id']."',
			 
			".Hotel_Id.",".User_id.",'".$_REQUEST['Active']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
	     }
	   }
	   else
	   {
		 $qry= " Exec_Room 
			'".$_REQUEST['RoomNo']."',
			'".$_REQUEST['Floor_Id']."',
			'".$_REQUEST['Block_Id']."',
			'".$_REQUEST['BedType_Id']."',
			'".$_REQUEST['RoomType_Id']."',
			 
			".Hotel_Id.",".User_id.",'".$_REQUEST['Active']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);  
	   }
	}
}
?>