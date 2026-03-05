<?php

class Customers extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function Customer_Val()
	{
		 $this->form_validation->set_rules('FirstName', 'FirstName', 'required');
		 //$this->form_validation->set_rules('LastName', 'LastName', 'required');
		 //$this->form_validation->set_rules('State', 'State', 'required');
		 //$this->form_validation->set_rules('City', 'City', 'required');
		 //$this->form_validation->set_rules('Address1', 'Address1', 'required');
		// $this->form_validation->set_rules('Mobile', 'Mobile', 'required');
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
	function Customer_exec()
	{
	echo	$qry= " Exec_Customer 
		'".$_REQUEST['FirstName']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
	}
}
?>