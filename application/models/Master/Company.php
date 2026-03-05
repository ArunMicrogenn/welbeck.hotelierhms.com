<?php

class Company extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function Company_Val()
	{

	
		 $this->form_validation->set_rules('Company', 'Company', 'required');
		 $this->form_validation->set_rules('City', 'City', 'required');
		 $this->form_validation->set_rules('City_id', 'City', 'required');		 
		 $this->form_validation->set_rules('CompanyType_Id', 'CompanyType', 'required');
		 $this->form_validation->set_rules('Zipcode', 'Zipcode', 'required');


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

	function Company_exec()
	{
		if($_REQUEST['BUT'] =='SAVE')
	   {
		
	
	        $qry1= "Exec Validate_Company'".$_REQUEST['Company']."'";
		 $res1=$this->db->query($qry1)->row_array();
		

		 if($_REQUEST['Gstno'] != ''){
			   $gstqry= "Exec Validate_company_gst'".$_REQUEST['Gstno']."'";
			$gst=$this->db->query($gstqry)->row_array();
			
		 }




		 if($_REQUEST['Gstno'] == '')
		 {

		 $output['Success']=true;
		  $output['MSG']=" Please Enter Gst Number";		 
		  echo json_encode($output);
		  exit;
		 }

		

		 
		 if($_REQUEST['Zipcode'] == '')
		 {

		 $output['Success']=true;
		  $output['MSG']=" Please Enter Zip Code";		 
		  echo json_encode($output);
		  exit;
		 }


	
		 
		  if($res1['cnt'] != 0)
		 {
				$output['Success'] = true;
				$output['MSG'] = "Company Already Exists";
				echo json_encode($output);
				exit;
	
		 }	

	
		 
		 if($gst['cnt'] != 0)
		 {
	
		 $output['Success']=true;
		  $output['MSG']=" GstNo Already Exists";		 
		  echo json_encode($output);
		  exit;
		 }


	
		
		 if($res1['cnt'] == 0 && $gst['cnt'] == 0 )
	     {
			  $qry= " exec Exec_Company 
			'".$_REQUEST['Company']."',
			'".$_REQUEST['Company_Shortname']."',
			'".$_REQUEST['Address1']."',
			'".$_REQUEST['Address2']."',
			'".$_REQUEST['Address3']."',
			'".$_REQUEST['City_id']."',
			'".$_REQUEST['State_id']."',
			'".$_REQUEST['Country_id']."',
			'".$_REQUEST['Zipcode']."',
			'".$_REQUEST['Ota']."',
			'".$_REQUEST['Phoneno']."',
			'".$_REQUEST['Fax']."',
			'".$_REQUEST['E_mail']."',
			'".$_REQUEST['Cotactperson']."',
			'".$_REQUEST['Contactno']."',
			'".$_REQUEST['Designation']."',
			'".$_REQUEST['com_email']."',
			'".$_REQUEST['GstType_Id']."',
			'".$_REQUEST['Gstno']."',
			'".$_REQUEST['CreditLimit']."',
			'".$_REQUEST['Creditdays']."',
			'".$_REQUEST['Remarks']."',
			'".$_REQUEST['CompanyType_Id']."',
			'".$_REQUEST['Commissionper']."',
			'".$_REQUEST['Commissiontaxper']."',
			'".$_REQUEST['checkintime']."',
			'".$_REQUEST['checkouttime']."',
			'".@$_REQUEST['CompanyGroup_Id']."',
			'".@$_REQUEST['MarketSegment_Id']."',
			'".@$_REQUEST['BusinessSource_Id']."',
			'".@$_REQUEST['PayMode_Id']."',
			'".@$_REQUEST['ReservationMode_Id']."',
			'0',
			'".Hotel_Id."',
			'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
		 }
	   }
	   else
	   {
		   $qry= "exec Exec_Company 
		'".$_REQUEST['Company']."',
		'".$_REQUEST['Company_Shortname']."',
		'".$_REQUEST['Address1']."',
		'".$_REQUEST['Address2']."',
		'".$_REQUEST['Address3']."',
		'".$_REQUEST['City_id']."',
		'".$_REQUEST['State_id']."',
		'".$_REQUEST['Country_id']."',
		'".$_REQUEST['Zipcode']."',
		'".$_REQUEST['Ota']."',
		'".$_REQUEST['Phoneno']."',
		'".$_REQUEST['Fax']."',
		'".$_REQUEST['E_mail']."',
		'".$_REQUEST['Cotactperson']."',
		'".$_REQUEST['Contactno']."',
		'".$_REQUEST['Designation']."',
		'".$_REQUEST['com_email']."',
		'".$_REQUEST['GstType_Id']."',
		'".$_REQUEST['Gstno']."',
		'".$_REQUEST['CreditLimit']."',
		'".$_REQUEST['Creditdays']."',
		'".$_REQUEST['Remarks']."',
		'".@$_REQUEST['CompanyType_Id']."',
		'".$_REQUEST['Commissionper']."',
		'".$_REQUEST['Commissiontaxper']."',
		'".$_REQUEST['checkintime']."',
		'".$_REQUEST['checkouttime']."',
		'".@$_REQUEST['CompanyGroup_Id']."',
		'".@$_REQUEST['MarketSegment_Id']."',
		'".@$_REQUEST['BusinessSource_Id']."',
		'".@$_REQUEST['PayMode_Id']."',
		'".@$_REQUEST['ReservationMode_Id']."',
		'0',
		'".Hotel_Id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
	   }
	}
}
?>