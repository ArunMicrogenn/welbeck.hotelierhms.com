<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->pcss->loginwjs();	
		echo "Redirecting...";
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
	   $qry=" EXEC dbo.Login '".$_POST['username']."' ,'".base64_encode($_POST['password'])."'";
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
		@session_start();
	    @session_destroy();
		//$this->load->view('welcome_message');
		?>
		<script>
		window.location.href="<?php echo scs_index; ?>";
	   </script>
	   <?php
	}
}
