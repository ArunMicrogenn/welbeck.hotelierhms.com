<?php

class ReservationAdvanceRefund extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function ReservationAdvanceRefund_Val()
	{
		$this->form_validation->set_rules('roomid', 'Room No', 'required');
		$this->form_validation->set_rules('ReceiptNo', 'ReceiptNo', 'required');
		$this->form_validation->set_rules('Guest', 'Guest Name', 'required');
		$this->form_validation->set_rules('Amount', 'Amount', 'required');
		$this->form_validation->set_rules('paymode', 'Paymode', 'required');
		if($this->input->post('paymode') !='1' && $this->input->post('paymode') !='13')
		{
			$this->form_validation->set_rules('cardnumber', 'Card Number', 'required');
			$this->form_validation->set_rules('bank', 'Bank', 'required');
			$this->form_validation->set_rules('validate', 'Valid Date', 'required');
		}else if($this->input->post('paymode') =='13'){
		   $this->form_validation->set_rules('bank', 'Bank', 'required');
		}
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
	function ReservationAdvanceRefund_exec()
	{  if($_REQUEST['BUT'] =='SAVE')
	   {	
		 if($_REQUEST['Amount']=='0' || $_REQUEST['Amount']=='0.00' )	  
		 {
			$output = array();
			$output['Success']=true;
			$output['MSG']="Advance Amount Should not Allow Rs.0.00";		 
			print_r(json_encode($output));
		 } 	     
		 else
	     {
		
			$qry="exec Exec_ResAdvanceRefund '".$_REQUEST['roomid']."' ,'".$_REQUEST['Amount']."','".$_REQUEST['paymode']."','".date('Y-m-d')."','".@$_REQUEST['bank']."','".@$_REQUEST['cardnumber']."','".@$_REQUEST['validate']."',".User_id.",'".$_REQUEST['Remark']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."' ";	  
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry); 		

		 }
		}else
	   {
		$qry="exec Exec_ResAdvanceRefund '".$_REQUEST['roomid']."' ,'".$_REQUEST['Amount']."','".$_REQUEST['paymode']."','".date('Y-m-d')."','".@$_REQUEST['bank']."','".@$_REQUEST['cardnumber']."','".@$_REQUEST['validate']."',".User_id.",'".$_REQUEST['Remark']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."' ";	  
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry); 		
	   }
	}
}
?>