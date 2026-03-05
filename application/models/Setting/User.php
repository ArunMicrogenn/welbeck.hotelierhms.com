<?php

class User extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    } 
	function User_Val()
	{
		  $this->form_validation->set_rules('EmailId', 'User Name', 'required');
		  $this->form_validation->set_rules('Password', 'Password', 'required');
		  $this->form_validation->set_rules('CPassword', 'Confirm Password', 'required');
		  $this->form_validation->set_rules('UserGroup_Id', 'User Group', 'required');
		 
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
	function User_exec()
	{ 
       if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_User '".$_REQUEST['EmailId']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
			$output = array();
			$output['Success']=true;
 		 	$output['MSG']="This User Name Already Have";		 
		 	print_r(json_encode($output));
		 }
		 else
	     {
		 	$qry= " Exec_User '".$_REQUEST['EmailId']."','".$_REQUEST['InActive']."','".$_REQUEST['UserGroup_Id']."','".base64_encode($_REQUEST['Password'])."',".Hotel_Id.",'".@$_REQUEST['idv']."','".$_REQUEST['Disper']."','".$_REQUEST['DisAmt']."','".str_replace(" ","",$_REQUEST['BUT'])."','".$_REQUEST['GraceHours']."'";
			$res=$this->db->query($qry);
		 	$msg=$this->db->error(); 
		 	$this->Myclass->GetRec($msg,$res,$qry);
		 }
	   }
	   else
	   {
		$qry= " Exec_User '".$_REQUEST['EmailId']."','".$_REQUEST['InActive']."','".$_REQUEST['UserGroup_Id']."','".base64_encode($_REQUEST['Password'])."',".Hotel_Id.",'".@$_REQUEST['idv']."','".$_REQUEST['Disper']."','".$_REQUEST['DisAmt']."','".str_replace(" ","",$_REQUEST['BUT'])."','".$_REQUEST['GraceHours']."'";
		 $res=$this->db->query($qry);
		 $msg=$this->db->error(); 
		 $this->Myclass->GetRec($msg,$res,$qry);
	   }
	}
}
?>