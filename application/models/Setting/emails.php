<?php

class emails extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function emails_Val()
	{
		 $this->form_validation->set_rules('EMAIL', 'EMAIL', 'required');
		 $this->form_validation->set_rules('SERVERNAME', 'SERVERNAME', 'required');
		 $this->form_validation->set_rules('PORT', 'PORT', 'required');
		 $this->form_validation->set_rules('USERNAME', 'USERNAME', 'required');
		 $this->form_validation->set_rules('PASSWORD', 'PASSWORD', 'required');
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
	function emails_exec()
	{
		$qry= " Exec_SMTP 
					  '".$_REQUEST['EMAIL']."',					  
					  '".$_REQUEST['SERVERNAME']."',					  
					  '".$_REQUEST['PORT']."',
					  '".$_REQUEST['USERNAME']."',
					  '".$_REQUEST['PASSWORD']."','".$_REQUEST['SECURITY']."',
					  '".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
					  $res=$this->db->query($qry);
					  $msg=$this->db->error(); 
					  $this->Myclass->GetRec($msg,$res,$qry);
	}
}
?>