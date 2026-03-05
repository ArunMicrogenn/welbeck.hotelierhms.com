<?php

class Collection extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function Collection_Val()
	{
		 
		 $this->form_validation->set_rules('totalamount', 'totalamount', 'required');
		//$this->form_validation->set_rules('paymode', 'paymode', 'required');
		 /*if($this->input->post('paymode') !='1')
		 {
			$this->form_validation->set_rules('cardnumber', 'cardnumber', 'required');
			$this->form_validation->set_rules('bank', 'bank', 'required');
			$this->form_validation->set_rules('validate', 'validate', 'required');
		 } */
		 if($this->form_validation->run() == FALSE)
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
	function Collection_exec()
	{
       $date= date('Y-m-d');
       $ins="";$ins1="";$ins3=""; $ims4="";
		if($_REQUEST['BUT'] =='SAVE')
		{   

            $ins=$ins."insert into Trans_BillPay_Mas (Creditno,Creditdate,
                      SettleorCollection,ReciptNo,Customerid,userid,iselite,Updatetrans,yearprefix)
					  values(dbo.ColNO(),'".$date."','C',dbo.ColNO(),'".$_REQUEST['Companyid']."','".User_id."','0','1',dbo.YearPrefix())";
			for($i=0; $i<$_REQUEST['counts']; $i++)
			{				
				//	echo $_REQUEST['cardno'][1];

				if(@$_REQUEST['Amtt'][$i])
				{
                    $ins1 =$ins1. "insert into Trans_Billpay_det(Paymodeid,Bankid,Amount,
                    Cardname,Creditid, Updatetrans, Validdate)values( 
                    '".$_REQUEST['paymode'][$i]."','".$_REQUEST['bank'][$i]."', '".$_REQUEST['Amtt'][$i]."',
                    '".$_REQUEST['cardno'][$i]."',@Siden, '1' ,'".$_REQUEST['validate'][$i]."')";
				}
			}
            for($i=0; $i<$_REQUEST['countrow']; $i++){

              $bal = $_REQUEST['Billamount'][$i] -$_REQUEST['Amt'][$i];
              $paid= $_REQUEST['Paidamount'][$i]+$_REQUEST['Amt'][$i];
              $ins3 =$ins3."insert into Trans_Bill_Det(Checkoutid, Creditid, Billno, 
                       Billdate, Billamount,Balamount,Paidamount)values('".$_REQUEST['checkoutid'][$i]."',@Siden,
                       '".$_REQUEST['Billno'][$i]."','".$_REQUEST['checkoutdate'][$i]."',
                       '".$_REQUEST['Billamount'][$i]."','".$bal."','".$_REQUEST['Amt'][$i]."')";

            $ims4 = $ims4."update  trans_pay_det set paidamount='".$paid."' where 
            Checkoutid='".$_REQUEST['checkoutid'][$i]."'";
            }
              
            echo "BEGIN Try ";
            echo "BEGIN Transaction ";
            echo "BEGIN Tran ";
            echo "Declare @Siden INT; ";
            echo $ins;
            echo "set @Siden=@@identity; ";
            echo $ins1;				
            echo $ins3;
            echo $ims4;
            echo " If @@error<>0 Rollback Tran else Commit Tran ";
            echo "COMMIT ";
            echo "end try ";
            echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
            echo "END CATCH ";
            $sqc = ob_get_clean();
            $sq = "".$sqc."";	  
            $result = $this->db->query($sq);
            $this->db->close();
            $this->db->reconnect();	
            // echo "Sucess";

			$output = array();
			$output['Success']=true;
			$output['MSG']="Checkout Settlement Successfully";		 
			print_r(json_encode($output));
		}
	
	}
}
?>