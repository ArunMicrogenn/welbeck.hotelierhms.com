<?php

class DataPurchaing extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function DataPurchaing_Val()
	{
		 $this->form_validation->set_rules('allmaster', 'allmaster', 'required');
			 
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
	function DataPurchaing_exec()
	{
		$qry= "exec Truncate_Transactions '".$_REQUEST['allmaster']."','".$_REQUEST['customer']."' ";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
		  
	}
	

}
?>