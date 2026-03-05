<?php

class Country extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function Country_Val()
	{
		 $this->form_validation->set_rules('Country', 'Country', 'required');
		 
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
	function Country_exec()
	{
		$qry= "Exec_Country'".$_REQUEST['Country']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
	}
}
?>