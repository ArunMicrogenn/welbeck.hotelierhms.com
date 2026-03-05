<?php

class ChangePassword extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function ChangePassword_Val()
	{
        $this->form_validation->set_rules('OldPassword', 'OldPassword', 'required');
		 $this->form_validation->set_rules('Password', 'Password', 'required');
         $this->form_validation->set_rules('CPassword', 'CPassword', 'required');	
          
		 if ($this->form_validation->run() == FALSE)
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
	function ChangePassword_exec()
	{

        $oldpassword = $_REQUEST['OldPassword'];
        $ch = "select * from usertable where user_id='".$_REQUEST['username']."' and Password='".base64_encode($oldpassword)."'";
        $chres = $this->db->query($ch);
        $no = $chres->num_rows();
       
        $newPassword = $_REQUEST['Password'];
        $CPassword = $_REQUEST['CPassword'];
        $compare = strcmp($newPassword, $CPassword);
        $compare1 = strcmp($CPassword,$oldpassword);
        if($no == 0){
            $output = array();
            $output['Success']=true;
            $output['MSG']="Enter a Valid Password!..";		 
            print_r(json_encode($output));
        }
        else if($compare != 0){
            $output = array();
            $output['Success']=true;
            $output['MSG']="Password Not Matched!..";		 
            print_r(json_encode($output));
        }else if($compare1 == 0){
            $output = array();
            $output['Success']=true;
            $output['MSG']="Enter a New Password...";		 
            print_r(json_encode($output));
        }else{
            $qry = "update usertable set Password='".base64_encode($CPassword)."' where user_id='".$_REQUEST['username']."'";
            $res=$this->db->query($qry);
            $output = array();
            $output['Success']=true;
            $output['MSG']="Password Changed Successfully";		 
            print_r(json_encode($output));

        }

	}
	

}
?>