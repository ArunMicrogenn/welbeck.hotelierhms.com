<?php

class HotelProperty extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function HotelProperty_Val()
	{
		 $this->form_validation->set_rules('Company', 'Company', 'required');
		 $this->form_validation->set_rules('City', 'City', 'required');
		 $this->form_validation->set_rules('Address', 'Address', 'required');
		 $this->form_validation->set_rules('MobileNo', 'MobileNo', 'required');
			 
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
	function HotelProperty_exec()
	{   

		
	
	   $qry= "exec Update_Mas_Hotel '".$_REQUEST['Company']."','".$_REQUEST['Address']."','".$_REQUEST['Address1']."','".$_REQUEST['website']."','".$_REQUEST['City']."','".$_REQUEST['PinCode']."','".$_REQUEST['Email']."','".$_REQUEST['MobileNo']."','".$_REQUEST['Phone']."','".$_REQUEST['State']."','".$_REQUEST['gstnumber']."','".$_REQUEST['Country']."','".Hotel_Id."'";
	   $res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
		  
	}
}
?>