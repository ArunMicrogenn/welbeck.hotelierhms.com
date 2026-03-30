<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {

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
         define('ActMenu','Setting');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }

	public function UserGroup($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'UserGroup','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->UserGroup($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function UserGroup_Val()
	{ 
		$this->load->model('Setting/UserGroup');
		$this->UserGroup->UserGroup_Val();
	}
    public function UserGroup_View()
	{
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'UserGroup');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."_View",$data);
		
	}
	public function GroupRights()
	{
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'GroupRights');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."",$data);
	}
	public function UG_R($UGID)
	{
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'UG_R','UGID'=>$UGID);
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."",$data);
	}
	
	public function UG_RA($UGIDA,$UGID,$SMENU)
	{
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'UG_RA','UGIDA'=>$UGIDA,'UGID'=>$UGID,'SMENU'=>$SMENU);
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."",$data);
	}	

	public function UR_GRAND($ACT,$GRID,$MODE)
	{
		// BUG FIX: SQL Injection â cast numeric params to int, escape string param
		$ACT  = (int)$ACT;
		$GRID = (int)$GRID;
		$MODE = $this->db->escape_str($MODE);
		$qry = "exec Exec_GroupRights ".$ACT.",".$GRID.",'".$MODE."'";
		$Res = $this->db->query($qry);
	}
	
	public function HotelProperty($ID=Hotel_Id,$BUT='Update')
	{
		
		$data=array('F_Class'=>'Setting','F_Ctrl'=='HotelProperty','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->HotelProperty($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
    //###########################################
	public function DataPurchaing($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'DataPurchaing','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->DataPurchaing($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	   $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function DataPurchaing_Val()
	{ 
		$this->load->model('Setting/DataPurchaing');
		$this->DataPurchaing->DataPurchaing_Val();
	}
	// public function HotelProperty_Val()
	// { 
	// 	// $this->load->model('Setting/HotelProperty');
	// 	// $this->HotelProperty->HotelProperty_Val();
		
	// 	if($_FILES["fileToUpload"]["name"] !=''){
	// 		$path ="upload";
	// 		$newname = 'logo';
	// 		$extension  = pathinfo( $_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION ); // jpg
	// 		$extension = 'png';
	// 		$basename   = $newname . "." . $extension; 
	// 		 $desdir = "$path/";
	// 		 $desdirc = "$path/$basename";
		 
	// 		$file = $_FILES["fileToUpload"]["tmp_name"];
	// 		$source_properties = getimagesize($file);
	// 		$image_type = $source_properties[2];
	// 		if ($image_type == IMAGETYPE_JPEG) {
	// 			$image_resource_id = imagecreatefromjpeg($file);
	// 		} elseif ($image_type == IMAGETYPE_GIF) {
	// 			$image_resource_id = imagecreatefromgif($file);
	// 		} elseif ($image_type == IMAGETYPE_PNG) {
	// 			$image_resource_id = imagecreatefrompng($file);
	// 		}
	// 		$target_width = 160;
	// 		$target_height = 128;
	// 		$target_layer = imagecreatetruecolor($target_width, $target_height);
	// 		imagecopyresampled($target_layer, $image_resource_id, 0, 0, 0, 0, $target_width, $target_height, $source_properties[0], $source_properties[1]);
					
	// 		  if(!file_exists($desdir)){
		 
	// 		   mkdir($desdir, 0777,true);
	// 		   echo "yes";   
	// 		  }
			 
	// 		   if(!file_exists($desdirc)){
	// 			imagejpeg($target_layer, $desdirc);
		
	// 		   }
	// 		  else{
	// 			imagejpeg($target_layer, $desdirc);
	// 			}
	// 		}
	// 		// echo nl2br($_REQUEST['regcard']);
			
	// 		   $qry= "exec Update_Mas_Hotel '".$_REQUEST['Company']."','".$_REQUEST['Address']."','".$_REQUEST['Address1']."','".$_REQUEST['website']."','".$_REQUEST['City']."','".$_REQUEST['PinCode']."','".$_REQUEST['Email']."','".$_REQUEST['MobileNo']."','".$_REQUEST['Phone']."','".$_REQUEST['State']."','".$_REQUEST['gstnumber']."',
	// 		   '".$_REQUEST['Country']."','".$_REQUEST['Heading']."','".nl2br($_REQUEST['regcard'])."','".Hotel_Id."'";
	// 		   $res=$this->db->query($qry);
	// 		   if($res){
	// 			echo "success";
	// 		   }
	// 		   else{
	// 			echo "fail";
	// 		   }
	// }


	public function HotelProperty_Val()
	{
		$logo = ''; 
	
	
		$uploadDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/upload/';

		if (!file_exists($uploadDir)) {
			mkdir($uploadDir, 0777, true); 
		}
	

		if (!empty($_FILES["fileToUpload"]["name"])) {
		
			$originalName = basename($_FILES["fileToUpload"]["name"]);
			$allowedExtensions = ['jpeg', 'jpg', 'png', 'gif']; 
			$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION)); 
	
			
			if (!in_array($ext, $allowedExtensions)) {
				// BUG FIX: Added return â previously echo "errtype" had no return, upload continued anyway!
				echo "errtype";
				return;
			}


			$sanitizedFileName = preg_replace("/[^a-zA-Z0-9_\-\.]/", "", $originalName);

			$targetPath = $uploadDir . $sanitizedFileName;

			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetPath)) {
				$logo = "upload/" . $sanitizedFileName;

			} else {
				// BUG FIX: Removed var_dump($_FILES) â was exposing internal server info in production
				echo "Upload failed!";
				return;
			}
		} else {
			$logo = isset($_REQUEST['existingLogo']) ? $_REQUEST['existingLogo'] : '';
		}

		// BUG FIX: SQL Injection â escape all $_REQUEST values before using in query
		$Company  = $this->db->escape_str($this->input->post('Company'));
		$Address  = $this->db->escape_str($this->input->post('Address'));
		$Address1 = $this->db->escape_str($this->input->post('Address1'));
		$website  = $this->db->escape_str($this->input->post('website'));
		$City     = $this->db->escape_str($this->input->post('City'));
		$PinCode  = $this->db->escape_str($this->input->post('PinCode'));
		$Email    = $this->db->escape_str($this->input->post('Email'));
		$MobileNo = $this->db->escape_str($this->input->post('MobileNo'));
		$Phone    = $this->db->escape_str($this->input->post('Phone'));
		$State    = $this->db->escape_str($this->input->post('State'));
		$gstnumber= $this->db->escape_str($this->input->post('gstnumber'));
		$Country  = $this->db->escape_str($this->input->post('Country'));
		$Heading  = $this->db->escape_str($this->input->post('Heading'));
		$regcard  = $this->db->escape_str(nl2br($this->input->post('regcard')));

		  $qry = "EXEC Update_Mas_Hotel
			'" . $Company . "',
			'" . $Address . "',
			'" . $Address1 . "',
			'" . $website . "',
			'" . $City . "',
			'" . $PinCode . "',
			'" . $Email . "',
			'" . $MobileNo . "',
			'" . $Phone . "',
			'" . $State . "',
			'" . $gstnumber . "',
			'" . $Country . "',
			'" . $Heading . "',
			'" . $regcard . "',
			'" . $logo . "',
			'" . Hotel_Id . "'";
	
		
		$res = $this->db->query($qry);
	
		
		if ($res) {
			echo "success";
		} else {
			echo "fail";
		}
	}
	




	
	
	
	public function emails($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'emails','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->Emails($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function emails_Val()
	{ 
		$this->load->model('Setting/emails');
		$this->emails->emails_Val();
	}
    public function emails_View()
	{
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'emails');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."_View",$data);
		
	}
	//***************************************************** *//
	public function User($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'User','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->User($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function User_Val()
	{ 
		$this->load->model('Setting/User');
		$this->User->User_Val();
	}
	public function User_View()
	{
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'User');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."_View",$data);
		
	}



	//*********************************************************************\\
	public function ChangePassword($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'ChangePassword','ID'=>$ID,'BUT'=>$BUT);
		// if($ID!=-1)
		// { 
		// 	$REC=$this->Myclass->User($ID);
		// 	$data=array_merge($data,$REC[0]);
		// }
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}

	public function ChangePassword_Val()
	{ 
		$this->load->model('Setting/ChangePassword');
		$this->ChangePassword->ChangePassword_Val();
	}

	//*********************************************************************\\
	public function Edit()
	{
		// BUG FIX: LFI (Local File Inclusion) â  $_REQUEST['link'] was used directly in load->view()
		// Hacker could pass ../../config/database to read config files
		// Fix: strip all characters except letters, numbers, slash, underscore, hyphen
		$link = isset($_REQUEST['link']) ? $_REQUEST['link'] : '';
		$link = preg_replace('/[^a-zA-Z0-9_\/\-]/', '', $link);
		if (empty($link)) {
			show_404();
			return;
		}
		$this->load->view('Master/Edit/'.$link);
	}


	public function foSettings($ID=-1,$BUT='SAVE')
	{
		
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'foSettings','ID'=>$ID,'BUT'=>$BUT);
		if($ID!=-1)
		{ 
			$REC=$this->Myclass->UserGroup($ID);
			$data=array_merge($data,$REC[0]);
		}
		 
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	
	public function ExtraOption_save(){
		$sql = "update ExtraOption set walkoutbillshowincashierreport = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionE_save(){
		$sql = "update ExtraOption set walkoutbillshowincashierreport = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionP_save(){
		$sql = "update ExtraOption set walkoutbillprint = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "SuaÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô((%ÁÕ±¥Õ¹Ñ¥½¸áÑÉ=ÁÑ¥½¹A}ÍÙ ¥ì($$ÍÅ°ôÕÁÑáÑÉ=ÁÑ¥½¸ÍÐÝ±­½ÕÑ¥±±ÁÉ¥¹ÐôÀÝ¡É½áÑÉ}%ôÄì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô(((%ÁÕ±¥Õ¹Ñ¥½¸UÍÉI¥¡ÑÌ ¤(%ì($$ÑõÉÉä }
±ÍÌôøMÑÑ¥¹°}
ÑÉ°ôøUÍÉI¥¡ÑÌ¤ì($Ñ¡¥Ì´ù±½´ùÙ¥Ü Ñl}
±ÍÌt¸¼¸Ñl}
ÑÉ°t¸°Ñ¤ì(%ô(((%ÁÕ±¥Õ¹Ñ¥½¸UI}H U%¤(%ì($$ÑõÉÉä }
±ÍÌôøMÑÑ¥¹°}
ÑÉ°ôøUI}H°U%ôøU%¤ì($Ñ¡¥Ì´ù±½´ùÙ¥Ü Ñl}
±ÍÌt¸¼¸Ñl}
ÑÉ°t¸°Ñ¤ì(%ô((%ÁÕ±¥Õ¹Ñ¥½¸UÍÉÝ±­½ÕÑ=ÁÑ¥½¹}ÍÙ ¥ì($$¼¼	U%`èME0%¹©Ñ¥½¸PÍÐ¥Ñ¼¥¹Ð¡UÍÉ}¥¥Ì±ÝåÌ¹ÕµÉ¥¤($$ÕÍÉ}¥ô¡¥¹Ð¤Ñ¡¥Ì´ù¥¹ÁÕÐ´ùÁ½ÍÐ ¥¤ì($$ÍÅ°ôÕÁÑUÍÉÑ±ÍÐ½µ¡­½ÕÑ½ÁÑ¥½¸ôÄÝ¡ÉUÍÉ}¥ô¸ÕÍÉ}¥ì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô((%ÁÕ±¥Õ¹Ñ¥½¸UÍÉÝ±­½ÕÑ=ÁÑ¥½¹}ÍÙ ¥ì($$¼¼	U%`èME0%¹©Ñ¥½¸PÍÐ¥Ñ¼¥¹Ð($$ÕÍÉ}¥ô¡¥¹Ð¤Ñ¡¥Ì´ù¥¹ÁÕÐ´ùÁ½ÍÐ ¥¤ì($$ÍÅ°ôÕÁÑUÍÉÑ±ÍÐ½µ¡­½ÕÑ½ÁÑ¥½¸ôÀÝ¡ÉUÍÉ}¥ô¸ÕÍÉ}¥ì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô((%ÁÕ±¥Õ¹Ñ¥½¸UÍÉÝ±­½ÕÑIÁ½ÉÑ}ÍÙ ¥ì($$¼¼	U%`èME0%¹©Ñ¥½¸PÍÐ¥Ñ¼¥¹Ð($$ÕÍÉ}¥ô¡¥¹Ð¤Ñ¡¥Ì´ù¥¹ÁÕÐ´ùÁ½ÍÐ ¥¤ì($$ÍÅ°ôÕÁÑUÍÉÑ±ÍÐ½µ¡­½ÕÑ½ÁÑ¥½¹Í¡¥ÉÉÁ½ÉÐôÄÝ¡ÉUÍÉ}¥ô¸ÕÍÉ}¥ì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô((%ÁÕ±¥Õ¹Ñ¥½¸UÍÉÝ±­½ÕÑIÁ½ÉÑ}ÍÙ ¥ì($$¼¼	U%`èME0%¹©Ñ¥½¸PÍÐ¥Ñ¼¥¹Ð($$ÕÍÉ}¥ô¡¥¹Ð¤Ñ¡¥Ì´ù¥¹ÁÕÐ´ùÁ½ÍÐ ¥¤ì($$ÍÅ°ôÕÁÑUÍÉÑ±ÍÐ½µ¡­½ÕÑ½ÁÑ¥½¹Í¡¥ÉÉÁ½ÉÐôÀÝ¡ÉUÍÉ}¥ô¸ÕÍÉ}¥ì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô($(%ÁÕ±¥Õ¹Ñ¥½¸UÍÉÝ±­½ÕÑIÁÉ¥¹Ñ}ÍÙ ¥ì($$¼¼	U%`èME0%¹©Ñ¥½¸PÍÐ¥Ñ¼¥¹Ð($$ÕÍÉ}¥ô¡¥¹Ð¤Ñ¡¥Ì´ù¥¹ÁÕÐ´ùÁ½ÍÐ ¥¤ì($$ÍÅ°ôÕÁÑUÍÉÑ±ÍÐ½µÉÁÉ¥¹Ñ¥±°ôÀÝ¡ÉUÍÉ}¥ô¸ÕÍÉ}¥ì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô((%ÁÕ±¥Õ¹Ñ¥½¸UÍÉÝ±­½ÕÑIÁÉ¥¹Ñ}ÍÙ ¥ì($$¼¼	U%`èME0%¹©Ñ¥½¸PÍÐ¥Ñ¼¥¹Ð($$ÕÍÉ}¥ô¡¥¹Ð¤Ñ¡¥Ì´ù¥¹ÁÕÐ´ùÁ½ÍÐ ¥¤ì($$ÍÅ°ôÕÁÑUÍÉÑ±ÍÐ½µÉÁÉ¥¹Ñ¥±°ôÄÝ¡ÉUÍÉ}¥ô¸ÕÍÉ}¥ì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô(((%ÁÕ±¥Õ¹Ñ¥½¸áÑÉ=ÁÑ¥½¹IÁÉ¥¹Ñ}ÍÙ ¥ì($$ÍÅ°ôÕÁÑáÑÉ=ÁÑ¥½¸ÍÐ½µÉÁÉ¥¹Ñ¥±°ôÄÝ¡É½áÑÉ}%ôÄì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô((%ÁÕ±¥Õ¹Ñ¥½¸áÑÉ=ÁÑ¥½¹IÁÉ¥¹Ñ}ÍÙ ¥ì($$ÍÅ°ôÕÁÑáÑÉ=ÁÑ¥½¸ÍÐ½µÉÁÉ¥¹Ñ¥±°ôÀÝ¡É½áÑÉ}%ôÄì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¥°ì($%ô(%ô(($¼¼ÁÕ±¥Õ¹Ñ¥½¸É¥ÍÑÉÑ¥½¹É}ÍÙ ¥ì($¼¼$ÍÅ°ôÕÁÑUÍÉÑ±ÍÐÉ¥ÍÑÉÑ¥½¹ÉôÄÝ¡ÉUÍÉ}¥ô¸}IEUMQl¥t¸ì($¼¼$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($¼¼%¥ á¥ì($¼¼$%¡¼MÕÍÌì($¼¼%ô($¼¼%±Íì($¼¼$%¡¼¥°ì($¼¼%ô($¼¼ô(($¼¼ÁÕ±¥Õ¹Ñ¥½¸É¥ÍÑÉÑ¥½¹É}ÍÙ ¥ì($¼¼$ÍÅ°ôÕÁÑUÍÉÑ±ÍÐÉ¥ÍÑÉÑ¥½¹ÉôÀÝ¡ÉUÍÉ}¥ô¸}IEUMQl¥t¸ì($¼¼$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($¼¼%¥ á¥ì($¼¼$%¡¼MÕÍÌì($¼¼%ô($¼¼%±Íì($¼¼$%¡¼¥°ì($¼¼%ô($¼¼ô(((%ÁÕ±¥Õ¹Ñ¥½¸áÑÉ=ÁÑ¥½¹ÉAÉ¥¹Ñ}ÍÙ ¥ì($$ÍÅ°ôÕÁÑáÑÉ=ÁÑ¥½¸ÍÐÉ¥ÍÑÉÑ¥½¹ÉôÄÝ¡É½áÑÉ}%ôÄì($$áôÑ¡¥Ì´ù´ùÅÕÉä ÍÅ°¤ì($%¥ á¥ì($$%¡¼MÕÍÌì($%ô($%±Íì($$%¡¼¡¾;
		}
	}

	public function ExtraOptioncardPrintE_save(){
		$sql = "update ExtraOption set registrationcard = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	
		public function ExtraOptioncardRePrint_save(){
		$sql = "update ExtraOption set registrationcardreprint = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptioncardRePrintE_save(){
		$sql = "update ExtraOption set registrationcardreprint = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}


	public function ExtraOptionSpilitBill_save(){
		$sql = "update ExtraOption set enablespilitbill = '1' where FoExtra_Id = 1" ;
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionSpilitBillE_save(){
		$sql = "update ExtraOption set enablespilitbill = '0' where FoExtra_Id = 1" ;
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function getUserPassword(){
		// BUG FIX: CRITICAL â This function was returning plain text decoded passwords to the browser!
		// Anyone with the URL could call /Setting/getUserPassword?userid=1 and get the password.
		// Also had SQL Injection via $_REQUEST['userid'].
		// Function DISABLED for security â passwords should never be exposed via API.
		show_error('Access denied', 403);
		return;
	}



	
	public function ExtraOptioncashbookentry_save(){
		$sql = "update ExtraOption set cashbookentryprint = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptioncashbookentryE_save(){
		$sql = "update ExtraOption set cashbookentryprint = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}
	
		public function ExtraOptionWBSms_save(){
		$sql = "update ExtraOption set whatsappBusinessSms = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionWBSmsE_save(){
		$sql = "update ExtraOption set whatsappBusinessSms = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}
	
	
	
	public function ExtraOptionmd_save(){
		$sql = "update ExtraOption set enablewhatsappsmsformd = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionmdE_save(){
		$sql = "update ExtraOption set enablewhatsappsmsformd = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}
	public function ExtraOptionCheckin_save(){
		$sql = "update ExtraOption set enablewhatsappsmsforcheckin = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionCheckinE_save(){
		$sql = "update ExtraOption set enablewhatsappsmsforcheckin = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}


	public function ExtraOptionCheckout_save(){
		$sql = "update ExtraOption set enablewhatsappsmsforcheckout = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionCheckoutE_save(){
		$sql = "update ExtraOption set enablewhatsappsmsforcheckout = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}


	public function ExtraOptionres_save(){
		$sql = "update ExtraOption set enablewhatsappsmsforres = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionresE_save(){
		$sql = "update ExtraOption set enablewhatsappsmsforres = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}


	public function ExtraOptionresc_save(){
		$sql = "update ExtraOption set enablewhatsappsmsforresc = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionrescE_save(){
		$sql = "update ExtraOption set enablewhatsappsmsforresc = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}


	public function ExtraOptionresenquiry_save(){
		$sql = "update ExtraOption set Enablereservationenquiry = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionresenquiryE_save(){
		$sql = "update ExtraOption set Enablereservationenquiry = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionrebooking_save(){
		$sql = "update ExtraOption set Enablebooklogic = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionrebookingE_save(){
		$sql = "update ExtraOption set Enablebooklogic = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function enalepower_save (){

		$sql = "update ExtraOption set enablepower = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}
	public function disablepower_save (){
		$sql = "update ExtraOption set enablepower = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function enalepowercut_save (){

		$sql = "update ExtraOption set powercut_after_settlement = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}
	public function disablepowercut_save (){
		$sql = "update ExtraOption set powercut_after_settlement = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}


	public function insertdb(){
		// BUG FIX: SQL Injection â escape all $_REQUEST values before using in query
		$power      = $this->db->escape_str($this->input->post('power'));
		$servername = $this->db->escape_str($this->input->post('servername'));
		$username   = $this->db->escape_str($this->input->post('username'));
		$password   = $this->db->escape_str($this->input->post('password'));

		$ins = "update ExtraOption set power_db = '".$power."',power_servername = '".$servername."',
		power_username = '".$username."',power_password ='".$password."'"  where FoExtra_Id = 1";

		$qry = $this->db->query($ins);

		if($qry){
			echo 1;
		}
		else{
			echo 2;
		}

	}


	public function roombookintegrationE_save(){
		$sql = "update ExtraOption set Enablebeehivesroombookingintergration = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			`V6ò$fÂ#° Ð Ð   V&Æ2gVæ7Föâ&ööÖ&öö¶çFVw&FöäE÷6fR° G7ÂÒ'WFFRWG&÷Föâ6WBVæ&ÆV&VVfW7&ööÖ&öö¶ævçFW&w&FöâÒsrvW&RfôWG&ôBÒ#° FWRÒGF2ÓæF"ÓçVW'G7Â° bFWR° V6ò%7V66W72#° Ð VÇ6W° V6ò$fÂ#° Ð Ð   V&Æ2gVæ7Föâ&ööÖçfVçFçFVw&FöäU÷6fR° G7ÂÒ'WFFRWG&÷Föâ6WBVæ&ÆV&VVfW7&ööÖçfVçF÷'çFW&w&FöâÒsrvW&RfôWG&ôBÒ#° FWRÒGF2ÓæF"ÓçVW'G7Â° bFWR° V6ò%7V66W72#° Ð VÇ6W° V6ò$fÂ#° Ð Ð  V&Æ2gVæ7Föâ&ööÖçfVçFçFVw&FöäE÷6fR° G7ÂÒ'WFFRWG&÷Föâ6WBVæ&ÆV&VVfW7&ööÖçfVçF÷'çFW&w&FöâÒsrvW&RfôWG&ôBÒ#° FWRÒGF2ÓæF"ÓçVW'G7Â° bFWR° V6ò%7V66W72#° Ð VÇ6W° V6ò$fÂ#° Ð Ð§Ð
