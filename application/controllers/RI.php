<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RI extends CI_Controller {

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
         define('ActMenu','RI');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }

	public function RatePlan($ID=-1,$BUT='SAVE')
	{
		
		$data=array('Keey'=>rand().rand().rand().rand(),'F_Class'=>'Master','F_Ctrl'=>'RatePlan','ID'=>$ID,'BUT'=>$BUT,'FD'=>date('d-m-Y'),'TD'=>date('d-m-Y'));
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->RatePlan($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function RatePlan_Val()
	{ 
		$this->load->model('Master/RatePlan');
		$this->RatePlan->RatePlan_Val();
	}
    public function RatePlan_View()
	{
		$data=array('F_Class'=>'Master','F_Ctrl'=>'RatePlan');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."_View",$data);
		
	}
    public function GetRatePlan()
	{
		$this->load->view('RI/GetRatePlan');
	}
	public function GetRatePlandelete($ID)
	{
		$this->load->view('RI/GetRatePlandelete',array('IDD'=>$ID));
	}
	public function AllDell()
	{
		$this->db->query("delete Temp_RatePlan_Det where Keey='".$_REQUEST['Keey']."'");
	}
	//********************************************************************\\
	
	public function PlanType($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'RI','F_Ctrl'=>'PlanType','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->PlanType($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function PlanType_Val()
	{ 
		$this->load->model('RI/PlanType');
		$this->PlanType->PlanType_Val();
	}
    public function PlanType_View()
	{
		$data=array('F_Class'=>'RI','F_Ctrl'=>'PlanType');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."_View",$data);
		
	}
	//********************************************************************\\
	
	public function FoodPlan($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'RI','F_Ctrl'=>'FoodPlan','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->FoodPlan($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function FoodPlan_Val()
	{ 
		$this->load->model('RI/FoodPlan');
		$this->FoodPlan->FoodPlan_Val();
	}
    public function FoodPlan_View()
	{
		$data=array('F_Class'=>'RI','F_Ctrl'=>'FoodPlan');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."_View",$data);
		
	}
	//******************************************************************************************\\
	
	
	
    public function Inventory()
	{
		$data=array('F_Class'=>'RI','F_Ctrl'=>'Inventory');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."",$data);
		
	}
	
	//*********************************************************************\\
	public function GetRate($ID)
	{
		$this->load->view('RI/GetRate',array('ID'=>$ID));
	}
	public function RateUpdate()
	{
		$cou=count($_POST['RatePlan_Id']);
		
		for($i=0;$i<$cou;$i++)
		{
			$qry ="exec Up_RatePlan ".$_POST['RatePlan_Id'][$i].",
			".$_POST['Single'][$i].",
			".$_POST['Doubles'][$i].",
			".$_POST['Triple'][$i].",
			".$_POST['Quadruple'][$i].",".$_POST['AdultRate'][$i].",".$_POST['ChildRate'][$i];
			$this->db->query($qry);
		}
		
		echo 'Successfully Updated !!! ';
	}
	
	public function InvUpdate()
	{
		$this->load->view('RI/InvUpdate');
	}
	public function GetInv($DAT)
	{
		$this->load->view('RI/GetInv',array('DT'=>$DAT));
	}
	
	public function valRatePlan()
        {
			$qry=" exec Val_RatPlane '".$_REQUEST['RoomType_Id']."',
			'".$_REQUEST['DPlanType_Id']."','".$_REQUEST['FoodPlan_Id']."',
			'".$_REQUEST['PlanType_Id']."',
			'".$this->Myclass->DateSplit($_REQUEST['FromDate'])."',
			'".$this->Myclass->DateSplit($_REQUEST['ToDate'])."',
			'".$_REQUEST['Keey']."'"; 
			
			$res=$this->db->query($qry);
			$res=$res->row();
			$res=$res->CO;
		
	 
			if($_REQUEST['RoomType_Id']=='' || $_REQUEST['DPlanType_Id']=='' || $_REQUEST['PlanType_Id']=='' )
			{
			  
				 echo 'Please Select RoomType or PlanType  !!!'; 
				 exit;
			} 

			if (empty($_REQUEST['isota'])) {
				echo 'Please select OTA !!!';
				exit;
			}

			if ($_REQUEST['isota'] == 1) {
				if($_REQUEST['Otaratecode']==''){
					echo 'Please Give Rate Code !!!';
					exit;
				}

				if($_REQUEST['Otapaymentpolicycode'] == ''){
					echo 'Please Give Payment Policy Code !!!';
					exit;
				}

				if($_REQUEST['Otacancelcode'] == ''){
					echo 'Please Give Cancel Code !!!';
					exit;
				}
			
			}

			if( $_REQUEST['FoodPlan_Id']==0){
				
				echo 'Please Select FoodPlan  !!!'; 
				 exit;
			}
			
			 
			if($res==0)
			{
				 
				 echo 1;
			}
			else
			{
				 echo 'already exists';
			}
                 
        }
	 
	
	
}
