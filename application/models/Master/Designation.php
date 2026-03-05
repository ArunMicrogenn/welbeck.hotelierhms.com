<?php

class Designation extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function Designation_Val()
	{
		 $this->form_validation->set_rules('Designation', 'Designation', 'required');
		$this->form_validation->set_rules('Department', 'Department', 'required');
		 
				 
		// $this->form_validation->set_rules('SCCB','SCCB','trim|required|xss_clean|greater_than[0]');
		 
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
	function Designation_exec()
	{ if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_Designation '".$_REQUEST['Designation']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This Designation Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
			 
		 $qry= " Exec_Designation
		 '".$_REQUEST['Designation']."',
		 '".$_REQUEST['Department']."',
		 '".$_REQUEST['Active']."', 
		 ".Hotel_Id.",
		 '".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		 $res=$this->db->query($qry);
		 $msg=$this->db->error(); 
		 $this->Myclass->GetRec($msg,$res,$qry);
	     }
	   }
	   else{
		   $qry= " Exec_Designation
		 '".$_REQUEST['Designation']."',
		 '".$_REQUEST['Department']."',
		 '".$_REQUEST['Active']."', 
		 ".Hotel_Id.",
		 '".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		 $res=$this->db->query($qry);
		 $msg=$this->db->error(); 
		 $this->Myclass->GetRec($msg,$res,$qry);
	   }
	}
}
?>