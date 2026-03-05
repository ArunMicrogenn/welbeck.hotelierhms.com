<?php

class PayMode extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function PayMode_Val()
	{
		  $this->form_validation->set_rules('PayMode', 'PayMode', 'required');
		 
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
	function PayMode_exec()
	{ 
       if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_PayMode '".$_REQUEST['PayMode']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This PayMode Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
		 $qry= " Exec_PayMode '".$_REQUEST['PayMode']."','".$_REQUEST['InActive']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		 $res=$this->db->query($qry);
		 $msg=$this->db->error(); 
		 $this->Myclass->GetRec($msg,$res,$qry);
		 }
	   }
	   else
	   {
	    $qry= " Exec_PayMode '".$_REQUEST['PayMode']."','".$_REQUEST['InActive']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		 $res=$this->db->query($qry);
		 $msg=$this->db->error(); 
		 $this->Myclass->GetRec($msg,$res,$qry);
	   }
	}
}
?>