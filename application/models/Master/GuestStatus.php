<?php

class GuestStatus extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function GuestStatus_Val()
	{
		 $this->form_validation->set_rules('GuestStatus', 'GuestStatus', 'required');
		 
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
	function GuestStatus_exec()
	{   if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_GuestStatus '".$_REQUEST['GuestStatus']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This GuestStatus Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
		$qry= " Exec_GuestStatus '".$_REQUEST['GuestStatus']."',
		'".$_REQUEST['Active']."',
		'".User_id."',
		'".Hotel_Id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
	   }}else
	   {
		 $qry= " Exec_GuestStatus '".$_REQUEST['GuestStatus']."',
		'".$_REQUEST['Active']."',
		'".User_id."',
		'".Hotel_Id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);  
	   }
	}
}
?>