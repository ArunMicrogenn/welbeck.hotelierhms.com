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
   $qry="exec Exec_GroupRights ".$ACT.",".$GRID.",'".$MODE."'";
		$Res=$this->db->query($qry);		
	}
	
	public function HotelProperty($ID=Hotel_Id,$BUT='Update')
	{
		
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'HotelProperty','ID'=>$ID,'BUT'=>$BUT);
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
				echo "errtype";
			}
	

			$sanitizedFileName = preg_replace("/[^a-zA-Z0-9_\-\.]/", "", $originalName);
	
			$targetPath = $uploadDir . $sanitizedFileName;
	
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetPath)) {
				$logo = "upload/" . $sanitizedFileName;
				 
			} else {
				
				echo "Upload failed!";
				var_dump($_FILES["fileToUpload"]);  
			}
		} else {
			$logo = isset($_REQUEST['existingLogo']) ? $_REQUEST['existingLogo'] : '';
		}

		  $qry = "EXEC Update_Mas_Hotel 
			'" . $_REQUEST['Company'] . "',
			'" . $_REQUEST['Address'] . "',
			'" . $_REQUEST['Address1'] . "',
			'" . $_REQUEST['website'] . "',
			'" . $_REQUEST['City'] . "',
			'" . $_REQUEST['PinCode'] . "',
			'" . $_REQUEST['Email'] . "',
			'" . $_REQUEST['MobileNo'] . "',
			'" . $_REQUEST['Phone'] . "',
			'" . $_REQUEST['State'] . "',
			'" . $_REQUEST['gstnumber'] . "',
			'" . $_REQUEST['Country'] . "',
			'" . $_REQUEST['Heading'] . "',
			'" . nl2br($_REQUEST['regcard']) . "',
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
		$this->load->view('Master/Edit/'.$_REQUEST['link']);
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
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionPE_save(){
		$sql = "update ExtraOption set walkoutbillprint = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}


	public function UserRights()
	{
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'UserRights');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."",$data);
	}


	public function UR_R($UGID)
	{
		$data=array('F_Class'=>'Setting','F_Ctrl'=>'UR_R','UGID'=>$UGID);
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl']."",$data);
	}

	public function UserwalkoutOption_save(){
		$sql = "update Usertable set comcheckoutoption = '1' where User_id = '".$_REQUEST['id']."' ";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function UserwalkoutOptionE_save(){
		$sql = "update Usertable set comcheckoutoption = '0' where User_id = '".$_REQUEST['id']."' ";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function UserwalkoutReport_save(){
		$sql = "update Usertable set comcheckoutoptioncashierreport = '1' where User_id = '".$_REQUEST['id']."' ";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function UserwalkoutReportE_save(){
		$sql = "update Usertable set comcheckoutoptioncashierreport = '0' where User_id = '".$_REQUEST['id']."' ";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}
	
	public function UserwalkoutReprintE_save(){
		$sql = "update Usertable set comreprintbill = '0' where User_id = '".$_REQUEST['id']."' ";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function UserwalkoutReprint_save(){
		$sql = "update Usertable set comreprintbill = '1' where User_id = '".$_REQUEST['id']."' ";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}


	public function ExtraOptionReprint_save(){
		$sql = "update ExtraOption set comreprintbill = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function ExtraOptionReprintE_save(){
		$sql = "update ExtraOption set comreprintbill = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	// public function registrationcard_save(){
	// 	$sql = "update Usertable set registrationcard = '1' where User_id = '".$_REQUEST['id']."' ";
	// 	$exe = $this->db->query($sql);
	// 	if($exe){
	// 		echo "Success";
	// 	}
	// 	else{
	// 		echo "Fail";
	// 	}
	// }

	// public function registrationcardE_save(){
	// 	$sql = "update Usertable set registrationcard = '0' where User_id = '".$_REQUEST['id']."' ";
	// 	$exe = $this->db->query($sql);
	// 	if($exe){
	// 		echo "Success";
	// 	}
	// 	else{
	// 		echo "Fail";
	// 	}
	// }


	public function ExtraOptioncardPrint_save(){
		$sql = "update ExtraOption set registrationcard = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
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

		$sql = "select * from usertable where user_id='".$_REQUEST['userid']."'";
		$res = $this->db->query($sql);
		foreach($res->result_array() as $row){
			$str = $row['Password'];
			echo base64_decode($str);
		}
		
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

		$power = $_REQUEST['power'];
		$servername = $_REQUEST['servername'];
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];

		$ins = "update ExtraOption set power_db = '".$power."',power_servername = '".$servername."',
		power_username = '".$username."',power_password ='".$password."'  where FoExtra_Id = 1";

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
			echo "Fail";
		}
	}


	public function roombookintegrationD_save(){
		$sql = "update ExtraOption set Enablebeehivesroombookingintergration = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}


	public function roominventintegrationE_save(){
		$sql = "update ExtraOption set Enablebeehivesroominventoryintergration = '1' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}

	public function roominventintegrationD_save(){
		$sql = "update ExtraOption set Enablebeehivesroominventoryintergration = '0' where FoExtra_Id = 1";
		$exe = $this->db->query($sql);
		if($exe){
			echo "Success";
		}
		else{
			echo "Fail";
		}
	}
}
