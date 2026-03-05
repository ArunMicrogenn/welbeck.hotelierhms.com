<?php

class DayBook extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function DayBook_Val()
	{
		 $this->form_validation->set_rules('ledgername', 'ledgername', 'required');
		 
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

	 function DayBook_Exec()
	{
		if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= "select * from accname where Accname= '".$_REQUEST['ledgername']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This Acc.Name Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
			 $qry= " Exec Exec_accname '".$_REQUEST['ledgername']."',
			'".$_REQUEST['Active']."',
			'".$_REQUEST['Creditordebit']."',
			'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
		 }
		 } else
		 {
			  $qry= " Exec Exec_accname '".$_REQUEST['ledgername']."',
			'".$_REQUEST['Active']."',
			'".$_REQUEST['Creditordebit']."',
			'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
		 }
	}
	
}
?>