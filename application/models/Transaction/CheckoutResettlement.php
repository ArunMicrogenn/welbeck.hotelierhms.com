<?php

class CheckoutResettlement extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function CheckoutResettlement_Val()
	{
		 $this->form_validation->set_rules('RoomNo', 'RoomNo', 'required');
		 $this->form_validation->set_rules('totalamount', 'totalamount', 'required');
		//$this->form_validation->set_rules('paymode', 'paymode', 'required');
		 /*if($this->input->post('paymode') !='1')
		 {
			$this->form_validation->set_rules('cardnumber', 'cardnumber', 'required');
			$this->form_validation->set_rules('bank', 'bank', 'required');
			$this->form_validation->set_rules('validate', 'validate', 'required');
		 } */
		 if($this->form_validation->run() == FALSE)
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
	function CheckoutResettlement_exec()
	{
		if($_REQUEST['BUT'] =='SAVE')
		{   
			$delete="delete Trans_Pay_Det where Checkoutid='".$_REQUEST['idv']."'";
			$res=$this->db->query($delete);
			for($i=0; $i<$_REQUEST['counts']; $i++)
			{				
				//	echo $_REQUEST['cardno'][1];
				if(@$_REQUEST['Amt'][$i])
				{
				$ins="insert into Trans_Pay_Det (Checkoutid,Paymodeid,Bankid,Amount,ChqNo,Validdate,Paidamount,receiptid,userid)
					values('".$_REQUEST['idv']."','".$_REQUEST['paymode'][$i]."','".@$_REQUEST['bank'][$i]."','".$_REQUEST['Amt'][$i]."','".@$_REQUEST['cardno'][$i]."','".date('Y-m-d', strtotime($_REQUEST['validate'][$i]))."','".$_REQUEST['Amt'][$i]."','".$_REQUEST['receiptid']."','".User_id."')";
					$res=$this->db->query($ins);
				}
			}			
			$output = array();
			$output['Success']=true;
			$output['MSG']="Checkout Resettlement Successfully";		 
			print_r(json_encode($output));
		}
	  /*
			$qry="Update Trans_Receipt_mas set paymodeid='".$_REQUEST['paymode']."',bank='".$_REQUEST['bank']."',cardnumber='".$_REQUEST['cardnumber']."',validdate='".$_REQUEST['validate']."',edituserid=".Hotel_Id." where Receiptid='".$_REQUEST['idv']."'";		
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			//$this->Myclass->GetRec($msg,$res,$qry);
			$output = array();
			$output['Success']=true;
			 $output['MSG']="Advance Resettlement Successfully";		 
			print_r(json_encode($output));
	     
		}
	   else
	   {
		  $qry= " Exec_Facility '".$_REQUEST['Facility']."',".Hotel_Id.",'".$_REQUEST['Active']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry); 
	   } */
	}
}
?>