<?php

class NightAuditReversal extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function NightAuditReversal_Val()
	{  	
			
         $this->form_validation->set_rules('Remark', 'Remark', 'required');		 
		 
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
	function NightAuditReversal_exec()
	{
	   $sql="select DateofAudit,* from night_audit";
	   $res=$this->db->query($sql);
	   foreach ($res->result_array() as $row)
	   { $auditdate=$row['DateofAudit']; }
		$creditdate=date('Y-m-d',strtotime($auditdate.'-1 days'));
	   if($_REQUEST['reversaldate'] ==$creditdate)
	   {	
		$bool=true;
        $Res=$this->Myclass->Get_NightAuditrooms();
		  foreach($Res as $row)
		  {
			$up="update Trans_roomdet_det_rent set nightauditcompleted=0 where roomgrcid='".$row['roomgrcid']."' and grcid='".$row['grcid']."' and Rentdate='".$creditdate."'";
		    $resup=$this->db->query($up);
		  }
		    $sql1="select * from Trans_Credit_Entry where isnull(fromnightaudit,0)=1 and CreditDate='".$creditdate."'";
			$res1=$this->db->query($sql1);	
			$norow= $res1->num_rows();
			if($norow != 0)
			{
				/*foreach ($res1->result_array() as $row1)
				{
				 $logins="insert into Trans_Credit_Entry_log (Credid,CreditNo,Roomid,Grcid,CreditDate,Creditheadid,Amount,roomgrcid,otherAmount,tarrifftype,tarriffsetupid,UserID,Ratetypeid,Editdate,edituserid,Edittime) values ('".$row1['Credid']."','".$row1['CreditNo']."','".$row1['Roomid']."','".$row1['Grcid']."','".$row1['CreditDate']."','".$row1['Creditheadid']."','".$row1['Amount']."','".$row1['roomgrcid']."','".$row1['otherAmount']."','".$row1['tarrifftype']."','".$row1['tarriffsetupid']."','".$row1['UserID']."','".$row1['Ratetypeid']."','".$date."','".User_id."','".$time."')";	
				 $resi=$this->db->query($logins);
				 $del="delete from Trans_credit_entry where  Credid='".$row1['Credid']."'";	
				 $resdel=$this->db->query($del);		 
				}*/
			}
		 
			$qry= " Update_Audit_date '".$creditdate."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);		
	   }
	   else
	   {
		   $qry= "SELECT 'Successfully Updated' AS MGS";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);	
	   }
	   
	}
}
?>