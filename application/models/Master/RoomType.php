<?php

class RoomType extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function RoomType_Val()
	{
		 $this->form_validation->set_rules('RoomType', 'RoomType', 'required');
		 

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
	function RoomType_exec()
	{   if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_RoomType '".$_REQUEST['RoomType']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This RoomType Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
			if($_REQUEST['bedcount'] > 0){
				if($_REQUEST['bedamt'] <= 0)
				{
                $output = array();
		 $output['Success']=true;
 		 $output['MSG']="Please Enter Extra Bed Amount";		 
		 print_r(json_encode($output));
		 exit;
			}
		}
			$config['upload_path']=spath."upload";
			$config['allowed_types']='gif|jpg|png';
			$this->load->library('upload',$config);
			//if($this->upload->do_upload("file")){
			
		
		
			 $qry= " Exec_RoomType '".$_REQUEST['RoomType']."',
			'".$_REQUEST['otaroomtypecode']."',
			".Hotel_Id.",
			'".$_REQUEST['PrintingName']."',
			'".$_REQUEST['occupency']."',
			'".$_REQUEST['bedcount']."',
			'".$_REQUEST['bedamt']."',
			'".$_REQUEST['OrderBy']."',
			'".$_REQUEST['Active']."','".rand().rand()."',
			'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
				
			//}
	     }
		}
		else{
			if($_REQUEST['bedcount'] > 0){
				if($_REQUEST['bedamt'] <= 0)
				{
                $output = array();
		 $output['Success']=true;
 		 $output['MSG']="Please Enter Extra Bed Amount";		 
		 print_r(json_encode($output));
		 exit;
			}
		}
			$config['upload_path']=spath."upload";
			$config['allowed_types']='gif|jpg|png';
			$this->load->library('upload',$config);
			//if($this->upload->do_upload("file")){
			
		
		
			 $qry= " Exec_RoomType '".$_REQUEST['RoomType']."',
			 '".$_REQUEST['otaroomtypecode']."',
			".Hotel_Id.",
			'".$_REQUEST['PrintingName']."',
			
			'".$_REQUEST['occupency']."',
			'".$_REQUEST['bedcount']."',
			'".$_REQUEST['bedamt']."',
			'".$_REQUEST['OrderBy']."',
			'".$_REQUEST['Active']."','".rand().rand()."',
			'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
				
			//}
		}
	}
}
?>