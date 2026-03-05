<?php

class BedType extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function BedType_Val()
	{
		 $this->form_validation->set_rules('BedType', 'BedType', 'required');
		 
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
	function BedType_exec()
	{
		 if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_BedType '".$_REQUEST['BedType']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This BedType Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
			$qry= " Exec_BedType '".$_REQUEST['BedType']."',".Hotel_Id.",".User_id.",'".$_REQUEST['Active']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
	   }}else
	   {
		 $qry= " Exec_BedType '".$_REQUEST['BedType']."',".Hotel_Id.",".User_id.",'".$_REQUEST['Active']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);  
	   }
	}
}
?>