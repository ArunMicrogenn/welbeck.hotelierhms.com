<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscription extends CI_Controller {

function __construct() {
        parent::__construct();
         define('ActMenu','Report');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }
    public function PayNow($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'Subscription','F_Ctrl'=>'PayNow','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->UserGroup($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function Renewal($ID=-1,$BUT='SAVE')
	{
		$data=array('F_Class'=>'Subscription','F_Ctrl'=>'Renewal','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->UserGroup($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function RenewalPaymentGateway()
	{
		$data=array('F_Class'=>'Subscription','F_Ctrl'=>'RenewalPaymentGateway');
		$this->load->view('Subscription/RenewalPaymentGateway',$data);
	}
	public function PaymentGateway()
	{   
		$data=array('F_Class'=>'Subscription','F_Ctrl'=>'PaymentGateway');
		$this->load->view('Subscription/PaymentGateway',$data);
	}
	public function Paytm_Response()
	{
		$data=array('F_Class'=>'Subscription','F_Ctrl'=>'PaymentGateway');
		$this->load->view('Subscription/Response',$data);
	}
	public function Paytm_Response1()
	{
		$data=array('F_Class'=>'Subscription','F_Ctrl'=>'PaymentGateway');
		$this->load->view('Subscription/Response1',$data);
	}
	Public function GetAmount($ID=0)
	{
		$sql="select * from mas_Subscription where Sub_Id=".$ID;
		$exe = $this->db->query($sql);
		foreach($exe -> result_array() as $row)
		{ echo $row['Amount'];
		}
	}

}