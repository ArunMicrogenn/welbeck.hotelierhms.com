<?php

class RatePlan extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function RatePlan_Val()
	{
		 $this->form_validation->set_rules('RoomType_Id', 'RoomType', 'required');
		 $this->form_validation->set_rules('PlanType_Id', 'PlanType', 'required');
		 $this->form_validation->set_rules('DPlanType_Id', 'PlanType', 'required');
				 
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
	function RatePlan_exec()
	{
		$TariffIncOfTaxes=0;$TariffIncOfPlan=0;$PlanIncTax=0; 
		if(@isset($_POST['TariffIncOfTaxes']))       { $TariffIncOfTaxes=1; }
		if(@isset($_POST['TariffIncOfPlan']))       { $TariffIncOfPlan=1; }
		if(@isset($_POST['PlanIncTax']))        { $PlanIncTax=1; }
		$Mon=0;$Tue=0;$Wed=0;$Thu=0;$Fri=0;$Sat=0;$Sun=0;
		if(@isset($_POST['Mon']))        { $Mon=1; }
		if(@isset($_POST['Tue']))        { $Tue=1; }
		if(@isset($_POST['Wed']))        { $Wed=1; }
		if(@isset($_POST['Thu']))        { $Thu=1; }
		if(@isset($_POST['Fri']))        { $Fri=1; }
		if(@isset($_POST['Sat']))        { $Sat=1; }
		if(@isset($_POST['Sun']))        { $Sun=1; }
	 
	 
	 	  $qry= " Exec_RatePlan 
		'".$_REQUEST['RoomType_Id']."',
		'".$_REQUEST['Otaratecode']."',
		'".$_REQUEST['Otapaymentpolicycode']."',
		'".$_REQUEST['Otacancelcode']."',
		'".$_REQUEST['isota']."',
		'".$_REQUEST['PlanType_Id']."',
		'".$_REQUEST['DPlanType_Id']."',
		'".$TariffIncOfTaxes."','".$TariffIncOfPlan."','".$PlanIncTax."',
		'".$Mon."',
		'".$Tue."',
		'".$Wed."',	
		'".$Thu."',
		'".$Fri."',
		'".$Sat."',
		'".$Sun."',
		".Hotel_Id.",".User_id.",'".@$_REQUEST['Keey']."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);

		

		$msg=$this->db->error(); 
	    $this->Myclass->GetRec($msg,$res,$qry);
	}
}
?>