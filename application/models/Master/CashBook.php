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

	 function CashBook_Exec()
	{


		
        $qry = "exec CASHBOOK__ENTRY '".$_REQUEST['amount']."','".date('Y-m-d')."',
		'".User_id."','".$_REQUEST['Remark']."', '".$_REQUEST['Head']."'";
		$res=$this->db->query($qry);
	 		$msg=$this->db->error(); 
	 		$this->Myclass->GetRec($msg,$res,$qry);
			
		

		
	 	// if($_REQUEST['BUT'] =='SAVE')
	    // {		   
	    //   $qry= "select * from accname where Accname= '".$_REQUEST['ledgername']."'";
	 	//  $res=$this->db->query($qry);
	 	//  $a= $res->num_rows();
	 	//  if($a !=0)
	 	//  {
	 	//  $output = array();
	 	//  $output['Success']=true;
 	 	//  $output['MSG']="This Acc.Name Already Have";		 
	 	//  print_r(json_encode($output));
	 	//  }
	 	//  else
	    //   {
	 	// 	 $qry= " Exec Exec_accname '".$_REQUEST['ledgername']."',
	 	// 	'".$_REQUEST['Active']."',
	 	// 	'".$_REQUEST['Creditordebit']."',
	 	// 	'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
	 	// 	$res=$this->db->query($qry);
	 	// 	$msg=$this->db->error(); 
	 	// 	$this->Myclass->GetRec($msg,$res,$qry);
	 	//  }
	 	//  } else
	 	//  {
	 	// 	  $qry= " Exec Exec_accname '".$_REQUEST['ledgername']."',
	 	// 	'".$_REQUEST['Active']."',
	 	// 	'".$_REQUEST['Creditordebit']."',
	 	// 	'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
	 	// 	$res=$this->db->query($qry);
	 	// 	$msg=$this->db->error(); 
	 	// 	$this->Myclass->GetRec($msg,$res,$qry);
	 	//  }
	}


	
	
}
?>