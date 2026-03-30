<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room extends CI_Controller {

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
         define('ActMenu','Room');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }

	
    //###########################################
	
	
	
	//*********************************************************************\\
	public function Edit()
	{
		// BUG FIX: LFI (Local File Inclusion) â same fix as Setting.php Edit()
		// Strip unsafe characters from user-supplied link parameter
		$link = isset($_REQUEST['link']) ? $_REQUEST['link'] : '';
		$link = preg_replace('/[^a-zA-Z0-9_\/\-]/', '', $link);
		if (empty($link)) {
			show_404();
			return;
		}
		$this->load->view('Master/Edit/'.$link);
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room extends CI_Controller {

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
         define('ActMenu','Room');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }

	
    //###########################################
	
	
	
	//*********************************************************************\\
	public function Edit()
	{
		// BUG FIX: LFI (Local File Inclusion) â same fix as Setting.php Edit()
		// Strip unsafe characters from user-supplied link parameter
		$link = isset($_REQUEST['link']) ? $_REQUEST['link'] : '';
		$link = preg_replace('/[^a-zA-Z0-9_\/\-]/', '', $link);
		if (empty($link)) {
			show_404();
			return;
		}
		$this->load->view('Master/Edit/'.$link);
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room extends CI_Controller {

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
         define('ActMenu','Room');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }

	
    //###########################################
	
	
	
	//*********************************************************************\\
	public function Edit()
	{
		$this->load->view('Master/Edit/'.$_REQUEST['link']);
	}
}
