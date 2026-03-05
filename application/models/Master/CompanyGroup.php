<?php

class CompanyGroup extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function CompanyGroup_Val()
	{
		 $this->form_validation->set_rules('CompanyGroup', 'CompanyGroup', 'required');
		 
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
	function CompanyGroup_exec()
	{
		$qry= " Exec_CompanyGroup '".$_REQUEST['CompanyGroup']."',
		'".$_REQUEST['Address1']."',
		'".$_REQUEST['Address2']."',
		'".$_REQUEST['Mobile']."',
		'".$_REQUEST['Phone']."',
		'".$_REQUEST['Email']."',
		'".$_REQUEST['Active']."',
		'".User_id."',
		'".Hotel_Id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
	}
}
?>