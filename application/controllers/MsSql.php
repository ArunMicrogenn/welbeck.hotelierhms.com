<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MsSql extends CI_Controller {

	public function index()
	{
		
		$ver=1;
		if("Master/Customer"==$_REQUEST['Mname'])
		{
			$this->load->model("Master/Customers");
			$ver=2;
		}
		if("Customer/TaxSetup"==$_REQUEST['Mname'])
		{
			$this->load->model("GetVal/TaxSetup");
			$ver=2;
		}
		if("Master/Room"==$_REQUEST['Mname'])
		{
			$this->load->model("Master/Rooms");
			$ver=2;
		}
		if($ver==1){
		     $this->load->model($_REQUEST['Mname']);
		}
		switch($_REQUEST['Mname'])
		{

			case"Setting/sms":
		    $this->sms->sms_exec();
			break;
			case"Setting/emails":
		    $this->emails->emails_exec();
			break;
						 
			case"Master/Floor":
		    $this->Floor->Floor_exec();
			break; 
			 
			case"Master/Facility":
		    $this->Facility->Facility_exec();
			break;
			
			case"Master/RoomType":
		    $this->RoomType->RoomType_exec();
			break;

			case"Master/Block":
		    $this->Block->Block_exec();
			break;
			case"Master/BedType":
		    $this->BedType->BedType_exec();
			break;

			case"Master/Bank":
			$this->Bank->Bank_exec();
			break;
			
			case"Master/Room":
		    $this->Rooms->Room_exec();
			break;
			
			case"Master/PayMode":
		    $this->PayMode->PayMode_exec();
			break;
			
			case"Master/State":
		    $this->State->State_exec();
			break;
			
			case"Master/City":
		    $this->City->City_exec();
			break;
			
			case"Master/Country":
		    $this->Country->Country_exec();
			break;
			
			case"Master/Customer":
		    $this->Customers->Customer_exec();
			break;
			case"Master/CompanyType":
		    $this->CompanyType->CompanyType_exec();
			break;
			case"Master/MarketSegment":
		    $this->MarketSegment->MarketSegment_exec();
			break;
			case"Master/BusinessSource":
		    $this->BusinessSource->BusinessSource_exec();
			break;
			case"Master/GuestType":
		    $this->GuestType->GuestType_exec();
			break;
			case"Master/BillingInstruction":
		    $this->BillingInstruction->BillingInstruction_exec();
			break;
			case"Master/GuestStatus":
		    $this->GuestStatus->GuestStatus_exec();
			break;
			case"Master/ReservationMode":
		    $this->ReservationMode->ReservationMode_exec();
			break;
			case"Master/CompanyGroup":
		    $this->CompanyGroup->CompanyGroup_exec();
			break;
			case"Master/GstType":
		    $this->GstType->GstType_exec();
			break;
			case"Master/Company":
		    $this->Company->Company_exec();
			break;
			case"Master/RevenueGroup":
		    $this->RevenueGroup->RevenueGroup_exec();
			break;
			case"Master/BillGroup":
		    $this->BillGroup->BillGroup_exec();
			break;
			
			case"Master/Revenue":
		    $this->Revenue->Revenue_exec();
			break;
			
			case"Customer/TaxSetup":
			
		    $this->TaxSetup->TaxSetup_exec();
			break;
			
			case"Master/PlanType":
		    $this->PlanType->PlanType_exec();
			break;
			
			case"Master/FoodPlan":
		    $this->FoodPlan->FoodPlan_exec();
			break;
			
			case"Master/Department":
		    $this->Department->Department_exec();
			break;
			
			case"Master/TariffSetup":
		    $this->TariffSetup->TariffSetup_exec();
			break;
			
			case"Master/Designation":
		    $this->Designation->Designation_exec();
			break;
			
			case"Master/RatePlan":
		    $this->RatePlan->RatePlan_exec();
			break;
			
			case"Setting/UserGroup":
		    $this->UserGroup->UserGroup_exec();
			break;	
			
			case"Setting/User":
			$this->User->User_exec();
			break;

			case"Transaction/DateChange":
		    $this->DateChange->DateChange_exec();
			break;
			
			case"Transaction/NightAuditReversal":
		    $this->NightAuditReversal->NightAuditReversal_exec();
			break;
			
			case"Transaction/PostRent":
		    $this->PostRent->PostRent_exec();
			break;
			
			case"Transaction/Changegueststay":
		    $this->Changegueststay->Changegueststay_exec();
			break;
			
			case"Transaction/RoomStatusChange":
		    $this->RoomStatusChange->RoomStatusChange_exec();
			break;
			
			case"Transaction/Reservation":
		    $this->Reservation->Reservation_exec();
			break;

			case"Transaction/ReinstateNoShows":
			$this->ReinstateNoShows->ReinstateNoShows_exec();
			break;

			case"Transaction/RoomBlockRelease":
			$this->RoomBlockRelease->RoomBlockRelease_exec();
			break;

			case"Transaction/AdvanceResettlement":
			$this->AdvanceResettlement->AdvanceResettlement_exec();
			break;

			case"Transaction/CheckoutResettlement":
			$this->CheckoutResettlement->CheckoutResettlement_exec();
			break;

			case"Transaction/Advance":
			$this->Advance->Advance_exec();
			break;

			case"Transaction/ReservationAdvances":
			$this->ReservationAdvances->ReservationAdvances_exec();
			break;

			case"Transaction/ReservationAdvanceRefund":
			$this->ReservationAdvanceRefund->ReservationAdvanceRefund_exec();
			break;

			case"Transaction/PostBill":
			$this->PostBill->PostBill_exec();
			break;

			case"Master/DayBook":
			
			$this->DayBook->DayBook_Exec();
			break;

			case"Transaction/CashBook":
			
				$this->CashBook->CashBook_Exec();
				break;

			case"Setting/ChangePassword":
				$this->ChangePassword->ChangePassword_exec();
				break;
			case"Setting/DataPurchaing":
		    $this->DataPurchaing->DataPurchaing_exec();
			break;
			case"Transaction/Collection":
			$this->Collection->Collection_exec();
			break;
			case"Configurations/SmsConfiguration":
			$this->SmsConfiguration->SmsConfiguration_exec();
			break;

			case"Configurations/SmsUsers":
			$this->SmsUsers->SmsUsers_exec();
			break;

			case"Setting/HotelProperty":
		    $this->HotelProperty->HotelProperty_exec();
			break;

			
		}
		 
	}
	

	 
}
