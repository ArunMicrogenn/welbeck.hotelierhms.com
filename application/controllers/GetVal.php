<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetVal extends CI_Controller {

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
    }

	 
	public function TaxSetp()
	{ 
		 $this->load->view('GetVal/TaxSetp');
    }
    
}
