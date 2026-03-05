<?php

class PostBill extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function PostBill_Val()
	{
		 $this->form_validation->set_rules('roomid', 'Room No', 'required');
		 $this->form_validation->set_rules('ReceiptNo', 'ReceiptNo', 'required');
		 $this->form_validation->set_rules('Guest', 'Guest Name', 'required');
		 $this->form_validation->set_rules('Amount', 'Amount', 'required');
		 $this->form_validation->set_rules('RevenueHead', 'RevenueHead', 'required');
	
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
	function PostBill_exec()
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
		
			$qry="exec Exec_PostBill '".$_REQUEST['roomid']."' ,'".$_REQUEST['Amount']."','".date('Y-m-d')."',".User_id.",'".$_REQUEST['Remark']."','".$_REQUEST['RevenueHead']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."' ";	  
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry); 		

		 }
		}else
	   {
	     	$qry="exec Exec_PostBill '".$_REQUEST['roomid']."' ,'".$_REQUEST['Amount']."','".date('Y-m-d')."',".User_id.",'".$_REQUEST['Remark']."','".$_REQUEST['RevenueHead']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."' ";	  
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry); 		
	   }
	}
}
?>