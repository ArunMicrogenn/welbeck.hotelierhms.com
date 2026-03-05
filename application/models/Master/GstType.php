<?php

class GstType extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function GstType_Val()
	{
		 $this->form_validation->set_rules('GstType', 'GstType', 'required');
		 
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
	function GstType_exec()
	{
		$qry= " Exec_GstType '".$_REQUEST['GstType']."',
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