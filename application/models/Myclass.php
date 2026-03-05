<?php

class Myclass extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
    function SMSAPI($ID=0){
     
	  $qry=" exec  Get_SMSAPI ".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Emails($ID=0){
     
	  $qry=" exec  Get_SMTP ".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Facility($ID=0){
     
	  $qry=" exec  Get_Facility ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function RoomType($ID=0){
     
	  $qry=" exec  Get_RoomType ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function PayMode($ID=0){
     
	  $qry=" exec  Get_PayMode ".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	
	function Country($ID=0){
     
	  $qry=" exec  Get_Country ".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	
	function State($ID=0){
     
	  $qry=" exec  Get_State ".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function City($ID=0){
     
	  $qry=" exec  Get_City ".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	
	function Get_Advancereceiptno(){
     
	  $qry=" exec  Get_Advancereceiptno ";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }


	function Get_Advancereceipt($ID=0){     
	 	$qry="select ti.Title+'.'+cus.Firstname as Name,* from Trans_Receipt_mas 	 rec
		inner join mas_Customer cus on cus.Customer_Id=rec.customerid
		left outer join Mas_Title ti on ti.Titleid=cus.Titelid
		inner join Mas_Room rom on rom.Room_Id=rec.roomid
		inner join Mas_Paymode pm on pm.PayMode_Id=rec.paymodeid
		where ReceiptType='C' and Receiptid=".$ID;
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	}
	function Get_ReservationAdvanceRefund($ID=0)
	{
		$qry="select mas.Remarks,ti.Title+'.'+cus.Firstname as Name,* from trans_reservecancel_mas mas
		Inner join Trans_Reserve_mas rmas on rmas.Resid=mas.reserveid 
		inner join Mas_Customer cus on rmas.cusid=cus.Customer_Id
        inner join Mas_Title ti on ti.Titleid=cus.Titelid
		where mas.resid=".$ID;
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	}
	function Get_ReservationAdvances($ID=0){     
		$qry="select ti.Title+'.'+cus.Firstname as Name,FORMAT(totamt,'N') as Amount,* from Trans_reserveadd_mas mas
		inner join Trans_reserveadd_det det on mas.resaddid=det.resaddid
        inner join Mas_Customer cus on mas.cusid=cus.Customer_Id
        inner join Mas_Title ti on ti.Titleid=cus.Titelid
		where mas.resaddid=".$ID;
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	}
	function Get_Advancereceipts(){     
		$qry="select rom.RoomNo,rec.Receiptid, ti.Title+'.'+cus.Firstname as Name,rec.Amount,rec.Receiptno,rec.yearprefix,mb.bank,pm.PayMode  from Trans_Receipt_mas 	 rec
		inner join mas_Customer cus on cus.Customer_Id=rec.customerid
		inner join Mas_Title ti on ti.Titleid=cus.Titelid
		inner join Mas_Room rom on rom.Room_Id=rec.roomid
		inner join Mas_Paymode pm on pm.PayMode_Id=rec.paymodeid
		inner join Room_Status rs on rs.roomgrcid = rec.roomgrcid
		left outer join mas_bank mb on mb.Bankid = rec.bank
		where ReceiptType='C' and isnull(cancel,0)=0 and isnull(Status,'')='Y' and isnull(billsettle,0)=0 and rptdate between '".date('Y-m-d')."' and '".date('Y-m-d')."'";
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	}
	function SmsConfiguration($ID=0){   
		$qry="select * from mas_smsmessage where TemplateId=".$ID; 
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	}
	function Get_PostBills($ID=0){     
		$qry="select ti.Title+'.'+cus.Firstname as Name,* from Trans_Credit_Entry Ce
		inner join  Mas_revenue rev on rev.Revenue_Id=Ce.Creditheadid
		inner join Mas_Room rm on rm.Room_id=Ce.Roomid
		inner join Room_status rs on rs.grcid=Ce.Grcid
		inner join mas_Customer cus on cus.Customer_Id=Ce.Customerid
		inner join Mas_Title ti on ti.Titleid=cus.Titelid
		 where Isnull(IsAllowance,0)=0 and RevenueHead not in ('Advance','Discount','ROOM RENT','CGST','SGST') 
		 and isnull(Status,'')='Y' and isnull(billsettle,0)=0 and Ce.CreditDate ='".date('Y-m-d')."'";
		 if($ID)
		 {
			$qry=$qry."and Ce.Credid=".$ID; 
		 }
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	}
	function Get_Checkoutbill($ID=0){     
		   $qry="select * from Trans_checkout_mas rec
		inner join Trans_Checkin_mas mas on mas.Grcid=rec.Grcid
        inner join Trans_Pay_Det det on det.checkoutid=rec.checkoutid
		inner join mas_Customer cus on cus.Customer_Id=rec.customerid
		left outer join Mas_Title ti on ti.Titleid=cus.Titelid
		inner join Mas_Room rom on rom.Room_Id=rec.roomid
		inner join Mas_Paymode pm on pm.PayMode_Id=det.paymodeid
		left outer join Mas_City ct on ct.Cityid=cus.Cityid
		where rec.Checkoutid=".$ID;
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	}
	function Get_City($ID=0){
     
	  $qry=" exec  Get_City ".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Get_Checkoutno(){
     
	  $qry=" exec  Get_Checkoutno ";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Get_Resclno(){
     
	  $qry=" exec  Get_Resclno ";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Get_ResaddNo(){
     
	  $qry=" exec  Get_ResaddNo ";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Get_ResNo(){
     
	  $qry=" exec  Get_ResNo ";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Get_Credit_Entry_No(){
     
	  $qry=" exec  Get_Credit_Entry_No ";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Title($ID=0){
     
	  $qry=" exec  Get_Title ".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Bank($ID=0){     
		$qry=" exec  Get_Bank ".$ID;
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	  }

	  public function Bank_other(){
		$qry="select * from mas_bank where isnull(isvisible,0)='1' and isnull(isupi,0)='0'";
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;

	  }
	function Customer($ID=0){
     
	  $qry=" exec  Get_Customer ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function HotelProperty($ID=0){
     
	  $qry=" exec  Get_HotelDetails ".Hotel_Id;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function CompanyType($ID=0){
     
	  $qry=" exec  Get_CompanyType ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function MarketSegment($ID=0){
     
	  $qry=" exec  Get_MarketSegment ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function BusinessSource($ID=0){
     
	  $qry=" exec  Get_BusinessSource ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Get_NightAuditrooms(){
     
	  $qry=" exec  Get_NightAuditrooms";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Get_NightAuditdate(){
     
	  $qry="select * from Night_Audit";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	
	function GuestType($ID=0){
     
	  $qry=" exec  Get_GuestType ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function CompanyGroup($ID=0){
     
	  $qry=" exec  Get_CompanyGroup ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function GstType($ID=0){
     
	  $qry=" exec  Get_GstType ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function RevenueGroup($ID=0){
     
	  $qry=" exec  Get_RevenueGroup ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }

	function Accname($ID=0){
     
		$qry=" exec  Get_Accname ".$ID;
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	  }
	 

	  function Cashbook($ID=0){
     
		$qry = "EXEC Get_Cashbook '{$ID}', '" . date('Y-m-d') . "'";

		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	  }

	function BillGroup($ID=0){
     
	  $qry=" exec  Get_BillGroup ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Revenue($ID=0){
     
	  $qry=" exec  Get_Revenue ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Floor($ID=0){
     
	  $qry=" exec  Get_Floor ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Block($ID=0){
     
	  $qry=" exec  Get_Block ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function DataPurchaing($ID=0){
     
	  $qry=" exec  Get_Block ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function BedType($ID=0){
     
	  $qry=" exec  Get_BedType ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Room($ID=0){
     
	  $qry=" exec  Get_Room ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Room_Type($ID=0){
     
	  $qry=" exec  Get_Room_Type ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Room_Status($ID=0){
     
	  $qry=" exec  Get_Room_Status ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Company($ID=0){
     
	   $qry=" exec  Get_Company ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	
	function BillingInstruction($ID=0){
     
	  $qry=" exec  Get_BillingInstruction ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function GuestStatus($ID=0){
     
	  $qry=" exec  Get_GuestStatus ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function ReservationMode($ID=0){
     
	  $qry=" exec  Get_ReservationMode ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }

	function ResNoShow($ID=0){
     
	 	$qry="exec  Get_ResNoShow ".$ID;
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	}

	function cashBookReport($fromdate,$todate){
     
	   $qry="exec cashBookReport '".$fromdate."', '".$todate."'";
	   $res=$this->db->query($qry);
	   $Res= json_encode($res->result());
	   $Res=json_decode($Res,true);
	   return $Res;
   }

   function DayOpeningCash($date){
     
	$qry="exec DayOpeningCash '".$date."'";
	$res=$this->db->query($qry);
	$Res= json_encode($res->result());
	$Res=json_decode($Res,true);
	return $Res;
}


	function Get_Reservations($fdate,$ddate,$ID=0){
     
	  $qry="exec Get_Reservations ".$ID.",'".$fdate."','".$ddate."'";
	   $res=$this->db->query($qry);
	   $Res= json_encode($res->result());
	   $Res=json_decode($Res,true);
	   return $Res;
   }
   function Get_Reservation($ID=0){
     
	$qry="exec Get_Reservation ".$ID;
	 $res=$this->db->query($qry);
	 $Res= json_encode($res->result());
	 $Res=json_decode($Res,true);
	 return $Res;
 }
	function PlanType($ID=0){
     
	  $qry=" exec  Get_PlanType ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function FoodPlan($ID=0){
     
	  $qry=" exec  Get_FoodPlan ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
    function Department($ID=0){
     
	  $qry=" exec  Get_Department ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Designation($ID=0){
     
	  $qry=" exec  Get_Designation ".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function UserGroup($ID=0){
     
	  $qry=" exec  Get_UserGroup ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function User($ID=0){
     
		$qry=" exec Get_Users ".Hotel_Id.",".$ID;
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	  }

	  function Smsuser($ID=0){
     
		$qry=" exec Get_smsuser ".$ID;
		$res=$this->db->query($qry);
		$Res= json_encode($res->result());
		$Res=json_decode($Res,true);
		return $Res;
	  }

    function Get_Vacant_Room(){
     
	  $qry=" exec Get_Vacant_Room ".Hotel_Id ;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    } 
	function Get_CGST($roomgrcid,$guestcharges,$Discamt,$date){
     
	  $qry="select dbo.Get_CGST_new ('".$roomgrcid."','".$guestcharges."','".$Discamt."','".$date."') as CGST";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Get_SGST($roomgrcid,$guestcharges,$Discamt,$date){
     
	  $qry=" select dbo.Get_SGST_new ('".$roomgrcid."','".$guestcharges."','".$Discamt."','".$date."') as SGST";
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function RatePlan($ID=0){
     
	  $qry=" exec  Get_RatePlan ".Hotel_Id.",".$ID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Booking($ID=0,$CID=0){
     
	  $qry=" exec  Get_Booking ".Hotel_Id.",".$ID.",".$CID;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Get_Position($date){
		$qry="exec Get_Position '".$date."'";
		$res=$this->db->query($qry);
		return $res;
	}
	function Get_BlockedCount($date){
		$qry="exec Get_BlockedCount '".$date."'";
		$res=$this->db->query($qry);
		return $res;
	}
	function Get_Occpancy($date){
		$qry="exec Get_Occpancy '".$date."'";
		$res=$this->db->query($qry);
		return $res;
	}
	function Hotel_Details(){
     
	  $qry=" exec  Get_HotelDetails ".Hotel_Id ;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
	function Donate_Das(){
     
	  $qry=" exec  Get_Donate_DAS " ;
	  $res=$this->db->query($qry);
	  $Res= json_encode($res->result());
	  $Res=json_decode($Res,true);
	  return $Res;
    }
		
  function DateSplit($dat)
{
	$dat=str_replace('/','-',$dat); 
	$Odate = explode(' ', $dat);
	$date = explode('-',$Odate[0]);
	$month = $date[1];
	$day   = $date[0];
	$year  = $date[2];
	return $month."-".$day."-".$year;
}
function GetRec($msg, $res, $qry)
{
    $output = array();
    $output['Qry'] = $qry;
    if (!empty($msg['message'])) 
    {
        $output['Success'] = false;
        $output['MSG'] = $this->ErrMessage($msg['message']);
        echo json_encode($output);
    }
    else
    {
        $res = $res->row(); 
        $output['Success'] = true;
        $output['MSG'] = $res->MGS; 
        echo json_encode($output); 
    }
}
  
  function ErrMessage($Msg)
  {
	  $M=$Msg;
	  if (strpos($Msg, 'UNIQUE KEY') !== false)
	  {
		 $A= explode("'",$Msg);
		 $M= @$A[1].@$A[4];
	  }
	  
	  return $M;
  }
  function HotelDetails($ID=0){
     
	$qry="select Company,StartDate,EndDate from Mas_Hotel where Hotel_Id=1";	
	$res=$this->db->query($qry);
	$Res= json_encode($res->result());
	$Res=json_decode($Res,true);
	return $Res;
  }

//   function idproof(){
// 		$qry="select * from mas_idproof";	
// 	$res=$this->db->query($qry);
// 	$Res= json_encode($res->result());
// 	$Res=json_decode($Res,true);
// 	return $Res;
//   }
	   
}