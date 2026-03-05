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
		// $this->form_validation->set_rules('Address1', 'Address1', 'required');
		 $this->form_validation->set_rules('Mobile', 'Mobile', 'required');
		 $this->form_validation->set_rules('City', 'City', 'required');
		 
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
	{  if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_Customer '".$_REQUEST['Mobile']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This Mobile Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
       $DOB=date('Y-m-d', strtotime($_REQUEST['DOB']));
		$qry= " Exec_Customer 
		'".$_REQUEST['FirstName']."',
        '".$_REQUEST['Titel']."',
        '".$_REQUEST['LastName']."',
		'".$_REQUEST['Address1']."',
        '".$_REQUEST['Address2']."',
        '".$_REQUEST['Address3']."',
		'".$_REQUEST['Mobile']."',
        '".$_REQUEST['Phone']."',
		'".$_REQUEST['Email']."',
		'".$_REQUEST['City_id']."',
		'".$_REQUEST['Company_Id']."',
		'".$_REQUEST['Company']."',
		'".$DOB."',
		'".$_REQUEST['State_id']."',
		'".$_REQUEST['Country_id']."',
		'".$_REQUEST['PINCode']."',
		'".$_REQUEST['Active']."',
		'".User_id."',
		'".Hotel_Id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
	   }}
	   else
	   {
		$DOB=date('Y-m-d', strtotime($_REQUEST['DOB']));
		$qry= " Exec_Customer 
		'".$_REQUEST['FirstName']."',
        '".$_REQUEST['Titel']."',
        '".$_REQUEST['LastName']."',
		'".$_REQUEST['Address1']."',
        '".$_REQUEST['Address2']."',
        '".$_REQUEST['Address3']."',
		'".$_REQUEST['Mobile']."',
        '".$_REQUEST['Phone']."',
		'".$_REQUEST['Email']."',
		'".$_REQUEST['City_id']."',
		'".$_REQUEST['Company_Id']."',
		'".$_REQUEST['Company']."',
		'".$DOB."',
		'".$_REQUEST['State_id']."',
		'".$_REQUEST['Country_id']."',
		'".$_REQUEST['PINCode']."',
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