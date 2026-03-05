<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donate extends CI_Controller {

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
         define('ActMenu','Donate');
		 
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }

	 
    public function Receipt()
	{
		$data=array('F_Class'=>'Donate','F_Ctrl'=>'Receipt');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function Decline()
	{
		$data=array('F_Class'=>'Donate','F_Ctrl'=>'Decline');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
    
}
