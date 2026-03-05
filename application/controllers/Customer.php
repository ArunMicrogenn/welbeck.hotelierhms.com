<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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
         define('ActMenu','Customer');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }

	
	
	
    
	//*********************************************************************\\
	public function ReservationMode($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'Customer','F_Ctrl'=>'ReservationMode','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->ReservationMode($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function ReservationMode_Val()
	{ 
		$this->load->model('Customer/ReservationMode');
		$this->ReservationMode->ReservationMode_Val();
	}
    public function ReservationMode_View()
	{
		$data=array('F_Class'=>'Customer','F_Ctrl'=>'ReservationMode');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."_View",$data);
		
	}
    
    
	  
	
	  //###########################################
	
	//*********************************************************************\\
	
	
	public function Edit()
	{
		$this->load->view('Customer/Edit/'.$_REQUEST['link']);
	}
}
