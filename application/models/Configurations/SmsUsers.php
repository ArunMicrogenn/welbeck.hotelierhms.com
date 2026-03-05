<?php

class SmsUsers extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function SmsUsers_Val()
	{
		  $this->form_validation->set_rules('Username', 'User Name', 'required');
		  $this->form_validation->set_rules('mobile', 'Mobile Number', 'required');
		  $this->form_validation->set_rules('InActive', 'User Type', 'required');
		  
		 
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
	function SmsUsers_exec()
	{ 
       if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_User '".$_REQUEST['Username']."'";
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
		 	$qry= " Exec_Smsusers '".$_REQUEST['Username']."','".$_REQUEST['type']."','".$_REQUEST['InActive']."','".$_REQUEST['mobile']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
		 	$msg=$this->db->error(); 
		 	$this->Myclass->GetRec($msg,$res,$qry);
		 }
	   }
	   else
	   {
		$qry= " Exec_Smsusers '".$_REQUEST['Username']."','".$_REQUEST['type']."','".$_REQUEST['InActive']."','".$_REQUEST['mobile']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
        $res=$this->db->query($qry);
        $msg=$this->db->error(); 
		 $this->Myclass->GetRec($msg,$res,$qry);
	   }
	}
}
?>