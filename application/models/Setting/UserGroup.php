<?php

class UserGroup extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function UserGroup_Val()
	{
		 $this->form_validation->set_rules('UserGroup', 'UserGroup', 'required');
		  
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
	function UserGroup_exec()
	{
		 $qry= " Exec_UserGroup 
					  '".$_REQUEST['UserGroup']."'					  
					  ,".Hotel_Id.",".User_id.",
					  '".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
					  $res=$this->db->query($qry);
					  $msg=$this->db->error(); 
					  $this->Myclass->GetRec($msg,$res,$qry);
	}
}
?>