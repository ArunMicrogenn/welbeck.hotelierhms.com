<?php

class CashBook extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function CashBook_Val()
	{
        
		$this->form_validation->set_rules('Head', 'Head', 'required');
		$this->form_validation->set_rules('amount', 'amount', 'required');
		$this->form_validation->set_rules('Remark', 'Remark', 'required');
		 
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

	//  function CashBook_Exec()
	// {
    //     $qry = "exec CASHBOOK__ENTRY '".$_REQUEST['amount']."','".date('Y-m-d')."',
	// 	'".User_id."','".$_REQUEST['Remark']."', '".$_REQUEST['Head']."'";
	// 	$res=$this->db->query($qry);
	//  		$msg=$this->db->error(); 
	//  		$this->Myclass->GetRec($msg,$res,$qry);
	
	// }
	
}
?>