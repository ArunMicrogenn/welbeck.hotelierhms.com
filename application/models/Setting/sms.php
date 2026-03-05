<?php

class sms extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function sms_Val()
	{
		 $this->form_validation->set_rules('APIURL', 'APIURL', 'required');
		 $this->form_validation->set_rules('APIKEY', 'APIKEY', 'required');
		 $this->form_validation->set_rules('SENDERID', 'SENDERID', 'required');
		 $this->form_validation->set_rules('CHANNEL', 'CHANNEL', 'required');
		 $this->form_validation->set_rules('ROUTE', 'ROUTE', 'required');
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
	function sms_exec()
	{
		 $qry= " Exec_SMSAPI 
					  '".$_REQUEST['APIURL']."',					  
					  '".$_REQUEST['APIKEY']."',					  
					  '".$_REQUEST['SENDERID']."',
					  '".$_REQUEST['CHANNEL']."',
					  '".$_REQUEST['ROUTE']."',
					  '".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
					  $res=$this->db->query($qry);
					  $msg=$this->db->error(); 
					  $this->Myclass->GetRec($msg,$res,$qry);
	}
}
?>