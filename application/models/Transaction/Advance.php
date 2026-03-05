<?php

class Advance extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }

	public function Advance_Val()
{
  $currentdate = date('Y-m-d');

    $this->form_validation->set_rules('roomid', 'Room No', 'required');
    $this->form_validation->set_rules('ReceiptNo', 'Receipt No', 'required');
    $this->form_validation->set_rules('Guest', 'Guest Name', 'required');
    $this->form_validation->set_rules('Amount', 'Amount', 'required');
    $this->form_validation->set_rules('paymode', 'Pay Mode', 'required');

    $paymode = $this->input->post('paymode');
    $validateDate = $this->input->post('validate');

    if ($paymode == 'CREDIT CARD' || $paymode == 'CHEQUE' || $paymode == 'NET TRANSFER') {
        $this->form_validation->set_rules('cardnumber', 'Card Number', 'required');
        $this->form_validation->set_rules('bank', 'Bank', 'required');
        $this->form_validation->set_rules('validate', 'Valid Date', 'required');

        // Validate that date is not in the past
        // if (!empty($validateDate)) {
        //     $validDateObj = new DateTime($validateDate);
        //     $currentDateObj = new DateTime($currentdate);
        //     if ($validDateObj < $currentDateObj) {

        //         $this->form_validation->set_rules('validate', 'Valid Date', 'callback_valid_date_check');
        //     }
        // }
    } else if ($paymode == 'UPI') {
        $this->form_validation->set_rules('bank', 'Bank', 'required');
    }

    if ($this->form_validation->run() == FALSE) {
        $output = $this->form_validation->return_f_error($this->input->post());
    } else {
        $output = $this->form_validation->return_success($this->input->post());
    }

    echo json_encode($output);
}


public function valid_date_check($date)
{
    $today = date('Y-m-d');
    if (strtotime($date) < strtotime($today)) {
        $this->form_validation->set_message('valid_date_check', 'The {field} cannot be in the past.');
        return false;
    }
    return true;
}


	function Advance_exec()
	{  
     
$roomid      = (int) $_REQUEST['roomid'];
$amount      = (float) $_REQUEST['Amount'];
$paymode     =  $_REQUEST['paymode']; 
$curdate     = date('Y-m-d');
$bank        = (int) $_REQUEST['bank'];
$cardnumber  = isset($_REQUEST['cardnumber']) ? $_REQUEST['cardnumber'] : '';
$validdate   = !empty($_REQUEST['validate']) ? "'".$_REQUEST['validate']."'" : 'NULL';
$user_id     = (int) User_id; 
$remark      = isset($_REQUEST['Remark']) ? $_REQUEST['Remark'] : '';
$idv         = isset($_REQUEST['idv']) ? $_REQUEST['idv'] : '';
 $stype       = str_replace(' ', '', $_REQUEST['BUT']);

          $sql = "Select PayMode_Id from mas_paymode where PayMode = '".$paymode."'";
          $paymode_row = $this->db->query($sql)->row_array();

          $paymodeid = $paymode_row['PayMode_Id'] ?? null;
		
		if($_REQUEST['BUT'] =='SAVE')
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
		
	 	 $qry = "EXEC Exec_PostAdvance $roomid, $amount, $paymodeid,'$curdate',$bank,'$cardnumber',$validdate,$user_id,'$remark','$idv','$stype'";  
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry); 		

		 }

		
		} else 
	   {
	 	  $qry = "EXEC Exec_PostAdvance $roomid,$amount,$paymodeid,'$curdate',$bank,'$cardnumber',$validdate, $user_id,'$remark','$idv','$stype'";  	  
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry); 		
	   }
	}
}
