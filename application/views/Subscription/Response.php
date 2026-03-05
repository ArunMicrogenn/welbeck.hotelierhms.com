<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Subscription','Response');
$this->pfrm->FrmHead4('Subscription / Response',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
require_once "config.php";
if(!empty($_POST)){
    $checksum = (!empty($_POST['CHECKSUMHASH'])) ? $_POST['CHECKSUMHASH'] : '';
    unset($_POST['CHECKSUMHASH']);
    $verifySignature = PaytmChecksum::verifySignature($_POST, PAYTM_MERCHANT_KEY, $checksum);
    if($verifySignature){
        if($_POST['STATUS']=='PENDING' || $_POST['STATUS']=='TXN_FAILURE')
        {
            $mqryk="insert into paytmpaymentgateway_det(BANKNAME,BANKTXNID,CURRENCY,MID,ORDERID,PAYMENTMODE,RESPCODE,RESPMSG,STATUS,TXNAMOUNT,TXNDATE,TXNID,updatedatetime)
            values('".@$_POST['BANKNAME']."','".$_POST['BANKTXNID']."','".$_POST['CURRENCY']."','".$_POST['MID']."','".$_POST['ORDERID']."','".$_POST['PAYMENTMODE']."','".$_POST['RESPCODE']."','".$_POST['RESPMSG']."','".$_POST['STATUS']."','".$_POST['TXNAMOUNT']."','".$_POST['TXNDATE']."','".$_POST['TXNID']."',convert(VARCHAR,getdate(),108))";
        }
        if($_POST['STATUS']=='TXN_SUCCESS')
        {
            $mqryk="insert into paytmpaymentgateway_det(Refno,BANKNAME,BANKTXNID,CURRENCY,MID,ORDERID,PAYMENTMODE,RESPCODE,RESPMSG,STATUS,TXNAMOUNT,TXNDATE,TXNID,updatedatetime,GATEWAYNAME,MERC_UNQ_REF)
            values('".$_POST['ORDERID']."','".@$_POST['BANKNAME']."','".$_POST['BANKTXNID']."','".$_POST['CURRENCY']."','".$_POST['MID']."','".$_POST['ORDERID']."','".$_POST['PAYMENTMODE']."','".$_POST['RESPCODE']."','".$_POST['RESPMSG']."','".$_POST['STATUS']."','".$_POST['TXNAMOUNT']."','".$_POST['TXNDATE']."','".$_POST['TXNID']."',convert(VARCHAR,getdate(),108),'".$_POST['GATEWAYNAME']."','".@$_POST['MERC_UNQ_REF']."')";
        
            $sql="select * from mas_Hotel where Hotel_id=1";
            $exe = $this->db->query($sql);
            foreach($exe -> result_array() as $row){
               $Company=$row['Company'];
               $Gstinn=$row['Gstinn'];
               $Email=$row['Email'];
               $City=$row['City'];
               $StartDate=$row['StartDate'];
               $EndDate=substr($row['EndDate'],0,10);
            }
            $numberofdays=10;
           $date_now = date("Y-m-d"); // this format is string comparable
    
            if ($date_now <= $EndDate) {     
                $aa_date =date_create(date('Y-m-d')); // convert the date to string
                $l_date=date_create($EndDate);
                $diff=date_diff($aa_date ,$l_date );
                $difference = $diff->format("%a");
                $numberofdays=$difference+$numberofdays;            
                $NewEndDate= date('Y-m-d', strtotime($EndDate. ' + '.$numberofdays.' days'));
            }else{
                $NewEndDate= date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$numberofdays.' days'));
            }       
            $update="update mas_Hotel set Enddate='".$NewEndDate."' where Hotel_Id=1";       
        }
        $result = $this->db->query($update,$mqryk); 
        ?>
        <div class="col-sm-12">
            <div class="the-box F_ram">
                <fieldset>
                    <table class="FrmTable T-4" >
                        <tr>
                            <td align="left" class="F_val">Payment Status :</td>
                            <td align="left"><?php echo $_POST['STATUS']; ?></td>
                        </tr>
                        <tr>
                            <td align="left" class="F_val">Transaction Amount :</td>
                            <td align="left"><?php echo $_POST['TXNAMOUNT']; ?></td>
                        </tr>
                        <tr>
                            <td align="left" class="F_val">Transaction Msg :</td>
                            <td align="left"><?php echo $_POST['RESPMSG']; ?></td>
                        </tr>
                        <tr>
                            <td align="left" class="F_val">Transaction ID :</td>
                            <td align="left"><?php echo $_POST['BANKTXNID']; ?></td>
                        </tr>
                        <tr>
                            <td align="left" class="F_val">Payment Mode :</td>
                            <td align="left"><?php echo $_POST['PAYMENTMODE']; ?></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
        </div>
        <?php
    }
    else {?>
        <h3 class="text-danger">Checksum is not verified.</h3>	
    <?php } ?>


<?php
}
else
{ {?>
    <h3 class="text-danger">Empty POST Response</h3>
<?php } 
}
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>