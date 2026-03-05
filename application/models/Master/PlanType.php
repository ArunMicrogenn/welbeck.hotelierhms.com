<?php

class PlanType extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function PlanType_Val()
	{
		 $this->form_validation->set_rules('RateCode', 'RateCode', 'required');
		 $this->form_validation->set_rules('RateCaption', 'RateCaption', 'required');
		 $this->form_validation->set_rules('ShortName', 'ShortName', 'required');
		 
		// $this->form_validation->set_rules('SCCB','SCCB','trim|required|xss_clean|greater_than[0]');
		 
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
	function PlanType_exec()
	{
		if($_REQUEST['BUT'] =='SAVE')
	   {		   
	     $qry= " Validate_PlanType '".$_REQUEST['RateCode']."'";
		 $res=$this->db->query($qry);
		 $a= $res->num_rows();
		 if($a !=0)
		 {
		 $output = array();
		 $output['Success']=true;
 		 $output['MSG']="This RateCode Already Have";		 
		 print_r(json_encode($output));
		 }
		 else
	     {
			$SCCB=0;$DEFA=0;$Act=0;$PubTarriff=0;$NetTarriff=0;
			if(@isset($_POST['SCCB']))       { $SCCB=1; }
			if(@isset($_POST['DEFA']))       { $DEFA=1; }
			if(@isset($_POST['Act']))        { $Act=1; }
			if(@isset($_POST['PubTarriff'])) { $PubTarriff=1; }
			if(@isset($_POST['NetTarriff'])) { $NetTarriff=1; }
		 
			$qry= " Exec_PlanType 
			'".$_REQUEST['RateCode']."',
			'".$_REQUEST['RateCaption']."',
			'".$_REQUEST['ShortName']."',
			'".$SCCB."','".$DEFA."','".$Act."','".$PubTarriff."','".$NetTarriff."', 
			".Hotel_Id.",
			'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry);
		  }
	   }
	   else
	   {
		  $SCCB=0;$DEFA=0;$Act=0;$PubTarriff=0;$NetTarriff=0;
			if(@isset($_POST['SCCB']))       { $SCCB=1; }
			if(@isset($_POST['DEFA']))       { $DEFA=1; }
			if(@isset($_POST['Act']))        { $Act=1; }
			if(@isset($_POST['PubTarriff'])) { $PubTarriff=1; }
			if(@isset($_POST['NetTarriff'])) { $NetTarriff=1; }
		 
			$qry= " Exec_PlanType 
			'".$_REQUEST['RateCode']."',
			'".$_REQUEST['RateCaption']."',
			'".$_REQUEST['ShortName']."',
			'".$SCCB."','".$DEFA."','".$Act."','".$PubTarriff."','".$NetTarriff."', 
			".Hotel_Id.",
			'".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
			$res=$this->db->query($qry);
			$msg=$this->db->error(); 
			$this->Myclass->GetRec($msg,$res,$qry); 
	   }
	}
}
?>