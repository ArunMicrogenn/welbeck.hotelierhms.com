<?php

class BusinessSource extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function BusinessSource_Val()
	{
		 $this->form_validation->set_rules('BusinessSource', 'BusinessSource', 'required');
		 
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
	function BusinessSource_exec()
	{
		 if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_BusinessSource '".$_REQUEST['BusinessSource']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This BusinessSource Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
		$qry= " Exec_BusinessSource '".$_REQUEST['BusinessSource']."',
		'".$_REQUEST['Active']."',
		'".User_id."',
		'".Hotel_Id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
	   }
	   }
	   else
	   {
		 $qry= " Exec_BusinessSource '".$_REQUEST['BusinessSource']."',
		'".$_REQUEST['Active']."',
		'".User_id."',
		'".Hotel_Id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);  
	   }
	}
}
?>