<?php

class TaxSetup extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function TaxSetup_Val()
	{
		 $this->form_validation->set_rules('Revenue', 'Revenue', 'required');
		 
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
	function TaxSetup_exec()
	{
		/*$qry= " Exec_TaxSetup '".$_REQUEST['TaxSetup']."',
		'".$_REQUEST['Active']."',
		'".User_id."',
		'".Hotel_Id."',
		'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);*/
		$i=0;
		 $qry='';
		foreach( $_POST['FAMT'] as $col)
		{
			  $qry .= "exec Up_TaxSetup 
					'".$_POST['FAMT'][$i]."',
					'".$_POST['To'][$i]."',
					'".$_POST['Per'][$i]."',
					'".$_POST['IDD'][$i]."'
					 ";
					
				   
					 $i++;
		}
		$res=$this->db->query($qry);
		$res=$this->db->query("SELECT 'Successfully Saved' AS MGS");
		$msg=$this->db->error();
		$this->Myclass->GetRec($msg,$res,$qry);
	}
}
?>