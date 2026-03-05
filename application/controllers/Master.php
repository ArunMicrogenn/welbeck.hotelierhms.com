<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master extends CI_Controller
{

	function __construct()
	{
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
		define('ActMenu', 'Master');
		$ci = &get_instance();
		$ci->router->class;
		$ci->router->method;
		date_default_timezone_set('Asia/Kolkata'); 
	}

	public function member($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'member', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Member($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function member_Val()
	{
		$this->load->model('Master/member');
		$this->member->member_Val();
	}
	public function member_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'member');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	//###########################################
	public function Facility($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Facility', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Facility($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Facility_Val()
	{
		$this->load->model('Master/Facility');
		$this->Facility->Facility_Val();
	}
	public function Facility_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Facility');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function Customer($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Customer', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Customer($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Customer_Val()
	{
		$this->load->model('Master/Customers');
		$this->Customers->Customer_Val();
	}
	public function Customer_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Customer');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//*********************************************************************\\

	public function GuestType($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'GuestType', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->GuestType($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function GuestType_Val()
	{
		$this->load->model('Master/GuestType');
		$this->GuestType->GuestType_Val();
	}
	public function GuestType_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'GuestType');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//*********************************************************************\\
	public function GuestStatus($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'GuestStatus', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->GuestStatus($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function GuestStatus_Val()
	{
		$this->load->model('Master/GuestStatus');
		$this->GuestStatus->GuestStatus_Val();
	}
	public function GuestStatus_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'GuestStatus');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function Room($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Room', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Room($ID);
			$data = array_merge($data, $REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Room_Val()
	{
		$this->load->model('Master/Rooms');
		$this->Rooms->Room_Val();
	}
	public function Room_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Room');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function ReservationMode($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'ReservationMode', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->ReservationMode($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReservationMode_Val()
	{
		$this->load->model('Master/ReservationMode');
		$this->ReservationMode->ReservationMode_Val();
	}
	public function ReservationMode_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'ReservationMode');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function Department($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Department', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Department($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Department_Val()
	{
		$this->load->model('Master/Department');
		$this->Department->Department_Val();
	}
	public function Department_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Department');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function Designation($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Designation', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Designation($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Designation_Val()
	{
		$this->load->model('Master/Designation');
		$this->Designation->Designation_Val();
	}
	public function Designation_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Designation');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function GstType($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'GstType', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->GstType($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function GstType_Val()
	{
		$this->load->model('Master/GstType');
		$this->GstType->GstType_Val();
	}
	public function GstType_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'GstType');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function RatePlan($ID = -1, $BUT = 'SAVE')
	{

		$data = array('Keey' => rand() . rand() . rand() . rand(), 'F_Class' => 'Master', 'F_Ctrl' => 'RatePlan', 'ID' => $ID, 'BUT' => $BUT, 'FD' => date('d-m-Y'), 'TD' => date('d-m-Y'));
		if ($ID != -1) {
			$REC = $this->Myclass->RatePlan($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function RatePlan_Val()
	{
		$this->load->model('Master/RatePlan');
		$this->RatePlan->RatePlan_Val();
	}
	public function RatePlan_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'RatePlan');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	public function GetRatePlan()
	{
		$this->load->view('Master/GetRatePlan');
	}
	public function GetRatePlandelete($ID)
	{
		$this->load->view('Master/GetRatePlandelete', array('IDD' => $ID));
	}
	public function AllDell()
	{
		$this->db->query("delete Temp_RatePlan_Det where Keey='" . $_REQUEST['Keey'] . "'");
	}

	//###########################################
	public function TariffSetup($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'TariffSetup', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->TariffSetup($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function TariffSetup_Val()
	{
		// $this->load->model('Master/TariffSetup');
		// $this->TariffSetup->TariffSetup_Val();
		$rowcount = $_REQUEST['rowcount'];
		$j = 1;
		$qry = '';

		for ($i = 0; $i < $rowcount; $i++) {
			$check = "select * from Mas_Tariffsetup where Setup_id='" . $j . "'";
			$res = $this->db->query($check);
			$no = $res->num_rows();
			if ($no != 0) {
				$qry .= "UPDATE Mas_Tariffsetup
				SET 
			
					FromAmt = '" . $_POST['FAMT'][$i] . "',
					ToAmt = '" . $_POST['To'][$i] . "',
					CGST = '" . $_POST['CGST'][$i] . "',
					SGST = '" . $_POST['SGST'][$i] . "',
					Validatefrom = '" . date('Y-m-d', strtotime($_POST['dateFrom'][$i])) . "',
					Validateto= '" . date('Y-m-d', strtotime($_POST['dateto'][$i])) . "',
					CGSTNAME = '" . $_POST['CGSTname'][$i] . "',
					SGSTNAME = '" . $_POST['SGSTname'][$i] . "',
					gracehours='" . $_POST['gracehours'][$i] . "'
				  where  Setup_id ='" . $j . "'";
			} else {


				$count = "select count(*) from mas_tariffsetup";
				$count = $this->db->query($count);
				$count = $count->num_rows();
				$no = 1;
				$datefrom = date('Y/m/d', strtotime(str_replace('-"', '/', ($_POST['dateFrom'][$i]))));
				$dateto = date('Y-m-d', strtotime(str_replace('-"', '/', $_POST['dateto'][$i])));
				while ($no <= $count) {
					$check = "select convert(varchar, Validatefrom, 111) as fromdate,FromAmt,
					convert(varchar, Validateto, 111) as todate,ToAmt 
					from mas_tariffsetup where Setup_id='" . $no . "'";
					$res = $this->db->query($check);
					foreach ($res->result_array() as $row) {
						$fromdate = date('Y/m/d', strtotime(str_replace('-"', '/', ($row['fromdate']))));
						$todate = date('Y/m/d', strtotime(str_replace('-"', '/', ($row['todate']))));
						$FromAmt = $row['FromAmt'];
						$ToAmt = $row['ToAmt'];
					}

					if ($fromdate >= $datefrom && $todate >= $dateto) {
						if ($_POST['FAMT'][$i] == $FromAmt && $_POST['To'][$i] == $ToAmt) {
							echo "fail";
							return;
						}
					}
					$no++;
				}
				$qry .= "insert into Mas_Tariffsetup(FromAmt,ToAmt,CGST,SGST,Validatefrom,Validateto,CGSTNAME,SGSTNAME,gracehours)
				values(	'" . $_POST['FAMT'][$i] . "','" . $_POST['To'][$i] . "','" . $_POST['CGST'][$i] . "','" . $_POST['SGST'][$i] . "',
				'" . date('Y-m-d', strtotime($_POST['dateFrom'][$i])) . "','" . date('Y-m-d', strtotime($_POST['dateto'][$i])) . "',
				'" . $_POST['CGSTname'][$i] . "','" . $_POST['SGSTname'][$i] . "','" . $_POST['gracehours'][$i] . "')";
			}
			$j++;
		}
		$res = $this->db->query($qry);
		if ($res) {
			echo "success";
		} else {
			echo "failure";
		}
	}
	public function TariffSetup_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'TariffSetup');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//********************************************************************\\

	public function PlanType($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'PlanType', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->PlanType($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function PlanType_Val()
	{
		$this->load->model('Master/PlanType');
		$this->PlanType->PlanType_Val();
	}
	public function PlanType_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'PlanType');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//********************************************************************\\


	public function TaxSetup($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'TaxSetup', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function TaxSetup_Val()
	{
		$this->load->model('GetVal/TaxSetup');
		$this->TaxSetup->TaxSetup_Val();
	}
	//###########################################

	public function Bank($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Bank', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Bank($ID);
			$data = array_merge($data, $REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Bank_Val()
	{
		$this->load->model('Master/Bank');
		$this->Bank->Bank_Val();
	}
	public function Bank_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Bank');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################

	public function BedType($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'BedType', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->BedType($ID);
			$data = array_merge($data, $REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function BedType_Val()
	{
		$this->load->model('Master/BedType');
		$this->BedType->BedType_Val();
	}
	public function BedType_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'BedType');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}

	//###########################################
	public function RoomType($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'RoomType', 'IMGKEY' => rand() . rand() . rand() . rand(), 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->RoomType($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function RoomType_Val()
	{
		$this->load->model('Master/RoomType');
		$this->RoomType->RoomType_Val();
	}
	public function RoomType_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'RoomType');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function CompanyGroup($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'CompanyGroup', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->CompanyGroup($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function CompanyGroup_Val()
	{
		$this->load->model('Master/CompanyGroup');
		$this->CompanyGroup->CompanyGroup_Val();
	}
	public function CompanyGroup_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'CompanyGroup');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################

	public function CompanyType($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'CompanyType', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->CompanyType($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function CompanyType_Val()
	{
		$this->load->model('Master/CompanyType');
		$this->CompanyType->CompanyType_Val();
	}
	public function CompanyType_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'CompanyType');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}


	//*********************************************************************\\


	public function Company($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Company', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Company($ID);
			$data = array_merge($data, $REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Company_Val()
	{
		$this->load->model('Master/Company');
		$this->Company->Company_Val();
	}
	public function Company_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Company');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}


	//*********************************************************************\\
	public function PayMode($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'PayMode', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->PayMode($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function PayMode_Val()
	{
		$this->load->model('Master/PayMode');
		$this->PayMode->PayMode_Val();
	}
	public function PayMode_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'PayMode');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//*********************************************************************\\


	public function MarketSegment($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'MarketSegment', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->MarketSegment($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function MarketSegment_Val()
	{
		$this->load->model('Master/MarketSegment');
		$this->MarketSegment->MarketSegment_Val();
	}
	public function MarketSegment_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'MarketSegment');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//*********************************************************************\\


	public function BillingInstruction($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'BillingInstruction', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->BillingInstruction($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function BillingInstruction_Val()
	{
		$this->load->model('Master/BillingInstruction');
		$this->BillingInstruction->BillingInstruction_Val();
	}
	public function BillingInstruction_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'BillingInstruction');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function Revenue($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Revenue', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Revenue($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Revenue_Val()
	{
		$this->load->model('Master/Revenue');
		$this->Revenue->Revenue_Val();
	}
	public function Revenue_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Revenue');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}

	//###########################################
	public function RevenueGroup($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'RevenueGroup', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->RevenueGroup($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function RevenueGroup_Val()
	{
		$this->load->model('Master/RevenueGroup');
		$this->RevenueGroup->RevenueGroup_Val();
	}
	public function RevenueGroup_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'RevenueGroup');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//###########################################
	public function BillGroup($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'BillGroup', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->BillGroup($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function BillGroup_Val()
	{
		$this->load->model('Master/BillGroup');
		$this->BillGroup->BillGroup_Val();
	}
	public function BillGroup_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'BillGroup');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}

	//###########################################

	public function Block($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Block', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Block($ID);
			$data = array_merge($data, $REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Block_Val()
	{
		$this->load->model('Master/Block');
		$this->Block->Block_Val();
	}
	public function Block_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Block');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//*********************************************************************\\
	public function Floor($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Floor', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Floor($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Floor_Val()
	{
		$this->load->model('Master/Floor');
		$this->Floor->Floor_Val();
	}
	public function Floor_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Floor');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//*********************************************************************\\


	public function BusinessSource($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'BusinessSource', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->BusinessSource($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function BusinessSource_Val()
	{
		$this->load->model('Master/BusinessSource');
		$this->BusinessSource->BusinessSource_Val();
	}
	public function BusinessSource_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'BusinessSource');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//*********************************************************************\\

	public function FoodPlan($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'FoodPlan', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->FoodPlan($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function FoodPlan_Val()
	{
		$this->load->model('Master/FoodPlan');
		$this->FoodPlan->FoodPlan_Val();
	}
	public function FoodPlan_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'FoodPlan');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}




	//*********************************************************************\\
	public function Country($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Country', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Country($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Country_Val()
	{
		$this->load->model('Master/Country');
		$this->Country->Country_Val();
	}
	public function Country_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'Country');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}


	//*********************************************************************\\
	public function State($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'State', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->State($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function State_Val()
	{
		$this->load->model('Master/State');
		$this->State->State_Val();
	}
	public function State_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'State');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}

	//*********************************************************************\\
	public function City($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'City', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->City($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function City_Val()
	{
		$this->load->model('Master/City');
		$this->City->City_Val();
	}
	public function City_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'City');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//*********************************************************************\\
	public function Edit()
	{
		$this->load->view('Master/Edit/' . $_REQUEST['link']);
	}

	public function DayBook($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'DayBook', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Accname($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function DayBook_Val()
	{
		$this->load->model('Master/DayBook');
		$this->DayBook->DayBook_Val();
	}


	public function DayBook_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'DayBook');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}


	public function CashBook($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'CashBook', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC=$this->Myclass->Accname($ID);
			$data=array_merge($data,$REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}


	public function CashBook_Val()
	{
		$this->load->model('Master/CashBook');
		$this->CashBook->CashBook_Val();
	}

	


	public function CashBook_View()
	{
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'CashBook');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}

	public function CashBook_EntryDelete(){


		$sql = "delete from trans_cash_book where dailyid='".$_REQUEST['id']."'";
		$sql1 = "delete from trans_cash_bookdet where dailyid='".$_REQUEST['id']."'";
		$res= $this->db->query($sql,$sql1);
		if($res){
				
			echo "success";
		}else{
			echo "fail";
		}
	}

	public function HeadSelection()
	{
		$headSelection = $_REQUEST['Accid'];
		$sql = "select * from accname where Accid='" . $headSelection . "'";
		$exec = $this->db->query($sql);
		foreach ($exec->result_array() as $row) {
			echo $result = $row['creditordebit'];
		}
	}

	public function PricingSlab(){
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'PricingSlab');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function pricingslab_view(){
		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'PricingSlab_View');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}


	public function SlabEdit($psid){

		$data['psid'] = $psid;

		$data = array('F_Class' => 'Master', 'F_Ctrl' => 'PricingSlab_Edit' , 'psid' => $psid);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);

	

		
	}

	public function deleteslab(){
		 $id = $this->input->post("id");

		  $dltqry = "delete from pricingslab_det1 where psdetid1 ='".$id."'";

		  $exdlt = $this->db->query($dltqry);

		 if($exdlt){
			echo "success";
		 } 
		 else {
			echo "failed";
		 }


	}

	
}
