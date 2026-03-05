<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

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
		
         define('ActMenu','Report');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }

	 
    public function Receipt()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'Receipt');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
		
	}
	public function Consolidate()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'Consolidate');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function RoomCurrentTariff()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'RoomCurrentTariff');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function CashierReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'CashierReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function HighBalanceReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'HighBalanceReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function BillEntryDetails()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'BillEntryDetails');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function GstReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'GstReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function Reservation_Log()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'Reservation_Log');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
    public function ReservationDetails()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'ReservationDetails');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function RoomAvaliability()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'RoomAvaliability');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function RoomAvaliabilityMonthwise()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'RoomAvaliabilityMonthwise');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function OutstandingReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'OutstandingReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function Outstanding()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'Outstanding');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function PendingcollectionReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'PendingcollectionReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function CashBookReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'CashBookReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function ArrivalReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'ArrivalReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function DepartureReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'DepartureReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function ReinReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'ReinReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function reinstatenoshowreport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'reinstatenoshowreport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	
	public function outstandingdetailedreport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'outstandingdetailedreport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	
	public function CheckoutCancellation()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'CheckoutCancellation');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function ReSettlement()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'ReSettlement');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function ManagerReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'ManagerReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function mblock()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'mblock');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function Foblock()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'Foblock');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	
	public function OccupancyList()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'OccupancyList');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function GuestArrivalRegister()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'GuestArrivalRegister');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function GuestDepatureRegister()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'GuestDepatureRegister');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function GuestCheckinDetails()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'GuestCheckinDetails');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function OccupancyAnalysis()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'OccupancyAnalysis');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function DiscountReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'DiscountReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function ReservationAdvance()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'ReservationAdvance');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function settlementwise()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'settlementwise');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	
	public function RoomHistory()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'RoomHistory');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}
	public function PoliceReport()
	{
		$data=array('F_Class'=>'Report','F_Ctrl'=>'PoliceReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}

	public function dailycollection(){
			$data=array('F_Class'=>'Report','F_Ctrl'=>'DailyCollectionReport');
	    $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
	}


	public function Otabookingsreport(){
		$data=array('F_Class'=>'Report','F_Ctrl'=>'Otabookingsreport');
	$this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
}

public function ReservationCancel(){
	$data=array('F_Class'=>'Report','F_Ctrl'=>'ReservationCancel');
	$this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
}

public function daywisesettlement(){
	$data=array('F_Class'=>'Report','F_Ctrl'=>'daywisesettlement');
	$this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
}
	

	
}