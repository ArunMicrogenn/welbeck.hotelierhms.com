<?php

class Bank extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function Bank_Val()
	{
		 $this->form_validation->set_rules('Bank', 'Bank', 'required');
		 
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
	function Bank_exec()
	{
   	 if($_REQUEST['BUT'] =='SAVE')
	   {	
	     $qry= " Validate_Bank '".$_REQUEST['Bank']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This Bank Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
			$isupi=0;
			if(@isset($_POST['isupi']))  { $isupi=1; }
			$qry= " Exec_Bank '".$_REQUEST['Bank']."',".Hotel_Id.",".User_id.",'".$isupi."','".$_REQUEST['Active']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
	  	 }
		}
		else
		{
			$isupi=0;
			if(@isset($_POST['isupi']))  { $isupi=1; }
			$qry= " Exec_Bank '".$_REQUEST['Bank']."',".Hotel_Id.",".User_id.",'".$isupi."','".$_REQUEST['Active']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
		}
	}
}
?>