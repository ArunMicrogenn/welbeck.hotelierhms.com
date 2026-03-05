<?php

class DateChange extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function DateChange_Val()
	{  	
			 $output = $this->form_validation->return_success($this->input->post());
			 echo $output = json_encode($output);
		
	}
	function DateChange_exec()
	{
		if($_REQUEST['BUT'] =='Done')
	   {	
        $sql="select DateofAudit,* from night_audit";
	    $res=$this->db->query($sql);
	    foreach ($res->result_array() as $row)
		{ $auditdate=$row['DateofAudit']; } 	  
		$update="update Trans_Reserve_det set Noshows=1 where fromdate='".$auditdate."' and isnull(stat,'')='' ";
		$res=$this->db->query($update);
		$update="delete Temp_Trans_Credit_Entry where CreditDate='".$auditdate."' ";
		$res=$this->db->query($update);
		$creditdate=date('Y-m-d',strtotime($auditdate.'+1 days'));
		$bool=true;
        $Res=$this->Myclass->Get_NightAuditrooms();
		  foreach($Res as $row)
		  {
			$up="update Trans_roomdet_det_rent set nightauditcompleted=1 where roomgrcid='".$row['roomgrcid']."' and grcid='".$row['grcid']."' and Rentdate='".$auditdate."'";
		    $resup=$this->db->query($up);
		  }
		
			$qry= " Update_Audit_date '".$creditdate."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
		
	   }
	   
	}
}
?>