<?php

class State extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function State_Val()
	{
		 $this->form_validation->set_rules('State', 'State', 'required');
         $this->form_validation->set_rules('Country_Id', 'Country_Id', 'required');
		 
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
	// function State_exec()
	// {
	// 	$qry= " Exec_State '".$_REQUEST['State']."',
    //     '".$_REQUEST['Country_Id']."',
    //     '".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
	// 	$res=$this->db->query($qry);
	// 	$msg=$this->db->error(); 
	// 	$this->Myclass->GetRec($msg,$res,$qry);
	// }


		function State_exec()
         {
    if ($_REQUEST['BUT'] == 'SAVE') {
      
        $qry = "Validate_state '" . $_REQUEST['State'] . "', '" . $_REQUEST['Country_Id'] . "'";
        $res = $this->db->query($qry);
        $a = $res->num_rows();

        if ($a != 0) {
           
            $output = array();
            $output['Success'] = true;
            $output['MSG'] = "This State Already Have";
            echo json_encode($output);
            return;
        } else {
            
        $qry= " Exec_State '".$_REQUEST['State']."',
        '".$_REQUEST['Country_Id']."',
        '".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
		}
    } else {
      
       $qry= " Exec_State '".$_REQUEST['State']."',
        '".$_REQUEST['Country_Id']."',
        '".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
    }
}
}
?>