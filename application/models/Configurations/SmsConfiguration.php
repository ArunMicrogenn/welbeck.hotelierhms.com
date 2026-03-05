<?php

class SmsConfiguration extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function SmsConfiguration_Val()
	{
		 $this->form_validation->set_rules('area', 'Text Are', 'required');
	
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
	function SmsConfiguration_exec()
	{  
		$qry="exec Exec_SmsMessage '".$_REQUEST['area']."' ,'".@$_REQUEST['idv']."','".@$_REQUEST['campaign']."','".str_replace(" ","",$_REQUEST['BUT'])."' ";	  
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry); 			
	   
	}
}
?>