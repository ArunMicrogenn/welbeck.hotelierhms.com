<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reprint extends CI_Controller {

function __construct() {
        parent::__construct();
		$this->load->library('session');

		if (empty($this->session->userdata('POS'))) {
			echo '
			<!DOCTYPE html>
			<html>
			<head>
				<!-- Load SweetAlert v1 -->
				<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
			</head>
			<body>
				<script>
					swal("Session Expired", "Your session has ended. You will be logged out.", "warning")
					.then(() => {
						window.location.href = "' . scs_index . 'login/logout";
					});
				</script>
			</body>
			</html>';
			exit;
		}
		
         define('ActMenu','Reprint');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }
	 
    public function AdvanceReceipt()
	{
		$data=array('F_Class'=>'Reprint','F_Ctrl'=>'AdvanceReceipt');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}

    public function BillEntryReceipt()
	{
		$data=array('F_Class'=>'Reprint','F_Ctrl'=>'BillEntryReceipt');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}

    public function CheckoutBill()
	{
		$data=array('F_Class'=>'Reprint','F_Ctrl'=>'CheckoutBill');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}

	public function CheckoutReprint()
	{
		$data=array('F_Class'=>'Print','F_Ctrl'=>'CheckoutReprint');
		$data['back'] = "Reprint/CheckoutBill";
		$this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function CheckoutSummaryReprint()
	{
		$data=array('F_Class'=>'Print','F_Ctrl'=>'CheckoutSummaryReprint');
		$this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function GroupcheckoutSummaryReprint()
	{
		$data=array('F_Class'=>'Print','F_Ctrl'=>'GroupcheckoutSummaryReprint');
		$this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function ResAdvanceReceipt()
	{
		$data=array('F_Class'=>'Reprint','F_Ctrl'=>'ResAdvanceReceipt');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}

	public function ComplementaryBill()
	{
		$data=array('F_Class'=>'Reprint','F_Ctrl'=>'ComplementaryBill');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}

	public function CashBookEntry()
	{
		$data=array('F_Class'=>'Reprint','F_Ctrl'=>'CashBookEntry');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}

	public function Registration()
	{
		$data=array('F_Class'=>'Reprint','F_Ctrl'=>'Registration');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}

	public function GroupCheckoutReprint()
	{
		$data=array('F_Class'=>'Print','F_Ctrl'=>'GroupCheckoutReprint');
		$this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
    

	public function blankregcard()
	{
		$data=array('F_Class'=>'Print','F_Ctrl'=>'blankregcard');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	
}
