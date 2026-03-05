<?php

class Revenue extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function Revenue_Val()
	{
		 $this->form_validation->set_rules('RevenueHead', 'RevenueHead', 'required');
		 $this->form_validation->set_rules('RevenueShortName', 'RevenueShortName', 'required');
		 $this->form_validation->set_rules('RevenueGroup_Id', 'RevenueGroup_Id', 'required');
		 $this->form_validation->set_rules('Taxhead', 'Taxhead', 'required');
		 $this->form_validation->set_rules('Slabbased', 'Slabbased', 'required');
		 $this->form_validation->set_rules('OrderBy', 'Order By', 'required');
		 $this->form_validation->set_rules('HSNSAC_Code', 'HSNSAC_Code', 'required');
		 
		 
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
	function Revenue_exec()
	{
		if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_RevenueHead '".$_REQUEST['RevenueHead']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This RevenueHead Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
		 $Allowance=0; $ApplicableForPostBill=0;
		if(@isset($_POST['Allowance'])){ $Allowance=1; }
		if(@isset($_POST['ApplicableForPostBill'])){ $ApplicableForPostBill=1; }
		  $qry= " Exec_Revenue '".$_REQUEST['RevenueHead']."',
		'".$_REQUEST['RevenueShortName']."',
		'".$_REQUEST['RevenueGroup_Id']."',
		'".$_REQUEST['Taxhead']."',
		'".$_REQUEST['Slabbased']."',		
		'".$_REQUEST['HSNSAC_Code']."',
		'".$_REQUEST['RevenueNature']."',
		'".$_REQUEST['Active']."',
		'".@$_REQUEST['BillGroup_Id']."',
		'".@$_REQUEST['OrderBy']."',
		'".$Allowance."','".$ApplicableForPostBill."',		
		'".Hotel_Id."','".User_id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
	   }
	   } 
	   else
	   {
		    $Allowance=0;$ApplicableForPostBill=0;
		if(@isset($_POST['Allowance']))       { $Allowance=1; }
		if(@isset($_POST['ApplicableForPostBill'])){ $ApplicableForPostBill=1; }
		  $qry= " Exec_Revenue '".$_REQUEST['RevenueHead']."',
		'".$_REQUEST['RevenueShortName']."',
		'".$_REQUEST['RevenueGroup_Id']."',
		'".$_REQUEST['Taxhead']."',
		'".$_REQUEST['Slabbased']."',		
		'".$_REQUEST['HSNSAC_Code']."',
		'".$_REQUEST['RevenueNature']."',
		'".$_REQUEST['Active']."',
		'".@$_REQUEST['BillGroup_Id']."',
		'".@$_REQUEST['OrderBy']."',
		'".$Allowance."','".$ApplicableForPostBill."',			
		'".Hotel_Id."','".User_id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);  
	   }
	}
}
?>