<?php

class GuestType extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function GuestType_Val()
	{
		 $this->form_validation->set_rules('GuestType', 'GuestType', 'required');
		 
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
	function GuestType_exec()
	{
		 if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_GuestType '".$_REQUEST['GuestType']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This GuestType Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
			$qry= " Exec_GuestType '".$_REQUEST['GuestType']."',
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
			$qry= " Exec_GuestType '".$_REQUEST['GuestType']."',
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