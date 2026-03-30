<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->pcss->loginwjs();
		// BUG FIX: Removed echo "Redirecting..." — was outputting content before CI could handle headers
	}
	public function index()
	{ 
	   $sql="select StartDate,EndDate from Mas_Hotel where Hotel_Id=1";
	        // $hotel_id =   $_SESSION
	   $result=$this->db->query($sql);
	   foreach ($result->result_array() as $row)
    	{   $StartDate=$row['StartDate'];
			$EndDate=$row['EndDate']; }
		$date_now = date("Y-m-d"); 
        if ($date_now <= $EndDate) {     
			$Ready =true;
		}
		else
		{
			$Ready=false;
		}
	   // BUG FIX: SQL Injection — never use $_POST directly in SQL. Use escape_str() to sanitize input.
	   $username = $this->db->escape_str($this->input->post('username'));
	   $password  = base64_encode($this->input->post('password'));
	   $qry=" EXEC dbo.Login '".$username."' ,'".$password."'";
	   $res=$this->db->query($qry);
	   $data=json_encode($res->result());
	 
		$data=json_decode($data,true);
		if(count($data)== 0)
		{
		   $this->load->view('welcome_message');
		   ?>
			<script>
			      swal("Invalid Username Password!", "Please to Enter Valid Credentials!", "warning")
				  .then(() => {(window.location.href="<?php echo scs_index; ?>")});
				</script>
		   <?php 
		}
		else if($Ready == false)
		{  ?>
			<script>
			swal("Your Subscription Expired!", "please to make a payment!", "warning")
			.then(() => {(window.location.href="<?php echo scs_index; ?>Subscription/Renewal")});
		  </script>
			 <?php 
		}
		else
		{
			
			$this->session->set_userdata('POS',$data[0]);   
		
		   ?>
		   <script>
			window.location.href="<?php echo scs_index; ?>";
		   </script>
			<?php
		}
		      // redirect(Scs_url, 'refresh');
           // $this->load->view('home');          --- Ravi Alter the commend 2019/12/13
		   //$data=array('F_Class'=>'Welcome','F_Ctrl'=>'Dashboard');
		   // $this->load->view('main',$data);
     }
  
	public function logout()
	{
		// BUG FIX: Use CI session library instead of raw PHP session functions
		$this->load->library('session');
		$this->session->sess_destroy();
		?>
		<script>
		window.location.href="<?php echo scs_index; ?>";
	   </script>
	   <?php
	}
}
